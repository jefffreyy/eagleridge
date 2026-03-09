<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper" style="min-height: 624px;">

    <div class="container-fluid p-4">

        <nav aria-label="breadcrumb">

            <ol class="breadcrumb">



                <li class="breadcrumb-item">

                    <a href="https://dev-env.eyebox.app/selfservices">Self Services</a>

                </li>

                <li class="breadcrumb-item">

                    <a href="https://dev-env.eyebox.app/selfservices/my_time_adjustments">My Time Adjustment</a>

                </li>

                <li class="breadcrumb-item active" aria-current="page">Add&nbsp;My Time Adjustment </li>

            </ol>

        </nav>

        <div class="row d-flex justify-content-center">

            <div class="col-sm-6">

                <div class="card">

                    <div class="modal-body pb-5">

                        <div class="row">

                            <div class="col-md-12">

                                <?php echo form_open_multipart('selfservices/add_time_adjustment');?>

                                    <input type='hidden' value="<?=$this->session->userdata('SESS_USER_ID')?>" name='assigned_by'/>

                                    <input type='hidden' value="<?=$this->session->userdata('SESS_USER_ID')?>" name='empl_id'/>

    

                                    <div class="form-group">

                                        <label class="required" for="input_date_adjustment">Adjustment&nbsp;Date</label>

                                        <!--<input type="date" required class="form-control" name="input_date_adjustment"-->

                                        <!--    id="input_date_adjustment" enabled="" value="">-->

                                        <select id='selected_date' class="custom-select" name='date_adjustment'>

                                    <?php foreach($ATTENDANCE_REC as $attendace) { ?>

                                            <option value="<?=$attendace->date?>" <?=$attendace->date==$DEFAULT_VAL->date?'selected' :'' ?> ><?= date_format(date_create($attendace->date),'F d Y') ?></option>

                                    <?php } ?>

                                        </select>

                                    </div>

                                    <div class="form-group">

                                        <label class="required" for="input_time_in_1">Time&nbsp;In&nbsp;1</label>

                                        <input type="time" required class="form-control" name="time_in_1" id="input_time_in_1"

                                            enabled="" value="<?=$DEFAULT_VAL->time_in1 ? $DEFAULT_VAL->time_in1  : '' ?>">

                                    </div>

                                    <div class="form-group">

                                        <label class="required" for="input_time_out_1">Time&nbsp;Out&nbsp;1</label>

                                        <input type="time" class="form-control" name="time_out_1"

                                            id="input_time_out_1" enabled=""  value="<?=$DEFAULT_VAL->time_out1 ? $DEFAULT_VAL->time_out1  : '' ?>">

                                    </div>

                                    <div class="form-group">

                                        <label class="required" for="input_time_in_2">Time&nbsp;In&nbsp;2</label>

                                        <input type="time" required class="form-control" name="time_in_2" id="input_time_in_2"

                                            enabled=""  value="<?=$DEFAULT_VAL->time_in2 ? $DEFAULT_VAL->time_in2  : '' ?>">

                                    </div>

                                    <div class="form-group">

                                        <label class="required" for="input_time_out_2">Time&nbsp;Out&nbsp;2</label>

                                        <input type="time" required class="form-control" name="time_out_2"

                                            id="input_time_out_2" enabled="" value="<?=$DEFAULT_VAL->time_out2 ? $DEFAULT_VAL->time_out2  : '' ?>">

                                    </div>

                                    <div class="form-group">

                                        <label class="" for="input_attachment">Attachment</label>

                                        <input type="file"  class="form-control file_upload" name="attachment"

                                            id="input_attachment" enabled="" value="">

                                    </div>

                                    <div class="form-group">

                                        <label class="" for="input_reason">Reason</label>

                                        <textarea name="reason" class="form-control" id="reason" rows="4" cols="50"

                                            enabled=""></textarea>

                                    </div>

                                     <input type='hidden' name='status' value='Pending 1'/>

                                    <!--<label class="">Status</label>-->

                                    <!--<div class="form-group">-->

                                       

                                    <!--    <select class="form-control" name="input_status" id="status" disabled="">-->

                                    <!--        <option>Pending 1</option>-->

                                    <!--        <option>Approved</option>-->

                                    <!--        <option>Rejected</option>-->

                                    <!--    </select>-->

                                    <!--</div>-->

                                    <!--<div class="form-group">-->

                                    <!--    <label class="" for="input_remarks">Remarks</label>-->

                                    <!--    <textarea name="remarks" class="form-control" id="remarks" rows="4" cols="50"-->

                                    <!--        enabled=""></textarea>-->

                                    <!--</div>-->

                                    <div class="mr-2" style="float: right !important">

                                        <button type='submit' id="btn_add"  class="btn technos-button-blue shadow-none rounded " ;="">

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

<script>

    $(document).ready(function(){

        $('#selected_date').on('change',function(){

            window.location = "?date="+$(this).val() 

        })

    })

</script>