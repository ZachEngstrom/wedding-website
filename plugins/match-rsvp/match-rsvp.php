<?php
/**
 * Plugin Name: ZKEngstrom RSVP
 * Description: An RSVP form for <a href="http://zkengstrom.com" target="_blank">zkengstrom.com</a>.
 * Version: 1.0.0
 * Author: Zach Engstrom
 * Author URI: http://zachengstrom.com
 **/

include_once plugin_dir_path( __FILE__ ) . "inc/db-setup.php";
include_once plugin_dir_path( __FILE__ ) . "inc/admin-setup.php";
include_once plugin_dir_path( __FILE__ ) . "inc/ui-deliver.php";
include_once plugin_dir_path( __FILE__ ) . "inc/ui-form.php";

if (!function_exists('match_rsvp_shortcode')) {
	function match_rsvp_shortcode() {
		ob_start();
		match_rsvp_ui_deliver();   // ~inc/ui-deliver.php
		match_rsvp_ui_form();      // ~inc/ui-form.php
		return ob_get_clean();
	}
	add_shortcode( 'rsvp_form', 'match_rsvp_shortcode' );
}