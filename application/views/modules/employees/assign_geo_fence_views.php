<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?= base_url('assets_system/css/handsontable14.css') ?>" />
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

    @media (max-width: 576px) {
        #search_select .employee_select {
            width: 100% !important;
        }
    }

    @media (min-height: 720px) {
        #search_select .employee_select {
            width: 10% !important;
        }
    }
</style>
<?php
(isset($_GET['branch'])) ? $param_branch = $_GET['branch'] : $param_branch = "";
(isset($_GET['dept'])) ? $param_dept = $_GET['dept'] : $param_dept = "";
(isset($_GET['division'])) ? $param_division = $_GET['division'] : $param_division = "";
(isset($_GET['clubhouse'])) ? $param_clubhouse = $_GET['clubhouse'] : $param_clubhouse = "";
(isset($_GET['section'])) ? $param_section = $_GET['section'] : $param_section = "";
(isset($_GET['group'])) ? $param_group = $_GET['group'] : $param_group = "";
(isset($_GET['team'])) ? $param_team = $_GET['team'] : $param_team = "";
(isset($_GET['line'])) ? $param_line = $_GET['line'] : $param_line = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
} else {
    $search = "";
}

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

$prev_page         = $current_page - 1;
$next_page         = $current_page + 1;
$last_page_initial = ceil($C_DATA_COUNT / $row);
$last_page         = ($last_page_initial == 0 || $last_page_initial == 1) ? 1 : $last_page_initial;


$filter = $this->input->get('filter');
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

<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <div class="row  pt-1">
                <div class="col-md-6">
                    <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'employees'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                        </a>&nbsp;Assign Geo Fences</h1>
                </div>
                <div class="col-md-6 button-title d-flex justify-content-end">
                    <button class="btn btn-primary" id="btn-update">
                        <img style="width: 16px; height: 16px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" /></i>&nbsp;Update
                    </button>
                </div>
            </div>
            <hr>


            <div class="filter-container <?= $filter ? 'visible' : '' ?>">
                <div class=" mb-4 d-flex row ">
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

                </div>

            </div>

            <div class="card border-0 p-0 m-0">

                <div class="card border-0 px-2 m-0">
                    <div class="p-2">

                        <div class="">
                            <!-- <div class="justify-content-between"> -->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex row align-items-end justify-content-between">

                                            <div class=" row d-flex justify-content-center justify-content-lg-start col-12 col-md-3 col-lg-6 ">

                                                <label class="col-12 mb-1 p-0 text-secondary">Search Employee</label>

                                                <select id="search_select" class="px-1 col-12 col-md-4 employee_select form-control ">
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

                                                <button id="btnFilter" class="mt-1 mt-lg-0 btn btn-primary  shadow-none rounded ml-1" onclick="toggleFilter()"><img src="<?= base_url('assets_system/icons/advance_filter.svg') ?>" style="margin-bottom: 2px" alt="">&nbsp;Advance Filter</button>
                                                <a href="<?= base_url('employees/assign_geo_fences') ?>" id="btn_clear_filter" class="mt-1 mt-lg-0 btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="">&nbsp;Clear</a>


                                            </div>

                                            <div class="d-none d-lg-flex col-sm-7 col-md-10 col-lg-5 justify-content-center justify-content-md-center justify-content-lg-end my-lg-0 my-2 ROW">
                                                <div class="col-12 col-lg-5 d-flex justify-content-lg-end align-items-end ">
                                                    <div class="d-flex align-items-center row">
                                                        <div class="d-inline col-12 col-lg-6">
                                                            <p class="p-0 m-0 mx-auto text-end text-lg-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
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
                                                <div class="col-12 col-lg-2 d-none d-lg-flex justify-content-center align-items-center ml-auto mr-2     ">
                                                    <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                                                    <select id="row_dropdown" class="custom-select notranslate mr-4" style="width: auto;">
                                                        <?php
                                                        foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>
                                                            <option value="<?= (int)$C_ROW_DISPLAY_ROW ?>" <?php echo ((int)$C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= (int)$C_ROW_DISPLAY_ROW ?></option>
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

                </div>

                <div class="">
                    <!-- <div id="table_data"></div> -->

                    <div class="table-responsive mx-1 mx-lg-0">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="w-50">EMPLOYEE</th>
                                    <th>FENCES</th>
                                </tr>
                            </thead>
                            <?php if ($DISP_EMP_LIST) { ?>
                                <?php foreach ($DISP_EMP_LIST as $employee) :  ?>
                                    <tr>
                                        <td><?= $employee->employee ?></td>
                                        <td>
                                            <form class="form-fence_data" method="POST">
                                                <input type="hidden" name="empl_id" value="<?= $employee->id ?>">
                                                <select class="w-100 select-fences form-control" name="fences[]" multiple="multiple">
                                                    <?php foreach ($FENCES as $fence) : ?>
                                                        <option value="<?= $fence->id ?>" <?= $employee->fences && in_array($fence->id, json_decode($employee->fences)) ? 'selected' : '' ?>><?= $fence->name ?></option>
                                                    <?php endforeach  ?>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php } ?>
                        </table>

                    </div>

                    <div class="d-block d-lg-none col-sm-7 col-md-10 col-lg-5 justify-content-lg-end justify-content-center my-lg-0 my-2">
                        <div class="col-12 col-lg-7 d-flex justify-content-lg-end align-items-center mx-2">
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
                    <div class="col-12 col-lg-1 d-flex d-lg-none justify-content-center align-items-center mb-2">
                        <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                        <select id="row_dropdown" class="custom-select notranslate" style="width: auto;">
                            <?php
                            foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>
                                <option value="<?= (int)$C_ROW_DISPLAY_ROW ?>" <?php echo ((int)$C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= (int)$C_ROW_DISPLAY_ROW ?></option>
                            <?php
                            } ?>
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- <div class="modal fade  class_modal_update_list" id="modela_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Update Bulk </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;
                        </span>
                    </button>
                </div>

                <form action="<?= base_url() . 'payrolls/update_payroll_assignment_bulk'; ?>" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul id="update_list_id" class="row" style="background: #e7f4e4;"></ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" for="UPDT_PAYROLL_ASSIGN">Salary Type</label>
                                    <select name="UPDT_PAYROLL_ASSIGN" id="UPDT_PAYROLL_ASSIGN" class="form-control">
                                        <option value="0">Rank and File</option>
                                        <option value="1">Rank & File/Managers</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div> -->
    <!-- 
                    <div class="modal-footer">
                        <input type="hidden" name="UPDATE_ID" id="UPDATE_ID">
                        <button type="submit" class='btn btn-primary text-light' id="save_button">&nbsp; Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->

    <?php $this->load->view('templates/jquery_link'); ?>
    <script type="text/javascript" src="<?= base_url('assets_system/js/handsontable14.js') ?>"></script>

    <?php
    if ($this->session->userdata('SESS_SUCCESS')) {
    ?>
        <script>
            $(document).Toasts('create', {
                class: 'bg-success toast_width',
                title: 'Success',
                subtitle: 'close',
                body: '<?php echo $this->session->userdata('SESS_SUCCESS'); ?>'
            })
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCCESS');
    }
    ?>

    <script>
        $(document).ready(function() {
            $('#search_select').select2();
            $(".select-fences").select2({
                width: 'resolve',
                theme: "classic"
            });
            $("#search_select").on("change", function() {
                search();
            });
            $('button#btn-update').on('click', async function(e) {
                let forms = $('.form-fence_data');
                for (let i = 0; i < forms.length; i++) {
                    console.log(i);
                    let res = await $.post("<?= site_url('employees/update_fences') ?>", $(forms[i]).serialize(), function(res) {
                        console.log(res);
                    }, 'json');
                }

            })
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

        function filter_clear() {
            document.location.href = "assign_geo_fences";
        }
    </script>

    <script>
        var assignment_update = document.getElementById('btn-update');
        assignment_update.addEventListener('click', function() {
            Swal.fire({
                title: "Are you sure you want to update fence?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirm",
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Updated Successfully!",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                }
            });
            // let messageError = '';
            // let changes = [];
            // for (var i = 0; i < dataCopy.length; i++) {
            //     if (dataCopy[i].assignment != data[i].assignment) {
            //         if (!source.includes(data[i].assignment)) {
            //             if (messageError) {
            //                 messageError = messageError + `, ${i+1}`
            //             } else {
            //                 messageError = `Invalid Assignment on row: ${i+1}`
            //             }
            //             continue;
            //         }
            //         changes.push({
            //             id: dataCopy[i].id,
            //             assignment: data[i].assignment
            //         })
            //     }
            // }
            // console.log('messageError', messageError);
            // if (messageError) {
            //     $(document).Toasts('create', {
            //         class: 'bg-warning toast_width',
            //         title: 'Warning!',
            //         subtitle: 'close',
            //         body: messageError
            //     });
            //     return;
            // }
            // console.log('changes', changes);
            // if (changes.length < 1) {
            //     $(document).Toasts('create', {
            //         class: 'bg-warning toast_width',
            //         title: 'Warning!',
            //         subtitle: 'close',
            //         body: 'No Changes'
            //     });
            //     return;
            // }
            // fetch(url + 'employees/update_data_payroll_assignment', {
            //         method: 'POST',
            //         headers: {
            //             'Content-Type': 'application/json'
            //         },
            //         body: JSON.stringify(data)
            //     })
            //     .then(response => response.json())
            //     .then(result => {
            //         console.log(result);

            //         if (result.success_message) {
            //             $(document).Toasts('create', {
            //                 class: 'bg-success toast_width',
            //                 title: 'Success!',
            //                 subtitle: 'close',
            //                 body: result.success_message
            //             })
            //         }

            //         if (result.warning_message) {
            //             $(document).Toasts('create', {
            //                 class: 'bg-warning toast_width',
            //                 title: 'Warning!',
            //                 subtitle: 'close',
            //                 body: result.warning_message
            //             })
            //         }
            //     })
            //     .catch(error => {
            //         $(document).Toasts('create', {
            //             class: 'bg-warning toast_width',
            //             title: 'Warning!',
            //             subtitle: 'close',
            //             body: 'Please provide all required information.'
            //         })
            //         console.error('Data update error:', error);
            //     });

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

            var base_url = '<?= base_url(); ?>';

            $('#row_dropdown').on('change', function(e) {
                e.preventDefault()
                var row_val = $(this).val();
                let data = "?page=1&row=" + row_val;
                filter_data(data);
            });

            $('.page_row').on('click', function(e) {
                e.preventDefault()
                let page_row = $(this).attr('href');
                filter_data(page_row);
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

            $("#filter_by_status").on("change", function() {
                filter_data();
            })

            function filter_data(page_row) {

                if (page_row == null || page_row == "") {
                    page_row = '?page=' + "<?= $current_page ?>" + '&row=' + "<?= $row ?>"
                }

                let branch = $("#filter_by_branch").find(":selected").val();
                let department = $("#filter_by_department").find(":selected").val();
                let division = $("#filter_by_division").find(":selected").val();
                let clubhouse = $("#filter_by_clubhouse").find(":selected").val();
                let section = $("#filter_by_section").find(":selected").val();
                let group = $("#filter_by_group").find(":selected").val();
                let team = $("#filter_by_team").find(":selected").val();
                let line = $("#filter_by_line").find(":selected").val();

                filterUrl = page_row + "&branch=" + branch + "&dept=" + department + "&division=" + division + "&clubhouse=" + clubhouse + "&section=" + section + "&group=" + group + "&team=" + team + "&line=" + line;

                if (document.querySelector('.filter-container').classList.contains('visible')) {
                    filterUrl = filterUrl + '&filter=1';
                }
                window.location = "?" + filterUrl;
            }

            // $('.salary_val').on('keydown', function(event) {
            //     if (event.key === "Enter") {
            //         event.preventDefault();

            //         let employee_id = $(this).siblings("#employee_data").val();
            //         let salary_val = $(this).val();

            //         window.location = base_url + "employees/process_salary_update/" + employee_id + "/" + salary_val;
            //     }
            // })

            // $('.salary_type').on('change', function() {
            //     let employee_id = $(this).siblings("#employee_data").val();
            //     let type_val = $(this).val();

            //     window.location = base_url + "employees/payroll_assignment_update/" + employee_id + "/" + type_val;
            // })

            // $('#update').click(function() {
            //     let selected_id = [];
            //     let att_empl_names = [];

            //     $('#UPDATE_ID').empty();
            //     $('#update_list_id').empty();
            //     $('#select_item input[type=checkbox]:checked').each(function() {
            //         let selected_item = $(this).val();
            //         let att_empl_name = $(this).attr('empl_name')
            //         selected_id.push(selected_item);
            //         att_empl_names.push(att_empl_name);
            //     })

            //     if (selected_id.length > 0) {
            //         $('.class_modal_update_list').prop('id', 'modela_update');
            //         $('#UPDATE_ID').val(selected_id);
            //         att_empl_names.forEach(function(data) {
            //             $('#update_list_id').append(`<li class="col-md-6"> <strong>${data}</strong></li>`);
            //         })
            //     } else {
            //         $('.class_modal_update_list').prop('id', '');
            //         Swal.fire(
            //             'Please Select Employee!',
            //             '',
            //             'warning'
            //         )
            //     }
            // });

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

</body>

</html>