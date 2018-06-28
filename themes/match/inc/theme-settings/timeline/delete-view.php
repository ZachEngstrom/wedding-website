<?php

if (isset($_GET['delete-item'])) {

	$dbTableTimelineDeleteView = $wpdb->prefix.'timeline';
	foreach( $wpdb->get_results('SELECT * FROM `'.$dbTableTimelineDeleteView.'` WHERE `id` = '.$_GET['delete-item']) as $timeline_key => $db_timeline_row) {
		$db_timeline_id    = $db_timeline_row->id;
		$db_timeline_date  = $db_timeline_row->date;
		$db_timeline_title = $db_timeline_row->title;
		$db_timeline_story = $db_timeline_row->story;
		$db_timeline_date  = date("Y-m-d", substr($db_timeline_date, 0, 10));
	}
}

?>

<a href="<?php echo get_admin_url(); ?>admin.php?page=timeline&edit-item=<?php echo $db_timeline_id; ?>" class="button button-secondary">&lt; Back</a>

<form action="./admin.php?page=timeline" method="post">

	<table class="timeline-delete">
		<tr style="display:none">
			<td style="width:19.5rem">
				<label for="timeline_id">ID</label>
			</td>
			<td>
				<input type="text" name="timeline_id" id="timeline_id" value="<?php if(isset($db_timeline_id)) { echo $db_timeline_id; } ?>" readonly>
			</td>
		</tr>
		<tr>
			<td style="width:19.5rem">
				<label for="timeline_date">Date</label>
			</td>
			<td>
				<input type="date" name="timeline_date" id="timeline_date" value="<?php if(isset($db_timeline_date)) { echo $db_timeline_date; } ?>" readonly>
			</td>
		</tr>
		<tr>
			<td style="width:19.5rem">
				<label for="timeline_title">Title</label>
				<br>
				<span>Ex: First Date, First Dance, etc</span>
			</td>
			<td>
				<input type="text" name="timeline_title" id="timeline_title" value="<?php if(isset($db_timeline_title)) { echo $db_timeline_title; } ?>" readonly>
			</td>
		</tr>
		<tr>
			<td style="width:19.5rem">
				<label for="timeline_story">Story</label>
			</td>
			<td><?php echo html_entity_decode(stripslashes(wpautop($db_timeline_story))); ?></td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="submit_delete" value="Delete" class="button button-danger" />
	</p>
</form>