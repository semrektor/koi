<?php
/**
 * Icerik turleri: Hizmetler, Atolyeler, Uzmanlar ve Galeri. Blog yazilari
 * WordPress'in kendi "Yazilar" bolumunu kullanir.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function koi_icerik_turleri() {
	/* Kendi sayfasi olan turler */
	$ortak = array(
		'public'       => true,
		'show_in_rest' => true,
		'has_archive'  => false,
		'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
	);

	register_post_type(
		'hizmet',
		array_merge(
			$ortak,
			array(
				'labels'        => array(
					'name'          => 'Hizmetler',
					'singular_name' => 'Hizmet',
					'add_new_item'  => 'Yeni Hizmet Ekle',
					'edit_item'     => 'Hizmeti Düzenle',
					'all_items'     => 'Tüm Hizmetler',
					'search_items'  => 'Hizmet Ara',
				),
				'menu_icon'     => 'dashicons-heart',
				'menu_position' => 21,
				'rewrite'       => array(
					'slug'       => 'hizmetler',
					'with_front' => false,
				),
			)
		)
	);

	register_post_type(
		'atolye',
		array_merge(
			$ortak,
			array(
				'labels'        => array(
					'name'          => 'Atölyeler',
					'singular_name' => 'Atölye',
					'add_new_item'  => 'Yeni Atölye Ekle',
					'edit_item'     => 'Atölyeyi Düzenle',
					'all_items'     => 'Tüm Atölyeler',
					'search_items'  => 'Atölye Ara',
				),
				'menu_icon'     => 'dashicons-art',
				'menu_position' => 22,
				'rewrite'       => array(
					'slug'       => 'atolyeler',
					'with_front' => false,
				),
			)
		)
	);

	/* Kendi sayfasi olmayan, baska sayfalarin icinde listelenen turler */
	$liste = array(
		'public'              => false,
		'show_ui'             => true,
		'show_in_rest'        => true,
		'exclude_from_search' => true,
		'has_archive'         => false,
		'rewrite'             => false,
	);

	/* Uzmanlar hem Uzmanlarimiz sayfasinda listelenir hem de kendi sayfalari vardir
	   (/uzmanlarimiz/ad-soyad/); kartlar o sayfaya baglanir. */
	register_post_type(
		'uzman',
		array_merge(
			$liste,
			array(
				'public'        => true,
				'rewrite'       => array(
					'slug'       => 'uzmanlarimiz',
					'with_front' => false,
				),
				'labels'        => array(
					'name'                  => 'Uzmanlar',
					'singular_name'         => 'Uzman',
					'add_new'               => 'Yeni Ekle',
					'add_new_item'          => 'Yeni Uzman Ekle',
					'edit_item'             => 'Uzmanı Düzenle',
					'view_item'             => 'Uzmanın Sayfasını Gör',
					'all_items'             => 'Tüm Uzmanlar',
					'search_items'          => 'Uzman Ara',
					'featured_image'        => 'Portre fotoğrafı',
					'set_featured_image'    => 'Portre fotoğrafı seç',
					'remove_featured_image' => 'Portre fotoğrafını kaldır',
				),
				'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
				'menu_icon'     => 'dashicons-groups',
				'menu_position' => 23,
			)
		)
	);

	register_post_type(
		'galeri_gorsel',
		array_merge(
			$liste,
			array(
				'labels'        => array(
					'name'                  => 'Galeri',
					'singular_name'         => 'Galeri Görseli',
					'add_new'               => 'Yeni Ekle',
					'add_new_item'          => 'Yeni Görsel Ekle',
					'edit_item'             => 'Görseli Düzenle',
					'all_items'             => 'Tüm Görseller',
					'search_items'          => 'Görsel Ara',
					'featured_image'        => 'Fotoğraf',
					'set_featured_image'    => 'Fotoğraf seç',
					'remove_featured_image' => 'Fotoğrafı kaldır',
				),
				'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
				'menu_icon'     => 'dashicons-format-gallery',
				'menu_position' => 24,
			)
		)
	);

	register_post_type(
		'oyun_grubu',
		array_merge(
			$liste,
			array(
				'labels'        => array(
					'name'          => 'Oyun Grupları',
					'singular_name' => 'Oyun Grubu',
					'add_new'       => 'Yeni Ekle',
					'add_new_item'  => 'Yeni Grup Ekle',
					'edit_item'     => 'Grubu Düzenle',
					'all_items'     => 'Tüm Gruplar',
					'search_items'  => 'Grup Ara',
				),
				'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
				'menu_icon'     => 'dashicons-smiley',
				'menu_position' => 25,
			)
		)
	);

	register_post_type(
		'sss',
		array_merge(
			$liste,
			array(
				'labels'        => array(
					'name'          => 'Sık Sorulan Sorular',
					'singular_name' => 'Soru',
					'menu_name'     => 'Sık Sorulanlar',
					'add_new'       => 'Yeni Ekle',
					'add_new_item'  => 'Yeni Soru Ekle',
					'edit_item'     => 'Soruyu Düzenle',
					'all_items'     => 'Tüm Sorular',
					'search_items'  => 'Soru Ara',
				),
				'supports'      => array( 'title', 'editor', 'page-attributes' ),
				'menu_icon'     => 'dashicons-editor-help',
				'menu_position' => 26,
			)
		)
	);

	$taksonomi = array(
		'hierarchical'      => true,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => false,
	);
	register_taxonomy(
		'hizmet_kategori',
		'hizmet',
		array_merge(
			$taksonomi,
			array(
				'labels' => array(
					'name'          => 'Hizmet Kategorileri',
					'singular_name' => 'Hizmet Kategorisi',
				),
			)
		)
	);
	register_taxonomy(
		'atolye_turu',
		'atolye',
		array_merge(
			$taksonomi,
			array(
				'labels' => array(
					'name'          => 'Atölye Türleri',
					'singular_name' => 'Atölye Türü',
				),
			)
		)
	);
	register_taxonomy(
		'galeri_kategori',
		'galeri_gorsel',
		array_merge(
			$taksonomi,
			array(
				'labels' => array(
					'name'          => 'Galeri Kategorileri',
					'singular_name' => 'Galeri Kategorisi',
				),
			)
		)
	);
	register_taxonomy(
		'sss_bolum',
		'sss',
		array_merge(
			$taksonomi,
			array(
				'labels' => array(
					'name'          => 'Soru Bölümleri',
					'singular_name' => 'Soru Bölümü',
				),
			)
		)
	);
}
add_action( 'init', 'koi_icerik_turleri' );

/* Baslik alanindaki yonlendirici yazi */
function koi_baslik_ipucu( $metin, $post ) {
	if ( 'uzman' === $post->post_type ) {
		return 'Ad Soyad';
	}
	if ( 'galeri_gorsel' === $post->post_type ) {
		return 'Görselin kısa adı (örn. Oyun odası)';
	}
	if ( 'oyun_grubu' === $post->post_type ) {
		return 'Grubun adı (örn. Minik Adımlar)';
	}
	if ( 'sss' === $post->post_type ) {
		return 'Soru';
	}
	return $metin;
}
add_filter( 'enter_title_here', 'koi_baslik_ipucu', 10, 2 );

/* ---------- Ek alanlar ----------
   anahtar => [etiket, aciklama, tur]   tur: text | textarea | checkbox | hizmetler */
function koi_ek_alanlar( $tur ) {
	$alanlar = array();

	if ( in_array( $tur, array( 'hizmet', 'atolye', 'post' ), true ) ) {
		$alanlar['koi_lead'] = array( 'Giriş metni', 'Başlığın yanında görünen 1–2 cümlelik özet.', 'textarea' );
	}
	if ( 'hizmet' === $tur || 'atolye' === $tur ) {
		$alanlar['koi_etiket'] = array( 'Üst etiket', 'Başlığın üstünde görünür. Örn. "Çocuk Atölyesi · 4-7 Yaş". Boşsa kategori adı kullanılır.', 'text' );
		$alanlar['koi_bilgi']  = array( 'Kısa bilgi kutusu', 'Her satıra bir bilgi: "Yaş aralığı: 6 – 18 yaş"', 'textarea' );
	}
	if ( 'atolye' === $tur ) {
		$alanlar['koi_rozetler'] = array( 'Rozetler', 'Kartta görünen kısa etiketler, virgülle ayırın. Örn. "Cumartesi, 90 dk"', 'text' );
	}
	if ( 'post' === $tur ) {
		$alanlar['koi_yazar'] = array( 'Yazar adı', 'Yazıda görünecek ad. Boşsa kullanıcı adınız kullanılır.', 'text' );
	}
	if ( 'uzman' === $tur ) {
		$alanlar['koi_etiket']     = array( 'Üst etiket', 'Adın üstünde görünen kısa etiket. Örn. "Kurucu Ortak", "Uzman".', 'text' );
		$alanlar['koi_unvan']      = array( 'Unvan', 'Örn. "Psikolojik Danışman · Aile Danışmanı".', 'text' );
		$alanlar['koi_unvan_kisa'] = array( 'Kısa unvan', 'Kartlarda görünür. Boşsa unvan kullanılır.', 'text' );
		$alanlar['koi_kisa']       = array( 'Kısa tanıtım', 'Kartlarda ve uzmanın kendi sayfasının üstünde görünen bir cümlelik tanıtım.', 'textarea' );
		$alanlar['koi_genis']      = array( 'Geniş profil', 'Uzmanlarımız sayfasında fotoğraf ve biyografiyle geniş profil olarak göster. İşaretli değilse kart olarak listelenir; karta tıklayan ziyaretçi uzmanın kendi sayfasını görür.', 'checkbox' );
		$alanlar['koi_alanlar']    = array( 'Uzmanlık alanları', 'Uzmanın kendi sayfasında ve geniş profilde görünür.', 'textarea' );
		$alanlar['koi_egitim']     = array( 'Eğitim ve sertifikalar', 'Her satıra bir madde. Uzmanın kendi sayfasında ve geniş profilde liste olarak görünür.', 'textarea' );
		$alanlar['koi_hizmetler']  = array( 'Yürüttüğü hizmetler', 'Uzmanın kendi sayfasında ve geniş profilde bağlantı olarak görünür.', 'hizmetler' );
	}
	if ( 'oyun_grubu' === $tur ) {
		$alanlar['koi_yas']       = array( 'Yaş aralığı', 'Kartta, tabloda ve başvuru formunda görünür. Örn. "1–2 yaş".', 'text' );
		$alanlar['koi_kisa']      = array( 'Kısa açıklama', 'Kartta görünen bir cümlelik tanıtım.', 'textarea' );
		$alanlar['koi_gun_saat']  = array( 'Gün ve saat', 'Program tablosunda görünür. Örn. "Pazartesi ve Çarşamba 10:00".', 'text' );
		$alanlar['koi_kontenjan'] = array( 'Kontenjan', 'Örn. "En fazla 6 çocuk".', 'text' );
		$alanlar['koi_ebeveyn']   = array( 'Ebeveyn katılımı', 'Örn. "Ebeveyn katılımlı" ya da "Programın niteliğine göre".', 'text' );
	}
	if ( 'sss' === $tur ) {
		$alanlar['koi_sss_hizmetler'] = array( 'Hizmetler sayfasında da göster', 'Soru, Hizmetler sayfasının altındaki kısa listede de yer alır.', 'checkbox' );
		$alanlar['koi_sss_iletisim']  = array( 'İletişim sayfasında da göster', 'Soru, İletişim sayfasının altındaki kısa listede de yer alır.', 'checkbox' );
	}
	return $alanlar;
}

/* Sitede "Sira" degerine gore dizilen turler (kucuk sayi once) */
function koi_sirali_turler() {
	return array( 'hizmet', 'atolye', 'uzman', 'galeri_gorsel', 'oyun_grubu', 'sss' );
}

/* Yeni kayit listenin sonuna gelsin diye onerilen sira: en buyuk sira + 1 */
function koi_sonraki_sira( $tur ) {
	global $wpdb;
	$en_buyuk = $wpdb->get_var( $wpdb->prepare( "SELECT MAX(menu_order) FROM {$wpdb->posts} WHERE post_type = %s AND post_status = 'publish'", $tur ) );
	return null === $en_buyuk ? 0 : (int) $en_buyuk + 1;
}

function koi_meta_kutulari() {
	foreach ( array( 'hizmet', 'atolye', 'post', 'uzman', 'galeri_gorsel', 'oyun_grubu', 'sss', 'page' ) as $tur ) {
		add_meta_box( 'koi_ayrintilar', 'KOI Sayfa Ayrıntıları', 'koi_meta_kutusu', $tur, 'normal', 'high' );
	}
}
add_action( 'add_meta_boxes', 'koi_meta_kutulari' );

function koi_meta_kutusu( $post ) {
	wp_nonce_field( 'koi_meta_kaydet', 'koi_meta_nonce' );
	if ( 'uzman' === $post->post_type ) {
		echo '<p class="description">Biyografiyi yukarıdaki yazı alanına, portre fotoğrafını sağdaki "Portre fotoğrafı" kutusuna ekleyin. Fotoğraf yoksa baş harfler gösterilir. Her uzmanın kendi sayfası vardır: sitedeki kartına tıklanınca biyografi, uzmanlık alanları, eğitim ve yürüttüğü hizmetler o sayfada açılır.</p>';
	}
	if ( 'oyun_grubu' === $post->post_type ) {
		echo '<p class="description">Grubun görselini sağdaki "Öne çıkan görsel" kutusundan ekleyin; eklenmezse temsili görsel kullanılır.</p>';
	}
	if ( 'galeri_gorsel' === $post->post_type ) {
		echo '<p class="description">Fotoğrafı sağdaki "Fotoğraf" kutusundan ekleyin, kategorisini "Galeri Kategorileri" kutusundan seçin.</p>';
	}
	if ( 'sss' === $post->post_type ) {
		echo '<p class="description">Soruyu en üstteki başlık alanına, cevabı yazı alanına yazın. Sorunun SSS sayfasında hangi başlık altında görüneceğini sağdaki "Soru Bölümleri" kutusundan seçin.</p>';
	}

	/* Sayfalar: metinler ve gorseller Ozellestir ekranindan, canli onizlemeyle duzenlenir */
	if ( 'page' === $post->post_type ) {
		$adres = koi_sayfa_ozellestir_adresi( $post );
		if ( '' === $adres ) {
			echo '<p class="description">Bu sayfanın içeriği yukarıdaki düzenleyiciden gelir.</p>';
			return;
		}
		if ( koi_metin_sayfasi_mi( koi_sayfa_anahtari_bul( $post ) ) ) {
			echo '<p>Metnin kendisini yukarıdaki düzenleyicide değiştirin. Sayfanın en üstündeki başlık, giriş metni ve yan kutular canlı önizlemeyle Özelleştir ekranından düzenlenir.</p>';
		} else {
			echo '<p>Bu sayfanın metinleri ve görselleri canlı önizlemeyle Özelleştir ekranından düzenlenir. Önizlemede bir metnin yanındaki kalem simgesine tıklayınca ilgili alan açılır.</p>';
		}
		echo '<p><a class="button button-primary" href="' . esc_url( $adres ) . '">Sayfa metinlerini düzenle</a></p>';
		return;
	}
	foreach ( koi_ek_alanlar( $post->post_type ) as $anahtar => $alan ) {
		$deger = (string) get_post_meta( $post->ID, $anahtar, true );
		$kimlik = esc_attr( $anahtar );

		if ( 'checkbox' === $alan[2] ) {
			echo '<p><label><input type="checkbox" name="' . $kimlik . '" value="1"' . checked( '1', $deger, false ) . '> <strong>' . esc_html( $alan[0] ) . '</strong></label>';
			echo '<br><span class="description">' . esc_html( $alan[1] ) . '</span></p>';
			continue;
		}

		if ( 'hizmetler' === $alan[2] ) {
			$secili = array_filter( array_map( 'trim', explode( ',', $deger ) ) );
			echo '<p><strong>' . esc_html( $alan[0] ) . '</strong><br>';
			foreach ( koi_kayitlar( 'hizmet' ) as $hizmet ) {
				echo '<label style="display:block;margin:4px 0"><input type="checkbox" name="' . $kimlik . '[]" value="' . esc_attr( $hizmet->post_name ) . '"' . checked( in_array( $hizmet->post_name, $secili, true ), true, false ) . '> ' . esc_html( get_the_title( $hizmet ) ) . '</label>';
			}
			echo '<span class="description">' . esc_html( $alan[1] ) . '</span></p>';
			continue;
		}

		echo '<p><label for="' . $kimlik . '"><strong>' . esc_html( $alan[0] ) . '</strong></label><br>';
		if ( 'textarea' === $alan[2] ) {
			echo '<textarea class="widefat" rows="4" id="' . $kimlik . '" name="' . $kimlik . '">' . esc_textarea( $deger ) . '</textarea>';
		} else {
			echo '<input class="widefat" type="text" id="' . $kimlik . '" name="' . $kimlik . '" value="' . esc_attr( $deger ) . '">';
		}
		echo '<br><span class="description">' . esc_html( $alan[1] ) . '</span></p>';
	}

	/* Sira: kaydin sitedeki listede kacinci gorunecegi */
	if ( in_array( $post->post_type, koi_sirali_turler(), true ) ) {
		$sira = 'auto-draft' === $post->post_status ? koi_sonraki_sira( $post->post_type ) : (int) $post->menu_order;
		echo '<p><label for="koi_sira"><strong>Sıra</strong></label><br>';
		echo '<input type="number" min="0" step="1" style="width:90px" id="koi_sira" name="koi_sira" value="' . esc_attr( (string) $sira ) . '">';
		echo '<br><span class="description">Sitedeki listede kaçıncı görüneceği. Küçük sayı önce gelir (0 en başta); aynı sayıyı taşıyanlar ada göre dizilir.</span></p>';
	}
}

/* "Sira" alani kaydin menu_order degerine yazilir */
function koi_sira_kaydet( $veri, $gelen ) {
	if ( ! isset( $_POST['koi_sira'], $_POST['koi_meta_nonce'], $_POST['post_ID'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['koi_meta_nonce'] ) ), 'koi_meta_kaydet' ) ) {
		return $veri;
	}
	/* Yalnizca duzenlenen kaydin kendisi; ayni istekte kaydedilen baska kayitlar degil */
	if ( empty( $gelen['ID'] ) || (int) $gelen['ID'] !== (int) $_POST['post_ID'] || ! in_array( $veri['post_type'], koi_sirali_turler(), true ) ) {
		return $veri;
	}
	$veri['menu_order'] = max( 0, (int) wp_unslash( $_POST['koi_sira'] ) );
	return $veri;
}
add_filter( 'wp_insert_post_data', 'koi_sira_kaydet', 10, 2 );

function koi_meta_kaydet( $post_id ) {
	if ( ! isset( $_POST['koi_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['koi_meta_nonce'] ) ), 'koi_meta_kaydet' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( koi_ek_alanlar( get_post_type( $post_id ) ) as $anahtar => $alan ) {
		/* Isaret kutulari isaretsizken hic gonderilmez; bos sayilir */
		if ( 'checkbox' === $alan[2] ) {
			$deger = empty( $_POST[ $anahtar ] ) ? '' : '1';
		} elseif ( 'hizmetler' === $alan[2] ) {
			$secili = isset( $_POST[ $anahtar ] ) ? (array) wp_unslash( $_POST[ $anahtar ] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$deger  = implode( ',', array_filter( array_map( 'sanitize_title', $secili ) ) );
		} else {
			if ( ! isset( $_POST[ $anahtar ] ) ) {
				continue;
			}
			$ham   = wp_unslash( $_POST[ $anahtar ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$deger = 'textarea' === $alan[2] ? sanitize_textarea_field( $ham ) : sanitize_text_field( $ham );
		}
		if ( '' === $deger ) {
			delete_post_meta( $post_id, $anahtar );
		} else {
			update_post_meta( $post_id, $anahtar, $deger );
		}
	}
}
add_action( 'save_post', 'koi_meta_kaydet' );

/* ---------- Liste ekranlarinda kucuk gorsel ---------- */
function koi_gorsel_sutunu( $sutunlar ) {
	$yeni = array();
	foreach ( $sutunlar as $anahtar => $baslik ) {
		$yeni[ $anahtar ] = $baslik;
		if ( 'cb' === $anahtar ) {
			$yeni['koi_gorsel'] = 'Görsel';
		}
	}
	return $yeni;
}
add_filter( 'manage_galeri_gorsel_posts_columns', 'koi_gorsel_sutunu' );
add_filter( 'manage_uzman_posts_columns', 'koi_gorsel_sutunu' );

function koi_gorsel_sutunu_icerigi( $sutun, $post_id ) {
	if ( 'koi_gorsel' !== $sutun ) {
		return;
	}
	if ( has_post_thumbnail( $post_id ) ) {
		echo get_the_post_thumbnail( $post_id, array( 64, 64 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} elseif ( 'uzman' === get_post_type( $post_id ) ) {
		echo esc_html( koi_bas_harfler( get_the_title( $post_id ) ) );
	} else {
		echo '<span class="description">Temsili görsel</span>';
	}
}
add_action( 'manage_galeri_gorsel_posts_custom_column', 'koi_gorsel_sutunu_icerigi', 10, 2 );
add_action( 'manage_uzman_posts_custom_column', 'koi_gorsel_sutunu_icerigi', 10, 2 );

/* ---------- Liste ekranlarinda sira ----------
   Sirali turlerin listesi sitedeki sirayla gelir ve "Sira" sutunu gosterir. */
function koi_sira_sutunu( $sutunlar ) {
	$yeni = array();
	foreach ( $sutunlar as $anahtar => $baslik ) {
		if ( 'date' === $anahtar ) {
			$yeni['koi_sira'] = 'Sıra';
		}
		$yeni[ $anahtar ] = $baslik;
	}
	if ( ! isset( $yeni['koi_sira'] ) ) {
		$yeni['koi_sira'] = 'Sıra';
	}
	return $yeni;
}

function koi_sira_sutunu_icerigi( $sutun, $post_id ) {
	if ( 'koi_sira' === $sutun ) {
		echo (int) get_post_field( 'menu_order', $post_id );
	}
}

foreach ( koi_sirali_turler() as $koi_tur ) {
	add_filter( 'manage_' . $koi_tur . '_posts_columns', 'koi_sira_sutunu' );
	add_action( 'manage_' . $koi_tur . '_posts_custom_column', 'koi_sira_sutunu_icerigi', 10, 2 );
}
unset( $koi_tur );

function koi_liste_sirasi( $sorgu ) {
	if ( ! is_admin() || ! $sorgu->is_main_query() || $sorgu->get( 'orderby' ) ) {
		return;
	}
	if ( in_array( $sorgu->get( 'post_type' ), koi_sirali_turler(), true ) ) {
		$sorgu->set( 'orderby', 'menu_order title' );
		$sorgu->set( 'order', 'ASC' );
	}
}
add_action( 'pre_get_posts', 'koi_liste_sirasi' );
