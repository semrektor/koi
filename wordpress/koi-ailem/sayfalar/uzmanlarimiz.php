<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>Uzmanlarımız</span>
      </nav>
      <h1>Yolculuğunuzda<br>Yanınızdaki Ekip</h1>
    </div>
    <p class="lead">Çocuğu, ebeveyni ve aileyi birlikte ele alan; danışmanlık, oyun ve gelişim deneyimini aynı çatı altında buluşturan bir ekip.</p>
  </div>
</section>

<?php koi_kartlar( 'uzman-profilleri' ); ?>

<section class="section section--cream">
  <div class="container container--wide">
    <div class="section-head center reveal">
      <span class="eyebrow eyebrow--center">Çalışma İlkelerimiz</span>
      <h2>Nasıl Çalışıyoruz?</h2>
    </div>
    <div class="values">
      <div class="value reveal">
        <span class="value__num">01</span>
        <h3>Gizlilik</h3>
        <p>Tüm görüşmeler mesleki etik ilkeler ve gizlilik esasları çerçevesinde yürütülür.</p>
      </div>
      <div class="value reveal">
        <span class="value__num">02</span>
        <h3>Süpervizyon</h3>
        <p>Süreçler ekip içi değerlendirme ve süpervizyon ile desteklenir.</p>
      </div>
      <div class="value reveal">
        <span class="value__num">03</span>
        <h3>Aile Katılımı</h3>
        <p>Çocukla yürütülen hiçbir süreç aileden bağımsız ilerlemez.</p>
      </div>
      <div class="value reveal">
        <span class="value__num">04</span>
        <h3>Sürekli Eğitim</h3>
        <p>Uzmanlarımız alanlarındaki güncel eğitim ve gelişmeleri takip eder.</p>
      </div>
    </div>
  </div>
</section>

<section class="cta-band">
  <div class="media media--olive cta-band__media has-img" data-label="Detay görsel"><img class="media__img" src="<?php koi_v(); ?>img/yaprak.jpg" srcset="<?php koi_v(); ?>img/yaprak-sm.jpg 900w, <?php koi_v(); ?>img/yaprak.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="Duvara vuran yaprak gölgeleri" loading="lazy"></div>
  <div class="cta-band__inner reveal">
    <span class="eyebrow">Ekibimize Katılın</span>
    <h2>Birlikte Çalışmak İster misiniz?</h2>
    <p class="lead">Alanında uzman psikolojik danışman, çocuk gelişim uzmanı ve atölye eğitmenlerinin başvurularını bekliyoruz.</p>
    <div class="cta-band__row">
      <a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>">Başvuru Gönderin<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
      <a class="link-arrow" href="<?php echo esc_url( 'mailto:' . koi_ayar( 'eposta' ) ); ?>"><?php echo esc_html( koi_ayar( 'eposta' ) ); ?><svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
    </div>
  </div>
  <div class="media cta-band__media has-img" data-label="Detay görsel"><img class="media__img" src="<?php koi_v(); ?>img/yaprak.jpg" srcset="<?php koi_v(); ?>img/yaprak-sm.jpg 900w, <?php koi_v(); ?>img/yaprak.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="Duvara vuran yaprak gölgeleri" loading="lazy">
    <svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg>
  </div>
</section>
