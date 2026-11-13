<?php
/**
 * Shared footer: on inner pages, a site index band (all pages + contact),
 * then the approved footer, identical to the homepage.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_front_page() ) :
	$cal_ag_link = static function ( $path ) {
		return esc_url( home_url( $path ) );
	};
	?>
<section class="site-index" aria-label="Site index">
	<div class="site-index-lead">
		<span>LET&rsquo;S TALK EQUIPMENT</span>
		<h2>Your next pass<br><em>starts here.</em></h2>
		<a class="site-index-phone" href="tel:5598341588">559.834.1588 &#8599;</a>
	</div>
	<nav class="site-index-links" aria-label="Site pages">
		<div>
			<span>EQUIPMENT</span>
			<a href="<?php echo $cal_ag_link( '/equipment/' ); ?>">All equipment</a>
			<a href="<?php echo $cal_ag_link( '/equipment/perfect-van-wamel/' ); ?>">PERFECT Van Wamel</a>
			<a href="<?php echo $cal_ag_link( '/equipment/alpego/' ); ?>">Alpego</a>
			<a href="<?php echo $cal_ag_link( '/equipment/electrostatic-sprayers/' ); ?>">Electrostatic sprayers</a>
			<a href="<?php echo $cal_ag_link( '/equipment/micron/' ); ?>">Micron weed sprayers</a>
		</div>
		<div>
			<span>CAL-AG</span>
			<a href="<?php echo $cal_ag_link( '/' ); ?>">Home</a>
			<a href="<?php echo $cal_ag_link( '/company/' ); ?>">Company</a>
			<a href="<?php echo $cal_ag_link( '/parts-service/' ); ?>">Parts &amp; service</a>
			<a href="<?php echo $cal_ag_link( '/contact/' ); ?>">Contact</a>
		</div>
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
