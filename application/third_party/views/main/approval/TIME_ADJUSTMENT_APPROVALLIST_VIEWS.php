<style>
  .btn-group .btn {
    padding: 0px 12px;
  }

  .page-title {
    font-weight: 600;
    color: #424F5C;
    font-size: 33px;
  }

  th,
  td {
    font-size: 13px !important;
    border-top: none !important;
  }

  label.required::after {
    content: " *";
    color: red;
  }

  .card-body {
    padding: 15px 20px !important;
  }

  #tab_pills_container li a.active {
    border-bottom: 1px solid #dee2e6;
    border-bottom-left-radius: .25rem;
    border-bottom-right-radius: .25rem;
    background-color: #0f67a3 !important;
    color: #fff !important;
  }

  #tab_pills_container li a:not(.active):hover {
    background-color: #ccc !important;
  }

  .approval_card {
    cursor: pointer;
    border-bottom: 1px solid #dadada;
  }

  .approval_card img {
    width: 40px;
    height: 40px;
  }

  .approval_card p {
    font-size: 11px;
  }

  .approval_card a {
    font-size: 12px;
    color: #1993D7;
  }

  .approval_card:hover {
    background-color: #E0F2FF;
  }

  .view_overtime_details:hover {
    background-color: #E0F2FF;
  }

  .view_adjustment_details:hover {
    background-color: #E0F2FF;
  }

  .btn-primary-inactive {
    background-color: #bfe3fb;
    color: #0D74BC !important;
  }

  .btn-primary-inactive:hover {
    background-color: #76c4f8;
    color: #fff !important;
  }
</style>
<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row">
      <div class="col-md-6">
        <h1 class="page-title">Time Adjustment Applications</h1>
      </div>
      <div class = "col-md-6" style = "text-align: right;">
        <a href="#" class="btn btn-primary shadow-none" style="text-decoration: none;"><i class="fas fa-wrench"></i>&nbsp; &nbsp; Time Adjustment</a>
        <a href="<?= base_url() ?>approval/approval_list_overtime" class="btn btn-primary shadow-none" style="text-decoration: none;"><i class="fas fa-history"></i>&nbsp; &nbsp; Overtime</a>
        <a href="<?= base_url() ?>approval/approval_list" class="btn btn-primary shadow-none" style="text-decoration: none;"><i class="fas fa-door-open"></i>&nbsp; &nbsp; Leave</a>
      </div>
    </div>
    <hr>

    <a href="#" id="reject_all" type="button" class="btn btn-danger shadow-none float-right mr-3" approve_type='Reject'>Reject All Selected</a>
    <a href="#" id="approve_all" type="button" class="btn btn-primary shadow-none float-right mr-3" approve_type='Approve'>Approve All Selected</a>

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
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <div class="card-title w-100  mb-0" style="font-size: 13.5px;">For Approval</div>
              </div>

              <?php
              if ($DISP_TIME_ADJUSTMENT_FOR_APPROVAL) {
                foreach ($DISP_TIME_ADJUSTMENT_FOR_APPROVAL as $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW) {
                  $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->empl_id);
                  // get approval route
                  $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_OT_ADJ();

                  $empl_cmid = '';
                  $empl_image = '';
                  $empl_fullname = '';
                  $empl_position = '';
                  if (count($employee) > 0) {
                    $empl_cmid = $employee[0]->col_empl_cmid;
                    $empl_image = $employee[0]->col_imag_path;
                    if (!empty($employee[0]->col_midl_name)) {
                      $midl_ini = $employee[0]->col_midl_name[0] . '.';
                    } else {
                      $midl_ini = '';
                    }
                    $empl_fullname = $employee[0]->col_last_name . ', ' . $employee[0]->col_frst_name . ' ' . $midl_ini;
                    $empl_position = $employee[0]->col_empl_posi;
                  }

                  // loop through the approval routes
                  foreach ($approval_route as $approval_route_row) {
                    // check if you are a approver then show the list of requests you can only approve
                    $my_user_id = $this->session->userdata('SESS_USER_ID');
                    if (($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id)) {

                      if ((($DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->status1 != 'Rejected') && ($DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->status2 != 'Rejected')) && (($DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->status1 == 'Pending') || ($DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->status2 == 'Pending'))) {
              ?>
                        <div class="card-body approval_card for_approval_details" data-toggle="modal" data-target="#modal_for_approval_adjustment_details" employee_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->empl_id ?>" adjustment_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->id ?>">
                          <div class="d-flex">
                            <img src="<?= base_url() ?>user_images/<?php echo $empl_image != '' ? $empl_image : 'default_profile_img3.png'; ?>" class="rounded-circle avatar mt-2">
                            <div class="ml-2 mt-2">
                              <a href="#"><?= $empl_cmid . ' - ' . $empl_fullname ?></a>
                              <p class="mb-1 text-secondary"><?= $empl_position; ?></p>
                              <p class="mb-0">Move To: <?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->date_adjustment ?></p>
                            </div>
                            <div class="flex-fill">
                              <div class="w-100 mt-2">
                                <div class="float-right text-center" style="height: 100%; width: 100px;">
                                  <p class="mb-0">Shift:</p>
                                  <label style="color: #687CED;font-size: 11px;"><?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->shift_type ?></label>
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
              }
              ?>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <div class="card-title w-100 mb-0" style="font-size: 13.5px;">
                  <a href='#' id="check_all_appr_1" class="float-right" style="font-weight: 500; text-decoration: none; margin-bottom: -20px;">Check All</a>
                  Approver 1
                </div>
              </div>

              <?php
              if ($DISP_TIME_ADJUSTMENT_FOR_APPROVAL) {
                foreach ($DISP_TIME_ADJUSTMENT_FOR_APPROVAL as $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW) {
                  $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->empl_id);

                  // get approval route
                  $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_OT_ADJ();

                  $empl_id = '';
                  $empl_cmid = '';
                  $empl_image = '';
                  $empl_fullname = '';
                  $empl_position = '';
                  if (count($employee) > 0) {
                    $empl_id = $employee[0]->id;
                    $empl_cmid = $employee[0]->col_empl_cmid;
                    $empl_image = $employee[0]->col_imag_path;
                    if (!empty($employee[0]->col_midl_name)) {
                      $midl_ini = $employee[0]->col_midl_name[0] . '.';
                    } else {
                      $midl_ini = '';
                    }
                    $empl_fullname = $employee[0]->col_last_name . ', ' . $employee[0]->col_frst_name . ' ' . $midl_ini;
                    $empl_position = $employee[0]->col_empl_posi;
                  }
                  // loop through the approval routes
                  foreach ($approval_route as $approval_route_row) {
                    // check if you are a approver then show the list of requests you can only approve
                    $my_user_id = $this->session->userdata('SESS_USER_ID');
                    if (($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id)) {

                      if (($DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->status1 == 'Pending')) {
              ?>
                        <div class="card-body approval_card appr_details" appr_num="appr_1" data-toggle="modal" data-target="#modal_adjustment_details" employee_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->empl_id ?>" adjustment_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->id ?>">
                          <div class="d-flex">
                            <img src="<?= base_url() ?>user_images/<?php echo $empl_image ? $empl_image : 'default_profile_img3.png'; ?>" class="rounded-circle avatar mt-2">
                            <div class="ml-2 mt-2">
                              <a href="#"><?= $empl_cmid . ' - ' . $empl_fullname ?></a>
                              <p class="mb-1 text-secondary"><?= $empl_position; ?></p>
                              <p class="mb-0">Move To: <?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->date_adjustment ?></p>
                            </div>
                            <div class="flex-fill">
                              <div class="w-100 mt-2">
                                <div class="float-right text-center" style="height: 100%; width: 100px;">
                                  <p class="mb-0">Shift:</p>
                                  <label style="color: #687CED;font-size: 11px;"><?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->shift_type ?></label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="d-flex flex-row-reverse mt-3">
                            <a href="#" class="text-white btn_fast_reject btn btn-danger" appr_num="appr_1" adjustment_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->id ?>" style="font-size: 12px !important;"><i class="fas fa-times"></i> &nbsp; Reject</a>
                            <a href="#" class="text-white btn_fast_approve btn btn-primary mr-1" appr_num="appr_1" employee_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->empl_id ?>" adjustment_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->id ?>" style="font-size: 12px !important;"><i class="fas fa-check"></i> &nbsp; Approve</a>
                          </div>
                        </div>
                        <div class="form-group ml-2 mb-0 mr-auto" style="margin-top: -40px; margin-left: 20px;">
                          <div class="icheck-primary d-inline">
                            <input type="checkbox" class="selected_application selected_application_appr_2" id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->id ?>" appr_num="appr_1" adjustment_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->id ?>" employee_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->empl_id ?>">
                            <label for="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->id ?>"></label>
                          </div>
                        </div>
              <?php
                      }
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
                <div class="card-title w-100 mb-0" style="font-size: 13.5px;">
                  <a href='#' id="check_all_appr_2" class="float-right" style="font-weight: 500; text-decoration: none; margin-bottom: -20px;">Check All</a>
                  Approver 2
                </div>
              </div>

              <?php
              if ($DISP_TIME_ADJUSTMENT_FOR_APPROVAL) {
                foreach ($DISP_TIME_ADJUSTMENT_FOR_APPROVAL as $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW) {
                  $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->empl_id);

                  // get approval route
                  $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_OT_ADJ();

                  $empl_cmid = '';
                  $empl_image = '';
                  $empl_fullname = '';
                  $empl_position = '';
                  if (count($employee) > 0) {
                    $empl_cmid = $employee[0]->col_empl_cmid;
                    $empl_image = $employee[0]->col_imag_path;
                    if (!empty($employee[0]->col_midl_name)) {
                      $midl_ini = $employee[0]->col_midl_name[0] . '.';
                    } else {
                      $midl_ini = '';
                    }
                    $empl_fullname = $employee[0]->col_last_name . ', ' . $employee[0]->col_frst_name . ' ' . $midl_ini;
                    $empl_position = $employee[0]->col_empl_posi;
                  }

                  // loop through the approval routes
                  foreach ($approval_route as $approval_route_row) {
                    // check if you are a approver then show the list of requests you can only approve
                    $my_user_id = $this->session->userdata('SESS_USER_ID');
                    if (($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id)) {

                      if (($DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->status1 == 'Approved') && ($DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->status2 == 'Pending')) {
              ?>
                        <div class="card-body approval_card appr_details" appr_num="appr_2" data-toggle="modal" data-target="#modal_adjustment_details" employee_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->empl_id ?>" adjustment_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->id ?>">
                          <div class="d-flex">
                            <img src="<?= base_url() ?>user_images/<?php echo $empl_image ? $empl_image : 'default_profile_img3.png'; ?>" class="rounded-circle avatar mt-2">
                            <div class="ml-2 mt-2">
                              <a href="#"><?= $empl_cmid . ' - ' . $empl_fullname ?></a>
                              <p class="mb-1 text-secondary"><?= $empl_position; ?></p>
                              <p class="mb-0">Move To: <?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->date_adjustment ?></p>
                            </div>
                            <div class="flex-fill">
                              <div class="w-100 mt-2">
                                <div class="float-right text-center" style="height: 100%; width: 100px;">
                                  <p class="mb-0">Shift:</p>
                                  <label style="color: #687CED;font-size: 11px;"><?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->shift_type ?></label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="d-flex flex-row-reverse mt-3">
                            <a href="#" class="text-white btn_fast_reject btn btn-danger" appr_num="appr_2" adjustment_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->id ?>" style="font-size: 12px !important;"><i class="fas fa-times"></i> &nbsp; Reject</a>
                            <a href="#" class="text-white btn_fast_approve btn btn-primary mr-1" appr_num="appr_2" employee_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->empl_id ?>" adjustment_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->id ?>" style="font-size: 12px !important;"><i class="fas fa-check"></i> &nbsp; Approve</a>
                          </div>
                        </div>
                        <div class="form-group ml-2 mb-0 mr-auto" style="margin-top: -40px; margin-left: 20px;">
                          <div class="icheck-primary d-inline">
                            <input type="checkbox" class="selected_application selected_application_appr_2" id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->id ?>" appr_num="appr_2" adjustment_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->id ?>" employee_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->empl_id ?>">
                            <label for="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->id ?>"></label>
                          </div>
                        </div>
              <?php
                      }
                    }
                  }
                }
              }
              ?>

            </div>
          </div>
          <!-- <div class="col-md-3">
              <div class="card">
                <div class="card-header">
                  <div class="card-title w-100 text-center mb-0" style="font-size: 13.5px;">Approver 3</div>
                </div>

                <?php
                if ($DISP_TIME_ADJUSTMENT_FOR_APPROVAL) {
                  foreach ($DISP_TIME_ADJUSTMENT_FOR_APPROVAL as $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW) {
                    $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->empl_id);

                    // get approval route
                    $approval_route = $this->p070_leave_mod->MOD_DISP_SPECIFIC_APPROVAL_ROUTE($DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->empl_id);

                    // loop through the approval routes
                    foreach ($approval_route as $approval_route_row) {
                      // check if you are a approver then show the list of requests you can only approve
                      $my_user_id = $this->session->userdata('SESS_USER_ID');
                      if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)) {

                        if (($DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->status2 == 'Approved') && ($DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->status3 == 'Pending')) {
                ?>
                                    <div class="card-body approval_card appr_details" appr_num="appr_3" data-toggle="modal" data-target="#modal_adjustment_details" employee_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->empl_id ?>" adjustment_id="<?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->id ?>">
                                        <div class="d-flex">
                                            <img src="<?= base_url() ?>user_images/<?= $employee[0]->col_imag_path ?>"  class="rounded-circle avatar mt-2">
                                            <div class="ml-2 mt-2">
                                                <a href="#" ><?= $employee[0]->col_frst_name . ' ' . $employee[0]->col_last_name ?></a>
                                                <p class="mb-1 text-secondary" ><?= $employee[0]->col_empl_posi; ?></p>
                                                <p class="mb-0">Move To:  <?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->date_adjustment ?></p>
                                            </div>
                                            <div class="flex-fill">
                                                <div class="w-100 mt-2">
                                                    <div class="float-right text-center" style="height: 100%; width: 100px;">
                                                        <p class="mb-0">Shift:</p>
                                                        <label style="color: #687CED;font-size: 11px;"><?= $DISP_TIME_ADJUSTMENT_FOR_APPROVAL_ROW->shift_type ?></label>
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
                      }
                                ?>
                
              </div>
            </div> -->
        </div>
      </div>

      <div class="card p-4 tab-pane" id="approved" style="border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
        <table class="table table-hover table-xs mb-0" id="approved_tbl">
          <thead>
            <th>Application ID</th>
            <th>Application Date</th>
            <th>Assigned By</th>
            <th>Employee</th>
            <th>Adjustment Date</th>
            <th>Shift</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Reason</th>
            <th>Status</th>
          </thead>
          <tbody style="font-weight: 500 !important;">
            <?php
            if ($DISP_APPROVED_ADJ) {
              foreach ($DISP_APPROVED_ADJ as $DISP_APPROVED_ADJ_ROW) {
                $application_id = 'ADJ' . str_pad($DISP_APPROVED_ADJ_ROW->id, 5, '0', STR_PAD_LEFT);
                $db_time_in = explode(':', $DISP_APPROVED_ADJ_ROW->time_in);
                $time_in = $db_time_in[0] . ':' . $db_time_in[1];
                $db_time_out = explode(':', $DISP_APPROVED_ADJ_ROW->time_out);
                $time_out = $db_time_out[0] . ':' . $db_time_out[1];

                $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVED_ADJ_ROW->empl_id);
                $assigned_by = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVED_ADJ_ROW->assigned_by);
                if (!empty($assigned_by[0]->col_midl_name)) {
                  $midl_ini = $assigned_by[0]->col_midl_name[0] . '.';
                } else {
                  $midl_ini = '';
                }
                if (!empty($employee[0]->col_midl_name)) {
                  $midl_ini2 = $employee[0]->col_midl_name[0] . '.';
                } else {
                  $midl_ini2 = '';
                }
            ?>
                <tr>
                  <td><?= $application_id ?></td>
                  <td><?= $DISP_APPROVED_ADJ_ROW->date_created ?></td>
                  <td>
                    <a href="<?= base_url() ?>employees/personal?id=<?= $assigned_by[0]->id ?>">
                      <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($assigned_by[0]->col_imag_path) {
                                                                                        echo base_url() . 'user_images/' . $assigned_by[0]->col_imag_path;
                                                                                      } else {
                                                                                        echo base_url() . 'user_images/default_profile_img3.png';
                                                                                      } ?>">&nbsp;&nbsp;<?= $assigned_by[0]->col_last_name . ', ' . $assigned_by[0]->col_frst_name . ' ' . $midl_ini ?>
                    </a>
                  </td>
                  <td>
                    <a href="<?= base_url() ?>employees/personal?id=<?= $employee[0]->id ?>">
                      <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($employee[0]->col_imag_path) {
                                                                                        echo base_url() . 'user_images/' . $employee[0]->col_imag_path;
                                                                                      } else {
                                                                                        echo base_url() . 'user_images/default_profile_img3.png';
                                                                                      } ?>">&nbsp;&nbsp;<?= $employee[0]->col_last_name . ', ' . $employee[0]->col_frst_name . ' ' . $midl_ini2 ?>
                    </a>
                  </td>
                  <td><?= $DISP_APPROVED_ADJ_ROW->date_adjustment ?></td>
                  <td><?= $DISP_APPROVED_ADJ_ROW->shift_type ?></td>
                  <td><?= $DISP_APPROVED_ADJ_ROW->time_in ?></td>
                  <td><?= $DISP_APPROVED_ADJ_ROW->time_out ?></td>
                  <td><?= $DISP_APPROVED_ADJ_ROW->reason ?></td>
                  <td><?= $DISP_APPROVED_ADJ_ROW->status1 ?></td>
                </tr>

              <?php
              }
            } else {
              ?>
              <tr>
                <td class="p-4" colspan="8">No approved leave application yet</td>
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
            <th>Application ID</th>
            <th>Application Date</th>
            <th>Assigned By</th>
            <th>Employee</th>
            <th>Adjustment Date</th>
            <th>Shift</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Reason</th>
            <th>Status</th>
          </thead>
          <tbody style="font-weight: 500 !important;">
            <?php
            if ($DISP_REJECTED_ADJ) {
              foreach ($DISP_REJECTED_ADJ as $DISP_REJECTED_ADJ_ROW) {
                $application_id = 'ADJ' . str_pad($DISP_REJECTED_ADJ_ROW->id, 5, '0', STR_PAD_LEFT);
                $db_time_in = explode(':', $DISP_REJECTED_ADJ_ROW->time_in);
                $time_in = $db_time_in[0] . ':' . $db_time_in[1];
                $db_time_out = explode(':', $DISP_REJECTED_ADJ_ROW->time_out);
                $time_out = $db_time_out[0] . ':' . $db_time_out[1];

                $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_REJECTED_ADJ_ROW->empl_id);
                $assigned_by = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_REJECTED_ADJ_ROW->assigned_by);
                if (!empty($assigned_by[0]->col_midl_name)) {
                  $midl_ini = $assigned_by[0]->col_midl_name[0] . '.';
                } else {
                  $midl_ini = '';
                }
                if (!empty($employee[0]->col_midl_name)) {
                  $midl_ini2 = $employee[0]->col_midl_name[0] . '.';
                } else {
                  $midl_ini2 = '';
                }
            ?>
                <tr>
                  <td><?= $application_id ?></td>
                  <td><?= $DISP_REJECTED_ADJ_ROW->date_created ?></td>
                  <td>
                    <a href="<?= base_url() ?>employees/personal?id=<?= $assigned_by[0]->id ?>">
                      <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($assigned_by[0]->col_imag_path) {
                                                                                        echo base_url() . 'user_images/' . $assigned_by[0]->col_imag_path;
                                                                                      } else {
                                                                                        echo base_url() . 'user_images/default_profile_img3.png';
                                                                                      } ?>">&nbsp;&nbsp;<?= $assigned_by[0]->col_last_name . ', ' . $assigned_by[0]->col_frst_name . ' ' . $midl_ini ?>
                    </a>
                  </td>
                  <td>
                    <a href="<?= base_url() ?>employees/personal?id=<?= $employee[0]->id ?>">
                      <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($employee[0]->col_imag_path) {
                                                                                        echo base_url() . 'user_images/' . $employee[0]->col_imag_path;
                                                                                      } else {
                                                                                        echo base_url() . 'user_images/default_profile_img3.png';
                                                                                      } ?>">&nbsp;&nbsp;<?= $employee[0]->col_last_name . ', ' . $employee[0]->col_frst_name . ' ' . $midl_ini2 ?>
                    </a>
                  </td>
                  <td><?= $DISP_REJECTED_ADJ_ROW->date_adjustment ?></td>
                  <td><?= $DISP_REJECTED_ADJ_ROW->shift_type ?></td>
                  <td><?= $DISP_REJECTED_ADJ_ROW->time_in ?></td>
                  <td><?= $DISP_REJECTED_ADJ_ROW->time_out ?></td>
                  <td><?= $DISP_REJECTED_ADJ_ROW->reason ?></td>
                  <td>Rejected</td>
                </tr>

              <?php
              }
            } else {
              ?>
              <tr>
                <td class="p-4" colspan="8">No approved leave application yet</td>
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







<!-- Selected Approved Applications Details Hidden Container -->
<form action="<?php echo base_url('approval/approve_all_adjustment'); ?>" id="form_approve_all" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">

</form>


<!-- Selected Rejected Applications Details Hidden Container -->
<form action="<?php echo base_url('approval/reject_all_adjustment'); ?>" id="form_reject_all" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">

</form>









<!-- content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>


<!-- View Time Adjustment Details -->
<div class="modal fade" id="modal_for_approval_adjustment_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  <p class="mb-4" id="adj_shift_type"></p>

                </div>
              </div>
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Time In:</p>
                  <p class="mb-4" id="adj_time_in"></p>
                  <p class="text-bold mb-1">Time Out:</p>
                  <p class="mb-4" id="adj_time_out"></p>
                  <p class="text-bold mb-1">Reason:</p>
                  <p class="mb-4" id="adj_reason"></p>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-4">
                <p class="text-bold mb-1">Status 1:</p>
                <p class="mb-4" id="adj_status1"></p>
              </div>
              <div class="col-md-4">
                <p class="text-bold mb-1">Status 2:</p>
                <p class="mb-4" id="adj_status2"></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-6">
                <p class="text-bold mb-1">Attachment:</p>
                <a id="time_adjustment_link_img" target="_blank">
                  <img id="time_adjustment_img" alt="" src="" style="width: 100px;cursor:pointer" class="w3-hover-opacity">
                </a>
                <p style="display:none" class="text-muted" id="empty_attachment">No attachement</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <a type="submit" class='btn btn-primary text-light' id="btn_approve_adj">&nbsp; Approve</a>
        <a type="submit" class='btn btn-danger text-light BTN_REJECT_ADJUSTMENT' id="btn_reject_adj" data-toggle="modal" data-target="#modal_adjustment_rejection_reason">&nbsp; Reject</a>
      </div> -->
    </div>
  </div>
</div>


<!-- View For Approval Overtime Details -->
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
              <img id="appr_adj_modal_employee_img" class="rounded-circle" alt="" style="width: 150px; height: 150px;">
            </div>
            <div class="pl-3 mt-3">
              <p class="text-bold mb-1">Name:</p>
              <p class="mb-4" id="appr_adj_employee_name"></p>
              <p class="text-bold mb-1">Position:</p>
              <p class="mb-4" id="appr_adj_employee_position"></p>
              <p class="text-bold mb-1">Department:</p>
              <p class="mb-4" id="appr_adj_employee_department"></p>
            </div>
          </div>
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Application Date:</p>
                  <p class="mb-4" id="appr_adj_application_date"></p>
                  <p class="text-bold mb-1">Adjustment Date:</p>
                  <p class="mb-4" id="appr_adj_adjustment_date"></p>
                  <p class="text-bold mb-1">Shift Type:</p>
                  <p class="mb-4" id="appr_adj_shift_type"></p>

                </div>
              </div>
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Time In:</p>
                  <p class="mb-4" id="appr_adj_time_in"></p>
                  <p class="text-bold mb-1">Time Out:</p>
                  <p class="mb-4" id="appr_adj_time_out"></p>
                  <p class="text-bold mb-1">Reason:</p>
                  <p class="mb-4" id="appr_adj_reason"></p>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-4">
                <p class="text-bold mb-1">Status 1:</p>
                <p class="mb-4" id="appr_adj_status1"></p>
              </div>
              <div class="col-md-4">
                <p class="text-bold mb-1">Status 2:</p>
                <p class="mb-4" id="appr_adj_status2"></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-6">
                <p class="text-bold mb-1">Attachment:</p>
                <a id="appr_time_adjustment_link_img" target="_blank">
                  <img id="appr_time_adjustment_img" alt="" src="" style="width: 100px;cursor:pointer" class="w3-hover-opacity">
                </a>
                <p style="display:none" class="text-muted" id="appr_empty_attachment">No attachement</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="hidden_employee_id" id="hidden_employee_id">
        <input type="hidden" name="hidden_adjustment_id" id="hidden_adjustment_id">
        <input type="hidden" name="hidden_appr_num" id="hidden_appr_num">
        <a type="submit" class='btn btn-primary text-light' id="btn_approve_adj">&nbsp; Approve</a>
        <a type="submit" class='btn btn-danger text-light BTN_REJECT_ADJUSTMENT' id="btn_reject_adj" data-toggle="modal" data-target="#modal_adjustment_rejection_reason">&nbsp; Reject</a>
      </div>
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
                <textarea class="form-control" name="INSRT_REASON_FOR_REJECTION_ADJUSTMENT" id="INSRT_REASON_FOR_REJECTION_ADJUSTMENT" cols="30" rows="3" required></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="reject_adjustment_id" id="reject_adjustment_id">
          <input type="hidden" name="reject_appr_num" id="reject_appr_num">
          <button type="submit" class='btn btn-primary text-light' id="BTN_ADJUSTMENT_REJECT">&nbsp; Reject </button>
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
<!-- SESSION MESSAGES -->
<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_APPLY_LEAVE')) {
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
if ($this->session->userdata('SESS_SUCC_MSG_UPDT_APPLY_LEAVE')) {
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
if ($this->session->userdata('SESS_SUCC_MSG_CANCEL_LEAVE')) {
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
if ($this->session->userdata('SESS_SUCC_MSG_REJECT_LEAVE')) {
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
if ($this->session->userdata('SESS_SUCC_MSG_APPROVE_LEAVE')) {
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
<?php
if ($this->session->userdata('SESS_ERR_MSG_APPROVE_LEAVE')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_ERR_MSG_APPROVE_LEAVE'); ?>',
      '',
      'error'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_ERR_MSG_APPROVE_LEAVE');
}
?>
<script>
  $(document).ready(function() {
    // var for_approval_tbl_length = $('#for_approval_tbl tbody tr').length;
    var approved_tbl_length = $('#approved_tbl tbody tr').length;
    var rejected_tbl_length = $('#rejected_tbl tbody tr').length;

    /* if(for_approval_tbl_length == 0){
      $('#for_approval_tbl tbody').append( "<tr><td colspan='7' class='p-4'>No leave application for approval yet</td></tr>" );
    } */
    if (approved_tbl_length == 0) {
      $('#approved_tbl tbody').append("<tr><td colspan='6' class='p-4'>No leave application approved under your supervision</td></tr>");
    }
    if (rejected_tbl_length == 0) {
      $('#rejected_tbl tbody').append("<tr><td colspan='6' class='p-4'>No leave application rejected under your supervision</td></tr>");
    }

    var base_url = '<?= base_url(); ?>';


























    // AJAX TIME ADJUSTMENT
    var url_get_time_adjustment_data = '<?php echo base_url(); ?>approval/get_time_adjustment_data';
    $('.for_approval_details').click(function() {
      var modal_employee_id = $(this).attr('employee_id');
      var modal_adjustment_id = $(this).attr('adjustment_id');

      get_time_adjustment_data(url_get_time_adjustment_data, modal_employee_id, modal_adjustment_id).then(data => {
        data.adjustment_data.forEach((adjustment) => {
          var application_date = adjustment.date_created;
          var overtime_date = adjustment.date_adjustment;
          var shift_type = adjustment.shift_type;
          var time_in = adjustment.time_in;
          var time_out = adjustment.time_out;
          var reason = adjustment.reason;
          var status1 = adjustment.status1;
          var status2 = adjustment.status2;
          // var status3 = adjustment.status3;

          $('#adj_application_date').text(application_date);
          $('#adj_adjustment_date').text(overtime_date);
          $('#adj_shift_type').text(shift_type);
          $('#adj_time_in').text(time_in);
          $('#adj_time_out').text(time_out);
          $('#adj_reason').text(reason);
          $('#adj_status1').text(status1);
          $('#adj_status2').text(status2);
          // $('#adj_status3').text(status3);

          if (adjustment.attachment) {
            $('#empty_attachment').hide();
            $('#time_adjustment_img').attr('src', base_url + 'assets/files/time_adjustment/' + adjustment.attachment);
          } else {
            $('#time_adjustment_link_img').hide();
            $('#empty_attachment').show();
          }
          $('#time_adjustment_link_img').attr('href', base_url + 'assets/files/time_adjustment/' + adjustment.attachment);
        });
        data.employee_data.forEach((employeeData) => {
          $('#adj_employee_name').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
          $('#adj_employee_position').text(employeeData.col_empl_posi);
          $('#adj_employee_department').text(employeeData.col_empl_dept);
          if (employeeData.col_imag_path) {
            $('#adj_modal_employee_img').attr('src', base_url + 'user_images/' + employeeData.col_imag_path);
          } else {
            $('#adj_modal_employee_img').attr('src', base_url + 'user_images/' + 'default_profile_img3.png');
          }

        })
      })
    })


    $('.appr_details').click(function() {
      var modal_employee_id = $(this).attr('employee_id');
      var modal_adjustment_id = $(this).attr('adjustment_id');
      var modal_appr_num = $(this).attr('appr_num');

      $('#hidden_employee_id').val(modal_employee_id);
      $('#hidden_adjustment_id').val(modal_adjustment_id);
      $('#hidden_appr_num').val(modal_appr_num);

      $('#btn_reject_adj').attr('adjustment_id', modal_adjustment_id);
      $('#btn_reject_adj').attr('appr_num', modal_appr_num);

      get_time_adjustment_data(url_get_time_adjustment_data, modal_employee_id, modal_adjustment_id).then(data => {
        data.adjustment_data.forEach((adjustment) => {
          var application_date = adjustment.date_created;
          var overtime_date = adjustment.date_adjustment;
          var shift_type = adjustment.shift_type;
          var time_in = adjustment.time_in;
          var time_out = adjustment.time_out;
          var reason = adjustment.reason;
          var status1 = adjustment.status1;
          var status2 = adjustment.status2;
          // var status3 = adjustment.status3;

          $('#appr_adj_application_date').text(application_date);
          $('#appr_adj_adjustment_date').text(overtime_date);
          $('#appr_adj_shift_type').text(shift_type);
          $('#appr_adj_time_in').text(time_in);
          $('#appr_adj_time_out').text(time_out);
          $('#appr_adj_reason').text(reason);
          $('#appr_adj_status1').text(status1);
          $('#appr_adj_status2').text(status2);
          // $('#appr_adj_status3').text(status3);

          // appr_time_adjustment_link_img
          // appr_time_adjustment_img
          // appr_empty_attachment
          if (adjustment.attachment) {
            $('#appr_empty_attachment').hide();
            $('#appr_time_adjustment_img').attr('src', base_url + 'assets/files/time_adjustment/' + adjustment.attachment);
          } else {
            $('#appr_time_adjustment_link_img').hide();
            $('#appr_empty_attachment').show();
          }
          $('#appr_time_adjustment_link_img').attr('href', base_url + 'assets/files/time_adjustment/' + adjustment.attachment);
        });
        data.employee_data.forEach((employeeData) => {
          $('#appr_adj_employee_name').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
          $('#appr_adj_employee_position').text(employeeData.col_empl_posi);
          $('#appr_adj_employee_department').text(employeeData.col_empl_dept);
          if (employeeData.col_imag_path) {
            $('#appr_adj_modal_employee_img').attr('src', base_url + 'user_images/' + employeeData.col_imag_path);
          } else {
            $('#appr_adj_modal_employee_img').attr('src', base_url + 'user_images/' + 'default_profile_img3.png');
          }
        })
      })
    })







    // Approve OT
    $('#btn_approve_adj').click(function(e) {
      e.preventDefault();
      var modal_employee_id = $('#hidden_employee_id').val();
      var modal_adjustment_id = $('#hidden_adjustment_id').val();

      var appr_num = $('#hidden_appr_num').val();
      Swal.fire({
        title: 'Approve this time adjustment application?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url(); ?>approval/approve_time_adjustment?employee_id=" + modal_employee_id + '&adjustment_id=' + modal_adjustment_id + '&appr_num=' + appr_num;
        }
      })
    })

    // Reject Time Adjustment
    $('.BTN_REJECT_ADJUSTMENT').click(function() {
      var adjustment_id = $(this).attr('adjustment_id');
      var appr_num = $(this).attr('appr_num');

      $('#reject_adjustment_id').val(adjustment_id);
      $('#reject_appr_num').val(appr_num);

    })

















    $('.btn_fast_reject').click(function(e) {
      e.stopPropagation();
      var adjustment_id = $(this).attr('adjustment_id');
      var appr_num = $(this).attr('appr_num');

      $('#reject_adjustment_id').val(adjustment_id);
      $('#reject_appr_num').val(appr_num);

      $('#modal_adjustment_rejection_reason').modal('toggle');

    })

    $('.btn_fast_approve').click(function(e) {
      e.stopPropagation();
      var employee_id = $(this).attr('employee_id');
      var adjustment_id = $(this).attr('adjustment_id');
      var appr_num = $(this).attr('appr_num');

      Swal.fire({
        title: 'Approve this time adjustment application?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url(); ?>approval/approve_time_adjustment?employee_id=" + employee_id + '&adjustment_id=' + adjustment_id + '&appr_num=' + appr_num;
        }
      })

    })









    $('#check_all_appr_1').click(function(e) {
      var label = $(this).text();
      console.log(label);

      var ischecked = false;
      if (label == 'Check All') {
        ischecked = true;
        $(this).text('Uncheck All');
      } else {
        ischecked = false;
        $(this).text('Check All');
      }

      Array.from($('.selected_application_appr_1')).forEach(function(checkbox) {

        $(checkbox).prop('checked', ischecked);
      })
    })







    $('#check_all_appr_2').click(function(e) {
      var label = $(this).text();
      console.log(label);

      var ischecked = false;
      if (label == 'Check All') {
        ischecked = true;
        $(this).text('Uncheck All');
      } else {
        ischecked = false;
        $(this).text('Check All');
      }

      Array.from($('.selected_application_appr_2')).forEach(function(checkbox) {

        $(checkbox).prop('checked', ischecked);
      })
    })




    $('#approve_all').click(function() {
      $('#form_approve_all').html('');

      if ($('.selected_application:checked').length > 0) {
        Array.from($('.selected_application:checked')).forEach(function(e) {
          var appr_num = $(e).attr('appr_num');
          var employee_id = $(e).attr('employee_id')
          var adjustment_id = $(e).attr('adjustment_id');

          var appr_details_compressed = appr_num + '/' + employee_id + '/' + adjustment_id;

          $('#form_approve_all').append(`
            <input name="appl_details_compressed[]" value="` + appr_details_compressed + `">
          `)
        })
      }

      Swal.fire({
        title: 'Approve this overtime application?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#form_approve_all').submit();
        }
      })
    })



















    $('#reject_all').click(function(e) {
      $('#form_reject_all').html('');

      if ($('.selected_application:checked').length > 0) {
        Array.from($('.selected_application:checked')).forEach(function(e) {
          var appr_num = $(e).attr('appr_num');
          var adjustment_id = $(e).attr('adjustment_id');

          var appr_details_compressed = appr_num + '/' + adjustment_id;

          $('#form_reject_all').append(`
            <input name="appl_details_compressed[]" value="` + appr_details_compressed + `">
          `)
        })
      }

      Swal.fire({
        title: 'Reject these overtime applications?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#form_reject_all').submit();
        }
      })

    })







    async function get_time_adjustment_data(url, employee_id, adjustment_id) {
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