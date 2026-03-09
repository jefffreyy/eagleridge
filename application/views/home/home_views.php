<html>
<script>
    function setDefaultImage(img) {
        img.src = "<?= base_url() ?>/assets_system/images/default_user.jpg";
        img.alt = 'Default Image';
    }
</script>
<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/home_style'); ?>
<?php
$User_access = '';
$Username    = '';
$Group       = '';

?>
<?php
$user_id           = '';
$user_image        = '';
$employee_id       = '';
$lastname          = '';
$middlename        = '';
$firstname         = '';
$full_name         = '';
$company_number    = '';
$company_email     = '';
$hired_on          = '';
$employment_type   = '';
$position          = '';
$section           = '';
$department        = '';
$division          = '';
$reporting_to      = '';
if ($DISP_USER_INFO) {
    foreach ($DISP_USER_INFO as $DISP_USER_INFO_ROW) {
        $user_image = $DISP_USER_INFO_ROW->col_imag_path;

        if (!empty($DISP_USER_INFO_ROW->col_last_name)) $full_name = $DISP_USER_INFO_ROW->col_last_name;
        if (!empty($DISP_USER_INFO_ROW->col_suffix)) $full_name = $full_name . ' ' . $DISP_USER_INFO_ROW->col_suffix;
        if (!empty($DISP_USER_INFO_ROW->col_frst_name)) $full_name = $full_name . ', ' . $DISP_USER_INFO_ROW->col_frst_name;
        if (!empty($DISP_USER_INFO_ROW->col_midl_name)) $full_name = $full_name . ' ' . $DISP_USER_INFO_ROW->col_midl_name[0] . '.';

        $position = $DISP_USER_INFO_ROW->col_empl_posi;
    }
}
?>
<style>
    li.approval-nav a.active {
        background-color: #7AC68B !important;
    }

    h6 {
        font-size: 14px !important;
    }

    .img-circle_sm {
        border-radius: 50% !important;
        width: 30px !important;
        height: 30px !important;
        object-fit: scale-down;
        background-color: #b0b0b0;
    }

    .img-circle_md {
        border-radius: 50% !important;
        width: 35px !important;
        height: 35px !important;
        object-fit: scale-down;

    }

    .img-circle_md_team {
        border-radius: 50% !important;
        width: 50px !important;
        height: 50px !important;
        object-fit: scale-down;

    }

    .img-circle-new-emp {
        border-radius: 50% !important;
        width: 80px !important;
        height: 80px !important;
        object-fit: scale-down;
    }

    .image-container {
        position: relative;
        /* Allows positioning of the icon within the container */
    }

    .image-container img {
        width: 100%;
        /* Adjust image width as needed */
    }

    .status-icon {
        position: relative;
        /* Positions the icon relative to its container */
        bottom: -15px;
        /* Adjust vertical distance from the bottom */
        left: -20px;
        /* Adjust horizontal distance from the left */
        width: 25px;
        /* Adjust icon size as needed */
        border: 3px solid white;
        /* Add white border */
        border-radius: 15px;
        /* Add optional rounded corners */
    }

    .upcoming_div::-webkit-scrollbar {
        width: 5px;
    }

    .upcoming_div::-webkit-scrollbar-track {
        border-radius: 2px;
        background-color: #DFE9EB;
    }

    .upcoming_div::-webkit-scrollbar-track:hover {
        background-color: #B8C0C2;
    }

    .upcoming_div::-webkit-scrollbar-track:active {
        background-color: #B8C0C2;
    }

    .upcoming_div::-webkit-scrollbar-thumb {
        border-radius: 11px;
        background-color: #397524;
    }

    .upcoming_div::-webkit-scrollbar-thumb:hover {
        background-color: #62A34B;
    }

    .upcoming_div::-webkit-scrollbar-thumb:active {
        background-color: #62A34B;
    }

    .break-word {
        word-wrap: break-word;
    }
</style>
<style>
    .m-h-250px-scroll-y {
        max-height: 250px;
        overflow-y: auto;
        display: block;
    }

    @media (min-width: 1280px) and (max-width: 1919px) {
        .counts {
            flex: 0 0 50%;
            /* Setting col-xl-3 to 50% width */
            max-width: 50%;
        }
    }

    @media (min-width: 1920px) {
        .counts {
            flex: 0 0 33.33333%;
            /* Resetting col-xl-3 to its default width */
            max-width: 25%;
        }
    }
</style>

<div class="content-wrapper">
    <div class="flex-fill p-4">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-12">

                <div class="card py-4 px-3" style="background-image: url(<?= base_url(); ?>assets_system/images/time_background.png); background-repeat: no-repeat; background-size: cover;">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="w-100"><?= $CURRENT_TIME ?></h2>
                            <?php
                            if ($isholiday) {
                                foreach ($isholiday as $holiday_row) {
                            ?>
                                    <h5 class="text-muted mb-0" style="font-size: 18px;">
                                        <?= 'Holiday - ' . $holiday_row->name ?>
                                    </h5>
                                <?php
                                }
                            } else {
                                ?>
                                <h5 class="text-muted mb-0" style="font-size: 18px;">
                                    <?= 'Regular Day' ?>
                                </h5>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <!-- <div class="col-9 col-lg-6"> -- naka compress -->
                    <div class="col-12 col-lg-6">
                        <a href="<?= base_url() . 'selfservices/my_time_records' ?>">
                            <div class='card' style="height: 200px">
                                <div class="card-header bg-white" style="background-color: #FFFFFF !important">
                                    <div class="card-title flex-grow-1 mb-0" style="font-weight: 600 !important;">
                                        <img src="<?= base_url('assets_system/icons/bullhorn-2xs-green-duotone.svg') ?>" />
                                        <h6 class="d-inline">My Time Record</h6>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-around" style="padding: 10px">
                                    <div class="d-flex align-items-center justify-content-center text-success" style="background-color:#7f7e8f0a;border-radius:50%;height:50px;width:50px;margin-right:6px;font-size:16px">
                                        <img class="shift_in_img" src="<?= base_url('assets_system/icons/inbox-in-duotone.svg'); ?>" alt="">
                                    </div>
                                    <div class="ml-2">
                                        <div style="font-size:14px;font-weight:500;color:#2b2a32eb"><?= $BIOMETRICS_SHIFT_IN ?? 'No Schedule' ?></div>
                                        <div style="font-size:13px;font-weight:500;color:#292b4199">Shift In</div>
                                    </div>
                                    <div class="ml-4">
                                        <div style="font-size:14px;font-weight:500;color:#2b2a32eb"><?= $BIOMETRICS_PUNCH_IN ?? 'Not Yet' ?></div>
                                        <div style="font-size:13px;font-weight:500;color:#292b4199">Punch In</div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-around" style="padding: 10px">
                                    <div class="d-flex align-items-center justify-content-center text-danger" style="background-color:#7f7e8f0a;border-radius:50%;height:50px;width:50px;margin-right:6px;font-size:16px">
                                        <img class="shift_in_img" src="<?= base_url('assets_system/icons/inbox-out-duotone.svg'); ?>" alt="">
                                    </div>

                                    <div class="ml-2">
                                        <div style="font-size:14px;font-weight:500;color:#2b2a32eb"><?= $BIOMETRICS_SHIFT_OUT ?? 'No Schedule' ?></div>
                                        <div style="font-size:13px;font-weight:500;color:#292b4199">Shift Out</div>
                                    </div>

                                    <div class="ml-4">
                                        <div style="font-size:14px;font-weight:500;color:#2b2a32eb"><?= $BIOMETRICS_PUNCH_OUT ?? 'Not Yet' ?></div>
                                        <div style="font-size:13px;font-weight:500;color:#292b4199">Punch Out</div>
                                    </div>

                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-6">
                        <a href="<?= base_url() . 'companies/holidays' ?>">
                            <div class="card" style="height: 200px;  ">
                                <div class="card-header bg-white" style="background-color: #FFFFFF !important">
                                    <div class="card-title flex-grow-1 mb-0" style="font-weight: 600 !important;">
                                        <img src="<?= base_url('assets_system/icons/calendar-2xs-green.svg') ?>" />
                                        <h6 class="d-inline">Upcoming Holidays</h6>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap align-items-center upcoming_div" style="overflow-y: auto; overflow-x: hidden;">
                                    <div class="row">
                                        <?php if ($DISP_HOLIDAYS) {
                                            foreach ($DISP_HOLIDAYS as $ROW) {  ?>
                                                <div class="col-6 col-lg-12">
                                                    <div class="p-2 d-flex ">
                                                        <div style="height: 48px; width: 44px; border: 3px solid green " class="d-flex justify-content-center flex-column align-items-center">
                                                            <p style="margin:0; padding:0;font-weight:600;font-size:18px;line-height:16px;color:#272323c4"><?= !empty($ROW->col_holi_date) && strtotime($ROW->col_holi_date) ? date("d", strtotime($ROW->col_holi_date)) : '' ?></p>
                                                            <p style="margin:0;padding:0;color:#675d5d;font-weight:500"><?= !empty($ROW->col_holi_date) && strtotime($ROW->col_holi_date) ? date("M", strtotime($ROW->col_holi_date)) : '' ?>
                                                            </p>
                                                        </div>

                                                        <div class="col-8 col-xl-8 d-flex justify-content-center flex-column">
                                                            <p style="color:#414f5b;margin:0;padding:0;line-height:16px;font-weight:500;font-size:14px"><?= !empty($ROW->name) ? $ROW->name : '' ?>
                                                            </p>
                                                            <p style="font-size:12px;margin:.5px 0 0 0;color:#807a7a;font-weight:500"><?= !empty($ROW->col_holi_date) && strtotime($ROW->col_holi_date) ? date(($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y", strtotime($ROW->col_holi_date)) : '' ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                        } else { ?>
                                            <div class="d-flex flex-wrap text-muted small m-2">No Upcoming holidays within two months from now</div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 col-lg-6 col-xl-3 counts">
                        <a href="<?= base_url() . 'selfservices/notifications' ?>" style="color: black;">
                            <div class='card' style="height: 100px">
                                <center>
                                    <div class="card-body align-items-center justify-content-center break-word">
                                        <h6>Notifications</h6>
                                        <span style="font-size:32px"><b><?= $NOTIFICATIONS_COUNT ?></b></span>
                                    </div>
                                </center>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-6 col-xl-3 counts ">
                        <a href="<?= base_url() . 'selfservices/my_leaves' ?>" style="color: black;">
                            <div class='card' style="height: 100px">
                                <center>
                                    <div class="card-body align-items-center justify-content-center break-word">
                                        <h6>Pending Leave</h6>
                                        <span style="font-size:32px"><b><?= $PENDINGLEAVE_COUNT ?></b></span>
                                    </div>
                                </center>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-6 col-xl-3 counts ">
                        <a href="<?= base_url() . 'selfservices/my_overtimes' ?>" style="color: black;">
                            <div class='card' style="height: 100px">
                                <center>
                                    <div class="card-body align-items-center justify-content-center">
                                        <h6>Pending OT</h6>
                                        <span style="font-size:32px"><b><?= $PENDINGOT_COUNT ?></b></span>
                                    </div>
                                </center>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-lg-6 col-xl-3 counts ">
                        <a href="<?= base_url() . 'selfservices/leave_approval' ?>" style="color: black;">
                            <div class='card' style="height: 100px">
                                <center>
                                    <div class="card-body align-items-center justify-content-center">
                                        <h6>Leave Approval</h6>
                                        <span style="font-size:32px"><b><?= $PENDING_LEAVE_APPROVAL_COUNT ?></b></span>
                                    </div>
                                </center>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-lg-6 col-xl-3 counts ">
                        <a href="<?= base_url() . 'selfservices/overtime_approval' ?>" style="color: black;">
                            <div class='card' style="height: 100px">
                                <center>
                                    <div class="card-body align-items-center justify-content-center">
                                        <h6>Overtime Approval</h6>
                                        <span style="font-size:32px"><b><?= $PENDING_OVERTIME_APPROVAL_COUNT ?></b></span>
                                    </div>
                                </center>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-lg-6 col-xl-3 counts ">
                        <a href="<?= base_url() . 'selfservices/mychange_approval' ?>" style="color: black;">
                            <div class='card' style="height: 100px">
                                <center>
                                    <div class="card-body align-items-center justify-content-center">
                                        <h6>Change shift Approval</h6>
                                        <span style="font-size:32px"><b><?= $PENDING_CHNAGESHIFT_APPROVAL_COUNT ?></b></span>
                                    </div>
                                </center>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-lg-6 col-xl-3 counts ">
                        <a href="<?= base_url() . 'selfservices/mychange_off_approval' ?>" style="color: black;">
                            <div class='card' style="height: 100px">
                                <center>
                                    <div class="card-body align-items-center justify-content-center">
                                        <h6>Change off Approval</h6>
                                        <span style="font-size:32px"><b><?= $PENDING_CHNAGEOFF_APPROVAL_COUNT ?></b></span>
                                    </div>
                                </center>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-lg-6 col-xl-3 counts ">
                        <a href="<?= base_url() . 'selfservices/my_offsets' ?>" style="color: black;">
                            <div class='card' style="height: 100px">
                                <center>
                                    <div class="card-body align-items-center justify-content-center">
                                        <h6>Offset Approval</h6>
                                        <span style="font-size:32px"><b><?= $PENDING_OFFSET_APPROVAL_COUNT ?></b></span>
                                    </div>
                                </center>
                            </div>
                        </a>
                    </div>

                </div>



                <?php if ($HOME_LEAVE_INFO['value'] == 1) { ?>
                    <div class="row">
                        <div class="col-12">
                            <div class='card'>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card-header bg-white" style="background-color: #FFFFFF !important">
                                            <div class="card-title flex-grow-1 mb-0" style="font-weight: 600 !important;">
                                                <img src="<?= base_url('assets_system/icons/bullhorn-2xs-green-duotone.svg') ?>" />
                                                <h6 class="d-inline">Leaves</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <?php if ($LEAVE_SETTINGS['sil_enable'] == 1) { ?>
                                            <div class="row justify-content-center ">
                                                <div class="col-3 d-flex justify-content-center">
                                                    <div class="d-flex align-items-center justify-content-center text-success" style="background-color:#7f7e8f0a;border-radius:50%;height:50px;width:50px;margin-right:6px;font-size:16px">
                                                        <img class="shift_in_img " src="<?= base_url('assets_system/icons/person-digging-duotone.svg'); ?>" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-5">
                                                    <div style="font-size:14px;font-weight:500;color:#2b2a32eb">SIL</div>
                                                    <div style="font-size:13px;font-weight:500;color:#292b4199">Leave</div>
                                                </div>
                                                <div class="col-4">
                                                    <div style="font-size:14px;font-weight:500;color:#2b2a32eb"><?= $REMAINING_SIL_HOURS ?> Hours</div>
                                                    <div style="font-size:13px;font-weight:500;color:#292b4199">Available</div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <?php if ($LEAVE_SETTINGS['offset_enable'] == 1) { ?>
                                            <div class="row justify-content-center ">
                                                <div class="col-3 d-flex justify-content-center">
                                                    <div class="d-flex align-items-center justify-content-center text-success" style="background-color:#7f7e8f0a;border-radius:50%;height:50px;width:50px;margin-right:6px;font-size:16px">
                                                        <img class="shift_in_img " src="<?= base_url('assets_system/icons/swap-duotone.svg'); ?>" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-5">
                                                    <div style="font-size:14px;font-weight:500;color:#2b2a32eb">Offset</div>
                                                    <div style="font-size:13px;font-weight:500;color:#292b4199">Leave</div>
                                                </div>
                                                <div class="col-4">
                                                    <div style="font-size:14px;font-weight:500;color:#2b2a32eb"><?= $REMAINING_OFFSET_HOURS ?> Hours</div>
                                                    <div style="font-size:13px;font-weight:500;color:#292b4199">Available</div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <?php if ($LEAVE_SETTINGS['vacation_enable'] == 1) { ?>
                                            <div class="row justify-content-center">
                                                <div class="col-3 d-flex justify-content-center">
                                                    <div class="d-flex align-items-center justify-content-center text-success" style="background-color:#7f7e8f0a;border-radius:50%;height:50px;width:50px;margin-right:6px;font-size:16px">
                                                        <img class="shift_in_img" src="<?= base_url('assets_system/icons/tree-palm-duotone.svg'); ?>" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-5">
                                                    <div style="font-size:14px;font-weight:500;color:#2b2a32eb">Vacation</div>
                                                    <div style="font-size:13px;font-weight:500;color:#292b4199">Leave</div>
                                                </div>
                                                <div class="col-4">
                                                    <div style="font-size:14px;font-weight:500;color:#2b2a32eb"><?= $REMAINING_VACATION_HOURS ?> Hours</div>
                                                    <div style="font-size:13px;font-weight:500;color:#292b4199">Available</div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <?php if ($LEAVE_SETTINGS['sick_enable'] == 1) { ?>
                                            <div class="row justify-content-center ">
                                                <div class="col-3 d-flex justify-content-center">
                                                    <div class="d-flex align-items-center justify-content-center text-success" style="background-color:#7f7e8f0a;border-radius:50%;height:50px;width:50px;margin-right:6px;font-size:16px">
                                                        <img class="shift_in_img" src="<?= base_url('assets_system/icons/face-mask-duotone.svg'); ?>" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-5">
                                                    <div style="font-size:14px;font-weight:500;color:#2b2a32eb">Sick</div>
                                                    <div style="font-size:13px;font-weight:500;color:#292b4199">Leave</div>
                                                </div>
                                                <div class="col-4">
                                                    <div style="font-size:14px;font-weight:500;color:#2b2a32eb"><?= $REMAINING_SICK_HOURS ?> Hours</div>
                                                    <div style="font-size:13px;font-weight:500;color:#292b4199">Available</div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>





                                <div class="p-2">
                                    <a href="<?= base_url() . 'selfservices/my_leaves' ?>">
                                        <button type="button" class="btn btn-success btn-block"> <img class="p-0" src="<?= base_url('assets_system/icons/reply-clock-solid.svg'); ?>" alt="">&nbsp;&nbsp;Request Leave</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>



                <?php if (isset($TEAM_MEMBERS_STATUS) && $TEAM_MEMBERS_STATUS['value'] == 1) : ?>
                    <div class='card'>
                        <div class="card-header bg-white" style="background-color: #FFFFFF !important">
                            <div class="card-title flex-grow-1 mb-0" style="font-weight: 600 !important;">
                                <img src="<?= base_url('assets_system/icons/bullhorn-2xs-green-duotone.svg') ?>" />
                                <h6 class="d-inline">Team Members</h6>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center align-items-center" style="padding: 10px">
                            <?php if ($TEAM_MEMBERS) { ?>
                                <?php foreach ($TEAM_MEMBERS as $row) {  ?>
                                    <div class="mb-2 mr-2 ml-2 justify-content-center" class="col-2" data-placement="bottom" data-toggle="tooltip" title="<?= $row->col_empl_cmid . ": " . $row->col_last_name . ", " . $row->col_frst_name ?>">
                                        <img class="img-circle_md_team" src="<?= $this->system_functions->profileImageCheck('assets_user/user_profile/', $row->col_imag_path) ?>" alt="">
                                        <?php if ($row->pic_status == 1) { ?>
                                            <img class="status-icon" src="<?= base_url('assets_system/icons/circle-check-solid.svg') ?>">
                                        <?php } elseif ($row->pic_status == 2) { ?>
                                            <img class="status-icon" src="<?= base_url('assets_system/icons/circle-arrow-left-duotone.svg') ?>">
                                        <?php } elseif ($row->pic_status == 3) { ?>
                                            <img class="status-icon" src="<?= base_url('assets_system/icons/circle-xmark-duotone.svg') ?>">
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div>
                                    <div colspan='3' class='p-3 d-flex flex-wrap text-muted mb-1'>No Assigned Members</div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>

            <div class="col-lg-5 col-12">
                <?php if (isset($HOME_ANNOUNCEMENT) && $HOME_ANNOUNCEMENT['value'] == 1) : ?>
                    <div class="card">
                        <div class="card-header bg-white" style="background-color: #FFFFFF !important">
                            <div class="card-title flex-grow-1 mb-0" style="font-weight: 600 !important;">
                                <img src="<?= base_url('assets_system/icons/bullhorn-2xs-green-duotone.svg') ?>" />
                                <h6 class="d-inline">Announcements</h6>
                            </div>
                        </div>

                        <div>
                            <div id="tbl_announcement">
                                <?php if ($DISP_ANNOUNCEMENTS_INFO) {
                                    $count = 0;
                                    foreach ($DISP_ANNOUNCEMENTS_INFO as $ROW_ANNOUNCEMENTS_INFO) {
                                        $employee_info = $this->home_model->employeInfo($ROW_ANNOUNCEMENTS_INFO->edit_user);
                                        // $db_date_time = strtotime();
                                        // $date_time = date('d/m/Y', $db_date_time);
                                        $date_time = date_format(date_create($ROW_ANNOUNCEMENTS_INFO->create_date), 'd/m/Y')
                                ?>
                                        <div class="p-3">

                                            <div>
                                                <a class="announcement_title"><?= $ROW_ANNOUNCEMENTS_INFO->title ?></a>
                                                <div class="author_name mb-2 mt-1">
                                                    <a>
                                                        <img width="30px" height="30px" class="rounded-circle mr-1  elevation-2" style="object-fit:scale-down" src="<?= file_exists(FCPATH . 'assets_user/user_profile/' . $employee_info[0]->col_imag_path) && !empty($employee_info[0]->col_imag_path) && isset($employee_info[0]->col_imag_path) ? base_url('assets_user/user_profile/' . $employee_info[0]->col_imag_path) : base_url('assets_system/images/default_user.jpg') ?>">
                                                    </a>

                                                    <a class="author_name"><?= isset($employee_info[0]->col_frst_name) ?  $employee_info[0]->col_last_name . ', ' . $employee_info[0]->col_frst_name  . ' ' . substr($employee_info[0]->col_midl_name, 0, 1) . '.' : ''; ?></a>

                                                    <span class="text-muted ml-1 author_date">
                                                        <?= $date_time ?>
                                                    </span>
                                                </div>

                                                <p class="my-2"><?= $ROW_ANNOUNCEMENTS_INFO->description ?></p>
                                                <div class="plain_text text-justify" style="overflow: hidden;  text-overflow: ellipsis !important; ">

                                                    <img style="border-radius: 5px;" class="pe-auto w-100 d-block" src="<?= base_url() ?>assets_user/files/hressentials/<?= $ROW_ANNOUNCEMENTS_INFO->attachment ?>" alt="">
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    }
                                } else { ?>
                                    <div>
                                        <div colspan='3' class='p-3 d-flex flex-wrap text-muted mb-1'>No Announcement Yet</div>
                                    </div>
                                <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                <?php endif ?>



                <?php if (isset($HOME_NEW_MEMBER) && $HOME_NEW_MEMBER['value'] == 1) : ?>
                    <div class="card">
                        <div class="card-header bg-white" style="background-color: #FFFFFF !important" id="new_member_this_month">
                            <div class="card-title flex-grow-1 mb-0" style="font-weight: 600 !important;">
                                <img src="<?= base_url('assets_system/icons/rss-2xs-green.svg') ?>" />
                                <h6 class="d-inline">New Members this month</h6>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <ul class="users-list clearfix">
                                <?php if ($DISP_NEW_EMP) {
                                    foreach ($DISP_NEW_EMP as $ROW_DISP_NEW_EMP) {  ?>
                                        <li>
                                            <img class="img-circle-new-emp elevation-2" src="<?php if (file_exists(FCPATH . 'assets_user/user_profile/' . $ROW_DISP_NEW_EMP->col_imag_path) && !empty($ROW_DISP_NEW_EMP->col_imag_path)) {
                                                                                                    echo base_url() . 'assets_user/user_profile/' . $ROW_DISP_NEW_EMP->col_imag_path;
                                                                                                } else {
                                                                                                    echo base_url() . 'assets_system/images/default_user.jpg';
                                                                                                } ?>">
                                            <a class="users-list-name pt-2" href="#" style="font-size: 12px !important"><?= $ROW_DISP_NEW_EMP->col_last_name . ',<br>' . $ROW_DISP_NEW_EMP->col_frst_name . ' ' . substr($ROW_DISP_NEW_EMP->col_midl_name, 0, 1) . '.' ?></a>
                                        </li>
                                    <?php
                                    }
                                } else { ?>
                                    <div class="d-flex flex-wrap text-muted mb-1 p-3">No new members this month</div>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php else : ?>
                <?php endif; ?>

                <?php if (isset($HOME_CELEBRATION) && $HOME_CELEBRATION['value'] == 1) : ?>
                    <div class="card">
                        <div class="card-header bg-white" style="background-color: #FFFFFF !important">
                            <div class="form-inline">
                                <div class="card-title flex-grow-1 mb-0" style="font-weight: 600 !important;">
                                    <img src="<?= base_url('assets_system/icons/champagne-sm-glasses.svg') ?>" />
                                    <h6 class="d-inline">Celebrations</h6>
                                </div>

                                <div class="header-elements float-right">
                                    <div class="list-icons small">
                                        <a href="" class="ml-0">7 days</a>
                                        <a class="list-icons-item" data-toggle="collapse" data-target="#celebration_card_container" aria-expanded="false" aria-controls="celebration_card_container" style='cursor:pointer'> <img style="height: 1rem; width: 1rem;" class=" ml-2" src="<?= base_url('assets_system/icons/circle-chevron-down-solid.svg') ?>" alt=""> </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="collapse show" id="celebration_card_container">
                            <table class="table table-xs mb-0">
                                <tbody>
                                    <?php
                                    $birthday_employee = '';
                                    if ($DISP_EMPOLYEE_INFO) {
                                        foreach ($DISP_EMPOLYEE_INFO as $DISP_EMPOLYEE_INFO_ROW) { ?>
                                            <tr class="activity-birthday">
                                                <td>
                                                    <div class="text-muted small mb-1">
                                                        <div class="author_name mb-2 mt-1">
                                                            <a>
                                                                <img onerror="setDefaultImage(this)" width="30px" height="30px" class="rounded-circle mr-1 elevation-2" style="object-fit:scale-down" src="<?= base_url() . "assets_user/user_profile/" . $DISP_EMPOLYEE_INFO_ROW->col_imag_path; ?>">
                                                            </a>
                                                            <a class="author_name" style="font-size: 14px;">
                                                                <?= $DISP_EMPOLYEE_INFO_ROW->col_last_name . ', ' . $DISP_EMPOLYEE_INFO_ROW->col_frst_name . ' ' . substr($DISP_EMPOLYEE_INFO_ROW->col_midl_name, 0, 1) . '.' ?></a> 
                                                                <span style="font-size: 14px;">- <?= $DISP_EMPOLYEE_INFO_ROW->Birthday ?> &nbsp;&nbsp;&nbsp;</span> 
                                                                
                                                                <?php if ($DISP_EMPOLYEE_INFO_ROW->Birthday == date('F d')) { ?> 
                                                                    <img style="" src="<?= base_url('assets_system/icons/gift-solid_2xl.svg') ?>" alt="">
                                                                <?php } ?>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="d-flex flex-wrap text-muted mb-1 p-3">No Incoming Celebrations</div>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php else : ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<aside class="control-sidebar control-sidebar-dark">

</aside>



<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" id="summernote">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<?php
if ($this->session->userdata('SESS_SUCC_MSG_LOGIN')) {
?>
    <script>
        var htmlContent = <?php echo !empty($WELCOME_MESSAGE) ? json_encode($WELCOME_MESSAGE) : null; ?>;
        $("#summernote").html(htmlContent.htmlContent);
        if (htmlContent !== null) {
            $("#summernote").html(htmlContent.htmlContent);
        } else {
            $("#summernote").html('No Message Found');
        }
        $('#myModal').modal('show');
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_LOGIN');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_DLT_ANNOUNCEMENT')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_ANNOUNCEMENT'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_DLT_ANNOUNCEMENT');
}
?>

<?php
if ($this->session->userdata('succ_approved')) {
?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success',
            subtitle: 'close',
            body: '<?php echo $this->session->userdata('succ_approved'); ?>'
        })
    </script>
<?php
    $this->session->unset_userdata('succ_approved');
}
?>

<?php function convert_id2name($array, $pos)
{
    $name = "";
    foreach ($array as $e) {
        if ($e->id == $pos) {

            $name = $e->name;
        }
    }

    if ($name == "") {
        $name = "";
    }
    return $name;
}

?>
<?php $this->load->view('templates/jquery_link'); ?>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->

<script>
    $('[data-toggle="tooltip"]').tooltip()
    // When the user leaves the page, remove the active item from local storage. this is for scrollbar to reset the active button
    window.addEventListener("unload", () => {
        const activeLinkId = localStorage.getItem('activeLinkId');
        localStorage.removeItem("activeLinkId");
    });
</script>
</body>

</html>