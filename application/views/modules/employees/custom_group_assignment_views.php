<html>
<?php $this->load->view('templates/css_link'); ?>
<?php
(isset($_GET['branch'])) ? $param_branch = $_GET['branch'] : $param_branch = "";
(isset($_GET['company'])) ? $param_company = $_GET['company'] : $param_company = "";
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
    $row = 10;
}

if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}

$prev_page = $current_page - 1;
$next_page = $current_page + 1;
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
    .icon-center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }
</style>

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
<style>
    th {
        text-align: center;
        vertical-align: middle;
    }

    th input[type="checkbox"] {
        margin-left: 5px;
        vertical-align: middle;
    }
</style>

<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">

            <div class="row  pt-1"> <!-- Title starts -->
                <div class="col-md-6">
                    <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'employees'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                        </a>&nbsp;Custom Group Assigment</h1>
                </div>
                <div class="col-md-6 button-title d-flex justify-content-end">
                    <button class="btn btn-primary" id="generateArrayButton"><img style="width: 16px; height: 16px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />
                        Update</button>
                </div>
            </div><!-- Title Ends -->

            <hr>
            <div class="filter-container<?= $filter ? 'visible' : '' ?>">
                <div class=" mb-4 d-flex row "><!-- Filter Starts -->
                    <div class="col-md-2" <?php echo ($DISP_VIEW_COMPANY ? "" : "hidden") ?>>
                        <p class="mb-1 text-secondary ">Company</p>
                        <select name="dept" id="filter_by_company" class="form-control">
                            <?php
                            if ($DISP_DISTINCT_COMPANY) {
                            ?>
                                <option value="all">All Companies</option>
                                <?php
                                foreach ($DISP_DISTINCT_COMPANY as $Row) {
                                    if ($Row->name != '') {
                                ?>
                                        <option value="<?= $Row->id ?>" <?php echo $param_company == $Row->id ? 'selected' : '' ?>>
                                            <?= $Row->name ?>
                                        </option>
                            <?php
                                    }
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
                            if ($DISP_DISTINCT_DIVISION) {
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

            </div><!-- Filter Ends -->

            <div class="card border-0 p-0 m-0">

                <div class="card border-0 p-0 m-0">
                    <div class="p-2">

                        <div class="">
                            <div class="justify-content-between">
                                <div class="row">

                                    <div class=" col-md-12 col-lg-12" <?php echo (true ? "" : "hidden") ?>>
                                        <div class="d-flex row  align-items-end">
                                            <div class="row d-flex justify-content-center justify-content-lg-start col-12 col-lg-6 col-xl-5">
                                                <label class="col-md-12 mb-1 text-secondary">Search Employee</label>
                                                <select id="search_select" class="px-1 col-12 col-md-5 employee_select form-control w-100 w-lg-50">
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

                                                <button id="btnFilter" class="btn btn-primary shadow-none rounded ml-1" onclick="toggleFilter()"><img src="<?= base_url('assets_system/icons/advance_filter.svg') ?>" style="margin-bottom: 1px" alt="">&nbsp;Advance Filter</button>
                                                <a href="<?= base_url('employees/custom_group_assignment') ?>" id="btn_clear_filter" class="btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="">&nbsp;Clear</a>
                                            </div>

                                            <div class="row d-none d-lg-flex col-12 col-lg-6 col-xl-7 justify-content-lg-end justify-content-center my-lg-0 my-2">
                                                <div class="col-12 col-lg-10 d-flex justify-content-lg-end align-items-center">
                                                    <div class="d-flex align-items-center row">
                                                        <div class="d-inline col-12 col-lg-5">
                                                            <p class="p-0 m-0 mx-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                                                        </div>

                                                        <div class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-between">
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
                                                <div class="col-12 col-lg-1 col-xl-1 d-none d-lg-flex justify-content-end align-items-center ml-auto">
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

                </div>

                <div class="table-responsive">
                    <table class="table table-bordered m-0" id="table_main" style="width:100%">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <?php if (!empty($customGroups)) {
                                    foreach ($customGroups as $i) { ?>
                                        <th><?= $i->name ?><input type="checkbox" id="checkAll<?= $i->name ?>"></th>
                                <?php }
                                } ?>
                            </tr>
                        </thead>
                        <tbody id="tbl_application_container">
                            <?php
                            if (!empty($tableData)) {
                                foreach ($tableData as $r) { ?>
                                    <tr>
                                        <td class="d-none empl_id"><?= $r->id ?></td>
                                        <td class="text-center" id="select_item">
                                            <?= $r->employee ?>
                                        </td>
                                        <?php
                                        foreach ($customGroups as $r2) { ?>
                                            <td class="text-center" id="select_item">
                                                <input type="checkbox" name="brand" class="check_single <?= $r2->name ?>" <?= $isChecked = in_array($r2->name, explode(',', $r->groups ?? '')) ? 'checked' : ''; ?>>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr class="table-active">
                                    <td colspan="50">
                                        <center>No Records</center>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var initialState = [];

                        <?php if (!empty($customGroups)) {
                            foreach ($customGroups as $i) { ?>

                                document.getElementById('checkAll<?= $i->name ?>').addEventListener('change', function() {
                                    var checkboxes = document.querySelectorAll('.<?= $i->name ?>');
                                    checkboxes.forEach(function(checkbox) {
                                        checkbox.checked = event.target.checked;
                                    });
                                });
                                isCheckedAll = true;
                                document.querySelectorAll('.<?= $i->name ?>').forEach(checkbox => {
                                    if (!checkbox.checked) {
                                        isCheckedAll = false;
                                    }
                                })
                                if (isCheckedAll) {
                                    document.getElementById('checkAll<?= $i->name ?>').checked = true;
                                }
                        <?php }
                        } ?>

                        function generateArrayAndCompare() {
                            var array = [];
                            var employees = document.querySelectorAll('#tbl_application_container tr');
                            employees.forEach(function(employeeRow) {
                                var empl_id = employeeRow.querySelector('.empl_id').innerText;
                                var employeeName = employeeRow.querySelector('.text-center').innerText;
                                var groups = {};
                                var checkboxes = employeeRow.querySelectorAll('.check_single');
                                checkboxes.forEach(function(checkbox) {
                                    var groupName = checkbox.classList[1];
                                    groups[groupName] = checkbox.checked ? 1 : 0;
                                });
                                array.push({
                                    empl_id: empl_id,
                                    employeeName,
                                    groups: groups
                                });
                            });
                            var changesArray = [];
                            for (var i = 0; i < array.length; i++) {
                                var employeeGroups = array[i].groups;
                                var initialGroups = initialState[i].groups;
                                var changedGroups = {};
                                for (var group in employeeGroups) {
                                    if (employeeGroups.hasOwnProperty(group)) {
                                        if (employeeGroups[group] !== initialGroups[group]) {
                                            changedGroups[group] = employeeGroups[group];
                                        }
                                    }
                                }
                                if (Object.keys(changedGroups).length > 0) {
                                    changesArray.push({
                                        empl_id: array[i].empl_id,
                                        employeeName: array[i].employeeName,
                                        groups: changedGroups
                                    });
                                }
                            }
                            console.log(changesArray);
                            if (changesArray.length < 1) {
                                $(document).Toasts('create', {
                                    class: 'bg-warning toast_width',
                                    title: 'Warning!',
                                    subtitle: 'close',
                                    body: 'No Changes'
                                });
                                return;
                            }
                            fetch('<?php echo base_url('employees/custom_group_assignment_api'); ?>', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify(changesArray)
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        // throw new Error('Network response was not ok');
                                        $(document).Toasts('create', {
                                            class: 'bg-warning toast_width',
                                            title: 'Warning!',
                                            subtitle: 'close',
                                            body: 'Unexpected Error Occured'
                                        });
                                        return;
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    console.log('Data sent successfully', data);
                                    if (data.messageError) {
                                        $(document).Toasts('create', {
                                            class: 'bg-warning toast_width',
                                            title: 'Warning!',
                                            subtitle: 'close',
                                            body: data.messageError,
                                        });
                                        return;
                                    }
                                    if (data.messageSuccess) {
                                        initialState = [];
                                        initialStateFunction();
                                        $(document).Toasts('create', {
                                            class: 'bg-success toast_width',
                                            title: 'Success!',
                                            subtitle: 'close',
                                            body: data.messageSuccess,
                                        });
                                        return;
                                    }
                                })
                                .catch(error => {
                                    // console.error('There was a problem with the fetch operation:', error);
                                    $(document).Toasts('create', {
                                        class: 'bg-warning toast_width',
                                        title: 'Warning!',
                                        subtitle: 'close',
                                        body: 'Unexpected Error Occured. Catch Error'
                                    });
                                    return;
                                });
                        }

                        function initialStateFunction() {
                            var initialEmployees = document.querySelectorAll('#tbl_application_container tr');
                            initialEmployees.forEach(function(employeeRow) {
                                var groups = {};
                                var checkboxes = employeeRow.querySelectorAll('.check_single');
                                checkboxes.forEach(function(checkbox) {
                                    var groupName = checkbox.classList[1];
                                    groups[groupName] = checkbox.checked ? 1 : 0;
                                });
                                initialState.push({
                                    groups: groups
                                });
                            });
                        }
                        initialStateFunction();
                        document.getElementById('generateArrayButton').addEventListener('click', generateArrayAndCompare);
                    });
                </script>



                <div class="d-block d-lg-none col-sm-7 col-md-10 col-lg-5 justify-content-lg-end justify-content-center my-lg-0 my-2">
                    <div class="col-12 col-lg-7 d-flex justify-content-lg-end align-items-center mx-2">
                        <div class="d-flex align-items-center row">
                            <div class="d-inline col-12 col-lg-6">
                                <p class="pp-0 m-0 mx-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
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
                <div class="col-12 col-lg-1 d-flex d-lg-none justify-content-center align-items-center">
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
    </div><!--End fluid-->
    </div> <!-- Content Ends -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Custom Group First</h5>
                </div>
                <div class="modal-body">
                    You must add custom group with Active status first...
                </div>
                <div class="modal-footer">
                    <a href="<?= base_url() . 'employees'; ?>" class="btn btn-secondary">Back</a>
                    <a href="<?= base_url() . 'employees/settings_custom_groups'; ?>" class="btn btn-primary">Go To Custom Group Now</a>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($customGroups)) { ?>
        <script>
            $(document).ready(function() {

                // Trigger the modal to open
                $('#modalTriggerBtn').trigger('click');

                // Prevent the modal from being closed
                $('#exampleModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            });
        </script>
    <?php } ?>


    <?php $this->load->view('templates/jquery_link'); ?>

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

        function filter_clear() {
            document.location.href = "custom_group_assignment";
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

            $("#filter_by_status").on("change", function() {
                filter_data();
            })

            function filter_data(page_row) {
                if (page_row == null || page_row == "") {
                    page_row = '?page=' + "<?= $current_page ?>" + '&row=' + "<?= $row ?>"
                }
                let branch = $("#filter_by_branch").find(":selected").val();
                let company = $("#filter_by_company").find(":selected").val();
                let department = $("#filter_by_department").find(":selected").val();
                let division = $("#filter_by_division").find(":selected").val();
                let clubhouse = $("#filter_by_clubhouse").find(":selected").val();
                let section = $("#filter_by_section").find(":selected").val();
                let group = $("#filter_by_group").find(":selected").val();
                let team = $("#filter_by_team").find(":selected").val();
                let line = $("#filter_by_line").find(":selected").val();
                filterUrl = page_row + "&branch=" + branch +
                    "&dept=" + department + "&division=" + division + "&clubhouse=" + clubhouse +
                    "&section=" + section + "&group=" + group +
                    "&team=" + team + "&line=" + line + "&company=" + company;

                if (document.querySelector('.filter-container').classList.contains('visible')) {
                    filterUrl = filterUrl + '&filter=1';
                }
                window.location = base_url + "employees/custom_group_assignment" + filterUrl;
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