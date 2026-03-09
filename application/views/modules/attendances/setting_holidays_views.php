<?php $this->load->view('templates/companycontribution_style'); ?>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?= base_url('assets_system/css/handsontable14.css') ?>" />

<?php
// $search_data = $this->input->get('all');
// $search_data = str_replace("_", " ", $search_data ?? '');
// if (isset($_GET['row'])) {
//     $row = $_GET['row'];
// } else {
//     $row = $default_row;
// }
if (isset($_GET['tab'])) {
    $tab = $_GET['tab'];
} else {
    $tab = $C_TAB_SELECT;
}
// if (isset($_GET['page'])) {
//     $current_page = $_GET['page'];
// } else {
//     $current_page = 1;
// }
// $prev_page = $current_page - 1;
// $next_page = $current_page + 1;
// // $last_page = intval($C_DATA_COUNT/$row) + 1;
// $last_page_initial = ceil($C_DATA_COUNT / $row);
// $last_page = ($last_page_initial == 0 || $last_page_initial == 1) ? 1 : $last_page_initial;

// if ($C_DATA_COUNT == 0) {
//     $low_limit = 0;
// } else {
//     $low_limit = $row * ($current_page - 1) + 1;
// }
// if ($current_page * $row > $C_DATA_COUNT) {
//     $high_limit = $C_DATA_COUNT;
// } else {
//     $high_limit = $row * ($current_page);
// }
?>

<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="flex-fill">

            <div class="row p-0">
                <div class="col-md-6">
                    <h1 class="page-title"><a href="<?= base_url() . 'attendances'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;Attendance Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>

            <div class="mx-auto card d-block d-lg-none col-11">
                <div class="form-group row d-flex justify-content-center">
                    <label for="" class="col-10">Navigate Settings</label>
                    <select name="" class="form-control col-10" id="settingsDropdown">
                        <option value="general" >
                            General
                        </option>
                        <option value="holidays" selected>
                            Holidays
                        </option>
                        <option value="years">
                            Years
                        </option>
                        <option value="biometrics">
                            Biometrics
                        </option>
                        <option value="remote_in_out">
                            Remote In Out
                        </option>
                        <option value="geofences">
                            Geofences
                        </option>

                    </select>
                </div>
            </div>

            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
                <div class="card col-xl-8 col-lg-4 col-md-8 col-11" style="min-height:700px ">
                    <div class="row">
                        <div class="col-md-3 d-none d-lg-inline-block">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?php $this->load->view('templates/settings_time_and_attendance_nav_views'); ?>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row mx-2">
                                <div class="col-md-12 ">
                                    <span style="font-weight: 500; font-size: 18px">Holidays</span>
                                </div>

                                <div class="col-md-12">
                                    <!-- <i>Note: LWOP, Offset, Vacation, Sick Leaves are permanent leave types.</i> -->
                                </div>
                            </div>
                            <hr>
                            <!-- <div class="card-header p-0">
                                <div class="row">
                                    <div class="col-xl-12">

                                        <ul class="nav nav-tabs">
                                            <?php
                                            foreach ($C_DATA_TAB as $C_DATA_TAB_ROW) { ?>
                                                <li class="nav-item">
                                                    <a class="nav-link head-tab <?php echo ($C_DATA_TAB_ROW[0] == $tab) ? ' active' : ''; ?>" id="tab-<?= $C_DATA_TAB_ROW[0] ?>" href="?page=1&row=<?= $row ?>&tab=<?= $C_DATA_TAB_ROW[0] ?>&tab_filter=<?= $C_DATA_TAB_ROW[1] ?>"><?= $C_DATA_TAB_ROW[0] ?><span class="ml-2 badge badge-pill badge-secondary"><?= $C_DATA_TAB_ROW[3] ?></span></a>
                                                </li>
                                            <?php
                                            } ?>
                                        </ul>
                                    </div>
                                    <div class="col-xl-5">
                                        <?php if (!isset($EMPLOYEE_LIST)) { ?>
                                            <div class="input-group pb-1 ">
                                                <?php
                                                if ($search_data) { ?>
                                                    <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none d-flex align-items-center" <?php if (!$add_button[0])  echo "hidden"; ?>><img src="<?= base_url('assets_system/icons/broom-wide-sharp-solid.svg') ?>" alt="">
                                                        &nbsp;Clear</button>
                                                <?php } else { ?>
                                                    <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none d-flex align-items-center" <?php if (!$add_button[0])  echo "hidden"; ?>><img src="<?= base_url('assets_system/icons/magnifying-glass-solid.svg') ?>" alt="">
                                                        &nbsp;Search</button>
                                                <?php } ?>

                                                <input type="text" class="form-control" placeholder="Search" id="search_data" value="<?= ($search_data) ? $search_data : ""; ?>" aria-label="Username" aria-describedby="basic-addon1">
                                            </div>
                                        <?php } else { ?>
                                            <div class="input-group m-2 ml-auto" style="width:max-content">
                                                <div class="input-group-prepend">
                                                    <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none d-flex align-items-center"><img src="<?= base_url('assets_system/icons/magnifying-glass-solid.svg') ?>" alt="">
                                                        &nbsp;Search</button>
                                                </div>
                                                <select class="select-employee d-block" id="search_data" style="min-width:300px;width:max-content">
                                                    <option value=''>All</option>
                                                    <?php foreach ($EMPLOYEE_LIST as $employee) {
                                                        $name = $employee->col_empl_cmid . "-" . $employee->col_last_name;
                                                        if (!empty($employee->col_suffix)) $name = $name . " " . $employee->col_suffix;
                                                        if (!empty($employee->col_frst_name)) $name = $name . ", " . $employee->col_frst_name;
                                                        if (!empty($employee->col_midl_name)) $name = $name . " " . $employee->col_midl_name[0] . '.';
                                                    ?>
                                                        <option value="<?= $employee->id ?>" <?= $search_data == $employee->id ? 'selected' : '' ?>>
                                                            <?= $name
                                                            // $employee->col_empl_cmid."-".$this->system_functions->fomatName($employee->col_last_name,$employee->col_frst_name,$employee->col_midl_name)
                                                            ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div> -->

                            <!-- pagination -->
                            <!-- <div class="row p-2">
                                <div>
                                    <?php
                                    foreach ($C_BULK_BUTTON as $C_BULK_BUTTON_ROW) {
                                        $buttonClass = isset($C_BULK_BUTTON_ROW[6]) ? $C_BULK_BUTTON_ROW[6] : 'technos-button-gray';
                                    ?>
                                    
                                        <button style="height: 36px;" id=<?= $C_BULK_BUTTON_ROW[1] ?> class="btn <?= $buttonClass ?> shadow-none rounded bulk-button " data-toggle="modal" data-id=<?= $C_BULK_BUTTON_ROW[5] ?> data-target="#modal_set_ssa" <?php if (!$C_BULK_BUTTON_ROW[0])  echo "hidden"; ?> status=<?= $C_BULK_BUTTON_ROW[3] ?>><img style="height: 1rem; width: 1rem; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/' . $C_BULK_BUTTON_ROW[2])  ?> " alt=""></i>&nbsp;<?= $C_BULK_BUTTON_ROW[3] ?></button>
                                    <?php
                                    } ?>
                                    <div class="float-right ">
                                        <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                                        <ul class="d-inline pagination m-0 p-0 ">
                                            <li><a <?php if ($current_page > 1)                echo "href='?page=$prev_page&row=$row&tab=$tab'"; ?>>
                                                    < </a>
                                            </li>
                                            <li><a href="?page=1&row=<?= $row ?>&tab=<?= $tab ?>" <?php if ($current_page == 1)               echo "hidden";                  ?>>1 </a></li>
                                            <li><a <?php if ($current_page <= 2)               echo "hidden";                  ?>>... </a></li>
                                            <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&tab=<?= $tab ?>" <?php if ($current_page <= 2)               echo "hidden";                  ?>><?= $prev_page ?> </a></li>
                                            <li><a style="color:white ; background-color:#007bff !important"><?= $current_page ?> </a></li>
                                            <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&tab=<?= $tab ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";                  ?>><?= $next_page ?> </a></li>
                                            <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden";                  ?>>... </a></li>
                                            <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&tab=<?= $tab ?>" <?php if ($current_page == $last_page)      echo "hidden";                  ?>><?= $last_page ?> </a></li>
                                            <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)       echo "href='?page=$next_page&row=$row&tab=$tab'"; ?>>> </a></li>
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
                            </div> -->

                            <div class="col-12 justify-content-center mt-3">
                                <div class="col-12 col-md-4 mb-3">
                                    <p class="mb-1 text-secondary ">Year</p>
                                    <select name="filter_year" id="filter_year" class="form-control">
                                        <?php
                                        // var_dump($DISP_YEARS);
                                        if ($DISP_YEARS) {
                                            foreach ($DISP_YEARS as $DISP_YEARS_ROW) {
                                        ?>
                                                <option value="<?= $DISP_YEARS_ROW->name ?>" <?php echo ($tab == $DISP_YEARS_ROW->name ? 'selected' : '') ?>>
                                                    <?= $DISP_YEARS_ROW->name ?>
                                                </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 col-md-12 mb-3 ">
                                    <button class="mb-1 mb-lg-0 d-block d-lg-inline btn btn-success pt-1 pb-1" id="btn-add-row" style="font-size: 14px"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-plus-solid_xs.svg') ?>">&nbsp;Add Row</button>
                                    <button class="mb-1 mb-lg-0 d-block d-lg-inline btn btn-danger pt-1 pb-1" id="btn-delete-row" style="font-size: 14px"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-minus-solid_xs.svg') ?>">&nbsp;Delete Row</button>
                                    <button class="mb-1 mb-lg-0 d-block d-lg-inline btn btn-primary pt-1 pb-1" id="btn-update" style="font-size: 14px"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>">&nbsp;Save Record</button>
                                </div>


                                <div class="col-md-12">
                                    <div id="data_table"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<aside class="control-sidebar control-sidebar-dark">
</aside>
<?php $this->load->view('templates/jquery_link'); ?>
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
<script type="text/javascript" src="<?= base_url('assets_system/js/handsontable14.js') ?>"></script>

<!-- <script>

</script> -->

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

<script>
    $(document).ready(function() {

        $('#filter_year').select2();
        $("#filter_year").on("change", function() {
            // var tab_val = "<?php echo $tab ?>";
            // console.log('tab_val', tab_val);
            let year = $("#filter_year").find(":selected").val();
            window.location = "?tab=" + year;
        })

        // $('#check_all').click(function() {
        //     if (this.checked == true) {
        //         Array.from($('.check_single')).forEach(function(element) {
        //             $(element).prop('checked', true);
        //             $('.check_single').parent().parent().css('background', '#e7f4e4');
        //         })
        //     } else {
        //         Array.from($('.check_single')).forEach(function(element) {
        //             $(element).prop('checked', false);
        //             $('.check_single').parent().parent().css('background', '');
        //         })
        //     }
        // })
        // $('.check_single').on('change', function() {
        //     if (this.checked == true) {
        //         $(this).parent().parent().css('background', '#e7f4e4');
        //     } else {
        //         $(this).parent().parent().css('background', '');
        //     }
        // })

        // $("#search_btn").on("click", function() {
        //     $('#search_data').val();
        //     var optionValue = $('#search_data').val();
        //     var url = window.location.href.split("?")[0];
        //     if (window.location.href.indexOf("?") > 0) {
        //         window.location = url + "?page=1&all=" + optionValue.replace(/\s/g, '_');
        //     } else {
        //         window.location = url + "?page=1&all=" + optionValue.replace(/\s/g, '_');
        //     }
        // })

        // $("#clear_search_btn").on("click", function() {
        //     var url = window.location.href.split("?")[0];
        //     window.location = url
        // });

        // $("#search_btn").on("click", function() {
        //     search();
        // });

        // $("#search_data").on("keypress", function(e) {
        //     if (e.which === 13) {
        //         search();
        //     }
        // });

        // function search() {
        //     var tab_val = "<?php echo $tab ?>";
        //     var optionValue = $('#search_data').val();
        //     var url = window.location.href.split("?")[0];
        //     if (window.location.href.indexOf("?") > 0) {
        //         window.location = url + "?page=1&tab=" + tab_val + "&all=" + optionValue.replace(/\s/g, '_');
        //     } else {
        //         window.location = url + "?page=1&tab=" + tab_val + "&all=" + optionValue.replace(/\s/g, '_');
        //     }
        // }


        // $('.delete_data').click(function(e) {
        //     e.preventDefault();
        //     var user_deleteKey = $(this).attr('delete_key');
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, delete it!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             window.location.href = "<?= base_url(); ?>" + "main_table_02/delete_row?delete_id=" + user_deleteKey + "&table=" + table_name + "&module=" + module_name + "&page=" + page_name;
        //         }
        //     })
        // })

        // $('.edit_data_id').click(function(e) {
        //     e.preventDefault(); // Prevent the default click behavior
        //     var id = $(this).attr('row_id');
        //     $('#edit_id_data').val(id);
        //     // Submit the form
        //     $('#edit_data_id').submit();

        // });
    })
</script>

<script>
    var url = '<?= base_url() ?>';
    var parsedData = <?php echo $C_DATA_TABLE; ?>;
    // var parsedDatayearNames = <?php echo $yearNames; ?>;
    var copiedData = JSON.parse(JSON.stringify(parsedData));
    console.log('parsedData', parsedData)

    // var tableName = 'tbl_std_leavetypes';
    var hot;
    let column_headers = "";
    let columns = "";

    // Custom renderer to prevent text wrapping
    const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        // td.style.whiteSpace = 'nowrap';
        td.style.overflow = 'hidden';
        td.style.whiteSpace = 'normal';
    };
    const col_holi_typeSource = ['Regular Holiday', 'Special Non-Working Holiday'];
    const statusSource = ['Active', 'Inactive'];
    column_headers = ['Id', 'Date', 'Name', 'Type', 'Status'];
    columns = [{
            data: 'id'
        },
        // {data: 'col_holi_date'},
        {
            data: 'col_holi_date',
            type: 'date',
            dateFormat: 'DD/MM/YYYY',
        },
        {
            data: 'name'
        },
        // {data: 'col_holi_type'},
        // {data: 'year'},
        {
            data: 'col_holi_type',
            type: 'dropdown',
            source: col_holi_typeSource,
        },
        {
            data: 'status',
            type: 'dropdown',
            source: statusSource,
        },
    ]

    const container = document.querySelector('#data_table');
    hot = new Handsontable(container, {
        data: parsedData,
        colHeaders: column_headers,
        rowHeaders: true,
        stretchH: 'all',
        height: window.innerHeight - container.getBoundingClientRect().top - 30,
        rowHeights: 40,
        outsideClickDeselects: false,
        selectionMode: 'multiple',
        licenseKey: 'non-commercial-and-evaluation',
        renderer: customStyleRenderer,
        hiddenColumns: {
            columns: [0],
            indicators: true,
            // exclude hidden columns from copying and pasting
            copyPasteEnabled: false,
        },
        columns: columns,
        minRows: 1,
    });


    function generateYearDropdownSource() {
        const currentYear = new Date().getFullYear();
        const years = [];
        // range of years
        for (let i = currentYear; i >= currentYear - 3; i--) {
            years.push(i.toString());
        }
        return years;
    }

    // function setHeightTo500px() {
    //     const currentHeight = hot.rootElement.clientHeight;
    //     if (currentHeight >= 500) {
    //         hot.updateSettings({
    //             height: 500
    //         });
    //     }
    // }

    // add row ===========================================================================
    // const addRowButton = document.getElementById('btn-add-row');
    // addRowButton.addEventListener('click', function() {
    //     const selected = hot.getSelected() || [];

    //     if (selected.length === 0) {
    //         alert('Please select a row to add a new row below.');
    //         return;
    //     }
    //     // Get the index of the first selected row
    //     const selectedIndex = selected[0][0];

    //     hot.alter('insert_row_below', selectedIndex);
    //     setHeightTo500px();
    // });
    const addRowButton = document.getElementById('btn-add-row');
    addRowButton.addEventListener('click', function() {
        const lastRowIndex = hot.countRows() - 1;
        hot.alter('insert_row_below', lastRowIndex);
    });

    // delete row ==========================================================================
    const deleteRowButton = document.getElementById('btn-delete-row');
    // deleteRowButton.addEventListener('click', function() {
    //     const selectedRows = hot.getSelected() || [];

    //     if (selectedRows.length === 0) {
    //         alert('No rows selected. Please select rows to delete.');
    //         return;
    //     }

    //     if (selectedRows.length > 0) {
    //         const confirmed = confirm('Are you sure you want to delete the selected row?');
    //         if (confirmed) {

    //             // Create an array to hold unique row indices
    //             const rowsToDelete = new Set();

    //             // Iterate through each selected range and add row indices to the set
    //             selectedRows.forEach(range => {
    //                 const [row1, _column1, row2, _column2] = range;
    //                 for (let rowIndex = Math.min(row1, row2); rowIndex <= Math.max(row1, row2); rowIndex++) {
    //                     rowsToDelete.add(rowIndex);
    //                 }
    //             });

    //             // Convert the set to an array and sort it in descending order
    //             const sortedRowsToDelete = Array.from(rowsToDelete).sort((a, b) => b - a);

    //             // Delete rows in the sorted order
    //             sortedRowsToDelete.forEach(rowIndex => {
    //                 hot.alter('remove_row', rowIndex);
    //             });

    //             hot.deselectCell();

    //         }
    //     }
    // });
    deleteRowButton.addEventListener('click', function() {
        const selectedRows = hot.getSelected() || [];

        if (selectedRows.length === 0) {
            alert('No rows selected. Please select rows to delete.');
            return;
        }

        if (selectedRows.length > 0) {


            // Create an array to hold unique row indices
            const rowsToDelete = new Set();

            // Flag to check if any row has non-null value in the first column
            let hasNonNullValue = false;

            // Iterate through each selected range and add row indices to the set
            selectedRows.forEach(range => {
                const [row1, _column1, row2, _column2] = range;
                for (let rowIndex = Math.min(row1, row2); rowIndex <= Math.max(row1, row2); rowIndex++) {
                    const firstColumnValue = hot.getDataAtCell(rowIndex, 0);
                    if (firstColumnValue !== null) {
                        hasNonNullValue = true;
                        break;
                    }
                    rowsToDelete.add(rowIndex);
                }
            });

            // Check if any row has non-null value in the first column
            if (hasNonNullValue) {
                alert('Cannot delete rows if one row selected already saved in records. You can only set inactive on already saved type');
                return;
            }
            const confirmed = confirm('Are you sure you want to delete the selected row?');
            if (!confirmed) return;
            // Convert the set to an array and sort it in descending order
            const sortedRowsToDelete = Array.from(rowsToDelete).sort((a, b) => b - a);

            // Delete rows in the sorted order
            sortedRowsToDelete.forEach(rowIndex => {
                hot.alter('remove_row', rowIndex);
            });

            hot.deselectCell();
        }
    });

    // setHeightTo500px();
    // update data ================================================================================== 

    const col_status = [{
        name: 'Active'
    }, {
        name: 'Inactive'
    }, ];
    // const col_type = [
    //     {
    //         name: 'Fixed'
    //     }, {
    //         name: 'Attendance'
    //     }, 
    // ];

    var update = document.getElementById('btn-update');
    update.addEventListener('click', function() {
        const updatedData = hot.getData();
        // check if rows is empty
        const hasEmptyRow = updatedData.some(row => row.slice(1).some(cell => (cell == '' || cell == null)));
        if (hasEmptyRow) {
            alert('Cannot upload empty rows.');
            return;
        }
        let shouldProceed = true;

        function validateDateFormat(row, rowIndex, tableColumn, title) {
            let regex = /^\d{2}\/\d{2}\/\d{4}$/;
            let check = regex.test(row);
            if (!check) {
                shouldProceed = false;
                // alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
                $(document).Toasts('create', {
                    class: 'bg-warning toast_width',
                    title: 'Warning!',
                    subtitle: 'close',
                    body: `${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`
                })
                return;
            }
        }

        //validateIncludes
        function validateIncludes(row, rowIndex, tableColumn, title) {
            if (!tableColumn.includes(row)) {
                shouldProceed = false;
                // alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
                $(document).Toasts('create', {
                    class: 'bg-warning toast_width',
                    title: 'Warning!',
                    subtitle: 'close',
                    body: `${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`
                })
                return;
            }
        }

        for (var rowIndex = 0; rowIndex < updatedData.length; rowIndex++) {
            var row = updatedData[rowIndex];
            // console.log("Row Index:", rowIndex);
            // console.log("Row Data:", rowData);
            validateIncludes(row[4], rowIndex, statusSource, 'Status');
            if (!shouldProceed) break;;
            validateIncludes(row[3], rowIndex, col_holi_typeSource, 'Type');
            if (!shouldProceed) break;;
            validateDateFormat(row[1], rowIndex, null, 'Date');
            if (!shouldProceed) break;;
        }


        // updatedData.forEach((row, rowIndex) => {
        //         validateIncludes(row[4], rowIndex, statusSource, 'Status');
        //         if(!shouldProceed)return;
        //         validateIncludes(row[3], rowIndex, col_holi_typeSource, 'Type');
        //         validateDateFormat(row[1], rowIndex, null, 'Date');
        // });
        if (!shouldProceed) return;
        const confirmed = confirm('Are you sure you want to upload the data?');
        if (!confirmed) {
            return;
        }


        var changes = [];
        // console.log('parsedData', parsedData)
        // console.log('copiedData', copiedData)
        for (var i = 0; i < copiedData.length; i++) {
            var originalObj = copiedData[i];
            // var modifiedObj = parsedData[i];
            var modifiedObj = {
                ...parsedData[i]
            };
            let isChanged = false;
            for (var key in originalObj) {
                // console.log('key',key);
                if (originalObj.hasOwnProperty(key) && modifiedObj && originalObj[key] !== modifiedObj[key]) {
                    isChanged = true;
                }
                if (key == 'col_holi_date') {
                    // console.log('key',true);
                    var parts = modifiedObj[key].split('/');
                    var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
                    modifiedObj[key] = formattedDate;
                }
            }
            if (isChanged) {
                changes.push(modifiedObj);
            }
        }
        for (var i = copiedData.length; i < parsedData.length; i++) {
            var modifiedObj = {
                ...parsedData[i]
            };
            if (!modifiedObj.id) {
                // console.log('modifiedObj',modifiedObj);
                var parts = modifiedObj.col_holi_date.split('/');
                var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
                modifiedObj.col_holi_date = formattedDate;
                modifiedObj.year = $("#filter_year").find(":selected").val();
                changes.push(modifiedObj);
            }
        }
        console.log('changes', changes)
        // return;

        // validate type
        // function validateType(row, rowIndex, tableColumn, title) {
        //     const validData = tableColumn.map(data => data.name);
        //     if (!validData.includes(row)) {
        //         shouldProceed = false;
        //         alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
        //     }
        // }

        // validate data
        // function validateData(row, rowIndex, tableColumn, title) {
        //     const validPositions = tableColumn.map(division => division.name);
        //     if (!validPositions.includes(row)) {
        //         console.log('row type', row);
        //         console.log('tableColumn', tableColumn);
        //         shouldProceed = false;
        //         alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
        //     }
        // }

        // validate year
        // function validateYear(row, rowIndex, tableColumn, title) {
        //     const validPositions = tableColumn.map(date => date);
        //     if (!validPositions.includes(row)) {
        //         shouldProceed = false;
        //         alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
        //     }
        // }

        // //validate date
        // function validateDateFormat(row, rowIndex, tableColumn, title) {
        //     let regex = /^\d{2}\/\d{2}\/\d{4}$/;
        //     let check = regex.test(row); 
        //     if (!check) {
        //         shouldProceed = false;
        //         alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
        //     }
        // }

        // //validateIncludes
        // function validateIncludes(row, rowIndex, tableColumn, title) {
        //     if (!tableColumn.includes(row)) {
        //         shouldProceed = false;
        //         alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
        //     }
        // }

        // let shouldProceed = true;
        // updatedData.forEach((row, rowIndex) => {
        //         validateIncludes(row[4], rowIndex, statusSource, 'Status');
        //         validateIncludes(row[3], rowIndex, col_holi_typeSource, 'Type');
        //         // validateYear(row[4], rowIndex, parsedDatayearNames, 'Year');
        //         validateDateFormat(row[1], rowIndex, null, 'Date');
        //         // console.log('row', row);
        //         // console.log('rowIndex', rowIndex);
        //         // console.log('col_status', col_status);
        //         // console.log('parsedDatayearNames', parsedDatayearNames);
        // });

        // console.log('updatedData',updatedData) 
        // return;

        // if (!shouldProceed) {
        //     return;
        // }

        if (changes.length < 1) {
            $(document).Toasts('create', {
                class: 'bg-warning toast_width',
                title: 'Warning!',
                subtitle: 'close',
                body: 'No Changes'
            })
            return;
        }

        const requestData = {
            updatedData: changes,
            // tableName: tableName
        };

        // insert data
        fetch(url + 'attendances/update_setting_holidays', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(result => {
                // console.log('test');
                // console.log('result',result);
                if (result.reload) {
                    location.reload();
                }
                if (result.success_message) {
                    copiedData = JSON.parse(JSON.stringify(parsedData));
                    $(document).Toasts('create', {
                        class: 'bg-success toast_width',
                        title: 'Success!',
                        subtitle: 'close',
                        body: result.success_message
                    })
                }

                if (result.warning_message) {
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
    });
</script>

<script>
    $(document).ready(function() {

        $('#settingsDropdown').on('change', function() {
            var selectedValue = $(this).val();

            if (selectedValue === 'general') {
                window.location.href = '<?= base_url('attendances/setting_general') ?>';
            }
            if (selectedValue === 'holidays') {
                window.location.href = '<?= base_url('attendances/setting_holidays') ?>';
            }
            if (selectedValue === 'years') {
                window.location.href = '<?= base_url('attendances/setting_years') ?>';
            }
            if (selectedValue === 'biometrics') {
                window.location.href = '<?= base_url('attendances/setting_biometrics') ?>';
            }
            if (selectedValue === 'remote_in_out') {
                window.location.href = '<?= base_url('attendances/setting_remote_in_out') ?>';
            }
            if (selectedValue === 'geofences') {
                window.location.href = '<?= base_url('attendances/setting_geo_fences') ?>';
            }


        });
    });
</script>