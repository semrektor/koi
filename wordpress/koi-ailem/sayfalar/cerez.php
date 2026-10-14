<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>Çerez Politikası</span>
      </nav>
      <h1<?php koi_isaret( 'cerez-1-baslik1' ); ?>><?php koi_alan( 'cerez-1-baslik1' ); ?></h1>
    </div>
    <p class="lead"<?php koi_isaret( 'cerez-1-giris1' ); ?>><?php koi_alan( 'cerez-1-giris1' ); ?></p>
  </div>
</section>

<section class="section">
  <div class="container container--wide with-sidebar">
    <div class="prose reveal">
<?php koi_sayfa_metni( 'cerez' ); ?>
    </div>

    <aside>
      <div class="sidebar-card reveal">
        <h3<?php koi_isaret( 'cerez-2-ara1' ); ?>><?php koi_alan( 'cerez-2-ara1' ); ?></h3>
        <ul>
          <li><a href="<?php echo esc_url( koi_url( 'kvkk' ) ); ?>">KVKK Aydınlatma Metni</a></li>
          <li><a href="<?php echo esc_url( koi_url( 'gizlilik' ) ); ?>">Gizlilik Politikası</a></li>
          <li><a href="<?php echo esc_url( koi_url( 'cerez' ) ); ?>">Çerez Politikası</a></li>
        </ul>
      </div>
      <div class="sidebar-card sidebar-card--dark reveal">
        <h3<?php koi_isaret( 'cerez-2-ara2' ); ?>><?php koi_alan( 'cerez-2-ara2' ); ?></h3>
        <p<?php koi_isaret( 'cerez-2-paragraf1' ); ?>><?php koi_alan( 'cerez-2-paragraf1' ); ?></p>
        <div style="margin-top:20px">
          <a class="btn btn--terra" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>"<?php koi_isaret( 'cerez-2-dugme1' ); ?>><?php koi_alan( 'cerez-2-dugme1' ); ?></a>
        </div>
      </div>
    </aside>
  </div>
</section>
