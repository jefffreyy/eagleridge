<style>

    .btn-group .btn {
        padding: 0px 12px;
    }

    .page-title {
        font-weight: 600;
        color: #424F5C;
        font-size: 33px;
    }

    th, td {
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

<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_style.min.css" rel="stylesheet" type="text/css" />
<div class="content-wrapper">
    <div class="p-3">
        <div class="flex-fill">
            <div class="row pr-3 mb-3">
                <div class="col">
                    <h1 class="page-title">Upload Employee photo</h1>
                </div>

                <div class="col ml-auto pr-0">
                    <a class="btn btn-primary float-right mt-1" title="Add" href="<?= base_url() ?>employees/csv_upload">
                        <i class="fas fa-arrow-left"></i>&nbsp;&nbsp;Back
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="edit_profile_pic w-100 text-center mt-5">
                    <img class="avatar" id="employee_img_modal" style="cursor: pointer;" width="300" height="300" src="<?php echo base_url() . 'assets_system/images/default_user.jpg'; ?>">
                </div>

                <h4 class="text-center mt-3">Upload a 1x1 Picture</h4>
                <div class="container mt-3 mb-3">
                    <div class="coud_upload">
                        <form method='post' action='<?php echo base_url('csv/uploadMultipleImages'); ?>' enctype="multipart/form-data" accept-charset="utf-8">
                            <div class="ml-2 mr-2">
                                <div class="form-group my-3">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input fileficker" id="upload_image" name='files[]' multiple="" accept=".jpg, ,.jpeg ,.png" required>
                                            <label class="custom-file-label" for="upload_image">Choose file</label>
                                        </div>

                                        <div class="input-group-append">
                                            <input class="input-group-text" type='submit' value='Upload'>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-100 text-center">
                                    <h4>Use the uploaded filename of the image in the <strong>'Image File'</strong> column of the .csv file</h4>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times; </span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Hi are you sure you want to logout? </p>
                </div>

                <div class="modal-footer pb-1 pt-1">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                    </button>
                    <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout </a>
                </div>
            </div>
        </div>
    </div>

<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>

    <script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>  $.widget.bridge('uibutton', $.ui.button) </script>
    <script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>
    <script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"> </script>
    <script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js"></script>
    <script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"> </script>
    <script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
    <script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
    <script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/js/froala_editor.pkgd.min.js"></script>

    <script>

        $(function() {
            $('div#froala-editor').froalaEditor({
                toolbarButtons: ['undo', 'redo', '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting', 'html'],
                toolbarButtonsXS: ['undo', 'redo', '-', 'bold', 'italic', 'html']
            })
            $('i.fa.fa-rotate-left').attr('class')
            $("#employee_img_modal").click(function(e) {
                $("#upload_image").click();
            });
            function fasterPreview(uploader) {
                if (uploader.files && uploader.files[0]) {
                    $('.custom-file-label').text(uploader.files[0].name);
                    Array.from(uploader.files).forEach(function(files) {
                        document.querySelector('.custom-file-label').innerHTML += " | " + files.name;
                    })
                }
            }
            $("#upload_image").change(function() {
                fasterPreview(this);
            });
        });
    </script>

    <?php
    if ($this->session->userdata('SESS_SUCC_UPDT_IMG')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_UPDT_IMG'); ?>',
                '',
                'success'
            )
        </script>

    <?php
        $this->session->unset_userdata('SESS_SUCC_UPDT_IMG');
    }
    ?>
    <?php
    if ($this->session->userdata('SESS_ERR_IMAGE')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_ERR_IMAGE'); ?>',
                '',
                'error'
            )
        </script>

    <?php
        $this->session->unset_userdata('SESS_ERR_IMAGE');
    }
    ?>
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