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
}
add_action( 'after_setup_theme', 'cal_ag_fieldcraft_setup' );

function cal_ag_fieldcraft_assets() {
	$version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'cal-ag-theme', get_stylesheet_uri(), array(), $version );
	wp_enqueue_style( 'cal-ag-base', get_template_directory_uri() . '/styles.css', array(), $version );
	wp_enqueue_style( 'cal-ag-refinement', get_template_directory_uri() . '/refinement.css', array( 'cal-ag-base' ), $version );
	wp_enqueue_script( 'cal-ag-site', get_template_directory_uri() . '/site.js', array(), $version, true );
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

