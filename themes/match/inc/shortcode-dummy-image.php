<?php

/*
 * Blog List Shortcode Declaration
 * @link https://upthemes.com/blog/2011/07/how-to-build-a-custom-page-template-for-blog-posts/
 * [postslist]
 */
function matchchild_shortcode_dummy_image($atts, $content=null) {

    $atts = shortcode_atts( array(
			"text"       => false,
			"width"      => false,
			"height"     => false,
			"bg-color"   => false, // Not done
			"text-color" => false // Not done
	), $atts );

	$output = '';

	if ($atts['width']) {
		$dummy_width = $atts['width'];
	} else {
		$dummy_width = "1000";
	}

	if ($atts['height']) {
		$dummy_height = $atts['height'];
	} else {
		$dummy_height = round($dummy_width * (9/16));
	}

	if ($atts['text']) {
		$dummy_text = str_replace(' ', '+', $atts['text']);
	} else {
		$dummy_text = $dummy_width . '+×+' . $dummy_height;
	}

	if ($atts['bg-color']) {
		$dummy_bgcolor = $atts['bg-color'];
	} else {
		$dummy_bgcolor = 'ccc';
	}

	if ($atts['text-color']) {
		$dummy_textcolor = $atts['text-color'];
	} else {
		$dummy_textcolor = '969696';
	}
	
	$output .= '<img class="img-fluid" src="https://dummyimage.com/'.$dummy_width.'x'.$dummy_height.'/'.$dummy_bgcolor.'/'.$dummy_textcolor.'.png&text='.$dummy_text.'" />';

	return $output;

}
add_shortcode('dummy-image', 'matchchild_shortcode_dummy_image');