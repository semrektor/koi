<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>Atölyeler</span>
      </nav>
      <h1>Birlikte Üretmenin<br>İyileştiren Hali</h1>
    </div>
    <p class="lead">Çocuk, ebeveyn ve çocuk-aile katılımlı tematik atölyeler; hafta sonlarında düzenlenen seminer ve workshop programları.</p>
  </div>
</section>

<section class="section">
  <div class="container container--wide">
    <div class="filters reveal" data-filter-group data-filter-target="#atolye-listesi" role="group" aria-label="Atölye filtresi">
      <button type="button" data-filter="all" class="is-active">Tümü</button>
      <button type="button" data-filter="cocuk">Çocuk Atölyeleri</button>
      <button type="button" data-filter="ebeveyn">Ebeveyn Atölyeleri</button>
      <button type="button" data-filter="aile">Çocuk-Aile</button>
      <button type="button" data-filter="seminer">Seminer</button>
    </div>

    <div class="cards cards--3" id="atolye-listesi">
<?php koi_kartlar( 'atolye-listesi' ); ?>
    </div>
  </div>
</section>

<section class="section section--cream">
  <div class="container container--wide">
    <div class="section-head section-head--split reveal">
      <div>
        <span class="eyebrow">Program</span>
        <h2>Açılış Dönemi Atölye ve Seminerleri</h2>
      </div>
      <p class="lead">Tarihler açılış takvimiyle birlikte duyurulacaktır.</p>
    </div>
    <div class="reveal" style="overflow-x:auto">
      <table class="schedule">
        <thead>
          <tr><th>Atölye / Seminer</th><th>Katılımcı</th><th>Tarih ve Saat</th><th>Süre</th><th>Kontenjan</th></tr>
        </thead>
        <tbody>
          <tr>
            <td data-th="Atölye / seminer">Duygularla Tanışmak</td>
            <td data-th="Katılımcı">Çocuk · 4–7 yaş</td>
            <td data-th="Tarih ve saat">Açılış takvimine göre</td>
            <td data-th="Süre">Programa göre</td>
            <td data-th="Kontenjan">Program kapasitesine göre</td>
          </tr>
          <tr>
            <td data-th="Atölye / seminer">Sınırlar, Bağ ve Güven</td>
            <td data-th="Katılımcı">Ebeveyn</td>
            <td data-th="Tarih ve saat">Açılış takvimine göre</td>
            <td data-th="Süre">Programa göre</td>
            <td data-th="Kontenjan">Program kapasitesine göre</td>
          </tr>
          <tr>
            <td data-th="Atölye / seminer">Birlikte Oyun, Birlikte Bağ</td>
            <td data-th="Katılımcı">Çocuk + aile</td>
            <td data-th="Tarih ve saat">Açılış takvimine göre</td>
            <td data-th="Süre">Programa göre</td>
            <td data-th="Kontenjan">Program kapasitesine göre</td>
          </tr>
          <tr>
            <td data-th="Atölye / seminer">Hikâye, Hayal ve Yaratıcılık</td>
            <td data-th="Katılımcı">Çocuk · 5–8 yaş</td>
            <td data-th="Tarih ve saat">Açılış takvimine göre</td>
            <td data-th="Süre">Programa göre</td>
            <td data-th="Kontenjan">Program kapasitesine göre</td>
          </tr>
          <tr>
            <td data-th="Atölye / seminer">Okula Uyum ve Yeni Başlangıçlar</td>
            <td data-th="Katılımcı">Ebeveyn</td>
            <td data-th="Tarih ve saat">Dönemsel</td>
            <td data-th="Süre">Programa göre</td>
            <td data-th="Kontenjan">Program kapasitesine göre</td>
          </tr>
          <tr>
            <td data-th="Atölye / seminer">İlk Yıl: Anne-Bebek Yolculuğu</td>
            <td data-th="Katılımcı">Anne / ebeveyn</td>
            <td data-th="Tarih ve saat">Dönemsel</td>
            <td data-th="Süre">Programa göre</td>
            <td data-th="Kontenjan">Program kapasitesine göre</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="section">
  <div class="container container--wide">
    <div class="section-head section-head--split reveal">
      <div>
        <span class="eyebrow">Başvuru</span>
        <h2>Başvuru Nasıl Yapılır?</h2>
      </div>
      <p class="lead">İlk bilgi talebinden kayda kadar süreç beş adımda ilerler.</p>
    </div>
    <div class="timeline">
      <div class="timeline__item reveal">
        <div class="timeline__when">01</div>
        <div class="timeline__what">
          <h3>Bilgi Talebi</h3>
          <p>Hizmet, oyun grubu veya atölye için form ya da WhatsApp üzerinden bilgi talep edersiniz.</p>
        </div>
      </div>
      <div class="timeline__item reveal">
        <div class="timeline__when">02</div>
        <div class="timeline__what">
          <h3>İhtiyacın Netleşmesi</h3>
          <p>KOI ekibi ihtiyacı ve uygun programı sizinle birlikte netleştirir.</p>
        </div>
      </div>
      <div class="timeline__item reveal">
        <div class="timeline__when">03</div>
        <div class="timeline__what">
          <h3>Gün, Saat ve Kontenjan</h3>
          <p>Uygun gün, saat ve kontenjan kesinleştirilir.</p>
        </div>
      </div>
      <div class="timeline__item reveal">
        <div class="timeline__when">04</div>
        <div class="timeline__what">
          <h3>Ön Görüşme</h3>
          <p>Gerekli bir ön görüşme ya da değerlendirme varsa planlanır.</p>
        </div>
      </div>
      <div class="timeline__item reveal">
        <div class="timeline__when">05</div>
        <div class="timeline__what">
          <h3>Kayıt</h3>
          <p>Kayıt ve ödeme bilgileri KOI tarafından sizinle paylaşılır.</p>
        </div>
      </div>
    </div>
    <p class="muted reveal" style="margin-top:22px;font-size:.86rem">Danışmanlık hizmetlerinde ilk görüşme öncesinde ihtiyaç değerlendirmesi yapılabilir.</p>
  </div>
</section>

<section class="cta-band">
  <div class="media media--olive cta-band__media has-img" data-label="Detay görsel"><img class="media__img" src="<?php koi_v(); ?>img/yaprak.jpg" srcset="<?php koi_v(); ?>img/yaprak-sm.jpg 900w, <?php koi_v(); ?>img/yaprak.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="Duvara vuran yaprak gölgeleri" loading="lazy"></div>
  <div class="cta-band__inner reveal">
    <span class="eyebrow">Atölye Başvurusu</span>
    <h2>Bir Sonraki Buluşmada Yerinizi Ayırtın</h2>
    <p class="lead">Kontenjanlar sınırlı olduğu için başvurular sırayla değerlendirilir.</p>
    <div class="cta-band__row">
      <a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>">Atölye Başvurusu<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
      <a class="link-arrow" href="<?php echo esc_url( koi_wa_url() ); ?>">WhatsApp'tan Sorun<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
    </div>
  </div>
  <div class="media cta-band__media has-img" data-label="Detay görsel"><img class="media__img" src="<?php koi_v(); ?>img/yaprak.jpg" srcset="<?php koi_v(); ?>img/yaprak-sm.jpg 900w, <?php koi_v(); ?>img/yaprak.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="Duvara vuran yaprak gölgeleri" loading="lazy">
    <svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg>
  </div>
</section>
