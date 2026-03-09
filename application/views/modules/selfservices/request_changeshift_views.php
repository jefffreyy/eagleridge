<?php $this->load->view('templates/css_link'); ?>
<head>
<!-- Include Moment.js -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> -->
<script src="<?= base_url('assets_system') ?>/_eyeboxroot/plugins/moment/moment.min.js"></script>
<!-- Include DateRangePicker CSS -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"> -->
<!-- Include DateRangePicker JavaScript -->
<!-- <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->
<style>
    .calendar-table{
        display:none !important;
    }
</style>
</head>
<div class="content-wrapper" style="min-height: 624px;">
    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="mychange_shift"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="">
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
                                <!-- <form action="<?= base_url('selfservices/add_request_shift') ?>" method='post'> -->
                                <form id="requestForm" style="width:100%">
                                    <input type='hidden' value="<?= $this->session->userdata('SESS_USER_ID') ?>" id="empl_id" name='empl_id' />
      
                                        <div class="form-group">
                                            <label class="required" for="input_date_ot">Date</label>
                                            <input type="date" class="form-control" name="date_shift" id="date_shift" value="<?= date('Y-m-d') ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="required">Current Shift</label>
                                            <input type="text" name="current_shift" id="current_shift" class="form-control" value="No shift assign" readonly>
                                        </div>
                                
                                        <div class="form-group">
                                            <label class="">Request Shift</label>
                                            <select class="form-control" name="request_shift" id="request_shift" enabled="">
                                                <?php foreach ($SHIFTLIST as $row){ ?>
                                                    <option value = <?= $row->id ?>><?= $row->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                               
                                    <div class="form-group">
                                        <label class="" for="input_reason">Reason</label>
                                        <textarea name="reason" class="form-control" id="reason" rows="4" cols="50" enabled=""></textarea>
                                    </div>
                                    <input type='hidden' value='Pending 1' name='status' />
                                
                                    <div class="mr-2" style="float: right !important">
                                        <button type='button' onclick="submitForm()" class="btn btn-primary shadow-none rounded btn_submit" ;="">
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
    //     let date = ''; // Initialize the date variable outside the event handler

    // $('#date_shift, #empl_id').on('change', function(){
    //     let empl_id = $('#empl_id').val();
    //     date = $('#date_shift').val(); // Update the global 'date' variable
    //     let formatted_date = moment(date);
    //     console.log(formatted_date.format('MM/DD/YYYY'));

    //     $.post("<?=base_url('overtimes/get_shift_type')?>", {'empl': empl_id, 'date': date}, function(res){
    //         if(res){
    //             let name = res.name ? res.name : '';
    //             let start_time = res.time_regular_start ? res.time_regular_start : '';
    //             let end_time = res.time_regular_end ? res.time_regular_end : ''; 
    //             let html_data = `${name} ${start_time} - ${end_time}`;
    //             $('#current_shift').val(name);
    //         }
    //         if(res.length <= 0){
    //             $('#current_shift').val(`No shift assign`);
    //         }
    //     }, 'json');
    // });

    function handleShiftChange(dateSelector, shiftInputSelector) {
            let empl_id = $('#empl_id').val();
            let date = $(dateSelector).val(); 
            let formatted_date = moment(date);
            // console.log(formatted_date.format('MM/DD/YYYY'));

            $.post("<?=base_url('overtimes/get_shift_type')?>", {'empl': empl_id, 'date': date}, function(res){
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

        $('#date_shift, #empl_id').on('change', function() {
            handleShiftChange('#date_shift', '#current_shift');
        });

        // $('#date_shift_to, #empl_id').on('change', function() {
        //     handleShiftChange('#date_shift_to', '#current_shift_to');
        // });


        
        // $(document).on('click', '.btn_submit', function(e) {
        //     e.preventDefault();

        //     var form = $(this).closest('form');
        //     var url = form.attr('action');

        //     var title = "Are you sure you want to submit this form?";
        //     var text =  "Confirm to submit form!";
        //     var confirmButtonText = "Yes, submit it!";
        //     var confirmButtonColor = "#28a745";

        //     Swal.fire({
        //     title: title,
        //     text: text,
        //     icon: "warning",
        //     showCancelButton: true,
        //     confirmButtonColor: confirmButtonColor,
        //     cancelButtonColor: "bg-secondary",
        //     cancelButtonText: "No, exit!",
        //     confirmButtonText: confirmButtonText
        //     }).then((result) => {
        //     if (result.isConfirmed) {
        //         form.submit();
        //     }
        //     });
        // });

        


    // get the shift type when  page is loaded
    function fetchShiftType() {
        let empl_id = $('#empl_id').val();
        date = $('#date_shift').val(); // Update the global 'date' variable
        let formatted_date = moment(date);
        console.log(formatted_date.format('MM/DD/YYYY'));

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

    // Call the function on page load
    fetchShiftType();

    // Bind the function to the change event of input elements
    $('#date_shift, #empl_id').on('change', function(){
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

<script>
    var baseUrl = '<?= base_url() ?>';

    function submitForm() {

        const requestData = new FormData(document.getElementById('requestForm'));
        const apiUrl = baseUrl + 'selfservices/add_request_shift';
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
                    window.location.href = '<?= base_url() ?>selfservices/mychange_shift';
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
