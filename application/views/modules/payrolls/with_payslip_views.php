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
                        <h1 class="page-title"><a href="<?= base_url() . 'payrolls/payslip_generator'; ?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Quick Payslip View</h1>
                    </div>
                    <div class="col ml-auto button-title">
                        <!-- <a class="btn btn-primary mt-1" title="Add" href="<?= base_url() ?>employees/upload_employee_photo">
                            <i class="fas fa-fw fa-upload"></i> Upload Employee Photo
                        </a> -->
                        <!-- <button class="btn btn-primary" id="btn-update"><i class="fa-solid fa-pen-to-square"></i> Update data</button>    -->
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
        var payslips = <?php echo json_encode($PAYSLIPS); ?>;

        console.log(payslips)


        const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.whiteSpace = 'nowrap';
            td.style.overflow = 'hidden';
        };


       
        const container = document.querySelector('#example');
        hot = new Handsontable(container, {
            data: payslips, 
            colHeaders: ["Payslip Id", "Employee Id","Employee Name","Salary Rate","Salary Type", "Daily Rate", "Hourly Rate", "Period", "Present", "Absent", "Tardiness", "Undertime", "Paid Leave", "REG Hours", 
            "REG OT", "REG ND", "REG NDOT", "Rest Hours", "Rest OT", "Rest ND", "Rest NDOT", "LEG Hours", "LEG OT", "LEG ND", "LEG NDOT", "Legrest Hours", "Legrest OT", "Legrest ND", "Legrest NDOT", 
            "SPE hours", "SPE OT", "SPE ND", "SPE NDOT", "Sperest Hours", "Sperest OT", "Sperest ND", "Sperest NDOT", "Earnings", "Deduction", "WTAX", "Net Income", "Loan Id", "Gross Income", 
            "SSS EE Current", "Pagibig EE Current", "PhilHealth EE Current", "SSS ER Current", "SSS EC ER Current", "PagIbig ER Current", "PhilHealth ER Current", "CA Id", "Deduct Id", "Status", "Loan List", "CA List", "Deduct List"],
            rowHeaders: true,
            stretchH: 'all',
            height: 'auto',
            outsideClickDeselects: false,
            selectionMode: 'multiple',
            licenseKey: 'non-commercial-and-evaluation',
            // Custom renderer to prevent text wrapping
            renderer: customStyleRenderer,
            hiddenColumns: {
                columns: [0],
                indicators: true,
            },
            readOnly: true,
        });
       
    
        
    </script>



</body>

</html>