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
                        <h1 class="page-title">New Employee Information</h1>
                    </div>
                    <div class="col ml-auto button-title">
                        <!-- <a class="btn btn-primary mt-1" title="Add" href="<?= base_url() ?>employees/upload_employee_photo">
                            <i class="fas fa-fw fa-upload"></i> Upload Employee Photo
                        </a> -->
                        <button class="btn btn-primary" id="btn-insert"><i class="fas fa-fw fa-upload"></i> Upload Data</button>   
                    </div>
                </div>
                <div class="card">

                    <div id="example"></div>
                    <div class="col mb-5 mt-2">
                        <button class="btn btn-success" id="btn-add-row">Add Row</button>
                        <button class="btn btn-danger" id="btn-delete-row">Delete Row</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('templates/jquery_link'); ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

    <script>

        var url = '<?=base_url()?>';

        var cUserAccess = <?php echo json_encode($C_USER_ACCESS); ?>;
        var cMarital = <?php echo json_encode($C_MARITAL); ?>;
        var cGenders = <?php echo json_encode($C_GENDERS); ?>;
        var cNationality = <?php echo json_encode($C_NATIONALITY); ?>;
        var cShirtSize = <?php echo json_encode($C_SHIRT_SIZE); ?>;
        var cType = <?php echo json_encode($C_TYPE); ?>;
        var cPositions = <?php echo json_encode($C_POSITIONS); ?>;
        var cDivisions = <?php echo json_encode($C_DIVISIONS); ?>;
        var cGroups = <?php echo json_encode($C_GROUPS); ?>;
        var cLines = <?php echo json_encode($C_LINES); ?>;
        var cDepartments = <?php echo json_encode($C_DEPARTMENTS); ?>;
        var cSections  = <?php echo json_encode($C_SECTIONS); ?>;
        var cHmo  = <?php echo json_encode($C_HMO); ?>;

        function json_data(data){
            return data.map(arg => arg.name);
        }

        // Custom renderer to prevent text wrapping
        const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.whiteSpace = 'nowrap';
            td.style.overflow = 'hidden';
        };

        
        const container = document.querySelector('#example');
        hot = new Handsontable(container, {
            data: [['','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','']], 
            colHeaders: ['Employee ID','Last Name','Middle Name','First Name','Marital Status','Home Address','Current Address','Birthday','Gender','Nationality','Shirt Size','Email Address','Mobile Number','Hired On','Employment Type','Position','Division','Group','Line','Department','Section','Image File','SSS Number','Pagibig','Philhealth','TIN','Drivers License','National ID','Passport','HMO','HMO Number','Salary Rate','Salary Type'],
            rowHeaders: true,
            height: 'auto',
            outsideClickDeselects: false,
            selectionMode: 'multiple',
            licenseKey: 'non-commercial-and-evaluation',
            renderer: customStyleRenderer,
            columns: [
                {data: 'col_empl_cmid'},{data: 'col_last_name'},{data: 'col_midl_name'},{data: 'col_frst_name'},
                {   
                    type: 'dropdown',
                    source: json_data(cMarital),
                },
                {data: 'col_home_addr'},{data: 'col_curr_addr'},{data: 'col_birt_date'},
                {   type: 'dropdown',
                    source: json_data(cGenders),
                },
                {   type: 'dropdown',
                    source: json_data(cNationality),
                },
                {   type: 'dropdown',
                    source: json_data(cShirtSize),
                },
                {data: 'col_empl_emai'},{data: 'col_mobl_numb'},{data: 'col_hire_date'},
                {   type: 'dropdown',
                    source: json_data(cType),
                },
                {   
                    type: 'dropdown',
                    source: json_data(cPositions),
                },
                {   type: 'dropdown',
                    source: json_data(cDivisions),
                },
                {   type: 'dropdown',
                    source: json_data(cGroups),
                },
                {   type: 'dropdown',
                    source: json_data(cLines),
                },
                {   type: 'dropdown',
                    source: json_data(cDepartments),
                },
                {   type: 'dropdown',
                    source: json_data(cSections),
                },
                {data: 'col_imag_path'},{data: 'col_empl_sssc'},{data: 'col_empl_hdmf'},{data: 'col_empl_phil'},{data: 'col_empl_btin'},{data: 'col_empl_driv'},{data: 'col_empl_naid'}, {data: 'col_empl_pass'},
                {   type: 'dropdown',
                    source: json_data(cHmo),
                },
                {data: 'col_empl_hmon'},{data: 'salary_rate'}, 
                {   data: 'salary_type',
                    type: 'dropdown',
                    source: ['Monthly', 'Daily'],
                },
            ]
        });

        // add row
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
        });

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
        });      


        var insert = document.getElementById('btn-insert');
        insert.addEventListener('click', function() {
            const confirmed = confirm('Are you sure you want to upload the data?');
            if (!confirmed) {
                return; 
            }

            const updatedData = hot.getData();

            // check if row is empty
            const hasEmptyRow = updatedData.some(row => row.some(cell => cell !== ''));
            if (!hasEmptyRow) {
                alert('Cannot upload empty rows.');
                return; 
            }
            
            function validateData(row,rowIndex,tableColumn, title){

                if (row === '' || row == null) { 
                    const confirmPosition = confirm(`${title} is blank in row ${rowIndex + 1}. Would you like to proceed without adding a ${title.toLowerCase()}?`);
                    if (!confirmPosition) {
                        shouldProceed = false;
                    }
                }
                else {
                    const providedPosition = row.toLowerCase();
                    const validPositions = tableColumn.map(division => division.name.toLowerCase());
                    if (!validPositions.includes(providedPosition)) {
                        shouldProceed = false;
                        alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
                    }
                }
            }

            function validateRequiredData(row,rowIndex, title){
                if (row === '' || row == null) { 
                    shouldProceed = false;
                    alert(`${title} is required in row ${rowIndex + 1}. Please provide a user ${title.toLowerCase()}.`);
                }
            }
        
            let shouldProceed = true;
            updatedData.forEach((row, rowIndex) => {

                validateRequiredData(row[0], rowIndex, 'Employee ID');

                validateRequiredData(row[1], rowIndex, 'Last Name');
                validateRequiredData(row[2], rowIndex, 'Middle Name');
                validateRequiredData(row[3], rowIndex, 'First Name');

                // validateData(row[14], rowIndex, cType, 'Employee Type');
                // validateData(row[15], rowIndex, cPositions, 'Position');
                // validateData(row[16], rowIndex, cDivisions, 'Division');
                // validateData(row[17], rowIndex, cGroups, 'Group');
                // validateData(row[18], rowIndex, cLines, 'Line');
                // validateData(row[19], rowIndex, cDepartments, 'Department');
                // validateData(row[20], rowIndex, cSections, 'Section');

            });

            if (!shouldProceed) {
                return; 
            }

            // insert data
            fetch(url + 'employees/insert_data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(updatedData)
            })
            .then(response => response.json())
            .then(result => {
                console.log(result.success_message);
                console.log(result.warning_message);

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