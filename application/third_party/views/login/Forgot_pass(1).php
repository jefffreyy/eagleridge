<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
		<link href="<?= base_url(); ?>css/loginStyles.css" rel="stylesheet">
		<title>HRCare Login</title>
	</head>
	<body>
		<div class = "forgot-container">
			<div class = "login-page">
				<img src = "<?= base_url(); ?>images/hrcare-logo.webp" alt = "" class = "logo">
				<p style = "font-size:17px;"><b>Forgot Your Password?</b></p>
                <img src = "<?= base_url(); ?>images/forgot_password.webp" alt = "" class = "forgot-logo">
				<div class = "forgot-inputs">
					<div class = "input-group">
						<input type = "text" name = "CALC_INPF_EMAIL" class = "form-control forgot-custom-input shadow-none" placeholder = "Email">
					</div>
					<button type = "button" name = "CALC_BTN_SEND" class = "btn btn-primary btn-block shadow-none">Send</button>
					<div class = "have-acc-div">
						<a href = "<?=base_url();?>login" class = "have-label">Already have an account?</a>
					</div>
				</div>
			</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
	</body>
</html>