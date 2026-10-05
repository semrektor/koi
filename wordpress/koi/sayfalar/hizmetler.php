<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>Hizmetler</span>
      </nav>
      <h1>Her İhtiyaca<br>Uygun Bir Yol Var</h1>
    </div>
    <p class="lead">Bireysel danışmanlıktan aile programlarına, oyun gruplarından seminerlere; ihtiyacınıza göre kurgulanan hizmetler.</p>
  </div>
</section>

<section class="section">
  <div class="container container--wide">
    <div class="filters reveal" data-filter-group data-filter-target="#hizmet-listesi" role="group" aria-label="Hizmet filtresi">
      <button type="button" data-filter="all" class="is-active">Tümü</button>
      <button type="button" data-filter="danismanlik">Danışmanlık</button>
      <button type="button" data-filter="cocuk">Çocuk ve Ergen</button>
      <button type="button" data-filter="aile">Aile ve Ebeveyn</button>
      <button type="button" data-filter="grup">Grup Programları</button>
    </div>

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
    <div class="accordion reveal">
      <div class="accordion__item is-open">
        <button class="accordion__trigger" type="button" aria-expanded="true">İlk görüşme nasıl planlanıyor?<svg aria-hidden="true"><use href="#i-plus"></use></svg></button>
        <div class="accordion__panel">İletişim formunu doldurmanız ya da WhatsApp üzerinden yazmanız yeterli. Ekibimiz en kısa sürede dönüş yaparak ihtiyacınıza uygun uzmanı ve uygun saatleri birlikte belirler.</div>
      </div>
      <div class="accordion__item">
        <button class="accordion__trigger" type="button" aria-expanded="false">Görüşmelere çocuğumla birlikte mi gelmeliyim?<svg aria-hidden="true"><use href="#i-plus"></use></svg></button>
        <div class="accordion__panel">Bu, başvuru nedenine göre değişir. Bazı süreçler önce ebeveyn görüşmesiyle başlar, bazı süreçlerde çocukla doğrudan çalışılır. İlk görüşmede bu akış sizinle netleştirilir.</div>
      </div>
      <div class="accordion__item">
        <button class="accordion__trigger" type="button" aria-expanded="false">Oyun grubu kontenjanları kaç kişilik?<svg aria-hidden="true"><use href="#i-plus"></use></svg></button>
        <div class="accordion__panel">Oyun gruplarımız seans başına en fazla 6 çocuk ile planlanmaktadır. Küçük kontenjan, her çocuğa yeterli alan ve ilgi ayırabilmemizi sağlar.</div>
      </div>
      <div class="accordion__item">
        <button class="accordion__trigger" type="button" aria-expanded="false">Ücret bilgisi nasıl alabilirim?<svg aria-hidden="true"><use href="#i-plus"></use></svg></button>
        <div class="accordion__panel">Hizmet ve program ücretleri; süre, kapsam ve katılım biçimine göre değişmektedir. Güncel bilgi için iletişim formunu doldurabilir veya bize ulaşabilirsiniz.</div>
      </div>
      <div class="accordion__item">
        <button class="accordion__trigger" type="button" aria-expanded="false">Görüşmeler gizli tutuluyor mu?<svg aria-hidden="true"><use href="#i-plus"></use></svg></button>
        <div class="accordion__panel">Evet. Tüm görüşmeler mesleki etik ilkeler ve gizlilik esasları çerçevesinde yürütülür. Paylaşılan bilgiler üçüncü kişilerle paylaşılmaz.</div>
      </div>
    </div>
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
