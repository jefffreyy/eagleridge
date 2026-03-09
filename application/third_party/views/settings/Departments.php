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
                        <li class="breadcrumb-item active" aria-current="page">Departments</li>
                    </ol>
                </nav>
                <div class="row pr-3 mb-2">
                    <div class="col">
                        <h1 class="page-title">Departments</h1>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                    </div>
                    <div class="col ml-auto">
                        <a class="btn btn-primary float-right" title="Add" href="#" data-toggle="modal" data-target="#modal_add_department"><i class="fas fa-fw fa-plus"></i> Add</a>
                    </div>
                </div>
                <div class="card">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Manager</th>
                                <th>Employees</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Finance</td>
                                <td></td>
                                <td>2</td>
                                <td class="">
                                    <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                            <a class="btn indigo lighten-2" title="Edit" href="#" data-toggle="modal" data-target="#modal_edit_department" ><i class="fas fa-edit"></i></a>
                                            <a class="btn indigo lighten-2" title="Delete" href="#"><i class="fas fa-trash text-danger"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Human Resources</td>
                                <td></td>
                                <td>1</td>
                                <td class="">
                                    <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                            <a class="btn indigo lighten-2" title="Edit" href="#" data-toggle="modal" data-target="#modal_edit_department" ><i class="fas fa-edit"></i></a>
                                            <a class="btn indigo lighten-2" title="Delete" href="#"><i class="fas fa-trash text-danger"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>IT</td>
                                <td></td>
                                <td>1</td>
                                <td class="">
                                    <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                            <a class="btn indigo lighten-2" title="Edit" href="#" data-toggle="modal" data-target="#modal_edit_department" ><i class="fas fa-edit"></i></a>
                                            <a class="btn indigo lighten-2" title="Delete" href="#"><i class="fas fa-trash text-danger"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Marketing</td>
                                <td></td>
                                <td>1</td>
                                <td class="">
                                    <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                            <a class="btn indigo lighten-2" title="Edit" href="#" data-toggle="modal" data-target="#modal_edit_department" ><i class="fas fa-edit"></i></a>
                                            <a class="btn indigo lighten-2" title="Delete" href="#"><i class="fas fa-trash text-danger"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Product</td>
                                <td></td>
                                <td>1</td>
                                <td class="">
                                    <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                            <a class="btn indigo lighten-2" title="Edit" href="#" data-toggle="modal" data-target="#modal_edit_department" ><i class="fas fa-edit"></i></a>
                                            <a class="btn indigo lighten-2" title="Delete" href="#"><i class="fas fa-trash text-danger"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Sales</td>
                                <td></td>
                                <td>0</td>
                                <td class="">
                                    <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                            <a class="btn indigo lighten-2" title="Edit" href="#" data-toggle="modal" data-target="#modal_edit_department" ><i class="fas fa-edit"></i></a>
                                            <a class="btn indigo lighten-2" title="Delete" href="#"><i class="fas fa-trash text-danger"></i></a>
                                        </div>
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

     <!-- Add offboard -->
     <div class="modal fade" id="modal_add_department" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Departments</h4>
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
                                <div class="form-group">
                                    <label for="parent_department">Parent Department</label>
                                    <select name="parent_department" id="parent_department" class="form-control">
                                        <option value="">--None--</option>
                                        <option value="Finance">Finance</option>
                                        <option value="Human Resources">Human Resources</option>
                                        <option value="IT">IT</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="Product">Product</option>
                                        <option value="Sales">Sales</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="asset_code">Manager</label>
                                    <input class="form-control form-control" type="text" name="asset_code" id="asset_code">
                                </div>
                            </div>
                            <input type="hidden" name="contact_id" id="contact_number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class='btn btn-primary text-light' id="btn_updateContact">&nbsp; Save</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

     <!-- edit offboard -->
     <div class="modal fade" id="modal_edit_department" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Departments</h4>
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
                                <div class="form-group">
                                    <label for="parent_department">Parent Department</label>
                                    <select name="parent_department" id="parent_department" class="form-control">
                                        <option value="">--None--</option>
                                        <option value="Finance">Finance</option>
                                        <option value="Human Resources">Human Resources</option>
                                        <option value="IT">IT</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="Product">Product</option>
                                        <option value="Sales">Sales</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="asset_code">Manager</label>
                                    <input class="form-control form-control" type="text" name="asset_code" id="asset_code">
                                </div>
                            </div>
                            <input type="hidden" name="contact_id" id="contact_number">
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

            $('i.fa.fa-rotate-left').attr('class')
        });
    </script>

</body>
</html>
