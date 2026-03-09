<!DOCTYPE html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<style>
.btn-primary{
  background-color: #008037 !important;
  border-color: #008037 !important;
}

.card-primary.card-outline {
    border-top: 3px solid #FFFFFF !important;
}
</style>
<title>Eyebox HRMS Login</title>
<link rel="shortcut icon" href="<?=base_url()?>assets_system/images/favicon.ico" type="image/x-icon">
<?php $this->load->view('templates/css_link'); ?>
<body class="hold-transition login-page">
<?php 
$data['DISP_NAME'] = $this->login_model->get_name();
$DISP_LOGO = $this->header_model->get_logo();
?>
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center pt-4">
		<img class="logo_bandai" src="<?= base_url(); ?>assets_system/images/<?=$DISP_LOGO["value"]?>" alt="" width="240"> <!-- login_logo.png -->
    </div>
    <div class="card-body">
		<p class="login-box-msg">Welcome <b><?= $data['DISP_NAME']['value']; ?></b> </p>
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
        <div class="input-group mb-3" style='position:relative;'>
          <input type="password" id="password" name="CALC_INPF_PASS" class="form-control custom-input shadow-none" placeholder="Password" required>
           <i class="fa fa-eye-slash" id="togglePassword" style='position:absolute;right:44px;top:10px;cursor:pointer;z-index:5'></i>
          <div class="input-group-append" >
            <div class="input-group-text">
              <span class="fas fa-lock" id='pass_icon'></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
         <div class="">
         <input type="checkbox" id="remember" value="1" name="remember" >
         <label for="remember" class="text-secondary font-weight-normal">Remember Me</label>
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
<p class="mb-1 mt-3" style = "text-align: center; font-size: 13px;">This product is licensed for <?= $data['DISP_NAME']['value']; ?>. </p>
<p class="" style = "text-align: center; font-size: 13px;">	&copy; 2021-2023 Eyebox by Technos Systems. All Rights Reserved </p>
<p class="" style = "text-align: center; font-size: 13px;">	Ver 2.1 </p>
<!-- /.login-box -->
<!-- jQuery -->
<!-- Commented due its not found - Benar -->
<!-- <script src="../../plugins/jquery/jquery.min.js"></script> -->
<!-- Bootstrap 4 -->
<!-- Commented due its not found - Benar -->
<!-- <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
<!-- AdminLTE App -->
<!-- Commented due its not found - Benar -->
<!-- <script src="../../dist/js/adminlte.min.js"></script> -->
<?php
    if((get_cookie("username") && get_cookie("password"))){
        $username = get_cookie("username");
        $password = get_cookie("password");
        echo "<script>
            document.getElementById('username').value='$username';
            document.getElementById('password').value='$password';
        </script>";
       


    }

    
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script>
    $(document).ready(function(){
     $('#togglePassword').on('click',function(){
        let pass_type=$("#password").attr("type");
        
        if(pass_type==='password'){
            $("#password").attr("type",'text');
            
             $(this).removeClass('fa-eye-slash');
             $(this).addClass('fa-eye');
            
        }else{
            $("#password").attr("type",'password');
            $(this).addClass('fa-eye-slash');
             $(this).removeClass('fa-eye');
        }

     })
      
    })
</script>
</body>
</html>