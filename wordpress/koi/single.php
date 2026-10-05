<?php
/**
 * Tekil icerik: blog yazisi, hizmet ve atolye detay sayfalari.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

while ( have_posts() ) {
	the_post();
	if ( in_array( get_post_type(), array( 'hizmet', 'atolye' ), true ) ) {
		koi_detay_sayfasi( get_post() );
	} else {
		koi_yazi_sayfasi( get_post() );
	}
}

get_footer();
