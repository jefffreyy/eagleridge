<style>
    li a {
        color: #0D74BC;
    }

    a:hover {
        text-decoration: none;
    }

    .activity td {
        padding: 6.8px 20px;
    }

    .page-item .active {
        background-color: #0D74BC !important;
    }

    label.required:after {
        content: " *";
    }

    label.required:after {
        content: " *";
        color: red;
    }

    li a {
        font-size: 14px;
    }

    .header-elements a {
        font-size: 14px;
    }

    .list-icons a {
        font-size: 11.2px;
        color: #197fc7;
    }

    td {
        width: 100%;
    }
</style>

<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">

<div class="content-wrapper">
    <div class="flex-fill p-4">
        <div class="row">
            <div class="col-12">
                <div class="card p-4 pt-5">
                    <div class="w-100">
                        <?php 
                            foreach($DISP_ANNOUNCEMENTS_INFO as $DISP_ANNOUNCEMENTS_INFO_ROW){
                                $employee_info = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_ANNOUNCEMENTS_INFO_ROW->col_empl_id);
                                $db_date_time = strtotime($DISP_ANNOUNCEMENTS_INFO_ROW->col_date_created);
                                $date_time = date('M d Y H:i', $db_date_time);
                            ?>
                                <div class="float-right">
                                    <div class="d-flex">
                                        <div class=" ">
                                            <a class="btn btn-light mr-2" href="<?= base_url() ?>home">
                                                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                                            </a>          
                                        </div>

                                        <a href="#" class="btn btn-light" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" title="Edit" data-toggle="modal" data-target="#modal_edit_announcement" announcement_id="<?= $DISP_ANNOUNCEMENTS_INFO_ROW->id ?>">Edit</a>
                                            <a class="dropdown-item text-danger BTN_DELETE_KEY" title="Delete" delete_key="<?= $DISP_ANNOUNCEMENTS_INFO_ROW->id ?>">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <h2 class="page-title mb-3" style="font-size: 23px !important;"><?= $DISP_ANNOUNCEMENTS_INFO_ROW->name ?></h2>
                                <div class="author small">
                                    <div class="mb-5 mt-1">
                                        <a href="<?= base_url() ?>employees/personal?id=<?= $DISP_ANNOUNCEMENTS_INFO_ROW->col_empl_id ?>">
                                            <img width="30" class="rounded-circle mr-2 " src="<?=base_url()?>user_images/<?= $employee_info[0]->col_imag_path ?>">
                                        </a>          
                                        <a class="ml-2" href="<?= base_url() ?>employees/personal?id=<?= $DISP_ANNOUNCEMENTS_INFO_ROW->col_empl_id ?>"><?= $employee_info[0]->col_frst_name.' '.$employee_info[0]->col_last_name ?></a>

                                        <span class="text-muted ml-3 author_date">
                                            <?= $date_time ?>
                                        </span>
                                    </div>
                                </div>
                                <p>
                                    <?=$DISP_ANNOUNCEMENTS_INFO_ROW->description?>
                                </p>
                            <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<aside class="control-sidebar control-sidebar-dark">
</aside>

<!-- EDIT MODAL -->
<div class="modal fade" id="modal_edit_announcement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pb-0" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Announcement
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;
                    </span>
                </button>
            </div>
            <form action="<?php echo base_url('announcements/updt_announcement'); ?>" id="FORM_UPDT_ANNOUNCEMENT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="modal-body">
                <?php 
                    foreach($DISP_ANNOUNCEMENTS_INFO as $DISP_ANNOUNCEMENTS_INFO_ROW1){
                    ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required " for="asset_code">Title
                                    </label>
                                    <input class="form-control form-control " type="text" name="UPDT_ANNOUNCEMENT_NAME" id="UPDT_ANNOUNCEMENT_NAME" value="<?= $DISP_ANNOUNCEMENTS_INFO_ROW1->name ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="required " for="asset_code">Description
                                    </label>
                                    <input class="form-control form-control " type="text" name="UPDT_ANNOUNCEMENT_DESCRIPTION" id="UPDT_ANNOUNCEMENT_DESCRIPTION" value="<?= $DISP_ANNOUNCEMENTS_INFO_ROW1->description ?>" required>
                                </div>
                            </div>
                            <input type="hidden" name="UPDT_ANNOUNCEMENT_ID" id="UPDT_ANNOUNCEMENT_ID" value="<?= $DISP_ANNOUNCEMENTS_INFO_ROW1->id ?>">
                        </div>
                    <?php
                    }
                ?>
                    
                </div>
                <div class="modal-footer">
                    <a class='btn btn-primary text-light' id="UPDT_ANNOUNCEMENT_BTN">&nbsp; Update
                    </a>
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
                <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout</a>
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
if ($this->session->userdata('SESS_UPDT_ANNOUNCEMENT')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_UPDT_ANNOUNCEMENT'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_UPDT_ANNOUNCEMENT');
}
?>


<script>

    $(document).ready(function(){
        // Update Position
        $('#UPDT_ANNOUNCEMENT_BTN').click(function(){
            var announcement_name = $('#UPDT_ANNOUNCEMENT_NAME').val();
            var announcement_description = $('#UPDT_ANNOUNCEMENT_DESCRIPTION').val();
            var hasErr = 0;
            if(!announcement_name){
                hasErr++;
            }
            if(!announcement_description){
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
                    $('#FORM_UPDT_ANNOUNCEMENT').submit();
                }
                })
            }
            else {
                if(!announcement_name){
                    $('#UPDT_ANNOUNCEMENT_NAME').addClass('is-invalid');
                }
                if(!announcement_description){
                    $('#UPDT_ANNOUNCEMENT_DESCRIPTION').addClass('is-invalid');
                }
            }
        })

        $('#UPDT_ANNOUNCEMENT_NAME').keyup(function(){
            $('#UPDT_ANNOUNCEMENT_NAME').removeClass('is-invalid');
        })
        $('#UPDT_ANNOUNCEMENT_DESCRIPTION').keyup(function(){
            $('#UPDT_ANNOUNCEMENT_DESCRIPTION').removeClass('is-invalid');
        })

        $('.BTN_DELETE_KEY').click(function(e){
            e.preventDefault();
            var deleteKey = $(this).attr('delete_key');
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
                window.location.href = "<?= base_url(); ?>announcements/dlt_announcement?delete_id="+deleteKey;
                }
            })
        })
    })

</script>

</body>

</html>