<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-8 ml-4 mt-3">
            <h2><a href="<?= base_url('selfservices/my_time_adjustments') ?>"><i class="fa-duotone fa-circle-left"></i></a></h2>
        </div>
    </div>

    <div class="container-fluid px-4">

        <div class="row d-flex justify-content-center">

            <div class="col-sm-6">

                <div class="card">

                    <div class="modal-body pb-5">

                        <?php echo form_open('selfservices/update_time_adjustment'); ?>

                        <div class="row">

                            <input type="hidden" name="id" value="<?= $TIME_ADJ->id ?>" />

                            <div class="col-md-12">

                                <label class="">Assigned&nbsp;By</label>

                                <select class="form-control" name="assigned_by" id="input_assigned_by" enabled>

                                    <option value="<?= $TIME_ADJ->assigned_by_id ?>"><?= $TIME_ADJ->assigned_by ?></option>

                                </select>



                                <label class="">Employee</label>

                                <select class="form-control" name="empl_id" id="input_empl_id" enabled>

                                    <option value="<?= $TIME_ADJ->empl_id ?>"><?= $TIME_ADJ->employee ?></option>

                                </select>



                                <div class="form-group">

                                    <label class="" for="input_date_adjustment">Adjustment&nbsp;Date</label>

                                    <input type="date" class="form-control" name="date_adjustment" id="input_date_adjustment" enabled value="<?= $TIME_ADJ->date_adjustment ?>">

                                </div>

                                <div class="form-group">

                                    <label class="" for="input_time_in_1">Time&nbsp;In&nbsp;1</label>

                                    <input type="time" class="form-control" name="time_in_1" id="input_time_in_1" enabled value="<?= $TIME_ADJ->time_in_1 ?>">

                                </div>

                                <div class="form-group">

                                    <label class="" for="input_time_out_1">Time&nbsp;Out&nbsp;1</label>

                                    <input type="time" class="form-control" name="time_out_1" id="input_time_out_1" enabled value="<?= $TIME_ADJ->time_out_1 ?>">

                                </div>

                                <div class="form-group">

                                    <label class="" for="input_time_in_2">Time&nbsp;In&nbsp;2</label>

                                    <input type="time" class="form-control" name="time_in_2" id="input_time_in_2" enabled value="<?= $TIME_ADJ->time_in_2 ?>">

                                </div>

                                <div class="form-group">

                                    <label class="" for="input_time_out_2">Time&nbsp;Out&nbsp;2</label>

                                    <input type="time" class="form-control" name="time_out_2" id="input_time_out_2" enabled value="<?= $TIME_ADJ->time_out_2 ?>">

                                </div>

                                <div class="form-group">

                                    <label class="" for="input_attachment">Attachment</label>


                                    <input type="text" class="form-control" name="attachment" id="input_attachment" value="" enabled hidden />

                                    <br><a href="<?= base_url('assets_user/files/selfservices/' . $TIME_ADJ->attachment) ?>" download><?= $TIME_ADJ->attachment ?></a>

                                </div>

                                <div class="form-group">

                                    <label class="" for="input_reason">Reason</label>

                                    <textarea name="reason" class="form-control" id="input_reason" rows="4" cols="50" enabled><?= $TIME_ADJ->reason ?></textarea>

                                </div>

                                <label class="">Status</label>

                                <div class="form-group">

                                    <select class="form-control" name="status" id="input_status" disabled>

                                        <option selected><?= $TIME_ADJ->status ?></option>

                                    </select>

                                </div>

                                <div class="form-group">

                                    <label class="" for="input_remarks">Remarks</label>

                                    <textarea name="remarks" class="form-control" id="input_remarks" rows="4" cols="50" enabled><?= $TIME_ADJ->remarks ?></textarea>

                                </div>

                                <div class="mr-2" style="float: right !important">

                                    <button type="submit" class="btn technos-button-blue shadow-none rounded">Submit</button>

                                </div>

                            </div>



                        </div>



                    </div>

                </div>

            </div>

        </div>

    </div>

</div>