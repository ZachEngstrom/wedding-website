<?php

if (!function_exists('match_rsvp_ui_deliver')) {
	function match_rsvp_ui_deliver() {

		// if the submit button is clicked, send the email
		if ( isset( $_POST['match-submit'] ) ) {

			global $wpdb;
			date_default_timezone_set('America/Chicago');

			if ($_POST["reason"] == 'guestbook') {

				$guestbook_table_name = $wpdb->prefix.'matchguestbook';

				// sanitize form values
				$firstName = sanitize_text_field( $_POST["firstName"] );
				$lastName  = sanitize_text_field( $_POST["lastName"] );
				$email     = sanitize_email( $_POST["email"] );
				$message   = esc_textarea( $_POST["message"] );
				$date      = time();

				$data = array(
					'firstName' => $firstName,
					'lastName'  => $lastName,
					'email'     => $email,
					'message'   => $message,
					'date'      => $date,
					'unread'    => '1',
					'approved'  => '0',
					'deleted'   => '0'
				);

				$format = array(
					'%s', // firstName          // string
					'%s', // lastName           // string
					'%s', // email              // string
					'%s', // message            // string
					'%d', // date               // integer
					'%d', // unread (boolean)   // integer
					'%d', // approved (boolean) // integer
					'%d'  // deleted (boolean)  // integer
				);

				$guestbook_success=$wpdb->insert( $guestbook_table_name, $data, $format );

				if($guestbook_success) {
					echo '<style>#match_contact_form{display:none}</style>';
					echo '<h2>Thank You!</h2>';
					echo '<p class="lead">We have successfully received your guestbook comment! We will review it before making it visible. Check the <a href="/guestbook/" target="_blank">guestbook</a> page soon!</p>';
				} else {
					echo '<h2>Sorry! Something went wrong. Please try again.</h2><!--p class="lead text-danger">' . str_replace(array('Column', 'null'), array('Input', 'empty'), $wpdb->last_error) . '</p-->';
				}

			} else { // if user is not signing the guestbook

				$contact_table_name = $wpdb->prefix.'matchcontactform';

				// sanitize form values
				$firstName = sanitize_text_field( $_POST["firstName"] );
				$lastName  = sanitize_text_field( $_POST["lastName"] );
				$email     = sanitize_email( $_POST["email"] );
				$message   = esc_textarea( $_POST["message"] );
				$date      = time();

				$data = array(
					'firstName' => $firstName,
					'lastName'  => $lastName,
					'email'     => $email,
					'message'   => $message,
					'date'      => $date,
					'unread'    => '1',
					'deleted'   => '0'
				);

				$format = array(
					'%s', // firstName         // string
					'%s', // lastName          // string
					'%s', // email             // string
					'%s', // message           // string
					'%d', // date              // integer
					'%d', // unread (boolean)  // integer
					'%d'  // deleted (boolean) // integer
				);

				$contact_success=$wpdb->insert( $contact_table_name, $data, $format );

				if($contact_success) {
					echo '<style>#match_contact_form{display:none}</style>';
					echo '<h2>Thank You!</h2>';
					echo '<p class="lead">We have successfully received your message!</p>';
				} else {
					echo '<h2>Sorry! Something went wrong. Please try again.</h2><!--p class="lead text-danger">' . str_replace(array('Column', 'null'), array('Input', 'empty'), $wpdb->last_error) . '</p-->';
				}

			}
		}
	}
}