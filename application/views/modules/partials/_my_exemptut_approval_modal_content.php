<style>
    .image_profile {
        z-index: 5;
    }

    .img-circle {
    border-radius: 50% !important;
    width: 60px !important;
    height: 60px !important;
    object-fit: scale-down;
  }
</style>
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Exempt Undertime Request (<?= 'LEA' . str_pad($LEAVE->id, 5, '0', STR_PAD_LEFT) ?>)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body position-relative">

    <!-- <?php
        $currentDate = date('Y-m-d'); 
        $appliedDate = date('Y-m-d', strtotime($LEAVE->create_date)); 
    ?> -->
    
        <div class="mb-3">
            <div class="row">
                <div class="col-2 m-0">
                    <p class="h6">Date Applied:</p>
                </div>
                <div class="col-4 m-0">
                <p class="m-0"><?= date(($DATE_FORMAT) ? $DATE_FORMAT . ' H:i:s A' : "m/d/Y H:i:s A", strtotime($LEAVE->create_date)) ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Shift Out:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $LEAVE->shift_out ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Actual Out</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $LEAVE->actual_out ?></p>
                </div>
                <!-- <div class="col-2">
                    <p class="h6">Duration:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?=$hours?> Hour/s (<?= $days ?> Day/s)</p>
                </div> -->
                <!-- <div class="col-2 m-0">
                    <p class="h6">ID:</p>
                </div> -->
                <!-- <div class="col-4 m-0">
                    <p class="m-0"><?= 'LEA' . str_pad($LEAVE->id, 5, '0', STR_PAD_LEFT) ?></p>
                </div> -->
                <div class="col-2 m-0">
                    <p class="h6">Reason:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $LEAVE->reason ?></p>
                </div>
          
                <!-- <div class="col-2">
                    <p class="h6">Attachment:</p>
                </div>
                <div class="col-4 text-break">
                    <p class="m-0"><a download href="<?= base_url('assets_user/files/leaves/' . $LEAVE->attachment) ?>"><?= $LEAVE->attachment ?></a></p>
                </div> -->
         
                <!-- <div class="col-2">
                    <p class="h6">Remarks:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $LEAVE->remarks ?></p>
                </div> -->
                <div class="col-2">
                    <p class="h6">Status:</p>
                </div>
                <div class="col-4">
                    <p class = "mb-0">
                        <?php if ($LEAVE->status == "Approved") { ?>
                            <span class='btn btn-sm btn-success m-auto disabled' style="width:100px"><?= $LEAVE->status ?></span>
                        <?php } elseif ($LEAVE->status == "Rejected") { ?>
                            <span class='btn btn-sm btn-danger m-auto disabled' style="width:100px"><?= $LEAVE->status ?></span>
                        <?php } elseif ($LEAVE->status == "Withdrawn") { ?>
                            <span class='btn btn-sm btn-secondary m-auto disabled' style="width:100px"><?= $LEAVE->status ?></span>
                        <?php } elseif ($LEAVE->status == "Nurse") { ?>
                            <span class='btn btn-sm btn-warning m-auto disabled' style="width:100px"><?= $LEAVE->status ?></span>
                        <?php } elseif ($LEAVE->status == "Pending") { ?>
                            <span class='btn btn-sm btn-secondary m-auto disabled' style="width:100px"><?= $LEAVE->status ?></span>
                        <?php } else { ?>
                            <span class='btn btn-sm btn-warning disabled'>Pending</span>
                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- <div class="d-flex justify-content-left mb-3">
            <table id="timeTable" style="width: 100%;border: 1px solid #E7ECF0;">
                <thead>
                    <tr>
                        <th style="width: 35%">Date</th>
                        <th style="width: 35%">Current Shift</th>
                        <th style="width: 35%">Time Range</th>
                        <th style="width: 30%">Hours</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($tableData) {  ?>
                        <?php foreach ($tableData as $row_data) { ?>
                            <tr>
                            <td><?= date_format(date_create($row_data->leave_date), ($DATE_FORMAT) ? $DATE_FORMAT : "m/d/Y") ?></td>
                                <td><?= $row_data->current_shift ?></td>
                                <td><?= $row_data->leave_range ?></td>
                                <td><?= $row_data->duration ?></td>
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
        </div> -->
       
<?php $index=count($C_APPROVERS); foreach($C_APPROVERS as $approver) { ?>
    
    <?php if($approver) { ?>
        <!-- <?php if (!in_array($LEAVE->status, ['Approved', 'Withdrawed', 'Rejected', 'Pending 1', 'Pending 2','Pending 3','Pending 4','Pending 5', 'Nurse'])): ?>
    <div class="d-flex align-items-center justify-content-between mb-0 cancel_by">
        <div class="d-flex align-items-center">
            <div class="line_progress" style="position:relative;width:1px;height:100px;background-color:black;bottom:-75px;left:26px"></div>
            <img src="<?= set_profile($LEAVE, 'employee') ?>" class="image_profile img-circle elevation-2" width='50' height='50' />
            <div class="ml-2">
                <p class="p-0 m-0" style="font-weight:bold">Withdraw Approved Leave by:</p>
                <p class="p-0 m-0"><?= $LEAVE->employee ?></p>
                <p class="p-0 m-0"><?= $LEAVE->employee_email ?></p>
            </div>
        </div>
    </div>
<?php endif; ?> -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <div class="line_progress" style="position:relative;width:1px;height:80px;background-color:black;bottom:-75px;left:26px"></div>
                <img src="<?= profile_image($approver->image) ?>" class="image_profile img-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0">Step <?=$index?>:&nbsp;<?= $approver->status?> <?= ($approver->approvedby) ? $approver->approvedby : ""?></p>
                    <p class="p-0 m-0"><?= $approver->fullname?> / <?= ($approver->fullname2) ? $approver->fullname2 : "" ?></p>
                    <p class="p-0 m-0"><?= $approver->email ?> / <?= ($approver->email2) ? $approver->email2 : "No Email" ?> </p>
                </div>
            </div>
            <div>
                <span><?= !empty($approver->date_row)? date_format(date_create($approver->date_row), ($DATE_FORMAT) ? $DATE_FORMAT . ' H:i:s A' : "m/d/Y H:i:s A") : '' ?></span>
            </div>
        </div>
    <?php } ?>
<?php $index--; } ?>
        <div class="d-flex align-items-center justify-content-between mb-0">
            <div class="d-flex align-items-center">
                <img src="<?= set_profile($LEAVE, 'employee') ?>" class="image_profile img-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                <p class="p-0 m-0" style="font-weight:bold"><?= $LEAVE->status == 'Withdrawn' ? 'Withdrawn by' : 'Requested by' ?></p>
                <p class="p-0 m-0"><?= $LEAVE->employee ?></p>
                <p class="p-0 m-0"><?= $LEAVE->employee_email ?></p>

                </div>
            </div>
            <div>
                <span><?= date_format(date_create($LEAVE->create_date), ($DATE_FORMAT) ?$DATE_FORMAT . ' H:i:s A' : "m/d/Y H:i:s A") ?></span>
            </div>
        </div>
    </div>

    <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  </div>
  <?php

function get_email($approver, $approverA_email, $approver1_email)
{
    if ($approver != 0) {
        return $approver1_email;
    }
    return $approverA_email;
}
function show_approver($approver_stat, $approverA, $approver)
{
    if ($approver_stat > 0) {
        return $approver;
    }
    return $approverA;
}
function show_approver1($leave)
{
    if (!$leave->approver_1_stat && $leave->status != 'Approved') {
        return $leave->pending_approver1;
    }
    return $leave->approver1;
}
function show_approver2($leave)
{
    if (!$leave->approver_2_stat && $leave->status != 'Approved') {
        return $leave->pending_approver2;
    }
    return $leave->approver2;
}
function show_approver3($leave)
{
    if (!$leave->approver_3_stat && $leave->status != 'Approved') {
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
    if ($status == 'Withdraw' && $next_approver != 0) {
        return '<span style="font-weight: bold; color: red;">Withdraw by</span>';
    }
    if ($status == 'Withdraw' && $next_approver != 0) {
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
    if ($status == 'Withdraw' && $next_approver == 0 && $approver_id != 0) {
        return '<span style="font-weight: bold; color: red;">Withdraw by</span>';
    }
    if ($status == 'Withdraw' && $next_approver != 0) {
        return '<span style="font-weight: bold; color: green;">Approved by</span>';
    }
    if ($status == 'Withdraw' && $approver_id == 0) {
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
    if ($status == 'Withdraw' && $approver_id != 0) {
        return '<span style="font-weight: bold; color: red;">Withdraw by</span>';
    }
    if ($status == 'Withdraw' && $approver_id == 0) {
        return '<span style="font-weight: bold; color: #474747;">No response needed</span>';
    }
}
function set_profile($leave, $status)
{
    $file_name = $leave->empl_image;
    if ($status == 'Pending 1') {
        if (!$leave->approver_1_stat) {
            $file_name = $leave->pending_approver1_img;
        } else {
            $file_name = $leave->approver_1_img;
        }
    }
    if ($status === 'Pending 2') {
        if (!$leave->approver_2_stat) {
            $file_name = $leave->pending_approver2_img;
        } else {
            $file_name = $leave->approver_2_img;
        }
    }
    if ($status === 'Pending 3') {
        if (!$leave->approver_3_stat) {
            $file_name = $leave->pending_approver3_img;
        } else {
            $file_name = $leave->approver_3_img;
        }
    }
    if (file_exists(FCPATH . 'assets_user/user_profile/' . $file_name) && !empty($file_name)) {
        return base_url() . 'assets_user/user_profile/' . $file_name;
    } else {
        return base_url() . 'assets_system/images/default_user.jpg';
    }
}
?>



    