<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<section class="page-hero">
  <div class="container container--wide page-hero__grid">
    <div>
      <nav class="breadcrumb" aria-label="Sayfa yolu">
        <a href="<?php echo esc_url( koi_url( 'index' ) ); ?>">Anasayfa</a><span>/</span><span>Blog</span>
      </nav>
      <h1>Ailelere Notlar</h1>
    </div>
    <p class="lead">Gelişim, ebeveynlik ve oyun üzerine uzmanlarımızın kaleminden; uygulanabilir, sade ve gerçekçi yazılar.</p>
  </div>
</section>

<section class="section section--tight">
  <div class="container container--wide">
<?php koi_one_cikan_yazi(); ?>
  </div>
</section>

<section class="section section--tight">
  <div class="container container--wide">
    <hr class="rule">
  </div>
</section>

<section class="section section--tight">
  <div class="container container--wide">
    <div class="filters reveal" data-filter-group data-filter-target="#blog-listesi" role="group" aria-label="Kategori filtresi">
      <button type="button" data-filter="all" class="is-active">Tümü</button>
      <button type="button" data-filter="ebeveynlik">Ebeveynlik</button>
      <button type="button" data-filter="oyun">Oyun ve Gelişim</button>
      <button type="button" data-filter="duygu">Duygular</button>
      <button type="button" data-filter="okul">Okul</button>
    </div>

    <div class="cards cards--3" id="blog-listesi">
<?php koi_kartlar( 'blog-listesi' ); ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container container--wide">
    <div class="cta-band__inner reveal" style="border-radius:var(--radius-m);text-align:center;align-items:center">
      <span class="eyebrow eyebrow--center">Bülten</span>
      <h2>Yeni Yazılardan Haberdar Olun</h2>
      <p class="lead">Ayda bir, uzmanlarımızın yazıları ve yaklaşan atölye takvimi e-posta kutunuza gelsin.</p>
      <form style="width:min(520px,100%);margin-top:10px" id="talep-formu" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
<?php koi_form_gizli( 'bulten' ); ?>
        <div class="form-grid" style="grid-template-columns:1fr auto;align-items:end">
          <div class="field">
            <label for="bulten-mail">E-posta adresiniz</label>
            <input id="bulten-mail" name="eposta" type="email" placeholder="ornek@eposta.com" required>
          </div>
          <button class="btn btn--primary" type="submit">Abone Ol</button>
        </div>
        <?php koi_form_notu( '' ); ?>
      </form>
    </div>
  </div>
</section>
