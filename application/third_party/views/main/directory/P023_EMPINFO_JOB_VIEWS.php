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
    border: 1px solid #ddd;
    }
    th, td {
        text-align: left;
        padding: 8px;
        font-weight: normal;
        font-size: 14px !important;
    }

    tr:nth-child(even){background-color: #f2f2f2}
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
</style>

<?php 
    $url_count = $this->uri->total_segments();
    $url_directory = $this->uri->segment($url_count);

    $user_info = $this->login_model->get_user_info($this->session->userdata('SESS_USER_ID'));

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
    $groups='';
    $group='';
    $line='';

    // Jobs Info
    $end_on='';
    $regularization_date='';
    $hmo='';
    $hmo_number='';

    // Salary Rate
    $salary_rate = '';
    $salary_type = '';

    $activation = '';

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
            $groups = $DISP_EMP_INFO_ROW->col_empl_group
            ;
            $line = $DISP_EMP_INFO_ROW->col_empl_line
            ;
            $reporting_to = $DISP_EMP_INFO_ROW->col_empl_repo
            ;

            $activation = $DISP_EMP_INFO_ROW->disabled
            ;

            // Jobs Info
            $end_on = $DISP_EMP_INFO_ROW->col_endd_date
            ;
            $regularization_date = $DISP_EMP_INFO_ROW->date_regular
            ;
            $hmo = $DISP_EMP_INFO_ROW->col_empl_hmoo
            ;
            $hmo_number = $DISP_EMP_INFO_ROW->col_empl_hmon
            ;

            // Salary Rate
            $salary_rate = $DISP_EMP_INFO_ROW->salary_rate
            ;
            $salary_type = $DISP_EMP_INFO_ROW->salary_type
            ;

            $activation = $DISP_EMP_INFO_ROW->disabled;
        }
    }
?>

<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
    
   
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<div class="content-wrapper">
        <div class = "nav-top">
            <?php
                $employee_id_next = $this->p020_emplist_mod->Next($user_id);
                $employee_id_prev = $this->p020_emplist_mod->Previous($user_id);
            ?>

            <!-- PREVIOUS -->
            <?php
                if($employee_id_prev){
                ?>
                    <a href = "<?= base_url() ?>employees/job?id=<?= $employee_id_prev[0]->id ?>" class = "top-left"><i class="fas fa-angle-left"></i>  Previous</a>
                <?php
                } else {
                ?>
                    <a href = "#" class = "top-left" style="pointer-events: none;cursor: default; color: #ccc"><i class="fas fa-angle-left"></i>  Previous</a>
                <?php
                }
            ?>

            <div class = "top-right">
                <!-- NEXT -->
                <?php
                    if($employee_id_next){
                    ?>
                        <a href = "<?= base_url() ?>employees/job?id=<?= $employee_id_next[0]->id ?>">Next  <i class="fas fa-angle-right"></i></a>
                    <?php
                    } else {
                    ?>
                        <a href = "#" style="pointer-events: none;cursor: default; color: #ccc">Next  <i class="fas fa-angle-right"></i></a>
                    <?php
                    }
                ?>
            </div>
        </div>
		<div class="container-fluid p-4">
            <div class = "row">
                <div class = "col-md-3">
                    <div class = "card border-0">
                        <div style = "text-align:center;">
                            <div class = "profile-pic">
                                <img class="rounded-circle avatar" id="employee_img" style="cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Update Profile Image" width="200" height="200" src="<?php if($user_image){echo base_url().'user_images/'.$user_image;} else {echo base_url().'user_images/default_profile_img3.png';}?>">
                            </div>
                            <text class = "emp-name"><?= $full_name ?></text>
                            <?php
                                if($DISP_EMP_INFO[0]->disabled > 0){
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
                                <div class = "card-title mt-2">Group</div>
                                <?= $group ?>
                                <div class = "card-title mt-2">Line</div>
                                <?= $line ?>
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
                                                            if($reporting_to){

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
                                                        <?php 
                                                            }
                                                        ?>
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
                            <a href = "<?=base_url()?>employees/personal?id=<?=$user_id?>" class = "mini-links">Personal</a>
                            <a href = "<?=base_url()?>employees/ids?id=<?=$user_id?>" class = "mini-links">ID's</a>
                            <a href = "<?=base_url()?>employees/job?id=<?=$user_id?>" class = "mini-links active">Job</a>
                            <!-- <a href = "<?=base_url()?>employees/leave?id=<?=$user_id?>" class = "mini-links">Leave</a> -->
                            <a href = "<?=base_url()?>employees/documents?id=<?=$user_id?>" class = "mini-links">Documents</a>
                            <!-- <a href = "<?=base_url()?>employees/tasks?id=<?=$user_id?>" class = "mini-links">Tasks</a> -->
                            <a href = "<?=base_url()?>employees/assets?id=<?=$user_id?>" class = "mini-links">Assets</a>
                            <a href = "<?=base_url()?>employees/emergency?id=<?=$user_id?>" class = "mini-links">Emergency</a>
                            <a href = "<?=base_url()?>employees/dependents?id=<?=$user_id?>" class = "mini-links">Dependents</a>
                            <a href = "<?=base_url()?>employees/notes?id=<?=$user_id?>" class = "mini-links">Notes</a>
                            <a href = "#" class="float-right text-secondary" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <form action="<?=base_url()?>employees/activate_employee" method="post" id="form_activate_empl">
                                    <input type="hidden" name="empl_id" value="<?=$user_id?>">
                                    <input type="hidden" name="url_directory" value="<?=$url_directory?>">
                                </form>
                                <?php
                                    if($activation == 0){
                                        ?>
                                            <a class="dropdown-item ml-0 text-danger" style="cursor:pointer;" data-toggle="modal" data-target="#modal_resign_employee">Resign/Terminate Employee</a>
                                        <?php
                                    } else {
                                        ?>
                                            <a class="dropdown-item ml-0 text-success" style="cursor:pointer;" id="btn_activate">Activate Employee</a>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class = "card border-0">
                        <div class = "card-title mb-0">
                            Job
                            <?php 
                                if(($user_info[0]->col_user_access == 2) || ($user_info[0]->col_user_access == 4)){
                                    ?>
                                        <div class="modal-btn"><a href="#" data-toggle="modal" data-target="#modal_edit_job"><i class="fas fa-pencil-alt"></i></a></div>
                                    <?php  
                                }
                            ?>
                            
                        </div>
                        <hr>
                        <div class = "row mb-4">
                            <div class = "col-md-6">
                                <div class = "row">
                                    <div class = "col col-md-4 ">
                                        Hired On
                                    </div>
                                    <div class = "col col-md-8">
                                        <p class="mb-0"><?= $hired_on ?></p>
                                    </div>
                                </div>
                                <div class = "row mt-3">
                                    <div class = "col col-md-4 ">
                                        Date of Regularization
                                    </div>
                                    <div class = "col col-md-8">
                                        <p class="mb-0"><?= $regularization_date ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-md-6">
                                <div class = "row">
                                    <div class = "col col-md-4 ">
                                        End On
                                    </div>
                                    <div class = "col col-md-8">
                                        <p class="mb-0"><?= $end_on ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "card border-0">
                        <div class = "card-title">
                            Employment Details
                            <?php 
                                if(($user_info[0]->col_user_access == 2) || ($user_info[0]->col_user_access == 4)){
                                    ?>
                                        <div class="modal-btn"><a href="#" data-toggle="modal" data-target="#modal_edit_employment_info"><i class="fas fa-pencil-alt"></i></a></div>
                                    <?php
                                }
                            ?>
                            
                        </div>
                        <hr style = "margin: 1px -20px 40px -20px">
                        <div class="row">
                            <div class="col-md-6">
                                <div class = "row">
                                    <div class = "col col-md-4">
                                        Employment Type
                                    </div>
                                    <div class = "col col-md-8">
                                        <span style="font-weight:normal"><?= $employment_type ?></span>
                                    </div>
                                </div>
                                <div class = "row mt-4">
                                    <div class = "col col-md-4">
                                        Position
                                    </div>
                                    <div class = "col col-md-8">
                                        <span style="font-weight:normal"><?= $position ?></span>
                                    </div>
                                </div>
                                <div class = "row mt-4">
                                    <div class = "col col-md-4">
                                        Groups
                                    </div>
                                    <div class = "col col-md-8">
                                        <span style="font-weight:normal"><?= $groups ?></span>
                                    </div>
                                </div>
                                <div class = "row mt-4">
                                    <div class = "col col-md-4">
                                        Department
                                    </div>
                                    <div class = "col col-md-8">
                                        <span style="font-weight:normal"><?= $department ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class = "row ">
                                    <div class = "col col-md-4">
                                        Line
                                    </div>
                                    <div class = "col col-md-8">
                                        <span style="font-weight:normal"><?= $line ?></span>
                                    </div>
                                </div>
                                <div class = "row mt-4">
                                    <div class = "col col-md-4">
                                        Sections
                                    </div>
                                    <div class = "col col-md-8">
                                        <span style="font-weight:normal"><?= $section ?></span>
                                    </div>
                                </div>
                                <div class = "row mt-4">
                                    <div class = "col col-md-4">
                                        HMO
                                    </div>
                                    <div class = "col col-md-8">
                                        <span style="font-weight:normal"><?= $hmo ?></span>
                                    </div>
                                </div>
                                <div class = "row mt-4">
                                    <div class = "col col-md-4">
                                        HMO Number
                                    </div>
                                    <div class = "col col-md-8">
                                        <span style="font-weight:normal"><?= $hmo_number ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class = "card border-0">
                        <div class = "card-title">
                            Salary
                            <?php 
                                if(($user_info[0]->col_user_access == 2) || ($user_info[0]->col_user_access == 4)){
                                    ?>
                                        <div class="modal-btn"><a href="#" data-toggle="modal" data-target="#modal_edit_salary_rate"><i class="fas fa-pencil-alt"></i></a></div>
                                    <?php
                                }
                            ?>
                            
                        </div>
                        <hr style = "margin: 1px -20px 20px -20px">
                        <div class="row">
                            <div class="col-md-6">
                                <div class = "row">
                                    <div class = "col col-md-6">
                                        Salary Type
                                    </div>
                                    <div class = "col col-md-6">
                                        <span style="font-weight:normal"><?= $salary_type ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class = "row">
                                    <div class = "col col-md-6">
                                        Salary Rate
                                    </div>
                                    <div class = "col col-md-6">
                                        <span style="font-weight:normal">&#8369; <?= $salary_rate ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div>
        </div>
	</div>

    
    <!-- Resign/Terminate Employee Modal -->
    <div class="modal fade" id="modal_resign_employee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Remove Employee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('employees/terminate_employee'); ?>" id="form_terminate_employee" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required">Date</label>
                                    <input class="form-control" autocomplete="off" type="date" value="<?= date('Y-m-d') ?>" name="termination_date" id="termination_date" >
                                </div>
                                <div class="form-group">
                                    <label class="required">Type</label>
                                    <select name="termination_type" id="termination_type" class="form-control">
                                        <option value="Resigned">Resigned</option>
                                        <option value="AWOL">AWOL</option>
                                        <option value="Resigned">Resigned</option>
                                        <option value="End of Contract">End of Contract</option>
                                        <option value="Terminated">Terminated</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required">Reason</label>
                                    <textarea name="termination_reason" class="form-control" placeholder="Enter your reason" id="termination_reason"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="empl_id" value="<?=$user_id?>">
                        <input type="hidden" name="url_directory" value="<?=$url_directory?>">
                        <button class='btn btn-primary text-light' type="submit" id="btn_terminate_employee">&nbsp; Remove</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Employement Details -->
    <div class="modal fade" id="modal_edit_employment_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Employment Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('employees/edit_employment_details'); ?>" id="FORM_EDIT_JOBS" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Employment Type</label>
                                    <select name="emp_type" id="emp_type" class="form-control" required>
                                        <option value="">Choose...</option>
                                        <?php 
                                            if($DISP_EMPTYPES){
                                                foreach($DISP_EMPTYPES as $DISP_EMPTYPES_ROW){
                                                ?>
                                                    <option value="<?= $DISP_EMPTYPES_ROW->name ?>" <?php if($DISP_EMPTYPES_ROW->name == $employment_type){echo 'selected';} ?>><?= $DISP_EMPTYPES_ROW->name ?></option>
                                                <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required"  for="UPDT_ID_SSS">Position</label>
                                    <select name="position" id="position" class="form-control" required>
                                        <option value="">Choose...</option>
                                        <?php 
                                            if($DISP_POSITION){
                                                foreach($DISP_POSITION as $DISP_POSITION_ROW){
                                                ?>
                                                    <option value="<?= $DISP_POSITION_ROW->name ?>" <?php if($DISP_POSITION_ROW->name == $position){echo 'selected';} ?>><?= $DISP_POSITION_ROW->name ?></option>
                                                <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required"  for="UPDT_ID_SSS">Department</label>
                                    <select name="department" id="department" class="form-control" required>
                                        <option value="">Choose...</option>
                                        <?php 
                                            if($DISP_DEPARTMENT){
                                                foreach($DISP_DEPARTMENT as $DISP_DEPARTMENT_ROW){
                                                ?>
                                                    <option value="<?= $DISP_DEPARTMENT_ROW->name ?>" <?php if($DISP_DEPARTMENT_ROW->name == $department){echo 'selected';} ?>><?= $DISP_DEPARTMENT_ROW->name ?></option>
                                                <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required"  for="UPDT_ID_SSS">Group</label>
                                    <select name="groups" id="groups" class="form-control" required>
                                        <option value="">Choose...</option>
                                        <?php 
                                            if($DISP_Group){
                                                foreach($DISP_Group as $DISP_Group_ROW){
                                                ?>
                                                    <option value="<?= $DISP_Group_ROW->name ?>" <?php if($DISP_Group_ROW->name == $groups){echo 'selected';} ?>><?= $DISP_Group_ROW->name ?></option>
                                                <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required"  for="line">Line</label>
                                    <select name="line" id="line" class="form-control" required>
                                        <option value="">Choose...</option>
                                        <?php 
                                            if($DISP_Line){
                                                foreach($DISP_Line as $DISP_Line_ROW){
                                                ?>
                                                    <option value="<?= $DISP_Line_ROW->col_empl_line ?>" <?php if($DISP_Line_ROW->col_empl_line == $line){echo 'selected';} ?>><?= $DISP_Line_ROW->col_empl_line ?></option>
                                                <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="required" for="section">Sections</label>
                                            <select name="section" id="section" class="form-control">
                                                <option value="">Choose...</option>
                                                <?php 
                                                    if($DISP_EMP_SECTION){
                                                        foreach($DISP_EMP_SECTION as $DISP_EMP_SECTION_ROW){
                                                        ?>
                                                            <option value="<?= $DISP_EMP_SECTION_ROW->name ?>" <?php if($DISP_EMP_SECTION_ROW->name == $section){echo 'selected';} ?> ><?= $DISP_EMP_SECTION_ROW->name ?></option>
                                                        <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required" for="hmo">HMO</label>
                                            <input class="form-control form-control " value="<?= $hmo ?>" type="text" name="hmo" id="hmo">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required" for="hmo_number">HMO Number</label>
                                            <input class="form-control form-control " value="<?= $hmo_number ?>" type="text" name="hmo_number" id="hmo_number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="EMPL_ID" id="EDUC_EMPL_ID" value="<?= $user_id ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="btn_edit_employment_details">&nbsp; Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Employement Details -->
    <div class="modal fade" id="modal_edit_salary_rate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Salary Rate</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('employees/edit_employee_salary_rate'); ?>" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" class="required" for="salary_type">Salary Type</label>
                                    <select name="salary_type" id="salary_type" class="form-control">
                                        <option value="">Choose...</option>
                                        <option value="Daily" <?php if($salary_type == 'Daily'){ echo 'selected';} ?>>Daily</option>
                                        <option value="Monthly" <?php if($salary_type == 'Monthly'){ echo 'selected';} ?>>Monthly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" class="required" for="salary_rate">Salary Rate</label>
                                    <input type="number" name="salary_rate" value="<?= $salary_rate ?>" step="0.01" id="salary_rate" class="form-control">
                                </div>
                            </div>
                            <input type="hidden" name="EMPL_ID" value="<?= $user_id ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit">&nbsp; Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Compensation -->
    <div class="modal fade" id="modal_add_compensation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Compensation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('employees/edit_employee_skill'); ?>" id="ADD_COMPENSATION_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Effetive From</label>
                                    <input class="form-control" autocomplete="off" type="date" value="<?= $company_email ?>" name=""  >
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="required">Amount</label>
                                        <input class="form-control" autocomplete="off" type="number" value="<?= $company_email ?>" name=""  >
                                    </div>
                                    <div class="col-md-4">
                                        <label class="required">Currency</label>
                                        <select name="INSRT_CURRENCY" id="INSRT_CURRENCY" class="form-control" required>
                                            <option value="">Choose...</option>
                                            <?php 
                                                if($DISP_SKILL_LEVEL_INFO){
                                                    foreach($DISP_SKILL_LEVEL_INFO as $DISP_SKILL_LEVEL_INFO_ROW){ ?>
                                                        <option value="<?= $DISP_SKILL_LEVEL_INFO_ROW->col_level_name ?>"><?= $DISP_SKILL_LEVEL_INFO_ROW->col_level_name ?></option>
                                            <?php   }
                                                } ?>
                                        <select>  
                                    </div>
                                    <div class="col-md-4">
                                        <label class="required">Per</label>
                                        <select name="INSRT_PER" id="INSRT_PER" class="form-control" required>
                                            <option value="">Choose...</option>
                                            <?php 
                                                if($DISP_SKILL_LEVEL_INFO){
                                                    foreach($DISP_SKILL_LEVEL_INFO as $DISP_SKILL_LEVEL_INFO_ROW){ ?>
                                                        <option value="<?= $DISP_SKILL_LEVEL_INFO_ROW->col_level_name ?>"><?= $DISP_SKILL_LEVEL_INFO_ROW->col_level_name ?></option>
                                            <?php   }
                                                } ?>
                                        <select>  
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <label class="">Effective From</label>
                                    <select class="form-control" name=""  >
                                        <option value="">Choose...</option>
                                    </select>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="icheck-primary pb-2" style="font-size: 14px; display: block;">
                                                <input type="checkbox" id="CHCK_CERT_EXPIRES_UPDT" name="CHCK_CERT_EXPIRES_UPDT">
                                                <label for="CHCK_CERT_EXPIRES_UPDT" style="font-weight: 500 !important; font-size: 14px !important;">
                                                    Overtime
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <label class="">Comment</label>
                                    <textarea name=""  class="form-control" cols="30" rows="4"></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="UPDT_SKILL_EMPL_ID" id="UPDT_SKILL_EMPL_ID">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="SKILL_BTN_UPDT">&nbsp; Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Job -->
    <div class="modal fade" id="modal_edit_job" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Job</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('employees/edit_employee_job'); ?>" id="EDIT_JOB_FORM" method="post" accept-charset="utf-8" autocomplete='off'>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Hired On</label>
                                    <input type="date" class="form-control" name="UPDT_JOB_HIRE_ON" id="UPDT_JOB_HIRE_ON" value="<?= $hired_on ?>">
                                </div>
                                <div class="form-group">
                                    <label class="">Ends On</label>
                                    <input type="date" class="form-control" name="UPDT_JOB_END_ON" id="UPDT_JOB_END_ON" value="<?= $end_on ?>">
                                </div>
                                <div class="form-group">
                                    <label class="">Date of Regularization</label>
                                    <input type="date" class="form-control" name="UPDT_REG_DATE" id="UPDT_REG_DATE" value="<?= $regularization_date ?>">
                                </div>
                                
                            </div>
                            <input type="hidden" name="UPDT_EMPL_ID" value="<?= $user_id ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="Submit" class="btn btn-primary text-white" id="BTN_EDIT_JOB" style="width:62.22px;">Save</a>
                    </div>
                </form>
            </div>
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
                <form action="<?php echo base_url('employees/edit_image'); ?>" id="edit_image_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
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
    <?php
    if($this->session->userdata('SESS_EMPLOYEE_TERMINATED')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_EMPLOYEE_TERMINATED'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_EMPLOYEE_TERMINATED');
    }
    ?>


    <?php
    if($this->session->userdata('SESS_SUCC_UPDT_EMPL_JOB')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_UPDT_EMPL_JOB'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_UPDT_EMPL_JOB');
    }
    ?>

    <script>
        
        $(document).ready(function(){

            $('#btn_terminate_employee').click(function(e){
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to terminate this employee?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form_terminate_employee').submit();
                    }
                })
            })

            $('#btn_activate').click(function(){
                $('#form_activate_empl').submit();
            })

            // edit job
            $('#BTN_EDIT_JOB').click(function(e){
                Swal.fire({
                    title: 'Do you want to save the following changes?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#EDIT_JOB_FORM').submit();
                    }
                })
            })

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
                $('#modal_edit_image').modal('toggle');
            })
        })
    </script>

</body>
</html>
