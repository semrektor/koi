/**
 * Taslak siteden WordPress temasini uretir.
 *   build/partials + build/pages + build/content + build/wp  ->  wordpress/koi/
 *
 * - build/wp/        : elle yazilan PHP dosyalari (aynen kopyalanir)
 * - header/footer    : build/partials'tan uretilir
 * - sayfalar/*.php   : build/pages'teki sayfa govdelerinden uretilir
 * - veri/*.json      : kurulum sihirbazinin kullandigi icerik
 *
 * Kullanim: node build/generate-pages.js && node build/apply-images.js && node build/wp-tema.js
 */
const fs = require("fs");
const path = require("path");

const KOK = path.join(__dirname, "..");
const PAGES = path.join(__dirname, "pages");
const KAYNAK = path.join(__dirname, "wp");
const SITE = path.join(KOK, "site");
const CIKTI = path.join(KOK, "wordpress", "koi");

const hizmetler = require("./content/hizmetler");
const atolyeler = require("./content/atolyeler");
const blog = require("./content/blog");

/* WordPress sayfasi olacak govdeler: anahtar (taslak dosya adi) -> sayfa bilgisi */
const SAYFALAR = [
  { anahtar: "index", slug: "anasayfa", baslik: "Anasayfa" },
  { anahtar: "hakkimizda", slug: "hakkimizda", baslik: "Hakkımızda" },
  { anahtar: "hizmetler", slug: "hizmetler", baslik: "Hizmetler" },
  { anahtar: "oyun-gruplari", slug: "oyun-gruplari", baslik: "Oyun Grupları" },
  { anahtar: "atolyeler", slug: "atolyeler", baslik: "Atölyeler" },
  { anahtar: "uzmanlarimiz", slug: "uzmanlarimiz", baslik: "Uzmanlarımız" },
  { anahtar: "blog", slug: "blog", baslik: "Blog" },
  { anahtar: "iletisim", slug: "iletisim", baslik: "İletişim" },
  { anahtar: "galeri", slug: "galeri", baslik: "Galeri" },
  { anahtar: "kvkk", slug: "kvkk", baslik: "KVKK Aydınlatma Metni" },
  { anahtar: "gizlilik", slug: "gizlilik", baslik: "Gizlilik Politikası" },
  { anahtar: "cerez", slug: "cerez", baslik: "Çerez Politikası" },
];
/* Sayfasi olmayan ama govdesi kullanilan sablonlar */
const EK_GOVDELER = ["404"];

/* Sayfadaki formun turu (inc/formlar.php ile ayni anahtarlar) */
const FORM_TURU = { iletisim: "iletisim", "oyun-gruplari": "oyun-grubu", blog: "bulten" };

const KORUMA = "<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>\n";

/* ---------- Dosya yardimcilari ---------- */
function yaz(gorecel, icerik) {
  const tam = path.join(CIKTI, gorecel);
  fs.mkdirSync(path.dirname(tam), { recursive: true });
  fs.writeFileSync(tam, icerik);
}

function kopyala(kaynak, hedef) {
  for (const f of fs.readdirSync(kaynak, { withFileTypes: true })) {
    const k = path.join(kaynak, f.name);
    const h = path.join(hedef, f.name);
    if (f.isDirectory()) {
      fs.mkdirSync(h, { recursive: true });
      kopyala(k, h);
    } else {
      fs.mkdirSync(path.dirname(h), { recursive: true });
      fs.copyFileSync(k, h);
    }
  }
}

function meta(src, key, fallback) {
  const m = src.match(new RegExp("<!--\\s*" + key + ":([\\s\\S]*?)-->"));
  return m ? m[1].trim() : fallback;
}

const phpMetin = (t) => "'" + String(t).replace(/\\/g, "\\\\").replace(/'/g, "\\'") + "'";

/* ---------- HTML -> PHP sablonu ---------- */
const DEGISIMLER = [
  /* Iletisim bilgileri Ozellestirici'den okunur */
  ['href="https://wa.me/900000000000"', 'href="<?php echo esc_url( koi_wa_url() ); ?>"'],
  ['href="tel:+900000000000"', 'href="<?php echo esc_url( koi_tel_url() ); ?>"'],
  ['href="mailto:info@koiailem.com"', "href=\"<?php echo esc_url( 'mailto:' . koi_ayar( 'eposta' ) ); ?>\""],
  ['href="mailto:iletisim@koiailem.com"', "href=\"<?php echo esc_url( 'mailto:' . koi_ayar( 'eposta2' ) ); ?>\""],
  ['href="https://www.instagram.com/koiworld/"', "href=\"<?php echo esc_url( koi_ayar( 'instagram' ) ); ?>\""],
  ["+90 (000) 000 00 00", "<?php echo esc_html( koi_ayar( 'telefon' ) ); ?>"],
  [">info@koiailem.com<", "><?php echo esc_html( koi_ayar( 'eposta' ) ); ?><"],
  [">iletisim@koiailem.com<", "><?php echo esc_html( koi_ayar( 'eposta2' ) ); ?><"],
  ["Necip Fazıl Mah. — Ümraniye / İstanbul", "<?php echo esc_html( koi_ayar( 'adres' ) ); ?>"],
  ["Hafta içi 09:00 – 19:00", "<?php echo esc_html( koi_ayar( 'saat1' ) ); ?>"],
  ["Hafta sonu: program takvimine göre", "<?php echo esc_html( koi_ayar( 'saat2' ) ); ?>"],
];

function phpLestir(html, anahtar) {
  if (html.includes("<?")) throw new Error(anahtar + ": govdede '<?' var; PHP'ye cevrilemez");

  /* Kart bloklari veritabanindan gelir */
  html = html.replace(/[ \t]*<!--CARDS:([a-z0-9-]+)-->[\s\S]*?<!--\/CARDS:\1-->/g, "<?php koi_kartlar( '$1' ); ?>");

  /* Blog sayfasindaki one cikan yazi */
  if (anahtar === "blog") {
    const once = html;
    html = html.replace(/[ \t]*<article class="split reveal"[\s\S]*?<\/article>/, "<?php koi_one_cikan_yazi(); ?>");
    if (html === once) throw new Error("blog: one cikan yazi blogu bulunamadi");
  }

  /* Formlar: taslak isareti yerine gercek gonderim */
  const tur = FORM_TURU[anahtar];
  html = html.replace(/<form([^>]*?)\sdata-demo-form([^>]*)>/g, (tam, a, b) => {
    if (!tur) throw new Error(anahtar + ": form var ama FORM_TURU tanimli degil");
    return (
      "<form" + a + b + ' id="talep-formu" method="post" action="<?php echo esc_url( admin_url( \'admin-post.php\' ) ); ?>">\n' +
      "<?php koi_form_gizli( '" + tur + "' ); ?>"
    );
  });
  html = html.replace(/<p class="form-note">([\s\S]*?)<\/p>/g, (tam, metin) => {
    const sade = metin.replace(/\s*Taslak önizleme:[\s\S]*$/, "").trim();
    return "<?php koi_form_notu( " + phpMetin(sade) + " ); ?>";
  });
  html = html.replace('id="bulten-mail" type="email"', 'id="bulten-mail" name="eposta" type="email"');

  /* Yonetim paneli baglantisi temada yer almaz (giris: /wp-admin) */
  html = html.replace(/\s*<a href="yonetim-giris\.html">[^<]*<\/a>/g, "");

  /* Sayfa baglantilari ve tema varliklari */
  html = html.replace(/href="([a-z0-9-]+)\.html(#[^"]*)?"/g, (tam, ad, capa) =>
    "href=\"<?php echo esc_url( koi_url( '" + ad + "' ) ); ?>" + (capa || "") + '"'
  );
  html = html.replace(/(?<=["\s,(])assets\/(?=(?:img|css|js)\/)/g, "<?php koi_v(); ?>");

  for (const [eski, yeni] of DEGISIMLER) html = html.split(eski).join(yeni);
  return html;
}

function govde(dosya) {
  return fs
    .readFileSync(path.join(PAGES, dosya), "utf8")
    .replace(/<!--\s*(title|desc|nav|layout|pagetitle|pagesub|topaction):[\s\S]*?-->\s*/g, "")
    .replace(/<!--generated-->\s*/g, "")
    .trim();
}

/* ---------- Icerik -> blok editoru HTML'i ---------- */
function blokHtml(bolumler, alinti) {
  const b = [];
  const p = (t) => "<!-- wp:paragraph -->\n<p>" + t + "</p>\n<!-- /wp:paragraph -->";
  const q = (t) =>
    '<!-- wp:quote -->\n<blockquote class="wp-block-quote">' + p(t) + "</blockquote>\n<!-- /wp:quote -->";
  for (const x of bolumler) {
    if (x.h) b.push('<!-- wp:heading -->\n<h2 class="wp-block-heading">' + x.h + "</h2>\n<!-- /wp:heading -->");
    (x.p || []).forEach((t) => b.push(p(t)));
    if (x.liste) {
      b.push(
        '<!-- wp:list -->\n<ul class="wp-block-list">' +
          x.liste.map((t) => "<!-- wp:list-item -->\n<li>" + t + "</li>\n<!-- /wp:list-item -->").join("\n") +
          "</ul>\n<!-- /wp:list -->"
      );
    }
    if (x.alinti) b.push(q(x.alinti));
  }
  if (alinti) b.push(q(alinti));
  return b.join("\n\n");
}

/* Liste sayfasindaki filtre dugmelerinden terim adlarini okur: { cocuk: "Çocuk ve Ergen", ... } */
function filtreAdlari(dosya) {
  const src = fs.readFileSync(path.join(PAGES, dosya), "utf8");
  const adlar = {};
  for (const m of src.matchAll(/data-filter="([a-z0-9-]+)"[^>]*>([^<]+)</g)) adlar[m[1]] = m[2].trim();
  return adlar;
}

const TUR_ONEKI = { hizmet: "hizmet-", atolye: "atolye-", post: "blog-" };
function ilgiliListe(slugs) {
  return (slugs || [])
    .map((s) => {
      for (const [tur, onek] of Object.entries(TUR_ONEKI)) {
        if (s.startsWith(onek)) return tur + ":" + s.slice(onek.length);
      }
      return "";
    })
    .filter(Boolean)
    .join(",");
}

function kayit(x, tur, terimAdlari) {
  return {
    slug: x.slug.slice(TUR_ONEKI[tur].length),
    baslik: x.baslik,
    kisa: x.kisa,
    lead: x.lead || "",
    gorsel: x.gorsel || "",
    cat: x.cat || "",
    terim: terimAdlari[x.cat] || x.kategori || x.cat || "",
    etiket: tur === "post" ? "" : x.kategori || "",
    bilgi: (x.bilgi || []).map(([k, v]) => k + ": " + v).join("\n"),
    rozetler: (x.rozetler || []).join(", "),
    yazar: x.yazar || "",
    one_cikan: !!x.one_cikan,
    ilgili: ilgiliListe(x.ilgili),
    icerik: blokHtml(x.bolumler || [], x.alinti),
  };
}

/* ---------- Uretim ---------- */
fs.rmSync(CIKTI, { recursive: true, force: true });
fs.mkdirSync(CIKTI, { recursive: true });

/* 1. Elle yazilan PHP dosyalari */
kopyala(KAYNAK, CIKTI);

/* 2. Tasarim varliklari */
fs.mkdirSync(path.join(CIKTI, "assets", "js"), { recursive: true });
fs.copyFileSync(path.join(SITE, "assets", "css", "style.css"), path.join(CIKTI, "assets", "css", "style.css"));
fs.copyFileSync(path.join(SITE, "assets", "js", "main.js"), path.join(CIKTI, "assets", "js", "main.js"));
kopyala(path.join(SITE, "assets", "img"), path.join(CIKTI, "assets", "img"));

/* 3. Tema kimligi */
yaz(
  "style.css",
  [
    "/*",
    "Theme Name: KOI",
    "Theme URI: https://koiailem.com",
    "Description: KOI | Çocuk ve Aile Gelişim Merkezi için sıfırdan tasarlanmış özel tema.",
    "Version: 0.1.0",
    "Requires at least: 6.4",
    "Requires PHP: 7.4",
    "Text Domain: koi",
    "*/",
    "",
    "/* Tasarim sistemi assets/css/style.css icindedir. */",
    "",
  ].join("\n")
);

/* 4. header.php / footer.php */
const head = fs.readFileSync(path.join(__dirname, "partials", "head.html"), "utf8");
const foot = fs.readFileSync(path.join(__dirname, "partials", "foot.html"), "utf8");

const bodyBas = head.indexOf("<body>");
if (bodyBas < 0) throw new Error("head.html: <body> bulunamadi");
const ust = phpLestir(head.slice(bodyBas + "<body>".length), "header").replace(
  /data-nav="([a-z0-9-]+)"/g,
  "data-nav=\"$1\"<?php koi_aktif( '$1' ); ?>"
);
yaz(
  "header.php",
  KORUMA +
    "<!DOCTYPE html>\n<html <?php language_attributes(); ?>>\n<head>\n" +
    "<meta charset=\"<?php bloginfo( 'charset' ); ?>\">\n" +
    '<meta name="viewport" content="width=device-width, initial-scale=1">\n' +
    "<?php wp_head(); ?>\n</head>\n<body <?php body_class(); ?>>\n<?php wp_body_open(); ?>\n" +
    ust.trimStart()
);

let alt = foot.replace(/\s*<script src="assets\/js\/main\.js"><\/script>/, "");
if (!alt.includes("</body>")) throw new Error("foot.html: </body> bulunamadi");
alt = phpLestir(alt, "footer").replace("</body>", "<?php wp_footer(); ?>\n</body>");
yaz("footer.php", KORUMA + alt);

/* 5. Sayfa govdeleri */
const sayfaMeta = {};
for (const s of SAYFALAR) {
  const dosya = s.anahtar + ".html";
  const ham = fs.readFileSync(path.join(PAGES, dosya), "utf8");
  sayfaMeta[s.anahtar] = { seo_baslik: meta(ham, "title", ""), aciklama: meta(ham, "desc", "") };
  yaz("sayfalar/" + s.anahtar + ".php", KORUMA + phpLestir(govde(dosya), s.anahtar) + "\n");
}
for (const anahtar of EK_GOVDELER) {
  const ham = fs.readFileSync(path.join(PAGES, anahtar + ".html"), "utf8");
  sayfaMeta[anahtar] = { seo_baslik: meta(ham, "title", ""), aciklama: "" };
  yaz("sayfalar/" + anahtar + ".php", KORUMA + phpLestir(govde(anahtar + ".html"), anahtar) + "\n");
}

/* 6. Veri */
yaz("veri/sayfalar.json", JSON.stringify(sayfaMeta, null, 1));
yaz(
  "veri/icerik.json",
  JSON.stringify(
    {
      sayfalar: SAYFALAR,
      hizmetler: hizmetler.map((x) => kayit(x, "hizmet", filtreAdlari("hizmetler.html"))),
      atolyeler: atolyeler.map((x) => kayit(x, "atolye", filtreAdlari("atolyeler.html"))),
      blog: blog.map((x) => kayit(x, "post", filtreAdlari("blog.html"))),
    },
    null,
    1
  )
);

/* 7. Kontrol: PHP'ye cevrilmemis taslak kalintisi kalmasin */
const KALINTI = [/\.html["#]/, /data-demo-form/, /Taslak önizleme/, /wa\.me\/9000/, /["\s,(]assets\/(img|css|js)\//, /CARDS:/];
let sorun = 0;
(function tara(d) {
  for (const f of fs.readdirSync(d, { withFileTypes: true })) {
    const p = path.join(d, f.name);
    if (f.isDirectory()) tara(p);
    else if (f.name.endsWith(".php")) {
      const m = fs.readFileSync(p, "utf8");
      for (const k of KALINTI) {
        const e = m.match(k);
        if (e) {
          console.log("  ! " + path.relative(CIKTI, p) + ": " + k + "  ->  " + m.slice(Math.max(0, e.index - 40), e.index + 50).replace(/\s+/g, " "));
          sorun++;
        }
      }
    }
  }
})(CIKTI);

let dosyaSayisi = 0;
(function say(d) {
  for (const f of fs.readdirSync(d, { withFileTypes: true })) f.isDirectory() ? say(path.join(d, f.name)) : dosyaSayisi++;
})(CIKTI);

console.log("wordpress/koi: " + dosyaSayisi + " dosya, " + SAYFALAR.length + " sayfa govdesi, " +
  hizmetler.length + " hizmet, " + atolyeler.length + " atolye, " + blog.length + " yazi" +
  (sorun ? "  |  " + sorun + " KALINTI" : "  |  kalinti yok"));
if (sorun) process.exit(1);
