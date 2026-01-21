<?php
/**
 * Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Polente DE
 */

if ( ! function_exists( 'polentede_setup' ) ) :
	function polentede_setup() {
		load_theme_textdomain( 'polentede', get_template_directory() . '/languages' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'polentede_setup' );

/**
 * Register block patterns.
 */
function polentede_register_block_patterns() {
	register_block_pattern_category(
		'polentede',
		array( 'label' => __( 'Polente DE', 'polentede' ) )
	);
}
add_action( 'init', 'polentede_register_block_patterns' );

/**
 * Enqueue front-end styles with cache-busting.
 */
function polentede_enqueue_styles() {
	$theme_version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style(
		'polentede-style',
		get_template_directory_uri() . '/style.min.css',
		array(),
		$theme_version
	);
}
add_action( 'wp_enqueue_scripts', 'polentede_enqueue_styles' );

/**
 * Enqueue editor styles so the block editor matches the front end.
 */
function polentede_editor_assets() {
	add_editor_style( 'style.min.css' );
}
add_action( 'after_setup_theme', 'polentede_editor_assets' );
