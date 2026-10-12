<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>Hizmetler</span>
      </nav>
      <h1><?php koi_ust_metin( 'baslik', 'Her İhtiyaca
Uygun Bir Yol Var' ); ?></h1>
    </div>
    <p class="lead"><?php koi_ust_metin( 'giris', 'Bireysel danışmanlıktan aile programlarına, oyun gruplarından seminerlere; ihtiyacınıza göre kurgulanan hizmetler.' ); ?></p>
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
        <span class="eyebrow">Sık Sorulanlar</span>
        <h2>Merak Edilenler</h2>
      </div>
      <p class="lead">Aklınıza takılan başka bir konu varsa bize yazmaktan çekinmeyin.</p>
    </div>
<?php koi_kartlar( 'sss-hizmetler' ); ?>
    <p class="reveal" style="margin-top:30px"><a class="link-arrow" href="<?php echo esc_url( koi_url( 'sss' ) ); ?>">Tüm Sorular<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a></p>
  </div>
</section>

<section class="cta-band">
  <div class="media media--olive cta-band__media has-img" data-label="Detay görsel"><img class="media__img" src="<?php koi_v(); ?>img/yaprak.jpg" srcset="<?php koi_v(); ?>img/yaprak-sm.jpg 900w, <?php koi_v(); ?>img/yaprak.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="Duvara vuran yaprak gölgeleri" loading="lazy"></div>
  <div class="cta-band__inner reveal">
    <span class="eyebrow">Başlayalım</span>
    <h2>Hangi Hizmetin Uygun Olduğundan Emin Değil misiniz?</h2>
    <p class="lead">Kısa bir ön görüşmeyle ihtiyacınıza en uygun programı birlikte belirleyelim.</p>
    <div class="cta-band__row">
      <a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>">Ön Başvuru Yapın<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
      <a class="link-arrow" href="<?php echo esc_url( koi_tel_url() ); ?>">Telefonla Arayın<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
    </div>
  </div>
  <div class="media cta-band__media has-img" data-label="Detay görsel"><img class="media__img" src="<?php koi_v(); ?>img/yaprak.jpg" srcset="<?php koi_v(); ?>img/yaprak-sm.jpg 900w, <?php koi_v(); ?>img/yaprak.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="Duvara vuran yaprak gölgeleri" loading="lazy">
    <svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg>
  </div>
</section>
