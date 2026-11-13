<?php
/**
 * Shared footer: site index band (all pages + contact; the homepage adds the
 * same band without the headline), then the approved footer.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_front_page() ) {
	echo cal_ag_fieldcraft_site_index_html( true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

echo cal_ag_fieldcraft_shell_part( 'footer' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
wp_footer();
?>
</body>
</html>
