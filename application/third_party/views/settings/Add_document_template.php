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
    .btn-group .btn{
        padding: 0px 12px;
    }

    .page-title{
        font-weight: 600;
        color: #424F5C;
        font-size: 33px;
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
                        <li class="breadcrumb-item active" aria-current="page">Document Templates</li>
                    </ol>
                </nav>
                <div class="row pr-3 mb-2">
                    <div class="col">
                        <h1 class="page-title">Document Templates</h1>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-white header-elements-inline">
                        <h6 class="card-title">New Document Template</h6>
                    </div>

                    <div class="card-body">
                        <form class="new_document_template" id="new_document_template" action="#" accept-charset="UTF-8" method="post">
                            <input type="hidden" name="authenticity_token">
                            <div class="form-group">
                                <label class="required " for="document_template_name">Name</label>
                                <input class="form-control form-control " type="text" name="document_template[name]" id="document_template_name">
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <!-- <div id="froala-editor">
                                        <p></p>
                                    </div> -->
                                    <textarea name="INSRT_DOC_TEMPL" id="INSRT_DOC_TEMPL" class="form-control" cols="30" rows="5"></textarea>
                                </div>
                                <div class="col-md-3">
                                    <div>
                                        <img width="200" src="https://app.peopleforce.io/assets/undraw/searching-7773645ba90d2bf1525b50f23544d9b0b54e6a691aa6d981206655d12dc9fbb1.png">
                                    </div>
                                    <a target="_blank" href="https://peopleforce.crisp.help/ru/article/zameniteli-dlya-shablonov-dokumentov-sotrudnika-1cj9ys3">How to use merge fields in template?</a>
                                </div>
                            </div>
                            <input type="submit" name="commit" value="Save" class="btn btn-primary btn btn-primary" data-disable-with="Please Wait...">
                        </form>  
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
