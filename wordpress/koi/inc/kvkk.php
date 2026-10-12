<?php
/**
 * KVKK veri araclari: basvurularin saklama suresi ve kisisel veri talepleri.
 *
 * - Saklama suresi: Gorunum > Ozellestir > KOI Veri Saklama. Sure dolan
 *   basvurular gunde bir kez kalici olarak silinir. Varsayilan: kapali.
 * - Araclar > Kisisel verileri disa aktar / sil: e-posta adresiyle yapilan
 *   taleplerde o adrese ait basvurular da dahil edilir.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ---------- Saklama suresi ---------- */
function koi_saklama_ay() {
	return absint( get_theme_mod( 'koi_saklama_ay', 0 ) );
}

function koi_saklama_ayari( $wp_customize ) {
	$wp_customize->add_section(
		'koi_veri',
		array(
			'title'       => 'KOI Veri Saklama',
			'description' => 'Formlardan gelen başvurular (Bilgi Talepleri) burada belirlenen süre sonunda kalıcı olarak silinir. Süreyi KVKK aydınlatma metninizde yazan saklama süresiyle aynı tutun.',
			'priority'    => 31,
		)
	);
	$wp_customize->add_setting(
		'koi_saklama_ay',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'koi_saklama_ay',
		array(
			'label'       => 'Başvuruların saklanma süresi (ay)',
			'description' => '0 yazarsanız otomatik silme kapalıdır; başvurular siz silene kadar durur.',
			'section'     => 'koi_veri',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 120,
				'step' => 1,
			),
		)
	);
}
add_action( 'customize_register', 'koi_saklama_ayari' );

function koi_talep_temizlik_planla() {
	if ( ! wp_next_scheduled( 'koi_talep_temizle' ) ) {
		wp_schedule_event( time() + HOUR_IN_SECONDS, 'daily', 'koi_talep_temizle' );
	}
}
add_action( 'init', 'koi_talep_temizlik_planla' );

function koi_talep_temizle() {
	$ay = koi_saklama_ay();
	if ( $ay < 1 ) {
		return;
	}
	$eskiler = get_posts(
		array(
			'post_type'        => 'koi_talep',
			'post_status'      => array( 'private', 'publish', 'draft', 'pending', 'trash' ),
			'numberposts'      => 200,
			'fields'           => 'ids',
			'suppress_filters' => true,
			'date_query'       => array(
				array(
					'before' => $ay . ' months ago',
				),
			),
		)
	);
	foreach ( $eskiler as $kimlik ) {
		wp_delete_post( (int) $kimlik, true );
	}
}
add_action( 'koi_talep_temizle', 'koi_talep_temizle' );

function koi_talep_temizlik_iptal() {
	wp_clear_scheduled_hook( 'koi_talep_temizle' );
}
add_action( 'switch_theme', 'koi_talep_temizlik_iptal' );

/* ---------- Kisisel veri talepleri (Araclar > Kisisel verileri disa aktar / sil) ---------- */
function koi_talepler_eposta( $eposta, $sayfa ) {
	return get_posts(
		array(
			'post_type'        => 'koi_talep',
			'post_status'      => array( 'private', 'publish', 'draft', 'pending', 'trash' ),
			'numberposts'      => 50,
			'paged'            => max( 1, (int) $sayfa ),
			'suppress_filters' => true,
			'meta_key'         => 'koi_f_eposta', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value'       => $eposta, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
		)
	);
}

function koi_talep_disa_aktar( $eposta, $sayfa = 1 ) {
	$ogeler  = array();
	$turler  = koi_form_turleri();
	$alanlar = koi_form_alanlari();
	$liste   = koi_talepler_eposta( $eposta, $sayfa );
	foreach ( $liste as $talep ) {
		$tur   = (string) get_post_meta( $talep->ID, 'koi_tur', true );
		$veri  = array(
			array(
				'name'  => 'Form',
				'value' => isset( $turler[ $tur ] ) ? $turler[ $tur ] : $tur,
			),
			array(
				'name'  => 'Tarih',
				'value' => get_the_date( 'd.m.Y H:i', $talep ),
			),
		);
		foreach ( $alanlar as $ad => $alan ) {
			$deger = (string) get_post_meta( $talep->ID, 'koi_f_' . $ad, true );
			if ( '' !== $deger ) {
				$veri[] = array(
					'name'  => $alan[0],
					'value' => $deger,
				);
			}
		}
		$ogeler[] = array(
			'group_id'    => 'koi-talepler',
			'group_label' => 'Bilgi Talepleri',
			'item_id'     => 'koi-talep-' . $talep->ID,
			'data'        => $veri,
		);
	}
	return array(
		'data' => $ogeler,
		'done' => count( $liste ) < 50,
	);
}

function koi_talep_kisisel_sil( $eposta, $sayfa = 1 ) {
	/* Silinen kayitlar listeden dustugu icin her seferinde ilk sayfa okunur */
	$liste   = koi_talepler_eposta( $eposta, 1 );
	$silinen = 0;
	foreach ( $liste as $talep ) {
		if ( wp_delete_post( $talep->ID, true ) ) {
			$silinen++;
		}
	}
	return array(
		'items_removed'  => $silinen > 0,
		'items_retained' => false,
		'messages'       => array(),
		'done'           => count( $liste ) < 50,
	);
}

function koi_kisisel_veri_aktaricilari( $liste ) {
	$liste['koi-talepler'] = array(
		'exporter_friendly_name' => 'KOI Bilgi Talepleri',
		'callback'               => 'koi_talep_disa_aktar',
	);
	return $liste;
}
add_filter( 'wp_privacy_personal_data_exporters', 'koi_kisisel_veri_aktaricilari' );

function koi_kisisel_veri_siliciler( $liste ) {
	$liste['koi-talepler'] = array(
		'eraser_friendly_name' => 'KOI Bilgi Talepleri',
		'callback'             => 'koi_talep_kisisel_sil',
	);
	return $liste;
}
add_filter( 'wp_privacy_personal_data_erasers', 'koi_kisisel_veri_siliciler' );
