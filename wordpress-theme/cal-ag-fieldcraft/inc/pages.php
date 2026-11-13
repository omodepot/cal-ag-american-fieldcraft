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

const CAL_AG_FIELDCRAFT_PAGES_VERSION = '2';

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
			'excerpt' => 'Rotary mowers, flail choppers, Solo-Swing, brush sweepers, and soil cultivation from Holland, distributed by CAL-AG since 1982.',
			'hero'    => 'PVW-ROTARY-SWING-ARM.jpg',
			'order'   => 1,
		),
		array(
			'path'    => 'equipment/perfect-van-wamel/flail-shredders',
			'title'   => 'Flail shredders',
			'excerpt' => 'PERFECT BK2, KK, and BKM flail shredders for orchard and vineyard prunings up to 4 inches.',
			'hero'    => 'PVW-FLAIL-CHOPPER.jpg',
			'order'   => 1,
		),
		array(
			'path'    => 'equipment/perfect-van-wamel/flail-mowers',
			'title'   => 'Flail mowers',
			'excerpt' => 'PERFECT KD compact flail mowers for row middles, grass strips, and professional grounds.',
			'hero'    => 'PVW-FLAIL-CHOPPER.jpg',
			'order'   => 2,
		),
		array(
			'path'    => 'equipment/perfect-van-wamel/vineyard-mowers',
			'title'   => 'Vineyard mowers',
			'excerpt' => 'PERFECT FV2 vineyard mowers with two swing arms: center row to vine row in one pass.',
			'hero'    => 'PVW-ROTARY-SWING-ARM.jpg',
			'order'   => 3,
		),
		array(
			'path'    => 'equipment/perfect-van-wamel/orchard-rotary-mowers',
			'title'   => 'Orchard rotary mowers',
			'excerpt' => 'PERFECT ZA and RF rotary mowers with swing arms that mow around every trunk, fence post, and solar panel stand.',
			'hero'    => 'PVW-RF-SOLAR-2.jpg',
			'order'   => 4,
		),
		array(
			'path'    => 'equipment/perfect-van-wamel/vineyard-orchard-rotary-mowers',
			'title'   => 'Vineyard & orchard rotary mowers',
			'excerpt' => 'PERFECT DR, LF, LK, MD, RN, and T rotary mowers for orchard and vineyard alleys.',
			'hero'    => 'PVW-ROTARY-SWING-ARM.jpg',
			'order'   => 5,
		),
		array(
			'path'    => 'equipment/perfect-van-wamel/solo-swing',
			'title'   => 'Solo-Swing attachment',
			'excerpt' => 'PERFECT Solo-Swing hydraulic swing arms for mowing around trees, posts, and solar panels.',
			'hero'    => 'PVW-ROTARY-SWING-ARM.jpg',
			'order'   => 6,
		),
		array(
			'path'    => 'equipment/perfect-van-wamel/brush-sweepers',
			'title'   => 'Brush sweepers',
			'excerpt' => 'PERFECT SPA, SPF, SPD, and SPDA brush sweepers that clear prunings from tree and vine rows.',
			'hero'    => 'PVW-FLAIL-CHOPPER.jpg',
			'order'   => 7,
		),
		array(
			'path'    => 'equipment/perfect-van-wamel/multi-mowers',
			'title'   => 'Multi mowers',
			'excerpt' => 'PERFECT ZW and Greenflex multi mowers for banks, ditches, and grassland.',
			'hero'    => 'PVW-FLAIL-CHOPPER.jpg',
			'order'   => 8,
		),
		array(
			'path'    => 'equipment/perfect-van-wamel/soil-cultivation',
			'title'   => 'Soil cultivation',
			'excerpt' => 'PERFECT subsoilers, aerators, overseeders, disc harrows, and the Terra Ranger in-row cultivator.',
			'hero'    => 'PVW-ROTARY-SWING-ARM.jpg',
			'order'   => 9,
		),
		array(
			'path'    => 'equipment/alpego',
			'title'   => 'Alpego',
			'excerpt' => 'The Focus Line for specialty crops: in-row cultivators, rotary tillers, power harrows, and subsoilers.',
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
			'path'    => 'photos-videos',
			'title'   => 'Photos & videos',
			'excerpt' => 'PERFECT and Martignani equipment in the field, plus brochures to download.',
			'hero'    => 'PVW-ROTARY-SWING-ARM.jpg',
			'order'   => 4,
		),
		array(
			'path'    => 'contact',
			'title'   => 'Contact',
			'excerpt' => 'Talk to an equipment specialist in Fowler, California.',
			'hero'    => 'DUNA5666.JPG',
			'order'   => 5,
		),
	);
}

/**
 * Replaces content tokens with this site's paths.
 *
 * @param string $content Block markup with {{assets}} / {{theme}} / {{home}} tokens.
 * @return string
 */
function cal_ag_fieldcraft_fill_tokens( $content ) {
	return str_replace(
		array( '{{assets}}', '{{theme}}', '{{home}}' ),
		array(
			wp_make_link_relative( get_template_directory_uri() ) . '/assets/',
			wp_make_link_relative( get_template_directory_uri() ) . '/',
			trailingslashit( wp_make_link_relative( home_url( '/' ) ) ),
		),
		$content
	);
}

/**
 * Creates missing pages and the header menu, once per pages version.
 */
function cal_ag_fieldcraft_ensure_pages() {
	$version = CAL_AG_FIELDCRAFT_PAGES_VERSION . '/' . wp_get_theme( get_template() )->get( 'Version' );
	if ( ! current_user_can( 'manage_options' ) || get_option( 'cal_ag_fieldcraft_pages_version' ) === $version ) {
		return;
	}

	foreach ( cal_ag_fieldcraft_page_definitions() as $page ) {
		$slug    = basename( $page['path'] );
		$file    = get_template_directory() . '/content/' . $slug . '.html';
		$content = is_readable( $file ) ? cal_ag_fieldcraft_fill_tokens( (string) file_get_contents( $file ) ) : '';
		$current = get_page_by_path( $page['path'], OBJECT, 'page' );

		if ( $current ) {
			// Refresh only pages this theme created that nobody has edited since.
			if ( '' !== $content && cal_ag_fieldcraft_page_is_untouched( $current ) && $current->post_content !== $content ) {
				wp_update_post(
					wp_slash(
						array(
							'ID'           => $current->ID,
							'post_content' => $content,
							'post_excerpt' => $page['excerpt'],
						)
					)
				);
				update_post_meta( $current->ID, '_cal_ag_content_md5', md5( (string) get_post_field( 'post_content', $current->ID, 'raw' ) ) );
				update_post_meta( $current->ID, '_cal_ag_hero_asset', $page['hero'] );
			}
			continue;
		}

		$parent = 0;
		if ( false !== strpos( $page['path'], '/' ) ) {
			$parent_page = get_page_by_path( dirname( $page['path'] ), OBJECT, 'page' );
			$parent      = $parent_page ? (int) $parent_page->ID : 0;
		}

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
			update_post_meta( $id, '_cal_ag_content_md5', md5( (string) get_post_field( 'post_content', $id, 'raw' ) ) );
		}
	}

	cal_ag_fieldcraft_ensure_menu();
	cal_ag_fieldcraft_ensure_menu_children();
	cal_ag_fieldcraft_update_home_links();
	update_option( 'cal_ag_fieldcraft_pages_version', $version );
}
add_action( 'admin_init', 'cal_ag_fieldcraft_ensure_pages', 20 );

/**
 * True if the theme created this page and nobody has edited its content since:
 * either the stored checksum still matches, or (pages created before checksums
 * existed) it carries the theme's banner meta and was never modified.
 *
 * @param WP_Post $post Page.
 * @return bool
 */
function cal_ag_fieldcraft_page_is_untouched( $post ) {
	$md5 = (string) get_post_meta( $post->ID, '_cal_ag_content_md5', true );
	if ( '' !== $md5 ) {
		return md5( (string) $post->post_content ) === $md5;
	}
	return '' !== (string) get_post_meta( $post->ID, '_cal_ag_hero_asset', true )
		&& $post->post_modified_gmt === $post->post_date_gmt;
}

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
 * Adds dropdown items under Company and Parts & service in the Primary menu,
 * only where that top-level item has no sub-items yet. Products shows the
 * Equipment page's child pages automatically (see inc/shell.php).
 */
function cal_ag_fieldcraft_ensure_menu_children() {
	$locations = get_nav_menu_locations();
	if ( empty( $locations['primary'] ) ) {
		return;
	}
	$menu_id = (int) $locations['primary'];
	$items   = (array) wp_get_nav_menu_items( $menu_id );

	$wanted = array(
		'company'       => array(
			array( 'Our team', '/company/#team' ),
			array( 'Photos & videos', 'photos-videos' ),
			array( 'Contact', 'contact' ),
		),
		'parts-service' => array(
			array( 'Brochures', '/photos-videos/#brochures' ),
			array( 'Contact', 'contact' ),
		),
	);

	foreach ( $wanted as $parent_path => $children ) {
		$parent_page = get_page_by_path( $parent_path, OBJECT, 'page' );
		if ( ! $parent_page ) {
			continue;
		}
		$parent_item = null;
		foreach ( $items as $item ) {
			if ( empty( $item->menu_item_parent ) && 'post_type' === $item->type && (int) $item->object_id === (int) $parent_page->ID ) {
				$parent_item = $item;
			}
		}
		if ( ! $parent_item ) {
			continue;
		}
		foreach ( $items as $item ) {
			if ( (int) $item->menu_item_parent === (int) $parent_item->ID ) {
				continue 2; // Already has sub-items: leave the editor's choice alone.
			}
		}
		$position = 0;
		foreach ( $children as $child ) {
			list( $label, $target ) = $child;
			$args = array(
				'menu-item-title'     => $label,
				'menu-item-status'    => 'publish',
				'menu-item-parent-id' => $parent_item->ID,
				'menu-item-position'  => ++$position,
			);
			$page = ( '/' === $target[0] ) ? null : get_page_by_path( $target, OBJECT, 'page' );
			if ( $page ) {
				$args['menu-item-type']      = 'post_type';
				$args['menu-item-object']    = 'page';
				$args['menu-item-object-id'] = $page->ID;
			} else {
				$args['menu-item-type'] = 'custom';
				$args['menu-item-url']  = home_url( $target );
			}
			wp_update_nav_menu_item( $menu_id, 0, $args );
		}
	}
}

/**
 * Old cal-ag.com addresses → new pages (301), so links and search rankings
 * carry over at launch.
 *
 * @return array<string,string> Old path (lowercase, no leading slash) => new path.
 */
function cal_ag_fieldcraft_legacy_redirects() {
	$pvw = 'equipment/perfect-van-wamel/';
	$map = array(
		'index.html'                     => '',
		'about-us'                       => 'company/',
		'our-team'                       => 'company/#team',
		'products'                       => 'equipment/',
		'perfect-van-wamel-product'      => $pvw,
		'flail-shredders'                => $pvw . 'flail-shredders/',
		'flail-mowers'                   => $pvw . 'flail-mowers/',
		'vineyard-mowers'                => $pvw . 'vineyard-mowers/',
		'orchard-rotary-mowers'          => $pvw . 'orchard-rotary-mowers/',
		'vineyard-orchard-rotary-mowers' => $pvw . 'vineyard-orchard-rotary-mowers/',
		'solo-swing-attachment'          => $pvw . 'solo-swing/',
		'brush-sweepers'                 => $pvw . 'brush-sweepers/',
		'multi-mowers'                   => $pvw . 'multi-mowers/',
		'photos-videos'                  => 'photos-videos/',
		'brochures'                      => 'photos-videos/#brochures',
		'parts-service'                  => 'parts-service/',
		'news-events'                    => 'company/',
		'contact-us'                     => 'contact/',
	);
	$out = array();
	foreach ( $map as $old => $new ) {
		$out[ $old ] = $new;
		if ( 'index.html' !== $old ) {
			$out[ $old . '.php' ]  = $new;
			$out[ $old . '.html' ] = $new;
		}
	}
	return $out;
}

add_action(
	'template_redirect',
	function () {
		if ( ! is_404() ) {
			return;
		}
		$path = strtolower( trim( (string) wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '', PHP_URL_PATH ), '/' ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$home = trim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
		if ( '' !== $home && 0 === strpos( $path, $home . '/' ) ) {
			$path = substr( $path, strlen( $home ) + 1 );
		}
		$map = cal_ag_fieldcraft_legacy_redirects();
		if ( isset( $map[ $path ] ) ) {
			wp_safe_redirect( home_url( '/' . $map[ $path ] ), 301 );
			exit;
		}
		if ( 0 === strpos( $path, 'brochure/' ) ) {
			wp_safe_redirect( home_url( '/photos-videos/#brochures' ), 301 );
			exit;
		}
	}
);

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
		'PERFECT / FEATURED'           => 'equipment/perfect-van-wamel/#rotary-mowers',
		'ROW-FLOOR MAINTENANCE'        => 'equipment/perfect-van-wamel/#brush-sweepers',
		'MARTIGNANI'                   => 'equipment/electrostatic-sprayers/',
		'01 Flail mowers'              => 'equipment/perfect-van-wamel/#flail-mowers',
		'02 Vineyard mowers'           => 'equipment/perfect-van-wamel/#rotary-mowers',
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
