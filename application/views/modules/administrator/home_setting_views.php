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
            <div class="row">
                <div class="col-md-6">
                    <h1 class="page-title"><a href="<?= base_url() . 'administrators'; ?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Home Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>

            

            <div class="row">
                <div class="card col-xl col-lg-4 col-md-6 col-12 mr-2">
                    <form action="<?php echo base_url() . 'administrators/update_status/' . $HOME_ANNOUNCEMENT["id"]; ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="card-header mt-0">
                            <strong> Announcement </strong>
                        </div>

                        <div class="card-body d-flex justify-content-center">
                            <label class="switch">
                                <input class="switch_on" type="checkbox" <?= $HOME_ANNOUNCEMENT["value"] == 1 ? 'checked' : "" ?> name="check_status">
                                <span class="slider round" id="announcement"></span>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="card col-xl col-lg-4 col-md-6 col-11 mr-2">
                    <form action="<?php echo base_url() . 'administrators/update_status/' . $HOME_CELEB["id"]; ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="card-header mt-0">
                            <strong> Celebrations </strong>
                        </div>

                        <div class="card-body d-flex justify-content-center">
                            <label class="switch">
                                <input class="switch_on" type="checkbox" <?= $HOME_CELEB["value"] == 1 ? 'checked' : "" ?> name="check_status">
                                <span class="slider round" id="celebrations"></span>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="card col-xl col-lg-4 col-md-6 col-12 mr-2">
                    <form action="<?php echo base_url() . 'administrators/update_status/' . $HOME_DATE["id"]; ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="card-header mt-0">
                            <strong> Date </strong>
                        </div>

                        <div class="card-body d-flex justify-content-center">
                            <label class="switch">
                                <input class="switch_on" type="checkbox" <?= $HOME_DATE["value"] == 1 ? 'checked' : "" ?> name="check_status">
                                <span class="slider round" id="date"></span>
                            </label>
                        </div>
                    </form>
                </div>


                <div class="card col-xl col-lg-4 col-md-6 col-12 mr-2">
                    <form action="<?php echo base_url() . 'administrators/update_status/' . $HOME_UPCOMING_HOLIDAYS["id"]; ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="card-header mt-0">
                            <strong>Upcoming Holidays </strong>
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <label class="switch">
                                <input class="switch_on" type="checkbox" <?= $HOME_UPCOMING_HOLIDAYS["value"] == 1 ? 'checked' : "" ?> name="check_status">
                                <span class="slider round" id="new_member_this_month"></span>
                            </label>
                        </div>
                    </form>
                </div>

            </div>

            <div class="row">
                <div class="card col-xl col-lg-4 col-md-6 col-12 mr-2">
                    <form action="<?php echo base_url() . 'administrators/update_status/' . $HOME_WHOS_OUT["id"]; ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="card-header mt-0">
                            <strong> Who's out today </strong>
                        </div>

                        <div class="card-body d-flex justify-content-center">
                            <label class="switch">
                                <input class="switch_on" type="checkbox" <?= $HOME_WHOS_OUT["value"] == 1 ? 'checked' : "" ?> name="check_status">
                                <span class="slider round" id="who_out_today"></span>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="card col-xl col-lg-4 col-md-6 col-12 mr-2">
                    <form action="<?php echo base_url() . 'administrators/update_status/' . $HOME_START_GUIDE["id"]; ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="card-header mt-0">
                            <strong> Starter Guide </strong>
                        </div>

                        <div class="card-body d-flex justify-content-center">
                            <label class="switch">
                                <input class="switch_on" type="checkbox" <?= $HOME_START_GUIDE["value"] == 1 ? 'checked' : "" ?> name="check_status">
                                <span class="slider round" id="starter_guide"></span>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="card col-xl col-lg-4 col-md-6 col-12 mr-2">
                    <form action="<?php echo base_url() . 'administrators/update_status/' . $HOME_NEW_MEMBER["id"]; ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="card-header mt-0">
                            <strong> New member this month </strong>
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <label class="switch">
                                <input class="switch_on" type="checkbox" <?= $HOME_NEW_MEMBER["value"] == 1 ? 'checked' : "" ?> name="check_status">
                                <span class="slider round" id="new_member_this_month"></span>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="card col-xl col-lg-4 col-md-6 col-12 mr-2">
                    <form action="<?php echo base_url() . 'administrators/update_status/' . $HOME_TIMERECORD["id"]; ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="card-header mt-0">
                            <strong> My Time Record </strong>
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <label class="switch">
                                <input class="switch_on" type="checkbox" <?= $HOME_TIMERECORD["value"] == 1 ? 'checked' : "" ?> name="check_status">
                                <span class="slider round" id="new_member_this_month"></span>
                            </label>
                        </div>
                    </form>
                </div>

            </div>
            <div class="row">
                <div class="card col-xl col-lg-4 col-md-6 col-12 mr-2">
                    <form action="<?php echo base_url() . 'administrators/update_status/' . $HOME_ATTENDANCE_SUMMARY["id"]; ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="card-header mt-0">
                            <strong> My Attendance Summary </strong>
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <label class="switch">
                                <input class="switch_on" type="checkbox" <?= $HOME_ATTENDANCE_SUMMARY["value"] == 1 ? 'checked' : "" ?> name="check_status">
                                <span class="slider round" id="new_member_this_month"></span>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="card col-xl col-lg-4 col-md-6 col-12 mr-2">
                    <form action="<?php echo base_url() . 'administrators/update_status/' . $HOME_REQUEST["id"]; ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="card-header mt-0">
                            <strong>Requests </strong>
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <label class="switch">
                                <input class="switch_on" type="checkbox" <?= $HOME_REQUEST["value"] == 1 ? 'checked' : "" ?> name="check_status">
                                <span class="slider round" id="new_member_this_month"></span>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="card col-xl col-lg-4 col-md-6 col-12 mr-2">
                    <form action="<?php echo base_url() . 'administrators/update_status/' . $HOME_APPROVAL["id"]; ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="card-header mt-0">
                            <strong>Approvals </strong>
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <label class="switch">
                                <input class="switch_on" type="checkbox" <?= $HOME_APPROVAL["value"] == 1 ? 'checked' : "" ?> name="check_status">
                                <span class="slider round" id="new_member_this_month"></span>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="card col-xl col-lg-4 col-md-6 col-12 mr-2">

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
        $("form").on("submit", function() {
            $.post($(this).attr("action"), $(this).serialize(), function(res) {
                console.log(res);
            })
            return false;
        })
        $("input.switch_on").on('change', function() {
            $(this).parentsUntil("form").submit();
        })
    })
</script>