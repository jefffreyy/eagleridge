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
            
            <hr>

            
            


            <div class="row mb-3">
                <div class="col-6">
                    <h1 class="page-title mb-0 " style="font-size: 20px;">Step 1 - Upload Shifts, Regular Day, Regular Night Diff)</h1>
                </div>
                <div class="col-6">
                    <i class="fas fa-question-circle text-primary float-right guide_icon" style="font-size: 20px; cursor:pointer;" data-toggle="modal" data-target="#modal_step1_guides" title="View Guides"></i>
                </div>
            </div>
            <div class="card mb-4">
                <div class="container mt-3 mb-3">
                    <div class="coud_upload">
                        <div class="donwloadFile">
                            <p class="ml-2 mr-2">Upload .csv format maximum of 10MB size. Download sample file format <i><a href="<?= base_url("csv/download_sample_attendance_part1") ?>">here.</a></i></p>
                        </div>
                        <form method='post' action='<?php echo base_url('csv/ImportCsv_attendance_part1'); ?>' enctype="multipart/form-data">
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
                            1. Date and Employee ID must be unique (not duplicated), otherwise it will not be uploaded <br>
                            2. Shift codes that will be used on the CSV must be declared on the Work Shift settings, otherwise, it will be blank. <br>
                        </p>
                    </div>
                </div>
            </div>















            <div class="row mb-4">
                <div class="col-6">
                    <h1 class="page-title mb-0 " style="font-size: 20px;">Step 2 - Upload Hourly Rate (Rest day, Holidays, etc.)</h1>
                </div>
                <div class="col-6">
                    <i class="fas fa-question-circle text-primary float-right guide_icon" style="font-size: 20px; cursor:pointer;" data-toggle="modal" data-target="#modal_step2_guides" title="View Guides"></i>
                </div>
            </div>
            <div class="card mb-4">
                <div class="container mt-3 mb-3">
                    <div class="coud_upload">
                        <div class="donwloadFile">
                            <p class="ml-2 mr-2">Upload .csv format maximum of 10MB size. Download sample file format <i><a href="<?= base_url("csv/download_sample_attendance_part2") ?>">here.</a></i></p>
                        </div>
                        <form method='post' action='<?php echo base_url('csv/ImportCsv_attendance_part2'); ?>' enctype="multipart/form-data">
                            <div class="ml-2 mr-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input fileficker" id="file_step2" name='file'>
                                            <label class="custom-file-label" id="upload_att_record_label2" for="file_step2">Choose file</label>
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
                        </p>
                    </div>
                </div>
            </div>














            <div class="row mb-4">
                <div class="col-6">
                    <h1 class="page-title mb-0 " style="font-size: 20px;">Step 3 - Upload Overtime Hourly Rate (Night Diff OT, Regular OT, etc.)</h1>
                </div>
                <div class="col-6">
                    <i class="fas fa-question-circle text-primary float-right guide_icon" style="font-size: 20px; cursor:pointer;" data-toggle="modal" data-target="#modal_step3_guides" title="View Guides"></i>
                </div>
            </div>
            <div class="card mb-4">
                <div class="container mt-3 mb-3">
                    <div class="coud_upload">
                        <div class="donwloadFile">
                            <p class="ml-2 mr-2">Upload .csv format maximum of 10MB size. Download sample file format <i><a href="<?= base_url("csv/download_sample_attendance_part3") ?>">here.</a></i></p>
                        </div>
                        <form method='post' action='<?php echo base_url('csv/ImportCsv_attendance_part3'); ?>' enctype="multipart/form-data">
                            <div class="ml-2 mr-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input fileficker" id="file_step3" name='file'>
                                            <label class="custom-file-label" id="upload_att_record_label3" for="file_step3">Choose file</label>
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
                        </p>
                    </div>
                </div>
            </div>











            <div class="row mb-4">
                <div class="col-6">
                    <h1 class="page-title mb-0 " style="font-size: 20px;">Step 4 - Upload Paid Leaves</h1>
                </div>
                <div class="col-6">
                    <i class="fas fa-question-circle text-primary float-right guide_icon" style="font-size: 20px; cursor:pointer;" data-toggle="modal" data-target="#modal_step4_guides" title="View Guides"></i>
                </div>
            </div>
            <div class="card mb-4">
                <div class="container mt-3 mb-3">
                    <div class="coud_upload">
                        <div class="donwloadFile">
                            <p class="ml-2 mr-2">Upload .csv format maximum of 10MB size. Download sample file format <i><a href="<?= base_url("csv/download_sample_attendance_part4") ?>">here.</a></i></p>
                        </div>
                        <form method='post' action='<?php echo base_url('csv/ImportCsv_attendance_part4'); ?>' enctype="multipart/form-data">
                            <div class="ml-2 mr-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input fileficker" id="file_step4" name='file'>
                                            <label class="custom-file-label" id="upload_att_record_label4" for="file_step4">Choose file</label>
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
                        </p>
                    </div>
                </div>
            </div>
















            
            
            <div class="row mb-4">
                <div class="col-6">
                    <h1 class="page-title mb-0" style="font-size: 20px;">Upload Time-In / Time-Out Record</h1>
                </div>
                <div class="col-6">

                </div>
            </div>
            <div class="card">
                <div class="container mt-3 mb-3">
                    <div class="coud_upload">
                        <div class="donwloadFile">
                            <p class="ml-2 mr-2">Upload .csv format maximum of 10MB size. Download sample file format <i><a href="<?= base_url("csv/download_Sample_File_Time_In_Time_Out") ?>">here.</a></i></p>
                        </div>
                        <form method='post' action='<?php echo base_url('csv/ImportCsvTimeInTimeOut'); ?>' enctype="multipart/form-data">
                            <div class="ml-2 mr-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input fileficker" id="updt_time_in_time_out" name='file'>
                                            <label class="custom-file-label" id="updt_time_in_time_out_label" for="exampleInputFile">Choose file</label>
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
                        </p>
                    </div>
                </div>
            </div>














            <hr>
















    
            <div class="row mb-4">
                <div class="col-6">
                    <h1 class="page-title mb-0" style="font-size: 20px;">Export Attendance Record</h1>
                </div>
                <div class="col-6">

                </div>
            </div>

            <div class="card py-4 px-3">
                <div class="row">
                    <div class="col-6">
                        <label for="employee" class="required">Employee</label>
                        <select name="employee" id="employee" class="form-control">
                            <option value="">Choose Employee...</option>
                            <?php
                                if($DISP_ALL_EMPLOYEES){
                                    foreach($DISP_ALL_EMPLOYEES as $DISP_ALL_EMPLOYEES_ROW){
                                        ?>
                                            <option value="<?= $DISP_ALL_EMPLOYEES_ROW->id ?>"><?= $DISP_ALL_EMPLOYEES_ROW->col_empl_cmid.' - '.$DISP_ALL_EMPLOYEES_ROW->col_frst_name.' '.$DISP_ALL_EMPLOYEES_ROW->col_last_name ?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>

                        
                    </div>
                    <div class="col-6">
                        <label for="cutoff_period" class="required">Cut-off Period</label>
                        <select name="cutoff_period" id="cutoff_period" class="form-control">
                            <option value="">Choose Cut-off Period...</option>
                            <?php
                                if($DISP_ALL_CUTOFF_PERIOD){
                                    foreach($DISP_ALL_CUTOFF_PERIOD as $DISP_ALL_CUTOFF_PERIOD_ROW){
                                        ?>
                                            <option value="<?= $DISP_ALL_CUTOFF_PERIOD_ROW->db_name ?>"><?= $DISP_ALL_CUTOFF_PERIOD_ROW->name ?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <a href="#" class="btn btn-primary float-right" id="btn_export_attendance_record"> Export All Attendance Information </a>
                    </div>
                </div>
                
            </div>













        </div>
    </div>
















    <table style="display:none;" id="tbl_attendance">
        <thead>
            <tr>
                <th>Date</th>
                <th>Employee ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Shift Code</th>
                <th>WD</th>
                <th>RD_SP</th>
                <th>REG_HOL</th>
                <th>RD+REG_HOL</th>
                <th>RD+SP</th>
                <th>REG_OT</th>
                <th>ND</th>
                <th>ND_OT</th>
                <th>REST_OT</th>
                <th>REST_ND_OT</th>
                <th>Paid Leaves</th>
            </tr>
        </thead>
        <tbody id="tbl_container">
            
        </tbody>
    </table>























    <!-- Step 1 Guides -->
    <div class="modal fade" id="modal_step1_guides" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Step 1 Guides
                    </p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">   <div class="col-6"> <h5 class="text-bold">Column Name</h5><br>  </div>      <div class="col-6"> <h5 class="text-bold">Values to Enter</h5><br>  </div>      </div>
                    
                    <div class="row">   <div class="col-6"> <p>1. Date</p>  </div>      <div class="col-6"> <p>Date with Month / Day / Year format (e.g. '07/25/2021')</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>2. Emp ID</p>  </div>      <div class="col-6"> <p>ID number of the employee (e.g. '101')</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>3. Shift Code</p>  </div>      <div class="col-6"> <p>Code that identifies which shift to be used (e.g. '[DS 8-9]')</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>4. WD</p>  </div>      <div class="col-6"> <p>Number of day/s that the employee attended on the specified date</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>5. ND</p>  </div>      <div class="col-6"> <p>Number of hours that the employee attended during night shift</p>  </div>      </div>
                </div>
                <div class="modal-footer pb-1 pt-1">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 2 Guides -->
    <div class="modal fade" id="modal_step2_guides" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Step 2 Guides
                    </p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">   <div class="col-6"> <h5 class="text-bold">Column Name</h5><br>  </div>      <div class="col-6"> <h5 class="text-bold">Values to Enter</h5><br>  </div>      </div>
                    
                    <div class="row">   <div class="col-6"> <p>1. Date</p>  </div>      <div class="col-6"> <p>Date with Month / Day / Year format (e.g. '07/25/2021')</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>2. Emp ID</p>  </div>      <div class="col-6"> <p>ID # ofthe employee (e.g. '101')</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>3. RD_SP</p>  </div>      <div class="col-6"> <p># of hours that the employee attended during rest day</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>4. REG_HOL</p>  </div>      <div class="col-6"> <p># of hours that the employee attended during regular holiday</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>5. RD+REG_HOL</p>  </div>      <div class="col-6"> <p># of hours that the employee attended during regular holiday & rest day</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>6. RD+SP</p>  </div>      <div class="col-6"> <p># of hours that the employee attended during special holiday</p>  </div>      </div>
                    
                </div>
                <div class="modal-footer pb-1 pt-1">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 3 Guides -->
    <div class="modal fade" id="modal_step3_guides" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Step 3 Guides
                    </p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">   <div class="col-6"> <h5 class="text-bold">Column Name</h5><br>  </div>      <div class="col-6"> <h5 class="text-bold">Values to Enter</h5><br>  </div>      </div>
                    
                    <div class="row">   <div class="col-6"> <p>1. Date</p>  </div>      <div class="col-6"> <p>Date with Month / Day / Year format (e.g. '07/25/2021')</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>2. Emp ID</p>  </div>      <div class="col-6"> <p>ID number of the employee (e.g. '101')</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>3. REG_OT</p>  </div>      <div class="col-6"> <p># of Overtime hours during regular working day</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>3. ND</p>  </div>      <div class="col-6"> <p># of hours spent on night shift</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>4. ND_OT</p>  </div>      <div class="col-6"> <p># of Overtime hours on night shift</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>5. REST_OT</p>  </div>      <div class="col-6"> <p># of Overtime hours spent during rest day</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>6. REST_ND_OT</p>  </div>      <div class="col-6"> <p># of Overtime hours spent during rest day on night shift</p>  </div>      </div>
                    
                </div>
                <div class="modal-footer pb-1 pt-1">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 4 Guides -->
    <div class="modal fade" id="modal_step4_guides" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Step 4 Guides
                    </p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">   <div class="col-6"> <h5 class="text-bold">Column Name</h5><br>  </div>      <div class="col-6"> <h5 class="text-bold">Values to Enter</h5><br>  </div>      </div>
                    
                    <div class="row">   <div class="col-6"> <p>1. Date</p>  </div>      <div class="col-6"> <p>Date with Month / Day / Year format (e.g. '07/25/2021')</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>2. Emp ID</p>  </div>      <div class="col-6"> <p>ID number of the employee (e.g. '101')</p>  </div>      </div>
                    <div class="row">   <div class="col-6"> <p>3. Paid Leaves</p>  </div>      <div class="col-6"> <p># of Day/s with paid leave</p>  </div>      </div>
                    
                </div>
                <div class="modal-footer pb-1 pt-1">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                    </button>
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

    <script>
        $(document).ready(function(){
            var url_get_attendance_data = '<?= base_url() ?>csv/get_attendance_data';
            var url_get_employee_all_ampl_data = '<?= base_url() ?>attendance/get_employee_all_ampl_data';
            var url_get_all_shift_data = '<?php echo base_url(); ?>attendance/get_all_shift_data';
            
















            var empl_info_arr = [];
            var shift_info_arr = [];

            get_employee_all_ampl_data(url_get_employee_all_ampl_data, 'test').then(function(data){
                // var obj = findObjectByKey(data, 'col_empl_cmid', '10');
                // console.log(obj);
                empl_info_arr = data;
            })

            get_all_shift_data(url_get_all_shift_data, 'test').then(function(data){
                // var obj = findObjectByKey(data, 'id', '15');
                // console.log(obj);
                shift_info_arr = data;
            })

            function findObjectByKey(array, key, value) {
                for (var i = 0; i < array.length; i++) {
                    if (array[i][key] === value) {
                        return array[i];
                    }
                }
                return null;
            }





















            var count_attendance_rows = 0;

            function load_attendance_data(empl_id, cutoff_period){
                $('#tbl_container').html('');
                count_attendance_rows = 0;
                get_attendance_data(url_get_attendance_data, empl_id, cutoff_period).then(function(data){
                    Array.from(data).forEach(function(x){

                        
                        var empl_info = findObjectByKey(empl_info_arr, 'id', ""+x.empl_id+"");
                        var shift_info = findObjectByKey(shift_info_arr, 'id', ""+x.shift_id+"");

                        var empl_first_name = '';
                        var empl_last_name = '';
                        var employee_id = '';
                        var shift_code = '';

                        if(empl_info){
                            empl_first_name = empl_info.col_frst_name;
                            empl_last_name = empl_info.col_last_name;
                            employee_id = empl_info.col_empl_cmid;
                        } else {
                            empl_first_name = 'Unknown';
                            empl_last_name = 'Unknown';
                        }

                        if(shift_info){
                            shift_code = shift_info.code;
                        }

                        $('#tbl_container').append(`
                            <tr>
                                <td>`+x.date+`</td>
                                <td>`+employee_id+`</td>
                                <td>`+empl_first_name+`</td>
                                <td>`+empl_last_name+`</td>
                                <td>`+x.time_in+`</td>
                                <td>`+x.time_out+`</td>
                                <td>`+shift_code+`</td>
                                <td>`+x.bp_reg+`</td>
                                <td>`+x.bp_sp_hol+`</td>
                                <td>`+x.bp_reg_hol+`</td>
                                <td>`+x.bp_reg_hol_rest+`</td>
                                <td>`+x.bp_sp_rest+`</td>
                                <td>`+x.appr_reg_ot+`</td>
                                <td>`+x.appr_night_diff+`</td>
                                <td>`+x.appr_ns_ot+`</td>
                                <td>`+x.rest_ot+`</td>
                                <td>`+x.rest_nd_ot+`</td>
                                <td>`+x.paid_leave+`</td>
                            </tr>
                        `);
                        count_attendance_rows++;
                    })
                })
            }

























            $('#employee').change(function(e){
                var empl_id = $(this).val();
                var cutoff_period = $('#cutoff_period').val();
                load_attendance_data(empl_id, cutoff_period)
            })

            $('#cutoff_period').change(function(e){
                var empl_id = $('#employee').val();
                var cutoff_period = $(this).val();
                load_attendance_data(empl_id, cutoff_period);
            })




















            $('#btn_export_attendance_record').click(function(){
                var select_empl = $('#employee').val();
                var select_cutoff_period = $('#cutoff_period').val();

                if(!select_empl || !select_cutoff_period){
                    if(!select_empl){
                        Swal.fire(
                            'Please select an employee',
                            '',
                            'warning'
                        )
                    }

                    if(!select_cutoff_period){
                        Swal.fire(
                            'Please select cut-off period',
                            '',
                            'warning'
                        )
                    }
                    
                } else {
                    var empl_name = $('#employee option:selected').text();
                    var table_id = 'tbl_attendance';
                    var separator = ',';

                    // Select rows from table_id
                    var rows = document.querySelectorAll('table#' + table_id + ' tr');
                    // Construct csv
                    var csv = [];
                    for (var i = 0; i < rows.length; i++) {
                        var row = [], cols = rows[i].querySelectorAll('td, th');
                        for (var j = 0; j < cols.length; j++) {
                            // Clean innertext to remove multiple spaces and jumpline (break csv)
                            var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
                            // Escape double-quote with double-double-quote
                            data = data.replace(/"/g, '""');
                            // Push escaped string
                            row.push('"' + data + '"');
                        }
                        csv.push(row.join(separator));
                    }
                    var csv_string = csv.join('\n');


                    // Download it
                    var filename = empl_name+' Attendance Data.csv';
                    var link = document.createElement('a');
                    link.style.display = 'none';
                    link.setAttribute('target', '_blank');
                    link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
                    link.setAttribute('download', filename);
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }


                
            })















            async function get_attendance_data(url, empl_id, cutoff_period){
            var formData = new FormData();
            formData.append('empl_id', empl_id);
            formData.append('cutoff_period', cutoff_period);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            async function get_employee_all_ampl_data(url, empl_id){
            var formData = new FormData();
            formData.append('empl_id', empl_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            async function get_all_shift_data(url,shift_id) {
            var formData = new FormData();
            formData.append('shift_id', shift_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }
        })
    </script>

    </body>

    </html>