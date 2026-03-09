<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/companycontribution_style'); ?>

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
    <div class="p-3">
        <div class="flex-fill">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>administrators">Administrator</a>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Company Structure Settings
                    </li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-md-6">
                    <h1 class="page-title"><a href="<?= base_url() . 'administrators'; ?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Company Structure Settings<h1>
                </div>

                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>

            <hr>
            <div class="row ">
                <div class="card col-xl col-lg-4 col-md-6 col-12 ml-2">
                    <form action="<?php echo base_url() . 'administrators/update_setting'; ?>" method="post" accept-charset="utf-8" class="p-0">
                        <div class="card-header mt-0 p-0">
                            <strong> Company </strong>
                        </div>

                        <div class="card-body d-flex justify-content-center">
                            <label class="switch p-0">
                                <input type="hidden" name="id" value="<?= $C_COM_COMPANY->id ?>">
                                <input class="switch_on p-0" type="checkbox" <?= $C_COM_COMPANY->value == '1' ? 'checked' : ''; ?> name="check_status">
                                <span class="slider round" id="branch"></span>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="card col-xl col-lg-4 col-md-6 col-12 ml-2">
                    <form action="<?php echo base_url() . 'administrators/update_setting'; ?>" method="post" accept-charset="utf-8" class="p-0">
                        <div class="card-header mt-0 p-0">
                            <strong> Branch </strong>
                        </div>

                        <div class="card-body d-flex justify-content-center">
                            <label class="switch p-0">
                                <input type="hidden" name="id" value="<?= $C_COM_STRUCTURE[32]->id ?>">
                                <input class="switch_on p-0" type="checkbox" <?= $C_COM_STRUCTURE[32]->value == '1' ? 'checked' : ''; ?> name="check_status">
                                <span class="slider round" id="branch"></span>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="card col-xl col-lg-4 col-md-6 col-12 ml-2">
                    <form action="<?php echo base_url() . 'administrators/update_setting'; ?>" method="post" accept-charset="utf-8" class="p-0">
                        <div class="card-header mt-0 p-0">
                            <strong> Department </strong>
                        </div>

                        <div class="card-body d-flex justify-content-center">
                            <label class="switch p-0">
                                <input type="hidden" name="id" value="<?= $C_COM_STRUCTURE[33]->id ?>">
                                <input class="switch_on p-0" type="checkbox" <?= $C_COM_STRUCTURE[33]->value == '1' ? 'checked' : ''; ?> name="check_status">
                                <span class="slider round" id="department"></span>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="card col-xl col-lg-4 col-md-6 col-12 ml-2">
                    <form action="<?php echo base_url() . 'administrators/update_setting'; ?>" method="post" accept-charset="utf-8" class="p-0">
                        <div class="card-header mt-0 p-0">
                            <strong> Division </strong>
                        </div>

                        <div class="card-body d-flex justify-content-center">
                            <label class="switch p-0">
                                <input type="hidden" name="id" value="<?= $C_COM_STRUCTURE[34]->id ?>">
                                <input class="switch_on p-0" type="checkbox" <?= $C_COM_STRUCTURE[34]->value == '1' ? 'checked' : ''; ?> name="check_status">
                                <span class="slider round" id="division"></span>
                            </label>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row ">
                <div class="card col-xl col-lg-4 col-md-6 col-12 ml-2">
                    <form action="<?php echo base_url() . 'administrators/update_setting'; ?>" method="post" accept-charset="utf-8" class="p-0">
                        <div class="card-header mt-0 p-0">
                            <strong> Section </strong>
                        </div>

                        <div class="card-body d-flex justify-content-center">
                            <label class="switch p-0">
                                <input type="hidden" name="id" value="<?= $C_COM_STRUCTURE[35]->id ?>">
                                <input class="switch_on p-0" type="checkbox" <?= $C_COM_STRUCTURE[35]->value == '1' ? 'checked' : ''; ?> name="check_status">
                                <span class="slider round" id="section"></span>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="card col-xl col-lg-4 col-md-6 col-12 ml-2">
                    <form action="<?php echo base_url() . 'administrators/update_setting'; ?>" method="post" accept-charset="utf-8" class="p-0">
                        <div class="card-header mt-0 p-0">
                            <strong> Groups </strong>
                        </div>

                        <div class="card-body d-flex justify-content-center">
                            <label class="switch p-0">
                                <input type="hidden" name="id" value="<?= $C_COM_STRUCTURE[36]->id ?>">
                                <input class="switch_on p-0" type="checkbox" <?= $C_COM_STRUCTURE[36]->value == '1' ? 'checked' : ''; ?> name="check_status">
                                <span class="slider round" id="groups"></span>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="card col-xl col-lg-4 col-md-6 col-12 ml-2">
                    <form action="<?php echo base_url() . 'administrators/update_setting'; ?>" method="post" accept-charset="utf-8" class="p-0">
                        <div class="card-header mt-0 p-0">
                            <strong> Team </strong>
                        </div>

                        <div class="card-body d-flex justify-content-center">
                            <label class="switch p-0">
                                <input type="hidden" name="id" value="<?= $C_COM_STRUCTURE[37]->id ?>">
                                <input class="switch_on p-0" type="checkbox" <?= $C_COM_STRUCTURE[37]->value == '1' ? 'checked' : ''; ?> name="check_status">
                                <span class="slider round" id="team"></span>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="card col-xl col-lg-4 col-md-6 col-12 ml-2">
                    <form action="<?php echo base_url() . 'administrators/update_setting'; ?>" method="post" accept-charset="utf-8" class="p-0">
                        <div class="card-header mt-0 p-0">
                            <strong> Line </strong>
                        </div>

                        <div class="card-body d-flex justify-content-center">
                            <label class="switch p-0">
                                <input type="hidden" name="id" value="<?= $C_COM_STRUCTURE[38]->id ?>">
                                <input class="switch_on p-0" type="checkbox" <?= $C_COM_STRUCTURE[38]->value == '1' ? 'checked' : ''; ?> name="check_status[]">
                                <span class="slider round" id="line"></span>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<aside class="control-sidebar control-sidebar-dark"></aside>
    
<?php $this->load->view('templates/jquery_link'); ?>
<script>
    $(document).ready(function() {
        $('input.switch_on').on('change', function() {
            const atLeastOneEnabled = $("input.switch_on:checked").length > 0;
            if (atLeastOneEnabled) {
                let form = $(this).closest('form');
                form.submit();
            } else {
                Swal.fire(
                    'Warning',
                    'Must have atleast one enabled',
                    'warning'
                )
                $(this).prop('checked', true);
            }
        })

    });
</script>