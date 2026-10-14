<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="section">
  <div class="container container--wide split split--narrow" style="align-items:center">
    <div class="split__body">
      <span class="eyebrow"<?php koi_isaret( '404-1-ust1' ); ?>><?php koi_alan( '404-1-ust1' ); ?></span>
      <h1<?php koi_isaret( '404-1-baslik1' ); ?>><?php koi_alan( '404-1-baslik1' ); ?></h1>
      <p class="lead"<?php koi_isaret( '404-1-giris1' ); ?>><?php koi_alan( '404-1-giris1' ); ?></p>
      <div style="margin-top:32px;display:flex;gap:14px;flex-wrap:wrap">
        <a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'index' ) ); ?>"<?php koi_isaret( '404-1-dugme1' ); ?>><?php koi_alan( '404-1-dugme1' ); ?></a>
        <a class="btn btn--ghost" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>"<?php koi_isaret( '404-1-dugme2' ); ?>><?php koi_alan( '404-1-dugme2' ); ?></a>
      </div>

      <div style="margin-top:44px">
        <p class="eyebrow" style="margin-bottom:16px"<?php koi_isaret( '404-1-ust2' ); ?>><?php koi_alan( '404-1-ust2' ); ?></p>
        <ul style="display:flex;flex-wrap:wrap;gap:10px 24px">
          <li><a class="link-arrow" href="<?php echo esc_url( koi_url( 'hizmetler' ) ); ?>"<?php koi_isaret( '404-1-baglanti1' ); ?>><?php koi_alan( '404-1-baglanti1' ); ?></a></li>
          <li><a class="link-arrow" href="<?php echo esc_url( koi_url( 'oyun-gruplari' ) ); ?>"<?php koi_isaret( '404-1-baglanti2' ); ?>><?php koi_alan( '404-1-baglanti2' ); ?></a></li>
          <li><a class="link-arrow" href="<?php echo esc_url( koi_url( 'atolyeler' ) ); ?>"<?php koi_isaret( '404-1-baglanti3' ); ?>><?php koi_alan( '404-1-baglanti3' ); ?></a></li>
          <li><a class="link-arrow" href="<?php echo esc_url( koi_url( 'blog' ) ); ?>"<?php koi_isaret( '404-1-baglanti4' ); ?>><?php koi_alan( '404-1-baglanti4' ); ?></a></li>
        </ul>
      </div>
    </div>

    <div class="split__media">
      <?php koi_gorsel( '404-1-gorsel1' ); ?>
    </div>
  </div>
</section>
