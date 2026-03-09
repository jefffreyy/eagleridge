<!doctype html>

<html lang="en" style='height:100%'>

<head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Eyebox HRMS Forgot Password</title>

    <!-- Google Font: Source Sans Pro -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->

    <!--<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">-->
    <!--<link rel="shortcut icon" href="<?=base_url()?>images/system/favicon.ico" type="image/x-icon">-->
    <!-- icheck bootstrap -->

    <!--<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">-->

    <!-- Theme style -->

    <!--<link rel="stylesheet" href="../../dist/css/adminlte.min.css">-->



    <?php $this->load->view('templates/css_link'); ?>
     <script src="../../dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
</head>

<body class="hold-transition login-page" style='height:100%;'>

    <div class="login-box">

        <div class="card card-outline card-success">

            <div class="card-header text-center">

                <img class="logo_bandai" src="<?= base_url(); ?>images/<?=$DISP_LOGO['value']; ?>" alt="" width="240">

            </div>

            <div class="card-body">

                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

                <form action="<?php echo base_url('login/send_email'); ?>" id="login_form" method="POST" accept-charset="utf-8" autocomplete='off'>

                    <div class="input-group mb-3">

                        <!--<input type = "email" name = "user_email" class="form-control" placeholder="Email"  required>-->
                        <input type = "text" name = "user_name" class="form-control" placeholder="Username"  required>
                        <div class="input-group-append">

                            <div class="input-group-text">

                                <!--<span class="fas fa-envelope"></span>-->
                                <span class="fas fa-user"></span>
                                

                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12">

                            <button type = "submit" name = "btn_send" class="btn btn-success btn-block">Request new password</button>

                        </div>

                        <!-- /.col -->

                    </div>

                </form>

                <p class="mt-3 mb-1">

                    <a  href="<?=base_url();?>login">Login</a>

                </p>

            </div>

            <!-- /.login-card-body -->

        </div>

    </div>

    <!-- /.login-box -->

    <!-- jQuery -->

    <script src="../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap 4 -->

    <!--<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>-->

    <!-- AdminLTE App -->

   
    <script>
       <?php if( $this->session->flashdata('success')){ ?>
        Swal.fire(
          'Success!',
          "<?=$this->session->flashdata('success')?>",
          'success'
        )
        
    <?php } ?>
    </script>

</body>

</html>