$(function () {
	$( document ).ready(function(){

		// Upload Image File Input begain
		function readURL(input, imagepath) {
	        if (input.files && input.files[0]) {
	            var reader = new FileReader();
	            reader.onload = function (e) {
					$(imagepath).next('img.image_upload_preview').attr('src', e.target.result);
	            }
	            reader.readAsDataURL(input.files[0]);
	        }
	    }
	    $('input[type=file]').change(function () {
	        var getInput = $(this).attr('id');
	        var imagepath = '#'+getInput
	        readURL(this , imagepath);
	    });

		// DateTime Picker
		$('.date').datetimepicker({
			viewMode: 'days',
            format: 'DD/MM/YYYY'
		});

		$('.futuredate').datetimepicker({
			viewMode: 'days',
            format: 'DD/MM/YYYY',
            minDate: new Date(),
		});

		 var d = new Date();
  		d.setDate(d.getDate() - 1);

		$('.pastdate').datetimepicker({
			viewMode: 'days',
            format: 'DD/MM/YYYY',
            maxDate: d,
            defaultDate : d,
		});

		$('.startTime').datetimepicker({
            format: 'LT'
        });
		$('.endTime').datetimepicker({
            format: 'LT'
        });

		// Review Star
		$('#star1').starrr();
	});
});