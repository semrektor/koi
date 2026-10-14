<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>İletişim</span>
      </nav>
      <h1<?php koi_isaret( 'iletisim-1-baslik1' ); ?>><?php koi_alan( 'iletisim-1-baslik1' ); ?></h1>
    </div>
    <p class="lead"<?php koi_isaret( 'iletisim-1-giris1' ); ?>><?php koi_alan( 'iletisim-1-giris1' ); ?></p>
  </div>
</section>

<section class="section">
  <div class="container container--wide contact-grid">
    <div class="reveal">
      <span class="eyebrow"<?php koi_isaret( 'iletisim-2-ust1' ); ?>><?php koi_alan( 'iletisim-2-ust1' ); ?></span>
      <h2<?php koi_isaret( 'iletisim-2-baslik1' ); ?>><?php koi_alan( 'iletisim-2-baslik1' ); ?></h2>
      <p class="lead"<?php koi_isaret( 'iletisim-2-giris1' ); ?>><?php koi_alan( 'iletisim-2-giris1' ); ?></p>
      <ul class="info-list">
        <li>
          <svg aria-hidden="true"><use href="#i-pin"></use></svg>
          <div><strong<?php koi_isaret( 'iletisim-2-kalin1' ); ?>><?php koi_alan( 'iletisim-2-kalin1' ); ?></strong><span><?php echo esc_html( koi_ayar( 'acik_adres' ) ); ?></span></div>
        </li>
        <li>
          <svg aria-hidden="true"><use href="#i-phone"></use></svg>
          <div><strong<?php koi_isaret( 'iletisim-2-kalin2' ); ?>><?php koi_alan( 'iletisim-2-kalin2' ); ?></strong><span><a href="<?php echo esc_url( koi_tel_url() ); ?>"><?php echo esc_html( koi_ayar( 'telefon' ) ); ?></a></span></div>
        </li>
        <li>
          <svg aria-hidden="true"><use href="#i-pin"></use></svg>
          <div><strong<?php koi_isaret( 'iletisim-2-kalin3' ); ?>><?php koi_alan( 'iletisim-2-kalin3' ); ?></strong><span><?php echo esc_html( koi_ayar( 'ulasim' ) ); ?></span></div>
        </li>
        <li>
          <svg aria-hidden="true"><use href="#i-mail"></use></svg>
          <div><strong<?php koi_isaret( 'iletisim-2-kalin4' ); ?>><?php koi_alan( 'iletisim-2-kalin4' ); ?></strong><span><a href="<?php echo esc_url( 'mailto:' . koi_ayar( 'eposta' ) ); ?>"><?php echo esc_html( koi_ayar( 'eposta' ) ); ?></a></span></div>
        </li>
        <li>
          <svg aria-hidden="true"><use href="#i-clock"></use></svg>
          <div><strong<?php koi_isaret( 'iletisim-2-kalin5' ); ?>><?php koi_alan( 'iletisim-2-kalin5' ); ?></strong><span><?php echo esc_html( koi_ayar( 'saat1' ) ); ?><br><?php echo esc_html( koi_ayar( 'saat2' ) ); ?></span></div>
        </li>
        <li>
          <svg aria-hidden="true"><use href="#i-ig"></use></svg>
          <div><strong<?php koi_isaret( 'iletisim-2-kalin6' ); ?>><?php koi_alan( 'iletisim-2-kalin6' ); ?></strong><span><a href="<?php echo esc_url( koi_ayar( 'instagram' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( koi_instagram_adi() ); ?></a></span></div>
        </li>
      </ul>

      <div style="margin-top:34px;display:flex;gap:12px;flex-wrap:wrap">
        <a class="btn btn--primary" href="<?php echo esc_url( koi_wa_url() ); ?>"<?php koi_isaret( 'iletisim-2-dugme1' ); ?>><?php koi_alan( 'iletisim-2-dugme1' ); ?></a>
        <a class="btn btn--ghost" href="<?php echo esc_url( koi_tel_url() ); ?>"<?php koi_isaret( 'iletisim-2-dugme2' ); ?>><?php koi_alan( 'iletisim-2-dugme2' ); ?></a>
      </div>
    </div>

    <form class="reveal" id="talep-formu" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
<?php koi_form_gizli( 'iletisim' ); ?>
      <span class="eyebrow"<?php koi_isaret( 'iletisim-2-ust2' ); ?>><?php koi_alan( 'iletisim-2-ust2' ); ?></span>
      <h2 style="margin-bottom:.8em"<?php koi_isaret( 'iletisim-2-baslik2' ); ?>><?php koi_alan( 'iletisim-2-baslik2' ); ?></h2>
      <div class="form-grid">
        <div class="field">
          <label for="il-ad">Ad Soyad</label>
          <input id="il-ad" name="ad" type="text" placeholder="Ad Soyad" required>
        </div>
        <div class="field">
          <label for="il-tel">Telefon / WhatsApp</label>
          <input id="il-tel" name="telefon" type="tel" placeholder="05xx xxx xx xx" required>
        </div>
        <div class="field">
          <label for="il-mail">E-posta</label>
          <input id="il-mail" name="eposta" type="email" placeholder="ornek@eposta.com">
        </div>
        <div class="field">
          <label for="il-konu">İlgilendiğiniz Hizmet / Atölye</label>
          <select id="il-konu" name="konu">
<?php koi_kartlar( 'konu-secenekleri' ); ?>
          </select>
        </div>
        <div class="field">
          <label for="il-yontem">Tercih Ettiğiniz İletişim Yöntemi</label>
          <select id="il-yontem" name="yontem">
            <option>Telefon</option>
            <option>WhatsApp</option>
            <option>E-posta</option>
          </select>
        </div>
        <div class="field">
          <label for="il-zaman">Uygun Gün / Saat</label>
          <input id="il-zaman" name="zaman" type="text" placeholder="Örn. hafta içi öğleden sonra">
        </div>
        <div class="field field--full">
          <label for="il-mesaj">Mesajınız</label>
          <textarea id="il-mesaj" name="mesaj" placeholder="Paylaşmak istediğiniz notlar"></textarea>
        </div>
        <div class="field field--check field--full">
          <input id="il-kvkk" name="kvkk" type="checkbox" required>
          <label for="il-kvkk"><a href="<?php echo esc_url( koi_url( 'kvkk' ) ); ?>" style="border-bottom:1px solid var(--koi-linen)">KVKK Aydınlatma Metni</a>'ni okudum, kişisel verilerimin başvurum kapsamında işlenmesini onaylıyorum.</label>
        </div>
      </div>
      <div style="margin-top:22px">
        <button class="btn btn--primary" type="submit">Gönder<svg aria-hidden="true"><use href="#i-arrow"></use></svg></button>
      </div>
      <?php koi_form_notu( 'Yalnızca gerekli bilgiler toplanır.' ); ?>
    </form>
  </div>
</section>

<section class="section section--tight">
  <div class="container container--wide">
    <div class="section-head reveal">
      <span class="eyebrow"<?php koi_isaret( 'iletisim-3-ust1' ); ?>><?php koi_alan( 'iletisim-3-ust1' ); ?></span>
      <h2<?php koi_isaret( 'iletisim-3-baslik1' ); ?>><?php koi_alan( 'iletisim-3-baslik1' ); ?></h2>
    </div>
    <div class="map-frame reveal" data-harita="<?php echo esc_url( koi_ayar( 'harita_gomme' ) ); ?>" data-harita-baslik="KOI Çocuk ve Aile Gelişim Merkezi — Google Haritalar">
      <div class="map-frame__pin">
        <svg aria-hidden="true"><use href="#i-pin"></use></svg>
        <span<?php koi_isaret( 'iletisim-3-metin1' ); ?>><?php koi_alan( 'iletisim-3-metin1' ); ?></span>
        <a class="link-arrow" href="<?php echo esc_url( koi_ayar( 'harita' ) ); ?>" target="_blank" rel="noopener"<?php koi_isaret( 'iletisim-3-baglanti1' ); ?>><?php koi_alan( 'iletisim-3-baglanti1' ); ?></a>
      </div>
    </div>
    <p class="map-link"><a class="link-arrow" href="<?php echo esc_url( koi_ayar( 'harita' ) ); ?>" target="_blank" rel="noopener"<?php koi_isaret( 'iletisim-3-baglanti2' ); ?>><?php koi_alan( 'iletisim-3-baglanti2' ); ?></a></p>
  </div>
</section>

<section class="section section--cream">
  <div class="container container--wide">
    <div class="section-head section-head--split reveal">
      <div>
        <span class="eyebrow"<?php koi_isaret( 'iletisim-4-ust1' ); ?>><?php koi_alan( 'iletisim-4-ust1' ); ?></span>
        <h2<?php koi_isaret( 'iletisim-4-baslik1' ); ?>><?php koi_alan( 'iletisim-4-baslik1' ); ?></h2>
      </div>
      <p class="lead"<?php koi_isaret( 'iletisim-4-giris1' ); ?>><?php koi_alan( 'iletisim-4-giris1' ); ?></p>
    </div>
<?php koi_kartlar( 'sss-iletisim' ); ?>
    <p class="reveal" style="margin-top:30px"><a class="link-arrow" href="<?php echo esc_url( koi_url( 'sss' ) ); ?>"<?php koi_isaret( 'iletisim-4-baglanti1' ); ?>><?php koi_alan( 'iletisim-4-baglanti1' ); ?></a></p>
  </div>
</section>
