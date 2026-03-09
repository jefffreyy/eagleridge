<?php $this->load->view('templates/css_link'); ?>
<!-- Include Moment.js -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> -->

<!-- Include DateRangePicker CSS -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"> -->

<!-- Include DateRangePicker JavaScript -->
<!-- <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->
<style>
    .calendar-table {
        display: none !important;
    }

    table {
        border-collapse: collapse;
        /* width: 50%;
        margin: 20px; */
    }

    table,
    th,
    td {
        border: 1px solid #0000000f;
    }

    th,
    td {
        /* padding: 10px; */
        width: 30%;
    }

    .circle-button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #3498db;
        /* Change the background color as desired */
        color: #ffffff;
        /* Change the text color as desired */
        font-size: 24px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }
</style>

<div class="content-wrapper" style="min-height: 624px;">
    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="<?= base_url() . 'leaves/leave_lists'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
        </div>
    </div>
    <div class="container-fluid px-4">
        <div class="row d-flex justify-content-center">

            <div class="col-sm-6">

                <div class="card">

                    <div class="modal-body pb-5">

                        <div class="row">
                            <form id="leaveForm" style="width:100%">
                                <div class="col-md-12">
                                    <!-- <?php echo form_open('leaves/add_new_leave'); ?> -->
                                    <!--<label class="">Assigned by</label>-->
                                    <!--<select class="form-control custom_selection" name="assigned_by" id="input_assigned_by">-->
                                    <!--</select>-->
                                    <div class="form-group">
                                        <label class="">Employee</label>
                                        <select class="form-control" name="empl_id" id="input_empl_id">
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
                                        <label class="">Type</label>
                                        <select class="form-control" name="type" id="type" enabled="">
                                            <?php foreach ($LEAVE_TYPES as $type) { ?>
                                                <option value='<?= $type->id ?>' data-name='<?= $type->name ?>'><?= $type->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div id="diplayBalance_div" style="display: none;">
                                        <label class="">Current Leave Balance</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control " min="0" name="duration" id="diplayBalance" required enabled="" disabled>
                                        </div>
                                    </div>
                                    <table id="timeTable">
                                        <thead>
                                            <tr>
                                                <!-- <th>Date</th>
                                                <th>Leave Range</th>
                                                <th>Number of Hours</th>
                                                <th>Action</th> -->
                                                <th style="width: 10%;">Date</th>
                                                <th style="width: 10%;">Current Shift</th>
                                                <th style="width: 10%;">Leave Range</th>
                                                <th style="width: 10%;"><?=$isLeaveHours?'Hours':'Days'?></th>
                                                <th style="width: 10%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                        
                                                <td><input type="date" id="date_shift" name="dates[]" value="" class="date form-control"></td>
                                                <td>
                                                <input type="text" name="current_shift[]" id="current_shift" class="current_shift form-control" value="No shift assign" readonly>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" name="leave_range[]" value="" class=" leaverange form-control" placeholder="Select time range">
                                                    </div>
                                                </td>
                                                <td><input type="number" name="hours[]" value="<?=$isLeaveHours?'8':'1'?>"
                                                
                                                <?php if(!$isLeaveHours){?> 
                                                    step="0.5" min="0.5" max="1"
                                                <?php } ?>
                                                class="hours form-control"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="circle-button my-1" onclick="addRow()">+</button>
                                    </div>
                                    <div class="form-group" id="reason">
                                        <label class="" for="input_reason">Reason</label>
                                        <textarea name="reason" class="form-control" id="remarks" rows="4" cols="50" enabled=""></textarea>
                                    </div>
                                    <div class="file_uploader form-group" data-type="leave" id="attachment">
                                        <label>Attachment</label>
                                        <input type="hidden" name="attachment" class="selected_images d-block w-100" />
                                    </div>
                                    <div class="mr-2" style="float: right !important">
                                        <button type='button' id="btn_add" class="btn technos-button-blue shadow-none rounded " onclick="submitForm()">
                                            Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<?php $this->load->view('templates/jquery_link'); ?>

<?php if(!$isLeaveHours){?> 
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var inputs = document.querySelectorAll('.hours');

            inputs.forEach(function(input) {
                input.addEventListener("input", function() {
                    var value = parseFloat(this.value);
                    if (value !== 1 && value !== 0.5 && value !== 0.5) {
                        this.value = ''; // Clear the input if the value is not valid
                    }
                });
            });
        });
        

    </script>    
<?php } ?>

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

        $('#input_empl_id').on('select2:select', function(event) {
            getRequestLeaveBalance();
        });

        let date = ''; 

        $('#date_shift, #input_empl_id').on('change', function(){
            updateShift();
        });

        function updateShift() {
            let empl_id = $('#input_empl_id').val();
        
            date = $('#date_shift').val();
            let formatted_date = moment(date);

            $.post("<?=base_url('overtimes/get_shift_type')?>", {'empl': empl_id, 'date': date}, function(res){
                if(res){
                    let name = res.name ? res.name : '';
                    let start_time = res.time_regular_start ? res.time_regular_start : '';
                    let end_time = res.time_regular_end ? res.time_regular_end : ''; 
                    let html_data = `${name} ${start_time} - ${end_time}`;
                    $('#current_shift').val(name);
                }
                if(res.length <= 0){
                    $('#current_shift').val(`No shift assign`);
                }
            }, 'json');
        }
       
        updateShift();

        $('#timeTable').on('change', '.date', updateShift);
        $('#input_empl_id').on('change', function() {
            $('#timeTable .date').each(function() {
                $(this).trigger('change');
            });
        });
    });

</script>

<script>
    function addRow() {
        const lastRow = document.getElementById('timeTable').rows.length - 1;
        const lastDate = document.getElementById('timeTable').rows[lastRow].querySelector('.date').value;
        const currentShift = document.getElementById('timeTable').rows[lastRow].querySelector('.current_shift').value;
        const lastHours = document.getElementById('timeTable').rows[lastRow].querySelector('.hours').value;
        const leaverange = document.getElementById('timeTable').rows[lastRow].querySelector('.leaverange').value;

        const isLeaveHours = <?= $isLeaveHours ?>; 
        const hoursValue = isLeaveHours ? 8 : 1;
        const stepValue = isLeaveHours ? '' : 'step="0.5"';
        const minValue = isLeaveHours ? '' : 'min="0.5"';
        const maxValue = isLeaveHours ? '' : 'max="1"';
        
        const newRow = document.createElement('tr');
        newRow.classList.add('dynamic-row');
        const nextDate = new Date(lastDate);
        nextDate.setDate(nextDate.getDate() + 1);

        newRow.innerHTML = '<td><input type="date" name="dates[]" value="' + nextDate.toISOString().split('T')[0] + '" class="date form-control"></td>' +
            '<td><input type="text" name="current_shift[]" id="current_shift" class="current_shift form-control" value="No shift assign" readonly></td>' +
            '<td><input type="text" name="leave_range[]" value="' + leaverange + '" class="leaverange form-control"  placeholder="Select time range"></td>' +
            // '<td><input type="number" name="hours[]" value="' + lastHours + '" class="hours form-control"></td>' +
            '<td><input type="number" name="hours[]" value="' + hoursValue + '" ' + stepValue + ' ' + minValue + ' ' + maxValue + ' class="hours form-control"></td>' +
            '<td class ="text-center"><a class="select_row p-2" style="color: gray; cursor: pointer; !important" id="remove_row" > <img src="<?= base_url('assets_system/icons/trash-solid.svg') ?>" onclick="removeRow(this)" alt=""> </a></td>';

        document.getElementById('timeTable').querySelector('tbody').appendChild(newRow);

        // Initialize daterangepicker for the leaverange input in the newly added row
        $(newRow).find('.leaverange').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            showCalendar: false,
            startDate: moment().startOf('day').add(8, 'hours'), // Set start time to 8 AM
            endDate: moment().startOf('day').add(17, 'hours'), // Set end time to 5 PM (17:00)
            locale: {
                format: 'HH:mm:ss'
            }
        });

        var inputs = document.querySelectorAll('.hours');

        inputs.forEach(function(input) {
            input.addEventListener("input", function() {
                var value = parseFloat(this.value);
                if (value !== 1 && value !== 0.5 && value !== 0.5) {
                    this.value = ''; // Clear the input if the value is not valid
                }
            });
        });

        updateCurrentShiftForRow(newRow);
    }

    function updateCurrentShiftForRow(row) {
        let empl_id = $('#input_empl_id').val(); 
        let date = $(row).find('.date').val(); 

        $.post("<?=base_url('overtimes/get_shift_type')?>", {'empl': empl_id, 'date': date}, function(res) {
            let currentShiftInput = $(row).find('.current_shift');
            if (res) {
                let name = res.name ? res.name : 'No shift assign';
                currentShiftInput.val(name);
            } else {
                currentShiftInput.val('No shift assign');
            }
        }, 'json');
    }

    $(document).on('change', '.date', function() {
        let row = $(this).closest('tr');
        updateCurrentShiftForRow(row); 
    });

    document.querySelector('.date').valueAsDate = new Date();

    $('.leaverange').daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        showCalendar: false,
        startDate: moment().startOf('day').add(8, 'hours'), // Set start time to 8 AM
        endDate: moment().startOf('day').add(17, 'hours'), // Set end time to 5 PM (17:00)
        locale: {
            format: 'HH:mm:ss'
        }
    });

    function removeRow(icon) {
        const rowToRemove = icon.closest('tr');

        // Check if the row is a dynamically added row (not the first row)
        if (rowToRemove.classList.contains('dynamic-row')) {
            rowToRemove.remove();
        } else {
            // console.log("Cannot delete the first row");
            // Or display an alert/message indicating the first row cannot be deleted
        }
    }

    // function handleLeaveTypeChange() {
    //     var leaveDropdown = document.getElementById("leave_types_dropdown");
    //     var durationInput = document.getElementById("input_duration");

    //     if (leaveDropdown.value === "Leave without Pay (LWOP)") {
    //         console.log("dede");
    //         durationInput.style.display = "none"; // Hide the input_duration
    //     } else {
    //         console.log("Other leave type selected");
    //         durationInput.style.display = "block"; // Show the input_duration
    //     }
    // }
</script>




<script>
    var baseUrl = '<?= base_url() ?>';
    const apiUrl = baseUrl + 'leaves/get_request_leave_by_date';
    const input_empl_id = document.getElementById('input_empl_id');
    const input_type = document.getElementById('type');
    // const input_leave_date = document.getElementById('input_leave_date');
    const input_leave_date = document.getElementById('timeTable').rows[1].querySelector('.date');

    // const input_duration = document.getElementById('input_duration');

    input_type.addEventListener('change', (event) => {
        getRequestLeaveBalance();


        const displayBalanceInput = document.getElementById('type').selectedOptions[0].dataset.name;
        if (displayBalanceInput != "Leave without Pay (LWOP)" && displayBalanceInput != "Offset") {
            document.getElementById("diplayBalance_div").style.display = "block";
        } else {
            document.getElementById("diplayBalance_div").style.display = "none";
        }
    });
    input_leave_date.addEventListener('change', (event) => {
        getRequestLeaveBalance();
    });

    // input_duration.addEventListener('change', (event) => {
    //     console.log('diplayBalance',document.getElementById('diplayBalance').textContent)
    //     console.log('input_duration',input_duration.value)
    //     if( !(document.getElementById('diplayBalance').textContent !== undefined && 
    //         document.getElementById('diplayBalance').textContent !== null && 
    //         document.getElementById('diplayBalance').textContent !== '' && 
    //         !isNaN(document.getElementById('diplayBalance').textContent))
    //         ){
    //             document.getElementById('diplayBalanceAfter').textContent = 'select valid date';
    //             return;
    //         }
    //     if (
    //         !(input_duration.value !== undefined &&
    //         input_duration.value !== null &&
    //         input_duration.value !== '' &&
    //         !isNaN(input_duration.value))
    //         ) {
    //             document.getElementById('diplayBalanceAfter').textContent = 'input duration'; return;
    //     }

    //     document.getElementById('diplayBalanceAfter').textContent = document.getElementById('diplayBalance').textContent - input_duration.value;
    // });

    function getRequestLeaveBalance() {
        const empl_id = input_empl_id.value;
        const type = input_type.value;
        const typeName = input_type.selectedOptions[0].dataset.name;
        // const selectedOption = document.getElementById('type').selectedOptions[0];
        // const name = selectedOption.dataset.name;
        const leave_date = input_leave_date.value;
        // const duration = input_duration.value;
        if (empl_id && type && leave_date) {
            fetch(apiUrl, {
                    method: 'POST',
                    body: JSON.stringify({
                        empl_id,
                        type,
                        leave_date,
                        typeName
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // console.log('data', data);
                    if (data.messageError) {
                        document.getElementById('diplayBalance').value = data.messageError;

                        // document.getElementById('diplayBalanceAfter').textContent = data.messageError;
                        // console.log('Error');
                    } else if (data.balance !== undefined && data.balance !== null) {
                        
                        <?php if($isLeaveHours == 1){?> 
                            document.getElementById('diplayBalance').value = data.balance;
                        <?php } ?>
                        <?php if($isLeaveHours == 0){?> 
                            let dividedValue;
                            if (data.balance < 8) {
                                dividedValue = data.balance >= 4 ? 0.5 : 0;
                            } else {
                                dividedValue = Math.floor(data.balance / 8);
                                if (data.balance % 8 >= 4) {
                                    dividedValue += 0.5;
                                }
                            }
                            document.getElementById('diplayBalance').value = dividedValue;
                        <?php } ?>
                        // console.log('Error');
                        // if (input_duration.value) {
                        //     document.getElementById('diplayBalanceAfter').textContent = data.balance - input_duration.value;
                        // }else{
                        //     document.getElementById('diplayBalanceAfter').textContent = 'input duration';
                        // }
                    } else {
                        // console.log('unexpected output occured');
                        document.getElementById('diplayBalance').value = '';
                        // document.getElementById('diplayBalanceAfter').textContent = '';
                    }

                    // const btnAdd = document.getElementById('btn_add');

                    // // Enable the button for Offset and LWOP, and if balance is greater than 0
                    // if ((typeName === "Offset" || typeName === "Leave without Pay (LWOP)") || data.balance > 0) {
                    //     btnAdd.disabled = false;
                    // } else {
                    //     btnAdd.disabled = true;
                    // }

                    // if (data.display_reason == 0) {
                    //     console.log('Hiding elements');
                    //     document.getElementById("reason").style.display = "none";

                    // } else {
                    //     console.log('Showing elements');
                    //     document.getElementById("reason").style.display = "block";

                    // }

                    // if (data.display_attachment == 0) {
                    //     console.log('Hiding elements');
                    //     document.getElementById("attachment").style.display = "none";

                    // } else {
                    //     console.log('Showing elements');
                    //     document.getElementById("attachment").style.display = "block";

                    // }
                })
                .catch(error => {
                    console.error('Error sending date to controller:', error);
                });
        }
    }
    getRequestLeaveBalance();
</script>

<?php

if ($this->session->flashdata('SUCC')) { ?>
    <!-- <script>
        Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>', '', 'success')
    </script> -->
    <script>
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('SUCC'); ?>'
        })
    </script>
<?php } ?>

<?php if ($this->session->flashdata('ERR')) { ?>
    <script>
        Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>', '', 'error')
    </script>
<?php } ?>

<script>
    function submitForm() {
        const formData = new FormData(document.getElementById('leaveForm'));
        const apiUrl = baseUrl + 'leaves/add_leaves_api';
        fetch(apiUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                if (data.messageError) {
                    $(document).Toasts('create', {
                        class: 'bg-warning toast_width',
                        title: 'Warning',
                        subtitle: 'close',
                        body: data.messageError
                    })
                } else {
                    // location.reload();
                    window.location.href = '<?= base_url() ?>leaves/leave_lists';
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