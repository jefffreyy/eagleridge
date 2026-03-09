<?php $this->load->view('templates/css_link'); ?>
<!-- Include Moment.js -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> -->
<script src="<?= base_url('assets_system') ?>/_eyeboxroot/plugins/moment/moment.min.js"></script>
<!-- Include DateRangePicker CSS -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"> -->
<!-- Include DateRangePicker JavaScript -->
<!-- <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->
<style>
    .calendar-table {
        display: none !important;
    }
</style>
<div class="content-wrapper" style="min-height: 624px;">
    <div class="row">
        <div class="col-md-8 ml-4 mt-3">
            <h2><a onclick="afterRenderFunction()" href="<?= base_url('selfservices/my_offsets') ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
        </div>
    </div>
    <div class="container-fluid px-4">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_open('selfservices/add_new_offset'); ?>

                                <div class="form-group">
                                    <label class="required">Offset Type</label>
                                    <input type="text" class="form-control" name="offset_type" value="Acquire" readonly>
                                </div>

                                <div class="form-group">
                                    <label class="required" for="input_offset_date">Date</label>
                                    <input type="date" class="form-control" name="offset_date" id="input_offset_date" value="<?= date('Y-m-d') ?>" required onchange="fetchAttendanceRecord()">
                                </div>

                                <div class="form-group">
                                    <label class="required">Shift Type</label>
                                    <p class="p-0 p-2 m-0 bg-light rounded d-flex justify-content-between" id="shift_type"><span>No shift assigned</span></p>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="required">Actual Time In</label>
                                            <p class="p-0 p-2 m-0 bg-light rounded d-flex justify-content-between" id="actual_time_in_display"></p>
                                            <input type="hidden" name="actual_time_in" id="actual_time_in" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="required">Actual Time Out</label>
                                            <p class="p-0 p-2 m-0 bg-light rounded d-flex justify-content-between" id="actual_time_out_display"></p>
                                            <input type="hidden" name="actual_time_out" id="actual_time_out" required>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="required" for="input_duration">Offset Duration (Hours)</label>
                                    <input type="number" class="form-control " max="9.5" min="1" value="1" step="0.5" name="duration" id="input_duration" enabled="" value="" required>
                                    <!-- <div style="font-size: 14px">
                                        <p style="font-weight: 500">Balance: <span id="diplayBalanceAfter" style="font-weight:400">select valid date</span></p> 
                                    </div>     -->
                                </div>
                                <div class="form-group">
                                    <label class="required" for="input_reason">Reason</label>
                                    <textarea name="reason" class="form-control" id="remarks" rows="4" cols="50"
                                        enabled="" required></textarea>
                                </div>

                                <div class="mr-2" style="float: right !important">
                                    <button type='submit' onclick="return validateForm()" id="btn_add" class="btn btn-primary shadow-none rounded " ;="">
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

<script>
    $(document).ready(function() {
        $('#input_empl_id').select2();
    });
</script>

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
<script>
    document.getElementById('input_duration').addEventListener('input', function() {
        var inputValue = parseFloat(this.value);
        if (isNaN(inputValue) || inputValue < 0 || inputValue > 24) {
            this.setCustomValidity('Invalid input for offset duration.');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
        }
    });
</script>

<!-- <script>
    $(document).ready(function() {
        // $('.custom_selection').select2();
        function handleChange() {
            // let empl_id = $('#input_employee_id').val();
            var empl_id = <?php echo json_encode($userId); ?>;
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
        $('#input_offset_date,#input_employee_id').on('change', handleChange)
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
</script> -->

<script>
    $(document).ready(function() {
        fetchAttendanceRecord();
    });
</script>


<script>
    function fetchAttendanceRecord() {
        var date = $('#input_offset_date').val();
        var empl_id = <?= json_encode($this->session->userdata('SESS_USER_ID')) ?>;

        $.ajax({
            url: '<?= base_url("selfservices/get_attendance_record") ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                empl: empl_id,
                date: date
            },
            success: function(response) {
                $('#shift_type').html('<span>' + (response.shift?.name || 'No shift assigned') + '</span>');

                const timeIn = response.attendance?.time_in ? response.attendance.time_in : '--:--';
                const timeOut = response.attendance?.time_out ? response.attendance.time_out : '--:--';

                $('#actual_time_in_display').html(timeIn);
                $('#actual_time_out_display').html(timeOut);

                $('#actual_time_in').val(response.attendance?.time_in || '');
                $('#actual_time_out').val(response.attendance?.time_out || '');
            },
        });
    }
</script>

<script>
    function validateForm() {
        var time_in = document.getElementById('actual_time_in').value;
        var time_out = document.getElementById('actual_time_out').value;

        if ((!time_in || time_in === "00:00:00") && (!time_out || time_out === "00:00:00")) {
            $(document).Toasts('create', {
                class: 'bg-warning toast_width',
                title: 'Warning!',
                subtitle: 'close',
                body: 'Time In and Time Out are required to acquire an offset.'
            });
            return false;
        }

        if (!time_in || time_in === "00:00:00") {
            $(document).Toasts('create', {
                class: 'bg-warning toast_width',
                title: 'Warning!',
                subtitle: 'close',
                body: 'Invalid time for "Actual Time In".'
            });
            return false; // Prevents form submission
        }

        if (!time_out || time_out === "00:00:00") {
            $(document).Toasts('create', {
                class: 'bg-warning toast_width',
                title: 'Warning!',
                subtitle: 'close',
                body: 'Invalid time for "Actual Time Out".'
            });
            return false; // Prevents form submission
        }

        return true; // Allows form submission 
    }
</script>