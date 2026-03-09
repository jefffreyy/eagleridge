<html>
<?php $this->load->view('templates/css_link'); ?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<style>
  .check_approved{
    color: #3ec769;
    font-size: 18px;
  }
</style>
<?php 

    if (isset($_GET['cutoff'])) {
    $cutoff = $_GET['cutoff'];
    } else {
    $cutoff = $CUTOFF_INITIAL;
    }


  if(isset($_GET['row'])){
    $row = $_GET['row'];
  }
  else{
    $row = 10;
  }

   if(isset($_GET['page']))
   {
    $current_page = $_GET['page'];
   }else{
    $current_page = 1;
   }

   $prev_page = $current_page - 1;
   $next_page = $current_page + 1;
   $last_page = intval($C_DATA_COUNT/$row) + 1;
                            
  if($C_DATA_COUNT == 0){
      $low_limit = 0;
  }
  else{
      $low_limit = $row*($current_page - 1) + 1;
  }
  if($current_page*$row > $C_DATA_COUNT){
      $high_limit = $C_DATA_COUNT;
  }
  else{
      $high_limit = $row*($current_page);
  }
?>
<body>

  <div class="content-wrapper">
    <div class="container-fluid p-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url() ?>payrolls">Payroll</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Payroll Payslip
          </li>
        </ol>
      </nav>
      <div class="row pt-1">
        <div class="col-md-6">
          <h1 class="page-title">Payroll Payslip<h1>
        </div>
      </div>
      <hr>
      <div class="row mb-4">
        <div class="col-md-2">
            <p class="mb-1 text-secondary ">Cut-off</p>
            <select name="filter_cutoff" id="filter_cutoff" class="form-control">
                <?php
                
                if ($DISP_CUTOFF) {
                foreach ($DISP_CUTOFF as $DISP_CUTOFF_ROW) {
                ?>
                    <option value="<?= $DISP_CUTOFF_ROW->id ?>" <?php echo ($cutoff == $DISP_CUTOFF_ROW->id ? 'selected' : '') ?>>
                    <?= $DISP_CUTOFF_ROW->name ?>
                    </option>
                <?php
                }
                }
                ?>
            </select>
        </div>

        <div class="col-md-2">
          <p class="mb-1 text-secondary ">Action</p>
          <a href=<?= base_url() . "payrolls/payroll_payslips" ?> id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
        </div>
      </div>
      
      <div class="card border-0 p-0 m-0">
        <!-- <div class="p-1">
          <div class="col-md-4 pl-0">
            <div class="input-group p-1 pt-2">
              <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
              <input type="text" class="form-control" placeholder="Search" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
            </div>
          </div>
        </div> -->
        <div class="card border-0 p-0 m-0">
          <div class="p-2">
            <div>
              <div class="float-right ">
              <p class ="p-0 m-0 d-inline" style = "color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT?> entries&nbsp;</p>
                <ul class="d-inline pagination m-0 p-0 ">
                <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>> < </a></li>
                  <li><a href = "?page=1&row=<?=$row?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                  <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                  <li><a href = "?page=<?= $current_page - 1?>&row=<?=$row?>"   <?php if ($current_page <= 2) echo "hidden";?>><?= $prev_page?></a></li>
                  <li><a style = "color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                  <li><a href = "?page=<?= $current_page + 1?>&row=<?=$row?>"  <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>  ><?= $next_page?>  </a></li>
                  <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>...  </a></li>
                  <li><a href = "?page=<?= $last_page?>&row=<?=$row?>" <?php if ($current_page == $last_page) echo "hidden"; ?>><?= $last_page?> </a></li>
                  <li><a style="margin-right: 10px;"    <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>>    </a></li>
                </ul>
                <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                <select id="row_dropdown" class="custom-select" style="width: auto;">
                  <?php
                      foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) {?>
                          <option value=<?= $C_ROW_DISPLAY_ROW?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW?> </option>
                      <?php
                  } ?>
                </select>
              </div>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-hover m-0" id="TableToExport" style="width:100%">
              <thead>
                <tr>
                    <th>Employee&nbsp;Id</th>
                    <th>Employee&nbsp;Name</th>
                    <th>Saraly&nbsp;Rate</th>
                    <th>Work&nbsp;Rate</th>
                    <th>Daily&nbsp;Salary</th>
                    <th>Hourly&nbsp;Salary</th>
                    <th>Payroll&nbsp;Period</th>
                    <th>Payroll&nbsp;type</th>
                    <th>Salary&nbsp;Type</th>
                    <th>Working&nbsp;Days</th>
                    <th>Hours&nbsp;of&nbsp;Work</th>
                    <th>Ti&nbsp;Basic&nbsp;Sal&nbsp;Mul</th>
                    <th>Ti&nbsp;Basic&nbsp;Sal&nbsp;Total</th>
                    <th>Ti&nbsp;Absent&nbsp;Mul</th>
                    <th>Ti&nbsp;Absent&nbsp;Total</th>
                    <th>Ti&nbsp;No&nbsp;Ti&nbsp;to&nbsp;Mul</th>
                    <th>Ti&nbsp;No&nbsp;Ti&nbsp;to&nbsp;Total</th>
                    <th>Ti&nbsp;Tard&nbsp;Mul</th>
                    <th>Ti&nbsp;Tard&nbsp;Total</th>
                    <th>Ti&nbsp;Half&nbsp;Mul</th>
                    <th>Ti&nbsp;Half&nbsp;Total</th>
                    <th>Ti&nbsp;Undertime&nbsp;Mul</th>
                    <th>Ti&nbsp;Undertime&nbsp;Total</th>
                    <th>Ti&nbsp;Rest&nbsp;Mul</th>
                    <th>Ti&nbsp;Rest&nbsp;Total</th>
                    <th>Ti&nbsp;Rest&nbsp;SP&nbsp;Hol&nbsp;Mul</th>
                    <th>Ti&nbsp;Rest&nbsp;SP&nbsp;Hol&nbsp;Total</th>
                    <th>Ti&nbsp;Legal&nbsp;Hol&nbsp;Mul</th>
                    <th>Ti&nbsp;Legal&nbsp;Hol&nbsp;Total</th>
                    <th>Ti&nbsp;Rest&nbsp;Legal&nbsp;hol&nbsp;Mul</th>
                    <th>Ti&nbsp;Rest&nbsp;Legal&nbsp;hol&nbsp;Total</th>
                    <th>Ti&nbsp;Reg&nbsp;OT&nbsp;Mul</th>
                    <th>Ti&nbsp;Reg&nbsp;OT&nbsp;Total</th>
                    <th>Ti&nbsp;Nd&nbsp;OT&nbsp;Mul</th>
                    <th>Ti&nbsp;Nd&nbsp;OT&nbsp;Total</th>
                    <th>Ti&nbsp;Nd&nbsp;Mul</th>
                    <th>Ti&nbsp;Nd&nbsp;Total</th>
                    <th>Ti&nbsp;Rest&nbsp;OT&nbsp;Mul</th>
                    <th>Ti&nbsp;Rest&nbsp;OT&nbsp;Total</th>
                    <th>Ti&nbsp;Rest&nbsp;Nd&nbsp;OT&nbsp;Mul</th>
                    <th>Ti&nbsp;Rest&nbsp;Nd&nbsp;OT&nbsp;Total</th>
                    <th>Ti&nbsp;Leave&nbsp;Mul</th>
                    <th>Ti&nbsp;Leave&nbsp;Total</th>
                    <th>Ti&nbsp;Meal</th>
                    <th>Ti&nbsp;Gov&nbsp;Cont</th>
                    <th>Ti&nbsp;Others</th>
                    <th>Ti&nbsp;De&nbsp;Minimis&nbsp;Mul</th>
                    <th>Ti&nbsp;De&nbsp;Minimis&nbsp;Total</th>
                    <th>Ti&nbsp;Gross</th>
                    <th>Gov&nbsp;SSS&nbsp;EE</th>
                    <th>Gov&nbsp;Philhealth&nbsp;EE</th>
                    <th>Gov&nbsp;Pagibig&nbsp;EE</th>
                    <th>Gov&nbsp;Total&nbsp;dd</th>
                    <th>Comp&nbsp;Cont&nbsp;SSS</th>
                    <th>Comp&nbsp;Cont&nbsp;SSS&nbsp;EC</th>
                    <th>Comp&nbsp;Cont&nbsp;Philhealth</th>
                    <th>Comp&nbsp;Cont&nbsp;Pagibig</th>
                    <th>Comp&nbsp;Cont&nbsp;Total</th>
                    <th>Ta&nbsp;Load</th>
                    <th>Ta&nbsp;Transportation</th>
                    <th>Ta&nbsp;Skill</th>
                    <th>Ta&nbsp;Pioneer</th>
                    <th>Ta&nbsp;Group&nbsp;Leader</th>
                    <th>Ta&nbsp;Daily&nbsp;Allowance</th>
                    <th>Ta&nbsp;Total</th>
                    <th>Wtax</th>
                    <th>Loan&nbsp;SSS&nbsp;Salary</th>
                    <th>Loan&nbsp;SSS&nbsp;Calamity</th>
                    <th>Loan&nbsp;Pagibig&nbsp;Salary</th>
                    <th>Loan&nbsp;Pagibig&nbsp;Calamity</th>
                    <th>Loan&nbsp;Emergency</th>
                    <th>Loan&nbsp;Total</th>
                    <th>Tax&nbsp;Refund</th>
                    <th>Ti&nbsp;Sil&nbsp;2020</th>
                    <th>Salary&nbsp;Advance</th>
                    <th>Uniform&nbsp;Deduction</th>
                    <th>Ded&nbsp;Total</th>
                    <th>Net&nbsp;Pay</th>
                    <th>Loan&nbsp;SSS&nbsp;Salary&nbsp;Calamity&nbsp;Total</th>
                    <th>Loan&nbsp;Pagibig&nbsp;Salary&nbsp;Calamity&nbsp;Total</th>
                    <th>Total&nbsp;Earnings</th>
                    <th>Total&nbsp;Earnings</th>
                    <th>Total&nbsp;Deductions</th>
                    <th>Status</th>
                </tr>
              </thead>
              <tbody id="tbl_application_container">
              <?php if($DISP_ATTENDANCE_LOCK) {
                    foreach($DISP_ATTENDANCE_LOCK as $DISP_ATTENDANCE_LOCK_ROW ){  ?>
                    <tr>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->empl_id?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->empl_name?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->salary_rate?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->work_rate?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->daily_salary?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->hourly_salary?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->payroll_period?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->payroll_type?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->salary_type?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->working_days?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->hours_of_work?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_basic_sal_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_basic_sal_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_absent_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_absent_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_no_ti_to_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_no_ti_to_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_tard_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_tard_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_half_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_half_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_undertime_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_undertime_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_rest_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_rest_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_rest_sp_hol_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_rest_sp_hol_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_legal_hol_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_legal_hol_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_rest_legal_hol_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_rest_legal_hol_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_reg_ot_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_reg_ot_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_nd_ot_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_nd_ot_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_nd_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_nd_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_rest_ot_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_rest_ot_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_rest_nd_ot_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_rest_nd_ot_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_leave_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_leave_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_meal?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_gov_cont?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_others?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_de_minimis_mul?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_de_minimis_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_gross?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->gov_sss_ee?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->gov_philhealth_ee?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->gov_pagibig_ee?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->gov_total_ee?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->comp_cont_sss?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->comp_cont_sss_ec?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->comp_cont_philhealth?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->comp_cont_pagibig?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->comp_cont_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ta_load?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ta_transportation?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ta_skill?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ta_pioneer?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ta_group_leader?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ta_daily_allowance?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ta_allowance?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ta_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->wtax?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->loan_sss_salary?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->loan_sss_calamity?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->loan_pagibig_salary?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->loan_pagibig_calamity?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->loan_emergency?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->loan_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->tax_refund?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ti_sil_2020?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->salary_advance?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->uniform_deduction?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->ded_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->net_pay?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->loan_sss_salary_calamity_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->loan_pagibig_salary_calamity_total?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->total_earnings?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->total_deductions?></td>
                        <td><?=$DISP_ATTENDANCE_LOCK_ROW->status?></td>
                    </tr>
              <?php   } 
                  }else { ?>
                  <tr class="table-active">
                    <td colspan="100%">
                      <center>No Data</center>
                    </td>
                  </tr>
              <?php }  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- Content Ends -->

  <aside class="control-sidebar control-sidebar-dark">
  </aside>

  <?php $this->load->view('templates/jquery_link'); ?>

  <!-- SESSION MESSAGES -->
  <?php
  if ($this->session->userdata('SESS_SUCC_MSG_INSRT_CSV')) {
  ?>
    <script>
      Swal.fire(
        '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_CSV'); ?>',
        '',
        'success'
      )
    </script>
  <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_CSV');
  }
  ?>


  <script>
$(document).ready(function() {

  var base_url = '<?= base_url(); ?>';


    $("#filter_cutoff").on("change", function() {
        filter_data();
    })

    function filter_data() {
        let cutoff = $("#filter_cutoff").find(":selected").val();

        window.location = base_url + "payrolls/payroll_payslips?cutoff=" + cutoff;
      }

    $('#row_dropdown').on('change', function () {
        var row_val = $(this).val(); 
        document.location.href = base_url + "payrolls/payroll_payslips?page=1&row=" + row_val ; 
    });

});



  </script>
  <!-------------------- Export ----------------->
  <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
  <script>
    document.getElementById("btn_export").addEventListener('click', function() {
      /* Create worksheet from HTML DOM TABLE */
      var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
      /* Export to file (start a download) */
      XLSX.writeFile(wb, "Route Leave.xlsx");
    });
  </script>
</body>

</html>