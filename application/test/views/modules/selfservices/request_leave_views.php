<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper" >

        <div class="container-fluid p-4">

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb">



                    <li class="breadcrumb-item">

                        <a href="https://dev-env.eyebox.app/selfservices">Self Services</a>

                    </li>

                    <li class="breadcrumb-item">

                        <a href="https://dev-env.eyebox.app/selfservices/my_leaves">My Leave Applications</a>

                    </li>

                    <li class="breadcrumb-item active" aria-current="page">Add&nbsp;My Leave Applications </li>

                </ol>

            </nav>

            <div class="row d-flex justify-content-center">

                <div class="col-sm-6">

                    <div class="card">

                        <div class="modal-body pb-5">

                            <div class="row">

                                <div class="col-md-12">

                            <?php echo form_open_multipart('selfservices/add_leave_request');?>

                                     <input type='hidden' value="<?=$this->session->userdata('SESS_USER_ID')?>" name='assigned_by'/>

                                    <input type='hidden' value="<?=$this->session->userdata('SESS_USER_ID')?>" name='empl_id'/>

                               

                                    <label class="">Type</label>

                                    <div class="form-group">

                                        <select class="form-control" name="type" id="input_type" enabled="">
                                        <option value="0">Leave Without Pay (LWOP)</option>

                                    <?php foreach($LEAVE_TYPES as $leave_type) { ?>

                                            <option value="<?=$leave_type->id?>"><?=$leave_type->name?></option>

                                    <?php } ?>

                                        </select>

                                    </div>

                                    <label class="">Current Leave Balance</label>

                                    <div class="form-group">

                                          <input type="number" class="form-control " min="0" name="duration"

                                        id="input_duration" required enabled="" value=0 disabled>


                                    </div>

                                    <div class="form-group">

                                        <label class="required" for="input_leave_date">Leave Date</label>

                                        <input type="date" class="form-control" name="leave_date" required

                                            id="input_leave_date" enabled="" value="">

                                    </div>

                                    <div class="form-group">

                                        <label class="required" for="input_duration">Leave Duration (Hours)</label>

                                        <input type="number" class="form-control " min="0" name="duration"

                                            id="input_duration" required enabled="" value="">

                                    </div>

                                    <input type='hidden' name='status' value='Pending 1'/>

                                    <!--<label class="">Status</label>-->

                                    <!--<div class="form-group">-->

                                        

                                    <!--    <select class="form-control" name="status" id="input_status"-->

                                    <!--        disabled="">-->

                                    <!--        <option>Pending 1</option>-->

                                    <!--    </select>-->

                                    <!--</div>-->

                                    <!--<div class="form-group">-->

                                    <!--    <label class="" for="input_remarks">Remarks</label>-->

                                    <!--    <textarea name="remarks" class="form-control" id="input_remarks" rows="4"-->

                                    <!--        cols="50" enabled=""></textarea>-->

                                    <!--</div>-->

                                    <div class="form-group">

                                        <label class="" for="input_attachment">Attachment</label>

                                        <input type="file" class="form-control file_upload" name="attachment"

                                            id="input_attachment" enabled="" value="">

                                    </div>

                                    <div class="mr-2" style="float: right !important">

                                        <button id="btn_add" type='submit' class="btn technos-button-blue shadow-none rounded " ;="">

                                            Submit</button>

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

    <script>Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>','','success')</script>

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