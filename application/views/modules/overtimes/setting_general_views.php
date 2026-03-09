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
                    <h1 class="page-title"><a href="<?= base_url() . 'overtimes'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;Overtime Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>

            <div class="mx-auto card py-2 d-block d-lg-none col-12">
                <div class=" form-group row d-flex justify-content-center">
                    <label for="" class="col-11 ml-1 ">Navigate settings</label>

                    <select name="" class="form-control  col-11" id="settingsDropdown">
                        <option value="general" Selected>
                            General
                        </option>
                        <option value="overtime_step" >
                            Overtime Step
                        </option>
                    </select>
                    
                </div>
            </div>

            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
                <div class="card col-xl-8 col-lg-4 col-md-8 col-12" style="min-height:700px ">
                    <form action="<?= base_url('overtimes/update_setting_employee_list') ?>" method="post">
                        <div class="row">
                            <div class="col-md-3 d-none d-lg-inline">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <?php $this->load->view('templates/settings_overtime_nav_views'); ?>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row mx-2">
                                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                                        <span style="font-weight: 500; font-size: 18px">General</span>
                                        <button type="submit" class=" btn btn-primary submit_form"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                                    </div>

                                    <div class="col-md-12">
                                        <!-- <i>Note: LWOP, Offset, Vacation, Sick Leaves are permanent leave types.</i> -->
                                    </div>
                                </div>
                                <hr>

                                <div class="row mx-3">
                                    <div>
                                        <div class="form-group">
                                            <label for="employee_list">Employee List</label>
                                            <!-- <input type="number" class="form-control" value="<?php echo $employee_list; ?>" step="0.01" name="employee_list" id="employee_list" aria-describedby="employee_list" placeholder=""> -->
                                            <select class="form-control" name="employee_list" id="employee_list">
                                                <option value="showAll" <?= $employee_list == "showAll" ? 'selected' : ''; ?>>Show All</option>
                                                <option value="membersOnly" <?= $employee_list == "membersOnly" ? 'selected' : ''; ?>>Members Only</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <!-- <button type="submit" class="btn btn-primary ml-auto d-block"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;"  src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button> -->
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
                    title: "Update overtime settings",
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
                window.location.href = '<?= base_url('overtimes/overtimes/setting_general') ?>';
            }
            
            if (selectedValue === 'overtime_step') {
                window.location.href = '<?= base_url('overtimes/overtimes/overtime_step') ?>';
            }
            
        });
    });
</script>