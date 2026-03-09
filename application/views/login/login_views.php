<?php
if ($maiya_theme["value"] == 1) {
  $theme_color         = "border-primary";
} else {
  $theme_color         = " ";
}
?>

<!DOCTYPE html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">

<style>
  .btn-primary {
    background-color: #008037 !important;
    border-color: #008037 !important;
  }

  .card-primary.card-outline {
    border-top: 3px solid #FFFFFF !important;
  }

  .togglePassword {
    z-index: 1111;
    position: absolute;
    right: 60px;
    bottom: 9px;
    height: 1.2rem;
    width: 1.2rem;
    transition: transform 0.6s ease-in-out;
  }
</style>

<title>Eyebox HRMS Login</title>
<link rel="shortcut icon" href="<?= base_url() ?>assets_system/images/favicon.ico" type="image/x-icon">
<?php $this->load->view('templates/css_link'); ?>

<body class="hold-transition login-page">
  <?php
  $data['DISP_NAME'] = $this->login_model->get_name();
  // $DISP_LOGO = $this->header_model->get_logo();
  ?>

  <div class="login-box">
    <div class="card card-outline card-success <?= $theme_color ?>">
      <!-- <p>test</p> -->
      <p>
      <div class="card-header text-center pt-4">
        <img class="logo_bandai" src="<?= base_url('assets_system/images/' . $DISP_LOGO['value'])  ?>" alt="" width="240"> <!-- login_logo.png -->
      </div>

      <div class="card-body">
        <p class="login-box-msg">Welcome <b><?= $data['DISP_NAME']['value']; ?></b> </p>
        <p class="login-box-msg">Sign in to start your session</p>

        <!-- Test Marco test ben-->
        <?php
        if ($this->session->userdata('SESS_ERR_MSG_INVALID1')) {
        ?>
          <!-- Test MArco2 -->
          <div class="alert alert-danger text-center">
            <h6 class="mb-0" id="err_login" name="err_login">
              <i class="fa-duotone fa-circle-exclamation fa-lg pt-2"></i>&nbsp;<?php echo $this->session->userdata('SESS_ERR_MSG_INVALID1'); ?>
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
              <i class="fa-duotone fa-circle-exclamation fa-lg pt-2"></i>&nbsp;<?php echo $this->session->userdata('SESS_ERR_MSG_INVALID2'); ?>
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
              <i class="fa-duotone fa-circle-exclamation fa-lg pt-2"></i>&nbsp;<?php echo $this->session->userdata('SESS_ERR_MSG_INCOMPLETE'); ?>
            </h6>
          </div>

        <?php
          $this->session->unset_userdata('SESS_ERR_MSG_INCOMPLETE');
        }
        ?>

        <form action="<?php echo base_url('login/sign_in'); ?>" id="login_form" method="POST" accept-charset="utf-8" autocomplete='off'>
          <div class="input-group mb-3">
            <input type="text" name="CALC_INPF_EMPL_ID" id="username" class="form-control custom-input shadow-none" placeholder="Employee ID" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <!-- <span class="fas fa-user"></span> -->
                <img style="height: 1rem; width: 1rem;" src="<?php echo base_url('assets_system/icons/user-solid.svg') ?>" alt="">
              </div>
            </div>
          </div>

          <!-- <div class="input-group mb-3" style='position:relative;'>
            <input type="password" id="password" name="CALC_INPF_PASS" class="form-control custom-input shadow-none" placeholder="Password" required>
            <img class="togglePassword hide" src="<?= base_url('assets_system/icons/eye-solid_pass.svg') ?>" alt="" style="display: none;">
            <img class="togglePassword show" src="<?= base_url('assets_system/icons/eye-slash-solid_pass.svg') ?>" alt="" >
            <div class="input-group-append">
              <div class="input-group-text">
                <img style="height: 1rem; width: 1rem;" src="<?php echo base_url('assets_system/icons/lock-solid.svg') ?>" alt="" >
              </div>
            </div>
          </div> -->
          <div class="input-group mb-3" style='position:relative;'>
            <input type="password" id="password" name="CALC_INPF_PASS" class="form-control custom-input shadow-none" placeholder="Password" required>
            <img class="togglePassword hide" src="<?= base_url('assets_system/icons/eye-slash-solid_pass.svg') ?>" alt="">
            <img class="togglePassword hide" src="<?= base_url('assets_system/icons/eye-solid_pass.svg') ?>" alt="" style="display: none;">
            <div class="input-group-append">
              <div class="input-group-text">
                <img style="height: 1rem; width: 1rem;" src="<?php echo base_url('assets_system/icons/lock-solid.svg') ?>" alt="">
              </div>
            </div>
          </div>

          <div class="input-group mb-3">
            <div class="">
              <input type="checkbox" id="remember" value="1" name="remember">
              <p for="remember" class="text-secondary font-weight-normal" style="display: inline; margin-left: 2px; font-size: 15px;">Remember Me</p>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <button type="submit" id="btn_sign_in" name="CALC_BTN_SAVE" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>
        <?php if ($forgot_pass_disable_enable == 1) { ?>
          <p class="mb-1 mt-3">
            <a href="<?= base_url() ?>login/forgot_password">I forgot my password</a>
          </p>
        <?php } ?>
        <br>
      </div>
    </div>
  </div>

  <p class="mb-1 mt-3" style="text-align: center; font-size: 13px;">This product is licensed for <?= $data['DISP_NAME']['value']; ?>. </p>
  <p class="" style="text-align: center; font-size: 13px;"> &copy; 2021-2023 Eyebox by Technos Systems. All Rights Reserved </p>
  <p class="" style="text-align: center; font-size: 13px;"> Ver 2.1 </p>
  <?php
  if ((get_cookie("username") && get_cookie("password"))) {
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
    $(document).ready(function() {
      var passwordInput = $("#password");
      var togglePasswords = $(".togglePassword");

      function togglePasswordVisibility() {
        var pass_type = passwordInput.attr("type");
        if (pass_type === 'password') {
          passwordInput.attr("type", 'text');
        } else {
          passwordInput.attr("type", 'password');
        }
      }

      passwordInput.on('input', function() {
        if ($(this).val().trim() !== '') {
          togglePasswords.eq(0).show();
          togglePasswords.eq(1).hide();
        } else {
          togglePasswords.eq(0).hide();
          togglePasswords.eq(1).hide();
        }
      });

      togglePasswords.on('click', function() {
        togglePasswordVisibility();
        togglePasswords.toggle();
      });
    });
  </script>

  <script>
    // Prevent back navigation
    function preventBack() {
      window.history.forward();
    }

    setTimeout(preventBack, 0);
    window.onunload = function() {
      null;
    };

    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function() {
      window.history.pushState(null, "", window.location.href);
    };
  </script>

</body>

</html>