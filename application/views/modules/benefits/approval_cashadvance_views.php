<?php $this->load->view('templates/css_link'); ?>
<style>
    .approval p{
        font-weight: 500;
    }
    span{
        font-weight: 400;
    }
    .modal-content {
        box-shadow: none;
    }
</style>

<script>
      function setDefaultImage(img) {
        img.src = "<?= base_url() ?>/assets_system/images/default_user.jpg";
        img.alt = 'Default Image';
      }
</script>
<div class="content-wrapper" style="min-height: 624px;">
    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="<?= base_url() . 'benefits/cashadvance'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
        </div>
    </div>

    <div class="modal-dialog approval">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cash Advance Request (<?= 'CA' . str_pad($data[0]->id, 5, '0', STR_PAD_LEFT) ?>)</h5>
            </div>
            <div class="modal-body">
                <form action="<?= base_url()?>benefits/cashadvance_approval_action" id="approval_form" method="post">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1">Date: <span><?= date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($data[0]->create_date)) ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="mb-1">Type: <span><?=$data[0]->type?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="mb-1">Amount: <span><?=$data[0]->amount?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="mb-1">Status: 
                                <?php if ($data[0]->status == "Approved") { ?>
                                    <span class='btn btn-sm btn-success disabled'><?= $data[0]->status ?></span>
                                <?php } elseif ($data[0]->status == "Rejected") { ?>
                                    <span class='btn btn-sm btn-danger disabled'><?= $data[0]->status ?></span>
                                <?php } elseif ($data[0]->status == "Withdrawed") { ?>
                                    <span class='btn btn-sm btn-secondary disabled'><?= $data[0]->status ?></span>
                                <?php } else { ?>
                                    <span class='btn btn-sm btn-warning disabled'>Pending</span>
                                <?php } ?>
                            </p>
                        </div>
                        <div class="col-12">
                            <p class="mb-1">Attachment: <a href="<?= base_url('assets_user/files/benefits/'.$data[0]->attachment) ?>" download> <?= $data[0]->attachment ?></a></p>
                        </div>
                        <div class="col-12">
                            <p class="mb-1">Description: <span><?=$data[0]->description?></span></p>
                        </div>
                        <?php if($data[0]->status == "Approved" || $data[0]->status == "Rejected") {?>
                            <div class="col-12">
                                <p class="mb-1">Remarks: <span><?=$data[0]->remarks?></span></p>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if($data[0]->status == "Pending") {?>
                        <div class="form-group">
                            <label class="required" for="remarks">Remarks</label>
                            <textarea required name="remarks" class="form-control" id="remarks" rows="4" cols="50" enabled=""
                            ><?= $data[0]->remarks ?></textarea>
                        </div>
                    <?php } ?>

                    <input type="hidden" name="id" value="<?=$data[0]->id?>">
                </form>
                <?php if($data[0]->status == "Approved" || $data[0]->status == "Rejected" || $data[0]->status == "Withdrawed") {?>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <div class="line_progress" style="position:relative;width:1px;height:50px;background-color:black;bottom:-45px;left:26px"></div>
                            <img src="<?= base_url('assets_user/user_profile/'.$data[0]->approver_col_imag_path) ?>" onerror="setDefaultImage(this)"
                            class="rounded-circle elevation-2 m-0 p-0" style="z-index: 1000;object-fit: scale-down;" width='50px' height='50px' />
                            <div class="ml-2">
                                <p class="p-0 m-0"><?= $data[0]->status.' By:'?></p>
                                <p class="p-0 m-0"><span><?= $data[0]->approver ?></span></p>
                                <p class="p-0 m-0"><span><?= $data[0]->approver_col_comp_emai ?></span></p>
                            </div>
                        </div>
                        <div>
                            <span><?= date_format(date_create($data[0]->approver_date), $DATE_FORMAT . ' H:i:s A') ?></span>
                        </div>
                    </div>
                <?php } ?>
                <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <div class="line_progress" style="position:relative;width:1px;height:50px;background-color:black;bottom:-45px;left:26px"></div>
                            <img src="<?= base_url('assets_user/user_profile/'.$data[0]->col_imag_path) ?>" onerror="setDefaultImage(this)"
                            class="rounded-circle elevation-2 m-0 p-0" style="z-index: 1000;object-fit: scale-down;" width='50px' height='50px' />
                            <div class="ml-2">
                                <p class="p-0 m-0">Employee:</p>
                                <p class="p-0 m-0"><span><?= $data[0]->employee ?></span></p>
                                <p class="p-0 m-0"><span><?= $data[0]->col_comp_emai ?></span></p>
                            </div>
                        </div>
                        <div>
                            <!-- <span><?= date_format(date_create($data[0]->create_date), $DATE_FORMAT . ' H:i:s A') ?></span> -->
                        </div>
                    </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <img src="<?= base_url('assets_user/user_profile/'.$data[0]->requester_col_imag_path) ?>" onerror="setDefaultImage(this)"
                        class="image_profile rounded-circle elevation-2" style="z-index: 1000;object-fit: scale-down;" width='50px' height='50px' />
                        <div class="ml-2">
                            <p class="p-0 m-0">Requested By:</p>
                            <p class="p-0 m-0"><span><?= $data[0]->requester ?></span></p>
                            <p class="p-0 m-0"><span><?= $data[0]->requester_col_comp_emai ?></span></p>
                        </div>
                    </div>
                    <div>
                        <span><?= date_format(date_create($data[0]->create_date), $DATE_FORMAT . ' H:i:s A') ?></span>
                    </div>
                </div>
            </div>
            <?php if($data[0]->status == "Pending") {?>
                <div class="modal-footer">
                <button onclick="setStatusAndSubmit('Rejected')" type="button" class="btn btn-danger">Reject</button>
                <button onclick="setStatusAndSubmit('Withdrawed')"  type="button" class="btn btn-secondary">Withdraw</button>
                <button onclick="setStatusAndSubmit('Approved')"  type="button" class="btn btn-primary">Approve</button>
            </div>
            <?php } ?>
        </div>
    </div>

</div>

<?php $this->load->view('templates/jquery_link'); ?>
<?php if ($this->session->flashdata('SUCC')) { ?>
    <script>
        Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>', '', 'success')
    </script>
<?php } ?>
<?php if ($this->session->flashdata('ERR')) { ?>
    <script>
        Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>',
            '',
            'error'
        )
    </script>
<?php } ?>

<script>
    $(document).ready(function() {
        $('#input_empl_id').select2();
    });
</script>

<script>
    function setStatusAndSubmit(status) {
        var remarksValue = document.getElementById('remarks').value;
        console.log('remarkValue', remarksValue);
        if (!remarksValue) {
            $(document).Toasts('create', {
                class: 'bg-warning toast_width',
                title: 'Warning!',
                subtitle: 'close',
                body: 'Please input Remarks'
            });
            return;
        }
        var form = document.getElementById("approval_form");
        var statusInput = document.createElement("input");
        statusInput.setAttribute("type", "hidden");
        statusInput.setAttribute("name", "status");
        statusInput.setAttribute("value", status);
        form.appendChild(statusInput);
        form.submit(); 
    }
</script>
