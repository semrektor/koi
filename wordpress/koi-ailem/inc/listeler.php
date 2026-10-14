<?php
/**
 * Panelden yonetilen listeler: oyun gruplari, atolye program tablosu, sik
 * sorulan sorular, formlardaki secenek listeleri ve sayfa ust bolumu metinleri.
 * HTML yapisi taslaktaki (build/generate-pages.js) yapiyla aynidir.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ---------- Oyun gruplari ---------- */
function koi_grup_kartlari() {
	$cikti = '';
	foreach ( koi_kayitlar( 'oyun_grubu' ) as $grup ) {
		$yas       = (string) get_post_meta( $grup->ID, 'koi_yas', true );
		$kisa      = (string) get_post_meta( $grup->ID, 'koi_kisa', true );
		$kontenjan = (string) get_post_meta( $grup->ID, 'koi_kontenjan', true );

		$cikti .= '<article class="card reveal">';
		$cikti .= koi_medya( $grup->ID, 'media--ratio-4-5' );
		$cikti .= '<div class="card__body">';
		if ( '' !== $yas ) {
			$cikti .= '<span class="card__meta">' . esc_html( $yas ) . '</span>';
		}
		$cikti .= '<h3 class="card__title">' . esc_html( get_the_title( $grup ) ) . '</h3>';
		if ( '' !== $kisa ) {
			$cikti .= '<p class="card__text">' . esc_html( $kisa ) . '</p>';
		}
		if ( '' !== $kontenjan ) {
			$cikti .= '<span class="badge badge--olive">' . esc_html( $kontenjan ) . '</span>';
		}
		$cikti .= '</div></article>';
	}
	return $cikti;
}

function koi_grup_tablosu() {
	$cikti = '';
	foreach ( koi_kayitlar( 'oyun_grubu' ) as $grup ) {
		$kontenjan = (string) get_post_meta( $grup->ID, 'koi_kontenjan', true );
		$cikti    .= '<tr>';
		$cikti    .= '<td data-th="Grup">' . esc_html( get_the_title( $grup ) ) . '</td>';
		$cikti    .= '<td data-th="Yaş">' . esc_html( (string) get_post_meta( $grup->ID, 'koi_yas', true ) ) . '</td>';
		$cikti    .= '<td data-th="Gün ve saat">' . esc_html( (string) get_post_meta( $grup->ID, 'koi_gun_saat', true ) ) . '</td>';
		$cikti    .= '<td data-th="Kontenjan">' . ( '' !== $kontenjan ? '<span class="badge">' . esc_html( $kontenjan ) . '</span>' : '' ) . '</td>';
		$cikti    .= '<td data-th="Ebeveyn katılımı">' . esc_html( (string) get_post_meta( $grup->ID, 'koi_ebeveyn', true ) ) . '</td>';
		$cikti    .= '</tr>';
	}
	return $cikti;
}

/* ---------- Formlardaki secenek listeleri ----------
   Ayni listeler hem formda gosterilir hem de gonderimde dogrulama icin kullanilir. */
function koi_grup_secenek_listesi() {
	$liste = array();
	foreach ( koi_kayitlar( 'oyun_grubu' ) as $grup ) {
		$yas     = (string) get_post_meta( $grup->ID, 'koi_yas', true );
		/* Ham baslik: tarayicinin gonderdigi metinle birebir karsilastirilabilsin */
		$liste[] = $grup->post_title . ( '' !== $yas ? ' (' . $yas . ')' : '' );
	}
	$liste[] = 'Hangi grubun uygun olduğundan emin değilim';
	return $liste;
}

function koi_konu_secenek_listesi() {
	$liste = array();
	foreach ( koi_kayitlar( 'hizmet' ) as $hizmet ) {
		$liste[] = $hizmet->post_title;
	}
	return array_merge( $liste, array( 'Oyun Grupları', 'Atölye / Seminer', 'Diğer' ) );
}

function koi_secenek_etiketleri( $liste ) {
	$cikti = '';
	foreach ( $liste as $secenek ) {
		$cikti .= '<option>' . esc_html( $secenek ) . '</option>';
	}
	return $cikti;
}

/* ---------- Atolye program tablosu ----------
   Satirlar her atolyenin "Kisa bilgi kutusu" alanindaki ayni adli satirlardan okunur. */
function koi_bilgi_satirlari( $post_id ) {
	$satirlar = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) get_post_meta( $post_id, 'koi_bilgi', true ) ) as $satir ) {
		$parca = explode( ':', $satir, 2 );
		if ( 2 === count( $parca ) && '' !== trim( $parca[0] ) ) {
			$satirlar[ mb_strtolower( trim( $parca[0] ) ) ] = trim( $parca[1] );
		}
	}
	return $satirlar;
}

function koi_atolye_tablosu() {
	$sutunlar = array(
		'Katılımcı'     => 'katılımcı',
		'Tarih ve saat' => 'tarih ve saat',
		'Süre'          => 'süre',
		'Kontenjan'     => 'kontenjan',
	);
	$cikti    = '';
	foreach ( koi_kayitlar( 'atolye' ) as $atolye ) {
		$bilgi  = koi_bilgi_satirlari( $atolye->ID );
		$cikti .= '<tr><td data-th="Atölye / seminer"><a href="' . esc_url( get_permalink( $atolye ) ) . '">' . esc_html( get_the_title( $atolye ) ) . '</a></td>';
		foreach ( $sutunlar as $baslik => $anahtar ) {
			$cikti .= '<td data-th="' . esc_attr( $baslik ) . '">' . esc_html( isset( $bilgi[ $anahtar ] ) ? $bilgi[ $anahtar ] : '—' ) . '</td>';
		}
		$cikti .= '</tr>';
	}
	return $cikti;
}

/* ---------- Sik sorulan sorular ---------- */
function koi_akordeon( $sorular, $ilk_acik ) {
	if ( ! $sorular ) {
		return '';
	}
	$cikti = '<div class="accordion reveal">';
	$sira  = 0;
	foreach ( $sorular as $soru ) {
		$acik   = ( $ilk_acik && 0 === $sira );
		$cikti .= '<div class="accordion__item' . ( $acik ? ' is-open' : '' ) . '">';
		$cikti .= '<button class="accordion__trigger" type="button" aria-expanded="' . ( $acik ? 'true' : 'false' ) . '">' . esc_html( get_the_title( $soru ) ) . '<svg aria-hidden="true"><use href="#i-plus"></use></svg></button>';
		$cikti .= '<div class="accordion__panel">' . apply_filters( 'the_content', $soru->post_content ) . '</div>';
		$cikti .= '</div>';
		$sira++;
	}
	return $cikti . '</div>';
}

/* Belirli bir sayfada da gosterilmek uzere isaretlenmis sorular ($yer: hizmetler | iletisim) */
function koi_sss_secili( $yer ) {
	$liste = array();
	foreach ( koi_kayitlar( 'sss' ) as $soru ) {
		if ( '1' === (string) get_post_meta( $soru->ID, 'koi_sss_' . $yer, true ) ) {
			$liste[] = $soru;
		}
	}
	return $liste;
}

/* SSS sayfasi: bolum bolum */
function koi_sss_bolumleri() {
	$gruplar = array();
	$diger   = array();
	foreach ( koi_kayitlar( 'sss' ) as $soru ) {
		$terim = koi_ilk_terim( $soru );
		if ( $terim ) {
			$gruplar[ $terim->term_id ][] = $soru;
		} else {
			$diger[] = $soru;
		}
	}

	$bolumler = array();
	$terimler = get_terms(
		array(
			'taxonomy'   => 'sss_bolum',
			'hide_empty' => true,
			'orderby'    => 'term_id',
			'order'      => 'ASC',
		)
	);
	if ( ! is_wp_error( $terimler ) ) {
		foreach ( $terimler as $terim ) {
			if ( ! empty( $gruplar[ $terim->term_id ] ) ) {
				$bolumler[] = array( $terim->description, $terim->name, $gruplar[ $terim->term_id ] );
			}
		}
	}
	if ( $diger ) {
		$bolumler[] = array( $bolumler ? 'Diğer' : 'Sık Sorulanlar', $bolumler ? 'Diğer Sorular' : 'Merak Edilenler', $diger );
	}

	$cikti = '';
	$sira  = 0;
	foreach ( $bolumler as $bolum ) {
		$cikti .= '<section class="section' . ( $sira % 2 ? ' section--cream' : '' ) . ' section--tight"><div class="container container--wide">';
		$cikti .= '<div class="section-head reveal">';
		if ( '' !== (string) $bolum[0] ) {
			$cikti .= '<span class="eyebrow">' . esc_html( $bolum[0] ) . '</span>';
		}
		$cikti .= '<h2>' . esc_html( $bolum[1] ) . '</h2></div>';
		$cikti .= koi_akordeon( $bolum[2], false );
		$cikti .= '</div></section>';
		$sira++;
	}
	return $cikti;
}

/* Instagram adresinden kullanici adi: https://www.instagram.com/koiworld/ -> @koiworld */
function koi_instagram_adi() {
	$yol = trim( (string) wp_parse_url( koi_ayar( 'instagram' ), PHP_URL_PATH ), '/' );
	$ad  = '' !== $yol ? explode( '/', $yol )[0] : '';
	return '' !== $ad ? '@' . $ad : 'Instagram';
}
