<?php
/**
 * Temel sikilastirma. Sunucu ve eklenti duzeyindeki onlemlerin (2FA, guvenlik
 * duvari, yedek) yerini tutmaz; onlari tamamlar.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Surum bilgisini gizle */
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

/* XML-RPC kullanilmiyor */
add_filter( 'xmlrpc_enabled', '__return_false' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

function koi_pingback_basligi( $basliklar ) {
	unset( $basliklar['X-Pingback'] );
	return $basliklar;
}
add_filter( 'wp_headers', 'koi_pingback_basligi' );

/* Yorumlar kapali: sitede yorum alani yok */
add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );

/* Giris hatasi kullanici adinin dogru olup olmadigini ele vermesin */
function koi_giris_hatasi() {
	return 'Kullanıcı adı veya parola hatalı.';
}
add_filter( 'login_errors', 'koi_giris_hatasi' );

/* ---------- Kullanici adi sizintilari ----------
   WordPress, yazar arsivi adresinde (/author/<kullanici-adi>/) giris adini
   gosterir. Sitede yazar arsivi kullanilmadigi icin bu adresler bloga
   yonlenir. Oncelik 1: WordPress'in kendi yonlendirmesinden (oncelik 10) once
   calismali, yoksa "?author=1" adresi kullanici adini ele verir. */
function koi_yazar_arsivini_kapat() {
	if ( is_admin() ) {
		return;
	}
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['author'] ) || is_author() ) {
		wp_safe_redirect( koi_url( 'blog' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'koi_yazar_arsivini_kapat', 1 );

/* Site haritasinda kullanici listesi yer almasin */
function koi_site_haritasi_saglayicilari( $saglayici, $ad ) {
	return 'users' === $ad ? false : $saglayici;
}
add_filter( 'wp_sitemaps_add_provider', 'koi_site_haritasi_saglayicilari', 10, 2 );

/* Paylasim onizleme verisinde (oEmbed) yazar adresi yer almasin */
function koi_oembed_yazari_gizle( $veri ) {
	unset( $veri['author_name'], $veri['author_url'] );
	return $veri;
}
add_filter( 'oembed_response_data', 'koi_oembed_yazari_gizle' );

/* Giris yapmamis ziyaretciye kullanici listesini verme */
function koi_rest_kullanicilar( $uclar ) {
	if ( ! is_user_logged_in() ) {
		unset( $uclar['/wp/v2/users'], $uclar['/wp/v2/users/(?P<id>[\d]+)'] );
	}
	return $uclar;
}
add_filter( 'rest_endpoints', 'koi_rest_kullanicilar' );

/* Panelden tema/eklenti dosyasi duzenlemeyi kapat */
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}

/* ---------- Guvenlik basliklari ---------- */

/* Her sayfada (site, giris ekrani, panel) gonderilen basliklar */
function koi_ortak_basliklar() {
	if ( headers_sent() ) {
		return;
	}
	header_remove( 'X-Powered-By' );
	header( 'X-Content-Type-Options: nosniff' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	if ( is_ssl() ) {
		/* Tarayici bir yil boyunca siteye yalnizca https ile baglanir */
		header( 'Strict-Transport-Security: max-age=31536000' );
	}
}
add_action( 'login_init', 'koi_ortak_basliklar' );
add_action( 'admin_init', 'koi_ortak_basliklar' );
/* REST yanitlari (/wp-json/) normal sayfa akisindan gecmez; basliklar burada eklenir */
add_action( 'rest_api_init', 'koi_ortak_basliklar' );

/* Sitenin ziyaretciye acik sayfalarinda gonderilen basliklar */
function koi_guvenlik_basliklari() {
	if ( headers_sent() ) {
		return;
	}
	koi_ortak_basliklar();
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()' );

	/* Icerik guvenlik politikasi: yalnizca giris yapmamis ziyaretciye.
	   Betik kisiti icermez (WordPress ve eklentiler satir ici betik kullanir);
	   cerceveleme, eklenti nesneleri ve form hedefleri sinirlanir.
	   Yonetici oturumunda gonderilmez ki panel araclari etkilenmesin. */
	if ( ! is_user_logged_in() ) {
		header( 'Content-Security-Policy: ' . koi_icerik_politikasi() );
	}
}
add_action( 'send_headers', 'koi_guvenlik_basliklari' );

function koi_icerik_politikasi() {
	/* Sayfalara gomulebilecek dis kaynaklar: harita ve blog yazilarindaki videolar */
	$cerceveler = apply_filters(
		'koi_izinli_cerceveler',
		array(
			'https://www.google.com',
			'https://maps.google.com',
			'https://www.youtube.com',
			'https://www.youtube-nocookie.com',
			'https://player.vimeo.com',
		)
	);
	return implode(
		'; ',
		array(
			"frame-ancestors 'self'",
			"base-uri 'self'",
			"object-src 'none'",
			"form-action 'self'",
			"frame-src 'self' " . implode( ' ', array_map( 'esc_url_raw', (array) $cerceveler ) ),
		)
	);
}
