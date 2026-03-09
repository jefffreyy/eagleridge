<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">



	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../../dist/css/adminlte.min.css">

	<title>Eyebox Login</title>

</head>

<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
	<img class="logo_bandai" src="<?= base_url(); ?>images/bandai_logo.webp" alt="" width="240">
      <!-- <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a> -->
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>
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



      <form action="<?php echo base_url('login/sign_in'); ?>" id="login_form" method="POST" accept-charset="utf-8" autocomplete='off'>
        <div class="input-group mb-3">
          <input type="text" name="CALC_INPF_EMAIL" id="username" class="form-control custom-input shadow-none" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="password" name="CALC_INPF_PASS" class="form-control custom-input shadow-none" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
     
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" id="btn_sign_in" name="CALC_BTN_SAVE" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      

      <p class="mb-1 mt-3">
        <a href="<?= base_url() ?>login/forgot_password" >I forgot my password</a>
      </p>


	  <br>

	  
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<p class="mb-1 mt-3" style = "text-align: center; font-size: 13px;">This product is licensed for Bandai Wireharness Philippines Inc. </p>
<p class="" style = "text-align: center; font-size: 13px;">	&copy; 2021-2022 Eyebox by Technos Systems. All Rights Reserved </p>


<p class="" style = "text-align: center; font-size: 13px;">	Ver 1.0.3199 </p>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>





</html>