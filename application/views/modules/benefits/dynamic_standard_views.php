<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<style>
    .handsontable .wtHolder .wtHider{
        /* margin-bottom: 50px; */
        height: 74vh !important;
    }
</style>
<style>
  .htLeftAlign {
    text-align: left !important;
  }
</style>
<?php
$search_data = $this->input->get('all');

$search_data = str_replace("_", " ", $search_data ?? '');

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
        <h1 class="page-title"><a href="<?= base_url() . 'benefits/dynamic'; ?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Dynamic Benefits Setup<h1>
      </div>

      <div class="col-md-6 button-title">
        <a href="<?= base_url() . 'benefits/dynamic_type' ?>" id="btn_new" class=" btn technos-button-green shadow-none rounded"><i class="fa-duotone fa-gear"></i>&nbsp;Types</a>
      </div>
    </div>

    <div class=" py-3 w-25">
      <p class="p-0 my-1 text-bold">Type</p>
      <select class="form-control type_filter">
        <?php foreach ($DYNAMIC_TYPE_LIST as $type) { ?>
          <option value="<?= $type->id ?>" <?= $TYPE == $type->id ? 'selected' : '' ?>><?= $type->name ?></option>
        <?php } ?>
      </select>
    </div>

    <div class="card border-0 p-0 m-0">
      <div class="card border-0 p-1 m-0">
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
                    <span class="ml-2 badge badge-pill badge-secondary"><?= $INACTIVES ?></span> </a>
                </li>
              </ul>
            </div>

            <div class="col-xl-4">
              <div class="input-group pb-1">
                <?php
                if ($search_data) { ?>
                  <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fa-regular fa-broom-wide" style="margin-top: 4px"></i>&nbsp;Clear</button>
                <?php } else { ?>
                  <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
                <?php } ?>
                <input type="text" class="form-control" placeholder="Search..." value="<?= ($search_data) ? $search_data : "" ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
              </div>
            </div>
          </div>
        </div>

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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  var url  = '<?= base_url() ?>';
  let data = [{
    id: '',
    name: '',
    value: ''
  }];
  var swc_std = <?= json_encode($DISP_DYNAMIC_STD); ?>;
  console.log('swc_std', swc_std);
  if (swc_std && Array.isArray(swc_std) && swc_std.length > 0) data = swc_std;
  const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.style.whiteSpace = 'nowrap';
    td.style.overflow = 'hidden';
  };

  if (data.length < 10) {
    var rowsToAdd = 10 - data.length;
      for (var i = 0; i < rowsToAdd; i++) {
          data.push({id: '', name: '', value: ''});
      }
  }
  const columns = [{
      data: 'id'
    },
    {
      data: 'name'
    },
    {
      data: 'value',
      type: 'numeric',
      className: 'htLeftAlign'
    },
  ];

  const container = document.querySelector('#table_data_new');
  hot = new Handsontable(container, {
    data,
    colHeaders: ['ID', 'Title', 'Value'],
    rowHeaders: true,
    height: 'auto',
    outsideClickDeselects: false,
    selectionMode: 'multiple',
    licenseKey: 'non-commercial-and-evaluation',
    renderer: customStyleRenderer_new,
    stretchH: 'all',
    hiddenColumns: {
      columns: [0],
    },
    columns,
    columnDefs: [{
      targets: 2, 
      className: 'htLeftAlign',
    }, ],
  });

  const addRowButton = document.getElementById('btn-add-row');
  addRowButton.addEventListener('click', function() {
    const lastRowIndex = hot.countRows() - 1;
    hot.alter('insert_row_below', lastRowIndex);
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
        const idsToDelete  = [];

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
          fetch(url + 'benefits/delete_dynamic_std', {
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

  var udpate_date   = document.getElementById('btn-update');
  udpate_date.addEventListener('click', function() {
    const confirmed = confirm('Are you sure you want to update the data?');
    if (!confirmed) {
      return;
    }

    // const updatedData = hot.getData();
    console.log('data', data);

    let requiredEmptyList = [];
    let data2 = [];
    let send = true;
            // for (let i = 0; i < data.length; i++) {
    for (let i = data.length - 1; i >= 0; i--) {
        const requiredList = [{
                column: 'name',
                name: 'Name'
            },
            {
                column: 'value',
                name: 'Value'
            },
        ]
        const obj = data[i];
        for (const key in obj) {
            // console.log(`key{${i}}`, obj[key])
            requiredList.forEach((item) => {
                if ((obj[key] == null || obj[key] == '') && key == item.column) {
                    requiredEmptyList.push(item.name)
                }
            });

        }
        // console.log('requiredEmptyList', requiredEmptyList);
        if(requiredEmptyList.length < 1){
            data2.push(data[i]);
            // data.splice(i, 1);
        }else if (requiredEmptyList.length > 0 && requiredEmptyList.length < 2) {
            let rowWith = 'with';
            if(data[i].name){rowWith=`${rowWith} Name:${data[i].name}`;}
            if(data[i].incentive_type){rowWith=`${rowWith} Type:${data[i].incentive_type}`;}
            if(data[i].taxable){rowWith=`${rowWith} Taxable:${data[i].taxable}`;}
            $(document).Toasts('create', {
            class: 'bg-danger toast_width',
            title: 'Error!',
            subtitle: 'close',
            // body: `Cannot add with empty ${requiredEmptyList} on row ${rowWith}`
            body: `Cannot update with empty ${requiredEmptyList} on row ${i+1}`
            });
            // break;
            // console.log('data',data);
            // console.log('required')
            send = false;
        }

        requiredEmptyList = [];
    }
    if (data.length < 10) {
    var rowsToAdd = 10 - data.length;
        for (var i = 0; i < rowsToAdd; i++) {
          data.push({id: '', name: '', incentive_type: '', taxable: ''});
        }
    }
    hot.updateSettings({data});
    console.log('data', data);
    console.log('data2', data2);
    if (data2.length < 1) {
        $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: "No rows with Name, Type, and Taxable"
        });
        return;
    }
    if(!send)return;
    console.log('send', send);

    fetch(url + 'benefits/update_dynamic_std/' + <?= $TYPE ?>, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data2)
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
          console.log('before reload')
          location.reload();
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
    $('select.type_filter').on('change', function() {
      window.location.href = "<?= base_url('benefits/dynamic_standard?type=') ?>" + $(this).val()
    })
  })
</script>

</body>

</html>