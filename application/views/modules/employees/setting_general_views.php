<?php $this->load->view('templates/companycontribution_style'); ?>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />

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
                        <option value="general" selected>
                           General
                        </option>
                        <option value="emp_types" >
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
                <div class="card col-xl-8 col-lg-4 col-md-8 col-11 " style="min-height:700px ">
                    <div class="row mx-2">
                        <div class="col-md-3 d-none d-lg-inline-block">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?php $this->load->view('templates/settings_employee_nav_views'); ?>
                            </div>
                        </div>
                        <div class="col-md-9 ">
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <span style="font-weight: 500; font-size: 18px">General</span>
                                    <button class="btn btn-primary" style="" onclick="update_setting_general()"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;"  src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                                </div>

                                <div class="col-md-12">

                                </div>
                            </div>


                            <hr>
                            <div class="form-group">
                                <label for="num_approvers">Number of Approvers for Leave, Overtime and Time Adjustment Applications</label>
                                <select style="max-width: 60px;" class="form-control" id="num_approvers" value="">
                                    <option value="0" <?= $num_approvers == 0 ? 'selected' : '' ?>>0</option>
                                    <option value="1" <?= $num_approvers == 1 ? 'selected' : '' ?>>1</option>
                                    <option value="2" <?= $num_approvers == 2 ? 'selected' : '' ?>>2</option>
                                    <option value="3" <?= $num_approvers == 3 ? 'selected' : '' ?>>3</option>
                                    <option value="4" <?= $num_approvers == 4 ? 'selected' : '' ?>>4</option>
                                    <option value="5" <?= $num_approvers == 5 ? 'selected' : '' ?>>5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="multiple_request">Multiple Request</label>
                                <label class="switch">
                                    <input id="multiple_request"  class="switch_on"  type="checkbox" name="multiple_request"  <?= $multiple_request == '1' ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="multiple_request">Allow Forgot Password</label>
                                <label class="switch">
                                    <input id="forgot_pass_disable_enable"  class="switch_on"  type="checkbox" name="forgot_pass_disable_enable"  <?= $forgot_pass_disable_enable == '1' ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="d-flex justify-content-center">
                               <!-- <button class="btn btn-primary" onclick="update_setting_general()"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;"  src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button> -->
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

<script>
    function update_setting_general() {
        const num_approvers = document.getElementById('num_approvers').value;
        const multiple_request = document.getElementById('multiple_request').checked? 1 : 0;
        const forgot_pass_disable_enable = document.getElementById('forgot_pass_disable_enable').checked? 1 : 0;

        console.log('num_approvers', num_approvers)
        console.log('multiple_request', multiple_request)
        var url = '<?= base_url() ?>';


        // fetch(url + 'employees/update_approver_count', {
        fetch(url + 'employees/update_setting_general', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({num_approvers,multiple_request,forgot_pass_disable_enable})
            })
            .then(response => {
                console.log('response', response);
                if (response.url.includes('login/session_expired')) {
                    window.location.href = "<?=base_url()?>login/session_expired";
                }else{
                    return response.json();
                }
            })
            .then(result => {
                console.log('result',result);
                if (result.success_message) {
                    $(document).Toasts('create', {
                        class: 'bg-success toast_width',
                        title: 'Success!',
                        subtitle: 'close',
                        body: result.success_message
                    })
                }

                if (result.warning_message) {
                    $(document).Toasts('create', {
                        class: 'bg-warning toast_width',
                        title: 'Warning!',
                        subtitle: 'close',
                        body: result.warning_message
                    })
                }

            })
            .catch(error => {
                $(document).Toasts('create', {
                    class: 'bg-warning toast_width',
                    title: 'Warning!',
                    subtitle: 'close',
                    body: 'Please provide all required information.'
                })
                console.error('Data update error:', error);
            });
    }
</script>

<script>
    $(document).ready(function() {
    
        $('#settingsDropdown').on('change', function() {
            var selectedValue = $(this).val();

            if (selectedValue === 'general') {
                window.location.href = '<?= base_url('employees/setting_general') ?>';
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