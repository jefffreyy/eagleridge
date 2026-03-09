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
        
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>

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