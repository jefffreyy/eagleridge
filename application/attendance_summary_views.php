<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<?php
$search_data = $this->input->get('all');

$search_data = str_replace("_", " ", $search_data);

$PAGE=1;
$C_DATA_COUNT =0;
$PAGES_COUNT=0;
$TAB='active';
$ACTIVES=0;
$INACTIVES=0;
$ROW=25;

$current_page = $PAGE;
$next_page = $PAGE + 1;
$prev_page = $PAGE - 1;
$last_page = $PAGES_COUNT;
$row = $ROW;
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

<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
      <!-- <a href="<?= base_url() . 'payrolls'; ?>"><i class="fa-solid fa-square-left"></i> -->
        <h1 class="page-title"><a href="<?= base_url().'attendances';?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Attendance Summary<h1>
      </div>
      <div class="col-md-6 button-title">
        <a href="<?= base_url('attendances/add_attendance_summary') ?>" class="btn btn-success" id="btn-add-row"><i class="fa-solid fa-circle-plus"></i>&nbsp;Add Data</a>
        <a href="<?= base_url('attendances/edit_attendance_summary') ?>" class="btn btn-primary" id="btn-update"><i class="fa-duotone fa-pen-to-square"></i>&nbsp;Edit Data</a>

        <!--<a href="<?= base_url() . 'payrolls/add_loans' ?>" id="btn_new" class=" btn technos-button-green shadow-none rounded"><i class="fas fa-plus"></i>&nbsp;Add New Loan</a>-->
        <!--<a href="<?= base_url('payrolls/bulk_loans') ?>" id="bulk_import" class=" btn technos-button-green shadow-none rounded" ><i class="fas fa-file-import"></i>&nbsp;Bulk Import</a>-->
        <!-- <a id="btn_export" class=" btn technos-button-blue shadow-none rounded" ><i class="fas fa-file-pdf"></i>&nbsp;Export PDF</a> -->
      </div>
    </div>
    <div class=" py-3 w-25">
        <p class="p-0 my-1 text-bold">Cut-off Period</p>
        <select class="form-control cut_off_period">
        <?php foreach($CUTOFF_PERIODS as $cut_off) { ?>
            <option value="<?=$cut_off->id?>" <?= $PERIOD==$cut_off->id? 'selected' : '' ?>><?=$cut_off->name?></option>
        <?php } ?>
        </select>
    </div>
    <div class="card border-0 p-0 m-0">
      <div class="card border-0 p-1 m-0">
        <div class="card-header d-none p-0">
          <div class="row ">
            <div class="col-xl-8 ">
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link head-tab <?= $TAB == 'Active' ? 'active' : '' ?> " href="?page=1&row=<?= $row ?>&tab=Active" id="tab-Active" style='cursor:pointer'>
                    Active
                    <span class="ml-2 badge badge-pill badge-secondary"><?= $ACTIVES ?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="?page=1&row=<?= $row ?>&tab=Inactive" class="nav-link head-tab <?= $TAB == 'Inactive' ? 'active' : '' ?>" id="tab-Inactive" style='cursor:pointer'>
                    Inactive
                    <span class="ml-2 badge badge-pill badge-secondary"><?= $INACTIVES ?></span>
                  </a>
                </li>

              </ul>
            </div>
            <div class="col-xl-4">
              <div class="input-group pb-1">
                <?php 
                    if($search_data){ ?>
                    <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fa-regular fa-broom-wide" style="margin-top: 4px"></i>&nbsp;Clear</button>
                <?php } else{?>
                    <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
                <?php } ?>
                <input type="text" class="form-control" placeholder="Search..." value="<?= ($search_data) ? $search_data : ""?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
              </div>
            </div>
          </div>
        </div>
        <div class="p-2">
          
          <div>
            <!--<button class="btn technos-button-gray shadow-none rounded bulk-button" data-toggle="modal" data-target="#modal_set_ssa" id="mark_as_active">-->
            <!--  <i class=""></i>&nbsp;Mark as Active-->
            <!--</button>-->
            <!--<button class="btn technos-button-gray shadow-none rounded bulk-button" data-toggle="modal" data-target="#modal_set_ssa" id="mark_as_inactive">-->
            <!--  <i class=""></i>&nbsp;Mark as Inactive-->
            <!--</button>-->
            <!-- <div class="float-right ">
              <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
              <ul class="d-inline pagination m-0 p-0 ">
                <li ><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
                    < </a>
                </li>
                <li><a href="?page=1&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row&tab=$TAB'"; ?>>> </a></li>
              </ul>
              <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
              <select id="row_dropdown" class="custom-select" style="width: auto;">
                  <?php
                      foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) {?>
                          <option value=<?= $C_ROW_DISPLAY_ROW?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW?> </option>
                      <?php
                  } ?>
              </select>
            </div> -->
          </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="p-2">
                    <div id="table_data_new" > </div>
                    <!-- <div id="table_data" > </div> -->
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
<!-- ================================================================ new design End here ======================================================= -->

<!-- LOGOUT MODAL -->
<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p style="font-size: 400px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?
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

<?php $this->load->view('templates/jquery_link'); ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>


<!-- SESSION MESSAGES -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-------------------- Export ----------------->
<script>

  var employee_list     = <?php echo json_encode($DISP_EMPLOYEES); ?>;
  var cutoff_period     = <?php echo json_encode($CUTOFF_PERIOD); ?>;
  var log_in_out        = <?php echo json_encode($DISP_EMPLOYEES_ATTENDANCE_LOG); ?>;
  var log_shift_in_out  = <?php echo json_encode($DISP_EMPLOYEES_SHIFT); ?>;
  var benefits_type      = <?php echo json_encode($DISP_BENEFITS_BENEFITS_TYPE); ?>;
  var adjustment_type      = <?php echo json_encode($DISP_BENEFITS_ADJUSTMENT_TYPE); ?>;
  
  var dynamic_type            = <?php echo json_encode($DISP_BENEFITS_DYNAMIC_TYPE); ?>;
  var benefits_dynamic        = <?php echo json_encode($DISP_BENEFITS_DYNAMIC); ?>;
  var employeeListAssign      = <?php echo json_encode($DISP_EMPLOYEELIST_ASSIGN); ?>;
  var dynamic_std             = <?php echo json_encode($DISP_DYNAMIC_STD); ?>;
  var fixed_assign            = <?php echo json_encode($DISP_BENEFITS_FIXED_ASSIGN); ?>;
  var adjustment_assign       = <?php echo json_encode($DISP_BENEFITS_ADJUSTMENT_ASSIGN); ?>;
  
  var approved_ot            = <?php echo json_encode($DISP_ALL_APPROVED_OT); ?>;
  var benefit_loan            = <?php echo json_encode($DISP_BENEFITS_LOAN); ?>;
  
  // console.log(benefits_dynamic);

  var dynamicTypeMap = {};
  dynamic_type.forEach(function (item) {
    dynamicTypeMap[item.id] = item.name;
  });

 
  var dynamicStdMap = {};
  dynamic_std.forEach(function (item) {
    dynamicStdMap[item.name] = parseFloat(item.value);
  });

  var multipliedData = benefits_dynamic.map(function (benefit) {

    var employee = employeeListAssign.find(function (employee) {
      return employee.id === benefit.user_id;
    });

    if (employee && dynamicStdMap[employee.category]) {
      var count = parseInt(benefit.count);
      var categoryValue = dynamicStdMap[employee.category];
      var multipliedValue = count * categoryValue;

      var typeName = dynamicTypeMap[benefit.type];

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


  // console.log(fixed_assign);
  // console.log(benefits_type);
  
  const benefitsTypeHeaders = benefits_type.map(item => item.name); 
  const dynamicTypeHeaders = dynamic_type.map(item => item.name); 
  const adjustmentTypeHeaders = adjustment_type.map(item => item.name); 
  // console.log(benefitsTypeHeaders);


  const fromDate = new Date(cutoff_period.date_from);
  const toDate = new Date(cutoff_period.date_to);
  const dateHeaders = [];
  
  // const extendColumns = ['Rice Subsidy', 'OT Meal','SWC','CTPA','SEA','Transpo','VAC','Funeral','Rice Reward Incentives','RCBC Loan','Others'];
  const extendColumns = ['Rice Subsidy', 'OT Meal','Rice Reward','RCBC Loan'];

  while (fromDate <= toDate) {
      // let parts = fromDate.toISOString().split('T')[0].split('-');
      // let newDate = `${parts[2]}/${parts[1]}`;
      dateHeaders.push(fromDate.toISOString().split('T')[0]);
      fromDate.setDate(fromDate.getDate() + 1);
  }

  // console.log(dateHeaders)

  // Create a new array that combines dispEmpList and dateHeaders
  var combinedData = employee_list.map(function(empData) {
      var combinedRow = {
          id: empData.id,
          col_empl_cmid: empData.col_empl_cmid,
          full_name: empData.fullname
      };

      worked_hours    = 0;
      rice_subsidy    = 0;
      ot_meal         = 0;
      rice_reward     = 0;
      
      let ot_data = 0;
      let loan_amount = 0;
      let loan_term = 0;

      dateHeaders.forEach(function(dateHeader) {
        const logs = log_in_out.find(item => item.date === dateHeader && item.empl_id === empData.id);
        const shift = log_shift_in_out.find(item => item.date === dateHeader && item.empl_id === empData.id);

        const ot = approved_ot.find(item => item.date_ot === dateHeader && item.empl_id === empData.id);
        const loan = benefit_loan.find(item => item.loan_date === dateHeader && item.empl_id === empData.id);

        if(loan){
          loan_amount += parseInt(loan.loan_amount);
          loan_term += parseInt(loan.loan_terms)
        }

        if(ot){
          ot_data = ot.hours;
        }

        if(logs){
          act_time_in = logs.time_in;
          act_time_out = logs.time_out;
          shift_time_in = shift.time_regular_start;
          shift_time_out = shift.time_regular_end;
          shift_reg_hrs = shift.time_regular_reg;

          tardiness_raw =  getTimeVal(act_time_in) - getTimeVal(shift_time_in);

          undertime_raw =  getTimeVal(shift_time_out) - getTimeVal(shift_time_out);
          if(tardiness_raw <= 0){ tardiness = 0;  }
          else if(tardiness_raw > 0 && tardiness_raw <= 15){ tardiness = 0.25; }
          else if(tardiness_raw > 15 && tardiness_raw <= 30){ tardiness = 0.5; }
          else if(tardiness_raw > 30 && tardiness_raw <= 45){ tardiness = 0.75; }
          else if(tardiness_raw > 45 && tardiness_raw <= 60){ tardiness = 1; }
          else if(tardiness_raw > 60 && tardiness_raw <= 75){ tardiness = 1.25; }
          else if(tardiness_raw > 75 && tardiness_raw <= 90){ tardiness = 1.50; }
          else if(tardiness_raw > 90 && tardiness_raw <= 105){ tardiness = 1.75; }
          else if(tardiness_raw > 105 && tardiness_raw <= 120){ tardiness = 2.0; }
          else if(tardiness_raw > 120 && tardiness_raw <= 135){ tardiness = 2.25; }
          else if(tardiness_raw > 135 && tardiness_raw <= 150){ tardiness = 2.5; }
          else if(tardiness_raw > 150 && tardiness_raw <= 165){ tardiness = 2.75; }
          else if(tardiness_raw > 165 && tardiness_raw <= 180){ tardiness = 3.0; }
          else if(tardiness_raw > 180 && tardiness_raw <= 195){ tardiness = 3.25; }
          else if(tardiness_raw > 195 && tardiness_raw <= 210){ tardiness = 3.5; }
          else if(tardiness_raw > 210 && tardiness_raw <= 225){ tardiness = 3.75; }        
          else if(tardiness_raw > 225 && tardiness_raw <= 240){ tardiness = 4.0; }       

          if(undertime_raw <= 0){    undertime = 0;   }
          else if(undertime_raw > 0 && undertime_raw <= 15){ undertime = 0.25; }
          else if(undertime_raw > 15 && undertime_raw <= 30){ undertime = 0.5; }
          else if(undertime_raw > 30 && undertime_raw <= 45){ undertime = 0.75; }
          else if(undertime_raw > 45 && undertime_raw <= 60){ undertime = 1; }
          else if(undertime_raw > 60 && undertime_raw <= 75){ undertime = 1.25; }
          else if(undertime_raw > 75 && undertime_raw <= 90){ undertime = 1.50; }
          else if(undertime_raw > 90 && undertime_raw <= 105){ undertime = 1.75; }
          else if(undertime_raw > 105 && undertime_raw <= 120){ undertime = 2.0; }
          else if(undertime_raw > 120 && undertime_raw <= 135){ undertime = 2.25; }
          else if(undertime_raw > 135 && undertime_raw <= 150){ undertime = 2.5; }
          else if(undertime_raw > 150 && undertime_raw <= 165){ undertime = 2.75; }
          else if(undertime_raw > 165 && undertime_raw <= 180){ undertime = 3.0; }
          else if(undertime_raw > 180 && undertime_raw <= 195){ undertime = 3.25; }
          else if(undertime_raw > 195 && undertime_raw <= 210){ undertime = 3.5; }
          else if(undertime_raw > 210 && undertime_raw <= 225){ undertime = 3.75; }        
          else if(undertime_raw > 225 && undertime_raw <= 240){ undertime = 4.0; }    
      
          // work_hours = act_time_out - act_time_in;
          // millisecondss = work_hours.getMilliseconds();
          // combinedRow[dateHeader] = `${logs.time_in}, ${logs.time_out},${shift.time_regular_start},${shift.time_regular_end}`; 

          worked_hours = shift_reg_hrs - undertime - tardiness;
          combinedRow[dateHeader] = `${worked_hours} (${ot_data})`;

          if(worked_hours >= 8){
            rice_subsidy    += 12;
          
          }
          if(ot_data >= 3){
            ot_meal         += 36;
          }

          if(worked_hours >= 8){
            rice_reward    += 1;
          }

          if(worked_hours + ot_data >= 16){
            rice_reward    += 1;
          }
          // else if(worked_hours + ot_data >= 8 && worked_hours + ot_data < 16){
          //   rice_reward    += 1;
          // }
         
         
   

          
        }
        
        else{
          worked_hours = 0;
           combinedRow[dateHeader] = ""; 
        }
        
       
      });

     
      extendColumns.forEach(function(extendColumn) {

        if(extendColumn == "Rice Subsidy"){
          if(rice_subsidy){
            combinedRow[extendColumn] = rice_subsidy; 
          }else{
            combinedRow[extendColumn] = '';
          }
        }

        if(extendColumn == "OT Meal"){
          if(ot_meal){
            combinedRow[extendColumn] = ot_meal; 
          }else{
            combinedRow[extendColumn] = '';
          }
        }

        if(extendColumn == "Rice Reward"){
          if(rice_reward){
            combinedRow[extendColumn] = rice_reward;  
          }else{
            combinedRow[extendColumn] = '';
          }
          
        }
    
        if(extendColumn == "RCBC Loan"){
          const loan_data = benefit_loan.find(item => item.empl_id === empData.id);
          if(loan_data && loan_amount != 0){
            combinedRow[extendColumn] = (loan_amount / loan_term).toFixed(2);
          }else{
            combinedRow[extendColumn] = '';
          }
        }

        // if(extendColumn == "Others"){
        //   combinedRow[extendColumn] = 345; 
        // }
        
      });

  
      dynamicTypeHeaders.forEach(function(dynamicTypeHeader) {
   
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
          return item.name === benefitsTypeHeader ;
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
          return item.name === adjustmentTypeHeader ;
        });

        if(adjustmentType){
          let adjustmentAssign = adjustment_assign.find(function(item){
            return item.type === adjustmentType.id.toString() && empData.id === item.user_id;
          })

          if(adjustmentAssign){
            combinedRow[adjustmentTypeHeader] = adjustmentAssign.value;
          }else{
            combinedRow[adjustmentTypeHeader] = ''; 
          }
        }else {
          combinedRow[adjustmentTypeHeader] = ''; 
        }
        
      });

      return combinedRow;
  });

// console.log(combinedData)
    const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        td.style.whiteSpace = 'nowrap';
        td.style.overflow = 'hidden';
        // td.style = 'hidden';
    };

    const container = document.querySelector('#table_data_new');
    hot = new Handsontable(container, {
        data: combinedData, 
        colHeaders: ['ID','Employee ID','Employee Name', ...dateHeaders, ...extendColumns, ...dynamicTypeHeaders, ...benefitsTypeHeaders, ...adjustmentTypeHeaders ],
        rowHeaders: true,
        height: 'auto',
        outsideClickDeselects: false,
        selectionMode: 'multiple',
        licenseKey: 'non-commercial-and-evaluation',
        // Custom renderer to prevent text wrapping
        renderer: customStyleRenderer_new,
        readOnly: true,
        hiddenColumns: {
          columns: [0],
          indicators: true,
        },
        
    });
    hot.updateSettings({
 
    });

  function getTimeVal(time1) {
    let time_hours = "";

    if(time1 != null){
      const timeParts = time1.split(':');
      // Get the hours, minutes, and seconds from the array
      const hours = parseFloat(timeParts[0]);
      const minutes = parseFloat(timeParts[1]);
      const seconds = parseFloat(timeParts[2]);
      time_hours = hours + minutes/60 + seconds/3600;
    }

    return time_hours;
  }

</script>

<script>

    // var employee_list = <?php echo json_encode($DISP_EMPLOYEES); ?>;
    // var summary = <?php echo json_encode($DISP_EMPLOYEELIST_SUMMARY); ?>;

    // // Function to find the employee name by empl_id
    // function findEmployeeNameById(emplId) {
    //   const employee = employee_list.find(emp => emp.id === emplId);
    //   return employee ? employee.fullname : 'Employee not found';
    // }
    // function findEmployeeCmidById(emplId) {
    //   const employee = employee_list.find(emp => emp.id === emplId);
    //   return employee ? employee.col_empl_cmid : 'Employee not found';
    // }

    // const convertedSummary = summary.map(summary => {
    //   const employeeName = findEmployeeNameById(summary.empl_id);
    //   const cmid = findEmployeeCmidById(summary.empl_id);
    //   return {
    //     empl_id: summary.empl_id,
    //     cmid: cmid,
    //     employee_name: employeeName,
    //     ...summary
    //   };
    // });
    // // console.log(convertedSummary);

    // const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
    //     Handsontable.renderers.TextRenderer.apply(this, arguments);
    //     td.style.whiteSpace = 'nowrap';
    //     td.style.overflow = 'hidden';
    // };

    // const container = document.querySelector('#table_data');
    //         hot = new Handsontable(container, {
    //             data: convertedSummary, 
    //             colHeaders: ['ID','Employee ID','Employee Name',"Days Present", "Absent", "Tardiness", "Undertime", "Paid Leave", 
    //             "Regular HR", "Regular OT", "Regular ND", "Regular NDOT", 
    //             "Rest HR", "Rest OT", "Rest ND", "Rest NDOT",
    //              "Legal HR", "Legal OT", "Legal ND", "Legal NDOT", 
    //              "Legal Rest HR", "Legal Rest OT", "Legal Rest ND", "Legal Rest NDOT", 
    //              "Special HR", "Special OT", "Special ND", "Special NDOT", 
    //              "Special Rest HR", "Special Rest OT", "Special Rest ND", "Special Rest NDOT", "Status",
    //              "adjustments","internet_fee","medical_fee","rice_allowance","rest_day_ot","lhot","regular",
    //              "st_hours","rcbc_loan","uniform","bonus","il_sl_conversion","swc","electricity_allwance","meal_allowance","meal_electricity_and_internet","ot_meal"
    //             ],
    //             rowHeaders: true,
    //             height: 'auto',
    //             outsideClickDeselects: false,
    //             selectionMode: 'multiple',
    //             licenseKey: 'non-commercial-and-evaluation',
    //             // Custom renderer to prevent text wrapping
    //             renderer: customStyleRenderer,
    //             readOnly: true,
    //             hiddenColumns: {
    //               columns: [0],
    //               indicators: true,
    //             },
    //         });
</script>

<script>
    $(document).ready(function(){
        $('select.cut_off_period').on('change',function(){
            window.location.href="<?=base_url('attendances/attendance_summary?period=')?>"+$(this).val()
        })
    })
</script>
</body>

</html>