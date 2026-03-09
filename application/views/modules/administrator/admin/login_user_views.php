<?php
$data['DISP_NAME'] = $this->setup_model->get_name();
?>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>Eyebox HRMS Admin</title>
<link rel="shortcut icon" href="<?= base_url() ?>images/company_icon.ico" type="image/x-icon">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
<?php $this->load->view('templates/css_link'); ?>

<style>
  .btn-primary {
    background-color: #008037 !important;
    border-color: #008037 !important;
  }

  .card-primary.card-outline {
    border-top: 3px solid #008037 !important;
  }
</style>

<body class="hold-transition login-page ">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center pt-4 ">
        <img class="logo_bandai" src="<?= base_url(); ?>images/system/login_logo.png" alt="" width="240">
      </div>

      <div class="card-body">
        <div class="alert alert-danger text-center">
          <h6 class="mb-0" id="err_login" name="err_login">
            Admin Login
          </h6>
        </div>

        <form action="<?php echo base_url('admin/login_user'); ?>" id="login_form" method="POST" accept-charset="utf-8" autocomplete='off'>
          <div class="input-group mb-3">
            <select class="form-control" name="user">
              <option value="">Select user</option>
              <?php foreach ($Users as $user) { ?>
                <option value="<?= $user->id ?>"> <?= $user->col_last_name . ',' . $user->col_frst_name . ' ' . $user->col_midl_name ?></option>
              <?php } ?>
            </select>

            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <button type="submit" id="btn_sign_in" class="btn btn-primary btn-block">Sign In</button>
              <a href="<?= base_url() ?>admin/signout" id="btn_sign_out" class="btn btn-secondary btn-block">Sign Out</a>
            </div>
          </div>
        </form>

        <br>
      </div>
    </div>
  </div>

  <script src="../../plugins/jquery/jquery.min.js"></script>
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../dist/js/adminlte.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
      $('select').selectize({
        sortField: 'text'
      });
    });
  </script>

</body>

</html>