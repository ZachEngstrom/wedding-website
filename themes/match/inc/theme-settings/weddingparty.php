<?php

/*
 * Weddingparty
 *
 * @link http://www.wpexplorer.com/wordpress-theme-options/
 * @link https://clicknathan.com/web-design/create-wordpress-theme-settings-page/
 */

include 'css.php';

include ABSPATH.'wp-config.php';

function match_weddingparty_page(){
  add_submenu_page( 'match-theme-settings', __('Wedding Party','match'), __('Wedding Party','match'), 'edit_posts', 'weddingparty', 'match_weddingparty');
}
add_action('admin_menu', 'match_weddingparty_page');

function match_weddingparty(){
 	if (!current_user_can('edit_posts')) {
 		wp_die(__('You do not have sufficient permissions to access this page.','match'));
 	} ?>

 	<?php echo
 		'<style>'
 		.$GLOBALS['cssGlobal']
 		.'.wrap .button-secondary{margin:1em 0 1.5em}table{border-collapse:collapse}thead th,tbody td{padding:.5em 1em;vertical-align:middle}tbody tr:nth-child(odd){background-color:rgba(0,0,0,.05)}.wrap td .button-secondary{margin:0}thead th:nth-child(n+6):nth-child(-n+9),tbody td:nth-child(n+6):nth-child(-n+9){display:none}tbody tr.update-error{background-color:rgba(220,50,50,.3)}.striped tbody tr.update-success,.striped tbody tr.update-success:hover{background-color:rgba(70,180,80,.3)}.wp-core-ui .button-primary.excel{background:#217346;border-color:#217346 #217346 #217346;box-shadow:0 1px 0 #217346;text-shadow:0 -1px 1px #217346,1px 0 1px #217346,0 1px 1px #217346,-1px 0 1px #217346}form.form-excel{float:right;margin-top:1em}form.form-excel~form.form-excel{margin-right:1em}.widefat thead tr th{font-weight:bold}.widefat tbody td{border:1px solid #e1e1e1;padding:.25rem;vertical-align:middle}.widefat thead td,.widefat thead th{border:1px solid #e1e1e1;border-bottom:2px solid #e1e1e1}.widefat tbody tr:hover{background-color:#efefef}.widefat tbody td.text-center{text-align:center}.widefat tbody td.text-center .dashicons{margin-top:0.1875rem}</style>';

		global $wpdb;

		$DBTableWeddingparty = $GLOBALS['wpdb']->get_results( 'SELECT * FROM '.$wpdb->prefix.'weddingparty ORDER BY `position`' );

		if (isset($_GET['weddingparty_updated'])) {
		 	$weddingpartyAlert = '<div id="message" class="updated notice is-dismissible"><p>Wedding party member updated successfully!</p></div>';
		} else if (isset($_GET['weddingparty_not_updated'])) {
			$weddingpartyAlert = '<div id="message" class="error notice is-dismissible"><p>Wedding party member not updated. Please try again.</p></div>';
		} else if (isset($_GET['weddingparty_deleted'])) {
		 	$weddingpartyAlert = '<div id="message" class="updated notice is-dismissible"><p>Wedding party member deleted successfully!</p></div>';
		} else if (isset($_GET['weddingparty_not_deleted'])) {
			$weddingpartyAlert = '<div id="message" class="error notice is-dismissible"><p>Wedding party member not deleted. Please try again.</p></div>';
		} else {
			$weddingpartyAlert = '';
		}

		if (empty($DBTableWeddingparty)) {


			// Create the table in the database if it doesn't already exist
			$table_name = $wpdb->prefix.'weddingparty';
			if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
				//table not in database. Create new table
				$charset_collate = $wpdb->get_charset_collate();

				$sql = "CREATE TABLE $table_name (
					`id` mediumint(9) NOT NULL AUTO_INCREMENT,
					`role` varchar(255) NOT NULL,
					`name` varchar(255) NOT NULL,
					`relationship` text NOT NULL,
					`position` varchar(255) NOT NULL,
					PRIMARY KEY (`id`)
					) $charset_collate;";
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql );
			}

		}

		$current_user = wp_get_current_user();
		$currentUserEmail = $current_user->user_email;

 	?>

 		<div class="wrap">
	 		<h1>ZKEngstrom</h1>
	 		<?php echo $weddingpartyAlert; ?>
	 		<h2>Wedding Party</h2>
	 		<hr>

			<a href="<?php echo get_admin_url(); ?>admin.php?page=weddingparty-add" class="button button-secondary">+ Add Wedding Party Member</a>

			<table class="wp-list-table widefat fixed striped users">
				<thead>
					<tr>
						<th style="width:2rem;text-align:center">#</th>
						<th>Wedding Party Member</th>
						<th>Role</th>
						<th>Relationship</th>
						<th style="width:3rem;text-align:center">Edit</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$i = 0;
					foreach ($DBTableWeddingparty as $weddingparty => $row) {

						// add 1 to the counter
						$i++;

						$wp_role = ucwords( str_replace(',', ', ', str_replace('-', ' ', $row->role)));

						// Set variable to add a class to the row of an updated or deleted wedding party
						if ($_GET['weddingparty_updated'] == $row->id) {
							$updatedClass = ' class="update-success"';
						} else if ($_GET['weddingparty_not_updated'] == $row->id) {
							$updatedClass = ' class="update-error"';
						} else if ($_GET['weddingparty_not_deleted'] == $row->id) {
							$updatedClass = ' class="update-error"';
						} else {
							$updatedClass = '';
						}

						if ($wp_role == 'Bride' || $wp_role == 'Groom') {
							$wp_relationship = '';
						} else {
							$wp_relationship = $row->relationship;
						}

						echo '
							<tr'.$updatedClass.'>
								<td class="text-center">'.$row->position.'</td>
								<td>'.$row->name.'</td>
								<td>'.$wp_role.'</td>
								<td>'.$wp_relationship.'</td>
								<td class="text-center"><a href="'.get_admin_url().'admin.php?page=weddingparty-edit&member='.$row->id.'" class="button button-primary"><span class="dashicons dashicons-edit"></span></a></td>
							</tr>
						';

					}
				?>
				</tbody>
			</table>
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