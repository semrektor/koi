/**
 * Canva'dan yuksek cozunurluklu gorselleri indirir (site/assets/img/).
 * Export baglantilari sureli oldugu icin, sure dolarsa Canva'dan
 * yeniden export alinip bu listedeki URL'ler guncellenmelidir.
 *
 * Kullanim: node build/download-images.js
 */
const https = require("https");
const fs = require("fs");
const path = require("path");

const OUT = path.join(__dirname, "..", "site", "assets", "img");

const urls = {
  karsilama:
    "https://export-download.canva.com/HOXP4/DAHV7kHOXP4/-1/0/0001-65818887833904536.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAQYCGKMUH5AO7UJ26%2F20260921%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260921T170518Z&X-Amz-Expires=83049&X-Amz-Signature=6cf9d226890c212c3f88aac114bbde1f6b1fef34f9b133d286630ae0325e4148&X-Amz-SignedHeaders=host%3Bx-amz-expected-bucket-owner&response-expires=Tue%2C%2022%20Sep%202026%2016%3A09%3A27%20GMT",
  "hero-kemer":
    "https://export-download.canva.com/Kb8YA/DAHV7tKb8YA/-1/0/0001-65818889152829555.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAQYCGKMUH5AO7UJ26%2F20260921%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260921T171625Z&X-Amz-Expires=81956&X-Amz-Signature=5286291437799ce04a64b56955733adfab64f275561026c7ddad657b06ed1075&X-Amz-SignedHeaders=host%3Bx-amz-expected-bucket-owner&response-expires=Tue%2C%2022%20Sep%202026%2016%3A02%3A21%20GMT",
  "oyun-odasi":
    "https://export-download.canva.com/g_WS0/DAHV7gg_WS0/-1/0/0001-483527755056840466.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAQYCGKMUH5AO7UJ26%2F20260922%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260922T110353Z&X-Amz-Expires=20022&X-Amz-Signature=0066697e9cddffbd60fdb45c4a88cb82ecfbfee08560edbca798996a7ac52540&X-Amz-SignedHeaders=host%3Bx-amz-expected-bucket-owner&response-expires=Tue%2C%2022%20Sep%202026%2016%3A37%3A35%20GMT",
  danismanlik:
    "https://export-download.canva.com/O0tDk/DAHV7jO0tDk/-1/0/0001-6183958981917021334.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAQYCGKMUH5AO7UJ26%2F20260922%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260922T095150Z&X-Amz-Expires=21850&X-Amz-Signature=50a710dca24467f78be8198153ba07a0660f49950f58a76de92babcefcca8692&X-Amz-SignedHeaders=host%3Bx-amz-expected-bucket-owner&response-expires=Tue%2C%2022%20Sep%202026%2015%3A56%3A00%20GMT",
  "atolye-masa":
    "https://export-download.canva.com/tQluw/DAHV7ptQluw/-1/0/0001-5627764429136632403.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAQYCGKMUH5AO7UJ26%2F20260922%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260922T085853Z&X-Amz-Expires=24811&X-Amz-Signature=48394fce1a4b726153260e144bd9df734fefde5003ba1dde712de48292f51d5d&X-Amz-SignedHeaders=host%3Bx-amz-expected-bucket-owner&response-expires=Tue%2C%2022%20Sep%202026%2015%3A52%3A24%20GMT",
  "blog-masa":
    "https://export-download.canva.com/Tj3zA/DAHV7sTj3zA/-1/0/0001-3677705789043155762.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAQYCGKMUH5AO7UJ26%2F20260922%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260922T063220Z&X-Amz-Expires=35845&X-Amz-Signature=16abdaa0211ed2f2d48ac2ed3efd6f297757ba5b08b69be144fc9caf1bdba93d&X-Amz-SignedHeaders=host%3Bx-amz-expected-bucket-owner&response-expires=Tue%2C%2022%20Sep%202026%2016%3A29%3A45%20GMT",
  yaprak:
    "https://export-download.canva.com/LeKE8/DAHV7lLeKE8/-1/0/0001-9186734036616921928.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAQYCGKMUH5AO7UJ26%2F20260921%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260921T213334Z&X-Amz-Expires=66497&X-Amz-Signature=8480e1f73c3979e1f72406e626ef34b9521898bcc181fe9bed21755c760b5981&X-Amz-SignedHeaders=host%3Bx-amz-expected-bucket-owner&response-expires=Tue%2C%2022%20Sep%202026%2016%3A01%3A51%20GMT",
};

/* PNG imzasi kontrolu - bozuk/HTML indirmeyi yakalar */
function isPng(file) {
  const fd = fs.openSync(file, "r");
  const buf = Buffer.alloc(8);
  fs.readSync(fd, buf, 0, 8, 0);
  fs.closeSync(fd);
  return buf.toString("hex") === "89504e470d0a1a0a";
}

const get = (u, f, n) =>
  new Promise((res, rej) => {
    if (n > 6) return rej(new Error("cok fazla yonlendirme"));
    https
      .get(u, (r) => {
        if (r.statusCode >= 300 && r.statusCode < 400 && r.headers.location) {
          r.resume();
          return get(r.headers.location, f, n + 1).then(res, rej);
        }
        if (r.statusCode !== 200) {
          r.resume();
          return rej(new Error("HTTP " + r.statusCode));
        }
        const w = fs.createWriteStream(f);
        r.pipe(w);
        w.on("finish", () => res());
        w.on("error", rej);
      })
      .on("error", rej);
  });

(async () => {
  for (const [name, u] of Object.entries(urls)) {
    const f = path.join(OUT, name + ".png");
    const tmp = f + ".tmp";
    try {
      await get(u, tmp, 0);
      if (!isPng(tmp)) throw new Error("gecerli PNG degil (indirme bozuk)");
      fs.renameSync(tmp, f);
      console.log("  ok  " + name + ".png  " + Math.round(fs.statSync(f).size / 1024) + " KB");
    } catch (e) {
      try { fs.unlinkSync(tmp); } catch (_) {}
      console.log("  HATA  " + name + ": " + e.message);
    }
  }
})();
