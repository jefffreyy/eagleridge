<style>
  .btn-group .btn{
    padding: 0px 12px;
  }
  .page-title{
    font-weight: 600;
    color: #424F5C;
    font-size: 33px;
  }
  th,td{
    font-size: 13px !important;
  }
  label.required::after{
    content:" *";
    color: red;
  }
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
  input[type=number] {
    -moz-appearance: textfield;
  }

  #work_hours{
    border: none!important;
    background-color: #fff !important;
  }

  #working_days{
    padding-left: 0px;
    border: none !important;
    background-color: #fff !important;
  }
  
  #salary_rate{
    padding-left: 0px;
    border: none !important;
    background-color: #fff !important;
  }
  
  #salary_type{
    padding-left: 0px;
    border: none !important;
    background-color: #fff !important;
  }
  
</style>
<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Daterange Picker -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/daterangepicker/daterangepicker.css">
<!-- Tempus Dominus -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Facebox -->
<link href="<?=base_url()?>facebox/facefiles/facebox.css" media="screen" rel="stylesheet" type="text/css" />

<?php
  $user_info = $this->login_model->get_user_info($this->session->userdata('SESS_USER_ID'));
  $user_type = '';
  
  foreach($user_info as $info)
  {
      $user_type = $info->col_user_type;
  }
?>
<div class="content-wrapper" style="height: 100vh !important;">
    <div class="p-3">
        <div class="flex-fill">
          <!-- form -->
          <form action="<?php echo base_url('payroll/insrt_payroll_data'); ?>" id="form_insert_data" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
              <!-- for loan -->
              <input type="hidden" value="0" name="cutoff_period" class="cutoff_period">
              <input type="hidden" value="0" name="empl_cmid" class="empl_cmid">
              <input type="hidden" value="0" name="salary_type" class="salary_type">

              <!-- header -->
              <input type="hidden" value="0" name="empl_id" class="empl_id">
              <input type="hidden" value="0" name="empl_name" class="empl_name">
              <input type="hidden" value="0" name="salary_rate" class="salary_rate">
              <input type="hidden" value="0" name="work_rate" class="work_rate">
              <input type="hidden" value="0" name="daily_salary" class="daily_salary">
              <input type="hidden" value="0" name="hourly_salary" class="hourly_salary">
              <input type="hidden" value="0" name="payroll_period" class="payroll_period">
              <input type="hidden" value="0" name="working_days" class="working_days">
              <input type="hidden" value="0" name="hours_of_work" class="hours_of_work">
              
              <!-- multiplier -->
              <input type="hidden" value="0" name="ti_basic_sal_mul" class="ti_basic_sal_mul">
              <input type="hidden" value="0" name="ti_absent_mul" class="ti_absent_mul">
              <input type="hidden" value="0" name="ti_no_ti_to_mul" class="ti_no_ti_to_mul">
              <input type="hidden" value="0" name="ti_tard_mul" class="ti_tard_mul">
              <input type="hidden" value="0" name="ti_half_mul" class="ti_half_mul">
              <input type="hidden" value="0" name="ti_undertime_mul" class="ti_undertime_mul">
              <input type="hidden" value="0" name="ti_rest_mul" class="ti_rest_mul">
              <input type="hidden" value="0" name="ti_rest_sp_hol_mul" class="ti_rest_sp_hol_mul">
              <input type="hidden" value="0" name="ti_legal_hol_mul" class="ti_legal_hol_mul">
              <input type="hidden" value="0" name="ti_rest_legal_hol_mul" class="ti_rest_legal_hol_mul">
              <input type="hidden" value="0" name="ti_reg_ot_mul" class="ti_reg_ot_mul">
              <input type="hidden" value="0" name="ti_nd_ot_mul" class="ti_nd_ot_mul">
              <input type="hidden" value="0" name="ti_nd_mul" class="ti_nd_mul">
              <input type="hidden" value="0" name="ti_leave_mul" class="ti_leave_mul">
              <input type="hidden" value="0" name="ti_de_minimis_mul" class="ti_de_minimis_mul">
              <input type="hidden" value="0" name="ti_rest_ot_mul" class="ti_rest_ot_mul">
              <input type="hidden" value="0" name="ti_rest_nd_ot_mul" class="ti_rest_nd_ot_mul">

              <!-- total -->
              <input type="hidden" value="0" name="ti_basic_sal_total" class="ti_basic_sal_total">
              <input type="hidden" value="0" name="ti_absent_total" class="ti_absent_total">
              <input type="hidden" value="0" name="ti_no_ti_to_total" class="ti_no_ti_to_total">
              <input type="hidden" value="0" name="ti_tard_total" class="ti_tard_total">
              <input type="hidden" value="0" name="ti_half_total" class="ti_half_total">
              <input type="hidden" value="0" name="ti_undertime_total" class="ti_undertime_total">
              <input type="hidden" value="0" name="ti_rest_total" class="ti_rest_total">
              <input type="hidden" value="0" name="ti_rest_sp_hol_total" class="ti_rest_sp_hol_total">
              <input type="hidden" value="0" name="ti_legal_hol_total" class="ti_legal_hol_total">
              <input type="hidden" value="0" name="ti_rest_legal_hol_total" class="ti_rest_legal_hol_total">
              <input type="hidden" value="0" name="ti_reg_ot_total" class="ti_reg_ot_total">
              <input type="hidden" value="0" name="ti_nd_ot_total" class="ti_nd_ot_total">
              <input type="hidden" value="0" name="ti_nd_total" class="ti_nd_total">
              <input type="hidden" value="0" name="ti_leave_total" class="ti_leave_total">
              <input type="hidden" value="0" name="ti_de_minimis_total" class="ti_de_minimis_total">
              <input type="hidden" value="0" name="ti_rest_ot_total" class="ti_rest_ot_total">
              <input type="hidden" value="0" name="ti_rest_nd_ot_total" class="ti_rest_nd_ot_total">

              <!-- no mul -->
              <input type="hidden" value="0" name="ti_sil_2020" class="ti_sil_2020">
              <input type="hidden" value="0" name="ti_meal" class="ti_meal">
              <input type="hidden" value="0" name="ti_gov_cont" class="ti_gov_cont">
              <input type="hidden" value="0" name="ti_others" class="ti_others">
              <input type="hidden" value="0" name="ti_gross" class="ti_gross">

              <input type="hidden" value="0" name="gov_sss_ee" class="gov_sss_ee">
              <input type="hidden" value="0" name="gov_philhealth_ee" class="gov_philhealth_ee">
              <input type="hidden" value="0" name="gov_pagibig_ee" class="gov_pagibig_ee">
              <input type="hidden" value="0" name="gov_total_ee" class="gov_total_ee">

              <input type="hidden" value="0" name="comp_cont_sss" class="comp_cont_sss">
              <input type="hidden" value="0" name="comp_cont_sss_ec" class="comp_cont_sss_ec">
              <input type="hidden" value="0" name="comp_cont_philhealth" class="comp_cont_philhealth">
              <input type="hidden" value="0" name="comp_cont_pagibig" class="comp_cont_pagibig">
              <input type="hidden" value="0" name="comp_cont_total" class="comp_cont_total">
              
              <input type="hidden" value="0" name="ta_load" class="ta_load">
              <input type="hidden" value="0" name="ta_transportation" class="ta_transportation">
              <input type="hidden" value="0" name="ta_skill" class="ta_skill">
              <input type="hidden" value="0" name="ta_pioneer" class="ta_pioneer">
              <input type="hidden" value="0" name="ta_group_leader" class="ta_group_leader">
              <input type="hidden" value="0" name="ta_daily_allowance" class="ta_daily_allowance"> <!--  ================= NEW =========== -->
              <input type="hidden" value="0" name="ta_allowance" class="ta_allowance">

              <input type="hidden" value="0" name="ta_total" class="ta_total">
              <input type="hidden" value="0" name="wtax" class="wtax">

              <input type="hidden" value="0" name="loan_sss_salary" class="loan_sss_salary">
              <input type="hidden" value="0" name="loan_sss_calamity" class="loan_sss_calamity">
              <input type="hidden" value="0" name="loan_pagibig_salary" class="loan_pagibig_salary">
              <input type="hidden" value="0" name="loan_pagibig_calamity" class="loan_pagibig_calamity">
              <input type="hidden" value="0" name="loan_emergency" class="loan_emergency">
              <input type="hidden" value="0" name="loan_total" class="loan_total">

              <input type="hidden" value="0" name="tax_refund" class="tax_refund">
              <input type="hidden" value="0" name="salary_advance" class="salary_advance">
              <input type="hidden" value="0" name="uniform_deduction" class="uniform_deduction">
              
              <input type="hidden" value="0" name="ded_total" class="ded_total">
              <input type="hidden" value="0" name="net_pay" class="net_pay">

              <div class="row pr-3 mb-2">
                  <div class="col-3">
                      <h1 class="page-title">Payslip Calculator
                      </h1>
                  </div>
                  <div class="col-9 pt-1">
                  
                    <a class="btn btn-info float-right text-white ml-3" id="btn_insert_payroll_data"><i class="fas fa-receipt"></i>&nbsp;&nbsp;&nbsp; Generate Payslip </a>

                    <a class="btn btn-info float-right text-white ml-3" id="calculate">Single Calculation</a>

                    <a class="btn btn-primary float-right text-white px-3" id="calculate_all">Calculate All</a>

                  </div>
              </div>
              <div class="row">
                  <div class="col-8">
                      <div class="card">
                          <div class="card-body" style="height: 324.5px;">
                              <div class="row">
                                <div class="col-6">
                                  <div class="row">
                                    <div class="col-12 d-flex">
                                      <div style="width: 150px;">
                                        <p class="text-bold mb-2 pt-2">Employee ID: </p>
                                      </div>
                                      <div class="flex-fill" style="width: auto;">
                                        <select class="form-control mb-2" name="select_employee" id="select_employee" required>
                                          <option value="">Select Employee...</option>
                                          <?php 
                                            if($DISP_APPROVED_ATTENDANCE_EMPLOYEE){
                                              foreach($DISP_APPROVED_ATTENDANCE_EMPLOYEE as $DISP_APPROVED_ATTENDANCE_EMPLOYEE_ROW){
                                                $approved_employees = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVED_ATTENDANCE_EMPLOYEE_ROW->empl_id);
                                                
                                                if($approved_employees[0]->col_empl_cmid != '1233'){
                                                  ?>
                                                    <option value="<?= $approved_employees[0]->id ?>"> <?= $approved_employees[0]->col_empl_cmid.' - '.$approved_employees[0]->col_frst_name.' '.$approved_employees[0]->col_last_name?></option>
                                                  <?php
                                                } else {
                                                  if($user_type == 'Accounting Head'){
                                                    ?>
                                                      <option value="<?= $approved_employees[0]->id ?>"> <?= $approved_employees[0]->col_empl_cmid.' - '.$approved_employees[0]->col_frst_name.' '.$approved_employees[0]->col_last_name?></option>
                                                    <?php
                                                  }
                                                }
                                              }
                                            }
                                          ?>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mt-2">
                                    <div class="col-12 d-flex">
                                      <div style="width: 150px;">
                                        <p class="text-bold">Employee Name: </p>
                                      </div>
                                      <div class="flex-fill" style="width: auto;">
                                        <p id="employee_name"></p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12 d-flex">
                                      <div style="width: 150px;">
                                        <p class="text-bold mb-2 pt-2">Salary: </p>
                                      </div>
                                      <div class="flex-fill" style="width: auto;">
                                        <input type="text" name="salary_rate" id="salary_rate" class="form-control ml-0" disabled>
                                        <!-- <p id="salary_rate">30000</p> -->
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mt-2">
                                    <div class="col-12 d-flex">
                                      <div style="width: 150px;">
                                        <p class="text-bold mb-2 pt-2">Work Rate: </p>
                                      </div>
                                      <div class="flex-fill" style="width: auto;">
                                        <select class="form-control mb-2" name="date_range" id="date_range" required>
                                             <option value="313_days">313 Days</option>
                                        </select>
                                      </div>
                                      <input type="text" style="width: 100px;display:none;" name="custom_days" id="custom_days" placeholder="# of days" class="form-control ml-2">
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12 d-flex">
                                      <div style="width: 150px;">
                                        <p class="text-bold">Daily Salary: </p>
                                      </div>
                                      <div class="flex-fill" style="width: auto;">
                                        <p id="daily_salary">0.00</p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12 d-flex">
                                      <div style="width: 150px;">
                                        <p class="text-bold">Hourly Salary: </p>
                                      </div>
                                      <div class="flex-fill" style="width: auto;">
                                        <p id="hourly_salary">0.00</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="row">
                                    <div class="col-12 d-flex">
                                      <div style="width: 150px;">
                                        <p class="text-bold mb-2 pt-2">Cut-off Period:  </p>
                                      </div>
                                      <div class="flex-fill" style="width: auto;">
                                        <!-- <p>June 1, 2021 - June 15, 2021</p> -->
                                        <select name="payroll_period" class="form-control" id="cutoff_period" required>
                                            <?php
                                              $payroll_period = $this->p175_payschedule_mod->MOD_GET_PAY_SCHED_DATA($DISP_PAYROLL_PERIOD);
                                            ?>
                                            <?php
                                              if($DISP_PAYROLL_SCHED){
                                                foreach($DISP_PAYROLL_SCHED as $DISP_PAYROLL_SCHED_ROW){
                                                ?>
                                                  <option value="<?= $DISP_PAYROLL_SCHED_ROW->id  ?>" period="<?= $DISP_PAYROLL_SCHED_ROW->db_name; ?>" <?php if($DISP_PAYROLL_SCHED_ROW->id == $DISP_PAYROLL_PERIOD){echo 'selected';} ?>><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                                                <?php
                                                }
                                              }
                                            ?>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12 d-flex">
                                      <div style="width: 150px;">
                                        <p class="text-bold mb-2 pt-2">Integrated Cut-off Period:  </p>
                                      </div>
                                      <div class="flex-fill" style="width: auto;">
                                        <select name="integrated_cutoff_period" class="form-control mt-3" id="integrated_cutoff_period" required>
                                            <option value="not_connected">Not Connected</option>
                                            <?php
                                              $payroll_period = $this->p175_payschedule_mod->MOD_GET_PAY_SCHED_DATA($DISP_PAYROLL_PERIOD);
                                            ?>
                                            <?php
                                              if($DISP_PAYROLL_SCHED){
                                                foreach($DISP_PAYROLL_SCHED as $DISP_PAYROLL_SCHED_ROW){
                                                  if($DISP_PAYROLL_SCHED_ROW->id != $DISP_PAYROLL_PERIOD){
                                                ?>
                                                  <option value="<?= $DISP_PAYROLL_SCHED_ROW->id  ?>" period="<?= $DISP_PAYROLL_SCHED_ROW->db_name; ?>" <?php if($DISP_PAYROLL_SCHED_ROW->id == $DISP_PAYROLL_PERIOD){echo 'selected';} ?>><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                                                <?php
                                                  }
                                                }
                                              }
                                            ?>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mt-2">
                                    <div class="col-12 d-flex">
                                      <div style="width: 150px;">
                                        <p class="text-bold">Payroll Type: </p>
                                      </div>
                                      <div class="flex-fill" style="width: auto;">
                                        <p>Semi-Monthly</p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12 d-flex">
                                      <div style="width: 150px;">
                                        <p class="text-bold mb-2 pt-2">Salary Type: </p>
                                      </div>
                                      <div class="flex-fill" style="width: auto;">
                                        <input type="text" name="salary_type" id="salary_type" class="form-control ml-0" disabled>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12 d-flex">
                                      <div style="width: 150px;">
                                        <p class="text-bold mb-2 pt-2">Working Days: </p>
                                      </div>
                                      <div class="flex-fill" style="width: auto;">
                                        <input type="text" name="work_hours" id="working_days" placeholder="# of Work hours per day" value="8" class="form-control ml-0" disabled>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mt-2">
                                    <div class="col-12 d-flex">
                                      <div style="width: 150px;">
                                        <p class="text-bold mb-2 pt-2">Hours of Work: </p>
                                      </div>
                                      <div class="flex-fill" style="width: auto;">
                                        <input type="text" name="work_hours" id="work_hours" placeholder="# of Work hours per day" value="8" class="form-control ml-0 pl-0" required disabled>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-4">
                      <div class="card">
                          <div class="card-body" style="padding-bottom: 29px !important; ">
                              <div class="row pb-1">
                                <div class="col-12">
                                  <p class="text-bold mb-2">Settings </p>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-6">
                                  <div class="icheck-primary d-inline">
                                    <input type="radio" id="auto-generate" value="automatic" name="generate_payroll_data" checked> 
                                    <label class="radio_label" for="auto-generate">
                                        Track Attendance
                                    </label>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="icheck-primary d-inline">
                                    <input type="radio" id="manual-generate" value="manual" name="generate_payroll_data">
                                    <label class="radio_label" for="manual-generate">
                                        Manual Entry
                                    </label>
                                  </div>
                                </div>
                              </div>
                              <hr>
                              <div class="row mt-3">
                                <div class="col-6">
                                  <div class="icheck-primary mb-0" style="font-size: 14px; display: block;">
                                      <input type="checkbox" id="approved_ot" name="CHCK_CERT_EXPIRES" checked>
                                      <label class="mb-2" for="approved_ot" style="font-weight: 500 !important; font-size: 14px !important;">
                                          Approved Overtime
                                      </label>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="icheck-primary mb-0" style="font-size: 14px; display: block;">
                                      <input type="checkbox" id="sss_deduction" name="CHCK_CERT_EXPIRES" checked>
                                      <label class="mb-2" for="sss_deduction" style="font-weight: 500 !important; font-size: 14px !important;">
                                          SSS Deduction
                                      </label>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="icheck-primary mb-0" style="font-size: 14px; display: block;">
                                      <input type="checkbox" id="philhealth_deduction" name="CHCK_CERT_EXPIRES" checked>
                                      <label class="mb-2" for="philhealth_deduction" style="font-weight: 500 !important; font-size: 14px !important;">
                                          PhilHealth Deduction
                                      </label>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="icheck-primary mb-0" style="font-size: 14px; display: block;">
                                      <input type="checkbox" id="pagibig_deduction" name="CHCK_CERT_EXPIRES" checked>
                                      <label class="mb-2" for="pagibig_deduction" style="font-weight: 500 !important; font-size: 14px !important;">
                                          Pag-Ibig Deduction
                                      </label>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="icheck-primary mb-0" style="font-size: 14px; display: block;">
                                      <input type="checkbox" id="tax_deduction" name="CHCK_CERT_EXPIRES" checked>
                                      <label class="mb-2" for="tax_deduction" style="font-weight: 500 !important; font-size: 14px !important;">
                                          W/Tax Deduction
                                      </label>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="icheck-primary mb-0" style="font-size: 14px; display: block;">
                                      <input type="checkbox" id="cash_advance" name="CHCK_CERT_EXPIRES" checked>
                                      <label class="mb-2" for="cash_advance" style="font-weight: 500 !important; font-size: 14px !important;">
                                          Cash Advance
                                      </label>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="icheck-primary mb-0" style="font-size: 14px; display: block;">
                                      <input type="checkbox" id="salary_loan" name="CHCK_CERT_EXPIRES" checked>
                                      <label class="mb-2" for="salary_loan" style="font-weight: 500 !important; font-size: 14px !important;">
                                          SSS Loan
                                      </label>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="icheck-primary mb-0" style="font-size: 14px; display: block;">
                                      <input type="checkbox" id="pagibig_loan" name="CHCK_CERT_EXPIRES" checked>
                                      <label class="mb-2" for="pagibig_loan" style="font-weight: 500 !important; font-size: 14px !important;">
                                          Pag-Ibig Loan
                                      </label>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="icheck-primary mb-0" style="font-size: 14px; display: block;">
                                      <input type="checkbox" id="emergency_loan" name="CHCK_CERT_EXPIRES" checked>
                                      <label class="mb-2" for="emergency_loan" style="font-weight: 500 !important; font-size: 14px !important;">
                                          Pag-Ibig Loan
                                      </label>
                                  </div>
                                </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- ./row -->
            </form>
            <hr>
            <p class="text-bold mb-2" style="font-size: 20px;">Taxable Income</p>
            <div class="row">
              <div class="col-6">
                <div class="card">
                    <div class="card-body">
                    <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Basic Salary: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_basic_sal" disabled>
                            <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_basic_sal_mul" disabled>
                            <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_basic_sal_total" disabled>
                        </div>
                    </div>
                </div>
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;color: red">Absences (Daily): </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_absent" disabled>
                        <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_absent_mul" disabled>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_absent_total" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;color: red">No In/No Out (Daily): </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_no_ti_to" disabled>
                        <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_no_ti_to_mul" disabled>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_no_ti_to_total" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;color: red">Tardiness (Hourly): </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_tard" disabled>
                        <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_tard_mul" disabled>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_tard_total" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;color: red">Half Day (Hourly): </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_half" disabled>
                        <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_half_mul" disabled>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_half_total" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;color: red">Undertime (Hourly): </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_undertime" disabled>
                        <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_undertime_mul" disabled>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_undertime_total" disabled>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-body">
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Rest/Special (Hourly): </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_rest" disabled>
                          <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_rest_mul" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_rest_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Rest+Special (Hourly): </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_rest_sp_hol" disabled>
                          <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_rest_sp_hol_mul" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_rest_sp_hol_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Legal Hol (Daily): </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_legal_hol" disabled>
                          <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_legal_hol_mul" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_legal_hol_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Rest+Legal (Hourly): </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_rest_legal_hol" disabled>
                          <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_rest_legal_hol_mul" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_rest_legal_hol_total" disabled>
                      </div>

                      <hr>

                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Regular OT (Hourly): </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_reg_ot" disabled>
                          <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_reg_ot_mul" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_reg_ot_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Night Diff OT (Hourly): </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_nd_ot" disabled>
                          <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_nd_ot_mul" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_nd_ot_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Night Diff (Hourly): </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_nd" disabled>
                          <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_nd_mul" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_nd_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Rest OT (Hourly): </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_rest_ot" disabled>
                          <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_rest_ot_mul" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_rest_ot_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Rest ND OT (Hourly): </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_rest_nd_ot" disabled>
                          <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_rest_nd_ot_mul" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_rest_nd_ot_total" disabled>
                      </div>
                  </div>
                  <!-- ./card-body -->
                </div>
                <!-- ./card -->

                
              </div>
              <!-- ./col-6 -->

              <div class="col-6">

                <div class="card">
                  <div class="card-body">
                    <div class="d-flex ml-1">
                      <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Paid Leaves</p>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_leave" disabled>
                        <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_leave_mul" disabled>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_leave_total" disabled>
                    </div>
                    <!-- <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">SIL 2021 </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_sil_2020" >
                    </div> -->
                  </div>
                </div>

                <div class="card">
                  <div class="card-body"> 

                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Meal Allowance</p>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_meal" >
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;color: red">Gov't Contributions</p>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_gov_cont" >
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Others </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_others" >
                    </div>
                    <!-- <hr>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Total Taxable Allowance </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="TAX_ALLOW_TOTAL" disabled>
                    </div> -->

                  </div>
                  <!-- ./card-body -->
                </div>
                <!-- ./card -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">De Minimis (Meal) </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_de_minimis" disabled>
                            <input type="number" class="form-control ml-2 text-right" style="width: 60px; font-size: 13px;" id="TI_de_minimis_mul" disabled>
                            <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_de_minimis_total" disabled>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                      <p class="text-bold mb-0">Total</p>
                      <div class="d-flex ml-1 mt-1">
                          <p class="text-right mb-3 mt-1 text-bold" style="font-size: 14px;width:250px;">Gross Income </p>
                          <input type="text" class="form-control ml-1 text-right flex-fill" style="width: 190px;" value="0" id="TI_gross" disabled>
                      </div>
                    </div>
                </div>
              </div>
              <!-- ./col-4 -->
              
            </div>
            <!-- ./row -->


            
            <!-- ./row -->

            <hr>

            <p class="text-bold mb-2" style="font-size: 20px;">Total Taxable Income</p>
            <div class="row">
              <div class="col-4">
                <div class="card">
                  <div class="card-body"> 
                    <p class="text-bold mb-0">Contributions</p>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Current Gross Income </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="GROSS_TAX_total" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Previous Gross Income </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="GROSS_P_TAX_total" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Total Gross Income </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="GROSS_P_TAX_OVERALL" disabled>
                    </div>
                    <hr>
                    <p class="text-bold mb-0">Total Gross Income Contribution</p>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">SSS: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_SSS_total" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">PhilHealth: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_philhealth_total" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Pag-Ibig: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_pagibig_total" disabled>
                    </div>
                    <hr>
                    <p class="text-bold mb-0">Previous Cutoff Contribution</p>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">SSS: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_P_SSS_total" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">PhilHealth: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_P_philhealth_total" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Pag-Ibig: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_P_pagibig_total" disabled>
                    </div>
                    <hr>
                    <p class="text-bold mb-0">Current Contribution</p>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">SSS: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_D_SSS_total" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">PhilHealth: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_D_philhealth_total" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Pag-Ibig: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_D_pagibig_total" disabled>
                    </div>
                    <hr>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Total Employee Share </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="GOV_TOTAL_EESHARE" disabled>
                    </div>
                    <br>
                        
                    <div class="d-flex ml-1" >
                        <p class="text-right mb-3 mt-1 flex-fill text-bold" style="font-size: 14px;width:280px; display:none;">Total Contributions: </p>
                        <input type="number" class="form-control ml-1 text-right" style="width: 190px; display:none;" value="0" id="GOV_total" disabled>
                    </div>
                  </div>
                  <!-- ./card-body -->
                </div>
                <!-- ./card -->
              </div>
              <!-- ./col-4 -->
              <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <p class="text-bold mb-2">Gross Total Contribution</p>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">SSS: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill " style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_EMPLYR_SSS_total" disabled>
                        </div>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">EC: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill " style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_EMPLYR_SSS_EC_total" disabled>
                        </div>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">PhilHealth: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill " style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_EMPLYR_philhealth_total" disabled>
                        </div>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Pag-Ibig: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill " style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_EMPLYR_pagibig_total" disabled>
                        </div>

                        <hr>
                        
                        <p class="text-bold mb-2">Previous Contributions</p>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">SSS: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill " style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_EMPLYR_SSS_PREV" disabled>
                        </div>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">EC: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill " style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_EMPLYR_SSS_EC_PREV" disabled>
                        </div>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">PhilHealth: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill " style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_EMPLYR_philhealth_PREV" disabled>
                        </div>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Pag-Ibig: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill " style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_EMPLYR_pagibig_PREV" disabled>
                        </div>
                        
                        <hr>

                        <p class="text-bold mb-2">Current Contributions</p>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">SSS: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill " style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_EMPLYR_SSS_DIF" disabled>
                        </div>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">EC: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill " style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_EMPLYR_SSS_EC_DIF" disabled>
                        </div>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">PhilHealth: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill " style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_EMPLYR_philhealth_DIF" disabled>
                        </div>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Pag-Ibig: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill " style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_EMPLYR_pagibig_DIF" disabled>
                        </div>
                        <hr>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Total Employer Share: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill " style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_EMPLYR_DIF_TOT" disabled>
                        </div>
                    </div>
                    <!-- ./card-body -->
                </div>
                <!-- ./card -->
              </div>
              <!-- ./col-4 -->
              <div class="col-4">
            <div class="card">
                <div class="card-body"> 
                    <p class="text-bold mb-0">Taxable Allowance</p>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Load </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="TAX_LOAD" >
                        </div>

                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Transportation</p>
                            <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="TAX_TRANS" >
                        </div>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Skill</p>
                            <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="TAX_SKILL" >
                        </div>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Pioneer Allowance </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="TAX_PIONEER" >
                        </div>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Group Leader Allowance </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="TAX_GROUP_LEADER" >
                        </div>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Daily Allowance </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="TAX_DAILY" >
                        </div>
                        <hr>
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Taxable Allowance </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="TAX_ALLOW_TOTAL" disabled>
                        </div>

                    </div>
                <!-- ./card-body -->
                </div>
                <!-- ./card -->
                <div class="card">
                  <div class="card-body"> 
                  <p class="text-bold mb-0">Total Taxable Income</p>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Gross Income </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="LTI_Gross" disabled>
                    </div>

                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Contributions</p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="LTI_Contri" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Taxable Allowances</p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="LTI_Allow" disabled>
                    </div>

                    <hr>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Total Taxable Allowance </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="LTI_Tot" disabled>
                    </div>
                    <hr>
                    <div class="d-flex ml-1">
                      <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">W/Tax: </p>
                      <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="0" id="GOV_CONT_with_tax_total" disabled>
                  </div>
                  </div>
                  <!-- ./card-body -->
                </div>
                <!-- ./card -->
              </div>
              <!-- ./col-4 -->
            </div>
            <!-- ./row -->

            <hr>
            
            <p class="text-bold mb-2" style="font-size: 20px;">Non-Taxable </p>
            <div class="row">
              <!-- ./col-4 -->
              <div class="col-6">
                <div class="card" style="height: 372px;">
                  <div class="card-body">
                    <p class="text-bold mb-2">Loans</p>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">SSS Salary Loan: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill LOAN_each_total" style="width: 110px; font-size: 13px;" value="0" id="LOAN_SSS_salary_loan_total">
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">SSS Calamity Loan: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill LOAN_each_total" style="width: 110px; font-size: 13px;" value="0" id="LOAN_SSS_calamity_loan_total">
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Pagibig Salary Loan: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill LOAN_each_total" style="width: 110px; font-size: 13px;" value="0" id="LOAN_HDMF_salary_loan_total">
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Pagibig Calamity Loan: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill LOAN_each_total" style="width: 110px; font-size: 13px;" value="0" id="LOAN_HDMF_calamity_loan_total">
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Emergency Loan: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill LOAN_each_total" style="width: 110px; font-size: 13px;" value="0" id="LOAN_company_loan_total">
                    </div>

                    <br>

                    <div class="d-flex ml-1" style="margin-top: 58px;">
                        <p class="text-right mb-3 mt-1 flex-fill text-bold" style="font-size: 14px;">Total Loans: </p>
                        <input type="number" class="form-control ml-1 text-right" style="width: 190px;" value="0" id="LOAN_total" disabled>
                    </div>
                  </div>
                  <!-- ./card-body -->
                </div>
                <!-- ./card -->
              </div>
              <!-- ./col-6 -->
              <div class="col-6">
                <div class="card">
                  <div class="card-body">
                    <p class="text-bold mb-2">Tax Refund / Deduction </p>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:130px;">Tax Refund/Dec Tax WH: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill DED_each_total" style="width: 110px; font-size: 13px;" value="0" id="DED_tax_refund">
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:130px;color: red">Salary Advances: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill DED_each_total" style="width: 110px; font-size: 13px;" value="0" id="DED_salary_advances">
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:130px;color: red">Uniform Deduction: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill DED_each_total" style="width: 110px; font-size: 13px;" value="0" id="DED_uniform_deduction">
                    </div>

                    <br>

                    <div class="d-flex ml-1" style="margin-top: 23px;">
                        <p class="text-right mb-3 mt-1 flex-fill text-bold" style="font-size: 14px;width:280px;">Total Deductions: </p>
                        <input type="text" class="form-control ml-1 text-right" style="width: 190px;" value="0" id="DED_total" disabled>
                    </div>
                  </div>
                  <!-- ./card-body -->
                </div>


                <div class="card">
                  <div class="card-body">
                    <div class="d-flex ml-1">
                        <p class="text-right text-bold mb-3 mt-1" style="font-size: 14px;width:130px;">SIL 2021: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_sil_2020" >
                    </div>
                  </div>
                  <!-- ./card-body -->
                </div>
                <!-- ./card -->
              </div>
              <!-- ./col-6 -->
            </div>
            <p class="text-bold mb-2" style="font-size: 20px;">Net Income</p>
            
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Total Taxable Income: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="OVR_total_TI" disabled>
                          </div>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">SIL 2021: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="OVR_SIL_2020" disabled>
                          </div>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;color:red">Withholding Tax: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="OVR_total_GOV" disabled>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Deductions: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="OVR_total_DED" disabled>
                          </div>

                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Loans: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="OVR_total_LOAN" disabled>
                          </div>
                        </div>
                    </div>

                    <br>

                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1 flex-fill text-bold" style="font-size: 14px;">Net Pay: </p>
                        <input type="text" class="form-control ml-1 text-right" style="width: 190px;" value="0" id="OVR_total" disabled>
                    </div>
                  </div>
                  <!-- ./card-body -->
                </div>
                <!-- ./card -->
              </div>
              <!-- ./col-12 -->
            </div>
            <!-- ./row -->

            <br>
            <br>

        </div>
        <!-- flex-fill -->
    </div>
  <!-- p-3 -->
</div>
<!-- content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->





<!-- Add payroll -->
<div class="modal fade" id="modal_add_payroll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Add Payroll
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('payroll/insrt_payroll'); ?>" id="PAYROLL_FORM_ADD" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="PAYROLL_INPF_NAME">Name
                </label>
                <input class="form-control form-control " type="text" name="PAYROLL_INPF_NAME" id="PAYROLL_INPF_NAME">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class='btn btn-primary text-light' id="PAYROLL_BTN_SAVE">&nbsp; Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit payroll -->
<div class="modal fade" id="modal_edit_payroll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Payroll
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('payroll/updt_payroll'); ?>" id="PAYROLL_FORM_EDIT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="asset_code">Name
                </label>
                <input class="form-control form-control " type="text" name="UPDT_PAYROLL_INPF_NAME" id="UPDT_PAYROLL_INPF_NAME" required>
              </div>
            </div>
            <input type="hidden" name="UPDT_PAYROLL_INPF_ID" id="UPDT_PAYROLL_INPF_ID">
          </div>
        </div>
        <div class="modal-footer">
          <a class='btn btn-primary text-light' id="PAYROLL_BTN_UPDT">&nbsp; Update
          </a>
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
        <a href="<?php echo base_url().'login/logout'; ?>" class="btn btn-info">Logout
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
<!-- DateRange Picker -->
<script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js">
</script>
<!-- Facebox -->
<script src="<?php echo base_url(); ?>facebox/facefiles/facebox.js" type="text/javascript"></script>
<!-- Toast Indicator -->
<script src="<?php echo base_url(); ?>plugins/toast_loading_indicator/jquery.toast.js" type="text/javascript"></script>


<script>

  $(document).ready(function(){
    // URL of Async Function
    var url_get_employee_all_ampl_data = '<?= base_url() ?>attendance/get_employee_all_ampl_data';
    var url_get_loan_payable_data = '<?= base_url() ?>payroll/get_loan_payable_data';
    var url_get_previous_cutoff = '<?= base_url() ?>payroll/get_previous_cutoff';
    var url = "<?= base_url() ?>payroll/getSssTax";
    var url_wtax = "<?= base_url() ?>payroll/getSalaryWitholdingTax";
    var url_generate_payslip = "<?= base_url() ?>payroll/generate_payslip";

    // New attendance counts
    var salary_rate;

    var work_days;
    var rest;
    var reg_hol;
    var rest_reg_hol;
    var rest_sp_hol;
    var abs;
    var tard;
    var ut;
    var nd;
    var reg_ot;
    var ns_ot;
    var pd_l;
    var half;
    var rest_ot;
    var rest_nd_ot;

    //  ================================= Latest revisions ========================================

    ////////  ROW 1 - TAXABLE INCOME ///////////
    var TI_basic_sal;
    var TI_absent;
    var TI_no_ti_to;
    var TI_tard;
    var TI_half;
    var TI_undertime;
    var TI_rest;
    var TI_rest_sp_hol;
    var TI_legal_hol;
    var TI_rest_legal_hol;
    var TI_reg_ot;
    var TI_nd_ot;
    var TI_nd;
    var TI_leave;
    var TI_de_minimis;
    var TI_rest_ot;
    var TI_rest_nd_ot;

    var TI_basic_sal_mul;
    var TI_absent_mul;
    var TI_no_ti_to_mul;
    var TI_tard_mul;
    var TI_half_mul;
    var TI_undertime_mul;
    var TI_rest_mul;
    var TI_rest_sp_hol_mul;
    var TI_legal_hol_mul;
    var TI_rest_legal_hol_mul;
    var TI_reg_ot_mul;
    var TI_nd_ot_mul;
    var TI_nd_mul;
    var TI_leave_mul;
    var TI_de_minimis_mul;
    var TI_rest_ot_mul;
    var TI_rest_nd_ot_mul;

    var TI_basic_sal_total;
    var TI_absent_total;
    var TI_no_ti_to_total;
    var TI_tard_total;
    var TI_half_total;
    var TI_undertime_total;
    var TI_rest_total;
    var TI_rest_sp_hol_total;
    var TI_legal_hol_total;
    var TI_rest_legal_hol_total;
    var TI_reg_ot_total;
    var TI_nd_ot_total;
    var TI_nd_total;
    var TI_leave_total;
    var TI_de_minimis_total;
    var TI_rest_ot_total;
    var TI_rest_nd_ot_total;

    var TI_sil_2020;
    var TI_meal;
    var TI_gov_cont;
    var TI_others;

    var TI_gross;




    ////////  ROW 2 - TOTAL TAXABLE INCOME ///////////
    var GROSS_TAX_total;
    var GROSS_P_TAX_total;
    var GROSS_P_TAX_OVERALL;
    var GOV_CONT_SSS_total;
    var GOV_CONT_philhealth_total;
    var GOV_CONT_pagibig_total;
    var GOV_CONT_P_SSS_total;
    var GOV_CONT_P_philhealth_total;
    var GOV_CONT_P_pagibig_total;
    var GOV_CONT_D_SSS_total;
    var GOV_CONT_D_philhealth_total;
    var GOV_CONT_D_pagibig_total;
    var GOV_TOTAL_EESHARE;
    var GOV_total;

    var GOV_CONT_EMPLYR_SSS_total;
    var GOV_CONT_EMPLYR_CONT;
    var GOV_CONT_EMPLYR_philhealth_total;
    var GOV_CONT_EMPLYR_pagibig_total;
    var GOV_CONT_EMPLYR_SSS_PREV;
    var GOV_CONT_EMPLYR_CONT_PREV;
    var GOV_CONT_EMPLYR_philhealth_PREV;
    var GOV_CONT_EMPLYR_pagibig_PREV;
    var GOV_CONT_EMPLYR_SSS_DIF;
    var GOV_CONT_EMPLYR_CONT_DIF;
    var GOV_CONT_EMPLYR_philhealth_DIF;
    var GOV_CONT_EMPLYR_pagibig_DIF;
    var GOV_CONT_EMPLYR_DIF_TOT;

    var TAX_LOAD;
    var TAX_TRANS;
    var TAX_SKILL;
    var TAX_PIONEER;
    var TAX_DAILY;
    var TAX_ALLOW_TOTAL;

    var LTI_Gross;
    var LTI_Contri;
    var LTI_Allow;
    var LTI_Tot;

    var GOV_CONT_with_tax_total;


    ////////  ROW 3  ///////////
    var LOAN_SSS_salary_loan_total;
    var LOAN_SSS_calamity_loan_total;
    var LOAN_HDMF_salary_loan_total;
    var LOAN_HDMF_calamity_loan_total;
    var LOAN_company_loan_total;
    var LOAN_total;
    var DED_tax_refund;
    var DED_salary_advances;
    var DED_uniform_deduction;
    var DED_total;


    ////////  ROW 4  ///////////
    var OVR_total_TI;
    var OVR_total_GOV;
    var OVR_total_DED;
    var OVR_total_LOAN;
    var OVR_total;






























    // var TI_reg_M;
    // var TI_rest_M;
    // var TI_spec_hol_M;
    // var TI_spec_hol_rest_M;
    // var TI_reg_hol_M;
    // var TI_reg_hol_rest_M;
    // var TI_double_hol_M;
    // var TI_double_hol_rest_M;
    // var TI_regular_ns_M;
    // var TI_rest_ns_M;
    // var TI_spec_hol_ns_M;
    // var TI_spec_hol_rest_ns_M;
    // var TI_reg_hol_ns_M;
    // var TI_reg_hol_rest_ns_M;
    // var TI_double_hol_ns_M;
    // var TI_double_hol_rest_ns_M;
    // var TI_reg_ot_M;
    // var TI_rest_ot_M;
    // var TI_spec_hol_ot_M;
    // var TI_spec_hol_rest_ot_M;
    // var TI_reg_hol_ot_M;
    // var TI_reg_hol_rest_ot_M;
    // var TI_double_hol_ot_M;
    // var TI_double_hol_rest_ot_M;
    // var TI_reg_ot_ns_M;
    // var TI_rest_ot_ns_M;
    // var TI_spec_hol_ot_ns_M;
    // var TI_spec_hol_rest_ot_ns_M;
    // var TI_reg_hol_ot_ns_M;
    // var TI_reg_hol_rest_ot_ns_M;
    // var TI_double_hol_ot_ns_M;
    // var TI_double_hol_rest_ot_ns_M;
    // var TI_absent_M;
    // var TI_late_undertime_M;
    // var TI_leave_M;
    // var TI_work_days;

    // var oti_meal;
    // var oti_2;
    // var oti_3;
    // var oti_4;
    // var oti_5;
    // var oti_6;
    // var oti_7;
    // var oti_8;
    // var oti_adj;
    // var nti_1;
    // var nti_2;
    // var nti_3;
    // var nti_4;
    // var nti_5;
    // var nti_6;
    // var nti_7;
    // var ded_1;
    // var ded_2;
    // var ded_3;
    // var ded_4;
    // var ded_5;
    // var oti_legal_mul;
    // var oti_2_mul;
    // var oti_3_mul;
    // var oti_4_mul;
    // var oti_5_mul;
    // var oti_6_mul;
    // var oti_7_mul;
    // var oti_8_mul;
    // var oti_adj_mul;
    // var nti_1_mul;
    // var nti_2_mul;
    // var nti_3_mul;
    // var nti_4_mul;
    // var nti_5_mul;
    // var nti_6_mul;
    // var nti_7_mul;
    // var ded_1_mul;
    // var ded_2_mul;
    // var ded_3_mul;
    // var ded_4_mul;
    // var ded_5_mul;
    // var TI_absent;
    // var TI_late_undertime;
    // var daily_salary;
    // var hourly_salary;
    // var salary_type;
    // var salary_rate;
    // var hours_per_day;
    // var TI_rest_s;
    // var TI_spec_hol_s;
    // var TI_spec_hol_rest_s;
    // var TI_reg_hol_s;
    // var TI_reg_hol_rest_s;
    // var TI_double_hol_s;
    // var TI_double_hol_rest_s;
    // var TI_regular_ns_s;
    // var TI_rest_ns_s;
    // var TI_spec_hol_ns_s;
    // var TI_spec_hol_rest_ns_s;
    // var TI_reg_hol_ns_s;
    // var TI_reg_hol_rest_ns_s;
    // var TI_double_hol_ns_s;
    // var TI_double_hol_rest_ns_s;
    // var TI_reg_ot_s;
    // var TI_rest_ot_s;
    // var TI_spec_hol_ot_s;
    // var TI_spec_hol_rest_ot_s;
    // var TI_reg_hol_ot_s;
    // var TI_reg_hol_rest_ot_s;
    // var TI_double_hol_ot_s;
    // var TI_double_hol_rest_ot_s;
    // var TI_reg_ot_ns_s;
    // var TI_rest_ot_ns_s;
    // var TI_spec_hol_ot_ns_s;
    // var TI_spec_hol_rest_ot_ns_s;
    // var TI_reg_hol_ot_ns_s;
    // var TI_reg_hol_rest_ot_ns_s;
    // var TI_double_hol_ot_ns_s;
    // var TI_double_hol_rest_ot_ns_s;
    // var ti_reg;
    // var ti_rest;
    // var ti_sp_hol;
    // var ti_sp_hol_rest;
    // var ti_reg_hol;
    // var ti_reg_hol_rest;
    // var ti_dbl_hol;
    // var ti_dbl_hol_rest;
    // var ti_reg_ns;
    // var ti_rest_ns;
    // var ti_sp_hol_ns;
    // var ti_sp_hol_rest_ns;
    // var ti_reg_hol_ns;
    // var ti_reg_hol_rest_ns;
    // var ti_dbl_hol_ns;
    // var ti_dbl_hol_rest_ns;
    // var TI_reg_ot;
    // var TI_rest_ot;
    // var TI_spec_hol_ot;
    // var TI_spec_hol_rest_ot;
    // var TI_reg_hol_ot;
    // var TI_reg_hol_rest_ot;
    // var TI_double_hol_ot;
    // var TI_double_hol_rest_ot;
    // var TI_reg_ot_ns;
    // var TI_rest_ot_ns;
    // var TI_spec_hol_ot_ns;
    // var TI_spec_hol_rest_ot_ns;
    // var TI_reg_hol_ot_ns;
    // var TI_reg_hol_rest_ot_ns;
    // var TI_double_hol_ot_ns;
    // var TI_double_hol_rest_ot_ns;
    // var TI_leave;
    
    // var OTI_legal;
    // var OTI_meal;
    // var OTI_other2;
    // var OTI_other3;
    // var OTI_other4;
    // var OTI_other5;
    // var OTI_other6;
    // var OTI_other7;
    // var OTI_other8;
    // var OTI_adj;
    // var NTI_other1;
    // var NTI_other2;
    // var NTI_other3;
    // var NTI_other4;
    // var NTI_other5;
    // var NTI_other6;
    // var NTI_other7;
    // var DED_other1;
    // var DED_other2;
    // var DED_other3;
    // var DED_other4;
    // var DED_other5;

    var subtotal_bp;
    var subtotal_ot;
    var subtotal_OTI;
    var subtotal_absent_late;
    
    var total_TI;
    var total_NTI;
    var total_DED;
    var total_LOAN;

    var sss_salary_loan = 0.00;
    var sss_calamity_loan = 0.00;
    var hdmf_salary_loan = 0.00;
    var hdmf_calamity_loan = 0.00;
    var emergency_loan = 0.00;

    var GROSS_P_TAX_total = 0.00;
    var GOV_CONT_P_SSS_total = 0.00;
    var GOV_CONT_P_philhealth_total = 0.00;
    var GOV_CONT_P_pagibig_total = 0.00;

    var GOV_CONT_P_ER_SSS_total = 0.00;
    var GOV_CONT_P_EC_SSS_total = 0.00;
    var GOV_CONT_P_ER_philhealth_total = 0.00;
    var GOV_CONT_P_ER_pagibig_total = 0.00;

    var TOT_tax_income;

    var integrated_cutoff_period = 'not_connected';

    var tax_allow_tot;
    var contri_total;
    var contri_total_ER;
    var contri_total_ER_diff;
    var gross_TI;

    var tax_isChecked;
    var total_wtax;
    var net_pay;

    var sss_ee_val_diff 
    var sss_er_val_diff;
    var sss_ec_val_diff;

    var philhealth_ee_val_diff;
    var philhealth_er_val_diff;

    var pagibig_ee_val_diff;  
    var pagibig_er_val_diff;  

    var tax_load;
    var tax_trans;
    var tax_skill;
    var tax_pioneer;
    var tax_group_leader;
    var tax_daily;

    var sss_isChecked;
    var philhealth_isChecked;
    var pagibig_isChecked;

    var total_GTI_OVERALL

    $('#btn_insert_payroll_data').click(function(){
      save_to_db();
      Swal.fire({
        title: 'Generate payslip for this employee?',
        text: 'You may want to review the calculations before proceeding.',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#form_insert_data').submit();
        }
      })
    })

    $('#calculate').click(function(){
      update_calc_manual();
    })
    
   
    // URL of Async Function
    var url_empl = "<?= base_url() ?>payroll/getEmployeeData";

    $('#select_employee').change(function(){
      var employee_id = $(this).val();
      var integrate_cutoff_period = $('#integrated_cutoff_period').val();

      integrate_cutoff_refresh(integrate_cutoff_period, employee_id);

      setTimeout(() => {
        getEmployeeData(url_empl,employee_id).then(data => {
          data.employee_data.forEach((x) => {

            // EMPL INFO
            var fullname = x.col_frst_name + ' ' + x.col_last_name;

            // ALLOWANCE
            var pioneer_allowance = '';
            var skill_allowance = '';
            var load_allowance = '';
            var transpo_allowance = '';
            var group_leader_allowance = '';
            var daily_allowance = '';

            if(x.pioneer_allowance == ''){ pioneer_allowance = 0; } else { pioneer_allowance = parseFloat(x.pioneer_allowance)/2; }
            if(x.skill_allowance == ''){ skill_allowance = 0; } else { skill_allowance = parseFloat(x.skill_allowance)/2; }
            if(x.load_allowance == ''){ load_allowance = 0; } else { load_allowance = parseFloat(x.load_allowance)/2; }
            if(x.transpo_allowance == ''){ transpo_allowance = 0; } else { transpo_allowance = parseFloat(x.transpo_allowance)/2; }
            

            // DEDUCTIONS
            var uniform_deduction = '';
            var salary_advance = '';

            if(x.uniform_deduction == ''){ uniform_deduction = 0; } else { uniform_deduction = x.uniform_deduction; }
            if(x.salary_advance == ''){ salary_advance = 0; } else { salary_advance = x.salary_advance; }

            $('#employee_name').text(fullname);
            $('#salary_rate').val(x.salary_rate);
            $('#salary_type').val(x.salary_type);

            // DISPLAY ALLOWANCES 
            $('#TAX_LOAD').val(parseFloat(load_allowance).toFixed(2));
            $('#TAX_TRANS').val(parseFloat(transpo_allowance).toFixed(2));
            $('#TAX_SKILL').val(parseFloat(skill_allowance).toFixed(2));
            $('#TAX_PIONEER').val(parseFloat(pioneer_allowance).toFixed(2));

            
            

            // DISPLAY DEDUCTIONS 
            $('#DED_salary_advances').val(parseFloat(uniform_deduction).toFixed(2));
            $('#DED_uniform_deduction').val(parseFloat(salary_advance).toFixed(2));
            
            setTimeout(() => {
              
              // update_calc();
              display_loans();
              track_attendance();
              computeTI();
              setTimeout(() => {
                  if(x.group_leader_allowance == ''){ group_leader_allowance = 0; } else { group_leader_allowance = parseFloat(x.group_leader_allowance)*work_days; }
                  if(x.daily_allowance == ''){ daily_allowance = 0; } else { daily_allowance = parseFloat(x.daily_allowance)*work_days; }
                  $('#TAX_GROUP_LEADER').val(parseFloat(group_leader_allowance).toFixed(2));
                  $('#TAX_DAILY').val(parseFloat(daily_allowance).toFixed(2));
                  contribution_calc();
              }, 500);

            }, 500);
          })
        })

        display_loans();
      }, 600);
      
    })

















    var empl_info_arr = [];

    get_employee_all_ampl_data(url_get_employee_all_ampl_data, 'test').then(function(data){
      empl_info_arr = data;
      ////console.log(empl_info_arr)
    })

    function findObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return array[i];
        }
    }
    return null;
    }





    var url_get_approved_employee_attendance_data = '<?= base_url() ?>payroll/get_approved_employee_attendance_data';
    $('#cutoff_period').change(function(){
        var cutoff_period = $('#cutoff_period option:selected').attr('period');
        get_approved_employee_attendance_data(url_get_approved_employee_attendance_data, cutoff_period).then(function(data){
          // //console.log(data);
          $('#select_employee').html(`
              <option value="">Select Employee</option>
          `);

          Array.from(data).forEach(function(x){

              var obj = findObjectByKey(empl_info_arr, 'id', ""+x+"");

              $('#select_employee').append(`
                  <option value="`+obj.id+`">`+obj.col_empl_cmid+` - `+ obj.col_frst_name +` ` + obj.col_last_name + `</option>
              `)
          })

         

          // $('#select_employee').html(`
          //     <option value="">Select Employee</option>
          // `);
          // Array.from(data).forEach(function(x){
          //     var id = x.id;
          //     var col_empl_cmid = x.col_empl_cmid;
          //     var col_frst_name = x.col_frst_name;
          //     var col_last_name = x.col_last_name;

          //     //console.log(x);

          //     $('#select_employee').append(`
          //         <option value="`+id+`">`+col_empl_cmid+` - `+ col_frst_name +` ` + col_last_name + `</option>
          //     `)
          // })
        })

        update_calc();
    })







    function integrate_cutoff_refresh(integ_cutoff_period, integ_empl_id){
      // integrated_cutoff_period = $(this).val();
      //console.log(integ_cutoff_period);
      // var employee_id = $('#select_employee').val();


      get_previous_cutoff(url_get_previous_cutoff,integ_empl_id,integ_cutoff_period).then(function(data){
        if(data.length != 0){
          Array.from(data).forEach(function(x){
            GROSS_P_TAX_total = parseFloat(x.ti_gross);
            GOV_CONT_P_SSS_total = parseFloat(x.gov_sss_ee);
            GOV_CONT_P_philhealth_total = parseFloat(x.gov_philhealth_ee);
            GOV_CONT_P_pagibig_total = parseFloat(x.gov_pagibig_ee);

            GOV_CONT_P_ER_SSS_total = parseFloat(x.comp_cont_sss);
            GOV_CONT_P_EC_SSS_total = parseFloat(x.comp_cont_sss_ec);
            GOV_CONT_P_ER_philhealth_total = parseFloat(x.comp_cont_philhealth);
            GOV_CONT_P_ER_pagibig_total = parseFloat(x.comp_cont_pagibig);

            
          })
        } else {
            GROSS_P_TAX_total = 0;
            GOV_CONT_P_SSS_total = 0;
            GOV_CONT_P_philhealth_total = 0;
            GOV_CONT_P_pagibig_total = 0;

            GOV_CONT_P_ER_SSS_total = 0;
            GOV_CONT_P_EC_SSS_total = 0;
            GOV_CONT_P_ER_philhealth_total = 0;
            GOV_CONT_P_ER_pagibig_total = 0;
        }
            $('#GROSS_P_TAX_total').val(toDisplay(GROSS_P_TAX_total));
            $('#GOV_CONT_P_SSS_total').val(toDisplay(GOV_CONT_P_SSS_total));
            $('#GOV_CONT_P_philhealth_total').val(toDisplay(GOV_CONT_P_philhealth_total));
            $('#GOV_CONT_P_pagibig_total').val(toDisplay(GOV_CONT_P_pagibig_total));

            $('#GOV_CONT_EMPLYR_SSS_PREV').val(toDisplay(GOV_CONT_P_ER_SSS_total));
            $('#GOV_CONT_EMPLYR_SSS_EC_PREV').val(toDisplay(GOV_CONT_P_EC_SSS_total));
            $('#GOV_CONT_EMPLYR_philhealth_PREV').val(toDisplay(GOV_CONT_P_ER_philhealth_total));
            $('#GOV_CONT_EMPLYR_pagibig_PREV').val(toDisplay(GOV_CONT_P_ER_pagibig_total));

            // console.log(`
            
            // ===========================================================
            
            // `);

            // console.log('GROSS_P_TAX_total: ' + GROSS_P_TAX_total);
            // console.log('GOV_CONT_P_SSS_total: ' + GOV_CONT_P_SSS_total);
            // console.log('GOV_CONT_P_philhealth_total: ' + GOV_CONT_P_philhealth_total);
            // console.log('GOV_CONT_P_pagibig_total: ' + GOV_CONT_P_pagibig_total);
            
            // console.log('GOV_CONT_P_ER_SSS_total: ' + GOV_CONT_P_ER_SSS_total);
            // console.log('GOV_CONT_P_EC_SSS_total: ' + GOV_CONT_P_EC_SSS_total);
            // console.log('GOV_CONT_P_ER_philhealth_total: ' + GOV_CONT_P_ER_philhealth_total);
            // console.log('GOV_CONT_P_ER_pagibig_total: ' + GOV_CONT_P_ER_pagibig_total);

      })
    }









    // integrated cutoff period
    $('#integrated_cutoff_period').change(function(){
      var integrate_cutoff_period = $(this).val();
      var employee_id = $('#select_employee').val();

      // //console.log(integrate_cutoff_period);

      integrate_cutoff_refresh(integrate_cutoff_period, employee_id);

      // integrated_cutoff_period = $(this).val();
      // //console.log(integrated_cutoff_period);
      // var employee_id = $('#select_employee').val();


      // get_previous_cutoff(url_get_previous_cutoff,employee_id,integrated_cutoff_period).then(function(data){
      //   if(data.length != 0){
      //     Array.from(data).forEach(function(x){
      //       GROSS_P_TAX_total = parseFloat(x.ti_gross);
      //       GOV_CONT_P_SSS_total = parseFloat(x.gov_sss_ee);
      //       GOV_CONT_P_philhealth_total = parseFloat(x.gov_philhealth_ee);
      //       GOV_CONT_P_pagibig_total = parseFloat(x.gov_pagibig_ee);

      //       GOV_CONT_P_ER_SSS_total = parseFloat(x.comp_cont_sss);
      //       GOV_CONT_P_EC_SSS_total = parseFloat(x.comp_cont_sss_ec);
      //       GOV_CONT_P_ER_philhealth_total = parseFloat(x.comp_cont_philhealth);
      //       GOV_CONT_P_ER_pagibig_total = parseFloat(x.comp_cont_pagibig);

            
      //     })
      //   } else {
      //       GROSS_P_TAX_total = 0;
      //       GOV_CONT_P_SSS_total = 0;
      //       GOV_CONT_P_philhealth_total = 0;
      //       GOV_CONT_P_pagibig_total = 0;

      //       GOV_CONT_P_ER_SSS_total = 0;
      //       GOV_CONT_P_EC_SSS_total = 0;
      //       GOV_CONT_P_ER_philhealth_total = 0;
      //       GOV_CONT_P_ER_pagibig_total = 0;
      //   }
      //       $('#GROSS_P_TAX_total').val(toDisplay(GROSS_P_TAX_total));
      //       $('#GOV_CONT_P_SSS_total').val(toDisplay(GOV_CONT_P_SSS_total));
      //       $('#GOV_CONT_P_philhealth_total').val(toDisplay(GOV_CONT_P_philhealth_total));
      //       $('#GOV_CONT_P_pagibig_total').val(toDisplay(GOV_CONT_P_pagibig_total));

      //       $('#GOV_CONT_EMPLYR_SSS_PREV').val(toDisplay(GOV_CONT_P_ER_SSS_total));
      //       $('#GOV_CONT_EMPLYR_SSS_EC_PREV').val(toDisplay(GOV_CONT_P_EC_SSS_total));
      //       $('#GOV_CONT_EMPLYR_philhealth_PREV').val(toDisplay(GOV_CONT_P_ER_philhealth_total));
      //       $('#GOV_CONT_EMPLYR_pagibig_PREV').val(toDisplay(GOV_CONT_P_ER_pagibig_total));

      //       //console.log('GROSS_P_TAX_total: ' + GROSS_P_TAX_total);
      //       //console.log('GOV_CONT_P_SSS_total: ' + GOV_CONT_P_SSS_total);
      //       //console.log('GOV_CONT_P_philhealth_total: ' + GOV_CONT_P_philhealth_total);
      //       //console.log('GOV_CONT_P_pagibig_total: ' + GOV_CONT_P_pagibig_total);
            
      //       //console.log('GOV_CONT_P_ER_SSS_total: ' + GOV_CONT_P_ER_SSS_total);
      //       //console.log('GOV_CONT_P_EC_SSS_total: ' + GOV_CONT_P_EC_SSS_total);
      //       //console.log('GOV_CONT_P_ER_philhealth_total: ' + GOV_CONT_P_ER_philhealth_total);
      //       //console.log('GOV_CONT_P_ER_pagibig_total: ' + GOV_CONT_P_ER_pagibig_total);

      // })
    })

    // Check if track attendance or manual entry
    $('input[type=radio][name=generate_payroll_data]').change(function(){
        if(this.value=='automatic'){
            // if track attendance is checked, disable input field for multiplier
            
            $('#TI_basic_sal_mul').prop('disabled',true);
            $('#TI_absent_mul').prop('disabled',true);
            $('#TI_no_ti_to_mul').prop('disabled',true);
            $('#TI_tard_mul').prop('disabled',true);
            $('#TI_half_mul').prop('disabled',true);
            $('#TI_undertime_mul').prop('disabled',true);
            $('#TI_rest_mul').prop('disabled',true);
            $('#TI_rest_sp_hol_mul').prop('disabled',true);
            $('#TI_legal_hol_mul').prop('disabled',true);
            $('#TI_rest_legal_hol_mul').prop('disabled',true);
            $('#TI_reg_ot_mul').prop('disabled',true);
            $('#TI_nd_ot_mul').prop('disabled',true);
            $('#TI_nd_mul').prop('disabled',true);
            $('#TI_leave_mul').prop('disabled',true);
            $('#TI_de_minimis_mul').prop('disabled',true);
            $('#TI_rest_ot').prop('disabled',true);
            $('#TI_rest_nd_ot').prop('disabled',true);

        }
        else if (this.value == 'manual') {
            // if manual entry is checked, enable input field for multiplier
            $('#TI_basic_sal_mul').prop('disabled',false);
            $('#TI_absent_mul').prop('disabled',false);
            $('#TI_no_ti_to_mul').prop('disabled',false);
            $('#TI_tard_mul').prop('disabled',false);
            $('#TI_half_mul').prop('disabled',false);
            $('#TI_undertime_mul').prop('disabled',false);
            $('#TI_rest_mul').prop('disabled',false);
            $('#TI_rest_sp_hol_mul').prop('disabled',false);
            $('#TI_legal_hol_mul').prop('disabled',false);
            $('#TI_rest_legal_hol_mul').prop('disabled',false);
            $('#TI_reg_ot_mul').prop('disabled',false);
            $('#TI_nd_ot_mul').prop('disabled',false);
            $('#TI_nd_mul').prop('disabled',false);
            $('#TI_leave_mul').prop('disabled',false);
            $('#TI_de_minimis_mul').prop('disabled',false);
            $('#TI_rest_ot_mul').prop('disabled',false);
            $('#TI_rest_nd_ot_mul').prop('disabled',false);
        }
    });


    


    // track attendance function
    function update_calc(){
        display_loans();
        track_attendance();
        computeTI();
        setTimeout(() => {
            contribution_calc();
        }, 500);
        //save_to_db();
    }

    function update_calc_manual(){
      display_loans();
      computeTI();
      contribution_calc();
    }

    function display_loans(){
      var get_empl_cmid = $('#select_employee option:selected').text();
      var cutoff_period = $('#cutoff_period option:selected').text();

      var split_get_empl_cmid = get_empl_cmid.split(' - ');
      var employee_cmid = $.trim(split_get_empl_cmid[0]);

      var sssloan_isChecked = $('#salary_loan:checkbox:checked').length > 0;
      var pagibigloan_isChecked = $('#pagibig_loan:checkbox:checked').length > 0;
      var emergency_loan_isChecked = $('#emergency_loan:checkbox:checked').length > 0;

      get_loan_payable_data(url_get_loan_payable_data, employee_cmid, cutoff_period).then(function(data){
        var sss_salary_loan = 0;
        var sss_calamity_loan = 0;
        var hdmf_salary_loan = 0;
        var hdmf_calamity_loan = 0;
        var emergency_loan = 0;
        
        if(data.length != 0){
          
          Array.from(data).forEach(function(x){
            // display loans
              // //console.log(x.loan_type);
              
              

              switch(x.loan_type){
                case 'SSS Salary Loan':
                  // code block
                  sss_salary_loan = parseFloat(x.installment);
                  // //console.log('sss_salary_loan: ' + sss_salary_loan);
                  break;
                case 'SSS Calamity Loan':
                  // code block
                  sss_calamity_loan = parseFloat(x.installment);
                  // //console.log('sss_calamity_loan: ' + sss_calamity_loan);
                  break;
                case 'Pag-ibig Salary Loan':
                  // code block
                  hdmf_salary_loan = parseFloat(x.installment);
                  // //console.log('hdmf_salary_loan: ' + hdmf_salary_loan);
                  break;
                case 'Pag-ibig Calamity Loan':
                  // code block
                  hdmf_calamity_loan = parseFloat(x.installment);
                  // //console.log('hdmf_calamity_loan: ' + hdmf_calamity_loan);
                  break;
                case 'Emergency Loan':
                  // code block
                  emergency_loan = parseFloat(x.installment);
                  // //console.log('emergency_loan: ' + emergency_loan);
                  break;
                default:
                  sss_salary_loan = 0;
                  sss_calamity_loan = 0;
                  hdmf_salary_loan = 0;
                  hdmf_calamity_loan = 0;
                  emergency_loan = 0;
                  
              }
          })
        } 

        else {
          sss_salary_loan = 0;
          sss_calamity_loan = 0;
          hdmf_salary_loan = 0;
          hdmf_calamity_loan = 0;
          emergency_loan = 0;
        }

        if(!sssloan_isChecked){
            sss_salary_loan = 0;
            sss_calamity_loan = 0;
        }
        if(!pagibigloan_isChecked){
            hdmf_salary_loan = 0;
            hdmf_calamity_loan = 0;
        }
        if(!emergency_loan_isChecked){
            emergency_loan = 0;
        }

        // if($('#LOAN_SSS_salary_loan_total').val() == '0'){
          $('#LOAN_SSS_salary_loan_total').val(toDisplay(sss_salary_loan));
        // }

        // if($('#LOAN_SSS_calamity_loan_total').val() == '0'){
          $('#LOAN_SSS_calamity_loan_total').val(toDisplay(sss_calamity_loan));
        // }
        
        // if($('#LOAN_HDMF_salary_loan_total').val() == '0'){
          $('#LOAN_HDMF_salary_loan_total').val(toDisplay(hdmf_salary_loan));
        // }

        // if($('#LOAN_HDMF_calamity_loan_total').val() == '0'){
          $('#LOAN_HDMF_calamity_loan_total').val(toDisplay(hdmf_calamity_loan));
        // }

        // if($('#LOAN_company_loan_total').val() == '0'){
          $('#LOAN_company_loan_total').val(emergency_loan);
        // }

        total_LOAN = parseFloat($('#LOAN_SSS_salary_loan_total').val()) + parseFloat($('#LOAN_SSS_calamity_loan_total').val()) + parseFloat($('#LOAN_HDMF_salary_loan_total').val()) + parseFloat($('#LOAN_HDMF_calamity_loan_total').val()) + parseFloat($('#LOAN_company_loan_total').val());

        // //console.log('total_LOAN: ' + total_LOAN);

        $('#LOAN_total').val(toDisplay(total_LOAN));  
        $('#OVR_total_LOAN').val(toDisplay(total_LOAN));
        
      })
    }


    function track_attendance(){
      var url_attendance_count = '<?= base_url() ?>payroll/get_attendance_count';
      var employee_id = $('#select_employee').val();
      var cutoff_period = $('#cutoff_period option:selected').attr('period');

      get_attendance_count(url_attendance_count, employee_id, cutoff_period).then(function(data){
        // $('#TI_reg_multiplier').val(data.bp_reg);

        // New attendance count
        work_days = data.work_day;
        no_ti_to = data.no_ti_to;
        rest = data.bp_sp_hol;
        reg_hol = data.bp_reg_hol;
        rest_reg_hol = data.bp_reg_hol_rest;
        rest_sp_hol = data.bp_sp_rest;
        abs = parseInt(data.absences) + parseInt(data.leaves);
        tard = data.late;
        ut = data.undertime;
        nd = data.bp_reg_ns;
        reg_ot = data.ot_reg;
        nd_ot = data.ot_reg_ns;
        pd_l = data.leaves;
        half = data.half_day;
        rest_ot = data.rest_ot;
        rest_nd_ot = data.rest_nd_ot;

        //console.log('rest_ot' + rest_ot);
        //console.log('rest_nd_ot' + rest_nd_ot);
        
        // half = data.rest;
        // half = data.half_day;

        console.log('LEGAL HOLIDAY: ' + reg_hol);
        

        $('#TI_basic_sal_mul').val(work_days);
        $('#TI_absent_mul').val(abs);
        $('#TI_no_ti_to_mul').val(no_ti_to);
        $('#TI_tard_mul').val(tard);
        $('#TI_half_mul').val(half);
        $('#TI_undertime_mul').val(ut);
        $('#TI_rest_mul').val(rest);
        $('#TI_rest_sp_hol_mul').val(rest_sp_hol);
        
        if(salary_type == "Monthly"){
          $('#TI_legal_hol_mul').val(0);
        } else if (salary_type == "Daily"){
          $('#TI_legal_hol_mul').val(reg_hol);
        } else {
          $('#TI_legal_hol_mul').val(0);
        }
       
        
        $('#TI_rest_legal_hol_mul').val(rest_reg_hol);
        $('#TI_reg_ot_mul').val(reg_ot);
        $('#TI_nd_ot_mul').val(nd_ot);
        $('#TI_nd_mul').val(nd);
        $('#TI_leave_mul').val(pd_l);
        $('#TI_de_minimis_mul').val(work_days);
        $('#TI_rest_ot_mul').val(rest_ot);
        $('#TI_rest_nd_ot_mul').val(rest_nd_ot);


      })
    } 

    function toDisplay(num) {
        num = parseFloat(num).toFixed(4);
        return (+(Math.round(+(num + 'e' + 2)) + 'e' + -2)).toFixed(2);
    }
    function toDisplay3(num) {
        return (+(Math.round(+(num + 'e' + 3)) + 'e' + -3)).toFixed(3);
    }
    function toDB4( num) {
        return (+(Math.round(+(num + 'e' + 4)) + 'e' + -4)).toFixed(4);
    }


    function contribution_calc(){

      tax_load =  parseFloat($('#TAX_LOAD').val());
      tax_trans =  parseFloat($('#TAX_TRANS').val());
      tax_skill =  parseFloat($('#TAX_SKILL').val());
      tax_pioneer =  parseFloat($('#TAX_PIONEER').val());
      tax_group_leader =  parseFloat($('#TAX_GROUP_LEADER').val());
      tax_daily =  parseFloat($('#TAX_DAILY').val());

      sss_isChecked = $('#sss_deduction:checkbox:checked').length > 0;
      philhealth_isChecked = $('#philhealth_deduction:checkbox:checked').length > 0;
      pagibig_isChecked = $('#pagibig_deduction:checkbox:checked').length > 0;

      total_GTI_OVERALL = TI_gross + GROSS_P_TAX_total;
      $('#GROSS_P_TAX_OVERALL').val(toDisplay(total_GTI_OVERALL));

      var integrated_cutoff_period = $('#integrated_cutoff_period').val();

      getSssTax(url,total_GTI_OVERALL).then(data => {
        data.sss.forEach((x) => {
          
          var sss_ee_val = x.ee;
          var sss_er_val = x.er;
          var sss_ec_val = x.ec_er;

          sss_er_val = (sss_er_val - sss_ec_val);

          // //console.log('sss_ec_val: ' + sss_ec_val);
          // //console.log('sss_er_val: ' + sss_er_val);
          // //console.log('sss_new_er_val: ' + (sss_er_val - sss_ec_val));

          var philhealth_ee_val;
          var philhealth_er_val;

          var pagibig_ee_val;        
          var pagibig_er_val;

          var philhealth_salary;
          var philhealth_constant;

          if(salary_type == 'Monthly')
          {
            // philhealth_salary = TI_basic_sal_total * 2;
            philhealth_salary = salary_rate;
            philhealth_constant = 2;
            // philhealth_salary = TI_basic_sal_total;
            // philhealth_constant = 2;
          }
          else{
            philhealth_salary = TI_basic_sal_total;
            philhealth_constant = 2;
          }

          if(philhealth_salary >= 100000){      
            philhealth_ee_val = 5000/philhealth_constant;
            philhealth_er_val = 5000/philhealth_constant;
          } else if((philhealth_salary > 10000) && (philhealth_salary < 100000)) {
            philhealth_ee_val = (philhealth_salary * (5.00 / 100)/philhealth_constant);
            philhealth_er_val = (philhealth_salary * (5.00 / 100)/philhealth_constant);
          } else { 
            philhealth_ee_val = 500/philhealth_constant;
            philhealth_er_val = 500/philhealth_constant;
          }

          // var philhealth_half_val = philhealth_ee_val;

            // FORCE 100 PHP ang Pagibig ng BANDAI
          // if(total_GTI_OVERALL >= 5000){      
          //     pagibig_ee_val = 100;
          //     pagibig_er_val = 100;
          //   } else if((total_GTI_OVERALL >= 1500) && (total_GTI_OVERALL < 5000)) {
          //     pagibig_ee_val = (parseFloat(total_GTI_OVERALL * 0.02));
          //     pagibig_er_val = (parseFloat(total_GTI_OVERALL * 0.02));
          //   } else {
          //     pagibig_ee_val = (parseFloat(total_GTI_OVERALL * 0.01));
          //     pagibig_er_val = (parseFloat(total_GTI_OVERALL * 0.02));
          //   }

          pagibig_ee_val = 100;
          pagibig_er_val = 100;

          sss_ee_val_diff = sss_ee_val - GOV_CONT_P_SSS_total;
          sss_er_val_diff = sss_er_val - GOV_CONT_P_ER_SSS_total;
          sss_ec_val_diff = sss_ec_val - GOV_CONT_P_EC_SSS_total;

          if(integrated_cutoff_period == 'not_connected'){

            philhealth_ee_val_diff = philhealth_ee_val;
            philhealth_er_val_diff = philhealth_er_val;

          }
          else{
            if(salary_type == 'Monthly')
            {

              philhealth_ee_val = philhealth_ee_val;
              philhealth_er_val = philhealth_ee_val;

              philhealth_ee_val_diff = philhealth_ee_val - GOV_CONT_P_philhealth_total;
              philhealth_er_val_diff = philhealth_ee_val - GOV_CONT_P_ER_philhealth_total;

            }
            else{

              philhealth_ee_val = philhealth_ee_val;
              philhealth_er_val = philhealth_ee_val;

              philhealth_ee_val_diff = 0;
              philhealth_er_val_diff = 0;

            }
          }

          // console.log('salary_type: ' + salary_type);
          // console.log('integrated_cutoff_period: ' + integrated_cutoff_period);

          // console.log('philhealth_ee_val: ' + philhealth_ee_val);
          // console.log('GOV_CONT_P_philhealth_total: ' + GOV_CONT_P_philhealth_total);
          // console.log('philhealth_ee_val_diff: ' + philhealth_ee_val_diff);

          pagibig_ee_val_diff = pagibig_ee_val - GOV_CONT_P_pagibig_total;  
          pagibig_er_val_diff = pagibig_er_val - GOV_CONT_P_ER_pagibig_total;  

          // GET SSS (EMPLOYEE)
          if(!sss_isChecked){
            sss_ee_val_diff = 0.00; 
            sss_er_val_diff = 0.00; 
          }
          // GET PHILHEALTH (EMPLOYEE)
          if(!philhealth_isChecked){
            philhealth_ee_val_diff = 0.00;
            philhealth_er_val_diff = 0.00;
          }
          // GET PAGIBIG (EMPLOYEE)
          if(!pagibig_isChecked){
            pagibig_ee_val_diff = 0.00;
            pagibig_er_val_diff = 0.00;
          }

          // ------------------- Computation ------------------------------
          tax_allow_tot = tax_load + tax_trans + tax_skill + tax_pioneer + tax_group_leader + tax_daily;

          contri_total = sss_ee_val_diff + philhealth_ee_val_diff + pagibig_ee_val_diff;
          contri_total_ER = parseFloat(sss_er_val) + parseFloat(philhealth_er_val) + parseFloat(pagibig_er_val);

          contri_total_ER_diff = sss_er_val_diff + sss_ec_val_diff + philhealth_er_val_diff + pagibig_er_val_diff;
          
          TOT_tax_income = TI_gross - contri_total + tax_allow_tot;
          gross_TI = parseFloat(total_GTI_OVERALL) - sss_ee_val - philhealth_ee_val - pagibig_ee_val;

          $('#GOV_CONT_D_SSS_total').val(toDisplay(sss_ee_val_diff));
          $('#GOV_CONT_D_philhealth_total').val(toDisplay(philhealth_ee_val_diff));
          $('#GOV_CONT_D_pagibig_total').val(toDisplay(pagibig_ee_val_diff));
          
          $('#GOV_TOTAL_EESHARE').val(toDisplay(contri_total));
          $('#LTI_Contri').val(toDisplay(contri_total));

          $('#TAX_ALLOW_TOTAL').val(toDisplay(tax_allow_tot));
          $('#LTI_Allow').val(toDisplay(tax_allow_tot));
          $('#LTI_Tot').val(toDisplay(TOT_tax_income));
          
         // $('#GROSS_TAX_TI_total').val(toDisplay(gross_TI));
          $('#OVR_total_TI').val(toDisplay(TOT_tax_income));

          $('#GOV_CONT_SSS_total').val(toDisplay(sss_ee_val));
          $('#GOV_CONT_philhealth_total').val(toDisplay(philhealth_ee_val));
          $('#GOV_CONT_pagibig_total').val(toDisplay(pagibig_ee_val));
          
          $('#GOV_CONT_EMPLYR_SSS_total').val(toDisplay(sss_er_val));
          $('#GOV_CONT_EMPLYR_SSS_EC_total').val(toDisplay(sss_ec_val));
          $('#GOV_CONT_EMPLYR_philhealth_total').val(toDisplay(philhealth_er_val));
          $('#GOV_CONT_EMPLYR_pagibig_total').val(toDisplay(pagibig_er_val));   
          $('#GOV_CONT_EMPLYR_total_TOT').val(toDisplay(contri_total_ER)); 

          $('#GOV_CONT_EMPLYR_SSS_DIF').val(toDisplay(sss_er_val_diff));
          $('#GOV_CONT_EMPLYR_SSS_EC_DIF').val(toDisplay(sss_ec_val_diff));
          $('#GOV_CONT_EMPLYR_philhealth_DIF').val(toDisplay(philhealth_er_val_diff));
          $('#GOV_CONT_EMPLYR_pagibig_DIF').val(toDisplay(pagibig_er_val_diff)); 
          $('#GOV_CONT_EMPLYR_DIF_TOT').val(toDisplay(contri_total_ER_diff)); 

          getSalaryWitholdingTax(url_wtax,TOT_tax_income).then(data => {
            data.witholding_tax.forEach((x) => {
                tax_isChecked = $('#tax_deduction:checkbox:checked').length > 0;
                total_wtax;
                
                if(tax_isChecked){
                  total_wtax =  parseFloat(x.fixed) + (parseFloat(TOT_tax_income) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent / 100)).toFixed(4);
                }
                else{
                  total_wtax = 0.00;
                }

                net_pay = (TOT_tax_income + TI_sil_2020) - total_wtax - total_DED - total_LOAN;
                $('#GOV_CONT_with_tax_total').val(toDisplay(total_wtax));
                $('#OVR_total_GOV').val(toDisplay(total_wtax));
                $('#OVR_total').val(toDisplay(net_pay));
              
            });
          });
        });
      });
    }

  

    

    // input number of days if 'input days here' is chosen
    $('#date_range').change(function(){
      update_calc();
    })

    

    function computeTI(){
      // new attendance record
      TI_basic_sal_mul = parseFloat($('#TI_basic_sal_mul').val());
      TI_absent_mul = parseFloat($('#TI_absent_mul').val());
      TI_no_ti_to_mul = parseFloat($('#TI_no_ti_to_mul').val());
      TI_tard_mul = parseFloat($('#TI_tard_mul').val());
      TI_half_mul = parseFloat($('#TI_half_mul').val());
      TI_undertime_mul = parseFloat($('#TI_undertime_mul').val());
      TI_rest_mul = parseFloat($('#TI_rest_mul').val());
      TI_rest_sp_hol_mul = parseFloat($('#TI_rest_sp_hol_mul').val());
      TI_legal_hol_mul = parseFloat($('#TI_legal_hol_mul').val());
      TI_rest_legal_hol_mul = parseFloat($('#TI_rest_legal_hol_mul').val());
      TI_reg_ot_mul = parseFloat($('#TI_reg_ot_mul').val());
      TI_nd_ot_mul = parseFloat($('#TI_nd_ot_mul').val());
      TI_nd_mul = parseFloat($('#TI_nd_mul').val());
      TI_leave_mul = parseFloat($('#TI_leave_mul').val());
      TI_de_minimis_mul = parseFloat($('#TI_de_minimis_mul').val());
      TI_rest_ot_mul = parseFloat($('#TI_rest_ot_mul').val());
      TI_rest_nd_ot_mul = parseFloat($('#TI_rest_nd_ot_mul').val());

      TI_sil_2020 = parseFloat($('#TI_sil_2020').val());
      TI_meal = parseFloat($('#TI_meal').val());
      TI_gov_cont = parseFloat($('#TI_gov_cont').val());
      TI_others = parseFloat($('#TI_others').val());

      ///// ROW 2 /////
      ///// ROW 3 /////
      DED_tax_refund = parseFloat($('#DED_tax_refund').val());
      DED_salary_advances = parseFloat($('#DED_salary_advances').val());
      DED_uniform_deduction = parseFloat($('#DED_uniform_deduction').val());

      salary_type = $('#salary_type').val();
      salary_rate = parseFloat($('#salary_rate').val());
      hours_per_day = parseFloat($('#work_hours').val());

      var daily_ST_month = (salary_rate * 12) / 313;
      var daily_ST_daily = salary_rate;

      if(salary_type == 'Monthly'){
         daily_salary = daily_ST_month;
      } else {
         daily_salary = daily_ST_daily;
      }  
      
      hourly_salary = daily_salary / hours_per_day;

      TI_basic_sal = daily_salary;
      TI_absent = daily_salary;
      TI_no_ti_to = daily_salary;
      TI_tard = hourly_salary;
      TI_half = hourly_salary;
      TI_undertime = hourly_salary;
      TI_rest = hourly_salary * 1.3;
      TI_rest_sp_hol = hourly_salary * 1.5;
      // TI_legal_hol = hourly_salary * 2; ** OLD VERSION ** 
      TI_legal_hol = daily_salary;
      TI_rest_legal_hol = hourly_salary * 2.6;
      TI_reg_ot = hourly_salary * 1.25;
      TI_nd_ot = hourly_salary * (1.25 * 0.1)
      TI_nd = hourly_salary * 0.1;
      TI_leave = daily_salary;
      TI_de_minimis = 40;

      // TI_rest_ot = hourly_salary * 1.69;
      // TI_rest_ot = hourly_salary * (1.25 * 0.3);
      // TI_rest_nd_ot = hourly_salary * (1.25 * 0.1 * 0.3);
      TI_rest_ot = hourly_salary * 1.69;
      TI_rest_nd_ot = hourly_salary * (1.69 * 0.1);
   
      //CONTROVERSIONA
      TI_basic_sal;

      if(salary_type == 'Monthly'){
        TI_basic_sal_total = salary_rate/2;
      } else {
        TI_basic_sal_total = parseFloat(TI_basic_sal_mul) * daily_salary;//
      }  

      if(salary_type == 'Monthly'){
        TI_absent_total = parseFloat(TI_absent_mul) * TI_absent;
        TI_no_ti_to_total = parseFloat(TI_no_ti_to_mul) * TI_no_ti_to;
      } else {
        TI_absent_total = 0;
        TI_no_ti_to_total = 0;
      }  
      
      // TI_no_ti_to_total = parseFloat(TI_no_ti_to_mul) * TI_no_ti_to;
      TI_tard_total = parseFloat(TI_tard_mul) * TI_tard;
      TI_half_total = parseFloat(TI_half_mul) * TI_half;
      TI_undertime_total = parseFloat(TI_undertime_mul) * TI_undertime;
      TI_rest_total = parseFloat(TI_rest_mul) * TI_rest;
      TI_rest_sp_hol_total = parseFloat(TI_rest_sp_hol_mul) * TI_rest_sp_hol;
      TI_legal_hol_total = parseFloat(TI_legal_hol_mul) * TI_legal_hol;
      TI_rest_legal_hol_total = parseFloat(TI_rest_legal_hol_mul) * TI_rest_legal_hol;
      TI_reg_ot_total = parseFloat(TI_reg_ot_mul) * TI_reg_ot;
      TI_nd_ot_total = parseFloat(TI_nd_ot_mul) * TI_nd_ot;
      TI_nd_total = parseFloat(TI_nd_mul) * TI_nd;
      TI_leave_total = parseFloat(TI_leave_mul) * TI_leave;
      TI_de_minimis_total = parseFloat(TI_de_minimis_mul) * TI_de_minimis;
      TI_rest_ot_total = parseFloat(TI_rest_ot_mul) * TI_rest_ot;
      TI_rest_nd_ot_total = parseFloat(TI_rest_nd_ot_mul) * TI_rest_nd_ot;

      // //console.log(parseFloat(TI_rest_ot_mul));
      // //console.log(parseFloat(TI_rest_nd_ot_mul));

      // TI_gross = TI_basic_sal_total - TI_absent_total - TI_no_ti_to_total - TI_tard_total - TI_half_total - TI_undertime_total + TI_rest_total + TI_rest_sp_hol_total + TI_legal_hol_total + TI_rest_legal_hol_total + TI_reg_ot_total + TI_nd_ot_total + TI_nd_total + TI_rest_ot_total + TI_rest_nd_ot_total + TI_leave_total + TI_de_minimis_total + TI_sil_2020 + TI_meal - TI_gov_cont + TI_others; 
      TI_gross = TI_basic_sal_total - TI_absent_total - TI_no_ti_to_total - TI_tard_total - TI_half_total - TI_undertime_total + TI_rest_total + TI_rest_sp_hol_total + TI_legal_hol_total + TI_rest_legal_hol_total + TI_reg_ot_total + TI_nd_ot_total + TI_nd_total + TI_rest_ot_total + TI_rest_nd_ot_total + TI_leave_total + TI_de_minimis_total + TI_meal - TI_gov_cont + TI_others; 
      
      total_DED = DED_salary_advances + DED_uniform_deduction - DED_tax_refund;
      
      // ti_rest = parseFloat(TI_rest_M) * TI_rest_s;
      // ti_sp_hol = parseFloat(TI_spec_hol_M) * TI_spec_hol_s;
      // ti_sp_hol_rest = parseFloat(TI_spec_hol_rest_M) * TI_spec_hol_rest_s;
      // ti_reg_hol = parseFloat(TI_reg_hol_M) * TI_reg_hol_s;
      // ti_reg_hol_rest = parseFloat(TI_reg_hol_rest_M) * TI_reg_hol_rest_s;
      // ti_dbl_hol = parseFloat(TI_double_hol_M) * TI_double_hol_s;
      // ti_dbl_hol_rest = parseFloat(TI_double_hol_rest_M) * TI_double_hol_rest_s;
      // ti_reg_ns = parseFloat(TI_regular_ns_M) * TI_regular_ns_s;
      // ti_rest_ns = parseFloat(TI_rest_ns_M) * TI_rest_ns_s;
      // ti_sp_hol_ns = parseFloat(TI_spec_hol_ns_M) * TI_spec_hol_ns_s;
      // ti_sp_hol_rest_ns = parseFloat(TI_spec_hol_rest_ns_M) * TI_spec_hol_rest_ns_s;
      // ti_reg_hol_ns = parseFloat(TI_reg_hol_ns_M) * TI_reg_hol_ns_s;
      // ti_reg_hol_rest_ns = parseFloat(TI_reg_hol_rest_ns_M) * TI_reg_hol_rest_ns_s;
      // ti_dbl_hol_ns = parseFloat(TI_double_hol_ns_M) * TI_double_hol_ns_s;
      // ti_dbl_hol_rest_ns = parseFloat(TI_double_hol_rest_ns_M) * TI_double_hol_rest_ns_s; 
      // TI_reg_ot = parseFloat(TI_reg_ot_M) * TI_reg_ot_s;
      // TI_rest_ot = parseFloat(TI_rest_ot_M) * TI_rest_ot_s;
      // TI_spec_hol_ot = parseFloat(TI_spec_hol_ot_M) * TI_spec_hol_ot_s;
      // TI_spec_hol_rest_ot = parseFloat(TI_spec_hol_rest_ot_M) * TI_spec_hol_rest_ot_s;
      // TI_reg_hol_ot = parseFloat(TI_reg_hol_ot_M) * TI_reg_hol_ot_s;
      // TI_reg_hol_rest_ot = parseFloat(TI_reg_hol_rest_ot_M) * TI_reg_hol_rest_ot_s;
      // TI_double_hol_ot = parseFloat(TI_double_hol_ot_M) * TI_double_hol_ot_s;
      // TI_double_hol_rest_ot = parseFloat(TI_double_hol_rest_ot_M) * TI_double_hol_rest_ot_s;
      // TI_reg_ot_ns = parseFloat(TI_reg_ot_ns_M) * TI_reg_ot_ns_s;
      // TI_rest_ot_ns = parseFloat(TI_rest_ot_ns_M) * TI_rest_ot_ns_s;
      // TI_spec_hol_ot_ns = parseFloat(TI_spec_hol_ot_ns_M) * TI_spec_hol_ot_ns_s;
      // TI_spec_hol_rest_ot_ns = parseFloat(TI_spec_hol_rest_ot_ns_M) * TI_spec_hol_rest_ot_ns_s;
      // TI_reg_hol_ot_ns = parseFloat(TI_reg_hol_ot_ns_M) * TI_reg_hol_ot_ns_s;
      // TI_reg_hol_rest_ot_ns = parseFloat(TI_reg_hol_rest_ot_ns_M) * TI_reg_hol_rest_ot_ns_s;
      // TI_double_hol_ot_ns = parseFloat(TI_double_hol_ot_ns_M) * TI_double_hol_ot_ns_s;
      // TI_double_hol_rest_ot_ns = parseFloat(TI_double_hol_rest_ot_ns_M) * TI_double_hol_rest_ot_ns_s;
      // TI_leave  =  daily_salary * parseFloat(TI_leave_M);

      // OTI_legal =  daily_salary * oti_legal_mul ;
      // OTI_meal = oti_meal * TI_reg_M ;
      // OTI_other2 = oti_2 * oti_2_mul ;
      // OTI_other3 = oti_3 * oti_3_mul ;
      // OTI_other4 = oti_4 * oti_4_mul ;
      // OTI_other5 = oti_5 * oti_5_mul ;
      // OTI_other6 = oti_6 * oti_6_mul ;
      // OTI_other7 = oti_7 * oti_7_mul ;
      // OTI_other8 = oti_8 * oti_8_mul ;
      // OTI_adj = oti_adj * oti_adj_mul ;

      // NTI_other1 = nti_1 * nti_1_mul ;
      // NTI_other2 = nti_2 * nti_2_mul ;
      // NTI_other3 = nti_3 * nti_3_mul ;
      // NTI_other4 = nti_4 * nti_4_mul ;
      // NTI_other5 = nti_5 * nti_5_mul ;
      // NTI_other6 = nti_6 * nti_6_mul ;
      // NTI_other7 = nti_7 * nti_7_mul ;

      // DED_other1 = ded_1 * ded_1_mul ;
      // DED_other2 = ded_2 * ded_2_mul ;
      // DED_other3 = ded_3 * ded_3_mul ;
      // DED_other4 = ded_4 * ded_4_mul ;
      // DED_other5 = ded_5 * ded_5_mul ;


      // subtotal_bp = ti_reg +ti_rest  + ti_sp_hol  + ti_sp_hol_rest  + ti_reg_hol  + ti_reg_hol_rest  + ti_dbl_hol  + ti_dbl_hol_rest  + ti_reg_ns  + ti_rest_ns  + ti_sp_hol_ns  + ti_sp_hol_rest_ns  + ti_reg_hol_ns  + ti_reg_hol_rest_ns  + ti_dbl_hol_ns  + ti_dbl_hol_rest_ns;
      // subtotal_ot = TI_reg_ot  + TI_rest_ot  + TI_spec_hol_ot  + TI_spec_hol_rest_ot  + TI_reg_hol_ot  + TI_reg_hol_rest_ot  + TI_double_hol_ot  + TI_double_hol_rest_ot  + TI_reg_ot_ns  + TI_rest_ot_ns  + TI_spec_hol_ot_ns  + TI_spec_hol_rest_ot_ns  + TI_reg_hol_ot_ns  + TI_reg_hol_rest_ot_ns  + TI_double_hol_ot_ns  + TI_double_hol_rest_ot_ns;
      // subtotal_OTI = OTI_legal+OTI_meal+OTI_other2+OTI_other3+OTI_other4+OTI_other5+OTI_other6+OTI_other7+OTI_other8+OTI_adj;
      // subtotal_absent_late = TI_absent + TI_late_undertime;
      // total_TI = subtotal_bp + subtotal_ot + subtotal_OTI - subtotal_absent_late + TI_leave;
      // total_NTI = NTI_other1+NTI_other2+NTI_other3+NTI_other4+NTI_other5+NTI_other6+NTI_other7;
      // total_DED = DED_other1+DED_other2+DED_other3+DED_other4+DED_other5;
      
      //------------------------------------- TEXT -----------------------------------------
      
      ////// HEAD CARD ///////
      $('#daily_salary').text(toDisplay(daily_salary));
      $('#hourly_salary').text(toDisplay(hourly_salary));
      var zero_val = 0; 
       
      ////// ROW 1 ////////
      $('#TI_basic_sal').val(toDisplay(TI_basic_sal));
      $('#TI_absent').val(toDisplay(TI_absent));
      $('#TI_no_ti_to').val(toDisplay(TI_no_ti_to));
      $('#TI_tard').val(toDisplay(TI_tard));
      $('#TI_half').val(toDisplay(TI_half));
      $('#TI_undertime').val(toDisplay(TI_undertime));
      $('#TI_rest').val(toDisplay(TI_rest));
      $('#TI_rest_sp_hol').val(toDisplay(TI_rest_sp_hol));
      $('#TI_legal_hol').val(toDisplay(TI_legal_hol));
      $('#TI_rest_legal_hol').val(toDisplay(TI_rest_legal_hol));
      $('#TI_reg_ot').val(toDisplay(TI_reg_ot));
      $('#TI_nd_ot').val(toDisplay(TI_nd_ot));
      $('#TI_nd').val(toDisplay(TI_nd));
      $('#TI_leave').val(toDisplay(TI_leave));
      $('#TI_de_minimis').val(toDisplay(TI_de_minimis));
      $('#TI_rest_ot').val(toDisplay(TI_rest_ot));
      $('#TI_rest_nd_ot').val(toDisplay(TI_rest_nd_ot));

      $('#TI_basic_sal_total').val(toDisplay(TI_basic_sal_total));
      $('#TI_absent_total').val(toDisplay(TI_absent_total));
      $('#TI_no_ti_to_total').val(toDisplay(TI_no_ti_to_total));
      $('#TI_tard_total').val(toDisplay(TI_tard_total));
      $('#TI_half_total').val(toDisplay(TI_half_total));
      $('#TI_undertime_total').val(toDisplay(TI_undertime_total));
      $('#TI_rest_total').val(toDisplay(TI_rest_total));
      $('#TI_rest_sp_hol_total').val(toDisplay(TI_rest_sp_hol_total));
      $('#TI_legal_hol_total').val(toDisplay(TI_legal_hol_total));
      $('#TI_rest_legal_hol_total').val(toDisplay(TI_rest_legal_hol_total));
      $('#TI_reg_ot_total').val(toDisplay(TI_reg_ot_total));
      $('#TI_nd_ot_total').val(toDisplay(TI_nd_ot_total));
      $('#TI_nd_total').val(toDisplay(TI_nd_total));
      $('#TI_leave_total').val(toDisplay(TI_leave_total));
      $('#TI_de_minimis_total').val(toDisplay(TI_de_minimis_total));
      $('#TI_rest_ot_total').val(toDisplay(TI_rest_ot_total));
      $('#TI_rest_nd_ot_total').val(toDisplay(TI_rest_nd_ot_total));

      $('#TI_gross').val(toDisplay(TI_gross));


      ////// ROW 2 ////////
      $('#GROSS_TAX_total').val(toDisplay(TI_gross));
      $('#LTI_Gross').val(toDisplay(TI_gross));


      /////// ROW 3 ///////
      $('#DED_total').val(toDisplay(total_DED));


      ////// ROW 4 ///////
      $('#OVR_total_TI').val(toDisplay(TI_gross));
      $('#OVR_SIL_2020').val(toDisplay(TI_sil_2020));
      $('#OVR_total_DED').val(toDisplay(total_DED));
      

      // $('#TI_leave_total').val(toDisplay(TI_leave));
      // $('#PD_leave').val(toDisplay(TI_leave));
      // $('#OTI_meal_multiplier').val(parseFloat(TI_reg_M));
      // $('#OTI_legal_total').val(toDisplay(OTI_legal));
      // $('#OTI_meal_total').val(toDisplay(OTI_meal));
      // $('#OTI_other2_total').val(toDisplay(OTI_other2));
      // $('#OTI_other3_total').val(toDisplay(OTI_other3));
      // $('#OTI_other4_total').val(toDisplay(OTI_other4));
      // $('#OTI_other5_total').val(toDisplay(OTI_other5));
      // $('#OTI_other6_total').val(toDisplay(OTI_other6));
      // $('#OTI_other7_total').val(toDisplay(OTI_other7));
      // $('#OTI_other8_total').val(toDisplay(OTI_other8));
      // $('#OTI_adj_total').val(toDisplay(OTI_adj));

      // $('#NTI_other1_total').val(toDisplay(NTI_other1));
      // $('#NTI_other2_total').val(toDisplay(NTI_other2));
      // $('#NTI_other3_total').val(toDisplay(NTI_other3));
      // $('#NTI_other4_total').val(toDisplay(NTI_other4));
      // $('#NTI_other5_total').val(toDisplay(NTI_other5));
      // $('#NTI_other6_total').val(toDisplay(NTI_other6));
      // $('#NTI_other7_total').val(toDisplay(NTI_other7));

      // $('#DED_other1_total').val(toDisplay(DED_other1));
      // $('#DED_other2_total').val(toDisplay(DED_other2));
      // $('#DED_other3_total').val(toDisplay(DED_other3));
      // $('#DED_other4_total').val(toDisplay(DED_other4));
      // $('#DED_other5_total').val(toDisplay(DED_other5));

      // $('#TI_absent').val(toDisplay(daily_salary));
      // $('#TI_late_undertime').val(toDisplay(hourly_salary));

      // $('#TI_absent_total').val(toDisplay(TI_absent));
      // $('#TI_late_undertime_total').val(toDisplay(TI_late_undertime));

      // $('#total_basic_pay').val(toDisplay(subtotal_bp));
      // $('#BP_total').val(toDisplay(subtotal_bp));
      // $('#total_overtime').val(toDisplay(subtotal_ot));
      // $('#OT_total').val(toDisplay(subtotal_ot));

      // $('#GROSS_TAX_total').val(toDisplay(total_TI));
      // $('#LTI_Gross').val(toDisplay(total_TI));

      // $('#OTI_total').val(toDisplay(subtotal_OTI));
      // $('#ABS_total').val(toDisplay(subtotal_absent_late));
      // $('#NTI_total').val(toDisplay(total_NTI));
      // $('#TI_total').val(toDisplay(total_TI));
      // $('#DED_total').val(toDisplay(total_DED));
      // $('#LOAN_total').val(toDisplay(total_LOAN));

      // OVER ALL
      // $('#OVR_total_TI').val(toDisplay(total_TI));
      // $('#OVR_total_NTI').val(toDisplay(total_NTI));
      // $('#OVR_total_DED').val(toDisplay(total_DED));
      // $('#OVR_total_LOAN').val(toDisplay(total_LOAN));

    }

    $('#custom_days').keyup(function(){
      computeTI($(this).val());
    })



    function save_to_db(){

      var ti_basic_sal_mul = TI_basic_sal_mul;
      var ti_absent_mul = TI_absent_mul;
      var ti_no_ti_to_mul = TI_no_ti_to_mul;
      var ti_tard_mul = TI_tard_mul;
      var ti_half_mul = TI_half_mul;
      var ti_undertime_mul = TI_undertime_mul;
      var ti_rest_mul = TI_rest_mul;
      var ti_rest_sp_hol_mul = TI_rest_sp_hol_mul;
      var ti_legal_hol_mul = TI_legal_hol_mul;
      var ti_rest_legal_hol_mul = TI_rest_legal_hol_mul;
      var ti_reg_ot_mul = TI_reg_ot_mul;
      var ti_nd_ot_mul = TI_nd_ot_mul;
      var ti_nd_mul = TI_nd_mul;
      var ti_leave_mul = TI_leave_mul;
      var ti_de_minimis_mul = TI_de_minimis_mul;
      var ti_rest_ot_mul = TI_rest_ot_mul;
      var ti_rest_nd_ot_mul = TI_rest_nd_ot_mul;

      var ti_basic_sal_total = TI_basic_sal_total;
      var ti_absent_total = TI_absent_total;
      var ti_no_ti_to_total = TI_no_ti_to_total;
      var ti_tard_total = TI_tard_total;
      var ti_half_total = TI_half_total;
      var ti_undertime_total = TI_undertime_total;
      var ti_rest_total = TI_rest_total;
      var ti_rest_sp_hol_total = TI_rest_sp_hol_total;
      var ti_legal_hol_total = TI_legal_hol_total;
      var ti_rest_legal_hol_total = TI_rest_legal_hol_total;
      var ti_reg_ot_total = TI_reg_ot_total;
      var ti_nd_ot_total = TI_nd_ot_total;
      var ti_nd_total = TI_nd_total;
      var ti_leave_total = TI_leave_total;
      var ti_de_minimis_total = TI_de_minimis_total;
      var ti_rest_ot_total = TI_rest_ot_total;
      var ti_rest_nd_ot_total = TI_rest_nd_ot_total;

      var ti_sil_2020 = TI_sil_2020;
      var ti_meal = TI_meal;
      var ti_gov_cont = TI_gov_cont;
      var ti_others = TI_others;
      var ti_gross = TI_gross;

      var gov_sss_ee = sss_ee_val_diff;
      var gov_philhealth_ee = philhealth_ee_val_diff;
      var gov_pagibig_ee = pagibig_ee_val_diff;
      var gov_total_ee = contri_total;

      var comp_cont_sss = sss_er_val_diff;
      var comp_cont_sss_ec = sss_ec_val_diff;
      var comp_cont_philhealth = philhealth_er_val_diff;
      var comp_cont_pagibig = pagibig_er_val_diff;
      var comp_cont_total = contri_total_ER_diff;

      var ta_load = tax_load;
      var ta_transportation = tax_trans;
      var ta_skill = tax_skill;
      var ta_pioneer = tax_pioneer;
      var ta_group_leader = tax_group_leader;
      var ta_daily = tax_daily;
      var ta_allowance = tax_allow_tot;

      var ta_total = TOT_tax_income;
      var wtax = total_wtax;

      var loan_sss_salary = parseFloat($('#LOAN_SSS_salary_loan_total').val());
      var loan_sss_calamity = parseFloat($('#LOAN_SSS_calamity_loan_total').val());
      var loan_pagibig_salary = parseFloat($('#LOAN_HDMF_salary_loan_total').val());
      var loan_pagibig_calamity = parseFloat($('#LOAN_HDMF_calamity_loan_total').val());
      var loan_emergency = parseFloat($('#LOAN_company_loan_total').val());
      var loan_total = total_LOAN;

      var tax_refund = DED_tax_refund;
      var salary_advance = DED_salary_advances;
      var uniform_deduction = DED_uniform_deduction;
      var ded_total = total_DED;

      var db_net_pay = net_pay;

      $('input.empl_id').val($('#select_employee').val());
      $('input.empl_name').val($('#employee_name').text());
      $('input.salary_rate').val($('#salary_rate').val());
      $('input.work_rate').val($('#date_range').val());
      $('input.daily_salary').val($('#daily_salary').text());
      $('input.hourly_salary').val($('#hourly_salary').text());
      $('input.payroll_period').val($('#cutoff_period').val());
      $('input.working_days').val(parseInt($('#working_days').val()));
      $('input.hours_of_work').val($('#work_hours').val());
      
      // multiplier
      if(ti_basic_sal_mul){$('input.ti_basic_sal_mul').val(ti_basic_sal_mul);}else{$('input.ti_basic_sal_mul').val(0);}
      if(ti_absent_mul){$('input.ti_absent_mul').val(ti_absent_mul);}else{$('input.ti_absent_mul').val(0);}
      if(ti_no_ti_to_mul){$('input.ti_no_ti_to_mul').val(ti_no_ti_to_mul);}else{$('input.ti_no_ti_to_mul').val(0);}
      if(ti_tard_mul){$('input.ti_tard_mul').val(ti_tard_mul);}else{$('input.ti_tard_mul').val(0);}
      if(ti_half_mul){$('input.ti_half_mul').val(ti_half_mul);}else{$('input.ti_half_mul').val(0);}
      if(ti_undertime_mul){$('input.ti_undertime_mul').val(ti_undertime_mul);}else{$('input.ti_undertime_mul').val(0);}
      if(ti_rest_mul){$('input.ti_rest_mul').val(ti_rest_mul);}else{$('input.ti_rest_mul').val(0);}
      if(ti_rest_sp_hol_mul){$('input.ti_rest_sp_hol_mul').val(ti_rest_sp_hol_mul);}else{$('input.ti_rest_sp_hol_mul').val(0);}
      if(ti_legal_hol_mul){$('input.ti_legal_hol_mul').val(ti_legal_hol_mul);}else{$('input.ti_legal_hol_mul').val(0);}
      if(ti_rest_legal_hol_mul){$('input.ti_rest_legal_hol_mul').val(ti_rest_legal_hol_mul);}else{$('input.ti_rest_legal_hol_mul').val(0);}
      if(ti_reg_ot_mul){$('input.ti_reg_ot_mul').val(ti_reg_ot_mul);}else{$('input.ti_reg_ot_mul').val(0);}
      if(ti_nd_ot_mul){$('input.ti_nd_ot_mul').val(ti_nd_ot_mul);}else{$('input.ti_nd_ot_mul').val(0);}
      if(ti_nd_mul){$('input.ti_nd_mul').val(ti_nd_mul);}else{$('input.ti_nd_mul').val(0);}
      if(ti_leave_mul){$('input.ti_leave_mul').val(ti_leave_mul);}else{$('input.ti_leave_mul').val(0);}
      if(ti_de_minimis_mul){$('input.ti_de_minimis_mul').val(ti_de_minimis_mul);}else{$('input.ti_de_minimis_mul').val(0);}
      if(ti_rest_ot_mul){$('input.ti_rest_ot_mul').val(ti_rest_ot_mul);}else{$('input.ti_rest_ot_mul').val(0);}
      if(ti_rest_nd_ot_mul){$('input.ti_rest_nd_ot_mul').val(ti_rest_nd_ot_mul);}else{$('input.ti_rest_nd_ot_mul').val(0);}
      
      // total
      if(ti_basic_sal_total){$('input.ti_basic_sal_total').val(ti_basic_sal_total);}else{$('input.ti_basic_sal_total').val(0);}
      if(ti_absent_total){$('input.ti_absent_total').val(ti_absent_total);}else{$('input.ti_absent_total').val(0);}
      if(ti_no_ti_to_total){$('input.ti_no_ti_to_total').val(ti_no_ti_to_total);}else{$('input.ti_no_ti_to_total').val(0);}
      if(ti_tard_total){$('input.ti_tard_total').val(ti_tard_total);}else{$('input.ti_tard_total').val(0);}
      if(ti_half_total){$('input.ti_half_total').val(ti_half_total);}else{$('input.ti_half_total').val(0);}
      if(ti_undertime_total){$('input.ti_undertime_total').val(ti_undertime_total);}else{$('input.ti_undertime_total').val(0);}
      if(ti_rest_total){$('input.ti_rest_total').val(ti_rest_total);}else{$('input.ti_rest_total').val(0);}
      if(ti_rest_sp_hol_total){$('input.ti_rest_sp_hol_total').val(ti_rest_sp_hol_total);}else{$('input.ti_rest_sp_hol_total').val(0);}
      if(ti_legal_hol_total){$('input.ti_legal_hol_total').val(ti_legal_hol_total);}else{$('input.ti_legal_hol_total').val(0);}
      if(ti_rest_legal_hol_total){$('input.ti_rest_legal_hol_total').val(ti_rest_legal_hol_total);}else{$('input.ti_rest_legal_hol_total').val(0);}
      if(ti_reg_ot_total){$('input.ti_reg_ot_total').val(ti_reg_ot_total);}else{$('input.ti_reg_ot_total').val(0);}
      if(ti_nd_ot_total){$('input.ti_nd_ot_total').val(ti_nd_ot_total);}else{$('input.ti_nd_ot_total').val(0);}
      if(ti_nd_total){$('input.ti_nd_total').val(ti_nd_total);}else{$('input.ti_nd_total').val(0);}
      if(ti_leave_total){$('input.ti_leave_total').val(ti_leave_total);}else{$('input.ti_leave_total').val(0);}
      if(ti_de_minimis_total){$('input.ti_de_minimis_total').val(ti_de_minimis_total);}else{$('input.ti_de_minimis_total').val(0);}
      if(ti_rest_ot_total){$('input.ti_rest_ot_total').val(ti_rest_ot_total);}else{$('input.ti_rest_ot_total').val(0);}
      if(ti_rest_nd_ot_total){$('input.ti_rest_nd_ot_total').val(ti_rest_nd_ot_total);}else{$('input.ti_rest_nd_ot_total').val(0);}

      if(ti_sil_2020){$('input.ti_sil_2020').val(ti_sil_2020);}else{$('input.ti_sil_2020').val(0);}
      if(ti_meal){$('input.ti_meal').val(ti_meal);}else{$('input.ti_meal').val(0);}
      if(ti_gov_cont){$('input.ti_gov_cont').val(ti_gov_cont);}else{$('input.ti_gov_cont').val(0);}
      if(ti_others){$('input.ti_others').val(ti_others);}else{$('input.ti_others').val(0);}
      if(ti_gross){$('input.ti_gross').val(ti_gross);}else{$('input.ti_gross').val(0);}

      if(gov_sss_ee){$('input.gov_sss_ee').val(gov_sss_ee);}else{$('input.gov_sss_ee').val(0);}
      if(gov_philhealth_ee){$('input.gov_philhealth_ee').val(gov_philhealth_ee);}else{$('input.gov_philhealth_ee').val(0);}
      if(gov_pagibig_ee){$('input.gov_pagibig_ee').val(gov_pagibig_ee);}else{$('input.gov_pagibig_ee').val(0);}
      if(gov_total_ee){$('input.gov_total_ee').val(gov_total_ee);}else{$('input.gov_total_ee').val(0);}

      if(comp_cont_sss){$('input.comp_cont_sss').val(comp_cont_sss);}else{$('input.comp_cont_sss').val(0);}
      if(comp_cont_sss_ec){$('input.comp_cont_sss_ec').val(comp_cont_sss_ec);}else{$('input.comp_cont_sss_ec').val(0);}
      if(comp_cont_philhealth){$('input.comp_cont_philhealth').val(comp_cont_philhealth);}else{$('input.comp_cont_philhealth').val(0);}
      if(comp_cont_pagibig){$('input.comp_cont_pagibig').val(comp_cont_pagibig);}else{$('input.comp_cont_pagibig').val(0);}
      if(comp_cont_total){$('input.comp_cont_total').val(comp_cont_total);}else{$('input.comp_cont_total').val(0);}

      if(ta_load){$('input.ta_load').val(ta_load);}else{$('input.ta_load').val(0);}
      if(ta_transportation){$('input.ta_transportation').val(ta_transportation);}else{$('input.ta_transportation').val(0);}
      if(ta_skill){$('input.ta_skill').val(ta_skill);}else{$('input.ta_skill').val(0);}
      if(ta_pioneer){$('input.ta_pioneer').val(ta_pioneer);}else{$('input.ta_pioneer').val(0);}
      if(ta_group_leader){$('input.ta_group_leader').val(ta_group_leader);}else{$('input.ta_group_leader').val(0);}
      if(ta_daily){$('input.ta_daily_allowance').val(ta_daily);}else{$('input.ta_daily_allowance').val(0);}
      if(ta_allowance){$('input.ta_allowance').val(ta_allowance);}else{$('input.ta_allowance').val(0);}

      if(ta_total){$('input.ta_total').val(ta_total);}else{$('input.ta_total').val(0);}
      if(wtax){$('input.wtax').val(wtax);}else{$('input.wtax').val(0);}

      if(loan_sss_salary){$('input.loan_sss_salary').val(loan_sss_salary);}else{$('input.loan_sss_salary').val(0);}
      if(loan_sss_calamity){$('input.loan_sss_calamity').val(loan_sss_calamity);}else{$('input.loan_sss_calamity').val(0);}
      if(loan_pagibig_salary){$('input.loan_pagibig_salary').val(loan_pagibig_salary);}else{$('input.loan_pagibig_salary').val(0);}
      if(loan_pagibig_calamity){$('input.loan_pagibig_calamity').val(loan_pagibig_calamity);}else{$('input.loan_pagibig_calamity').val(0);}
      if(loan_emergency){$('input.loan_emergency').val(loan_emergency);}else{$('input.loan_emergency').val(0);}
      if(loan_total){$('input.loan_total').val(loan_total);}else{$('input.loan_total').val(0);}

      if(tax_refund){$('input.tax_refund').val(tax_refund);}else{$('input.tax_refund').val(0);}
      if(salary_advance){$('input.salary_advance').val(salary_advance);}else{$('input.salary_advance').val(0);}
      if(uniform_deduction){$('input.uniform_deduction').val(uniform_deduction);}else{$('input.uniform_deduction').val(0);}
      if(ded_total){$('input.ded_total').val(ded_total);}else{$('input.ded_total').val(0);}

      if(db_net_pay){$('input.net_pay').val(db_net_pay);}else{$('input.net_pay').val(0);}

      // for loan
      var get_empl_cmid = $('#select_employee option:selected').text();
      var salary_type = $('#salary_type').val();
      var cutoff_period = $('#cutoff_period option:selected').text();
      var split_get_empl_cmid = get_empl_cmid.split(' - ');
      var employee_cmid = $.trim(split_get_empl_cmid[0]);
      $('input.cutoff_period').val(cutoff_period);
      $('input.empl_cmid').val(employee_cmid);
      $('input.salary_type').val(salary_type);
    }




    


    var isReadyForCalculation = false;
    // var isReadyForPayslipGeneration = false;


    $('#calculate_all').click(function(){
      var employees = $('#select_employee').children();
      var employees_length = (employees.length) - 1;
      var interval  = 5000;
      var empl_id = '';

      var generated_empl_payslip = 0;

      if(employees_length > 1){
        $.Toast.showToast({

        // toast message

        "title": "Calculating all employees payroll...",

        // "success", "none", "error"

        "icon": "loading",

        "duration": '100000000'

        });
      } else {
        $.Toast.showToast({

        // toast message

        "title": "There are no employees ready for payslip yet",

        // "success", "none", "error"

        "icon": "error",


        });
      }
      
      for (let i = 0; i < employees_length-1; i++) {
          setTimeout(function () {

            if($(employees[i]).val() != ''){
              empl_id = $(employees[i]).val();

              console.log(empl_id);

              //console.log(empl);
              $('#select_employee').val(empl_id); 

              var integ_cutoff_period = $('#integrated_cutoff_period').val();

              integrate_cutoff_refresh(integ_cutoff_period, empl_id);

              setTimeout(() => {
                // CALCULATE UPON CHANGE
                getEmployeeData(url_empl,empl_id).then(data => {
                  

                  data.employee_data.forEach((x) => {

                    // EMPL INFO
                    var fullname = x.col_frst_name + ' ' + x.col_last_name;

                    // ALLOWANCE
                    var pioneer_allowance = '';
                    var skill_allowance = '';
                    var load_allowance = '';
                    var transpo_allowance = '';
                    var group_leader_allowance = '';
                    var daily_allowance = '';

                    if(x.pioneer_allowance == ''){ pioneer_allowance = 0; } else { pioneer_allowance = parseFloat(x.pioneer_allowance)/2; }
                    if(x.skill_allowance == ''){ skill_allowance = 0; } else { skill_allowance = parseFloat(x.skill_allowance)/2; }
                    if(x.load_allowance == ''){ load_allowance = 0; } else { load_allowance = parseFloat(x.load_allowance)/2; }
                    if(x.transpo_allowance == ''){ transpo_allowance = 0; } else { transpo_allowance = parseFloat(x.transpo_allowance)/2; }                

                    // DEDUCTIONS
                    var uniform_deduction = '';
                    var salary_advance = '';

                    if(x.uniform_deduction == ''){ uniform_deduction = 0; } else { uniform_deduction = x.uniform_deduction; }
                    if(x.salary_advance == ''){ salary_advance = 0; } else { salary_advance = x.salary_advance; }

                    $('#employee_name').text(fullname);
                    $('#salary_rate').val(x.salary_rate);
                    $('#salary_type').val(x.salary_type);

                    // DISPLAY ALLOWANCES 
                    $('#TAX_LOAD').val(parseFloat(load_allowance).toFixed(2));
                    $('#TAX_TRANS').val(parseFloat(transpo_allowance).toFixed(2));
                    $('#TAX_SKILL').val(parseFloat(skill_allowance).toFixed(2));
                    $('#TAX_PIONEER').val(parseFloat(pioneer_allowance).toFixed(2));

                    // DISPLAY DEDUCTIONS 
                    $('#DED_salary_advances').val(parseFloat(uniform_deduction).toFixed(2));
                    $('#DED_uniform_deduction').val(parseFloat(salary_advance).toFixed(2));
                    
                    setTimeout(() => {
                      
                      // update_calc();
                      display_loans();
                      track_attendance();
                      computeTI();
                      setTimeout(() => {
                          if(x.group_leader_allowance == ''){ group_leader_allowance = 0; } else { group_leader_allowance = parseFloat(x.group_leader_allowance)*work_days; }
                          if(x.daily_allowance == ''){ daily_allowance = 0; } else { daily_allowance = parseFloat(x.daily_allowance)*work_days; }
                          $('#TAX_GROUP_LEADER').val(parseFloat(group_leader_allowance).toFixed(2));
                          $('#TAX_DAILY').val(parseFloat(daily_allowance).toFixed(2));
                          contribution_calc();
                          isReadyForCalculation = true;

                          // setTimeout(() => {
                          //   isReadyForPayslipGeneration = true;
                          // }, 500 * interval);
                      }, 500);

                    }, 500);
                    
                  })
                })
              }, 400);
              
              
              
              setInterval(() => {
                if($('.toast-content p').length > 0){
                  $('.toast-content p').text(generated_empl_payslip + ' out of ' + employees_length + ' employees calculated');
                }
              }, 100);
              
              generated_empl_payslip = generated_empl_payslip + 1;

              if(generated_empl_payslip == employees_length){
                $.Toast.hideToast();
              }
              
            }

          }, i * interval);

      }

    })


    
    setInterval(() => {
      
        if(isReadyForCalculation){
          if($('#select_employee').val() != ''){
            update_calc_manual();

            save_to_db();
            
            // if(isReadyForPayslipGeneration){
              
            // }
            
            setTimeout(() => {
              var empl_id = $('input.empl_id').val();
              // var empl_id = $('#select_employee').val();
              var empl_name = $('input.empl_name').val();
              var salary_rate = $('input.salary_rate').val();
              var work_rate = $('input.work_rate').val();
              var daily_salary = $('input.daily_salary').val();
              var hourly_salary = $('input.hourly_salary').val();
              var payroll_period = $('input.payroll_period').val();
              var working_days = $('input.working_days').val();
              var hours_of_work = $('input.hours_of_work').val();
              var ti_basic_sal_mul = $('input.ti_basic_sal_mul').val();
              var ti_absent_mul = $('input.ti_absent_mul').val();
              var ti_no_ti_to_mul = $('input.ti_no_ti_to_mul').val();
              var ti_tard_mul = $('input.ti_tard_mul').val();
              var ti_half_mul = $('input.ti_half_mul').val();
              var ti_undertime_mul = $('input.ti_undertime_mul').val();
              var ti_rest_mul = $('input.ti_rest_mul').val();
              var ti_rest_sp_hol_mul = $('input.ti_rest_sp_hol_mul').val();
              var ti_legal_hol_mul = $('input.ti_legal_hol_mul').val();
              var ti_rest_legal_hol_mul = $('input.ti_rest_legal_hol_mul').val();
              var ti_reg_ot_mul = $('input.ti_reg_ot_mul').val();
              var ti_nd_ot_mul = $('input.ti_nd_ot_mul').val();
              var ti_nd_mul = $('input.ti_nd_mul').val();
              var ti_leave_mul = $('input.ti_leave_mul').val();
              var ti_de_minimis_mul = $('input.ti_de_minimis_mul').val();
              var ti_rest_ot_mul = $('input.ti_rest_ot_mul').val();
              var ti_rest_nd_ot_mul = $('input.ti_rest_nd_ot_mul').val();
              var ti_basic_sal_total = $('input.ti_basic_sal_total').val();
              var ti_absent_total = $('input.ti_absent_total').val();
              var ti_no_ti_to_total = $('input.ti_no_ti_to_total').val();
              var ti_tard_total = $('input.ti_tard_total').val();
              var ti_half_total = $('input.ti_half_total').val();
              var ti_undertime_total = $('input.ti_undertime_total').val();
              var ti_rest_total = $('input.ti_rest_total').val();
              var ti_rest_sp_hol_total = $('input.ti_rest_sp_hol_total').val();
              var ti_legal_hol_total = $('input.ti_legal_hol_total').val();
              var ti_rest_legal_hol_total = $('input.ti_rest_legal_hol_total').val();
              var ti_reg_ot_total = $('input.ti_reg_ot_total').val();
              var ti_nd_ot_total = $('input.ti_nd_ot_total').val();
              var ti_nd_total = $('input.ti_nd_total').val();
              var ti_leave_total = $('input.ti_leave_total').val();
              var ti_de_minimis_total = $('input.ti_de_minimis_total').val();
              var ti_rest_ot_total = $('input.ti_rest_ot_total').val();
              var ti_rest_nd_ot_total = $('input.ti_rest_nd_ot_total').val();
              var ti_sil_2020 = $('input.ti_sil_2020').val();
              var ti_meal = $('input.ti_meal').val();
              var ti_gov_cont = $('input.ti_gov_cont').val();
              var ti_others = $('input.ti_others').val();
              var ti_gross = $('input.ti_gross').val();
              var gov_sss_ee = $('input.gov_sss_ee').val();
              var gov_philhealth_ee = $('input.gov_philhealth_ee').val();
              var gov_pagibig_ee = $('input.gov_pagibig_ee').val();
              var gov_total_ee = $('input.gov_total_ee').val();
              var comp_cont_sss = $('input.comp_cont_sss').val();
              var comp_cont_sss_ec = $('input.comp_cont_sss_ec').val();
              var comp_cont_philhealth = $('input.comp_cont_philhealth').val();
              var comp_cont_pagibig = $('input.comp_cont_pagibig').val();
              var comp_cont_total = $('input.comp_cont_total').val();
              var ta_load = $('input.ta_load').val();
              var ta_transportation = $('input.ta_transportation').val();
              var ta_skill = $('input.ta_skill').val();
              var ta_pioneer = $('input.ta_pioneer').val();
              var ta_group_leader = $('input.ta_group_leader').val();
              var ta_daily_allowance = $('input.ta_daily_allowance').val();
              var ta_allowance = $('input.ta_allowance').val();
              var ta_total = $('input.ta_total').val();
              var wtax = $('input.wtax').val();
              var loan_sss_salary = $('input.loan_sss_salary').val();
              var loan_sss_calamity = $('input.loan_sss_calamity').val();
              var loan_pagibig_salary = $('input.loan_pagibig_salary').val();
              var loan_pagibig_calamity = $('input.loan_pagibig_calamity').val();
              var loan_emergency = $('input.loan_emergency').val();
              var loan_total = $('input.loan_total').val();
              var tax_refund = $('input.tax_refund').val();
              var salary_advance = $('input.salary_advance').val();
              var uniform_deduction = $('input.uniform_deduction').val();
              var ded_total = $('input.ded_total').val();
              var net_pay = $('input.net_pay').val();
              var cutoff_period = $('input.cutoff_period').val();
              var empl_cmid = $('input.empl_cmid').val();
              var salary_type = $('input.salary_type').val();


              console.log('For: '+ empl_cmid + ' - ' + empl_name);
              console.log('loan_sss_salary: ' + loan_sss_salary);
              console.log('loan_sss_calamity: ' + loan_sss_calamity);
              console.log('loan_pagibig_salary: ' + loan_pagibig_salary);
              console.log('loan_pagibig_calamity: ' + loan_pagibig_calamity);
              console.log('loan_emergency: ' + loan_emergency);
              console.log('loan_total: ' + loan_total);
              console.log('Net Pay: ' + net_pay);
              


              generate_payslip(url_generate_payslip, empl_id, empl_name, salary_rate, work_rate, daily_salary, hourly_salary, payroll_period, working_days, hours_of_work, ti_basic_sal_mul, ti_absent_mul, ti_no_ti_to_mul, ti_tard_mul, ti_half_mul, ti_undertime_mul, ti_rest_mul, ti_rest_sp_hol_mul, ti_legal_hol_mul, ti_rest_legal_hol_mul, ti_reg_ot_mul, ti_nd_ot_mul, ti_nd_mul, ti_leave_mul, ti_de_minimis_mul, ti_rest_ot_mul, ti_rest_nd_ot_mul, ti_basic_sal_total, ti_absent_total, ti_no_ti_to_total, ti_tard_total, ti_half_total, ti_undertime_total, ti_rest_total, ti_rest_sp_hol_total, ti_legal_hol_total, ti_rest_legal_hol_total, ti_reg_ot_total, ti_nd_ot_total, ti_nd_total, ti_leave_total, ti_de_minimis_total, ti_rest_ot_total, ti_rest_nd_ot_total, ti_sil_2020, ti_meal, ti_gov_cont, ti_others, ti_gross, gov_sss_ee, gov_philhealth_ee, gov_pagibig_ee, gov_total_ee, comp_cont_sss, comp_cont_sss_ec, comp_cont_philhealth, comp_cont_pagibig, comp_cont_total, ta_load, ta_transportation, ta_skill, ta_pioneer, ta_group_leader, ta_daily_allowance, ta_allowance, ta_total, wtax, loan_sss_salary, loan_sss_calamity, loan_pagibig_salary, loan_pagibig_calamity, loan_emergency, loan_total, tax_refund, salary_advance, uniform_deduction, ded_total, net_pay, cutoff_period, empl_cmid, salary_type).then(function(data){
                console.log('loan_sss_salary: ' + data);
              })

              
              isReadyForCalculation = false;
              
            }, 1000);
            
            
            
          }
        }
      
    }, 1000);







      // ======================================= ASYNC REQUESTS =================================

      async function get_previous_cutoff(url,empl_id , previous_cutoff_period){
        var formData = new FormData();
        formData.append('empl_id', empl_id);
        formData.append('previous_cutoff_period', previous_cutoff_period);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }

      async function get_loan_payable_data(url, empl_cmid, cutoff_period){
        var formData = new FormData();
        formData.append('empl_cmid', empl_cmid);
        formData.append('cutoff_period', cutoff_period);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }

      async function getSalaryWitholdingTax(url,salary) {
        var formData = new FormData();
        formData.append('salary_id', salary);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }

      async function getSssTax(url,salary) {
        var formData = new FormData();
        formData.append('salary_id', salary);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }
      
      async function getEmployeeData(url,id) {
        var formData = new FormData();
        formData.append('employee_id', id);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }
      
      async function get_attendance_count(url,empl_id,cutoff_period) {
        var formData = new FormData();
        formData.append('employee_id', empl_id);
        formData.append('cutoff_period', cutoff_period);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }
      
      async function get_approved_employee_attendance_data(url, cutoff_period){
        var formData = new FormData();
        formData.append('cutoff_period', cutoff_period);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }



      async function get_employee_all_ampl_data(url,empl_id){
          var formData = new FormData();
          formData.append('empl_cmid', empl_id);
          const response = await fetch(url, {
          method: 'POST',
          body: formData
          });
          return response.json();
      }



      async function generate_payslip(url, empl_id, empl_name, salary_rate, work_rate, daily_salary, hourly_salary, payroll_period, working_days, hours_of_work, ti_basic_sal_mul, ti_absent_mul, ti_no_ti_to_mul, ti_tard_mul, ti_half_mul, ti_undertime_mul, ti_rest_mul, ti_rest_sp_hol_mul, ti_legal_hol_mul, ti_rest_legal_hol_mul, ti_reg_ot_mul, ti_nd_ot_mul, ti_nd_mul, ti_leave_mul, ti_de_minimis_mul, ti_rest_ot_mul, ti_rest_nd_ot_mul, ti_basic_sal_total, ti_absent_total, ti_no_ti_to_total, ti_tard_total, ti_half_total, ti_undertime_total, ti_rest_total, ti_rest_sp_hol_total, ti_legal_hol_total, ti_rest_legal_hol_total, ti_reg_ot_total, ti_nd_ot_total, ti_nd_total, ti_leave_total, ti_de_minimis_total, ti_rest_ot_total, ti_rest_nd_ot_total, ti_sil_2020, ti_meal, ti_gov_cont, ti_others, ti_gross, gov_sss_ee, gov_philhealth_ee, gov_pagibig_ee, gov_total_ee, comp_cont_sss, comp_cont_sss_ec, comp_cont_philhealth, comp_cont_pagibig, comp_cont_total, ta_load, ta_transportation, ta_skill, ta_pioneer, ta_group_leader, ta_daily_allowance, ta_allowance, ta_total, wtax, loan_sss_salary, loan_sss_calamity, loan_pagibig_salary, loan_pagibig_calamity, loan_emergency, loan_total, tax_refund, salary_advance, uniform_deduction, ded_total, net_pay, cutoff_period, empl_cmid, salary_type){
          var formData = new FormData();
          formData.append('empl_id', empl_id);
          formData.append('empl_name', empl_name);
          formData.append('salary_rate', salary_rate);
          formData.append('work_rate', work_rate);
          formData.append('daily_salary', daily_salary);
          formData.append('hourly_salary', hourly_salary);
          formData.append('payroll_period', payroll_period);
          formData.append('working_days', working_days);
          formData.append('hours_of_work', hours_of_work);
          formData.append('ti_basic_sal_mul', ti_basic_sal_mul);
          formData.append('ti_absent_mul', ti_absent_mul);
          formData.append('ti_no_ti_to_mul', ti_no_ti_to_mul);
          formData.append('ti_tard_mul', ti_tard_mul);
          formData.append('ti_half_mul', ti_half_mul);
          formData.append('ti_undertime_mul', ti_undertime_mul);
          formData.append('ti_rest_mul', ti_rest_mul);
          formData.append('ti_rest_sp_hol_mul', ti_rest_sp_hol_mul);
          formData.append('ti_legal_hol_mul', ti_legal_hol_mul);
          formData.append('ti_rest_legal_hol_mul', ti_rest_legal_hol_mul);
          formData.append('ti_reg_ot_mul', ti_reg_ot_mul);
          formData.append('ti_nd_ot_mul', ti_nd_ot_mul);
          formData.append('ti_nd_mul', ti_nd_mul);
          formData.append('ti_leave_mul', ti_leave_mul);
          formData.append('ti_de_minimis_mul', ti_de_minimis_mul);
          formData.append('ti_rest_ot_mul', ti_rest_ot_mul);
          formData.append('ti_rest_nd_ot_mul', ti_rest_nd_ot_mul);
          formData.append('ti_basic_sal_total', ti_basic_sal_total);
          formData.append('ti_absent_total', ti_absent_total);
          formData.append('ti_no_ti_to_total', ti_no_ti_to_total);
          formData.append('ti_tard_total', ti_tard_total);
          formData.append('ti_half_total', ti_half_total);
          formData.append('ti_undertime_total', ti_undertime_total);
          formData.append('ti_rest_total', ti_rest_total);
          formData.append('ti_rest_sp_hol_total', ti_rest_sp_hol_total);
          formData.append('ti_legal_hol_total', ti_legal_hol_total);
          formData.append('ti_rest_legal_hol_total', ti_rest_legal_hol_total);
          formData.append('ti_reg_ot_total', ti_reg_ot_total);
          formData.append('ti_nd_ot_total', ti_nd_ot_total);
          formData.append('ti_nd_total', ti_nd_total);
          formData.append('ti_leave_total', ti_leave_total);
          formData.append('ti_de_minimis_total', ti_de_minimis_total);
          formData.append('ti_rest_ot_total', ti_rest_ot_total);
          formData.append('ti_rest_nd_ot_total', ti_rest_nd_ot_total);
          formData.append('ti_sil_2020', ti_sil_2020);
          formData.append('ti_meal', ti_meal);
          formData.append('ti_gov_cont', ti_gov_cont);
          formData.append('ti_others', ti_others);
          formData.append('ti_gross', ti_gross);
          formData.append('gov_sss_ee', gov_sss_ee);
          formData.append('gov_philhealth_ee', gov_philhealth_ee);
          formData.append('gov_pagibig_ee', gov_pagibig_ee);
          formData.append('gov_total_ee', gov_total_ee);
          formData.append('comp_cont_sss', comp_cont_sss);
          formData.append('comp_cont_sss_ec', comp_cont_sss_ec);
          formData.append('comp_cont_philhealth', comp_cont_philhealth);
          formData.append('comp_cont_pagibig', comp_cont_pagibig);
          formData.append('comp_cont_total', comp_cont_total);
          formData.append('ta_load', ta_load);
          formData.append('ta_transportation', ta_transportation);
          formData.append('ta_skill', ta_skill);
          formData.append('ta_pioneer', ta_pioneer);
          formData.append('ta_group_leader', ta_group_leader);
          formData.append('ta_daily_allowance', ta_daily_allowance);
          formData.append('ta_allowance', ta_allowance);
          formData.append('ta_total', ta_total);
          formData.append('wtax', wtax);
          formData.append('loan_sss_salary', loan_sss_salary);
          formData.append('loan_sss_calamity', loan_sss_calamity);
          formData.append('loan_pagibig_salary', loan_pagibig_salary);
          formData.append('loan_pagibig_calamity', loan_pagibig_calamity);
          formData.append('loan_emergency', loan_emergency);
          formData.append('loan_total', loan_total);
          formData.append('tax_refund', tax_refund);
          formData.append('salary_advance', salary_advance);
          formData.append('uniform_deduction', uniform_deduction);
          formData.append('ded_total', ded_total);
          formData.append('net_pay', net_pay);
          formData.append('cutoff_period', cutoff_period);
          formData.append('empl_cmid', empl_cmid);
          formData.append('salary_type', salary_type);

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