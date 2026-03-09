<!DOCTYPE html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">

<style>
	.btn-primary {
		background-color: #008037 !important;
		border-color: #008037 !important;
	}

	.card-primary.card-outline {
		border-top: 3px solid #008037 !important;
	}

</style>

<title>Eyebox HRMS Login</title>
<link rel="shortcut icon" href="<?= base_url() ?>images/system/favicon.ico" type="image/x-icon">
<?php $this->load->view('templates/css_link'); ?>

<body class="hold-transition login-page">
	<?php
	$data['DISP_NAME'] = $this->setup_model->get_name();
	?>
	<div class="login-box">
		<div class="card card-outline card-primary">
			<div class="card-header text-center pt-4">
				<img class="logo_bandai" src="<?= base_url(); ?>images/system/login_logo.png" alt="" width="240">
			</div>

			<div class="card-body">
				<?php
				if ($this->session->userdata('SESS_ERR_MSG_INVALID1')) {
				?>
					<div class="alert alert-danger text-center">
						<h6 class="mb-0" id="err_login" name="err_login">
							<?php echo $this->session->userdata('SESS_ERR_MSG_INVALID1'); ?>
						</h6>
					</div>

				<?php
					$this->session->unset_userdata('SESS_ERR_MSG_INVALID1');
				}
				?>

				<?php
				if ($this->session->userdata('SESS_ERR_MSG_INVALID2')) {
				?>
					<div class="alert alert-danger text-center">
						<h6 class="mb-0" id="err_login" name="err_login">
							<?php echo $this->session->userdata('SESS_ERR_MSG_INVALID2'); ?>
						</h6>
					</div>

				<?php
					$this->session->unset_userdata('SESS_ERR_MSG_INVALID2');
				}
				?>

				<?php
				if ($this->session->userdata('SESS_ERR_MSG_INCOMPLETE')) {
				?>
					<div class="alert alert-danger text-center">
						<h6 class="mb-0" id="err_login" name="err_login">
							<?php echo $this->session->userdata('SESS_ERR_MSG_INCOMPLETE'); ?>
						</h6>
					</div>
				<?php
					$this->session->unset_userdata('SESS_ERR_MSG_INCOMPLETE');
				}
				?>

				<form action="<?php echo base_url(); ?>admin_users/login_user_signin" id="login_form" method="POST" accept-charset="utf-8" autocomplete='off'>
					<div class="input-group mb-3">
						<input type="text" name="CALC_INPF_EMAIL" id="username" class="form-control custom-input shadow-none" placeholder="Username" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<button type="submit" id="btn_sign_in" name="CALC_BTN_SAVE" class="btn btn-primary btn-block">Sign In</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<script src="../../plugins/jquery/jquery.min.js"></script>
	<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../../dist/js/adminlte.min.js"></script>
	<?php
	if ((get_cookie("username") && get_cookie("password"))) 
	{
		$username = get_cookie("username");
		$password = get_cookie("password");
		echo "<script>
            document.getElementById('username').value='$username';
            document.getElementById('password').value='$password';
        </script>";
	}
	
	?>
</body>

</html>