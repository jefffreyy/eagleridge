<html>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?php echo base_url() ?>/assets_system/css/handsontable14.css" />
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
        <h1 class="page-title"><a href="<?= base_url() . 'benefits/adjustment'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 5px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Adjustment Types<h1>
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
                    <span class="ml-2 badge badge-pill badge-secondary"><?= $ACTIVES ?></span>
                  </a>
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
                  <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><img style="height: 1rem; width: 1rem;" src="<?= base_url('assets_system/icons/broom-wide-sharp-solid.svg') ?>" alt="">&nbsp;Clear</button>
                <?php } else { ?>
                  <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><img src="<?= base_url('assets_system/icons/magnifying-glass-solid.svg') ?>" alt="">&nbsp;Search</button>
                <?php } ?>
                <input type="text" class="form-control" placeholder="Search..." value="<?= ($search_data) ? $search_data : "" ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
              </div>
            </div>
          </div>
        </div>

        <div class="p-2">
          <div class="row justify-content-between">
            <div class="col-12 col-lg-6 d-flex justify-content-center justify-content-lg-start align-items-center">
              <button class="mr-1 btn btn-success" id="btn-add-row"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-plus-solid_xs.svg') ?>" alt="" />&nbsp;Add Row</button>
              <button class="mr-1 btn btn-danger" id="btn-delete-row"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-minus-solid_xs.svg') ?>" alt="" /> Delete Row</button>
              <button class="btn btn-primary" id="btn-update"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
            </div>


            <div class="col-12 col-lg-5 d-lg-flex d-none justify-content-lg-end align-items-center">
              <div class="col-12 col-lg-4 d-flex justify-content-center my-2 my-lg-0 ">
                <div class="row d-flex align-items-center justify-content-center">
                  <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                </div>
              </div>
              <div class="d-lg-inline col-12 col-lg-4 d-flex justify-content-lg-end justify-content-center">
                <ul class="pagination ml-0 ml-lg-4 m-0 p-0">
                  <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
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
              </div>

              <div class="col-sm-3 col-md-2 col-lg-2  d-none d-lg-flex align-items-center justify-content-center  mr-lg-0 mr-2">
                <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                <select id="row_dropdown" class="custom-select" style="width: auto;">
                  <?php
                  foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>
                    <option value=<?= $C_ROW_DISPLAY_ROW ?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>
                  <?php
                  } ?>
                </select>
              </div>

            </div>


          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="py-2">
              <div id="table_data_new"> </div>

              <div class="col-12 col-lg-5 d-lg-none d-flex justify-content-lg-end align-items-center">
                <div class="col-12 col-lg-4 d-flex justify-content-center my-2 my-lg-0 ">
                  <div class="row d-flex align-items-center justify-content-center">
                    <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                    <div class="d-lg-inline col-12 col-lg-4 d-flex justify-content-lg-end justify-content-center">
                      <ul class="pagination ml-0 ml-lg-4 m-0 p-0">
                        <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
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
                    </div>
                  </div>

                </div>

              </div>
              <div class="col-sm-3 col-md-2 col-lg-2  d-flex d-lg-none align-items-center justify-content-center  mr-lg-0 mr-2">
                <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                <select id="row_dropdown" class="custom-select" style="width: auto;">
                  <?php
                  foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>
                    <option value=<?= $C_ROW_DISPLAY_ROW ?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>
                  <?php
                  } ?>
                </select>
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
          <p>Hi are you sure you want to logout?</p>
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
  <script type="text/javascript" src="<?php echo base_url() ?>/assets_system/js/handsontable14.js"></script>
  <script>
    var url = '<?= base_url() ?>';
    var fixedType = <?= json_encode($DISP_ADJUSTMENT_TYPE); ?>;

    console.log(fixedType);
    const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
      Handsontable.renderers.TextRenderer.apply(this, arguments);
      td.style.whiteSpace = 'nowrap';
      td.style.overflow = 'hidden';
    };

    const container = document.querySelector('#table_data_new');
    hot = new Handsontable(container, {
      data: fixedType,
      colHeaders: ['ID', 'Type', 'Currency/Hour'],
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
          data: 'currency_hour',
          type: 'dropdown',
          source: ['Currency', 'Hour'],
        }
      ]

    });

    hot.updateSettings({
      height: window.innerHeight - container.getBoundingClientRect().top - 50,
    });

    const addRowButton = document.getElementById('btn-add-row');
    addRowButton.addEventListener('click', function() {

      // const selected = hot.getSelected() || [];

      // if (selected.length === 0 && hot.countRows() === 0) {
      //   hot.alter('insert_row_below', 0);
      //   hot.updateSettings({
      //     columns: columns,
      //   });
      // } else if (selected.length === 0) {
      //   alert('Please select a row to add a new row below.');
      //   return;
      // } else {
      //   const selectedIndex = selected[0][0];
      //   hot.alter('insert_row_below', selectedIndex);
      // }

      const totalRows = hot.countRows();
      hot.alter('insert_row_below', totalRows);
      hot.updateSettings({
        columns: columns,
      });

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

    var udpate_date = document.getElementById('btn-update');
    udpate_date.addEventListener('click', function() {
      const confirmed = confirm('Are you sure you want to update the data?');
      if (!confirmed) {
        return;
      }

      const updatedData = hot.getData();
      fetch(url + 'benefits/update_adjustment_type', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(updatedData)
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
      $('select.cut_off_period').on('change', function() {
        window.location.href = "<?= base_url('benefits/dynamic_standard?period=') ?>" + $(this).val()
      })
    })
  </script>
  </body>

</html>