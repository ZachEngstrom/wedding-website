<?php

global $wpdb;
$guestbook_table_name = $wpdb->prefix.'matchguestbook';
$guestbookResults = $wpdb->get_results( "SELECT * FROM $guestbook_table_name ORDER BY `approved`, `unread` DESC, `date`");
date_default_timezone_set('America/Chicago');

?>
<div class="wrap" id="guestbook-results">

		<h2>Guestbook Results</h2>

		<div id="listMSG">

			<table class="wp-list-table widefat fixed striped users">
				<thead>
					<tr>
						<th scope="col" id="username" class="manage-column column-username column-primary">Name</th>
						<th scope="col" id="username" class="manage-column column-username column-primary">Approved?</th>
						<th scope="col" id="email" class="manage-column column-email">Email</th>
						<th scope="col" id="role" class="manage-column column-role">Date</th>
						<th scope="col" id="posts" class="manage-column column-posts num" style="width:33%">Message</th>
						<th scope="col" id="email" class="manage-column column-view" style="width:3.15rem">&nbsp;</th>
					</tr>
				</thead>
				<tbody id="the-list">
					<?php
						$i = 0;
						foreach ($guestbookResults as $guestbookResult) {
							if ($guestbookResult->approved != "2") {
								$i++;
								//$unreadClass = ($guestbookResult->email == '1') ? 'unread' : '';
								$unreadClass = ($guestbookResult->unread == "1") ? "unread" : "";
								$approvedStatus = ($guestbookResult->approved == "0") ? "<span class=\"dashicons dashicons-clock\"></span>" : ( ($guestbookResult->approved == "1") ? "<span class=\"dashicons dashicons-thumbs-up\"></span>" : ( ($guestbookResult->approved == "2") ? "<span class=\"dashicons dashicons-thumbs-down\"></span>" : "unknown" ) );

								echo '
									<tr id="user-'.$i.'" class="'.$unreadClass.'">
										<td class="username column-username has-row-actions column-primary" data-colname="Name">
											<img alt="" src="'.esc_url( get_avatar_url( $guestbookResult->email ) ).'" srcset="'.esc_url( get_avatar_url( $guestbookResult->email ) ).' 2x" class="avatar avatar-32 photo" height="32" width="32"><strong>'.ucfirst($guestbookResult->firstName).' '.ucfirst($guestbookResult->lastName).'</strong><br>
											<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
										</td>
										<td class="email column-status" data-colname="Status">'.$approvedStatus.'</td>
										<td class="email column-email" data-colname="Email">'.$guestbookResult->email.'</td>
										<td class="role column-role" data-colname="Date">'.date("Y-m-d g:ia", substr($guestbookResult->date, 0, 10)).'</td>
										<td class="posts column-posts" data-colname="Message">'.stripslashes(substr($guestbookResult->message,0,160)).'...</td>
										<td class="posts column-posts" data-colname="View"><a href="'.get_admin_url().'admin.php?page=match-guestbook-form.php&view='.$guestbookResult->id.'" class="button button-primary"><span class="dashicons dashicons-visibility"></span></a></td>
									</tr>
								';
							}
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th scope="col" class="manage-column column-username column-primary desc">Name</th>
						<th scope="col" class="manage-column column-username column-primary desc">Approved</th>
						<th scope="col" class="manage-column column-email desc">Email</th>
						<th scope="col" class="manage-column column-role">Date</th>
						<th scope="col" class="manage-column column-posts num">Message</th>
						<th scope="col" id="email" class="manage-column column-view">&nbsp;</th>
					</tr>
				</tfoot>
			</table>

		</div>

	</div>