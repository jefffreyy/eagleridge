<?php $this->load->view('templates/css_link'); ?>
<head>

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
                <h2><a href="<?= base_url('teams/apply_overtimes') ?>"><img style="width: 32px; height: 32px; " class="mb-1" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="requestForm" style="width:100%">
                                <!-- <?php echo form_open('requests/add_overtime'); ?> -->
                                
                                <!-- <form action="<?= base_url('overtimes/add_overtime') ?>" method='post'> -->
                                <!-- <form action="" method='post'> -->
                                <div class="form-group">
                                        <!-- <label>Available Overtime</label>
                                        <p class="p-0 p-2 m-0 rounded d-flex justify-content-between" id="available_ot"></p> -->
                                        <input type="hidden" id="available_ot2" value="">
                                    </div>

                                    <div class="form-group">
                                        <label class="">Employee</label>
                                        <select class="form-control custom_selection" name="empl_id" id="input_employee_id">
                                            <?php foreach ($EMPLOYEES as $employee) {
                                                $name = $employee->col_empl_cmid . '-' . $employee->col_last_name;
                                                if (!empty($employee->col_suffix)) $name = $name . ' ' . $employee->col_suffix;
                                                if (!empty($employee->col_frst_name)) $name = $name . ', ' . $employee->col_frst_name;
                                                if (!empty($employee->col_midl_name)) $name = $name . ' ' . $employee->col_midl_name[0];
                                            ?>
                                                <option value="<?= $employee->id ?>">
                                                    <?= $name
                                                    // $employee->col_empl_cmid.'-'.$employee->col_last_name.' '.$employee->col_frst_name
                                                    ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <?php
                                    $disable_overtime_hours = isset($disable_overtime_hours) ? $disable_overtime_hours : '0';
                                    ?>
                                    <div class="form-group">
                                        <label class="required" for="input_date_ot">Overtime Date</label>
                                        <input type="date" class="form-control" name="date_ot" id="input_date_ot" value="<?= date('Y-m-d') ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Date Type</label>
                                        <input type="text" class="form-control" name="type" id="date_type" value="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="required">Shift Type</label>
                                        <!-- <input type="text" id="shift_type" class="form-control" value="" disabled> -->
                                        <p class="p-0 p-2 m-0 bg-light rounded d-flex justify-content-between" id="shift_type"><span>No shift assign</span></p>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                        <div class="col-md-6">
                                            <label >Actual Time In</label>
                                            <p class="p-0 p-2 m-0 bg-light rounded d-flex justify-content-between" id="actual_time_in"></p>
                                         </div>
                                         <div class="col-md-6">
                                            <label >Actual Time Out</label>
                                            <p class="p-0 p-2 m-0 bg-light rounded d-flex justify-content-between" id="actual_time_out"></p>
                                         </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="">
                                            <label >Night Differential Overtime</label>
                                            <input type="text" class="form-control" name="ndot" id="night_differential" value="" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="required d-block " for="input_time_out">Time Range</label>
                                        <div class="input-group">
                                            <input type="text" name="time_out" class="form-control" id="time-range" placeholder="Select time range">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-sm btn-primary rounded-right " id="clear-button"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="" />&nbsp;Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="required" for="input_hours">Overtime Hours</label>
                                        <input type="number" class="form-control" name="hours" id="input_hours" value="0" min="0" step="0.5" required 
                                        <?php if ($disable_overtime_hours == '1') echo 'readonly'; ?>>
                                    </div>

                                    <div class="form-group">
                                        <label class="required" for="input_early_ot">Early OT</label>
                                        <input type="number" class="form-control" name="early_ot" id="input_early_ot" value="0" min="0" step="0.5" required 
                                        <?php if ($disable_overtime_hours == '1') echo 'readonly'; ?>>
                                    </div>

                                    <div class="form-group">
                                        <label class="" for="input_reason">Reason</label>
                                        <textarea name="reason" class="form-control" id="reason" rows="4" cols="50" enabled=""></textarea>
                                    </div>
                                    <input type='hidden' value='Pending 1' name='status' />
                                    <div class="mr-2" style="float: right !important">
                                        <button type='button' onclick="submitForm()" class="btn technos-button-blue shadow-none rounded " ;="">
                                            Submit</button>
                                    </div>
                                </form>
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
    <!-- <script>
        Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>', '', 'success')
    </script> -->
    <script>
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success!',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('SUCC'); ?>'
        })
    </script>
<?php
}
?>
<?php
if ($this->session->flashdata('ERR')) {
?>
    <!-- <script>
        Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>',
            '',
            'error'
        )
    </script> -->
    <script>
        $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('ERR'); ?>'
        })
    </script>
<?php
}
?>
<!-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> -->
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
    // document.getElementById('input_hours').addEventListener('input', function() {
    //     var inputValue = parseFloat(this.value);
    //     if (isNaN(inputValue) || inputValue < 0.5 || inputValue > 24) {
    //         this.setCustomValidity('Invalid input for overtime hours.');
    //         this.classList.add('is-invalid');
    //     } else {
    //         this.setCustomValidity('');
    //         this.classList.remove('is-invalid');
    //     }
    // });
</script>
<script>
    $(document).ready(function() {
        $('.custom_selection').select2();
        
        let date = ''; // Initialize the date variable outside the event handler
        $('#input_date_ot, #input_employee_id').on('change', function() {
        
            let empl_id = $('#input_employee_id').val();
            date = $('#input_date_ot').val(); // Update the global 'date' variable
            let formatted_date = moment(date);
            // console.log(formatted_date.format('MM/DD/YYYY'));
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

        function ot_value(){
            let empl_id = $('#input_employee_id').val();
            let ot_date = $('#input_date_ot').val(); // Update the global 'date' variable

            $.post("<?= base_url('overtimes/get_attendance_record') ?>", {
                'empl': empl_id,
                'date': ot_date
            },function(res) {
                // console.log(res)
                if (res){
                  
                let timeIn = res.attendance.time_in;
                let timeOut = res.attendance.time_out;
                let shiftStart = res.shift.time_regular_start;
                let shiftEnd = res.shift.time_regular_end;

                let overtime_hours = res.overtime_hours;
                let ndot = res.ndot;

                // Convert times to Date objects
                let timeInDate = new Date(`1970-01-01T${timeIn}Z`);
                let timeOutDate = new Date(`1970-01-01T${timeOut}Z`);
                let shiftStartDate = new Date(`1970-01-01T${shiftStart}Z`);
                let shiftEndDate = new Date(`1970-01-01T${shiftEnd}Z`);

                // Calculate differences in milliseconds
                let attendanceDuration = timeOutDate - timeInDate;
                let shiftDuration = shiftEndDate - shiftStartDate;

                let startDiff = timeInDate - shiftStartDate; 
                let endDiff = timeOutDate - shiftEndDate;

                // Function to format hours and minutes as HH:mm
                function formatTimeDifference(duration) {
                    let hours = Math.floor((duration % 86400000) / 3600000);
                    let minutes = Math.floor((duration % 3600000) / 60000);
                    return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
                }

                let attendanceFormatted = formatTimeDifference(attendanceDuration);
                let shiftFormatted = formatTimeDifference(shiftDuration);
                let startDiffFormatted = formatTimeDifference(startDiff);
                let endDiffFormatted = formatTimeDifference(endDiff);

                // Function to convert time difference to decimal hours
                function convertToDecimalHours(duration) {
                    let hours = Math.floor((duration % 86400000) / 3600000);
                    let minutes = Math.floor((duration % 3600000) / 60000);
                    return hours + (minutes / 60); // Convert minutes to a fraction of an hour
                }

                let attendanceDecimal = convertToDecimalHours(attendanceDuration);
                let shiftDecimal = convertToDecimalHours(shiftDuration);
                let startDiffDecimal = convertToDecimalHours(startDiff);
                let endDiffDecimal = convertToDecimalHours(endDiff);

                // console.log(`Attendance Duration: ${attendanceDecimal.toFixed(2)} hours`);
                // console.log(`Shift Duration: ${shiftDecimal.toFixed(2)} hours`);
                // console.log(`Start Difference: ${startDiffDecimal.toFixed(2)} hours`);
                // console.log(`End Difference: ${endDiffDecimal.toFixed(2)} hours`);
                                
                // console.log(`Attendance Duration: ${attendanceFormatted}`);
                // console.log(`Shift Duration: ${shiftFormatted}`);
                // console.log(`Start Difference: ${startDiffFormatted}`);
                // console.log(`End Difference: ${endDiffFormatted}`);

                // let html = `<h6>Available Overtime: ${endDiffFormatted}</h6>`;
                let html = `<h6>Available Overtime:  ${endDiffDecimal.toFixed(2)} hours</h6>`;
                $('#available_ot').html(html)
                // $('#available_ot2').val(endDiffDecimal.toFixed(2));
                $('#available_ot2').val(overtime_hours);
                
                $('#actual_time_in').html(`<span>${timeIn}</span>`);
                $('#actual_time_out').html(`<span>${timeOut}</span>`);
                $('#night_differential').val(ndot);
                $('#overtime').val(overtime_hours);
                
                }

                if (res.attendance.length <= 0) {
                    $('#available_ot').html(`<h6>Available Overtime: 00:00</h6>`);
                    $('#actual_time_in').html(`<span> 00:00 </span>`);
                    $('#actual_time_out').html(`<span> 00:00 </span>`);
                    $('#overtime').val('00.00');
                    $('#night_differential').val('00.00');
                }
            }, 'json');
        }
       
        ot_value();
        $('#input_date_ot, #input_employee_id').on('change', function() {
            ot_value();
        });

    
        // get the shift type when  page is loaded
        function fetchShiftType() {
            let empl_id = $('#input_employee_id').val();
            date = $('#input_date_ot').val(); // Update the global 'date' variable
            let formatted_date = moment(date);
            // console.log(formatted_date.format('MM/DD/YYYY'));
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
                    $('#shift_type').html(`<span>No shift assign123</span>`);
                }
            }, 'json');
        }
        // Call the function on page load
        fetchShiftType();
        // Bind the function to the change event of input elements
        $('#input_date_ot, #input_employee_id').on('change', function() {
            fetchShiftType();
        });
        // function fetchStdDepartment() {
        //     let empl_id = $('#input_employee_id').val();
        //     $.post("<?= base_url('overtimes/get_department_min_hour') ?>", {
        //         'empl' : empl_id
        //     }, function(result) {
        //         let minHour = result.min_hours;
        //            // Update min and step attributes based on minHour value
        //            $('#input_hours').attr('value', (minHour) ? minHour : "");
        //             $('#input_hours').attr('min', (minHour == 1) ? 1 : 0.5);
        //             $('#input_hours').attr('step', (minHour == 1) ? '' : 0.5);
        //     }, 'json');
        // }
        // fetchStdDepartment();
        // $('#input_employee_id').on('change', function() {
        //     fetchStdDepartment();
        // });
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
        function calculateOvertime(start, end) {
            const duration = moment.duration(end.diff(start));
            let overtimeHours = duration.asHours();
            if (overtimeHours < 0) {
                overtimeHours += 24;
            }
            return overtimeHours;
        }
        //time range => overtime hours
        $('#time-range').on('apply.daterangepicker', function(ev, picker) {
            const start = picker.startDate;
            const end = picker.endDate;
            const overtimeHours = calculateOvertime(start, end);
            $('#input_hours').val(overtimeHours);
        });
        $('#clear-button').on('click', function() {
            $('#time-range').data('daterangepicker').setStartDate(moment().startOf('hour'));
            $('#time-range').data('daterangepicker').setEndDate(moment().startOf('hour').add(1, 'hour'));
            $('#input_hours').val('1');
        });

    });
</script>
<!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->
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
                    // console.log(response);
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

<script>

    function validateForm() {

        // let available_ot = document.getElementById('available_ot2').value;

        let hours = document.getElementById('input_hours').value;
        let early_ot = document.getElementById('input_early_ot').value;
        

        // if(available_ot == 'NaN' && Number(available_ot) < Number(hours)){

        if(Number(early_ot) <= 0 && Number(hours) <= 0){
            // console.log(available_ot);
            $(document).Toasts('create', {
              class: 'bg-warning toast_width',
              title: 'Warning!',
              subtitle: 'close',
              body: 'Please Insert overtime'
          })
          return false; // Prevents form submission
        }

        return true;

    }
</script>

<script>
    var baseUrl = '<?= base_url() ?>';

    function submitForm() {

        let hours = document.getElementById('input_hours').value;
        let early_ot = document.getElementById('input_early_ot').value;

        // if(available_ot == 'NaN' && Number(available_ot) < Number(hours)){
        if(Number(early_ot) <= 0 && Number(hours) <= 0){
            $(document).Toasts('create', {
              class: 'bg-warning toast_width',
              title: 'Warning!',
              subtitle: 'close',
              body: 'Please Insert overtime'
          })
          return; // Prevents form submission
        }



        const requestData = new FormData(document.getElementById('requestForm'));
        const apiUrl = baseUrl + 'selfservices/add_request_overtime';
        fetch(apiUrl, {
                method: 'POST',
                body: requestData
            })
            .then(response => response.json())
            .then(data => {
           
                if (data.messageError) {
                    $(document).Toasts('create', {
                        class: 'bg-warning toast_width',
                        title: 'Warning',
                        subtitle: 'close',
                        body: data.messageError
                    })
                } else {
                    window.location.href = '<?= base_url() ?>teams/apply_overtimes';
                }
            })
            .catch(error => {
                $(document).Toasts('create', {
                        class: 'bg-warning toast_width',
                        title: 'Warning',
                        subtitle: 'close',
                        body: 'Failed to submit. Please check empty fields'
                    })
                console.error('Error:', error);
            });
    }
</script>