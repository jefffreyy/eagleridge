<?php $this->load->view('templates/companycontribution_style'); ?>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->

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
                    <h1 class="page-title"><a href="<?= base_url() . 'benefits'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;Benefits Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>

            <div class="mx-auto card d-block d-lg-none col-11">
                <div class="form-group row d-flex justify-content-center">
                    <label for="" class="col-10">Select Settings</label>
                    <select name="" class="form-control col-10" id="settingsDropdown">
                        <option value="cashadvance">
                            Cash Advance Types
                        </option>
                        <option value="general_settings" selected>
                            General
                        </option>
                        <option value="loan_types">
                            Loan Types
                        </option>
                        <option value="reimbursement">
                            Reimbursement Types
                        </option>
                    </select>
                </div>
            </div>

            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
                <div class="card col-xl-8 col-lg-4 col-md-8 col-11" style="min-height:700px ">
                    <div class="row">
                        <div class="col-md-3 d-none d-lg-inline-block">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?php $this->load->view('templates/settings_benefits_nav_views'); ?>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                    <span style="font-weight: 500; font-size: 18px">General</span>
                                    <button type="submit" class="btn btn-primary mb-2 mr-3 submit_form d-flex align-items-center">
                                    <img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url() ?>assets_system/icons/circle-arrow-up-sharp-solid.svg" alt="">&nbsp;Update
                                </button>
                                </div>

                                <div class="col-md-12">
                                    <!-- Manage leave settings and related features. These settings are applied company-wide. -->
                                </div>
                            </div>
                            <hr>
                            <?php echo form_open('benefits/update_setting_general'); ?>
                            <div class="">

                                <div class="form-group row d-flex justify-content-center">
                                    <div class="col-5 col-lg-6 mt-2  my-auto"><span class="fs-" style="font-weight: 500;">Tax/Non-Tax Allowance (Start and End Column)</span></div>
                                    <div class="col-7 col-lg-6 mt-3 d-flex justify-content-center justify-content-lg-start text-nowrap">
                                        <span class="mx-4 mt-1" style="text-align: right;">Show</span>
                                        <div class="mt-1">
                                            <label class="switch enable-switch">
                                                <input type="hidden" name="tax_nontax_allowance" value="0">
                                                <input class="switch_on" name="tax_nontax_allowance" value="1" <?= $tax_nontax_allowance == '1' ? 'checked' : '' ?> type="checkbox"><span class="slider round"></span>
                                            </label>
                                        </div>
                                        <span class="mx-4 mt-1">Hide</span>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="form-group row d-flex justify-content-center">
                                    <div class="col-5 col-lg-6 mt-2  my-auto"><span class="fs-" style="font-weight: 500;">Meal Allowance</span></div>
                                    <div class="col-7 col-lg-6 mt-3 d-flex justify-content-center justify-content-lg-start text-nowrap">
                                        <span class="mx-4 mt-1" style="text-align: right;">Disable</span>
                                        <div class="mt-1">
                                            <label class="switch enable-switch">
                                                <input type="hidden" name="allowance_meal_enable" value="0">
                                                <input class="switch_on" name="allowance_meal_enable" value="1" <?= $allowance_meal_enable == '1' ? 'checked' : '' ?> type="checkbox"><span class="slider round"></span>
                                            </label>
                                        </div>
                                        <span class="mx-4 mt-1">Enable</span>
                                    </div>

                                </div>

                                <div class="form-group row d-flex justify-content-center">
                                    <div class="col-11 col-lg-6 mt-2 allowance_meal-sections <?= $allowance_meal_enable == '1' ? '' : 'd-none' ?>">&nbsp;&nbsp;&nbsp;&nbsp;Shift</div>
                                    <div class="col-11 col-md-5 mt-1 allowance_meal-sections <?= $allowance_meal_enable == '1' ? '' : 'd-none' ?>">
                                        <select class="form-control" name="allowance_meal_shift">
                                            <option value="All" <?= $allowance_meal_shift == 'All' ? 'selected' : '' ?>>All</option>
                                            <option value="Night Shift and Rest Day" <?= $allowance_meal_shift == 'Night Shift and Rest Day' ? 'selected' : '' ?>>Night Shift and Rest Day</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="form-group row  d-flex justify-content-center">
                                    <div class="col-11 col-md-6 mt-2 allowance_meal-sections <?= $allowance_meal_enable == '1' ? '' : 'd-none' ?>">&nbsp;&nbsp;&nbsp;&nbsp;Value</div>
                                    <div class="col-11 col-md-5 mt-1 allowance_meal-sections <?= $allowance_meal_enable == '1' ? '' : 'd-none' ?>">
                                        <input type="number" value="<?= intval($allowance_meal_value) ?>" name="allowance_meal_value" class="form-control" pattern="[0-9]*" title="Only numbers are allowed">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="form-group row d-flex justify-content-center">
                                    <div class="col-5 col-lg-6 mt-2  my-auto"><span class="fs-" style="font-weight: 500;">Meal Allowance By Hours</span></div>
                                    <div class="col-7 col-lg-6 mt-3 d-flex justify-content-center justify-content-lg-start text-nowrap">
                                        <span class="mx-4 mt-1" style="text-align: right;">Disable</span>
                                        <div class="mt-1">
                                            <label class="switch enable-switch">
                                                <input type="hidden" name="allowance_meal_by_hour_enable" value="0">
                                                <input class="switch_on" name="allowance_meal_by_hour_enable" value="1" <?= $allowance_meal_by_hour_enable == '1' ? 'checked' : '' ?> type="checkbox"><span class="slider round"></span>
                                            </label>
                                        </div>
                                        <span class="mx-4 mt-1">Enable</span>
                                    </div>

                                </div>

                                <div class="form-group row d-flex justify-content-center">
                                    <div class="col-11 col-lg-6 mt-2 allowance_meal_by_hour-sections <?= $allowance_meal_by_hour_enable == '1' ? '' : 'd-none' ?>">&nbsp;&nbsp;&nbsp;&nbsp;Hours</div>
                                    <div class="col-11 col-md-5 mt-1 allowance_meal_by_hour-sections <?= $allowance_meal_by_hour_enable == '1' ? '' : 'd-none' ?>">

                                        <input type="number" value="<?= intval($allowance_meal_by_hour) ?>" name="allowance_meal_by_hour" class="form-control" min="0" pattern="[0-9]*" title="Only numbers are allowed">
                                    </div>

                                </div>

                                <div class="form-group row  d-flex justify-content-center">
                                    <div class="col-11 col-md-6 mt-2 allowance_meal_by_hour-sections <?= $allowance_meal_by_hour_enable == '1' ? '' : 'd-none' ?>">&nbsp;&nbsp;&nbsp;&nbsp;Value</div>
                                    <div class="col-11 col-md-5 mt-1 allowance_meal_by_hour-sections <?= $allowance_meal_by_hour_enable == '1' ? '' : 'd-none' ?>">
                                        <input type="number" value="<?= intval($allowance_meal_by_hour_value) ?>" name="allowance_meal_by_hour_value" class="form-control" min="0" pattern="[0-9]*" title="Only numbers are allowed">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="form-group row d-flex justify-content-center mt-4">
                                    <div class="col-5 col-lg-6 my-auto ">
                                        <span style="font-weight: 500;">Rice Subsidy</span>
                                    </div>
                                    <div class="col-7 col-lg-6 mt-3 d-flex justify-content-center justify-content-lg-start text-nowrap">
                                        <span class="mx-4 mt-1" style="text-align: right;">Disable</span>

                                        <div class="mt-1">
                                            <label class="switch enable-switch">
                                                <input type="hidden" name="allowance_ricesub_enable" value="0">
                                                <input class="switch_on" name="allowance_ricesub_enable" value="1" <?= $allowance_ricesub_enable == '1' ? 'checked' : '' ?> type="checkbox"><span class="slider round"></span>
                                            </label>
                                        </div>

                                        <span class="mx-4 mt-1">Enable</span>
                                    </div>
                                </div>

                                <div class="form-group row justify-content-center">
                                    <div class="col-11 col-lg-6 mt-2 allowance_ricesub-sections <?= $allowance_ricesub_enable == '1' ? '' : 'd-none' ?>">&nbsp;&nbsp;&nbsp;&nbsp;Value</div>
                                    <div class="col-11 col-lg-5 mt-1 allowance_ricesub-sections <?= $allowance_ricesub_enable == '1' ? '' : 'd-none' ?>">
                                        <input type="number" value="<?= intval($allowance_ricesub_value) ?>" name="allowance_ricesub_value" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row justify-content-center">
                                    <div class="col-11 col-lg-6 mt-2 allowance_ricesub-sections <?= $allowance_ricesub_enable == '1' ? '' : 'd-none' ?>">&nbsp;&nbsp;&nbsp;&nbsp;Minimum Hours</div>
                                    <div class="col-11 col-lg-5 mt-1 allowance_ricesub-sections <?= $allowance_ricesub_enable == '1' ? '' : 'd-none' ?>">
                                        <input type="number" value="<?= intval($allowance_ricesub_minhours) ?>" name="allowance_ricesub_minhours" class="form-control">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="form-group row d-flex justify-content-center mt-4">
                                    <div class="col-5 col-lg-6 my-auto "><span style="font-weight: 500;">Rice Allowance</span></div>
                                    <div class="col-7 col-lg-6 mt-3 d-flex justify-content-center justify-content-lg-start text-nowrap">
                                        <div class="mx-4 mt-1" style="text-align: right;">Disable</div>
                                        <div class="mt-1">
                                            <label class="switch enable-switch">
                                                <input type="hidden" name="allowance_rice_enable" value="0">
                                                <input class="switch_on" value="1" <?= $allowance_rice_enable == '1' ? 'checked' : '' ?> name="allowance_rice_enable" value="1" type="checkbox"><span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="mx-4 mt-1">Enable</div>
                                    </div>

                                </div>

                                <div class="form-group row justify-content-center">
                                    <div class="col-11 col-lg-6 mt-2 allowance_rice-sections <?= $allowance_rice_enable == '1' ? '' : 'd-none' ?>">&nbsp;&nbsp;&nbsp;&nbsp;Value</div>
                                    <div class="col-11 col-lg-5 allowance_rice-sections <?= $allowance_rice_enable == '1' ? '' : 'd-none' ?>">
                                        <input type="number" value="<?= intval($allowance_rice_value) ?>" name="allowance_rice_value" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <div class="col-11 col-lg-6 mt-2 allowance_rice-sections <?= $allowance_rice_enable == '1' ? '' : 'd-none' ?>">&nbsp;&nbsp;&nbsp;&nbsp;Minimum Hours</div>
                                    <div class="col-11 col-lg-5 mt-1 allowance_rice-sections <?= $allowance_rice_enable == '1' ? '' : 'd-none' ?>">
                                        <input type="number" value="<?= intval($allowance_rice_minhours) ?>" name="allowance_rice_minhours" class="form-control">
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="form-group row d-flex justify-content-center mt-4">
                                    <div class="col-5 col-lg-6 mt-2"><span style="font-weight: 500;">Overtime Meal Allowance</span></div>
                                    <div class="col-7 col-lg-6 mt-3 d-flex justify-content-center justify-content-lg-start text-nowrap">
                                        <div class="mx-4 mt-1" style="text-align: right;">Disable</div>
                                        <div class="mt-1">
                                            <label class="switch enable-switch">
                                                <input type="hidden" name="allowance_otmeal_enable" value="0">
                                                <input class="switch_on" <?= $allowance_otmeal_enable == '1' ? 'checked' : '' ?> name="allowance_otmeal_enable" value="1" type="checkbox"><span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="mx-4 mt-1">Enable</div>
                                    </div>

                                </div>

                                <div class="form-group row justify-content-center">
                                    <div class="col-11 col-lg-6 mt-2 allowance_otmeal-sections <?= $allowance_otmeal_enable == '1' ? '' : 'd-none' ?>">&nbsp;&nbsp;&nbsp;&nbsp;Value</div>
                                    <div class="col-11 col-lg-5 mt-1 allowance_otmeal-sections <?= $allowance_otmeal_enable == '1' ? '' : 'd-none' ?>">
                                        <input type="number" value="<?= intval($allowance_otmeal_value) ?>" name="allowance_otmeal_value" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row justify-content-center">
                                    <div class="col-11 col-lg-6 mt-2 allowance_otmeal-sections <?= $allowance_otmeal_enable == '1' ? '' : 'd-none' ?>">&nbsp;&nbsp;&nbsp;&nbsp;Minimum Hours</div>
                                    <div class="col-11 col-lg-5 mt-1 allowance_otmeal-sections <?= $allowance_otmeal_enable == '1' ? '' : 'd-none' ?>">
                                        <input type="number" value="<?= intval($allowance_otmeal_minhours) ?>" name="allowance_otmeal_minhours" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="form-group row d-flex justify-content-center mt-4">
                                    <div class="col-5 col-lg-6 mt-2"><span style="font-weight: 500;">Transportation Allowance</span></div>
                                    <div class="col-7 col-lg-6 mt-3 d-flex justify-content-center justify-content-lg-start text-nowrap">
                                        <div class="mx-4 mt-1" style="text-align: right;">Disable</div>
                                        <div class="mt-1">
                                            <label class="switch enable-switch">
                                                <input type="hidden" name="allowance_transportaion_enable" value="0">
                                                <input class="switch_on" <?= $allowance_transportaion_enable == '1' ? 'checked' : '' ?> name="allowance_transportaion_enable" value="1" type="checkbox"><span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="mx-4 mt-1">Enable</div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="col-md-12 mt-2 d-flex justify-content-end mt-4 ">
                                    <button type="button" class="btn btn-danger py-1 clear_changes mr-2 d-flex align-items-center" style="font-size: 14px">
                                        <img class="" style="height: 1.1rem; width: 1.1rem; " src="<?= base_url('assets_system/icons/circle-x-solid_mark_as.svg') ?>">&nbsp;Clear Changes
                                    </button>

                                    <!-- <button type="submit" class="btn btn-primary pt-1 pb-1 submit_form d-flex align-items-center" style="font-size: 14px">
                                        <img class="" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>">&nbsp;Save Changes
                                    </button> -->

                                </div>
                            </div>
                            <?php echo form_close() ?>
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
                    title: "Update benefits settings",
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

                if (selectedValue === 'cashadvance') {
                    window.location.href = '<?= base_url('benefits/setting_cashadvance_types') ?>';
                }
                if (selectedValue === 'general_settings') {
                    window.location.href = '<?= base_url('benefits/setting_general') ?>';
                }
                if (selectedValue === 'loan_types') {
                    window.location.href = '<?= base_url('benefits/setting_loan_types') ?>';
                }
                if (selectedValue === 'reimbursement') {
                    window.location.href = '<?= base_url('benefits/setting_reimbursement_types') ?>';
                }

            });
        });
    </script>