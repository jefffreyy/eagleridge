<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper" style="min-height: 692.889px;">

    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="<?= base_url() . 'attendances/time_adjustment_lists'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
        </div>
    </div>

    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>attendances">Attendance</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>attendances/time_adjustment_lists">Time Adjustment List</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">Add&nbsp;Time Adjustment List </li>
            </ol>
        </nav>

        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_open_multipart('attendances/add_new_time_adjustments'); ?>
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
                                    <input type="date" required class="form-control" name="date_adjustment" id="input_date_adjustment" enabled="" value="<?php echo date('Y-m-d'); ?>">
                                </div>

                                <label class="">Shift Type</label>
                                <div class="form-group">
                                    <select class="form-control" name="shift_type" id="input_shift_type" enabled="">
                                        <!-- <?php foreach ($C_SHIFT_TYPES as $type) { ?>
                                            <option value=<?= $type->id ?>> <?= $type->name ?> </option>
                                        <?php } ?> -->
                                    </select>
                                </div>

                                <label class="">Shift Time In</label>
                                <div class="form-group">
                                    <select class="form-control" name="shift_type_in" id="input_shift_type_in">
                                    </select>
                                </div>

                                <label class="">Shift Time Out</label>
                                <div class="form-group">
                                    <select class="form-control" name="shift_type_out" id="input_shift_type_out">
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

<script>
    $(document).ready(function() {
        var url = '<?= base_url() ?>';

        $('#input_employee_id').change(function() {
            var empl_id = $(this).val();
            var adjustmentDate = $('#input_date_adjustment').val();

            const combinedData = {
                empl_id: empl_id,
                adjustmentDate: adjustmentDate,
            }

            fetch(url + 'attendances/GET_SHIFT_ASSIGN', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(combinedData)
            })
            .then(response => response.json())
            .then(result => {
                console.log(result);

                // Update Shift Type
                var shiftTypeSelect = document.getElementById('input_shift_type');
                shiftTypeSelect.innerHTML = '';
                var shiftTypeOption = document.createElement('option');
                shiftTypeOption.value = result.id;
                shiftTypeOption.text = result.name;
                shiftTypeSelect.appendChild(shiftTypeOption);

                 // Update Shift Type In
                var shiftTypeInSelect = document.getElementById('input_shift_type_in');
                shiftTypeInSelect.innerHTML = '';
                var shiftTypeInOption = document.createElement('option');
                shiftTypeInOption.value = result.time_regular_start;
                shiftTypeInOption.text = result.time_regular_start;
                shiftTypeInSelect.appendChild(shiftTypeInOption);

                // Update Shift Type Out
                var shiftTypeOutSelect = document.getElementById('input_shift_type_out');
                shiftTypeOutSelect.innerHTML = '';
                var shiftTypeOutOption = document.createElement('option');
                shiftTypeOutOption.value = result.time_regular_end;
                shiftTypeOutOption.text = result.time_regular_end;
                shiftTypeOutSelect.appendChild(shiftTypeOutOption);

                var timeIn1Input = document.getElementById('input_time_in_1');
                timeIn1Input.innerHTML = '';
                timeIn1Input.value = result.time_regular_start;

                var timeOut1Input = document.getElementById('input_time_out_1');
                timeOut1Input.innerHTML = '';
                timeOut1Input.value = result.time_regular_end;

                var defaultTimeIn2Input = document.getElementById('input_time_in_2');
                defaultTimeIn2Input.innerHTML = '';
                defaultTimeIn2Input.value = result.time_break_start;

                var defaultTimeOut2Input = document.getElementById('input_time_out_2');
                defaultTimeOut2Input.innerHTML = '';
                defaultTimeOut2Input.value = result.time_break_end;


            })
            .catch(error => {
                console.error('Data update error:', error);
            });
        })


//         var defaultShiftType = <?= json_encode($C_SHIFT_TYPES[0]) ?>;
// // console.log(defaultShiftType)
//         // Populate Shift Type In with default value
//         $('#input_shift_type_in').append($('<option>', {
//             value: defaultShiftType.time_regular_start,
//             text: defaultShiftType.time_regular_start
//         }));

//         // Populate Shift Type Out with default value
//         $('#input_shift_type_out').append($('<option>', {
//             value: defaultShiftType.time_regular_end,
//             text: defaultShiftType.time_regular_end
//         }));

//         var defaultTimeIn1Input = document.getElementById('input_time_in_1');
//         defaultTimeIn1Input.value = defaultShiftType.time_regular_start;

//         var defaultTimeOut1Input = document.getElementById('input_time_out_1');
//         defaultTimeOut1Input.value = defaultShiftType.time_regular_end;

//         var defaultTimeIn2Input = document.getElementById('input_time_in_2');
//         defaultTimeIn2Input.value = defaultShiftType.time_break_start;

//         var defaultTimeOut2Input = document.getElementById('input_time_out_2');
//         defaultTimeOut2Input.value = defaultShiftType.time_break_end;


//         $('#input_shift_type').change(function() {
//             var selectedShiftType = $(this).val();
//             var shiftType = <?= json_encode($C_SHIFT_TYPES) ?>.find(function(type) {
//                 return type.id == selectedShiftType;
//             });

//             if (shiftType) {
//                 // $('#input_shift_type_in').prop('disabled', false);
//                 // $('#input_shift_type_out').prop('disabled', false);

//                 $('#input_shift_type_in').empty().append($('<option>', {
//                     value: shiftType.time_regular_start,
//                     text: shiftType.time_regular_start
//                 }));

//                 $('#input_shift_type_out').empty().append($('<option>', {
//                     value: shiftType.time_regular_end,
//                     text: shiftType.time_regular_end
//                 }));

//             }
//             // else {
//             //     $('#input_shift_type_in').prop('disabled', true);
//             //     $('#input_shift_type_out').prop('disabled', true);
//             // }
//         });
    });
</script>