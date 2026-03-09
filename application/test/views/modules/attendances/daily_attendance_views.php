<!------------------------------------------------------ A. PAGE INFORMATION  -----------------------------------------------------

TECHNOS SYSTEM ENGINEERING INC.

EyeBox HRMS

@author     Technos Developers

@datetime   16 November 2022

@purpose    Daily Attendance

CONTROLLER FILES:

MODEL FILES:

----------------------------------------------------------- A. STYLESHEETS  ----------------------------------------------------->

<?php $this->load->view('templates/css_link'); ?>

<?php $this->load->view('templates/dailyattendace_style'); ?>

<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

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

<body>

  <!-- Content Starts -->

	<div class="content-wrapper">

		<div class="container-fluid p-4">

        <nav aria-label="breadcrumb">

			<ol class="breadcrumb">

			<li class="breadcrumb-item">

				<a href="<?php echo base_url() ?>attendances">Attendance

				</a>

			</li>

			<li class="breadcrumb-item active" aria-current="page">Daily Attendance

			</li>

			</ol>

		</nav>

            <div class="row">

                <!-- Title Text -->

                <div class = "col-md-6">

                    <h1 class="page-title">Daily Attendance</h1>

                </div>

                <div class = "col-md-6  button-title">

                        <a href="<?php echo base_url()?>attendances/daily_attendances?date=<?=$prev_date?>" class="btn btn-primary shadow-none" prev_day="<?= $prev_date ?>" id="btn_filter_prev"><i class="fas fa-angle-left mr-2"></i> Prev</a>

                        <a href="<?php echo base_url()?>attendances/daily_attendances?date=<?=$today?>" class="btn btn-primary shadow-none" today="<?= $today ?>" id="btn_filter_today">Today</a>

                        <a href="<?php echo base_url()?>attendances/daily_attendances?date=<?=$next_date?>" class="btn btn-primary shadow-none" next_day="<?= $next_date ?>" id="btn_filter_next">Next<i class="fas fa-angle-right ml-2"></i></a>

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

                                        <option value="" <?php foreach($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW_1){ if($DISP_DISTINCT_DEPARTMENT_ROW_1->name == ''){echo 'selected';} } ?>>All Departments</option>

                                        <?php

                                        foreach($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW){

                                            if($DISP_DISTINCT_DEPARTMENT_ROW->name != ''){

                                                ?>

                                                    <option value="<?= $DISP_DISTINCT_DEPARTMENT_ROW->name ?>"><?= $DISP_DISTINCT_DEPARTMENT_ROW->name ?></option>

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

                                        <option value="" <?php foreach($DISP_Group as $DISP_Group_ROW_1){ if($DISP_Group_ROW_1->name== ''){echo 'selected';} } ?>>All Groups</option>

                                        <?php

                                        foreach($DISP_Group as $DISP_Group_ROW){

                                            if($DISP_Group_ROW->name != ''){

                                                ?>

                                                    <option value="<?= $DISP_Group_ROW->name ?>"><?= $DISP_Group_ROW->name ?></option>

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

                                        <option value="" <?php foreach($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW_1){ if($DISP_DISTINCT_SECTION_ROW_1->name == ''){echo 'selected';} } ?>>All Sections</option>

                                        <?php

                                        foreach($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW){

                                            if($DISP_DISTINCT_SECTION_ROW->name != ''){

                                                ?>

                                                    <option value="<?= $DISP_DISTINCT_SECTION_ROW->name ?>"><?= $DISP_DISTINCT_SECTION_ROW->name ?></option>

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

                                        <option value="" <?php foreach($DISP_Line as $DISP_Line_ROW_1){ if($DISP_Line_ROW_1->name == ''){echo 'selected';} } ?>>All Lines</option>

                                        <?php

                                        foreach($DISP_Line as $DISP_Line_ROW){

                                            if($DISP_Line_ROW->name != ''){

                                                ?>

                                                    <option value="<?= $DISP_Line_ROW->name ?>"><?= $DISP_Line_ROW->name ?></option>

                                                <?php

                                            }

                                        }

                                    }

                                ?>

                            </select>

                            <a href="<?= base_url() ?>attendances/daily_attendances" class="btn btn-secondary ml-3 float-right px-4 mt-2" id="btn_clear_filter">Clear Filter</a>

                            <a href="#" class="btn btn-primary ml-3 float-right px-4 mt-2" id="btn_filter">Filter</a>

                        </div>

                    </div>

                </div>

            </div>

            <div class = "row mt-3">

                <div class = "col-lg-15">

                    <div class = "card p-4 small-box bg-light">

                        <div style= "margin-left: -12px;">

                            <text style = "font-size: 2.2rem; font-weight: 700; " id="not_yet_in_office_count">

                            </text><br>

                            <text>Not yet in Shift</text>

                        </div>

                        <div style= "margin-top"class="icon">

                            <i class="fas fa-user"></i>

                        </div>

                    </div>

                </div>

                <div class = "col-lg-15">

                    <div class = "card p-4 small-box bg-light">

                        <div style= "margin-left: -12px;">

                            <text style = "font-size: 2.2rem; font-weight: 700;" id="already_in_office_count">

                            </text><br>

                            <text>In Shift</text>

                        </div>

                        <div class="icon">

                            <i class="fas fa-user-plus"></i>

                        </div>

                    </div>

                </div>

                <div class = "col-lg-15">

                    <div class = "card p-4 small-box bg-light">

                        <div style= "margin-left: -12px;">

                            <text style = "font-size: 2.2rem; font-weight: 700;" id="out_of_office_count">

                            </text><br>

                            <text>Finished Shift</text>

                        </div>

                        <div class="icon">

                            <i class="fas fa-user-check"></i>

                        </div>

                    </div>

                </div>

                <div class = "col-lg-15">

                    <div class = "card p-4 small-box bg-light">

                        <div style= "margin-left: -12px;">

                            <text style = "font-size: 2.2rem; font-weight: 700;" id="rest_day_count">

                            </text><br>

                            <text>Rest Day</text>

                        </div>

                        <div class="icon">

                            <i class="fas fa-home"></i>

                        </div>

                    </div>

                </div>

                <div class = "col-lg-15">

                    <div class = "card p-4 small-box bg-light">

                        <div style= "margin-left: -12px;">

                            <text style = "font-size: 2.2rem; font-weight: 700;" id="approved_leave_count">

                            </text><br>

                            <text>Approved Leave</text>

                        </div>

                        <div class="icon">

                            <i class="fas fa-thumbs-up"></i>

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

                window.location.href = base_url+'attendances/daily_attendances?date='+search_date+'&department='+department+'&section='+section+'&group='+group+'&line='+line;

            })

            // $('#btn_filter_next').click(function(){

            //     var next_day = $(this).attr('next_day');

            //     window.location.href = base_url+'attendances/daily_attendances?date='+next_day;

            // })

            // $('#btn_filter_prev').click(function(){

            //     var prev_day = $(this).attr('prev_day');

            //     window.location.href = base_url+'attendances/daily_attendances?date='+prev_day;

            // })

            // $('#btn_filter_today').click(function(){

            //     var today = $(this).attr('today');

            //     window.location.href = base_url+'attendances/daily_attendances?date='+today;

            // })

        })

    </script>

</body>

</html>