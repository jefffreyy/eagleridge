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
<!-- Include Editor style. -->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_style.min.css" rel="stylesheet" type="text/css" />
<!-- Facebox -->
<link href="<?=base_url()?>facebox/facefiles/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<?php
    $id = '';
    $empl_id = '';
    $empl_name = '';
    $monthly_salary = '';
    $work_rate = '';
    $daily_salary = '';
    $hourly_salary = '';
    $payroll_period = '';
    $working_days = '';
    $hours_of_work = '';

    $reg_mul = '';
    $rest_mul = '';
    $sp_hol_mul = '';
    $sp_hol_rest_mul = '';
    $reg_hol_mul = '';
    $reg_hol_rest_mul = '';
    $dbl_hol_mul = '';
    $dbl_hol_rest_mul = '';
    $reg_ns_mul = '';
    $rest_ns_mul = '';
    $sp_hol_ns_mul = '';
    $sp_hol_rest_ns_mul = '';
    $reg_hol_ns_mul = '';
    $reg_hol_rest_ns_mul = '';
    $dbl_hol_ns_mul = '';
    $dbl_hol_rest_ns_mul = '';
    $total_bp = '';

    $reg_ot_mul = '';
    $rest_ot_mul = '';
    $sp_hol_ot_mul = '';
    $sp_hol_rest_ot_mul = '';
    $reg_hol_ot_mul = '';
    $reg_hol_rest_ot_mul = '';
    $dbl_hol_ot_mul = '';
    $dbl_hol_rest_ot_mul = '';
    $reg_ot_ns_mul = '';
    $rest_ot_ns_mul = '';
    $sp_hol_ot_ns_mul = '';
    $sp_hol_rest_ot_ns_mul = '';
    $reg_hol_ot_ns_mul = '';
    $reg_hol_rest_ot_ns_mul = '';
    $dbl_hol_ot_ns_mul = '';
    $dbl_hol_rest_ot_ns_mul = '';
    $total_ot = '';

    $oti_1_mul = '';
    $oti_2_mul = '';
    $oti_3_mul = '';
    $oti_4_mul = '';
    $oti_5_mul = '';
    $oti_6_mul = '';
    $oti_7_mul = '';
    $oti_8_mul = '';
    $total_oti = '';

    $abs_mul = '';
    $late_mul = '';
    $total_abs = '';

    $ti_total = '';

    $nti_1_mul = '';
    $nti_2_mul = '';
    $nti_3_mul = '';
    $nti_4_mul = '';
    $nti_5_mul = '';
    $nti_6_mul = '';
    $nti_7_mul = '';
    $nti_total = '';

    $gross_ti = '';
    $gov_wtax = '';
    $gov_sss = '';
    $gov_philhealth = '';
    $gov_pagibig = '';
    $gov_total = '';

    $loan_sss_salary = '';
    $loan_sss_calamity = '';
    $loan_hdmf_salary = '';
    $loan_hdmf_calamity = '';
    $loan_company = '';
    $loan_total = '';

    $ded_salary_adv = '';
    $ded_1_mul = '';
    $ded_2_mul = '';
    $ded_3_mul = '';
    $ded_4_mul = '';
    $ded_5_mul = '';
    $ded_total = '';

    $ovr_total_ti = '';
    $ovr_total_oti = '';
    $ovr_total_nti = '';
    $ovr_total_ded = '';
    $ovr_total_gov = '';
    $ovr_total_loan = '';
    $net_pay = '';

    $comp_cont_sss = '';
    $comp_cont_philhealth = '';
    $comp_cont_pagibig = '';

    if($DISP_PAYROLL_DATA){
        foreach($DISP_PAYROLL_DATA as $DISP_PAYROLL_DATA_ROW){
            $id =  $DISP_PAYROLL_DATA_ROW->id;
            $empl_id =  $DISP_PAYROLL_DATA_ROW->empl_id;
            $empl_name =  $DISP_PAYROLL_DATA_ROW->empl_name;
            $monthly_salary =  $DISP_PAYROLL_DATA_ROW->monthly_salary;
            $work_rate =  $DISP_PAYROLL_DATA_ROW->work_rate;
            $daily_salary =  $DISP_PAYROLL_DATA_ROW->daily_salary;
            $hourly_salary =  $DISP_PAYROLL_DATA_ROW->hourly_salary;
            $payroll_period =  $DISP_PAYROLL_DATA_ROW->payroll_period;
            $working_days =  $DISP_PAYROLL_DATA_ROW->working_days;
            $hours_of_work =  $DISP_PAYROLL_DATA_ROW->hours_of_work;

            $reg_mul =  $DISP_PAYROLL_DATA_ROW->reg_mul;
            $rest_mul =  $DISP_PAYROLL_DATA_ROW->rest_mul;
            $sp_hol_mul =  $DISP_PAYROLL_DATA_ROW->sp_hol_mul;
            $sp_hol_rest_mul =  $DISP_PAYROLL_DATA_ROW->sp_hol_rest_mul;
            $reg_hol_mul =  $DISP_PAYROLL_DATA_ROW->reg_hol_mul;
            $reg_hol_rest_mul =  $DISP_PAYROLL_DATA_ROW->reg_hol_rest_mul;
            $dbl_hol_mul =  $DISP_PAYROLL_DATA_ROW->dbl_hol_mul;
            $dbl_hol_rest_mul =  $DISP_PAYROLL_DATA_ROW->dbl_hol_rest_mul;
            $reg_ns_mul =  $DISP_PAYROLL_DATA_ROW->reg_ns_mul;
            $rest_ns_mul =  $DISP_PAYROLL_DATA_ROW->rest_ns_mul;
            $sp_hol_ns_mul =  $DISP_PAYROLL_DATA_ROW->sp_hol_ns_mul;
            $sp_hol_rest_ns_mul =  $DISP_PAYROLL_DATA_ROW->sp_hol_rest_ns_mul;
            $reg_hol_ns_mul =  $DISP_PAYROLL_DATA_ROW->reg_hol_ns_mul;
            $reg_hol_rest_ns_mul =  $DISP_PAYROLL_DATA_ROW->reg_hol_rest_ns_mul;
            $dbl_hol_ns_mul =  $DISP_PAYROLL_DATA_ROW->dbl_hol_ns_mul;
            $dbl_hol_rest_ns_mul =  $DISP_PAYROLL_DATA_ROW->dbl_hol_rest_ns_mul;
            $total_bp =  $DISP_PAYROLL_DATA_ROW->total_bp;

            $reg_ot_mul =  $DISP_PAYROLL_DATA_ROW->reg_ot_mul;
            $rest_ot_mul =  $DISP_PAYROLL_DATA_ROW->rest_ot_mul;
            $sp_hol_ot_mul =  $DISP_PAYROLL_DATA_ROW->sp_hol_ot_mul;
            $sp_hol_rest_ot_mul =  $DISP_PAYROLL_DATA_ROW->sp_hol_rest_ot_mul;
            $reg_hol_ot_mul =  $DISP_PAYROLL_DATA_ROW->reg_hol_ot_mul;
            $reg_hol_rest_ot_mul =  $DISP_PAYROLL_DATA_ROW->reg_hol_rest_ot_mul;
            $dbl_hol_ot_mul =  $DISP_PAYROLL_DATA_ROW->dbl_hol_ot_mul;
            $dbl_hol_rest_ot_mul =  $DISP_PAYROLL_DATA_ROW->dbl_hol_rest_ot_mul;
            $reg_ot_ns_mul =  $DISP_PAYROLL_DATA_ROW->reg_ot_ns_mul;
            $rest_ot_ns_mul =  $DISP_PAYROLL_DATA_ROW->rest_ot_ns_mul;
            $sp_hol_ot_ns_mul =  $DISP_PAYROLL_DATA_ROW->sp_hol_ot_ns_mul;
            $sp_hol_rest_ot_ns_mul =  $DISP_PAYROLL_DATA_ROW->sp_hol_rest_ot_ns_mul;
            $reg_hol_ot_ns_mul =  $DISP_PAYROLL_DATA_ROW->reg_hol_ot_ns_mul;
            $reg_hol_rest_ot_ns_mul =  $DISP_PAYROLL_DATA_ROW->reg_hol_rest_ot_ns_mul;
            $dbl_hol_ot_ns_mul =  $DISP_PAYROLL_DATA_ROW->dbl_hol_ot_ns_mul;
            $dbl_hol_rest_ot_ns_mul =  $DISP_PAYROLL_DATA_ROW->dbl_hol_rest_ot_ns_mul;
            $total_ot =  $DISP_PAYROLL_DATA_ROW->total_ot;

            $oti_1_mul =  $DISP_PAYROLL_DATA_ROW->oti_1_mul;
            $oti_2_mul =  $DISP_PAYROLL_DATA_ROW->oti_2_mul;
            $oti_3_mul =  $DISP_PAYROLL_DATA_ROW->oti_3_mul;
            $oti_4_mul =  $DISP_PAYROLL_DATA_ROW->oti_4_mul;
            $oti_5_mul =  $DISP_PAYROLL_DATA_ROW->oti_5_mul;
            $oti_6_mul =  $DISP_PAYROLL_DATA_ROW->oti_6_mul;
            $oti_7_mul =  $DISP_PAYROLL_DATA_ROW->oti_7_mul;
            $oti_8_mul =  $DISP_PAYROLL_DATA_ROW->oti_8_mul;
            $total_oti =  $DISP_PAYROLL_DATA_ROW->total_oti;

            $abs_mul =  $DISP_PAYROLL_DATA_ROW->abs_mul;
            $late_mul =  $DISP_PAYROLL_DATA_ROW->late_mul;
            $total_abs =  $DISP_PAYROLL_DATA_ROW->total_abs;

            $ti_total =  $DISP_PAYROLL_DATA_ROW->ti_total;

            $nti_1_mul =  $DISP_PAYROLL_DATA_ROW->nti_1_mul;
            $nti_2_mul =  $DISP_PAYROLL_DATA_ROW->nti_2_mul;
            $nti_3_mul =  $DISP_PAYROLL_DATA_ROW->nti_3_mul;
            $nti_4_mul =  $DISP_PAYROLL_DATA_ROW->nti_4_mul;
            $nti_5_mul =  $DISP_PAYROLL_DATA_ROW->nti_5_mul;
            $nti_6_mul =  $DISP_PAYROLL_DATA_ROW->nti_6_mul;
            $nti_7_mul =  $DISP_PAYROLL_DATA_ROW->nti_7_mul;
            $nti_total =  $DISP_PAYROLL_DATA_ROW->nti_total;

            $gross_ti =  $DISP_PAYROLL_DATA_ROW->gross_ti;
            $gov_wtax =  $DISP_PAYROLL_DATA_ROW->gov_wtax;
            $gov_sss =  $DISP_PAYROLL_DATA_ROW->gov_sss;
            $gov_philhealth =  $DISP_PAYROLL_DATA_ROW->gov_philhealth;
            $gov_pagibig =  $DISP_PAYROLL_DATA_ROW->gov_pagibig;
            $gov_total =  $DISP_PAYROLL_DATA_ROW->gov_total;

            $loan_sss_salary =  $DISP_PAYROLL_DATA_ROW->loan_sss_salary;
            $loan_sss_calamity =  $DISP_PAYROLL_DATA_ROW->loan_sss_calamity;
            $loan_hdmf_salary =  $DISP_PAYROLL_DATA_ROW->loan_hdmf_salary;
            $loan_hdmf_calamity =  $DISP_PAYROLL_DATA_ROW->loan_hdmf_calamity;
            $loan_company =  $DISP_PAYROLL_DATA_ROW->loan_company;
            $loan_total =  $DISP_PAYROLL_DATA_ROW->loan_total;
            $ded_salary_adv =  $DISP_PAYROLL_DATA_ROW->ded_salary_adv;
            $ded_1_mul =  $DISP_PAYROLL_DATA_ROW->ded_1_mul;
            $ded_2_mul =  $DISP_PAYROLL_DATA_ROW->ded_2_mul;
            $ded_3_mul =  $DISP_PAYROLL_DATA_ROW->ded_3_mul;
            $ded_4_mul =  $DISP_PAYROLL_DATA_ROW->ded_4_mul;
            $ded_5_mul =  $DISP_PAYROLL_DATA_ROW->ded_5_mul;
            $ded_total =  $DISP_PAYROLL_DATA_ROW->ded_total;

            $ovr_total_ti =  $DISP_PAYROLL_DATA_ROW->ovr_total_ti;
            $ovr_total_oti =  $DISP_PAYROLL_DATA_ROW->ovr_total_oti;
            $ovr_total_nti =  $DISP_PAYROLL_DATA_ROW->ovr_total_nti;
            $ovr_total_ded =  $DISP_PAYROLL_DATA_ROW->ovr_total_ded;
            $ovr_total_gov =  $DISP_PAYROLL_DATA_ROW->ovr_total_gov;
            $ovr_total_loan =  $DISP_PAYROLL_DATA_ROW->ovr_total_loan;
            $net_pay =  $DISP_PAYROLL_DATA_ROW->net_pay;

            $comp_cont_sss =  $DISP_PAYROLL_DATA_ROW->comp_cont_sss;
            $comp_cont_philhealth =  $DISP_PAYROLL_DATA_ROW->comp_cont_philhealth;
            $comp_cont_pagibig =  $DISP_PAYROLL_DATA_ROW->comp_cont_pagibig;
        }
    }
?>
<div class="content-wrapper" style="height: 100vh !important;">
    <div class="p-3">
        <div class="flex-fill">
          <!-- form -->
          <form action="<?php echo base_url('payroll/updt_payroll_data'); ?>" id="form_updt_payroll" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
              <input type="hidden" value="<?= $id ?>" name="payroll_id" class="payroll_id">
              <input type="hidden" value="0" name="empl_id" class="empl_id">
              <input type="hidden" value="0" name="empl_name" class="empl_name">
              <input type="hidden" value="0" name="monthly_salary" class="monthly_salary">
              <input type="hidden" value="0" name="work_rate" class="work_rate">
              <input type="hidden" value="0" name="daily_salary" class="daily_salary">
              <input type="hidden" value="0" name="hourly_salary" class="hourly_salary">
              <input type="hidden" value="0" name="payroll_period" class="payroll_period">
              <input type="hidden" value="0" name="working_days" class="working_days">
              <input type="hidden" value="0" name="hours_of_work" class="hours_of_work">
              <input type="hidden" value="0" name="reg_mul" class="reg_mul">
              <input type="hidden" value="0" name="rest_mul" class="rest_mul">
              <input type="hidden" value="0" name="sp_hol_mul" class="sp_hol_mul">
              <input type="hidden" value="0" name="sp_hol_rest_mul" class="sp_hol_rest_mul">
              <input type="hidden" value="0" name="reg_hol_mul" class="reg_hol_mul">
              <input type="hidden" value="0" name="reg_hol_rest_mul" class="reg_hol_rest_mul">
              <input type="hidden" value="0" name="dbl_hol_mul" class="dbl_hol_mul">
              <input type="hidden" value="0" name="dbl_hol_rest_mul" class="dbl_hol_rest_mul">
              <input type="hidden" value="0" name="reg_ns_mul" class="reg_ns_mul">
              <input type="hidden" value="0" name="rest_ns_mul" class="rest_ns_mul">
              <input type="hidden" value="0" name="sp_hol_ns_mul" class="sp_hol_ns_mul">
              <input type="hidden" value="0" name="sp_hol_rest_ns_mul" class="sp_hol_rest_ns_mul">
              <input type="hidden" value="0" name="reg_hol_ns_mul" class="reg_hol_ns_mul">
              <input type="hidden" value="0" name="reg_hol_rest_ns_mul" class="reg_hol_rest_ns_mul">
              <input type="hidden" value="0" name="dbl_hol_ns_mul" class="dbl_hol_ns_mul">
              <input type="hidden" value="0" name="dbl_hol_rest_ns_mul" class="dbl_hol_rest_ns_mul">
              <input type="hidden" value="0" name="total_bp" class="total_bp">
              <input type="hidden" value="0" name="reg_ot_mul" class="reg_ot_mul">
              <input type="hidden" value="0" name="rest_ot_mul" class="rest_ot_mul">
              <input type="hidden" value="0" name="sp_hol_ot_mul" class="sp_hol_ot_mul">
              <input type="hidden" value="0" name="sp_hol_rest_ot_mul" class="sp_hol_rest_ot_mul">
              <input type="hidden" value="0" name="reg_hol_ot_mul" class="reg_hol_ot_mul">
              <input type="hidden" value="0" name="reg_hol_rest_ot_mul" class="reg_hol_rest_ot_mul">
              <input type="hidden" value="0" name="dbl_hol_ot_mul" class="dbl_hol_ot_mul">
              <input type="hidden" value="0" name="dbl_hol_rest_ot_mul" class="dbl_hol_rest_ot_mul">
              <input type="hidden" value="0" name="reg_ot_ns_mul" class="reg_ot_ns_mul">
              <input type="hidden" value="0" name="rest_ot_ns_mul" class="rest_ot_ns_mul">
              <input type="hidden" value="0" name="sp_hol_ot_ns_mul" class="sp_hol_ot_ns_mul">
              <input type="hidden" value="0" name="sp_hol_rest_ot_ns_mul" class="sp_hol_rest_ot_ns_mul">
              <input type="hidden" value="0" name="reg_hol_ot_ns_mul" class="reg_hol_ot_ns_mul">
              <input type="hidden" value="0" name="reg_hol_rest_ot_ns_mul" class="reg_hol_rest_ot_ns_mul">
              <input type="hidden" value="0" name="dbl_hol_ot_ns_mul" class="dbl_hol_ot_ns_mul">
              <input type="hidden" value="0" name="dbl_hol_rest_ot_ns_mul" class="dbl_hol_rest_ot_ns_mul">
              <input type="hidden" value="0" name="total_ot" class="total_ot">
              <input type="hidden" value="0" name="oti_1_mul" class="oti_1_mul">
              <input type="hidden" value="0" name="oti_2_mul" class="oti_2_mul">
              <input type="hidden" value="0" name="oti_3_mul" class="oti_3_mul">
              <input type="hidden" value="0" name="oti_4_mul" class="oti_4_mul">
              <input type="hidden" value="0" name="oti_5_mul" class="oti_5_mul">
              <input type="hidden" value="0" name="oti_6_mul" class="oti_6_mul">
              <input type="hidden" value="0" name="oti_7_mul" class="oti_7_mul">
              <input type="hidden" value="0" name="oti_8_mul" class="oti_8_mul">
              <input type="hidden" value="0" name="total_oti" class="total_oti">
              <input type="hidden" value="0" name="abs_mul" class="abs_mul">
              <input type="hidden" value="0" name="late_mul" class="late_mul">
              <input type="hidden" value="0" name="total_abs" class="total_abs">
              <input type="hidden" value="0" name="ti_total" class="ti_total">
              <input type="hidden" value="0" name="nti_1_mul" class="nti_1_mul">
              <input type="hidden" value="0" name="nti_2_mul" class="nti_2_mul">
              <input type="hidden" value="0" name="nti_3_mul" class="nti_3_mul">
              <input type="hidden" value="0" name="nti_4_mul" class="nti_4_mul">
              <input type="hidden" value="0" name="nti_5_mul" class="nti_5_mul">
              <input type="hidden" value="0" name="nti_6_mul" class="nti_6_mul">
              <input type="hidden" value="0" name="nti_7_mul" class="nti_7_mul">
              <input type="hidden" value="0" name="nti_total" class="nti_total">
              <input type="hidden" value="0" name="gross_ti" class="gross_ti">
              <input type="hidden" value="0" name="gov_wtax" class="gov_wtax">
              <input type="hidden" value="0" name="gov_sss" class="gov_sss">
              <input type="hidden" value="0" name="gov_philhealth" class="gov_philhealth">
              <input type="hidden" value="0" name="gov_pagibig" class="gov_pagibig">
              <input type="hidden" value="0" name="gov_total" class="gov_total">
              <input type="hidden" value="0" name="loan_sss_salary" class="loan_sss_salary">
              <input type="hidden" value="0" name="loan_sss_calamity" class="loan_sss_calamity">
              <input type="hidden" value="0" name="loan_hdmf_salary" class="loan_hdmf_salary">
              <input type="hidden" value="0" name="loan_hdmf_calamity" class="loan_hdmf_calamity">
              <input type="hidden" value="0" name="loan_company" class="loan_company">
              <input type="hidden" value="0" name="loan_total" class="loan_total">
              <input type="hidden" value="0" name="ded_salary_adv" class="ded_salary_adv">
              <input type="hidden" value="0" name="ded_1_mul" class="ded_1_mul">
              <input type="hidden" value="0" name="ded_2_mul" class="ded_2_mul">
              <input type="hidden" value="0" name="ded_3_mul" class="ded_3_mul">
              <input type="hidden" value="0" name="ded_4_mul" class="ded_4_mul">
              <input type="hidden" value="0" name="ded_5_mul" class="ded_5_mul">
              <input type="hidden" value="0" name="ded_total" class="ded_total">
              <input type="hidden" value="0" name="ovr_total_ti" class="ovr_total_ti">
              <input type="hidden" value="0" name="ovr_total_oti" class="ovr_total_oti">
              <input type="hidden" value="0" name="ovr_total_nti" class="ovr_total_nti">
              <input type="hidden" value="0" name="ovr_total_ded" class="ovr_total_ded">
              <input type="hidden" value="0" name="ovr_total_gov" class="ovr_total_gov">
              <input type="hidden" value="0" name="ovr_total_loan" class="ovr_total_loan">
              <input type="hidden" value="0" name="net_pay" class="net_pay">
              <input type="hidden" value="0" name="comp_cont_sss" class="comp_cont_sss">
              <input type="hidden" value="0" name="comp_cont_philhealth" class="comp_cont_philhealth">
              <input type="hidden" value="0" name="comp_cont_pagibig" class="comp_cont_pagibig">
            
              <div class="row pr-3 mb-2">
                  <div class="col-3">
                      <h1 class="page-title">Payslip Calculator
                      </h1>
                  </div>
                  <div class="col-9 pt-1">
                    <a href="#" class="btn btn-primary float-right" id="btn_update_payroll_data"><i class="fas fa-edit"></i>&nbsp;&nbsp;&nbsp; Adjust Payslip Data </a>
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
                                        <select class="form-control mb-2" name="select_employee" id="select_employee" disabled>
                                          <?php
                                              $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($empl_id);
                                          ?>
                                          <option value="<?= $empl_id ?>"><?= $employee[0]->col_empl_cmid ?></option>
                                          <?php 
                                            if($DISP_ALL_EMPLOYEES){
                                              foreach($DISP_ALL_EMPLOYEES as $DISP_ALL_EMPLOYEES_ROW){
                                              ?>
                                                <option value="<?= $DISP_ALL_EMPLOYEES_ROW->id ?>"> <?= $DISP_ALL_EMPLOYEES_ROW->col_empl_cmid ?></option>
                                              <?php
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
                                        <p id="employee_name"><?= $empl_name ?></p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12 d-flex">
                                      <div style="width: 150px;">
                                        <p class="text-bold mb-2 pt-2">Monthly Salary: </p>
                                      </div>
                                      <div class="flex-fill" style="width: auto;">
                                        <input type="text" name="monthly_salary" value="<?= $monthly_salary ?>" id="monthly_salary" placeholder="Enter Monthly Salary" class="form-control ml-0" required>
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
                                          <option value="divide_by_30" <?php if($work_rate == 'divide_by_30'){ echo 'selected';} ?>>Divide by 30</option>
                                          <option value="divide_by_26" <?php if($work_rate == 'divide_by_26'){ echo 'selected';} ?>>Divide by 26</option>
                                          <option value="divide_by_24" <?php if($work_rate == 'divide_by_24'){ echo 'selected';} ?>>Divide by 24</option>
                                          <option value="divide_by_22" <?php if($work_rate == 'divide_by_22'){ echo 'selected';} ?>>Divide by 22</option>
                                          <option value="divide_by_20" <?php if($work_rate == 'divide_by_20'){ echo 'selected';} ?>>Divide by 20</option>
                                          <option value="313_days" <?php if($work_rate == '313_days'){ echo 'selected';} ?>>313 Days</option>
                                          <option value="261_days" <?php if($work_rate == '261_days'){ echo 'selected';} ?>>261 Days</option>
                                          <option value="custom" <?php if($work_rate == 'custom'){ echo 'selected';} ?>>Custom</option>
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
                                        <p id="daily_salary"><?= $daily_salary ?></p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12 d-flex">
                                      <div style="width: 150px;">
                                        <p class="text-bold">Hourly Salary: </p>
                                      </div>
                                      <div class="flex-fill" style="width: auto;">
                                        <p id="hourly_salary"><?= $hourly_salary ?></p>
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
                                            $payroll_period_arr = $this->p175_payschedule_mod->MOD_GET_PAY_SCHED_DATA($payroll_period);
                                            ?>
                                            <option value="<?= $payroll_period ?>"><?= $payroll_period_arr[0]->name ?></option>
                                            <?php
                                              if($DISP_PAYROLL_SCHED){
                                                foreach($DISP_PAYROLL_SCHED as $DISP_PAYROLL_SCHED_ROW){
                                                ?>
                                                  <option value="<?= $DISP_PAYROLL_SCHED_ROW->id ?>"><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                                                <?php
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
                                        <p class="text-bold mb-2 pt-2">Working Days: </p>
                                      </div>
                                      <div class="flex-fill" style="width: auto;">
                                        <input type="text" name="working_days" id="working_days" value="<?= $working_days ?>" placeholder="# of Working Days" class="form-control ml-0" required>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mt-2">
                                    <div class="col-12 d-flex">
                                      <div style="width: 150px;">
                                        <p class="text-bold mb-2 pt-2">Hours of Work: </p>
                                      </div>
                                      <div class="flex-fill" style="width: auto;">
                                        <input type="text" name="work_hours" id="work_hours" value="<?= $hours_of_work ?>" placeholder="# of Work hours per day" value="8" class="form-control ml-0" required>
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
              <div class="col-4">
                <div class="card">
                  <div class="card-body" style="min-height: 830px;">
                      <p class="text-bold mb-2">Basic Pay</p>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Regular: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_reg" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $reg_mul ?>" style="width: 60px; font-size: 13px;" id="TI_reg_multiplier" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill BP_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_reg_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Rest Day: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_rest" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $rest_mul ?>" style="width: 60px; font-size: 13px;" id="TI_rest_multiplier" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill BP_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_rest_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Special Hol: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_spec_hol" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $sp_hol_mul ?>" style="width: 60px; font-size: 13px;" id="TI_spec_hol_multiplier" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill BP_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_spec_hol_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Special Hol + Rest: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_spec_hol_rest" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $sp_hol_rest_mul ?>" style="width: 60px; font-size: 13px;" id="TI_spec_hol_rest_multiplier" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill BP_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_spec_hol_rest_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Regular Hol: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_reg_hol" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $reg_hol_mul ?>" style="width: 60px; font-size: 13px;" id="TI_reg_hol_multiplier" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill BP_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_reg_hol_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Regular Hol + Rest: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_reg_hol_rest" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $reg_hol_rest_mul ?>" style="width: 60px; font-size: 13px;" id="TI_reg_hol_rest_multiplier" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill BP_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_reg_hol_rest_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Double Hol: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_double_hol" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $dbl_hol_mul ?>" style="width: 60px; font-size: 13px;" id="TI_double_hol_multiplier" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill BP_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_double_hol_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Double Hol + Rest: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_double_hol_rest" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $dbl_hol_rest_mul ?>" style="width: 60px; font-size: 13px;" id="TI_double_hol_rest_multiplier" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill BP_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_double_hol_rest_total" disabled>
                      </div>

                      <br>

                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Regular NS: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_regular_ns" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $reg_ns_mul ?>" style="width: 60px; font-size: 13px;" id="TI_regular_ns_multiplier" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill BP_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_regular_ns_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Rest Day NS: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_rest_ns" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $rest_ns_mul ?>" style="width: 60px; font-size: 13px;" id="TI_rest_ns_multiplier" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill BP_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_rest_ns_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Special Hol NS: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_spec_hol_ns" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $sp_hol_ns_mul ?>" style="width: 60px; font-size: 13px;" id="TI_spec_hol_ns_multiplier" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill BP_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_spec_hol_ns_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Special Hol + Rest NS: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_spec_hol_rest_ns" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $sp_hol_rest_ns_mul ?>" style="width: 60px; font-size: 13px;" id="TI_spec_hol_rest_ns_multiplier" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill BP_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_spec_hol_rest_ns_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Regular Hol NS: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_reg_hol_ns" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $reg_hol_ns_mul ?>" style="width: 60px; font-size: 13px;" id="TI_reg_hol_ns_multiplier" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill BP_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_reg_hol_ns_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Regular Hol + Rest NS: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_reg_hol_rest_ns" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $reg_hol_rest_ns_mul?>" style="width: 60px; font-size: 13px;" id="TI_reg_hol_rest_ns_multiplier" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill BP_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_reg_hol_rest_ns_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Double Hol NS: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_double_hol_ns" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $dbl_hol_ns_mul?>" style="width: 60px; font-size: 13px;" id="TI_double_hol_ns_multiplier" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill BP_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_double_hol_ns_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Double Hol + Rest NS: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_double_hol_rest_ns" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $dbl_hol_rest_ns_mul?>" style="width: 60px; font-size: 13px;" id="TI_double_hol_rest_ns_multiplier" disabled>
                          <input type="number" class="form-control ml-2 text-right flex-fill BP_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_double_hol_rest_ns_total" disabled>
                      </div>
                      <div class="d-flex ml-1" style="margin-top: 88px;">
                          <p class="text-right mb-3 mt-1 text-bold" style="font-size: 14px;width:250px;">Total Basic Pay: </p>
                          <input type="text" class="form-control ml-1 text-right flex-fill" value="<?= $total_bp?>" style="width: 190px;" id="total_basic_pay" disabled>
                      </div>
                  </div>
                  <!-- ./card-body -->
                </div>
                <!-- ./card -->
              </div>
              <!-- ./col-4 -->

              <div class="col-4">
                <div class="card">
                  <div class="card-body" style="min-height: 830px;">
                      <p class="text-bold mb-2">Overtime</p>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Regular OT: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_reg_ot" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $reg_ot_mul?>" style="width: 60px; font-size: 13px;" id="TI_reg_ot_multiplier">
                          <input type="number" class="form-control ml-2 text-right flex-fill OT_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_reg_ot_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Rest Day OT: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_rest_ot" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $rest_ot_mul?>" style="width: 60px; font-size: 13px;" id="TI_rest_ot_multiplier">
                          <input type="number" class="form-control ml-2 text-right flex-fill OT_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_rest_ot_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Special Hol OT: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_spec_hol_ot" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $sp_hol_ot_mul?>" style="width: 60px; font-size: 13px;" id="TI_spec_hol_ot_multiplier">
                          <input type="number" class="form-control ml-2 text-right flex-fill OT_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_spec_hol_ot_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Special Hol + Rest OT: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_spec_hol_rest_ot" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $sp_hol_rest_ot_mul?>" style="width: 60px; font-size: 13px;" id="TI_spec_hol_rest_ot_multiplier">
                          <input type="number" class="form-control ml-2 text-right flex-fill OT_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_spec_hol_rest_ot_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Regular Hol OT: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_reg_hol_ot" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $reg_hol_ot_mul?>" style="width: 60px; font-size: 13px;" id="TI_reg_hol_ot_multiplier">
                          <input type="number" class="form-control ml-2 text-right flex-fill OT_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_reg_hol_ot_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Regular Hol + Rest OT: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_reg_hol_rest_ot" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $reg_hol_rest_ot_mul?>" style="width: 60px; font-size: 13px;" id="TI_reg_hol_rest_ot_multiplier">
                          <input type="number" class="form-control ml-2 text-right flex-fill OT_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_reg_hol_rest_ot_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Double Hol OT: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_double_hol_ot" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $dbl_hol_ot_mul?>" style="width: 60px; font-size: 13px;" id="TI_double_hol_ot_multiplier">
                          <input type="number" class="form-control ml-2 text-right flex-fill OT_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_double_hol_ot_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Double Hol + Rest OT: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_double_hol_rest_ot" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $dbl_hol_rest_ot_mul?>" style="width: 60px; font-size: 13px;" id="TI_double_hol_rest_ot_multiplier">
                          <input type="number" class="form-control ml-2 text-right flex-fill OT_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_double_hol_rest_ot_total" disabled>
                      </div>

                      <br>

                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Regular OT NS: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_reg_ot_ns" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $reg_ot_ns_mul?>" style="width: 60px; font-size: 13px;" id="TI_reg_ot_ns_multiplier">
                          <input type="number" class="form-control ml-2 text-right flex-fill OT_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_reg_ot_ns_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Rest Day OT NS: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_rest_ot_ns" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $rest_ot_ns_mul?>" style="width: 60px; font-size: 13px;" id="TI_rest_ot_ns_multiplier">
                          <input type="number" class="form-control ml-2 text-right flex-fill OT_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_rest_ot_ns_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Special Hol OT NS: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_spec_hol_ot_ns" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $sp_hol_ot_ns_mul?>" style="width: 60px; font-size: 13px;" id="TI_spec_hol_ot_ns_multiplier">
                          <input type="number" class="form-control ml-2 text-right flex-fill OT_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_spec_hol_ot_ns_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Special Hol + Rest OT NS: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_spec_hol_rest_ot_ns" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $sp_hol_rest_ot_ns_mul?>" style="width: 60px; font-size: 13px;" id="TI_spec_hol_rest_ot_ns_multiplier">
                          <input type="number" class="form-control ml-2 text-right flex-fill OT_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_spec_hol_rest_ot_ns_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Regular Hol OT NS: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_reg_hol_ot_ns" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $reg_hol_ot_ns_mul?>" style="width: 60px; font-size: 13px;" id="TI_reg_hol_ot_ns_multiplier">
                          <input type="number" class="form-control ml-2 text-right flex-fill OT_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_reg_hol_ot_ns_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Regular Hol + Rest OT NS: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_reg_hol_rest_ot_ns" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $reg_hol_rest_ot_ns_mul?>" style="width: 60px; font-size: 13px;" id="TI_reg_hol_rest_ot_ns_multiplier">
                          <input type="number" class="form-control ml-2 text-right flex-fill OT_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_reg_hol_rest_ot_ns_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Double Hol OT NS: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_double_hol_ot_ns" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $dbl_hol_ot_ns_mul?>" style="width: 60px; font-size: 13px;" id="TI_double_hol_ot_ns_multiplier">
                          <input type="number" class="form-control ml-2 text-right flex-fill OT_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_double_hol_ot_ns_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Double Hol + Rest OT NS: </p>
                          <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_double_hol_rest_ot_ns" disabled>
                          <input type="number" class="form-control ml-2 text-right" value="<?= $dbl_hol_rest_ot_ns_mul?>" style="width: 60px; font-size: 13px;" id="TI_double_hol_rest_ot_ns_multiplier">
                          <input type="number" class="form-control ml-2 text-right flex-fill OT_each_total" style="width: 110px; font-size: 13px;" value="0" id="TI_double_hol_rest_ot_ns_total" disabled>
                      </div>

                      <div class="d-flex ml-1" style="margin-top: 25px;">
                          <p class="text-right mb-3 mt-1 text-bold" style="font-size: 14px;width:250px;">Total Overtime: </p>
                          <input type="text" class="form-control ml-1 text-right flex-fill" value="<?= $total_ot?>" style="width: 190px;" id="total_overtime" disabled>
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
                    <!-- other taxable income -->
                    <p class="text-bold mb-2">Others</p>
                    <?php
                      if($DISP_OTHER_TAXABLE_INCOME){
                        ?>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;"><?= $DISP_OTHER_TAXABLE_INCOME[0]->name ?>: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_OTHER_TAXABLE_INCOME[0]->value ?>" id="OTI_other1" disabled>
                              <input type="number" class="form-control ml-2 text-right" value="<?= $oti_1_mul?>" style="width: 60px; font-size: 13px;" id="OTI_other1_multiplier">
                              <input type="number" class="form-control ml-2 text-right flex-fill OTI_each_total" style="width: 110px; font-size: 13px;" value="0" id="OTI_other1_total" disabled>
                          </div>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;"><?= $DISP_OTHER_TAXABLE_INCOME[1]->name ?>: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_OTHER_TAXABLE_INCOME[1]->value ?>" id="OTI_other2" disabled>
                              <input type="number" class="form-control ml-2 text-right" value="<?= $oti_2_mul?>" style="width: 60px; font-size: 13px;" id="OTI_other2_multiplier">
                              <input type="number" class="form-control ml-2 text-right flex-fill OTI_each_total" style="width: 110px; font-size: 13px;" value="0" id="OTI_other2_total" disabled>
                          </div>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;"><?= $DISP_OTHER_TAXABLE_INCOME[2]->name ?>: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_OTHER_TAXABLE_INCOME[2]->value ?>" id="OTI_other3" disabled>
                              <input type="number" class="form-control ml-2 text-right" value="<?= $oti_3_mul?>" style="width: 60px; font-size: 13px;" id="OTI_other3_multiplier">
                              <input type="number" class="form-control ml-2 text-right flex-fill OTI_each_total" style="width: 110px; font-size: 13px;" value="0" id="OTI_other3_total" disabled>
                          </div>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;"><?= $DISP_OTHER_TAXABLE_INCOME[3]->name ?>: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_OTHER_TAXABLE_INCOME[3]->value ?>" id="OTI_other4" disabled>
                              <input type="number" class="form-control ml-2 text-right" value="<?= $oti_4_mul?>" style="width: 60px; font-size: 13px;" id="OTI_other4_multiplier">
                              <input type="number" class="form-control ml-2 text-right flex-fill OTI_each_total" style="width: 110px; font-size: 13px;" value="0" id="OTI_other4_total" disabled>
                          </div>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;"><?= $DISP_OTHER_TAXABLE_INCOME[4]->name ?>: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_OTHER_TAXABLE_INCOME[4]->value ?>" id="OTI_other5" disabled>
                              <input type="number" class="form-control ml-2 text-right" value="<?= $oti_5_mul?>" style="width: 60px; font-size: 13px;" id="OTI_other5_multiplier">
                              <input type="number" class="form-control ml-2 text-right flex-fill OTI_each_total" style="width: 110px; font-size: 13px;" value="0" id="OTI_other5_total" disabled>
                          </div>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;"><?= $DISP_OTHER_TAXABLE_INCOME[5]->name ?>: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_OTHER_TAXABLE_INCOME[5]->value ?>" id="OTI_other6" disabled>
                              <input type="number" class="form-control ml-2 text-right" value="<?= $oti_6_mul?>" style="width: 60px; font-size: 13px;" id="OTI_other6_multiplier">
                              <input type="number" class="form-control ml-2 text-right flex-fill OTI_each_total" style="width: 110px; font-size: 13px;" value="0" id="OTI_other6_total" disabled>
                          </div>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;"><?= $DISP_OTHER_TAXABLE_INCOME[6]->name ?>: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_OTHER_TAXABLE_INCOME[6]->value ?>" id="OTI_other7" disabled>
                              <input type="number" class="form-control ml-2 text-right" value="<?= $oti_7_mul?>" style="width: 60px; font-size: 13px;" id="OTI_other7_multiplier">
                              <input type="number" class="form-control ml-2 text-right flex-fill OTI_each_total" style="width: 110px; font-size: 13px;" value="0" id="OTI_other7_total" disabled>
                          </div>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;"><?= $DISP_OTHER_TAXABLE_INCOME[7]->name ?>: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_OTHER_TAXABLE_INCOME[7]->value ?>" id="OTI_other8" disabled>
                              <input type="number" class="form-control ml-2 text-right" value="<?= $oti_8_mul?>" style="width: 60px; font-size: 13px;" id="OTI_other8_multiplier">
                              <input type="number" class="form-control ml-2 text-right flex-fill OTI_each_total" style="width: 110px; font-size: 13px;" value="0" id="OTI_other8_total" disabled>
                          </div>
                        <?php
                      }
                    ?>
                  </div>
                  <!-- ./card-body -->
                </div>
                <!-- ./card -->

                <div class="card">
                  <div class="card-body">
                    <p class="text-bold mb-2">Absences / Tardiness / Undertime</p>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Absent: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_absent" disabled>
                        <input type="number" class="form-control ml-2 text-right" value="<?= $abs_mul?>" style="width: 60px; font-size: 13px;" id="TI_absent_multiplier">
                        <input type="number" class="form-control ml-2 text-right flex-fill TI_each_total_minus" style="width: 110px; font-size: 13px;" value="0" id="TI_absent_total" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Late/Undertime: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" id="TI_late_undertime" disabled>
                        <input type="number" class="form-control ml-2 text-right" value="<?= $late_mul?>" style="width: 60px; font-size: 13px;" id="TI_late_undertime_multiplier">
                        <input type="number" class="form-control ml-2 text-right flex-fill TI_each_total_minus" style="width: 110px; font-size: 13px;" value="0" id="TI_late_undertime_total" disabled>
                    </div>
                  </div>
                </div>

                <div class="card">
                    <div class="card-body">
                      <p class="text-bold mb-0">Total</p>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:250px;">Basic Pay: </p>
                          <input type="text" class="form-control ml-1 text-right flex-fill" value="<?= $total_bp?>" style="width: 190px;" id="BP_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:250px;">Overtime: </p>
                          <input type="text" class="form-control ml-1 text-right flex-fill" value="<?= $total_ot?>" style="width: 190px;" id="OT_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:250px;">Other Taxable Income: </p>
                          <input type="text" class="form-control ml-1 text-right flex-fill" value="<?= $total_oti?>" style="width: 190px;" id="OTI_total" disabled>
                      </div>
                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1" style="font-size: 14px;width:250px;">Absences / Tardiness / Undertime: </p>
                          <input type="text" class="form-control ml-1 text-right flex-fill" value="<?= $total_abs?>" style="width: 190px;" id="ABS_total" disabled>
                      </div>
                      <br>
                      <div class="d-flex ml-1 mt-1">
                          <p class="text-right mb-3 mt-1 text-bold" style="font-size: 14px;width:250px;">Total Taxable Income: </p>
                          <input type="text" class="form-control ml-1 text-right flex-fill" value="<?= $ti_total?>" style="width: 190px;" id="TI_total" disabled>
                      </div>
                    </div>
                </div>
              </div>
              <!-- ./col-4 -->
            </div>
            <!-- ./row -->

            <hr>

            <div class="row">
              <div class="col-12">
                <p class="text-bold mb-2" style="font-size: 20px;">Non-Taxable Income </p>
                <div class="card">
                  <div class="card-body">
                      <?php
                        if($DISP_NON_TAXABLE_INCOME){
                          ?>
                            <div class="d-flex ml-1">
                                <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;"><?= $DISP_NON_TAXABLE_INCOME[0]->name ?>: </p>
                                <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_NON_TAXABLE_INCOME[0]->value ?>" id="NTI_other1" disabled>
                                <input type="number" class="form-control ml-2 text-right" value="<?= $nti_1_mul?>" style="width: 60px; font-size: 13px;" id="NTI_other1_multiplier">
                                <input type="number" class="form-control ml-2 text-right flex-fill NTI_each_total" style="width: 110px; font-size: 13px;" value="0" id="NTI_other1_total" disabled>
                            </div>
                            <div class="d-flex ml-1">
                                <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;"><?= $DISP_NON_TAXABLE_INCOME[1]->name ?>: </p>
                                <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_NON_TAXABLE_INCOME[1]->value ?>" id="NTI_other2" disabled>
                                <input type="number" class="form-control ml-2 text-right" value="<?= $nti_2_mul?>" style="width: 60px; font-size: 13px;" id="NTI_other2_multiplier">
                                <input type="number" class="form-control ml-2 text-right flex-fill NTI_each_total" style="width: 110px; font-size: 13px;" value="0" id="NTI_other2_total" disabled>
                            </div>
                            <div class="d-flex ml-1">
                                <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;"><?= $DISP_NON_TAXABLE_INCOME[2]->name ?>: </p>
                                <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_NON_TAXABLE_INCOME[2]->value ?>" id="NTI_other3" disabled>
                                <input type="number" class="form-control ml-2 text-right" value="<?= $nti_3_mul?>" style="width: 60px; font-size: 13px;" id="NTI_other3_multiplier">
                                <input type="number" class="form-control ml-2 text-right flex-fill NTI_each_total" style="width: 110px; font-size: 13px;" value="0" id="NTI_other3_total" disabled>
                            </div>
                            <div class="d-flex ml-1">
                                <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;"><?= $DISP_NON_TAXABLE_INCOME[3]->name ?>: </p>
                                <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_NON_TAXABLE_INCOME[3]->value ?>" id="NTI_other4" disabled>
                                <input type="number" class="form-control ml-2 text-right" value="<?= $nti_4_mul?>" style="width: 60px; font-size: 13px;" id="NTI_other4_multiplier">
                                <input type="number" class="form-control ml-2 text-right flex-fill NTI_each_total" style="width: 110px; font-size: 13px;" value="0" id="NTI_other4_total" disabled>
                            </div>
                            <div class="d-flex ml-1">
                                <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;"><?= $DISP_NON_TAXABLE_INCOME[4]->name ?>: </p>
                                <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_NON_TAXABLE_INCOME[4]->value ?>" id="NTI_other5" disabled>
                                <input type="number" class="form-control ml-2 text-right" value="<?= $nti_5_mul?>" style="width: 60px; font-size: 13px;" id="NTI_other5_multiplier">
                                <input type="number" class="form-control ml-2 text-right flex-fill NTI_each_total" style="width: 110px; font-size: 13px;" value="0" id="NTI_other5_total" disabled>
                            </div>
                            <div class="d-flex ml-1">
                                <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;"><?= $DISP_NON_TAXABLE_INCOME[5]->name ?>: </p>
                                <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_NON_TAXABLE_INCOME[5]->value ?>" id="NTI_other6" disabled>
                                <input type="number" class="form-control ml-2 text-right" value="<?= $nti_6_mul?>" style="width: 60px; font-size: 13px;" id="NTI_other6_multiplier">
                                <input type="number" class="form-control ml-2 text-right flex-fill NTI_each_total" style="width: 110px; font-size: 13px;" value="0" id="NTI_other6_total" disabled>
                            </div>
                            <div class="d-flex ml-1">
                                <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;"><?= $DISP_NON_TAXABLE_INCOME[6]->name ?>: </p>
                                <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_NON_TAXABLE_INCOME[6]->value ?>" id="NTI_other7" disabled>
                                <input type="number" class="form-control ml-2 text-right" value="<?= $nti_7_mul?>" style="width: 60px; font-size: 13px;" id="NTI_other7_multiplier">
                                <input type="number" class="form-control ml-2 text-right flex-fill NTI_each_total" style="width: 110px; font-size: 13px;" value="0" id="NTI_other7_total" disabled>
                            </div>
                          <?php
                        }
                      ?>

                      <br>

                      <div class="d-flex ml-1">
                          <p class="text-right mb-3 mt-1 flex-fill text-bold" style="font-size: 14px;width:280px;">Total Non-Taxable Income: </p>
                          <input type="text" class="form-control ml-1 text-right" value="<?= $nti_total?>" style="width: 190px;" id="NTI_total" disabled>
                      </div>
                  </div>
                </div>
                <!-- ./card -->
              </div>
              <!-- ./col-12 -->
            </div>
            <!-- ./row -->

            <hr>

            <p class="text-bold mb-2" style="font-size: 20px;">Contributions / Loans / Advances</p>
            <div class="row">
              <div class="col-4">
                <div class="card">
                  <div class="card-body">
                    <p class="text-bold mb-2">Gross Taxable Income</p>
                    <div class="d-flex ml-1">
                        <input type="number" class="form-control ml-0 text-right flex-fill GOV_each_total mb-2"  value="<?= $gross_ti?>" style="width: 110px; font-size: 13px;" id="GROSS_TAX_total" disabled>
                    </div>
                    <hr>
                    <p class="text-bold mb-2">Government Contributions</p>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">W/Tax: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" value="<?= $gov_wtax?>"  style="width: 110px; font-size: 13px;" id="GOV_CONT_with_tax_total" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">SSS: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" value="<?= $gov_sss?>"  style="width: 110px; font-size: 13px;" id="GOV_CONT_SSS_total" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">PhilHealth: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" value="<?= $gov_philhealth?>"  style="width: 110px; font-size: 13px;" id="GOV_CONT_philhealth_total" disabled>
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Pag-Ibig: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" value="<?= $gov_pagibig?>"  style="width: 110px; font-size: 13px;" id="GOV_CONT_pagibig_total" disabled>
                    </div>

                    <br>

                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1 flex-fill text-bold" style="font-size: 14px;width:280px;">Total Contributions: </p>
                        <input type="number" class="form-control ml-1 text-right" style="width: 190px;" value="<?= $gov_total ?>" id="GOV_total" disabled>
                    </div>
                  </div>
                  <!-- ./card-body -->
                </div>
                <!-- ./card -->
              </div>
              <!-- ./col-4 -->

              <div class="col-4">
                <div class="card" style="height: 372px;">
                  <div class="card-body">
                    <p class="text-bold mb-2">Loans</p>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">SSS Salary Loan: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill LOAN_each_total" value="<?= $loan_sss_salary?>" style="width: 110px; font-size: 13px;" id="LOAN_SSS_salary_loan_total">
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">SSS Calamity Loan: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill LOAN_each_total" value="<?= $loan_sss_calamity?>" style="width: 110px; font-size: 13px;" id="LOAN_SSS_calamity_loan_total">
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Pagibig Salary Loan: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill LOAN_each_total" value="<?= $loan_hdmf_salary?>" style="width: 110px; font-size: 13px;" id="LOAN_HDMF_salary_loan_total">
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Pagibig Calamity Loan: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill LOAN_each_total" value="<?= $loan_hdmf_calamity?>" style="width: 110px; font-size: 13px;" id="LOAN_HDMF_calamity_loan_total">
                    </div>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Company Loan: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill LOAN_each_total" value="<?= $loan_company?>" style="width: 110px; font-size: 13px;" id="LOAN_company_loan_total">
                    </div>

                    <br>

                    <div class="d-flex ml-1" style="margin-top: 58px;">
                        <p class="text-right mb-3 mt-1 flex-fill text-bold" style="font-size: 14px;">Total Loans: </p>
                        <input type="number" class="form-control ml-1 text-right" style="width: 190px;" value="<?= $loan_total ?>" id="LOAN_total" disabled>
                    </div>
                  </div>
                  <!-- ./card-body -->
                </div>
                <!-- ./card -->
              </div>
              <!-- ./col-4 -->
              
              <div class="col-4">
                <div class="card" style="height: 372px;">
                  <div class="card-body">
                    <p class="text-bold mb-2">Deductions </p>
                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1" style="font-size: 14px;width:130px;">Salary Advances: </p>
                        <input type="number" class="form-control ml-2 text-right flex-fill DED_each_total" value="<?= $ded_salary_adv ?>" style="width: 110px; font-size: 13px;" id="DED_salary_advances_total" disabled>
                    </div>

                    <?php
                      if($DISP_DEDUCTIONS){
                        ?>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:130px;"><?= $DISP_DEDUCTIONS[0]->name ?>: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_DEDUCTIONS[0]->value ?>" id="DED_other1" disabled>
                              <input type="number" class="form-control ml-2 text-right" value="<?= $ded_1_mul ?>" style="width: 60px; font-size: 13px;" id="DED_other1_multiplier">
                              <input type="number" class="form-control ml-2 text-right flex-fill DED_each_total" style="width: 110px; font-size: 13px;" value="0" id="DED_other1_total" disabled>
                          </div>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:130px;"><?= $DISP_DEDUCTIONS[1]->name ?>: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_DEDUCTIONS[1]->value ?>" id="DED_other2" disabled>
                              <input type="number" class="form-control ml-2 text-right" value="<?= $ded_2_mul ?>" style="width: 60px; font-size: 13px;" id="DED_other2_multiplier">
                              <input type="number" class="form-control ml-2 text-right flex-fill DED_each_total" style="width: 110px; font-size: 13px;" value="0" id="DED_other2_total" disabled>
                          </div>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:130px;"><?= $DISP_DEDUCTIONS[2]->name ?>: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_DEDUCTIONS[2]->value ?>" id="DED_other3" disabled>
                              <input type="number" class="form-control ml-2 text-right" value="<?= $ded_3_mul ?>" style="width: 60px; font-size: 13px;" id="DED_other3_multiplier">
                              <input type="number" class="form-control ml-2 text-right flex-fill DED_each_total" style="width: 110px; font-size: 13px;" value="0" id="DED_other3_total" disabled>
                          </div>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:130px;"><?= $DISP_DEDUCTIONS[3]->name ?>: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_DEDUCTIONS[3]->value ?>" id="DED_other4" disabled>
                              <input type="number" class="form-control ml-2 text-right" value="<?= $ded_4_mul ?>" style="width: 60px; font-size: 13px;" id="DED_other4_multiplier">
                              <input type="number" class="form-control ml-2 text-right flex-fill DED_each_total" style="width: 110px; font-size: 13px;" value="0" id="DED_other4_total" disabled>
                          </div>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:130px;"><?= $DISP_DEDUCTIONS[4]->name ?>: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="<?= $DISP_DEDUCTIONS[4]->value ?>" id="DED_other5" disabled>
                              <input type="number" class="form-control ml-2 text-right" value="<?= $ded_5_mul ?>" style="width: 60px; font-size: 13px;" id="DED_other5_multiplier">
                              <input type="number" class="form-control ml-2 text-right flex-fill DED_each_total" style="width: 110px; font-size: 13px;" value="0" id="DED_other5_total" disabled>
                          </div>
                        <?php
                      }
                    ?>

                    <br>

                    <div class="d-flex ml-1" style="margin-top: 23px;">
                        <p class="text-right mb-3 mt-1 flex-fill text-bold" style="font-size: 14px;width:280px;">Total Deductions: </p>
                        <input type="text" class="form-control ml-1 text-right" value="<?= $ded_total ?>" style="width: 190px;" id="DED_total" disabled>
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

            <p class="text-bold mb-2" style="font-size: 20px;">Net Income</p>
            
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Taxable Income: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" value="<?= $ti_total?>" style="width: 110px; font-size: 13px;" id="OVR_total_TI" disabled>
                          </div>
                          <div class="d-flex ml-1" style="display: none !important;;">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Other Taxable Income: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" value="<?= $total_oti?>" style="width: 110px; font-size: 13px;" id="OVR_total_OTI" disabled>
                          </div>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Non-Taxable Income: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill" value="<?= $nti_total?>" style="width: 110px; font-size: 13px;" id="OVR_total_NTI" disabled>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Deductions: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill"  value="<?= $ded_total?>"style="width: 110px; font-size: 13px;" id="OVR_total_DED" disabled>
                          </div>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Contributions: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill"  value="<?= $gov_total?>"style="width: 110px; font-size: 13px;" id="OVR_total_GOV" disabled>
                          </div>
                          <div class="d-flex ml-1">
                              <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Loans: </p>
                              <input type="number" class="form-control ml-2 text-right flex-fill"  value="<?= $loan_total?>"style="width: 110px; font-size: 13px;" id="OVR_total_LOAN" disabled>
                          </div>
                        </div>
                    </div>

                    <br>

                    <div class="d-flex ml-1">
                        <p class="text-right mb-3 mt-1 flex-fill text-bold" style="font-size: 14px;">Net Pay: </p>
                        <input type="text" class="form-control ml-1 text-right" style="width: 190px;" value="<?= $net_pay ?>" id="OVR_total" disabled>
                    </div>
                  </div>
                  <!-- ./card-body -->
                </div>
                <!-- ./card -->
              </div>
              <!-- ./col-12 -->
            </div>
            <!-- ./row -->

            <hr>
            <br>
            <br>

            <p class="text-bold mb-2" style="font-size: 20px;">Company Contributions</p>

            <!-- Company Contributions -->
            <div class="row"> 
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <p class="text-bold mb-2">Government Contributions</p>
                    <div class="row">
                      <div class="col-4">
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">SSS: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="<?= $comp_cont_sss ?>" id="GOV_CONT_EMPLYR_SSS_total" disabled>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">PhilHealth: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="<?= $comp_cont_philhealth ?>" id="GOV_CONT_EMPLYR_philhealth_total" disabled>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="d-flex ml-1">
                            <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Pag-Ibig: </p>
                            <input type="number" class="form-control ml-2 text-right flex-fill GOV_each_total" style="width: 110px; font-size: 13px;" value="<?= $comp_cont_pagibig ?>" id="GOV_CONT_EMPLYR_pagibig_total" disabled>
                        </div>
                      </div>
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

            <!-- <div class="row"> 
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <p class="text-bold mb-2 page-title">Payslip Summary</p>
                    <hr>
                    <p class="text-bold mb-2">Taxable Income</p>
                    <table class="table table-hover table-xs">
                      <thead>
                        <th></th>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div> -->
        </div>
        <!-- flex-fill -->
    </div>
  <!-- p-3 -->



<table id="tbl_payroll" style="display: none;">
  <thead>
    <tr>
      <th>Basic Salary</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td id="tbl_total_bp"></td>
    </tr>
  </tbody>
</table>

<a href="#" id="btn_export_empl_info" style="display: none;">132123132123132121</a>









</div>
<!-- content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<!-- Add position -->
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
<!-- Edit position -->
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

<?php
if ($this->session->userdata('SESS_SUCC_MSG_ADD_PAYROLL')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_ADD_PAYROLL'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_ADD_PAYROLL');
}
?>

<?php
if ($this->session->userdata('SESS_SUCC_MSG_UPDT_PAYROLL')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_PAYROLL'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_UPDT_PAYROLL');
}
?>

<?php
if ($this->session->userdata('SESS_ERR_MSG_UPDT_PAYROLL')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_ERR_MSG_UPDT_PAYROLL'); ?>',
            '',
            'error'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_ERR_MSG_UPDT_PAYROLL');
}
?>

<script>
  $(document).ready(function(){

    $('#btn_update_payroll_data').click(function(){
      Swal.fire({
        title: 'Do you want to save the changes?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#form_updt_payroll').submit();
        }
      })
    })

    // URL of Async Function
    var url_empl = "<?= base_url() ?>payroll/getEmployeeData";
    $('#select_employee').change(function(){
      employee_id = $(this).val();
      getEmployeeData(url_empl,employee_id).then(data => {
        data.employee_data.forEach((x) => {
          var fullname = x.col_frst_name + ' ' + x.col_last_name;
          $('#employee_name').text(fullname);
        })
      })
    })


    function payroll_to_tbl(){
      var totalbasic = $('#total_basic_pay').val();
      $('#tbl_total_bp').html(totalbasic);
    }


    function show_each_total(){
      var ti_reg = $('#TI_reg_total').val(($('#TI_reg_multiplier').val()*$('#TI_reg').val()).toFixed(2));
      var ti_rest = $('#TI_rest_total').val(($('#TI_rest_multiplier').val()*$('#TI_rest').val()).toFixed(2));
      var ti_sp_hol = $('#TI_spec_hol_total').val(($('#TI_spec_hol_multiplier').val()*$('#TI_spec_hol').val()).toFixed(2));
      var ti_sp_hol_rest = $('#TI_spec_hol_rest_total').val(($('#TI_spec_hol_rest_multiplier').val()*$('#TI_spec_hol_rest').val()).toFixed(2));
      var ti_reg_hol = $('#TI_reg_hol_total').val(($('#TI_reg_hol_multiplier').val()*$('#TI_reg_hol').val()).toFixed(2));
      var ti_reg_hol_rest = $('#TI_reg_hol_rest_total').val(($('#TI_reg_hol_rest_multiplier').val()*$('#TI_reg_hol_rest').val()).toFixed(2));
      var ti_dbl_hol = $('#TI_double_hol_total').val(($('#TI_double_hol_multiplier').val()*$('#TI_double_hol').val()).toFixed(2));
      var ti_dbl_hol_rest = $('#TI_double_hol_rest_total').val(($('#TI_double_hol_rest_multiplier').val()*$('#TI_double_hol_rest').val()).toFixed(2));
      var ti_reg_ns = $('#TI_regular_ns_total').val(($('#TI_regular_ns_multiplier').val()*$('#TI_regular_ns').val()).toFixed(2));
      var ti_rest_ns = $('#TI_rest_ns_total').val(($('#TI_rest_ns_multiplier').val()*$('#TI_rest_ns').val()).toFixed(2));
      var ti_sp_hol_ns = $('#TI_spec_hol_ns_total').val(($('#TI_spec_hol_ns_multiplier').val()*$('#TI_spec_hol_ns').val()).toFixed(2));
      var ti_sp_hol_rest_ns = $('#TI_spec_hol_rest_ns_total').val(($('#TI_spec_hol_rest_ns_multiplier').val()*$('#TI_spec_hol_rest_ns').val()).toFixed(2));
      var ti_reg_hol_ns = $('#TI_reg_hol_ns_total').val(($('#TI_reg_hol_ns_multiplier').val()*$('#TI_reg_hol_ns').val()).toFixed(2));
      var ti_reg_hol_rest_ns = $('#TI_reg_hol_rest_ns_total').val(($('#TI_reg_hol_rest_ns_multiplier').val()*$('#TI_reg_hol_rest_ns').val()).toFixed(2));
      var ti_dbl_hol_ns = $('#TI_double_hol_ns_total').val(($('#TI_double_hol_ns_multiplier').val()*$('#TI_double_hol_ns').val()).toFixed(2));
      var ti_dbl_hol_rest_ns = $('#TI_double_hol_rest_ns_total').val(($('#TI_double_hol_rest_ns_multiplier').val()*$('#TI_double_hol_rest_ns').val()).toFixed(2));
      // var total_bp = parseFloat(ti_reg.val())+parseFloat(ti_rest.val())+parseFloat(ti_sp_hol.val())+parseFloat(ti_sp_hol_rest.val())+parseFloat(ti_reg_hol.val())+parseFloat(ti_reg_hol_rest.val())+parseFloat(ti_dbl_hol.val())+parseFloat(ti_dbl_hol_rest.val())+parseFloat(ti_reg_ns.val())+parseFloat(ti_rest_ns.val())+parseFloat(ti_sp_hol_ns.val())+parseFloat(ti_sp_hol_rest_ns.val())+parseFloat(ti_reg_hol_ns.val())+parseFloat(ti_reg_hol_rest_ns.val())+parseFloat(ti_dbl_hol_ns.val())+parseFloat(ti_dbl_hol_rest_ns.val());
      // $('#total_basic_pay').val(total_bp);

      var TI_reg_ot = $('#TI_reg_ot_total').val(($('#TI_reg_ot_multiplier').val()*$('#TI_reg_ot').val()).toFixed(2));
      var TI_rest_ot = $('#TI_rest_ot_total').val(($('#TI_rest_ot_multiplier').val()*$('#TI_rest_ot').val()).toFixed(2));
      var TI_spec_hol_ot = $('#TI_spec_hol_ot_total').val(($('#TI_spec_hol_ot_multiplier').val()*$('#TI_spec_hol_ot').val()).toFixed(2));
      var TI_spec_hol_rest_ot = $('#TI_spec_hol_rest_ot_total').val(($('#TI_spec_hol_rest_ot_multiplier').val()*$('#TI_spec_hol_rest_ot').val()).toFixed(2));
      var TI_reg_hol_ot = $('#TI_reg_hol_ot_total').val(($('#TI_reg_hol_ot_multiplier').val()*$('#TI_reg_hol_ot').val()).toFixed(2));
      var TI_reg_hol_rest_ot = $('#TI_reg_hol_rest_ot_total').val(($('#TI_reg_hol_rest_ot_multiplier').val()*$('#TI_reg_hol_rest_ot').val()).toFixed(2));
      var TI_double_hol_ot = $('#TI_double_hol_ot_total').val(($('#TI_double_hol_ot_multiplier').val()*$('#TI_double_hol_ot').val()).toFixed(2));
      var TI_double_hol_rest_ot = $('#TI_double_hol_rest_ot_total').val(($('#TI_double_hol_rest_ot_multiplier').val()*$('#TI_double_hol_rest_ot').val()).toFixed(2));
      var TI_reg_ot_ns = $('#TI_reg_ot_ns_total').val(($('#TI_reg_ot_ns_multiplier').val()*$('#TI_reg_ot_ns').val()).toFixed(2));
      var TI_rest_ot_ns = $('#TI_rest_ot_ns_total').val(($('#TI_rest_ot_ns_multiplier').val()*$('#TI_rest_ot_ns').val()).toFixed(2));
      var TI_spec_hol_ot_ns = $('#TI_spec_hol_ot_ns_total').val(($('#TI_spec_hol_ot_ns_multiplier').val()*$('#TI_spec_hol_ot_ns').val()).toFixed(2));
      var TI_spec_hol_rest_ot_ns = $('#TI_spec_hol_rest_ot_ns_total').val(($('#TI_spec_hol_rest_ot_ns_multiplier').val()*$('#TI_spec_hol_rest_ot_ns').val()).toFixed(2));
      var TI_reg_hol_ot_ns = $('#TI_reg_hol_ot_ns_total').val(($('#TI_reg_hol_ot_ns_multiplier').val()*$('#TI_reg_hol_ot_ns').val()).toFixed(2));
      var TI_reg_hol_rest_ot_ns = $('#TI_reg_hol_rest_ot_ns_total').val(($('#TI_reg_hol_rest_ot_ns_multiplier').val()*$('#TI_reg_hol_rest_ot_ns').val()).toFixed(2));
      var TI_double_hol_ot_ns = $('#TI_double_hol_ot_ns_total').val(($('#TI_double_hol_ot_ns_multiplier').val()*$('#TI_double_hol_ot_ns').val()).toFixed(2));
      var TI_double_hol_rest_ot_ns = $('#TI_double_hol_rest_ot_ns_total').val(($('#TI_double_hol_rest_ot_ns_multiplier').val()*$('#TI_double_hol_rest_ot_ns').val()).toFixed(2));

      var OTI_other1 = $('#OTI_other1_total').val(($('#OTI_other1_multiplier').val()*$('#OTI_other1').val()).toFixed(2));
      var OTI_other2 = $('#OTI_other2_total').val(($('#OTI_other2_multiplier').val()*$('#OTI_other2').val()).toFixed(2));
      var OTI_other3 = $('#OTI_other3_total').val(($('#OTI_other3_multiplier').val()*$('#OTI_other3').val()).toFixed(2));
      var OTI_other4 = $('#OTI_other4_total').val(($('#OTI_other4_multiplier').val()*$('#OTI_other4').val()).toFixed(2));
      var OTI_other5 = $('#OTI_other5_total').val(($('#OTI_other5_multiplier').val()*$('#OTI_other5').val()).toFixed(2));
      var OTI_other6 = $('#OTI_other6_total').val(($('#OTI_other6_multiplier').val()*$('#OTI_other6').val()).toFixed(2));
      var OTI_other7 = $('#OTI_other7_total').val(($('#OTI_other7_multiplier').val()*$('#OTI_other7').val()).toFixed(2));
      var OTI_other8 = $('#OTI_other8_total').val(($('#OTI_other8_multiplier').val()*$('#OTI_other8').val()).toFixed(2));

      var TI_absent = $('#TI_absent_total').val($('#TI_absent_multiplier').val()*$('#TI_absent').val());
      var TI_late_undertime = $('#TI_late_undertime_total').val($('#TI_late_undertime_multiplier').val()*$('#TI_late_undertime').val());

      var NTI_other1 = $('#NTI_other1_total').val(($('#NTI_other1_multiplier').val()*$('#NTI_other1').val()).toFixed(2));
      var NTI_other2 = $('#NTI_other2_total').val(($('#NTI_other2_multiplier').val()*$('#NTI_other2').val()).toFixed(2));
      var NTI_other3 = $('#NTI_other3_total').val(($('#NTI_other3_multiplier').val()*$('#NTI_other3').val()).toFixed(2));
      var NTI_other4 = $('#NTI_other4_total').val(($('#NTI_other4_multiplier').val()*$('#NTI_other4').val()).toFixed(2));
      var NTI_other5 = $('#NTI_other5_total').val(($('#NTI_other5_multiplier').val()*$('#NTI_other5').val()).toFixed(2));
      var NTI_other6 = $('#NTI_other6_total').val(($('#NTI_other6_multiplier').val()*$('#NTI_other6').val()).toFixed(2));
      var NTI_other7 = $('#NTI_other7_total').val(($('#NTI_other7_multiplier').val()*$('#NTI_other7').val()).toFixed(2));

      var DED_other1 = $('#DED_other1_total').val(($('#DED_other1_multiplier').val()*$('#DED_other1').val()).toFixed(2));
      var DED_other2 = $('#DED_other2_total').val(($('#DED_other2_multiplier').val()*$('#DED_other2').val()).toFixed(2));
      var DED_other3 = $('#DED_other3_total').val(($('#DED_other3_multiplier').val()*$('#DED_other3').val()).toFixed(2));
      var DED_other4 = $('#DED_other4_total').val(($('#DED_other4_multiplier').val()*$('#DED_other4').val()).toFixed(2));
      var DED_other5 = $('#DED_other5_total').val(($('#DED_other5_multiplier').val()*$('#DED_other5').val()).toFixed(2));

      // add all BP total values
      var BP_total_values = [];
      Array.from($('.BP_each_total')).forEach(function(total){
        BP_total_values.push(parseFloat($(total).val()));
      })
      BP_total = BP_total_values.reduce((a, b) => a + b);

      // add all OT total values
      var OT_total_values = [];
      Array.from($('.OT_each_total')).forEach(function(total){
        OT_total_values.push(parseFloat($(total).val()));
      })
      OT_total = OT_total_values.reduce((a, b) => a + b);
      
      // minus absent total values
      var minus_total_values = [];
      Array.from($('.TI_each_total_minus')).forEach(function(total){
        minus_total_values.push(parseFloat($(total).val()));
      })
      minus_TI_total = minus_total_values.reduce((a, b) => a + b);

      // add all total values
      var OTI_total_values = [];
      Array.from($('.OTI_each_total')).forEach(function(total){
        OTI_total_values.push(parseFloat($(total).val()));
      })
      OTI_total = OTI_total_values.reduce((a, b) => a + b);

      TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

      $('#total_basic_pay').val(BP_total.toFixed(2));
      $('#total_overtime').val(OT_total.toFixed(2));


      $('#ABS_total').val(minus_TI_total.toFixed(2));
      $('#BP_total').val(BP_total.toFixed(2));
      $('#OT_total').val(OT_total.toFixed(2));
      $('#TI_total').val(TI_total.toFixed(2));
      $('#OTI_total').val(OTI_total.toFixed(2));
      $('#OVR_total_TI').val(TI_total.toFixed(2));
      $('#OVR_total_OTI').val(OTI_total.toFixed(2));

      var total_TI = parseFloat($('#TI_total').val());
      var total_OTI = parseFloat($('#OTI_total').val());
      var total_NTI = parseFloat($('#NTI_total').val());
      var total_DED = parseFloat($('#DED_total').val());

      var total_OVR = (total_TI + total_NTI) - total_DED;
      var total_GTI = TI_total;
      $('#OVR_total').val(total_OVR.toFixed(2));
      $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
      getSalaryWitholdingTax(url,total_GTI).then(data => {
        data.witholding_tax.forEach((x) => {
          var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

          document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
        });
        data.sss.forEach((x) => {
          // gov contributions (employee)
          document.getElementById('GOV_CONT_SSS_total').value = x.ee;
          document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
          document.getElementById('GOV_CONT_pagibig_total').value = 100;
          // gov contributions (employer)
          document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
          document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
          document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

          var wth_tax = $('#GOV_CONT_with_tax_total').val();
          var sss = x.ee
          var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
          var pagibig = 100;
          var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
          $('#GOV_total').val(gov_cont_total.toFixed(2));
          $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
          $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
        });
      });

      payroll_to_tbl();

    }

    setTimeout(() => {
      show_each_total();
    }, 200);
    

    function save_to_db(){

      payroll_to_tbl();
      
      var reg_mul = $('#TI_reg_multiplier').val();
      var rest_mul = $('#TI_rest_multiplier').val();
      var sp_hol_mul = $('#TI_spec_hol_multiplier').val();
      var sp_hol_rest_mul= $('#TI_spec_hol_rest_multiplier').val();
      var reg_hol_mul= $('#TI_reg_hol_multiplier').val();
      var reg_hol_rest_mul= $('#TI_reg_hol_rest_multiplier').val();
      var dbl_hol_mul= $('#TI_double_hol_multiplier').val();
      var dbl_hol_rest_mul= $('#TI_double_hol_rest_multiplier').val();
      var reg_ns_mul = $('#TI_regular_ns_multiplier').val();
      var rest_ns_mul = $('#TI_rest_ns_multiplier').val();
      var sp_hol_ns_mul = $('#TI_spec_hol_ns_multiplier').val();
      var sp_hol_rest_ns_mul = $('#TI_spec_hol_rest_ns_multiplier').val();
      var reg_hol_ns_mul = $('#TI_reg_hol_ns_multiplier').val();
      var reg_hol_rest_ns_mul = $('#TI_reg_hol_rest_ns_multiplier').val();
      var dbl_hol_ns_mul = $('#TI_double_hol_ns_multiplier').val();
      var dbl_hol_rest_ns_mul = $('#TI_double_hol_rest_ns_multiplier').val();
      var total_bp = $('#total_basic_pay').val();

      var reg_ot_mul = $('#TI_reg_ot_multiplier').val();
      var rest_ot_mul = $('#TI_rest_ot_multiplier').val();
      var sp_hol_ot_mul = $('#TI_spec_hol_ot_multiplier').val();
      var sp_hol_rest_ot_mul = $('#TI_spec_hol_rest_ot_multiplier').val();
      var reg_hol_ot_mul = $('#TI_reg_hol_ot_multiplier').val();
      var reg_hol_rest_ot_mul = $('#TI_reg_hol_rest_ot_multiplier').val();
      var dbl_hol_ot_mul = $('#TI_double_hol_ot_multiplier').val();
      var dbl_hol_rest_ot_mul = $('#TI_double_hol_rest_ot_multiplier').val();
      var reg_ot_ns_mul = $('#TI_reg_ot_ns_multiplier').val();
      var rest_ot_ns_mul = $('#TI_rest_ot_ns_multiplier').val();
      var sp_hol_ot_ns_mul = $('#TI_spec_hol_ot_ns_multiplier').val();
      var sp_hol_rest_ot_ns_mul = $('#TI_spec_hol_rest_ot_ns_multiplier').val();
      var reg_hol_ot_ns_mul = $('#TI_reg_hol_ot_ns_multiplier').val();
      var reg_hol_rest_ot_ns_mul = $('#TI_reg_hol_rest_ot_ns_multiplier').val();
      var dbl_hol_ot_ns_mul = $('#TI_double_hol_ot_ns_multiplier').val();
      var dbl_hol_rest_ot_ns_mul = $('#TI_double_hol_rest_ot_ns_multiplier').val();
      var total_ot = $('#total_overtime').val();

      var oti_1_mul = $('#OTI_other1_multiplier').val();
      var oti_2_mul = $('#OTI_other2_multiplier').val();
      var oti_3_mul = $('#OTI_other3_multiplier').val();
      var oti_4_mul = $('#OTI_other4_multiplier').val();
      var oti_5_mul = $('#OTI_other5_multiplier').val();
      var oti_6_mul = $('#OTI_other6_multiplier').val();
      var oti_7_mul = $('#OTI_other7_multiplier').val();
      var oti_8_mul = $('#OTI_other8_multiplier').val();

      var abs_mul = $('#TI_absent_multiplier').val();
      var late_mul = $('#TI_late_undertime_multiplier').val();

      var bp_total = $('#BP_total').val();
      var ot_total = $('#OT_total').val();
      var oti_total = $('#OTI_total').val();
      var abs_total = $('#ABS_total').val();
      var ti_total = $('#TI_total').val();

      var nti_1_mul = $('#NTI_other1_multiplier').val();
      var nti_2_mul = $('#NTI_other2_multiplier').val();
      var nti_3_mul = $('#NTI_other3_multiplier').val();
      var nti_4_mul = $('#NTI_other4_multiplier').val();
      var nti_5_mul = $('#NTI_other5_multiplier').val();
      var nti_6_mul = $('#NTI_other6_multiplier').val();
      var nti_7_mul = $('#NTI_other7_multiplier').val();
      var nti_total = $('#NTI_total').val();

      var gross_ti = $('#GROSS_TAX_total').val();
      var gov_wtax = $('#GOV_CONT_with_tax_total').val();
      var gov_sss = $('#GOV_CONT_SSS_total').val();
      var gov_philhealth = $('#GOV_CONT_philhealth_total').val();
      var gov_pagibig = $('#GOV_CONT_pagibig_total').val();
      var gov_total = $('#GOV_total').val();

      var loan_sss_salary = $('#LOAN_SSS_salary_loan_total').val();
      var loan_sss_calamity = $('#LOAN_SSS_calamity_loan_total').val();
      var loan_hdmf_salary = $('#LOAN_HDMF_salary_loan_total').val();
      var loan_hdmf_calamity = $('#LOAN_HDMF_calamity_loan_total').val();
      var loan_company = $('#LOAN_company_loan_total').val();
      var loan_total = $('#LOAN_total').val();

      var ded_salary_adv = $('#DED_salary_advances_total').val();
      var ded_1_mul = $('#DED_other1_multiplier').val();
      var ded_2_mul = $('#DED_other2_multiplier').val();
      var ded_3_mul = $('#DED_other3_multiplier').val();
      var ded_4_mul = $('#DED_other4_multiplier').val();
      var ded_5_mul = $('#DED_other5_multiplier').val();
      var ded_total = $('#DED_total').val();

      var ovr_total_ti = $('#OVR_total_TI').val();
      var ovr_total_oti = $('#OVR_total_OTI').val();
      var ovr_total_nti = $('#OVR_total_NTI').val();
      var ovr_total_ded = $('#OVR_total_DED').val();
      var ovr_total_gov = $('#OVR_total_GOV').val();
      var ovr_total_loan = $('#OVR_total_LOAN').val();
      var net_pay = $('#OVR_total').val();

      var comp_cont_sss = $('#GOV_CONT_EMPLYR_SSS_total').val();
      var comp_cont_philhealth = $('#GOV_CONT_EMPLYR_philhealth_total').val();
      var comp_cont_pagibig = $('#GOV_CONT_EMPLYR_pagibig_total').val();

      $('input.empl_id').val($('#select_employee').val());
      $('input.empl_name').val($('#employee_name').text());
      $('input.monthly_salary').val($('#monthly_salary').val());
      $('input.work_rate').val($('#date_range').val());
      $('input.daily_salary').val($('#daily_salary').text());
      $('input.hourly_salary').val($('#hourly_salary').text());
      $('input.payroll_period').val($('#cutoff_period').val());
      $('input.working_days').val($('#working_days').val());
      $('input.hours_of_work').val($('#work_hours').val());
      
      // Basic Pay
      if(reg_mul){$('input.reg_mul').val(reg_mul);}else{$('input.reg_mul').val(0);}
      if(rest_mul){$('input.rest_mul').val(rest_mul);}else{$('input.rest_mul').val(0);}
      if(sp_hol_mul){$('input.sp_hol_mul').val(sp_hol_mul);}else{$('input.sp_hol_mul').val(0);}
      if(sp_hol_rest_mul){$('input.sp_hol_rest_mul').val(sp_hol_rest_mul);}else{$('input.sp_hol_rest_mul').val(0);}
      if(reg_hol_mul){$('input.reg_hol_mul').val(reg_hol_mul);}else{$('input.reg_hol_mul').val(0);}
      if(reg_hol_rest_mul){$('input.reg_hol_rest_mul').val(reg_hol_rest_mul);}else{$('input.reg_hol_rest_mul').val(0);}
      if(dbl_hol_mul){$('input.dbl_hol_mul').val(dbl_hol_mul);}else{$('input.dbl_hol_mul').val(0);}
      if(dbl_hol_rest_mul){$('input.dbl_hol_rest_mul').val(dbl_hol_rest_mul);}else{$('input.dbl_hol_rest_mul').val(0);}
      if(reg_ns_mul){$('input.reg_ns_mul').val(reg_ns_mul);}else{$('input.reg_ns_mul').val(0);}
      if(rest_ns_mul){$('input.rest_ns_mul').val(rest_ns_mul);}else{$('input.rest_ns_mul').val(0);}
      if(sp_hol_ns_mul){$('input.sp_hol_ns_mul').val(sp_hol_ns_mul);}else{$('input.sp_hol_ns_mul').val(0);}
      if(sp_hol_rest_ns_mul){$('input.sp_hol_rest_ns_mul').val(sp_hol_rest_ns_mul);}else{$('input.sp_hol_rest_ns_mul').val(0);}
      if(reg_hol_ns_mul){$('input.reg_hol_ns_mul').val(reg_hol_ns_mul);}else{$('input.reg_hol_ns_mul').val(0);}
      if(reg_hol_rest_ns_mul){$('input.reg_hol_rest_ns_mul').val(reg_hol_rest_ns_mul);}else{$('input.reg_hol_rest_ns_mul').val(0);}
      if(dbl_hol_ns_mul){$('input.dbl_hol_ns_mul').val(dbl_hol_ns_mul);}else{$('input.dbl_hol_ns_mul').val(0);}
      if(dbl_hol_rest_ns_mul){$('input.dbl_hol_rest_ns_mul').val(dbl_hol_rest_ns_mul);}else{$('input.dbl_hol_rest_ns_mul').val(0);}
      if(total_bp){$('input.total_bp').val(total_bp);}else{$('input.total_bp').val(0);}

      // Overtime
      if(reg_ot_mul){$('input.reg_ot_mul').val(reg_ot_mul);}else{$('input.reg_ot_mul').val(0);}
      if(rest_ot_mul){$('input.rest_ot_mul').val(rest_ot_mul);}else{$('input.rest_ot_mul').val(0);}
      if(sp_hol_ot_mul){$('input.sp_hol_ot_mul').val(sp_hol_ot_mul);}else{$('input.sp_hol_ot_mul').val(0);}
      if(sp_hol_rest_ot_mul){$('input.sp_hol_rest_ot_mul').val(sp_hol_rest_ot_mul);}else{$('input.sp_hol_rest_ot_mul').val(0);}
      if(reg_hol_ot_mul){$('input.reg_hol_ot_mul').val(reg_hol_ot_mul);}else{$('input.reg_hol_ot_mul').val(0);}
      if(reg_hol_rest_ot_mul){$('input.reg_hol_rest_ot_mul').val(reg_hol_rest_ot_mul);}else{$('input.reg_hol_rest_ot_mul').val(0);}
      if(dbl_hol_ot_mul){$('input.dbl_hol_ot_mul').val(dbl_hol_ot_mul);}else{$('input.dbl_hol_ot_mul').val(0);}
      if(dbl_hol_rest_ot_mul){$('input.dbl_hol_rest_ot_mul').val(dbl_hol_rest_ot_mul);}else{$('input.dbl_hol_rest_ot_mul').val(0);}
      if(reg_ot_ns_mul){$('input.reg_ot_ns_mul').val(reg_ot_ns_mul);}else{$('input.reg_ot_ns_mul').val(0);}
      if(rest_ot_ns_mul){$('input.rest_ot_ns_mul').val(rest_ot_ns_mul);}else{$('input.rest_ot_ns_mul').val(0);}
      if(sp_hol_ot_ns_mul){$('input.sp_hol_ot_ns_mul').val(sp_hol_ot_ns_mul);}else{$('input.sp_hol_ot_ns_mul').val(0);}
      if(sp_hol_rest_ot_ns_mul){$('input.sp_hol_rest_ot_ns_mul').val(sp_hol_rest_ot_ns_mul);}else{$('input.sp_hol_rest_ot_ns_mul').val(0);}
      if(reg_hol_ot_ns_mul){$('input.reg_hol_ot_ns_mul').val(reg_hol_ot_ns_mul);}else{$('input.reg_hol_ot_ns_mul').val(0);}
      if(reg_hol_rest_ot_ns_mul){$('input.reg_hol_rest_ot_ns_mul').val(reg_hol_rest_ot_ns_mul);}else{$('input.reg_hol_rest_ot_ns_mul').val(0);}
      if(dbl_hol_ot_ns_mul){$('input.dbl_hol_ot_ns_mul').val(dbl_hol_ot_ns_mul);}else{$('input.dbl_hol_ot_ns_mul').val(0);}
      if(dbl_hol_rest_ot_ns_mul){$('input.dbl_hol_rest_ot_ns_mul').val(dbl_hol_rest_ot_ns_mul);}else{$('input.dbl_hol_rest_ot_ns_mul').val(0);}
      if(total_ot){$('input.total_ot').val(total_ot);}else{$('input.total_ot').val(0);}

      // Other Tax Income
      if(oti_1_mul){$('input.oti_1_mul').val(oti_1_mul);}else{$('input.oti_1_mul').val(0);}
      if(oti_2_mul){$('input.oti_2_mul').val(oti_2_mul);}else{$('input.oti_2_mul').val(0);}
      if(oti_3_mul){$('input.oti_3_mul').val(oti_3_mul);}else{$('input.oti_3_mul').val(0);}
      if(oti_4_mul){$('input.oti_4_mul').val(oti_4_mul);}else{$('input.oti_4_mul').val(0);}
      if(oti_5_mul){$('input.oti_5_mul').val(oti_5_mul);}else{$('input.oti_5_mul').val(0);}
      if(oti_6_mul){$('input.oti_6_mul').val(oti_6_mul);}else{$('input.oti_6_mul').val(0);}
      if(oti_7_mul){$('input.oti_7_mul').val(oti_7_mul);}else{$('input.oti_7_mul').val(0);}
      if(oti_8_mul){$('input.oti_8_mul').val(oti_8_mul);}else{$('input.oti_8_mul').val(0);}
      if(oti_total){$('input.total_oti').val(oti_total);}else{$('input.total_oti').val(0);}

      // absence / late / undertime
      if(abs_mul){$('input.abs_mul').val(abs_mul);}else{$('input.abs_mul').val(0);}
      if(late_mul){$('input.late_mul').val(late_mul);}else{$('input.late_mul').val(0);}
      if(abs_total){$('input.total_abs').val(abs_total);}else{$('input.total_abs').val(0);}

      // total tax income
      if(ti_total){$('input.ti_total').val(ti_total);}else{$('input.ti_total').val(0);}

      // Non-Taxable Income
      if(nti_1_mul){$('input.nti_1_mul').val(nti_1_mul);}else{$('input.nti_1_mul').val(0);}
      if(nti_2_mul){$('input.nti_2_mul').val(nti_2_mul);}else{$('input.nti_2_mul').val(0);}
      if(nti_3_mul){$('input.nti_3_mul').val(nti_3_mul);}else{$('input.nti_3_mul').val(0);}
      if(nti_4_mul){$('input.nti_4_mul').val(nti_4_mul);}else{$('input.nti_4_mul').val(0);}
      if(nti_5_mul){$('input.nti_5_mul').val(nti_5_mul);}else{$('input.nti_5_mul').val(0);}
      if(nti_6_mul){$('input.nti_6_mul').val(nti_6_mul);}else{$('input.nti_6_mul').val(0);}
      if(nti_7_mul){$('input.nti_7_mul').val(nti_7_mul);}else{$('input.nti_7_mul').val(0);}
      if(nti_total){$('input.nti_total').val(nti_total);}else{$('input.nti_total').val(0);}

      // Gov't Contributions
      if(gross_ti){$('input.gross_ti').val(gross_ti);}else{$('input.gross_ti').val(0);}
      if(gov_wtax){$('input.gov_wtax').val(gov_wtax);}else{$('input.gov_wtax').val(0);}
      if(gov_sss){$('input.gov_sss').val(gov_sss);}else{$('input.gov_sss').val(0);}
      if(gov_philhealth){$('input.gov_philhealth').val(gov_philhealth);}else{$('input.gov_philhealth').val(0);}
      if(gov_pagibig){$('input.gov_pagibig').val(gov_pagibig);}else{$('input.gov_pagibig').val(0);}
      if(gov_total){$('input.gov_total').val(gov_total);}else{$('input.gov_total').val(0);}

      // Loans
      if(loan_sss_salary){$('input.loan_sss_salary').val(loan_sss_salary);}else{$('input.loan_sss_salary').val(0);}
      if(loan_sss_calamity){$('input.loan_sss_calamity').val(loan_sss_calamity);}else{$('input.loan_sss_calamity').val(0);}
      if(loan_hdmf_salary){$('input.loan_hdmf_salary').val(loan_hdmf_salary);}else{$('input.loan_hdmf_salary').val(0);}
      if(loan_hdmf_calamity){$('input.loan_hdmf_calamity').val(loan_hdmf_calamity);}else{$('input.loan_hdmf_calamity').val(0);}
      if(loan_company){$('input.loan_company').val(loan_company);}else{$('input.loan_company').val(0);}
      if(loan_total){$('input.loan_total').val(loan_total);}else{$('input.loan_total').val(0);}

      // Deductions
      if(ded_salary_adv){$('input.ded_salary_adv').val(ded_salary_adv);}else{$('input.ded_salary_adv').val(0);}
      if(ded_1_mul){$('input.ded_1_mul').val(ded_1_mul);}else{$('input.ded_1_mul').val(0);}
      if(ded_2_mul){$('input.ded_2_mul').val(ded_2_mul);}else{$('input.ded_2_mul').val(0);}
      if(ded_3_mul){$('input.ded_3_mul').val(ded_3_mul);}else{$('input.ded_3_mul').val(0);}
      if(ded_4_mul){$('input.ded_4_mul').val(ded_4_mul);}else{$('input.ded_4_mul').val(0);}
      if(ded_5_mul){$('input.ded_5_mul').val(ded_5_mul);}else{$('input.ded_5_mul').val(0);}
      if(ded_total){$('input.ded_total').val(ded_total);}else{$('input.ded_total').val(0);}

      // Overall Total
      if(ovr_total_ti){$('input.ovr_total_ti').val(ovr_total_ti);}else{$('input.ovr_total_ti').val(0);}
      if(ovr_total_oti){$('input.ovr_total_oti').val(ovr_total_oti);}else{$('input.ovr_total_oti').val(0);}
      if(ovr_total_nti){$('input.ovr_total_nti').val(ovr_total_nti);}else{$('input.ovr_total_nti').val(0);}
      if(ovr_total_ded){$('input.ovr_total_ded').val(ovr_total_ded);}else{$('input.ovr_total_ded').val(0);}
      if(ovr_total_gov){$('input.ovr_total_gov').val(ovr_total_gov);}else{$('input.ovr_total_gov').val(0);}
      if(ovr_total_loan){$('input.ovr_total_loan').val(ovr_total_loan);}else{$('input.ovr_total_loan').val(0);}

      // Net Pay
      if(net_pay){$('input.net_pay').val(net_pay);}else{$('input.net_pay').val(0);}

      // Company Contributions
      if(comp_cont_sss){$('input.comp_cont_sss').val(comp_cont_sss);}else{$('input.comp_cont_sss').val(0);}
      if(comp_cont_philhealth){$('input.comp_cont_philhealth').val(comp_cont_philhealth);}else{$('input.comp_cont_philhealth').val(0);}
      if(comp_cont_pagibig){$('input.comp_cont_pagibig').val(comp_cont_pagibig);}else{$('input.comp_cont_pagibig').val(0);}
    }

    save_to_db();

    // Check if track attendance or manual entry
    $('input[type=radio][name=generate_payroll_data]').change(function() {
        if (this.value == 'automatic') {
          // if track attendance is checked, disable input field for multiplier
          // reg
          $('#TI_reg_multiplier').prop('disabled',true);
          $('#TI_rest_multiplier').prop('disabled',true);
          $('#TI_spec_hol_multiplier').prop('disabled',true);
          $('#TI_spec_hol_rest_multiplier').prop('disabled',true);
          $('#TI_reg_hol_multiplier').prop('disabled',true);
          $('#TI_reg_hol_rest_multiplier').prop('disabled',true);
          $('#TI_double_hol_multiplier').prop('disabled',true);
          $('#TI_double_hol_rest_multiplier').prop('disabled',true);

          // reg ns
          $('#TI_regular_ns_multiplier').prop('disabled',true);
          $('#TI_rest_ns_multiplier').prop('disabled',true);
          $('#TI_spec_hol_ns_multiplier').prop('disabled',true);
          $('#TI_spec_hol_rest_ns_multiplier').prop('disabled',true);
          $('#TI_reg_hol_ns_multiplier').prop('disabled',true);
          $('#TI_reg_hol_rest_ns_multiplier').prop('disabled',true);
          $('#TI_double_hol_ns_multiplier').prop('disabled',true);
          $('#TI_double_hol_rest_ns_multiplier').prop('disabled',true);
        }
        else if (this.value == 'manual') {
          // if manual entry is checked, enable input field for multiplier
          // reg
          $('#TI_reg_multiplier').prop('disabled',false);
          $('#TI_rest_multiplier').prop('disabled',false);
          $('#TI_spec_hol_multiplier').prop('disabled',false);
          $('#TI_spec_hol_rest_multiplier').prop('disabled',false);
          $('#TI_reg_hol_multiplier').prop('disabled',false);
          $('#TI_reg_hol_rest_multiplier').prop('disabled',false);
          $('#TI_double_hol_multiplier').prop('disabled',false);
          $('#TI_double_hol_rest_multiplier').prop('disabled',false);

          // reg ns
          $('#TI_regular_ns_multiplier').prop('disabled',false);
          $('#TI_rest_ns_multiplier').prop('disabled',false);
          $('#TI_spec_hol_ns_multiplier').prop('disabled',false);
          $('#TI_spec_hol_rest_ns_multiplier').prop('disabled',false);
          $('#TI_reg_hol_ns_multiplier').prop('disabled',false);
          $('#TI_reg_hol_rest_ns_multiplier').prop('disabled',false);
          $('#TI_double_hol_ns_multiplier').prop('disabled',false);
          $('#TI_double_hol_rest_ns_multiplier').prop('disabled',false);
        }
    });


    // input number of days if 'input days here' is chosen
    $('#date_range').change(function(){
      
      if($(this).val() == 'custom'){
        $('#custom_days').show();
      } else {
        $('#custom_days').hide();

        switch($(this).val()) {
          case 'divide_by_30':
            // code block
              var day_rate = 30;
              computeTI(day_rate);
              show_each_total()
              save_to_db();
              payroll_to_tbl();
            break;
          case 'divide_by_26':
            // code block
              var day_rate = 26;
              computeTI(day_rate);
              show_each_total()
              save_to_db();
              payroll_to_tbl();
            break;
          case 'divide_by_24':
            // code block
              var day_rate = 24;
              computeTI(day_rate);
              show_each_total()
              save_to_db();
              payroll_to_tbl();
            break;
          case 'divide_by_22':
            // code block
              var day_rate = 22;
              computeTI(day_rate);
              show_each_total()
              save_to_db();
              payroll_to_tbl();
            break;
          case 'divide_by_20':
            // code block
              var day_rate = 20;
              computeTI(day_rate);
              show_each_total()
              save_to_db();
              payroll_to_tbl();
            break;
          case '313_days':
            // code block
              var day_rate = 313 / 12;
              computeTI(day_rate);
              show_each_total()
              save_to_db();
              payroll_to_tbl();
            break;
          case '261_days':
            // code block
              var day_rate = 261 / 12;
              computeTI(day_rate);
              show_each_total()
              save_to_db();
              payroll_to_tbl();
            break;
          default:
            // code block
            var day_rate = 30;
            computeTI(day_rate);
            show_each_total()
            save_to_db();
            payroll_to_tbl();
        }
      }
    })

    $('#monthly_salary').keyup(function(){

      switch($('#date_range').val()) {
          case 'divide_by_30':
            // code block
              var day_rate = 30;
              computeTI(day_rate);
              show_each_total()
              save_to_db();
            break;
          case 'divide_by_26':
            // code block
              var day_rate = 26;
              computeTI(day_rate);
              show_each_total()
              save_to_db();
            break;
          case 'divide_by_24':
            // code block
              var day_rate = 24;
              computeTI(day_rate);
              show_each_total()
              save_to_db();
            break;
          case 'divide_by_22':
            // code block
              var day_rate = 22;
              computeTI(day_rate);
              show_each_total()
              save_to_db();
            break;
          case 'divide_by_20':
            // code block
              var day_rate = 20;
              computeTI(day_rate);
              show_each_total()
              save_to_db();
            break;
          case '313_days':
            // code block
              var day_rate = 313 / 12;
              computeTI(day_rate);
              show_each_total()
              save_to_db();
            break;
          case '261_days':
            // code block
              var day_rate = 261 / 12;
              computeTI(day_rate);
              show_each_total()
              save_to_db();
            break;
          case 'custom':
            // code block
              computeTI($('#custom_days').val());
              show_each_total()
              save_to_db();
            break;
          default:
            // code block
            var day_rate = 30;
            computeTI(day_rate);
            show_each_total()
            save_to_db();
        }
    })

    $('#work_hours').keyup(function(){
      switch($('#date_range').val()) {
        case 'divide_by_30':
          // code block
            var day_rate = 30;
            computeTI(day_rate);
            show_each_total()
            save_to_db();
          break;
        case 'divide_by_26':
          // code block
            var day_rate = 26;
            computeTI(day_rate);
            show_each_total()
            save_to_db();
          break;
        case 'divide_by_24':
          // code block
            var day_rate = 24;
            computeTI(day_rate);
            show_each_total()
            save_to_db();
          break;
        case 'divide_by_22':
          // code block
            var day_rate = 22;
            computeTI(day_rate);
            show_each_total()
            save_to_db();
          break;
        case 'divide_by_20':
          // code block
            var day_rate = 20;
            computeTI(day_rate);
            show_each_total()
            save_to_db();
          break;
        case '313_days':
          // code block
            var day_rate = 313 / 12;
            computeTI(day_rate);
            show_each_total()
            save_to_db();
          break;
        case '261_days':
          // code block
            var day_rate = 261 / 12;
            computeTI(day_rate);
            show_each_total()
            save_to_db();
          break;
        case 'custom':
          // code block
            computeTI($('#custom_days').val());
            show_each_total()
            save_to_db();
          break;
        default:
          // code block
          var day_rate = 30;
          computeTI(day_rate);
          show_each_total()
          save_to_db();
      }
    })

    

    function computeTI(day_rate){
      payroll_to_tbl();
      var monthly_salary = parseFloat($('#monthly_salary').val());
      var hours_per_day = parseFloat($('#work_hours').val());
      var daily_salary = monthly_salary / day_rate;
      $('#daily_salary').text(daily_salary.toFixed(2));
      $('#hourly_salary').text((daily_salary / hours_per_day).toFixed(2));

      // Show Taxable Income value based on Daily Salary
      // Basic Pay
      $('#TI_reg').val( daily_salary.toFixed(2) );
      $('#TI_rest').val( (parseFloat($('#daily_salary').text()) * 1.3).toFixed(2) );
      $('#TI_spec_hol').val( (parseFloat($('#daily_salary').text()) * 1.3).toFixed(2) );
      $('#TI_spec_hol_rest').val( (parseFloat($('#daily_salary').text()) * 1.5).toFixed(2) );
      $('#TI_reg_hol').val( (parseFloat($('#daily_salary').text()) * 2).toFixed(2) );
      $('#TI_reg_hol_rest').val( (parseFloat($('#daily_salary').text()) * 2.6).toFixed(2) ); // <<<<<<<<<
      $('#TI_double_hol').val( (parseFloat($('#daily_salary').text()) * 3).toFixed(2) );
      $('#TI_double_hol_rest').val( (parseFloat($('#daily_salary').text()) * 3.9).toFixed(2) );
      
      $('#TI_regular_ns').val( (parseFloat($('#daily_salary').text()) * 1.1).toFixed(2) );
      $('#TI_rest_ns').val( (parseFloat($('#daily_salary').text()) * 1.3 * 1.1).toFixed(2));
      $('#TI_spec_hol_ns').val( (parseFloat($('#daily_salary').text()) * 1.3 * 1.1).toFixed(2) );
      $('#TI_spec_hol_rest_ns').val( (parseFloat($('#daily_salary').text()) * 1.5 * 1.1).toFixed(2) );
      $('#TI_reg_hol_ns').val( (parseFloat($('#daily_salary').text()) * 2 * 1.1).toFixed(2) );
      $('#TI_reg_hol_rest_ns').val( (parseFloat($('#daily_salary').text()) * 2.6 * 1.1).toFixed(2)); // <<<<<<<<<
      $('#TI_double_hol_ns').val( (parseFloat($('#daily_salary').text()) * 3 * 1.1).toFixed(2));
      $('#TI_double_hol_rest_ns').val( (parseFloat($('#daily_salary').text()) * 3.9 * 1.1).toFixed(2));

      // Overtime Pay
      $('#TI_reg_ot').val( (parseFloat($('#hourly_salary').text()) * 1.25).toFixed(2) );
      $('#TI_rest_ot').val( (parseFloat($('#hourly_salary').text()) * 1.69).toFixed(2) );
      $('#TI_spec_hol_ot').val( (parseFloat($('#hourly_salary').text()) * 1.69).toFixed(2) );
      $('#TI_spec_hol_rest_ot').val( (parseFloat($('#hourly_salary').text()) * 1.95).toFixed(2) );
      $('#TI_reg_hol_ot').val( (parseFloat($('#hourly_salary').text()) * 2.6).toFixed(2) );
      $('#TI_reg_hol_rest_ot').val((parseFloat($('#hourly_salary').text()) * 3.38).toFixed(2) ); // <<<<<<<<<
      $('#TI_double_hol_ot').val( (parseFloat($('#hourly_salary').text()) * 3.9).toFixed(2) );
      $('#TI_double_hol_rest_ot').val( (parseFloat($('#hourly_salary').text()) * 5.07).toFixed(2) );

      $('#TI_reg_ot_ns').val( (parseFloat($('#hourly_salary').text()) * 1.25 * 1.1).toFixed(2) );
      $('#TI_rest_ot_ns').val( (parseFloat($('#hourly_salary').text()) * 1.69 * 1.1).toFixed(2) );
      $('#TI_spec_hol_ot_ns').val( (parseFloat($('#hourly_salary').text()) * 1.69 * 1.1).toFixed(2));
      $('#TI_spec_hol_rest_ot_ns').val( (parseFloat($('#hourly_salary').text()) * 1.95 * 1.1).toFixed(2) );
      $('#TI_reg_hol_ot_ns').val( (parseFloat($('#hourly_salary').text()) * 2.6 * 1.1).toFixed(2) );
      $('#TI_reg_hol_rest_ot_ns').val( (parseFloat($('#hourly_salary').text()) * 3.38 * 1.1).toFixed(2) ); // <<<<<<<<<
      $('#TI_double_hol_ot_ns').val( (parseFloat($('#hourly_salary').text()) * 3.9 * 1.1).toFixed(2) );
      $('#TI_double_hol_rest_ot_ns').val( (parseFloat($('#hourly_salary').text()) * 5.07 * 1.1).toFixed(2));

      // Absent / Tardiness
      $('#TI_absent').val( parseFloat($('#daily_salary').text()) );
      $('#TI_late_undertime').val( parseFloat($('#hourly_salary').text()) );
    }

    $('#custom_days').keyup(function(){
      computeTI($(this).val());
    })

    computeTI(30,parseFloat($('#work_hours').val()));
    
    // ============================================ TAXABLE INCOME ==========================================
    
    // >>>>>>>> REGULAR

    // URL of Async Function
    var url = "<?= base_url() ?>payroll/getSalaryWitholdingTax";

    // Regular
    $('#TI_reg').keyup(function(element){
      if($('#TI_reg_multiplier').val()){
        var value = $('#TI_reg').val();
        var multiplier = $('#TI_reg_multiplier').val();
        $('#TI_reg_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_reg').on('blur',function(){
      $('#TI_reg').val(parseFloat($('#TI_reg').val()).toFixed(2));  
    })
    $('#TI_reg_multiplier').keyup(function(){
      if($('#TI_reg').val()){
        var value = $('#TI_reg').val();
        var multiplier = $('#TI_reg_multiplier').val();
        $('#TI_reg_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Rest Day
    $('#TI_rest').keyup(function(element){
      if($('#TI_rest_multiplier').val()){
        var value = $('#TI_rest').val();
        var multiplier = $('#TI_rest_multiplier').val();
        $('#TI_rest_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_rest').on('blur',function(){
      $('#TI_rest').val(parseFloat($('#TI_rest').val()).toFixed(2));  
    })
    $('#TI_rest_multiplier').keyup(function(){
      if($('#TI_rest').val()){
        var value = $('#TI_rest').val();
        var multiplier = $('#TI_rest_multiplier').val();
        $('#TI_rest_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Special Holiday
    $('#TI_spec_hol').keyup(function(element){
      if($('#TI_spec_hol_multiplier').val()){
        var value = $('#TI_spec_hol').val();
        var multiplier = $('#TI_spec_hol_multiplier').val();
        $('#TI_spec_hol_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_spec_hol').on('blur',function(){
      $('#TI_spec_hol').val(parseFloat($('#TI_spec_hol').val()).toFixed(2));  
    })
    $('#TI_spec_hol_multiplier').keyup(function(){
      if($('#TI_spec_hol').val()){
        var value = $('#TI_spec_hol').val();
        var multiplier = $('#TI_spec_hol_multiplier').val();
        $('#TI_spec_hol_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Special Holiday + Rest
    $('#TI_spec_hol_rest').keyup(function(element){
      if($('#TI_spec_hol_rest_multiplier').val()){
        var value = $('#TI_spec_hol_rest').val();
        var multiplier = $('#TI_spec_hol_rest_multiplier').val();
        $('#TI_spec_hol_rest_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_spec_hol_rest').on('blur',function(){
      $('#TI_spec_hol_rest').val(parseFloat($('#TI_spec_hol_rest').val()).toFixed(2));  
    })
    $('#TI_spec_hol_rest_multiplier').keyup(function(){
      if($('#TI_spec_hol_rest').val()){
        var value = $('#TI_spec_hol_rest').val();
        var multiplier = $('#TI_spec_hol_rest_multiplier').val();
        $('#TI_spec_hol_rest_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Regular Holiday
    $('#TI_reg_hol').keyup(function(element){
      if($('#TI_reg_hol_multiplier').val()){
        var value = $('#TI_reg_hol').val();
        var multiplier = $('#TI_reg_hol_multiplier').val();
        $('#TI_reg_hol_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_reg_hol').on('blur',function(){
      $('#TI_reg_hol').val(parseFloat($('#TI_reg_hol').val()).toFixed(2));  
    })
    $('#TI_reg_hol_multiplier').keyup(function(){
      if($('#TI_reg_hol').val()){
        var value = $('#TI_reg_hol').val();
        var multiplier = $('#TI_reg_hol_multiplier').val();
        $('#TI_reg_hol_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Regular Holiday + Rest
    $('#TI_reg_hol_rest').keyup(function(element){
      if($('#TI_reg_hol_rest_multiplier').val()){
        var value = $('#TI_reg_hol_rest').val();
        var multiplier = $('#TI_reg_hol_rest_multiplier').val();
        $('#TI_reg_hol_rest_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_reg_hol_rest').on('blur',function(){
      $('#TI_reg_hol_rest').val(parseFloat($('#TI_reg_hol_rest').val()).toFixed(2));  
    })
    $('#TI_reg_hol_rest_multiplier').keyup(function(){
      if($('#TI_reg_hol_rest').val()){
        var value = $('#TI_reg_hol_rest').val();
        var multiplier = $('#TI_reg_hol_rest_multiplier').val();
        $('#TI_reg_hol_rest_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Double Holiday
    $('#TI_double_hol').keyup(function(element){
      if($('#TI_double_hol_multiplier').val()){
        var value = $('#TI_double_hol').val();
        var multiplier = $('#TI_double_hol_multiplier').val();
        $('#TI_double_hol_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_double_hol').on('blur',function(){
      $('#TI_double_hol').val(parseFloat($('#TI_double_hol').val()).toFixed(2));  
    })
    $('#TI_double_hol_multiplier').keyup(function(){
      if($('#TI_double_hol').val()){
        var value = $('#TI_double_hol').val();
        var multiplier = $('#TI_double_hol_multiplier').val();
        $('#TI_double_hol_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })

    // Double Holiday + Rest
    $('#TI_double_hol_rest').keyup(function(element){
      if($('#TI_double_hol_rest_multiplier').val()){
        var value = $('#TI_double_hol_rest').val();
        var multiplier = $('#TI_double_hol_rest_multiplier').val();
        $('#TI_double_hol_rest_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_double_hol_rest').on('blur',function(){
      $('#TI_double_hol_rest').val(parseFloat($('#TI_double_hol_rest').val()).toFixed(2));  
    })
    $('#TI_double_hol_rest_multiplier').keyup(function(){
      if($('#TI_double_hol_rest').val()){
        var value = $('#TI_double_hol_rest').val();
        var multiplier = $('#TI_double_hol_rest_multiplier').val();
        $('#TI_double_hol_rest_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })




    // >>>>>>>> NIGHT SHIFT
    
    // Regular Night Shift
    $('#TI_regular_ns').keyup(function(element){
      if($('#TI_regular_ns_multiplier').val()){
        var value = $('#TI_regular_ns').val();
        var multiplier = $('#TI_regular_ns_multiplier').val();
        $('#TI_regular_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_regular_ns').on('blur',function(){
      $('#TI_regular_ns').val(parseFloat($('#TI_regular_ns').val()).toFixed(2));  
    })
    $('#TI_regular_ns_multiplier').keyup(function(){
      if($('#TI_regular_ns').val()){
        var value = $('#TI_regular_ns').val();
        var multiplier = $('#TI_regular_ns_multiplier').val();
        $('#TI_regular_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Rest Day Night Shift
    $('#TI_rest_ns').keyup(function(element){
      if($('#TI_rest_ns_multiplier').val()){
        var value = $('#TI_rest_ns').val();
        var multiplier = $('#TI_rest_ns_multiplier').val();
        $('#TI_rest_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_rest_ns').on('blur',function(){
      $('#TI_rest_ns').val(parseFloat($('#TI_rest_ns').val()).toFixed(2));  
    })
    $('#TI_rest_ns_multiplier').keyup(function(){
      if($('#TI_rest_ns').val()){
        var value = $('#TI_rest_ns').val();
        var multiplier = $('#TI_rest_ns_multiplier').val();
        $('#TI_rest_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Special Holiday Night Shift
    $('#TI_spec_hol_ns').keyup(function(element){
      if($('#TI_spec_hol_ns_multiplier').val()){
        var value = $('#TI_spec_hol_ns').val();
        var multiplier = $('#TI_spec_hol_ns_multiplier').val();
        $('#TI_spec_hol_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_spec_hol_ns').on('blur',function(){
      $('#TI_spec_hol_ns').val(parseFloat($('#TI_spec_hol_ns').val()).toFixed(2));  
    })
    $('#TI_spec_hol_ns_multiplier').keyup(function(){
      if($('#TI_spec_hol_ns').val()){
        var value = $('#TI_spec_hol_ns').val();
        var multiplier = $('#TI_spec_hol_ns_multiplier').val();
        $('#TI_spec_hol_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Special Holiday Night Shift
    $('#TI_spec_hol_rest_ns').keyup(function(element){
      if($('#TI_spec_hol_rest_ns_multiplier').val()){
        var value = $('#TI_spec_hol_rest_ns').val();
        var multiplier = $('#TI_spec_hol_rest_ns_multiplier').val();
        $('#TI_spec_hol_rest_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_spec_hol_rest_ns').on('blur',function(){
      $('#TI_spec_hol_rest_ns').val(parseFloat($('#TI_spec_hol_rest_ns').val()).toFixed(2));  
    })
    $('#TI_spec_hol_rest_ns_multiplier').keyup(function(){
      if($('#TI_spec_hol_rest_ns').val()){
        var value = $('#TI_spec_hol_rest_ns').val();
        var multiplier = $('#TI_spec_hol_rest_ns_multiplier').val();
        $('#TI_spec_hol_rest_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Regular Holiday Night Shift
    $('#TI_reg_hol_ns').keyup(function(element){
      if($('#TI_reg_hol_ns_multiplier').val()){
        var value = $('#TI_reg_hol_ns').val();
        var multiplier = $('#TI_reg_hol_ns_multiplier').val();
        $('#TI_reg_hol_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_reg_hol_ns').on('blur',function(){
      $('#TI_reg_hol_ns').val(parseFloat($('#TI_reg_hol_ns').val()).toFixed(2));  
    })
    $('#TI_reg_hol_ns_multiplier').keyup(function(){
      if($('#TI_reg_hol_ns').val()){
        var value = $('#TI_reg_hol_ns').val();
        var multiplier = $('#TI_reg_hol_ns_multiplier').val();
        $('#TI_reg_hol_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })

    // Regular Holiday + Rest Night Shift
    $('#TI_reg_hol_rest_ns').keyup(function(element){
      if($('#TI_reg_hol_rest_ns_multiplier').val()){
        var value = $('#TI_reg_hol_rest_ns').val();
        var multiplier = $('#TI_reg_hol_rest_ns_multiplier').val();
        $('#TI_reg_hol_rest_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_reg_hol_rest_ns').on('blur',function(){
      $('#TI_reg_hol_rest_ns').val(parseFloat($('#TI_reg_hol_rest_ns').val()).toFixed(2));  
    })
    $('#TI_reg_hol_rest_ns_multiplier').keyup(function(){
      if($('#TI_reg_hol_rest_ns').val()){
        var value = $('#TI_reg_hol_rest_ns').val();
        var multiplier = $('#TI_reg_hol_rest_ns_multiplier').val();
        $('#TI_reg_hol_rest_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Double Holiday Night Shift
    $('#TI_double_hol_ns').keyup(function(element){
      if($('#TI_double_hol_ns_multiplier').val()){
        var value = $('#TI_double_hol_ns').val();
        var multiplier = $('#TI_double_hol_ns_multiplier').val();
        $('#TI_double_hol_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_double_hol_ns').on('blur',function(){
      $('#TI_double_hol_ns').val(parseFloat($('#TI_double_hol_ns').val()).toFixed(2));  
    })
    $('#TI_double_hol_ns_multiplier').keyup(function(){
      if($('#TI_double_hol_ns').val()){
        var value = $('#TI_double_hol_ns').val();
        var multiplier = $('#TI_double_hol_ns_multiplier').val();
        $('#TI_double_hol_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Double Holiday Night Shift
    $('#TI_double_hol_ns').keyup(function(element){
      if($('#TI_double_hol_ns_multiplier').val()){
        var value = $('#TI_double_hol_ns').val();
        var multiplier = $('#TI_double_hol_ns_multiplier').val();
        $('#TI_double_hol_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_double_hol_ns').on('blur',function(){
      $('#TI_double_hol_ns').val(parseFloat($('#TI_double_hol_ns').val()).toFixed(2));  
    })
    $('#TI_double_hol_ns_multiplier').keyup(function(){
      if($('#TI_double_hol_ns').val()){
        var value = $('#TI_double_hol_ns').val();
        var multiplier = $('#TI_double_hol_ns_multiplier').val();
        $('#TI_double_hol_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Double Holiday + Rest Night Shift
    $('#TI_double_hol_rest_ns').keyup(function(element){
      if($('#TI_double_hol_rest_ns_multiplier').val()){
        var value = $('#TI_double_hol_rest_ns').val();
        var multiplier = $('#TI_double_hol_rest_ns_multiplier').val();
        $('#TI_double_hol_rest_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_double_hol_rest_ns').on('blur',function(){
      $('#TI_double_hol_rest_ns').val(parseFloat($('#TI_double_hol_rest_ns').val()).toFixed(2));  
    })
    $('#TI_double_hol_rest_ns_multiplier').keyup(function(){
      if($('#TI_double_hol_rest_ns').val()){
        var value = $('#TI_double_hol_rest_ns').val();
        var multiplier = $('#TI_double_hol_rest_ns_multiplier').val();
        $('#TI_double_hol_rest_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })















    // >>>>>>>> OVER TIME
    
    // Payroll Type Over Time
    $('#TI_reg_ot').keyup(function(element){
      if($('#TI_reg_ot_multiplier').val()){
        var value = $('#TI_reg_ot').val();
        var multiplier = $('#TI_reg_ot_multiplier').val();
        $('#TI_reg_ot_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_reg_ot').on('blur',function(){
      $('#TI_reg_ot').val(parseFloat($('#TI_reg_ot').val()).toFixed(2));  
    })
    $('#TI_reg_ot_multiplier').keyup(function(){
      if($('#TI_reg_ot').val()){
        var value = $('#TI_reg_ot').val();
        var multiplier = $('#TI_reg_ot_multiplier').val();
        $('#TI_reg_ot_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Rest Day Over Time
    $('#TI_rest_ot').keyup(function(element){
      if($('#TI_rest_ot_multiplier').val()){
        var value = $('#TI_rest_ot').val();
        var multiplier = $('#TI_rest_ot_multiplier').val();
        $('#TI_rest_ot_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_rest_ot').on('blur',function(){
      $('#TI_rest_ot').val(parseFloat($('#TI_rest_ot').val()).toFixed(2));  
    })
    $('#TI_rest_ot_multiplier').keyup(function(){
      if($('#TI_rest_ot').val()){
        var value = $('#TI_rest_ot').val();
        var multiplier = $('#TI_rest_ot_multiplier').val();
        $('#TI_rest_ot_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Special Holiday Over Time
    $('#TI_spec_hol_ot').keyup(function(element){
      if($('#TI_spec_hol_ot_multiplier').val()){
        var value = $('#TI_spec_hol_ot').val();
        var multiplier = $('#TI_spec_hol_ot_multiplier').val();
        $('#TI_spec_hol_ot_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_spec_hol_ot').on('blur',function(){
      $('#TI_spec_hol_ot').val(parseFloat($('#TI_spec_hol_ot').val()).toFixed(2));  
    })
    $('#TI_spec_hol_ot_multiplier').keyup(function(){
      if($('#TI_spec_hol_ot').val()){
        var value = $('#TI_spec_hol_ot').val();
        var multiplier = $('#TI_spec_hol_ot_multiplier').val();
        $('#TI_spec_hol_ot_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Special Holiday + Rest Day Over Time
    $('#TI_spec_hol_rest_ot').keyup(function(element){
      if($('#TI_spec_hol_rest_ot_multiplier').val()){
        var value = $('#TI_spec_hol_rest_ot').val();
        var multiplier = $('#TI_spec_hol_rest_ot_multiplier').val();
        $('#TI_spec_hol_rest_ot_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_spec_hol_rest_ot').on('blur',function(){
      $('#TI_spec_hol_rest_ot').val(parseFloat($('#TI_spec_hol_rest_ot').val()).toFixed(2));  
    })
    $('#TI_spec_hol_rest_ot_multiplier').keyup(function(){
      if($('#TI_spec_hol_rest_ot').val()){
        var value = $('#TI_spec_hol_rest_ot').val();
        var multiplier = $('#TI_spec_hol_rest_ot_multiplier').val();
        $('#TI_spec_hol_rest_ot_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Regular Holiday Over Time
    $('#TI_reg_hol_ot').keyup(function(element){
      if($('#TI_reg_hol_ot_multiplier').val()){
        var value = $('#TI_reg_hol_ot').val();
        var multiplier = $('#TI_reg_hol_ot_multiplier').val();
        $('#TI_reg_hol_ot_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_reg_hol_ot').on('blur',function(){
      $('#TI_reg_hol_ot').val(parseFloat($('#TI_reg_hol_ot').val()).toFixed(2));  
    })
    $('#TI_reg_hol_ot_multiplier').keyup(function(){
      if($('#TI_reg_hol_ot').val()){
        var value = $('#TI_reg_hol_ot').val();
        var multiplier = $('#TI_reg_hol_ot_multiplier').val();
        $('#TI_reg_hol_ot_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Regular Holiday + Rest Over Time
    $('#TI_reg_hol_rest_ot').keyup(function(element){
      if($('#TI_reg_hol_rest_ot_multiplier').val()){
        var value = $('#TI_reg_hol_rest_ot').val();
        var multiplier = $('#TI_reg_hol_rest_ot_multiplier').val();
        $('#TI_reg_hol_rest_ot_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_reg_hol_rest_ot').on('blur',function(){
      $('#TI_reg_hol_rest_ot').val(parseFloat($('#TI_reg_hol_rest_ot').val()).toFixed(2));  
    })
    $('#TI_reg_hol_rest_ot_multiplier').keyup(function(){
      if($('#TI_reg_hol_rest_ot').val()){
        var value = $('#TI_reg_hol_rest_ot').val();
        var multiplier = $('#TI_reg_hol_rest_ot_multiplier').val();
        $('#TI_reg_hol_rest_ot_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Double Holiday Over Time
    $('#TI_double_hol_ot').keyup(function(element){
      if($('#TI_double_hol_ot_multiplier').val()){
        var value = $('#TI_double_hol_ot').val();
        var multiplier = $('#TI_double_hol_ot_multiplier').val();
        $('#TI_double_hol_ot_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_double_hol_ot').on('blur',function(){
      $('#TI_double_hol_ot').val(parseFloat($('#TI_double_hol_ot').val()).toFixed(2));  
    })
    $('#TI_double_hol_ot_multiplier').keyup(function(){
      if($('#TI_double_hol_ot').val()){
        var value = $('#TI_double_hol_ot').val();
        var multiplier = $('#TI_double_hol_ot_multiplier').val();
        $('#TI_double_hol_ot_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Double Holiday + Rest Over Time
    $('#TI_double_hol_rest_ot').keyup(function(element){
      if($('#TI_double_hol_rest_ot_multiplier').val()){
        var value = $('#TI_double_hol_rest_ot').val();
        var multiplier = $('#TI_double_hol_rest_ot_multiplier').val();
        $('#TI_double_hol_rest_ot_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_double_hol_rest_ot').on('blur',function(){
      $('#TI_double_hol_rest_ot').val(parseFloat($('#TI_double_hol_rest_ot').val()).toFixed(2));  
    })
    $('#TI_double_hol_rest_ot_multiplier').keyup(function(){
      if($('#TI_double_hol_rest_ot').val()){
        var value = $('#TI_double_hol_rest_ot').val();
        var multiplier = $('#TI_double_hol_rest_ot_multiplier').val();
        $('#TI_double_hol_rest_ot_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })






    // >>>>>>>> OVER TIME NIGHT SHIFT
    
    // Payroll Type Over Time Night Shift
    $('#TI_reg_ot_ns').keyup(function(element){
      if($('#TI_reg_ot_ns_multiplier').val()){
        var value = $('#TI_reg_ot_ns').val();
        var multiplier = $('#TI_reg_ot_ns_multiplier').val();
        $('#TI_reg_ot_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_reg_ot_ns').on('blur',function(){
      $('#TI_reg_ot_ns').val(parseFloat($('#TI_reg_ot_ns').val()).toFixed(2));  
    })
    $('#TI_reg_ot_ns_multiplier').keyup(function(){
      if($('#TI_reg_ot_ns').val()){
        var value = $('#TI_reg_ot_ns').val();
        var multiplier = $('#TI_reg_ot_ns_multiplier').val();
        $('#TI_reg_ot_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Rest Day Over Time Night Shift
    $('#TI_rest_ot_ns').keyup(function(element){
      if($('#TI_rest_ot_ns_multiplier').val()){
        var value = $('#TI_rest_ot_ns').val();
        var multiplier = $('#TI_rest_ot_ns_multiplier').val();
        $('#TI_rest_ot_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_rest_ot_ns').on('blur',function(){
      $('#TI_rest_ot_ns').val(parseFloat($('#TI_rest_ot_ns').val()).toFixed(2));  
    })
    $('#TI_rest_ot_ns_multiplier').keyup(function(){
      if($('#TI_rest_ot_ns').val()){
        var value = $('#TI_rest_ot_ns').val();
        var multiplier = $('#TI_rest_ot_ns_multiplier').val();
        $('#TI_rest_ot_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Special Holiday Over Time Night Shift
    $('#TI_spec_hol_ot_ns').keyup(function(element){
      if($('#TI_spec_hol_ot_ns_multiplier').val()){
        var value = $('#TI_spec_hol_ot_ns').val();
        var multiplier = $('#TI_spec_hol_ot_ns_multiplier').val();
        $('#TI_spec_hol_ot_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_spec_hol_ot_ns').on('blur',function(){
      $('#TI_spec_hol_ot_ns').val(parseFloat($('#TI_spec_hol_ot_ns').val()).toFixed(2));  
    })
    $('#TI_spec_hol_ot_ns_multiplier').keyup(function(){
      if($('#TI_spec_hol_ot_ns').val()){
        var value = $('#TI_spec_hol_ot_ns').val();
        var multiplier = $('#TI_spec_hol_ot_ns_multiplier').val();
        $('#TI_spec_hol_ot_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Special Holiday Rest Day Over Time Night Shift
    $('#TI_spec_hol_rest_ot_ns').keyup(function(element){
      if($('#TI_spec_hol_rest_ot_ns_multiplier').val()){
        var value = $('#TI_spec_hol_rest_ot_ns').val();
        var multiplier = $('#TI_spec_hol_rest_ot_ns_multiplier').val();
        $('#TI_spec_hol_rest_ot_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_spec_hol_rest_ot_ns').on('blur',function(){
      $('#TI_spec_hol_rest_ot_ns').val(parseFloat($('#TI_spec_hol_rest_ot_ns').val()).toFixed(2));  
    })
    $('#TI_spec_hol_rest_ot_ns_multiplier').keyup(function(){
      if($('#TI_spec_hol_rest_ot_ns').val()){
        var value = $('#TI_spec_hol_rest_ot_ns').val();
        var multiplier = $('#TI_spec_hol_rest_ot_ns_multiplier').val();
        $('#TI_spec_hol_rest_ot_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Regular Holiday Over Time Night Shift
    $('#TI_reg_hol_ot_ns').keyup(function(element){
      if($('#TI_reg_hol_ot_ns_multiplier').val()){
        var value = $('#TI_reg_hol_ot_ns').val();
        var multiplier = $('#TI_reg_hol_ot_ns_multiplier').val();
        $('#TI_reg_hol_ot_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_reg_hol_ot_ns').on('blur',function(){
      $('#TI_reg_hol_ot_ns').val(parseFloat($('#TI_reg_hol_ot_ns').val()).toFixed(2));  
    })
    $('#TI_reg_hol_ot_ns_multiplier').keyup(function(){
      if($('#TI_reg_hol_ot_ns').val()){
        var value = $('#TI_reg_hol_ot_ns').val();
        var multiplier = $('#TI_reg_hol_ot_ns_multiplier').val();
        $('#TI_reg_hol_ot_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Regular Holiday + Rest Over Time Night Shift
    $('#TI_reg_hol_rest_ot_ns').keyup(function(element){
      if($('#TI_reg_hol_rest_ot_ns_multiplier').val()){
        var value = $('#TI_reg_hol_rest_ot_ns').val();
        var multiplier = $('#TI_reg_hol_rest_ot_ns_multiplier').val();
        $('#TI_reg_hol_rest_ot_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_reg_hol_rest_ot_ns').on('blur',function(){
      $('#TI_reg_hol_rest_ot_ns').val(parseFloat($('#TI_reg_hol_rest_ot_ns').val()).toFixed(2));  
    })
    $('#TI_reg_hol_rest_ot_ns_multiplier').keyup(function(){
      if($('#TI_reg_hol_rest_ot_ns').val()){
        var value = $('#TI_reg_hol_rest_ot_ns').val();
        var multiplier = $('#TI_reg_hol_rest_ot_ns_multiplier').val();
        $('#TI_reg_hol_rest_ot_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Double Holiday Over Time Night Shift
    $('#TI_double_hol_ot_ns').keyup(function(element){
      if($('#TI_double_hol_ot_ns_multiplier').val()){
        var value = $('#TI_double_hol_ot_ns').val();
        var multiplier = $('#TI_double_hol_ot_ns_multiplier').val();
        $('#TI_double_hol_ot_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_double_hol_ot_ns').on('blur',function(){
      $('#TI_double_hol_ot_ns').val(parseFloat($('#TI_double_hol_ot_ns').val()).toFixed(2));  
    })
    $('#TI_double_hol_ot_ns_multiplier').keyup(function(){
      if($('#TI_double_hol_ot_ns').val()){
        var value = $('#TI_double_hol_ot_ns').val();
        var multiplier = $('#TI_double_hol_ot_ns_multiplier').val();
        $('#TI_double_hol_ot_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Double Holiday + Rest Over Time Night Shift
    $('#TI_double_hol_rest_ot_ns').keyup(function(element){
      if($('#TI_double_hol_rest_ot_ns_multiplier').val()){
        var value = $('#TI_double_hol_rest_ot_ns').val();
        var multiplier = $('#TI_double_hol_rest_ot_ns_multiplier').val();
        $('#TI_double_hol_rest_ot_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_double_hol_rest_ot_ns').on('blur',function(){
      $('#TI_double_hol_rest_ot_ns').val(parseFloat($('#TI_double_hol_rest_ot_ns').val()).toFixed(2));  
    })
    $('#TI_double_hol_rest_ot_ns_multiplier').keyup(function(){
      if($('#TI_double_hol_rest_ot_ns').val()){
        var value = $('#TI_double_hol_rest_ot_ns').val();
        var multiplier = $('#TI_double_hol_rest_ot_ns_multiplier').val();
        $('#TI_double_hol_rest_ot_ns_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })



    




    // Absent
    $('#TI_absent').keyup(function(element){
      if($('#TI_absent_multiplier').val()){
        var value = $('#TI_absent').val();
        var multiplier = $('#TI_absent_multiplier').val();
        $('#TI_absent_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_absent').on('blur',function(){
      $('#TI_absent').val(parseFloat($('#TI_absent').val()).toFixed(2));  
    })
    $('#TI_absent_multiplier').keyup(function(){
      if($('#TI_absent').val()){
        var value = $('#TI_absent').val();
        var multiplier = $('#TI_absent_multiplier').val();
        $('#TI_absent_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);
        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Late/Undertime
    $('#TI_late_undertime').keyup(function(element){
      if($('#TI_late_undertime_multiplier').val()){
        var value = $('#TI_late_undertime').val();
        var multiplier = $('#TI_late_undertime_multiplier').val();
        $('#TI_late_undertime_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#TI_late_undertime').on('blur',function(){
      $('#TI_late_undertime').val(parseFloat($('#TI_late_undertime').val()).toFixed(2));  
    })
    $('#TI_late_undertime_multiplier').keyup(function(){
      if($('#TI_late_undertime').val()){
        var value = $('#TI_late_undertime').val();
        var multiplier = $('#TI_late_undertime_multiplier').val();
        $('#TI_late_undertime_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_TI = parseFloat(TI_total.toFixed(2));
        var total_OTI = parseFloat($('#OTI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })











































    // ============================================ OTHER TAXABLE INCOME ==========================================
    
    // Other 1
    $('#OTI_other1').keyup(function(element){
      if($('#OTI_other1_multiplier').val()){
        var value = $('#OTI_other1').val();
        var multiplier = $('#OTI_other1_multiplier').val();
        $('#OTI_other1_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_OTI = parseFloat(OTI_total.toFixed(2));
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#OTI_other1').on('blur',function(){
      $('#OTI_other1').val(parseFloat($('#OTI_other1').val()).toFixed(2));  
    })
    $('#OTI_other1_multiplier').keyup(function(){
      if($('#OTI_other1').val()){
        var value = $('#OTI_other1').val();
        var multiplier = $('#OTI_other1_multiplier').val();
        $('#OTI_other1_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_OTI = parseFloat(OTI_total.toFixed(2));
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Other 2
    $('#OTI_other2').keyup(function(element){
      if($('#OTI_other2_multiplier').val()){
        var value = $('#OTI_other2').val();
        var multiplier = $('#OTI_other2_multiplier').val();
        $('#OTI_other2_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_OTI = parseFloat(OTI_total.toFixed(2));
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#OTI_other2').on('blur',function(){
      $('#OTI_other2').val(parseFloat($('#OTI_other2').val()).toFixed(2));  
    })
    $('#OTI_other2_multiplier').keyup(function(){
      if($('#OTI_other2').val()){
        var value = $('#OTI_other2').val();
        var multiplier = $('#OTI_other2_multiplier').val();
        $('#OTI_other2_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_OTI = parseFloat(OTI_total.toFixed(2));
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Other 3
    $('#OTI_other3').keyup(function(element){
      if($('#OTI_other3_multiplier').val()){
        var value = $('#OTI_other3').val();
        var multiplier = $('#OTI_other3_multiplier').val();
        $('#OTI_other3_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_OTI = parseFloat(OTI_total.toFixed(2));
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#OTI_other3').on('blur',function(){
      $('#OTI_other3').val(parseFloat($('#OTI_other3').val()).toFixed(2));  
    })
    $('#OTI_other3_multiplier').keyup(function(){
      if($('#OTI_other3').val()){
        var value = $('#OTI_other3').val();
        var multiplier = $('#OTI_other3_multiplier').val();
        $('#OTI_other3_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_OTI = parseFloat(OTI_total.toFixed(2));
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Other 4
    $('#OTI_other4').keyup(function(element){
      if($('#OTI_other4_multiplier').val()){
        var value = $('#OTI_other4').val();
        var multiplier = $('#OTI_other4_multiplier').val();
        $('#OTI_other4_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_OTI = parseFloat(OTI_total.toFixed(2));
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#OTI_other4').on('blur',function(){
      $('#OTI_other4').val(parseFloat($('#OTI_other4').val()).toFixed(2));  
    })
    $('#OTI_other4_multiplier').keyup(function(){
      if($('#OTI_other4').val()){
        var value = $('#OTI_other4').val();
        var multiplier = $('#OTI_other4_multiplier').val();
        $('#OTI_other4_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_OTI = parseFloat(OTI_total.toFixed(2));
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Other 5
    $('#OTI_other5').keyup(function(element){
      if($('#OTI_other5_multiplier').val()){
        var value = $('#OTI_other5').val();
        var multiplier = $('#OTI_other5_multiplier').val();
        $('#OTI_other5_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_OTI = parseFloat(OTI_total.toFixed(2));
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#OTI_other5').on('blur',function(){
      $('#OTI_other5').val(parseFloat($('#OTI_other5').val()).toFixed(2));  
    })
    $('#OTI_other5_multiplier').keyup(function(){
      if($('#OTI_other5').val()){
        var value = $('#OTI_other5').val();
        var multiplier = $('#OTI_other5_multiplier').val();
        $('#OTI_other5_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_OTI = parseFloat(OTI_total.toFixed(2));
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Other 6
    $('#OTI_other6').keyup(function(element){
      if($('#OTI_other6_multiplier').val()){
        var value = $('#OTI_other6').val();
        var multiplier = $('#OTI_other6_multiplier').val();
        $('#OTI_other6_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_OTI = parseFloat(OTI_total.toFixed(2));
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#OTI_other6').on('blur',function(){
      $('#OTI_other6').val(parseFloat($('#OTI_other6').val()).toFixed(2));  
    })
    $('#OTI_other6_multiplier').keyup(function(){
      if($('#OTI_other6').val()){
        var value = $('#OTI_other6').val();
        var multiplier = $('#OTI_other6_multiplier').val();
        $('#OTI_other6_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_OTI = parseFloat(OTI_total.toFixed(2));
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Other 7
    $('#OTI_other7').keyup(function(element){
      if($('#OTI_other7_multiplier').val()){
        var value = $('#OTI_other7').val();
        var multiplier = $('#OTI_other7_multiplier').val();
        $('#OTI_other7_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_OTI = parseFloat(OTI_total.toFixed(2));
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#OTI_other7').on('blur',function(){
      $('#OTI_other7').val(parseFloat($('#OTI_other7').val()).toFixed(2));  
    })
    $('#OTI_other7_multiplier').keyup(function(){
      if($('#OTI_other7').val()){
        var value = $('#OTI_other7').val();
        var multiplier = $('#OTI_other7_multiplier').val();
        $('#OTI_other7_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_OTI = parseFloat(OTI_total.toFixed(2));
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    
    // Other 7
    $('#OTI_other8').keyup(function(element){
      if($('#OTI_other8_multiplier').val()){
        var value = $('#OTI_other8').val();
        var multiplier = $('#OTI_other8_multiplier').val();
        $('#OTI_other8_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_OTI = parseFloat(OTI_total.toFixed(2));
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })
    $('#OTI_other8').on('blur',function(){
      $('#OTI_other8').val(parseFloat($('#OTI_other8').val()).toFixed(2));  
    })
    $('#OTI_other8_multiplier').keyup(function(){
      if($('#OTI_other8').val()){
        var value = $('#OTI_other8').val();
        var multiplier = $('#OTI_other8_multiplier').val();
        $('#OTI_other8_total').val((value * multiplier).toFixed(2));

        // add all BP total values
        var BP_total_values = [];
        Array.from($('.BP_each_total')).forEach(function(total){
          BP_total_values.push(parseFloat($(total).val()));
        })
        BP_total = BP_total_values.reduce((a, b) => a + b);

        // add all OT total values
        var OT_total_values = [];
        Array.from($('.OT_each_total')).forEach(function(total){
          OT_total_values.push(parseFloat($(total).val()));
        })
        OT_total = OT_total_values.reduce((a, b) => a + b);
        
        // minus absent total values
        var minus_total_values = [];
        Array.from($('.TI_each_total_minus')).forEach(function(total){
          minus_total_values.push(parseFloat($(total).val()));
        })
        minus_TI_total = minus_total_values.reduce((a, b) => a + b);

        // add all total values
        var OTI_total_values = [];
        Array.from($('.OTI_each_total')).forEach(function(total){
          OTI_total_values.push(parseFloat($(total).val()));
        })
        OTI_total = OTI_total_values.reduce((a, b) => a + b);

        TI_total = (BP_total + OT_total + OTI_total) - minus_TI_total;

        $('#total_basic_pay').val(BP_total.toFixed(2));
        $('#total_overtime').val(OT_total.toFixed(2));


        $('#ABS_total').val(minus_TI_total.toFixed(2));
        $('#BP_total').val(BP_total.toFixed(2));
        $('#OT_total').val(OT_total.toFixed(2));
        $('#TI_total').val(TI_total.toFixed(2));
        $('#OTI_total').val(OTI_total.toFixed(2));
        $('#OVR_total_TI').val(TI_total.toFixed(2));
        $('#OVR_total_OTI').val(OTI_total.toFixed(2));

        var total_OTI = parseFloat(OTI_total.toFixed(2));
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat($('#NTI_total').val());
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED;
        var total_GTI = TI_total;
        $('#OVR_total').val(total_OVR.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        $('#GROSS_TAX_total').val(total_GTI.toFixed(2));
        getSalaryWitholdingTax(url,total_GTI).then(data => {
          data.witholding_tax.forEach((x) => {
            var total =  parseFloat(x.fixed) + (parseFloat(total_GTI) - parseFloat(x.c_level)) * ( parseFloat(x.c_percent) / 100);

            document.getElementById('GOV_CONT_with_tax_total').value = total.toFixed(2);
          });
          data.sss.forEach((x) => {
            // gov contributions (employee)
            document.getElementById('GOV_CONT_SSS_total').value = x.ee;
            document.getElementById('GOV_CONT_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_pagibig_total').value = 100;
            // gov contributions (employer)
            document.getElementById('GOV_CONT_EMPLYR_SSS_total').value = x.er;
            document.getElementById('GOV_CONT_EMPLYR_philhealth_total').value = ((parseFloat(total_GTI) * (3.5 / 100))/2).toFixed(2);
            document.getElementById('GOV_CONT_EMPLYR_pagibig_total').value = 100;

            var wth_tax = $('#GOV_CONT_with_tax_total').val();
            var sss = x.ee
            var philhealth = (parseFloat(total_GTI) * (3.5 / 100)) / 2;
            var pagibig = 100;
            var gov_cont_total = parseFloat(wth_tax) + parseFloat(sss) + parseFloat(philhealth) + parseFloat(pagibig);
            $('#GOV_total').val(gov_cont_total.toFixed(2));
            $('#OVR_total_GOV').val(gov_cont_total.toFixed(2));
            $('#OVR_total').val((parseFloat($('#OVR_total').val()) - parseFloat(gov_cont_total.toFixed(2)) - parseFloat($('#LOAN_total').val())).toFixed(2));
          });
        });
        save_to_db();
      }
    })









    // ============================================ NON TAXABLE INCOME ==========================================
    
    // Other 1
    $('#NTI_other1').keyup(function(element){
      if($('#NTI_other1_multiplier').val()){
        var value = $('#NTI_other1').val();
        var multiplier = $('#NTI_other1_multiplier').val();
        $('#NTI_other1_total').val((value * multiplier).toFixed(2));

        // add all total values
        var total_values = [];
        Array.from($('.NTI_each_total')).forEach(function(total){
          total_values.push(parseFloat($(total).val()));
        })
        NTI_total = total_values.reduce((a, b) => a + b);
        $('#NTI_total').val(NTI_total.toFixed(2));
        $('#OVR_total_NTI').val(NTI_total.toFixed(2));

        var total_OTI = parseFloat($('#OTI_total').val());
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat(NTI_total.toFixed(2));
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
        $('#OVR_total').val(total_OVR.toFixed(2));
        save_to_db();
      }
    })
    $('#NTI_other1').on('blur',function(){
      $('#NTI_other1').val(parseFloat($('#NTI_other1').val()).toFixed(2));  
    })
    $('#NTI_other1_multiplier').keyup(function(){
      if($('#NTI_other1').val()){
        var value = $('#NTI_other1').val();
        var multiplier = $('#NTI_other1_multiplier').val();
        $('#NTI_other1_total').val((value * multiplier).toFixed(2));

        // add all total values
        var total_values = [];
        Array.from($('.NTI_each_total')).forEach(function(total){
          total_values.push(parseFloat($(total).val()));
        })
        NTI_total = total_values.reduce((a, b) => a + b);
        $('#NTI_total').val(NTI_total.toFixed(2));
        $('#OVR_total_NTI').val(NTI_total.toFixed(2));

        var total_OTI = parseFloat($('#OTI_total').val());
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat(NTI_total.toFixed(2));
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
        $('#OVR_total').val(total_OVR.toFixed(2));
        save_to_db();
        
      }
    })
    
    // Other 2
    $('#NTI_other2').keyup(function(element){
      if($('#NTI_other2_multiplier').val()){
        var value = $('#NTI_other2').val();
        var multiplier = $('#NTI_other2_multiplier').val();
        $('#NTI_other2_total').val((value * multiplier).toFixed(2));

        // add all total values
        var total_values = [];
        Array.from($('.NTI_each_total')).forEach(function(total){
          total_values.push(parseFloat($(total).val()));
        })
        NTI_total = total_values.reduce((a, b) => a + b);
        $('#NTI_total').val(NTI_total.toFixed(2));
        $('#OVR_total_NTI').val(NTI_total.toFixed(2));

        var total_OTI = parseFloat($('#OTI_total').val());
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat(NTI_total.toFixed(2));
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
        $('#OVR_total').val(total_OVR.toFixed(2));
        save_to_db();
      }
    })
    $('#NTI_other2').on('blur',function(){
      $('#NTI_other2').val(parseFloat($('#NTI_other2').val()).toFixed(2));  
    })
    $('#NTI_other2_multiplier').keyup(function(){
      if($('#NTI_other2').val()){
        var value = $('#NTI_other2').val();
        var multiplier = $('#NTI_other2_multiplier').val();
        $('#NTI_other2_total').val((value * multiplier).toFixed(2));

        // add all total values
        var total_values = [];
        Array.from($('.NTI_each_total')).forEach(function(total){
          total_values.push(parseFloat($(total).val()));
        })
        NTI_total = total_values.reduce((a, b) => a + b);
        $('#NTI_total').val(NTI_total.toFixed(2));
        $('#OVR_total_NTI').val(NTI_total.toFixed(2));

        var total_OTI = parseFloat($('#OTI_total').val());
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat(NTI_total.toFixed(2));
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
        $('#OVR_total').val(total_OVR.toFixed(2));
        save_to_db();
      }
    })
    
    // Other 3
    $('#NTI_other3').keyup(function(element){
      if($('#NTI_other3_multiplier').val()){
        var value = $('#NTI_other3').val();
        var multiplier = $('#NTI_other3_multiplier').val();
        $('#NTI_other3_total').val((value * multiplier).toFixed(2));

        // add all total values
        var total_values = [];
        Array.from($('.NTI_each_total')).forEach(function(total){
          total_values.push(parseFloat($(total).val()));
        })
        NTI_total = total_values.reduce((a, b) => a + b);
        $('#NTI_total').val(NTI_total.toFixed(2));
        $('#OVR_total_NTI').val(NTI_total.toFixed(2));

        var total_OTI = parseFloat($('#OTI_total').val());
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat(NTI_total.toFixed(2));
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
        $('#OVR_total').val(total_OVR.toFixed(2));
        save_to_db();
      }
    })
    $('#NTI_other3').on('blur',function(){
      $('#NTI_other3').val(parseFloat($('#NTI_other3').val()).toFixed(2));  
    })
    $('#NTI_other3_multiplier').keyup(function(){
      if($('#NTI_other3').val()){
        var value = $('#NTI_other3').val();
        var multiplier = $('#NTI_other3_multiplier').val();
        $('#NTI_other3_total').val((value * multiplier).toFixed(2));

        // add all total values
        var total_values = [];
        Array.from($('.NTI_each_total')).forEach(function(total){
          total_values.push(parseFloat($(total).val()));
        })
        NTI_total = total_values.reduce((a, b) => a + b);
        $('#NTI_total').val(NTI_total.toFixed(2));
        $('#OVR_total_NTI').val(NTI_total.toFixed(2));

        var total_OTI = parseFloat($('#OTI_total').val());
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat(NTI_total.toFixed(2));
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
        $('#OVR_total').val(total_OVR.toFixed(2));
        save_to_db();
      }
    })
    
    // Other 4
    $('#NTI_other4').keyup(function(element){
      if($('#NTI_other4_multiplier').val()){
        var value = $('#NTI_other4').val();
        var multiplier = $('#NTI_other4_multiplier').val();
        $('#NTI_other4_total').val((value * multiplier).toFixed(2));

        // add all total values
        var total_values = [];
        Array.from($('.NTI_each_total')).forEach(function(total){
          total_values.push(parseFloat($(total).val()));
        })
        NTI_total = total_values.reduce((a, b) => a + b);
        $('#NTI_total').val(NTI_total.toFixed(2));
        $('#OVR_total_NTI').val(NTI_total.toFixed(2));

        var total_OTI = parseFloat($('#OTI_total').val());
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat(NTI_total.toFixed(2));
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
        $('#OVR_total').val(total_OVR.toFixed(2));
        save_to_db();
      }
    })
    $('#NTI_other4').on('blur',function(){
      $('#NTI_other4').val(parseFloat($('#NTI_other4').val()).toFixed(2));  
    })
    $('#NTI_other4_multiplier').keyup(function(){
      if($('#NTI_other4').val()){
        var value = $('#NTI_other4').val();
        var multiplier = $('#NTI_other4_multiplier').val();
        $('#NTI_other4_total').val((value * multiplier).toFixed(2));

        // add all total values
        var total_values = [];
        Array.from($('.NTI_each_total')).forEach(function(total){
          total_values.push(parseFloat($(total).val()));
        })
        NTI_total = total_values.reduce((a, b) => a + b);
        $('#NTI_total').val(NTI_total.toFixed(2));
        $('#OVR_total_NTI').val(NTI_total.toFixed(2));

        var total_OTI = parseFloat($('#OTI_total').val());
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat(NTI_total.toFixed(2));
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
        $('#OVR_total').val(total_OVR.toFixed(2));
        save_to_db();
      }
    })
    
    // Other 5
    $('#NTI_other5').keyup(function(element){
      if($('#NTI_other5_multiplier').val()){
        var value = $('#NTI_other5').val();
        var multiplier = $('#NTI_other5_multiplier').val();
        $('#NTI_other5_total').val((value * multiplier).toFixed(2));

        // add all total values
        var total_values = [];
        Array.from($('.NTI_each_total')).forEach(function(total){
          total_values.push(parseFloat($(total).val()));
        })
        NTI_total = total_values.reduce((a, b) => a + b);
        $('#NTI_total').val(NTI_total.toFixed(2));
        $('#OVR_total_NTI').val(NTI_total.toFixed(2));

        var total_OTI = parseFloat($('#OTI_total').val());
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat(NTI_total.toFixed(2));
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
        $('#OVR_total').val(total_OVR.toFixed(2));
        save_to_db();
      }
    })
    $('#NTI_other5').on('blur',function(){
      $('#NTI_other5').val(parseFloat($('#NTI_other5').val()).toFixed(2));  
    })
    $('#NTI_other5_multiplier').keyup(function(){
      if($('#NTI_other5').val()){
        var value = $('#NTI_other5').val();
        var multiplier = $('#NTI_other5_multiplier').val();
        $('#NTI_other5_total').val((value * multiplier).toFixed(2));

        // add all total values
        var total_values = [];
        Array.from($('.NTI_each_total')).forEach(function(total){
          total_values.push(parseFloat($(total).val()));
        })
        NTI_total = total_values.reduce((a, b) => a + b);
        $('#NTI_total').val(NTI_total.toFixed(2));
        $('#OVR_total_NTI').val(NTI_total.toFixed(2));

        var total_OTI = parseFloat($('#OTI_total').val());
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat(NTI_total.toFixed(2));
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
        $('#OVR_total').val(total_OVR.toFixed(2));
        save_to_db();
      }
    })
    
    // Other 6
    $('#NTI_other6').keyup(function(element){
      if($('#NTI_other6_multiplier').val()){
        var value = $('#NTI_other6').val();
        var multiplier = $('#NTI_other6_multiplier').val();
        $('#NTI_other6_total').val((value * multiplier).toFixed(2));

        // add all total values
        var total_values = [];
        Array.from($('.NTI_each_total')).forEach(function(total){
          total_values.push(parseFloat($(total).val()));
        })
        NTI_total = total_values.reduce((a, b) => a + b);
        $('#NTI_total').val(NTI_total.toFixed(2));
        $('#OVR_total_NTI').val(NTI_total.toFixed(2));

        var total_OTI = parseFloat($('#OTI_total').val());
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat(NTI_total.toFixed(2));
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
        $('#OVR_total').val(total_OVR.toFixed(2));
        save_to_db();
      }
    })
    $('#NTI_other6').on('blur',function(){
      $('#NTI_other6').val(parseFloat($('#NTI_other6').val()).toFixed(2));  
    })
    $('#NTI_other6_multiplier').keyup(function(){
      if($('#NTI_other6').val()){
        var value = $('#NTI_other6').val();
        var multiplier = $('#NTI_other6_multiplier').val();
        $('#NTI_other6_total').val((value * multiplier).toFixed(2));

        // add all total values
        var total_values = [];
        Array.from($('.NTI_each_total')).forEach(function(total){
          total_values.push(parseFloat($(total).val()));
        })
        NTI_total = total_values.reduce((a, b) => a + b);
        $('#NTI_total').val(NTI_total.toFixed(2));
        $('#OVR_total_NTI').val(NTI_total.toFixed(2));

        var total_OTI = parseFloat($('#OTI_total').val());
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat(NTI_total.toFixed(2));
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
        $('#OVR_total').val(total_OVR.toFixed(2));
        save_to_db();
      }
    })
    
    // Other 7
    $('#NTI_other7').keyup(function(element){
      if($('#NTI_other7_multiplier').val()){
        var value = $('#NTI_other7').val();
        var multiplier = $('#NTI_other7_multiplier').val();
        $('#NTI_other7_total').val((value * multiplier).toFixed(2));

        // add all total values
        var total_values = [];
        Array.from($('.NTI_each_total')).forEach(function(total){
          total_values.push(parseFloat($(total).val()));
        })
        NTI_total = total_values.reduce((a, b) => a + b);
        $('#NTI_total').val(NTI_total.toFixed(2));
        $('#OVR_total_NTI').val(NTI_total.toFixed(2));

        var total_OTI = parseFloat($('#OTI_total').val());
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat(NTI_total.toFixed(2));
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
        $('#OVR_total').val(total_OVR.toFixed(2));
        save_to_db();
      }
    })
    $('#NTI_other7').on('blur',function(){
      $('#NTI_other7').val(parseFloat($('#NTI_other7').val()).toFixed(2));  
    })
    $('#NTI_other7_multiplier').keyup(function(){
      if($('#NTI_other7').val()){
        var value = $('#NTI_other7').val();
        var multiplier = $('#NTI_other7_multiplier').val();
        $('#NTI_other7_total').val((value * multiplier).toFixed(2));

        // add all total values
        var total_values = [];
        Array.from($('.NTI_each_total')).forEach(function(total){
          total_values.push(parseFloat($(total).val()));
        })
        NTI_total = total_values.reduce((a, b) => a + b);
        $('#NTI_total').val(NTI_total.toFixed(2));
        $('#OVR_total_NTI').val(NTI_total.toFixed(2));

        var total_OTI = parseFloat($('#OTI_total').val());
        var total_TI = parseFloat($('#TI_total').val());
        var total_NTI = parseFloat(NTI_total.toFixed(2));
        var total_DED = parseFloat($('#DED_total').val());

        var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
        $('#OVR_total').val(total_OVR.toFixed(2));
        save_to_db();
      }
    })










      // ============================================ DEDUCTIONS ==========================================
      // Salary Advances
      $('#DED_salary_advances').keyup(function(element){
        if($('#DED_salary_advances_multiplier').val()){
          var value = $('#DED_salary_advances').val();
          var multiplier = $('#DED_salary_advances_multiplier').val();
          $('#DED_salary_advances_total').val((value * multiplier).toFixed(2));

          // add all total values
          var total_values = [];
          Array.from($('.DED_each_total')).forEach(function(total){
            total_values.push(parseFloat($(total).val()));
          })
          DED_total = total_values.reduce((a, b) => a + b);
          $('#DED_total').val(DED_total.toFixed(2));
          $('#OVR_total_DED').val(DED_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat(DED_total.toFixed(2));

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
        }
      })
      $('#DED_salary_advances').on('blur',function(){
        $('#DED_salary_advances').val(parseFloat($('#DED_salary_advances').val()).toFixed(2));  
      })
      $('#DED_salary_advances_multiplier').keyup(function(){
        if($('#DED_salary_advances').val()){
          var value = $('#DED_salary_advances').val();
          var multiplier = $('#DED_salary_advances_multiplier').val();
          $('#DED_salary_advances_total').val((value * multiplier).toFixed(2));

          // add all total values
          var total_values = [];
          Array.from($('.DED_each_total')).forEach(function(total){
            total_values.push(parseFloat($(total).val()));
          })
          DED_total = total_values.reduce((a, b) => a + b);
          $('#DED_total').val(DED_total.toFixed(2));
          $('#OVR_total_DED').val(DED_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat(DED_total.toFixed(2));

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
        }
      })

      // Other 1
      $('#DED_other1').keyup(function(element){
        if($('#DED_other1_multiplier').val()){
          var value = $('#DED_other1').val();
          var multiplier = $('#DED_other1_multiplier').val();
          $('#DED_other1_total').val((value * multiplier).toFixed(2));

          // add all total values
          var total_values = [];
          Array.from($('.DED_each_total')).forEach(function(total){
            total_values.push(parseFloat($(total).val()));
          })
          DED_total = total_values.reduce((a, b) => a + b);
          $('#DED_total').val(DED_total.toFixed(2));
          $('#OVR_total_DED').val(DED_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat(DED_total.toFixed(2));

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
        }
      })
      $('#DED_other1').on('blur',function(){
        $('#DED_other1').val(parseFloat($('#DED_other1').val()).toFixed(2));  
      })
      $('#DED_other1_multiplier').keyup(function(){
        if($('#DED_other1').val()){
          var value = $('#DED_other1').val();
          var multiplier = $('#DED_other1_multiplier').val();
          $('#DED_other1_total').val((value * multiplier).toFixed(2));

          // add all total values
          var total_values = [];
          Array.from($('.DED_each_total')).forEach(function(total){
            total_values.push(parseFloat($(total).val()));
          })
          DED_total = total_values.reduce((a, b) => a + b);
          $('#DED_total').val(DED_total.toFixed(2));
          $('#OVR_total_DED').val(DED_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat(DED_total.toFixed(2));

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
        }
      })

      // Other 2
      $('#DED_other2').keyup(function(element){
        if($('#DED_other2_multiplier').val()){
          var value = $('#DED_other2').val();
          var multiplier = $('#DED_other2_multiplier').val();
          $('#DED_other2_total').val((value * multiplier).toFixed(2));

          // add all total values
          var total_values = [];
          Array.from($('.DED_each_total')).forEach(function(total){
            total_values.push(parseFloat($(total).val()));
          })
          DED_total = total_values.reduce((a, b) => a + b);
          $('#DED_total').val(DED_total.toFixed(2));
          $('#OVR_total_DED').val(DED_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat(DED_total.toFixed(2));

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
        }
      })
      $('#DED_other2').on('blur',function(){
        $('#DED_other2').val(parseFloat($('#DED_other2').val()).toFixed(2));  
      })
      $('#DED_other2_multiplier').keyup(function(){
        if($('#DED_other2').val()){
          var value = $('#DED_other2').val();
          var multiplier = $('#DED_other2_multiplier').val();
          $('#DED_other2_total').val((value * multiplier).toFixed(2));

          // add all total values
          var total_values = [];
          Array.from($('.DED_each_total')).forEach(function(total){
            total_values.push(parseFloat($(total).val()));
          })
          DED_total = total_values.reduce((a, b) => a + b);
          $('#DED_total').val(DED_total.toFixed(2));
          $('#OVR_total_DED').val(DED_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat(DED_total.toFixed(2));

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
        }
      })

      // Other 3
      $('#DED_other3').keyup(function(element){
        if($('#DED_other3_multiplier').val()){
          var value = $('#DED_other3').val();
          var multiplier = $('#DED_other3_multiplier').val();
          $('#DED_other3_total').val((value * multiplier).toFixed(2));

          // add all total values
          var total_values = [];
          Array.from($('.DED_each_total')).forEach(function(total){
            total_values.push(parseFloat($(total).val()));
          })
          DED_total = total_values.reduce((a, b) => a + b);
          $('#DED_total').val(DED_total.toFixed(2));
          $('#OVR_total_DED').val(DED_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat(DED_total.toFixed(2));

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
        }
      })
      $('#DED_other3').on('blur',function(){
        $('#DED_other3').val(parseFloat($('#DED_other3').val()).toFixed(2));  
      })
      $('#DED_other3_multiplier').keyup(function(){
        if($('#DED_other3').val()){
          var value = $('#DED_other3').val();
          var multiplier = $('#DED_other3_multiplier').val();
          $('#DED_other3_total').val((value * multiplier).toFixed(2));

          // add all total values
          var total_values = [];
          Array.from($('.DED_each_total')).forEach(function(total){
            total_values.push(parseFloat($(total).val()));
          })
          DED_total = total_values.reduce((a, b) => a + b);
          $('#DED_total').val(DED_total.toFixed(2));
          $('#OVR_total_DED').val(DED_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat(DED_total.toFixed(2));

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
        }
      })

      // Other 4
      $('#DED_other4').keyup(function(element){
        if($('#DED_other4_multiplier').val()){
          var value = $('#DED_other4').val();
          var multiplier = $('#DED_other4_multiplier').val();
          $('#DED_other4_total').val((value * multiplier).toFixed(2));

          // add all total values
          var total_values = [];
          Array.from($('.DED_each_total')).forEach(function(total){
            total_values.push(parseFloat($(total).val()));
          })
          DED_total = total_values.reduce((a, b) => a + b);
          $('#DED_total').val(DED_total.toFixed(2));
          $('#OVR_total_DED').val(DED_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat(DED_total.toFixed(2));

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
        }
      })
      $('#DED_other4').on('blur',function(){
        $('#DED_other4').val(parseFloat($('#DED_other4').val()).toFixed(2));  
      })
      $('#DED_other4_multiplier').keyup(function(){
        if($('#DED_other4').val()){
          var value = $('#DED_other4').val();
          var multiplier = $('#DED_other4_multiplier').val();
          $('#DED_other4_total').val((value * multiplier).toFixed(2));

          // add all total values
          var total_values = [];
          Array.from($('.DED_each_total')).forEach(function(total){
            total_values.push(parseFloat($(total).val()));
          })
          DED_total = total_values.reduce((a, b) => a + b);
          $('#DED_total').val(DED_total.toFixed(2));
          $('#OVR_total_DED').val(DED_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat(DED_total.toFixed(2));

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
        }
      })

      // Other 5
      $('#DED_other5').keyup(function(element){
        if($('#DED_other5_multiplier').val()){
          var value = $('#DED_other5').val();
          var multiplier = $('#DED_other5_multiplier').val();
          $('#DED_other5_total').val((value * multiplier).toFixed(2));

          // add all total values
          var total_values = [];
          Array.from($('.DED_each_total')).forEach(function(total){
            total_values.push(parseFloat($(total).val()));
          })
          DED_total = total_values.reduce((a, b) => a + b);
          $('#DED_total').val(DED_total.toFixed(2));
          $('#OVR_total_DED').val(DED_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat(DED_total.toFixed(2));

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
        }
      })
      $('#DED_other5').on('blur',function(){
        $('#DED_other5').val(parseFloat($('#DED_other5').val()).toFixed(2));  
      })
      $('#DED_other5_multiplier').keyup(function(){
        if($('#DED_other5').val()){
          var value = $('#DED_other5').val();
          var multiplier = $('#DED_other5_multiplier').val();
          $('#DED_other5_total').val((value * multiplier).toFixed(2));

          // add all total values
          var total_values = [];
          Array.from($('.DED_each_total')).forEach(function(total){
            total_values.push(parseFloat($(total).val()));
          })
          DED_total = total_values.reduce((a, b) => a + b);
          $('#DED_total').val(DED_total.toFixed(2));
          $('#OVR_total_DED').val(DED_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat(DED_total.toFixed(2));

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - parseFloat($('#LOAN_total').val());
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
        }
      })


















      // ============================================ LOANS ==========================================

      // SSS SALARY LOAN
      $('#LOAN_SSS_salary_loan_total').keyup(function(){
          // add all total values
          var total_values = [];
          Array.from($('.LOAN_each_total')).forEach(function(total){
            if($(total).val()){
              total_values.push(parseFloat($(total).val()));
            }
          })
          LOAN_total = total_values.reduce((a, b) => a + b);
          $('#LOAN_total').val(LOAN_total.toFixed(2));
          $('#OVR_total_LOAN').val(LOAN_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat($('#DED_total').val());

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - LOAN_total.toFixed(2);
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
      })

      // SSS CALAMITY LOAN
      $('#LOAN_SSS_calamity_loan_total').keyup(function(){
          // add all total values
          var total_values = [];
          Array.from($('.LOAN_each_total')).forEach(function(total){
            if($(total).val()){
              total_values.push(parseFloat($(total).val()));
            }
          })
          LOAN_total = total_values.reduce((a, b) => a + b);
          $('#LOAN_total').val(LOAN_total.toFixed(2));
          $('#OVR_total_LOAN').val(LOAN_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat($('#DED_total').val());

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - LOAN_total.toFixed(2);
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
      })

      // HDMF SALARY LOAN
      $('#LOAN_HDMF_salary_loan_total').keyup(function(){
          // add all total values
          var total_values = [];
          Array.from($('.LOAN_each_total')).forEach(function(total){
            if($(total).val()){
              total_values.push(parseFloat($(total).val()));
            }
          })
          LOAN_total = total_values.reduce((a, b) => a + b);
          $('#LOAN_total').val(LOAN_total.toFixed(2));
          $('#OVR_total_LOAN').val(LOAN_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat($('#DED_total').val());

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - LOAN_total.toFixed(2);
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
      })

      // HDMF CALAMITY LOAN
      $('#LOAN_HDMF_calamity_loan_total').keyup(function(){
          // add all total values
          var total_values = [];
          Array.from($('.LOAN_each_total')).forEach(function(total){
            if($(total).val()){
              total_values.push(parseFloat($(total).val()));
            }
          })
          LOAN_total = total_values.reduce((a, b) => a + b);
          $('#LOAN_total').val(LOAN_total.toFixed(2));
          $('#OVR_total_LOAN').val(LOAN_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat($('#DED_total').val());

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - LOAN_total.toFixed(2);
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
      })

      // COMPANY LOAN
      $('#LOAN_company_loan_total').keyup(function(){
          // add all total values
          var total_values = [];
          Array.from($('.LOAN_each_total')).forEach(function(total){
            if($(total).val()){
              total_values.push(parseFloat($(total).val()));
            }
          })
          LOAN_total = total_values.reduce((a, b) => a + b);
          $('#LOAN_total').val(LOAN_total.toFixed(2));
          $('#OVR_total_LOAN').val(LOAN_total.toFixed(2));

          var total_OTI = parseFloat($('#OTI_total').val());
          var total_TI = parseFloat($('#TI_total').val());
          var total_NTI = parseFloat($('#NTI_total').val());
          var total_DED = parseFloat($('#DED_total').val());

          var total_OVR = (total_TI + total_NTI) - total_DED - parseFloat($('#GOV_total').val()) - LOAN_total.toFixed(2);
          $('#OVR_total').val(total_OVR.toFixed(2));
          save_to_db();
      })

      


























      // Quick and simple export target #table_id into a csv
      $('#btn_export_empl_info').click(function(){
          var table_id = 'tbl_payroll';
          var separator = ',';

          // Select rows from table_id
          var rows = document.querySelectorAll('table#' + table_id + ' tr');
          // Construct csv
          var csv = [];
          for (var i = 0; i < rows.length; i++) {
              var row = [], cols = rows[i].querySelectorAll('td, th');
              for (var j = 0; j < cols.length; j++) {
                  // Clean innertext to remove multiple spaces and jumpline (break csv)
                  var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
                  // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
                  data = data.replace(/"/g, '""');
                  // Push escaped string
                  row.push('"' + data + '"');
              }
              csv.push(row.join(separator));
          }
          var csv_string = csv.join('\n');


          // Download it
          var filename = 'Export_Employee_Data.csv';
          var link = document.createElement('a');
          link.style.display = 'none';
          link.setAttribute('target', '_blank');
          link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
          link.setAttribute('download', filename);
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
      })











      async function getSalaryWitholdingTax(url,salary) {
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
      




  




      
  })
</script>
</body>
</html>
