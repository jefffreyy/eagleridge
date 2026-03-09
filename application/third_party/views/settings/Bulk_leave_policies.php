<style>
    /* edited froala editor */
    .fr-toolbar{
        border-top: 1px solid #ccc !important;
        z-index: 0 !important;
        border-radius: 10px 10px 0px 0px !important;
    }
    .fr-wrapper{
        border-radius: 0px 0px 10px 10px !important;
        font-size: 14px !important;
        margin-bottom: 20px !important;
    }
    .fr-command{
        margin-top: 5px !important;
        margin-bottom: 5px !important;
    }
    .fr-counter{
        margin-right: 5px !important;
        border: none !important;
    }
    .fr-counter::before{
        content: 'Characters: ';
        font-family: inter,sans-serif;
    }
    #froala-editor{
        border-radius: 10px !important;
    }
    /* CSS for this page only */
    .active{
        font-weight: 600;
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
                <div class="row pr-3">
                    <div class="col">
                        <h1 class="page-title">Assets</h1>
                        <p class="plain-text">Manage company assets and assignments for your employees.</p>
                    </div>
                    <div class="ml-auto">
                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal_add_asset">
                            <i class="fas fa-plus mr-1"></i> New Asset
                        </a>    
                    </div>
                </div>
                <div class="row w-100 px-3 mb-2">
                    <div class="form-inline">
                        <div class="input-group mr-3">
                            <span class="input-group-prepend">
                                <div class="input-group-text bg-white border-right-0"><i class="fa fa-search text-muted"></i></div>
                            </span>
                            <input placeholder="Search..." class="form-control border-left-0" autofocus="autofocus" data-action="debounced:input->form#submit" type="search" name="criteria[query]" id="criteria_query">
                        </div>
                        <button class="btn btn-secondary dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-filter p-1"></i>&nbsp;&nbsp;Filter</button>
                        <div class="dropdown-menu js-dropdown-propagate-click" style="width: 400px;">
                            <div class="p-2">
                                <div class="mb-2">
                                    <input type="text" name="teams" id="teams" class="form-control w-100" placeholder="Category">
                                </div>
                                <div class="mb-2">
                                    <input type="text" name="department" id="department" class="form-control w-100" placeholder="Locations">
                                </div>
                                <div class="mb-2">
                                    <input type="text" name="divisions" id="divisions" class="form-control w-100" placeholder="Assigned To">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p>Displaying <strong>1 - 1</strong> of <strong>1</strong> in total</p>
                <div class="card">
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-xs table-striped table-nowrap table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th><a href="/asset/items?criteria%5Bdir%5D=asc&amp;criteria%5Bsort%5D=code">ID</a></th>
                                            <th><a href="/asset/items?criteria%5Bdir%5D=asc&amp;criteria%5Bsort%5D=name">Name</a></th>
                                            <th><a href="/asset/items?criteria%5Bdir%5D=asc&amp;criteria%5Bsort%5D=serial_number">Serial number</a></th>
                                            <th><a href="/asset/items?criteria%5Bdir%5D=asc&amp;criteria%5Bsort%5D=asset_category_name">Category</a></th>
                                            <th><a href="/asset/items?criteria%5Bdir%5D=asc&amp;criteria%5Bsort%5D=location_name">Location</a></th>
                                            <th><a href="/asset/items?criteria%5Bdir%5D=asc&amp;criteria%5Bsort%5D=warranty_expires_on">Warranty Expires On</a></th>
                                            <th>Assigned To</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="#">34432432432</a>
                                            </td>
                                            <td>Arduino</td>
                                            <td>1231asdasd</td>
                                            <td>Laptop</td>
                                            <td>Los Angeles</td>
                                            <td>16.06.2021</td>
                                            <td></td>
                                            <td>
                                                <a href="#" class="text-black-50" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas  fa-ellipsis-v"></i>
                                                    <span class="d-xl-none ml-2">Settings</span>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" title="Edit" href="#"><i class="fas fa-fw fa-edit"></i>Edit</a>
                                                    <a class="dropdown-item" title="Copy" data-method="get" href="#"><i class="fas fa-fw fa-copy"></i>Copy</a>
                                                    <a class="dropdown-item text-danger " title="Delete" rel="nofollow" href="#"><i class="fas fa-fw fa-trash"></i>Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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


    <div class="modal fade" id="modal_add_asset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Asset</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('contacts/update_contact'); ?>" id="update_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required " for="asset_code">ID</label>
                                    <input class="form-control form-control " type="text" name="asset_code" id="asset_code">
                                </div>
                                <div class="form-group">
                                    <label class="required " for="asset_code">Name</label>
                                    <input class="form-control form-control " type="text" name="asset_name" id="asset_name">
                                </div>
                                <div class="form-group">
                                    <label class="required " for="asset_code">Serial Number</label>
                                    <input class="form-control form-control " type="text" name="asset_serial" id="asset_serial">
                                </div>
                            </div>
                            <input type="hidden" name="contact_id" id="contact_number">
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="required" for="asset_location_id-tomselected" id="asset_location_id-ts-label">Category</label>
                                    <select name="asset_location" id="asset_location" class="form-control">
                                        <option value="7301">Desktop Computer</option>
                                        <option value="7302">Laptop</option>
                                        <option value="7303">Phone</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="required" for="asset_location_id-tomselected" id="asset_location_id-ts-label">Location</label>
                                    <select name="asset_location" id="asset_location" class="form-control">
                                        <option value="7301">London</option>
                                        <option value="7302">Melbourne</option>
                                        <option value="7303">New York</option>
                                        <option value="7303">Remote Workers</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="asset_code">Price</label>
                                    <input class="form-control " type="text" name="asset_price" id="asset_price">
                                </div>
                                <div class="form-group">
                                    <label for="asset_code">Warranty Expires On</label>
                                    <input class="form-control" type="date" name="asset_warranty" id="asset_warranty">
                                </div>
                                <div class="form-group">
                                    <label for="asset_code">Description</label>
                                    <!-- <div id="froala-editor">
                                        <p></p>
                                    </div> -->
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
