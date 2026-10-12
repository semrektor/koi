<?php
/**
 * KOI | Cocuk ve Aile Gelisim Merkezi - WordPress temasi.
 *
 * Bu tema build/wp-tema.js ile taslak siteden uretilir. sayfalar/, header.php,
 * footer.php ve veri/ klasoru uretilmis ciktidir; elle duzenlemeyin.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KOI_SURUM', '0.5.1' );
/* Kurulumun olusturdugu icerigin surumu; veri/icerik.json degistiginde artirilir */
define( 'KOI_ICERIK_SURUM', '0.4.0' );
define( 'KOI_DIR', get_template_directory() );
define( 'KOI_URI', get_template_directory_uri() );

require KOI_DIR . '/inc/ayarlar.php';
require KOI_DIR . '/inc/icerik-turleri.php';
require KOI_DIR . '/inc/sablonlar.php';
require KOI_DIR . '/inc/listeler.php';
require KOI_DIR . '/inc/formlar.php';
require KOI_DIR . '/inc/guvenlik.php';
require KOI_DIR . '/inc/kvkk.php';
require KOI_DIR . '/inc/kurulum.php';

/* ---------- Eski klasor adindan gecis ----------
   Temanin klasoru once "koi" idi; ayni adli baska bir temayla karistigi icin
   "koi-ailem" oldu. Ozellestirici ayarlari klasor adina bagli saklandigindan,
   yeni tema ilk etkinlestirildiginde eski ayarlar buraya tasinir. */
function koi_eski_ayarlari_tasi() {
	$eski = get_option( 'theme_mods_koi' );
	if ( 'koi' === get_stylesheet() || ! is_array( $eski ) ) {
		return;
	}
	foreach ( $eski as $anahtar => $deger ) {
		if ( 0 === strpos( (string) $anahtar, 'koi_' ) && null === get_theme_mod( $anahtar, null ) ) {
			set_theme_mod( $anahtar, $deger );
		}
	}
}
add_action( 'after_switch_theme', 'koi_eski_ayarlari_tasi' );

/* ---------- Temel destekler ---------- */
function koi_tema_destekleri() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'koi_tema_destekleri' );

/* ---------- Stil ve betikler ---------- */
function koi_dosya_surumu( $yol ) {
	$tam = KOI_DIR . '/' . $yol;
	return file_exists( $tam ) ? (string) filemtime( $tam ) : KOI_SURUM;
}

function koi_varliklar() {
	wp_enqueue_style(
		'koi-yazi-tipleri',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500&family=Petit+Formal+Script&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'koi', KOI_URI . '/assets/css/style.css', array(), koi_dosya_surumu( 'assets/css/style.css' ) );
	wp_enqueue_style( 'koi-wp', KOI_URI . '/assets/css/wp.css', array( 'koi' ), koi_dosya_surumu( 'assets/css/wp.css' ) );
	wp_enqueue_script( 'koi', KOI_URI . '/assets/js/main.js', array(), koi_dosya_surumu( 'assets/js/main.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'koi_varliklar' );

function koi_head_ekleri() {
	/* Reveal animasyonu yalnizca JS varken devreye girer */
	echo "<script>document.documentElement.classList.add('js');</script>\n";
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
	if ( ! has_site_icon() ) {
		$ikon = esc_url( KOI_URI . '/assets/img/favicon.png' );
		echo '<link rel="icon" type="image/png" href="' . $ikon . '">' . "\n";
		echo '<link rel="apple-touch-icon" href="' . $ikon . '">' . "\n";
	}
}
add_action( 'wp_head', 'koi_head_ekleri', 1 );

/* Emoji betikleri kullanilmiyor */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/* ---------- Adres ve varlik yardimcilari ---------- */

/* Taslaktaki dosya adindan (or. "hizmet-oyun-terapisi") WordPress adresi uretir */
function koi_url( $anahtar ) {
	$anahtar = (string) $anahtar;
	if ( 'index' === $anahtar ) {
		return home_url( '/' );
	}
	$onekler = array(
		'hizmet-' => 'hizmetler',
		'atolye-' => 'atolyeler',
		'blog-'   => 'blog',
	);
	foreach ( $onekler as $onek => $taban ) {
		if ( 0 === strpos( $anahtar, $onek ) ) {
			return home_url( user_trailingslashit( '/' . $taban . '/' . substr( $anahtar, strlen( $onek ) ) ) );
		}
	}
	return home_url( user_trailingslashit( '/' . $anahtar ) );
}

/* Tema varlik klasorunun adresini basar: <?php koi_v(); ?>img/logo.webp */
function koi_v() {
	echo esc_url( KOI_URI . '/assets/' );
}

/* ---------- Hangi sayfadayiz? ---------- */
function koi_sayfa_anahtari() {
	if ( is_front_page() ) {
		return 'index';
	}
	if ( is_home() ) {
		return 'blog';
	}
	if ( is_404() ) {
		return '404';
	}
	if ( is_page() ) {
		$sayfa = get_queried_object();
		return $sayfa ? (string) $sayfa->post_name : '';
	}
	return '';
}

function koi_nav_anahtari() {
	if ( is_front_page() ) {
		return 'index';
	}
	if ( is_singular( 'hizmet' ) || is_tax( 'hizmet_kategori' ) ) {
		return 'hizmetler';
	}
	if ( is_singular( 'atolye' ) || is_tax( 'atolye_turu' ) ) {
		return 'atolyeler';
	}
	if ( is_home() || is_singular( 'post' ) || is_category() || is_tag() || is_date() || is_author() ) {
		return 'blog';
	}
	return koi_sayfa_anahtari();
}

function koi_aktif( $anahtar ) {
	if ( $anahtar === koi_nav_anahtari() ) {
		echo ' aria-current="page"';
	}
}

/* Yayinda en az bir blog yazisi var mi? (Blog bolumleri buna gore gosterilir) */
function koi_yazi_var() {
	static $var = null;
	if ( null === $var ) {
		$sayi = wp_count_posts( 'post' );
		$var  = isset( $sayi->publish ) && (int) $sayi->publish > 0;
	}
	return $var;
}

/* Taslaktan gelen sayfa govdesini (sayfalar/<anahtar>.php) basar */
function koi_sayfa_govdesi( $anahtar ) {
	if ( ! preg_match( '/^[a-z0-9-]+$/', (string) $anahtar ) ) {
		return false;
	}
	$dosya = KOI_DIR . '/sayfalar/' . $anahtar . '.php';
	if ( ! file_exists( $dosya ) ) {
		return false;
	}
	include $dosya;
	return true;
}

/* ---------- Baslik ve aciklama (SEO eklentisi yoksa) ---------- */
function koi_seo_eklentisi_var() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' );
}

function koi_sayfa_meta() {
	static $liste = null;
	if ( null === $liste ) {
		$liste = array();
		$dosya = KOI_DIR . '/veri/sayfalar.json';
		if ( file_exists( $dosya ) ) {
			$veri = json_decode( (string) file_get_contents( $dosya ), true );
			if ( is_array( $veri ) ) {
				$liste = $veri;
			}
		}
	}
	$anahtar = koi_sayfa_anahtari();
	return ( $anahtar && isset( $liste[ $anahtar ] ) ) ? $liste[ $anahtar ] : array();
}

function koi_belge_basligi( $baslik ) {
	if ( koi_seo_eklentisi_var() ) {
		return $baslik;
	}
	$meta = koi_sayfa_meta();
	return ! empty( $meta['seo_baslik'] ) ? $meta['seo_baslik'] : $baslik;
}
add_filter( 'pre_get_document_title', 'koi_belge_basligi' );

function koi_baslik_ayraci() {
	return '|';
}
add_filter( 'document_title_separator', 'koi_baslik_ayraci' );

function koi_meta_aciklama() {
	if ( koi_seo_eklentisi_var() ) {
		return;
	}
	$meta     = koi_sayfa_meta();
	$aciklama = ! empty( $meta['aciklama'] ) ? $meta['aciklama'] : '';
	if ( ! $aciklama && is_singular() ) {
		$aciklama = get_the_excerpt( get_queried_object_id() );
	}
	if ( ! $aciklama ) {
		$aciklama = get_bloginfo( 'description' );
	}
	$aciklama = trim( wp_strip_all_tags( (string) $aciklama ) );
	if ( ! $aciklama ) {
		return;
	}
	$baslik = wp_get_document_title();
	echo '<meta name="description" content="' . esc_attr( $aciklama ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $baslik ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $aciklama ) . '">' . "\n";
	echo '<meta property="og:type" content="' . ( is_singular( 'post' ) ? 'article' : 'website' ) . '">' . "\n";
	echo '<meta property="og:locale" content="tr_TR">' . "\n";
}
add_action( 'wp_head', 'koi_meta_aciklama', 2 );

/* ---------- Sayfa onbellegi ----------
   Liste sayfalari (Oyun Gruplari, SSS, Uzmanlarimiz, Galeri...) baska kayitlardan
   uretilir. Bir kayit degistiginde onbellek eklentisi bu sayfalari kendiliginden
   yenilemez ve ziyaretci eski hali gormeye devam eder. Bu yuzden icerik ya da ayar
   degistiginde tum sayfa onbellegi temizlenir (LiteSpeed Cache kurulu degilse
   hicbir sey yapmaz). */
function koi_onbellegi_temizle() {
	do_action( 'litespeed_purge_all' );
}

function koi_kayit_degisti( $post_id ) {
	if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
		return;
	}
	$turler = array( 'post', 'page', 'hizmet', 'atolye', 'uzman', 'galeri_gorsel', 'oyun_grubu', 'sss' );
	if ( in_array( get_post_type( $post_id ), $turler, true ) ) {
		koi_onbellegi_temizle();
	}
}
add_action( 'save_post', 'koi_kayit_degisti' );
add_action( 'trashed_post', 'koi_kayit_degisti' );
add_action( 'untrashed_post', 'koi_kayit_degisti' );
add_action( 'before_delete_post', 'koi_kayit_degisti' );
add_action( 'customize_save_after', 'koi_onbellegi_temizle' );
add_action( 'created_term', 'koi_onbellegi_temizle' );
add_action( 'edited_term', 'koi_onbellegi_temizle' );
add_action( 'delete_term', 'koi_onbellegi_temizle' );
