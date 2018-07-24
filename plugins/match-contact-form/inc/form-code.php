<?php

if (!function_exists('match_form_code')) {
	function match_form_code() {

		$firstName = isset($_GET['firstName']) ? $_GET['firstName'] : '';
		$lastName  = isset($_GET['lastName']) ? $_GET['lastName'] : '';
		$email     = isset($_GET['email']) ? $_GET['email'] : '';
		$reason    = isset($_GET['reason']) ? $_GET['reason'] : '';
		$message   = isset($_GET['message']) ? $_GET['message'] : '';

		$selectedReason_null = ($reason == "") ? " selected" : "";
		$selectedReason_guestbook = ($reason == "guestbook") ? "selected" : "";
		$selectedReason_other = ($reason == "other") ? "selected" : "";

		$messageLabel = $reason == 'guestbook' ? 'Guestbook Comment' : 'Message/Question';

		?>

		<style>form#match_contact_form label{font-weight:bold}form#match_contact_form input,form#match_contact_form select,form#match_contact_form textarea{border-radius:0}form#match_contact_form .captcha .math{font-weight:bold;font-size:1.75rem;line-height:2rem}form#match_contact_form .captcha .icon-plus:before{content:"+"}form#match_contact_form .captcha .icon-equals:before{content:"="}form#match_contact_form .captcha .icon-equals:before,form#match_contact_form .captcha .icon-plus:before{position:absolute;right:0;margin-right:-.55rem;margin-top:-.25rem;font-weight:bold;font-size:1.75rem}.alert:empty{display:none}</style>
		<div class="alert alert-danger text-center" id="formError" role="alert"></div>
		<form id="match_contact_form" name="match_contact_form" onsubmit="return formValFunc()" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post">
			<div class="row mb-md-4">
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
				<div class="col-md-6 mb-3 mb-md-0">
					<label for="email">Email</label>
					<input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>">
				</div>
				<div class="col-md-6 mb-3 mb-md-0">
					<label for="reason">Reason</label>
					<select class="custom-select" id="reason" name="reason" onchange="reasonValueFunc()">
						<option value="" <?php echo $selectedReason_null; ?>>-- Select --</option>
						<option value="guestbook" <?php echo $selectedReason_guestbook; ?>>I want to sign the guestbook</option>
						<option value="other" <?php echo $selectedReason_other; ?>>Comment/Question</option>
					</select>
				</div>
			</div>
			<div class="row mb-md-4">
				<div class="col mb-3 mb-md-0">
					<label for="message" id="messageLabel"><?php echo $messageLabel; ?></label>
					<textarea class="form-control" id="message" name="message" rows="7"><?php echo $message; ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<label for="answerNumber">Captcha</label>
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
			<button type="submit" name="match-submit" id="match-submit" class="btn btn-primary">Submit</button>
		</form>
		<script>function reasonValueFunc(){var e=document.getElementById("reason").value;document.getElementById("messageLabel").innerHTML="guestbook"==e?"Guestbook Comment":"Message/Question"}function formValFunc(){var e=document.getElementById("firstName").value,n=document.getElementById("lastName").value,t=document.getElementById("email").value,r=document.getElementById("reason").value,o=document.getElementById("message").value,m=parseInt(document.getElementById("firstNumber").innerHTML),u=parseInt(document.getElementById("secondNumber").innerHTML),l=parseInt(document.getElementById("answerNumber").value),s=m+u;return""==e||null==e?!(document.getElementById("formError").innerHTML="<strong>First Name</strong> must be filled out"):""==n||null==n?!(document.getElementById("formError").innerHTML="<strong>Last Name</strong> must be filled out"):""==t||null==t?!(document.getElementById("formError").innerHTML="<strong>Email</strong> must be filled out"):""==r||null==r?!(document.getElementById("formError").innerHTML="<strong>Reason</strong> must be filled out"):""==o||null==o?!(document.getElementById("formError").innerHTML="<strong>Message</strong> must be filled out"):l!=s?!(document.getElementById("formError").innerHTML="<strong>Captcha</strong> answer was incorrect"):void 0}</script>

		<?php

	}
}