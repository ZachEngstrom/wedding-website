<?php

if ( ! function_exists( 'match_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function match_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Match, use a find and replace
	 * to change 'match' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'match', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// Theme Image Sizes
	add_image_size( 'match-standard', 938, 500, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'match' ),
	) );

	// This theme styles the visual editor to resemble the theme style.
	$editorCSSFileLocation = '/css/editor-style.min.css';
	add_editor_style( array ( $editorCSSFileLocation, match_fonts_url() ) );
	function match_custom_editor_stylesheet_version( $mce_init ) {
	    $mce_init['cache_suffix'] = date("Y\.m\.d\.Hi", filemtime(get_template_directory() . $editorCSSFileLocation));
	    return $mce_init;
	}
	add_filter( 'tiny_mce_before_init', 'match_custom_editor_stylesheet_version' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array (
		'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'gallery', 'image', 'link', 'quote', 'video',
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'match_custom_background_args', array(
		'default-color' => 'fafafa',
		'default-image' => '',
	) ) );

}
endif; // match_setup
add_action( 'after_setup_theme', 'match_setup' );

// Remove WordPress version from meta tags
function match_remove_version() {
	return '';
}
add_filter('the_generator', 'match_remove_version');

// Enable shortcodes in text widgets
add_filter('widget_text','do_shortcode');
