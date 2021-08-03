<!-- ================== BEGIN BASE JS ================== -->
<script src="/assets/plugins/jquery/jquery-3.2.1.min.js"></script>
<script src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="/assets/plugins/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<!--[if lt IE 9]>
	<script src="../assets/crossbrowserjs/html5shiv.js"></script>
	<script src="../assets/crossbrowserjs/respond.min.js"></script>
	<script src="../assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/assets/plugins/js-cookie/js.cookie.js"></script>
<script src="/assets/js/theme/default.min.js"></script>
<script src="/assets/js/apps.min.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="../assets/plugins/parsley/dist/parsley.js"></script>
<script src="../assets/plugins/highlight/highlight.common.js"></script>
<script src="../assets/js/demo/render.highlight.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script>
	$(document).ready(function() {
		App.init();
	});
</script>

{{-- Login Form Validation --}}
<script>
	$('#login_form').ready(function(){
		// e.preventDefault();
		$('#login_form').validate({
			errorClass: "invalid",
   			validClass: "valid",
			rules: {
				email: {
                	required: true,
					email: true,
           		},
            	password: {
                	required: true,
            	},
			},
			messages: {
				email: 	{
							required: '<div class="text-danger">*The email field is required!</div>',
							email: '<div class="text-danger">*Please enter a valid email address!</div>',
        				},
            	password: '<div class="text-danger">*The password field is required!</div>',
			},
			// Customize placement of created message error labels. 
			errorPlacement: function(error, element) {
				error.appendTo( element.parent().find(".error_msg"));
        	}
		});
	});
	$(document).on('submit', 'form#login_form', function(e){
		e.preventDefault();

		var route = "{{route('user.login')}}";
		var form_data = $(this);

		$.ajax({
			headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	},
			method: 'POST',
			url: route,
			data: form_data.serialize(),
			success: function(otp_mail_success){
				// console.log(form_data);
				window.location.href = "{{route('otp_page')}}";
          	},
			error: function(error_response){
				$('span.error_email_pass').empty();
				$('#login_form')[0].reset();
				// append() = Inserts content at the end of the selected elements
				// stay on the same page and shows error
				$('span.error_email_pass').append('<div class="alert alert-danger">'+error_response.responseJSON['message']+'</div>');
			}
		});
	});
</script>

{{-- Send Reset Link Form Validation --}}
<script>
	$('#reset_form').ready(function(){
		$('#reset_form').validate({
			errorClass: "invalid",
   			validClass: "valid",
			rules: {
				email: {
                	required: true,
					email: true,
           		},
			},
			messages: {
				email: 	{
							required: '<div class="text-danger">*The email field is required!</div>',
							email: '<div class="text-danger">*Please enter a valid email address!</div>',
        				},
			},
			// Customize placement of created message error labels. 
			errorPlacement: function(error, element) {
				error.appendTo( element.parent().find(".error_msg") );
        	}
		});
	});
	$(document).on('submit', 'form#reset_form', function(e){
		e.preventDefault();

		var route = "{{ route('send.req.pwd.link') }}";
		var form_data = $(this);

		$.ajax({
			headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	},
			method: 'POST',
			url: route,
			data: form_data.serialize(),
			success: function(success_response){
				// console.log(success_response);
				Swal.fire({
					position: 'center',
					icon: 'success',
					title: success_response.message,
					showConfirmButton: true,
					// timer: 1500
				}).then(function(){ 
					window.location = "/login";
				});
          	},
			error: function(error_response){
				$('span.error_email').empty();
				$('#reset_form')[0].reset();
				// append() = Inserts content at the end of the selected elements
				$('span.error_email').append('<div class="alert alert-danger">'+error_response.responseJSON['message']+'</div>');
			}
		});
	});
</script>

{{-- Change password form --}}
<script>
	$('#change_password_form').ready(function(){
		$('#change_password_form').validate({
			errorClass: "invalid",
   			validClass: "valid",
			rules: {
            	old_password: {
                	required: true
            	},
				new_password: {
                	required: true,
            	},
			},
			messages: {
				old_password: '<div class="text-danger">*The old password field is required!</div>',
				new_password: '<div class="text-danger">*The new password field is required!</div>',
			},
			// Customize placement of created message error labels. 
			errorPlacement: function(error, element) {
				error.appendTo( element.parent().find(".error_msg") );
        	}
		});
	});
	$(document).on('submit', 'form#change_password_form', function(e){
		e.preventDefault();

		var route = $('form#change_password_form').attr('action');
		var form_data = $(this);

		$.ajax({
			headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	},
			method: 'PATCH',
			url: route,
			data: form_data.serialize(),
			success: function(success_response){
				Swal.fire({
					position: 'center',
					icon: 'success',
					title: success_response.message,
					showConfirmButton: false,
					timer: 1500,
				}).then(function(){ 
					window.location = "/login";
				});
          	},
			error: function(error_response){
				$('span.error_password').empty();
				$('#change_password_form')[0].reset();
				// append() = Inserts content at the end of the selected elements
				$('span.error_password').append('<div class="alert alert-danger">'+error_response.responseJSON['message']+'</div>');
			}
		});
	});
</script>

{{-- Verify OTP Page --}}
<script>
	$('#otp_form').ready(function(){
		$('#otp_form').validate({
			errorClass: "invalid",
   			validClass: "valid",
			rules:{
				otp: {
                	required: true,
					maxlength: 4,
				}
			},
			messages: {
				otp: {
					required:'<div class="text-danger">*The OTP field is required!</div>',
					maxlength: '<div class="text-danger">*The OTP Pin is only 4 digits!</div>'
				}
				
			},
				// Customize placement of created message error labels. 
			errorPlacement: function(error, element) {
				error.appendTo( element.parent().find(".error_msg") );
        	}
		});
	});
	$(document).on('submit', 'form#otp_form', function(e){
		e.preventDefault();

		var route = "{{ route('form.check_otp_verification') }}";
		var form_data = $(this);

		$.ajax({
			headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	},
			method: 'POST',
			url: route,
			data: form_data.serialize(),
			success: function(otp_verified_response){
				Swal.fire({
					position: 'center',
					icon: 'success',
					title: otp_verified_response.message,
					showConfirmButton: false,
					timer: 1500
				}).then(function(){ 
					window.location.href = "{{route('main.home')}}";
				});
          	},
			error: function(error_response){
				$('span.error_otp').empty();
				$('#otp_form')[0].reset();
				// append() = Inserts content at the end of the selected elements
				$('span.error_otp').append('<div class="alert alert-danger">'+error_response.responseJSON['message']+'</div>');
			}
		});
	});
</script>

{{-- Verify OTP Page --}}
<script>
	$(document).on('submit', 'form#reset_otp_form', function(e){
		e.preventDefault();

		var route = "{{ route('reset_otp_link') }}";
		var form_data = $(this);

		$.ajax({
			headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	},
			method: 'PATCH',
			url: route,
			data: form_data.serialize(),
			success: function(reset_otp_mail_success){
				Swal.fire({
					position: 'center',
					icon: 'success',
					title: reset_otp_mail_success.message,
					showConfirmButton: true,
				});
				$('span.error_otp').remove();
          	},
		});
	});
</script>