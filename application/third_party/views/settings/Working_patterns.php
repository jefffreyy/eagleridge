<style>
    .btn-group .btn{
        padding: 0px 12px;
    }

    .page-title{
        font-weight: 600;
        color: #424F5C;
        font-size: 33px;
    }

    th,td{
        font-size: 13px !important;
    }

    label.required::after{
        content:" *";
        color: red;
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
		<div class="p-3">
            <div class="flex-fill">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?=base_url()?>settings">Settings</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Work Patterns</li>
                    </ol>
                </nav>
                <div class="row pr-3 mb-2">
                    <div class="col">
                        <h1 class="page-title">Work Patterns</h1>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <form class="new_q" id="new_q" action="#" accept-charset="UTF-8" method="get">
                        <div class="form-row align-items-center">
                            <div class="col mb-1">
                                <input autofocus="autofocus" class="form-control" placeholder="Search..." type="search" name="work_pattern_search" id="work_pattern_search">
                            </div>
                        </div>
                    </form>  </div>
                    <div class="col ml-auto">
                        <a class="btn btn-primary float-right" title="Add" href="#" data-toggle="modal" data-target="#modal_add_work_pattern"><i class="fas fa-fw fa-plus"></i> Add</a>
                    </div>
                </div>
                <div class="card">
                    <table class="table table-xs mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-right">Total Weekly (hrs)</th>
                                <th class="text-right">Employees</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            
                            if($DISP_WORKING_PATTERNS_INFO)
                            {
                                foreach($DISP_WORKING_PATTERNS_INFO as $ROW_WORKING_PATTERNS_INFO)
                                { 
                                    ?>
                        <?php if ($ROW_WORKING_PATTERNS_INFO->name == "Part Time"): ?>

                            <tr>
                                <td><?=$ROW_WORKING_PATTERNS_INFO->name?> &nbsp;<span class="badge badge-info"> Default</span></td>
                                <td class="text-right">
                                
                                    <?=
                                        $ROW_WORKING_PATTERNS_INFO->col_hours_monday + 
                                        $ROW_WORKING_PATTERNS_INFO->col_hours_tuesday +
                                        $ROW_WORKING_PATTERNS_INFO->col_hours_wednesday +
                                        $ROW_WORKING_PATTERNS_INFO->col_hours_thursday +
                                        $ROW_WORKING_PATTERNS_INFO->col_hours_friday +
                                        $ROW_WORKING_PATTERNS_INFO->col_hours_saturday +
                                        $ROW_WORKING_PATTERNS_INFO->col_hours_sunday
                                    ?>
                                
                                </td>

                                <td class="text-right"></td>
                                
                                <td class="">
                                    <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                        <a class="btn btn-sm indigo lighten-2" working_patterns_id="<?=$ROW_WORKING_PATTERNS_INFO->id?>" title="Edit" data-toggle="modal" data-target="#modal_edit_working_patterns" ><i class="fas fa-edit"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>        

                        <?php else: ?>
                            
                            <tr>
                                <td><?=$ROW_WORKING_PATTERNS_INFO->name?></td>
                                <td class="text-right">
                                
                                    <?=$ROW_WORKING_PATTERNS_INFO->col_hours_monday + 
                                    $ROW_WORKING_PATTERNS_INFO->col_hours_tuesday +
                                    $ROW_WORKING_PATTERNS_INFO->col_hours_wednesday +
                                    $ROW_WORKING_PATTERNS_INFO->col_hours_thursday +
                                    $ROW_WORKING_PATTERNS_INFO->col_hours_friday +
                                    $ROW_WORKING_PATTERNS_INFO->col_hours_saturday +
                                    $ROW_WORKING_PATTERNS_INFO->col_hours_sunday?>

                                </td>
                                <td class="text-right"></td>
                                <td class="">
                                    <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                            <a class="btn btn-sm indigo lighten-2" working_patterns_id="<?=$ROW_WORKING_PATTERNS_INFO->id?>" title="Edit" data-toggle="modal" data-target="#modal_edit_working_patterns" ><i class="fas fa-edit"></i></a>
                                            <a class="btn btn-sm indigo lighten-2 text-danger WORKING_PATTERNS_BTN_DLT" delete_key="<?=$ROW_WORKING_PATTERNS_INFO->id?>"><i class="fas fa-trash text-danger"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        <?php endif; ?>
                            
                            <?php
                                    }
                                } 
                                
                                else 
                                { 
                            ?>
                  
                            <tr>
                            <td colspan='3'>No Data Yet
                            </td>
                            </tr>
                            
                            <?php
                                }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- flex-fill -->
        </div>
        <!-- p-3 -->
	</div>
    <!-- content-wrapper -->



	<!-- Control Sidebar -->
	<aside class="control-sidebar control-sidebar-dark">
		<!-- Control sidebar content goes here -->
	</aside>
	<!-- /.control-sidebar -->

    <!-- Add work pattern -->
    <div class="modal fade" id="modal_add_work_pattern" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Working Pattern</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('settings/insrt_working_patterns'); ?>" id="WORK_PATTERNS_FORM_ADD" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required " for="asset_code">Name</label>
                                    <input class="form-control form-control " type="text" name="WORKING_PATTERNS_INPF_NAME" id="WORKING_PATTERNS_INPF_NAME">
                                </div>
                            </div>
                            <input type="hidden" name="contact_id" id="contact_number">
                        </div>
                        <table class="table table-xs">
                            <tbody>
                                <tr>
                                    <td>
                                    Monday
                                    </td>
                                    <td>
                                        <div class="form-row align-items-center">
                                            <div class="col-sm-3">
                                            <input min="0" class="form-control form-control" placeholder="0" type="number" value="0" name="WORKING_PATTERNS_INPF_MONDAY" id="WORKING_PATTERNS_INPF_MONDAY">
                                            </div>
                                            <div class="col-auto">
                                            Hours
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    Tuesday
                                    </td>
                                    <td>
                                        <div class="form-row align-items-center">
                                            <div class="col-sm-3">
                                            <input min="0" class="form-control form-control" placeholder="0" type="number" value="0" name="WORKING_PATTERNS_INPF_TUESDAY" id="WORKING_PATTERNS_INPF_TUESDAY">
                                            </div>
                                            <div class="col-auto">
                                            Hours
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    Wednesday
                                    </td>
                                    <td>
                                        <div class="form-row align-items-center">
                                            <div class="col-sm-3">
                                            <input min="0" class="form-control form-control" placeholder="0" type="number" value="0" name="WORKING_PATTERNS_INPF_WEDNESDAY" id="WORKING_PATTERNS_INPF_WEDNESDAY">
                                            </div>
                                            <div class="col-auto">
                                            Hours
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    Thursday
                                    </td>
                                    <td>
                                        <div class="form-row align-items-center">
                                            <div class="col-sm-3">
                                            <input min="0" class="form-control form-control" placeholder="0" type="number" value="0" name="WORKING_PATTERNS_INPF_THURSDAY" id="WORKING_PATTERNS_INPF_THURSDAY">
                                            </div>
                                            <div class="col-auto">
                                            Hours
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    Friday
                                    </td>
                                    <td>
                                        <div class="form-row align-items-center">
                                            <div class="col-sm-3">
                                            <input min="0" class="form-control form-control" placeholder="0" type="number" value="0" name="WORKING_PATTERNS_INPF_FRIDAY" id="WORKING_PATTERNS_INPF_FRIDAY">
                                            </div>
                                            <div class="col-auto">
                                            Hours
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    Saturday
                                    </td>
                                    <td>
                                        <div class="form-row align-items-center">
                                            <div class="col-sm-3">
                                            <input min="0" class="form-control form-control" placeholder="0" type="number" value="0" name="WORKING_PATTERNS_INPF_SATURDAY" id="WORKING_PATTERNS_INPF_SATURDAY">
                                            </div>
                                            <div class="col-auto">
                                            Hours
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    Sunday
                                    </td>
                                    <td>
                                    <div class="form-row align-items-center">
                                        <div class="col-sm-3">
                                        <input min="0" class="form-control form-control" placeholder="0" type="number" value="0" name="WORKING_PATTERNS_INPF_SUNDAY" id="WORKING_PATTERNS_INPF_SUNDAY">
                                        </div>
                                        <div class="col-auto">
                                        Hours
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class='btn btn-primary text-light' id="WORK_PATTERNS_BTN_SAVE">&nbsp; Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit work pattern -->
    <div class="modal fade" id="modal_edit_working_patterns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Working Pattern</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('settings/updt_working_patterns'); ?>" id="WORKING_PATTERNS_FORM_EDIT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required " for="asset_code">Name</label>
                                    <input class="form-control form-control " type="text" name="UPDT_WORKING_PATTERNS_INPF_NAME" id="UPDT_WORKING_PATTERNS_INPF_NAME" required>
                                </div>
                            </div>
                            <input type="hidden" name="UPDT_WORKING_PATTERNS_INPF_ID" id="UPDT_WORKING_PATTERNS_INPF_ID">
                        </div>
                        <table class="table table-xs">
                            <tbody>
                                <tr>
                                    <td>
                                    Monday
                                    </td>
                                    <td>
                                        <div class="form-row align-items-center">
                                            <div class="col-sm-3">
                                            <input min="0" class="form-control form-control" placeholder="0" type="number" value="0" name="UPDT_WORKING_PATTERNS_INPF_MONDAY" id="UPDT_WORKING_PATTERNS_INPF_MONDAY">
                                            </div>
                                            <div class="col-auto">
                                            Hours
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    Tuesday
                                    </td>
                                    <td>
                                        <div class="form-row align-items-center">
                                            <div class="col-sm-3">
                                            <input min="0" class="form-control form-control" placeholder="0" type="number" value="0" name="UPDT_WORKING_PATTERNS_INPF_TUESDAY" id="UPDT_WORKING_PATTERNS_INPF_TUESDAY">
                                            </div>
                                            <div class="col-auto">
                                            Hours
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    Wednesday
                                    </td>
                                    <td>
                                        <div class="form-row align-items-center">
                                            <div class="col-sm-3">
                                            <input min="0" class="form-control form-control" placeholder="0" type="number" value="0" name="UPDT_WORKING_PATTERNS_INPF_WEDNESDAY" id="UPDT_WORKING_PATTERNS_INPF_WEDNESDAY">
                                            </div>
                                            <div class="col-auto">
                                            Hours
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    Thursday
                                    </td>
                                    <td>
                                        <div class="form-row align-items-center">
                                            <div class="col-sm-3">
                                            <input min="0" class="form-control form-control" placeholder="0" type="number" value="0" name="UPDT_WORKING_PATTERNS_INPF_THURSDAY" id="UPDT_WORKING_PATTERNS_INPF_THURSDAY">
                                            </div>
                                            <div class="col-auto">
                                            Hours
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    Friday
                                    </td>
                                    <td>
                                        <div class="form-row align-items-center">
                                            <div class="col-sm-3">
                                            <input min="0" class="form-control form-control" placeholder="0" type="number" value="0" name="UPDT_WORKING_PATTERNS_INPF_FRIDAY" id="UPDT_WORKING_PATTERNS_INPF_FRIDAY">
                                            </div>
                                            <div class="col-auto">
                                            Hours
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    Saturday
                                    </td>
                                    <td>
                                        <div class="form-row align-items-center">
                                            <div class="col-sm-3">
                                            <input min="0" class="form-control form-control" placeholder="0" type="number" value="0" name="UPDT_WORKING_PATTERNS_INPF_SATURDAY" id="UPDT_WORKING_PATTERNS_INPF_SATURDAY">
                                            </div>
                                            <div class="col-auto">
                                            Hours
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    Sunday
                                    </td>
                                    <td>
                                    <div class="form-row align-items-center">
                                        <div class="col-sm-3">
                                        <input min="0" class="form-control form-control" placeholder="0" type="number" value="0" name="UPDT_WORKING_PATTERNS_INPF_SUNDAY" id="UPDT_WORKING_PATTERNS_INPF_SUNDAY">
                                        </div>
                                        <div class="col-auto">
                                        Hours
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <a class='btn btn-primary text-light' id="WORKING_PATTERNS_BTN_UPDT">&nbsp; Save</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

	<!-- LOGOUT MODAL -->
	<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?</p>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="text-white">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Hi are you sure you want to logout?</p>
				</div>
				<div class="modal-footer pb-1 pt-1">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<a href="<?php echo base_url().'login/logout'; ?>" class="btn btn-info">Logout</a>
				</div>
			</div>
		</div>
	</div>
	
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
    
    <!-- SESSION SUCCESS MESSAGE INSERT-->
    <?php
        
        if($this->session->userdata('SESS_SUCC_MSG_INSRT_WORKING_PATTERNS'))
        {
    ?>
    
    <script>
        
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_WORKING_PATTERNS'); ?>',
            '',
            'success'
        )
    
    </script>
        
    <?php
        
        $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_WORKING_PATTERNS');
        }
    ?>

    <!-- SESSION SUCCESS MESSAGE DELETE-->
    <?php
        
        if($this->session->userdata('SESS_SUCC_MSG_DLT_WORKING_PATTERNS'))
        {
    ?>
    
    <script>
        
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_WORKING_PATTERNS'); ?>',
            '',
            'success'
        )
    
    </script>
        
    <?php
        
        $this->session->unset_userdata('SESS_SUCC_MSG_DLT_WORKING_PATTERNS');
        }
    ?>

    <!-- SESSION SUCCESS MESSAGE UPDATE-->
    <?php
        
        if($this->session->userdata('SESS_SUCC_MSG_UPDT_WORKING_PATTERNS'))
        {
    ?>
    
    <script>
        
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_WORKING_PATTERNS'); ?>',
            '',
            'success'
        )
    
    </script>
        
    <?php
        
        $this->session->unset_userdata('SESS_SUCC_MSG_UPDT_WORKING_PATTERNS');
        }
    ?>
    
    <script>
    
        $(function() 
        {
            $('div#froala-editor').froalaEditor({
            // Set custom buttons with separator between them.
            toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting','html'],
            toolbarButtonsXS: ['undo', 'redo' , '-', 'bold', 'italic','html']
            })

            $('i.fa.fa-rotate-left').attr('class')
        });
    
    </script>

    <script>

        $(document).ready(function(){

        // Get & Display Data to Edit Modal Using Async JS function
        var url = '<?php echo base_url(); ?>settings/getwork_patternsData';
        const openModalButton = document.querySelectorAll('[data-target]');
        openModalButton.forEach(button => {
        button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.target);
        getwork_patternsData(url,button.getAttribute('working_patterns_id')).then(data => {
        if(data.length > 0)
        {
        data.forEach((x) => {
        document.getElementById('UPDT_WORKING_PATTERNS_INPF_ID').value = x.id;
        document.getElementById('UPDT_WORKING_PATTERNS_INPF_NAME').value = x.name;
        document.getElementById('UPDT_WORKING_PATTERNS_INPF_MONDAY').value = x.col_hours_monday;
        document.getElementById('UPDT_WORKING_PATTERNS_INPF_TUESDAY').value = x.col_hours_tuesday;
        document.getElementById('UPDT_WORKING_PATTERNS_INPF_WEDNESDAY').value = x.col_hours_wednesday;
        document.getElementById('UPDT_WORKING_PATTERNS_INPF_THURSDAY').value = x.col_hours_thursday;
        document.getElementById('UPDT_WORKING_PATTERNS_INPF_FRIDAY').value = x.col_hours_friday;
        document.getElementById('UPDT_WORKING_PATTERNS_INPF_SATURDAY').value = x.col_hours_saturday;
        document.getElementById('UPDT_WORKING_PATTERNS_INPF_SUNDAY').value = x.col_hours_sunday;
        });
        }
        });
        });
        });
        async function getwork_patternsData(url,working_patterns_id) {
        var formData = new FormData();
        formData.append('WORKING_PATTERNS_GET_WORKING_PATTERNS_DATA', working_patterns_id);
        const response = await fetch(url, {
        method: 'POST',
        body: formData
        });
        return response.json();
        }

        // Update Position
        $('#WORKING_PATTERNS_BTN_UPDT').click(function(e)
        {
            var working_patterns_name = $('#UPDT_WORKING_PATTERNS_INPF_NAME').val();
            var hasErr = 0;
            
            if(!working_patterns_name)
            {
                hasErr++;
            }
        
            if(hasErr == 0)
            {
                // $('#WORKING_PATTERNS_FORM_EDIT').submit();

                Swal.fire({
                    title: 'Do you want to save the following changes?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                    }).then((result) => 
                    {
                        if (result.isConfirmed) 
                        {
                            $('#WORKING_PATTERNS_FORM_EDIT').submit();
                        }
                    })
            } 
            
            else 
            {
                $('#UPDT_WORKING_PATTERNS_INPF_NAME').addClass('is-invalid');
            }
        })
        $('#UPDT_WORKING_PATTERNS_INPF_NAME').keyup(function(){
        $('#UPDT_WORKING_PATTERNS_INPF_NAME').removeClass('is-invalid');
        })

    
        // Delete Position
        $('.WORKING_PATTERNS_BTN_DLT').click(function(e){
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
        window.location.href = "<?= base_url(); ?>settings/dlt_working_patterns?delete_id="+user_deleteKey;
        }
        })
        })
    })

    
    </script>

</body>
</html>
