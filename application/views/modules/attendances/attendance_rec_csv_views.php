<html>
<?php $this->load->view('templates/css_link'); ?>

<body>
    <div class="content-wrapper">
        <div class="p-4">
            <div class="flex-fill">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url() ?>attendances">Attendance</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= base_url() ?>attendances/attendance_records">Attendance Records</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Attendance Records CSV Import</li>
                    </ol>
                </nav>

                <div class="row pr-3 mb-3">
                    <div class="col d-flex align-items-center">
                        <a href="<?= base_url() . 'attendances/attendance_records'; ?>"><i class="h4 mb-1 mr-3 fa-duotone fa-circle-left"></i></a>
                        <h1 class="page-title d-inline">Attendance Records CSV Import</h1>
                    </div>
                </div>

                <div class="card">
                    <div class="container mt-3 mb-3">
                        <div class="coud_upload">
                            <div class="donwloadFile">
                                <p class="ml-2 mr-2">Upload .csv format maximum of 10MB size. Download sample file format <i><a href="<?= base_url() ?>assets_system/csv_template/csv_import_attendance_record.csv" download>here.</a></i></p>
                            </div>

                            <form method='post' action='<?php echo base_url(); ?>attendances/attendance_rec_csv_process' enctype="multipart/form-data">
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
                                4. Date must be unique, Date sample format 'March 15, 2023'.<br>
                                5. Time sample format '06:54:02'.<br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
    <?php $this->load->view('templates/jquery_link'); ?>
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
            $('#btn_export_empl_info').click(function() {
                var table_id = 'tbl_employees';
                var separator = ',';
                var rows = document.querySelectorAll('table#' + table_id + ' tr');
                var csv = [];
                for (var i = 0; i < rows.length; i++) {
                    var row = [],
                        cols = rows[i].querySelectorAll('td, th');
                    for (var j = 0; j < cols.length; j++) {
                        var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
                        data = data.replace(/"/g, '""');
                        row.push('"' + data + '"');
                    }
                    csv.push(row.join(separator));
                }
                var csv_string = csv.join('\n');
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