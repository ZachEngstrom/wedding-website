<a href="<?php echo get_admin_url(); ?>admin.php?page=timeline&add-item" class="button button-secondary">+ Add Timeline Item</a>

<table class="wp-list-table widefat fixed timeline-list striped">
	<thead>
		<tr>
			<th style="width:5.5rem">Date</th>
			<th style="width:15rem">Title</th>
			<th>Story</th>
			<th style="width:3rem;text-align:center">Edit</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i = 0;
		foreach ($dbTableTimeline as $timeline => $row) {

			// add 1 to the counter
			$i++;

			// Set variable to add a class to the row of an updated or deleted timeline
			if ($_GET['timeline_updated'] == $row->id) {
				$updatedClass = ' class="update-success"';
			} else if ($_GET['timeline_not_updated'] == $row->id) {
				$updatedClass = ' class="update-error"';
			} else if ($_GET['timeline_not_deleted'] == $row->id) {
				$updatedClass = ' class="update-error"';
			} else {
				$updatedClass = '';
			}

			echo '
				<tr'.$updatedClass.'>
					<td class="text-center">'.date("M\. j\, Y", substr($row->date, 0, 10)).'</td>
					<td>'.$row->title.'</td>
					<td>'.html_entity_decode(stripslashes(wpautop($row->story))).'</td>
					<td class="text-center"><a href="'.get_admin_url().'admin.php?page=timeline&edit-item='.$row->id.'" class="button button-primary"><span class="dashicons dashicons-edit"></span></a></td>
				</tr>
			';

		}
	?>
	</tbody>
</table>