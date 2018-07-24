<?php

global $wpdb;
$rsvp_table_name = $wpdb->prefix.'rsvpform';
$rsvpResults = $wpdb->get_results( "SELECT * FROM $rsvp_table_name ORDER BY `unread` DESC, `primary_email`, `lastName`");
date_default_timezone_set('America/Chicago');

?>
<div class="wrap" id="contact-results">

		<style><?php include_once plugin_dir_path( __FILE__ ) . "../css/admin-rsvp.css"; ?></style>

		<h2>RSVP Results</h2>

		<div id="listRSVP">

			<table class="wp-list-table widefat fixed striped users">
				<thead>
					<tr>
						<th scope="col" id="username" class="manage-column column-username column-primary"><span class="desktop">Email</span><span class="mobile">Name</span></th>
						<th scope="col" id="email" class="manage-column column-email">Name</th>
						<th scope="col" id="attending" class="manage-column column-attending">Attending?</th>
						<th scope="col" id="food" class="manage-column column-food">Food?</th>
						<th scope="col" id="songs" class="manage-column column-songs">Song Request</th>
						<th scope="col" id="role" class="manage-column column-role">Date</th>
						<th scope="col" id="email" class="manage-column column-view" style="width:3.15rem">&nbsp;</th>
					</tr>
				</thead>
				<tbody id="the-list">
					<?php
						$i = 0;
						foreach ($rsvpResults as $rsvpResult) {
							if ($rsvpResult->deleted != "1") {
								$i++;

								$unreadClass = ($rsvpResult->unread == "1") ? "unread" : "";

								$rsvpAttending = ($rsvpResult->attending == "1") ? "Yes" : "No";

								$rsvpFood = ($rsvpResult->food_choice == "0") ? "Dietary Restriction" : (($rsvpResult->food_choice == "1") ? 'Asiago Chicken' : (($rsvpResult->food_choice == "2") ? 'Roast Beef' : (($rsvpResult->food_choice == "3") ? 'Kids Meal' : 'Unknown')));

								$rsvpSongRequest = ($rsvpResult->song_request) ? substr($rsvpResult->song_request,0,160).'...' : "";

								echo '
									<tr id="user-'.$i.'" class="'.$unreadClass.'">
										<td class="username column-username has-row-actions column-primary" data-colname="Name">
											<img alt="" src="'.esc_url( get_avatar_url( $rsvpResult->primary_email ) ).'" srcset="'.esc_url( get_avatar_url( $rsvpResult->primary_email ) ).' 2x" class="avatar avatar-32 photo" height="32" width="32"><strong class="desktop">'.$rsvpResult->primary_email.'</strong><strong class="mobile">'.ucfirst($rsvpResult->firstName).' '.ucfirst($rsvpResult->lastName).'</strong><br>
											<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
										</td>
										<td class="email column-email" data-colname="Email"><span class="desktop">'.ucfirst($rsvpResult->lastName).', '.ucfirst($rsvpResult->firstName).'</span><span class="mobile">'.$rsvpResult->primary_email.'</span></td>
										<td class="email column-attending" data-colname="Attending">'.$rsvpAttending.'</td>
										<td class="email column-food" data-colname="Food">'.$rsvpFood.'</td>
										<td class="posts column-songs" data-colname="Songs">'.$rsvpSongRequest.'</td>
										<td class="role column-role" data-colname="Date">'.date("M\. j\, Y g:ia", substr($rsvpResult->date, 0, 10)).'</td>
										<td class="posts column-posts" data-colname="View"><a href="'.get_admin_url().'admin.php?page=match-rsvp.php&view='.$rsvpResult->id.'" class="button button-primary"><span class="dashicons dashicons-visibility"></span></a></td>
									</tr>
								';
							}
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th scope="col" id="username" class="manage-column column-username column-primary"><span class="desktop">Email</span><span class="mobile">Name</span></th>
						<th scope="col" id="email" class="manage-column column-email">Name</th>
						<th scope="col" id="attending" class="manage-column column-attending">Attending?</th>
						<th scope="col" id="food" class="manage-column column-food">Food?</th>
						<th scope="col" id="songs" class="manage-column column-songs">Song Request</th>
						<th scope="col" id="role" class="manage-column column-role">Date</th>
						<th scope="col" id="email" class="manage-column column-view" style="width:3.15rem">&nbsp;</th>
					</tr>
				</tfoot>
			</table>

		</div>

	</div>