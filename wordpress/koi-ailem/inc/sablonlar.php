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
	$cikti .= '<a class="link-arrow card__foot" href="' . esc_url( get_permalink( $post ) ) . '">Detaylı Bilgi' . koi_ok() . '</a>';
	$cikti .= '</div></article>';
	return $cikti;
}

function koi_statik_kart( $baslik, $metin, $gorsel, $adres, $oran = 'media--ratio-3-2', $etiket = '', $filtre = '' ) {
	$cikti  = '<article class="card reveal"' . ( $filtre ? ' data-cat="' . esc_attr( $filtre ) . '"' : '' ) . '>';
	$cikti .= koi_statik_medya( $gorsel, $oran );
	$cikti .= '<div class="card__body">';
	if ( '' !== $etiket ) {
		$cikti .= '<span class="card__meta">' . esc_html( $etiket ) . '</span>';
	}
	$cikti .= '<h3 class="card__title">' . esc_html( $baslik ) . '</h3>';
	$cikti .= '<p class="card__text">' . esc_html( $metin ) . '</p>';
	$cikti .= '<a class="link-arrow card__foot" href="' . esc_url( $adres ) . '">Detaylı Bilgi' . koi_ok() . '</a>';
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
	$cikti .= '<a class="link-arrow" href="' . esc_url( get_permalink( $post ) ) . '">Yazıyı Oku' . koi_ok() . '</a>';
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
			$cikti .= koi_statik_kart( 'Oyun Grupları', 'Yaş ve gelişim dönemine göre ayrıştırılmış, seans başına en fazla 6 çocukla yürütülen küçük grup programları.', 'oyun-odasi', koi_url( 'oyun-gruplari' ), 'media--ratio-3-2', 'Grup Programları', 'grup' );
			$cikti .= koi_statik_kart( 'Tematik Atölyeler', 'Çocuk, ebeveyn ve çocuk-aile katılımlı; yaratıcılık, duygu ve birlikte üretim temalı atölye programları.', 'atolye-masa', koi_url( 'atolyeler' ), 'media--ratio-3-2', 'Grup Programları', 'grup' );
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
					$cikti .= koi_statik_kart( 'Oyun Grupları ve Atölyeler', 'Yaş ve gelişim dönemine göre ayrıştırılmış, küçük gruplu programlar.', 'oyun-odasi', koi_url( 'oyun-gruplari' ), 'media--ratio-4-5' );
				}
				$cikti .= koi_kart( $kayit, 'media--ratio-4-5', false );
				$sira++;
			}
			break;

		case 'blog-kartlari':
			foreach ( array_slice( koi_kayitlar( 'post' ), 0, 3 ) as $kayit ) {
				$cikti .= koi_yazi_karti( $kayit, true );
			}
			break;
	}
	echo $cikti; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- parcalar uretilirken kacislandi.
}

/* Blog sayfasindaki kategori filtresi: yazisi olan kategorilerden uretilir */
function koi_blog_filtreleri() {
	$kategoriler = get_categories( array( 'hide_empty' => true ) );
	if ( count( $kategoriler ) < 2 ) {
		return;
	}
	echo '<div class="filters reveal" data-filter-group data-filter-target="#blog-listesi" role="group" aria-label="Kategori filtresi">';
	echo '<button type="button" data-filter="all" class="is-active">Tümü</button>';
	foreach ( $kategoriler as $kategori ) {
		echo '<button type="button" data-filter="' . esc_attr( $kategori->slug ) . '">' . esc_html( $kategori->name ) . '</button>';
	}
	echo '</div>';
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
			<span class="eyebrow">Öne Çıkan Yazı</span>
			<h2><?php echo esc_html( get_the_title( $post ) ); ?></h2>
			<div class="post__meta">
				<?php if ( $terim ) : ?>
					<span><?php echo esc_html( $terim->name ); ?></span><span>·</span>
				<?php endif; ?>
				<span><?php echo esc_html( koi_okuma_suresi( $post ) ); ?> okuma</span><span>·</span><span><?php echo esc_html( koi_yazar_adi( $post ) ); ?></span>
			</div>
			<p class="lead"><?php echo esc_html( '' !== $lead ? $lead : koi_ozet( $post ) ); ?></p>
			<div style="margin-top:26px">
				<a class="btn btn--primary" href="<?php echo esc_url( get_permalink( $post ) ); ?>">Yazıyı Oku<?php echo koi_ok(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
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
	echo '<span class="eyebrow">' . esc_html( $etiket ) . '</span><h2>' . esc_html( $baslik ) . '</h2>';
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
				<h3><?php echo $hizmet ? 'Kısa Bilgi' : 'Program Bilgisi'; ?></h3>
				<ul>
					<?php foreach ( $satirlar as $satir ) : ?>
						<li><strong style="font-weight:400;color:var(--koi-olive)"><?php echo esc_html( $satir[0] ); ?>:</strong> <span class="muted"><?php echo esc_html( $satir[1] ); ?></span></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>

			<div class="sidebar-card sidebar-card--dark reveal">
				<h3><?php echo $hizmet ? 'Bilgi Alın' : 'Yerinizi Ayırtın'; ?></h3>
				<p><?php echo $hizmet ? 'Süreç hakkında konuşmak ve uygun saatleri belirlemek için ön başvuru formunu doldurabilirsiniz.' : 'Kontenjan durumunu ve katılım detaylarını paylaşabilmemiz için başvurunuzu iletin.'; ?></p>
				<div style="margin-top:20px;display:flex;flex-direction:column;gap:10px">
					<a class="btn btn--terra" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>"><?php echo $hizmet ? 'Ön Başvuru' : 'Atölye Başvurusu'; ?><?php echo koi_ok(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--light" href="<?php echo esc_url( koi_wa_url() ); ?>">WhatsApp</a>
				</div>
			</div>

			<div class="sidebar-card reveal">
				<h3><?php echo $hizmet ? 'Diğer Hizmetler' : 'Diğer Atölyeler'; ?></h3>
				<ul>
					<?php foreach ( $digerleri as $kayit ) : ?>
						<li><a href="<?php echo esc_url( get_permalink( $kayit ) ); ?>"><?php echo esc_html( get_the_title( $kayit ) ); ?></a></li>
					<?php endforeach; ?>
					<li><a href="<?php echo esc_url( $ust[1] ); ?>"><?php echo $hizmet ? 'Tüm Hizmetler' : 'Tüm Program Takvimi'; ?></a></li>
				</ul>
			</div>
		</aside>
	</div>
</section>

	<?php
	koi_ilgili_kartlar( $post, $hizmet ? 'İlgili Hizmetler' : 'Diğer Atölyeler', $hizmet ? 'Birlikte İlerleyen Süreçler' : 'Bunlar da İlginizi Çekebilir' );
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
				<h3>Bu Yazıda</h3>
				<ul>
					<?php foreach ( $basliklar as $kimlik => $metin ) : ?>
						<li><a href="#<?php echo esc_attr( $kimlik ); ?>"><?php echo esc_html( $metin ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>

			<div class="sidebar-card sidebar-card--dark reveal">
				<h3>Bir Uzmanla Konuşun</h3>
				<p>Bu konuda zorlanıyorsanız, kısa bir ön görüşmeyle başlayabiliriz.</p>
				<div style="margin-top:20px;display:flex;flex-direction:column;gap:10px">
					<a class="btn btn--terra" href="<?php echo esc_url( koi_url( 'iletisim' ) ); ?>">Bilgi Al<?php echo koi_ok(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="btn btn--light" href="<?php echo esc_url( koi_wa_url() ); ?>">WhatsApp</a>
				</div>
			</div>

			<?php if ( $kategoriler ) : ?>
			<div class="sidebar-card reveal">
				<h3>Kategoriler</h3>
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
	koi_ilgili_kartlar( $post, 'Devamı', 'İlgili Yazılar' );
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
