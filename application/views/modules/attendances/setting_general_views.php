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
                    <h1 class="page-title"><a href="<?= base_url() . 'attendances'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;Attendance Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>

            <div class="mx-auto card d-block d-lg-none col-11">
                <div class="form-group row d-flex justify-content-center">
                    <label for="" class="col-10">Navigate Settings</label>
                    <select name="" class="form-control col-10" id="settingsDropdown">
                        <option value="general" selected>
                            General
                        </option>
                        <option value="holidays">
                            Holidays
                        </option>
                        <option value="years">
                            Years
                        </option>

                        <option value="biometrics">
                            Biometrics
                        </option>
                        <option value="remote_in_out">
                            Remote In Out
                        </option>
                        <option value="geofences">
                            Geofences
                        </option>

                    </select>
                </div>
            </div>

            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
                <div class="card col-xl-8 col-lg-4 col-md-8 col-11" style="min-height:700px ">
                    <div class="row">
                        <div class="col-md-3 d-none d-lg-inline-block">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?php $this->load->view('templates/settings_time_and_attendance_nav_views'); ?>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row mx-2">
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    <span style="font-weight: 500; font-size: 18px">General</span>
                                    <button type="submit" class="btn btn-primary submit_form">
                                <img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url() ?>assets_system/icons/circle-arrow-up-sharp-solid.svg" alt="">&nbsp;Update
                            </button>
                                </div>

                              
                            </div>
                            <hr>

                            <form action="<?= base_url('attendances/update_setting_general') ?>" method="post">
                                <div class="row">
                                    <div class="col-12 col-lg-10 row d-flex align-items-center justify-content-center">
                                        <div class="col-12 row mb-4">
                                            <div class="col-12 col-lg-6">
                                                <label for="min_hours_present">Minimum Work hours to consider 1-day present</label>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <select name="min_hours_present" id="min_hours_present" class="form-control">
                                                    <option value="1" <?= $min_hours_present['value'] == 1 ? 'selected' : '' ?>>1</option>
                                                    <option value="2" <?= $min_hours_present['value'] == 2 ? 'selected' : '' ?>>2</option>
                                                    <option value="3" <?= $min_hours_present['value'] == 3 ? 'selected' : '' ?>>3</option>
                                                    <option value="4" <?= $min_hours_present['value'] == 4 ? 'selected' : '' ?>>4</option>
                                                    <option value="5" <?= $min_hours_present['value'] == 5 ? 'selected' : '' ?>>5</option>
                                                    <option value="6" <?= $min_hours_present['value'] == 6 ? 'selected' : '' ?>>6</option>
                                                    <option value="7" <?= $min_hours_present['value'] == 7 ? 'selected' : '' ?>>7</option>
                                                    <option value="8" <?= $min_hours_present['value'] == 8 ? 'selected' : '' ?>>8</option>
                                                    <option value="9" <?= $min_hours_present['value'] == 9 ? 'selected' : '' ?>>9</option>
                                                    <option value="10" <?= $min_hours_present['value'] == 10 ? 'selected' : '' ?>>10</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-12 row mb-4">
                                            <div class="col-12 col-lg-6">
                                                <label for="dp">Late/Undertime Deduction Type</label>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <select name="timekeeping_lateunder_deduction_perminute" id="timekeeping_lateunder_deduction_perminute" class="form-control">
                                                    <option value="0" <?= $timekeeping_lateunder_deduction_perminute['value'] == 0 ? 'selected' : '' ?>>By 30 Minutes</option>
                                                    <option value="1" <?= $timekeeping_lateunder_deduction_perminute['value'] == 1 ? 'selected' : '' ?>>Per Minute</option>
                                                </select>
                                            </div>
                                        </div> -->

                                        <div class="col-12 row mb-4">
                                            <div class="col-12 col-lg-6">
                                                <label for="dp">Late Deduction Type</label>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <select name="timekeeping_late_deduction_perminute" id="timekeeping_late_deduction_perminute" class="form-control">
                                                    <option value="0" <?= $timekeeping_late_deduction_perminute['value'] == 0 ? 'selected' : '' ?>>By 30 Minutes</option>
                                                    <option value="1" <?= $timekeeping_late_deduction_perminute['value'] == 1 ? 'selected' : '' ?>>Per Minute</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 row mb-4">
                                            <div class="col-12 col-lg-6">
                                                <label for="dp">Undertime Deduction Type</label>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <select name="timekeeping_undertime_deduction_perminute" id="timekeeping_undertime_deduction_perminute" class="form-control">
                                                    <option value="0" <?= $timekeeping_undertime_deduction_perminute['value'] == 0 ? 'selected' : '' ?>>By 30 Minutes</option>
                                                    <option value="1" <?= $timekeeping_undertime_deduction_perminute['value'] == 1 ? 'selected' : '' ?>>Per Minute</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 row mb-4">
                                            <div class="col-12 col-lg-6">
                                                <label for="gp">Grace Period (min)</label>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <input id="gp" class="form-control" type="number" name="timekeeping_graceperiod" value="<?= $timekeeping_graceperiod['value'] ?>">
                                            </div>
                                        </div>

                                        <div class="col-12 row mb-4">
                                            <div class="col-6 col-lg-6">
                                                <label for="">Enable Break IN/OUT</label>
                                            </div>
                                            <div class="col-6 col-lg-6">
                                                <label class="switch ml-3">
                                                    <input type="hidden" class="setting" name="isBreakEnabled" value="0">
                                                    <input class="switch_on" type="checkbox" name="isBreakEnabled" value="1" <?= $isBreakEnabled == '1' ? 'checked' : ''; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12 row mb-4">
                                            <div class="col-6 col-lg-6">
                                                <label for="">Disregard Night Differential if less than 1 hour</label>
                                            </div>
                                            <div class="col-6 col-lg-6">
                                                <label class="switch ml-3">
                                                    <input type="hidden" class="setting" name="NDMinimum" value="0">
                                                    <input class="switch_on" type="checkbox" name="NDMinimum" value="1" <?= $NDMinimum == '1' ? 'checked' : ''; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <!-- <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary "><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="https://dev-env2.eyebox.app/assets_system/icons/circle-arrow-up-sharp-solid.svg" alt="">&nbsp;Update</button>
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
    <script>
        $(document).ready(function() {
            $('input[name$="_enable"]').change(function() {
                var sectionName = $(this).attr('name').replace('_enable', '');
                toggleSections(sectionName);
            });

            function toggleSections(sectionName) {
                var enableSwitch = $('input[name="' + sectionName + '_enable"]');
                var sections = $('.' + sectionName + '-sections');

                if (enableSwitch.is(':checked')) {
                    // sections.show();

                    sections.removeClass('d-none');
                } else {
                    // sections.hide();
                    sections.addClass('d-none');
                }
            }
        });
    </script>

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
            $(document).on('click', 'button.clear_changes', function() {
                window.location.reload();
            });

            $(document).on('click', 'button.submit_form', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Update attendance settings",
                    text: "Confirm to save the settings",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Confirm"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('form').submit();
                    }
                });
            });
        });
    </script>

<script>
    $(document).ready(function() {

        $('#settingsDropdown').on('change', function() {
            var selectedValue = $(this).val();

            if (selectedValue === 'general') {
                window.location.href = '<?= base_url('attendances/setting_general') ?>';
            }
            if (selectedValue === 'holidays') {
                window.location.href = '<?= base_url('attendances/setting_holidays') ?>';
            }
            if (selectedValue === 'years') {
                window.location.href = '<?= base_url('attendances/setting_years') ?>';
            }
            if (selectedValue === 'biometrics') {
                window.location.href = '<?= base_url('attendances/setting_biometrics') ?>';
            }
            if (selectedValue === 'remote_in_out') {
                window.location.href = '<?= base_url('attendances/setting_remote_in_out') ?>';
            }
            if (selectedValue === 'geofences') {
                window.location.href = '<?= base_url('attendances/setting_geo_fences') ?>';
            }


        });
    });
</script>