<?php
/**
 * Kartlar, detay sayfalari ve ortak sablon parcalari.
 * HTML yapisi taslaktaki (build/generate-pages.js) yapiyla birebir aynidir.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function koi_ok() {
	return '<svg aria-hidden="true"><use href="#i-arrow"></use></svg>';
}

/* ---------- Gorseller ---------- */

/* Tema ile gelen temsili gorseller: ad => [genislik, alt metni] */
function koi_tema_gorselleri() {
	return array(
		'karsilama'   => array( 2200, 'KOI merkezinin karşılama alanı' ),
		'hero-kemer'  => array( 1400, 'KOI merkezinde kemerli dinlenme alanı' ),
		'oyun-odasi'  => array( 2200, 'KOI oyun grubu odası' ),
		'danismanlik' => array( 1400, 'KOI danışmanlık odası' ),
		'atolye-masa' => array( 2200, 'KOI atölye çalışma masası' ),
		'blog-masa'   => array( 2200, 'Defter, kalem ve çay ile çalışma masası' ),
		'yaprak'      => array( 2200, 'Duvara vuran yaprak gölgeleri' ),
	);
}

function koi_tema_gorseli( $ad ) {
	$liste = koi_tema_gorselleri();
	if ( ! isset( $liste[ $ad ] ) ) {
		$ad = 'atolye-masa';
	}
	$taban = KOI_URI . '/assets/img/' . $ad;
	return '<img class="media__img" src="' . esc_url( $taban . '.jpg' ) . '"' .
		' srcset="' . esc_url( $taban . '-sm.jpg' ) . ' 900w, ' . esc_url( $taban . '.jpg' ) . ' ' . (int) $liste[ $ad ][0] . 'w"' .
		' sizes="(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw"' .
		' alt="' . esc_attr( $liste[ $ad ][1] ) . '" loading="lazy">';
}

/* One cikan gorsel varsa onu, yoksa tema gorselini kullanir */
function koi_medya( $post_id, $sinif, $etiket = 'Görsel', $boyut = 'large' ) {
	if ( $post_id && has_post_thumbnail( $post_id ) ) {
		$img = get_the_post_thumbnail(
			$post_id,
			$boyut,
			array(
				'class'   => 'media__img',
				'loading' => 'lazy',
				'sizes'   => '(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw',
			)
		);
	} else {
		$img = koi_tema_gorseli( $post_id ? (string) get_post_meta( $post_id, 'koi_gorsel', true ) : '' );
	}
	return '<div class="media ' . esc_attr( $sinif ) . ' has-img" data-label="' . esc_attr( $etiket ) . '">' . $img . '</div>';
}

function koi_statik_medya( $ad, $sinif, $etiket = 'Görsel' ) {
	return '<div class="media ' . esc_attr( $sinif ) . ' has-img" data-label="' . esc_attr( $etiket ) . '">' . koi_tema_gorseli( $ad ) . '</div>';
}

/* ---------- Kucuk yardimcilar ---------- */
function koi_taksonomi( $tur ) {
	$harita = array(
		'hizmet' => 'hizmet_kategori',
		'atolye' => 'atolye_turu',
		'galeri_gorsel' => 'galeri_kategori',
		'sss' => 'sss_bolum',
		'post'   => 'category',
	);
	return isset( $harita[ $tur ] ) ? $harita[ $tur ] : '';
}

function koi_ilk_terim( $post ) {
	$taksonomi = koi_taksonomi( $post->post_type );
	if ( ! $taksonomi ) {
		return null;
	}
	$terimler = get_the_terms( $post, $taksonomi );
	return ( is_array( $terimler ) && $terimler ) ? reset( $terimler ) : null;
}

/* Kartin ve sayfanin ustundeki kucuk etiket */
function koi_etiket( $post ) {
	$etiket = (string) get_post_meta( $post->ID, 'koi_etiket', true );
	if ( '' !== $etiket ) {
		return $etiket;
	}
	$terim = koi_ilk_terim( $post );
	return $terim ? $terim->name : '';
}

function koi_filtre_anahtari( $post ) {
	$terim = koi_ilk_terim( $post );
	return $terim ? $terim->slug : '';
}

function koi_ozet( $post ) {
	return trim( wp_strip_all_tags( get_the_excerpt( $post ) ) );
}

function koi_okuma_suresi( $post ) {
	$metin   = trim( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ) );
	$kelime  = '' === $metin ? 0 : count( preg_split( '/\s+/u', $metin ) );
	$dakika  = max( 1, (int) ceil( $kelime / 200 ) );
	return $dakika . ' dk';
}

function koi_yazar_adi( $post ) {
	$ad = (string) get_post_meta( $post->ID, 'koi_yazar', true );
	return '' !== $ad ? $ad : get_the_author_meta( 'display_name', (int) $post->post_author );
}

function koi_kayitlar( $tur ) {
	return get_posts(
		array(
			'post_type'        => $tur,
			'post_status'      => 'publish',
			'numberposts'      => -1,
			'orderby'          => 'post' === $tur ? 'date' : 'menu_order title',
			'order'            => 'post' === $tur ? 'DESC' : 'ASC',
			'suppress_filters' => false,
		)
	);
}

/* One cikan yazi: sabitlenmis yazi varsa o, yoksa en yeni yazi */
function koi_one_cikan() {
	$sabit = get_option( 'sticky_posts' );
	if ( is_array( $sabit ) && $sabit ) {
		$liste = get_posts(
			array(
				'post__in'    => array_map( 'intval', $sabit ),
				'numberposts' => 1,
				'post_status' => 'publish',
			)
		);
		if ( $liste ) {
			return $liste[0];
		}
	}
	$liste = get_posts(
		array(
			'numberposts' => 1,
			'post_status' => 'publish',
		)
	);
	return $liste ? $liste[0] : null;
}

/* ---------- Kartlar ---------- */
function koi_kart( $post, $oran = 'media--ratio-3-2', $ust_etiket = true ) {
	$cikti  = '<article class="card reveal" data-cat="' . esc_attr( koi_filtre_anahtari( $post ) ) . '">';
	$cikti .= koi_medya( $post->ID, $oran );
	$cikti .= '<div class="card__body">';
	$etiket = $ust_etiket ? koi_etiket( $post ) : '';
	if ( '' !== $etiket ) {
		$cikti .= '<span class="card__meta">' . esc_html( $etiket ) . '</span>';
	}
	$cikti .= '<h3 class="card__title">' . esc_html( get_the_title( $post ) ) . '</h3>';
	$ozet   = koi_ozet( $post );
	if ( '' !== $ozet ) {
		$cikti .= '<p class="card__text">' . esc_html( $ozet ) . '</p>';
	}
	if ( 'atolye' === $post->post_type ) {
		$rozetler = array_filter( array_map( 'trim', explode( ',', (string) get_post_meta( $post->ID, 'koi_rozetler', true ) ) ) );
		if ( $rozetler ) {
			$cikti .= '<div style="display:flex;gap:8px;flex-wrap:wrap">';
			$sira   = 0;
			foreach ( $rozetler as $rozet ) {
				$cikti .= '<span class="badge' . ( $sira ? ' badge--olive' : '' ) . '">' . esc_html( $rozet ) . '</span>';
				$sira++;
			}
			$cikti .= '</div>';
		}
	}
	$cikti .= '<a class="link-arrow card__foot" href="' . esc_url( get_permalink( $post ) ) . '">' . koi_metin( 'ortak-kart-detay' ) . koi_ok() . '</a>';
	$cikti .= '</div></article>';
	return $cikti;
}

function koi_statik_kart( $baslik, $metin, $gorsel, $adres, $oran = 'media--ratio-3-2', $etiket = '', $filtre = '' ) {
	$cikti  = '<article class="card reveal"' . ( $filtre ? ' data-cat="' . esc_attr( $filtre ) . '"' : '' ) . '>';
	$cikti .= koi_statik_medya( $gorsel, $oran );
	$cikti .= '<div class="card__body">';
	if ( '' !== $etiket ) {
		$cikti .= '<span class="card__meta">' . koi_bicimle( $etiket ) . '</span>';
	}
	$cikti .= '<h3 class="card__title">' . koi_bicimle( $baslik ) . '</h3>';
	$cikti .= '<p class="card__text">' . koi_bicimle( $metin ) . '</p>';
	$cikti .= '<a class="link-arrow card__foot" href="' . esc_url( $adres ) . '">' . koi_metin( 'ortak-kart-detay' ) . koi_ok() . '</a>';
	$cikti .= '</div></article>';
	return $cikti;
}

function koi_yazi_karti( $post, $okuma_eki = false ) {
	$terim  = koi_ilk_terim( $post );
	$cikti  = '<article class="post reveal" data-cat="' . esc_attr( $terim ? $terim->slug : '' ) . '">';
	$cikti .= koi_medya( $post->ID, 'media--ratio-3-2', 'Kapak görseli' );
	$cikti .= '<div class="post__meta">';
	if ( $terim ) {
		$cikti .= '<span>' . esc_html( $terim->name ) . '</span><span>·</span>';
	}
	$cikti .= '<span>' . esc_html( koi_okuma_suresi( $post ) . ( $okuma_eki ? ' okuma' : '' ) ) . '</span></div>';
	$cikti .= '<h3 class="post__title">' . esc_html( get_the_title( $post ) ) . '</h3>';
	$cikti .= '<p class="post__excerpt">' . esc_html( koi_ozet( $post ) ) . '</p>';
	$cikti .= '<a class="link-arrow" href="' . esc_url( get_permalink( $post ) ) . '">' . koi_metin( 'ortak-blog-oku' ) . koi_ok() . '</a>';
	$cikti .= '</article>';
	return $cikti;
}

/* Sayfa govdelerindeki kart bloklari (taslaktaki CARDS isaretcilerinin karsiligi) */
function koi_kartlar( $kimlik ) {
	$cikti = '';
	switch ( $kimlik ) {
		case 'hizmet-listesi':
			foreach ( koi_kayitlar( 'hizmet' ) as $kayit ) {
				$cikti .= koi_kart( $kayit );
			}
			$cikti .= koi_statik_kart( koi_alan_degeri( 'ortak-kart-grup-baslik' ), koi_alan_degeri( 'ortak-kart-grup-metin' ), 'oyun-odasi', koi_url( 'oyun-gruplari' ), 'media--ratio-3-2', koi_alan_degeri( 'ortak-kart-grup-etiket' ), 'grup' );
			$cikti .= koi_statik_kart( koi_alan_degeri( 'ortak-kart-atolye-baslik' ), koi_alan_degeri( 'ortak-kart-atolye-metin' ), 'atolye-masa', koi_url( 'atolyeler' ), 'media--ratio-3-2', koi_alan_degeri( 'ortak-kart-grup-etiket' ), 'grup' );
			break;

		case 'atolye-listesi':
			foreach ( koi_kayitlar( 'atolye' ) as $kayit ) {
				$cikti .= koi_kart( $kayit );
			}
			break;

		case 'blog-listesi':
			$one_cikan = koi_one_cikan();
			foreach ( koi_kayitlar( 'post' ) as $kayit ) {
				if ( $one_cikan && $one_cikan->ID === $kayit->ID ) {
					continue;
				}
				$cikti .= koi_yazi_karti( $kayit );
			}
			break;

		case 'hizmet-kartlari':
			/* Anasayfa: dort hizmet + ortada oyun gruplari karti */
			$hizmetler = array_slice( koi_kayitlar( 'hizmet' ), 0, 4 );
			$sira      = 0;
			foreach ( $hizmetler as $kayit ) {
				if ( 2 === $sira ) {
					$cikti .= koi_statik_kart( koi_alan_degeri( 'ortak-kart-anasayfa-baslik' ), koi_alan_degeri( 'ortak-kart-anasayfa-metin' ), 'oyun-odasi', koi_url( 'oyun-gruplari' ), 'media--ratio-4-5' );
				}
				$cikti .= koi_kart( $kayit, 'media--ratio-4-5', false );
				$sira++;
			}
			break;

		case 'grup-kartlari':
			$cikti .= koi_grup_kartlari();
			break;

		case 'grup-tablosu':
			$cikti .= koi_grup_tablosu();
			break;

		case 'grup-secenekleri':
			$cikti .= koi_secenek_etiketleri( koi_grup_secenek_listesi() );
			break;

		case 'konu-secenekleri':
			$cikti .= koi_secenek_etiketleri( koi_konu_secenek_listesi() );
			break;

		case 'atolye-tablosu':
			$cikti .= koi_atolye_tablosu();
			break;

		case 'sss-bolumleri':
			$cikti .= koi_sss_bolumleri();
			break;

		case 'sss-hizmetler':
			$cikti .= koi_akordeon( koi_sss_secili( 'hizmetler' ), true );
			break;

		case 'sss-iletisim':
			$cikti .= koi_akordeon( koi_sss_secili( 'iletisim' ), true );
			break;

		case 'uzman-kartlari':
			foreach ( array_slice( koi_kayitlar( 'uzman' ), 0, 4 ) as $kayit ) {
				$cikti .= koi_uzman_karti( $kayit );
			}
			break;

		case 'uzman-profilleri':
			koi_uzman_profilleri();
			return;

		case 'galeri-listesi':
			$cikti .= koi_galeri_ogeleri();
			break;

		case 'galeri-anasayfa':
			$cikti .= koi_galeri_ogeleri( 5 );
			break;

		case 'blog-kartlari':
			foreach ( array_slice( koi_kayitlar( 'post' ), 0, 3 ) as $kayit ) {
				$cikti .= koi_yazi_karti( $kayit, true );
			}
			break;
	}
	echo $cikti; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- parcalar uretilirken kacislandi.
}

/* Liste sayfalarindaki filtre dugmeleri: icerigi olan kategorilerden uretilir.
   Tek kategori varsa filtre gosterilmez. */
function koi_filtreler( $taksonomi, $hedef, $etiket ) {
	$terimler = get_terms(
		array(
			'taxonomy'   => $taksonomi,
			'hide_empty' => true,
		)
	);
	if ( is_wp_error( $terimler ) || count( $terimler ) < 2 ) {
		return;
	}
	echo '<div class="filters reveal" data-filter-group data-filter-target="' . esc_attr( $hedef ) . '" role="group" aria-label="' . esc_attr( $etiket ) . '">';
	echo '<button type="button" data-filter="all" class="is-active">Tümü</button>';
	foreach ( $terimler as $terim ) {
		echo '<button type="button" data-filter="' . esc_attr( $terim->slug ) . '">' . esc_html( $terim->name ) . '</button>';
	}
	echo '</div>';
}

function koi_blog_filtreleri() {
	koi_filtreler( 'category', '#blog-listesi', 'Kategori filtresi' );
}

/* ---------- Ekip ---------- */

/* Portre yokken gosterilen bas harfler: "Elif Bilsel" -> "EB" */
function koi_bas_harfler( $ad ) {
	$parcalar = preg_split( '/\s+/u', trim( (string) $ad ) );
	$parcalar = array_values( array_filter( (array) $parcalar, 'strlen' ) );
	if ( ! $parcalar ) {
		return 'KOI';
	}
	$harfler = mb_substr( $parcalar[0], 0, 1 );
	if ( count( $parcalar ) > 1 ) {
		$harfler .= mb_substr( $parcalar[ count( $parcalar ) - 1 ], 0, 1 );
	}
	return mb_strtoupper( $harfler );
}

/* Portre fotografi varsa onu, yoksa bas harfli alani basar */
function koi_portre( $uzman, $sinif, $etiket ) {
	if ( has_post_thumbnail( $uzman->ID ) ) {
		$img = get_the_post_thumbnail(
			$uzman->ID,
			'large',
			array(
				'class'   => 'media__img',
				'loading' => 'lazy',
				'alt'     => get_the_title( $uzman ),
				'sizes'   => '(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw',
			)
		);
		return '<div class="media ' . esc_attr( $sinif ) . ' has-img" data-label="' . esc_attr( $etiket ) . '">' . $img . '</div>';
	}
	return '<div class="media ' . esc_attr( $sinif ) . ' media--mono" data-label="' . esc_attr( $etiket ) . '" data-mono="' . esc_attr( koi_bas_harfler( get_the_title( $uzman ) ) ) . '"><svg class="media__mark" aria-hidden="true"><use href="#i-koi-leaf"></use></svg></div>';
}

function koi_uzman_karti( $uzman ) {
	$unvan = (string) get_post_meta( $uzman->ID, 'koi_unvan_kisa', true );
	if ( '' === $unvan ) {
		$unvan = (string) get_post_meta( $uzman->ID, 'koi_unvan', true );
	}
	$kisa   = (string) get_post_meta( $uzman->ID, 'koi_kisa', true );
	$cikti  = '<article class="expert reveal">';
	$cikti .= koi_portre( $uzman, 'media--ratio-3-4', koi_alan_degeri( 'ortak-uzman-kart-notu' ) );
	$cikti .= '<h3 class="expert__name"><a href="' . esc_url( get_permalink( $uzman ) ) . '">' . esc_html( get_the_title( $uzman ) ) . '</a></h3>';
	if ( '' !== $unvan ) {
		$cikti .= '<p class="expert__role">' . esc_html( $unvan ) . '</p>';
	}
	if ( '' !== $kisa ) {
		$cikti .= '<p class="expert__text">' . esc_html( $kisa ) . '</p>';
	}
	/* Baglanti adin uzerindedir ve kartin tamamini kaplar; bu satir yalnizca gorsel ipucu */
	$cikti .= '<span class="link-arrow" aria-hidden="true">' . koi_metin( 'ortak-uzman-profil' ) . koi_ok() . '</span>';
	return $cikti . '</article>';
}

/* Uzmanlik alanlari, egitim ve yuruttugu hizmetler; ardindan "Bilgi Al" dugmesi.
   $dugme false ise dugme yalnizca yuruttugu hizmet varsa gosterilir. */
function koi_uzman_ayrintilari( $uzman, $dugme = false ) {
	$alanlar   = (string) get_post_meta( $uzman->ID, 'koi_alanlar', true );
	$egitim    = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) get_post_meta( $uzman->ID, 'koi_egitim', true ) ) ) );
	$hizmetler = array();
	foreach ( array_filter( array_map( 'trim', explode( ',', (string) get_post_meta( $uzman->ID, 'koi_hizmetler', true ) ) ) ) as $adres ) {
		$hizmet = get_page_by_path( sanitize_title( $adres ), OBJECT, 'hizmet' );
		if ( $hizmet && 'publish' === $hizmet->post_status ) {
			$hizmetler[] = $hizmet;
		}
	}
	?>
			<?php if ( '' !== $alanlar || $egitim || $hizmetler ) : ?>
			<div class="prose">
				<?php if ( '' !== $alanlar ) : ?>
					<h3><?php echo koi_metin( 'ortak-uzman-alanlar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
					<p><?php echo esc_html( $alanlar ); ?></p>
				<?php endif; ?>
				<?php if ( $egitim ) : ?>
					<h3><?php echo koi_metin( 'ortak-uzman-egitim' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
					<ul>
						<?php foreach ( $egitim as $madde ) : ?>
							<li><?php echo esc_html( $madde ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<?php if ( $hizmetler ) : ?>
					<h3><?php echo koi_metin( 'ortak-uzman-hizmetler' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
					<ul>
						<?php foreach ( $hizmetler as $hizmet ) : ?>
							<li><a href="<?php echo esc_url( get_permalink( $hizmet ) ); ?>"><?php echo esc_html( get_the_title( $hizmet ) ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<?php if ( $dugme || $hizmetler ) : ?>
			<div style="margin-top:30px">
				<a class="btn btn--primary" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>"><?php echo koi_metin( 'ortak-uzman-dugme' ) . koi_ok(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>
			<?php endif; ?>
	<?php
}

/* Uzmanlarimiz sayfasi: genis profiller, ardindan diger uzmanlarin kartlari */
function koi_uzman_profilleri() {
	$genis = array();
	$diger = array();
	foreach ( koi_kayitlar( 'uzman' ) as $uzman ) {
		if ( '1' === (string) get_post_meta( $uzman->ID, 'koi_genis', true ) ) {
			$genis[] = $uzman;
		} else {
			$diger[] = $uzman;
		}
	}

	$sira = 0;
	foreach ( $genis as $uzman ) {
		$tek      = ( 1 === $sira % 2 );
		$etiket   = (string) get_post_meta( $uzman->ID, 'koi_etiket', true );
		$unvan    = (string) get_post_meta( $uzman->ID, 'koi_unvan', true );
		?>
<section class="section<?php echo $tek ? ' section--cream' : ''; ?>">
	<div class="container container--wide split<?php echo $tek ? ' split--reverse' : ''; ?>">
		<div class="split__media reveal">
			<?php echo koi_portre( $uzman, 'media--arch media--tall', koi_alan_degeri( 'ortak-uzman-portre-notu' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<div class="split__body reveal">
			<?php if ( '' !== $etiket ) : ?>
				<span class="eyebrow"><?php echo esc_html( $etiket ); ?></span>
			<?php endif; ?>
			<h2><?php echo esc_html( get_the_title( $uzman ) ); ?></h2>
			<?php if ( '' !== $unvan && $unvan !== $etiket ) : ?>
				<p class="expert__role" style="margin-bottom:20px"><?php echo esc_html( $unvan ); ?></p>
			<?php endif; ?>
			<?php echo apply_filters( 'the_content', $uzman->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- the_content filtresinden gecti. ?>
			<?php koi_uzman_ayrintilari( $uzman ); ?>
		</div>
	</div>
</section>
		<?php
		$sira++;
	}

	$krem = ( 1 === count( $genis ) % 2 ) ? ' section--cream' : '';
	echo '<section class="section' . esc_attr( $krem ) . '"><div class="container container--wide">';
	echo '<div class="section-head center reveal"><span class="eyebrow eyebrow--center">' . koi_metin( 'ortak-uzman-kadro-ust' ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	if ( $diger ) {
		echo '<h2>' . koi_metin( 'ortak-uzman-kadro' ) . '</h2></div><div class="cards cards--4">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		foreach ( $diger as $uzman ) {
			echo koi_uzman_karti( $uzman ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		echo '</div>';
	} else {
		echo '<h2>' . koi_metin( 'ortak-uzman-bos-baslik' ) . '</h2><p class="lead">' . koi_metin( 'ortak-uzman-bos-metin' ) . '</p></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '</div></section>';
}

/* ---------- Galeri ---------- */

/* Izgaradaki yerlesim ritmi (build/content/galeri.js icindeki "desen" ile ayni) */
function koi_galeri_deseni() {
	return array(
		'media--span2 media--row2',
		'',
		'media--olive',
		'media--olive',
		'',
		'',
		'media--olive media--row2',
		'media--span2',
		'',
		'',
		'media--olive',
		'media--span2',
	);
}

function koi_galeri_ogeleri( $adet = 0 ) {
	$desen = koi_galeri_deseni();
	$liste = koi_kayitlar( 'galeri_gorsel' );
	if ( $adet > 0 ) {
		$liste = array_slice( $liste, 0, $adet );
	}
	$cikti = '';
	$sira  = 0;
	foreach ( $liste as $gorsel ) {
		$baslik = get_the_title( $gorsel );
		if ( has_post_thumbnail( $gorsel->ID ) ) {
			$alt = (string) get_post_meta( get_post_thumbnail_id( $gorsel->ID ), '_wp_attachment_image_alt', true );
			$img = get_the_post_thumbnail(
				$gorsel->ID,
				'large',
				array(
					'class'   => 'media__img',
					'loading' => 'lazy',
					'alt'     => '' !== $alt ? $alt : $baslik,
					'sizes'   => '(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 45vw',
				)
			);
		} else {
			$img = koi_tema_gorseli( (string) get_post_meta( $gorsel->ID, 'koi_gorsel', true ) );
		}
		$sinif  = trim( 'media ' . $desen[ $sira % count( $desen ) ] ) . ' has-img';
		$cikti .= '<div class="' . esc_attr( $sinif ) . '" data-cat="' . esc_attr( koi_filtre_anahtari( $gorsel ) ) . '" data-label="' . esc_attr( $baslik ) . '">' . $img . '</div>';
		$sira++;
	}
	return $cikti;
}

/* Blog sayfasinin ustundeki one cikan yazi */
function koi_one_cikan_yazi() {
	$post = koi_one_cikan();
	if ( ! $post ) {
		return;
	}
	$terim = koi_ilk_terim( $post );
	$lead  = (string) get_post_meta( $post->ID, 'koi_lead', true );
	?>
	<article class="split reveal" style="align-items:center">
		<div class="split__media">
			<?php echo koi_medya( $post->ID, 'media--soft media--ratio-4-5', 'Öne çıkan yazı görseli' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<div class="split__body">
			<span class="eyebrow"><?php echo koi_metin( 'ortak-blog-one-cikan' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			<h2><?php echo esc_html( get_the_title( $post ) ); ?></h2>
			<div class="post__meta">
				<?php if ( $terim ) : ?>
					<span><?php echo esc_html( $terim->name ); ?></span><span>·</span>
				<?php endif; ?>
				<span><?php echo esc_html( koi_okuma_suresi( $post ) ); ?> okuma</span><span>·</span><span><?php echo esc_html( koi_yazar_adi( $post ) ); ?></span>
			</div>
			<p class="lead"><?php echo esc_html( '' !== $lead ? $lead : koi_ozet( $post ) ); ?></p>
			<div style="margin-top:26px">
				<a class="btn btn--primary" href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo koi_metin( 'ortak-blog-oku' ) . koi_ok(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>
		</div>
	</article>
	<?php
}

/* ---------- Detay sayfalari ---------- */

/* Icerikteki h2 basliklarina baglanti kimligi ekler; basliklari $basliklar'a yazar */
function koi_icerik( &$basliklar ) {
	$basliklar = array();
	$icerik    = apply_filters( 'the_content', get_the_content() );
	$icerik    = str_replace( ']]>', ']]&gt;', $icerik );
	return preg_replace_callback(
		'/<h2([^>]*)>(.*?)<\/h2>/is',
		function ( $e ) use ( &$basliklar ) {
			$metin = trim( wp_strip_all_tags( $e[2] ) );
			if ( preg_match( '/\sid="([^"]+)"/', $e[1], $var ) ) {
				$basliklar[ $var[1] ] = $metin;
				return $e[0];
			}
			$kimlik = sanitize_title( $metin );
			if ( '' === $kimlik ) {
				return $e[0];
			}
			$basliklar[ $kimlik ] = $metin;
			return '<h2' . $e[1] . ' id="' . esc_attr( $kimlik ) . '">' . $e[2] . '</h2>';
		},
		$icerik
	);
}

function koi_sayfa_yolu( $ust_baslik, $ust_adres, $baslik ) {
	echo '<nav class="breadcrumb" aria-label="Sayfa yolu">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">Anasayfa</a><span>/</span>';
	if ( $ust_baslik ) {
		echo '<a href="' . esc_url( $ust_adres ) . '">' . esc_html( $ust_baslik ) . '</a><span>/</span>';
	}
	echo '<span>' . esc_html( $baslik ) . '</span></nav>';
}

function koi_ilgili_kayitlar( $post ) {
	$liste = array();
	$ham   = array_filter( array_map( 'trim', explode( ',', (string) get_post_meta( $post->ID, 'koi_ilgili', true ) ) ) );
	foreach ( $ham as $satir ) {
		$parca = explode( ':', $satir, 2 );
		if ( 2 !== count( $parca ) || ! post_type_exists( $parca[0] ) ) {
			continue;
		}
		$kayit = get_page_by_path( sanitize_title( $parca[1] ), OBJECT, $parca[0] );
		if ( $kayit && 'publish' === $kayit->post_status ) {
			$liste[] = $kayit;
		}
	}
	if ( ! $liste ) {
		foreach ( koi_kayitlar( $post->post_type ) as $kayit ) {
			if ( $kayit->ID !== $post->ID ) {
				$liste[] = $kayit;
			}
		}
	}
	return array_slice( $liste, 0, 3 );
}

function koi_ilgili_kartlar( $post, $etiket, $baslik ) {
	$liste = koi_ilgili_kayitlar( $post );
	if ( ! $liste ) {
		return;
	}
	echo '<section class="section section--cream"><div class="container container--wide">';
	echo '<div class="section-head section-head--split reveal"><div>';
	echo '<span class="eyebrow">' . koi_bicimle( $etiket ) . '</span><h2>' . koi_bicimle( $baslik ) . '</h2>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- koi_bicimle kacislar.
	echo '</div></div><div class="cards cards--3">';
	foreach ( $liste as $kayit ) {
		echo koi_kart( $kayit, 'media--ratio-3-2', false ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '</div></div></section>';
}

/* Hizmet ve atolye detay sayfasi */
function koi_detay_sayfasi( $post ) {
	$tur       = $post->post_type;
	$hizmet    = ( 'hizmet' === $tur );
	$ust       = $hizmet ? array( 'Hizmetler', koi_url( 'hizmetler' ) ) : array( 'Atölyeler', koi_url( 'atolyeler' ) );
	$lead      = (string) get_post_meta( $post->ID, 'koi_lead', true );
	$etiket    = koi_etiket( $post );
	$basliklar = array();
	$icerik    = koi_icerik( $basliklar );

	$satirlar = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) get_post_meta( $post->ID, 'koi_bilgi', true ) ) as $satir ) {
		$parca = explode( ':', $satir, 2 );
		if ( 2 === count( $parca ) && '' !== trim( $parca[0] ) ) {
			$satirlar[] = array( trim( $parca[0] ), trim( $parca[1] ) );
		}
	}
	$digerleri = array();
	foreach ( koi_kayitlar( $tur ) as $kayit ) {
		if ( $kayit->ID !== $post->ID && count( $digerleri ) < 4 ) {
			$digerleri[] = $kayit;
		}
	}
	?>
<section class="page-hero">
	<div class="container container--wide page-hero__grid">
		<div>
			<?php koi_sayfa_yolu( $ust[0], $ust[1], get_the_title( $post ) ); ?>
			<?php if ( '' !== $etiket ) : ?>
				<span class="eyebrow"><?php echo esc_html( $etiket ); ?></span>
			<?php endif; ?>
			<h1><?php echo esc_html( get_the_title( $post ) ); ?></h1>
		</div>
		<p class="lead"><?php echo esc_html( '' !== $lead ? $lead : koi_ozet( $post ) ); ?></p>
	</div>
</section>

<section class="section section--tight">
	<div class="container container--wide">
		<?php echo koi_medya( $post->ID, 'media--ratio-16-9 reveal', 'Görsel', 'full' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</section>

<section class="section section--tight">
	<div class="container container--wide with-sidebar">
		<div class="prose reveal">
			<?php echo $icerik; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- the_content filtresinden gecti. ?>
		</div>

		<aside>
			<?php if ( $satirlar ) : ?>
			<div class="sidebar-card reveal">
				<h3><?php echo koi_metin( $hizmet ? 'ortak-hizmet-bilgi' : 'ortak-atolye-bilgi' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
				<ul>
					<?php foreach ( $satirlar as $satir ) : ?>
						<li><strong style="font-weight:400;color:var(--koi-olive)"><?php echo esc_html( $satir[0] ); ?>:</strong> <span class="muted"><?php echo esc_html( $satir[1] ); ?></span></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>

			<div class="sidebar-card sidebar-card--dark reveal">
				<h3><?php echo koi_metin( $hizmet ? 'ortak-hizmet-cta-baslik' : 'ortak-atolye-cta-baslik' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
				<p><?php echo koi_metin( $hizmet ? 'ortak-hizmet-cta-metin' : 'ortak-atolye-cta-metin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<div style="margin-top:20px;display:flex;flex-direction:column;gap:10px">
					<a class="btn btn--terra" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>"><?php echo koi_metin( $hizmet ? 'ortak-hizmet-cta-dugme' : 'ortak-atolye-cta-dugme' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo koi_ok(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--light" href="<?php echo esc_url( koi_wa_url() ); ?>">WhatsApp</a>
				</div>
			</div>

			<div class="sidebar-card reveal">
				<h3><?php echo koi_metin( $hizmet ? 'ortak-hizmet-diger' : 'ortak-atolye-diger' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
				<ul>
					<?php foreach ( $digerleri as $kayit ) : ?>
						<li><a href="<?php echo esc_url( get_permalink( $kayit ) ); ?>"><?php echo esc_html( get_the_title( $kayit ) ); ?></a></li>
					<?php endforeach; ?>
					<li><a href="<?php echo esc_url( $ust[1] ); ?>"><?php echo koi_metin( $hizmet ? 'ortak-hizmet-tumu' : 'ortak-atolye-tumu' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></li>
				</ul>
			</div>
		</aside>
	</div>
</section>

	<?php
	koi_ilgili_kartlar( $post, koi_alan_degeri( $hizmet ? 'ortak-hizmet-ilgili-ust' : 'ortak-atolye-ilgili-ust' ), koi_alan_degeri( $hizmet ? 'ortak-hizmet-ilgili' : 'ortak-atolye-ilgili' ) );
}

/* Blog yazisi sayfasi */
function koi_yazi_sayfasi( $post ) {
	$terim     = koi_ilk_terim( $post );
	$lead      = (string) get_post_meta( $post->ID, 'koi_lead', true );
	$basliklar = array();
	$icerik    = koi_icerik( $basliklar );
	$kategoriler = get_categories( array( 'hide_empty' => true ) );
	?>
<section class="page-hero">
	<div class="container container--wide page-hero__grid">
		<div>
			<?php koi_sayfa_yolu( 'Blog', koi_url( 'blog' ), get_the_title( $post ) ); ?>
			<?php if ( $terim ) : ?>
				<span class="eyebrow"><?php echo esc_html( $terim->name ); ?></span>
			<?php endif; ?>
			<h1><?php echo esc_html( get_the_title( $post ) ); ?></h1>
		</div>
		<div>
			<div class="post__meta" style="margin-bottom:14px"><span><?php echo esc_html( koi_yazar_adi( $post ) ); ?></span><span>·</span><span><?php echo esc_html( koi_okuma_suresi( $post ) ); ?> okuma</span></div>
			<p class="lead"><?php echo esc_html( '' !== $lead ? $lead : koi_ozet( $post ) ); ?></p>
		</div>
	</div>
</section>

<section class="section section--tight">
	<div class="container container--wide">
		<?php echo koi_medya( $post->ID, 'media--ratio-16-9 reveal', 'Kapak görseli', 'full' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</section>

<section class="section section--tight">
	<div class="container container--wide with-sidebar">
		<article class="prose reveal">
			<?php echo $icerik; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- the_content filtresinden gecti. ?>
		</article>

		<aside>
			<?php if ( $basliklar ) : ?>
			<div class="sidebar-card reveal">
				<h3><?php echo koi_metin( 'ortak-blog-icindekiler' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
				<ul>
					<?php foreach ( $basliklar as $kimlik => $metin ) : ?>
						<li><a href="#<?php echo esc_attr( $kimlik ); ?>"><?php echo esc_html( $metin ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>

			<div class="sidebar-card sidebar-card--dark reveal">
				<h3><?php echo koi_metin( 'ortak-blog-cta-baslik' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
				<p><?php echo koi_metin( 'ortak-blog-cta-metin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<div style="margin-top:20px;display:flex;flex-direction:column;gap:10px">
					<a class="btn btn--terra" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>"><?php echo koi_metin( 'ortak-blog-cta-dugme' ) . koi_ok(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--light" href="<?php echo esc_url( koi_wa_url() ); ?>">WhatsApp</a>
				</div>
			</div>

			<?php if ( $kategoriler ) : ?>
			<div class="sidebar-card reveal">
				<h3><?php echo koi_metin( 'ortak-blog-kategoriler' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
				<ul>
					<?php foreach ( $kategoriler as $kategori ) : ?>
						<li><a href="<?php echo esc_url( get_category_link( $kategori ) ); ?>"><?php echo esc_html( $kategori->name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>
		</aside>
	</div>
</section>

	<?php
	koi_ilgili_kartlar( $post, koi_alan_degeri( 'ortak-blog-ilgili-ust' ), koi_alan_degeri( 'ortak-blog-ilgili' ) );
}

/* Uzman sayfasi: kartina tiklaninca acilir */
function koi_uzman_sayfasi( $post ) {
	$etiket = (string) get_post_meta( $post->ID, 'koi_etiket', true );
	$unvan  = (string) get_post_meta( $post->ID, 'koi_unvan', true );
	$kisa   = (string) get_post_meta( $post->ID, 'koi_kisa', true );
	$diger  = array();
	foreach ( koi_kayitlar( 'uzman' ) as $kayit ) {
		if ( $kayit->ID !== $post->ID && count( $diger ) < 4 ) {
			$diger[] = $kayit;
		}
	}
	?>
<section class="page-hero">
	<div class="container container--wide page-hero__grid">
		<div>
			<?php koi_sayfa_yolu( 'Uzmanlarımız', koi_url( 'uzmanlarimiz' ), get_the_title( $post ) ); ?>
			<?php if ( '' !== $etiket ) : ?>
				<span class="eyebrow"><?php echo esc_html( $etiket ); ?></span>
			<?php endif; ?>
			<h1><?php echo esc_html( get_the_title( $post ) ); ?></h1>
		</div>
		<?php if ( '' !== $kisa ) : ?>
			<p class="lead"><?php echo esc_html( $kisa ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="section section--tight">
	<div class="container container--wide split">
		<div class="split__media reveal">
			<?php echo koi_portre( $post, 'media--arch media--tall', koi_alan_degeri( 'ortak-uzman-portre-notu' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<div class="split__body reveal">
			<?php if ( '' !== $unvan && $unvan !== $etiket ) : ?>
				<p class="expert__role" style="margin-bottom:20px"><?php echo esc_html( $unvan ); ?></p>
			<?php endif; ?>
			<?php echo apply_filters( 'the_content', $post->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- the_content filtresinden gecti. ?>
			<?php koi_uzman_ayrintilari( $post, true ); ?>
		</div>
	</div>
</section>

	<?php
	if ( ! $diger ) {
		return;
	}
	echo '<section class="section section--cream"><div class="container container--wide">';
	echo '<div class="section-head section-head--split reveal"><div>';
	echo '<span class="eyebrow">' . koi_metin( 'ortak-uzman-kadro-ust' ) . '</span><h2>' . koi_metin( 'ortak-uzman-diger' ) . '</h2></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '<a class="link-arrow" style="justify-self:end" href="' . esc_url( koi_url( 'uzmanlarimiz' ) ) . '">' . koi_metin( 'ortak-uzman-tumu' ) . koi_ok() . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '</div><div class="cards cards--4">';
	foreach ( $diger as $kayit ) {
		echo koi_uzman_karti( $kayit ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '</div></div></section>';
}

/* Sablonu olmayan sayfalar ve arsivler icin sade ust bolum */
function koi_sade_ust( $baslik, $aciklama = '' ) {
	?>
<section class="page-hero">
	<div class="container container--wide page-hero__grid">
		<div>
			<?php koi_sayfa_yolu( '', '', $baslik ); ?>
			<h1><?php echo esc_html( $baslik ); ?></h1>
		</div>
		<?php if ( '' !== $aciklama ) : ?>
			<p class="lead"><?php echo esc_html( $aciklama ); ?></p>
		<?php endif; ?>
	</div>
</section>
	<?php
}
