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
<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'benefits'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
          </a>&nbsp;Taxable Allowances<h1>
      </div>
      <div class="col-md-6 button-title">
      <a href="<?= base_url() . 'benefits/add_category' ?>" id="btn_new" class=" btn btn-primary shadow-none rounded"><img style="width: 17px; height: 17px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
          &nbsp;Categories</a>
          <a <?= ($NIGHTSHIFT_ALLOWANCE_TAX==0) ? 'hidden' : ""; ?> href="<?= base_url() . 'benefits/add_nightshift_category' ?>" id="btn_new" class=" btn btn-primary shadow-none rounded"><img style="width: 17px; height: 17px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
          &nbsp;Night Shift Categories</a>
        <a href="<?= base_url() . 'benefits/taxable_type' ?>" id="btn_new" class=" btn btn-primary shadow-none rounded"><img style="width: 17px; height: 17px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/gear-solid_xs.svg') ?>" alt="">
          &nbsp;Types</a>
      </div>
    </div>

    <hr>
    <div class=" p-3 d-flex">

      <!-- <div class="col-2">
        <p class="p-0 my-1 text-bold">Income Type</p>
        <input class="form-control" disabled value="" id="allowances" />

      </div> -->
      
      <div class="col-6 col-md-3 col-lg-3">
        <p class="p-0 my-1 text-bold">Type</p>
        <select class="form-control type_filter" id="filter_by_type">
          <?php foreach ($FIXED_TYPE_LIST as $type) { ?>
            <option value="<?= $type->id ?>" <?= $TYPE == $type->id ? 'selected' : '' ?>  data-onetime-attendance="<?= $type->onetime_attendance ?>" > <?= $type->name ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="col-2" hidden>
        <p class="p-0 my-1 text-bold">Frequency</p>
        <input class="form-control" disabled value="" id="frequency" />
      </div>

      <div class="col-2" hidden>
        <p class="p-0 my-1 text-bold">Cut-off Period</p>
        <select class="form-control cut_off_period" id="filter_by_period">
          <?php foreach ($CUTOFF_PERIODS as $cut_off) { ?>
            <option value="<?= $cut_off->id ?>" <?= $PERIOD == $cut_off->id ? 'selected' : '' ?>><?= $cut_off->name ?></option>
          <?php } ?>
        </select>
      </div>

      
      <div class="col-2" hidden>
        <p class="p-0 my-1 text-bold">Value</p>
        <input class="form-control" disabled value="" id="incentive_input" />
      </div>
      
      <div class="col-6 col-md-3 col-lg-3">
        <p class="p-0 my-1 text-bold text-nowrap">One-Time/By Attendance</p>
        <input class="form-control" disabled value="" id="onetime_attendance" />
      </div>
    </div>

    <div class=" px-3 pb-3 d-flex" id="default_value" style="display: none !important">
      <div class="col-2">
        <p class="p-0 my-1 text-bold">Default Value</p>
        <input class="form-control" disabled value="" id="default_value_input" />
      </div>
    </div>
    <div class="card border-0 p-0 m-0">
      <div class="card border-0 p- m-0">
        <!-- <?php if (!empty($FIXED_TYPE_LIST)) : ?> -->
          <div>
            <!-- <button class="btn btn-success" id="btn-add-row">
              <img style="width: 17px; height: 17px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/circle-plus-solid_xs.svg') ?>" alt="">
              &nbsp;Add Row
            </button>
            <button class="btn btn-danger" id="btn-delete-row">
              <img style="width: 17px; height: 17px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/circle-minus-solid_xs.svg') ?>" alt="">
              Delete Row
            </button> -->
            <button class="btn btn-primary" id="btn-update">
              <img style="width: 17px; height: 17px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="">
              &nbsp;Update
            </button>
          </div>
        <!-- <?php else : ?>
          <div class="table-active p-1">
            <div class="col md p-2">
              <center>No Selected Type</center>
            </div>
          </div>
        <?php endif; ?> -->
      </div>
      <br>

      <div class="row">
        <div class="col">
          <div class="py-0">
            <div  id="table_data_new"> </div>
     
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

<?php $this->load->view('templates/jquery_link'); ?>
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script type="text/javascript" src="<?php echo base_url()?>/assets_system/js/handsontable14.js"></script>
<script>
  var url                       = '<?= base_url() ?>';
  var benefits_fixed            = <?= json_encode($DISP_BENEFITS_FIXED); ?>;
  var employeeList              = <?= json_encode($DISP_EMPLOYEELIST); ?>;
  var dynamic_categories        = <?= json_encode($DISP_CATEGORIES); ?>;
  var tax_nontax_allowance      = <?= json_encode($tax_nontax_allowance); ?>;
  var transportation_allowance  = <?= json_encode($DISP_TRANSPORTATION_ALLOWANCE); ?>;
  var nightshift_allowance_tax  = <?= json_encode($NIGHTSHIFT_ALLOWANCE_TAX); ?>;

  var nightshift_categories_tax = <?= json_encode($DISP_NIGHTSHIFT_CATEGORIES); ?>;
  
  let dynamicCategories = dynamic_categories.map(function(item){
    return item.name;
  });

  let releaseDate = ['Every Cut-off'];
  for (let i = 1; i <= 31; i++) {
    releaseDate.push(i);
  }

  let nightshiftCategories = nightshift_categories_tax.map(function(item){
    return item.name;
  });

  var employee_cmid   = {};
  employeeList.forEach(function(employee) {
    employee_cmid[employee.id] = employee.col_empl_cmid;
  });

  let data = [{
    id: '',
    col_empl_cmid: '',
    category: '',
    start_date : '',
    end_date : '',
    transportation : '',
  }];

  // console.log(benefits_fixed);
  var combinedData = employeeList.map(function(employee) {

    var benefit_val = benefits_fixed.find(function (benefit) {
        return benefit.user_id === employee.id;
    });

    var transportation_allowance_val = transportation_allowance.find(function (trans) {
      return trans.user_id === employee.id;
    })
    
    return {
      id: employee.id,
      col_empl_cmid: employee.col_empl_cmid,
      fullname: employee.fullname,
      category: benefit_val ? benefit_val.category : '',
      start_date: benefit_val && benefit_val.start_date != null  && benefit_val.start_date != '0000-00-00' ? new Date(benefit_val.start_date).toLocaleDateString('en-GB').replace(/\//g, '/') : '',
      end_date: (benefit_val && benefit_val.end_date != null  && benefit_val.start_date != '0000-00-00') ? new Date(benefit_val.end_date).toLocaleDateString('en-GB').replace(/\//g, '/') : '',
      transportation: transportation_allowance_val ? transportation_allowance_val.nightshift_category : '',
    };
  });

  const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.style.whiteSpace = 'nowrap';
    td.style.overflow = 'hidden';
  };


  if (combinedData && Array.isArray(combinedData) && combinedData.length > 0) {
    data = combinedData;
  }

  const frequencyType = document.querySelector('#filter_by_type option[selected]').dataset.frequency;
  const onetimeType   = document.querySelector('#filter_by_type option[selected]').dataset.onetimeAttendance;
  const incentiveType = document.querySelector('#filter_by_type option[selected]').dataset.incentiveType;
  const taxable       = document.querySelector('#filter_by_type option[selected]').dataset.taxable;

  document.getElementById('frequency').value = frequencyType;
  document.getElementById('onetime_attendance').value = onetimeType;
  document.getElementById('incentive_input').value = incentiveType;

  const container = document.querySelector('#table_data_new');
  hot = new Handsontable(container, {
    data,
    colHeaders: ['ID', 'Employee ID', 'Employee Name', 'Category', 'Start', 'End','Night Shift Allowance', 'Release Date'],
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
    columns: [
      { data: 'id', readOnly: true },
      { data: 'col_empl_cmid', readOnly: true },
      { data: 'fullname', readOnly: true },
      { data: 'category',  type: 'dropdown', source: dynamicCategories },
      { data: 'start_date', type: 'date', dateFormat: 'DD/MM/YYYY', correctFormat: true },
      { data: 'end_date', type: 'date', dateFormat: 'DD/MM/YYYY', correctFormat: true },
      { data: 'transportation', type: 'dropdown', source: nightshiftCategories, width: 100},
      {
        data: 'release_date',
        type: 'dropdown',
        source: releaseDate,
      },
    ],
    
  });
  
    // Hide the start and end columns
  // if (tax_nontax_allowance === '1') {
  //   hot.updateSettings({
  //     hiddenColumns: {
  //       columns: [0, 4, 5],
  //       indicators: true,
  //     },
  //   });
  // }

  const hiddenColumns = {
    columns: [0], // Initialize an empty array
    indicators: true, // Optionally show visual indicators for hidden columns
  };

  if (tax_nontax_allowance && tax_nontax_allowance === '1') {
    hiddenColumns.columns.push(4, 5); // Hide columns 4 and 5
  }

  if (nightshift_allowance_tax && nightshift_allowance_tax === '0') {
    hiddenColumns.columns.push(6); // Hide column 6
  }

  hot.updateSettings({
    hiddenColumns,
  });



  // hot.updateSettings({
  //   height: container.offsetHeight + 100, 
  // });

  hot.updateSettings({
    height: window.innerHeight - container.getBoundingClientRect().top - 50,
  });

  

  // const addRowButton = document.getElementById('btn-add-row');
  // addRowButton.addEventListener('click', function() {
  //   // const lastRowIndex = hot.countRows() - 1;
  //   // hot.alter('insert_row_below', lastRowIndex);
  //   console.log('clicked row')
  //   const totalRows = hot.countRows();
  //   hot.alter('insert_row_below', totalRows);
  //   hot.updateSettings({
  //     columns: columns,
  //   });

  // });


  if (incentiveType == 'Attendance') {
    hot.updateSettings({
      hiddenColumns: {
        columns: [0, 2]
      },
    });
    const value1 = document.querySelector('#filter_by_type option[selected]').dataset.value;
    document.getElementById('default_value_input').value = value1;
    document.getElementById('default_value').style.display = 'block';
  }


  // const deleteRowButton = document.getElementById('btn-delete-row');
  // deleteRowButton.addEventListener('click', function() {
  //   const selectedRows = hot.getSelected() || [];
  //   if (selectedRows.length === 0) {
  //     alert('No rows selected. Please select rows to delete.');
  //     return;
  //   }
  //   if (selectedRows.length > 0) {
  //     const confirmed = confirm('Are you sure you want to delete the selected row?');
  //     if (confirmed) {
  //       const rowsToDelete = new Set();
  //       selectedRows.forEach(range => {
  //         const [row1, _column1, row2, _column2] = range;
  //         for (let rowIndex = Math.min(row1, row2); rowIndex <= Math.max(row1, row2); rowIndex++) {
  //           rowsToDelete.add(rowIndex);
  //         }
  //       });
  //       const sortedRowsToDelete = Array.from(rowsToDelete).sort((a, b) => b - a);
  //       const dataToDelete = sortedRowsToDelete.map(rowIndex => {
  //         return {
  //           id: combinedData[rowIndex].id,
  //         };
  //       });
  //       fetch(url + 'benefits/delete_fixed_data', {
  //           method: 'POST',
  //           headers: {
  //             'Content-Type': 'application/json'
  //           },
  //           body: JSON.stringify(dataToDelete)
  //         })
  //         .then(response => response.json())
  //         .then(result => {
  //           if (result.success_message) {
  //             $(document).Toasts('create', {
  //               class: 'bg-success toast_width',
  //               title: 'Success!',
  //               subtitle: 'close',
  //               body: result.success_message
  //             })
  //           } else {
  //             $(document).Toasts('create', {
  //               class: 'bg-warning toast_width',
  //               title: 'Error!',
  //               subtitle: 'close',
  //               body: 'Failed to delete!'
  //             })
  //           }
  //         })
  //         .catch(error => {
  //           console.error('Data deletion error:', error);
  //         });
  //       sortedRowsToDelete.forEach(rowIndex => {
  //         hot.alter('remove_row', rowIndex);
  //       });
  //       hot.deselectCell();
  //     }
  //   }
  // });


  // deleteRowButton.addEventListener('click', function() {
  //     const selectedRows = hot.getSelected() || [];

  //     if (selectedRows.length === 0) {
  //         alert('No rows selected. Please select rows to delete.');
  //         return;
  //     }

  //     if (selectedRows.length > 0) {
  //         const confirmed = confirm('Are you sure you want to delete the selected row?');
  //         if (confirmed) {

  //             const rowsToDelete = new Set();

  //             selectedRows.forEach(range => {
  //                 const [row1, _column1, row2, _column2] = range;
  //                 for (let rowIndex = Math.min(row1, row2); rowIndex <= Math.max(row1, row2); rowIndex++) {
  //                     rowsToDelete.add(rowIndex);
  //                 }
  //             });

  //             const sortedRowsToDelete = Array.from(rowsToDelete).sort((a, b) => b - a);

  //             sortedRowsToDelete.forEach(rowIndex => {
  //                 hot.alter('remove_row', rowIndex);
  //             });

  //             hot.deselectCell();

  //         }
  //     }
  // });

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
    
    fetch(url + 'benefits/update_fixed_data', {
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
    var filter_by_income_type = $("#filter_by_income_type").val();
    $('select.cut_off_period').on('change', function() {
      window.location.href = "<?= base_url('benefits/taxable?period=') ?>" + $(this).val() + "&type=" + filter_type + "&income_type=" + filter_by_income_type
    })
    $('select.type_filter').on('change', function() {
      window.location.href = "<?= base_url('benefits/taxable?period=') ?>" + filter_period + "&type=" + $(this).val() + "&income_type=" + filter_by_income_type;
    })
    $('select.income_type').on('change', function() {
      window.location.href = "<?= base_url('benefits/taxable?income_type=') ?>" + $(this).val();
    })
  })
</script>
</body>

</html>