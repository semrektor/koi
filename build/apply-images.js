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
  [/öne çıkan/i, "karsilama"], // blog one cikan yazi: yazinin kendi gorseli
  [/karşılama|iç mekân|bekleme|genel görünüm/i, "karsilama"],
  [/oyun odası|seans|çocuk-aile|buluşma/i, "oyun-odasi"],
  [/danışmanlık|seminer/i, "danismanlik"],
  [/atölye|çalışma alanı|malzeme/i, "atolye-masa"],
  [/kapak/i, "blog-masa"],
  [/etkinlik|açılış/i, "hero-kemer"],
  [/detay|bitki|yaprak/i, "yaprak"],
];

/* Eslesmeyenler icin sirayla kullanilacak gorseller */
const FALLBACK = ["oyun-odasi", "danismanlik", "atolye-masa", "blog-masa", "karsilama", "yaprak"];

/* Dikey/kemerli alanlarda tercih edilen dikey gorseller */
const PORTRAIT_IMG = { karsilama: "hero-kemer", "oyun-odasi": "oyun-odasi", danismanlik: "danismanlik" };

/* Gorsellerin tam cozunurlukteki genisligi; srcset icin kullanilir */
const GENISLIK = {
  karsilama: 2200, "hero-kemer": 1400, "oyun-odasi": 2200,
  danismanlik: 1400, "atolye-masa": 2200, "blog-masa": 2200, yaprak: 2200,
};

/* Kucuk alanlarda 900px varyant, buyuk alanlarda tam cozunurluk sunulur */
const imgEtiket = (name) =>
  '<img class="media__img" src="assets/img/' + name + '.jpg"' +
  ' srcset="assets/img/' + name + '-sm.jpg 900w, assets/img/' + name + ".jpg " + (GENISLIK[name] || 2200) + 'w"' +
  ' sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw"' +
  ' alt="' + (ALT[name] || "") + '" loading="lazy">';

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
  /* Monogram alanlari (uzman portreleri) bos kalir */
  if (/media--mono/.test(classes)) return null;
  /* One cikan yazi: detay sayfasindaki kapakla ayni gorsel kullanilir */
  if (/öne çıkan/i.test(label)) return "karsilama";
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
        ">" +
        imgEtiket(img)
      );
    }
  );

  fs.writeFileSync(p, src, "utf8");
});

console.log(placed + " görsel yerleştirildi, " + skipped + " portre alanı boş bırakıldı.");
