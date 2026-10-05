<?php
/**
 * Icerik turleri: Hizmetler ve Atolyeler. Blog yazilari WordPress'in kendi
 * "Yazilar" bolumunu kullanir.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function koi_icerik_turleri() {
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
}
add_action( 'init', 'koi_icerik_turleri' );

/* ---------- Ek alanlar ---------- */
function koi_ek_alanlar( $tur ) {
	$alanlar = array(
		'koi_lead' => array( 'Giriş metni', 'Başlığın yanında görünen 1–2 cümlelik özet.', 'textarea' ),
	);
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
	return $alanlar;
}

function koi_meta_kutulari() {
	foreach ( array( 'hizmet', 'atolye', 'post' ) as $tur ) {
		add_meta_box( 'koi_ayrintilar', 'KOI Sayfa Ayrıntıları', 'koi_meta_kutusu', $tur, 'normal', 'high' );
	}
}
add_action( 'add_meta_boxes', 'koi_meta_kutulari' );

function koi_meta_kutusu( $post ) {
	wp_nonce_field( 'koi_meta_kaydet', 'koi_meta_nonce' );
	foreach ( koi_ek_alanlar( $post->post_type ) as $anahtar => $alan ) {
		$deger = (string) get_post_meta( $post->ID, $anahtar, true );
		echo '<p><label for="' . esc_attr( $anahtar ) . '"><strong>' . esc_html( $alan[0] ) . '</strong></label><br>';
		if ( 'textarea' === $alan[2] ) {
			echo '<textarea class="widefat" rows="4" id="' . esc_attr( $anahtar ) . '" name="' . esc_attr( $anahtar ) . '">' . esc_textarea( $deger ) . '</textarea>';
		} else {
			echo '<input class="widefat" type="text" id="' . esc_attr( $anahtar ) . '" name="' . esc_attr( $anahtar ) . '" value="' . esc_attr( $deger ) . '">';
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
		if ( ! isset( $_POST[ $anahtar ] ) ) {
			continue;
		}
		$ham   = wp_unslash( $_POST[ $anahtar ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$deger = 'textarea' === $alan[2] ? sanitize_textarea_field( $ham ) : sanitize_text_field( $ham );
		if ( '' === $deger ) {
			delete_post_meta( $post_id, $anahtar );
		} else {
			update_post_meta( $post_id, $anahtar, $deger );
		}
	}
}
add_action( 'save_post', 'koi_meta_kaydet' );
