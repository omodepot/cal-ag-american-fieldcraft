<?php
/**
 * Inner page template: photo banner (like the homepage hero) with the page
 * title and excerpt, then the page's blocks.
 *
 * Banner photo: the page's Featured Image if set, otherwise the theme photo
 * chosen when the page was created.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$cal_ag_parent = wp_get_post_parent_id( get_the_ID() );
	$cal_ag_kicker = $cal_ag_parent ? get_the_title( $cal_ag_parent ) : 'CAL-AG ENTERPRISES';
	?>
<main>
<section class="page-hero">
	<?php echo cal_ag_fieldcraft_hero_image( get_the_ID() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div class="shade"></div>
	<div class="page-hero-copy">
		<div class="overline"><span><?php echo esc_html( strtoupper( $cal_ag_kicker ) ); ?></span><span>FOWLER, CALIFORNIA</span></div>
		<h1><?php the_title(); ?></h1>
		<?php if ( has_excerpt() ) : ?>
			<p><?php echo esc_html( get_the_excerpt() ); ?></p>
		<?php endif; ?>
	</div>
</section>
<div class="page-body">
	<?php the_content(); ?>
</div>
</main>
	<?php
endwhile;

get_footer();
