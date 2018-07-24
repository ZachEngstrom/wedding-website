<?php

if (isset($_GET['view-deleted'])) {

	$msgID = $_GET['view-deleted'];

	global $wpdb;
	$guestbook_table_name = $wpdb->prefix.'matchguestbook';
	$guestbookResults = $wpdb->get_results( "SELECT * FROM $guestbook_table_name WHERE `id` = $msgID");
	date_default_timezone_set('America/Chicago');

	// Update database when message is clicked on
	$markReadData = array(
		'unread' => '0'
	);
	$markReadFormat = array(
		'id' => $msgID
	);
	$wpdb->update( $guestbook_table_name, $markReadData, $markReadFormat );

	// When "Delete" button clicked update database
	if (isset($_POST['submitUndelete'])) {
		global $wpdb;
		$table_name = $wpdb->prefix.'matchguestbook';
		$success = $wpdb->update(
			$table_name,
			array(
				'approved' => '0',
			),
			array( 'id' => $msgID ),
			array(
				'%d'	// value2
			),
			array( '%d' )
		);

		if ($success) {
			$cfURL = get_admin_url() . 'admin.php?page=match-guestbook-form.php';
			echo '<script>window.location.replace("'.$cfURL.'");</script>';
			die();
		} else {
			echo '<script>alert("Error: '.$wpdb->last_error.'");</script>';
		}
	}

	?>
	<div class="wrap" id="guestbook-results">

		<h2>View Comment/Question</h2>

		<div id="indMSG">
			<?php

				foreach ($guestbookResults as $guestbookResult) {

					$approvedStatus = ($guestbookResult->approved == "0") ? "<span class=\"dashicons dashicons-clock\"></span>" : ( ($guestbookResult->approved == "1") ? "<span class=\"dashicons dashicons-thumbs-up\"></span>" : ( ($guestbookResult->approved == "2") ? "<span class=\"dashicons dashicons-thumbs-down\"></span>" : "unknown" ) );

			?>
				<div class="button-row">
					<a href="<?php echo get_admin_url(); ?>admin.php?page=match-guestbook-form.php" class="button button-primary button-back">&#9664; Back</a>
					<form action="" method="post">
						<button type="submit" name="submitUndelete" id="submitUndelete" class="button button-primary"><span class="dashicons dashicons-clock"></span> Undelete</button>
					</form>

				</div>
				<div style="margin:1rem 0"><?php echo get_avatar( $guestbookResult->email, 150 ); ?></div>
				<h3>
					<strong>Status:</strong>
					<span><?php echo $approvedStatus; ?></span>
				</h3>
				<h3>
					<strong>From:</strong>
					<span>
						<a href="mailto:<?php echo $guestbookResult->email; ?>"><?php echo $guestbookResult->firstName . ' ' . $guestbookResult->lastName; ?></a>
					</span>
				</h3>
				<h3>
					<strong>Date:</strong>
					<span><?php echo date("F j\, Y \@ g:ia", substr($guestbookResult->date, 0, 10)); ?></span>
				</h3>
				<div class="msgText"><?php echo stripslashes(nl2br($guestbookResult->message)); ?></div>
			<?php

				}

			?>
		</div>

	</div>
	<?php
}