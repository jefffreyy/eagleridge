<html>
<?php $this->load->view('templates/css_link'); ?>

<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() . 'attendances' ?>">Attendance</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() . 'attendances/approval_routes' ?>">Overtime Approval Route</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add&nbsp;Approval
                    </li>
                </ol>
            </nav>
            <div class="row d-flex justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?=base_url().'attendances/add_approval_data'?>" method="POST">
                                        
                                        <div class="form-group ">
                                            <label class="required">Employee Name</label>
                                            <select class="form-control" name="insrt_name" id="insrt_name" required>
                                                <option value="">Please Choose Employee</option>
                                                <?php if($DISP_EMPLOYEES){ 
                                                foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){?>
                                                <option value="<?=$DISP_EMPLOYEES_ROW->id?>"><?=$DISP_EMPLOYEES_ROW->col_last_name.' '.$DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_midl_name ?></option>
                                                <?php }  }?>
                                            </select>
                                        </div>

                                        <label class="">Apporver 1A</label>
                                        <div class="form-group">
                                            <select class="form-control" name="insrt_approver_1a" id="insrt_approver_1a">
                                                <option value="">Apporver 1A</option>
                                                <?php if($DISP_EMPLOYEES){ 
                                                foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){?>
                                                <option value="<?=$DISP_EMPLOYEES_ROW->id?>"><?=$DISP_EMPLOYEES_ROW->col_last_name.' '.$DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_midl_name ?></option>
                                                <?php }  }?>
                                            </select>
                                        </div>

                                        <label class="">Apporver 1B</label>
                                        <div class="form-group">
                                            <select class="form-control" name="insrt_approver_1b" id="insrt_approver_1b">
                                            <option value="">Apporver 1B</option>
                                                <?php if($DISP_EMPLOYEES){ 
                                                foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){?>
                                                <option value="<?=$DISP_EMPLOYEES_ROW->id?>"><?=$DISP_EMPLOYEES_ROW->col_last_name.' '.$DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_midl_name ?></option>
                                                <?php }  }?>
                                            </select>
                                        </div>

                                        <label class="">Apporver 2A</label>
                                        <div class="form-group">
                                            <select class="form-control" name="insrt_approver_2a" id="insrt_approver_2a">
                                            <option value="">Apporver 2A</option>
                                            <?php if($DISP_EMPLOYEES){ 
                                                foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){?>
                                                <option value="<?=$DISP_EMPLOYEES_ROW->id?>"><?=$DISP_EMPLOYEES_ROW->col_last_name.' '.$DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_midl_name ?></option>
                                                <?php }  }?>
                                            </select>
                                        </div>

                                        <label class="">Apporver 2B</label>
                                        <div class="form-group">
                                            <select class="form-control" name="insrt_approver_2b" id="insrt_approver_2b">
                                            <option value="">Apporver 2B</option>
                                            <?php if($DISP_EMPLOYEES){ 
                                                foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){?>
                                                <option value="<?=$DISP_EMPLOYEES_ROW->id?>"><?=$DISP_EMPLOYEES_ROW->col_last_name.' '.$DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_midl_name ?></option>
                                                <?php }  }?>
                                            </select>
                                        </div>

                                        <label class="">Apporver 3A</label>
                                        <div class="form-group">
                                            <select class="form-control" name="insrt_approver_3a" id="insrt_approver_3a">
                                            <option value="">Apporver 3A</option>
                                            <?php if($DISP_EMPLOYEES){ 
                                                foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){?>
                                                <option value="<?=$DISP_EMPLOYEES_ROW->id?>"><?=$DISP_EMPLOYEES_ROW->col_last_name.' '.$DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_midl_name ?></option>
                                                <?php }  }?>
                                            </select>
                                        </div>

                                        <label class="">Apporver 3B</label>
                                        <div class="form-group">
                                            <select class="form-control" name="insrt_approver_3b" id="insrt_approver_3b" >
                                            <option value="">Apporver 3B</option>
                                            <?php if($DISP_EMPLOYEES){ 
                                                foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){?>
                                                <option value="<?=$DISP_EMPLOYEES_ROW->id?>"><?=$DISP_EMPLOYEES_ROW->col_last_name.' '.$DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_midl_name ?></option>
                                                <?php }  }?>
                                            </select>
                                        </div>

                                        <div class="mr-2" style="float: right !important">
                                            <input type="submit" class="btn technos-button-green shadow-none rounded " value="Submit">
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
    <script>

    </script>
</body>

</html>