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
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-8 ml-4 mt-3">
            <h2><a href="<?= base_url('selfservices/my_leaves') ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
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
                                    <!-- <?php echo form_open('selfservices/add_leave_request'); ?> -->
                                    <label class="">Type</label>
                                    <div class="form-group">
                                        <!-- <select class="form-control" name="type" id="leave_types_dropdown" enabled=""> -->
                                        <select class="form-control" name="type" id="type" enabled="">
                                            <?php

                                            foreach ($LEAVE_TYPES as $leave_type) {

                                            ?>
                                                <option value="<?= $leave_type->id ?>" data-name='<?= $leave_type->name ?>'><?= $leave_type->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>


                                    <div id="displayBalance_div" style="display: none;">
                                        <label id="input_duration_label" class="">Current Balance</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" min="0" name="duration" id="displayBalance" required enabled="" disabled>
                                        </div>
                                    </div>


                                    <label id="input_duration_label" class="">Total Duration</label>
                                    <div class="form-group">
                                   
                                        <input type="text" class="form-control " min="0" name="duration" id="displaytotal" required enabled="" disabled  value="<?=$isLeaveHours?'8':'1'?>">
                                    </div>

                                    <div id="displayAfter_div" style="display: none;">
                                        <label id="input_duration_label" class="">Projected Balance</label>
                                        <div class="form-group">
                                      
                                            <input type="text" class="form-control " min="0" name="duration" id="displayafter" required enabled="" disabled>
                                        </div>
                                        <!-- <button id="day_conversion" class="btn btn-primary mb-2">Convert Hours to Days</button> -->
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
                                                
                                                <!-- <th style="width: 10%;">Hours</th> -->
                                                <th style="width: 10%;"><?=$isLeaveHours?'Hours':'Days'?></th>
                                                <th style="width: 10%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <input type='hidden' value="<?= $this->session->userdata('SESS_USER_ID') ?>" id="empl_id" name='empl_id' />
                                                <td><input type="date" id="date_shift" name="dates[]" value="" class="date form-control"></td>
                                                <td>
                                                <input type="text" name="current_shift[]" id="current_shift" class="current_shift form-control" value="No shift assign" readonly>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" name="leave_range[]" value="" class=" leaverange form-control" placeholder="Select time range">

                                                    </div>
                                                </td>
                                         
                                                <td>
                                                    <!-- <input type="number" id="hours" name="hours[]" value="8" class="hours form-control" min="1" max="24"> -->

                                                    <input type="number" name="hours[]" value="<?=$isLeaveHours?'8':'1'?>"
                                                
                                                    <?php if(!$isLeaveHours){?> 
                                                        step="0.5" min="0.5" max="1"
                                                    <?php } ?>
                                                    class="hours form-control">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="circle-button my-1" onclick="addRow()">+</button>
                                    </div>
                                    <div class="form-group">
                                        <label class="required" for="input_duration">Reason</label>
                                        <textarea class="form-control" name="reason" rows="3" id="reason"></textarea>
                                    </div>

                                    <!--<input type='hidden' name='status' value='Pending 1' />-->
                                    <div class="file_uploader form-group" id="attachment" data-type="leave">
                                        <label>Attachment</label>
                                        <input type="hidden" name="attachment" class="selected_images d-block w-100" />
                                    </div>

                                    <div class="mr-2" style="float: right !important">
                                        <button id="btn_add" type='button' class="btn btn-primary shadow-none rounded" onclick="submitForm()">Submit</button>
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

<?php if ($this->session->flashdata('SUCC')) { ?>
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
        $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('ERR'); ?>'
        })
    </script>
<?php } ?>

<?php
if ($this->session->userdata('ERR')) {
?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-danger toast_width',
            title: 'Success',
            subtitle: 'close',
            body: '<?php echo $this->session->userdata('ERR'); ?>'
        })
    </script>
<?php
    $this->session->unset_userdata('ERR');
}
?>

<script>
$(document).ready(function(){
    let date = ''; // Initialize the date variable outside the event handler

    $('#date_shift, #empl_id').on('change', function(){
        handleShiftChange();
    })

    function handleShiftChange(){
        let empl_id = $('#empl_id').val();
        date = $('#date_shift').val(); // Update the global 'date' variable
        let formatted_date = moment(date);
        // console.log(formatted_date.format('MM/DD/YYYY'));

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

    handleShiftChange();
    // Add event listener to dynamically added rows
    $('#timeTable').on('change', '.date', function() {
        let row = $(this).closest('tr');
        let date = $(this).val();
        let empl_id = $('#empl_id').val();

        $.post("<?=base_url('overtimes/get_shift_type')?>", {'empl': empl_id, 'date': date}, function(res){
            let currentShiftInput = row.find('.current_shift');
            if(res){
                let name = res.name ? res.name : 'No shift assign';
                currentShiftInput.val(name);
            } else {
                currentShiftInput.val('No shift assign');
            }
        }, 'json');
    });
    

});
</script>

<script>
    const input_table = document.getElementById('timeTable');
    const input_type = document.getElementById('type');
    const input_leave_date = document.getElementById('timeTable').rows[1].querySelector('.date');

    input_table.addEventListener('change', function() {
        getTotalDuration();
    });

    input_type.addEventListener('change', (event) => {

        // const displayBalanceInput = document.getElementById('type').selectedOptions[0].dataset.name;
        // isConverted = false;
        // document.getElementById('day_conversion').textContent = "Convert Hours to Days";
        getTotalDuration();
    });

    input_leave_date.addEventListener('change', (event) => {
        getRequestLeaveBalance();
    });


    function getTotalDuration() {
        const totalRow = document.getElementById('timeTable').rows.length;
        var sum = 0;
        var hoursValue = 0;
        for (var i = 1; i < totalRow; i++) {
            hoursValue = parseFloat(document.getElementById('timeTable').rows[i].querySelector('.hours').value);
            if (!isNaN(hoursValue)) {
                sum += hoursValue;
            }
            document.getElementById('displaytotal').value = sum;
        }
        const promise = getRequestLeaveBalance();
        promise.then(result => {
           

            <?php if($isLeaveHours == 1){?> 
                document.getElementById('displayafter').value = result - sum;
            <?php } ?>
            <?php if($isLeaveHours == 0){?> 

                let balanceInDays = Math.floor(result / 8) - sum;

                document.getElementById('displayafter').value = balanceInDays;
            <?php } ?>


        }).catch(error => {
            console.error(error);
        });

    }

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
            '<input type="hidden" value="<?= $this->session->userdata('SESS_USER_ID') ?>" id="empl_id" name="empl_id" />' +
            '<td><input type="text" name="current_shift[]" id="current_shift" class="current_shift form-control" value="No shift assign" readonly></td>' +
            '<td><input type="text" name="leave_range[]" value="' + leaverange + '" class="leaverange form-control"  placeholder="Select time range"></td>' +
            // '<td><input type="number" name="hours[]" value="' + lastHours + '" class="hours form-control"></td>' +
            '<td><input type="number" name="hours[]" value="' + hoursValue + '" ' + stepValue + ' ' + minValue + ' ' + maxValue + ' class="hours form-control"></td>' +
            '<td class ="text-center"><a class="select_row p-2" style="color: gray; cursor: pointer; !important" id="remove_row" > <img src="<?= base_url('assets_system/icons/trash-solid.svg') ?>" onclick="removeRow(this)" alt=""> </a></td>';
     
        document.getElementById('timeTable').querySelector('tbody').appendChild(newRow);

        getTotalDuration();

        $(newRow).find('.leaverange').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            showCalendar: false,
            startDate: moment().startOf('day').add(8, 'hours'),
            endDate: moment().startOf('day').add(17, 'hours'),
            locale: {
                format: 'HH:mm:ss'
            }
        });

        var inputs = document.querySelectorAll('.hours');

        inputs.forEach(function(input) {
            input.addEventListener("input", function() {
                var value = parseFloat(this.value);
                if (value !== 1 && value !== 0.5 && value !== 0.5) {
                    this.value = '';
                }
            });
        });

        updateCurrentShiftForRow(newRow);
    }

    function updateCurrentShiftForRow(row) {
        let empl_id = $('#empl_id').val(); 
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
        startDate: moment().startOf('day').add(8, 'hours'),
        endDate: moment().startOf('day').add(17, 'hours'),
        locale: {
            format: 'HH:mm:ss'
        }
    });

    function removeRow(icon) {
        const rowToRemove = icon.closest('tr');

        if (rowToRemove.classList.contains('dynamic-row')) {
            rowToRemove.remove();
        } else {
            // console.log("Cannot delete the first row");
        }
        getTotalDuration();
    };

    var baseUrl = '<?= base_url() ?>';
    const apiUrl = baseUrl + 'selfservices/get_request_leave_by_date';
    const redirectUrl = baseUrl + 'selfservices/my_leaves';

    function getRequestLeaveBalance() {
        const type = input_type.value;
        const typeName = input_type.selectedOptions[0].dataset.name;
        const leave_date = input_leave_date.value;


        if (type && leave_date) {
            return fetch(apiUrl, {
                    method: 'POST',
                    body: JSON.stringify({
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

                    if (data && typeof data === 'object') {
                        // console.log('Response data:', data);

                        // if (data.display_attachment == 0) {
                        //     console.log('Hiding elements');
                        //     document.getElementById("attachment").style.display = "none";

                        // } else {
                        //     console.log('Showing elements');
                        //     document.getElementById("attachment").style.display = "block";

                        // }

                        const reasonInput = document.getElementById('reason');
                        reasonInput.required = data.display_reason !== 0;


                        const btnAdd = document.getElementById('btn_add');


                        // if ((typeName === "Offset" || typeName === "Leave without Pay (LWOP)") || data.balance > 0) {
                        //     btnAdd.disabled = false;
                        // } else {
                        //     btnAdd.disabled = true;
                        // }

                        if (data.display_credit !== undefined) {
                            // console.log('Display Credit:', data.display_credit);

                            if (data.display_credit != 1) {
                                // console.log('Hiding elements');
                                document.getElementById("displayBalance_div").style.display = "none";
                                document.getElementById("displayAfter_div").style.display = "none";
                            } else {
                                // console.log('Showing elements');
                                document.getElementById("displayBalance_div").style.display = "block";
                                document.getElementById("displayAfter_div").style.display = "block";
                            }

                            if (data.messageError) {
                                document.getElementById('displayBalance').value = data.messageError;
                                return null;
                            } else if (data.balance !== undefined && data.balance !== null) {

                                // document.getElementById('displayBalance').value = data.balance;
                            
                                <?php if($isLeaveHours == 1){?> 
                                document.getElementById('displayBalance').value = data.balance;
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
                                    document.getElementById('displayBalance').value = dividedValue;
                                <?php } ?>

                                return data.balance;

                            } else {
                                // console.log('unexpected output occurred');
                                document.getElementById('displayBalance').value = '';
                                return null;
                            }
                        } else {
                            console.error('Error: Unexpected data format received');
                            document.getElementById('displayBalance').value = '0';
                            return null;
                        }
                    } else {
                        console.error('Error: Invalid JSON format received');
                        document.getElementById('displayBalance').value = 'Invalid JSON format received';
                        return null;
                    }
                })
                .catch(error => {
                    console.error('Error sending date to controller:', error);
                    document.getElementById('displayBalance').value = 'Error sending date to controller: ' + error.message;
                    return null;
                });
        }
    }
    getRequestLeaveBalance();
</script>

<script>
    function submitForm() {
        const formData = new FormData(document.getElementById('leaveForm'));
        const formDataObject = Object.fromEntries(formData);
        const apiUrl = baseUrl + 'selfservices/add_my_leaves_api';

        fetch(apiUrl, {
            method: 'POST',
            body: formData
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
                window.location.href = redirectUrl;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>

<script>
    let isConverted = false;

    document.getElementById('day_conversion').addEventListener('click', function() {
        if (!isConverted) {
            convertHoursToDays('displayBalance', true);
            convertHoursToDays('displaytotal', false);
            convertHoursToDays('displayafter', true);
            isConverted = true;
            this.textContent = "Convert Days to Hours";
        } else {
            convertDaysToHours('displayBalance');
            convertDaysToHours('displaytotal');
            convertDaysToHours('displayafter');
            isConverted = false;
            this.textContent = "Convert Hours to Days";
        }
    });

    function convertHoursToDays(elementId, withDecimal) {
        let element = document.getElementById(elementId);
        let balanceInHours = parseFloat(element.value);

        let balanceInDays = balanceInHours / 8;
        if (withDecimal) {
            element.value = parseFloat(balanceInDays.toFixed(2));
        } else {
            element.value = parseFloat(balanceInDays.toFixed(1));
        }

        return balanceInDays;
    }

    function convertDaysToHours(elementId) {
        let element = document.getElementById(elementId);
        let balanceInDays = parseFloat(element.value);

        let balanceInHours = Math.round(balanceInDays * 8);
        element.value = balanceInHours;

        return balanceInHours;
    }

    document.querySelectorAll('.hours').forEach(input => {
        input.addEventListener('input', function() {
            isConverted = false;
            document.getElementById('day_conversion').textContent = "Convert Hours to Days";
        });
    });
</script>