# KOI | Çocuk ve Aile Gelişim Merkezi

Ümraniye/Necip Fazıl'da açılacak KOI Çocuk ve Aile Gelişim Merkezi için hazırlanan kurumsal web sitesi taslağı ve yönetim paneli önizlemesi.

Markaya özel, sıfırdan tasarlanmış statik site. Müşteri onayından sonra WordPress'e (özel tema) aktarılacaktır.

**42 sayfa** · duyarlı tasarım · hazır tema kullanılmadı

## Hızlı başlangıç

```bash
node build/serve.js
```

`http://localhost:5173` → site
`http://localhost:5173/yonetim-giris.html` → yönetim paneli (`admin` / `admin`)

## Derleme

```bash
node build/generate-pages.js && node build/apply-images.js && node build/build.js && node build/sitemap.js
```

Çıktı `site/` klasörüne yazılır.

## Kontrol

```bash
node build/check.js
```

Bağlantılar, SEO alanları, erişilebilirlik ve yapısal bütünlük kontrolü.

## Netlify

`netlify.toml` hazırdır:

- **Publish directory:** `site`
- **Build command:** `node build/generate-pages.js && node build/apply-images.js && node build/build.js`
- **Node sürümü:** 20

Güvenlik başlıkları ve önbellek kuralları aynı dosyada tanımlıdır.

## Ayrıntılı belge

Sayfa listesi, tasarım sistemi, çalışan özellikler ve WordPress geçiş notları için: [OKUBENI.md](OKUBENI.md)
