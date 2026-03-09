<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper" style="min-height: 624px;">
    <div class="container-fluid p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="https://dev-env.eyebox.app/selfservices">Self Services</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="https://dev-env.eyebox.app/selfservices/my_tasks">My Tasks</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Add&nbsp;My Tasks </li>
            </ol>
        </nav>
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_open_multipart('selfservices/add_new_task');?>
                                <input type='hidden' value="<?=$this->session->userdata('SESS_USER_ID')?>" name='employee_id'/>
                             
                                <div class="form-group">
                                    <label class="required" for="input_task_title">Title</label>
                                    <input type="text" required class="form-control" name="task_title"
                                        id="input_task_title" enabled="" value="">
                                </div>
                                <div class="form-group">
                                    <label class="required" for="input_task_description">Description</label>
                                    <textarea required name="task_description" class="form-control" id="task_description"
                                        rows="4" cols="50" enabled=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="input_task_date_from">Date From</label>
                                    <input type="date" required class="form-control" name="task_date_from"
                                        id="input_task_date_from" enabled="" value="">
                                </div>
                                <div class="form-group">
                                    <label class="required" for="input_task_date_to">Date to</label>
                                    <input type="date" required class="form-control" name="task_date_to"
                                        id="input_task_date_to" enabled="" value="">
                                </div>
                                <label class="">Status</label>
                                <div class="form-group">
                                    <select class="form-control" name="status" id="status" enabled="">
                                        <option>Open</option>
                                        <option>Closed</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="" for="input_attachment">Attachment</label>
                                    <input type="file" class="form-control file_upload" name="attachment"
                                        id="input_attachment" enabled="" value="">
                                </div>
                                <!--<div class="form-group">-->
                                <!--    <label class="" for="input_remarks">Remarks</label>-->
                                <!--    <textarea name="remarks" class="form-control" id="input_remarks" rows="4" cols="50"-->
                                <!--        enabled=""></textarea>-->
                                <!--</div>-->
                                <div class="mr-2" style="float: right !important">
                                    <button type='submit'  class="btn technos-button-blue shadow-none rounded " ;="">
                                        Submit</button>
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
    <script>Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>','','success')</script>
<?php 
}
?>
<?php
if ($this->session->flashdata('ERR')) {
?>
    <script>Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>',
            '',
            'error'
        )
    </script>
<?php
}
?>
