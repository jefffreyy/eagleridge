<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<body>
    <div class="content-wrapper">
        <div class="p-3">
            <div class="flex-fill">
                <div class="row pr-3 mb-3">
                    <div class="col">
                        <h1 class="page-title"><a href="<?= base_url() . 'employees/directories'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 5px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Quick Edit Employees</h1>
                    </div>

                    <div class="col ml-auto button-title">
                        <button class="btn btn-primary" id="btn-insert"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;"  src="<?= base_url('assets_system/icons/pen-to-square-solid_light.svg') ?>" alt="" /> Update data</button>
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
                    <div class="p-1">
                        <span for="employee_select">Search Employee</span>
                        <div class="d-flex">
                            <select id="employee_select" class="custom-select d-inline-block w-auto">
                                <?php $searchParam = isset($_GET['id']) ? $_GET['id'] : false; ?>
                                <option value="" <?php echo !$searchParam ? 'selected' : '' ?>>
                                    All
                                </option>
                                <?php if ($employee_search) { ?>
                                    <?php foreach ($employee_search as $DISP_EMP_LIST_SEARCH_ROW) { ?>
                                        <?php
                                            $isSelected = $searchParam && $searchParam == $DISP_EMP_LIST_SEARCH_ROW->id;
                                        ?>
                                        <option value="<?= $DISP_EMP_LIST_SEARCH_ROW->id ?>" <?php echo $isSelected ? 'selected' : '' ?>>
                                            <?= $DISP_EMP_LIST_SEARCH_ROW->employee_name ?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <a href="<?= base_url('employees/employee_update') ?>" id="btn_clear_filter" class="btn technos-button-green mx-1">Clear</a>
                        </div>
                    
                        <div class="float-right ">
                            <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                            <ul class="d-inline pagination m-0 p-0 ">
                            <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
                                < </a>
                            </li>
                            <li><a class="page_row" href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                            <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                            <li><a class="page_row" href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                            <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                            <li><a class="page_row" href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                            <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                            <li><a class="page_row" href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page) echo "hidden"; ?>><?= $last_page ?> </a></li>
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
                    <p style="margin:0;padding:4px 4px 4px 4px;color: #dc3545;">Employee ID is not editable*</p>
                    <div id="example"></div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('templates/jquery_link'); ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#employee_select').select2();
            var searchInput = document.getElementById('employee_select');
            console.log('searchInput')
            searchInput.addEventListener('change', function() {
                console.log('test');
                if (searchInput.value === '') {
                    var urlWithoutId = window.location.href.split('?')[0];
                    window.history.replaceState({}, document.title, urlWithoutId);
                    location.reload();
                } else {
                    var urlWithId = window.location.href.split('?')[0] + '?id=' + encodeURIComponent(searchInput.value);
                    window.history.replaceState({}, document.title, urlWithId);
                    location.reload();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#employee_select').select2();
            var $searchInput = $('#employee_select');
            var initialValue = $searchInput.val();
            $searchInput.on('change', function() {
                if ($searchInput.val() !== initialValue) {
                    if ($searchInput.val() === '') {
                        var urlWithoutId = window.location.href.split('?')[0];
                        window.history.replaceState({}, document.title, urlWithoutId);
                    } else {
                        var urlWithId = window.location.href.split('?')[0] + '?id=' + encodeURIComponent($searchInput.val());
                        window.history.replaceState({}, document.title, urlWithId);
                    }
                    location.reload();
                }
            });
        });
    </script>

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

        var employee_search          = <?php echo json_encode($employee_search); ?>;
        console.log('employee_search',employee_search);
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
        
        let apiUrl = url + 'employees/get_tableplus_data';
        const queryString = window.location.search;
        const params = new URLSearchParams(queryString);
        const id = params.get('id');
        console.log('id',id);
        if (id) {
            apiUrl+=`_id?id=${id}`
            console.log('apiUrl',apiUrl );
        }
        var hot;
        fetch(apiUrl)
            .then(response => response.json())
            .then(resData => {
                data = resData;
                initializeHandsontable(data);
                hot.updateSettings({
                // height: 0.8 * window.innerHeight,
                    height: window.innerHeight - container.getBoundingClientRect().top - 30,
                });
            })
            .catch(error => {
                console.error('Data fetch error:', error);
            });
        const container = document.querySelector('#example');
        function initializeHandsontable(data) {
            console.log(data);
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
                        data: 'col_empl_cmid', readOnly: true
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



        // hot.updateSettings({
        //     height: window.innerHeight - container.getBoundingClientRect().top - 50,
        // }); 
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