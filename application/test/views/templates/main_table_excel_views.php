<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->



<body>
    <!-- Content Starts -->
    <div class="content-wrapper">
        <div class="p-3">
            <div class="flex-fill">
                <div class="row pr-3 mb-3">
                    <div class="col">
                        <h1 class="page-title"><?= $data_list[4] ?> Information</h1>
                    </div>
                    <div class="col ml-auto button-title">
                        <!-- <a class="btn btn-primary mt-1" title="Add" href="<?= base_url() ?>employees/upload_employee_photo">
                            <i class="fas fa-fw fa-upload"></i> Upload Employee Photo
                        </a> -->
                        <button class="btn btn-primary" id="btn-update"><i class="fa-solid fa-pen-to-square"></i> Update data</button>   
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-sm-6">
                        <div class="card border-0 p-0 m-0">
                    
                            <div class="p-2">
                                <div id="example" ></div>
                            </div>
                    
                            <div class="col mb-5 mt-2">
                                <button class="btn btn-success" id="btn-add-row">Add Row</button>
                                <button class="btn btn-danger" id="btn-delete-row">Delete Row</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('templates/jquery_link'); ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

    <script>

        var url = '<?=base_url()?>';
       
        // var standard_data = '<?= $STANDARD_DATA ?>';
        var standard_data = <?= json_encode($STANDARD_DATA, JSON_UNESCAPED_UNICODE) ?>;
        var parsedData = JSON.parse(standard_data);

        var tableName = '<?= $data_list[0] ?>';
        var hot;

        // Custom renderer to prevent text wrapping
        const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.whiteSpace = 'nowrap';
            td.style.overflow = 'hidden';
        };

        function generateYearDropdownSource() {
            const currentYear = new Date().getFullYear();
            const years = [];
            // range of years
            for (let i = currentYear; i >= currentYear - 3; i--) {
                years.push(i.toString());
            }
            return years;
        }
        // console.log(generateYearDropdownSource())
        
        let column_headers = "";
        let columns = "";

        if(tableName == "tbl_std_allowances_tax" || tableName ==  "tbl_std_allowances_nontax" || tableName == "tbl_std_deductions_nontax" || tableName ==  "tbl_std_deductions_tax"){
            column_headers = ['Id', 'Title', 'Status', 'Type'];
            columns = [ 
                    {data: 'id'},{data: 'name'},
                    {   data: 'status',
                        type: 'dropdown',
                        source: ['Active', 'Inactive'],
                    },
                    {   data: 'type',
                        type: 'dropdown',
                        source: ['Fixed', 'Attendance'],
                    },
                ]
        } 
        else if (tableName == "tbl_biometrics" ){
            column_headers = ['Id', 'Terminal SN', 'Name', 'Status'];
            columns = [ 
                    {data: 'id'},{data: 'terminal_sn'},{data: 'name'},
                    {   data: 'status',
                        type: 'dropdown',
                        source: ['Active', 'Inactive'],
                    },
                ]
        }
        else if(tableName == "tbl_std_holidays"){
            column_headers = ['Id', 'Date', 'Title', 'Type', 'Year', 'Status'];
            columns = [ 
                    {data: 'id'},
                    {   
                        data: 'col_holi_date', 
                        type: 'date', 
                        dateFormat: 'YYYY-MM-DD',
                    },
                    {data: 'name'},
                    {   
                        data: 'col_holi_type',
                        type: 'dropdown',
                        source: ['Regular Holiday', 'Special Non-Working Holiday'],
                        renderer: customStyleRenderer,
                    },
                    {   
                        data: 'year',
                        type: 'dropdown',
                        source: generateYearDropdownSource(),
                    },
                    {   
                        data: 'status',
                        type: 'dropdown',
                        source: ['Active', 'Inactive'],
                    },
                ]
        }
        else{
            column_headers = ['Id', 'Title', 'Status'];
            columns = [ 
                    {data: 'id'},{data: 'name'},
                    {   data: 'status',
                        type: 'dropdown',
                        source: ['Active', 'Inactive'],
                    },
                ]
        }



        const container = document.querySelector('#example');
            hot = new Handsontable(container, {
                data: parsedData,
                colHeaders: column_headers,
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
                    // exclude hidden columns from copying and pasting
                    copyPasteEnabled: false,
                },
                columns: columns,
            });



        function setHeightTo500px() {
            const currentHeight = hot.rootElement.clientHeight;
            if (currentHeight >= 500) {
                hot.updateSettings({ height: 500 });
            }
            // else if(currentHeight < 500){
            //     hot.updateSettings({ height: 'auto' });
            // }
        }

        // add row ===========================================================================
        const addRowButton = document.getElementById('btn-add-row');
        addRowButton.addEventListener('click', function() {
            const selected = hot.getSelected() || [];

            if (selected.length === 0) {
                alert('Please select a row to add a new row below.');
                return;
            }
            // Get the index of the first selected row
            const selectedIndex = selected[0][0];

            hot.alter('insert_row_below', selectedIndex); 
            setHeightTo500px();
        });
        
        // delete row ==========================================================================
        const deleteRowButton = document.getElementById('btn-delete-row');
        deleteRowButton.addEventListener('click', function() {
            const selectedRows = hot.getSelected() || [];

            // console.log(selectedRows);
            // console.log(selectedRows.length);

            if (selectedRows.length === 0) {
                alert('No rows selected. Please select rows to delete.');
                return; 
            }

            if(selectedRows.length > 0 ){
                const confirmed = confirm('Are you sure you want to delete the selected row?');
                if(confirmed){

                        // Create an array to hold unique row indices
                    const rowsToDelete = new Set();

                    // Iterate through each selected range and add row indices to the set
                    selectedRows.forEach(range => {
                        const [row1, _column1, row2, _column2] = range;
                        for (let rowIndex = Math.min(row1, row2); rowIndex <= Math.max(row1, row2); rowIndex++) {
                            rowsToDelete.add(rowIndex);
                        }
                    });

                    // Convert the set to an array and sort it in descending order
                    const sortedRowsToDelete = Array.from(rowsToDelete).sort((a, b) => b - a);

                    // Delete rows in the sorted order
                    sortedRowsToDelete.forEach(rowIndex => {
                        hot.alter('remove_row', rowIndex);
                    });

                    hot.deselectCell();
                    
                }
            }
            setHeightTo500px();
        }); 
        setHeightTo500px();
        // update data ================================================================================== 

        const col_status = [ {name: 'Active' }, {name: 'Inactive'}, ];
        const col_type = [ {name: 'Fixed' }, {name: 'Attendance'}, ];

        var update = document.getElementById('btn-update');
        update.addEventListener('click', function() {
            const confirmed = confirm('Are you sure you want to upload the data?');
            if (!confirmed) {
                return; 
            }

            const updatedData = hot.getData();
     
            // check if rows is empty
            const hasEmptyRow =  updatedData.some(row => row.slice(1).some(cell => (cell == '' || cell == null)));
            if (hasEmptyRow) {
                alert('Cannot upload empty rows.');
                return; 
            }

            // validate type
            function validateType(row,rowIndex,tableColumn, title){
                const validData = tableColumn.map(data => data.name);
                if (!validData.includes(row)) {
                    shouldProceed = false;
                    alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
                }
            }

            // validate data
            function validateData(row,rowIndex,tableColumn, title){
                const validPositions = tableColumn.map(division => division.name);
                if (!validPositions.includes(row)) {
                    shouldProceed = false;
                    alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
                }
            }

            // validate year
            function validateYear(row,rowIndex,tableColumn, title){
                const validPositions = tableColumn.map(date => date);
                if (!validPositions.includes(row)) {
                    shouldProceed = false;
                    alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
                }
            }


            let shouldProceed = true;
            updatedData.forEach((row, rowIndex) => {
                if(tableName == "tbl_std_allowances_tax" || tableName ==  "tbl_std_allowances_nontax" || tableName == "tbl_std_deductions_nontax" || tableName ==  "tbl_std_deductions_tax"){
                    validateType(row[3], rowIndex, col_type, 'Type');
                }
                else if(tableName == "tbl_biometrics"){
                    validateData(row[3], rowIndex, col_status, 'Status');
                }
                else if (tableName == "tbl_std_holidays"){
                    const date = new Date(row[1]);
                    const year = date.getFullYear();

                    validateYear(year.toString(), rowIndex, generateYearDropdownSource(), 'Date');
                    validateYear(row[4], rowIndex, generateYearDropdownSource(), 'Year');
                    validateData(row[5], rowIndex, col_status, 'Status');

                    if(row[4] != year.toString()){
                        shouldProceed = false;
                        alert(`Please make sure the dates in row ${rowIndex + 1} are for the same year.`);
                    }
                }
                else{
                    validateData(row[2], rowIndex, col_status, 'Status');
                }
                
            });

            if (!shouldProceed) {
                return; 
            }

            const requestData = {
                updatedData: updatedData,
                tableName: tableName
            };

            // insert data
            fetch(url + 'main_table_01/update_data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(result => {
                // console.log(result.success_message);
                // console.log(result.warning_message);

                // console.log(result);

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
        });

     
    

        

    
        
    </script>



</body>

</html>