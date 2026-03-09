<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="<?= base_url('assets_system/css/handsontable14.css') ?>" />


<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'attendances'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Converter<h1>
      </div>


      <div class="col-md-6 button-title">

        <button class="btn btn-primary" id="btn-update"> <img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Submit</button>


      </div>
    </div>

    <div class="card border-0 p-0 m-0">
      <div class="card border-0 pt-1 m-0">


        <div class="p-2">
          <div>
            <button class="btn btn-success" id="btn-add-row"><img style="height: 1rem; width: 1rem;" class="mb-1" src="<?= base_url('assets_system/icons/circle-plus-solid.svg') ?>" alt="">&nbsp;Add Row</button>
            <button class="btn btn-danger" id="btn-delete-row"><img style="height: 1rem; width: 1rem;" class="mb-1" src="<?= base_url('assets_system/icons/circle-minus-solid.svg') ?>" alt="">&nbsp;Delete Row</button>

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

<script type="text/javascript" src="<?= base_url('assets_system/js/handsontable14.js') ?>"></script>
<script>
  var url = '<?= base_url() ?>';

  const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.style.whiteSpace = 'nowrap';
    td.style.overflow = 'hidden';
  };

  const container = document.querySelector('#table_data');
  const hot = new Handsontable(container, {
    data: [{
      empl_id: "",
      date: "",
      time_in: "",
    }],
    colHeaders: ['Employee ID', 'Date', 'Time'],
    rowHeaders: true,
    height: 'auto',
    outsideClickDeselects: false,
    selectionMode: 'multiple',
    licenseKey: 'non-commercial-and-evaluation',
    renderer: customStyleRenderer_new,
    stretchH: 'all',
    minRows: 1,
    columns: [{}, // Employee ID
      {
        type: 'date',
        correctFormat: false
      }, // Date
      {} // Time
    ]
  });

  hot.updateSettings({
    height: window.innerHeight - container.getBoundingClientRect().top - 50,
  });

  const addRowButton = document.getElementById('btn-add-row');
  addRowButton.addEventListener('click', function() {
    const selected = hot.getSelected() || [];

    if (selected.length === 0 && hot.countRows() === 0) {
      hot.alter('insert_row_below', 0);
      hot.updateSettings({
        columns: columns,
      });
    } else if (selected.length === 0) {
      alert('Please select a row to add a new row below.');
      return;
    } else {
      const selectedIndex = selected[0][0];
      hot.alter('insert_row_below', selectedIndex);
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
        sortedRowsToDelete.forEach(rowIndex => {
          hot.alter('remove_row', rowIndex);
        });
        hot.deselectCell();
      }
    }
  });

  const udpate_date = document.getElementById('btn-update');
  udpate_date.addEventListener('click', function() {

    const confirmed = confirm('Are you sure you want to update the data?');
    if (!confirmed) {
      return;
    }

    let updatedData = hot.getData();

    // Filter out empty rows
    updatedData = updatedData.filter(row => row[0] !== "" && row[1] !== "");

    // Sort data by Employee ID and Date
    updatedData.sort((a, b) => {
      if (a[0] === b[0]) {
        return new Date(a[1]) - new Date(b[1]);
      }
      return a[0] > b[0] ? 1 : -1;
    });

    $.ajax({
      url: url + 'attendances/save_data',
      type: 'POST',
      data: {
        updatedData: JSON.stringify(updatedData)
      },
      success: function(response) {
        alert('Data saved successfully!');
      },
      error: function(xhr, status, error) {
        alert('An error occurred while saving the data.');
      }
    });

  });
</script>

</body>

</html>