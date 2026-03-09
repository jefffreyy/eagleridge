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
    margin: 0px !important;
    font-size: 13px !important;
    padding: 10px 8px !important;
    border-top: none !important;
  }

  label.required::after{
    content:" *";
    color: red;
  }

  #btn_show_attendance{
    text-decoration: none;
  }

  #chevron_icon{
    transition: 0.5s;
  }

  .rotate-right{
    transition: 0.5s;
    transform: rotate(90deg);
  }
  
  .rotate-left{
    transition: 0.5s;
    transform: rotate(180deg);
  }

  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
  input[type=number] {
    -moz-appearance: textfield;
  }
  /* td:hover{
    background-color: #ccc !important;
  } */
</style>
<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Daterange Picker -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/daterangepicker/daterangepicker.css">
<!-- Tempus Dominus -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Table Sorter -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins\tablesorter-master\dist\css\theme.ice.min.css">
<!-- Include Editor style. -->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_style.min.css" rel="stylesheet" type="text/css" />
<div class="content-wrapper">
  <div class="p-3">
    <div class="flex-fill">
      <div class="row pr-3 mb-2">
        <div class="col">
          <h1 class="page-title">Attendance Record
          </h1>
        </div>
      </div>
      <hr>
      <div class="row mb-2">
        <div class="col-4">
            <div class="d-flex">
                <div style="width: 100px;">
                    <label for="search_employees" style="font-weight: 500">Cut-off Period</label>
                </div>
                <div class="flex-fill">
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
            </div>
        </div>
        <div class="col-8">
          <!-- <a href="<?= base_url() ?>csv/import_attendance" class="btn btn-primary float-right"><i class="fas fa-file-import"></i> Import CSV File</a> -->
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-4">
            <div class="d-flex">
                <div style="width: 100px;">
                    <label for="search_employees" style="font-weight: 500">Employee ID</label>
                </div>
                <div class="flex-fill">
                    <select name="employee_id" id="employee_id" class="form-control">
                        <option value="1" id="empl_id_name_based" selected>D00001</option>
                        <?php
                            if($DISP_EMP_LIST){
                                foreach($DISP_EMP_LIST as $DISP_EMP_LIST_ROW){
                                ?>
                                <option value="<?= $DISP_EMP_LIST_ROW->id ?>"><?= $DISP_EMP_LIST_ROW->col_empl_cmid ?></option>
                                <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="d-flex mt-1">
                <div style="width: 115px;">
                    <label for="employee_name" style="font-weight: 500">Employee Name</label>
                </div>
                <div class="flex-fill" id="employee_name_container">
                    <label id='employee_fullname'>Wilmer Andre Cruz</label>
                    <!-- <select name="employee_name" id="employee_name" class="form-control">
                        <option value="" id="empl_name_id_based">Choose Employee Name...</option>
                        <?php
                            if($DISP_EMP_LIST){
                                foreach($DISP_EMP_LIST as $DISP_EMP_LIST_ROW){
                                ?>
                                <option value="<?= $DISP_EMP_LIST_ROW->id ?>"><?= $DISP_EMP_LIST_ROW->col_frst_name.' '.$DISP_EMP_LIST_ROW->col_last_name ?></option>
                                <?php
                                }
                            }
                        ?>
                    </select> -->
                </div>
            </div>
        </div>
      </div>
      <div class="card">
        <table class="table table-hover table-xs mb-0 hover-highlight" id="tbl_attendance">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>DOW</th>
                    <th>Employee</th>
                    <th>Day Code</th>
                    <th>Shift for the Day</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Status</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody id="cutoff_container">
              <tr>
                <td colspan="9" class="text-center py-5" style="background-color: #f0f0f0;">No selected cut-off period</td>
              </tr>
            </tbody>
        </table>
        <div class="w-100 text-center">
          <img src="<?= base_url() ?>images/loader2.gif" id="loader_gif" style="width: 180px; height: 120px; display: none;">
        </div>
      </div>
    </div>
    <!-- flex-fill -->
  </div>
  <!-- p-3 -->
</div>
<!-- content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<!-- Add position -->
<div class="modal fade" id="modal_add_attendance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Add Teams
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('attendance/insrt_attendance'); ?>" id="ATTENDANCE_FORM_ADD" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="ATTENDANCE_INPF_NAME">Name
                </label>
                <input class="form-control form-control " type="text" name="ATTENDANCE_INPF_NAME" id="ATTENDANCE_INPF_NAME">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class='btn btn-primary text-light' id="ATTENDANCE_BTN_SAVE">&nbsp; Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit position -->
<div class="modal fade" id="modal_edit_attendance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Teams
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('attendance/updt_attendance'); ?>" id="ATTENDANCE_FORM_EDIT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="asset_code">Name
                </label>
                <input class="form-control form-control " type="text" name="UPDT_ATTENDANCE_INPF_NAME" id="UPDT_ATTENDANCE_INPF_NAME" required>
              </div>
            </div>
            <input type="hidden" name="UPDT_ATTENDANCE_INPF_ID" id="UPDT_ATTENDANCE_INPF_ID">
          </div>
        </div>
        <div class="modal-footer">
          <a class='btn btn-primary text-light' id="ATTENDANCE_BTN_UPDT">&nbsp; Update
          </a>
        </div>
      </form>
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
        <a href="<?php echo base_url().'login/logout'; ?>" class="btn btn-info">Logout
        </a>
      </div>
    </div>
  </div>
</div>

<!-- =============== APPY TEMPLATE ================= -->
<div class="modal fade" id="modal_apply_template" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Apply Shift Template
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label class="required " for="ATTENDANCE_INPF_NAME">Shift Name
              </label>
              <select name="work_shift_template" id="work_shift_template" class="form-control">
                  <option value="">Choose Template...</option>
                  <?php
                      if($DISP_SHIFT_TEMPLATE){
                          foreach($DISP_SHIFT_TEMPLATE as $DISP_SHIFT_TEMPLATE_ROW){
                          ?>
                            <option value="<?= $DISP_SHIFT_TEMPLATE_ROW->id ?>"><?= $DISP_SHIFT_TEMPLATE_ROW->name ?></option>
                          <?php
                          }
                      }
                  ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a class='btn btn-primary text-light' id="btn_apply_template">&nbsp; Apply
        </a>
      </div>
    </div>
  </div>
</div>

<!-- =============== SET SHIFT ================= -->
<div class="modal fade" id="modal_set_shift" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Set Shift
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <!-- <form action="<?php echo base_url('attendance/update_shift'); ?>" id="FORM_UPDT_SHIFT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2"> -->
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="set_shift_name">Shift Name
                </label>
                <select name="set_shift_name" id="set_shift_name" class="form-control" required>
                    <option value="">Choose Template...</option>
                    <?php
                        if($DISP_WORK_SHIFT){
                            foreach($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW){
                            ?>
                              <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="modal_employee_id" name="modal_employee_id" class="form-control">
          <input type="hidden" id="schedule_id" name="schedule_id" class="form-control">
          <button class='btn btn-primary text-light' id="btn_updt_shift">&nbsp; Save
          </button>
        </div>
      <!-- </form> -->
    </div>
  </div>
</div>

<!-- =============== TIME ADJUSTMENT MODAL ================= -->
<div class="modal fade" id="modal_time_adjustment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Time Adjustment
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="adjust_date">Date
              </label>
              <input type="text" name="adjust_date" id="adjust_date" class="form-control" disabled>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="adjust_empl_id">Employee ID
                  </label>
                  <input type="text" name="adjust_empl_id" id="adjust_empl_id" class="form-control" disabled>
                </div>
              </div>
              <div class="col-md-10">
                <div class="form-group">
                  <label for="adjust_empl_name">Employee Name
                  </label>
                  <input type="text" name="adjust_empl_name" id="adjust_empl_name" class="form-control" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="adjust_dow">Day of Work
                  </label>
                  <input type="text" name="adjust_dow" id="adjust_dow" class="form-control" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="adjust_shift">Shift for the Day
                  </label>
                  <input type="text" name="adjust_shift" id="adjust_shift" class="form-control" disabled>
                </div>
              </div>
            </div>

            <hr>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="required " for="ADJUSTMENT_INPF_TIME_IN">Time In
                  </label>
                  <div class="input-group date" id="timepicker" data-target-input="nearest" style="width: 100% !important;">
                    <input type="text" class="form-control datetimepicker-input time_in_text mr-0" name="time_in_text" data-target="#timepicker" id="time_in_text" placeholder="hr:min" required>
                    <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="required " for="ADJUSTMENT_INPF_TIME_OUT">Time Out
                  </label>
                  <div class="input-group date" id="timepicker2" data-target-input="nearest" style="width: 100% !important;">
                    <input type="text" class="form-control datetimepicker-input time_out_text mr-0" name="time_out_text" data-target="#timepicker2" id="time_out_text" placeholder="hr:min" required>
                    <div class="input-group-append" data-target="#timepicker2" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="required " for="ADJUSTMENT_INPF_TIME_IN">Status
                  </label>
                  <select name="attendance_status" id="attendance_status" class="form-control">
                    <option value="">Choose...</option>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="required " for="ADJUSTMENT_INPF_TIME_OUT">Remarks
                  </label>
                  <select name="attendance_remarks" id="attendance_remarks" class="form-control">
                    <option value="">Choose...</option>
                    <option value="Late">Late</option>
                    <option value="Overtime">Overtime</option>
                    <option value="Undertime">Undertime</option>
                    <option value="Abnormal">Abnormal</option>
                  </select>
                </div>
              </div>
            </div>

            <hr>

            <div class="mb-4">
              <a href="#" id="btn_show_attendance">Show Attendance Count &nbsp;&nbsp;<i class="fas fa-chevron-up rotate-right" id="chevron_icon"></i> </a>
            </div>
            
            <div id="attendance_count_container" style="display:none;">
            
              <div class="bg-dark py-1" style="border-radius: 5px 5px 0px 0px;">
                <span class="pl-3" style="font-size: 14px !important;">Basic (Days)</span>
              </div>
              <div class="card p-3">
                <div class="row px-3">
                  <div class="col-md-6">
                    <div class="row"><div class="col-10"><p>Regular:</p></div>                                            <div class="col-2">     <input type="number" class="form-control" id="bp_reg_mul">              </div></div>
                    <div class="row"><div class="col-10"><p>Rest:</p></div>                                               <div class="col-2">     <input type="number" class="form-control" id="bp_rest_mul">             </div></div>
                    <div class="row"><div class="col-10"><p>Special Holiday:</p></div>                                    <div class="col-2">     <input type="number" class="form-control" id="bp_sp_hol_mul">           </div></div>
                    <div class="row"><div class="col-10"><p>Special Holiday + Rest:</p></div>                             <div class="col-2">     <input type="number" class="form-control" id="bp_sp_rest_mul">          </div></div>
                    <div class="row"><div class="col-10"><p>Regular Holiday:</p></div>                                    <div class="col-2">     <input type="number" class="form-control" id="bp_reg_hol_mul">          </div></div>
                    <div class="row"><div class="col-10"><p>Regular Holiday + Rest:</p></div>                             <div class="col-2">     <input type="number" class="form-control" id="bp_reg_hol_rest_mul">     </div></div>
                    <div class="row"><div class="col-10"><p>Double Holiday:</p></div>                                     <div class="col-2">     <input type="number" class="form-control" id="bp_dbl_hol_mul">          </div></div>
                    <div class="row"><div class="col-10"><p>Double Holliday + Rest:</p></div>                             <div class="col-2">     <input type="number" class="form-control" id="bp_dbl_hol_rest_mul">     </div></div>
                  </div>
                  <div class="col-md-6">
                    <div class="row"><div class="col-10"><p>Regular (Night):</p></div>                                    <div class="col-2">     <input type="number" class="form-control" id="bp_reg_ns_mul">           </div></div>
                    <div class="row"><div class="col-10"><p>Rest (Night):</p></div>                                       <div class="col-2">     <input type="number" class="form-control" id="bp_rest_ns_mul">          </div></div>
                    <div class="row"><div class="col-10"><p>Special Holiday (Night):</p></div>                            <div class="col-2">     <input type="number" class="form-control" id="bp_sp_hol_ns_mul">        </div></div>
                    <div class="row"><div class="col-10"><p>Special Holiday + Rest (Night):</p></div>                     <div class="col-2">     <input type="number" class="form-control" id="bp_sp_rest_ns_mul">       </div></div>
                    <div class="row"><div class="col-10"><p>Regular Holiday (Night):</p></div>                            <div class="col-2">     <input type="number" class="form-control" id="bp_reg_hol_ns_mul">       </div></div>
                    <div class="row"><div class="col-10"><p>Regular Holiday + Rest (Night):</p></div>                     <div class="col-2">     <input type="number" class="form-control" id="bp_reg_hol_rest_ns_mul">  </div></div>
                    <div class="row"><div class="col-10"><p>Double Holiday (Night):</p></div>                             <div class="col-2">     <input type="number" class="form-control" id="bp_dbl_hol_ns_mul">       </div></div>
                    <div class="row"><div class="col-10"><p>Double Holliday + Rest (Night):</p></div>                     <div class="col-2">     <input type="number" class="form-control" id="bp_dbl_hol_rest_ns_mul">  </div></div>
                  </div>
                </div>
              </div>

              <br>
              
              <div class="bg-dark py-1" style="border-radius: 5px 5px 0px 0px;">
                <span class="pl-3" style="font-size: 14px !important;">Overtime (Hours)</span>
              </div>
              <div class="card p-3">
                <div class="row px-3">
                  <div class="col-md-6">
                    <div class="row"><div class="col-10"><p>Regular:</p></div>                                            <div class="col-2">     <input type="number" class="form-control" id="ot_reg_mul">              </div></div>
                    <div class="row"><div class="col-10"><p>Rest:</p></div>                                               <div class="col-2">     <input type="number" class="form-control" id="ot_rest_mul">             </div></div>
                    <div class="row"><div class="col-10"><p>Special Holiday:</p></div>                                    <div class="col-2">     <input type="number" class="form-control" id="ot_sp_hol_mul">           </div></div>
                    <div class="row"><div class="col-10"><p>Special Holiday + Rest:</p></div>                             <div class="col-2">     <input type="number" class="form-control" id="ot_sp_rest_mul">          </div></div>
                    <div class="row"><div class="col-10"><p>Regular Holiday:</p></div>                                    <div class="col-2">     <input type="number" class="form-control" id="ot_reg_hol_mul">          </div></div>
                    <div class="row"><div class="col-10"><p>Regular Holiday + Rest:</p></div>                             <div class="col-2">     <input type="number" class="form-control" id="ot_reg_hol_rest_mul">     </div></div>
                    <div class="row"><div class="col-10"><p>Double Holiday:</p></div>                                     <div class="col-2">     <input type="number" class="form-control" id="ot_dbl_hol_mul">          </div></div>
                    <div class="row"><div class="col-10"><p>Double Holliday + Rest:</p></div>                             <div class="col-2">     <input type="number" class="form-control" id="ot_dbl_hol_rest_mul">     </div></div>
                  </div>
                  <div class="col-md-6">
                    <div class="row"><div class="col-10"><p>Regular (Night):</p></div>                                    <div class="col-2">     <input type="number" class="form-control" id="ot_reg_ns_mul">           </div></div>
                    <div class="row"><div class="col-10"><p>Rest (Night):</p></div>                                       <div class="col-2">     <input type="number" class="form-control" id="ot_rest_ns_mul">          </div></div>
                    <div class="row"><div class="col-10"><p>Special Holiday (Night):</p></div>                            <div class="col-2">     <input type="number" class="form-control" id="ot_sp_hol_ns_mul">        </div></div>
                    <div class="row"><div class="col-10"><p>Special Holiday + Rest (Night):</p></div>                     <div class="col-2">     <input type="number" class="form-control" id="ot_sp_rest_ns_mul">       </div></div>
                    <div class="row"><div class="col-10"><p>Regular Holiday (Night):</p></div>                            <div class="col-2">     <input type="number" class="form-control" id="ot_reg_hol_ns_mul">       </div></div>
                    <div class="row"><div class="col-10"><p>Regular Holiday + Rest (Night):</p></div>                     <div class="col-2">     <input type="number" class="form-control" id="ot_reg_hol_rest_ns_mul">  </div></div>
                    <div class="row"><div class="col-10"><p>Double Holiday (Night):</p></div>                             <div class="col-2">     <input type="number" class="form-control" id="ot_dbl_hol_ns_mul">       </div></div>
                    <div class="row"><div class="col-10"><p>Double Holliday + Rest (Night):</p></div>                     <div class="col-2">     <input type="number" class="form-control" id="ot_dbl_hol_rest_ns_mul">  </div></div>
                  </div>
                </div>
              </div>
            </div>
            

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class='btn btn-primary text-light' id="btn_adjust_time">&nbsp; Save
        </button>
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
<!-- DateRange Picker -->
<script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js">
</script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Table Sorter -->
<script type="text/javascript" src="<?= base_url(); ?>plugins/tablesorter-master/dist/js/jquery.tablesorter.min.js"></script>
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

    //Timepicker time in
    $('#timepicker').datetimepicker({
        format: 'LT'
    })
    // Timepicker time out
    $('#timepicker2').datetimepicker({
        format: 'LT'
    })

    var is_executed = false;
    $("#tbl_attendance").tablesorter();

    // get holiday data
    var url_holiday = '<?php echo base_url(); ?>attendance/get_holiday_data';

    // =========================== GENERATE DATES AND DAYS BASED ON CHOSEN PERIOD ====================================
    var url = '<?php echo base_url(); ?>attendance/get_cutoff_schedule_data';
    $('#cutoff_period').change(function(){
        $('#cutoff_container').html('');
        var date = $(this).val();
        var employee_id = $('#employee_id').val();

         // show loading indicator
         $('#loader_gif').show();

        get_employee_data(url2, employee_id,date).then(data => {
          if($('#cutoff_period').val()){
            $('#cutoff_container').html('');
            data.cutoff_data.forEach((x) => {
              var cutoff_id = x.id;
              var db_shift_id = x.shift_id;
              var db_date = x.date;
              var db_date = db_date.split(" ");
              var date_period = moment(x.date).format('LL');
              var day_of_work = moment(x.date).format('dddd');

              var db_status = '';
              var db_remarks = '';
              if(x.status){
                db_status = x.status;
              }
              if(x.remarks){
                db_remarks = x.remarks;
              }

              var db_time_in = '';
              var db_time_out = '';

              if(x.time_in != '00:00:00'){
                db_time_in = x.time_in;
              }

              if(x.time_out != '00:00:00'){
                db_time_out = x.time_out;
              }

              var empl_arr = [];
              get_employee_data(url2, x.empl_id,$('#cutoff_period').val()).then(data1 => {
                data1.employee_data.forEach((x) => {
                    empl_arr.push(x.col_frst_name+" "+x.col_last_name);
                    empl_arr.push(x.id);
                })

                var holiday_arr = [];
                get_holiday_data(url_holiday).then(data2 => {
                  data2.holiday.forEach((x) => {
                    holiday_arr.push(x.col_holi_date);
                    holiday_arr.push(x.col_holi_type);
                  })

                  var day_code = '';
                  if(holiday_arr.includes(db_date[0])){
                    var holi_index = holiday_arr.indexOf(db_date[0]);
                    holi_index++;

                    day_code = holiday_arr[holi_index];
                  } else {
                    day_code = 'Regular';
                  }

                  var shift_arr = [];
                  get_shift_data(url4, db_shift_id).then(data4 => {

                    data4.forEach((x) => {
                      shift_arr.push(x.code);
                      shift_arr.push(x.time_in);
                      shift_arr.push(x.time_out);
                    })

                    var shift_name = '';
                    if(shift_arr.length > 0){
                      var shift_code = shift_arr[0];
                      var shift_time_in = shift_arr[1];
                      var shift_time_out = shift_arr[2];

                      shift_name = '['+shift_code+']'+' '+shift_time_in+' - '+shift_time_out;
                    }

                    //toggle tooltip
                    $('[data-toggle="tooltip"]').tooltip()
                    $('#cutoff_container').append(`
                      <tr class="cutoff" style="cursor: pointer;" data-toggle="modal" data-target="#modal_time_adjustment" att_id="`+cutoff_id+`" att_date="`+db_date+`" dow="`+day_of_work+`" att_empl_id="`+empl_arr[1]+`" att_empl_name="`+empl_arr[0]+`" att_shift="`+shift_name+`" att_time_in="`+db_time_in+`" att_time_out="`+db_time_out+`" att_status="`+db_status+`" att_remarks="`+db_remarks+`">
                          <td attendance_date="`+db_date+`">`+db_date+`</td>
                          <td>`+day_of_work+`</td>
                          <td empl_id="`+empl_arr[1]+`">`+empl_arr[0]+`</td>
                          <td>`+day_code+`</td>
                          <td class="shift_num" shift_id="`+db_shift_id+`">`+shift_name+`</td>
                          <td class="db_time_in" row_id="`+cutoff_id+`" data-toggle="tooltip" data-placement="left" title="Click to Adjust">`+db_time_in+`</td>
                          <td class="db_time_out" row_id="`+cutoff_id+`" data-toggle="tooltip" data-placement="left" title="Click to Adjust">`+db_time_out+`</td>
                          <td data-toggle="tooltip" data-placement="left" title="Click to Adjust">`+db_status+`</td>
                          <td data-toggle="tooltip" data-placement="left" title="Click to Adjust">`+db_remarks+`</td>
                      </tr>
                    `);
                    
                    set_shift();
                    is_executed = true;
                  })
                })
              })
            })
          }

          data.employee_data.forEach((x) => {
              $('#employee_fullname').html(x.col_frst_name+" "+x.col_last_name);
          })
        })
    })



    // ============================== GET EMPLOYEE DATA BASED ON CHOSEND ID/NAME ====================================
    var url2 = '<?php echo base_url(); ?>attendance/get_employee_data';
    $('#employee_id').change(function(){
        var employee_id = $(this).val();
        var date_period = $('#cutoff_period').val();

        // show loading indicator
        $('#loader_gif').show();

        get_employee_data(url2, employee_id,date_period).then(data => {
          if($('#cutoff_period').val()){
            $('#cutoff_container').html('');
            data.cutoff_data.forEach((x) => {
              var cutoff_id = x.id;
              var db_shift_id = x.shift_id;
              var db_date = x.date;
              var db_date = db_date.split(" ");
              var date_period = moment(x.date).format('LL');
              var day_of_work = moment(x.date).format('dddd');

              var db_status = '';
              var db_remarks = '';
              if(x.status){
                db_status = x.status;
              }
              if(x.remarks){
                db_remarks = x.remarks;
              }

              var db_time_in = '';
              var db_time_out = '';

              if(x.time_in != '00:00:00'){
                db_time_in = x.time_in;
              }

              if(x.time_out != '00:00:00'){
                db_time_out = x.time_out;
              }

              var empl_arr = [];
              get_employee_data(url2, x.empl_id,$('#cutoff_period').val()).then(data1 => {
                data1.employee_data.forEach((x) => {
                    empl_arr.push(x.col_frst_name+" "+x.col_last_name);
                    empl_arr.push(x.id);
                })

                var holiday_arr = [];
                get_holiday_data(url_holiday).then(data2 => {
                  data2.holiday.forEach((x) => {
                    holiday_arr.push(x.col_holi_date);
                    holiday_arr.push(x.col_holi_type);
                  })

                  var day_code = '';
                  if(holiday_arr.includes(db_date[0])){
                    var holi_index = holiday_arr.indexOf(db_date[0]);
                    holi_index++;

                    day_code = holiday_arr[holi_index];
                  } else {
                    day_code = 'Regular';
                  }

                  var shift_arr = [];
                  get_shift_data(url4, db_shift_id).then(data4 => {

                    data4.forEach((x) => {
                      shift_arr.push(x.code);
                      shift_arr.push(x.time_in);
                      shift_arr.push(x.time_out);
                    })

                    var shift_name = '';
                    if(shift_arr.length > 0){
                      var shift_code = shift_arr[0];
                      var shift_time_in = shift_arr[1];
                      var shift_time_out = shift_arr[2];

                      shift_name = '['+shift_code+']'+' '+shift_time_in+' - '+shift_time_out;
                    }
                    
                    //toggle tooltip
                    $('[data-toggle="tooltip"]').tooltip()
                    $('#cutoff_container').append(`
                      <tr class="cutoff" style="cursor: pointer;" data-toggle="modal" data-target="#modal_time_adjustment" att_id="`+cutoff_id+`" att_date="`+db_date+`" dow="`+day_of_work+`" att_empl_id="`+empl_arr[1]+`" att_empl_name="`+empl_arr[0]+`" att_shift="`+shift_name+`" att_time_in="`+db_time_in+`" att_time_out="`+db_time_out+`"  att_status="`+db_status+`" att_remarks="`+db_remarks+`">
                          <td attendance_date="`+db_date+`">`+db_date+`</td>
                          <td>`+day_of_work+`</td>
                          <td empl_id="`+empl_arr[1]+`">`+empl_arr[0]+`</td>
                          <td>`+day_code+`</td>
                          <td class="shift_num" shift_id="`+db_shift_id+`">`+shift_name+`</td>
                          <td class="db_time_in" row_id="`+cutoff_id+`" data-toggle="tooltip" data-placement="left" title="Click to Adjust">`+db_time_in+`</td>
                          <td class="db_time_out" row_id="`+cutoff_id+`" data-toggle="tooltip" data-placement="left" title="Click to Adjust">`+db_time_out+`</td>
                          <td data-toggle="tooltip" data-placement="left" title="Click to Adjust">`+db_status+`</td>
                          <td data-toggle="tooltip" data-placement="left" title="Click to Adjust">`+db_remarks+`</td>
                      </tr>
                    `);
                    set_shift();
                    is_executed = true;
                  })
                })
              })
            })
          }
          data.employee_data.forEach((x) => {
              $('#employee_fullname').html(x.col_frst_name+" "+x.col_last_name);
          })
        })
    })
    
    
    function load_auto_sort(){
      $("#tbl_attendance").trigger("update");
      if($(".tablesorter-headerUnSorted[data-column=0]").length > 0){
        $(".tablesorter-headerUnSorted[data-column=0]").click();
      }
    }


    var url_attendance = '<?= base_url() ?>attendance/get_attendance_data_based_id';
          
    setInterval(() => {
      if(is_executed == true){
        load_auto_sort();
        is_executed = false;
        $('#cutoff_container').show();
        $('#loader_gif').hide();

        // get cutoff data to modal
        $('.cutoff').click(function(){
          $('#adjust_date').val($(this).attr('att_date'));
          $('#adjust_empl_id').val($(this).attr('att_empl_id'));
          $('#adjust_empl_name').val($(this).attr('att_empl_name'));
          $('#adjust_dow').val($(this).attr('dow'));
          $('#adjust_shift').val($(this).attr('att_shift'));
          $('#time_in_text').val($(this).attr('att_time_in'));
          $('#time_out_text').val($(this).attr('att_time_out'));

          $('#attendance_status').val($(this).attr('att_status'));
          $('#attendance_remarks').val($(this).attr('att_remarks'));

          var attendance_id = $(this).attr('att_id');
          get_attendance_data_based_id(url_attendance, attendance_id).then((attendance_row)=>{
            Array.from(attendance_row).forEach(function(data){
              $('#bp_reg_mul').val(data.bp_reg);
              $('#bp_rest_mul').val(data.bp_rest);
              $('#bp_sp_hol_mul').val(data.bp_sp_hol);
              $('#bp_sp_rest_mul').val(data.bp_sp_rest);
              $('#bp_reg_hol_mul').val(data.bp_reg_hol);
              $('#bp_reg_hol_rest_mul').val(data.bp_reg_hol_rest);
              $('#bp_dbl_hol_mul').val(data.bp_dbl_hol);
              $('#bp_dbl_hol_rest_mul').val(data.bp_dbl_hol_rest);
              
              $('#bp_reg_ns_mul').val(data.bp_reg_ns);
              $('#bp_rest_ns_mul').val(data.bp_rest_ns);
              $('#bp_sp_hol_ns_mul').val(data.bp_sp_hol_ns);
              $('#bp_sp_rest_ns_mul').val(data.bp_sp_rest_ns);
              $('#bp_reg_hol_ns_mul').val(data.bp_reg_hol_ns);
              $('#bp_reg_hol_rest_ns_mul').val(data.bp_reg_hol_rest_ns);
              $('#bp_dbl_hol_ns_mul').val(data.bp_dbl_hol_ns);
              $('#bp_dbl_hol_rest_ns_mul').val(data.bp_dbl_hol_rest_ns);

              $('#ot_reg_mul').val(data.ot_reg);
              $('#ot_rest_mul').val(data.ot_rest);
              $('#ot_sp_hol_mul').val(data.ot_sp_hol);
              $('#ot_sp_rest_mul').val(data.ot_sp_rest);
              $('#ot_reg_hol_mul').val(data.ot_reg_hol);
              $('#ot_reg_hol_rest_mul').val(data.ot_reg_hol_rest);
              $('#ot_dbl_hol_mul').val(data.ot_dbl_hol);
              $('#ot_dbl_hol_rest_mul').val(data.ot_dbl_hol_rest);

              $('#ot_reg_ns_mul').val(data.ot_reg_ns);
              $('#ot_rest_ns_mul').val(data.ot_rest_ns);
              $('#ot_sp_hol_ns_mul').val(data.ot_sp_hol_ns);
              $('#ot_sp_rest_ns_mul').val(data.ot_sp_rest_ns);
              $('#ot_reg_hol_ns_mul').val(data.ot_reg_hol_ns);
              $('#ot_reg_hol_rest_ns_mul').val(data.ot_reg_hol_rest_ns);
              $('#ot_dbl_hol_ns_mul').val(data.ot_dbl_hol_ns);
              $('#ot_dbl_hol_rest_ns_mul').val(data.ot_dbl_hol_rest_ns);
            })
          })
        })
      }
    }, 10);

    $('#btn_show_attendance').click(function(){
      if($('#chevron_icon').hasClass('rotate-right')){
        $('#chevron_icon').removeClass('rotate-right');
        $('#chevron_icon').addClass('rotate-left');
      } else if($('#chevron_icon').hasClass('rotate-left')){
        $('#chevron_icon').removeClass('rotate-left');
        $('#chevron_icon').addClass('rotate-right');
      }
      
      $('#attendance_count_container').toggle(300);
    })



    // get shift template data
    var url3 = '<?php echo base_url(); ?>attendance/get_work_shift_data';
    // get shift data
    var url4 = '<?php echo base_url(); ?>attendance/get_shift_data';


    // Display Shift id in the modal
    function set_shift(){
      $('.BTN_SET_SHIFT').click(function(e){
        e.preventDefault();
        var parent = $(this).parent().parent().parent();
        var parent_container = Array.from(parent)[0];
        var shift_id = $(parent_container.childNodes[9]).attr('shift_id');
        var cutoff_id = $(this).attr('cutoff_id');
        $('#schedule_id').val(cutoff_id);
        $('#set_shift_name').val(shift_id);
        console.log(shift_id);

        var employee_id = $(parent_container.childNodes[5]).attr('empl_id');
        $('#modal_employee_id').val(employee_id);
        console.log(employee_id);

        var date_period = $(parent_container.childNodes[1]).attr('empl_id');

      })
    }

    $('#btn_updt_shift').click(function(){
      var schedule_id = $('#schedule_id').val();
      var shift_id = $('#set_shift_name').val();
      
      var selector = 'a[cutoff_id|='+schedule_id+']';
      var parent = $(selector).parent().parent().parent();
      var parent_container = Array.from(parent)[0];
      $(parent_container.childNodes[9]).text(shift_id);

      get_shift_data(url4, shift_id).then(data => {
        if(data.length > 0)
        {
          data.forEach((x) => {
            $(parent_container.childNodes[9]).text('['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out);
          });
        }
      })

      $('#modal_set_shift').modal('toggle');
    })


      

    const convertTime12to24 = (time12h) => {
      const [time, modifier] = time12h.split(' ');

      let [hours, minutes] = time.split(':');

      if (hours === '12') {
        hours = '00';
      }

      if (modifier === 'PM') {
        hours = parseInt(hours, 10) + 12;
        
      }

      if(hours < 10){
        return `0${hours}:${minutes}:00`;
      } else {
        return `${hours}:${minutes}:00`;
      }
    }

















    var url_adjustment = '<?= base_url() ?>attendance/updt_attendance_time_out_async';
    
    $('#btn_adjust_time').click(function(){
      var adjust_date = $('#adjust_date').val();
      var adjust_empl_id = $('#adjust_empl_id').val();
      var adjust_empl_name = $('#adjust_empl_name').val();
      var adjust_dow = $('#adjust_dow').val();
      var adjust_shift = $('#adjust_shift').val();
      var time_in_text = $('#time_in_text').val();
      var time_out_text = $('#time_out_text').val();

      var adjust_status = $('#attendance_status').val();
      var adjust_remarks = $('#attendance_remarks').val();

      var bp_reg = $('#bp_reg_mul').val();
      var bp_rest = $('#bp_rest_mul').val();
      var bp_sp_hol = $('#bp_sp_hol_mul').val();
      var bp_sp_rest = $('#bp_sp_rest_mul').val();
      var bp_reg_hol = $('#bp_reg_hol_mul').val();
      var bp_reg_hol_rest = $('#bp_reg_hol_rest_mul').val();
      var bp_dbl_hol = $('#bp_dbl_hol_mul').val();
      var bp_dbl_hol_rest = $('#bp_dbl_hol_rest_mul').val();
      
      var bp_reg_ns = $('#bp_reg_ns_mul').val();
      var bp_rest_ns = $('#bp_rest_ns_mul').val();
      var bp_sp_hol_ns = $('#bp_sp_hol_ns_mul').val();
      var bp_sp_rest_ns = $('#bp_sp_rest_ns_mul').val();
      var bp_reg_hol_ns = $('#bp_reg_hol_ns_mul').val();
      var bp_reg_hol_rest_ns = $('#bp_reg_hol_rest_ns_mul').val();
      var bp_dbl_hol_ns = $('#bp_dbl_hol_ns_mul').val();
      var bp_dbl_hol_rest_ns = $('#bp_dbl_hol_rest_ns_mul').val();

      var ot_reg = $('#ot_reg_mul').val();
      var ot_rest = $('#ot_rest_mul').val();
      var ot_sp_hol = $('#ot_sp_hol_mul').val();
      var ot_sp_rest = $('#ot_sp_rest_mul').val();
      var ot_reg_hol = $('#ot_reg_hol_mul').val();
      var ot_reg_hol_rest = $('#ot_reg_hol_rest_mul').val();
      var ot_dbl_hol = $('#ot_dbl_hol_mul').val();
      var ot_dbl_hol_rest = $('#ot_dbl_hol_rest_mul').val();

      var ot_reg_ns = $('#ot_reg_ns_mul').val();
      var ot_rest_ns = $('#ot_rest_ns_mul').val();
      var ot_sp_hol_ns = $('#ot_sp_hol_ns_mul').val();
      var ot_sp_rest_ns = $('#ot_sp_rest_ns_mul').val();
      var ot_reg_hol_ns = $('#ot_reg_hol_ns_mul').val();
      var ot_reg_hol_rest_ns = $('#ot_reg_hol_rest_ns_mul').val();
      var ot_dbl_hol_ns = $('#ot_dbl_hol_ns_mul').val();
      var ot_dbl_hol_rest_ns = $('#ot_dbl_hol_rest_ns_mul').val();


      var time_in = time_in_text;
      if((time_in_text.includes('AM')) || (time_in_text.includes('PM'))){
        var time_in = convertTime12to24(time_in_text);
      }

      var time_out = time_out_text;
      if((time_out_text.includes('AM')) || (time_out_text.includes('PM'))){
        var time_out = convertTime12to24(time_out_text);
      }
      
      var parent_tr = $('[attendance_date="'+adjust_date+'"]').parent();
      var parent_tr_container = Array.from(parent_tr)[0];

      $(parent_tr_container.childNodes[11]).text(time_in);
      $(parent_tr_container.childNodes[13]).text(time_out);

      $(parent_tr_container.childNodes[15]).text(adjust_status);
      $(parent_tr_container.childNodes[17]).text(adjust_remarks);

      // updt_attendance_time_out_async(url_adjustment, adjust_date, adjust_empl_id, time_in, time_out).then(data => {
      //   console.log(data);
      // })
      updt_attendance_time_out_async(
          url_adjustment,
          adjust_date,
          adjust_empl_id,
          time_in,
          time_out,
          adjust_status,
          adjust_remarks,
          bp_reg,
          bp_rest,
          bp_sp_hol,
          bp_sp_rest,
          bp_reg_hol,
          bp_reg_hol_rest,
          bp_dbl_hol,
          bp_dbl_hol_rest,
          bp_reg_ns,
          bp_rest_ns,
          bp_sp_hol_ns,
          bp_sp_rest_ns,
          bp_reg_hol_ns,
          bp_reg_hol_rest_ns,
          bp_dbl_hol_ns,
          bp_dbl_hol_rest_ns,
          ot_reg,
          ot_rest,
          ot_sp_hol,
          ot_sp_rest,
          ot_reg_hol,
          ot_reg_hol_rest,
          ot_dbl_hol,
          ot_dbl_hol_rest,
          ot_reg_ns,
          ot_rest_ns,
          ot_sp_hol_ns,
          ot_sp_rest_ns,
          ot_reg_hol_ns,
          ot_reg_hol_rest_ns,
          ot_dbl_hol_ns,
          ot_dbl_hol_rest_ns
        ).then(data => {
          console.log(data);
          BP_reg
          BP_rest
          BP_sp_hol
          BP_sp_rest
          BP_reg_hol
          BP_reg_hol_rest
          BP_dbl_hol
          BP_dbl_hol_rest
          BP_reg_ns
          BP_rest_ns
          BP_sp_hol_ns
          BP_sp_rest_ns
          BP_reg_hol_ns
          BP_reg_hol_rest_ns
          BP_dbl_hol_ns
          BP_dbl_hol_rest_ns
          OT_reg
          OT_rest
          OT_sp_hol
          OT_sp_rest
          OT_reg_hol
          OT_reg_hol_rest
          OT_dbl_hol
          OT_dbl_hol_rest
          OT_reg_ns
          OT_rest_ns
          OT_sp_hol_ns
          OT_sp_rest_ns
          OT_reg_hol_ns
          OT_reg_hol_rest_ns
          OT_dbl_hol_ns
          OT_dbl_hol_rest_ns
      })

      $('#modal_time_adjustment').modal('toggle');
    })



    







    $('#cutoff_container .cutoff').each(function(){
      $(this).hover(function(){
        $(this).css("background-color", "#c6b79f !important");
      })
    })

















    async function get_attendance_data_based_id(url, attendance_id){
      var formData = new FormData();
      formData.append('attendance_id', attendance_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });

      return response.json();
    }


    async function updt_attendance_time_out_async(
      url,
      att_date,
      att_employee_id,
      time_in,
      time_out,
      status,
      remarks,
      bp_reg,
      bp_rest,
      bp_sp_hol,
      bp_sp_rest,
      bp_reg_hol,
      bp_reg_hol_rest,
      bp_dbl_hol,
      bp_dbl_hol_rest,
      bp_reg_ns,
      bp_rest_ns,
      bp_sp_hol_ns,
      bp_sp_rest_ns,
      bp_reg_hol_ns,
      bp_reg_hol_rest_ns,
      bp_dbl_hol_ns,
      bp_dbl_hol_rest_ns,
      ot_reg,
      ot_rest,
      ot_sp_hol,
      ot_sp_rest,
      ot_reg_hol,
      ot_reg_hol_rest,
      ot_dbl_hol,
      ot_dbl_hol_rest,
      ot_reg_ns,
      ot_rest_ns,
      ot_sp_hol_ns,
      ot_sp_rest_ns,
      ot_reg_hol_ns,
      ot_reg_hol_rest_ns,
      ot_dbl_hol_ns,
      ot_dbl_hol_rest_ns
    ){
      var formData = new FormData();
      formData.append('att_date', att_date);
      formData.append('att_employee', att_employee_id);
      formData.append('att_time_in', time_in);
      formData.append('att_time_out', time_out);
      formData.append('att_status', status);
      formData.append('att_remarks', remarks);

      formData.append('bp_reg', bp_reg);
      formData.append('bp_rest', bp_rest);
      formData.append('bp_sp_hol', bp_sp_hol);
      formData.append('bp_sp_rest', bp_sp_rest);
      formData.append('bp_reg_hol', bp_reg_hol);
      formData.append('bp_reg_hol_rest', bp_reg_hol_rest);
      formData.append('bp_dbl_hol', bp_dbl_hol);
      formData.append('bp_dbl_hol_rest', bp_dbl_hol_rest);
      formData.append('bp_reg_ns', bp_reg_ns);
      formData.append('bp_rest_ns', bp_rest_ns);
      formData.append('bp_sp_hol_ns', bp_sp_hol_ns);
      formData.append('bp_sp_rest_ns', bp_sp_rest_ns);
      formData.append('bp_reg_hol_ns', bp_reg_hol_ns);
      formData.append('bp_reg_hol_rest_ns', bp_reg_hol_rest_ns);
      formData.append('bp_dbl_hol_ns', bp_dbl_hol_ns);
      formData.append('bp_dbl_hol_rest_ns', bp_dbl_hol_rest_ns);
      formData.append('ot_reg', ot_reg);
      formData.append('ot_rest', ot_rest);
      formData.append('ot_sp_hol', ot_sp_hol);
      formData.append('ot_sp_rest', ot_sp_rest);
      formData.append('ot_reg_hol', ot_reg_hol);
      formData.append('ot_reg_hol_rest', ot_reg_hol_rest);
      formData.append('ot_dbl_hol', ot_dbl_hol);
      formData.append('ot_dbl_hol_rest', ot_dbl_hol_rest);
      formData.append('ot_reg_ns', ot_reg_ns);
      formData.append('ot_rest_ns', ot_rest_ns);
      formData.append('ot_sp_hol_ns', ot_sp_hol_ns);
      formData.append('ot_sp_rest_ns', ot_sp_rest_ns);
      formData.append('ot_reg_hol_ns', ot_reg_hol_ns);
      formData.append('ot_reg_hol_rest_ns', ot_reg_hol_rest_ns);
      formData.append('ot_dbl_hol_ns', ot_dbl_hol_ns);
      formData.append('ot_dbl_hol_rest_ns', ot_dbl_hol_rest_ns);
      
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      
      return response.json();
    }




    async function get_work_shift_data(url,template_id) {
      var formData = new FormData();
      formData.append('template_id', template_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_cutoff_schedule_data(url,date) {
      var formData = new FormData();
      formData.append('cutoff_date_period', date);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }
    
    async function get_employee_data(url,employee_id,date_period) {
      var formData = new FormData();
      formData.append('employee_id', employee_id);
      formData.append('date_period', date_period);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }
    
    async function get_shift_data(url,shift_id) {
      var formData = new FormData();
      formData.append('shift_id', shift_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }
    
    async function get_holiday_data(url) {
      var formData = new FormData();
      formData.append('shift_id', 'shift');
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
