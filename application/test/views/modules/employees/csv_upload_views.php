<html>
<?php $this->load->view('templates/css_link'); ?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<body>
    <!-- Content Starts -->
    <div class="content-wrapper">
        <div class="p-3">
            <div class="flex-fill">
                <div class="row pr-3 mb-3">
                    <div class="col">
                        <h1 class="page-title">New Employee Information</h1>
                    </div>
                    <div class="col ml-auto button-title">
                        <a class="btn btn-primary mt-1" title="Add" href="<?= base_url() ?>employees/upload_employee_photo">
                            <i class="fas fa-fw fa-upload"></i> Upload Employee Photo
                        </a>
                    </div>
                </div>
                <div class="card">
                    <div class="container mt-3 mb-3">
                        <div class="coud_upload">
                            
                            <p class="ml-2 mr-2 mb-2">Upload .csv format maximum of 10MB size. Download below<i></i></p>
                            <div class="donwloadFile">
                                <a class="btn btn-primary ml-2 mr-1 mb-2" href="<?= base_url() ?>assets_system/csv_template/csv_import_new_employee_sample.csv" download>Sample file format</a>
                                <a class="btn btn-primary mb-2" href="<?= base_url() ?>assets_system/csv_template/csv_import_new_employee_template.csv" download>Template file</a>
                            </div>

                            <form method='post' action='<?php echo base_url('employees/upload_csv_new_employees'); ?>' enctype="multipart/form-data">
                                <div class="ml-2 mr-2">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input fileficker" id="exampleInputFile" name='file' required>
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
                                3. Write the proper format of Government IDs. Add dashes " - " if possible ( e.g 1023-4567-8090 )<br>
                                4. Symbols or characters like 'ñ' or 'Ñ' is not allowed. Please use 'n' or 'N' instead.<br>
                                5. The following setting items must be configured on the setting prior importation to avoid error. <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Marital Status <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Gender <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Nationality <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Shirt Size <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Employment Type <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Department <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Position <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Section <br>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row pr-3 mb-3 mt-5">
                    <div class="col">
                        <h1 class="page-title">Export Employee List</h1>
                    </div>
                    <div class="col ml-auto">
                    </div>
                </div>
                <div class="card">
                    <div class="container mt-3 mb-3">
                        <div class="w-100 text-center py-3">
                            <a href="#" class="btn btn-primary px-4 py-3" id="btn_export_empl_info"><i class="fas fa-file-export"></i> Export All Employee Information </a>
                        </div>
                    </div>
                </div>
                <div class="row pr-3 mb-3 mt-5">
                    <div class="col">
                        <h1 class="page-title">Update Existing Employee Information</h1>
                    </div>
                    <div class="col ml-auto">
                    </div>
                </div>
                <div class="card">
                    <div class="container mt-4 mb-3">
                        <div class="coud_upload">
                            <!-- <div class="donwloadFile">
                            <p class="ml-2 mr-2">Upload .csv format maximum of 10MB size. Download sample file format <i><a href="<?= base_url("csv/download_Sample_File_Updt") ?>">here.</a></i></p>
                        </div> -->
                            <form method='post' action='<?php echo base_url('employees/upload_csv_update_employees'); ?>' enctype="multipart/form-data">
                                <div class="ml-2 mr-2">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input fileficker" id="update_existing" name='file' required>
                                                <label class="custom-file-label" id="update_existing_label" for="update_existing">Choose file</label>
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
                                1. Best practice for updating to CSV, export first from the Employee List. <br>
                                2. On CSV, you may delete the rows of the employee with unchanged details. <br>
                                Upload only the employees with changed details. <br>
                                3. Changing the Employee ID is not allowed. If the admin wishes to Change the Employee ID, please create new entry of employee. <br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table style="display:none;" id="tbl_employees">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>User Access</th>
                    <th>Last Name</th>
                    <th>Middle Name</th>
                    <th>First Name</th>
                    <th>Marital Status</th>
                    <th>Home Address</th>
                    <th>Current Address</th>
                    <th>Birthday</th>
                    <th>Gender</th>
                    <th>Nationality</th>
                    <th>Shirt Size</th>
                    <th>Email Address</th>
                    <th>Mobile Number</th>
                    <th>Hired On</th>
                    <th>Employment Type</th>
                    <th>Position</th>
                    <th>Division</th>
                    <th>Group</th>
                    <th>Line</th>
                    <th>Department</th>
                    <th>Section</th>
                    <th>Image File</th>
                    <th>SSS Number</th>
                    <th>Pagibig</th>
                    <th>Philhealth</th>
                    <th>TIN</th>
                    <th>Drivers License</th>
                    <th>National ID</th>
                    <th>Passport</th>
                    <th>HMO</th>
                    <th>HMO Number</th>
                    <th>Salary Rate</th>
                    <th>Salary Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($DISP_ALL_EMPLOYEES) {
                    foreach ($DISP_ALL_EMPLOYEES as $DISP_ALL_EMPLOYEES_ROW) {
                ?>
                        <tr>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_empl_cmid ?></td>
                            <td><?= convert_user_access($C_USER_ACCESS, $DISP_ALL_EMPLOYEES_ROW->col_user_access) ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_last_name ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_midl_name ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_frst_name ?></td>
                            <td><?= convert_id2name($C_MARITAL,$DISP_ALL_EMPLOYEES_ROW->col_mart_stat) ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_home_addr ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_curr_addr ?></td>
                            <td><?= date('d/m/Y', strtotime($DISP_ALL_EMPLOYEES_ROW->col_birt_date)) ?></td>
                            <td><?= convert_id2name($C_GENDERS,$DISP_ALL_EMPLOYEES_ROW->col_empl_gend)  ?></td>
                            <td><?= convert_id2name($C_NATIONALITY,$DISP_ALL_EMPLOYEES_ROW->col_empl_nati) ?></td>
                            <td><?= convert_id2name($C_SHIRT_SIZE,$DISP_ALL_EMPLOYEES_ROW->col_shir_size) ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_empl_emai ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_mobl_numb ?></td>
                            <td><?= date('d/m/Y', strtotime($DISP_ALL_EMPLOYEES_ROW->col_hire_date)) ?></td>
                            <td><?= convert_id2name($C_TYPE,$DISP_ALL_EMPLOYEES_ROW->col_empl_type) ?></td>
                            <td><?= convert_id2name($C_POSITIONS,$DISP_ALL_EMPLOYEES_ROW->col_empl_posi) ?></td>
                            <td><?= convert_id2name($C_DIVISIONS,$DISP_ALL_EMPLOYEES_ROW->col_empl_divi) ?></td>
                            <td><?= convert_id2name($C_GROUPS,$DISP_ALL_EMPLOYEES_ROW->col_empl_group) ?></td>
                            <td><?= convert_id2name($C_LINES,$DISP_ALL_EMPLOYEES_ROW->col_empl_line) ?></td>
                            <td><?= convert_id2name($C_DEPARTMENTS,$DISP_ALL_EMPLOYEES_ROW->col_empl_dept) ?></td>
                            <td><?= convert_id2name($C_SECTIONS,$DISP_ALL_EMPLOYEES_ROW->col_empl_sect) ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_imag_path ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_empl_sssc ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_empl_hdmf ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_empl_phil ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_empl_btin ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_empl_driv ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_empl_naid ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_empl_pass ?></td>
                            <td><?= convert_id2name($C_HMOS,$DISP_ALL_EMPLOYEES_ROW->col_empl_hmoo) ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->col_empl_hmon ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->salary_rate ?></td>
                            <td><?= $DISP_ALL_EMPLOYEES_ROW->salary_type ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
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
    <?php $this->load->view('templates/jquery_link'); ?>

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

        <?php 
        function convert_id2name($array, $id)
        {
            $name = "";
            foreach ($array as $e) {
                if ($e->id == $id) {
                    $name = $e->name;
                    return $name;
                }
            }
            return 0;
        }
        
        function convert_user_access($array, $id)
        {
            $name = "";
            foreach ($array as $e) {
                if ($e->id == $id) {
                    $name = $e->user_access;
                    return $name;
                }
            }
            return 0;
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