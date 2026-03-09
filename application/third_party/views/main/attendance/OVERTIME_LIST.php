<style>
 .btn-group .btn{
    padding: 0px 12px;
  }
  .page-title{
    font-weight: 600;
    color: #424F5C;
    font-size: 33px;
  }
  th,td{
    font-size: 13px !important;
  }
  label.required::after{
    content:" *";
    color: red;
  }
</style>


<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Pagination -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/bs-pagination.min.css">


<?php
    //get the url
    $url_count = $this->uri->total_segments();
    $url_directory = $this->uri->segment($url_count);
?>


<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-md-6">
                <h1 class="page-title">Overtime<h1>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() ?>employees/new_employee" type="button" data-toggle="modal" data-target="#modal_application_overtime" class="btn btn-primary shadow-none"><i class="fas fa-plus"></i> Application for Overtime</a>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-3">
                <label for="filter_employee">Filter by Employees</label>
                <select name="filter_employee" id="filter_employee" class="form-control">
                    <option value="">All Employees</option>
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
            <div class="col-md-3">
                <label for="filter_cutoff_period">Filter by cutoff period</label>
                <select name="filter_cutoff_period" id="filter_cutoff_period" class="form-control">
                    <option value="">All Cut-off Period</option>
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

        <br>
        <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">
            <table id="tbl_application" class="table table-hover">
                <thead>
                        <th>Application ID</th>
                        <th>Application Date</th>
                        <th>Assigned By</th>
                        <th>Employee</th>
                        <th>Overtime Date</th>
                        <th>Time Out</th>
                        <th>Type</th>
                        <th>No. of Hours</th>
                        <th>Reason</th>
                        <th>Status <br> (Approver 1)</th>
                        <th>Status <br> (Approver 2)</th>
                        <!-- <th>Status <br> (Approver 3)</th> -->
                        <th>Comment</th>
                        <th>Action</th>
                </thead>
                <tbody id="tbl_application_container">
                    <?php 
                        if($DISP_ALL_OVERTIME){
                            foreach($DISP_ALL_OVERTIME as $DISP_ALL_OVERTIME_ROW){
                                $application_id = 'OT'.str_pad($DISP_ALL_OVERTIME_ROW->id, 5, '0', STR_PAD_LEFT);
                                $db_time_out = explode(':',$DISP_ALL_OVERTIME_ROW->time_out);
                                $time_out = $db_time_out[0].':'.$db_time_out[1];
                                
                                $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_ALL_OVERTIME_ROW->empl_id);
                                $assigned_by = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_ALL_OVERTIME_ROW->assigned_by);
                                if($assigned_by[0]->col_midl_name){
                                    $midl_ini = $assigned_by[0]->col_midl_name[0].'.';
                                }else{
                                    $midl_ini = '';
                                }
                                if($employee[0]->col_midl_name){
                                    $midl_ini2 = $employee[0]->col_midl_name[0].'.';
                                }else{
                                    $midl_ini2 = '';
                                }
                            ?>
                                <tr clas="row_application">
                                    <td class="ot_row" employee_id="<?= $DISP_ALL_OVERTIME_ROW->empl_id ?>" overtime_id="<?= $DISP_ALL_OVERTIME_ROW->id ?>" data-toggle="modal" data-target="#modal_overtime_details" style="cursor: pointer;"><?= $application_id ?></td>
                                    <td class="ot_row" employee_id="<?= $DISP_ALL_OVERTIME_ROW->empl_id ?>" overtime_id="<?= $DISP_ALL_OVERTIME_ROW->id ?>" data-toggle="modal" data-target="#modal_overtime_details" style="cursor: pointer;"><?= date('M j, Y',strtotime($DISP_ALL_OVERTIME_ROW->date_created)) ?></td>
                                    <td class="ot_row" employee_id="<?= $DISP_ALL_OVERTIME_ROW->empl_id ?>" overtime_id="<?= $DISP_ALL_OVERTIME_ROW->id ?>" data-toggle="modal" data-target="#modal_overtime_details" style="cursor: pointer;">
                                        <a href = "<?=base_url()?>employees/personal?id=<?= $assigned_by[0]->id ?>">
                                            <img class="rounded-circle avatar " width="35" height="35" src="<?php if($assigned_by[0]->col_imag_path){echo base_url().'user_images/'.$assigned_by[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $assigned_by[0]->col_last_name.', '.$assigned_by[0]->col_frst_name.' '.$midl_ini?>
                                        </a>
                                    </td>
                                    <td class="ot_row" employee_id="<?= $DISP_ALL_OVERTIME_ROW->empl_id ?>" overtime_id="<?= $DISP_ALL_OVERTIME_ROW->id ?>" data-toggle="modal" data-target="#modal_overtime_details" style="cursor: pointer;">
                                        <a href = "<?=base_url()?>employees/personal?id=<?= $employee[0]->id ?>">
                                            <img class="rounded-circle avatar " width="35" height="35" src="<?php if($employee[0]->col_imag_path){echo base_url().'user_images/'.$employee[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $employee[0]->col_last_name.', '.$employee[0]->col_frst_name.' '.$midl_ini2?>
                                        </a>
                                    </td>
                                    <td class="ot_row" employee_id="<?= $DISP_ALL_OVERTIME_ROW->empl_id ?>" overtime_id="<?= $DISP_ALL_OVERTIME_ROW->id ?>" data-toggle="modal" data-target="#modal_overtime_details" style="cursor: pointer;"><?= date('M j, Y',strtotime($DISP_ALL_OVERTIME_ROW->date_ot)) ?></td>
                                    <td class="ot_row" employee_id="<?= $DISP_ALL_OVERTIME_ROW->empl_id ?>" overtime_id="<?= $DISP_ALL_OVERTIME_ROW->id ?>" data-toggle="modal" data-target="#modal_overtime_details" style="cursor: pointer;"><?= $time_out ?></td>
                                    <td class="ot_row" employee_id="<?= $DISP_ALL_OVERTIME_ROW->empl_id ?>" overtime_id="<?= $DISP_ALL_OVERTIME_ROW->id ?>" data-toggle="modal" data-target="#modal_overtime_details" style="cursor: pointer;"><?= $DISP_ALL_OVERTIME_ROW->type ?></td>
                                    <td class="ot_row" employee_id="<?= $DISP_ALL_OVERTIME_ROW->empl_id ?>" overtime_id="<?= $DISP_ALL_OVERTIME_ROW->id ?>" data-toggle="modal" data-target="#modal_overtime_details" style="cursor: pointer;"><?= $DISP_ALL_OVERTIME_ROW->hours ?></td>
                                    <td class="ot_row" employee_id="<?= $DISP_ALL_OVERTIME_ROW->empl_id ?>" overtime_id="<?= $DISP_ALL_OVERTIME_ROW->id ?>" data-toggle="modal" data-target="#modal_overtime_details" style="cursor: pointer;"><?= $DISP_ALL_OVERTIME_ROW->reason ?></td>
                                    <td class="ot_row" employee_id="<?= $DISP_ALL_OVERTIME_ROW->empl_id ?>" overtime_id="<?= $DISP_ALL_OVERTIME_ROW->id ?>" data-toggle="modal" data-target="#modal_overtime_details" style="cursor: pointer;"><?= $DISP_ALL_OVERTIME_ROW->status1 ?></td>
                                    <td class="ot_row" employee_id="<?= $DISP_ALL_OVERTIME_ROW->empl_id ?>" overtime_id="<?= $DISP_ALL_OVERTIME_ROW->id ?>" data-toggle="modal" data-target="#modal_overtime_details" style="cursor: pointer;"><?= $DISP_ALL_OVERTIME_ROW->status2 ?></td>
                                    <!-- <td><?= $DISP_ALL_OVERTIME_ROW->status3 ?></td> -->
                                    <td class="ot_row" employee_id="<?= $DISP_ALL_OVERTIME_ROW->empl_id ?>" overtime_id="<?= $DISP_ALL_OVERTIME_ROW->id ?>" data-toggle="modal" data-target="#modal_overtime_details" style="cursor: pointer;"><?= $DISP_ALL_OVERTIME_ROW->comment ?></td>
                                    <td>
                                        <?php
                                            if(($DISP_ALL_OVERTIME_ROW->status1 == 'Approved') && ($DISP_ALL_OVERTIME_ROW->status2 == 'Approved')){
                                                ?>
                                                    <a href="#" class="btn btn-primary btn_edit_overtime" overtime_id="<?= $DISP_ALL_OVERTIME_ROW->id ?>" data-toggle="modal" data-target="#modal_edit_overtime">Edit</a>
                                                <?php
                                            } else {
                                                ?>
                                                    <button href="#" class="btn btn-secondary" disabled>Edit</button>
                                                <?php
                                            }
                                        ?>
                                        
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                                <tr>
                                    <td colspan="10">No Applications Yet</td>
                                </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>

            <center><ul id="btn_pagination" class="pagination mr-auto ml-auto"></ul></center>

        </div>
    </div>
</div>

<!-- =============== Application Overtime ================= -->
<div class="modal fade" id="modal_application_overtime" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Application for Overtime
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;
                    </span>
                </button>
            </div>
            <form action="<?php echo base_url('attendance/insrt_assign_overtime'); ?>" id="form_add_overtime" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="required " for="EMPLOYEE_ID">Employee ID</label>
                                <select name="EMPLOYEE_ID" id="EMPLOYEE_ID" class="form-control">
                                    <option value="">Choose Employee...</option>
                                    <?php 
                                        foreach($DISP_EMPL_INFO as $DISP_EMPL_INFO_ROW){
                                            ?>
                                                <option value="<?= $DISP_EMPL_INFO_ROW->id ?>"><?= $DISP_EMPL_INFO_ROW->col_empl_cmid.' - '.$DISP_EMPL_INFO_ROW->col_frst_name.' '.$DISP_EMPL_INFO_ROW->col_last_name ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="required " for="OVERTIME_INPF_OVRTIME_DATE">Overtime Date
                                </label>
                                <input type="date" name="overtime_date" id="overtime_date" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="required " for="OVERTIME_INPF_OVRTIME_DATE">Time Out
                                </label>
                                <div class="input-group date" id="timepicker" data-target-input="nearest" style="width: 100% !important;">
                                    <input type="text" class="form-control datetimepicker-input time_text mr-0" data-target="#timepicker" id="time_out" placeholder="hr:min" required>
                                    <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="required " for="reason">No. of Hours
                                </label>
                                <input type="number" name="num_hours" id="num_hours" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="required " for="reason">Reason
                                </label>
                                <textarea name="reason" id="reason" class="form-control" cols="30" rows="03"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="time_out" id="time_out_formatted">
                    <input type="hidden" name="url_directory" value="<?= $url_directory ?>">
                    <a class='btn btn-primary text-light' id="btn_apply_overtime">&nbsp; Apply
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =============== Edit Overtime ================= -->
<div class="modal fade" id="modal_edit_overtime" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Overtime
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;
                    </span>
                </button>
            </div>
            <form action="<?php echo base_url('attendance/updt_overtime_application'); ?>" id="form_edit_overtime" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label class="required " for="appl_empl_id">Employee ID</label>
                                <select name="appl_empl_id" id="appl_empl_id" class="form-control" disabled>
                                    <?php 
                                        $user_data = $this->p020_emplist_mod->MOD_DISP_ALL_EMPLOYEES();
                                        foreach($user_data as $user_data_row){
                                            ?>
                                                <option value="<?= $user_data_row->id ?>"><?= $user_data_row->col_empl_cmid.' - '.$user_data_row->col_frst_name.' '.$user_data_row->col_last_name; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="required " for="appl_ot_duration">Applied Overtime Duration (Hours)</label>
                                <input type="number" name="appl_ot_duration" id="appl_ot_duration" class="form-control" placeholder="Applied Overtime Duration" disabled>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="required " for="appl_time_in">Time In</label>
                                        <input type="text" name="appl_time_in" id="appl_time_in" class="form-control" placeholder="Recorded Time In" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="required " for="appl_time_out">Applied Time Out</label>
                                        <input type="text" name="appl_time_out" id="appl_time_out" class="form-control" placeholder="Applied Time Out" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="required " for="appl_time_out">Actual Time Out</label>
                                        <input type="text" name="actual_time_out" id="actual_time_out" class="form-control" placeholder="Actual Time Out" disabled>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <label class="required " for="actual_ot_duration">Actual Overtime Duration (Hours)</label>
                                <input type="number" name="actual_ot_duration" id="actual_ot_duration" class="form-control" placeholder="Enter actual overtime duration">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="appl_overtime_id" id="appl_overtime_id">
                    <input type="hidden" name="appl_overtime_date" id="appl_overtime_date">
                    <input type="hidden" name="appl_overtime_empl_id" id="appl_overtime_empl_id">
                    <input type="hidden" name="appl_type" id="appl_type">
                        <button type="submit" class='btn btn-primary text-light' id="btn_save_overtime">&nbsp; Save</button>
                </div>
            </form>
        </div>
    </div>
</div>







<!-- View For Approval Overtime Details -->
<div class="modal fade" id="modal_overtime_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title mt-0 ml-1">Overtime Details
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body pb-5">
        <div class="row">
          <div class="col-md-4">
            <div class="w-100 text-center pt-4">
              <img id="ot_modal_employee_img" class="rounded-circle" alt="" style="width: 150px; height: 150px;">
            </div>
            <div class="pl-3 mt-3">
              <p class="text-bold mb-1">Name:</p>
              <p class="mb-4" id="ot_employee_name"></p>
              <p class="text-bold mb-1">Position:</p>
              <p class="mb-4" id="ot_employee_position"></p>
              <p class="text-bold mb-1">Department:</p>
              <p class="mb-4" id="ot_employee_department"></p>
            </div>
          </div>
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Application Date:</p>
                  <p class="mb-4" id="ot_application_date"></p>
                  <p class="text-bold mb-1">Overtime Date:</p>
                  <p class="mb-4" id="ot_overtime_date"></p>
                  <p class="text-bold mb-1">Time Out:</p>
                  <p class="mb-4" id="ot_time_out"></p> 
                </div>
              </div>
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Type:</p>
                  <p class="mb-4"id="ot_type"></p>
                  <p class="text-bold mb-1">No. of Hours:</p>
                  <p class="mb-4"id="ot_num_hours"></p>
                  <p class="text-bold mb-1">Reason:</p>
                  <p class="mb-4"id="ot_reason"></p>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p class="text-bold mb-1">Status:</p>
                    <p id="ot_status" class="text-success"></p>
                </div>
                <div class="col-md-6" id="reason_rejection">
                  <p class="text-bold mb-1 text-danger">Reason for Rejection:</p>
                  <p id="ot_rejection_comment"></p>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>









<?php 
    $page_count = $DISP_ROW_COUNT[0]->ot_count/20;
    
    if(($DISP_ROW_COUNT[0]->ot_count % 20) != 0){
        $page_count = $page_count++;
    }

    $page_count = ceil($page_count);
?>

<input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT[0]->ot_count ?>">
<input type="hidden" id="page_count" value="<?= $page_count ?>">

<aside class="control-sidebar control-sidebar-dark">
</aside>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<!-- jQuery -->
<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>
<!-- Full Calendar 2.2.5 -->
<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js"></script>
<!-- Sweet Alert -->
<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
<!-- InputMask (Required for Timepicker)-->
<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Pagination -->
<script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>





<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_OVERTIME')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_OVERTIME'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_OVERTIME');
}
?>
<?php
if ($this->session->userdata('SESS_ERR_MSG_INSRT_OVERTIME')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_OVERTIME'); ?>',
            '',
            'error'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_ERR_MSG_INSRT_OVERTIME');
}
?>
<script>
    $(document).ready(function() {
        var url_get_overtime_data_for_updt = '<?= base_url() ?>attendance/get_overtime_data_for_updt';
        var url_get_attendance_record_data = '<?= base_url() ?>attendance/get_attendance_record_data';
        var url_get_ot_application_data = '<?= base_url() ?>attendance/get_ot_application_data';
        var url_get_all_ampl_data = '<?= base_url() ?>attendance/get_all_ampl_data';
        var url_get_overtime_data = '<?php echo base_url(); ?>approval/get_overtime_data';
        var url_get_overtime = '<?= base_url() ?>attendance/get_overtime';
        var base_url = '<?= base_url() ?>';

        //Timepicker
        $('#timepicker').datetimepicker({
            stepping: 30,
            format: 'LT'
        })

        $('#btn_apply_overtime').click(function(e) {
            var overtime_date = $('#overtime_date').val();
            var time_out = $('#time_out').val();
            var num_hours = $('#num_hours').val();
            var reason = $('#reason').val();
            var hasErr = 0;

            var time_out_formatted = moment(time_out, "LT").format("HH:mm");
            $('#time_out_formatted').val(time_out_formatted);

            if (!overtime_date) {
                hasErr++;
                $('#overtime_date').addClass('is-invalid');
            }
            if (!time_out) {
                hasErr++;
                $('#time_out').addClass('is-invalid');
            }
            if (!num_hours) {
                hasErr++;
                $('#num_hours').addClass('is-invalid');
            }
            if (!reason) {
                hasErr++;
                $('#reason').addClass('is-invalid');
            }

            if (!hasErr) {
                $('#form_add_overtime').submit();
            } else {
                e.preventDefault();
            }
        })

        $('#overtime_date').change(function() {
            $('#overtime_date').removeClass('is-invalid');
        })

        $('#time_out').blur(function() {
            $('#time_out').removeClass('is-invalid');
        })

        $('#num_hours').keyup(function() {
            $('#num_hours').removeClass('is-invalid');
        })

        $('#num_hours').change(function() {
            $('#num_hours').removeClass('is-invalid');
        })

        $('#reason').keyup(function() {
            $('#reason').removeClass('is-invalid');
        })




















        















        var empl_id_arr = [];
        var empl_info_arr = [];

        get_all_ampl_data(url_get_all_ampl_data, 'test').then(function(data){

            var obj = findObjectByKey(data, 'id', '999999');
            console.log(obj);
            empl_info_arr = data;
        })

        function findObjectByKey(array, key, value) {
            for (var i = 0; i < array.length; i++) {
                if (array[i][key] === value) {
                    return array[i];
                }
            }
            return null;
        }









        function edit_overtime_application(overtime_id){
            // var overtime_id = $(this).attr('overtime_id');
            console.log('Overtime ID: ' + overtime_id);
        }









        $('#filter_employee').change(function(e){
            var cutoff_period = '';
            if($('#filter_cutoff_period').val()){
                cutoff_period = $('#filter_cutoff_period').val();
            }
            var empl_id = $(this).val();

            display_application_data(empl_id, cutoff_period);
            
        })

        $('#filter_cutoff_period').change(function(e){
            var empl_id = '';
            if($('#filter_employee').val()){
                empl_id = $('#filter_employee').val();
            }
            var cutoff_period = $(this).val();

            display_application_data(empl_id, cutoff_period);
            
        })



        function display_application_data(empl_id, cutoff_period){

            get_ot_application_data(url_get_ot_application_data,empl_id,cutoff_period,1).then(function(data){
                $('#tbl_application_container').html('');


                Array.from(data).forEach(function(e){
                    var ot_id = 'OT'+(e.id).padStart(5,0);

                    var date_created = moment(e.date_created).format('MMMM D, YYYY');
                    var date_ot = moment(e.date_ot).format('MMMM D, YYYY');
                    var time_out = e.time_out;
                    var type = e.type;
                    var hours = e.hours;
                    var reason = e.reason;
                    var empl_id = e.empl_id;
                    var assigned_by = e.assigned_by;
                    var approval_route = e.approval_route;
                    var status1 = e.status1;
                    var status2 = e.status2;
                    var comment = e.comment;

                    var empl_image = 'default_profile_img3.png';
                    var empl_name = '';
                    var empl_cmid = '';
                    var empl_id = '';
                    var empl_info = findObjectByKey(empl_info_arr, 'id', ""+e.empl_id+"");
                    if(empl_info){
                        if(empl_info.col_imag_path){
                            empl_image = empl_info.col_imag_path;
                        }
                        if(empl_info.col_midl_name){
                            var midl_ini = empl_info.col_midl_name + '.';
                        }else{
                            var midl_ini = '';
                        }
                        
                        empl_name = empl_info.col_last_name + ', ' + empl_info.col_frst_name + ' ' + midl_ini;
                        empl_cmid = empl_info.col_empl_cmid;
                        empl_id = empl_info.id;
                    }

                    var assigned_by_image = 'default_profile_img3.png';
                    var assigned_by_name = '';
                    var assigned_by_cmid = '';
                    var assigned_by_id = '';
                    var assigned_by_info = findObjectByKey(empl_info_arr, 'id', ""+e.assigned_by+"");
                    if(assigned_by_info){
                        if(assigned_by_info.col_imag_path){
                            assigned_by_image = assigned_by_info.col_imag_path;
                        }
                        if(assigned_by_info.col_midl_name){
                            var midl_ini2 = assigned_by_info.col_midl_name + '.';
                        }else{
                            var midl_ini2 = '';
                        }
                        assigned_by_name = assigned_by_info.col_last_name + ', ' + assigned_by_info.col_frst_name + ' ' + midl_ini2;
                        assigned_by_cmid = assigned_by_info.col_empl_cmid;
                        assigned_by_id = assigned_by_info.id;
                    }

                    var action_btns = '';
                    if((e.status1 == 'Approved') && (e.status2 == 'Approved')){
                        action_btns = `
                            <a href="#" class="btn btn-primary btn_edit_overtime" overtime_id="`+e.id+`" onclick="edit_overtime_application(`+e.id+`)" data-toggle="modal" data-target="#modal_edit_overtime">Edit</a>
                        `;
                    } else {
                        action_btns = `
                            <button href="#" class="btn btn-secondary" disabled>Edit</button>
                        `;
                    }
                    $('#tbl_application_container').append(`
                        <tr>
                            <td>`+ot_id+`</td>
                            <td>`+date_created+`</td>
                            <td>
                                <a href = "<?=base_url()?>employees/personal?id=`+empl_id+`">
                                    <img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`user_images/`+empl_image+`">&nbsp;&nbsp;`+empl_name+`
                                </a>
                            </td>
                            <td>
                                <a href = "<?=base_url()?>employees/personal?id=`+assigned_by_id+`">
                                    <img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`user_images/`+assigned_by_image+`">&nbsp;&nbsp;`+assigned_by_name+`
                                </a>
                            </td>
                            <td>`+date_ot+`</td>
                            <td>`+time_out+`</td>
                            <td>`+type+`</td>
                            <td>`+hours+`</td>
                            <td>`+reason+`</td>
                            <td>`+status1+`</td>
                            <td>`+status2+`</td>
                            <td>`+comment+`</td>
                            <td>`+action_btns+`</td>
                        </tr>
                    `)
                })


                $('.btn_edit_overtime').click(function(e){
                    e.preventDefault();
                    

                    var overtime_id = $(this).attr('overtime_id');

                    console.log('Overtime ID: ' + overtime_id);

                    get_overtime_data_for_updt(url_get_overtime_data_for_updt, overtime_id).then(function(data){
                        // console.log(data);

                        Array.from(data).forEach(function(x){
                            var date_ot = x.date_ot;
                            var empl_id = x.empl_id;

                            console.log(date_ot);
                            console.log(empl_id);

                            get_attendance_record_data(url_get_attendance_record_data, date_ot, empl_id).then(function(att_data){

                                Array.from(att_data).forEach(function(y){
                                    $('#appl_time_in').val(y.time_in);
                                    $('#actual_time_out').val(y.time_out);
                                })

                                $('#appl_empl_id').val(x.empl_id);
                                $('#appl_ot_duration').val(x.hours);
                                $('#appl_time_out').val(x.time_out);
                                $('#appl_overtime_id').val(x.id);
                                
                                $('#appl_overtime_date').val(date_ot);
                                $('#appl_overtime_empl_id').val(empl_id);

                                $('#appl_type').val(x.type);

                            })

                        })
                        
                    })
                })

                

            })

        }









        $('#btn_pagination').pagination();
        
        var row_count = $('#row_count').val();
        var page_count = $('#page_count').val();

        console.log(row_count);
        console.log(page_count);

        $('#btn_pagination').pagination({

            // the number of entries
            total: row_count,

            // current page
            current: 1, 

            // the number of entires per page
            length: page_count, 

            // pagination size
            size: 2,

            // Prev/Next text
            prev: "&lt;", 
            next: "&gt;", 

            // fired on each click
            click: function (e) {
                $('#tbl_application_container').html('');

                var row_count = $('#row_count').val();
                var page_count = $('#page_count').val();
                // console.log(e.current);
                var page_num = e.current;
                
                var employee = $('#filter_employee').val();
                var cutoff_period = $('#filter_cutoff_period').val();

                get_overtime(url_get_overtime,employee,cutoff_period,page_num).then(function(data){
                    console.log(data);
                    Array.from(data).forEach(function(x){
                        var ot_id = 'OT'+(x.id).padStart(5,0);

                        var date_created = moment(x.date_created).format('MMMM D, YYYY');
                        var date_ot = moment(x.date_ot).format('MMMM D, YYYY');
                        var time_out = x.time_out;
                        var type = x.type;
                        var hours = x.hours;
                        var reason = x.reason;
                        var empl_id = x.empl_id;
                        var assigned_by = x.assigned_by;
                        var approval_route = x.approval_route;
                        var status1 = x.status1;
                        var status2 = x.status2;
                        var comment = x.comment;

                        var empl_image = 'default_profile_img3.png';
                        var empl_name = '';
                        var empl_cmid = '';
                        var empl_id = '';
                        var empl_info = findObjectByKey(empl_info_arr, 'id', ""+x.empl_id+"");
                        if(empl_info){
                            if(empl_info.col_imag_path){
                                empl_image = empl_info.col_imag_path;
                            }
                            if(empl_info.col_midl_name){
                                var midl_ini = empl_info.col_midl_name + '.';
                            }else{
                                var midl_ini = '';
                            }
                            
                            empl_name = empl_info.col_last_name + ', ' + empl_info.col_frst_name + ' ' + midl_ini;
                            empl_cmid = empl_info.col_empl_cmid;
                            empl_id = empl_info.id;
                        }

                        var assigned_by_image = 'default_profile_img3.png';
                        var assigned_by_name = '';
                        var assigned_by_cmid = '';
                        var assigned_by_id = '';
                        var assigned_by_info = findObjectByKey(empl_info_arr, 'id', ""+x.assigned_by+"");
                        if(assigned_by_info){
                            if(assigned_by_info.col_imag_path){
                                assigned_by_image = assigned_by_info.col_imag_path;
                            }
                            if(assigned_by_info.col_midl_name){
                                var midl_ini2 = assigned_by_info.col_midl_name + '.';
                            }else{
                                var midl_ini2 = '';
                            }
                            assigned_by_name = assigned_by_info.col_last_name + ', ' + assigned_by_info.col_frst_name + ' ' + midl_ini2;
                            assigned_by_cmid = assigned_by_info.col_empl_cmid;
                            assigned_by_id = assigned_by_info.id;
                        }

                        var action_btns = '';
                        if((x.status1 == 'Approved') && (x.status2 == 'Approved')){
                            action_btns = `
                                <a href="#" class="btn btn-primary btn_edit_overtime" overtime_id="`+x.id+`" onclick="edit_overtime_application(`+x.id+`)" data-toggle="modal" data-target="#modal_edit_overtime">Edit</a>
                            `;
                        } else {
                            action_btns = `
                                <button href="#" class="btn btn-secondary" disabled>Edit</button>
                            `;
                        }

                        $('#tbl_application_container').append(`
                            <tr>
                                <td>`+ot_id+`</td>
                                <td>`+date_created+`</td>
                                <td>
                                    <a href = "<?=base_url()?>employees/personal?id=`+empl_id+`">
                                        <img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`user_images/`+empl_image+`">&nbsp;&nbsp;`+empl_name+`
                                    </a>
                                </td>
                                <td>
                                    <a href = "<?=base_url()?>employees/personal?id=`+assigned_by_id+`">
                                        <img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`user_images/`+assigned_by_image+`">&nbsp;&nbsp;`+assigned_by_name+`
                                    </a>
                                </td>
                                <td>`+date_ot+`</td>
                                <td>`+time_out+`</td>
                                <td>`+type+`</td>
                                <td>`+hours+`</td>
                                <td>`+reason+`</td>
                                <td>`+status1+`</td>
                                <td>`+status2+`</td>
                                <td>`+comment+`</td>
                                <td>`+action_btns+`</td>
                            </tr>
                        `)
                    })

                    $('.btn_edit_overtime').click(function(e){
                        e.preventDefault();
                        

                        var overtime_id = $(this).attr('overtime_id');

                        console.log('Overtime ID: ' + overtime_id);

                        get_overtime_data_for_updt(url_get_overtime_data_for_updt, overtime_id).then(function(data){
                            // console.log(data);

                            Array.from(data).forEach(function(x){
                                var date_ot = x.date_ot;
                                var empl_id = x.empl_id;

                                console.log(date_ot);
                                console.log(empl_id);

                                get_attendance_record_data(url_get_attendance_record_data, date_ot, empl_id).then(function(att_data){

                                    Array.from(att_data).forEach(function(y){
                                        $('#appl_time_in').val(y.time_in);
                                        $('#actual_time_out').val(y.time_out);
                                    })

                                    $('#appl_empl_id').val(x.empl_id);
                                    $('#appl_ot_duration').val(x.hours);
                                    $('#appl_time_out').val(x.time_out);
                                    $('#appl_overtime_id').val(x.id);
                                    
                                    $('#appl_overtime_date').val(date_ot);
                                    $('#appl_overtime_empl_id').val(empl_id);

                                    $('#appl_type').val(x.type);

                                })

                            })
                            
                        })
                    })

                    
                })

            }
        });







        









        $('.btn_edit_overtime').click(function(e){
            e.preventDefault();
            

            var overtime_id = $(this).attr('overtime_id');

            console.log('Overtime ID: ' + overtime_id);

            // // console.log(overtime_id);

            get_overtime_data_for_updt(url_get_overtime_data_for_updt, overtime_id).then(function(data){
                // console.log(data);

                Array.from(data).forEach(function(x){
                    var date_ot = x.date_ot;
                    var empl_id = x.empl_id;

                    console.log(date_ot);
                    console.log(empl_id);

                    get_attendance_record_data(url_get_attendance_record_data, date_ot, empl_id).then(function(att_data){

                        Array.from(att_data).forEach(function(y){
                            $('#appl_time_in').val(y.time_in);
                            $('#actual_time_out').val(y.time_out);
                        })

                        $('#appl_empl_id').val(x.empl_id);
                        $('#appl_ot_duration').val(x.hours);
                        $('#appl_time_out').val(x.time_out);
                        $('#appl_overtime_id').val(x.id);
                        
                        $('#appl_overtime_date').val(date_ot);
                        $('#appl_overtime_empl_id').val(empl_id);

                        $('#appl_type').val(x.type);

                    })

                })
                
            })

        })

















        $('.ot_row').click(function(){
            var modal_employee_id = $(this).attr('employee_id');
            var modal_overtime_id = $(this).attr('overtime_id');
            

            get_overtime_data(url_get_overtime_data,modal_employee_id,modal_overtime_id).then(data => {
                data.overtime_data.forEach((overtimeData) => {
                    var application_date = overtimeData.date_created;
                    var overtime_date = overtimeData.date_ot;
                    var time_out = overtimeData.time_out;
                    var type = overtimeData.type;
                    var hours = overtimeData.hours;
                    var reason = overtimeData.reason;
                    var status1 = overtimeData.status1;
                    var status2 = overtimeData.status2;
                    // var status3 = overtimeData.status3;
                    

                    $('#ot_application_date').text(application_date);
                    $('#ot_overtime_date').text(overtime_date);
                    $('#ot_time_out').text(time_out);
                    $('#ot_type').text(type);
                    $('#ot_num_hours').text(hours+' hrs');
                    $('#ot_reason').text(reason);
                    // $('#ot_status1').text(status1);
                    // $('#ot_status2').text(status2);
                    // $('#ot_status3').text(status3);

                    if((status1 == "Approved") && (status2 == "Approved")){
                        $('#ot_status').attr('class','text-bold text-success');
                        $('#ot_status').text('Approved');
                    } else if ((status1 == "Pending") || (status2 == "Pending")){
                        $('#ot_status').attr('class','text-bold text-secondary');
                        $('#ot_status').text('Pending');
                    } else if ((status1 == "Rejected") || (status2 == "Rejected")){
                        $('#ot_status').attr('class','text-bold text-danger');
                        $('#ot_status').text('Rejected');
                    }

                    if(overtimeData.comment){
                        $('#reason_rejection').show();
                        $('#ot_rejection_comment').text(overtimeData.comment);
                    } else {
                        $('#ot_rejection_comment').text('');
                        $('#reason_rejection').hide();
                    }
                    
                })
                data.employee_data.forEach((employeeData) => {
                    $('#ot_employee_name').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
                    $('#ot_employee_position').text(employeeData.col_empl_posi);
                    $('#ot_employee_department').text(employeeData.col_empl_dept);

                    if(employeeData.col_imag_path){
                    $('#ot_modal_employee_img').attr('src',base_url + 'user_images/' + employeeData.col_imag_path);
                    } else {
                    $('#ot_modal_employee_img').attr('src',base_url + 'user_images/' + 'default_profile_img3.png');
                    }
                    
                })
            })
        })
















        // EDIT OVERTIME APPLICATION DETAILS
        async function get_overtime_data_for_updt(url, overtime_id){
            var formData = new FormData();
            formData.append('overtime_id', overtime_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }
        
        async function get_attendance_record_data(url, date_ot, empl_id){
            var formData = new FormData();
            formData.append('date_ot', date_ot);
            formData.append('empl_id', empl_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }
        




        // ASYNC FUNCTION GET OVERTIME
        async function get_overtime(url,employee,cutoff_period,page_num){
            var formData = new FormData();
            formData.append('page_num', page_num);
            formData.append('employee', employee);
            formData.append('cutoff_period', cutoff_period);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        // ASYNC FUNCTION GET ALL EMPL DATA
        async function get_all_ampl_data(url,empl_id){
            var formData = new FormData();
            formData.append('empl_cmid', empl_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }
        
        // ASYNC FUNCTION CLICKING PAGE NUM
        async function get_ot_application_data(url,empl_id,cutoff_period,page_num) {
            var formData = new FormData();
            formData.append('empl_id', empl_id);
            formData.append('cutoff_period', cutoff_period);
            formData.append('page_num', page_num);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }


















        async function get_overtime_data(url,employee_id,overtime_id){
            var formData = new FormData();
            formData.append('employee_id', employee_id);
            formData.append('overtime_id', overtime_id);
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