<?php
/**
 * Site pages, header menu and banner photos.
 *
 * On the first admin visit after this theme version is installed, creates any
 * missing pages from content/*.html and the "Primary" header menu. Existing
 * pages and menus are never changed.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const CAL_AG_FIELDCRAFT_PAGES_VERSION = '1';

/**
 * Pages to create. Order matters: parents before children.
 *
 * @return array[]
 */
function cal_ag_fieldcraft_page_definitions() {
	return array(
		array(
			'path'    => 'equipment',
			'title'   => 'Equipment',
			'excerpt' => 'Professional implements for orchards, vineyards, and specialty crops—selected, stocked, and supported by specialists.',
			'hero'    => 'HOUT9912.JPG',
			'order'   => 1,
		),
		array(
			'path'    => 'equipment/perfect-van-wamel',
			'title'   => 'PERFECT Van Wamel',
			'excerpt' => 'Flail shredders, mowers, and brush sweepers from Holland, distributed by CAL-AG since 1982.',
			'hero'    => 'UJOF4856.JPG',
			'order'   => 1,
		),
		array(
			'path'    => 'equipment/alpego',
			'title'   => 'Alpego',
			'excerpt' => 'Tillers, power harrows, and subsoilers for professional soil preparation.',
			'hero'    => 'AGJK2166.JPG',
			'order'   => 2,
		),
		array(
			'path'    => 'equipment/electrostatic-sprayers',
			'title'   => 'Electrostatic sprayers',
			'excerpt' => 'Martignani and LectroBlast electrostatic spraying systems for precise professional application.',
			'hero'    => 'FMMT3809.JPG',
			'order'   => 3,
		),
		array(
			'path'    => 'equipment/micron',
			'title'   => 'Micron weed sprayers',
			'excerpt' => 'Targeted weed control for orchards, vineyards, and specialty crops.',
			'hero'    => 'FRSY4534.JPG',
			'order'   => 4,
		),
		array(
			'path'    => 'company',
			'title'   => 'Company',
			'excerpt' => 'Founded in 1969 in Dinuba, California, and focused ever since on implements for orchard and vineyard maintenance.',
			'hero'    => 'POUN9579.JPG',
			'order'   => 2,
		),
		array(
			'path'    => 'parts-service',
			'title'   => 'Parts & service',
			'excerpt' => 'Factory-original parts, in-house support, and product documentation for the equipment we represent.',
			'hero'    => 'AMTZ1414.JPG',
			'order'   => 3,
		),
		array(
			'path'    => 'contact',
			'title'   => 'Contact',
			'excerpt' => 'Talk to an equipment specialist in Fowler, California.',
			'hero'    => 'DUNA5666.JPG',
			'order'   => 4,
		),
	);
}

/**
 * Replaces content tokens with this site's paths.
 *
 * @param string $content Block markup with {{assets}} / {{home}} tokens.
 * @return string
 */
function cal_ag_fieldcraft_fill_tokens( $content ) {
	return str_replace(
		array( '{{assets}}', '{{home}}' ),
		array( wp_make_link_relative( get_template_directory_uri() ) . '/assets/', trailingslashit( wp_make_link_relative( home_url( '/' ) ) ) ),
		$content
	);
}

/**
 * Creates missing pages and the header menu, once per pages version.
 */
function cal_ag_fieldcraft_ensure_pages() {
	if ( ! current_user_can( 'manage_options' ) || get_option( 'cal_ag_fieldcraft_pages_version' ) === CAL_AG_FIELDCRAFT_PAGES_VERSION ) {
		return;
	}

	foreach ( cal_ag_fieldcraft_page_definitions() as $page ) {
		if ( get_page_by_path( $page['path'], OBJECT, 'page' ) ) {
			continue; // Never overwrite an existing page.
		}
		$slug   = basename( $page['path'] );
		$parent = 0;
		if ( false !== strpos( $page['path'], '/' ) ) {
			$parent_page = get_page_by_path( dirname( $page['path'] ), OBJECT, 'page' );
			$parent      = $parent_page ? (int) $parent_page->ID : 0;
		}
		$file    = get_template_directory() . '/content/' . $slug . '.html';
		$content = is_readable( $file ) ? cal_ag_fieldcraft_fill_tokens( (string) file_get_contents( $file ) ) : '';

		$id = wp_insert_post(
			wp_slash(
				array(
					'post_type'    => 'page',
					'post_status'  => 'publish',
					'post_title'   => $page['title'],
					'post_name'    => $slug,
					'post_parent'  => $parent,
					'menu_order'   => $page['order'],
					'post_excerpt' => $page['excerpt'],
					'post_content' => $content,
				)
			),
			true
		);
		if ( ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_cal_ag_hero_asset', $page['hero'] );
		}
	}

	cal_ag_fieldcraft_ensure_menu();
	cal_ag_fieldcraft_update_home_links();
	update_option( 'cal_ag_fieldcraft_pages_version', CAL_AG_FIELDCRAFT_PAGES_VERSION );
}
add_action( 'admin_init', 'cal_ag_fieldcraft_ensure_pages', 20 );

/**
 * Creates the "Primary" header menu (same four links as the approved header)
 * if no menu is assigned to the header yet.
 */
function cal_ag_fieldcraft_ensure_menu() {
	$locations = get_nav_menu_locations();
	if ( ! empty( $locations['primary'] ) && wp_get_nav_menu_object( $locations['primary'] ) ) {
		return;
	}

	$menu = wp_get_nav_menu_object( 'Primary' );
	$id   = $menu ? (int) $menu->term_id : wp_create_nav_menu( 'Primary' );
	if ( is_wp_error( $id ) ) {
		return;
	}

	if ( ! $menu ) {
		$position = 0;
		foreach ( array( 'equipment' => 'Products', '#featured' => 'Featured', 'company' => 'Company', 'parts-service' => 'Parts & service' ) as $target => $label ) {
			$item = array(
				'menu-item-title'    => $label,
				'menu-item-status'   => 'publish',
				'menu-item-position' => ++$position,
			);
			$page = ( '#' === $target[0] ) ? null : get_page_by_path( $target, OBJECT, 'page' );
			if ( $page ) {
				$item['menu-item-type']      = 'post_type';
				$item['menu-item-object']    = 'page';
				$item['menu-item-object-id'] = $page->ID;
			} else {
				$item['menu-item-type'] = 'custom';
				$item['menu-item-url']  = ( '#' === $target[0] ) ? home_url( '/' . $target ) : home_url( '/' . $target . '/' );
			}
			wp_update_nav_menu_item( $id, 0, $item );
		}
	}

	$locations['primary'] = $id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

/**
 * Homepage links → new pages. Maps each approved homepage link (by its text)
 * to the page it should open. Anchors not listed keep their original target.
 *
 * @return array<string,string> Leading link text => site path.
 */
function cal_ag_fieldcraft_home_link_map() {
	return array(
		'01 / PERFECT VAN WAMEL'       => 'equipment/perfect-van-wamel/',
		'02 / ALPEGO'                  => 'equipment/alpego/',
		'03 / MARTIGNANI + LECTROBLAST' => 'equipment/electrostatic-sprayers/',
		'04 / MICRON SPRAYERS'         => 'equipment/micron/',
		'PERFECT / FEATURED'           => 'equipment/perfect-van-wamel/#orchard-rotary-mowers',
		'ROW-FLOOR MAINTENANCE'        => 'equipment/perfect-van-wamel/#brush-sweepers',
		'MARTIGNANI'                   => 'equipment/electrostatic-sprayers/',
		'01 Flail mowers'              => 'equipment/perfect-van-wamel/#flail-mowers',
		'02 Vineyard mowers'           => 'equipment/perfect-van-wamel/#vineyard-mowers',
		'03 Original parts'            => 'parts-service/',
		'Our full story'               => 'company/',
	);
}

/**
 * Applies the homepage link map to homepage markup.
 *
 * @param string $html Homepage section markup.
 * @return string
 */
function cal_ag_fieldcraft_apply_home_links( $html ) {
	$map  = cal_ag_fieldcraft_home_link_map();
	$root = trailingslashit( wp_make_link_relative( home_url( '/' ) ) );

	return preg_replace_callback(
		'#<a\b([^>]*)\bhref="(\#[^"]*)"([^>]*)>(.*?)</a>#s',
		static function ( $m ) use ( $map, $root ) {
			$text = trim( preg_replace( '/\s+/', ' ', html_entity_decode( wp_strip_all_tags( preg_replace( '/<[^>]+>/', ' ', $m[4] ) ) ) ) );
			foreach ( $map as $lead => $path ) {
				if ( 0 === strpos( $text, $lead ) ) {
					return '<a' . $m[1] . 'href="' . esc_attr( $root . $path ) . '"' . $m[3] . '>' . $m[4] . '</a>';
				}
			}
			return $m[0];
		},
		$html
	);
}

/**
 * Points an untouched auto-created Home page's links at the new pages.
 * Skipped if anyone has edited the Home page.
 */
function cal_ag_fieldcraft_update_home_links() {
	$home_id = (int) get_option( 'cal_ag_fieldcraft_home_page_id' );
	$home    = $home_id ? get_post( $home_id ) : null;
	if ( ! $home || $home->post_content !== cal_ag_fieldcraft_home_blocks( false ) ) {
		return;
	}
	wp_update_post(
		wp_slash(
			array(
				'ID'           => $home_id,
				'post_content' => cal_ag_fieldcraft_home_blocks( true ),
			)
		)
	);
}

/**
 * Banner photo for a page: its Featured Image, else the theme photo chosen at
 * creation, else the homepage hero photo.
 *
 * @param int $post_id Page ID (0 for archives/404).
 * @return string <img> markup.
 */
function cal_ag_fieldcraft_hero_image( $post_id ) {
	if ( $post_id && has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail(
			$post_id,
			'full',
			array(
				'class'         => 'hero-bg',
				'loading'       => false,
				'fetchpriority' => 'high',
			)
		);
	}
	$asset = $post_id ? (string) get_post_meta( $post_id, '_cal_ag_hero_asset', true ) : '';
	if ( ! preg_match( '/^[A-Za-z0-9_-]+\.(JPG|jpg|jpeg|png|webp)$/', $asset ) || ! file_exists( get_template_directory() . '/assets/' . $asset ) ) {
		$asset = 'DUNA5666.JPG';
	}
	return '<img class="hero-bg" src="' . esc_url( get_template_directory_uri() . '/assets/' . $asset ) . '" alt="" fetchpriority="high">';
}
