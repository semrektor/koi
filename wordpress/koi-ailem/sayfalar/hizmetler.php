<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>Hizmetler</span>
      </nav>
      <h1<?php koi_isaret( 'hizmetler-1-baslik1' ); ?>><?php koi_alan( 'hizmetler-1-baslik1' ); ?></h1>
    </div>
    <p class="lead"<?php koi_isaret( 'hizmetler-1-giris1' ); ?>><?php koi_alan( 'hizmetler-1-giris1' ); ?></p>
  </div>
</section>

<section class="section">
  <div class="container container--wide">
<?php koi_filtreler( 'hizmet_kategori', '#hizmet-listesi', 'Hizmet filtresi' ); ?>

    <div class="cards cards--3" id="hizmet-listesi">
<?php koi_kartlar( 'hizmet-listesi' ); ?>
    </div>
  </div>
</section>

<section class="section section--cream">
  <div class="container container--wide">
    <div class="section-head section-head--split reveal">
      <div>
        <span class="eyebrow"<?php koi_isaret( 'hizmetler-3-ust1' ); ?>><?php koi_alan( 'hizmetler-3-ust1' ); ?></span>
        <h2<?php koi_isaret( 'hizmetler-3-baslik1' ); ?>><?php koi_alan( 'hizmetler-3-baslik1' ); ?></h2>
      </div>
      <p class="lead"<?php koi_isaret( 'hizmetler-3-giris1' ); ?>><?php koi_alan( 'hizmetler-3-giris1' ); ?></p>
    </div>
<?php koi_kartlar( 'sss-hizmetler' ); ?>
    <p class="reveal" style="margin-top:30px"><a class="link-arrow" href="<?php echo esc_url( koi_url( 'sss' ) ); ?>"<?php koi_isaret( 'hizmetler-3-baglanti1' ); ?>><?php koi_alan( 'hizmetler-3-baglanti1' ); ?></a></p>
  </div>
</section>

<section class="cta-band">
  <?php koi_gorsel( 'hizmetler-4-gorsel1' ); ?>
  <div class="cta-band__inner reveal">
    <span class="eyebrow"<?php koi_isaret( 'hizmetler-4-ust1' ); ?>><?php koi_alan( 'hizmetler-4-ust1' ); ?></span>
    <h2<?php koi_isaret( 'hizmetler-4-baslik1' ); ?>><?php koi_alan( 'hizmetler-4-baslik1' ); ?></h2>
    <p class="lead"<?php koi_isaret( 'hizmetler-4-giris1' ); ?>><?php koi_alan( 'hizmetler-4-giris1' ); ?></p>
    <div class="cta-band__row">
      <a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>"<?php koi_isaret( 'hizmetler-4-dugme1' ); ?>><?php koi_alan( 'hizmetler-4-dugme1' ); ?></a>
      <a class="link-arrow" href="<?php echo esc_url( koi_tel_url() ); ?>"<?php koi_isaret( 'hizmetler-4-baglanti1' ); ?>><?php koi_alan( 'hizmetler-4-baglanti1' ); ?></a>
    </div>
  </div>
  <?php koi_gorsel( 'hizmetler-4-gorsel2' ); ?>
</section>
