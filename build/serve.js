/* KOI taslak - basit statik sunucu (yalnizca yerel onizleme icin) */
const http = require("http");
const fs = require("fs");
const path = require("path");

const ROOT = path.join(__dirname, "..", "site");
const PORT = process.env.PORT || 5173;
/* Yalnizca bu bilgisayardan erisilebilir; ag uzerindeki diger cihazlar baglanamaz */
const HOST = "127.0.0.1";
/* Gorsel kaydetme araci varsayilan olarak KAPALI: KOI_ARAC=1 ile acilir */
const ARAC_ACIK = process.env.KOI_ARAC === "1";
const ARAC_MAX_BAYT = 10 * 1024 * 1024;

/* Canli ortamla ayni guvenlik basliklari: netlify.toml'dan okunur */
const TOML = fs.readFileSync(path.join(__dirname, "..", "netlify.toml"), "utf8");
const CSP = (TOML.match(/Content-Security-Policy = "([^"]+)"/) || [])[1] || "";

const TYPES = {
  ".html": "text/html; charset=utf-8",
  ".css": "text/css; charset=utf-8",
  ".js": "text/javascript; charset=utf-8",
  ".svg": "image/svg+xml",
  ".png": "image/png",
  ".jpg": "image/jpeg",
  ".jpeg": "image/jpeg",
  ".webp": "image/webp",
  ".ico": "image/x-icon",
  ".xml": "application/xml; charset=utf-8",
  ".txt": "text/plain; charset=utf-8",
};

function json(res, kod, veri) {
  res.writeHead(kod, { "Content-Type": "application/json" });
  res.end(JSON.stringify(veri));
}

http
  .createServer((req, res) => {
    /* Yerel yardimci: tarayicida islenen gorseli diske kaydeder.
       Siteye dahil degildir, Netlify'da calismaz. */
    if (req.url === "/__save") {
      if (!ARAC_ACIK) return json(res, 404, { ok: false, error: "arac kapali (KOI_ARAC=1)" });
      if (req.method !== "POST") return json(res, 405, { ok: false });
      /* CSRF korumasi: baska bir site tarayici uzerinden istek atamasin.
         application/json zorunlulugu capraz kaynakli isteklerde on-kontrol
         (preflight) gerektirir; sunucu buna izin vermedigi icin istek engellenir. */
      const kaynak = req.headers.origin || "";
      if (kaynak && !/^http:\/\/(localhost|127\.0\.0\.1):\d+$/.test(kaynak))
        return json(res, 403, { ok: false, error: "izinsiz kaynak" });
      if (!/^application\/json/.test(req.headers["content-type"] || ""))
        return json(res, 415, { ok: false, error: "application/json gerekli" });

      let boyut = 0;
      const parcalar = [];
      req.on("data", (c) => {
        boyut += c.length;
        if (boyut > ARAC_MAX_BAYT) {
          json(res, 413, { ok: false, error: "dosya cok buyuk" });
          req.destroy();
          return;
        }
        parcalar.push(c);
      });
      req.on("end", () => {
        if (res.writableEnded) return;
        try {
          const { name, dataUrl } = JSON.parse(Buffer.concat(parcalar).toString("utf8"));
          if (!/^[a-z0-9_-]+\.(png|jpg|jpeg|webp)$/i.test(name)) throw new Error("gecersiz dosya adi");
          const m = /^data:image\/(png|jpeg|webp);base64,([A-Za-z0-9+/=]+)$/.exec(dataUrl || "");
          if (!m) throw new Error("gecersiz gorsel verisi");
          fs.writeFileSync(path.join(ROOT, "assets", "img", name), Buffer.from(m[2], "base64"));
          json(res, 200, { ok: true, name });
        } catch (e) {
          json(res, 400, { ok: false, error: e.message });
        }
      });
      return;
    }

    let urlPath;
    try {
      urlPath = decodeURIComponent(req.url.split("?")[0]);
    } catch (e) {
      /* Bozuk yuzde kodlamasi sunucuyu cokertmesin */
      res.writeHead(400).end("Bad Request");
      return;
    }
    if (urlPath === "/") urlPath = "/index.html";
    const filePath = path.join(ROOT, urlPath);
    /* site/ disina cikmayi engelle (site-yedek gibi komsu klasorler dahil) */
    if (filePath !== ROOT && !filePath.startsWith(ROOT + path.sep)) {
      res.writeHead(403).end("Forbidden");
      return;
    }
    fs.readFile(filePath, (err, data) => {
      if (err) {
        res.writeHead(404, { "Content-Type": "text/html; charset=utf-8" });
        res.end("<h1>404</h1>");
        return;
      }
      res.writeHead(200, {
        "Content-Type": TYPES[path.extname(filePath).toLowerCase()] || "application/octet-stream",
        "Cache-Control": "no-store",
        "X-Content-Type-Options": "nosniff",
        ...(CSP ? { "Content-Security-Policy": CSP.replace(" upgrade-insecure-requests", "").replace(/;$/, "") } : {}),
      });
      res.end(data);
    });
  })
  .listen(PORT, HOST, () =>
    console.log("KOI taslak: http://localhost:" + PORT + (ARAC_ACIK ? "  (gorsel araci ACIK)" : ""))
  );
