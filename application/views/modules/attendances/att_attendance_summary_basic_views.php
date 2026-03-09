<html>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?= base_url('assets_system/css/handsontable14.css') ?>" />

<style>
    .handsontable .wtHolder .wtHider {
        /* margin-bottom: 50px; */
        height: 60vh !important;
    }
</style>

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
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }


    .legend-container .legend::before {
        content: '';
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 5px;
        background-color: #85acff;
    }

    .legend-container span {
        font-size: 10px;
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
    $row = 100;
}
if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}
$prev_page = $current_page - 1;
$next_page = $current_page + 1;
$last_page_initial = ceil($C_DATA_COUNT / $row);
$last_page = ($last_page_initial == 0 || $last_page_initial == 1) ? 1 : $last_page_initial;
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
    <div id="loadingOverlay" class="loading-overlay"hidden>
        <div class="loading-spinner"></div>
    </div>
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title d-flex align-items-center" id="page_title"><a
                        href="<?= base_url() . 'attendances'; ?>"><img
                            style="width: 24px; height: 24px; margin-bottom: 3px;"
                            src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                        </i></a>&nbsp;Attendance Summary<h1>
            </div>
            <div class="col-md-6 button-title">
                <!-- 
        <a href="<?= base_url('attendances/add_attendance_summary') ?>" class="btn btn-success" id="btn-add-row"><i class="fa-solid fa-circle-plus"></i>&nbsp;Add Data</a>
        <a href="<?= base_url('attendances/edit_attendance_summary') ?>" class="btn btn-primary" id="btn-update"><i class="fa-duotone fa-pen-to-square"></i>&nbsp;Edit Data</a> -->
            </div>
        </div>

        <hr>

        <div class="d-flex justify-content-between align-items-end row">
            <div class="col-12 col-lg-3 py-3 w-25">
                <p class="p-0 my-1 text-bold">Cut-off Period</p>
                <select class="form-control cut_off_period" id="cut_off_period">
                    <?php foreach ($CUTOFF_PERIODS as $cut_off) { ?>
                        <option value="<?= $cut_off->id ?>" <?= $PERIOD == $cut_off->id ? 'selected' : '' ?>>
                            <?= $cut_off->name ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class='d-lg-flex d-block justify-content-end mr-1 col-12 col-lg-8'>
                <a  onclick="afterRenderFunction()" href="<?= base_url('attendances/attendance_summary') ?>" class="btn btn-primary mr-1">
                    Detailed View
                </a>
                <button class="btn btn-primary " id="btn-insert"><img
                        style="width: 16px; height: 16px; margin-bottom: 3px;"
                        src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />
                    Endorse to Payroll</button>
                <button type="button" class="btn btn-primary ml-1" data-toggle="modal" data-target="#settingsModal"
                    id="hide_col_btn"><img style="width: 16px; height: 16px; margin-bottom: 3px;"
                        src="<?= base_url('assets_system/icons/eye-slash-duotone.svg') ?>" alt="" />
                    &nbsp;Hide Columns</button>
                <button type="button" class="btn btn-primary ml-1 mt-1 mt-lg-0" id="printButton"><img
                        style="width: 16px; height: 16px; margin-bottom: 3px;"
                        src="<?= base_url('assets_system/icons/print-duotone_sm.svg') ?>" alt="" />&nbsp;Print</button>
                <button onclick="exportToExcel()"
                    class=" mt-1 mt-lg-0 btn btn-primary ml-1 shadow-none rounded d-flex align-items-center ml-1"
                    style="width: auto; display: inline-block !important;">
                    <img style="margin-bottom: 4px;" src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>"
                        alt="">&nbsp;Export XLSX
                </button>
            </div>
        </div>
        <div class="card border-0 p-0 m-0">
            <div class="card border-0 pt-1 m-0">
                <div class="card-header d-none p-0">
                    <div class="row ">
                        <div class="col-xl-8 ">
                        </div>
                        <div class="col-xl-4">
                            <div class="input-group pb-1">
                                <?php
                                if ($search_data) { ?>
                                    <button id="clear_search_btn"
                                        class="input-group-prepend btn technos-button-blue shadow-none"><i
                                            class="fa-regular fa-broom-wide"
                                            style="margin-top: 4px"></i>&nbsp;Clear</button>
                                <?php } else { ?>
                                    <button id="search_btn"
                                        class="input-group-prepend btn technos-button-blue shadow-none"><i
                                            class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
                                <?php } ?>
                                <input type="text" class="form-control" placeholder="Search..."
                                    value="<?= ($search_data) ? $search_data : "" ?>" id="search_data"
                                    aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2">
                    <div class="d-flex row">
                        <div class=" legend-container col-3">
                            <!-- <p>Legend : </p> -->
                            <!-- <span class="d-block legend">AA - Regular Working Hours</span>
              <span class="d-block legend">(BB) - Overtime</span>
              <span class="d-block legend">[CC] - Leave</span> -->
                            <!-- <span class="d-block legend">Rice Subsidy</span>
                            <span class="d-block legend">Rice Allowance</span>
                            <span class="d-block legend">Overtime Meal Allowance</span> -->
                        </div>

                        <!-- <div class="legend-container col-3">
                            <span class="d-block legend">Paid Leave</span>
                            <span class="d-block legend">Absent</span>
                            <span class="d-block legend">Tardiness</span>
                        </div>

                        <div class=" legend-container col-3">
                            <span class="d-block legend">Undertime</span>
                            <span class="d-block legend">Early Break</span>
                            <span class="d-block legend">Over Break</span>
                        </div>

                        <div class=" legend-container col-3">
                            
                        </div> -->

                        <!-- <div class="ml-1 legend-container">
                            <span class="d-block legend">REG REG - Regular Hours</span>
                            <span class="d-block legend">REG OT - Regular Overtime</span>
                            <span class="d-block legend">REG ND - Regular Night Differential</span>
                            <span class="d-block legend">REG NDOT - Regular Night Differential / Overtime</span>
                        </div>

                        <div class="ml-1 legend-container">
                            <span class="d-block legend">RST REG - Rest Regular Hours</span>
                            <span class="d-block legend">RST OT - Rest Regular Overtime</span>
                            <span class="d-block legend">RST ND - Rest Regular Night Differential</span>
                            <span class="d-block legend">RST NDOT - Rest Regular Night Differential / Overtime</span>
                        </div>

                        <div class="ml-1 legend-container">
                            <span class="d-block legend">LEG REG - Legal Regular Hours</span>
                            <span class="d-block legend">LEG OT - Legal Regular Overtime</span>
                            <span class="d-block legend">LEG ND - Legal Regular Night Differential</span>
                            <span class="d-block legend">LEG NDOT - Legal Regular Night Differential / Overtime</span>
                        </div>

                        <div class="ml-1 legend-container">
                            <span class="d-block legend">RST + LEG REG - Rest + Legal Regular Hours</span>
                            <span class="d-block legend">RST + LEG OT - Rest + Legal Regular Overtime</span>
                            <span class="d-block legend">RST + LEG ND - Rest + Legal Regular Night Differential</span>
                            <span class="d-block legend">RST + LEG NDOT - Rest + Legal Regular Night Differential /
                                Overtime</span>
                        </div>

                        <div class="ml-1 legend-container">
                            <span class="d-block legend">SPE REG - Special Regular Hours</span>
                            <span class="d-block legend">SPE OT - Special Regular Overtime</span>
                            <span class="d-block legend">SPE ND - Special Regular Night Differential</span>
                            <span class="d-block legend">SPE NDOT - Special Regular Night Differential / Overtime</span>
                        </div>

                        <div class="ml-1 legend-container">
                            <span class="d-block legend">RST + SPE REG - Rest + Special Regular Hours</span>
                            <span class="d-block legend">RST + SPE OT - Rest + Special Regular Overtime</span>
                            <span class="d-block legend">RST + SPE ND - Rest + Special Regular Night Differential</span>
                            <span class="d-block legend">RST + SPE NDOT - Rest + Special Regular Night Differential /
                                Overtime</span>
                        </div> -->

                    </div>


                </div>
                <div class="row">
                    <div class="col">
                        <div class="">
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
<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="settingsModalLabel"
    aria-hidden="true">
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
                        <input type="checkbox" class="form-check-input column-checkbox" id="presentCheckbox">
                        <label class="form-check-label" for="presentCheckbox">Present</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input column-checkbox" id="sliderCheckbox">
                        <label class="form-check-label" for="sliderCheckbox">Slider</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input column-checkbox" id="benefitCheckbox">
                        <label class="form-check-label" for="benefitCheckbox">Benefit</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input column-checkbox" id="absencesCheckbox">
                        <label class="form-check-label" for="absencesCheckbox">Absences</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input column-checkbox" id="deductionsCheckbox">
                        <label class="form-check-label" for="deductionsCheckbox">Deductions</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input column-checkbox" id="regularHolidayCheckbox">
                        <label class="form-check-label" for="regularHolidayCheckbox">REGULAR</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input column-checkbox" id="restCheckbox">
                        <label class="form-check-label" for="restCheckbox">REST</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input column-checkbox" id="legalCheckbox">
                        <label class="form-check-label" for="legalCheckbox">LEGAL</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input column-checkbox" id="restLegalCheckbox">
                        <label class="form-check-label" for="restLegalCheckbox">REST+LEGAL</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input column-checkbox" id="specialCheckbox">
                        <label class="form-check-label" for="specialCheckbox">SPECIAL</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input column-checkbox" id="restSpecialCheckbox">
                        <label class="form-check-label" for="restSpecialCheckbox">REST+SPECIAL</label>
                    </div>
                    <!-- <div class="form-check">
            <input type="checkbox" class="form-check-input column-checkbox" id="subsidyCheckbox">
            <label class="form-check-label" for="subsidyCheckbox">Subsidy</label>
          </div> -->
                    <!-- <div class="form-check">
            <input type="checkbox" class="form-check-input column-checkbox" id="shiftCheckbox">
            <label class="form-check-label" for="shiftCheckbox">Dynamic Incentives</label>
          </div> -->
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input column-checkbox" id="fixedIncentivesCheckbox">
                        <label class="form-check-label" for="fixedIncentivesCheckbox">Earnings</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input column-checkbox" id="adjustmentCheckbox">
                        <label class="form-check-label" for="adjustmentCheckbox">Adjustment</label>
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
<?php $this->load->view('templates/jquery_link'); ?>

<script>
  function afterRenderFunction(){
    var loadingOverlay = document.getElementById('loadingOverlay');
    loadingOverlay.hidden = false;
  }
</script>

<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script type="text/javascript" src="<?= base_url('assets_system/js/handsontable14.js') ?>"></script>
<script>
    const selectAllCheckbox = document.getElementById("selectAllCheckbox");
    const columnCheckboxes = document.querySelectorAll(".column-checkbox");
    selectAllCheckbox.addEventListener("change", function () {
        const selectAllChecked = selectAllCheckbox.checked;
        columnCheckboxes.forEach(function (checkbox) {
            checkbox.checked = selectAllChecked;
        });
    });
    document.getElementById("saveButton").addEventListener("click", function () {
        const selectedColumns = [];
        columnCheckboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                selectedColumns.push(checkbox.nextElementSibling.textContent);
            }
        });
        let columns = [0, 1];
        if (selectedColumns.includes("Employee")) {
            columns = [...columns, 2, 3]
        }
        if (selectedColumns.includes("Attendance Record")) {
            const start = 4;
            const length = dateHeaders.length;
            columns = [...columns, ...Array.from({
                length
            }, (_, i) => start + i)];
        }
        if (selectedColumns.includes("Present")) {
            const start = 4 + dateHeaders.length;
            const length = presentColumns.length;
            columns = [...columns, ...Array.from({
                length
            }, (_, i) => start + i)];
        }
        if (selectedColumns.includes("Slider")) {
            const start = 4 + dateHeaders.length + presentColumns.length;
            const length = sliders.length;
            columns = [...columns, ...Array.from({
                length
            }, (_, i) => start + i)];
        }
        if (selectedColumns.includes("Benefit")) {
            const start = 4 + dateHeaders.length + presentColumns.length + sliders.length;
            const length = benefitsColumns.length;
            columns = [...columns, ...Array.from({
                length
            }, (_, i) => start + i)];
        }
        if (selectedColumns.includes("Absences")) {
            const start = 4 + dateHeaders.length + presentColumns.length + sliders.length + benefitsColumns.length;
            const length = attendanceAbsences.length;
            columns = [...columns, ...Array.from({
                length
            }, (_, i) => start + i)];
        }
        if (selectedColumns.includes("Deductions")) {
            const start = 4 + dateHeaders.length + presentColumns.length + sliders.length + benefitsColumns.length + attendanceAbsences.length;
            const length = attendanceDeductions.length;
            columns = [...columns, ...Array.from({
                length
            }, (_, i) => start + i)];
        }
        // if (selectedColumns.includes("REGULAR")) {
        //     const start = 4 + dateHeaders.length + presentColumns.length + sliders.length + benefitsColumns.length + attendanceAbsences.length + attendanceDeductions.length;
        //     const length = typeREG.length;
        //     columns = [...columns, ...Array.from({
        //         length
        //     }, (_, i) => start + i)];
        // }
        // if (selectedColumns.includes("REST")) {
        //     const start = 4 + dateHeaders.length + presentColumns.length + sliders.length + benefitsColumns.length + attendanceAbsences.length + attendanceDeductions.length + typeREG.length;
        //     const length = typeRST.length;
        //     columns = [...columns, ...Array.from({
        //         length
        //     }, (_, i) => start + i)];
        // }
        // if (selectedColumns.includes("LEGAL")) {
        //     const start = 4 + dateHeaders.length + presentColumns.length + sliders.length + benefitsColumns.length + attendanceAbsences.length + attendanceDeductions.length + typeREG.length + typeRST.length;
        //     const length = typeLEG.length;
        //     columns = [...columns, ...Array.from({
        //         length
        //     }, (_, i) => start + i)];
        // }
        // if (selectedColumns.includes("REST+LEGAL")) {
        //     const start = 4 + dateHeaders.length + presentColumns.length + sliders.length + benefitsColumns.length + attendanceAbsences.length + attendanceDeductions.length + typeREG.length + typeRST.length + typeLEG.length;
        //     const length = typeRST_LEG.length;
        //     columns = [...columns, ...Array.from({
        //         length
        //     }, (_, i) => start + i)];
        // }
        // if (selectedColumns.includes("SPECIAL")) {
        //     const start = 4 + dateHeaders.length + presentColumns.length + sliders.length + benefitsColumns.length + attendanceAbsences.length + attendanceDeductions.length + typeREG.length + typeRST.length + typeLEG.length + typeRST_LEG.length;
        //     const length = typeSPE.length;
        //     columns = [...columns, ...Array.from({
        //         length
        //     }, (_, i) => start + i)];
        // }
        // if (selectedColumns.includes("REST+SPECIAL")) {
        //     const start = 4 + dateHeaders.length + presentColumns.length + sliders.length + benefitsColumns.length + attendanceAbsences.length + attendanceDeductions.length + typeREG.length + typeRST.length + typeLEG.length + typeRST_LEG.length + typeSPE.length;
        //     const length = typeRST_SPE.length;
        //     columns = [...columns, ...Array.from({
        //         length
        //     }, (_, i) => start + i)];
        // }
        // if (selectedColumns.includes("Fixed Incentives")) {
        //   const start          = 3 + dateHeaders.length + attendanceAbsences.length + attendanceDeductions.length +
        //     typeREG.length + typeRST.length + typeLEG.length + typeRST_LEG.length + typeSPE.length + typeRST_SPE.length;
        //   const length         = benefitsTypeHeaders.length;
        //   columns              = [...columns, ...Array.from({
        //     length
        //   }, (_, i) => start + i)];
        // }
        // if (selectedColumns.includes("Earnings")) {
        //     const start = 4 + dateHeaders.length + presentColumns.length + sliders.length + benefitsColumns.length + attendanceAbsences.length + attendanceDeductions.length + typeREG.length + typeRST.length + typeLEG.length + typeRST_LEG.length + typeSPE.length + typeRST_SPE.length;
        //     const length = benefitsTypeHeaders.length;
        //     columns = [...columns, ...Array.from({
        //         length
        //     }, (_, i) => start + i)];
        // }
        // if (selectedColumns.includes("Adjustment")) {
        //     const start = 4 + dateHeaders.length + presentColumns.length + sliders.length + benefitsColumns.length + attendanceAbsences.length + attendanceDeductions.length + typeREG.length + typeRST.length + typeLEG.length + typeRST_LEG.length + typeSPE.length + typeRST_SPE.length + benefitsTypeHeaders.length;
        //     const length = adjustmentTypeHeaders.length;
        //     columns = [...columns, ...Array.from({
        //         length
        //     }, (_, i) => start + i)];
        // }
        hot.updateSettings({
            hiddenColumns: {
                columns
            }
        });
        $('#settingsModal').modal('hide');
    });
</script>
<script>
    var url = '<?= base_url() ?>';
    var employee_list = <?php echo json_encode($DISP_EMPLOYEES); ?>;
    var cutoff_period = <?php echo json_encode($CUTOFF_PERIOD); ?>;
    var log_in_out = <?php echo json_encode($DISP_EMPLOYEES_ATTENDANCE_LOG); ?>;
    var log_shift_in_out = <?php echo json_encode($DISP_EMPLOYEES_SHIFT); ?>;
    var benefits_type = <?php echo json_encode($DISP_BENEFITS_BENEFITS_TYPE); ?>;
    var adjustment_type = <?php echo json_encode($DISP_BENEFITS_ADJUSTMENT_TYPE); ?>;
    var benefits_dynamic = <?php echo json_encode($DISP_BENEFITS_DYNAMIC); ?>;
    var employeeListAssign = <?php echo json_encode($DISP_EMPLOYEELIST_ASSIGN); ?>;
    var dynamic_std = <?php echo json_encode($DISP_DYNAMIC_STD); ?>;
    var fixed_assign = <?php echo json_encode($DISP_BENEFITS_FIXED_ASSIGN); ?>;
    var adjustment_assign = <?php echo json_encode($DISP_BENEFITS_ADJUSTMENT_ASSIGN); ?>;
    var approved_ot = <?php echo json_encode($DISP_ALL_APPROVED_OT); ?>;
    var leave_assigns = <?php echo json_encode($LEAVE_ASSIGNS); ?>;
    var leave_names = <?php echo json_encode($DISP_LEAVE_NAMES); ?>;
    var holidays = <?php echo json_encode($DISP_HOLIDAYS); ?>;
    var zkteco_attendance_data = <?php echo json_encode($DISP_ZKTECO_ATTENDANCE_DATA); ?>;

    var hot;

    function getLeaveNameByType(leaveType) {
        const leave = leave_names.find(leave => leave.id === leaveType);
        return leave ? leave.name : 'Unknown';
    }

    const attendance_color = zkteco_attendance_data.map(data => data.attendance_color);

    const fromDate = new Date(cutoff_period.date_from);
    const toDate = new Date(cutoff_period.date_to);
    const dateHeaders = [];
    const presentColumns = ['DAYS'];
    const sliders = [''];
    const benefitsColumns = ['RICE SUBSIDY', 'RICE ALLOWANCE', 'OVERTIME MEAL ALLOWANCE', 'TRANSPORTATION ALLOWANCE'];
    const attendanceAbsences = ['PAID', 'ABSENT'];
    const attendanceDeductions = ['TARDINESS', 'UNDERTIME', 'EARLY BREAK', 'OVER BREAK'];
    const typeRST = ['REST OVERTIME'];
    // const typeREG = ['REG REG', 'REG OT', 'REG ND', 'REG NDOT'];
    // const typeRST = ['RST REG', 'RST OT', 'RST ND', 'RST NDOT'];
    // const typeLEG = ['LEG REG', 'LEG OT', 'LEG ND', 'LEG NDOT'];
    // const typeRST_LEG = ['RST+LEG REG', 'RST+LEG OT', 'RST+LEG ND', 'RST+LEG NDOT'];
    // const typeSPE = ['SPE REG', 'SPE OT', 'SPE ND', 'SPE NDOT'];
    // const typeRST_SPE = ['RST+SPE REG', 'RST+SPE OT', 'RST+SPE ND', 'RST+SPE NDOT'];

    let rc_sub = <?php echo json_encode($RICE_SUB); ?>;
    let rc_alo = <?php echo json_encode($RICE_ALO); ?>;
    let ovm_alo = <?php echo json_encode($OVM_ALO); ?>;

    if (rc_sub == 0) {
        const index = benefitsColumns.indexOf('RICE SUBSIDY');
        if (index !== -1) {
            benefitsColumns.splice(index, 1);
        }
    }
    if (rc_alo == 0) {
        const index = benefitsColumns.indexOf('RICE ALLOWANCE');
        if (index !== -1) {
            benefitsColumns.splice(index, 1);
        }
    }
    if (ovm_alo == 0) {
        const index = benefitsColumns.indexOf('OVERTIME MEAL ALLOWANCE');
        if (index !== -1) {
            benefitsColumns.splice(index, 1);
        }
    }

    if (rc_sub === 1 && !benefitsColumns.includes('RICE SUBSIDY')) {
        benefitsColumns.push('RC SUB');
    }
    if (rc_alo === 1 && !benefitsColumns.includes('RICE ALLOWANCE')) {
        benefitsColumns.push('RC ALO');
    }
    if (ovm_alo === 1 && !benefitsColumns.includes('OVERTIME MEAL ALLOWANCE')) {
        benefitsColumns.push('OVM ALO');
    }

    const hasBenefits = benefitsColumns.length > 0;


    const benefitsTypeHeaders = benefits_type.map(item => item.name);
    const adjustmentTypeHeaders = adjustment_type.map(item => item.name);

    while (fromDate <= toDate) {
        dateHeaders.push(fromDate.toISOString().split('T')[0]);
        fromDate.setDate(fromDate.getDate() + 1);
    }

    // console.log(attendance_color)


    const colorWithDate = attendance_color.map((colorArr, index) => {
        const date = dateHeaders[index];
        const colorObj = {};
        colorArr.forEach((color, colorIndex) => {
            colorObj[dateHeaders[colorIndex]] = color;
        });
        return colorObj;
    });


    var combinedData = employee_list.map(function (empData) {
        var combinedRow = {
            id: empData.id,
            col_empl_cmid: empData.col_empl_cmid,
            full_name: empData.fullname
        };

        // Attendance Summary data
        let sumOfRegularHours = 0;
        let sumOfRegularHours_allowance = 0;
        let sumOfOvertimeMeal_allowance = 0;
        let sumOfTransportation_allowance = 0;

        dateHeaders.forEach(function (dateHeader, index) {
            const attendanceData = zkteco_attendance_data.find((data) => data.id === empData.id);

            if (attendanceData) {
                const reg_hrs = attendanceData.reg_hrs[index];
                const paid_leaves = attendanceData.paid_leaves[index];
                const overtime = attendanceData.overtime[index];
                const attendance_color = attendanceData.attendance_color[index];
                // console.log(attendance_color)
                if (reg_hrs !== 0) {
                    combinedRow[dateHeader] = `${reg_hrs}`;
                    // console.log('reg_hrs', reg_hrs);
                    if (!isNaN(parseFloat(reg_hrs)) && isFinite(reg_hrs)) {
                        var reg_hrs_int = parseInt(reg_hrs);
                        if (reg_hrs_int >= 8) {
                            sumOfRegularHours++;
                            sumOfRegularHours_allowance = sumOfRegularHours_allowance + 12;
                        }
                    }
                } else {
                    if (overtime >= 8) {
                        sumOfRegularHours++;
                        sumOfRegularHours_allowance = sumOfRegularHours_allowance + 12;
                    }
                }

                if (overtime) {
                    if (combinedRow[dateHeader]) {
                        combinedRow[dateHeader] += ` (${overtime})`;
                    } else {
                        combinedRow[dateHeader] = `(${overtime})`;
                    }

                    if (overtime >= 3) {
                        sumOfOvertimeMeal_allowance = sumOfOvertimeMeal_allowance + 36;
                    }

                    if (overtime >= 1) {
                        sumOfTransportation_allowance = sumOfTransportation_allowance + 50;
                    }

                }
                if (paid_leaves) {
                    if (combinedRow[dateHeader]) {
                        combinedRow[dateHeader] += `[${paid_leaves}]`;
                    } else {
                        combinedRow[dateHeader] = `[${paid_leaves}]`;
                    }
                }
                if (
                    typeof combinedRow[dateHeader] !== 'undefined' &&
                    combinedRow[dateHeader] !== null &&
                    !isNaN(Number(combinedRow[dateHeader])) &&
                    isFinite(Number(combinedRow[dateHeader])) &&
                    Number(combinedRow[dateHeader]) > 0
                ) {
                    // console.log('combinedRow[dateHeader].toFixed(2)', Number(combinedRow[dateHeader]).toFixed(2));
                    combinedRow[dateHeader] = Number(combinedRow[dateHeader]).toFixed(2);
                } else {
                    // console.log('false combinedRow[dateHeader].toFixed(2)', combinedRow[dateHeader]);
                }

            }
        });


        $reg_reg = "";
        $leg_reg = "";
        $rst_leg_reg = "";
        $sum_spe_hours = "";
        $sum_sperest_hours = "";
        $sum_awol = "";
        $sum_lwop = "";
        $sum_present = "";
        $sum_paid_leave = "";
        $sum_tardiness = "";
        $sum_undertime = "";
        $sum_earlybreak = "";
        $sum_overbreak = "";
        $slider = "";
        let earning_deduction = [];
        let adjustment_benefits = [];

        let sum_rest_hours = "";
        let sum_rest_regot = "";
        let sum_rest_nd = "";
        let sum_rest_ndot = "";

        // data from controller attendance_summary()
        const attendances = zkteco_attendance_data.find((data) => data.id === empData.id);

        if (attendances) {
            $reg_reg = attendances.sum_reg_hours;
            $leg_reg = attendances.sum_leg_hours;
            $rst_leg_reg = attendances.sum_legrest_hours;
            $sum_spe_hours = attendances.sum_spe_hours;
            $sum_sperest_hours = attendances.sum_sperest_hours;
            $sum_awol = attendances.sum_awol
            $sum_lwop = attendances.sum_lwop
            $sum_present = attendances.sum_present
            $sum_paid_leave = attendances.sum_paid_leave
            $sum_tardiness = attendances.sum_tardiness
            $sum_undertime = attendances.sum_undertime
            $sum_earlybreak = attendances.sum_earlybreak
            $sum_overbreak = attendances.sum_overbreak
            earning_deduction = attendances.earning_deduction
            adjustment_benefits = attendances.adjustment_benefits
            $slider = attendances.slider

            sum_rest_hours = attendances.sum_rest_hours
            sum_rest_regot = attendances.sum_rest_regot
            sum_rest_nd = attendances.sum_rest_nd
            sum_rest_ndot = attendances.sum_rest_ndot
        }


        // Present Data
        presentColumns.forEach(function (presentColumn) {
            if (presentColumn == "DAYS") {
                combinedRow[presentColumn] = ($sum_present) ? $sum_present : "";
            }
        })

        sliders.forEach(function (slider) {
            if (slider == "") {

                combinedRow[slider] = ($slider) ? $slider : "";
            }
        })

        // Benefits Data
        benefitsColumns.forEach(function (column) {
            if (column == "RC SUB") {
                combinedRow[column] = sumOfRegularHours > 0 ? sumOfRegularHours : '';
            }
            if (column == "RC ALO") {
                combinedRow[column] = sumOfRegularHours_allowance > 0 ? sumOfRegularHours_allowance : '';
            }
            if (column == "OVM ALO") {
                combinedRow[column] = sumOfOvertimeMeal_allowance > 0 ? sumOfOvertimeMeal_allowance : '';
            }
            if (column == "TRANS ALLO") {
                combinedRow[column] = sumOfTransportation_allowance > 0 ? sumOfTransportation_allowance : '';
            }
        })

        // Absences Data
        attendanceAbsences.forEach(function (attendanceAbsence) {
            if (attendanceAbsence == "PAID") {
                combinedRow[attendanceAbsence] = ($sum_paid_leave) ? $sum_paid_leave : "";
            }
            if (attendanceAbsence == "LWOP") {
                combinedRow[attendanceAbsence] = ($sum_lwop) ? $sum_lwop : "";
            }
            if (attendanceAbsence == "AWOL") {
                combinedRow[attendanceAbsence] = ($sum_awol) ? $sum_awol : "";
            }
        })

        // Deductions Data
        attendanceDeductions.forEach(function (attendanceDeduction) {
            if (attendanceDeduction == "TARD") {
                combinedRow[attendanceDeduction] = ($sum_tardiness) ? $sum_tardiness : "";
            }
            if (attendanceDeduction == "UT") {
                combinedRow[attendanceDeduction] = ($sum_undertime) ? $sum_undertime : "";
            }
            if (attendanceDeduction == "EARB") {
                combinedRow[attendanceDeduction] = ($sum_earlybreak) ? $sum_earlybreak : "";
            }
            if (attendanceDeduction == "OVRB") {
                combinedRow[attendanceDeduction] = ($sum_overbreak) ? $sum_overbreak : "";
            }
        });

        // // Regular Data
        // typeREG.forEach(function (regRow) {
        //     if (regRow == "REG REG") {
        //         combinedRow[regRow] = ($reg_reg) ? $reg_reg : "";
        //         if (
        //             typeof combinedRow[regRow] !== 'undefined' &&
        //             combinedRow[regRow] !== null &&
        //             !isNaN(Number(combinedRow[regRow])) &&
        //             isFinite(Number(combinedRow[regRow])) &&
        //             Number(combinedRow[regRow]) > 0
        //         ) {
        //             // console.log('combinedRow[regRow].toFixed(2)', Number(combinedRow[regRow]).toFixed(2));
        //             combinedRow[regRow] = Number(combinedRow[regRow]).toFixed(2);
        //         } else {
        //             // console.log('false combinedRow[regRow].toFixed(2)', combinedRow[regRow] );
        //         }
        //     }
        //     if (regRow == "REG OT") {
        //         combinedRow[regRow] = '';
        //     }
        //     if (regRow == "REG ND") {
        //         combinedRow[regRow] = '';
        //     }
        //     if (regRow == "REG NDOT") {
        //         combinedRow[regRow] = '';
        //     }
        // })

        // Rest Data 
        typeRST.forEach(function (rstRow) {
            if (rstRow == "REST OVERTIME") {
                combinedRow[rstRow] = (sum_rest_regot) ? sum_rest_regot : '';
            }

        })

        // typeRST.forEach(function (rstRow) {
        //     if (rstRow == "RST REG") {
        //         combinedRow[rstRow] = '';
        //     }
        //     if (rstRow == "RST OT") {
        //         combinedRow[rstRow] = '';
        //     }
        //     if (rstRow == "RST ND") {
        //         combinedRow[rstRow] = '';
        //     }
        //     if (rstRow == "RST NDOT") {
        //         combinedRow[rstRow] = '';
        //     }
        // })

        // Legal Data 
        // typeLEG.forEach(function (rstRow) {
        //     if (rstRow == "LEG REG") {
        //         combinedRow[rstRow] = ($leg_reg) ? $leg_reg : "";
        //     }
        //     if (rstRow == "LEG OT") {
        //         combinedRow[rstRow] = '';
        //     }
        //     if (rstRow == "LEG ND") {
        //         combinedRow[rstRow] = '';
        //     }
        //     if (rstRow == "LEG NDOT") {
        //         combinedRow[rstRow] = '';
        //     }
        // })

        // Rest Legal Data 
        // typeRST_LEG.forEach(function (rstRow) {
        //     if (rstRow == "RST+LEG REG") {
        //         combinedRow[rstRow] = ($rst_leg_reg) ? $rst_leg_reg : "";
        //     }
        //     if (rstRow == "RST+LEG OT") {
        //         combinedRow[rstRow] = '';
        //     }
        //     if (rstRow == "RST+LEG ND") {
        //         combinedRow[rstRow] = '';
        //     }
        //     if (rstRow == "RST+LEG NDOT") {
        //         combinedRow[rstRow] = '';
        //     }
        // })

        // Special Data 
        // typeSPE.forEach(function (rstRow) {
        //     if (rstRow == "SPE REG") {
        //         combinedRow[rstRow] = ($sum_spe_hours) ? $sum_spe_hours : "";
        //     }
        //     if (rstRow == "SPE OT") {
        //         combinedRow[rstRow] = '';
        //     }
        //     if (rstRow == "SPE ND") {
        //         combinedRow[rstRow] = '';
        //     }
        //     if (rstRow == "SPE NDOT") {
        //         combinedRow[rstRow] = '';
        //     }
        // })

        // Rest Special Data 
        // typeRST_SPE.forEach(function (rstRow) {
        //     if (rstRow == "RST+SPE REG") {
        //         combinedRow[rstRow] = ($sum_sperest_hours) ? $sum_sperest_hours : "";
        //     }
        //     if (rstRow == "RST+SPE OT") {
        //         combinedRow[rstRow] = '';
        //     }
        //     if (rstRow == "RST+SPE ND") {
        //         combinedRow[rstRow] = '';
        //     }
        //     if (rstRow == "RST+SPE NDOT") {
        //         combinedRow[rstRow] = '';
        //     }
        // })

        // Earnings / Deductions Data
        benefitsTypeHeaders.forEach(function (benefitsTypeHeader) {
            earning_deduction.forEach(function (item) {
                if (benefitsTypeHeader == item.type) {
                    combinedRow[benefitsTypeHeader] = item.value;
                }
            });
        });

        // Adjustment benefits
        adjustmentTypeHeaders.forEach(function (adjustmentTypeHeader) {
            adjustment_benefits.forEach(function (item) {
                if (adjustmentTypeHeader == item.type) {
                    combinedRow[adjustmentTypeHeader] = item.value;
                }
            })
        });

        combinedRow.isSelected = false;
        return combinedRow;

    });

    const customStyleRenderer_new = function (instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        td.style.whiteSpace = 'nowrap';
        td.style.overflow = 'hidden';
    };

    const attendanceStyleRenderer = function (instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        const color = colorWithDate[row][cellProperties['prop']];
        td.style.backgroundColor = color;
        td.style.whiteSpace = 'nowrap';
        td.style.overflow = 'hidden';
    };

    const customCheckboxRenderer = function (instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.CheckboxRenderer.apply(this, arguments);
        td.style.textAlign = 'center';
        td.style.verticalAlign = 'middle';
    };

    const columns = [];
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
        width: 150,
        renderer: customStyleRenderer_new,
    });


    dateHeaders.forEach(function (dateHeader) {
        columns.push({
            data: dateHeader,
            type: 'text',
            title: dateHeader,
            renderer: attendanceStyleRenderer,
        })
    })

    presentColumns.forEach(function (presentColumn) {
        columns.push({
            data: presentColumn,
            type: 'text',
            title: presentColumn,
            renderer: customStyleRenderer_new,
        });
    })
    sliders.forEach(function (slider) {
        columns.push({
            data: slider,
            type: 'text',
            title: slider,
            renderer: customStyleRenderer_new,
        });
    })
    benefitsColumns.forEach(function (column) {
        columns.push({
            data: column,
            type: 'text',
            title: column,
            renderer: customStyleRenderer_new,
        });
    })
    attendanceAbsences.forEach(function (attendanceAbsence) {
        columns.push({
            data: attendanceAbsence,
            type: 'text',
            title: attendanceAbsence,
            renderer: customStyleRenderer_new,
        });
    })
    attendanceDeductions.forEach(function (attendanceDeduction) {
        columns.push({
            data: attendanceDeduction,
            type: 'text',
            title: attendanceDeduction,
            renderer: customStyleRenderer_new,
        });
    });
    // typeREG.forEach(function (regRow) {
    //     columns.push({
    //         data: regRow,
    //         type: 'text',
    //         title: regRow,
    //         renderer: customStyleRenderer_new,
    //     });
    // })
    typeRST.forEach(function (rstRow) {
        columns.push({
            data: rstRow,
            type: 'text',
            title: rstRow,
            renderer: customStyleRenderer_new,
        });
    })
    // typeLEG.forEach(function (legRow) {
    //     columns.push({
    //         data: legRow,
    //         type: 'text',
    //         title: legRow,
    //         renderer: customStyleRenderer_new,
    //     });
    // })
    // typeRST_LEG.forEach(function (rstLeg) {
    //     columns.push({
    //         data: rstLeg,
    //         type: 'text',
    //         title: rstLeg,
    //         renderer: customStyleRenderer_new,
    //     });
    // })
    // typeSPE.forEach(function (spe) {
    //     columns.push({
    //         data: spe,
    //         type: 'text',
    //         title: spe,
    //         renderer: customStyleRenderer_new,
    //     });
    // })
    // typeRST_SPE.forEach(function (rstSpe) {
    //     columns.push({
    //         data: rstSpe,
    //         type: 'text',
    //         title: rstSpe,
    //         renderer: customStyleRenderer_new,
    //     });
    // })


    // benefitsTypeHeaders.forEach(function (benefitsTypeHeader) {
    //     columns.push({
    //         data: benefitsTypeHeader,
    //         type: 'text',
    //         title: benefitsTypeHeader,
    //         renderer: customStyleRenderer_new,
    //     });
    // });
    // adjustmentTypeHeaders.forEach(function (adjustmentTypeHeader) {
    //     columns.push({
    //         data: adjustmentTypeHeader,
    //         type: 'text',
    //         title: adjustmentTypeHeader,
    //         renderer: customStyleRenderer_new,
    //     });
    // });
    const selectHeaderLabel = `<input type="checkbox" id="checkAllCheckbox" >`;
    const container = document.querySelector('#table_data_new');
    let formattedDates = dateHeaders.map(dateString => {
        let dateObject = new Date(dateString);
        let month = (dateObject.getMonth() + 1).toString().padStart(2, '0');
        let day = dateObject.getDate().toString().padStart(2, '0');
        return `${day}/${month}`;
    });

    let nestedHeaders = [
        [
            'ID', 'Select', {
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
                label: 'Slider',
                colspan: sliders.length
            },
            {
                label: 'Benefits',
                colspan: benefitsColumns.length
            },
            {
                label: 'Absences',
                colspan: attendanceAbsences.length
            },
            {
                label: 'Deductions',
                colspan: attendanceDeductions.length
            },
            // {
            //     label: 'REGULAR',
            //     colspan: typeREG.length
            // },
            {
                label: 'REST',
                colspan: typeRST.length
            },
            // {
            //     label: 'LEGAL',
            //     colspan: typeLEG.length
            // },
            // {
            //     label: 'REST+LEGAL',
            //     colspan: typeRST_LEG.length
            // },
            // {
            //     label: 'SPECIAL',
            //     colspan: typeSPE.length
            // },
            // {
            //     label: 'REST+SPECIAL',
            //     colspan: typeRST_SPE.length
            // },
            // {
            //     label: 'Earnings',
            //     colspan: benefitsTypeHeaders.length
            // },
            // {
            //     label: 'Adjustment',
            //     colspan: adjustmentTypeHeaders.length
            // },
        ],
        ['ID', selectHeaderLabel, 'Employee ID', 'Employee Name', ...formattedDates, ...presentColumns, ...sliders, ...benefitsColumns, ...attendanceAbsences, ...attendanceDeductions, ...typeRST
        ],
    ]

    if (!hasBenefits) {
        nestedHeaders[0] = nestedHeaders[0].filter(item => item.label !== 'Benefits');
    }

    const hiddenColumns = {
        columns: [0],
    }

    let col_header_title = function (col, TH) {
        const colName = nestedHeaders[1][col];
        switch (colName) {
            case 'RC SUB':
                TH.setAttribute('title', 'Rice Subsidy');
                break;
            case 'RC ALO':
                TH.setAttribute('title', 'Rice Allowance');
                break;
            case 'OVM ALO':
                TH.setAttribute('title', 'Overtime Meal Allowance');
                break;
            case 'PAID':
                TH.setAttribute('title', 'Paid Leave');
                break;
            case 'LWOP':
                TH.setAttribute('title', 'Leave Without Pay');
                break;
            case 'AWOL':
                TH.setAttribute('title', 'Absent Without Official Leave');
                break;
            case 'TARD':
                TH.setAttribute('title', 'Tardiness');
                break;
            case 'UT':
                TH.setAttribute('title', 'Undertime');
                break;
            case 'EARB':
                TH.setAttribute('title', 'Early Break');
                break;
            case 'OVRB':
                TH.setAttribute('title', 'Over Break');
                break;

            case 'REG REG':
                TH.setAttribute('title', 'Regular Hours');
                break;
            case 'REG OT':
                TH.setAttribute('title', 'Regular Overtime');
                break;
            case 'REG ND':
                TH.setAttribute('title', 'Regular Night Differential');
                break;
            case 'REG NDOT':
                TH.setAttribute('title', 'Regular Night Differential / Overtime');
                break;

            case 'RST REG':
                TH.setAttribute('title', 'Rest Regular Hours');
                break;
            case 'RST OT':
                TH.setAttribute('title', 'Rest Overtime');
                break;
            case 'RST ND':
                TH.setAttribute('title', 'Rest Night Differential');
                break;
            case 'RST NDOT':
                TH.setAttribute('title', 'Rest Night Differential / Overtime');
                break;

            case 'LEG REG':
                TH.setAttribute('title', 'Legal Regular Hours');
                break;
            case 'LEG OT':
                TH.setAttribute('title', 'Legal Overtime');
                break;
            case 'LEG ND':
                TH.setAttribute('title', 'Legal Night Differential');
                break;
            case 'LEG NDOT':
                TH.setAttribute('title', 'Legal Night Differential / Overtime');
                break;

            case 'RST+LEG REG':
                TH.setAttribute('title', 'Rest + Legal Regular Hours');
                break;
            case 'RST+LEG OT':
                TH.setAttribute('title', 'Rest + Legal Overtime');
                break;
            case 'RST+LEG ND':
                TH.setAttribute('title', 'Rest + Legal Night Differential');
                break;
            case 'RST+LEG NDOT':
                TH.setAttribute('title', 'Rest + Legal Night Differential / Overtime');
                break;

            case 'SPE REG':
                TH.setAttribute('title', 'Special Regular Hours');
                break;
            case 'SPE OT':
                TH.setAttribute('title', 'Special Overtime');
                break;
            case 'SPE ND':
                TH.setAttribute('title', 'Special Night Differential');
                break;
            case 'SPE NDOT':
                TH.setAttribute('title', 'Special Night Differential / Overtime');
                break;

            case 'RST+SPE REG':
                TH.setAttribute('title', 'Rest + Special Regular Hours');
                break;
            case 'RST+SPE OT':
                TH.setAttribute('title', 'Rest + Special Overtime');
                break;
            case 'RST+SPE ND':
                TH.setAttribute('title', 'Rest + Special Night Differential');
                break;
            case 'RST+SPE NDOT':
                TH.setAttribute('title', 'Rest + Special Night Differential / Overtime');
                break;


            default:
                TH.setAttribute('title', '');
                break;
        }
    }

    hot = new Handsontable(container, {
        data: combinedData,
        colHeaders: true,
        rowHeaders: true,
        height: 'auto',
        colWidths: 70,
        nestedHeaders,
        outsideClickDeselects: false,
        selectionMode: 'multiple',
        licenseKey: 'non-commercial-and-evaluation',
        renderer: customStyleRenderer_new,
        readOnly: true,
        hiddenColumns,
        columns: columns,
        afterGetColHeader: col_header_title,
    });
    // hot.addHook('afterRender', afterRenderFunction);
    document.addEventListener('change', function (event) {
        if (event.target.id === 'checkAllCheckbox') {
            let isChecked = event.target.checked;
            // console.log(isChecked)
            for (const data of combinedData) {
                // console.log(data)
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

    let cutOff = document.getElementById('cut_off_period');
    let cutOffVal = cutOff.value;
    var insert = document.getElementById('btn-insert');
    insert.addEventListener('click', function () {
        const confirmed = confirm('Are you sure you want to update the data?');
        if (!confirmed) {
            return;
        }

        let anyCheckboxChecked = false;
        for (const data of combinedData) {
            if (data.isSelected) {
                anyCheckboxChecked = true;
                break;
            }
        }
        if (!anyCheckboxChecked) {
            $(document).Toasts('create', {
                class: 'bg-warning toast_width',
                title: 'Warning!',
                subtitle: 'close',
                body: 'Please select employee.'
            })
            return;
        }
        const updatedData = hot.getData();

        const requestData = {
            updatedData: updatedData,
            combinedData: combinedData,
            cutOffVal: cutOffVal,
            benefitsColumns: benefitsColumns,
        };
        // console.log(requestData)
        fetch(url + 'attendances/insert_data', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData),
        })
            .then(response => response.json())
            .then(result => {
                console.log(result);
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
                // console.log('Data update error:', error);
            });
    });
    // document.getElementById('printButton').addEventListener('click', function() {
    //   console.log('combinedData',combinedData)
    //   console.log('attendanceAbsences',attendanceAbsences)
    //   console.log('columns',columns)
    //   const hideColBtn         = document.getElementById('hide_col_btn');
    //   const addBtn             = document.getElementById('btn-add-row');
    //   const updateBtn          = document.getElementById('btn-update');
    //   const pageTitle          = document.getElementById('page_title');
    //   const originalStyles     = {
    //     hideColBtn: hideColBtn.style.display,
    //     addBtn: addBtn.style.display,
    //     updateBtn: updateBtn.style.display,
    //     pageTitle: pageTitle.style.display,
    //   };
    //   hideColBtn.style.display = 'none';
    //   addBtn.style.display     = 'none';
    //   updateBtn.style.display  = 'none';
    //   pageTitle.style.display  = 'none';
    //   this.style.display       = 'none';
    //   window.print();
    //   this.style.display       = 'block';
    //   hideColBtn.style.display = originalStyles.hideColBtn;
    //   addBtn.style.display     = originalStyles.addBtn;
    //   updateBtn.style.display  = originalStyles.updateBtn;
    //   pageTitle.style.display  = originalStyles.pageTitle;
    // });
    function getTimeVal(time1) {
        let time_hours = "";
        if (time1 != null) {
            const timeParts = time1.split(':');
            const hours = parseFloat(timeParts[0]);
            const minutes = parseFloat(timeParts[1]);
            const seconds = parseFloat(timeParts[2]);
            time_hours = hours + minutes / 60 + seconds / 3600;
        }
        return time_hours;
    }
</script>
<script>
    $(document).ready(function () {
        $("#printButton").click(function () {
            printTable();
        });

        function printTable() {
            const dateFormat = /\d{4}-\d{2}-\d{2}/;
            const selectedColumns = [];
            columnCheckboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    selectedColumns.push(checkbox.nextElementSibling.textContent);
                }
            });
            const notEmptyKeys = [];
            combinedData.forEach(obj => {
                Object.entries(obj).forEach(([key, value]) => {
                    if (value !== "" && value !== 0) {
                        if (!notEmptyKeys.includes(key)) {
                            notEmptyKeys.push(key);
                        }
                    }
                });
            });
            // console.log('notEmptyKeys', notEmptyKeys);
            let printTableHeader1 = [{
                colspan: 2,
                title: 'EMPLOYEE'
            }]
            let printTableHeader = ['col_empl_cmid', 'full_name'];
            if (!selectedColumns.includes("Attendance Record")) {
                printTableHeader = printTableHeader.concat(dateHeaders);
                printTableHeader1 = [...printTableHeader1, {
                    colspan: dateHeaders.length,
                    title: 'ATTENDANCE RECORD'
                }]
            }
            // print1
            if (!selectedColumns.includes("Absences")) {
                printTableHeader = printTableHeader.concat(attendanceAbsences);
                printTableHeader1 = [...printTableHeader1, {
                    colspan: attendanceAbsences.length,
                    title: 'ABSENCES'
                }]
                // const commonArray = notEmptyKeys.filter(item => attendanceAbsences.includes(item));
                // if (commonArray.length > 0) {
                //   printTableHeader = printTableHeader.concat(commonArray);
                //   printTableHeader1 = [...printTableHeader1,{colspan: commonArray.length, title: 'ABSENCES'} ]
                // }
            }
            if (!selectedColumns.includes("Deductions")) {
                printTableHeader = printTableHeader.concat(attendanceDeductions);
                printTableHeader1 = [...printTableHeader1, {
                    colspan: attendanceDeductions.length,
                    title: 'DEDUCTIONS'
                }]
                // const commonArray = notEmptyKeys.filter(item => attendanceDeductions.includes(item));
                // if (commonArray.length > 0) {
                //   printTableHeader = printTableHeader.concat(commonArray);
                //   printTableHeader1 = [...printTableHeader1,{colspan: commonArray.length, title: 'DEDUCTIONS'} ]
                // }
            }
            if (!selectedColumns.includes("REGULAR")) {
                // printTableHeader = printTableHeader.concat(typeREG);
                // printTableHeader1 = [...printTableHeader1,{colspan: typeREG.length, title: 'REGULAR'} ]
                const commonArray = notEmptyKeys.filter(item => typeREG.includes(item));
                if (commonArray.length > 0) {
                    printTableHeader = printTableHeader.concat(commonArray);
                    printTableHeader1 = [...printTableHeader1, {
                        colspan: commonArray.length,
                        title: 'REGULAR'
                    }]
                }
            }
            if (!selectedColumns.includes("REST")) {
                const commonArray = notEmptyKeys.filter(item => typeRST.includes(item));
                if (commonArray.length > 0) {
                    printTableHeader = printTableHeader.concat(commonArray);
                    printTableHeader1 = [...printTableHeader1, {
                        colspan: commonArray.length,
                        title: 'REST'
                    }]
                }
            }
            if (!selectedColumns.includes("LEGAL")) {
                const commonArray = notEmptyKeys.filter(item => typeLEG.includes(item));
                if (commonArray.length > 0) {
                    printTableHeader = printTableHeader.concat(commonArray);
                    printTableHeader1 = [...printTableHeader1, {
                        colspan: commonArray.length,
                        title: 'LEGAL'
                    }]
                }
            }
            if (!selectedColumns.includes("REST+LEGAL")) {
                const commonArray = notEmptyKeys.filter(item => typeRST_LEG.includes(item));
                if (commonArray.length > 0) {
                    printTableHeader = printTableHeader.concat(commonArray);
                    printTableHeader1 = [...printTableHeader1, {
                        colspan: commonArray.length,
                        title: 'REST+LEGAL'
                    }]
                }
            }
            // print 2
            if (!selectedColumns.includes("SPECIAL")) {
                const commonArray = notEmptyKeys.filter(item => typeSPE.includes(item));
                if (commonArray.length > 0) {
                    printTableHeader = printTableHeader.concat(commonArray);
                    printTableHeader1 = [...printTableHeader1, {
                        colspan: commonArray.length,
                        title: 'SPECIAL'
                    }]
                }
            }
            if (!selectedColumns.includes("REST+SPECIAL")) {
                const commonArray = notEmptyKeys.filter(item => typeRST_SPE.includes(item));
                if (commonArray.length > 0) {
                    printTableHeader = printTableHeader.concat(commonArray);
                    printTableHeader1 = [...printTableHeader1, {
                        colspan: commonArray.length,
                        title: 'REST+SPECIAL'
                    }]
                }
            }


            if (!selectedColumns.includes("Fixed Incentives")) {
                printTableHeader = printTableHeader.concat(benefitsTypeHeaders);
                printTableHeader1 = [...printTableHeader1, {
                    colspan: benefitsTypeHeaders.length,
                    title: 'FIXED INCENTIVES'
                }]
                // const commonArray = notEmptyKeys.filter(item => benefitsTypeHeaders.includes(item));
                // if (commonArray.length > 0) {
                //   printTableHeader = printTableHeader.concat(commonArray);
                //   printTableHeader1 = [...printTableHeader1,{colspan: commonArray.length, title: 'FIXED INCENTIVES'} ]
                // }
            }
            if (!selectedColumns.includes("Adjustment")) {
                printTableHeader = printTableHeader.concat(adjustmentTypeHeaders);
                printTableHeader1 = [...printTableHeader1, {
                    colspan: adjustmentTypeHeaders.length,
                    title: 'ADJUSTMENTS'
                }]
                // const commonArray = notEmptyKeys.filter(item => adjustmentTypeHeaders.includes(item));
                // if (commonArray.length > 0) {
                //   printTableHeader = printTableHeader.concat(commonArray);
                //   printTableHeader1 = [...printTableHeader1,{colspan: commonArray.length, title: 'ADJUSTMENTS'} ]
                // }
            }
            // console.log('columns', columns);
            // console.log('combinedData', combinedData);
            // console.log('printTableHeader', printTableHeader);
            // const filteredPrintTableHeader = printTableHeader.filter(item => {
            //   return combinedData.some(item2 => item2[item] !== '' && item2[item] !== 0);
            // });
            // console.log('filteredPrintTableHeader', filteredPrintTableHeader)
            const sumOfColspan = printTableHeader1.reduce((sum, item) => sum + item.colspan, 0);
            const currentDate = new Date();
            const months = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            const month = months[currentDate.getMonth()];
            const day = currentDate.getDate();
            const year = currentDate.getFullYear();
            let hours = currentDate.getHours();
            const minutes = currentDate.getMinutes();
            const amOrPm = hours >= 12 ? "PM" : "AM";
            hours = hours % 12 || 12;
            const formattedDateTime = `${month} ${day}, ${year} at ${hours}:${minutes < 10 ? '0' : ''}${minutes} ${amOrPm}`;
            var cutoffPeriods = <?php echo json_encode($CUTOFF_PERIODS); ?>;
            const selectedId = document.getElementById('cut_off_period').value;
            const selectedCutoff = cutoffPeriods.find(obj => obj.id === selectedId);
            const name = selectedCutoff ? selectedCutoff.name : "Not Found";
            // const name = cutoffPeriods.find(obj => obj.id === document.getElementById('cut_off_period').value).name;
            // console.log('printTableHeader', printTableHeader)
            // console.log('combinedData', combinedData)
            var printContents = ` 
          <table>
              <thead>
                  <tr>
                    <th colspan="${sumOfColspan}">
                      <h5>Attendance Summary</h5>
                      <h6>Cut-Off Period: ${name}</h6>
                      <p>Print Date: ${formattedDateTime}</p>
                    </th>
                  </tr>
                  <tr>
                  ${printTableHeader1.map(item => {
                return `<th class="bg-gray-ben" colspan="${item.colspan}">${item.title}</th>`
            }).join('')}
                  </tr>
                  <tr>
                    ${printTableHeader.map(item => {
                if (item === 'col_empl_cmid') return `<th class="bg-gray-ben">ID</th>`
                if (item === 'full_name') return `<th class="bg-gray-ben">NAME</th>`
                if (dateFormat.test(item)) return `<th class="text-vertical bg-gray-ben" >${convertDateFormat(item)}</th>`
                return `<th class="bg-gray-ben">${item}</th>`
            }).join('')}
                  </tr>
              </thead>
              <tbody>
                ${combinedData.map(item => `
                  <tr>
                    ${printTableHeader.map(key => {
                if (!item[key]) {
                    return (
                        `<td></td>`
                    )
                }
                return (
                    `<td>${item[key]}</td>`
                )
            }).join('')
                } 
  `).join('')}
              </tbody>
          </table>
        `;
            // Apply styles for printing
            var styleSheet = '<style type="text/css">';
            styleSheet += '@page { margin: 10px 10px; size: landscape; }';
            styleSheet += 'th, td { border: 1px solid #dddddd; text-align: center; font-size: 9px !important}';
            // styleSheet += 'th {background-color: #f2f2f2;}';
            // styleSheet += '.text-vertical{writing-mode: vertical-rl;white-space: nowrap;}';
            styleSheet += '.text-vertical{writing-mode: vertical-rl;white-space: nowrap;transform: rotate(180deg);}';
            styleSheet += '.bg-gray-ben{background: #f2f2f2 !important;-webkit-print-color-adjust: exact;}';
            styleSheet += '</style>';
            scaledContents = styleSheet + printContents;
            $("body").html(scaledContents);
            window.print();
            location.reload();
        }

        function convertDateFormat(originalFormat) {
            var dateComponents = originalFormat.split("-");
            var rearrangedFormat = dateComponents[2] + "/" + dateComponents[1] + "/" + dateComponents[0];
            return rearrangedFormat;
        }
    });
</script>
<script>
    // function changeTitle() {
    //   // document.title = "Attendance Summary";
    // }
    $(document).ready(function () {
        var base_url = '<?= base_url(); ?>';
        $('#row_dropdown').on('change', function (e) {
            e.preventDefault()
            var row_val = $(this).val();
            let data = "?page=1&row=" + row_val;
            filter_data(data);
        });
        $('.page_row').on('click', function (e) {
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
        $('select.cut_off_period').on('change', function () {
            afterRenderFunction();
            window.location.href = "<?= base_url('attendances/attendance_basic_view?period=') ?>" + $(this).val()
        });
      });
</script>
<!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> -->
<script src="<?= base_url() ?>assets_system/js/xlsx.full.min.js"></script>
<script>
    function exportToExcel() {
        const allHeaders = nestedHeaders[1];
        const visibleColumnIndices = allHeaders
            .map((_, index) => index)
            .filter(index => !hiddenColumns.columns.includes(index) && index !== 1);


        // Mapping for replacements
        const replacementMap = {
            'RC SUB': 'Rice Incentives',
            'RC ALO': 'Rice Allowance',
            'OVM ALO': 'OT Meal Allowance',
            'AWOL': 'Absences',
            'TARD': 'Tardiness',
            'UT': 'Undertime'
        };

        const visibleHeaders = visibleColumnIndices.map(index => allHeaders[index]);

        // Replace values in the array
        const updatedHeaders = visibleHeaders.map(header => replacementMap[header] || header);

        const visibleData = hot.getData().map(row =>
            row.filter((_, colIndex) => !hiddenColumns.columns.includes(colIndex) && colIndex !== 1)
        );

        var wb = XLSX.utils.book_new();
        // var ws = XLSX.utils.aoa_to_sheet(data);
        // console.log('visibleHeaders', visibleHeaders);
        const ws = XLSX.utils.aoa_to_sheet([updatedHeaders, ...visibleData]);

        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        var sheetName = wb.SheetNames[0];
        var sheet = wb.Sheets[sheetName];


        for (var cellAddress in sheet) {
            if (sheet.hasOwnProperty(cellAddress)) {
                var cell = sheet[cellAddress];
                if (cellAddress.startsWith('A') && /\d/.test(cell.v) && cell.t !== 'n') {
                    if (/^[a-zA-Z]+[0-9]+$/.test(cell.v)) {
                        // Do nothing or handle the special case for cells with a combination of letters and numbers
                    } else {
                        // Convert other cells to numbers
                        cell.t = 'n';
                        cell.v = +cell.v;
                    }
                }
            }
        }

        XLSX.writeFile(wb, 'attendance_summary.xlsx');
    }
</script>
</body>

</html>