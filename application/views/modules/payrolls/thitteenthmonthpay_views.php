<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?php echo base_url() ?>/assets_system/css/handsontable14.css" />

<?php
(isset($_GET['year'])) ? $year = $_GET['year'] : $year = $YEAR_INITIAL;
(isset($_GET['branch'])) ? $param_branch = $_GET['branch'] : $param_branch = "";
(isset($_GET['dept'])) ? $param_dept = $_GET['dept'] : $param_dept = "";
(isset($_GET['division'])) ? $param_division = $_GET['division'] : $param_division = "";
(isset($_GET['clubhouse'])) ? $param_clubhouse = $_GET['clubhouse'] : $param_clubhouse = "";
(isset($_GET['section'])) ? $param_section = $_GET['section'] : $param_section = "";
(isset($_GET['group'])) ? $param_group = $_GET['group'] : $param_group = "";
(isset($_GET['team'])) ? $param_team = $_GET['team'] : $param_team = "";
(isset($_GET['line'])) ? $param_line = $_GET['line'] : $param_line = "";

$search_data = $this->input->get('search');
$search_data = str_replace("_", " ", $search_data ?? '');

if (isset($_GET['row'])) {
    $row = $_GET['row'];
} else {
    $row = 25;
}

if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}

$prev_page = $current_page - 1;
$next_page = $current_page + 1;
// $last_page = intval($C_DATA_COUNT / $row) + 1;
$last_page_initial = ceil($C_DATA_COUNT / $row);
$last_page = ($last_page_initial == 0 || $last_page_initial == 1) ? 1 : $last_page_initial;

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
    <!-- Content Starts -->
    <div class="content-wrapper">
        <div class="container-fluid p-4">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>payrolls">Attendance
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">13th Month Pay
                    </li>
                </ol>
            </nav>

            <div class="row  pt-1"> <!-- Title starts -->
                <div class="col-md-6">
                    <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'payrolls'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                        </a>&nbsp;13th Month Pay</h1>
                </div>
                <div class="col-md-6 button-title">
                    <!-- <a href="" class="btn btn-primary shadow-none"><img style="width: 17px; height: 17px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/gears-duotone_xs.svg') ?>" alt="">
                        </i>&nbsp;Settings</a> -->
                    <!-- <a href="<?= base_url() . 'leaves/shift_import_csv'; ?>" id="btn_application" class="btn btn-primary shadow-none"><i class="fas fa-file-import"></i>Import CSV</a> -->
                    <!-- <a href="<?= base_url() . 'leaves/bulk_import'; ?>" id="btn_application" class="btn technos-button-green shadow-none"><i class="fas fa-file-import"></i>Bulk Import</a>-->
                    <!-- <a href="#" id="btn_export" class="btn technos-button-gray shadow-none rounded"><i class="fas fa-file-export"></i>Export XLSX</a>  -->
                    <!-- <a href="#" id="btn_application" data-toggle="modal" data-target="#modal_attendance_records" class="btn btn-primary shadow-none"><i class="fas fa-file-export"></i>Export CSV</a> -->
                </div>
            </div><!-- Title Ends -->

            <hr>

            <div class="filter-container  <?= $filter ? 'visible' : '' ?>">
                <div class="row d-flex mb-4"><!-- Filter Starts -->
                    <div class="col-md-2">
                        <p class="mb-1 text-secondary ">Year</p>
                        <select name="filter_year" id="filter_year" class="form-control">
                            <?php
                            // var_dump($DISP_YEARS);
                            if ($DISP_YEARS) {
                                foreach ($DISP_YEARS as $DISP_YEARS_ROW) {
                            ?>
                                    <option value="<?= $DISP_YEARS_ROW->id ?>" <?php echo ($year == $DISP_YEARS_ROW->id ? 'selected' : '') ?>>
                                        <?= $DISP_YEARS_ROW->name ?>
                                    </option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2" <?php echo ($DISP_VIEW_BRANCH ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Branch</p>
                        <select name="dept" id="filter_by_branch" class="form-control">
                            <?php
                            if ($DISP_DISTINCT_BRANCH) {
                            ?>
                                <option value="all">All Branches</option>
                                <?php
                                foreach ($DISP_DISTINCT_BRANCH as $DISP_DISTINCT_BRANCH_ROW) {
                                    if ($DISP_DISTINCT_BRANCH_ROW->name != '') {
                                ?>
                                        <option value="<?= $DISP_DISTINCT_BRANCH_ROW->id ?>" <?php echo $param_branch == $DISP_DISTINCT_BRANCH_ROW->id ? 'selected' : '' ?>>
                                            <?= $DISP_DISTINCT_BRANCH_ROW->name ?>
                                        </option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2" <?php echo ($DISP_VIEW_DEPARTMENT ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Department</p>
                        <select name="dept" id="filter_by_department" class="form-control">
                            <?php
                            if ($DISP_DISTINCT_DEPARTMENT) {
                            ?>
                                <option value="all" <?php foreach ($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW_1) {
                                                        if ($DISP_DISTINCT_DEPARTMENT_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Departments</option>
                                <?php
                                foreach ($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW) {
                                    if ($DISP_DISTINCT_DEPARTMENT_ROW->name != '') {
                                ?>
                                        <option value="<?= $DISP_DISTINCT_DEPARTMENT_ROW->id ?>" <?php echo $param_dept == $DISP_DISTINCT_DEPARTMENT_ROW->id ? 'selected' : '' ?>>
                                            <?= $DISP_DISTINCT_DEPARTMENT_ROW->name ?>
                                        </option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2" <?php echo ($DISP_VIEW_DIVISION ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Division</p>
                        <select name="dept" id="filter_by_division" class="form-control">
                            <?php
                            if ($DISP_DISTINCT_DIVISION) {
                            ?>
                                <option value="all" <?php foreach ($DISP_DISTINCT_DIVISION as $DISP_DISTINCT_DIVISION_ROW_1) {
                                                        if ($DISP_DISTINCT_DIVISION_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Divisions</option>
                                <?php
                                foreach ($DISP_DISTINCT_DIVISION as $DISP_DISTINCT_DIVISION_ROW) {
                                    if ($DISP_DISTINCT_DIVISION_ROW->name != '') {
                                ?>
                                        <option value="<?= $DISP_DISTINCT_DIVISION_ROW->id ?>" <?php echo $param_division == $DISP_DISTINCT_DIVISION_ROW->id ? 'selected' : '' ?>>
                                            <?= $DISP_DISTINCT_DIVISION_ROW->name ?>
                                        </option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2" <?php echo ($DISP_VIEW_CLUBHOUSE ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Clubhouse</p>
                        <select name="dept" id="filter_by_clubhouse" class="form-control">
                            <?php
                            if ($DISP_DISTINCT_CLUBHOUSE) {
                            ?>
                                <option value="all" <?php foreach ($DISP_DISTINCT_CLUBHOUSE as $DISP_DISTINCT_CLUBHOUSE_ROW_1) {
                                                        if ($DISP_DISTINCT_CLUBHOUSE_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Clubhouse</option>
                                <?php
                                foreach ($DISP_DISTINCT_CLUBHOUSE as $DISP_DISTINCT_CLUBHOUSE_ROW_1) {
                                    if ($DISP_DISTINCT_CLUBHOUSE_ROW_1->name != '') {
                                ?>
                                        <option value="<?= $DISP_DISTINCT_CLUBHOUSE_ROW_1->id ?>" <?php echo $param_clubhouse == $DISP_DISTINCT_CLUBHOUSE_ROW_1->id ? 'selected' : '' ?>>
                                            <?= $DISP_DISTINCT_CLUBHOUSE_ROW_1->name ?>
                                        </option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2" <?php echo ($DISP_VIEW_SECTION ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Section</p>
                        <select name="section" id="filter_by_section" class="form-control">
                            <?php
                            if ($DISP_DISTINCT_SECTION) {
                            ?>
                                <option value="all" <?php foreach ($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW_1) {
                                                        if ($DISP_DISTINCT_SECTION_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Sections</option>
                                <?php
                                foreach ($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW) {
                                    if ($DISP_DISTINCT_SECTION_ROW->name != '') {
                                ?>
                                        <option value="<?= $DISP_DISTINCT_SECTION_ROW->id ?>" <?php echo $param_section == $DISP_DISTINCT_SECTION_ROW->id ? 'selected' : "" ?>>
                                            <?= $DISP_DISTINCT_SECTION_ROW->name ?>
                                        </option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2" <?php echo ($DISP_VIEW_GROUP ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Group</p>
                        <select name="group" id="filter_by_group" class="form-control">
                            <?php
                            if ($DISP_DISTINCT_GROUP) {
                            ?>
                                <option value="all" <?php foreach ($DISP_DISTINCT_GROUP as $DISP_DISTINCT_GROUP_ROW_1) {
                                                        if ($DISP_DISTINCT_GROUP_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Groups</option>
                                <?php
                                foreach ($DISP_DISTINCT_GROUP as $DISP_DISTINCT_GROUP_ROW) {
                                    if ($DISP_DISTINCT_GROUP_ROW->name != '') {
                                ?>
                                        <option value="<?= $DISP_DISTINCT_GROUP_ROW->id ?>" <?php echo $param_group == $DISP_DISTINCT_GROUP_ROW->id ? 'selected' : "" ?>>
                                            <?= $DISP_DISTINCT_GROUP_ROW->name ?>
                                        </option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2" <?php echo ($DISP_VIEW_TEAM ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Team</p>
                        <select name="dept" id="filter_by_team" class="form-control">
                            <?php
                            if ($DISP_DISTINCT_TEAM) {
                            ?>
                                <option value="all" <?php foreach ($DISP_DISTINCT_TEAM as $DISP_DISTINCT_TEAM_ROW_1) {
                                                        if ($DISP_DISTINCT_TEAM_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Teams</option>
                                <?php
                                foreach ($DISP_DISTINCT_TEAM as $DISP_DISTINCT_TEAM_ROW) {
                                    if ($DISP_DISTINCT_TEAM_ROW->name != '') {
                                ?>
                                        <option value="<?= $DISP_DISTINCT_TEAM_ROW->id ?>" <?php echo $param_team == $DISP_DISTINCT_TEAM_ROW->id ? 'selected' : '' ?>>
                                            <?= $DISP_DISTINCT_TEAM_ROW->name ?>
                                        </option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2" <?php echo ($DISP_VIEW_LINE ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Line</p>
                        <select name="line" id="filter_by_line" class="form-control">
                            <?php
                            if ($DISP_DISTINCT_LINE) {
                            ?>
                                <option value="all" <?php foreach ($DISP_DISTINCT_LINE as $DISP_DISTINCT_LINE_ROW_1) {
                                                        if ($DISP_DISTINCT_LINE_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Lines</option>
                                <?php
                                foreach ($DISP_DISTINCT_LINE as $DISP_DISTINCT_LINE_ROW) {
                                    if ($DISP_DISTINCT_LINE_ROW->name != '') {
                                ?>
                                        <option value="<?= $DISP_DISTINCT_LINE_ROW->id ?>" <?php echo $param_line == $DISP_DISTINCT_LINE_ROW->id ? 'selected' : '' ?>><?= $DISP_DISTINCT_LINE_ROW->name ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <!-- <div class="col-md-2">
                        <p class="mb-1 text-secondary ">Action</p>
                        <a href=<?= base_url() . "payrolls/thitteenthmonthpay" ?> id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
                    </div> -->

                </div>
            </div><!-- Filter Ends -->

            <div class="card border-0 p-0 m-0">
                <div>
                    <div class="p-2">
                        <div class="justify-content-between">
                            <div class="d-flex row  align-items-center">
                                <div class="form-group row d-flex justify-content-center justify-content-lg-start col-12 col-lg-5 ml-0 ">
                                    <label class="col-md-12 mb-1 p-0 text-secondary " for="search_employees" style="font-weight: 500">Search Employee</label>

                                    <select name="employee_id" id="employee_id" class="px-1 col-12 col-md-5  employee_select form-control custom-select">
                                        <option value="">All</option>
                                        <?php
                                        if ($DISP_ALL_EMP_LIST_DATA) {
                                            foreach ($DISP_ALL_EMP_LIST_DATA as $DISP_EMP_LIST_ROW) {
                                                if ($DISP_EMP_LIST_ROW->col_midl_name) {
                                                    $midl_ini = $DISP_EMP_LIST_ROW->col_midl_name[0] . '.';
                                                } else {
                                                    $midl_ini = '';
                                                }
                                        ?>
                                                <option value="<?= $DISP_EMP_LIST_ROW->id ?>" <?= $search_data == $DISP_EMP_LIST_ROW->id ? 'selected' : '' ?>>
                                                    <?= $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name . ' ' . $midl_ini ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <button id="btnFilter" class="mt-1 mt-lg-0 btn btn-primary shadow-none rounded ml-1" onclick="toggleFilter()"><img src="<?= base_url('assets_system/icons/advance_filter.svg') ?>" style="margin-bottom: 1px" alt="" />&nbsp;Advance Filter</button>
                                    <a href="<?= base_url('payrolls/thitteenthmonthpay') ?>" id="btn_clear_filter" class="mt-1 mt-lg-0 btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="" />&nbsp;Clear</a>
                                </div>
                                <div class="d-none d-lg-flex col-sm-7 col-md-10 col-lg-6 justify-content-end justify-content-lg-start my-lg-0 my-2">
                                    <div class="col-12 col-md-10 col-lg-10 col-xl-10 d-flex justify-content-center justify-content-xl-end align-items-center ">
                                        <div class="d-flex align-items-center justify-content-center justify-content-lg-start row">
                                            <div class="d-inline col-12 col-lg-3 col-xl-6" >
                                                <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                                            </div>
                                            <div class="d-lg-inline d-flex col-12 col-lg-3 col-xl-6">
                                                <ul class="pagination ml-0 ml-lg-4 m-0 p-0 mr-auto">
                                                    <li><a class="page_row" <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
                                                            < </a>
                                                    </li>
                                                    <li><a class="page_row" href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                                                    <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                                                    <li><a class="page_row" href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                                                    <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                                                    <li><a class="page_row" href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                                                    <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                                                    <li><a class="page_row" href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page) echo "hidden"; ?>><?= $last_page ?> </a></li>
                                                    <li><a class="page_row" style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                  
                                </div>
                                <div class="col-12 col-lg-1 d-none d-lg-flex justify-content-end align-items-center ml-auto">
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
                        <!-- <div class="input-group p-1 pt-2">
                        <?php
                        if ($search_data) { ?>
                            <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fa-regular fa-broom-wide" style="margin-top: 4px"></i>&nbsp;Clear</button>
                        <?php } else { ?>
                            <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
                        <?php } ?>
                        
                        <input type="text" class="form-control" placeholder="Search..." value="<?= ($search_data) ? $search_data : ""; ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
                        </div> -->




                    </div>
                    <div class="card border-0 p-0 m-0">
                        <!-- handsontable -->
                        <div class="px-2">

                        </div>
                        <div class="row">
                            <div class="col">
                                <div style="margin: 0px !important;">
                                    <div id="table_data"> </div>
                                    <!-- <div id="table_data" > </div> -->
                                    <div class="d-flex d-lg-none col-sm-7 col-md-10 col-lg-6 justify-content-lg-end justify-content-center my-lg-0 my-2">
                                        <div class="col-12 col-lg-7 d-flex justify-content-lg-end justify-content-center align-items-center mx-2">
                                            <div class="d-flex align-items-center row">
                                                <div class="d-inline col-12 col-lg-6">
                                                    <p class=" p-0 m-0 mx-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                                                </div>
                                                <div class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-end">
                                                    <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">
                                                        <li><a class="page_row" <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
                                                                < </a>
                                                        </li>
                                                        <li><a class="page_row" href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                                                        <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                                                        <li><a class="page_row" href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                                                        <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                                                        <li><a class="page_row" href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                                                        <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                                                        <li><a class="page_row" href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page) echo "hidden"; ?>><?= $last_page ?> </a></li>
                                                        <li><a class="page_row" style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-1 d-flex d-lg-none justify-content-center align-items-center my-1">
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
            </div><!--End fluid-->
        </div> <!-- Content Ends -->



        <div class="modal fade  class_modal_update_list" id="modela_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: none;">
                        <h4 class="modal-title ml-1" id="exampleModalLabel">Update Bulk
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;
                            </span>
                        </button>
                    </div>
                    <form action="<?= base_url() . 'employees/update_salary_detail_bulk'; ?>" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul id="update_list_id" class="row" style="background: #e7f4e4;"></ul>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label class="required" for="UPDT_SALARY_AMOUNT">Employee Code</label>
                                        <input class="form-control" type="number" class="UPDT_SALARY_AMOUNT" id="updt_salary_amount" name="UPDT_SALARY_AMOUNT" pattern="^\d*(\.\d{0,2})?$" step="0.01">
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="UPDATE_ID" id="UPDATE_ID">
                            <button type="submit" class='btn btn-primary text-light' id="save_button">&nbsp; Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <?php $this->load->view('templates/jquery_link'); ?>

        <?php
        if ($this->session->userdata('SESS_SUCCESS_MSG')) {
        ?>
            <script>
                $(document).Toasts('create', {
                    class: 'bg-success toast_width',
                    title: 'Error',
                    subtitle: 'close',
                    body: '<?php echo $this->session->userdata('SESS_SUCCESS_MSG'); ?>'
                })
            </script>
        <?php
            $this->session->unset_userdata('SESS_SUCCESS_MSG');
        }
        ?>

        <?php
        if ($this->session->userdata('SESS_ERROR_MSG')) {
        ?>
            <script>
                $(document).Toasts('create', {
                    class: 'bg-danger toast_width',
                    title: 'Error',
                    subtitle: 'close',
                    body: '<?php echo $this->session->userdata('SESS_ERROR_MSG'); ?>'
                })
            </script>
        <?php
            $this->session->unset_userdata('SESS_ERROR_MSG');
        }
        ?>

        <?php
        if ($this->session->userdata('SESS_EMPTY_MSG')) {
        ?>
            <script>
                $(document).Toasts('create', {
                    class: 'bg-warning toast_width',
                    title: 'Warning',
                    subtitle: 'close',
                    body: '<?php echo $this->session->userdata('SESS_EMPTY_MSG'); ?>'
                })
            </script>
        <?php
            $this->session->unset_userdata('SESS_EMPTY_MSG');
        }
        ?>

        <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
        <script type="text/javascript" src="<?php echo base_url() ?>/assets_system/js/handsontable14.js"></script>

        <script>
            var url = '<?= base_url() ?>';
            var dispEmpList = <?php echo json_encode($DISP_EMP_LIST); ?>;
            var dispCutoffPeriod = <?php echo json_encode($cutoff_period); ?>;

            const amountColumns = ['amount'];

            const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
                Handsontable.renderers.TextRenderer.apply(this, arguments);
                td.style.whiteSpace = 'nowrap';
                td.style.overflow = 'hidden';
                td.style.backgroundColor = '#f9f9f9';
            };

            let value_custom = function(instance, td, row, col, prop, value, cellProperties) {
                Handsontable.renderers.TextRenderer.apply(this, arguments);
                td.style.textAlign = 'right';
            };

            // Abbreviate the months and simplify the format
            dispCutoffPeriod = dispCutoffPeriod.map(function(period) {
                let dateFrom = new Date(period.date_from);
                let dateTo = new Date(period.date_to);

                // Abbreviate the month (Jan, Feb, etc.)
                const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                let formattedName = dateFrom.getMonth() === dateTo.getMonth() 
                    ? `${dateFrom.getDate()}-${dateTo.getDate()} ${monthNames[dateFrom.getMonth()]}`
                    : `${monthNames[dateFrom.getMonth()]} ${dateFrom.getDate()} - ${monthNames[dateTo.getMonth()]} ${dateTo.getDate()}`;
                
                return {
                    ...period,
                    name: formattedName
                };
            });

            var combinedData = dispEmpList.map(function(empData) {
                let name = `${empData.col_empl_cmid}-${empData.col_last_name}`;
                if (empData.col_suffix) name = `${name} ${empData.col_suffix}`;
                if (empData.col_frst_name) name = `${name}, ${empData.col_frst_name}`;
                if (empData.col_midl_name) name = `${name} ${empData.col_midl_name[0]}.`;
                var combinedRow = {
                    id: empData.id,
                    col_empl_cmid: name,
                    amount: empData._13th_month_pay,
                    total_basic: empData.total_basic,
                    
                };

                // amountColumns.forEach(function(amount) {
                //     if (amount == "amount") {
                //         combinedRow[amount] = empData._13th_month_pay;
                //     }
                // })

                  // Add each cutoff period column
                    dispCutoffPeriod.forEach(function(period) {
                        let payslipPeriod = empData.all_basic_pay[0].find(pay => pay.PAYSLIP_PERIOD === period.id);
                        combinedRow[period.id] = payslipPeriod ? payslipPeriod.TOTAL_BASIC : '';
                    });

                return combinedRow;
            });

            if (combinedData.length === 0) {
                combinedData.push(['', '', '']);
            }

            // Create the base colHeaders array
            const baseColHeaders = ['Id', 'Employee', '13th', 'Total Basic'];

            // Append each dispCutoffPeriod name to the colHeaders array
            dispCutoffPeriod.forEach(function(period) {
                baseColHeaders.push(period.name);
            });

            const columns = [{
                    data: 'id',
                    readOnly: true
                },
                {
                    data: 'col_empl_cmid',
                    readOnly: true
                },
                {
                    data: 'amount',
                    readOnly: true,
                    renderer: function(instance, td, row, col, prop, value, cellProperties) {
                        Handsontable.renderers.TextRenderer.apply(this, arguments);
                        td.style.textAlign = 'right';
                        td.style.backgroundColor = '#f9f9f9';
                        if (!isNaN(value)) {
                            value = parseFloat(value).toFixed(2);
                            td.innerHTML = '<span style="float: left;">&#8369;</span>' + value;
                        }
                    }
                },
                {
                    data: 'total_basic',
                    readOnly: true,
                    renderer: function(instance, td, row, col, prop, value, cellProperties) {
                        Handsontable.renderers.TextRenderer.apply(this, arguments);
                        td.style.textAlign = 'right';
                        td.style.backgroundColor = '#f9f9f9';
                        if (!isNaN(value)) {
                            value = parseFloat(value).toFixed(2);
                            td.innerHTML = '<span style="float: left;">&#8369;</span>' + value;
                        }
                    }
                    
                },
                    // Add dynamic columns for each period
                ...dispCutoffPeriod.map(period => ({
                    data: period.id,
                    readOnly: true,
                    renderer: customStyleRenderer
                }))

                
            ];

            const container = document.querySelector('#table_data');
            hot = new Handsontable(container, {
                data: combinedData,
                colHeaders: baseColHeaders,
                rowHeaders: true,
                stretchH: 'all',
                height: 'auto',
                rowHeights: 40,
                outsideClickDeselects: false,
                selectionMode: 'multiple',
                licenseKey: 'non-commercial-and-evaluation',
                renderer: customStyleRenderer,
                hiddenColumns: {
                    columns: [0],
                    indicators: true,
                    copyPasteEnabled: false,
                },
                columns: columns,
            });
        </script>

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
                $('#employee_id').select2();

                var base_url = '<?= base_url(); ?>';

                $('#row_dropdown').on('change', function(e) {
                    e.preventDefault()
                    var row_val = $(this).val();
                    let data = "?page=" + "<?= $current_page ?>" + "&row=" + row_val;
                    filter_data(data);
                    // document.location.href = base_url + "employees/taxable_allowance_assign?page=1&row=" + row_val ; 
                });

                $('.page_row').on('click', function(e) {
                    e.preventDefault()
                    let page_row = $(this).attr('href');
                    filter_data(page_row);
                })
                $("#filter_year").on("change", function() {
                    filter_data();
                })

                $("#filter_by_branch").on("change", function() {
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
                $("#employee_id").on("change", function() {
                    filter_data();
                })

                $("#filter_by_status").on("change", function() {
                    filter_data();
                })

                function filter_data(page_row) {

                    if (page_row == null || page_row == "") {
                        page_row = '?page=' + "<?= $current_page ?>" + '&row=' + "<?= $row ?>"
                    }

                    let year = $("#filter_year").find(":selected").val();
                    let branch = $("#filter_by_branch").find(":selected").val();
                    let department = $("#filter_by_department").find(":selected").val();
                    let division = $("#filter_by_division").find(":selected").val();
                    let clubhouse = $("#filter_by_clubhouse").find(":selected").val();
                    let section = $("#filter_by_section").find(":selected").val();
                    let group = $("#filter_by_group").find(":selected").val();
                    let team = $("#filter_by_team").find(":selected").val();
                    let line = $("#filter_by_line").find(":selected").val();
                    let employee_id = $("#employee_id").find(":selected").val();

                    let filterUrl = page_row + "&branch=" + branch +
                        "&dept=" + department + "&division=" + division +
                        "&clubhouse=" + clubhouse +
                        "&section=" + section + "&group=" + group +
                        "&team=" + team + "&line=" + line + "&search=" + employee_id + "&year=" + year;

                    if (document.querySelector('.filter-container').classList.contains('visible')) {
                        filterUrl = filterUrl + '&filter=1';
                    }

                    window.location = base_url + "payrolls/thitteenthmonthpay" + filterUrl;
                }

                // $('.code_val').on('change', function() {
                // let cur_page = "<?= $current_page ?>";
                // let cur_row = "<?= $row ?>";

                $('.code_val').on('keydown', function(event) {
                    if (event.key === "Enter") {
                        event.preventDefault();
                        let default_val = $(this).attr('default');
                        let employee_id = $(this).siblings("#employee_data").val();
                        let empl_id = $(this).siblings("#employee_id").val();
                        let code_val = $(this).val();
                        code_val = (code_val) ? code_val : null;

                        if (default_val != code_val) {
                            window.location = base_url + "attendances/process_code_update/" + empl_id + "/" + employee_id + "/" + code_val;
                        }
                    }
                })

                $('.code_val').on('focusout', function(event) {
                    event.preventDefault();
                    let default_val = $(this).attr('default');
                    let employee_id = $(this).siblings("#employee_data").val();
                    let empl_id = $(this).siblings("#employee_id").val();
                    let code_val = $(this).val();
                    code_val = (code_val) ? code_val : null;

                    if (default_val != code_val) {
                        window.location = base_url + "attendances/process_code_update/" + empl_id + "/" + employee_id + "/" + code_val;
                    }

                })


                $('.salary_type').on('change', function() {
                    let employee_id = $(this).siblings("#employee_data").val();
                    let type_val = $(this).val();

                    window.location = base_url + "employees/process_salary_type_update/" + employee_id + "/" + type_val;
                })



                $('#update').click(function() {
                    let selected_id = [];
                    let att_empl_names = [];

                    $('#UPDATE_ID').empty();
                    $('#update_list_id').empty();
                    $('#select_item input[type=checkbox]:checked').each(function() {
                        let selected_item = $(this).val();
                        let att_empl_name = $(this).attr('empl_name')
                        selected_id.push(selected_item);
                        att_empl_names.push(att_empl_name);
                    })

                    if (selected_id.length > 0) {
                        $('.class_modal_update_list').prop('id', 'modela_update');
                        $('#UPDATE_ID').val(selected_id);
                        att_empl_names.forEach(function(data) {
                            $('#update_list_id').append(`<li class="col-md-6"> <strong>${data}</strong></li>`);
                        })
                    } else {
                        $('.class_modal_update_list').prop('id', '');
                        Swal.fire(
                            'Please Select Employee!',
                            '',
                            'warning'
                        )
                    }
                });


                $(document).on('click', '#check_all', function() {
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

                function search() {
                    var optionValue = $('#search_data').val();
                    var url = window.location.href.split("?")[0];
                    if (window.location.href.indexOf("?") > 0) {
                        window.location = url + "?page=1&all=" + optionValue.replace(/\s/g, '_');
                    } else {
                        window.location = url + "?page=1&all=" + optionValue.replace(/\s/g, '_');
                    }
                }


            })
        </script>
        <script>
            function toggleFilter() {
                document.querySelector('.filter-container').classList.toggle('visible');
            }
        </script>
        <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <script>
        document.getElementById("btn_export").addEventListener('click', function() {
            /* Create worksheet from HTML DOM TABLE */
            var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
            /* Export to file (start a download) */
            XLSX.writeFile(wb, "Leave Entitlement.xlsx");
        });
    </script> -->
</body>

</html>