<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<!-- ============ HERO ============ -->
  <section class="hero">
    <div class="container container--wide hero__grid">
      <div class="hero__copy">
        <span class="eyebrow">KOI · Çocuk ve Aile Gelişim Merkezi</span>
        <h1 class="hero__title">İyi İnsanlar,<br>İyi Hikâyeler <em>Büyütür.</em></h1>
        <p class="lead">Çocukların, ebeveynlerin ve ailelerin iyi olma halini destekleyen bütüncül bir gelişim merkezi. Danışmanlık, oyun ve atölye deneyimini aynı çatı altında buluşturuyoruz.</p>
        <div class="hero__actions">
          <a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'hakkimizda' ) ); ?>">KOI'yi Keşfet<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
          <a class="btn btn--ghost" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>">Bilgi Al</a>
        </div>
        <p class="hero__note">Ümraniye · İstanbul</p>
      </div>
      <div class="hero__visual">
        <div class="media media--arch hero__media has-img" data-label="Merkez karşılama alanı — çekim yapılacak"><img class="media__img" src="<?php koi_v(); ?>img/hero-kemer.jpg" srcset="<?php koi_v(); ?>img/hero-kemer-sm.jpg 900w, <?php koi_v(); ?>img/hero-kemer.jpg 1400w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="KOI merkezinde kemerli dinlenme alanı" loading="lazy">
          <svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg>
        </div>
        <ul class="hero__tags">
          <li>Oyun</li>
          <li>Danışmanlık</li>
          <li>Atölye</li>
          <li>Gelişim</li>
          <li>Birliktelik</li>
          <li class="hero__script script">iyi insan<br>iyi gelecek</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ============ HIZMET SERIDI ============ -->
  <section class="pillars">
    <div class="container container--wide">
      <ul class="pillars__grid">
        <li class="pillar reveal"><svg aria-hidden="true"><use href="#i-lotus"></use></svg><span>Çocuk<br>Gelişimi</span></li>
        <li class="pillar reveal"><svg aria-hidden="true"><use href="#i-leaf"></use></svg><span>Aile<br>Danışmanlığı</span></li>
        <li class="pillar reveal"><svg aria-hidden="true"><use href="#i-sun"></use></svg><span>Atölye ve<br>Workshoplar</span></li>
        <li class="pillar reveal"><svg aria-hidden="true"><use href="#i-arch"></use></svg><span>Ebeveyn<br>Destek Programları</span></li>
        <li class="pillar reveal"><svg aria-hidden="true"><use href="#i-sprout"></use></svg><span>Akademik ve<br>Sosyal Gelişim</span></li>
      </ul>
    </div>
  </section>

  <!-- ============ KOI NEDIR ============ -->
  <section class="section">
    <div class="container container--wide split split--narrow">
      <div class="split__media reveal">
        <div class="quote-card">
          <blockquote>"Her çocuğun kendi ritmi vardır. Her ailenin kendi hikâyesi."</blockquote>
          <cite>KOI Yaklaşımı</cite>
        </div>
        <div class="media media--soft media--ratio-3-2 has-img" style="margin-top:22px" data-label="Atölye / çalışma alanı"><img class="media__img" src="<?php koi_v(); ?>img/atolye-masa.jpg" srcset="<?php koi_v(); ?>img/atolye-masa-sm.jpg 900w, <?php koi_v(); ?>img/atolye-masa.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="KOI atölye çalışma masası" loading="lazy">
          <svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg>
        </div>
      </div>
      <div class="split__body reveal">
        <span class="eyebrow">Hakkımızda</span>
        <h2>KOI Nedir?</h2>
        <p>KOI; psikolojik danışmanlık, aile ve ebeveyn çalışmaları, oyun, gelişim programları ve atölyeleri aynı çatı altında buluşturan çocuk ve aile odaklı bir gelişim merkezidir.</p>
        <p>Her çocuğu, her ebeveyni ve her aileyi kendi ihtiyaçları ve ritmi içinde ele alıyoruz. Hazır kalıplar sunmak yerine; dinlemeye, anlamaya ve ihtiyaca uygun alanı birlikte oluşturmaya önem veriyoruz.</p>
        <ul class="tagline-stack">
          <li>Denge</li>
          <li>Bağlantı</li>
          <li>Gelişim</li>
        </ul>
        <div style="margin-top:32px">
          <a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'hakkimizda' ) ); ?>">Hikâyemiz<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ HIZMETLER ============ -->
  <section class="section section--cream">
    <div class="container container--wide">
      <div class="section-head section-head--split reveal">
        <div>
          <span class="eyebrow">Hizmetlerimiz</span>
          <h2>Sizin İçin<br>Neler Sunuyoruz?</h2>
        </div>
        <p class="lead">Her bireyin ve ailenin kendine özgü ihtiyaçlarına uygun, uzmanlıkla tasarlanmış hizmetler.</p>
      </div>
      <div class="cards cards--5" id="hizmet-kartlari">
<?php koi_kartlar( 'hizmet-kartlari' ); ?>
      </div>
    </div>
</section>

  <!-- ============ YAKLASIM ============ -->
  <section class="section">
    <div class="container container--wide">
      <div class="section-head center reveal">
        <span class="eyebrow eyebrow--center">Yaklaşımımız</span>
        <h2>Neden KOI?</h2>
        <p class="lead">Ailelerin kendilerini güvende hissedeceği, çocukların özgürce keşfedebileceği nitelikli bir alan.</p>
      </div>
      <div class="values">
        <div class="value reveal">
          <span class="value__num">01</span>
          <h3>Bütüncül Bakış</h3>
          <p>Çocuğu tek başına değil; ailesi, okulu ve çevresiyle birlikte ele alırız.</p>
        </div>
        <div class="value reveal">
          <span class="value__num">02</span>
          <h3>Oyun Temelli</h3>
          <p>Oyunu bir yöntem olarak kullanır, gelişimi çocuğun kendi dilinden destekleriz.</p>
        </div>
        <div class="value reveal">
          <span class="value__num">03</span>
          <h3>Küçük Gruplar</h3>
          <p>Seans başına en fazla 6 çocuk ile her katılımcıya yeterli alan ve ilgi.</p>
        </div>
        <div class="value reveal">
          <span class="value__num">04</span>
          <h3>Uzman Kadro</h3>
          <p>Alanında eğitimli psikolojik danışman ve uzmanlarla yürütülen süreçler.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ PROGRAM BANDI ============ -->
  <section class="program-band">
    <div class="program-band__copy reveal">
      <span class="eyebrow">Oyun Grupları</span>
      <h2>Oyunun İçinde<br>Büyüyen Gelişim</h2>
      <p class="lead">Haftanın 5 günü, günde 2 seans olarak planlanan oyun gruplarımız; yaş ve gelişim dönemine göre ayrıştırılır.</p>
      <ul class="program-band__list">
        <li><svg aria-hidden="true"><use href="#i-check"></use></svg><span>Seans başına en fazla 6 çocuk ile küçük grup çalışması</span></li>
        <li><svg aria-hidden="true"><use href="#i-check"></use></svg><span>Yaş gruplarına göre ayrıştırılmış program akışı</span></li>
        <li><svg aria-hidden="true"><use href="#i-check"></use></svg><span>Çocuk, ebeveyn ve çocuk-aile katılımlı tematik atölyeler</span></li>
        <li><svg aria-hidden="true"><use href="#i-check"></use></svg><span>Hafta sonu seminer ve workshop programları</span></li>
      </ul>
      <div style="margin-top:34px;display:flex;gap:14px;flex-wrap:wrap">
        <a class="btn btn--terra" href="<?php echo esc_url( koi_url( 'oyun-gruplari' ) ); ?>">Programları İncele<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
        <a class="btn btn--light" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>">Ön Başvuru</a>
      </div>
    </div>
    <div class="media media--olive program-band__media has-img" data-label="Oyun odası — çekim yapılacak"><img class="media__img" src="<?php koi_v(); ?>img/oyun-odasi.jpg" srcset="<?php koi_v(); ?>img/oyun-odasi-sm.jpg 900w, <?php koi_v(); ?>img/oyun-odasi.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="KOI oyun grubu odası" loading="lazy">
      <svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg>
    </div>
  </section>

  <!-- ============ UZMANLAR ============ -->
  <section class="section section--cream">
    <div class="container container--wide">
      <div class="section-head section-head--split reveal">
        <div>
          <span class="eyebrow">Ekibimiz</span>
          <h2>Yolculuğunuzda<br>Yanınızdayız</h2>
        </div>
        <p class="lead">Danışmanlık yaklaşımını oyun ve gelişim deneyimiyle buluşturan kurucu ekibimiz. Uzman kadromuz açılış dönemiyle birlikte tanıtılacak.</p>
      </div>
      <div class="cards cards--4">
        <article class="expert reveal">
          <div class="media media--ratio-3-4 media--mono" data-label="Fotoğraf çekim sonrası eklenecek" data-mono="EB"><svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg></div>
          <h3 class="expert__name">Elif Bilsel</h3>
          <p class="expert__role">Psikolojik Danışman · Aile Danışmanı</p>
          <p class="expert__text">Çocuk ve ergen gelişimi, aile ve ebeveyn danışmanlığı, çocuk merkezli oyun terapisi.</p>
        </article>
        <article class="expert reveal">
          <div class="media media--ratio-3-4 media--mono" data-label="Fotoğraf çekim sonrası eklenecek" data-mono="DŞ"><svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg></div>
          <h3 class="expert__name">Dilek Şevik</h3>
          <p class="expert__role">Kurucu Ortak</p>
          <p class="expert__text">Eğitim kurumlarında yöneticilik ve koordinatörlük; veli ilişkileri ve kurumsal iletişim.</p>
        </article>
      </div>
      <div style="margin-top:44px" class="reveal">
        <a class="btn btn--ghost" href="<?php echo esc_url( koi_url( 'uzmanlarimiz' ) ); ?>">Ekibimizi Tanıyın<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
      </div>
    </div>
  </section>


  <!-- ============ BLOG ============ -->
<?php if ( koi_yazi_var() ) : ?>
  <section class="section section--cream">
    <div class="container container--wide">
      <div class="section-head section-head--split reveal">
        <div>
          <span class="eyebrow">Blog</span>
          <h2>Ailelere Notlar</h2>
        </div>
        <p class="lead">Gelişim, ebeveynlik ve oyun üzerine uzmanlarımızın kaleminden yazılar.</p>
      </div>
      <div class="cards cards--3" id="blog-kartlari">
<?php koi_kartlar( 'blog-kartlari' ); ?>
      </div>
    </div>
</section>
<?php endif; ?>

  <!-- ============ GALERI ============ -->
  <section class="section section--tight">
    <div class="container container--wide">
      <div class="section-head section-head--split reveal">
        <div>
          <span class="eyebrow">Galeri</span>
          <h2>Merkezimizden</h2>
        </div>
        <p class="lead">Mekânımızın ruhunu yansıtan temsili görseller. Merkezimiz açıldığında kendi fotoğraflarımızla güncellenecek.</p>
      </div>
      <div class="gallery reveal">
        <div class="media media--span2 media--row2 has-img" data-label="Karşılama alanı"><img class="media__img" src="<?php koi_v(); ?>img/karsilama.jpg" srcset="<?php koi_v(); ?>img/karsilama-sm.jpg 900w, <?php koi_v(); ?>img/karsilama.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="KOI merkezinin karşılama alanı" loading="lazy"><svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg></div>
        <div class="media has-img" data-label="Oyun odası"><img class="media__img" src="<?php koi_v(); ?>img/oyun-odasi.jpg" srcset="<?php koi_v(); ?>img/oyun-odasi-sm.jpg 900w, <?php koi_v(); ?>img/oyun-odasi.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="KOI oyun grubu odası" loading="lazy"></div>
        <div class="media media--olive has-img" data-label="Danışmanlık odası"><img class="media__img" src="<?php koi_v(); ?>img/danismanlik.jpg" srcset="<?php koi_v(); ?>img/danismanlik-sm.jpg 900w, <?php koi_v(); ?>img/danismanlik.jpg 1400w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="KOI danışmanlık odası" loading="lazy"></div>
        <div class="media media--olive has-img" data-label="Atölye"><img class="media__img" src="<?php koi_v(); ?>img/atolye-masa.jpg" srcset="<?php koi_v(); ?>img/atolye-masa-sm.jpg 900w, <?php koi_v(); ?>img/atolye-masa.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="KOI atölye çalışma masası" loading="lazy"></div>
        <div class="media has-img" data-label="Bekleme alanı"><img class="media__img" src="<?php koi_v(); ?>img/karsilama.jpg" srcset="<?php koi_v(); ?>img/karsilama-sm.jpg 900w, <?php koi_v(); ?>img/karsilama.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="KOI merkezinin karşılama alanı" loading="lazy"></div>
      </div>
      <div style="margin-top:34px" class="reveal">
        <a class="link-arrow" href="<?php echo esc_url( koi_url( 'galeri' ) ); ?>">Tüm Galeri<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
      </div>
    </div>
  </section>

  <!-- ============ CTA ============ -->
  <section class="cta-band">
    <div class="media media--olive cta-band__media has-img" data-label="Detay görsel"><img class="media__img" src="<?php koi_v(); ?>img/yaprak.jpg" srcset="<?php koi_v(); ?>img/yaprak-sm.jpg 900w, <?php koi_v(); ?>img/yaprak.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="Duvara vuran yaprak gölgeleri" loading="lazy"></div>
    <div class="cta-band__inner reveal">
      <span class="eyebrow">Bilgi Al</span>
      <h2>İyi Bir Gelecek İçin Buradayız.</h2>
      <p class="lead">Siz de KOI yolculuğunun bir parçası olun. Ön başvuru formunu doldurun, uzmanlarımız sizinle iletişime geçsin.</p>
      <div class="cta-band__row">
        <a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>">Bilgi Alın<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
        <a class="link-arrow" href="<?php echo esc_url( koi_wa_url() ); ?>">WhatsApp'tan Yazın<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
      </div>
    </div>
    <div class="media cta-band__media has-img" data-label="Detay görsel"><img class="media__img" src="<?php koi_v(); ?>img/yaprak.jpg" srcset="<?php koi_v(); ?>img/yaprak-sm.jpg 900w, <?php koi_v(); ?>img/yaprak.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="Duvara vuran yaprak gölgeleri" loading="lazy">
      <svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg>
    </div>
  </section>
