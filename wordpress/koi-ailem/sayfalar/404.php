<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="section">
  <div class="container container--wide split split--narrow" style="align-items:center">
    <div class="split__body">
      <span class="eyebrow">404</span>
      <h1>Aradığınız Sayfayı<br>Bulamadık</h1>
      <p class="lead">Bağlantı değişmiş ya da sayfa kaldırılmış olabilir. Aşağıdaki bölümlerden devam edebilir veya doğrudan bize ulaşabilirsiniz.</p>
      <div style="margin-top:32px;display:flex;gap:14px;flex-wrap:wrap">
        <a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Ana Sayfaya Dön<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
        <a class="btn btn--ghost" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>">İletişime Geçin</a>
      </div>

      <div style="margin-top:44px">
        <p class="eyebrow" style="margin-bottom:16px">Sık Ziyaret Edilenler</p>
        <ul style="display:flex;flex-wrap:wrap;gap:10px 24px">
          <li><a class="link-arrow" href="<?php echo esc_url( koi_url( 'hizmetler' ) ); ?>">Hizmetler<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a></li>
          <li><a class="link-arrow" href="<?php echo esc_url( koi_url( 'oyun-gruplari' ) ); ?>">Oyun Grupları<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a></li>
          <li><a class="link-arrow" href="<?php echo esc_url( koi_url( 'atolyeler' ) ); ?>">Atölyeler<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a></li>
          <li><a class="link-arrow" href="<?php echo esc_url( koi_url( 'blog' ) ); ?>">Blog<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a></li>
        </ul>
      </div>
    </div>

    <div class="split__media">
      <div class="media media--arch media--ratio-4-5 has-img" data-label="">
        <img class="media__img" src="<?php koi_v(); ?>img/hero-kemer.jpg" srcset="<?php koi_v(); ?>img/hero-kemer-sm.jpg 900w, <?php koi_v(); ?>img/hero-kemer.jpg 1400w" sizes="(max-width: 700px) 100vw, 45vw" alt="KOI merkezinde kemerli dinlenme alanı" loading="lazy">
      </div>
    </div>
  </div>
</section>
