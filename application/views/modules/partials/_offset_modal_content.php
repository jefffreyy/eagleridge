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
        <h5 class="modal-title">Offset Approval</h5>
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
                    <p class="m-0"><?= date(($DATE_FORMAT) ? $DATE_FORMAT : "m/d/Y", strtotime($OFFSET->offset_date)) ?></p>
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
                    <p class="m-0"><?= 'OFF' . str_pad($OFFSET->id, 5, '0', STR_PAD_LEFT) ?></p>
                </div>
                <div class="col-2">
                    <p class="h6">Duration:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $OFFSET->duration ?> Hours</p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Reason:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $OFFSET->reason ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Offset Type:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $OFFSET->offset_type ?></p>
                </div>
                <!-- <div class="col-2">
                    <p class="h6">Attachment:</p>
                </div>
                <div class="col-4 text-break">
                    <p class="m-0"><a download href="<?= base_url('assets_user/files/leaves/' . $OFFSET->attachment) ?>"><?= $OFFSET->attachment ?></a></p>
                </div> -->
                <?php if ($OFFSET->offset_type !== 'Redeem'): ?>
                    <div class="col-2 m-0">
                        <p class="h6">Time In:</p>
                    </div>
                    <div class="col-4 m-0">
                        <p class="m-0"><?= $OFFSET->actual_time_in ?></p>
                    </div>
                    <div class="col-2 m-0">
                        <p class="h6">Time Out:</p>
                    </div>
                    <div class="col-4 m-0">
                        <p class="m-0"><?= $OFFSET->actual_time_out ?></p>
                    </div>
                <?php endif; ?>
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
                        <?php } elseif ($OFFSET->status == "Withdrawn") { ?>
                            <span class='btn btn-sm btn-secondary disabled'><?= $OFFSET->status ?></span>
                        <?php } else { ?>
                            <span class='btn btn-sm btn-warning disabled'>Pending</span>
                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>


        <?php $index = count($C_APPROVERS);
        foreach ($C_APPROVERS as $approver) { ?>
            <?php if ($approver) { ?>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        <div class="line_progress" style="position:relative;width:1px;height:80px;background-color:black;bottom:-65px;left:26px"></div>
                        <img src="<?= profile_image($approver->image) ?>" class="rounded-circle elevation-2 m-0 p-0" style="z-index:5" width='50px' height='50px' />
                        <div class="ml-2">
                            <p class="p-0 m-0">Step <?= $index ?>:&nbsp;<?= $approver->status ?> <?= ($approver->approvedby) ? $approver->approvedby : "" ?></p>
                            <p class="p-0 m-0"><?= $approver->fullname ?> / <?= ($approver->fullname2) ? $approver->fullname2 : "" ?></p>
                            <p class="p-0 m-0"><?= $approver->email ?> / <?= ($approver->email2) ? $approver->email2 : "No Email" ?> </p>
                        </div>
                    </div>
                    <div>
                        <span><?= !empty($approver->date_row) ? date_format(date_create($approver->date_row), ($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y" . ' H:i:s A') : '' ?></span>
                    </div>
                </div>
            <?php } ?>
        <?php $index--;
        } ?>
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="<?= set_profile($OFFSET, 'employee') ?>" class="image_profile rounded-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0"><?= $OFFSET->status == 'Withdrawn' ? 'Withdrawn by' : 'Requested by' ?></p>
                    <p class="p-0 m-0"><?= $OFFSET->employee ?></p>
                    <p class="p-0 m-0"><?= $OFFSET->employee_email ?></p>
                </div>
            </div>
            <div>
                <span><?= date_format(date_create($OFFSET->create_date), ($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y" . ' H:i:s A') ?></span>
            </div>
        </div>
    </div>

    <!-- <?php if (show_approver3($OFFSET)) { ?>
    <p class="h6 mb-0">Approval Route:</p>
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <div class="line_progress" style="position:relative;width:1px;height:100px;background-color:black;bottom:-75px;left:26px"></div>
            <img src="<?= set_profile($OFFSET, 'Pending 3') ?>" class="image_profile img-circle elevation-2" width='50' height='50' />
            <div class="ml-2">
                <p class="p-0 m-0">Step 3:&nbsp;<?= step_3_response($OFFSET->status, $OFFSET->approver_3_stat) ?></p>
                <p class="p-0 m-0"><?= show_approver3($OFFSET) ?></p>
                <?php if (property_exists($OFFSET, 'approver3a_email') && property_exists($OFFSET, 'approver3_email')) : ?>
                    <p class="p-0 m-0"><?= get_email($OFFSET->approver_3_stat, $OFFSET->approver3a_email, $OFFSET->approver3_email) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <span><?= $OFFSET->approver_3_stat ? date_format(date_create($OFFSET->approver3_date), ($DATE_FORMAT) ? $DATE_FORMAT : "m/d/Y" . ' H:i:s A') : '' ?></span>
        </div>
    </div>
<?php } ?>

<?php if (show_approver2($OFFSET)) { ?>
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
        <div class="line_progress" style="position:relative;width:1px;height:100px;background-color:black;bottom:-75px;left:26px"></div>
            <img src="<?= set_profile($OFFSET, 'Pending 2') ?>" class="image_profile img-circle elevation-2" width='50' height='50' />
            <div class="ml-2">
                <p class="p-0 m-0">Step 2:&nbsp;<?= step_2_response($OFFSET->status, $OFFSET->approver_2_stat, $OFFSET->approver_3_stat, $OFFSET->approver_1_stat) ?></p>
                <p class="p-0 m-0"><?= show_approver2($OFFSET) ?></p>
                <?php if (property_exists($OFFSET, 'approver2a_email') && property_exists($OFFSET, 'approver2_email')) : ?>
                    <p class="p-0 m-0"><?= get_email($OFFSET->approver_2_stat, $OFFSET->approver2a_email, $OFFSET->approver2_email) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <span><?= $OFFSET->approver_2_stat ? date_format(date_create($OFFSET->approver2_date), ($DATE_FORMAT) ? $DATE_FORMAT : "m/d/Y" . ' H:i:s A') : '' ?></span>
        </div>
    </div>
<?php } ?>

<?php if (show_approver1($OFFSET)) { ?>
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center">
        <div class="line_progress" style="position:relative;width:1px;height:100px;background-color:black;bottom:-75px;left:26px"></div>
            <img src="<?= set_profile($OFFSET, 'Pending 1') ?>" class="image_profile img-circle elevation-2" width='50' height='50' />
            <div class="ml-2">
                <p class="p-0 m-0">Step 1:&nbsp;<?= step_1_response($OFFSET->status, $OFFSET->approver_1_stat, $OFFSET->approver_2_stat) ?></p>
                <p class="p-0 m-0"><?= show_approver1($OFFSET) ?></p>
                <?php if (property_exists($OFFSET, 'approver1a_email') && property_exists($OFFSET, 'approver1_email')) : ?>
                    <p class="p-0 m-0"><?= get_email($OFFSET->approver_1_stat, $OFFSET->approver1a_email, $OFFSET->approver1_email) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <span><?= $OFFSET->approver_1_stat ? date_format(date_create($OFFSET->approver1_date), ($DATE_FORMAT) ? $DATE_FORMAT : "m/d/Y" . ' H:i:s A') : '' ?></span>
        </div>
    </div>
<?php } ?> -->

    <!-- <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="<?= set_profile($OFFSET, 'employee') ?>" class="image_profile img-circle  rounded-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0"><?= $OFFSET->status == 'Withdrawed' ? 'Withdrawed by' : 'Requested by' ?></p>
                    <p class="p-0 m-0"><?= $OFFSET->employee ?></p>
                </div>
            </div>
            <div>
                <span><?= date_format(date_create($OFFSET->create_date), ($DATE_FORMAT) ? $DATE_FORMAT : "m/d/Y" . ' H:i:s A') ?></span> -->
    <!-- <span><?= date_format(date_create($OFFSET->create_date), 'd/m/Y H:i:s A') ?></span> -->
    <!-- </div>
        </div> -->
    <!-- </div> -->

    <div class="modal-footer">
        <!-- <?php if ($OFFSET->status != 'Withdrawn' && $OFFSET->status != 'Rejected' && $OFFSET->offset_type != 'Redeem') { ?>
            <form action="<?= site_url('selfservices/withdraw_acquire_offset') ?>" method="POST">
                <input type="hidden" name="rowId" value="<?= $OFFSET->id ?>" />
                <button type="submit" class='btn btn-default withdraw_offset'>Withdraw Offset</button>
            </form>
        <?php } ?> -->

        <?php if ($OFFSET->status != 'Withdrawn' && $OFFSET->status != 'Rejected') { ?>
            <form id="withdraw_approved_form" action="<?= site_url('selfservices/withdraw_acquire_offset') ?>" method="POST">
                <input type="hidden" name="rowId" value="<?= $OFFSET->id ?>" />
                <input type="hidden" id="reason" name="reason" value="" />
                <button type="button" class='btn btn-default withdraw_approved_offset'>Withdraw Offset</button>
            </form>

        <?php } ?>

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
function show_approver1($OFFSET)
{
    if (!$OFFSET->approver_1_stat) {
        return $OFFSET->pending_approver1;
    }
    return $OFFSET->approver1;
}
function show_approver2($OFFSET)
{
    if (!$OFFSET->approver_2_stat) {
        return $OFFSET->pending_approver2;
    }
    return $OFFSET->approver2;
}
function show_approver3($OFFSET)
{
    if (!$OFFSET->approver_3_stat) {
        return $OFFSET->pending_approver3;
    }
    return $OFFSET->approver3;
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

<script>
    $(document).on('click', 'button.withdraw_offset', function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Are you sure you want to withdraw acquired offset?",
            text: "Confirm to withdraw acquired offset!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "No, exit!",
            confirmButtonText: "Yes, confirm!"
        }).then((result) => {
            if (result.isConfirmed) {
                $('form').submit();

            }
        });
    });
</script>

<script>
   $(document).on('click', 'button.withdraw_approved_offset', function(e) {
        e.preventDefault();
        e.stopPropagation();

        $('.modal').modal('hide');

        Swal.fire({
            icon: 'warning',
            title: "Are you sure you want to withdraw approved acquired offset?",
            input: "textarea",
            inputLabel: "Add Reason",
            inputPlaceholder: "Type your reason here...",
            inputAttributes: {
                "aria-label": "Type your reason here"
            },
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, confirm!",
            cancelButtonText: "No, exit!",
            inputValidator: (value) => {
                if (!value) {
                    return "You need to provide a reason!";
                }
            },
            preConfirm: (reason) => {
                $('#reason').val(reason); 
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $('#withdraw_approved_form').submit();
            }
        });
    });

</script>