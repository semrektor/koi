<?php
/**
 * Ilk kurulum: Gorunum > KOI Kurulum.
 * Sayfalari, hizmetleri, atolyeleri ve ornek blog yazilarini olusturur.
 * Var olan icerige dokunmaz; guvenle tekrar calistirilabilir.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function koi_kurulum_kayit( $kayit, $tur, $sira ) {
	if ( get_page_by_path( $kayit['slug'], OBJECT, $tur ) ) {
		return 0;
	}
	$dizi = array(
		'post_type'      => $tur,
		'post_status'    => 'publish',
		'post_title'     => $kayit['baslik'],
		'post_name'      => $kayit['slug'],
		'post_content'   => $kayit['icerik'],
		'post_excerpt'   => $kayit['kisa'],
		'menu_order'     => $sira,
		'comment_status' => 'closed',
		'ping_status'    => 'closed',
	);
	if ( 'post' === $tur ) {
		/* Yazilar taslaktaki sirayla gorunsun diye tarihler birer hafta arayla verilir */
		$dizi['post_date'] = gmdate( 'Y-m-d H:i:s', time() - $sira * WEEK_IN_SECONDS + (int) ( (float) get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) );
	}
	$kimlik = wp_insert_post( wp_slash( $dizi ), true );
	if ( is_wp_error( $kimlik ) || ! $kimlik ) {
		return 0;
	}

	$taksonomi = koi_taksonomi( $tur );
	if ( $taksonomi && ! empty( $kayit['cat'] ) ) {
		$terim = term_exists( $kayit['cat'], $taksonomi );
		if ( ! $terim ) {
			$terim = wp_insert_term( $kayit['terim'], $taksonomi, array( 'slug' => $kayit['cat'] ) );
		}
		if ( is_array( $terim ) ) {
			wp_set_object_terms( $kimlik, (int) $terim['term_id'], $taksonomi );
		}
	}

	$metalar = array(
		'koi_lead'     => isset( $kayit['lead'] ) ? $kayit['lead'] : '',
		'koi_gorsel'   => isset( $kayit['gorsel'] ) ? $kayit['gorsel'] : '',
		'koi_etiket'   => isset( $kayit['etiket'] ) ? $kayit['etiket'] : '',
		'koi_bilgi'    => isset( $kayit['bilgi'] ) ? $kayit['bilgi'] : '',
		'koi_rozetler' => isset( $kayit['rozetler'] ) ? $kayit['rozetler'] : '',
		'koi_ilgili'   => isset( $kayit['ilgili'] ) ? $kayit['ilgili'] : '',
		'koi_yazar'    => isset( $kayit['yazar'] ) ? $kayit['yazar'] : '',
	);
	foreach ( $metalar as $anahtar => $deger ) {
		if ( '' !== $deger ) {
			update_post_meta( $kimlik, $anahtar, wp_slash( $deger ) );
		}
	}
	if ( ! empty( $kayit['one_cikan'] ) ) {
		stick_post( $kimlik );
	}
	return 1;
}

function koi_icerik_kur() {
	$dosya = KOI_DIR . '/veri/icerik.json';
	$veri  = file_exists( $dosya ) ? json_decode( (string) file_get_contents( $dosya ), true ) : null;
	if ( ! is_array( $veri ) || empty( $veri['sayfalar'] ) ) {
		return new WP_Error( 'koi_veri', 'İçerik dosyası (veri/icerik.json) okunamadı.' );
	}

	$rapor = array(
		'sayfa'  => 0,
		'hizmet' => 0,
		'atolye' => 0,
		'yazi'   => 0,
	);

	/* WordPress'in ornek icerigi cop kutusuna (geri alinabilir) */
	foreach ( array( array( 'hello-world', 'post' ), array( 'merhaba-dunya', 'post' ), array( 'sample-page', 'page' ), array( 'ornek-sayfa', 'page' ) ) as $ornek ) {
		$kayit = get_page_by_path( $ornek[0], OBJECT, $ornek[1] );
		if ( $kayit ) {
			wp_trash_post( $kayit->ID );
		}
	}

	/* Sayfalar */
	$kimlikler = array();
	foreach ( $veri['sayfalar'] as $sayfa ) {
		$var = get_page_by_path( $sayfa['slug'], OBJECT, 'page' );
		if ( $var ) {
			$kimlikler[ $sayfa['anahtar'] ] = $var->ID;
			continue;
		}
		$kimlik = wp_insert_post(
			wp_slash(
				array(
					'post_type'      => 'page',
					'post_status'    => 'publish',
					'post_title'     => $sayfa['baslik'],
					'post_name'      => $sayfa['slug'],
					'post_content'   => '',
					'comment_status' => 'closed',
					'ping_status'    => 'closed',
				)
			),
			true
		);
		if ( ! is_wp_error( $kimlik ) && $kimlik ) {
			$kimlikler[ $sayfa['anahtar'] ] = $kimlik;
			$rapor['sayfa']++;
		}
	}
	if ( isset( $kimlikler['index'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $kimlikler['index'] );
	}
	if ( isset( $kimlikler['blog'] ) ) {
		update_option( 'page_for_posts', $kimlikler['blog'] );
	}

	/* Icerikler */
	$sira = 0;
	foreach ( $veri['hizmetler'] as $kayit ) {
		$rapor['hizmet'] += koi_kurulum_kayit( $kayit, 'hizmet', $sira++ );
	}
	$sira = 0;
	foreach ( $veri['atolyeler'] as $kayit ) {
		$rapor['atolye'] += koi_kurulum_kayit( $kayit, 'atolye', $sira++ );
	}
	$sira = 0;
	foreach ( $veri['blog'] as $kayit ) {
		$rapor['yazi'] += koi_kurulum_kayit( $kayit, 'post', $sira++ );
	}

	/* Genel ayarlar */
	update_option( 'blogname', 'KOI Çocuk ve Aile Gelişim Merkezi' );
	update_option( 'blogdescription', 'Çocukların, ebeveynlerin ve ailelerin iyi olma halini destekleyen bütüncül bir gelişim merkezi.' );
	update_option( 'default_comment_status', 'closed' );
	update_option( 'default_ping_status', 'closed' );
	if ( ! get_option( 'timezone_string' ) ) {
		update_option( 'timezone_string', 'Europe/Istanbul' );
	}

	/* Kalici baglantilar: /blog/yazi-adi/ */
	global $wp_rewrite;
	if ( '/blog/%postname%/' !== get_option( 'permalink_structure' ) ) {
		$wp_rewrite->set_permalink_structure( '/blog/%postname%/' );
	}
	koi_icerik_turleri();
	flush_rewrite_rules();
	/* Kategori adresleri (/blog/category/..) yeni yapiyi ancak bir sonraki istekte
	   alir. Kurallar o istekte yeniden uretilsin diye kayitli kopya silinir. */
	delete_option( 'rewrite_rules' );

	update_option( 'koi_kurulum_tamam', KOI_SURUM );
	return $rapor;
}

/* ---------- Yonetim sayfasi ---------- */
function koi_kurulum_menusu() {
	add_theme_page( 'KOI Kurulum', 'KOI Kurulum', 'manage_options', 'koi-kurulum', 'koi_kurulum_sayfasi' );
}
add_action( 'admin_menu', 'koi_kurulum_menusu' );

function koi_kurulum_sayfasi() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	echo '<div class="wrap"><h1>KOI Kurulum</h1>';

	if ( isset( $_POST['koi_kur'] ) && check_admin_referer( 'koi_kurulum' ) ) {
		$sonuc = koi_icerik_kur();
		if ( is_wp_error( $sonuc ) ) {
			echo '<div class="notice notice-error"><p>' . esc_html( $sonuc->get_error_message() ) . '</p></div>';
		} else {
			echo '<div class="notice notice-success"><p>' . esc_html(
				sprintf( 'Kurulum tamamlandı: %d sayfa, %d hizmet, %d atölye, %d blog yazısı eklendi.', $sonuc['sayfa'], $sonuc['hizmet'], $sonuc['atolye'], $sonuc['yazi'] )
			) . '</p></div>';
		}
	}

	echo '<p>Bu işlem sitenin sayfalarını, hizmetleri, atölyeleri ve örnek blog yazılarını oluşturur; site adını, anasayfayı ve kalıcı bağlantıları ayarlar.</p>';
	echo '<p>Var olan içeriğe dokunmaz. Aynı adrese sahip bir sayfa ya da yazı varsa atlanır, bu yüzden tekrar çalıştırmak güvenlidir.</p>';
	if ( get_option( 'koi_kurulum_tamam' ) ) {
		echo '<p><strong>Kurulum daha önce çalıştırıldı.</strong> İletişim bilgilerini <a href="' . esc_url( admin_url( 'customize.php?autofocus[section]=koi_iletisim' ) ) . '">Görünüm → Özelleştir → KOI İletişim Bilgileri</a> altından güncelleyebilirsiniz.</p>';
	}
	echo '<form method="post">';
	wp_nonce_field( 'koi_kurulum' );
	submit_button( 'İçerikleri Oluştur', 'primary', 'koi_kur' );
	echo '</form></div>';
}

function koi_kurulum_uyarisi() {
	if ( get_option( 'koi_kurulum_tamam' ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$ekran = get_current_screen();
	if ( $ekran && 'appearance_page_koi-kurulum' === $ekran->id ) {
		return;
	}
	echo '<div class="notice notice-info"><p>KOI teması etkin. Sayfaları ve içerikleri oluşturmak için <a href="' . esc_url( admin_url( 'themes.php?page=koi-kurulum' ) ) . '">KOI Kurulum</a> sayfasını açın.</p></div>';
}
add_action( 'admin_notices', 'koi_kurulum_uyarisi' );
