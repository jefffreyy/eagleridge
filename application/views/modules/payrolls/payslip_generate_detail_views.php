<html>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?php echo base_url()?>/assets_system/css/handsontable14.css">

<?php
$search_data = $this->input->get('all');
$search_data = str_replace("_", " ", $search_data ?? '');

if (isset($_GET['search'])) {
  $search = $_GET['search'];
} else {
  $search = "";
}

if (isset($_GET['row'])) {
  $row = $_GET['row'];
} else {
  $row = 25;
}

if (isset($_GET['page'])) {
  $current_page = $_GET['page'];
} else {
  $current_page = 1;
}

$prev_page         = $current_page - 1;
$next_page         = $current_page + 1;
$last_page_initial = ceil($C_DATA_COUNT / $row);
$last_page         = ($last_page_initial == 0 || $last_page_initial == 1) ? 1 : $last_page_initial;

if ($C_DATA_COUNT == 0) {
  $low_limit = 0;
} else {
  $low_limit = $row * ($current_page - 1) + 1;
}
if ($current_page * $row > $C_DATA_COUNT) {
  $high_limit = $C_DATA_COUNT;
} else {
  $high_limit = $row * ($current_page);
}
?>

<style>
  .header-employee {
    background-color: green;
    color: white;
  }

  @media print {
    @page {
      size: landscape;
      size: 13in 8.5in !important;
    }

    #table_data_new {
      font-size: 10pt;
      width: 100%;
      border-collapse: collapse;
      margin: 0;

    }

    .container-fluid {
      background-color: white;
    }

    body {
      background-color: white;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
  }
</style>

<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title" id="page_title"><a href="<?= base_url() . 'payrolls/'.$TAB.'?period='.$PERIOD; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Payslip Generated Details<h1>
      </div>

      <!-- <div class="col-md-6 button-title">
        <a href="<?= base_url('attendances/add_attendance_summary') ?>" class="btn btn-success" id="btn-add-row"><i class="fa-solid fa-circle-plus"></i>&nbsp;Add Data</a>
        <a href="<?= base_url('attendances/edit_attendance_summary') ?>" class="btn btn-primary" id="btn-update"><i class="fa-duotone fa-pen-to-square"></i>&nbsp;Edit Data</a>
      </div> -->
    </div>
    <div class="row">
      <div class=" col-md-2 py-2">
        <p class="p-0 my-1 text-bold">Cut-off&nbsp;Period</p>
        <select class="form-control cut_off_period" id="cut_off_period" disabled>
          <?php foreach ($CUTOFF_PERIODS as $cut_off) { ?>
            <option value="<?= $cut_off->id ?>" <?= $PERIOD == $cut_off->id ? 'selected' : '' ?>><?= $cut_off->name ?></option>
          <?php } ?>
        </select>
      </div>

      <div class=" col-md-2 py-2">
        <div class="form-group">
          <label class="" for="start_date">Start&nbsp;Date</label>
          <input type="date" class="form-control " name="start_date" id="start_date" value="<?= $SPECIFIC_PAYROLL_SCHEDULES->date_from ?>" disabled>
        </div>
      </div>

      <div class=" col-md-2 py-2">
        <div class="form-group">
          <label class="" for="end_date">End&nbsp;Date</label>
          <input type="date" class="form-control " name="end_date" id="end_date" value="<?= $SPECIFIC_PAYROLL_SCHEDULES->date_to ?>" disabled>
        </div>
      </div>

      <div class=" col-md-2 py-2">
        <div class="form-group">
          <label class="" for="payout_date">Payout&nbsp;Date</label>
          <input type="date" class="form-control " name="payout_date" id="payout_date" value="<?= $SPECIFIC_PAYROLL_SCHEDULES->payout ?>" disabled>
        </div>
      </div>

      <div class=" col-md-2 py-2">
        <div class="form-group">
          <label class="" for="pay_freq">Pay&nbsp;Frequency</label>
          <select class="form-control" name="pay_freq" id="pay_freq" disabled>
            <option value='Monthly'>Monthly</option>
            <option value='Semi-Monthly'>Semi-Monthly</option>
            <option value='Weekly'>Weekly</option>
          </select>
        </div>
      </div>
    
      <div class=" col-md-2 py-2" <?= ($SPECIFIC_PAYROLL_SCHEDULES->connected_period == 0) ? 'Hidden' : ''; ?>>
        <div class="form-group">
          <label class="" for="input_">Connected&nbsp;Period&nbsp;1&nbsp;(Optional)</label>
          <select class="form-control" name="con_period_1" id="con_period_1" disabled>
            <option value="">No Option Selected</option>
            <?php if ($PAYROLL_SCHEDULES) {
              foreach ($PAYROLL_SCHEDULES as $PAYROLL_SCHEDULE) { ?>
                <option value='<?= $PAYROLL_SCHEDULE->id ?>' <?= ($PAYROLL_SCHEDULE->id == $SPECIFIC_PAYROLL_SCHEDULES->connected_period) ? 'selected' : '' ?>><?= $PAYROLL_SCHEDULE->name ?></option>
            <?php    }
            } ?>
          </select>
        </div>
      </div>

      <div class=" col-md-2 py-2" <?= ($SPECIFIC_PAYROLL_SCHEDULES->connected_period_2 == 0) ? 'Hidden' : ''; ?>>
        <div class="form-group">
          <label class="" for="input_">Connected Period 2 (Optional)</label>
          <select class="form-control" name="con_period_2" id="con_period_2" disabled>
            <option value="">No Option Selected</option>
            <?php if ($PAYROLL_SCHEDULES) {
              foreach ($PAYROLL_SCHEDULES as $PAYROLL_SCHEDULE) { ?>
                <option value='<?= $PAYROLL_SCHEDULE->id ?>' <?= ($PAYROLL_SCHEDULE->id == $SPECIFIC_PAYROLL_SCHEDULES->connected_period_2) ? 'selected' : '' ?>><?= $PAYROLL_SCHEDULE->name ?></option>
            <?php    }
            } ?>
          </select>
        </div>
      </div>

      <div class=" col-md-2 py-2" <?= ($SPECIFIC_PAYROLL_SCHEDULES->connected_period_3 == 0) ? 'Hidden' : ''; ?>>
        <div class="form-group">
          <label class="" for="input_">Connected Period 3 (Optional)</label>
          <select class="form-control" name="con_period_3" id="con_period_3" disabled>
            <option value="">No Option Selected</option>
            <?php if ($PAYROLL_SCHEDULES) {
              foreach ($PAYROLL_SCHEDULES as $PAYROLL_SCHEDULE) { ?>
                <option value='<?= $PAYROLL_SCHEDULE->id ?>' <?= ($PAYROLL_SCHEDULE->id == $SPECIFIC_PAYROLL_SCHEDULES->connected_period_3) ? 'selected' : '' ?>><?= $PAYROLL_SCHEDULE->name ?></option>
            <?php    }
            } ?>
          </select>
        </div>
      </div>

      <div class=" col-md-2 py-2" <?= ($SPECIFIC_PAYROLL_SCHEDULES->connected_period_4 == 0) ? 'Hidden' : ''; ?>>
        <div class="form-group">
          <label class="" for="input_">Connected Period 4 (Optional)</label>
          <select class="form-control" name="con_period_4" id="con_period_4" disabled>
            <option value="">No Option Selected</option>
            <?php if ($PAYROLL_SCHEDULES) {
              foreach ($PAYROLL_SCHEDULES as $PAYROLL_SCHEDULE) { ?>
                <option value='<?= $PAYROLL_SCHEDULE->id ?>' <?= ($PAYROLL_SCHEDULE->id == $SPECIFIC_PAYROLL_SCHEDULES->connected_period_4) ? 'selected' : '' ?>><?= $PAYROLL_SCHEDULE->name ?></option>
            <?php    }
            } ?>
          </select>
        </div>
      </div>

      <div class=" col-md-2 py-2" <?= ($SPECIFIC_PAYROLL_SCHEDULES->connected_period_5 == 0) ? 'Hidden' : ''; ?>>
        <div class="form-group">
          <label class="" for="input_">Connected Period 5 (Optional)</label>
          <select class="form-control" name="con_period_5" id="con_period_5" disabled>
            <option value="">No Option Selected</option>
            <?php if ($PAYROLL_SCHEDULES) {
              foreach ($PAYROLL_SCHEDULES as $PAYROLL_SCHEDULE) { ?>
                <option value='<?= $PAYROLL_SCHEDULE->id ?>' <?= ($PAYROLL_SCHEDULE->id == $SPECIFIC_PAYROLL_SCHEDULES->connected_period_5) ? 'selected' : '' ?>><?= $PAYROLL_SCHEDULE->name ?></option>
            <?php    }
            } ?>
          </select>
        </div>
      </div>



    </div>

    <div class="row">

      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2" id="cb_sss" name="cb_sss" style="width: 20px; height: 20px; font-size: 13px; color:green;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_sss == "0") ? 'checked' : '' ?> disabled>
          <label for="cb_sss" class="mr-4"> SSS Contribution</label><br>
        </div>
      </div>

      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2" id="cb_phil" name="cb_phil" style="width: 20px; height:20px; font-size: 13px;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_philhealth == "0") ? 'checked' : '' ?> disabled>
          <label for="cb_phil" class="mr-4"> Philhealth Contribution</label><br>
        </div>
      </div>

      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2 " id="cb_pagibig" name="cb_pagibig" style="width: 20px; height:20px; font-size: 13px;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_pagibig == "0") ? 'checked' : '' ?> disabled>
          <label for="cb_pagibig" class="mr-4"> Pag-ibig Contribution</label><br>
        </div>
      </div>

      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2" id="input_wtax" name="input_wtax" style="width: 20px; height:20px; font-size: 13px;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_withholding == "0") ? 'checked' : '' ?> disabled>
          <label for="cb_wtax" class="mr-4"> Withholding Tax</label><br>
        </div>
      </div>

      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2" id="input_earnings" name="input_earnings" style="width: 20px; height:20px; font-size: 13px;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_taxable == "0") ? 'checked' : '' ?> disabled>
          <label for="cb_ti" class="mr-4"> Taxable Allowance</label><br>
        </div>
      </div>

      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2" id="input_deductions" name="input_deductions" style="width: 20px; height:20px; font-size: 13px;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_nontaxable == "0") ? 'checked' : '' ?> disabled>
          <label for="cb_nti" class="mr-4"> Non-Taxable Allowance</label><br>
        </div>
      </div>

      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2" id="input_loans" name="input_loans" style="width: 20px; height:20px; font-size: 13px;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_loans == "0") ? 'checked' : '' ?> disabled>
          <label for="cb_loans" class="mr-4">Loans</label><br>
        </div>
      </div>

      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2" id="input_adjustment" name="input_adjustment" style="width: 20px; height:20px; font-size: 13px;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_adjustment == "0") ? 'checked' : '' ?> disabled>
          <label for="cb_loans" class="mr-4">Adjustment</label><br>
        </div>
      </div>

      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2" id="input_tard" name="input_tard" style="width: 20px; height:20px; font-size: 13px;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_tardiness == "0") ? 'checked' : '' ?> disabled>
          <label for="cb_absut" class="mr-4">Tardiness</label><br>
        </div>
      </div>

    </div>


    <!-- <div class='d-flex justify-content-end mr-1'>
      <button class="btn btn-primary" id="btn-insert"><i class="fa-solid fa-circle-arrow-up"></i>&nbsp;Endorse to Payroll</button>
      <button type="button" class="btn btn-primary ml-1" data-toggle="modal" data-target="#settingsModal" id="hide_col_btn"><i class="fa-duotone fa-eye-slash"></i>&nbsp;Hide Columns</button>
      <button type="button" class="btn btn-primary ml-1" id="printButton" onclick="changeTitle()"><i class="fa-duotone fa-print"></i>&nbsp;Print</button>
    </div> -->

    <div class="card border-0">
      <div class="card border-0" style="margin: 0px !important;">
        <div class="card-header d-none p-0">
          <div class="row ">
            <div class="col-xl-8 ">
            </div>

            <!-- <div class="col-xl-4">
              <div class="input-group pb-1">
                <?php
                if ($search_data) { ?>
                  <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fa-regular fa-broom-wide" style="margin-top: 4px"></i>&nbsp;Clear</button>
                <?php } else { ?>
                  <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
                <?php } ?>
                <input type="text" class="form-control" placeholder="Search..." value="<?= ($search_data) ? $search_data : "" ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
              </div>
            </div> -->
          </div>
        </div>
        <div class="card border-0 p-0 m-0">
          <div class="p-2">
            <div lass='row align-items-center'>
              <!-- <div class='col col-md-4'>
                <button class="btn btn-primary" id="btn-generate-payslip"><i class="fa-solid fa-circle-arrow-up"></i>&nbsp;Generate Payslip</button>
              </div> -->

              <!-- <div class='col d-flex justify-content-end align-items-center'>
                <ul class="d-inline pagination m-0 p-0 ">
                  <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                  <ul class="d-inline pagination m-0 p-0 ">
                    <li><a class="page_row" <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
                        < </a>
                    </li>
                    <li><a class="page_row" href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                    <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                    <li><a class="page_row" href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                    <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                    <li><a class="page_row" href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                    <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                    <li><a class="page_row" href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page) echo "hidden"; ?>><?= $last_page ?> </a></li>
                    <li><a class="page_row" style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
                  </ul>

                  <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                  <select id="row_dropdown" class="custom-select m-0" style="width: auto;">
                    <?php
                    foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>
                      <option value=<?= $C_ROW_DISPLAY_ROW ?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>
                    <?php } ?>
                  </select>
                  </ul>
              </div> -->
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div>
                <div id="table_data_new"> </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<form id='builk_activate' method='post' action="<?= base_url('payrolls/bulk_activate') ?>">
  <input type='hidden' name='active' id='active_loans' />
  <input type='hidden' name='table' value='tbl_payroll_loan' />
</form>

<form id='builk_inactivate' method='post' action="<?= base_url('payrolls/bulk_inactivate') ?>">
  <input type='hidden' name='inactive' id='inactive_loans' />
  <input type='hidden' name='table' value='tbl_payroll_loan' />
</form>

<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="settingsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="settingsModalLabel">Select Columns to Hide</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form>
          <div class="form-check">
            <input type="checkbox" class="form-check-input select-all" id="selectAllCheckbox">
            <label class="form-check-label" for="selectAllCheckbox">Select All</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input column-checkbox" id="employeeCheckbox">
            <label class="form-check-label" for="employeeCheckbox">Employee</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input column-checkbox" id="attendanceRecordCheckbox">
            <label class="form-check-label" for="attendanceRecordCheckbox">Attendance Record</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input column-checkbox" id="absencesCheckbox">
            <label class="form-check-label" for="shiftCheckbox">Absences</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input column-checkbox" id="deductionsCheckbox">
            <label class="form-check-label" for="shiftCheckbox">Deductions</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input column-checkbox" id="regularHolidayCheckbox">
            <label class="form-check-label" for="shiftCheckbox">REGULAR</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input column-checkbox" id="restCheckbox">
            <label class="form-check-label" for="shiftCheckbox">REST</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input column-checkbox" id="legalCheckbox">
            <label class="form-check-label" for="shiftCheckbox">LEGAL</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input column-checkbox" id="restLegalCheckbox">
            <label class="form-check-label" for="shiftCheckbox">REST+LEGAL</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input column-checkbox" id="specialCheckbox">
            <label class="form-check-label" for="shiftCheckbox">SPECIAL</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input column-checkbox" id="restSpecialCheckbox">
            <label class="form-check-label" for="shiftCheckbox">REST+SPECIAL</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input column-checkbox" id="subsidyCheckbox">
            <label class="form-check-label" for="shiftCheckbox">Subsidy</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input column-checkbox" id="shiftCheckbox">
            <label class="form-check-label" for="shiftCheckbox">Dynamic Incentives</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input column-checkbox" id="fixedIncentivesCheckbox">
            <label class="form-check-label" for="shiftCheckbox">Fixed Incentives</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input column-checkbox" id="adjustmentCheckbox">
            <label class="form-check-label" for="shiftCheckbox">Adjustment</label>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveButton">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p style="font-size: 400px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;
          </span>
        </button>
      </div>

      <div class="modal-body">
        <p>Hi are you sure you want to logout?</p>
      </div>

      <div class="modal-footer pb-1 pt-1">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout</a>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('templates/jquery_link'); ?>
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url()?>/assets_system/js/handsontable14.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<script>
  var url = '<?= base_url() ?>';
  var payroll_payslips = <?php echo json_encode($PAYROLL_PAYSLIPS); ?>

  let employee_info             = ['Employee ID', 'Employee Name', 'Salary Type', 'Salary Rate', 'Bank Name', 'Bank Account', 'Monthly Salary', 'Daily Salary', 'Hourly Salary'];
  let basic_salary              = ['Regular', 'Paid Leave', 'Absences', 'Tardiness', 'Undertime', 'Underbreak', 'Overbreak', 'Basic Pay'];
  let ot_and_night_diff         = ['REG OT', 'REG ND', 'REG NDOT', 'RST REG', 'RST OT', 'RST ND', 'RST NDOT', 'LEG REG', 'LEG OT', 'LEG ND', 'LEG NDOT', 'RST+LEG REG', 'RST+LEG OT', 'RST+LEG ND', 'RST+LEG NDOT', 'SPE REG', 'SPE OT', 'SPE ND', 'SPE NDOT', 'RST+SPE REG', 'RST+SPE OT', 'RST+SPE ND', 'RST+SPE NDOT', 'TOTAL OT PAY'];
  let taxable_allowance         = ['Total Taxable Allowance'];
  let nontaxable_allowance      = ['Total Non-Taxable Allowance'];
  let gross_pay                 = ['Gross Pay']
  let taxable_income            = ['Taxable Income'];
  let wtax                      = ['WTAX'];
  let contributions             = ['SSS EE', 'Pagibig EE', 'Philhealth EE', 'Total Contribution'];
  let loans                     = ['Total Loans'];
  // let ca_total                  = ['Total Cash Advance']
  let deductions                = ['Total Deductions'];
  let net_pay                   = ['Net Pay'];

  const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.style.whiteSpace = 'nowrap';
    td.style.overflow = 'hidden';
  };

  const selectedPayslipData = payroll_payslips.map(function(payslip) {

  return {
    id: payslip.id,
    PAYSLIP_EMPLOYEE_CMID: payslip.PAYSLIP_EMPLOYEE_CMID,
    PAYSLIP_EMPLOYEE_NAME: payslip.PAYSLIP_EMPLOYEE_NAME,
    PAYSLIP_SALARY_TYPE: payslip.PAYSLIP_SALARY_TYPE,
    PAYSLIP_SALARY_RATE: parseFloat(payslip.PAYSLIP_SALARY_RATE).toFixed(2),
    
    // WORKDAYSPERYEAR:'N/A',
    BANK_NAME: payslip.BANK_NAME,
    BANK_ACCOUNT: payslip.BANK_ACCOUNT,
    INITIAL_MONTHLY_RATE: parseFloat(payslip.INITIAL_MONTHLY_RATE).toFixed(2),
    INITIAL_DAILY_RATE: parseFloat(payslip.INITIAL_DAILY_RATE).toFixed(2),
    INITIAL_HOURLY_RATE: parseFloat(payslip.INITIAL_HOURLY_RATE).toFixed(2),

    TOT_REG_HOURS: parseFloat(payslip.TOT_REG_HOURS).toFixed(2),
    TOT_PAID_LEAVE: parseFloat(payslip.TOT_PAID_LEAVE).toFixed(2),
    TOT_ABSENT: parseFloat(payslip.TOT_ABSENT).toFixed(2),
    TOT_TARDINESS: parseFloat(payslip.TOT_TARDINESS).toFixed(2),
    TOT_UNDERTIME: parseFloat(payslip.TOT_UNDERTIME).toFixed(2),
    TOT_UNDERBREAK: parseFloat(payslip.TOT_UNDERBREAK).toFixed(2),
    TOT_OVERBREAK: parseFloat(payslip.TOT_OVERBREAK).toFixed(2),
    TOTAL_BASIC: parseFloat(payslip.TOTAL_BASIC).toFixed(2),

    TOT_REG_OT: parseFloat(payslip.TOT_REG_OT).toFixed(2),
    TOT_REG_ND: parseFloat(payslip.TOT_REG_ND).toFixed(2),
    TOT_REG_NDOT: parseFloat(payslip.TOT_REG_NDOT).toFixed(2),

    TOT_REST_HOURS: parseFloat(payslip.TOT_REST_HOURS).toFixed(2),
    TOT_REST_OT: parseFloat(payslip.TOT_REST_OT).toFixed(2),
    TOT_REST_ND: parseFloat(payslip.TOT_REST_ND).toFixed(2),
    TOT_REST_NDOT: parseFloat(payslip.TOT_REST_NDOT).toFixed(2),

    TOT_LEG_HOURS: parseFloat(payslip.TOT_LEG_HOURS).toFixed(2),
    TOT_LEG_OT: parseFloat(payslip.TOT_LEG_OT).toFixed(2),
    TOT_LEG_ND: parseFloat(payslip.TOT_LEG_ND).toFixed(2),
    TOT_LEG_NDOT: parseFloat(payslip.TOT_LEG_NDOT).toFixed(2),

    TOT_LEGREST_HOURS: parseFloat(payslip.TOT_LEGREST_HOURS).toFixed(2),
    TOT_LEGREST_OT: parseFloat(payslip.TOT_LEGREST_OT).toFixed(2),
    TOT_LEGREST_ND: parseFloat(payslip.TOT_LEGREST_ND).toFixed(2),
    TOT_LEGREST_NDOT: parseFloat(payslip.TOT_LEGREST_NDOT).toFixed(2),

    TOT_SPE_HOURS: parseFloat(payslip.TOT_SPE_HOURS).toFixed(2),
    TOT_SPE_OT: parseFloat(payslip.TOT_SPE_OT).toFixed(2),
    TOT_SPE_ND: parseFloat(payslip.TOT_SPE_ND).toFixed(2),
    TOT_SPE_NDOT: parseFloat(payslip.TOT_SPE_NDOT).toFixed(2),
    
    TOT_SPEREST_HOURS: parseFloat(payslip.TOT_SPEREST_HOURS).toFixed(2),
    TOT_SPEREST_OT: parseFloat(payslip.TOT_SPEREST_OT).toFixed(2),
    TOT_SPEREST_ND: parseFloat(payslip.TOT_SPEREST_ND).toFixed(2),
    TOT_SPEREST_NDOT: parseFloat(payslip.TOT_SPEREST_NDOT).toFixed(2),

    TOTAL_OTND: parseFloat(payslip.TOTAL_OTND).toFixed(2),

    OTHER_TOTAL_TAX: parseFloat(payslip.OTHER_TOTAL_TAX).toFixed(2),
    OTHER_TOTAL_NONTAX: parseFloat(payslip.OTHER_TOTAL_NONTAX).toFixed(2),
    GROSS_INCOME: parseFloat(payslip.GROSS_INCOME).toFixed(2),
    TAXABLE_INCOME: parseFloat(payslip.TAXABLE_INCOME).toFixed(2),
    WTAX: parseFloat(payslip.WTAX).toFixed(2),
    SSS_EE_CURRENT: parseFloat(payslip.SSS_EE_CURRENT).toFixed(2),
    PAGIBIG_EE_CURRENT: parseFloat(payslip.PAGIBIG_EE_CURRENT).toFixed(2),
    PHILHEALTH_EE_CURRENT: parseFloat(payslip.PHILHEALTH_EE_CURRENT).toFixed(2),
    TOTAL_CONTRIBUTIONS: (Number(payslip.WTAX) + Number(payslip.SSS_EE_CURRENT)+  Number(payslip.PAGIBIG_EE_CURRENT)+ Number(payslip.PHILHEALTH_EE_CURRENT)).toFixed(2),
    LOAN_TOTAL: parseFloat(payslip.LOAN_TOTAL).toFixed(2),
    DEDUCTIONS: parseFloat(payslip.DEDUCTIONS).toFixed(2),
    NET_INCOME: parseFloat(payslip.NET_INCOME).toFixed(2),
    
  };
});

const nestedHeaders = [
  
  ['ID',  {
          label: 'Employee Info',
          colspan: employee_info.length,
        },
        {
          label: 'Basic Salary',
          colspan: basic_salary.length,
          type: 'numeric', format: '0,0.00'
        },
        {
          label: 'OT / Night Differential',
          colspan: ot_and_night_diff.length,
        },

        {
          label: 'Taxable Allowance',
          colspan: taxable_allowance.length
        },

        {
          label: 'Non-Taxable Allowance',
          colspan: nontaxable_allowance.length
        },

        {
          label: 'Gross',
          colspan: gross_pay.length
        },
        {
          label: 'Taxable',
          colspan: taxable_income.length
        },
        {
          label: 'Withholding Tax',
          colspan: wtax.length
        },

        {
          label: 'Contributions',
          colspan: contributions.length
        },
        {
          label: 'Loans',
          colspan: loans.length
        },
        
        // {
        //   label: 'Cash Advance',
        //   colspan: ca_total.length
        // },
        {
          label: 'Deductions',
          colspan: deductions.length
        },
        {
          label: 'NET',
          colspan: net_pay.length
        },
      ],

      ['ID', ...employee_info, ...basic_salary, ...ot_and_night_diff, ...taxable_allowance, ...nontaxable_allowance, ...gross_pay, ...taxable_income, ...wtax, ...contributions, ...loans, /*...ca_total,*/ ...deductions, ...net_pay],
    
  ]
  const hiddenColumns = {
    columns: [0],
  };


    let amount_custom = function(instance, td, row, col, prop, value, cellProperties) {
      Handsontable.renderers.TextRenderer.apply(this, arguments);
      td.style.whiteSpace = 'nowrap';
      td.style.overflow = 'hidden';
      if (prop != "PAYSLIP_EMPLOYEE_CMID" && prop != "PAYSLIP_EMPLOYEE_NAME" && prop != "PAYSLIP_SALARY_TYPE" && prop != "BANK_NAME" && prop != "BANK_ACCOUNT") {
          td.style.textAlign = 'right';
          td.innerHTML = '<span style="float: left;">&#8369;</span>' + value;
      }
  };



  const container = document.querySelector('#table_data_new');
  hot = new Handsontable(container, {
    data: selectedPayslipData,
    colHeaders: true,
    rowHeaders: true,
    height: 'auto',
    colWidths: 100,
    nestedHeaders,
    outsideClickDeselects: false,
    selectionMode: 'multiple',
    licenseKey: 'non-commercial-and-evaluation',
    renderer: amount_custom,
    readOnly: true,
    hiddenColumns,
    // afterGetColHeader: afterGetColHeader,
    // columns: columns,
  });
  hot.updateSettings({
    height: window.innerHeight - container.getBoundingClientRect().top - 50,
  });

  var url = '<?= base_url() ?>';

</script>

<script>
  $(document).ready(function() {
    var base_url = '<?= base_url(); ?>';

    $('#row_dropdown').on('change', function(e) {
      e.preventDefault()
      var row_val = $(this).val();
      let data = "?page=1&row=" + row_val;
      filter_data(data);
    });

    $('.page_row').on('click', function(e) {
      e.preventDefault()
      let page_row = $(this).attr('href');
      filter_data(page_row);
    })

    function filter_data(page_row) {
      if (page_row == null || page_row == "") {
        page_row = '?page=' + "<?= $current_page ?>" + '&row=' + "<?= $row ?>"
      }
      let row = $("#row_dropdown").val();

      window.location = base_url + "payrolls/view_details" + page_row;
    }

    $('select.cut_off_period').on('change', function() {
      window.location.href = "<?= base_url('payrolls/view_details?period=') ?>" + $(this).val()
    })
  })
</script>

</body>

</html>