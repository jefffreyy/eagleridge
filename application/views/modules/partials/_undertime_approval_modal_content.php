<style>
    .image_profile {
        z-index: 5;
    }

    .data_content div{
        margin-bottom: 5px;
    }
</style>
<?php $user_id = $this->session->userdata('SESS_USER_ID') ?>
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Undertime Approval</h5>
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
                    <p class="m-0"><?= date(($DATE_FORMAT) ? $DATE_FORMAT : "m/d/Y", strtotime($CHANGEOFF->create_date)) ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">ID:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= 'UND' . str_pad($CHANGEOFF->id, 5, '0', STR_PAD_LEFT) ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Reason:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $CHANGEOFF->reason ?></p>
                </div>
                <div class="col-2">
                    <p class="h6">Final Status:</p>
                </div>
                <div class="col-4">
                    <p>
                        <?php if ($CHANGEOFF->status == "Approved") { ?>
                            <span class='btn btn-sm btn-success disabled'><?= $CHANGEOFF->status ?></span>
                        <?php } elseif ($CHANGEOFF->status == "Rejected") { ?>
                            <span class='btn btn-sm btn-danger disabled'><?= $CHANGEOFF->status ?></span>
                        <?php } elseif ($CHANGEOFF->status == "Withdrawed") { ?>
                            <span class='btn btn-sm btn-secondary disabled'><?= $CHANGEOFF->status ?></span>
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
                        <th style="width: 35%">Date Undertime</th>
                        <th style="width: 30%">Current Shift</th>
                        <th style="width: 30%">Request time out</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= date_format(date_create($CHANGEOFF->date_undertime), ($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y")?></td>
                        <td><?= $CHANGEOFF->current_shift?></td>
                        <td><?=$CHANGEOFF->request_time_out?></td>
                    </tr>
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
                <img src="<?= set_profile($CHANGEOFF, 'employee') ?>" class="image_profile rounded-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0"><?= $CHANGEOFF->status == 'Withdrawed' ? 'Withdrawed by' : 'Requested by' ?></p>
                    <p class="p-0 m-0"><?= $CHANGEOFF->employee ?></p>
                    <p class="p-0 m-0"><?= $CHANGEOFF->employee_email ?></p>
                </div>
            </div>
            <div>
                <span><?= date_format(date_create($CHANGEOFF->create_date), ($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y" . ' H:i:s A') ?></span>
            </div>
        </div>
    </div>

    <div class="modal-footer">
    <form action="<?= base_url('selfservices/update_approve_undertime') ?>" method="POST" id="form_approved">
        <input type="hidden" name="id" value="<?= $CHANGEOFF->id ?>">
        <input type="hidden" name="employee" value="<?= $CHANGEOFF->employee ?>" />
        <input type='hidden' name="approver_1" value="<?= $CHANGEOFF->approver1 ?>">
        <input type='hidden' name="approver_2" value="<?= $CHANGEOFF->approver2 ?>">
        <input type='hidden' name="approver_3" value="<?= $CHANGEOFF->approver3 ?>">
        <input type="hidden" name="empl_id" value="<?= $CHANGEOFF->empl_id ?>">
        <input type="hidden" name="approver_1a" value="<?= $CHANGEOFF->approver_1a ?>">
        <input type="hidden" name="approver_1b" value="<?= $CHANGEOFF->approver_1b ?>">
        <input type="hidden" name="approver_2a" value="<?= $CHANGEOFF->approver_2a ?>">
        <input type="hidden" name="approver_2b" value="<?= $CHANGEOFF->approver_2b ?>">
        <input type="hidden" name="approver_3a" value="<?= $CHANGEOFF->approver_3a ?>">
        <button class="btn btn-primary approve_btn" type="button" approved_id="<?= $CHANGEOFF->id; ?>" <?=$btn_status?> >Approve</button>
    </form>
    <form action="<?= base_url('selfservices/reject_undertime_assign') ?>" method="POST" id="form_reject">
        <input type="hidden" name="id" value="<?= $CHANGEOFF->id ?>">
        <input type='hidden' name="approver_1" value="<?= $CHANGEOFF->approver1 ?>">
        <input type='hidden' name="approver_2" value="<?= $CHANGEOFF->approver2 ?>">
        <input type='hidden' name="approver_3" value="<?= $CHANGEOFF->approver3 ?>">
        <input type="hidden" name="empl_id" value="<?= $CHANGEOFF->empl_id ?>">
        <input type="hidden" name="approver_1a" value="<?= $CHANGEOFF->approver_1a ?>">
        <input type="hidden" name="approver_1b" value="<?= $CHANGEOFF->approver_1b ?>">
        <input type="hidden" name="approver_2a" value="<?= $CHANGEOFF->approver_2a ?>">
        <input type="hidden" name="approver_2b" value="<?= $CHANGEOFF->approver_2b ?>">
        <input type="hidden" name="approver_3a" value="<?= $CHANGEOFF->approver_3a ?>">
        <input type="hidden" name="remarks" value="" id="remarks_reject" />
        <button class="btn btn-danger reject_btn" type="submit" reject_id="<?= $CHANGEOFF->id?>" <?=$btn_status?> >Reject</button>
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