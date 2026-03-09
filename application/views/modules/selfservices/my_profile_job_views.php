<html>
<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/myinfo_views_style'); ?>
<?php
$user_id = '';
$user_image = '';
$lastname = '';
$middlename = '';
$firstname = '';
$full_name = '';
$progress = 0;
$company_number = '';
$company_email = '';
$hired_on = '';
$employment_type = '';
$position = '';
$section = '';
$department = '';
$division = '';
$reporting_to = '';
$groups = '';
$line = '';
$end_on = '';
$hmo = '';
$hmo_number = '';
$salary_rate = '';
$salary_type = '';
$jobs_data = array();
if ($DISP_EMP_INFO) {
    foreach ($DISP_EMP_INFO as $DISP_EMP_INFO_ROW) {
        $user_id = $DISP_EMP_INFO_ROW->id;
        $user_image = $DISP_EMP_INFO_ROW->col_imag_path;
        $lastname = $DISP_EMP_INFO_ROW->col_last_name;
        $middlename = $DISP_EMP_INFO_ROW->col_midl_name;
        $firstname = $DISP_EMP_INFO_ROW->col_frst_name;
        if ($middlename) {
            $full_name = $lastname . ', ' . $firstname . ' ' . ucfirst($middlename[0]) . '.';
        } else {
            $full_name = $lastname . ', ' . $firstname;
        }
        $company_number = $DISP_EMP_INFO_ROW->col_comp_numb;
        $company_email = $DISP_EMP_INFO_ROW->col_comp_emai;
        $hired_on = $DISP_EMP_INFO_ROW->col_hire_date;
        $progress = ($hired_on != '0000-00-00') && ($hired_on != '') ? ++$progress : $progress;
        $employment_type = $DISP_EMP_INFO_ROW->col_empl_type;
        $progress = ($employment_type != '')  ? ++$progress : $progress;
        $position = $DISP_EMP_INFO_ROW->col_empl_posi;
        $progress = ($position != '')  ? ++$progress : $progress;
        $section = $DISP_EMP_INFO_ROW->col_empl_sect;
        $progress = ($section != '')  ? ++$progress : $progress;
        $department = $DISP_EMP_INFO_ROW->col_empl_dept;
        $progress = ($department != '')  ? ++$progress : $progress;
        $division = $DISP_EMP_INFO_ROW->col_empl_divi;
        $reporting_to = $DISP_EMP_INFO_ROW->col_empl_repo;
        $groups = $DISP_EMP_INFO_ROW->col_empl_group;
        $progress = ($groups != '')  ? ++$progress : $progress;
        $line = $DISP_EMP_INFO_ROW->col_empl_line;
        $progress = ($line != '')  ? ++$progress : $progress;
        $end_on = $DISP_EMP_INFO_ROW->col_endd_date;
        $progress = ($end_on != '0000-00-00') && ($end_on != '')  ? ++$progress : $progress;
        $hmo = $DISP_EMP_INFO_ROW->col_empl_hmoo;
        $progress = ($hmo != '')  ? ++$progress : $progress;
        $hmo_number = $DISP_EMP_INFO_ROW->col_empl_hmon;
        $progress = ($hmo_number != '')  ? ++$progress : $progress;
        $salary_rate = $DISP_EMP_INFO_ROW->salary_rate;
        $progress = ($salary_rate != '')  ? ++$progress : $progress;
        $salary_type = $DISP_EMP_INFO_ROW->salary_type;
        $progress = ($salary_type != '')  ? ++$progress : $progress;
    }
}
$progress = round(($progress / 12) * 100);
?>

<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>selfservices">Self-Service
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">My Personal Profile
                    </li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('templates/partials/profile_header', array(
                        'full_name' => $full_name,
                        'user_image' => $user_image,
                        'is_active' => $DISP_USER_INFO[0]->disabled,
                        'employment_type' => $employment_type,
                        'position' => $position,
                        'department' => $department
                    )); ?>

                </div>
                <div class=" card col-md-12">
                    <div class="row">
                        <div class="mini-nav">
                            <a href="<?= base_url() ?>selfservices/my_profile_personal" class="mini-links">Personal</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_ids" class="mini-links">ID's</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_job" class="mini-links active">Job</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_allowance" class="mini-links">Allowance</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_documents" class="mini-links">Documents</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_emergency" class="mini-links">Emergency</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_dependents" class="mini-links">Dependents</a>
                        </div>
                    </div>
                    <br>
                    <?php $this->load->view('templates/partials/progress', array('progress' => $progress)); ?>
                    <div class="card_container ">
                        <div class="card-title mb-0 ">
                            Job
                            <div class="modal-btn"><a href="#" data-toggle="modal" style="display: none;" data-target="#modal_edit_job"><i class="fas fa-pencil-alt"></i></a></div>
                        </div>
                        <br>
                        <hr>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col col-md-4 text-bold">
                                        Hired On
                                    </div>
                                    <div class="col col-md-8">
                                        <p class="<?php echo ($hired_on == '0000-00-00') ? 'text-danger' : 'text-dark'; ?>  mb-0"> <?php echo $hired_on != '0000-00-00' ? $hired_on : 'No data provided'; ?></p><br>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col col-md-4 text-bold">
                                        End On
                                    </div>

                                    <div class="col col-md-8">
                                        <p class="<?php echo ($end_on == '0000-00-00') ? 'text-danger' : 'text-dark'; ?>  mb-0"><?php echo $end_on != '0000-00-00' ? $end_on : 'No data provided'; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card_container">
                        <div class="card-title">
                            Employment Details
                            <div class="modal-btn"><a href="#" style="display: none;" data-toggle="modal" data-target="#modal_edit_employment_info"><i class="fas fa-pencil-alt"></i></a></div>
                        </div>
                        <br>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col col-md-4 text-bold">
                                        Employment Type
                                    </div>

                                    <div class="col col-md-8">
                                        <span class="<?php echo !$employment_type ? 'text-danger' : 'text-dark' ?>" style="font-weight:normal"><?php echo $employment_type ? $employment_type : 'No data provided'; ?></span>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col col-md-4 text-bold">
                                        Position
                                    </div>

                                    <div class="col col-md-8">
                                        <span class="<?php echo !$position ? 'text-danger' : 'text-dark' ?>" style="font-weight:normal"><?php echo $position ? $position : 'No data provided'; ?></span>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col col-md-4 text-bold">
                                        Groups
                                    </div>
                                    <div class="col col-md-8">
                                        <span class="<?php echo !$groups ? 'text-danger' : 'text-dark' ?>" style="font-weight:normal"><?php echo $groups ? $groups : 'No data provided'; ?></span>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col col-md-4 text-bold">
                                        Department
                                    </div>

                                    <div class="col col-md-8">
                                        <span class="<?php echo !$department ? 'text-danger' : 'text-dark' ?>" style="font-weight:normal">
                                            <?php echo $department ? $department : 'No data provided'; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row ">
                                    <div class="col col-md-4 text-bold">
                                        Line
                                    </div>

                                    <div class="col col-md-8">
                                        <span class="<?php echo !$line ? 'text-danger' : 'text-dark' ?>" style="font-weight:normal"><?php echo $line ? $line : 'No data provided'; ?></span>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col col-md-4 text-bold">
                                        Sections
                                    </div>

                                    <div class="col col-md-8">
                                        <span class="<?php echo !$section ? 'text-danger' : 'text-dark' ?>" style="font-weight:normal">
                                            <?php echo $section ? $section : 'No data provided'; ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col col-md-4 text-bold">
                                        HMO
                                    </div>

                                    <div class="col col-md-8">
                                        <span class="<?php echo !$hmo ? 'text-danger' : 'text-dark' ?>" style="font-weight:normal">
                                            <?php echo $hmo ? $hmo : 'No data provided'; ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col col-md-4 text-bold">
                                        HMO Number
                                    </div>

                                    <div class="col col-md-8">
                                        <span class="<?php echo !$hmo_number ? 'text-danger' : 'text-dark' ?>" style="font-weight:normal">
                                            <?php echo $hmo_number ? $hmo_number : 'No data provided'; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card_container">
                        <div class="card-title">
                            Salary
                            <div class="modal-btn"><a href="#" style="display: none;" data-toggle="modal" data-target="#modal_edit_salary_rate"><i class="fas fa-pencil-alt"></i></a></div>
                        </div>
                        <br>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col col-md-6 text-bold">
                                        Salary Type
                                    </div>

                                    <div class="col col-md-6">
                                        <span class="<?php echo !$salary_type ? 'text-danger' : 'text-dark' ?>" style="font-weight:normal">
                                            <?php echo $salary_type ? $salary_type : 'No data provided'; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col col-md-6 text-bold">
                                        Salary Rate
                                    </div>

                                    <div class="col col-md-6">
                                        <span class="<?php echo !$salary_rate ? 'text-danger' : 'text-dark' ?>" style="font-weight:normal">&#8369; <?php echo $salary_rate ? $salary_rate : 'No data provided'; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                </div>
            </div>

            <div class="modal fade" id="modal_edit_employment_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header pb-0" style="border-bottom: none;">
                            <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Employment Details</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="<?php echo base_url('profile/edit_employment_details'); ?>" id="FORM_EDIT_JOBS" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="required" class="required" for="UPDT_ID_SSS">Employment Type</label>
                                            <select name="emp_type" id="emp_type" class="form-control" required>
                                                <option value="">Choose...</option>
                                                <?php
                                                if ($DISP_EMPTYPES) {
                                                    foreach ($DISP_EMPTYPES as $DISP_EMPTYPES_ROW) {
                                                ?>
                                                        <option value="<?= $DISP_EMPTYPES_ROW->name ?>" <?php if ($DISP_EMPTYPES_ROW->name == $employment_type) {
                                                                                                            echo 'selected';
                                                                                                        } ?>><?= $DISP_EMPTYPES_ROW->name ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="required" for="UPDT_ID_SSS">Position</label>
                                            <select name="position" id="position" class="form-control" required>
                                                <option value="">Choose...</option>
                                                <?php
                                                if ($DISP_POSITION) {
                                                    foreach ($DISP_POSITION as $DISP_POSITION_ROW) {
                                                ?>
                                                        <option value="<?= $DISP_POSITION_ROW->name ?>" <?php if ($DISP_POSITION_ROW->name == $position) {
                                                                                                            echo 'selected';
                                                                                                        } ?>><?= $DISP_POSITION_ROW->name ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="required" for="UPDT_ID_SSS">Department</label>
                                            <select name="department" id="department" class="form-control" required>
                                                <option value="">Choose...</option>
                                                <?php
                                                if ($DISP_DEPARTMENT) {
                                                    foreach ($DISP_DEPARTMENT as $DISP_DEPARTMENT_ROW) {
                                                ?>
                                                        <option value="<?= $DISP_DEPARTMENT_ROW->name ?>" <?php if ($DISP_DEPARTMENT_ROW->name == $department) {
                                                                                                                echo 'selected';
                                                                                                            } ?>><?= $DISP_DEPARTMENT_ROW->name ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="required" for="UPDT_ID_SSS">Group</label>
                                            <select name="groups" id="groups" class="form-control" required>
                                                <option value="">Choose...</option>
                                                <?php
                                                if ($DISP_Group) {
                                                    foreach ($DISP_Group as $DISP_Group_ROW) {
                                                ?>
                                                        <option value="<?= $DISP_Group_ROW->name ?>" <?php if ($DISP_Group_ROW->name == $groups) {
                                                                                                            echo 'selected';
                                                                                                        } ?>><?= $DISP_Group_ROW->name ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="required" for="line">Line</label>
                                            <select name="line" id="line" class="form-control" required>
                                                <option value="">Choose...</option>
                                                <?php
                                                if ($DISP_Line) {
                                                    foreach ($DISP_Line as $DISP_Line_ROW) {
                                                ?>
                                                        <option value="<?= $DISP_Line_ROW->name ?>" <?php if ($DISP_Line_ROW->name == $line) {
                                                                                                        echo 'selected';
                                                                                                    } ?>><?= $DISP_Line_ROW->name ?></option>
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
                                                        if ($DISP_EMP_SECTION) {
                                                            foreach ($DISP_EMP_SECTION as $DISP_EMP_SECTION_ROW) {
                                                        ?>
                                                                <option value="<?= $DISP_EMP_SECTION_ROW->name ?>" <?php if ($DISP_EMP_SECTION_ROW->name == $section) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>><?= $DISP_EMP_SECTION_ROW->name ?></option>
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
                                                    <label class="required" for="UPDT_ID_SSS">HMO</label>
                                                    <input class="form-control form-control " value="<?= $hmo ?>" type="text" name="hmo" id="hmo">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="required" for="UPDT_ID_SSS">HMO Number</label>
                                                    <input class="form-control form-control " value="<?= $hmo_number ?>" type="text" name="hmo_number" id="hmo_number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="EMPL_ID" id="EDUC_EMPL_ID" value="<?= $this->session->userdata('SESS_USER_ID') ?>">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class='btn btn-primary text-light' type="submit" id="btn_edit_employment_details">&nbsp; Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_edit_salary_rate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header pb-0" style="border-bottom: none;">
                            <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Salary Rate</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="<?php echo base_url('profile/edit_employee_salary_rate'); ?>" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="required" class="required" for="salary_type">Salary Type</label>
                                            <select name="salary_type" id="salary_type" class="form-control">
                                                <option value="">Choose...</option>
                                                <option value="Daily" <?php if ($salary_type == 'Daily') {
                                                                            echo 'selected';
                                                                        } ?>>Daily</option>
                                                <option value="Montlhy" <?php if ($salary_type == 'Montlhy') {
                                                                            echo 'selected';
                                                                        } ?>>Montlhy</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="required" class="required" for="salary_rate">Salary Rate</label>
                                            <input type="number" name="salary_rate" value="<?= $salary_rate ?>" id="salary_rate" class="form-control">
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
                                            <input class="form-control" autocomplete="off" type="date" value="<?= $company_email ?>" name="">
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="required">Amount</label>
                                                <input class="form-control" autocomplete="off" type="number" value="<?= $company_email ?>" name="">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="required">Currency</label>
                                                <select name="INSRT_CURRENCY" id="INSRT_CURRENCY" class="form-control" required>
                                                    <option value="">Choose...</option>
                                                    <?php
                                                    if ($DISP_SKILL_LEVEL_INFO) {
                                                        foreach ($DISP_SKILL_LEVEL_INFO as $DISP_SKILL_LEVEL_INFO_ROW) { ?>
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
                                                    if ($DISP_SKILL_LEVEL_INFO) {
                                                        foreach ($DISP_SKILL_LEVEL_INFO as $DISP_SKILL_LEVEL_INFO_ROW) { ?>
                                                            <option value="<?= $DISP_SKILL_LEVEL_INFO_ROW->col_level_name ?>"><?= $DISP_SKILL_LEVEL_INFO_ROW->col_level_name ?></option>
                                                    <?php   }
                                                    } ?>
                                                    <select>
                                            </div>
                                        </div>

                                        <div class="form-group mt-4">
                                            <label class="">Effective From</label>
                                            <select class="form-control" name="">
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
                                            <textarea name="" class="form-control" cols="30" rows="4"></textarea>
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
                                    <img class="avatar" id="employee_img_modal" style="cursor: pointer;" width="300" height="300" src="<?php if ($user_image) {
                                                                                                                                            echo base_url() . 'assets_user/user_profile/' . $user_image;
                                                                                                                                        } else {
                                                                                                                                            echo base_url() . 'assets_system/images/default_user.jpg';
                                                                                                                                        } ?>">
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
        </div>
    </div>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <?php $this->load->view('templates/jquery_link'); ?>
    <?php
    if ($this->session->userdata('SESS_SUCC_UPDT_EMPL_JOB')) {
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
        $('#BTN_EDIT_JOB').click(function(e) {
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
        $(document).ready(function() {
            $("#employee_img_modal").click(function(e) {
                $("#upload_image").click();
            });

            function fasterPreview(uploader) {
                if (uploader.files && uploader.files[0]) {
                    $('#employee_img_modal').attr('src',
                        window.URL.createObjectURL(uploader.files[0]));
                    $('.custom-file-label').text(uploader.files[0].name);
                }
            }
            $("#upload_image").change(function() {
                fasterPreview(this);
            });
            $('#employee_img').click(function() {})
        })
    </script>
</body>

</html>