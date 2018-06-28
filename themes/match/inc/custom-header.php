<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Match
 */

function match_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'match_custom_header_args', array(
		'default-image'          => '%s/images/header-default.jpg',
		'random-default'         => false,
		'width'                  => 1920,
		'height'                 => 750,
		'flex-height'            => true,
		'header-text'            => false,
	) ) );
}
add_action( 'after_setup_theme', 'match_custom_header_setup' );

/** Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI. */
register_default_headers( array(

	'match' => array(
		'url'           => '%s/images/header-default.jpg',
		'thumbnail_url' => '%s/images/header-default-thumb.jpg',
		'description'   => esc_html__( 'Match', 'match' )
	)

) );
