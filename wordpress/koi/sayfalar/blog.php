<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>Blog</span>
      </nav>
      <h1>Ailelere Notlar</h1>
    </div>
    <p class="lead">Gelişim, ebeveynlik ve oyun üzerine uzmanlarımızın kaleminden; uygulanabilir, sade ve gerçekçi yazılar.</p>
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
    <div class="filters reveal" data-filter-group data-filter-target="#blog-listesi" role="group" aria-label="Kategori filtresi">
      <button type="button" data-filter="all" class="is-active">Tümü</button>
      <button type="button" data-filter="ebeveynlik">Ebeveynlik</button>
      <button type="button" data-filter="oyun">Oyun ve Gelişim</button>
      <button type="button" data-filter="duygu">Duygular</button>
      <button type="button" data-filter="okul">Okul</button>
    </div>

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
      <span class="eyebrow eyebrow--center">Çok Yakında</span>
      <h2>İlk Yazılarımız Yolda</h2>
      <p class="lead">Oyun, ebeveynlik ve çocuğun gelişim yolculuğu üzerine yazılarımız açılışla birlikte burada olacak.</p>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="cta-band">
  <div class="media media--olive cta-band__media has-img" data-label="Detay görsel"><img class="media__img" src="<?php koi_v(); ?>img/yaprak.jpg" srcset="<?php koi_v(); ?>img/yaprak-sm.jpg 900w, <?php koi_v(); ?>img/yaprak.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="Duvara vuran yaprak gölgeleri" loading="lazy"></div>
  <div class="cta-band__inner reveal">
    <span class="eyebrow">Bilgi Al</span>
    <h2>Bir Uzmanla Konuşmak İster misiniz?</h2>
    <p class="lead">Aklınızdaki soruyu bize iletin; ihtiyacınıza uygun yolu birlikte belirleyelim.</p>
    <div class="cta-band__row">
      <a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>">Bilgi Alın<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
      <a class="link-arrow" href="<?php echo esc_url( koi_wa_url() ); ?>">WhatsApp'tan Yazın<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
    </div>
  </div>
  <div class="media cta-band__media has-img" data-label="Detay görsel"><img class="media__img" src="<?php koi_v(); ?>img/yaprak.jpg" srcset="<?php koi_v(); ?>img/yaprak-sm.jpg 900w, <?php koi_v(); ?>img/yaprak.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="Duvara vuran yaprak gölgeleri" loading="lazy">
    <svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg>
  </div>
</section>
