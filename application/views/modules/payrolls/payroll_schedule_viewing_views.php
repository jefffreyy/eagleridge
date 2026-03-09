<?php $this->load->view('templates/css_link'); ?>
<!-- Include Moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<!-- Include DateRangePicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

<!-- Include DateRangePicker JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">

<style>
    .calendar-table {
        display: none !important;
    }
    table {
        border-collapse: collapse;
    }
    table,
    th,
    td {
        /* border: 1px solid #0000000f; */
        border: none;
    }

    th,
    td {
        width: 30%;
    }
</style>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <!-- <div class="col-md-8 ml-4 mt-3">
            <h2><a href="<?= base_url('payrolls') ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="">Payroll Schedule Viewing</a></h2>
        </div> -->

            <div class="col-md-6">
                <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'payrolls'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Payroll Schedule Viewing<h1>
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
                                        <label class="">Set Schedule Viewing</label>
                                        <table id="timeTable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 40%;">Date</th>
                                                    <th style="width: 40%;">Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="padding-bottom: 280px;"><input type="date" name="dates[]" value="" class="date form-control"></td>
                                                    <td style="padding-bottom: 280px;">
                                                        <div class="input-group date time_picker" id="timepicker_regular_start" data-target-input="nearest" style="width: 100% !important;">
                                                            <input type="text" required class="timer_in form-control datetimepicker-input time_text mr-0" name="time_regular_start" placeholder="hr:min" id="time_regular_start_add">
                                                            <div class="input-group-append" data-target="#timepicker_regular_start" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="mr-2" style="float: right !important">
                                            <button id="btn_add" type='button' class="btn technos-button-blue shadow-none rounded " onclick="submitForm()">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js"></script>

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

$(document).ready(function() {
    $('.timer_in').on('input', function() {
        reg_time();
    });


    function reg_time(){
        var reg_time_in = document.getElementById("time_regular_start_add").value;
    }

    $('#timepicker_regular_start').datetimepicker({
        format: 'hh:mm A',  // Use 12-hour format with AM/PM
        icons: {
            time: 'far fa-clock'
        }
    });
})


</script>


<script>
    function submitForm() {
        const formData = new FormData(document.getElementById('leaveForm'));
        const formDataObject = Object.fromEntries(formData);
        console.log('formData', formDataObject);

        const apiUrl = baseUrl + '';

        // return;
        fetch(apiUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
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