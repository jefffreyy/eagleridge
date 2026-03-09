<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<style>
    .handsontable .wtHolder .wtHider{
        /* margin-bottom: 50px; */
        height: 74vh !important;
    }
</style>
<body>
    <div class="content-wrapper">
        <div class="p-3">
            <div class="flex-fill">
                <div class="row pr-3 mb-3">
                    <div class="col">
                        <h1 class="page-title"><a href="<?= base_url() . 'employees/directories'; ?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Quick Edit Employees</h1>
                    </div>

                    <div class="col ml-auto button-title">
                        <button class="btn btn-primary" id="btn-insert"><i class="fa-solid fa-pen-to-square"></i> Update data</button>
                    </div>
                </div>

                <div class=" pb-3 w-25">
                    <p class="p-0 my-1 text-bold">Select Table</p>
                    <select class="form-control cut_off_period" id="table-id" onchange="pageTable(this.value)">
                        <option value="General" selected>General</option>
                        <option value="Education">Education</option>
                        <option value="Skills">Skills</option>
                        <option value="Work History">Work History</option>
                        <option value="Documents">Documents</option>
                        <option value="Dependents">Dependents</option>
                        <option value="Emergency Contacts">Emergency Contacts</option>
                    </select>
                </div>

                <div class="card">
                    <p style="margin:0;padding:4px;color: #dc3545;">Employee ID is not editable*</p> 
                    <div id="example"></div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('templates/jquery_link'); ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
    <script>
        var url           = '<?= base_url() ?>';
        var cUserAccess   = <?php echo json_encode($C_USER_ACCESS); ?>;
        var cMarital      = <?php echo json_encode($C_MARITAL); ?>;
        var cGenders      = <?php echo json_encode($C_GENDERS); ?>;
        var cNationality  = <?php echo json_encode($C_NATIONALITY); ?>;
        var cShirtSize    = <?php echo json_encode($C_SHIRT_SIZE); ?>;
        var cType         = <?php echo json_encode($C_TYPE); ?>;
        var cPositions    = <?php echo json_encode($C_POSITIONS); ?>;
        var cBranches     = <?php echo json_encode($C_BRANCHES); ?>;
        var cCompanies    = <?php echo json_encode($C_COMPANIES); ?>;
        var cDivisions    = <?php echo json_encode($C_DIVISIONS); ?>;
        var cGroups       = <?php echo json_encode($C_GROUPS); ?>;
        var cTeams        = <?php echo json_encode($C_TEAMS); ?>;
        var cLines        = <?php echo json_encode($C_LINES); ?>;
        var cDepartments  = <?php echo json_encode($C_DEPARTMENTS); ?>;
        var cSections     = <?php echo json_encode($C_SECTIONS); ?>;
        var cHmo          = <?php echo json_encode($C_HMO); ?>;
        let data          = [
        ]
        function json_data(data) {
            return data.map(arg => arg.name);
        }
        const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.whiteSpace   = 'nowrap';
            td.style.overflow     = 'hidden';
            // td.style.overflow = 'auto';
        };

        const apiUrl = url + 'employees/get_tableplus_data';
        var hot;
        fetch(apiUrl)
            .then(response => response.json())
            .then(resData => {
                data = resData;
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
                colHeaders: ['Employee ID', 'Last Name', 'Middle Name', 'First Name', 'Suffix', 'Marital Status', 'Home Address', 'Current Address', 'Birthday', 'Gender', 'Nationality', 'Shirt Size', 'Email Address', 'Mobile Number', 'Hired Date', 'Regularization Date', 'Resignation Date', 'Last Day Date', 'Employment Type', 'Position', 'Company', 'Branch', 'Department', 'Division', 'Section', 'Groups', 'Team', 'Line', 'Image File', 'SSS Number', 'Pagibig', 'Philhealth', 'TIN', 'Drivers License', 'National ID', 'Passport', 'HMO', 'HMO Number', 'Salary Rate', 'Salary Type'],
                rowHeaders: true,
                height: 'auto',
                // wordWrap: false,
                outsideClickDeselects: false,
                selectionMode: 'multiple',
                licenseKey: 'non-commercial-and-evaluation',
                renderer: customStyleRenderer,
                columns: [{
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
                        data: 'col_suffix' 
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
                        dateFormat: 'DD/MM/YYYY',
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
                        dateFormat: 'DD/MM/YYYY',
                        correctFormat: false
                    },
                    {
                        data: 'date_regular', 
                        type: 'date',
                        dateFormat: 'DD/MM/YYYY',
                        correctFormat: false
                    },
                    {
                        data: 'resignation_date', 
                        type: 'date',
                        dateFormat: 'DD/MM/YYYY',
                        correctFormat: false
                    },
                    {
                        data: 'col_endd_date', 
                        type: 'date',
                        dateFormat: 'DD/MM/YYYY',
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
                    },
                    {
                        data: 'col_empl_company', 
                        type: 'dropdown',
                        source: json_data(cCompanies),
                    },
                    {
                        data: 'col_empl_branch', 
                        type: 'dropdown',
                        source: json_data(cBranches), 
                    },
                    {
                        data: 'col_empl_dept', 
                        type: 'dropdown',
                        source: json_data(cDepartments),
                    },
                    {
                        data: 'col_empl_divi', 
                        type: 'dropdown',
                        source: json_data(cDivisions),
                    },
                    {
                        data: 'col_empl_sect', 
                        type: 'dropdown',
                        source: json_data(cSections),
                    },
                    {
                        data: 'col_empl_group', 
                        type: 'dropdown',
                        source: json_data(cGroups),
                    },
                    {
                        data: 'col_empl_team', 
                        type: 'dropdown',
                        source: json_data(cTeams), 
                    },
                    {
                        data: 'col_empl_line', 
                        type: 'dropdown',
                        source: json_data(cLines),
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
                ],
                hiddenColumns: {
                    columns: <?php echo json_encode($HIDDEN_COLUMNS); ?>,
                },
            });
        }

        function myCustomRenderer(instance, td, row, col, prop, value, cellProperties) {
            const newDate       = new Date(value);
            const formattedDate = newDate.toLocaleDateString('en-GB');
            td.textContent      = formattedDate;
        }

        var insert = document.getElementById('btn-insert');
        insert.addEventListener('click', function() {
            const confirmed = confirm('Are you sure you want to update the data?');
            if (!confirmed) {
                return;
            }
            const updatedData = hot.getData();
            console.log('data: ', data)
            const sendData = JSON.stringify(data);
            console.log('json data', sendData);
            fetch(url + 'employees/update_data', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: sendData
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
                    console.log('Data update error:', error);
                });
        });
        const pageTable = (value) => {
            if (value === 'General') window.location.href = `${url}employees/employee_update`;
            if (value === 'Education') window.location.href = `${url}employees/bulk_education`;
            if (value === 'Skills') window.location.href = `${url}employees/bulk_skills`;
            if (value === 'Work History') window.location.href = `${url}employees/bulk_work_history`;
            if (value === 'Documents') window.location.href = `${url}employees/bulk_documents`;
            if (value === 'Dependents') window.location.href = `${url}employees/bulk_dependents`;
            if (value === 'Emergency Contacts') window.location.href = `${url}employees/bulk_emergency_contacts`;
        }
    </script>
    
</body>
</html>