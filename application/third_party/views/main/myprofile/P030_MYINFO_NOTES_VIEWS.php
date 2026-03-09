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
            $_SESSION['empid'] = $user_id;

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
                            <!-- <a href = "<?=base_url()?>profile/leave" class = "mini-links">Leave</a> -->
                            <a href = "<?=base_url()?>profile/documents" class = "mini-links">Documents</a>
                            <!-- <a href = "<?=base_url()?>profile/tasks" class = "mini-links">Tasks</a> -->
                            <a href = "<?=base_url()?>profile/assets" class = "mini-links">Assets</a>
                            <a href = "<?=base_url()?>profile/emergency" class = "mini-links">Emergency</a>
                            <a href = "<?=base_url()?>profile/dependents" class = "mini-links">Dependents</a>
                            <a href = "<?=base_url()?>profile/notes" class = "mini-links active">Notes</a>
                        </div>
                    </div>
                    <br>
                    <div class = "card border-0">
                        <div class = "card-title">Notes
                            <div class = "modal-btn"><a href="#" style="display: none;" data-target="#modal_add_notes" data-toggle="modal"><i class="fas fa-plus"></i></i></a></div>
                        </div>

                        <hr style = "margin: 1px -20px 10px -20px">
                        
                        <?php
                            
                            $COUNTER = 1;

                            if($DISP_NOTES_INFO)
                            {
                                foreach($DISP_NOTES_INFO as $ROW_NOTES_INFO)
                                {
                                    ?>

                        <div class = "row">
                            
                            <div class = "col-md-10">
                                
                                <span style = "font-weight: normal;"><?= $ROW_NOTES_INFO->col_notes_desc ?></span>
                                <text class = "form-text text-muted" style = "font-weight: normal;">By <?= $ROW_NOTES_INFO->col_notes_created_by ?> on <?php $date = date_create($ROW_NOTES_INFO->col_notes_date_created); echo date_format($date, "M d, Y h:i a"); ?></text>
                            
                            </div>
                            
                            <div class="col-md-2" style = "text-align: right;">
                                
                                <div class="dropdown">
                                    
                                    <a href="#" class="btn btn-light" data-toggle="dropdown" aria-expanded="true">
                            
                                        <i class="fas fa-cog"></i>
                                    
                                    </a>
                                    
                                    <div class="dropdown-menu">
                                        
                                        <a style="display: none;" class="dropdown-item" href="#" DATA_ID="<?= $ROW_NOTES_INFO->id ?>" title="Edit" data-toggle="modal" data-target="#modal_edit_notes">Edit</a>
                                        <a style="display: none;" class="dropdown-item text-danger NOTES_BTN_DLT" href="#" delete_key="<?= $ROW_NOTES_INFO->id ?>">Delete</a>
                      
                                    </div>
                    
                                </div>
                  
                            </div>

                        </div>

                        <hr>

                        <?php
                                    }
                                } 
                                
                                else 
                                { 
                            ?>
                  
                            <div class = "row">
                            
                                <div class = "col-md-10">
                                
                                    <span style = "font-weight: normal;">No Data Yet</span>
                            
                                </div>

                            </div>
                            
                            <?php
                                }
                            ?>
                        
                    </div>
                </div>
            <div>
        </div>
	</div>

	<aside class="control-sidebar control-sidebar-dark"></aside>
	
    <!-- Add Notes -->
    <div class="modal fade" id="modal_add_notes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Notes</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('profile/insert_notes'); ?>" id="ADD_NOTE_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">

                                <?php 

                                    date_default_timezone_set('Asia/Manila');
                                    $DATE_NOW = date("Y/m/d h:i a");

                                    if ($DISP_USER_INFO)
                                    {
                                        foreach ($DISP_USER_INFO as $ROW_USER_INFO)
                                        {
                                            $CURRENT_USER = $ROW_USER_INFO->col_frst_name." ".$ROW_USER_INFO->col_last_name;
                                        }
                                    }
                                ?>
                                
                                <input class="form-control form-control " type="text" name="INSRT_NOTE_CRBY" id="INSRT_NOTE_CRBY" value="<?php echo $CURRENT_USER; ?>" hidden>
                                <input class="form-control form-control " type="text" name="INSRT_NOTE_CRDT" id="INSRT_NOTE_CRDT" value="<?php echo $DATE_NOW; ?>" hidden>
                                <input class="form-control form-control " type="text" name="INSRT_NOTE_EMID" id="INSRT_NOTE_EMID" value="<?php echo $user_id; ?>" hidden>

                                <div class="form-group">
                                    
                                    <label class="required" class="required" for="UPDT_ID_SSS">Notes</label>
                                    <textarea class="form-control form-control " name="INSRT_NOTE_DESC" id="INSRT_NOTE_DESC" required></textarea>
                                
                                </div>

                            </div>
                                
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="NOTE_BTN_INSRT">&nbsp; Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Notes -->
    <div class="modal fade" id="modal_edit_notes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Notes</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('profile/update_notes'); ?>" id="EDIT_NOTE_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                
                                <input class="form-control form-control " type="text" name="UPDT_NOTE_ID" id="UPDT_NOTE_ID" hidden>
                                <input class="form-control form-control " type="text" name="UPDT_NOTE_CRBY" id="UPDT_NOTE_CRBY" hidden>
                                <input class="form-control form-control " type="text" name="UPDT_NOTE_CRDT" id="UPDT_NOTE_CRDT" hidden>
                                <input class="form-control form-control " type="text" name="UPDT_NOTE_EMID" id="UPDT_NOTE_EMID" hidden>

                                <div class="form-group">
                                    
                                    <label class="required" class="required" for="UPDT_ID_SSS">Notes</label>
                                    <textarea class="form-control form-control " name="UPDT_NOTE_DESC" id="UPDT_NOTE_DESC" required></textarea>
                                
                                </div>

                            </div>
                                
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class='btn btn-primary text-light' type="submit" id="NOTE_BTN_UPDT">&nbsp; Update</a>
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

    <!-- SESSION SUCCESS MESSAGE INSERT-->
    <?php
        
        if($this->session->userdata('SESS_SUCC_MSG_INSRT_NOTES'))
        {
    ?>
    
    <script>
        
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_NOTES'); ?>',
            '',
            'success'
        )
    
    </script>
        
    <?php
        
        $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_NOTES');
        }
    ?>

    <!-- SESSION SUCCESS MESSAGE DELETE-->
    <?php
        
        if($this->session->userdata('SESS_SUCC_MSG_DLT_NOTES'))
        {
    ?>
    
    <script>
        
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_NOTES'); ?>',
            '',
            'success'
        )
    
    </script>
        
    <?php
        
        $this->session->unset_userdata('SESS_SUCC_MSG_DLT_NOTES');
        }
    ?>

    <!-- SESSION SUCCESS MESSAGE UPDATE-->
    <?php
        
        if($this->session->userdata('SESS_SUCC_MSG_UPDT_NOTES'))
        {
    ?>
    
    <script>
        
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_NOTES'); ?>',
            '',
            'success'
        )
    
    </script>
        
    <?php
        
        $this->session->unset_userdata('SESS_SUCC_MSG_UPDT_NOTES');
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

        // Get & Display Data to Edit Modal Using Async JS function
        var url = '<?php echo base_url(); ?>employees/get_notes_data';
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
                            document.getElementById('UPDT_NOTE_ID').value = x.id;
                            document.getElementById('UPDT_NOTE_CRBY').value = x.col_notes_created_by;
                            document.getElementById('UPDT_NOTE_CRDT').value = x.col_notes_date_created;
                            document.getElementById('UPDT_NOTE_EMID').value = x.col_empl_id;
                            document.getElementById('UPDT_NOTE_DESC').value = x.col_notes_desc;
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
        $('#NOTE_BTN_UPDT').click(function(e)
        {
            var UPDT_DEPT_DESC = $('#UPDT_NOTE_DESC').val();
            var hasErr = 0;
            
            if(!UPDT_DEPT_DESC)
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
                            $('#EDIT_NOTE_FORM').submit();
                        }
                    })
            } 
            
            else 
            {
                $('#UPDT_NOTE_DESC').addClass('is-invalid');
            }
        })
        $('#UPDT_NOTE_DESC').keyup(function(){
        $('#UPDT_NOTE_DESC').removeClass('is-invalid');
        })
    
        // Delete Position
        $('.NOTES_BTN_DLT').click(function(e){
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
        window.location.href = "<?= base_url(); ?>profile/delete_notes?delete_id="+user_deleteKey;
        }
        })
        })
    })
    
    </script>

</body>
</html>
