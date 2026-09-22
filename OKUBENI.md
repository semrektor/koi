# KOI | Çocuk ve Aile Gelişim Merkezi — Web Sitesi Taslağı

Statik HTML/CSS tasarım taslağı ve yönetim paneli önizlemesi. Müşteri onayından sonra WordPress'e (özel tema) aktarılacaktır.

**42 sayfa** · mobil/tablet/masaüstü uyumlu · sıfırdan tasarlanmış · hazır tema kullanılmadı

---

## Çalıştırma

```bash
node build/serve.js
```

Ardından `http://localhost:5173` adresini açın.

**Yönetim paneli:** `http://localhost:5173/yonetim-giris.html` — kullanıcı adı `admin`, parola `admin`

---

## Site haritası

### Ana sayfalar (8)
| Sayfa | Dosya |
|---|---|
| Ana sayfa | `index.html` |
| Hakkımızda | `hakkimizda.html` |
| Hizmetler | `hizmetler.html` |
| Oyun Grupları | `oyun-gruplari.html` |
| Atölyeler | `atolyeler.html` |
| Uzmanlarımız | `uzmanlarimiz.html` |
| Blog | `blog.html` |
| İletişim | `iletisim.html` |

### Detay sayfaları (20) — her biri kendi içeriğiyle
**Hizmetler (7):** Çocuk ve Ergen Danışmanlığı · Oyun Terapisi · Aile ve Ebeveyn Danışmanlığı · Anne, Hamilelik ve Yenidoğan · Eğitim ve Akademik Gelişim · Seminer ve Workshoplar · Kurum ve Okul İş Birlikleri

**Atölyeler (6):** Duygu Kutusu · Sınırlar ve Güvenli Bağ · Birlikte Oynuyoruz · Hikâye ve Hayal · Okula Uyum Süreci · Yenidoğan ve İlk Yıl

**Blog (7):** Yeni Başlangıçlar · Oyun Gruplarının Yeri · Sınırlar ve Güvenli Bağ · Kaygı ve Duygu Düzenleme · Küçük Değişiklikler · Okula Uyum · Kardeş İlişkileri

### Diğer (4)
Galeri · KVKK Aydınlatma Metni · Gizlilik Politikası · Çerez Politikası

### Yönetim paneli (10)
Giriş · Panel Özeti · Randevu Talepleri · Blog Yazıları · Yazı Düzenle · Hizmetler · Atölye ve Programlar · Galeri · Uzman Kadrosu · Site Ayarları

---

## Klasör yapısı

```
site/                      → Yayına çıkan çıktı (Netlify bu klasörü yayınlar)
  assets/css/style.css       → Site tasarım sistemi
  assets/css/admin.css       → Yönetim paneli arayüzü
  assets/js/main.js          → Menü, animasyon, akordeon, filtreler
  assets/js/admin.js         → Panel etkileşimleri ve oturum kontrolü
  assets/img/                → Görseller ve logo
build/
  content/*.js               → Hizmet, atölye ve blog içerikleri (tek kaynak)
  partials/                  → Ortak head/footer (site ve panel)
  pages/*.html               → Sayfa gövdeleri
  generate-pages.js          → İçerikten detay sayfası ve kart üretimi
  apply-images.js            → Görselleri sayfa alanlarına yerleştirir
  build.js                   → Parçaları birleştirip site/ altına yazar
  sitemap.js                 → sitemap.xml üretir
  check.js                   → Teslim öncesi kontroller
  serve.js                   → Yerel önizleme sunucusu
netlify.toml                 → Netlify yayın yapılandırması
```

### Derleme

```bash
node build/generate-pages.js && node build/apply-images.js && node build/build.js && node build/sitemap.js
```

Netlify bu komutu otomatik çalıştırır (`netlify.toml`).

> `site/*.html` üretilmiş çıktıdır, doğrudan düzenlemeyin. İçerik değişiklikleri `build/content/` ve `build/pages/` altında yapılır; CSS ve JS ise `site/assets/` altında doğrudan düzenlenir.

### Kontrol

```bash
node build/check.js
```

Kırık bağlantı, eksik meta etiketi, `alt` niteliği olmayan görsel, etiketsiz form alanı, başlık hiyerarşisi, yapısal denge, yetim sayfa ve görsel boyutu kontrolü yapar. Son çalıştırma: **0 hata, 0 uyarı**.

---

## Tasarım sistemi

**Renk** — krem/fildişi zemin (`#FBF8F3`, `#F4EFE6`), koyu zeytin yeşili (`#3A452F`), koi turuncusu (`#C4764F`), kum tonları. Logo kimliğinden türetildi; canlı/neon renk kullanılmadı.

**Tipografi** — Başlıklar: Cormorant Garamond (serif). Gövde: Jost (ince sans). Vurgu: Petit Formal Script. Google Fonts üzerinden.

**İkonlar** — Sayfaya gömülü ince çizgi SVG seti; harici ikon kütüphanesi yok.

**Logo** — Orijinal KOI logosundan hazırlandı: `logo.png` (açık zeminler için), `logo-acik.png` (koyu zeminler ve panel için), `favicon.png`. Kaynak logonun vektör (SVG/AI) hâli iletildiğinde daha keskin bir sürümle değiştirilebilir.

**Görseller** — Canva ile üretilmiş 7 temsili görsel, 2200×1238 / 1400×1750 piksel, JPG (toplam 1.9 MB):

| Dosya | Sahne |
|---|---|
| `hero-kemer.jpg` | Kemerli dinlenme alanı (dikey) |
| `karsilama.jpg` | Karşılama alanı |
| `oyun-odasi.jpg` | Oyun grubu odası |
| `danismanlik.jpg` | Danışmanlık odası (dikey) |
| `atolye-masa.jpg` | Atölye çalışma masası |
| `blog-masa.jpg` | Defter, kalem, çay |
| `yaprak.jpg` | Yaprak gölgeleri |

**Bunlar geçici temsili görsellerdir.** Profesyonel çekim sonrası aynı dosya adlarıyla değiştirmek yeterlidir.

---

## Çalışan özellikler

**Site:** yapışkan header · mobil menü · scroll animasyonları (JS kapalıyken de içerik görünür) · SSS akordeonu · hizmet/atölye/blog/galeri filtreleri · randevu ve atölye başvuru formları · WhatsApp sabit butonu · Google Maps alanı · program takvimi tabloları (mobilde kart düzenine geçer) · blog yazılarında bölüm bağlantıları

**Yönetim paneli:** giriş doğrulaması · blog yazısı ekleme/silme/yayın durumu değiştirme · yazı editörü (biçimlendirme araç çubuğu, SEO alanları, otomatik URL önizleme) · randevu taleplerini işaretleme · hizmet, atölye, oyun grubu, uzman ve galeri listeleri · site ayarları formu

Panel verileri şimdilik tarayıcının yerel deposunda tutulur; WordPress kurulumunda gerçek veritabanına bağlanacaktır.

---

## Teknik hazırlık

| Konu | Durum |
|---|---|
| Duyarlı tasarım | 375 / 768 / 1300 / 1440 genişliklerinde test edildi |
| Sayfa ağırlığı | Görseller optimize JPG; lazy-loading etkin |
| SEO | Her sayfada benzersiz `title` + `meta description`, tek `h1`, Open Graph etiketleri, SEO uyumlu URL'ler |
| Site haritası | `sitemap.xml` otomatik üretiliyor (32 genel sayfa) |
| robots.txt | Hazır; yönetim paneli arama motorlarına kapalı |
| Erişilebilirlik | Tüm görsellerde `alt`, form alanlarında `label`, `aria` etiketleri, klavye erişimi |
| Güvenlik başlıkları | `netlify.toml` içinde tanımlı |
| SSL | Netlify/WordPress kurulumunda etkinleştirilecek |
| Analytics / Search Console | Kurulum aşamasında bağlanacak |

---

## Taslakta bilinçli olarak yer tutucu bırakılanlar

| Alan | Durum |
|---|---|
| Telefon / WhatsApp | `+90 (000) 000 00 00` — netleşince güncellenecek |
| E-posta | `info@koimerkezi.com` — domain seçimine bağlı |
| Açık adres / Google Maps | Ruhsat ve adres kesinleşince canlı harita gömülecek |
| Uzman isimleri | Elif Bilsel dışındakiler "Uzman İsmi" olarak duruyor |
| Uzman portreleri | Boş bırakıldı — yapay zekâ ile üretilmiş insan yüzü kullanılmadı |
| Veli yorumları | Örnek metin; gerçek yorumlarla değiştirilecek |
| Yaş grupları, takvim, kontenjan | Taslak veri |
| KVKK / gizlilik / çerez metinleri | Sayfalar hazır; metinler hukuk danışmanlığı sonrası kesinleşecek |
| Ücret bilgisi | Gösterilmiyor (müşteri kararına bırakıldı) |
| Sosyal medya | Yalnızca Instagram (@koiworld) bağlı; diğer hesaplar açılınca eklenecek |

---

## WordPress aşamasına hazırlık

- Ortak `head`/`footer` parçaları `header.php` / `footer.php` karşılığı olacak şekilde ayrıldı.
- Hizmet, atölye ve blog içerikleri tek kaynaktan (`build/content/`) besleniyor; bu yapı doğrudan özel içerik tipine (CPT) karşılık gelir.
- Blog yapısı standart WordPress yazı/kategori mantığına birebir oturuyor.
- Yönetim paneli tasarımı, WordPress yönetici arayüzünün nasıl sadeleştirileceğini gösteren bir referanstır.
- Meta başlık/açıklama alanları her sayfada tanımlı (`build/pages/*.html` başındaki yorum satırları).
