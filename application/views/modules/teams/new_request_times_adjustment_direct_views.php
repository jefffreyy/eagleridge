<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<style>
    .handsontable .wtHolder .wtHider{
        /* margin-bottom: 50px; */
        height: 70vh !important;
    }
</style>
<body>
    <div class="content-wrapper">
        <div class="p-3">
            <div class="flex-fill">
                <div class="row pr-3 mb-3">
                    <div class="col">
                        <h1 class="page-title"><a href="<?= base_url('teams/apply_time_adjustments')?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Add Time Adjustments</h1>
                    </div>
                    <div class="col ml-auto button-title">
         
                        <button class="btn btn-primary" id="btn-insert"><i class="fa-solid fa-circle-arrow-up"></i> Upload Data</button>
                    </div>
                </div>

                <div class="card">
                    <div class="col mb-5 mt-2">
                        <button class="btn btn-success" id="btn-add-row"><i class="fa-duotone fa-circle-plus"></i> Add Row</button>
                        <button class="btn btn-danger" id="btn-delete-row"><i class="fa-duotone fa-circle-minus"></i> Delete Row</button>
                    </div>
                    <p style="margin:0;padding:4px;color: #dc3545;">Employee,Date, Time In and Time Out are required*</p>
                    <div id="example"></div>

                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('templates/jquery_link'); ?>

    <?php
    if ($this->session->userdata('success')) {
    ?>
        <script>Swal.fire('<?php echo $this->session->userdata('success'); ?>','','success')</script>
    <?php $this->session->unset_userdata('success');
    }
    ?>
    <?php
    if ($this->session->flashdata('SUCC')) {
    ?>
        <!-- <script>Swal.fire('<?php echo $this->session->flashdata('flashdata'); ?>','','success')</script> -->
        <script>
            $(document).Toasts('create', {
                class: 'bg-success toast_width',
                title: 'Success',
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
        <!-- <script>
        Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>',
                '',
                'error'
            )
        </script> -->
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

    <script>
        $(document).ready(function (){
        var employeeList = <?php echo json_encode($DISP_EMPLOYEES_NONFILTERED); ?>;
        
        let data = 
                [
                    {
                        empl_id: '',
                        date_adjustment: '',
                        time_in_1: '',
                        time_out_1: '',
                        remarks:''
                    }
                ];
        
        let employeeIdsCopywithCMID =[];
        
        const employeeIds = employeeList.map(obj => {
            let employeeNameWithCMID = '';
            if(obj.col_empl_cmid)employeeNameWithCMID = `${obj.col_empl_cmid}`;
            if(obj.col_last_name)employeeNameWithCMID = `${obj.col_empl_cmid}-${obj.col_last_name}`;
            if (obj.col_suffix)employeeNameWithCMID = `${employeeNameWithCMID} ${obj.col_suffix}`;
            if (obj.col_frst_name)employeeNameWithCMID = `${employeeNameWithCMID}, ${obj.col_frst_name}`;
            if (obj.col_midl_name)employeeNameWithCMID = `${employeeNameWithCMID} ${obj.col_midl_name[0]}.`;
            // let employeeNameWithCMID = `${lastnameSuffix}, ${obj.col_suffix}`;
            // const employeeNameWithCMID = `${obj.col_empl_cmid}-${obj.col_last_name}, ${obj.col_frst_name} ${obj.col_midl_name.charAt(0).padEnd(2, '.')}`
            employeeIdsCopywithCMID.push({
                employeeNameWithCMID: employeeNameWithCMID,
                cmid:obj.col_empl_cmid,
                id:obj.id
            })
            return {label:employeeNameWithCMID,value:obj.id};
        });
        console.log(employeeIds)
        console.log(employeeIdsCopywithCMID);
        const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.whiteSpace = 'nowrap';
            td.style.overflow = 'hidden';
            // if (col === 0 || col === 1 || col === 2) {
            //         td.style.backgroundColor = 'lightyellow';;
            //     };
        };

        const container = document.querySelector('#example');
        initializeHandsontable(data);

        function initializeHandsontable(data) {
            const container = document.querySelector('#example');
            hot = new Handsontable(container, {
                data,  
                readOnly: true,
                nestedHeaders: [
                ['Employee',
                'Date','Time In','Time Out',
                'Remarks',
                ],
                ],
                minRows:10,
                rowHeaders: true,
                height: 'auto',
                outsideClickDeselects: false,
                selectionMode: 'multiple',
                licenseKey: 'non-commercial-and-evaluation',
                // Custom renderer to prevent text wrapping
                renderer: customStyleRenderer,
                // readOnly: false,
                hiddenColumns: {
            //   columns: [0],
                // indicators: true,
                },
                stretchH: 'all',
                columns: [ 
                {data:'empl_id',readOnly: false, type: 'dropdown', source: employeeIds.map(option => option.label), width: 200, wordWrap: false},
                {data:'date_adjustment',readOnly: false,type: 'date',
                dateFormat: 'DD/MM/YYYY', 
                correctFormat: false},
                {data:'time_in_1',readOnly: false,type:'time',timeFormat: 'H:mm:ss',correctFormat: true},
                {data:'time_out_1',readOnly: false,type:'time',timeFormat: 'H:mm:ss',correctFormat: true},
                {data:'remarks',readOnly: false, width: 340}, 
                ],
            });
        }

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

            function isValidDateFormat(dateString) {
              const dateFormatRegex = /^\d{2}\/\d{2}\/\d{4}$/;
              return dateFormatRegex.test(dateString);
            }

            let requiredEmptyList = [];
            let send = false;
            let changesFinal = [];
            let validRows = [];
            let invalidRows = [];
            for (var i = 0; i < data.length; i++) {
                data[i].assigned_by="<?=$this->session->userdata('SESS_USER_ID')?>"
                data[i].create_date="<?=date('Y-m-d H:i:s')?>"
                data[i].edit_date="<?=date('Y-m-d H:i:s')?>"
                let employeeInvalid = '';
                let requestDateInvalid = '';
                let requestDurationInvalid = '';
                valid = true;
                var temp = { ...data[i] };
                
                if (data[i].empl_id) {
                    console.log(data[i]);
                    const check = employeeIdsCopywithCMID.find(obj => obj.employeeNameWithCMID === data[i].empl_id);
                    if (check) {
                        temp.empl_id=check.id;
                    } else {
                        employeeInvalid = `Employee in Invalid.`;
                        valid = false;
                    }
                }else{
                    employeeInvalid = `Employee is Empty.`;
                    valid = false;
                }
                if (data[i].date_adjustment) {
                    if (isValidDateFormat(data[i].date_adjustment)) {
                    const parts = data[i].date_adjustment.split('/');
                    const mysqlDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
                    temp.date_adjustment=mysqlDate;
                    }else{
                        requestDateInvalid = `Overtime Date is Invalid.`;
                        valid = false;
                    }
                } else {
                    requestDateInvalid = `Overtime Date is Empty.`;
                    valid = false;
                }
                if (! data[i].time_in_1){
                    requestDurationInvalid = `Time In Empty Value.`;
                    valid = false;
                }
                if (! data[i].time_out_1){
                    requestDurationInvalid = `Time Out Empty Value.`;
                    valid = false;
                }
                if (!data[i].remarks){
                    data[i].remarks="";
                }
                
                if (valid) {
                    changesFinal.push(temp);
                    validRows.push(i+1);
                }else{
                    if (!employeeInvalid || !requestDateInvalid || !requestDurationInvalid) {
                        invalidRows.push(i+1);
                    }
                }
                // console.log('employeeInvalid '+i, employeeInvalid);
                // console.log(`data[${i}].employee`, data[i].employee);
                // console.log(`data[${i}].employee`, data[i].employee? true: false);
                // console.log('requestDateInvalid '+i, requestDateInvalid);
                // console.log('requestDurationInvalid '+i, requestDurationInvalid);
            }

            console.log('data', data);
            console.log('changesFinal', changesFinal);
            if (changesFinal.length < 1) {
                $(document).Toasts('create', {
                    class: 'bg-warning toast_width',
                    title: 'Warning!',
                    subtitle: 'close',
                    body: "No rows with valid Employee, Date , Time In and Time Out"
                });
                return;
            }
            const changesLeavesInvalidString = 
            invalidRows.length > 0? `Row${invalidRows.length > 1? 's': ''} ${invalidRows.join(', ')} ${invalidRows.length > 1? 'have': 'has'} invalid input and will not be added` 
              : '';
            const confirmed = confirm(`Are you sure you want to add row: ${validRows.join(', ')} ? ${changesLeavesInvalidString? changesLeavesInvalidString : '' }`);
            if (!confirmed) {
                return; 
            }
            
            var url          = '<?= base_url() ?>'; 
            fetch(url + 'teams/insert_time_adjustment_direct', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(changesFinal),
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
                console.log('result', result);
                return;
                if(result.reload){
                  location.reload();
                }else if (result.messageSuccess) {
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
        })
    </script>
</body>

</html>