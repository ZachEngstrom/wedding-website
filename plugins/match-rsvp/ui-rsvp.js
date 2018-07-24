function formValFunc() {

    var f=parseInt(document.getElementById("firstNumber").innerHTML);
    var g=parseInt(document.getElementById("secondNumber").innerHTML);
    var h=parseInt(document.getElementById("answerNumber").value);
    var i = f + g;

	if (h != i) {
        document.getElementById("formError").innerHTML = "<strong>Captcha</strong> answer was incorrect";
        return false;
    }

}

$(function(){
	// if guest is attending, display Meal Choice dropdown
	$('#modalAddGuest #attending').change(function() {
		var attendingValue = $(this).val();
		if (attendingValue != 'yes') { // if not attending, hide Meal Choice dropdown
			$('#modalAddGuest #mealChoiceWrapper').addClass('d-none').removeClass('d-block');
		} else { // if attending, display Meal Choice dropdown
			$('#modalAddGuest #mealChoiceWrapper').removeClass('d-none').addClass('d-block');
		}
	});
	$('#match_rsvp_form #btnAddGuest').on('click', function() {
		var guestCount = $('#guestTable tbody tr').length; // get number of rows in the guest table
		var currentGuestNum = guestCount+1; // to get current guest number, add "1" to number of rows in the guest table
		$('#modalAddGuest #numGuest').text(currentGuestNum); // set text of div to current guest number
		$('#modalAddGuest .modal-title').text('Guest '+currentGuestNum); // set text of div to current guest number
		if (currentGuestNum != 1) { // if not first guest
			$('#modalAddGuest #emailWrapper').hide(); // hide email field
			$('#mealChoiceWrapper').removeClass('mt-md-4').addClass('mt-0'); // Remove margin-top on Meal Choice dropdown
		} else { // if first guest
			$('#mealChoiceWrapper').removeClass('mt-0').addClass('mt-md-4'); // Set margin-top on Meal Choice dropdown
		}
	});

	var guestFirstName  = $('#modalAddGuest #firstName').val();
	var guestLastName   = $('#modalAddGuest #lastName').val();
	var guestAttending  = $('#modalAddGuest #attending').val();
	var guestMealChoice = $('#modalAddGuest #mealChoice').val();

	// $('input,select').change(function(){
	// 	if ()
	// });

	$('#modalAddGuest #addGuest').on('click', function() {
		// Assign variables
		var guestNum        = $('#modalAddGuest #numGuest').text();
		//var guestFirstName  = $('#modalAddGuest #firstName').val();
		//var guestLastName   = $('#modalAddGuest #lastName').val();
		var guestEmail      = $('#modalAddGuest #email').val();
		//var guestAttending  = $('#modalAddGuest #attending').val();
		//var guestMealChoice = $('#modalAddGuest #mealChoice').val();

		$('input,select')

		// Set guest number
		$('#totalGuestNum').attr("value",guestNum);
		if (guestNum != "1") { // Don't include email info if not first guest
			$('#guestTable tbody').append('<tr><td data-colname="Name">'+guestFirstName+' '+guestLastName+'</td><td data-colname="Primary Email">N/A</td><td data-colname="Attending?">'+guestAttending+'</td><td data-colname="Meal Choice?">'+guestMealChoice+'</td></tr>');
			$('#guestList').append('<label for="firstName_'+guestNum+'">First Name</label><input class="form-control" id="firstName_'+guestNum+'" name="firstName_'+guestNum+'" value="'+guestFirstName+'"><label for="lastName_'+guestNum+'">Last Name</label><input class="form-control" id="lastName_'+guestNum+'" name="lastName_'+guestNum+'" value="'+guestLastName+'"><label for="email_'+guestNum+'">Email</label><input class="form-control" id="email_'+guestNum+'" name="email_'+guestNum+'" value=""><label for="attending_'+guestNum+'">Attending?</label><input class="form-control" id="attending_'+guestNum+'" name="attending_'+guestNum+'" value="'+guestAttending+'"><label for="mealChoice_'+guestNum+'">Meal Choice?</label><input class="form-control" id="mealChoice_'+guestNum+'" name="mealChoice_'+guestNum+'" value="'+guestMealChoice+'">');
		} else { // Include email info if first guest
			$('#guestTableWrapper').removeClass('d-none');
			$('#guestTable tbody').append('<tr><td data-colname="Name">'+guestFirstName+' '+guestLastName+'</td><td data-colname="Primary Email">'+guestEmail+'</td><td data-colname="Attending?">'+guestAttending+'</td><td data-colname="Meal Choice?">'+guestMealChoice+'</td></tr>');
			$('#guestList').append('<label for="firstName_'+guestNum+'">First Name</label><input class="form-control" id="firstName_'+guestNum+'" name="firstName_'+guestNum+'" value="'+guestFirstName+'"><label for="lastName_'+guestNum+'">Last Name</label><input class="form-control" id="lastName_'+guestNum+'" name="lastName_'+guestNum+'" value="'+guestLastName+'"><label for="email_'+guestNum+'">Email</label><input class="form-control" id="email_'+guestNum+'" name="email_'+guestNum+'" value="'+guestEmail+'"><label for="attending_'+guestNum+'">Attending?</label><input class="form-control" id="attending_'+guestNum+'" name="attending_'+guestNum+'" value="'+guestAttending+'"><label for="mealChoice_'+guestNum+'">Meal Choice?</label><input class="form-control" id="mealChoice_'+guestNum+'" name="mealChoice_'+guestNum+'" value="'+guestMealChoice+'">');
		}
		// Clear the form
		$('#modalAddGuest input, #modalAddGuest select').val("");
		// Re-hide the Meal Choice dropdown
		$('#modalAddGuest #mealChoiceWrapper').addClass('d-none').removeClass('d-block');
		// Close the modal
		$('#modalAddGuest').modal('hide');
	});
});