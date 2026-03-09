<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper" style="min-height: 624px;">
    <div class="container-fluid p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="https://dev-env.eyebox.app/leaves">Leaves</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="https://dev-env.eyebox.app/leaves/leave_lists">Leave Requests</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Add&nbsp;Leave Requests </li>
            </ol>
        </nav>
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_open_multipart('leaves/add_new_leave');?>
                                <label class="">Assigned by</label>
                                <select class="form-control custom_selection" name="assigned_by"
                                    id="input_assigned_by">
                                    <option value="1">ABC00001- Ethan Smith
                                    </option>
                                    <option value="3">ABC00002- Ava Johnson</option>
                                    <option value="4">ABC00003- Noah Williams</option>
                                    <option value="5">ABC00004- Olivia Jones</option>
                                    <option value="76">ABC00075- Aaron Bennett</option>
                                    <option value="77">ABC00076- Natalie Wood</option>
                                    <option value="78">ABC00077- Adrian Barnes</option>
                                </select>

                                <label class="">Employee</label>
                                <select class="form-control custom_selection" name="empl_id"
                                    id="input_empl_id" >
                                    <option value="1">ABC00001- Ethan Smith
                                    </option>
                                    <option value="3">ABC00002- Ava Johnson</option>
                                    <option value="4">ABC00003- Noah Williams</option>
                                    <option value="5">ABC00004- Olivia Jones</option>
                                    <option value="76">ABC00075- Aaron Bennett</option>
                                    <option value="77">ABC00076- Natalie Wood</option>
                                    <option value="78">ABC00077- Adrian Barnes</option>
                                </select>
                                <label class="">Type</label>
                                <div class="form-group">
                                    <select class="form-control" name="type" id="type" enabled="">
                                <?php foreach($LEAVE_TYPES as $type) { ?>
                                        <option value='<?=$type->id?>'><?=$type->name?></option>
                                
                                <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="input_leave_date">Leave Date</label>
                                    <input type="date" class="form-control" name="leave_date"
                                        id="input_leave_date" required enabled="" value="">
                                </div>
                                <div class="form-group">
                                    <label class="required" for="input_duration">Leave Duration (Hours)</label>
                                    <input type="number" class="form-control " min="0" name="duration"
                                        id="input_duration" enabled="" value="" required>
                                </div>
                                <input type='hidden' name='status' value='Pending 1'/> 
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
                                <!--<div class="form-group">-->
                                <!--    <label class="" for="input_remarks">Remarks</label>-->
                                <!--    <textarea name="remarks" class="form-control" id="remarks" rows="4" cols="50"-->
                                <!--        enabled=""></textarea>-->
                                <!--</div>-->
                                <div class="form-group">
                                    <label class="" for="input_attachment">Attachment</label>
                                    <input type="file" class="form-control file_upload" name="attachment"
                                        id="input_attachment" enabled="" value="">
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
        $('.custom_selection').select2()
    })
</script>