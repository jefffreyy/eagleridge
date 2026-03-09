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
                        <h1 class="page-title"><a href="<?= base_url() . 'attendances/attendance_records'; ?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Quick Attendance Record View</h1>
                    </div>
                    <div class="col ml-auto button-title">
                        <!-- <a class="btn btn-primary mt-1" title="Add" href="<?= base_url() ?>employees/upload_employee_photo">
                            <i class="fas fa-fw fa-upload"></i> Upload Employee Photo
                        </a> -->
                        <!-- <button class="btn btn-primary" id="btn-insert"><i class="fa-solid fa-pen-to-square"></i> Update data</button>    -->
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
        // var cUserAccess = <?php echo json_encode($C_USER_ACCESS); ?>;
        // var cMarital = <?php echo json_encode($C_MARITAL); ?>;
        // var cGenders = <?php echo json_encode($C_GENDERS); ?>;
        // var cNationality = <?php echo json_encode($C_NATIONALITY); ?>;
        // var cShirtSize = <?php echo json_encode($C_SHIRT_SIZE); ?>;
        // var cType = <?php echo json_encode($C_TYPE); ?>;
        // var cPositions = <?php echo json_encode($C_POSITIONS); ?>;
        // var cDivisions = <?php echo json_encode($C_DIVISIONS); ?>;
        // var cGroups = <?php echo json_encode($C_GROUPS); ?>;
        // var cLines = <?php echo json_encode($C_LINES); ?>;
        // var cDepartments = <?php echo json_encode($C_DEPARTMENTS); ?>;
        // var cSections  = <?php echo json_encode($C_SECTIONS); ?>;
        // var cHmo  = <?php echo json_encode($C_HMO); ?>;

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

            });
        }
    


    
        
    </script>



</body>

</html>