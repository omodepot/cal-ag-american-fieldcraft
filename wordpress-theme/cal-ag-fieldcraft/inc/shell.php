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
 * Child pages of a page, as nav items (with one more level of children).
 *
 * @param int $parent_id Page ID.
 * @param int $depth     Levels to include.
 * @return array[]
 */
function cal_ag_fieldcraft_page_children( $parent_id, $depth = 2 ) {
	$items = array();
	foreach ( get_pages( array( 'parent' => $parent_id, 'sort_column' => 'menu_order,post_title', 'post_status' => 'publish' ) ) as $child ) {
		$items[] = array(
			'label'    => html_entity_decode( get_the_title( $child ), ENT_QUOTES, 'UTF-8' ),
			'url'      => get_permalink( $child ),
			'object'   => (int) $child->ID,
			'children' => $depth > 1 ? cal_ag_fieldcraft_page_children( $child->ID, $depth - 1 ) : array(),
		);
	}
	return $items;
}

/**
 * Header items: from Appearance > Menus > "Primary Navigation" (two levels),
 * else the approved defaults. A top-level page item with no sub-items shows
 * its child pages as the dropdown (e.g. Products > Equipment pages).
 *
 * @return array[]
 */
function cal_ag_fieldcraft_nav_items() {
	$items     = array();
	$locations = get_nav_menu_locations();

	if ( ! empty( $locations['primary'] ) ) {
		$all = (array) wp_get_nav_menu_items( $locations['primary'] );
		$sub = array();
		foreach ( $all as $item ) {
			if ( ! empty( $item->menu_item_parent ) ) {
				$sub[ (int) $item->menu_item_parent ][] = array(
					'label'    => html_entity_decode( $item->title, ENT_QUOTES, 'UTF-8' ),
					'url'      => $item->url,
					'object'   => ( 'post_type' === $item->type ) ? (int) $item->object_id : 0,
					'children' => array(),
				);
			}
		}
		foreach ( $all as $item ) {
			if ( empty( $item->menu_item_parent ) ) {
				$object   = ( 'post_type' === $item->type ) ? (int) $item->object_id : 0;
				$children = isset( $sub[ (int) $item->ID ] ) ? $sub[ (int) $item->ID ] : ( $object ? cal_ag_fieldcraft_page_children( $object ) : array() );
				$items[]  = array(
					'label'    => html_entity_decode( $item->title, ENT_QUOTES, 'UTF-8' ),
					'url'      => $item->url,
					'object'   => $object,
					'children' => $children,
				);
			}
		}
	}

	if ( ! $items ) {
		foreach ( cal_ag_fieldcraft_default_nav() as $item ) {
			$item['object']   = 0;
			$item['children'] = array();
			$items[]          = $item;
		}
	}
	return $items;
}

/**
 * Header navigation. Items without a dropdown keep the approved markup
 * (<nav><a>…</a></nav>); items with one are wrapped for the dropdown panel.
 *
 * @return string
 */
function cal_ag_fieldcraft_nav_html() {
	$current   = is_singular() ? get_queried_object_id() : 0;
	$ancestors = $current ? get_post_ancestors( $current ) : array();
	$is_cur    = static function ( $item ) use ( $current, $ancestors ) {
		return $current && ! empty( $item['object'] ) && ( $item['object'] === $current || in_array( $item['object'], $ancestors, true ) );
	};
	$link      = static function ( $item, $class = '' ) use ( $is_cur ) {
		return '<a href="' . esc_url( $item['url'] ) . '"' . ( $class ? ' class="' . esc_attr( $class ) . '"' : '' ) . ( $is_cur( $item ) ? ' aria-current="page"' : '' ) . '>' . esc_html( $item['label'] ) . '</a>';
	};

	$html = '<nav>';
	foreach ( cal_ag_fieldcraft_nav_items() as $i => $item ) {
		if ( empty( $item['children'] ) ) {
			$html .= $link( $item );
			continue;
		}
		$html .= '<div class="nav-item has-drop">' . $link( $item ) . '<div class="nav-drop" id="nav-drop-' . (int) $i . '"><div class="nav-drop-inner">';
		foreach ( $item['children'] as $child ) {
			if ( empty( $child['children'] ) ) {
				$html .= $link( $child, 'nav-drop-link' );
				continue;
			}
			$html .= '<div class="nav-drop-group">' . $link( $child, 'nav-drop-link nav-drop-head' );
			foreach ( $child['children'] as $grandchild ) {
				$html .= $link( $grandchild, 'nav-drop-sub' );
			}
			$html .= '</div>';
		}
		$html .= '</div></div></div>';
	}
	return $html . '</nav>';
}

/**
 * Footer site index: every published page, grouped like the header.
 *
 * @return array<string,array[]> Column title => links.
 */
function cal_ag_fieldcraft_site_index() {
	$cols      = array();
	$equipment = get_page_by_path( 'equipment', OBJECT, 'page' );
	$pvw       = get_page_by_path( 'equipment/perfect-van-wamel', OBJECT, 'page' );
	$used      = array();

	if ( $equipment ) {
		$cols['EQUIPMENT'][] = array( 'label' => 'All equipment', 'url' => get_permalink( $equipment ) );
		$used[]              = $equipment->ID;
		foreach ( cal_ag_fieldcraft_page_children( $equipment->ID, 1 ) as $child ) {
			$cols['EQUIPMENT'][] = $child;
			$used[]              = $child['object'];
		}
	}
	if ( $pvw ) {
		foreach ( cal_ag_fieldcraft_page_children( $pvw->ID, 1 ) as $child ) {
			$cols['PERFECT VAN WAMEL'][] = $child;
			$used[]                      = $child['object'];
		}
	}

	$cols['CAL-AG'][] = array( 'label' => 'Home', 'url' => home_url( '/' ) );
	$front            = (int) get_option( 'page_on_front' );
	$exclude          = array_filter( array_merge( $used, array( $front, (int) get_option( 'page_for_posts' ) ) ) );
	foreach ( get_pages( array( 'parent' => 0, 'sort_column' => 'menu_order,post_title', 'post_status' => 'publish', 'exclude' => $exclude ) ) as $page ) {
		$cols['CAL-AG'][] = array( 'label' => html_entity_decode( get_the_title( $page ), ENT_QUOTES, 'UTF-8' ), 'url' => get_permalink( $page ) );
		foreach ( cal_ag_fieldcraft_page_children( $page->ID, 1 ) as $child ) {
			$cols['CAL-AG'][] = $child;
		}
	}
	return $cols;
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
