<html>
<?php $this->load->view('templates/css_link'); 
$search_data = $this->input->get('search');
$search_data    = str_replace("_", " ", $search_data ?? '');
?>
<link rel="stylesheet" href="<?php echo base_url()?>/assets_system/css/handsontable14.css" />
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title">
          <a href="<?= base_url('reports/attendances'); ?>">
            <img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
          </a>&nbsp;Undertime
          <h1>
      </div>
      <div class="col-md-6 button-title d-none d-lg-flex justify-content-end">
        <button type="button" class="btn btn-primary ml-1" id="printButton" onclick="printFunction()">
          <img style="width: 24px; height: 20px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/print-duotone_sm.svg') ?>" alt="" />&nbsp;Print
        </button>
        <button onclick="exportData()" id="btn_export" style="width:max-content" class="btn btn-primary shadow-none rounded ml-2">
          <img src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>" alt="">
          &nbsp;Export XLSX
        </button>
      </div>
    </div>
   <div class="row my-3">

      <div class="col-12 col-lg-2">
        <h6>Employee</h6>
        <select class="select-employee form-control" id="search_data">
          <option value=''>All</option>
          <?php foreach ($EMPLOYEES as $employee) {
            $name = $employee->col_empl_cmid . '-' . $employee->col_last_name;
            if (!empty($employee->col_suffix)) $name = $name . ' ' . $employee->col_suffix;
            if (!empty($employee->col_frst_name)) $name = $name . ', ' . $employee->col_frst_name;
            if (!empty($employee->col_midl_name)) $name = $name . ' ' . $employee->col_midl_name[0] . '.';
          ?>
            <option value="<?= $employee->id ?>" <?= $search_data == $employee->id ? 'selected' : '' ?>>
              <?= $name ?>
            </option>
          <?php } ?>
        </select>
      </div>

      <div class="col-12 col-lg-2">
        <h6>Cutoff-Period</h6>
        <select class="form-control select_period">
          <option value=''>All</option>
          <?php foreach ($CUTOFF_PERIODS as $period) : ?>
            <option value="<?= $period->id ?>" <?= $period->id == $period_param ? 'selected' : '' ?>>
              <?= $period->name ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>

      <div class="col-12 col-lg-2">
        <h6>Select Date Range</h6>
        <input type="text" class="form-control" name="daterange" id="selecteddaterange"
          value="<?= $START_DATE ?> - <?= $END_DATE ?>" />
      </div>

      <div class="col-12 col-lg-2 d-flex align-items-end">
        <a href="<?= base_url('reports/undertime') ?>" id="btn_clear_filter" class="btn btn-primary">
          <img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="">&nbsp;Clear
        </a>
      </div>

    </div>

    <div class="col-md-6 button-title d-flex d-lg-none justify-content-end my-2">
      <button type="button" class="btn btn-primary ml-1" id="printButton" onclick="printFunction()">
        <img style="width: 24px; height: 20px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/print-duotone_sm.svg') ?>" alt="" />&nbsp;Print
      </button>
    </div>

    <!-- <div class="card border-0 p-0 m-0">
      <div class="card border-0 py-1 m-0">
        <div>
          <p class=" m-2 bg-primary p-1  text-center ml-auto" style="color: gray;width:150px;border-radius:15px">Showing <?= count($UNDERTIME) ?> entries&nbsp;</p>
        </div>
        <div class="table-responsive" style="max-height: 75vh">
          <table class="table table-bordered table-hover m-0" id="TableToExport">
            <thead style="position: sticky; top: 0;">
              <tr>
                <th class="text-left" style="min-width: 150px !important">DATE</th>
                <th class="text-left" style="min-width: 300px !important">EMPLOYEE ID</th>
                <th class="text-left" style="min-width: 300px !important">EMPLOYEE NAME</th>
                <th class="text-left" style="min-width: 150px !important">SHIFT TIME OUT</th>
                <th class="text-left" style="min-width: 150px !important">TIME OUT</th>
                <th class="text-left" style="min-width: 100px !important">NO. OF HOURS</th>
              </tr>
            </thead>
            <tbody id="tbl_application_container">
              <?php if ($UNDERTIME) {
                foreach ($UNDERTIME as $undertime) {
              ?>
                  <tr>
                    <td class="text-left"><?= date_format(date_create($undertime->date), "d/m/Y") ?></td>
                    <td class="text-left"><?= $undertime->col_empl_cmid ?></td>
                    <td class="text-left"><?= $undertime->fullname ?></td>
                    <td class="text-left"><?= $undertime->time_regular_end ?></td>
                    <td class="text-left"><?= $undertime->time_out ?></td>
                    <td class="text-left"><?= $undertime->duration ?></td>
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
            <p class=" m-2 bg-primary p-1  text-center ml-auto" style="color: gray;width:150px;border-radius:15px">Showing <?= count($UNDERTIME) ?> entries&nbsp;</p>
          </div>
          <div  id="handsontable"> </div>
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
<?php $this->load->view('templates/jquery_link'); ?>
<script type="text/javascript" src="<?php echo base_url()?>/assets_system/js/handsontable14.js"></script>

<script>

  let UNDERTIME = <?= json_encode($UNDERTIME); ?>;

  const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
      Handsontable.renderers.TextRenderer.apply(this, arguments);
      td.style.whiteSpace = 'nowrap';
      td.style.overflow = 'hidden';
    };

    const container = document.querySelector('#handsontable');
hot = new Handsontable(container, {
  data: UNDERTIME,
  colHeaders: ['ID', 'Date', 'Employee ID', 'Employee Name', 'Shift Time Out', 'Time Out', 'No. of Minutes'],
  rowHeaders: true,
  height: 'auto',
  outsideClickDeselects: false,
  selectionMode: 'multiple',
  licenseKey: 'non-commercial-and-evaluation',
  hiddenColumns: {
    columns: [0],
  },
  stretchH: 'all',
  columns: [
    { data: 'id', readOnly: true },
    { data: 'newdate', readOnly: true },
    { data: 'col_empl_cmid', readOnly: true },
    { data: 'fullname', readOnly: true },
    { data: 'time_regular_end', readOnly: true },
    { data: 'time_out', readOnly: true },
    {
      data: 'duration', // originally in hours
      readOnly: true,
      renderer: (instance, td, row, col, prop, value, cellProperties) => {
        const minutes = parseFloat(value) * 60;
        td.textContent = isNaN(minutes) ? '' : minutes.toFixed(0) + ' min';
        return td;
      }
    },
  ],
});



    hot.updateSettings({
      height: window.innerHeight - container.getBoundingClientRect().top - 50,
    });

</script>
<script>
  function printFunction() {
    var mainLogoImage = document.querySelector('.main-sidebar img');
    var mainLogoSrc = mainLogoImage.src;
    var UNDERTIME = <?php echo json_encode($UNDERTIME); ?>;
    console.log('UNDERTIME', UNDERTIME);
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
                  <th colspan="6">
                    <div style="
                        display: flex;justify-content: space-between;
                        align-items: center;">
                      <div>
                        <img style="height: auto;width: 200px;" src=${mainLogoSrc} alt="">
                      </div>
                      <div>
                        <h5 style="margin: 0; padding: 2px 0;">Undertime</h5>
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
                  <th class="bg-gray-ben">Shift Time Out</th>
                  <th class="bg-gray-ben">Time Out</th>
                  <th class="bg-gray-ben">Duration</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                  ${UNDERTIME.map(item => `
                    <tr>
                      <td>${item.date? item.date : ''}</td>
                      <td>${item.col_empl_cmid? item.col_empl_cmid : ''}</td>
                      <td>${item.fullname? item.fullname : ''}</td>
                      <td>${item.time_regular_end? item.time_regular_end : ''}</td>
                      <td>${item.time_out? item.time_out : ''}</td>
                      <td>${item.duration? item.duration : ''} hour/s</td>
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

<script>
  $(document).ready(function() {
    $('input[name="daterange"]').daterangepicker({
      opens: 'right',
      locale: {
        format: 'DD/MM/YYYY'
      }
    }, function(start, end, label) {
      window.location.href = "<?= base_url('reports/undertime?date_from=') ?>" + start.format('YYYY-MM-DD') + '&date_to=' + end.format('YYYY-MM-DD');
    });
    $('select.cut_off_period').on('change', function() {
      window.location.href = "<?= base_url('reports/undertime?period=') ?>" + $(this).val()
    })
    $('#daily_add').on('change', function() {
      window.location.href = "<?= base_url('reports/undertime?date=') ?>" + $(this).val();
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
        window.location.href = "<?= base_url('reports/undertime?period=') ?>" + period;
      }
    }

    function compute_time(reg_time, time_out) {
      const time1 = moment(reg_time, 'HH:mm:ss');
      const time2 = moment(time_out, 'HH:mm:ss');

      // Calculate the time difference
      const duration = moment.duration(time1.diff(time2));

      // Calculate the total hours
      const totalHours = duration.asHours();
      const remainingMinutes = Math.floor(duration.minutes() / 15) * 0.25;
      // Apply the condition for minutes (0.25 for every 15 minutes)
      const total_time = parseInt(totalHours) + remainingMinutes
      return total_time;
    }
    // function generatePDF() {
    //     let date_from           = "<?= $START_DATE ?>";
    //     let date_to             = "<?= $END_DATE ?>";
    //     let printDate           = "<?= date('d/m/Y') ?>";
    //     let date_from_formatted = moment(date_from, 'DD/MM/YYYY').format('YYYY-MM-DD');
    //     let date_to_formatted   = moment(date_to, 'DD/MM/YYYY').format('YYYY-MM-DD');;
    //     let url                 ="<?= base_url('reports/get_undertime_data?date_from=') ?>"+date_from_formatted+'&date_to='+date_to_formatted;
    //     fetch(url)
    //     .then(res=>res.json())
    //     .then((data)=>{
    //         let data_formatted=[];
    //         for(let i=0;i<data.length;i++){
    //           let name=data[i].col_last_name;
    //           if(data[i].col_suffix)name=name+' '+data[i].col_suffix;
    //           if(data[i].col_frst_name)name=name+', '+data[i].col_frst_name;
    //           if(data[i].col_midl_name)name=name+' '+data[i].col_midl_name[0]+'.';
    //             data_formatted[i]=[data[i].date,
    //             // data[i].col_last_name+' '+data[i].col_frst_name+','+data[i].col_midl_name,
    //             name,
    //             data[i].time_out,compute_time(data[i].time_regular_end,data[i].time_out)]
    //         }
    //         const doc = new jsPDF();
    //         var width       = doc.internal.pageSize.width;
    //         var height      = doc.internal.pageSize.height;
    //         var logo = "<?= base64_encode(file_get_contents(base_url('assets_system/images/login_logo.png'))) ?>";

    //         // Define your company logo (replace with your own logo)
    //         const companyLogo = 'data:image/png;base64,'+logo; // Replace with your logo URL or base64 data
    //         // Set title, date, and print date
    //         const title = 'Undertime';
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
    //             head: [['Date', 'Employee', 'Time Out','No. of Hours']],
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
<script>
    $(document).ready(function() {

      $('.select-employee').select2();
      let employeeId = $('#search_data').val();
      let period = "<?= $period_param ?>";

      $('input[name="daterange"]').daterangepicker({
        opens: 'right',
        locale: {
          format: 'DD/MM/YYYY'
        }
      }, function(start, end, label) {
        window.location.href = "<?= base_url('reports/undertime?date_from=') ?>" + start.format('YYYY-MM-DD') + '&date_to=' + end.format('YYYY-MM-DD') + '&search=' + employeeId;
      });

      $('#search_data').on('change', function() {
        let employeeId = $(this).val();
        let currentUrl = new URL(window.location.href);

        // Convert strings to moment objects
        let startDate = moment('<?= $START_DATE ?>', 'DD/MM/YYYY');
        let endDate = moment('<?= $END_DATE ?>', 'DD/MM/YYYY');

        // Build and redirect to new URL
        let newUrl = `${currentUrl.origin}${currentUrl.pathname}?date_from=${startDate.format('YYYY-MM-DD')}&date_to=${endDate.format('YYYY-MM-DD')}&search=${employeeId}&period=${period}`;
        window.location.href = newUrl;
      });

      $('select.select_period').on('change', function() {
        period = $('.select_period').val();
        let currentUrl = new URL(window.location.href);
        // Build and redirect to new URL
        let newUrl = `${currentUrl.origin}${currentUrl.pathname}?search=${employeeId}&period=${period}`;
        window.location.href = newUrl;
      })



      $('select.cut_off_period').on('change', function() {
        window.location.href = "<?= base_url('reports/undertime?period=') ?>" + $(this).val()
      })
      $('#daily_add').on('change', function() {
        window.location.href = "<?= base_url('reports/undertime?date=') ?>" + $(this).val();
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
          window.location.href = "<?= base_url('reports/undertime?period=') ?>" + period;
        }
      }

      function time_difference(time_reg, time_in) {
        var time1 = moment(time_reg, 'HH:mm:ss');
        var time2 = moment(time_in, 'HH:mm:ss');
        var totalMinutes = time2.diff(time1, 'minutes');
        var totalHours = Math.floor(totalMinutes / 60) + Math.min(1, Math.max(0, Math.floor(totalMinutes / 15) * 0.25));
        return totalHours;
      }

    })
  </script>

<script>
  $(document).ready(function() {
    $('input[name="daterange"]').daterangepicker({
      opens: 'right',
      locale: {
        format: 'DD/MM/YYYY'
      }
    }, function(start, end, label) {
      window.location.href = "<?= base_url('reports/undertime?date_from=') ?>" + start.format('YYYY-MM-DD') + '&date_to=' + end.format('YYYY-MM-DD');
    });
    $('select.cut_off_period').on('change', function() {
      window.location.href = "<?= base_url('reports/undertime?period=') ?>" + $(this).val()
    })
    $('#daily_add').on('change', function() {
      window.location.href = "<?= base_url('reports/undertime?date=') ?>" + $(this).val();
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
        window.location.href = "<?= base_url('reports/undertime?period=') ?>" + period;
      }
    }

    function time_difference(time_reg, time_in) {
      var time1 = moment(time_reg, 'HH:mm:ss');
      var time2 = moment(time_in, 'HH:mm:ss');
      var totalMinutes = time2.diff(time1, 'minutes');
      var totalHours = Math.floor(totalMinutes / 60) + Math.min(1, Math.max(0, Math.floor(totalMinutes / 15) * 0.25));
      return totalHours;
    }
  })
</script>

<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
function exportData() {
  // Get headers and data from Handsontable
  const headers = hot.getColHeader();
  const data = hot.getData();

  // Optional: convert "duration" (hours) to minutes before export
  const updatedData = data.map(row => {
    const hours = parseFloat(row[6]); // assuming 'duration' is the 7th column (index 6)
    const minutes = isNaN(hours) ? '' : (hours * 60).toFixed(0);
    row[6] = minutes + ' min';
    return row;
  });

  // Combine headers + data
  const sheetData = [headers, ...updatedData];

  // Create Excel sheet and workbook
  const ws = XLSX.utils.aoa_to_sheet(sheetData);
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "Undertime Report");

  // Optional: set column widths for nicer output
  ws['!cols'] = [
    { wch: 5 },   // ID
    { wch: 12 },  // Date
    { wch: 15 },  // Employee ID
    { wch: 25 },  // Name
    { wch: 15 },  // Shift Time Out
    { wch: 15 },  // Time Out
    { wch: 15 }   // No. of Minutes
  ];

  // Download Excel file
  XLSX.writeFile(wb, "undertime_report.xlsx");
}

</script>
</body>

</html>