<!--style>.wrap .button-secondary{margin:1.5em 0}table{border-collapse:collapse;width:75%}thead th{text-align:center}tbody td{padding:.5em 1em}tbody tr td:nth-child(1){width:25%;min-width:155px}tbody tr td:nth-child(2){width:75%;min-width:155px}tbody label{font-weight:bold;}input[type=text],input[type=url],input[type=number],input[type=date]{width:100%}br+span{color:#989898}select,textarea{width:100%}

@media(max-width:500px){
	table{width:100%}tbody td{float:left}tbody tr td:nth-child(1){width:95%;margin-top:.5em}tbody tr td:nth-child(2){width:95%;margin-top:-.5em}
}</style-->

<?php

if (isset($_GET['edit-item'])) {

	$dbTableTimelineEditView = $wpdb->prefix.'timeline';
	foreach( $wpdb->get_results('SELECT * FROM `'.$dbTableTimelineEditView.'` WHERE `id` = '.$_GET['edit-item']) as $timeline_key => $db_timeline_row) {
		$db_timeline_id    = $db_timeline_row->id;
		$db_timeline_date  = $db_timeline_row->date;
		$db_timeline_title = $db_timeline_row->title;
		$db_timeline_story = $db_timeline_row->story;
		$db_timeline_date  = date("Y-m-d", substr($db_timeline_date, 0, 10));
	}
}

?>

<a href="<?php echo get_admin_url(); ?>admin.php?page=timeline" class="button button-secondary">&lt; Back</a>
<a href="<?php echo get_admin_url().'admin.php?page=timeline&delete-item='.$_GET['edit-item']; ?>" class="button button-danger" style="float:right">Delete</a>

<form action="./admin.php?page=timeline" method="post">

	<table class="timeline-edit">
		<tr style="display:none">
			<td>
				<label for="timeline_id">ID</label>
			</td>
			<td>
				<input type="text" name="timeline_id" id="timeline_id" value="<?php if(isset($db_timeline_id)) { echo $db_timeline_id; } ?>">
			</td>
		</tr>
		<tr>
			<td>
				<label for="timeline_date">Date</label>
			</td>
			<td>
				<input type="date" name="timeline_date" id="timeline_date" value="<?php if(isset($db_timeline_date)) { echo $db_timeline_date; } ?>">
			</td>
		</tr>
		<tr>
			<td>
				<label for="timeline_title">Title</label>
				<br>
				<span>Ex: First Date, First Dance, etc</span>
			</td>
			<td>
				<input type="text" name="timeline_title" id="timeline_title" value="<?php if(isset($db_timeline_title)) { echo $db_timeline_title; } ?>">
			</td>
		</tr>
		<tr>
			<td>
				<label for="timeline_story">Story</label>
			</td>
			<td> <?php

				$timeline_story = html_entity_decode(stripslashes(wpautop($db_timeline_story)));

				wp_editor( $timeline_story , 'timeline_story', array(
				    'wpautop'       => true,
				    'media_buttons' => true,
					'drag_drop_upload' => true,
					'tabfocus_elements' => 'content-html,save-post',
				    'textarea_name' => 'timeline_story',
				    'editor_class'  => 'timeline_story',
				    'textarea_rows' => 20
				) );

			?>
		</tr>
	</table>
	<p class="submit" style="width:75%">
		<input type="submit" name="submit_edit" value="Update" class="button button-primary" />
	</p>
</form>