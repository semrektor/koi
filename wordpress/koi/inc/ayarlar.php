<?php
/**
 * Iletisim bilgileri: Gorunum > Ozellestir > KOI Iletisim Bilgileri.
 * Telefon, e-posta, adres gibi bilgiler sitenin her yerinde buradan okunur.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function koi_ayar_alanlari() {
	return array(
		'telefon'     => array( 'Telefon (sitede görünen hali)', '+90 (000) 000 00 00', 'text', 'sanitize_text_field' ),
		'whatsapp'    => array( 'WhatsApp numarası (yalnızca rakam, 90 ile başlar)', '900000000000', 'text', 'sanitize_text_field' ),
		'eposta'      => array( 'E-posta', 'info@koiailem.com', 'email', 'sanitize_email' ),
		'adres'       => array( 'Kısa adres (alt bilgide görünür)', 'Necip Fazıl Mah. — Ümraniye / İstanbul', 'text', 'sanitize_text_field' ),
		'acik_adres'  => array( 'Açık adres (İletişim ve KVKK sayfalarında görünür)', 'Necip Fazıl Mah. Hamza Yerlikaya Bulvarı, Narlı Bahçe Evleri Sitesi B Blok No: 70 BF, 34773 Ümraniye / İstanbul', 'text', 'sanitize_text_field' ),
		'saat1'       => array( 'Çalışma saatleri (1. satır)', 'Hafta içi 09:00 – 19:00', 'text', 'sanitize_text_field' ),
		'saat2'       => array( 'Çalışma saatleri (2. satır)', 'Hafta sonu: program ve randevu durumuna göre', 'text', 'sanitize_text_field' ),
		'instagram'   => array( 'Instagram adresi', 'https://www.instagram.com/koiworld/', 'url', 'esc_url_raw' ),
		'form_eposta' => array( 'Form başvurularının gideceği e-posta (boşsa site yöneticisi)', '', 'email', 'sanitize_email' ),
	);
}

function koi_ayar( $anahtar ) {
	$alanlar    = koi_ayar_alanlari();
	$varsayilan = isset( $alanlar[ $anahtar ] ) ? $alanlar[ $anahtar ][1] : '';
	$deger      = get_theme_mod( 'koi_' . $anahtar, $varsayilan );
	return ( is_string( $deger ) && '' !== trim( $deger ) ) ? $deger : $varsayilan;
}

function koi_tel_url() {
	return 'tel:+' . preg_replace( '/\D+/', '', koi_ayar( 'telefon' ) );
}

function koi_wa_url() {
	return 'https://wa.me/' . preg_replace( '/\D+/', '', koi_ayar( 'whatsapp' ) );
}

function koi_ozellestirici( $wp_customize ) {
	$wp_customize->add_section(
		'koi_iletisim',
		array(
			'title'       => 'KOI İletişim Bilgileri',
			'description' => 'Buradaki bilgiler üst menü, alt bilgi ve iletişim sayfasında kullanılır.',
			'priority'    => 30,
		)
	);
	foreach ( koi_ayar_alanlari() as $anahtar => $alan ) {
		$wp_customize->add_setting(
			'koi_' . $anahtar,
			array(
				'default'           => $alan[1],
				'sanitize_callback' => $alan[3],
			)
		);
		$wp_customize->add_control(
			'koi_' . $anahtar,
			array(
				'label'   => $alan[0],
				'section' => 'koi_iletisim',
				'type'    => $alan[2],
			)
		);
	}
}
add_action( 'customize_register', 'koi_ozellestirici' );
