/**
 * Icerik verisinden detay sayfalarini ve liste kartlarini uretir.
 *   build/content/*.js  ->  build/pages/<slug>.html
 * Liste sayfalarindaki kart bloklarini da gunceller (CARDS isaretcileri).
 *
 * Kullanim: node build/generate-pages.js   (ardindan: node build/build.js)
 */
const fs = require("fs");
const path = require("path");

const PAGES = path.join(__dirname, "pages");
/* Uretilen sayfalar bu isareti tasir; apply-images onlara dokunmaz. */
const GENERATED_MARK = "<!--generated-->\n";
const hizmetler = require("./content/hizmetler");
const atolyeler = require("./content/atolyeler");
const blog = require("./content/blog");
const uzmanlar = require("./content/uzmanlar");
const galeri = require("./content/galeri");
const oyunGruplari = require("./content/oyun-gruplari");
const sss = require("./content/sss");

const ALT = {
  karsilama: "KOI merkezinin karşılama alanı",
  "hero-kemer": "KOI merkezinde kemerli dinlenme alanı",
  "oyun-odasi": "KOI oyun grubu odası",
  danismanlik: "KOI danışmanlık odası",
  "atolye-masa": "KOI atölye çalışma masası",
  "blog-masa": "Defter, kalem ve çay ile çalışma masası",
  yaprak: "Duvara vuran yaprak gölgeleri",
};

/* Slug -> baslik/url cozumleme (ilgili baglantilar icin) */
const SABIT = {
  "oyun-gruplari": { baslik: "Oyun Grupları", url: "oyun-gruplari.html" },
  atolyeler: { baslik: "Tüm Atölyeler", url: "atolyeler.html" },
  hizmetler: { baslik: "Tüm Hizmetler", url: "hizmetler.html" },
  iletisim: { baslik: "İletişim", url: "iletisim.html" },
  blog: { baslik: "Blog", url: "blog.html" },
};
const INDEX = {};
[...hizmetler, ...atolyeler, ...blog].forEach((x) => {
  INDEX[x.slug] = { baslik: x.baslik, url: x.slug + ".html", kisa: x.kisa, gorsel: x.gorsel };
});
Object.assign(INDEX, SABIT);

/* Gorsellerin tam cozunurlukteki genisligi; srcset icin kullanilir */
const GENISLIK = {
  karsilama: 2200, "hero-kemer": 1400, "oyun-odasi": 2200,
  danismanlik: 1400, "atolye-masa": 2200, "blog-masa": 2200, yaprak: 2200,
};

/* Kucuk alanlarda 900px varyant, buyuk alanlarda tam cozunurluk sunulur */
const imgEtiket = (name, ekSinif) =>
  '<img class="media__img" src="assets/img/' + name + '.jpg"' +
  ' srcset="assets/img/' + name + '-sm.jpg 900w, assets/img/' + name + ".jpg " + (GENISLIK[name] || 2200) + 'w"' +
  ' sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw"' +
  ' alt="' + (ALT[name] || "") + '" loading="lazy">';

const media = (name, cls, label) =>
  '<div class="media ' + cls + ' has-img" data-label="' + label + '">' +
  imgEtiket(name) + "</div>";

const arrow = '<svg aria-hidden="true"><use href="#i-arrow"></use></svg>';

/* Baslik metninden baglanti icin kimlik uretir */
function basId(t) {
  var harita = { "ç": "c", "ğ": "g", "ı": "i", "ö": "o", "ş": "s", "ü": "u" };
  return String(t).toLowerCase()
    .replace(/[çğıöşü]/g, function (c) { return harita[c]; })
    .replace(/[^a-z0-9]+/g, "-").replace(/^-+|-+$/g, "");
}

function bolumHtml(b) {
  let out = "";
  if (b.h) out += '      <h2 id="' + basId(b.h) + '">' + b.h + "</h2>\n";
  if (b.p) b.p.forEach((t) => (out += "      <p>" + t + "</p>\n"));
  if (b.liste) {
    out += "      <ul>\n";
    b.liste.forEach((t) => (out += "        <li>" + t + "</li>\n"));
    out += "      </ul>\n";
  }
  if (b.alinti) out += "      <blockquote>" + b.alinti + "</blockquote>\n";
  return out;
}

function ilgiliKartlar(slugs, baslik, aciklama) {
  const kartlar = slugs
    .map((s) => INDEX[s])
    .filter(Boolean)
    .map(
      (x) =>
        '      <article class="card reveal">\n' +
        "        " + media(x.gorsel || "atolye-masa", "media--ratio-3-2", "Görsel") + "\n" +
        '        <div class="card__body">\n' +
        '          <h3 class="card__title">' + x.baslik + "</h3>\n" +
        (x.kisa ? '          <p class="card__text">' + x.kisa + "</p>\n" : "") +
        '          <a class="link-arrow card__foot" href="' + x.url + '">Detaylı Bilgi' + arrow + "</a>\n" +
        "        </div>\n" +
        "      </article>"
    )
    .join("\n");

  return (
    '<section class="section section--cream">\n' +
    '  <div class="container container--wide">\n' +
    '    <div class="section-head section-head--split reveal">\n' +
    "      <div>\n" +
    '        <span class="eyebrow">' + baslik + "</span>\n" +
    "        <h2>" + aciklama + "</h2>\n" +
    "      </div>\n" +
    "    </div>\n" +
    '    <div class="cards cards--3">\n' +
    kartlar +
    "\n    </div>\n" +
    "  </div>\n" +
    "</section>\n"
  );
}

function yanPanel(item, tur) {
  const satirlar = (item.bilgi || [])
    .map(
      ([k, v]) =>
        '          <li><strong style="font-weight:400;color:var(--koi-olive)">' + k +
        ':</strong> <span class="muted">' + v + "</span></li>"
    )
    .join("\n");

  const digerler = (tur === "hizmet" ? hizmetler : atolyeler)
    .filter((x) => x.slug !== item.slug)
    .slice(0, 4)
    .map((x) => '          <li><a href="' + x.slug + '.html">' + x.baslik + "</a></li>")
    .join("\n");

  const ctaBaslik = tur === "hizmet" ? "Bilgi Alın" : "Yerinizi Ayırtın";
  const ctaMetin =
    tur === "hizmet"
      ? "Süreç hakkında konuşmak ve uygun saatleri belirlemek için ön başvuru formunu doldurabilirsiniz."
      : "Kontenjan durumunu ve katılım detaylarını paylaşabilmemiz için başvurunuzu iletin.";
  const ctaButon = tur === "hizmet" ? "Ön Başvuru" : "Atölye Başvurusu";
  const listeBaslik = tur === "hizmet" ? "Diğer Hizmetler" : "Diğer Atölyeler";
  const listeSayfa = tur === "hizmet" ? "hizmetler.html" : "atolyeler.html";
  const listeMetin = tur === "hizmet" ? "Tüm Hizmetler" : "Tüm Program Takvimi";

  return (
    "    <aside>\n" +
    '      <div class="sidebar-card reveal">\n' +
    "        <h3>" + (tur === "hizmet" ? "Kısa Bilgi" : "Program Bilgisi") + "</h3>\n" +
    "        <ul>\n" + satirlar + "\n        </ul>\n" +
    '        <p class="muted" style="font-size:.78rem;margin-top:18px">Bilgiler taslak amaçlıdır; içerik çalışmasında netleştirilecektir.</p>\n' +
    "      </div>\n\n" +
    '      <div class="sidebar-card sidebar-card--dark reveal">\n' +
    "        <h3>" + ctaBaslik + "</h3>\n" +
    "        <p>" + ctaMetin + "</p>\n" +
    '        <div style="margin-top:20px;display:flex;flex-direction:column;gap:10px">\n' +
    '          <a class="btn btn--terra" href="iletisim.html">' + ctaButon + arrow + "</a>\n" +
    '          <a class="btn btn--light" href="https://wa.me/905313415086">WhatsApp</a>\n' +
    "        </div>\n" +
    "      </div>\n\n" +
    '      <div class="sidebar-card reveal">\n' +
    "        <h3>" + listeBaslik + "</h3>\n" +
    "        <ul>\n" + digerler + "\n" +
    '          <li><a href="' + listeSayfa + '">' + listeMetin + "</a></li>\n" +
    "        </ul>\n" +
    "      </div>\n" +
    "    </aside>\n"
  );
}

/* ---------- Hizmet ve atolye detay sayfalari ---------- */
function detaySayfasi(item, tur) {
  const ustSayfa = tur === "hizmet" ? ["Hizmetler", "hizmetler.html"] : ["Atölyeler", "atolyeler.html"];
  let prose = "";
  item.bolumler.forEach((b) => (prose += bolumHtml(b)));
  if (item.alinti) prose += "      <blockquote>" + item.alinti + "</blockquote>\n";

  return (
    "<!--title: " + item.baslik + " | KOI Çocuk ve Aile Gelişim Merkezi-->\n" +
    "<!--desc: " + item.kisa + "-->\n" +
    "<!--nav: " + (tur === "hizmet" ? "hizmetler" : "atolyeler") + "-->\n\n" +
    '<section class="page-hero">\n' +
    '  <div class="container container--wide page-hero__grid">\n' +
    "    <div>\n" +
    '      <nav class="breadcrumb" aria-label="Sayfa yolu">\n' +
    '        <a href="index.html">Anasayfa</a><span>/</span><a href="' + ustSayfa[1] + '">' + ustSayfa[0] +
    "</a><span>/</span><span>" + item.baslik + "</span>\n" +
    "      </nav>\n" +
    '      <span class="eyebrow">' + item.kategori + "</span>\n" +
    "      <h1>" + item.baslik + "</h1>\n" +
    "    </div>\n" +
    '    <p class="lead">' + item.lead + "</p>\n" +
    "  </div>\n" +
    "</section>\n\n" +
    '<section class="section section--tight">\n' +
    '  <div class="container container--wide">\n' +
    "    " + media(item.gorsel, "media--ratio-16-9 reveal", "Görsel") + "\n" +
    "  </div>\n" +
    "</section>\n\n" +
    '<section class="section section--tight">\n' +
    '  <div class="container container--wide with-sidebar">\n' +
    '    <div class="prose reveal">\n' + prose + "    </div>\n\n" +
    yanPanel(item, tur) +
    "  </div>\n" +
    "</section>\n\n" +
    ilgiliKartlar(item.ilgili, tur === "hizmet" ? "İlgili Hizmetler" : "Diğer Atölyeler",
      tur === "hizmet" ? "Birlikte İlerleyen Süreçler" : "Bunlar da İlginizi Çekebilir")
  );
}

/* ---------- Blog yazisi sayfasi ---------- */
function blogSayfasi(item) {
  let prose = "";
  item.bolumler.forEach((b) => (prose += bolumHtml(b)));

  const icindekiler = item.bolumler
    .filter((b) => b.h)
    .map((b) => '          <li><a href="#' + basId(b.h) + '">' + b.h + "</a></li>")
    .join("\n");

  const kategoriler = [...new Set(blog.map((b) => b.kategori))]
    .map((k) => '          <li><a href="blog.html">' + k + "</a></li>")
    .join("\n");

  return (
    "<!--title: " + item.baslik + " | KOI Blog-->\n" +
    "<!--desc: " + item.kisa + "-->\n" +
    "<!--nav: blog-->\n\n" +
    '<section class="page-hero">\n' +
    '  <div class="container container--wide page-hero__grid">\n' +
    "    <div>\n" +
    '      <nav class="breadcrumb" aria-label="Sayfa yolu">\n' +
    '        <a href="index.html">Anasayfa</a><span>/</span><a href="blog.html">Blog</a><span>/</span><span>' +
    item.baslik + "</span>\n" +
    "      </nav>\n" +
    '      <span class="eyebrow">' + item.kategori + "</span>\n" +
    "      <h1>" + item.baslik + "</h1>\n" +
    "    </div>\n" +
    "    <div>\n" +
    '      <div class="post__meta" style="margin-bottom:14px"><span>' + item.yazar +
    "</span><span>·</span><span>" + item.sure + " okuma</span></div>\n" +
    '      <p class="lead">' + item.lead + "</p>\n" +
    "    </div>\n" +
    "  </div>\n" +
    "</section>\n\n" +
    '<section class="section section--tight">\n' +
    '  <div class="container container--wide">\n' +
    "    " + media(item.gorsel, "media--ratio-16-9 reveal", "Kapak görseli") + "\n" +
    "  </div>\n" +
    "</section>\n\n" +
    '<section class="section section--tight">\n' +
    '  <div class="container container--wide with-sidebar">\n' +
    '    <article class="prose reveal">\n' + prose + "    </article>\n\n" +
    "    <aside>\n" +
    '      <div class="sidebar-card reveal">\n' +
    "        <h3>Bu Yazıda</h3>\n        <ul>\n" + icindekiler + "\n        </ul>\n      </div>\n\n" +
    '      <div class="sidebar-card sidebar-card--dark reveal">\n' +
    "        <h3>Bir Uzmanla Konuşun</h3>\n" +
    "        <p>Bu konuda zorlanıyorsanız, kısa bir ön görüşmeyle başlayabiliriz.</p>\n" +
    '        <div style="margin-top:20px;display:flex;flex-direction:column;gap:10px">\n' +
    '          <a class="btn btn--terra" href="iletisim.html">Bilgi Al' + arrow + "</a>\n" +
    '          <a class="btn btn--light" href="https://wa.me/905313415086">WhatsApp</a>\n' +
    "        </div>\n      </div>\n\n" +
    '      <div class="sidebar-card reveal">\n' +
    "        <h3>Kategoriler</h3>\n        <ul>\n" + kategoriler + "\n        </ul>\n      </div>\n" +
    "    </aside>\n" +
    "  </div>\n" +
    "</section>\n\n" +
    ilgiliKartlar(item.ilgili, "Devamı", "İlgili Yazılar")
  );
}

/* ---------- Liste sayfalari icin kart bloklari ---------- */
function hizmetKartlari() {
  return hizmetler
    .map(
      (x) =>
        '      <article class="card reveal" data-cat="' + x.cat + '">\n' +
        "        " + media(x.gorsel, "media--ratio-3-2", "Görsel") + "\n" +
        '        <div class="card__body">\n' +
        '          <span class="card__meta">' + x.kategori + "</span>\n" +
        '          <h3 class="card__title">' + x.baslik + "</h3>\n" +
        '          <p class="card__text">' + x.kisa + "</p>\n" +
        '          <a class="link-arrow card__foot" href="' + x.slug + '.html">Detaylı Bilgi' + arrow + "</a>\n" +
        "        </div>\n      </article>"
    )
    .join("\n\n");
}

function grupKartlari() {
  /* Oyun gruplari ve atolyeler kendi sayfalarina baglanir */
  return (
    '      <article class="card reveal" data-cat="grup">\n' +
    "        " + media("oyun-odasi", "media--ratio-3-2", "Görsel") + "\n" +
    '        <div class="card__body">\n' +
    '          <span class="card__meta">Grup Programları</span>\n' +
    '          <h3 class="card__title">Oyun Grupları</h3>\n' +
    '          <p class="card__text">Yaş ve gelişim dönemine göre ayrıştırılmış, seans başına en fazla 6 çocukla yürütülen küçük grup programları.</p>\n' +
    '          <a class="link-arrow card__foot" href="oyun-gruplari.html">Detaylı Bilgi' + arrow + "</a>\n" +
    "        </div>\n      </article>\n\n" +
    '      <article class="card reveal" data-cat="grup">\n' +
    "        " + media("atolye-masa", "media--ratio-3-2", "Görsel") + "\n" +
    '        <div class="card__body">\n' +
    '          <span class="card__meta">Grup Programları</span>\n' +
    '          <h3 class="card__title">Tematik Atölyeler</h3>\n' +
    '          <p class="card__text">Çocuk, ebeveyn ve çocuk-aile katılımlı; yaratıcılık, duygu ve birlikte üretim temalı atölye programları.</p>\n' +
    '          <a class="link-arrow card__foot" href="atolyeler.html">Detaylı Bilgi' + arrow + "</a>\n" +
    "        </div>\n      </article>"
  );
}

function atolyeKartlari() {
  return atolyeler
    .map(
      (x) =>
        '      <article class="card reveal" data-cat="' + x.cat + '">\n' +
        "        " + media(x.gorsel, "media--ratio-3-2", "Görsel") + "\n" +
        '        <div class="card__body">\n' +
        '          <span class="card__meta">' + x.kategori + "</span>\n" +
        '          <h3 class="card__title">' + x.baslik + "</h3>\n" +
        '          <p class="card__text">' + x.kisa + "</p>\n" +
        '          <div style="display:flex;gap:8px;flex-wrap:wrap">' +
        x.rozetler.map((r, i) => '<span class="badge' + (i ? " badge--olive" : "") + '">' + r + "</span>").join("") +
        "</div>\n" +
        '          <a class="link-arrow card__foot" href="' + x.slug + '.html">Detaylı Bilgi' + arrow + "</a>\n" +
        "        </div>\n      </article>"
    )
    .join("\n\n");
}

function blogKartlari(haric) {
  return blog
    .filter((x) => x.slug !== haric)
    .map(
      (x) =>
        '      <article class="post reveal" data-cat="' + x.cat + '">\n' +
        "        " + media(x.gorsel, "media--ratio-3-2", "Kapak görseli") + "\n" +
        '        <div class="post__meta"><span>' + x.kategori + "</span><span>·</span><span>" + x.sure + "</span></div>\n" +
        '        <h3 class="post__title">' + x.baslik + "</h3>\n" +
        '        <p class="post__excerpt">' + x.kisa + "</p>\n" +
        '        <a class="link-arrow" href="' + x.slug + '.html">Yazıyı Oku' + arrow + "</a>\n" +
        "      </article>"
    )
    .join("\n\n");
}

function anasayfaKartlari() {
  const secim = [
    hizmetler.find((x) => x.slug === "hizmet-cocuk-ergen-danismanligi"),
    hizmetler.find((x) => x.slug === "hizmet-aile-ebeveyn-danismanligi"),
    { baslik: "Oyun Grupları ve Atölyeler", kisa: "Yaş ve gelişim dönemine göre ayrıştırılmış, küçük gruplu programlar.", gorsel: "oyun-odasi", url: "oyun-gruplari.html" },
    hizmetler.find((x) => x.slug === "hizmet-anne-yenidogan"),
    hizmetler.find((x) => x.slug === "hizmet-seminer-workshop"),
  ];
  return secim
    .map(
      (x) =>
        '        <article class="card reveal">\n' +
        "          " + media(x.gorsel, "media--ratio-4-5", "Görsel") + "\n" +
        '          <div class="card__body">\n' +
        '            <h3 class="card__title">' + x.baslik + "</h3>\n" +
        '            <p class="card__text">' + x.kisa + "</p>\n" +
        '            <a class="link-arrow card__foot" href="' + (x.url || x.slug + ".html") + '">Detaylı Bilgi' + arrow + "</a>\n" +
        "          </div>\n        </article>"
    )
    .join("\n");
}

function anasayfaBlog() {
  return blog
    .slice(0, 3)
    .map(
      (x) =>
        '        <article class="post reveal">\n' +
        "          " + media(x.gorsel, "media--ratio-3-2", "Kapak görseli") + "\n" +
        '          <div class="post__meta"><span>' + x.kategori + "</span><span>·</span><span>" + x.sure + " okuma</span></div>\n" +
        '          <h3 class="post__title">' + x.baslik + "</h3>\n" +
        '          <p class="post__excerpt">' + x.kisa + "</p>\n" +
        '          <a class="link-arrow" href="' + x.slug + '.html">Yazıyı Oku' + arrow + "</a>\n" +
        "        </article>"
    )
    .join("\n");
}

/* ---------- Ekip ---------- */
const yaprakIsareti = '<svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg>';

/* Portre yokken gosterilen bas harfler: "Elif Bilsel" -> "EB" */
function basHarfler(ad) {
  const p = ad.trim().split(/\s+/);
  return (p[0][0] + (p.length > 1 ? p[p.length - 1][0] : "")).toLocaleUpperCase("tr");
}

function uzmanKarti(u) {
  return (
        '        <article class="expert reveal">\n' +
        '          <div class="media media--ratio-3-4 media--mono" data-label="Fotoğraf çekim sonrası eklenecek" data-mono="' + basHarfler(u.ad) + '">' + yaprakIsareti + "</div>\n" +
        '          <h3 class="expert__name"><a href="uzman-' + u.slug + '.html">' + u.ad + "</a></h3>\n" +
        '          <p class="expert__role">' + (u.unvanKisa || u.unvan) + "</p>\n" +
        '          <p class="expert__text">' + u.kisa + "</p>\n" +
        '          <span class="link-arrow" aria-hidden="true">Profili İncele' + arrow + "</span>\n" +
        "        </article>"
  );
}

/* Uzmanlik alanlari, egitim ve yuruttugu hizmetler; ardindan "Bilgi Al" dugmesi.
   dugme false ise dugme yalnizca yuruttugu hizmet varsa gosterilir. */
function uzmanAyrintilari(u, dugme) {
  let out = "";
  const ek = [];
  if (u.alanlar) ek.push("        <h3>Uzmanlık Alanları</h3>\n        <p>" + u.alanlar + "</p>");
  if (u.egitim.length) {
    ek.push("        <h3>Eğitim ve Sertifikalar</h3>\n        <ul>\n" + u.egitim.map((e) => "          <li>" + e + "</li>").join("\n") + "\n        </ul>");
  }
  if (u.hizmetler.length) {
    ek.push(
      "        <h3>Yürüttüğü Hizmetler</h3>\n        <ul>\n" +
        u.hizmetler.map((s) => '          <li><a href="' + s + '.html">' + INDEX[s].baslik + "</a></li>").join("\n") +
        "\n        </ul>"
    );
  }
  if (ek.length) out += '      <div class="prose">\n' + ek.join("\n") + "\n      </div>\n";
  if (dugme || u.hizmetler.length) {
    out += '      <div style="margin-top:30px">\n        <a class="btn btn--primary" href="iletisim.html">Bilgi Al' + arrow + "</a>\n      </div>\n";
  }
  return out;
}

/* Uzman sayfasi: kartina tiklaninca acilir */
function uzmanSayfasi(u) {
  let govde = "";
  if (u.unvan && u.unvan !== u.etiket) govde += '      <p class="expert__role" style="margin-bottom:20px">' + u.unvan + "</p>\n";
  u.bio.forEach((t) => (govde += "      <p>" + t + "</p>\n"));
  govde += uzmanAyrintilari(u, true);

  const diger = uzmanlar.filter((x) => x.slug !== u.slug).slice(0, 4);
  const digerBolum = diger.length
    ? '\n<section class="section section--cream">\n' +
      '  <div class="container container--wide">\n' +
      '    <div class="section-head section-head--split reveal">\n' +
      "      <div>\n" +
      '        <span class="eyebrow">Kadromuz</span>\n' +
      "        <h2>Diğer Uzmanlarımız</h2>\n" +
      "      </div>\n" +
      '      <a class="link-arrow" style="justify-self:end" href="uzmanlarimiz.html">Tüm Ekip' + arrow + "</a>\n" +
      "    </div>\n" +
      '    <div class="cards cards--4">\n' + diger.map(uzmanKarti).join("\n") + "\n    </div>\n" +
      "  </div>\n</section>\n"
    : "";

  return (
    "<!--title: " + u.ad + " | KOI Çocuk ve Aile Gelişim Merkezi-->\n" +
    "<!--desc: " + u.kisa + "-->\n" +
    "<!--nav: uzmanlarimiz-->\n\n" +
    '<section class="page-hero">\n' +
    '  <div class="container container--wide page-hero__grid">\n' +
    "    <div>\n" +
    '      <nav class="breadcrumb" aria-label="Sayfa yolu">\n' +
    '        <a href="index.html">Anasayfa</a><span>/</span><a href="uzmanlarimiz.html">Uzmanlarımız</a><span>/</span><span>' +
    u.ad + "</span>\n" +
    "      </nav>\n" +
    (u.etiket ? '      <span class="eyebrow">' + u.etiket + "</span>\n" : "") +
    "      <h1>" + u.ad + "</h1>\n" +
    "    </div>\n" +
    (u.kisa ? '    <p class="lead">' + u.kisa + "</p>\n" : "") +
    "  </div>\n" +
    "</section>\n\n" +
    '<section class="section section--tight">\n' +
    '  <div class="container container--wide split">\n' +
    '    <div class="split__media reveal">\n' +
    '      <div class="media media--arch media--tall media--mono" data-label="Portre — çekim sonrası eklenecek" data-mono="' + basHarfler(u.ad) + '">\n' +
    "        " + yaprakIsareti + "\n      </div>\n" +
    "    </div>\n" +
    '    <div class="split__body reveal">\n' + govde + "    </div>\n" +
    "  </div>\n</section>\n" +
    digerBolum
  );
}

function anasayfaUzmanlar() {
  return uzmanlar.slice(0, 4).map(uzmanKarti).join("\n");
}

/* Uzmanlarimiz sayfasi: genis profiller, ardindan diger uzmanlarin kartlari */
function uzmanProfilleri() {
  const genis = uzmanlar.filter((u) => u.genis);
  const diger = uzmanlar.filter((u) => !u.genis);

  const profiller = genis.map((u, i) => {
    const tek = i % 2 === 1;
    let govde = '      <span class="eyebrow">' + u.etiket + "</span>\n      <h2>" + u.ad + "</h2>\n";
    if (u.unvan && u.unvan !== u.etiket) govde += '      <p class="expert__role" style="margin-bottom:20px">' + u.unvan + "</p>\n";
    u.bio.forEach((t) => (govde += "      <p>" + t + "</p>\n"));
    govde += uzmanAyrintilari(u, false);

    return (
      '<section class="section' + (tek ? " section--cream" : "") + '">\n' +
      '  <div class="container container--wide split' + (tek ? " split--reverse" : "") + '">\n' +
      '    <div class="split__media reveal">\n' +
      '      <div class="media media--arch media--tall media--mono" data-label="Portre — çekim sonrası eklenecek" data-mono="' + basHarfler(u.ad) + '">\n' +
      "        " + yaprakIsareti + "\n      </div>\n" +
      "    </div>\n" +
      '    <div class="split__body reveal">\n' + govde + "    </div>\n" +
      "  </div>\n</section>"
    );
  });

  const krem = genis.length % 2 === 1 ? " section--cream" : "";
  const son = diger.length
    ? '<section class="section' + krem + '">\n' +
      '  <div class="container container--wide">\n' +
      '    <div class="section-head center reveal">\n' +
      '      <span class="eyebrow eyebrow--center">Kadromuz</span>\n' +
      "      <h2>Uzmanlarımız</h2>\n    </div>\n" +
      '    <div class="cards cards--4">\n' + diger.map(uzmanKarti).join("\n") + "\n    </div>\n" +
      "  </div>\n</section>"
    : '<section class="section' + krem + '">\n' +
      '  <div class="container container--wide">\n' +
      '    <div class="section-head center reveal">\n' +
      '      <span class="eyebrow eyebrow--center">Kadromuz</span>\n' +
      "      <h2>Ekibimiz Büyüyor</h2>\n" +
      '      <p class="lead">Uzman kadromuz, açılış dönemiyle birlikte bu sayfada tanıtılacaktır.</p>\n' +
      "    </div>\n  </div>\n</section>";

  return profiller.concat(son).join("\n\n");
}

/* ---------- Galeri ---------- */
function galeriOgeleri(liste) {
  return liste
    .map((g, i) => {
      const desen = galeri.desen[i % galeri.desen.length];
      return (
        '      <div class="media' + (desen ? " " + desen : "") + ' has-img" data-cat="' + g.cat + '" data-label="' + g.baslik + '">' +
        imgEtiket(g.gorsel) + "</div>"
      );
    })
    .join("\n");
}

/* ---------- Oyun gruplari ---------- */
function oyunGrubuKartlari() {
  return oyunGruplari
    .map(
      (g) =>
        '      <article class="card reveal">\n' +
        '        <div class="media media--ratio-4-5 has-img" data-label="Görsel">' + imgEtiket(g.gorsel) + yaprakIsareti + "</div>\n" +
        '        <div class="card__body">\n' +
        '          <span class="card__meta">' + g.yas + "</span>\n" +
        '          <h3 class="card__title">' + g.ad + "</h3>\n" +
        '          <p class="card__text">' + g.kisa + "</p>\n" +
        '          <span class="badge badge--olive">' + g.kontenjan + "</span>\n" +
        "        </div>\n      </article>"
    )
    .join("\n");
}

function oyunGrubuTablosu() {
  return oyunGruplari
    .map(
      (g) =>
        "          <tr>\n" +
        '            <td data-th="Grup">' + g.ad + "</td>\n" +
        '            <td data-th="Yaş">' + g.yas + "</td>\n" +
        '            <td data-th="Gün ve saat">' + g.gunSaat + "</td>\n" +
        '            <td data-th="Kontenjan"><span class="badge">' + g.kontenjan + "</span></td>\n" +
        '            <td data-th="Ebeveyn katılımı">' + g.ebeveyn + "</td>\n" +
        "          </tr>"
    )
    .join("\n");
}

const secenekler = (liste) => liste.map((t) => "            <option>" + t + "</option>").join("\n");

/* Basvuru formundaki grup listesi */
function grupSecenekleri() {
  return secenekler(oyunGruplari.map((g) => g.ad + " (" + g.yas + ")").concat("Hangi grubun uygun olduğundan emin değilim"));
}

/* Iletisim formundaki "ilgilendiginiz hizmet" listesi */
function konuSecenekleri() {
  return secenekler(hizmetler.map((h) => h.baslik).concat(["Oyun Grupları", "Atölye / Seminer", "Diğer"]));
}

/* ---------- Atolye program tablosu ----------
   Satirlar her atolyenin "bilgi" kutusundaki ayni adli satirlardan okunur. */
function atolyeTablosu() {
  const al = (x, etiket) => ((x.bilgi || []).find(([k]) => k === etiket) || ["", "—"])[1];
  return atolyeler
    .map(
      (x) =>
        "          <tr>\n" +
        '            <td data-th="Atölye / seminer"><a href="' + x.slug + '.html">' + x.baslik + "</a></td>\n" +
        '            <td data-th="Katılımcı">' + al(x, "Katılımcı") + "</td>\n" +
        '            <td data-th="Tarih ve saat">' + al(x, "Tarih ve saat") + "</td>\n" +
        '            <td data-th="Süre">' + al(x, "Süre") + "</td>\n" +
        '            <td data-th="Kontenjan">' + al(x, "Kontenjan") + "</td>\n" +
        "          </tr>"
    )
    .join("\n");
}

/* ---------- Sik sorulan sorular ---------- */
const artiIsareti = '<svg aria-hidden="true"><use href="#i-plus"></use></svg>';

function akordeon(sorular, ilkAcik) {
  return (
    '    <div class="accordion reveal">\n' +
    sorular
      .map((s, i) => {
        const acik = ilkAcik && i === 0;
        return (
          '      <div class="accordion__item' + (acik ? " is-open" : "") + '">\n' +
          '        <button class="accordion__trigger" type="button" aria-expanded="' + (acik ? "true" : "false") + '">' + s.soru + artiIsareti + "</button>\n" +
          '        <div class="accordion__panel">' + s.yanit.map((y) => "<p>" + y + "</p>").join("") + "</div>\n" +
          "      </div>"
        );
      })
      .join("\n") +
    "\n    </div>"
  );
}

/* SSS sayfasi: bolum bolum */
function sssBolumleri() {
  return sss.bolumler
    .map((b, i) => {
      const sorular = sss.sorular.filter((s) => s.bolum === b.slug);
      if (!sorular.length) return "";
      return (
        '<section class="section' + (i % 2 ? " section--cream" : "") + ' section--tight">\n' +
        '  <div class="container container--wide">\n' +
        '    <div class="section-head reveal">\n' +
        '      <span class="eyebrow">' + b.ustYazi + "</span>\n" +
        "      <h2>" + b.baslik + "</h2>\n" +
        "    </div>\n" +
        akordeon(sorular, false) + "\n" +
        "  </div>\n</section>"
      );
    })
    .filter(Boolean)
    .join("\n\n");
}

/* ---------- Yazma ---------- */
let yazilan = 0;
hizmetler.forEach((x) => {
  fs.writeFileSync(path.join(PAGES, x.slug + ".html"), GENERATED_MARK + detaySayfasi(x, "hizmet"), "utf8");
  yazilan++;
});
atolyeler.forEach((x) => {
  fs.writeFileSync(path.join(PAGES, x.slug + ".html"), GENERATED_MARK + detaySayfasi(x, "atolye"), "utf8");
  yazilan++;
});
blog.forEach((x) => {
  fs.writeFileSync(path.join(PAGES, x.slug + ".html"), GENERATED_MARK + blogSayfasi(x), "utf8");
  yazilan++;
});
uzmanlar.forEach((u) => {
  fs.writeFileSync(path.join(PAGES, "uzman-" + u.slug + ".html"), GENERATED_MARK + uzmanSayfasi(u), "utf8");
  yazilan++;
});

/* Liste sayfalarindaki kart bloklarini degistir */
const BLOKLAR = {
  "hizmetler.html": [
    { id: "hizmet-listesi", html: () => hizmetKartlari() + "\n\n" + grupKartlari() },
    { id: "sss-hizmetler", html: () => akordeon(sss.sorular.filter((s) => s.hizmetler), true) },
  ],
  "atolyeler.html": [
    { id: "atolye-listesi", html: atolyeKartlari },
    { id: "atolye-tablosu", html: atolyeTablosu },
  ],
  "oyun-gruplari.html": [
    { id: "grup-kartlari", html: oyunGrubuKartlari },
    { id: "grup-tablosu", html: oyunGrubuTablosu },
    { id: "grup-secenekleri", html: grupSecenekleri },
  ],
  "iletisim.html": [
    { id: "konu-secenekleri", html: konuSecenekleri },
    { id: "sss-iletisim", html: () => akordeon(sss.sorular.filter((s) => s.iletisim), true) },
  ],
  "sss.html": { id: "sss-bolumleri", html: sssBolumleri },
  "blog.html": { id: "blog-listesi", html: () => blogKartlari("blog-yeni-baslangiclar") },
  "uzmanlarimiz.html": { id: "uzman-profilleri", html: uzmanProfilleri },
  "galeri.html": { id: "galeri-listesi", html: () => galeriOgeleri(galeri.gorseller) },
  "index.html": [
    { id: "hizmet-kartlari", html: anasayfaKartlari },
    { id: "blog-kartlari", html: anasayfaBlog },
    { id: "uzman-kartlari", html: anasayfaUzmanlar },
    { id: "galeri-anasayfa", html: () => galeriOgeleri(galeri.gorseller.slice(0, 5)) },
  ],
};

Object.entries(BLOKLAR).forEach(([file, def]) => {
  const p = path.join(PAGES, file);
  if (!fs.existsSync(p)) return;
  let src = fs.readFileSync(p, "utf8");
  const defs = Array.isArray(def) ? def : [def];
  defs.forEach((d) => {
    /* Kart bloklari acilis ve kapanis isaretcisiyle sinirlandirilir;
       boylece uretim kac kez calisirsa calissin yalnizca o blok tazelenir. */
    const ac = "<!--CARDS:" + d.id + "-->";
    const kapa = "<!--/CARDS:" + d.id + "-->";
    if (!src.includes(ac)) {
      console.log("  ! isaretci bulunamadi: " + file + " " + ac);
      return;
    }
    if (!src.includes(kapa)) {
      /* Eski surumden gecis: kapanis isaretcisi yoksa blogu bastan kur */
      const i = src.indexOf(ac);
      const sec = src.indexOf("</section>", i);
      const girinti = file === "index.html" ? "      " : "    ";
      src =
        src.slice(0, i + ac.length) + "\n" + kapa + "\n" +
        girinti + "</div>\n" + girinti.slice(0, -2) + "</div>\n" + src.slice(sec);
    }
    const i = src.indexOf(ac);
    const j = src.indexOf(kapa);
    src = src.slice(0, i + ac.length) + "\n" + d.html() + "\n" + src.slice(j);
  });
  fs.writeFileSync(p, src, "utf8");
});

console.log(yazilan + " detay sayfasi uretildi; liste kartlari guncellendi.");
