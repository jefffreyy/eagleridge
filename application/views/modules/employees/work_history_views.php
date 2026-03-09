<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<?php
$search_data = $this->input->get('all');

$search_data = str_replace("_", " ", $search_data ?? '');

$PAGE = 1;
$C_DATA_COUNT = 0;
$PAGES_COUNT = 0;
$TAB = 'active';
$ACTIVES = 0;
$INACTIVES = 0;
$ROW = 25;

$current_page = $PAGE;
$next_page = $PAGE + 1;
$prev_page = $PAGE - 1;
$last_page = $PAGES_COUNT;
$row = $ROW;
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

<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <!-- <a href="<?= base_url() . 'payrolls'; ?>"><i class="fa-solid fa-square-left"></i> -->
        <h1 class="page-title"><a href="<?= base_url() ?>employees/personal?id=<?= $USER_ID ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
            </i></a>&nbsp;Work History<h1>
      </div>
    </div>

    <div class="card border-0 p-0 m-0">
      <div class="card border-0 p-1 m-0">

        <div class="p-2">
          <div class="d-flex">
            <button class="btn btn-success d-flex align-items-center" id="btn-add-row"><img src="<?= base_url('assets_system/icons/circle-plus-solid.svg') ?>" alt="" />
              &nbsp;Add Row</button>
            <button class="btn btn-danger d-flex align-items-center" id="btn-delete-row"><img src="<?= base_url('assets_system/icons/circle-minus-solid.svg') ?>" alt="" /> Delete Row</button>
            <button class="btn btn-primary d-flex align-items-center" id="btn-update"><img src="<?= base_url('assets_system/icons/circle-arrow-up-solid.svg') ?>" alt="" />&nbsp;Update Changes</button>

            <!-- <div class="float-right ">
              <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
              <ul class="d-inline pagination m-0 p-0 ">
                <li ><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
                    < </a>
                </li>
                <li><a href="?page=1&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row&tab=$TAB'"; ?>>> </a></li>
              </ul>
              <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
              <select id="row_dropdown" class="custom-select" style="width: auto;">
                  <?php
                  foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>
                          <option value=<?= $C_ROW_DISPLAY_ROW ?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>
                      <?php
                    } ?>
              </select>
            </div> -->

          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="p-2">
              <div id="table_data_new"> </div>
              <!-- <div id="table_data" > </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- ================================================================ new design End here ======================================================= -->


<?php $this->load->view('templates/jquery_link'); ?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>


<!-- SESSION MESSAGES -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-------------------- Export ----------------->
<script>
  var url = '<?= base_url() ?>';
  // var hot;
  const userId = <?= $USER_ID ?>;
  let data = [{
    id: '',
    company_name: '',
    company_address: '',
    date_start: '',
    date_end: '',
    position: '',
  }];
  var dataCopy = null;
  var deletedId = [];
  const apiUrl = url + 'employees/get_tableplus_data_work_history';
  fetch(apiUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(userId)
    })
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
    td.style.whiteSpace = 'nowrap';
    td.style.overflow = 'hidden';
  };

  function initializeHandsontable(data) {
    const container = document.querySelector('#table_data_new');
    hot = new Handsontable(container, {
      data,
      colHeaders: ['ID', 'Company Name', 'Company Address', 'Date Start', 'Date End', 'Position'],
      rowHeaders: true,
      height: 'auto',
      outsideClickDeselects: false,
      selectionMode: 'multiple',
      licenseKey: 'non-commercial-and-evaluation',
      // Custom renderer to prevent text wrapping
      renderer: customStyleRenderer_new,
      // readOnly: false,
      hiddenColumns: {
        columns: [0],
        // indicators: true,
      },
      stretchH: 'all',
      columns: [{
          data: 'id',
          readOnly: true
        },
        {
          data: 'company_name',
        },
        {
          data: 'company_address',
        },
        {
          data: 'date_start',
        },
        {
          data: 'date_end',
        },
        {
          data: 'position',
        },
      ],

    });
  }

  // add row
  // const addRowButton = document.getElementById('btn-add-row');
  //   addRowButton.addEventListener('click', function() {
  //       const selected = hot.getSelected() || [];

  //       if (selected.length === 0) {
  //           alert('Please select a row to add a new row below.');
  //           return;
  //       }
  //       // Get the index of the first selected row
  //       const selectedIndex = selected[0][0];

  //       hot.alter('insert_row_below', selectedIndex); 
  //       // hot.setDataAtCell(selectedIndex + 1, hot.countCols() - 1, 'Active');
  //   });

  const addRowButton = document.getElementById('btn-add-row');
  addRowButton.addEventListener('click', function() {
    const lastRowIndex = hot.countRows() - 1; // Get the index of the last row

    hot.alter('insert_row_below', lastRowIndex + 1); // Insert a new row below the last row
  });

  const deleteRowButton = document.getElementById('btn-delete-row');
  deleteRowButton.addEventListener('click', function() {
    const selectedRows = hot.getSelected() || [];

    // console.log(selectedRows);
    // console.log(selectedRows.length);

    if (selectedRows.length === 0) {
      alert('No rows selected. Please select rows to delete.');
      return;
    }

    if (selectedRows.length > 0) {
      const confirmed = confirm('Are you sure you want to delete the selected row?');
      if (confirmed) {

        // Create an array to hold unique row indices
        const rowsToDelete = new Set();

        // Iterate through each selected range and add row indices to the set
        selectedRows.forEach(range => {
          const [row1, _column1, row2, _column2] = range;
          for (let rowIndex = Math.min(row1, row2); rowIndex <= Math.max(row1, row2); rowIndex++) {
            rowsToDelete.add(rowIndex);
          }
        });

        // Convert the set to an array and sort it in descending order
        const sortedRowsToDelete = Array.from(rowsToDelete).sort((a, b) => b - a);

        // Delete rows in the sorted order
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
    // console.log('data', data);
    // console.log('dataCopy', dataCopy);
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
      // $(document).Toasts('create', {
      //     class: 'bg-warning toast_width',
      //     title: 'Warning!',
      //     subtitle: 'close',
      //     body: 'No Data to update'
      // })
      // return;
    }

    const apiUrl = url + 'employees/update_work_history';
    const data = {
      updatedData,
      userId,
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
              // location.reload();
            }
          })
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
        setTimeout(() => {
          // alert('test');
          // location.reload;
          window.location.href = window.location.href;
        }, 100)

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
      window.location.href = "<?= base_url('benefits/fixed?period=') ?>" + $(this).val() + "&type=" + filter_type;
    })
    $('select.type_filter').on('change', function() {
      window.location.href = "<?= base_url('benefits/fixed?period=') ?>" + filter_period + "&type=" + $(this).val();
    })
  })
</script>
</body>

</html>