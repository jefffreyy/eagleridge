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
                        <h1 class="page-title"><a href="<?= base_url().'payrolls/payroll_status';?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Edit Generated Payslip
                        </h1>
                    </div>
                    <div class="col-md-8 pt-1 button-title" style="padding: 0px; margin: 0px">
                        <button class="btn btn-info  text-white ml-3 mb-2" id="btn_update_generated_payslip"><i class="fa-solid fa-circle-arrow-up"></i> Update Generated Payslip </button>
                    </div>
                </div>
                <!-- Title Header Line -->
                <hr>
                <div class="row justify-content-md-center">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 ">
                        <div class="card">
                            <form action="<?php echo base_url(); ?>payrolls/edit_generated_payslip_data/<?= $DISP_PAYROLL_PAYSLIPS->id; ?>/<?= $DISP_PAYROLL_PAYSLIPS->empl_id; ?>/<?= $DISP_PAYROLL_PAYSLIPS_PERIOD->PAYSLIP_PERIOD;?> " id="form_edit_generated_payslip" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Cut-off Period: </p>
                                                <input type="text" name="cutoff_period" id="cutoff_period" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value="<?= $DISP_PAYROLL_PAYSLIPS->PAYSLIP_PERIOD; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Employee ID: </p>
                                                <input type="text" name="employee_cmid" id="employee_cmid" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value="<?= $DISP_PAYROLL_PAYSLIPS->PAYSLIP_EMPLOYEE_CMID .' - '. $DISP_PAYROLL_PAYSLIPS->PAYSLIP_EMPLOYEE_NAME; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Payroll Type: </p>
                                                <input type="text" name="payroll_type" id="payroll_type" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value="Semi-Monthly">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Salary Type: </p>
                                                <input type="text" name="salary_type" id="salary_type" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value="<?= $DISP_PAYROLL_PAYSLIPS->PAYSLIP_SALARY_TYPE ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Salary: </p>
                                                <input type="text" name="salary_rate" id="salary_rate" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value="<?= $DISP_PAYROLL_PAYSLIPS->PAYSLIP_SALARY_RATE ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Work Rate: </p>
                                                <input type="text" name="work_rate" id="work_rate" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value="313 Days">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Daily Salary: </p>
                                                <input type="text" name="daily_salary" id="daily_salary" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value="<?= $DISP_PAYROLL_PAYSLIPS->INITIAL_DAILY_RATE; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Hourly Salary: </p>
                                                <input type="text" name="hourly_salary" id="hourly_salary" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;" disabled value="<?= $DISP_PAYROLL_PAYSLIPS->INITIAL_HOURLY_RATE; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Present: </p>
                                                <input type="text" name="count_present" id="count_present" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_PRESENT; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Absent: </p>
                                                <input type="text" name="count_absent" id="count_absent" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_ABSENT; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Tardiness: </p>
                                                <input type="text" name="count_tardiness" id="count_tardiness" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_TARDINESS ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Undertime: </p>
                                                <input type="text" name="count_undertime" id="count_undertime" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_UNDERTIME ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Paid Leave: </p>
                                                <input type="text" name="count_paid_leave" id="count_paid_leave" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_PAID_LEAVE ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Regular Hours: </p>
                                                <input type="text" name="count_reg_hours" id="count_reg_hours" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_REG_HOURS; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Regular OT: </p>
                                                <input type="text" name="count_reg_ot" id="count_reg_ot" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_REG_OT; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Regular ND: </p>
                                                <input type="text" name="count_reg_nd" id="count_reg_nd" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_REG_ND; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Regular NDOT: </p>
                                                <input type="text" name="count_reg_ndot" id="count_reg_ndot" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_REG_NDOT; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Rest Hours: </p>
                                                <input type="text" name="count_rest_hours" id="count_rest_hours" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_REST_HOURS; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Rest OT: </p>
                                                <input type="text" name="count_rest_ot" id="count_rest_ot" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_REST_OT; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Rest ND: </p>
                                                <input type="text" name="count_rest_nd" id="count_rest_nd" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_REST_ND; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Rest NDOT: </p>
                                                <input type="text" name="count_rest_ndot" id="count_rest_ndot" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_REST_NDOT; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Legal Hours: </p>
                                                <input type="text" name="count_leg_hours" id="count_leg_hours" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_LEG_HOURS; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Legal OT: </p>
                                                <input type="text" name="count_leg_ot" id="count_leg_ot" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_LEG_OT; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Legal ND: </p>
                                                <input type="text" name="count_leg_nd" id="count_leg_nd" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_LEG_ND; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Legal NDOT: </p>
                                                <input type="text" name="count_leg_ndot" id="count_leg_ndot" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_LEG_NDOT; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Legal Rest Hours: </p>
                                                <input type="text" name="count_legrest_hours" id="count_legrest_hours" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_LEGREST_HOURS; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Legal Rest OT: </p>
                                                <input type="text" name="count_legrest_ot" id="count_legrest_ot" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_LEGREST_OT; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Legal Rest ND: </p>
                                                <input type="text" name="count_legrest_nd" id="count_legrest_nd" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_LEGREST_ND; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Legal Rest NDOT: </p>
                                                <input type="text" name="count_legrest_ndot" id="count_legrest_ndot" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_LEGREST_NDOT; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Special Hours: </p>
                                                <input type="text" name="count_spe_hours" id="count_spe_hours" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_SPE_HOURS; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Special OT: </p>
                                                <input type="text" name="count_spe_ot" id="count_spe_ot" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_SPE_OT; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Special ND: </p>
                                                <input type="text" name="count_spe_nd" id="count_spe_nd" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_SPE_ND; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Special NDOT: </p>
                                                <input type="text" name="count_spe_ndot" id="count_spe_ndot" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_SPE_NDOT; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Special Rest Hours: </p>
                                                <input type="text" name="count_sperest_hours" id="count_sperest_hours" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_SPEREST_HOURS; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Special Rest OT: </p>
                                                <input type="text" name="count_sperest_ot" id="count_sperest_ot" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_SPEREST_OT; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Special Rest ND: </p>
                                                <input type="text" name="count_sperest_nd" id="count_sperest_nd" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_SPEREST_ND; ?>">
                                            </div>
                                            <div class="d-flex ml-1">
                                                <p class="text-bold mb-3 mt-1" style="font-size: 14px;width:170px;">Count Special Rest NDOT: </p>
                                                <input type="text" name="count_sperest_ndot" id="count_sperest_ndot" class="form-control ml-2 text-right flex-fill" style="width: 115px; font-size: 13px;"  value="<?= $DISP_PAYROLL_PAYSLIPS->COUNT_SPEREST_NDOT; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
        $(document).ready(function() {
            
            $('#btn_update_generated_payslip').click(function() {
                $('#form_edit_generated_payslip').submit();
            })
        })



    </script>

    
    
</body>
</html>