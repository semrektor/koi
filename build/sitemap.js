/**
 * site/ altindaki genel sayfalardan sitemap.xml uretir.
 * Yonetim paneli sayfalari disarida birakilir.
 *
 * Kullanim: node build/sitemap.js [site-adresi]
 */
const fs = require("fs");
const path = require("path");

const OUT = path.join(__dirname, "..", "site");
const BASE = (process.argv[2] || "https://koimerkezi.com").replace(/\/$/, "");

/* Arama motorlarina acilmayacak sayfalar */
const HARIC = /^yonetim/;

/* Oncelik: ana sayfa > ust sayfalar > detay sayfalari */
function oncelik(slug) {
  if (slug === "index") return "1.0";
  if (["hakkimizda", "hizmetler", "oyun-gruplari", "atolyeler", "uzmanlarimiz", "blog", "iletisim", "galeri"].includes(slug))
    return "0.9";
  if (["kvkk", "gizlilik", "cerez"].includes(slug)) return "0.3";
  return "0.7";
}

const bugun = new Date().toISOString().slice(0, 10);

const sayfalar = fs
  .readdirSync(OUT)
  .filter((f) => f.endsWith(".html"))
  .map((f) => f.replace(/\.html$/, ""))
  .filter((slug) => !HARIC.test(slug))
  .sort((a, b) => (a === "index" ? -1 : b === "index" ? 1 : a.localeCompare(b, "tr")));

const xml =
  '<?xml version="1.0" encoding="UTF-8"?>\n' +
  '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n' +
  sayfalar
    .map(
      (slug) =>
        "  <url>\n" +
        "    <loc>" + BASE + (slug === "index" ? "/" : "/" + slug + ".html") + "</loc>\n" +
        "    <lastmod>" + bugun + "</lastmod>\n" +
        "    <priority>" + oncelik(slug) + "</priority>\n" +
        "  </url>"
    )
    .join("\n") +
  "\n</urlset>\n";

fs.writeFileSync(path.join(OUT, "sitemap.xml"), xml, "utf8");

/* robots.txt icindeki sitemap adresini guncel tut */
const robots = path.join(OUT, "robots.txt");
if (fs.existsSync(robots)) {
  const r = fs.readFileSync(robots, "utf8").replace(/^Sitemap:.*$/m, "Sitemap: " + BASE + "/sitemap.xml");
  fs.writeFileSync(robots, r, "utf8");
}

console.log("sitemap.xml: " + sayfalar.length + " sayfa (" + BASE + ")");
