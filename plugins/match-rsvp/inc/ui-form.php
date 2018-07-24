<?php

if (!function_exists('match_rsvp_ui_form')) {
	function match_rsvp_ui_form() {

		?>
		<h2 id="thanks">Thank You!</h2>
		<style><?php include_once plugin_dir_path( __FILE__ ) . "../css/ui-rsvp.css"; ?></style>
		<div class="alert alert-danger text-center" id="formError" role="alert"></div>
		<form id="match_rsvp_form" name="match_rsvp_form" onsubmit="return formValFunc()" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post">

			<div class="modal fade modal-add-guest" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalAddGuest">
				<div class="modal-dialog modal-lg modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<div class="modal-title">Guest 1</div>
						</div>
						<div class="modal-body">
							<div class="row mb-md-4">
								<div class="col-md-6 mb-3 mb-md-0 sr-only">
									<label for="numGuest">Guest Number</label>
									<div type="text" id="numGuest" name="numGuest" class="form-control" readonly></div>
								</div>
								<div class="col-md-6 mb-3 mb-md-0">
									<label for="firstName">First Name</label>
									<input type="text" id="firstName" name="firstName" class="form-control" value="<?php echo $firstName; ?>">
								</div>
								<div class="col-md-6 mb-3 mb-md-0">
									<label for="lastName">Last Name</label>
									<input type="text" id="lastName" name="lastName" class="form-control" value="<?php echo $lastName; ?>">
								</div>
							</div>
							<div class="row mb-md-4">
								<div class="col-md-6 mb-3 mb-md-0" id="emailWrapper">
									<label for="email">Email</label>
									<input type="email" id="email" name="email" class="form-control" value="<?php echo $primary_email; ?>">
								</div>
								<div class="col-md-6 mb-3 mb-md-0">
									<label for="attending">Attending?</label>
									<select class="custom-select" id="attending" name="attending">
										<option value="" <?php echo $selected_attending_null; ?>>-- Select --</option>
										<option value="1" <?php echo $selected_attending_guestbook; ?>>Can't Wait!</option>
										<option value="0" <?php echo $selected_attending_other; ?>>Celebrating from afar</option>
									</select>
								</div>
								<div class="col-md-12 mb-3 mb-md-0 mt-md-4 d-none" id="mealChoiceWrapper">
									<label for="mealChoice">Meal Choice?</label>
									<select class="custom-select" id="mealChoice" name="mealChoice">
										<option value="" <?php echo $selected_mealchoice_null; ?>>-- Select --</option>
										<option value="1" <?php echo $selected_mealchoice_chx; ?>>Asiago Chicken</option>
										<option value="2" <?php echo $selected_mealchoice_beef; ?>>Roast Beef</option>
										<option value="3" <?php echo $selected_mealchoice_kids; ?>>Kids Meal</option>
									</select>
									<small class="text-muted">* Gluten free &amp; vegetarian options are available upon request - please use the form on the "Contact Us" page to let us know about your gluten free or vegetarian needs.</small>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" id="addGuest" disabled>Add</button>
							<button type="button" class="btn btn-red" data-dismiss="modal">Cancel</button>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col d-none" id="guestTableWrapper">
					<table class="table table-sm table-bordered mb-4" id="guestTable">
						<thead>
							<tr>
								<th>Guest</th>
								<th>Primary Contact's Email</th>
								<th>Attending?</th>
								<th>Meal Choice?</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<div class="col-12 d-none" id="guestList">
					<label for="totalGuestNum" id="messageLabel">Total Guest Count</label>
					<input class="form-control" id="totalGuestNum" name="totalGuestNum" value="">
				</div>
			</div>

			<button type="button" class="btn btn-secondary mt-0 mb-3" data-toggle="modal" data-target=".modal-add-guest" id="btnAddGuest">Add Individual Response</button>

			<div class="row mb-md-4">
				<div class="col mb-3 mb-md-0">
					<label for="songRequest" id="songRequestLabel" class="mb-0">Song Requests</label>
					<div class="text-muted mb-2"><strong>Example:</strong> Artist - Title, Artist - Title, Artist - Title</div>
					<textarea class="form-control" id="songRequest" name="songRequest" rows="3"><?php echo $songRequest; ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<label for="answerNumber">Prove you are human</label>
				</div>
			</div>
			<div class="row mb-md-4 captcha">
				<div class="col icon-plus">
					<div class="form-control text-center rounded-0" id="firstNumber" readonly><?php echo rand(0,9) ?></div>
				</div>
				<div class="col icon-equals">
					<div class="form-control text-center rounded-0" id="secondNumber" readonly><?php echo rand(0,9) ?></div>
				</div>
				<div class="col">
					<input type="number" class="form-control text-center" id="answerNumber" name="answerNumber">
				</div>
			</div>
			<button type="submit" name="match-rsvp-submit" id="match-rsvp-submit" class="btn btn-secondary">Submit</button>
		</form>
		<p id="cta" class="lead mt-3">Please consider sharing your advice and encouragement in our <a href="/contact-us/?reason=guestbook" target="_blank">guestbook</a>!</p>
		<script><?php include_once plugin_dir_path( __FILE__ ) . "../js/ui-rsvp.min.js"; ?></script>

		<?php

	}
}