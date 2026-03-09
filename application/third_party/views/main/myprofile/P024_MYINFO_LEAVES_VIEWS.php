<style>
    .card{
        padding: 20px;
    }
    li a{
        color: #0D74BC;
    }
    a:hover{
        text-decoration: none;
    }
    .activity td{
        padding: 6.8px 20px;
    }
    .page-item .active{
        background-color: #0D74BC !important;
    }
    label.required:after {
        content: " *";
    }

    label.required:after {
        content: " *";
        color: red;
    }
    li a{
        font-size: 14px;
    }
    .header-elements a{
        font-size: 14px;
    }
    .list-icons a{
        font-size: 11.2px;
        color: #197fc7;
    }
    .profile{
        padding: 20px 0px 0px;
    }
    .profile-img{
        display: inline-block;
        float: left;
        padding-right: 20px;
    }
    .profile-disc{
        margin-left: 100px;
    }
    .profile-name{
        font-weight: bold;
        font-size:16px;
    }
    .position{
        font-weight: bold;
        font-size: 15px;
        color: #B0B0B0;
    }
    .divider{
        margin-top: 50px;
    }
    .social-div a{
        padding: 10px 15px;
        color: #6a6a6a;
        font-size: 15px;
    }
    .label-note{
        background-color: #fde6d8;
        padding: 5px 10px;
        border-radius: 30px;
        color: #c46632;
        font-weight: bold;
        text-align: center;
        line-height: normal;
    }
    .upload-div{
        position: absolute;
        width: 250px;
        background-color: ;
        height: 300px;
    }
    #formFile{
        padding: 10px 15px -20px 10px;
    }
    .photo{
        text-align: center;
        padding: 10px;
    }
    .firstFields{
        margin-left: 250px; 
        max-width: auto;
    }
    @media (max-width: 900px) {
        .upload-div{
            position: relative;
            width: 100%;
            background-color: ;
            height: 250px;
        }
        .firstFields{
            margin-left: 0px;

        }
        #myTab{
            margin-left: 0px;
        }
    }
    .nav-tabs > li > a{
    	background-color: none;
		color: black;
		border: 0px;
        font-size: 14px;
    }
    .nav-tabs > li > a:hover{
    	background-color: white;
		border: 0px;
    }
    .nav-tabs>li.active>a, 
	.nav-tabs>li.active>a:focus, 
	.nav-tabs>li.active>a:hover {
		border: 0;
    }
    .nav-tabs {
	  border-bottom: 0px solid transparent;
      padding-right: 15px;
	}
	.nav-tabs .nav-link {
	  border: 0px solid transparent;
	}
	.nav-tabs>li.active{
		border-color: #1279bf;
		border-bottom-style: solid;
	}
    .profile-pic{
        text-align: center;
        margin-bottom: 10px;
    }
    .emp-name{
        font-size: 20px;
    }
    .nav-top{
        width: 100%;
        overflow: hidden;
        background-color: white;
    }
    .nav-top a{
        padding: 13px 27px;
        display: block;
        float: left;
        margin-left: 20px;
        color: #878787;
    }
    .nav-top a:hover{
        background-color: #e8e8e8;
    }
    .nav-top .top-right{
        float: right;
        margin-right: 20px;
        display: block;
    }
    .time-off{
        background-color:;
        padding: 5px;
    }
    .time-off-text{
        background-color: #e1e1e1;
        padding: 3px 8px;
        border-radius: 15px;
    }
    .emp-stat{
        padding: 7px 10px;
        display: block;
    }
    .emp-stat{
        list-style-type: none;
        padding: 7px 0px;
        display: block;
        margin-bottom: -10px;
    }
    .emp-stat .stats{
       display: block;
       display: inline-block;
    }
    .scrollmenu{
        width: 800px;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
    }
    .modal-btn{
        display: flex;
        float: right;
        font-size: 22px;
    }
    .stats-icn{
        width: 20px;
        text-align: center;
        display: inline-block;
        margin-right: 5px;
        margin-bottom: 10px;
    }
    .stats{
        display: inline-block;
        word-break: break-all;
    }
    table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    }
    th, td {
    text-align: left;
    padding: 8px;
    font-size: 14px !important;
    }

    .mini-nav{
		width: 100%;
		margin-top: -15px;
        margin-left: 20px;
	}
	.mini-links.active{
		border-color: #1279bf;
		border-bottom-style: solid;
	}
    .mini-links.active:hover{
		border-color: #1279bf;
		border-bottom-style: solid;
	}
	.mini-nav a{
		display: block;
		float: left;
		padding: 10px 15px;
		text-decoration: none;
		color: black;
	}
	.mini-nav a:hover{
		border-color: #e2e2e2;
		border-bottom-style: solid;
	}

    @media screen and (max-width: 500px) {
        .mini-nav{
            display: flex;
            overflow-x: scroll;
            margin-top: 15px;
        }
    }
</style>

<?php 
    // Key id
    $user_id = '';
    
    // Personal Info
    $user_image='';
    $lastname='';
    $middlename='';
    $firstname='';
    $full_name='';

    // Company Info
    $company_number='';
    $company_email='';
    $hired_on='';
    $employment_type='';
    $position='';
    $section='';
    $department='';
    $division='';
    $reporting_to='';

    if($DISP_EMP_INFO){
        foreach($DISP_EMP_INFO as $DISP_EMP_INFO_ROW){
            // Key id
            $user_id = $DISP_EMP_INFO_ROW->id;

            // Set personal Info
            $user_image = $DISP_EMP_INFO_ROW->col_imag_path
            ;
            $lastname = $DISP_EMP_INFO_ROW->col_last_name
            ;
            $middlename = $DISP_EMP_INFO_ROW->col_midl_name
            ;
            $firstname = $DISP_EMP_INFO_ROW->col_frst_name
            ;
            if($middlename){
                $full_name = $lastname.', '.$firstname.' '. ucfirst($middlename[0]).'.';
            } else {
                $full_name = $lastname.', '.$firstname;
            }

            // Set company Info
            $company_number = $DISP_EMP_INFO_ROW->col_comp_numb
            ;
            $company_email = $DISP_EMP_INFO_ROW->col_comp_emai
            ;
            $hired_on = $DISP_EMP_INFO_ROW->col_hire_date
            ;
            $employment_type = $DISP_EMP_INFO_ROW->col_empl_type
            ;
            $position = $DISP_EMP_INFO_ROW->col_empl_posi
            ;
            $section = $DISP_EMP_INFO_ROW->col_empl_sect
            ;
            $department = $DISP_EMP_INFO_ROW->col_empl_dept
            ;
            $division = $DISP_EMP_INFO_ROW->col_empl_divi
            ;
            $reporting_to = $DISP_EMP_INFO_ROW->col_empl_repo
            ;
        }
    }
?>

<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
   
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<div class="content-wrapper">
        <!-- <div class = "nav-top">
            <a href = "#" class = "top-left"><i class="fas fa-angle-left"></i>  Previous</a>
            <div class = "top-right">
                <a href = "#">Next  <i class="fas fa-angle-right"></i></a>
                <a href = "#" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <h6 class="dropdown-header text-left">Self-Service...</h6>
                    <a class="dropdown-item ml-0" href="#">Reset Password</a>
                    <a class="dropdown-item ml-0" href="#">Send Welcome Letter</a>
                    <a class="dropdown-item ml-0" href="#">Login as User</a>
                    <a class="dropdown-item ml-0" href="#">Disable Self-Service Access</a>
                    <a class="dropdown-item ml-0" href="#">Leave Policy</a>
                    <a class="dropdown-item ml-0" href="#">Terminate Employee...</a>
                    <a class="dropdown-item ml-0 text-danger" href="#">Delete Employee</a>
                </div>
            </div>
        </div> -->
		<div class="container-fluid p-4">
            <div class = "row">
                <div class = "col-md-3">
                    <div class = "card border-0">
                        <div style = "text-align:center;">
                            <div class = "profile-pic">
                                <img class="rounded-circle avatar" id="employee_img" style="cursor: pointer;" width="200" height="200" src="<?php if($user_image){echo base_url().'user_images/'.$user_image;} else {echo base_url().'user_images/default_profile_img3.png';}?>">
                            </div>
                            <text class = "emp-name"><?= $full_name ?></text>
                            <?php
                                if($DISP_USER_INFO[0]->disabled > 0){
                                    ?>
                                        <p class="text-danger text-bold">Inactive</p>
                                    <?php
                                } else {
                                    ?>
                                        <p class="text-success text-bold">Active</p>
                                    <?php
                                }
                            ?>
                            <!--<div class = "time-off"><text class = "time-off-text"><i class="fas fa-plane mr-2" style = "font-size: 12px;"></i>Annual Leave</text></div>-->
                        </div>
                        <div class = "emp-stat">
                            <div class = "stats-icn"><i class="fas fa-briefcase"></i></div>
                            <div class = "stats"><?= $position ?></div><br>
                            <div class = "stats-icn"><i class="fas fa-map-marker-alt"></i></div>
                            <div class = "stats"><?= $department ?></div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "card border-0">
                                <div class = "card-title">Company Number</div>
                                <?= $company_number ?>
                                <div class = "card-title mt-2">Company Email</div>
                                <?= $company_email ?>
                                <hr>
                                <div class = "card-title mt-2">Hired On</div>
                                <?= $hired_on ?>
                                <div class = "card-title mt-2">Employment Type</div>
                                <?= $employment_type ?>
                                <div class = "card-title mt-2">Position</div>
                                <?= $position ?>
                                <div class = "card-title mt-2">Section</div>
                                <?= $section ?>
                                <div class = "card-title mt-2">Department</div>
                                <?= $department ?>
                                <div class = "card-title mt-2">Division</div>
                                <?= $division ?>
                            </div>
                        </div>
                    </div>
                    <!-- <div class = "row">
                        <div class = "col-md-12">
                            <div class="card">
                                <h6 class="card-title">
                                <i class="fas fa-user-tie mr-2"></i> Reports To
                                </h6>
                                <div class="table-responsive mt-3">
                                    <table class="table table-xs" style="border: none !important;">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php 
                                                            $reporting = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($reporting_to);
                                                            $manager_name = $reporting[0]->col_frst_name.' '.$reporting[0]->col_last_name;
                                                            $manager_position = $reporting[0]->col_empl_posi;
                                                        ?>
                                                        <div class="mr-3">
                                                            <a href="#">
                                                                <img class="rounded-circle avatar" src="<?=base_url()?>user_images/<?= $reporting[0]->col_imag_path; ?>" style="width: 50px; height: 50px;">
                                                            </a>                      
                                                        </div>
                                                        <div>
                                                            <strong><a href="<?=base_url()?>employees/personal?id=<?= $reporting[0]->id ?>"><?= $manager_name ?></a></strong>
                                                            <div class="small text-muted">
                                                                <?= $manager_position ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class="card">
                                <h6 class="card-title">
                                <i class="fas fa-sitemap mr-2"></i> Direct Reports
                                </h6>
                                <div class="table-responsive mt-3">
                                    <table class="table table-xs" style="border: none !important;">
                                        <tbody>
                                            <?php if($DISP_EMP_DIRECT_REPORTS){
                                                foreach($DISP_EMP_DIRECT_REPORTS as $DISP_EMP_DIRECT_REPORTS_ROW){
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="mr-3">
                                                            <a href="#">
                                                                <img class="rounded-circle avatar" src="<?=base_url()?>user_images/<?= $DISP_EMP_DIRECT_REPORTS_ROW->col_imag_path; ?>" style="width: 50px; height: 50px;">
                                                            </a>                      
                                                        </div>
                                                        <div>
                                                            <strong><a href="<?=base_url()?>employees/personal?id=<?= $DISP_EMP_DIRECT_REPORTS_ROW->id ?>"><?= $DISP_EMP_DIRECT_REPORTS_ROW->col_frst_name.' '.$DISP_EMP_DIRECT_REPORTS_ROW->col_last_name ?></a></strong>
                                                            <div class="small text-muted">
                                                                <?= $DISP_EMP_DIRECT_REPORTS_ROW->col_empl_posi ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php }
                                            } else { ?>
                                                <div class="text-center text-muted" >
                                                    Employee does not have any direct reports
                                                </div>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class = "col-md-9">
                    <div class = "row">
                        <div class = "mini-nav">
                            <a href = "<?=base_url()?>profile" class = "mini-link">Personal</a>
                            <a href = "<?=base_url()?>profile/ids" class = "mini-links">ID's</a>
                            <a href = "<?=base_url()?>profile/job" class = "mini-links">Job</a>
                            <a href = "<?=base_url()?>profile/allowance" class = "mini-links">Allowance</a>
                            <!-- <a href = "<?=base_url()?>profile/leave" class = "mini-links active">Leave</a> -->
                            <a href = "<?=base_url()?>profile/documents" class = "mini-links">Documents</a>
                            <!-- <a href = "<?=base_url()?>profile/tasks" class = "mini-links">Tasks</a> -->
                            <a href = "<?=base_url()?>profile/assets" class = "mini-links">Assets</a>
                            <a href = "<?=base_url()?>profile/emergency" class = "mini-links">Emergency</a>
                            <a href = "<?=base_url()?>profile/dependents" class = "mini-links">Dependents</a>
                            <a href = "<?=base_url()?>profile/notes" class = "mini-links">Notes</a>
                        </div>
                    </div>
                    <br>
                    <div class = "card border-0">
                        <div class = "card-title">Entitlements
                            <div class = "modal-btn"><a href = "#" class = ""><i class="fas fa-plus"></i></i></a></div>
                        </div>
                        <table class="table table-hover table-xs mb-0">
                            <thead>
                                <th>Employee</th>
                                <th>Date</th>
                                <th>Leave Type</th>
                                <th>Value (Days)</th>
                                <th style="width: 250px;">Remaining Leave (Days) </th>
                            </thead>
                            <tbody style="font-weight: 500 !important;">
                                <?php 
                                    if($DISP_ENTITLEMENT_INFO){
                                        foreach($DISP_ENTITLEMENT_INFO as $DISP_ENTITLEMENT_INFO_ROW){
                                            $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_ENTITLEMENT_INFO_ROW->col_empl_id);
                                            $db_date = $DISP_ENTITLEMENT_INFO_ROW->col_date_created;
                                            $date = date('l, F j, Y',strtotime($db_date));
                                        ?>
                                        <tr>
                                            <td><?= $employee_id[0]->col_frst_name.' '.$employee_id[0]->col_last_name ?></td>
                                            <td><?= $date ?></td>
                                            <td><?= $DISP_ENTITLEMENT_INFO_ROW->col_leave_type ?></td>
                                            <td><?= $DISP_ENTITLEMENT_INFO_ROW->col_leave_value ?></td>
                                            <td><?= $DISP_ENTITLEMENT_INFO_ROW->col_leave_balance ?></td>
                                        </tr>
                                        <?php
                                        }
                                    } else {
                                    ?>
                                        <tr>
                                            <td class="p-4" colspan="5">No entitlements yet</td>
                                        </tr>
                                    <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class = "card border-0">
                        <div class = "card-title">Leave History
                            <div class = "modal-btn"><a href = "#" class = ""><i class="fas fa-plus"></i></i></a></div>
                        </div>
                        <table class="table table-hover table-xs mb-0 mt-4">
                            <thead>
                                <th>Date</th>
                                <th>Leave Type</th>
                                <th>Remaining Leave (Days)</th>
                                <th>Duration (Day/s)</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                <?php 
                                    if($DISP_MY_LEAVES){
                                        foreach($DISP_MY_LEAVES as $DISP_MY_LEAVES_ROW){
                                            $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_MY_LEAVES_ROW->col_empl_id);
                                            $db_date_from = $DISP_MY_LEAVES_ROW->col_leave_from;
                                            $date_from = date('l, F j, Y',strtotime($db_date_from));
                                            
                                            /* $leave_balance = $employee_id[0]->col_leave_balance;
                                            $db_total_leave_days = $this->P070_LEAVE_MOD->MOD_CALC_LEAVE_DAYS($db_date_from, $db_date_to, $DISP_MY_LEAVES_ROW->id);
                                            $total_leave_days = $db_total_leave_days["DATEDIFF('".$db_date_to."', '".$db_date_from."')"] + 1; */

                                            switch ($DISP_MY_LEAVES_ROW->col_leave_type) {
                                                case 'Vacation Leave':
                                                    $leave_balance = $employee_id[0]->col_leave_vacation;
                                                    break;
                                                case 'Sick Leave':
                                                    $leave_balance = $employee_id[0]->col_leave_sick;
                                                    break;
                                                case 'Maternity Leave':
                                                    $leave_balance = $employee_id[0]->col_leave_maternity;
                                                    break;
                                                case 'Parental Leave':
                                                    $leave_balance = $employee_id[0]->col_leave_parental;
                                                    break;
                                                case 'Paternity Leave':
                                                    $leave_balance = $employee_id[0]->col_leave_paternal;
                                                    break;
                                                case 'Rehabilitation Leave':
                                                    $leave_balance = $employee_id[0]->col_leave_rehabilitation;
                                                    break;
                                                case 'Service Incentive Leave':
                                                    $leave_balance = $employee_id[0]->col_leave_service_incentive;
                                                    break;
                                                case 'Study Leave':
                                                    $leave_balance = $employee_id[0]->col_leave_study;
                                                    break;
                                                default:
                                                $leave_balance = '';
                                            }
                                        ?>
                                        <tr>
                                            <td><?= $date_from?></td>
                                            <td><?= $DISP_MY_LEAVES_ROW->col_leave_type ?></td>
                                            <td><?= $leave_balance ?></td>
                                            <td><?= $DISP_MY_LEAVES_ROW->col_leave_duration ?></td>
                                            <td><?= $DISP_MY_LEAVES_ROW->col_leave_status ?></td>
                                        </tr>
                                        <?php
                                        }
                                    } else {
                                    ?>
                                        <tr>
                                        <td colspan="5" class="p-4">You haven't submitted any leave application yet</td>
                                        </tr>
                                    <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <div>
        </div>
	</div>

    <!-- Edit Profile Image -->
    <div class="modal fade" id="modal_edit_image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Update Profile Photo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('profile/edit_image'); ?>" id="edit_image_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                    <div class="modal-body">
                    <hr>
                        <div class="edit_profile_pic w-100 text-center">
                            <img class="avatar" id="employee_img_modal" style="cursor: pointer;" width="300" height="300" src="<?php if($user_image){echo base_url().'user_images/'.$user_image;} else {echo base_url().'user_images/default_profile_img3.png';}?>">
                        </div>
                        <div class="form-group mt-3">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input fileficker" id="upload_image" name="employee_image" multiple="" accept=".jpg, .png" required>
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="INSRT_EMPL_ID" value="<?= $user_id ?>">
                        <?php 
                            $url_count = $this->uri->total_segments();
                            $url_directory = $this->uri->segment($url_count);
                        ?>
                        <input type="hidden" name="URL_DIRECTORY" value="<?= $url_directory ?>">
                        <button class='btn btn-primary text-light px-3' type="submit" id="EDUC_BTN_INSRT">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<aside class="control-sidebar control-sidebar-dark">
	</aside>
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
    
        $(document).ready(function(){
            // Update Image
            $("#employee_img_modal").click(function(e) {
                $("#upload_image").click();
            });

            function fasterPreview( uploader ) {
                if ( uploader.files && uploader.files[0] ){
                    $('#employee_img_modal').attr('src', 
                    window.URL.createObjectURL(uploader.files[0]) );
                    $('.custom-file-label').text(uploader.files[0].name);
                }
            }

            $("#upload_image").change(function(){
                fasterPreview( this );
            });


            // Toggle modal by clicking the employee's profile photo
            $('#employee_img').click(function(){
                // $('#modal_edit_image').modal('toggle');
            })
        })
    </script>
</body>
</html>
