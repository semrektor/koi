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
        <button class="accordion__trigger" type="button" aria-expanded="true">Oyun grubu ile oyun terapisi arasındaki fark nedir?<svg aria-hidden="true"><use href="#i-plus"></use></svg></button>
        <div class="accordion__panel"><p>Oyun grupları, çocukların yaş ve gelişim özelliklerine uygun bir grup ortamında oyun oynama, keşfetme, iletişim kurma ve sosyal becerilerini destekleme amacı taşır.</p><p>Oyun terapisi ise bireysel ihtiyaçlara göre yapılandırılan profesyonel bir danışmanlık/terapi sürecidir. Çocuğun duygusal ve davranışsal ihtiyaçları değerlendirilerek uzman tarafından planlanır.</p><p>Kısacası, oyun grubu gelişimi destekleyen grup deneyimi; oyun terapisi ise çocuğun bireysel ihtiyaçlarına yönelik profesyonel bir süreçtir.</p></div>
      </div>
      <div class="accordion__item">
        <button class="accordion__trigger" type="button" aria-expanded="false">Çocuğum için danışmanlık mı, oyun grubu mu, atölye mi uygun?<svg aria-hidden="true"><use href="#i-plus"></use></svg></button>
        <div class="accordion__panel"><p>Bunu yalnızca yaşa bakarak belirlemek her zaman doğru değildir.</p><p>Çocuğun gelişimsel özellikleri, ihtiyaçları, sosyal becerileri, duygusal durumu ve ailenin beklentileri birlikte değerlendirilir. Ön görüşme sonrasında çocuğunuz için danışmanlık, oyun terapisi, oyun grubu veya atölye seçeneklerinden hangisinin daha uygun olduğu konusunda yönlendirme yapılabilir.</p><p>Amacımız belirli bir hizmeti sunmak değil, çocuğun ihtiyacına uygun olan alanı belirlemektir.</p></div>
      </div>
      <div class="accordion__item">
        <button class="accordion__trigger" type="button" aria-expanded="false">İlk görüşme nasıl ilerliyor?<svg aria-hidden="true"><use href="#i-plus"></use></svg></button>
        <div class="accordion__panel"><p>İlk görüşme, öncelikle çocuğunuzun ve ailenizin ihtiyaçlarını anlamaya yönelik bir ön değerlendirme ve tanışma süreci olarak ilerler.</p><p>Çocuğun gelişim öyküsü, mevcut ihtiyaçlar, aile ve okul yaşamı gibi konular ele alınır. İhtiyaca göre danışmanlık, oyun terapisi, oyun grubu veya farklı bir çalışma önerilebilir.</p><p>Amaç, her aileyi tek bir programa yönlendirmek değil; ihtiyaca uygun yolu birlikte belirlemektir.</p></div>
      </div>
      <div class="accordion__item">
        <button class="accordion__trigger" type="button" aria-expanded="false">Ebeveyn görüşmeye katılır mı?<svg aria-hidden="true"><use href="#i-plus"></use></svg></button>
        <div class="accordion__panel"><p>Sürecin niteliğine göre ebeveyn katılımı değişebilir.</p><p>Özellikle çocukla yürütülen danışmanlık ve oyun terapisi süreçlerinde ebeveyn görüşmeleri, çocuğun gelişimini ve süreci daha bütüncül değerlendirmek açısından önemli bir yer tutar.</p><p>Ebeveynle ne sıklıkta ve hangi kapsamda görüşüleceği, çocuğun ihtiyaçlarına ve yürütülen çalışmanın yapısına göre belirlenir.</p></div>
      </div>
      <div class="accordion__item">
        <button class="accordion__trigger" type="button" aria-expanded="false">Ücret bilgisi nasıl alabilirim?<svg aria-hidden="true"><use href="#i-plus"></use></svg></button>
        <div class="accordion__panel"><p>Ücretler hizmete, uzmana ve programa göre değiştiği için sitede sabit fiyat yayınlamıyoruz. Güncel bilgi için iletişim formunu doldurabilir veya bize ulaşabilirsiniz.</p></div>
      </div>
    </div>
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
