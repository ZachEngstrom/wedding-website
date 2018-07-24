<?php

if (!function_exists('match_contact_admin_menu')) {
	function match_contact_admin_menu() {

		// Get count of unread messages to display as a badge in the admin menu
		global $wpdb;
		$contact_table_name = $wpdb->prefix . 'matchcontactform';
		$count_query = "SELECT count(*) FROM $contact_table_name WHERE `unread` = '1'";
		$unreadCount = $wpdb->get_var($count_query);

		if ($unreadCount == 0) {
			$countBubble = '';
		} else {
			$countBubble = sprintf(
				' <span class="update-plugins"><span class="update-count">%d</span></span>',
				$unreadCount //bubble contents
			);
		}
		add_menu_page( 'Contact Form', 'Contact Form' . $countBubble, 'edit_posts', 'match-contact-form.php', 'match_contact_admin_page', 'dashicons-feedback', 101 );
		add_submenu_page( 'match-contact-form.php', 'Deleted Messages', 'Deleted Messages', 'manage_options', 'admin.php?page=match-contact-form.php&list=deleted');
	}
	add_action( 'admin_menu', 'match_contact_admin_menu' );
}

if (!function_exists('match_contact_admin_page')) {
	function match_contact_admin_page(){

		include_once plugin_dir_path( __FILE__ ) . "admin-css.php";
		echo $adminCSS;

		if (isset($_GET['view'])) {

			include_once plugin_dir_path( __FILE__ ) . "inc-contactform/view-view.php";

		} else if (isset($_GET['list'])) {

			$isDeletedList = $_GET['list'];

			if ($isDeletedList == 'deleted') {

				include_once plugin_dir_path( __FILE__ ) . "inc-contactform/view-deleted-list.php";

			}

		} else if (isset($_GET['view-deleted'])) {

			include_once plugin_dir_path( __FILE__ ) . "inc-contactform/view-deleted-ind.php";

		} else {

			include_once plugin_dir_path( __FILE__ ) . "inc-contactform/view-list.php";

		}

	}

}