<?php

if (!function_exists('match_rsvp_ui_deliver')) {
	function match_rsvp_ui_deliver() {

		// if the submit button is clicked, send the email
		if ( isset( $_POST['match-rsvp-submit'] ) ) {

			global $wpdb;
			date_default_timezone_set('America/Chicago');
			$rsvp_table_name = $wpdb->prefix.'rsvpform';

			$party_total = sanitize_text_field( $_POST["totalGuestNum"] );
			$primary_email = sanitize_email( $_POST["email_1"] );
			$song_request = esc_textarea( $_POST["songRequest"] );
			$date = time();
			$unread = 1;
			$deleted = 0;

			$i = 1;
			while ($i <= $party_total) {

				if ($i != 1) {
					$song_request = '';
				}

				$firstName = ucfirst(sanitize_text_field( $_POST["firstName_".$i] ));
				$lastName = ucfirst(sanitize_text_field( $_POST["lastName_".$i] ));
				$attending = sanitize_text_field( $_POST["attending_".$i] );
				$food_choice = sanitize_text_field( $_POST["mealChoice_".$i] );

				$data = array(
					'firstName' => $firstName,
					'lastName' => $lastName,
					'primary_email' => $primary_email,
					'party_total' => $party_total,
					'attending' => $attending,
					'food_choice' => $food_choice,
					'song_request' => $song_request,
					'date' => $date,
					'unread' => $unread,
					'deleted' => $deleted,
				);

				$format = array(
					'%s', // firstName     // string
					'%s', // lastName      // string
					'%s', // primary_email // string
					'%d', // party_total   // integer
					'%d', // attending     // integer
					'%d', // food_choice   // integer
					'%s', // song_request  // string
					'%d', // date          // integer
					'%d', // unread        // integer
					'%d', // deleted       // integer
				);

				$rsvp_success=$wpdb->insert( $rsvp_table_name, $data, $format );

				if($rsvp_success) {
					echo '<style>#match_rsvp_form{display:none}#thanks{display:block !important}#cta{display:block !important}</style>';
					echo '<p class="lead mb-0">We have successfully received '.$firstName.'\'s RSVP!</p>';
				} else {
					echo '<h2>Sorry! Something went wrong. Please try again.</h2><!--p class="lead text-danger">' . str_replace(array('Column', 'null'), array('Input', 'empty'), $wpdb->last_error) . '</p-->';
				}

				$i++;

			}

		}
	}
}