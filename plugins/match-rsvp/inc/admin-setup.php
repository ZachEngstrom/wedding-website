<?php

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