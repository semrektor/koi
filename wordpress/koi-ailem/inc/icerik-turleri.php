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

	register_post_type(
		'uzman',
		array_merge(
			$liste,
			array(
				'labels'        => array(
					'name'                  => 'Uzmanlar',
					'singular_name'         => 'Uzman',
					'add_new'               => 'Yeni Ekle',
					'add_new_item'          => 'Yeni Uzman Ekle',
					'edit_item'             => 'Uzmanı Düzenle',
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
		$alanlar['koi_kisa']       = array( 'Kısa tanıtım', 'Kartlarda görünen bir cümlelik tanıtım.', 'textarea' );
		$alanlar['koi_genis']      = array( 'Geniş profil', 'Uzmanlarımız sayfasında fotoğraf ve biyografiyle geniş profil olarak göster. İşaretli değilse kart olarak listelenir.', 'checkbox' );
		$alanlar['koi_alanlar']    = array( 'Uzmanlık alanları', 'Geniş profilde görünür.', 'textarea' );
		$alanlar['koi_egitim']     = array( 'Eğitim ve sertifikalar', 'Her satıra bir madde. Geniş profilde liste olarak görünür.', 'textarea' );
		$alanlar['koi_hizmetler']  = array( 'Yürüttüğü hizmetler', 'Geniş profilde bağlantı olarak görünür.', 'hizmetler' );
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
	if ( 'page' === $tur ) {
		$alanlar['koi_ust_baslik'] = array( 'Sayfa başlığı', 'Sayfanın en üstündeki büyük başlık. Alt satıra geçmek için Enter kullanın.', 'textarea' );
		$alanlar['koi_ust_giris']  = array( 'Giriş metni', 'Başlığın yanındaki 1–2 cümlelik giriş.', 'textarea' );
	}
	return $alanlar;
}

function koi_meta_kutulari() {
	foreach ( array( 'hizmet', 'atolye', 'post', 'uzman', 'oyun_grubu', 'sss', 'page' ) as $tur ) {
		add_meta_box( 'koi_ayrintilar', 'KOI Sayfa Ayrıntıları', 'koi_meta_kutusu', $tur, 'normal', 'high' );
	}
}
add_action( 'add_meta_boxes', 'koi_meta_kutulari' );

function koi_meta_kutusu( $post ) {
	wp_nonce_field( 'koi_meta_kaydet', 'koi_meta_nonce' );
	if ( 'uzman' === $post->post_type ) {
		echo '<p class="description">Biyografiyi yukarıdaki yazı alanına, portre fotoğrafını sağdaki "Portre fotoğrafı" kutusuna ekleyin. Fotoğraf yoksa baş harfler gösterilir. Sıralama için sağdaki "Sıra" alanını kullanın (küçük sayı önce görünür).</p>';
	}
	if ( 'oyun_grubu' === $post->post_type ) {
		echo '<p class="description">Grubun görselini sağdaki "Öne çıkan görsel" kutusundan ekleyin; eklenmezse temsili görsel kullanılır. Sıralama için sağdaki "Sıra" alanını kullanın.</p>';
	}
	if ( 'sss' === $post->post_type ) {
		echo '<p class="description">Soruyu en üstteki başlık alanına, cevabı yazı alanına yazın. Sorunun SSS sayfasında hangi başlık altında görüneceğini sağdaki "Soru Bölümleri" kutusundan seçin.</p>';
	}

	/* Sayfalar: ust bolumdeki baslik ve giris metni. Varsayilan metin gri olarak gosterilir. */
	$ipucu = array();
	if ( 'page' === $post->post_type ) {
		$ipucu = koi_sayfa_ust_varsayilani( $post->post_name );
		if ( ! $ipucu ) {
			echo '<p class="description">Bu sayfanın metinleri temadan gelir; burada değiştirilecek bir alan yok.</p>';
			return;
		}
		echo '<p class="description">Sayfanın en üstündeki başlık ve giriş metni. Boş bıraktığınız alanda, gri görünen varsayılan metin kullanılır.</p>';
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
			$alan_adi   = str_replace( 'koi_ust_', '', $anahtar );
			$yer_tutucu = isset( $ipucu[ $alan_adi ] ) ? (string) $ipucu[ $alan_adi ] : '';
			echo '<textarea class="widefat" rows="4" id="' . $kimlik . '" name="' . $kimlik . '" placeholder="' . esc_attr( $yer_tutucu ) . '">' . esc_textarea( $deger ) . '</textarea>';
		} else {
			echo '<input class="widefat" type="text" id="' . $kimlik . '" name="' . $kimlik . '" value="' . esc_attr( $deger ) . '">';
		}
		echo '<br><span class="description">' . esc_html( $alan[1] ) . '</span></p>';
	}
}

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
