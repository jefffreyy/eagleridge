<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper" style="min-height: 624px;">
    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="<?= base_url() . 'employees/onboarding'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
        </div>
    </div>

    <div class="container-fluid p-4">

        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_open('employees/request_onboarding_task'); ?>
                                <input type='hidden' value="<?= $this->session->userdata('SESS_USER_ID') ?>" name='employee_id' />
                                
                                <div class="form-group">
                                    <label class="required" for="input_onboard_date">Date:</label>
                                    <input type="date" class="form-control" name="date" id="date" value="<?= date('Y-m-d') ?>" required enabled="">
                                    </div>
                                    

                                    <div class="form-group">
                                    <label class="">Employee</label>

                                    <select class="form-control custom_selection" name="employee_id" id="employee_id">
                                        <?php foreach($EMPLOYEES as $employee) { 
                                            $name = $employee->col_empl_cmid.'-'.$employee->col_last_name;
                                            if($employee->col_suffix)$name = $name.' '.$employee->col_suffix;
                                            if($employee->col_frst_name)$name = $name.', '.$employee->col_frst_name;
                                            if($employee->col_midl_name)$name = $name.' '.$employee->col_midl_name[0].'.';
                                            ?>
                                            <option value="<?=$employee->id?>"> 
                                            <?= $name
                                            // $employee->col_empl_cmid.' - '. $employee->col_last_name.' '. $employee->col_frst_name
                                            ?></option>     
                                        <?php } ?>

                                    </select>
                                </div>


                                <div class="form-group">
                                    <label class="required mt-2" for="task_name">Task Name:</label>
                                    <input type="text" required class="form-control" name="task_name" id="task_name" enabled="" value="">
                                </div>

                                <label class="required">Person in Charge</label>
                                <select class="form-control custom_selection" name="employee_id" id="employee_id">
                                    <?php foreach ($EMPLOYEES  as $employee) { ?>
                                        <option value="<?= $employee->id ?>"><?= $employee->col_empl_cmid . '-' . $employee->col_last_name . ' ' . $employee->col_frst_name ?></option>
                                    <?php } ?>
                                </select>


                                <label class="mt-3">Status:</label>
                                <div class="form-group">
                                    <select class="form-control" name="status" id="status" enabled="">
                                        <option value=''>-Select Status-</option>
                                        <option>Partial</option>
                                        <option>Not Yet Started</option>
                                        <option>Completed</option>
                                        <option>Cancelled</option>
                                    </select>
                                </div>

                                <div class="mr-2 mt-2" style="float: right !important">
                                    <button type='submit' class="btn btn-primary shadow-none rounded ">
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


<?php
  if ($this->session->userdata('SUCC')) {
  ?>
    <script>
      $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success!',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('SUCC'); ?>'
      })
    </script>
  <?php
  }
  ?>
  
  <?php
  if ($this->session->userdata('ERR')) {
  ?>
    <script>
      $(document).Toasts('create', {
        class: 'bg-warning toast_width',
        title: 'Warning!',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('ERR'); ?>'
      })
    </script>
  <?php
  }
  ?>


