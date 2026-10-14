<?php
/**
 * Sayfa icerikleri: sayfalardaki metinler ve gorseller panelden degistirilir.
 *
 * - Sayfa govdelerindeki metin, liste ve gorsel alanlari build/wp-alanlar.js ile
 *   cikarilir; varsayilanlari veri/alanlar.json dosyasindadir. Degistirilen degerler
 *   tek bir tema ayarinda (koi_alanlar) tutulur ve Gorunum > Ozellestir > Sayfa
 *   Icerikleri bolumunden canli onizlemeyle duzenlenir.
 * - Yasal metin sayfalarinin (KVKK, Gizlilik, Cerez) govdesi sayfa duzenleyicisinden gelir.
 * - Hizmet, atolye, blog ve uzman sayfalarinda ortak kullanilan metinler "Ortak Metinler"
 *   bolumundedir.
 * - Ust menu ve alt bilgi (header/footer) bu sistemin disindadir.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ---------- Veri ---------- */
function koi_alan_verisi() {
	static $veri = null;
	if ( null === $veri ) {
		$veri  = array(
			'sayfalar' => array(),
			'ust'      => array(),
			'metinler' => array(),
		);
		$dosya = KOI_DIR . '/veri/alanlar.json';
		if ( file_exists( $dosya ) ) {
			$okunan = json_decode( (string) file_get_contents( $dosya ), true );
			if ( is_array( $okunan ) ) {
				$veri = array_merge( $veri, $okunan );
			}
		}
	}
	return $veri;
}

/* Hizmet, atolye, blog ve uzman sayfalarinda ortak kullanilan metinler: kimlik => tanim */
function koi_ortak_alanlar() {
	static $liste = null;
	if ( null !== $liste ) {
		return $liste;
	}
	$gruplar = array(
		'Hizmet sayfaları'     => array(
			'ortak-hizmet-bilgi'        => array( 'Bilgi kutusu başlığı', 'Kısa Bilgi' ),
			'ortak-hizmet-cta-baslik'   => array( 'Başvuru kutusu başlığı', 'Bilgi Alın' ),
			'ortak-hizmet-cta-metin'    => array( 'Başvuru kutusu metni', 'Süreç hakkında konuşmak ve uygun saatleri belirlemek için ön başvuru formunu doldurabilirsiniz.' ),
			'ortak-hizmet-cta-dugme'    => array( 'Başvuru düğmesi', 'Ön Başvuru' ),
			'ortak-hizmet-diger'        => array( 'Diğer hizmetler kutusu başlığı', 'Diğer Hizmetler' ),
			'ortak-hizmet-tumu'         => array( 'Tüm hizmetler bağlantısı', 'Tüm Hizmetler' ),
			'ortak-hizmet-ilgili-ust'   => array( 'Alt bölüm üst yazısı', 'İlgili Hizmetler' ),
			'ortak-hizmet-ilgili'       => array( 'Alt bölüm başlığı', 'Birlikte İlerleyen Süreçler' ),
		),
		'Atölye sayfaları'     => array(
			'ortak-atolye-bilgi'        => array( 'Bilgi kutusu başlığı', 'Program Bilgisi' ),
			'ortak-atolye-cta-baslik'   => array( 'Başvuru kutusu başlığı', 'Yerinizi Ayırtın' ),
			'ortak-atolye-cta-metin'    => array( 'Başvuru kutusu metni', 'Kontenjan durumunu ve katılım detaylarını paylaşabilmemiz için başvurunuzu iletin.' ),
			'ortak-atolye-cta-dugme'    => array( 'Başvuru düğmesi', 'Atölye Başvurusu' ),
			'ortak-atolye-diger'        => array( 'Diğer atölyeler kutusu başlığı', 'Diğer Atölyeler' ),
			'ortak-atolye-tumu'         => array( 'Tüm atölyeler bağlantısı', 'Tüm Program Takvimi' ),
			'ortak-atolye-ilgili-ust'   => array( 'Alt bölüm üst yazısı', 'Diğer Atölyeler' ),
			'ortak-atolye-ilgili'       => array( 'Alt bölüm başlığı', 'Bunlar da İlginizi Çekebilir' ),
		),
		'Blog yazıları'        => array(
			'ortak-blog-icindekiler'    => array( 'İçindekiler kutusu başlığı', 'Bu Yazıda' ),
			'ortak-blog-cta-baslik'     => array( 'Başvuru kutusu başlığı', 'Bir Uzmanla Konuşun' ),
			'ortak-blog-cta-metin'      => array( 'Başvuru kutusu metni', 'Bu konuda zorlanıyorsanız, kısa bir ön görüşmeyle başlayabiliriz.' ),
			'ortak-blog-cta-dugme'      => array( 'Başvuru düğmesi', 'Bilgi Al' ),
			'ortak-blog-kategoriler'    => array( 'Kategoriler kutusu başlığı', 'Kategoriler' ),
			'ortak-blog-ilgili-ust'     => array( 'Alt bölüm üst yazısı', 'Devamı' ),
			'ortak-blog-ilgili'         => array( 'Alt bölüm başlığı', 'İlgili Yazılar' ),
			'ortak-blog-one-cikan'      => array( 'Blog sayfasında öne çıkan yazı üst yazısı', 'Öne Çıkan Yazı' ),
			'ortak-blog-oku'            => array( 'Yazıyı açan bağlantı ve düğme', 'Yazıyı Oku' ),
		),
		'Uzmanlar'             => array(
			'ortak-uzman-kart-notu'     => array( 'Fotoğrafı olmayan uzman kartındaki not', 'Fotoğraf çekim sonrası eklenecek' ),
			'ortak-uzman-portre-notu'   => array( 'Fotoğrafı olmayan büyük portredeki not', 'Portre — çekim sonrası eklenecek' ),
			'ortak-uzman-profil'        => array( 'Uzman kartındaki bağlantı', 'Profili İncele' ),
			'ortak-uzman-kadro-ust'     => array( 'Uzmanlarımız sayfası: liste üst yazısı', 'Kadromuz' ),
			'ortak-uzman-kadro'         => array( 'Uzmanlarımız sayfası: liste başlığı', 'Uzmanlarımız' ),
			'ortak-uzman-bos-baslik'    => array( 'Uzmanlarımız sayfası: kart yokken başlık', 'Ekibimiz Büyüyor' ),
			'ortak-uzman-bos-metin'     => array( 'Uzmanlarımız sayfası: kart yokken metin', 'Uzman kadromuz, açılış dönemiyle birlikte bu sayfada tanıtılacaktır.' ),
			'ortak-uzman-dugme'         => array( 'Uzman sayfası: başvuru düğmesi', 'Bilgi Al' ),
			'ortak-uzman-alanlar'       => array( 'Uzman sayfası: uzmanlık alanları başlığı', 'Uzmanlık Alanları' ),
			'ortak-uzman-egitim'        => array( 'Uzman sayfası: eğitim başlığı', 'Eğitim ve Sertifikalar' ),
			'ortak-uzman-hizmetler'     => array( 'Uzman sayfası: hizmetler başlığı', 'Yürüttüğü Hizmetler' ),
			'ortak-uzman-diger'         => array( 'Uzman sayfası: diğer uzmanlar başlığı', 'Diğer Uzmanlarımız' ),
			'ortak-uzman-tumu'          => array( 'Uzman sayfası: tüm ekip bağlantısı', 'Tüm Ekip' ),
		),
		'Kartlar'              => array(
			'ortak-kart-detay'          => array( 'Hizmet ve atölye kartlarındaki bağlantı', 'Detaylı Bilgi' ),
			'ortak-kart-grup-etiket'    => array( 'Hizmetler sayfası: grup kartlarının üst yazısı', 'Grup Programları' ),
			'ortak-kart-grup-baslik'    => array( 'Hizmetler sayfası: Oyun Grupları kartı başlığı', 'Oyun Grupları' ),
			'ortak-kart-grup-metin'     => array( 'Hizmetler sayfası: Oyun Grupları kartı metni', 'Yaş ve gelişim dönemine göre ayrıştırılmış, seans başına en fazla 6 çocukla yürütülen küçük grup programları.' ),
			'ortak-kart-atolye-baslik'  => array( 'Hizmetler sayfası: Tematik Atölyeler kartı başlığı', 'Tematik Atölyeler' ),
			'ortak-kart-atolye-metin'   => array( 'Hizmetler sayfası: Tematik Atölyeler kartı metni', 'Çocuk, ebeveyn ve çocuk-aile katılımlı; yaratıcılık, duygu ve birlikte üretim temalı atölye programları.' ),
			'ortak-kart-anasayfa-baslik' => array( 'Anasayfa: Oyun Grupları ve Atölyeler kartı başlığı', 'Oyun Grupları ve Atölyeler' ),
			'ortak-kart-anasayfa-metin' => array( 'Anasayfa: Oyun Grupları ve Atölyeler kartı metni', 'Yaş ve gelişim dönemine göre ayrıştırılmış, küçük gruplu programlar.' ),
		),
	);
	$liste = array();
	foreach ( $gruplar as $grup => $alanlar ) {
		foreach ( $alanlar as $kimlik => $alan ) {
			$liste[ $kimlik ] = array(
				'id'      => $kimlik,
				'tur'     => 'metin',
				'grup'    => $grup,
				'etiket'  => $alan[0],
				'v'       => $alan[1],
				'kontrol' => strlen( $alan[1] ) > 70 ? 'textarea' : 'text',
			);
		}
	}
	return $liste;
}

/* Kimlige gore alan tanimi */
function koi_alan_tanimi( $kimlik ) {
	static $dizin = null;
	if ( null === $dizin ) {
		$dizin = koi_ortak_alanlar();
		foreach ( koi_alan_verisi()['sayfalar'] as $sayfa ) {
			foreach ( $sayfa['bolumler'] as $bolum ) {
				foreach ( $bolum['alanlar'] as $alan ) {
					$dizin[ $alan['id'] ] = $alan;
				}
			}
		}
	}
	return isset( $dizin[ $kimlik ] ) ? $dizin[ $kimlik ] : null;
}

/* ---------- Degerler ---------- */

/* Panelden kaydedilmis ham deger ('' = kaydedilmemis) */
function koi_alan_ham( $kimlik ) {
	$kayitli = get_theme_mod( 'koi_alanlar', array() );
	if ( ! is_array( $kayitli ) || ! isset( $kayitli[ $kimlik ] ) || is_array( $kayitli[ $kimlik ] ) ) {
		return '';
	}
	return (string) $kayitli[ $kimlik ];
}

/* Gecerli metin: kaydedilen deger, bossa temadaki varsayilan */
function koi_alan_degeri( $kimlik ) {
	$deger = trim( koi_alan_ham( $kimlik ) );
	if ( '' === $deger ) {
		$alan  = koi_alan_tanimi( $kimlik );
		$deger = ( $alan && isset( $alan['v'] ) ) ? (string) $alan['v'] : '';
	}
	return $deger;
}

/* Paneldeki yazim bicimi -> HTML. Once kacislanir, sonra yalnizca su isaretler acilir:
   **kalin**, *italik*, yeni satir. Bu yuzden alanlara HTML yazilamaz. */
function koi_bicimle( $metin ) {
	$html = esc_html( (string) $metin );
	$html = preg_replace( '/\*\*(.+?)\*\*/u', '<strong>$1</strong>', $html );
	$html = preg_replace( '/\*(.+?)\*/u', '<em>$1</em>', $html );
	return str_replace( array( "\r\n", "\r", "\n" ), '<br>', (string) $html );
}

/* Ortak metin: sablonlarda echo ile kullanilir, kacislanmis HTML dondurur */
function koi_metin( $kimlik ) {
	return koi_bicimle( koi_alan_degeri( $kimlik ) );
}

/* ---------- Sablon cikti fonksiyonlari ---------- */

/* Ozellestir onizlemesinde alanin yerini isaretler (kalem simgesi ve canli guncelleme icin) */
function koi_isaret( $kimlik ) {
	if ( is_customize_preview() ) {
		echo ' data-koi-alan="' . esc_attr( $kimlik ) . '"';
	}
}

function koi_alan_parcasi( $kimlik ) {
	$alan = koi_alan_tanimi( $kimlik );
	if ( ! $alan ) {
		return '';
	}
	if ( 'liste' === $alan['tur'] ) {
		return koi_liste_parcasi( $alan );
	}
	if ( 'gorsel' === $alan['tur'] ) {
		return koi_gorsel_parcasi( $alan );
	}
	$html = koi_bicimle( koi_alan_degeri( $kimlik ) );
	/* Dugmelerdeki ok simgesi temadan gelir */
	if ( ! empty( $alan['ek'] ) ) {
		$html .= $alan['ek'];
	}
	return $html;
}

function koi_alan( $kimlik ) {
	echo koi_alan_parcasi( $kimlik ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- koi_bicimle ile kacislandi.
}

/* Her satir bir madde; madde kalibi temadan gelir */
function koi_liste_parcasi( $alan ) {
	$maddeler = array();
	foreach ( preg_split( '/\r\n|\r|\n/', koi_alan_degeri( $alan['id'] ) ) as $satir ) {
		$satir = trim( $satir );
		if ( '' !== $satir ) {
			$maddeler[] = str_replace( '§', koi_bicimle( $satir ), (string) $alan['sablon'] );
		}
	}
	return implode( "\n", $maddeler );
}

function koi_liste( $kimlik ) {
	koi_alan( $kimlik );
}

/* Gorsel alani: panelden secilen gorsel, yoksa temadaki gorsel */
function koi_gorsel_parcasi( $alan ) {
	$g      = $alan['g'];
	$isaret = is_customize_preview() ? ' data-koi-alan="' . esc_attr( $alan['id'] ) . '"' : '';
	$kimlik = absint( koi_alan_ham( $alan['id'] ) );

	if ( $kimlik && wp_attachment_is_image( $kimlik ) ) {
		$sinif = ' ' . preg_replace( '/\s+/', ' ', (string) $g['sinif'] ) . ' ';
		if ( false === strpos( $sinif, ' has-img ' ) ) {
			$sinif .= 'has-img ';
		}
		$img = wp_get_attachment_image(
			$kimlik,
			'full',
			false,
			array(
				'class'   => 'media__img',
				'loading' => 'lazy',
				'sizes'   => (string) $g['boyut'],
			)
		);
		return '<div class="' . esc_attr( trim( $sinif ) ) . '"' .
			( '' !== (string) $g['stil'] ? ' style="' . esc_attr( $g['stil'] ) . '"' : '' ) .
			' data-label="' . esc_attr( $g['etiket'] ) . '"' . $isaret . '>' . $img .
			( ! empty( $g['isaret'] ) ? '<svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg>' : '' ) .
			'</div>';
	}

	$html = str_replace( '{{V}}', esc_url( KOI_URI . '/assets/' ), (string) $g['html'] );
	if ( 0 === strpos( $html, '<div' ) ) {
		$html = '<div' . $isaret . substr( $html, 4 );
	}
	return $html;
}

function koi_gorsel( $kimlik ) {
	koi_alan( $kimlik );
}

/* ---------- Sayfalar ---------- */

/* Sablon anahtari ("index", "kvkk"...) -> WordPress sayfasi */
function koi_tema_sayfasi( $anahtar ) {
	if ( 'index' === $anahtar || 'blog' === $anahtar ) {
		$kimlik = (int) get_option( 'index' === $anahtar ? 'page_on_front' : 'page_for_posts' );
		return $kimlik ? get_post( $kimlik ) : null;
	}
	foreach ( koi_alan_verisi()['sayfalar'] as $sayfa ) {
		if ( $sayfa['anahtar'] === $anahtar && '' !== (string) $sayfa['slug'] ) {
			return get_page_by_path( $sayfa['slug'], OBJECT, 'page' );
		}
	}
	return null;
}

/* WordPress sayfasi -> sablon anahtari ('' = temanin sayfalarindan degil) */
function koi_sayfa_anahtari_bul( $post ) {
	if ( ! $post || 'page' !== $post->post_type ) {
		return '';
	}
	if ( (int) $post->ID === (int) get_option( 'page_on_front' ) ) {
		return 'index';
	}
	if ( (int) $post->ID === (int) get_option( 'page_for_posts' ) ) {
		return 'blog';
	}
	foreach ( koi_alan_verisi()['sayfalar'] as $sayfa ) {
		if ( ! in_array( $sayfa['anahtar'], array( 'index', 'blog', '404' ), true ) && $sayfa['slug'] === $post->post_name ) {
			return $sayfa['anahtar'];
		}
	}
	return '';
}

function koi_metin_sayfasi_mi( $anahtar ) {
	return isset( koi_alan_verisi()['metinler'][ $anahtar ] );
}

function koi_ozellestir_bolumu( $anahtar ) {
	return 'koi_sayfa_' . str_replace( '-', '_', $anahtar );
}

/* Bir sayfanin Ozellestir ekraninda acilacagi adres */
function koi_onizleme_adresi( $anahtar ) {
	if ( '404' === $anahtar ) {
		return home_url( user_trailingslashit( '/koi-bulunamadi-onizleme' ) );
	}
	$sayfa = koi_tema_sayfasi( $anahtar );
	return $sayfa ? get_permalink( $sayfa ) : koi_url( $anahtar );
}

/* Yasal metin sayfasinin govdesi: sayfa duzenleyicisinde yazilan metin, bossa temadaki taslak */
function koi_sayfa_metni( $anahtar ) {
	$sayfa  = is_page() ? get_queried_object() : koi_tema_sayfasi( $anahtar );
	$icerik = ( $sayfa instanceof WP_Post ) ? trim( (string) $sayfa->post_content ) : '';
	if ( '' === $icerik ) {
		$metinler = koi_alan_verisi()['metinler'];
		$icerik   = isset( $metinler[ $anahtar ] ) ? (string) $metinler[ $anahtar ] : '';
	}
	echo apply_filters( 'the_content', $icerik ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- the_content filtresinden gecti.
}

/* Yasal metin sayfalarinin govdesi bossa temadaki metin yazilir; boylece duzenleyici
   bos acilmaz. Sayfada temanin onceki bir surumunun metni degistirilmeden duruyorsa
   o da yenisiyle degistirilir. Panelden degistirilmis sayfaya dokunulmaz. */
function koi_metin_sayfalarini_doldur() {
	$veri = koi_alan_verisi();
	$sayi = 0;
	foreach ( $veri['metinler'] as $anahtar => $icerik ) {
		$sayfa = koi_tema_sayfasi( $anahtar );
		if ( ! $sayfa ) {
			continue;
		}
		$mevcut = trim( (string) $sayfa->post_content );
		$eski   = isset( $veri['eskiMetinler'][ $anahtar ] ) ? (array) $veri['eskiMetinler'][ $anahtar ] : array();
		if ( '' !== $mevcut && ( md5( $mevcut ) === md5( trim( (string) $icerik ) ) || ! in_array( md5( $mevcut ), $eski, true ) ) ) {
			continue;
		}
		/* Metin temadan gelir ve guvenilirdir; ziyaretci isteginde calisabildigi icin
		   kullanici yetkisine bagli HTML suzgeci bu yazma icin kapatilir. */
		$suzgec = (bool) has_filter( 'content_save_pre', 'wp_filter_post_kses' );
		if ( $suzgec ) {
			kses_remove_filters();
		}
		$sonuc = wp_update_post(
			wp_slash(
				array(
					'ID'           => $sayfa->ID,
					'post_content' => (string) $icerik,
				)
			),
			true
		);
		if ( $suzgec ) {
			kses_init_filters();
		}
		if ( ! is_wp_error( $sonuc ) && $sonuc ) {
			$sayi++;
		}
	}
	return $sayi;
}

/* 0.7.0 oncesinde sayfa ust basligi ve giris metni sayfa duzenleme ekranindaydi
   (koi_ust_baslik, koi_ust_giris). Bu degerler yeni alanlara bir kez tasinir. */
function koi_ust_metinlerini_tasi() {
	$kayitli = get_theme_mod( 'koi_alanlar', array() );
	if ( ! is_array( $kayitli ) ) {
		$kayitli = array();
	}
	$degisti = false;
	foreach ( koi_alan_verisi()['ust'] as $anahtar => $kimlikler ) {
		$sayfa = koi_tema_sayfasi( $anahtar );
		if ( ! $sayfa ) {
			continue;
		}
		foreach ( array( 'baslik', 'giris' ) as $alan ) {
			$deger = trim( (string) get_post_meta( $sayfa->ID, 'koi_ust_' . $alan, true ) );
			$hedef = isset( $kimlikler[ $alan ] ) ? (string) $kimlikler[ $alan ] : '';
			if ( '' !== $deger && '' !== $hedef && empty( $kayitli[ $hedef ] ) ) {
				$kayitli[ $hedef ] = sanitize_textarea_field( $deger );
				$degisti           = true;
			}
			delete_post_meta( $sayfa->ID, 'koi_ust_' . $alan );
		}
	}
	if ( $degisti ) {
		set_theme_mod( 'koi_alanlar', $kayitli );
	}
}

/* ---------- Sayfa duzenleme ekrani ----------
   Temanin tasarimli sayfalarinda yazi alani kullanilmaz (metinler Ozellestir'den gelir);
   bos bir duzenleyici yaniltici olacagi icin gizlenir. Yasal metin sayfalarinda kalir. */
function koi_tasarimli_sayfa_mi( $post ) {
	$anahtar = koi_sayfa_anahtari_bul( $post );
	return '' !== $anahtar && ! koi_metin_sayfasi_mi( $anahtar );
}

function koi_sayfa_duzenleyicisi( $kullan, $post ) {
	return ( $post instanceof WP_Post && koi_tasarimli_sayfa_mi( $post ) ) ? false : $kullan;
}
add_filter( 'use_block_editor_for_post', 'koi_sayfa_duzenleyicisi', 10, 2 );

function koi_sayfa_yazi_alanini_gizle() {
	$kimlik = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- yalnizca ekran duzeni.
	$post   = $kimlik ? get_post( $kimlik ) : null;
	if ( $post && koi_tasarimli_sayfa_mi( $post ) ) {
		remove_post_type_support( 'page', 'editor' );
	}
}
add_action( 'load-post.php', 'koi_sayfa_yazi_alanini_gizle' );

/* Sayfanin Ozellestir ekranindaki yeri */
function koi_sayfa_ozellestir_adresi( $post ) {
	$anahtar = koi_sayfa_anahtari_bul( $post );
	if ( '' === $anahtar ) {
		return '';
	}
	return add_query_arg(
		array(
			'url'                => rawurlencode( (string) get_permalink( $post ) ),
			'autofocus[section]' => koi_ozellestir_bolumu( $anahtar ),
			'return'             => rawurlencode( (string) get_edit_post_link( $post->ID, 'raw' ) ),
		),
		admin_url( 'customize.php' )
	);
}

/* ---------- Ozellestir ekrani ---------- */
function koi_gorsel_kimligi_temizle( $deger ) {
	$kimlik = absint( $deger );
	return ( $kimlik && wp_attachment_is_image( $kimlik ) ) ? $kimlik : '';
}

function koi_alan_ayari_ekle( $wp_customize, $alan, $bolum, $canli ) {
	$ayar = 'koi_alanlar[' . $alan['id'] . ']';

	if ( 'gorsel' === $alan['tur'] ) {
		$wp_customize->add_setting(
			$ayar,
			array(
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'default'           => '',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'koi_gorsel_kimligi_temizle',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				$ayar,
				array(
					'label'       => $alan['etiket'],
					'description' => 'Görsel seçilmezse temadaki temsili görsel kullanılır.',
					'section'     => $bolum,
					'mime_type'   => 'image',
				)
			)
		);
	} else {
		$varsayilan = (string) $alan['v'];
		$cok_satir  = 'textarea' === $alan['kontrol'];
		$wp_customize->add_setting(
			$ayar,
			array(
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'default'           => $varsayilan,
				'transport'         => $canli ? 'postMessage' : 'refresh',
				/* HTML kabul edilmez; bos birakilan alan temadaki ilk metne doner */
				'sanitize_callback' => function ( $deger ) use ( $varsayilan, $cok_satir ) {
					$deger = $cok_satir ? sanitize_textarea_field( (string) $deger ) : sanitize_text_field( (string) $deger );
					return '' === trim( $deger ) ? $varsayilan : $deger;
				},
			)
		);
		$wp_customize->add_control(
			$ayar,
			array(
				'label'       => $alan['etiket'],
				'description' => 'liste' === $alan['tur'] ? 'Her satıra bir madde.' : '',
				'section'     => $bolum,
				'type'        => $cok_satir ? 'textarea' : 'text',
			)
		);
	}

	if ( $canli ) {
		$wp_customize->selective_refresh->add_partial(
			$ayar,
			array(
				'selector'            => '[data-koi-alan="' . $alan['id'] . '"]',
				'settings'            => array( $ayar ),
				'container_inclusive' => 'gorsel' === $alan['tur'],
				'fallback_refresh'    => true,
				'render_callback'     => function () use ( $alan ) {
					return koi_alan_parcasi( $alan['id'] );
				},
			)
		);
	}
}

function koi_alanlar_ozellestir( $wp_customize ) {
	$veri = koi_alan_verisi();
	if ( empty( $veri['sayfalar'] ) ) {
		return;
	}

	if ( ! class_exists( 'KOI_Ara_Baslik_Kontrolu' ) ) {
		/* Alanlari bolum bolum ayiran baslik (ayari yoktur) */
		class KOI_Ara_Baslik_Kontrolu extends WP_Customize_Control {
			public $type = 'koi_ara_baslik';
			public function render_content() {
				echo '<h3 style="margin:18px 0 0;padding-top:14px;border-top:1px solid #c3c4c7;font-size:14px;line-height:1.4">' . esc_html( $this->label ) . '</h3>';
				if ( $this->description ) {
					echo '<p class="description">' . wp_kses_post( $this->description ) . '</p>';
				}
			}
		}
	}

	$wp_customize->add_panel(
		'koi_sayfa_icerikleri',
		array(
			'title'       => 'Sayfa İçerikleri',
			'priority'    => 5,
			'description' => '<p>Sayfalardaki metinleri ve görselleri buradan değiştirebilirsiniz. Bir sayfa seçtiğinizde sağdaki önizleme o sayfaya gider; önizlemede bir metnin yanındaki kalem simgesine tıklayınca ilgili alan açılır.</p>' .
				'<p><strong>Yazım:</strong> yeni satır için Enter; <code>*yıldız*</code> arasındaki yazı italik, <code>**çift yıldız**</code> arasındaki kalın görünür. Bir alanı tamamen silerseniz temadaki ilk metin geri gelir.</p>' .
				'<p>Değişiklikler "Yayımla" düğmesine basınca sitede görünür. Üst menü ve sayfa altı bu bölümden değişmez; iletişim bilgileri "KOI İletişim Bilgileri" bölümündedir.</p>',
		)
	);

	$oncelik = 0;
	foreach ( $veri['sayfalar'] as $sayfa ) {
		$bolum    = koi_ozellestir_bolumu( $sayfa['anahtar'] );
		$aciklama = '';
		if ( koi_metin_sayfasi_mi( $sayfa['anahtar'] ) ) {
			$wp_sayfa = koi_tema_sayfasi( $sayfa['anahtar'] );
			$aciklama = 'Metnin kendisi sayfa düzenleyicisinden değiştirilir' .
				( $wp_sayfa ? ': <a href="' . esc_url( (string) get_edit_post_link( $wp_sayfa->ID ) ) . '">' . esc_html( $sayfa['baslik'] ) . ' sayfasını düzenle</a>' : '' ) .
				'. Buradan sayfanın üstündeki başlık ve giriş metni ile yan kutular değişir.';
		} elseif ( '404' === $sayfa['anahtar'] ) {
			$aciklama = 'Sitede olmayan bir adrese girildiğinde görünen sayfa.';
		}
		$wp_customize->add_section(
			$bolum,
			array(
				'title'       => $sayfa['baslik'],
				'panel'       => 'koi_sayfa_icerikleri',
				'priority'    => $oncelik += 10,
				'description' => $aciklama,
			)
		);
		foreach ( $sayfa['bolumler'] as $b ) {
			$wp_customize->add_control(
				new KOI_Ara_Baslik_Kontrolu(
					$wp_customize,
					$bolum . '__' . $b['no'],
					array(
						'label'    => $b['baslik'],
						'section'  => $bolum,
						'settings' => array(),
					)
				)
			);
			foreach ( $b['alanlar'] as $alan ) {
				koi_alan_ayari_ekle( $wp_customize, $alan, $bolum, true );
			}
		}
	}

	/* Ortak metinler: birden cok sayfada gecer, degisince onizleme yenilenir */
	$wp_customize->add_section(
		'koi_ortak_metinler',
		array(
			'title'       => 'Ortak Metinler',
			'panel'       => 'koi_sayfa_icerikleri',
			'priority'    => $oncelik + 10,
			'description' => 'Hizmet, atölye, blog yazısı ve uzman sayfalarında ortak kullanılan başlıklar ve düğme yazıları. Her hizmetin, atölyenin ve uzmanın kendi metni ilgili kaydın düzenleme ekranındadır.',
		)
	);
	$grup = '';
	foreach ( koi_ortak_alanlar() as $alan ) {
		if ( $alan['grup'] !== $grup ) {
			$grup = $alan['grup'];
			$wp_customize->add_control(
				new KOI_Ara_Baslik_Kontrolu(
					$wp_customize,
					'koi_ortak__' . sanitize_key( $grup ),
					array(
						'label'    => $grup,
						'section'  => 'koi_ortak_metinler',
						'settings' => array(),
					)
				)
			);
		}
		koi_alan_ayari_ekle( $wp_customize, $alan, 'koi_ortak_metinler', false );
	}
}
add_action( 'customize_register', 'koi_alanlar_ozellestir' );

/* Bir sayfa bolumu acilinca onizleme o sayfaya gider */
function koi_ozellestir_betigi() {
	$adresler = array();
	foreach ( koi_alan_verisi()['sayfalar'] as $sayfa ) {
		$adresler[ koi_ozellestir_bolumu( $sayfa['anahtar'] ) ] = koi_onizleme_adresi( $sayfa['anahtar'] );
	}
	$hizmet = get_posts(
		array(
			'post_type'   => 'hizmet',
			'numberposts' => 1,
			'orderby'     => 'menu_order title',
			'order'       => 'ASC',
		)
	);
	if ( $hizmet ) {
		$adresler['koi_ortak_metinler'] = get_permalink( $hizmet[0] );
	}
	wp_enqueue_script( 'koi-ozellestir', KOI_URI . '/assets/js/ozellestir.js', array( 'customize-controls' ), koi_dosya_surumu( 'assets/js/ozellestir.js' ), true );
	wp_add_inline_script( 'koi-ozellestir', 'window.koiOnizlemeAdresleri = ' . wp_json_encode( $adresler ) . ';', 'before' );
}
add_action( 'customize_controls_enqueue_scripts', 'koi_ozellestir_betigi' );
