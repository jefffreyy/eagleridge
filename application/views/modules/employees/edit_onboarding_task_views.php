<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper" style="min-height: 624px;">
    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="<?= base_url() . 'employees/onboarding'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
        </div>
    </div>

    <!-- <?php echo var_dump($DISP_ONBOARDINGS);
    ?> -->


    <div class="container-fluid p-4">

        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_open('employees/update_onboarding_task'); ?>

                                
                                <div class="form-group">
                                <input type="hidden" name="id" value="<?= $DISP_ONBOARDINGS->id ?>">
                                    <label class="required" for="date">Date:</label>
                                    <input type="date" class="form-control" name="date" id="date" value="<?= $DISP_ONBOARDINGS->date;?>" required enabled="">
                                    </div>

                                    <div class="form-group">
                                <input type="hidden" name="id" value="<?= $DISP_ONBOARDINGS->id ?>">
                                <label class="required">Employee</label>
                                <select class="form-control custom_selection" name="employee_id" id="employee_id">
                                    <?php foreach ($C_EMPLOYEES as $employee) { ?>
                                        <option value="<?= $employee->id ?>"><?= $employee->col_empl_cmid . '-' . $employee->col_last_name . ' ' . $employee->col_frst_name ?></option>
                                    <?php } ?>
                                </select>
                                

                                <div class="form-group">
                                <input type="hidden" name="id" value="<?= $DISP_ONBOARDINGS->id ?>">
                                <label class="required mt-2" for="task_name">Task Name:</label>
                                <input type="text" required class="form-control" name="task_name" id="task_name" enabled="" value="<?= $DISP_ONBOARDINGS->task_name;?>">
                                </div>

                                <div class="form-group">
                                <input type="hidden" name="id" value="<?= $DISP_ONBOARDINGS->id ?>">
                                <label class="required mt-2" for="person_in_charge">Person In Charge:</label>
                                <select class="form-control custom_selection" name="person_in_charge" id="person_in_charge">
                                    <?php foreach ($C_EMPLOYEES as $employee) { ?>
                                        <option value="<?= $employee->id ?>"><?= $employee->col_empl_cmid . '-' . $employee->col_last_name . ' ' . $employee->col_frst_name ?></option>
                                    <?php } ?>
                                </select>

<!--                                 
                                    <label class="required" for="person_in_charge">Person In Charge:</label>
                                    <input type="text" required class="form-control" name="person_in_charge" id="person_in_charge" enabled="" value="<?= $DISP_ONBOARDINGS->person_in_charge;?>">
                                </div> -->

                                <label class="mt-2">Status:</label>
                                <div class="form-group">
                                <input type="hidden" name="id" value="<?= $DISP_ONBOARDINGS->id ?>">
                                <select class="form-control" name="status" id="status" enabled=""value="">
                                        

                                        <option value=''>-Select Status-</option>
                                        <option 
                                        <?php echo($DISP_ONBOARDINGS->status=="Partial")?"Selected":""?>>Partial</option>
                                        <option
                                        <?php echo($DISP_ONBOARDINGS->status=="Not Yet Started")?"Selected":""?>>Not Yet Started</option>
                                        <option 
                                        <?php echo($DISP_ONBOARDINGS->status=="Completed")?"Selected":""?>>Completed</option>
                                        <option 
                                        <?php echo($DISP_ONBOARDINGS->status=="Cancelled")?"Selected":""?>>Cancelled</option>
                                    </select>
                                </div>

                                <div class="mr-2" style="float: right !important">
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