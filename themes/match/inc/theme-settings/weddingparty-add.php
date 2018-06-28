<?php

/*
 * Wedding Party
 *
 * @link http://www.wpexplorer.com/wordpress-theme-options/
 * @link https://clicknathan.com/web-design/create-wordpress-theme-settings-page/
 * @link http://blog.chapagain.com.np/very-simple-add-edit-delete-view-in-php-mysql/
 * @link ****http://www.kodingmadesimple.com/2016/10/simple-crud-operations-php-mysql-example.html
 */

include 'css.php';

include ABSPATH.'wp-config.php';

/*
 * Create new submenu page but don't show it in the dashboard side menu
 * @link https://wordpress.stackexchange.com/questions/73622/add-an-admin-page-but-dont-show-it-on-the-admin-menu
 */
function match_weddingparty_add_page(){
  add_submenu_page( null, __('Wedding Party - Add','match'), __('Wedding Party - Add','match'), 'edit_posts', 'weddingparty-add', 'match_weddingparty_add');
}
add_action('admin_menu', 'match_weddingparty_add_page');

function match_weddingparty_add(){
 	if (!current_user_can('edit_posts')) {
 		wp_die(__('You do not have sufficient permissions to access this page.','match'));
 	} ?>

 	<?php echo
 		'<style>'
 		.$GLOBALS['cssGlobal']
 		.'

 		.wrap .button-secondary{margin:1.5em 0}table{border-collapse:collapse;width:75%}thead th{text-align:center}tbody td{padding:.5em 1em}tbody tr td:nth-child(1){width:25%;min-width:155px}tbody tr td:nth-child(2){width:75%;min-width:155px}tbody label{font-weight:bold}input[type=text],input[type=url],input[type=number]{width:100%}br+span{color:#989898}select,textarea{width:100%}

		@media(max-width:500px){
			table{width:100%}tbody td{float:left}tbody tr td:nth-child(1){width:95%;margin-top:.5em}tbody tr td:nth-child(2){width:95%;margin-top:-.5em}
		}</style>';

		global $wpdb;

		if (isset($_POST['submit'])) {

			// sanitize form values
			$wp_role        = sanitize_text_field( $_POST["wp_role"] );
			$wp_custom_role = sanitize_text_field( $_POST["wp_custom_role"] );
			$wp_name        = sanitize_text_field( $_POST["wp_name"] );
			$wp_pos         = sanitize_text_field( $_POST["wp_pos"] );
			$wp_rel         = esc_textarea( $_POST["wp_rel"] );

			// if Position < 10, add leading 0
	 		if (strlen($wp_pos) < 2) {
				$wp_pos = '0' . $wp_pos;
	 		}

	 		// if Role = 'other', set role to custom value
	 		if ($wp_role == 'other') {
	 			$wp_custom_role = str_replace(' ', '-', str_replace(', ', ',', strtolower($wp_custom_role)));
	 			$wp_role = $wp_custom_role;
	 		}

			$weddingpartyAlert = '';

			if(empty($wp_role)) { // error out if role field is blank

				$weddingpartyAlert = '<div id="message" class="error notice is-dismissible"><p>Wedding party member not added. Missing <strong>Role</strong>. Please try again.</p></div>';

			} elseif (empty($wp_name)) { // error out if name field is blank

				$weddingpartyAlert = '<div id="message" class="error notice is-dismissible"><p>Wedding party member not added. Missing <strong>Name</strong>. Please try again.</p></div>';

			} elseif (empty($wp_pos)) { // error out if name field is blank

				$weddingpartyAlert = '<div id="message" class="error notice is-dismissible"><p>Wedding party member not added. Missing <strong>Position</strong>. Please try again.</p></div>';

			} else {

				$weddingpartyTable = $wpdb->prefix.'weddingparty';

				$data = array(
					'role'         => $wp_role,
					'name'         => $wp_name,
					'position'     => $wp_pos,
					'relationship' => $wp_rel
				);

				$format = array(
					'%s',
					'%s',
					'%s',
					'%s'
				);

				$success=$wpdb->insert( $weddingpartyTable, $data, $format );

				if($success) {
					$weddingpartyAlert = '<div id="message" class="updated notice is-dismissible"><p>Wedding party member added successfully!</p></div>';
				} else {
					$weddingpartyAlert = '<div id="message" class="error is-dismissible"><p>Wedding party member not added. Please try again.</p></div>';
				}

			}
		}

 	?>

 		<div class="wrap">
	 		<h1>ZKEngstrom</h1>
	 		<?php echo $weddingpartyAlert; ?>
	 		<h2>Wedding Party - Add</h2>
	 		<hr>

			<a href="<?php echo get_admin_url(); ?>admin.php?page=weddingparty" class="button button-secondary">&lt; Back</a>

			<form action="./admin.php?page=weddingparty-add" method="post">

				<table>
					<tr>
						<td>
							<label for="wp_role">Role</label>
						</td>
						<td>
							<!--input type="text" name="wp_role" id="wp_role"-->
							<select id="wp_role" name="wp_role">
								<option value="">-- Select One --</option>
								<option value="bride">Bride</option>
								<option value="groom">Groom</option>
								<option value="maid-of-honor">Maid of Honor</option>
								<option value="best-man">Best Man</option>
								<option value="bridesmaid">Bridesmaid</option>
								<option value="groomsman">Groomsman</option>
								<option value="junior-groomsman">Junior Groomsman</option>
								<option value="ring-bearer">Ring Bearer</option>
								<option value="other">Other</option>
							</select>
						</td>
					</tr>
					<tr class="wp-custom-role">
						<td>
							<label for="wp_custom_role">Custom Role</label>
							<br>
							<span>Ex: Usher, Ring bearer, etc.</span>
						</td>
						<td>
							<input type="text" name="wp_custom_role" id="wp_custom_role">
						</td>
					</tr>
					<tr>
						<td>
							<label for="wp_name">Name</label>
							<br>
							<span>First and last</span>
						</td>
						<td>
							<input type="text" name="wp_name" id="wp_name">
						</td>
					</tr>
					<tr>
						<td>
							<label for="wp_pos">Position</label>
							<br>
							<span>Ex: Bride = 1, Groom = 2, Maid of Honor = 3, Best Man = 4, etc...</span>
						</td>
						<td>
							<input type="number" name="wp_pos" id="wp_pos">
						</td>
					</tr>
					<tr>
						<td>
							<label for="wp_rel">Relationship</label>
							<br>
							<span>Ex: Friend of the bride.</span>
						</td>
						<td>
							<textarea id="wp_rel" name="wp_rel" rows="3"></textarea>
						</td>
					</tr>
				</table>
				<p class="submit">
					<input type="submit" name="submit" value="Submit" class="button button-primary" />
				</p>
			</form>
		</div>

		<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/js/jquery.min.js?ver=3.3.1'></script>
		<script>
			$(".wp-custom-role").hide();
			$('#wp_role').change(function(){
				var roleValue = $(this).val();
				if (roleValue == 'bride' || roleValue == 'groom') {
					$('#wp_rel').text('').val('').prop('readonly', true);
				} else {
					$('#wp_rel').prop('readonly', false);
				}
			    if (roleValue === 'other') {
			        $(".wp-custom-role").show();
			    } else {
			        $(".wp-custom-role").hide();
			    }
			});
		</script>

	<?php
}

