<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="<?php echo base_url()?>/assets_system/css/handsontable14.css" />


<div class="content-wrapper">
    <div id="loadingOverlay" class="loading-overlay" hidden>
    <div class="loading-spinner"></div>
    </div>
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title">&nbsp;Add Data<h1>
            </div>
            <div class="col-md-6 button-title">
            </div>
        </div>
        <div class="card border-0 p-0 m-0">
            <div class="card border-0 py-1 m-0">
                <div class="p-2">
                    <div>
                        <button class="btn btn-success" id="btn-add-row"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-plus-solid_xs.svg') ?>" alt="" />&nbsp;Add Row</button>
                        <button class="btn btn-danger" id="btn-delete-row"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-minus-solid_xs.svg') ?>" alt="" /> Delete Row</button>
                        <button onclick="afterRenderFunction()" class="btn btn-primary" id="btn-update"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="py-2">
                            <div id="table_data_new"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('templates/jquery_link'); ?>

<script type="text/javascript" src="<?php echo base_url()?>/assets_system/js/handsontable14.js"></script>
<script>
    var url = '<?= base_url() ?>';
    var employees = <?= json_encode($DISP_EMPLOYEELIST); ?>;

    var data = employees.map(function(employee) {
        return {
        id: employee.id,
        col_empl_cmid: employee.col_empl_cmid,
        col_frst_name: employee.col_frst_name,
        col_last_name: employee.col_last_name,
        
        };
    });

    const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        td.style.whiteSpace = 'nowrap';
        td.style.overflow = 'hidden';
    };
    const container = document.querySelector('#table_data_new');
    hot = new Handsontable(container, {
        data: data,
        colHeaders: ['ID', 'Employee Id', 'Firstname', 'Lastname'],
        rowHeaders: true,
        height: 'auto',
        outsideClickDeselects: false,
        selectionMode: 'multiple',
        licenseKey: 'non-commercial-and-evaluation',
        renderer: customStyleRenderer_new,
        stretchH: 'all',
        hiddenColumns: {
            columns: [0],
            indicators: true,
        },
        columns: [{
                data: 'id'
            },
            {
                data: 'col_empl_cmid'
            },
            {
                data: 'col_frst_name'
            },
            {
                data: 'col_last_name'
            },
      
        ]
    });

    hot.updateSettings({
        height: window.innerHeight - container.getBoundingClientRect().top - 50,
    });

    const addRowButton = document.getElementById('btn-add-row');
        addRowButton.addEventListener('click', function() {
        const totalRows = hot.countRows();
        hot.alter('insert_row_below', totalRows);
        hot.updateSettings({
            // columns: columns,
        });
    });


    const deleteRowButton = document.getElementById('btn-delete-row');
    deleteRowButton.addEventListener('click', function() {
        const selectedRows = hot.getSelected() || [];
        // console.log('selectedRows', selectedRows);
        if (selectedRows.length === 0) {
            alert('No rows selected. Please select rows to delete.');
            return;
        }
        if (selectedRows.length > 0) {
            const confirmed = confirm('Are you sure you want to delete the selected row?');
            if (confirmed) {
                const rowsToDelete = new Set();
                const idsToDelete = [];
                selectedRows.forEach(range => {
                    const [row1, _column1, row2, _column2] = range;
                    for (let rowIndex = Math.min(row1, row2); rowIndex <= Math.max(row1, row2); rowIndex++) {
                        const id = hot.getDataAtCell(rowIndex, hot.propToCol('id'));
                        idsToDelete.push(id);
                        rowsToDelete.add(rowIndex);
                    }
                });
  
                if (idsToDelete.length > 0) {
                    // console.log('idsToDelete > 0', idsToDelete);
                    fetch(url + 'handsontable_test/delete_data', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(idsToDelete)
                        })
                        .then(response => response.json())
                        .then(result => {
                            // console.log(result);
                            if (result.success_message) {
                                $(document).Toasts('create', {
                                    class: 'bg-success toast_width',
                                    title: 'Success!',
                                    subtitle: 'close',
                                    body: result.success_message
                                });
                                const sortedRowsToDelete = Array.from(rowsToDelete).sort((a, b) => b - a);
                                sortedRowsToDelete.forEach(rowIndex => {
                                    hot.alter('remove_row', rowIndex);
                                });
                            } else if (result.warning_message) {
                                $(document).Toasts('create', {
                                    class: 'bg-warning toast_width',
                                    title: 'Error!',
                                    subtitle: 'close',
                                    body: result.warning_message
                                })
                            } 
                            
                            // else {
                            //     $(document).Toasts('create', {
                            //         class: 'bg-warning toast_width',
                            //         title: 'Error!',
                            //         subtitle: 'close',
                            //         body: 'Failed to delete!'
                            //     })
                            // }
                        })
                        .catch(error => {
                            console.error('Data deletion error:', error);
                            return;
                        });
                }
                hot.deselectCell();
            }
        }
    });


    var udpate_date = document.getElementById('btn-update');
    udpate_date.addEventListener('click', function() {
        const confirmed = confirm('Are you sure you want to update the data?');
        if (!confirmed) {
            return;
        }
        const updatedData = hot.getData();

        let combinedUpdateData = {
            updatedData : updatedData,
        }

        fetch(url + 'handsontable_test/update_data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(combinedUpdateData)
            })
            .then(response => response.json())
            .then(result => {
                // console.log(result);
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
                var loadingOverlay = document.getElementById('loadingOverlay');
                loadingOverlay.hidden = true;
            })
            .catch(error => {
                $(document).Toasts('create', {
                    class: 'bg-warning toast_width',
                    title: 'Warning!',
                    subtitle: 'close',
                    body: 'Please provide all required information.'
                })
                console.error('Data update error:', error);
                var loadingOverlay = document.getElementById('loadingOverlay');
                loadingOverlay.hidden = true;
            });
    });
</script>


</body>

</html>