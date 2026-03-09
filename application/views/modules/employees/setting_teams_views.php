<?php $this->load->view('templates/companycontribution_style'); ?>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?= base_url('assets_system/css/handsontable14.css') ?>" />


<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="flex-fill">

            <div class="row p-0">
                <div class="col-md-6">
                    <h1 class="page-title"><a href="<?= base_url() . 'employees'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;Employee Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>

            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
                <div class="card col-xl-8 col-lg-4 col-md-8 col-8" style="min-height:700px ">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?php $this->load->view('templates/settings_employee_nav_views'); ?>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12">
                                    <span style="font-weight: 500; font-size: 18px">Teams</span>
                                    <button class="btn btn-primary pt-1 pb-1" style="margin-left: 13rem;" id="btn-update" style="font-size: 14px"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>">&nbsp;Update</button>
                                </div>
                           
                                <div class="col-md-12">
                                    <!-- <i>Note: LWOP, Offset, Vacation, Sick Leaves are permanent leave types.</i> -->
                                </div>
                            </div>
                            <hr>
                            <div class="row justify-content-center">
                                <div class="col-md-12 mb-3">
                                    <button class="btn btn-success pt-1 pb-1" id="btn-add-row" style="font-size: 14px"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-plus-solid_xs.svg') ?>">&nbsp;Add Row</button>
                                    <button class="btn btn-danger pt-1 pb-1" id="btn-delete-row" style="font-size: 14px"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-minus-solid_xs.svg') ?>">&nbsp;Delete Row</button>
                                    <!-- <button class="btn btn-primary pt-1 pb-1" id="btn-update" style="font-size: 14px"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>">&nbsp;Save Record</button> -->
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



<script>
    var url = '<?= base_url() ?>';
    var parsedData = <?php echo $DATA_LIST; ?>;
    var copiedData = JSON.parse(JSON.stringify(parsedData));
    console.log('parsedData', parsedData)

    // var tableName = 'tbl_std_leavetypes';
    var hot;
    let column_headers = "";
    let columns = "";

    // Custom renderer to prevent text wrapping
    const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        td.style.whiteSpace = 'nowrap';
        td.style.overflow = 'hidden';
    };

    column_headers = ['Id', 'Name', 'Status'];
    columns = [{
            data: 'id'
        }, {
            data: 'name'
        },
        {
            data: 'status',
            type: 'dropdown',
            source: ['Active', 'Inactive'],
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
    deleteRowButton.addEventListener('click', function () {
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
                if (!confirmed)return;
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
        const confirmed = confirm('Are you sure you want to upload the data?');
        if (!confirmed) {
            return;
        }

        
        var changes = [];
        // console.log('parsedData', parsedData)
        // console.log('copiedData', copiedData)
        for (var i = 0; i < copiedData.length; i++) {
            var originalObj = copiedData[i];
            var modifiedObj = parsedData[i];

            for (var key in originalObj) {
                if (originalObj.hasOwnProperty(key) && modifiedObj && originalObj[key] !== modifiedObj[key]) {
                    changes.push(modifiedObj);
                break;
                }
            }
        }
        for (var i = 0; i < parsedData.length; i++) {
            var modifiedObj = parsedData[i];
            if(!modifiedObj.id){
                changes.push(modifiedObj);
            }
        }
        console.log('changes', changes)


        // validate type
        function validateType(row, rowIndex, tableColumn, title) {
            const validData = tableColumn.map(data => data.name);
            if (!validData.includes(row)) {
                shouldProceed = false;
                alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
            }
        }

        // validate data
        function validateData(row, rowIndex, tableColumn, title) {
            const validPositions = tableColumn.map(division => division.name);
            if (!validPositions.includes(row)) {
                shouldProceed = false;
                alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
            }
        }

        // validate year
        function validateYear(row, rowIndex, tableColumn, title) {
            const validPositions = tableColumn.map(date => date);
            if (!validPositions.includes(row)) {
                shouldProceed = false;
                alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
            }
        }


        let shouldProceed = true;
        updatedData.forEach((row, rowIndex) => {
                validateData(row[2], rowIndex, col_status, 'Status');
        });

        if (!shouldProceed) {
            return;
        }

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
        fetch(url + 'employees/update_teams', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(result => {

                if (result.success_message) {
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