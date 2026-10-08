<?php
/**
 * Kurulum ve icerik guncelleme: Gorunum > KOI Kurulum.
 *
 * "Icerikleri Olustur"  : eksik sayfalari, hizmetleri ve atolyeleri olusturur;
 *                         var olan icerige dokunmaz, guvenle tekrar calistirilabilir.
 * "Icerikleri Guncelle" : temayla gelen icerigi var olan kayitlarin uzerine yazar,
 *                         adresi degisen kayitlari yeniden adlandirir ve artik
 *                         kullanilmayan ornek yazilari cop kutusuna tasir.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Kaydi yeni ya da onceki adresinden bulur */
function koi_kurulum_bul( $kayit, $tur ) {
	$var = get_page_by_path( $kayit['slug'], OBJECT, $tur );
	if ( ! $var && ! empty( $kayit['eski_slug'] ) ) {
		$var = get_page_by_path( $kayit['eski_slug'], OBJECT, $tur );
	}
	return $var;
}

/* Donus: 'eklendi', 'guncellendi' ya da '' (dokunulmadi) */
function koi_kurulum_kayit( $kayit, $tur, $sira, $guncelle = false ) {
	$var = koi_kurulum_bul( $kayit, $tur );
	if ( $var && ! $guncelle ) {
		return '';
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
	if ( $var ) {
		$dizi['ID'] = $var->ID;
		$kimlik     = wp_update_post( wp_slash( $dizi ), true );
	} else {
		if ( 'post' === $tur ) {
			/* Yazilar taslaktaki sirayla gorunsun diye tarihler birer hafta arayla verilir */
			$dizi['post_date'] = gmdate( 'Y-m-d H:i:s', time() - $sira * WEEK_IN_SECONDS + (int) ( (float) get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) );
		}
		$kimlik = wp_insert_post( wp_slash( $dizi ), true );
	}
	if ( is_wp_error( $kimlik ) || ! $kimlik ) {
		return '';
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
		} else {
			delete_post_meta( $kimlik, $anahtar );
		}
	}
	if ( ! empty( $kayit['one_cikan'] ) ) {
		stick_post( $kimlik );
	}
	return $var ? 'guncellendi' : 'eklendi';
}

function koi_icerik_kur( $guncelle = false ) {
	$dosya = KOI_DIR . '/veri/icerik.json';
	$veri  = file_exists( $dosya ) ? json_decode( (string) file_get_contents( $dosya ), true ) : null;
	if ( ! is_array( $veri ) || empty( $veri['sayfalar'] ) ) {
		return new WP_Error( 'koi_veri', 'İçerik dosyası (veri/icerik.json) okunamadı.' );
	}

	$rapor = array(
		'sayfa'      => 0,
		'hizmet'     => 0,
		'atolye'     => 0,
		'yazi'       => 0,
		'guncelleme' => 0,
		'kaldirilan' => 0,
	);

	/* WordPress'in ornek icerigi cop kutusuna (geri alinabilir) */
	foreach ( array( array( 'hello-world', 'post' ), array( 'merhaba-dunya', 'post' ), array( 'sample-page', 'page' ), array( 'ornek-sayfa', 'page' ) ) as $ornek ) {
		$kayit = get_page_by_path( $ornek[0], OBJECT, $ornek[1] );
		if ( $kayit ) {
			wp_trash_post( $kayit->ID );
		}
	}

	/* Sayfalar: govdeleri temadan gelir, burada yalnizca eksik olanlar olusturulur */
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
	$turler = array(
		'hizmetler' => array( 'hizmet', 'hizmet' ),
		'atolyeler' => array( 'atolye', 'atolye' ),
		'blog'      => array( 'post', 'yazi' ),
	);
	foreach ( $turler as $anahtar => $tur ) {
		if ( empty( $veri[ $anahtar ] ) ) {
			continue;
		}
		$sira = 0;
		foreach ( $veri[ $anahtar ] as $kayit ) {
			$sonuc = koi_kurulum_kayit( $kayit, $tur[0], $sira++, $guncelle );
			if ( 'eklendi' === $sonuc ) {
				$rapor[ $tur[1] ]++;
			} elseif ( 'guncellendi' === $sonuc ) {
				$rapor['guncelleme']++;
			}
		}
	}

	/* Artik kullanilmayan ornek icerik (yalnizca guncellemede; cop kutusundan geri alinabilir) */
	if ( $guncelle && ! empty( $veri['kaldirilan'] ) && is_array( $veri['kaldirilan'] ) ) {
		foreach ( $veri['kaldirilan'] as $tur => $adresler ) {
			if ( ! post_type_exists( $tur ) ) {
				continue;
			}
			foreach ( (array) $adresler as $adres ) {
				$kayit = get_page_by_path( sanitize_title( $adres ), OBJECT, $tur );
				if ( $kayit && 'trash' !== $kayit->post_status && wp_trash_post( $kayit->ID ) ) {
					$rapor['kaldirilan']++;
				}
			}
		}
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

	$sonuc = null;
	if ( isset( $_POST['koi_kur'] ) && check_admin_referer( 'koi_kurulum' ) ) {
		$sonuc = koi_icerik_kur( false );
	} elseif ( isset( $_POST['koi_guncelle'] ) && check_admin_referer( 'koi_kurulum' ) ) {
		if ( empty( $_POST['koi_onay'] ) ) {
			echo '<div class="notice notice-warning"><p>Güncelleme için onay kutusunu işaretleyin.</p></div>';
		} else {
			$sonuc = koi_icerik_kur( true );
		}
	}
	if ( is_wp_error( $sonuc ) ) {
		echo '<div class="notice notice-error"><p>' . esc_html( $sonuc->get_error_message() ) . '</p></div>';
	} elseif ( is_array( $sonuc ) ) {
		echo '<div class="notice notice-success"><p>' . esc_html(
			sprintf(
				'Tamamlandı: %d sayfa, %d hizmet, %d atölye, %d blog yazısı eklendi; %d kayıt güncellendi; %d örnek kayıt çöp kutusuna taşındı.',
				$sonuc['sayfa'],
				$sonuc['hizmet'],
				$sonuc['atolye'],
				$sonuc['yazi'],
				$sonuc['guncelleme'],
				$sonuc['kaldirilan']
			)
		) . '</p></div>';
	}

	echo '<p>Tema sürümü: <strong>' . esc_html( KOI_SURUM ) . '</strong>';
	$kurulu = get_option( 'koi_kurulum_tamam' );
	if ( $kurulu ) {
		echo ' · İçerik sürümü: <strong>' . esc_html( $kurulu ) . '</strong>';
	}
	echo '</p>';

	echo '<form method="post">';
	wp_nonce_field( 'koi_kurulum' );

	echo '<h2>İçerikleri Oluştur</h2>';
	echo '<p>Eksik sayfaları, hizmetleri ve atölyeleri oluşturur; site adını, anasayfayı ve kalıcı bağlantıları ayarlar. Var olan içeriğe dokunmaz, bu yüzden tekrar çalıştırmak güvenlidir.</p>';
	submit_button( 'İçerikleri Oluştur', 'primary', 'koi_kur', false );

	echo '<h2 style="margin-top:2.5em">İçerikleri Güncelle</h2>';
	echo '<p>Hizmet ve atölyeleri temayla gelen son haline getirir, adresi değişenleri yeniden adlandırır ve artık kullanılmayan örnek blog yazılarını çöp kutusuna taşır.</p>';
	echo '<p><strong>Dikkat:</strong> Hizmet ve atölyelerde panelden yaptığınız metin değişikliklerinin üzerine yazılır. Kendi eklediğiniz hizmet, atölye ve yazılara dokunulmaz.</p>';
	echo '<p><label><input type="checkbox" name="koi_onay" value="1"> Panelden yapılan değişikliklerin üzerine yazılacağını anladım.</label></p>';
	submit_button( 'İçerikleri Güncelle', 'secondary', 'koi_guncelle', false );
	echo '</form>';

	echo '<p style="margin-top:2.5em">İletişim bilgileri: <a href="' . esc_url( admin_url( 'customize.php?autofocus[section]=koi_iletisim' ) ) . '">Görünüm → Özelleştir → KOI İletişim Bilgileri</a></p>';
	echo '</div>';
}

function koi_kurulum_uyarisi() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$ekran = get_current_screen();
	if ( $ekran && 'appearance_page_koi-kurulum' === $ekran->id ) {
		return;
	}
	$kurulu = get_option( 'koi_kurulum_tamam' );
	$adres  = esc_url( admin_url( 'themes.php?page=koi-kurulum' ) );
	if ( ! $kurulu ) {
		echo '<div class="notice notice-info"><p>KOI teması etkin. Sayfaları ve içerikleri oluşturmak için <a href="' . $adres . '">KOI Kurulum</a> sayfasını açın.</p></div>';
	} elseif ( version_compare( (string) $kurulu, KOI_SURUM, '<' ) ) {
		echo '<div class="notice notice-info"><p>KOI teması güncellendi. Yeni sayfaları eklemek ve içerikleri güncellemek için <a href="' . $adres . '">KOI Kurulum</a> sayfasını açın.</p></div>';
	}
}
add_action( 'admin_notices', 'koi_kurulum_uyarisi' );
