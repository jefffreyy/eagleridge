<?php $this->load->view('templates/css_link'); ?>
<head>
<script src="<?= base_url('assets_system') ?>/_eyeboxroot/plugins/moment/moment.min.js"></script>
<style>
    .calendar-table{
        display:none !important;
    }
</style>
</head>
<div class="content-wrapper" style="min-height: 624px;">
    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="undertime"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="">
</a></h2>
        </div>
    </div>

    <div class="container-fluid px-4">

        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?= base_url('requests/add_request_undertime') ?>" method='post'>

                                    <div class="form-group">
                                        <label class="">Employee</label>
                                        <select class="form-control" name="empl_id" id="empl_id">
                                            <?php foreach ($EMPLOYEES as $employee) {
                                                $name = $employee->col_empl_cmid . '-' . $employee->col_last_name;
                                                if ($employee->col_suffix) $name = $name . ' ' . $employee->col_suffix;
                                                if ($employee->col_frst_name) $name = $name . ', ' . $employee->col_frst_name;
                                                if ($employee->col_midl_name) $name = $name . ' ' . $employee->col_midl_name[0] . '.';
                                            ?>
                                                <option value="<?= $employee->id ?>"><?= $name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="required" for="input_date_ot">Date Undertime</label>
                                        <input type="date" class="form-control" name="date_undertime" id="date_undertime" value="<?= date('Y-m-d') ?>" required>
                                    </div>
                                
                                    <div class="form-group">
                                        <label class="required">Current Shift</label>
                                        <input type="text" name="current_shift" id="current_shift" class="form-control" value="No shift assign" readonly>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <label for="request_time_in">Request Time In</label>
                                                <input type="time" class="form-control" name="request_time_in" id="request_time_in" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <label for="request_time_out">Request Time Out</label>
                                                <input type="time" class="form-control" name="request_time_out" id="request_time_out" required>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="" for="input_reason">Reason</label>
                                        <textarea name="reason" class="form-control" id="reason" rows="4" cols="50" enabled=""></textarea>
                                    </div>
                                    <input type='hidden' value='Pending 1' name='status' />
                                
                                    <div class="mr-2" style="float: right !important">
                                        <button id="btn_add" type='submit' class="btn btn-primary shadow-none rounded btn_submit" ;="">
                                            Submit</button>
                                    </div>
                                </form>
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
    $(document).ready(function(){

    $('#empl_id').select2();

        function handleShiftChange(dateSelector, shiftInputSelector) {
            let empl_id = $('#empl_id').val();
            let date = $(dateSelector).val(); 
            let formatted_date = moment(date);
            // console.log(formatted_date.format('MM/DD/YYYY'));

            $.post("<?=base_url('teams/get_shift_type')?>", {'empl': empl_id, 'date': date}, function(res){
                if (res) {
                    let name = res.name ? res.name : '';
                    let start_time = res.time_regular_start ? res.time_regular_start : '';
                    let end_time = res.time_regular_end ? res.time_regular_end : ''; 
                    let html_data = `${name} ${start_time} - ${end_time}`;
                    $(shiftInputSelector).val(name);
                } else {
                    $(shiftInputSelector).val('No shift assign');
                }
            }, 'json');
        }

        $('#date_undertime, #empl_id').on('change', function() {
            handleShiftChange('#date_undertime', '#current_shift');
        });
        handleShiftChange('#date_undertime', '#current_shift');
        

        $(document).on('click', '.btn_submit', function(e) {
            e.preventDefault();

            var currentShift = document.getElementById('current_shift').value;
            var timeIn = document.getElementById('request_time_in').value;
            var timeOut = document.getElementById('request_time_out').value;
            var reason = document.getElementById('reason').value;

            function toat_response(resonse_data){
                $(document).Toasts('create', {
                    class: 'bg-warning toast_width',
                    title: 'Error!',
                    subtitle: 'close',
                    body: resonse_data,
                })
            }

            if(!currentShift || currentShift == 'No shift assign'){
                let response = 'Please check the current shift.';
                toat_response(response);
                return;
            }

            if (!timeIn) {
                let response = 'Please fill out the Time In field.';
                toat_response(response);
                return;
            }

            if (!timeOut) {
                let response = 'Please fill out the Time Out field.';
                toat_response(response);
                return;
            }

            if (!reason) {
                let response = 'Please fill out the reason field.';
                toat_response(response);
                return;
            }

            var form = $(this).closest('form');
            var url = form.attr('action');

            var title = "Are you sure you want to submit this form?";
            var text =  "Confirm to submit form!";
            var confirmButtonText = "Yes, submit it!";
            var confirmButtonColor = "#28a745";

            Swal.fire({
            title: title,
            text: text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: confirmButtonColor,
            cancelButtonColor: "bg-secondary",
            cancelButtonText: "No, exit!",
            confirmButtonText: confirmButtonText
            }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
            });
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
