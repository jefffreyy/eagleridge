<html>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?php echo base_url()?>/assets_system/css/handsontable14.css">
<style>
  .loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
  }
  .loading-spinner {
    border: 4px solid #f3f3f3; 
    border-top: 4px solid #3498db; 
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite; 
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>
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
  <!-- <div id="loadingOverlay" class="loading-overlay">
    <div class="loading-spinner"></div>
  </div> -->
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title d-flex align-items-center" id="page_title"><a href="<?= base_url() . 'payrolls/' . $TAB . '?period=' . $PERIOD; ?>"><img style="width: 24px; height: 24px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Ready Generate Payslip<h1>
      </div>
     
      <div class="col-md-6 button-title">
        <!-- <a href="<?= base_url('attendances/add_attendance_summary') ?>" class="btn btn-success" id="btn-add-row"><i class="fa-solid fa-circle-plus"></i>&nbsp;Add Data</a> -->
        <button class="btn btn-primary" id="btn-update"><img style="width: 16px; height: 16px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update Contributions</button>
      </div>
    </div>
    <hr>
    <?= form_open_multipart('payrolls/contributions' , array('id' => 'payroll_contribution_form')) ?>
    <div class="row">
      <div class=" col-md-2 py-2">
        <p class="p-0 my-1 text-bold">Cut-off&nbsp;Period</p>
        <select class="form-control cut_off_period" id="cut_off_period" name="cut_off_period">
          <?php foreach ($CUTOFF_PERIODS as $cut_off) { ?>
            <option value="<?= $cut_off->id ?>" <?= $PERIOD == $cut_off->id ? 'selected' : '' ?>><?= $cut_off->name ?></option>
          <?php } ?>
        </select>
      </div>
      <div class=" col-md-2 py-2">
        <div class="form-group">
          <label class="" for="start_date">Start&nbsp;Date</label>
          <input type="date" class="form-control " name="start_date" id="start_date" value="<?= isset($SPECIFIC_PAYROLL_SCHEDULES->date_from) ? $SPECIFIC_PAYROLL_SCHEDULES->date_from : "" ?>" disabled>
        </div>
      </div>
      <div class=" col-md-2 py-2">
        <div class="form-group">
          <label class="" for="end_date">End&nbsp;Date</label>
          <input type="date" class="form-control " name="end_date" id="end_date" value="<?= isset($SPECIFIC_PAYROLL_SCHEDULES->date_to) ? $SPECIFIC_PAYROLL_SCHEDULES->date_to : "" ?>" disabled>
        </div>
      </div>
      <div class=" col-md-2 py-2">
        <div class="form-group">
          <label class="" for="payout_date">Payout&nbsp;Date</label>
          <input type="date" class="form-control " name="payout_date" id="payout_date" value="<?= isset($SPECIFIC_PAYROLL_SCHEDULES->payout) ? $SPECIFIC_PAYROLL_SCHEDULES->payout : "" ?>" disabled>
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
      <div class=" col-md-2 py-2" <?= isset($SPECIFIC_PAYROLL_SCHEDULES->connected_period) ? (($SPECIFIC_PAYROLL_SCHEDULES->connected_period == 0) ? 'Hidden' : '') : 'Hidden'; ?>>
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
      <div class=" col-md-2 py-2" <?= isset($SPECIFIC_PAYROLL_SCHEDULES->connected_period_2) ? (($SPECIFIC_PAYROLL_SCHEDULES->connected_period_2 == 0) ? 'Hidden' : '') : 'Hidden'; ?>>
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
      <div class=" col-md-2 py-2" <?= isset($SPECIFIC_PAYROLL_SCHEDULES->connected_period_3) ? (($SPECIFIC_PAYROLL_SCHEDULES->connected_period_3 == 0) ? 'Hidden' : '') : 'Hidden'; ?>>
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
      <div class=" col-md-2 py-2" <?= isset($SPECIFIC_PAYROLL_SCHEDULES->connected_period_4) ? (($SPECIFIC_PAYROLL_SCHEDULES->connected_period_4 == 0) ? 'Hidden' : '') : 'Hidden'; ?>>
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
      <div class=" col-md-2 py-2" <?= isset($SPECIFIC_PAYROLL_SCHEDULES->connected_period_5) ? (($SPECIFIC_PAYROLL_SCHEDULES->connected_period_5 == 0) ? 'Hidden' : '') : 'Hidden'; ?>>
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
          <input type="checkbox" class="form-control mx-2" id="cb_sss" name="cb_sss" style="width: 20px; height: 20px; font-size: 13px; color:green;" <?= isset($SPECIFIC_PAYROLL_SCHEDULES->chk_sss) ? (($SPECIFIC_PAYROLL_SCHEDULES->chk_sss == "0") ? 'checked' : '') : ''; ?> >
          <label for="cb_sss" class="mr-4"> SSS Contribution</label><br>
        </div>
      </div>
      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2" id="cb_phil" name="cb_phil" style="width: 20px; height:20px; font-size: 13px;" <?= isset($SPECIFIC_PAYROLL_SCHEDULES->chk_philhealth) ? (($SPECIFIC_PAYROLL_SCHEDULES->chk_philhealth == "0") ? 'checked' : '') : ''; ?> >
          <label for="cb_phil" class="mr-4"> Philhealth Contribution</label><br>
        </div>
      </div>
      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2 " id="cb_pagibig" name="cb_pagibig" style="width: 20px; height:20px; font-size: 13px;" <?= isset($SPECIFIC_PAYROLL_SCHEDULES->chk_pagibig) ? (($SPECIFIC_PAYROLL_SCHEDULES->chk_pagibig == "0") ? 'checked' : '') : ''; ?> >
          <label for="cb_pagibig" class="mr-4"> Pag-ibig Contribution</label><br>
        </div>
      </div>
      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2" id="input_wtax" name="input_wtax" style="width: 20px; height:20px; font-size: 13px;" <?= isset($SPECIFIC_PAYROLL_SCHEDULES->chk_withholding) ? (($SPECIFIC_PAYROLL_SCHEDULES->chk_withholding == "0") ? 'checked' : '') : ''; ?> >
          <label for="cb_wtax" class="mr-4"> Withholding Tax</label><br>
        </div>
      </div>
      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2" id="input_ta" name="input_ta" style="width: 20px; height:20px; font-size: 13px;" <?= isset($SPECIFIC_PAYROLL_SCHEDULES->chk_taxable) ? (($SPECIFIC_PAYROLL_SCHEDULES->chk_taxable == "0") ? 'checked' : '') : ''; ?> >
          <label for="cb_ti" class="mr-4"> Taxable Allowance</label><br>
        </div>
      </div>
      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2" id="input_nta" name="input_nta" style="width: 20px; height:20px; font-size: 13px;" <?= isset($SPECIFIC_PAYROLL_SCHEDULES->chk_nontaxable) ? (($SPECIFIC_PAYROLL_SCHEDULES->chk_nontaxable == "0") ? 'checked' : '') : '' ?> >
          <label for="cb_nti" class="mr-4"> Non-Taxable Allowance</label><br>
        </div>
      </div>
      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2" id="input_loans" name="input_loans" style="width: 20px; height:20px; font-size: 13px;" <?= isset($SPECIFIC_PAYROLL_SCHEDULES->chk_loans) ? (($SPECIFIC_PAYROLL_SCHEDULES->chk_loans == "0") ? 'checked' : '') : '' ?> >
          <label for="cb_loans" class="mr-4">Loans</label><br>
        </div>
      </div>
      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2" id="input_adjustment" name="input_adjustment" style="width: 20px; height:20px; font-size: 13px;" <?= isset($SPECIFIC_PAYROLL_SCHEDULES->chk_adjustment) ? (($SPECIFIC_PAYROLL_SCHEDULES->chk_adjustment == "0") ? 'checked' : '') : '' ?> >
          <label for="cb_loans" class="mr-4">Adjustment</label><br>
        </div>
      </div>
      <div class=" col-md-2 py-2">
        <div class="d-flex">
          <input type="checkbox" class="form-control mx-2" id="input_tard" name="input_tard" style="width: 20px; height:20px; font-size: 13px;" <?= isset($SPECIFIC_PAYROLL_SCHEDULES->chk_tardiness) ? (($SPECIFIC_PAYROLL_SCHEDULES->chk_tardiness == "0") ? 'checked' : '') : '' ?> checked disabled>
          <label for="cb_absut" class="mr-4">Tardiness</label><br>
        </div>
      </div>
    </div>
    <?= form_close(); ?>
    <!-- <div class='d-flex justify-content-end mr-1'>
      <button class="btn btn-primary" id="btn-insert"><i class="fa-solid fa-circle-arrow-up"></i>&nbsp;Endorse to Payroll</button>
      <button type="button" class="btn btn-primary ml-1" data-toggle="modal" data-target="#settingsModal" id="hide_col_btn"><i class="fa-duotone fa-eye-slash"></i>&nbsp;Hide Columns</button>
      <button type="button" class="btn btn-primary ml-1" id="printButton" onclick="changeTitle()"><i class="fa-duotone fa-print"></i>&nbsp;Print</button>
    </div> -->
    <div class="card border-0 p-0 m-0">
      <div class="card border-0 p-1 m-0">
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
              <div class='col col-md-4'>
                <button class="btn btn-primary" id="btn-generate-payslip"><img style="width: 16px; height: 16px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Generate Payslip</button>
              <button onclick="exportToExcel()" id="btn_export" class=" btn btn-primary shadow-none rounded d-flex align-items-center mr-2" 
                  style="width: auto; display: inline-block !important;"
                  >
                    <img class="mb-1" src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>" alt="">&nbsp;Export XLSX
                  </button>
              </div>
              
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
              </div> -->
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="p-2">
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
<!-- <script>
  function afterRenderFunction(){
    var loadingOverlay = document.getElementById('loadingOverlay');
    loadingOverlay.style.display = 'none';
  }
</script> -->
<?php $this->load->view('templates/jquery_link'); ?>

<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url()?>/assets_system/js/handsontable14.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<?php if ($this->session->userdata('SESS_SUCCESS')) { ?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success',
            subtitle: 'close',
            body: '<?php echo $this->session->userdata('SESS_SUCCESS'); ?>'
        })
    </script>
<?php $this->session->unset_userdata('SESS_SUCCESS');
} ?>

<script>
  var url                 = '<?= base_url() ?>';
  var employee_list       = <?php echo json_encode($DISP_EMPLOYEES); ?>;
  var payroll_summary     = <?php echo json_encode($DISP_PAYROLL_SUMMARY); ?>;
  var leave_types         = <?php echo json_encode($DISP_LEAVE_TYPES); ?>;
  
  // const earningColumns      = ['REG REG', 'REG OT', 'REG ND', 'REG NDOT', 'RST REG', 'RST OT', 'RST ND', 'RST NDOT', 'LEG REG', 'LEG OT', 'LEG ND', 'LEG NDOT', 'RST+LEG REG', 'RST+LEG OT', 'RST+LEG ND', 'RST+LEG NDOT', 'SPE REG', 'SPE OT', 'SPE ND', 'SPE NDOT', 'RST+SPE REG', 'RST+SPE OT', 'RST+SPE ND', 'RST+SPE NDOT', 'Basic Income', 'Gross Income', 'Taxable Income', 'Non-Taxable Income', 'Earn Adjustments', 'Fixed Benefits Earn', 'Total Earnings'];
  // const deductColumns       = ['Absences', 'Tardiness', 'Undertime', 'Underbreak', 'Overbreak', 'Withholding Tax', 'SSS', 'Pagibig', 'PhilHealth','Fixed Benefits Deduct', 'Loans', 'Cash Advances', 'Deduction', 'Deduct Adjustments', 'Total Deductions'];
  // const netColumns          = ['Net Income'];
  // console.log(payroll_summary);

  // new column
  let employee_info = ['Employee ID', 'Employee Name', 'Salary Type', 'Salary Rate', 'Work Days/Year', 'Bank Name', 'Bank Account', 'Monthly Salary', 'Daily Salary', 'Hourly Salary'];
  let basic_salary = ['Regular', 'Paid Leave', 'Absences', 'Tardiness', 'Undertime', 'Underbreak', 'Overbreak', 'Basic Pay'];
  let ot_and_night_diff = ['REG OT', 'REG ND', 'REG NDOT', 'RST REG', 'RST OT', 'RST ND', 'RST NDOT', 'LEG REG', 'LEG OT', 'LEG ND', 'LEG NDOT', 'RST+LEG REG', 'RST+LEG OT', 'RST+LEG ND', 'RST+LEG NDOT', 'SPE REG', 'SPE OT', 'SPE ND', 'SPE NDOT', 'RST+SPE REG', 'RST+SPE OT', 'RST+SPE ND', 'RST+SPE NDOT', 'TOTAL OT PAY'];
  let taxable_allowance = ['Total Taxable Allowance'];
  let nontaxable_allowance = ['Total Non-Taxable Allowance'];
  let adjustments = ['Total Adjustment'];
  let gross_pay = ['Gross Pay']
  let taxable_income = ['Taxable Income'];
  let wtax = ['WTAX'];
  let contributions = ['SSS EE', 'Pagibig EE', 'Philhealth EE', 'Total Contribution'];
  let loans = ['Total Loans'];
  let ca_total = ['Total Cash Advance']
  let deductions = ['Total Deductions'];
  let net_pay = ['Net Pay'];

  let benefitsColums = [];
  const leaveTypes = leave_types.map(item => item.name);

  var combinedData = employee_list.map(function(empData) {

    var combinedRow = {
      id: empData.id,
    };

    let payrollSummary = payroll_summary.find((data) => data.id === empData.id);

    // benefitsColums = payrollSummary.benefits_col.map(item => item.type);
    // let benefitsMap = {};
    // payrollSummary.benefits_col.forEach(item => {
    //   benefitsMap[item.type] = item.value;
    // });

    // benefitsColums.forEach(function (benefitsColumn) {
    //   if (benefitsMap.hasOwnProperty(benefitsColumn)) {
    //     combinedRow[benefitsColumn] = (benefitsMap[benefitsColumn]) ? benefitsMap[benefitsColumn] : "";
    //   }
    // });

    employee_info.forEach(function(info) {
      if (info == "Employee ID") {
        combinedRow[info] = (payrollSummary) ? payrollSummary.cmid : "";
      }
      if (info == "Employee Name") {
        combinedRow[info] = (payrollSummary) ? payrollSummary.fullname : "";
      }
      if (info == "Salary Type") {
        combinedRow[info] = (payrollSummary) ? payrollSummary.salary_type : "";
      }
      if (info == "Salary Rate") {
        combinedRow[info] = (payrollSummary) ? payrollSummary.salary_rate : "";
      }
      if (info == "Work Days/Year") {
        combinedRow[info] = (payrollSummary) ? payrollSummary.workdaysperyear : "";
      }
      if (info == "Bank Name") {
        combinedRow[info] = (payrollSummary) ? payrollSummary.bank_name : "";
      }
      if (info == "Bank Account") {
        combinedRow[info] = (payrollSummary) ? payrollSummary.bank_account : "";
      }
      if (info == "Monthly Salary") {
        combinedRow[info] = (payrollSummary) ? payrollSummary.monthly_salary : "";
      }
      if (info == "Daily Salary") {
        combinedRow[info] = (payrollSummary) ? payrollSummary.daily_salary : "";
      }
      if (info == "Hourly Salary") {
        combinedRow[info] = (payrollSummary) ? payrollSummary.hourly_salary : "";
      }
    })

    basic_salary.forEach(function(basicSalary) {
      if (basicSalary == "Regular") {
        combinedRow[basicSalary] = (payrollSummary) ? payrollSummary.regular_pay : "";
      }
      if (basicSalary == "Paid Leave") {
        combinedRow[basicSalary] = (payrollSummary) ? payrollSummary.paid_leave : "";
      }
      if (basicSalary == "Absences") {
        combinedRow[basicSalary] = (payrollSummary) ? payrollSummary.absent : "";
      }
      if (basicSalary == "Tardiness") {
        combinedRow[basicSalary] = (payrollSummary) ? payrollSummary.tardiness : "";
      }
      if (basicSalary == "Undertime") {
        combinedRow[basicSalary] = (payrollSummary) ? payrollSummary.undertime : "";
      }
      if (basicSalary == "Underbreak") {
        combinedRow[basicSalary] = (payrollSummary) ? payrollSummary.underbreak : "";
      }
      if (basicSalary == "Overbreak") {
        combinedRow[basicSalary] = (payrollSummary) ? payrollSummary.overbreak : "";
      }
      if (basicSalary == "Basic Pay") {
        combinedRow[basicSalary] = (payrollSummary) ? payrollSummary.basic_pay : "";
      }
    })

    ot_and_night_diff.forEach(function(otAndNightDiff) {
      if (otAndNightDiff == "REG OT") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.reg_ot : "";
      }
      if (otAndNightDiff == "REG ND") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.reg_nd : "";
      }
      if (otAndNightDiff == "REG NDOT") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.reg_ndot : "";
      }
      if (otAndNightDiff == "RST REG") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.rest_hour : "";
      }
      if (otAndNightDiff == "RST OT") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.rest_ot : "";
      }
      if (otAndNightDiff == "RST ND") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.rest_nd : "";
      }
      if (otAndNightDiff == "RST NDOT") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.rest_ndot : "";
      }
      if (otAndNightDiff == "LEG REG") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.leg_hours : "";
      }
      if (otAndNightDiff == "LEG OT") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.leg_ot : "";
      }
      if (otAndNightDiff == "LEG ND") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.leg_nd : "";
      }
      if (otAndNightDiff == "LEG NDOT") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.leg_ndot : "";
      }
      if (otAndNightDiff == "RST+LEG REG") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.legrest_hours : "";
      }
      if (otAndNightDiff == "RST+LEG OT") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.legrest_ot : "";
      }
      if (otAndNightDiff == "RST+LEG ND") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.legrest_nd : "";
      }
      if (otAndNightDiff == "RST+LEG NDOT") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.legrest_ndot : "";
      }
      if (otAndNightDiff == "SPE REG") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.spe_hours : "";
      }
      if (otAndNightDiff == "SPE OT") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.spe_ot : "";
      }
      if (otAndNightDiff == "SPE ND") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.spe_nd : "";
      }
      if (otAndNightDiff == "SPE NDOT") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.spe_ndot : "";
      }
      if (otAndNightDiff == "RST+SPE REG") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.sperest_hours : "";
      }
      if (otAndNightDiff == "RST+SPE OT") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.sperest_ot : "";
      }
      if (otAndNightDiff == "RST+SPE ND") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.sperest_nd : "";
      }
      if (otAndNightDiff == "RST+SPE NDOT") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.sperest_ndot : "";
      }
      if (otAndNightDiff == "TOTAL OT PAY") {
        combinedRow[otAndNightDiff] = (payrollSummary) ? payrollSummary.ot_pay : "";
      }


    })

    taxable_allowance.forEach(function(taxableAllo) {
      if (taxableAllo == "Total Taxable Allowance") {
        combinedRow[taxableAllo] = (payrollSummary) ? payrollSummary.tax_allowance_total : "";
      }

    })

    nontaxable_allowance.forEach(function(nontaxableAllo) {
      if (nontaxableAllo = "Total Non-Taxable Allowance") {
        combinedRow[nontaxableAllo] = (payrollSummary) ? payrollSummary.nontax_allowance_total : "";
      }
    })

    adjustments.forEach(function(adjustment) {
      if (adjustment = "Total Adjustment") {
        combinedRow[adjustment] = (payrollSummary) ? payrollSummary.benefits_adjustment : "";
      }
    })

    gross_pay.forEach(function(grossPay) {
      if (grossPay == "Gross Pay") {
        combinedRow[grossPay] = (payrollSummary) ? payrollSummary.gross_income : "";
      }
    })

    taxable_income.forEach(function(taxableIncome) {
      if (taxableIncome == "Taxable Income") {
        combinedRow[taxableIncome] = (payrollSummary) ? payrollSummary.taxable_income : "";
      }
    })

    wtax.forEach(function(wtaxData) {
      if (wtaxData == "WTAX") {
        combinedRow[wtaxData] = (payrollSummary) ? payrollSummary.wtax : "";
      }
    })

    contributions.forEach(function(contribution) {
      if (contribution == "SSS EE") {
        combinedRow[contribution] = (payrollSummary) ? payrollSummary.sss_ee_current : "";
      }
      if (contribution == "Pagibig EE") {
        combinedRow[contribution] = (payrollSummary) ? payrollSummary.pagibig_ee_current : "";
      }
      if (contribution == "Philhealth EE") {
        combinedRow[contribution] = (payrollSummary) ? payrollSummary.philhealth_ee_current : "";
      }
      if (contribution == "Total Contribution") {
        combinedRow[contribution] = (payrollSummary) ? payrollSummary.ee_difference_total : "";
      }
    })

    loans.forEach(function(loan) {
      if (loan == "Total Loans") {
        combinedRow[loan] = (payrollSummary) ? payrollSummary.loan_total : "";
      }
    })

    ca_total.forEach(function(ca_total_data) {
      if (ca_total_data == "Total Cash Advance") {
        combinedRow[ca_total_data] = (payrollSummary) ? payrollSummary.ca_total : "";
      }
    })

    deductions.forEach(function(deduction) {
      if (deduction == "Total Deductions") {
        combinedRow[deduction] = (payrollSummary) ? payrollSummary.deduct_total : "";
      }
    })

    net_pay.forEach(function(net) {
      if (net == "Net Pay") {
        combinedRow[net] = (payrollSummary) ? payrollSummary.net_income : "";
      }
    })


    // leaveTypes.forEach(function(leavetype) {
    //   combinedRow[leavetype] = (payrollSummary) ? payrollSummary.leave_entitlement[leavetype] : "";
    // })

    // earningColumns.forEach(function(earningColumn) {
    //   if (earningColumn == "REG REG") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.reg_hours : "";
    //   }
    //   if (earningColumn == "REG OT") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.reg_ot : "";
    //   }
    //   if (earningColumn == "REG ND") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.reg_nd : "";
    //   }
    //   if (earningColumn == "REG NDOT") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.reg_ndot : "";
    //   }
    //   if (earningColumn == "RST REG") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.rest_hour : "";
    //   }
    //   if (earningColumn == "RST OT") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.rest_ot : "";
    //   }
    //   if (earningColumn == "RST ND") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.rest_nd : "";
    //   }
    //   if (earningColumn == "RST NDOT") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.rest_ndot : "";
    //   }
    //   if (earningColumn == "LEG REG") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.leg_hours : "";
    //   }
    //   if (earningColumn == "LEG OT") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.leg_ot : "";
    //   }
    //   if (earningColumn == "LEG ND") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.leg_nd : "";
    //   }
    //   if (earningColumn == "LEG NDOT") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.leg_ndot : "";
    //   }
    //   if (earningColumn == "RST+LEG REG") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.legrest_hours : "";
    //   }
    //   if (earningColumn == "RST+LEG OT") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.legrest_ot : "";
    //   }
    //   if (earningColumn == "RST+LEG ND") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.legrest_nd : "";
    //   }
    //   if (earningColumn == "RST+LEG NDOT") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.legrest_ndot : "";
    //   }
    //   if (earningColumn == "SPE REG") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.spe_hours : "";
    //   }
    //   if (earningColumn == "SPE OT") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.spe_ot : "";
    //   }
    //   if (earningColumn == "SPE ND") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.spe_nd : "";
    //   }
    //   if (earningColumn == "SPE NDOT") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.spe_ndot : "";
    //   }
    //   if (earningColumn == "RST+SPE REG") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.sperest_hours : "";
    //   }
    //   if (earningColumn == "RST+SPE OT") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.sperest_ot : "";
    //   }
    //   if (earningColumn == "RST+SPE ND") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.sperest_nd : "";
    //   }
    //   if (earningColumn == "RST+SPE NDOT") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.sperest_ndot : "";
    //   }
    //   if (earningColumn == "Basic Income") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.basic_pay : "";
    //   }
    //   if (earningColumn == "Gross Income") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.gross_income : "";
    //   }

    //   if (earningColumn == "Taxable Income") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.tax_allowance_total : "";
    //   }
    //   if (earningColumn == "Non-Taxable Income") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.nontax_allowance_total : "";
    //   }
    //   if (earningColumn == "Earn Adjustments") {
    //     combinedRow[earningColumn] = '0.00';
    //   }
    //   if (earningColumn == "Fixed Benefits Earn") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.fixed_benefits_earn : "";
    //   }
    //   if (earningColumn == "Total Earnings") {
    //     combinedRow[earningColumn] = (payrollSummary) ? payrollSummary.earnings : "";
    //   }
    // })
    // deductColumns.forEach(function(deductColumn) {
    //   if (deductColumn == "Absences") {
    //     combinedRow[deductColumn] = (payrollSummary) ? payrollSummary.absent : "";
    //   }
    //   if (deductColumn == "Tardiness") {
    //     combinedRow[deductColumn] = (payrollSummary) ? payrollSummary.tardiness : "";
    //   }
    //   if (deductColumn == "Undertime") {
    //     combinedRow[deductColumn] = (payrollSummary) ? payrollSummary.undertime : "";
    //   }
    //   if (deductColumn == "Underbreak") {
    //     combinedRow[deductColumn] = (payrollSummary) ? payrollSummary.underbreak : "";
    //   }
    //   if (deductColumn == "Overbreak") {
    //     combinedRow[deductColumn] = (payrollSummary) ? payrollSummary.overbreak : "";
    //   }
    //   if (deductColumn == "Withholding Tax") {
    //     combinedRow[deductColumn] = (payrollSummary) ? payrollSummary.wtax : "";
    //   }
    //   if (deductColumn == "SSS") {
    //     combinedRow[deductColumn] = (payrollSummary) ? payrollSummary.sss_ee_current : "";
    //   }
    //   if (deductColumn == "Pagibig") {
    //     combinedRow[deductColumn] = (payrollSummary) ? payrollSummary.pagibig_ee_current : "";
    //   }
    //   if (deductColumn == "PhilHealth") {
    //     combinedRow[deductColumn] = (payrollSummary) ? payrollSummary.philhealth_ee_current : "";
    //   }
    //   if (deductColumn == "Fixed Benefits Deduct") {
    //     combinedRow[deductColumn] = (payrollSummary) ? payrollSummary.fixed_benefits_deduct : "";
    //   }
    //   if (deductColumn == "Loans") {
    //     combinedRow[deductColumn] = (payrollSummary) ? payrollSummary.loan_total : "";
    //   }
    //   if (deductColumn == "Cash Advances") {
    //     combinedRow[deductColumn] = (payrollSummary) ? payrollSummary.ca_total : "";
    //   }
    //   if (deductColumn == "Deduction") {
    //     combinedRow[deductColumn] = (payrollSummary) ? payrollSummary.deduct_total : "";
    //   }
    //   if (deductColumn == "Deduct Adjustments") {
    //     combinedRow[deductColumn] = '0.00';
    //   }
    //   if (deductColumn == "Total Deductions") {
    //     combinedRow[deductColumn] = (payrollSummary) ? payrollSummary.deductions : "";
    //   }
    // })
    net_pay.forEach(function(netColumn) {
      if (netColumn == "Net Pay") {
        combinedRow[netColumn] = (payrollSummary) ? payrollSummary.net_income : "";
      }
    })


    combinedRow.isSelected = false;
    return combinedRow;
  });
  const customCheckboxRenderer = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.CheckboxRenderer.apply(this, arguments);
    td.style.textAlign = 'center';
    td.style.verticalAlign = 'middle';
  };
  let customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.style.whiteSpace = 'nowrap';
    td.style.overflow = 'hidden';
  };

  let amount_custom = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.style.whiteSpace = 'nowrap';
    td.style.overflow = 'hidden';
    td.style.textAlign = 'right';
    td.innerHTML = '<span style="float: left;">&#8369;</span>' + value;
  };


  let columns = [];
  columns.push({
    data: 'id',
    type: 'text',
    title: 'ID',
  });
  columns.push({
    data: 'isSelected',
    type: 'checkbox',
    renderer: customCheckboxRenderer,
    readOnly: false,
  });

  employee_info.forEach(function(employeeinfoColumn) {
    let render_data = "";
    if(employeeinfoColumn == "Salary Rate" || employeeinfoColumn == "Monthly Salary" || employeeinfoColumn == "Daily Salary" || employeeinfoColumn == "Hourly Salary"){
      render_data  = amount_custom;
    }else{
      render_data = customStyleRenderer_new;
    }
    columns.push({
      data: employeeinfoColumn,
      renderer: render_data,
    })
  })

  basic_salary.forEach(function(salaryColumn) {
    columns.push({
      data: salaryColumn,
      type: 'text',
      title: salaryColumn,
      renderer: amount_custom,
    });
  });
  ot_and_night_diff.forEach(function(otNightColumn) {
    columns.push({
      data: otNightColumn,
      type: 'text',
      title: otNightColumn,
      renderer: amount_custom,
    });
  });


  taxable_allowance.forEach(function(taxable_allowance_col) {
    columns.push({
      data: taxable_allowance_col,
      type: 'text',
      title: taxable_allowance_col,
      renderer: amount_custom,
    });
  });

  nontaxable_allowance.forEach(function(nontaxable_allowance_col) {
    columns.push({
      data: nontaxable_allowance_col,
      type: 'text',
      title: nontaxable_allowance_col,
      renderer: amount_custom,
    });
  });

  adjustments.forEach(function(adjustment) {
    columns.push({
      data: adjustment,
      type: 'text',
      title: adjustment,
      renderer: amount_custom,
    });
  });

  gross_pay.forEach(function(gross_pay_col) {
    columns.push({
      data: gross_pay_col,
      renderer: amount_custom,
    });
  });

  taxable_income.forEach(function(taxable_income_col) {
    columns.push({
      data: taxable_income_col,
      renderer: amount_custom,
    });
  })

  wtax.forEach(function(wtax_col) {
    columns.push({
      data: wtax_col,
      renderer: amount_custom,
    });
  })

  contributions.forEach(function(contribution_col) {
    columns.push({
      data: contribution_col,
      renderer: amount_custom,
    });
  })

  loans.forEach(function(loan_col) {
    columns.push({
      data: loan_col,
      renderer: amount_custom,
    });
  })

  ca_total.forEach(function(ca_total_col) {
    columns.push({
      data: ca_total_col,
      renderer: amount_custom,
    });
  })

  deductions.forEach(function(deduction_col) {
    columns.push({
      data: deduction_col,
      renderer: amount_custom,
    });
  })

  net_pay.forEach(function(net_pay_col) {
    columns.push({
      data: net_pay_col,
      renderer: amount_custom,
    });
  })



  // net_pay.forEach(function(net_pay_col) {
  //   columns.push({
  //     data: net_pay_col,
  //     renderer: customStyleRenderer_new,
  //   });
  // });
  

  const afterGetColHeader = function(instance, TH, row, col, prop) {
    // if (TH.textContent === 'Earnings' || TH.textContent === 'REG REG' || TH.textContent === 'REG OT' || TH.textContent === 'REG ND' || TH.textContent === 'REG NDOT' || TH.textContent === 'RST REG' || TH.textContent === 'RST OT' || TH.textContent === 'RST ND' || TH.textContent === 'RST NDOT' || TH.textContent === 'LEG REG' || TH.textContent === 'LEG OT' || TH.textContent === 'LEG ND' || TH.textContent === 'LEG NDOT' || TH.textContent === 'RST+LEG REG' || TH.textContent === 'RST+LEG OT' || TH.textContent === 'RST+LEG ND' || TH.textContent === 'RST+LEG NDOT' || TH.textContent === 'SPE REG' || TH.textContent === 'SPE OT' || TH.textContent === 'SPE ND' || TH.textContent === 'SPE NDOT' || TH.textContent === 'RST+SPE REG' || TH.textContent === 'RST+SPE OT' || TH.textContent === 'RST+SPE ND' || TH.textContent === 'RST+SPE NDOT' || TH.textContent === 'Basic Income' || TH.textContent === 'Gross Income' || TH.textContent === 'Taxable Income' || TH.textContent === 'Non-Taxable Income' || TH.textContent === 'Earn Adjustments' || TH.textContent === 'Fixed Benefits Earn' || TH.textContent === 'Total Earnings') {
    //   TH.style.backgroundColor = '#DAFFDA';
    // }
    // if (TH.textContent === 'Deductions' || TH.textContent === 'Absences' || TH.textContent === 'Tardiness' || TH.textContent === 'Undertime' || TH.textContent === 'Underbreak' || TH.textContent === 'Overbreak' || TH.textContent === 'Withholding Tax' || TH.textContent === 'SSS' || TH.textContent === 'Pagibig' || TH.textContent === 'PhilHealth' || TH.textContent === 'Fixed Benefits Deduct' || TH.textContent === 'Loans' || TH.textContent === 'Cash Advances' || TH.textContent === 'Deduction' || TH.textContent === 'Deduct Adjustments' || TH.textContent === 'Total Deductions') {
    //   TH.style.backgroundColor = '#FFDADA';
    // }
  };

  const selectHeaderLabel = `<input type="checkbox" id="checkAllCheckbox" >`;
  const container = document.querySelector('#table_data_new');
  hot = new Handsontable(container, {
    data: combinedData,
    colHeaders: true,
    rowHeaders: true,
    height: 'auto',
    colWidths: 100,
    nestedHeaders: [
      ['ID', 'Select', {
          label: 'Employee Info',
          colspan: employee_info.length,
        },
        {
          label: 'Basic Salary',
          colspan: basic_salary.length,
          type: 'numeric',
          format: '0,0.00',
        },
        {
          label: 'OT / Night Differential',
          colspan: ot_and_night_diff.length,
        },

        {
          label: 'Taxable Allowance',
          colspan: taxable_allowance.length,
        },

        {
          label: 'Non-Taxable Allowance',
          colspan: nontaxable_allowance.length,
        },
        
        {
          label: 'Adjustment',
          colspan: adjustments.length,
        },

        {
          label: 'Gross',
          colspan: gross_pay.length,
        },
        {
          label: 'Taxable',
          colspan: taxable_income.length,
        },
        {
          label: 'Withholding Tax',
          colspan: wtax.length,
        },

        {
          label: 'Contributions',
          colspan: contributions.length,
        },
        {
          label: 'Loans',
          colspan: loans.length,
        },

        {
          label: 'Cash Advance',
          colspan: ca_total.length,
        },
        {
          label: 'Deductions',
          colspan: deductions.length,
        },
        {
          label: 'NET',
          colspan: net_pay.length,
        },
      ],

      ['ID', selectHeaderLabel, ...employee_info, ...basic_salary, ...ot_and_night_diff, ...taxable_allowance, ...nontaxable_allowance, ...adjustments, ...gross_pay, ...taxable_income, ...wtax, ...contributions, ...loans, ...ca_total, ...deductions, ...net_pay],
    ],
    outsideClickDeselects: false,
    selectionMode: 'multiple',
    licenseKey: 'non-commercial-and-evaluation',
    renderer: customStyleRenderer_new,
    readOnly: true,
    hiddenColumns: {
      columns: [0],
    },
    afterGetColHeader: afterGetColHeader,
    columns: columns,
  });
  hot.updateSettings({
    height: window.innerHeight - container.getBoundingClientRect().top - 50,
  });
  // hot.addHook('afterRender', afterRenderFunction);
  document.addEventListener('change', function(event) {
    if (event.target.id === 'checkAllCheckbox') {
      let isChecked = event.target.checked;

      for (const data of combinedData) {

        if (data.isSelected !== isChecked) {
          data.isSelected = true;
        } else {
          data.isSelected = false;
        }
      }
      hot.render();
    }
    if (event.target.type === 'checkbox') {
      const checkbox = document.querySelector('#checkAllCheckbox');
      const allChecked = combinedData.every(data => data.isSelected);
      document.getElementById('checkAllCheckbox').checked = allChecked;
    }
  });
  const payFrequency = "<?= $SPECIFIC_PAYROLL_SCHEDULES->pay_frequency ?>";
  const selectElement = document.getElementById("pay_freq");
  for (let i = 0; i < selectElement.options.length; i++) {
    if (selectElement.options[i].value === payFrequency) {
      selectElement.selectedIndex = i;
      break;
    }
  }
  var url = '<?= base_url() ?>';
  let generate = document.getElementById('btn-generate-payslip');
  generate.addEventListener('click', function() {
    const confirmed = confirm('Are you sure you want to update the data?');
    if (!confirmed) {
      return;
    }
    const generate_payslip = hot.getData();
    // const filteredArray = generate_payslip.filter(item => item[1] === true);
    const checked_ids = generate_payslip.filter(item => item[1] === true).map(item => item[0]);
    const filteredPayrollSummary = payroll_summary.filter(item => checked_ids.includes(item.id));
    // console.log(filteredPayrollSummary);
    fetch(url + 'payrolls/generate_payslips', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(filteredPayrollSummary)
      })
      .then(response => response.json())
      .then(result => {
        // console.log(result);
        if (result.success_message) {
          $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success!',
            subtitle: 'close',
            body: result.success_message
          })
          setTimeout(function() {
            location.reload();
          }, 1500);
        }
        if (result.warning_message) {
          $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: result.warning_message
          })
        }
      })
      .catch(error => {
        $(document).Toasts('create', {
          class: 'bg-warning toast_width',
          title: 'Warning!',
          subtitle: 'close',
          body: 'Something wrong. Please inform your system administrator.'
        })
        console.error('Data update error:', error);
      });
  })
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
      window.location = base_url + "payrolls/payroll_summary" + page_row;
    }
    $('select.cut_off_period').on('change', function() {
      let tab = '<?=$TAB?>'
      
      window.location.href = "<?= base_url('payrolls/payroll_summary?period=') ?>" + $(this).val() + '&tab='+tab
    })

    let btnUpdate = document.getElementById('btn-update');
    let formId = document.getElementById('payroll_contribution_form');
    btnUpdate.addEventListener('click', function(){
      formId.submit();
    })
  })
</script>

<<script src="<?php echo base_url()?>/assets_system/js/xlsx.full.min.js"></script>

<script>
  function exportToExcel() {
    const cutoffSelect = document.getElementById('cut_off_period');
    const cutoffValue = cutoffSelect.value;
    const cutoffText = cutoffSelect.options[cutoffSelect.selectedIndex].text;

    const allHeaders = hot.getSettings().nestedHeaders[1]; // detailed headers
    const allData = hot.getData();
    const hiddenCols = hot.getSettings().hiddenColumns.columns || [];

    // Skip first 2 columns: ID (0) and Select (1)
    const skipColumns = [0, 1, ...hiddenCols];

    const visibleColumnIndices = allHeaders
      .map((_, index) => index)
      .filter(index => !skipColumns.includes(index));

    // Visible headers only
    const visibleHeaders = visibleColumnIndices.map(index => allHeaders[index]);

    // Visible data only
    const visibleData = allData.map(row =>
      row.filter((_, colIndex) => visibleColumnIndices.includes(colIndex))
    );

    // Build Excel
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.aoa_to_sheet([visibleHeaders, ...visibleData]);
    const filename = `Payslip_Ready_Detail_${cutoffText.replace(/\s+/g, '_')}.xlsx`;
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
    XLSX.writeFile(wb, filename);
  }
</script>



</body>

</html>