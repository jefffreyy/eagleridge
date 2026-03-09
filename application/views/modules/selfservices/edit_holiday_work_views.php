<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper">
    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="<?= base_url() . 'selfservices/my_holiday_work'; ?>"><i class="fa-duotone fa-circle-left"></i></h2>

        </div>
    </div>

    <div class="container-fluid px-4">

        <nav aria-label="breadcrumb">

            <ol class="breadcrumb">

                <li class="breadcrumb-item">

                    <a href="https://dev-env-demo.eyebox.app/selfservices">Self Services</a>

                </li>

                <li class="breadcrumb-item">

                    <a href="https://dev-env-demo.eyebox.app/selfservices/my_holiday_work">My Holiday Work</a>

                </li>

                <li class="breadcrumb-item active" aria-current="page">Edit&nbsp;My Holiday Work </li>

            </ol>

        </nav>

        <div class="row d-flex justify-content-center">

            <div class="col-sm-6">

                <div class="card">

                    <div class="modal-body pb-5">

                        <?php echo form_open('selfservices/update_holiday_work') ?>

                        <label class="">Assigned By</label>

                        <select class="form-control" name="assigned_by" id="input_assigned_by" enabled>

                            <option value="<?= $HOLIDAY_WORK->assigned_by_id ?>"><?= $HOLIDAY_WORK->assigned_by ?></option>

                        </select>

                        <input type="hidden" name="id" value="<?= $HOLIDAY_WORK->id ?>" />

                        <label class="">Employee</label>

                        <select class="form-control" name="empl_id" id="input_empl_id" enabled>

                            <option value="<?= $HOLIDAY_WORK->empl_id ?>"><?= $HOLIDAY_WORK->employee ?></option>

                        </select>

                        <div class="form-group">

                            <label class="" for="input_date">Date</label>

                            <input type="date" class="form-control" name="date" id="input_date" enabled value="<?= $HOLIDAY_WORK->date ?>">

                        </div>

                        <label class="">Type</label>

                        <div class="form-group">

                            <select class="form-control" name="type" id="type" enabled>

                                <?php foreach ($TYPES as $type) : ?>

                                    <option value="<?= $type ?>" <?= $HOLIDAY_WORK->type == $type ? 'selected' : '' ?>><?= $type ?></option>

                                <?php endforeach ?>

                            </select>

                        </div>

                        <div class="form-group">

                            <label class="" for="input_hours">Working Hours</label>

                            <input type="number" min="0" class="form-control" name="hours" id="input_hours" enabled value="<?= $HOLIDAY_WORK->hours ?>">

                        </div>

                        <div class="form-group">

                            <label class="" for="input_reason">Reason</label>

                            <textarea name="reason" class="form-control" id="reason" rows="4" cols="50" enabled><?= $HOLIDAY_WORK->reason ?></textarea>

                        </div>

                        <label class="">Status</label>

                        <div class="form-group">

                            <select class="form-control" name="status" id="input_status" disabled>

                                <option><?= $HOLIDAY_WORK->status ?></option>

                            </select>

                        </div>

                        <div class="form-group">

                            <label class="" for="input_comment">Remarks</label>

                            <textarea name="comment" class="form-control" id="input_comment" rows="4" cols="50" enabled><?= $HOLIDAY_WORK->comment ?></textarea>

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