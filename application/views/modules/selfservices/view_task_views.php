<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper">

    <!-- <div class="row">

        <div class="col-md-8 ml-4 mt-3">

            <h2><a href="<?= base_url('selfservices/my_tasks') ?>"><i class="fa-duotone fa-circle-left"></i></a></h2>

        </div>

    </div> -->

    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="<?= base_url() . 'selfservices/my_tasks'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
        </div>
    </div>



    <div class="container-fluid px-4">

        <div class="row d-flex justify-content-center">

            <div class="col-sm-6">

                <div class="card">

                    <div class="modal-body pb-5">

                        <div class="row">

                            <div class="col-md-12">

                                <form action="<?=base_url('selfservices/update_task/'.$TASK->id)?>" method="post">

                                    <div class="form-group">

                                        <label class="" for="input_id">ID</label>

                                        <input type="text" class="form-control" name="id" id="input_id" disabled

                                            value=<?='TSK'.str_pad($TASK->id,5,"0", STR_PAD_LEFT );?>>

                                    </div>

                                    <div class="form-group">
                                        <label class="" for="input_create_date">Create Date</label>
                                        <input type="text" class="form-control" disabled value="<?= !empty($TASK->create_date) ? 
                                        date_format(date_create($TASK->create_date), $DATE_FORMAT . ' H:i:s A') : '' ?>">
                                    </div>

                                    <!-- <div class="form-group">

                                        <label class="" for="input_create_date">Create Date</label>

                                        <input type="datetime-local" class="form-control" name="create_date"

                                            id="input_create_date" disabled value="<?=$TASK->create_date?>">

                                    </div> -->

                                    <div class="form-group">
                                        <label class="" for="input_edit_date">Edit Date</label>
                                        <input type="text" class="form-control" disabled value="<?= !empty($TASK->edit_date) ? 
                                        date_format(date_create($TASK->edit_date), $DATE_FORMAT . ' H:i:s A') : '' ?>">
                                    </div>

                                    <!-- <div class="form-group">

                                        <label class="" for="input_edit_date">Edit Date</label>

                                        <input type="datetime-local" class="form-control" name="edit_date"

                                            id="input_edit_date" disabled value="<?=$TASK->edit_date?>">

                                    </div> -->

                                    <label class="">Last Edited By</label>
                                    <input type="" class="form-control" name="input_edit_user" id="edit_user" disabled value="<?=$TASK->editor?>">


                                    <label class="mt-2">Employee</label>
                                    <input type="" class="form-control" name="input_edit_user" id="edit_user" disabled value="<?=$TASK->employee?>">
  

                                    <div class="form-group mt-2">

                                        <label class="" for="task_title">Title</label>

                                        <input type="text" class="form-control" name="task_title"

                                            id="task_title" disabled value=" <?=$TASK->task_title?>">

                                    </div>

                                    <div class="form-group">

                                        <label class="" for="task_description">Description</label>

                                        <textarea name="task_description" class="form-control" id="task_description"

                                            rows="4" cols="50" disabled> <?=$TASK->task_description?></textarea>

                                    </div>

                                    <div class="form-group">

                                        <label class="" for="task_date_from">Date From</label>

                                        <input type="date" class="form-control" name="task_date_from"

                                            id="task_date_from" disabled value=<?=$TASK->task_date_from ?> >

                                    </div>

                                    <div class="form-group">

                                        <label class="" for="task_date_to">Date to</label>

                                        <input type="date" class="form-control" name="task_date_to"

                                            id="task_date_to" disabled value=<?=$TASK->task_date_to?> >

                                    </div>

                                    <label class="">Status</label>
                                    <input type="" class="form-control" name="input_edit_user" id="edit_user" disabled value="<?=$TASK->status?>">

                                     <br>

                                    <div class="form-group">

                                         <label class="" for="input_feedback">Attachment</label>
                                        <a class="d-block" href="<?= base_url('assets_user/files/selfservices/' . $TASK->attachment) ?>" download><?= $TASK->attachment ?></a>

                                    </div>

                                    <div class="form-group">

                                        <label class="" for="remarks">Remarks</label>

                                        <textarea name="remarks" class="form-control" id="remarks" rows="4" cols="50"

                                        disabled value=><?=$TASK->remarks?></textarea>

                                    </div>
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