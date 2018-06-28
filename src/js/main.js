$(function(){
	/*
	 * Sticky Footer
	 */
	var footerHeight = $('footer.site-footer').height();
	$('body').css('margin-bottom',footerHeight);

	if ($('body.page-rsvp').length > 0) {
		$('h1').text('RSVP');
		$('#form_rsvp #addOne').on('click',function(){
			var guestCount = $('[id^="row"].card').length,
			    addNum = guestCount+1;
			$('input#guest_count').val(addNum);
			$("#row"+guestCount+".card").after("<div class='card mt-4' id='row"+addNum+"'><div class='card-header h4'>Guest #"+addNum+"</div><div class='card-body'><div class='row'><div class='form-group col-12 col-sm-6'><label for='rsvp_fn_"+addNum+"' class='col-form-label'>First Name <span class='text-danger'>*</span></label><input type='text' class='form-control' id='rsvp_fn_"+addNum+"' name='rsvp_fn_"+addNum+"'></div><div class='form-group col-12 col-sm-6'><label for='rsvp_ln_"+addNum+"' class='col-form-label'>Last Name <span class='text-danger'>*</span></label><input type='text' class='form-control' id='rsvp_ln_"+addNum+"' name='rsvp_ln_"+addNum+"'></div><div class='form-group col-12 col-sm-6 col-md-4'><label for='attending_"+addNum+"' class='col-form-label'>Attending? <span class='text-danger'>*</span></label><select class='form-control' id='attending_"+addNum+"' name='attending_"+addNum+"'><option value=''>-- Select --</option><option value='"+addNum+"'>Yes</option><option value='0'>No</option></select></div><div class='form-group col-12 col-sm-6 col-md-4'><label for='rsvp_mm_"+addNum+"' class='col-form-label'>Meal Main <span class='text-primary'>*</span></label><select class='form-control' id='rsvp_mm_"+addNum+"' name='rsvp_mm_"+addNum+"'><option value=''>-- Select --</option><option value='mm"+addNum+"'>Main Meal 1</option><option value='mm2'>Main Meal 2</option></select></div><div class='form-group col-12 col-sm-6 col-md-4'><label for='rsvp_sm_"+addNum+"' class='col-form-label'>Side Meal <span class='text-primary'>*</span></label><select class='form-control' id='rsvp_sm_"+addNum+"' name='rsvp_sm_"+addNum+"'><option value=''>-- Select --</option><option value='sm"+addNum+"'>Side Meal 1</option><option value='sm2'>Side Meal 2</option></select></div></div></div></div>");
		});
	}
	$("body").on("change","#form_rsvp [id^='attending']",function(){
		var attBool = $(this).val();
		if (attBool == 1) {
			$(this).parent().parent().find('.food').show();
		} else {
			$(this).parent().parent().find('.food').hide();
		}
	});
});