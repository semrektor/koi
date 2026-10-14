/**
 * Taslak sayfa govdelerinden, WordPress panelinden duzenlenebilecek alanlari cikarir.
 *
 * Basliklar, paragraflar, ust yazilar, dugme yazilari, duz madde listeleri ve
 * gorseller birer "alan" olur. Govdede yerlerine yer tutucu konur:
 *   ⟦A:kimlik⟧  metin        ⟦I:kimlik⟧  onizleme isareti (acilis etiketinde)
 *   ⟦L:kimlik⟧  liste        ⟦G:kimlik⟧  gorsel
 *   ⟦M:anahtar⟧ yasal metin sayfasinin govdesi (sayfa duzenleyicisinden gelir)
 * wp-tema.js bunlari PHP cagrilarina cevirir; varsayilan metinler veri/alanlar.json'a yazilir.
 *
 * Kimlikler <sayfa>-<bolum no>-<tur><sira> bicimindedir (or. index-3-paragraf2).
 * Bolum numarasi sayfadaki ust duzey <section> sirasidir. Bir bolume yeni oge
 * eklenirken sona eklenmesi, kayitli metinlerin yer degistirmemesini saglar;
 * gerekirse ogeye data-alan="ad" yazilarak sabit kimlik verilebilir.
 */

/* ---------- Kucuk HTML ayristirici (bagimliliksiz) ---------- */
const BOS_ETIKETLER = new Set(["area", "base", "br", "col", "embed", "hr", "img", "input", "link", "meta", "source", "track", "wbr"]);

function ayristir(html) {
  const kok = { tip: "kok", cocuklar: [], bas: 0, acilisSon: 0, kapanisBas: html.length, son: html.length };
  const yigin = [kok];
  const ust = () => yigin[yigin.length - 1];
  let i = 0;
  while (i < html.length) {
    if (html.startsWith("<!--", i)) {
      const j = html.indexOf("-->", i + 4);
      const son = j < 0 ? html.length : j + 3;
      ust().cocuklar.push({ tip: "yorum", bas: i, son, metin: html.slice(i + 4, son - 3).trim() });
      i = son;
      continue;
    }
    if (html[i] === "<" && html[i + 1] === "/") {
      const j = html.indexOf(">", i);
      const ad = html.slice(i + 2, j).trim().toLowerCase();
      for (let k = yigin.length - 1; k > 0; k--) {
        if (yigin[k].ad === ad) {
          while (yigin.length > k) {
            const d = yigin.pop();
            d.kapanisBas = d.ad === ad ? i : i;
            d.son = j + 1;
          }
          break;
        }
      }
      i = j + 1;
      continue;
    }
    if (html[i] === "<" && /[a-zA-Z]/.test(html[i + 1] || "")) {
      let j = i + 1;
      let tirnak = null;
      while (j < html.length) {
        const c = html[j];
        if (tirnak) {
          if (c === tirnak) tirnak = null;
        } else if (c === '"' || c === "'") tirnak = c;
        else if (c === ">") break;
        j++;
      }
      const ic = html.slice(i + 1, j);
      const ad = ic.match(/^[a-zA-Z0-9-]+/)[0].toLowerCase();
      const d = { tip: "el", ad, bas: i, acilisSon: j + 1, ozellik: ic.slice(ad.length), cocuklar: [], ebeveyn: ust() };
      ust().cocuklar.push(d);
      if (BOS_ETIKETLER.has(ad) || ic.endsWith("/")) {
        d.kapanisBas = d.son = j + 1;
      } else {
        yigin.push(d);
      }
      i = j + 1;
      continue;
    }
    let j = html.indexOf("<", i + 1);
    if (j < 0) j = html.length;
    ust().cocuklar.push({ tip: "metin", bas: i, son: j });
    i = j;
  }
  while (yigin.length > 1) {
    const d = yigin.pop();
    d.kapanisBas = d.son = html.length;
  }
  return kok;
}

const ozellikDegeri = (d, ad) => {
  const m = (d.ozellik || "").match(new RegExp("\\s" + ad + '\\s*=\\s*"([^"]*)"', "i"));
  return m ? m[1] : null;
};
const siniflar = (d) => (ozellikDegeri(d, "class") || "").split(/\s+/).filter(Boolean);
const sinifVar = (d, s) => siniflar(d).includes(s);

/* Kart bloklari (<!--CARDS:..--> ... <!--/CARDS:..-->) veritabanindan uretildigi icin atlanir */
function cocuklar(d) {
  const liste = [];
  let kartta = false;
  for (const c of d.cocuklar) {
    if (c.tip === "yorum") {
      if (/^CARDS:/.test(c.metin)) kartta = true;
      else if (/^\/CARDS:/.test(c.metin)) kartta = false;
      continue;
    }
    if (!kartta) liste.push(c);
  }
  return liste;
}

/* ---------- Metin donusumleri ---------- */
const VARLIKLAR = { amp: "&", lt: "<", gt: ">", quot: '"', "#39": "'", "#039": "'", nbsp: " ", hellip: "…", mdash: "—", ndash: "–" };
const varlikCoz = (t) => t.replace(/&(#?[a-z0-9]+);/gi, (tam, ad) => (ad.toLowerCase() in VARLIKLAR ? VARLIKLAR[ad.toLowerCase()] : tam));

/* Ic HTML -> paneldeki yazim bicimi: <br> yeni satir, <em> *yildiz*, <strong> **cift yildiz** */
function isaretle(ic) {
  const SATIR = "\u0000";
  let t = ic.replace(/<br\s*\/?>/gi, SATIR);
  t = t.replace(/<(strong|b)\b[^>]*>([\s\S]*?)<\/\1>/gi, "**$2**");
  t = t.replace(/<(em|i)\b[^>]*>([\s\S]*?)<\/\1>/gi, "*$2*");
  t = t.replace(/<[^>]+>/g, "");
  t = varlikCoz(t).replace(/\s+/g, " ").trim();
  return t
    .split(SATIR)
    .map((s) => s.trim())
    .join("\n");
}

const duzMetin = (t) => t.replace(/\*+/g, "").replace(/\s*\n\s*/g, " ").trim();

/* ---------- Yasal metin sayfalari: govde blok duzenleyicisine tasinir ---------- */
function bloklara(ic) {
  const kok = ayristir(ic);
  const bloklar = [];
  for (const c of kok.cocuklar) {
    if (c.tip !== "el") continue;
    const icHtml = ic.slice(c.acilisSon, c.kapanisBas).trim();
    if (/^h[2-4]$/.test(c.ad)) {
      const seviye = Number(c.ad[1]);
      bloklar.push(
        "<!-- wp:heading" + (seviye !== 2 ? ' {"level":' + seviye + "}" : "") + " -->\n" +
          "<" + c.ad + ' class="wp-block-heading">' + icHtml + "</" + c.ad + ">\n<!-- /wp:heading -->"
      );
    } else if (c.ad === "p" && !c.ozellik.trim()) {
      bloklar.push("<!-- wp:paragraph -->\n<p>" + icHtml + "</p>\n<!-- /wp:paragraph -->");
    } else if ((c.ad === "ul" || c.ad === "ol") && !c.ozellik.trim()) {
      const maddeler = c.cocuklar
        .filter((x) => x.tip === "el" && x.ad === "li")
        .map((li) => "<!-- wp:list-item -->\n<li>" + ic.slice(li.acilisSon, li.kapanisBas).trim() + "</li>\n<!-- /wp:list-item -->");
      bloklar.push(
        "<!-- wp:list" + (c.ad === "ol" ? ' {"ordered":true}' : "") + " -->\n" +
          "<" + c.ad + ' class="wp-block-list">' + maddeler.join("\n") + "</" + c.ad + ">\n<!-- /wp:list -->"
      );
    } else {
      bloklar.push("<!-- wp:html -->\n" + ic.slice(c.bas, c.son).trim() + "\n<!-- /wp:html -->");
    }
  }
  return bloklar.join("\n\n");
}

/* <div class="prose ..."> icerigini ayirir; yerine ⟦M:anahtar⟧ konur */
function metniAyir(html, anahtar) {
  const kok = ayristir(html);
  let bulunan = null;
  (function ara(d) {
    for (const c of d.cocuklar) {
      if (bulunan || c.tip !== "el") continue;
      if (c.ad === "div" && sinifVar(c, "prose")) bulunan = c;
      else ara(c);
    }
  })(kok);
  if (!bulunan) throw new Error(anahtar + ": prose bolumu bulunamadi");
  const ic = html.slice(bulunan.acilisSon, bulunan.kapanisBas);
  return {
    html: html.slice(0, bulunan.acilisSon) + "\n⟦M:" + anahtar + "⟧\n    " + html.slice(bulunan.kapanisBas),
    bloklar: bloklara(ic),
  };
}

/* ---------- Alan cikarma ---------- */
const METIN_ETIKETLERI = new Set(["h1", "h2", "h3", "h4", "p", "span", "blockquote", "cite", "li", "strong"]);
const SATIR_ICI = new Set(["br", "em", "strong", "b", "i"]);
const HARIC_ETIKETLER = new Set(["svg", "select", "button", "nav", "table", "script", "style", "textarea", "label", "input", "img"]);
const HARIC_SINIFLAR = ["breadcrumb", "filters", "form-note", "form-grid", "field", "value__num", "timeline__when", "post__meta", "accordion"];

/* tur -> [kimlikteki ad, paneldeki etiket] */
function turBul(d) {
  if (sinifVar(d, "eyebrow")) return ["ust", "Üst yazı"];
  if (d.ad === "h1" || d.ad === "h2") return ["baslik", "Başlık"];
  if (d.ad === "h3" || d.ad === "h4") return ["ara", "Ara başlık"];
  if (d.ad === "blockquote") return ["alinti", "Alıntı"];
  if (d.ad === "cite") return ["kaynak", "Alıntı kaynağı"];
  if (sinifVar(d, "lead")) return ["giris", "Giriş metni"];
  if (sinifVar(d, "hero__note") || sinifVar(d, "muted")) return ["not", "Not"];
  if (d.ad === "li" || (d.ad === "span" && d.ebeveyn && d.ebeveyn.ad === "li")) return ["madde", "Madde"];
  if (d.ad === "strong") return ["kalin", "Kalın başlık"];
  if (d.ad === "p") return ["paragraf", "Paragraf"];
  return ["metin", "Metin"];
}

function alanlariCikar(html, sayfa, secenek = {}) {
  const korunan = secenek.korunan || [];
  const haricEk = secenek.haric || (() => false);
  const kok = ayristir(html);
  const duzenler = []; /* { bas, son, metin, sira } */
  const bolumler = [];
  let ust = null;

  const ic = (d) => html.slice(d.acilisSon, d.kapanisBas);
  const sade = (d) => d.cocuklar.every((c) => c.tip === "metin" || (c.tip === "el" && SATIR_ICI.has(c.ad) && sade(c)));
  const metniVar = (d) => duzMetin(isaretle(ic(d))) !== "";
  const korunuyor = (metin) => korunan.some((k) => k && metin.includes(k));
  const yaprakMi = (d) => METIN_ETIKETLERI.has(d.ad) && sade(d) && metniVar(d) && !korunuyor(ic(d));
  const haricMi = (d) => HARIC_ETIKETLER.has(d.ad) || HARIC_SINIFLAR.some((s) => sinifVar(d, s)) || haricEk(d, siniflar(d));

  /* Bir li icindeki tek metin yapragi (li'nin kendisi ya da icindeki span) */
  function maddeYapragi(li) {
    if (yaprakMi(li)) return li;
    const bulunan = [];
    let baglanti = false;
    (function ara(d) {
      for (const c of d.cocuklar) {
        if (c.tip !== "el") continue;
        if (c.ad === "a") baglanti = true;
        if (yaprakMi(c)) bulunan.push(c);
        else ara(c);
      }
    })(li);
    return !baglanti && bulunan.length === 1 ? bulunan[0] : null;
  }

  /* Butun maddeleri ayni kaliptaysa liste tek alan olur (her satira bir madde) */
  function listeKalibi(d) {
    const ogeler = cocuklar(d).filter((c) => !(c.tip === "metin" && !html.slice(c.bas, c.son).trim()));
    if (ogeler.length < 2 || !ogeler.every((c) => c.tip === "el" && c.ad === "li")) return null;
    let kalip = null;
    const maddeler = [];
    for (const li of ogeler) {
      const y = maddeYapragi(li);
      if (!y) return null;
      const bicim = html.slice(li.bas, y.acilisSon) + "§" + html.slice(y.kapanisBas, li.son);
      if (kalip !== null && bicim !== kalip) return null;
      kalip = bicim;
      maddeler.push(isaretle(ic(y)));
    }
    return { kalip, maddeler };
  }

  function gorselMi(d) {
    if (d.ad !== "div" || !sinifVar(d, "media") || sinifVar(d, "media--mono")) return false;
    const resimler = [];
    (function ara(x) {
      for (const c of x.cocuklar) if (c.tip === "el") (c.ad === "img" ? resimler.push(c) : ara(c));
    })(d);
    return resimler.length === 0 || (resimler.length === 1 && sinifVar(resimler[0], "media__img"));
  }

  function gez(d, b) {
    if (haricMi(d)) return;
    if (gorselMi(d)) return gorselEkle(d, b);
    if (d.ad === "ul" || d.ad === "ol") {
      const liste = listeKalibi(d);
      if (liste) return listeEkle(d, b, liste);
    }
    if (d.ad === "a") {
      if (sinifVar(d, "btn") || sinifVar(d, "link-arrow")) dugmeEkle(d, b);
      return;
    }
    if (yaprakMi(d)) return metinEkle(d, b);
    for (const c of cocuklar(d)) if (c.tip === "el") gez(c, b);
  }

  function kimlikVer(d, b, ad) {
    const sabit = ozellikDegeri(d, "data-alan");
    if (sabit) return sayfa + "-" + sabit;
    b.sayac[ad] = (b.sayac[ad] || 0) + 1;
    return sayfa + "-" + b.no + "-" + ad + b.sayac[ad];
  }

  function isaretKoy(d, kimlik) {
    const kapanis = html[d.acilisSon - 2] === "/" ? d.acilisSon - 2 : d.acilisSon - 1;
    duzenler.push({ bas: kapanis, son: kapanis, metin: "⟦I:" + kimlik + "⟧" });
  }

  function metinEkle(d, b) {
    const [ad, etiket] = turBul(d);
    const kimlik = kimlikVer(d, b, ad);
    const v = isaretle(ic(d));
    b.alanlar.push({ id: kimlik, tur: ad, etiket, v, kontrol: /\n/.test(v) || v.length > 70 || ["giris", "paragraf", "alinti"].includes(ad) ? "textarea" : "text", etiket_ad: d.ad, sinif: siniflar(d) });
    isaretKoy(d, kimlik);
    duzenler.push({ bas: d.acilisSon, son: d.kapanisBas, metin: "⟦A:" + kimlik + "⟧" });
  }

  function dugmeEkle(d, b) {
    /* Yalnizca "yazi + (ok simgesi)" bicimindeki dugmeler */
    const ogeler = d.cocuklar.filter((c) => !(c.tip === "metin" && !html.slice(c.bas, c.son).trim()));
    if (!ogeler.length || ogeler[0].tip !== "metin") return;
    if (ogeler.slice(1).some((c) => c.tip !== "el" || c.ad !== "svg")) return;
    const v = isaretle(html.slice(ogeler[0].bas, ogeler[0].son));
    if (!v || korunuyor(v)) return;
    const ad = sinifVar(d, "btn") ? "dugme" : "baglanti";
    const kimlik = kimlikVer(d, b, ad);
    const ek = html.slice(ogeler[0].son, d.kapanisBas).trim();
    b.alanlar.push({ id: kimlik, tur: ad, etiket: ad === "dugme" ? "Düğme yazısı" : "Bağlantı yazısı", v, kontrol: "text", ek });
    isaretKoy(d, kimlik);
    duzenler.push({ bas: d.acilisSon, son: d.kapanisBas, metin: "⟦A:" + kimlik + "⟧" });
  }

  function listeEkle(d, b, liste) {
    const kimlik = kimlikVer(d, b, "liste");
    b.alanlar.push({ id: kimlik, tur: "liste", etiket: "Liste", v: liste.maddeler.join("\n"), kontrol: "textarea", sablon: liste.kalip });
    isaretKoy(d, kimlik);
    duzenler.push({ bas: d.acilisSon, son: d.kapanisBas, metin: "⟦L:" + kimlik + "⟧" });
  }

  function gorselEkle(d, b) {
    const kimlik = kimlikVer(d, b, "gorsel");
    let resim = null;
    (function ara(x) {
      for (const c of x.cocuklar) if (c.tip === "el") (c.ad === "img" ? (resim = c) : ara(c));
    })(d);
    const dis = html.slice(d.bas, d.son);
    b.alanlar.push({
      id: kimlik,
      tur: "gorsel",
      etiket: "Görsel",
      g: {
        sinif: ozellikDegeri(d, "class") || "media",
        etiket: varlikCoz(ozellikDegeri(d, "data-label") || ""),
        stil: ozellikDegeri(d, "style") || "",
        boyut: (resim && ozellikDegeri(resim, "sizes")) || "(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw",
        isaret: /media__mark/.test(dis),
        html: dis.replace(/(["\s,])assets\/(?=img\/)/g, "$1{{V}}"),
      },
    });
    duzenler.push({ bas: d.bas, son: d.son, metin: "⟦G:" + kimlik + "⟧" });
  }

  /* Ust duzey bolumler */
  let no = 0;
  for (const s of cocuklar(kok)) {
    if (s.tip !== "el" || s.ad !== "section") continue;
    no++;
    const b = { no, alanlar: [], sayac: {} };
    for (const c of cocuklar(s)) if (c.tip === "el") gez(c, b);
    if (!b.alanlar.length) continue;

    /* Ayni etiketten birden fazla varsa numaralanir: "Paragraf 1", "Paragraf 2" */
    const say = {};
    b.alanlar.forEach((a) => (say[a.etiket] = (say[a.etiket] || 0) + 1));
    const sira = {};
    b.alanlar.forEach((a) => {
      if (say[a.etiket] > 1) {
        sira[a.etiket] = (sira[a.etiket] || 0) + 1;
        a.etiket += " " + sira[a.etiket];
      }
    });

    const adi = ozellikDegeri(s, "data-bolum");
    const baslik = b.alanlar.find((a) => a.tur === "baslik") || b.alanlar.find((a) => a.tur === "ust") || b.alanlar.find((a) => a.v);
    const kisalt = (t) => (t.length > 60 ? t.slice(0, 57).trimEnd() + "…" : t);
    b.baslik = no + ". " + (adi ? varlikCoz(adi) : baslik ? kisalt(duzMetin(baslik.v)) : "Bölüm");

    if (sinifVar(s, "page-hero")) {
      const h1 = b.alanlar.find((a) => a.etiket_ad === "h1");
      const giris = b.alanlar.find((a) => a.tur === "giris");
      ust = { baslik: h1 ? h1.id : "", giris: giris ? giris.id : "" };
    }
    b.alanlar.forEach((a) => {
      delete a.etiket_ad;
      delete a.sinif;
    });
    delete b.sayac;
    bolumler.push(b);
  }

  /* Duzenlemeler sondan basa uygulanir; ayni konumdakiler eklenis sirasinin tersiyle */
  duzenler.forEach((d, i) => (d.i = i));
  duzenler.sort((a, b) => b.bas - a.bas || b.i - a.i);
  let cikti = html;
  for (const d of duzenler) cikti = cikti.slice(0, d.bas) + d.metin + cikti.slice(d.son);
  cikti = cikti.replace(/\sdata-(?:bolum|alan)="[^"]*"/g, "");

  const kimlikler = new Set();
  for (const b of bolumler)
    for (const a of b.alanlar) {
      if (!/^[a-z0-9-]+$/.test(a.id)) throw new Error(sayfa + ": gecersiz alan kimligi " + a.id);
      if (kimlikler.has(a.id)) throw new Error(sayfa + ": ayni alan kimligi iki kez: " + a.id);
      kimlikler.add(a.id);
    }

  return { html: cikti, bolumler, ust };
}

module.exports = { alanlariCikar, metniAyir, ayristir, isaretle };
