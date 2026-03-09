<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<style>
  .htLeftAlign {
    text-align: left !important;
  }
</style>
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
        <h1 class="page-title"><a href="<?= base_url() . 'benefits'; ?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Dynamic Benefits<h1>
      </div>

      <div class="col-md-6 button-title">
        <a href="<?= base_url() . 'benefits/dynamic_standard' ?>" id="btn_new" class=" btn technos-button-green shadow-none rounded"><i class="fa-duotone fa-gear"></i>&nbsp;Setup</a>
      </div>
    </div>

    <div class="p-3 d-flex">
      <div class="col-3 m-1">
        <p class="p-0 my-1 text-bold">Cut-off Period</p>
        <select class="form-control cut_off_period" id="filter_by_period">
          <?php foreach ($CUTOFF_PERIODS as $cut_off) { ?>
            <option value="<?= $cut_off->id ?>" <?= $PERIOD == $cut_off->id ? 'selected' : '' ?>><?= $cut_off->name ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="col-3 m-1">
        <p class="p-0 my-1 text-bold">Type</p>
        <select class="form-control type_filter" id="filter_by_type">
          <?php foreach ($DYNAMIC_TYPE_LIST as $type) { ?>
            <option value="<?= $type->id ?>" <?= $TYPE == $type->id ? 'selected' : '' ?> data-incentive-type="<?= $type->incentive_type ?>" data-taxable="<?= $type->taxable ?>"><?= $type->name ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="col-3 m-1">
        <p class="p-0 my-1 text-bold">Incentive</p>
        <input class="form-control" disabled value="" id="incentive_input" />
      </div>

      <div class="col-3 m-1">
        <p class="p-0 my-1 text-bold">Taxable</p>
        <input class="form-control" disabled value="" id="taxable_input" />
      </div>
    </div>

    <div class="card border-0 p-0 m-0">
      <div class="card border-0 p-1 m-0">

        <div class="p-2">
          <div>
            <button class="btn btn-success" id="btn-add-row"><i class="fa-solid fa-circle-plus"></i>&nbsp;Add Row</button>
            <button class="btn btn-danger" id="btn-delete-row"><i class="fa-duotone fa-circle-minus"></i> Delete Row</button>
            <button class="btn btn-primary" id="btn-update"><i class="fa-solid fa-circle-arrow-up"></i>&nbsp;Update Changes</button>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  var benefits_dynamic  = <?= json_encode($DISP_BENEFITS_DYNAMIC); ?>;
  var employeeList      = <?= json_encode($DISP_EMPLOYEELIST_ASSIGN); ?>;
  var dynamic_std       = <?= json_encode($DISP_DYNAMIC_STD); ?>;
  var DYNAMIC_TYPE_LIST = <?= json_encode($DYNAMIC_TYPE_LIST); ?>;


  console.log('benefits_dynamic', benefits_dynamic)
  console.log('dynamic_std', dynamic_std)
  console.log('DYNAMIC_TYPE_LIST', DYNAMIC_TYPE_LIST)

  var employee_cmid = {};
  employeeList.forEach(function(employee) {
    employee_cmid[employee.id] = employee.col_empl_cmid;
  });

  var category_name = {};
  dynamic_std.forEach(function(category) {
    category_name[category.id] = category.name;
  });

  console.log('employee_cmid', employee_cmid)
  console.log('category_name', category_name)
  var combinedData = benefits_dynamic.map(function(dynamic) {
    var cmid = employee_cmid[dynamic.user_id] || '';
    var category = category_name[dynamic.category] || '';
    return {
      id: dynamic.user_id,
      col_empl_cmid: cmid,
      category: category,
      count: dynamic.count
    };
  });

  const incentiveType = document.querySelector('#filter_by_type option[selected]').dataset.incentiveType;
  const taxable       = document.querySelector('#filter_by_type option[selected]').dataset.taxable;
  document.getElementById('incentive_input').value = incentiveType;
  document.getElementById('taxable_input').value = taxable;
  let hiddenColumns = [0]
  if (incentiveType == 'Attendance') {
    hiddenColumns.push(3)
  }

  const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.style.whiteSpace = 'nowrap';
    td.style.overflow   = 'hidden';
  };
  var url = '<?= base_url() ?>';
  let data = [{
    id: '',
    col_empl_cmid: '',
    category: '',
    count: ''
  }];
  if (combinedData && Array.isArray(combinedData) && combinedData.length > 0) data = combinedData;
  console.log('data', data)
  const container = document.querySelector('#table_data_new');
  hot = new Handsontable(container, {
    data,
    colHeaders: ['ID', 'Employee ID', 'Category', 'Count', 'total'],
    rowHeaders: true,
    height: 'auto',
    outsideClickDeselects: false,
    selectionMode: 'multiple',
    licenseKey: 'non-commercial-and-evaluation',
    renderer: customStyleRenderer_new,
    hiddenColumns: {
      columns: hiddenColumns,
    },
    stretchH: 'all',
    columns: [{
        data: 'id',
        readOnly: true
      },
      {
        data: 'col_empl_cmid',
      },
      {
        data: 'category',
        type: 'dropdown',
        source: dynamic_std.map(function(item) {
          return item.name;
        }),
      },
      {
        data: 'count',
      },
    ],
  });

  const addRowButton   = document.getElementById('btn-add-row');
  addRowButton.addEventListener('click', function() {
    const lastRowIndex = hot.countRows() - 1;
    hot.alter('insert_row_below', lastRowIndex);
  });

  const deleteRowButton = document.getElementById('btn-delete-row');
  deleteRowButton.addEventListener('click', function() {
    // alert('test')
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
          const combinedUpdateData = {
            idsToDelete,
            periodValue: periodValue,
            typeValue: typeValue
          }
          console.log('combinedUpdateData',combinedUpdateData);
          fetch(url + 'benefits/delete_count_data', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify(combinedUpdateData)
            })
            .then(response => response.json())
            .then(result => {
              console.log(result);

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
        }

        hot.deselectCell();

      }
    }
  });

  var periodValue   = document.getElementById("filter_by_period").value;
  var typeValue     = document.getElementById("filter_by_type").value;
  var update_date   = document.getElementById('btn-update');
  update_date.addEventListener('click', function() {
    const confirmed = confirm('Are you sure you want to update the data?');
    if (!confirmed) {
      return;
    }

    const updatedData = hot.getData();

    const combinedUpdateData = {
      updatedData: updatedData,
      periodValue: periodValue,
      typeValue: typeValue
    }


    fetch(url + 'benefits/update_count_data', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(combinedUpdateData)
      })
      .then(response => response.json())
      .then(result => {
        console.log(result);

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
    var filter_type   = $("#filter_by_type").val();

    $('select.cut_off_period').on('change', function() {
      window.location.href = "<?= base_url('benefits/dynamic?period=') ?>" + $(this).val() + "&type=" + filter_type;
    })
    $('select.type_filter').on('change', function() {
      window.location.href = "<?= base_url('benefits/dynamic?period=') ?>" + filter_period + "&type=" + $(this).val();
    })
  })
</script>

</body>

</html>