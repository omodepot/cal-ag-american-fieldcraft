<?php
/**
 * Theme setup for CAL-AG American Fieldcraft.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function cal_ag_fieldcraft_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 160,
			'width'       => 320,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'cal-ag-fieldcraft' ),
		)
	);
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'after_setup_theme', 'cal_ag_fieldcraft_setup' );

function cal_ag_fieldcraft_assets() {
	$version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'cal-ag-theme', get_stylesheet_uri(), array(), $version );
	wp_enqueue_style( 'cal-ag-base', get_template_directory_uri() . '/styles.css', array(), $version );
	wp_enqueue_style( 'cal-ag-refinement', get_template_directory_uri() . '/refinement.css', array( 'cal-ag-base' ), $version );
	wp_enqueue_script( 'cal-ag-site', get_template_directory_uri() . '/site.js', array(), $version, true );
	if ( ! is_front_page() ) {
		wp_enqueue_style( 'cal-ag-pages', get_template_directory_uri() . '/pages.css', array( 'cal-ag-refinement' ), $version );
	}
}
add_action( 'wp_enqueue_scripts', 'cal_ag_fieldcraft_assets' );

function cal_ag_fieldcraft_robots( $robots ) {
	if ( '1' === get_option( 'blog_public' ) ) {
		return $robots;
	}
	$robots['noindex'] = true;
	$robots['nofollow'] = true;
	$robots['noarchive'] = true;
	return $robots;
}
add_filter( 'wp_robots', 'cal_ag_fieldcraft_robots' );


/**
 * Original review-site asset URL used in static-home.html. Rewritten to the
 * theme's own assets/ folder at render time.
 */
const CAL_AG_FIELDCRAFT_REVIEW_ASSETS = 'https://cal-ag-fieldcraft-review-7m4k2.info249216.chatgpt.site/assets/';

require_once __DIR__ . '/inc/shell.php';
require_once __DIR__ . '/inc/pages.php';

/**
 * Builds the editable homepage content from the approved static page:
 * one Custom HTML block per <section> inside <main>, markup unchanged except
 * image URLs, which point at the theme's assets/ folder.
 *
 * @param bool $link_pages Point homepage links at the site's pages (see inc/pages.php).
 * @return string Block markup, or '' if the approved page can't be read.
 */
function cal_ag_fieldcraft_home_blocks( $link_pages = true ) {
	$html = file_get_contents( get_template_directory() . '/static-home.html' );
	if ( false === $html ) {
		return '';
	}
	$start = strpos( $html, '<main>' );
	$end   = strpos( $html, '</main>' );
	if ( false === $start || false === $end ) {
		return '';
	}
	$main = substr( $html, $start + strlen( '<main>' ), $end - $start - strlen( '<main>' ) );
	$main = str_replace(
		CAL_AG_FIELDCRAFT_REVIEW_ASSETS,
		wp_make_link_relative( get_template_directory_uri() ) . '/assets/',
		$main
	);
	if ( $link_pages ) {
		$main = cal_ag_fieldcraft_apply_home_links( $main );
	}

	$blocks = array();
	foreach ( preg_split( '/(?=<section\b)/', $main, -1, PREG_SPLIT_NO_EMPTY ) as $section ) {
		$section = trim( $section );
		if ( '' !== $section ) {
			$blocks[] = "<!-- wp:html -->\n" . $section . "\n<!-- /wp:html -->";
		}
	}
	return implode( "\n\n", $blocks );
}

/**
 * Once per site: create the "Home" page from the approved design and set it as
 * the front page. Skips if this already ran, or if a static front page is
 * already configured (that page is used instead). Never overwrites content.
 */
function cal_ag_fieldcraft_ensure_home_page() {
	if ( ! current_user_can( 'manage_options' ) || get_option( 'cal_ag_fieldcraft_home_page_id' ) ) {
		return;
	}

	if ( 'page' === get_option( 'show_on_front' ) && (int) get_option( 'page_on_front' ) ) {
		update_option( 'cal_ag_fieldcraft_home_page_id', (int) get_option( 'page_on_front' ) );
		return;
	}

	$content = cal_ag_fieldcraft_home_blocks();
	if ( '' === $content ) {
		return;
	}

	$page_id = wp_insert_post(
		wp_slash(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => 'Home',
				'post_name'    => 'home',
				'post_content' => $content,
			)
		),
		true
	);
	if ( is_wp_error( $page_id ) ) {
		return;
	}

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', (int) $page_id );
	update_option( 'cal_ag_fieldcraft_home_page_id', (int) $page_id );
}
add_action( 'admin_init', 'cal_ag_fieldcraft_ensure_home_page' );
