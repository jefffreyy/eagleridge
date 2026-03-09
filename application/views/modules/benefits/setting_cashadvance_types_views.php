<?php $this->load->view('templates/companycontribution_style'); ?>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?php echo base_url()?>/assets_system/css/handsontable14.css" />

<?php
?>

<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="flex-fill">

            <div class="row p-0">
                <div class="col-md-6">
                    <h1 class="page-title"><a href="<?= base_url() . 'benefits'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;Benefits Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;"> 
                </div>
            </div>
            <hr>

            <div class="mx-auto card d-block d-lg-none col-11">
                <div class="form-group row d-flex justify-content-center">
                    <label for="" class="col-10">Select Settings</label>
                    <select name="" class="form-control col-10" id="settingsDropdown">
                        <option value="cashadvance" selected>
                           Cash Advance Types
                        </option>
                        <option value="general_settings">
                           General
                        </option>
                        <option value="loan_types">
                           Loan Types
                        </option>
                        <option value="reimbursement">
                           Reimbursement Types
                        </option>
                    </select>
                </div>
            </div>

            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
           
                <div class="card col-xl-8 col-lg-4 col-md-8 col-11" style="min-height:700px ">
                    <div class="row">
                        <div class="col-md-3 d-none d-lg-block">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?php $this->load->view('templates/settings_benefits_nav_views'); ?>
                            </div>
                        </div>
                        <div class="col-md-9 p-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <span style="font-weight: 500; font-size: 18px">Cash Advance Types</span>
                                </div>
                           
                                <div class="col-md-12">
                                    <!-- <i>Note: LWOP, Offset, Vacation, Sick Leaves are permanent leave types.</i> -->
                                </div>
                            </div>
                            <hr>

                            <div class="col-12 justify-content-center mt-3">
                                <div class="col-md-12 mb-3">
                                    <button class="btn btn-success pt-1 pb-1" id="btn-add-row" style="font-size: 14px"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-plus-solid_xs.svg') ?>">&nbsp;Add Row</button>
                                    <button class="btn btn-danger pt-1 pb-1" id="btn-delete-row" style="font-size: 14px"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-minus-solid_xs.svg') ?>">&nbsp;Delete Row</button>
                                    <button class="btn btn-primary pt-1 pb-1" id="btn-update" style="font-size: 14px"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>">&nbsp;Save Record</button>
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
<script type="text/javascript" src="<?php echo base_url()?>/assets_system/js/handsontable14.js"></script>


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
    var url = '<?= base_url() ?>';
    var parsedData = <?php echo $C_DATA_TABLE; ?>;
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
    var sourceColumnStatus = ['Active', 'Inactive'];
    var yearsArray = [];
    for (let year = 2010; year <= 2050; year++) {
        yearsArray.push(year.toString());
    }
    console.log('yearsArray', yearsArray);
    column_headers = ['Id','Name','Status'];
    columns = [{
            data: 'id'
        }, 
        // {data: 'name'},
        {
            data: 'name',
        },
        {
            data: 'status',
            type: 'dropdown',
            source: sourceColumnStatus,
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


    // function generateYearDropdownSource() {
    //     const currentYear = new Date().getFullYear();
    //     const years = [];
    //     // range of years
    //     for (let i = currentYear; i >= currentYear - 3; i--) {
    //         years.push(i.toString());
    //     }
    //     return years;
    // }
    const addRowButton = document.getElementById('btn-add-row');
        addRowButton.addEventListener('click', function() {
        const lastRowIndex = hot.countRows() - 1;
        hot.alter('insert_row_below', lastRowIndex);
        });

    // delete row ==========================================================================
    const deleteRowButton = document.getElementById('btn-delete-row');
    deleteRowButton.addEventListener('click', function () {
        const selectedRows = hot.getSelected() || [];
        if (selectedRows.length === 0) {
            alert('No rows selected. Please select rows to delete.');
            return;
        }
        if (selectedRows.length > 0) {
            const rowsToDelete = new Set();
            let hasNonNullValue = false;
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
            if (hasNonNullValue) {
                alert('Cannot delete rows if one row selected already saved in records. You can only set inactive on already saved type');
                return;
            }
            const confirmed = confirm('Are you sure you want to delete the selected row?');
            if (!confirmed)return;
            const sortedRowsToDelete = Array.from(rowsToDelete).sort((a, b) => b - a);
            sortedRowsToDelete.forEach(rowIndex => {
                hot.alter('remove_row', rowIndex);
            });
            hot.deselectCell();
        }
    });
    // const col_status = [{
    //     name: 'Active'
    // }, {
    //     name: 'Inactive'
    // }, ];
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
            // var modifiedObj = parsedData[i];
            var modifiedObj = { ...parsedData[i] };
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
            var modifiedObj = { ...parsedData[i] };
            if(!modifiedObj.id){
                // console.log('modifiedObj',modifiedObj);
                if (modifiedObj.col_holi_date) {
                    var parts = modifiedObj.col_holi_date.split('/');
                    var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
                    modifiedObj.col_holi_date = formattedDate;
                }
                changes.push(modifiedObj);
            }
        }
        console.log('changes', changes)
        // return;

        // validate type
        function validateType(row, rowIndex, tableColumn, title) {
            const validData = tableColumn.map(data => data.name);
            if (!validData.includes(row)) {
                shouldProceed = false;
                alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
            }
        }

        // validate Includes
        function validateIncludes(row, rowIndex, tableColumn, title) {
            if (!tableColumn.includes(row)) {
                shouldProceed = false;
                alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
            }
        }

        let shouldProceed = true;
        updatedData.forEach((row, rowIndex) => {
            validateIncludes(row[2], rowIndex, sourceColumnStatus, 'Status');
            
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
        // return;
        // insert data
        fetch(url + 'benefits/update_cashadvance_types', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(result => {
                // console.log('test');
                console.log('result',result);
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

            if (selectedValue === 'cashadvance') {
                window.location.href = '<?= base_url('benefits/setting_cashadvance_types') ?>';
            }
            if (selectedValue === 'general_settings') {
                window.location.href = '<?= base_url('benefits/setting_general') ?>';
            }
            if (selectedValue === 'loan_types') {
                window.location.href = '<?= base_url('benefits/setting_loan_types') ?>';
            }
            if (selectedValue === 'reimbursement') {
                window.location.href = '<?= base_url('benefits/setting_reimbursement_types') ?>';
            }

        });
    });
</script>