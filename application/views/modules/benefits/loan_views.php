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
          </a>&nbsp;Loans<h1>
      </div>

      <div class="col-md-6 button-title d-flex justify-content-center justify-content-lg-end">
        <a href="<?= base_url() . 'benefits/add_loans' ?>" id="btn_new" class="mr-1 btn btn-primary shadow-none rounded"><img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
          &nbsp;Add New Loan</a>
        <a href="<?= base_url() . 'benefits/edit_loans?page='.$current_page.'&row='.$row.'&tab='.$TAB ?>" id="btn_new" class=" btn btn-primary shadow-none rounded"><img class="mb-1" src="<?= base_url('assets_system/icons/pen-to-square-solid_light.svg') ?>" alt="">
          &nbsp;Edit Loan</a>
      </div>
    </div>

    <hr>
    <div class="card border-0 p-0 m-0">
      <div class="card border-0" style="margin: 0px !important;">
        <div class="card-header p-0">
          <div class="row">
            <div class="col-xl-8 d-flex align-items-end">
              <ul class="nav nav-tabs align-items-center mt-2">
                <li class="nav-item ">
                  <a class="nav-link head-tab <?= $TAB == 'Active' ? 'active' : '' ?> " href="?page=1&row=<?= $row ?>&tab=Active" id="tab-Active" style='cursor:pointer'>
                    Active
                    <span class="ml-2 badge badge-pill badge-secondary"><?= $ACTIVES ?></span> </a>
                </li>

                <li class="nav-item">
                  <a href="?page=1&row=<?= $row ?>&tab=Inactive" class="nav-link head-tab <?= $TAB == 'Inactive' ? 'active' : '' ?>" id="tab-Inactive" style='cursor:pointer'>
                    Inactive
                    <span class="ml-2 badge badge-pill badge-secondary"><?= $INACTIVES ?></span>
                  </a>
                </li>
              </ul>
            </div>

            <div class="col-xl-4 d-none d-lg-inline">
              <div class="input-group pb-1">
                <!-- <div class="col-md-2">
                  <p class="mb-1 text-secondary ">Action</p>
                  
                </div> -->
                <div class=" my-1 col-12">
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

                    <a href=<?= base_url() . "benefits/loans" ?> id="btn_clear_filter" class="col btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="" />&nbsp;Clear Filter</a>
                  </div>

                </div>

                <!-- <?php
                      if ($search_data) { ?>
                  <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fa-regular fa-broom-wide" style="margin-top: 4px"></i>&nbsp;Clear</button>
                <?php } else { ?>
                  <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
                <?php } ?>
                <input type="text" class="form-control" placeholder="Search..." value="<?= ($search_data) ? $search_data : "" ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1"> -->
              </div>
            </div>
          </div>
        </div>

        <div class="p-2">
          <div class=" my-1 col-12 d-lg-none d-block ">
            <p class="mb-1 text-secondary ">Search Employee</p>
            <div class="d-flex">

              <select class="select-employee form-control w-100" id="search_data" style="min-width:300px;width:max-content">
                <option value=''>All</option>
                <?php foreach ($EMPLOYEES as $employee) {
                ?>
                  <option value="<?= $employee->id ?>" <?= $search_data == $employee->id ? 'selected' : '' ?>><?= $employee->name
                                                                                                              // $employee->col_empl_cmid."-".$this->system_functions->fomatName($employee->col_last_name,$employee->col_frst_name,$employee->col_midl_name)
                                                                                                              ?></option>
                <?php } ?>
              </select>

            </div>

            <a href=<?= base_url() . "benefits/loans" ?> id="btn_clear_filter" class="my-1 mx-auto d-lg-none col btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="" />&nbsp;Clear Filter</a>

          </div>
          <div class="row py-1 justify-content-between">
            <div class="col-12 col-lg-3 d-flex justify-content-lg-start justify-content-center">
              <button class="mr-1 btn technos-button-green shadow-none rounded bulk-button" data-toggle="modal" data-target="#modal_set_ssa" id="mark_as_active">
                <img style="height: 1rem; width: 1rem; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-check-solid_mark.svg') ?>" alt="">
                &nbsp;Mark as Active
              </button>
              <button class="btn btn-danger shadow-none rounded bulk-button" style="padding: 5px 12px 5px 12px" data-toggle="modal" data-target="#modal_set_ssa" id="mark_as_inactive">
                <img style="height: 1rem; width: 1rem; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-x-solid_mark_as.svg') ?>" alt="">
                &nbsp;Mark as Inactive
              </button>
            </div>


            <div class="col-12 col-lg-7 d-lg-flex d-none justify-content-lg-end">
              <div class="col-12 col-lg-4 d-flex justify-content-center my-2 my-lg-0 ">
                <div class="row d-flex align-items-center justify-content-center">
                  <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
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
              </div>

            </div>

            <div class="col-sm-3 col-md-2 col-lg-2  d-none d-lg-flex align-items-center justify-content-end  mr-lg-0 mr-2">
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

        <div class="table-responsive" style="max-height: 75vh">
          <table class="table table-bordered table-hover m-0" id="TableToExport">
            <thead style="position: sticky; top: 0;">
              <tr>
                <th class="text-center" style="min-width: 50px !important"><input type="checkbox" name="check_all" id="check_all"></th>
                <th class="text-left" style="min-width: 100px !important">ID</th>
                <th class="text-left" style="min-width: 150px !important">DATE</th>
                <th class="text-left" style="min-width: 300px !important">EMPLOYEE</th>
                <th class="text-left" style="min-width: 150px !important">TYPE</th>
                <th class="text-left" style="min-width: 100px !important">SEMI-MONTHLY AMORTIZATION</th>
                <th class="text-left" style="min-width: 100px !important">TERMS</th>
                <th class="text-left" style="min-width: 100px !important">BALANCE</th>
                <th class="text-center" style="min-width: 100px !important; display: none !important;">STATUS</th>
                <th class="text-center" style="min-width: 100px !important">ACTION</th>
              </tr>
            </thead>
            <tbody id="tbl_application_container">

              <?php if ($DISP_PAYROLL_LOAN) {
                foreach ($DISP_PAYROLL_LOAN as $DISP_PAYROLL_LOAN_ROW) { ?>
                  <tr class="hover" onclick="openModal(
                  '<?= $DISP_PAYROLL_LOAN_ROW['id'] ?>',
                  '<?= 'LN' . str_pad($DISP_PAYROLL_LOAN_ROW['id'], 5, '0', STR_PAD_LEFT); ?>',
                  '<?= date_format(date_create($DISP_PAYROLL_LOAN_ROW['date']), $DATE_FORMAT) ?>',
                  '<?= $DISP_PAYROLL_LOAN_ROW['loan_type'] ?>',
                  '<?= $DISP_PAYROLL_LOAN_ROW['loan_amount'] ?>',
                  '<?= $DISP_PAYROLL_LOAN_ROW['initial_paid'] ?>',
                  )">

                    <td class="text-center" id="select_item">
                      <input type="checkbox" name="approval_name" loan_id=<?= $DISP_PAYROLL_LOAN_ROW['id'] ?> class="check_single" approval_id="" row_id="" value="">
                    </td>
                    <td class="text-left"><?= 'LN' . str_pad($DISP_PAYROLL_LOAN_ROW['id'], 5, '0', STR_PAD_LEFT); ?></td>
                    <!-- <td class="text-left"><?= date($DATE_FORMAT, strtotime($DISP_PAYROLL_LOAN_ROW['date'])) ?></td> -->
                    <td class="text-left"><?= date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($DISP_PAYROLL_LOAN_ROW['date'])) ?></td>
                    <td class="text-left"><?= $DISP_PAYROLL_LOAN_ROW['name'] ?></td>
                    <td class="text-left"><?= $DISP_PAYROLL_LOAN_ROW['loan_type'] ?></td>
                    <td class="text-right"><span style="float: left;">&#8369;</span><?= $DISP_PAYROLL_LOAN_ROW['loan_amount'] ?></td>
                    <td class="text-left"><?= $DISP_PAYROLL_LOAN_ROW['loan_paid'] . '/' . $DISP_PAYROLL_LOAN_ROW['loan_terms'] ?></td>
                    <td class="text-right"><span style="float: left;">&#8369;</span><?= $DISP_PAYROLL_LOAN_ROW['loan_balance'] ?></td>
                    <td class="text-left" style="display: none !important;"><?= $DISP_PAYROLL_LOAN_ROW['loan_status'] ?></td>
                    <td style="width:15%" class="text-center">
                      <!-- <a class="select_row p-2" href="<?= base_url('benefits/edit_loan/' . $DISP_PAYROLL_LOAN_ROW['id']) ?>" style="color: gray; " row_id=""><i class="far fa-edit"></i></a> -->
                      <button class="deleteLoanBtn btn  select_row p-2" data-loan-id="<?= $DISP_PAYROLL_LOAN_ROW['id'] ?>" style="color: gray; "><img class="mb-1" src="<?= base_url('assets_system/icons/trash-solid.svg') ?>" alt="" /></button>
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
        <div class="col-12 col-lg-8 d-lg-none d-block justify-content-lg-end justify-content-center">
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
              <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&  tab=<?= $TAB ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
              <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
              <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
              <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row&tab=$TAB'"; ?>>> </a></li>
            </ul>
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

<form id='builk_activate' method='post' action="<?= base_url('benefits/bulk_activate') ?>">
  <input type='hidden' name='active' id='active_loans' />
  <input type='hidden' name='table' value='tbl_benefits_loan' />
</form>

<form id='builk_inactivate' method='post' action="<?= base_url('benefits/bulk_inactivate') ?>">
  <input type='hidden' name='inactive' id='inactive_loans' />
  <input type='hidden' name='table' value='tbl_benefits_loan' />
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
        <p style="font-weight:500" class="m-0">SEMI-MONTHLY AMORTIZATION: <span id="monthlyAmortization" class="font-weight-normal">SSS</span></p>
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

<!-- <script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

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
</script>
<script>
  $(document).ready(function() {
    $('#row_dropdown').on('change', function() {
      let row = $(this).val();
      window.location = "<?= base_url() ?>benefits/loans?" + "page=" + 1 + "&row=" + row + '&tab=<?= $TAB ?>';
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
    // $("#clear_search_btn").on("click", function() {
    //   var url = window.location.href.split("?")[0];
    //   window.location = url
    // });

    // $("#search_btn").on("click", function() {
    //   search();
    // });
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
        window.location = url + "?page=1&row=<?= $row ?>&tab=<?= $TAB ?>&all=" + optionValue.replace(/\s/g, '_');
      } else {
        window.location = url + "?page=1&row=<?= $row ?>&tab=<?= $TAB ?>&all=" + optionValue.replace(/\s/g, '_');
      }
    }
    $('.select-employee').select2();
  })
</script>


</body>

</html>