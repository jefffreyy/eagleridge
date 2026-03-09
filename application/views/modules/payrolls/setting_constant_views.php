<?php $this->load->view('templates/companycontribution_style'); ?>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->

<?php
?>
<style>
    .switch {
        position: relative;
        display: block;
        width: 50px;
        height: 26px;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .switch input {
        display: none;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 21px;
        width: 21px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50px;
    }

    input:checked+.slider:before {
        background-color: limegreen;
    }

    input:checked+.slider:before {
        transform: translateX(23px);
    }
</style>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="flex-fill">

            <div class="row p-0">
                <div class="col-md-6">
                    <h1 class="page-title"><a href="<?= base_url() . 'payrolls'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;Payroll Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>

            <div class="mx-auto card d-block d-lg-none col-11">
                <div class="form-group row d-flex justify-content-center">
                    <label for="" class="col-10">Select Settings</label>
                    <select name="" class="form-control col-10" id="settingsDropdown">
                        <option value="general" selected>
                            General
                        </option>
                    </select>
                </div>
            </div>

            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
                <div class="card col-xl-8 col-lg-4 col-md-8 col-12" style="min-height:700px ">
                    <form action="<?= base_url('payrolls/update_settings') ?>" method="post">
                        <div class="row ">
                            <div class="col-md-3 d-none d-lg-inline-block">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <?php $this->load->view('templates/settings_payroll_nav_views'); ?>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row mx-2">
                                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                                        <span style="font-weight: 500; font-size: 18px">General</span>
                                        <button type="submit" class="btn btn-primary"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                                    </div>
                                </div>
                                <hr>


                                <div class="row p-3">
                                    <div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Payroll Monthly Constant</label>
                                            <input type="number" class="form-control" value="<?php echo $payroll_monthly_constant; ?>" step="0.01" name="payroll_monthly_constant" id="payroll_monthly_constant" aria-describedby="payroll_monthly_constant" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="sss_contribution">SSS Contribution</label>
                                            <select class="form-control" name="sss_contribution" id="sss_contribution">
                                                <option value="Gross Pay" <?= $sss_contribution == "Gross Pay" ? 'selected' : ''  ?>>Gross Pay</option>
                                                <option value="Basic Pay" <?= $sss_contribution == "Basic Pay" ? 'selected' : ''  ?>>Basic Pay</option>
                                                <option value="Basic Pay + OT" <?= $sss_contribution == "Basic Pay + OT" ? 'selected' : ''  ?>>Basic Pay + OT</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="thirteen_month_reference">13th Month Reference</label>
                                            <select class="form-control" name="thirteen_month_reference" id="thirteen_month_reference">
                                                <option value="Basic Pay" <?= $thirteen_month_reference == "Basic Pay" ? 'selected' : ''  ?>>Basic Pay</option>
                                                <option value="Basic Pay Without Deduction" <?= $thirteen_month_reference == "Basic Pay Without Deduction" ? 'selected' : ''  ?>>Basic Pay Without Deduction</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <!-- <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;"  src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                                </div> -->
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>


<aside class="control-sidebar control-sidebar-dark">
</aside>
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
<script>
    $(function() {
        $('input.switch_on').on('change', function() {
            if ($(this).prop('checked')) {
                $(this).siblings('input.setting').val('1')
                return;
            }
            $(this).siblings('input.setting').val('0')
        })
    });
</script>

<script>
    $(document).ready(function() {

        $('#settingsDropdown').on('change', function() {
            var selectedValue = $(this).val();

            if (selectedValue === 'general') {
                window.location.href = '<?= base_url('payrolls/setting_constant') ?>';
            }


        });
    });
</script>