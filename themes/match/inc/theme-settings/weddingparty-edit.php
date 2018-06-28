<?php

/*
 * Wedding Party
 *
 * @link http://www.kodingmadesimple.com/2016/10/simple-crud-operations-php-mysql-example.html
 */

include 'css.php';

include ABSPATH.'wp-config.php';

/*
 * Create new submenu page but don't show it in the dashboard side menu
 * @link https://wordpress.stackexchange.com/questions/73622/add-an-admin-page-but-dont-show-it-on-the-admin-menu
 */
function match_weddingparty_edit_page(){
  add_submenu_page( null, __('Wedding Party - Edit','match'), __('Wedding Party - Edit','match'), 'edit_posts', 'weddingparty-edit', 'match_weddingparty_edit');
}
add_action('admin_menu', 'match_weddingparty_edit_page');

function match_weddingparty_edit(){
 	if (!current_user_can('edit_posts')) {
 		wp_die(__('You do not have sufficient permissions to access this page.','match'));
 	} ?>

 	<?php echo
 		'<style>'
 		.$GLOBALS['cssGlobal']
 		.'

 		.wrap .button-secondary{margin:1.5em 0}table{border-collapse:collapse;width:75%}thead th{text-align:center}tbody td{padding:.5em 1em}tbody tr td:nth-child(1){width:25%;min-width:155px}tbody tr td:nth-child(2){width:75%;min-width:155px}tbody label{font-weight:bold}input[type=text],input[type=url]{width:100%}.wp-core-ui .button-primary.delete{background:#B21231;float:right;border-color:#B21225 #B21224 #B21224;box-shadow:0 1px 0 #B21224;text-shadow:0 -1px 1px #B21224,1px 0 1px #B21224,0 1px 1px #B21224,-1px 0 1px #B21224}br+span{color:#989898}select,textarea{width:100%}

		@media(max-width:500px){
			table{width:100%}tbody td{float:left}tbody tr td:nth-child(1){width:95%;margin-top:.5em}tbody tr td:nth-child(2){width:95%;margin-top:-.5em}
		}</style>';

		global $wpdb;

		if (isset($_GET['member'])) {
			$weddingpartyTable = $wpdb->prefix.'weddingparty';
			foreach( $wpdb->get_results('SELECT * FROM `'.$weddingpartyTable.'` WHERE `id` = '.$_GET['member']) as $wp_key => $db_wp_row) {
				$db_wp_id           = $db_wp_row->id;
				$db_wp_role         = $db_wp_row->role;
				$db_wp_name         = $db_wp_row->name;
				$db_wp_relationship = $db_wp_row->relationship;
				$db_wp_position     = $db_wp_row->position;
			}
		}

		if (isset($_POST['submit'])) {

			// sanitize form values
			$wp_id          = sanitize_text_field( $_POST["wp_id"] );
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

				$weddingpartyAlert = '<div id="message" class="error notice is-dismissible"><p>Wedding party member not updated. Missing <strong>Role</strong>. Please try again.</p></div>';

			} elseif (empty($wp_name)) { // error out if name field is blank

				$weddingpartyAlert = '<div id="message" class="error notice is-dismissible"><p>Wedding party member not updated. Missing <strong>Name</strong>. Please try again.</p></div>';

			} elseif (empty($wp_pos)) { // error out if name field is blank

				$weddingpartyAlert = '<div id="message" class="error notice is-dismissible"><p>Wedding party member not updated. Missing <strong>Position</strong>. Please try again.</p></div>';

			} else {

				$weddingpartyTable = $wpdb->prefix.'weddingparty';

				$data = array(
					'role'         => $wp_role,
					'name'         => $wp_name,
					'position'     => $wp_pos,
					'relationship' => $wp_rel
				);

				$where = array(
					'id' => $wp_id,
				);

				$format = array(
					'%s',
					'%s',
					'%s',
					'%s'
				);

				$where_format = array(
					'%d'
				);

				$success=$wpdb->update( $weddingpartyTable, $data, $where, $format, $where_format );

				if($success) {
					$weddingpartyAlert = '<div id="message" class="updated notice is-dismissible"><p>Wedding party member successfully updated!</p></div>';
					echo '<script>window.location.href="'.get_admin_url().'admin.php?page=weddingparty&weddingparty_updated='.$wp_id.'";</script>';
				} else {
					$weddingpartyAlert = '<div id="message" class="error is-dismissible"><p>Wedding party member not updated. Please try again.</p></div>';
				}

			}
		}

 	?>

 		<div class="wrap">
	 		<h1>ZKEngstrom</h1>
	 		<?php echo $weddingpartyAlert; ?>
	 		<h2>Wedding Party - Edit</h2>
	 		<hr>

			<a href="<?php echo get_admin_url(); ?>admin.php?page=weddingparty" class="button button-secondary">&lt; Back</a>

			<form action="./admin.php?page=weddingparty-edit" method="post">
				<table>
					<tr style="display:none">
						<td>
							<label for="wp_id">ID</label>
						</td>
						<td>
							<input type="hidden" name="wp_id" id="wp_id" value="<?php if(isset($db_wp_id)) { echo $db_wp_id; } ?>">
						</td>
					</tr>
					<tr>
						<td>
							<label for="wp_role">Role</label>
						</td>
						<td>
							<select id="wp_role" name="wp_role">
								<option value="" <?php echo ($db_wp_role == '') ? 'selected' : ''; ?>>-- Select One --</option>
								<option value="bride" <?php echo ($db_wp_role == 'bride') ? 'selected' : ''; ?>>Bride</option>
								<option value="groom" <?php echo ($db_wp_role == 'groom') ? 'selected' : ''; ?>>Groom</option>
								<option value="maid-of-honor" <?php echo ($db_wp_role == 'maid-of-honor') ? 'selected' : ''; ?>>Maid of Honor</option>
								<option value="best-man" <?php echo ($db_wp_role == 'best-man') ? 'selected' : ''; ?>>Best Man</option>
								<option value="bridesmaid" <?php echo ($db_wp_role == 'bridesmaid') ? 'selected' : ''; ?>>Bridesmaid</option>
								<option value="groomsman" <?php echo ($db_wp_role == 'groomsman') ? 'selected' : ''; ?>>Groomsman</option>
								<option value="junior-groomsman" <?php echo ($db_wp_role == 'junior-groomsman') ? 'selected' : ''; ?>>Junior Groomsman</option>
								<option value="ring-bearer" <?php echo ($db_wp_role == 'ring-bearer') ? 'selected' : ''; ?>>Ring Bearer</option>
								<option value="other" <?php echo (!in_array($some_variable, array('','bride','groom','maid-of-honor','best-man','bridesmaid','groomsman'), true )) ? 'selected' : ''; ?>>Other</option>
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
							<?php

							$db_wp_role = ucwords( str_replace(',', ', ', str_replace('-', ' ', $db_wp_role)));

							?>
							<input type="text" name="wp_custom_role" id="wp_custom_role" value="<?php if(isset($db_wp_role)) { echo $db_wp_role; } ?>">
						</td>
					</tr>
					<tr>
						<td>
							<label for="wp_name">Name</label>
							<br>
							<span>First and last</span>
						</td>
						<td>
							<input type="text" name="wp_name" id="wp_name" value="<?php if(isset($db_wp_name)) { echo $db_wp_name; } ?>">
						</td>
					</tr>
					<tr>
						<td>
							<label for="wp_pos">Position</label>
							<br>
							<span>Ex: Bride = 1, Groom = 2, Maid of Honor = 3, Best Man = 4, etc...</span>
						</td>
						<td>
							<input type="text" name="wp_pos" id="wp_pos" value="<?php if(isset($db_wp_position)) { echo str_replace('\\', '', $db_wp_position); } ?>">
						</td>
					</tr>
					<tr>
						<td>
							<label for="wp_rel">Relationship</label>
							<br>
							<span>Ex: Friend of the bride.</span>
						</td>
						<?php

							if ($db_wp_role == 'bride' || $db_wp_role == 'groom') {
								$readOnly = 'readOnly';
							} else {
								$readOnly = '';
							}

						?>
						<td>
							<textarea id="wp_rel" name="wp_rel" rows="3" <?php echo $readOnly; ?>><?php if(isset($db_wp_relationship)) { echo $db_wp_relationship; } ?></textarea>
						</td>
					</tr>
				</table>
				<p class="submit">
					<input type="submit" name="submit" value="Update" class="button button-primary" />
					<a href="<?php echo get_admin_url(); ?>admin.php?page=weddingparty-delete&member=<?php if(isset($db_wp_id)) { echo $db_wp_id; } ?>" class="button button-primary delete">Delete</a>
				</p>
			</form>
		</div>

		<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/js/jquery.min.js?ver=3.3.1'></script>
		<?php

		if (in_array($some_variable, array('','bride','groom','maid-of-honor','best-man','bridesmaid','groomsman'), true )) {
			echo '<script>$(".wp-custom-role").hide();</script>';
		}

		?>
		<script>
			$('#wp_role').change(function(){
				var roleValue = $(this).val();
				if (roleValue == 'bride' || roleValue == 'groom') {
					$('#wp_rel').prop('readonly', true);
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

