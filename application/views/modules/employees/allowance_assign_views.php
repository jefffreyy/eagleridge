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

?>


<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>employees">Employee</a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page">Allowance Assignment
                    </li>
                </ol>
            </nav>

            <div class="row  pt-1">
                <div class="col-md-6">
                    <h1 class="page-title">Allowance Assignment</h1>
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
                    <a href=<?= base_url() . "employees/allowance_assign" ?> id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
                </div>
            </div>

            <?php
            ?>

            <div class="card border-0 p-0 m-0">
                <div class="p-2">
                    <a href="#" class=" btn technos-button-gray shadow-none rounded" id="update" data-toggle="modal" data-target="#modela_update"><i class="far fa-check-circle"></i>&nbsp;Bulk Entitlement Assign</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered m-0" id="TableToExport" style="width:100%">
                        <thead>
                            <th class="text-center"><input type="checkbox" name="check_all" id="check_all"></th>
                            <th class="text-center emp">Employee</th>
                            <?php foreach ($DISP_ALLOWANCE_TYPES as $DISP_ALLOWANCE_TYPES_ROW) { ?>
                                <th class="text-center std"><?= $DISP_ALLOWANCE_TYPES_ROW->name ?></th>
                            <?php } ?>
                        </thead>

                        <tbody id="cutoff_container">
                            <?php if ($DISP_EMP_LIST) {
                                foreach ($DISP_EMP_LIST as $DISP_EMP_LIST_ROW) { ?>
                                    <tr>
                                        <td class="text-center" id="select_item">
                                            <input type="checkbox" name="brand" class="check_single" empl_name="<?= $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name ?>" value="<?= $DISP_EMP_LIST_ROW->id ?>">
                                        </td>

                                        <td>
                                            <?= $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name ?>
                                        </td>

                                        <?php
                                        foreach ($DISP_ALLOWANCE_TYPES as $DISP_ALLOWANCE_TYPES_ROW) {
                                            $entitlement_value = 0;

                                            if ($DISP_ALLOWANCE) {
                                                foreach ($DISP_ALLOWANCE as $DISP_ALLOWANCE_ROW) {
                                                    $entitlement_value = 0;
                                                    if ($DISP_ALLOWANCE_ROW->username == $DISP_EMP_LIST_ROW->id && $DISP_ALLOWANCE_TYPES_ROW->id == $DISP_ALLOWANCE_ROW->name) {
                                                        $entitlement_value = $DISP_ALLOWANCE_ROW->value;
                                                        break;
                                                    }
                                                }
                                            }
                                        ?>
                                            <td>
                                                <form class="bg-transparent">
                                                    <input type="hidden" id="employee_data" name="employee_data" value="<?= $DISP_EMP_LIST_ROW->id ?>">
                                                    <input type="hidden" id="type_data" name="type_data" value=<?= $DISP_ALLOWANCE_TYPES_ROW->id  ?>>
                                                    <input type="text" class="entitlement_val" id="entitlement_val" name="entitlement_val" pattern="[0-9]*" value=<?= $entitlement_value ?> style="width:100%;">
                                                </form>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php }
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
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Update Bulk</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="<?= base_url() . 'employees/update_allowance'; ?>" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul id="update_list_id" class="row" style="background: #e7f4e4;"></ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" for="UPDT_ALLOWANCE_TYPE">Leave Type</label>
                                    <input type="hidden" name="UPDT_ENTITLEMENT_YEAR" id="UPDT_ENTITLEMENT_YEAR" value=<?= $year ?>>
                                    <select name="UPDT_ALLOWANCE_TYPE" id="updt_allowance_type" class="form-control">
                                        <?php
                                        foreach ($DISP_ALLOWANCE_TYPES as $DISP_ALLOWANCE_TYPES_ROW) {
                                        ?>
                                            <option value="<?= $DISP_ALLOWANCE_TYPES_ROW->id ?>"><?= $DISP_ALLOWANCE_TYPES_ROW->name; ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="required" for="UPDT_ALLOWANCE_VAL">Value</label>
                                    <input class="form-control" type="number" class="UPDT_ALLOWANCE_VAL" id="updt_allowance_val" name="UPDT_ALLOWANCE_VAL" pattern="[0-9]*">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="YEAR" id="YEAR" value="<?= $year ?>">
                        <input type="hidden" name="UPDATE_ID" id="UPDATE_ID">
                        <button type="submit" class='btn btn-primary text-light' id="save_button">&nbsp; Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>
    <script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js"></script>
    <script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
    <script src="<?php echo base_url(); ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>plugins/tablesorter-master/dist/js/jquery.tablesorter.min.js"></script>


    <script>
        $(document).ready(function() {

            var base_url = '<?= base_url(); ?>';

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

            function filter_data() {
                let year        = $("#filter_year").find(":selected").val();
                let branch      = $("#filter_by_branch").find(":selected").val();
                let department  = $("#filter_by_department").find(":selected").val();
                let division    = $("#filter_by_division").find(":selected").val();
                let section     = $("#filter_by_section").find(":selected").val();
                let group       = $("#filter_by_group").find(":selected").val();
                let team        = $("#filter_by_team").find(":selected").val();
                let line        = $("#filter_by_line").find(":selected").val();

                window.location = base_url + "employees/allowance_assign?branch=" + branch +
                    "&dept=" + department + "&division=" + division +
                    "&section=" + section + "&group=" + group +
                    "&team=" + team + "&line=" + line +
                    "&year=" + year;
            }

            $('.entitlement_val').on('change', function() {
                let employee = $(this).siblings("#employee_data").val();
                let type = $(this).siblings("#type_data").val();
                let allowance_val = $(this).val();
                let year = $("#filter_year").find(":selected").val();

                window.location = base_url + "employees/process_assigning/" + employee + "/" + allowance_val + "/" + year + "/" + type;
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