<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />

<?php
(isset($_GET['branch'])) ? $param_branch = $_GET['branch'] : $param_branch = "";
(isset($_GET['company'])) ? $param_company = $_GET['company'] : $param_company = "";
(isset($_GET['dept'])) ? $param_dept = $_GET['dept'] : $param_dept = "";
(isset($_GET['division'])) ? $param_division = $_GET['division'] : $param_division = "";
(isset($_GET['section'])) ? $param_section = $_GET['section'] : $param_section = "";
(isset($_GET['group'])) ? $param_group = $_GET['group'] : $param_group = "";
(isset($_GET['team'])) ? $param_team = $_GET['team'] : $param_team = "";
(isset($_GET['line'])) ? $param_line = $_GET['line'] : $param_line = "";
if (isset($_GET['search'])) {$search = $_GET['search']; } else { $search = ""; }

// $search_data = $this->input->get('all');
// $search_data = str_replace("_", " ", $search_data ?? '');

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

?>

<style>
    .icon-center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }
</style>
<body>
    <!-- Content Starts -->
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <div class="row  pt-1"> <!-- Title starts -->
                <div class="col-md-6">
                    <h1 class="page-title"><a href="<?= base_url() . 'employees'; ?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Salary Details</h1>
                </div>
            </div><!-- Title Ends -->

            <hr>
            <div class="row mb-4"><!-- Filter Starts -->
                

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
                <div class="col-md-2">
                    <p class="mb-1 text-secondary ">Action</p>
                    <a href=<?= base_url() . "employees/salary_details" ?> id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
                </div>

            </div><!-- Filter Ends -->

            <div class="card border-0 p-0 m-0">
                <!-- <div class="p-1">
                    <div class="col-md-4 pl-0">
                        <div class="input-group p-1 pt-2">
                        <?php 
                            if($search_data){ ?>
                            <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fa-regular fa-broom-wide" style="margin-top: 4px"></i>&nbsp;Clear</button>
                        <?php } else{?>
                            <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
                        <?php } ?>
                        
                        <input type="text" class="form-control" placeholder="Search..." value="<?= ($search_data) ? $search_data : ""; ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div> -->
                <div class="col-md-2" <?php echo ( true? "" : "hidden") ?>>
                    <p class="mb-1 text-secondary ">Search</p>
                    <select id="search_select" class="form-control">
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
                </div>
                <div class="card border-0 p-0 m-0">
                    <div class="p-2">
                        <button class="btn btn-primary" id="btn-update"><i class="fa-solid fa-circle-arrow-up"></i>&nbsp;Update Changes</button>
                        <!-- <a href="#" class=" btn technos-button-gray shadow-none rounded" id="update" data-toggle="modal" data-target="#modela_update"><i class="far fa-check-circle"></i>&nbsp;Bulk Assign</a> -->

                        <div class="float-right ">
                            <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                            <ul class="d-inline pagination m-0 p-0 ">
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
                            <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>

                            <select id="row_dropdown" class="custom-select" style="width: auto;">
                            <?php
                                foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) {?>
                                    <option value=<?= $C_ROW_DISPLAY_ROW?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW?> </option>
                                <?php
                            } ?>
                            </select>
                        </div>
                    </div>
                            
                    <div id="table_data"> </div>

                    <!-- <div class="table-responsive">
                        <table class="table table-bordered m-0" id="TableToExport" style="width:100%">
                            <thead>
                                <th class="text-center"><input type="checkbox" name="check_all" id="check_all"></th>
                                <th class="text-center ">Employee</th>
                                <th class="text-center " style="background:#f6d6ff;">Salary Amount</th>
                                <th class="text-center " style="background:#feffd6;">Salary Type</th>
                                <th class="text-center " >History</th>
                            
                            </thead>
                            <tbody id="cutoff_container">
                                <?php if ($DISP_EMP_LIST) {
                                    foreach ($DISP_EMP_LIST as $DISP_EMP_LIST_ROW) { ?>
                                        <tr>
                                            <td class="text-center" id="select_item">
                                                <input type="checkbox" name="brand" class="check_single" empl_name="<?= $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name ?>" value="<?= $DISP_EMP_LIST_ROW->id ?>">
                                            </td>
                                            <td>
                                                <?= $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ' ' . $DISP_EMP_LIST_ROW->col_frst_name ?>
                                            </td>
                                    
                                            <td style="padding: 1px;">
                                                <form class="bg-transparent" style="padding: 1px;">
                                                    <input type="hidden" id="employee_data" name="employee_data" value="<?= $DISP_EMP_LIST_ROW->id ?>">
                                                    <input type="number" class="form-control salary_val" default="<?=number_format((float)$DISP_EMP_LIST_ROW->salary_rate, 2, '.', '')?>" id="salary_val" name="salary_val" pattern="^\d*(\.\d{0,2})?$" step="0.01"  value="<?= number_format((float)$DISP_EMP_LIST_ROW->salary_rate, 2, '.', '')  ?>" >
                                                </form>
                                            </td>
                                            <td style="padding: 1px;">
                                                <input type="hidden" id="employee_data" name="employee_data" value="<?= $DISP_EMP_LIST_ROW->id ?>">
                                                <select name="salary_type" id="salary_type" class="form-control salary_type" style="padding: 1px;">
                                            
                                                <?php if ($DISP_EMP_LIST_ROW->salary_type == "Monthly") {?>
                                                    <option value="Monthly" selected>Monthly</option>
                                                    <option value="Daily">Daily</option>
                                                <?php } elseif ($DISP_EMP_LIST_ROW->salary_type == "Daily") {?>
                                                    <option value="Monthly">Monthly</option>
                                                    <option value="Daily" selected>Daily</option>
                                                <?php }  ?>
                                                                                            
                                                </select>
                                            </td>
                                            <td class="text-center">
                                            <a href="<?= base_url() . 'employees/salary_history/' . $DISP_EMP_LIST_ROW->id; ?>"  class="select_edit_row" style="background-color: transparent; border: none;color: gray; cursor: pointer; !important" row_id="12"><i class="far fa-eye" id="view" aria-hidden="true"></i></a>
                                            </td>
                                        
                                        <?php } ?>
                                        </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                        <div class="w-100 text-center">
                            <img src="<?= base_url() ?>images/loader2.gif" id="loader_gif" style="width: 180px; height: 120px; display: none;">
                        </div>
                    </div> -->

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
                                    <label class="required" for="UPDT_SALARY_AMOUNT">Salary Amount</label>
                                    <input class="form-control" type="number" class="UPDT_SALARY_AMOUNT" id="updt_salary_amount" name="UPDT_SALARY_AMOUNT" pattern="^\d*(\.\d{0,2})?$" step="0.01">
                                </div>

                                <div class="form-group">
                                    <label class="required" for="UPDT_SALARY_TYPE">Salary Type</label>
                                    <select name="UPDT_SALARY_TYPE" id="updt_salary_type" class="form-control">
                                        <option value="Monthly">Monthly</option>
                                        <option value="Daily" >Daily</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="UPDATE_ID" id="UPDATE_ID">
                        <button type="submit" class='btn btn-primary text-light'id="save_button">&nbsp; Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHistory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <!-- <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Welcome Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div> -->
            <div class="modal-body">
            Change Salary Type Histor Under Construction
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <?php $this->load->view('templates/jquery_link'); ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

    <?php 
    if($this->session->userdata('SESS_SUCCESS')){ ?>

    <script>
            $(document).Toasts('create', {
                class: 'bg-success toast_width',
                title: 'Success',
                subtitle: 'close',
                body: '<?= $this->session->userdata('SESS_SUCCESS'); ?>'
            })
        </script>
        
    <?PHP 
    $this->session->unset_userdata('SESS_SUCCESS');
    } ?>
  
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
            }else{
                window.location.href = "?search=" + search_select.replace(/\s/g, '_');
            }
        }
        function filter_clear(){
            document.location.href = "setup_organization";
        }
    </script>

    <script>
        var url = '<?=base_url()?>';
        var employee_list = <?= json_encode($DISP_EMP_LIST_TABLE); ?>;
        // console.log('employee_list',employee_list);
        var DISP_EMP_LIST_SEARCH = <?= json_encode($DISP_EMP_LIST_SEARCH); ?>;
        // console.log('DISP_EMP_LIST_SEARCH',DISP_EMP_LIST_SEARCH);
        var data = "";
       
        let employeeIdsCopywithCMID =[];
        const employeeIds = DISP_EMP_LIST_SEARCH.map(obj => {
            const employeeNameWithCMID = obj.name;
                employeeIdsCopywithCMID.push({
                employeeNameWithCMID: obj.name,
                cmid:obj.col_empl_cmid
            })
            return employeeNameWithCMID;
        });
        // console.log('employeeIdsCopywithCMID',employeeIdsCopywithCMID)
        // console.log('employeeIds',employeeIds)
        if(employee_list){
            data = employee_list;
        }else{
            $default = [ {fullname: "", extra_posi:"", reportingto: ""} ];
        }

        const container = document.querySelector('#table_data');
        hot = new Handsontable(container, {
            data: data,
            colHeaders: [ 'id','Employee', 'Other Description', 'Assign To'],
            rowHeaders: true,
            height: 'auto',
            outsideClickDeselects: false,
            selectionMode: 'multiple',
            licenseKey: 'non-commercial-and-evaluation',
            stretchH: 'all',
            hiddenColumns: {
                columns: [0],
                // indicators: true,
            },
            columns : [
                {
                    data: 'id',
                    readOnly: true
                },
                {
                    data: 'fullname',
                    readOnly: true
                },
                {
                    data: 'extra_posi',
                    readOnly: true
                },
                {data:'reportingto',readOnly: false, type: 'dropdown', source: employeeIds, width: 240},
            ]
        })


        var update_date = document.getElementById('btn-update');
    
        update_date.addEventListener('click', function() {
            const confirmed = confirm('Are you sure you want to update the data?');
            if (!confirmed) {
                return; 
            }

            // const updatedData = hot.getData();
        //    console.log('updatedData', updatedData);
        let invalidId = false;
        const updatedData = hot.getData();
        updatedData.map((item, i)=>{
          if(item[3]){
            const check = employeeIdsCopywithCMID.find(obj => obj.employeeNameWithCMID === item[3]);
            if (check) {
              item[3]=check.cmid;
            } 
            else {
                invalidId = true
            }
          }
        })
        console.log('updatedData', updatedData);
        // console.log('invalidId', invalidId);
        if(invalidId){
          return $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: 'Invalid ID Detected, check Approvers in Red Font or the Approvers already terminated'
          })
        }

            fetch(url + 'employees/update_setup_organization', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(updatedData)
            })
            .then(response => response.json())
            .then(result => {
                console.log(result);

                if(result.success_message){
                    $(document).Toasts('create', {
                        class: 'bg-success toast_width',
                        title: 'Success!',
                        subtitle: 'close',
                        body: result.success_message
                    })
                }

                if(result.warning_message){
                    $(document).Toasts('create', {
                        class: 'bg-warning toast_width',
                        title: 'Warning!',
                        subtitle: 'close',
                        body: result.warning_message
                    })
                }

            })
            .catch(error => {
                $(document).Toasts('create', {
                    class: 'bg-warning toast_width',
                    title: 'Warning!',
                    subtitle: 'close',
                    body: 'Please provide all required information.'
                })
            console.error('Data update error:', error);
            });

            // setTimeout(function() {
            //   location.reload();
            // }, 1200)
        
        });

    </script>


    <script>
        $(document).ready(function() {

            $('#filter_by_branch').select2();
            $('#filter_by_company').select2();
            $('#filter_by_department').select2();
            $('#filter_by_division').select2();
            $('#filter_by_section').select2();
            $('#filter_by_group').select2();
            $('#filter_by_team').select2();
            $('#filter_by_line').select2();

            var base_url = '<?= base_url(); ?>';

            $('#row_dropdown').on('change', function (e) {
                e.preventDefault()
                var row_val = $(this).val(); 
                let data = "?page=1&row=" + row_val;
                filter_data(data);
                // document.location.href = base_url + "employees/taxable_allowance_assign?page=1&row=" + row_val ; 
            });

            $('.page_row').on('click',function(e){
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

                if(page_row == null || page_row == ""){
                   page_row ='?page='+"<?=$current_page?>"+'&row='+"<?=$row?>"
                }

                let branch = $("#filter_by_branch").find(":selected").val();
                let company = $("#filter_by_company").find(":selected").val();
                let department = $("#filter_by_department").find(":selected").val();
                let division = $("#filter_by_division").find(":selected").val();
                let section = $("#filter_by_section").find(":selected").val();
                let group = $("#filter_by_group").find(":selected").val();
                let team = $("#filter_by_team").find(":selected").val();
                let line = $("#filter_by_line").find(":selected").val();

                window.location = base_url + "employees/salary_details"+page_row+"&branch=" + branch +
                    "&dept=" + department + "&division=" + division +
                    "&section=" + section + "&group=" + group +
                    "&team=" + team + "&line=" + line + "&company=" + company ;
            }

            // $('.salary_val').on('change', function() {
            
            $('.salary_val').on('keydown', function(event) {
                if (event.key === "Enter") {
                    event.preventDefault(); 
                    let default_val=    $(this).attr('default');
                    let employee_id = $(this).siblings("#employee_data").val();
                    let salary_val = $(this).val();
                    if(default_val!=salary_val){
                        window.location = base_url + "employees/process_salary_update/" + employee_id + "/" + salary_val ;
                    }
                }
            })
            $('.salary_val').on('focusout', function(event) {
                event.preventDefault(); 
                let default_val=    $(this).attr('default');
                let employee_id = $(this).siblings("#employee_data").val();
                let salary_val = $(this).val();
                if(default_val!=salary_val){
                    window.location = base_url + "employees/process_salary_update/" + employee_id + "/" + salary_val ;
                }
                
            })

            $('.salary_type').on('change', function() {
                let employee_id = $(this).siblings("#employee_data").val();
                let type_val = $(this).val();

                window.location = base_url + "employees/process_salary_type_update/" + employee_id + "/" + type_val ;
            })

            $('.openModalHistory').click(function(e) {
                var tdName = $(this).attr('name');
                console.log('Name of td:', tdName);
            });
            
            // $('#modalHistory').modal('show');
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



    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <script>
        // document.getElementById("btn_export").addEventListener('click', function() {
        //     /* Create worksheet from HTML DOM TABLE */
        //     var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
        //     /* Export to file (start a download) */
        //     XLSX.writeFile(wb, "Leave Entitlement.xlsx");
        // });
    </script>
</body>

</html>