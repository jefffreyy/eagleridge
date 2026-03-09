<html>
<?php $this->load->view('templates/css_link'); ?>
<?php
$search = $this->input->get('search');
$search = str_replace("_", " ", $search ?? '');


$current_page = $PAGE;
$next_page    = $PAGE + 1;
$prev_page    = $PAGE - 1;
$last_page    = $PAGES_COUNT;
$row          = $ROW;
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
?>

<style>
    .active-page {
        background-color: #007bff !important;
        color: white !important;
        cursor: 'default';
    }

    .img-circle_sm {
        border-radius: 50% !important;
        width: 30px !important;
        height: 30px !important;
        object-fit: scale-down;
        background-color: #fff;
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
    <div class="content-wrapper ">
        <div class="container-fluid p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>administrators">Administrator</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Access Management
                    </li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-md-6">
                    <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'administrators'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Access Management<h1>
                </div>

                <div class="col-md-6  button-title d-flex justify-content-end">
                    <a class="btn btn-primary" href="<?= base_url() ?>administrators/employee_update"><img style="width: 20px; height: 20px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/solid-bolt-pen_xs.svg') ?>" alt="" />&nbsp;Quick Edit</a>

                </div>
            </div>
            <hr>
            <?php
            (isset($_GET['dept']) ? $dept         = $_GET['dept'] : $dept = "");
            (isset($_GET['company']) ? $company   = $_GET['company'] : $company = "");
            (isset($_GET['sec']) ? $sec           = $_GET['sec'] : $sec = "");
            (isset($_GET['group']) ? $group       = $_GET['group'] : $group = "");
            (isset($_GET['line']) ? $line         = $_GET['line'] : $line = "");
            (isset($_GET['team']) ? $team         = $_GET['team'] : $team = "");
            (isset($_GET['clubhouse']) ? $clubhouse = $_GET['clubhouse'] : $clubhouse = "");
            (isset($_GET['division']) ? $division = $_GET['division'] : $division = "");
            (isset($_GET['branch']) ? $branch     = $_GET['branch'] : $branch = "");
            (isset($_GET['status']) ? $status     = $_GET['status'] : $status = "");
            (isset($_GET['all']) ? $all           = $_GET['all'] : $all = "");
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


            <div class=" filter-container">
                <div class="card col-12 row d-flex">
                    <div class="m-2">
                        <div class=" d-flex row justify-content-center justify-content-lg-start">

                            <div class="col-11 col-md-2 " <?php echo ($DISP_VIEW_COMPANY ? "" : "hidden") ?>>
                                <p class="mb-1 text-secondary ">Company</p>
                                <select id="filter_by_company" class="form-control filter_by">
                                    <?php
                                    if ($C_COMPANY) {
                                    ?>
                                        <option value="" <?php foreach ($C_COMPANY as $C_COMPANY_ROW_1) {
                                                                if ($C_COMPANY_ROW_1->name == '') {
                                                                    echo 'selected';
                                                                }
                                                            } ?>>All Company</option>
                                        <?php
                                        foreach ($C_COMPANY as $C_COMPANY_ROW) {
                                            if ($C_COMPANY_ROW->name != '') {
                                        ?>
                                                <option value="<?= $C_COMPANY_ROW->id ?>" <?= ($C_COMPANY_ROW->id == $company) ? 'Selected' : ''; ?>><?= $C_COMPANY_ROW->name ?></option>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-12 col-md-2 " <?php echo ($DISP_VIEW_BRANCH ? "" : "hidden") ?>>
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

                            <div class="col-12 col-md-2 " <?php echo ($DISP_VIEW_DEPARTMENT ? "" : "hidden") ?>>
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

                            <div class="col-12 col-md-2 " <?php echo ($DISP_VIEW_DIVISION ? "" : "hidden") ?>>
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

                            <div class="col-12 col-md-2 " <?php echo ($DISP_VIEW_SECTION ? "" : "hidden") ?>>
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

                            <div class="col-12 col-md-2 " <?php echo ($DISP_VIEW_GROUP ? "" : "hidden") ?>>
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

                            <div class="col-12 col-md-2 " <?php echo ($DISP_VIEW_TEAM ? "" : "hidden") ?>>
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

                            <div class="col-12 col-md-2 " <?php echo ($DISP_VIEW_LINE ? "" : "hidden") ?>>
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

                            <!-- <div class="col-12 col-md-2">
                                <p class="mb-1 text-secondary ">Action</p>
                                <a href="<?= base_url(); ?>administrators/access" class="col btn btn-secondary mx-1">Clear Filter</a>
                            </div> -->
                        </div>

                    </div>
                </div>
            </div>


            <div class="row mb-1">
            </div>

            <div class="card border-0 mt-4" style="padding: 0px; margin: 0px">

                <div class="p-2 ">

                    <div>
                        <div class=''>

                            <div class='row'>

                                <div class='col-md-12 col-xl-12'>

                                    <div class="d-flex row align-items-end">

                                        <div class="ml-1 row  col-12 col-xl-8 justify-content-center justify-content-lg-start align-items-center">
                                            <span class="col-10 mb-1 p-0 text-secondary">Search Employee</span>
                                            <select id="search_select" class="px-1 col-12 col-md-3 employee_select form-control  ">
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
                                            <a href="<?= base_url('administrators/access') ?>" id="btn_clear_filter" class="mt-1 mt-lg-0 btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="">&nbsp;Clear</a>

                                        </div>
                                    </div>

                                    <div class="">
                                        <div class='row mb-1 mt-2'>
                                            <div class="col-12 col-xl-4">
                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item">
                                                        <a class="nav-link head-tab <?= $TAB == 'Active' ? 'active' : '' ?> " id="tab-Active" style='cursor:pointer'>Active<span class="ml-2 badge badge-pill badge-secondary"><?= $ACTIVES ?></span></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link head-tab <?= $TAB == 'Inactive' ? 'active' : '' ?>" id="tab-Inactive" style='cursor:pointer'>Inactive<span class="ml-2 badge badge-pill badge-secondary"><?= $INACTIVES ?></span></a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class='col-12 col-xl-8 row d-none d-lg-flex justify-content-center justify-content-lg-end align-items-center'>
                                                <div class="d-flex align-items-center col-xl-9 row">
                                                    <div class='col-12 col-xl-6 d-flex justify-content-center justify-content-lg-end'>
                                                        <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                                                    </div>
                                                    <div class="col-12 col-xl-6 d-flex justify-content-center">
                                                        <ul class="d-inline pagination m-0 p-0 ">
                                                            <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB&all=$ALL'"; ?>>
                                                                    < </a>
                                                            </li>
                                                            <li><a href="?page=1&row=<?= $row ?>&tab=<?= $TAB ?>&all=<?= $ALL ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                                                            <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                                                            <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>&all=<?= $ALL ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                                                            <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                                                            <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>&all=<?= $ALL ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                                                            <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                                                            <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&tab=<?= $TAB ?>&all=<?= $ALL ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                                                            <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row&tab=$TAB&all=$ALL'"; ?>>> </a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-xl-1 col-2-xl d-none d-lg-flex justify-content-end align-items-center">
                                                    <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                                                    <select id="row_dropdown" class="custom-select m-0" style="width: auto;">
                                                        <option value="10" <?= $ROW == 10 ? 'selected' : '' ?>> 10 </option>
                                                        <option value="25" <?= $ROW == 25 ? 'selected' : '' ?>> 25 </option>
                                                        <option value="50" <?= $ROW == 50 ? 'selected' : '' ?>> 50 </option>
                                                        <option value="100" <?= $ROW == 100 ? 'selected' : '' ?>> 100 </option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover" id="employee_tbl" style="margin-bottom: 0px; padding-bottom: 0px;">
                                                        <thead>
                                                            <th>EMPLOYEE&nbsp;ID</th>
                                                            <th style='min-width:200px'>FULL&nbsp;NAME</th>
                                                            <th>POSITION</th>
                                                            <th>USER&nbsp;ACCESS</th>
                                                            <th>REMOTE&nbsp;ATTENDANCE</th>
                                                            <th>STATUS</th>
                                                            <th>ACCESSIBILTY STATUS </th>
                                                            <th>LAST LOGGED IN</th>
                                                            <th class="text-center">ACTION</th>
                                                        </thead>
                                                        <tbody id="table_container">
                                                            <?php
                                                            if ($C_USERS) {
                                                                foreach ($C_USERS as $C_USERS_ROW) {
                                                                    $name = $C_USERS_ROW->col_last_name;
                                                                    if (!empty($C_USERS_ROW->col_suffix)) $name = $name . ' ' . $C_USERS_ROW->col_suffix;
                                                                    if (!empty($C_USERS_ROW->col_frst_name)) $name = $name . ', ' . $C_USERS_ROW->col_frst_name;
                                                                    if (!empty($C_USERS_ROW->col_midl_name)) $name = $name . ' ' . $C_USERS_ROW->col_midl_name[0] . '.';
                                                                    // if (!empty($C_USERS_ROW->col_midl_name)) {
                                                                    //     $midl_ini = $C_USERS_ROW->col_midl_name[0] . '.';
                                                                    // } else {
                                                                    //     $midl_ini = '';
                                                                    // } 
                                                            ?>
                                                                    <tr class="empl_row" empl_id="<?= $C_USERS_ROW->id ?>" reset_pass="<?= ucwords($C_USERS_ROW->col_last_name) . '.' . date('Y', strtotime($C_USERS_ROW->col_birt_date)) ?>">
                                                                        <td><?= $C_USERS_ROW->col_empl_cmid ?></td>
                                                                        <td><a href="<?= base_url() ?>employees/personal?id=<?= $C_USERS_ROW->id ?>">
                                                                                <img class="rounded-circle avatar img-circle_sm elevation-2" src="<?= $this->system_functions->profileImageCheck('assets_user/user_profile/', $C_USERS_ROW->col_imag_path) ?>">
                                                                                &nbsp;&nbsp;<?= $name
                                                                                            // $C_USERS_ROW->col_last_name . ', ' . $C_USERS_ROW->col_frst_name . ' ' . $midl_ini 
                                                                                            ?></a>
                                                                        </td>
                                                                        <td><?= convert_id2name($C_POSITIONS, $C_USERS_ROW->col_empl_posi) ?></td>
                                                                        <td>
                                                                            <select onchange="saveFunction(event, 'userAccess', <?= $C_USERS_ROW->id ?>)" name="user_access" id="user_access" class="form-control">
                                                                                <?php foreach ($C_USER_ACCESS as $C_USER_ACCESS_ROW) { ?>
                                                                                    <option value="<?= $C_USER_ACCESS_ROW->id ?>" <?php echo $C_USERS_ROW->col_user_access == $C_USER_ACCESS_ROW->id ? 'selected' : "" ?>>
                                                                                        <?= $C_USER_ACCESS_ROW->user_access ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select onchange="saveFunction(event, 'remoteAttendance', <?= $C_USERS_ROW->id ?>)" name="remote_attendance" id="remote_attendance" class="form-control">
                                                                                <option value="0" <?php if ($C_USERS_ROW->remote_att == 0) {
                                                                                                        echo 'selected';
                                                                                                    } ?>>Disabled</option>
                                                                                <option value="1" <?php if ($C_USERS_ROW->remote_att == 1) {
                                                                                                        echo 'selected';
                                                                                                    } ?>>Enabled</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select onchange="saveFunction(event, 'userStatus', <?= $C_USERS_ROW->id ?>)" name="user_status" id="user_status<?= $C_USERS_ROW->id ?>" class=" form-control"> <!-- user_status -->
                                                                                <option value="1" <?php if ($C_USERS_ROW->disabled == 1) {
                                                                                                        echo 'selected';
                                                                                                    } ?>>Inactive</option>
                                                                                <option value="0" <?php if ($C_USERS_ROW->disabled == 0) {
                                                                                                        echo 'selected';
                                                                                                    } ?>>Active</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <?= $C_USERS_ROW->password_attempt >= 10 ? "<p class='text-danger text-md'>Locked</p>" : "<p class='text-success text-md'>Good</p>" ?>
                                                                        </td>
                                                                        <td>
                                                                            <?= ($C_USERS_ROW->last_logged_in  !== null && strtotime($C_USERS_ROW->last_logged_in) !== false) ? (new DateTime($C_USERS_ROW->last_logged_in))->format('d/m/Y g:iA') : '' ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <a class="btn-sm btn-primary  btn_reset_pass text-light" style='cursor:pointer' id="reset_password">Reset Password</a>
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                            } else { ?>

                                                                <tr class="table-active">
                                                                    <td colspan="9">
                                                                        <center>No Records</center>
                                                                    </td>
                                                                </tr>
                                                            <?php }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class='col-12 col-lg-7 row d-flex d-lg-none justify-content-center justify-content-lg-end align-items-center my-2'>
                                                    <div class='col-12 col-lg-7 d-flex justify-content-center justify-content-lg-end'>
                                                        <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                                                    </div>
                                                    <div class="col-12 col-lg-3 d-flex justify-content-center justify-content-lg-end">
                                                        <ul class="d-inline pagination m-0 p-0 ">
                                                            <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB&all=$ALL'"; ?>>
                                                                    < </a>
                                                            </li>
                                                            <li><a href="?page=1&row=<?= $row ?>&tab=<?= $TAB ?>&all=<?= $ALL ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                                                            <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                                                            <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>&all=<?= $ALL ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                                                            <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                                                            <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>&all=<?= $ALL ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                                                            <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                                                            <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&tab=<?= $TAB ?>&all=<?= $ALL ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                                                            <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row&tab=$TAB&all=$ALL'"; ?>>> </a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-1  d-flex d-lg-none justify-content-center align-items-center my-2">
                                                    <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                                                    <select id="row_dropdown" class="custom-select m-0" style="width: auto;">
                                                        <option value="10" <?= $ROW == 10 ? 'selected' : '' ?>> 10 </option>
                                                        <option value="25" <?= $ROW == 25 ? 'selected' : '' ?>> 25 </option>
                                                        <option value="50" <?= $ROW == 50 ? 'selected' : '' ?>> 50 </option>
                                                        <option value="100" <?= $ROW == 100 ? 'selected' : '' ?>> 100 </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <aside class="control-sidebar control-sidebar-dark"></aside>
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

                        <div class="modal fade" id="modalPleaseWait" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered d-flex justify-content-center" style="font-size: 1.3rem">
                                <button class="btn btn-primary" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                        </div>

                        <script>
                            $(function() {
                                $('[data-toggle="tooltip"]').tooltip()
                            })

                            function saveFunction(e, field, userId) {

                                console.log('field', field);
                                if (field === 'userStatus' ||
                                    field === 'remoteAttendance' ||
                                    field === 'userAccess'
                                ) {
                                    let apiUrl = '<?= base_url() ?>login/session_expired';
                                    const dataToSend = {
                                        userId,
                                        value: e.target.value
                                    };
                                    if (field === 'userStatus') {
                                        apiUrl = '<?= base_url() ?>administrators/user_activation_api';
                                    }
                                    if (field === 'remoteAttendance') {
                                        apiUrl = '<?= base_url() ?>administrators/remote_attendance_api';
                                    }
                                    if (field === 'userAccess') {
                                        apiUrl = '<?= base_url() ?>administrators/user_access_api';
                                    }
                                    fetch(apiUrl, {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                            },
                                            body: JSON.stringify(dataToSend),
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data?.messageSuccess) {
                                                location.reload();
                                            }
                                            if (data?.messageError) {

                                                $(document).Toasts('create', {
                                                    class: 'bg-warning toast_width',
                                                    title: 'Warning!',
                                                    subtitle: 'close',
                                                    body: data?.messageError,
                                                })

                                            }
                                            console.log('data', data);
                                            console.log('field', field);

                                        })
                                        .catch(error => {

                                            $(document).Toasts('create', {
                                                class: 'bg-warning toast_width',
                                                title: 'Warning!',
                                                subtitle: 'close',
                                                body: 'error',
                                            })

                                            console.error('Error:', error);
                                        });
                                }
                            }
                        </script>

                        <?php $this->load->view('templates/jquery_link'); ?>

                        <?php
                        if ($this->session->flashdata('SUCC')) {
                        ?>
                            <script>
                                $(document).Toasts('create', {
                                    class: 'bg-success toast_width',
                                    title: 'Success!',
                                    subtitle: 'close',
                                    body: '<?php echo $this->session->flashdata('SUCC'); ?>'
                                })
                            </script>
                        <?php
                        }
                        ?>
                        <?php
                        if ($this->session->flashdata('ERR')) {
                        ?>
                            <script>
                                $(document).Toasts('create', {
                                    class: 'bg-warning toast_width',
                                    title: 'Warning!',
                                    subtitle: 'close',
                                    body: '<?php echo $this->session->flashdata('ERR'); ?>'
                                })
                            </script>
                        <?php
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
                            if (!$name) {
                                $name = "";
                            }
                            return $name;
                        }
                        ?>
                        <script>
                            $(document).ready(function() {
                                $('#filter_by_branch').select2();
                                $('#filter_by_department').select2();
                                $('#filter_by_division').select2();
                                $('#filter_by_clubhouse').select2();
                                $('#filter_by_section').select2();
                                $('#filter_by_group').select2();
                                $('#filter_by_team').select2();
                                $('#filter_by_line').select2();

                                $('select.filter_by').on('change', function() {
                                    var filter_dept = $("#filter_by_department").val();
                                    var filter_sec = $("#filter_by_section").val();
                                    var filter_group = $("#filter_by_group").val();
                                    var filter_line = $("#filter_by_line").val();
                                    var filter_team = $("#filter_by_team").val();
                                    var filter_branch = $("#filter_by_branch").val();
                                    var filter_division = $("#filter_by_division").val();
                                    var filter_by_clubhouse = $("#filter_by_clubhouse").val();
                                    var filter_status = $("#filter_by_status").val();
                                    console.log(filter_dept)
                                    document.location.href = "access?page=<?= $current_page ?>&row=<?= $row ?>" + "&tab=<?= $TAB ?>" + "&dept=" + filter_dept + '&sec=' + filter_sec + '&group=' + filter_group + '&line=' + filter_line + '&clubhouse=' + filter_by_clubhouse + '&division=' + filter_division;
                                })

                                $('a.page-link').on('click', function() {
                                    paginate($(this).text());
                                })
                                $("#prev-page").on('click', function() {
                                    let activePage = $('a.active-page').text();
                                    if (parseInt(activePage) > 1) {
                                        paginate(parseInt(activePage) - 1);
                                    }
                                })
                                $("#next-page").on('click', function() {
                                    let maxPage = <?= $PAGES_COUNT - 1 ?>;
                                    let activePage = $('a.active-page').text();
                                    if (parseInt(activePage) < parseInt(maxPage) && parseInt(maxPage) > 1) {
                                        let nextPage = parseInt(activePage) + 1;
                                        paginate(nextPage);
                                    }
                                })
                                $('#tab-Inactive').on('click', function() {
                                    let row = $("#row_dropdown").val();
                                    window.location = "<?= base_url() ?>administrators/access?" + "page=" + 1 + "&row=" + row + '&tab=Inactive&all=<?= $ALL ?>';
                                })
                                $('#tab-Active').on('click', function() {
                                    let row = $("#row_dropdown").val();
                                    window.location = "<?= base_url() ?>administrators/access?" + "page=" + 1 + "&row=" + row + '&tab=Active&all=<?= $ALL ?>';
                                })
                                $('#row_dropdown').on("change", function() {
                                    let row = $("#row_dropdown").val();
                                    window.location = "<?= base_url() ?>administrators/access?" + "page=" + 1 + "&row=" + row + '&tab=<?= $TAB ?>&all=<?= $ALL ?>';
                                })

                                function paginate(page = "<?= $PAGE ?>") {
                                    let row = $("#row_dropdown").val();
                                    window.location = "<?= base_url() ?>administrators/access?" + "page=" + page + "&row=" + row;
                                }
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
                                var url_reset_empl_password = '<?= base_url() ?>administrators/reset_empl_password';
                                var url_update_empl_user_access = '<?= base_url() ?>administrators/update_empl_user_access';
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

                                $('#filter_employee').on('keyup', function() {
                                    empl_tbl.search(this.value).draw();
                                });

                                $("#clear_search_btn").on("click", function() {
                                    var url = window.location.href.split("?")[0];
                                    window.location = url
                                });

                                $("#search_btn").on("click", function() {
                                    search();
                                });

                                $("#search_data").on("keypress", function(e) {
                                    if (e.which === 13) {
                                        search();
                                    }
                                });

                                // function search() {
                                //     var optionValue = $('#search_data').val();
                                //     var url = window.location.href.split("?")[0];
                                //     if (window.location.href.indexOf("?") > 0) {
                                //         window.location = url + "?page=1&row=<?= $row ?>&tab=<?= $TAB ?>&all=" + optionValue.replace(/\s/g, '_');
                                //     } else {
                                //         window.location = url + "?page=1&row=<?= $row ?>&tab=<?= $TAB ?>&all=" + optionValue.replace(/\s/g, '_');
                                //     }
                                // }

                                function display_filtered_empl(department, section, line, group, status) {
                                    $('#loader_gif').show();
                                    $('#table_container').html('');
                                    get_filter_data(url_get_filter_data, department, line, group, section, status).then(function(data) {
                                        if (data.length > 0) {
                                            Array.from(data).forEach(function(x) {
                                                var staffIsSelected = '';
                                                var HRIsSelected = '';
                                                var AccountingIsSelected = '';
                                                var AdminIsSelected = '';
                                                var IsRemote = '';
                                                var user_image = '';
                                                if (x.col_imag_path) {
                                                    user_image = base_url + 'user_images/' + x.col_imag_path;
                                                } else {
                                                    user_image = base_url + 'user_images/default_profile_img3.png';
                                                }
                                                var fullname = '';
                                                if ((x.col_frst_name) && (x.col_last_name)) {
                                                    if (x.col_midl_name) {
                                                        var middlename = capitalizeFirstLetter(x.col_midl_name);
                                                        fullname = x.col_last_name + ', ' + x.col_frst_name + ' ' + middlename + '.';
                                                    } else {
                                                        fullname = x.col_last_name + ', ' + x.col_frst_name;
                                                    }
                                                }
                                                $('#loader_gif').hide();
                                                if (x.col_user_access == 0) {
                                                    staffIsSelected = 'selected';
                                                } else if (x.col_user_access == 2) {
                                                    HRIsSelected = 'selected';
                                                } else if (x.col_user_access == 3) {
                                                    AccountingIsSelected = 'selected';
                                                } else if (x.col_user_access == 4) {
                                                    AdminIsSelected = 'selected';
                                                }
                                                if (x.remote_att == 1) {
                                                    IsRemote = 'selected';
                                                }
                                                $('#table_container').append(`
                                <tr class="empl_row" empl_id="` + x.id + `">
                                    <td>` + x.col_empl_cmid + `</td>
                                    <td><a href = "<?= base_url() ?>employees/personal?id=` + x.id + `">
                                        <img class="rounded-circle avatar " width="35" height="35" src="` + user_image + `">&nbsp;&nbsp;` + fullname + `</a>
                                    </td>
                                    <td>` + x.col_empl_posi + `</td>
                                    <td>
                                        <select name="user_access" id="user_access" class="form-control">
                                            <option value="0" ` + staffIsSelected + `>STAFF</option>
                                            <option value="2" ` + HRIsSelected + `>HR</option>
                                            <option value="3" ` + AccountingIsSelected + `>ACCOUNTING</option>
                                            <option value="4" ` + AdminIsSelected + `>ADMIN</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="user_access" id="user_access" class="form-control">
                                            <option value="0">Disabled</option>
                                            <option value="1" ` + IsRemote + `>Enabled</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-primary btn_reset_pass">Reset Password</a>
                                    </td>
                                </tr>
                            `);
                                            })
                                        } else {
                                            $('#loader_gif').hide();
                                            $('#table_container').append(`
                                <td colspan="7">No Employees Detected</td>
                        `);
                                        }
                                    })
                                }

                                $('#filter_by_department').change(function() {
                                    department = $(this).val();
                                    section = $('#filter_by_section').val();
                                    line = $('#filter_by_line').val();
                                    group = $('#filter_by_group').val();
                                    status = $('#filter_by_status').val();
                                    display_filtered_empl(department, section, line, group, 0);
                                    get_filter_data(url_get_filter_data_section, department, line, group, section, 0).then(function(data) {
                                        if (!section) {
                                            $('#filter_by_section').html('');
                                            $('#filter_by_section').append(`<option value="">All Sections</option>`);
                                        }
                                        Array.from(data).forEach(function(x) {
                                            if (x.col_empl_sect != '') {
                                                $('#filter_by_section').append(`
                                <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                            `);
                                            }
                                        })
                                    })
                                    get_filter_data(url_get_filter_data_group, department, line, group, section, 0).then(function(data) {
                                        if (!group) {
                                            $('#filter_by_group').html('');
                                            $('#filter_by_group').append(`<option value="">All Groups</option>`);
                                        }
                                        Array.from(data).forEach(function(x) {
                                            if (x.col_empl_group != '') {
                                                $('#filter_by_group').append(`
                                <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                            `);
                                            }
                                        })
                                    })
                                    get_filter_data(url_get_filter_data_line, department, line, group, section, 0).then(function(data) {
                                        if (!line) {
                                            $('#filter_by_line').html('');
                                            $('#filter_by_line').append(`<option value="">All Lines</option>`);
                                        }
                                        Array.from(data).forEach(function(x) {
                                            if (x.col_empl_line != '') {
                                                $('#filter_by_line').append(`
                                <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                            `);
                                            }
                                        })
                                    })
                                })

                                $('#filter_by_section').change(function() {
                                    department = $('#filter_by_department').val();
                                    section = $(this).val();
                                    line = $('#filter_by_line').val();
                                    group = $('#filter_by_group').val();
                                    status = $('#filter_by_status').val();
                                    display_filtered_empl(department, section, line, group, 0);
                                    get_filter_data(url_get_filter_data_department, department, line, group, section, 0).then(function(data) {
                                        if (!department) {
                                            $('#filter_by_department').html('');
                                            $('#filter_by_department').append(`<option value="">All Departments</option>`);
                                        }
                                        Array.from(data).forEach(function(x) {
                                            if (x.col_empl_dept != '') {
                                                $('#filter_by_department').append(`
                                <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                            `);
                                            }
                                        })
                                    })
                                    get_filter_data(url_get_filter_data_group, department, line, group, section, 0).then(function(data) {
                                        if (!group) {
                                            $('#filter_by_group').html('');
                                            $('#filter_by_group').append(`<option value="">All Groups</option>`);
                                        }
                                        Array.from(data).forEach(function(x) {
                                            if (x.col_empl_group != '') {
                                                $('#filter_by_group').append(`
                                <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                            `);
                                            }
                                        })
                                    })
                                    get_filter_data(url_get_filter_data_line, department, line, group, section, 0).then(function(data) {
                                        if (!line) {
                                            $('#filter_by_line').html('');
                                            $('#filter_by_line').append(`<option value="">All Lines</option>`);
                                        }
                                        Array.from(data).forEach(function(x) {
                                            if (x.col_empl_line != '') {
                                                $('#filter_by_line').append(`
                                <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                            `);
                                            }
                                        })
                                    })
                                })

                                $('#filter_by_group').change(function() {
                                    department = $('#filter_by_department').val();
                                    section = $('#filter_by_section').val();
                                    line = $('#filter_by_line').val();
                                    group = $(this).val();
                                    status = $('#filter_by_status').val();
                                    display_filtered_empl(department, section, line, group, 0);
                                    get_filter_data(url_get_filter_data_department, department, line, group, section, 0).then(function(data) {
                                        if (!department) {
                                            $('#filter_by_department').html('');
                                            $('#filter_by_department').append(`<option value="">All Departments</option>`);
                                        }
                                        Array.from(data).forEach(function(x) {
                                            if (x.col_empl_dept != '') {
                                                $('#filter_by_department').append(`
                                <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                            `);
                                            }
                                        })
                                    })
                                    get_filter_data(url_get_filter_data_section, department, line, group, section, 0).then(function(data) {
                                        if (!section) {
                                            $('#filter_by_section').html('');
                                            $('#filter_by_section').append(`<option value="">All Sections</option>`);
                                        }
                                        Array.from(data).forEach(function(x) {
                                            if (x.col_empl_sect != '') {
                                                $('#filter_by_section').append(`
                                <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                            `);
                                            }
                                        })
                                    })
                                    get_filter_data(url_get_filter_data_line, department, line, group, section, 0).then(function(data) {
                                        if (!line) {
                                            $('#filter_by_line').html('');
                                            $('#filter_by_line').append(`<option value="">All Lines</option>`);
                                        }
                                        Array.from(data).forEach(function(x) {
                                            if (x.col_empl_line != '') {
                                                $('#filter_by_line').append(`
                                <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                            `);
                                            }
                                        })
                                    })
                                })

                                $('#filter_by_line').change(function() {
                                    department = $('#filter_by_department').val();
                                    section = $('#filter_by_section').val();
                                    line = $(this).val();
                                    group = $('#filter_by_group').val();
                                    status = $('#filter_by_status').val();
                                    display_filtered_empl(department, section, line, group, 0);
                                    get_filter_data(url_get_filter_data_department, department, line, group, section, 0).then(function(data) {
                                        if (!department) {
                                            $('#filter_by_department').html('');
                                            $('#filter_by_department').append(`<option value="">All Departments</option>`);
                                        }
                                        Array.from(data).forEach(function(x) {
                                            if (x.col_empl_dept != '') {
                                                $('#filter_by_department').append(`
                                <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                            `);
                                            }
                                        })
                                    })
                                    get_filter_data(url_get_filter_data_section, department, line, group, section, 0).then(function(data) {
                                        if (!section) {
                                            $('#filter_by_section').html('');
                                            $('#filter_by_section').append(`<option value="">All Sections</option>`);
                                        }
                                        Array.from(data).forEach(function(x) {
                                            if (x.col_empl_sect != '') {
                                                $('#filter_by_section').append(`
                                <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                            `);
                                            }
                                        })
                                    })
                                    get_filter_data(url_get_filter_data_group, department, line, group, section, 0).then(function(data) {
                                        if (!group) {
                                            $('#filter_by_group').html('');
                                            $('#filter_by_group').append(`<option value="">All Groups</option>`);
                                        }
                                        Array.from(data).forEach(function(x) {
                                            if (x.col_empl_group != '') {
                                                $('#filter_by_group').append(`
                                <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                            `);
                                            }
                                        })
                                    })
                                })

                                $('#btn_clear_filter').click(function() {
                                    $('#loader_gif').show();
                                    $('#filter_by_group').val('');
                                    $('#filter_by_section').val('');
                                    $('#filter_by_department').val('');
                                    $('#filter_by_line').val('');
                                    $('#table_container').html('');
                                    get_all_employee_data(url_get_all_empl_data).then(function(data) {
                                        Array.from(data).forEach(function(x) {
                                            var staffIsSelected = '';
                                            var HRIsSelected = '';
                                            var AccountingIsSelected = '';
                                            var AdminIsSelected = '';
                                            var IsRemote = '';
                                            var user_image = '';
                                            if (x.col_imag_path) {
                                                user_image = base_url + 'user_images/' + x.col_imag_path;
                                            } else {
                                                user_image = base_url + 'user_images/default_profile_img3.png';
                                            }
                                            var fullname = '';
                                            if ((x.col_frst_name) && (x.col_last_name)) {
                                                if (x.col_midl_name) {
                                                    var middlename = capitalizeFirstLetter(x.col_midl_name);
                                                    fullname = x.col_last_name + ', ' + x.col_frst_name + ' ' + middlename + '.';
                                                } else {
                                                    fullname = x.col_last_name + ', ' + x.col_frst_name;
                                                }
                                            }
                                            $('#loader_gif').hide();
                                            if (x.col_user_access == 0) {
                                                staffIsSelected = 'selected';
                                            } else if (x.col_user_access == 2) {
                                                HRIsSelected = 'selected';
                                            } else if (x.col_user_access == 3) {
                                                AccountingIsSelected = 'selected';
                                            } else if (x.col_user_access == 4) {
                                                AdminIsSelected = 'selected';
                                            }
                                            if (x.remote_att == 1) {
                                                IsRemote = 'selected';
                                            }
                                            $('#table_container').append(`
                            <tr class="empl_row" empl_id="` + x.id + `">
                                <td>` + x.col_empl_cmid + `</td>
                                <td><a href = "<?= base_url() ?>employees/personal?id=` + x.id + `">
                                    <img class="rounded-circle avatar " width="35" height="35" src="` + user_image + `">&nbsp;&nbsp;` + fullname + `</a>
                                </td>
                                <td>` + x.col_empl_posi + `</td>
                                <td>
                                    <select name="user_access" id="user_access" class="form-control">
                                        <option value="0" ` + staffIsSelected + `>STAFF</option>
                                        <option value="2" ` + HRIsSelected + `>HR</option>
                                        <option value="3" ` + AccountingIsSelected + `>ACCOUNTING</option>
                                        <option value="4" ` + AdminIsSelected + `>ADMIN</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="user_access" id="user_access" class="form-control">
                                        <option value="0">Disabled</option>
                                        <option value="1" ` + IsRemote + `>Enabled</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-primary btn_reset_pass">Reset Password</a>
                                </td>
                            </tr>
                        `);
                                        })
                                    })
                                    get_all_filter_data(url_get_all_filter_data).then(function(data) {
                                        $('#filter_by_group').html('');
                                        $('#filter_by_section').html('');
                                        $('#filter_by_department').html('');
                                        $('#filter_by_line').html('');
                                        $('#filter_by_group').append('<option value="">All Groups</option>');
                                        $('#filter_by_section').append('<option value="">All Sections</option>');
                                        $('#filter_by_department').append('<option value="">All Departments</option>');
                                        $('#filter_by_line').append('<option value="">All Lines</option>');
                                        Array.from(data.DISP_Group).forEach(function(x) {
                                            if (x.col_empl_group != '') {
                                                $('#filter_by_group').append(`
                                <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                            `)
                                            }
                                        })
                                        Array.from(data.DISP_DISTINCT_SECTION).forEach(function(x) {
                                            if (x.col_empl_sect != '') {
                                                $('#filter_by_section').append(`
                                <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                            `)
                                            }
                                        })
                                        Array.from(data.DISP_DISTINCT_DEPARTMENT).forEach(function(x) {
                                            if (x.col_empl_dept != '') {
                                                $('#filter_by_department').append(`
                                <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                            `)
                                            }
                                        })
                                        Array.from(data.DISP_Line).forEach(function(x) {
                                            if (x.col_empl_line != '') {
                                                $('#filter_by_line').append(`
                                <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                            `)
                                            }
                                        })
                                    })
                                })

                                function save_user_access() {

                                    Array.from($('.empl_row')).forEach(function(e) {
                                        var td_user_access_parent = e.childNodes[7];
                                        var user_access_dropdown = td_user_access_parent.childNodes[1];
                                        var user_access_id = $(user_access_dropdown).val();

                                        var td_remote_attendance = e.childNodes[9];
                                        var remote_attendance_dropdown = td_remote_attendance.childNodes[1];
                                        var remote_attendance = $(remote_attendance_dropdown).val();
                                        var td_disable = e.childNodes[11];
                                        var disable_dropdown = td_disable.childNodes[1];
                                        var disable = $(disable_dropdown).val();
                                        var empl_id = $(e).attr('empl_id');

                                        update_empl_user_access(url_update_empl_user_access, empl_id, user_access_id, remote_attendance, disable).then(function(data) {
                                            console.log(empl_id + ' - ' + data + ' disable = ' + disable);
                                        })
                                    })
                                }
                                $('#save_user_access').click(function() {
                                    save_user_access();
                                    $(document).Toasts('create', {
                                        class: 'bg-success toast_width',
                                        title: 'Success',
                                        subtitle: 'close',
                                        body: 'Access Management Updated Successfully'
                                    })
                                })

                                $('.btn_reset_pass').click(function() {
                                    var parent_tr = $(this).parent().parent();
                                    var empl_id = $(parent_tr).attr('empl_id');
                                    var reset_pass = $(parent_tr).attr('reset_pass');
                                    Swal.fire({
                                        title: 'Reset Password for this Employee?',
                                        text: ' New Password: ' + reset_pass,
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Reset'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            console.log(empl_id + '\n' + reset_pass);
                                            reset_empl_password(url_reset_empl_password, empl_id, reset_pass).then(function(data) {
                                                console.log(data)
                                                if (data === 1) {
                                                    $(document).Toasts('create', {
                                                        class: 'bg-success toast_width',
                                                        title: 'Success',
                                                        subtitle: 'close',
                                                        body: 'Password has been reset successfully!'
                                                    })
                                                } else {
                                                    $(document).Toasts('create', {
                                                        class: 'bg-danger toast_width',
                                                        title: 'Fail',
                                                        subtitle: 'close',
                                                        body: 'Unable to reset password! Please try again'
                                                    })
                                                }
                                            })

                                        }
                                    }).catch((err) => {
                                        $(document).Toasts('create', {
                                            class: 'bg-danger toast_width',
                                            title: 'Fail',
                                            subtitle: 'close',
                                            body: 'Unable to reset password! Please try again'
                                        })
                                    })
                                })
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

                                async function update_empl_user_access(url, empl_id, user_access, remote_attendance, disable) {
                                    var formData = new FormData();
                                    formData.append('empl_id', empl_id);
                                    formData.append('user_access', user_access);
                                    formData.append('remote_attendance', remote_attendance);
                                    formData.append('disable', disable);
                                    const response = await fetch(url, {
                                        method: 'POST',
                                        body: formData
                                    });
                                    return response.json();
                                }

                                async function reset_empl_password(url, empl_id, reset_pass) {
                                    var formData = new FormData();
                                    formData.append('empl_id', empl_id);
                                    formData.append('reset_pass', reset_pass)
                                    const response = await fetch(url, {
                                        method: 'POST',
                                        body: formData
                                    });
                                    return response.json();
                                }
                            })
                        </script>

                        <script>
                            function toggleFilter() {
                                document.querySelector('.filter-container').classList.toggle('visible');
                            }
                        </script>

                        <script>
                            $(document).ready(function() {
                                $('#search_select').select2();
                                $('#filter_by_branch').select2();
                                $('#filter_by_department').select2();
                                $('#filter_by_division').select2();
                                $('#filter_by_clubhouse').select2();
                                $('#filter_by_section').select2();
                                $('#filter_by_group').select2();
                                $('#filter_by_team').select2();
                                $('#filter_by_line').select2();

                                $("#search_select").on("change", function() {
                                    applyFilters();
                                });

                                $('select.filter_by').on('change', function() {
                                    applyFilters();
                                });

                                function applyFilters() {
                                    let search_select = $("#search_select").find(":selected").val();

                                    let filter_dept = $("#filter_by_department").val();
                                    let filter_sec = $("#filter_by_section").val();
                                    let filter_group = $("#filter_by_group").val();
                                    let filter_line = $("#filter_by_line").val();
                                    let filter_team = $("#filter_by_team").val();
                                    let filter_branch = $("#filter_by_branch").val();
                                    let filter_division = $("#filter_by_division").val();
                                    let filter_by_clubhouse = $("#filter_by_clubhouse").val();

                                    let params = [];
                                    if (search_select && search_select !== 'all') {
                                        params.push(`search=${search_select}`);
                                    }

                                    if (filter_dept) params.push(`dept=${filter_dept}`);
                                    if (filter_sec) params.push(`sec=${filter_sec}`);
                                    if (filter_group) params.push(`group=${filter_group}`);
                                    if (filter_line) params.push(`line=${filter_line}`);
                                    if (filter_team) params.push(`team=${filter_team}`);
                                    if (filter_branch) params.push(`branch=${filter_branch}`);
                                    if (filter_division) params.push(`division=${filter_division}`);
                                    if (filter_by_clubhouse) params.push(`clubhouse=${filter_by_clubhouse}`);

                                    const filter = document.querySelector('.filter-container').classList.contains('visible') ? '&filter=1' : '';

                                    let query = params.length > 0 ? '?' + params.join('&') + filter : '';
                                    window.location.href = `access${query}`;
                                }
                            });
                        </script>

</body>

</html>