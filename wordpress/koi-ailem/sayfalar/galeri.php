<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>Galeri</span>
      </nav>
      <h1><?php koi_ust_metin( 'baslik', 'Merkezimizden' ); ?></h1>
    </div>
    <p class="lead"><?php koi_ust_metin( 'giris', 'Mekânımızın ruhunu yansıtan temsili görseller. Merkezimiz açıldığında kendi fotoğraflarımızla güncellenecektir.' ); ?></p>
  </div>
</section>

<section class="section">
  <div class="container container--wide">
<?php koi_filtreler( 'galeri_kategori', '#galeri-listesi', 'Galeri filtresi' ); ?>

    <div class="gallery reveal" id="galeri-listesi">
<?php koi_kartlar( 'galeri-listesi' ); ?>
    </div>

    <p class="muted" style="margin-top:28px;font-size:.82rem">Çocuklara ait görseller yalnızca gerekli yayın izinleri alınarak kullanılacaktır.</p>
  </div>
</section>

<section class="cta-band">
  <div class="media media--olive cta-band__media has-img" data-label="Detay görsel"><img class="media__img" src="<?php koi_v(); ?>img/yaprak.jpg" srcset="<?php koi_v(); ?>img/yaprak-sm.jpg 900w, <?php koi_v(); ?>img/yaprak.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="Duvara vuran yaprak gölgeleri" loading="lazy"></div>
  <div class="cta-band__inner reveal">
    <span class="eyebrow">Ziyaret</span>
    <h2>Merkezi Yerinde Görün</h2>
    <p class="lead">Fotoğraflar bir fikir verir; asıl atmosferi yerinde hissetmek için sizi merkezimize bekliyoruz.</p>
    <div class="cta-band__row">
      <a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>">Ziyaret İçin Bilgi Al<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
      <a class="link-arrow" href="<?php echo esc_url( koi_wa_url() ); ?>">WhatsApp'tan Yazın<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
    </div>
  </div>
  <div class="media cta-band__media has-img" data-label="Detay görsel"><img class="media__img" src="<?php koi_v(); ?>img/yaprak.jpg" srcset="<?php koi_v(); ?>img/yaprak-sm.jpg 900w, <?php koi_v(); ?>img/yaprak.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="Duvara vuran yaprak gölgeleri" loading="lazy">
    <svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg>
  </div>
</section>
