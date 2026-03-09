<html>
<?php $this->load->view('templates/css_link'); ?>
<?php
$search_data  = $this->input->get('all');
$search_data  = str_replace("_", " ", $search_data ?? '');
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
<style>
  .hover {
    cursor: pointer;
  }
</style>

<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'benefits'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
          </a>&nbsp;Reimbursements<h1>
      </div>

      <div class="col-md-6 button-title d-flex justify-content-end">
        <a href="<?= base_url() . 'benefits/add_reimbursement' ?>" id="btn_new" class=" btn btn-primary shadow-none rounded"><img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
          &nbsp;Add Request</a>
      </div>
    </div>

    <hr>
    <div class="card border-0 p-0 m-0">
      <div class="card border-0" style="margin: 0px !important;">
        <div class="card-header p-0">

        </div>

        <div class="p-2">
          <div class="row align-items-center justify-content-between">
            <div class="col-12 col-lg-4  justify-content-center justify-content-lg-start align-items-center">
              <p class="mb-1 text-secondary ">Search Employee</p>
              <div class="d-flex">

                <select class="select-employee form-control" id="search_data" style="min-width:300px;width:max-content">
                  <option value=''>All</option>
                  <?php foreach ($EMPLOYEES as $employee) {
                  ?>
                    <option value="<?= $employee->id ?>" <?= $search_data == $employee->id ? 'selected' : '' ?>><?= $employee->name
                                                                                                                // $employee->col_empl_cmid."-".$this->system_functions->fomatName($employee->col_last_name,$employee->col_frst_name,$employee->col_midl_name)
                                                                                                                ?></option>
                  <?php } ?>
                </select>
                <a style="max-width: 150px" href=<?= base_url() . "benefits/reimbursement" ?> id="btn_clear_filter" class="col btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="" />&nbsp;Clear Filter</a>
              </div>

            </div>

            <!-- <div class="float-right "> -->
            <div class="col-12 col-lg-4 d-lg-flex d-none justify-content-lg-center align-items-center">
              <div class="col-12 col-lg-4 d-flex justify-content-center my-2 my-lg-0 ">
                <div class="row d-flex align-items-center justify-content-center">

                  <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>

                </div>

              </div>
              <div class="d-lg-inline col-12 col-lg-4 d-flex justify-content-lg-start justify-content-center">
                <ul class="pagination ml-0 ml-lg-4 m-0 p-0">
                  <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
                      < </a>
                  </li>
                  <li><a href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                  <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                  <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                  <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                  <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                  <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                  <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                  <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
                </ul>
              </div>

              <div class="col-sm-3 col-md-2 col-lg-2  d-none d-lg-flex align-items-center justify-content-center mr-lg-0 mr-2">
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

        <div class="table-responsive" style="max-height: 75vh">
          <table class="table table-bordered table-hover m-0" id="TableToExport">
            <thead style="position: sticky; top: 0;">
              <tr>
                <!-- <th class="text-center" style="min-width: 50px !important"><input type="checkbox" name="check_all" id="check_all"></th> -->
                <th class="text-left" style="min-width: 100px !important">ID</th>
                <th class="text-left" style="min-width: 300px !important">EMPLOYEE</th>
                <th class="text-left" style="min-width: 150px !important">TYPE</th>
                <th class="text-left" style="min-width: 100px !important">DESCRIPTION</th>
                <th class="text-left" style="min-width: 100px !important">AMOUNT</th>
                <th class="text-center" style="min-width: 100px !important">STATUS</th>
                <th class="text-center" style="min-width: 100px !important">ACTION</th>
              </tr>
            </thead>

            <tbody id="tbl_application_container">

              <?php if ($tableData) {
                foreach ($tableData as $tableDatarow) { ?>
                  <tr>
                    <td class="text-left"><?= 'RBT' . str_pad($tableDatarow->id, 5, '0', STR_PAD_LEFT); ?></td>
                    <td class="text-left"><?= $tableDatarow->employee ?></td>
                    <td class="text-left"><?= $tableDatarow->type ?></td>
                    <td class="text-left"><?= $tableDatarow->description ?></td>
                    <td class="text-right"><span style="float: left;">&#8369;</span> <?= number_format($tableDatarow->amount, 2) ?></td>
                    <td class="text-left">
                      <?php if ($tableDatarow->status == "Approved") { ?>
                        <span class='btn btn-sm btn-success disabled'><?= $tableDatarow->status ?></span>
                      <?php } elseif ($tableDatarow->status == "Rejected") { ?>
                        <span class='btn btn-sm btn-danger disabled'><?= $tableDatarow->status ?></span>
                      <?php } elseif ($tableDatarow->status == "Withdrawed") { ?>
                        <span class='btn btn-sm btn-secondary disabled'><?= $tableDatarow->status ?></span>
                      <?php } else { ?>
                        <span class='btn btn-sm btn-warning disabled'>Pending</span>
                      <?php } ?>
                    </td>
                    <td class="d-flex justify-content-center">
                      <!-- <a class="btn btn-sm btn_edit indigo lighten-2 ml-2" href="<?= base_url() . 'benefits/edit_reimbursement/' . $tableDatarow->id ?>"  >
                            <img src="<?= base_url('assets_system/icons/pen-to-square-solid.svg') ?>" alt="" id="edit">
                        </a> -->
                      <a class="btn btn-sm btn_edit indigo lighten-2 ml-2" href="<?= base_url() . 'benefits/approval_reimbursement/' . $tableDatarow->id ?>">
                        <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="" id="edit">
                      </a>
                      <!-- <button type="button"  data-id="<?= $tableDatarow->id ?>" class="btn_view" style="background-color: transparent; border: none;color: gray; cursor: pointer; !important" row_id="1">
                            <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="" id="view">
                        </button> -->
                      <!-- <a href="<?= base_url() . 'benefits/edit_reimbursement' ?>" id="btn_new" class=" btn btn-primary shadow-none rounded"><img class="mb-1" src="<?= base_url('assets_system/icons/pen-to-square-solid_light.svg') ?>" alt="">
                          &nbsp;Edit Reimbursement</a> -->
                    </td>
                  </tr>

                <?php  }
              } else { ?>

                <tr class="table-active">
                  <td colspan="12">
                    <center>No Records</center>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <div class="col-12 col-lg-4 d-lg-none d-flex justify-content-lg-center align-items-center">
          <div class="col-12 col-lg-4 d-flex justify-content-center my-2 my-lg-0 ">
            <div class="row d-flex align-items-center justify-content-center">

              <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>

              <div class="d-lg-inline col-12 col-lg-4 d-flex justify-content-lg-start justify-content-center">
                <ul class="pagination ml-0 ml-lg-4 m-0 p-0">
                  <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
                      < </a>
                  </li>
                  <li><a href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                  <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                  <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                  <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                  <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                  <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                  <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                  <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
                </ul>
              </div>
            </div>

          </div>

        </div>
        <div class="col-sm-3 col-md-2 col-lg-2  d-flex d-lg-none align-items-center justify-content-center mr-lg-0 mr-2 mb-2">
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
        <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade vertical-centered" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 34px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modalcontent" class="modal-body pt-2">
        <p style="font-weight:500" class="m-0">LOAN TYPE: <span id="loanType" class="font-weight-normal">SSS</span></p>
        <p style="font-weight:500" class="m-0">MONTHLY AMORTIZATION: <span id="monthlyAmortization" class="font-weight-normal">SSS</span></p>
        <p style="font-weight:500" class="m-0">INITIAL PAID TERMS: <span id="initialPaidTerms" class="font-weight-normal">3</span></p>
        <div class="table-responsive mt-1" style="max-weight: 400px">
          <table class="table table-hover table-bordered m-0" id="TableToExport">
            <thead style="position: sticky; top: 0;">
              <tr>
                <th class="text-left" style="min-width: 100px !important">PAYSLIP ID</th>
                <th class="text-left" style="min-width: 150px !important">PERIOD</th>
                <th class="text-left" style="min-width: 150px !important">AMOUNT PAID</th>
              </tr>
            </thead>
            <tbody id="tableBody">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const openModal = async (id, idLN, date, loanType, monthlyAmortization, initialPaidTerms) => {
    document.getElementById("modalTitle").innerHTML = `Loan Details (${idLN})`;
    document.getElementById("loanType").innerHTML = `${loanType}`;
    document.getElementById("monthlyAmortization").innerHTML = `${monthlyAmortization}`;
    document.getElementById("initialPaidTerms").innerHTML = `${initialPaidTerms}`;
    var tableBody = document.getElementById("tableBody");
    tableBody.innerHTML = '';
    var tr = document.createElement("tr");
    tr.innerHTML = `                  
        <tr>
          <td colspan="3">
            <div class="d-flex w-100 h-100 align-items-center justify-content-center">
              <div class="d-flex align-items-center">
                <div class="spinner-border text-primary" role="status" style="width:20px;height:20px">
                  <span class="sr-only">Loading...</span>
                </div>
                <span class="ml-1" style="font-weight: 600;font-size:18px">Fetching Data...</span>
              </div>
            </div>
          </td>
        </tr>          
        `
    tableBody.appendChild(tr);
    $('#modal').modal('show');
    console.log('id', id);
    var baseUrl = '<?= base_url() ?>';
    const apiUrl = baseUrl + 'selfservices/get_loan_payments_api';
    fetch(apiUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(id)
      })
      .then(response => response.json())
      .then(result => {
        console.log('result', result);
        const phpSymbol = '\u20B1';
        if (result.length > 0) {
          tableBody.innerHTML = '';
          let total = 0;
          result.forEach(obj => {
            total += parseFloat(obj.deducted);
            var tr = document.createElement("tr");
            tr.innerHTML = `                  
                      <td>${'PAY' + String(obj.payslip_id).padStart(5, '0')}</td>
                      <td>${obj.period}</td>
                      <td>${phpSymbol}${parseFloat(obj.deducted).toFixed(2)}</td>`
            tableBody.appendChild(tr);
          })
          var tr = document.createElement("tr");
          tr.innerHTML = `                 
                    <td colspan="3" class="text-center text-bold" style="font-size: 1em !important"><span>Total</span>: <span>${phpSymbol}${parseFloat(total).toFixed(2)}</span></td>`
          tableBody.appendChild(tr);
        } else {
          tableBody.innerHTML = '';
          var tr = document.createElement("tr");
          tr.innerHTML = `                  
        <tr>
          <td colspan="3">
            <div class="d-flex w-100 h-100 align-items-center justify-content-center">
              <div class="d-flex align-items-center">
                <span class="ml-1" style="font-weight: 600;font-size:18px">No Payments Found</span>
              </div>
            </div>
          </td>
        </tr>          
        `
          tableBody.appendChild(tr);
        }
        // document.getElementById("modalLoading").style.display = "none";

      })
      .catch(error => {
        tableBody.innerHTML = '';
        var tr = document.createElement("tr");
        tr.innerHTML = `                  
        <tr>
          <td colspan="3">
            <div class="d-flex w-100 h-100 align-items-center justify-content-center">
              <div class="d-flex align-items-center">
                <span class="ml-1" style="font-weight: 600;font-size:18px">Unexpected Error Occured</span>
              </div>
            </div>
          </td>
        </tr>          
        `
        tableBody.appendChild(tr);
        // $(document).Toasts('create', {
        //   class: 'bg-warning toast_width',
        //   title: 'Warning!',
        //   subtitle: 'close',
        //   body: 'Unexpected Error Occured Fetching Data..'
        // })
        console.error('Data update error:', error);
      });
  }
</script>

<?php $this->load->view('templates/jquery_link'); ?>



<?php if ($this->session->flashdata('SUCC')) { ?>
  <script>
    $(document).Toasts('create', {
      class: 'bg-success toast_width',
      title: 'Success!',
      subtitle: 'close',
      body: '<?php echo $this->session->flashdata('SUCC'); ?>'
    })
  </script>
<?php } ?>


<?php if ($this->session->flashdata('ERR')) { ?>
  <script>
    $(document).Toasts('create', {
      class: 'bg-warning toast_width',
      title: 'Warning!',
      subtitle: 'close',
      body: '<?php echo $this->session->flashdata('ERR'); ?>'
    })
  </script>
<?php } ?>

<!-- <script>
  document.addEventListener('DOMContentLoaded', function() {
    $('.deleteLoanBtn').on('click', function(e) {
      e.stopPropagation();
      var loanId = this.getAttribute('data-loan-id');

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
          fetch("<?php echo base_url('benefits/delete_loan'); ?>" + `/${loanId}`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
              },
            })
            .then(response => response.json())
            .then(data => {
              console.log(data);

              if (data.success_message) {
                // alert(data.success_message);
                window.location.reload();


              } else if (data.warning_message) {
                // alert(data.warning_message);
                $(document).Toasts('create', {
                  class: 'bg-warning toast_width',
                  title: 'Warning!',
                  subtitle: 'close',
                  body: data.warning_message
                })
              } else if (data.error_message) {
                // alert(data.error_message);
                $(document).Toasts('create', {
                  class: 'bg-warning toast_width',
                  title: 'Warning!',
                  subtitle: 'close',
                  body: data.warning_message
                })
              }
            })
            .catch(error => {
              alert('An error occurred while making the request.');
            });
        }
      });
    });
  });
</script> -->

<script>
  $(document).ready(function() {
    $('#row_dropdown').on('change', function() {
      let row = $(this).val();
      window.location = "<?= base_url() ?>payrolls/loans?" + "page=" + 1 + "&row=" + row;
    });

    $("#search_data").on("change", function() {
      search();
    });

    // $("#search_data").on("keypress", function(e) {
    //   if (e.which === 13) {
    //     search();
    //   }
    // });

    function search() {
      var optionValue = $('#search_data').val();
      var url = window.location.href.split("?")[0];
      if (window.location.href.indexOf("?") > 0) {
        window.location = url + "?page=1&row=<?= $row ?>&all=" + optionValue.replace(/\s/g, '_');
      } else {
        window.location = url + "?page=1&row=<?= $row ?>&all=" + optionValue.replace(/\s/g, '_');
      }
    }
    $('.select-employee').select2();
  })
</script>


</body>

</html>