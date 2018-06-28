<?php

/*
 * CTA Button Shortcode Declaration
 * [cta-btn]
 * @link https://github.com/MWDelaney/bootstrap-3-shortcodes/blob/master/bootstrap-shortcodes.php
 */
function match_shortcode_timeline($atts, $content = null) {

	global $wpdb;

	$dbTableTimeline = $GLOBALS['wpdb']->get_results( 'SELECT * FROM '.$wpdb->prefix.'timeline ORDER BY `date`' );

	$timelineList = '';

	if (empty($dbTableTimeline)) {
		$timelineList .= '';
	} else {

		$timelineList .= '<div class="timeline">';

		$i = 0;

		foreach ($dbTableTimeline as $timeline => $row) {

			$i++;

			if($i % 2 == 0) {
				$timelineItemClass = 'timeline-container right';
			} else {
				$timelineItemClass = 'timeline-container left';
			}

			if ( !empty($row->title) ) {
				$timelineItemTitle = '<h3 class="h4 mb-4">'.$row->title.'</h3>';
			}

			$timelineItemDate = '<h2>'.date("M\. j\, Y", substr($row->date, 0, 10)).'</h2>';

			$timelineList .= "
				<div class='".$timelineItemClass."'>
					<div class='content'>
						".$timelineItemDate."
						".$timelineItemTitle."
						".str_replace(array('&lt;','&gt;','&quot;'), array('<','>','"'),stripslashes(wpautop($row->story)))."
					</div>
				</div>
			";

		}

		$timelineList .= '</div>';

	}

	return $timelineList;

}
add_shortcode('timeline', 'match_shortcode_timeline');




// WYSIWYG for adding timeline item - https://stackoverflow.com/questions/41659034/wordpress-how-to-add-wysiwyg-to-textarea-with-a-specific-class




/**************************************************************************************************
 *     *     *     *     *     *     *     Usage Examples     *     *     *     *     *     *     *
 **************************************************************************************************/




/*
 * Standard
 * No parameters
 *

	[cta-btn]CTA Button[/cta-btn]

*/




/*
 * Large
 * Pass size="lg" through the "cta-btn" shortcode
 *

	[cta-btn size="lg"]CTA Button[/cta-btn]

*/




/*
 * Small
 * Pass size="sm" through the "cta-btn" shortcode
 *

	[cta-btn size="sm"]CTA Button[/cta-btn]

*/




/*
 * Extra Small
 * Pass size="xs" through the "cta-btn" shortcode
 *

	[cta-btn size="xs"]CTA Button[/cta-btn]

*/
