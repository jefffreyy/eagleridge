<style>
    .image_profile {
        z-index: 5;
    }
</style>
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Time Adjustment Approval</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body position-relative">
        <div class="">
            <div class="row">
                <div class="col-2 m-0">
                    <p class="h6">Date:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= date(($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y", strtotime($TIME_ADJS->date_adjustment)) ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Assigned by:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $TIME_ADJS->assigned_by ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">ID:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= 'TAD' . str_pad($TIME_ADJS->id, 5, '0', STR_PAD_LEFT) ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Reason:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $TIME_ADJS->reason ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Type:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $TIME_ADJS->shift_type ?></p>
                </div>
                <div class="col-2">
                    <p class="h6">Attachment:</p>
                </div>
                <div class="col-4 text-break">
                    <!-- <p class="m-0"><a download href="<?= base_url('assets_user/files/leaves/' . $TIME_ADJS->attachment) ?>"><?= $TIME_ADJS->attachment ?></a></p> -->
                </div>
                <div class="col-2">
                    <p class="h6">Shift In:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $TIME_DATAS->time_regular_start ?> </p>
                </div>
                <div class="col-2">
                    <p class="h6">Shift Out:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $TIME_DATAS->time_regular_end ?> </p>
                </div>
                <div class="col-2">
                    <p class="h6">Actual In:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $ACTUALTIME->time_in ?> </p>
                </div>
                <div class="col-2">
                    <p class="h6">Actual Out:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $ACTUALTIME->time_out ?> </p>
                </div>
                <div class="col-2">
                    <p class="h6">Adjusted In:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $TIME_ADJS->time_in_1 ?> </p>
                </div>
                <div class="col-2">
                    <p class="h6">Adjusted Out:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $TIME_ADJS->time_out_1 ?> </p>
                </div>                
                <div class="col-2">
                    <p class="h6">Remarks:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $TIME_ADJS->remarks ?></p>
                </div>
                <div class="col-2">
                    <p class="h6">Final Status:</p>
                </div>
                <div class="col-4">
                    <p>
                        <?php if ($TIME_ADJS->status == "Approved") { ?>
                            <span class='btn btn-sm btn-success disabled'><?= $TIME_ADJS->status ?></span>
                        <?php } elseif ($TIME_ADJS->status == "Rejected") { ?>
                            <span class='btn btn-sm btn-danger disabled'><?= $TIME_ADJS->status ?></span>
                        <?php } elseif ($TIME_ADJS->status == "Withdrawed") { ?>
                            <span class='btn btn-sm btn-secondary disabled'><?= $TIME_ADJS->status ?></span>
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
                <img src="<?= profile_image($approver->image) ?>" class="rounded-circle elevation-2" style="z-index:5" width='50' height='50' />
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
                <img src="<?= set_profile($TIME_ADJS, 'employee') ?>" class="image_profile rounded-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0"><?= $TIME_ADJS->status == 'Withdrawed' ? 'Withdrawed by' : 'Requested by' ?></p>
                    <p class="p-0 m-0"><?= $TIME_ADJS->employee ?></p>
                    <p class="p-0 m-0"><?= $TIME_ADJS->employee_email ?></p>
                </div>
            </div>
            <div>
                <span><?= date_format(date_create($TIME_ADJS->create_date), ($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y" . ' H:i:s A') ?></span>
            </div>
        </div>
    </div>
<?php if((( $row_data->approver1 == $userId && $row_data->approver1_date='0000-00-00 00:00:00') ||  
        ($row_data->approver2==$userId && $row_data->approver1_date!='0000-00-00 00:00:00' && $row_data->approver2_date=='0000-00-00 00:00:00'  ) ||
        ($row_data->approver3==$userId && $row_data->approver1_date!='0000-00-00 00:00:00' && $row_data->approver2_date!='0000-00-00 00:00:00' && $row_data->approver3_date=='0000-00-00 00:00:00'  ) ||
        ($row_data->approver4==$userId && $row_data->approver1_date!='0000-00-00 00:00:00' && $row_data->approver2_date!='0000-00-00 00:00:00' && $row_data->approver3_date!='0000-00-00 00:00:00' && $row_data->approver4_date=='0000-00-00 00:00:00'  ) ||
        ($row_data->approver5==$userId && $row_data->approver1_date!='0000-00-00 00:00:00' && $row_data->approver2_date!='0000-00-00 00:00:00' && $row_data->approver3_date!='0000-00-00 00:00:00' && $row_data->approver4_date!='0000-00-00 00:00:00' && $row_data->approver5_date=='0000-00-00 00:00:00')
    ) && preg_match('/Pending/i', $row_data->status)) { ?>
    <div class="modal-footer">
        <button class="btn btn-primary approve_btn" approved_id="<?= $TIME_ADJS->id; ?>">Approve</button>
        <button class="btn btn-danger reject_btn" reject_key="<?= $TIME_ADJS->id; ?>">Reject</button>
    </div>
    <form action="<?= base_url('selfservices/approve_time_adj_assign') ?>" method="POST" id="form_approved">
        <input type="hidden" name="id" value="<?= $TIME_ADJS->id ?>">
        <input type="hidden" name="employee" value="<?= $TIME_ADJS->employee ?>" />
        <input type='hidden' name="approver_1" value="<?= $TIME_ADJS->approver1 ?>">
        <input type='hidden' name="approver_2" value="<?= $TIME_ADJS->approver2 ?>">
        <input type='hidden' name="approver_3" value="<?= $TIME_ADJS->approver3 ?>">
        <input type="hidden" name="empl_id" value="<?= $TIME_ADJS->empl_id ?>">
        <input type="hidden" name="approver_1a" value="<?= $TIME_ADJS->approver_1a ?>">
        <input type="hidden" name="approver_2a" value="<?= $TIME_ADJS->approver_2a ?>">
        <input type="hidden" name="approver_3a" value="<?= $TIME_ADJS->approver_3a ?>">
    </form>
    <form action="<?= base_url('selfservices/reject_time_adj_assign') ?>" method="POST" id="form_reject">
        <input type="hidden" name="id" value="<?= $TIME_ADJS->id ?>">
        <input type="hidden" name="empl_id" value="<?= $TIME_ADJS->empl_id ?>">
        <input type="hidden" name="employee" value="<?= $TIME_ADJS->employee ?>" />
        <input type='hidden' name="approver_1" value="<?= $TIME_ADJS->approver1 ?>">
        <input type='hidden' name="approver_2" value="<?= $TIME_ADJS->approver2 ?>">
        <input type='hidden' name="approver_3" value="<?= $TIME_ADJS->approver3 ?>">
        <input type="hidden" name="empl_id" value="<?= $TIME_ADJS->empl_id ?>">
        <input type="hidden" name="remarks" value="" id="remarks_reject" />
    </form>
<?php } ?>
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
    if (!$data->approver_1_stat) {
        return $data->pending_approver1;
    }
    return $data->approver1;
}
function show_approver2($data)
{
    if (!$data->approver_2_stat) {
        return $data->pending_approver2;
    }
    return $data->approver2;
}
function show_approver3($data)
{
    if (!$data->approver_3_stat) {
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