<style>
    .btn-group .btn {
        padding: 0px 12px;
    }

    .page-title {
        font-weight: 600;
        color: #424F5C;
        font-size: 28px;
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

    .guide_icon:hover{
        transition: 0.5s;
        border-radius: 50%;
        box-shadow: 0px 2px 6px 2px rgba(99,155,220,0.53);
        -webkit-box-shadow: 0px 2px 6px 2px rgba(99,155,220,0.53);
        -moz-box-shadow: 0px 2px 6px 2px rgba(99,155,220,0.53);
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
                    <h1 class="page-title">Import Deductions</h1>
                </div>
                <div class="col ml-auto">
                </div>
            </div>
            
            <hr>


            <div class="row mb-3">
                <div class="col-6">
                    <h1 class="page-title mb-0 " style="font-size: 20px;">Upload Employee Deductions</h1>
                </div>
                <div class="col-6">
                    
                </div>
            </div>
            <div class="card mb-4">
                <div class="container mt-3 mb-3">
                    <div class="coud_upload">
                        <div class="donwloadFile">
                            <p class="ml-2 mr-2">Upload .csv format maximum of 10MB size. Download sample file format <i><a href="<?= base_url() ?>sample_file/Sample_deductions_format.csv" download>here.</a></i></p>
                        </div>
                        <form method='post' action='<?php echo base_url('csv/importDeductions'); ?>' enctype="multipart/form-data">
                            <div class="ml-2 mr-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input fileficker" id="file_step1" name='file'>
                                            <label class="custom-file-label" id="upload_att_record_label" for="file_step1">Choose file</label>
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
                            1. Please Enter the exact amount of deduction for each category - Uniform Deduction, Salary Advances<br>
                            2. Leave it blank if there's none<br>
                        </p>
                    </div>
                </div>
            </div>




        </div>
    </div>
















    <!-- LOGOUT MODAL -->
    <div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?
                    </p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Hi are you sure you want to logout?
                    </p>
                </div>
                <div class="modal-footer pb-1 pt-1">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                    </button>
                    <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout
                    </a>
                </div>
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
    <!-- Include Editor JS files. -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/js/froala_editor.pkgd.min.js">
    </script>
    <!-- Initialize the editor. -->
    <script>
        $(function() {
            $('i.fa.fa-rotate-left').attr('class')
            
            // step 1
            function fasterPreview(uploader) {
                if (uploader.files && uploader.files[0]) {
                    $('#upload_att_record_label').text(uploader.files[0].name);
                }
            }

            // step 2
            function fasterPreview2(uploader) {
                if (uploader.files && uploader.files[0]) {
                    $('#upload_att_record_label2').text(uploader.files[0].name);
                }
            }

            // step 3
            function fasterPreview3(uploader) {
                if (uploader.files && uploader.files[0]) {
                    $('#upload_att_record_label3').text(uploader.files[0].name);
                }
            }

            // step 4
            function fasterPreview4(uploader) {
                if (uploader.files && uploader.files[0]) {
                    $('#upload_att_record_label4').text(uploader.files[0].name);
                }
            }
            
            function fasterPreview_timein_timeout(uploader) {
                if (uploader.files && uploader.files[0]) {
                    $('#updt_time_in_time_out_label').text(uploader.files[0].name);
                }
            }

            // step 1
            $("#file_step1").change(function() {
                fasterPreview(this);
            });

            // step 2
            $("#file_step2").change(function() {
                fasterPreview2(this);
            });

            // step 3
            $("#file_step3").change(function() {
                fasterPreview3(this);
            });

            // step 4
            $("#file_step4").change(function() {
                fasterPreview4(this);
            });



            $('#updt_time_in_time_out').change(function(){
                fasterPreview_timein_timeout(this);
            })

        });
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

    </body>

    </html>