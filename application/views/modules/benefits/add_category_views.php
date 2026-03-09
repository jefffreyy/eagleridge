<html>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?php echo base_url()?>/assets_system/css/handsontable14.css" />

<?php
$search_data  = $this->input->get('all');
$search_data  = str_replace("_", " ", $search_data ?? '');
$PAGE         = 1;
$C_DATA_COUNT = 0;
$PAGES_COUNT  = 0;
$TAB          = 'active';
$ACTIVES      = 0;
$INACTIVES    = 0;
$ROW          = 25;
$current_page = $PAGE;
$next_page    = $PAGE + 1;
$prev_page    = $PAGE - 1;
$last_page    = $PAGES_COUNT;
$row          = $ROW;
if ($C_DATA_COUNT == 0) {
    $low_limit = 0;
} else {
    $low_limit = $row * ($current_page - 1) + 1;
}
if ($current_page * $row > $C_DATA_COUNT) {
    $high_limit = $C_DATA_COUNT;
} else {
    $high_limit = $row * ($current_page);
}
?>
<style>
      .loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    
  }
  .loading-spinner {
    border: 4px solid #f3f3f3; 
    border-top: 4px solid #3498db; 
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite; 
  }
  
</style>

<div class="content-wrapper">
    <div id="loadingOverlay" class="loading-overlay" hidden>
    <div class="loading-spinner"></div>
    </div>
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title"><a href="<?= base_url() . 'benefits/taxable'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 5px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Add Category<h1>
            </div>
            <div class="col-md-6 button-title">
            </div>
        </div>
        <div class="card border-0 p-0 m-0">
            <div class="card border-0 py-1 m-0">
                <div class="card-header d-none p-0">
                    <div class="row ">
                        <div class="col-xl-8 ">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link head-tab <?= $TAB == 'Active' ? 'active' : '' ?> " href="?page=1&row=<?= $row ?>&tab=Active" id="tab-Active" style='cursor:pointer'>
                                        Active
                                        <span class="ml-2 badge badge-pill badge-secondary"><?= $ACTIVES ?></span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="?page=1&row=<?= $row ?>&tab=Inactive" class="nav-link head-tab <?= $TAB == 'Inactive' ? 'active' : '' ?>" id="tab-Inactive" style='cursor:pointer'>
                                        Inactive
                                        <span class="ml-2 badge badge-pill badge-secondary"><?= $INACTIVES ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xl-4">
                            <div class="input-group pb-1">
                                <?php
                                if ($search_data) { ?>
                                    <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none d-flex align-items-center"><img style="height: 1rem; width: 1rem;" src="<?= base_url('assets_system/icons/broom-wide-sharp-solid.svg') ?>" alt="">&nbsp;Clear</button>
                                <?php } else { ?>
                                    <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none  d-flex align-items-center"><img src="<?= base_url('assets_system/icons/magnifying-glass-solid.svg') ?>" alt="">&nbsp;Search</button>
                                <?php } ?>
                                <input type="text" class="form-control" placeholder="Search..." value="<?= ($search_data) ? $search_data : "" ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2">
                    <div>
                        <button class="btn btn-success" id="btn-add-row"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-plus-solid_xs.svg') ?>" alt="" />&nbsp;Add Row</button>
                        <button class="btn btn-danger" id="btn-delete-row"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-minus-solid_xs.svg') ?>" alt="" /> Delete Row</button>
                        <button onclick="afterRenderFunction()" class="btn btn-primary" id="btn-update"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                    </div>
                    <div class="col-12 col-lg-2">
                        <p class="p-0 my-1 text-bold">Type</p>
                        <select class="form-control type_filter" id="filter_by_type">
                            <?php foreach ($DISP_FIXED_TYPE as $type) { ?>
                                <option value="<?= $type->id ?>" <?= $TYPE == $type->id ? 'selected' : '' ?>>  <?= $type->name ?></option>
                            <?php } ?>
                        </select>
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
<form id='builk_activate' method='post' action="<?= base_url('payrolls/bulk_activate') ?>">
    <input type='hidden' name='active' id='active_loans' />
    <input type='hidden' name='table' value='tbl_payroll_loan' />
</form>
<form id='builk_inactivate' method='post' action="<?= base_url('payrolls/bulk_inactivate') ?>">
    <input type='hidden' name='inactive' id='inactive_loans' />
    <input type='hidden' name='table' value='tbl_payroll_loan' />
</form>
<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p style="font-size: 400px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <p>Hi are you sure you want to logout?
                </p>
            </div>
            <div class="modal-footer pb-1 pt-1">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                </button>
                <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout
                </a>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('templates/jquery_link'); ?>
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script type="text/javascript" src="<?php echo base_url()?>/assets_system/js/handsontable14.js"></script>
<script>
    var url = '<?= base_url() ?>';
    var fixedType = <?= json_encode($DISP_FIXED_TYPE); ?>;
    var categories = <?= json_encode($DISP_CATEGORIES); ?>;

console.log(categories)
    var fixed_type = fixedType.map(function(item) {
        return item.name;
    });

    const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        td.style.whiteSpace = 'nowrap';
        td.style.overflow = 'hidden';
    };
    const container = document.querySelector('#table_data_new');
    hot = new Handsontable(container, {
        data: categories,
        colHeaders: ['ID', 'Name', 'Value'],
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
                data: 'name'
            },
            {
                data: 'value',
                type: 'numeric',
                renderer: function(instance, td, row, col, prop, value, cellProperties) {
                    Handsontable.renderers.TextRenderer.apply(this, arguments);
                    td.style.textAlign = 'right';
                    
                    if (value === null || value === undefined || value === '') {
                        td.innerHTML = '<span style="float: left;">&#8369;</span>0.00';
                    } else if (!isNaN(value)) {
                        var numericValue = parseFloat(value);
                        if (numericValue >= 0 && numericValue <= 1000000) {
                            var formattedValue = numericValue.toFixed(2);
                            td.innerHTML = '<span style="float: left;">&#8369;</span>' + formattedValue;
                        } else {
                            td.innerHTML = '<span style="color: red;">Invalid value</span>';
                            if (!td.hasEventListener) {
                                window.alert('Invalid value. Please input a valid amount.');
                                td.hasEventListener = true;
                                td.addEventListener('click', function() {
                                    instance.setDataAtCell(row, col, 0.00);
                                });
                            }
                        }
                    } else {
                        td.innerHTML = '<span style="color: red;">Invalid input</span>';
                        if (!td.hasEventListener) {
                            window.alert('Invalid input. Please input a valid number.');
                            td.hasEventListener = true;
                            td.addEventListener('click', function() {
                                instance.setDataAtCell(row, col, 0.00);
                            });
                        }
                    }
                }
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
        console.log('selectedRows', selectedRows);
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
                console.log('rowsToDelete', rowsToDelete);
                console.log('idsToDelete', idsToDelete);
                if (idsToDelete.length > 0) {
                    console.log('idsToDelete > 0', idsToDelete);
                    fetch(url + 'benefits/delete_fixed_type', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(idsToDelete)
                        })
                        .then(response => response.json())
                        .then(result => {
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
                            } else {
                                $(document).Toasts('create', {
                                    class: 'bg-warning toast_width',
                                    title: 'Error!',
                                    subtitle: 'close',
                                    body: 'Failed to delete!'
                                })
                            }
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

    let type = document.getElementById('filter_by_type').value;

    var udpate_date = document.getElementById('btn-update');
    udpate_date.addEventListener('click', function() {
        const confirmed = confirm('Are you sure you want to update the data?');
        if (!confirmed) {
            return;
        }
        const updatedData = hot.getData();

        let combinedUpdateData = {
            updatedData : updatedData,
            type : type,
        }


        fetch(url + 'benefits/insert_category', {
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

<script>
  function afterRenderFunction(){
    var loadingOverlay = document.getElementById('loadingOverlay');
    loadingOverlay.hidden = false;
  }
</script>

<script>
    $(document).ready(function() {
        $('select.cut_off_period').on('change', function() {
            window.location.href = "<?= base_url('benefits/dynamic_standard?period=') ?>" + $(this).val()
        })

        $('select.type_filter').on('change', function(){
            window.location.href = "<?= base_url('benefits/add_category?type='); ?>" + $(this).val();
        })
    })
</script>
</body>

</html>