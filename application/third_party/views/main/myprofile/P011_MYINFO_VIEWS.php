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
        /* background-color: ; */
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
            /* background-color: ; */
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
        /* background-color:; */
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
    }

    .mini-nav{
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
    .media-title{
        font-weight: 600;
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
    $employee_id='';
    $lastname='';
    $middlename='';
    $firstname='';
    $full_name='';
    $marital_status='';
    $home_address='';
    $current_address='';
    $birthdate='';
    $nationality='';
    $email='';
    $gender='';
    $shirt_size='';
    $mobile_number='';

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

    if($DISP_USER_INFO){
        foreach($DISP_USER_INFO as $DISP_USER_INFO_ROW){
            // Key id
            $user_id = $DISP_USER_INFO_ROW->id;

            // Set personal Info
            $user_image = $DISP_USER_INFO_ROW->col_imag_path
            ;
            $employee_id = $DISP_USER_INFO_ROW->col_empl_cmid
            ;
            $lastname = $DISP_USER_INFO_ROW->col_last_name
            ;
            $middlename = $DISP_USER_INFO_ROW->col_midl_name
            ;
            $firstname = $DISP_USER_INFO_ROW->col_frst_name
            ;
            $marital_status = $DISP_USER_INFO_ROW->col_mart_stat
            ;
            $home_address = $DISP_USER_INFO_ROW->col_home_addr
            ;
            $current_address = $DISP_USER_INFO_ROW->col_curr_addr
            ;
            $birthdate = $DISP_USER_INFO_ROW->col_birt_date
            ;
            $nationality = $DISP_USER_INFO_ROW->col_empl_nati
            ;
            $email = $DISP_USER_INFO_ROW->col_empl_emai
            ;
            $gender = $DISP_USER_INFO_ROW->col_empl_gend
            ;
            $shirt_size = $DISP_USER_INFO_ROW->col_shir_size
            ;
            $mobile_number = $DISP_USER_INFO_ROW->col_mobl_numb
            ;
            
            if($middlename){
                $full_name = $lastname.', '.$firstname.' '. $middlename;
            } else {
                $full_name = $lastname.', '.$firstname;
            }
            

            // Set company Info
            $company_number = $DISP_USER_INFO_ROW->col_comp_numb
            ;
            $company_email = $DISP_USER_INFO_ROW->col_comp_emai
            ;
            $hired_on = $DISP_USER_INFO_ROW->col_hire_date
            ;
            $employment_type = $DISP_USER_INFO_ROW->col_empl_type
            ;
            $position = $DISP_USER_INFO_ROW->col_empl_posi
            ;
            $section = $DISP_USER_INFO_ROW->col_empl_sect
            ;
            $department = $DISP_USER_INFO_ROW->col_empl_dept
            ;
            $division = $DISP_USER_INFO_ROW->col_empl_divi
            ;
            $reporting_to = $DISP_USER_INFO_ROW->col_empl_repo
            ;
        }
    }
?>

<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">

	<div class="content-wrapper">
		<div class="container-fluid p-4">
            <div class = "row">
                <div class = "col-md-3">
                    <div class = "card border-0">
                        <div style = "text-align:center;">
                            <div class = "profile-pic">
                                <img class="rounded-circle avatar" id="employee_img" style="cursor: pointer;" width="200" height="200" src="<?php if($user_image){echo base_url().'user_images/'.$user_image;} else {echo base_url().'user_images/default_profile_img3.png';}?>">
                            </div>
                            <text class = "emp-name"><?= $full_name ?></text><br>
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
                            <a href = "<?=base_url()?>profile" class = "mini-links active">Personal</a>
                            <a href = "<?=base_url()?>profile/ids" class = "mini-links">ID's</a>
                            <a href = "<?=base_url()?>profile/job" class = "mini-links">Job</a>
                            <a href = "<?=base_url()?>profile/allowance" class = "mini-links">Allowance</a>
                            <!-- <a href = "<?=base_url()?>profile/leave" class = "mini-links">Leave</a> -->
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
                        <div class = "card-title mb-0">Personal Details
                            <div class = "modal-btn"><a href="#" style="display:none;" data-toggle="modal" data-target="#modal_edit_employee_info"><i class="fas fa-pencil-alt"></i></a></div>
                        </div>
                        <hr>
                        <div class = "row mt-3">
                            <div class = "col-md-6">
                                <div class = "row">
                                    <div class = "col col-md-6 text-bold">
                                        Employee ID
                                    </div>
                                    <div class = "col col-md-6">
                                        <span style="font-weight:normal"><?= $employee_id ?></span>
                                    </div>
                                </div>
                                <div class = "row mt-4">
                                    <div class = "col col-md-6 text-bold">
                                        First Name
                                    </div>
                                    <div class = "col col-md-6">
                                        <span style="font-weight:normal"><?= $firstname ?></span>
                                    </div>
                                </div>
                                <div class = "row mt-4">
                                    <div class = "col col-md-6 text-bold">
                                        Middle Name
                                    </div>
                                    <div class = "col col-md-6">
                                        <span style="font-weight:normal"><?= substr($middlename, 0, 1).'.' ?></span>
                                    </div>
                                </div>
                                <div class = "row mt-4">
                                    <div class = "col col-md-6 text-bold">
                                        Last Name
                                    </div>
                                    <div class = "col col-md-6">
                                        <span style="font-weight:normal"><?= $lastname ?></span>
                                    </div>
                                </div>
                                <div class = "row mt-4">
                                    <div class = "col col-md-6 text-bold">
                                        Marital Status
                                    </div>
                                    <div class = "col col-md-6">
                                        <span style="font-weight:normal"><?= $marital_status ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class = "row">
                                    <div class = "col col-md-6 text-bold">
                                        Birthdate
                                    </div>
                                    <div class = "col col-md-6">
                                        <span style="font-weight:normal"><?= $birthdate ?></span>
                                    </div>
                                </div>
                                <div class = "row mt-4">
                                    <div class = "col col-md-6 text-bold">
                                        Gender
                                    </div>
                                    <div class = "col col-md-6">
                                        <span style="font-weight:normal"><?= $gender ?></span>
                                    </div>
                                </div>
                                <div class = "row mt-4">
                                    <div class = "col col-md-6 text-bold">
                                        Nationality
                                    </div>
                                    <div class = "col col-md-6">
                                        <span style="font-weight:normal"><?= $nationality ?></span>
                                    </div>
                                </div>
                                <div class = "row mt-4">
                                    <div class = "col col-md-6 text-bold">
                                        Shirt size
                                    </div>
                                    <div class = "col col-md-6">
                                        <span style="font-weight:normal"><?= $shirt_size ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "row mt-4">
                            <div class = "col col-md-3 text-bold">
                                Home Address
                            </div>
                            <div class = "col col-md-9">
                                <span style="font-weight:normal"><?= $home_address ?></span>
                            </div>
                        </div>
                        <div class = "row mt-4">
                            <div class = "col col-md-3 text-bold">
                                Current Address
                            </div>
                            <div class = "col col-md-9">
                                <span style="font-weight:normal"><?= $current_address ?></span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class = "card border-0">
                        <div class = "card-title">Contact Details
                            <div class = "modal-btn"><a href="#" style="display:none;" data-toggle="modal" data-target="#modal_edit_employee_contact"><i class="fas fa-pencil-alt"></i></a></div>
                        </div>
                        <div class = "row mt-4">
                            <div class = "col-md-6">
                                <div class = "row">
                                    <div class = "col col-md-6 text-bold">
                                        Mobile Number
                                    </div>
                                    <div class = "col col-md-6">
                                        <span style="font-weight:normal"><?= $mobile_number ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-md-6">
                                <div class = "row">
                                    <div class = "col col-md-6 text-bold">
                                        Work Phone Number
                                    </div>
                                    <div class = "col col-md-6">
                                        <span style="font-weight:normal"><?= $company_number ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "row mt-4">
                            <div class = "col-md-6">
                                <div class = "row">
                                    <div class = "col col-md-6 text-bold">
                                        Personal Email
                                    </div>
                                    <div class = "col col-md-6">
                                        <span style="font-weight:normal"><?= $email ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-md-6">
                                <div class = "row">
                                    <div class = "col col-md-6 text-bold">
                                        Work Email
                                    </div>
                                    <div class = "col col-md-6">
                                        <span style="font-weight:normal"><?= $company_email ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "card border-0">
                        <div class = "card-title"><i class="fas fa-graduation-cap"></i>  Education
                            <div class = "modal-btn"><a href="#" style="display:none;" data-toggle="modal" data-target="#modal_add_education"><i class="fas fa-plus"></i></i></a></div>
                        </div>
                        <div class="card-body">
                            <?php 
                            if($DISP_EDUCATION_INFO){
                                foreach($DISP_EDUCATION_INFO as $DISP_EDUCATION_INFO_ROW){
                            ?>
                                <ul class="media-list pl-0">
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="btn-toolbar float-right" style="display: none;" role="toolbar" aria-label="Toolbar with button groups">
                                                <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                                    <a class="btn indigo lighten-2" title="Edit" education_id="<?=$DISP_EDUCATION_INFO_ROW->id?>" data-toggle="modal" data-target="#modal_edit_education"><i class="fas fa-edit"></i></a>
                                                    <a class="btn indigo lighten-2 EDUC_BTN_DLT" title="Delete" employee_id="<?=$DISP_EDUCATION_INFO_ROW->col_empl_id?>" delete_key="<?=$DISP_EDUCATION_INFO_ROW->id?>"><i class="fas fa-trash text-danger"></i></a>
                                                </div>
                                            </div>
                                            <h5 class="media-title"><?= $DISP_EDUCATION_INFO_ROW->col_educ_school ?></h5>
                                            <h6><?= $DISP_EDUCATION_INFO_ROW->col_educ_degree ?>  - <?= $DISP_EDUCATION_INFO_ROW->col_educ_grade ?></h6>
                                                <?= $DISP_EDUCATION_INFO_ROW->col_educ_from_yr ?> - <?= $DISP_EDUCATION_INFO_ROW->col_educ_to_yr ?>
                                        </div>
                                    </li>
                                </ul>
                            <?php 
                                }
                            } else { ?>
                                <div class="text-center mt-4 mb-4">
                                    <i class="fas fa-graduation-cap fa-4x text-muted"></i>
                                    <h3 class="text-muted mb-4 mt-2"><?= $firstname ?> has not added any educational background</h3>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class = "card border-0">
                        <div class = "card-title"><i class="fas fa-certificate"></i>  Licenses & Certifications
                            <div class = "modal-btn"><a href="#" style="display:none;" data-toggle="modal" data-target="#modal_add_certification"><i class="fas fa-plus"></i></i></a></div>
                        </div>
                        <div class="card-body">
                            <?php 
                            if($DISP_LICENSE_INFO){
                                foreach($DISP_LICENSE_INFO as $DISP_LICENSE_INFO_ROW){
                            ?>
                                <ul class="media-list pl-0">
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="btn-toolbar float-right" style="display: none;" role="toolbar" aria-label="Toolbar with button groups">
                                                <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                                    <a class="btn indigo lighten-2" title="Edit"  certification_id="<?=$DISP_LICENSE_INFO_ROW->id?>" href="#" data-toggle="modal" data-target="#modal_edit_certificate"><i class="fas fa-edit"></i></a>
                                                    <a class="btn indigo lighten-2 CERT_BTN_DLT" title="Delete" employee_id="<?=$DISP_LICENSE_INFO_ROW->col_empl_id?>" delete_key="<?=$DISP_LICENSE_INFO_ROW->id?>"><i class="fas fa-trash text-danger"></i></a>
                                                </div>
                                            </div>
                                        <h5 class="media-title"><?= $DISP_LICENSE_INFO_ROW->col_cert_name ?></h5>
                                        <h6><?= $DISP_LICENSE_INFO_ROW->col_cert_issuer ?></h6>
                                            Issued On <?= $DISP_LICENSE_INFO_ROW->col_cert_issued_on ?>
                                            <?php if(($DISP_LICENSE_INFO_ROW->col_cert_expires_on != "0000-00-00")){ ?>
                                                <br>
                                                Expires On <?= $DISP_LICENSE_INFO_ROW->col_cert_expires_on ?>
                                            <?php } ?>
                                        </div>
                                    </li>
                                </ul>
                            <?php 
                                }
                            } else { ?>
                                <div class="text-center mt-4 mb-4">
                                    <i class="fas fa-certificate  fa-4x text-muted"></i>
                                    <h3 class="text-muted mb-4 mt-2"><?= $firstname ?> has not added any licenses or certifications</h3>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class = "card border-0">
                        <div class = "card-title"><i class="fas fa-book-open"></i>  Skills
                            <div class = "modal-btn"><a href="#" style="display:none;" data-toggle="modal" data-target="#modal_add_skills"><i class="fas fa-plus"></i></i></a></div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group" >
                                <?php 
                                if($DISP_EMPL_SKILLS_INFO){
                                    foreach($DISP_EMPL_SKILLS_INFO as $DISP_EMPL_SKILLS_INFO_ROW){
                                ?>
                                
                                        <li class="list-group-item w-100" style="border:none !important;">
                                            <?= $DISP_EMPL_SKILLS_INFO_ROW->col_skill_name ?>
                                            <span class="badge badge-primary ml-2"><?= $DISP_EMPL_SKILLS_INFO_ROW->col_skill_level ?></span>
                                            <a href="#" class="btn btn-sm btn-light float-right text-center" style="display: none; width: 4.5px;padding: 5px 15px !important;" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v" style="width: 4.5px !important;height: 13px !important;margin-left: -2px;"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" skill_id="<?= $DISP_EMPL_SKILLS_INFO_ROW->id ?>" data-toggle="modal" data-target="#modal_edit_skills">
                                                    Edit
                                                </a>
                                                <a class="dropdown-item text-danger SKILL_BTN_DLT" href="#" employee_id="<?=$DISP_EMPL_SKILLS_INFO_ROW->col_empl_id?>" delete_key="<?=$DISP_EMPL_SKILLS_INFO_ROW->id?>">
                                                    Delete
                                                </a>              
                                            </div>
                                        </li>
                                    
                                <?php 
                                    }
                                } else { ?>
                                    <div class="text-center mt-4 mb-4">
                                        <i class="fas fa-book-open  fa-4x text-muted"></i>
                                        <h3 class="text-muted mb-4 mt-2"><?= $firstname ?> has not added any skills</h3>
                                    </div>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <div>
        </div>
	</div>

    <!-- Add Education -->
    <div class="modal fade" id="modal_add_education" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Education</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('settings/insrt_education'); ?>" id="ADD_EDUC_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">School</label>
                                    <input class="form-control form-control " type="text" name="INSRT_EDUC_SCHOOL" id="INSRT_EDUC_SCHOOL" required>
                                </div>
                                <div class="form-group">
                                    <label class="required"  for="UPDT_ID_SSS">Degree</label>
                                    <input class="form-control form-control " type="text" name="INSRT_EDUC_DEGREE" id="INSRT_EDUC_DEGREE" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="UPDT_ID_SSS">From Year</label>
                                            <input class="form-control form-control " type="text" name="INSRT_EDUC_FROM_YEAR" id="INSRT_EDUC_FROM_YEAR">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="UPDT_ID_SSS">To Year (or year expected)</label>
                                            <input class="form-control form-control " type="text" name="INSRT_EDUC_TO_YEAR" id="INSRT_EDUC_TO_YEAR">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="UPDT_ID_SSS">Grade</label>
                                    <input class="form-control form-control " type="text" name="INSRT_EDUC_GRADE" id="INSRT_EDUC_GRADE">
                                </div>
                            </div>
                            <input type="hidden" name="EMPL_ID" id="EDUC_EMPL_ID" value="<?= $user_id ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="EDUC_BTN_INSRT">&nbsp; Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Add License and Certificates -->
    <div class="modal fade" id="modal_add_certification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add License & Certification</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('settings/insrt_license'); ?>" id="ADD_CERT_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" class="required" for="INSRT_CERT_NAME">Name</label>
                                    <input class="form-control form-control " type="text" name="INSRT_CERT_NAME" id="INSRT_CERT_NAME" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="INSRT_CERT_ISSUER">Issuer</label>
                                    <input class="form-control form-control " type="text" name="INSRT_CERT_ISSUER" id="INSRT_CERT_ISSUER" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="INSRT_CERT_ISSUED_ON">Issued On</label>
                                    <input class="form-control form-control " type="date" name="INSRT_CERT_ISSUED_ON" id="INSRT_CERT_ISSUED_ON" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="icheck-primary pb-2" style="font-size: 14px; display: block;">
                                                <input type="checkbox" id="CHCK_CERT_EXPIRES" name="CHCK_CERT_EXPIRES">
                                                <label for="CHCK_CERT_EXPIRES" style="font-weight: 500 !important; font-size: 14px !important;">
                                                    Expires
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 show_expire" style="display:none;">
                                        <div class="form-group">
                                            <label for="INSRT_CERT_EXPIRE">Expires On</label>
                                            <input class="form-control form-control" type="date" name="INSRT_CERT_EXPIRE" id="INSRT_CERT_EXPIRE">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="CERT_EMPL_ID" id="CERT_EMPL_ID" value="<?= $user_id ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="CERT_BTN_INSRT">&nbsp; Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Add Skills -->
    <div class="modal fade" id="modal_add_skills" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Skills</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('profile/insrt_skill'); ?>" id="ADD_SKILLS_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" class="required" for="INSRT_SKILL_NAME">Skill</label>
                                    <select name="INSRT_SKILL_NAME" id="INSRT_SKILL_NAME" class="form-control" required>
                                        <option value="">Choose...</option>
                                        <?php 
                                            if($DISP_SKILL_INFO){
                                                foreach($DISP_SKILL_INFO as $DISP_SKILL_INFO_ROW){ ?>
                                                    <option value="<?= $DISP_SKILL_INFO_ROW->col_skill_name ?>"><?= $DISP_SKILL_INFO_ROW->col_skill_name ?></option>
                                        <?php   }
                                            } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="INSRT_SKILL_LEVEL">Level</label>
                                    <select name="INSRT_SKILL_LEVEL" id="INSRT_SKILL_LEVEL" class="form-control" required>
                                        <option value="">Choose...</option>
                                        <?php 
                                            if($DISP_SKILL_LEVEL_INFO){
                                                foreach($DISP_SKILL_LEVEL_INFO as $DISP_SKILL_LEVEL_INFO_ROW){ ?>
                                                    <option value="<?= $DISP_SKILL_LEVEL_INFO_ROW->col_level_name ?>"><?= $DISP_SKILL_LEVEL_INFO_ROW->col_level_name ?></option>
                                        <?php   }
                                            } ?>
                                    <select>  
                                </div>
                                <div x-show="level == 'interested'">
                                    <p>You have a common knowledge level of understanding in this area and a basic understanding of the skills and techniques required to practically apply this skill.</p>
                                    <p>You have identified this as a key area of interest and are interested in developing it further.</p>
                                    <ul>
                                        <li>Basic knowledge</li>
                                        <li>Focus on learning</li>
                                    </ul>
                                </div>
                            </div>
                            <input type="hidden" name="SKILL_EMPL_ID" id="SKILL_EMPL_ID" value="<?= $user_id ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="BTN_SKILL_ADD">&nbsp; Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Personal Information -->
    <div class="modal fade" id="modal_edit_employee_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Personal Info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('profile/edit_employee_info'); ?>" id="EDIT_EMPLOYEE_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Employee ID</label>
                                    <input class="form-control" autocomplete="off" type="text" value="<?= $employee_id ?>" name="UPDT_EMPL_ID" id="UPDT_EMPL_ID" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Last Name</label>
                                            <input class="form-control" autocomplete="off" type="text" value="<?= $lastname ?>" name="UPDT_EMPL_LNAME" id="UPDT_EMPL_LNAME" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Middle Name</label>
                                            <input class="form-control" autocomplete="off" type="text" value="<?= $middlename ?>" name="UPDT_EMPL_MNAME" id="UPDT_EMPL_MNAME" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">First Name</label>
                                            <input class="form-control" autocomplete="off" type="text" value="<?= $firstname ?>" name="UPDT_EMPL_FNAME" id="UPDT_EMPL_FNAME" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">Gender</label>
                                            <select name="UPDT_EMPL_GENDER" id="UPDT_EMPL_GENDER" class="form-control" required>
                                                <option value="<?= $gender ?>"><?= $gender ?></option>
                                                <?php 
                                                    if($DISP_GENDER_INFO){
                                                        foreach($DISP_GENDER_INFO as $DISP_GENDER_INFO_ROW){ ?>
                                                            <option value="<?= $DISP_GENDER_INFO_ROW->name ?>"><?= $DISP_GENDER_INFO_ROW->name ?></option>
                                                <?php   }
                                                    } ?>
                                            <select>  
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">Marital Status</label>
                                            <select class="custom-select mr-sm-2" id="UPDT_EMPL_MRTL_STAT" name="UPDT_EMPL_MRTL_STAT" required>
                                                <option value="<?= $marital_status ?>" selected><?= $marital_status ?></option>
                                                <?php foreach($DISP_MRTL_STAT as $DISP_MRTL_STAT_ROW){?>
                                                        <option value="<?= $DISP_MRTL_STAT_ROW->name ?>"><?= $DISP_MRTL_STAT_ROW->name ?></option>
                                                <?php } ?>
                                            </select> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">Shirt Size</label>
                                            <select class="custom-select mr-sm-2" id="UPDT_EMPL_SHIRT_SIZE" name="UPDT_EMPL_SHIRT_SIZE">
                                                <option value="<?= $shirt_size ?>" selected><?= $shirt_size ?></option>
                                                <?php foreach($DISP_SHRT_SIZE as $DISP_SHRT_SIZE_ROW){?>
                                                        <option value="<?= $DISP_SHRT_SIZE_ROW->name ?>"><?= $DISP_SHRT_SIZE_ROW->name ?></option>
                                                <?php } ?>
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">Nationality</label>
                                            <select class="custom-select mr-sm-2" id="UPDT_EMPL_NATIONALITY" name="UPDT_EMPL_NATIONALITY" required>
                                                <option value="<?= $nationality ?>" selected><?= $nationality ?></option>
                                                <?php foreach($DISP_NATIONALITY as $DISP_NATIONALITY_ROW){?>
                                                        <option value="<?= $DISP_NATIONALITY_ROW->name ?>"><?= $DISP_NATIONALITY_ROW->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="">Home Address</label>
                                            <input class="form-control" autocomplete="off" type="text" value="<?= $home_address ?>" name="UPDT_EMPL_HOME_ADDR" id="UPDT_EMPL_HOME_ADDR">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="">Current Address</label>
                                            <input class="form-control" autocomplete="off" type="text" value="<?= $current_address ?>" name="UPDT_EMPL_CURR_ADDR" id="UPDT_EMPL_CURR_ADDR">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="">Date of Birth</label>
                                            <input class="form-control" autocomplete="off" type="date" value="<?= $birthdate ?>" name="UPDT_EMPL_BIRTHDAY" id="UPDT_EMPL_BIRTHDAY">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="EDIT_EMPL_ID" id="EDIT_EMPL_ID" value="<?= $user_id ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="BTN_EMPL_UPDT">&nbsp; Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Employee Contact -->
    <div class="modal fade" id="modal_edit_employee_contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Contact</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('profile/edit_employee_contact'); ?>" id="EDIT_EMPLOYEE_CONTACT_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Mobile Number</label>
                                            <input class="form-control" autocomplete="off" type="text" value="<?= $mobile_number ?>" name="UPDT_EMPL_PERS_NUMBER" id="UPDT_EMPL_PERS_NUMBER" placeholder="e.g 09091234567" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Work Phone Number</label>
                                            <input class="form-control" autocomplete="off" type="text" value="<?= $company_number ?>" name="UPDT_EMPL_WORK_NUMBER" id="UPDT_EMPL_WORK_NUMBER" placeholder="e.g 834-4000" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="">Work Email</label>
                                    <input class="form-control" autocomplete="off" type="text" value="<?= $company_email ?>" name="UPDT_EMPL_WORK_EMAIL" id="UPDT_EMPL_WORK_EMAIL" >
                                </div>
                                <div class="form-group">
                                    <label class="">Personal Email</label>
                                    <input class="form-control" autocomplete="off" type="text" value="<?= $email ?>" name="UPDT_EMPL_PERS_EMAIL" id="UPDT_EMPL_PERS_EMAIL" >
                                    <small id="emailHelp" class="form-text text-muted">Personal email will be used to login.</small>
                                </div>
                            </div>
                            <input type="hidden" name="EDIT_EMPL_ID" value="<?= $user_id ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="BTN_EMPL_CONTACT_UPDT">&nbsp; Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Education -->
    <div class="modal fade" id="modal_edit_education" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Education</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('profile/edit_employee_education'); ?>" id="EDIT_EDUC_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">School</label>
                                    <input class="form-control form-control " type="text" name="UPDT_EDUC_SCHOOL" id="UPDT_EDUC_SCHOOL" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="UPDT_ID_SSS">Degree</label>
                                    <input class="form-control form-control " type="text" name="UPDT_EDUC_DEGREE" id="UPDT_EDUC_DEGREE" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="UPDT_ID_SSS">From Year</label>
                                            <input class="form-control form-control " type="text" name="UPDT_EDUC_FROM_YEAR" id="UPDT_EDUC_FROM_YEAR">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="UPDT_ID_SSS">To Year (or year expected)</label>
                                            <input class="form-control form-control " type="text" name="UPDT_EDUC_TO_YEAR" id="UPDT_EDUC_TO_YEAR">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="UPDT_ID_SSS">Grade</label>
                                    <input class="form-control form-control " type="text" name="UPDT_EDUC_GRADE" id="UPDT_EDUC_GRADE">
                                </div>
                            </div>
                            <input type="hidden" name="UPDT_EDUC_ID" id="UPDT_EDUC_ID">
                            <input type="hidden" name="UPDT_EDUC_EMPL_ID" id="UPDT_EDUC_EMPL_ID">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="EDUC_BTN_UPDT">&nbsp; Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Certifications -->
    <div class="modal fade" id="modal_edit_certificate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit License and Certifications</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('profile/edit_employee_certification'); ?>" id="EDIT_CERT_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_CERT_NAME">Name</label>
                                    <input class="form-control form-control " type="text" name="UPDT_CERT_NAME" id="UPDT_CERT_NAME" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="UPDT_CERT_ISSUER">Issuer</label>
                                    <input class="form-control form-control " type="text" name="UPDT_CERT_ISSUER" id="UPDT_CERT_ISSUER" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="UPDT_CERT_ISSUED_ON">Issued On</label>
                                    <input class="form-control form-control " type="date" name="UPDT_CERT_ISSUED_ON" id="UPDT_CERT_ISSUED_ON" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="icheck-primary pb-2" style="font-size: 14px; display: block;">
                                                <input type="checkbox" id="CHCK_CERT_EXPIRES_UPDT" name="CHCK_CERT_EXPIRES_UPDT">
                                                <label for="CHCK_CERT_EXPIRES_UPDT" style="font-weight: 500 !important; font-size: 14px !important;">
                                                    Expires
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 show_expire_updt" style="display:none;">
                                        <div class="form-group">
                                            <label for="UPDT_CERT_EXPIRE">Expires On</label>
                                            <input class="form-control form-control" type="date" name="UPDT_CERT_EXPIRE" id="UPDT_CERT_EXPIRE">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="UPDT_CERT_ID" id="UPDT_CERT_ID">
                            <input type="hidden" name="UPDT_CERT_EMPL_ID" id="UPDT_CERT_EMPL_ID">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="CERT_BTN_UPDT">&nbsp; Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Skills -->
    <div class="modal fade" id="modal_edit_skills" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Skill</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('profile/edit_employee_skill'); ?>" id="EDIT_SKILL_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_SKILL_NAME">Skill</label>
                                    <select name="UPDT_SKILL_NAME" id="UPDT_SKILL_NAME" class="form-control">
                                        <option value="">Choose...</option>
                                        <?php 
                                            if($DISP_SKILL_INFO){
                                                foreach($DISP_SKILL_INFO as $DISP_SKILL_INFO_ROW){ ?>
                                                    <option value="<?= $DISP_SKILL_INFO_ROW->col_skill_name ?>"><?= $DISP_SKILL_INFO_ROW->col_skill_name ?></option>
                                        <?php   }
                                            } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="UPDT_SKILL_LEVEL">Level</label>
                                    <select name="UPDT_SKILL_LEVEL" id="UPDT_SKILL_LEVEL" class="form-control">
                                        <option value="">Choose...</option>
                                        <?php 
                                            if($DISP_SKILL_LEVEL_INFO){
                                                foreach($DISP_SKILL_LEVEL_INFO as $DISP_SKILL_LEVEL_INFO_ROW){ ?>
                                                    <option value="<?= $DISP_SKILL_LEVEL_INFO_ROW->col_level_name ?>"><?= $DISP_SKILL_LEVEL_INFO_ROW->col_level_name ?></option>
                                        <?php   }
                                            } ?>
                                    <select>  
                                </div>
                                <div x-show="level == 'interested'">
                                    <p>You have a common knowledge level of understanding in this area and a basic understanding of the skills and techniques required to practically apply this skill.</p>
                                    <p>You have identified this as a key area of interest and are interested in developing it further.</p>
                                    <ul>
                                        <li>Basic knowledge</li>
                                        <li>Focus on learning</li>
                                    </ul>
                                </div>
                            </div>
                            <input type="hidden" name="UPDT_SKILL_ID" id="UPDT_SKILL_ID">
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
    <?php
    if($this->session->userdata('SESS_SUCC_MSG_INSRT_EDUCATION')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_EDUCATION'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_EDUCATION');
    }
    ?>
    <?php
    if($this->session->userdata('SESS_SUCC_MSG_INSRT_CERTIFICATION')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_CERTIFICATION'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_CERTIFICATION');
    }
    ?>
    <?php
    if($this->session->userdata('SESS_SUCC_INSRT_SKILL')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_INSRT_SKILL'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_INSRT_SKILL');
    }
    ?>
    <?php
    if($this->session->userdata('SESS_SUCC_UPDT_EMPL_INFO')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_UPDT_EMPL_INFO'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_UPDT_EMPL_INFO');
    }
    ?>
    <?php
    if($this->session->userdata('SESS_SUCC_UPDT_EMPL_CONTACT')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_UPDT_EMPL_CONTACT'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_UPDT_EMPL_CONTACT');
    }
    ?>
    <?php
    if($this->session->userdata('SESS_SUCC_UPDT_EMPL_EDUC')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_UPDT_EMPL_EDUC'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_UPDT_EMPL_EDUC');
    }
    ?>
    <?php
    if($this->session->userdata('SESS_SUCC_MSG_DLT_EDUC')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_EDUC'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_DLT_EDUC');
    }
    ?>
    <?php
    if($this->session->userdata('SESS_SUCC_UPDT_EMPL_CERT')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_UPDT_EMPL_CERT'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_UPDT_EMPL_CERT');
    }
    ?>
    <?php
    if($this->session->userdata('SESS_SUCC_UPDT_EMPL_CERT')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_CERT'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_DLT_CERT');
    }
    ?>
    <?php
    if($this->session->userdata('SESS_SUCC_UPDT_EMPL_SKILL')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_UPDT_EMPL_SKILL'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_UPDT_EMPL_SKILL');
    }
    ?>
    <?php
    if($this->session->userdata('SESS_SUCC_MSG_DLT_SKILL')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_SKILL'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_DLT_SKILL');
    }
    ?>
    <script>
        $(document).ready(function(){
            $('#CHCK_CERT_EXPIRES').click(function(){
                $('.show_expire').toggle();
            });
            $('#CHCK_CERT_EXPIRES_UPDT').click(function(){
                $('.show_expire_updt').toggle();
            });

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

            // =================================== EDIT EDUCATION =====================================================
            // Get & Display Data to Edit Modal Using Async JS function
            var education_url = '<?php echo base_url(); ?>profile/getEducationData';
            const openModalButton_educ = document.querySelectorAll('[data-target]');
            openModalButton_educ.forEach(button => {
                button.addEventListener('click', () => {
                    const modal = document.querySelector(button.dataset.target);
                    getEducationData(education_url,button.getAttribute('education_id')).then(data => {
                        if(data.length > 0)
                        {
                            data.forEach((x) => {
                                document.getElementById('UPDT_EDUC_ID').value = x.id;
                                document.getElementById('UPDT_EDUC_EMPL_ID').value = x.col_empl_id;
                                document.getElementById('UPDT_EDUC_SCHOOL').value = x.col_educ_school;
                                document.getElementById('UPDT_EDUC_DEGREE').value = x.col_educ_degree;
                                document.getElementById('UPDT_EDUC_FROM_YEAR').value = x.col_educ_from_yr;
                                document.getElementById('UPDT_EDUC_TO_YEAR').value = x.col_educ_to_yr;
                                document.getElementById('UPDT_EDUC_GRADE').value = x.col_educ_grade;
                            });
                        }
                    });
                });
            });

            async function getEducationData(education_url,education_id) {
                var formData = new FormData();
                formData.append('education_id', education_id);
                const response = await fetch(education_url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }

            // Delete Education
            $('.EDUC_BTN_DLT').click(function(e){
                e.preventDefault();
                var user_deleteKey = $(this).attr('delete_key');
                var employee_id = $(this).attr('employee_id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }
                        ).then((result) => {
                    if (result.isConfirmed) {
                    window.location.href = "<?= base_url(); ?>profile/delete_employee_education?delete_id="+user_deleteKey+"&employee_id="+employee_id;
                    }
                })
            })





            // =================================== EDIT LICENSE AND CERTIFICATIONS =====================================================
            // Get & Display Data to Edit Modal Using Async JS function
            var certification_url = '<?php echo base_url(); ?>profile/getCertificationData';
            const openModalButton_cert = document.querySelectorAll('[data-target]');
            openModalButton_cert.forEach(button => {
                button.addEventListener('click', () => {
                    const modal = document.querySelector(button.dataset.target);
                    getCertificationData(certification_url,button.getAttribute('certification_id')).then(data => {
                        if(data.length > 0)
                        {
                            data.forEach((x) => {
                                document.getElementById('UPDT_CERT_ID').value = x.id;
                                document.getElementById('UPDT_CERT_EMPL_ID').value = x.col_empl_id;
                                document.getElementById('UPDT_CERT_NAME').value = x.col_cert_name;
                                document.getElementById('UPDT_CERT_ISSUER').value = x.col_cert_issuer;
                                document.getElementById('UPDT_CERT_ISSUED_ON').value = x.col_cert_issued_on;
                                document.getElementById('UPDT_CERT_EXPIRE').value = x.col_cert_expires_on;

                                if(x.col_cert_expires_on != "0000-00-00"){
                                    $('#CHCK_CERT_EXPIRES_UPDT').prop('checked', true);
                                    $('.show_expire_updt').toggle();
                                }
                            });
                        }
                    });
                });
            });

            async function getCertificationData(certification_url,certification_id) {
                var formData = new FormData();
                formData.append('certification_id', certification_id);
                const response = await fetch(certification_url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }

            // Delete Education
            $('.CERT_BTN_DLT').click(function(e){
                e.preventDefault();
                var user_deleteKey = $(this).attr('delete_key');
                var employee_id = $(this).attr('employee_id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }
                        ).then((result) => {
                    if (result.isConfirmed) {
                    window.location.href = "<?= base_url(); ?>profile/delete_employee_certification?delete_id="+user_deleteKey+"&employee_id="+employee_id;
                    }
                })
            })








            // =================================== EDIT SKILLS =====================================================
            // Get & Display Data to Edit Modal Using Async JS function
            var skills_url = '<?php echo base_url(); ?>profile/getSkillData';
            const openModalButton_skill = document.querySelectorAll('[data-target]');
            openModalButton_skill.forEach(button => {
                button.addEventListener('click', () => {
                    const modal = document.querySelector(button.dataset.target);
                    getSkillData(skills_url,button.getAttribute('skill_id')).then(data => {
                        if(data.length > 0)
                        {
                            data.forEach((x) => {
                                document.getElementById('UPDT_SKILL_ID').value = x.id;
                                document.getElementById('UPDT_SKILL_EMPL_ID').value = x.col_empl_id;
                                document.getElementById('UPDT_SKILL_NAME').value = x.col_skill_name;
                                document.getElementById('UPDT_SKILL_LEVEL').value = x.col_skill_level;
                            });
                        }
                    });
                });
            });

            async function getSkillData(skills_url,skill_id) {
                var formData = new FormData();
                formData.append('skill_id', skill_id);
                const response = await fetch(skills_url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }

            // Delete Education
            $('.SKILL_BTN_DLT').click(function(e){
                e.preventDefault();
                var user_deleteKey = $(this).attr('delete_key');
                var employee_id = $(this).attr('employee_id');
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
                    window.location.href = "<?= base_url(); ?>profile/delete_employee_skill?delete_id="+user_deleteKey+"&employee_id="+employee_id;
                    }
                })
            })



        })
    </script>
</body>
</html>
