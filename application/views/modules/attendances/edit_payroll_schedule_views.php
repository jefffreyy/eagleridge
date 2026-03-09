<html>
<?php $this->load->view('templates/css_link');
$this->load->library('session');
?>

<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <div class='row  pt-1'>
                <div class="col-md-6">
                    <h1 class="page-title"><a href="<?= base_url() . 'attendances/payroll_schedules'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 5px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Edit Payroll Schedule<h1>
                </div>
            </div>
            <div class="container-fluid px-4">
                <div class="row d-flex justify-content-center">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="modal-body pb-5">
                                <div class="row">

                                    <div class="col-md-12">
                                        <?php echo form_open_multipart('attendances/edit_specific_payroll_sched/' . $SPECIFIC_PAYROLL_SCHEDULES->id); ?>
                                        <div class="form-group">
                                            <label class="" for="input_">Title</label>
                                            <input type="text" class="form-control" name="title" id="title" value="<?= $SPECIFIC_PAYROLL_SCHEDULES->name ?>">
                                        </div>


                                        <div class="form-group">
                                            <label class="" for="input_">Year</label>
                                            <select class="form-control" name="year" id="year" enabled="">
                                                <?php foreach ($DISP_YEARS as $year) { ?>
                                                    <option value='<?= $year->id ?>' <?= ($year->id == $SPECIFIC_PAYROLL_SCHEDULES->year) ? 'selected' : '' ?>><?= $year->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Month</label>
                                            <select class="form-control" name="month">
                                                <?php foreach ($DISP_MONTHS as $month) { ?>
                                                    <option value='<?= $month ?>' <?= $SPECIFIC_PAYROLL_SCHEDULES->month == $month ? 'selected' : '' ?>><?= $month ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="start_date">Start Date</label>
                                            <input type="date" class="form-control " name="start_date" id="start_date" value="<?= $SPECIFIC_PAYROLL_SCHEDULES->date_from ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="end_date">End Date</label>
                                            <input type="date" class="form-control " name="end_date" id="end_date" value="<?= $SPECIFIC_PAYROLL_SCHEDULES->date_to ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="payout_date">Payout Date</label>
                                            <input type="date" class="form-control " name="payout_date" id="payout_date" value="<?= $SPECIFIC_PAYROLL_SCHEDULES->payout ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="payslip_schedule_viewing">Payslip Schedule Viewing</label>
                                            <input type="datetime-local" class="form-control" name="payslip_schedule_viewing" id="payslip_schedule_viewing" value="<?= $SPECIFIC_PAYROLL_SCHEDULES->payslip_sched ?>" required>
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
                                                        <option value='<?= $PAYROLL_SCHEDULE->id ?>' <?= ($PAYROLL_SCHEDULE->id == $SPECIFIC_PAYROLL_SCHEDULES->connected_period) ? 'selected' : '' ?>><?= $PAYROLL_SCHEDULE->name ?></option>
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
                                                        <option value='<?= $PAYROLL_SCHEDULE->id ?>' <?= ($PAYROLL_SCHEDULE->id == $SPECIFIC_PAYROLL_SCHEDULES->connected_period_2) ? 'selected' : '' ?>><?= $PAYROLL_SCHEDULE->name ?></option>
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
                                                        <option value='<?= $PAYROLL_SCHEDULE->id ?>' <?= ($PAYROLL_SCHEDULE->id == $SPECIFIC_PAYROLL_SCHEDULES->connected_period_3) ? 'selected' : '' ?>><?= $PAYROLL_SCHEDULE->name ?></option>
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
                                                        <option value='<?= $PAYROLL_SCHEDULE->id ?>' <?= ($PAYROLL_SCHEDULE->id == $SPECIFIC_PAYROLL_SCHEDULES->connected_period_4) ? 'selected' : '' ?>><?= $PAYROLL_SCHEDULE->name ?></option>
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
                                                        <option value='<?= $PAYROLL_SCHEDULE->id ?>' <?= ($PAYROLL_SCHEDULE->id == $SPECIFIC_PAYROLL_SCHEDULES->connected_period_5) ? 'selected' : '' ?>><?= $PAYROLL_SCHEDULE->name ?></option>
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
                                                    <input type="checkbox" class="form-control mx-2" id="input_sss" name="input_sss" style="width: 20px; height: 20px; font-size: 13px; color:green;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_sss == "0") ? 'checked' : '' ?>>
                                                    <label for="cb_sss" class="mr-4"> SSS Contribution</label><br>
                                                </div>
                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_phil" name="input_phil" style="width: 20px; height:20px; font-size: 13px;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_philhealth == "0") ? 'checked' : '' ?>>
                                                    <label for="cb_phil" class="mr-4"> Philhealth Contribution</label><br>
                                                </div>
                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_pagibig" name="input_pagibig" style="width: 20px; height:20px; font-size: 13px;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_pagibig == "0") ? 'checked' : '' ?>>
                                                    <label for="cb_pagibig" class="mr-4"> Pag-ibig Contribution</label><br>
                                                </div>
                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_wtax" name="input_wtax" style="width: 20px; height:20px; font-size: 13px;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_withholding == "0") ? 'checked' : '' ?>>
                                                    <label for="cb_wtax" class="mr-4"> Withholding Tax</label><br>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_tax_allowance" name="input_tax_allowance" style="width: 20px; height:20px; font-size: 13px;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_taxable == "0") ? 'checked' : '' ?>>
                                                    <label for="cb_ti" class="mr-4"> Taxable Allowance</label><br>
                                                </div>

                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_nontax_allowance" name="input_nontax_allowance" style="width: 20px; height:20px; font-size: 13px;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_nontaxable == "0") ? 'checked' : '' ?>>
                                                    <label for="cb_nti" class="mr-4"> Non-Taxable Allowance</label><br>
                                                </div>

                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_loans" name="input_loans" style="width: 20px; height:20px; font-size: 13px;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_loans == "0") ? 'checked' : '' ?>>
                                                    <label for="cb_loans" class="mr-4">Loans</label><br>
                                                </div>
                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_adjustment" name="input_adjustment" style="width: 20px; height:20px; font-size: 13px;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_adjustment == "0") ? 'checked' : '' ?>>
                                                    <label for="cb_loans" class="mr-4">Adjustment</label><br>
                                                </div>
                                                <div class="d-flex">
                                                    <input type="checkbox" class="form-control mx-2" id="input_tard" name="input_tard" style="width: 20px; height:20px; font-size: 13px;" <?= ($SPECIFIC_PAYROLL_SCHEDULES->chk_tardiness == "0") ? 'checked' : '' ?>>
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

</body>

<script>
    const payFrequency = "<?= $SPECIFIC_PAYROLL_SCHEDULES->pay_frequency ?>";
    const selectElement = document.getElementById("pay_freq");

    for (let i = 0; i < selectElement.options.length; i++) {
        if (selectElement.options[i].value === payFrequency) {
            selectElement.selectedIndex = i;
            break;
        }
    }


    const status = "<?= $SPECIFIC_PAYROLL_SCHEDULES->status ?>";
    const statusElement = document.getElementById("status");

    for (let i = 0; i < statusElement.options.length; i++) {
        if (statusElement.options[i].value === status) {
            statusElement.selectedIndex = i;
            break;
        }
    }
</script>

</html>