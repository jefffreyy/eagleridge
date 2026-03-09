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
        <h1 class="page-title"><a href="<?= base_url('reports/goverment_forms'); ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;BIR 2316<h1>
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
          <?php foreach ($MONTHS as $key => $value) { ?>
            <option value="<?= str_pad($key, 2, "0", STR_PAD_LEFT) ?>"><?= $value ?></option>
          <?php } ?>
        </select>
        <select class="custom-select" id="year">
          <?php for ($i = $YEAR; $i >= $YEAR - 50; $i--) { ?>
            <option value="<?= $i ?>"><?= $i ?></option>
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
          <div class="col-12 col-lg-3 d-flex justify-content-center justify-content-lg-start ml-2">
            <button class="generate_pdfs btn btn-primary m-1" hidden>Generate PDF 1</button>
            <button class="generate_pdfs_handsontable btn btn-primary m-1">Generate PDF</button>
            <button type="button" class=" pdf-print_1 btn btn-primary m-1" id="printButton" hidden><img style="width: 24px; height: 18px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/print-duotone_sm.svg') ?>" alt=""  />&nbsp;Print</button>
            <button type="button" class=" pdf-print btn btn-primary m-1" id="printButton"><img style="width: 24px; height: 18px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/print-duotone_sm.svg') ?>" alt="" />&nbsp;Print</button>
          </div>
          <!-- <button id="btn_application"    class=" btn technos-button-gray shadow-none rounded" data-toggle="modal" data-target="#modal_insert"  ><i class="far fa-trash-alt"></i>&nbsp;Delete</button> -->
          <div class="col-12 col-lg-7 d-none d-lg-flex justify-content-center justify-content-lg-end align-items-center row">
            <div class="col-12 col-lg-7 d-flex justify-content-center justify-content-lg-end py-1">
              <p class="p-0 m-0" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
            </div>
            <div class="col-12 col-lg-3 d-flex justify-content-center justify-content-lg-end ">
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
            <?php if ($EMPLOYEES) { ?>
              <?php foreach ($EMPLOYEES as $employee) { ?>
                <tr>
                  <td class="text-center"><input data-userId="<?= $employee->id ?>" value="<?= $employee->id ?>" type="checkbox" class="empl_select" /></td>
                  <td scope="row"><?= $employee->col_empl_cmid ?></td>
                  <td><?= $employee->fullname ?></td>
                  <td class="text-center">
                    <a class="pdf-file select_row p-2" data-userId="<?= $employee->id ?>" style="color: gray; cursor: pointer; !important">
                       <img src="<?= base_url('assets_system/icons/eye-solid.svg') ?>" alt=""></a>
                  </td>
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




      <div class="col-12 col-lg-7 d-flex d-lg-none justify-content-center justify-content-lg-end align-items-center row">
        <div class="col-12 col-lg-7 d-flex justify-content-center justify-content-lg-end py-1 my-2">
          <p class="p-0 m-0" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
        </div>
        <div class="col-12 col-lg-3 d-flex justify-content-center justify-content-lg-end ">
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

      <div class="col-12 col-lg-1 d-flex d-lg-none justify-content-center my-2 my-lg-0 align-items-center">
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script> -->
<?php $this->load->view('templates/jquery_link'); ?>
<script type="text/javascript" src="<?php echo base_url() ?>/assets_system/js/handsontable14.js"></script>
<script src="<?= base_url('assets_system/js') ?>/pdf-lib.min.js"></script>



<script>
  (function() {
    $(document).ready(function() {

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
                const url = "<?= base_url('assets_system/forms/form_bir316.pdf') ?>";
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
        let employers = informations.employers;
        const url = "<?= base_url('assets_system/forms/form_bir316.pdf') ?>";
        const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())
        const srcDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
        const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
        const pages = await pdfDoc.getPages();
        const firstPage = pages[0];
        annotatePage(firstPage, data[0], employers)
        let res = await data.forEach(async function(element, index) {
          if (index > 0) {
            let [page1] = await pdfDoc.copyPages(srcDoc, [0]);
            pdfDoc.addPage(annotatePage(page1, element, employers));
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


      $('button.pdf-print').on('click', async function(e) {
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
        let employers = informations.employers;
        const url = "<?= base_url('assets_system/forms/form_bir316.pdf') ?>";
        const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())
        const srcDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
        const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
        const pages = await pdfDoc.getPages();
        const firstPage = pages[0];
        annotatePage(firstPage, data[0], employers)
        let res = await data.forEach(async function(element, index) {
          if (index > 0) {
            let [page1] = await pdfDoc.copyPages(srcDoc, [0]);
            pdfDoc.addPage(annotatePage(page1, element, employers));
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

      function annotatePage(page, data, employers) {
        let today = $('select#month').val() + $('select#year').val();
        let month = '0000';
        let year = $('select#year').val();
        let text_x = 130;
        loopText(page, year, text_x, 830, 14.5)
        loopText(page, month, 393, 830, 14.5)
        loopText(page, month, 520, 830, 14.5)
        // number of sheets
        // loopText(page,'23',450,810,14.5)
        // writeText( firstPage,'2  3',450,345);
        // ATC
        // loopText(page,'2222',540,810,10)
        // Tin number

        let tin = data['col_empl_btin'].split('-').join('').replace(/^(\d{3})(\d{3})(\d{3})(\d{2,5})(\D*)$/, '$1 $2 $3 $4$5').replace(/\-/g, '');
        text_x = 90
        loopText(page, tin, text_x, 800, 12.5)
        // loopText(page,'403',552,780,14.8)
        //  Withholding Agent’s Name
        let fullname = data.fullname;
        let zip = '4422';
        let address = data.col_home_addr;
        let contact_number = data.col_mobl_numb;
        let email = data.col_empl_emai;
        let empl_birt_date = data['birth_date'];
        let compensation = parseInt(data.salary_rate).toFixed(2).split('').reverse().join('');
        let sat_min_wage = parseInt(data.salary_rate);

        sat_min_wage = sat_min_wage.toFixed(2).split('').reverse().join('');

        let text_y = 775;
        writeText(page, fullname, 43, text_y, 9)
        loopText(page, '102', 265, text_y, 14.4, 9)
        writeText(page, address, 43, text_y - 26, 9)
        loopText(page, '1020', 265, text_y -= 26, 12, 9)
        writeText(page, address, 43, text_y - 26, 9)
        loopText(page, '1020', 265, text_y -= 26, 12, 9)

        writeText(page, '', 43, text_y -= 26, 9) //-foreign address
        loopText(page, empl_birt_date, 50, text_y - 26, 12, 9)
        loopText(page, contact_number, 172, text_y -= 26, 12.5, 9)
        loopText(page, sat_min_wage, 300, text_y -= 20, -5, 9)
        loopText(page, sat_min_wage, 300, text_y -= 19, -5, 9)
        // Employer Info
        // employers['tin']='123456789123'
        let emplr_tin = employers['tin'].padEnd(14, '-').replace(/^(\d{3})(\d{3})(\d{3})(\d{2,5})(\D*)$/, '$1 $2 $3 $4$5').replace(/\-/g, '');
        let emplr_name = employers['name'];
        let emplr_address = employers['address'];
        let emplr_zip = employers['zip_code'];
        loopText(page, emplr_tin, 90, text_y -= 40, 12.7, 9)
        writeText(page, emplr_name, 43, text_y -= 30, 9)
        writeText(page, emplr_address, 43, text_y - 25, 9)
        loopText(page, emplr_zip, 265, text_y -= 25, 12, 9)
        text_y = 460;
        // part 4
        /*  Part IVA - Summary
            gross_com_income                - Gross Compensation Income from Present Employer (Sum of Items 38 and 52)
            less_total_none_tax             - Less: Total Non-Taxable/Exempt Compensation Income from Present Employer (From Item 38)
            tax_com_income                  - Taxable Compensation Income from Present Employer (Item 19 Less Item 20) (From Item 52)
            add_tax_com_income_prev_emplr   - Add: Taxable Compensation Income from Previous Employer, if applicable
            gross_tax_income                - Gross Taxable Compensation Income (Sum of Items 21 and 22)
            tax_due                         - Tax Due
            amount_tax_witheld_cur_emplr    - Amount of Taxes Withheld 25A Present Employer
            amount_tax_witheld_prev_emplr   - Amount of Taxes Withheld 25A Previous Employer
            total_amount_tax_witheld_adj    - Total Amount of Taxes Withheld as adjusted
            tax_credit                      - 5% Tax Credit (PERA Act of 2008)
            total_tax_widtheld              - Total Taxes Withheld (Sum of Items 26 and 27)
        */
        /*  NON-TAXABLE/EXEMPT COMPENSATION INCOME
            basic_sal               - Basic Salary (including the exempt P250,000 & below) or the Statutory Minimum Wage of the MWE
            holiday_pay             - Holiday Pay (MWE)
            overtime_pay            - Overtime Pay (MWE)
            night_shift_diff        - Night Shift Differential (MWE)
            hazard_pay              - Hazard Pay (MWE)
            benefits_pay            - 13th Month Pay and Other Benefits (maximum of P90,000)
            de_minimis_benefits     - De Minimis Benefits
            contributions           - SSS, GSIS, PHIC & PAG-IBIG Contributions and Union Dues (Employee share only)
            compensation            - Salaries and Other Forms of Compensation
            total_none_tax          - Total Non-Taxable/Exempt Compensation Income (Sum of Items 29 to 37)

        */
        /* TAXABLE COMPENSATION INCOME REGULAR
            basic_sal_reg           - Basic Salary
            representation          - Representation
            transportation          - Transportation
            cola_alo                - Cost of Living Allowance (COLA)
            fixed_housing_alo       - Fixed Housing Allowance
        */
        /* SUPPLEMENTARY
            commission              - Commission
            profit_sharing          - Profit Sharing
            fees_director           - Fees Including Director's Fees
            tax_13_benefits         - Taxable 13th Month Benefits
            supp_hazard_pay         - Hazard Pay
            supp_overtime_pay       - Overtime Pay
        */
        let gross_com_income = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let less_total_none_tax = parseFloat(300).toFixed(2) ? parseFloat(300).toFixed(2).split('').reverse().join('') : 0.00;
        let tax_com_income = parseFloat(300).toFixed(2) ? parseFloat(300).toFixed(2).split('').reverse().join('') : 0.00;
        let add_tax_com_income_prev_emplr = parseFloat(0).toFixed(2) ? parseFloat(0).toFixed(2).split('').reverse().join('') : 0.00;
        let gross_tax_income = parseFloat(1000).toFixed(2) ? parseFloat(1000).toFixed(2).split('').reverse().join('') : 0.00;
        let tax_due = parseFloat(1000).toFixed(2) ? parseFloat(1000).toFixed(2).split('').reverse().join('') : 0.00;
        let amount_tax_witheld_cur_empl = parseFloat(1000).toFixed(2) ? parseFloat(1000).toFixed(2).split('').reverse().join('') : 0.00;
        let amount_tax_witheld_prev_emplr = parseFloat(1000).toFixed(2) ? parseFloat(1000).toFixed(2).split('').reverse().join('') : 0.00;
        let total_amount_tax_witheld_adj = parseFloat(1000).toFixed(2) ? parseFloat(1000).toFixed(2).split('').reverse().join('') : 0.00;
        let tax_credit = parseFloat(1000).toFixed(2) ? parseFloat(1000).toFixed(2).split('').reverse().join('') : 0.00;
        let total_tax_widtheld = parseFloat(1000).toFixed(2) ? parseFloat(1000).toFixed(2).split('').reverse().join('') : 0.00;
        let part_4a = [less_total_none_tax, tax_com_income, add_tax_com_income_prev_emplr, gross_tax_income,
          tax_due, amount_tax_witheld_cur_empl, amount_tax_witheld_prev_emplr, total_amount_tax_witheld_adj,
          tax_credit, total_tax_widtheld
        ]
        // part_4b_a
        let basic_sal = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let holiday_pay = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let overtime_pay = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let night_shift_diff = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let hazard_pay = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let benefits_pay = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let de_minimis_benefits = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let contributions = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let compensations = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let total_none_tax = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let part_4b_a = [basic_sal, holiday_pay, overtime_pay, night_shift_diff, hazard_pay, benefits_pay, de_minimis_benefits,
          contributions, compensations, total_none_tax
        ]
        // TAXABLE COMPENSATION INCOME REGULAR
        let basic_sal_reg = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let representation = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let transportation = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let cola_alo = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let fixed_housing_alo = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let part_4b_b = [basic_sal_reg, representation, transportation, cola_alo, fixed_housing_alo]
        // 
        let commission = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let profit_sharing = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let fees_director = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let tax_13_benefits = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let supp_hazard_pay = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let supp_overtime_pay = parseFloat(20000).toFixed(2) ? parseFloat(20000).toFixed(2).split('').reverse().join('') : 0.00;
        let part_4_supp = [commission, profit_sharing, fees_director, tax_13_benefits, supp_hazard_pay, supp_overtime_pay]
        // part 4a
        loopText(page, gross_com_income, 300, text_y -= 50, -5, 9);
        for (let amount of part_4a) {
          loopText(page, amount, 300, text_y -= 19.13, -5, 9)
        }
        text_y = 782;
        for (let amount of part_4b_a) {
          loopText(page, amount, 575, text_y, -5, 9)
          text_y -= 19.13;
        }
        // end part 4 a
        text_y = 570;

        for (let amount of part_4b_b) {
          loopText(page, amount, 575, text_y, -5, 9)
          text_y -= 19.13;
        }
        text_y = 420;

        for (let amount of part_4_supp) {
          loopText(page, amount, 575, text_y, -5, 9)
          text_y -= 19.13;
        }
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
        let employers = informations.employers;
        const url = "<?= base_url('assets_system/forms/form_bir316.pdf') ?>";
        const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())
        const srcDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
        const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
        const pages = await pdfDoc.getPages();
        const firstPage = pages[0];
        annotatePage(firstPage, data[0], employers)
        let res = await data.forEach(async function(element, index) {
          if (index > 0) {
            let [page1] = await pdfDoc.copyPages(srcDoc, [0]);
            pdfDoc.addPage(annotatePage(page1, element, employers));
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


      $('button.pdf-print_1').on('click', async function(e) {
        let ids = await $('.empl_select:checked').map(function() {
          return this.value;
        }).get();
        if (ids.length <= 0) {
          alert('Please Select Employees');
          return;
        }
        let informations = await getEmployeesData(ids);
        let data = informations.employees;
        let employers = informations.employers;
        const url = "<?= base_url('assets_system/forms/form_bir316.pdf') ?>";
        const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())
        const srcDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
        const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
        const pages = await pdfDoc.getPages();
        const firstPage = pages[0];
        annotatePage(firstPage, data[0], employers)
        let res = await data.forEach(async function(element, index) {
          if (index > 0) {
            let [page1] = await pdfDoc.copyPages(srcDoc, [0]);
            pdfDoc.addPage(annotatePage(page1, element, employers));
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
        let employers = information.employers;
        const url = "<?= base_url('assets_system/forms/form_bir316.pdf') ?>";
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
      })
      $('#row_dropdown').on('change', function() {
        var page = "<?= $PAGE ?>";
        window.location.href = "<?= base_url('reports/bir_2316?page=') ?>" + page + '&row=' + $(this).val();
      })


    })


  })(jQuery);


</script>
