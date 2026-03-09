<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper" style="min-height: 624px;">
    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="<?= base_url() . 'benefits/reimbursement'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
        </div>
    </div>

    <div class="container-fluid p-4">

        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_open('benefits/add_reimbursement_action'); ?>
                                <div class="form-group">
                                    <label class="required" for="input_empl_id">Employee</label>
                                    <select class="form-control" name="empl_id" id="input_empl_id">
                                        <?php foreach ($EMPLOYEES as $employee) {
                                        ?>
                                            <option value="<?= $employee->id ?>"><?= $employee->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="type">Types</label>
                                    <select class="form-control" name="type" id="type">
                                        <?php foreach ($types as $type) {
                                        ?>
                                            <option value="<?= $type->id ?>"><?= $type->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="required" for="description">Description</label>
                                    <textarea required name="description" class="form-control" id="description" rows="4" cols="50" enabled=""></textarea>
                                </div>
                                <!-- 
                                <div class="form-group">
                                    <label class="required" for="amount">Amount</label>
                                    <input type="date" required class="form-control" name="amount" id="amount" enabled="" value="">
                                </div> -->
                                <div class="form-group">
                                    <label class="required" for="amount">Amount</label>
                                    <input type="text" required class="form-control" name="amount" id="amount" pattern="^[0-9]+(\.[0-9]+)?$" title="Please enter a valid amount">
                                </div>

                                <div class="form-group">
                                    <label class="required" for="remarks">Remarks</label>
                                    <textarea required name="remarks" class="form-control" id="remarks" rows="2" cols="50" enabled=""></textarea>
                                </div>


                                <!-- <div class="form-group">
                                    <label class="required" for="input_task_date_to">Date to</label>
                                    <input type="date" required class="form-control" name="task_date_to" id="input_task_date_to" enabled="" value="">
                                </div> -->

                                <!-- <label class="">Status</label>
                                <div class="form-group">
                                    <select class="form-control" name="status" id="status" enabled="">
                                        <option>Open</option>
                                        <option>Closed</option>
                                    </select>
                                </div> -->

                                <div class="file_uploader form-group" data-type="benefits">
                                    <label>Attachment</label>
                                    <input type="hidden" name="attachment" class="selected_images d-block w-100" />
                                </div>
                                <!--<div class="form-group">-->
                                <!--    <label class="" for="input_attachment">Attachment</label>-->
                                <!--    <input type="file" class="form-control file_upload" name="attachment" id="input_attachment" enabled="" value="">-->
                                <!--</div>-->

                                <div class="mr-2" style="float: right !important">
                                    <button type='submit' class="btn technos-button-blue shadow-none rounded ">
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

<?php $this->load->view('templates/jquery_link'); ?>
<?php if ($this->session->flashdata('SUCC')) { ?>
    <script>
        Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>', '', 'success')
    </script>
<?php } ?>
<?php if ($this->session->flashdata('ERR')) { ?>
    <script>
        Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>',
            '',
            'error'
        )
    </script>
<?php } ?>

<script>
    document.getElementById('amount').addEventListener('input', function() {
        var inputValue = parseFloat(this.value); 
            if (isNaN(inputValue) || inputValue <= 0 || inputValue > 1000000) {
                this.setCustomValidity('Invalid value. Please input a valid reimbursement amount.');
                this.classList.add('is-invalid'); 
            } else {
                this.setCustomValidity(''); 
                this.classList.remove('is-invalid'); 
            }
    });
</script>

<script>
    $(document).ready(function() {
        $('#input_empl_id').select2();
    });
</script>