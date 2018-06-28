<?php

/*
 * CTA Button Shortcode Declaration
 * [cta-btn]
 * @link https://github.com/MWDelaney/bootstrap-3-shortcodes/blob/master/bootstrap-shortcodes.php
 */
function match_shortcode_button_link($atts = [], $content=null) {

    $atts = shortcode_atts( array(
            "size"   => false,
            "color" => false,
            "align" => false,
            "url" => false,
            "new-tab" => false
    ), $atts );
    
    if ($atts['size']) {
        $btnSize = ' btn-'.$atts['size'];
    } else {
        $btnSize = '';
    }
    
    if ($atts['color']) {
        $btnColor = ' btn-'.$atts['color'];
    } else {
        $btnColor = ' btn-primary';
    }
    
    if ($atts['align']) {
        if ($atts['align'] == 'left') {
            $btnAlign = ' style="text-align:left"';
        } else if ($atts['align'] == 'center') {
            $btnAlign = ' style="text-align:center"';
        } else if ($atts['align'] == 'right') {
            $btnAlign = ' style="text-align:right"';
        } else {
            $btnAlign = ' style="text-align:left"';
        }
    } else {
        $btnAlign = ' style="text-align:left"';
    }
    
    if ($atts['url']) {
        $btnURL = $atts['url'];
    } else {
        $btnURL = '#';
    }
    
    if ($atts['new-tab']) {
        if ($atts['new-tab'] == 'false') {
            $btnNT = '';
        } else {
            $btnNT = ' target="_blank"';
        }
    } else {
        $btnNT = ' target="_blank"';
    }
 
    $output = '';

    $output .= '<div'.$btnAlign.'><a class="btn'.$btnColor.$btnSize.'" href="'.$btnURL.'"'.$btnNT.'>';

    $output .= do_shortcode($content);

    $output .= '</a></div>';

    // return output
    return $output;
}
add_shortcode('button-link', 'match_shortcode_button_link');