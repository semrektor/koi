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

/* ?author=1 ile kullanici adi taramasini engelle */
function koi_yazar_taramasi() {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! is_admin() && isset( $_GET['author'] ) && ! is_user_logged_in() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'koi_yazar_taramasi' );

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

/* Guvenlik basliklari */
function koi_guvenlik_basliklari() {
	if ( headers_sent() ) {
		return;
	}
	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	header( 'Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()' );
}
add_action( 'send_headers', 'koi_guvenlik_basliklari' );
