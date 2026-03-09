<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper" style="min-height: 692.889px;">

    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="<?= base_url('overtimes/time_adjustments') ?>"><i class="fa-duotone fa-circle-left"></a></i></h2>
        </div>
    </div>

    <div class="container-fluid px-4">

        <div class="row d-flex justify-content-center">

            <div class="col-sm-6">

                <div class="card">

                    <div class="modal-body pb-5">

                        <div class="row">

                            <div class="col-md-12">

                                <?php echo form_open_multipart('overtimes/add_new_time_adjustments'); ?>

                                <label class="">Assigned By</label>

                                <select class="form-control custom_selection" name="assigned_by" id="input_assigned_by">

                                    <?php foreach ($C_EMPLOYEES as $employee) { ?>

                                        <option value="<?= $employee->id ?>"><?= $employee->col_empl_cmid . '-' . $employee->col_last_name . ' ' . $employee->col_frst_name ?></option>

                                    <?php } ?>

                                </select>



                                <label class="mt-3">Employee</label>

                                <select class="form-control custom_selection" name="empl_id" id="input_employee_id">

                                    <?php foreach ($C_EMPLOYEES as $employee) { ?>

                                        <option value="<?= $employee->id ?>"><?= $employee->col_empl_cmid . '-' . $employee->col_last_name . ' ' . $employee->col_frst_name ?></option>

                                    <?php } ?>



                                </select>



                                <div class="form-group mt-3">

                                    <label class="required" for="input_date_adjustment">Adjustment Date</label>

                                    <input type="date" required class="form-control" name="date_adjustment" id="input_date_adjustment" enabled="" value="">

                                </div>

                                <label class="">Shift Type</label>

                                <div class="form-group">

                                    <select class="form-control" name="shift_type" id="input_shift_type" enabled="">

                                        <?php foreach ($C_SHIFT_TYPES as $type) { ?>

                                            <option><?= $type->name ?></option>

                                        <?php } ?>

                                    </select>

                                </div>

                                <div class="form-group">

                                    <label class="required" for="input_time_in_1">Time&nbsp;In&nbsp;1</label>

                                    <input type="time" required class="form-control" name="time_in_1" id="input_time_in_1" enabled="" value="">

                                </div>

                                <div class="form-group">

                                    <label class="required" for="input_time_out_1">Time&nbsp;Out&nbsp;1</label>

                                    <input type="time" required class="form-control" name="time_out_1" id="input_time_out_1" enabled="" value="">

                                </div>

                                <div class="form-group">

                                    <label class="required" for="input_time_in_2">Time&nbsp;In&nbsp;2</label>

                                    <input type="time" required class="form-control" name="time_in_2" id="input_time_in_2" enabled="" value="">

                                </div>

                                <div class="form-group">

                                    <label class=" required" for="input_time_out_2">Time&nbsp;Out&nbsp;2</label>

                                    <input type="time" required class="form-control" name="time_out_2" id="input_time_out_2" enabled="" value="">

                                </div>

                                <div class="form-group">

                                    <label class="" for="input_attachment">Attachment</label>

                                    <input type="file" class="form-control file_upload" name="attachment" id="input_attachment" enabled="" value="">

                                </div>

                                <div class="form-group">

                                    <label class="" for="input_reason">Reason</label>

                                    <textarea name="reason" class="form-control" id="input_reason" rows="4" cols="50" enabled=""></textarea>

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

                                    <label class="" for="input_remarks">Remarks</label>

                                    <textarea name="remarks" class="form-control" id="input_remarks" rows="4" cols="50" enabled=""></textarea>

                                </div>

                                <div class="mr-2" style="float: right !important">

                                    <button type='submit' class="btn technos-button-blue shadow-none rounded " ;="">

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

    <script>
        Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>', '', 'success')
    </script>

<?php

}

?>

<?php

if ($this->session->flashdata('ERR')) {

?>

    <script>
        Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>',

            '',

            'error'

        )
    </script>

<?php

}

?>

<script>
    $(document).ready(function() {

        $('.custom_selection').select2();

    })
</script>