<html>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?= base_url('assets_system/css/handsontable14.css') ?>" />
<body>
    <div class="content-wrapper">
        <div class="p-3">
            <div class="flex-fill">
                <div class="row pr-3 mb-3">
                    <div class="col">
                        <h1 class="page-title"><a href="<?= base_url() . 'employees/directories'; ?>">
                            <img style="width: 24px; height: 24px; margin-bottom: 5px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;
                            Quick Add Employees
                        </h1>
                    </div>
                    <div class="col ml-auto button-title">
         
                        <button class="btn btn-primary" id="btn-insert"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;"  src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" /> Update</button>
                    </div>
                </div>

                <div class="card">
                    <div class="col mb-5 mt-2">
                        <button class="btn btn-success " id="btn-add-row"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;"  src="<?= base_url('assets_system/icons/circle-plus-solid_xs.svg') ?>" alt="" />&nbsp; Add Row</button>
                        <button class="btn btn-danger" id="btn-delete-row"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-minus-solid_xs.svg') ?>" alt="" />&nbsp; Delete Row</button>
                    </div>
                    <p class="font-italic m-0 p-1">Download template <a download href="<?=base_url('assets_system/files/add_employee_excel_template.xlsx')?>">here</a></p>
                    <p style="margin:0;padding:4px;color: #dc3545;">Employee ID, Last Name, First Name and Birthday are required*</p>
                    <div id="example"></div>

                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('templates/jquery_link'); ?>
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
    <script type="text/javascript" src="<?= base_url('assets_system/js/handsontable14.js') ?>"></script> 

    <script>
        var url          = '<?= base_url() ?>';
        var cUserAccess  = <?php echo json_encode($C_USER_ACCESS); ?>;
        var cMarital     = <?php echo json_encode($C_MARITAL); ?>;
        var cGenders     = <?php echo json_encode($C_GENDERS); ?>;
        var cNationality = <?php echo json_encode($C_NATIONALITY); ?>;
        var cShirtSize   = <?php echo json_encode($C_SHIRT_SIZE); ?>;
        var cType        = <?php echo json_encode($C_TYPE); ?>;
        var cPositions   = <?php echo json_encode($C_POSITIONS); ?>;
        var cBranches    = <?php echo json_encode($C_BRANCHES); ?>;
        var cCompanies   = <?php echo json_encode($C_COMPANIES); ?>;
        var cDivisions   = <?php echo json_encode($C_DIVISIONS); ?>;
        var cClubhouse    = <?php echo json_encode($C_CLUBHOUSE); ?>;
        var cGroups      = <?php echo json_encode($C_GROUPS); ?>;
        var cTeams       = <?php echo json_encode($C_TEAMS); ?>;
        var cLines       = <?php echo json_encode($C_LINES); ?>;
        var cDepartments = <?php echo json_encode($C_DEPARTMENTS); ?>;
        var cSections    = <?php echo json_encode($C_SECTIONS); ?>;
        var cHmo         = <?php echo json_encode($C_HMO); ?>;
        // console.log(cCompanies)

        let data = 
                [
                        {
                            col_empl_cmid: '',
                            col_last_name: '',
                            col_midl_name: '',
                            col_frst_name: '',
                            col_suffix: '',
                            col_mart_stat: '',
                            col_home_addr: '',
                            col_curr_addr: '',
                            col_province: '',
                            col_city: '',
                            col_barangay: '',
                            col_birt_date: '',
                            col_empl_gend: '',
                            col_empl_nati: '',
                            col_shir_size: '',
                            col_empl_emai: '',
                            col_mobl_numb: '',
                            col_hire_date: '',
                            date_regular: '',
                            resignation_date: '',
                            col_endd_date: '',
                            col_empl_type: '',
                            col_empl_posi: '',
                            col_empl_company: '',
                            col_empl_branch: '',
                            col_empl_dept: '',
                            col_empl_divi: '',
                            col_empl_club: '',
                            col_empl_sect: '',
                            col_empl_group: '',
                            col_empl_team: '',
                            col_empl_line: '',
                            col_imag_path: '',
                            col_empl_sssc: '',
                            col_empl_hdmf: '',
                            col_empl_phil: '',
                            col_empl_btin: '',
                            col_empl_driv: '',
                            col_empl_naid: '',
                            col_empl_pass: '',
                            col_empl_hmoo: '',
                            col_empl_hmon: '',
                            salary_rate: '',
                            salary_type: '',
                            bank_name: '',
                            account_number: '',
                            disabled: '',
                        },
                        {
                            col_empl_cmid: '',
                            col_last_name: '',
                            col_midl_name: '',
                            col_frst_name: '',
                            col_suffix: '',
                            col_mart_stat: '',
                            col_home_addr: '',
                            col_curr_addr: '',
                            col_province: '',
                            col_city: '',
                            col_barangay: '',
                            col_birt_date: '',
                            col_empl_gend: '',
                            col_empl_nati: '',
                            col_shir_size: '',
                            col_empl_emai: '',
                            col_mobl_numb: '',
                            col_hire_date: '',
                            date_regular: '',
                            resignation_date: '',
                            col_endd_date: '',
                            col_empl_type: '',
                            col_empl_posi: '',
                            col_empl_company: '',
                            col_empl_branch: '',
                            col_empl_dept: '',
                            col_empl_divi: '',
                            col_empl_club: '',
                            col_empl_sect: '',
                            col_empl_group: '',
                            col_empl_team: '',
                            col_empl_line: '',
                            col_imag_path: '',
                            col_empl_sssc: '',
                            col_empl_hdmf: '',
                            col_empl_phil: '',
                            col_empl_btin: '',
                            col_empl_driv: '',
                            col_empl_naid: '',
                            col_empl_pass: '',
                            col_empl_hmoo: '',
                            col_empl_hmon: '',
                            salary_rate: '',
                            salary_type: '',
                            bank_name: '',
                            account_number: '',
                            disabled: '',
                        },
                        {
                            col_empl_cmid: '',
                            col_last_name: '',
                            col_midl_name: '',
                            col_frst_name: '',
                            col_suffix: '',
                            col_mart_stat: '',
                            col_home_addr: '',
                            col_curr_addr: '',
                            col_province: '',
                            col_city: '',
                            col_barangay: '',
                            col_birt_date: '',
                            col_empl_gend: '',
                            col_empl_nati: '',
                            col_shir_size: '',
                            col_empl_emai: '',
                            col_mobl_numb: '',
                            col_hire_date: '',
                            date_regular: '',
                            resignation_date: '',
                            col_endd_date: '',
                            col_empl_type: '',
                            col_empl_posi: '',
                            col_empl_company: '',
                            col_empl_branch: '',
                            col_empl_dept: '',
                            col_empl_divi: '',
                            col_empl_club: '',
                            col_empl_sect: '',
                            col_empl_group: '',
                            col_empl_team: '',
                            col_empl_line: '',
                            col_imag_path: '',
                            col_empl_sssc: '',
                            col_empl_hdmf: '',
                            col_empl_phil: '',
                            col_empl_btin: '',
                            col_empl_driv: '',
                            col_empl_naid: '',
                            col_empl_pass: '',
                            col_empl_hmoo: '',
                            col_empl_hmon: '',
                            salary_rate: '',
                            salary_type: '',
                            bank_name: '',
                            account_number: '',
                            disabled: '',
                        },
                        {
                            col_empl_cmid: '',
                            col_last_name: '',
                            col_midl_name: '',
                            col_frst_name: '',
                            col_suffix: '',
                            col_mart_stat: '',
                            col_home_addr: '',
                            col_curr_addr: '',
                            col_province: '',
                            col_city: '',
                            col_barangay: '',
                            col_birt_date: '',
                            col_empl_gend: '',
                            col_empl_nati: '',
                            col_shir_size: '',
                            col_empl_emai: '',
                            col_mobl_numb: '',
                            col_hire_date: '',
                            date_regular: '',
                            resignation_date: '',
                            col_endd_date: '',
                            col_empl_type: '',
                            col_empl_posi: '',
                            col_empl_company: '',
                            col_empl_branch: '',
                            col_empl_dept: '',
                            col_empl_divi: '',
                            col_empl_club: '',
                            col_empl_sect: '',
                            col_empl_group: '',
                            col_empl_team: '',
                            col_empl_line: '',
                            col_imag_path: '',
                            col_empl_sssc: '',
                            col_empl_hdmf: '',
                            col_empl_phil: '',
                            col_empl_btin: '',
                            col_empl_driv: '',
                            col_empl_naid: '',
                            col_empl_pass: '',
                            col_empl_hmoo: '',
                            col_empl_hmon: '',
                            salary_rate: '',
                            salary_type: '',
                            bank_name: '',
                            account_number: '',
                            disabled: '',
                        },
                        {
                            col_empl_cmid: '',
                            col_last_name: '',
                            col_midl_name: '',
                            col_frst_name: '',
                            col_suffix: '',
                            col_mart_stat: '',
                            col_home_addr: '',
                            col_curr_addr: '',
                            col_province: '',
                            col_city: '',
                            col_barangay: '',
                            col_birt_date: '',
                            col_empl_gend: '',
                            col_empl_nati: '',
                            col_shir_size: '',
                            col_empl_emai: '',
                            col_mobl_numb: '',
                            col_hire_date: '',
                            date_regular: '',
                            resignation_date: '',
                            col_endd_date: '',
                            col_empl_type: '',
                            col_empl_posi: '',
                            col_empl_company: '',
                            col_empl_branch: '',
                            col_empl_dept: '',
                            col_empl_divi: '',
                            col_empl_club: '',
                            col_empl_sect: '',
                            col_empl_group: '',
                            col_empl_team: '',
                            col_empl_line: '',
                            col_imag_path: '',
                            col_empl_sssc: '',
                            col_empl_hdmf: '',
                            col_empl_phil: '',
                            col_empl_btin: '',
                            col_empl_driv: '',
                            col_empl_naid: '',
                            col_empl_pass: '',
                            col_empl_hmoo: '',
                            col_empl_hmon: '',
                            salary_rate: '',
                            salary_type: '',
                            bank_name: '',
                            account_number: '',
                            disabled: '',
                        },
                        {
                            col_empl_cmid: '',
                            col_last_name: '',
                            col_midl_name: '',
                            col_frst_name: '',
                            col_suffix: '',
                            col_mart_stat: '',
                            col_home_addr: '',
                            col_curr_addr: '',
                            col_province: '',
                            col_city: '',
                            col_barangay: '',
                            col_birt_date: '',
                            col_empl_gend: '',
                            col_empl_nati: '',
                            col_shir_size: '',
                            col_empl_emai: '',
                            col_mobl_numb: '',
                            col_hire_date: '',
                            date_regular: '',
                            resignation_date: '',
                            col_endd_date: '',
                            col_empl_type: '',
                            col_empl_posi: '',
                            col_empl_company: '',
                            col_empl_branch: '',
                            col_empl_dept: '',
                            col_empl_divi: '',
                            col_empl_club: '',
                            col_empl_sect: '',
                            col_empl_group: '',
                            col_empl_team: '',
                            col_empl_line: '',
                            col_imag_path: '',
                            col_empl_sssc: '',
                            col_empl_hdmf: '',
                            col_empl_phil: '',
                            col_empl_btin: '',
                            col_empl_driv: '',
                            col_empl_naid: '',
                            col_empl_pass: '',
                            col_empl_hmoo: '',
                            col_empl_hmon: '',
                            salary_rate: '',
                            salary_type: '',
                            bank_name: '',
                            account_number: '',
                            disabled: '',
                        },
                        {
                            col_empl_cmid: '',
                            col_last_name: '',
                            col_midl_name: '',
                            col_frst_name: '',
                            col_suffix: '',
                            col_mart_stat: '',
                            col_home_addr: '',
                            col_curr_addr: '',
                            col_province: '',
                            col_city: '',
                            col_barangay: '',
                            col_birt_date: '',
                            col_empl_gend: '',
                            col_empl_nati: '',
                            col_shir_size: '',
                            col_empl_emai: '',
                            col_mobl_numb: '',
                            col_hire_date: '',
                            date_regular: '',
                            resignation_date: '',
                            col_endd_date: '',
                            col_empl_type: '',
                            col_empl_posi: '',
                            col_empl_company: '',
                            col_empl_branch: '',
                            col_empl_dept: '',
                            col_empl_divi: '',
                            col_empl_club: '',
                            col_empl_sect: '',
                            col_empl_group: '',
                            col_empl_team: '',
                            col_empl_line: '',
                            col_imag_path: '',
                            col_empl_sssc: '',
                            col_empl_hdmf: '',
                            col_empl_phil: '',
                            col_empl_btin: '',
                            col_empl_driv: '',
                            col_empl_naid: '',
                            col_empl_pass: '',
                            col_empl_hmoo: '',
                            col_empl_hmon: '',
                            salary_rate: '',
                            salary_type: '',
                            bank_name: '',
                            account_number: '',
                            disabled: '',
                        },
                        {
                            col_empl_cmid: '',
                            col_last_name: '',
                            col_midl_name: '',
                            col_frst_name: '',
                            col_suffix: '',
                            col_mart_stat: '',
                            col_home_addr: '',
                            col_curr_addr: '',
                            col_province: '',
                            col_city: '',
                            col_barangay: '',
                            col_birt_date: '',
                            col_empl_gend: '',
                            col_empl_nati: '',
                            col_shir_size: '',
                            col_empl_emai: '',
                            col_mobl_numb: '',
                            col_hire_date: '',
                            date_regular: '',
                            resignation_date: '',
                            col_endd_date: '',
                            col_empl_type: '',
                            col_empl_posi: '',
                            col_empl_company: '',
                            col_empl_branch: '',
                            col_empl_dept: '',
                            col_empl_divi: '',
                            col_empl_club: '',
                            col_empl_sect: '',
                            col_empl_group: '',
                            col_empl_team: '',
                            col_empl_line: '',
                            col_imag_path: '',
                            col_empl_sssc: '',
                            col_empl_hdmf: '',
                            col_empl_phil: '',
                            col_empl_btin: '',
                            col_empl_driv: '',
                            col_empl_naid: '',
                            col_empl_pass: '',
                            col_empl_hmoo: '',
                            col_empl_hmon: '',
                            salary_rate: '',
                            salary_type: '',
                            bank_name: '',
                            account_number: '',
                            disabled: '',
                        },
                        {
                            col_empl_cmid: '',
                            col_last_name: '',
                            col_midl_name: '',
                            col_frst_name: '',
                            col_suffix: '',
                            col_mart_stat: '',
                            col_home_addr: '',
                            col_curr_addr: '',
                            col_province: '',
                            col_city: '',
                            col_barangay: '',
                            col_birt_date: '',
                            col_empl_gend: '',
                            col_empl_nati: '',
                            col_shir_size: '',
                            col_empl_emai: '',
                            col_mobl_numb: '',
                            col_hire_date: '',
                            date_regular: '',
                            resignation_date: '',
                            col_endd_date: '',
                            col_empl_type: '',
                            col_empl_posi: '',
                            col_empl_company: '',
                            col_empl_branch: '',
                            col_empl_dept: '',
                            col_empl_divi: '',
                            col_empl_club: '',
                            col_empl_sect: '',
                            col_empl_group: '',
                            col_empl_team: '',
                            col_empl_line: '',
                            col_imag_path: '',
                            col_empl_sssc: '',
                            col_empl_hdmf: '',
                            col_empl_phil: '',
                            col_empl_btin: '',
                            col_empl_driv: '',
                            col_empl_naid: '',
                            col_empl_pass: '',
                            col_empl_hmoo: '',
                            col_empl_hmon: '',
                            salary_rate: '',
                            salary_type: '',
                            bank_name: '',
                            account_number: '',
                            disabled: '',
                        },
                        {
                            col_empl_cmid: '',
                            col_last_name: '',
                            col_midl_name: '',
                            col_frst_name: '',
                            col_suffix: '',
                            col_mart_stat: '',
                            col_home_addr: '',
                            col_curr_addr: '',
                            col_province: '',
                            col_city: '',
                            col_barangay: '',
                            col_birt_date: '',
                            col_empl_gend: '',
                            col_empl_nati: '',
                            col_shir_size: '',
                            col_empl_emai: '',
                            col_mobl_numb: '',
                            col_hire_date: '',
                            date_regular: '',
                            resignation_date: '',
                            col_endd_date: '',
                            col_empl_type: '',
                            col_empl_posi: '',
                            col_empl_company: '',
                            col_empl_branch: '',
                            col_empl_dept: '',
                            col_empl_divi: '',
                            col_empl_club: '',
                            col_empl_sect: '',
                            col_empl_group: '',
                            col_empl_team: '',
                            col_empl_line: '',
                            col_imag_path: '',
                            col_empl_sssc: '',
                            col_empl_hdmf: '',
                            col_empl_phil: '',
                            col_empl_btin: '',
                            col_empl_driv: '',
                            col_empl_naid: '',
                            col_empl_pass: '',
                            col_empl_hmoo: '',
                            col_empl_hmon: '',
                            salary_rate: '',
                            salary_type: '',
                            bank_name: '',
                            account_number: '',
                            disabled: '',
                        },
                ];
        
        function json_data(data) {
            return data.map(arg => arg.name);
        }

        const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.whiteSpace = 'nowrap';
            td.style.overflow = 'hidden';
            if (col === 0 || col === 1 || col === 3) {
                    td.style.backgroundColor = 'lightyellow';;
                };
        };

        const container = document.querySelector('#example');
        initializeHandsonTable(data);
        function initializeHandsonTable(data){
            hot = new Handsontable(container, {
            data,
            colHeaders: ['Employee ID', 'Last Name', 'Middle Name', 'First Name', 'Suffix', 'Birthday','Marital Status', 'Home Address', 'Current Address', 'Province','City','Barangay','Gender', 'Nationality', 'Shirt Size', 'Email Address', 'Mobile Number', 'Hired Date', 'Regularization Date', 'Resignation Date', 'Last Day Date', 'Employment Type', 'Position', 'Company', 'Branch', 'Department', 'Division','Clubhouse','Section', 'Groups', 'Team', 'Line', 'Image File', 'Bank Name','Bank Account Number', 'SSS Number', 'Pagibig', 'Philhealth', 'TIN', 'Drivers License', 'National ID', 'Passport', 'HMO', 'HMO Number', 'Salary Rate', 'Salary Type', 'Status'],
            rowHeaders: true,
            height: window.innerHeight - container.getBoundingClientRect().top - 30,
            outsideClickDeselects: false,
            selectionMode: 'multiple',
            licenseKey: 'non-commercial-and-evaluation',
            renderer: customStyleRenderer,
            minRows: 1,
            hiddenColumns: {
      columns: [41,42],
      indicators: true,
    },
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
                    data: 'col_birt_date', 
                    type: 'date',
                    dateFormat: 'DD/MM/YYYY',
                    correctFormat: false
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
                    data: 'col_province'
                },
                {
                    data: 'col_city'
                },
                {
                    data: 'col_barangay'
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
                    data: 'col_empl_club', 
                    type: 'dropdown',
                    source: json_data(cClubhouse),
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
                    data: 'bank_name'
                }, 
                {
                    data: 'account_number'
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
                {
                    data: 'disabled', 
                    type: 'dropdown',
                    source: ['Active', 'Inactive'],
                },
            ],
            hiddenColumns: {
                columns: <?php echo json_encode($HIDDEN_COLUMNS); ?>,
            },
        });
        }

        hot.updateSettings({
            cells: function(row, col, prop) {
                var cellProperties = {};
                if (col === 5) {
                    cellProperties.type = 'date';
                    cellProperties.dateFormat = 'DD/MM/YYYY';
                    cellProperties.correctFormat = false;
                    cellProperties.renderer = Handsontable.renderers.DateRenderer;
                    // Set the background color to light yellow for the date column
                    cellProperties.renderer = function(instance, td, row, col, prop, value, cellProperties) {
                        Handsontable.renderers.DateRenderer.apply(this, arguments);
                        td.style.backgroundColor = 'lightyellow';
                    };
                }
                return cellProperties;
            },
            
        });
        
        // const addRowButton = document.getElementById('btn-add-row');
        // addRowButton.addEventListener('click', function() {
        //     const selected = hot.getSelected() || [];

        //     if (selected.length === 0) {
        //         alert('Please select a row to add a new row below.');
        //         return;
        //     }
        //     const selectedIndex = selected[0][0];

        //     hot.alter('insert_row_below', selectedIndex);
        // });
        const addRowButton = document.getElementById('btn-add-row');
        addRowButton.addEventListener('click', function() {
        const lastRowIndex = hot.countRows() - 1;
        hot.alter('insert_row_below', lastRowIndex);
        });

        const deleteRowButton = document.getElementById('btn-delete-row');
        deleteRowButton.addEventListener('click', function() {
            const selectedRows = hot.getSelected() || [];

            if (selectedRows.length === 0) {
                alert('No rows selected. Please select rows to delete.');
                return;
            }

            if (selectedRows.length > 0) {
                const confirmed = confirm('Are you sure you want to delete the selected row?');
                if (confirmed) {

                    const rowsToDelete = new Set();

                    selectedRows.forEach(range => {
                        const [row1, _column1, row2, _column2] = range;
                        for (let rowIndex = Math.min(row1, row2); rowIndex <= Math.max(row1, row2); rowIndex++) {
                            rowsToDelete.add(rowIndex);
                        }
                    });

                    const sortedRowsToDelete = Array.from(rowsToDelete).sort((a, b) => b - a);

                    sortedRowsToDelete.forEach(rowIndex => {
                        hot.alter('remove_row', rowIndex);
                    });

                    hot.deselectCell();

                }
            }
        });

        var insert = document.getElementById('btn-insert');
        insert.addEventListener('click', function() {
            if (!data || !Array.isArray(data) || data.length < 0) {
                $(document).Toasts('create', {
                    class: 'bg-warning toast_width',
                    title: 'Warning!',
                    subtitle: 'close',
                    body: "Cannot upload with empty row!"
                });
                return;
            }
            
            let requiredEmptyList = [];
            let send = false;
            let data2 = [];
            // for (let i = 0; i < data.length; i++) {
            for (let i = data.length - 1; i >= 0; i--) {
                const requiredList = [{
                        column: 'col_empl_cmid',
                        name: 'Employee ID'
                    },
                    {
                        column: 'col_last_name',
                        name: 'Lastname'
                    },
                    {
                        column: 'col_frst_name',
                        name: 'Firstname'
                    },
                    {
                        column: 'col_birt_date',
                        name: 'Birth Date'
                    },
                ]
                const obj = data[i];
                for (const key in obj) {
                    // console.log(`key{${i}}`, obj[key])
                    requiredList.forEach((item) => {
                        if ((obj[key] == null || obj[key] == '') && key == item.column) {
                            requiredEmptyList.push(item.name)
                        }
                    });

                }
                // console.log('requiredEmptyList', requiredEmptyList);
                if(requiredEmptyList.length < 1){
                    data2.push(data[i]);
                    data.splice(i, 1);
                }else if (requiredEmptyList.length > 0 && requiredEmptyList.length < 4) {
                    let rowWith = 'with';
                    if(data[i].col_empl_cmid){rowWith=`${rowWith} ID:${data[i].col_empl_cmid}`;}
                    if(data[i].col_last_name){rowWith=`${rowWith} Lastname:${data[i].col_last_name}`;}
                    if(data[i].col_frst_name){rowWith=`${rowWith} Firstname:${data[i].col_frst_name}`;}
                    if(data[i].col_birt_date){rowWith=`${rowWith} Firstname:${data[i].col_birt_date}`;}
                    $(document).Toasts('create', {
                    class: 'bg-danger toast_width',
                    title: 'Error!',
                    subtitle: 'close',
                    body: `Cannot add with empty ${requiredEmptyList} on row ${rowWith}`
                    });
                    // break;
                    // console.log('data',data);
                    // console.log('required')
                }

                requiredEmptyList = [];
            }
            if (data.length < 10) {
            var rowsToAdd = 10 - data.length;
            for (var i = 0; i < rowsToAdd; i++) {
                data.push({
                            col_empl_cmid: '',
                            col_last_name: '',
                            col_midl_name: '',
                            col_frst_name: '',
                            col_suffix: '',
                            col_mart_stat: '',
                            col_home_addr: '',
                            col_curr_addr: '',
                            col_province: '',
                            col_city: '',
                            col_barangay: '',
                            col_birt_date: '',
                            col_empl_gend: '',
                            col_empl_nati: '',
                            col_shir_size: '',
                            col_empl_emai: '',
                            col_mobl_numb: '',
                            col_hire_date: '',
                            date_regular: '',
                            resignation_date: '',
                            col_endd_date: '',
                            col_empl_type: '',
                            col_empl_posi: '',
                            col_empl_company: '',
                            col_empl_branch: '',
                            col_empl_dept: '',
                            col_empl_divi: '',
                            col_empl_club: '',
                            col_empl_sect: '',
                            col_empl_group: '',
                            col_empl_team: '',
                            col_empl_line: '',
                            col_imag_path: '',
                            col_empl_sssc: '',
                            col_empl_hdmf: '',
                            col_empl_phil: '',
                            col_empl_btin: '',
                            col_empl_driv: '',
                            col_empl_naid: '',
                            col_empl_pass: '',
                            col_empl_hmoo: '',
                            col_empl_hmon: '',
                            salary_rate: '',
                            salary_type: '',
                            bank_name: '',
                            account_number: '',
                            disabled: '',
                        });
            }
            }
            hot.updateSettings({data});
            console.log('data', data);
            console.log('data2', data2);
            if (data2.length < 1) {
                $(document).Toasts('create', {
                    class: 'bg-warning toast_width',
                    title: 'Warning!',
                    subtitle: 'close',
                    body: "No rows with Employee ID, Last Name, First Name and Birthday"
                });
                return;
            }
      
            fetch(url + 'employees/insert_data', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data2),
                })
                .then(response => {
                    if (response.url.includes('session_expired')) {
                        window.location.reload();
                        return;
                    }
                    return response.json()
                })
                .then(result => {
                    console.log(result);

                    if (result.messageSuccess) {
                        $(document).Toasts('create', {
                            class: 'bg-success toast_width',
                            title: 'Success!',
                            subtitle: 'close',
                            body: result.messageSuccess
                        })
                    }

                    if (result.messageError) {
                        $(document).Toasts('create', {
                            class: 'bg-warning toast_width',
                            title: 'Warning!',
                            subtitle: 'close',
                            body: result.messageError
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
    </script>
</body>

</html>