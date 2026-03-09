<html>
<?php $this->load->view('templates/css_link'); ?>
<?php
$year_data      = $this->input->get('year');
$pay_frequency  = $this->input->get('pay_frequency');
?>
<style>
    .action_btn {
        display: flex !important;
        flex-direction: row !important;
        justify-content: center !important;
        align-items: center !important;
        margin: 0 auto;
        width: 100%;
    }

    .button-title {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        gap: 4px;
    }

    .pay_sched-gear {
        cursor: pointer;
    }
</style>

<html>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'attendances'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                    </a>&nbsp;Payroll Schedule<h1>
            </div>
            <div class="col-md-6 button-title">
                <a href="<?= base_url() . 'attendances/add_payroll_sched'; ?>" class=" btn btn-primary shadow-none rounded"><img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
                    &nbsp;Add Period</a>
            </div>
        </div>

        <hr>

        <div class="row my-3">
            <div class="col-12 col-lg-6 d-flex">
                <div class="form-group col-6 w-25">
                    <label>Year</label>
                    <select class="paysched-year form-control">
                        <?php foreach ($C_YEARS as $year) { ?>
                            <!-- <option value="<?= $year->name ?>" <?= $year_data == $year->name ? 'selected' : ''  ?>><?= $year->name ?></option> -->
                            <option value="<?= $year->name ?>" <?= (isset($year_data) && $year_data == $year->name) || (!isset($year_data) && $currentYear == $year->name) ? 'selected' : '' ?>><?= $year->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-6 w-25">
                    <label>Pay Frequency</label>
                    <select class="paysched-frequency form-control">
                        <option value="Semi-Monthly">Semi-Monthly</option>
                        <option value="Weekly" <?= $pay_frequency == 'Weekly' ? 'selected' : '' ?>>Weekly</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="row justify-content-evenly">
            <?php foreach ($MONTHS as $key => $month) {  ?>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h5 class="card-title"><?= $key ?></h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered">
                                <tbody>
                                    <?php if ($month) { ?>
                                        <?php foreach ($month as $row_data) {  ?>
                                            <tr>
                                                <td class="text-center"><?= $row_data->name ?></td>
                                                <td class="text-center"><?= $row_data->date_range ?></td>
                                                <td class="text-center d-flex justify-content-center ">
                                                    <img class="ml-2" style="width: 20px; height: 20px; " src="<?= base_url('assets_system/icons/gear-solid_sm_gray.svg') ?>" alt="" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false" />
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <a class="dropdown-item" href="<?= site_url('attendances/payroll_sched/' . $row_data->id) ?>">Details</a>
                                                        <a class="dropdown-item" href="<?= site_url('attendances/payroll_status') ?>?period=<?= $row_data->id ?>&tab=pending">Payroll status</a>
                                                        <a class="dropdown-item" href="<?= site_url('attendances/edit_payroll_sched/' . $row_data->id) ?>">Edit</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td class="text-center" col-span=3>No Records</td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php $this->load->view('templates/jquery_link'); ?>

<?php if ($this->session->userdata('SESS_SUCCESS')) { ?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success',
            subtitle: 'close',
            body: '<?php echo $this->session->userdata('SESS_SUCCESS'); ?>'
        })
    </script>
<?php $this->session->unset_userdata('SESS_SUCCESS');
} ?>

<script>
    (function() {
            $(document).ready(function() {
                $('select.paysched-year,select.paysched-frequency').on('change', function() {
                    let year = $('select.paysched-year').val();
                    let frequency = $('select.paysched-frequency').val();
                    window.location.href = "<?= site_url('attendances/payroll_schedules') ?>" + "?year=" + year + '&pay_frequency=' + frequency;
                })

            })

        }

    )(jQuery)
</script>


</html>