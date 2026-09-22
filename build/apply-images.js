/**
 * Uretilen gorselleri sayfa govdelerindeki .media alanlarina yerlestirir.
 * build/pages/*.html dosyalarini yerinde gunceller.
 *
 * Kullanim: node build/apply-images.js   (ardindan: node build/build.js)
 *
 * Portre alanlari bilincli olarak bos birakilir - gercek uzman
 * fotograflari cekim sonrasi eklenecektir.
 */
const fs = require("fs");
const path = require("path");

const PAGES = path.join(__dirname, "pages");

/* Etikete gore gorsel secimi (ilk eslesen kazanir) */
const RULES = [
  [/portre|kurucu/i, null], // insan gorseli uretilmedi - bos birak
  [/karşılama|iç mekân|bekleme|genel görünüm/i, "karsilama"],
  [/oyun odası|seans/i, "oyun-odasi"],
  [/danışmanlık/i, "danismanlik"],
  [/atölye|çalışma alanı|malzeme|etkinlik|seminer|açılış|buluşma/i, "atolye-masa"],
  [/kapak/i, "blog-masa"],
  [/detay|bitki|yaprak/i, "yaprak"],
];

/* Eslesmeyenler icin sirayla kullanilacak gorseller */
const FALLBACK = ["oyun-odasi", "danismanlik", "atolye-masa", "blog-masa", "karsilama", "yaprak"];

/* Dikey/kemerli alanlarda tercih edilen dikey gorseller */
const PORTRAIT_IMG = { karsilama: "hero-kemer", "oyun-odasi": "oyun-odasi", danismanlik: "danismanlik" };

const ALT = {
  karsilama: "KOI merkezinin karşılama alanı",
  "hero-kemer": "KOI merkezinde kemerli dinlenme alanı",
  "oyun-odasi": "KOI oyun grubu odası",
  danismanlik: "KOI danışmanlık odası",
  "atolye-masa": "KOI atölye çalışma masası",
  "blog-masa": "Defter, kalem ve çay ile çalışma masası",
  yaprak: "Duvara vuran yaprak gölgeleri",
};

let fallbackIndex = 0;

function pick(label, classes) {
  for (const [re, img] of RULES) {
    if (re.test(label)) {
      if (img === null) return null;
      const isPortrait = /media--arch|media--tall|ratio-4-5|ratio-3-4/.test(classes);
      return isPortrait && PORTRAIT_IMG[img] ? PORTRAIT_IMG[img] : img;
    }
  }
  const img = FALLBACK[fallbackIndex++ % FALLBACK.length];
  const isPortrait = /media--arch|media--tall|ratio-4-5|ratio-3-4/.test(classes);
  return isPortrait && PORTRAIT_IMG[img] ? PORTRAIT_IMG[img] : img;
}

const files = fs.readdirSync(PAGES).filter((f) => f.endsWith(".html"));
let placed = 0,
  skipped = 0;

files.forEach((file) => {
  const p = path.join(PAGES, file);
  let src = fs.readFileSync(p, "utf8");
  if (src.startsWith("<!--generated-->")) return; // gorselleri jenerator belirledi
  fallbackIndex = 0;

  // Onceki calistirmanin ciktilarini temizle (idempotent olsun)
  src = src.replace(/\s*<img class="media__img"[^>]*>/g, "");
  src = src.replace(/ has-img/g, "");

  src = src.replace(
    /<div class="(media[^"]*)"([^>]*?)data-label="([^"]*)"([^>]*)>/g,
    (full, classes, mid, label, tail) => {
      const img = pick(label, classes);
      if (!img) {
        skipped++;
        return full;
      }
      placed++;
      return (
        '<div class="' +
        classes +
        ' has-img"' +
        mid +
        'data-label="' +
        label +
        '"' +
        tail +
        '><img class="media__img" src="assets/img/' +
        img +
        '.jpg" alt="' +
        (ALT[img] || "") +
        '" loading="lazy">'
      );
    }
  );

  fs.writeFileSync(p, src, "utf8");
});

console.log(placed + " görsel yerleştirildi, " + skipped + " portre alanı boş bırakıldı.");
