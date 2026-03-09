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

<?php
    $user_info = $this->login_model->get_user_info($this->session->userdata('SESS_USER_ID'));
    $col_user_access = '';
    $is_super_admin = '';
    if($user_info){
        foreach($user_info as $user_info_row){
            $col_user_access = $user_info_row->col_user_access;
            $is_super_admin = $user_info_row->isSuperAdmin;
        }
    }
?>

<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

	<div class="content-wrapper">
		<div class="container-fluid p-4">
            <div class="row mb-2">
                <div class = "col-md-6">
                    <h1><b>Patch Updates</b><h1>
                </div>

                
                <?php 
                    if($is_super_admin == 1){
                        ?>
                            <div class = "col-md-6" style = "text-align: right;">
                                <a href="#" id="btn_add" data-toggle="modal" data-target="#modal_add_patch_details" type ="button" class = "btn btn-primary shadow-none">Add Patch</a>
                            </div>
                        <?php
                    }
                ?>
                
            </div>

            <!-- <div class="row mt-4 pb-2">
                <div class="col-md-4">
                    <label for="filter_by_date">Filter by Date</label>
                    <input type="date" name="filter_by_date" id="filter_by_date" class="form-control">
                </div>
            </div> -->
            
            <?php
                if(count($DISP_PATCH_LOGS) > 0){
                
                    foreach($DISP_PATCH_LOGS as $DISP_PATCH_LOGS_ROW){
                        $date_patched = date('F d, Y', strtotime($DISP_PATCH_LOGS_ROW->date_patched));
                        $description_arr = explode('%%',$DISP_PATCH_LOGS_ROW->description);

                        $empl_info = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_PATCH_LOGS_ROW->patched_by);
                        $empl_name = '';
                        $empl_id = '';
                        foreach($empl_info as $empl_info_row){
                            $empl_name = $empl_info_row->col_frst_name.' '.$empl_info_row->col_last_name;
                            $empl_id = $empl_info_row->id;
                        }
                        ?>
                            <hr>

                            <div class="d-flex mt-4 px-4">
                                <div class="flex-fill">
                                    <p style="font-size: 25px;" class="mb-1">Patch <?= $DISP_PATCH_LOGS_ROW->patch_num ?>: </p>
                                    <p>Update as of <?= $date_patched ?> - <a href="#"> <?= $empl_name ?></a></p>
                                    
                                    <div>
                                        <?php
                                            foreach($description_arr as $description_arr_row){
                                                ?>
                                                    <ul class="mb-1">
                                                        <li><?= $description_arr_row ?></li>
                                                    </ul>
                                                <?php
                                            }
                                        ?>
                                    </div>

                                </div>

                                <?php 
                                    if($is_super_admin == 1){
                                        ?>
                                            <div>
                                                <a href = "<?=base_url()?>employees/personal?id=<?= $empl_id ?>" class="float-right text-secondary mt-4" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a style="cursor: pointer;" class="dropdown-item ml-0 py-2 text-primary btn_edit" patch_id="<?= $DISP_PATCH_LOGS_ROW->id ?>" data-toggle="modal" data-target="#modal_edit_patch_details"><i class="fas fa-pencil-alt"></i>&nbsp; Edit</a>
                                                    <a style="cursor: pointer;" class="dropdown-item ml-0 py-2 text-danger btn_delete" patch_id="<?= $DISP_PATCH_LOGS_ROW->id ?>"><i class="fas fa-trash-alt"></i>&nbsp; Delete</a>
                                                </div>
                                            </div>
                                        <?php
                                    }
                                ?>
                                
                            </div>
                        <?php
                    }

                } else {
                    ?>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <p style="font-size: 30px;" class="text-secondary">No Updates Yet</p>
                            </div>
                        </div>
                        
                    <?php
                }
            ?>
            

        </div>
	</div>

	<aside class="control-sidebar control-sidebar-dark"></aside>

    <!-- Add Patch Detials -->
    <div class="modal fade" id="modal_add_patch_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-2" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Patch Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="<?= base_url() ?>patch/insrt_patch" id="add_patch" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row px-2">
                            <div class="col-12">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="patch_number" class="required">Patch Number</label>
                                                <input type="text" name="patch_number" id="patch_number" class="form-control" placeholder="Enter Patch Number">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="patch_date" class="required">Date Patched</label>
                                                <input type="date" name="patch_date" id="patch_date" class="form-control" placeholder="Enter Patch Number">
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div id="description_container">
                                        <div class="form-group description">
                                            <label for="patch_date" class="required">Description</label>
                                            <textarea name="patch_desc[]" id="patch_desc" cols="30" rows="2" class="form-control mb-1"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <a href="#" class="btn btn-primary mb-0" id="btn_add_more">Add More</a>
                                    </div>

                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class='btn btn-primary text-light px-5'>&nbsp; Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <!-- Edit Patch Detials -->
    <div class="modal fade" id="modal_edit_patch_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-2" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Update Patch Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="<?= base_url() ?>patch/updt_patch" id="updt_patch" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row px-2">
                            <div class="col-12">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="updt_patch_number" class="required">Patch Number</label>
                                            <input type="text" name="updt_patch_number" id="updt_patch_number" class="form-control" placeholder="Enter Patch Number" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="updt_patch_date" class="required">Date Patched</label>
                                            <input type="date" name="updt_patch_date" id="updt_patch_date" class="form-control" placeholder="Enter Patch Number" required>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div id="updt_description_container">
                                    <div class="form-group description">
                                        <label for="updt_patch_date" class="required">Description</label>
                                        <textarea name="updt_patch_desc[]" id="updt_patch_desc" cols="30" rows="2" class="form-control mb-1" required></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <a href="#" class="btn btn-primary mb-0" id="updt_btn_add_more">Add More</a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="updt_patch_id" id="updt_patch_id">
                        <button type="submit" class='btn btn-primary text-light px-5'>&nbsp; Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




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
    <!-- Datatables -->
    <script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
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
    if($this->session->userdata('success')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('success'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('success');
    }
    ?>





















    <script>
        $(document).ready(function(){
            var url_get_patch_data = '<?= base_url() ?>patch/get_patch_data';

            $('#btn_add_more').click(function(){
                $('#description_container').append(`
                    <div class="form-group description">
                        <label for="patch_date" class="required">Description</label>
                        <textarea name="patch_desc[]" id="patch_desc" cols="30" rows="2" class="form-control mb-1" required></textarea>
                    </div>
                `)
            })

            $('#updt_btn_add_more').click(function(){
                $('#updt_description_container').append(`
                    <div class="form-group description">
                        <label for="patch_date" class="required">Description</label>
                        <textarea name="updt_patch_desc[]" id="updt_patch_desc" cols="30" rows="2" class="form-control mb-1" required></textarea>
                    </div>
                `)
            })

            $("#modal_show_patch_details").on('hide.bs.modal', function(){
                $('#description_container').html(`
                    <div class="form-group description">
                        <label for="patch_date" class="required">Description</label>
                        <textarea name="patch_desc[]" id="patch_desc" cols="30" rows="2" class="form-control mb-1" required></textarea>
                    </div>
                `)
            });








            $('.btn_edit').click(function(e){
                $('#updt_description_container').html('');
                var patch_id = $(this).attr('patch_id');

                get_patch_data(url_get_patch_data, patch_id).then(function(data){
                    Array.from(data).forEach(function(x){

                        $('#updt_patch_number').val(x.patch_num);
                        $('#updt_patch_date').val(x.date_patched);
                        $('#updt_patch_id').val(x.id);

                        var description_arr = (x.description).split('%%');

                        Array.from(description_arr).forEach(function(desc){
                            $('#updt_description_container').append(`
                                <div class="form-group description">
                                    <label for="patch_date" class="required">Description</label>
                                    <textarea name="updt_patch_desc[]" id="updt_patch_desc" cols="30" rows="2" class="form-control mb-1" required>`+desc+`</textarea>
                                </div>
                            `)
                        })

                        
                    })
                })
            })







            $('.btn_delete').click(function(e){
                var patch_id = $(this).attr('patch_id');

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
                        window.location.href = "<?= base_url() ?>patch/dlt_patch?patch_id="+patch_id;
                    }
                })
               
            })




            // ================================== PATCH ======================================
            async function get_patch_data(url, patch_id){
                var formData = new FormData();
                formData.append('patch_id', patch_id);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }


        })
        
    </script>


</body>
</html>
