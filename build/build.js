/**
 * KOI taslak site derleyicisi
 * build/pages/<slug>.html  ->  site/<slug>.html
 * Ortak parcalar: build/partials/head.html + foot.html
 *
 * Kullanim: node build/build.js
 */
const fs = require("fs");
const path = require("path");

const ROOT = path.join(__dirname, "..");
const PAGES = path.join(__dirname, "pages");
const OUT = path.join(ROOT, "site");

const P = (f) => fs.readFileSync(path.join(__dirname, "partials", f), "utf8");

/* Iki yerlesim var: site (varsayilan) ve yonetim paneli (layout: admin) */
const LAYOUTS = {
  site: { head: P("head.html"), foot: P("foot.html") },
  admin: { head: P("admin-head.html"), foot: P("admin-foot.html") },
};
const head = LAYOUTS.site.head;
const foot = LAYOUTS.site.foot;

function meta(src, key, fallback) {
  const m = src.match(new RegExp("<!--\\s*" + key + ":([\\s\\S]*?)-->"));
  return m ? m[1].trim() : fallback;
}

/* ---------- Varlik surumleme ----------
   assets/ altindaki dosyalar uzun sureli onbelleklenir. Ayni adla
   guncellenen bir gorsel ziyaretcide eski haliyle kalmasin diye her
   referansa dosya icerigine dayali kisa bir surum eklenir:
   assets/img/logo.webp -> assets/img/logo.webp?v=8c9e82 */
const crypto = require("crypto");
const surumOnbellek = new Map();

function varlikSurumu(gorecelYol) {
  if (surumOnbellek.has(gorecelYol)) return surumOnbellek.get(gorecelYol);
  const tam = path.join(OUT, gorecelYol);
  let s = "";
  try {
    s = crypto.createHash("md5").update(fs.readFileSync(tam)).digest("hex").slice(0, 8);
  } catch (e) {
    s = ""; // dosya yoksa surum eklenmez
  }
  surumOnbellek.set(gorecelYol, s);
  return s;
}

function surumle(html) {
  return html.replace(/(assets\/[A-Za-z0-9._\/-]+\.(?:webp|png|jpg|jpeg|svg|css|js))(?=["'\s,)])/g, (tam, yol) => {
    const s = varlikSurumu(yol);
    return s ? yol + "?v=" + s : yol;
  });
}

const files = fs.readdirSync(PAGES).filter((f) => f.endsWith(".html"));
let count = 0;

files.forEach((file) => {
  const slug = file.replace(/\.html$/, "");
  const src = fs.readFileSync(path.join(PAGES, file), "utf8");

  const title = meta(src, "title", "KOI | Çocuk ve Aile Gelişim Merkezi");
  const desc = meta(src, "desc", "KOI Çocuk ve Aile Gelişim Merkezi");
  const navKey = meta(src, "nav", slug);
  const layoutKey = meta(src, "layout", "site");
  const layout = LAYOUTS[layoutKey] || LAYOUTS.site;
  const body = src
    .replace(/<!--\s*(title|desc|nav|layout|pagetitle|pagesub|topaction):[\s\S]*?-->\s*/g, "")
    .replace(/<!--generated-->\s*/g, "");

  let page = layout.head.replace(/\{\{TITLE\}\}/g, title).replace(/\{\{DESC\}\}/g, desc);

  if (layoutKey === "admin") {
    page = page
      .replace(/\{\{PAGETITLE\}\}/g, meta(src, "pagetitle", title))
      .replace(/\{\{PAGESUB\}\}/g, meta(src, "pagesub", ""))
      .replace(/\{\{TOPACTION\}\}/g, meta(src, "topaction", ""))
      .replace('data-anav="' + navKey + '"', 'data-anav="' + navKey + '" aria-current="page"');
  } else {
    page = page.replace(
      'data-nav="' + navKey + '"',
      'data-nav="' + navKey + '" aria-current="page"'
    );
  }

  fs.writeFileSync(
    path.join(OUT, slug + ".html"),
    surumle(page + "\n" + body.trim() + "\n\n" + layout.foot),
    "utf8"
  );
  count++;
  console.log("  ok  site/" + slug + ".html");
});

/* Derleme disinda tutulan sayfa (giris ekrani) da surumlenir */
const ELLE = ["yonetim-giris.html"];
ELLE.forEach((f) => {
  const p = path.join(OUT, f);
  if (!fs.existsSync(p)) return;
  const ham = fs.readFileSync(p, "utf8").replace(/(assets\/[A-Za-z0-9._\/-]+\.(?:webp|png|jpg|jpeg|svg|css|js))\?v=[a-f0-9]+/g, "$1");
  fs.writeFileSync(p, surumle(ham), "utf8");
  console.log("  ok  site/" + f + " (surumlendi)");
});

console.log("\n" + count + " sayfa derlendi.");
