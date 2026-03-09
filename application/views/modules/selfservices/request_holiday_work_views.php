<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper" style="min-height: 570px;">
    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="<?= base_url() . 'selfservices/my_holiday_work'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="">
                </a></h2>
        </div>
    </div>

    <div class="container-fluid px-4">
        <!-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="https://dev-env.eyebox.app/selfservices">Self Services</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="https://dev-env.eyebox.app/selfservices/my_holiday_work">My Holiday Work</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Add&nbsp;My Holiday Work </li>
            </ol>
        </nav> -->

        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?= base_url('selfservices/add_holiday_work') ?>" method='POST'>
                                    <input type='hidden' value="<?= $this->session->userdata('SESS_USER_ID') ?>" name='assigned_by' />
                                    <input type='hidden' value="<?= $this->session->userdata('SESS_USER_ID') ?>" name='empl_id' />
                                    <div class="form-group">
                                        <label class="required" for="input_date">Date</label>
                                        <input type="date" required class="form-control" name="date" id="input_date" enabled="" value="">
                                    </div>

                                    <label class="">Type</label>
                                    <div class="form-group">
                                        <select class="form-control" name="type" id="type" enabled="">
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
                                        <label class="required" for="input_hours">Working Hours</label>
                                        <input type="number" required class="form-control " min="0" name="hours" id="input_hours" enabled="" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="" for="reason">Reason</label>
                                        <textarea name="reason" class="form-control" id="reason" rows="4" cols="50" enabled=""></textarea>
                                    </div>

                                    <input type='hidden' name='status' value='Pending 1' />
                                    <div class="mr-2" style="float: right !important">
                                        <button type='submit' class="btn technos-button-blue shadow-none rounded " ;="">
                                            Submit
                                        </button>
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

<!-- date -->
<script>

  var currentDate = new Date();
  var formattedDate = currentDate.getFullYear().toString().padStart(4, '0') + '-' + 
    (currentDate.getMonth() + 1).toString().padStart(2, '0') + '-' + 
    currentDate.getDate().toString().padStart(2, '0');

  
  document.getElementById('input_date').value = formattedDate;
  document.getElementById('input_date').setAttribute('min', formattedDate);
</script>

<script>
    document.getElementById('input_hours').addEventListener('input', function() {
        var inputValue = parseFloat(this.value); 
            if (isNaN(inputValue) || inputValue < 1 || inputValue > 99) {
                this.setCustomValidity('Invalid input for working hours.');
                this.classList.add('is-invalid'); 
            } else {
                this.setCustomValidity(''); 
                this.classList.remove('is-invalid'); 
            }
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
        Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>',
            '',
            'error'
        )
    </script>
<?php
}
?>