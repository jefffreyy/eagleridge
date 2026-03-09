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

                                <div class="form-group" style="display: flex; align-items: center;">
                                    <label for="input_duration">Available Offset (Hours) :</label>
                                    <h5 style="margin-left: 10px;"><?= $DISP_TOTAL_OFFSET ?></h5>
                                </div>

                                <div class="form-group">
                                    <label class="required">Offset Type</label>
                                    <input type="text" class="form-control" name="offset_type" value="Redeem" readonly>
                                </div>

                                <div class="form-group">

                                    <label class="required" for="input_offset_date">Offset Date</label>

                                    <input type="date" class="form-control" name="offset_date" id="input_offset_date" value="<?= date('Y-m-d') ?>" required enabled="">
                                    <!-- <div style="font-size: 14px">
                                        <p style="font-weight: 500">Balance: <span id="diplayBalance" style="font-weight:400">select valid date</span></p> 
                                    </div> -->
                                </div>

                                <!-- <div class="form-group">
                                    <label class="required">Shift Type</label>
                                    <p class="p-0 p-2 m-0 bg-light rounded d-flex justify-content-between" id="shift_type"><span>No shift assign</span></p>
                                </div> -->

                                <div class="form-group">
                                    <label class="required">Current Shift</label>
                                    <input type="text" id="shift_type" class="form-control" value="No shift assign" readonly>
                                </div>

                                <div class="form-group">
                                    <label class="required d-block " for="time_range">Time Range</label>
                                    <div class="input-group">
                                        <input type="text" name="time_range" class="form-control" id="time_range" placeholder="Select time range">
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn btn-sm btn-primary rounded-right " id="clear-button"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="" />&nbsp;Clear</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label class="required" for="input_duration">Offset Duration (Hours)</label>

                                    <input type="number" class="form-control " max="9.5" min="0.5" value="1" step="0.5" name="duration" id="input_duration" enabled="" value="" required readonly>
                                    <!-- <div style="font-size: 14px">
                                        <p style="font-weight: 500">Balance: <span id="diplayBalanceAfter" style="font-weight:400">select valid date</span></p> 
                                    </div>     -->
                                </div>

                                <div class="form-group">

                                    <label class="required" for="input_reason">Reason</label>

                                    <textarea name="reason" class="form-control" id="remarks" rows="4" cols="50"

                                        enabled="" required></textarea>

                                </div>

                                <!--<div class="form-group">-->

                                <!--    <label class="" for="input_attachment">Attachment</label>-->

                                <!--    <input type="file" class="form-control file_upload" name="attachment" id="input_attachment" enabled="" value="">-->

                                <!--</div>-->
                                <!-- <div class="file_uploader form-group" data-type="leave" >
                                     <label>Attachment</label>
                                    <input type="hidden" name="attachment" class="selected_images d-block w-100" />
                                </div> -->

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
    // $(document).ready(function() {

    //     // $('.custom_selection').select2()

    //     const input_empl_id = document.getElementById('input_empl_id');
    //     input_empl_id.addEventListener('change', (event) => {
    //     getRequestLeaveBalance();
    //     });
    //     $('#input_empl_id').select2();
    // })
    $(document).ready(function() {
        $('#input_empl_id').select2();

        // $('#input_empl_id').on('select2:select', function (event) {
        //     getRequestLeaveBalance();
        // });
    });
</script>

<!-- <script>
    var baseUrl = '<?= base_url() ?>';
    const apiUrl = baseUrl + 'leaves/get_request_leave_by_date';
    const input_empl_id = document.getElementById('input_empl_id');
    const input_type = document.getElementById('type');
    const input_offset_date = document.getElementById('input_offset_date');
    const input_duration = document.getElementById('input_duration');

    input_type.addEventListener('change', (event) => {
        getRequestLeaveBalance();
    });
    input_offset_date.addEventListener('change', (event) => {
        getRequestLeaveBalance();
    });
    input_duration.addEventListener('change', (event) => {
        console.log('diplayBalance',document.getElementById('diplayBalance').textContent)
        console.log('input_duration',input_duration.value)
        if( !(document.getElementById('diplayBalance').textContent !== undefined && 
            document.getElementById('diplayBalance').textContent !== null && 
            document.getElementById('diplayBalance').textContent !== '' && 
            !isNaN(document.getElementById('diplayBalance').textContent))
            ){
                document.getElementById('diplayBalanceAfter').textContent = 'select valid date';
                return;
            }
        if (
            !(input_duration.value !== undefined &&
            input_duration.value !== null &&
            input_duration.value !== '' &&
            !isNaN(input_duration.value))
            ) {
                document.getElementById('diplayBalanceAfter').textContent = 'input duration'; return;
        }

        document.getElementById('diplayBalanceAfter').textContent = document.getElementById('diplayBalance').textContent - input_duration.value;
    });

    function getRequestLeaveBalance(){
        const empl_id = input_empl_id.value;
        const type = input_type.value;
        const typeName = input_type.selectedOptions[0].dataset.name;
        // const selectedOption = document.getElementById('type').selectedOptions[0];
        // const name = selectedOption.dataset.name;
        const offset_date = input_offset_date.value;
        const duration = input_duration.value;
        if (empl_id && type && offset_date) {
            fetch(apiUrl, {
                method: 'POST',
                body: JSON.stringify({empl_id,type,offset_date,typeName}),
                headers: {
                    'Content-Type': 'application/json'
            }
            })
            .then(response => response.json())
            .then(data => {
                console.log('data',data);
                if (data.messageError) {
                    document.getElementById('diplayBalance').textContent = data.messageError;
                    document.getElementById('diplayBalanceAfter').textContent = data.messageError;
                    // console.log('Error');
                }else if (data.balance !== undefined && data.balance !== null) {
                    document.getElementById('diplayBalance').textContent = data.balance;
                    // console.log('Error');
                    if (input_duration.value) {
                        document.getElementById('diplayBalanceAfter').textContent = data.balance - input_duration.value;
                    }else{
                        document.getElementById('diplayBalanceAfter').textContent = 'input duration';
                    }
                } else {
                console.log('unexpected output occured');
                document.getElementById('diplayBalance').textContent = '';
                document.getElementById('diplayBalanceAfter').textContent = '';
                }
            })
            .catch(error => {
                console.error('Error sending date to controller:', error);
            });
        }
    }
</script> -->
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
        // Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>',

        //     '',

        //     'error'

        // )
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

<script>
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
                // console.log(res)
                // if (res) {
                //     let name = res.name ? res.name : '';
                //     let start_time = res.time_regular_start ? res.time_regular_start : '';
                //     let end_time = res.time_regular_end ? res.time_regular_end : '';
                //     let html_data = `<span>${name}</span><span>${start_time} To ${end_time}</span>`;
                //     $('#shift_type').html(html_data);
                // }
                // if (res.length <= 0) {
                //     $('#shift_type').html(`<span>No shift assign</span>`)
                // }
                if (res) {
                    let name = res.name ? res.name : '';
                    let html_data = `${name}`;
                    $('#shift_type').val(html_data);
                }
                if (res.length <= 0) {
                    $('#shift_type').val('No shift assign');
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
</script>

<script>
    function validateForm() {
        var remainingOT = parseFloat("<?= $DISP_TOTAL_OFFSET ?>");
        var inputDuration = parseFloat(document.getElementById('input_duration').value);
        var shift = document.getElementById('shift_type').value;


        if (inputDuration > remainingOT) {
            $(document).Toasts('create', {
                class: 'bg-warning toast_width',
                title: 'Warning!',
                subtitle: 'close',
                body: 'Insufficient available offset hours.'
            })
            return false; // Prevents form submission
        }


        if (shift == "No shift assign") {
            $(document).Toasts('create', {
                class: 'bg-warning toast_width',
                title: 'Warning!',
                subtitle: 'close',
                body: 'Please indicate the date of your shift'
            })
            return false; // Prevents form submission
        }
        return true; // Allows form submission
    }
</script>


<script>
    $(document).ready(function() {
        $('#time_range').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            locale: {
                format: 'HH:mm:ss'
            }
        });

        $('#time_range').on('apply.daterangepicker', function(ev, picker) {
            const startTime = picker.startDate;
            const endTime = picker.endDate;
            const duration = endTime.diff(startTime, 'hours', true);

            let displayDuration;
            if (duration % 1 === 0) {
                displayDuration = duration;
            } else if (duration % 1 === 0.5) {
                displayDuration = duration.toFixed(1);
            } else {
                displayDuration = duration.toFixed(2);
            }
            
            $('#input_duration').val(displayDuration);
        });

        $('#clear-button').on('click', function() {
            $('#input_duration').val('1'); 
        });
    });
</script>
