<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
</main>

<!-- ============ FOOTER ============ -->
<footer class="site-footer">
  <div class="container container--wide">
    <div class="footer-grid">
      <div>
        <a class="brand" href="<?php echo esc_url( koi_url( 'index' ) ); ?>" aria-label="KOI Çocuk ve Aile Gelişim Merkezi">
          <img class="brand__logo brand__logo--footer" src="<?php koi_v(); ?>img/logo-acik.webp" alt="KOI Çocuk ve Aile Gelişim Merkezi" width="400" height="270">
        </a>
        <p class="footer-about">Çocukların, ebeveynlerin ve ailelerin iyi olma halini destekleyen bütüncül bir gelişim merkezi.</p>
        <div class="socials">
          <a href="<?php echo esc_url( koi_ayar( 'instagram' ) ); ?>" aria-label="KOI Instagram sayfası (@koiworld)" target="_blank" rel="noopener"><svg aria-hidden="true"><use href="#i-ig"></use></svg></a>
          <a href="<?php echo esc_url( koi_wa_url() ); ?>" aria-label="WhatsApp ile yazın"><svg aria-hidden="true"><use href="#i-wa"></use></svg></a>
          <a href="<?php echo esc_url( 'mailto:' . koi_ayar( 'eposta' ) ); ?>" aria-label="E-posta gönderin"><svg aria-hidden="true"><use href="#i-mail"></use></svg></a>
        </div>
      </div>
      <div>
        <p class="footer-title">Kurumsal</p>
        <ul class="footer-list">
          <li><a href="<?php echo esc_url( koi_url( 'hakkimizda' ) ); ?>">Hakkımızda</a></li>
          <li><a href="<?php echo esc_url( koi_url( 'uzmanlarimiz' ) ); ?>">Uzmanlarımız</a></li>
          <li><a href="<?php echo esc_url( koi_url( 'galeri' ) ); ?>">Galeri</a></li>
          <li><a href="<?php echo esc_url( koi_url( 'blog' ) ); ?>">Blog</a></li>
          <li><a href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>">İletişim</a></li>
        </ul>
      </div>
      <div>
        <p class="footer-title">Hizmetler</p>
        <ul class="footer-list">
          <li><a href="<?php echo esc_url( koi_url( 'hizmet-cocuk-ergen-danismanligi' ) ); ?>">Çocuk ve Ergen Danışmanlığı</a></li>
          <li><a href="<?php echo esc_url( koi_url( 'hizmet-oyun-terapisi' ) ); ?>">Oyun Terapisi</a></li>
          <li><a href="<?php echo esc_url( koi_url( 'hizmet-aile-ebeveyn-danismanligi' ) ); ?>">Aile ve Ebeveyn Danışmanlığı</a></li>
          <li><a href="<?php echo esc_url( koi_url( 'hizmet-anne-yenidogan' ) ); ?>">Anne ve Yenidoğan Danışmanlığı</a></li>
          <li><a href="<?php echo esc_url( koi_url( 'oyun-gruplari' ) ); ?>">Oyun Grupları</a></li>
          <li><a href="<?php echo esc_url( koi_url( 'atolyeler' ) ); ?>">Atölyeler</a></li>
          <li><a href="<?php echo esc_url( koi_url( 'hizmet-seminer-workshop' ) ); ?>">Seminer ve Workshoplar</a></li>
          <li><a href="<?php echo esc_url( koi_url( 'hizmetler' ) ); ?>">Tüm Hizmetler</a></li>
        </ul>
      </div>
      <div>
        <p class="footer-title">İletişim</p>
        <ul class="footer-list">
          <li><span><?php echo esc_html( koi_ayar( 'adres' ) ); ?></span></li>
          <li><a href="<?php echo esc_url( koi_tel_url() ); ?>"><?php echo esc_html( koi_ayar( 'telefon' ) ); ?></a></li>
          <li><a href="<?php echo esc_url( 'mailto:' . koi_ayar( 'eposta' ) ); ?>"><?php echo esc_html( koi_ayar( 'eposta' ) ); ?></a></li>
          <li><span><?php echo esc_html( koi_ayar( 'saat1' ) ); ?></span></li>
          <li><span><?php echo esc_html( koi_ayar( 'saat2' ) ); ?></span></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="container container--wide">
    <div class="footer-bottom">
      <span>&copy; <span data-year>2026</span> KOI Çocuk ve Aile Gelişim Merkezi. Tüm hakları saklıdır.</span>
      <div class="footer-legal">
        <a href="<?php echo esc_url( koi_url( 'kvkk' ) ); ?>">KVKK Aydınlatma Metni</a>
        <a href="<?php echo esc_url( koi_url( 'gizlilik' ) ); ?>">Gizlilik Politikası</a>
        <a href="<?php echo esc_url( koi_url( 'cerez' ) ); ?>">Çerez Politikası</a>
      </div>
    </div>
  </div>
</footer>

<a class="wa-float" href="<?php echo esc_url( koi_wa_url() ); ?>" aria-label="WhatsApp ile iletişime geçin">
  <svg aria-hidden="true"><use href="#i-wa"></use></svg><span>WhatsApp</span>
</a>
<?php wp_footer(); ?>
</body>
</html>
