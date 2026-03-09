<style>
    .image_profile {
        z-index: 5;
    }
</style>
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Offset Approval</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body position-relative">
        <div class="line_progress" style="position:absolute;width:1px;height:300px;background-color:black;bottom:20px;left:40px"></div>
        <!-- <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <p class="h6">Date: <?= date("d/m/Y", strtotime($OFFSET->offset_date)) ?></p>

                </div>
                <div class="col-6">
                    <p class="h6">Assigned by: <?= $OFFSET->assigned_by ?></p>
                </div>
                <div class="col-6">
                    <p class="h6">ID: <?= 'OFF' . str_pad($OFFSET->id, 5, '0', STR_PAD_LEFT) ?></p>
                </div>
                <div class="col-6">
                    <p class="h6">Reason: <?= $OFFSET->reason ?></p>
                </div>
                <div class="col-6">
                    <p class="h6">Type: <?= $OFFSET->type ?></p>
                </div>
                <div class="col-6">
                    <p class="h6">Attachment:<a href="<?= base_url('assets_user/files/offsets/' . $OFFSET->attachment) ?>" download><?= $OFFSET->attachment ?></a>
                    </p>
                </div>
                <div class="col">
                    <p class="h6">Duration: <?= $OFFSET->duration ?> Hours</p>
                </div>
                <div class="col-12">
                    <p class="h6">Final Status:
                        <?php if ($OFFSET->status == "Approved") { ?>
                            <span class='btn btn-sm btn-success disabled'><?= $OFFSET->status ?></span>
                        <?php } elseif ($OFFSET->status == "Rejected") { ?>
                            <span class='btn btn-sm btn-danger disabled'><?= $OFFSET->status ?></span>
                        <?php } elseif ($OFFSET->status == "Withdrawed") { ?>
                            <span class='btn btn-sm btn-secondary disabled'><?= $OFFSET->status ?></span>
                        <?php } else { ?>
                            <span class='btn btn-sm btn-warning disabled'>Pending</span>
                        <?php } ?>
                    </p>
                </div>

            </div>
        </div> -->
        <div class="mb-3">
            <div class="row">
                <div class="col-2 m-0">
                    <p class="h6">Date:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= date("d/m/Y", strtotime($OFFSET->date_adjustment)) ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Assigned by:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $OFFSET->assigned_by ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">ID:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= 'LEA' . str_pad($OFFSET->id, 5, '0', STR_PAD_LEFT) ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Reason:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $OFFSET->reason ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Type:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $OFFSET->shift_type ?></p>
                </div>
                <div class="col-2">
                    <p class="h6">Attachment:</p>
                </div>
                <div class="col-4 text-break">
                    <!-- <p class="m-0"><a download href="<?= base_url('assets_user/files/leaves/' . $OFFSET->attachment) ?>"><?= $OFFSET->attachment ?></a></p> -->
                </div>
                <div class="col-2">
                    <p class="h6">Time In:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $OFFSET->duration ?> </p>
                </div>
              
                <div class="col-2">
                    <p class="h6">Remarks:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $OFFSET->remarks ?></p>
                </div>
                <div class="col-2">
                    <p class="h6">Final Status:</p>
                </div>
                <div class="col-4">
                    <p>
                        <?php if ($OFFSET->status == "Approved") { ?>
                            <span class='btn btn-sm btn-success disabled'><?= $OFFSET->status ?></span>
                        <?php } elseif ($OFFSET->status == "Rejected") { ?>
                            <span class='btn btn-sm btn-danger disabled'><?= $OFFSET->status ?></span>
                        <?php } elseif ($OFFSET->status == "Withdrawed") { ?>
                            <span class='btn btn-sm btn-secondary disabled'><?= $OFFSET->status ?></span>
                        <?php } else { ?>
                            <span class='btn btn-sm btn-warning disabled'>Pending</span>
                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="d-none mb-3">
            <!--<p class="h6">Date: </p>-->
            <!---->

        </div>
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div class="d-flex align-items-center">
                <img src="<?= set_profile($OFFSET, 'Pending 3') ?>" class="image_profile rounded-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0">Step 3:&nbsp;<?= step_3_response($OFFSET->status, $OFFSET->approver_3_stat) ?></p>
                    <p class="p-0 m-0"><?= show_approver3($OFFSET) ?></p>
                </div>
            </div>
            <div>
                <span><?= $OFFSET->approver_3_stat ? date_format(date_create($OFFSET->approver3_date), 'd/m/Y H:i:s A') : '' ?></span>
            </div>
        </div>
        <div class="d-flex align-items-center mb-5 justify-content-between">
            <div class="d-flex align-items-center">
                <img src="<?= set_profile($OFFSET, 'Pending 2') ?>" class="image_profile rounded-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0">Step 2:&nbsp;<?= step_2_response($OFFSET->status, $OFFSET->approver_2_stat, $OFFSET->approver_3_stat, $OFFSET->approver_1_stat) ?></p>
                    <p class="p-0 m-0"><?= show_approver2($OFFSET) ?></p>
                </div>
            </div>
            <div>
                <span><?= $OFFSET->approver_2_stat ? date_format(date_create($OFFSET->approver2_date), 'd/m/Y H:i:s A') : '' ?></span>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div class="d-flex align-items-center">
                <img src="<?= set_profile($OFFSET, 'Pending 1') ?>" class="image_profile rounded-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0">Step 1:&nbsp;<?= step_1_response($OFFSET->status, $OFFSET->approver_1_stat, $OFFSET->approver_2_stat) ?></p>
                    <p class="p-0 m-0"><?= show_approver1($OFFSET) ?></p>
                </div>
            </div>
            <div>
                <span><?= $OFFSET->approver_1_stat ? date_format(date_create($OFFSET->approver1_date), 'd/m/Y H:i:s A') : '' ?></span>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="<?= set_profile($OFFSET, 'employee') ?>" class="image_profile rounded-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0"><?= $OFFSET->status == 'Withdrawed' ? 'Withdrawed by' : 'Requested by' ?></p>
                    <p class="p-0 m-0"><?= $OFFSET->employee ?></p>
                </div>
            </div>
            <div>
                <span><?= date_format(date_create($OFFSET->create_date), 'd/m/Y H:i:s A') ?></span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>
<?php
function show_approver1($leave)
{
    if (!$leave->approver_1_stat) {
        return $leave->pending_approver1;
    }
    return $leave->approver1;
}
function show_approver2($leave)
{
    if (!$leave->approver_2_stat) {
        return $leave->pending_approver2;
    }
    return $leave->approver2;
}
function show_approver3($leave)
{
    if (!$leave->approver_3_stat) {
        return $leave->pending_approver3;
    }
    return $leave->approver3;
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