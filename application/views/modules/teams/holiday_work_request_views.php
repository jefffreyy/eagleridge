<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper" style="min-height: 692.889px;">
    <div class="container-fluid px-4">
        <div class='row mt-3'>
            <div class='col-md-8'>
                <h2><a href="<?= base_url('teams/apply_holiday_works') ?>"><img style="width: 28px; height: 28px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a></h2>
            </div>
        </div>

        <div class="row d-flex justify-content-center">

            <div class="col-sm-6">

                <div class="card">

                    <div class="modal-body pb-5">

                        <div class="row">

                            <div class="col-md-12">

                                <?php echo form_open('teams/add_new_holiday_work'); ?>

                                <label class="mt-3">Employee</label>

                                <select class="form-control custom_selection" name="empl_id" id="input_employee_id">

                                    <?php foreach ($EMPLOYEES as $employee) { 
                                        $name = $employee->col_empl_cmid . '-' . $employee->col_last_name;
                                        if(!empty($employee->col_suffix))$name = $name.' '.$employee->col_suffix;
                                        if(!empty($employee->col_frst_name))$name = $name.', '.$employee->col_frst_name;
                                        if(!empty($employee->col_midl_name))$name = $name.' '.$employee->col_midl_name[0].'.';
                                        ?>

                                        <option value="<?= $employee->id ?>">
                                        <?= $name
                                        // $employee->col_empl_cmid . '-' . $employee->col_last_name . ' ' . $employee->col_frst_name 
                                        ?></option>

                                    <?php } ?>



                                </select>



                                <div class="form-group mt-3">

                                    <label class="required" for="input_date">Date</label>

                                    <input type="date" required class="form-control" name="date" id="input_date" enabled="" value="">

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

                                    <input type="number" required class="form-control " min="0" name="hours" id="input_hours" enabled="" value="">

                                </div>

                                <div class="form-group">

                                    <label class="" for="input_reason">Reason</label>

                                    <textarea name="reason" class="form-control" id="reason" rows="4" cols="50" enabled=""></textarea>

                                </div>

                                <div class="form-group">

                                    <label class="" for="input_comment">Remarks</label>

                                    <textarea name="comment" class="form-control" id="input_comment" rows="4" cols="50" enabled=""></textarea>

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