<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-8 ml-4 mt-3">
            <!-- <h2><a href="<?= base_url('selfservices/my_warnings') ?>"><i class="fa-duotone fa-circle-left"></i></a></h2> -->
            <h2><a href="<?= base_url('selfservices/my_warnings') ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="" for="input_id">ID</label>
                                        <input type="text" class="form-control" name="input_id" id="input_id" disabled
                                            value="<?='WRN'.str_pad($WARNING->id,5,"0", STR_PAD_LEFT );?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="" for="input_create_date">Create Date</label>
                                        <input type="text" class="form-control" disabled value="<?= !empty($WARNING->create_date) ? 
                                        date_format(date_create($WARNING->create_date), $DATE_FORMAT . ' H:i:s A') : '' ?>">
                                    </div>

                                    <!-- <div class="form-group">
                                        <label class="" for="input_create_date">Create Date</label>
                                        <input type="datetime-local" class="form-control" name="create_date"
                                            id="input_create_date" disabled value="<?=$WARNING->create_date?>">
                                    </div> -->
                                    
                                    <div class="form-group">
                                        <label class="" for="input_edit_date">Edit Date</label>
                                        <input type="text" class="form-control" disabled value="<?= !empty($WARNING->edit_date) ? 
                                        date_format(date_create($WARNING->edit_date), $DATE_FORMAT . ' H:i:s A') : '' ?>">
                                    </div>

                                    <!-- <div class="form-group">
                                        <label class="" for="input_edit_date">Edit Date</label>
                                        <input type="datetime-local" class="form-control" name="edit_date"
                                            id="input_edit_date" disabled value="<?=$WARNING->edit_date?>">
                                    </div> -->

                                    <label class="">Last Edited By</label>
                                    <select class="form-control" name="edit_user" id="input_edit_user" disabled>
                                        <option><?=$WARNING->editor?></option>
                                    </select>
    
                                    <label class="mt-2">Employee</label>
                                    <select class="form-control" name="employee_id" id="input_employee_id" disabled>
                                        <option><?=$WARNING->employee?></option>
                                    </select>
    
                                    <div class="form-group mt-2">
                                        <label class="" for="input_title">Title</label>
                                        <input type="text" class="form-control" name="title" id="input_title" disabled
                                            value="<?=$WARNING->title?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="" for="input_description">Description</label>
                                        <textarea name="description" class="form-control" id="input_description" rows="4"
                                            cols="50" disabled><?=$WARNING->description?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="" for="input_feedback">Feedback</label>
                                        <textarea name="feedback" class="form-control" id="input_feedback" rows="4"
                                            cols="50" disabled><?=$WARNING->feedback?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="" for="input_feedback">Attachment</label>
                                        <a href="<?=base_url('assets_user/files/selfservices/'.$WARNING->attachment)?>"
                                            download><?=$WARNING->attachment?></a>
                                    </div>
                                    <label class="">Status</label>
                                    <div class="form-group">
                                        <select class="form-control" name="status" id="status" disabled>
                                            <option value="Active">Active</option>
                                            <option value="Inactive" <?= $WARNING->status=='Inactive'? 'selected' : '' ?>>Inactive</option>
                                        </select>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/jquery_link'); ?>
<?php
if ($this->session->flashdata('SUCC')) {
?>
    <script>
        Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>', '', 'success')
    </script>
<?php
}
?>
<?php
if ($this->session->userdata('ERR')) {
?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-danger toast_width',
            title: 'Success',
            subtitle: 'close',
            body: '<?php echo $this->session->userdata('ERR'); ?>'
        })
    </script>
<?php
    $this->session->unset_userdata('ERR');
}
?>