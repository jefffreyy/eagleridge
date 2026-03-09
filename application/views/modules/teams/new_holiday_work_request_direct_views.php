<html>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?= base_url() ?>assets_system/css/handsontable14.css" />
<body>
    <div class="content-wrapper">
        <div class="p-3">
            <div class="flex-fill">
                <div class="row pr-3 mb-3">
                    <div class="col">
                        <h1 class="page-title"><a href="<?= base_url() . 'teams/apply_holiday_works'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
            </a>&nbsp;Add Holiday Work<h1>
                    </div>
                    <div class="col ml-auto button-title">
         
                        <button class="btn btn-primary" id="btn-insert"><i class="fa-solid fa-circle-arrow-up"></i> Upload Data</button>
                    </div>
                </div>

                <div class="card">
                    <div class="col mb-5 mt-2">
                    <button class="btn btn-primary" id="btn-add-row"><img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">&nbsp;Add Row</button>
                        <button class="btn btn-danger" id="btn-delete-row"><i class="fa-duotone fa-circle-minus"></i> Delete Row</button>
                    </div>
                    <p style="margin:0;padding:4px;color: #dc3545;">Employee, Shift Date, Overtime Hours are required*</p>
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
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
    <script type="text/javascript" src="<?= base_url() ?>assets_system/js/handsontable14.js"></script>

    <script>
        var employeeList = <?php echo json_encode($DISP_EMPLOYEES_NONFILTERED); ?>;

        let data = 
                [
                    {
                        employee: '',
                        date: '',
                        hours: '',
                        comment: '',
                    },
                    {
                        employee: '',
                        date: '',
                        hours: '',
                        comment: '',
                    },
                    {
                        employee: '',
                        date: '',
                        hours: '',
                        comment: '',
                    },
                    {
                        employee: '',
                        date: '',
                        hours: '',
                        comment: '',
                    },
                    {
                        employee: '',
                        date: '',
                        hours: '',
                        comment: '',
                    },
                    {
                        employee: '',
                        date: '',
                        hours: '',
                        comment: '',
                    },
                    {
                        employee: '',
                        date: '',
                        hours: '',
                        comment: '',
                    },
                    {
                        employee: '',
                        date: '',
                        hours: '',
                        comment: '',
                    },
                    {
                        employee: '',
                        date: '',
                        hours: '',
                        comment: '',
                    },
                    {
                        employee: '',
                        date: '',
                        hours: '',
                        comment: '',
                    },
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
                cmid:obj.col_empl_cmid
            })
            return employeeNameWithCMID;
        });

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
                'Shift Date','Overtime Hours',
                'Remarks',
                ],
                ],
                rowHeaders: true,
                height: window.innerHeight - container.getBoundingClientRect().top - 30,
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
                {data:'employee',readOnly: false, type: 'dropdown', source: employeeIds, width: 200, wordWrap: false},
                {data:'date',readOnly: false,type: 'date',
                dateFormat: 'DD/MM/YYYY', 
                correctFormat: false}, 
                {data:'hours',readOnly: false,
                validator: function(value, callback) {
                    if (!isNaN(value) && value >= 0.1 && value <= 99) {
                    callback(true);
                    } else {
                    callback(false, 'Value must be greater than 0'); 
                    }
                  }
                }, 
                {data:'comment',readOnly: false, width: 340}, 
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
                let employeeInvalid = '';
                let requestDateInvalid = '';
                let requestDurationInvalid = '';
                valid = true;
                var temp = { ...data[i] };

                if (data[i].employee) {
                    const check = employeeIdsCopywithCMID.find(obj => obj.employeeNameWithCMID === data[i].employee);
                    if (check) {
                        temp.employee=check.cmid;
                    } else {
                        employeeInvalid = `Employee in Invalid.`;
                        valid = false;
                    }
                }else{
                    employeeInvalid = `Employee is Empty.`;
                    valid = false;
                }
                if (data[i].date) {
                    if (isValidDateFormat(data[i].date)) {
                    const parts = data[i].date.split('/');
                    const mysqlDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
                    temp.date=mysqlDate;
                    }else{
                        requestDateInvalid = `Date is Invalid.`;
                        valid = false;
                    }
                } else {
                    requestDateInvalid = `Date is Empty.`;
                    valid = false;
                }
                if (data[i].hours) {
                    if (!isNaN(data[i].hours) && Number(data[i].hours) >= 0.1 && Number(data[i].hours) <= 99) {
                } else {
                        requestDurationInvalid = `Working Hours is Invalid.`;
                        valid = false;
                    }
                } else {
                    requestDurationInvalid = `Working Hours is Empty.`;
                    valid = false;
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
                    body: "No rows with valid Employee, Overtime Date and Overtime Duration"
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
            fetch(url + 'overtimes/insert_holiday_work_direct', {
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
    </script>
</body>

</html>