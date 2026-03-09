<style>
    .image_profile {
        z-index: 5;
    }
</style>
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Overtime Request (<?= 'OVT' . str_pad($OVERTIME->id, 5, '0', STR_PAD_LEFT) ?>)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body position-relative">
        <div class="">
            <div class="row">
                <div class="col-2 m-0">
                    <p class="h6">Date</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($OVERTIME->date_ot)) ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Type:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $OVERTIME->type ?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Assigned by:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $OVERTIME->assigned_by ?></p>
                </div>
                <!-- <div class="col-2 m-0">
                    <p class="h6">ID:</p>
                </div> -->
                <!-- <div class="col-4 m-0">
                    <p class="m-0"><?= 'OVT' . str_pad($OVERTIME->id, 5, '0', STR_PAD_LEFT) ?></p>
                </div> -->
                <div class="col-2">
                    <p class="h6">Overtime:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $OVERTIME->hours ?> Hours</p>
                </div>

                <div class="col-2">
                    <p class="h6">Early OT:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $OVERTIME->early_ot ?> Hours</p>
                </div>

                <div class="col-2">
                    <p class="h6">Night Differential:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $OVERTIME->ndot ?> Hours</p>
                </div>

                <div class="col-2 m-0">
                    <p class="h6">Reason:</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?= $OVERTIME->reason ?></p>
                </div>

                <div class="col-2">
                    <p class="h6">Attachment:</p>
                </div>
                <div class="col-4 text-break">
                    <!-- <p class="m-0"><a download href="<?= base_url('assets_user/files/leaves/' . $LEAVE->attachment) ?>"><?= $LEAVE->attachment ?></a></p> -->
                </div>

                <div class="col-2">
                    <p class="h6">Remarks:</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><?= $OVERTIME->comment ?></p>
                </div>
                <div class="col-2">
                    <p class="h6">Final Status:</p>
                </div>
                <div class="col-4">
                    <p>
                        <?php if ($OVERTIME->status == "Approved") { ?>
                            <span class='btn btn-sm btn-success disabled'><?= $OVERTIME->status ?></span>
                        <?php } elseif ($OVERTIME->status == "Rejected") { ?>
                            <span class='btn btn-sm btn-danger disabled'><?= $OVERTIME->status ?></span>
                        <?php } elseif ($OVERTIME->status == "Withdrawn") { ?>
                            <span class='btn btn-sm btn-secondary disabled'><?= $OVERTIME->status ?></span>
                        <?php } elseif (preg_match('/Pending/i', $OVERTIME->status)) { ?>
                            <span class='btn btn-sm btn-warning disabled'>Pending</span>
                        <?php } elseif ($OVERTIME->status == "Cancelled") { ?>
                            <span class='btn btn-sm btn-secondary disabled'>Cancelled</span>
                        <?php } elseif ($OVERTIME->status == "Withdrawed") { ?>
                            <span class='btn btn-sm btn-secondary disabled'>Withdrawed</span>
                        <?php } else { ?>
                            <span class='btn btn-sm btn-info disabled'>Unknown</span>
                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>
        <?php $index = count($C_APPROVERS); ?>
        <?php foreach ($C_APPROVERS as $approver) { ?>
            <?php if ($approver) { ?>
                <?php if (!in_array($OVERTIME->status, ['Approved', 'Cancelled', 'Rejected', 'Pending 1', 'Pending 2', 'Pending 3', 'Pending 4', 'Pending 5', 'Withdrawn'])) : ?>
                    <div class="d-flex align-items-center justify-content-between mb-0 cancel_by">
                        <div class="d-flex align-items-center">
                            <div class="line_progress" style="position:relative;width:1px;height:100px;background-color:black;bottom:-75px;left:26px"></div>
                            <img src="<?= set_profile($OVERTIME, 'employee') ?>" class="image_profile img-circle elevation-2" width='50' height='50' />
                            <div class="ml-2">
                                <p class="p-0 m-0" style="font-weight:bold">Withdraw Approved Overtime by:</p>
                                <p class="p-0 m-0"><?= $OVERTIME->employee ?></p>
                                <p class="p-0 m-0"><?= $OVERTIME->employee_email ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        <div class="line_progress" style="position:relative;width:1px;height:80px;background-color:black;bottom:-65px;left:26px"></div>
                        <img src="<?= profile_image($approver['main']->image) ?>" class="rounded-circle elevation-2 m-0 p-0" style="z-index:5" width='50px' height='50px' />
                        <div class="ml-2">
                            <p class="p-0 m-0">Step <?= $index ?>:&nbsp;<?= $approver['main']->status ?> : <?= $approver['approvedby']->approvedby ?> 
                            <p class="p-0 m-0" style="color: gray;font-weight:bold"><?= $approver['main']->fullname ?>
                                <?php if ($approver['backup']) { ?>
                                    / BA: <?= $approver['backup']->fullname ?>
                                <?php } ?>
                            </p>
                            <?php
                            $mainEmail = $approver['main']->email ?? 'No email';
                            $backupEmail = $approver['backup']->email ?? 'No email';

                            echo '<p class="p-0 m-0">' . $mainEmail;
                            if ($approver['backup']) {
                                echo ' / ' . $backupEmail;
                            }
                            echo '</p>';
                            ?>
                        </div>
                        <span><?= !empty($approver->date_row) ? date_format(date_create($approver->date_row), ($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y" . ' H:i:s A') : '' ?></span>
                    </div>
                </div>
            <?php } ?>
        <?php $index--;
        } ?>
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="<?= set_profile($OVERTIME, 'employee') ?>" class="image_profile img-circle elevation-2" width='50' height='50' />
                <div class="ml-2">
                    <p class="p-0 m-0" style="font-weight:bold"><?= $OVERTIME->status == 'Withdrawn' ? 'Withdrawn by:' : 'Requested by:' ?></p>
                    <p class="p-0 m-0"><?= $OVERTIME->employee ?></p>
                    <p class="p-0 m-0"><?= $OVERTIME->employee_email ?></p>
                </div>
            </div>
            <div>
                <span><?= date_format(date_create($OVERTIME->create_date), ($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y" . ' H:i:s A') ?></span>
            </div>
        </div>
    </div>
    <div class="modal-footer">

         <?php
$restrictedStatuses = ['Approved', 'Rejected'];
?>

<?php if (
    $OVERTIME->status != 'Withdrawn' &&
    ($user_access == 2 || !in_array($OVERTIME->status, $restrictedStatuses))
) : ?>

    <form action="<?= base_url('selfservices/cancel_approved_leave') ?>" method="POST" class="form_cancel">
        <input type="hidden" name="rowId" value="<?= $OVERTIME->id ?>"/>
        <input type="hidden" name="remarks" class="remarks_withdrawn" value="" />
        <button type="button" class="btn btn-default cancel_form">Withdraw Leave</button>
    </form>

<?php endif; ?>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
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
    if (!$data->approver_1_stat && $data->status != 'Approved') {
        return $data->pending_approver1;
    }
    return $data->approver1;
}
function show_approver2($data)
{
    if (!$data->approver_2_stat && $data->status != 'Approved') {
        return $data->pending_approver2;
    }
    return $data->approver2;
}
function show_approver3($data)
{
    if (!$data->approver_3_stat && $data->status != 'Approved') {
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
    if ($status == 'Cancelled' && $approver_id == 0) {
        return '<span style="font-weight: bold; color: #474747;">No response needed</span>';
    }
    if (($status == 'Cancelled' && $approver_id != 0) || $status == 'Approved') {
        return '<span style="font-weight: bold; color: green;">Approved by</span>';
    }
    if ($status == 'Rejected' && $next_approver == 0) {
        return '<span style="font-weight: bold; color: red;">Rejected by</span>';
    }
    if ($status == 'Rejected' && $next_approver != 0) {
        return '<span style="font-weight: bold; color: green;">Approved by</span>';
    }
    if ($status == 'Withdrawed' && $next_approver != 0) {
        return '<span style="font-weight: bold; color: red;">Withdraw by</span>';
    }
    if ($status == 'Withdrawed' && $next_approver == 0) {
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
    if ($status == 'Cancelled' && $approver_id == 0) {
        return '<span style="font-weight: bold; color: #474747;">No response needed</span>';
    }
    if (($status == 'Cancelled' && $approver_id != 0) || $status == 'Approved') {
        return '<span style="font-weight: bold; color: green;">Approved by</span>';
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
    if ($status == 'Withdrawed' && $next_approver == 0 && $approver_id != 0) {
        return '<span style="font-weight: bold; color: red;">Withdraw by</span>';
    }
    if ($status == 'Withdrawed' && $next_approver != 0) {
        return '<span style="font-weight: bold; color: green;">Approved by</span>';
    }
    if ($status == 'Withdrawed' && $approver_id == 0) {
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
    if ($status == 'Cancelled' && $approver_id == 0) {
        return '<span style="font-weight: bold; color: #474747;">No response needed</span>';
    }
    if (($status == 'Cancelled' && $approver_id != 0) || $status == 'Approved') {
        return '<span style="font-weight: bold; color: green;">Approved by</span>';
    }
    if ($status == 'Rejected' && $approver_id != 0) {
        return '<span style="font-weight: bold; color: red;">Rejected by</span>';
    }
    if ($status == 'Rejected' && $approver_id == 0) {
        return '<span style="font-weight: bold; color: #474747;">No response needed</span>';
    }
    if ($status == 'Withdrawed' && $approver_id != 0) {
        return '<span style="font-weight: bold; color: red;">Withdraw by</span>';
    }
    if ($status == 'Withdrawed' && $approver_id == 0) {
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
    // $(document).on('click', 'button.withdraw_form', function(e) {
    //     e.preventDefault();
    //     Swal.fire({
    //         title: "Are you sure you want to withdraw approved overtime?",
    //         text: "Confirm to withdraw overtime!",
    //         icon: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#3085d6",
    //         cancelButtonColor: "#d33",
    //         cancelButtonText: "No, exit!",
    //         confirmButtonText: "Yes, confirm!"
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $('form').submit();

    //         }
    //     });
    // });
    // $(document).on('click', 'button.cancel_form', function(e) {
    //     e.preventDefault();
    //     Swal.fire({
    //         title: "Are you sure you want to withdraw overtime?",
    //         text: "Confirm to withdraw overtime!",
    //         icon: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#3085d6",
    //         cancelButtonColor: "#d33",
    //         cancelButtonText: "No, exit!",
    //         confirmButtonText: "Yes, confirm!"
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $('form').submit();

    //         }
    //     });
    // });
</script>