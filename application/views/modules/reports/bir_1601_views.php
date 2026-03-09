<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="<?php echo base_url() ?>/assets_system/css/handsontable14.css" />
<?php
$search_data = $this->input->get('all');

$search_data = str_replace("_", " ", $search_data ?? '');
$id_prefix = 'OVT';
$TAB = 'active';
$ACTIVES = 0;
$INACTIVES = 0;
// $ROW=25;
$STATUS = '';
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
<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title"><a href="<?= base_url('reports/goverment_forms'); ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;BIR 1601-C<h1>
      </div>
    </div>
    <div class="col-12 col-lg-3 my-3">
      <!--<h6>Select Date</h6>-->
      <!--<input type="text" class="form-control" name="daterange" id="selecteddaterange"  />-->
      <div class="input-group mb-3">
        <!--<div class="input-group-prepend">-->
        <!--  <label class="input-group-text" for="inputGroupSelect01">Month</label>-->
        <!--</div>-->
        <select class="custom-select" id="month">
          <?php if ($MONTHS) {
            foreach ($MONTHS as $key => $value) { ?>
              <option value="<?= str_pad($key, 2, "0", STR_PAD_LEFT) ?>"><?= $value ?></option>
            <?php } ?>
        </select>
        <select class="custom-select" id="year">
          <?php for ($i = $YEAR; $i >= $YEAR - 50; $i--) { ?>
            <option value="<?= $i ?>"><?= $i ?></option>
          <?php } ?>
        <?php } else { ?>
          <tr class="table-active">
            <td colspan="12">
              <center>No Records</center>
            </td>
          </tr>
        <?php } ?>
        </select>
        <!--<div class="input-group-append">-->
        <!--  <label class="input-group-text" for="inputGroupSelect01">Year</label>-->
        <!--</div>-->
      </div>

    </div>
    <div class="card">
      <div class="py-2">
        <div class="row d-flex justify-content-between align-items-center">
          <div class="col-12 col-lg-3 d-flex justify-content-center justify-content-lg-start ml-0 ml-lg-2">
            <button class="generate_pdfs btn btn-primary m-1" hidden>Generate PDF </button>
            <button class="generate_pdfs_handsontable btn btn-primary m-1">Generate PDF</button>
            <!--<button type="button" class=" pdf-print btn btn-primary m-1" id="printButton" ><i class="fa-duotone fa-print"></i>&nbsp;Print</button>-->
          </div>
          <!-- <button id="btn_application"    class=" btn technos-button-gray shadow-none rounded" data-toggle="modal" data-target="#modal_insert"  ><i class="far fa-trash-alt"></i>&nbsp;Delete</button> -->
          <div class="col-12 col-lg-7 d-none d-lg-flex justify-content-center justify-content-lg-end align-items-center row ">
            <div class="col-12 col-lg-7 d-flex justify-content-center justify-content-lg-end py-1">
              <p class="p-0 m-0" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
            </div>

            <div class="col-12 col-lg-3 d-flex justify-content-center justify-content-lg-end">
              <ul class="d-inline pagination m-0 p-0 ">
                <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
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
          <div class="col-12 col-lg-1 d-none d-lg-flex justify-content-center my-0 my-lg-2 align-items-center">
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
      <!-- <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th scope="col" class="text-center"><input type="checkbox" id="select_all" /></th>
              <th scope="col">EMPLOYEE ID</th>
              <th scope="col">NAME</th>
              <th scope="col" class="text-center">ACTION</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($EMPLOYEES) {
              foreach ($EMPLOYEES as $employee) { ?>
                <tr>
                  <td class="text-center"><input data-userId="<?= $employee->id ?>" value="<?= $employee->id ?>" type="checkbox" class="empl_select" /></td>
                  <td scope="row"><?= $employee->col_empl_cmid ?></td>
                  <td><?= $employee->fullname ?></td>
                  <td class="text-center">
                    <a class="pdf-file select_row p-2" data-userId="<?= $employee->id ?>" style="color: gray; cursor: pointer; !important">
                       <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt=""></a>
                  </td>
                </tr>

              <?php }
            } else { ?>
              <tr class="table-active">
                <td colspan="12">
                  <center>No Records</center>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div> -->

      <div class="row">
        <div class="col">
          <div class="py-0">
            <!-- <div>
              <p class=" m-2 bg-primary p-1  text-center ml-auto" style="color: gray;width:150px;border-radius:15px">Showing <?= count($EMPLOYEES) ?> entries&nbsp;</p>
            </div> -->
            <div id="handsontable"> </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-7 d-flex d-lg-none justify-content-center justify-content-lg-end align-items-center row my-2">
        <div class="col-12 col-lg-7 d-flex justify-content-center justify-content-lg-end py-1">
          <p class="p-0 m-0" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
        </div>

        <div class="col-12 col-lg-3 d-flex justify-content-center justify-content-lg-end">
          <ul class="d-inline pagination m-0 p-0 ">
            <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
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
      <div class="col-12 col-lg-1 d-flex d-lg-none justify-content-center my-0 my-lg-2 align-items-center my-2">
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
<?php $this->load->view('templates/jquery_link'); ?>
<script type="text/javascript" src="<?php echo base_url() ?>/assets_system/js/handsontable14.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script> -->
<script src="<?= base_url('assets_system/js') ?>/pdf-lib.min.js"></script>
<script>
  (function() {
    $(document).ready(function() {


    //================================== HANDSONTABLE STARTS HERE ================================================

        let EMPLOYEES = <?= json_encode($EMPLOYEES); ?>;

        const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
          Handsontable.renderers.TextRenderer.apply(this, arguments);
          td.style.whiteSpace = 'nowrap';
          td.style.overflow = 'hidden';
        };

        const customCheckboxRenderer = function(instance, td, row, col, prop, value, cellProperties) {
          Handsontable.renderers.CheckboxRenderer.apply(this, arguments);
          td.style.textAlign = 'center';
          td.style.verticalAlign = 'middle';
        };

        const selectHeaderLabel = `<input type="checkbox" id="checkAllCheckbox">`;
        const container = document.querySelector('#handsontable');
        
        hot = new Handsontable(container, {
          data: EMPLOYEES,
          colHeaders: ['ID', 'Select All ' + selectHeaderLabel, 'Employee ID', 'Employee Name', 'Action'],
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
              data: 'isSelected',
              type: 'checkbox',
              renderer: customCheckboxRenderer,
              readOnly: false,
              width: 18,
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
              data: 'id',
              renderer: function(instance, td, row, col, prop, value, cellProperties) {
                Handsontable.renderers.TextRenderer.apply(this, arguments);
                const button = document.createElement('img');
                button.src = '<?= base_url('assets_system/icons/eye-duotone.svg') ?>';
                td.style.cursor = 'pointer';
                
                td.addEventListener('click', async function(event) {
                  const selectedEmployeeId = EMPLOYEES[row].id; // Get employee ID from data
                  // Rest of your code to fetch data, annotate PDF, and open it
                  let information = await getEmployeesData([selectedEmployeeId]);
                  let data = information.employees;
                  let employers = information.employers;
                  const url = "<?= base_url('assets_system/reports/BIR1601C.pdf') ?>";
                  const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())
                  const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
                  const helveticaFont = await pdfDoc.embedFont(PDFLib.StandardFonts.Helvetica)

                  const pages = pdfDoc.getPages()
                  const firstPage = pages[0]
                  //annotate data
                  annotatePage(firstPage, data[0], employers)
                  const pdfBytes = await pdfDoc.save()
                  // Convert PDF bytes to a Blob
                  const pdfBlob = new Blob([pdfBytes], {
                    type: 'application/pdf'
                  });

                  // Create a temporary URL and open the PDF in a new tab
                  const url_data = URL.createObjectURL(pdfBlob);
                  window.open(url_data, '_blank');
                });

                td.style.textAlign = 'center';
                td.innerHTML = '';
                td.appendChild(button);
              },
            },
            
          ],

        });

        hot.updateSettings({
          height: window.innerHeight - container.getBoundingClientRect().top - 50,
        });


        document.addEventListener('change', function(event) {
          if (event.target.id === 'checkAllCheckbox') {
            let isChecked = event.target.checked;
            // console.log(isChecked)
            for (let data of EMPLOYEES) {
              // console.log(data)
              if (data.isSelected !== isChecked) {
                data.isSelected = true;
              } else {
                data.isSelected = false;
              }
            }
            hot.render();
          }
          
          if (event.target.type === 'checkbox') {
            const checkbox = document.querySelector('#checkAllCheckbox');
            const allChecked = EMPLOYEES.every(data => data.isSelected);
            document.getElementById('checkAllCheckbox').checked = allChecked;
          }
        });

        $('button.generate_pdfs_handsontable').on('click', async function() {

          let checkedEmployeeIds = [];

          for (const data of EMPLOYEES) {
              if (data.isSelected) {
                  checkedEmployeeIds.push(data.id);
              }
          }

          if (checkedEmployeeIds.length === 0) {
              $(document).Toasts('create', {
                  class: 'bg-warning toast_width',
                  title: 'Warning!',
                  subtitle: 'close',
                  body: 'Please select at least one employee.'
              });
              return;
          }

          let informations = await getEmployeesData(checkedEmployeeIds);
          let data = informations.employees;
          const url = "<?= base_url('assets_system/reports/BIR1601C.pdf') ?>";
          const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())
          const srcDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
          const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
          const pages = await pdfDoc.getPages();
          const firstPage = pages[0];
          annotatePage(firstPage, data[0])
          let res = await data.forEach(async function(element, index) {
            if (index > 0) {
              let [page1] = await pdfDoc.copyPages(srcDoc, [0]);
              pdfDoc.addPage(annotatePage(page1, element));
            }
          });
          const doc_pages = await pdfDoc.getPages();
          const pdfBytes = await pdfDoc.save()

          const pdfBlob = new Blob([pdfBytes], {
            type: 'application/pdf'
          });
          // Create a temporary URL and open the PDF in a new tab
          const url_data = URL.createObjectURL(pdfBlob);
          window.open(url_data, '_blank');

        });



    //================================== HANDSONTABLE ENDS HERE ================================================





      function writeText(page, text, x, y, size = 12) {
        page.drawText(text, {
          x: x,
          y: y,
          size: size,
          font: PDFLib.helveticaFont,
          color: PDFLib.rgb(0, 0, 0),
          align: 'center'
        })
      }

      function loopText(page, text, x, y, steps, size = 12) {
        for (let char of text) {
          writeText(page, char, x, y, size);
          if (char.length > 1) {
            x += (char.length * 10) + steps
            continue
          }
          x += steps;
        }
      }

      function annotatePage(page, data) {
        let today = $('select#month').val() + $('select#year').val();
        let text_x = 49;
        loopText(page, today, text_x, 810, 14.5)
        // number of sheets
        loopText(page, '23', 450, 810, 14.5)
        // writeText( firstPage,'2  3',450,345);
        // ATC
        loopText(page, '2222', 540, 810, 10)
        // Tin number
        let tin = data['col_empl_btin'].split('-').join('').replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        text_x = 235.6
        loopText(page, tin, text_x, 780, 14.3)
        loopText(page, '403', 552, 780, 14.8)
        //  Withholding Agent’s Name
        let fullname = data.fullname;
        let zip = '4422';
        let address = data.col_home_addr;
        let contact_number = data.col_mobl_numb;
        let email = data.col_empl_emai;
        let compensation = parseInt(data.salary_rate).toFixed(2).split('').reverse().join('');
        let sat_min_wage = parseInt(data.salary_rate);
        sat_min_wage = sat_min_wage.toFixed(2).split('').reverse().join('');
        /** excess_pay          - holiday,overtime,night shifts diff and hazard pay
            benefits_pay        - 13th month pay and other benefits
            demin_benefits      - De Minimis Benefits
            mando_contribution  - SSS, GSIS, PHIC, HDMF Mandatory Contributions & Union Dues (employee’s share only)
            other_non_tax            - Other Non-Taxable Compensation
            total_non_tax_com        - Total Non-Taxable Compensation 
            total_tax_com            - Total Taxable Compensation
            less_tax_com_witholding  - Less: Taxable compensation not subject to withholding tax (for employees, other than MWEs, receiving P250,000 & below for the year)
            net_tax_com              - Net Taxable Compensation
            total_tax_witheld        - Total Taxes Withheld 
            tax_adj_widtheld         - Add/(Less): Adjustment of Taxes Withheld from Previous Month/s (From Part IV-Schedule 1, Item 4)
            tax_widtheld_remittance  - Taxes Withheld for Remittance 
            less_tax_remittance      - Less: Tax Remitted in Return Previously Filed, if this is an amended return 
            other_remittance         - Other Remittances Made
            total_tax_remittance     - Total Tax Remittances Made
            tax_due                  - Tax Still Due/(Over-remittance) 
            penalty_surcharge        - Surcharge
            penalty_interest         - Interest
            penalty_compromise       - Compromise
            total_penalties          - Total Penalties
            total_amount_due         - TOTAL AMOUNT STILL DUE/(Over-remittance)
            cash_debit               - 
        */
        let excess_pay = 45328.345363.toFixed(2).split('').reverse().join('');
        let benefits_pay = 628.345363.toFixed(2).split('').reverse().join('');
        let demin_benefits = 422.345645.toFixed(2).split('').reverse().join('');
        let mando_contribution = 5234.23.toFixed(2).split('').reverse().join('');
        let other_non_tax = 400.2345.toFixed(2).split('').reverse().join('');
        let total_non_tax_com = 470.34.toFixed(2).split('').reverse().join('');
        let total_tax_com = 4320.34.toFixed(2).split('').reverse().join('');
        let less_tax_com_witholding = 350.33.toFixed(2).split('').reverse().join('');
        let net_tax_com = 550.33.toFixed(2).split('').reverse().join('');
        let total_tax_witheld = 650.33.toFixed(2).split('').reverse().join('');
        let tax_adj_widtheld = 550.32.toFixed(2).split('').reverse().join('');
        let tax_widtheld_remittance = 2123.00.toFixed(2).split('').reverse().join('');
        let less_tax_remittance = 3429.00.toFixed(2).split('').reverse().join('');
        let other_remittance = 1429.00.toFixed(2).split('').reverse().join('');
        let total_tax_remittance = 6429.00.toFixed(2).split('').reverse().join('');
        let tax_due = 8329.00.toFixed(2).split('').reverse().join('');
        let penalty_surcharge = 1329.00.toFixed(2).split('').reverse().join('');
        let penalty_interest = 2329.00.toFixed(2).split('').reverse().join('');
        let penalty_compromise = 4329.00.toFixed(2).split('').reverse().join('');
        let total_penalties = 8329.00.toFixed(2).split('').reverse().join('');
        let total_amount_due = 8529.00.toFixed(2).split('').reverse().join('');

        let text_y = 753.5;
        loopText(page, fullname, 20.3, text_y, 14.4)
        loopText(page, address.substr(0, 40), 20, text_y - 26, 14.4)
        loopText(page, address.substr(40), 20, text_y - 42.5, 14.4)
        loopText(page, zip, 540, text_y -= 40, 14.4)
        loopText(page, contact_number, 108, text_y -= 20, 14.4)
        loopText(page, email, 108, text_y -= 17, 14.4)
        text_y = 628;
        // part 2 
        let part3_data = [sat_min_wage, excess_pay, benefits_pay, demin_benefits, mando_contribution,
          other_non_tax, total_non_tax_com, total_tax_com,
          less_tax_com_witholding, net_tax_com, total_tax_witheld,
          tax_adj_widtheld, tax_widtheld_remittance, less_tax_remittance,
          other_remittance, total_tax_remittance, tax_due, penalty_surcharge,
          penalty_interest, penalty_compromise, total_penalties, total_amount_due
        ];
        loopText(page, compensation, 583.2, text_y, -14.4)
        text_y -= 26;
        // loopText(page,sat_min_wage,583.2,text_y-=26,-14.4)
        for (let text of part3_data) {
          loopText(page, text, 583.2, text_y, -14.4);
          text_y -= 16;
        }
        //part 3
        /**
        debit_memo  - Cash/Bank Debit Memo
        check       - Check    
        */

        let debit_memo = {
          agency: 'PNBKB',
          number: '123456',
          date: '02022022',
          amount: '1234567'
        }
        let check = {
          agency: 'PNB',
          number: '234567',
          date: '02022022',
          amount: '1'
        }
        loopText(page, debit_memo.agency, 120, 135, 14.4)
        loopText(page, debit_memo.number, 194, 135, 14.4)
        loopText(page, debit_memo.date, 280, 135, 14.4)
        loopText(page, debit_memo.amount, 538, 135, -14.4)

        return page;
      }
      $('input#select_all').on('change', function() {
        if ($(this).prop('checked')) {
          $('input.empl_select').prop('checked', true)
          return
        }
        $('input.empl_select').prop('checked', false)
      })
      async function getEmployeesData(ids) {
        const data = await $.post("<?= base_url('reports/get_employee_info') ?>", {
          'ids': ids
        }, function(res) {
          return res
        }, 'json');
        return data;
      }
      $('button.generate_pdfs').on('click', async function() {
        let ids = await $('.empl_select:checked').map(function() {
          return this.value;
        }).get();
        if (ids.length <= 0) {
          alert('Please Select Employees');
          return;
        }
        let informations = await getEmployeesData(ids);
        let data = informations.employees;
        const url = "<?= base_url('assets_system/reports/BIR1601C.pdf') ?>";
        const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())
        const srcDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
        const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
        const pages = await pdfDoc.getPages();
        const firstPage = pages[0];
        annotatePage(firstPage, data[0])
        let res = await data.forEach(async function(element, index) {
          if (index > 0) {
            let [page1] = await pdfDoc.copyPages(srcDoc, [0]);
            pdfDoc.addPage(annotatePage(page1, element));
          }
        });
        const doc_pages = await pdfDoc.getPages();
        const pdfBytes = await pdfDoc.save()

        const pdfBlob = new Blob([pdfBytes], {
          type: 'application/pdf'
        });
        // Create a temporary URL and open the PDF in a new tab
        const url_data = URL.createObjectURL(pdfBlob);
        window.open(url_data, '_blank');
      })


      $('button.pdf-print').on('click', async function(e) {
        let ids = await $('.empl_select:checked').map(function() {
          return this.value;
        }).get();
        if (ids.length <= 0) {
          alert('Please Select Employees');
          return;
        }
        let data = await getEmployeesData(ids);

        const url = "<?= base_url('assets_system/reports/BIR1601C.pdf') ?>";
        const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())
        const srcDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
        const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
        const pages = await pdfDoc.getPages();
        const firstPage = pages[0];
        annotatePage(firstPage, data[0])
        let res = await data.forEach(async function(element, index) {
          if (index > 0) {
            let [page1] = await pdfDoc.copyPages(srcDoc, [0]);
            pdfDoc.addPage(annotatePage(page1, element));
          }
        });
        const doc_pages = await pdfDoc.getPages();
        const pdfBytes = await pdfDoc.save()

        const pdfBlob = new Blob([pdfBytes], {
          type: 'application/pdf'
        });

        // Create a temporary URL and open the PDF in a new tab
        const url_data = URL.createObjectURL(pdfBlob);
        const pdfContent = url_data;
        const iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        document.body.appendChild(iframe);
        iframe.src = pdfContent;

        // Trigger print action
        iframe.onload = function() {
          iframe.contentWindow.print();
        };
        // window.open(url_data, '_blank');
      })

      $('a.pdf-file').on('click', async function(e) {
        let information = await getEmployeesData([$(this).attr('data-userId')]);
        let data = information.employees;
        const url = "<?= base_url('assets_system/reports/BIR1601C.pdf') ?>";
        const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())
        const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
        const helveticaFont = await pdfDoc.embedFont(PDFLib.StandardFonts.Helvetica)

        const pages = pdfDoc.getPages()
        const firstPage = pages[0]
        //annotate data
        annotatePage(firstPage, data[0])
        const pdfBytes = await pdfDoc.save()
        // Convert PDF bytes to a Blob
        const pdfBlob = new Blob([pdfBytes], {
          type: 'application/pdf'
        });

        // Create a temporary URL and open the PDF in a new tab
        const url_data = URL.createObjectURL(pdfBlob);
        window.open(url_data, '_blank');
      })
      $('#row_dropdown').on('change', function() {
        var page = "<?= $PAGE ?>";
        window.location.href = "<?= base_url('reports/bir_1601_c?page=') ?>" + page + '&row=' + $(this).val();
      })


    })
  })(jQuery);
</script>