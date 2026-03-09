<html>
<?php $this->load->view('templates/css_link');
$period_param = $this->input->get('period');
?>
<link rel="stylesheet" href="<?php echo base_url() ?>/assets_system/css/handsontable14.css" />
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title d-flex justify-content-center justify-content-lg-start">
          <a href="<?= base_url('reports/payslip_generations'); ?>">
            <img class="mr-2" style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
          </a>&nbsp;Payslips: Cutoff SSS Pagibig Philhealth
        </h1>
      </div>
      <div class="col-md-6 button-title d-flex justify-content-end">
        <a id="btn_export" style="width:max-content" class=" btn technos-button-gray shadow-none rounded">
          <img src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>" alt="">
          &nbsp;Export XLSX
        </a>
      </div>
    </div>
    <div class="row my-3">
      <div class="col-12 col-lg-2 justify-content-center justify-content-lg-start">
        <h6>Cutoff-Period</h6>
        <select class="form-control select_period">
          <?php foreach ($CUTOFF_PERIODS as $period) : ?>
            <option value="<?= $period->id ?>" <?= $period->id == $period_param ? 'selected' : '' ?>><?= $period->name ?></option>
          <?php endforeach ?>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col col-md-3">
        <div class="card p-2 small-box position-relative W-75" id="probationary_employees">
          <div style="padding: 10px 10px;" class="text-left">
            <text style="font-size: 2.2rem; font-weight: 700;" id="prob_employees">
              <?= sprintf("%.2f", $SSS_TOTAL) ?>
            </text><br>
            <text>SSS Total</text>
          </div>
          <div class="icon" style="position: absolute; top: 28px; right: 17px;">
            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/money-bill-1-wave-duotone.svg') ?>" alt="" />
          </div>
        </div>
      </div>
      <div class="col col-md-3">
        <div class="card p-2 small-box position-relative" id="probationary_employees">
          <div style="padding: 10px 10px;" class="text-left">
            <text style="font-size: 2.2rem; font-weight: 700;" id="prob_employees">
              <?= sprintf("%.2f", $PHIL_H_TOTAL) ?>
            </text><br>
            <text>Philhealth Total</text>
          </div>
          <div class="icon" style="position: absolute; top: 28px; right: 17px;">
            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/money-bill-1-wave-duotone.svg') ?>" alt="" />
          </div>
        </div>
      </div>
      <div class="col col-md-3">
        <div class="card p-2 small-box position-relative" id="probationary_employees">
          <div style="padding: 10px 10px;" class="text-left">
            <text style="font-size: 2.2rem; font-weight: 700;" id="prob_employees">
              <?= sprintf("%.2f", $PAG_IBIG_TOTAL) ?>
            </text><br>
            <text>Pagibig Total</text>
          </div>
          <div class="icon" style="position: absolute; top: 28px; right: 17px;">
            <img style="width: 80px; height: 60px; opacity: 0.8;" src="<?= base_url('assets_system/icons/money-bill-1-wave-duotone.svg') ?>" alt="" />
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="card border-0 p-0 m-0">
      <div class="card border-0 py-1 m-0">
        <div>
          <p class=" m-2 bg-primary p-1  text-center ml-auto" style="color: gray;width:150px;border-radius:15px">Showing <?= count($BENIFITS) ?> entries&nbsp;</p>
        </div>
        <div class="table-responsive" style="max-height: 75vh">
          <table class="table table-bordered table-hover m-0" id="TableToExport">
            <thead style="position: sticky; top: 0;">
              <tr>
                <th class="text-left" style="min-width: 150px !important">EMPLOYEE ID</th>
                <th class="text-left" style="min-width: 300px !important">EMPLOYEE</th>
                <th class="text-left" style="min-width: 100px !important">SSS</th>
                <th class="text-left" style="min-width: 100px !important">PHILHEALTH</th>
                <th class="text-left" style="min-width: 100px !important">PAG-IBIG</th>
              </tr>
            </thead>
            <tbody id="tbl_application_container">
              <?php if ($BENIFITS) {
                foreach ($BENIFITS as $benifit) {
              ?>
                  <tr>
                    <td class="text-left"><?= $benifit->col_empl_cmid ?></td>
                    <td class="text-left"><?= $benifit->fullname
                                          ?></td>
                    <td class="text-left"><?= sprintf("%.2f", $benifit->SSS_EE_CURRENT ? $benifit->SSS_EE_CURRENT : 0) ?></td>
                    <td class="text-left"><?= sprintf("%.2f", $benifit->PHILHEALTH_EE_CURRENT ? $benifit->PHILHEALTH_EE_CURRENT : 0) ?></td>
                    <td class="text-left"><?= sprintf("%.2f", $benifit->PAGIBIG_EE_CURRENT ? $benifit->PAGIBIG_EE_CURRENT : 0) ?></td>
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
      </div>
    </div> -->

    <div class="row">
      <div class="col">
        <div class="py-0">
          <div>
            <p class=" m-2 bg-primary p-1  text-center ml-auto" style="color: gray;width:150px;border-radius:15px">Showing <?= count($BENIFITS) ?> entries&nbsp;</p>
          </div>
          <div id="handsontable"> </div>
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
<!-- ================================================================ new design End here ======================================================= -->
<!-- LOGOUT MODAL -->
<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p style="font-size: 400px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?
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
<script type="text/javascript" src="<?php echo base_url() ?>/assets_system/js/handsontable14.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.7/jspdf.plugin.autotable.min.js"></script> -->

<script>
  let BENIFITS = <?= json_encode($BENIFITS); ?>;

  const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.style.whiteSpace = 'nowrap';
    td.style.overflow = 'hidden';
    td.style.backgroundColor = '#f9f9f9'; 
  };

  const customRenderer = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    let formattedValue = parseFloat(value || 0).toFixed(2);
        let content = `<span style="float: left;">₱</span><span style="float: right;">${formattedValue}</span>`;
        td.innerHTML = content;
        td.style.textAlign = 'right';
        td.style.backgroundColor = '#f9f9f9'; 
  };

  const container = document.querySelector('#handsontable');
  hot = new Handsontable(container, {
    data: BENIFITS,
    colHeaders: ['ID', 'Employee ID', 'Employee Name', 'SSS', 'PhilHealth', 'Pag-ibig'],
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
        readOnly: true
      },
      {
        data: 'fullname',
        readOnly: true
      },
      {
        data: 'SSS_EE_CURRENT',
        renderer: customRenderer,
        readOnly: true,
      },

      {
        data: 'PHILHEALTH_EE_CURRENT',
        renderer: customRenderer,
        readOnly: true,
      },

      {
        data: 'PAGIBIG_EE_CURRENT',
        renderer: customRenderer,
        readOnly: true,
      },
    ],

  });

  hot.updateSettings({
    height: window.innerHeight - container.getBoundingClientRect().top - 50,
  });
</script>

<!-- Print Starts -->
<script>
  function printFunction() {
    var mainLogoImage = document.querySelector('.main-sidebar img');
    var mainLogoSrc = mainLogoImage.src;
    var leavesData = <?php echo json_encode($BENIFITS); ?>;
    // console.log('leavesData', leavesData);
    var selectedDateRanged = document.getElementById('selecteddaterange').value;
    const currentDate = new Date();
    const months = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ];
    const month = months[currentDate.getMonth()];
    const day = currentDate.getDate();
    const year = currentDate.getFullYear();
    let hours = currentDate.getHours();
    const minutes = currentDate.getMinutes();
    const amOrPm = hours >= 12 ? "PM" : "AM";
    hours = hours % 12 || 12;
    const formattedDateTime = `${month} ${day}, ${year} at ${hours}:${minutes < 10 ? '0' : ''}${minutes} ${amOrPm}`;
    var printContents = ` 
        <table>
            <thead>
                <tr>
                  <th colspan="5">
                    <div style="
                        display: flex;justify-content: space-between;
                        align-items: center;">
                      <div>
                        <img style="height: auto;width: 200px;" src=${mainLogoSrc} alt="">
                      </div>
                      <div>
                        <h5 style="margin: 0; padding: 2px 0;">Approved Leaves</h5>
                        <p style="margin: 0; padding: 2px 0;">Date Range: <span style ="font-weight: 450">${selectedDateRanged}</span></p>
                        <p style="margin: 0; padding: 2px 0;">Print Date: <span style ="font-weight: 450">${formattedDateTime}</span></p>
                      </div>
                    </div>
                  </th>
                </tr>
                <tr>
                  <th class="bg-gray-ben">Date</th>
                  <th class="bg-gray-ben">Employee ID</th>
                  <th class="bg-gray-ben">Employee Name</th>
                  <th class="bg-gray-ben">Type</th>
                  <th class="bg-gray-ben">Duration</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                  ${leavesData.map(item => `
                    <tr>
                      <td>${item.leave_date}</td>
                      <td>${item.col_empl_cmid}</td>
                      <td>${item.fullname}</td>
                      <td>${item.type}</td>
                      <td>${item.duration} hour/s</td>
                    </tr>
                  `).join('')}
                </tr>
            </tbody>
        </table>
      `;
    // Apply styles for printing
    var styleSheet = '<style type="text/css">';
    styleSheet += '@page { margin: 10px 10px; }';
    styleSheet += 'th, td { border: 1px solid #dddddd; text-align: center; font-size: 14px !important}';
    // styleSheet += 'th {background-color: #f2f2f2;}';
    // styleSheet += '.text-vertical{writing-mode: vertical-rl;white-space: nowrap;}';
    styleSheet += '.text-vertical{writing-mode: vertical-rl;white-space: nowrap;transform: rotate(180deg);}';
    styleSheet += '.bg-gray-ben{background: #f2f2f2 !important;-webkit-print-color-adjust: exact;}';
    styleSheet += '</style>';
    scaledContents = styleSheet + printContents;
    var linkElements = document.getElementsByTagName("link");
    for (var i = 0; i < linkElements.length; i++) {
      var linkElement = linkElements[i];
      if (linkElement.getAttribute("href") && linkElement.getAttribute("href").includes("technos_style.css")) {
        linkElement.parentNode.removeChild(linkElement);
      }
    }
    document.body.innerHTML = scaledContents;
    window.print();
    location.reload();
  }
</script>
<!-- Print Ends -->
<!-------------------- Export ----------------->
<script>
  $(document).ready(function() {
    $('select.select_period').on('change', function() {
      let val = $(this).val();
      window.location.href = "?period=" + val;
    })
  })
</script>
<!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> -->
<script src="<?= base_url('assets_system/js') ?>/xlsx.full.min.js"></script>
<script>
  document.getElementById("btn_export").addEventListener('click', function() {
    var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
    XLSX.writeFile(wb, "<?php echo 'employees_sss_pagibig_philhealth_contributions.xlsx' ?>");
  });
</script>
</body>
</html>