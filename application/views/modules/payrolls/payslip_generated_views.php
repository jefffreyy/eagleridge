<html>
<?php $this->load->view('templates/css_link'); ?>

<style>
  input[type=checkbox] {
    accent-color: green;
  }
</style>

<body>
  <div class="content-wrapper">
    <div class="p-3">
      <div class="flex-fill">

        <div class="row pr-3 mb-2">
          <div class="col-md-4">
            <h1 class="page-title"><a href="<?= base_url() . 'payrolls/payroll_status'; ?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Generated Payslip
            </h1>
          </div>
          <div class="col-md-8 pt-1 button-title" style="padding: 0px; margin: 0px">
            <button class="btn btn-info  text-white ml-3 mb-2" id="btn_submit_payslip_generated"><i class="fa-duotone fa-pen-to-square"></i>&nbsp; Update </button>
           <!-- <button class="btn btn-info  text-white ml-3 mb-2" id="btn_insert_payroll_data"><i class="fas fa-receipt"></i>&nbsp; Generate Payslip </button> -->
          </div>
        </div>
        <!-- Title Header Line -->
        <hr>
        <div class="row justify-content-md-center">
          <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 ">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="d-flex ml-1">
                      <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:150px;">Cut-off Period: </p>
                      <input type="text" name="salary_rate" id="salary_rate" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value="<?= $DISP_PERIOD; ?>">
                    </div>
                    <div class="d-flex ml-1">
                      <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:150px;">Employee ID: </p>
                      <input type="text" name="salary_rate" id="salary_rate" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value="<?= $DISP_EMPLOYEE->col_empl_cmid . ' - ' . $DISP_EMPLOYEE->col_last_name . ', ' . $DISP_EMPLOYEE->col_frst_name; ?>">
                    </div>
                    <!-- <div class="d-flex ml-1">
                      <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:150px;">Connected Period: </p>
                      <input type="text" name="integrated_cutoff_period" id="integrated_cutoff_period" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value=<?= $DISP_CONN_PERIOD ?>>
                    </div> -->
                    <div class="d-flex ml-1">
                      <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:150px;">Payroll Type: </p>
                      <input type="text" name="salary_rate" id="salary_rate" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value="Semi-Monthly">
                    </div>
                    <div class="d-flex ml-1">
                      <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:150px;">Salary Type: </p>
                      <input type="text" name="salary_type" id="salary_type" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value="<?= $INITIAL_SALARY_TYPE ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="d-flex ml-1">
                      <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:150px;">Salary: </p>
                      <input type="text" name="salary_rate" id="salary_rate" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value="<?= $INITIAL_SALARY_RATE ?>">
                    </div>
                    <div class="d-flex ml-1">
                      <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:150px;">Work Rate: </p>
                      <input type="text" name="salary_rate" id="salary_rate" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value="313 Days">
                    </div>
                    <div class="d-flex ml-1">
                      <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:150px;">Daily Salary: </p>
                      <input type="text" name="daily_salary" id="daily_salary" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value="<?= $INITIAL_DAILY_RATE; ?>">
                    </div>
                    <div class="d-flex ml-1">
                      <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:150px;">Hourly Salary: </p>
                      <input type="text" name="hourly_salary" id="hourly_salary" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value="<?= $INITIAL_HOURLY_RATE; ?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php
        $en_sss       = $EN_SSS;
        $en_phil      = $EN_PHIL;
        $en_pagibig   = $EN_PAGIBIG;
        $en_wtax      = $EN_WTAX;
        $en_ti        = $EN_TI;
        $en_nti       = $EN_NTI;
        //  $en_td        = $EN_TD;
        //  $en_ntd       = $EN_NTD;
        $en_loan      = $EN_LOAN;
        $en_absut      = $EN_ABSUT;
        ?>


        <div class="row justify-content-md-center">
          <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 ">
            <div class="card">
              <div class="card-body">
                <div class="row">

                  <div class="col-4">

                    <div style="display: flex;" <?= ($PAYROLL_CONTRIBUTION->chk_sss == 1 || $PAYROLL_CONTRIBUTION->chk_sss == null) ? "hidden" : ""; ?>>
                      <input type="checkbox" class="form-control mx-2" id="cb_sss" name="cb_sss" value="<?= $en_sss ?>" style="width: 20px; height: 20px; font-size: 13px; color:green;" <?= ($en_sss == 0) ? 'checked' : ""; ?> disabled>
                      <label for="cb_sss" class="mr-4"> SSS Contribution</label><br>
                    </div>

                    <div style="display: flex;" <?= ($PAYROLL_CONTRIBUTION->chk_philhealth == 1 || $PAYROLL_CONTRIBUTION->chk_philhealth == null) ? "hidden" : ""; ?>>
                      <input type="checkbox" class="form-control mx-2" id="cb_phil" name="cb_phil" value="<?= $en_phil ?>" style="width: 20px; height:20px; font-size: 13px;" <?= ($en_phil == 0) ? 'checked' : ""; ?> disabled>
                      <label for="cb_phil" class="mr-4"> Philhealth Contribution</label><br>
                    </div>
                    <div style="display: flex;" <?= ($PAYROLL_CONTRIBUTION->chk_pagibig == 1 || $PAYROLL_CONTRIBUTION->chk_pagibig == null) ? "hidden" : ""; ?>>
                      <input type="checkbox" class="form-control mx-2" id="cb_pagibig" name="cb_pagibig" value="<?= $en_pagibig ?>" style="width: 20px; height:20px; font-size: 13px;" <?= ($en_pagibig == 0) ? 'checked' : ""; ?> disabled>
                      <label for="cb_pagibig" class="mr-4"> Pag-ibig Contribution</label><br>
                    </div>
                    <div style="display: flex;" <?= ($PAYROLL_CONTRIBUTION->chk_withholding == 1 || $PAYROLL_CONTRIBUTION->chk_withholding == null) ? "hidden" : ""; ?>>
                      <input type="checkbox" class="form-control mx-2" id="cb_wtax" name="cb_wtax" value="<?= $en_wtax ?>" style="width: 20px; height:20px; font-size: 13px;" <?= ($en_wtax == 0) ? 'checked' : ""; ?> disabled>
                      <label for="cb_wtax" class="mr-4"> Withholding Tax</label><br>
                    </div>
                  </div>
                  <div class="col-4">
                    <div style="display: flex;" <?= ($PAYROLL_CONTRIBUTION->chk_taxable == 1 || $PAYROLL_CONTRIBUTION->chk_taxable == null) ? "hidden" : ""; ?>>
                      <input type="checkbox" class="form-control mx-2" id="cb_ti" name="cb_ti" value="<?= $en_ti ?>" style="width: 20px; height:20px; font-size: 13px;" <?= ($en_ti == 0) ? 'checked' : ""; ?> disabled>
                      <label for="cb_ti" class="mr-4"> Taxable Allowance</label><br>
                    </div>

                    <div style="display: flex;" <?= ($PAYROLL_CONTRIBUTION->chk_nontaxable == 1 || $PAYROLL_CONTRIBUTION->chk_nontaxable == null) ? "hidden" : ""; ?>>
                      <input type="checkbox" class="form-control mx-2" id="cb_nti" name="cb_nti" value="<?= $en_nti ?>" style="width: 20px; height:20px; font-size: 13px;" <?= ($en_nti == 0) ? 'checked' : ""; ?> disabled>
                      <label for="cb_nti" class="mr-4"> Non-Taxable Allowance</label><br>
                    </div>

                  </div>
                  <div class="col-4">
                    <div style="display: flex;" <?= ($PAYROLL_CONTRIBUTION->chk_loan_deduction == 1 || $PAYROLL_CONTRIBUTION->chk_loan_deduction == null) ? "hidden" : ""; ?>>
                      <input type="checkbox" class="form-control mx-2" id="cb_loans" name="cb_loans" value="<?= $en_loan ?>" style="width: 20px; height:20px; font-size: 13px;" <?= ($en_loan == 0) ? 'checked' : ""; ?> disabled>
                      <label for="cb_loans" class="mr-4">Loans/CA/Deductions</label><br>
                    </div>
                    <div style="display: flex;" <?= ($PAYROLL_CONTRIBUTION->chk_tardiness == 1 || $PAYROLL_CONTRIBUTION->chk_tardiness == null) ? "hidden" : ""; ?>>
                      <input type="checkbox" class="form-control mx-2" id="cb_absut" name="cb_absut" value="<?= $en_absut ?>" style="width: 20px; height:20px; font-size: 13px;" <?= ($en_absut == 0) ? 'checked' : ""; ?> disabled>
                      <label for="cb_absut" class="mr-4">Tardiness</label><br>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>

        <!-- start of Form -->
        <form action="<?php echo base_url(); ?>payrolls/edit_payslip_generated" id="form_edit_payslip" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">

          <div class="row justify-content-md-center">
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
              <!-- <p class="text-bold mb-2" style="font-size: 20px;">Taxable Income</p> -->
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
              <p class="text-bold mb-2" style="font-size: 20px;">Taxable Income</p>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
              <!-- <p class="text-bold mb-2" style="font-size: 20px;">Taxable Income</p> -->
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
              <div class="card" style="padding: 0px !important">
                <div class="card-body p-0" style="padding: 0px !important">
                  <table class="table table-bordered table-sm text-center">
                    <thead>
                      <tr>
                        <th colspan="7">Basic and Overtime Pay</th>
                      </tr>
                      <tr>
                        <th width="20%">Name</th>
                        <th width="20%">Rate</th>
                        <th width="20%">Multiplier</th>
                        <th width="20%">Count</th>
                        <th width="20%">Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr <?php echo ($INITIAL_SALARY_TYPE == "Daily" ? "hidden" : "") ?>>
                        <td style="text-align: left;">Basic Pay</td>
                        <td style="text-align: right;"><?= $INITIAL_SALARY_RATE ?></td>
                        <td style="text-align: right;">-</td>
                        <td style="text-align: right;">-</td>
                        <td style="text-align: right;"><?= $TOT_PRESENT ?></td>
                      </tr>
                      <tr <?php echo ($TOT_PAID_LEAVE == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Paid Leaves</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_PAID_LEAVE ?></td>
                        <td style="text-align: right;"><?= $COUNT_PAID_LEAVE ?></td>
                        <td style="text-align: right;"><?= $TOT_PAID_LEAVE ?></td>
                      </tr>

                      <tr <?php echo ($TOT_REG_HOURS == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Regular REG HR</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_REG_HOURS ?></td>
                        <td style="text-align: right;"><?= $COUNT_REG_HOURS ?></td>
                        <td style="text-align: right;"><?= $TOT_REG_HOURS ?></td>
                      </tr>
                      <tr <?php echo ($TOT_REG_OT == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Regular REG OT</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_REG_OT ?></td>
                        <td style="text-align: right;"><?= $COUNT_REG_OT ?></td>
                        <td style="text-align: right;"><?= $TOT_REG_OT ?></td>
                      </tr>
                      <tr <?php echo ($TOT_REG_ND == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Regular ND</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_REG_ND ?></td>
                        <td style="text-align: right;"><?= $COUNT_REG_ND ?></td>
                        <td style="text-align: right;"><?= $TOT_REG_ND ?></td>
                      </tr>
                      <tr <?php echo ($TOT_REG_NDOT == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Regular NDOT</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_REG_NDOT ?></td>
                        <td style="text-align: right;"><?= $COUNT_REG_NDOT ?></td>
                        <td style="text-align: right;"><?= $TOT_REG_NDOT ?></td>
                      </tr>
                      <tr <?php echo ($TOT_REST_HOURS == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Rest REG HR</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_REST_HOURS ?></td>
                        <td style="text-align: right;"><?= $COUNT_REST_HOURS ?></td>
                        <td style="text-align: right;"><?= $TOT_REST_HOURS ?></td>
                      </tr>
                      <tr <?php echo ($TOT_REST_OT == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Rest REG OT</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_REST_OT ?></td>
                        <td style="text-align: right;"><?= $COUNT_REST_OT ?></td>
                        <td style="text-align: right;"><?= $TOT_REST_OT ?></td>
                      </tr>
                      <tr <?php echo ($TOT_REST_ND == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Rest ND</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_REST_ND ?></td>
                        <td style="text-align: right;"><?= $COUNT_REST_ND ?></td>
                        <td style="text-align: right;"><?= $TOT_REST_ND ?></td>
                      </tr>
                      <tr <?php echo ($TOT_REST_NDOT == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Rest NDOT</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_REST_NDOT ?></td>
                        <td style="text-align: right;"><?= $COUNT_REST_NDOT ?></td>
                        <td style="text-align: right;"><?= $TOT_REST_NDOT ?></td>
                      </tr>
                      <tr <?php echo ($TOT_LEG_HOURS == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Legal REG HR</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_LEG_HOURS ?></td>
                        <td style="text-align: right;"><?= $COUNT_LEG_HOURS ?></td>
                        <td style="text-align: right;"><?= $TOT_LEG_HOURS ?></td>
                      </tr>
                      <tr <?php echo ($TOT_LEG_OT == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Legal REG OT</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_LEG_OT ?></td>
                        <td style="text-align: right;"><?= $COUNT_LEG_OT ?></td>
                        <td style="text-align: right;"><?= $TOT_LEG_OT ?></td>
                      </tr>
                      <tr <?php echo ($TOT_LEG_ND == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Legal ND</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_LEG_ND ?></td>
                        <td style="text-align: right;"><?= $COUNT_LEG_ND ?></td>
                        <td style="text-align: right;"><?= $TOT_LEG_ND ?></td>
                      </tr>
                      <tr <?php echo ($TOT_LEG_NDOT == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Legal NDOT</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_LEG_NDOT ?></td>
                        <td style="text-align: right;"><?= $COUNT_LEG_NDOT ?></td>
                        <td style="text-align: right;"><?= $TOT_LEG_NDOT ?></td>
                      </tr>
                      <tr <?php echo ($TOT_LEGREST_HOURS == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Legal Rest REG HR</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_LEGREST_HOURS ?></td>
                        <td style="text-align: right;"><?= $COUNT_LEGREST_HOURS ?></td>
                        <td style="text-align: right;"><?= $TOT_LEGREST_HOURS ?></td>
                      </tr>
                      <tr <?php echo ($TOT_LEGREST_OT == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Legal Rest REG OT</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_LEGREST_OT ?></td>
                        <td style="text-align: right;"><?= $COUNT_LEGREST_OT ?></td>
                        <td style="text-align: right;"><?= $TOT_LEGREST_OT ?></td>
                      </tr>
                      <tr <?php echo ($TOT_LEGREST_ND == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Legal Rest ND</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_LEGREST_ND ?></td>
                        <td style="text-align: right;"><?= $COUNT_LEGREST_ND ?></td>
                        <td style="text-align: right;"><?= $TOT_LEGREST_ND ?></td>
                      </tr>
                      <tr <?php echo ($TOT_LEGREST_NDOT == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Legal Rest NDOT</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_LEGREST_NDOT ?></td>
                        <td style="text-align: right;"><?= $COUNT_LEGREST_NDOT ?></td>
                        <td style="text-align: right;"><?= $TOT_LEGREST_NDOT ?></td>
                      </tr>
                      <tr <?php echo ($TOT_SPE_HOURS == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Special REG HR</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_SPE_HOURS ?></td>
                        <td style="text-align: right;"><?= $COUNT_SPE_HOURS ?></td>
                        <td style="text-align: right;"><?= $TOT_SPE_HOURS ?></td>
                      </tr>
                      <tr <?php echo ($TOT_SPE_OT == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Special REG OT</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_SPE_OT ?></td>
                        <td style="text-align: right;"><?= $COUNT_SPE_OT ?></td>
                        <td style="text-align: right;"><?= $TOT_SPE_OT ?></td>
                      </tr>
                      <tr <?php echo ($TOT_SPE_ND == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Special ND</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_SPE_ND ?></td>
                        <td style="text-align: right;"><?= $COUNT_SPE_ND ?></td>
                        <td style="text-align: right;"><?= $TOT_SPE_ND ?></td>
                      </tr>
                      <tr <?php echo ($TOT_SPE_NDOT == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Special NDOT</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_SPE_NDOT ?></td>
                        <td style="text-align: right;"><?= $COUNT_SPE_NDOT ?></td>
                        <td style="text-align: right;"><?= $TOT_SPE_NDOT ?></td>
                      </tr>
                      <tr <?php echo ($TOT_SPEREST_HOURS == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Special Rest REG HR</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_SPEREST_HOURS ?></td>
                        <td style="text-align: right;"><?= $COUNT_SPEREST_HOURS  ?></td>
                        <td style="text-align: right;"><?= $TOT_SPEREST_HOURS ?></td>
                      </tr>
                      <tr <?php echo ($TOT_SPEREST_OT == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Special Rest REG OT</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_SPEREST_OT ?></td>
                        <td style="text-align: right;"><?= $COUNT_SPEREST_OT ?></td>
                        <td style="text-align: right;"><?= $TOT_SPEREST_OT ?></td>
                      </tr>
                      <tr <?php echo ($TOT_SPEREST_ND == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Special Rest ND</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_SPEREST_ND ?></td>
                        <td style="text-align: right;"><?= $COUNT_SPEREST_ND ?></td>
                        <td style="text-align: right;"><?= $TOT_SPEREST_ND ?></td>
                      </tr>
                      <tr <?php echo ($TOT_SPEREST_NDOT == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Special Rest NDOT</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_SPEREST_NDOT ?></td>
                        <td style="text-align: right;"><?= $COUNT_SPEREST_NDOT ?></td>
                        <td style="text-align: right;"><?= $TOT_SPEREST_NDOT ?></td>
                      </tr>
                      <tr>
                        <th colspan="4" style="text-align: right;">Total</td>
                        <td style="text-align: right;"><?= $BASIC_PAY ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
              <div class="card" style="padding: 0px !important">
                <div class="card-body p-0" style="padding: 0px !important">
                  <table class="table table-bordered table-sm text-center">
                    <thead>
                      <tr>
                        <th colspan="7">Absences/Tardiness/Undertime</th>
                      </tr>
                      <tr>
                        <th width="20%">Name</th>
                        <th width="20%">Rate</th>
                        <th width="20%">Multiplier</th>
                        <th width="20%">Count</th>
                        <th width="20%">Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>

                      <tr <?php echo ($TOT_ABSENT == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Absences</td>
                        <td style="text-align: right;"><?= $INITIAL_DAILY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_ABSENT ?></td>
                        <td style="text-align: right;"><?= $COUNT_ABSENT ?></td>
                        <td>&nbsp;<?= $TOT_ABSENT ?></td>
                      </tr>
                      <tr <?php echo ($TOT_TARDINESS == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Tardiness</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_TARDINESS ?></td>
                        <td style="text-align: right;"><?= $COUNT_TARDINESS ?></td>
                        <td style="text-align: right;">&nbsp;<?= $TOT_TARDINESS ?></td>
                      </tr>
                      <tr <?php echo ($TOT_UNDERTIME == 0 ? "hidden" : "") ?>>
                        <td style="text-align: left;">Undertime</td>
                        <td style="text-align: right;"><?= $INITIAL_HOURLY_RATE ?></td>
                        <td style="text-align: right;"><?= $MUL_UNDERTIME ?></td>
                        <td style="text-align: right;"><?= $COUNT_UNDERTIME ?></td>
                        <td style="text-align: right;">&nbsp;<?= $TOT_UNDERTIME ?></td>
                      </tr>

                      <tr>
                        <th colspan="4" style="text-align: right;">Total</td>
                        <td style="text-align: right;">(-)&nbsp;<?= $BASIC_DEDUCTION ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-6 col-sm-6 col-md-6 col-lg-8 col-xl-8">
              <div class="card" style="padding: 0px !important">
                <div class="card-body p-0" style="padding: 0px !important">
                  <table class="table table-bordered table-sm text-center">
                    <thead>
                      <tr>
                        <th colspan="7">Taxable Allowances</th>
                      </tr>
                      <tr>
                        <th width="20%">Name</th>
                        <th width="40%">Value</th>
                        <th width="20%">Count</th>
                        <th width="20%">Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($DISP_TAX_ALLOWANCE as $DISP_TAX_ALLOWANCE_ROW) { ?>
                        <tr <?php echo ($DISP_TAX_ALLOWANCE_ROW->value == 0 ? "hidden" : "") ?>>
                          <td style="text-align: left;"><?= $DISP_TAX_ALLOWANCE_ROW->name ?></td>
                          <input type="hidden" name="TAX_ALLOWANCE_EMPL_ID[]" value="<?= $DISP_TAX_ALLOWANCE_ROW->empl_id ?>" style="width: 100%; padding:0; height:25px" class="form-control"> 
                          <input type="hidden" name="TAX_ALLOWANCE_NAME[]" value="<?= $DISP_TAX_ALLOWANCE_ROW->id ?>" style="width: 100%; padding:0; height:25px" class="form-control"> 
                          <td style="text-align: right;"><input type="number" step="0.01" name="TAX_ALLOWANCE_VAL[]" value="<?= number_format((float)str_replace(',', '', $DISP_TAX_ALLOWANCE_ROW->value), 2, '.', '') ?>" style="width: 100%; padding:0; height:25px" class="form-control"> </td>
                          <td style="text-align: right;"><?= $DISP_TAX_ALLOWANCE_ROW->count ?></td>
                          <td style="text-align: right;"><?= $DISP_TAX_ALLOWANCE_ROW->subtotal ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                      <tr>
                        <th colspan="3" style="text-align: right;">Total</td>
                        <td style='text-align: right;'><?= $DISP_TAX_ALLOWANCE_TOTAL ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- <div class="card" style="padding: 0px !important">
              <div class="card-body p-0" style="padding: 0px !important">
                <table class="table table-bordered table-sm text-center">
                  <thead>
                    <tr>
                      <th colspan="7">Adjustments</th>
                    </tr>
                    <tr>
                      <th>Name</th>
                      <th>Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($DISP_ADJUSTMENTS as $DISP_ADJUSTMENTS_ROW) { ?>
                      <tr>
                        <td><?= $DISP_ADJUSTMENTS_ROW->name ?></td>
                        <td>
                          <div>0.00</div>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                    <tr>
                      <th colspan="1">Total</td>
                      <td>0.00</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div> -->
            </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
              <p class="text-bold mb-2" style="font-size: 20px;">Non-taxable Allowance</p>
            </div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-8 col-xl-8">
              <div class="card" style="padding: 0px !important">
                <div class="card-body p-0" style="padding: 0px !important">
                  <table class="table table-bordered table-sm text-center">
                    <thead>
                      <tr>
                        <th colspan="7">Non-Taxable Allowances</th>
                      </tr>
                      <tr>
                        <th width="20%">Name</th>
                        <th width="40%">Value</th>
                        <th width="20%">Count</th>
                        <th width="20%">Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($DISP_NONTAX_ALLOWANCE as $DISP_NONTAX_ALLOWANCE_ROW) { ?>
                        <!-- <tr> -->
                        <tr <?php echo ($DISP_NONTAX_ALLOWANCE_ROW->value == 0 ? "hidden" : "") ?>>
                          <td style="text-align: left;"><?= $DISP_NONTAX_ALLOWANCE_ROW->name ?></td>
                          <!-- <td style="text-align: right;"><?= $DISP_NONTAX_ALLOWANCE_ROW->value ?></td> -->

                          <input type="hidden" name="NONTAX_ALLOWANCE_EMPL_ID[]" value="<?= $DISP_NONTAX_ALLOWANCE_ROW->empl_id ?>" style="width: 100%; padding:0; height:25px" class="form-control"> 
                          <input type="hidden" name="NONTAX_ALLOWANCE_NAME[]" value="<?= $DISP_NONTAX_ALLOWANCE_ROW->id ?>" style="width: 100%; padding:0; height:25px" class="form-control"> 
                          <td style="text-align: right;"><input type="number" step="0.01" name="NONTAX_ALLOWANCE_VAL[]" value="<?= number_format((float)str_replace(',', '', $DISP_NONTAX_ALLOWANCE_ROW->value), 2, '.', '') ?>" style="width: 100%; padding:0; height:25px" class="form-control"> </td>
                          
                          <td style="text-align: right;"><?= $DISP_NONTAX_ALLOWANCE_ROW->count ?></td>
                          <td style="text-align: right;"><?= $DISP_NONTAX_ALLOWANCE_ROW->subtotal ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                      <tr>
                        <th colspan="3" style="text-align: right;">Total</td>
                        <td style='text-align: right' ;><?= $DISP_NONTAX_ALLOWANCE_TOTAL ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>



            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
              <div class="card" style="padding: 0px !important">
                <div class="card-body p-0" style="padding: 0px !important">
                  <table class="table table-bordered table-sm text-center">
                    <thead>
                      <tr>
                        <th width="80%" style="text-align: right;">Gross Income&nbsp;&nbsp;</th>
                        <th width="20%" style="background-color: white !important; text-align: right;"><?= $GROSS_INCOME ?></th>
                      </tr>
                      <!-- <tr>
                      <th width="80%" style="text-align: right;">Taxable Income&nbsp;&nbsp;</th>
                      <th width="20%" style="background-color: white !important; text-align: right;"><?= $TAXABLE_INCOME ?></th>
                    </tr>
                    <tr>
                      <th width="80%" style="text-align: right;"> Withholding Tax&nbsp;&nbsp;</th>
                      <th width="20%" <?php echo ($en_wtax  == 0) ? "style = 'text-align: right;background-color: #FF0000'" : "style = 'text-align: right; background-color: white'"; ?>><?= $WTAX ?></th>
                    </tr> -->
                      <!-- <tr <?php echo ($DISP_CONN_PERIOD_1 == "0") ? "hidden" : "" ?>>
                      <th width="80%" style="text-align: right;"><?= $DISP_CONN_PERIOD_1_NAME ?>&nbsp;&nbsp;</th>
                      <th width="20%" style="background-color: white !important; text-align: right;"><?= $GROSS_INCOME_PREV_1 ?></th>
                    </tr>
                    <tr <?php echo ($DISP_CONN_PERIOD_2 == "0") ? "hidden" : "" ?>>
                      <th width="80%" style="text-align: right;"><?= $DISP_CONN_PERIOD_2_NAME ?>&nbsp;&nbsp;</th>
                      <th width="20%" style="background-color: white !important; text-align: right;"><?= $GROSS_INCOME_PREV_2 ?></th>
                    </tr>
                    <tr <?php echo ($DISP_CONN_PERIOD_3 == "0") ? "hidden" : "" ?>>
                      <th width="80%" style="text-align: right;"><?= $DISP_CONN_PERIOD_3_NAME ?>&nbsp;&nbsp;</th>
                      <th width="20%" style="background-color: white !important; text-align: right;"><?= $GROSS_INCOME_PREV_3 ?></th>
                    </tr>
                    <tr <?php echo ($DISP_CONN_PERIOD_4 == "0") ? "hidden" : "" ?>>
                      <th width="80%" style="text-align: right;"><?= $DISP_CONN_PERIOD_4_NAME ?>&nbsp;&nbsp;</th>
                      <th width="20%" style="background-color: white !important; text-align: right;"><?= $GROSS_INCOME_PREV_4 ?></th>
                    </tr>
                    <tr <?php echo ($DISP_CONN_PERIOD_5 == "0") ? "hidden" : "" ?>>
                      <th width="80%" style="text-align: right;"><?= $DISP_CONN_PERIOD_5_NAME ?>&nbsp;&nbsp;</th>
                      <th width="20%" style="background-color: white !important; text-align: right;"><?= $GROSS_INCOME_PREV_5 ?></th>
                    </tr>
                    <tr>
                      <th width="80%" style="text-align: right;"> Combined Taxable Income&nbsp;&nbsp;</th>
                      <th width="20%" style="background-color: white !important; text-align: right;"><?= $GROSS_INCOME_TOTAL ?></th>
                    </tr> -->
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <hr>

          <div class="row justify-content-md-center">

          </div>

          <div class="row justify-content-md-center">
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
              <p class="text-bold mb-2" style="font-size: 20px;">Contributions</p>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
              <p class="text-bold mb-2" style="font-size: 20px;">Withholding Tax</p>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
            </div>
            <div class="col-8 col-sm-8 col-md-8 col-lg-4 col-xl-4">
              <div class="card" style="padding: 0px !important">
                <div class="card-body p-0" style="padding: 0px !important">
                  <table class="table table-bordered table-sm text-center">
                    <thead>
                      <!-- <tr>
                      <th colspan="7">Employee Contributions</th>
                    </tr> -->
                      <tr>
                        <th width="40%">Item</th>
                        <th width="20%">SSS</th>
                        <th width="20%">Pagibig</th>
                        <th width="20%">Philhealth</th>
                        <!-- <th>Total</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td style="text-align: left;">Combined</td>
                        <td style="text-align: right;">
                          <input type="number" name="SSS_EE_TOTAL" value="<?= $SSS_EE_TOTAL ?>" style="width: 100%; padding:0; height:25px" class="form-control">
                        </td>
                        <td style="text-align: right;">
                          <input type="number" name="PAGIBIG_EE_TOTAL" value="<?= $PAGIBIG_EE_TOTAL ?>" style="width: 100%; padding:0; height:25px" class="form-control">
                        </td>
                        <td style="text-align: right;">
                          <input type="number" name="PHILHEALTH_EE_TOTAL" value="<?= $PHILHEALTH_EE_TOTAL ?>" style="width: 100%; padding:0; height:25px" class="form-control">
                        </td>

                        <!-- <td><?= $TOTAL_EE_TOTAL ?></td> -->
                      </tr>
                      <tr <?php echo ($DISP_CONN_PERIOD_1 == "0") ? "hidden" : "" ?>>
                        <td style="text-align: left;"><?= $DISP_CONN_PERIOD_1_NAME ?></td>
                        <td style="text-align: right;"><?= $SSS_EE_PREVIOUS_1 ?></td>
                        <td style="text-align: right;"><?= $PAGIBIG_EE_PREVIOUS_1 ?></td>
                        <td style="text-align: right;"><?= $PHILHEALTH_EE_PREVIOUS_1 ?></td>
                        <!-- <td><?= $TOTAL_EE_PREVIOUS_1 ?></td> -->
                      </tr>
                      <tr <?php echo ($DISP_CONN_PERIOD_2 == "0") ? "hidden" : "" ?>>
                        <td style="text-align: left;"><?= $DISP_CONN_PERIOD_2_NAME ?></td>
                        <td style="text-align: right;"><?= $SSS_EE_PREVIOUS_2 ?></td>
                        <td style="text-align: right;"><?= $PAGIBIG_EE_PREVIOUS_2 ?></td>
                        <td style="text-align: right;"><?= $PHILHEALTH_EE_PREVIOUS_2 ?></td>
                        <!-- <td><?= $TOTAL_EE_PREVIOUS_2 ?></td> -->
                      </tr>
                      <tr <?php echo ($DISP_CONN_PERIOD_3 == "0") ? "hidden" : "" ?>>
                        <td style="text-align: left;"><?= $DISP_CONN_PERIOD_3_NAME ?></td>
                        <td style="text-align: right;"><?= $SSS_EE_PREVIOUS_3 ?></td>
                        <td style="text-align: right;"><?= $PAGIBIG_EE_PREVIOUS_3 ?></td>
                        <td style="text-align: right;"><?= $PHILHEALTH_EE_PREVIOUS_3 ?></td>
                        <!-- <td><?= $TOTAL_EE_PREVIOUS_3 ?></td> -->
                      </tr>
                      <tr <?php echo ($DISP_CONN_PERIOD_4 == "0") ? "hidden" : "" ?>>
                        <td style="text-align: left;"><?= $DISP_CONN_PERIOD_4_NAME ?></td>
                        <td style="text-align: right;"><?= $SSS_EE_PREVIOUS_4 ?></td>
                        <td style="text-align: right;"><?= $PAGIBIG_EE_PREVIOUS_4 ?></td>
                        <td style="text-align: right;"><?= $PHILHEALTH_EE_PREVIOUS_4 ?></td>
                        <!-- <td><?= $TOTAL_EE_PREVIOUS_4 ?></td> -->
                      </tr>
                      <tr <?php echo ($DISP_CONN_PERIOD_5 == "0") ? "hidden" : "" ?>>
                        <td style="text-align: left;"><?= $DISP_CONN_PERIOD_5_NAME ?></td>
                        <td style="text-align: right;"><?= $SSS_EE_PREVIOUS_5 ?></td>
                        <td style="text-align: right;"><?= $PAGIBIG_EE_PREVIOUS_5 ?></td>
                        <td style="text-align: right;"><?= $PHILHEALTH_EE_PREVIOUS_5 ?></td>
                        <!-- <td><?= $TOTAL_EE_PREVIOUS_5 ?></td> -->
                      </tr>
                      <tr>
                        <td style="text-align: left;">Current</td>
                        <td style="text-align: right;"><?= $SSS_EE_CURRENT ?></td>
                        <td style="text-align: right;"><?= $PAGIBIG_EE_CURRENT ?></td>
                        <td style="text-align: right;"><?= $PHILHEALTH_EE_CURRENT ?></td>
                        <!-- <td><?= $TOTAL_EE_CURRENT ?></td> -->
                      </tr>
                      <tr>
                        <th colspan="3" style="text-align: right;">Total&nbsp;&nbsp;</th>
                        <th style="background-color: white !important; text-align: right;">(-)&nbsp;<?= $TOTAL_EE_CURRENT ?></th>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-8 col-sm-8 col-md-8 col-lg-4 col-xl-4">
              <div class="card" style="padding: 0px !important">
                <div class="card-body p-0" style="padding: 0px !important">
                  <table class="table table-bordered table-sm text-center">
                    <thead>

                      <tr>
                        <th width="80%" style="text-align: right;">Taxable Income&nbsp;&nbsp;</th>
                        <th width="20%" style="background-color: white !important; text-align: right;"><?= $TAXABLE_INCOME ?></th>
                      </tr>
                      <tr>
                        <th width="80%" style="text-align: right;"> Withholding Tax&nbsp;&nbsp;</th>
                        <th width="20%" style='text-align: right'><?= $WTAX ?></th>
                      </tr>

                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          
        </form> <!-- end of Form -->
        <hr>
        <div class="row justify-content-md-center">
          <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
            <p class="text-bold mb-2" style="font-size: 20px;">Loans/Cash Advance/Deductions</p>
          </div>
          <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
            <div class="card" style="padding: 0px !important">
              <div class="card-body p-0" style="padding: 0px !important">
                <table class="table table-bordered table-sm text-center">
                  <thead>
                    <tr>
                      <th width="20%">Type</th>
                      <th width="20%">ID</th>
                      <th width="40%">Name</th>
                      <th width="20%">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($DISP_LOAN as $DISP_LOAN_ROW) { ?>
                      <tr>
                        <td style="text-align: left;">Loans</td>
                        <td style="text-align: left;"><?= $DISP_LOAN_ROW->id ?></td>
                        <td style="text-align: left;"><?= $DISP_LOAN_ROW->loan_name ?></td>
                        <td style="text-align: right;"><?= $DISP_LOAN_ROW->contrib  ?></td>
                      </tr>
                    <?php
                    }
                    ?>
                    <?php foreach ($DISP_CA as $DISP_CA_ROW) { ?>
                      <tr>
                        <td style="text-align: left;">Cash Advance</td>
                        <td style="text-align: left;"><?= $DISP_CA_ROW->id ?></td>
                        <td style="text-align: left;"><?= $DISP_CA_ROW->loan_name ?></td>
                        <td style="text-align: right;"><?= $DISP_CA_ROW->contrib  ?></td>
                      </tr>
                    <?php
                    }
                    ?>
                    <?php foreach ($DISP_DEDUCT as $DISP_DEDUCT_ROW) { ?>
                      <tr>
                        <td style="text-align: left;">Deductions</td>
                        <td style="text-align: left;"><?= $DISP_DEDUCT_ROW->id ?></td>
                        <td style="text-align: left;"><?= $DISP_DEDUCT_ROW->loan_name ?></td>
                        <td style="text-align: right;"><?= $DISP_DEDUCT_ROW->contrib  ?></td>
                      </tr>
                    <?php
                    }
                    ?>
                    <tr>
                      <th colspan="3" style="text-align: right;">Total&nbsp;&nbsp;</th>
                      <th style='text-align: right'>(-)&nbsp;<?= $DISP_LOANCADED_TOTAL ?></th>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- <div class="card" style="padding: 0px !important">
  <div class="card-body p-0" style="padding: 0px !important">
    <table class="table table-bordered table-sm text-center">
      <thead>
        <tr>
          <th width="70%" style="text-align: right;"> Total&nbsp;&nbsp;</th>
          <th width="30%" <?php echo ($en_loan == 0) ? "style = 'text-align: right;background-color: #FF0000'" : "style = 'text-align: right; background-color: white'"; ?>><?= $DISP_LOANCADED_TOTAL ?></th>
        </tr>
      </thead>
    </table>
  </div>
</div> -->
          </div>
          <!-- <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4">
            <div class="card" style="padding: 0px !important">
              <div class="card-body p-0" style="padding: 0px !important">
                <table class="table table-bordered table-sm text-center">
                  <thead>
                    <tr>
                      <th colspan="7">Employer Contributions</th>
                    </tr>
                    <tr>
                      <th>Item</th>
                      <th>SSS</th>
                      <th>SSS&nbsp;EC</th>
                      <th>Pagibig</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Combined</td>
                      <td><?= $SSS_ER_TOTAL ?></td>
                      <td><?= $SSS_EC_ER_TOTAL ?></td>
                      <td><?= $PAGIBIG_ER_TOTAL ?></td>
                      <td><?= $PHILHEALTH_ER_TOTAL ?></td>
                    </tr>
                    <tr <?php echo ($DISP_CONN_PERIOD_1 == "0") ? "hidden" : "" ?>>
                      <td><?= $DISP_CONN_PERIOD_1_NAME ?></td>
                      <td><?= $SSS_ER_PREVIOUS_1 ?></td>
                      <td><?= $SSS_EC_ER_PREVIOUS_1 ?></td>
                      <td><?= $PAGIBIG_ER_PREVIOUS_1 ?></td>
                      <td><?= $PHILHEALTH_ER_PREVIOUS_1 ?></td>
                    </tr>
                    <tr <?php echo ($DISP_CONN_PERIOD_2 == "0") ? "hidden" : "" ?>>
                      <td><?= $DISP_CONN_PERIOD_2_NAME ?></td>
                      <td><?= $SSS_ER_PREVIOUS_2 ?></td>
                      <td><?= $SSS_EC_ER_PREVIOUS_2 ?></td>
                      <td><?= $PAGIBIG_ER_PREVIOUS_2 ?></td>
                      <td><?= $PHILHEALTH_ER_PREVIOUS_2 ?></td>
                    </tr>
                    <tr <?php echo ($DISP_CONN_PERIOD_3 == "0") ? "hidden" : "" ?>>
                      <td><?= $DISP_CONN_PERIOD_3_NAME ?></td>
                      <td><?= $SSS_ER_PREVIOUS_3 ?></td>
                      <td><?= $SSS_EC_ER_PREVIOUS_3 ?></td>
                      <td><?= $PAGIBIG_ER_PREVIOUS_3 ?></td>
                      <td><?= $PHILHEALTH_ER_PREVIOUS_3 ?></td>
                    </tr>
                    <tr <?php echo ($DISP_CONN_PERIOD_4 == "0") ? "hidden" : "" ?>>
                      <td><?= $DISP_CONN_PERIOD_4_NAME ?></td>
                      <td><?= $SSS_ER_PREVIOUS_4 ?></td>
                      <td><?= $SSS_EC_ER_PREVIOUS_4 ?></td>
                      <td><?= $PAGIBIG_ER_PREVIOUS_4 ?></td>
                      <td><?= $PHILHEALTH_ER_PREVIOUS_4 ?></td>
                    </tr>
                    <tr <?php echo ($DISP_CONN_PERIOD_5 == "0") ? "hidden" : "" ?>>
                      <td><?= $DISP_CONN_PERIOD_5_NAME ?></td>
                      <td><?= $SSS_ER_PREVIOUS_5 ?></td>
                      <td><?= $SSS_EC_ER_PREVIOUS_5 ?></td>
                      <td><?= $PAGIBIG_ER_PREVIOUS_5 ?></td>
                      <td><?= $PHILHEALTH_ER_PREVIOUS_5 ?></td>
                    </tr>
                    <tr>
                      <td>Current</td>
                      <td><?= $SSS_ER_CURRENT ?></td>
                      <td><?= $SSS_EC_ER_CURRENT ?></td>
                      <td><?= $PAGIBIG_ER_CURRENT ?></td>
                      <td><?= $PHILHEALTH_ER_CURRENT ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div> -->
        </div>
        <hr>
        <div class="row justify-content-md-center">
          <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
            <p class="text-bold mb-2" style="font-size: 20px;">Net Income</p>
          </div>
        </div>
        <div class="row justify-content-md-center">
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4">
            <div class="card" style="padding: 0px !important">
              <div class="card-body p-0" style="padding: 0px !important">
                <table class="table table-bordered table-sm text-center">
                  <thead>
                    <tr>
                      <th colspan="7">Earnings</th>
                    </tr>
                    <tr>
                      <th>Item</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="text-align: left;">Basic Pay + OT</td>
                      <td style="text-align: right;"><?= $BASIC_PAY ?></td>
                    </tr>
                    <tr>
                      <td style="text-align: left;">Taxable Income</td>
                      <td style="text-align: right;"><?= $DISP_TAX_ALLOWANCE_TOTAL ?></td>
                    </tr>
                    <tr>
                      <td style="text-align: left;">Non-Taxable Income</td>
                      <td style="text-align: right;"><?= $DISP_NONTAX_ALLOWANCE_TOTAL ?></td>
                    </tr>
                    <tr>
                      <td style="text-align: left;">Adjustments</td>
                      <td style="text-align: right;">0.00</td>
                    </tr>
                    <tr>
                      <th style="text-align: left;">Total Earnings</td>
                      <th style="text-align: right;"><?= $EARNINGS ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4">
            <div class="card" style="padding: 0px !important">
              <div class="card-body p-0" style="padding: 0px !important">
                <table class="table table-bordered table-sm text-center">
                  <thead>
                    <tr>
                      <th colspan="7">Deductions</th>
                    </tr>
                    <tr>
                      <th>Item</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="text-align: left;">Absences/Tardiness/Undertime</td>
                      <td style="text-align: right;"><?= $BASIC_DEDUCTION ?></td>
                    </tr>
                    <tr>
                      <td style="text-align: left;">Withholding Tax</td>
                      <td style="text-align: right;"><?= $WTAX ?></td>
                    </tr>
                    <tr>
                      <td style="text-align: left;">Government Contributions</td>
                      <td style="text-align: right;"><?= $TOTAL_EE_CURRENT ?></td>
                    </tr>
                    <tr>
                      <td style="text-align: left;">Loans/Cash Advances/Deductions</td>
                      <td style='text-align: right;'><?= $DISP_LOANCADED_TOTAL ?></td>
                    </tr>
                    <tr>
                      <td style="text-align: left;">Adjustments</td>
                      <td style="text-align: right;">0.00</td>
                    </tr>
                    <tr>
                      <th style="text-align: left;">Total Deductions</td>
                      <th style="text-align: right;"><?= $DEDUCTIONS ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
            <div class="card" style="padding: 0px !important">
              <div class="card-body p-0" style="padding: 0px !important">
                <table class="table table-bordered table-sm text-center">
                  <thead>
                    <tr>
                      <th width="80%" style="text-align: right;">Net Income&nbsp;&nbsp;</th>
                      <th width="20%" style="background-color: white !important; text-align: right;"><?= $NET_INCOME ?></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- Allowances Group            -->
        <!-- <hr>
        <p class="text-bold mb-2" style="font-size: 20px;">Allowances</p>
        <div class="row justify-content-md-center">
          <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
            <div class="card" style="padding: 0px !important">
              <div class="card-body p-0" style="padding: 0px !important">
                <table class="table table-bordered table-sm text-center">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Rate</th>
                      <th>Multiplier</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>A Allowance</td>
                      <td>100.00</td>
                      <td>3</td>
                      <td>300.00</td>
                    </tr>
                    <tr>
                      <td>B Allowance</td>
                      <td></td>
                      <td></td>
                      <td>27.0</td>
                    </tr>
                    <tr>
                      <th colspan="3">Total</th>
                      <td>27.0</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
            <div class="card" style="padding: 0px !important">
              <div class="card-body p-0" style="padding: 0px !important">
                <table class="table table-bordered table-sm text-center">
                  <thead>
                    <tr>
                      <th width="70%" style="text-align: right;">Total Allowances&nbsp;&nbsp;</th>
                      <th width="30%" style="background-color: white !important; text-align: right;"><?= $GROSS_INCOME ?></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div> -->
        <!-- Total Taxable Income Group            -->
        <!-- <hr> -->
        <!-- <p class="text-bold mb-2" style="font-size: 20px;">Total Taxable Income</p>
        <div class="row justify-content-md-center">
          <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
            <div class="card" style="padding: 0px !important">
              <div class="card-body p-0" style="padding: 0px !important">
                <table class="table table-bordered table-sm text-center">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Rate</th>
                      <th>Multiplier</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>A Allowance</td>
                      <td>100.00</td>
                      <td>3</td>
                      <td>300.00</td>
                    </tr>
                    <tr>
                      <td>B Allowance</td>
                      <td></td>
                      <td></td>
                      <td>27.0</td>
                    </tr>
                    <tr>
                      <th colspan="3">Total</th>
                      <td>27.0</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
            <div class="card" style="padding: 0px !important">
              <div class="card-body p-0" style="padding: 0px !important">
                <table class="table table-bordered table-sm text-center">
                  <thead>
                    <tr>
                      <th width="70%" style="text-align: right;">Total Gross&nbsp;&nbsp;</th>
                      <td width="30%" style="background-color: white !important; text-align: right;">(+) <?= $GROSS_INCOME ?></td>
                    </tr>
                    <tr>
                      <th width="70%" style="text-align: right;">Total Contribution&nbsp;&nbsp;</th>
                      <td width="30%" style="background-color: white !important; text-align: right;">(-) <?= $GROSS_INCOME ?></td>
                    </tr>
                    <tr>
                      <th width="70%" style="text-align: right;">Total Allowances&nbsp;&nbsp;</th>
                      <td width="30%" style="background-color: white !important; text-align: right;">(+) <?= $GROSS_INCOME ?></td>
                    </tr>
                    <tr>
                      <th width="70%" style="text-align: right;">Total Taxable Allowance&nbsp;&nbsp;</th>
                      <td width="30%" style="background-color: white !important; text-align: right;"><?= $GROSS_INCOME ?></td>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <div class="card" style="padding: 0px !important">
              <div class="card-body p-0" style="padding: 0px !important">
                <table class="table table-bordered table-sm text-center">
                  <thead>
                    <tr>
                      <th width="70%" style="text-align: right;">Withholding Tax</th>
                      <th width="30%" style="background-color: white !important; text-align: right;"><?= $GROSS_INCOME ?></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div> -->
        <!-- Loans Income Group            -->
        <!-- <hr>
        <p class="text-bold mb-2" style="font-size: 20px;">Loans</p>
        <div class="row justify-content-md-center">
          <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
            <div class="card" style="padding: 0px !important">
              <div class="card-body p-0" style="padding: 0px !important">
                <table class="table table-bordered table-sm text-center">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Rate</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>SSS Salary</td>
                      <td>100.00</td>
                    </tr>
                    <tr>
                      <td>SSS Calamity</td>
                      <td>127.0</td>
                    </tr>
                    <tr>
                      <td>Pagibig Salary</td>
                      <td>200.00</td>
                    </tr>
                    <tr>
                      <td>Pagibig Calamity</td>
                      <td>227.0</td>
                    </tr>
                    <tr>
                      <th>Total</th>
                      <td>227.0</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr> -->
        <!-- ./row -->
        <!-- <hr>
      <p class="text-bold mb-2" style="font-size: 20px;">Non-Taxable </p>
      <div class="row">
        <div class="col-md-6">
          <div class="card" style="height: 372px;">
            <div class="card-body">
              <p class="text-bold mb-2">Loans</p>
              <div class="d-flex ml-1">
                <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">SSS Salary Loan: </p>
                <input type="number" class="form-control ml-2 text-right flex-fill LOAN_each_total" style="width: 110px; font-size: 13px;" value="0" id="LOAN_SSS_salary_loan_total" disabled>
              </div>
              <div class="d-flex ml-1">
                <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">SSS Calamity Loan: </p>
                <input type="number" class="form-control ml-2 text-right flex-fill LOAN_each_total" style="width: 110px; font-size: 13px;" value="0" id="LOAN_SSS_calamity_loan_total" disabled>
              </div>
              <div class="d-flex ml-1">
                <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Pagibig Salary Loan: </p>
                <input type="number" class="form-control ml-2 text-right flex-fill LOAN_each_total" style="width: 110px; font-size: 13px;" value="0" id="LOAN_HDMF_salary_loan_total" disabled>
              </div>
              <div class="d-flex ml-1">
                <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Pagibig Calamity Loan: </p>
                <input type="number" class="form-control ml-2 text-right flex-fill LOAN_each_total" style="width: 110px; font-size: 13px;" value="0" id="LOAN_HDMF_calamity_loan_total" disabled>
              </div>
              <div class="d-flex ml-1">
                <p class="text-right mb-3 mt-1" style="font-size: 14px;width:150px;">Emergency Loan: </p>
                <input type="number" class="form-control ml-2 text-right flex-fill LOAN_each_total" style="width: 110px; font-size: 13px;" value="0" id="LOAN_company_loan_total" disabled>
              </div>
              <br>
              <div class="d-flex ml-1" style="margin-top: 43px;">
                <p class="text-right mb-3 mt-1 flex-fill text-bold" style="font-size: 14px;">Total Loans: </p>
                <input type="number" class="form-control ml-1 text-right" style="width: 190px;" value="0" id="LOAN_total" disabled>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <p class="text-bold mb-2">Tax Refund / Deduction </p>
              <div class="d-flex ml-1">
                <p class="text-right mb-3 mt-1" style="font-size: 14px;width:130px;">Tax Refund/Dec Tax WH: </p>
                <input type="number" class="form-control ml-2 text-right flex-fill DED_each_total" style="width: 110px; font-size: 13px;" value="0" id="DED_tax_refund" disabled>
              </div>
              <div class="d-flex ml-1">
                <p class="text-right mb-3 mt-1" style="font-size: 14px;width:130px;color: red">Salary Advances: </p>
                <input type="number" class="form-control ml-2 text-right flex-fill DED_each_total" style="width: 110px; font-size: 13px;" value="0" id="DED_salary_advances" disabled>
              </div>
              <div class="d-flex ml-1">
                <p class="text-right mb-3 mt-1" style="font-size: 14px;width:130px;color: red">Uniform Deduction: </p>
                <input type="number" class="form-control ml-2 text-right flex-fill DED_each_total" style="width: 110px; font-size: 13px;" value="0" id="DED_uniform_deduction" disabled>
              </div>
              <br>
              <div class="d-flex ml-1" style="margin-top: 23px;">
                <p class="text-right mb-3 mt-1 flex-fill text-bold" style="font-size: 14px;width:280px;">Total Deductions: </p>
                <input type="text" class="form-control ml-1 text-right" style="width: 190px;" value="0" id="DED_total" disabled>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="d-flex ml-1">
                <p class="text-right text-bold mb-3 mt-1" style="font-size: 14px;width:130px;">SIL 2021: </p>
                <input type="number" class="form-control ml-2 text-right flex-fill" style="width: 110px; font-size: 13px;" value="0" id="TI_sil_2022" disabled>
              </div>
            </div>
          </div>
        </div>
      </div> -->
        <!-- <p class="text-bold mb-2" style="font-size: 20px;">Net Income</p>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
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
                <div class="col-md-6">
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
          </div>
        </div>
      </div> -->
      </div>
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
              <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
      <script>
        $(document).ready(function() {
          // URL of Async Function
          var base_url = '<?= base_url(); ?>';
          $('input[name="empl_id"]').val($('#select_employee').val());
          $('input[name="payroll_period"]').val($('#cutoff_period').val());
          $('#btn_insert_payroll_data').click(function() {
            // save_to_db();
            Swal.fire({
              title: 'Generate payslip for this employee?',
              text: 'You may want to review the calculations before proceeding.',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                // alert($('input[name="cutoff_period"]').val());
                $('#form_insert_data').submit();
              }
            })
          })
          $('#calculate').click(function() {
            update_calc_manual();
          })

          function toDisplay(num) {
            num = parseFloat(num).toFixed(4);
            return (+(Math.round(+(num + 'e' + 2)) + 'e' + -2)).toFixed(2);
          }

          function toDisplay3(num) {
            return (+(Math.round(+(num + 'e' + 3)) + 'e' + -3)).toFixed(3);
          }

          function toDB4(num) {
            return (+(Math.round(+(num + 'e' + 4)) + 'e' + -4)).toFixed(4);
          }
          $("#select_employee").on("change", function() {
            filter_data($("#select_employee").find(":selected").val());
          })
          $("#cutoff_period").on("change", function() {
            filter_data(null);
          })
          $("#integrated_cutoff_period").on("change", function() {
            filter_data($("#select_employee").find(":selected").val());
          })
          $('input[type="checkbox"]').on('change', function() {
            if ($(this).prop("checked") == true) {
              $(this).val(1);
            } else if ($(this).prop("checked") == false) {
              $(this).val(0);
            }
            filter_data($("#select_employee").find(":selected").val())
          });

          function filter_data(empl) {
            let period = $("#cutoff_period").find(":selected").val();
            let integrate = $("#integrated_cutoff_period").find(":selected").val();
            let employee = empl;
            //  $("#select_employee").find(":selected").val();
            let sss = $("#cb_sss").val();
            let philhealth = $("#cb_phil").val();
            let pagibig = $("#cb_pagibig").val();
            let wtax = $("#cb_wtax").val();
            let ti = $("#cb_ti").val();
            let nti = $("#cb_nti").val();
            let td = $("#cb_td").val();
            let ntd = $("#cb_ntd").val();
            let loans = $("#cb_loans").val();
            let absut = $("#cb_absut").val();
            window.location = base_url + "payrolls/generator?employee=" + employee + "&period=" + period + "&sss=" + sss + "&phil=" + philhealth + "&pagibig=" + pagibig + "&wtax=" + wtax + "&ti=" + ti + "&nti=" + nti + "&td=" + td + "&ntd=" + ntd + "&loans=" + loans + "&absut=" + absut;
            // "&period="+cut_off+"&employee="+employee;
          }
        

          $('#btn_submit_payslip_generated').click(function(){
            $('#form_edit_payslip').submit();
          })
        
        })
      </script>
</body>

</html>