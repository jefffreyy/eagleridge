<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper">
  <div class="container-fluid p-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="https://dev-env.eyebox.app/leaves">Leaves</a>
        </li>
        <li class="breadcrumb-item">
          <a href="https://dev-env.eyebox.app/leaves/leave_lists">Leave Requests</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">View&nbsp;Leave Requests </li>
      </ol>
    </nav>
    <div class="row d-flex justify-content-center">
      <div class="col-sm-6">
        <div class="card">
          <div class="modal-body pb-5">
            <div class="row">

              <div class="col-md-12">
                <div class="form-group">
                  <label class="" for="input_id">Leave ID</label>
                  <input type="text" class="form-control" name="input_id" id="input_id" disabled value="<?='LEA'. str_pad($LEAVE->id, 5, '0', STR_PAD_LEFT)?>">
                </div>
                <div class="form-group">
                  <label class="" for="input_create_date">Create Date</label>
                  <input type="datetime-local" class="form-control" name="input_create_date" id="input_create_date"
                    disabled value="<?=$LEAVE->create_date?>">
                </div>
                <div class="form-group">
                  <label class="" for="input_edit_date">Edit Date</label>
                  <input type="datetime-local" class="form-control" name="input_edit_date" id="input_edit_date" disabled
                    value="<?=$LEAVE->edit_date?>">
                </div>
                <label class="">Last Edited By</label>
                <select class="form-control" name="input_edit_user" id="input_edit_user" disabled>
                </select>

                <label class="">Assigned by</label>
                <select class="form-control" name="input_assigned_by" id="input_assigned_by" disabled>
<?php foreach($EMPLOYEES as $employee) { ?>
    <?php if($LEAVE->assigned_by==$employee->id){ ?>
                    <option value='<?=$employee->id?>'>
                        <?=$employee->col_empl_cmid.'-'.$employee->col_last_name.' '.$employee->col_frst_name.', '.$employee->col_midl_name?>
                    </option>
    <?php } ?>
<?php } ?>
                </select>

                <label class="">Employee</label>
                <select class="form-control" name="input_empl_id" id="input_empl_id" disabled>
<?php foreach($EMPLOYEES as $employee) { ?>
    <?php if($LEAVE->empl_id==$employee->id){ ?>
                    <option value='<?=$employee->id?>'>
                        <?=$employee->col_empl_cmid.'-'.$employee->col_last_name.' '.$employee->col_frst_name.', '.$employee->col_midl_name?>
                    </option>
    <?php } ?>
<?php } ?>
                </select>

                <label class="">Type</label>
                <div class="form-group">
                  <select class="form-control" name="input_type" id="input_type" disabled>
<?php foreach($LEAVE_TYPES as $leave_type) { ?>
                    <option value="<?=$leave_type->id?>" <?=$LEAVE->type==$leave_type->id?'selected' :'' ?>><?=$leave_type->name?></option>
<?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="" for="input_leave_date">Leave Date</label>
                  <input type="date" class="form-control" name="input_leave_date" id="input_leave_date" disabled
                    value="<?=$LEAVE->leave_date?>">
                </div>
                <div class="form-group">
                  <label class="" for="input_duration">Leave Duration (Hours)</label>
                  <input type="number" class="form-control" name="input_duration" id="input_duration" disabled value="<?=$LEAVE->duration?>">
                </div>
                <label class="">Status</label>
                <div class="form-group">
                  <select class="form-control" name="input_status" id="input_status" disabled>
                    <option selected><?=$LEAVE->status?></option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="" for="input_remarks">Remarks</label>
                  <textarea name="remarks" class="form-control" id="input_remarks" rows="4" cols="50"
                    disabled><?=$LEAVE->remarks?></textarea>
                </div>
                <div class="form-group">
                  <label class="" for="input_attachment">Attachment</label>
                  <!-- <input type="file" class="form-control" name="input_attachment" id="input_attachment" disabled value= > -->
                  <!-- <input type="file" class="form-control" name="input_attachment" id="input_attachment"  disabledstyle="display:none;"/> -->
                  <br><a href="<?=base_url('assets_user/files/leaves/'.$LEAVE->attachment)?>"></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>