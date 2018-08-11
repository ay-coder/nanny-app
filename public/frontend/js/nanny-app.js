var Nanny = {
	init : function() {
	},
	Account : function() {
		// My Profile Edit, My Children Edit/ Add new
		// Edit
		$('.btn-edit-profile').on('click', function(){
			$(this).parent('.parent-profile').hide();
			$(this).parent('.parent-profile').next('.parent-profile.edit').show();
		});

		// Save
		// $('form#edit-form').submit(function( event ) {
		// 	event.preventDefault();
		// 	var profileEdit = $(this);
		// 	var data = new FormData($('#edit-form')[0]);
		// 	$.ajax({
		// 		type: 'post',
	 //        	url : ModuleConfig.UpdateProfileURL,
	 //        	data : data,
	 //        	processData: false,
		// 		contentType: false,
		// 		cache:false,
		//     }).done(function (response) {
		//     	var data = JSON.parse(response);
		//     	console.log(data);
		//     	if(data.status == true) {
		//     		$('#ajax-messages').addClass('alert alert-success');
		//         	$('#ajax-messages').html(data.message);
		//         	profileEdit.parent(".parent-profile.edit").hide();
		// 			profileEdit.parent(".parent-profile.edit").prev('.parent-profile').show();
		//     	} else {
		//     		$('#ajax-messages').addClass('alert alert-danger');
		//         	$('#ajax-messages').html('There was a problem updating your profile. Please try again.');
		//     	}
		//         $('#ajax-messages').css('display', 'block');

		//     }).fail(function () {
		//         $('#ajax-messages').addClass('alert alert-danger');
		//         $('#ajax-messages').html('Something went wrong Please try again.');
		//         $('#ajax-messages').css('display', 'block');
		//         //
		//     });
		// });

		// Edit children
		$('.btn-edit').on('click', function(){
			$('.childern-list').hide();
			$('.add-children > ul > li').hide();
			$('#add-baby-submit-btn').css('display', 'none');

			$('.edit-children > ul > li').show();
			$('#edit-baby-submit-btn').css('display', 'block');
		});

		$('.btn-add').on('click', function(){
			$('.childern-list').hide();
			$('.edit-children > ul > li').hide();
			$('#edit-baby-submit-btn').css('display', 'none');

			$('.add-children > ul > li').show();
			$('#add-baby-submit-btn').css('display', 'block');
		});

		$('.btn-edit-profile-sitter').on('click', function(){
			$('.about-sitter').hide();
			$('.about-sitter-edit').show();
			$('#edit-baby-submit-btn').css('display', 'none');
		});
	},
	Appointment : function() {
		$('#upcoming_appointment_btn').click(function() {
			$('#upcoming_appointment_btn').addClass('active');
			$('#previous_appointment_btn').removeClass('active');

			$('#upcoming_appointment').css('display', 'block');
			$('#previous_appointment').css('display', 'none');
		});

		$('#previous_appointment_btn').click(function() {
			$('#previous_appointment_btn').addClass('active');
			$('#upcoming_appointment_btn').removeClass('active');

			$('#previous_appointment').css('display', 'block');
			$('#upcoming_appointment').css('display', 'none');
		});
	},
	Home : function () {

	}
};