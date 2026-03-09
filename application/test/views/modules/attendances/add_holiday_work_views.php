<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper" style="min-height: 692.889px;">
    <div class="container-fluid p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="https://dev-env.eyebox.app/attendances">Attendances</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="https://dev-env.eyebox.app/attendances/holiday_work">Holiday Work</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Add&nbsp;Holiday Work </li>
            </ol>
        </nav>
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-md-12">
                                 <?php echo form_open('attendances/add_new_holiday_work'); ?>
                                <label class="">Assigned By</label>
                                <select class="form-control custom_selection" name="assigned_by"
                                id="input_assigned_by">
                        <?php foreach($C_EMPLOYEES as $employee) { ?>
                                    <option value="<?=$employee->id?>"><?=$employee->col_empl_cmid.'-'.$employee->col_last_name.' '.$employee->col_frst_name?></option>
                        <?php } ?>
                                </select>

                                <label class="mt-3">Employee</label>
                                <select class="form-control custom_selection" name="empl_id"
                                    id="input_employee_id">
                            <?php foreach($C_EMPLOYEES as $employee) { ?>
                                    <option value="<?=$employee->id?>"><?=$employee->col_empl_cmid.'-'.$employee->col_last_name.' '.$employee->col_frst_name?></option>
                            <?php } ?>
                                    
                                </select>   

                                <div class="form-group mt-3">
                                    <label class="required" for="input_date">Date</label>
                                    <input type="date" required class="form-control" name="date" id="input_date" enabled=""
                                        value="">
                                </div>
                                <label class="">Type</label>
                                <div class="form-group">
                                    <select class="form-control" name="type" id="input_type" enabled="">
                                        <option>Regular</option>
                                        <option> Night Shift</option>
                                        <option> Rest</option>
                                        <option> Special</option>
                                        <option> Legal</option>
                                        <option> Rest + Special</option>
                                        <option> Rest + Legal</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="input_hours">Working Hours</label>
                                    <input type="number" required class="form-control " min="0" name="hours"
                                        id="input_hours" enabled="" value="">
                                </div>
                                <div class="form-group">
                                    <label class="" for="input_reason">Reason</label>
                                    <textarea name="reason"  class="form-control" id="reason" rows="4" cols="50"
                                        enabled=""></textarea>
                                </div>
                                <input type='hidden' name='status' value='Pending 1' />
                                <!--<label class="">Status</label>-->
                                <!--<div class="form-group">-->
                                <!--    <select class="form-control" name="input_status" id="input_status" disabled="">-->
                                <!--        <option>Pending 1</option>-->
                                <!--        <option>Pending 2</option>-->
                                <!--        <option>Pending 3</option>-->
                                <!--        <option>Approved</option>-->
                                <!--        <option>Rejected</option>-->
                                <!--    </select>-->
                                <!--</div>-->
                                <div class="form-group">
                                    <label class="" for="input_comment">Remarks</label>
                                    <textarea name="comment" class="form-control" id="input_comment" rows="4" cols="50"
                                        enabled=""></textarea>
                                </div>
                                <div class="mr-2" style="float: right !important">
                                   <button type='submit' id="btn_add" class="btn technos-button-blue shadow-none rounded " ;="">
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
<script>
    $(document).ready(function(){
        $('.custom_selection').select2();
    })
</script>