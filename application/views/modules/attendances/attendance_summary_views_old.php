<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />

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
        <h1 class="page-title" id="page_title"><a href="<?= base_url() . 'attendances'; ?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Attendance Summary<h1>
      </div>

      <div class="col-md-6 button-title">
        <a href="<?= base_url('attendances/add_attendance_summary') ?>" class="btn btn-success" id="btn-add-row"><i class="fa-solid fa-circle-plus"></i>&nbsp;Add Data</a>
        <a href="<?= base_url('attendances/edit_attendance_summary') ?>" class="btn btn-primary" id="btn-update"><i class="fa-duotone fa-pen-to-square"></i>&nbsp;Edit Data</a>
      </div>
    </div>

    <div class=" py-3 w-25">
      <p class="p-0 my-1 text-bold">Cut-off Period</p>
      <select class="form-control cut_off_period" id="cut_off_period">
        <?php foreach ($CUTOFF_PERIODS as $cut_off) { ?>
          <option value="<?= $cut_off->id ?>" <?= $PERIOD == $cut_off->id ? 'selected' : '' ?>><?= $cut_off->name ?></option>
        <?php } ?>
      </select>
    </div>

    <div class='d-flex justify-content-end mr-1'>
      <button class="btn btn-primary" id="btn-insert"><i class="fa-solid fa-circle-arrow-up"></i>&nbsp;Endorse to Payroll</button>
      <button type="button" class="btn btn-primary ml-1" data-toggle="modal" data-target="#settingsModal" id="hide_col_btn"><i class="fa-duotone fa-eye-slash"></i>&nbsp;Hide Columns</button>
      <button type="button" class="btn btn-primary ml-1" id="printButton" onclick="changeTitle()"><i class="fa-duotone fa-print"></i>&nbsp;Print</button>
    </div>

    <div class="card border-0 p-0 m-0">
      <div class="card border-0 p-1 m-0">
        <div class="card-header d-none p-0">
          <div class="row ">
            <div class="col-xl-8 ">
            </div>

            <div class="col-xl-4">
              <div class="input-group pb-1">
                <?php
                if ($search_data) { ?>
                  <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fa-regular fa-broom-wide" style="margin-top: 4px"></i>&nbsp;Clear</button>
                <?php } else { ?>
                  <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
                <?php } ?>
                <input type="text" class="form-control" placeholder="Search..." value="<?= ($search_data) ? $search_data : "" ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
              </div>
            </div>
          </div>
        </div>
        <div class="p-2">
          <div>
            <div class='col d-flex justify-content-end align-items-center'>

              <ul class="d-inline pagination m-0 p-0 ">
                <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                <ul class="d-inline pagination m-0 p-0 ">
                  <li><a class="page_row" <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>< </a></li>
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
            </div>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  const selectAllCheckbox  = document.getElementById("selectAllCheckbox");
  const columnCheckboxes   = document.querySelectorAll(".column-checkbox");

  selectAllCheckbox.addEventListener("change", function() {
    const selectAllChecked = selectAllCheckbox.checked;
    columnCheckboxes.forEach(function(checkbox) {
      checkbox.checked     = selectAllChecked;
    });
  });

  document.getElementById("saveButton").addEventListener("click", function() {
    const selectedColumns  = [];

    columnCheckboxes.forEach(function(checkbox) {
      if (checkbox.checked) {
        selectedColumns.push(checkbox.nextElementSibling.textContent);
      }
    });
    let columns            = [0];

    if (selectedColumns.includes("Employee")) {
      columns              = [...columns, 1, 2]
    }

    if (selectedColumns.includes("Attendance Record")) {
      const start          = 3;
      const length         = dateHeaders.length;
      columns              = [...columns, ...Array.from({
        length
      }, (_, i) => start + i)];
    }

    if (selectedColumns.includes("Absences")) {
      const start          = 3 + dateHeaders.length;
      const length         = attendanceAbsences.length;
      columns              = [...columns, ...Array.from({
        length
      }, (_, i) => start + i)];
    }

    if (selectedColumns.includes("Deductions")) {
      const start          = 3 + dateHeaders.length + attendanceAbsences.length;
      const length         = attendanceDeductions.length;
      columns              = [...columns, ...Array.from({
        length
      }, (_, i) => start + i)];
    }

    if (selectedColumns.includes("REGULAR")) {
      const start          = 3 + dateHeaders.length + attendanceAbsences.length + attendanceDeductions.length;
      const length         = typeREG.length;
      columns              = [...columns, ...Array.from({
        length
      }, (_, i) => start + i)];
    }

    if (selectedColumns.includes("REST")) {
      const start          = 3 + dateHeaders.length + attendanceAbsences.length + attendanceDeductions.length + typeREG.length;
      const length         = typeRST.length;
      columns              = [...columns, ...Array.from({
        length
      }, (_, i) => start + i)];
    }

    if (selectedColumns.includes("LEGAL")) {
      const start          = 3 + dateHeaders.length + attendanceAbsences.length + attendanceDeductions.length + typeREG.length + typeRST.length;
      const length         = typeLEG.length;
      columns              = [...columns, ...Array.from({
        length
      }, (_, i) => start + i)];
    }

    if (selectedColumns.includes("REST+LEGAL")) {
      const start          = 3 + dateHeaders.length + attendanceAbsences.length + attendanceDeductions.length + typeREG.length + typeRST.length + typeLEG.length;
      const length         = typeRST_LEG.length;
      columns              = [...columns, ...Array.from({
        length
      }, (_, i) => start + i)];
    }

    if (selectedColumns.includes("SPECIAL")) {
      const start          = 3 + dateHeaders.length + attendanceAbsences.length + attendanceDeductions.length + typeREG.length + typeRST.length + typeLEG.length + typeRST_LEG.length;
      const length         = typeSPE.length;
      columns              = [...columns, ...Array.from({
        length
      }, (_, i) => start + i)];
    }

    if (selectedColumns.includes("REST+SPECIAL")) {
      const start          = 3 + dateHeaders.length + attendanceAbsences.length + attendanceDeductions.length + typeREG.length + typeRST.length + typeLEG.length + typeRST_LEG.length + typeSPE.length;
      const length         = typeRST_SPE.length;
      columns              = [...columns, ...Array.from({
        length
      }, (_, i) => start + i)];
    }

    if (selectedColumns.includes("Subsidy")) {
      const start          = 3 + dateHeaders.length + attendanceAbsences.length + attendanceDeductions.length + typeREG.length + typeRST.length + typeLEG.length + typeRST_LEG.length + typeSPE.length + typeRST_SPE.length;
      const length         = extendColumns.length;
      columns              = [...columns, ...Array.from({
        length
      }, (_, i) => start + i)];
    }

    if (selectedColumns.includes("Dynamic Incentives")) {
      const start          = 3 + dateHeaders.length + attendanceAbsences.length + attendanceDeductions.length +
        typeREG.length + typeRST.length + typeLEG.length + typeRST_LEG.length + typeSPE.length + typeRST_SPE.length + extendColumns.length;
      const length         = dynamicTypeHeaders.length;
      columns              = [...columns, ...Array.from({
        length
      }, (_, i) => start + i)];
    }

    if (selectedColumns.includes("Fixed Incentives")) {
      const start          = 3 + dateHeaders.length + attendanceAbsences.length + attendanceDeductions.length +
        typeREG.length + typeRST.length + typeLEG.length + typeRST_LEG.length + typeSPE.length + typeRST_SPE.length + extendColumns.length + dynamicTypeHeaders.length;
      const length         = benefitsTypeHeaders.length;
      columns              = [...columns, ...Array.from({
        length
      }, (_, i) => start + i)];
    }

    if (selectedColumns.includes("Adjustment")) {
      const start          = 3 + dateHeaders.length + attendanceAbsences.length + attendanceDeductions.length +
        typeREG.length + typeRST.length + typeLEG.length + typeRST_LEG.length + typeSPE.length + typeRST_SPE.length + extendColumns.length + dynamicTypeHeaders.length + benefitsTypeHeaders.length;
      const length         = adjustmentTypeHeaders.length;
      columns              = [...columns, ...Array.from({
        length
      }, (_, i) => start + i)];
    }

    hot.updateSettings({
      hiddenColumns: {
        columns
      }
    });
    $('#settingsModal').modal('hide');
  });
</script>

<script>
  var url                    = '<?= base_url() ?>';
  var employee_list          = <?php echo json_encode($DISP_EMPLOYEES); ?>;
  var cutoff_period          = <?php echo json_encode($CUTOFF_PERIOD); ?>;
  var log_in_out             = <?php echo json_encode($DISP_EMPLOYEES_ATTENDANCE_LOG); ?>;
  var log_shift_in_out       = <?php echo json_encode($DISP_EMPLOYEES_SHIFT); ?>;
  var benefits_type          = <?php echo json_encode($DISP_BENEFITS_BENEFITS_TYPE); ?>;
  var adjustment_type        = <?php echo json_encode($DISP_BENEFITS_ADJUSTMENT_TYPE); ?>;
  var dynamic_type           = <?php echo json_encode($DISP_BENEFITS_DYNAMIC_TYPE); ?>;
  var benefits_dynamic       = <?php echo json_encode($DISP_BENEFITS_DYNAMIC); ?>;
  var employeeListAssign     = <?php echo json_encode($DISP_EMPLOYEELIST_ASSIGN); ?>;
  var dynamic_std            = <?php echo json_encode($DISP_DYNAMIC_STD); ?>;
  var fixed_assign           = <?php echo json_encode($DISP_BENEFITS_FIXED_ASSIGN); ?>;
  var adjustment_assign      = <?php echo json_encode($DISP_BENEFITS_ADJUSTMENT_ASSIGN); ?>;
  var approved_ot            = <?php echo json_encode($DISP_ALL_APPROVED_OT); ?>;
  var benefit_loan           = <?php echo json_encode($DISP_BENEFITS_LOAN); ?>;
  var leave_assigns          = <?php echo json_encode($LEAVE_ASSIGNS); ?>;
  var leave_names            = <?php echo json_encode($DISP_LEAVE_NAMES); ?>;
  var holidays               = <?php echo json_encode($DISP_HOLIDAYS); ?>;
  var zkteco_attendance_data = <?php echo json_encode($DISP_ZKTECO_ATTENDANCE_DATA); ?>;
  var hot;

  var dynamicTypeMap         = {};
  dynamic_type.forEach(function(item) {
    dynamicTypeMap[item.id]  = item.name;
  });

  var dynamicStdMap          = {};
  dynamic_std.forEach(function(item) {
    dynamicStdMap[item.name] = parseFloat(item.value);
  });

  function getLeaveNameByType(leaveType) {
    const leave = leave_names.find(leave => leave.id === leaveType);
    return leave ? leave.name : 'Unknown';
  }

  var multipliedData         = benefits_dynamic.map(function(benefit) {

    var employee             = employeeListAssign.find(function(employee) {
      return employee.id === benefit.user_id;
    });

    if (employee && dynamicStdMap[employee.category]) {
      var count              = parseInt(benefit.count);
      var categoryValue      = dynamicStdMap[employee.category];
      var multipliedValue    = count * categoryValue;

      var typeName           = dynamicTypeMap[benefit.type];

      return {
        id: employee.id,
        col_empl_cmid: employee.col_empl_cmid,
        fullname: employee.fullname,
        multipliedValue: multipliedValue.toFixed(2),
        typeName: typeName
      };
    } else {
      return null;
    }
  })

  const fromDate              = new Date(cutoff_period.date_from);
  const toDate                = new Date(cutoff_period.date_to);
  const dateHeaders           = [];

  const presentColumns        = ['Present (day/s)'];
  const extendColumns         = ['Rice Subsidy', 'OT Meal', 'Rice Reward', 'RCBC Loan'];
  const attendanceAbsences    = ['PAID', 'LWOP', 'AWOL'];
  const attendanceDeductions  = ['TARD', 'UT', 'EARB', 'OVRB'];

  const typeREG               = ['REG REG', 'REG OT', 'REG ND', 'REG NDOT'];
  const typeRST               = ['RST REG', 'RST OT', 'RST ND', 'RST NDOT'];
  const typeLEG               = ['LEG REG', 'LEG OT', 'LEG ND', 'LEG NDOT'];
  const typeRST_LEG           = ['RST+LEG REG', 'RST+LEG OT', 'RST+LEG ND', 'RST+LEG NDOT'];
  const typeSPE               = ['SPE REG', 'SPE OT', 'SPE ND', 'SPE NDOT'];
  const typeRST_SPE           = ['RST+SPE REG', 'RST+SPE OT', 'RST+SPE ND', 'RST+SPE NDOT'];

  const benefitsTypeHeaders   = benefits_type.map(item => item.name);
  const dynamicTypeHeaders    = dynamic_type.map(item => item.name);
  const adjustmentTypeHeaders = adjustment_type.map(item => item.name);

  while (fromDate <= toDate) {
    dateHeaders.push(fromDate.toISOString().split('T')[0]);
    fromDate.setDate(fromDate.getDate() + 1);
  }

  var combinedData  = employee_list.map(function(empData) {
    var combinedRow = {
      id: empData.id,
      col_empl_cmid: empData.col_empl_cmid,
      full_name: empData.fullname
    };

    worked_hours    = 0;
    rice_subsidy    = 0;
    ot_meal         = 0;
    rice_reward     = 0;

    let ot_data     = 0;
    let loan_amount = 0;
    let loan_term   = 0;

    let totalPaid   = 0;
    let totalLWOP   = 0;

    let absent      = 0;
    let awol        = 0;

    let hol_code    = "REGULAR";

    dateHeaders.forEach(function(dateHeader) {
      const logs         = log_in_out.find(item => item.date === dateHeader && item.empl_id === empData.id);
      const shift        = log_shift_in_out.find(item => item.date === dateHeader && item.empl_id === empData.id);
      const leave_assign = leave_assigns.find(item => item.leave_date === dateHeader && item.empl_id == empData.id)
      const ot           = approved_ot.find(item => item.date_ot === dateHeader && item.empl_id === empData.id);
      const loan         = benefit_loan.find(item => item.loan_date === dateHeader && item.empl_id === empData.id);
      const holiday      = holidays.find(item => item.col_holi_date === dateHeader)

      if (holiday) {
        if (holiday.col_holi_type == "Regular Holiday") {
          hol_code = "LEGAL";
        } else {
          hol_code = "SPECIAL";
        }
      }

      if (loan) {
        loan_amount += parseInt(loan.loan_amount);
        loan_term += parseInt(loan.loan_terms)
      }

      if (ot) {
        ot_data = ot.hours;
      }

      if (leave_assign) {
        if (getLeaveNameByType(leave_assign.type) == "Leave Without Pay") {
          totalLWOP += parseInt(leave_assign.duration);
        } else {
          totalPaid += parseInt(leave_assign.duration);
        }
      }

      if (shift && !logs) {
        absent += parseInt(shift.time_regular_reg);
      }

      if (shift) {
        if (hol_code == "REGULAR" && shift.code != "REST") {

        }
      }

      combinedRow[dateHeader] = "";

    });

    dateHeaders.forEach(function(dateHeader, index) {
      const attendanceData = zkteco_attendance_data.find((data) => data.id === empData.id);

      if (attendanceData) {
        const reg_hrs = attendanceData.reg_hrs[index];
        const paid_leaves = attendanceData.paid_leaves[index];
        const overtime = attendanceData.overtime[index];

        if (reg_hrs !== 0) {
          combinedRow[dateHeader] = `${reg_hrs}`;
        }

        if (overtime) {
          if (combinedRow[dateHeader]) {
            combinedRow[dateHeader] += ` (${overtime})`;
          } else {
            combinedRow[dateHeader] = `(${overtime})`;
          }
        }

        if (paid_leaves) {
          if (combinedRow[dateHeader]) {
            combinedRow[dateHeader] += `[${paid_leaves}]`;
          } else {
            combinedRow[dateHeader] = `[${paid_leaves}]`;
          }
        }
      }
    });

    presentColumns.forEach(function(presentColumn) {
      if (presentColumn == "Present (day/s)") {
        combinedRow[presentColumn] = '';
      }
    })

    awol = absent - totalLWOP - totalPaid;

    attendanceAbsences.forEach(function(attendanceAbsence) {
      if (attendanceAbsence == "PAID") {
        if (totalPaid) {
          combinedRow[attendanceAbsence] = totalPaid;
        } else {
          combinedRow[attendanceAbsence] = '';
        }
      }

      if (attendanceAbsence == "LWOP") {
        if (totalLWOP) {
          combinedRow[attendanceAbsence] = totalLWOP;
        } else {
          combinedRow[attendanceAbsence] = '';
        }
      }

      if (attendanceAbsence == "AWOL") {
        if (awol) {
          combinedRow[attendanceAbsence] = awol;
        } else {
          combinedRow[attendanceAbsence] = '';
        }
      }
    })

    attendanceDeductions.forEach(function(attendanceDeduction) {
      if (attendanceDeduction == "TARD") {
        combinedRow[attendanceDeduction] = '';
      }

      if (attendanceDeduction == "UT") {
        combinedRow[attendanceDeduction] = '';
      }

      if (attendanceDeduction == "EARB") {
        combinedRow[attendanceDeduction] = '';
      }

      if (attendanceDeduction == "OVRB") {
        combinedRow[attendanceDeduction] = '';
      }
    });

    $reg_reg             = "";
    $leg_reg             = "";
    $rst_leg_reg         = "";
    $sum_spe_hours       = "";
    $sum_sperest_hours   = "";

    const attendances    = zkteco_attendance_data.find((data) => data.id === empData.id);
    if (attendances) {
      $reg_reg           = attendances.sum_reg_hours;
      $leg_reg           = attendances.sum_leg_hours;
      $rst_leg_reg       = attendances.sum_legrest_hours;
      $sum_spe_hours     = attendances.sum_spe_hours;
      $sum_sperest_hours = attendances.sum_sperest_hours;
    }

    typeREG.forEach(function(regRow) {
      if (regRow == "REG REG") {
        combinedRow[regRow] = ($reg_reg) ? $reg_reg : "";
      }

      if (regRow == "REG OT") {
        combinedRow[regRow] = '';
      }

      if (regRow == "REG ND") {
        combinedRow[regRow] = '';
      }

      if (regRow == "REG NDOT") {
        combinedRow[regRow] = '';
      }
    })

    typeRST.forEach(function(rstRow) {
      if (rstRow == "RST REG") {
        combinedRow[rstRow] = '';
      }

      if (rstRow == "RST OT") {
        combinedRow[rstRow] = '';
      }

      if (rstRow == "RST ND") {
        combinedRow[rstRow] = '';
      }

      if (rstRow == "RST NDOT") {
        combinedRow[rstRow] = '';
      }
    })

    typeLEG.forEach(function(rstRow) {
      if (rstRow == "LEG REG") {
        combinedRow[rstRow] = ($leg_reg) ? $leg_reg : "";
      }

      if (rstRow == "LEG OT") {
        combinedRow[rstRow] = '';
      }

      if (rstRow == "LEG ND") {
        combinedRow[rstRow] = '';
      }

      if (rstRow == "LEG NDOT") {
        combinedRow[rstRow] = '';
      }
    })

    typeRST_LEG.forEach(function(rstRow) {
      if (rstRow == "RST+LEG REG") {
        combinedRow[rstRow] = ($rst_leg_reg) ? $rst_leg_reg : "";
      }

      if (rstRow == "RST+LEG OT") {
        combinedRow[rstRow] = '';
      }

      if (rstRow == "RST+LEG ND") {
        combinedRow[rstRow] = '';
      }

      if (rstRow == "RST+LEG NDOT") {
        combinedRow[rstRow] = '';
      }
    })

    typeSPE.forEach(function(rstRow) {
      if (rstRow == "SPE REG") {
        combinedRow[rstRow] = ($sum_spe_hours) ? $sum_spe_hours : "";
      }

      if (rstRow == "SPE OT") {
        combinedRow[rstRow] = '';
      }

      if (rstRow == "SPE ND") {
        combinedRow[rstRow] = '';
      }

      if (rstRow == "SPE NDOT") {
        combinedRow[rstRow] = '';
      }
    })

    typeRST_SPE.forEach(function(rstRow) {
      if (rstRow == "RST+SPE REG") {
        combinedRow[rstRow] = ($sum_sperest_hours) ? $sum_sperest_hours : "";
      }

      if (rstRow == "RST+SPE OT") {
        combinedRow[rstRow] = '';
      }

      if (rstRow == "RST+SPE ND") {
        combinedRow[rstRow] = '';
      }

      if (rstRow == "RST+SPE NDOT") {
        combinedRow[rstRow] = '';
      }
    })

    extendColumns.forEach(function(extendColumn) {
      if (extendColumn == "Rice Subsidy") {
        if (rice_subsidy) {
          combinedRow[extendColumn] = rice_subsidy;
        } else {
          combinedRow[extendColumn] = '';
        }
      }

      if (extendColumn == "OT Meal") {
        if (ot_meal) {
          combinedRow[extendColumn] = ot_meal;
        } else {
          combinedRow[extendColumn] = '';
        }
      }

      if (extendColumn == "Rice Reward") {
        if (rice_reward) {
          combinedRow[extendColumn] = rice_reward;
        } else {
          combinedRow[extendColumn] = '';
        }
      }

      if (extendColumn == "RCBC Loan") {
        const loan_data = benefit_loan.find(item => item.empl_id === empData.id);
        if (loan_data && loan_amount != 0) {
          combinedRow[extendColumn] = (loan_amount / loan_term).toFixed(2);
        } else {
          combinedRow[extendColumn] = '';
        }
      }
    });

    dynamicTypeHeaders.forEach(function(dynamicTypeHeader) 
    {
      var multipliedDataEntry = multipliedData.find(function(entry) {
        return (entry) ? entry.typeName === dynamicTypeHeader && empData.id === entry.id : "";
      });

      if (multipliedDataEntry) {
        combinedRow[dynamicTypeHeader] = multipliedDataEntry.multipliedValue;
      } else {
        combinedRow[dynamicTypeHeader] = '';
      }
    });


    benefitsTypeHeaders.forEach(function(benefitsTypeHeader) {

      var benefitsType = benefits_type.find(function(item) {
        return item.name === benefitsTypeHeader;
      });

      if (benefitsType) {
        var fixedAssign = fixed_assign.find(function(item) {
          return item.type === benefitsType.id.toString() && empData.id === item.user_id;
        });

        if (fixedAssign) {
          combinedRow[benefitsTypeHeader] = fixedAssign.value;
        } else {
          combinedRow[benefitsTypeHeader] = '';
        }
      } else {
        combinedRow[benefitsTypeHeader] = '';
      }
    });

    adjustmentTypeHeaders.forEach(function(adjustmentTypeHeader) {
      var adjustmentType = adjustment_type.find(function(item) {
        return item.name === adjustmentTypeHeader;
      });

      if (adjustmentType) {
        let adjustmentAssign = adjustment_assign.find(function(item) {
          return item.type === adjustmentType.id.toString() && empData.id === item.user_id;
        })

        if (adjustmentAssign) {
          combinedRow[adjustmentTypeHeader] = adjustmentAssign.value;
        } else {
          combinedRow[adjustmentTypeHeader] = '';
        }
      } else {
        combinedRow[adjustmentTypeHeader] = '';
      }

    });

    combinedRow.isSelected = false;

    return combinedRow;
  });

console.log('date ',combinedData)

  const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.style.whiteSpace         = 'nowrap';
    td.style.overflow           = 'hidden';
  };

  const customCheckboxRenderer  = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.CheckboxRenderer.apply(this, arguments);
    td.style.textAlign          = 'center';
    td.style.verticalAlign      = 'middle';
  };

  const columns                 = [];
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

  columns.push({
    data: 'col_empl_cmid',
    type: 'text',
    title: 'Employee ID',
    renderer: customStyleRenderer_new,
  });

  columns.push({
    data: 'full_name',
    type: 'text',
    title: 'Employee Name',
    width: 180,
    renderer: customStyleRenderer_new,
  });

  dateHeaders.forEach(function(dateHeader) {
    columns.push({
      data: dateHeader,
      type: 'text',
      title: dateHeader,
      renderer: customStyleRenderer_new,
    });
  });

  presentColumns.forEach(function(presentColumn) {
    columns.push({
      data: presentColumn,
      type: 'text',
      title: presentColumn,
      renderer: customStyleRenderer_new,
    });
  })

  attendanceAbsences.forEach(function(attendanceAbsence) {
    columns.push({
      data: attendanceAbsence,
      type: 'text',
      title: attendanceAbsence,
      renderer: customStyleRenderer_new,
    });
  })

  attendanceDeductions.forEach(function(attendanceDeduction) {
    columns.push({
      data: attendanceDeduction,
      type: 'text',
      title: attendanceDeduction,
      renderer: customStyleRenderer_new,
    });
  });

  typeREG.forEach(function(regRow) {
    columns.push({
      data: regRow,
      type: 'text',
      title: regRow,
      renderer: customStyleRenderer_new,
    });
  })

  typeRST.forEach(function(rstRow) {
    columns.push({
      data: rstRow,
      type: 'text',
      title: rstRow,
      renderer: customStyleRenderer_new,
    });
  })

  typeLEG.forEach(function(legRow) {
    columns.push({
      data: legRow,
      type: 'text',
      title: legRow,
      renderer: customStyleRenderer_new,
    });
  })

  typeRST_LEG.forEach(function(rstLeg) {
    columns.push({
      data: rstLeg,
      type: 'text',
      title: rstLeg,
      renderer: customStyleRenderer_new,
    });
  })

  typeSPE.forEach(function(spe) {
    columns.push({
      data: spe,
      type: 'text',
      title: spe,
      renderer: customStyleRenderer_new,
    });
  })

  typeRST_SPE.forEach(function(rstSpe) {
    columns.push({
      data: rstSpe,
      type: 'text',
      title: rstSpe,
      renderer: customStyleRenderer_new,
    });
  })

  extendColumns.forEach(function(extendColumn) {
    columns.push({
      data: extendColumn,
      type: 'text',
      title: extendColumn,
      renderer: customStyleRenderer_new,
    });
  });

  dynamicTypeHeaders.forEach(function(dynamicTypeHeader) {
    columns.push({
      data: dynamicTypeHeader,
      type: 'text',
      title: dynamicTypeHeader,
      renderer: customStyleRenderer_new,
    });
  });

  benefitsTypeHeaders.forEach(function(benefitsTypeHeader) {
    columns.push({
      data: benefitsTypeHeader,
      type: 'text',
      title: benefitsTypeHeader,
      renderer: customStyleRenderer_new,
    });
  });

  adjustmentTypeHeaders.forEach(function(adjustmentTypeHeader) {
    columns.push({
      data: adjustmentTypeHeader,
      type: 'text',
      title: adjustmentTypeHeader,
      renderer: customStyleRenderer_new,
    });
  });

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
          label: 'Employee',
          colspan: 2
        },
        {
          label: 'Attendance Record',
          colspan: dateHeaders.length
        },
        {
          label: 'Present',
          colspan: presentColumns.length
        },
        {
          label: 'Absences',
          colspan: attendanceAbsences.length
        },
        {
          label: 'Deductions',
          colspan: attendanceDeductions.length
        },
        {
          label: 'REGULAR',
          colspan: typeREG.length
        },
        {
          label: 'REST',
          colspan: typeRST.length
        },
        {
          label: 'LEGAL',
          colspan: typeLEG.length
        },
        {
          label: 'REST+LEGAL',
          colspan: typeRST_LEG.length
        },
        {
          label: 'SPECIAL',
          colspan: typeSPE.length
        },
        {
          label: 'REST+SPECIAL',
          colspan: typeRST_SPE.length
        },
        {
          label: 'Subsidy',
          colspan: extendColumns.length
        },
        {
          label: 'Dynamic Incentives',
          colspan: dynamicTypeHeaders.length
        },
        {
          label: 'Fixed Incentives',
          colspan: benefitsTypeHeaders.length
        },
        {
          label: 'Adjustment',
          colspan: adjustmentTypeHeaders.length
        },
      ],

      ['ID', selectHeaderLabel, 'Employee ID', 'Employee Name', ...dateHeaders, ...presentColumns, ...attendanceAbsences, ...attendanceDeductions,
        ...typeREG, ...typeRST, ...typeLEG, ...typeRST_LEG, ...typeSPE, ...typeRST_SPE,
        ...extendColumns, ...dynamicTypeHeaders, ...benefitsTypeHeaders, ...adjustmentTypeHeaders,
      ],
    ],
    outsideClickDeselects: false,
    selectionMode: 'multiple',
    licenseKey: 'non-commercial-and-evaluation',
    renderer: customStyleRenderer_new,
    readOnly: true,
    hiddenColumns: {
      columns: [0],
    },
    columns: columns,
  });

  document.addEventListener('change', function(event) {
    if (event.target.id === 'checkAllCheckbox') {
      let isChecked = event.target.checked;
      console.log(isChecked)

      for (const data of combinedData) {
        console.log(data)
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

  let cutOff        = document.getElementById('cut_off_period');
  let cutOffVal     = cutOff.value;

  var insert        = document.getElementById('btn-insert');
  insert.addEventListener('click', function() {
    const confirmed = confirm('Are you sure you want to update the data?');
    if (!confirmed) {
      return;
    }

    const updatedData = hot.getData();
    console.log(combinedData)
    const requestData = {
      updatedData: updatedData,
      combinedData: combinedData,
      cutOffVal: cutOffVal
    };

    fetch(url + 'attendances/insert_data', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(requestData),
      })
      .then(response => response.json())
      .then(result => {
        console.log('result', result);
        if (result.success_message) {
          $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success!',
            subtitle: 'close',
            body: result.success_message
          })
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
          body: 'Please provide all required information.'
        })
        console.log('Data update error:', error);
      });
  });

  document.getElementById('printButton').addEventListener('click', function() {
    const hideColBtn         = document.getElementById('hide_col_btn');
    const addBtn             = document.getElementById('btn-add-row');
    const updateBtn          = document.getElementById('btn-update');
    const pageTitle          = document.getElementById('page_title');

    const originalStyles     = {
      hideColBtn: hideColBtn.style.display,
      addBtn: addBtn.style.display,
      updateBtn: updateBtn.style.display,
      pageTitle: pageTitle.style.display,
    };

    hideColBtn.style.display = 'none';
    addBtn.style.display     = 'none';
    updateBtn.style.display  = 'none';
    pageTitle.style.display  = 'none';
    this.style.display       = 'none';

    window.print();

    this.style.display       = 'block';
    hideColBtn.style.display = originalStyles.hideColBtn;
    addBtn.style.display     = originalStyles.addBtn;
    updateBtn.style.display  = originalStyles.updateBtn;
    pageTitle.style.display  = originalStyles.pageTitle;
  });

  function getTimeVal(time1) {
    let time_hours           = "";

    if (time1 != null) {
      const timeParts        = time1.split(':');
      const hours            = parseFloat(timeParts[0]);
      const minutes          = parseFloat(timeParts[1]);
      const seconds          = parseFloat(timeParts[2]);
      time_hours             = hours + minutes / 60 + seconds / 3600;
    }
    return time_hours;
  }
</script>

<script>

  function changeTitle() {
    document.title = "Attendance Summary";
  }
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

      window.location = base_url + "attendances/attendance_summary" + page_row;
    }

    $('select.cut_off_period').on('change', function() {
      window.location.href = "<?= base_url('attendances/attendance_summary?period=') ?>" + $(this).val()
    })
  })

</script>
</body>

</html>