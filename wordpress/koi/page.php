<?php
/**
 * Sayfalar. Taslaktan gelen bir govde (sayfalar/<adres>.php) varsa o basilir;
 * yoksa sayfanin editorde yazilan icerigi sade duzende gosterilir.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

if ( ! koi_sayfa_govdesi( koi_sayfa_anahtari() ) ) {
	while ( have_posts() ) {
		the_post();
		koi_sade_ust( get_the_title() );
		?>
<section class="section section--tight">
	<div class="container container--wide">
		<div class="prose reveal">
			<?php the_content(); ?>
		</div>
	</div>
</section>
		<?php
	}
}

get_footer();
