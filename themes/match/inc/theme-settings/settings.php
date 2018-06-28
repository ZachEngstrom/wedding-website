<?php

/*
 * Creating Custom Admin Menus
 * @link http://wpsnipp.com/index.php/functions-php/create-custom-add_menu_page-with-add_submenu_page-admin-panel/
 */

include 'css.php';

function theme_options_panel(){
  add_menu_page(__('ZKEngstrom Theme','match'), __('ZKEngstrom Theme','match'), 'edit_posts', 'match-theme-settings', 'match_theme_settings', 'dashicons-admin-settings');
}
add_action('admin_menu', 'theme_options_panel');

function match_theme_settings(){
 	if (!current_user_can('edit_posts')) {
 		wp_die(__('You do not have sufficient permissions to access this page.','match'));
 	} ?>

 	<?php echo
 		'<style>'
 		.$GLOBALS['cssGlobal']
 		.$GLOBALS['cssCollapsible']
 		.$GLOBALS['cssFormTable']
 		.'</style>';

		global $wpdb;

 		if (isset($_POST['submit_settings'])) {

 			// Get value from form
			$match_zke_display_tagline         = sanitize_text_field( $_POST["display_tagline"] );
			$match_zke_wedding_date_time       = sanitize_text_field( $_POST["wedding_date_time"] );
	 		$match_zke_wedding_date_time_epoch = strtotime($match_zke_wedding_date_time) + 18000; // add CST timezone offset to epoch value

	 		if (get_option('display_tagline') != '') { // if option exists, update it
	 			update_option( 'display_tagline', $match_zke_display_tagline );
	 		} else { // if option doesn't exist, create it
	 			add_option( 'display_tagline', $match_zke_display_tagline );
	 		}

	 		if (get_option('wedding_date_time') != '') { // if option exists, update it
	 			update_option( 'wedding_date_time', $match_zke_wedding_date_time );
	 		} else { // if option doesn't exist, create it
	 			add_option( 'wedding_date_time', $match_zke_wedding_date_time );
	 		}
	 		if (get_option('wedding_date_time_epoch') != '') { // if option exists, update it
	 			update_option( 'wedding_date_time_epoch', $match_zke_wedding_date_time_epoch );
	 		} else { // if option doesn't exist, create it
	 			add_option( 'wedding_date_time_epoch', $match_zke_wedding_date_time_epoch );
	 		}

 		}

 	?>

 	<div class="wrap">
 		<h1>ZKEngstrom Theme</h1>
 		<hr>
 		<div class="panel-group">
			<div class="panel">
				<div class="panel-header">Getting Started</div>
				<div class="panel-body">
					<table class="form-table">
						<tbody>
							<tr>
								<th>First Steps</th>
								<td>Test</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div> <!-- /.panel -->
 		</div> <!-- /.panel-group -->
 		<h2 style="font-size:20px">Settings</h2>
 		<form action="./admin.php?page=match-theme-settings" method="post">
 			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">Display Tagline</th>
						<td>
							<input type="radio" name="display_tagline" id="display_tagline_yes" value="1" <?php echo (get_option('display_tagline') == '1') ? 'checked' : ''; ?>>Yes<br>
							<input type="radio" name="display_tagline" id="display_tagline_no" value="0" <?php echo (get_option('display_tagline') == '0') ? 'checked' : ''; ?>>No
							<p class="description" id="display_tagline_description">Choose whether or not you'd like the website's tagline (defined in the <a href="<?php echo get_admin_url();?>options-general.php">Settings</a> page) to be displayed in the header of <strong>every</strong> page/post throughout the website.</p>
						</td>
					</tr>
					<tr>
						<th scope="row">Wedding Date</th>
						<td>
							<input type="datetime-local" name="wedding_date_time" id="wedding_date_time" value="<?php echo get_option('wedding_date_time'); ?>" class="regular-text"> CST
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input type="submit" name="submit_settings" value="Save Changes" class="button button-primary" />
			</p>
 		</form>
 	</div>

	<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/js/jquery.min.js?ver=3.3.1'></script>
	<script>
		$(".wrap .panel-header").click(function() {
			$(this).next(".panel-body").slideToggle();
			$(this).toggleClass('open');
		});
	</script>

 	<?php
}
