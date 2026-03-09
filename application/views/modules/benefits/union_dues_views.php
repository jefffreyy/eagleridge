<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
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
<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'benefits'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
          </a>&nbsp;Union Dues<h1>
      </div>
      <div class="col-md-6 button-title">
        <a href="<?= base_url() . 'benefits/union_dues_type' ?>" id="btn_new" class=" btn btn-primary shadow-none rounded"><img style="width: 17px; height: 17px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/gear-solid_xs.svg') ?>" alt="">&nbsp;Union Dues Type</a>
      </div>
    </div>
    <hr>
    <div class=" p-3 row d-flex">

      <div class="col-4 col-xl-3 m-1">
        <p class="p-0 my-1 text-bold">Cut-off Period</p>
        <select class="form-control cut_off_period" id="filter_by_period">
          <?php foreach ($CUTOFF_PERIODS as $cut_off) { ?>
            <option value="<?= $cut_off->id ?>" <?= $PERIOD == $cut_off->id ? 'selected' : '' ?>><?= $cut_off->name ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-4 col-xl-3 m-1">
        <p class="p-0 my-1 text-bold">Type</p>
        <select class="form-control type_filter" id="filter_by_type">
          <?php foreach ($UNION_DUES_TYPE_LIST as $type) { ?>
            <option value="<?= $type->id ?>" <?= $TYPE == $type->id ? 'selected' : '' ?>  > <?= $type->name ?></option>
          <?php } ?>
        </select>
      </div>

    </div>
    <div class=" px-3 pb-3 d-flex" id="default_value" style="display: none !important">
      <div class="col-3 m-1">
        <p class="p-0 my-1 text-bold">Default Value</p>
        <input class="form-control" disabled value="" id="default_value_input" />
      </div>
    </div>
    <div class="card border-0 p-0 m-0">
      <div class="card border-0 p-1 m-0">
        <div class="p-2">
          <div>
            <button class="btn btn-success" id="btn-add-row"><img style="width: 17px; height: 17px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/circle-plus-solid_xs.svg') ?>" alt="">
              &nbsp;Add Row</button>
            <button class="btn btn-danger" id="btn-delete-row"><img style="width: 17px; height: 17px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/circle-minus-solid_xs.svg') ?>" alt="">
 Delete Row</button>
            <button class="btn btn-primary" id="btn-update"><img style="width: 17px; height: 17px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />
&nbsp;Update Changes</button>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="p-2">
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
        <p style="font-size: 400px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave? </p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;
          </span>
        </button>
      </div>
      <div class="modal-body">
        <p>Hi are you sure you want to logout? </p>
      </div>
      <div class="modal-footer pb-1 pt-1">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
        </button>
        <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout </a>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/jquery_link'); ?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  var url = '<?= base_url() ?>';
  var benefits_fixed = <?= json_encode($DISP_BENEFITS_FIXED); ?>;
  var employeeList = <?= json_encode($DISP_EMPLOYEELIST); ?>;
  var employee_cmid = {};
  employeeList.forEach(function(employee) {
    employee_cmid[employee.id] = employee.col_empl_cmid;
  });
  let data = [{
    id: '',
    col_empl_cmid: '',
    value: ''
  }];
  
  var combinedData = benefits_fixed.map(function(benefit) {
    var cmid = employee_cmid[benefit.user_id] || '';
    return {
      id: benefit.id,
      col_empl_cmid: cmid,
      value: benefit.value,
    };
  });
  const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.style.whiteSpace = 'nowrap';
    td.style.overflow = 'hidden';
  };
  // console.log('combinedData', combinedData);
  if (combinedData && Array.isArray(combinedData) && combinedData.length > 0) {
    data = combinedData;
  }

  const container = document.querySelector('#table_data_new');
  hot = new Handsontable(container, {
    data,
    colHeaders: ['ID', 'Employee ID', 'Value'],
    rowHeaders: true,
    height: 'auto',
    outsideClickDeselects: false,
    selectionMode: 'multiple',
    licenseKey: 'non-commercial-and-evaluation',
    renderer: customStyleRenderer_new,
    hiddenColumns: {
      columns: [0],
    },
    stretchH: 'all',
    columns: [{
        data: 'id',
        readOnly: true
      },
      {
        data: 'col_empl_cmid',
        type: 'dropdown',
        source: employeeList.map(employee => employee.col_empl_cmid),
        renderer: customStyleRenderer_new,
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
  // hot.updateSettings({
  //   height: container.offsetHeight + 100, 
  // });
  hot.updateSettings({
    height: window.innerHeight - container.getBoundingClientRect().top - 50,
  });

  const addRowButton = document.getElementById('btn-add-row');
  addRowButton.addEventListener('click', function() {

    const lastRowIndex = hot.countRows() - 1;
    if (hot.getData().length === 0) {
      hot.alter('insert_row_below', 0);
    } else {
      hot.alter('insert_row_below', lastRowIndex);
    }

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
        const dataToDelete = sortedRowsToDelete.map(rowIndex => {
          return {
            id: combinedData[rowIndex].id,
          };
        });
        fetch(url + 'benefits/delete_fixed_data', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataToDelete)
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
          });
        sortedRowsToDelete.forEach(rowIndex => {
          hot.alter('remove_row', rowIndex);
        });
        hot.deselectCell();
      }
    }
  });
  
  var periodValue = document.getElementById("filter_by_period").value;
  var typeValue = document.getElementById("filter_by_type").value;
  var update_date = document.getElementById('btn-update');
  var defaultValue = document.getElementById('default_value_input').value;
  update_date.addEventListener('click', function() {
    const confirmed = confirm('Are you sure you want to update the data?');
    if (!confirmed) {
      return;
    }
    const updatedData = hot.getData();
    const combinedUpdateData = {
      updatedData: updatedData,
      periodValue: periodValue,
      typeValue: typeValue,
      defaultValue
    }
    console.log('combinedUpdateData', combinedUpdateData)
    fetch(url + 'benefits/update_union_dues_data', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(combinedUpdateData)
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
        console.error('Data update error:', error);
      });
  });
  
</script>
<script>
  $(document).ready(function() {

    var filter_period = $("#filter_by_period").val();
    var filter_type = $("#filter_by_type").val();

    $('select.cut_off_period').on('change', function() {
      window.location.href = "<?= base_url('benefits/union_dues?period=') ?>" + $(this).val() + "&type=" + filter_type ;
    })
    $('select.type_filter').on('change', function() {
      window.location.href = "<?= base_url('benefits/union_dues?period=') ?>" + filter_period + "&type=" + $(this).val() ;
    })
    $('select.income_type').on('change', function() {
      window.location.href = "<?= base_url('benefits/union_dues?income_type=') ?>" + $(this).val();
    })

  })
</script>
</body>

</html>