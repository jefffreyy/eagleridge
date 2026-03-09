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
    border-top: none !important;
  }
  label.required::after{
    content:" *";
    color: red;
  }
  .card-body{
    padding: 15px 20px !important;
  }

  #tab_pills_container li a.active{
    border-bottom: 1px solid #dee2e6;
    border-bottom-left-radius: .25rem;
    border-bottom-right-radius: .25rem;
    background-color: #0f67a3 !important;
    color: #fff !important;
  }

  #tab_pills_container li a:not(.active):hover{
    background-color: #ccc !important;
  }

  .view_leave_details:hover{
    background-color: #E0F2FF;
  }

  .view_overtime_details:hover{
    background-color: #E0F2FF;
  }

  .view_adjustment_details:hover{
    background-color: #E0F2FF;
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
      <div class="row pr-3 mb-2">
        <div class="col">
          <h1 class="page-title">Approval List
          </h1>
        </div>
      </div>
      <ul class="nav nav-tabs border-0" id="tab_pills_container">
          <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#for_approval">For Approval</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#approved">Approved</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#rejected">Rejected</a>
          </li>
      </ul>
      <div class="tab-content mt-3">
        <div class="tab-pane active" id="for_approval">
          <div class="row" >
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <div class="card-title w-100 text-center mb-0" style="font-size: 16px;">Leave Applications</div>
                </div>

                <?php
                  if($DISP_LEAVES_FOR_APPROVAL){
                    foreach($DISP_LEAVES_FOR_APPROVAL as $DISP_LEAVES_FOR_APPROVAL_ROW){
                        $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_LEAVES_FOR_APPROVAL_ROW->col_empl_id);
                        $db_date_from = $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_from;
                        $date_from = date('l, F j, Y',strtotime($db_date_from));

                        switch ($DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type) {
                          case 'Vacation Leave':
                              $leave_balance = $employee_id[0]->col_leave_vacation;
                              break;
                          case 'Sick Leave':
                              $leave_balance = $employee_id[0]->col_leave_sick;
                              break;
                          case 'Maternity Leave':
                              $leave_balance = $employee_id[0]->col_leave_maternity;
                              break;
                          case 'Parental Leave':
                              $leave_balance = $employee_id[0]->col_leave_parental;
                              break;
                          case 'Paternity Leave':
                              $leave_balance = $employee_id[0]->col_leave_paternal;
                              break;
                          case 'Service Incentive Leave':
                              $leave_balance = $employee_id[0]->col_leave_service_incentive;
                              break;
                          case 'Solo Incentive Leave':
                              $leave_balance = $employee_id[0]->col_leave_solo_incentive;
                              break;
                          default:
                          $leave_balance = '';
                        }

                        // get approval route
                        $approval_route = $this->p070_leave_mod->MOD_DISP_SPECIFIC_APPROVAL_ROUTE($DISP_LEAVES_FOR_APPROVAL_ROW->col_empl_id);

                        // loop through the approval routes
                        foreach($approval_route as $approval_route_row){
                          // check if you are a approver then show the list of requests you can only approve
                          $my_user_id = $this->session->userdata('SESS_USER_ID');
                          if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)){
                            ?>
                            <div class="card-body view_leave_details" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" leave_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id ?>" employee_id='<?= $employee_id[0]->id?>'  approve_key='<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id?>' leave_balance='<?= $leave_balance ?>' leave_duration='<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_duration ?>' leave_type="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type ?>">
                                <div class="d-flex">
                                  <img src="<?= base_url() ?>user_images/<?= $employee_id[0]->col_imag_path ?>"  class="rounded-circle avatar mt-1" width="80" height="80">
                                  <div class="ml-2 mt-2">
                                      <a href="#" style="font-size: 15px; color: #1993D7;"><?= $employee_id[0]->col_frst_name.' '.$employee_id[0]->col_last_name ?></a>
                                      <p class="mb-1 text-secondary" style="font-size: 12px;"><?= $employee_id[0]->col_empl_posi ?></p>
                                      <p class="mb-0" style="font-size: 12px;">Leave Date:  <?= $db_date_from ?></p>
                                  </div>
                                  <div class="flex-fill">
                                      <div class="w-100 mt-2">
                                          <div class="float-right text-center" style="height: 100%; width: 100px;">
                                              <p class="mb-0" style="font-size: 12px;">Leave Type:</p>
                                              <label style="color: #687CED;"><?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type ?></label>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            <?php
                          }
                        }
                    }
                  }
                ?>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <div class="card-title w-100 text-center mb-0" style="font-size: 16px;">Overtime Applications</div>
                </div>
                <?php 
                  if($DISP_OVERTIME){
                    foreach($DISP_OVERTIME as $DISP_OVERTIME_ROW){
                      $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_OVERTIME_ROW->empl_id);

                      // get approval route
                      $approval_route = $this->p070_leave_mod->MOD_DISP_SPECIFIC_APPROVAL_ROUTE($DISP_OVERTIME_ROW->empl_id);

                      // loop through the approval routes
                      foreach($approval_route as $approval_route_row){
                        // check if you are a approver then show the list of requests you can only approve
                        $my_user_id = $this->session->userdata('SESS_USER_ID');
                        if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)){
                          ?>
                          <div class="card-body view_overtime_details" employee_id="<?= $DISP_OVERTIME_ROW->empl_id ?>" overtime_id="<?= $DISP_OVERTIME_ROW->id ?>" style="cursor: pointer;" data-toggle="modal" data-target="#modal_overtime_details">
                              <div class="d-flex">
                                <img src="<?= base_url() ?>user_images/<?= $employee[0]->col_imag_path ?>"  class="rounded-circle avatar mt-1" width="80" height="80">
                                <div class="ml-2 mt-2">
                                    <a href="#" style="font-size: 15px; color: #1993D7;"><?= $employee[0]->col_frst_name.' '.$employee[0]->col_last_name ?></a>
                                    <p class="mb-1 text-secondary" style="font-size: 12px;"><?= $employee[0]->col_empl_posi; ?></p>
                                    <p class="mb-0" style="font-size: 12px;">OT Date:  <?= $DISP_OVERTIME_ROW->date_ot ?></p>
                                </div>
                                <div class="flex-fill">
                                    <div class="w-100 mt-2">
                                        <div class="float-right text-center" style="height: 100%; width: 100px;">
                                            <p class="mb-0" style="font-size: 12px;">No. of Hours:</p>
                                            <label style="color: #687CED;"><?= $DISP_OVERTIME_ROW->hours ?> hrs</label>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                          <?php
                        }
                      }
                    }
                  }
                ?>
                
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <div class="card-title w-100 text-center mb-0" style="font-size: 16px;">Time Adjustment Applications</div>
                </div>
                <?php
                  if($DISP_TIME_ADJUSTMENT){
                    foreach($DISP_TIME_ADJUSTMENT as $DISP_TIME_ADJUSTMENT_ROW){
                      $employee1 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_TIME_ADJUSTMENT_ROW->empl_id);

                      // get approval route
                      $approval_route = $this->p070_leave_mod->MOD_DISP_SPECIFIC_APPROVAL_ROUTE($DISP_TIME_ADJUSTMENT_ROW->empl_id);

                      // loop through the approval routes
                      foreach($approval_route as $approval_route_row){
                        // check if you are a approver then show the list of requests you can only approve
                        $my_user_id = $this->session->userdata('SESS_USER_ID');
                        if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)){
                          ?>
                            <div class="card-body view_adjustment_details" employee_id="<?= $DISP_TIME_ADJUSTMENT_ROW->empl_id ?>" adjustment_id="<?= $DISP_TIME_ADJUSTMENT_ROW->id ?>" style="cursor: pointer;" data-toggle="modal" data-target="#modal_adjustment_details">
                              <div class="d-flex">
                                  <img src="<?= base_url() ?>user_images/<?= $employee1[0]->col_imag_path ?>"  class="rounded-circle avatar mt-1" width="80" height="80">
                                  <div class="ml-2 mt-2">
                                      <a href="#" style="font-size: 15px; color: #1993D7;"><?= $employee1[0]->col_frst_name.' '.$employee1[0]->col_last_name ?></a>
                                      <p class="mb-1 text-secondary" style="font-size: 12px;"><?= $employee1[0]->col_empl_posi ?></p>
                                      <p class="mb-0" style="font-size: 12px;">Move To:  <?= $DISP_TIME_ADJUSTMENT_ROW->date_adjustment ?></p>
                                  </div>
                                <div class="flex-fill">
                                    <div class="w-100 mt-2">
                                        <div class="float-right text-center" style="height: 100%; width: 120px;">
                                            <p class="mb-0" style="font-size: 12px;">Shift:</p>
                                            <label style="color: #687CED;"><?= $DISP_TIME_ADJUSTMENT_ROW->shift_type ?></label>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                          <?php
                        }
                      }
                    }
                  }
                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="card p-4 tab-pane" id="approved" style="border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
          <table class="table table-hover table-xs mb-0" id="approved_tbl">
              <thead>
                  <th>Employee</th>
                  <th>Date</th>
                  <th>Leave Type</th>
                  <th>Reason for leave</th>
                  <th>Duration (Day/s)</th>
                  <th>Status</th>
              </thead>
              <tbody style="font-weight: 500 !important;">
                  <?php 
                      if($DISP_LEAVES_APPROVED){
                          foreach($DISP_LEAVES_APPROVED as $DISP_LEAVES_APPROVED_ROW){
                              $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_LEAVES_APPROVED_ROW->col_empl_id);
                              $db_date_from = $DISP_LEAVES_APPROVED_ROW->col_leave_from;
                              $date_from = date('l, F j, Y',strtotime($db_date_from));

                              if($employee_id[0]->col_empl_repo == $this->session->userdata('SESS_USER_ID')){

                                // check if leave balance has value (leave balance is the difference of current leave balance and duration)
                                if($DISP_LEAVES_APPROVED_ROW->col_leave_balance != 0){
                                  $leave_balance = $DISP_LEAVES_APPROVED_ROW->col_leave_balance;
                                }
                          ?>
                            <tr>
                                <td class="view_leave_details approved" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" leave_id="<?= $DISP_LEAVES_APPROVED_ROW->id ?>" employee_id='<?= $employee_id[0]->id?>'><?= $employee_id[0]->col_frst_name.' '.$employee_id[0]->col_last_name ?></td>
                                <td class="view_leave_details approved" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" leave_id="<?= $DISP_LEAVES_APPROVED_ROW->id ?>" employee_id='<?= $employee_id[0]->id?>'><?= $date_from ?></td>
                                <td class="view_leave_details approved" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" leave_id="<?= $DISP_LEAVES_APPROVED_ROW->id ?>" employee_id='<?= $employee_id[0]->id?>'><?= $DISP_LEAVES_APPROVED_ROW->col_leave_type ?></td>
                                <td class="view_leave_details approved" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" leave_id="<?= $DISP_LEAVES_APPROVED_ROW->id ?>" employee_id='<?= $employee_id[0]->id?>'><?= $DISP_LEAVES_APPROVED_ROW->col_leave_comments ?></td>
                                <td class="view_leave_details approved" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" leave_id="<?= $DISP_LEAVES_APPROVED_ROW->id ?>" employee_id='<?= $employee_id[0]->id?>'><?= $DISP_LEAVES_APPROVED_ROW->col_leave_duration ?></td>
                                <td class="view_leave_details approved" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" leave_id="<?= $DISP_LEAVES_APPROVED_ROW->id ?>" employee_id='<?= $employee_id[0]->id?>'><?= $DISP_LEAVES_APPROVED_ROW->col_leave_status ?></td>
                            </tr>
                          <?php
                              }
                          }
                      } else {
                        ?>
                          <tr>
                            <td class="p-4" colspan="6">No approved leave application yet</td>
                          </tr>
                        <?php
                      }
                  ?>
              </tbody>
          </table>
        </div>
        <div class="card p-4 tab-pane" id="rejected" style="border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
          <table class="table table-hover table-xs mb-0" id="rejected_tbl">
              <thead>
                  <th>Employee</th>
                  <th>Date</th>
                  <th>Leave Type</th>
                  <th>Reason for rejection</th>
                  <th>Duration (Day/s)</th>
                  <th>Status</th>
              </thead>
              <tbody style="font-weight: 500 !important;">
                  <?php 
                      if($DISP_LEAVES_REJECTED){
                          foreach($DISP_LEAVES_REJECTED as $DISP_LEAVES_REJECTED_ROW){
                              $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_LEAVES_REJECTED_ROW->col_empl_id);
                              $db_date_from = $DISP_LEAVES_REJECTED_ROW->col_leave_from;
                              $date_from = date('l, F j, Y',strtotime($db_date_from));
                              
                              if($employee_id[0]->col_empl_repo == $this->session->userdata('SESS_USER_ID')){
                          ?>
                            <tr>
                                <td class="view_leave_details rejected" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" leave_id="<?= $DISP_LEAVES_REJECTED_ROW->id ?>"  employee_id='<?= $employee_id[0]->id?>'><?= $employee_id[0]->col_frst_name.' '.$employee_id[0]->col_last_name ?></td>
                                <td class="view_leave_details rejected" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" leave_id="<?= $DISP_LEAVES_REJECTED_ROW->id ?>"  employee_id='<?= $employee_id[0]->id?>'><?= $date_from ?></td>
                                <td class="view_leave_details rejected" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" leave_id="<?= $DISP_LEAVES_REJECTED_ROW->id ?>"  employee_id='<?= $employee_id[0]->id?>'><?= $DISP_LEAVES_REJECTED_ROW->col_leave_type ?></td>
                                <td class="view_leave_details rejected" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" leave_id="<?= $DISP_LEAVES_REJECTED_ROW->id ?>"  employee_id='<?= $employee_id[0]->id?>'><?= $DISP_LEAVES_REJECTED_ROW->col_reason_rejection ?></td>
                                <td class="view_leave_details rejected" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" leave_id="<?= $DISP_LEAVES_REJECTED_ROW->id ?>"  employee_id='<?= $employee_id[0]->id?>'><?= $DISP_LEAVES_REJECTED_ROW->col_leave_duration ?></td>
                                <td class="view_leave_details rejected" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" leave_id="<?= $DISP_LEAVES_REJECTED_ROW->id ?>"  employee_id='<?= $employee_id[0]->id?>'><?= $DISP_LEAVES_REJECTED_ROW->col_leave_status ?></td>
                            </tr>
                          <?php
                              }
                          }
                      } else {
                        ?>
                          <tr>
                            <td class="p-4" colspan="6">No rejected leave application yet</td>
                          </tr>
                        <?php
                      }
                  ?>
              </tbody>
          </table>
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

<!-- View Leave Details -->
<div class="modal fade" id="modal_leave_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title mt-0 ml-1">Leave Details
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
              <img id="modal_employee_img" class="rounded-circle" alt="" style="width: 150px; height: 150px;">
            </div>
            <div class="pl-3 mt-3">
              <p class="text-bold mb-1">Name:</p>
              <p class="mb-4" id="employee_name"></p>
              <p class="text-bold mb-1">Position:</p>
              <p class="mb-4" id="employee_position"></p>
              <p class="text-bold mb-1">Department:</p>
              <p class="mb-4" id="employee_department"></p>
            </div>
          </div>
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Date Requested:</p>
                  <p class="mb-4" id="leave_date_requested"></p>
                  <p class="text-bold mb-1">Request Leave On:</p>
                  <p class="mb-4" id="leave_on_date"></p>
                  <p class="text-bold mb-1">Leave Type:</p>
                  <p class="mb-4" id="leave_type"></p> 
                </div>
              </div>
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Reason:</p>
                  <p class="mb-4"id="leave_reason"></p>
                  <p class="text-bold mb-1">Duration:</p>
                  <p class="mb-4"id="leave_duration"></p>
                  <p class="text-bold mb-1">Status:</p>
                  <p class="mb-4"id="leave_status"></p>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                  <p class="text-bold mb-1">Photo Attachments:</p>
                  <a id="leave_attachment_link" target="_blank">
                    <img id="leave_attachment" alt="" src="<?= base_url() ?>user_images/11017face-10.jpg" style="width: 100px;cursor:pointer" class="w3-hover-opacity">
                  </a>
                  <p style="display:none" class="text-muted" id="empty_attachment">No photo attached</p>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="hidden_leave_id">
        <input type="hidden" id="hidden_employee_id">
        <input type="hidden" id="hidden_approve_key">
        <input type="hidden" id="hidden_leave_balance">
        <input type="hidden" id="hidden_leave_duration">
        <input type="hidden" id="hidden_leave_type">

        <a class='btn btn-primary text-light' id="btn_approve_leave">&nbsp; Approve</a>
        <a class='btn btn-danger text-light BTN_REJECT_LEAVE' id="btn_reject_leave" data-toggle="modal" data-target="#modal_leave_rejection_reason">&nbsp; Reject</a>
      </div>
    </div>
  </div>
</div>

<!-- View Overtime Details -->
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
                  <p class="text-bold mb-1">No. of Hours:</p>
                  <p class="mb-4"id="ot_num_hours"></p>
                  <p class="text-bold mb-1">Reason:</p>
                  <p class="mb-4"id="ot_reason"></p>
                  <p class="text-bold mb-1">Status:</p>
                  <p class="mb-4"id="ot_status"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a type="submit" class='btn btn-primary text-light' id="btn_approve_ot">&nbsp; Approve</a>
        <a type="submit" class='btn btn-danger text-light BTN_REJECT_OVERTIME' id="btn_reject_ot" data-toggle="modal" data-target="#modal_overtime_rejection_reason">&nbsp; Reject</a>
      </div>
    </div>
  </div>
</div>

<!-- View Time Adjustment Details -->
<div class="modal fade" id="modal_adjustment_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title mt-0 ml-1">Time Adjustment Details
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
              <img id="adj_modal_employee_img" class="rounded-circle" alt="" style="width: 150px; height: 150px;">
            </div>
            <div class="pl-3 mt-3">
              <p class="text-bold mb-1">Name:</p>
              <p class="mb-4" id="adj_employee_name"></p>
              <p class="text-bold mb-1">Position:</p>
              <p class="mb-4" id="adj_employee_position"></p>
              <p class="text-bold mb-1">Department:</p>
              <p class="mb-4" id="adj_employee_department"></p>
            </div>
          </div>
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Application Date:</p>
                  <p class="mb-4" id="adj_application_date"></p>
                  <p class="text-bold mb-1">Adjustment Date:</p>
                  <p class="mb-4" id="adj_adjustment_date"></p>
                  <p class="text-bold mb-1">Shift Type:</p>
                  <p class="mb-4"id="adj_shift_type"></p>
                  
                </div>
              </div>
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Time In:</p>
                  <p class="mb-4" id="adj_time_in"></p> 
                  <p class="text-bold mb-1">Time Out:</p>
                  <p class="mb-4" id="adj_time_out"></p> 
                  <p class="text-bold mb-1">Status:</p>
                  <p class="mb-4"id="adj_status"></p>
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <p class="text-bold mb-1">Reason:</p>
                  <p class="mb-4"id="adj_reason"></p>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a type="submit" class='btn btn-primary text-light' id="btn_approve_adj">&nbsp; Approve</a>
        <a type="submit" class='btn btn-danger text-light BTN_REJECT_ADJUSTMENT' id="btn_reject_adj" data-toggle="modal" data-target="#modal_adjustment_rejection_reason">&nbsp; Reject</a>
      </div>
    </div>
  </div>
</div>



<!-- REASON FOR LEAVE REJECTION MODAL -->
<div class="modal fade" id="modal_leave_rejection_reason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Reject Leave Request
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('approval/reject_leave'); ?>" id="FORM_REJECT_LEAVE" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="INSRT_REASON_FOR_REJECTION">Please enter the reason for rejection
                </label>
                <textarea class="form-control" name="INSRT_REASON_FOR_REJECTION" id="INSRT_REASON_FOR_REJECTION" cols="30" rows="3" required></textarea>
              </div>
            </div>
            <input type="hidden" name="REJECT_LEAVE_ID" id="REJECT_LEAVE_ID">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class='btn btn-primary text-light' id="BTN_REJECT">&nbsp; Reject
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- REASON FOR REJECTION MODAL -->
<div class="modal fade" id="modal_overtime_rejection_reason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Reject Overtime Request
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('approval/reject_overtime'); ?>" id="FORM_REJECT_OVERTIME" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="INSRT_REASON_FOR_REJECTION_OVERTIME">Please enter the reason for rejection
                </label>
                <textarea class="form-control" name="INSRT_REASON_FOR_REJECTION" id="INSRT_REASON_FOR_REJECTION_OVERTIME" cols="30" rows="3" required></textarea>
              </div>
            </div>
            <input type="hidden" name="REJECT_OVERTIME_ID" id="REJECT_OVERTIME_ID">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class='btn btn-primary text-light' id="BTN_OVERTIME_REJECT">&nbsp; Reject
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- REASON FOR REJECTION MODAL -->
<div class="modal fade" id="modal_adjustment_rejection_reason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Reject Time Adjustment Request
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('approval/reject_time_adjustment'); ?>" id="FORM_REJECT_ADJUSTMENT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="INSRT_REASON_FOR_REJECTION_ADJUSTMENT">Please enter the reason for rejection
                </label>
                <textarea class="form-control" name="INSRT_REASON_FOR_REJECTION" id="INSRT_REASON_FOR_REJECTION_ADJUSTMENT" cols="30" rows="3" required></textarea>
              </div>
            </div>
            <input type="hidden" name="REJECT_ADJUSTMENT_ID" id="REJECT_ADJUSTMENT_ID">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class='btn btn-primary text-light' id="BTN_ADJUSTMENT_REJECT">&nbsp; Reject
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- /.control-sidebar -->
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
<!-- Include Editor JS files. -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/js/froala_editor.pkgd.min.js">
</script>
<!-- Initialize the editor. -->
<script>
  $(function() {
    $('div#froala-editor').froalaEditor({
      // Set custom buttons with separator between them.
      toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting','html'],
      toolbarButtonsXS: ['undo', 'redo' , '-', 'bold', 'italic','html']
    }
                                       )
    $('i.fa.fa-rotate-left').attr('class')
  }
   );
</script>
<!-- SESSION MESSAGES -->
<?php
if($this->session->userdata('SESS_SUCC_MSG_INSRT_APPLY_LEAVE')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_APPLY_LEAVE'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_INSRT_APPLY_LEAVE');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_UPDT_APPLY_LEAVE')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_APPLY_LEAVE'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_UPDT_APPLY_LEAVE');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_CANCEL_LEAVE')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_CANCEL_LEAVE'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_CANCEL_LEAVE');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_REJECT_LEAVE')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_REJECT_LEAVE'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_REJECT_LEAVE');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_APPROVE_LEAVE')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_APPROVE_LEAVE'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_APPROVE_LEAVE');
}
?>
<script>
  $(document).ready(function(){
    // var for_approval_tbl_length = $('#for_approval_tbl tbody tr').length;
    var approved_tbl_length = $('#approved_tbl tbody tr').length;
    var rejected_tbl_length = $('#rejected_tbl tbody tr').length;

    /* if(for_approval_tbl_length == 0){
      $('#for_approval_tbl tbody').append( "<tr><td colspan='7' class='p-4'>No leave application for approval yet</td></tr>" );
    } */
    if(approved_tbl_length == 0){
      $('#approved_tbl tbody').append( "<tr><td colspan='6' class='p-4'>No leave application approved under your supervision</td></tr>" );
    }
    if(rejected_tbl_length == 0){
      $('#rejected_tbl tbody').append( "<tr><td colspan='6' class='p-4'>No leave application rejected under your supervision</td></tr>" );
    }

    var base_url = '<?= base_url();?>';

    // AJAX LEAVE
    var url = '<?php echo base_url(); ?>leave/get_leave_data';
    const openModalButton = document.querySelectorAll('.view_leave_details');

    openModalButton.forEach(button => {
      button.addEventListener('click', (e) => {
        const modal = document.querySelector(button.dataset.target);

        var modal_leave_id = button.getAttribute('leave_id');
        var modal_employee_id = button.getAttribute('employee_id');

        var modal_approve_key = button.getAttribute('approve_key');
        var modal_leave_balanace = button.getAttribute('leave_balance');
        var modal_leave_duration = button.getAttribute('leave_duration');
        var modal_leave_type = button.getAttribute('leave_type');

        $('#hidden_leave_id').val(modal_leave_id);
        $('#hidden_employee_id').val(modal_employee_id);
        $('#hidden_approve_key').val(modal_approve_key);
        $('#hidden_leave_balance').val(modal_leave_balanace);
        $('#hidden_leave_duration').val(modal_leave_duration);
        $('#hidden_leave_type').val(modal_leave_type);

        $('#btn_reject_leave').attr('reject_key', modal_leave_id);
        $('#btn_reject_leave').attr('leave_id', modal_leave_id);
        $('#btn_reject_leave').attr('employee_id', modal_employee_id);

        if(($(button).hasClass('approved')) || ($(button).hasClass('rejected'))){
          $('#btn_approve_leave').hide();
          $('#btn_reject_leave').hide();
        } else {
          $('#btn_approve_leave').show();
          $('#btn_reject_leave').show();
        }
        

        get_leave_data(url,modal_leave_id,modal_employee_id).then(data => {
          data.leave_data.forEach((leaveData) => {
            $('#leave_date_requested').text(leaveData.col_date_created);
            if(!leaveData.col_leave_to){
              $('#leave_on_date').text(leaveData.col_leave_from);
            } else {
              var leave_end = leaveData.col_leave_to.split(' ');
              $('#leave_on_date').text(leaveData.col_leave_from + ' to ' + leave_end[0]);
            }
            
            $('#leave_type').text(leaveData.col_leave_type);
            $('#leave_reason').text(leaveData.col_leave_comments);
            $('#leave_duration').text((parseFloat(leaveData.col_leave_duration)).toFixed(2) + " Day/s");
            $('#leave_status').text(leaveData.col_leave_status);
            if(leaveData.col_leave_image){
              $('#leave_attachment').attr('src',base_url + 'assets/files/leave/' + leaveData.col_leave_image);
            } else {
              $('#leave_attachment_link').hide();
              $('#empty_attachment').show();
            }
            $('#leave_attachment_link').attr('href',base_url + 'assets/files/leave/' + leaveData.col_leave_image);
          });
          data.employee_data.forEach((employeeData) => {
            $('#employee_name').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
            $('#employee_position').text(employeeData.col_empl_posi);
            $('#employee_department').text(employeeData.col_empl_dept);
            $('#modal_employee_img').attr('src',base_url + 'user_images/' + employeeData.col_imag_path);
          })
        });
      });
    });

    // AJAX OVERTIME
    var url2 = '<?php echo base_url(); ?>approval/get_overtime_data';
    const openModalButton2 = document.querySelectorAll('.view_overtime_details');

    openModalButton2.forEach(button => {
      button.addEventListener('click', () => {

        const modal = document.querySelector(button.dataset.target);
        var modal_employee_id = button.getAttribute('employee_id');
        var modal_overtime_id = button.getAttribute('overtime_id');

        get_overtime_data(url2,modal_employee_id,modal_overtime_id).then(data => {
          data.overtime_data.forEach((overtimeData) => {
            var application_date = overtimeData.date_created;
            var overtime_date = overtimeData.date_ot;
            var time_out = overtimeData.time_out;
            var hours = overtimeData.hours;
            var reason = overtimeData.reason;
            var status = overtimeData.status;
          
            $('#ot_application_date').text(application_date);
            $('#ot_overtime_date').text(overtime_date);
            $('#ot_time_out').text(time_out);
            $('#ot_num_hours').text(hours+' hrs');
            $('#ot_reason').text(reason);
            $('#ot_status').text(status);
          });
          data.employee_data.forEach((employeeData) => {
            $('#ot_employee_name').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
            $('#ot_employee_position').text(employeeData.col_empl_posi);
            $('#ot_employee_department').text(employeeData.col_empl_dept);
            $('#ot_modal_employee_img').attr('src',base_url + 'user_images/' + employeeData.col_imag_path);
          })
        });
      });
    });

    // AJAX TIME ADJUSTMENT
    var url3 = '<?php echo base_url(); ?>approval/get_time_adjustment_data';
    const openModalButton3 = document.querySelectorAll('.view_adjustment_details');

    openModalButton3.forEach(button => {
      button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.target);
        var modal_employee_id = button.getAttribute('employee_id');
        var modal_adjustment_id = button.getAttribute('adjustment_id');

        get_time_adjustment_data(url3,modal_employee_id,modal_adjustment_id).then(data => {
          data.adjustment_data.forEach((adjustment) => {
            var application_date = adjustment.date_created;
            var overtime_date = adjustment.date_adjustment;
            var shift_type = adjustment.shift_type;
            var time_in = adjustment.time_in;
            var time_out = adjustment.time_out;
            var reason = adjustment.reason;
            var status = adjustment.status;
          
            $('#adj_application_date').text(application_date);
            $('#adj_adjustment_date').text(overtime_date);
            $('#adj_shift_type').text(shift_type);
            $('#adj_time_in').text(time_in);
            $('#adj_time_out').text(time_out);
            $('#adj_status').text(reason);
            $('#adj_reason').text(status);
          });
          data.employee_data.forEach((employeeData) => {
            $('#adj_employee_name').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
            $('#adj_employee_position').text(employeeData.col_empl_posi);
            $('#adj_employee_department').text(employeeData.col_empl_dept);
            $('#adj_modal_employee_img').attr('src',base_url + 'user_images/' + employeeData.col_imag_path);
          })
        });
      });
    });

    // Display Leave ID in Reject Modal
    const openModalButton4 = document.querySelectorAll('.BTN_REJECT_LEAVE');
    openModalButton4.forEach(button => {
      button.addEventListener('click', () => {
        $('#modal_leave_details').modal('toggle');
        $('#REJECT_LEAVE_ID').val(button.getAttribute('leave_id'));
      });
    });

    // Display Leave ID in Reject Modal
    const openModalButton5 = document.querySelectorAll('.BTN_REJECT_OVERTIME');
    openModalButton5.forEach(button => {
      button.addEventListener('click', () => {
        $('#modal_overtime_details').modal('toggle');
        $('#REJECT_OVERTIME_ID').val(button.getAttribute('overtime_id'));
      });
    });

    // Display Leave ID in Reject Modal
    const openModalButton6 = document.querySelectorAll('.BTN_REJECT_ADJUSTMENT');
    openModalButton6.forEach(button => {
      button.addEventListener('click', () => {
        $('#modal_adjustment_details').modal('toggle');
        $('#REJECT_ADJUSTMENT_ID').val(button.getAttribute('adjustment_id'));
      });
    });

    // Approve Leave
    $('#btn_approve_leave').click(function(e){
      e.preventDefault();
      var approveKey = $('#hidden_approve_key').val();
      var leave_balance = $('#hidden_leave_balance').val();
      var leave_duration = $('#hidden_leave_duration').val();
      var leave_type = $('#hidden_leave_type').val();
      var employee_id = $('#hidden_employee_id').val();
      Swal.fire({
        title: 'Approve this leave application?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url(); ?>approval/approve_leave?approve_id="+approveKey+'&leave_balance='+leave_balance+'&leave_duration='+leave_duration+'&leave_type='+leave_type+'&employee_id='+employee_id;
        }
      })
    })

    /* // Reject Leave
    $('.BTN_REJECT_LEAVE').click(function(e){
      e.preventDefault();
      var rejectKey = $(this).attr('reject_key');
      Swal.fire({
        title: 'Reject this leave application?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url(); ?>leave/reject_leave?reject_id="+rejectKey;
        }
      })
    }) */

    


























    async function get_leave_data(url,leave_id,employee_id) {
      var formData = new FormData();
      formData.append('leave_id', leave_id);
      formData.append('employee_id', employee_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_overtime_data(url,employee_id,overtime_id) {
      var formData = new FormData();
      formData.append('employee_id', employee_id);
      formData.append('overtime_id', overtime_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_time_adjustment_data(url,employee_id,adjustment_id) {
      var formData = new FormData();
      formData.append('employee_id', employee_id);
      formData.append('adjustment_id', adjustment_id);
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
