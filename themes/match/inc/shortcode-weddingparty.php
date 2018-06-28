<?php

/*
 * CTA Button Shortcode Declaration
 * [cta-btn]
 * @link https://github.com/MWDelaney/bootstrap-3-shortcodes/blob/master/bootstrap-shortcodes.php
 */
function match_shortcode_weddingparty($atts, $content = null) {

	global $wpdb;

	$DBTableWeddingparty = $GLOBALS['wpdb']->get_results( 'SELECT * FROM '.$wpdb->prefix.'weddingparty ORDER BY `position`' );

	$weddingPartyList = '';

	$atts = shortcode_atts( array(
			"other"     => ''
	), $atts );

	if ($atts['size'] == '') {
		$btnClass = '';
	}

	if (empty($DBTableWeddingparty)) {
		$weddingPartyList .= '';
	} else {

		$weddingPartyList .= '<div class="row"><div class="col-12"><div class="card-deck d-block d-md-flex">';

		$i = 0;

		foreach ($DBTableWeddingparty as $weddingparty => $row) {

			$wp_role = ucwords( str_replace(',', ', ', str_replace('-', ' ', $row->role)));
			$wp_role_class = str_replace(',', '-', $row->role);

			if (!empty($row->relationship)) {
				$wp_relationship = '<p>(' . str_replace('.','',$row->relationship) . ')</p>';
			} else {
				$wp_relationship = '';
			}

			$weddingPartyList .= "
					<div class='card card-".$wp_role_class."'>
						<div class='h2 card-header'>".$wp_role."</div>
						<div class='card-body'>
							<div class='h3 card-title'>".$row->name."</div>
							".$wp_relationship."
						</div>
						<div class='card-footer'></div>
					</div>
			";

			$i++;

			if ($i % 2 == 0 && $i != count($DBTableWeddingparty)) {
				$weddingPartyList .= "\t</div>\n\t\t\t\t<div class='card-deck d-block d-md-flex'>";
			}

		}

		$weddingPartyList .= '</div></div></div>';

	}

	return $weddingPartyList;

}
add_shortcode('weddingparty', 'match_shortcode_weddingparty');




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
