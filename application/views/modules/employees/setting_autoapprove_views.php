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
                    <h1 class="page-title"><a href="<?= base_url() . 'employees'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;Employee Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>

            <div class="mx-auto card d-block d-lg-none col-11">
                <div class="form-group row d-flex justify-content-center">
                    <label for="" class="col-10">Navigate Settings</label>
                    <select name="" class="form-control col-10" id="settingsDropdown">
                        <option value="general" >
                           General
                        </option>
                        <option value="auto_approve" selected>
                          Auto Approve
                        </option>
                        <option value="emp_types" selected>
                           Employee Types
                        </option>
                        <option value="requirements" >
                        Requirements
                        </option>
                        <option value="customized_info">
                           Customized Informations
                        </option>
                        <option value="positions">
                           Positions
                        </option>
                        <option value="departments">
                           Departments
                        </option>
                        <option value="divisions">
                           Divisions
                        </option>
                        <option value="marital_stat">
                           Marital Statuses
                        </option>
                        <option value="genders">
                           Genders
                        </option>
                        <option value="nationalities">
                           Nationalities
                        </option>
                        <option value="religions">
                           Religions
                        </option>
                        <option value="blood_types">
                           Blood Types
                        </option>
                        <option value="hmos">
                           HMOs
                        </option>
                        <option value="shirt_sizes">
                           Shirt Sizes
                        </option>
                        <option value="banks">
                           Banks
                        </option>
                        <option value="custom_groups">
                           Custom Groups
                        </option>
                    </select>
                </div>
            </div>

            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
                <div class="card col-xl-8 col-lg-4 col-md-8 col-11" style="min-height:700px ">
                    <div class="row">
                        <div class="col-md-3 d-none d-lg-inline-block">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?php $this->load->view('templates/settings_employee_nav_views'); ?>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                    <span style="font-weight: 500; font-size: 18px">Auto Approve</span>
                                    <button type="submit" class="btn btn-primary mb-2 mr-3 submit_form d-flex align-items-center">
                                    <img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url() ?>assets_system/icons/circle-arrow-up-sharp-solid.svg" alt="">&nbsp;Update
                                </button>
                                </div>

                                <div class="col-md-12">
                                    <!-- Manage leave settings and related features. These settings are applied company-wide. -->
                                </div>
                            </div>
                            <hr>
                            <?php echo form_open('employees/update_auto_approve'); ?>
                            <div class="">

                                <div class="form-group row d-flex justify-content-center">
                                    <div class="col-5 col-lg-6 mt-2  my-auto"><span class="fs-" style="font-weight: 500;">Auto Approve Column</span></div>
                                    <div class="col-7 col-lg-6 mt-3 d-flex justify-content-center justify-content-lg-start text-nowrap">
                                        <span class="mx-4 mt-1" style="text-align: right;">Show</span>
                                        <div class="mt-1">
                                            <label class="switch enable-switch">
                                                <input type="hidden" name="auto_approve" value="0">
                                                <input class="switch_on" name="auto_approve" value="1" <?= $auto_approve == '1' ? 'checked' : '' ?> type="checkbox"><span class="slider round"></span>
                                            </label>
                                        </div>
                                        <span class="mx-4 mt-1">Hide</span>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <hr>
                                </div>

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
                    title: "Are you sure you want to update?",
                    text: "Confirm to save the settings!",
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
                window.location.href = '<?= base_url('employees/setting_general') ?>';
            }
            if (selectedValue === 'auto_approve') {
                window.location.href = '<?= base_url('employees/setting_auto_approve') ?>';
            }
            if (selectedValue === 'emp_types') {
                window.location.href = '<?= base_url('employees/employee_types') ?>';
            }
            if (selectedValue === 'requirements') {
                window.location.href = '<?= base_url('employees/requirements') ?>';
            }
            if (selectedValue === 'customized_info') {
                window.location.href = '<?= base_url('employees/customize_informations') ?>';
            }
            if (selectedValue === 'positions') {
                window.location.href = '<?= base_url('employees/positions') ?>';
            }
   
            if (selectedValue === 'departments') {
                window.location.href = '<?= base_url('employees/departments') ?>';
            }
            if (selectedValue === 'divisions') {
                window.location.href = '<?= base_url('employees/divisions') ?>';
            }
            if (selectedValue === 'marital_stat') {
                window.location.href = '<?= base_url('employees/marital_statuses') ?>';
            }
            if (selectedValue === 'genders') {
                window.location.href = '<?= base_url('employees/genders') ?>';
            }
            if (selectedValue === 'nationalities') {
                window.location.href = '<?= base_url('employees/nationalities') ?>';
            }
            if (selectedValue === 'religions') {
                window.location.href = '<?= base_url('employees/religions') ?>';
            }
            if (selectedValue === 'blood_types') {
                window.location.href = '<?= base_url('employees/blood_types') ?>';
            }
            if (selectedValue === 'hmos') {
                window.location.href = '<?= base_url('employees/hmos') ?>';
            }
            if (selectedValue === 'shirt_sizes') {
                window.location.href = '<?= base_url('employees/shirt_sizes') ?>';
            }
            if (selectedValue === 'banks') {
                window.location.href = '<?= base_url('employees/banks') ?>';
            }
            if (selectedValue === 'custom_groups') {
                window.location.href = '<?= base_url('employees/settings_custom_groups') ?>';
            }
            

        });
    });
</script>