<?php $this->load->view('templates/css_link'); ?>

<style>
    .form-row {
        display: flex;
        align-items: center;
    }

    .form-row .label {
        margin: 10px;
        width: 150px;
    }

    .form-row input {
        width: 80px;
        margin-right: 10px;
    }

    .form-row .coordinates {
        margin: 10px 0;
        margin-right: 86px;
    }
    .form-row input {
        height: 28px;
        padding-right: 0;
    }

    .form-row p {
        font-weight: 460;
    }

    .form-row .label_title{
        font-weight: 600;
    }


    #updateCoordinatesForm {
        overflow-y: scroll;
        height: 80vh; 
    }
</style>

<body>
    <!-- Content Starts -->
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <div class="row  pt-1">
                <!-- Title Text -->
                <div class="col-md-6">
                    <h1 class="page-title"><a href="<?= base_url() . 'payrolls/pending'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                        </a>&nbsp;Payslip Template</h1>
                </div>
                <!-- Title Button -->
                <div class="col-md-6 button-title">
                    <a href="" id="updateButton" class="btn btn-primary shadow-none"> <img style="width: 18px; height: 18px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</a>
                </div>
            </div>
            <hr>
            <div class="card border-0 p-0 m-0">
                <div class="form-container">
                    <!-- <button id="generate-pdf">Generate PDF</button> -->
                    <div class="row">
                        <form action="<?php echo base_url('payrolls/payslip_format'); ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8">
                                    <!-- <div class="form-group">
                                        <input class="form-control p-0" type="file" name="update_image" id="update_image" accept="image/*" capture="camera" value="<?= $PAYSLIP_FORM ?>" />
                                        <input type="hidden" name="old_image" value="<?= $PAYSLIP_FORM ?>">
                                    </div> -->
                                    <div class="custom-file my-2 mx-3">
                                        <input class="p-0 custom-file-input fileficker" type="file" name="update_image" id="update_image" accept="image/*" capture="camera" value="<?= $PAYSLIP_FORM ?>" />
                                        <input type="hidden" name="old_image" value="<?= $PAYSLIP_FORM ?>">
                                        <label class="custom-file-label" id="preview_login_logo" for="update_login_logo">Choose file</label>
                                    </div>

                                </div>
                                <div class="col-md-3 my-2 m-1">
                                    <button type="submit" class='btn btn-primary text-light form-control'>Save</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <form action="<?= base_url('payrolls/payslip_coordinates_setting') ?>" method="post" id="updateCoordinatesForm">
                                <div class="form-row">
                                    <p class="label label_title">COORDINATES</p>
                                    <p class="coordinates">X</p>
                                    <p class="coordinates">Y</p>
                                </div>
                                <div class="form-row">
                                    <!--Employee ID  -->
                                    <p class="label">Employee ID</p>
                                    <input class="form-control" type="number" name="employee_id_x" id="employee_id_x" min="0" step="0.01" value="<?= $EMPL_ID_X; ?>">
                                    <input class="form-control" type="number" name="employee_id_y" id="employee_id_y" min="0" step="0.01" value="<?= $EMPL_ID_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <!-- Employee Name -->
                                    <p class="label">Employee Name</p>
                                    <input class="form-control" type="number" name="employee_name_x" id="employee_name_x" min="0" step="0.01" value="<?= $EMPL_NAME_X; ?>">
                                    <input class="form-control" type="number" name="employee_name_y" id="employee_name_y" min="0" step="0.01" value="<?= $EMPL_NAME_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">Designation</p>
                                    <input class="form-control" type="number" name="designation_x" id="designation_x" min="0" step="0.01" value="<?= $DESIGNATION_X; ?>">
                                    <input class="form-control" type="number" name="designation_y" id="designation_y" min="0" step="0.01" value="<?= $DESIGNATION_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <!-- Payroll Period -->
                                    <p class="label">Payroll Period</p>
                                    <input class="form-control" type="number" name="payroll_period_x" id="payroll_period_x" min="0" step="0.01" value="<?= $PERIOD_X; ?>">
                                    <input class="form-control" type="number" name="payroll_period_y" id="payroll_period_y" min="0" step="0.01" value="<?= $PERIOD_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">Payout Date</p>
                                    <input class="form-control" type="number" name="payout_date_x" id="payout_date_x" min="0" step="0.01" value="<?= $PAYOUT_X; ?>">
                                    <input class="form-control" type="number" name="payout_date_y" id="payout_date_y" min="0" step="0.01" value="<?= $PAYOUT_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">Bank Account</p>
                                    <input class="form-control" type="number" name="bank_account_x" id="bank_account_x" min="0" step="0.01" value="<?= $BANK_ACCT_X; ?>">
                                    <input class="form-control" type="number" name="bank_account_y" id="bank_account_y" min="0" step="0.01" value="<?= $BANK_ACCT_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <!-- Salary Type -->
                                    <p class="label">Salary Type</p>
                                    <input class="form-control" type="number" name="salary_type_x" id="salary_type_x" min="0" step="0.01" value="<?= $SALARY_TYPE_X; ?>">
                                    <input class="form-control" type="number" name="salary_type_y" id="salary_type_y" min="0" step="0.01" value="<?= $SALARY_TYPE_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <!-- Monthly Salary -->
                                    <p class="label">Monthly Salary</p>
                                    <input class="form-control" type="number" name="monthly_salary_x" id="monthly_salary_x" min="0" step="0.01" value="<?= $MONTHLY_SALARY_X; ?>">
                                    <input class="form-control" type="number" name="monthly_salary_y" id="monthly_salary_y" min="0" step="0.01" value="<?= $MONTHLY_SALARY_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <!-- Daily Salary -->
                                    <p class="label">Daily Salary</p>
                                    <input class="form-control" type="number" name="daily_salary_x" id="daily_salary_x" min="0" step="0.01" value="<?= $DAILY_SALARY_X; ?>">
                                    <input class="form-control" type="number" name="daily_salary_y" id="daily_salary_y" min="0" step="0.01" value="<?= $DAILY_SALARY_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">HDMF No.</p>
                                    <input class="form-control" type="number" name="hdmf_no_x" id="hdmf_no_x" min="0" step="0.01" value="<?= $HDMF_NO_X; ?>">
                                    <input class="form-control" type="number" name="hdmf_no_y" id="hdmf_no_y" min="0" step="0.01" value="<?= $HDMF_NO_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">PhilHealth No.</p>
                                    <input class="form-control" type="number" name="philhealth_no_x" id="philhealth_no_x" min="0" step="0.01" value="<?= $PHILHEALTH_NO_X; ?>">
                                    <input class="form-control" type="number" name="philhealth_no_y" id="philhealth_no_y" min="0" step="0.01" value="<?= $PHILHEALTH_NO_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">TIN No.</p>
                                    <input class="form-control" type="number" name="tin_no_x" id="tin_no_x" min="0" step="0.01" value="<?= $TIN_NO_X ?>">
                                    <input class="form-control" type="number" name="tin_no_y" id="tin_no_y" min="0" step="0.01" value="<?= $TIN_NO_Y ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">SSS No.</p>
                                    <input class="form-control" type="number" name="sss_no_x" id="sss_no_x" min="0" step="0.01" value="<?= $SSS_NO_X; ?>">
                                    <input class="form-control" type="number" name="sss_no_y" id="sss_no_y" min="0" step="0.01" value="<?= $SSS_NO_Y; ?>">
                                </div>
   
                                <div class="form-row">
                                    <p class="label label_title">GROSS INCOME</p>
                                    <p>_____________________________</p>
                                </div>

                                <div class="form-row">
                                    <p class="label label_title">Basic Pay</p>
                                </div>

                                <div class="form-row">
                                    <p class="label">Reg Work (Hrs)</p>
                                    <input class="form-control" type="number" name="regwrk_hrs_x" id="regwrk_hrs_x" min="0" step="0.01" value="<?= $REGWRK_HRS_X; ?>">
                                    <input class="form-control" type="number" name="regwrk_hrs_y" id="regwrk_hrs_y" min="0" step="0.01" value="<?= $REGWRK_HRS_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">Reg Work (Amt)</p>
                                    <input class="form-control" type="number" name="regwrk_amt_x" id="regwrk_amt_x" min="0" step="0.01" value="<?= $REGWRK_AMT_X; ?>">
                                    <input class="form-control" type="number" name="regwrk_amt_y" id="regwrk_amt_y" min="0" step="0.01" value="<?= $REGWRK_AMT_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label">Paid Leave (Hrs)</p>
                                    <input class="form-control" type="number" name="pdLeave_hrs_x" id="pdLeave_hrs_x" min="0" step="0.01" value="<?= $PDLEAVE_HRS_X; ?>">
                                    <input class="form-control" type="number" name="pdLeave_hrs_y" id="pdLeave_hrs_y" min="0" step="0.01" value="<?= $PDLEAVE_HRS_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">Paid Leave (Amt)</p>
                                    <input class="form-control" type="number" name="pdLeave_amt_x" id="pdLeave_amt_x" min="0" step="0.01" value="<?= $PDLEAVE_AMT_X; ?>">
                                    <input class="form-control" type="number" name="pdLeave_amt_y" id="pdLeave_amt_y" min="0" step="0.01" value="<?= $PDLEAVE_AMT_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">Legal Holiday (Hrs)</p>
                                    <input class="form-control" type="number" name="legHol_hrs_x" id="legHol_hrs_x" min="0" step="0.01" value="<?= $LEGHOL_HRS_X; ?>">
                                    <input class="form-control" type="number" name="legHol_hrs_y" id="legHol_hrs_y" min="0" step="0.01" value="<?= $LEGHOL_HRS_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">Legal Holiday (Amt)</p>
                                    <input class="form-control" type="number" name="legHol_amt_x" id="legHol_amt_x" min="0" step="0.01" value="<?= $LEGHOL_AMT_X; ?>">
                                    <input class="form-control" type="number" name="legHol_amt_y" id="legHol_amt_y" min="0" step="0.01" value="<?= $LEGHOL_AMT_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label label_title">Absences</p>
                                </div>

                                <div class="form-row">
                                    <p class="label">Absent (Hrs)</p>
                                    <input class="form-control" type="number" name="absent_hrs_x" id="absent_hrs_x" min="0" step="0.01" value="<?= $ABSENT_HRS_X; ?>">
                                    <input class="form-control" type="number" name="absent_hrs_y" id="absent_hrs_y" min="0" step="0.01" value="<?= $ABSENT_HRS_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">Absent (Amt)</p>
                                    <input class="form-control" type="number" name="absent_amt_x" id="absent_amt_x" min="0" step="0.01" value="<?= $ABSENT_AMT_X; ?>">
                                    <input class="form-control" type="number" name="absent_amt_y" id="absent_amt_y" min="0" step="0.01" value="<?= $ABSENT_AMT_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label">Tardiness (Hrs)</p>
                                    <input class="form-control" type="number" name="tard_hrs_x" id="tard_hrs_x" min="0" step="0.01" value="<?= $TARD_HRS_X; ?>">
                                    <input class="form-control" type="number" name="tard_hrs_y" id="tard_hrs_y" min="0" step="0.01" value="<?= $TARD_HRS_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">Tardiness (Amt)</p>
                                    <input class="form-control" type="number" name="tard_amt_x" id="tard_amt_x" min="0" step="0.01" value="<?= $TARD_AMT_X; ?>">
                                    <input class="form-control" type="number" name="tard_amt_y" id="tard_amt_y" min="0" step="0.01" value="<?= $TARD_AMT_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label">Undertime (Hrs)</p>
                                    <input class="form-control" type="number" name="ut_hrs_x" id="ut_hrs_x" min="0" step="0.01" value="<?= $UT_HRS_X; ?>">
                                    <input class="form-control" type="number" name="ut_hrs_y" id="ut_hrs_y" min="0" step="0.01" value="<?= $UT_HRS_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">Undertime (Amt)</p>
                                    <input class="form-control" type="number" name="ut_amt_x" id="ut_amt_x" min="0" step="0.01" value="<?= $UT_AMT_X; ?>">
                                    <input class="form-control" type="number" name="ut_amt_y" id="ut_amt_y" min="0" step="0.01" value="<?= $UT_AMT_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label">Under Break (Hrs)</p>
                                    <input class="form-control" type="number" name="ubrk_hrs_x" id="ubrk_hrs_x" min="0" step="0.01" value="<?= $UBRK_HRS_X; ?>">
                                    <input class="form-control" type="number" name="ubrk_hrs_y" id="ubrk_hrs_y" min="0" step="0.01" value="<?= $UBRK_HRS_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">Undertime Break (Amt)</p>
                                    <input class="form-control" type="number" name="ubrk_amt_x" id="ubrk_amt_x" min="0" step="0.01" value="<?= $UBRK_AMT_X; ?>">
                                    <input class="form-control" type="number" name="ubrk_amt_y" id="ubrk_amt_y" min="0" step="0.01" value="<?= $UBRK_AMT_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label">Over Break (Hrs)</p>
                                    <input class="form-control" type="number" name="obrk_hrs_x" id="obrk_hrs_x" min="0" step="0.01" value="<?= $OBRK_HRS_X; ?>">
                                    <input class="form-control" type="number" name="obrk_hrs_y" id="obrk_hrs_y" min="0" step="0.01" value="<?= $OBRK_HRS_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">Over Break (Amt)</p>
                                    <input class="form-control" type="number" name="obrk_amt_x" id="obrk_amt_x" min="0" step="0.01" value="<?= $OBRK_AMT_X; ?>">
                                    <input class="form-control" type="number" name="obrk_amt_y" id="obrk_amt_y" min="0" step="0.01" value="<?= $OBRK_AMT_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label">Total Basic Pay</p>
                                    <input class="form-control" type="number" name="totalbp_x" id="totalbp_x" min="0" step="0.01" value="<?= $TOTALBP_X; ?>">
                                    <input class="form-control" type="number" name="totalbp_y" id="totalbp_y" min="0" step="0.01" value="<?= $TOTALBP_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label label_title">Overtime Pay</p>
                                </div>

                                <div class="form-row">
                                    <p class="label">OTP Description</p>
                                    <input class="form-control" type="number" name="otpay_des_x" id="otpay_des_x" min="0" step="0.01" value="<?= $OTPAY_DES_X; ?>">
                                    <input class="form-control" type="number" name="otpay_y" id="otpay_y" min="0" step="0.01" value="<?= $OTPAY_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">OTP Hours</p>
                                    <input class="form-control" type="number" name="otpay_hrs_x" id="otpay_hrs_x" min="0" step="0.01" value="<?= $OTPAY_HRS_X; ?>">
                                    <input class="form-control" type="number" id="otpay_hrs_y" min="0" step="0.01" value="<?= $OTPAY_Y; ?>" disabled>
                                </div>
                                <div class="form-row">
                                    <p class="label">OTP Amount</p>
                                    <input class="form-control" type="number" name="otpay_amt_x" id="otpay_amt_x" min="0" step="0.01" value="<?= $OTPAY_AMT_X; ?>">
                                    <input class="form-control" type="number" id="otpay_amt_y" min="0" step="0.01" value="<?= $OTPAY_Y; ?>" disabled>
                                </div>

                                <div class="form-row">
                                    <p class="label label_title">Night Differential</p>
                                </div>

                                <div class="form-row">
                                    <p class="label">ND Description</p>
                                    <input class="form-control" type="number" name="ndpay_des_x" id="ndpay_des_x" min="0" step="0.01" value="<?= $NDPAY_DES_X; ?>">
                                    <input class="form-control" type="number" name="ndpay_y" id="ndpay_y" min="0" step="0.01" value="<?= $NDPAY_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">ND Hours</p>
                                    <input class="form-control" type="number" name="ndpay_hrs_x" id="ndpay_hrs_x" min="0" step="0.01" value="<?= $NDPAY_HRS_X; ?>">
                                    <input class="form-control" type="number" id="ndpay_hrs_y" min="0" step="0.01" value="<?= $NDPAY_Y; ?>" disabled>
                                </div>
                                <div class="form-row">
                                    <p class="label">ND Amount</p>
                                    <input class="form-control" type="number" name="ndpay_amt_x" id="ndpay_amt_x" min="0" step="0.01" value="<?= $NDPAY_AMT_X; ?>">
                                    <input class="form-control" type="number" id="ndpay_amt_y" min="0" step="0.01" value="<?= $NDPAY_Y; ?>" disabled>
                                </div>

                                <div class="form-row">
                                    <p class="label">Total OT/ND Pay</p>
                                    <input class="form-control" type="number" name="total_otnd_x" id="total_otnd_x" min="0" step="0.01" value="<?= $TOTAL_OTND_X; ?>">
                                    <input class="form-control" type="number" name="total_otnd_y" id="total_otnd_y" min="0" step="0.01" value="<?= $TOTAL_OTND_Y; ?>">
                                </div>


                                <div class="form-row">
                                    <p class="label label_title">GOVERNMENT CONTRIBUTIONS</p>
                                    <p>_____________________________</p>
                                </div>

                                <div class="form-row">
                                    <p class="label">WTAX</p>
                                    <input class="form-control" type="number" name="wtax_x" id="wtax_x" min="0" step="0.01" value="<?= $WTAX_X; ?>">
                                    <input class="form-control" type="number" name="wtax_y" id="wtax_y" min="0" step="0.01" value="<?= $WTAX_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">SSS</p>
                                    <input class="form-control" type="number" name="sss_x" id="sss_x" min="0" step="0.01" value="<?= $SSS_X; ?>">
                                    <input class="form-control" type="number" name="sss_y" id="sss_y" min="0" step="0.01" value="<?= $SSS_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">PhilHealth</p>
                                    <input class="form-control" type="number" name="philhealth_x" id="philhealth_x" min="0" step="0.01" value="<?= $PHILHEALTH_X; ?>">
                                    <input class="form-control"type="number" name="philhealth_y" id="philhealth_y" min="0" step="0.01" value="<?= $PHILHEALTH_Y; ?>">
                                </div>
                                <div class="form-row">
                                    <p class="label">HDMF</p>
                                    <input class="form-control" type="number" name="hdmf_x" id="hdmf_x" min="0" step="0.01" value="<?= $HDMF_X; ?>">
                                    <input class="form-control" type="number" name="hdmf_y" id="hdmf_y" min="0" step="0.01" value="<?= $HDMF_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label label_title">YTD BALANCES</p>
                                    <p>_____________________________</p>
                                </div>

                                <div class="form-row">
                                    <p class="label">Gross Tax</p>
                                    <input class="form-control" type="number" name="gross_tax_x" id="gross_tax_x" min="0" step="0.01" value="<?= $GROSS_TAX_X; ?>">
                                    <input class="form-control" type="number" name="gross_tax_y" id="gross_tax_y" min="0" step="0.01" value="<?= $GROSS_TAX_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label">Exclusion</p>
                                    <input class="form-control" type="number" name="exclusion_x" id="exclusion_x" min="0" step="0.01" value="<?= $EXCLUSION_X; ?>">
                                    <input class="form-control" type="number" name="exclusion_y" id="exclusion_y" min="0" step="0.01" value="<?= $EXCLUSION_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label">WTAX</p>
                                    <input class="form-control" type="number" name="wtax_ytd_x" id="wtax_ytd_x" min="0" step="0.01" value="<?= $WTAX_YTD_X; ?>">
                                    <input class="form-control" type="number" name="wtax_ytd_y" id="wtax_ytd_y" min="0" step="0.01" value="<?= $WTAX_YTD_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label label_title">OTHER TAXABLE INCOME</p>
                                    <p>_____________________________</p>
                                </div>

                                <div class="form-row">
                                    <p class="label">Tax Description</p>
                                    <input class="form-control" type="number" name="tax_description_x" id="tax_description_x" min="0" step="0.01" value="<?= $TAX_DESC_X; ?>">
                                    <input class="form-control" type="number" name="taxable_income_y" id="taxable_income_y" min="0" step="0.01" value="<?= $TAXABLE_INCOME_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label">Tax Amount</p>
                                    <input class="form-control" type="number" name="tax_amount_x" id="tax_amount_x" min="0" step="0.01" value="<?= $TAX_AMT_X; ?>">
                                    <input class="form-control" type="number" id="" min="0" step="0.01" value="<?= $TAXABLE_INCOME_Y; ?>" disabled>
                                </div>

                                <div class="form-row">
                                    <p class="label">Total Other Tax</p>
                                    <input class="form-control" type="number" name="total_oth_tax_x" id="total_oth_tax_x" min="0" step="0.01" value="<?= $TOTAL_OTH_TAX_X; ?>">
                                    <input class="form-control" type="number" name="total_oth_tax_y" id="total_oth_tax_y" min="0" step="0.01" value="<?= $TOTAL_OTH_TAX_Y; ?>" >
                                </div>

                                <div class="form-row">
                                    <p class="label label_title">OTHER NON-TAXABLE INCOME</p>
                                    <p>_____________________________</p>
                                </div>

                                <div class="form-row">
                                    <p class="label">Non-Tax Description</p>
                                    <input class="form-control" type="number" name="non_tax_description_x" id="non_tax_description_x" min="0" step="0.01" value="<?= $NON_TAX_DESC_X; ?>">
                                    <input class="form-control" type="number" name="non_taxable_income_y" id="non_taxable_income_y" min="0" step="0.01" value="<?= $NON_TAXABLE_INCOME_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label">Non-Tax Amount</p>
                                    <input class="form-control" type="number" name="non_tax_amount_x" id="non_tax_amount_x" min="0" step="0.01" value="<?= $NON_TAX_AMT_X; ?>">
                                    <input class="form-control" type="number" id="" min="0" step="0.01" value="<?= $NON_TAXABLE_INCOME_Y; ?>" disabled>
                                </div>

                                <div class="form-row">
                                    <p class="label">Total Other Non-Tax</p>
                                    <input class="form-control" type="number" name="total_oth_nontax_x" id="total_oth_nontax_x" min="0" step="0.01" value="<?= $TOTAL_OTH_NONTAX_X; ?>">
                                    <input class="form-control" type="number" name="total_oth_nontax_y" id="total_oth_nontax_y" min="0" step="0.01" value="<?= $TOTAL_OTH_NONTAX_Y; ?>" >
                                </div>

                                <div class="form-row">
                                    <p class="label label_title">LOANS AND OTHER DEDUCTIONS</p>
                                    <p>_____________________________</p>
                                </div>

                                <div class="form-row">
                                    <p class="label">Code</p>
                                    <input class="form-control" type="number" name="other_code_x" id="other_code_x" min="0" step="0.01" value="<?= $OTHER_CODE_X; ?>">
                                    <input class="form-control" type="number" name="loan_deductions_y" id="loan_deductions_y" min="0" step="0.01" value="<?= $LOAN_OTHER_DEDUCTIONS_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label">Start</p>
                                    <input class="form-control" type="number" name="other_start_x" id="other_start_x" min="0" step="0.01" value="<?= $OTHER_START_X; ?>">
                                    <input class="form-control" type="number" id="" min="0" step="0.01" value="<?= $LOAN_OTHER_DEDUCTIONS_Y; ?>" disabled>
                                </div>

                                <div class="form-row">
                                    <p class="label">Payable</p>
                                    <input class="form-control" type="number" name="other_payable_x" id="other_payable_x" min="0" step="0.01" value="<?= $OTHER_PAYABLE_X; ?>">
                                    <input class="form-control" type="number" id="" min="0" step="0.01" value="<?= $LOAN_OTHER_DEDUCTIONS_Y; ?>" disabled>
                                </div>

                                <div class="form-row">
                                    <p class="label">Deducted</p>
                                    <input class="form-control" type="number" name="other_deducted_x" id="other_deducted_x" min="0" step="0.01" value="<?= $OTHER_DEDUCTED_X; ?>">
                                    <input class="form-control" type="number" id="" min="0" step="0.01" value="<?= $LOAN_OTHER_DEDUCTIONS_Y; ?>" disabled>
                                </div>

                                <div class="form-row">
                                    <p class="label">Balance Amount</p>
                                    <input class="form-control" type="number" name="other_bal_amt_x" id="other_bal_amt_x" min="0" step="0.01" value="<?= $OTHER_BAL_AMT_X; ?>">
                                    <input class="form-control" type="number" id="" min="0" step="0.01" value="<?= $LOAN_OTHER_DEDUCTIONS_Y; ?>" disabled>
                                </div>

                                <div class="form-row">
                                    <p class="label label_title">LEAVE BALANCES</p>
                                    <p>_____________________________</p>
                                </div>

                                <div class="form-row">
                                    <p class="label label_title">Vaction</p>
                                </div>

                                <div class="form-row">
                                    <p class="label">Vacation Used</p>
                                    <input class="form-control" type="number" name="leave_vac_used_x" id="leave_vac_used_x" min="0" step="0.01" value="<?= $LEAVE_VAC_USED_X; ?>">
                                    <input class="form-control" type="number" name="leave_vac_y" id="leave_vac_y" min="0" step="0.01" value="<?= $LEAVE_VAC_y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label">Vacation Balance</p>
                                    <input class="form-control" type="number" name="leave_vac_bal_x" id="leave_vac_bal_x" min="0" step="0.01" value="<?= $LEAVE_VAC_BAL_X; ?>">
                                    <input class="form-control" type="number"  id="" min="0" step="0.01" value="<?= $LEAVE_VAC_y; ?>" disabled>
                                </div>

                                <div class="form-row">
                                    <p class="label label_title">Sick</p>
                                </div>

                                <div class="form-row">
                                    <p class="label">Sick Used</p>
                                    <input class="form-control" type="number" name="leave_sick_used_x" id="leave_sick_used_x" min="0" step="0.01" value="<?= $LEAVE_SICK_USED_X; ?>">
                                    <input class="form-control" type="number" name="leave_sick_y" id="leave_sick_y" min="0" step="0.01" value="<?= $LEAVE_SICK_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label">Sick Balance</p>
                                    <input class="form-control" type="number" name="leave_sick_bal_x" id="leave_sick_bal_x" min="0" step="0.01" value="<?= $LEAVE_SICK_BAL_x; ?>">
                                    <input class="form-control" type="number"  id="" min="0" step="0.01" value="<?= $LEAVE_SICK_Y; ?>" disabled>
                                </div>

                                <div class="form-row">
                                    <p class="label label_title">TOTAL</p>
                                    <p>_____________________________</p>
                                </div>

                                <div class="form-row">
                                    <p class="label">Total Gross Pay</p>
                                    <input class="form-control" type="number" name="total_gross_pay_x" id="total_gross_pay_x" min="0" step="0.01" value="<?= $TOTAL_GROSS_PAY_X; ?>">
                                    <input class="form-control" type="number" name="total_gross_pay_y" id="total_gross_pay_y" min="0" step="0.01" value="<?= $TOTAL_GROSS_PAY_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label">Total Deduction</p>
                                    <input class="form-control" type="number" name="total_deductions_x" id="total_deductions_x" min="0" step="0.01" value="<?= $TOTAL_DEDUCTIONS_X; ?>">
                                    <input class="form-control" type="number" name="total_deductions_y" id="total_deductions_y" min="0" step="0.01" value="<?= $TOTAL_DEDUCTIONS_Y; ?>">
                                </div>

                                <div class="form-row">
                                    <p class="label">Net Pay</p>
                                    <input class="form-control" type="number" name="total_net_pay_x" id="total_net_pay_x" min="0" step="0.01" value="<?= $TOTAL_NET_PAY_X; ?>">
                                    <input class="form-control" type="number" name="total_net_pay_y" id="total_net_pay_y" min="0" step="0.01" value="<?= $TOTAL_NET_PAY_Y; ?>">
                                </div>


                            </form>
                        </div>
                        <div class="col-md-9">
                            <div id="pdf-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--End fluid-->
    </div>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script> -->
    <script src="<?= base_url('assets_system') ?>/js/jspdf.umd.min.js"></script>
    <!-- jQuery -->
    <?php $this->load->view('templates/jquery_link'); ?>

    <?php
    if ($this->session->userdata('SESS_SUCCESS')) {
    ?>
        <script>
            $(document).Toasts('create', {
                class: 'bg-success toast_width',
                title: 'Success',
                subtitle: 'close',
                body: '<?php echo $this->session->userdata('SESS_SUCCESS'); ?>'
            })
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCCESS');
    }
    ?>

    <script>

        const updateButton = document.getElementById('updateButton');
        const updateCoordinatesForm = document.getElementById('updateCoordinatesForm');

        updateButton.addEventListener('click', function(event) {
            event.preventDefault();
            updateCoordinatesForm.submit();
        });
    </script>

    <script>

        let emplId_x            = Number(<?= json_encode($EMPL_ID_X);?>);
        let emplId_y            = Number(<?= json_encode($EMPL_ID_Y);?>);
        let emplName_x          = Number(<?= json_encode($EMPL_NAME_X);?>);
        let emplName_y          = Number(<?= json_encode($EMPL_NAME_Y);?>);
        let designation_x       = Number(<?= json_encode($DESIGNATION_X);?>);
        let designation_y       = Number(<?= json_encode($DESIGNATION_Y);?>);
        let period_x            = Number(<?= json_encode($PERIOD_X);?>);
        let period_y            = Number(<?= json_encode($PERIOD_Y);?>);
        let payout_x            = Number(<?= json_encode($PAYOUT_X);?>);
        let payout_y            = Number(<?= json_encode($PAYOUT_Y);?>);
        let bankAcct_x          = Number(<?= json_encode($BANK_ACCT_X);?>);
        let bankAcct_y          = Number(<?= json_encode($BANK_ACCT_Y);?>);
        let salaryType_x        = Number(<?= json_encode($SALARY_TYPE_X);?>);
        let salaryType_y        = Number(<?= json_encode($SALARY_TYPE_Y);?>);
        let monthlySalary_x     = Number(<?= json_encode($MONTHLY_SALARY_X);?>);
        let monthlySalary_y     = Number(<?= json_encode($MONTHLY_SALARY_Y);?>);
        let dailySalary_x       = Number(<?= json_encode($DAILY_SALARY_X);?>);
        let dailySalary_y       = Number(<?= json_encode($DAILY_SALARY_Y);?>);
        let hdmfNo_x            = Number(<?= json_encode($HDMF_NO_X);?>);
        let hdmfNo_y            = Number(<?= json_encode($HDMF_NO_Y);?>);
        let philHealthNo_x      = Number(<?= json_encode($PHILHEALTH_NO_X);?>);
        let philHealthNo_y      = Number(<?= json_encode($PHILHEALTH_NO_Y);?>);
        let tinNo_x             = Number(<?= json_encode($TIN_NO_X);?>);
        let tinNo_y             = Number(<?= json_encode($TIN_NO_Y);?>);
        let sssNo_x             = Number(<?= json_encode($SSS_NO_X);?>);
        let sssNo_y             = Number(<?= json_encode($SSS_NO_Y);?>);
        let wtax_x              = Number(<?= json_encode($WTAX_X);?>);
        let wtax_y              = Number(<?= json_encode($WTAX_Y);?>);
        let sss_x               = Number(<?= json_encode($SSS_X);?>);
        let sss_y               = Number(<?= json_encode($SSS_Y);?>);
        let philhealth_x        = Number(<?= json_encode($PHILHEALTH_X);?>);
        let philhealth_y        = Number(<?= json_encode($PHILHEALTH_Y);?>);
        let hdmf_x              = Number(<?= json_encode($HDMF_X);?>);
        let hdmf_y              = Number(<?= json_encode($HDMF_Y);?>);
        let regwrk_hrs_x        = Number(<?= json_encode($REGWRK_HRS_X);?>);
        let regwrk_hrs_y        = Number(<?= json_encode($REGWRK_HRS_Y);?>);
        let regwrk_amt_x        = Number(<?= json_encode($REGWRK_AMT_X);?>);
        let regwrk_amt_y        = Number(<?= json_encode($REGWRK_AMT_Y);?>);
        let pdLeave_hrs_x       = Number(<?= json_encode($PDLEAVE_HRS_X);?>);
        let pdLeave_hrs_y       = Number(<?= json_encode($PDLEAVE_HRS_Y);?>);
        let pdLeave_amt_x       = Number(<?= json_encode($PDLEAVE_AMT_X);?>);
        let pdLeave_amt_y       = Number(<?= json_encode($PDLEAVE_AMT_Y);?>);
        let legHol_hrs_x        = Number(<?= json_encode($LEGHOL_HRS_X);?>);
        let legHol_hrs_y        = Number(<?= json_encode($LEGHOL_HRS_Y);?>);
        let legHol_amt_x        = Number(<?= json_encode($LEGHOL_AMT_X);?>);
        let legHol_amt_y        = Number(<?= json_encode($LEGHOL_AMT_Y);?>);
        let absent_hrs_x        = Number(<?= json_encode($ABSENT_HRS_X);?>);
        let absent_hrs_y        = Number(<?= json_encode($ABSENT_HRS_Y);?>);
        let absent_amt_x        = Number(<?= json_encode($ABSENT_AMT_X);?>);
        let absent_amt_y        = Number(<?= json_encode($ABSENT_AMT_Y);?>);
        let tard_hrs_x          = Number(<?= json_encode($TARD_HRS_X);?>);
        let tard_hrs_y          = Number(<?= json_encode($TARD_HRS_Y);?>);
        let tard_amt_x          = Number(<?= json_encode($TARD_AMT_X);?>);
        let tard_amt_y          = Number(<?= json_encode($TARD_AMT_Y);?>);
        let ut_hrs_x            = Number(<?= json_encode($UT_HRS_X);?>);
        let ut_hrs_y            = Number(<?= json_encode($UT_HRS_Y);?>);
        let ut_amt_x            = Number(<?= json_encode($UT_AMT_X);?>);
        let ut_amt_y            = Number(<?= json_encode($UT_AMT_Y);?>);
        let ubrk_hrs_x          = Number(<?= json_encode($UBRK_HRS_X);?>);
        let ubrk_hrs_y          = Number(<?= json_encode($UBRK_HRS_Y);?>);
        let ubrk_amt_x          = Number(<?= json_encode($UBRK_AMT_X);?>);
        let ubrk_amt_y          = Number(<?= json_encode($UBRK_AMT_Y);?>);
        let obrk_hrs_x          = Number(<?= json_encode($OBRK_HRS_X);?>);
        let obrk_hrs_y          = Number(<?= json_encode($OBRK_HRS_Y);?>);
        let obrk_amt_x          = Number(<?= json_encode($OBRK_AMT_X);?>);
        let obrk_amt_y          = Number(<?= json_encode($OBRK_AMT_Y);?>);
        let totalbp_x           = Number(<?= json_encode($TOTALBP_X);?>);
        let totalbp_y           = Number(<?= json_encode($TOTALBP_Y);?>);
        let otpay_des_x         = Number(<?= json_encode($OTPAY_DES_X);?>);
        let otpay_hrs_x         = Number(<?= json_encode($OTPAY_HRS_X);?>);
        let otpay_amt_x         = Number(<?= json_encode($OTPAY_AMT_X);?>);
        let otpay_y             = Number(<?= json_encode($OTPAY_Y);?>);
        let ndpay_des_x         = Number(<?= json_encode($NDPAY_DES_X);?>);
        let ndpay_hrs_x         = Number(<?= json_encode($NDPAY_HRS_X);?>);
        let ndpay_amt_x         = Number(<?= json_encode($NDPAY_AMT_X);?>);
        let ndpay_y             = Number(<?= json_encode($NDPAY_Y);?>);
        let total_otnd_x        = Number(<?= json_encode($TOTAL_OTND_X);?>);
        let total_otnd_y        = Number(<?= json_encode($TOTAL_OTND_Y);?>);
        let gross_tax_x         = Number(<?= json_encode($GROSS_TAX_X);?>);
        let gross_tax_y         = Number(<?= json_encode($GROSS_TAX_Y);?>);
        let exclusion_x         = Number(<?= json_encode($EXCLUSION_X);?>);
        let exclusion_y         = Number(<?= json_encode($EXCLUSION_Y);?>);
        let wtax_ytd_x          = Number(<?= json_encode($WTAX_YTD_X);?>);
        let wtax_ytd_y          = Number(<?= json_encode($WTAX_YTD_Y);?>);
        let tax_income_y        = Number(<?= json_encode($TAXABLE_INCOME_Y);?>);
        let tax_desc_x          = Number(<?= json_encode($TAX_DESC_X);?>);
        let tax_amt_x           = Number(<?= json_encode($TAX_AMT_X);?>);
        let non_tax_income_y    = Number(<?= json_encode($NON_TAXABLE_INCOME_Y);?>);
        let non_tax_desc_x      = Number(<?= json_encode($NON_TAX_DESC_X);?>);
        let non_tax_amt_x       = Number(<?= json_encode($NON_TAX_AMT_X);?>);
        let loan_other_deduct_y = Number(<?= json_encode($LOAN_OTHER_DEDUCTIONS_Y);?>);
        let other_code_x        = Number(<?= json_encode($OTHER_CODE_X);?>);
        let other_start_x       = Number(<?= json_encode($OTHER_START_X);?>);
        let other_payable_x     = Number(<?= json_encode($OTHER_PAYABLE_X);?>);
        let other_deduct_x      = Number(<?= json_encode($OTHER_DEDUCTED_X);?>);
        let other_bal_amt_x     = Number(<?= json_encode($OTHER_BAL_AMT_X);?>);
        let leave_vac_used_x    = Number(<?= json_encode($LEAVE_VAC_USED_X);?>);
        let leave_vac_bal_x     = Number(<?= json_encode($LEAVE_VAC_BAL_X);?>);
        let leave_vac_y         = Number(<?= json_encode($LEAVE_VAC_y);?>);
        let leave_sick_used_x   = Number(<?= json_encode($LEAVE_SICK_USED_X);?>);
        let leave_sick_bal_x    = Number(<?= json_encode($LEAVE_SICK_BAL_x);?>);
        let leave_sick_y        = Number(<?= json_encode($LEAVE_SICK_Y);?>);
        let total_oth_tax_x     = Number(<?= json_encode($TOTAL_OTH_TAX_X);?>);
        let total_oth_tax_y     = Number(<?= json_encode($TOTAL_OTH_TAX_Y);?>);
        let total_oth_nontax_x  = Number(<?= json_encode($TOTAL_OTH_NONTAX_X);?>);
        let total_oth_nontax_y  = Number(<?= json_encode($TOTAL_OTH_NONTAX_Y);?>);
        let total_gross_pay_x   = Number(<?= json_encode($TOTAL_GROSS_PAY_X);?>);
        let total_gross_pay_y   = Number(<?= json_encode($TOTAL_GROSS_PAY_Y);?>);
        let total_deductions_x  = Number(<?= json_encode($TOTAL_DEDUCTIONS_X);?>);
        let total_deductions_y  = Number(<?= json_encode($TOTAL_DEDUCTIONS_Y);?>);
        let total_net_pay_x     = Number(<?= json_encode($TOTAL_NET_PAY_X);?>);
        let total_net_pay_y     = Number(<?= json_encode($TOTAL_NET_PAY_Y);?>);

        function updatePDF() {
            window.jsPDF = window.jspdf.jsPDF;
        // document.getElementById('generate-pdf').addEventListener('click', function() {
            // Create a new jsPDF instance

            <?php
            if (!empty($DISP_NAV)) {
                $company_logo = base_url() . 'assets_system/images/' . $DISP_NAV;
            } else {
                $company_logo = false;
            }
            ?>
            let companyLogo = '<?= $company_logo ?>';

            var doc = new jsPDF({
                orientation: 'p',
                unit: 'mm',
                format: 'a5',
            });
        
            pdfImage = "<?= base64_encode(file_get_contents(base_url('assets_user/files/payslips/'.$PAYSLIP_FORM))) ?>";
            // console.log('<?= base_url('assets_user/files/payslips/'.$PAYSLIP_FORM) ?>')
            var width = doc.internal.pageSize.width;
            var height = doc.internal.pageSize.height;
            doc.addImage("data:image/png;base64," + pdfImage, 'PNG', 0, 0, width, height);
            console.log(companyLogo)
            if (companyLogo) {
                let log0Xcoor = 6;
                let logoYcoor = 5.3;
                let logoWith = 20;
                let logoHeight = 6;
                doc.addImage(companyLogo, 'PNG', log0Xcoor, logoYcoor, logoWith, logoHeight);
            }

            doc.setFontSize(4.8);

            increment_by = 2.5;
            // Employee Details
            xcoor = 54;
            ycoor = 4.2;
            doc.text(emplId_x, emplId_y ,  "ABC00001");
            doc.text(emplName_x, emplName_y,  "Jonh Cruz");
            doc.text(designation_x, designation_y,  "Staff");

            //  Payslip Period
            xcoor = 95;
            ycoor = 4;
            doc.text(period_x, period_y, "Mar 01 - Mar 15, 2024");
            doc.text(payout_x, payout_y, "Mar 15, 2024");
            doc.text(bankAcct_x, bankAcct_y, "1234567890");

            // Salary Type
            xcoor = 128;
            ycoor = 4;
            doc.text(salaryType_x, salaryType_y, "Monthly");

            // Monthly Rate
            ycoor = 9;
            doc.text(monthlySalary_x, monthlySalary_y, "30,000.00")
            
            // Daily Rate
            ycoor = 11.5;
            doc.text(dailySalary_x, dailySalary_y, "1,139.24");
            
            xcoor = 80;
            ycoor = 11.5;
            doc.text(hdmfNo_x, hdmfNo_y, "1234567890" ); // Pagibig ID
            doc.text(philHealthNo_x, philHealthNo_y, "1234567890" ); // PhilHealth ID

            xcoor = 116;
            ycoor = 11.5;
            doc.text(tinNo_x, tinNo_y, "1234567890" ); // TIN ID
            doc.text(sssNo_x, sssNo_y, "1234567890" ); // SSS ID

            // Government Contributions    ================ Start ===============

            xcoor_3_2 = 93; //  x coordinate
            ycoor_3 = 24.2;
            doc.text(wtax_x, wtax_y, "306.78", { align: 'right'}) // WTAX

            ycoor_3 = 26.7;
            doc.text(sss_x, sss_y, "607.50", { align: 'right'}) // SSS

            xcoor_4_2 = 120; // x coordinate
            ycoor_4 = 24.2;
            doc.text(philhealth_x, philhealth_y, "375.00", { align: 'right'}) // Philhealth

            ycoor_4 = 26.7;
            doc.text(hdmf_x, hdmf_y, "0.00", { align: 'right'}) // Pag-ibig

            // Government Contributions    ================ End ===============

            // Gross Income Basic Pay   ================== Start =========================

            ycoor_1 = 22;
            xcoor_1_2 = 22.5;
            xcoor_1_3 = 36.5;

            // REGWRK
            doc.text(regwrk_hrs_x, regwrk_hrs_y, "10.50", { align: 'right' });
            doc.text(regwrk_amt_x, regwrk_amt_y, "8,000.00" ,{ align: 'right'});

            // PDLEAV
            doc.text(pdLeave_hrs_x, pdLeave_hrs_y, "1.00", { align: 'right' });
            doc.text(pdLeave_amt_x, pdLeave_amt_y, "700.00" ,{ align: 'right'});

            // LEGHOL
            doc.text(legHol_hrs_x, legHol_hrs_y, "1.00", { align: 'right' });
            doc.text(legHol_amt_x, legHol_amt_y, "700.00" ,{ align: 'right'});

            // Gross Income Basic Pay   ================== End =========================


            // Gross Income Absences   ================== Start =========================
            ycoor_abs_1 = 32 ;
            xcoor_abs_1_1 = 50;
            xcoor_abs_1_2 = 22.5;
            xcoor_abs_1_3 = 36.5;
            increment_by = 2.6;
            // ABSENT
            doc.text(absent_hrs_x, absent_hrs_y, "1.00", { align: 'right' });
            doc.text(absent_amt_x, absent_amt_y, "1.00" ,{ align: 'right'});

            // TARDINESS
            doc.text(tard_hrs_x, tard_hrs_y, "2.00", { align: 'right' });
            doc.text(tard_amt_x, tard_amt_y, "2.00" ,{ align: 'right'});
            
            // UNDERTIME
            doc.text(ut_hrs_x, ut_hrs_y, "3.00", { align: 'right' });
            doc.text(ut_amt_x, ut_amt_y, "3.00" ,{ align: 'right'});

            // UNDER BREAK
            doc.text(ubrk_hrs_x, ubrk_hrs_y, "4.00", { align: 'right' });
            doc.text(ubrk_amt_x, ubrk_amt_y, "4.00" ,{ align: 'right'});

            // OVER BREAK
            doc.text(obrk_hrs_x, obrk_hrs_y, "5.00", { align: 'right' });
            doc.text(obrk_amt_x, obrk_amt_y, "5.00" ,{ align: 'right'});
            
        // Gross Income Absences   ================== End =========================

        // Total Basic Pay  ======================Start ========================
            // ycoor_total_basic = 50;
            // xcoor_total_basic = 36.5;
            ycoor_total_basic = totalbp_y;
            xcoor_total_basic = totalbp_x;

            doc.text(xcoor_total_basic, ycoor_total_basic, "10.00", {align: 'right'});

        // Total Basic Pay  ====================== End ========================

        // Gross Income OT Pay   ================== Start =========================
            // ycoor_1 = 22;
            // xcoor_1_1 = 38;
            // xcoor_1_2 = 54;
            // xcoor_1_3 = 69.6;
            ycoor_1 = otpay_y;
            xcoor_1_1 = otpay_des_x;
            xcoor_1_2 = otpay_hrs_x;
            xcoor_1_3 = otpay_amt_x;
            increment_by = 2.6;

            let description_ot_pay = ['REST', 'LEGHOL', 'LEGREST', 'SPEHOL', 'SPEREST', 'REGOT', 'RESTOT', 'LEGOT', 'LEGRESTOT', 'SPEOT', 'SPERESTOT'];
            let count_ot_pay = ["10.00", "10.00", "10.00", "0", "0", "0", "0", "0", "0", "0", "0"];
            let unit_ot_pay = ['hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr','hr', 'hr', 'hr', 'hr'];
            let tot_ot_pay = ["11.00", "11.00", "11.00", "0", "0", "0", "0", "0", "0", "0", "0"];
            size_length = description_ot_pay.length;

            for (let i = 0; i < size_length; i++) {
                if (tot_ot_pay[i] && tot_ot_pay[i] != '0.00' && tot_ot_pay[i] != '0') {
                    // Description
                    doc.text(xcoor_1_1, ycoor_1, description_ot_pay[i], {
                        align: 'left'
                    });

                    if (count_ot_pay[i] != '0') {
                        doc.text(xcoor_1_2, ycoor_1, count_ot_pay[i], {
                            align: 'right'
                        });
                    }
                    doc.text(xcoor_1_3, ycoor_1, parseFloat(tot_ot_pay[i]).toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }), {
                        align: 'right'
                    });
                    ycoor_1 += increment_by;
                }
            }

        // Gross Income OT Pay   ===================== End =========================

            // Gross Income NIGHT DIFF   ================== Start =========================
            // ycoor_1 = 37;
            // xcoor_1_1 = 38;
            // xcoor_1_2 = 54;
            // xcoor_1_3 = 69.5;
            ycoor_1 = ndpay_y;
            xcoor_1_1 = ndpay_des_x;
            xcoor_1_2 = ndpay_hrs_x;
            xcoor_1_3 = ndpay_amt_x;
            increment_by = 2.6;

            let description_night_diff = ['REG ND', 'REG NDOT', 'REST ND', 'REST NDOT', 'LEG ND', 'LEG NDOT', 'LEGREST ND', 'LEGREST NDOT', 'SPE ND', 'SPE NDOT', 'SPEREST ND', 'SPEREST NDOT', ];
            let count_night_diff = ["10.00", "10.00", "10.00", "0", "0", "0", "0", "0", "0", "0", "0", "0", ];
            let unit_night_diff = ['hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr'];
            let tot_night_diff = ["10.00", "10.00", "10.00", "0", "0", "0", "0", "0", "0", "0", "0", "0", ];

            size_length = description_night_diff.length;

            for (let i = 0; i < size_length; i++) {
                if (tot_night_diff[i] && tot_night_diff[i] != '0.00' && tot_night_diff[i] != '0') {
                    // Description
                    doc.text(xcoor_1_1, ycoor_1, description_night_diff[i], {
                        align: 'left'
                    });

                    if (count_night_diff[i] != '0') {
                    doc.text(xcoor_1_2, ycoor_1, count_night_diff[i], {
                        align: 'right'
                    });
                    }
                    doc.text(xcoor_1_3, ycoor_1, parseFloat(tot_night_diff[i]).toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }), {
                    align: 'right'
                    });
                    ycoor_1 += increment_by;
                }
            }

            // Gross Income NIGHT DIFF   ===================== End =========================

            // Total OT/ND PAY  ======================Start ========================
            // ycoor_total_nd = 50;
            // xcoor_total_nd = 69.5;
            ycoor_total_nd = total_otnd_y;
            xcoor_total_nd = total_otnd_x;

            doc.text(xcoor_total_nd, ycoor_total_nd, "30.00", { align: 'right' });
            // Total OT/ND PAY  ====================== End ========================

            let gross_tax_x        = Number(<?= json_encode($GROSS_TAX_X);?>);
            let gross_tax_y        = Number(<?= json_encode($GROSS_TAX_Y);?>);
            
            let exclusion_x        = Number(<?= json_encode($EXCLUSION_X);?>);
            let exclusion_y        = Number(<?= json_encode($EXCLUSION_Y);?>);
            
            let wtax_ytd_x        = Number(<?= json_encode($WTAX_YTD_X);?>);
            let wtax_ytd_y        = Number(<?= json_encode($WTAX_YTD_Y);?>);

            // YTD BALANCES =========================== START ===================================
            xcoor = 143;
            ycoor = 24.1

            doc.text(gross_tax_x, gross_tax_y, "10.00", { align: 'right' });
            ycoor = 26.6
            doc.text(exclusion_x, exclusion_y, "11.00", {align: 'right'});
            ycoor = 29.2
            doc.text(wtax_ytd_x, wtax_ytd_y, "12.00", { align: 'right' });
            
            // YTD BALANCES =========================== END ===================================


            // Other Taxable Income =============================== STart ===========================

            // ycoor_2 = 57.5;
            // xcoor_2_1 = 5.5;
            // // xcoor_2_2 = 21;
            // xcoor_2_3 = 36.5;
            // increment_by = 2.5;

            ycoor_2 = tax_income_y
            xcoor_2_1 = tax_desc_x;
            // xcoor_2_2 = 21;
            xcoor_2_3 = tax_amt_x;
            increment_by = 2.5;

            let description_tax = ['Gold', 'Silver'];
            let amount_tax = ['20.00', '10.00'];
            let hr_tax = [];

            for (let i = 0; i < description_tax.length; i++) {
                if (amount_tax[i] && amount_tax[i] != '0.00' && amount_tax[i] != '0') {
                    // Description
                    doc.text(xcoor_2_1, ycoor_2, description_tax[i], {
                        align: 'left'
                    });
                    // amount
                    doc.text(xcoor_2_3, ycoor_2, parseFloat(amount_tax[i]).toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }), {
                        align: 'right'
                    });
                    ycoor_2 += increment_by;
                }

            }
        // Other Taxable Income =============================== End ===========================

        // Other Non-Taxable Income =============================== STart ===========================

            // ycoor_2 = 57.5;
            // xcoor_2_1 = 38;
            // // xcoor_2_2 = 54;
            // xcoor_2_3 = 69.6;
            // increment_by = 2.5;

            ycoor_2 = non_tax_income_y;
            xcoor_2_1 = non_tax_desc_x;
            xcoor_2_3 = non_tax_amt_x;
            increment_by = 2.5;

            let description_nontax = ["Bronze", "Iron"];
            let amount_nontax = ["15.00", "9.00"];
            let hr_nontax = [];

            for (let i = 0; i < description_nontax.length; i++) {
                if (amount_nontax[i] && amount_nontax[i] != '0.00' && amount_nontax[i] != '0') {
                    // Description
                    doc.text(xcoor_2_1, ycoor_2, description_nontax[i], {
                        align: 'left'
                    });
                    // amount
                    doc.text(xcoor_2_3, ycoor_2, parseFloat(amount_nontax[i]).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                    }), {
                        align: 'right'
                    });
                    ycoor_2 += increment_by;
                }

            }
        // Other Non-Taxable Income =============================== End ===========================

        // Loans and Other Deductions   ======================== Start =======================

            // ycoor_2 = 37;
            // xcoor_2_1 = 70.5; // code
            // xcoor_2_2 = 130; // not used
            // xcoor_2_3 = 107.5;
            // xcoor_2_4 = 119.5;
            // xcoor_2_5 = 80.5; // loan date
            // xcoor_2_6 = 91; // loan amount

            ycoor_2         = loan_other_deduct_y;
            xcoor_2_1       = other_code_x;         // code
            xcoor_2_3       = other_deduct_x;       // deducted
            xcoor_2_4       = other_bal_amt_x;      // bal amount
            xcoor_2_5       = other_start_x;        // start
            xcoor_2_6       = other_payable_x;      // loan amount
            increment_by    = 2.5;

            let loan_code       = ['calamity','sss'];
            let start           = ['Jan 1, 2024','Jan 1, 2024'];
            let payable         = ['6,000.00', '3,000.00 '];
            let deducted        = ['1,000.00', '500.00'];
            let bal_amt         = ['5,000.00','2,500.00'];

            size_length = loan_code.length;
            for (let i = 0; i < size_length; i++) {

                if (loan_code) {

                doc.text(xcoor_2_1, ycoor_2, loan_code[i], {
                    align: 'left'
                });

                if (start[i]) {
                    doc.text(xcoor_2_5, ycoor_2, start[i], {
                    align: 'left'
                    });

                }

                if (payable[i]) {
                    doc.text(xcoor_2_6, ycoor_2, parseFloat(payable[i]).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                    }), {
                    align: 'left'
                    });
                }

                if (deducted[i]) {
                    doc.text(xcoor_2_3, ycoor_2, parseFloat(deducted[i]).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                    }), {
                    align: 'right'
                    });
                }

                if (bal_amt[i]) {
                    doc.text(xcoor_2_4, ycoor_2, parseFloat(bal_amt[i]).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                    }), {
                    align: 'right'
                    });
                }

                ycoor_2 += increment_by;
                }
            }

        // Loans and Other Deductions         ================ End ===============
        
        // LEAVE BALANCES =========================== START ===================================
            // xcoor = 133;
            // ycoor = 40;
            xcoor = 133;
            ycoor = 40;
            increment_by = 2.5;
            // Description

            doc.text(leave_vac_used_x, leave_vac_y, "8", { align: 'right' });
            doc.text(leave_sick_used_x, leave_sick_y, "16", { align: 'right' });
            
            xcoor = 143;
            ycoor = 40;
            increment_by = 2.5;

            doc.text(leave_vac_bal_x, leave_vac_y, "8", { align: 'right' });
            doc.text(leave_sick_bal_x, leave_sick_y, "16", { align: 'right' });
            

        // LEAVE BALANCES =========================== END ===================================


        // OTHER TOTAL TAX ========================== START ================================
            y_coor = 65.5;
            x_coor = 36.5;
            
            doc.text(total_oth_tax_x, total_oth_tax_y, "10.00", {
                align: 'right'
            });
        // OTHER TOTAL TAX ========================== END ================================

        // OTHER TOTAL TAX ========================== START ================================
            y_coor = 68;
            x_coor = 69.5;
            
            doc.text(total_oth_nontax_x, total_oth_nontax_y, "10.00", {
                align: 'right'
            });
        // OTHER TOTAL TAX ========================== END ================================


        // GROSS INCOME ========================== START ================================
            y_coor = 68;
            x_coor = 36.5;
            doc.text(total_gross_pay_x, total_gross_pay_y, "10.00", {
                align: 'right'
            });
        // GROSS INCOME ========================== END ================================

        // DEDUCTIONS ========================== START ================================
            y_coor = 68;
            x_coor = 120;
            doc.text(total_deductions_x, total_deductions_y, "10.00", {
                align: 'right'
            });
        // DEDUCTIONS ========================== END ================================

        // NET INCOME ========================== START ================================
            y_coor = 65;
            x_coor = 137;
            doc.text(total_net_pay_x, total_net_pay_y, "10.00", {
                align: 'right'
            });
        // NET INCOME ========================== END ================================


        // Output the PDF as a data URI
        var pdfDataUri = doc.output('datauristring');
        // Display the PDF in an iframe
        var pdfContainer = document.getElementById('pdf-container');
        pdfContainer.innerHTML = '<embed width="100%" height="700px" src="' + pdfDataUri + '#zoom=150" />';

    }

    document.addEventListener('DOMContentLoaded', function() {
        updatePDF(); 
    });
    

    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('change', function() {
            // Update variables with new input values

            switch (input.id) {
                case 'employee_id_x':
                    emplId_x = parseFloat(input.value);
                    break;
                case 'employee_id_y':
                    emplId_y = parseFloat(input.value);
                    break;
                case 'employee_name_x':
                    emplName_x = parseFloat(input.value);
                    break;
                case 'employee_name_y':
                    emplName_y = parseFloat(input.value);
                    break;
                case 'designation_x':
                    designation_x = parseFloat(input.value);
                    break;
                case 'designation_y':
                    designation_y = parseFloat(input.value);
                    break;
                case 'payroll_period_x':
                    period_x = parseFloat(input.value);
                    break;
                case 'payroll_period_y':
                    period_y = parseFloat(input.value);
                    break;  
                case 'payout_date_x':
                    payout_x = parseFloat(input.value);
                    break;
                case 'payout_date_y':
                    payout_y = parseFloat(input.value);
                    break;  
                case 'bank_account_x':
                    bankAcct_x = parseFloat(input.value);
                    break;
                case 'bank_account_y':
                    bankAcct_y = parseFloat(input.value);
                    break;
                case 'salary_type_x':
                    salaryType_x = parseFloat(input.value);
                    break;
                case 'salary_type_y':
                    salaryType_x = parseFloat(input.value);
                    break;
                case 'monthly_salary_x':
                    monthlySalary_x = parseFloat(input.value);
                    break;
                case 'monthly_salary_y':
                    monthlySalary_y = parseFloat(input.value);
                    break;
                case 'daily_salary_x':
                    dailySalary_x = parseFloat(input.value);
                    break;
                case 'daily_salary_y':
                    dailySalary_y = parseFloat(input.value);
                    break;
                case 'hdmf_no_x':
                    hdmfNo_x = parseFloat(input.value);
                    break;
                case 'hdmf_no_y':
                    hdmfNo_y = parseFloat(input.value);
                    break;
                case 'philhealth_no_x':
                    philHealthNo_x = parseFloat(input.value);
                    break;
                case 'philhealth_no_y':
                    philHealthNo_y = parseFloat(input.value);
                    break;
                case 'tin_no_x':
                    tinNo_x = parseFloat(input.value);
                    break;
                case 'tin_no_y':
                    tinNo_y = parseFloat(input.value);
                    break;
                case 'sss_no_x':
                    sssNo_x = parseFloat(input.value);
                    break;
                case 'sss_no_y':
                    sssNo_y = parseFloat(input.value);
                    break;
                case 'regwrk_hrs_x':
                    regwrk_hrs_x = parseFloat(input.value);
                    break;
                case 'regwrk_hrs_y':
                    regwrk_hrs_y = parseFloat(input.value);
                    break;
                case 'regwrk_amt_x':
                    regwrk_amt_x = parseFloat(input.value);
                    break;
                case 'regwrk_amt_y':
                    regwrk_amt_y = parseFloat(input.value);
                    break;
                case 'pdLeave_hrs_x':
                    pdLeave_hrs_x = parseFloat(input.value);
                    break;
                case 'pdLeave_hrs_y':
                    pdLeave_hrs_y = parseFloat(input.value);
                    break;
                case 'pdLeave_amt_x':
                    pdLeave_amt_x = parseFloat(input.value);
                    break;
                case 'pdLeave_amt_y':
                    pdLeave_amt_y = parseFloat(input.value);
                    break;
                case 'legHol_hrs_x':
                    legHol_hrs_x = parseFloat(input.value);
                    break;
                case 'legHol_hrs_y':
                    legHol_hrs_y = parseFloat(input.value);
                    break;
                    case 'legHol_amt_x':
                    legHol_amt_x = parseFloat(input.value);
                    break;
                case 'legHol_amt_y':
                    legHol_amt_y = parseFloat(input.value);
                    break;
                case 'absent_hrs_x':
                    absent_hrs_x = parseFloat(input.value);
                    break;
                case 'absent_hrs_y':
                    absent_hrs_y = parseFloat(input.value);
                    break;
                case 'absent_amt_x':
                    absent_amt_x = parseFloat(input.value);
                    break;
                case 'absent_amt_y':
                    absent_amt_y = parseFloat(input.value);
                    break;
                case 'tard_hrs_x':
                    tard_hrs_x = parseFloat(input.value);
                    break;
                case 'tard_hrs_y':
                    tard_hrs_y = parseFloat(input.value);
                    break;
                case 'tard_amt_x':
                    tard_amt_x = parseFloat(input.value);
                    break;
                case 'tard_amt_y':
                    tard_amt_y = parseFloat(input.value);
                    break;
                case 'ut_hrs_x':
                    ut_hrs_x = parseFloat(input.value);
                    break;
                case 'ut_hrs_y':
                    ut_hrs_y = parseFloat(input.value);
                    break;
                case 'ut_amt_x':
                    ut_amt_x = parseFloat(input.value);
                    break;
                case 'ut_amt_y':
                    ut_amt_y = parseFloat(input.value);
                    break;
                case 'ubrk_hrs_x':
                    ubrk_hrs_x = parseFloat(input.value);
                    break;
                case 'ubrk_hrs_y':
                    ubrk_hrs_y = parseFloat(input.value);
                    break;
                case 'ubrk_amt_x':
                    ubrk_amt_x = parseFloat(input.value);
                    break;
                case 'ubrk_amt_y':
                    ubrk_amt_y = parseFloat(input.value);
                    break;
                case 'obrk_hrs_x':
                    obrk_hrs_x = parseFloat(input.value);
                    break;
                case 'obrk_hrs_y':
                    obrk_hrs_y = parseFloat(input.value);
                    break;
                case 'obrk_amt_x':
                    obrk_amt_x = parseFloat(input.value);
                    break;
                case 'obrk_amt_y':
                    obrk_amt_y = parseFloat(input.value);
                    break;
                case 'totalbp_x':
                    totalbp_x = parseFloat(input.value);
                    break;
                case 'totalbp_y':
                    totalbp_y = parseFloat(input.value);
                    break;
                case 'otpay_des_x':
                    otpay_des_x = parseFloat(input.value);
                    break;
                case 'otpay_y':
                    otpay_y = parseFloat(input.value);
                    break;
                case 'otpay_hrs_x':
                    otpay_hrs_x = parseFloat(input.value);
                    break;
                case 'otpay_amt_x':
                    otpay_amt_x = parseFloat(input.value);
                    break;
                case 'ndpay_des_x':
                    ndpay_des_x = parseFloat(input.value);
                    break;
                case 'ndpay_y':
                    ndpay_y = parseFloat(input.value);
                    break;
                case 'ndpay_hrs_x':
                    ndpay_hrs_x = parseFloat(input.value);
                    break;
                case 'ndpay_amt_x':
                    ndpay_amt_x = parseFloat(input.value);
                    break;
                case 'total_otnd_x':
                    total_otnd_x = parseFloat(input.value);
                    break;
                case 'total_otnd_y':
                    total_otnd_y = parseFloat(input.value);
                    break;
                case 'wtax_x':
                    wtax_x = parseFloat(input.value);
                    break;
                case 'wtax_y':
                    wtax_y = parseFloat(input.value);
                    break;
                case 'sss_x':
                    sss_x = parseFloat(input.value);
                    break;
                case 'sss_y':
                    sss_y = parseFloat(input.value);
                    break;
                case 'philhealth_x':
                    philhealth_x = parseFloat(input.value);
                    break;
                case 'philhealth_y':
                    philhealth_y = parseFloat(input.value);
                    break;
                case 'hdmf_x':
                    hdmf_x = parseFloat(input.value);
                    break;
                case 'hdmf_y':
                    hdmf_y = parseFloat(input.value);
                    break;
                case 'gross_tax_x':
                    gross_tax_x = parseFloat(input.value);
                    break;
                case 'gross_tax_y':
                    gross_tax_y = parseFloat(input.value);
                    break;
                case 'exclusion_x':
                    exclusion_x = parseFloat(input.value);
                    break;
                case 'exclusion_y':
                    exclusion_y = parseFloat(input.value);
                    break;
                case 'wtax_ytd_x':
                    wtax_ytd_x = parseFloat(input.value);
                    break;
                case 'wtax_ytd_y':
                    wtax_ytd_y = parseFloat(input.value);
                    break;
                case 'tax_description_x':
                    tax_desc_x = parseFloat(input.value);
                    break;
                case 'taxable_income_y':
                    tax_income_y = parseFloat(input.value);
                    break;
                case 'tax_amount_x':
                    tax_amt_x = parseFloat(input.value);
                    break;
                case 'total_oth_tax_x':
                    total_oth_tax_x = parseFloat(input.value);
                    break;
                case 'total_oth_tax_y':
                    total_oth_tax_y = parseFloat(input.value);
                    break;
                case 'non_tax_description_x':
                    non_tax_desc_x = parseFloat(input.value);
                    break;
                case 'non_taxable_income_y':
                    non_tax_income_y = parseFloat(input.value);
                    break;
                case 'non_tax_amount_x':
                    non_tax_amt_x = parseFloat(input.value);
                    break;
                case 'total_oth_nontax_x':
                    total_oth_nontax_x = parseFloat(input.value);
                    break;
                case 'total_oth_nontax_y':
                    total_oth_nontax_y = parseFloat(input.value);
                    break;
                case 'other_code_x':
                    other_code_x = parseFloat(input.value);
                    break;
                case 'loan_deductions_y':
                    loan_other_deduct_y = parseFloat(input.value);
                    break;
                case 'other_start_x':
                    other_start_x = parseFloat(input.value);
                    break;
                case 'other_payable_x':
                    other_payable_x = parseFloat(input.value);
                    break;
                case 'other_deducted_x':
                    other_deduct_x = parseFloat(input.value);
                    break;
                case 'other_bal_amt_x':
                    other_bal_amt_x = parseFloat(input.value);
                    break;
                case 'leave_vac_used_x':
                    leave_vac_used_x = parseFloat(input.value);
                    break;
                case 'leave_vac_y':
                    leave_vac_y = parseFloat(input.value);
                    break;
                case 'leave_vac_bal_x':
                    leave_vac_bal_x = parseFloat(input.value);
                    break;
                case 'leave_sick_used_x':
                    leave_sick_used_x= parseFloat(input.value);
                    break;
                case 'leave_sick_bal_x':
                    leave_sick_bal_x = parseFloat(input.value);
                    break;
                case 'leave_sick_y':
                    leave_sick_y = parseFloat(input.value);
                    break;
                case 'total_gross_pay_x':
                    total_gross_pay_x = parseFloat(input.value);
                    break;
                case 'total_gross_pay_y':
                    total_gross_pay_y = parseFloat(input.value);
                    break;
                case 'total_deductions_x':
                    total_deductions_x = parseFloat(input.value);
                    break;
                case 'total_deductions_y':
                    total_deductions_y = parseFloat(input.value);
                    break;
                case 'total_net_pay_x':
                    total_net_pay_x = parseFloat(input.value);
                    break;
                case 'total_net_pay_y':
                    total_net_pay_y = parseFloat(input.value);
                    break;
                default:
                    break;
            }
            // Update PDF content
            updatePDF();
        });
    });


    </script>

<script>
    const updateImageInput = document.getElementById('update_image');
    const updateImageLabel = document.getElementById('update_image_label');

    updateImageInput.addEventListener('change', function(event) {
        const fileName = event.target.files[0].name; // Get the filename
        updateImageLabel.textContent = fileName; // Update the label text
    });


    function update_login_logo(uploader) {
            if (uploader.files && uploader.files[0]) {
                $('#preview_login_logo').text(uploader.files[0].name);
            }
        }
        $("#update_image").change(function() {
            update_login_logo(this);
        });
</script>


</body>

</html>