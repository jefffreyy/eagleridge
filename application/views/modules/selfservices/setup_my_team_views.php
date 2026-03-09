<?php $this->load->view('templates/css_link'); ?>
<?php
(isset($_GET['year'])) ? $year = $_GET['year'] : $year = $YEAR_INITIAL;
(isset($_GET['branch'])) ? $param_branch = $_GET['branch'] : $param_branch = "";
(isset($_GET['dept'])) ? $param_dept = $_GET['dept'] : $param_dept = "";
(isset($_GET['division'])) ? $param_division = $_GET['division'] : $param_division = "";
(isset($_GET['section'])) ? $param_section = $_GET['section'] : $param_section = "";
(isset($_GET['group'])) ? $param_group = $_GET['group'] : $param_group = "";
(isset($_GET['team'])) ? $param_team = $_GET['team'] : $param_team = "";
(isset($_GET['line'])) ? $param_line = $_GET['line'] : $param_line = "";
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
$C_DATA_COUNT -= 1; 
$prev_page = $current_page - 1;
$next_page = $current_page + 1;
$last_page = intval($C_DATA_COUNT / $row);
$last_page_initial = ceil($C_DATA_COUNT / $row);
$excess = $C_DATA_COUNT % $row;
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
?>

<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>companies">Company
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Setup My Teams
                    </li>
                </ol>
            </nav>

            <div class="row  pt-1"> 
                <div class="col-md-6">
                    <h1 class="page-title"><a href="<?= base_url() . 'selfservices/my_teams'; ?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Setup My Teams</h1>
                </div>
                <div class="col-md-6 button-title">
                   
                </div>
            </div>
            <hr>
            <div class="row mb-4">
                <div class="col-md-2">
                    <p class="mb-1 text-secondary ">Year</p>
                    <select name="filter_year" id="filter_year" class="form-control">
                        <?php
                        
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
                    <a href=<?= base_url() . "selfservices/setup_my_teams" ?> id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
                </div>
            </div>

            <?php
            ?>
            <div class="card border-0 p-0 m-0">
                <div class="p-2">
                    <a href="#" class=" btn technos-button-gray shadow-none rounded" id="update" data-toggle="modal" data-target="#modela_update"><i class="far fa-check-circle"></i>&nbsp;Bulk Assign</a>
                    <a href="#" class=" btn technos-button-gray shadow-none rounded" id="remove" data-toggle="modal" data-target="#modela_update"><i class="fa-regular fa-circle-xmark"></i>&nbsp;Bulk Remove</a>
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
                            <li><a class="page_row" href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                            <li><a class="page_row" style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
                        </ul>
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

                <div class="table-responsive">
                    <table class="table table-bordered m-0" id="TableToExport">
                        <thead>
                            <th class="text-center"><input type="checkbox" name="check_all" id="check_all"></th>
                            <th class="text-center">Employee</th>
                            <th class="text-center">Position</th>
                            <th>Reporting to</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="cutoff_container">
                            <?php if ($DISP_EMP_LIST) {
                                foreach ($DISP_EMP_LIST as $DISP_EMP_LIST_ROW) {
                                    if ($DISP_EMP_LIST_ROW->id != $this->session->userdata('SESS_USER_ID')) {
                            ?>
                                        <tr>
                                            <td class="text-center" id="select_item">
                                                <input type="checkbox" reporting_to="<?= $DISP_EMP_LIST_ROW->reporting_to ?>" name="brand" class="check_single" empl_name="<?= $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name ?>" value="<?= $DISP_EMP_LIST_ROW->id ?>">
                                            </td>
                                            <td>
                                                <?= $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name ?>
                                            </td>
                                            <td><?= $DISP_EMP_LIST_ROW->position ?></td>
                                            <td>
                                                <?php foreach ($ALL_EMPLOYEES as $Employee) { ?>
                                                    <?php if ($Employee->id == $DISP_EMP_LIST_ROW->reporting_to) { ?>
                                                        <span>
                                                            <?= $Employee->col_empl_cmid . ' - ' . $Employee->col_last_name . ', ' . $Employee->col_frst_name ?>
                                                        </span>
                                                <?php }
                                                } ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($DISP_EMP_LIST_ROW->reporting_to != $this->session->userdata('SESS_USER_ID')) { ?>
                                                    <a employee="<?= $DISP_EMP_LIST_ROW->id ?>" action='update' class="d-block employee w-100 btn btn-sm technos-button-green">Add</a>
                                                <?php } else { ?>
                                                    <a employee="<?= $DISP_EMP_LIST_ROW->id ?>" action='remove' class="d-block employee w-100 btn btn-sm btn-danger text-light">Remove</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                <?php }
                                }
                            } else {
                                ?>
                                <tr class="table-active">
                                    <td colspan="12">
                                        <center>No Data</center>
                                    </td>
                                </tr>
                            <?php  } ?>
                    
                        </tbody>
                    </table>
                    <div class="w-100 text-center">
                        <img src="<?= base_url() ?>images/loader2.gif" id="loader_gif" style="width: 180px; height: 120px; display: none;">
                    </div>
                </div>
            </div>
        </div>
    </div>
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

                <form id='update_form' action="<?= base_url() . 'selfservices/update_my_teams'; ?>" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul id="update_list_id" class="row" style="background: #e7f4e4;"></ul>
                            </div>
                        </div>
                        <input type='hidden' name='employee_ids' id='employee_ids'>
                        <input type='hidden' name='action' id='action_form'>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class='btn btn-primary text-light' id="save_button">&nbsp; Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php $this->load->view('templates/jquery_link'); ?>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            var base_url = '<?= base_url(); ?>';
            $('select.employees').select2(); 
            $('select#reporting_to').select2();
            $('#row_dropdown').on('change', function(e) {
                e.preventDefault()
                var row_val = $(this).val();
                let data = "?page=1&row=" + row_val;
                filter_data(data);
            });
            $('a.employee').on('click', function() {
                $('input#employee_ids').val($(this).attr('employee'));
                $('#action_form').val($(this).attr('action'));
                $('#update_form').submit();
            })
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
                let year = $("#filter_year").find(":selected").val();
                let branch = $("#filter_by_branch").find(":selected").val();
                let department = $("#filter_by_department").find(":selected").val();
                let division = $("#filter_by_division").find(":selected").val();
                let section = $("#filter_by_section").find(":selected").val();
                let group = $("#filter_by_group").find(":selected").val();
                let team = $("#filter_by_team").find(":selected").val();
                let line = $("#filter_by_line").find(":selected").val();
                window.location = base_url + "selfservices/setup_my_teams" + page_row + "&branch=" + branch +
                    "&dept=" + department + "&division=" + division +
                    "&section=" + section + "&group=" + group +
                    "&team=" + team + "&line=" + line +
                    "&year=" + year;
            }
            $('#update,#remove').click(function() {
                let selected_id = [];
                let att_empl_names = [];
                let action = $(this).attr('id');
                let user = "<?= $this->session->userdata('SESS_USER_ID') ?>"
                $('#action_form').val(action);
                $('#UPDATE_ID').empty();
                $('#update_list_id').empty();
                $('#select_item input[type=checkbox]:checked').each(function() {
                    if ((action == 'remove' && $(this).attr('reporting_to') == user) || action == 'update') {
                        let selected_item = $(this).val();
                        let att_empl_name = $(this).attr('empl_name');
                        selected_id.push(selected_item);
                        att_empl_names.push(att_empl_name);
                    }
                    if (action == 'remove' && $(this).attr('reporting_to') != user) {
                        $(this).prop('checked', false)
                    }
                })
                if (selected_id.length > 0) {
                    $('.class_modal_update_list').prop('id', 'modela_update');
                    $('#UPDATE_ID').val(selected_id);
                    att_empl_names.forEach(function(data) {
                        $('#update_list_id').append(`<li class="col-md-6"> <strong>${data}</strong></li>`);
                    })
                    $('input#employee_ids').val(selected_id.join(','));
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
        })
    </script>
    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <script>
        document.getElementById("btn_export").addEventListener('click', function() {
            var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
            XLSX.writeFile(wb, "Leave Entitlement.xlsx");
        });
    </script>
</body>

</html>