<style>
    .card{
        padding: 20px;
    }
    li a{
        color: #0D74BC;
    }
    a:hover{
        text-decoration: none;
    }
    .activity td{
        padding: 6.8px 20px;
    }
    .page-item .active{
        background-color: #0D74BC !important;
    }
    label.required:after {
        content: " *";
    }

    label.required:after {
        content: " *";
        color: red;
    }
    li a{
        font-size: 14px;
    }
    .header-elements a{
        font-size: 14px;
    }
    .list-icons a{
        font-size: 11.2px;
        color: #197fc7;
    }
    .profile{
        padding: 20px 0px 0px;
    }
    .profile-img{
        display: inline-block;
        float: left;
        padding-right: 20px;
    }
    .profile-disc{
        margin-left: 100px;
    }
    .profile-name{
        font-weight: bold;
        font-size:16px;
        color: black;
    }
    .position{
        font-weight: bold;
        font-size: 15px;
        color: #B0B0B0;
    }
    .divider{
        margin-top: 50px;
    }
    .social-div a{
        padding: 10px 15px;
        color: #6a6a6a;
        font-size: 15px;
    }
    .label-note{
        background-color: #fde6d8;
        padding: 5px 10px;
        border-radius: 30px;
        color: #c46632;
        font-weight: bold;
        text-align: center;
        line-height: normal;
    }
    table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
   
    }
    th, td {
    text-align: left;
    padding: 8px;
    font-size: 14px;
    font-weight: normal;
    }
    .modal-btn{
        display: flex;
        float: right;
    }
    .no-task{
        padding: 14px 14px;
        font-size: 50px;
        text-align: center;
    }
    .no-found{
        font-size: 14px; 
        display: block;
    }
    .no-task, .no-found{
        color: #b9b9b9;
    }
    .row.list{
        display: block;
        text-align: left;
        margin-bottom: 15px;
    }
    .task-label{
        margin-top: 5px;
        font-weight: bold;
        font-size: 15px;
        display: block;
    }
    .t-stask{
        display: block;
        font-size: 20px;
        margin-top: 5px;
    }
    .mini-nav{
		width: 100%;
		margin-top: -15px;
        margin-left: 20px;
	}
	.mini-links.active{
		border-color: #1279bf;
		border-bottom-style: solid;
	}
    .mini-links.active:hover{
		border-color: #1279bf;
		border-bottom-style: solid;
	}
	.mini-nav a{
		display: block;
		float: left;
		padding: 10px 15px;
		text-decoration: none;
		color: black;
	}
	.mini-nav a:hover{
		border-color: #e2e2e2;
		border-bottom-style: solid;
	}
    .have-task{
        color: black;
        margin: 0px -20px 0px -20px;
        padding: 10px 20px;
    }
    .have-task:hover{
        background-color:#f3f3f3;
    }
    .task-title{
        display: block;

    }
    .task-ends{
        display: block;
        font-size: 12px;
    }
    .task-assigned{
        display: block;
        font-size: 12px;
        color: #929292;
    }
</style>
<?php 
$UPDT_TASK_ID = $UPDT_TASK_TITLE = $UPDT_TASK_TYPE = $UPDT_TASK_ASSIGNED = $full_Name = "";
if($SPECIFIC_TASK=='true'){
    foreach($DISP_TASK_LIST as $DISP_TASK_LIST_ROW1){
        $UPDT_TASK_ID = $DISP_TASK_LIST_ROW1->id;
        $UPDT_TASK_TITLE = $DISP_TASK_LIST_ROW1->col_task_title;
        $UPDT_TASK_TYPE = $DISP_TASK_LIST_ROW1->col_task_type;
        $UPDT_TASK_ASSIGNED = $DISP_TASK_LIST_ROW1->col_task_assigned_to;
        $UPDT_TASK_STARTS = $DISP_TASK_LIST_ROW1->col_task_start;
        $UPDT_TASK_ENDS = $DISP_TASK_LIST_ROW1->col_task_end;
        $UPDT_TASK_DESCRIPTION = $DISP_TASK_LIST_ROW1->col_task_comments;

        $UPDT_EMPLOYEE_ID = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_TASK_LIST_ROW1->col_task_assigned_to);
        $fName = $UPDT_EMPLOYEE_ID[0]->col_frst_name;
        $lName = $UPDT_EMPLOYEE_ID[0]->col_last_name;
        $full_Name = $fName.' '.$lName;
    }
}

?>
<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">

   <!-- Code Mirror -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
    <!-- Include Editor style. -->
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_style.min.css" rel="stylesheet" type="text/css" />
	
    <div class="content-wrapper">
		<div class="container-fluid p-4">
            <div class="row">
                <div class = "col-md-3">
                   <div class = "card border-0">
                        <div class="row mb-3">
                            <div class = "col-md-4 my-auto">
                                <div class = "card-title">Tasks</div>
                            </div>
                            <div class = "col-md-8">
                                <div class = "modal-btn"><a href = "#" class = "btn btn-primary" data-target = "#modal_task" data-toggle = "modal"><i class="fas fa-plus mr-2"></i>Add</a></div>
                            </div>
                        </div>
                        <div class = "row">
                            <div class = "col" style = "padding: 0px 0px 0px 0px;">
                                <div class="form-group">
                                    <select class="form-control" id="" onchange="location = this.value;">
                                        <option value = "tasks">Tasks Assigned To Me</option>
                                        <option value = "" selected>Created By Me</option>
                                        <option value = "<?=base_url()?>tasks/tasks_future">Future</option>
                                        <option value = "<?=base_url()?>tasks/tasks_completed">Completed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class = "row">
                            <div class = "col">
                                <?php 
                                if($DISP_TASK_LIST){
                                    foreach($DISP_TASK_LIST as $DISP_TASK_LIST_ROW){
                                    $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_TASK_LIST_ROW->col_task_assigned_to);
                                    $created_by = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_TASK_LIST_ROW->col_task_created_by);
                                    
                                    $fnameCreated = $created_by[0]->col_frst_name;
                                    $lnameCreated = $created_by[0]->col_last_name;
                                    $task_creator = $fnameCreated.' '.$lnameCreated;

                                    $firstName = $employee_id[0]->col_frst_name;
                                    $lastName = $employee_id[0]->col_last_name;
                                    $fullname = $firstName.' '.$lastName;
                                ?>

                                <a href = "<?= base_url()?>tasks/tasks_created_by_me_specific?id=<?=$DISP_TASK_LIST_ROW->id;?>">
                                    <div class = "have-task">
                                        <div class = "task-title"><?=$DISP_TASK_LIST_ROW->col_task_title;?></div>
                                        <div class = "task-ends"><i class="far fa-calendar-alt mr-2"></i><?=$DISP_TASK_LIST_ROW->col_task_end;?></div>
                                        <div class = "task-assigned"><i class="fas fa-user mr-2"></i><?=$fullname;?></div>
                                    </div>
                                </a>
                               <?php 
                                    }
                                }else{
                                    echo '
                                    <div class = "no-task">
                                        <i class="fas fa-list"></i>
                                        <span class = "no-found">No tasks found</span>
                                    </div>
                                    ';
                                }
                               ?>
                            </div>
                        </div>
                   </div>
                </div>
                <?php 
                    if($SPECIFIC_TASK=='true'){
                        foreach($DISP_TASK_LIST as $DISP_TASK_LIST_ROWs){
                ?>
                <div class = "col-md-9">
                    <div class = "card border-0">
                        <div class = "row">
                            <div class = "col-md-9">
                                <span class = ""><?=$DISP_TASK_LIST_ROWs->col_task_title;?></span>
                                <hr>
                                <div class = "row">
                                    <div class = "col">
                                        <?=$DISP_TASK_LIST_ROWs->col_task_comments;?>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-md-3" style = "text-align: right;">
                                <a href = "#" type = "button" class = "btn btn-primary">Complete</a>
                                <button class="btn btn-light" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <a class="dropdown-item" title="Edit" href="#" asset_id="<?= $DISP_TASK_LIST_ROWs->id ?>" data-toggle="modal" data-target="#modal_edit_task">Edit</a>
                                    <a class="dropdown-item text-danger BTN_DLT_TASK" title="Delete" href="#" rel="nofollow" delete_key="<?= $DISP_TASK_LIST_ROWs->id ?>">Delete</a>
                                </div>
                                <div class = "row list">
                                    <div class = "col">
                                        <div class = "task-label">
                                            Type
                                        </div>
                                        <div class = "t-task">
                                            <?=$DISP_TASK_LIST_ROWs->col_task_type;?>
                                        </div>
                                        <div class = "task-label">
                                            Assigned To
                                        </div>
                                        <div class = "t-task">
                                            <?=$fullname;?>
                                        </div>
                                        <div class = "task-label">
                                            Created By
                                        </div>
                                        <div class = "t-task">
                                            <?=$task_creator;?>
                                        </div>
                                        <div class = "task-label">
                                            Starts on
                                        </div>
                                        <div class = "t-task">
                                            <?=$DISP_TASK_LIST_ROWs->col_task_start;?>
                                        </div>
                                        <div class = "task-label">
                                        Ends on
                                        </div>
                                        <div class = "t-task">
                                            <?=$DISP_TASK_LIST_ROWs->col_task_end;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "row mt-4 mb-4">
                        <div class = "mini-nav">
                            <a href = "#" class = "mini-links active">Comments</a>
                            <a href = "#" class = "mini-links">History</a>
                        </div>
                    </div>
                    <div class = "card border-0">
                        <!-- <div id="froala-editor">
                            <p></p>
                        </div> -->
                        <textarea name="INSRT_TASK_COMMENT" id="INSRT_TASK_COMMENT" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <div class = "row mt-4 mb-4">
                        <div class = "col">
                            <a href = "#" class = "btn btn-primary">Post Comment</a>
                        </div>
                    </div>
                </div>
                <?php 
                        }
                    }
                ?>
            </div>
        </div>
	</div>
    <!-- Modal -->
    <div class="modal fade" id="modal_task" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">New Task</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('tasks/add_task'); ?>" id="add_task_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" class="form-control" name = "INSRT_TASK_TITLE" id="INSRT_TASK_TITLE" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label for="">Task Type</label>
                            <select name="INSRT_TASK_TYPE" id="INSRT_TASK_TYPE" class="form-control">
                                <option value="">Choose...</option>
                                <option value="Task">Task</option>
                                <option value="Onboarding Task">Onboarding Task</option>
                                <option value="Offboarding Task">Offboarding Task</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Assigned To</label>
                            <select class="form-control" id="exampleFormControlSelect1" name = "INSRT_TASK_ASSIGNED">
                                <option>--Select--</option>
                                <?php 
                                foreach($DISP_EMP_LIST as $DISP_EMP_LIST_ROW){
                                    
                                    ?>
                                    <option value = "<?=$DISP_EMP_LIST_ROW->id?>"><?=$DISP_EMP_LIST_ROW->col_frst_name.' '.$DISP_EMP_LIST_ROW->col_last_name;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class = "form-group">
                            <label>Description</label>
                            <!-- <div id="froala-editor">
                                <p></p>
                            </div> -->
                            <textarea name="INSRT_TASK_DESC" id="INSRT_TASK_DESC" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <div class = "row">
                            <div class = "col-md-6">
                                <div class="form-group mt-2">
                                    <label for="">Starts On</label>
                                        <input type="date" class="form-control float-right" id="INSRT_TASK_STARTS" name = "INSRT_TASK_STARTS">
                                </div>
                            </div>
                            <div class = "col-md-6">
                                <div class="form-group mt-3">
                                    <label for="">Ends On</label>
                                        <input type="date" class="form-control float-right" id="INSRT_TASK_ENDS" name = "INSRT_TASK_ENDS">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <input type="hidden" name = "USER_ID" value = "<?=$this->session->userdata('SESS_USER_ID')?>">
                        <button type="submit" class="btn btn-primary pull-left">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit TASK -->
    <div class="modal fade" id="modal_edit_task" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Task</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('tasks/edit_task'); ?>" id="edit_task_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" class="form-control" name = "UPDT_TASK_TITLE" id="UPDT_TASK_TITLE" value = "<?=$UPDT_TASK_TITLE;?>" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label for="">Task Type</label>
                            <select name="UPDT_TASK_TYPE" id="UPDT_TASK_TYPE" class="form-control" value = "<?=$UPDT_TASK_TYPE;?>">
                                <option value = "<?=$UPDT_TASK_TYPE;?>"><?=$UPDT_TASK_TYPE;?></option>
                                <option value="Task">Task</option>
                                <option value="Onboarding Task">Onboarding Task</option>
                                <option value="Offboarding Task">Offboarding Task</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Assigned To</label>
                            <select class="form-control" id="UPDT_TASK_ASSIGNED" name = "UPDT_TASK_ASSIGNED" value = "<?=$UPDT_TASK_ASSIGNED;?>">
                                <option value = "<?=$UPDT_TASK_ASSIGNED;?>"><?=$full_Name;?></option>
                                <?php 
                                foreach($DISP_EMP_LIST as $DISP_EMP_LIST_ROW){
                                    
                                    ?>
                                    <option value = "<?=$DISP_EMP_LIST_ROW->id?>"><?=$DISP_EMP_LIST_ROW->col_frst_name.' '.$DISP_EMP_LIST_ROW->col_last_name;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="UPDT_TASK_DESCRIPTION" id="UPDT_TASK_DESCRIPTION" value = "<?=$UPDT_TASK_DESCRIPTION;?>" class="form-control" cols="30" rows="10"><?=$UPDT_TASK_DESCRIPTION;?></textarea>
                        </div>
                        <div class = "row">
                            <div class = "col-md-6">
                                <div class="form-group mt-2">
                                    <label for="">Starts On</label>
                                        <input type="date" class="form-control float-right" id="UPDT_TASK_STARTS" name = "UPDT_TASK_STARTS" value = "<?=$UPDT_TASK_STARTS;?>">
                                </div>
                            </div>
                            <div class = "col-md-6">
                                <div class="form-group mt-3">
                                    <label for="">Ends On</label>
                                        <input type="date" class="form-control float-right" id="UPDT_TASK_ENDS" name = "UPDT_TASK_ENDS" value = "<?=$UPDT_TASK_ENDS;?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <input type="hidden" name = "UPDT_TASK_KEY" id = "UPDT_TASK_KEY" value = "<?=$UPDT_TASK_ID;?>">
                        <a class='btn btn-primary' id="BTN_TASK_UPDT">Save</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<aside class="control-sidebar control-sidebar-dark">
	</aside>
	<script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        
    </script>
	<!-- jQuery -->
	<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	$.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- jQuery Knob Chart -->
	<script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js"></script>
	<!-- Summernote -->
	<script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js"></script>
	<!-- overlayScrollbars -->
	<script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>
	<!-- Full Calendar 2.2.5 -->
	<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js"></script>
	<!-- Sweet Alert -->
	<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
	<!-- Toastr -->
	<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
    <!-- Include Editor JS files. -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/js/froala_editor.pkgd.min.js"></script>

    <!-- Initialize the editor. -->
    <?php
    if($this->session->userdata('SESS_SUCC_INSRT_TASKS')){
    ?>
    <script>
    Swal.fire(
        '<?php echo $this->session->userdata('SESS_SUCC_INSRT_TASKS'); ?>',
        '',
        'success'
    )
    </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_INSRT_TASKS');
    }
    ?>
    <?php
    if($this->session->userdata('SESS_SUCC_UPDT_TASK')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_UPDT_TASK'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_UPDT_TASK');
    }
    ?>
    <?php
    if($this->session->userdata('SESS_SUCC_MSG_DLT_TASK')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_TASK'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_DLT_TASK');
    }
    ?>
    <script>
        $(function() {
           /*  $('div#froala-editor').froalaEditor({
            // Set custom buttons with separator between them.
            toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting','html'],
            toolbarButtonsXS: ['undo', 'redo' , '-', 'bold', 'italic','html']
            })

            $('i.fa.fa-rotate-left').attr('class')
            
            $('.fr-view').keyup(function(){
                var fr_text = $('.fr-view').text();
                $('#INSRT_TASK_DESC').val(fr_text);
            }) */

            // Update TASK
            $('#BTN_TASK_UPDT').click(function(){
                var task_title = $('#UPDT_TASK_TITLE').val();
                var task_type = $('#UPDT_TASK_TYPE').val();
                var task_starts = $('#UPDT_TASK_STARTS').val();
                var task_ends = $('#UPDT_TASK_ENDS').val();
                var task_assigned = $('#UPDT_TASK_ASSIGNED').val();
                var task_description = $('#UPDT_TASK_DESCRIPTION').val();
                var hasErr = 0;
                if(!task_title){
                    $('#UPDT_TASK_TITLE').addClass('is-invalid');
                    hasErr++;
                    console.log('error_task_title');
                }
                if(!task_type){
                    $('#UPDT_TASK_TYPE').addClass('is-invalid');
                    hasErr++;
                    console.log('error_task_type');
                }
                if(!task_starts){
                    $('#UPDT_TASK_STARTS').addClass('is-invalid');
                    hasErr++;
                    console.log('error_task_starts');
                }
                if(!task_ends){
                    $('#UPDT_TASK_ENDS').addClass('is-invalid');
                    hasErr++;
                    console.log('error_task_ends');
                }
                if(!task_assigned){
                    $('#UPDT_TASK_ASSIGNED').addClass('is-invalid');
                    hasErr++;
                    console.log('error_task_assigned');
                }
                if(!task_description){
                    $('#UPDT_TASK_DESCRIPTION').addClass('is-invalid');
                    hasErr++;
                    console.log('error_task_description');
                }
                if(hasErr == 0){
                    Swal.fire({
                    title: 'Do you want to save the following changes?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#edit_task_form').submit();
                        }
                    })
                }
            })

            $('#UPDT_TASK_TITLE').keyup(function(){
                $('#UPDT_TASK_TITLE').removeClass('is-invalid');
            })
            $('#UPDT_TASK_TYPE').keyup(function(){
                $('#UPDT_TASK_TYPE').removeClass('is-invalid');
            })
            $('#UPDT_TASK_STARTS').keyup(function(){
                $('#UPDT_TASK_STARTS').removeClass('is-invalid');
            })
            $('#UPDT_TASK_ENDS').keyup(function(){
                $('#UPDT_TASK_ENDS').removeClass('is-invalid');
            })
            $('#UPDT_TASK_ASSIGNED').keyup(function(){
                $('#UPDT_TASK_ASSIGNED').removeClass('is-invalid');
            })
            $('#UPDT_TASK_DESCRIPTION').keyup(function(){
                $('#UPDT_TASK_DESCRIPTION').removeClass('is-invalid');
            })

            // Delete TASK
            $('.BTN_DLT_TASK').click(function(e){
                e.preventDefault();
                var user_deleteKey = $(this).attr('delete_key');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                    window.location.href = "<?= base_url(); ?>tasks/dlt_task?delete_id="+user_deleteKey;
                    }
                })
            })
        });
    </script>
    

</body>
</html>
