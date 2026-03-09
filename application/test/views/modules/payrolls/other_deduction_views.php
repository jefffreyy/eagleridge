<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<?php
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

$search_data = $this->input->get('all');
$search_data = str_replace("_", " ", $search_data);
?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<div class="content-wrapper">
  <div class="container-fluid p-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= base_url() . 'payrolls'; ?>">Payroll</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Other Deductions
        </li>
      </ol>
    </nav>
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title">Other Deductions<h1>
      </div>

    </div>
    <hr>
    <div class="row">
                    <div class="col-md-3">
                        <label for="">Payroll Period</label>
                        <!-- <p>June 1, 2021 - June 15, 2021</p> -->
                        <select name="date_period" class="form-control" id="date_period" required>
                            <?php
                            $date = ((isset($_GET['date'])) && ($_GET['date'] != '')) ? $_GET['date'] : '';
                            $db_cutoff_id = '';
                            if ($DISP_PAYROLL_SCHED) {
                                $isCutoff_today = false;
                                foreach ($DISP_PAYROLL_SCHED as $DISP_PAYROLL_SCHED_ROW) {
                                    $current_date = date('Y-m-d');

                                    
                                    $start_date = $DISP_PAYROLL_SCHED_ROW->date_from;
                                    $end_date = $DISP_PAYROLL_SCHED_ROW->date_to;

                                    $db_payout = $DISP_PAYROLL_SCHED_ROW->payout;
                                    $payout = date('F d Y', strtotime($db_payout));
                                    if ($DISP_PAYROLL_SCHED_ROW->id == $date) {
                                        $selected = "selected";
                                    } else {
                                        $selected = '';
                                    }
                                    if (($current_date >= $start_date) && ($current_date <= $end_date)) {
                                        $schedule_id = $DISP_PAYROLL_SCHED_ROW->id;
                                        $db_cutoff_id = $schedule_id;
                                        $isCutoff_today = true;
                            ?>
                                        <option <?php echo $selected; ?>  value="<?= $schedule_id ?>" db_date="<?= $DISP_PAYROLL_SCHED_ROW->db_name ?>" payout="<?= $payout ?>"><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                            <?php
                                    } else {
                            ?>
                                        <option <?php echo $selected; ?> value="<?= $DISP_PAYROLL_SCHED_ROW->id ?>" db_date="<?= $DISP_PAYROLL_SCHED_ROW->db_name ?>" payout="<?= $payout ?>"><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                            <?php
                                    }
                                }
                                if ($isCutoff_today) {
                                    $db_cutoff_id = $DISP_PAYROLL_SCHED[0]->id;
                                }
                            }
                            ?>
                        </select>
                    </div>
    </div>
    <div class="pb-1">

    </div>
    <div class="card border-0 p-0 m-0">
      <div class="p-1">
        <div id="table_data" style="width:100%;"></div>
        <button onclick="updateButton()" id="btn_new" class="btn btn-primary shadow-none rounded"><i class="fas fa-plus"></i>&nbsp;Update Changes</button>
        <button class="btn btn-success" id="btn-add-row">New Row</button>
        <button class="btn btn-danger" id="btn-delete-row">Delete Row</button>
      </div>
    </div>

  </div>

</div>


<!-- <form id='builk_activate' method='post' action="<?= base_url('payrolls/bulk_activate') ?>">
    <input type='hidden' name='active' id='active_loans'/>
    <input type='hidden' name='table'  value='tbl_payroll_deductions'/>
</form>
<form id='builk_inactivate' method='post' action="<?= base_url('payrolls/bulk_inactivate') ?>">
    <input type='hidden' name='inactive' id='inactive_loans'/>
    <input type='hidden' name='table'  value='tbl_payroll_deductions'/>
</form> -->
<!-- ================================================================ new design End here ======================================================= -->

<!-- LOGOUT MODAL -->
<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?
        </p>
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

<!-- Pagination -->
<script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>
<!-- Datatables -->
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- SESSION MESSAGES -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_CSV')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_CSV'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_CSV');
}
?>
<?php
if ($this->session->userdata('SESS_ERR_MSG_INSRT_APPROVER')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_APPROVER'); ?>',
      '',
      'error'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_ERR_MSG_INSRT_APPROVER');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_APPROVER')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_APPROVER'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_APPROVER');
}
?>
<?php
if ($this->session->userdata('SESS_ERR_MSG_UPDT_APPROVER')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_ERR_MSG_UPDT_APPROVER'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_ERR_MSG_UPDT_APPROVER');
}
?>
<?php
if ($this->session->userdata('SESS_ERR_MSG_DLT_APPROVER')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_ERR_MSG_DLT_APPROVER'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_ERR_MSG_DLT_APPROVER');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_REJECT_LEAVE')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_REJECT_LEAVE'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_REJECT_LEAVE');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_APPROVE_LEAVE')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_APPROVE_LEAVE'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_APPROVE_LEAVE');
}
?>

<?php
if ($this->session->flashdata('SESS_SUCC_LOAN')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->flashdata('SESS_SUCC_LOAN'); ?>',
      '',
      'success'
    )
  </script>
<?php
}
?>

<?php
function convert_data($array, $id)
{
  $name = "";
  foreach ($array as $row) {
    if ($row->id == $id) {
      $name = $row->col_last_name . ' ' . $row->col_frst_name . ' ' . $row->col_midl_name;
    }
  }
  return $name;
}

function convert_img($array, $id)
{
  $img = "";
  foreach ($array as $row) {
    if ($row->id == $id) {
      $img = $row->col_imag_path;
    }
  }
  return $img;
}

function convert_cmid($array, $id)
{
  $cmid = "";
  foreach ($array as $row) {
    if ($row->id == $id) {
      $cmid = $row->col_empl_cmid;
    }
  }
  return $cmid;
}



?>
<script>
  document.querySelectorAll('button').addEventListener('click', updateButton);
  var payroll_id = $('#date_period').val();
  function updateButton() {
    // alert("Hello, world!");
    const confirmed = confirm('Are you sure you want to update the data?');
    if (!confirmed) {
      return;
    }

    const updatedData = hot.getData();

    // const hasEmptyRow = updatedData.some(row => row.some(cell => cell !== ''));
    // if (!hasEmptyRow) {
    //     alert('Cannot upload empty rows.');
    //     return;
    // }
    console.log(updatedData);


    fetch(url + 'payrolls/update_otherdeductions_data/' + payroll_id, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(updatedData)
      })
      .then(response => response.json())
      .then(result => {
        // console.log(result.success_message);
        // console.log(result.warning_message);
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
</script>

<script>
  var url = '<?= base_url() ?>';
  var payroll_id = $('#date_period').val();
  const apiUrl = url + 'payrolls/get_otherdeductions_data/' + payroll_id;

  var hot;

  fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
      initializeHandsontable(data);
    })
    .catch(error => {
      console.error('Data fetch error:', error);
    });

  function initializeHandsontable(data) {
    console.log(data);

    const container = document.querySelector('#table_data');
    hot = new Handsontable(container, {
      data: data,
      colHeaders: ['DED ID', 'Employee ID', 'Full Name', 'COOP', 'VACCINE', 'VAC', 'FUNERAL', 'CMCL', 'RCBC', 'CANTEEN'],
      rowHeaders: true,
      stretchH: 'all', // 'none' is default
      height: 'auto',
      rowHeights: 40,
      outsideClickDeselects: false,
      selectionMode: 'multiple',
      hiddenColumns: {
        columns: [0],
        indicators: true,
        // exclude hidden columns from copying and pasting
        copyPasteEnabled: false,
      },
      licenseKey: 'non-commercial-and-evaluation',
      // Custom renderer to prevent text wrapping
      renderer: function(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        td.style.whiteSpace = 'nowrap';
        td.style.overflow = 'hidden';
      },

    });

  // add row
  const addRowButton = document.getElementById('btn-add-row');
    addRowButton.addEventListener('click', function() {
        const selected = hot.getSelected() || [];

        if (selected.length === 0) {
            alert('Please select a row to add a new row below.');
            return;
        }
        // Get the index of the first selected row
        const selectedIndex = selected[0][0];

        hot.alter('insert_row_below', selectedIndex); 
    });

    // delete row
    const deleteRowButton = document.getElementById('btn-delete-row');
        deleteRowButton.addEventListener('click', function() {
            const selectedRows = hot.getSelected() || [];

            // console.log(selectedRows);
            // console.log(selectedRows.length);

            if (selectedRows.length === 0) {
                alert('No rows selected. Please select rows to delete.');
                return; 
            }

            if(selectedRows.length > 0 ){
                const confirmed = confirm('Are you sure you want to delete the selected row?');
                if(confirmed){

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


  }


  $(document).ready(function() {
    $('#row_dropdown').on('change', function() {
      let row = $(this).val();
      // alert(row);
      window.location = "<?= base_url() ?>payrolls/deductions?" + "page=" + 1 + "&row=" + row + '&tab=<?= $TAB ?>';
    });


    $('#mark_as_active').on('click', function() {
      let selected = false;
      let loan_id = [];
      Array.from($('.check_single')).forEach(function(element) {
        if ($(element).prop('checked')) {
          selected = true;
          loan_id.push($(element).attr('loan_id'))
        }

      })
      $('#active_loans').val(loan_id);
      if (!selected) {
        Swal.fire(
          'Warning!',
          'No item selected',
          'warning'
        )
      }
      if (selected) {
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Confirm!'
        }).then((result) => {
          if (result.isConfirmed) {
            $('#builk_activate').submit();
          }
        })
      }
    })
    $('#mark_as_inactive').on('click', function() {
      let selected = false;
      let loan_id = [];
      Array.from($('.check_single')).forEach(function(element) {
        if ($(element).prop('checked')) {
          selected = true;
          loan_id.push($(element).attr('loan_id'))
        }

      })
      $('#inactive_loans').val(loan_id);
      if (!selected) {
        Swal.fire(
          'Warning!',
          'No item selected',
          'warning'
        )
      }
      if (selected) {
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Confirm!'
        }).then((result) => {
          if (result.isConfirmed) {
            $('#builk_inactivate').submit();
          }
        })
      }
    })
    $('#approval').click(function() {
      let selected_id = [];
      let selected_att_id = [];
      $('#APPROVAL_ID').empty();
      $('#approval_list_id').empty();
      $('#select_item input[type=checkbox]:checked').each(function() {
        let selected_item = $(this).val();
        let att_approval_id = $(this).attr('approval_id');
        selected_id.push(selected_item);
        selected_att_id.push(att_approval_id);
      })

      if (selected_id.length > 0) {
        $('.class_modal_approval_list').prop('id', 'modal_assign_approver');
        let approval_ids = selected_id.join(',');
        $('#APPROVAL_ID').val(approval_ids);
        selected_att_id.forEach(function(data) {
          $('#approval_list_id').append(`<li class="col-md-6">Employee ID: <strong>${data}</strong></li>`);
        })
      } else {
        $('.class_modal_approval_list').prop('id', '');
        Swal.fire(
          'Please Select Employee!',
          '',
          'warning'
        )
      }

    })
    $("#date_period").on("change", function() {
      
                var optionValue = $(this).val();
                // window.history.replaceState(null, null, '?date='+optionValue+'');
                // console.log('?date='+optionValue+'');
                var url = window.location.href.split("?")[0];
                if (window.location.href.indexOf("?") > 0) {
                    window.location = url + "?date=" + optionValue;
                } else {
                    window.location = url + "?date=" + optionValue;
                }
            })
    $('#check_all').click(function() {
      if (this.checked == true) {
        Array.from($('.check_single')).forEach(function(element) {
          $(element).prop('checked', true);
          $('.check_single').parent().parent().css('background', '#e7f4e4');
        })
      } else {
        Array.from($('.check_single')).forEach(function(element) {
          $(element).prop('checked', false);
          $('.check_single').parent().parent().css('background', '');
        })
      }
    })
    $('.check_single').on('change', function() {
      if (this.checked == true) {
        $(this).parent().parent().css('background', '#e7f4e4');
      } else {
        $(this).parent().parent().css('background', '');
      }
    })

    // $("#search_btn").on("click", function() {
    //     $('#search_data').val();
    //     var optionValue = $('#search_data').val();
    //     var row         = $('#row_dropdown').val();
    //     var url = window.location.href.split("?")[0];
    //     if (window.location.href.indexOf("?") > 0) {
    //         window.location = url + "?page=1&row=<?= $row ?>&all=" + optionValue.replace(/\s/g, '_');
    //     } else {
    //         window.location = url + "?page=1&row=<?= $row ?>&all=" + optionValue.replace(/\s/g, '_');
    //     }
    // })

    $("#clear_search_btn").on("click", function() {
      var url = window.location.href.split("?")[0];
      window.location = url
    });

    $("#search_btn").on("click", function() {
      search();
    });

    $("#search_data").on("keypress", function(e) {
      if (e.which === 13) {
        search();
      }
    });

    function search() {
      let tab = '<?= $TAB ?>';
      var optionValue = $('#search_data').val();
      var url = window.location.href.split("?")[0];
      if (window.location.href.indexOf("?") > 0) {
        window.location = url + "?page=1&tab=" + tab + "&all=" + optionValue.replace(/\s/g, '_');
      } else {
        window.location = url + "?page=1&tab=" + tab + "&all=" + optionValue.replace(/\s/g, '_');
      }
    }


  })
</script>
<!-------------------- Export ----------------->

</body>

</html>