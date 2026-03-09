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
                        <h1 class="page-title">Guide Lists</h1>
                    </div>
                </div>
                <hr>
                <div class="row">

                    <!-- GENERAL -->
                    <div class="col-md-12">
                        <h4 class="text-bold text-secondary">General</h4>
                        
                        <div class="row mt-3 px-4">
                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;" onclick="displayGuides(0)">
                                    <img src="<?= base_url() ?>images/thumbnails/Login.png" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #1:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">Login / Forgot Password</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/UI.png" onclick="displayGuides(1)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #2:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">User Interface</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    <!-- SELF-SERVICE -->
                    <div class="col-md-12">
                        <br>
                        <h4 class="text-bold text-secondary">Self-Service</h4>
                        
                        <div class="row mt-3 px-4">
                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Apply_Leave.png" onclick="displayGuides(2)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #3:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">How to Apply for Leave</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Apply_Overtime.png" onclick="displayGuides(3)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #4:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">How to Apply for Overtime</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Login.png" onclick="displayGuides(4)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #5:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">How to Apply for Time Adjustments</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Login.png" onclick="displayGuides(5)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #6:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">Remote Time Record</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    

                    <!-- HUMAN RESOURCE -->
                    <div class="col-md-12">
                        <br>
                        <h4 class="text-bold text-secondary">Human Resource</h4>
                        
                        <div class="row mt-3 px-4">

                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Add_employee_data.png" onclick="displayGuides(6)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #7:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">How to Add Employee</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Edit_Employee_Data.png" onclick="displayGuides(7)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #8:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">How to Edit Employee</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Manage_Attendance_Records.png" onclick="displayGuides(8)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #9:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">How to Manage Attendance Records</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Leave_Entitlement.png" onclick="displayGuides(9)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #10:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">Leave Entitlement</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/how_to_add_loans.png" onclick="displayGuides(10)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #11:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">How to Add Loans</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Add_allowances.png" onclick="displayGuides(11)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #12:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">How to Add Allowances</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Importing_employee_data.png" onclick="displayGuides(12)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #13:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">Importing Employee Data</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Import_Attendance_Records.png" onclick="displayGuides(13)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #14:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">Importing Attendance Records</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Biometrics_Data_Monitoring.png" onclick="displayGuides(14)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #15:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">Biometrics Data Monitoring</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Terminate_Resign.png" onclick="displayGuides(15)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #16:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">How to Terminate/Resign Employee</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>







                    <!-- ACCOUNTING -->
                    <div class="col-md-12">
                        <br>
                        <h4 class="text-bold text-secondary">Accounting</h4>
                        
                        <div class="row mt-3 px-4">
                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Calculate_Payslip.png" onclick="displayGuides(16)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #17:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">How to Calculate Payslip</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Manage_Assets.png" onclick="displayGuides(17)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #18:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">How to Manage Assets</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Add_Bank_Details.png" onclick="displayGuides(18)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #19:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">How to Add Bank Details</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <!-- ADMINISTRATOR -->
                    <div class="col-md-12">
                        <br>
                        <h4 class="text-bold text-secondary">Administrator</h4>
                        
                        <div class="row mt-3 px-4">
                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Calculate_Payslip.png" onclick="displayGuides(19)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #20:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">How to Reset Password</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="card" style="cursor: pointer;">
                                    <img src="<?= base_url() ?>images/thumbnails/Manage_Assets.png" onclick="displayGuides(20)" alt="">
                                    <div class="p-3">
                                        <p class=" mb-0 text-primary text-bold text-center" style="font-size: 17px;">HRCare Tutorial #21:</p>
                                        <p class="mt-2 text-secondary text-center" style="font-size: 15px;">How to Assign User Access</p>
                                    </div>
                                </div>
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

    <script>
        function displayGuides(index){
            window.location.href = '<?= base_url() ?>home/display_guide?guide_index='+index;
        }
    </script>

</body>
</html>
