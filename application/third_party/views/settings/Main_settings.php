<style>
    /* CSS for this page only */
    .active{
        font-weight: 600;
    }

    th,td{
        font-size: 13px !important;
    }

    label.required::after{
        content:" *";
        color: red;
    }

    .settings-category{
        font-size: 12px !important;
        color: #333333;
    }

    .list-group-item{
        border: none !important;
    }
</style>

<?php 
    $user_info = $this->login_model->get_user_info($this->session->userdata('SESS_USER_ID'));

    $User_access='';
    foreach($user_info as $info)
    {
        $User_access = $info->col_user_access;
    }
?>
	
	<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">

	<div class="content-wrapper">
		<div class="p-3">
            <div class="flex-fill">
                <div class="row pr-3">
                    <div class="col">
                        <h1 class="page-title">Settings</h1>
                    </div>
                </div>
                <div class="row">

                    <?php 
                        if(($User_access == 2) || ($User_access == 4)){
                            ?>
                                <!-- HUMAN RESOURCE -->
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-transparent">
                                            <span class="text-uppercase settings-category">Human Resource</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/positions"><i class="fas fa-fw fa-briefcase mr-3"></i>Positions</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/gender"><i class="fas fa-venus-mars mr-3"></i>Gender</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/marital_status"><i class="fas fa-ring mr-3"></i>Marital Status</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/emptypes"><i class="fas fa-fw fa-business-time mr-3"></i>Employment Types</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/nationality"><i class="fas fa-flag mr-3"></i>Nationality</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/skills"><i class="fas fa-fw fa-brain mr-3"></i>Skills</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/skill_level"><i class="fas fa-level-up-alt mr-3"></i>Skill Level</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/shirt_size"><i class="fas fa-tshirt mr-3"></i>Shirt Size</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/hmo"><i class="fas fa-medkit mr-3"></i>HMO</a>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/department"><i class="fas fa-fw fa-network-wired mr-3"></i>Departments</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/section"><i class="fas fa-object-group mr-3"></i>Sections</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/group"><i class="fas fa-users mr-3"></i>Groups</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/line"><i class="fas fa-users mr-3"></i>Line</a>
                                                </div>
                                            </div>

                                            <hr>
                                                
                                            <div class="row">
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/pay_schedule"><i class="fas fa-file-invoice-dollar mr-3"></i>Cut-off Schedules</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/work_shift"><i class="fas fa-cloud-moon mr-3"></i>Work Shifts</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/shiftTemplate"><i class="fas fa-adjust mr-3"></i>Shift Template</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/holidays"><i class="fas fa-fw fa-umbrella-beach mr-3"></i>Holidays</a>
                                                </div>
                                            </div>

                                            <hr>
                                                
                                            <div class="row">
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/location"><i class="fas fa-map-marker-alt mr-3"></i>Locations</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/stockroom"><i class="fas fa-warehouse mr-3"></i>Stock Rooms</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?= base_url()?>settings/assets"><i class="fas fa-fw fa-laptop mr-3"></i>Asset Categories</a>
                                                </div>
                                            </div>

                                            <hr>
                                                
                                            <div class="row">
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/leavetypes"><i class="fas fa-sign-out-alt mr-3"></i>Leave Types</a>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                    
                    <?php 
                        if(($User_access == 3) || ($User_access == 4)){
                            ?>
                                <!-- ACCOUNTING -->
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-transparent">
                                            <span class="text-uppercase settings-category">Accounting</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/sss"><i class="fas fa-shield-alt mr-3"></i>Social Security System (SSS)</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/philhealth"><i class="fas fa-heart mr-3"></i>Philhealth</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/hdmf"><i class="fas fa-house-user mr-3"></i>Home Development Mutual Fund (HDMF)</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/wth_tax"><i class="fas fa-hand-holding-usd mr-3"></i>Withholding Tax</a>
                                                </div>
                                                <div class="col-4">
                                                    <a class="list-group-item list-group-item-action" href="<?=base_url()?>settings/pay_schedule"><i class="fas fa-file-invoice-dollar mr-3"></i>Cut-off Schedules</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                    
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

</body>
</html>
