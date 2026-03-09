<!------------------------------------------------------ A. PAGE INFORMATION  -----------------------------------------------------
TECHNOS SYSTEM ENGINEERING INC.
EyeBox HRMS
@author     Technos Developers
@datetime   15 November 2022
@purpose    Leaves
CONTROLLER FILES:
MODEL FILES:
----------------------------------------------------------- A. STYLESHEETS  ----------------------------------------------------->
<html>
<?php $this->load->view('templates/css_link'); ?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<?php
//get the url
$url_count = $this->uri->total_segments();
$url_directory = $this->uri->segment($url_count);
?>
<body>
  <!-- Content Starts -->
  <div class="content-wrapper">
    <div class="container-fluid p-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
      <li class="breadcrumb-item">
          <a href="<?= base_url() ?>leaves">Leave</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">Leave</li>
    </ol>
    </nav>
      <div class="row">
        <!-- Title Text -->
        <div class="col-md-6">
          <h1 class="page-title">Leave</h1>
        </div>
        <!-- Title Button -->
        <div class="col-md-6" style="text-align: right;">
          <a href="#" class="btn btn-primary shadow-none" id="btn_export"><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a>
          <a href="#" class="btn btn-primary shadow-none" data-toggle="modal" data-target="#modal_assign_leave"><i class="fas fa-plus"></i> Assign Leave</a>
        </div>
      </div>
      <!-- Title Header Line -->
      <hr>
      <div class="row">
        <div class="col-md-3">
          <label for="filter_employee">Filter by Employees</label>
          <select name="filter_employee" id="filter_employee" class="form-control">
            <option value="">All Employees</option>
            <?php
            if ($DISP_ALL_EMPLOYEES) {
              foreach ($DISP_ALL_EMPLOYEES as $DISP_ALL_EMPLOYEES_ROW) {
            ?>
                <option value="<?= $DISP_ALL_EMPLOYEES_ROW->id ?>"><?= $DISP_ALL_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_ALL_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_ALL_EMPLOYEES_ROW->col_last_name ?></option>
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
            if ($DISP_ALL_CUTOFF_PERIOD) {
              foreach ($DISP_ALL_CUTOFF_PERIOD as $DISP_ALL_CUTOFF_PERIOD_ROW) {
            ?>
                <option value="<?= $DISP_ALL_CUTOFF_PERIOD_ROW->id ?>"> <?= $DISP_ALL_CUTOFF_PERIOD_ROW->name ?></option>
            <?php
              }
            }
            ?>
          </select>
        </div>
      </div>
      <br>
      <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">
        <table class="table table-hover" id="TableToExport">
          <thead>
            <th>Application&nbsp;ID</th>
            <th>Application&nbsp;Date</th>
            <th>Leave&nbsp;Date</th>
            <th>Assigned By</th>
            <th>Employee</th>
            <th>Leave Type</th>
            <th>Reason</th>
            <th>Duration&nbsp;(Day/s)</th>
            <th>Status <br> (Approver 1)</th>
            <th>Status <br> (Approver 2)</th>
            <th>Status <br> (Approver 3)</th>
            <th>Comment</th>
          </thead>
          <tbody id="tbl_application_container">
            <?php

            if ($C_LEAVE_LIST) {
              // echo "<pre>";
              // var_dump($C_LEAVE_LIST);
              // 	// var_dump($C_LEAVE_LIST[0]["employee"][0]);
              // echo "</pre>";
              // return;
              foreach ($C_LEAVE_LIST as $C_LEAVE_LIST_ROW) { ?>
                
                <tr class="view_leave_details" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" employee_id="<?= $C_LEAVE_LIST_ROW["employee"][0]->id ?>" leave_id="<?= $C_LEAVE_LIST_ROW["leave_id"] ?>">
                  <td><?= $C_LEAVE_LIST_ROW["application_id"] ?></td>
                  <td><?= $C_LEAVE_LIST_ROW["application_date"] ?></td>
                  <td><?= $C_LEAVE_LIST_ROW["date_from"] ?></td>
                  <td>
                    <a href="<?= base_url()?>employees/personal?id=<?= $C_LEAVE_LIST_ROW["assigned_by"][0]->id ?>">
                      <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($C_LEAVE_LIST_ROW["assigned_by"][0]->col_imag_path) {
                                                                                        echo base_url() . 'assets_user/user_profile/' . $C_LEAVE_LIST_ROW["assigned_by"][0]->col_imag_path;
                                                                                      } else {
                                                                                        echo base_url() . 'assets_system/images/default_user.jpg';
                                                                                      } ?>">&nbsp;&nbsp;<?= $C_LEAVE_LIST_ROW["assigned_by"][0]->col_last_name . ', ' . $C_LEAVE_LIST_ROW["assigned_by"][0]->col_frst_name . ' ' .$C_LEAVE_LIST_ROW["midl_ini"] ?>
                    </a>
                  </td>
                  <td>
                    <a href="<?= base_url() ?>employees/personal?id=<?= $C_LEAVE_LIST_ROW["employee"][0]->id ?>">
                      <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($C_LEAVE_LIST_ROW["employee"][0]->col_imag_path) {
                                                                                        echo base_url() . 'assets_user/user_profile/' . $C_LEAVE_LIST_ROW["employee"][0]->col_imag_path;
                                                                                      } else {
                                                                                        echo base_url() . 'assets_system/images/default_user.jpg';
                                                                                      } ?>">&nbsp;&nbsp;<?= $C_LEAVE_LIST_ROW["employee"][0]->col_last_name . ', ' . $C_LEAVE_LIST_ROW["employee"][0]->col_frst_name . ' ' .$C_LEAVE_LIST_ROW["midl_ini2"]  ?>
                    </a>
                  </td>
                  <td><?= $C_LEAVE_LIST_ROW["leave_type"] ?></td>
                  <td style="word-break: break-word;"><?php if ($C_LEAVE_LIST_ROW["isEdited_reason"] == 1) {
                                                        echo '<span class="text-success text-bold">(Edited)</span><br>';
                                                      } ?><?=$C_LEAVE_LIST_ROW["leave_comment"] ?></td>
                  <td><?php if ($C_LEAVE_LIST_ROW["isEdited_duration"] == 1) {
                        echo '<span class="text-success text-bold">(Edited)</span><br>';
                      } ?><?= number_format($C_LEAVE_LIST_ROW["leave_duration"], 2, '.', ""); ?></td>
                  <td><?= $C_LEAVE_LIST_ROW["leave_status1"]?></td>
                  <td><?= $C_LEAVE_LIST_ROW["leave_status2"]?></td>
                  <td><?= $C_LEAVE_LIST_ROW["leave_status3"] ?></td>
                  <td><?= $C_LEAVE_LIST_ROW["reason_rejected"] ?></td>
                </tr>
              <?php
              }
            } else {
              ?>
              <tr>
                <td colspan="12" class="p-4">No leave application from your supervisory yet</td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
        <!-- Pagination -->
        <right>
        <ul id="btn_pagination" class="pagination mr-auto ml-auto"> </ul>
      </right>
    </div>
    <!-- flex-fill -->
  </div>
  <!-- p-3 -->
  <!-- content-wrapper -->
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
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
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-5">
          <div class="row mb-2">
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
              <form action="<?php echo base_url(); ?>leaves/insrt_assign_leave" id="assign_leave_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
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
                      ?>
                        <option value="<?= $DISP_EMPL_INFO_ROW->id ?>"><?= $DISP_EMPL_INFO_ROW->col_empl_cmid . ' - ' . $DISP_EMPL_INFO_ROW->col_frst_name . ' ' . $DISP_EMPL_INFO_ROW->col_last_name ?></option>
                      <?php
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
                      ?>
                        <option value="<?= $DISP_EMPL_INFO_ROW->id ?>"><?= $DISP_EMPL_INFO_ROW->col_empl_cmid . ' - ' . $DISP_EMPL_INFO_ROW->col_frst_name . ' ' . $DISP_EMPL_INFO_ROW->col_last_name ?></option>
                      <?php
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
        <form action="<?php echo base_url(); ?>leaves/updt_leave_details" id="form_updt_leave" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
          <div class="modal-body pb-5">
            <div class="row">
              <div class="col-md-12">
                <!-- <div class="w-100 text-center pt-4">
                  <img id="modal_employee_img" class="rounded-circle" alt="" style="width: 150px; height: 150px;">
                </div> -->
                  <!-- <p class="text-bold mb-1">Name:</p>
                  <p class="mb-4" id="employee_name"></p> -->
                  <div class="form-group">
                    <label class="required" for="employee_name">Employee
                    </label>
                    <input type="text" class="form-control" name="employee_name" id="employee_name" disabled>
                  </div>
                  <div class="form-group">
                    <label class="required" for="employee_position">Position:
                    </label>
                    <input type="text" class="form-control" name="employee_position" id="employee_position" disabled>
                  </div>
                  <div class="form-group">
                    <label class="required" for="employee_department">Department:
                    </label>
                    <input type="text" class="form-control" name="employee_department" id="employee_department" disabled>
                  </div>
                  <div class="form-group">
                    <label class="required" for="leave_date_requested">Date Requested:
                    </label>
                    <input type="date" class="form-control" name="leave_date_requested" id="leave_date_requested" required>
                  </div>
                  <div class="form-group">
                    <label class="required" for="leave_on_date">Request Leave On:
                    </label>
                    <input type="date" class="form-control" name="leave_on_date" id="leave_on_date" required>
                  </div>
                  <div class="form-group">
                    <label class="required" for="leave_type">Leave Type:
                    </label>
                    <select class="form-control" name="leave_type" id="leave_type">
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
                    <label class="required" for="edit_leave_reason">Reason:
                    </label>
                    <input type="text" class="form-control" name="edit_leave_reason" id="edit_leave_reason" required>
                  </div>
                  <div class="form-group">
                    <label class="required" for="edit_leave_duration">Duration:
                    </label>
                    <input type="number" class="form-control" name="edit_leave_duration" id="edit_leave_duration" required>
                  </div>
                    <!-- <p class="text-bold mb-1">Reason:</p>
                    <p class="mb-4" id="leave_reason"></p>
                    <input style="display: none;" type="text" name="leave_reason" id="edit_leave_reason" class="form-control mb-4" placeholder="Enter Reason">
                    <p class="text-bold mb-1">Duration:</p>
                    <p class="mb-4" id="leave_duration"></p>
                    <input style="display: none;" type="number" step="0.25" name="leave_duration" id="edit_leave_duration" class="form-control mb-4" placeholder="Enter Duration">
                     -->
                    <div class="form-group">
                      <label class="required" for="leave_status">Status:
                      </label>
                      <input type="text" class="form-control" name="leave_status" id="leave_status" disabled>
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
          <div class="modal-footer">
            <!-- <input type="hidden" name="input_leave_reason" id="input_leave_reason">
            <input type="hidden" name="input_leave_duration" id="input_leave_duration"> -->
            <input type="hidden" name="row_id" id="row_id">
            <!-- <a class="btn btn-primary text-white" id="btn_edit">Edit</a> -->
            <button class="btn btn-primary text-white" id="btn_save" >Save</button>
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
          <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout
          </a>
        </div>
      </div>
    </div>
  </div>
  <!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->
  <?php $this->load->view('templates/jquery_link'); ?>
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
      var url_get_application_data = '<?= base_url() ?>leave/get_application_data';
      var url_get_all_ampl_data = '<?= base_url() ?>leave/get_all_ampl_data';
      var base_url = '<?= base_url() ?>';
      function fasterPreview1(uploader) {
        if (uploader.files && uploader.files[0]) {
          $('.custom-file-label').text(uploader.files[0].name);
        }
      }
      $("#INSRT_LEAVE_FILE").change(function() {
        fasterPreview1(this);
      });
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
        // $('#btn_edit').show();
        var base_url = '<?= base_url() ?>';
        var url = '<?= base_url() ?>leave/get_leave_data';
        var leave_id = $(this).attr('leave_id');
        var employee_id = $(this).attr('employee_id');
        get_leave_data(url, leave_id, employee_id).then(data => {
          data.leave_data.forEach((leaveData) => {
            $('#leave_date_requested').val(leaveData.col_date_created);
            if (!leaveData.col_leave_to) {
              $('#leave_on_date').val(leaveData.col_leave_from);
            } else {
              var leave_end = leaveData.col_leave_to.split(' ');
              $('#leave_on_date').val(leaveData.col_leave_from + ' to ' + leave_end[0]);
            }
            $('#leave_type').val(leaveData.col_leave_type);
            $('#leave_reason').val(leaveData.col_leave_comments);
            $('#leave_duration').text((parseFloat(leaveData.col_leave_duration)).toFixed(2) + " Day/s");
            $('#leave_status').val(leaveData.col_leave_status1);
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
            $('#edit_leave_reason').val(leaveData.col_leave_comments);
            $('#edit_leave_duration').val((parseFloat(leaveData.col_leave_duration)).toFixed(2));
            $('#row_id').val(leaveData.id);
          })
          data.employee_data.forEach((employeeData) => {
            $('#employee_name').val(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
            $('#employee_position').val(employeeData.col_empl_posi);
            $('#employee_department').val(employeeData.col_empl_dept);
            $('#modal_employee_img').attr('src', base_url + 'user_images/' + employeeData.col_imag_path);
          })
        })
      })
      $('#btn_edit').click(function() {
        var leave_reason = $('#leave_reason').html();
        var leave_duration = $('#leave_duration').html();
        var split_leave_duration = leave_duration.split(' ');
        leave_duration = split_leave_duration[0];
        $('#input_leave_reason').val(leave_reason);
        $('#input_leave_duration').val(leave_duration);
        $('#edit_leave_reason').show();
        $('#edit_leave_duration').show();
        $('#leave_reason').hide();
        $('#leave_duration').hide();
        $('#btn_save').prop('disabled', false);
        $('#btn_edit').hide();
      })
      $('#modal_leave_details').on('hide.bs.modal', function(e) {
        // $('#btn_save').prop('disabled', true);
        // $('#edit_leave_reason').hide();
        // $('#edit_leave_duration').hide();
        // $('#leave_reason').show();
        // $('#leave_duration').show();
        // $('#btn_edit').show();
      })
      var empl_id_arr = [];
      var empl_info_arr = [];
      get_all_ampl_data(url_get_all_ampl_data, 'test').then(function(data) {
        empl_info_arr = data;
        console.log(empl_info_arr);
      })
      function findObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
          if (array[i][key] === value) {
            return array[i];
          }
        }
        return null;
      }
      $('#filter_employee').change(function(e) {
        var cutoff_period = '';
        if ($('#filter_cutoff_period').val()) {
          cutoff_period = $('#filter_cutoff_period').val();
        }
        var empl_id = $(this).val();
        display_application_data(empl_id, cutoff_period);
      })
      $('#filter_cutoff_period').change(function(e) {
        var empl_id = '';
        if ($('#filter_employee').val()) {
          empl_id = $('#filter_employee').val();
        }
        var cutoff_period = $(this).val();
        display_application_data(empl_id, cutoff_period);
      })
      function display_application_data(empl_id, cutoff_period) {
        get_application_data(url_get_application_data, empl_id, cutoff_period).then(function(data) {
          $('#tbl_application_container').html('');
          Array.from(data).forEach(function(e) {
            var leave_id = 'LV' + (e.id).padStart(5, 0);
            var date_created = e.col_date_created;
            var leave_type = e.col_leave_type;
            var leave_from = moment(e.col_leave_from).format('MMMM D, YYYY');
            var leave_to = moment(e.col_leave_to).format('MMMM D, YYYY');
            var leave_duration = e.col_leave_duration;
            var status1 = e.col_leave_status1;
            var status2 = e.col_leave_status2;
            var status3 = e.col_leave_status3;
            var leave_comments = e.col_leave_comments;
            var leave_image = e.col_leave_image;
            var assigned_by = e.col_assigned_by;
            var empl_id = e.col_empl_id;
            var leave_balance = e.col_leave_balance;
            var reason_rejection = e.col_reason_rejection;
            var isEdited_reason = e.isEdited_reason;
            var isEdited_duration = e.isEdited_duration;
            var empl_image = 'default_profile_img3.png';
            var empl_name = '';
            var empl_cmid = '';
            var empl_id = '';
            var empl_info = findObjectByKey(empl_info_arr, 'id', "" + e.col_empl_id + "");
            if (empl_info) {
              if (empl_info.col_imag_path) {
                empl_image = empl_info.col_imag_path;
              }
              if (empl_info.col_midl_name) {
                var midl_ini = empl_info.col_midl_name + '.';
              } else {
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
            var assigned_by_info = findObjectByKey(empl_info_arr, 'id', "" + e.col_assigned_by + "");
            if (assigned_by_info) {
              if (assigned_by_info.col_imag_path) {
                assigned_by_image = assigned_by_info.col_imag_path;
              }
              if (assigned_by_info.col_midl_name) {
                var midl_ini2 = assigned_by_info.col_midl_name + '.';
              } else {
                var midl_ini2 = '';
              }
              assigned_by_name = assigned_by_info.col_last_name + ', ' + assigned_by_info.col_frst_name + ' ' + midl_ini2;
              assigned_by_cmid = assigned_by_info.col_empl_cmid;
              assigned_by_id = assigned_by_info.id;
            }
            if (isEdited_reason == '1') {
              isEdited_reason = `<span class="text-success text-bold">(Edited)</span><br>`;
            }
            if (isEdited_duration == '1') {
              isEdited_duration = `<span class="text-success text-bold">(Edited)</span><br>`;
              leave_duration = (parseFloat(leave_duration)).toFixed(2);
            }
            console.log(empl_info_arr);
            $('#tbl_application_container').append(`
              <tr class="view_leave_details" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" employee_id="` + empl_id + `" leave_id="` + e.id + `">
                  <td>` + leave_id + `</td>
                  <td>` + date_created + `</td>
                  <td>` + leave_from + `</td>
                  <td>
                    <a href = "<?= base_url() ?>employees/personal?id=` + empl_id + `">
                        <img class="rounded-circle avatar " width="35" height="35" src="` + base_url + `user_images/` + empl_image + `">&nbsp;&nbsp;` + empl_name + `
                    </a>
                  </td>
                  <td>
                    <a href = "<?= base_url() ?>employees/personal?id=` + assigned_by_id + `">
                        <img class="rounded-circle avatar " width="35" height="35" src="` + base_url + `user_images/` + assigned_by_image + `">&nbsp;&nbsp;` + assigned_by_name + `
                    </a>
                  </td>
                  <td>` + leave_type + `</td>
                  <td style="word-break: break-word;">` + isEdited_reason + `` + leave_comments + `</td>
                  <td>` + isEdited_duration + `` + leave_duration + `</td>
                  <td>` + status1 + `</td>
                  <td>` + status2 + `</td>
                  <td>` + status3 + `</td>
                  <td>` + reason_rejection + `</td>
              </tr>
            `)
          })
        })
      }
      // ------------------------------ Pagination -------------------------------------
      // TECHNOS STANDARD: DO NOT CHANGE
      var row_count = $('#row_count').val();
      var page_count = $('#page_count').val();
      $('#btn_pagination').pagination();
      $('#btn_pagination').pagination({
        total: row_count, // the number of entries
        current: 1, // current page
        length: 10, // the number of entires per page
        size: 2, // pagination size
        prev: "&lt;", // Prev/Next text
        next: "&gt;",
        // fired on each click
        click: function(e) {
          $('#tbl_application_container').html('');
          var row_count = $('#row_count').val();
          var page_count = $('#page_count').val();
          // console.log(e.current);
          var page_num = e.current;
          var employee = $('#filter_employee').val();
          var cutoff_period = $('#filter_cutoff_period').val();
          get_overtime(url_get_overtime, employee, cutoff_period, page_num).then(function(data) {
            // console.log(data);
            Array.from(data).forEach(function(x) {
              var ot_id = 'OT' + (x.id).padStart(5, 0);
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
              var empl_info = findObjectByKey(empl_info_arr, 'id', "" + x.empl_id + "");
              if (empl_info) {
                if (empl_info.col_imag_path) {
                  empl_image = empl_info.col_imag_path;
                }
                if (empl_info.col_midl_name) {
                  var midl_ini = empl_info.col_midl_name + '.';
                } else {
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
              var assigned_by_info = findObjectByKey(empl_info_arr, 'id', "" + x.assigned_by + "");
              if (assigned_by_info) {
                if (assigned_by_info.col_imag_path) {
                  assigned_by_image = assigned_by_info.col_imag_path;
                }
                if (assigned_by_info.col_midl_name) {
                  var midl_ini2 = assigned_by_info.col_midl_name + '.';
                } else {
                  var midl_ini2 = '';
                }
                assigned_by_name = assigned_by_info.col_last_name + ', ' + assigned_by_info.col_frst_name + ' ' + midl_ini2;
                assigned_by_cmid = assigned_by_info.col_empl_cmid;
                assigned_by_id = assigned_by_info.id;
              }
              $('#tbl_application_container').append(`
                          <tr>
                              <td>` + ot_id + `</td>
                              <td>` + date_created + `</td>
                              <td>
                                  <a href = "<?= base_url() ?>employees/personal?id=` + empl_id + `">
                                      <img class="rounded-circle avatar " width="35" height="35" src="` + base_url + `user_images/` + empl_image + `">&nbsp;&nbsp;` + empl_name + `
                                  </a>
                              </td>
                              <td>
                                  <a href = "<?= base_url() ?>employees/personal?id=` + assigned_by_id + `">
                                      <img class="rounded-circle avatar " width="35" height="35" src="` + base_url + `user_images/` + assigned_by_image + `">&nbsp;&nbsp;` + assigned_by_name + `
                                  </a>
                              </td>
                              <td>` + date_ot + `</td>
                              <td>` + time_out + `</td>
                              <td>` + hours + `</td>
                              <td>` + reason + `</td>
                              <td>` + status1 + `</td>
                              <td>` + status2 + `</td>
                              <td>` + comment + `</td>
                          </tr>
                      `)
            })
          })
        }
      });
      async function get_all_ampl_data(url, empl_id) {
        var formData = new FormData();
        formData.append('empl_cmid', empl_id);
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
      async function get_application_data(url, empl_id, cutoff_period) {
        var formData = new FormData();
        formData.append('empl_id', empl_id);
        formData.append('cutoff_period', cutoff_period);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }
    })
  </script>
  <!-------------------- Export ----------------->
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script>
document.getElementById("btn_export").addEventListener('click', function() {
  /* Create worksheet from HTML DOM TABLE */
  var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
  /* Export to file (start a download) */
  XLSX.writeFile(wb, "Leave Tab - Leave.xlsx");
});
</script>
</body>
</html>