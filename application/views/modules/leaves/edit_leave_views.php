<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper">
  <div class='row'>
    <div class='col-md-8 ml-4 mt-3'>
      <h2><a href="<?= base_url() . 'leaves/leave_lists'; ?>"><i class="fa-duotone fa-circle-left"></a></i></h2>
    </div>
  </div>
  <div class="container-fluid px-4">

    <nav aria-label="breadcrumb">

      <ol class="breadcrumb">

        <li class="breadcrumb-item">

          <a href="<?= base_url('leaves') ?>">Leaves</a>

        </li>

        <li class="breadcrumb-item">

          <a href="<?= base_url('leaves/leave_lists') ?>">Leave Requests</a>

        </li>

        <li class="breadcrumb-item active" aria-current="page">Edit&nbsp;Leave Requests </li>

      </ol>

    </nav>

    <div class="row d-flex justify-content-center">

      <div class="col-sm-6">

        <div class="card">

          <div class="modal-body pb-5">

            <div class="row">

              <div class="col-md-12">

                <?php echo form_open_multipart('leaves/update_leave/' . $LEAVE->id); ?>

                <label class="">Assigned by</label>

                <select class="form-control" name="assigned_by" id="input_assigned_by" enabled>

                  <?php foreach ($EMPLOYEES as $employee) { 
                     $name = $employee->col_empl_cmid . '-' . $employee->col_last_name;
                     if($employee->col_suffix)$name = $name.' '.$employee->col_suffix;
                     if($employee->col_frst_name)$name = $name.', '.$employee->col_frst_name;
                     if($employee->col_midl_name)$name = $name.' '.$employee->col_midl_name[0].'.';
                    ?>

                    <option value='<?= $employee->id ?>' <?= $LEAVE->assigned_by == $employee->id ? 'selected' : '' ?>>

                      <?= $name
                      // $employee->col_empl_cmid . '-' . $employee->col_last_name . ' ' . $employee->col_frst_name . ', ' . $employee->col_midl_name
                       ?>

                    </option>

                  <?php } ?>

                </select>

                <label class="">Employee</label>

                <select class="form-control" name="empl_id" id="input_empl_id" enabled>

                  <?php foreach ($EMPLOYEES as $employee) { 
                      $name = $employee->col_empl_cmid . '-' . $employee->col_last_name;
                      if($employee->col_suffix)$name = $name.' '.$employee->col_suffix;
                      if($employee->col_frst_name)$name = $name.', '.$employee->col_frst_name;
                      if($employee->col_midl_name)$name = $name.' '.$employee->col_midl_name[0].'.';
                    ?>

                    <option value='<?= $employee->id ?>' <?= $LEAVE->empl_id == $employee->id ? 'selected' : '' ?>>

                      <?= $name
                      //  $employee->col_empl_cmid . '-' . $employee->col_last_name . ' ' . $employee->col_frst_name . ', ' . $employee->col_midl_name 
                       ?>

                    </option>

                  <?php } ?>

                </select>



                <label class="">Type</label>

                <div class="form-group">

                  <select class="form-control" name="type" id="input_type" enabled>

                    <?php foreach ($LEAVE_TYPES as $leave_type) { ?>

                      <option value="<?= $leave_type->id ?>" <?= $LEAVE->type == $leave_type->id ? 'selected' : '' ?>><?= $leave_type->name ?></option>

                    <?php } ?>

                  </select>

                </div>

                <div class="form-group">

                  <label class="" for="input_leave_date">Leave Date</label>

                  <input type="date" class="form-control" name="leave_date" id="input_leave_date" enabled value="<?= $LEAVE->leave_date ?>">

                </div>

                <div class="form-group">

                  <label class="" for="input_duration">Leave Duration (Hours)</label>

                  <input type="number" min="0" class="form-control" name="duration" id="input_duration" enabled value="<?= $LEAVE->duration ?>">

                </div>

                <label class="">Status</label>

                <div class="form-group">

                  <input type="hidden" name="status" value="<?= $LEAVE->status ?>" />

                  <select class="form-control" id="input_status" disabled>

                    <option selected><?= $LEAVE->status ?></option>

                  </select>

                </div>

                <div class="form-group">

                  <label class="" for="input_remarks">Remarks</label>

                  <textarea name="remarks" class="form-control" id="input_remarks" rows="4" cols="50" enabled><?= $LEAVE->remarks ?></textarea>

                </div>

                <div class="form-group">

                  <label class="" for="input_attachment">Attachment</label>

                  <!-- <input type="file" class="form-control" name="input_attachment" id="input_attachment" enabled value= > -->

                  <!-- <input type="file" class="form-control" name="input_attachment" id="input_attachment"  enabledstyle="display:none;"/> -->

                  <input type="text" class="form-control" name="attachment" id="input_attachment" value="" enabled hidden value="<?= $LEAVE->attachment ?>" />

                  <br><a href="<?= base_url('assets_user/files/leaves/' . $LEAVE->attachment) ?>" download> </a>

                </div>

                <div class="mr-2" style="float: right !important">

                  <button type="submit" class="btn technos-button-blue shadow-none rounded">Submit</button>

                  <!--<a id="btn_edit" class="btn technos-button-blue shadow-none rounded" ;> Submit</a>-->

                </div>

              </div>



            </div>



          </div>

        </div>

      </div>

    </div>

  </div>

</div>