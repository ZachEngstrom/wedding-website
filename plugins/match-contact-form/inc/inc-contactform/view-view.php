<?php

if (isset($_GET['view'])) {

	$msgID = $_GET['view'];

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

	// When "Mark Unread" button clicked update database
	if (isset($_POST['submitUnread'])) {
		global $wpdb;
		$table_name = $wpdb->prefix.'matchcontactform';
		$success = $wpdb->update(
			$table_name,
			array(
				'unread' => '1',
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

	// When "Delete" button clicked update database
	if (isset($_POST['submitDelete'])) {
		global $wpdb;
		$table_name = $wpdb->prefix.'matchcontactform';
		$success = $wpdb->update(
			$table_name,
			array(
				'deleted' => 1,
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
						<input type="submit" name="submitDelete" id="submitDelete" value="Delete" class="button button-primary button-red">
					</form>
					<form action="" method="post">
						<input type="submit" name="submitUnread" id="submitUnread" value="Mark Unread" class="button button-primary button-unread">
					</form>

					<?php

						// To
						$replyLinkString = 'mailto:' . $contactResult->firstName . ' ' . $contactResult->lastName . ' &lt;' . $contactResult->email . '&gt;';
						// Response Subject
						$replyLinkString .= '?subject=RE%3A%20' . 'Comment/Question%20on%20ZKEngstrom.com' . '&amp;';
						// Response Template
						$replyLinkString .= 'body=' . $contactResult->firstName . '%2C%0A%0A%5BYour%20response%5D%0A%0AThank%20you%2C%0A%0AZach%20and%20Kelley';
						// From
						$replyLinkString .= '%0A%0A---%0A%0AFrom%3A%20' . $contactResult->firstName . '%20' . $contactResult->lastName . '%20%3C' . str_replace('@', '%40', $contactResult->email) . '%3E%0A';
						// Sent (date)
						$replyLinkString .= 'Sent%3A%20' . str_replace(array(' ', ',', ':'),array('%20', '%2C', '%3A'),date('l\, F d\, Y g:i A', $contactResult->date)) . '%0A';
						// Subject
						$replyLinkString .= 'Subject%3A%20' . 'Comment/Question%20on%20ZKEngstrom.com' . '%0A%0A';
						// Body
						$replyLinkString .= preg_replace( "/\r|\n/", "", str_replace(array(',', '<br />', ' '),array('%2C', '%0A', '%20'),stripslashes(nl2br($contactResult->message))));

						echo '<a href="'.$replyLinkString.'" class="button button-primary button-green">Reply</a>';

					?>

				</div>
				<div style="margin:1rem 0"><?php echo get_avatar( $contactResult->email, 150 ); ?></div>
				<h3>
					<strong>From:</strong>
					<span>
						<a href="mailto:<?php echo $contactResult->email; ?>"><?php echo ucfirst($contactResult->firstName) . ' ' . ucfirst($contactResult->lastName); ?></a>
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