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
<!-- Include Editor style. -->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_style.min.css" rel="stylesheet" type="text/css" />

<div class="content-wrapper">
    <div class="p-3">
        <div class="flex-fill">
            <div class="row pr-3 mb-3">
                <div class="col">
                    <h1 class="page-title">Upload Attendance Record</h1>
                </div>
                <div class="col ml-auto">
                </div>
            </div>

            <div class="card">
                <div class="container mt-3 mb-3">
                    <div class="coud_upload">
                        <div class="donwloadFile">
                            <p class="ml-2 mr-2">Upload .csv format maximum of 10MB size. Download sample file format <i><a href="<?= base_url("csv/download_Sample_File_Attendance") ?>">here.</a></i></p>
                        </div>
                        <form method='post' action='<?php echo base_url('csv/ImportCsvAttendance'); ?>' enctype="multipart/form-data">
                            <div class="ml-2 mr-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input fileficker" id="exampleInputFile" name='file'>
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
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
                            1. Date and Employee ID must be unique (not duplicated), otherwise it will not be uploaded <br>
                            2. Shift codes that will be used on the CSV must be declared on the Work Shift settings, otherwise, it will be blank. <br>
                        </p>
                    </div>
                </div>
            </div>

            <!-- <div class="row pr-3 mb-3 mt-5">
                <div class="col">
                    <h1 class="page-title">Export Employee List</h1>
                </div>
                <div class="col ml-auto">
                </div>
            </div>

            <div class="card">
                <div class="container mt-3 mb-3">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="">Cut-off period</label>
                            <select name="cutoff_period" id="cutoff_period" class="form-control">
                                <option value="">Select Period...</option>
                                <?php
                                    if($DISP_PAYROLL_SCHED){
                                        foreach($DISP_PAYROLL_SCHED as $DISP_PAYROLL_SCHED_ROW){
                                        ?>
                                        <option value="<?= $DISP_PAYROLL_SCHED_ROW->db_name ?>"><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                                        <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Employee ID</label>
                            <select name="employee" id="employee" class="form-control">
                                <option value="">Choose Employee...</option>
                                <?php
                                    if($DISP_ALL_EMPLOYEES){
                                        foreach($DISP_ALL_EMPLOYEES as $DISP_ALL_EMPLOYEES_ROW){
                                        ?>
                                        <option value="<?= $DISP_ALL_EMPLOYEES_ROW->id ?>"><?= $DISP_ALL_EMPLOYEES_ROW->col_empl_cmid ?></option>
                                        <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="w-100 text-center py-3 mt-4">
                        <a href="#" class="btn btn-primary px-5 py-3" id="btn_export_empl_info"> Export All Employee Information </a>
                    </div>
                </div>
            </div> -->
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
            $('div#froala-editor').froalaEditor({
                // Set custom buttons with separator between them.
                toolbarButtons: ['undo', 'redo', '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting', 'html'],
                toolbarButtonsXS: ['undo', 'redo', '-', 'bold', 'italic', 'html']
            })
            $('i.fa.fa-rotate-left').attr('class')

            function fasterPreview(uploader) {
                if (uploader.files && uploader.files[0]) {
                    $('.custom-file-label').text(uploader.files[0].name);
                }
            }
            $("#exampleInputFile").change(function() {
                fasterPreview(this);
            });
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