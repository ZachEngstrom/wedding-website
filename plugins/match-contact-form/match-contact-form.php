<?php
/*
Plugin Name: ZKEngstrom Contact Form
Description: A custom contact form for <a href="http://zkengstrom.com" target="_blank">zkengstrom.com</a>.
Version: 1.0.0
Author: Zach Engstrom
Author URI: http://zachengstrom.com
*/

include_once plugin_dir_path( __FILE__ ) . "inc/contact-admin-page.php";
include_once plugin_dir_path( __FILE__ ) . "inc/guestbook-admin-page.php";
include_once plugin_dir_path( __FILE__ ) . "inc/db-setup.php";
include_once plugin_dir_path( __FILE__ ) . "inc/deliver-mail.php";
include_once plugin_dir_path( __FILE__ ) . "inc/form-code.php";

if (!function_exists('match_cf_shortcode')) {
	function match_cf_shortcode() {
		ob_start();
		match_deliver_mail();   // ~inc/deliver-mail.php
		match_form_code();      // ~inc/form-code.php
		return ob_get_clean();
	}
	add_shortcode( 'match_contact_form', 'match_cf_shortcode' );
}

if (!function_exists('match_guestbook_shortcode')) {
	function match_guestbook_shortcode() {
		global $wpdb;
		$guestbook_table_name = $wpdb->prefix.'matchguestbook';
		$guestbookResults = $wpdb->get_results( "SELECT * FROM $guestbook_table_name ORDER BY `date`");
		date_default_timezone_set('America/Chicago');

		$guestbookOutput = '<style>ul.list-unstyled{margin-left:0}li.media:last-child{border-width:0!important}.h4>small{font-size:.85rem;display:block;}@media (max-width: 576px){li.media{display:block}}</style><ul class="list-unstyled">';

		foreach ($guestbookResults as $guestbookResult) {

			if ($guestbookResult->approved == '1') {

				$guestbookOutput .= '
				<li class="media my-4 pb-4 border-bottom border-secondary">
					'.get_avatar( $guestbookResult->email, '64', $default, $alt, array( 'class' => array( 'align-self-start', 'mr-3' ) ) ).'
					<div class="media-body">
						<div class="h4">'.ucfirst($guestbookResult->firstName) . ' ' . ucfirst($guestbookResult->lastName).'<br><small class="text-muted">'.date("F j\, Y", substr($guestbookResult->date, 0, 10)).'</small></div>
						<div>'.stripslashes(nl2br($guestbookResult->message)).'</div>
					</div>
				</li>';

			}

		}

		$guestbookOutput .= '</ul>';

		return $guestbookOutput;

	}
	add_shortcode( 'match_guestbook', 'match_guestbook_shortcode' );
}