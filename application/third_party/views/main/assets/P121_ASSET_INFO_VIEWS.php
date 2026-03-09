<style>
    .card{
        padding: 0px 14px 10px;
    }
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

    th{
        padding-bottom: 10px !important;
        border-top: none !important;
        border-bottom: none !important;
    }

    label.required::after{
        content:" *";
        color: red;
    }

    label.radio_label{
        font-weight: normal !important;
    }
</style>


<?php 
    $user_id = '';

    $id='';
    $asset_name='';
    $asset_category='';
    $asset_location='';
    $asset_id='';
    $asset_serial='';
    $price='';
    $description='';
    $status='';
    $issued_on='';
    $assign_to='';

    if($DISP_ASSET_INFO){
        foreach($DISP_ASSET_INFO as $DISP_ASSET_INFO_ROW){
            $user_id = $this->session->userdata('SESS_USER_ID');

            $id = $DISP_ASSET_INFO_ROW->id;
            $asset_name = ucfirst($DISP_ASSET_INFO_ROW->col_asset_name);
            $asset_category = ucfirst($DISP_ASSET_INFO_ROW->col_asset_category);
            $asset_location = ucfirst($DISP_ASSET_INFO_ROW->col_asset_location);
            $asset_id = ucfirst($DISP_ASSET_INFO_ROW->col_asset_id);
            $asset_serial = $DISP_ASSET_INFO_ROW->col_asset_serial;
            $price = $DISP_ASSET_INFO_ROW->col_asset_price;
            $description = ucfirst($DISP_ASSET_INFO_ROW->col_asset_description);
            $status = $DISP_ASSET_INFO_ROW->col_asset_status;
            $issued_on = $DISP_ASSET_INFO_ROW->col_asset_issued_on;
            $assign_to = $DISP_ASSET_INFO_ROW->col_asset_assigned_to;
        }
    }
?>
	
	<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
    <!-- Code Mirror -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
    <!-- Include Editor style. -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_style.min.css" rel="stylesheet" type="text/css" /> -->

	<div class="content-wrapper">
		<div class="p-3">
            <div class="flex-fill">
                <div class="row pr-3">
                    <div class="col">
                        <h1 class="page-title"><?= $asset_name ?></h1>
                        <h4>Status: &nbsp;&nbsp;<?php if($status == 'in-use'){echo '<span class="text-success">In Use</span>';}else if($status == 'in-stockroom'){echo '<span class="text-warning">In Stock</span>';} ?></h4>
                    </div>
                    <div class="ml-auto">
                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal_add_asset">
                            <i class="fas fa-plus mr-1"></i> Assign
                        </a>    
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card mt-2">
                            <div class="block w-100 pl-4 pt-4">
                                <dt>Name</dt>
                                <dd><?= $asset_name ?></dd>
                            </div>
                            <div class="block w-100 pl-4 pt-3">
                                <dt>Category</dt>
                                <dd><?= $asset_category ?></dd>
                            </div>
                            <div class="block w-100 pl-4 pt-3">
                                <dt>Location</dt>
                                <dd><?= $asset_location ?></dd>
                            </div>
                            <div class="block w-100 pl-4 pt-3">
                                <dt>ID</dt>
                                <dd><?= $asset_id ?></dd>
                            </div>
                            <div class="block w-100 pl-4 pt-3">
                                <dt>Serial number</dt>
                                <dd><?= $asset_serial ?></dd>
                            </div>
                            <div class="block w-100 pl-4 pt-3">
                                <dt>Price</dt>
                                <dd>&#8369;&nbsp;<?= $price ?></dd>
                            </div>
                            <div class="block w-100 pl-4 pt-3">
                                <dt>Description</dt>
                                <dd><div class="trix-content">
                                    <div><?= $description ?></div>
                                </dd>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card mt-2">
                            <div class="card-header pl-2 py-4 bg-white header-elements-inline" style="border-bottom:none !important;">
                                <h6 class="card-title mb-0">
                                    Assignments
                                </h6>
                            </div>
                            <table class="table" style="border: none;">
                                <thead>
                                    <tr>
                                        <th>Assigned To</th>
                                        <th>Recieved On</th>
                                        <th>Transferred On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if($DISP_ASSET_LOGS){
                                            foreach($DISP_ASSET_LOGS as $DISP_ASSET_LOGS_ROW){ 
                                                $asset_info = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_ASSET_LOGS_ROW->col_assign_to);
                                            ?>
                                                <tr>
                                                    <?php if(is_numeric($DISP_ASSET_LOGS_ROW->col_assign_to)){ ?>
                                                        <td><a href="<?= base_url() ?>employees/assets?id=<?=$DISP_ASSET_LOGS_ROW->col_assign_to?>"><?php echo $asset_info[0]->col_frst_name.' '.$asset_info[0]->col_last_name; ?></a></td>
                                                    <?php } else { ?>
                                                        <td><?= $DISP_ASSET_LOGS_ROW->col_assign_to?></td>
                                                    <?php } ?>
                                                    <td><?= $DISP_ASSET_LOGS_ROW->col_issued_on?></td>
                                                    <td><?= $DISP_ASSET_LOGS_ROW->col_returned_on?></td>
                                                </tr>
                                    <?php
                                            }
                                        } else {
                                    ?>
                                            <tr>
                                                <td colspan="4">The item has never been assign yet</td>
                                            </tr>
                                    <?php
                                        }
                                    ?> 
                                </tbody>
                            </table>
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

    <!-- Add Asset -->
    <div class="modal fade" id="modal_add_asset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Assign Asset</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('asset/assign_asset'); ?>" id="update_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body py-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group clearfix my-4">
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" id="check_employee" value="check_employee" name="assign_to">
                                        <label class="radio_label" for="check_employee">
                                            Employee
                                        </label>
                                    </div>
                                    <div class="icheck-primary d-inline ml-4">
                                        <input type="radio" id="check_stockroom" value="check_stockroom" name="assign_to">
                                        <label class="radio_label" for="check_stockroom">
                                            Stock Room
                                        </label>
                                    </div>
                                </div>
                                <div id="assign_employee" style="display:none;">
                                    <div class="form-group">
                                        <label class="required" for="INSRT_ASSIGN_TO_EMP">Assign To</label>
                                        <select name="INSRT_ASSIGN_TO_EMP" id="INSRT_ASSIGN_TO_EMP" class="form-control">
                                            <option value="">Choose...</option>
                                            <?php 
                                                if($DISP_EMPLOYEE_INFO){
                                                    foreach($DISP_EMPLOYEE_INFO as $DISP_EMPLOYEE_INFO_ROW){
                                                    ?>
                                                        <option value="<?= $DISP_EMPLOYEE_INFO_ROW->id ?>"><?= $DISP_EMPLOYEE_INFO_ROW->col_empl_cmid.' - '.$DISP_EMPLOYEE_INFO_ROW->col_frst_name.' '.$DISP_EMPLOYEE_INFO_ROW->col_last_name ?></option>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="required" for="INSRT_EMPL_ISSUED_ON">Date</label>
                                        <input class="form-control form-control " type="date" name="INSRT_EMPL_ISSUED_ON" id="INSRT_EMPL_ISSUED_ON" value="<?php echo date('Y-m-d') ?>">
                                    </div>
                                </div>
                                <div id="assign_stockroom" style="display: none;">
                                    <div class="form-group">
                                        <label class="required" for="INSRT_ASSIGN_TO_STOCKROOM">Stock Room Location</label>
                                        <select name="INSRT_ASSIGN_TO_STOCKROOM" id="INSRT_ASSIGN_TO_STOCKROOM" class="form-control">
                                            <option value="">Choose...</option>
                                            <?php 
                                                if($DISP_STOCKROOM_INFO){
                                                    foreach($DISP_STOCKROOM_INFO as $DISP_STOCKROOM_INFO_ROW){
                                                    ?>
                                                        <option value="<?= $DISP_STOCKROOM_INFO_ROW->name ?>"><?= $DISP_STOCKROOM_INFO_ROW->name?></option>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="INSRT_RETURNED_ON">Transferred On</label>
                                        <input class="form-control form-control" type="date" name="INSRT_RETURNED_ON" id="INSRT_RETURNED_ON" >
                                    </div>
                                </div>
                                <input type="hidden" name="INSRT_ASSET_KEY" id="INSRT_ASSET_KEY" value="<?= $id ?>">
                                <input type="hidden" name="INSRT_ASSET_STATUS" id="INSRT_ASSET_STATUS" value="<?= $status ?>">
                                <input type="hidden" name="ISSUED_ON_KEY" id="ISSUED_ON_KEY" value="<?= $issued_on ?>">
                                <input type="hidden" name="ASSIGN_TO_KEY" id="ASSIGN_TO_KEY" value="<?= $assign_to ?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' id="BTN_ASSIGN_INSRT">&nbsp; Save</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Asset -->
    <div class="modal fade" id="modal_edit_asset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Assignment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('asset/edit_asset'); ?>" id="edit_asset_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                    <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" for="INSRT_ASSET_NAME">Issued On</label>
                                    <input class="form-control form-control " type="date" name="INSRT_ASSET_NAME" id="INSRT_ASSET_NAME">
                                </div>
                                <div class="form-group">
                                    <label for="INSRT_ASSET_SERIAL">Returned On</label>
                                    <input class="form-control form-control " type="date" name="INSRT_ASSET_SERIAL" id="INSRT_ASSET_SERIAL">
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="UPDT_ASSET_KEY" id="UPDT_ASSET_KEY">
                    <div class="modal-footer">
                        <a class='btn btn-primary text-light' id="BTN_ASSET_UPDT">&nbsp; Save</a>
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

    <?php
    if($this->session->userdata('SESS_SUCC_MSG_ASSIGN_ASSET')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_ASSIGN_ASSET'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_ASSIGN_ASSET');
    }
    ?>

    <?php
    if($this->session->userdata('SESS_SUCC_MSG_TRANSFER_ASSET')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_TRANSFER_ASSET'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_TRANSFER_ASSET');
    }
    ?>

    <?php
    if($this->session->userdata('SESS_SUCC_MSG_TRANSFER_TO_STOCKROOM')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_TRANSFER_TO_STOCKROOM'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_TRANSFER_TO_STOCKROOM');
    }
    ?>

    <?php
    if($this->session->userdata('SESS_SUCC_MSG_TRANSFER_TO_EMPLOYEE')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_TRANSFER_TO_EMPLOYEE'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_TRANSFER_TO_EMPLOYEE');
    }
    ?>

     <!-- Initialize the editor. -->
     <script>
        $(function() {

            $('input[type=radio][name=assign_to]').change(function() {
                if (this.value == 'check_stockroom') {
                    $('#assign_employee').hide(400);
                    $('#assign_stockroom').show(400);
                    $('#INSRT_ASSIGN_TO_STOCKROOM').prop('required',true);
                    $('#INSRT_RETURNED_ON').prop('required',true);
                    $('#INSRT_ASSIGN_TO_EMP').prop('required',false);
                    $('#INSRT_EMPL_ISSUED_ON').prop('required',false);
                }
                else if (this.value == 'check_employee') {
                    $('#assign_employee').show(400);
                    $('#assign_stockroom').hide(400);
                    $('#INSRT_ASSIGN_TO_EMP').prop('required',true);
                    $('#INSRT_EMPL_ISSUED_ON').prop('required',true);
                    $('#INSRT_ASSIGN_TO_STOCKROOM').prop('required',false);
                    $('#INSRT_RETURNED_ON').prop('required',false);
                }
            });

            // Get & Display Data to Edit Modal Using Async JS function
            var url = '<?php echo base_url(); ?>asset/getAssetData';
            const openModalButton = document.querySelectorAll('[data-target]');
            openModalButton.forEach(button => {
                button.addEventListener('click', () => {
                    const modal = document.querySelector(button.dataset.target);
                    getAssetData(url,button.getAttribute('asset_id')).then(data => {
                        if(data.length > 0)
                        {
                            data.forEach((x) => {
                                document.getElementById('UPDT_ASSET_KEY').value = x.id;
                                document.getElementById('UPDT_ASSET_ID').value = x.col_asset_id;
                                document.getElementById('UPDT_ASSET_NAME').value = x.col_asset_name;
                                document.getElementById('UPDT_ASSET_SERIAL').value = x.col_asset_serial;
                                document.getElementById('UPDT_ASSET_CATEGORY').value = x.col_asset_category;
                                document.getElementById('UPDT_ASSET_LOCATION').value = x.col_asset_location;
                                document.getElementById('UPDT_ASSET_PRICE').value = x.col_asset_price;
                                document.getElementById('UPDT_ASSET_WARRANTY_EXP').value = x.col_asset_warranty_exp;

                                var html = x.col_asset_description.replace(/<style([\s\S]*?)<\/style>/gi, '');
                                html = html.replace(/<script([\s\S]*?)<\/script>/gi, '');
                                html = html.replace(/<\/div>/ig, '\n');
                                html = html.replace(/<\/li>/ig, '\n');
                                html = html.replace(/<li>/ig, '  *  ');
                                html = html.replace(/<\/ul>/ig, '\n');
                                html = html.replace(/<\/p>/ig, '\n');
                                html = html.replace(/<br\s*[\/]?>/gi, "\n");
                                html = html.replace(/<[^>]+>/ig, '');

                                document.getElementById('UPDT_ASSET_DESCRIPTION').value = html;
                            });
                        }
                    });
                });
            });

            async function getAssetData(url,asset_id) {
                var formData = new FormData();
                formData.append('asset_id', asset_id);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }

            // Update Position
            $('#BTN_ASSET_UPDT').click(function(){
                var asset_id = $('#UPDT_ASSET_ID').val();
                var asset_name = $('#UPDT_ASSET_NAME').val();
                var asset_category = $('#UPDT_ASSET_CATEGORY').val();
                var asset_price = $('#UPDT_ASSET_PRICE').val();
                var hasErr = 0;
                if(!asset_id){
                    $('#UPDT_ASSET_ID').addClass('is-invalid');
                    hasErr++;
                }
                if(!asset_name){
                    $('#UPDT_ASSET_NAME').addClass('is-invalid');
                    hasErr++;
                }
                if(!asset_category){
                    $('#UPDT_ASSET_CATEGORY').addClass('is-invalid');
                    hasErr++;
                }
                if(!asset_price){
                    $('#UPDT_ASSET_PRICE').addClass('is-invalid');
                    hasErr++;
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
                            $('#edit_asset_form').submit();
                        }
                    })
                }
            })

            $('#UPDT_ASSET_ID').keyup(function(){
                $('#UPDT_ASSET_ID').removeClass('is-invalid');
            })
            $('#UPDT_ASSET_NAME').keyup(function(){
                $('#UPDT_ASSET_NAME').removeClass('is-invalid');
            })
            $('#UPDT_ASSET_CATEGORY').keyup(function(){
                $('#UPDT_ASSET_CATEGORY').removeClass('is-invalid');
            })
            $('#UPDT_ASSET_PRICE').keyup(function(){
                $('#UPDT_ASSET_PRICE').removeClass('is-invalid');
            })

            // Delete Position
            $('.BTN_DLT_ASSET').click(function(e){
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
                    window.location.href = "<?= base_url(); ?>asset/dlt_asset?delete_id="+user_deleteKey;
                    }
                })
            })
        });
    </script>
    

</body>
</html>
