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

		$('.add-children > ul > li').hide();
		$('.edit-children > ul > li').hide();

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

		$('a.show_baby').click(function () {
			$(this).closest('tr').next('tr').toggle();
		});
	},
	Myjobs : function () {
		$('#calender_view_btn').click(function() {
			$('#calender_view_btn').addClass('active');

			$('#current_jobs_btn').removeClass('active');
			$('#previous_jobs_btn').removeClass('active');

			$('#calender_view').css('display', 'block');

			$('#current_jobs').css('display', 'none');
			$('#previous_jobs').css('display', 'none');
		});

		$('#current_jobs_btn').click(function() {
			$('#current_jobs_btn').addClass('active');

			$('#calender_view_btn').removeClass('active');
			$('#previous_jobs_btn').removeClass('active');

			$('#current_jobs').css('display', 'block');

			$('#calender_view').css('display', 'none');
			$('#previous_jobs').css('display', 'none');
		});

		$('#previous_jobs_btn').click(function() {
			$('#previous_jobs_btn').addClass('active');

			$('#calender_view_btn').removeClass('active');
			$('#current_jobs_btn').removeClass('active');

			$('#previous_jobs').css('display', 'block');

			$('#calender_view').css('display', 'none');
			$('#current_jobs').css('display', 'none');
		});

		$('a.show_baby').click(function () {
			$(this).closest('tr').next('tr').toggle();
		});

	}
};