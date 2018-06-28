<?php

/**
 * Custom function gets the last modified date of the file
 * Output: YYYY.MM.DD.HHMM
 * Example output: 2015.04.13.1905 (April 13th, 2015 at 7:05 PM)
 */
function fileVersion($ver) {
	date_default_timezone_set('America/Chicago');
	$themePath = get_template_directory();
	return date("Y.m.d.Hi", filemtime($themePath . $ver));
}

/**
 * Remove Emoji code
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

/**
 * Remove unnecessary scripts
 */
function bcbsmn_deregister_scripts() {
	wp_deregister_script('jquery'); // re-declared later
}
add_action('wp_enqueue_scripts', 'bcbsmn_deregister_scripts');

/**
 * jQuery Library file to be called at the top of every page if not an admin page
 * Calling jQuery at the top of an admin the page breaks some admin functionalities (sidebar widgets)
 */
if (!is_admin()) {
	wp_enqueue_script('bcbsmn-jquery', get_template_directory_uri() . '/js/jquery.min.js', array(), '3.3.1', false);
}

/**
 * Custom JS files to be called at the bottom of the page
 * Version numbers are the dates the files were last modified
 */
function bcbsmn_custom_scripts() {
	$template = basename(get_page_template());
	$bottom_scripts = array(
	    'match-custom'       => '/js/libs.min.js',
	    'match-main'         => '/js/scripts.min.js'
	);
	foreach ($bottom_scripts as $handle => $src) {
	    echo wp_enqueue_script($handle, get_template_directory_uri() . $src, array(), fileVersion($src), true);
	}

	// Comment Reply
	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Keyboard image navigation support
	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'match-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array(), fileVersion('/js/keyboard-image-navigation.js'), true );
	}

}
add_action('wp_enqueue_scripts', 'bcbsmn_custom_scripts');

/**
 * Custom CSS files to be called at the top of the page
 * Version numbers are the dates the files were last modified
 */
function custom_styles() {

	$top_styles = array(
	    //'match-fontawesome' => '/css/font-awesome.css',
	    'match-fonts'       => match_fonts_url(),
	    'match-style'       => '/css/style.css'
	);

	foreach ($top_styles as $handle => $src) {

		if (strpos($src, '//')) {
			$custom_style = wp_enqueue_style($handle, $src, array(), get_bloginfo('version'), false);
		} else {
			$custom_style = wp_enqueue_style($handle, get_template_directory_uri() . $src, array(), fileVersion($src), false);
		}

		echo $custom_style;

	}
}
add_action('wp_enqueue_scripts', 'custom_styles');