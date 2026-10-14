<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>Atölyeler</span>
      </nav>
      <h1<?php koi_isaret( 'atolyeler-1-baslik1' ); ?>><?php koi_alan( 'atolyeler-1-baslik1' ); ?></h1>
    </div>
    <p class="lead"<?php koi_isaret( 'atolyeler-1-giris1' ); ?>><?php koi_alan( 'atolyeler-1-giris1' ); ?></p>
  </div>
</section>

<section class="section">
  <div class="container container--wide">
<?php koi_filtreler( 'atolye_turu', '#atolye-listesi', 'Atölye filtresi' ); ?>

    <div class="cards cards--3" id="atolye-listesi">
<?php koi_kartlar( 'atolye-listesi' ); ?>
    </div>
  </div>
</section>

<section class="section section--cream">
  <div class="container container--wide">
    <div class="section-head section-head--split reveal">
      <div>
        <span class="eyebrow"<?php koi_isaret( 'atolyeler-3-ust1' ); ?>><?php koi_alan( 'atolyeler-3-ust1' ); ?></span>
        <h2<?php koi_isaret( 'atolyeler-3-baslik1' ); ?>><?php koi_alan( 'atolyeler-3-baslik1' ); ?></h2>
      </div>
      <p class="lead"<?php koi_isaret( 'atolyeler-3-giris1' ); ?>><?php koi_alan( 'atolyeler-3-giris1' ); ?></p>
    </div>
    <div class="reveal" style="overflow-x:auto">
      <table class="schedule">
        <thead>
          <tr><th>Atölye / Seminer</th><th>Katılımcı</th><th>Tarih ve Saat</th><th>Süre</th><th>Kontenjan</th></tr>
        </thead>
        <tbody>
<?php koi_kartlar( 'atolye-tablosu' ); ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="section">
  <div class="container container--wide">
    <div class="section-head section-head--split reveal">
      <div>
        <span class="eyebrow"<?php koi_isaret( 'atolyeler-4-ust1' ); ?>><?php koi_alan( 'atolyeler-4-ust1' ); ?></span>
        <h2<?php koi_isaret( 'atolyeler-4-baslik1' ); ?>><?php koi_alan( 'atolyeler-4-baslik1' ); ?></h2>
      </div>
      <p class="lead"<?php koi_isaret( 'atolyeler-4-giris1' ); ?>><?php koi_alan( 'atolyeler-4-giris1' ); ?></p>
    </div>
    <div class="timeline">
      <div class="timeline__item reveal">
        <div class="timeline__when">01</div>
        <div class="timeline__what">
          <h3<?php koi_isaret( 'atolyeler-4-ara1' ); ?>><?php koi_alan( 'atolyeler-4-ara1' ); ?></h3>
          <p<?php koi_isaret( 'atolyeler-4-paragraf1' ); ?>><?php koi_alan( 'atolyeler-4-paragraf1' ); ?></p>
        </div>
      </div>
      <div class="timeline__item reveal">
        <div class="timeline__when">02</div>
        <div class="timeline__what">
          <h3<?php koi_isaret( 'atolyeler-4-ara2' ); ?>><?php koi_alan( 'atolyeler-4-ara2' ); ?></h3>
          <p<?php koi_isaret( 'atolyeler-4-paragraf2' ); ?>><?php koi_alan( 'atolyeler-4-paragraf2' ); ?></p>
        </div>
      </div>
      <div class="timeline__item reveal">
        <div class="timeline__when">03</div>
        <div class="timeline__what">
          <h3<?php koi_isaret( 'atolyeler-4-ara3' ); ?>><?php koi_alan( 'atolyeler-4-ara3' ); ?></h3>
          <p<?php koi_isaret( 'atolyeler-4-paragraf3' ); ?>><?php koi_alan( 'atolyeler-4-paragraf3' ); ?></p>
        </div>
      </div>
      <div class="timeline__item reveal">
        <div class="timeline__when">04</div>
        <div class="timeline__what">
          <h3<?php koi_isaret( 'atolyeler-4-ara4' ); ?>><?php koi_alan( 'atolyeler-4-ara4' ); ?></h3>
          <p<?php koi_isaret( 'atolyeler-4-paragraf4' ); ?>><?php koi_alan( 'atolyeler-4-paragraf4' ); ?></p>
        </div>
      </div>
      <div class="timeline__item reveal">
        <div class="timeline__when">05</div>
        <div class="timeline__what">
          <h3<?php koi_isaret( 'atolyeler-4-ara5' ); ?>><?php koi_alan( 'atolyeler-4-ara5' ); ?></h3>
          <p<?php koi_isaret( 'atolyeler-4-paragraf5' ); ?>><?php koi_alan( 'atolyeler-4-paragraf5' ); ?></p>
        </div>
      </div>
    </div>
    <p class="muted reveal" style="margin-top:22px;font-size:.86rem"<?php koi_isaret( 'atolyeler-4-not1' ); ?>><?php koi_alan( 'atolyeler-4-not1' ); ?></p>
  </div>
</section>

<section class="cta-band">
  <?php koi_gorsel( 'atolyeler-5-gorsel1' ); ?>
  <div class="cta-band__inner reveal">
    <span class="eyebrow"<?php koi_isaret( 'atolyeler-5-ust1' ); ?>><?php koi_alan( 'atolyeler-5-ust1' ); ?></span>
    <h2<?php koi_isaret( 'atolyeler-5-baslik1' ); ?>><?php koi_alan( 'atolyeler-5-baslik1' ); ?></h2>
    <p class="lead"<?php koi_isaret( 'atolyeler-5-giris1' ); ?>><?php koi_alan( 'atolyeler-5-giris1' ); ?></p>
    <div class="cta-band__row">
      <a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>"<?php koi_isaret( 'atolyeler-5-dugme1' ); ?>><?php koi_alan( 'atolyeler-5-dugme1' ); ?></a>
      <a class="link-arrow" href="<?php echo esc_url( koi_wa_url() ); ?>"<?php koi_isaret( 'atolyeler-5-baglanti1' ); ?>><?php koi_alan( 'atolyeler-5-baglanti1' ); ?></a>
    </div>
  </div>
  <?php koi_gorsel( 'atolyeler-5-gorsel2' ); ?>
</section>
