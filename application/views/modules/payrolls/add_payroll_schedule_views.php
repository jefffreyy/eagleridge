<html>
<?php $this->load->view('templates/css_link');
$this->load->library('session');
?>

<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <div class='row pt-1'>
                <!-- <div class='col-md-8 ml-4 mt-3'>
                <h2><a href="javascript:history.go(-1);"><i class="fa-duotone fa-circle-left"></a></i>&nbsp;Add Payroll Schedule</h2>
            </div> -->
                <div class="col-md-6">
                    <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'payrolls/payroll_schedules'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Add Payroll Schedule<h1>
                </div>
            </div>
            <div class="container-fluid px-4">
                <div class="row d-flex justify-content-center">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="modal-body pb-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php echo form_open_multipart('payrolls/insert_payroll_sched'); ?>
                                        <div class="form-group">
                                            <label class="" for="input_">Title</label>
                                            <input type="text" class="form-control" name="title" id="title" value="" required>
                                        </div>


                                        <div class="form-group">
                                            <label class="" for="input_">Year</label>
                                            <select class="form-control" name="year" id="year" enabled="">
                                                <?php
                                                $currentYear = date('Y'); // Get the current year
                                                foreach ($DISP_YEARS as $year) {
                                                    // Only display the current year as an option
                                                    if ($year->name == $currentYear) {
                                                ?>
                                                        <option value='<?= $year->id ?>' selected><?= $year->name ?></option>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <option value='<?= $year->id ?>'><?= $year->name ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="">Month</label>
                                            <select class="form-control" name="month">
                                                <?php foreach ($DISP_MONTHS as $month) { ?>
                                                    <option value='<?= $month ?>'><?= $month ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label class="" for="start_date">Start Date</label>
                                            <input type="date" class="form-control " name="start_date" id="start_date" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="end_date">End Date</label>
                                            <input type="date" class="form-control " name="end_date" id="end_date" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="payout_date">Payout Date</label>
                                            <input type="date" class="form-control " name="payout_date" id="payout_date" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="payslip_schedule_viewing">Payslip Schedule Viewing</label>
                                            <input type="datetime-local" class="form-control" name="payslip_schedule_viewing" id="payslip_schedule_viewing" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="pay_freq">Pay Frequency</label>
                                            <select class="form-control" name="pay_freq" id="pay_freq" enabled="">
                                                <option value='Semi-Monthly'>Semi-Monthly</option>
                                                <option value='Weekly'>Weekly</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="input_">Connected Period 1 (Optional)</label>
                                            <select class="form-control" name="con_period_1" id="con_period_1" enabled="">
                                                <option value="">No Option Selected</option>
                                                <?php if ($PAYROLL_SCHEDULES) {
                                                    foreach ($PAYROLL_SCHEDULES as $PAYROLL_SCHEDULE) { ?>
                                                        <option value='<?= $PAYROLL_SCHEDULE->id ?>'><?= $PAYROLL_SCHEDULE->name ?></option>
                                                <?php    }
                                                } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="input_">Connected Period 2 (Optional)</label>
                                            <select class="form-control" name="con_period_2" id="con_period_2" enabled="">
                                                <option value="">No Option Selected</option>
                                                <?php if ($PAYROLL_SCHEDULES) {
                                                    foreach ($PAYROLL_SCHEDULES as $PAYROLL_SCHEDULE) { ?>
                                                        <option value='<?= $PAYROLL_SCHEDULE->id ?>'><?= $PAYROLL_SCHEDULE->name ?></option>
                                                <?php    }
                                                } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="input_">Connected Period 3 (Optional)</label>
                                            <select class="form-control" name="con_period_3" id="con_period_3" enabled="">
                                                <option value="">No Option Selected</option>
                                                <?php if ($PAYROLL_SCHEDULES) {
                                                    foreach ($PAYROLL_SCHEDULES as $PAYROLL_SCHEDULE) { ?>
                                                        <option value='<?= $PAYROLL_SCHEDULE->id ?>'><?= $PAYROLL_SCHEDULE->name ?></option>
                                                <?php    }
                                                } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="input_">Connected Period 4 (Optional)</label>
                                            <select class="form-control" name="con_period_4" id="con_period_4" enabled="">
                                                <option value="">No Option Selected</option>
                                                <?php if ($PAYROLL_SCHEDULES) {
                                                    foreach ($PAYROLL_SCHEDULES as $PAYROLL_SCHEDULE) { ?>
                                                        <option value='<?= $PAYROLL_SCHEDULE->id ?>'><?= $PAYROLL_SCHEDULE->name ?></option>
                                                <?php    }
                                                } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="input_">Connected Period 5 (Optional)</label>
                                            <select class="form-control" name="con_period_5" id="con_period_5" enabled="">
                                                <option value="">No Option Selected</option>
                                                <?php if ($PAYROLL_SCHEDULES) {
                                                    foreach ($PAYROLL_SCHEDULES as $PAYROLL_SCHEDULE) { ?>
                                                        <option value='<?= $PAYROLL_SCHEDULE->id ?>'><?= $PAYROLL_SCHEDULE->name ?></option>
                                                <?php    }
                                                } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="status">Status</label>
                                            <select class="form-control" name="status" id="status" enabled="">

                                                <option value='Active'>Active</option>
                                                <option value='Inactive'>Inactive</option>
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_sss" name="input_sss" style="width: 20px; height: 20px; font-size: 13px; color:green;">
                                                    <label for="cb_sss" class="mr-4"> SSS Contribution</label><br>
                                                </div>
                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_phil" name="input_phil" style="width: 20px; height:20px; font-size: 13px;">
                                                    <label for="cb_phil" class="mr-4"> Philhealth Contribution</label><br>
                                                </div>
                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_pagibig" name="input_pagibig" style="width: 20px; height:20px; font-size: 13px;">
                                                    <label for="cb_pagibig" class="mr-4"> Pag-ibig Contribution</label><br>
                                                </div>
                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_wtax" name="input_wtax" style="width: 20px; height:20px; font-size: 13px;">
                                                    <label for="cb_wtax" class="mr-4"> Withholding Tax</label><br>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_tax_allowance" name="input_tax_allowance" style="width: 20px; height:20px; font-size: 13px;">
                                                    <label for="cb_ti" class="mr-4"> Taxable Allowance</label><br>
                                                </div>

                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_nontax_allowance" name="input_nontax_allowance" style="width: 20px; height:20px; font-size: 13px;">
                                                    <label for="cb_nti" class="mr-4"> Non-Taxable Allowance</label><br>
                                                </div>

                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_loans" name="input_loans" style="width: 20px; height:20px; font-size: 13px;">
                                                    <label for="cb_loans" class="mr-4">Loans</label><br>
                                                </div>
                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_adjustment" name="input_adjustment" style="width: 20px; height:20px; font-size: 13px;">
                                                    <label for="cb_loans" class="mr-4">Adjustment</label><br>
                                                </div>
                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_tard" name="input_tard" style="width: 20px; height:20px; font-size: 13px;">
                                                    <label for="cb_absut" class="mr-4">Tardiness</label><br>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="mr-2" style="float: right !important">
                                            <button type="submit" id="btn_add" class="btn technos-button-blue shadow-none rounded " ;> Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('templates/jquery_link'); ?>

    <?php
    if ($this->session->flashdata('SUCC')) {
    ?>
        <script>
            $(document).Toasts('create', {
                class: 'bg-success toast_width',
                title: 'Success!',
                subtitle: 'close',
                body: '<?php echo $this->session->flashdata('SUCC'); ?>'
            })
        </script>
    <?php
    }
    ?>


    <?php
    if ($this->session->flashdata('ERR')) {
    ?>
        <script>
            $(document).Toasts('create', {
                class: 'bg-warning toast_width',
                title: 'Warning!',
                subtitle: 'close',
                body: '<?php echo $this->session->flashdata('ERR'); ?>'
            })
        </script>
    <?php
    }
    ?>



</body>

</html>