<?php
/**
 * Front page template.
 *
 * The approved design shell (head, header, footer) comes from static-home.html
 * unchanged. The homepage sections inside <main> come from the WordPress page
 * set as the front page (Settings > Reading), so they can be edited in WP Admin
 * (Pages > Home). Each section is a Custom HTML block holding the approved
 * markup, rendered exactly as saved: no wpautop/wptexturize/lazy-load rewrites,
 * so the output matches the approved page byte-for-byte until someone edits it.
 *
 * If no front page is set, or it is empty, the approved static sections are used.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$template_path = get_template_directory() . '/static-home.html';
$document      = file_get_contents( $template_path );

$document = str_replace(
	array(
		'<link rel="stylesheet" href="styles.css">',
		'<link rel="stylesheet" href="refinement.css">',
		'<script defer src="site.js"></script>',
	),
	array( '', '', '' ),
	$document
);

// Shared header (menu from Appearance > Menus), identical markup on every page.
$document = preg_replace_callback(
	'#<header class="site-nav">.*?</header>#s',
	static function () {
		return cal_ag_fieldcraft_shell_part( 'header' );
	},
	$document,
	1
);

// Editable homepage content from the front page (includes previews of unsaved changes).
$front_post = null;
if ( is_page() && ! empty( $GLOBALS['wp_query']->posts[0] ) ) {
	$front_post = $GLOBALS['wp_query']->posts[0];
}

if ( $front_post && '' !== trim( (string) $front_post->post_content ) ) {
	$rendered = '';
	foreach ( parse_blocks( $front_post->post_content ) as $block ) {
		$rendered .= trim( render_block( $block ) );
	}

	$main_start = strpos( $document, '<main>' );
	$main_end   = strpos( $document, '</main>' );
	if ( '' !== $rendered && false !== $main_start && false !== $main_end ) {
		$document = substr( $document, 0, $main_start + strlen( '<main>' ) ) . $rendered . substr( $document, $main_end );
	}
}

$document = str_replace(
	CAL_AG_FIELDCRAFT_REVIEW_ASSETS,
	esc_url( get_template_directory_uri() . '/assets/' ),
	$document
);

$document = str_replace(
	'href="index.html"',
	'href="' . esc_url( home_url( '/' ) ) . '"',
	$document
);

// Site index (every page) above the approved footer, so all pages are reachable
// from the homepage footer and on phones, where the header menu is hidden.
$document = preg_replace_callback(
	'#<footer>#',
	static function () {
		return cal_ag_fieldcraft_site_index_html( false ) . '<footer>';
	},
	$document,
	1
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
