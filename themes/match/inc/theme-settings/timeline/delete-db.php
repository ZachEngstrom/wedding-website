<?php

if (isset($_POST['submit_delete'])) {

	// sanitize form values
	$timeline_id    = sanitize_text_field( $_POST["timeline_id"] );

	$dbTableTimelineDelete = $wpdb->prefix.'timeline';

	$where = array(
		'id'  => $timeline_id
	);

	$where_format = array(
		'%d'
	);

	$success=$wpdb->delete( $dbTableTimelineDelete, $where, $where_format );

	if($success) {
		echo '<script>window.location.replace("'.get_admin_url().'admin.php?page=timeline&timeline_deleted");</script>';
	} else {
		echo '<script>window.location.replace("'.get_admin_url().'admin.php?page=timeline&timeline_not_deleted");</script>';
	}
}
?>