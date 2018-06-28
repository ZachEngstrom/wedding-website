<?php

/*
 * CTA Button Shortcode Declaration
 * [cta-btn]
 * @link https://github.com/MWDelaney/bootstrap-3-shortcodes/blob/master/bootstrap-shortcodes.php
 */
function match_shortcode_rsvpform($atts, $content = null) {

	// Create the table in the database if it doesn't already exist
	global $wpdb;
	$table_name = $wpdb->prefix.'rsvpform';
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		//table not in database. Create new table
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
			`name_first` varchar(255) NOT NULL,
			`name_last` varchar(255) NOT NULL,
			`attending` varchar(15) NOT NULL,
			`meal_main` varchar(255) NOT NULL,
			`meal_side` varchar(255) NOT NULL,
			`song_req` text NOT NULL,
			`message` text NOT NULL,
			`date` varchar(255) NOT NULL,
			`unread` varchar(15) NOT NULL,
			PRIMARY KEY (`id`)
			) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	if (isset($_POST['submit'])) {

		// sanitize form values
		$guest_count = sanitize_text_field( $_POST["guest_count"] );

		for ( $i = 1; $i < $guest_count+1; $i++) {

			$name_first = sanitize_text_field( $_POST["rsvp_fn_".$i] );
			$name_last  = sanitize_text_field( $_POST["rsvp_ln_".$i] );
			$attending  = sanitize_text_field( $_POST["attending_".$i] );
			$meal_main  = sanitize_text_field( $_POST["rsvp_mm_".$i] );
			$meal_side  = sanitize_text_field( $_POST["rsvp_sm_".$i] );

			if ($i == 1) {
				$song_req = esc_textarea( $_POST["rsvp_sr"] );
				$message  = esc_textarea( $_POST["rsvp_notes"] );
			} else {
				$song_req = '';
				$message  = '';
			}

			$date        = time();
			$unread      = 1;

			$data = array(
				'name_first' => $name_first,
				'name_last'  => $name_last,
				'attending'  => $attending,
				'meal_main'  => $meal_main,
				'meal_side'  => $meal_side,
				'song_req' => $song_req,
				'message' => $message,
				'date' => $date,
				'unread' => $unread
			);

			$success=$wpdb->insert( $table_name, $data );

			if($success) {
				//echo '<div id="message" class="updated notice is-dismissible"><p>Wedding party member added successfully!</p></div>';
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'.$name_first.'\'s RSVP was received successfully!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><style>form#form_rsvp{display:none}</style>';
			} else {
				//echo '<div id="message" class="error is-dismissible"><p>Wedding party member not added. Please try again.</p></div>';
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Oops! Your RSVP was <strong>NOT</strong> received. Something went wrong. Please try again!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
			}
   		}

	}

	global $wp;
	$currentURL = home_url( $wp->request );

$rsvpform = '

<form id="form_rsvp" action="'.$currentURL.'" method="post">

	<div class="form-group row" style="display:none">
		<label for="guest_count" class="col-md-4 col-lg-3 col-form-label">Guest Count</label>
		<div class="col-md-8 col-lg-9"><input type="number" class="form-control" id="guest_count" name="guest_count" value="1"></div>
	</div>

	<div class="card mt-4" id="row1">
		<div class="card-header h4">Guest #1</div>
		<div class="card-body">
			<div class="row">
				<div class="form-group col-12 col-sm-6">
					<label for="rsvp_fn_1" class="col-form-label">First Name <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="rsvp_fn_1" name="rsvp_fn_1">
				</div>
				<div class="form-group col-12 col-sm-6">
					<label for="rsvp_ln_1" class="col-form-label">Last Name <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="rsvp_ln_1" name="rsvp_ln_1">
				</div>
				<div class="form-group col-12 col-sm-6 col-md-4">
					<label for="attending_1" class="col-form-label">Attending? <span class="text-danger">*</span></label>
					<select class="form-control" id="attending_1" name="attending_1">
						<option value="">-- Select --</option>
						<option value="1">Yes</option>
						<option value="0">No</option>
					</select>
				</div>
				<div class="form-group col-12 col-sm-6 col-md-4">
					<label for="rsvp_mm_1" class="col-form-label">Meal Main <span class="text-primary">*</span></label>
					<select class="form-control" id="rsvp_mm_1" name="rsvp_mm_1">
						<option value="">-- Select --</option>
						<option value="mm1">Main Meal 1</option>
						<option value="mm2">Main Meal 2</option>
					</select>
				</div>
				<div class="form-group col-12 col-sm-6 col-md-4">
					<label for="rsvp_sm_1" class="col-form-label">Side Meal <span class="text-primary">*</span></label>
					<select class="form-control" id="rsvp_sm_1" name="rsvp_sm_1">
						<option value="">-- Select --</option>
						<option value="sm1">Side Meal 1</option>
						<option value="sm2">Side Meal 2</option>
					</select>
				</div>
			</div>
		</div>
	</div>

	<div class="row mb-4">
		<div class="col-12"><span class="text-danger">*</span> = Required</div>
		<div class="col-12"><span class="text-primary">*</span> = Only required if attending</div>
	</div>

	<div class="row">
		<div class="col-12">
			<span class="btn btn-primary float-left" id="addOne">
				<i class="fa fa-plus" aria-hidden="true"></i> Add Guest
			</span>
			<span class="text-muted d-inline-block mt-2">
				<i class="fa fa-arrow-left ml-2 d-none d-md-inline-block" aria-hidden="true"></i><i class="fa fa-arrow-up ml-2 d-md-none" aria-hidden="true"></i> Click to add your +1 or members of your family/group
			</span>
		</div>
	</div>

	<h2 class="mt-5">Help us out...</h2>

	<div class="my-4">
		<div class="form-group row">
			<label for="rsvp_sr" class="col-md-4 col-lg-3 col-form-label">Song Request(s)</label>
			<div class="col-md-8 col-lg-9">
				<textarea class="form-control" id="rsvp_sr" name="rsvp_sr" rows="3"></textarea>
			</div>
		</div>
		<div class="form-group row">
			<label for="rsvp_notes" class="col-md-4 col-lg-3 col-form-label">Notes</label>
			<div class="col-md-8 col-lg-9">
				<textarea class="form-control" id="rsvp_notes" name="rsvp_notes" rows="3"></textarea>
				<small id="rsvp_notes_help" class="form-text text-muted">Dietary restrictions, questions/concerns, etc.</small>
			</div>
		</div>
	</div>
	<div class="mt-5">
		<input type="submit" class="btn btn-success float-right" name="submit" value="Submit">
	</div>
</form>

';


	return $rsvpform;

}
add_shortcode('rsvpform', 'match_shortcode_rsvpform');