<?php $this->load->view('templates/companycontribution_style'); ?>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->

<?php ?>

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

    input[type=number] {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="flex-fill">

            <div class="row p-0">
                <div class="col-md-6">
                    <h1 class="page-title"><a href="<?= base_url() . 'superadministrators'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;Configurations<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>

            <div class="mx-auto card d-block d-lg-none col-11">
                <div class="form-group row d-flex justify-content-center">
                    <label for="" class="col-10">Navigate Settings</label>
                    <select name="" class="form-control col-10" id="settingsDropdown">
                        <option value="config">
                            Configurations
                        </option>
                        <option value="system_reset">
                            System Reset
                        </option>
                    </select>
                </div>
            </div>

            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
                <div class="card col-xl-8 col-lg-4 col-md-8 col-11" style="min-height:700px ">
                    <div class="row">
                        <div class="col-md-3 d-none d-lg-block">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?php $this->load->view('templates/configuration_nav_views'); ?>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12 ml-3">
                                    <span style="font-weight: 500; font-size: 18px">Configurations</span>
                                </div>

                                <div class="col-md-12">
                                    <!-- <i>Note: LWOP, Offset, Vacation, Sick Leaves are permanent leave types.</i> -->
                                </div>
                            </div>
                            <hr>

                            <form action="<?= base_url('superadministrators/update_configurations') ?>" method="post">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="row m-2 d-flex align-items-center ">
                                            <div class="col-6">
                                                <label for="username">Maximum Users</label>
                                            </div>
                                            <div class="col-6 d-flex justify-content-center justify-content-lg-end">
                                                <input id="username" class="form-control" type="text" name="max_active_user" style="width: 80px" value="<?= $max_active_user['value'] ?>">
                                            </div>
                                        </div>


                                        <div class="row m-2 d-flex align-items-center justify-content-between ">
                                            <div class="col-6">
                                                <label for="">Maintenance</label>
                                            </div>
                                            <div class="col-6 d-flex justify-content-center justify-content-lg-end">
                                                <label class="switch ml-3">
                                                    <input class="switch_on" type="checkbox" name="maintenance" <?= $maintenance['value'] == '1' ? 'checked' : ''; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row m-2 d-flex align-items-center justify-content-between">
                                            <div class="col-6">
                                                <label for="">Time Out</label>
                                            </div>
                                            <div class="col-6 d-flex justify-content-center justify-content-lg-end">
                                                <label class="switch ml-3">
                                                    <input class="switch_on" type="checkbox" id='time_out_enable' name="time_out_enable" <?= $time_out['value'] != '0' ? 'checked' : ''; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div id="time_out_minutes_div" class="col-5 m-2 align-items-center justify-content-between d-none <?= $time_out['value'] != '0' ? 'd-flex' : ''; ?>">
                                            <div class="">
                                                <label for="">Minutes</label>
                                            </div>
                                            <div class="" style="max-width: 60px">
                                                <input id="time_out" class="form-control" type="number" name="time_out" value="<?= $time_out['value'] ?>">
                                            </div>
                                        </div>

                                        <div class="row m-2 d-flex align-items-center justify-content-between">
                                            <div class="col-6">
                                                <label for="">Auto Login (For HRMS Dev Only!!!)</label>
                                            </div>
                                            <div class="col-6 d-flex justify-content-center justify-content-lg-end">
                                                <label class="switch ml-3">
                                                    <input class="switch_on" value='0' type="hidden" id='auto_login' name="auto_login" >
                                                    <input class="switch_on" value='1' type="checkbox" id='auto_login' name="auto_login" <?= $auto_login != '0' ? 'checked' : ''; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="mt-4 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />
                                        &nbsp;Update</button>
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


<?php if ($this->session->flashdata('SUCC')) { ?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success!',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('SUCC'); ?>'
        })
    </script>
<?php } ?>


<?php if ($this->session->flashdata('ERR')) { ?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('ERR'); ?>'
        })
    </script>
<?php } ?>

<script>
    const enableButton = document.getElementById('time_out_enable');
    const targetDiv = document.getElementById('time_out_minutes_div');
    enableButton.addEventListener('change', function() {
        if (enableButton.checked) {
            targetDiv.classList.add('d-flex');
        } else {
            targetDiv.classList.remove('d-flex');
            document.getElementById('time_out').value = 0;
        }
    });
</script>

<script>
    $(document).ready(function() {
        let base_url = '<?= base_url() ?>'
        $('#btn_reset').on("click", function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(base_url + "superadministrators/system_data_reset").then((result) => {
                        console.log(result);
                        Swal.fire(
                            'Deleted!',
                            'Tables have been reset.',
                            'success'
                        )
                    })

                }
            })

        })

    })
</script>
<script>
    $(document).ready(function() {

        $('#settingsDropdown').on('change', function() {
            var selectedValue = $(this).val();

            if (selectedValue === 'config') {
                window.location.href = '<?= base_url('superadministrators/configurations') ?>';
            }
            if (selectedValue === 'system_reset') {
                window.location.href = '<?= base_url('superadministrators/system_reset') ?>';
            }
           

        });
    });
</script>