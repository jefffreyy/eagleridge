<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper">

    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="javascript:history.go(-1);"><i class="fa-duotone fa-circle-left"></a></i></h2>
        </div>
    </div>

    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="https://dev-env-demo.eyebox.app/selfservices">Self Services</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="https://dev-env-demo.eyebox.app/selfservices/my_overtimes">My Overtimes</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit&nbsp;My Overtimes </li>
            </ol>
        </nav>

        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <?php echo form_open('attendances/update_overtime') ?>
                        <input type="hidden" value="<?= $OVERTIME->id ?>" name="id">
                        <label class="">Assigned By</label>
                        <input type="hidden" name="assigned_by" value="<?= $OVERTIME->assigned_by_id ?>">
                        <select class="form-control" id="input_assigned_by" disabled>
                            <option><?= $OVERTIME->assigned_by ?></option>
                        </select>

                        <label class="">Employee</label>
                        <input type="hidden" name="empl_id" value="<?= $OVERTIME->empl_id ?>" />
                        <select class="form-control" id="input_empl_id" disabled>
                            <option value="<?= $OVERTIME->empl_id ?>"><?= $OVERTIME->employee ?></option>
                        </select>

                        <label class="">Type</label>
                        <div class="form-group">
                            <select class="form-control" name="type" id="input_type" enabled>
                                <?php foreach ($TYPES as $type) : ?>
                                    <option value="<?= $type ?>" <?= $OVERTIME->type == $type ? 'selected' : '' ?>><?= $type ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="" for="input_date_ot">Shift Date</label>
                            <input type="date" class="form-control" name="date_ot" id="input_date_ot" enabled value="<?= $OVERTIME->date_ot ?>">
                        </div>

                        <div class="form-group">
                            <label class="" for="input_time_out">Time Out</label>
                            <input type="time" class="form-control" name="time_out" id="input_time_out" enabled value="<?= $OVERTIME->time_out ?>">
                        </div>

                        <div class="form-group">
                            <label class="" for="input_hours">Overtime Hours</label>
                            <input type="number" min="0" class="form-control" name="hours" id="input_hours" enabled value="<?= $OVERTIME->hours ?>">
                        </div>

                        <div class="form-group">
                            <label class="" for="input_reason">Reason</label>
                            <textarea name="reason" class="form-control" id="input_reason" rows="4" cols="50" enabled><?= $OVERTIME->reason ?></textarea>
                        </div>

                        <label class="">Status</label>

                        <div class="form-group">
                            <input type="hidden" name="status" value="<?= $OVERTIME->status ?>" />
                            <select class="form-control" name="input_status" id="input_status" disabled>
                                <option value="<?= $OVERTIME->status ?>"><?= $OVERTIME->status ?></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="" for="input_comment">Remarks</label>
                            <textarea name="comment" class="form-control" id="input_comment" rows="4" cols="50" enabled><?= $OVERTIME->comment ?></textarea>
                        </div>

                        <div class="mr-2" style="float: right !important">
                            <button class="btn technos-button-blue shadow-none rounded" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>