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

        <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'benefits'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
          </a>&nbsp;Adjustment Benefits<h1>
      </div>
      <div class="col-md-6 button-title d-flex justify-content-end">
        <a href="<?= base_url() . 'benefits/adjustment_type' ?>" id="btn_new" class=" btn btn-primary shadow-none rounded"><img style="width: 17px; height: 17px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/gear-solid_xs.svg') ?>" alt="">&nbsp;Adjustment Type</a>
      </div>
    </div>

    <hr>
    <div class=" pt-1 pb-3 row d-flex justify-content-lg-start justify-content-center">
      <div class="col-12 col-lg-4 d-flex">
        <div class="col-6 col-lg-6">
          <p class="p-0 my-1 text-bold">Cut-off Period</p>
          <select class="form-control cut_off_period" id="filter_by_period">
            <?php foreach ($CUTOFF_PERIODS as $cut_off) { ?>
              <option value="<?= $cut_off->id ?>" <?= $PERIOD == $cut_off->id ? 'selected' : '' ?>><?= $cut_off->name ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-6 col-lg-6">
          <p class="p-0 my-1 text-bold">Type</p>
          <select class="form-control type_filter" id="filter_by_type">
            <?php foreach ($ADJUSTMENT_TYPE_LIST as $type) { ?>
              <option value="<?= $type->id ?>" <?= $TYPE == $type->id ? 'selected' : '' ?>><?= $type->name ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>


    <div class="card border-0 p-0 m-0">
      <div class="card border-0 py-1 m-0">
        <div class="p-2">
          <div class="row mx-1">
            <div class="col-12 col-lg-5 col-xl-6 d-flex justify-content-center justify-content-lg-start align-items-center">
              <button class="mr-1 btn btn-success" id="btn-add-row"><img style="width: 17px; height: 17px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/circle-plus-solid_xs.svg') ?>" alt="">
                &nbsp;Add Row</button>
              <button class="mr-1 btn btn-danger" id="btn-delete-row"><img style="width: 17px; height: 17px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/circle-minus-solid_xs.svg') ?>" alt="">
                Delete Row</button>
              <button class="mr-1  btn btn-primary" id="btn-update"><img style="width: 17px; height: 17px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="">
                &nbsp;Update</button>

                <!-- <button hidden class="btn btn-info" id="btn-converter"><img style="width: 17px; height: 17px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="">
                &nbsp;Change <?= ($DISP_ADJ_VALUE_TYPE == "currency") ? 'Currency to Hour' : "Hour to Currency" ?></button> -->
            </div>

            <div class="col-12 col-lg-7 col-xl-6 d-lg-flex d-none justify-content-lg-end align-items-center row">
              <div class="col-12 col-lg-5 d-flex justify-content-end my-2 my-lg-0 ">
                <div class="row d-flex align-items-center justify-content-center">
                  <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                </div>
              </div>

              <div class="d-lg-inline col-12 col-lg-5 d-flex justify-content-lg-end justify-content-center">
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

              <div class="col-12 col-lg-7 d-lg-none d-flex justify-content-lg-end">
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
<script type="text/javascript" src="<?php echo base_url() ?>/assets_system/js/handsontable14.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script>
  var url = '<?= base_url() ?>';
  var benefits_fixed = <?= json_encode($DISP_BENEFITS_ADJUSTMENT); ?>;
  var employeeList = <?= json_encode($DISP_EMPLOYEELIST); ?>;
  // let adjusment_val_type = <?= json_encode($DISP_ADJ_VALUE_TYPE); ?>;

  // let adj_text = "";
  // let adj_data = "";
  // if(adjusment_val_type == "currency"){
  //   adj_text = "[Currency] to [Hour]";
  //   adj_data = 'hour'
  // }else{
  //   adj_text = "[Hour] to [Currency]";
  //   adj_data = 'currency'
  // }

  var employee_cmid = {};
  employeeList.forEach(function(employee) {
    employee_cmid[employee.id] = employee.col_empl_cmid;
  });

  var combinedData = benefits_fixed.map(function(benefit) {
    var cmid = employee_cmid[benefit.user_id] || '';
    return {
      id: benefit.id,
      col_empl_cmid: cmid,
      value: benefit.value,
      // value_hour: benefit.value_hour,
    };
  });

  const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.style.whiteSpace = 'nowrap';
    td.style.overflow = 'hidden';
  };
  

  // let hiddenColumnIndex;
  //   if (adj_data === 'currency') {
  //     hiddenColumnIndex = 2; 
  // } else {
  //     hiddenColumnIndex = 3; 
  // }

  const container = document.querySelector('#table_data_new');
  hot = new Handsontable(container, {
    data: combinedData,
    colHeaders: ['ID', 'Employee ID', 'Value'],
    rowHeaders: true,
    height: 'auto',
    outsideClickDeselects: false,
    selectionMode: 'multiple',
    licenseKey: 'non-commercial-and-evaluation',
    renderer: customStyleRenderer_new,
    hiddenColumns: {
      columns: [0],
      indicators: true,
    },
    stretchH: 'all',
    columns: [{
        data: 'id',
        readOnly: true
      },
      {
        data: 'col_empl_cmid',
      },
      // {
      //   data: 'value',
      //   renderer: function(instance, td, row, col, prop, value, cellProperties) {
      //     Handsontable.renderers.TextRenderer.apply(this, arguments);
      //     td.style.textAlign = 'right';
      //   }
      // },
      {
          data: 'value',
          // renderer: function(instance, td, row, col, prop, value, cellProperties) {
          //     Handsontable.renderers.TextRenderer.apply(this, arguments);
          //     td.style.textAlign = 'right';
              
          //     if (value === null || value === undefined || value === '') {
          //         td.innerHTML = '<span style="float: left;">&#8369;</span>0.00';
          //     } else if (!isNaN(value)) {
          //         var numericValue = parseFloat(value);
          //         if (numericValue >= 0 && numericValue <= 1000000) {
          //             var formattedValue = numericValue.toFixed(2);
          //             td.innerHTML = '<span style="float: left;">&#8369;</span>' + formattedValue;
          //         } else {
          //             td.innerHTML = '<span style="color: red;">Invalid value</span>';
          //             if (!td.hasEventListener) {
          //                 window.alert('Invalid value. Please input a valid amount.');
          //                 td.hasEventListener = true;
          //                 td.addEventListener('click', function() {
          //                     instance.setDataAtCell(row, col, 0.00);
          //                 });
          //             }
          //         }
          //     } else {
          //         td.innerHTML = '<span style="color: red;">Invalid input</span>';
          //         if (!td.hasEventListener) {
          //             window.alert('Invalid input. Please input a valid number.');
          //             td.hasEventListener = true;
          //             td.addEventListener('click', function() {
          //                 instance.setDataAtCell(row, col, 0.00);
          //             });
          //         }
          //     }
          // }
      },
      // {
      //   data: 'value_hour',
      //   type: 'numeric',
      // }

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
        const dataToDelete = sortedRowsToDelete.map(rowIndex => {
          return {
            id: combinedData[rowIndex].id,
          };
        });


        fetch(url + 'benefits/delete_adjustment_data', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataToDelete)
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
    }

    fetch(url + 'benefits/udpate_adjustment_data', {
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


  // let btn_converter = document.getElementById('btn-converter');

  // btn_converter.addEventListener('click', function() {

  //   Swal.fire({
  //     title: `Confirm change ${adj_text}?`,
  //     // text: "Convert the value",
  //     icon: 'info',
  //     showCancelButton: true,
  //     confirmButtonColor: '#3085d6',
  //     cancelButtonColor: '#d33',
  //     confirmButtonText: 'Change it!'
  //   }).then((result) => {
  //     if(result.isConfirmed){
  //       fetch(url + 'benefits/convert_adjustment_data', {
  //         method: 'POST',
  //         headers: {
  //           'Content-Type': 'application/json'
  //         },
  //         body: JSON.stringify(adj_data)
  //       })
  //       .then(response => response.json())
  //       .then(response => {
  //       console.log('response = ',response);

  //       if (response.success_message) {
  //         $(document).Toasts('create', {
  //           class: 'bg-success toast_width',
  //           title: 'Success!',
  //           subtitle: 'close',
  //           body: response.success_message
  //         })

  //         setTimeout(function() {
  //           location.reload();
  //         }, 1500);
  //       }

  //       if (response.warning_message) {
  //         $(document).Toasts('create', {
  //           class: 'bg-warning toast_width',
  //           title: 'Warning!',
  //           subtitle: 'close',
  //           body: response.warning_message
  //         })
  //       }
  //     })
  //     }
  //   })
  // });


</script>
<script>
  $(document).ready(function() {
    var filter_period = $("#filter_by_period").val();
    var filter_type = $("#filter_by_type").val();

    $('select.cut_off_period').on('change', function() {
      window.location.href = "<?= base_url('benefits/adjustment?period=') ?>" + $(this).val() + "&type=" + filter_type;
    })
    $('select.type_filter').on('change', function() {
      window.location.href = "<?= base_url('benefits/adjustment?period=') ?>" + filter_period + "&type=" + $(this).val();
    })
  })
</script>
</body>

</html>