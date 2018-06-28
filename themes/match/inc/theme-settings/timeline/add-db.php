<?php

if (isset($_POST['submit_add'])) {

	// sanitize form values
	$timeline_date        = sanitize_text_field( $_POST["timeline_date"] );
	$timeline_title       = sanitize_text_field( $_POST["timeline_title"] );
	$timeline_story       = esc_textarea( $_POST["timeline_story"] );

	$timeline_date = strtotime($timeline_date . ' 17:00:00');

	$timelineAlert = '';

	if(empty($timeline_date)) { // error out if role field is blank

		$timelineAlert = '<div id="message" class="error notice is-dismissible"><p>Timeline item not added. Missing <strong>Date</strong>. Please try again.</p></div>';

	} elseif (empty($timeline_title)) { // error out if name field is blank

		$timelineAlert = '<div id="message" class="error notice is-dismissible"><p>Timeline item not added. Missing <strong>Title</strong>. Please try again.</p></div>';

	} elseif (empty($timeline_story)) { // error out if name field is blank

		$timelineAlert = '<div id="message" class="error notice is-dismissible"><p>Timeline item not added. Missing <strong>Story</strong>. Please try again.</p></div>';

	} else {

		$dbTableTimelineAdd = $wpdb->prefix.'timeline';

		$data = array(
			'date'  => $timeline_date,
			'title' => $timeline_title,
			'story' => $timeline_story
		);

		$format = array(
			'%d',
			'%s',
			'%s'
		);

		$success=$wpdb->insert( $dbTableTimelineAdd, $data, $format );

		if($success) {
			echo '<script>window.location.replace("'.get_admin_url().'admin.php?page=timeline&timeline_created");</script>';
		} else {
			echo '<script>window.location.replace("'.get_admin_url().'admin.php?page=timeline&timeline_not_created");</script>';
		}

	}
}
?>