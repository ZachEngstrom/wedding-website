<?php

if (!function_exists('match_rsvp_admin_menu')) {
	function match_rsvp_admin_menu() {

		// Get count of unread messages to display as a badge in the admin menu
		global $wpdb;
		$rsvp_table_name = $wpdb->prefix . 'rsvpform';
		$count_query = "SELECT count(*) FROM $rsvp_table_name WHERE `unread` = '1'";
		$unreadCount = $wpdb->get_var($count_query);

		if ($unreadCount == 0) {
			$countBubble = '';
		} else {
			$countBubble = sprintf(
				' <span class="update-plugins"><span class="update-count">%d</span></span>',
				$unreadCount //bubble contents
			);
		}
		add_menu_page( 'RSVP', 'RSVP' . $countBubble, 'edit_posts', 'match-rsvp.php', 'match_rsvp_admin_page', 'dashicons-feedback', 105 );
		add_submenu_page( 'match-rsvp.php', 'Deleted RSVPs', 'Deleted RSVPs', 'manage_options', 'admin.php?page=match-rsvp.php&list=deleted');
	}
	add_action( 'admin_menu', 'match_rsvp_admin_menu' );
}

if (!function_exists('match_rsvp_admin_page')) {
	function match_rsvp_admin_page(){

		// include_once plugin_dir_path( __FILE__ ) . "admin-css.php";
		// echo $adminCSS;

		// if (isset($_GET['view'])) {

		// 	include_once plugin_dir_path( __FILE__ ) . "inc/admin-view.php";

		// } else if (isset($_GET['list'])) {

		// 	$isDeletedList = $_GET['list'];

		// 	if ($isDeletedList == 'deleted') {

		// 		include_once plugin_dir_path( __FILE__ ) . "inc/admin-deleted-list.php";

		// 	}

		// } else if (isset($_GET['view-deleted'])) {

		// 	include_once plugin_dir_path( __FILE__ ) . "inc/admin-deleted-ind.php";

		// } else {

			include_once plugin_dir_path( __FILE__ ) . "../inc/admin-list.php";

		//}

	}

}