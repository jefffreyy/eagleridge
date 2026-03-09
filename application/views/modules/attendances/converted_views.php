<html>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?= base_url('assets_system/css/handsontable14.css') ?>" />
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
        <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'attendances/converter'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Converted<h1>
      </div>


      <div class="col-md-6 button-title">

      <!-- <button class="btn btn-primary" id="btn-update"> <img class="mb-1" style="height: 1.1rem; width: 1.1rem;"  src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Submit</button> -->


      </div>
    </div>

    <div class="card border-0 p-0 m-0">
      <div class="card border-0 pt-1 m-0">
       

        <div class="p-2">
          <div>
            <!-- <button class="btn btn-success" id="btn-add-row"><img style="height: 1rem; width: 1rem;" class="mb-1" src="<?= base_url('assets_system/icons/circle-plus-solid.svg') ?>" alt="">&nbsp;Add Row</button>
            <button class="btn btn-danger" id="btn-delete-row"><img style="height: 1rem; width: 1rem;" class="mb-1" src="<?= base_url('assets_system/icons/circle-minus-solid.svg') ?>" alt="">&nbsp;Delete Row</button>
           -->
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="">
              <div id="table_data"> </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>




<?php $this->load->view('templates/jquery_link'); ?>
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script type="text/javascript" src="<?= base_url('assets_system/js/handsontable14.js') ?>"></script> 
<script>
  var url = '<?= base_url() ?>';

  var CONVERTED = <?= json_encode($CONVERTED); ?>;
  
//   console.log('CONVERTED ', CONVERTED);
  const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.style.whiteSpace = 'nowrap';
    td.style.overflow = 'hidden';
  };

//   data: [{
//       empl_id: "",
//       date: "",
//       time_in: "",
//       time_out: "",
//       break_in: "",
//       break_out: "",
//     }],
  
  const container = document.querySelector('#table_data');
  hot = new Handsontable(container, {

    data: CONVERTED,
    colHeaders: ['Employee ID', 'Date', 'Time in', 'Time out'],
    rowHeaders: true,
    height: 'auto',
    outsideClickDeselects: false,
    selectionMode: 'multiple',
    licenseKey: 'non-commercial-and-evaluation',
    renderer: customStyleRenderer_new,
    stretchH: 'all',
    minRows: 1,
    columns: [
      {
        
      },
      {
        type: 'date',
        correctFormat: false
      },
      {},
      {},
    ]
  });

  hot.updateSettings({
    height: window.innerHeight - container.getBoundingClientRect().top - 50,
  });

//   const addRowButton = document.getElementById('btn-add-row');
//   addRowButton.addEventListener('click', function() {
//     const selected = hot.getSelected() || [];

//     if (selected.length === 0 && hot.countRows() === 0) {
//       hot.alter('insert_row_below', 0);
//       hot.updateSettings({
//         columns: columns,
//       });
//     } else if (selected.length === 0) {
//       alert('Please select a row to add a new row below.');
//       return;
//     } else {
//       const selectedIndex = selected[0][0];
//       hot.alter('insert_row_below', selectedIndex);
//     }

//   });

//   const deleteRowButton = document.getElementById('btn-delete-row');
//   deleteRowButton.addEventListener('click', function() {
//     const selectedRows = hot.getSelected() || [];

//     if (selectedRows.length === 0) {
//       alert('No rows selected. Please select rows to delete.');
//       return;
//     }
//     if (selectedRows.length > 0) {
//       const confirmed = confirm('Are you sure you want to delete the selected row?');
//       if (confirmed) {
//         const rowsToDelete = new Set();
//         selectedRows.forEach(range => {
//           const [row1, _column1, row2, _column2] = range;
//           for (let rowIndex = Math.min(row1, row2); rowIndex <= Math.max(row1, row2); rowIndex++) {
//             rowsToDelete.add(rowIndex);
//           }
//         });
//         const sortedRowsToDelete = Array.from(rowsToDelete).sort((a, b) => b - a);
//         sortedRowsToDelete.forEach(rowIndex => {
//           hot.alter('remove_row', rowIndex);
//         });
//         hot.deselectCell();
//       }
//     }
//   });

//   var udpate_date = document.getElementById('btn-update');
//   udpate_date.addEventListener('click', function() {

//     const confirmed = confirm('Are you sure you want to update the data?');
//     if (!confirmed) {
//       return;
//     }

//     const updatedData = hot.getData();

//     fetch(url + 'attendances/add_attendance_record', {
//         method: 'POST',
//         headers: {
//           'Content-Type': 'application/json'
//         },
//         body: JSON.stringify(updatedData)
//       })
//       .then(response => response.json())
//       .then(result => {
//         console.log(result);

//         if (result.success_message) {
//           $(document).Toasts('create', {
//             class: 'bg-success toast_width',
//             title: 'Success!',
//             subtitle: 'close',
//             body: result.success_message
//           })
//         }

//         if (result.warning_message) {
//           $(document).Toasts('create', {
//             class: 'bg-warning toast_width',
//             title: 'Warning!',
//             subtitle: 'close',
//             body: result.warning_message
//           })
//         }

//       })
//       .catch(error => {
//         $(document).Toasts('create', {
//           class: 'bg-warning toast_width',
//           title: 'Warning!',
//           subtitle: 'close',
//           body: 'Unexpected error occured, please contact support.'
//         })
//         console.error('Data update error:', error);
//       });
//   });

//   const employeeSelect = document.getElementById("employee_select");
//   const datePeriod = document.getElementById("date_period");
//   const endDatePeriod = document.getElementById("end_date_period");

//   employeeSelect.addEventListener("change", filterData);
//   datePeriod.addEventListener("change", filterData);
//   endDatePeriod.addEventListener("change", filterData);

//   function filterData() {
//     const selectedEmployee = employeeSelect.value;
//     const selectedDate = datePeriod.value;
//     const selectedEndDate = endDatePeriod.value;
//     const redirectUrl = `${url}attendances/edit_attendance_summary?employee=${selectedEmployee}&start_date=${selectedDate}&end_date=${selectedEndDate}`;

//     window.location.href = redirectUrl;
//   }
</script>

</body>

</html>