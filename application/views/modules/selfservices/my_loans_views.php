<html>
<?php $this->load->view('templates/css_link'); ?>
<?php
$search_data = $this->input->get('all');
$search_data = str_replace("_", " ", $search_data ?? '');
// $ROW=25;
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
<style>
  .hover {
    cursor: pointer;
  }
</style>
<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title d-flex align-items-center"><a onclick="afterRenderFunction()" href="<?= base_url() . 'selfservices'; ?>"> <img class="mb-1" style="width: 24px; height: 24px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
          </a>&nbsp;My Loans<h1>
      </div>

      <div class="col-md-6 button-title d-none">
        <a href="<?= base_url() . 'benefits/add_loans' ?>" id="btn_new" class=" btn technos-button-green shadow-none rounded d-flex align-items-center"><img src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
          &nbsp;Add New Loan</a>
        <a href="<?= base_url() . 'benefits/edit_loans' ?>" id="btn_new" class=" btn technos-button-green shadow-none rounded d-flex align-items-center"><img src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
          &nbsp;Edit Loan</a>
      </div>
    </div>

    <hr>
    <div class="card border-0 pt-1 m-0 mt-5 ">
      <div class="card border-0 pt-1 m-0">
        <div class="card-header p-0">
          <div class="row w-100">

            <div class="col-xl-4 ml-auto">
              <div class="input-group pb-1">
                <?php
                if ($search_data) { ?>
                  <button id="clear_search_btn" class="input-group-prepend btn btn-primary shadow-none d-flex align-items-center">
                    <img src="<?= base_url('assets_system/icons/broom-wide-sharp-solid.svg') ?>" alt="">
                    &nbsp;Clear
                  </button>
                <?php } else { ?>
                  <button id="search_btn" class="input-group-prepend btn btn-primary shadow-none d-flex align-items-center"><img src="<?= base_url('assets_system/icons/magnifying-glass-solid.svg') ?>" alt="">
                    &nbsp;Search</button>
                <?php } ?>
                <input type="text" class="form-control" placeholder="Search..." value="<?= ($search_data) ? $search_data : "" ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
              </div>
            </div>
          </div>
        </div>

        <div class="p-2 d-none d-lg-block">
          <div class="row align-items-center py-1">
            <div class="d-flex col-sm-9 col-md-10 col-lg-11 justify-content-lg-end justify-content-center my-lg-0 my-2">
              <div class="d-flex align-items-center  row">
                <div class="d-inline col-12 col-lg-6">
                  <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                </div>
                <div class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-end">
                  <ul class="pagination  ml-0 ml-lg-4 m-0 p-0 ">
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
            <div class=" col-sm-3 col-md-2 col-lg-1  d-flex align-items-center justify-content-center mr-lg-0 mr-">
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

        <div class="table-responsive" style="max-weight: 400px">
          <table class="table table-hover table-bordered m-0" id="TableToExport">
            <thead style="position: sticky; top: 0;">
              <tr>
                <th class="text-left" style="min-width: 100px !important">ID</th>
                <th class="text-left" style="min-width: 150px !important">DATE</th>
                <th class="text-left" style="min-width: 150px !important">TYPE</th>
                <th class="text-left" style="min-width: 100px !important">MONTHLY AMORTIZATION</th>
                <th class="text-left" style="min-width: 100px !important">TERMS</th>
                <th class="text-left" style="min-width: 100px !important">BALANCE</th>
                <th class="text-center" style="min-width: 100px !important">STATUS</th>

              </tr>
            </thead>

            <tbody id="tbl_application_container">

              <?php if ($DISP_PAYROLL_LOAN) {
                foreach ($DISP_PAYROLL_LOAN as $DISP_PAYROLL_LOAN_ROW) { ?>
                  <tr class="hover" onclick="openModal(
                  '<?= $DISP_PAYROLL_LOAN_ROW->id ?>',
                  '<?= 'LN' . str_pad($DISP_PAYROLL_LOAN_ROW->id, 5, '0', STR_PAD_LEFT); ?>',
                  '<?= date_format(date_create($DISP_PAYROLL_LOAN_ROW->loan_date), 'd/m/Y') ?>',
                  '<?= $DISP_PAYROLL_LOAN_ROW->loan_type ?>',
                  '<?= sprintf('%.2f', $DISP_PAYROLL_LOAN_ROW->loan_amount) ?>',
                  '<?= $DISP_PAYROLL_LOAN_ROW->initial_paid ?>',
                  )">
                    <td class="text-left"><?= 'LN' . str_pad($DISP_PAYROLL_LOAN_ROW->id, 5, '0', STR_PAD_LEFT); ?></td>
                    <td class="text-left"> <?= date(($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y", strtotime($DISP_PAYROLL_LOAN_ROW->loan_date)) ?></td>
                    <td class="text-left"><?= $DISP_PAYROLL_LOAN_ROW->loan_type ?></td>
                    <td class="text-right"><span style="float: left;">&#8369;</span><?= sprintf("%.2f", $DISP_PAYROLL_LOAN_ROW->loan_amount)  ?></td>
                    <td class="text-left"><?= $DISP_PAYROLL_LOAN_ROW->loan_paid_count . '/' . $DISP_PAYROLL_LOAN_ROW->loan_terms ?></td>
                    <td class="text-right"><span style="float: left;">&#8369;</span>
                      <?= sprintf("%.2f", ($DISP_PAYROLL_LOAN_ROW->loan_terms * $DISP_PAYROLL_LOAN_ROW->loan_amount) - ($DISP_PAYROLL_LOAN_ROW->loan_paid_count * $DISP_PAYROLL_LOAN_ROW->loan_amount)); ?>
                    </td>
                    <td class="text-center">
                      <?php if ($DISP_PAYROLL_LOAN_ROW->loan_paid_count == $DISP_PAYROLL_LOAN_ROW->loan_terms) {
                        echo ("Completed");
                      } else {
                        echo ("Not yet Complete");
                      } ?>
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
        <div class="p-2 d-block d-lg-none">
          <div class="row align-items-center py-1">
            <div class="d-flex col-sm-9 col-md-10 col-lg-11 justify-content-lg-end justify-content-center my-lg-0 my-2">
              <div class="d-flex align-items-center  row">
                <div class="d-inline col-12 col-lg-6">
                  <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                </div>
                <div class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-end">
                  <ul class="pagination  ml-0 ml-lg-4 m-0 p-0 ">
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
            <div class=" col-sm-3 col-md-2 col-lg-1  d-flex align-items-center justify-content-center mr-lg-0 mr-">
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

<div class="modal fade vertical-centered" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 34px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
      <div class="d-flex justify-content-end">
        <button type="button" class="close pr-3 pt-2" data-dismiss="modal" aria-label="Close" style="font-size: 34px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> -->
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
<?php $this->load->view('templates/jquery_link'); ?>
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
    // setTimeout(()=>{
    // tableBody.innerHTML = '';
    // const arrayOfObjects = [
    //   {id: 1, period: 'test 1', amount: 10},
    //   {id: 2, period: 'test 2', amount: 20},
    //   {id: 3, period: 'test 3', amount: 30},
    // ]
    //   arrayOfObjects.forEach(obj=>{
    //     var tr = document.createElement("tr");
    //     tr.innerHTML = `                  
    //               <td>${obj.id}</td>
    //               <td>${obj.period}</td>
    //               <td>${obj.amount}</td>`
    //       tableBody.appendChild(tr);
    //   })
    // }, 2000);
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

  // const copyFunction = async (employeeId) => {
  //   document.getElementById("modalLoading").style.display = "block";
  //   $('#modalDirects').modal('show');
  //   const apiUrl = baseUrl + 'selfservices/get_reporting_to_directives';
  //   const data = {
  //     employeeId
  //   };
  //   console.log('data', data);
  //   fetch(apiUrl, {
  //       method: 'POST',
  //       headers: {
  //         'Content-Type': 'application/json'
  //       },
  //       body: JSON.stringify(data)
  //     })
  //     .then(response => response.json())
  //     .then(result => {
  //       console.log('result', result)
  //       document.getElementById("modalLoading").style.display = "none";
  //       let employeeImage = `${baseUrl}/assets_user/user_profile/${result.data.employeeInfo?.col_imag_path}`;
  //       if (!result.data.employeeInfo?.col_imag_path) employeeImage = `${baseUrl}/assets_system/images/default_user.jpg`;
  //       document.getElementById('employee_img').src = employeeImage;

  //       let employeeLastNameSuffix = result.data.employeeInfo?.col_last_name;
  //       if (result.data.employeeInfo?.col_suffix) employeeLastNameSuffix = `${result.data.employeeInfo?.col_last_name} ${result.data.employeeInfo?.col_suffix}`;
  //       let employeeFullName = employeeLastNameSuffix;
  //       if (result.data.employeeInfo?.col_frst_name) employeeFullName = `${employeeFullName}, ${result.data.employeeInfo?.col_frst_name}`;
  //       if (result.data.employeeInfo?.col_midl_name) employeeFullName = `${employeeFullName} ${result.data.employeeInfo?.col_midl_name.charAt(0)}.`;
  //       if (employeeFullName) {
  //         document.getElementById("employeeFullName").textContent = employeeFullName;
  //       } else {
  //         document.getElementById("employeeFullName").textContent = '(No Full Name)'
  //       }

  //       if (result.data.employeeInfo?.col_empl_cmid) {
  //         document.getElementById("employeeNumber").textContent = `${result.data.employeeInfo.col_empl_cmid}`;
  //       } else {
  //         document.getElementById("employeeNumber").textContent = '(No Employee Number)'
  //       }
  //       if (result.data.employeeInfo?.col_empl_posi) {
  //         document.getElementById("employeePosition").textContent = `${result.data.employeeInfo.col_empl_posi}`;
  //       } else {
  //         document.getElementById("employeePosition").textContent = '(No Position)'
  //       }
  //       if (result.data.employeeInfo?.col_empl_company) {
  //         document.getElementById("employeeCompany").textContent = `${result.data.employeeInfo.col_empl_company}`;
  //       } else {
  //         document.getElementById("employeeCompany").textContent = '(No Company)'
  //       }
  //       if (companyHide) document.getElementById("employeeCompany").style.display = 'none';
  //       branch = result.data.employeeInfo?.col_empl_branch;
  //       inBetween = ` \\ `;
  //       department = result.data.employeeInfo?.col_empl_dept;
  //       if (!branch || branchHide) branch = '';
  //       if (!department || departmentHide) department = '';
  //       if (branchHide || departmentHide || !branch || !department) inBetween = '';
  //       if (branch || department) {
  //         document.getElementById("employeeBranchDepartment").textContent = `${branch}${inBetween}${department}`;
  //       } else {
  //         if (branchHide && !departmentHide) {
  //           document.getElementById("employeeBranchDepartment").textContent = '(No Department)';
  //         } else if (departmentHide && !branchHide) {
  //           document.getElementById("employeeBranchDepartment").textContent = '(No Branch)';
  //         } else if (!branchHide && !departmentHide) {
  //           document.getElementById("employeeBranchDepartment").textContent = '(No Branch / No Department)';
  //         } else {
  //           document.getElementById("employeeBranchDepartment").textContent = ''
  //         }
  //       }
  //       if (result.data.employeeInfo?.col_comp_emai) {
  //         document.getElementById("employeeEmail").textContent = `${result.data.employeeInfo.col_comp_emai}`;
  //       } else {
  //         document.getElementById("employeeEmail").textContent = '(No Email)'
  //       }

  //       let reportingToLastNameSuffix = result.data.reportingTo?.col_last_name;
  //       if (result.data.reportingTo?.col_suffix) reportingToLastNameSuffix = `${reportingToLastNameSuffix} ${result.data.reportingTo?.col_suffix}`;
  //       let reportingToFullName = reportingToLastNameSuffix;
  //       if (result.data.reportingTo?.col_frst_name) reportingToFullName = `${reportingToFullName}, ${result.data.reportingTo?.col_frst_name}`;
  //       if (result.data.reportingTo?.col_midl_name) reportingToFullName = `${reportingToFullName} ${result.data.reportingTo?.col_midl_name?.charAt(0)}.`;

  //       let reportingToImage = "<?= base_url() ?>/assets_system/images/default_user.jpg";
  //       if (result.data.reportingTo?.col_imag_path)
  //         reportingToImage = `${baseUrl}/assets_user/user_profile/${result.data.reportingTo.col_imag_path}`;

  //       if (reportingToFullName) {
  //         document.getElementById("reportingToContainer").textContent = "";
  //         document.getElementById("reportingToContainer").innerHTML =
  //           `<img class="img-circle2 rounded-circle avatar elevation-2" 
  //             style="cursor: pointer;width:50px !important;height:50px !important" data-toggle="tooltip" 
  //             data-placement="right" title="Reporting To" 
  //             src="${reportingToImage}">
  //           <div class="mx-2">
  //             <p class="p-0 m-0" style="line-height: 1;font: size 13px;font-weight:500;">${reportingToFullName}</p>
  //           </div>`;
  //       } else {
  //         document.getElementById("reportingToContainer").innerHTML = '(No Reporting To)'
  //       }
  //       var directsParent = document.getElementById("directsParent");

  //       console.log('directs condition', Array.isArray(result.data.directsTo) && result.data.directsTo.length > 0)
  //       if (Array.isArray(result.data.directsTo) && result.data.directsTo.length > 0) {
  //         directsParent.innerHTML = '';
  //         result.data.directsTo.forEach(function(user) {

  //           directLastNameSuffix = user.col_last_name;
  //           if (user.col_suffix) directLastNameSuffix = `${directLastNameSuffix} ${user.col_suffix}`;
  //           let directFullName = directLastNameSuffix;
  //           if (user.col_frst_name) directFullName = `${directFullName}, ${user.col_frst_name}`;
  //           if (user.col_midl_name) directFullName = `${directFullName} ${user.col_midl_name.charAt(0)}.`;

  //           let directImage = `${baseUrl}/assets_system/images/default_user.jpg`;
  //           if (result.data.directsTo[0].col_imag_path) {
  //             directImage = `${baseUrl}/assets_user/user_profile/${user.col_imag_path}`;
  //           }
  //           var div = document.createElement("div");
  //           div.className = "d-flex align-items-center";
  //           div.innerHTML = `
  //             <div  class="d-flex align-items-center mb-2">
  //               <img class="img-circle2 rounded-circle avatar elevation-2" 
  //                 id="directsToPhoto" style="cursor: pointer;width:50px !important;height:50px !important" 
  //                 data-toggle="tooltip" data-placement="right" title="Reporting To" 
  //                 src="${directImage}">
  //               <div class="mx-2">
  //                 <p id="direcstToName" class="p-0 m-0" style="line-height: 1;font: size 13px;">${directFullName}</p>
  //               </div>
  //             </div>
  //             `;
  //           directsParent.appendChild(div);
  //         });
  //       } else {
  //         directsParent.innerHTML = '(No Directs)';
  //       }
  //       if (result.errorMessage) {
  //         $(document).Toasts('create', {
  //           class: 'bg-warning toast_width',
  //           title: 'Warning!',
  //           subtitle: 'close',
  //           body: 'Unexpected Error Occured Fetching Data'
  //         })
  //       }
  //     })
  //     .catch(error => {
  //       document.getElementById("modalLoading").style.display = "none";
  //       $(document).Toasts('create', {
  //         class: 'bg-warning toast_width',
  //         title: 'Warning!',
  //         subtitle: 'close',
  //         body: 'Unexpected Error Occured Fetching Data..'
  //       })
  //       console.error('Data update error:', error);
  //     });

  //   // document.getElementById('employee_img').src = `${baseUrl}/assets_system/images/default_user.jpg`;
  //   // assets_user/user_profile/' . $user_image;
  // }
</script>

<script>
  $(document).ready(function() {
    $('#row_dropdown').on('change', function() {
      let row = $(this).val();
      window.location = "<?= base_url() ?>selfservices/my_loans?" + "page=" + 1 + "&row=" + row + '&tab=<?= $TAB ?>';
    });

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
      var optionValue = $('#search_data').val();
      var url = window.location.href.split("?")[0];
      if (window.location.href.indexOf("?") > 0) {
        window.location = url + "?page=1&row=<?= $row ?>&tab=<?= $TAB ?>&all=" + optionValue.replace(/\s/g, '_');
      } else {
        window.location = url + "?page=1&row=<?= $row ?>&tab=<?= $TAB ?>&all=" + optionValue.replace(/\s/g, '_');
      }
    }
  })
</script>

</body>

</html>