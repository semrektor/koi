<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>Blog</span>
      </nav>
      <h1<?php koi_isaret( 'blog-1-baslik1' ); ?>><?php koi_alan( 'blog-1-baslik1' ); ?></h1>
    </div>
    <p class="lead"<?php koi_isaret( 'blog-1-giris1' ); ?>><?php koi_alan( 'blog-1-giris1' ); ?></p>
  </div>
</section>

<?php if ( koi_yazi_var() ) : ?>
<section class="section section--tight">
  <div class="container container--wide">
<?php koi_one_cikan_yazi(); ?>
  </div>
</section>

<section class="section section--tight">
  <div class="container container--wide">
    <hr class="rule">
  </div>
</section>

<section class="section section--tight">
  <div class="container container--wide">
<?php koi_blog_filtreleri(); ?>

    <div class="cards cards--3" id="blog-listesi">
<?php koi_kartlar( 'blog-listesi' ); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ( ! koi_yazi_var() ) : ?>
<section class="section">
  <div class="container container--wide">
    <div class="section-head center reveal">
      <span class="eyebrow eyebrow--center"<?php koi_isaret( 'blog-5-ust1' ); ?>><?php koi_alan( 'blog-5-ust1' ); ?></span>
      <h2<?php koi_isaret( 'blog-5-baslik1' ); ?>><?php koi_alan( 'blog-5-baslik1' ); ?></h2>
      <p class="lead"<?php koi_isaret( 'blog-5-giris1' ); ?>><?php koi_alan( 'blog-5-giris1' ); ?></p>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="cta-band">
  <?php koi_gorsel( 'blog-6-gorsel1' ); ?>
  <div class="cta-band__inner reveal">
    <span class="eyebrow"<?php koi_isaret( 'blog-6-ust1' ); ?>><?php koi_alan( 'blog-6-ust1' ); ?></span>
    <h2<?php koi_isaret( 'blog-6-baslik1' ); ?>><?php koi_alan( 'blog-6-baslik1' ); ?></h2>
    <p class="lead"<?php koi_isaret( 'blog-6-giris1' ); ?>><?php koi_alan( 'blog-6-giris1' ); ?></p>
    <div class="cta-band__row">
      <a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>"<?php koi_isaret( 'blog-6-dugme1' ); ?>><?php koi_alan( 'blog-6-dugme1' ); ?></a>
      <a class="link-arrow" href="<?php echo esc_url( koi_wa_url() ); ?>"<?php koi_isaret( 'blog-6-baglanti1' ); ?>><?php koi_alan( 'blog-6-baglanti1' ); ?></a>
    </div>
  </div>
  <?php koi_gorsel( 'blog-6-gorsel2' ); ?>
</section>
