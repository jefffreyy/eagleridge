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
    .media-title{
        font-weight: 600;
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
    $group='';
    $line='';

    $activation = '';

    $school1_name = '';
    $school1_deg = '';
    $school1_from = '';
    $school1_to = '';
    $school1_gwa = '';

    $school2_name = '';
    $school2_deg = '';
    $school2_from = '';
    $school2_to = '';
    $school2_gwa = '';

    $school3_name = '';
    $school3_deg = '';
    $school3_from = '';
    $school3_to = '';
    $school3_gwa = '';

    $skill_name1 = '';
    $skill_lvl1 = '';

    $skill_name2 = '';
    $skill_lvl2 = '';


    if($DISP_EMP_INFO){
        foreach($DISP_EMP_INFO as $DISP_EMP_INFO_ROW){
            // Key id
            $user_id = $DISP_EMP_INFO_ROW->id;

            // Set personal Info
            $user_image = $DISP_EMP_INFO_ROW->col_imag_path
            ;
            $employee_id = $DISP_EMP_INFO_ROW->col_empl_cmid
            ;
            $lastname = $DISP_EMP_INFO_ROW->col_last_name
            ;
            $middlename = $DISP_EMP_INFO_ROW->col_midl_name
            ;
            $firstname = $DISP_EMP_INFO_ROW->col_frst_name
            ;
            $marital_status = $DISP_EMP_INFO_ROW->col_mart_stat
            ;
            $home_address = $DISP_EMP_INFO_ROW->col_home_addr
            ;
            $current_address = $DISP_EMP_INFO_ROW->col_curr_addr
            ;
            $birthdate = $DISP_EMP_INFO_ROW->col_birt_date
            ;
            $nationality = $DISP_EMP_INFO_ROW->col_empl_nati
            ;
            $email = $DISP_EMP_INFO_ROW->col_empl_emai
            ;
            $gender = $DISP_EMP_INFO_ROW->col_empl_gend
            ;
            $shirt_size = $DISP_EMP_INFO_ROW->col_shir_size
            ;
            $mobile_number = $DISP_EMP_INFO_ROW->col_mobl_numb
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
            $group = $DISP_EMP_INFO_ROW->col_empl_group
            ;
            $line = $DISP_EMP_INFO_ROW->col_empl_line
            ;
            $reporting_to = $DISP_EMP_INFO_ROW->col_empl_repo
            ;

            $activation = $DISP_EMP_INFO_ROW->disabled
            ;


            // School data

            $school1_name = $DISP_EMP_INFO_ROW->sch1_name;
            $school1_deg = $DISP_EMP_INFO_ROW->sch1_deg;
            $school1_from = $DISP_EMP_INFO_ROW->sch1_from;
            $school1_to = $DISP_EMP_INFO_ROW->sch1_to;
            $school1_gwa = 'Grade: ' . $DISP_EMP_INFO_ROW->sch1_gwa;

            $school2_name = $DISP_EMP_INFO_ROW->sch2_name;
            $school2_deg = $DISP_EMP_INFO_ROW->sch2_deg;
            $school2_from = $DISP_EMP_INFO_ROW->sch2_from;
            $school2_to = $DISP_EMP_INFO_ROW->sch2_to;
            $school2_gwa = 'Grade: ' . $DISP_EMP_INFO_ROW->sch2_gwa;

            $school3_name = $DISP_EMP_INFO_ROW->sch3_name;
            $school3_deg = $DISP_EMP_INFO_ROW->sch3_deg;
            $school3_from = $DISP_EMP_INFO_ROW->sch3_from;
            $school3_to = $DISP_EMP_INFO_ROW->sch3_to;
            $school3_gwa = 'Grade: ' . $DISP_EMP_INFO_ROW->sch3_gwa;

            $skill_name1 = $DISP_EMP_INFO_ROW->skill_name1;
            $skill_lvl1 = $DISP_EMP_INFO_ROW->skill_lvl1;

            $skill_name2 = $DISP_EMP_INFO_ROW->skill_name2;
            $skill_lvl2 = $DISP_EMP_INFO_ROW->skill_lvl2;
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
            <?php
                $employee_id_next = $this->p020_emplist_mod->Next($user_id);
                $employee_id_prev = $this->p020_emplist_mod->Previous($user_id);
            ?>

            
            <?php
                if($employee_id_prev){
                ?>
                    <a href = "<?=base_url()?>login/sign_out" class = "top-left"><i class="fas fa-angle-left"></i>  Previous</a>
                <?php
                } else {
                ?>
                    <a href = "#" class = "top-left" style="pointer-events: none;cursor: default; color: #ccc"><i class="fas fa-angle-left"></i>  Previous</a>
                <?php
                }
            ?>

            <div class = "top-right">
               
                <?php
                    if($employee_id_next){
                    ?>
                        <a href = "<?=base_url()?>login/sign_out">Next  <i class="fas fa-angle-right"></i></a>
                    <?php
                    } else {
                    ?>
                        <a href = "#" style="pointer-events: none;cursor: default; color: #ccc">Next  <i class="fas fa-angle-right"></i></a>
                    <?php
                    }
                ?>

            </div>
        </div> -->
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
                    
                </div>
                <div class = "col-md-9">
                    <div class = "row">
                        <div class = "mini-nav">
                            <a href = "<?=base_url()?>employees/personal?id=<?=$user_id?>" class = "mini-links active">Personal</a>
                            <a href = "<?=base_url()?>employees/ids?id=<?=$user_id?>" class = "mini-links">ID's</a>
                            <a href = "<?=base_url()?>employees/job?id=<?=$user_id?>" class = "mini-links">Job</a>
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
                        <div class = "card-title mb-0">Personal Details
                            <?php 
                                if(($user_info[0]->col_user_access == 2) || ($user_info[0]->col_user_access == 4)){
                                    ?>
                                        <div class = "modal-btn"><a href="#" data-toggle="modal" data-target="#modal_edit_employee_info"><i class="fas fa-pencil-alt"></i></a></div>
                                    <?php
                                }
                            ?>
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
                            <?php 
                                if(($user_info[0]->col_user_access == 2) || ($user_info[0]->col_user_access == 4)){
                                    ?>
                                        <div class = "modal-btn"><a href="#" data-toggle="modal" data-target="#modal_edit_employee_contact"><i class="fas fa-pencil-alt"></i></a></div>
                                    <?php
                                }
                            ?>
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
                            <?php 
                                if(($user_info[0]->col_user_access == 2) || ($user_info[0]->col_user_access == 4)){
                                    ?>
                                        <div class = "modal-btn"><a href="#" data-toggle="modal" data-target="#modal_add_education"><i class="fas fa-pencil-alt"></i></i></a></div>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <?php 
                                        if($school1_name){
                                            ?>
                                                <p class="text-bold mb-1">Primary</p>
                                                <hr>
                                                <ul class="media-list pl-0">
                                                    <li class="media">
                                                        <div class="media-body">
                                                            <h5 class="media-title"><?= $school1_name ?></h5>
                                                            <h6><?= $school1_deg ?>  - <?= $school1_gwa ?></h6>
                                                                <?= $school1_from ?> - <?= $school1_to ?>
                                                        </div>
                                                    </li>
                                                </ul>
                                            <?php
                                        }
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <?php 
                                        if($school2_name){
                                            ?>
                                                <p class="text-bold mb-1">Secondary</p>
                                                <hr>
                                                <ul class="media-list pl-0">
                                                    <li class="media">
                                                        <div class="media-body">
                                                            <h5 class="media-title"><?= $school2_name ?></h5>
                                                            <h6><?= $school2_deg ?>  - <?= $school2_gwa ?></h6>
                                                                <?= $school2_from ?> - <?= $school2_to ?>
                                                        </div>
                                                    </li>
                                                </ul>
                                            <?php
                                        }
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <?php 
                                        if($school3_name){
                                            ?>
                                                <p class="text-bold mb-1">Tertiary</p>
                                                <hr>
                                                <ul class="media-list pl-0">
                                                    <li class="media">
                                                        <div class="media-body">
                                                            <h5 class="media-title"><?= $school3_name ?></h5>
                                                            <h6><?= $school3_deg ?>  - <?= $school3_gwa ?></h6>
                                                                <?= $school3_from ?> - <?= $school3_to ?>
                                                        </div>
                                                    </li>
                                                </ul>
                                            <?php
                                        } 
                                    ?>
                                </div>
                            </div>
                            <?php
                                if(!$school1_name && !$school2_name && !$school3_name){
                                    ?>
                                        <div class="text-center mt-4 mb-4">
                                            <i class="fas fa-graduation-cap fa-4x text-muted"></i>
                                            <h3 class="text-muted mb-4 mt-2"><?= $firstname ?> has not added any educational background</h3>
                                        </div>
                                    <?php
                                }
                            ?>
                                
                        </div>
                    </div>
                    
                    <div class = "card border-0">
                        <div class = "card-title"><i class="fas fa-book-open"></i>  Skills
                            <?php 
                                if(($user_info[0]->col_user_access == 2) || ($user_info[0]->col_user_access == 4)){
                                    ?>
                                        <div class = "modal-btn"><a href="#" data-toggle="modal" data-target="#modal_add_skills"><i class="fas fa-pencil-alt"></i></i></a></div>
                                    <?php
                                }
                            ?>
                            
                        </div>
                        <div class="card-body">
                            <ul class="list-group" >
                                <?php
                                    if($skill_name1 || $skill_name2){
                                        if($skill_name1){
                                            ?>
                                                <li class="list-group-item w-100" style="border:none !important;">
                                                    <?= $skill_name1 ?>
                                                    <span class="badge badge-primary ml-2"><?= $skill_lvl1 ?></span>
                                                </li>
                                            <?php
                                        }
                                        if($skill_name2){
                                            ?>
                                                <li class="list-group-item w-100" style="border:none !important;">
                                                    <?= $skill_name2 ?>
                                                    <span class="badge badge-primary ml-2"><?= $skill_lvl2 ?></span>
                                                </li>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                            <div class="text-center mt-4 mb-4">
                                                <i class="fas fa-book-open  fa-4x text-muted"></i>
                                                <h3 class="text-muted mb-4 mt-2"><?= $firstname ?> has not added any skills</h3>
                                            </div>
                                        <?php
                                    }
                                ?>

                            </ul>
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
                <form action="<?php echo base_url('employees/edit_employee_education'); ?>" id="ADD_EDUC_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Primary -->
                                <p class="text-bold" style="font-size: 18px;">Primary</p>
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label class="required" for="UPDT_ID_SSS">School</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter the name of school" name="school1_name" id="school1_name" value="<?= $school1_name ?>" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="UPDT_ID_SSS">Degree / Diploma</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter Degree/Diploma (if highschool graduate, enter 'High School Graduate')" name="school1_deg" id="school1_deg" value="<?= $school1_deg ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="UPDT_ID_SSS">Grade</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter grade" name="school1_gwa" id="school1_gwa" value="<?= $school1_gwa ?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="UPDT_ID_SSS">From Year</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter start of school year" name="school1_from" id="school1_from" value="<?= $school1_from ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="UPDT_ID_SSS">To Year (or year expected)</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter end of school year" name="school1_to" id="school1_to" value="<?= $school1_to ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr>

                                <!-- Secondary -->
                                <p class="text-bold" style="font-size: 18px;">Secondary</p>
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label class="required" for="UPDT_ID_SSS">School</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter the name of school" name="school2_name" id="school2_name" value="<?= $school2_name ?>" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="UPDT_ID_SSS">Degree / Diploma</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter Degree/Diploma (if highschool graduate, enter 'High School Graduate')" name="school2_deg" id="school2_deg" value="<?= $school2_deg ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="UPDT_ID_SSS">Grade</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter grade" name="school2_gwa" id="school2_gwa" value="<?= $school2_gwa ?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="UPDT_ID_SSS">From Year</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter start of school year" name="school2_from" id="school2_from" value="<?= $school2_from ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="UPDT_ID_SSS">To Year (or year expected)</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter end of school year" name="school2_to" id="school2_to" value="<?= $school2_to ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                
                                <!-- Tertiary -->
                                <p class="text-bold " style="font-size: 18px;">Tertiary</p>
                                
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label class="required" for="UPDT_ID_SSS">School</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter the name of school" name="school3_name" id="school3_name" value="<?= $school3_name ?>" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="UPDT_ID_SSS">Degree / Diploma</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter Degree/Diploma (if highschool graduate, enter 'High School Graduate')" name="school3_deg" id="school3_deg" value="<?= $school3_deg ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="UPDT_ID_SSS">Grade</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter grade" name="school3_gwa" id="school3_gwa" value="<?= $school3_gwa ?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="UPDT_ID_SSS">From Year</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter start of school year" name="school3_from" id="school3_from" value="<?= $school3_from ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="UPDT_ID_SSS">To Year (or year expected)</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter end of school year" name="school3_to" id="school3_to" value="<?= $school3_to ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                            </div>
                            <input type="hidden" name="EMPL_ID" id="EDUC_EMPL_ID" value="<?= $user_id ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" >&nbsp; Add</button>
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
                <form action="<?php echo base_url('employees/edit_employee_skill'); ?>" id="ADD_SKILLS_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required" for="INSRT_SKILL_NAME1">Skill 1</label>
                                            <input type="text" name="INSRT_SKILL_NAME1" placeholder="Enter Skill" id="INSRT_SKILL_NAME1" class="form-control" value="<?= $skill_name1 ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="INSRT_SKILL_LEVEL1">Level</label>
                                            <input type="text" name="INSRT_SKILL_LEVEL1" placeholder="Enter Skill Lever (Beginner, Intermediate, Proficient)" id="INSRT_SKILL_LEVEL1" class="form-control" value="<?= $skill_lvl1 ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="INSRT_SKILL_NAME2">Skill 2</label>
                                            <input type="text" name="INSRT_SKILL_NAME2" placeholder="Enter Skill" id="INSRT_SKILL_NAME2" class="form-control" value="<?= $skill_name2 ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="INSRT_SKILL_LEVEL2">Level</label>
                                            <input type="text" name="INSRT_SKILL_LEVEL2" placeholder="Enter Skill Lever (Beginner, Intermediate, Proficient)" id="INSRT_SKILL_LEVEL2" class="form-control" value="<?= $skill_lvl2 ?>">
                                        </div>
                                    </div>
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
                            <input type="hidden" name="EMPL_ID" id="SKILL_EMPL_ID" value="<?= $user_id ?>">
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
                <form action="<?php echo base_url('employees/edit_employee_info'); ?>" id="EDIT_EMPLOYEE_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
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
                <form action="<?php echo base_url('employees/edit_employee_contact'); ?>" id="EDIT_EMPLOYEE_CONTACT_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
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
                <form action="<?php echo base_url('employees/edit_employee_education'); ?>" id="EDIT_EDUC_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
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
                <form action="<?php echo base_url('employees/edit_employee_certification'); ?>" id="EDIT_CERT_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
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
                <form action="<?php echo base_url('employees/edit_employee_skill'); ?>" id="EDIT_SKILL_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
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
    if($this->session->userdata('SESS_SUCC_UPDT_IMG')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_UPDT_IMG'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_UPDT_IMG');
    }
    ?>
    <?php
    if($this->session->userdata('SESS_ERR_IMAGE')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_ERR_IMAGE'); ?>',
            '',
            'error'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_ERR_IMAGE');
    }
    ?>
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

            // short input field if checkbox is expired
            $('#CHCK_CERT_EXPIRES').click(function(){
                $('.show_expire').toggle();
            });
            $('#CHCK_CERT_EXPIRES_UPDT').click(function(){
                $('.show_expire_updt').toggle();
            });

            // =================================== EDIT EDUCATION =====================================================
            // Get & Display Data to Edit Modal Using Async JS function
            var education_url = '<?php echo base_url(); ?>employees/getEducationData';
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
                    window.location.href = "<?= base_url(); ?>employees/delete_employee_education?delete_id="+user_deleteKey+"&employee_id="+employee_id;
                    }
                })
            })





            // =================================== EDIT LICENSE AND CERTIFICATIONS =====================================================
            // Get & Display Data to Edit Modal Using Async JS function
            var certification_url = '<?php echo base_url(); ?>employees/getCertificationData';
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
                    window.location.href = "<?= base_url(); ?>employees/delete_employee_certification?delete_id="+user_deleteKey+"&employee_id="+employee_id;
                    }
                })
            })








            // =================================== EDIT SKILLS =====================================================
            // Get & Display Data to Edit Modal Using Async JS function
            var skills_url = '<?php echo base_url(); ?>employees/getSkillData';
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
                    window.location.href = "<?= base_url(); ?>employees/delete_employee_skill?delete_id="+user_deleteKey+"&employee_id="+employee_id;
                    }
                })
            })



        })
    </script>
</body>
</html>
