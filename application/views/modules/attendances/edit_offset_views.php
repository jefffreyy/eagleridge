<?php $this->load->view('templates/css_link'); ?>

<style>
    .calendar-table {

        display: none !important;

    }
</style>

<div class="content-wrapper">
  <div class='row'>
    <div class='col-md-8 ml-4 mt-3'>
      <h2><a href="<?= base_url() . 'attendances/offset_lists'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
    </div>
  </div>
  <div class="container-fluid px-4">

    <nav aria-label="breadcrumb">

      <ol class="breadcrumb">

        <li class="breadcrumb-item">

          <a href="<?= base_url('attendances') ?>">Offsets</a>

        </li>

        <li class="breadcrumb-item">

          <a href="<?= base_url('attendances/offset_lists') ?>">Offset Requests</a>

        </li>

        <li class="breadcrumb-item active" aria-current="page">Edit&nbsp;Offset Requests </li>

      </ol>

    </nav>

    <div class="row d-flex justify-content-center">

      <div class="col-sm-6">

        <div class="card">

          <div class="modal-body pb-5">

            <div class="row">

              <div class="col-md-12">

                <?php echo form_open_multipart('attendances/update_offset/' . $OFFSET->id); ?>

                <label class="">Assigned by</label>

                <select class="form-control" name="assigned_by" id="input_assigned_by" enabled>

                  <?php foreach ($EMPLOYEES as $employee) { 
                     $name = $employee->col_empl_cmid . '-' . $employee->col_last_name;
                     if($employee->col_suffix)$name = $name.' '.$employee->col_suffix;
                     if($employee->col_frst_name)$name = $name.', '.$employee->col_frst_name;
                     if($employee->col_midl_name)$name = $name.' '.$employee->col_midl_name[0].'.';
                    ?>

                    <option value='<?= $employee->id ?>' <?= $OFFSET->assigned_by == $employee->id ? 'selected' : '' ?>>

                      <?= $name
                      // $employee->col_empl_cmid . '-' . $employee->col_last_name . ' ' . $employee->col_frst_name . ', ' . $employee->col_midl_name
                       ?>

                    </option>

                  <?php } ?>

                </select>

                <div class="form-group">
                  <label class="">Employee</label>

                  <select class="form-control" name="empl_id" id="input_empl_id" enabled>

                    <?php foreach ($EMPLOYEES as $employee) { 
                        $name = $employee->col_empl_cmid . '-' . $employee->col_last_name;
                        if($employee->col_suffix)$name = $name.' '.$employee->col_suffix;
                        if($employee->col_frst_name)$name = $name.', '.$employee->col_frst_name;
                        if($employee->col_midl_name)$name = $name.' '.$employee->col_midl_name[0].'.';
                      ?>

                      <option value='<?= $employee->id ?>' <?= $OFFSET->empl_id == $employee->id ? 'selected' : '' ?>>

                        <?= $name
                        //  $employee->col_empl_cmid . '-' . $employee->col_last_name . ' ' . $employee->col_frst_name . ', ' . $employee->col_midl_name 
                        ?>

                      </option>

                    <?php } ?>

                  </select>
                </div>


                <!-- <label class="">Type</label>

                <div class="form-group">

                  <select class="form-control" name="type" id="input_type" enabled>

                    <?php foreach ($LEAVE_TYPES as $leave_type) { ?>

                      <option value="<?= $leave_type->id ?>" <?= $OFFSET->type == $leave_type->id ? 'selected' : '' ?>><?= $leave_type->name ?></option>

                    <?php } ?>

                  </select>

                </div> -->

                <div class="form-group">

                  <label class="" for="input_offset_date">Offset Date</label>

                  <input type="date" class="form-control" name="offset_date" id="input_offset_date" enabled value="<?= $OFFSET->offset_date ?>">

                </div>

                <div class="form-group">
                    <label class="required">Shift Type</label>
                    <p class="p-0 p-2 m-0 bg-light rounded d-flex justify-content-between" id="shift_type"><span>No shift assign</span></p>
                </div>

                <div class="form-group">
                    <label class="required d-block " for="time_range">Time Range</label>
                    <div class="input-group">
                        <input type="text" name="time_range" class="form-control" id="time_range" placeholder="Select time range">
                        <div class="input-group-prepend">
                            <button type="button" class="btn btn-sm btn-primary rounded-right " id="clear-button">Clear</button>
                        </div>
                    </div>
                </div>

                <div class="form-group">

                  <label class="" for="input_duration">Offset Duration (Hours)</label>

                  <input type="number" min="0" class="form-control" name="duration" id="input_duration" enabled value="<?= $OFFSET->duration ?>">

                </div>

                <label class="">Status</label>

                <div class="form-group">

                  <input type="hidden" name="status" value="<?= $OFFSET->status ?>" />

                  <select class="form-control" id="input_status" disabled>

                    <option selected><?= $OFFSET->status ?></option>

                  </select>

                </div>

                <div class="form-group">

                  <label class="" for="input_remarks">Reason</label>

                  <textarea name="remarks" class="form-control" id="input_remarks" rows="4" cols="50" enabled><?= $OFFSET->reason ?></textarea>

                </div>

                <!-- <div class="form-group">

                  <label class="" for="input_attachment">Attachment</label>

                  <input type="text" class="form-control" name="attachment" id="input_attachment" value="" enabled hidden value="<?= $OFFSET->attachment ?>" />

                  <br><a href="<?= base_url('assets_user/files/offsets/' . $OFFSET->attachment) ?>" download> </a>

                </div> -->

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

<script>
    document.getElementById('input_duration').addEventListener('input', function() {
        var inputValue = parseFloat(this.value); 
            if (isNaN(inputValue) || inputValue < 1 || inputValue > 99) {
                this.setCustomValidity('Invalid input for offset duration.');
                this.classList.add('is-invalid'); 
            } else {
                this.setCustomValidity(''); 
                this.classList.remove('is-invalid'); 
            }
    });
</script>

<script>
    $(document).ready(function() {
        // $('.custom_selection').select2();
        function handleChange() {
            let empl_id = $('#input_empl_id').val();
            let date = $('#input_offset_date').val();
            let fomated_date = moment(date);
            console.log(fomated_date.format('MM/DD/YYYY'));
            $.post("<?= base_url('overtimes/get_shift_type') ?>", {
                'empl': empl_id,
                'date': date
            }, function(res) {
                console.log(res)
                if (res) {
                    let name = res.name ? res.name : '';
                    let start_time = res.time_regular_start ? res.time_regular_start : '';
                    let end_time = res.time_regular_end ? res.time_regular_end : '';
                    let html_data = `<span>${name}</span><span>${start_time} To ${end_time}</span>`;
                    $('#shift_type').html(html_data);
                }
                if (res.length <= 0) {
                    $('#shift_type').html(`<span>No shift assign</span>`)
                }
            }, 'json')
        }
        $('#input_offset_date,#input_empl_id').on('change', handleChange)
        handleChange();
        $('#time_range').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            showCalendar: false,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(1, 'hour'),
            locale: {
                format: 'HH:mm:ss'
            }
        });
        $('#clear-button').on('click', function() {
            $('#time_range').data('daterangepicker').setStartDate(moment().startOf('hour'));
            $('#time_range').data('daterangepicker').setEndDate(moment().startOf('hour').add(1, 'hour'));
            $('#selected-range').text('Time range cleared');
        });

    })
</script>