<style>
    .image_profile {
        z-index: 5;
    }
</style>
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Holiday Work Approval</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body position-relative">
        <div class="">
            <div class="row">
                <div class="col-2 m-0">
                    <p class="h6">Date</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= date(($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y", strtotime($HOLIDAY_WORK->date)) ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Type:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $HOLIDAY_WORK->type ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Assigned by:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $HOLIDAY_WORK->assigned_by ?></p>
                </div>
                <div class="col-2">
                    <p class="h6">Duration:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $HOLIDAY_WORK->hours ?> Hours</p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">ID:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= 'HDW' . str_pad($HOLIDAY_WORK->id, 5, '0', STR_PAD_LEFT) ?></p>
                </div>

                <div class="col-2 m-0">
                    <p class="h6">Reason:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $HOLIDAY_WORK->reason ?></p>
                </div>

                <div class="col-2">
                    <p class="h6">Attachment:</p>
                </div>
                <div class="col-4 text-break">
                    <!-- <p class="m-0"><a download href="<?= base_url('assets_user/files/leaves/' . $HOLIDAY_WORK->attachment) ?>"><?= $HOLIDAY_WORK->attachment ?></a></p> -->
                </div>

                <div class="col-2">
                    <p class="h6">Remarks:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $HOLIDAY_WORK->comment ?></p>
                </div>
                <div class="col-2">
                    <p class="h6">Final Status:</p>
                </div>
                <div class="col-3">
                    <p>
                        <?php if ($HOLIDAY_WORK->status == 'Approved') { ?>
                            <span class='btn btn-sm btn-success disabled'><?= $HOLIDAY_WORK->status ?></span>
                        <?php } elseif ($HOLIDAY_WORK->status == "Rejected") { ?>
                            <span class='btn btn-sm btn-danger disabled'><?= $HOLIDAY_WORK->status ?></span>
                        <?php } elseif ($HOLIDAY_WORK->status == "Withdrawed") { ?>
                            <span class='btn btn-sm btn-secondary disabled'><?= $HOLIDAY_WORK->status ?></span>
                        <?php } else { ?>
                            <span class='btn btn-sm btn-warning disabled'>Pending</span>
                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>

<?php $index=count($C_APPROVERS); foreach($C_APPROVERS as $approver) { ?>
    <?php if($approver) { ?>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <div class="line_progress" style="position:relative;width:1px;height:80px;background-color:black;bottom:-65px;left:26px"></div>
                <img src="<?= profile_image($approver->image) ?>" class="image_profile img-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0">Step <?=$index?>:&nbsp;<?= $approver->status?></p>
                    <p class="p-0 m-0"><?= $approver->fullname?></p>
                    <p class="p-0 m-0"><?= $approver->email ?></p>
                </div>
            </div>
            <div>
                <span><?= !empty($approver->date_row)? date_format(date_create($approver->date_row), ($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y" . ' H:i:s A') : '' ?></span>
            </div>
        </div>
    <?php } ?>
<?php $index--; } ?>
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="<?= set_profile($HOLIDAY_WORK, 'employee') ?>" class="image_profile img-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0"><?= $HOLIDAY_WORK->status == 'Withdrawed' ? 'Withdrawed by' : 'Requested by' ?></p>
                    <p class="p-0 m-0"><?= $HOLIDAY_WORK->employee ?></p>
                </div>
            </div>
            <div>
                <span><?= date_format(date_create($HOLIDAY_WORK->create_date), ($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y" . ' H:i:s A') ?></span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>
<?php
function get_email($approver, $approverA_email, $approver1_email)
{
    if ($approver != 0) {
        return $approver1_email;
    }
    return $approverA_email;
}
function show_approver1($data)
{
    if (!$data->approver_1_stat && $data->status!='Approved') {
        return $data->pending_approver1;
    }
    return $data->approver1;
}
function show_approver2($data)
{
    if (!$data->approver_2_stat && $data->status!='Approved') {
        return $data->pending_approver2;
    }
    return $data->approver2;
}
function show_approver3($data)
{
    if (!$data->approver_3_stat && $data->status!='Approved') {
        return $data->pending_approver3;
    }
    return $data->approver3;
}
function step_1_response($status, $approver_id, $next_approver)
{

    if ($status == 'Pending 1') {
        return '<span style="font-weight: bold; color: black;">Pending response</span>';
    }
    if ($status == 'Pending 2' || $status == 'Pending 3') {
        return '<span style="font-weight: bold; color: green;">Approved by</span>';
    }
    if (($status == 'Withdrawed' && $approver_id != 0) || $status == 'Approved') {
        return '<span style="font-weight: bold; color: green;">Approved by</span>';
    }
    if ($status == 'Withdrawed' & $approver_id == 0) {
        return '<span style="font-weight: bold; color: #474747;">No response needed</span>';
    }
    if ($status == 'Rejected' && $next_approver == 0) {
        return '<span style="font-weight: bold; color: red;">Rejected by</span>';
    }
    if ($status == 'Rejected' && $next_approver != 0) {
        return '<span style="font-weight: bold; color: green;">Approved by</span>';
    }
}
function step_2_response($status, $approver_id, $next_approver, $prev_approver)
{
    if ($status == 'Pending 2') {
        return '<span style="font-weight: bold; color: black;">Pending response</span>';
    }
    if ($status == 'Pending 3') {
        return '<span style="font-weight: bold; color: green;">Approved by</span>';
    }
    if ($status == 'Pending 1') {
        return '<span style="font-weight: bold; color: black;">Needs response from</span>';
    }
    if (($status == 'Withdrawed' && $approver_id != 0) || $status == 'Approved') {
        return '<span style="font-weight: bold; color: green;">Approved by</span>';
    }
    if ($status == 'Withdrawed' && $approver_id == 0) {
        return '<span style="font-weight: bold; color: #474747;">No response needed</span>';
    }
    if ($status == 'Rejected' && $next_approver == 0 && $approver_id != 0) {
        return '<span style="font-weight: bold; color: red;">Rejected by</span>';
    }
    if ($status == 'Rejected' && $next_approver != 0) {
        return '<span style="font-weight: bold; color: green;">Approved by</span>';
    }
    if ($status == 'Rejected' && $approver_id == 0) {
        return '<span style="font-weight: bold; color: #474747;">No response needed</span>';
    }
}
function step_3_response($status, $approver_id)
{
    if ($status == 'Pending 3') {
        return '<span style="font-weight: bold; color: black;">Pending response</span>';
    }
    if ($status == 'Pending 1' || $status == 'Pending 2') {
        return '<span style="font-weight: bold; color: black;">Needs response from</span>';
    }
    if (($status == 'Withdrawed' && $approver_id != 0) || $status == 'Approved') {
        return '<span style="font-weight: bold; color: green;">Approved by</span>';
    }
    if ($status == 'Withdrawed' && $approver_id == 0) {
        return '<span style="font-weight: bold; color: #474747;">No response needed</span>';
    }
    if ($status == 'Rejected' && $approver_id != 0) {
        return '<span style="font-weight: bold; color: red;">Rejected by</span>';
    }
    if ($status == 'Rejected' && $approver_id == 0) {
        return '<span style="font-weight: bold; color: #474747;">No response needed</span>';
    }
}
function set_profile($data, $status)
{
    $file_name = $data->empl_image;
    if ($status == 'Pending 1') {
        if (!$data->approver_1_stat) {
            $file_name = $data->pending_approver1_img;
        } else {
            $file_name = $data->approver_1_img;
        }
    }
    if ($status === 'Pending 2') {
        if (!$data->approver_2_stat) {
            $file_name = $data->pending_approver2_img;
        } else {
            $file_name = $data->approver_2_img;
        }
    }
    if ($status === 'Pending 3') {
        if (!$data->approver_3_stat) {
            $file_name = $data->pending_approver3_img;
        } else {
            $file_name = $data->approver_3_img;
        }
    }
    if (file_exists(FCPATH . 'assets_user/user_profile/' . $file_name) && !empty($file_name)) {
        return base_url() . 'assets_user/user_profile/' . $file_name;
    } else {
        return base_url() . 'assets_system/images/default_user.jpg';
    }
}
?>