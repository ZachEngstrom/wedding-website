<?php

if (isset($_GET['view-deleted'])) {

	$msgID = $_GET['view-deleted'];

	global $wpdb;
	$contact_table_name = $wpdb->prefix.'matchcontactform';
	$contactResults = $wpdb->get_results( "SELECT * FROM $contact_table_name WHERE `id` = $msgID");
	date_default_timezone_set('America/Chicago');

	// Update database when message is clicked on
	$markReadData = array(
		'unread' => '0'
	);
	$markReadFormat = array(
		'id' => $msgID
	);
	$wpdb->update( $contact_table_name, $markReadData, $markReadFormat );

	// When "Delete" button clicked update database
	if (isset($_POST['submitUndelete'])) {
		global $wpdb;
		$table_name = $wpdb->prefix.'matchcontactform';
		$success = $wpdb->update(
			$table_name,
			array(
				'deleted' => '0',
			),
			array( 'id' => $msgID ),
			array(
				'%d'	// value2
			),
			array( '%d' )
		);

		if ($success) {
			$cfURL = get_admin_url() . 'admin.php?page=match-contact-form.php';
			echo '<script>window.location.replace("'.$cfURL.'");</script>';
			die();
		} else {
			echo '<script>alert("Error: '.$wpdb->last_error.'");</script>';
		}
	}

	?>
	<div class="wrap" id="contact-results">

		<h2>View Comment/Question</h2>

		<div id="indMSG">
			<?php

				foreach ($contactResults as $contactResult) {

			?>
				<div class="button-row">
					<a href="<?php echo get_admin_url(); ?>admin.php?page=match-contact-form.php" class="button button-primary button-back">&#9664; Back</a>
					<form action="" method="post">
						<input type="submit" name="submitUndelete" id="submitUndelete" value="Undelete" class="button button-primary button-green">
					</form>

				</div>
				<div style="margin:1rem 0"><?php echo get_avatar( $contactResult->email, 150 ); ?></div>
				<h3>
					<strong>From:</strong>
					<span>
						<a href="mailto:<?php echo $contactResult->email; ?>"><?php echo $contactResult->firstName . ' ' . $contactResult->lastName; ?></a>
					</span>
				</h3>
				<h3>
					<strong>Date:</strong>
					<span><?php echo date("F j\, Y \@ g:ia", substr($contactResult->date, 0, 10)); ?></span>
				</h3>
				<div class="msgText"><?php echo stripslashes(nl2br($contactResult->message)); ?></div>
			<?php

				}

			?>
		</div>

	</div>
	<?php
}