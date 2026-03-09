<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="<?php echo base_url() ?>/assets_system/css/handsontable14.css" />
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <!-- <a href="<?= base_url() . 'payrolls'; ?>"><i class="fa-solid fa-square-left"></i> -->
        <h1 class="page-title"><a href="<?= base_url('reports/employee_informations'); ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Probationary Employees<h1>
      </div>
      <div class="col-md-6 button-title d-none d-lg-flex justify-content-end">
        <!--<a href="<?= base_url() . 'payrolls/add_loans' ?>" id="btn_new" class=" btn technos-button-green shadow-none rounded"><i class="fas fa-plus"></i>&nbsp;Add New Loan</a>-->
        <!--<a href="<?= base_url('payrolls/bulk_loans') ?>" id="bulk_import" class=" btn technos-button-green shadow-none rounded" ><i class="fas fa-file-import"></i>&nbsp;Bulk Import</a>-->
        <!-- <a id="btn_export" class=" btn technos-button-blue shadow-none rounded" ><i class="fas fa-file-pdf"></i>&nbsp;Export PDF</a> -->
        <button type="button" class="btn btn-primary ml-1" id="printButton" onclick="printFunction()"><img style="width: 24px; height: 20px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/print-duotone_sm.svg') ?>" alt="" />&nbsp;Print</button>
      </div>
    </div>

    <div class="row my-3">
      <div class="col-12 col-lg-2 justify-content-center justify-content-lg-start">
        <h6>Select Date Range</h6>
        <input type="text" class="form-control" name="daterange" id="selecteddaterange" value="<?= $START_DATE ?> - <?= $END_DATE ?>" />
      </div>
      <div class="col-9">

      </div>
    </div>

    <div class="col-md-6 button-title  d-flex d-lg-none justify-content-end my-2">
      <button type="button" class="btn btn-primary ml-1" id="printButton" onclick="printFunction()"><img style="width: 24px; height: 20px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/print-duotone_sm.svg') ?>" alt="" />&nbsp;Print</button>
    </div>

    <!-- <div class="card border-0 p-0 m-0">
      <div class="card border-0 py-1 m-0">
        <div>
          <p class=" m-2 bg-primary p-1  text-center ml-auto" style="color: gray;width:150px;border-radius:15px">Showing <?= count($EMPLOYEES) ?> entries&nbsp;</p>
        </div>
        <div class="table-responsive" style="max-height: 75vh">
          <table class="table table-bordered table-hover m-0" id="TableToExport">
            <thead style="position: sticky; top: 0;">
              <tr>
                <th class="text-left" style="min-width: 100px !important">DATE</th>
                <th class="text-left" style="min-width: 100px !important">EMPLOYEE ID</th>
                <th class="text-left" style="min-width: 100px !important">EMPLOYEE NAME</th>
                <th class="text-left" style="min-width: 100px !important">FROM</th>
                <th class="text-left" style="min-width: 100px !important">TO</th>
              </tr>
            </thead>
            <tbody id="tbl_application_container">
              <?php if ($EMPLOYEES) {
                foreach ($EMPLOYEES as $employee) { ?>
                  <tr>
                    <td class="text-left"><?= date_format(date_create($employee->log_date), "d/m/Y") ?></td>
                    <td class="text-left"><?= $employee->col_empl_cmid ?></td>
                    <td class="text-left"><?= $employee->fullname ?></td>
                    <td class="text-left"><?= $employee->from_val ? $employee->from_val : '' ?></td>
                    <td class="text-left"><?= $employee->to_val ? $employee->to_val : '' ?></td>
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
            <p class=" m-2 bg-primary p-1  text-center ml-auto" style="color: gray;width:150px;border-radius:15px">Showing <?= count($EMPLOYEES) ?> entries&nbsp;</p>
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
  let EMPLOYEES = <?= json_encode($EMPLOYEES); ?>;

  const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.style.whiteSpace = 'nowrap';
    td.style.overflow = 'hidden';
  };

  const container = document.querySelector('#handsontable');
  hot = new Handsontable(container, {
    data: EMPLOYEES,
    colHeaders: ['ID', 'Date Hire', 'Employee ID', 'Employee Name', 'From', 'To'],
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
        data: 'formatted_date',
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
    ],

  });

  hot.updateSettings({
    height: window.innerHeight - container.getBoundingClientRect().top - 50,
  });
</script>

<!-------------------- Export ----------------->

<script>
  function printFunction() {
    var mainLogoImage = document.querySelector('.main-sidebar img');
    var mainLogoSrc = mainLogoImage.src;
    var EMPLOYEES = <?php echo json_encode($EMPLOYEES); ?>;
    console.log('EMPLOYEES', EMPLOYEES);
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
                        <h5 style="margin: 0; padding: 2px 0;">Probationary Employees</h5>
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
                <th class="bg-gray-ben">From</th>
                <th class="bg-gray-ben">To</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                  ${EMPLOYEES.map(item => `
                    <tr>
                      <td>${item.log_date? formatDateOnly(item.log_date) : ''}</td>
                      <td>${item.col_empl_cmid? item.col_empl_cmid : ''}</td>
                      <td>${item.fullname? item.fullname : ''}</td>
                      <td>${item.from_val? item.from_val : ''}</td>
                      <td>${item.to_val? item.to_val : ''}</td>
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

  function formatDateOnly(dateTimeString) {
    var parts = dateTimeString.split(" ");
    var datePart = parts[0];
    return datePart;
  }
</script>

<script>
  $(document).ready(function() {
    $('input[name="daterange"]').daterangepicker({
      opens: 'right',
      locale: {
        format: 'DD/MM/YYYY'
      }
    }, function(start, end, label) {
      window.location.href = "<?= base_url('reports/probationary_employees?date_from=') ?>" + start.format('YYYY-MM-DD') + '&date_to=' + end.format('YYYY-MM-DD');
    });
    $('select.cut_off_period').on('change', function() {
      window.location.href = "<?= base_url('reports/probationary_employees?period=') ?>" + $(this).val()
    })
    $('#daily_add').on('change', function() {
      window.location.href = "<?= base_url('reports/probationary_employees?date=') ?>" + $(this).val();
    })
    $('.filter_type').on('change', function() {
      filter_type();
    })

    function filter_type() {
      let filter_type = $('.filter_type').val();

      if (filter_type === 'daily') {
        $('#daily_container').show();
        $('#period_container').hide();
      }
      if (filter_type === 'period') {
        // alert(filter_type);
        // console.log()
        let period = $('.cut_off_period').val();
        $('#period_container').show();
        $('#daily_container').hide();
        window.location.href = "<?= base_url('reports/probationary_employees?period=') ?>" + period;
      }
    }
    // function generatePDF() {
    //     let date_from           = "<?= $START_DATE ?>";
    //     let date_to             = "<?= $END_DATE ?>";
    //     let printDate           = "<?= date('d/m/Y') ?>";
    //     let date_from_formatted = moment(date_from, 'DD/MM/YYYY').format('YYYY-MM-DD');
    //     let date_to_formatted   = moment(date_to, 'DD/MM/YYYY').format('YYYY-MM-DD');;
    //     let url                 ="<?= base_url('reports/get_probi_employees_data?date_from=') ?>"+date_from_formatted+'&date_to='+date_to_formatted;
    //     fetch(url)
    //     .then(res=>res.json())
    //     .then((data)=>{
    //         let data_formatted=[];
    //         for(let i=0;i<data.length;i++){
    //           let name=data[i].col_last_name;
    //           if(data[i].col_suffix)name=name+' '+data[i].col_suffix;
    //           if(data[i].col_frst_name)name=name+', '+data[i].col_frst_name;
    //           if(data[i].col_midl_name)name=name+' '+data[i].col_midl_name[0]+'.';
    //             data_formatted[i]=[data[i].log_date,
    //             // data[i].col_last_name+' '+data[i].col_frst_name+','+data[i].col_midl_name,
    //             name,
    //             data[i].from_val,data[i].to_val]
    //         }
    //         const doc = new jsPDF();
    //         var width       = doc.internal.pageSize.width;
    //         var height      = doc.internal.pageSize.height;
    //         var logo = "<?= base64_encode(file_get_contents(base_url('assets_system/images/login_logo.png'))) ?>";

    //         // Define your company logo (replace with your own logo)
    //         const companyLogo = 'data:image/png;base64,'+logo; // Replace with your logo URL or base64 data
    //         // Set title, date, and print date
    //         const title = 'Probationary Employees';
    //         const optionsDate = { year: 'numeric', month: 'short', day: '2-digit' };
    //         // const cutoffDate = new Date().toLocaleDateString();
    //         const printDate = new Date().toLocaleDateString('en-US', optionsDate);
    //         const cutoffDateText=`Cut-off Period: ${date_from} - ${date_to}`;
    //         const printDateText= `Print Date: ${printDate}`;
    //         // Define your table data (replace with your own data)
    //         const tableData = [
    //             ...data_formatted
    //         ];

    //         // Set the title
    //         doc.setFontSize(16);
    //         doc.text(width-doc.getTextWidth(title)-10, 10,title, { align: "right" });

    //         // Set the date and print date
    //         doc.setFontSize(10);
    //         doc.text(width-doc.getTextWidth(cutoffDateText)-10, 18,cutoffDateText,{align:"right"});
    //         doc.text(width-doc.getTextWidth(printDateText)-10, 25,printDateText, {align:"right"});

    //         // Add the company logo (adjust position and size as needed)
    //         doc.addImage(companyLogo, 'PNG',  5, 5, 60, 0);

    //         // Create the table
    //         doc.autoTable({
    //             startY: 40,
    //             head: [['Date', 'Employee', 'From','To']],
    //             headStyles: {
    //                     fillColor: [176, 196, 222], // RGB color for the header background
    //                     fontStyle: 'bold', // Font style of the header text
    //                     textColor: [0, 0, 0],
    //                     lineWidth: 0.2, // Body border line width
    //                     lineColor: [0, 0, 0], // Body border line color
    //                 },
    //             body: tableData,
    //             bodyStyles:{
    //                 textColor: [0, 0, 0],
    //                 lineWidth: 0.2, // Body border line width
    //                 lineColor: [0, 0, 0], // Body border line color
    //             }
    //         });

    //         // Save or open the PDF
    //         // doc.save('sample-report.pdf');
    //          window.open(doc.output('bloburl'), '_blank');
    //     })
    //     return;
    //     // Create a new jsPDF instance


    // }
    // $('#btn_export').on('click',function(){
    //      generatePDF();
    // })
  })
</script>
</body>

</html>