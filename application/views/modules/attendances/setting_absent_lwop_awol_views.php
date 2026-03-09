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
                        <option value="general">
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
                        <option value="remote_in_out" selected>
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
                                <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <span style="font-weight: 500; font-size: 18px">Absences</span>

                                    <div class="float-right">
                                        <button type="submit" id="btn-submit" class="btn btn-primary ml-3 d-block">
                                            <img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update
                                        </button>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <!-- <i>Note: LWOP, Offset, Vacation, Sick Leaves are permanent leave types.</i> -->
                                </div>
                            </div>
                            <hr>

                            <form action="<?= base_url('attendances/update_setting_absences') ?>" id="update_form" method="post">
                                <div class="row">
                                    <div class="col-12 col-lg-10 m-2 align-items-center row ">
                                        <div class="col-6 col-lg-4">
                                            <label for="">lwop & awol to Absent</label>
                                        </div>
                                        <div class="col-6 col-lg-8">
                                            <label class="switch ml-3">
                                                <input type="hidden" class="setting" name="absent_lwop_awol" value="<?= $DISP_ABSENT; ?>">
                                                <input class="switch_on" type="checkbox" <?= ($DISP_ABSENT == '1') ? 'checked' : "" ?> >
                                                <span class="slider round"></span>
                                            </label>
                                        </div>

                                    </div>
                                </div>

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

<?php if ($this->session->userdata('SESS_FAILED')) { ?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-danger toast_width',
            title: 'Failed',
            subtitle: 'close',
            body: '<?php echo $this->session->userdata('SESS_FAILED'); ?>'
        })
    </script>
<?php $this->session->unset_userdata('SESS_FAILED');
} ?>


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
        $('#btn-submit').on('click',function(){
            $('form#update_form').submit();
        })
    });
</script>