<?php

global $wpdb;
$contact_table_name = $wpdb->prefix.'matchcontactform';
$contactResults = $wpdb->get_results( "SELECT * FROM $contact_table_name ORDER BY `unread` DESC, `date`");
date_default_timezone_set('America/Chicago');

?>
<div class="wrap" id="contact-results">

		<h2>Contact Results</h2>

		<table class="wp-list-table widefat fixed striped users">
			<thead>
				<tr>
					<th scope="col" id="username" class="manage-column column-username column-primary">Name</th>
					<th scope="col" id="email" class="manage-column column-email">Email</th>
					<th scope="col" id="role" class="manage-column column-role">Date</th>
					<th scope="col" id="posts" class="manage-column column-posts num" style="width:33%">Message</th>
					<th scope="col" id="email" class="manage-column column-view" style="width:3.15rem">&nbsp;</th>
				</tr>
			</thead>
			<tbody id="the-list">
				<?php
					$i = 0;
					foreach ($contactResults as $contactResult) {
						if ($contactResult->deleted == "1") {
							$i++;
							//$unreadClass = ($contactResult->email == '1') ? 'unread' : '';
							$unreadClass = ($contactResult->unread == "1") ? "unread" : "";

							echo '
								<tr id="user-'.$i.'" class="'.$unreadClass.'">
									<td class="username column-username has-row-actions column-primary" data-colname="Name">
										<img alt="" src="'.esc_url( get_avatar_url( $contactResult->email ) ).'" srcset="'.esc_url( get_avatar_url( $contactResult->email ) ).' 2x" class="avatar avatar-32 photo" height="32" width="32"><strong>'.$contactResult->firstName.' '.$contactResult->lastName.'</strong><br>
										<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
									</td>
									<td class="email column-email" data-colname="Email">'.$contactResult->email.'</td>
									<td class="role column-role" data-colname="Date">'.date("Y-m-d g:ia", substr($contactResult->date, 0, 10)).'</td>
									<td class="posts column-posts" data-colname="Message">'.substr($contactResult->message,0,160).'...</td>
									<td class="posts column-posts" data-colname="View"><a href="'.get_admin_url().'admin.php?page=match-contact-form.php&view-deleted='.$contactResult->id.'" class="button button-primary"><span class="dashicons dashicons-visibility"></span></a></td>
								</tr>
							';
						}
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<th scope="col" class="manage-column column-username column-primary desc">Name</th>
					<th scope="col" class="manage-column column-email desc">Email</th>
					<th scope="col" class="manage-column column-role">Date</th>
					<th scope="col" class="manage-column column-posts num">Message</th>
					<th scope="col" id="email" class="manage-column column-view">&nbsp;</th>
				</tr>
			</tfoot>
		</table>

	</div>