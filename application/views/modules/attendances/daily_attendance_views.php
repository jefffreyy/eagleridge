<html>
<?php $this->load->view('templates/css_link'); ?>
<?php

(isset($_GET['dept']) ? $dept                       = $_GET['dept'] : $dept = "");
(isset($_GET['section']) ? $sec                     = $_GET['section'] : $sec = "");
(isset($_GET['group']) ? $group                     = $_GET['group'] : $group = "");
(isset($_GET['line']) ? $line                       = $_GET['line'] : $line = "");
(isset($_GET['employementtype']) ? $employment_type = $_GET['employementtype'] : $employment_type = "");
(isset($_GET['team']) ? $team                       = $_GET['team'] : $team = "");
(isset($_GET['division']) ? $division               = $_GET['division'] : $division = "");
(isset($_GET['clubhouse']) ? $clubhouse               = $_GET['clubhouse'] : $clubhouse = "");
(isset($_GET['branch']) ? $branch                   = $_GET['branch'] : $branch = "");
(isset($_GET['company']) ? $company                 = $_GET['company'] : $company = "");
(isset($_GET['status']) ? $status                   = $_GET['status'] : $status = "");
(isset($_GET['all']) ? $all                         = $_GET['all'] : $all = "");

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
if (isset($_GET['clubhouse'])) {
    $param_clubhouse = $_GET['clubhouse'];
} else {
    $param_clubhouse = "";
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

(isset($_GET['attendance_filter']) ? $attendance_filter = $_GET['attendance_filter'] : $attendance_filter = "");

if (isset($_GET['date'])) {
    $date = $_GET['date'];
} else {
    $date = date('Y-m-d');
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

    #all_active {
        background-color: #46cf6a;
    }

    .small-box {
        position: relative;
    }

    .small-box .icon {
        position: absolute;
        top: 28px;
        right: 17px;

    }

    .small-box img {
        transition: 0.5s ease;
    }

    .small-box:hover img {
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
</style>

<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">

            <div class="row">
                <div class="col-md-6">
                    <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'attendances'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                        </a>&nbsp;Daily Attendance</h1>
                </div>

                <div class="col-md-6 button-title d-flex justify-content-end">

                    <a href="" id="btn_export" class="btn btn-primary shadow-none"><img style="margin-bottom: 4px;" src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>" alt=""> Export XLSX</a>

                </div>
            </div>
            <hr>

            <div class="filter-container <?= $filter ? 'visible' : '' ?>">
                <div class="card border-0 p-0 m-0">
                    <div class="p-1">
                        <div class="row">
                            <div class="col-md-3">
                                <div class='m-2'>
                                    <h6 class='p-0 mb-1'>Date</h6>
                                    <input class="custom-select " type="date" id="date_selection" name="start" value="<?= $date ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="row mb-3">
                <div class="col-md-4">
                    <div class="input-group mb-3"></div>
                </div>
            </div> -->

            <div class="row mt-4">
                <div class="col-6 col-lg-3 hover" id="allEmployee">
                    <div class="card p-2 small-box" <?= ($attendance_filter == '') ? "style='background-color: #FFFFE6'" : "" ?>>
                        <div style="padding: 10px 10px;" class="text-left">
                            <text class="text-nowrap" style="font-size: 2.2rem; font-weight: 700;">
                                <?= $DISP_ALL_EMPLOYEE_COUNT; ?>
                            </text><br>
                            <text class="text-nowrap">All Active</text>
                        </div>

                        <div class="icon">
                            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/user-tie-hair-solid_2xl.svg') ?>" alt="" />
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 hover" id="unAssignedBtn">
                    <div class="card p-2 small-box" <?= ($attendance_filter == 'unassigned_shift') ? "style='background-color: #FFFFE6'" : "" ?>>
                        <div style="padding: 10px 10px;" class="text-left">
                            <text class="text-nowrap" style="font-size: 2.2rem; font-weight: 700;" id="">
                                <?= $DISP_UNASSIGNED_SHIFT_COUNT ?>
                            </text><br>
                            <text class="text-nowrap">Uassigned Shift</text>
                        </div>

                        <div class="icon">
                            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/users-solid2xl.svg') ?>" alt="" />
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 hover" id="no_in">
                    <div class="card p-2 small-box" <?= ($attendance_filter == 'no_in') ? "style='background-color: #FFFFE6'" : "" ?>>
                        <div style="padding: 10px 10px;" class="text-left">
                            <text class="text-nowrap" style="font-size: 2.2rem; font-weight: 700;" id="">
                                <?= $DISP_IN_SHIFT_COUNT ?>
                            </text><br>
                            <text class="text-nowrap">No IN (Have workshift)</text>
                        </div>

                        <div class="icon">
                            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/timer-solid.svg') ?>" alt="" />
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 hover" id="no_out">
                    <div class="card p-2 small-box" <?= ($attendance_filter == 'no_out') ? "style='background-color: #FFFFE6'" : "" ?>>
                        <div style="padding: 10px 10px;" class="text-left">
                            <text class="text-nowrap" style="font-size: 2.2rem; font-weight: 700;" id="">
                                <?= $DISP_OUT_SHIFT_COUNT ?>
                            </text><br>
                            <text class="text-nowrap">No OUT (Have workshift)</text>
                        </div>

                        <div class="icon">
                            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/user-tie-hair-solid_2xl.svg') ?>" alt="" />
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 hover" id="rest_count">
                    <div class="card p-2 small-box" <?= ($attendance_filter == 'rest_count') ? "style='background-color: #FFFFE6'" : "" ?>>
                        <div style="padding: 10px 10px;" class="text-left">
                            <text class="text-nowrap" style="font-size: 2.2rem; font-weight: 700;" id="">
                                <?= $DISP_REST_COUNT ?>
                            </text><br>
                            <text class="text-nowrap">Rest</text>
                        </div>

                        <div class="icon">
                            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/user-tie-hair-solid_2xl.svg') ?>" alt="" />
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 hover" id="on_leave">
                    <div class="card p-2 small-box" <?= ($attendance_filter == 'on_leave') ? "style='background-color: #FFFFE6'" : "" ?>>
                        <div style="padding: 10px 10px;" class="text-left">
                            <text class="text-nowrap" style="font-size: 2.2rem; font-weight: 700;" id="">
                                <?= $DISP_LEAVE_COUNT ?>
                            </text><br>
                            <text class="text-nowrap">On Leave</text>
                        </div>

                        <div class="icon">
                            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/user-tie-hair-solid_2xl.svg') ?>" alt="" />
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 hover" id="with_tardiness">
                    <div class="card p-2 small-box" <?= ($attendance_filter == 'with_tardiness') ? "style='background-color: #FFFFE6'" : "" ?>>
                        <div style="padding: 10px 10px;" class="text-left">
                            <text class="text-nowrap" style="font-size: 2.2rem; font-weight: 700;" id="">
                                <?= $DISP_TARDINESS_COUNT ?>
                            </text><br>
                            <text class="text-nowrap">With Tardiness</text>
                        </div>

                        <div class="icon">
                            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/user-tie-hair-solid_2xl.svg') ?>" alt="" />
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 hover" id="with_undertime">
                    <div class="card p-2 small-box" <?= ($attendance_filter == 'with_undertime') ? "style='background-color: #FFFFE6'" : "" ?>>
                        <div style="padding: 10px 10px;" class="text-left">
                            <text class="text-nowrap" style="font-size: 2.2rem; font-weight: 700;" id="">
                                <?= $DISP_UNDERTIME_COUNT ?>
                            </text><br>
                            <text class="text-nowrap">With Undertime</text>
                        </div>

                        <div class="icon">
                            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/user-tie-hair-solid_2xl.svg') ?>" alt="" />
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 hover" id="remote_count">
                    <div class="card p-2 small-box" <?= ($attendance_filter == 'remote_count') ? "style='background-color: #FFFFE6'" : "" ?>>
                        <div style="padding: 10px 10px;" class="text-left">
                            <text class="text-nowrap" style="font-size: 2.2rem; font-weight: 700;" id="">
                                <?= $DISP_REMOTE_COUNT ?>
                            </text><br>
                            <text class="text-nowrap">Remote</text>
                        </div>

                        <div class="icon">
                            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/user-tie-hair-solid_2xl.svg') ?>" alt="" />
                        </div>
                    </div>
                </div>
            </div>

            <div class=" filter-container <?= $filter ? 'visible' : '' ?>">
                <div class=" row  d-flex mt-4">

                    <div class="col-md-2 " <?php echo ($DISP_VIEW_COMPANY ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Company</p>
                        <select id="filter_by_company" class="form-control filter_by">
                            <?php
                            if ($C_COMPANIES) {
                            ?>
                                <option value="all" <?php foreach ($C_COMPANIES as $Row) {
                                                        if ($Row->name == '') {
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
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2 " <?php echo ($DISP_VIEW_BRANCH ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Branch</p>
                        <select id="filter_by_branch" class="form-control filter_by">
                            <?php
                            if ($C_BRANCH) {
                            ?>
                                <option value="all" <?php foreach ($C_BRANCH as $C_BRANCH_ROW_1) {
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
                                <option value="all" <?php foreach ($C_DEPARTMENTS as $DISP_DISTINCT_DEPARTMENT_ROW_1) {
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
                                <option value="all" <?php foreach ($C_DIVISIONS as $C_DIVISIONS_ROW_1) {
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
                                <option value="all" <?php foreach ($C_CLUBHOUSE as $C_CLUBHOUSE_ROW_1) {
                                                        if ($C_CLUBHOUSE_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Clubhouse</option>
                                <?php
                                foreach ($C_CLUBHOUSE as $C_CLUBHOUSE_ROW) {
                                    if ($C_CLUBHOUSE_ROW->name != '') {
                                ?>
                                        <option value="<?= $C_CLUBHOUSE_ROW->id ?>" <?= ($C_CLUBHOUSE_ROW->id == $clubhouse) ? 'selected' : ''; ?>><?= $C_CLUBHOUSE_ROW->name ?></option>
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
                                <option value="all" <?php foreach ($C_SECTIONS as $DISP_DISTINCT_SECTION_ROW_1) {
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
                                <option value="all" <?php foreach ($C_GROUPS as $DISP_Group_ROW_1) {
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
                                <option value="all" <?php foreach ($C_TEAMS as $C_TEAMS_ROW_1) {
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
                                <option value="all" <?php foreach ($C_LINES as $DISP_Line_ROW_1) {
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
                                <option value="all" <?php foreach ($C_EMPLOYMENT_TYPES as $employmentTyperow_1) {
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
                        <p class="mb-1 text-secondary ">Action</p>
                        <a href="#" id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
                    </div> -->
                </div>



            </div>

            <div class="row">
                <div class="col-12 col-lg-6">

                </div>
                <div class="col-12 col-lg-6 mt-3 ml-auto d-flex justify-content-center justify-content-lg-end">
                <button id="btnFilter" class="btn btn-primary shadow-none rounded ml-1" onclick="toggleFilter()"><img src="<?= base_url('assets_system/icons/advance_filter.svg') ?>" style="margin-bottom: 1px" alt="">&nbsp;Advance Filter</button>
                <a href="<?= base_url('attendances/daily_attendances') ?>" id="btn_clear_filter" class="btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="">&nbsp;Clear</a>
            </div>
            </div>
           

            <div class="card border-0 mt-4" style="padding: 0px; margin: 0px">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive" style='max-height:75vh;'>
                            <table class="table table-hover table-bordered mb-0" id="TableToExport">
                                <thead style='position:sticky;top:-1px'>
                                    <tr style="line-height: 7px">
                                        <th class="th-lg text-nowrap" rowspan=3 style="text-align: left">EMPLOYEE&nbsp;ID</th>
                                        <th class="th-xl text-nowrap" rowspan=3 style="text-align: left">NAME</th>
                                        <th class="th-sm text-nowrap" rowspan=3 style="text-align: left">SHIFT CODE</th>
                                        <th class="th-sm text-nowrap" colspan=6 style="text-align: center">SHIFT TIME</th>
                                        <th class="th-sm text-nowrap" colspan=4 style="text-align: center; background-color: #DAFFDA">ACTUAL TIME</th>
                                    </tr>

                                    <tr style="line-height: 7px">
                                        <th class="th-lg text-nowrap" colspan=2 style="text-align: center;">REGULAR</th>
                                        <th class="th-lg text-nowrap" colspan=2 style="text-align: center;">BREAK</th>
                                        <th class="th-lg text-nowrap" colspan=2 style="text-align: center;">OVERTIME</th>
                                        <th class="th-lg text-nowrap" colspan=2 style="text-align: center; background-color: #DAFFDA">REGULAR</th>
                                        <th class="th-lg text-nowrap" colspan=2 style="text-align: center; background-color: #DAFFDA">BREAK</th>
                                    </tr>

                                    <tr style="line-height: 7px">
                                        <th class="th-lg text-nowrap" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">IN</th>
                                        <th class="th-lg text-nowrap" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">OUT</th>
                                        <th class="th-lg text-nowrap" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">IN</th>
                                        <th class="th-lg text-nowrap" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">OUT</th>
                                        <th class="th-lg text-nowrap" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">IN</th>
                                        <th class="th-lg text-nowrap" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">OUT</th>
                                        <th class="th-lg text-nowrap" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center; background-color: #DAFFDA">IN</th>
                                        <th class="th-lg text-nowrap" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center; background-color: #DAFFDA">OUT</th>
                                        <th class="th-lg text-nowrap" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center; background-color: #DAFFDA">IN</th>
                                        <th class="th-lg text-nowrap" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center; background-color: #DAFFDA">OUT</th>
                                    </tr>
                                </thead>

                                <tbody id="table_container">
                                    <?php if ($DISP_ATTENDANCE_TODAY) {
                                        foreach ($DISP_ATTENDANCE_TODAY as $EMPLOYEE) { ?>
                                            <tr>
                                                <td><?= $EMPLOYEE->cmid ?></td>
                                                <td><?= $EMPLOYEE->fullname ?></td>
                                                <td><?= $EMPLOYEE->shiftCode ?></td>
                                                <td><?= ($EMPLOYEE->shiftIn == "00:00") ? "" : $EMPLOYEE->shiftIn; ?></td>
                                                <td><?= ($EMPLOYEE->shiftOut  == "00:00") ? "" : $EMPLOYEE->shiftOut; ?></td>
                                                <td><?= $EMPLOYEE->shiftBreakIn ?></td>
                                                <td><?= $EMPLOYEE->shiftBreakOut ?></td>
                                                <td></td>
                                                <td></td>
                                                <td class="clock_stamp" data-toggle="modal" data-target="#remoteInfo" data-image="<?=$EMPLOYEE->time_in_img?>" 
                                                    data-address="<?=$EMPLOYEE->time_in_add?>" data-image_text="Time In Snapshot" data-address_text="Time In Address"
                                                    style="background-color: #FFFFE6;<?=!empty($EMPLOYEE->time_in_img) || !empty($EMPLOYEE->time_in_add)   ?'font-weight: 450;color:blue; background-color: #FFFFE6' : '' ?>"
                                                    >
                                                    <?= $EMPLOYEE->actIn ?>
                                    <?php if  (!empty($EMPLOYEE->time_in_img) ||
                                                    !empty($EMPLOYEE->time_in_add)) { ?>
                                                    <img class="" src="<?= base_url('assets_system/icons/circle-info-solid_2xs.svg') ?>" style="height: 14px; width: 14px; margin-bottom: 3px;" alt="">
                                    <?php } ?>
                                                </td>
                                                <td class="clock_stamp" data-toggle="modal" data-target="#remoteInfo" data-image="<?=$EMPLOYEE->time_out_img?>" 
                                                    data-address="<?=$EMPLOYEE->time_out_add?>" data-image_text="Time Out Snapshot" data-address_text="Time Out Address"
                                                    style="background-color: #FFFFE6;<?=!empty($EMPLOYEE->time_out_img) || !empty($EMPLOYEE->time_out_add)   ?'font-weight: 450;color:blue; background-color: #FFFFE6' : '' ?>"
                                                    >
                                                    <?= $EMPLOYEE->actOut ?>
                                    <?php if  (!empty($EMPLOYEE->time_out_img) ||
                                                    !empty($EMPLOYEE->time_out_add)) { ?>
                                                    <img class="" src="<?= base_url('assets_system/icons/circle-info-solid_2xs.svg') ?>" style="height: 14px; width: 14px; margin-bottom: 3px;" alt="">
                                    <?php } ?>
                                                </td>
                                                <td class="clock_stamp" data-toggle="modal" data-target="#remoteInfo" data-image="<?=$EMPLOYEE->break_in_img?>" 
                                                    data-address="<?=$EMPLOYEE->break_in_add?>" data-image_text="Break In Snapshot" data-address_text="Break In Address"
                                                    style="background-color: #FFFFE6;<?=!empty($EMPLOYEE->break_in_add) || !empty($EMPLOYEE->break_in_img)   ?'font-weight: 450;color:blue; background-color: #FFFFE6' : '' ?>"
                                                    >
                                                    <?= $EMPLOYEE->shiftBreakIn ?>
                                    <?php if  (!empty($EMPLOYEE->break_in_add) ||
                                                    !empty($EMPLOYEE->break_in_img)) { ?>
                                                    <img class="" src="<?= base_url('assets_system/icons/circle-info-solid_2xs.svg') ?>" style="height: 14px; width: 14px; margin-bottom: 3px;" alt="">
                                    <?php } ?>
                                                </td>
                                                <td class="clock_stamp" data-toggle="modal" data-target="#remoteInfo" data-image="<?=$EMPLOYEE->break_out_img?>" 
                                                    data-address="<?=$EMPLOYEE->break_out_add?>" data-image_text="Break Out Snapshot" data-address_text="Break Out Address"
                                                    style="background-color: #FFFFE6;<?=!empty($EMPLOYEE->break_out_add) || !empty($EMPLOYEE->break_out_img)   ?'font-weight: 450;color:blue; background-color: #FFFFE6' : '' ?>"
                                                    >
                                                    <?= $EMPLOYEE->shiftBreakOut ?>
                                    <?php if  (!empty($EMPLOYEE->break_out_add) ||
                                                    !empty($EMPLOYEE->break_out_img)) { ?>
                                                    <img class="" src="<?= base_url('assets_system/icons/circle-info-solid_2xs.svg') ?>" style="height: 14px; width: 14px; margin-bottom: 3px;" alt="">
                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else { ?>

                                        <tr class="table-active">
                                            <td colspan="13">
                                                <center>No Employee Yet</center>
                                            </td>
                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>

                            <div class="w-100 text-center">
                                <img src="<?= base_url() ?>images/loader2.gif" id="loader_gif" style="width: 180px; height: 120px; display: none;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <aside class="control-sidebar control-sidebar-dark"></aside>

    <div class="modal fade vertical-centered" id="remoteInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="d-flex justify-content-end">
            <button type="button" class="close pr-3 pt-2" data-dismiss="modal" aria-label="Close" style="font-size: 34px;">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="col card d-flex justify-content-center align-items-center">
                <div class="card" style="width: 18rem;" id="remoteSnapshot">

                </div>
            </div>
            <div class="col card d-flex justify-content-center align-items-center">
                <div class="card" style="width: 18rem;" id="remoteAddress">

                </div>
            </div>
            </div>
        </div>
        </div>
    </div>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
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
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCy_b_G7emL5aBoKkflJShoo_QEwO6afb8&libraries=geometry&loading=async"></script>
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
            var base_url = '<?= base_url() ?>';
            $('#remoteInfo').on('show.bs.modal', function (event) {
                const baseUrl = '<?php echo base_url() . 'assets_user/snapshots/'; ?>';
                var td              = $(event.relatedTarget);
                var image           = td.data('image');
                var address         = td.data('address');
                var image_text      = td.data('image_text');
                var address_text    = td.data('address_text');
                if (image) {
                    document.getElementById("remoteSnapshot").innerHTML =
                    `<img src="${baseUrl}${image}" class="card-img-top" alt="snapshot in">
                            <div class="card-body">
                            <h5 class="card-title text-center w-100">${image_text}</h5>
                            </div>`
                } else {
                    document.getElementById("remoteSnapshot").innerHTML = '';
                }
                if (address) {
                    let coordinates=address.split(',');
                    let latlng = new google.maps.LatLng(coordinates[0], coordinates[1]);
                    let geocoder = new google.maps.Geocoder();
                    geocoder.geocode({
                        'latLng': latlng
                    }, (results, status) => {
                        document.getElementById("remoteAddress").innerHTML =
                    `<iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d18820.036574374346!2d${address.split(',')[1]}!3d${address.split(',')[0]}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTXCsDE4JzU2LjgiTiAxMjDCsDMyJzQ4LjkiRQ!5e1!3m2!1sen!2sph!4v1699500707383!5m2!1sen!2sph" width="300" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            <div class="card-body">
                            <h5 class="card-title text-center w-100">${address_text}</h5>
                            <h6>${results[0].formatted_address}</h6>
                            </div>`
                    });
                } else {
                    document.getElementById("remoteAddress").innerHTML = ''
                }
                // var modal       = $(this)
                // modal.find('.modal-title').text('New message to ' + recipient)
                // modal.find('.modal-body input').val(recipient)
            })
            $("#filter_by_branch").on("change", function() {
                filter_data();
            })
            $("#filter_by_company").on("change", function() {
                filter_data();
            })
            $("#filter_by_department").on("change", function() {
                filter_data();
            })
            $("#filter_by_division").on("change", function() {
                filter_data();
            })
            $("#filter_by_clubhouse").on("change", function() {
                filter_data();
            })
            $("#filter_by_section").on("change", function() {
                filter_data();
            })
            $('#filter_by_group').on("change", function() {
                filter_data();
            })
            $("#filter_by_team").on("change", function() {
                filter_data();
            })
            $("#filter_by_line").on("change", function() {
                filter_data();
            })

            $("#filter_by_employment_type").on("change", function() {
                filter_data();
            })

            $("#date_selection").on("change", function() {
                filter_data();
            })


            function filter_data(data = "") {

                let branch = $("#filter_by_branch").find(":selected").val();
                let company = $("#filter_by_company").find(":selected").val();
                let department = $("#filter_by_department").find(":selected").val();
                let division = $("#filter_by_division").find(":selected").val();
                let clubhouse = $("#filter_by_clubhouse").find(":selected").val();
                let section = $("#filter_by_section").find(":selected").val();
                let group = $("#filter_by_group").find(":selected").val();
                let team = $("#filter_by_team").find(":selected").val();
                let line = $("#filter_by_line").find(":selected").val();
                let date = $("#date_selection").val();
                let empl_type = $("#filter_by_employment_type").find(":selected").val();

                let filterUrl = "?branch=" + branch +
                    "&dept=" + department + "&division=" + division + "&clubhouse=" + clubhouse +
                    "&section=" + section + "&date=" + date + "&group=" + group +
                    "&team=" + team + "&line=" + line + "&company=" + company + "&employementtype=" + empl_type + "&attendance_filter=" + data;
                if (document.querySelector('.filter-container').classList.contains('visible')) {
                    filterUrl = filterUrl + '&filter=1';
                }

                window.location = base_url + "attendances/daily_attendances" + filterUrl;
            }

            $('#btn_clear_filter').click(function() {
                document.location.href = "daily_attendances";
            })

            $('#allEmployee').click(function() {
                document.location.href = "daily_attendances";
            })

            $('#unAssignedBtn').click(function() {
                $unassigned_shift = 'unassigned_shift';
                filter_data($unassigned_shift);
            });

            $('#no_in').click(function() {
                $no_in = 'no_in';
                filter_data($no_in);
            });

            $('#no_out').click(function() {
                $no_out = 'no_out';
                filter_data($no_out);
            });

            $('#on_leave').click(function() {
                $on_leave = 'on_leave';
                filter_data($on_leave);
            });

            $('#with_tardiness').click(function() {
                $with_tardiness = 'with_tardiness';
                filter_data($with_tardiness);
            });

            $('#with_undertime').click(function() {
                $with_undertime = 'with_undertime';
                filter_data($with_undertime);
            });

            $('#remote_count').click(function() {
                $remote_count = 'remote_count';
                filter_data($remote_count);
            });

            $('#rest_count').click(function() {
                $rest_count = 'rest_count';
                filter_data($rest_count);
            });
        });
    </script>
    <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> -->
    <script src="<?= base_url() ?>assets_system/js/xlsx.full.min.js"></script>
    <script>
        document.getElementById("btn_export").addEventListener('click', function() {

            var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));

            var sheetName = wb.SheetNames[0];
            var sheet = wb.Sheets[sheetName];
           console.log(sheet);
            for (var cellAddress in sheet) {
                if (sheet.hasOwnProperty(cellAddress)) {

                    var cell = sheet[cellAddress];

                    if ((cellAddress.startsWith('A') || cellAddress.startsWith('B') || cellAddress.startsWith('C')) && cell.t !== 's') {
                        cell.t = 's';
                        cell.v = String(cell.v);
                    }

                    if (cell.t === 'n' && cellAddress !== 'A1' && cellAddress !== 'A2' && cellAddress !== 'A3') {
                        cell.z = 'hh:mm';
                    }


                    // var cell = sheet[cellAddress];
                    if (cellAddress.startsWith('A') && /\d/.test(cell.v) && cell.t !== 'n') {
                        if (/^[a-zA-Z]+[0-9]+$/.test(cell.v)) {
                            // Do nothing or handle the special case for cells with a combination of letters and numbers
                        } else {
                            // Convert other cells to numbers
                            cell.t = 'n'; 
                            cell.v = +cell.v; 
                            
                        }
                    }
                }
            }

            XLSX.writeFile(wb, "Daily Attendance.xlsx");
        });
    </script>

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