<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>Oyun Grupları</span>
      </nav>
      <h1><?php koi_ust_metin( 'baslik', 'Oyunun İçinde
Büyüyen Gelişim' ); ?></h1>
    </div>
    <p class="lead"><?php koi_ust_metin( 'giris', 'Haftanın 5 günü, günde 2 seans. Yaş ve gelişim dönemine göre ayrıştırılmış, seans başına en fazla 6 çocukla yürütülen küçük grup programları.' ); ?></p>
  </div>
</section>

<section class="section">
  <div class="container container--wide split">
    <div class="split__media reveal">
      <div class="media media--arch media--tall has-img" data-label="Oyun odası — çekim yapılacak"><img class="media__img" src="<?php koi_v(); ?>img/oyun-odasi.jpg" srcset="<?php koi_v(); ?>img/oyun-odasi-sm.jpg 900w, <?php koi_v(); ?>img/oyun-odasi.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="KOI oyun grubu odası" loading="lazy">
        <svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg>
      </div>
    </div>
    <div class="split__body reveal">
      <span class="eyebrow">Program Yaklaşımı</span>
      <h2>Neden Küçük Gruplar?</h2>
      <p>Bir çocuğun kendini güvende hissetmesi için görülmeye ihtiyacı vardır. Kalabalık gruplarda bu görülme hali kaybolur. Bu nedenle oyun gruplarımızı seans başına en fazla 6 çocuk ile planlıyoruz.</p>
      <p>Her program; yaş aralığına, gelişim dönemine ve grubun dinamiğine göre hazırlanır. Serbest oyun, yönlendirilmiş etkinlik ve kapanış ritüeli aynı akış içinde yer alır.</p>
      <ul class="tagline-stack">
        <li>Akran ilişkisi</li>
        <li>Duygu düzenleme</li>
        <li>Yaratıcı ifade</li>
      </ul>
      <div style="margin-top:30px">
        <a class="btn btn--primary" href="#basvuru">Kontenjan Sorun<svg aria-hidden="true"><use href="#i-arrow"></use></svg></a>
      </div>
    </div>
  </div>
</section>

<section class="section section--cream">
  <div class="container container--wide">
    <div class="section-head section-head--split reveal">
      <div>
        <span class="eyebrow">Yaş Grupları</span>
        <h2>Gelişim Dönemine<br>Göre Ayrılmış Gruplar</h2>
      </div>
      <p class="lead">Her grupta en fazla 6 çocuk yer alır. Gün ve saatler dönemsel takvime göre belirlenir.</p>
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
        <span class="eyebrow">Program Düzeni</span>
        <h2>Gruplar ve Kontenjan</h2>
      </div>
      <p class="lead">Haftada 5 gün, günde 2 seans. Kesin program, yaş gruplarına ve dönemsel takvime göre yayınlanacaktır.</p>
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
    <span class="eyebrow">Bir Seans</span>
    <h2>Seans İçinde<br>Neler Oluyor?</h2>
    <p class="lead">Her seans, çocuğun öngörebileceği bir ritim içinde ilerler. Bu öngörülebilirlik güven duygusunu büyütür.</p>
    <ul class="program-band__list">
      <li><svg aria-hidden="true"><use href="#i-check"></use></svg><span><strong style="font-weight:400;color:#F4EFE6">Karşılama ritüeli</strong> — grubun bir araya gelmesi ve günün çerçevesinin kurulması</span></li>
      <li><svg aria-hidden="true"><use href="#i-check"></use></svg><span><strong style="font-weight:400;color:#F4EFE6">Serbest oyun</strong> — çocuğun kendi ilgisini takip ettiği alan</span></li>
      <li><svg aria-hidden="true"><use href="#i-check"></use></svg><span><strong style="font-weight:400;color:#F4EFE6">Yönlendirilmiş etkinlik</strong> — haftanın temasına göre birlikte üretim</span></li>
      <li><svg aria-hidden="true"><use href="#i-check"></use></svg><span><strong style="font-weight:400;color:#F4EFE6">Kapanış ve paylaşım</strong> — günün toparlanması ve aileye geri bildirim</span></li>
    </ul>
  </div>
  <div class="media media--olive program-band__media has-img" data-label="Seans anı — çekim yapılacak"><img class="media__img" src="<?php koi_v(); ?>img/oyun-odasi.jpg" srcset="<?php koi_v(); ?>img/oyun-odasi-sm.jpg 900w, <?php koi_v(); ?>img/oyun-odasi.jpg 2200w" sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw" alt="KOI oyun grubu odası" loading="lazy">
    <svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg>
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

<section class="section section--cream" id="basvuru">
  <div class="container container--wide contact-grid">
    <div class="reveal">
      <span class="eyebrow">Ön Başvuru</span>
      <h2>Kontenjan ve Takvim İçin Yazın</h2>
      <p class="lead">Formu doldurun; uygun gruplar, saatler ve kontenjan durumu hakkında sizi bilgilendirelim.</p>
      <ul class="info-list">
        <li>
          <svg aria-hidden="true"><use href="#i-users"></use></svg>
          <div><strong>Kontenjan</strong><span>Seans başına en fazla 6 çocuk</span></div>
        </li>
        <li>
          <svg aria-hidden="true"><use href="#i-clock"></use></svg>
          <div><strong>Program</strong><span>Haftanın 5 günü, günde 2 seans</span></div>
        </li>
        <li>
          <svg aria-hidden="true"><use href="#i-pin"></use></svg>
          <div><strong>Konum</strong><span><?php echo esc_html( koi_ayar( 'adres' ) ); ?></span></div>
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
