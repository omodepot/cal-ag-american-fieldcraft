<?php
/**
 * Shared design shell: head, header and footer markup taken from the approved
 * static-home.html, so every page uses exactly the same header and footer as
 * the approved homepage.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The approved static document (read once per request).
 *
 * @return string
 */
function cal_ag_fieldcraft_static_document() {
	static $html = null;
	if ( null === $html ) {
		$html = (string) file_get_contents( get_template_directory() . '/static-home.html' );
	}
	return $html;
}

/**
 * Rewrites review-site asset URLs to the theme's assets/ folder and the
 * approved "index.html" home links to the WordPress home URL.
 *
 * @param string $html Markup.
 * @return string
 */
function cal_ag_fieldcraft_rewrite_urls( $html ) {
	$html = str_replace( CAL_AG_FIELDCRAFT_REVIEW_ASSETS, esc_url( get_template_directory_uri() . '/assets/' ), $html );
	return str_replace( 'href="index.html"', 'href="' . esc_url( home_url( '/' ) ) . '"', $html );
}

/**
 * Returns one part of the approved shell.
 *
 * @param string $part head|preamble|header|footer.
 * @return string Markup ('' if not found).
 */
function cal_ag_fieldcraft_shell_part( $part ) {
	$doc = cal_ag_fieldcraft_static_document();

	switch ( $part ) {
		case 'head':
			// Everything inside <head>, minus the static asset tags WordPress enqueues itself.
			if ( ! preg_match( '#<head>(.*?)</head>#s', $doc, $m ) ) {
				return '';
			}
			return str_replace(
				array(
					'<link rel="stylesheet" href="styles.css">',
					'<link rel="stylesheet" href="refinement.css">',
					'<script defer src="site.js"></script>',
				),
				'',
				$m[1]
			);
		case 'preamble':
			return preg_match( '#<body[^>]*>(.*?)<header#s', $doc, $m ) ? $m[1] : '';
		case 'header':
			if ( ! preg_match( '#<header class="site-nav">.*?</header>#s', $doc, $m ) ) {
				return '';
			}
			$header = preg_replace( '#<nav>.*?</nav>#s', cal_ag_fieldcraft_nav_html(), $m[0], 1 );
			return cal_ag_fieldcraft_rewrite_urls( $header );
		case 'footer':
			return preg_match( '#<footer>.*?</footer>#s', $doc, $m ) ? cal_ag_fieldcraft_rewrite_urls( $m[0] ) : '';
	}
	return '';
}

/**
 * Default header links (used until a menu is assigned to "Primary Navigation").
 *
 * @return array[] Each item: label, url.
 */
function cal_ag_fieldcraft_default_nav() {
	return array(
		array( 'label' => 'Products', 'url' => home_url( '/equipment/' ) ),
		array( 'label' => 'Featured', 'url' => home_url( '/#featured' ) ),
		array( 'label' => 'Company', 'url' => home_url( '/company/' ) ),
		array( 'label' => 'Parts & service', 'url' => home_url( '/parts-service/' ) ),
	);
}

/**
 * Header navigation in the approved markup: <nav><a>…</a>…</nav>.
 * Items come from Appearance > Menus > "Primary Navigation" (top level only).
 *
 * @return string
 */
function cal_ag_fieldcraft_nav_html() {
	$items     = array();
	$locations = get_nav_menu_locations();

	if ( ! empty( $locations['primary'] ) ) {
		foreach ( (array) wp_get_nav_menu_items( $locations['primary'] ) as $item ) {
			if ( empty( $item->menu_item_parent ) ) {
				$items[] = array(
					'label'  => html_entity_decode( $item->title, ENT_QUOTES, 'UTF-8' ),
					'url'    => $item->url,
					'object' => ( 'post_type' === $item->type ) ? (int) $item->object_id : 0,
				);
			}
		}
	}
	if ( ! $items ) {
		$items = cal_ag_fieldcraft_default_nav();
	}

	$current = is_singular() ? get_queried_object_id() : 0;
	$html    = '<nav>';
	foreach ( $items as $item ) {
		$is_current = $current && ! empty( $item['object'] ) && ( $item['object'] === $current || in_array( $item['object'], get_post_ancestors( $current ), true ) );
		$html      .= '<a href="' . esc_url( $item['url'] ) . '"' . ( $is_current ? ' aria-current="page"' : '' ) . '>' . esc_html( $item['label'] ) . '</a>';
	}
	return $html . '</nav>';
}

/**
 * Inner pages: add the approved body class "fc" alongside WordPress's classes.
 */
add_filter(
	'body_class',
	function ( $classes ) {
		$classes[] = 'fc';
		if ( ! is_front_page() ) {
			$classes[] = 'fc-inner';
		}
		return $classes;
	}
);
