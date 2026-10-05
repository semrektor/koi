<?php
/**
 * Arsivler (kategori, etiket, tarih, arama) ve yedek sablon.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

if ( is_search() ) {
	$koi_baslik = 'Arama: ' . get_search_query();
} elseif ( is_archive() ) {
	$koi_baslik = wp_strip_all_tags( get_the_archive_title() );
} else {
	$koi_baslik = 'Blog';
}
koi_sade_ust( $koi_baslik, is_archive() ? wp_strip_all_tags( get_the_archive_description() ) : '' );
?>
<section class="section section--tight">
	<div class="container container--wide">
		<?php if ( have_posts() ) : ?>
			<div class="cards cards--3">
				<?php
				while ( have_posts() ) {
					the_post();
					if ( 'post' === get_post_type() ) {
						echo koi_yazi_karti( get_post() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					} else {
						echo koi_kart( get_post() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
				}
				?>
			</div>
			<div class="koi-sayfalama">
				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 1,
						'prev_text' => 'Önceki',
						'next_text' => 'Sonraki',
					)
				);
				?>
			</div>
		<?php else : ?>
			<p class="lead">Burada henüz içerik yok.</p>
		<?php endif; ?>
		<p style="margin-top:32px"><a class="link-arrow" href="<?php echo esc_url( koi_url( 'blog' ) ); ?>">Tüm Yazılar<?php echo koi_ok(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></p>
	</div>
</section>
<?php
get_footer();
