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
function match_weddingparty_delete_page(){
  add_submenu_page( null, __('Wedding Party - Delete','match'), __('Wedding Party - Delete','match'), 'edit_posts', 'weddingparty-delete', 'match_weddingparty_delete');
}
add_action('admin_menu', 'match_weddingparty_delete_page');

function match_weddingparty_delete(){
 	if (!current_user_can('edit_posts')) {
 		wp_die(__('You do not have sufficient permissions to access this page.','match'));
 	} ?>

 	<?php echo
 		'<style>'
 		.$GLOBALS['cssGlobal']
 		.'

 		.wrap .button-secondary{margin:1.5em 0}table{border-collapse:collapse;width:75%}thead th{text-align:center}tbody td{padding:.5em 1em}tbody tr td:nth-child(1){width:25%;min-width:155px}tbody tr td:nth-child(2){width:75%;min-width:155px}tbody label{font-weight:bold}input[type=text],input[type=url]{width:100%}.wp-core-ui .button-primary.delete{background:#B21231;border-color:#B21225 #B21224 #B21224;box-shadow:0 1px 0 #B21224;text-shadow:0 -1px 1px #B21224,1px 0 1px #B21224,0 1px 1px #B21224,-1px 0 1px #B21224}br+span{color:#989898}select,textarea{width:100%}

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
			$wp_id = sanitize_text_field( $_POST["wp_id"] );

			$weddingpartyTable = $wpdb->prefix.'weddingparty';

			$where = array(
				'id' => $wp_id,
			);

			$where_format = array(
				'%d'
			);

			$success=$wpdb->delete( $weddingpartyTable, $where, $where_format );

			$weddingpartyAlert = '';

			if($success) {
				$weddingpartyAlert = '<div id="message" class="updated notice is-dismissible"><p>Wedding party member successfully deleted!</p></div>';
				echo '<script>window.location.href="'.get_admin_url().'admin.php?page=weddingparty&weddingparty_deleted='.$wp_id.'";</script>';
			} else {
				$weddingpartyAlert = '<div id="message" class="error is-dismissible"><p>Wedding party member not deleted. Please try again.</p></div>';
			}
		}

 	?>

 		<div class="wrap">
	 		<h1>ZKEngstrom</h1>
	 		<?php echo $weddingpartyAlert; ?>
	 		<h2>Wedding Party - <span style="color:#DC3232;text-transform:uppercase">Delete</span></h2>
	 		<hr>

			<a href="<?php echo get_admin_url(); ?>admin.php?page=weddingparty" class="button button-secondary">&lt; Back</a>

			<form action="./admin.php?page=weddingparty-delete" method="post">
				<table>
					<tr style="display:none">
						<td>
							<label for="wp_id">ID</label>
						</td>
						<td>
							<input type="hidden" name="wp_id" id="wp_id" value="<?php if(isset($db_wp_id)) { echo $db_wp_id; } ?>" readonly>
						</td>
					</tr>
					<tr>
						<td>
							<label for="wp_role">Role</label>
						</td>
						<td>
							<select id="wp_role" name="wp_role" disabled>
								<option value="" <?php echo ($db_wp_role == '') ? 'selected' : ''; ?>>-- Select One --</option>
								<option value="bride" <?php echo ($db_wp_role == 'bride') ? 'selected' : ''; ?>>Bride</option>
								<option value="groom" <?php echo ($db_wp_role == 'groom') ? 'selected' : ''; ?>>Groom</option>
								<option value="maid-of-honor" <?php echo ($db_wp_role == 'maid-of-honor') ? 'selected' : ''; ?>>Maid of Honor</option>
								<option value="best-man" <?php echo ($db_wp_role == 'best-man') ? 'selected' : ''; ?>>Best Man</option>
								<option value="bridesmaid" <?php echo ($db_wp_role == 'bridesmaid') ? 'selected' : ''; ?>>Bridesmaid</option>
								<option value="groomsman" <?php echo ($db_wp_role == 'groomsman') ? 'selected' : ''; ?>>Groomsman</option>
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
							<input type="text" name="wp_custom_role" id="wp_custom_role" value="<?php if(isset($db_wp_role)) { echo $db_wp_role; } ?>" disabled>
						</td>
					</tr>
					<tr>
						<td>
							<label for="wp_name">Name</label>
							<br>
							<span>First and last</span>
						</td>
						<td>
							<input type="text" name="wp_name" id="wp_name" value="<?php if(isset($db_wp_name)) { echo $db_wp_name; } ?>" disabled>
						</td>
					</tr>
					<tr>
						<td>
							<label for="wp_pos">Position</label>
							<br>
							<span>Ex: Bride = 1, Groom = 2, Maid of Honor = 3, Best Man = 4, etc...</span>
						</td>
						<td>
							<input type="text" name="wp_pos" id="wp_pos" value="<?php if(isset($db_wp_position)) { echo str_replace('\\', '', $db_wp_position); } ?>" disabled>
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
							<textarea id="wp_rel" name="wp_rel" rows="3" <?php echo $readOnly; ?> disabled><?php if(isset($db_wp_relationship)) { echo $db_wp_relationship; } ?></textarea>
						</td>
					</tr>
				</table>
				<p class="submit">
					<input type="submit" name="submit" value="Delete" class="button button-primary delete" />
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
			    if (roleValue === 'other') {
			        $(".wp-custom-role").show();
			    } else {
			        $(".wp-custom-role").hide();
			    }
			});
		</script>

	<?php
}

