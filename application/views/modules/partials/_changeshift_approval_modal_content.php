<style>
    .image_profile {
        z-index: 5;
    }

    /*td,*/
    /*th {*/
    /*    text-align: center;*/
    /*}*/
</style>
<?php $user_id = $this->session->userdata('SESS_USER_ID') ?>
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Change Shift Approval</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body position-relative">
        <div class="mb-3">
            <div class="row">
                <div class="col-2 m-0">
                    <p class="h6">Date Applied</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= date(($DATE_FORMAT) ? $DATE_FORMAT : "m/d/Y", strtotime($CHANGESHIFT->create_date)) ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">ID:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= 'CSH' . str_pad($CHANGESHIFT->id, 5, '0', STR_PAD_LEFT) ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Reason:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $CHANGESHIFT->reason ?></p>
                </div>
                <div class="col-2">
                    <p class="h6">Final Status:</p>
                </div>
                <div class="col-4">
                    <p>
                        <?php if ($CHANGESHIFT->status == "Approved") { ?>
                            <span class='btn btn-sm btn-success disabled'><?= $CHANGESHIFT->status ?></span>
                        <?php } elseif ($CHANGESHIFT->status == "Rejected") { ?>
                            <span class='btn btn-sm btn-danger disabled'><?= $CHANGESHIFT->status ?></span>
                        <?php } elseif ($CHANGESHIFT->status == "Withdrawed") { ?>
                            <span class='btn btn-sm btn-secondary disabled'><?= $CHANGESHIFT->status ?></span>
                        <?php } else { ?>
                            <span class='btn btn-sm btn-warning disabled'>Pending</span>
                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-left mb-3">
            <table id="timeTable">
                <thead>
                    <tr>
                        <th style="width: 35%">Change Shift Date</th>
                        <th style="width: 30%">Current Shift</th>
                        <th style="width: 30%">Request Shift</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($tableData) {  ?>
                        <?php foreach ($tableData as $shift) { ?>
                            <tr>
                                <td><?= date_format(date_create($shift->date_shift), ($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y")?></td>
                                <td><?= $shift->current_shift?></td>
                                <td><?=$CHANGESHIFT->shift_type?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                    <tr class="table-active">
                        <td colspan="10">
                        <center>No Records</center>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table> 
        </div>
<?php $index=count($C_APPROVERS); foreach($C_APPROVERS as $approver) { ?>
    <?php if($approver) { ?>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <div class="line_progress" style="position:relative;width:1px;height:80px;background-color:black;bottom:-65px;left:26px"></div>
                <img src="<?= profile_image($approver->image) ?>" class="rounded-circle elevation-2 m-0 p-0" style="z-index:5" width='50px' height='50px' />
                <div class="ml-2">
                <p class="p-0 m-0">Step <?=$index?>:&nbsp;<?= $approver->status?> <?= ($approver->approvedby) ? $approver->approvedby : ""?></p>
                    <p class="p-0 m-0"><?= $approver->fullname?> / <?= ($approver->fullname2) ? $approver->fullname2 : "" ?></p>
                    <p class="p-0 m-0"><?= $approver->email ?> / <?= ($approver->email2) ? $approver->email2 : "No Email" ?> </p>
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
                <img src="<?= set_profile($CHANGESHIFT, 'employee') ?>" class="image_profile rounded-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0"><?= $CHANGESHIFT->status == 'Withdrawed' ? 'Withdrawed by' : 'Requested by' ?></p>
                    <p class="p-0 m-0"><?= $CHANGESHIFT->employee ?></p>
                    <p class="p-0 m-0"><?= $CHANGESHIFT->employee_email ?></p>
                </div>
            </div>
            <div>
                <span><?= date_format(date_create($CHANGESHIFT->create_date), ($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y" . ' H:i:s A') ?></span>
            </div>
        </div>
    </div>



    <div class="modal-footer">
    <form action="<?= base_url('selfservices/update_approve_changeshift') ?>" method="POST" id="form_approved">
        <input type="hidden" name="id" value="<?= $CHANGESHIFT->id ?>">
        <input type="hidden" name="employee" value="<?= $CHANGESHIFT->employee ?>" />
        <input type='hidden' name="approver_1" value="<?= $CHANGESHIFT->approver1 ?>">
        <input type='hidden' name="approver_2" value="<?= $CHANGESHIFT->approver2 ?>">
        <input type='hidden' name="approver_3" value="<?= $CHANGESHIFT->approver3 ?>">
        <input type="hidden" name="empl_id" value="<?= $CHANGESHIFT->empl_id ?>">
        <input type="hidden" name="approver_1a" value="<?= $CHANGESHIFT->approver_1a ?>">
        <input type="hidden" name="approver_1b" value="<?= $CHANGESHIFT->approver_1b ?>">
        <input type="hidden" name="approver_2a" value="<?= $CHANGESHIFT->approver_2a ?>">
        <input type="hidden" name="approver_2b" value="<?= $CHANGESHIFT->approver_2b ?>">
        <input type="hidden" name="approver_3a" value="<?= $CHANGESHIFT->approver_3a ?>">
        <button class="btn btn-primary approve_btn" type="button" approved_id="<?= $CHANGESHIFT->id; ?>" <?=$btn_status?> >Approve</button>
    </form>
    <form action="<?= base_url('selfservices/reject_changeshift_assign') ?>" method="POST" id="form_reject">
        <input type="hidden" name="id" value="<?= $CHANGESHIFT->id ?>">
        <input type='hidden' name="approver_1" value="<?= $CHANGESHIFT->approver1 ?>">
        <input type='hidden' name="approver_2" value="<?= $CHANGESHIFT->approver2 ?>">
        <input type='hidden' name="approver_3" value="<?= $CHANGESHIFT->approver3 ?>">
        <input type="hidden" name="empl_id" value="<?= $CHANGESHIFT->empl_id ?>">
        <input type="hidden" name="approver_1a" value="<?= $CHANGESHIFT->approver_1a ?>">
        <input type="hidden" name="approver_1b" value="<?= $CHANGESHIFT->approver_1b ?>">
        <input type="hidden" name="approver_2a" value="<?= $CHANGESHIFT->approver_2a ?>">
        <input type="hidden" name="approver_2b" value="<?= $CHANGESHIFT->approver_2b ?>">
        <input type="hidden" name="approver_3a" value="<?= $CHANGESHIFT->approver_3a ?>">
        <input type="hidden" name="remarks" value="" id="remarks_reject" />
        <button class="btn btn-danger reject_btn" type="button" reject_id="<?= $CHANGESHIFT->id?>" <?=$btn_status?> >Reject</button>
    </form>
        
        
    </div>

    <?php if((( $row_data->approver1 == $userId && $row_data->approver1_date='0000-00-00 00:00:00') ||  
        ($row_data->approver2==$userId && $row_data->approver1_date!='0000-00-00 00:00:00' && $row_data->approver2_date=='0000-00-00 00:00:00'  ) ||
        ($row_data->approver3==$userId && $row_data->approver1_date!='0000-00-00 00:00:00' && $row_data->approver2_date!='0000-00-00 00:00:00' && $row_data->approver3_date=='0000-00-00 00:00:00'  ) ||
        ($row_data->approver4==$userId && $row_data->approver1_date!='0000-00-00 00:00:00' && $row_data->approver2_date!='0000-00-00 00:00:00' && $row_data->approver3_date!='0000-00-00 00:00:00' && $row_data->approver4_date=='0000-00-00 00:00:00'  ) ||
        ($row_data->approver5==$userId && $row_data->approver1_date!='0000-00-00 00:00:00' && $row_data->approver2_date!='0000-00-00 00:00:00' && $row_data->approver3_date!='0000-00-00 00:00:00' && $row_data->approver4_date!='0000-00-00 00:00:00' && $row_data->approver5_date=='0000-00-00 00:00:00')
        ) && preg_match('/Pending/i', $row_data->status)) { ?>
    
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