<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<?php
$search_data  = $this->input->get('all');
$search_data  = str_replace("_", " ", $search_data ?? '');


?>
<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title"><a href="<?= base_url() . 'benefits/nontaxable'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 5px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Non-Taxable Types<h1>
      </div>
      <div class="col-md-6 button-title d-flex justify-content-end">
        <a href="<?= base_url() . 'benefits/add_nontaxable_type'; ?>" class=" btn btn-primary shadow-none rounded"><img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">&nbsp;Add Type</a>
        <!-- <a href="<?= base_url() . 'benefits/edit_taxable_type'; ?>" class=" btn btn-primary shadow-none rounded"><img class="mb-1" src="<?= base_url('assets_system/icons/edit.svg') ?>" alt="">&nbsp;Edit Type</a> -->
      </div>
    </div>
    <hr>
    <div class="card border-0 p-0 m-0">
      <div class="card border-0 py-1 m-0">

        <div class="p-2">

        </div>

        <div class="table-responsive">

            <table class="table table-bordered m-0" id="table_main" style="width:100%">
              <thead>

                <th class="text-center" style="width:5%" hidden><input type="checkbox" name="check_all" id="check_all">
                </th>
                <th style='width:10%;text-align: left;'>Type ID</th>
       
                <th style='width:10%;text-align: left;'>Name</th>
                <th style='width:10%;text-align: left;'>Type</th>
                <th style='width:2%;text-align: center;'>Action</th>

                <!-- <th style="width:10%" class="text-center">ACTION</th> -->
              </thead>
              <tbody id="tbl_application_container">
              <?php if ($DISP_NONTAXABLE_TYPE) {  ?>
                  <?php foreach ($DISP_NONTAXABLE_TYPE as $type) { ?>
                    <tr >
                      <td><?= $type->id ?></td>
                      <td><?= $type->name ?></td>
                      <td><?= $type->onetime_attendance ?></td>
                      <td style='width:2%;text-align: center;'> <a href="<?= base_url() . 'benefits/edit_nontaxable_type/'.$type->id; ?>"><img  src="<?= base_url('assets_system/icons/pen-to-square-solid.svg') ?>" alt=""></a> </td>
                    </tr>
                    <?php } ?>
                <?php } else { ?>
                  <tr class="table-active">
                    <td colspan="12">
                      <center>No Records</center>
                    </td>
                  </tr>
                  <?php } ?>
              </tbody>
            </table>
          </div>

        <!-- ========================== Handsontable start =========================== -->
        <div class="row" hidden>
          <div class="col">
            <div class="py-2">
              <div id="table_data_new"> </div>
            </div>
          </div>
        </div>
        <!-- ========================== Handsontable end =========================== -->


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


<?php
if ($this->session->userdata('SUCCESS')) {
?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success',
            subtitle: 'close',
            body: '<?php echo $this->session->userdata('SUCCESS'); ?>'
        })
    </script>
<?php
    $this->session->unset_userdata('SUCCESS');
}
?>



<script>
  var url = '<?= base_url() ?>';
  var fixedType = <?= json_encode($DISP_NONTAXABLE_TYPE); ?>;
  const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.style.whiteSpace = 'nowrap';
    td.style.overflow = 'hidden';
  };
  // console.log('fixedType', fixedType);
  const container = document.querySelector('#table_data_new');
  hot = new Handsontable(container, {
    data: fixedType,
    colHeaders: ['ID',
      // 'Earnings / Deductions', 
      'Benefit Name',
      // 'Taxable' , 
      'Type', 'Value'
    ],
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
      // {
      //   data: 'income_type',
      //   type: 'dropdown', 
      //   source: ['Earnings', 'Deductions'],
      // },
      {
        data: 'name'
      },
      // {
      //   data: 'taxable',
      //   type: 'dropdown',
      //   source: ['Taxable', 'Non-Taxable'],
      // },
      {
        data: 'incentive_type',
        type: 'dropdown',
        source: ['Manual', 'Attendance'],
      },
      {
        data: 'value',
        type: 'numeric',
      },


    ]
  });
  hot.updateSettings({
    height: window.innerHeight - container.getBoundingClientRect().top - 50,
  });

//   const addRowButton = document.getElementById('btn-add-row');
//   addRowButton.addEventListener('click', function() {

//     const totalRows = hot.countRows();
//     hot.alter('insert_row_below', totalRows);
//     hot.updateSettings({
//       columns: columns,
//     });
//   });


//   const deleteRowButton = document.getElementById('btn-delete-row');
//   deleteRowButton.addEventListener('click', function() {
//     const selectedRows = hot.getSelected() || [];
//     console.log('selectedRows', selectedRows);
//     if (selectedRows.length === 0) {
//       alert('No rows selected. Please select rows to delete.');
//       return;
//     }
//     if (selectedRows.length > 0) {
//       const confirmed = confirm('Are you sure you want to delete the selected row?');
//       if (confirmed) {
//         const rowsToDelete = new Set();
//         const idsToDelete = [];
//         selectedRows.forEach(range => {
//           const [row1, _column1, row2, _column2] = range;
//           for (let rowIndex = Math.min(row1, row2); rowIndex <= Math.max(row1, row2); rowIndex++) {
//             const id = hot.getDataAtCell(rowIndex, hot.propToCol('id'));
//             idsToDelete.push(id);
//             rowsToDelete.add(rowIndex);
//           }
//         });
//         console.log('rowsToDelete', rowsToDelete);
//         console.log('idsToDelete', idsToDelete);
//         if (idsToDelete.length > 0) {
//           console.log('idsToDelete > 0', idsToDelete);
//           fetch(url + 'benefits/delete_fixed_type', {
//               method: 'POST',
//               headers: {
//                 'Content-Type': 'application/json'
//               },
//               body: JSON.stringify(idsToDelete)
//             })
//             .then(response => response.json())
//             .then(result => {
//               if (result.success_message) {
//                 $(document).Toasts('create', {
//                   class: 'bg-success toast_width',
//                   title: 'Success!',
//                   subtitle: 'close',
//                   body: result.success_message
//                 });
//                 const sortedRowsToDelete = Array.from(rowsToDelete).sort((a, b) => b - a);
//                 sortedRowsToDelete.forEach(rowIndex => {
//                   hot.alter('remove_row', rowIndex);
//                 });
//               } else if (result.warning_message) {
//                 $(document).Toasts('create', {
//                   class: 'bg-warning toast_width',
//                   title: 'Error!',
//                   subtitle: 'close',
//                   body: result.warning_message
//                 })
//               } else {
//                 $(document).Toasts('create', {
//                   class: 'bg-warning toast_width',
//                   title: 'Error!',
//                   subtitle: 'close',
//                   body: 'Failed to delete!'
//                 })
//               }
//             })
//             .catch(error => {
//               console.error('Data deletion error:', error);
//               return;
//             });
//         }
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
//     console.log('updatedData', updatedData);
//     console.log('fixedType', fixedType);
//     fetch(url + 'benefits/update_fixed_type', {
//         method: 'POST',
//         headers: {
//           'Content-Type': 'application/json'
//         },
//         body: JSON.stringify(updatedData)
//       })
//       .then(response => response.json())
//       .then(result => {
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
//           body: 'Please provide all required information.'
//         })
//         console.error('Data update error:', error);
//       });
//   });
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