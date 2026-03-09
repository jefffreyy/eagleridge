<style>
    .card-body{
        padding: 10px 15px !important;
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
        color: black;
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
    table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
   
    }
    .page-title{
    font-weight: 600;
    color: #424F5C;
    font-size: 33px;
  }
  th,td{
    font-size: 13px !important;
  }
    .col-xs-15,
    .col-sm-15,
    .col-md-15,
    .col-lg-15 {
        position: relative;
        min-height: 1px;
        padding-right: 10px;
        padding-left: 10px;
        width: 100%;
    }
    @media (min-width: 768px) {
    .col-sm-15 {
            width: 20%;
            float: left;
        }
    }
    @media (min-width: 992px) {
        .col-lg-15 {
            width: 50%;
            float: left;
        }
    }
    @media (min-width: 1300px) {
        .col-lg-15 {
            width: 20%;
            float: left;
        }
    }
    
</style>

<?php
    $date = date('F d, Y');

    if($this->input->get('date')){
        $date = $this->input->get('date');
        $today = date('Y-m-d');
        $prev_date = date('Y-m-d', strtotime("-1 day", strtotime($date)));
        $next_date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
    } else {
        $today = date('Y-m-d');
        $prev_date = date('Y-m-d', strtotime("-1 day"));
        $next_date = date('Y-m-d', strtotime("+1 day"));   
    }
    
?>

<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">

	<div class="content-wrapper">
		<div class="container-fluid p-4">
            <div class="row">
                <div class = "col-md-6">
                    <h1 class="page-title">Daily Attendance</h1>
                </div>
                <div class = "col-md-6" style = "text-align: right;">
                        <a href="#" class="btn btn-primary shadow-none" prev_day="<?= $prev_date ?>" id="btn_filter_prev"><i class="fas fa-angle-left mr-2"></i> Prev</a>
                        <a href="#" class="btn btn-primary shadow-none" today="<?= $today ?>" id="btn_filter_today">Today</a>
                        <a href="#" class="btn btn-primary shadow-none" next_day="<?= $next_date ?>" id="btn_filter_next">Next<i class="fas fa-angle-right ml-2"></i></a>
                </div>
            </div>
            <hr>
            <p style="font-size: 18px;"><?php if($this->input->get('date')){ echo date('F d, Y',strtotime($this->input->get('date')));}else{echo 'Today: '. $date;} ?></p>
            <div class = "row">
                <div class="col-md-3">
                    <br>
                    
                </div>
                <div class="col-md-12">
                    <p class="text-secondary text-bold" style="font-size: 18px;">Filter By:</p>
                    <div class="row">
                        <div class="col-6">
                            <input type="date" class="form-control" value="<?php if($this->input->get('date')){ echo $this->input->get('date');} else {echo date('Y-m-d');} ?>" id="search_date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <select name="filter_by_department" id="filter_by_department" class="form-control mt-2">
                                <option value="">All Departments</option>
                                <?php 
                                    if($DISP_DISTINCT_DEPARTMENT){
                                        ?>
                                        <option value="" <?php foreach($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW_1){ if($DISP_DISTINCT_DEPARTMENT_ROW_1->col_empl_dept == ''){echo 'selected';} } ?>>All Departments</option>
                                        <?php
                                        foreach($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW){
                                            if($DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept != ''){
                                                ?>
                                                    <option value="<?= $DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept ?>"><?= $DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>
                            <select name="filter_by_group" id="filter_by_group" class="form-control mt-2">
                                <option value="">All Groups</option>
                                <?php 
                                    if($DISP_Group){
                                        ?>
                                        <option value="" <?php foreach($DISP_Group as $DISP_Group_ROW_1){ if($DISP_Group_ROW_1->col_empl_group == ''){echo 'selected';} } ?>>All Groups</option>
                                        <?php
                                        foreach($DISP_Group as $DISP_Group_ROW){
                                            if($DISP_Group_ROW->col_empl_group != ''){
                                                ?>
                                                    <option value="<?= $DISP_Group_ROW->col_empl_group ?>"><?= $DISP_Group_ROW->col_empl_group ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name="filter_by_section" id="filter_by_section" class="form-control mt-2">
                                <option value="">All Sections</option>
                                <?php 
                                    if($DISP_DISTINCT_SECTION){
                                        ?>
                                        <option value="" <?php foreach($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW_1){ if($DISP_DISTINCT_SECTION_ROW_1->col_empl_sect == ''){echo 'selected';} } ?>>All Sections</option>
                                        <?php
                                        foreach($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW){
                                            if($DISP_DISTINCT_SECTION_ROW->col_empl_sect != ''){
                                                ?>
                                                    <option value="<?= $DISP_DISTINCT_SECTION_ROW->col_empl_sect ?>"><?= $DISP_DISTINCT_SECTION_ROW->col_empl_sect ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>
                            <select name="filter_by_line" id="filter_by_line" class="form-control mt-2">
                                <option value="">All Lines</option>
                                <?php 
                                    if($DISP_Line){
                                        ?>
                                        <option value="" <?php foreach($DISP_Line as $DISP_Line_ROW_1){ if($DISP_Line_ROW_1->col_empl_line == ''){echo 'selected';} } ?>>All Lines</option>
                                        <?php
                                        foreach($DISP_Line as $DISP_Line_ROW){
                                            if($DISP_Line_ROW->col_empl_line != ''){
                                                ?>
                                                    <option value="<?= $DISP_Line_ROW->col_empl_line ?>"><?= $DISP_Line_ROW->col_empl_line ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>
                            
                            <a href="<?= base_url() ?>attendance/daily_attendance" class="btn btn-secondary ml-3 float-right px-4 mt-2" id="btn_clear_filter">Clear Filter</a>
                            <a href="#" class="btn btn-primary ml-3 float-right px-4 mt-2" id="btn_filter">Filter</a>
                        </div>
                    </div>
                </div>
            </div>



            <div class = "row mt-3">
                <div class = "col-lg-15">
                    <div class = "card p-4" style = "background-color: #00897b; color: white;">
                        <div style = "padding: 10px 1px;">
                            <text style = "font-size: 20px; margin-bottom: -15px;" id="not_yet_in_office_count">
                            </text><br>
                            <text><b>Not yet in Shift</b></text>
                        </div>
                    </div>
                </div>
                <div class = "col-lg-15">
                    <div class = "card p-4" style = "background-color: #5e35b1; color: white;">
                        <div style = "padding: 10px 1px;">
                            <text style = "font-size: 20px; margin-bottom: -15px;" id="already_in_office_count">
                            </text><br>
                            <text><b>In Shift</b></text>
                        </div>
                    </div>
                </div>
                <div class = "col-lg-15">
                    <div class = "card p-4" style = "background-color: #3382b1; color: white;">
                        <div style = "padding: 10px 1px;">
                            <text style = "font-size: 20px; margin-bottom: -15px;" id="out_of_office_count">
                            </text><br>
                            <text><b>Finished Shift</b></text>
                        </div>
                    </div>
                </div>
                <div class = "col-lg-15">
                    <div class = "card p-4" style = "background-color: #635249; color: white;">
                        <div style = "padding: 10px 1px;">
                            <text style = "font-size: 20px; margin-bottom: -15px;" id="rest_day_count">
                            </text><br>
                            <text><b>Rest Day</b></text>
                        </div>
                    </div>
                </div>
                <div class = "col-lg-15">
                    <div class = "card p-4" style = "background-color: #1F566D; color: white;">
                        <div style = "padding: 10px 1px;">
                            <text style = "font-size: 20px; margin-bottom: -15px;" id="approved_leave_count">
                            </text><br>
                            <text><b>Approved Leave</b></text>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-15">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-0 w-100 text-center">
                                Not yet in Shift
                                <i class="fas fa-question-circle float-right mt-1 text-primary" style="cursor: pointer;" data-toggle="tooltip" data-placement="left" title="Display employees that has shift for this day but hasn't timed in yet"></i>
                            </div>
                        </div>
                        
                        <?php 
                            if($DISP_EMPL_NOT_YET_IN_OFFICE){
                                foreach($DISP_EMPL_NOT_YET_IN_OFFICE as $DISP_EMPL_NOT_YET_IN_OFFICE_ROW){ 

                                    // FILTERING FUNCTION
                                    $filtered_employees_arr = [];
                                    if($DISP_DEPARTMENT || $DISP_SECTION || $DISP_GROUP || $DISP_LINES){
                                        if($DISP_DEPARTMENT){
                                            $employee_w_department = $this->p020_emplist_mod->MOD_GET_EMPLOYEES_DATA_BY_DEPT($DISP_DEPARTMENT);
                                            foreach($employee_w_department as $employee_w_department_row){
                                                array_push($filtered_employees_arr, $employee_w_department_row->id);
                                            }
                                        }
    
                                        if($DISP_SECTION){
                                            $employee_w_section = $this->p020_emplist_mod->MOD_GET_EMPLOYEES_DATA_BY_SECT($DISP_SECTION);
                                            foreach($employee_w_section as $employee_w_section_row){
                                                array_push($filtered_employees_arr, $employee_w_section_row->id);
                                            }
                                        }
    
                                        if($DISP_GROUP){
                                            $employee_w_group = $this->p020_emplist_mod->MOD_GET_EMPLOYEES_DATA_BY_GROUP($DISP_GROUP);
                                            foreach($employee_w_group as $employee_w_group_row){
                                                array_push($filtered_employees_arr, $employee_w_group_row->id);
                                            }
                                        }
    
                                        if($DISP_LINES){
                                            $employee_w_line = $this->p020_emplist_mod->MOD_GET_EMPLOYEES_DATA_BY_LINE($DISP_LINES);
                                            foreach($employee_w_line as $employee_w_line_row){
                                                array_push($filtered_employees_arr, $employee_w_line_row->id);
                                            }
                                        }

                                    } else if(!$DISP_DEPARTMENT || !$DISP_SECTION || !$DISP_GROUP || !$DISP_LINES){
                                        $all_employees = $this->p020_emplist_mod->MOD_DISP_ALL_EMPLOYEES();
                                        foreach($all_employees as $all_employees_row){
                                            array_push($filtered_employees_arr, $all_employees_row->id);
                                        }
                                    }
                                    
                                    // CHECK IF EMPLOYEE ID IS ON THE LIST OF FILTERD IDs
                                    if (in_array($DISP_EMPL_NOT_YET_IN_OFFICE_ROW->empl_id, $filtered_employees_arr)){

                                        // FETCHING EMPLOYEE INFO AND ATTENDANCE INFO
                                        $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_EMPL_NOT_YET_IN_OFFICE_ROW->empl_id);
                                        $shift = $this->p171_workshifts_mod->MOD_GET_WRK_SHFT_DATA($DISP_EMPL_NOT_YET_IN_OFFICE_ROW->shift_id);

                                        //  CHECKING IF EMPLOYEE IS ON LEAVE
                                        if($this->input->get('date')){
                                            $leave = $this->p050_attendance_mod->MOD_DISP_EMPL_ON_LEAVE_AJAX($this->input->get('date'),$DISP_EMPL_NOT_YET_IN_OFFICE_ROW->empl_id);
                                        } else {
                                            $leave = $this->p050_attendance_mod->MOD_DISP_EMPL_ON_LEAVE($DISP_EMPL_NOT_YET_IN_OFFICE_ROW->empl_id);
                                        }
                                        if(count($leave) == 0){
                                            
                                            if($employee[0]->col_midl_name){
                                                $midl_ini = $employee[0]->col_midl_name[0].'.';
                                            }else{
                                                $midl_ini = '';
                                            }
                            ?>
                                        <div class="card-body empl_not_in_office" >
                                            <div class="d-flex">
                                                <img class="rounded-circle avatar mt-1" width="35" height="35" src="<?php if($employee[0]->col_imag_path){echo base_url().'user_images/'.$employee[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">
                                                <div class="ml-2">
                                                    <a href = "<?=base_url()?>employees/personal?id=<?= $employee[0]->id ?>"><?= $employee[0]->col_empl_cmid.' - '.$employee[0]->col_last_name.', '.$employee[0]->col_frst_name.' '.$midl_ini?></a>
                                                    <p class="mb-0" style="font-size: 12px;"><?= $employee[0]->col_empl_posi ?></p>
                                                    <p class="mb-0" style="font-size: 12px;"><?php 
                                                        if($DISP_EMPL_NOT_YET_IN_OFFICE_ROW->shift_id){
                                                            ?>
                                                            <i class="fas fa-circle" style="color: <?= $shift[0]->color ?>;"></i> [<?= $shift[0]->code ?>] <?= $shift[0]->time_in ?> - <?= $shift[0]->time_out ?>
                                                            <?php
                                                        }
                                                    ?></p>
                                                </div>
                                            </div>
                                        </div>
                            <?php       
                                        }
                                    }
                                }
                            } 
                        ?>
                    </div>
                </div>
                <div class="col-lg-15">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-0 w-100 text-center">
                                In Shift
                                <i class="fas fa-question-circle float-right mt-1 text-primary" style="cursor: pointer;" data-toggle="tooltip" data-placement="left" title="Display employees that has timed in and currently in the office"></i>
                            </div>
                        </div>
                        
                        <?php 
                            if($DISP_EMPL_ALREADY_IN_OFFICE){
                                foreach($DISP_EMPL_ALREADY_IN_OFFICE as $DISP_EMPL_ALREADY_IN_OFFICE_ROW){

                                    $employee1 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_EMPL_ALREADY_IN_OFFICE_ROW->empl_id);
                                    
                                    if($employee1[0]->col_midl_name){
                                        $midl_ini = $employee1[0]->col_midl_name[0].'.';
                                    }else{
                                        $midl_ini = '';
                                    }
                                    ?>
                                        <div class="card-body empl_in_office">
                                            <div class="d-flex">
                                                <img class="rounded-circle avatar mt-1" width="35" height="35" src="<?php if($employee1[0]->col_imag_path){echo base_url().'user_images/'.$employee1[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">
                                                <div class="ml-2">
                                                    <a href = "<?=base_url()?>employees/personal?id=<?= $employee1[0]->id ?>"><?= $employee1[0]->col_last_name.', '.$employee1[0]->col_frst_name.' '.$midl_ini?></a>
                                                    <p class="mb-0" style="font-size: 12px;"><?= $employee1[0]->col_empl_posi ?></p>
                                                    <p class="mb-0" style="font-size: 12px;"><?php 
                                                        if($DISP_EMPL_ALREADY_IN_OFFICE_ROW->shift_id){
                                                            $shift = $this->p171_workshifts_mod->MOD_GET_WRK_SHFT_DATA($DISP_EMPL_ALREADY_IN_OFFICE_ROW->shift_id);
                                                            ?>
                                                            <i class="fas fa-circle" style="color: <?= $shift[0]->color ?>;"></i> [<?= $shift[0]->code ?>] <?= $shift[0]->time_in ?> - <?= $shift[0]->time_out ?>
                                                            <?php
                                                        }
                                                    ?></p>
                                                </div>
                                                <div class="flex-fill">
                                                    <div class="w-100">
                                                        <div class="float-right text-center" style="height: 100%; width: 60px;">
                                                            <p class="mb-0" style="font-size: 12px;">Time In</p>
                                                            <label for=""><?php 
                                                                $time_hr_min =  explode(':',$DISP_EMPL_ALREADY_IN_OFFICE_ROW->time_in);
                                                                echo $time_hr_min[0].':',$time_hr_min[1];
                                                            ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php      
                                }
                            } 
                        ?>
                    </div>
                </div>
                <div class="col-lg-15">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-0 w-100 text-center">
                                Finished Shift
                                <i class="fas fa-question-circle float-right mt-1 text-primary" style="cursor: pointer;" data-toggle="tooltip" data-placement="left" title="Display employees that has timed out and currently out of office"></i>
                            </div>
                        </div>
                        <?php 
                            if($DISP_EMPL_OUT_OF_OFFICE){
                                foreach($DISP_EMPL_OUT_OF_OFFICE as $DISP_EMPL_OUT_OF_OFFICE_ROW){ 

                                    $employee2 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_EMPL_OUT_OF_OFFICE_ROW->empl_id);
                                    
                                    if($employee2[0]->col_midl_name){
                                        $midl_ini = $employee2[0]->col_midl_name[0].'.';
                                    }else{
                                        $midl_ini = '';
                                    }
                                    ?>
                                        <div class="card-body empl_out_of_office">
                                            <div class="d-flex">
                                                <img class="rounded-circle avatar mt-1" width="35" height="35" src="<?php if($employee2[0]->col_imag_path){echo base_url().'user_images/'.$employee2[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">
                                                <div class="ml-2">
                                                    <a href = "<?=base_url()?>employees/personal?id=<?= $employee2[0]->id ?>"><?= $employee2[0]->col_last_name.', '.$employee2[0]->col_frst_name.' '.$midl_ini?></a>
                                                    <p class="mb-0" style="font-size: 12px;"><?= $employee2[0]->col_empl_posi ?></p>
                                                    <p class="mb-0" style="font-size: 12px;"><?php 
                                                        if($DISP_EMPL_OUT_OF_OFFICE_ROW->shift_id){
                                                            $shift = $this->p171_workshifts_mod->MOD_GET_WRK_SHFT_DATA($DISP_EMPL_OUT_OF_OFFICE_ROW->shift_id);
                                                            ?>
                                                            <i class="fas fa-circle" style="color: <?= $shift[0]->color ?>;"></i> [<?= $shift[0]->code ?>] <?= $shift[0]->time_in ?> - <?= $shift[0]->time_out ?>
                                                            <?php
                                                        }
                                                    ?></p>
                                                </div>
                                                <div class="flex-fill">
                                                    <div class="w-100">
                                                        <div class="float-right text-center" style="height: 100%; width: 60px;">
                                                            <p class="mb-0" style="font-size: 12px;">Time Out</p>
                                                            <label for=""><?php 
                                                                $time_hr_min =  explode(':',$DISP_EMPL_OUT_OF_OFFICE_ROW->time_out);
                                                                echo $time_hr_min[0].':',$time_hr_min[1];
                                                            ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    
                                }
                            } 
                        ?>
                    </div>
                </div>
                <div class="col-lg-15">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-0 w-100 text-center">
                                Rest Day
                                <i class="fas fa-question-circle float-right mt-1 text-primary" style="cursor: pointer;" data-toggle="tooltip" data-placement="left" title="Display employees taking their rest day"></i>
                            </div>
                        </div>
                        <?php 
                            if($DISP_EMPL_ON_REST){
                                foreach($DISP_EMPL_ON_REST as $DISP_EMPL_ON_REST_ROW){ 

                                $employee3 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_EMPL_ON_REST_ROW->empl_id);

                                if($employee3[0]->col_midl_name){
                                    $midl_ini = $employee3[0]->col_midl_name[0].'.';
                                }else{
                                    $midl_ini = '';
                                }
                                    ?>
                                        <div class="card-body empl_on_rest">
                                            <div class="d-flex">
                                                <img class="rounded-circle avatar mt-1" width="35" height="35" src="<?php if($employee3[0]->col_imag_path){echo base_url().'user_images/'.$employee3[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">
                                                <div class="ml-2">
                                                    <a href = "<?=base_url()?>employees/personal?id=<?= $employee3[0]->id ?>"><?= $employee3[0]->col_last_name.', '.$employee3[0]->col_frst_name.' '.$midl_ini?></a>
                                                    <p class="mb-0" style="font-size: 12px;"><?= $employee3[0]->col_empl_posi ?></p>
                                                    <p class="mb-0" style="font-size: 12px;"><?php 
                                                        if($DISP_EMPL_ON_REST_ROW->shift_id){
                                                            $shift = $this->p171_workshifts_mod->MOD_GET_WRK_SHFT_DATA($DISP_EMPL_ON_REST_ROW->shift_id);
                                                            ?>
                                                            <i class="fas fa-circle" style="color: <?= $shift[0]->color ?>;"></i> [<?= $shift[0]->code ?>] <?= $shift[0]->time_in ?> - <?= $shift[0]->time_out ?>
                                                            <?php
                                                        }
                                                    ?></p>
                                                </div>
                                                <div class="flex-fill">
                                                    <div class="w-100">
                                                        <div class="float-right text-center" style="height: 100%; width: 60px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                }
                            } 
                        ?>
                    </div>
                </div>
                <div class="col-lg-15">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-0 w-100 text-center">
                                Approved Leave
                                <i class="fas fa-question-circle float-right mt-1 text-primary" style="cursor: pointer;" data-toggle="tooltip" data-placement="left" title="Display employees that are currently on leave"></i>
                            </div>
                        </div>
                        <?php 
                            if($DISP_ON_LEAVE){
                                foreach($DISP_ON_LEAVE as $DISP_ON_LEAVE_ROW){ 
                                $employee4 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_ON_LEAVE_ROW->empl_id);
                                if($employee4[0]->col_midl_name){
                                    $midl_ini = $employee4[0]->col_midl_name[0].'.';
                                }else{
                                    $midl_ini = '';
                                }
                                    ?>
                                        <div class="card-body empl_on_leave">
                                            <div class="d-flex">
                                                <img class="rounded-circle avatar mt-1" width="35" height="35" src="<?php if($employee4[0]->col_imag_path){echo base_url().'user_images/'.$employee4[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">
                                                <div class="ml-2">
                                                    <a href = "<?=base_url()?>employees/personal?id=<?= $employee4[0]->id ?>"><?= $employee4[0]->col_last_name.', '.$employee4[0]->col_frst_name.' '.$midl_ini?></a>
                                                    <p class="mb-0" style="font-size: 12px;"><?= $employee4[0]->col_empl_posi ?></p>
                                                </div>
                                                <div class="flex-fill">
                                                    <div class="w-100">
                                                        <div class="float-right text-center" style="height: 100%; width: 60px;">

                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                }
                            } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
	</div>

	<aside class="control-sidebar control-sidebar-dark">
	</aside>
	<script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
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
    if ($this->session->userdata('SESS_ERR_MSG_INSRT_CSV')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_CSV'); ?>',
                '',
                'error'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_ERR_MSG_INSRT_CSV');
    }
    ?>
    <?php
    if ($this->session->userdata('SESS_SUCC_MSG_INSRT_CSV')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_CSV'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_CSV');
    }
    ?>

    <script>
        $(document).ready(function(){
            var employees_in_office = $('.empl_in_office').length;
            $('#already_in_office_count').html(employees_in_office);

            var empl_not_in_office = $('.empl_not_in_office').length;
            $('#not_yet_in_office_count').html(empl_not_in_office);

            var empl_out_of_office = $('.empl_out_of_office').length;
            $('#out_of_office_count').html(empl_out_of_office);

            var empl_on_rest = $('.empl_on_rest').length;
            $('#rest_day_count').html(empl_on_rest);

            var empl_on_leave = $('.empl_on_leave').length;
            $('#approved_leave_count').html(empl_on_leave);

            var base_url = '<?= base_url() ?>';

            $('#btn_filter').click(function(){
                var search_date = $('#search_date').val();
                var department = $('#filter_by_department').val();
                var section = $('#filter_by_section').val();
                var group = $('#filter_by_group').val();
                var line = $('#filter_by_line').val();

                window.location.href = base_url+'attendance/daily_attendance?date='+search_date+'&department='+department+'&section='+section+'&group='+group+'&line='+line;
            })

            $('#btn_filter_next').click(function(){
                var next_day = $(this).attr('next_day');
                window.location.href = base_url+'attendance/daily_attendance?date='+next_day;
            })

            $('#btn_filter_prev').click(function(){
                var prev_day = $(this).attr('prev_day');
                window.location.href = base_url+'attendance/daily_attendance?date='+prev_day;
            })

            $('#btn_filter_today').click(function(){
                var today = $(this).attr('today');
                window.location.href = base_url+'attendance/daily_attendance?date='+today;
            })


        })
    </script>
</body>
</html>
