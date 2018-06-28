<?php

/*
 * CTA Button Shortcode Declaration
 * [cta-btn]
 * @link https://github.com/MWDelaney/bootstrap-3-shortcodes/blob/master/bootstrap-shortcodes.php
 */
function match_shortcode_grid_wrapper($atts = [], $content=null) {

    $atts = shortcode_atts( array(
			//"size"   => false
	), $atts );
 
   $output = '';

   $output .= '<div class="row">';

   $output .= do_shortcode($content);

   $output .= '</div>';
 
    // return output
    return $output;
}
add_shortcode('grid-wrapper', 'match_shortcode_grid_wrapper');