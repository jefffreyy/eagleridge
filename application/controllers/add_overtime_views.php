<?php $this->load->view('templates/css_link'); ?>

<head>
    <!-- Include Bootstrap CSS -->
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->

    <!-- Include Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- Include DateRangePicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

    <!-- Include DateRangePicker JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <style>
        .calendar-table {
            display: none !important;
        }
    </style>
</head>
<div class="content-wrapper" style="min-height: 624px;">

    <div class="container-fluid px-4">

        <div class='row mt-3'>

            <div class='col-md-8'>

                <h2><a href="<?= base_url('overtimes/overtime') ?>"><img style="width: 32px; height: 32px; " class="mb-1" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>

            </div>

        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-md-12">

                                <!-- <?php echo form_open('overtimes/add_overtime'); ?> -->
                                <form action="<?= base_url('overtimes/add_overtime') ?>" method='post'>
                                    <input type='hidden' value="<?= $this->session->userdata('SESS_USER_ID') ?>" name='assigned_by' />
                                    <input type='hidden' value="<?= $this->session->userdata('SESS_USER_ID') ?>" id="input_employee_id" name='empl_id' />

                                    <div class="form-group">
                                        <label class="">Employee</label>

                                        <select class="form-control custom_selection" name="empl_id" id="input_employee_id">

                                            <?php foreach ($C_EMPLOYEES as $employee) {
                                                $name = $employee->col_empl_cmid . '-' . $employee->col_last_name;
                                                if (!empty($employee->col_suffix)) $name = $name . ' ' . $employee->col_suffix;
                                                if (!empty($employee->col_frst_name)) $name = $name . ', ' . $employee->col_frst_name;
                                                if (!empty($employee->col_midl_name)) $name = $name . ' ' . $employee->col_midl_name[0] . '.';
                                            ?>

                                                <option value="<?= $employee->id ?>">
                                                    <?= $name
                                                    // $employee->col_empl_cmid.'-'.$employee->col_last_name.' '.$employee->col_frst_name
                                                    ?></option>

                                            <?php } ?>



                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="required" for="input_date_ot">Overtime Date</label>
                                        <input type="date" class="form-control" name="date_ot" id="input_date_ot" value="<?= date('Y-m-d') ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="required" for="date_type">Date Type</label>
                                        <input type="text" class="form-control" name="date_type" id="date_type" value="" required>
                                    </div>


                                    <div class="form-group">

                                        <label class="required">Shift Type</label>

                                        <!-- <input type="text" id="shift_type" class="form-control" value="" disabled> -->
                                        <p class="p-0 p-2 m-0 bg-light rounded d-flex justify-content-between" id="shift_type"><span>No shift assign</span></p>

                                    </div>
                                    <div class="form-group">
                                        <label class="required d-block " for="input_time_out">Time Range</label>
                                        <div class="input-group">
                                            <input type="text" name="time_out" class="form-control" id="time-range" placeholder="Select time range">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-sm btn-primary rounded-right " id="clear-button">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="required" for="input_hours">Overtime Hours</label>
                                        <input type="number" required class="form-control " min="0" step="0.01" name="hours" id="input_hours" enabled="" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="" for="input_reason">Reason</label>
                                        <textarea name="reason" class="form-control" id="reason" rows="4" cols="50" enabled=""></textarea>
                                    </div>
                                    <input type='hidden' value='Pending 1' name='status' />

                                    <div class="mr-2" style="float: right !important">
                                        <button id="btn_add" type='submit' class="btn technos-button-blue shadow-none rounded " ;="">
                                            Submit</button>
                                    </div>
                                    <!-- </form> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- <div class="row d-flex justify-content-center">

            <div class="col-sm-6" data-select2-id="select2-data-10-n8rb">

                <div class="card" data-select2-id="select2-data-9-opfw">

                    <div class="modal-body pb-5" data-select2-id="select2-data-8-pzx8">

                        <div class="row" data-select2-id="select2-data-7-j021">

                            <div class="col-md-12" data-select2-id="select2-data-6-dmol">

                                <?php echo form_open('overtimes/add_overtime'); ?>

                                <label class="">Employee</label>

                                <select class="form-control custom_selection" name="empl_id" id="input_employee_id">

                                    <?php foreach ($C_EMPLOYEES as $employee) {
                                        $name = $employee->col_empl_cmid . '-' . $employee->col_last_name;
                                        if (!empty($employee->col_suffix)) $name = $name . ' ' . $employee->col_suffix;
                                        if (!empty($employee->col_frst_name)) $name = $name . ', ' . $employee->col_frst_name;
                                        if (!empty($employee->col_midl_name)) $name = $name . ' ' . $employee->col_midl_name[0] . '.';
                                    ?>

                                        <option value="<?= $employee->id ?>">
                                            <?= $name
                                            // $employee->col_empl_cmid.'-'.$employee->col_last_name.' '.$employee->col_frst_name
                                            ?></option>

                                    <?php } ?>



                                </select>





                                <div class="form-group mt-3">
                                    <label class="">Type</label>
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

                                    <label class="required" for="input_date_ot">OT</label>

                                    <input type="date" required class="form-control" name="date_ot" id="input_date_ot" enabled="">

                                </div>
                                <div class="form-group">

                                    <label class="required">Shift Type</label>

                                    <input type="text" id="shift_type" class="form-control" value="" disabled>
                                    <p class="p-0 p-2 m-0 bg-light rounded d-flex justify-content-between" id="shift_type"><span>No shift assign</span></p>

                                </div>
                                <div class="form-group">
                                    <label class="required d-block " for="input_time_out">Time Out Range</label>
                                    <div class="input-group">
                                        <input type="text" name="time_out" class="form-control" id="time-range" placeholder="Select time range">
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn btn-sm btn-primary rounded-right " id="clear-button">Clear</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">

                                   <label class="required" for="input_time_out">Time Out</label>

                                   <input type="time" required class="form-control" name="time_out" id="input_time_out"

                                       enabled="" value="">

                                </div>

                                <div class="form-group">

                                    <label class="required" for="input_hours">Overtime Hours</label>

                                    <input type="number" required class="form-control " min="0" name="hours" id="input_hours" enabled="" value="">

                                </div>

                                <div class="form-group">

                                    <label class="" for="input_reason">Reason</label>

                                    <textarea name="reason" class="form-control" id="input_reason" rows="4" cols="50" enabled=""></textarea>

                                </div>

                                <input type='hidden' name='status' value='Pending 1' />

                                <label class="">Status</label>

                                <div class="form-group">

                                   <select class="form-control" name="input_status" id="input_status" disabled="">

                                       <option>Pending 1</option>

                                       <option>Pending 2</option>

                                       <option>Pending 3</option>

                                       <option>Approved</option>

                                       <option>Rejected</option>

                                   </select>

                                </div>

                                <div class="form-group">

                                    <label class="" for="input_comment">Remarks</label>

                                    <textarea name="comment" class="form-control" id="input_comment" rows="4" cols="50" enabled=""></textarea>

                                </div>
                                <div class="mr-2" style="float: right !important">

                                    <button id="btn_add" class="btn technos-button-blue shadow-none rounded " ;="">

                                        Submit</button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div> -->

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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- <script>
    $(document).ready(function() {

        let date = '';

        $('.custom_selection').select2();
        $('#input_date_ot,#input_employee_id').on('change', function() {
            let empl_id = $('#input_employee_id').val();
            let date = $('#input_date_ot').val();
            let fomated_date = moment(date);
            console.log(fomated_date.format('MM/DD/YYYY'));
            $.post("<?= base_url('overtimes/get_shift_type') ?>", {
                'empl': empl_id,
                'date': date
            }, function(res) {
                console.log(res)
                // return;
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

        })
        //     $("#time-range").flatpickr({
        //     enableTime: true,
        //     dateFormat: "H:i",
        //     time_24hr: true,
        //     defaultDate:'2022-',
        //     mode: "range",
        //     onClose: function(selectedDates, dateStr, instance) {
        //         console.log(selectedDates)
        //       if (selectedDates.length === 2) {
        //         const startTime = selectedDates[0].toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        //         const endTime = selectedDates[1].toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        //         $("#selected-range").text(`Selected time range: ${startTime} - ${endTime}`);
        //       } else {
        //         $("#selected-range").text('Please select both start and end times.');
        //       }
        //     }
        //   });

    })
</script> -->

<script>
    $(document).ready(function() {
        let date = ''; // Initialize the date variable outside the event handler

        $('#input_date_ot, #input_employee_id').on('change', function() {
            let empl_id = $('#input_employee_id').val();
            date = $('#input_date_ot').val(); // Update the global 'date' variable
            let formatted_date = moment(date);
            console.log(formatted_date.format('MM/DD/YYYY'));

            $.post("<?= base_url('overtimes/get_shift_type') ?>", {
                'empl': empl_id,
                'date': date
            }, function(res) {
                if (res) {
                    let name = res.name ? res.name : '';
                    let start_time = res.time_regular_start ? res.time_regular_start : '';
                    let end_time = res.time_regular_end ? res.time_regular_end : '';
                    let html_data = `<span>${name}</span><span>${start_time} To ${end_time}</span>`;
                    $('#shift_type').html(html_data);
                }
                if (res.length <= 0) {
                    $('#shift_type').html(`<span>No shift assign</span>`);
                }
            }, 'json');
        });

        // get the shift type when  page is loaded
        function fetchShiftType() {
            let empl_id = $('#input_employee_id').val();
            date = $('#input_date_ot').val(); // Update the global 'date' variable
            let formatted_date = moment(date);
            console.log(formatted_date.format('MM/DD/YYYY'));

            $.post("<?= base_url('overtimes/get_shift_type') ?>", {
                'empl': empl_id,
                'date': date
            }, function(res) {
                if (res) {
                    let name = res.name ? res.name : '';
                    let start_time = res.time_regular_start ? res.time_regular_start : '';
                    let end_time = res.time_regular_end ? res.time_regular_end : '';
                    let html_data = `<span>${name}</span><span>${start_time} To ${end_time}</span>`;
                    $('#shift_type').html(html_data);
                }
                if (res.length <= 0) {
                    $('#shift_type').html(`<span>No shift assign</span>`);
                }
            }, 'json');
        }

        // Call the function on page load
        fetchShiftType();

        // Bind the function to the change event of input elements
        $('#input_date_ot, #input_employee_id').on('change', function() {
            fetchShiftType();
        });


        $('#time-range').daterangepicker({
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

            $('#time-range').data('daterangepicker').setStartDate(moment().startOf('hour'));
            $('#time-range').data('daterangepicker').setEndDate(moment().startOf('hour').add(1, 'hour'));
            $('#selected-range').text('Time range cleared');
        });

    })
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
      
        function updateDateType() {
            var selectedDate = $('#input_date_ot').val();

           
            $.ajax({
                url: '<?= base_url('overtimes/check_holiday') ?>', 
                method: 'POST',
                data: {
                    date: selectedDate
                },
                success: function(response) {
                    
                    var dateType = (response.isHoliday) ? response.holidayType : 'Regular Day';
                    $('#date_type').val(dateType);
                },
                error: function(error) {
                    console.error('Error checking holiday:', error);
                }
            });
        }

       
        $('#input_date_ot').on('input', updateDateType);

        
        updateDateType();
    });
</script>