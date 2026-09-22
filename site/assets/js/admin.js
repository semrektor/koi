/* KOI Yonetim Paneli - taslak etkilesimleri
   Veriler tarayicinin localStorage'inda tutulur; WordPress kurulumunda
   bu katmanin yerini gercek veritabani alacaktir. */
(function () {
  "use strict";

  var KEY = "koi-admin-v1";
  var OTURUM = "koi-oturum";

  /* ---------- Oturum kontrolu ----------
     Taslak seviyesinde istemci tarafi kontrol; gercek kimlik dogrulama
     WordPress kullanici yonetimiyle sunucu tarafinda yapilacaktir. */
  function oturumOku() {
    try {
      var s = sessionStorage.getItem(OTURUM) || localStorage.getItem(OTURUM);
      return s ? JSON.parse(s) : null;
    } catch (e) {
      return null;
    }
  }
  var oturum = oturumOku();
  if (!oturum) {
    window.location.replace("yonetim-giris.html");
    return;
  }

  /* Kullanici bilgisini ust bara yaz */
  document.addEventListener("DOMContentLoaded", function () {
    var ad = document.querySelector(".admin-user span:first-child");
    var bas = document.querySelector(".admin-user__avatar");
    if (ad && oturum.ad) ad.textContent = oturum.ad;
    if (bas && oturum.bas) bas.textContent = oturum.bas;
  });

  /* Cikis */
  document.addEventListener("click", function (e) {
    var cikis = e.target.closest('a[href="yonetim-giris.html"]');
    if (!cikis) return;
    try {
      sessionStorage.removeItem(OTURUM);
      localStorage.removeItem(OTURUM);
    } catch (err) {}
  });

  /* ---------- Baslangic verisi ---------- */
  var VARSAYILAN = {
    blog: [
      { id: 1, baslik: "Çocuklarda ve Ailelerde Yeni Başlangıçlar", ozet: "Uyum süreçlerinde çocuğun yanında nasıl durulur?", kategori: "Ebeveynlik", durum: "yayinda", tarih: "2026-09-18", yazar: "Elif Bilsel" },
      { id: 2, baslik: "Oyun Gruplarının Çocuk Gelişimindeki Yeri", ozet: "Sosyal beceriler neden oyun içinde öğrenilir?", kategori: "Oyun ve Gelişim", durum: "yayinda", tarih: "2026-09-12", yazar: "KOI Uzman Ekibi" },
      { id: 3, baslik: "Ebeveynlikte Sınırlar, İletişim ve Güvenli Bağ", ozet: "Sınır koymak sevgiyi azaltmaz; güveni büyütür.", kategori: "Ebeveynlik", durum: "yayinda", tarih: "2026-09-05", yazar: "Elif Bilsel" },
      { id: 4, baslik: "Çocuklarda Kaygı ve Duyguları Düzenleme", ozet: "Kaygı bir düşman değil, bir sinyaldir.", kategori: "Duygular", durum: "yayinda", tarih: "2026-08-28", yazar: "KOI Uzman Ekibi" },
      { id: 5, baslik: "Okula Uyum ve Ayrılık Kaygısı", ozet: "Sabah kapıda yaşanan zorlu anlar için yol haritası.", kategori: "Okul", durum: "yayinda", tarih: "2026-08-20", yazar: "Elif Bilsel" },
      { id: 6, baslik: "Ekran Süresi ve Dijital Sınırlar", ozet: "Yaş gruplarına göre uygulanabilir öneriler.", kategori: "Ebeveynlik", durum: "taslak", tarih: "2026-09-21", yazar: "KOI Uzman Ekibi" },
      { id: 7, baslik: "Kardeş Kıskançlığıyla Baş Etmek", ozet: "İkinci çocuk sonrası evdeki denge.", kategori: "Ebeveynlik", durum: "taslak", tarih: "2026-09-20", yazar: "Elif Bilsel" }
    ],
    randevu: [
      { id: 1, ad: "Ayşe Yılmaz", konu: "Oyun Grupları", iletisim: "WhatsApp · 05xx xxx xx xx", durum: "yeni", tarih: "2 saat önce" },
      { id: 2, ad: "Mehmet Demir", konu: "Aile Danışmanlığı", iletisim: "Telefon · 05xx xxx xx xx", durum: "yeni", tarih: "5 saat önce" },
      { id: 3, ad: "Selin Kaya", konu: "Ebeveyn Atölyesi", iletisim: "E-posta · selin@ornek.com", durum: "yeni", tarih: "Bugün" },
      { id: 4, ad: "Burak Aydın", konu: "Oyun Terapisi", iletisim: "Telefon · 05xx xxx xx xx", durum: "tamam", tarih: "Dün" },
      { id: 5, ad: "Deniz Şahin", konu: "Okula Uyum Semineri", iletisim: "WhatsApp · 05xx xxx xx xx", durum: "tamam", tarih: "2 gün önce" },
      { id: 6, ad: "Ece Korkmaz", konu: "Anne ve Yenidoğan", iletisim: "E-posta · ece@ornek.com", durum: "tamam", tarih: "3 gün önce" }
    ],
    hizmet: [
      { id: 1, baslik: "Çocuk ve Ergen Danışmanlığı", kategori: "Çocuk ve Ergen", durum: "yayinda", sayfa: "hizmet-cocuk-ergen-danismanligi.html" },
      { id: 2, baslik: "Oyun Terapisi", kategori: "Çocuk ve Ergen", durum: "yayinda", sayfa: "hizmet-oyun-terapisi.html" },
      { id: 3, baslik: "Aile ve Ebeveyn Danışmanlığı", kategori: "Aile ve Ebeveyn", durum: "yayinda", sayfa: "hizmet-aile-ebeveyn-danismanligi.html" },
      { id: 4, baslik: "Anne, Hamilelik ve Yenidoğan Danışmanlığı", kategori: "Aile ve Ebeveyn", durum: "yayinda", sayfa: "hizmet-anne-yenidogan.html" },
      { id: 5, baslik: "Eğitim ve Akademik Gelişim Desteği", kategori: "Danışmanlık", durum: "yayinda", sayfa: "hizmet-akademik-gelisim.html" },
      { id: 6, baslik: "Seminer ve Workshoplar", kategori: "Grup Programları", durum: "yayinda", sayfa: "hizmet-seminer-workshop.html" },
      { id: 7, baslik: "Kurum ve Okul İş Birlikleri", kategori: "Danışmanlık", durum: "yayinda", sayfa: "hizmet-kurum-okul.html" }
    ],
    atolye: [
      { id: 1, baslik: "Duygu Kutusu", tur: "Çocuk Atölyesi", tarih: "Cumartesi 10:30", kontenjan: "4 / 6", durum: "yayinda", sayfa: "atolye-duygu-kutusu.html" },
      { id: 2, baslik: "Sınırlar ve Güvenli Bağ", tur: "Ebeveyn Atölyesi", tarih: "Cumartesi 14:00", kontenjan: "9 / 12", durum: "yayinda", sayfa: "atolye-sinirlar-guvenli-bag.html" },
      { id: 3, baslik: "Birlikte Oynuyoruz", tur: "Çocuk-Aile", tarih: "Pazar 11:00", kontenjan: "6 / 6", durum: "yayinda", sayfa: "atolye-birlikte-oynuyoruz.html" },
      { id: 4, baslik: "Hikâye ve Hayal", tur: "Çocuk Atölyesi", tarih: "Cumartesi 13:00", kontenjan: "3 / 6", durum: "yayinda", sayfa: "atolye-hikaye-hayal.html" },
      { id: 5, baslik: "Okula Uyum Süreci", tur: "Seminer", tarih: "Pazar 15:00", kontenjan: "11 / 20", durum: "yayinda", sayfa: "atolye-okula-uyum.html" },
      { id: 6, baslik: "Yenidoğan ve İlk Yıl", tur: "Ebeveyn Atölyesi", tarih: "Pazar 13:00", kontenjan: "5 / 8", durum: "yayinda", sayfa: "atolye-yenidogan-ilk-yil.html" },
      { id: 7, baslik: "Bahar Dönemi Drama Atölyesi", tur: "Çocuk Atölyesi", tarih: "Planlanıyor", kontenjan: "0 / 6", durum: "taslak", sayfa: "" }
    ],
    oyungrubu: [
      { id: 1, gun: "Pazartesi", sabah: "10:00 — Minik Adımlar (1-2 yaş)", ogleden: "15:00 — Oyun Atölyesi (3-5 yaş)", kontenjan: "6" },
      { id: 2, gun: "Salı", sabah: "10:00 — Keşif Grubu (2-3 yaş)", ogleden: "15:00 — Sosyal Beceri (5-7 yaş)", kontenjan: "6" },
      { id: 3, gun: "Çarşamba", sabah: "10:00 — Minik Adımlar (1-2 yaş)", ogleden: "15:00 — Oyun Atölyesi (3-5 yaş)", kontenjan: "6" },
      { id: 4, gun: "Perşembe", sabah: "10:00 — Keşif Grubu (2-3 yaş)", ogleden: "15:00 — Sosyal Beceri (5-7 yaş)", kontenjan: "6" },
      { id: 5, gun: "Cuma", sabah: "10:00 — Karma Yaş Atölyesi", ogleden: "15:00 — Çocuk-Aile Oyun Saati", kontenjan: "6" }
    ],
    uzman: [
      { id: 1, ad: "Elif Bilsel", unvan: "Psikolojik Danışman", uzmanlik: "Aile danışmanlığı, oyun terapisi", foto: false, durum: "yayinda" },
      { id: 2, ad: "Uzman İsmi", unvan: "Klinik Psikolog", uzmanlik: "Çocuk ve ergen", foto: false, durum: "taslak" },
      { id: 3, ad: "Uzman İsmi", unvan: "Çocuk Gelişim Uzmanı", uzmanlik: "Erken çocukluk", foto: false, durum: "taslak" },
      { id: 4, ad: "Uzman İsmi", unvan: "Atölye Eğitmeni", uzmanlik: "Yaratıcı drama", foto: false, durum: "taslak" }
    ],
    galeri: [
      { id: 1, src: "karsilama", ad: "Karşılama alanı", kat: "mekan" },
      { id: 2, src: "oyun-odasi", ad: "Oyun odası", kat: "mekan" },
      { id: 3, src: "danismanlik", ad: "Danışmanlık odası", kat: "mekan" },
      { id: 4, src: "atolye-masa", ad: "Atölye masası", kat: "atolye" },
      { id: 5, src: "blog-masa", ad: "Çalışma alanı", kat: "atolye" },
      { id: 6, src: "yaprak", ad: "Detay — bitki", kat: "mekan" },
      { id: 7, src: "hero-kemer", ad: "Kemerli alan", kat: "mekan" },
      { id: 8, src: "oyun-odasi", ad: "Atölye anı", kat: "etkinlik" }
    ]
  };

  /* ---------- Depolama ---------- */
  function oku() {
    try {
      var s = localStorage.getItem(KEY);
      if (!s) return JSON.parse(JSON.stringify(VARSAYILAN));
      var d = JSON.parse(s);
      Object.keys(VARSAYILAN).forEach(function (k) {
        if (!d[k]) d[k] = JSON.parse(JSON.stringify(VARSAYILAN[k]));
      });
      return d;
    } catch (e) {
      return JSON.parse(JSON.stringify(VARSAYILAN));
    }
  }
  function yaz(d) {
    try { localStorage.setItem(KEY, JSON.stringify(d)); } catch (e) {}
  }
  var db = oku();

  var esc = function (s) {
    return String(s == null ? "" : s).replace(/[&<>"']/g, function (c) {
      return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c];
    });
  };
  var ikon = function (id) { return '<svg aria-hidden="true"><use href="#' + id + '"></use></svg>'; };
  var durumRozet = function (d) {
    var ad = { yayinda: "Yayında", taslak: "Taslak", yeni: "Yeni", tamam: "Yanıtlandı" };
    return '<span class="status status--' + d + '">' + (ad[d] || d) + "</span>";
  };
  var tarihTr = function (s) {
    if (!s || s.indexOf("-") < 0) return s || "—";
    var p = s.split("-");
    return p[2] + "." + p[1] + "." + p[0];
  };

  /* ---------- Tablo cizimleri ---------- */
  var CIZ = {
    blog: function (x) {
      return (
        '<tr data-id="' + x.id + '" data-durum="' + x.durum + '">' +
        '<td data-th="Başlık" class="t-title">' + esc(x.baslik) + "<small>" + esc(x.ozet || "") + "</small></td>" +
        '<td data-th="Kategori">' + esc(x.kategori) + "</td>" +
        '<td data-th="Durum">' + durumRozet(x.durum) + "</td>" +
        '<td data-th="Tarih">' + tarihTr(x.tarih) + "</td>" +
        '<td data-th="İşlem"><div class="row-actions">' +
        '<a class="icon-btn" href="yonetim-yazi.html" title="Düzenle">' + ikon("i-pen") + "</a>" +
        '<button class="icon-btn" type="button" data-eylem="durum" title="Yayın durumunu değiştir">' + ikon("i-eye") + "</button>" +
        '<button class="icon-btn icon-btn--danger" type="button" data-eylem="sil" title="Sil">' + ikon("i-trash") + "</button>" +
        "</div></td></tr>"
      );
    },
    "ozet-blog": function (x) {
      return (
        "<tr>" +
        '<td data-th="Başlık" class="t-title">' + esc(x.baslik) + "</td>" +
        '<td data-th="Kategori">' + esc(x.kategori) + "</td>" +
        '<td data-th="Durum">' + durumRozet(x.durum) + "</td>" +
        '<td data-th="Tarih">' + tarihTr(x.tarih) + "</td>" +
        '<td data-th="İşlem"><div class="row-actions"><a class="icon-btn" href="yonetim-yazi.html">' + ikon("i-pen") + "</a></div></td>" +
        "</tr>"
      );
    },
    randevu: function (x) {
      return (
        '<tr data-id="' + x.id + '" data-durum="' + x.durum + '">' +
        '<td data-th="Ad Soyad" class="t-title">' + esc(x.ad) + "</td>" +
        '<td data-th="Konu">' + esc(x.konu) + "</td>" +
        '<td data-th="İletişim">' + esc(x.iletisim) + "</td>" +
        '<td data-th="Durum">' + durumRozet(x.durum) + "</td>" +
        '<td data-th="Tarih">' + esc(x.tarih) + "</td>" +
        '<td data-th="İşlem"><div class="row-actions">' +
        '<button class="icon-btn" type="button" data-eylem="durum" title="Yanıtlandı olarak işaretle">' + ikon("i-eye") + "</button>" +
        '<button class="icon-btn icon-btn--danger" type="button" data-eylem="sil" title="Sil">' + ikon("i-trash") + "</button>" +
        "</div></td></tr>"
      );
    },
    hizmet: function (x) {
      return (
        '<tr data-id="' + x.id + '" data-durum="' + x.durum + '">' +
        '<td data-th="Hizmet" class="t-title">' + esc(x.baslik) + "</td>" +
        '<td data-th="Kategori">' + esc(x.kategori) + "</td>" +
        '<td data-th="Durum">' + durumRozet(x.durum) + "</td>" +
        '<td data-th="Sayfa">' + (x.sayfa ? '<a href="' + x.sayfa + '" target="_blank" style="color:var(--koi-terra)">Görüntüle</a>' : "—") + "</td>" +
        '<td data-th="İşlem"><div class="row-actions">' +
        '<button class="icon-btn" type="button" data-eylem="duzenle" title="Düzenle">' + ikon("i-pen") + "</button>" +
        '<button class="icon-btn" type="button" data-eylem="durum" title="Yayın durumunu değiştir">' + ikon("i-eye") + "</button>" +
        "</div></td></tr>"
      );
    },
    atolye: function (x) {
      return (
        '<tr data-id="' + x.id + '" data-durum="' + x.durum + '">' +
        '<td data-th="Program" class="t-title">' + esc(x.baslik) + "</td>" +
        '<td data-th="Tür">' + esc(x.tur) + "</td>" +
        '<td data-th="Tarih">' + esc(x.tarih) + "</td>" +
        '<td data-th="Kontenjan">' + esc(x.kontenjan) + "</td>" +
        '<td data-th="Durum">' + durumRozet(x.durum) + "</td>" +
        '<td data-th="İşlem"><div class="row-actions">' +
        '<button class="icon-btn" type="button" data-eylem="duzenle" title="Düzenle">' + ikon("i-pen") + "</button>" +
        '<button class="icon-btn" type="button" data-eylem="durum" title="Yayın durumunu değiştir">' + ikon("i-eye") + "</button>" +
        '<button class="icon-btn icon-btn--danger" type="button" data-eylem="sil" title="Sil">' + ikon("i-trash") + "</button>" +
        "</div></td></tr>"
      );
    },
    oyungrubu: function (x) {
      return (
        '<tr data-id="' + x.id + '">' +
        '<td data-th="Gün" class="t-title">' + esc(x.gun) + "</td>" +
        '<td data-th="Sabah">' + esc(x.sabah) + "</td>" +
        '<td data-th="Öğleden Sonra">' + esc(x.ogleden) + "</td>" +
        '<td data-th="Kontenjan">' + esc(x.kontenjan) + " çocuk</td>" +
        '<td data-th="İşlem"><div class="row-actions"><button class="icon-btn" type="button" data-eylem="duzenle">' + ikon("i-pen") + "</button></div></td>" +
        "</tr>"
      );
    },
    uzman: function (x) {
      return (
        '<tr data-id="' + x.id + '" data-durum="' + x.durum + '">' +
        '<td data-th="Ad Soyad" class="t-title">' + esc(x.ad) + "</td>" +
        '<td data-th="Unvan">' + esc(x.unvan) + "</td>" +
        '<td data-th="Uzmanlık">' + esc(x.uzmanlik) + "</td>" +
        '<td data-th="Fotoğraf">' + (x.foto ? "Yüklendi" : '<span class="muted">Bekleniyor</span>') + "</td>" +
        '<td data-th="Durum">' + durumRozet(x.durum) + "</td>" +
        '<td data-th="İşlem"><div class="row-actions">' +
        '<button class="icon-btn" type="button" data-eylem="duzenle">' + ikon("i-pen") + "</button>" +
        '<button class="icon-btn" type="button" data-eylem="durum">' + ikon("i-eye") + "</button>" +
        "</div></td></tr>"
      );
    }
  };

  function ciz(tur) {
    var govde = document.querySelector('[data-list="' + tur + '"]');
    if (!govde) return;
    var kaynak = tur === "ozet-blog" ? db.blog.slice(0, 5) : db[tur];
    if (!kaynak) return;
    if (tur === "galeri") {
      govde.innerHTML = kaynak
        .map(function (x) {
          return (
            '<figure data-id="' + x.id + '" data-kat="' + x.kat + '">' +
            '<img src="assets/img/' + x.src + '.jpg" alt="' + esc(x.ad) + '" loading="lazy">' +
            "<figcaption><span>" + esc(x.ad) + "</span>" +
            '<button class="icon-btn icon-btn--danger" type="button" data-eylem="sil" title="Kaldır">' + ikon("i-trash") + "</button>" +
            "</figcaption></figure>"
          );
        })
        .join("");
      return;
    }
    govde.innerHTML = kaynak.map(CIZ[tur]).join("");
  }

  Object.keys(CIZ).concat(["galeri"]).forEach(ciz);

  /* ---------- Satir eylemleri ---------- */
  document.addEventListener("click", function (e) {
    var btn = e.target.closest("[data-eylem]");
    if (!btn) return;
    var satir = btn.closest("[data-id]");
    var kap = btn.closest("[data-list]");
    if (!satir || !kap) return;
    e.preventDefault();

    var tur = kap.getAttribute("data-list");
    var id = Number(satir.getAttribute("data-id"));
    var liste = db[tur];
    if (!liste) return;
    var kayit = liste.filter(function (x) { return x.id === id; })[0];
    var eylem = btn.getAttribute("data-eylem");

    if (eylem === "sil") {
      if (!window.confirm("Bu kaydı silmek istediğinize emin misiniz?")) return;
      db[tur] = liste.filter(function (x) { return x.id !== id; });
      yaz(db);
      ciz(tur);
      if (tur === "blog") ciz("ozet-blog");
      bildir("Kayıt silindi.");
    } else if (eylem === "durum" && kayit) {
      if (tur === "randevu") kayit.durum = kayit.durum === "yeni" ? "tamam" : "yeni";
      else kayit.durum = kayit.durum === "yayinda" ? "taslak" : "yayinda";
      yaz(db);
      ciz(tur);
      if (tur === "blog") ciz("ozet-blog");
      bildir("Durum güncellendi.");
    } else if (eylem === "duzenle") {
      bildir("Düzenleme ekranı WordPress kurulumunda açılacaktır.");
    }
  });

  /* ---------- Filtreler ---------- */
  document.querySelectorAll("[data-admin-filter]").forEach(function (grup) {
    var tur = grup.getAttribute("data-admin-filter");
    grup.addEventListener("click", function (e) {
      var b = e.target.closest("button[data-f]");
      if (!b) return;
      grup.querySelectorAll("button").forEach(function (x) { x.classList.toggle("is-active", x === b); });
      var f = b.getAttribute("data-f");
      var kapsayici = document.querySelector('[data-list="' + (tur === "randevu" ? "randevu" : tur) + '"]');
      if (!kapsayici) return;
      kapsayici.querySelectorAll("[data-id]").forEach(function (satir) {
        var deger = satir.getAttribute("data-durum") || satir.getAttribute("data-kat");
        satir.style.display = f === "all" || deger === f ? "" : "none";
      });
    });
  });

  /* ---------- Yazi editoru ---------- */
  var form = document.querySelector("[data-yazi-form]");
  if (form) {
    var alan = form.querySelector("#y-icerik");
    form.querySelectorAll(".editor-toolbar button").forEach(function (b) {
      b.addEventListener("click", function () {
        var ek = b.getAttribute("data-ins");
        var p = alan.selectionStart;
        alan.value = alan.value.slice(0, p) + ek + alan.value.slice(alan.selectionEnd);
        alan.focus();
        alan.selectionStart = alan.selectionEnd = p + ek.length;
      });
    });

    var baslikAlani = form.querySelector("#y-baslik");
    var slugOnizleme = form.querySelector("[data-slug-onizleme]");
    if (baslikAlani && slugOnizleme) {
      baslikAlani.addEventListener("input", function () {
        var harita = { ç: "c", ğ: "g", ı: "i", ö: "o", ş: "s", ü: "u" };
        var s = baslikAlani.value
          .toLowerCase()
          .replace(/[çğıöşü]/g, function (c) { return harita[c]; })
          .replace(/[^a-z0-9]+/g, "-")
          .replace(/^-+|-+$/g, "");
        slugOnizleme.textContent = s || "yazi-basligi";
      });
    }

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      var d = new FormData(form);
      if (!d.get("baslik")) return;
      db.blog.unshift({
        id: Date.now(),
        baslik: d.get("baslik"),
        ozet: d.get("ozet") || "",
        kategori: d.get("kategori"),
        durum: d.get("durum"),
        tarih: d.get("tarih") || new Date().toISOString().slice(0, 10),
        yazar: d.get("yazar")
      });
      yaz(db);
      var not = form.querySelector("[data-kayit-not]");
      if (not) {
        not.textContent = "Yazı kaydedildi. Blog listesine yönlendiriliyorsunuz…";
        not.style.color = "var(--koi-olive-300)";
      }
      setTimeout(function () { window.location.href = "yonetim-blog.html"; }, 900);
    });

    var onizle = form.querySelector("[data-onizleme]");
    if (onizle) onizle.addEventListener("click", function () { bildir("Önizleme WordPress kurulumunda açılacaktır."); });
  }

  /* ---------- Ayarlar formu ---------- */
  var ayar = document.querySelector("[data-ayar-form]");
  if (ayar) {
    ayar.addEventListener("submit", function (e) {
      e.preventDefault();
      var not = ayar.querySelector("[data-ayar-not]");
      if (not) {
        not.textContent = "Ayarlar kaydedildi (taslak önizleme).";
        not.style.color = "var(--koi-olive-300)";
      }
    });
  }

  /* ---------- Mobil menu ---------- */
  var toggle = document.querySelector(".admin-side-toggle");
  var side = document.getElementById("admin-side");
  if (toggle && side) {
    toggle.addEventListener("click", function () { side.classList.toggle("is-open"); });
    side.querySelectorAll("a").forEach(function (a) {
      a.addEventListener("click", function () { side.classList.remove("is-open"); });
    });
  }

  /* ---------- Henuz baglanmamis butonlar ---------- */
  document.querySelectorAll("[data-yeni],[data-yukle],[data-disa-aktar]").forEach(function (b) {
    b.addEventListener("click", function (e) {
      e.preventDefault();
      bildir("Bu işlem WordPress kurulumunda etkinleşecektir.");
    });
  });

  /* ---------- Kisa bildirim ---------- */
  function bildir(mesaj) {
    var el = document.createElement("div");
    el.textContent = mesaj;
    el.style.cssText =
      "position:fixed;left:50%;bottom:28px;transform:translateX(-50%);z-index:90;" +
      "background:#2C3524;color:#F4EFE6;padding:13px 22px;border-radius:100px;" +
      "font-size:.86rem;box-shadow:0 16px 40px -18px rgba(0,0,0,.5);opacity:0;transition:opacity .3s";
    document.body.appendChild(el);
    requestAnimationFrame(function () { el.style.opacity = "1"; });
    setTimeout(function () {
      el.style.opacity = "0";
      setTimeout(function () { el.remove(); }, 320);
    }, 2400);
  }

  /* ---------- Panel ozeti sayilari ---------- */
  var s1 = document.querySelector('[data-stat="yazi"]');
  if (s1) {
    s1.textContent = db.blog.filter(function (x) { return x.durum === "yayinda"; }).length;
    var s2 = document.querySelector('[data-stat="randevu"]');
    if (s2) s2.textContent = db.randevu.length;
    var s3 = document.querySelector('[data-stat="program"]');
    if (s3) s3.textContent = db.atolye.length + db.oyungrubu.length - 2;
    var s4 = document.querySelector('[data-stat="galeri"]');
    if (s4) s4.textContent = db.galeri.length;
  }
})();
