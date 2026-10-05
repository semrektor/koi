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
        <span class="eyebrow">Takvim</span>
        <h2>Yaklaşan Programlar</h2>
      </div>
      <p class="lead">Kontenjanlar sınırlıdır; katılım için ön kayıt gerekmektedir.</p>
    </div>
    <div class="reveal" style="overflow-x:auto">
      <table class="schedule">
        <thead>
          <tr><th>Tarih</th><th>Program</th><th>Katılım</th><th>Durum</th></tr>
        </thead>
        <tbody>
          <tr>
            <td data-th="Tarih">Cumartesi · 10:30</td>
            <td data-th="Program">Duygu Kutusu — Çocuk Atölyesi (4-7 yaş)</td>
            <td data-th="Katılım">Çocuk</td>
            <td data-th="Durum"><span class="badge">Kayıt açık</span></td>
          </tr>
          <tr>
            <td data-th="Tarih">Cumartesi · 14:00</td>
            <td data-th="Program">Sınırlar ve Güvenli Bağ — Ebeveyn Atölyesi</td>
            <td data-th="Katılım">Ebeveyn</td>
            <td data-th="Durum"><span class="badge">Kayıt açık</span></td>
          </tr>
          <tr>
            <td data-th="Tarih">Pazar · 11:00</td>
            <td data-th="Program">Birlikte Oynuyoruz — Çocuk-Aile Buluşması</td>
            <td data-th="Katılım">Çocuk + Ebeveyn</td>
            <td data-th="Durum"><span class="badge badge--olive">Son kontenjan</span></td>
          </tr>
          <tr>
            <td data-th="Tarih">Pazar · 15:00</td>
            <td data-th="Program">Okula Uyum Süreci — Seminer</td>
            <td data-th="Katılım">Ebeveyn</td>
            <td data-th="Durum"><span class="badge">Kayıt açık</span></td>
          </tr>
        </tbody>
      </table>
    </div>
    <p class="muted" style="margin-top:22px;font-size:.82rem">Takvim taslak amaçlıdır. Yayın sonrası atölye ve seminerler yönetim panelinden eklenip güncellenebilecektir.</p>
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
