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
      <div class="col">
        <h1 class="page-title"><a href="<?= base_url() . 'employees/directories'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 5px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Quick Edit Employees</h1>
      </div>
    </div>

    <div class="card border-0 p-0 m-0">
      <div class="card border-0 p-1 m-0">
        <div class=" py-3 w-25">
          <p class="p-0 my-1 text-bold">Select Table</p>
          <select class="form-control" id="table-id" onchange="pageTable(this.value)">
            <option value="General">General</option>
            <option value="Education">Education</option>
            <option value="Skills">Skills</option>
            <option value="Work History">Work History</option>
            <option value="Documents">Documents</option>
            <option value="Dependents" selected>Dependents</option>
            <option value="Emergency Contacts">Emergency Contacts</option>
          </select>
        </div>

        <div class="p-2">
          <div>
            <button class="btn btn-success" id="btn-add-row"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;"  src="<?= base_url('assets_system/icons/circle-plus-solid_xs.svg') ?>" alt="" />&nbsp;Add Row</button>
            <button class="btn btn-danger" id="btn-delete-row"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-minus-solid_xs.svg') ?>" alt="" /> Delete Row</button>
            <button class="btn btn-primary" id="btn-update"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;"  src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update Changes</button>
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

<?php $this->load->view('templates/jquery_link'); ?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

  var url  = '<?= base_url() ?>';
  let data = [{
    id: '',
    col_empl_cmid: '',
    col_depe_name: '',
    col_depe_bday: '',
    col_depe_gndr: '',
    col_depe_rela: ''
  }];
  var dataCopy = null;
  var deletedId = [];
  const apiUrl = url + 'employees/get_tableplus_dependents_all';
  fetch(apiUrl
   
    )
    .then(response => response.json())
    .then(responseData => {
      console.log('responseData', responseData)
      if (Array.isArray(responseData) && responseData.length > 0) {
        data = responseData;
        dataCopy = JSON.parse(JSON.stringify(responseData));
      }
      initializeHandsontable(data)
    })
    .catch(error => {
      console.error('Data fetch error:', error);
    });

  const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.style.whiteSpace         = 'nowrap';
    td.style.overflow           = 'hidden';
  };

  function initializeHandsontable(data) {
    const container = document.querySelector('#table_data_new');
    hot = new Handsontable(container, {
      data,
      colHeaders: ['ID', 'Employee ID', 'Name', 'Birth Date', 'Gender', 'Relationship'],
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
        },
        {
          data: 'col_depe_name', 
        },
        {
          data: 'col_depe_bday', 
          type: 'date',
          dateFormat: 'DD/MM/YYYY',
        },
        {
          data: 'col_depe_gndr', 
          type: 'dropdown',
          source: ['Male', 'Female'],
        },
        {
          data: 'col_depe_rela', 
        },
      ],
    });
  }

  const addRowButton   = document.getElementById('btn-add-row');
  addRowButton.addEventListener('click', function() {
    const lastRowIndex = hot.countRows() - 1; 

    hot.alter('insert_row_below', lastRowIndex + 1); 
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

  var update_data = document.getElementById('btn-update');
  update_data.addEventListener('click', function() {
    const confirmed = confirm('Are you sure you want to update the data?');
    if (!confirmed) {
      return;
    }
    const updatedData = hot.getData();
    console.log('updatedData', updatedData);

    if (dataCopy && Array.isArray(dataCopy) && dataCopy.length > 0) {
      dataCopy.forEach((item) => {
        let found = false;
        updatedData.forEach(item2 => {
          if (item2[0] && item.id === item2[0]) {
            found = true
          }
        });
        if (!found) {
          deletedId.push(item.id);
        }
      });
    }

    const apiUrl = url + 'employees/update_dependents_all';
    const data   = {
      updatedData,
      deletedId
    };
    console.log('data', data);
    fetch(apiUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(result => {
        console.log('result', result);

        if (result.success_message) {
          $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success!',
            subtitle: 'close',
            body: result.success_message,
            onHidden: function() {
              alert('test toast callback');
            }
          })
          setTimeout(() => {

            window.location.href = window.location.href;
          }, 100)
        }
        if (result.error_message) {
          $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: result.error_message
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
  
  const pageTable = (value) => {
    if (value === 'General') window.location.href = `${url}employees/employee_update`;
    if (value === 'Education') window.location.href = `${url}employees/bulk_education`;
    if (value === 'Skills') window.location.href = `${url}employees/bulk_skills`;
    if (value === 'Work History') window.location.href = `${url}employees/bulk_work_history`;
    if (value === 'Documents') window.location.href = `${url}employees/bulk_documents`;
    if (value === 'Dependents') window.location.href = `${url}employees/bulk_dependents`;
    if (value === 'Emergency Contacts') window.location.href = `${url}employees/bulk_emergency_contacts`;
  }
</script>
</body>

</html>