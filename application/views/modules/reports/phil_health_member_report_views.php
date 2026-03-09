<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="<?php echo base_url() ?>/assets_system/css/handsontable14.css" />
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title"><a href="<?= base_url('reports/goverment_forms'); ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Phil Health Member Report<h1>
            </div>
        </div>
        <div class="col-12 col-lg-3 my-3">
            <div class="input-group mb-3">
                <!--<div class="input-group-prepend">-->
                <!--  <label class="input-group-text" for="inputGroupSelect01">Month</label>-->
                <!--</div>-->
                <select class="custom-select" id="form-month">
                    <?php foreach ($MONTHS as $key => $value) { ?>
                        <option value="<?= str_pad($key, 2, "0", STR_PAD_LEFT) ?>"><?= $value ?></option>
                    <?php } ?>
                </select>
                <select class="custom-select" id="form-year">
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
            <div class="card-header">
                <button class="generate_pdfs btn btn-primary d-block ml-auto">Generate PDFs</button>
            </div>
            <!-- <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">EMPLOYEE ID</th>
                            <th scope="col">NAME</th>
                            <th scope="col" class="text-center">SSS ID</th>
                            <th scope="col" class="text-center">TIN NUMBER</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($EMPLOYEES) {
                            foreach ($EMPLOYEES as $employee) { ?>
                                <tr>
                                    <td scope="row"><?= $employee->col_empl_cmid ?></td>
                                    <td><?= $employee->formated_fullname ?></td>
                                    <td><?= $employee->col_empl_sssc ?></td>
                                    <td><?= $employee->col_empl_btin ?></td>
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
        </div>

    </div>
</div>
<?php $this->load->view('templates/jquery_link'); ?>
<script type="text/javascript" src="<?php echo base_url() ?>/assets_system/js/handsontable14.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script> -->
<script src="<?= base_url('assets_system/js'); ?>/pdf-lib.min.js"></script>

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
        colHeaders: ['ID', 'Employee ID', 'Employee Name', 'SSS ID', 'Tin Number'],
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
            data: 'formated_fullname',
            readOnly: true
        },
        {
            data: 'col_empl_sssc',
            readOnly: true
        },
        {
            data: 'col_empl_btin',
            readOnly: true
        },
        ],

    });

    hot.updateSettings({
        height: window.innerHeight - container.getBoundingClientRect().top - 50,
    });
</script>


<script>
    $(document).ready(function() {
        function writeText(page, text, x, y, size = 12) {
            if (!text) {
                text = '';
            }
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
            if (!text) {
                text = '';
            }
            for (let char of text) {
                writeText(page, char, x, y, size);
                if (char.length > 1) {
                    x += (char.length * 10) + steps
                    continue
                }
                x += steps;
            }
        }
        async function getEmployeesData() {
            const data = await $.post("<?= base_url('reports/get_all_employee_info') ?>", {
                'res': 1
            }, function(res) {

                return res
            }, 'json');
            return data;
        }

        function annotatePhilHealth(page, data, employer) {
            let employers_name = employer['name'];
            let employers_address = employer['address'];
            let zip_code = employer['zip_code'];
            let employers_mobile = employer['mobile_number'];
            let employers_tel_num = employer['telephone'];
            let employers_email = employer['email'];
            let employers_tin = employer['tin'];
            let employer_id_num = employer['sss_id'];
            let quater_end = '112023';
            writeText(page, employer_id_num, 655, 510)
            writeText(page, employers_address, 95, 496, 10)
            writeText(page, employers_email, 525, 496)
            let employees = {
                sss_num: '3264123479',
                name: 'Steph Curry Smith Jr',
                date_birth: '01211999',
                date_hire: '02-24-2022',
                date_sep: '10102023',
                monthly_com: '20000.00',
                position: 'Web developer'
            }
            let text_y = 435;
            for (let employee of data) {
                let sss = employee.col_empl_sssc ? employee.col_empl_sssc.split('-').join('') : '';
                let fullname = employee.fullname ? employee.fullname : '';
                let position = employee.position ? employee.position : '';
                let birth_date = employee.birth_date && employee.birth_date != '00000000' ? employee.birth_date : '';
                let date_hire = employee.hire_date && employee.hire_date != '00000000' ? employee.hire_date : '';
                let date_sep = employee.sep_date && employee.sep_date != '00000000' ? employee.sep_date : '';
                let monthly_com = employee.salary_rate ? employee.salary_rate + '' : '';
                writeText(page, sss, 45, text_y, 10)
                writeText(page, fullname, 165, text_y, 10)
                writeText(page, position, 315, text_y, 10)
                writeText(page, monthly_com, 435, text_y, 10)
                writeText(page, date_hire, 490, text_y, 10)
                text_y -= 20.08
            }
            writeText(page, data.length + '', 200, 85, 16)
            return page;
        }

        $('button.generate_pdfs').on('click', async function(e) {
            e.preventdefault;
            let information = await getEmployeesData();
            let data = information.employees;
            let employer = information.employers;
            let data_length = data.length;
            let pages_num = 0;
            pages_num = parseInt(data_length / 15);
            if (data_length % 15 > 0) {
                pages_num += 1;
            }
            pages_num -= 1;
            const url = "<?= base_url() ?>assets_system/reports/PHIC_ER2.pdf";
            const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())
            const srcDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
            const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes)

            const pages = pdfDoc.getPages()
            const firstPage = pages[0]
            annotatePhilHealth(firstPage, [...data.slice(0, 15)], employer)
            const {
                width,
                height
            } = firstPage.getSize()
            let data_index = 15;
            for (let i = 0; i <= pages_num; i++) {
                if (i > 0) {
                    let [page1] = await pdfDoc.copyPages(srcDoc, [0]);
                    pdfDoc.addPage(annotatePhilHealth(page1, [...data.slice(data_index, data_index + 15)], employer));
                    data_index += 15;
                    console.log('sss')
                }
            }
            // 
            const pdfBytes = await pdfDoc.save()
            // Convert PDF bytes to a Blob
            const pdfBlob = new Blob([pdfBytes], {
                type: 'application/pdf'
            });

            // Create a temporary URL and open the PDF in a new tab
            const url_data = URL.createObjectURL(pdfBlob);
            window.open(url_data, '_blank');
        })




    })
</script>