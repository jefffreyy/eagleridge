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
    font-size: 14px !important;
    }
    th{
        padding-bottom: 10px !important;
        border-top: none !important;
        border-bottom: none !important;
    }

    td{
        padding-top: 10px !important; 
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
    $group='';
    $line='';

    $activation = '';

    $dep_name1 = '';
    $dep_birth1 = '';
    $dep_gend1 = '';
    $dep_rel1 = '';

    $dep_name2 = '';
    $dep_birth2 = '';
    $dep_gend2 = '';
    $dep_rel2 = '';

    $dep_name3 = '';
    $dep_birth3 = '';
    $dep_gend3 = '';
    $dep_rel3 = '';

    $dep_name4 = '';
    $dep_birth4 = '';
    $dep_gend4 = '';
    $dep_rel4 = '';

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
            $group = $DISP_EMP_INFO_ROW->col_empl_group
            ;
            $line = $DISP_EMP_INFO_ROW->col_empl_line
            ;
            $reporting_to = $DISP_EMP_INFO_ROW->col_empl_repo
            ;

            $activation = $DISP_EMP_INFO_ROW->disabled
            ;

            
            $dep_name1 = $DISP_EMP_INFO_ROW->dep_name1;
            $dep_birth1 = $DISP_EMP_INFO_ROW->dep_birth1;
            $dep_gend1 = $DISP_EMP_INFO_ROW->dep_gend1;
            $dep_rel1 = $DISP_EMP_INFO_ROW->dep_rel1;

            $dep_name2 = $DISP_EMP_INFO_ROW->dep_name2;
            $dep_birth2 = $DISP_EMP_INFO_ROW->dep_birth2;
            $dep_gend2 = $DISP_EMP_INFO_ROW->dep_gend2;
            $dep_rel2 = $DISP_EMP_INFO_ROW->dep_rel2;

            $dep_name3 = $DISP_EMP_INFO_ROW->dep_name3;
            $dep_birth3 = $DISP_EMP_INFO_ROW->dep_birth3;
            $dep_gend3 = $DISP_EMP_INFO_ROW->dep_gend3;
            $dep_rel3 = $DISP_EMP_INFO_ROW->dep_rel3;

            $dep_name4 = $DISP_EMP_INFO_ROW->dep_name4;
            $dep_birth4 = $DISP_EMP_INFO_ROW->dep_birth4;
            $dep_gend4 = $DISP_EMP_INFO_ROW->dep_gend4;
            $dep_rel4 = $DISP_EMP_INFO_ROW->dep_rel4;
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
                    <a href = "<?=base_url()?>login/sign_out" class = "top-left"><i class="fas fa-angle-left"></i>  Previous</a>
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
                        <a href = "<?=base_url()?>login/sign_out">Next  <i class="fas fa-angle-right"></i></a>
                    <?php
                    } else {
                    ?>
                        <a href = "#" style="pointer-events: none;cursor: default; color: #ccc">Next  <i class="fas fa-angle-right"></i></a>
                    <?php
                    }
                ?>
                <!-- <a href = "#"><i class="fas fa-ellipsis-v"></i></a> -->
            </div>
        </div>
		<div class="container-fluid p-4">
            <div class = "row">
                <div class = "col-md-3">
                    <div class = "card border-0">
                        <div style = "text-align:center;">
                            <div class = "profile-pic">
                                <img class="rounded-circle avatar" width="200" height="200" src="<?php if($user_image){echo base_url().'user_images/'.$user_image;} else {echo base_url().'user_images/hrcare_sample_img1.jpg';}?>">
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
                            <a href = "<?=base_url()?>employees/personal?id=<?=$user_id?>" class = "mini-links">Personal</a>
                            <a href = "<?=base_url()?>employees/ids?id=<?=$user_id?>" class = "mini-links">ID's</a>
                            <a href = "<?=base_url()?>employees/job?id=<?=$user_id?>" class = "mini-links">Job</a>
                            <!-- <a href = "<?=base_url()?>employees/leave?id=<?=$user_id?>" class = "mini-links">Leave</a> -->
                            <a href = "<?=base_url()?>employees/documents?id=<?=$user_id?>" class = "mini-links">Documents</a>
                            <!-- <a href = "<?=base_url()?>employees/tasks?id=<?=$user_id?>" class = "mini-links">Tasks</a> -->
                            <a href = "<?=base_url()?>employees/assets?id=<?=$user_id?>" class = "mini-links">Assets</a>
                            <a href = "<?=base_url()?>employees/emergency?id=<?=$user_id?>" class = "mini-links">Emergency</a>
                            <a href = "<?=base_url()?>employees/dependents?id=<?=$user_id?>" class = "mini-links active">Dependents</a>
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
                        <div class = "card-title">Dependents
                            <?php 
                                if(($user_info[0]->col_user_access == 2) || ($user_info[0]->col_user_access == 4)){
                                    ?>
                                        <div class = "modal-btn"><a href="#" data-target="#modal_add_dependents" data-toggle="modal"><i class="fas fa-pencil-alt"></i></i></a></div>
                                    <?php
                                }
                            ?>
                            
                        </div>
                        <table class="table table-sm" style="border: none;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Birth Date</th>
                                    <th>Gender</th>
                                    <th>Relationship</th>
                                    
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    if($dep_name1 || $dep_name2 || $dep_name3 || $dep_name4){
                                        if($dep_name1){
                                            ?>
                                                <tr>
                                                    <td><?= $dep_name1 ?></td>
                                                    <td><?= $dep_birth1 ?></td>
                                                    <td><?= $dep_gend1 ?></td>
                                                    <td><?= $dep_rel1 ?></td>
                                                </tr>
                                            <?php
                                        }
                                        if($dep_name2){
                                            ?>
                                                <tr>
                                                    <td><?= $dep_name2 ?></td>
                                                    <td><?= $dep_birth2 ?></td>
                                                    <td><?= $dep_gend2 ?></td>
                                                    <td><?= $dep_rel2 ?></td>
                                                </tr>
                                            <?php
                                        }
                                        if($dep_name3){
                                            ?>
                                                <tr>
                                                    <td><?= $dep_name3 ?></td>
                                                    <td><?= $dep_birth3 ?></td>
                                                    <td><?= $dep_gend3 ?></td>
                                                    <td><?= $dep_rel3 ?></td>
                                                </tr>
                                            <?php
                                        }
                                        if($dep_name4){
                                            ?>
                                                <tr>
                                                    <td><?= $dep_name4 ?></td>
                                                    <td><?= $dep_birth4 ?></td>
                                                    <td><?= $dep_gend4 ?></td>
                                                    <td><?= $dep_rel4 ?></td>
                                                </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                            <td colspan='3'>No Data Yet</td>
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

	<aside class="control-sidebar control-sidebar-dark"></aside>


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
                                    <label >Date</label>
                                    <input class="form-control" autocomplete="off" type="date" value="<?= date('Y-m-d') ?>" name="termination_date" id="termination_date" >
                                </div>
                                <div class="form-group">
                                    <label >Type</label>
                                    <select name="termination_type" id="termination_type" class="form-control">
                                        <option value="Resigned">Resigned</option>
                                        <option value="AWOL">AWOL</option>
                                        <option value="Resigned">Resigned</option>
                                        <option value="End of Contract">End of Contract</option>
                                        <option value="Terminated">Terminated</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label >Reason</label>
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

    <!-- Add Dependents -->
    <div class="modal fade" id="modal_add_dependents" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Dependents</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('employees/update_dependents'); ?>" id="ADD_DEPE_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input class="form-control form-control " type="text" name="EMPL_ID" id="EMPL_ID" value="<?php echo $user_id; ?>" hidden required>

                                <p class="text-bold" style="font-size: 15px;">Dependent 1</p>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label   for="UPDT_ID_SSS">Name</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" name="updt_dep_name1" id="updt_dep_name1" value="<?= $dep_name1 ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label   for="UPDT_ID_SSS">Relationship</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" name="updt_dep_rel1" id="updt_dep_rel1" value="<?= $dep_rel1 ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label   for="UPDT_ID_SSS">Gender</label>
                                            </div>
                                            <div class="col-8">
                                                <select name="updt_dep_gend1" id="updt_dep_gend1" class="form-control" value="<?= $dep_gend1 ?>">
                                                    <option value="">Choose...</option>
                                                    <?php 

                                                        foreach($DISP_EMP_GENDER as $DISP_EMP_GENDER_ROW){
                                                            
                                                            $db_gend1 = strtolower($dep_gend1);
                                                            $ref_gend1 = strtolower($DISP_EMP_GENDER_ROW->name);
                                                        ?>
                                                            <option value="<?= $DISP_EMP_GENDER_ROW->name ?>" <?php if($db_gend1 == $ref_gend1){echo 'selected';} ?>><?= $DISP_EMP_GENDER_ROW->name ?></option>
                                                        <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label   for="UPDT_ID_SSS">Birthday</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="date" name="updt_dep_birth1" id="updt_dep_birth1" value="<?= $dep_birth1 ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <p class="text-bold" style="font-size: 15px;">Dependent 2</p>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label   for="UPDT_ID_SSS">Name</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" name="updt_dep_name2" id="updt_dep_name2" value="<?= $dep_name2 ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label   for="UPDT_ID_SSS">Relationship</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" name="updt_dep_rel2" id="updt_dep_rel2" value="<?= $dep_rel2 ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label   for="UPDT_ID_SSS">Gender</label>
                                            </div>
                                            <div class="col-8">
                                                <select name="updt_dep_gend2" id="updt_dep_gend2" class="form-control" value="<?= $dep_gend2 ?>">
                                                    <option value="">Choose...</option>
                                                    <?php 
                                                        
                                                        foreach($DISP_EMP_GENDER as $DISP_EMP_GENDER_ROW){
                                                            $db_gend2 = strtolower($dep_gend2);
                                                            $ref_gend2 = strtolower($DISP_EMP_GENDER_ROW->name);
                                                        ?>
                                                            <option value="<?= $DISP_EMP_GENDER_ROW->name ?>" <?php if($db_gend2 == $ref_gend2){echo 'selected';} ?>><?= $DISP_EMP_GENDER_ROW->name ?></option>
                                                        <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label   for="UPDT_ID_SSS">Birthday</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="date" name="updt_dep_birth2" id="updt_dep_birth2" value="<?= $dep_birth2 ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <p class="text-bold" style="font-size: 15px;">Dependent 3</p>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label   for="UPDT_ID_SSS">Name</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" name="updt_dep_name3" id="updt_dep_name3" value="<?= $dep_name3 ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label   for="UPDT_ID_SSS">Relationship</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" name="updt_dep_rel3" id="updt_dep_rel3" value="<?= $dep_rel3 ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label   for="UPDT_ID_SSS">Gender</label>
                                            </div>
                                            <div class="col-8">
                                                <select name="updt_dep_gend3" id="updt_dep_gend3" class="form-control" value="<?= $dep_gend3 ?>">
                                                    <option value="">Choose...</option>
                                                    <?php 
                                                        foreach($DISP_EMP_GENDER as $DISP_EMP_GENDER_ROW){
                                                            $db_gend3 = strtolower($dep_gend3);
                                                            $ref_gend3 = strtolower($DISP_EMP_GENDER_ROW->name);
                                                        ?>
                                                            <option value="<?= $DISP_EMP_GENDER_ROW->name ?>" <?php if($db_gend3 == $ref_gend3){echo 'selected';} ?>><?= $DISP_EMP_GENDER_ROW->name ?></option>
                                                        <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label   for="UPDT_ID_SSS">Birthday</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="date" name="updt_dep_birth3" id="updt_dep_birth3" value="<?= $dep_birth3 ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <p class="text-bold" style="font-size: 15px;">Dependent 4</p>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label   for="UPDT_ID_SSS">Name</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" name="updt_dep_name4" id="updt_dep_name4" value="<?= $dep_name4 ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label   for="UPDT_ID_SSS">Relationship</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" name="updt_dep_rel4" id="updt_dep_rel4" value="<?= $dep_rel4 ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label   for="UPDT_ID_SSS">Gender</label>
                                            </div>
                                            <div class="col-8">
                                                <select name="updt_dep_gend4" id="updt_dep_gend4" class="form-control" value="<?= $dep_gend4 ?>">
                                                    <option value="">Choose...</option>
                                                    <?php 
                                                        foreach($DISP_EMP_GENDER as $DISP_EMP_GENDER_ROW){
                                                        ?>
                                                            <option value="<?= $DISP_EMP_GENDER_ROW->name ?>"><?= $DISP_EMP_GENDER_ROW->name ?></option>
                                                        <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label   for="UPDT_ID_SSS">Birthday</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="date" name="updt_dep_birth4" id="updt_dep_birth4" value="<?= $dep_birth4 ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                                
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="DEPE_BTN_INSRT">&nbsp; Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Dependents -->
    <div class="modal fade" id="modal_edit_dependents" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Dependents</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('employees/update_dependents'); ?>" id="EDIT_DEPE_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                
                                <input class="form-control form-control " type="text" name="UPDT_DEPT_ID" id="UPDT_DEPT_ID" hidden>
                                <input class="form-control form-control " type="text" name="UPDT_DEPT_EMPID" id="UPDT_DEPT_EMPID" hidden>

                                <div class="form-group">
                                    <label   for="UPDT_ID_SSS">Name</label>
                                    <input class="form-control form-control " type="text" name="UPDT_DEPT_NAME" id="UPDT_DEPT_NAME" required>
                                </div>

                                <div class="form-group">
                                    <label   for="UPDT_ID_SSS">Birthday</label>
                                    <input class="form-control form-control " type="date" name="UPDT_DEPT_BDAY" id="UPDT_DEPT_BDAY" required>
                                </div>

                                <!-- <div class="form-group">
                                    <label   for="UPDT_ID_SSS">Age</label>
                                    <input class="form-control form-control " type="number" name="UPDT_DEPT_AGE" id="UPDT_DEPT_AGE" required>
                                </div> -->

                                <div class="form-group">
                                    <label   for="UPDT_ID_SSS">Gender</label>
                                    <input class="form-control form-control " type="text" name="UPDT_DEPT_GNDR" id="UPDT_DEPT_GNDR" required>
                                </div>

                                <div class="form-group">
                                    <label   for="UPDT_ID_SSS">Relationship</label>
                                    <input class="form-control form-control " type="text" name="UPDT_DEPT_RELA" id="UPDT_DEPT_RELA" required>
                                </div>

                            </div>
                                
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class='btn btn-primary text-light' type="submit" id="DEPENDENTS_BTN_UPDT">&nbsp; Update</a>
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

    <!-- SESSION SUCCESS MESSAGE INSERT-->
    <?php
        
        if($this->session->userdata('SESS_SUCC_MSG_INSRT_DEPENDENTS'))
        {
    ?>
    
    <script>
        
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_DEPENDENTS'); ?>',
            '',
            'success'
        )
    
    </script>
        
    <?php
        
        $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_DEPENDENTS');
        }
    ?>

    <!-- SESSION SUCCESS MESSAGE DELETE-->
    <?php
        
        if($this->session->userdata('SESS_SUCC_MSG_DLT_DEPENDENTS'))
        {
    ?>
    
    <script>
        
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_DEPENDENTS'); ?>',
            '',
            'success'
        )
    
    </script>
        
    <?php
        
        $this->session->unset_userdata('SESS_SUCC_MSG_DLT_DEPENDENTS');
        }
    ?>

    <!-- SESSION SUCCESS MESSAGE UPDATE-->
    <?php
        
        if($this->session->userdata('SESS_SUCC_MSG_UPDT_DEPENDENTS'))
        {
    ?>
    
    <script>
        
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_DEPENDENTS'); ?>',
            '',
            'success'
        )
    
    </script>
        
    <?php
        
        $this->session->unset_userdata('SESS_SUCC_MSG_UPDT_DEPENDENTS');
        }
    ?>
    
    <script>
    
        $(function() 
        {
            $('div#froala-editor').froalaEditor({
            // Set custom buttons with separator between them.
            toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting','html'],
            toolbarButtonsXS: ['undo', 'redo' , '-', 'bold', 'italic','html']
            })

            $('i.fa.fa-rotate-left').attr('class')
        });
    
    </script>

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

        // Get & Display Data to Edit Modal Using Async JS function
        var url = '<?php echo base_url(); ?>employees/get_dependents_data';
        const openModalButton = document.querySelectorAll('[data-target]');
        
        openModalButton.forEach(button => 
        {
        
            button.addEventListener('click', () => 
            {
        
                const modal = document.querySelector(button.dataset.target);
        
                get_dependents_data(url,button.getAttribute('DATA_ID')).then(data => 
                {
        
                    if(data.length > 0)
        
                    {
        
                        data.forEach((x) => 
                        {
                            document.getElementById('UPDT_DEPT_ID').value = x.id;
                            document.getElementById('UPDT_DEPT_EMPID').value = x.col_depe_empid;
                            document.getElementById('UPDT_DEPT_NAME').value = x.col_depe_name;
                            document.getElementById('UPDT_DEPT_BDAY').value = x.col_depe_bday;
                            //document.getElementById('UPDT_DEPT_AGE').value = x.col_depe_age;
                            document.getElementById('UPDT_DEPT_GNDR').value = x.col_depe_gndr;
                            document.getElementById('UPDT_DEPT_RELA').value = x.col_depe_rela;
                        });
        
                    }
        
                });
        
            });
        });
        
        async function get_dependents_data(url, DATA_ID) 
        {
        
            var formData = new FormData();
        
            formData.append('DATA_ID', DATA_ID);
        
            const response = await fetch(url, 
            {
        
                method: 'POST',
        
                body: formData
        
            });
        
            return response.json();
        }

        // Update DEPENDENTS
        $('#DEPENDENTS_BTN_UPDT').click(function(e)
        {
            var UPDT_DEPT_NAME = $('#UPDT_DEPT_NAME').val();
            var hasErr = 0;
            
            if(!UPDT_DEPT_NAME)
            {
                hasErr++;
            }
        
            if(hasErr == 0)
            {
                Swal.fire({
                    title: 'Do you want to save the following changes?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                    }).then((result) => 
                    {
                        if (result.isConfirmed) 
                        {
                            $('#EDIT_DEPE_FORM').submit();
                        }
                    })
            } 
            
            else 
            {
                $('#UPDT_DEPT_NAME').addClass('is-invalid');
            }
        })
        $('#UPDT_DEPT_NAME').keyup(function(){
        $('#UPDT_DEPT_NAME').removeClass('is-invalid');
        })

    
        // Delete Position
        $('.DEPENDENTS_BTN_DLT').click(function(e){
        e.preventDefault();
        var user_deleteKey = $(this).attr('delete_key');
        var employee_key = $(this).attr('employee_key');
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
        window.location.href = "<?= base_url(); ?>employees/delete_dependents?delete_id="+user_deleteKey+"&employee_id="+employee_key;
        }
        })
        })
    })

    
    </script>

</body>
</html>
