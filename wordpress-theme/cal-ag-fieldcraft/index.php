<?php
/**
 * Fallback template (posts, archives, search, 404) in the shared design shell.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( is_404() ) {
	$cal_ag_title = 'Page not found.';
} elseif ( is_search() ) {
	/* translators: %s: search query. */
	$cal_ag_title = sprintf( 'Search: %s', get_search_query() );
} elseif ( is_archive() ) {
	$cal_ag_title = wp_strip_all_tags( get_the_archive_title() );
} elseif ( is_singular() ) {
	$cal_ag_title = single_post_title( '', false );
} else {
	$cal_ag_title = 'News';
}
?>
<main>
<section class="page-hero page-hero-short">
	<?php echo cal_ag_fieldcraft_hero_image( 0 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div class="shade"></div>
	<div class="page-hero-copy">
		<div class="overline"><span>CAL-AG ENTERPRISES</span><span>FOWLER, CALIFORNIA</span></div>
		<h1><?php echo esc_html( $cal_ag_title ); ?></h1>
	</div>
</section>
<div class="page-body">
	<?php if ( is_404() ) : ?>
		<p class="fc-lead">The page you&rsquo;re looking for has moved or doesn&rsquo;t exist.</p>
		<p class="fc-more"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to the homepage &#8599;</a></p>
	<?php elseif ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class( 'fc-entry' ); ?>>
				<?php if ( ! is_singular() ) : ?>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				<?php else : ?>
					<?php the_content(); ?>
				<?php endif; ?>
			</article>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p class="fc-lead">Nothing here yet.</p>
	<?php endif; ?>
</div>
</main>
<?php
get_footer();
