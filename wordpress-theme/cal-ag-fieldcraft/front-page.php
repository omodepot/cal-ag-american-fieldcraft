<?php
/**
 * Front page template.
 *
 * The approved static concept is rendered intact while WordPress supplies
 * metadata, plugin hooks, the admin bar, and future content integration.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$template_path = get_template_directory() . '/static-home.html';
$document      = file_get_contents( $template_path );
$theme_uri     = get_template_directory_uri();

$document = str_replace(
	array(
		'<link rel="stylesheet" href="styles.css">',
		'<link rel="stylesheet" href="refinement.css">',
		'<script defer src="site.js"></script>',
	),
	array( '', '', '' ),
	$document
);

ob_start();
wp_head();
$head_markup = ob_get_clean();

ob_start();
wp_footer();
$footer_markup = ob_get_clean();

$document = str_replace( '</head>', $head_markup . '</head>', $document );
$document = str_replace( '</body>', $footer_markup . '</body>', $document );

echo $document; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

