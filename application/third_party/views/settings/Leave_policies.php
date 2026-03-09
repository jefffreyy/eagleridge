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
        padding: 6.8px 20px !important;
    }

    label.required::after{
        content:" *";
        color: red;
    }

    .table-active {
        background-color: #fff;
    }
    .table-active:hover {
        background-color: #fff !important;
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
    <!-- Icon Picker -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
    <link rel="stylesheet" href="<?=base_url()?>icon_picker/dist/css/bootstrap-iconpicker.min.css"/>
    <!-- Color Picker -->
    <link rel="stylesheet" href="<?=base_url()?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">


	<div class="content-wrapper">
		<div class="p-3">
            <div class="flex-fill">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?=base_url()?>settings">Settings</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Leave Policies</li>
                    </ol>
                </nav>
                <div class="row pr-3 mb-2">
                    <div class="col">
                        <h1 class="page-title">Leave Policies</h1>
                    </div>
                </div>
                <div class="d-flex flex-row-reverse mb-2">
                    <div>
                        <a class="btn btn-light mr-2" href="<?= base_url()?>settings/leave_policies_bulk">Bulk Operations</a>
                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal_add_leave_type"><i class="fas fa-plus mr-2"></i> Add Leave Type</a>
                    </div>
                </div>
                <div class="card">

                    <table class="table table-xs mb-0 table-hover" data-controller="sortable">
                        
                        <tbody class="draggable" style="">
                        <tr class=" table-active">
                        <td>
                            <i class="fas fa-bars mr-2 handle"></i>
                            <i class="fas fa-plane fa-2x mb-2 mr-2" style="color: #000000;"></i>  Annual Leave
                            -
                            <span class="text-muted">Tracking in days</span>
                        </td>
                        <td></td>
                        <td></td>
                        <td class="text-right">

                            <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group btn-group-sm" role="group" aria-label="First group">

                                <div data-toggle="tooltip" title="" data-original-title="Add Leave Policy" class="">
                                <a href="#" class="btn text-black-50" data-toggle="dropdown" aria-expanded="false" draggable="false">
                                    <i class="fas fa-plus"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" style="">
                                    <a class="dropdown-item" href="#" draggable="false">Accrued</a>
                                    <a class="dropdown-item" href="#" draggable="false">Manually Tracked</a>

                                </div>
                                </div>

                                <div class="">
                                <a href="#" class="btn text-black-50" data-toggle="dropdown" aria-expanded="false" draggable="false">
                                    <i class="fas  fa-ellipsis-v"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" style="">
                                    <a class="dropdown-item" data-remote="true" href="#" draggable="false">Edit</a>
                                    <a class="dropdown-item text-danger" title="Delete" data-confirm="Are you sure?" rel="nofollow" data-method="delete" href="https://erovoutika.peopleforce.io/settings/leave/types/7605" draggable="false">Delete</a>
                                </div>
                                </div>
                            </div>
                            </div>

                        </td>
                        </tr>
                            <tr>
                                <td>
                                    <div class="pl-3">Annual Leave - Full Time</div>
                                </td>
                                <td>Accrual</td>
                                <td class="text-right">7 employees</td>
                                <td class="text-right">
                                    <a href="#" class=" btn text-black-50" data-toggle="dropdown" aria-expanded="false" draggable="false">
                                        <i class="fas  fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" style="">
                                        <a class="dropdown-item" href="#" draggable="false">Edit</a>
                                        <a class="dropdown-item" rel="nofollow" data-method="post" href="#" draggable="false">Copy</a>
                                        <a class="dropdown-item" rel="nofollow" data-method="post" href="#" draggable="false">Assign Default</a>
                                        <a class="dropdown-item text-danger" title="Delete" href="@">Delete</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="pl-3">Mental Health Leave</div>
                                </td>
                                <td>Manual</td>
                                <td class="text-right">1 employees</td>
                                <td class="text-right">
                                    <a href="#" class=" btn text-black-50" data-toggle="dropdown" aria-expanded="false" draggable="false">
                                        <i class="fas  fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Edit</a>
                                        <a class="dropdown-item" rel="nofollow" href="#" draggable="false">Copy</a>
                                        <a class="dropdown-item" rel="nofollow" href="#">Assign Default</a>
                                        <a class="dropdown-item text-danger" title="Delete" href="#">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody class="draggable">
                        <tr class=" table-active">
                            <td>
                                <i class="fas fa-bars mr-2 handle"></i>
                                <i class="fas fa-briefcase-medical fa-2x mb-2 mr-2" style="color: #000000;"></i>  Sick Leave - <span class="text-muted">Tracking in days</span>
                            </td>
                            <td></td>
                            <td></td>
                            <td class="text-right">

                                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="First group">
                                        <div data-toggle="tooltip" title="" class="">
                                            <a href="#" class="btn text-black-50" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" style="">
                                                <a class="dropdown-item" href="#">Accrued</a>
                                                <a class="dropdown-item" href="#">Manually Tracked</a>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="#" class="btn text-black-50" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fas  fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" data-remote="true" href="#">Edit</a>
                                                <a class="dropdown-item text-danger" title="Delete" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                            <tr>
                                <td>
                                    <div class="pl-3">Sick Leave - Full Time</div>
                                </td>
                                <td>Accrual</td>
                                <td class="text-right"> 0 employees</td>
                                <td class="text-right">
                                    <a href="#" class=" btn text-black-50" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas  fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Edit</a>
                                        <a class="dropdown-item" rel="nofollow" data-method="post" href="#">Copy</a>
                                        <a class="dropdown-item" rel="nofollow" data-method="post" href="#">Assign Default</a>
                                        <a class="dropdown-item text-danger" title="Delete" href="#">Delete</a>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                        <tbody class="draggable">
                            <tr class="table-active">
                                <td>
                                    <i class="fas fa-bars mr-2 handle"></i>
                                    <i class="fas fa-eject fa-2x mb-2 mr-2" style="color: #000000;"></i>  Without Pay - <span class="text-muted">Tracking in days</span>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="text-right">
                                    <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="First group">
                                            <div data-toggle="tooltip" title="Add Leave Policy">
                                                <a href="#" class="btn text-black-50" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#">Accrued</a>
                                                    <a class="dropdown-item" href="#">Manually Tracked</a>

                                                </div>
                                            </div>
                                            <div>
                                                <a href="#" class="btn text-black-50" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas  fa-ellipsis-v"></i>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#">Edit</a>
                                                    <a class="dropdown-item text-danger" title="Delete" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div class="pl-3 text-muted">
                                        No policies have been created yet.
                                    </div>
                                </td>
                            </tr>
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

    <!-- Add Leasve Type -->
    <div class="modal fade" id="modal_add_leave_type" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Leave Type</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('contacts/update_contact'); ?>" id="update_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required " for="asset_code">Name</label>
                                    <input class="form-control form-control " type="text" name="asset_code" id="asset_code">
                                </div>
                            </div>
                            <input type="hidden" name="contact_id" id="contact_number">
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                <label for="leave_type_tracking_time_in">Tracking Time In</label>
                                <div>
                                    <select class="form-control custom-select" name="leave_type[tracking_time_in]" id="leave_type_tracking_time_in">
                                    <option selected="selected" value="hours">Hours</option>
                                    <option value="days">Days</option></select></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-1 pr-0">
                                        <div class="form-group">
                                            <label for="btn_add_icon">Icon</label>
                                            <div class="form-inline">
                                                <button class="btn btn-default" id="btn_add_icon" role="iconpicker"></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="btn_add_icon" style="font-weight: 500">with color:</label>
                                        <div class="input-group color_picker colorpicker-element" data-colorpicker-id="2">
                                            <input type="text" class="form-control" data-original-title="" title="" aria-describedby="popover706594">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-square"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class='btn btn-primary text-light' id="btn_updateContact">&nbsp; Save</a>
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
    <!-- Icon Picker -->
    <script type="text/javascript" src="<?=base_url()?>icon_picker/dist/js/bootstrap-iconpicker.bundle.min.js"></script>
    <!-- Color Picker -->
    <script src="<?=base_url()?>plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Font Icon Picker -->
    <script>
        $('#e3_element').iconpicker();
    </script>
    <!-- Include Editor JS files. -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/js/froala_editor.pkgd.min.js"></script>
     <!-- Initialize the editor. -->
     <script>
        $(function() {
            $('div#froala-editor').froalaEditor({
            // Set custom buttons with separator between them.
            toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting','html'],
            toolbarButtonsXS: ['undo', 'redo' , '-', 'bold', 'italic','html']
            })

            $('i.fa.fa-rotate-left').attr('class');
        });
    </script>
    <script>
        $('.color_picker').colorpicker();
        $('.color_picker').on('colorpickerChange', function(event) {
            $('.color_picker .fa-square').css('color', event.color.toString());
        })
    </script>
</body>
</html>
