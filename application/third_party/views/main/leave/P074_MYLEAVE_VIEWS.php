<!------------------------------------------------------ A. PAGE INFORMATION  -----------------------------------------------------
  
TECHNOS SYSTEM ENGINEERING INC.
EyeBox HRMS

@author     Technos Developers
@datetime   11 October 2022
@purpose    My Leave

CONTROLLER FILES:


MODEL FILES:
  p020_emplist_mod





----------------------------------------------------------- A. STYLESHEETS  ----------------------------------------------------->
<?php $this->load->view('templates/css_link'); ?>

<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<!-- Content Starts -->
<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row">

      <!-- Title Text -->
      <div class="col-md-6">
        <h1 class="page-title">My Leave</h1>
      </div>

      <!-- Title Button -->
      <div class="col-md-6 button-title">
        <a href="#" class="btn btn-primary shadow-none" id="btn_apply_leave" employee_id="<?= $this->session->userdata('SESS_USER_ID') ?>"><i class="fas fa-plus"></i> Leave Request</a>
      </div>

    </div>

    <!-- Title Header Line -->
    <hr>

    <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">
      <div class="row">
        <div class="col">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <!-- Table Headers -->
                <th>Leave&nbsp;ID</th>
                <th>Application&nbsp;Date</th>
                <th>Leave&nbsp;Date</th>
                <th>Employee&nbsp;</th>
                <th>Type&nbsp;</th>
                <th>Reason&nbsp;</th>
                <th>Duration&nbsp;(day/s)</th>
                <th>Status&nbsp;</th>
                <th>Acknowledgement&nbsp;</th>
              </thead>

              <!-- Table Information -->
              <tbody id="tbl_application_container">

                <?php
                if ($DISP_MY_LEAVES) {
                  foreach ($DISP_MY_LEAVES as $DISP_MY_LEAVES_ROW) {
                    $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_MY_LEAVES_ROW->col_empl_id);
                    $db_date_from = $DISP_MY_LEAVES_ROW->col_leave_from;
                    $date_from = date('l, F j, Y', strtotime($db_date_from));

                    $application_id = 'LV' . str_pad($DISP_MY_LEAVES_ROW->id, 5, '0', STR_PAD_LEFT);
                    $application_date = $DISP_MY_LEAVES_ROW->col_date_created;
                    $application_date = date('l, F j, Y', strtotime($application_date));

                    switch ($DISP_MY_LEAVES_ROW->col_leave_type) {
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
                      case 'Rehabilitation Leave':
                        $leave_balance = $employee_id[0]->col_leave_rehabilitation;
                        break;
                      case 'Service Incentive Leave':
                        $leave_balance = $employee_id[0]->col_leave_service_incentive;
                        break;
                      case 'Study Leave':
                        $leave_balance = $employee_id[0]->col_leave_study;
                        break;
                      default:
                        $leave_balance = '';
                    }
                ?>

                    <tr class="leave_row" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" employee_id="<?= $DISP_MY_LEAVES_ROW->col_empl_id ?>" leave_id="<?= $DISP_MY_LEAVES_ROW->id ?>">
                      <td><?= $application_id ?></td>
                      <td><?= $application_date ?></td>
                      <td><?= $date_from ?></td>
                      <td>
                        <a href="#">
                          <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($employee_id[0]->col_imag_path) {
                                                                                            echo base_url() . 'user_images/' . $employee_id[0]->col_imag_path;
                                                                                          } else {
                                                                                            echo base_url() . 'user_images/default_profile_img3.png';
                                                                                          } ?>">&nbsp;&nbsp;<?= $employee_id[0]->col_frst_name . ' ' . $employee_id[0]->col_last_name ?>
                        </a>
                      </td>
                      <td><?= $DISP_MY_LEAVES_ROW->col_leave_type ?></td>
                      <td style="word-break: break-word;"><?= $DISP_MY_LEAVES_ROW->col_leave_comments ?></td>
                      <td><?= number_format($DISP_MY_LEAVES_ROW->col_leave_duration, 2, '.', ""); ?></td>
                      <td>
                        <?php
                        if (($DISP_MY_LEAVES_ROW->col_leave_status1 == 'Rejected') || ($DISP_MY_LEAVES_ROW->col_leave_status2 == 'Rejected') || ($DISP_MY_LEAVES_ROW->col_leave_status3 == 'Rejected')) {
                          echo 'Rejected';
                        } else if (($DISP_MY_LEAVES_ROW->col_leave_status1 == 'Approved') && ($DISP_MY_LEAVES_ROW->col_leave_status2 == 'Approved') && ($DISP_MY_LEAVES_ROW->col_leave_status3 == 'Approved')) {
                          echo 'Approved';
                        } else {
                          echo 'Pending';
                        }
                        ?>
                      </td>

                      <td>
                        <?php
                        if (($DISP_MY_LEAVES_ROW->col_leave_status1 == 'Rejected') || ($DISP_MY_LEAVES_ROW->col_leave_status2 == 'Rejected') || ($DISP_MY_LEAVES_ROW->col_leave_status3 == 'Rejected')) {
                          echo 'Acknowledged';
                        } else if (($DISP_MY_LEAVES_ROW->col_leave_status1 == 'Approved') && ($DISP_MY_LEAVES_ROW->col_leave_status2 == 'Approved') && ($DISP_MY_LEAVES_ROW->col_leave_status3 == 'Approved')) {
                          echo 'Acknowledged';
                        }
                        ?>
                      </td>


                    </tr>
                  <?php
                  }
                } else {
                  ?>

                  <!-- Message if no entries -->
                  <tr class="table-active">
                    <td colspan="9">
                      <center>You haven't submitted any leave requests yet</center>
                    </td>
                  </tr>

                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> <!-- card border ends -->

    <!-- Pagination -->
    <right>
      <ul id="btn_pagination" class="pagination mr-auto ml-auto"> </ul>
    </right>

  </div>
</div> <!-- Content ends -->

<!------------------------------------------------------------- C. Data Pull  --------------------------------------------------------->
<?php
$url_count      = $this->uri->total_segments();
$url_directory  = $this->uri->segment($url_count);
$user           = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($this->session->userdata('SESS_USER_ID'));
$user_cmid      = $user[0]->col_empl_cmid;
$user_firstname = $user[0]->col_frst_name;
$user_lastname  = $user[0]->col_last_name;

$vacation_balance = '0';
$sick_balance = '0';
$maternity_balance = '0';
$paternal_balance = '0';
$parental_balance = '0';
$service_incentive_balance = '0';
$solo_incentive = '0';

if ($user[0]->col_leave_vacation) {
  $vacation_balance = $user[0]->col_leave_vacation;
}

if ($user[0]->col_leave_sick) {
  $sick_balance = $user[0]->col_leave_sick;
}

if ($user[0]->col_leave_maternity) {
  $maternity_balance = $user[0]->col_leave_maternity;
}

if ($user[0]->col_leave_paternal) {
  $paternal_balance = $user[0]->col_leave_paternal;
}


if ($user[0]->col_leave_parental) {
  $parental_balance = $user[0]->col_leave_parental;
}


if ($user[0]->col_leave_service_incentive) {
  $service_incentive_balance = $user[0]->col_leave_service_incentive;
}


if ($user[0]->col_leave_solo_incentive) {
  $solo_incentive = $user[0]->col_leave_solo_incentive;
}
?>



<?php
$row_count = $DISP_ROW_COUNT[0]->ml_count;
$page_count = ceil($DISP_ROW_COUNT[0]->ml_count / 10);
?>


<input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT[0]->ml_count ?>">
<input type="hidden" id="page_count" value="<?= $page_count ?>">

<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->


<!------------------------------------------------------------- Modals  --------------------------------------------------------->
<!-- Logout Modal -->
<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        
      <!--Modal Header -->
      <div class="modal-header">
        <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;
          </span>
        </button>
      </div>
      
      <!--Modal Body -->
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

<!-- Apply Leave -->
<div class="modal fade" id="modal_apply_leave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <!--Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title mt-0 ml-1">Leave Request</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>

      <!--Modal Body -->
      <div class="modal-body pb-5">
        <div class="row mb-2 px-3">
          <div class="col-6">
            <div class="form-group w-100 float-left">
              <label>Vacation</label>&nbsp;&nbsp;
              <span class="float-right"><?= number_format($vacation_balance, 2, '.', ""); ?></span>
            </div>
            <div class="form-group w-100 float-left">
              <label>Sick</label>&nbsp;&nbsp;
              <span class="float-right"><?= number_format($sick_balance, 2, '.', ""); ?></span>
            </div>
            <div class="form-group w-100 float-left">
              <label>Maternity</label>&nbsp;&nbsp;
              <span class="float-right"><?= number_format($maternity_balance, 2, '.', ""); ?></span>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group w-100 float-left">
              <label>Parental</label>&nbsp;&nbsp;
              <span class="float-right"><?= number_format($parental_balance, 2, '.', ""); ?></span>
            </div>
            <div class="form-group w-100 float-left">
              <label>Paternity</label>&nbsp;&nbsp;
              <span class="float-right"><?= number_format($paternal_balance, 2, '.', ""); ?></span>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group w-100 float-left">
              <label>Service (SIL)</label>&nbsp;&nbsp;
              <span class="float-right"><?= number_format($service_incentive_balance, 2, '.', ""); ?></span>
            </div>
            <div class="form-group w-100 float-left">
              <label class="mb-0">Solo Parent</label>&nbsp;&nbsp;
              <span class="float-right"><?= number_format($solo_incentive, 2, '.', "");  ?></span>
            </div>
          </div>
        </div> <!-- row mb-2 px-3 ends -->

        <hr>

        <div class="row">
          <div class="col-12">
            <!-- Form starts -->
            <form action="<?php echo base_url('leave/insrt_apply_leave'); ?>" id="apply_leave_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">

              <!-- Leave Entry -->
              <div class="form-group clearfix my-4 text-center">
                <div class="icheck-primary d-inline">
                  <input type="radio" id="leave_single_day" value="leave_single_day" name="leave_class" checked>
                  <label class="radio_label" for="leave_single_day">Single Entry
                  </label>
                </div>
                <div class="icheck-primary d-inline ml-4">
                  <input type="radio" id="leave_multiple_days" value="leave_multiple_days" name="leave_class">
                  <label class="radio_label" for="leave_multiple_days">Multiple Entry
                  </label>
                </div>
              </div>

              <!-- Employee Single Leave -->
              <div id="single_leave">
                <div class="form-group">
                  <label class="required" for="EMPLOYEE">Employee
                  </label>
                  <select class="form-control" name="EMPLOYEE" id="EMPLOYEE" disabled>
                    <option value=""><?= $user_cmid . ' - ' . $user_firstname . ' ' . $user_lastname ?></option>
                  </select>
                </div>

                <!-- Leave Type -->
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

                <!-- Leave Date -->
                <div class="form-group">
                  <label class="required" for="INSRT_LEAVE_DATE">Date
                  </label>
                  <input class="form-control" type="date" name="INSRT_LEAVE_DATE" id="INSRT_LEAVE_DATE" required>
                </div>

                <!-- Leave Duration -->
                <div class="form-group">
                  <label class="required" for="INSRT_LEAVE_DURATION">Duration
                  </label>
                  <input type="number" name="INSRT_LEAVE_DURATION" id="INSRT_LEAVE_DURATION" class="form-control" step="0.25" placeholder="Enter Duration (Days)" required>
                  <!-- <select class="form-control" name="INSRT_LEAVE_DURATION" id="INSRT_LEAVE_DURATION">
                    <option value="">Choose...</option>
                    <option value="0.5">Half Day</option>
                    <option value="1">Full Day</option>
                  </select> -->
                </div>

              </div><!-- Employee Single Leave ends-->

              <!-- Employee multiple leave (DISPLAY NONE) -->
              <div id="multiple_leave" style="display:none;">

                <!-- Employee -->
                <div class="form-group">
                  <label class="required" for="INSRT_LEAVE_TYPE">Employee
                  </label>
                  <select class="form-control" name="INSRT_LEAVE_TYPE" id="INSRT_LEAVE_TYPE" disabled>
                    <option value=""><?= $user_cmid . ' - ' . $user_firstname . ' ' . $user_lastname ?></option>
                  </select>
                </div>

                <!-- Leave Type  -->
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

                <!-- Insert Date -->
                <div class="row">
                  <!-- From date -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="required" for="INSRT_LEAVE_DATE_FROM">From Date
                      </label>
                      <input class="form-control" type="date" name="INSRT_LEAVE_DATE_FROM" id="INSRT_LEAVE_DATE_FROM">
                    </div>
                  </div>
                  <!-- To Date -->
                  <div class="col-md-6">
                    <div class="form-group" style="display:none;">
                      <label class="required" for="INSRT_LEAVE_DATE_TO">To Date
                      </label>
                      <input class="form-control" type="date" name="INSRT_LEAVE_DATE_TO" id="INSRT_LEAVE_DATE_TO">
                    </div>
                  </div>
                </div> <!-- Insert Date ends-->

                <!-- Duration -->
                <div class="form-group">
                  <label class="required" for="INSRT_LEAVE_DURATION_MULTIPLE">Duration (Days)
                  </label>
                  <input type="number" name="INSRT_LEAVE_DURATION_MULTIPLE" id="INSRT_LEAVE_DURATION_MULTIPLE" class="form-control">
                </div>

              </div> <!-- Employee multiple leave ends (DISPLAY NONE) -->

              <!-- Insert Reason -->
              <div class="form-group">
                <label for="INSRT_LEAVE_TO_DATE">Reason for Leave
                </label>
                <textarea class="form-control" name="INSRT_LEAVE_COMMENT" id="INSRT_LEAVE_COMMENT" cols="30" rows="5"></textarea>
              </div>

              <!-- Insert Leave File (DISPLAY NONE)-->
              <div class="form-group" id="leave_file" style="display: none;">
                <label for="INSRT_LEAVE_FILE">Medical Certificate &nbsp;&nbsp; <span class="text-muted">(Optional)</span>
                </label>
                <div class="row">
                  <div class="col-6">
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input fileficker" id="INSRT_LEAVE_FILE" name="INSRT_LEAVE_FILE" multiple="" accept=".jpg, .jpeg, .png">
                        <label class="custom-file-label" for="INSRT_LEAVE_FILE">Choose file
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Imployee Id -->
              <div class="row">
                <div class="col-12 w-100">
                  <input type="hidden" name="EMPL_ID" value="<?= $this->session->userdata('SESS_USER_ID') ?>">
                  <button class="btn btn-primary float-right" id="INSRT_LEAVE_BTN" type="submit">Apply</button>
                </div>
              </div>

            </form> <!-- Form ends -->
          </div> <!-- col-12 ends  -->
        </div> <!-- row ends  -->
      </div> <!-- Modal ends -->
    </div> <!-- modal-content ends -->
  </div> <!-- modal-dialog ends -->
</div> <!-- modal fade ends -->

<!-- View Leave Details -->
<div class="modal fade" id="modal_leave_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title mt-0 ml-1">Leave Request Details
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body pb-5">
        <div class="row">
          <div class="col-md-4 col-6">
            <!-- <div class="w-100 text-center pt-4">
              <img id="modal_employee_img" class="rounded-circle" alt="" style="width: 150px; height: 150px;">
            </div> -->

            <p class="text-bold mb-1">Name:</p>
            <p class="mb-3" id="employee_name"></p>
            <p class="text-bold mb-1">Position:</p>
            <p class="mb-3" id="employee_position"></p>
            <p class="text-bold mb-1">Department:</p>
            <p class="mb-3" id="employee_department"></p>
            <p class="text-bold mb-1">Date Requested:</p>
            <p class="mb-3" id="leave_date_requested"></p>
            <p class="text-bold mb-1">Request Leave On:</p>
            <p class="mb-3" id="leave_on_date"></p>
            <p class="text-bold mb-1">Leave Type:</p>
            <p class="mb-3" id="leave_type"></p>
            <p class="text-bold mb-1">Reason:</p>
            <p class="mb-3" id="leave_reason"></p>
            <p class="text-bold mb-1">Duration:</p>
            <p class="mb-3" id="leave_duration"></p>
            <p class="text-bold mb-1">Status:</p>
            <p class="mb-3" id="leave_status"></p>

          </div>
        </div> <!-- row ends -->

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
        </div><!-- row ends -->
      </div> <!-- Modal Body ends -->
    </div> <!-- modal-content ends -->
  </div> <!-- modal-dialog ends -->
</div> <!-- modal fade ends -->


<!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->
<?php $this->load->view('templates/jquery_link'); ?>



<!-- SESSION MESSAGES -->

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
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_APPLY_LEAVE')) {
?>
  <script>
    Swal.fire(
      "<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_APPLY_LEAVE'); ?>",
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
if ($this->session->userdata('SESS_ERR_MSG_INSRT_APPLY_LEAVE')) {
?>
  <script>
    Swal.fire(
      "<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_APPLY_LEAVE'); ?>",
      '',
      'warning'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_ERR_MSG_INSRT_APPLY_LEAVE');
}
?>

<script>
  $(document).ready(function() {
    // controller urls
    var url_base = '<?= base_url() ?>';
    var url_get_specific_data = '<?= base_url() ?>leave/get_leave_data';
    var url_get_table_list = '<?= base_url() ?>leave/get_my_leave_data';
    var url_get_empl_data = '<?= base_url() ?>employees/get_empl_data';

    // Check if leave is single day or multiple days (bulk)
    $('input[type=radio][name=leave_class]').change(function() {
      if (this.value == 'leave_single_day') {
        $('#single_leave').show(400);
        $('#multiple_leave').hide(400);

        // if single leave is checked, require all the fields under that div
        $('#INSRT_LEAVE_TYPE').prop('required', true);
        $('#INSRT_LEAVE_DATE').prop('required', true);
        $('#INSRT_LEAVE_DURATION').prop('required', true);

        // if multpile leave is checked, require all the fields under that div
        $('#INSRT_LEAVE_TYPE_MULTIPLE').prop('required', false);
        $('#INSRT_LEAVE_DATE_FROM').prop('required', false);
        // $('#INSRT_LEAVE_DATE_TO').prop('required',false);
        $('#INSRT_LEAVE_DURATION_MULTIPLE').prop('required', false);
      } else if (this.value == 'leave_multiple_days') {
        $('#multiple_leave').show(400);
        $('#single_leave').hide(400);

        // if multpile leave is checked, require all the fields under that div
        $('#INSRT_LEAVE_TYPE_MULTIPLE').prop('required', true);
        $('#INSRT_LEAVE_DATE_FROM').prop('required', true);
        // $('#INSRT_LEAVE_DATE_TO').prop('required',true);
        $('#INSRT_LEAVE_DURATION_MULTIPLE').prop('required', true);

        // if single leave is checked, unrequire all the fields under that div
        $('#INSRT_LEAVE_TYPE').prop('required', false);
        $('#INSRT_LEAVE_DATE').prop('required', false);
        $('#INSRT_LEAVE_DURATION').prop('required', false);
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


    $('#btn_apply_leave').click(function(e) {
      e.preventDefault();

      var employee_id = $(this).attr('employee_id');
      get_empl_data(url_get_empl_data, employee_id).then(function(data) {
        Array.from(data).forEach(function(x) {
          if (x.isRegular > 0) {
            $('#modal_apply_leave').modal('toggle');
          } else {
            Swal.fire(
              'Application Restricted',
              'Only regular employees may apply for leave.',
              'warning'
            )

          }
        })
      })


    })





    // Get & Display Data to Edit Modal Using Async JS function

    const openModalButton = document.querySelectorAll('[data-target]');
    openModalButton.forEach(button => {
      button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.target);
        get_leave_data(url_get_specific_data, button.getAttribute('leave_id'), button.getAttribute('employee_id')).then(data => {
          data.leave_data.forEach((leaveData) => {
            $('#leave_date_requested').text(new Date(leaveData.col_date_created).toLocaleDateString('en-us', {
              weekday: "long",
              year: "numeric",
              month: "short",
              day: "numeric"
            }));
            if (!leaveData.col_leave_to) {
              $('#leave_on_date').text(new Date(leaveData.col_leave_from).toLocaleDateString('en-us', {
                weekday: "long",
                year: "numeric",
                month: "short",
                day: "numeric"
              }));
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
              $('#leave_attachment').attr('src', url_base + 'assets/files/leave/' + leaveData.col_leave_image);
            } else {
              $('#empty_attachment').show();
              $('#leave_attachment').attr('src', '');
            }
            $('#leave_attachment_link').attr('href', url_base + 'assets/files/leave/' + leaveData.col_leave_image);

            if (leaveData.col_reason_rejection) {
              $('#reason_rejection').show();
              $('#leave_rejection_comment').text(leaveData.col_reason_rejection);
            } else {
              $('#leave_rejection_comment').text('');
              $('#reason_rejection').hide();
            }

          });
          data.employee_data.forEach((employeeData) => {
            $('#employee_name').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
            $('#employee_position').text(employeeData.col_empl_posi);
            $('#employee_department').text(employeeData.col_empl_dept);
            $('#modal_employee_img').attr('src', url_base + 'user_images/' + employeeData.col_imag_path);
          })
        });
      });
    });

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
        var page_num = e.current;

        get_table_data(url_get_table_list, page_num).then(function(data) {
          Array.from(data).forEach(function(e) {

            var employee_id       = e.col_empl_id;
            var date_from         = e.col_leave_from;
            var application_id    = e.id;
            var application_date  = e.col_date_created;
            var leave_type        = e.col_leave_type;
            var comment           = e.col_leave_comments;
            var leave_duration    = e.col_leave_duration;
            var status1           = e.col_leave_status1;
            var status2           = e.col_leave_status2;
            var status3           = e.col_leave_status3;


            // Date Change Format
            var application_date = new Date(application_date).toLocaleDateString('en-us', {
              weekday: "long",
              year: "numeric",
              month: "short",
              day: "numeric"
            });
            var date_from = new Date(date_from).toLocaleDateString('en-us', {
              weekday: "long",
              year: "numeric",
              month: "short",
              day: "numeric"
            });

            // Status Condition
            if ((status1 == 'Rejected') || (status2 == 'Rejected') || (status3 == 'Rejected')) {
              var status = 'Rejected';
            } else if ((status1 == 'Approved') && (status2 == 'Approved') && (status3 == 'Approved')) {
              var status = 'Approved';
            } else {
              var status = 'Pending';
            }

            if ((status1 == 'Rejected') || (status2 == 'Rejected') || (status3 == 'Rejected')) {
              var Acknowledged = 'Acknowledged';
            } else if ((status1 == 'Approved') && (status2 == 'Approved') && (status3 == 'Approved')) {
              var Acknowledged = 'Acknowledged';
            } else {
              var Acknowledged = '';
            }

            $('#tbl_application_container').append(`
              <tr class="leave_row" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" employee_id="` + employee_id + `" leave_id="` + application_id + `">
              <td>LV` + application_id.padStart(5, '0') + `</td>
              <td>` + application_date + `</td>
              <td>` + date_from + `</td>
              <td>
              <a href = "#">
                <img class="rounded-circle avatar " width="35" height="35" 
                src="<?php if ($employee_id[0]->col_imag_path) {
                        echo base_url() . 'user_images/' . $employee_id[0]->col_imag_path;
                      } else {
                        echo base_url() . 'user_images/default_profile_img3.png';
                      } ?>">&nbsp;&nbsp;<?= $employee_id[0]->col_frst_name . ' ' . $employee_id[0]->col_last_name ?>
                </a>
              </td>
              <td>` + leave_type + `</td>
              <td style="word-break: break-word;">` + comment + `</td>
              <td>` + Number(leave_duration).toFixed(2) + `</td>
              <td>` + status + `</td>
              <td>` + Acknowledged + `</td>
              </tr>
          `)
          })
        })

      }
    });
    //-------------------------- ASYNC FUNCTIONS ------------------------------------------
    //Get My Leave List for the Table display
    async function get_table_data(url, page_num) {
      var formData = new FormData();
      formData.append('page_num', page_num);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    //Get Specific Leave Data for Modal Display
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

    //Get Employee Details to use for Modal Verification
    async function get_empl_data(url, empl_id) {
      var formData = new FormData();
      formData.append('empl_id', empl_id);
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