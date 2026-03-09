<style>
    .btn-group .btn {
        padding: 0px 12px;
    }

    .page-title {
        font-weight: 600;
        color: #424F5C;
        font-size: 25px;
    }

    th,
    td {
        font-size: 13px !important;
    }

    label.required::after {
        content: " *";
        color: red;
    }

    a:hover {
        text-decoration: none;
    }

    .active {
        font-weight: 500;
    }
</style>

<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">

<div class="content-wrapper">

    <div class="p-3">

        <div class="flex-fill">

            <div class="row pr-3 mb-3">

                <div class="col">

                    <h1 class="page-title">Import Leave Credits</h1>

                </div>

                <div class="col ml-auto">

                </div>

            </div>

            <div class="card">

                <div class="container mt-3 mb-3">

                    <div class="coud_upload">

                        <div class="donwloadFile">

                            <!-- <p class="ml-2 mr-2">Upload .csv format maximum of 10MB size. Download sample file format <i><a href="<?= base_url("csv/download_Sample_Leave_Credits_File") ?>">here.</a></i></p> -->
                            <p class="ml-2 mr-2">Upload .csv format maximum of 10MB size. Download sample file format <i><a href="<?= base_url("csv/download_Sample_Leave_Credits_File") ?>">here.</a></i></p>

                        </div>

                        <form method='post' action='<?php echo base_url('csv/import_leave_credits'); ?>' enctype="multipart/form-data">

                            <div class="ml-2 mr-2">

                                <div class="form-group">

                                    <div class="input-group">

                                        <div class="custom-file">

                                            <input type="file" class="custom-file-input fileficker" id="exampleInputFile" name='file'>
                                            <label class="custom-file-label" id="new_employee_label" for="exampleInputFile">Choose file</label>

                                        </div>

                                        <div class="input-group-append">

                                            <input class="input-group-text" type='submit' value='Upload'>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </form>

                        <label for="required "> Important Notes:</label>
                        <p>
                            1. Employee ID must be unique, otherwise, it will not be uploaded. <br>
                            2. Follow the date format: YYYY/MM/DD, otherwise it will not be uploaded. <br>
                            3. Only enter the foilowing leave types:<br>
                                &nbsp;&nbsp;&nbsp; Maternity Leave<br>
                                &nbsp;&nbsp;&nbsp; Parental Leave<br>
                                &nbsp;&nbsp;&nbsp; Service Incentive Leave<br>
                                &nbsp;&nbsp;&nbsp; Sick Leave<br>
                                &nbsp;&nbsp;&nbsp; Solo Incentive Leave<br>
                                &nbsp;&nbsp;&nbsp; Vacation Leave<br>
                        </p>

                    </div>

                </div>

            </div>



    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js">
    </script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js">
    </script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js">
    </script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js">
    </script>
    <!-- Summernote -->
    <script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js">
    </script>
    <!-- overlayScrollbars -->
    <script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js">
    </script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/adminlte.js">
    </script>
    <!-- Full Calendar 2.2.5 -->
    <script src="<?php echo base_url(); ?>plugins/moment/moment.min.js">
    </script>
    <script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js">
    </script>
    <!-- Sweet Alert -->
    <script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js">
    </script>
    <!-- Toastr -->
    <script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js">
    </script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>dist/js/demo.js">
    </script>
    <!-- DateRange Picker -->
    <script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
    </script>

    <!-- SESSION MESSAGES -->
    <?php
    if ($this->session->userdata('SESS_SUCC_MSG_INSRT_CSV')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_CSV'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_CSV');
    }
    ?>

    <?php
    if ($this->session->userdata('SESS_ERR_MSG_INSRT_CSV')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_CSV'); ?>',
                '',
                'error'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_ERR_MSG_INSRT_CSV');
    }
    ?>

    <!-- Initialize the editor. -->
    <script>
        $(function() {

            function fasterPreview1(uploader) {
                if (uploader.files && uploader.files[0]) {
                    $('#new_employee_label').text(uploader.files[0].name);
                }
            }
            $("#exampleInputFile").change(function() {
                fasterPreview1(this);
            });
            

            function fasterPreview2(uploader) {
                if (uploader.files && uploader.files[0]) {
                    $('#update_existing_label').text(uploader.files[0].name);
                }
            }
            $("#update_existing").change(function() {
                fasterPreview2(this);
            });

        });
    </script>

    </body>

    </html>