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
        <div class="line_progress" style="position:absolute;width:1px;height:345px;background-color:black;bottom:25px;left:40px"></div>

        <div class="mb-3">
            <div class="row">
                <div class="col-2 m-0">
                    <p class="h6">Date:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= date("d/m/Y", strtotime($OFFSETS->date_adjustment)) ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Assigned by:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $OFFSETS->assigned_by ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">ID:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= 'LEA' . str_pad($OFFSETS->id, 5, '0', STR_PAD_LEFT) ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Reason:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $OFFSETS->reason ?></p>
                </div>
                <!-- <div class="col-2 m-0">
                    <p class="h6">Type:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $OFFSETS->shift_type ?></p>
                </div> -->
                <div class="col-2">
                    <p class="h6">Attachment:</p>
                </div>
                <div class="col-4 text-break">
                    <!-- <p class="m-0"><a download href="<?= base_url('assets_user/files/leaves/' . $OFFSETS->attachment) ?>"><?= $OFFSETS->attachment ?></a></p> -->
                </div>
                <div class="col-2">
                    <p class="h6">Time In:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $OFFSETS->time_in_1 ?> </p>
                </div>
                <div class="col-2">
                    <p class="h6">Time Out:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $OFFSETS->time_out_1 ?> </p>
                </div>
                <div class="col-2">
                    <p class="h6">Remarks:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $OFFSETS->remarks ?></p>
                </div>
                <div class="col-2">
                    <p class="h6">Final Status:</p>
                </div>
                <div class="col-4">
                    <p>
                        <?php if ($OFFSETS->status == "Approved") { ?>
                            <span class='btn btn-sm btn-success disabled'><?= $OFFSETS->status ?></span>
                        <?php } elseif ($OFFSETS->status == "Rejected") { ?>
                            <span class='btn btn-sm btn-danger disabled'><?= $OFFSETS->status ?></span>
                        <?php } elseif ($OFFSETS->status == "Withdrawed") { ?>
                            <span class='btn btn-sm btn-secondary disabled'><?= $OFFSETS->status ?></span>
                        <?php } else { ?>
                            <span class='btn btn-sm btn-warning disabled'>Pending</span>
                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>

<?php if(show_approver3($OFFSETS)) { ?>
        <p class="h6 mb-0">Approval Route:</p> 
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div class="d-flex align-items-center">
                <img src="<?= set_profile($OFFSETS, 'Pending 3') ?>" class="image_profile img-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0">Step 3:&nbsp;<?= step_3_response($OFFSETS->status, $OFFSETS->approver_3_stat) ?></p>
                    <p class="p-0 m-0"><?= show_approver3($OFFSETS) ?></p>
                    <p class="p-0 m-0"><?= get_email($OFFSETS->approver_3_stat, $OFFSETS->approver3a_email, $OFFSETS->approver3_email) ?></p>

                </div>
            </div>
            <div>
                <span><?= $OFFSETS->approver_3_stat ? date_format(date_create($OFFSETS->approver3_date), 'd/m/Y H:i:s A') : '' ?></span>
            </div>
        </div>

 <?php } ?>
<?php if(show_approver2($OFFSETS)){ ?>
        <div class="d-flex align-items-center mb-5 justify-content-between">
            <div class="d-flex align-items-center">
                <img src="<?= set_profile($OFFSETS, 'Pending 2') ?>" class="image_profile img-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0">Step 2:&nbsp;<?= step_2_response($OFFSETS->status, $OFFSETS->approver_2_stat, $OFFSETS->approver_3_stat, $OFFSETS->approver_1_stat) ?></p>
                    <p class="p-0 m-0"><?= show_approver2($OFFSETS) ?></p>
                    <p class="p-0 m-0"><?= get_email($OFFSETS->approver_2_stat, $OFFSETS->approver2a_email, $OFFSETS->approver2_email) ?></p>
                </div>
            </div>
            <div>
                <span><?= $OFFSETS->approver_2_stat ? date_format(date_create($OFFSETS->approver2_date), 'd/m/Y H:i:s A') : '' ?></span>
            </div>
        </div>
<?php } ?>
<?php if(show_approver1($OFFSETS)) { ?>
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div class="d-flex align-items-center">
                <img src="<?= set_profile($OFFSETS, 'Pending 1') ?>" class="image_profile img-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0">Step 1:&nbsp;<?= step_1_response($OFFSETS->status, $OFFSETS->approver_1_stat, $OFFSETS->approver_2_stat) ?></p>
                    <p class="p-0 m-0"><?= show_approver1($OFFSETS) ?></p>
                    <p class="p-0 m-0"><?= get_email($OFFSETS->approver_1_stat, $OFFSETS->approver1a_email, $OFFSETS->approver1_email) ?></p>
                </div>
            </div>
            <div>
                <span><?= $OFFSETS->approver_1_stat ? date_format(date_create($OFFSETS->approver1_date), 'd/m/Y H:i:s A') : '' ?></span>
            </div>
        </div>
<?php } ?>
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="<?= set_profile($OFFSETS, 'employee') ?>" class="image_profile img-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0"><?= $OFFSETS->status == 'Withdrawed' ? 'Withdrawed by' : 'Requested by' ?></p>
                    <p class="p-0 m-0"><?= $OFFSETS->employee ?></p>
                    <p class="p-0 m-0"><?= $OFFSETS->employee_email ?></p>
                </div>
            </div>
            <div>
                <span><?= date_format(date_create($OFFSETS->create_date), 'd/m/Y H:i:s A') ?></span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <!--<button type="button" onclick="setRowId(<?= $OFFSETS->id ?>)" class='btn btn-default -->
        <!--<?= $OFFSETS->status == "Withdrawed" || $OFFSETS->status == "Rejected" || $OFFSETS->status == "Approved" ?  "d-none" : ""; ?>' >Withdraw Leave</button>-->
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
    if (!$data->approver_1_stat || $data->approver_1_stat=='0') {
        return $data->pending_approver1;
    }
    return $data->approver1;
}
function show_approver2($data)
{
    if (!$data->approver_2_stat || $data->approver_1_stat=='0') {
        return $data->pending_approver2;
    }
    return $data->approver2;
}
function show_approver3($data)
{
    if (!$data->approver_3_stat  || $data->approver_1_stat=='0') {
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