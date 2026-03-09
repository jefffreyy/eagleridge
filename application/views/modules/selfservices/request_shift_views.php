<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper" style="min-height: 624px;">
    <div class="row">
        <div class="col-md-8 ml-4 mt-3">
            <h2><a href="<?= base_url('selfservices/my_time_adjustments') ?>"> <img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a></h2>
        </div>
    </div>

    <div class="container-fluid px-4">

        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_open('selfservices/add_shift_request', 'id="timeAdjustmentForm"'); ?>
                                <div class="form-group">
                                    <label class="required" for="date">Adjustment&nbsp;Date</label>
                                    <input type="date" name='date' id='date' value="<?php echo date('Y-m-d'); ?>" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label class="" for="input_reason">Shifts</label>
                                    <select id="shift_id" class="form-control" name="shift_id">
                                    <?php foreach($shifts as $r) { ?>
                                        <option value='<?=$r->id?>'><?=$r->name." ($r->time_regular_start-$r->time_regular_end)"?></option>
                                    <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="" for="input_reason">Reason</label>
                                    <textarea name="reason" class="form-control" id="reason" name="reason" rows="4" cols="50" enabled=""></textarea>
                                </div>

                                <div class="file_uploader form-group" data-type="self_services">
                                    <label>Attachment</label>
                                    <input type="hidden" name="attachment" class="selected_images d-block w-100"/>
                                </div>



                                <!-- <input type='hidden' name='status' value='Pending 1' /> -->
                        
                                <div class="mr-2" style="float: right !important">
                                    <button type='submit' id="btn_add" class="btn technos-button-blue shadow-none rounded " ;="">
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
        // Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>', '', 'success')
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success',
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
    <script>
        // Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>', '', 'success')
        $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('ERR'); ?>'
        })
    </script>
<?php
}
?>

<!-- <?php
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
?> -->
<script>
    document.getElementById('timeAdjustmentForm').addEventListener('submit', function(event) {
        let timeInValue = document.getElementById('adjust_input_time_in_1').value;
        let timeOutValue = document.getElementById('adjust_input_time_out_1').value;

        if (!timeInValue.trim() || !timeOutValue.trim()) {
            event.preventDefault(); // Prevent form submission
            alert('Please fill in the required fields.'); // Show an alert message
        }
    });
</script>

<script>
    let url = '<?=base_url();?>'
    document.addEventListener('DOMContentLoaded', function() {
        let shift_date = document.getElementById('date_adjustment').value;
        fetchShiftAssignment(shift_date);
    });

    $('#date_adjustment').change(function() {
        let shift_date = $(this).val();
        
        fetchShiftAssignment(shift_date);
    });

    function fetchShiftAssignment(shift_date) {
        fetch(url + 'selfservices/GET_SHIFT_ASSIGN', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(shift_date)
        })
        .then(response => response.json())
        .then(result => {
        
            let shiftTimeIn1Input           = document.getElementById('input_shift_time_in_1');
            let shiftTimeOut1Input          = document.getElementById('input_shift_time_out_1');
            let timeIn1Input                = document.getElementById('input_time_in_1');
            let timeOut1Input               = document.getElementById('input_time_out_1');
            let adjustTimeIn1Input          = document.getElementById('adjust_input_time_in_1');
            let adjustTimeOut1Input         = document.getElementById('adjust_input_time_out_1');
            
            if (result) {
                shiftTimeIn1Input.value         = (result.time_regular_start && result.time_regular_start !== '00:00:00') ? result.time_regular_start : '';
                shiftTimeOut1Input.value        = (result.time_regular_end && result.time_regular_end !== '00:00:00') ? result.time_regular_end : '';
                timeIn1Input.value              = (result.time_in && result.time_in !== '00:00:00') ? result.time_in : '';
                timeOut1Input.value             = (result.time_out && result.time_out !== '00:00:00') ? result.time_out : '';
                adjustTimeIn1Input.value        = (result.time_regular_start && result.time_regular_start !== '00:00:00') ? result.time_regular_start : '';
                adjustTimeOut1Input.value       = (result.time_regular_end && result.time_regular_end !== '00:00:00') ? result.time_regular_end : '';

            } else {
                // Reset time inputs to empty values
                shiftTimeIn1Input.value     = '';
                shiftTimeOut1Input.value    = '';
                timeIn1Input.value          = '';
                timeOut1Input.value         = '';
                adjustTimeIn1Input.value    = '';
                adjustTimeOut1Input.value   = '';
            }
        })
        .catch(error => {
            console.error('Data update error:', error);
        });
    }

    $(document).ready(function() {
    
        $('#selected_date').on('change', function() {
            window.location = "?date=" + $(this).val()
        })

    })
</script>