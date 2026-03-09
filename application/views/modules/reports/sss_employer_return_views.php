<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="<?php echo base_url() ?>/assets_system/css/handsontable14.css" />
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title"><a href="<?= base_url('reports/goverment_forms'); ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;SSS Form R-5: Employer Contributions Payment Return<h1>
            </div>
        </div>
        <div class=" py-3 w-25">
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

        function annotateSSS(page, data, employers) {
            let employers_id = employers['sss_id']
            let employers_name = employers['name'];
            let employers_address = employers['address'];
            let zip_code = employers['zip_code'];
            let employers_mobile = employers['mobile_number'];
            let employers_tel_num = employers['telephone'];
            let employers_email = employers['email'];
            let employers_tin = employers['tin'];
            let website = employers['web_site'];
            loopText(page, employers_id, 20, 480, 12)
            writeText(page, employers_name, 180, 480)
            loopText(page, employers_address.split('/'), 80, 462, 10)
            loopText(page, zip_code, 875, 463, 12)
            loopText(page, employers_mobile, 140, 426, 12)
            loopText(page, employers_tel_num, 20, 426, 12)
            writeText(page, website, 465, 426, 12)
            writeText(page, employers_email, 280, 426)
            loopText(page, employers_tin, 782, 427, 12, 10)
            // 
            let employees = {
                sss_num: '3241234679',
                name: 'Steph Curry Smith Jr',
                date_birth: '01211999',
                date_hire: '02242022',
                date_sep: '10102023',
                monthly_com: '20000.00',
                position: 'Web developer'
            }
            let y = 390;
            for (let employee of data) {
                let sss = employee.col_empl_sssc ? employee.col_empl_sssc.split('-').join('') : '';
                let fullname = employee.fullname ? employee.fullname : '';
                let position = employee.position ? employee.position : '';
                let birth_date = employee.birth_date && employee.birth_date != '00000000' ? employee.birth_date : '';
                let date_hire = employee.date_hire && employee.date_hire != '00000000' ? employee.date_hire : '';
                let date_sep = employee.sep_date && employee.sep_date != '00000000' ? employee.sep_date : '';
                let monthly_com = employee.salary_rate ? employee.salary_rate + '' : '';
                loopText(page, sss, 20, y, 12.2)
                writeText(page, fullname, 150, y)
                loopText(page, birth_date, 392, y, 12.2)
                loopText(page, date_hire, 487, y, 12.2)
                loopText(page, date_sep, 582, y, 12.2)
                writeText(page, monthly_com, 690, y)
                writeText(page, position, 750, y, 11)
                y -= 16.4;
            }
            return page;
        }
        $('button.generate_pdfs').on('click', async function(e) {
            let information = await getEmployeesData();
            let employer = information.employers;
            let data = information.employees;
            let data_length = data.length;
            let pages_num = 0;
            pages_num = parseInt(data_length / 15);
            if (data_length % 15 > 0) {
                pages_num += 1;
            }
            pages_num -= 1;
            // console.log([...data.slice(15)]);
            // console.log(employer);
            // return;
            const url = "<?= base_url() ?>assets_system/reports/SSS_R-1a.pdf";
            const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())
            const srcDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
            const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
            const pages = pdfDoc.getPages()
            const firstPage = pages[0]
            annotateSSS(firstPage, [...data.slice(0, 15)], employer)
            const {
                width,
                height
            } = firstPage.getSize()
            let data_index = 15;
            for (let i = 0; i <= pages_num; i++) {
                if (i > 0) {
                    let [page1] = await pdfDoc.copyPages(srcDoc, [0]);
                    pdfDoc.addPage(annotateSSS(page1, [...data.slice(data_index, data_index + 15)], employer));
                    data_index += 15;
                }
            }

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