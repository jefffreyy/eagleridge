<?php $this->load->view('templates/css_link'); ?>
<?php
$empl_id = $this->input->get('empl_id');
?>
<div class="content-wrapper" style="min-height: 624px;">
    <div class="row">
        <div class="col-md-8 ml-4 mt-3">
            <h2><a href="<?= base_url('teams/apply_time_adjustments') ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="">

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
                                <?php echo form_open('teams/add_time_adjustment'); ?>

                                <div class="form-group">
                                    <label class="required" for="input_date_adjustment">Adjustment&nbsp;Date</label>

                                    <!-- <select id='selected_date' class="custom-select" name='date_adjustment'>
                                        <?php foreach ($ATTENDANCE_REC as $attendace) { ?>
                                            <?php if ($DEFAULT_VAL) {  ?>
                                                <option value="<?= $attendace->date ?>" <?= $attendace->date == $DEFAULT_VAL->date ? 'selected' : '' ?>><?= date_format(date_create($attendace->date), 'F d Y') ?></option>
                                        <?php }
                                        } ?>
                                    </select> -->
                                    <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name='date_adjustment' required>
                                </div>
                            
                                <div class="form-group">
                                    <label class="required" for="input_date_adjustment">Employee</label>

                                    <select id='selected_empl' class="custom-select" name='empl_id'>
                                        <?php foreach ($EMPLOYEES as $employee) { ?>
                                            <option value="<?= $employee->id ?>" <?= $empl_id == $employee->id ? 'selected' : '' ?>><?= $employee->fullname ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="input_time_in_1">Time&nbsp;In</label>
                                    <input type="time" required class="form-control" name="time_in_1" id="input_time_in_1" enabled="" value="<?= isset($DEFAULT_VAL->time_in) ? $DEFAULT_VAL->time_in  : '' ?>">
                                </div>

                                <div class="form-group">
                                    <label class="required" for="input_time_out_1">Time&nbsp;Out</label>
                                    <input type="time" class="form-control" name="time_out_1" id="input_time_out_1" enabled="" value="<?= isset($DEFAULT_VAL->time_out) ? $DEFAULT_VAL->time_out  : '' ?>">
                                </div>
                                <div class="file_uploader form-group" data-type="self_services">
                                    <label>Attachment</label>
                                    <input type="hidden" name="attachment" class="selected_images d-block w-100" />
                                </div>
                                <!--<div class="form-group">-->
                                <!--    <label class="" for="input_attachment">Attachment</label>-->
                                <!--    <input type="file" class="form-control file_upload" name="attachment" id="input_attachment" enabled="" value="">-->
                                <!--</div>-->

                                <div class="form-group">
                                    <label class="" for="input_reason">Reason</label>
                                    <textarea name="reason" class="form-control" id="reason" rows="4" cols="50" enabled=""></textarea>
                                </div>

                                <input type='hidden' name='status' value='Pending 1' />

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
        Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>', '', 'success')
    </script>
<?php
}
?>
<?php
if ($this->session->flashdata('ERR')) {
?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-danger toast_width',
            title: 'Success',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('ERR'); ?>'
        })
    </script>
<?php
   
}
?>
<script>
    $(document).ready(function() {
        $('#selected_date').on('change', function() {
            let date = $('#selected_date').val();
            let empl = $('#selected_empl').val();
            window.location = "?date=" + date + '&empl_id=' + empl
        })
        $('#selected_empl').on('change', function() {
            let date = $('#selected_date').val();
            let empl = $('#selected_empl').val();
            window.location = '?empl_id=' + empl
        })

    })
</script>