<?php
/**
 * Shared footer: on inner pages, a site index band (all pages + contact),
 * then the approved footer, identical to the homepage.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_front_page() ) :
	?>
<section class="site-index" aria-label="Site index">
	<div class="site-index-lead">
		<span>LET&rsquo;S TALK EQUIPMENT</span>
		<h2>Your next pass<br><em>starts here.</em></h2>
		<a class="site-index-phone" href="tel:5598341588">559.834.1588 &#8599;</a>
	</div>
	<nav class="site-index-links" aria-label="Site pages">
		<?php foreach ( cal_ag_fieldcraft_site_index() as $cal_ag_title => $cal_ag_links ) : ?>
		<div>
			<span><?php echo esc_html( $cal_ag_title ); ?></span>
			<?php foreach ( $cal_ag_links as $cal_ag_item ) : ?>
				<a href="<?php echo esc_url( $cal_ag_item['url'] ); ?>"<?php echo ( is_page() && ! empty( $cal_ag_item['object'] ) && get_queried_object_id() === $cal_ag_item['object'] ) ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $cal_ag_item['label'] ); ?></a>
			<?php endforeach; ?>
		</div>
		<?php endforeach; ?>
		<div>
			<span>VISIT</span>
			<p>2020 S. Golden State #106<br>Fowler, California 93625</p>
			<p>Tel <a href="tel:5598341588">559.834.1588</a><br>Fax 559.834.5584</p>
		</div>
	</nav>
</section>
	<?php
endif;

echo cal_ag_fieldcraft_shell_part( 'footer' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
wp_footer();
?>
</body>
</html>
