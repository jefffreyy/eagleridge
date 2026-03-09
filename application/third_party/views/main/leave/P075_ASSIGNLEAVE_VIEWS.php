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
  }

  label.required::after {
    content: " *";
    color: red;
  }
</style>

<?php
//get the url
$url_count = $this->uri->total_segments();
$url_directory = $this->uri->segment($url_count);

$user = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($this->session->userdata('SESS_USER_ID'));
$vacation_balance = $user[0]->col_leave_vacation;
$sick_balance = $user[0]->col_leave_sick;
$maternity_balance = $user[0]->col_leave_maternity;
$parental_balance = $user[0]->col_leave_parental;
$paternal_balance = $user[0]->col_leave_paternal;
//$rehabilitation_balance = $user[0]->col_leave_rehabilitation;
$service_incentive_balance = $user[0]->col_leave_service_incentive;
$solo_incentive = $user[0]->col_leave_solo_incentive;
?>

<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Pagination -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/bs-pagination.min.css">
<!-- Datatable -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row">
      <div class="col-md-6">
        <h1 class="page-title">Assign Leave</h1>
      </div>
      <div class="col-md-6">
        <a href="#" class="btn btn-primary float-right mt-2" data-toggle="modal" data-target="#modal_assign_leave">Assign Leave</a>
      </div>
    </div>
    <hr>
    <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">

      <table class="table table-hover table-xs mb-0">
        <thead>
          <th>Leave ID</th>
          <th>Application Date</th>
          <th>Date of Leave</th>
          <th>Assigned By</th>
          <th>Employee</th>
          <th>Leave Type</th>
          <th>Reason for leave</th>
          <th>Duration (Day/s)</th>
          <th>Status <br> (Approver 1)</th>
          <th>Status <br> (Approver 2)</th>
          <th>Status <br> (Approver 3)</th>
        </thead>
        <tbody id="tbl_application_container">
          <?php
          if ($DISP_ASSIGNED_LEAVE) {
            foreach ($DISP_ASSIGNED_LEAVE as $DISP_ASSIGNED_LEAVE_ROW) {
              $assigned_by_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_ASSIGNED_LEAVE_ROW->col_assigned_by);
              $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_ASSIGNED_LEAVE_ROW->col_empl_id);
              $db_date_from = $DISP_ASSIGNED_LEAVE_ROW->col_leave_from;
              $date_from = date('l F j, Y', strtotime($db_date_from));

              $application_id = 'LV' . str_pad($DISP_ASSIGNED_LEAVE_ROW->id, 5, '0', STR_PAD_LEFT);
              $application_date = $DISP_ASSIGNED_LEAVE_ROW->col_date_created;
              $application_date = date('l F j, Y', strtotime($application_date));

              $empl_group = 'No Group';
              if ($employee_id[0]->col_empl_group) {
                $empl_group = $employee_id[0]->col_empl_group;
              }

              $group_approver = $this->approval_route_mod->MOD_DISP_GROUP_APPROVERS($empl_group);

              // get approval route
              $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_LEAVE();

              // loop through the approval routes
              foreach ($approval_route as $approval_route_row) {
                // check if you are a approver then show the list of requests you can only approve
                $my_user_id = $this->session->userdata('SESS_USER_ID');
                // echo 'group approver: '.$group_approver[0]->approver1.'<br>';
                // echo 'group approver: '.$group_approver[0]->approver2.'<br>';
                // echo 'approval route: '.$approval_route_row->approver1.'<br>';
                // echo 'approval route: '.$approval_route_row->approver2.'<br>';
                // echo 'approval route: '.$approval_route_row->approver3.'<br>';
                // echo 'approval route: '.$approval_route_row->approver4.'<br>';
                // echo 'approval route: '.$approval_route_row->approver5.'<br>';
                // echo 'approval route: '.$approval_route_row->approver6.'<br>';
                // echo 'approval route: '.$approval_route_row->approver7.'<br>';
                if (($group_approver[0]->approver1 == $my_user_id) || ($group_approver[0]->approver2 == $my_user_id) || ($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id) || ($approval_route_row->approver7 == $my_user_id) || ($my_user_id = 999999)) {

                  if (!empty($assigned_by_id[0]->col_midl_name)) {
                    $midl_ini = $assigned_by_id[0]->col_midl_name[0] . '.';
                  } else {
                    $midl_ini = '';
                  }
                  if (!empty($employee_id[0]->col_midl_name)) {
                    $midl_ini2 = $employee_id[0]->col_midl_name[0] . '.';
                  } else {
                    $midl_ini2 = '';
                  }
          ?>
                  <tr class="view_leave_details" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" employee_id="<?= $DISP_ASSIGNED_LEAVE_ROW->col_empl_id ?>" leave_id="<?= $DISP_ASSIGNED_LEAVE_ROW->id ?>">
                    <td><?= $application_id ?></td>
                    <td><?= $application_date ?></td>
                    <td><?= $date_from ?></td>
                    <td>
                      <a style="text-transform: capitalize;" href="<?= base_url() ?>employees/personal?id=<?= $assigned_by_id[0]->id ?>">
                        <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($assigned_by_id[0]->col_imag_path) {
                                                                                          echo base_url() . 'user_images/' . $assigned_by_id[0]->col_imag_path;
                                                                                        } else {
                                                                                          echo base_url() . 'user_images/default_profile_img3.png';
                                                                                        } ?>">&nbsp;&nbsp;<?= strtolower($assigned_by_id[0]->col_last_name . ', ' . $assigned_by_id[0]->col_frst_name . ' ' . $midl_ini) ?>
                      </a>
                    </td>
                    <td>
                      <a style="text-transform: capitalize;" href="<?= base_url() ?>employees/personal?id=<?= $employee_id[0]->id ?>">
                        <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($employee_id[0]->col_imag_path) {
                                                                                          echo base_url() . 'user_images/' . $employee_id[0]->col_imag_path;
                                                                                        } else {
                                                                                          echo base_url() . 'user_images/default_profile_img3.png';
                                                                                        } ?>">&nbsp;&nbsp;<?= strtolower($employee_id[0]->col_last_name . ', ' . $employee_id[0]->col_frst_name . ' ' . $midl_ini2) ?>
                      </a>
                    </td>
                    <td><?= $DISP_ASSIGNED_LEAVE_ROW->col_leave_type ?></td>
                    <td style="word-break: break-word;"><?= $DISP_ASSIGNED_LEAVE_ROW->col_leave_comments ?></td>
                    <td><?= number_format($DISP_ASSIGNED_LEAVE_ROW->col_leave_duration, 2, '.', ""); ?></td>
                    <td><?= $DISP_ASSIGNED_LEAVE_ROW->col_leave_status1 ?></td>
                    <td><?= $DISP_ASSIGNED_LEAVE_ROW->col_leave_status2 ?></td>
                    <td><?= $DISP_ASSIGNED_LEAVE_ROW->col_leave_status3 ?></td>
                  </tr>
                <?php
                } else {
                ?>
                  <tr class="table-active">
                    <td colspan="11">
                      <center>No Applications Yet</center>
                    </td>
                  </tr>
            <?php
                  break 2;
                }
              }
            }
          } else {
            ?>
            <tr class="table-active">
              <td colspan="11">
                <center>No Applications Yet</center>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>

      <center>
        <ul id="btn_pagination" class="pagination mr-auto ml-auto"></ul>
      </center>

    </div>
  </div>
  <!-- flex-fill -->
</div>
<!-- p-3 -->
<!-- content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->


<!-- Apply Leave -->
<div class="modal fade" id="modal_assign_leave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title mt-0 ml-1">Assign Leave
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>



      <div class="modal-body pb-5">
        <div class="row mb-2 px-3">
          <div class="col-4">
            <div class="form-group w-100 float-left">
              <label>Vacation Leave</label>&nbsp;&nbsp;
              <span class="float-right" id="vacation_balance"></span>
            </div>
            <div class="form-group w-100 float-left">
              <label>Sick Leave</label>&nbsp;&nbsp;
              <span class="float-right" id="sick_balance"></span>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group w-100 float-left">
              <label>Parental Leave</label>&nbsp;&nbsp;
              <span class="float-right" id="parental_balance"></span>
            </div>
            <div class="form-group w-100 float-left">
              <label>Paternity Leave</label>&nbsp;&nbsp;
              <span class="float-right" id="paternal_balance"></span>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group w-100 float-left">
              <label>Service Incentive Leave</label>&nbsp;&nbsp;
              <span class="float-right" id="service_incentive_balance"></span>
            </div>
            <div class="form-group w-100 float-left">
              <label class="mb-0">Solo Incentive Leave:</label>&nbsp;&nbsp;
              <span class="float-right" id="solo_incentive_balance"></span>
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-12 text-center">
            <div class="form-group w-100 float-left">
              <label>Maternity Leave</label>&nbsp;&nbsp;
              <span id="maternity_balance"></span>
            </div>
          </div>
        </div>
        <hr>



        <div class="row">
          <div class="col-12">
            <form action="<?php echo base_url('leave/insrt_assign_leave'); ?>" id="assign_leave_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
              <div class="form-group clearfix my-4 text-center">
                <div class="icheck-primary d-inline">
                  <input type="radio" id="leave_single_day" value="leave_single_day" name="leave_class" checked>
                  <label class="radio_label" for="leave_single_day">
                    Single Entry
                  </label>
                </div>
                <div class="icheck-primary d-inline ml-4">
                  <input type="radio" id="leave_multiple_days" value="leave_multiple_days" name="leave_class">
                  <label class="radio_label" for="leave_multiple_days">
                    Multiple Entry
                  </label>
                </div>
              </div>



              <div id="single_leave">
                <div class="form-group">
                  <label class="required" for="INSRT_ASSIGN_TO">Assign to
                  </label>
                  <select class="form-control" name="INSRT_ASSIGN_TO" id="INSRT_ASSIGN_TO" required>
                    <option value="">Choose...</option>
                    <?php
                    foreach ($DISP_EMPL_INFO as $DISP_EMPL_INFO_ROW) {

                      $empl_group = 'No Group';
                      if ($DISP_EMPL_INFO_ROW->col_empl_group) {
                        $empl_group = $DISP_EMPL_INFO_ROW->col_empl_group;
                      }

                      $group_approver = $this->approval_route_mod->MOD_DISP_GROUP_APPROVERS($empl_group);

                      // get approval route
                      $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_LEAVE();


                      // loop through the approval routes
                      foreach ($approval_route as $approval_route_row) {
                        // check if you are a approver then show the list of requests you can only approve
                        $my_user_id = $this->session->userdata('SESS_USER_ID');
                        if (($group_approver[0]->approver1 == $my_user_id) || ($group_approver[0]->approver2 == $my_user_id) || ($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id) || ($approval_route_row->approver7 == $my_user_id) || ($my_user_id = 999999)) {
                          if (!empty($DISP_EMPL_INFO_ROW->col_midl_name)) {
                            $midl_ini = $DISP_EMPL_INFO_ROW->col_midl_name[0] . '.';
                          } else {
                            $midl_ini = '';
                          }
                    ?>
                          <option value="<?= $DISP_EMPL_INFO_ROW->id ?>"><?= $DISP_EMPL_INFO_ROW->col_empl_cmid . ' - ' . $DISP_EMPL_INFO_ROW->col_last_name . ', ' . $DISP_EMPL_INFO_ROW->col_frst_name . ' ' . $midl_ini ?></option>
                    <?php
                        }
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="required" for="INSRT_LEAVE_TYPE">Leave Type
                  </label>
                  <select class="form-control" name="INSRT_LEAVE_TYPE" id="INSRT_LEAVE_TYPE" required>
                    <option value="">Choose...</option>
                    <?php
                    foreach ($DISP_LEAVETYPES_INFO as $DISP_LEAVETYPES_INFO_ROW) {
                    ?>
                      <option value="<?= $DISP_LEAVETYPES_INFO_ROW->name ?>"><?= $DISP_LEAVETYPES_INFO_ROW->name ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="required" for="INSRT_LEAVE_DATE">Date
                  </label>
                  <input class="form-control" type="date" name="INSRT_LEAVE_DATE" id="INSRT_LEAVE_DATE" required>
                </div>
                <div class="form-group">
                  <label class="required" for="INSRT_LEAVE_DURATION">Duration
                  </label>
                  <input type="number" name="INSRT_LEAVE_DURATION" id="INSRT_LEAVE_DURATION" class="form-control" step="0.25" placeholder="Enter Duration (Days)">
                </div>
              </div>





              <div id="multiple_leave" style="display:none;">
                <div class="form-group">
                  <label class="required" for="INSRT_ASSIGN_TO_MULTIPLE">ASSIGN TO
                  </label>
                  <select class="form-control" name="INSRT_ASSIGN_TO_MULTIPLE" id="INSRT_ASSIGN_TO_MULTIPLE">
                    <option value="">Choose...</option>
                    <?php
                    foreach ($DISP_EMPL_INFO as $DISP_EMPL_INFO_ROW) {

                      $empl_group = 'No Group';
                      if ($DISP_EMPL_INFO_ROW->col_empl_group) {
                        $empl_group = $DISP_EMPL_INFO_ROW->col_empl_group;
                      }

                      $group_approver = $this->approval_route_mod->MOD_DISP_GROUP_APPROVERS($empl_group);

                      // get approval route
                      $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_LEAVE();


                      // loop through the approval routes
                      foreach ($approval_route as $approval_route_row) {
                        // check if you are a approver then show the list of requests you can only approve
                        $my_user_id = $this->session->userdata('SESS_USER_ID');
                        if (($group_approver[0]->approver1 == $my_user_id) || ($group_approver[0]->approver2 == $my_user_id) || ($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id) || ($approval_route_row->approver7 == $my_user_id)) {
                          if (!empty($DISP_EMPL_INFO_ROW->col_midl_name)) {
                            $midl_ini = $DISP_EMPL_INFO_ROW->col_midl_name[0] . '.';
                          } else {
                            $midl_ini = '';
                          }
                    ?>
                          <option value="<?= $DISP_EMPL_INFO_ROW->id ?>"><?= $DISP_EMPL_INFO_ROW->col_empl_cmid . ' - ' . $DISP_EMPL_INFO_ROW->col_last_name . ', ' . $DISP_EMPL_INFO_ROW->col_frst_name . ' ' . $midl_ini ?></option>
                    <?php
                        }
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="required" for="INSRT_LEAVE_TYPE_MULTIPLE">Leave Type
                  </label>
                  <select class="form-control" name="INSRT_LEAVE_TYPE_MULTIPLE" id="INSRT_LEAVE_TYPE_MULTIPLE">
                    <option value="">Choose...</option>
                    <?php
                    foreach ($DISP_LEAVETYPES_INFO as $DISP_LEAVETYPES_INFO_ROW) {
                    ?>
                      <option value="<?= $DISP_LEAVETYPES_INFO_ROW->name ?>"><?= $DISP_LEAVETYPES_INFO_ROW->name ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="required" for="INSRT_LEAVE_DATE_FROM">From Date
                      </label>
                      <input class="form-control" type="date" name="INSRT_LEAVE_DATE_FROM" id="INSRT_LEAVE_DATE_FROM">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="required" for="INSRT_LEAVE_DATE_TO">To Date
                      </label>
                      <input class="form-control" type="date" name="INSRT_LEAVE_DATE_TO" id="INSRT_LEAVE_DATE_TO">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="required" for="INSRT_LEAVE_DURATION_MULTIPLE">Duration (Days)
                  </label>
                  <input type="number" name="INSRT_LEAVE_DURATION_MULTIPLE" id="INSRT_LEAVE_DURATION_MULTIPLE" class="form-control">
                </div>
              </div>







              <div class="form-group">
                <label for="INSRT_LEAVE_COMMENT">Reason for Leave
                </label>
                <textarea class="form-control" name="INSRT_LEAVE_COMMENT" id="INSRT_LEAVE_COMMENT" cols="30" rows="5"></textarea>
              </div>
              <div class="form-group" id="leave_file" style="display: none;">
                <label for="INSRT_LEAVE_FILE">Medical Certificate &nbsp;&nbsp; <span class="text-muted">(Optional)</span>
                </label>
                <div class="row">
                  <div class="col-6">
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input fileficker" id="INSRT_LEAVE_FILE" name="INSRT_LEAVE_FILE" multiple="" accept=".jpg, .jpeg, .png">
                        <label class="custom-file-label" for="INSRT_LEAVE_FILE">Choose file</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 w-100">
                  <input type="hidden" name="url_directory" value="<?= $url_directory ?>">
                  <button class="btn btn-primary float-right" id="INSRT_LEAVE_BTN" type="submit">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

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
                  <p class="mb-4" id="leave_reason"></p>
                  <p class="text-bold mb-1">Duration:</p>
                  <p class="mb-4" id="leave_duration"></p>
                  <p class="text-bold mb-1">Status:</p>
                  <p class="mb-4" id="leave_status"></p>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-6">
                <p class="text-bold mb-1">Photo Attachments:</p>
                <a id="leave_attachment_link" target="_blank">
                  <img id="leave_attachment" alt="" style="width: 100px;cursor:pointer" class="w3-hover-opacity">
                </a>
                <p style="display:none" class="text-muted" id="empty_attachment">No photo attached</p>
              </div>
              <div class="col-md-6" id="reason_rejection">
                <p class="text-bold mb-1 text-danger">Reason for Rejection:</p>
                <p id="leave_rejection_comment"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
$page_count = $DISP_ROW_COUNT / 20;

if (($DISP_ROW_COUNT % 20) != 0) {
  $page_count = $page_count++;
}

$page_count = ceil($page_count);
?>

<input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT ?>">
<input type="hidden" id="page_count" value="<?= $page_count ?>">


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
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
<!-- Pagination -->
<script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>
<!-- Data table -->
<script src="<?= base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
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
if ($this->session->userdata('SESS_SUCC_MSG_DLT_APPLY_LEAVE')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_APPLY_LEAVE'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_DLT_APPLY_LEAVE');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_ASSIGN_LEAVE')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_ASSIGN_LEAVE'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_ASSIGN_LEAVE');
}
?>
<?php
if ($this->session->userdata('SESS_ERR_MSG_INSRT_ASSIGN_LEAVE')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_ASSIGN_LEAVE'); ?>',
      '',
      'warning'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_ERR_MSG_INSRT_ASSIGN_LEAVE');
}
?>
<script>
  $(document).ready(function() {

    // Check if leave is single day or multiple days (bulk)
    $('input[type=radio][name=leave_class]').change(function() {
      if (this.value == 'leave_single_day') {
        $('#single_leave').show(400);
        $('#multiple_leave').hide(400);

        // if single leave is checked, require all the fields under that div
        $('#INSRT_ASSIGN_TO').prop('required', true);
        $('#INSRT_LEAVE_TYPE').prop('required', true);
        $('#INSRT_LEAVE_DATE').prop('required', true);
        $('#INSRT_LEAVE_DURATION').prop('required', true);

        // if multpile leave is checked, require all the fields under that div
        $('#INSRT_ASSIGN_TO_MULTIPLE').prop('required', false);
        $('#INSRT_LEAVE_TYPE_MULTIPLE').prop('required', false);
        $('#INSRT_LEAVE_DATE_FROM').prop('required', false);
        $('#INSRT_LEAVE_DATE_TO').prop('required', false);
        $('#INSRT_LEAVE_DURATION_MULTIPLE').prop('required', false);
      } else if (this.value == 'leave_multiple_days') {
        $('#multiple_leave').show(400);
        $('#single_leave').hide(400);

        // if multpile leave is checked, require all the fields under that div
        $('#INSRT_ASSIGN_TO_MULTIPLE').prop('required', true);
        $('#INSRT_LEAVE_TYPE_MULTIPLE').prop('required', true);
        $('#INSRT_LEAVE_DATE_FROM').prop('required', true);
        $('#INSRT_LEAVE_DATE_TO').prop('required', true);
        $('#INSRT_LEAVE_DURATION_MULTIPLE').prop('required', true);

        // if single leave is checked, unrequire all the fields under that div
        $('#INSRT_ASSIGN_TO').prop('required', false);
        $('#INSRT_LEAVE_TYPE').prop('required', false);
        $('#INSRT_LEAVE_DATE').prop('required', false);
        $('#INSRT_LEAVE_DURATION').prop('required', false);

        $('#vacation_balance').html('0.00');
        $('#sick_balance').html('0.00');
        $('#maternity_balance').html('0.00');
        $('#parental_balance').html('0.00');
        $('#paternal_balance').html('0.00');
        $('#service_incentive_balance').html('0.00');
        $('#solo_incentive_balance').html('0.00');
      }
    });

    // Show file input when sick leave is chosen
    $('#INSRT_LEAVE_TYPE').change(function() {
      if ($('#INSRT_LEAVE_TYPE').val() == 'Sick Leave') {
        $('#leave_file').show(400);
      } else {
        $('#leave_file').hide(400);
      }
    })
    $('#INSRT_LEAVE_TYPE_MULTIPLE').change(function() {
      if ($('#INSRT_LEAVE_TYPE_MULTIPLE').val() == 'Sick Leave') {
        $('#leave_file').show(400);
      } else {
        $('#leave_file').hide(400);
      }
    })


    $('#INSRT_ASSIGN_TO').change(function() {
      var url = '<?php echo base_url(); ?>leave/getEmployeeData';
      var employee_id = $('#INSRT_ASSIGN_TO').val();

      getEmployeeData(url, employee_id).then(data => {
        if (data.length > 0) {
          data.forEach((x) => {
            document.getElementById('vacation_balance').innerHTML = (parseFloat(x.col_leave_vacation)).toFixed(2);
            document.getElementById('sick_balance').innerHTML = (parseFloat(x.col_leave_sick)).toFixed(2);
            document.getElementById('maternity_balance').innerHTML = (parseFloat(x.col_leave_maternity)).toFixed(2);
            document.getElementById('parental_balance').innerHTML = (parseFloat(x.col_leave_parental)).toFixed(2);
            document.getElementById('paternal_balance').innerHTML = (parseFloat(x.col_leave_paternal)).toFixed(2);
            document.getElementById('service_incentive_balance').innerHTML = (parseFloat(x.col_leave_service_incentive)).toFixed(2);
            document.getElementById('solo_incentive_balance').innerHTML = (parseFloat(x.col_leave_solo_incentive)).toFixed(2);
          });
        }
      });
    })

    $('#INSRT_ASSIGN_TO_MULTIPLE').change(function() {
      var url = '<?php echo base_url(); ?>leave/getEmployeeData';
      var employee_id = $('#INSRT_ASSIGN_TO_MULTIPLE').val();

      getEmployeeData(url, employee_id).then(data => {
        if (data.length > 0) {
          data.forEach((x) => {
            document.getElementById('vacation_balance').innerHTML = (parseFloat(x.col_leave_vacation)).toFixed(2);
            document.getElementById('sick_balance').innerHTML = (parseFloat(x.col_leave_sick)).toFixed(2);
            document.getElementById('maternity_balance').innerHTML = (parseFloat(x.col_leave_maternity)).toFixed(2);
            document.getElementById('parental_balance').innerHTML = (parseFloat(x.col_leave_parental)).toFixed(2);
            document.getElementById('paternal_balance').innerHTML = (parseFloat(x.col_leave_paternal)).toFixed(2);
            document.getElementById('service_incentive_balance').innerHTML = (parseFloat(x.col_leave_service_incentive)).toFixed(2);
            document.getElementById('solo_incentive_balance').innerHTML = (parseFloat(x.col_leave_solo_incentive)).toFixed(2);
          });
        }
      });
    })


    $('.view_leave_details').click(function() {
      var base_url = '<?= base_url() ?>';
      var url = '<?= base_url() ?>leave/get_leave_data';
      var leave_id = $(this).attr('leave_id');
      var employee_id = $(this).attr('employee_id');

      get_leave_data(url, leave_id, employee_id).then(data => {
        data.leave_data.forEach((leaveData) => {
          $('#leave_date_requested').text(leaveData.col_date_created);
          if (!leaveData.col_leave_to) {
            $('#leave_on_date').text(leaveData.col_leave_from);
          } else {
            var leave_end = leaveData.col_leave_to.split(' ');
            $('#leave_on_date').text(leaveData.col_leave_from + ' to ' + leave_end[0]);
          }

          $('#leave_type').text(leaveData.col_leave_type);
          $('#leave_reason').text(leaveData.col_leave_comments);
          $('#leave_duration').text((parseFloat(leaveData.col_leave_duration)).toFixed(2) + " Day/s");
          $('#leave_status').text(leaveData.col_leave_status1);
          if (leaveData.col_leave_image) {
            $('#empty_attachment').hide();
            $('#leave_attachment').attr('src', base_url + 'assets/files/leave/' + leaveData.col_leave_image);
          } else {
            $('#empty_attachment').show();
            $('#leave_attachment').attr('src', '');
          }
          $('#leave_attachment_link').attr('href', base_url + 'assets/files/leave/' + leaveData.col_leave_image);

          if (leaveData.col_reason_rejection) {
            $('#reason_rejection').show();
            $('#leave_rejection_comment').text(leaveData.col_reason_rejection);
          } else {
            $('#leave_rejection_comment').text('');
            $('#reason_rejection').hide();
          }
        })

        data.employee_data.forEach((employeeData) => {
          $('#employee_name').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
          $('#employee_position').text(employeeData.col_empl_posi);
          $('#employee_department').text(employeeData.col_empl_dept);
          console.log(employeeData.col_imag_path);

          if (employeeData.col_imag_path) {
            $('#modal_employee_img').attr('src', base_url + 'user_images/' + employeeData.col_imag_path);
          } else {
            $('#modal_employee_img').attr('src', base_url + 'user_images/' + 'default_profile_img3.png');
          }

        })

      })
    })




    var url_get_assign_leave = '<?= base_url() ?>leave/get_assign_leave';
    var url_get_assign_by = '<?= base_url() ?>leave/getEmployeeData';
    var url_get_employee_by = '<?= base_url() ?>leave/getEmployeeData';
    var url_get_assign_group = '<?= base_url() ?>leave/get_assign_group';
    var url_get_approval_route = '<?= base_url() ?>leave/get_approval_route';
    $('#btn_pagination').pagination();

    var row_count = $('#row_count').val();
    var page_count = $('#page_count').val();

    $('#btn_pagination').pagination({

      // the number of entries
      total: row_count,

      // current page
      current: 1,

      // the number of entires per page
      length: 20,

      // pagination size
      size: 2,

      // Prev/Next text
      prev: "&lt;",
      next: "&gt;",

      // fired on each click
      click: function(e) {
        $('#tbl_application_container').html('');

        var row_count = $('#row_count').val();
        var page_count = $('#page_count').val();
        // console.log(e.current);
        var page_num = e.current;

        // console.log(page_num);

        get_assign_leave(url_get_assign_leave, page_num).then(function(data) {
          Array.from(data).forEach(function(e) {
            var assign_id = e.col_assigned_by;

            get_assign_by(url_get_assign_by, assign_id).then(function(assign_by) {
              Array.from(assign_by).forEach(function(assign_by) {
                var assign_by_id = assign_by.id;
                if (assign_by.col_imag_path) {
                  var assign_by_img_path = `<?= base_url() ?>user_images/` + assign_by.col_imag_path + ``;
                } else {
                  var assign_by_img_path = `<?= base_url() ?>user_images/default_profile_img3.png`;
                }
                if (assign_by.col_midl_name) {
                  var assign_by_name = assign_by.col_last_name + ', ' + assign_by.col_frst_name + ' ' + assign_by.col_midl_name[0] + '.';
                } else {
                  var assign_by_name = assign_by.col_last_name + ', ' + assign_by.col_frst_name;
                }

                var emplo_id = e.col_empl_id;
                get_employee_by(url_get_employee_by, emplo_id).then(function(employee_by) {
                  Array.from(employee_by).forEach(function(employee_by) {
                    var employee_by_id = employee_by.id;
                    if (employee_by.col_imag_path) {
                      var employee_by_img_path = `<?= base_url() ?>user_images/` + employee_by.col_imag_path + ``;
                    } else {
                      var employee_by_img_path = `<?= base_url() ?>user_images/default_profile_img3.png`;
                    }
                    if (employee_by.col_midl_name) {
                      var employee_by_name = employee_by.col_last_name + ', ' + employee_by.col_frst_name + ' ' + employee_by.col_midl_name[0] + '.';
                    } else {
                      var employee_by_name = employee_by.col_last_name + ', ' + employee_by.col_frst_name;
                    }

                    var empl_group = 'No Group';
                    if (e.col_empl_group) {
                      var empl_group = e.col_empl_group;
                    }
                    get_assign_group(url_get_assign_group, empl_group).then(function(assign_group) {
                      Array.from(assign_group).forEach(function(assign_group) {
                        var my_user_id = `<?= $this->session->userdata('SESS_USER_ID') ?>`;

                        get_approval_route(url_get_approval_route).then(function(approval_route) {
                          Array.from(approval_route).forEach(function(approval_route) {
                            if ((assign_group.approver1 == my_user_id) || (assign_group.approver2 == my_user_id) || (approval_route.approver1 == my_user_id) || (approval_route.approver2 == my_user_id) || (approval_route.approver3 == my_user_id) || (approval_route.approver4 == my_user_id) || (approval_route.approver5 == my_user_id) || (approval_route.approver6 == my_user_id) || (approval_route.approver7 == my_user_id) || (my_user_id == 999999)) {
                              var application_id = 'LV' + (e.id).padStart(5, 0);
                              var leave_duration = Number(e.col_leave_duration).toFixed(2);
                              var application_date = new Date(e.col_date_created).toLocaleDateString('en-us', {
                                weekday: "long",
                                year: "numeric",
                                month: "short",
                                day: "numeric"
                              });
                              var date_from = new Date(e.col_leave_from).toLocaleDateString('en-us', {
                                weekday: "long",
                                year: "numeric",
                                month: "short",
                                day: "numeric"
                              });
                              $('#tbl_application_container').append(`
                                      <tr class="view_leave_details" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" employee_id="` + e.col_empl_id + `" leave_id="` + e.id + `">
                                          <td>` + application_id + `</td>
                                          <td>` + application_date + `</td>
                                          <td>` + date_from + `</td>
                                          <td>
                                            <a style="text-transform: capitalize;" href = "<?= base_url() ?>employees/personal?id=` + assign_by_id + `">
                                              <img class="rounded-circle avatar " width="35" height="35" src="` + assign_by_img_path + `">&nbsp;&nbsp;` + assign_by_name.toLowerCase() + `
                                            </a>
                                          </td>
                                          <td>
                                            <a style="text-transform: capitalize;" href = "<?= base_url() ?>employees/personal?id=` + employee_by_id + `">
                                              <img class="rounded-circle avatar " width="35" height="35" src="` + employee_by_img_path + `">&nbsp;&nbsp;` + employee_by_name.toLowerCase() + `
                                            </a>
                                          </td>
                                          <td>` + e.col_leave_type + `</td>
                                          <td style="word-break: break-word;">` + e.col_leave_comments + `</td>
                                          <td>` + leave_duration + `</td>
                                          <td>` + e.col_leave_status1 + `</td>
                                          <td>` + e.col_leave_status2 + `</td>
                                          <td>` + e.col_leave_status3 + `</td>
                                      </tr>
                                    `)
                            }
                          })
                        })
                      })
                    })
                  })
                })
              })
            })
          })
        })

      }
    });


    async function get_assign_leave(url, page_num) {
      var formData = new FormData();
      formData.append('page_num', page_num);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_assign_by(url, assign_id) {
      var formData = new FormData();
      formData.append('employee_id', assign_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_employee_by(url, emplo_id) {
      var formData = new FormData();
      formData.append('employee_id', emplo_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_assign_group(url, empl_group) {
      var formData = new FormData();
      formData.append('group', empl_group);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_approval_route(url) {
      var formData = new FormData();
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }





    async function getEmployeeData(url, employee_id) {
      var formData = new FormData();
      formData.append('employee_id', employee_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_leave_data(url, leave_id, employee_id) {
      var formData = new FormData();
      formData.append('leave_id', leave_id);
      formData.append('employee_id', employee_id);
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