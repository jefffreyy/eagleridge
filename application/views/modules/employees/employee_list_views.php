<html>
<?php $this->load->view('templates/css_link'); ?>

<?php


if (isset($_GET['row'])) {
    $row = $_GET['row'];
} else {
    $row = 50;
}

if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}
$prev_page  = $current_page - 1;
$next_page  = $current_page + 1;
$last_page  = intval($C_DATA_COUNT / $row);
$excess     = $C_DATA_COUNT % $row;
if ($excess > 0) {
    $last_page += 1;
}


if ($C_DATA_COUNT == 0) {
    $low_limit = 0;
} else {
    $low_limit = $row * ($current_page - 1) + 1;
}
if ($current_page * $row > $C_DATA_COUNT) {
    $high_limit = $C_DATA_COUNT;
} else {
    $high_limit = $row * ($current_page);
}

$filter = $this->input->get('filter');
?>
<style>
    .hover {
        cursor: pointer;
    }

    .img-circle {
        border-radius: 50% !important;
        width: 30px !important;
        height: 30px !important;
        object-fit: scale-down;
        background-color: #b0b0b0;
    }

    .hide {
        display: none;
    }


    .missing_count {
        display: inline-block;
        margin: 5px 1px 0 1px;
        width: 20px;
        height: 20px;
        background: #f56767;
        color: white;
        border-radius: 50%;
        padding: 1px;
        text-align: center;
        font-size: 12px;
        font-weight: 500;
    }

    .complete_count {
        margin: 5px 1px 0 1px;
        width: 20px;
        height: 20px;
        background: #46cf6a;
        color: white;
        border-radius: 50%;
        padding: 3px;
        text-align: center;
        font-size: 10px;
    }

    /* scaling icons */
    #scaleupIcon img {
        transition: 0.5s ease;
    }

    #scaleupIcon:hover img {
        transform: scale(1.1);
        transition: transform 0.3s ease-in-out;
    }

    .filter-container {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease-out;
    }

    .filter-container form {
        margin: 0;
    }

    .filter-container.visible {
        max-height: 1000px;
        transition: max-height 0.5s ease-in-out;
    }

    @media (max-width: 576px) {
        #search_select .employee_select {
            width: 100% !important;
        }
    }

    @media (min-width: 1280px) {
        .col-2-xl {
            flex-basis: 16.66667%;
            max-width: 16.66667%;
        }

        #search_data {
            min-width: 200px;
        }
    }
</style>

<body>
    <!-- Content Starts -->
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="page-title d-flex align-items-center">
                        <a href="<?= base_url() . 'employees'; ?>">
                            <img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />

                        </a>&nbsp;
                        <span>Employee List</span>
                    </h1>
                </div>
                <!-- Title Button -->
                <div class="col-md-6 col-12 button-title text-nowrap">
                    <!-- <a href="#" class="btn btn-primary shadow-none" id="btn_export"><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a>
                    <a href="<?= base_url() ?>employees/new_employee" class="btn btn-primary shadow-none" id="add_employee"><i class="fas fa-plus"></i> Add Employee</a> -->
                    <!-- <a class="btn btn-primary" id="bulk_import" href="<?= base_url() ?>handsontable/tableplus"><i class="fas fa-fw fa-upload"></i>Bulk Import</a> -->
                    <a class="btn btn-primary my-1" href="<?= base_url() ?>employees/inactive_list">
                        <img class="mb-1" style="height: 1rem; width: 1.2rem;" src="<?= base_url('assets_system/icons/scroll-old-solid-white.svg') ?>" width='18px' />
                        Inactive List
                    </a>
                    <a class="btn btn-primary my-1" href="<?= base_url() ?>employees/new_employee_upload">
                        <img class="mb-1" style="height: 1rem; width: 1.2rem;" src="<?= base_url('assets_system/icons/solid-bolt-circle-plus_xs.svg') ?>">
                        &nbsp;Quick Add
                    </a>
                    <a class="btn btn-primary my-1" href="<?= base_url() ?>employees/employee_update">
                        <img class="mb-1" style="height: 1rem; width: 1.2rem; " src="<?= base_url('assets_system/icons/solid-bolt-pen_xs.svg') ?>">&nbsp;Quick Edit
                    </a>

                </div>
            </div>
            <!-- Title Header Line -->
            <hr>
            <?php
            (isset($_GET['dept']) ? $dept = $_GET['dept'] : $dept = "");
            (isset($_GET['sec']) ? $sec = $_GET['sec'] : $sec = "");
            (isset($_GET['group']) ? $group = $_GET['group'] : $group = "");
            (isset($_GET['line']) ? $line = $_GET['line'] : $line = "");
            (isset($_GET['employementtype']) ? $employment_type = $_GET['employementtype'] : $employment_type = "");
            (isset($_GET['team']) ? $team = $_GET['team'] : $team = "");
            (isset($_GET['division']) ? $division = $_GET['division'] : $division = "");
            (isset($_GET['clubhouse']) ? $clubhouse = $_GET['clubhouse'] : $clubhouse = "");
            (isset($_GET['branch']) ? $branch = $_GET['branch'] : $branch = "");
            (isset($_GET['company']) ? $company = $_GET['company'] : $company = "");
            (isset($_GET['status']) ? $status = $_GET['status'] : $status = "");
            (isset($_GET['all']) ? $all = $_GET['all'] : $all = "");
            ?>

            <?php
            if (isset($_GET['branch'])) {
                $param_branch = $_GET['branch'];
            } else {
                $param_branch = "";
            }
            if (isset($_GET['company'])) {
                $param_company = $_GET['company'];
            } else {
                $param_company = "";
            }
            if (isset($_GET['dept'])) {
                $param_dept = $_GET['dept'];
            } else {
                $param_dept = "";
            }
            if (isset($_GET['division'])) {
                $param_division = $_GET['division'];
            } else {
                $param_division = "";
            }
            if (isset($_GET['section'])) {
                $param_section = $_GET['section'];
            } else {
                $param_section = "";
            }
            if (isset($_GET['group'])) {
                $param_group = $_GET['group'];
            } else {
                $param_group = "";
            }
            if (isset($_GET['team'])) {
                $param_team = $_GET['team'];
            } else {
                $param_team = "";
            }
            if (isset($_GET['line'])) {
                $param_line = $_GET['line'];
            } else {
                $param_line = "";
            }
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
            } else {
                $search = "";
            }
            ?>


            <div class="row mt-4">

                <div class="col-lg-3 col-6 hover" onclick="filter_clear()" id="scaleupIcon">
                    <div class="card p-2 small-box position-relative" id="active_employees">
                        <div style="padding: 10px 10px;" class="text-left">
                            <text style="font-size: 2.2rem; font-weight: 700;" id="total_employees">
                                <?= $DISP_ROW_ACTIVE_COUNT ?>
                            </text><br>
                            <text>Active Employees</text>
                        </div>
                        <div class="icon" style="position: absolute; top: 28px; right: 17px;">
                            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/users-solid2xl.svg') ?>" alt="" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6 hover " onclick="filter_by_employee_type_id(<?= $EMPLOYEE_TYPE_PROB_ID ?>)" id="scaleupIcon">
                    <div class="card p-2 small-box position-relative" id="probationary_employees">
                        <div style="padding: 10px 10px;" class="text-left">
                            <text style="font-size: 2.2rem; font-weight: 700;" id="prob_employees">
                                <?= $DISP_ROW_ACTIVE_PROB_COUNT ?>
                            </text><br>
                            <text>Probationary</text>
                        </div>
                        <div class="icon" style="position: absolute; top: 28px; right: 17px;">
                            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/sparkles-solid.svg') ?>" alt="" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6 hover" onclick="filter_by_employee_type_id(<?= $EMPLOYEE_TYPE_PROJ_ID ?>)" id="scaleupIcon">
                    <div class="card p-2 small-box position-relative" id="project_employees">
                        <div style="padding: 10px 10px;" class="text-left">
                            <text style="font-size: 2.2rem; font-weight: 700;" id="proj_employees">
                                <?= $DISP_ROW_ACTIVE_PROJ_COUNT ?>
                            </text><br>
                            <text>Project-Based</text>
                        </div>
                        <div class="icon" style="position: absolute; top: 28px; right: 17px;">
                            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/timer-solid.svg') ?>" alt="" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6 hover" onclick="filter_by_employee_type_id(<?= $EMPLOYEE_TYPE_REG_ID ?>)" id="scaleupIcon">
                    <div class="card p-2 small-box position-relative" id="regular_employees">
                        <div style="padding: 10px 10px;" class="text-left">
                            <text style="font-size: 2.2rem; font-weight: 700;" id="regular_employees">
                                <?= $DISP_ROW_ACTIVE_REG_COUNT ?>
                            </text><br>
                            <text>Regular</text>
                        </div>
                        <div class="icon" style="position: absolute; top: 28px; right: 17px;">
                            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/user-tie-hair-solid_2xl.svg') ?>" alt="" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6 hover" onclick="filter_by_employee_type_id(<?= $EMPLOYEE_TYPE_INTERN_ID ?>)" id="scaleupIcon">
                    <div class="card p-2 small-box position-relative" id="interns">
                        <div style="padding: 10px 10px;" class="text-left">
                            <text style="font-size: 2.2rem; font-weight: 700;" id="interns">
                                <?= $DISP_ROW_ACTIVE_INTERN_COUNT ?>
                            </text><br>
                            <text>Intern</text>
                        </div>
                        <div class="icon" style="position: absolute; top: 28px; right: 17px;">
                            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/user-tie-hair-solid_2xl.svg') ?>" alt="" />
                        </div>
                    </div>
                </div>
                <!-- <div class="col-4">
                    <div class="card p-2 small-box">
                        <div style="padding: 10px 10px;" class="text-left">
                            <text style="font-size: 2.2rem; font-weight: 700;" id="total_employees">
                                <?= $C_DATA_COUNT ?>
                            </text><br>
                            <text>Filtered Employees</text>
                        </div>
                        <div class="icon" style="position: absolute; top: 14px; right: 17px;">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div> -->
                <!-- <div class="col-4">
                    <div class="card p-2 small-box">
                        <div style="padding: 10px 10px;" class="text-left">
                            <text style="font-size: 2.2rem; font-weight: 700;" id="total_employees">
                                <?= $DISP_ROW_COUNT ?>
                            </text><br>
                            <text>Total Registered Employees</text>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div> -->
            </div>

            <div class=" filter-container <?= $filter ? 'visible' : '' ?>">
                <div class=" d-flex row">
                    <div class="col-md-2 " <?php echo ($DISP_VIEW_COMPANY ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Company</p>
                        <select id="filter_by_company" class="form-control filter_by">
                            <?php
                            if ($C_COMPANIES) {
                            ?>
                                <option value="" <?php foreach ($C_COMPANIES as $Row1) {
                                                        if ($Row1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Company</option>
                                <?php
                                foreach ($C_COMPANIES as $Row) {
                                    if ($Row->name != '') {
                                ?>
                                        <option value="<?= $Row->id ?>" <?= ($Row->id == $company) ? 'Selected' : ''; ?>><?= $Row->name ?></option>
                            <?php
                                    }
                                }
                            } else { ?>
                                    <option value=""></option> 
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2 " <?php echo ($DISP_VIEW_BRANCH ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Branch</p>
                        <select id="filter_by_branch" class="form-control filter_by">
                            <?php
                            if ($C_BRANCH) {
                            ?>
                                <option value="" <?php foreach ($C_BRANCH as $C_BRANCH_ROW_1) {
                                                        if ($C_BRANCH_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Branch</option>
                                <?php
                                foreach ($C_BRANCH as $C_BRANCH_ROW) {
                                    if ($C_BRANCH_ROW->name != '') {
                                ?>
                                        <option value="<?= $C_BRANCH_ROW->id ?>" <?= ($C_BRANCH_ROW->id == $branch) ? 'Selected' : ''; ?>><?= $C_BRANCH_ROW->name ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2 " <?php echo ($DISP_VIEW_DEPARTMENT ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Department</p>
                        <select id="filter_by_department" class="form-control filter_by">
                            <?php
                            if ($C_DEPARTMENTS) {
                            ?>
                                <option value="" <?php foreach ($C_DEPARTMENTS as $DISP_DISTINCT_DEPARTMENT_ROW_1) {
                                                        if ($DISP_DISTINCT_DEPARTMENT_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Departments</option>
                                <?php
                                foreach ($C_DEPARTMENTS as $DISP_DISTINCT_DEPARTMENT_ROW) {
                                    if ($DISP_DISTINCT_DEPARTMENT_ROW->name != '') {
                                ?>
                                        <option value="<?= $DISP_DISTINCT_DEPARTMENT_ROW->id ?>" <?= ($DISP_DISTINCT_DEPARTMENT_ROW->id == $dept) ?  "selected" : ''; ?>><?= $DISP_DISTINCT_DEPARTMENT_ROW->name ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2 " <?php echo ($DISP_VIEW_DIVISION ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Division</p>
                        <select id="filter_by_division" class="form-control filter_by">
                            <?php
                            if ($C_DIVISIONS) {
                            ?>
                                <option value="" <?php foreach ($C_DIVISIONS as $C_DIVISIONS_ROW_1) {
                                                        if ($C_DIVISIONS_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Division</option>
                                <?php
                                foreach ($C_DIVISIONS as $C_DIVISIONS_ROW) {
                                    if ($C_DIVISIONS_ROW->name != '') {
                                ?>
                                        <option value="<?= $C_DIVISIONS_ROW->id ?>" <?= ($C_DIVISIONS_ROW->id == $division) ? 'Selected' : ''; ?>><?= $C_DIVISIONS_ROW->name ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 " <?php echo ($DISP_VIEW_CLUBHOUSE ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Clubhouse</p>
                        <select id="filter_by_clubhouse" class="form-control filter_by">
                            <?php
                            if ($C_CLUBHOUSE) {
                            ?>
                                <option value="" <?php foreach ($C_CLUBHOUSE as $C_CLUBHOUSE_ROW_1) {
                                                        if ($C_CLUBHOUSE_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Clubhouse</option>
                                <?php
                                foreach ($C_CLUBHOUSE as $C_CLUBHOUSE_ROW) {
                                    if ($C_CLUBHOUSE_ROW->name != '') {
                                ?>
                                        <option value="<?= $C_CLUBHOUSE_ROW->id ?>" <?= ($C_CLUBHOUSE_ROW->id == $clubhouse) ? 'Selected' : ''; ?>><?= $C_CLUBHOUSE_ROW->name ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2 " <?php echo ($DISP_VIEW_SECTION ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Section</p>
                        <select id="filter_by_section" class="form-control filter_by">
                            <?php
                            if ($C_SECTIONS) {
                            ?>
                                <option value="" <?php foreach ($C_SECTIONS as $DISP_DISTINCT_SECTION_ROW_1) {
                                                        if ($DISP_DISTINCT_SECTION_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Sections</option>
                                <?php
                                foreach ($C_SECTIONS as $DISP_DISTINCT_SECTION_ROW) {
                                    if ($DISP_DISTINCT_SECTION_ROW->name != '') {
                                ?>
                                        <option value="<?= $DISP_DISTINCT_SECTION_ROW->id ?>" <?= ($DISP_DISTINCT_SECTION_ROW->id == $sec) ?  "selected" : ''; ?>><?= $DISP_DISTINCT_SECTION_ROW->name ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 " <?php echo ($DISP_VIEW_GROUP ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Group</p>
                        <select id="filter_by_group" class="form-control filter_by">
                            <?php
                            if ($C_GROUPS) {
                            ?>
                                <option value="" <?php foreach ($C_GROUPS as $DISP_Group_ROW_1) {
                                                        if ($DISP_Group_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Groups</option>
                                <?php
                                foreach ($C_GROUPS as $DISP_Group_ROW) {
                                    if ($DISP_Group_ROW->name != '') {
                                ?>
                                        <option value="<?= $DISP_Group_ROW->id ?>" <?= ($DISP_Group_ROW->id == $group) ? 'Selected' : ""; ?>><?= $DISP_Group_ROW->name ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 " <?php echo ($DISP_VIEW_TEAM ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Team</p>
                        <select id="filter_by_team" class="form-control filter_by">
                            <?php
                            if ($C_TEAMS) {
                            ?>
                                <option value="" <?php foreach ($C_TEAMS as $C_TEAMS_ROW_1) {
                                                        if ($C_TEAMS_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Team</option>
                                <?php
                                foreach ($C_TEAMS as $C_TEAMS_ROW) {
                                    if ($C_TEAMS_ROW->name != '') {
                                ?>
                                        <option value="<?= $C_TEAMS_ROW->id ?>" <?= ($C_TEAMS_ROW->id == $team) ? 'Selected' : ''; ?>><?= $C_TEAMS_ROW->name ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 " <?php echo ($DISP_VIEW_LINE ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Line</p>
                        <select id="filter_by_line" class="form-control filter_by">
                            <?php
                            if ($C_LINES) {
                            ?>
                                <option value="" <?php foreach ($C_LINES as $DISP_Line_ROW_1) {
                                                        if ($DISP_Line_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Lines</option>
                                <?php
                                foreach ($C_LINES as $DISP_Line_ROW) {
                                    if ($DISP_Line_ROW->name != '') {
                                ?>
                                        <option value="<?= $DISP_Line_ROW->id ?>" <?= ($DISP_Line_ROW->id == $line) ? 'Selected' : ''; ?>><?= $DISP_Line_ROW->name ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 " <?php echo (true ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Employment Types</p>
                        <select id="filter_by_employment_type" class="form-control filter_by">
                            <?php
                            if ($C_EMPLOYMENT_TYPES) {
                            ?>
                                <option value="" <?php foreach ($C_EMPLOYMENT_TYPES as $employmentTyperow_1) {
                                                        if ($employmentTyperow_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Types</option>
                                <?php
                                foreach ($C_EMPLOYMENT_TYPES as $employmentTyperow) {
                                    if ($employmentTyperow->name != '') {
                                ?>
                                        <option value="<?= $employmentTyperow->id ?>" <?= ($employmentTyperow->id == $employment_type) ? 'Selected' : ''; ?>><?= $employmentTyperow->name ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- <div class="col-md-2">
                    <p class="mb-1 text-secondary ">Status</p>
                    <select id="filter_by_status" class="form-control filter_by">
                        <option value="0" <?= ($status == '0') ? 'Selected' : ''; ?> >Active</option>
                        <option value="1" <?= ($status == '1') ? 'Selected' : ''; ?> >Inactive</option>
                    </select>
                    </div> -->
                    <!-- <div class="col-md-2">
                        <br>
                        <a href="#" id="btn_clear_filter" class="btn btn-primary float-right">Clear Filter</a>
                    </div> -->

                    <!-- <div class="col-md-2">
                        <p class="mb-1 text-secondary ">Action</p>
                        <a href="#" id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
                    </div> -->
                </div>

            </div>

            <div class="card border-0 mt-4" style="padding: 0px; margin: 0px">

                <div class="p-2 ">

                    <div>
                        <div class=''>

                            <div class='row'>

                                <div class='col-md-12 col-xl-12'>

                                    <div class="d-flex row align-items-end">

                                        <div class="ml-1 row  col-12 col-xl-5 justify-content-center justify-content-lg-start align-items-center">
                                            <span class="col-10 mb-1 p-0 text-secondary">Search Employee</span>
                                            <select id="search_select" class="px-1 col-12 col-md-3 employee_select form-control " style="width:300px">
                                                <?php
                                                if ($DISP_EMP_LIST_SEARCH) {
                                                ?>
                                                    <option value="all" <?php foreach ($DISP_EMP_LIST_SEARCH as $DISP_EMP_LIST_SEARCH_ROW_1) {
                                                                            if ($DISP_EMP_LIST_SEARCH_ROW_1->name == '') {
                                                                                echo 'selected';
                                                                            }
                                                                        } ?>>All </option>
                                                    <?php
                                                    foreach ($DISP_EMP_LIST_SEARCH as $DISP_EMP_LIST_SEARCH_ROW) {
                                                        if ($DISP_EMP_LIST_SEARCH_ROW->name != '') {
                                                    ?>
                                                            <option value="<?= $DISP_EMP_LIST_SEARCH_ROW->id ?>" <?php echo $search == $DISP_EMP_LIST_SEARCH_ROW->id ? 'selected' : '' ?>>
                                                                <?= $DISP_EMP_LIST_SEARCH_ROW->name ?>
                                                            </option>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>

                                            <button id="btnFilter" class="mt-1 mt-lg-0 btn btn-primary shadow-none rounded ml-1" onclick="toggleFilter()"><img src="<?= base_url('assets_system/icons/advance_filter.svg') ?>" style="margin-bottom: 2px" alt="">&nbsp;Advance Filter</button>
                                            <a href="<?= base_url('employees/directories') ?>" id="btn_clear_filter" class="mt-1 mt-lg-0 btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="">&nbsp;Clear</a>

                                        </div>

                                        <div class="d-none d-lg-flex col-6 col-xl-7 justify-content-lg-end justify-content-center my-lg-0 my-2">
                                            <div class="col-12 col-xl-11 d-flex justify-content-lg-end  justify-content-center align-items-center mx-2">
                                                <div class="d-flex align-items-center row">

                                                    <div class="d-inline col-12 col-xl-6">
                                                        <p class=" p-0 m-0 ml-auto text-center" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                                                    </div>
                                                    <div class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-start">
                                                        <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">
                                                            <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&dept=$dept&sec=$sec&group=$group&line=$line&division=$division&clubhouse=$clubhouse&status=$status&branch=$branch&team=$team&company=$company&employementtype=$employment_type'"; ?>>
                                                                    < </a>
                                                            </li>
                                                            <li><a href="?page=1&row=<?= $row ?>&dept=<?= $dept ?>&sec=<?= $sec ?>&group=<?= $group ?>&line=<?= $line ?>&division=<?= $division ?>&clubhouse=<?= $clubhouse ?>&status=<?= $status ?>&branch=<?=$branch?>&team=<?=$team?>&company=<?=$company?>&employementtype=<?=$employment_type?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                                                            <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                                                            <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&dept=<?= $dept ?>&sec=<?= $sec ?>&group=<?= $group ?>&line=<?= $line ?>&division=<?= $division ?>&clubhouse=<?= $clubhouse ?>&status=<?= $status ?>&branch=<?=$branch?>&team=<?=$team?>&company=<?=$company?>&employementtype=<?=$employment_type?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                                                            <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                                                            <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&dept=<?= $dept ?>&sec=<?= $sec ?>&group=<?= $group ?>&line=<?= $line ?>&division=<?= $division ?>&clubhouse=<?= $clubhouse ?>&status=<?= $status ?>&branch=<?=$branch?>&team=<?=$team?>&company=<?=$company?>&employementtype=<?=$employment_type?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                                                            <li><a <?php if ($current_page >= $last_page - 1 || $last_page == 3)  echo "hidden"; ?>>... </a></li>
                                                            <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&dept=<?= $dept ?>&sec=<?= $sec ?>&group=<?= $group ?>&line=<?= $line ?>&division=<?= $division ?>&clubhouse=<?= $clubhouse ?>&status=<?= $status ?>&branch=<?=$branch?>&team=<?=$team?>&company=<?=$company?>&employementtype=<?=$employment_type?>" <?php if ($current_page == $last_page || $last_page == 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                                                            <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row&dept=$dept&sec=$sec&group=$group&line=$line&division=$division&clubhouse=$clubhouse&status=$status&branch=$branch&team=$team&company=$company&employementtype=$employment_type'"; ?>>> </a></li>
                                                        </ul>
                                                    </div>

                                                </div>



                                            </div>

                                            <div class="col-12 col-xl-1 col-2-xl  d-none d-lg-flex justify-content-center  align-items-center">
                                            <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                                            <select id="row_dropdown" class="custom-select" style="width: auto;">
                                                <?php
                                                foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>
                                                    <option value=<?= $C_ROW_DISPLAY_ROW ?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>
                                                <?php
                                                } ?>
                                            </select>
                                        </div>
                                        </div>

                                      
                                    </div>

                                </div>
                            </div>


                        </div>

                    </div>
                </div>


                <div class="row">
                    <div class="col">
                        <div class="table-responsive" style='max-height:75vh;'>
                            <table class="table table-hover table-bordered mb-0" id="TableToExport">
                                <thead style='position:sticky;top:-1px'>
                                    <tr>
                                        <?php

                                        $SUM_COL = (int)$DISP_VIEW_COMPANY + (int)$DISP_VIEW_BRANCH + (int)$DISP_VIEW_DEPARTMENT + (int)$DISP_VIEW_DIVISION + (int)$DISP_VIEW_CLUBHOUSE + (int)$DISP_VIEW_SECTION + (int)$DISP_VIEW_GROUP + (int)$DISP_VIEW_TEAM + (int)$DISP_VIEW_LINE + 6;
                                        $COL = (int)(100 / $SUM_COL);
                                        $EXCESS = 100 - ($SUM_COL * $COL);

                                        ?>
                                        <th style="width: <?= $COL ?>%">EMPLOYEE&nbsp;ID</th>
                                        <th style="width: <?= $COL + $EXCESS ?>%">FULL&nbsp;NAME</th>
                                        <th style="width: <?= $COL ?>%">REQUIREMENTS</th>
                                        <th style="width: <?= $COL ?>%">TYPE</th>
                                        <th style="width: <?= $COL ?>%">POSITION</th>
                                        <th class="width: <?= $COL ?>%" <?php echo ($DISP_VIEW_COMPANY ? "" : "hidden") ?>> COMPANY</th>
                                        <th class="width: <?= $COL ?>%" <?php echo ($DISP_VIEW_BRANCH ? "" : "hidden") ?>> BRANCH</th>
                                        <th class="width: <?= $COL ?>%" <?php echo ($DISP_VIEW_DEPARTMENT ? "" : "hidden") ?>> DEPARTMENT</th>
                                        <th class="width: <?= $COL ?>%" <?php echo ($DISP_VIEW_DIVISION ? "" : "hidden") ?>> DIVISION</th>
                                        <th class="width: <?= $COL ?>%" <?php echo ($DISP_VIEW_CLUBHOUSE ? "" : "hidden") ?>> CLUBHOUSE</th>
                                        <th class="width: <?= $COL ?>%" <?php echo ($DISP_VIEW_SECTION ? "" : "hidden") ?>> SECTION</th>
                                        <th class="width: <?= $COL ?>%" <?php echo ($DISP_VIEW_GROUP ? "" : "hidden") ?>> GROUP</th>
                                        <th class="width: <?= $COL ?>%" <?php echo ($DISP_VIEW_TEAM ? "" : "hidden") ?>> TEAM</th>
                                        <th class="width: <?= $COL ?>%" <?php echo ($DISP_VIEW_LINE ? "" : "hidden") ?>> LINE</th>
                                    </tr>
                                </thead>
                                <tbody id="table_container">
                                    <?php
                                    if ($DISP_EMP_LIST) {
                                        foreach ($DISP_EMP_LIST as $DISP_EMP_LIST_ROW) {
                                            if (!empty($DISP_EMP_LIST_ROW->col_midl_name)) {
                                                $midl_ini = $DISP_EMP_LIST_ROW->col_midl_name[0] . '.';
                                            } else {
                                                $midl_ini = '';
                                            }
                                            if (!empty($DISP_EMP_LIST_ROW->col_suffix)) {
                                                $DISP_EMP_LIST_ROW->col_last_name = $DISP_EMP_LIST_ROW->col_last_name . ' ' . $DISP_EMP_LIST_ROW->col_suffix;
                                            }
                                    ?>
                                            <tr>
                                                <!-- <td class="text-center" id="select_item">
                                                    <input type="checkbox" name="approval_name" class="check_single"  employee_id="<?= $DISP_EMP_LIST_ROW->id ?>" row_id="<?= $DISP_EMP_LIST_ROW->col_empl_cmid ?>" value="<?= $DISP_EMP_LIST_ROW->id ?>" >
                                                </td> -->

                                                <!-- <td>Company: <?= $DISP_EMP_LIST_ROW->col_empl_company ?></td> -->
                                                <td><?= $DISP_EMP_LIST_ROW->col_empl_cmid ?></td>
                                                <td class="empl_img">

                                                    <a href="<?= base_url() ?>employees/personal?id=<?= $DISP_EMP_LIST_ROW->id ?>">
                                                        <img width="30px" height='30px' class=" rounded-circle avatar elevation-2" style="object-fit:scale-down" src="
                                                        <?= $this->system_functions->profileImageCheck('assets_user/user_profile/', $DISP_EMP_LIST_ROW->col_imag_path)
                                                        // if ($DISP_EMP_LIST_ROW->col_imag_path) {
                                                        //     echo base_url() . 'assets_user/user_profile/' . $DISP_EMP_LIST_ROW->col_imag_path;
                                                        // } else {
                                                        //     echo base_url() . 'assets_system/images/default_user.jpg';
                                                        // } 
                                                        ?>">&nbsp;&nbsp;<?= $DISP_EMP_LIST_ROW->col_last_name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name . ' ' . $midl_ini ?>
                                                    </a>



                                                </td>
                                                <td>
                                                <?php if($this->employees_model->getRequirementsCountNotDone($DISP_EMP_LIST_ROW->id)): ?>
                                                    <span class="missing_count">
                                                        <?= $this->employees_model->getRequirementsCountNotDone($DISP_EMP_LIST_ROW->id) ? $this->employees_model->getRequirementsCountNotDone($DISP_EMP_LIST_ROW->id) : ''; ?>
                                                    </span>
                                                <?php endif; ?>
                                                <!-- <span class="missing_count">
                                                    <?= $this->employees_model->getRequirementsCountNotDone($DISP_EMP_LIST_ROW->id) ? $this->employees_model->getRequirementsCountNotDone($DISP_EMP_LIST_ROW->id) : ''; ?>

                                                            <?= (get_document_count($C_ALL_DOCUMENTS, $DISP_EMP_LIST_ROW->id) +  get_emergency_count($C_ALL_EMERGENCY, $DISP_EMP_LIST_ROW->id) + get_dependents_count($C_ALL_DEPENDENTS, $DISP_EMP_LIST_ROW->id) + get_count($DISP_EMP_LIST, $DISP_EMP_LIST_ROW->id)); ?>
                                                </span> -->
                                                    <!-- <?php if (
                                                        get_document_count($C_ALL_DOCUMENTS, $DISP_EMP_LIST_ROW->id)
                                                        // + get_emergency_count($C_ALL_EMERGENCY, $DISP_EMP_LIST_ROW->id)
                                                        // + get_dependents_count($C_ALL_DEPENDENTS, $DISP_EMP_LIST_ROW->id)
                                                        // + get_count($DISP_EMP_LIST, $DISP_EMP_LIST_ROW->id) > 0
                                                    ) {
                                                    ?>
                                                        <span class="missing_count">
                                                            <?= (get_document_count($C_ALL_DOCUMENTS, $DISP_EMP_LIST_ROW->id) +  get_emergency_count($C_ALL_EMERGENCY, $DISP_EMP_LIST_ROW->id) + get_dependents_count($C_ALL_DEPENDENTS, $DISP_EMP_LIST_ROW->id) + get_count($DISP_EMP_LIST, $DISP_EMP_LIST_ROW->id)); ?></span>
                                                    <?php } else { ?>
                                                        <span><i class="fa-solid fa-circle-check fa-xl" style="color: #00e004;"></i></span>
                                                    <?php } ?> -->
                                                </td>
                                                <td><?= convert_id2name($C_TYPE, $DISP_EMP_LIST_ROW->col_empl_type)  ?></td>
                                                <td><?= convert_id2name($C_POSITIONS, $DISP_EMP_LIST_ROW->col_empl_posi) ?></td>
                                                <td <?php echo ($DISP_VIEW_COMPANY ? "" : "hidden") ?>><?= convert_id2name($C_COMPANIES, $DISP_EMP_LIST_ROW->col_empl_company) ?></td>
                                                <td <?php echo ($DISP_VIEW_BRANCH ? "" : "hidden") ?>><?= convert_id2name($C_BRANCH, $DISP_EMP_LIST_ROW->col_empl_branch) ?></td>
                                                <td <?php echo ($DISP_VIEW_DEPARTMENT ? "" : "hidden") ?>><?= convert_id2name($C_DEPARTMENTS, $DISP_EMP_LIST_ROW->col_empl_dept) ?></td>
                                                <td <?php echo ($DISP_VIEW_DIVISION ? "" : "hidden") ?>><?= convert_id2name($C_DIVISIONS, $DISP_EMP_LIST_ROW->col_empl_divi) ?></td>
                                                <td <?php echo ($DISP_VIEW_CLUBHOUSE ? "" : "hidden") ?>><?= convert_id2name($C_CLUBHOUSE, $DISP_EMP_LIST_ROW->col_empl_club) ?></td>
                                                <td <?php echo ($DISP_VIEW_SECTION ? "" : "hidden") ?>><?= convert_id2name($C_SECTIONS, $DISP_EMP_LIST_ROW->col_empl_sect) ?></td>
                                                <td <?php echo ($DISP_VIEW_GROUP ? "" : "hidden") ?>><?= convert_id2name($C_GROUPS, $DISP_EMP_LIST_ROW->col_empl_group) ?></td>
                                                <td <?php echo ($DISP_VIEW_TEAM ? "" : "hidden") ?>><?= convert_id2name($C_TEAMS, $DISP_EMP_LIST_ROW->col_empl_team) ?></td>
                                                <td <?php echo ($DISP_VIEW_LINE ? "" : "hidden") ?>><?= convert_id2name($C_LINES, $DISP_EMP_LIST_ROW->col_empl_line) ?></td>
                                            </tr>
                                        <?php
                                        }
                                    } else { ?>
                                        <!-- Message if no entries -->
                                        <tr class="table-active">
                                            <td colspan="12">
                                                <center>No Records</center>
                                            </td>
                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                            <!-- <div class="w-100 text-center">
                                <img src="<?= base_url() ?>images/loader2.gif" id="loader_gif" style="width: 180px; height: 120px; display: none;">
                            </div> -->
                        </div>
                        <div class=" d-flex d-lg-none col-sm-7 col-md-10 col-lg-6 justify-content-lg-end justify-content-center my-lg-0 my-2">
                            <div class="col-12 col-lg-7 d-flex justify-content-center justify-content-lg-end align-items-center mx-2">
                                <div class="d-flex align-items-center row">

                                    <div class="d-inline col-12 col-lg-6">

                                        <p class=" p-0 m-0 mx-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                                    </div>
                                    <div class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-end">
                                        <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">
                                            <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&dept=$dept&sec=$sec&group=$group&line=$line&division=$division&clubhouse=$clubhouse&status=$status'"; ?>>
                                                    < </a>
                                            </li>
                                            <li><a href="?page=1&row=<?= $row ?>&dept=<?= $dept ?>&sec=<?= $sec ?>&group=<?= $group ?>&line=<?= $line ?>&division=<?= $division ?>&clubhouse=<?= $clubhouse ?>&status=<?= $status ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                                            <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                                            <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&dept=<?= $dept ?>&sec=<?= $sec ?>&group=<?= $group ?>&line=<?= $line ?>&division=<?= $division ?>&clubhouse=<?= $clubhouse ?>&status=<?= $status ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                                            <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                                            <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&dept=<?= $dept ?>&sec=<?= $sec ?>&group=<?= $group ?>&line=<?= $line ?>&division=<?= $division ?>&clubhouse=<?= $clubhouse ?>&status=<?= $status ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                                            <li><a <?php if ($current_page >= $last_page - 1 || $last_page == 3)  echo "hidden"; ?>>... </a></li>
                                            <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&dept=<?= $dept ?>&sec=<?= $sec ?>&group=<?= $group ?>&line=<?= $line ?>&division=<?= $division ?>&clubhouse=<?= $clubhouse ?>&status=<?= $status ?>" <?php if ($current_page == $last_page || $last_page == 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                                            <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row&dept=$dept&sec=$sec&group=$group&line=$line&division=$division&clubhouse=$clubhouse&status=$status'"; ?>>> </a></li>
                                        </ul>
                                    </div>

                                </div>



                            </div>


                        </div>

                        <div class="col-12 col-lg-1 d-lg-none d-flex justify-content-center align-items-center">
                            <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                            <select id="row_dropdown" class="custom-select" style="width: auto;">
                                <?php
                                foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>
                                    <option value=<?= $C_ROW_DISPLAY_ROW ?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>
                                <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pagination -->

    </div>
    </div>
    <!-- control-sidebar -->
    <aside class="control-sidebar control-sidebar-dark"></aside>
    <!-- /.control-sidebar -->


    <div class="modal fade class_modal_approve" id="modal_bulk_activate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Bulk Activate
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;
                        </span>
                    </button>
                </div>
                <form action="<?php echo base_url(); ?>employees/employee_bulk_activate" id="form_bulk_activate" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul id="approve_list_id" class="row" style="background: #e7f4e4;"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="EMPLOYEE_ID" id="EMPLOYEE_ID">
                        <input type="hidden" name="ACTIVATE" id="ACTIVATE" value="0">
                        <a type="submit" id="submit_bulk_approve" class='btn btn-primary text-light'>&nbsp; Save</a>
                        <div class="spinner-border text-primary loading_indicator_appr2_appr3" style="display: none;"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade class_modal_reject" id="modal_bulk_deactivate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Bulk Deactivate
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;
                        </span>
                    </button>
                </div>
                <form action="<?php echo base_url(); ?>employees/employee_bulk_deactivate" id="form_bulk_deactivate" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul id="reject_list_id" class="row" style="background: #e7f4e4;"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="EMPLOYEE_DEACTIVATE_ID" id="EMPLOYEE_DEACTIVATE_ID">
                        <input type="hidden" name="ACTIVATE" id="ACTIVATE" value="1">
                        <a type="submit" id="submit_bulk_reject" class='btn btn-primary text-light'>&nbsp; Save</a>
                        <div class="spinner-border text-primary loading_indicator_appr2_appr3" style="display: none;"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <!-- Resign/Terminate Employee Modal -->
    <div class="modal fade" id="modal_show_termination_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Termination Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <p class="mb-0" id="termination_date"></p>
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <p class="mb-0" id="termination_type"></p>
                            </div>
                            <div class="form-group">
                                <label>Reason</label>
                                <p class="mb-0" id="termination_reason"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class='btn btn-primary text-light' data-dismiss="modal" aria-label="Close">&nbsp; Remove</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    $page_count = $DISP_ROW_COUNT / 10;
    if (($DISP_ROW_COUNT % 10) != 0) {
        $page_count = $page_count++;
    }
    $page_count = ceil($page_count);
    ?>
    <input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT ?>">
    <input type="hidden" id="page_count" value="<?= $page_count ?>">
    <input type="hidden" id="current_page" value="">
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->
    <?php $this->load->view('templates/jquery_link'); ?>

    <?php
    if ($this->session->userdata('SESS_ERR_IMAGE')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_ERR_IMAGE'); ?>',
                '',
                'warning'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_ERR_IMAGE');
    }
    ?>
    <!-- SESSION MESSAGES -->
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
    <?php
    if ($this->session->userdata('SESS_WARN_MSG_INSRT_CSV')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_WARN_MSG_INSRT_CSV'); ?>',
                '',
                'warning'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_WARN_MSG_INSRT_CSV');
    }
    ?>
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
    if ($this->session->userdata('SESS_SUCC_INSRT')) {
    ?>
        <script>
            $(document).Toasts('create', {
                class: 'bg-success toast_width',
                title: 'Success',
                subtitle: 'close',
                body: '<?php echo $this->session->userdata('SESS_SUCC_INSRT'); ?>'
            })
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_INSRT');
    }
    ?>

    <?php
    if ($this->session->userdata('SESS_ERROR_INSRT')) {
    ?>
        <script>
            $(document).Toasts('create', {
                class: 'bg-danger toast_width',
                title: 'Unable to Register!',
                subtitle: 'close',
                body: '<?php echo $this->session->userdata('SESS_ERROR_INSRT'); ?>'
            })
        </script>
    <?php
        $this->session->unset_userdata('SESS_ERROR_INSRT');
    }
    ?>


    <?php function convert_id2name($array, $pos)
    {
        $name = "";
        foreach ($array as $e) {
            if ($e->id == $pos) {
                $name = $e->name;
            }
        }
        if ($name == "") {
            $name = "";
        }
        return $name;
    }

    function get_document_count($array, $id)
    {
        $count = 0;

        foreach ($array as $x) {
            if ($x->col_empl_id == $id) {
                ($x->col_empl_id) ? $count++ : '';
            }
        }

        if ($count == 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_emergency_count($array, $id)
    {
        $count = 0;

        foreach ($array as $x) {
            if ($x->empid == $id) {
                ($x->empid) ? $count++ : '';
            }
        }

        if ($count == 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_dependents_count($array, $id)
    {
        $count = 0;

        foreach ($array as $x) {
            if ($x->col_depe_empid == $id) {
                ($x->col_depe_empid) ? $count++ : '';
            }
        }

        if ($count == 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_count($array, $id)
    {
        $count = 0;
        foreach ($array as $x) {
            if ($x->id == $id) {
                (!$x->col_empl_cmid) ? $count++ : '';
                (!$x->col_frst_name) ? $count++ : '';
                (!$x->col_last_name) ? $count++ : '';
                (!$x->col_mart_stat) ? $count++ : '';
                (!$x->col_birt_date) ? $count++ : '';
                (!$x->col_empl_gend) ? $count++ : '';
                (!$x->col_empl_nati) ? $count++ : '';
                (!$x->col_shir_size) ? $count++ : '';
                (!$x->col_mobl_numb) ? $count++ : '';
                (!$x->col_home_addr) ? $count++ : '';
                (!$x->col_curr_addr) ? $count++ : '';
                (!$x->col_hire_date) ? $count++ : '';
                (!$x->col_empl_type) ? $count++ : '';
                (!$x->col_empl_posi) ? $count++ : '';
                (!$x->col_empl_sssc) ? $count++ : '';
                (!$x->col_empl_phil) ? $count++ : '';
                (!$x->col_empl_btin) ? $count++ : '';
                (!$x->col_empl_hdmf) ? $count++ : '';
                // (!$x->salary_type) ? $count++ : '';
                (!$x->bank_name) ? $count++ : '';
                (!$x->account_type) ? $count++ : '';
                (!$x->account_number) ? $count++ : '';
                // (!$x->salary_rate) ? $count++ : '';
                (!$x->branch_name) ? $count++ : '';
                (!$x->payment_type) ? $count++ : '';
            }
        }
        return $count;
    }
    ?>
    <script>
        const paramsString = window.location.search;
        if (paramsString) {
            const urlParams = new URLSearchParams(paramsString);
            const {
                page,
                dept,
                sec,
                group,
                line,
                division,
                clubhouse,
                branch,
                team,
                company,
                employementtype
            } = Object.fromEntries(urlParams.entries());

            if (
                !((dept !== null && dept !== '') ||
                    (sec !== null && sec !== '') ||
                    (group !== null && group !== '') ||
                    (line !== null && line !== '') ||
                    (division !== null && division !== '') ||
                    (clubhouse !== null && clubhouse !== '') ||
                    (branch !== null && branch !== '') ||
                    (team !== null && team !== '') ||
                    (company !== null && company !== ''))
            ) {
                console.log('empty params');
                console.log('employementtype', employementtype);
                if (employementtype == 2) {
                    document.getElementById('probationary_employees').style.backgroundColor = '#FFFFE6';
                } else if (employementtype == 3) {
                    document.getElementById('project_employees').style.backgroundColor = '#FFFFE6';
                } else if (employementtype == 1) {
                    document.getElementById('regular_employees').style.backgroundColor = '#FFFFE6';
                } else if (employementtype == 4) {
                    document.getElementById('interns').style.backgroundColor = '#FFFFE6';
                }
            }
        } else {
            document.getElementById('active_employees').style.backgroundColor = '#FFFFE6';
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#search_select').select2();
            $("#search_select").on("change", function() {
                search();
            });
        });

        function search() {
            let search_select = $("#search_select").find(":selected").val();
            console.log('search_select', search_select);
            if (!search_select) return;
            if (search_select == 'all') {
                filter_clear();
            } else {
                if (document.querySelector('.filter-container').classList.contains('visible')) {
                    window.location.href = "?search=" + search_select.replace(/\s/g, '_') + '&filter=1';
                } else {
                    window.location.href = "?search=" + search_select.replace(/\s/g, '_');
                }

            }
        }
    </script>
    <script>
        function filter_by_employee_type_id(id) {
            let filter_dept = "";
            let filter_sec = "";
            let filter_group = "";
            let filter_line = "";
            let filter_by_employment_type = id;
            let filter_team = "";
            let filter_branch = "";
            let filter_by_company = "";
            let filter_division = "";
            let filter_clubhouse = "";
            let filter_status = "";
            console.log(filter_dept)

            filterUrl = "&dept=" + filter_dept + '&sec=' + filter_sec + '&group=' + filter_group + '&line=' + filter_line + '&division=' + filter_division + '&clubhouse=' + filter_clubhouse + '&status=' + filter_status + '&branch=' + filter_branch + '&team=' + filter_team + '&company=' + filter_by_company + '&employementtype=' + filter_by_employment_type;

            if (document.querySelector('.filter-container').classList.contains('visible')) {
                filterUrl = filterUrl + '&filter=1';
            }
            window.location.href = "directories?page=<?= $current_page ?>&row=<?= $row ?>" + filterUrl;
        }

        function filter_clear() {
            document.location.href = "directories";
        }
    </script>
    <script>
        $(document).ready(function() {

            $('#filter_by_branch').select2();
            $('#filter_by_company').select2();
            $('#filter_by_department').select2();
            $('#filter_by_division').select2();
            $('#filter_by_clubhouse').select2();
            $('#filter_by_section').select2();
            $('#filter_by_group').select2();
            $('#filter_by_team').select2();
            $('#filter_by_line').select2();
            $('#filter_by_employment_type').select2();
            // $('#search_select').select2();

            var base_url = '<?= base_url() ?>';
            var department;
            var section;
            var group;
            var line;
            var status;
            var department_arr;
            var section_arr;
            var group_arr;
            var line_arr;
            var url_get_filter_data = '<?= base_url() ?>employees/get_filter_data';
            var url_get_filter_data_department = '<?= base_url() ?>employees/get_filter_data_department';
            var url_get_filter_data_section = '<?= base_url() ?>employees/get_filter_data_section';
            var url_get_filter_data_group = '<?= base_url() ?>employees/get_filter_data_group';
            var url_get_filter_data_line = '<?= base_url() ?>employees/get_filter_data_line';
            var url_get_all_filter_data = '<?= base_url() ?>employees/get_all_filter_data';
            var url_filter_by_department = '<?= base_url() ?>attendance/get_employee_data_filter_by_dept';
            var url_filter_section_by_department = '<?= base_url() ?>attendance/get_employee_section_data_filter_by_dept';
            var url_filter_by_section = '<?= base_url() ?>attendance/get_employee_data_filter_by_sect';
            var url_get_all_empl_data = '<?= base_url() ?>employees/get_all_employee_data';
            var url_filter_by_group = '<?= base_url() ?>attendance/get_employee_data_filter_by_group';
            var url_filter_by_line = '<?= base_url() ?>attendance/get_employee_data_filter_by_line';
            var url_filter_by_status = '<?= base_url() ?>attendance/get_employee_data_filter_by_status';
            var url_get_employee = '<?php echo base_url(); ?>employees/get_all_employee';
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                "formatted-num-pre": function(a) {
                    a = (a === "-" || a === "") ? 0 : a.replace(/[^\d\-\.]/g, "");
                    return parseFloat(a);
                },
                "formatted-num-asc": function(a, b) {
                    return a - b;
                },
                "formatted-num-desc": function(a, b) {
                    return b - a;
                }
            });
            $('#employee_tbl_filter').parent().parent().hide();
            $('#employee_tbl_info').parent().parent().hide();
            $('select.filter_by').on('change', function() {
                var filter_dept = $("#filter_by_department").val();
                var filter_sec = $("#filter_by_section").val();
                var filter_group = $("#filter_by_group").val();
                var filter_line = $("#filter_by_line").val();
                var filter_by_employment_type = $("#filter_by_employment_type").val();
                var filter_team = $("#filter_by_team").val();
                var filter_branch = $("#filter_by_branch").val();
                var filter_by_company = $("#filter_by_company").val();
                var filter_division = $("#filter_by_division").val();
                var filter_clubhouse = $("#filter_by_clubhouse").val();
                var filter_status = $("#filter_by_status").val();
                // console.log('filter_by_company',filter_by_company)
                // console.log('filter_division',filter_division)

                filterUrl = "&dept=" + filter_dept + '&sec=' + filter_sec + '&group=' + filter_group + '&line=' + filter_line + '&division=' + filter_division + '&clubhouse=' + filter_clubhouse + '&status=' + filter_status + '&branch=' + filter_branch + '&team=' + filter_team + '&company=' + filter_by_company + '&employementtype=' + filter_by_employment_type;
                if (document.querySelector('.filter-container').classList.contains('visible')) {
                    filterUrl = filterUrl + '&filter=1';
                }
                document.location.href = "directories?page=<?= $current_page ?>&row=<?= $row ?>" + filterUrl;
            })

            // $("#filter_by_department").change(function() {
            //     var filter_dept = document.getElementById("filter_by_department");
            //     document.location.href = "directories?"+ "dept=" + filter_dept.value ;
            // })
            // $("#filter_by_section").change(function() {
            //     var filter_sec = document.getElementById("filter_by_section");
            //     document.location.href = "directories?"+ "sec=" + filter_sec.value;
            // })
            // $("#filter_by_group").change(function() {
            //     var filter_group = document.getElementById("filter_by_group");
            //     document.location.href = "directories?"+ "group=" + filter_group.value;
            // })
            // $("#filter_by_line").change(function() {
            //     var filter_line = document.getElementById("filter_by_line");
            //     document.location.href = "directories?"+ "line=" + filter_line.value;
            // })
            // $("#filter_by_team").change(function() {
            //     var filter_team = document.getElementById("filter_by_team");
            //     document.location.href = "directories?"+ "team=" + filter_team.value;
            // })

            // $("#filter_by_branch").change(function() {
            //     var filter_branch = document.getElementById("filter_by_branch");
            //     document.location.href = "directories?"+ "branch=" + filter_branch.value;
            // })

            // $("#filter_by_division").change(function() {
            //     var filter_division = document.getElementById("filter_by_division");
            //     document.location.href = "directories?"+ "division=" + filter_division.value;
            // })

            // $("#filter_by_status").change(function() {
            //     var filter_status = document.getElementById("filter_by_status");
            //     document.location.href = "directories?"+ "status=" + filter_status.value;
            // })


            $('#btn_clear_filter').click(function() {
                $("#filter_by_division").val("");
                $("#filter_by_clubhouse").val("");
                $("#filter_by_branch").val("");
                $("#filter_by_company").val("");
                $("#filter_by_team").val("");
                $("#filter_by_status").val("");
                $("#filter_by_line").val("");
                $("#filter_by_employment_type").val("");
                $("#filter_by_group").val("");
                $("#filter_by_section").val("");
                $("#filter_by_department").val("");
                document.location.href = "directories";
            })
            // $('#search').click(function(){
            //     $('#search_data').val();
            //     $("#filter_by_division").val("");
            //     $("#filter_by_branch").val("");
            //     $("#filter_by_team").val("");
            //     $("#filter_by_status").val("");
            //     $("#filter_by_line").val("");
            //     $("#filter_by_group").val("");
            //     $("#filter_by_section").val("");
            //     $("#filter_by_department").val("");
            //     var optionValue = $('#search_data').val();
            //     document.location.href = "directories?"+ "all=" + optionValue.replace(/\s/g, '_')+"&status=<?= $status ?>";
            // })

            $("#clear_search_btn").on("click", function() {
                var url = window.location.href.split("?")[0];
                window.location = url
            });

            $("#search_btn").on("click", function() {
                search_data();
            });

            $("#search_data").on("keypress", function(e) {
                if (e.which === 13) {
                    search_data();
                }
            });

            function search_data() {
                $('#search_data').val();
                $("#filter_by_division").val("");
                $("#filter_by_clubhouse").val("");
                $("#filter_by_branch").val("");
                $("#filter_by_company").val("");
                $("#filter_by_team").val("");
                $("#filter_by_status").val("");
                $("#filter_by_line").val("");
                $("#filter_by_employment_type").val("");
                $("#filter_by_group").val("");
                $("#filter_by_section").val("");
                $("#filter_by_department").val("");
                var optionValue = $('#search_data').val();
                document.location.href = "directories?" + "all=" + optionValue.replace(/\s/g, '_') + "&status=<?= $status ?>";
            }




            function search(search_val) {
                var url_get_searched_employee = '<?php echo base_url(); ?>employees/get_searched_employee';
                $('#table_container').html('');
                get_searched_employee(url_get_searched_employee, search_val).then(function(data) {
                    Array.from(data).forEach(function(e) {
                        console.log(e)
                        var empl_image = "<?= base_url() ?>user_images/default_profile_img3.png";
                        if (e.col_imag_path) {
                            var empl_image = "<?= base_url() ?>user_images/" + e.col_imag_path;
                        }
                        if (e.col_midl_name) {
                            var midl_ini = e.col_midl_name + '.';
                        } else {
                            var midl_ini = '';
                        }
                        var empl_name = e.col_last_name + ', ' + e.col_frst_name + ' ' + midl_ini;
                        $('#table_container').append(`
                            <tr class="bank_row" data-toggle="modal" data-target="#modal_edit_bank" empl_cmid="` + e.col_empl_cmid + `">
                                <td>` + e.col_empl_cmid + `</td>
                                <td>
                                    <a href = "<?= base_url() ?>employees/personal?id=` + e.id + `">
                                        <img class="rounded-circle avatar " width="35" height="35" src="` + empl_image + `">&nbsp;&nbsp;` + empl_name + `
                                    </a>
                                </td>
                                <td>` + e.col_empl_type + `</td>
                                <td>` + e.col_empl_posi + `</td>
                                <td>` + e.col_empl_dept + `</td>
                                <td>` + e.col_empl_sect + `</td>
                                <td>` + e.col_empl_group + `</td>
                                <td>` + e.col_empl_line + `</td>
                            </tr>
                        `)
                    })
                })
            }

            function reset_table() {
                $('#table_container').html('');
                var row_count = $('#row_count').val();
                var page_count = $('#page_count').val();
                var page_num = 1;
                if ($('#current_page').val()) {
                    var page_num = $('#current_page').val();
                }
                get_employee(url_get_employee, page_num).then(function(data) {
                    Array.from(data).forEach(function(e) {
                        console.log(e)
                        var empl_image = "<?= base_url() ?>user_images/default_profile_img3.png";
                        if (e.col_imag_path) {
                            var empl_image = "<?= base_url() ?>user_images/" + e.col_imag_path;
                        }
                        if (e.col_midl_name) {
                            var midl_ini = e.col_midl_name + '.';
                        } else {
                            var midl_ini = '';
                        }
                        var empl_name = e.col_last_name + ', ' + e.col_frst_name + ' ' + midl_ini;
                        $('#table_container').append(`
                            <tr class="bank_row" data-toggle="modal" data-target="#modal_edit_bank" empl_cmid="` + e.col_empl_cmid + `">
                                <td>` + e.col_empl_cmid + `</td>
                                <td>
                                    <a href = "<?= base_url() ?>employees/personal?id=` + e.id + `">
                                        <img class="rounded-circle avatar " width="35" height="35" src="` + empl_image + `">&nbsp;&nbsp;` + empl_name + `
                                    </a>
                                </td>
                                <td>` + e.col_empl_type + `</td>
                                <td>` + e.col_empl_posi + `</td>
                                <td>` + e.col_empl_dept + `</td>
                                <td>` + e.col_empl_sect + `</td>
                                <td>` + e.col_empl_group + `</td>
                                <td>` + e.col_empl_line + `</td>
                            </tr>
                        `)
                    })
                })
            }
            async function get_searched_employee(url, search) {
                var formData = new FormData();
                formData.append('search', search);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            // function display_filtered_empl(department, section, line, group, status) {
            //     $('#loader_gif').show();
            //     // change employee dropdown
            //     $('#table_container').html('');
            //     get_filter_data(url_get_filter_data, department, line, group, section, status).then(function(data) {
            //         if (data.length > 0) {
            //             Array.from(data).forEach(function(x) {
            //                 var user_image = '';
            //                 if (x.col_imag_path) {
            //                     user_image = base_url + 'user_images/' + x.col_imag_path;
            //                 } else {
            //                     user_image = base_url + 'user_images/default_profile_img3.png';
            //                 }
            //                 var fullname = '';
            //                 if ((x.col_frst_name) && (x.col_last_name)) {
            //                     if (x.col_midl_name) {
            //                         fullname = x.col_last_name + ', ' + x.col_frst_name + ' ' + x.col_midl_name[0] + '.';
            //                     } else {
            //                         fullname = x.col_last_name + ', ' + x.col_frst_name;
            //                     }
            //                 }
            //                 $('#loader_gif').hide();
            //                 $('#table_container').append(`
            //                     <tr>
            //                         <td>` + x.col_empl_cmid + `</td>
            //                         <td><a href = "<?= base_url() ?>employees/personal?id=` + x.id + `">
            //                             <img class="rounded-circle avatar " width="35" height="35" src="` + user_image + `">&nbsp;&nbsp;` + fullname + `</a>
            //                         </td>
            //                         <td>` + x.col_empl_type + `</td>
            //                         <td>` + x.col_empl_posi + `</td>
            //                         <td>` + x.col_empl_dept + `</td>
            //                         <td>` + x.col_empl_sect + `</td>
            //                         <td>` + x.col_empl_group + `</td>
            //                         <td>` + x.col_empl_line + `</td>
            //                     </tr>
            //                 `);
            //             })
            //         } else {
            //             $('#loader_gif').hide();
            //             $('#table_container').append(`
            //                     <td colspan="7">No Employees Detected</td>
            //             `);
            //         }
            //         $('#total_employees').text($('#table_container tr').length);
            //     })
            // }
            function display_filtered_empl_status(department, section, line, group, status) {
                $('#loader_gif').show();
                // change employee dropdown
                $('#table_container').html('');
                if (status == 0) {
                    get_filter_data(url_get_filter_data, department, line, group, section, status).then(function(data) {
                        if (data.length > 0) {
                            Array.from(data).forEach(function(x) {
                                var user_image = '';
                                if (x.col_imag_path) {
                                    user_image = base_url + 'user_images/' + x.col_imag_path;
                                } else {
                                    user_image = base_url + 'user_images/default_profile_img3.png';
                                }
                                var fullname = '';
                                if ((x.col_frst_name) && (x.col_last_name)) {
                                    if (x.col_midl_name) {
                                        fullname = x.col_last_name + ', ' + x.col_frst_name + ' ' + x.col_midl_name[0] + '.';
                                    } else {
                                        fullname = x.col_last_name + ', ' + x.col_frst_name;
                                    }
                                }
                                $('#loader_gif').hide();
                                $('#table_container').append(`
                                    <tr>
                                        <td>` + x.col_empl_cmid + `</td>
                                        <td><a href = "<?= base_url() ?>employees/personal?id=` + x.id + `">
                                            <img class="rounded-circle avatar " width="35" height="35" src="` + user_image + `">&nbsp;&nbsp;` + fullname + `</a>
                                        </td>
                                        <td>` + x.col_empl_type + `</td>
                                        <td>` + x.col_empl_posi + `</td>
                                        <td>` + x.col_empl_dept + `</td>
                                        <td>` + x.col_empl_sect + `</td>
                                        <td>` + x.col_empl_group + `</td>
                                        <td>` + x.col_empl_line + `</td>
                                    </tr>
                                `);
                            })
                        } else {
                            $('#loader_gif').hide();
                            $('#table_container').append(`
                                    <td colspan="7">No Employees Detected</td>
                            `);
                        }
                        $('#total_employees').text($('#table_container tr').length);
                    })
                } else {
                    get_filter_data(url_get_filter_data, department, line, group, section, status).then(function(data) {
                        if (data.length > 0) {
                            Array.from(data).forEach(function(x) {
                                var user_image = '';
                                if (x.col_imag_path) {
                                    user_image = base_url + 'user_images/' + x.col_imag_path;
                                } else {
                                    user_image = base_url + 'user_images/default_profile_img3.png';
                                }
                                var fullname = '';
                                if ((x.col_frst_name) && (x.col_last_name)) {
                                    if (x.col_midl_name) {
                                        fullname = x.col_last_name + ', ' + x.col_frst_name + ' ' + x.col_midl_name[0] + '.';
                                    } else {
                                        fullname = x.col_last_name + ', ' + x.col_frst_name;
                                    }
                                }
                                $('#loader_gif').hide();
                                $('#table_container').append(`
                                    <tr data-toggle="modal" data-target="#modal_show_termination_details" style="cursor:pointer">
                                        <td>` + x.col_empl_cmid + `</td>
                                        <td><a href = "<?= base_url() ?>employees/personal?id=` + x.id + `">
                                            <img class="rounded-circle avatar " width="35" height="35" src="` + user_image + `">&nbsp;&nbsp;` + fullname + `</a>
                                        </td>
                                        <td>` + x.col_empl_type + `</td>
                                        <td>` + x.col_empl_posi + `</td>
                                        <td>` + x.col_empl_dept + `</td>
                                        <td>` + x.col_empl_sect + `</td>
                                        <td>` + x.col_empl_group + `</td>
                                        <td>` + x.col_empl_line + `</td>
                                    </tr>
                                `);
                            })
                        } else {
                            $('#loader_gif').hide();
                            $('#table_container').append(`
                                    <td colspan="7">No Employees Detected</td>
                            `);
                        }
                        $('#total_employees').text($('#table_container tr').length);
                    })
                }
            }

            function capitalizeFirstLetter(word) {
                var newStr = word.split('');
                return newStr[0].toUpperCase();
            }
            // ------------------------------ Pagination -------------------------------------
            // TECHNOS STANDARD: DO NOT CHANGE
            var row_count = $('#row_count').val();
            var page_count = $('#page_count').val();


            $('#submit_bulk_approve').click(function() {
                $('#form_bulk_activate').submit();
            })

            $('#submit_bulk_reject').click(function() {
                $('#form_bulk_deactivate').submit();
            })


            $('#bulk_activate').click(function() {
                let selected_id = [];
                let selected_empl_id = [];
                let selected_row_id = [];

                $('#approve_list_id').empty();

                $('#select_item input[type=checkbox]:checked').each(function() {
                    let selected_item = $(this).val();
                    let att_empl_id = $(this).attr('employee_id');
                    let att_row_id = $(this).attr('row_id');

                    selected_id.push(selected_item);
                    selected_empl_id.push(att_empl_id);
                    selected_row_id.push(att_row_id);
                })

                if (selected_id.length > 0) {
                    $('.class_modal_approve').prop('id', 'modal_bulk_activate');
                    let empl_ids = selected_empl_id.join(',');
                    $('#EMPLOYEE_ID').val(empl_ids);
                    selected_row_id.forEach(function(data) {
                        $('#approve_list_id').append(`<li class="col-md-6">ID : <strong>EMPLOYEE ID : ${data}</strong></li>`);
                    })
                } else {
                    $('.class_modal_approve').prop('id', '');
                    Swal.fire(
                        'Please Select Employee!',
                        '',
                        'warning'
                    )
                }
            })


            $('#bulk_deactivate').click(function() {
                let selected_id = [];
                let selected_empl_id = [];
                let selected_row_id = [];
                $('#APPROVAL_ID').empty();
                $('#reject_list_id').empty();
                $('#select_item input[type=checkbox]:checked').each(function() {
                    let selected_item = $(this).val();
                    let att_empl_id = $(this).attr('employee_id');
                    let att_row_id = $(this).attr('row_id');
                    selected_id.push(selected_item);
                    selected_empl_id.push(att_empl_id);
                    selected_row_id.push(att_row_id);
                })
                if (selected_id.length > 0) {
                    $('.class_modal_reject').prop('id', 'modal_bulk_deactivate');
                    let empl_ids = selected_empl_id.join(',');
                    $('#EMPLOYEE_DEACTIVATE_ID').val(empl_ids);
                    selected_row_id.forEach(function(data) {
                        $('#reject_list_id').append(`<li class="col-md-6">ID : <strong>EMPLOYEE ID : ${data}</strong></li>`);
                    })
                } else {
                    $('.class_modal_reject').prop('id', '');
                    Swal.fire(
                        'Please Select Employee!',
                        '',
                        'warning'
                    )
                }
            })



            $('#check_all').click(function() {
                if (this.checked == true) {
                    Array.from($('.check_single')).forEach(function(element) {
                        $(element).prop('checked', true);
                        $('.check_single').parent().parent().css('background', '#e7f4e4');
                    })
                } else {
                    Array.from($('.check_single')).forEach(function(element) {
                        $(element).prop('checked', false);
                        $('.check_single').parent().parent().css('background', '');
                    })
                }
            })
            $('.check_single').on('change', function() {
                if (this.checked == true) {
                    $(this).parent().parent().css('background', '#e7f4e4');
                } else {
                    $(this).parent().parent().css('background', '');
                }
            })


            $('#row_dropdown').on('change', function() {
                var row_val = $(this).val();
                document.location.href = base_url + "employees/directories?page=1&row=" + row_val + "&dept=<?= $dept ?>&sec=<?= $sec ?>&group=<?= $group ?>&line=<?= $line ?>&division=<?= $division ?>&status=<?= $status ?>";
            });



            async function get_employee(url, page_num) {
                var formData = new FormData();
                formData.append('page_num', page_num);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function update_status_remarks(url, date, empl_id, status, remarks) {
                var formData = new FormData();
                formData.append('date', date);
                formData.append('empl_id', empl_id);
                formData.append('status', status);
                formData.append('remarks', remarks);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_all_employee_data(url) {
                var formData = new FormData();
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            // ==================================================== FILTER ========================================================
            async function get_employee_section_data_filter_by_dept(url, department) {
                var formData = new FormData();
                formData.append('department', department);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_employee_data_filter_by_group(url, group) {
                var formData = new FormData();
                formData.append('group', group);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_employee_data_filter_by_line(url, line) {
                console.log('get_employee_data_filter_by_line')
                var formData = new FormData();
                formData.append('line', line);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_employee_data_filter_by_status(url, status) {
                var formData = new FormData();
                formData.append('status', status);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_employee_data_filter_by_sect(url, section) {
                var formData = new FormData();
                formData.append('section', section);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_employee_data_filter_by_dept(url, department) {
                var formData = new FormData();
                formData.append('department', department);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            // ================================ ASYNC FILTER ===================================
            async function get_filter_data(url, department, line, group, section, status) {
                var formData = new FormData();
                formData.append('department', department);
                formData.append('line', line);
                formData.append('group', group);
                formData.append('section', section);
                formData.append('status', status);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_all_filter_data(url) {
                var formData = new FormData();
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
        })
    </script>
    <!-------------------- Export ----------------->
    <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <script>
        document.getElementById("btn_export").addEventListener('click', function() {
            /* Create worksheet from HTML DOM TABLE */
            var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
            /* Export to file (start a download) */
            XLSX.writeFile(wb, "Employee Directory.xlsx");
        });
    </script> -->

    <script>
        function toggleFilter() {
            var filterContainers = document.querySelectorAll('.filter-container');

            filterContainers.forEach(function(container) {
                container.classList.toggle('visible');
            });
        }
    </script>

</body>

</html>