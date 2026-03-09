<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper" style="min-height: 624px;">

    <div class="container-fluid p-4">

        <nav aria-label="breadcrumb">

            <ol class="breadcrumb">



                <li class="breadcrumb-item">

                    <a href="https://dev-env.eyebox.app/selfservices">Self Services</a>

                </li>

                <li class="breadcrumb-item">

                    <a href="https://dev-env.eyebox.app/selfservices/my_overtimes">My Overtimes</a>

                </li>

                <li class="breadcrumb-item active" aria-current="page">Add&nbsp;My Overtimes </li>

            </ol>

        </nav>

        <div class="row d-flex justify-content-center">

            <div class="col-sm-6">

                <div class="card">

                    <div class="modal-body pb-5">

                        <div class="row">

                            <div class="col-md-12">

                                <form action="<?=base_url('selfservices/add_request_overtime')?>" method='post'>

                                    <input type='hidden' value="<?=$this->session->userdata('SESS_USER_ID')?>" name='assigned_by'/>

                                    <input type='hidden' value="<?=$this->session->userdata('SESS_USER_ID')?>" name='empl_id'/>

                                   

                                    <label class="">Shift Type</label>

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

                                        <label class="required" for="input_date_ot">Shift Date</label>

                                        <input type="date" class="form-control" name="date_ot" id="input_date_ot"

                                             value="" required>

                                    </div>

                                    <!--<div class="form-group">-->

                                    <!--    <label class="required" for="input_time_out">Time Out</label>-->

                                    <!--    <input type="time" class="form-control" name="time_out" id="input_time_out"-->

                                    <!--        required value="">-->

                                    <!--</div>-->

                                    <div class="form-group">

                                        <label class="required" for="input_hours">Overtime Hours</label>

                                        <input type="number" required class="form-control " min="0" step="0.01" name="hours"

                                            id="input_hours" enabled="" value="">

                                    </div>

                                    <div class="form-group">

                                        <label class="" for="input_reason">Reason</label>

                                        <textarea name="reason" class="form-control" id="reason" rows="4" cols="50"

                                            enabled=""></textarea>

                                    </div>

                                    <input type='hidden' value='Pending 1' name='status'/>

                                    <!--<label class="">Status</label>-->

                                    <!--<div class="form-group">-->

                                    <!--    <select class="form-control" name="input_status" id="status" disabled="">-->

                                    <!--        <option>Pending 1</option>-->

                                    <!--        <option>Pending 2</option>-->

                                    <!--        <option>Pending 3</option>-->

                                    <!--        <option>Approved</option>-->

                                    <!--        <option>Rejected</option>-->

                                    <!--    </select>-->

                                    <!--</div>-->

                                    <!--<div class="form-group">-->

                                    <!--    <label class="" for="input_comment">Remarks</label>-->

                                    <!--    <textarea name="comment" class="form-control" id="comment" rows="4" cols="50"-->

                                    <!--        enabled=""></textarea>-->

                                    <!--</div>-->

                                    <div class="mr-2" style="float: right !important">

                                        <button id="btn_add" type='submit' class="btn technos-button-blue shadow-none rounded " ;="">

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

    <script>Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>','','success')</script>

<?php 

}

?>

<?php

if ($this->session->flashdata('ERR')) {

?>

    <script>Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>',

            '',

            'error'

        )

    </script>

<?php

}

?>