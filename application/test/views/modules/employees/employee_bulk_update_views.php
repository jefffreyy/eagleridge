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
                        <h1 class="page-title">Update Employee Information</h1>
                    </div>
                    <div class="col ml-auto button-title">
                        <!-- <a class="btn btn-primary mt-1" title="Add" href="<?= base_url() ?>employees/upload_employee_photo">
                            <i class="fas fa-fw fa-upload"></i> Upload Employee Photo
                        </a> -->
                        <button class="btn btn-primary" id="btn-insert"><i class="fa-solid fa-pen-to-square"></i> Update data</button>   
                    </div>
                </div>
                <div class="card">

                    <div id="example"></div>
                    <!-- <div class="col mb-5 mt-2">
                        <button class="btn btn-success" id="btn-add-row">Add Row</button>
                        <button class="btn btn-danger" id="btn-delete-row">Delete Row</button>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('templates/jquery_link'); ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

    <script>

        var url = '<?=base_url()?>';

        // check position if empty
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

        const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.whiteSpace = 'nowrap';
            td.style.overflow = 'hidden';
        };

        const apiUrl = url + 'employees/get_tableplus_data';

        var hot;

        fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            initializeHandsontable(data);
        })
        .catch(error => {
            console.error('Data fetch error:', error);
        });
        
     
        function initializeHandsontable(data) {
            console.log(data);
       
            const container = document.querySelector('#example');
            hot = new Handsontable(container, {
                data: data, 
                colHeaders: ['Employee ID','Last Name','Middle Name','First Name','Marital Status','Home Address','Current Address','Birthday','Gender','Nationality','Shirt Size','Email Address','Mobile Number','Hired On','Employment Type','Position','Division','Group','Line','Department','Section','Image File','SSS Number','Pagibig','Philhealth','TIN','Drivers License','National ID','Passport','HMO','HMO Number','Salary Rate','Salary Type'],
                rowHeaders: true,
                height: 'auto',
                outsideClickDeselects: false,
                selectionMode: 'multiple',
                licenseKey: 'non-commercial-and-evaluation',
                // Custom renderer to prevent text wrapping
                renderer: customStyleRenderer,
                columns: [
                {
                    data: 'col_empl_cmid'
                },
                {
                    data: 'col_last_name'
                },
                {
                    data: 'col_midl_name'
                },
                {
                    data: 'col_frst_name'
                },
                {   
                    data: 'col_mart_stat',
                    type: 'dropdown',
                    source: json_data(cMarital),
                },
                {
                    data: 'col_home_addr'
                },
                {
                    data: 'col_curr_addr'
                },
                {
                    data: 'col_birt_date',
                    type: 'date',
                    dateFormat: 'YYYY-MM-DD',
                    correctFormat: false
                },
                {   
                    data: 'col_empl_gend',
                    type: 'dropdown',
                    source: json_data(cGenders),
                },
                {   
                    data: 'col_empl_nati',
                    type: 'dropdown',
                    source: json_data(cNationality),
                },
                {   
                    data: 'col_shir_size',
                    type: 'dropdown',
                    source: json_data(cShirtSize),
                },
                {
                    data: 'col_empl_emai'
                },
                {
                    data: 'col_mobl_numb'
                },
                {
                    data: 'col_hire_date',
                    type: 'date',
                    dateFormat: 'YYYY-MM-DD',
                    correctFormat: false                    
                },
                {   
                    data: 'col_empl_type',
                    type: 'dropdown',
                    source: json_data(cType),
                },
                {   
                    data: 'col_empl_posi',
                    type: 'dropdown',
                    source: json_data(cPositions),
                    // renderer: customStyleRenderer,
                },
                {   
                    data: 'col_empl_divi',
                    type: 'dropdown',
                    source: json_data(cDivisions),
                },
                {   
                    data: 'col_empl_group',
                    type: 'dropdown',
                    source: json_data(cGroups),
                },
                {   
                    data: 'col_empl_line',
                    type: 'dropdown',
                    source: json_data(cLines),
                },
                {   
                    data: 'col_empl_dept',
                    type: 'dropdown',
                    source: json_data(cDepartments),
                },
                {   
                    data: 'col_empl_sect',
                    type: 'dropdown',
                    source: json_data(cSections),
                    // renderer: customStyleRenderer,
                },
                {
                    data: 'col_imag_path'
                },
                {
                    data: 'col_empl_sssc'
                },
                {
                    data: 'col_empl_hdmf'
                },
                {
                    data: 'col_empl_phil'
                },
                {
                    data: 'col_empl_btin'
                },
                {
                    data: 'col_empl_driv'
                },
                {
                    data: 'col_empl_naid'
                },
                {
                    data: 'col_empl_pass'
                },
                {   
                    data: 'col_empl_hmoo',
                    type: 'dropdown',
                    source: json_data(cHmo),
                },
                {
                    data: 'col_empl_hmon'
                },
                {
                    data: 'salary_rate'
                }, 
                {   
                    data: 'salary_type',
                    type: 'dropdown',
                    source: ['Monthly', 'Daily'],
                },
            ]

            


            });
        }
    

        var insert = document.getElementById('btn-insert');
        insert.addEventListener('click', function() {
            const confirmed = confirm('Are you sure you want to update the data?');
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
            
            
         
            fetch(url + 'employees/update_data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(updatedData)
            })
            .then(response => response.json())
            .then(result => {
                // console.log(result.success_message);
                // console.log(result.warning_message);
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
        });

    
        
    </script>



</body>

</html>