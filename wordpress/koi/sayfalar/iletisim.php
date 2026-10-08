<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>İletişim</span>
      </nav>
      <h1>Bir Adım Atmak<br>İçin Buradayız</h1>
    </div>
    <p class="lead">Bilgi almak, ön başvuru yapmak veya aklınıza takılan bir soruyu iletmek için formu doldurabilir, dilerseniz doğrudan WhatsApp'tan yazabilirsiniz.</p>
  </div>
</section>

<section class="section">
  <div class="container container--wide contact-grid">
    <div class="reveal">
      <span class="eyebrow">İletişim Bilgileri</span>
      <h2>Bize Ulaşın</h2>
      <p class="lead">Ekibimiz başvurunuzu en kısa sürede değerlendirip size dönüş yapar.</p>
      <ul class="info-list">
        <li>
          <svg aria-hidden="true"><use href="#i-pin"></use></svg>
          <div><strong>Adres</strong><span><?php echo esc_html( koi_ayar( 'acik_adres' ) ); ?></span></div>
        </li>
        <li>
          <svg aria-hidden="true"><use href="#i-phone"></use></svg>
          <div><strong>Telefon / WhatsApp</strong><span><a href="<?php echo esc_url( koi_tel_url() ); ?>"><?php echo esc_html( koi_ayar( 'telefon' ) ); ?></a></span></div>
        </li>
        <li>
          <svg aria-hidden="true"><use href="#i-pin"></use></svg>
          <div><strong>Ulaşım ve Otopark</strong><span>Açık otopark mevcuttur. Necip Fazıl metro istasyonu 8–12 dakika, Dudullu metro istasyonu 10 dakika mesafededir.</span></div>
        </li>
        <li>
          <svg aria-hidden="true"><use href="#i-mail"></use></svg>
          <div><strong>E-posta</strong><span><a href="<?php echo esc_url( 'mailto:' . koi_ayar( 'eposta' ) ); ?>"><?php echo esc_html( koi_ayar( 'eposta' ) ); ?></a></span></div>
        </li>
        <li>
          <svg aria-hidden="true"><use href="#i-clock"></use></svg>
          <div><strong>Çalışma Saatleri</strong><span><?php echo esc_html( koi_ayar( 'saat1' ) ); ?><br><?php echo esc_html( koi_ayar( 'saat2' ) ); ?></span></div>
        </li>
        <li>
          <svg aria-hidden="true"><use href="#i-ig"></use></svg>
          <div><strong>Sosyal Medya</strong><span><a href="<?php echo esc_url( koi_ayar( 'instagram' ) ); ?>" target="_blank" rel="noopener">@koiworld</a></span></div>
        </li>
      </ul>

      <div style="margin-top:34px;display:flex;gap:12px;flex-wrap:wrap">
        <a class="btn btn--primary" href="<?php echo esc_url( koi_wa_url() ); ?>">WhatsApp'tan Yazın<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
        <a class="btn btn--ghost" href="<?php echo esc_url( koi_tel_url() ); ?>">Hemen Arayın</a>
      </div>
    </div>

    <form class="reveal" id="talep-formu" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
<?php koi_form_gizli( 'iletisim' ); ?>
      <span class="eyebrow">Bilgi Talebi / Ön Başvuru</span>
      <h2 style="margin-bottom:.8em">Formu Doldurun</h2>
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
            <option>Çocuk ve Ergen Danışmanlığı</option>
            <option>Oyun Terapisi</option>
            <option>Aile ve Ebeveyn Danışmanlığı</option>
            <option>Anne, Hamilelik ve Yenidoğan Danışmanlığı</option>
            <option>Eğitim ve Akademik Gelişim</option>
            <option>Seminer ve Workshoplar</option>
            <option>Kurum ve Okul İş Birlikleri</option>
            <option>Oyun Grupları</option>
            <option>Atölye / Seminer</option>
            <option>Diğer</option>
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
      <span class="eyebrow">Konum</span>
      <h2>Bizi Nasıl Bulursunuz?</h2>
    </div>
    <div class="map-frame reveal">
      <div class="map-frame__pin">
        <svg aria-hidden="true"><use href="#i-pin"></use></svg>
        <span>Narlı Bahçe Evleri — Necip Fazıl Mah., Ümraniye</span>
        <a class="link-arrow" href="<?php echo esc_url( koi_ayar( 'harita' ) ); ?>" target="_blank" rel="noopener">Google Haritalar'da Aç<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
      </div>
    </div>
  </div>
</section>

<section class="section section--cream">
  <div class="container container--wide">
    <div class="section-head section-head--split reveal">
      <div>
        <span class="eyebrow">Sık Sorulanlar</span>
        <h2>Başvurmadan Önce</h2>
      </div>
      <p class="lead">Aklınızdaki soruların yanıtı burada yoksa, formu doldurmanız yeterli.</p>
    </div>
    <div class="accordion reveal">
      <div class="accordion__item is-open">
        <button class="accordion__trigger" type="button" aria-expanded="true">Randevu ve ön başvuru nasıl yapılır?<svg aria-hidden="true"><use href="#i-plus"></use></svg></button>
        <div class="accordion__panel"><p>KOI'ye web sitesindeki iletişim/ön başvuru formu veya WhatsApp üzerinden ulaşabilirsiniz.</p><p>İlk iletişimde çocuğunuzun yaşı, ihtiyaç alanı ve almak istediğiniz hizmet hakkında kısaca bilgi alınır. Ardından uygun uzman, hizmet ve görüşme zamanı konusunda yönlendirme yapılır.</p><p>Randevu oluşturulmadan önce ihtiyaç ve süreç hakkında bilgi almak için de bizimle iletişime geçebilirsiniz.</p></div>
      </div>
      <div class="accordion__item">
        <button class="accordion__trigger" type="button" aria-expanded="false">İlk görüşme nasıl ilerliyor?<svg aria-hidden="true"><use href="#i-plus"></use></svg></button>
        <div class="accordion__panel"><p>İlk görüşme, öncelikle çocuğunuzun ve ailenizin ihtiyaçlarını anlamaya yönelik bir ön değerlendirme ve tanışma süreci olarak ilerler.</p><p>Çocuğun gelişim öyküsü, mevcut ihtiyaçlar, aile ve okul yaşamı gibi konular ele alınır. İhtiyaca göre danışmanlık, oyun terapisi, oyun grubu veya farklı bir çalışma önerilebilir.</p><p>Amaç, her aileyi tek bir programa yönlendirmek değil; ihtiyaca uygun yolu birlikte belirlemektir.</p></div>
      </div>
      <div class="accordion__item">
        <button class="accordion__trigger" type="button" aria-expanded="false">Çocuğum için danışmanlık mı, oyun grubu mu, atölye mi uygun?<svg aria-hidden="true"><use href="#i-plus"></use></svg></button>
        <div class="accordion__panel"><p>Bunu yalnızca yaşa bakarak belirlemek her zaman doğru değildir.</p><p>Çocuğun gelişimsel özellikleri, ihtiyaçları, sosyal becerileri, duygusal durumu ve ailenin beklentileri birlikte değerlendirilir. Ön görüşme sonrasında çocuğunuz için danışmanlık, oyun terapisi, oyun grubu veya atölye seçeneklerinden hangisinin daha uygun olduğu konusunda yönlendirme yapılabilir.</p><p>Amacımız belirli bir hizmeti sunmak değil, çocuğun ihtiyacına uygun olan alanı belirlemektir.</p></div>
      </div>
      <div class="accordion__item">
        <button class="accordion__trigger" type="button" aria-expanded="false">Ücret bilgisi nasıl alabilirim?<svg aria-hidden="true"><use href="#i-plus"></use></svg></button>
        <div class="accordion__panel"><p>Ücretler hizmete, uzmana ve programa göre değiştiği için sitede sabit fiyat yayınlamıyoruz. Güncel bilgi için iletişim formunu doldurabilir veya bize ulaşabilirsiniz.</p></div>
      </div>
    </div>
    <p class="reveal" style="margin-top:30px"><a class="link-arrow" href="<?php echo esc_url( koi_url( 'sss' ) ); ?>">Tüm Sorular<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a></p>
  </div>
</section>
