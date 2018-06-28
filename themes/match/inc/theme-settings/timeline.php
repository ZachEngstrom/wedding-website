<?php

/*
 * Timeline
 *
 * @link http://www.wpexplorer.com/wordpress-theme-options/
 * @link https://clicknathan.com/web-design/create-wordpress-theme-settings-page/
 */

include 'css.php';

include ABSPATH.'wp-config.php';

function match_timeline_page(){
  add_submenu_page( 'match-theme-settings', __('Timeline','match'), __('Timeline','match'), 'edit_posts', 'timeline', 'match_timeline');
}
add_action('admin_menu', 'match_timeline_page');

function match_timeline(){
 	if (!current_user_can('edit_posts')) {
 		wp_die(__('You do not have sufficient permissions to access this page.','match'));
 	} ?>

 	<?php echo
 		'<style>'
 		.$GLOBALS['cssGlobal']
 		.'.wrap .button-secondary{margin:1em 0 1.5em}table{border-collapse:collapse}thead th,tbody td{padding:.5em 1em;vertical-align:middle}.timeline-list tbody tr:nth-child(odd){background-color:rgba(0,0,0,.05)}.wrap td .button-secondary{margin:0}thead th:nth-child(n+6):nth-child(-n+9),tbody td:nth-child(n+6):nth-child(-n+9){display:none}tbody tr.update-error{background-color:rgba(220,50,50,.3)}.striped tbody tr.update-success,.timeline-list.striped tbody tr.update-success:hover{background-color:rgba(70,180,80,.3)}.wp-core-ui .button-primary.excel{background:#217346;border-color:#217346 #217346 #217346;box-shadow:0 1px 0 #217346;text-shadow:0 -1px 1px #217346,1px 0 1px #217346,0 1px 1px #217346,-1px 0 1px #217346}form.form-excel{float:right;margin-top:1em}form.form-excel~form.form-excel{margin-right:1em}.widefat thead tr th{font-weight:bold}.widefat tbody td{border:1px solid #e1e1e1;padding:.25rem;vertical-align:middle}.widefat thead td,.widefat thead th{border:1px solid #e1e1e1;border-bottom:2px solid #e1e1e1}.widefat tbody tr:hover{background-color:#efefef}.widefat tbody td.text-center{text-align:center}.widefat tbody td.text-center .dashicons{margin-top:0.1875rem}tbody label{font-weight:bold}input[type=text],input[type=url],input[type=number],input[type=date]{width:100%}br+span{color:#989898}select,textarea{width:100%}table.timeline-add,table.timeline-edit,table.timeline-delete{border-collapse:collapse;width:75%}.button.button-danger{background:#DC3232;border-color:#b02828 #841e1e #841e1e;box-shadow:0 1px 0 #841e1e;color:#fff;text-decoration:none;text-shadow:0 0 0 #841e1e,0 0 0 #841e1e}.button.button-danger:hover{background:#df4646;border-color:#841e1e;color:#fff}.aligncenter{clear:both;display:block;margin:0 auto !important}.alignright{display:inline;float:right;margin:0 0 15px 15px !important}.alignleft{display:inline;float:left;margin:0 15px 15px 0 !important}img{height:auto}td:nth-child(3) img{max-width:10rem}</style>';

		global $wpdb;

		$dbTableTimeline = $GLOBALS['wpdb']->get_results( 'SELECT * FROM '.$wpdb->prefix.'timeline ORDER BY `date` ASC' );

		if (isset($_GET['timeline_updated'])) {
		 	$timelineAlert = '<div id="message" class="updated notice is-dismissible"><p>Timeline item updated successfully!</p></div>';
		} else if (isset($_GET['timeline_not_updated'])) {
			$timelineAlert = '<div id="message" class="error notice is-dismissible"><p>Timeline item not updated. Please try again.</p></div>';
		} else if (isset($_GET['timeline_deleted'])) {
		 	$timelineAlert = '<div id="message" class="updated notice is-dismissible"><p>Timeline item deleted successfully!</p></div>';
		} else if (isset($_GET['timeline_not_deleted'])) {
			$timelineAlert = '<div id="message" class="error notice is-dismissible"><p>Timeline item not deleted. Please try again.</p></div>';
		} else if (isset($_GET['timeline_created'])) {
		 	$timelineAlert = '<div id="message" class="updated notice is-dismissible"><p>Timeline item created successfully!</p></div>';
		} else if (isset($_GET['timeline_not_created'])) {
			$timelineAlert = '<div id="message" class="error notice is-dismissible"><p>Timeline item not created. Please try again.</p></div>';
		} else {
			$timelineAlert = '';
		}

		if (empty($dbTableTimeline)) {


			// Create the table in the database if it doesn't already exist
			$table_name = $wpdb->prefix.'timeline';
			if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
				//table not in database. Create new table
				$charset_collate = $wpdb->get_charset_collate();

				$sql = "CREATE TABLE $table_name (
					`id` mediumint(9) NOT NULL AUTO_INCREMENT,
					`date` int(20) NOT NULL,
					`title` varchar(255) NOT NULL,
					`story` text NOT NULL,
					PRIMARY KEY (`id`)
					) $charset_collate;";
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql );
			}

		}


		require get_template_directory() . '/inc/theme-settings/timeline/add-db.php';
		require get_template_directory() . '/inc/theme-settings/timeline/edit-db.php';
		require get_template_directory() . '/inc/theme-settings/timeline/delete-db.php';


		$current_user = wp_get_current_user();
		$currentUserEmail = $current_user->user_email;

 	?>

 		<div class="wrap">
	 		<h1>ZKEngstrom</h1>
	 		<?php echo $timelineAlert; ?>
	 		<h2>Timeline</h2>
	 		<hr>


			<?php

			if (isset($_GET['edit-item'])) {
				require get_template_directory() . '/inc/theme-settings/timeline/edit-view.php';
			} else if (isset($_GET['add-item'])) {
				require get_template_directory() . '/inc/theme-settings/timeline/add-view.php';
			} else if (isset($_GET['delete-item'])) {
				require get_template_directory() . '/inc/theme-settings/timeline/delete-view.php';
			} else {
				require get_template_directory() . '/inc/theme-settings/timeline/default-view.php';
			}

			?>


	 	</div>

 	<?php
}



// <table class="wp-list-table widefat fixed striped users">
// 	<thead>
// 		<tr>
// 			<td id="cb" class="manage-column column-cb check-column"><label class="sr-only" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
// 			<th scope="col" id="username" class="manage-column column-username column-primary sortable desc"><a href="http://localhost/playground/ZKEngstrom/wp-admin/users.php?orderby=login&amp;order=asc"><span>Username</span><span class="sorting-indicator"></span></a></th>
// 			<th scope="col" id="name" class="manage-column column-name">Name</th>
// 			<th scope="col" id="email" class="manage-column column-email sortable desc"><a href="http://localhost/playground/ZKEngstrom/wp-admin/users.php?orderby=email&amp;order=asc"><span>Email</span><span class="sorting-indicator"></span></a></th>
// 			<th scope="col" id="role" class="manage-column column-role">Role</th>
// 			<th scope="col" id="posts" class="manage-column column-posts num">Posts</th>
// 		</tr>
// 	</thead>
// 	<tbody id="the-list" data-wp-lists="list:user">
// 		<tr id="user-1">
// 			<th scope="row" class="check-column"><label class="sr-only" for="user_1">Select engza</label><input type="checkbox" name="users[]" id="user_1" class="administrator" value="1"></th>
// 			<td class="username column-username has-row-actions column-primary" data-colname="Username">
// 				<img alt="" src="http://0.gravatar.com/avatar/6b5b07e37f93c81dbcade7e152423a48?s=32&amp;d=mm&amp;r=g" srcset="http://0.gravatar.com/avatar/6b5b07e37f93c81dbcade7e152423a48?s=64&amp;d=mm&amp;r=g 2x" class="avatar avatar-32 photo" height="32" width="32"> <strong><a href="http://localhost/playground/ZKEngstrom/wp-admin/profile.php?wp_http_referer=%2Fplayground%2FZKEngstrom%2Fwp-admin%2Fusers.php">engza</a></strong><br>
// 				<div class="row-actions"><span class="edit"><a href="http://localhost/playground/ZKEngstrom/wp-admin/profile.php?wp_http_referer=%2Fplayground%2FZKEngstrom%2Fwp-admin%2Fusers.php">Edit</a> | </span><span class="view"><a href="http://localhost/playground/ZKEngstrom/blog/author/engza/" aria-label="View posts by engza">View</a></span></div>
// 				<button type="button" class="toggle-row"><span class="sr-only">Show more details</span></button>
// 			</td>
// 			<td class="name column-name" data-colname="Name"><span aria-hidden="true">—</span><span class="sr-only">Unknown</span></td>
// 			<td class="email column-email" data-colname="Email"><a href="mailto:engstrom.zach@gmail.com">engstrom.zach@gmail.com</a></td>
// 			<td class="role column-role" data-colname="Role">Administrator</td>
// 			<td class="posts column-posts num" data-colname="Posts"><a href="edit.php?author=1" class="edit"><span aria-hidden="true">1</span><span class="sr-only">1 post by this author</span></a></td>
// 		</tr>
// 	</tbody>
// 	<tfoot>
// 		<tr>
// 			<td class="manage-column column-cb check-column"><label class="sr-only" for="cb-select-all-2">Select All</label><input id="cb-select-all-2" type="checkbox"></td>
// 			<th scope="col" class="manage-column column-username column-primary sortable desc"><a href="http://localhost/playground/ZKEngstrom/wp-admin/users.php?orderby=login&amp;order=asc"><span>Username</span><span class="sorting-indicator"></span></a></th>
// 			<th scope="col" class="manage-column column-name">Name</th>
// 			<th scope="col" class="manage-column column-email sortable desc"><a href="http://localhost/playground/ZKEngstrom/wp-admin/users.php?orderby=email&amp;order=asc"><span>Email</span><span class="sorting-indicator"></span></a></th>
// 			<th scope="col" class="manage-column column-role">Role</th>
// 			<th scope="col" class="manage-column column-posts num">Posts</th>
// 		</tr>
// 	</tfoot>
// </table>