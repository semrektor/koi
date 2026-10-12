<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>Sık Sorulan Sorular</span>
      </nav>
      <h1><?php koi_ust_metin( 'baslik', 'Sık Sorulan
Sorular' ); ?></h1>
    </div>
    <p class="lead"><?php koi_ust_metin( 'giris', 'KOI, hizmetlerimiz ve başvuru süreci hakkında en çok merak edilenler. Yanıtını bulamadığınız bir soru olursa bize yazabilirsiniz.' ); ?></p>
  </div>
</section>

<?php koi_kartlar( 'sss-bolumleri' ); ?>

<section class="cta-band">
  <div class="media media--olive cta-band__media has-img" data-label="Detay görsel"><img class="media__img" src="<?php koi_v(); ?>img/yaprak.jpg" srcset="<?php koi_v(); ?>img/yaprak-sm.jpg 900w, <?php koi_v(); ?>img/yaprak.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="Duvara vuran yaprak gölgeleri" loading="lazy"></div>
  <div class="cta-band__inner reveal">
    <span class="eyebrow">Başka Bir Sorunuz mu Var?</span>
    <h2>Yanıtını Birlikte Bulalım</h2>
    <p class="lead">Formu doldurun ya da WhatsApp'tan yazın; ihtiyacınıza uygun yolu birlikte belirleyelim.</p>
    <div class="cta-band__row">
      <a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>">Bilgi Alın<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
      <a class="link-arrow" href="<?php echo esc_url( koi_wa_url() ); ?>">WhatsApp'tan Yazın<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
    </div>
  </div>
  <div class="media cta-band__media has-img" data-label="Detay görsel"><img class="media__img" src="<?php koi_v(); ?>img/yaprak.jpg" srcset="<?php koi_v(); ?>img/yaprak-sm.jpg 900w, <?php koi_v(); ?>img/yaprak.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="Duvara vuran yaprak gölgeleri" loading="lazy">
    <svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg>
  </div>
</section>
