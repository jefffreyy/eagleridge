<html>
<?php $this->load->view('templates/css_link'); ?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<body>
    <!-- Content Starts -->
    <div class="content-wrapper">
        <div class="p-4">
            <div class="flex-fill">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url() ?>attendances">Attendance</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= base_url() ?>attendances/shift_assignment">Shift Assignment</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Shift Assignment CSV Import</li>
                    </ol>
                </nav>
                <div class="row pr-3 mb-3">
                    <div class="col">
                        <h1 class="page-title">Shift Assignment CSV Import</h1>
                    </div>
                </div>
                <div class="card">
                    <div class="container mt-3 mb-3">
                        <div class="coud_upload">
                            <div class="donwloadFile">
                                <p class="ml-2 mr-2">Upload .csv format maximum of 10MB size. Download sample file format <i><a href="<?= base_url() ?>assets_system/csv_template/csv_import_shift.csv" download>here.</a></i></p>
                            </div>
                            <form method='post' action='<?php echo base_url(); ?>attendances/insert_shift_csv' enctype="multipart/form-data">
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
                                2. The system can't read Ñ or ñ from the csv file. To fix this, just edit the employee details<br>
                                3. Symbols or characters like 'ñ' or 'Ñ' is not allowed. Please use 'n' or 'N' instead.<br>

                            </p>
                        </div>
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
            // Quick and simple export target #table_id into a csv
            $('#btn_export_empl_info').click(function() {
                var table_id = 'tbl_employees';
                var separator = ',';
                // Select rows from table_id
                var rows = document.querySelectorAll('table#' + table_id + ' tr');
                // Construct csv
                var csv = [];
                for (var i = 0; i < rows.length; i++) {
                    var row = [],
                        cols = rows[i].querySelectorAll('td, th');
                    for (var j = 0; j < cols.length; j++) {
                        // Clean innertext to remove multiple spaces and jumpline (break csv)
                        var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
                        // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
                        data = data.replace(/"/g, '""');
                        // Push escaped string
                        row.push('"' + data + '"');
                    }
                    csv.push(row.join(separator));
                }
                var csv_string = csv.join('\n');
                // Download it
                var filename = 'Export_Employee_Data.csv';
                var link = document.createElement('a');
                link.style.display = 'none';
                link.setAttribute('target', '_blank');
                link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
                link.setAttribute('download', filename);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            })
        });
    </script>
</body>

</html>