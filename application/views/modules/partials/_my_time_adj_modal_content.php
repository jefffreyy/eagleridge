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
        <div class="mb-2">
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
                    <p class="m-0"><?= 'ADJ' . str_pad($TIME_ADJS->id, 5, '0', STR_PAD_LEFT) ?></p>
                </div>

                <!-- <div class="col-2 m-0">
                    <p class="h6">Type:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $TIME_ADJS->shift_type ?></p>
                </div> -->

                <div class="col-2">
                    <p class="h6">Time In:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $TIME_ADJS->time_in_1 ?> </p>
                </div>
                <div class="col-2">
                    <p class="h6">Time Out:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $TIME_ADJS->time_out_1 ?> </p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Reason:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $TIME_ADJS->reason ?></p>
                </div>
                <div class="col-2">
                    <p class="h6">Remarks:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $TIME_ADJS->remarks ?></p>
                </div>
                <div class="col-2">
                    <p class="h6">Attachment:</p>
                </div>
                <div class="col-4 text-break">
                     <p class="m-0"><a download href="<?= base_url('assets_user/files/leaves/' . $TIME_ADJS->attachment) ?>"><?= $TIME_ADJS->attachment ?></a></p> 
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
                <img src="<?= set_profile($TIME_ADJS, 'employee') ?>" class="image_profile img-circle elevation-2" width='50' height='50' />
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