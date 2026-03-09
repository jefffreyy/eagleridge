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
            <h2><a href="<?=base_url('requests/exemptut')?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="">
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
                                <form action="<?= base_url('teams/add_request_exemptut_admin') ?>" method='post'>
                                    <!-- <input type='hidden' value="<?= $this->session->userdata('SESS_USER_ID') ?>" id="empl_id" name='empl_id' /> -->

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
                                        <label class="required" for="date_undertime">Date</label>
                                        <input type="date" class="form-control" name="date_undertime" id="date_undertime" value="<?= date('Y-m-d') ?>" required>
                                    </div>
                                
                                    <div class="form-group">
    
                                        <label class="required">Shift Out</label>
                                        <input type="text" name="shift_out" id="shift_out" class="form-control" value="No shift assign" readonly>
                                        
                                        <!-- <p class="p-0 p-2 m-0 bg-light rounded d-flex justify-content-between" id="actual_out"><span></span></p> -->
    
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="">Actual Out</label>
                                        <input type="text" name="actual_out" id="actual_out" class="form-control" value="No shift assign" readonly>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label class="" for="input_reason">Reason</label>
                                        <textarea name="reason" class="form-control" id="reason" rows="4" cols="50" enabled=""></textarea>
                                    </div>
                                    <input type='hidden' value='Pending 1' name='status' />
                                
                                    <div class="mr-2" style="float: right !important">
                                        <button id="btn_add" type='submit' class="btn btn-primary shadow-none rounded " ;="">
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
        let date = ''; // Initialize the date variable outside the event handler

    $('#date_undertime, #empl_id').on('change', function(){
        let empl_id = $('#empl_id').val();
        date = $('#date_undertime').val(); // Update the global 'date' variable
        let formatted_date = moment(date);
        // console.log(formatted_date.format('MM/DD/YYYY'));

        $.post("<?=base_url('overtimes/get_shift_type')?>", {'empl': empl_id, 'date': date}, function(res){
            if(res){
                let name = res.name ? res.name : '';
                let start_time = res.time_regular_start ? res.time_regular_start : '';
                let end_time = res.time_regular_end ? res.time_regular_end : ''; 
                let html_data = `${name} ${start_time} - ${end_time}`;
                $('#shift_out').val(end_time);
             
            }
            if(res.length <= 0){
                $('#shift_out').val(`No shift assign`);
            }
        }, 'json');
    });

    // get the shift type when  page is loaded
    function fetchShiftType() {
        let empl_id = $('#empl_id').val();
        date = $('#date_undertime').val();
        let formatted_date = moment(date);

        $.post("<?=base_url('overtimes/get_shift_type')?>", {'empl': empl_id, 'date': date}, function(res){
            if(res){
                let name = res.name ? res.name : '';
                let start_time = res.time_regular_start ? res.time_regular_start : '';
                let end_time = res.time_regular_end ? res.time_regular_end : ''; 
                let html_data = `${name} ${start_time} - ${end_time}`;
                $('#shift_out').val(end_time);
            }
            if(res.length <= 0){
                $('#shift_out').val(`No shift assign`);
            }
        }, 'json');
        $.post("<?=base_url('overtimes/get_shift_out')?>", {'empl': empl_id, 'date': date}, function(res){
            if(res){
                let id = res.id ? res.id : '';
                let out = res.time_out ? res.time_out : '';
                $('#actual_out').val(out);
            }
            if(res.length <= 0){
                $('#actual_out').val(`No Out`);
            }
        }, 'json');
    }

    // Call the function on page load
    fetchShiftType();

    // Bind the function to the change event of input elements
    $('#date_undertime, #empl_id').on('change', function(){
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
