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
</style>

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
                                        <option value = "<?=base_url()?>tasks/tasks_created_by_me"">Created By Me</option>
                                        <option value = "<?=base_url()?>tasks/tasks_future">Future</option>
                                        <option value = "<?=base_url()?>tasks/tasks_completed" selected>Completed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class = "row">
                            <div class = "col">
                                <div class = "no-task">
                                    <i class="fas fa-list"></i>
                                     <span class = "no-found">No tasks found</span>
                                </div>
                            </div>
                        </div>
                   </div>
                </div>
                <!--<div class = "col-md-9">
                    <div class = "card border-0">
                        <div class = "row">
                            <div class = "col-md-9">
                                <span class = "">Sample Task</span>
                                <hr>
                                <div class = "row">
                                    <div class = "col">
                                     Task Discription
                                    </div>
                                </div>
                            </div>
                            <div class = "col-md-3" style = "text-align: right;">
                                <a href = "#" type = "button" class = "btn btn-primary">Complete</a>
                                <a href = "#" type = "button" class = "btn btn-light"><i class="fas fa-ellipsis-v"></i></a>
                                <div class = "row list">
                                    <div class = "col">
                                        <div class = "task-label">
                                            Type
                                        </div>
                                        <div class = "t-task">
                                            Task
                                        </div>
                                        <div class = "task-label">
                                            Assigned To
                                        </div>
                                        <div class = "t-task">
                                            Dela Cruz Juan
                                        </div>
                                        <div class = "task-label">
                                            Created By
                                        </div>
                                        <div class = "t-task">
                                            Dela Cruz Juan
                                        </div>
                                        <div class = "task-label">
                                            Starts on
                                        </div>
                                        <div class = "t-task">
                                            18.06.2021
                                        </div>
                                        <div class = "task-label">
                                        Ends on
                                        </div>
                                        <div class = "t-task">
                                        22.07.2021
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
                        <div id="froala-editor">
                            <p></p>
                        </div>
                    </div>
                    <div class = "row mt-4 mb-4">
                        <div class = "col">
                            <a href = "#" class = "btn btn-primary">Post Comment</a>
                        </div>
                    </div>
                </div>-->
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
                <form action="<?php echo base_url('tasks/add_task'); ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" class="form-control" name = "INSRT_TASK_TITLE" id="" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label for="">Task Type</label>
                            <input type="text" class="form-control" name = "INSRT_TASK_TYPE" id="" placeholder="Type">
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
                                        <input type="date" class="form-control float-right" id="" name = "INSRT_TASK_STARTS">
                                </div>
                            </div>
                            <div class = "col-md-6">
                                <div class="form-group mt-3">
                                    <label for="">Ends On</label>
                                        <input type="date" class="form-control float-right" id="" name = "INSRT_TASK_ENDS">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary pull-left">Save</button>
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
    <script>
        $(function() {
            $('div#froala-editor').froalaEditor({
            // Set custom buttons with separator between them.
            toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting','html'],
            toolbarButtonsXS: ['undo', 'redo' , '-', 'bold', 'italic','html']
            })

            $('i.fa.fa-rotate-left').attr('class')
            
            $('.fr-view').keyup(function(){
                var fr_text = $('.fr-view').text();
                $('#INSRT_TASK_DESC').val(fr_text);
            })
        });
    </script>
    

</body>
</html>
