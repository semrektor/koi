<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>Galeri</span>
      </nav>
      <h1<?php koi_isaret( 'galeri-1-baslik1' ); ?>><?php koi_alan( 'galeri-1-baslik1' ); ?></h1>
    </div>
    <p class="lead"<?php koi_isaret( 'galeri-1-giris1' ); ?>><?php koi_alan( 'galeri-1-giris1' ); ?></p>
  </div>
</section>

<section class="section">
  <div class="container container--wide">
<?php koi_filtreler( 'galeri_kategori', '#galeri-listesi', 'Galeri filtresi' ); ?>

    <div class="gallery reveal" id="galeri-listesi">
<?php koi_kartlar( 'galeri-listesi' ); ?>
    </div>

    <p class="muted" style="margin-top:28px;font-size:.82rem"<?php koi_isaret( 'galeri-2-not1' ); ?>><?php koi_alan( 'galeri-2-not1' ); ?></p>
  </div>
</section>

<section class="cta-band">
  <?php koi_gorsel( 'galeri-3-gorsel1' ); ?>
  <div class="cta-band__inner reveal">
    <span class="eyebrow"<?php koi_isaret( 'galeri-3-ust1' ); ?>><?php koi_alan( 'galeri-3-ust1' ); ?></span>
    <h2<?php koi_isaret( 'galeri-3-baslik1' ); ?>><?php koi_alan( 'galeri-3-baslik1' ); ?></h2>
    <p class="lead"<?php koi_isaret( 'galeri-3-giris1' ); ?>><?php koi_alan( 'galeri-3-giris1' ); ?></p>
    <div class="cta-band__row">
      <a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>"<?php koi_isaret( 'galeri-3-dugme1' ); ?>><?php koi_alan( 'galeri-3-dugme1' ); ?></a>
      <a class="link-arrow" href="<?php echo esc_url( koi_wa_url() ); ?>"<?php koi_isaret( 'galeri-3-baglanti1' ); ?>><?php koi_alan( 'galeri-3-baglanti1' ); ?></a>
    </div>
  </div>
  <?php koi_gorsel( 'galeri-3-gorsel2' ); ?>
</section>
