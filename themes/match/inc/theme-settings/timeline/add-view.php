<!--style>.wrap .button-secondary{margin:1.5em 0}table{border-collapse:collapse;width:75%}thead th{text-align:center}tbody td{padding:.5em 1em}tbody tr td:nth-child(1){width:25%;min-width:155px}tbody tr td:nth-child(2){width:75%;min-width:155px}tbody label{font-weight:bold;}input[type=text],input[type=url],input[type=number],input[type=date]{width:100%}br+span{color:#989898}select,textarea{width:100%}

@media(max-width:500px){
	table{width:100%}tbody td{float:left}tbody tr td:nth-child(1){width:95%;margin-top:.5em}tbody tr td:nth-child(2){width:95%;margin-top:-.5em}
}</style-->

<?php
?>

<a href="<?php echo get_admin_url(); ?>admin.php?page=timeline" class="button button-secondary">&lt; Back</a>

<form action="./admin.php?page=timeline" method="post">

	<table class="timeline-add">
		<tr>
			<td>
				<label for="timeline_date">Date</label>
			</td>
			<td>
				<input type="date" name="timeline_date" id="timeline_date">
			</td>
		</tr>
		<tr>
			<td>
				<label for="timeline_title">Title</label>
				<br>
				<span>Ex: First Date, First Dance, etc</span>
			</td>
			<td>
				<input type="text" name="timeline_title" id="timeline_title">
			</td>
		</tr>
		<tr>
			<td>
				<label for="timeline_story">Story</label>
			</td>
			<td> <?php

				$timeline_story = '';

				wp_editor( $timeline_story , 'timeline_story', array(
				    'wpautop'       => true,
				    'media_buttons' => true,
				    'textarea_name' => 'timeline_story',
				    'editor_class'  => 'timeline_story',
				    'textarea_rows' => 20
				) );

			?>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="submit_add" value="Submit" class="button button-primary" />
	</p>
</form>