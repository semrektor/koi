# KOI | Çocuk ve Aile Gelişim Merkezi — Web Sitesi Taslağı

Statik HTML/CSS tasarım taslağı ve yönetim paneli önizlemesi. Müşteri onayından sonra WordPress'e (özel tema) aktarılacaktır.

**37 sayfa** · mobil/tablet/masaüstü uyumlu · sıfırdan tasarlanmış · hazır tema kullanılmadı

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

### Detay sayfaları (13) — her biri kendi içeriğiyle
**Hizmetler (7):** Çocuk ve Ergen Danışmanlığı · Oyun Terapisi · Aile ve Ebeveyn Danışmanlığı · Anne, Hamilelik ve Yenidoğan · Eğitim ve Akademik Gelişim · Seminer ve Workshoplar · Kurum ve Okul İş Birlikleri

**Atölyeler (6):** Duygularla Tanışmak · Sınırlar, Bağ ve Güven · Birlikte Oyun, Birlikte Bağ · Hikâye, Hayal ve Yaratıcılık · Okula Uyum ve Yeni Başlangıçlar · İlk Yıl: Anne-Bebek Yolculuğu

**Blog:** müşteri kendi yazılarını hazırlayacak; taslaktaki 7 örnek yazı sitede yer almıyor (`build/content/arsiv/blog-ornek.js`). Yazı yokken blog sayfası "çok yakında" durumunu gösterir, ana sayfadaki blog bölümü gizlenir.

### Diğer (5)
Galeri · Sık Sorulan Sorular · KVKK Aydınlatma Metni · Gizlilik Politikası · Çerez Politikası

### Yönetim paneli (10)
Giriş · Panel Özeti · Bilgi Talepleri · Blog Yazıları · Yazı Düzenle · Hizmetler · Atölye ve Programlar · Galeri · Uzman Kadrosu · Site Ayarları

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

**Logo** — Müşterinin orijinal KOI logosu (koi balığı + yay + yapraklar): `logo.webp` (açık zeminler), `logo-acik.webp` (koyu zeminler ve panel), `favicon.png`. Denenen alternatif yatay logo `build/logo-alternatif.png` olarak saklanıyor, sitede kullanılmıyor.

**Koi işareti** — Hakkımızda sayfasındaki "KOI Nedir?" bölümünde, orijinal logodaki koi işareti (yay + balık + yapraklar) harflerden ayrıştırılarak şeffaf zeminli `koi-isaret.webp` olarak kullanıldı.

**Uzman portreleri** — Fotoğraf çekimi yapılana kadar, uzman kartlarında baş harflerden oluşan monogram görünür (örn. "EB", "KOI"). Yapay zekâ ile üretilmiş insan yüzü kullanılmadı; gerçek uzman izlenimi vermemesi için bilinçli bir tercih.

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

Her görselin bir de **900 piksellik küçük varyantı** var (`*-sm.jpg`). Sayfalar `srcset` ile sunulur: telefonda küçük, büyük ekranda tam çözünürlük yüklenir. Mobilde ana sayfanın görsel yükü **585 KB**.

**Bunlar geçici temsili görsellerdir.** Profesyonel çekim sonrası aynı dosya adlarıyla değiştirmek yeterlidir — yeni görselin küçük varyantını da üretmeyi unutmayın.

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
| Sayfa ağırlığı | `srcset` ile duyarlı görseller, lazy-loading, WebP logo — mobilde ana sayfa 585 KB |
| SEO | Her sayfada benzersiz `title` + `meta description`, tek `h1`, Open Graph etiketleri, SEO uyumlu URL'ler |
| Site haritası | `sitemap.xml` otomatik üretiliyor (26 genel sayfa) |
| robots.txt | Hazır; yönetim paneli arama motorlarına kapalı |
| Erişilebilirlik | Tüm görsellerde `alt`, form alanlarında `label`, `aria` etiketleri, klavye erişimi |
| Güvenlik başlıkları | CSP (satır içi script yasak), HSTS, X-Frame-Options, nosniff, Referrer-Policy, Permissions-Policy; panelde X-Robots-Tag — `netlify.toml` |
| HTTPS | Netlify: http → https 301 yönlendirmesi, HSTS preload |
| Analytics / Search Console | Kurulum aşamasında bağlanacak |

---

## Güvenlik notları (taslak)

- **Yönetim paneli girişi (`admin` / `admin`) yalnızca tanıtım amaçlıdır.** Doğrulama tarayıcıda yapılır ve atlatılabilir; panelde gerçek veri olmadığı için risk yoktur. WordPress aşamasında sunucu taraflı oturum, güçlü parola ve 2FA ile değiştirilecektir — bu yapı canlı bir sisteme taşınmamalıdır.
- Panel, kayıtlı verileri ekrana basarken HTML kaçışı ve bağlantı doğrulaması uygular.
- `build/serve.js` yalnızca `127.0.0.1` üzerinde dinler. Görsel kaydetme aracı varsayılan kapalıdır (`KOI_ARAC=1` ile açılır), CSRF ve boyut sınırı korumalıdır. Canlıyla aynı CSP'yi gönderir.
- `node build/check.js` satır içi script, `javascript:` bağlantısı ve `rel=noopener` eksikliğini de hata olarak yakalar.

## Müşteri formu (8 Ekim 2026) ve açık kalanlar

Müşterinin doldurduğu içerik formu işlendi: slogan, vizyon/misyon, "KOI Nedir?" metni, sık sorulan sorular, başvuru adımları, açık adres, ticari unvan ve MERSİS, atölye adları, oyun grubu tablosu, hizmet bilgi kutuları, kurucu ortak biyografileri. Veli yorumları ve örnek blog yazıları kaldırıldı; çerez bildirimi eklendi.

| Alan | Durum |
|---|---|
| Telefon / WhatsApp | `+90 (000) 000 00 00` — müşteri açılış öncesi kesinleştirecek. **Yayın öncesi mutlaka güncellenmeli** |
| E-posta | `info@koiailem.com` — posta kutusu henüz açılmadı |
| Çalışma saatleri | Formdaki haliyle; müşteri açılış öncesi kesinleştirecek |
| Google Maps | Müşteri bağlantı vermedi; İletişim sayfasında adres aramasına giden bağlantı var |
| Instagram | @koiworld bağlı; müşteri formda kesin kullanıcı adının sonradan belirleneceğini yazdı |
| Hizmet ve atölye metinleri | Taslak metinler duruyor; müşteri "KOI içerik yönüne göre yeniden yazılacak" dedi, yeni metin iletmedi |
| Dilek Şevik biyografisi | Müşteri birinci tekil şahıs yazdı; sitede üçüncü tekil şahsa çevrildi — onay alınmalı |
| Diğer uzmanlar | Bilgileri doğrulanınca eklenecek; sayfada "Ekibimiz Büyüyor" notu var |
| Uzman portreleri | Monogram gösteriliyor — çekim sonrası fotoğraflar eklenecek |
| Görseller | Temsili görseller müşteri onayıyla yayında; çekim sonrası değiştirilecek |
| Veli yorumları | Açılış sonrası, yazılı izinli gerçek yorumlarla eklenecek |
| Blog | Açılışta üç yazı planlanıyor; müşteri hazırlayacak |
| KVKK / gizlilik / çerez metinleri | Taslak; müşterinin hukukçusu kontrol edecek. Saklama süresi hukukçuyla belirlenecek |
| Ücret bilgisi | Gösterilmiyor; "bilgi için iletişime geçin" |

---

## WordPress aşamasına hazırlık

**Alan adı ve barındırma:** `koiailem.com` · Hostinger Business paketi (müşterinin hesabı; ajans erişimi hesap paylaşımıyla). Günlük yedek, test ortamı ve kurumsal e-posta pakete dahil.

### WordPress teması (`wordpress/koi/`)

Tema, taslakla aynı kaynaklardan üretilir; tasarım birebir aynıdır.

```bash
node build/wp-tema.js      # wordpress/koi klasörünü üretir
node build/wp-paket.js     # belgeler/koi-tema.zip dosyasını üretir (WordPress'e yüklenecek dosya)
```

| Kaynak | Temadaki karşılığı |
|---|---|
| `build/partials/head.html`, `foot.html` | `header.php`, `footer.php` |
| `build/pages/*.html` (sayfa gövdeleri) | `sayfalar/*.php` |
| `build/content/*.js` | `veri/icerik.json` (kurulum sihirbazı içeri aktarır) |
| `build/wp/` | Elle yazılan PHP: içerik türleri, şablonlar, formlar, ayarlar |

> `wordpress/koi/` üretilmiş çıktıdır. PHP değişiklikleri `build/wp/` altında, sayfa metinleri `build/pages/` altında yapılır.

**Kurulum (WordPress panelinde):**
1. Görünüm → Temalar → Yeni Ekle → Tema Yükle → `koi-tema.zip` → Etkinleştir
2. Görünüm → KOI Kurulum → "İçerikleri Oluştur" (sayfalar, 7 hizmet, 6 atölye, 7 örnek yazı; anasayfa ve kalıcı bağlantılar ayarlanır)
3. Görünüm → Özelleştir → KOI İletişim Bilgileri (telefon, WhatsApp, e-posta, adres, form alıcısı)

**Müşterinin panelden yönetebildikleri:** blog yazıları (Yazılar), Hizmetler, Atölyeler (başlık, metin, özet, görsel, kısa bilgi kutusu), iletişim bilgileri, formlardan gelen Bilgi Talepleri.

**Henüz tema dosyasında duranlar:** Hakkımızda, Oyun Grupları, Uzmanlarımız, Galeri ve yasal metin sayfalarının gövdeleri. Müşteri formu geldiğinde metinler güncellenecek; uzmanlar ve galeri panelden yönetilebilir hale getirilecek.

**Formlar:** harici eklenti yok. Gönderimler "Bilgi Talepleri" altına kaydedilir ve e-postayla bildirilir. Bal küpü alanı ve saatlik gönderim sınırı var.

**Deneme:** tema WordPress Playground üzerinde (WordPress 7.1, PHP 8.2) kurulup tüm sayfalar ve form akışı denendi. Gerçek sunucuda (Hostinger) henüz denenmedi.
