<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>Uzmanlarımız</span>
      </nav>
      <h1<?php koi_isaret( 'uzmanlarimiz-1-baslik1' ); ?>><?php koi_alan( 'uzmanlarimiz-1-baslik1' ); ?></h1>
    </div>
    <p class="lead"<?php koi_isaret( 'uzmanlarimiz-1-giris1' ); ?>><?php koi_alan( 'uzmanlarimiz-1-giris1' ); ?></p>
  </div>
</section>

<?php koi_kartlar( 'uzman-profilleri' ); ?>

<section class="section section--cream">
  <div class="container container--wide">
    <div class="section-head center reveal">
      <span class="eyebrow eyebrow--center"<?php koi_isaret( 'uzmanlarimiz-2-ust1' ); ?>><?php koi_alan( 'uzmanlarimiz-2-ust1' ); ?></span>
      <h2<?php koi_isaret( 'uzmanlarimiz-2-baslik1' ); ?>><?php koi_alan( 'uzmanlarimiz-2-baslik1' ); ?></h2>
    </div>
    <div class="values">
      <div class="value reveal">
        <span class="value__num">01</span>
        <h3<?php koi_isaret( 'uzmanlarimiz-2-ara1' ); ?>><?php koi_alan( 'uzmanlarimiz-2-ara1' ); ?></h3>
        <p<?php koi_isaret( 'uzmanlarimiz-2-paragraf1' ); ?>><?php koi_alan( 'uzmanlarimiz-2-paragraf1' ); ?></p>
      </div>
      <div class="value reveal">
        <span class="value__num">02</span>
        <h3<?php koi_isaret( 'uzmanlarimiz-2-ara2' ); ?>><?php koi_alan( 'uzmanlarimiz-2-ara2' ); ?></h3>
        <p<?php koi_isaret( 'uzmanlarimiz-2-paragraf2' ); ?>><?php koi_alan( 'uzmanlarimiz-2-paragraf2' ); ?></p>
      </div>
      <div class="value reveal">
        <span class="value__num">03</span>
        <h3<?php koi_isaret( 'uzmanlarimiz-2-ara3' ); ?>><?php koi_alan( 'uzmanlarimiz-2-ara3' ); ?></h3>
        <p<?php koi_isaret( 'uzmanlarimiz-2-paragraf3' ); ?>><?php koi_alan( 'uzmanlarimiz-2-paragraf3' ); ?></p>
      </div>
      <div class="value reveal">
        <span class="value__num">04</span>
        <h3<?php koi_isaret( 'uzmanlarimiz-2-ara4' ); ?>><?php koi_alan( 'uzmanlarimiz-2-ara4' ); ?></h3>
        <p<?php koi_isaret( 'uzmanlarimiz-2-paragraf4' ); ?>><?php koi_alan( 'uzmanlarimiz-2-paragraf4' ); ?></p>
      </div>
    </div>
  </div>
</section>

<section class="cta-band">
  <?php koi_gorsel( 'uzmanlarimiz-3-gorsel1' ); ?>
  <div class="cta-band__inner reveal">
    <span class="eyebrow"<?php koi_isaret( 'uzmanlarimiz-3-ust1' ); ?>><?php koi_alan( 'uzmanlarimiz-3-ust1' ); ?></span>
    <h2<?php koi_isaret( 'uzmanlarimiz-3-baslik1' ); ?>><?php koi_alan( 'uzmanlarimiz-3-baslik1' ); ?></h2>
    <p class="lead"<?php koi_isaret( 'uzmanlarimiz-3-giris1' ); ?>><?php koi_alan( 'uzmanlarimiz-3-giris1' ); ?></p>
    <div class="cta-band__row">
      <a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>"<?php koi_isaret( 'uzmanlarimiz-3-dugme1' ); ?>><?php koi_alan( 'uzmanlarimiz-3-dugme1' ); ?></a>
      <a class="link-arrow" href="<?php echo esc_url( 'mailto:' . koi_ayar( 'eposta' ) ); ?>"><?php echo esc_html( koi_ayar( 'eposta' ) ); ?><svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
    </div>
  </div>
  <?php koi_gorsel( 'uzmanlarimiz-3-gorsel2' ); ?>
</section>
