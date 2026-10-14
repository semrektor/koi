<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>Oyun Grupları</span>
      </nav>
      <h1<?php koi_isaret( 'oyun-gruplari-1-baslik1' ); ?>><?php koi_alan( 'oyun-gruplari-1-baslik1' ); ?></h1>
    </div>
    <p class="lead"<?php koi_isaret( 'oyun-gruplari-1-giris1' ); ?>><?php koi_alan( 'oyun-gruplari-1-giris1' ); ?></p>
  </div>
</section>

<section class="section">
  <div class="container container--wide split">
    <div class="split__media reveal">
      <?php koi_gorsel( 'oyun-gruplari-2-gorsel1' ); ?>
    </div>
    <div class="split__body reveal">
      <span class="eyebrow"<?php koi_isaret( 'oyun-gruplari-2-ust1' ); ?>><?php koi_alan( 'oyun-gruplari-2-ust1' ); ?></span>
      <h2<?php koi_isaret( 'oyun-gruplari-2-baslik1' ); ?>><?php koi_alan( 'oyun-gruplari-2-baslik1' ); ?></h2>
      <p<?php koi_isaret( 'oyun-gruplari-2-paragraf1' ); ?>><?php koi_alan( 'oyun-gruplari-2-paragraf1' ); ?></p>
      <p<?php koi_isaret( 'oyun-gruplari-2-paragraf2' ); ?>><?php koi_alan( 'oyun-gruplari-2-paragraf2' ); ?></p>
      <ul class="tagline-stack"<?php koi_isaret( 'oyun-gruplari-2-liste1' ); ?>><?php koi_liste( 'oyun-gruplari-2-liste1' ); ?></ul>
      <div style="margin-top:30px">
        <a class="btn btn--primary" href="#basvuru"<?php koi_isaret( 'oyun-gruplari-2-dugme1' ); ?>><?php koi_alan( 'oyun-gruplari-2-dugme1' ); ?></a>
      </div>
    </div>
  </div>
</section>

<section class="section section--cream">
  <div class="container container--wide">
    <div class="section-head section-head--split reveal">
      <div>
        <span class="eyebrow"<?php koi_isaret( 'oyun-gruplari-3-ust1' ); ?>><?php koi_alan( 'oyun-gruplari-3-ust1' ); ?></span>
        <h2<?php koi_isaret( 'oyun-gruplari-3-baslik1' ); ?>><?php koi_alan( 'oyun-gruplari-3-baslik1' ); ?></h2>
      </div>
      <p class="lead"<?php koi_isaret( 'oyun-gruplari-3-giris1' ); ?>><?php koi_alan( 'oyun-gruplari-3-giris1' ); ?></p>
    </div>
    <div class="cards cards--4">
<?php koi_kartlar( 'grup-kartlari' ); ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container container--wide">
    <div class="section-head section-head--split reveal">
      <div>
        <span class="eyebrow"<?php koi_isaret( 'oyun-gruplari-4-ust1' ); ?>><?php koi_alan( 'oyun-gruplari-4-ust1' ); ?></span>
        <h2<?php koi_isaret( 'oyun-gruplari-4-baslik1' ); ?>><?php koi_alan( 'oyun-gruplari-4-baslik1' ); ?></h2>
      </div>
      <p class="lead"<?php koi_isaret( 'oyun-gruplari-4-giris1' ); ?>><?php koi_alan( 'oyun-gruplari-4-giris1' ); ?></p>
    </div>
    <div class="reveal" style="overflow-x:auto">
      <table class="schedule">
        <thead>
          <tr><th>Grup</th><th>Yaş</th><th>Gün ve Saat</th><th>Kontenjan</th><th>Ebeveyn Katılımı</th></tr>
        </thead>
        <tbody>
<?php koi_kartlar( 'grup-tablosu' ); ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="program-band">
  <div class="program-band__copy reveal">
    <span class="eyebrow"<?php koi_isaret( 'oyun-gruplari-5-ust1' ); ?>><?php koi_alan( 'oyun-gruplari-5-ust1' ); ?></span>
    <h2<?php koi_isaret( 'oyun-gruplari-5-baslik1' ); ?>><?php koi_alan( 'oyun-gruplari-5-baslik1' ); ?></h2>
    <p class="lead"<?php koi_isaret( 'oyun-gruplari-5-giris1' ); ?>><?php koi_alan( 'oyun-gruplari-5-giris1' ); ?></p>
    <ul class="program-band__list"<?php koi_isaret( 'oyun-gruplari-5-liste1' ); ?>><?php koi_liste( 'oyun-gruplari-5-liste1' ); ?></ul>
  </div>
  <?php koi_gorsel( 'oyun-gruplari-5-gorsel1' ); ?>
</section>

<section class="section">
  <div class="container container--wide">
    <div class="section-head section-head--split reveal">
      <div>
        <span class="eyebrow"<?php koi_isaret( 'oyun-gruplari-6-ust1' ); ?>><?php koi_alan( 'oyun-gruplari-6-ust1' ); ?></span>
        <h2<?php koi_isaret( 'oyun-gruplari-6-baslik1' ); ?>><?php koi_alan( 'oyun-gruplari-6-baslik1' ); ?></h2>
      </div>
      <p class="lead"<?php koi_isaret( 'oyun-gruplari-6-giris1' ); ?>><?php koi_alan( 'oyun-gruplari-6-giris1' ); ?></p>
    </div>
    <div class="timeline">
      <div class="timeline__item reveal">
        <div class="timeline__when">01</div>
        <div class="timeline__what">
          <h3<?php koi_isaret( 'oyun-gruplari-6-ara1' ); ?>><?php koi_alan( 'oyun-gruplari-6-ara1' ); ?></h3>
          <p<?php koi_isaret( 'oyun-gruplari-6-paragraf1' ); ?>><?php koi_alan( 'oyun-gruplari-6-paragraf1' ); ?></p>
        </div>
      </div>
      <div class="timeline__item reveal">
        <div class="timeline__when">02</div>
        <div class="timeline__what">
          <h3<?php koi_isaret( 'oyun-gruplari-6-ara2' ); ?>><?php koi_alan( 'oyun-gruplari-6-ara2' ); ?></h3>
          <p<?php koi_isaret( 'oyun-gruplari-6-paragraf2' ); ?>><?php koi_alan( 'oyun-gruplari-6-paragraf2' ); ?></p>
        </div>
      </div>
      <div class="timeline__item reveal">
        <div class="timeline__when">03</div>
        <div class="timeline__what">
          <h3<?php koi_isaret( 'oyun-gruplari-6-ara3' ); ?>><?php koi_alan( 'oyun-gruplari-6-ara3' ); ?></h3>
          <p<?php koi_isaret( 'oyun-gruplari-6-paragraf3' ); ?>><?php koi_alan( 'oyun-gruplari-6-paragraf3' ); ?></p>
        </div>
      </div>
      <div class="timeline__item reveal">
        <div class="timeline__when">04</div>
        <div class="timeline__what">
          <h3<?php koi_isaret( 'oyun-gruplari-6-ara4' ); ?>><?php koi_alan( 'oyun-gruplari-6-ara4' ); ?></h3>
          <p<?php koi_isaret( 'oyun-gruplari-6-paragraf4' ); ?>><?php koi_alan( 'oyun-gruplari-6-paragraf4' ); ?></p>
        </div>
      </div>
      <div class="timeline__item reveal">
        <div class="timeline__when">05</div>
        <div class="timeline__what">
          <h3<?php koi_isaret( 'oyun-gruplari-6-ara5' ); ?>><?php koi_alan( 'oyun-gruplari-6-ara5' ); ?></h3>
          <p<?php koi_isaret( 'oyun-gruplari-6-paragraf5' ); ?>><?php koi_alan( 'oyun-gruplari-6-paragraf5' ); ?></p>
        </div>
      </div>
    </div>
    <p class="muted reveal" style="margin-top:22px;font-size:.86rem"<?php koi_isaret( 'oyun-gruplari-6-not1' ); ?>><?php koi_alan( 'oyun-gruplari-6-not1' ); ?></p>
  </div>
</section>

<section class="section section--cream" id="basvuru">
  <div class="container container--wide contact-grid">
    <div class="reveal">
      <span class="eyebrow"<?php koi_isaret( 'oyun-gruplari-7-ust1' ); ?>><?php koi_alan( 'oyun-gruplari-7-ust1' ); ?></span>
      <h2<?php koi_isaret( 'oyun-gruplari-7-baslik1' ); ?>><?php koi_alan( 'oyun-gruplari-7-baslik1' ); ?></h2>
      <p class="lead"<?php koi_isaret( 'oyun-gruplari-7-giris1' ); ?>><?php koi_alan( 'oyun-gruplari-7-giris1' ); ?></p>
      <ul class="info-list">
        <li>
          <svg aria-hidden="true"><use href="#i-users"></use></svg>
          <div><strong<?php koi_isaret( 'oyun-gruplari-7-kalin1' ); ?>><?php koi_alan( 'oyun-gruplari-7-kalin1' ); ?></strong><span<?php koi_isaret( 'oyun-gruplari-7-metin1' ); ?>><?php koi_alan( 'oyun-gruplari-7-metin1' ); ?></span></div>
        </li>
        <li>
          <svg aria-hidden="true"><use href="#i-clock"></use></svg>
          <div><strong<?php koi_isaret( 'oyun-gruplari-7-kalin2' ); ?>><?php koi_alan( 'oyun-gruplari-7-kalin2' ); ?></strong><span<?php koi_isaret( 'oyun-gruplari-7-metin2' ); ?>><?php koi_alan( 'oyun-gruplari-7-metin2' ); ?></span></div>
        </li>
        <li>
          <svg aria-hidden="true"><use href="#i-pin"></use></svg>
          <div><strong<?php koi_isaret( 'oyun-gruplari-7-kalin3' ); ?>><?php koi_alan( 'oyun-gruplari-7-kalin3' ); ?></strong><span><?php echo esc_html( koi_ayar( 'adres' ) ); ?></span></div>
        </li>
      </ul>
    </div>

    <form class="reveal" id="talep-formu" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
<?php koi_form_gizli( 'oyun-grubu' ); ?>
      <div class="form-grid">
        <div class="field">
          <label for="og-ad">Ad Soyad</label>
          <input id="og-ad" name="ad" type="text" placeholder="Ebeveyn ad soyad" required>
        </div>
        <div class="field">
          <label for="og-tel">Telefon / WhatsApp</label>
          <input id="og-tel" name="telefon" type="tel" placeholder="05xx xxx xx xx" required>
        </div>
        <div class="field">
          <label for="og-mail">E-posta</label>
          <input id="og-mail" name="eposta" type="email" placeholder="ornek@eposta.com">
        </div>
        <div class="field">
          <label for="og-yas">Çocuğun Yaşı</label>
          <input id="og-yas" name="yas" type="text" placeholder="Örn. 3,5 yaş">
        </div>
        <div class="field field--full">
          <label for="og-grup">İlgilenilen Grup</label>
          <select id="og-grup" name="grup">
<?php koi_kartlar( 'grup-secenekleri' ); ?>
          </select>
        </div>
        <div class="field field--full">
          <label for="og-not">Eklemek İstedikleriniz</label>
          <textarea id="og-not" name="not" placeholder="Tercih ettiğiniz gün/saat veya paylaşmak istediğiniz notlar"></textarea>
        </div>
        <div class="field field--check field--full">
          <input id="og-kvkk" name="kvkk" type="checkbox" required>
          <label for="og-kvkk"><a href="<?php echo esc_url( koi_url( 'kvkk' ) ); ?>" style="border-bottom:1px solid var(--koi-linen)">KVKK Aydınlatma Metni</a>'ni okudum, kişisel verilerimin başvurum kapsamında işlenmesini onaylıyorum.</label>
        </div>
      </div>
      <div style="margin-top:22px">
        <button class="btn btn--primary" type="submit">Başvuruyu Gönder<svg aria-hidden="true"><use href="#i-arrow"></use></svg></button>
      </div>
      <?php koi_form_notu( '' ); ?>
    </form>
  </div>
</section>
