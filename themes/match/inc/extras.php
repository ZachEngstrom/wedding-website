<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Match
 */

/**
 * Register Google fonts for Match.
 *
 * @return string Google fonts URL for the theme.
 */
function match_fonts_url() {

    // Fonts and Other Variables
    $fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

    /* Translators: If there are characters in your language that are not
    * supported by Open Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    if ( 'off' !== esc_html_x( 'on', 'Open Sans font: on or off', 'match' ) ) {
		$fonts[] = 'Open Sans:400,400i,700,700i';
	}

	/* Translators: If there are characters in your language that are not
    * supported by Roboto, translate this to 'off'. Do not translate
    * into your own language.
    */
    if ( 'off' !== esc_html_x( 'on', 'Roboto font: on or off', 'match' ) ) {
		$fonts[] = 'Roboto:400,400i,700,700i';
	}

	/* Translators: To add an additional character subset specific to your language,
	* translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'.
	* Do not translate into your own language.
	*/
	$subset = esc_html_x( 'no-subset', 'Add new subset (cyrillic, greek, devanagari, vietnamese)', 'match' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;

}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function match_page_menu_args( $args ) {
	$args['show_home'] = true;
	$args['menu_class'] = 'site-primary-menu';
	return $args;
}
add_filter( 'wp_page_menu_args', 'match_page_menu_args' );

/**
 * Add ID and CLASS attributes to the first <ul> occurence in wp_page_menu
 */
function match_page_menu_class( $class ) {
  return preg_replace( '/<ul>/', '<ul class="primary-menu sf-menu">', $class, 1 );
}
add_filter( 'wp_page_menu', 'match_page_menu_class' );

/**
 * Filter 'the_content_more_link'
 * Prevent Page Scroll When Clicking the More Link.
 *
 * @param string $link
 * @return filtered link
 */
function match_the_content_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'match_the_content_more_link_scroll' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function match_body_classes( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'match_body_classes' );

/**
 * Display Blog Credits.
 *
 * @return void
 */
function match_credit_blog() {
	$credit_blog_string = '<div class="credits-blog">&copy; %1$s %2$s <span>&sdot;</span> <a href="%3$s">%4$s</a></div>';
	printf( $credit_blog_string,
		esc_html__( 'Copyright', 'match' ),
		esc_html( date( 'Y' ) ),
		esc_url( home_url() ),
		esc_html( get_bloginfo( 'name' ) )
	);
}
add_action( 'match_credits', 'match_credit_blog' );

/**
 * Designer Credits.
 *
 * @return void
 */
function match_credits_designer() {
	$designer_string = sprintf( '%1$s %2$s <a href="%3$s" title="%4$s">%5$s</a> <span>%6$s</span> %7$s <a href="%8$s" title="%9$s">%10$s</a>',
		esc_html( 'Match Theme' ),
		esc_html__( 'by', 'match' ),
		esc_url( 'http://dovethemes.com' ),
		esc_attr( 'DoveThemes' ),
		esc_html( 'DoveThemes' ),
		esc_html_x( '&sdot;', 'Footer Credit Separator', 'match' ),
		esc_html__( 'Powered by', 'match' ),
		esc_url( 'https://wordpress.org' ),
		esc_attr( 'WordPress' ),
		esc_html( 'WordPress' )
	);

	// Designer HTML
	$html = '<div class="credits credits-designer">'. $designer_string .'</div>';

	/**
	 * Filters the Designer HTML.
	 *
	 * @param string $html Designer HTML.
	 */
	$html = apply_filters( 'match_credits_designer_html', $html );

	echo $html; // WPCS: XSS OK.
}
add_action( 'match_credits', 'match_credits_designer' );

/**
 * Adjust content_width value.
 *
 * @return void
 */
function match_template_redirect_content_width() {

	// Full Width Page Template
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 1038;
	}

}
add_action( 'template_redirect', 'match_template_redirect_content_width' );

if ( ! function_exists( 'match_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @return void
 */
function match_the_attached_image() {
	$post                = get_post();
	/**
	 * Filter the default Retina attachment size.
	 *
	 * @param array $dimensions {
	 *     An array of height and width dimensions.
	 *
	 *     @type int $height Height of the image in pixels. Default 1140.
	 *     @type int $width  Width of the image in pixels. Default 1140.
	 * }
	 */
	$attachment_size     = apply_filters( 'match_attachment_size', 'full' );
	$next_attachment_url = wp_get_attachment_url();

	if ( $post->post_parent ) { // Only look for attachments if this attachment has a parent object.

		/*
		 * Grab the IDs of all the image attachments in a gallery so we can get the URL
		 * of the next adjacent image in a gallery, or the first image (if we're
		 * looking at the last image in a gallery), or, in a gallery of one, just the
		 * link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => 100,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID',
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {

			foreach ( $attachment_ids as $key => $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					break;
				}
			}

			// For next attachment
			$key++;

			if ( isset( $attachment_ids[ $key ] ) ) {
				// get the URL of the next image attachment
				$next_attachment_url = get_attachment_link( $attachment_ids[$key] );
			} else {
				// or get the URL of the first image attachment
				$next_attachment_url = get_attachment_link( $attachment_ids[0] );
			}

		}

	} // end post->post_parent check

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		esc_attr( get_the_title() ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);

}
endif;
