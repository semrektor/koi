<?php
/**
 * Bilgi talebi ve basvuru formlari.
 * Gonderilen form yonetim panelinde "Bilgi Talepleri" altina kaydedilir ve
 * e-posta ile bildirilir. Harici form eklentisi gerekmez.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function koi_form_turleri() {
	return array(
		'iletisim'   => 'İletişim formu',
		'oyun-grubu' => 'Oyun grubu başvurusu',
		'bulten'     => 'Bülten kaydı',
	);
}

/* Formlarda kabul edilen alanlar: ad => [etiket, tur] */
function koi_form_alanlari() {
	return array(
		'ad'      => array( 'Ad Soyad', 'metin' ),
		'telefon' => array( 'Telefon', 'metin' ),
		'eposta'  => array( 'E-posta', 'eposta' ),
		'konu'    => array( 'Konu', 'metin' ),
		'yontem'  => array( 'Dönüş yöntemi', 'metin' ),
		'zaman'   => array( 'Uygun zaman', 'metin' ),
		'yas'     => array( 'Çocuğun yaşı', 'metin' ),
		'grup'    => array( 'Grup', 'metin' ),
		'mesaj'   => array( 'Mesaj', 'uzun' ),
		'not'     => array( 'Not', 'uzun' ),
	);
}

/* ---------- Kayit turu ---------- */
function koi_talep_turu() {
	register_post_type(
		'koi_talep',
		array(
			'labels'              => array(
				'name'          => 'Bilgi Talepleri',
				'singular_name' => 'Bilgi Talebi',
				'edit_item'     => 'Talep Ayrıntısı',
				'search_items'  => 'Talep Ara',
				'not_found'     => 'Henüz talep yok.',
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_rest'        => false,
			'exclude_from_search' => true,
			'menu_icon'           => 'dashicons-email-alt',
			'menu_position'       => 20,
			'supports'            => array( 'title' ),
			'capability_type'     => 'page',
			'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'        => true,
		)
	);
}
add_action( 'init', 'koi_talep_turu' );

/* ---------- Form parcalari (sayfa govdelerinden cagrilir) ---------- */
function koi_form_gizli( $tur ) {
	echo '<input type="hidden" name="action" value="koi_talep">';
	echo '<input type="hidden" name="koi_tur" value="' . esc_attr( $tur ) . '">';
	/* Gonderimden sonra ziyaretci ayni sayfaya doner */
	wp_referer_field();
	/* Bal kupu: gercek ziyaretci bu alani gormez ve doldurmaz */
	echo '<p class="koi-bal" aria-hidden="true"><label>Bu alanı boş bırakın<input type="text" name="web_sitesi" tabindex="-1" autocomplete="off"></label></p>';
}

function koi_form_notu( $varsayilan = '' ) {
	$durum = isset( $_GET['talep'] ) ? sanitize_key( wp_unslash( $_GET['talep'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( 'ok' === $durum ) {
		echo '<p class="form-note form-note--ok" role="status">Teşekkür ederiz, talebiniz bize ulaştı. En kısa sürede dönüş yapacağız.</p>';
		return;
	}
	$hatalar = array(
		'eksik' => 'Lütfen zorunlu alanları doldurun ve KVKK onay kutusunu işaretleyin.',
		'sinir' => 'Kısa süre içinde çok fazla gönderim yapıldı. Lütfen biraz sonra tekrar deneyin.',
		'hata'  => 'Talebiniz kaydedilemedi. Lütfen tekrar deneyin veya bize telefonla ulaşın.',
	);
	if ( isset( $hatalar[ $durum ] ) ) {
		echo '<p class="form-note form-note--hata" role="alert">' . esc_html( $hatalar[ $durum ] ) . '</p>';
		return;
	}
	if ( '' !== $varsayilan ) {
		echo '<p class="form-note">' . esc_html( $varsayilan ) . '</p>';
	}
}

/* ---------- Gonderim ---------- */
function koi_talep_donus( $durum ) {
	$geri = wp_get_referer();
	if ( ! $geri ) {
		$geri = home_url( '/' );
	}
	$geri = remove_query_arg( 'talep', $geri );
	wp_safe_redirect( add_query_arg( 'talep', $durum, $geri ) . '#talep-formu' );
	exit;
}

function koi_talep_isle() {
	// phpcs:disable WordPress.Security.NonceVerification.Missing -- Herkese acik form; nonce sayfa onbellegiyle calismaz. Bal kupu ve hiz siniri kullanilir.
	if ( ! empty( $_POST['web_sitesi'] ) ) {
		koi_talep_donus( 'ok' ); // Bot: basarili gibi goster, kaydetme.
	}

	$turler = koi_form_turleri();
	$tur    = isset( $_POST['koi_tur'] ) ? sanitize_key( wp_unslash( $_POST['koi_tur'] ) ) : '';
	if ( ! isset( $turler[ $tur ] ) ) {
		koi_talep_donus( 'hata' );
	}

	/* Hiz siniri: ayni adresten saatte en fazla 5 gonderim */
	$ip      = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$anahtar = 'koi_talep_' . md5( $ip . wp_salt() );
	$sayi    = (int) get_transient( $anahtar );
	if ( $sayi >= 5 ) {
		koi_talep_donus( 'sinir' );
	}

	$veri = array();
	foreach ( koi_form_alanlari() as $ad => $alan ) {
		if ( ! isset( $_POST[ $ad ] ) ) {
			continue;
		}
		$ham = wp_unslash( $_POST[ $ad ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		if ( ! is_string( $ham ) ) {
			continue;
		}
		if ( 'eposta' === $alan[1] ) {
			$deger = sanitize_email( $ham );
		} elseif ( 'uzun' === $alan[1] ) {
			$deger = mb_substr( sanitize_textarea_field( $ham ), 0, 3000 );
		} else {
			$deger = mb_substr( sanitize_text_field( $ham ), 0, 200 );
		}
		if ( '' !== $deger ) {
			$veri[ $ad ] = $deger;
		}
	}
	$kvkk = ! empty( $_POST['kvkk'] );
	// phpcs:enable

	if ( 'bulten' === $tur ) {
		$gecerli = ! empty( $veri['eposta'] ) && is_email( $veri['eposta'] );
	} else {
		$gecerli = ! empty( $veri['ad'] ) && ! empty( $veri['telefon'] ) && $kvkk;
	}
	if ( ! $gecerli ) {
		koi_talep_donus( 'eksik' );
	}

	$kim    = ! empty( $veri['ad'] ) ? $veri['ad'] : $veri['eposta'];
	$kimlik = wp_insert_post(
		wp_slash(
			array(
				'post_type'   => 'koi_talep',
				'post_status' => 'private',
				'post_title'  => $kim . ' — ' . $turler[ $tur ],
			)
		),
		true
	);
	if ( is_wp_error( $kimlik ) || ! $kimlik ) {
		koi_talep_donus( 'hata' );
	}
	update_post_meta( $kimlik, 'koi_tur', $tur );
	update_post_meta( $kimlik, 'koi_durum', 'yeni' );
	foreach ( $veri as $ad => $deger ) {
		update_post_meta( $kimlik, 'koi_f_' . $ad, wp_slash( $deger ) );
	}
	set_transient( $anahtar, $sayi + 1, HOUR_IN_SECONDS );

	/* E-posta bildirimi */
	$alici = koi_ayar( 'form_eposta' );
	if ( ! is_email( $alici ) ) {
		$alici = get_option( 'admin_email' );
	}
	$satirlar = array( 'Form: ' . $turler[ $tur ], '' );
	$alanlar  = koi_form_alanlari();
	foreach ( $veri as $ad => $deger ) {
		$satirlar[] = $alanlar[ $ad ][0] . ': ' . $deger;
	}
	$satirlar[] = '';
	$satirlar[] = 'Talebi panelde görüntüle: ' . admin_url( 'post.php?post=' . (int) $kimlik . '&action=edit' );
	$basliklar  = array();
	if ( ! empty( $veri['eposta'] ) && is_email( $veri['eposta'] ) ) {
		$basliklar[] = 'Reply-To: ' . $veri['eposta'];
	}
	wp_mail( $alici, '[KOI] Yeni talep: ' . $kim, implode( "\n", $satirlar ), $basliklar );

	koi_talep_donus( 'ok' );
}
add_action( 'admin_post_nopriv_koi_talep', 'koi_talep_isle' );
add_action( 'admin_post_koi_talep', 'koi_talep_isle' );

/* ---------- Gonderen adresi ----------
   WordPress varsayilan olarak var olmayan "wordpress@alanadi" adresinden gonderir;
   alici sunucular (Gmail vb.) bu iletileri reddeder. Kurumsal e-posta sitenin
   alan adindaysa iletiler o adresten gonderilir. Posta kutusunun barindirma
   panelinde acilmis olmasi gerekir. */
function koi_posta_gonderen( $adres ) {
	$kurumsal = koi_ayar( 'eposta' );
	$alan     = preg_replace( '/^www\./', '', (string) wp_parse_url( home_url(), PHP_URL_HOST ) );
	if ( $alan && is_email( $kurumsal ) ) {
		$son = '@' . strtolower( $alan );
		if ( substr( strtolower( $kurumsal ), -strlen( $son ) ) === $son ) {
			return $kurumsal;
		}
	}
	return $adres;
}
add_filter( 'wp_mail_from', 'koi_posta_gonderen' );

function koi_posta_gonderen_adi( $ad ) {
	$site = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
	return '' !== $site ? $site : $ad;
}
add_filter( 'wp_mail_from_name', 'koi_posta_gonderen_adi' );

/* ---------- Yonetim paneli gorunumu ---------- */
function koi_talep_sutunlari( $sutunlar ) {
	return array(
		'cb'           => isset( $sutunlar['cb'] ) ? $sutunlar['cb'] : '',
		'title'        => 'Talep',
		'koi_tur'      => 'Form',
		'koi_iletisim' => 'İletişim',
		'koi_durum'    => 'Durum',
		'date'         => 'Tarih',
	);
}
add_filter( 'manage_koi_talep_posts_columns', 'koi_talep_sutunlari' );

function koi_talep_sutun_icerigi( $sutun, $post_id ) {
	if ( 'koi_tur' === $sutun ) {
		$turler = koi_form_turleri();
		$tur    = (string) get_post_meta( $post_id, 'koi_tur', true );
		echo esc_html( isset( $turler[ $tur ] ) ? $turler[ $tur ] : $tur );
	} elseif ( 'koi_iletisim' === $sutun ) {
		$parcalar = array_filter(
			array(
				(string) get_post_meta( $post_id, 'koi_f_telefon', true ),
				(string) get_post_meta( $post_id, 'koi_f_eposta', true ),
			)
		);
		echo esc_html( implode( ' · ', $parcalar ) );
	} elseif ( 'koi_durum' === $sutun ) {
		echo 'tamam' === get_post_meta( $post_id, 'koi_durum', true ) ? 'Yanıtlandı' : '<strong>Yeni</strong>';
	}
}
add_action( 'manage_koi_talep_posts_custom_column', 'koi_talep_sutun_icerigi', 10, 2 );

function koi_talep_kutusu_ekle() {
	add_meta_box( 'koi_talep_ayrinti', 'Talep Bilgileri', 'koi_talep_kutusu', 'koi_talep', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'koi_talep_kutusu_ekle' );

function koi_talep_kutusu( $post ) {
	wp_nonce_field( 'koi_talep_kaydet', 'koi_talep_nonce' );
	echo '<table class="form-table"><tbody>';
	foreach ( koi_form_alanlari() as $ad => $alan ) {
		$deger = (string) get_post_meta( $post->ID, 'koi_f_' . $ad, true );
		if ( '' === $deger ) {
			continue;
		}
		echo '<tr><th scope="row">' . esc_html( $alan[0] ) . '</th><td>' . nl2br( esc_html( $deger ) ) . '</td></tr>';
	}
	$durum = (string) get_post_meta( $post->ID, 'koi_durum', true );
	echo '<tr><th scope="row"><label for="koi_durum">Durum</label></th><td><select id="koi_durum" name="koi_durum">';
	echo '<option value="yeni"' . selected( 'tamam' !== $durum, true, false ) . '>Yeni</option>';
	echo '<option value="tamam"' . selected( $durum, 'tamam', false ) . '>Yanıtlandı</option>';
	echo '</select></td></tr></tbody></table>';
}

function koi_talep_kaydet( $post_id ) {
	if ( ! isset( $_POST['koi_talep_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['koi_talep_nonce'] ) ), 'koi_talep_kaydet' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) || ! isset( $_POST['koi_durum'] ) ) {
		return;
	}
	$durum = sanitize_key( wp_unslash( $_POST['koi_durum'] ) );
	update_post_meta( $post_id, 'koi_durum', 'tamam' === $durum ? 'tamam' : 'yeni' );
}
add_action( 'save_post_koi_talep', 'koi_talep_kaydet' );
