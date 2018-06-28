<?php

if (isset($_POST['submit_edit'])) {

	// sanitize form values
	$timeline_id    = sanitize_text_field( $_POST["timeline_id"] );
	$timeline_date  = sanitize_text_field( $_POST["timeline_date"] );
	$timeline_title = sanitize_text_field( $_POST["timeline_title"] );
	$timeline_story = esc_textarea( $_POST["timeline_story"] );

	$timeline_date = strtotime($timeline_date . ' 17:00:00');

	$timelineAlert = '';

	if(empty($timeline_date)) { // error out if role field is blank

		$timelineAlert = '<div id="message" class="error notice is-dismissible"><p>Timeline item not updated. Missing <strong>Date</strong>. Please try again.</p></div>';

	} elseif (empty($timeline_title)) { // error out if name field is blank

		$timelineAlert = '<div id="message" class="error notice is-dismissible"><p>Timeline item not updated. Missing <strong>Title</strong>. Please try again.</p></div>';

	} elseif (empty($timeline_story)) { // error out if name field is blank

		$timelineAlert = '<div id="message" class="error notice is-dismissible"><p>Timeline item not updated. Missing <strong>Story</strong>. Please try again.</p></div>';

	} else {

		$dbTableTimelineEdit = $wpdb->prefix.'timeline';

		$data = array(
			'date'  => $timeline_date,
			'title' => $timeline_title,
			'story' => $timeline_story
		);

		$where = array(
			'id'  => $timeline_id
		);

		$format = array(
			'%d',
			'%s',
			'%s'
		);

		$where_format = array(
			'%d'
		);

		$success=$wpdb->update( $dbTableTimelineEdit, $data, $where, $format, $where_format );

		if($success) {
			echo '<script>window.location.replace("'.get_admin_url().'admin.php?page=timeline&timeline_updated");</script>';
		} else {
			echo '<script>window.location.replace("'.get_admin_url().'admin.php?page=timeline&timeline_not_updated");</script>';
		}

	}
}
?>