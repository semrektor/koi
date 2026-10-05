/**
 * wordpress/koi klasorunu WordPress'e yuklenebilir zip dosyasina cevirir.
 *   wordpress/koi/  ->  belgeler/koi-tema.zip
 *
 * Kullanim:
 *   node build/wp-paket.js          zip uretir
 *   node build/wp-paket.js --sun    zip uretir ve 127.0.0.1:5174 uzerinden sunar
 *                                   (WordPress Playground ile deneme icin)
 */
const fs = require("fs");
const path = require("path");
const zlib = require("zlib");

const KOK = path.join(__dirname, "..");
const TEMA = path.join(KOK, "wordpress", "koi");
const ZIP = path.join(KOK, "belgeler", "koi-tema.zip");

function dosyalar(d, onek, liste = []) {
  for (const f of fs.readdirSync(d, { withFileTypes: true }).sort((a, b) => a.name.localeCompare(b.name))) {
    const tam = path.join(d, f.name);
    const ad = onek + "/" + f.name; // zip icinde her zaman duz bolu
    if (f.isDirectory()) dosyalar(tam, ad, liste);
    else liste.push([ad, tam]);
  }
  return liste;
}

function zipOlustur() {
  const parcalar = [];
  const merkez = [];
  let konum = 0;
  /* Sabit tarih: ayni icerik ayni zip'i uretsin */
  const zaman = 0;
  const tarih = ((2026 - 1980) << 9) | (1 << 5) | 1;

  for (const [ad, tam] of dosyalar(TEMA, "koi")) {
    const veri = fs.readFileSync(tam);
    const adBuf = Buffer.from(ad, "utf8");
    const sikisik = zlib.deflateRawSync(veri, { level: 9 });
    const depola = sikisik.length >= veri.length;
    const govde = depola ? veri : sikisik;
    const crc = zlib.crc32(veri);

    const yerel = Buffer.alloc(30);
    yerel.writeUInt32LE(0x04034b50, 0);
    yerel.writeUInt16LE(20, 4);
    yerel.writeUInt16LE(0x0800, 6); // UTF-8 dosya adi
    yerel.writeUInt16LE(depola ? 0 : 8, 8);
    yerel.writeUInt16LE(zaman, 10);
    yerel.writeUInt16LE(tarih, 12);
    yerel.writeUInt32LE(crc, 14);
    yerel.writeUInt32LE(govde.length, 18);
    yerel.writeUInt32LE(veri.length, 22);
    yerel.writeUInt16LE(adBuf.length, 26);
    parcalar.push(yerel, adBuf, govde);

    const kayit = Buffer.alloc(46);
    kayit.writeUInt32LE(0x02014b50, 0);
    kayit.writeUInt16LE(20, 4);
    kayit.writeUInt16LE(20, 6);
    kayit.writeUInt16LE(0x0800, 8);
    kayit.writeUInt16LE(depola ? 0 : 8, 10);
    kayit.writeUInt16LE(zaman, 12);
    kayit.writeUInt16LE(tarih, 14);
    kayit.writeUInt32LE(crc, 16);
    kayit.writeUInt32LE(govde.length, 20);
    kayit.writeUInt32LE(veri.length, 24);
    kayit.writeUInt16LE(adBuf.length, 28);
    kayit.writeUInt32LE(konum, 42);
    merkez.push(kayit, adBuf);

    konum += yerel.length + adBuf.length + govde.length;
  }

  const merkezBuf = Buffer.concat(merkez);
  const son = Buffer.alloc(22);
  son.writeUInt32LE(0x06054b50, 0);
  son.writeUInt16LE(merkez.length / 2, 8);
  son.writeUInt16LE(merkez.length / 2, 10);
  son.writeUInt32LE(merkezBuf.length, 12);
  son.writeUInt32LE(konum, 16);

  fs.mkdirSync(path.dirname(ZIP), { recursive: true });
  fs.writeFileSync(ZIP, Buffer.concat([...parcalar, merkezBuf, son]));
  console.log("belgeler/koi-tema.zip: " + merkez.length / 2 + " dosya, " + Math.round(fs.statSync(ZIP).size / 1024) + " KB");
}

if (!fs.existsSync(TEMA)) {
  console.error("wordpress/koi yok. Once: node build/wp-tema.js");
  process.exit(1);
}
zipOlustur();

if (process.argv.includes("--sun")) {
  /* Yalnizca bu bilgisayardan erisilir; tek dosya sunar. CORS basliklari
     tarayicida calisan WordPress Playground'un zip'i alabilmesi icindir. */
  require("http")
    .createServer((req, res) => {
      const baslik = {
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Private-Network": "true",
        "Cache-Control": "no-store",
      };
      if (req.method === "OPTIONS") {
        res.writeHead(204, baslik);
        return res.end();
      }
      if (req.method !== "GET" || req.url.split("?")[0] !== "/koi-tema.zip") {
        res.writeHead(404, baslik);
        return res.end();
      }
      zipOlustur(); // her istekte guncel tema
      res.writeHead(200, { ...baslik, "Content-Type": "application/zip" });
      res.end(fs.readFileSync(ZIP));
    })
    .listen(5174, "127.0.0.1", () => console.log("Tema zip: http://127.0.0.1:5174/koi-tema.zip"));
}
