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
        <h5 class="modal-title">Change Off Approval</h5>
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
                    <p class="m-0"><?= 'CHO' . str_pad($CHANGEOFF->id, 5, '0', STR_PAD_LEFT) ?></p>
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
    <div class="col-md-6">
        <div>
            <h5 style="text-align: left; margin-bottom: 10px;">Original Shift</h5>
            <div class="d-flex">
                <div class="title" style="min-width: 150px;">
                    <div class="h6">Date:</div>
                    <div class="h6">Current Shift:</div>
                    <div class="h6">Request Shift:</div>
                </div>
                <div class="data_content">
                    <div><?= date_format(date_create($CHANGEOFF->date_shift), ($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y")?></div>
                    <div><?= $CHANGEOFF->current_shift?></div>
                    <div><?= $CHANGEOFF->shift_type?></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div>
            <h5 style="text-align: left; margin-bottom: 10px;">Amended</h5>
            <div class="d-flex">
                <div class="title" style="min-width: 150px;">
                    <div class="h6">Date:</div>
                    <div class="h6">Current Shift:</div>
                    <div class="h6">Request Shift:</div>
                </div>
                <div class="data_content">
                    <div><?= date_format(date_create($CHANGEOFF->date_shift_to), ($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y")?></div>
                    <div><?= $CHANGEOFF->current_shift_to?></div>
                    <div><?= $CHANGEOFF->shift_type2?></div>
                </div>
            </div>
        </div>
    </div>
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
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        
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