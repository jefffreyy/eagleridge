<?php $this->load->view('templates/companycontribution_style'); ?>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />


<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="flex-fill">

            <div class="row p-0">
                <div class="col-md-6">
                    <h1 class="page-title"><a href="<?= base_url() . 'overtimes'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;Overtime Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>

            <div class="mx-auto card py-2 d-block d-lg-none col-12">
                <div class=" form-group row d-flex justify-content-center">
                    <label for="" class="col-11 ml-1 ">Navigate settings</label>

                    <select name="" class="form-control  col-11" id="settingsDropdown">
                        <option value="general" >
                            General
                        </option>
                    </select>
                    
                    <select name="" class="form-control  col-11" id="settingsDropdown">
                        <option value="overtime_step" Selected>
                            Overtime Step
                        </option>
                    </select>
                </div>
            </div>

            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
                <div class="card col-xl-8 col-lg-4 col-md-8 col-11" style="min-height:700px ">
                    <div class="row">
                        <div class="col-md-3 d-none d-lg-inline-block">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <?php $this->load->view('templates/settings_overtime_nav_views'); ?>
                                </div>
                            </div>
                            <div class="col-md-9 ">
                            <div class="row mx-2">
                            <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <span style="font-weight: 500; font-size: 18px">Overtime Step Count</span>
                                    <button class="btn btn-primary pt-1 pb-1" id="btn-update" style="font-size: 16px"><img class="mb-1" style="height: 1.5rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>">&nbsp;Update</button>
                                </div>
                           
                                <div class="col-md-12">
                                    <!-- <i>Note: LWOP, Offset, Vacation, Sick Leaves are permanent leave types.</i> -->
                                </div>
                            </div>
                            <hr>

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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

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

    column_headers = ['Id', 'Department', 'Step Count']; //Status
    columns = [{
            data: 'id'
        }, {
            data: 'name'
        },
        {
            data: 'min_hours',
            type: 'dropdown',
            source: ['1', '0.5'],
        },
        // {
        //     data: 'status',
        //     type: 'dropdown',
        //     source: ['Active', 'Inactive'],
        // },
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
        minRows: 2,
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

    // update data ================================================================================== 
    const min_hours = [{
        name: '1'
    }, {
        name: '0.5'
    }, ];

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
                validateData(row[2], rowIndex, min_hours, 'Min. Hours');

        // let shouldProceed = true;
        // updatedData.forEach((row, rowIndex) => {
        //         validateData(row[3], rowIndex, col_status, 'Status');

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
        fetch(url + 'overtimes/update_departments', {
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


<script>
    $(document).ready(function() {

        $('#settingsDropdown').on('change', function() {
            var selectedValue = $(this).val();

            if (selectedValue === 'general') {
                window.location.href = '<?= base_url('overtimes/overtimes/setting_general') ?>';
            }
            
            if (selectedValue === 'overtime_step') {
                window.location.href = '<?= base_url('overtimes/overtimes/overtime_step') ?>';
            }
        });
    });
</script>