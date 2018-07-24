<?php

if (!function_exists('match_guestbook_admin_menu')) {
	function match_guestbook_admin_menu() {

		// Get count of unread messages to display as a badge in the admin menu
		global $wpdb;
		$guestbook_table_name = $wpdb->prefix . 'matchguestbook';
		$count_query = "SELECT count(*) FROM $guestbook_table_name WHERE `unread` = '1'";
		$unreadCount = $wpdb->get_var($count_query);

		if ($unreadCount == 0) {
			$countBubble = '';
		} else {
			$countBubble = sprintf(
				' <span class="update-plugins"><span class="update-count">%d</span></span>',
				$unreadCount //bubble contents
			);
		}
		add_menu_page( 'Guestbook', 'Guestbook' . $countBubble, 'edit_posts', 'match-guestbook-form.php', 'match_guestbook_admin_page', 'dashicons-feedback', 102 );
		add_submenu_page( 'match-guestbook-form.php', 'Deleted Messages', 'Deleted Messages', 'manage_options', 'admin.php?page=match-guestbook-form.php&list=deleted');
	}
	add_action( 'admin_menu', 'match_guestbook_admin_menu' );
}

if (!function_exists('match_guestbook_admin_page')) {
	function match_guestbook_admin_page(){

		include_once plugin_dir_path( __FILE__ ) . "admin-css.php";
		echo $adminCSS;

		if (isset($_GET['view'])) {

			include_once plugin_dir_path( __FILE__ ) . "inc-guestbook/view-view.php";

		} else if (isset($_GET['list'])) {

			$isDeletedList = $_GET['list'];

			if ($isDeletedList == 'deleted') {

				include_once plugin_dir_path( __FILE__ ) . "inc-guestbook/view-deleted-list.php";

			}

		} else if (isset($_GET['view-deleted'])) {

			include_once plugin_dir_path( __FILE__ ) . "inc-guestbook/view-deleted-ind.php";

		} else {

			include_once plugin_dir_path( __FILE__ ) . "inc-guestbook/view-list.php";

		}

	}

}