/**
 * Teslim oncesi kontrol: baglantilar, SEO alanlari, erisilebilirlik ve
 * yapisal butunluk. Hata bulursa cikis kodu 1 doner.
 *
 * Kullanim: node build/check.js
 */
const fs = require("fs");
const path = require("path");

const SITE = path.join(__dirname, "..", "site");
const hatalar = [];
const uyarilar = [];

const dosyalar = fs.readdirSync(SITE).filter((f) => f.endsWith(".html"));
const sayfalar = {};
dosyalar.forEach((f) => (sayfalar[f] = fs.readFileSync(path.join(SITE, f), "utf8")));

const hata = (f, m) => hatalar.push(f + ": " + m);
const uyari = (f, m) => uyarilar.push(f + ": " + m);

dosyalar.forEach((f) => {
  const s = sayfalar[f];
  const yonetim = /^yonetim/.test(f);

  /* 1. Baglantilar ve kaynaklar */
  [...s.matchAll(/(?:href|src)="([^"]+)"/g)]
    .map((m) => m[1])
    .forEach((h) => {
      if (h.startsWith("http") || h.startsWith("#") || h.startsWith("mailto:") || h.startsWith("tel:") || h.startsWith("data:")) return;
      const hedef = h.split("#")[0].split("?")[0];
      if (!hedef) return;
      if (!fs.existsSync(path.join(SITE, hedef))) hata(f, "kirik baglanti/kaynak -> " + hedef);
    });

  /* 2. Bos veya yer tutucu baglanti */
  const bos = (s.match(/href="#"/g) || []).length;
  if (bos > 0 && !yonetim) uyari(f, bos + " adet href=\"#\" (islevsiz baglanti)");

  /* 3. SEO alanlari */
  if (!/<title>[^<]{10,}<\/title>/.test(s)) hata(f, "title eksik veya cok kisa");
  if (!yonetim) {
    const d = s.match(/<meta name="description" content="([^"]*)"/);
    if (!d || d[1].length < 40) hata(f, "meta description eksik veya cok kisa");
    else if (d[1].length > 175) uyari(f, "meta description 175 karakterden uzun (" + d[1].length + ")");
  }

  /* 4. Basliklar */
  const h1 = (s.match(/<h1[\s>]/g) || []).length;
  if (h1 === 0) hata(f, "h1 yok");
  if (h1 > 1) hata(f, h1 + " adet h1 (sayfada tek h1 olmali)");

  /* 5. Gorsellerde alt */
  [...s.matchAll(/<img\b[^>]*>/g)].forEach((m) => {
    if (!/\balt=/.test(m[0])) hata(f, "alt niteligi olmayan img");
  });

  /* 6. Dil ve karakter seti */
  if (!/<html lang="tr">/.test(s)) hata(f, "html lang=\"tr\" eksik");
  if (!/charset="utf-8"/i.test(s)) hata(f, "charset eksik");
  if (!/name="viewport"/.test(s)) hata(f, "viewport meta eksik");

  /* 7. Form alanlarinda etiket */
  [...s.matchAll(/<(input|select|textarea)\b[^>]*id="([^"]+)"[^>]*>/g)].forEach((m) => {
    const id = m[2];
    if (m[1] === "input" && /type="(hidden|submit|button)"/.test(m[0])) return;
    if (!new RegExp('<label[^>]*for="' + id + '"').test(s)) hata(f, "etiketi olmayan form alani: #" + id);
  });

  /* 8. Yapisal denge */
  const ac = (s.match(/<div\b/g) || []).length;
  const kapa = (s.match(/<\/div>/g) || []).length;
  if (ac !== kapa) hata(f, "div dengesizligi (" + ac + " acik / " + kapa + " kapali)");
  const acS = (s.match(/<section\b/g) || []).length;
  const kapaS = (s.match(/<\/section>/g) || []).length;
  if (acS !== kapaS) hata(f, "section dengesizligi (" + acS + " / " + kapaS + ")");

  /* 9. Yonetim sayfalari arama motoruna kapali olmali */
  if (yonetim && !/name="robots" content="noindex/.test(s)) hata(f, "yonetim sayfasinda noindex yok");

  /* 9b. CSP uyumu: script-src 'self' satir ici script ve olay niteliklerini engeller */
  if (/<script(?![^>]*\bsrc=)[^>]*>/i.test(s)) hata(f, "satir ici <script> (CSP tarafindan engellenir)");
  if (/\son(click|load|error|submit|change|input|mouseover)\s*=/i.test(s)) hata(f, "satir ici olay niteligi (onclick= vb., CSP engeller)");
  if (/href="javascript:/i.test(s)) hata(f, "javascript: baglantisi");

  /* 9c. Yeni sekmede acilan baglantilar sayfaya erisemesin */
  [...s.matchAll(/<a\b[^>]*target="_blank"[^>]*>/g)].forEach((m) => {
    if (!/rel="[^"]*noopener/.test(m[0])) hata(f, "target=_blank baglantida rel=noopener yok");
  });

  /* 10. Taslak artiklari */
  if (/lorem ipsum/i.test(s)) hata(f, "Lorem ipsum metni kalmis");
  if (/<!--\s*(title|desc|nav|layout|pagetitle|pagesub|topaction|generated)/.test(s))
    hata(f, "derleme yorumu ciktida kalmis");
});

/* 11. Site genel kontrolleri */
["sitemap.xml", "robots.txt", "index.html", "assets/css/style.css", "assets/js/main.js"].forEach((f) => {
  if (!fs.existsSync(path.join(SITE, f))) hatalar.push("eksik dosya: " + f);
});

/* 12. Gorsel boyutlari (performans) */
const imgDir = path.join(SITE, "assets", "img");
if (fs.existsSync(imgDir)) {
  fs.readdirSync(imgDir).forEach((f) => {
    const kb = fs.statSync(path.join(imgDir, f)).size / 1024;
    if (kb > 500) uyarilar.push("buyuk gorsel: assets/img/" + f + " (" + Math.round(kb) + " KB)");
  });
}

/* 13. Yetim sayfa kontrolu (hicbir yerden baglanmayan) */
const baglananlar = new Set();
dosyalar.forEach((f) => {
  [...sayfalar[f].matchAll(/href="([^"#?]+\.html)"/g)].forEach((m) => baglananlar.add(m[1]));
});
dosyalar.forEach((f) => {
  if (f === "index.html" || f === "404.html") return; // 404 dogal olarak baglanti almaz
  if (!baglananlar.has(f)) uyarilar.push("yetim sayfa (hicbir yerden baglanmiyor): " + f);
});

/* ---------- Rapor ---------- */
console.log("KOI - teslim oncesi kontrol");
console.log("  Sayfa sayisi : " + dosyalar.length);
console.log("  Hata         : " + hatalar.length);
console.log("  Uyari        : " + uyarilar.length);

if (hatalar.length) {
  console.log("\nHATALAR");
  hatalar.forEach((h) => console.log("  ✗ " + h));
}
if (uyarilar.length) {
  console.log("\nUYARILAR");
  uyarilar.forEach((u) => console.log("  ! " + u));
}
if (!hatalar.length) console.log("\nTum kritik kontroller gecti.");

process.exit(hatalar.length ? 1 : 0);
