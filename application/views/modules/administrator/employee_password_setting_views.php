<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/companycontribution_style'); ?>
<style>
    .image {
        display: flex;
        flex-direction: column;
    }

    .image p {
        margin-left: 8px;
        font-size: 12px;
    }
</style>
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
                    <h1 style="font-size: 24px;" class="page-title"><a href="<?= base_url() . 'administrators'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;General Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>

            <div class="mx-auto card d-block d-lg-none col-11">
                <div class="form-group row d-flex justify-content-center">
                    <label for="" class="col-10">Select Settings</label>
                    <select name="" class="form-control col-10" id="settingsDropdown">
                        <option value="system_setup">
                            System Setup
                        </option>
                        <option value="home">
                            Home
                        </option>
                        <option value="company_structure">
                            Company Structure
                        </option>
                        <option value="administrators">
                            Administrators
                        </option>
                        <option value="payroll_officers">
                            Payroll Officers
                        </option>
                        <option value="employee_pass" selected>
                            Employee Password Management
                        </option>
                        <option value="self_service_settings">
                            Self Service Settings
                        </option>
                        <option value="date_format_settings">
                            Date Format Settings
                        </option>
                    </select>
                </div>
            </div>

            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
                <div class="card col-xl-8 col-lg-4 col-md-8 col-11" style="min-height:700px ">
                    <div class="row">
                        <div class="col-2 d-none d-lg-block">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link" href="<?= site_url('administrators/generalsettings') ?>">System Setup</a>
                                <a class="nav-link" href="<?= site_url('administrators/home_settings') ?>">Home</a>
                                <a class="nav-link " href="<?= site_url('administrators/company_settings') ?>">Company Structure</a>
                                <a class="nav-link" href="<?= site_url('administrators/administrator_settings') ?>">Administrators</a>
                                <a class="nav-link" href="<?= site_url('administrators/payroll_settings') ?>">Payroll Officers</a>
                                <a class="nav-link active" href="<?= site_url('administrators/employee_password_settings') ?>">Employee Password Management</a>
                                <a class="nav-link" href="<?= site_url('administrators/self_service_settings') ?>">Self Service Settings</a>
                                <a class="nav-link" href="<?= site_url('administrators/date_format_settings') ?>">Date Format Settings</a>
                            </div>
                        </div>
                        <div class="col">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-system_setup" role="tabpanel" aria-labelledby="v-pills-system_setup-tab">
                                    <form action="<?= base_url('administrators/update_employee_password_enable_disable') ?>" method="Post">
                                        <div class="row mt-3 ">
                                            <div class="col-12 col-lg-6 m-2 d-flex align-items-center justify-content-between">
                                                <div class="col-6">
                                                    <div class="">
                                                        <label for="">Allow Forgot Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 d-flex justify-content-center justify-content-lg-end">
                                                    <label class="switch ml-3">
                                                        <input type="hidden" class="setting" name="forgot_pass_disable_enable" value="0">
                                                        <input name="forgot_pass_disable_enable" class="switch_on" value="1" type="checkbox" <?= $forgot_pass_disable_enable == 1 ? 'checked' : '' ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit" class="mt-5 mt-lg-0 btn btn-primary ml-auto d-block"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                                    </form>
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
</div>

<aside class="control-sidebar control-sidebar-dark">
</aside>
<?php $this->load->view('templates/jquery_link'); ?>

<?php
if ($this->session->userdata('SESS_UPDATE')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_UPDATE'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_UPDATE');
}
?>

<?php
if ($this->session->userdata('SESS_SUCC_UPDATE')) {
?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success',
            subtitle: 'close',
            body: '<?php echo $this->session->userdata('SESS_SUCC_UPDATE'); ?>'
        })
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_UPDATE');
}
?>

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
    $(document).ready(function() {

        $('#settingsDropdown').on('change', function() {
            var selectedValue = $(this).val();

            if (selectedValue === 'system_setup') {
                window.location.href = '<?= base_url('administrators/generalsettings') ?>';
            }
            if (selectedValue === 'home') {
                window.location.href = '<?= base_url('administrators/home_settings') ?>';
            }
            if (selectedValue === 'company_structure') {
                window.location.href = '<?= base_url('administrators/company_settings') ?>';
            }
            if (selectedValue === 'administrators') {
                window.location.href = '<?= base_url('administrators/administrator_settings') ?>';
            }
            if (selectedValue === 'payroll_officers') {
                window.location.href = '<?= base_url('administrators/payroll_settings') ?>';
            }
            if (selectedValue === 'employee_pass') {
                window.location.href = '<?= base_url('administrators/employee_password_settings') ?>';
            }
            if (selectedValue === 'self_service_settings') {
                window.location.href = '<?= base_url('administrators/self_service_settings') ?>';
            }
        });
    });
</script>
