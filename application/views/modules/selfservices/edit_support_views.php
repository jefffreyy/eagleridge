<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper">

    <div class="row">

        <div class="col-md-8 ml-4 mt-3">

            <h2><a href="<?= base_url('selfservices/my_support_requests') ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="">
                </a></h2>

        </div>

    </div>



    <div class="container-fluid px-4">

        <div class="row d-flex justify-content-center">

            <div class="col-sm-6">

                <div class="card">

                    <div class="modal-body pb-5">

                        <div class="row">

                            <div class="col-md-12">

                                <form action="<?= base_url('selfservices/update_support/' . $SUPPORT->id) ?>" method="POST">

                                    <div class="form-group">

                                        <label class="" for="input_id">ID</label>

                                        <input type="text" class="form-control" name="input_id" id="input_id" disabled value="<?= 'SUP' . str_pad($SUPPORT->id, 5, "0", STR_PAD_LEFT); ?>">

                                    </div>

                                    <div class="form-group">
                                        <label class="" for="input_create_date">Create Date</label>
                                        <input type="text" class="form-control" disabled value="<?= !empty($SUPPORT->create_date) ? 
                                        date_format(date_create($SUPPORT->create_date), $DATE_FORMAT . ' H:i:s A') : '' ?>">
                                    </div>

                                    <!-- <div class="form-group">

                                        <label class="" for="input_create_date">Create Date</label>

                                        <input type="datetime-local" class="form-control" name="create_date" id="input_create_date" disabled value="<?= $SUPPORT->create_date ?>">

                                    </div> -->

                                    <div class="form-group">
                                        <label class="" for="input_edit_date">Edit Date</label>
                                        <input type="text" class="form-control" disabled value="<?= !empty($SUPPORT->edit_date) ? 
                                        date_format(date_create($SUPPORT->edit_date), $DATE_FORMAT . ' H:i:s A') : '' ?>">
                                    </div>

                                    <!-- <div class="form-group">

                                        <label class="" for="input_edit_date">Edit Date</label>

                                        <input type="datetime-local" class="form-control" name="edit_date" id="input_edit_date" disabled value="<?= $SUPPORT->edit_date ?>">

                                    </div> -->

                                    <label class="">Last Edited By</label>

                                    <select class="form-control" name="edit_user" id="input_edit_user" disabled>

                                        <option><?= $SUPPORT->editor ?></option>

                                    </select>



                                    <label class="">Employee</label>

                                    <select class="form-control" name="employee_id" id="input_employee_id" disabled>

                                        <option><?= $SUPPORT->employee ?></option>

                                    </select>



                                    <div class="form-group">

                                        <label class="" for="input_title">Title</label>

                                        <input type="text" class="form-control" name="title" id="input_title" enabled value="<?= $SUPPORT->title ?>">

                                    </div>

                                    <div class="form-group">

                                        <label class="" for="input_description">Description</label>

                                        <textarea name="description" class="form-control" id="input_description" rows="4" cols="50" enabled><?= $SUPPORT->description ?></textarea>

                                    </div>

                                    <div class="form-group">

                                        <label class="" for="input_feedback">Feedback</label>

                                        <textarea name="feedback" class="form-control" id="input_feedback" rows="4" cols="50" enabled><?= $SUPPORT->feedback ?></textarea>

                                    </div>

                                    <div class="form-group">

                                        <div class="file_uploader" data-type="self_services">

                                            <label>Attachment</label>

                                            <input type="hidden" name="attachment" value="<?= $SUPPORT->attachment ?>" class="selected_images d-block w-100" />

                                        </div>

                                        <a href="<?= base_url('assets_user/files/selfservices/' . $SUPPORT->attachment) ?>" download><?= $SUPPORT->attachment ?></a>

                                    </div>

                                    <label class="">Status</label>

                                    <div class="form-group">

                                        <select class="form-control" name="status" id="status" enabled>

                                            <option value="Active">Active</option>

                                            <option value="Inactive" <?= $SUPPORT->status == 'Inactive' ? 'selected' : '' ?>>Inactive</option>

                                        </select>

                                    </div>

                                    <div class="mr-2" style="float: right !important">

                                        <button type="submit" id="btn_edit" class="btn technos-button-blue shadow-none rounded" ;> Submit</button>

                                    </div>

                                </form>

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