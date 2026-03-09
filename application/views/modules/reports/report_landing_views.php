<html>
<?php $this->load->view('templates/css_link'); ?>


<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title">Reports<h1>
      </div>
    </div>
    <hr>

    <div class="row pt-1 justify-content-md-center">
      <div class="col-md-8">
        <h1 class="page-title">Employee Information Reports<h1>
            <div class="card border-0 py-1 mt-3">
              <div class="table-responsive" style="max-height: 75vh">
                <table class="table table-bordered table-hover m-0" id="TableToExport">
                  <thead style="position: sticky; top: 0;">
                    <tr>
                      <th class="text-left" style="min-width: 300px !important">Report Title</th>
                      <th class="text-left" style="min-width: 150px !important">Frequency</th>
                    </tr>
                  </thead>

                  <tbody>
                  <tr>
                    <td><a href="<?= base_url() . 'reports/active_employees' ?>">Active Employees</a></td>
                      <td>Monthly/Quarterly/Annual</td>
                    </tr>

                    <tr>
                      <td><a href="<?= base_url() . 'reports/promoted_employees' ?>">Promoted Employees</a></td>
                      <td>Monthly/Quarterly/Annual</td>
                    </tr>
                   
                      <tr>
                        <td><a href="<?= base_url() . 'reports/new_employees' ?>">Newly Hired Employees</a></td>
                        <td>Monthly/Quarterly/Annual</td>
                      </tr>
                    

                    <tr>
                      <td><a href="<?= base_url() . 'reports/probationary_employees' ?>">Probationary Employees</a></td>
                      <td>Monthly/Quarterly/Annual</td>

                    </tr>

                    <tr>
                      <td><a href="<?= base_url() . 'reports/contractual_employees' ?>">Contractual Employees</a></td>
                      <td>Monthly/Quarterly/Annual</td>

                    </tr>

                    <tr>
                      <td><a href="<?= base_url() . 'reports/resigned_employees' ?>">Resigned Employees</a></td>
                      <td>Monthly/Quarterly/Annual</td>

                    </tr>
                  </tbody>
                </table>
              </div>

            </div>
      </div>
    </div>

    <div class="row pt-1 justify-content-md-center">
      <div class="col-md-8">
          
        <h1 class="page-title">Timekeeping/Attendance Reports<h1>
            <div class="card border-0 p-1 mt-3">
              <div class="table-responsive" style="max-height: 75vh">
                <table class="table table-hover m-0" id="TableToExport">
                  <thead style="position: sticky; top: 0;">
                    <tr>
                      <th class="text-left" style="min-width: 300px !important">Report Title</th>
                      <th class="text-left" style="min-width: 150px !important">Frequency</th>
                    </tr>
                  </thead>
                  <tbody id="tbl_application_container">
                    <tr>
                      <td><a href="<?= base_url() . 'reports/leaves' ?>">Approved Leaves</a></td>
                      <td>Monthly/Quarterly/Annual</td>

                    </tr>

                    <tr>
                      <td><a href="<?= base_url() . 'reports/overtimes' ?>">Approved Overtime</a></td>
                      <td>Monthly/Quarterly/Annual</td>

                    </tr>

                    <tr>
                      <td><a href="<?= base_url() . 'reports/time_adjustments' ?>">Approved Time Adjustments</a></td>
                      <td>Monthly/Quarterly/Annual</td>

                    </tr>

                    <tr>
                      <td><a href="<?= base_url() . 'reports/holiday_works' ?>">Approved Holiday Work</a></td>
                      <td>Monthly/Quarterly/Annual</td>

                    </tr>

                    <tr>
                      <td><a href="<?= base_url() . 'reports/tardiness' ?>">Tardiness</a></td>
                      <td>Monthly/Quarterly/Annual</td>

                    </tr>

                    <tr>
                      <td><a href="<?= base_url() . 'reports/undertime' ?>">Undertime</a></td>
                      <td>Monthly/Quarterly/Annual</td>

                    </tr>

                    <tr>
                      <td><a href="<?= base_url() . 'reports/sliders' ?>">Sliders</a></td>
                      <td>Monthly/Quarterly/Annual</td>

                    </tr>

                    <tr>
                      <td><a href="<?= base_url() . 'reports/awol' ?>">AWOL</a></td>
                      <td>Monthly/Quarterly/Annual</td>

                    </tr>
                  </tbody>
                </table>
              </div>

            </div>
      </div>
    </div>
    <div class="row pt-1 justify-content-md-center">
      <div class="col-md-8">
          
        <h1 class="page-title">Report Generation<h1>
            <div class="card border-0 p-1 mt-3">
              <div class="table-responsive" style="max-height: 75vh">
                <table class="table table-hover m-0" id="TableToExport">
                  <thead style="position: sticky; top: 0;">
                    <tr>
                      <th class="text-left" style="min-width: 300px !important">Report Title</th>
                      <th class="text-left" style="min-width: 150px !important">Frequency</th>
                    </tr>
                  </thead>
                  <tbody id="tbl_application_container">
                    <tr>
                        <td>
                            <a href="<?= site_url('reports/payslips_loan_deductions')?>">Payslips: Cutoff / Loans and Deductions</a>
                        </td>
                        <td>Cut-off Period</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="<?= site_url('reports/payslip_benifits')?>">Payslips: Cutoff SSS Pagibig Philhealth</a>
                        </td>
                        <td>Cut-off Period</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="<?= site_url('reports/payslip_remittances')?>">Payslips: Cutoff Remittance</a>
                        </td>
                        <td>Cut-off Period</td>
                    </tr>
                  </tbody>
                </table>
              </div>

            </div>
      </div>
    </div>
    <div class="row pt-1 justify-content-md-center">
      <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="page-title">Government Remittance Forms<h1>
                <a class="btn btn-primary" href="<?=site_url('reports/form_settings')?>"><img style="width: 16px; height: 16px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/gear-solid_xs.svg') ?>" alt="" /> Settings</a>      
            </div>
        
            <div class="card border-0 p-1 mt-3">
              <div class="table-responsive" style="max-height: 75vh">
                <table class="table table-hover m-0" id="TableToExport">
                  <thead style="position: sticky; top: 0;">
                    <tr>
                      <th class="text-left" style="min-width: 300px !important">Report Title</th>
                      <th class="text-left" style="min-width: 150px !important">Frequency</th>
                    </tr>
                  </thead>
                  <tbody id="tbl_application_container">
                    <tr>
                      <td><a  href="<?=site_url('reports/bir_2316')?>"  class="pdf-file text-primary">BIR 2316</a></td>
                      <td>Monthly</td>
                    </tr>
                    <tr>
                      <td><a  href="<?=site_url('reports/bir_1601_c')?>"  class="pdf-file text-primary">BIR 1601-C: Monthly Remittance Return of Income Taxes Withheld on Compensation</a></td>
                      <td>Monthly</td>
                    </tr>

                    <tr>
                      <td><a href="<?=site_url('reports/bir_alpha_list')?>" class="pdf-file text-primary">BIR Alphalist</a></td>
                      <td>Annually</td>
                    </tr>

                    <tr>
                      <td><a href="<?=site_url('reports/bir_alpha_list_dat')?>" class="pdf-file text-primary" >BIR Alphalist DAT File</a></td>
                      <td>Annually</td>
                    </tr>

                    <tr>
                      <td><a href="<?=site_url('reports/sss_employees_report')?>" class=" text-primary ">SSS Form R-1a: Employment Report</a></td>
                      <td>Monthly</td>
                    </tr>

                    <tr>
                      <td><a  href="<?=site_url('reports/sss_collection_lists')?>" class="pdf-sssr_file text-primary">SSS Form R-3: Contribution Collection List</a></td>
                      <td>Monthly</td>
                    </tr>

                    <tr>
                      <td><a href="<?=site_url('reports/sss_employer_return')?>"  class="pdf-sss_file text-primary">SSS Form R-5: Employer Contributions Payment Return</a></td>
                      <td>Monthly</td>

                    </tr>

                    <tr>
                      <td><a href="<?= base_url() ?>assets_system/reports/PHIC_RF1.xlsx" target="_blank">PhilHealth RF-1: Remittance Report</a></td>
                      <td>Monthly</td>

                    </tr>

                    <tr>
                      <td><a href="<?= base_url() ?>assets_system/reports/PHIC_RF1.xlsx" target="_blank">PhilHealth RF-1: Remittance Report (XLS)</a></td>
                      <td>Monthly</td>

                    </tr>

                    <tr>
                      <td><a href="<?=site_url('reports/phil_health_member_report')?>" class="pdf-phic text-primary" >PhilHealth Er2: Employee-Members Report</a></td>
                      <td>Monthly</td>

                    </tr>

                    <tr>
                      <td><a href="<?=site_url('reports/pag_ibig_contribution_remitance')?>" class="pdf-sss_file text-primary">Pag-ibig FPF060: Membership Contributions Remittance Form (MCRF)</a></td>
                      <td>Monthly</td>
                    </tr>


                  </tbody>
                </table>
              </div>

            </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.7/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
<script>
    $(document).ready(function(){
        function writeText(page,text,x,y,size=12){
            if(!text){
                text='';
            }
          page.drawText(text, {
            x: x,
            y: y,
            size: size,
            font: PDFLib.helveticaFont,
            color: PDFLib.rgb(0, 0, 0),
            align:'center'
          })
        }
        function loopText(page,text,x,y,steps,size=12){
            if(!text){
                text='';
            }
            for(let char of text){
                writeText(page,char,x,y,size);
                if(char.length>1){  
                    x+=(char.length*10)+steps
                    continue
                }
                x+=steps;
            }
        }
        async function getEmployeesData(){
            const data= await $.post("<?=base_url('reports/get_all_employee_info')?>",{'res':1},function(res){
                
                return res
            },'json');
            return data;
        }
        function annotateSSS(page,data,employers){
            let employers_id        = employers['sss_id']
            let employers_name      = employers['name'];
            let employers_address   = employers['address'];
            let zip_code            = employers['zip_code'];
            let employers_mobile    = employers['mobile_number'];
            let employers_tel_num   = employers['telephone'];
            let employers_email     = employers['email'];
            let employers_tin       = employers['tin'];
            let website             = employers['web_site'];
            loopText(page,employers_id,20,480,12)
            writeText(page,employers_name,180,480)
            loopText(page,employers_address.split('/'),80,462,10)
            loopText(page,zip_code,875,463,12)
            loopText(page,employers_mobile,140,426,12)
            loopText(page,employers_tel_num,20,426,12)
            writeText(page,website,465,426,12)
            writeText(page,employers_email,280,426)
            loopText(page,employers_tin,782,427,12,10)
            // 
            let employees={sss_num:'3241234679',name:'Steph Curry Smith Jr',date_birth:'01211999',date_hire:'02242022',date_sep:'10102023',monthly_com:'20000.00',position:'Web developer'}
            let y=390;
            for (let employee of data) {
                let sss         = employee.col_empl_sssc?employee.col_empl_sssc.split('-').join(''):'';
                let fullname    = employee.fullname?employee.fullname:'';
                let position    = employee.position?employee.position:'';
                let birth_date  = employee.birth_date && employee.birth_date!='00000000'  ? employee.birth_date : '';
                let date_hire   = employee.date_hire && employee.date_hire!='00000000'  ? employee.date_hire : '';
                let date_sep    = employee.sep_date && employee.sep_date!='00000000'  ? employee.sep_date : '';
                let monthly_com = employee.salary_rate?employee.salary_rate+'':'';
                loopText(page,sss,20,y,12.2)
                writeText(page,fullname,150,y)
                loopText(page,birth_date,392,y,12.2)
                loopText(page,date_hire,487,y,12.2)
                loopText(page,date_sep,582,y,12.2)
                writeText(page,monthly_com,690,y)
                writeText(page,position,750,y,11)
                y-=16.4;
            }
            return page;
        }
        $('a.pdf-sss_file').on('click',async function(e){
            let information         = await getEmployeesData();
            let employer            = information.employers;
            let data                = information.employees;
            let data_length         = data.length;
            let pages_num           = 0;
            pages_num               = parseInt(data_length/15);
            if(data_length%15>0){
                pages_num+=1;
            }
            pages_num-=1;
            // console.log([...data.slice(15)]);
            // console.log(employer);
            // return;
            const url               = $(this).data('file');
            const existingPdfBytes  = await fetch(url).then(res => res.arrayBuffer())
            const srcDoc            = await PDFLib.PDFDocument.load(existingPdfBytes)
            const pdfDoc            = await PDFLib.PDFDocument.load(existingPdfBytes)
            const pages             = pdfDoc.getPages()
            const firstPage         = pages[0]
            annotateSSS(firstPage,[...data.slice(0,15)],employer)
            const { width, height } = firstPage.getSize()
            let data_index          = 15;
            for(let i=0;i<=pages_num;i++){
                if(i>0){
                    let [page1] = await pdfDoc.copyPages(srcDoc,[0]);
                    pdfDoc.addPage(annotateSSS(page1,[...data.slice(data_index,data_index+15)],employer));
                    data_index+=15;
                }
            }
            
            const pdfBytes = await pdfDoc.save()
            // Convert PDF bytes to a Blob
            const pdfBlob = new Blob([pdfBytes], { type: 'application/pdf' });
    
            // Create a temporary URL and open the PDF in a new tab
            const url_data= URL.createObjectURL(pdfBlob);
            window.open(url_data, '_blank');
            
        })
        
        function addNewPage(doc,page){
            doc.addPage(page);
            return doc
        }
        function annotatePage(page,data,employer){
            let employers_name      = employer['name'];
            let employers_address   = employer['address'];
            let zip_code            = employer['zip_code'];
            let employers_mobile    = employer['mobile_number'];
            let employers_tel_num   = employer['telephone'];
            let employers_email     = employer['email'];
            let employers_tin       = employer['tin'];
            let employer_id_num     = employer['sss_id'];
            let quater_end          = $('select#form-month').val()+$('select#form-year').val();
            loopText(page,employer_id_num,45,497,11.4)
            writeText(page,employers_name,200,497)
            loopText(page,quater_end,696,497,11.4)
            writeText(page,employers_address,200,470,11)
            writeText(page,employers_tel_num,50,470,11)
            //
            let y=414;
            let employees={sss_num:'3264123479',name:'Steph Curry Smith Jr',date_birth:'01211999',date_hire:'02242022',date_sep:'10102023',monthly_com:'20000.00',position:'Web developer'}
            for (let employee of data) {
                let sss         = employee.col_empl_sssc?employee.col_empl_sssc.split('-').join(''):'';
                let fullname    = employee.fullname?employee.fullname:'';
                let lastname    = employee.col_last_name?employee.col_last_name:'';
                let firstname   = employee.col_frst_name?employee.col_frst_name:'';
                let midlename   = employee.col_midl_name?employee.col_midl_name+'.':'';
                let position    = employee.position?employee.position:'';
                let birth_date  = employee.birth_date && employee.birth_date!='00000000'  ? employee.birth_date : '';
                let date_hire   = employee.date_hire && employee.date_hire!='00000000'  ? employee.date_hire : '';
                let date_sep    = employee.sep_date && employee.sep_date!='00000000'  ? employee.sep_date : '';
                let monthly_com = employee.salary_rate?employee.salary_rate+'':'';
                loopText(page,sss,45,y,11.3,10)
                writeText(page,lastname,165,y,10)
                writeText(page,firstname,(lastname.length*10)+150,y,10)
                writeText(page,midlename,350,y,10)
                loopText(page,'429',435,y,-12.5,10)
                loopText(page,'08000',500,y,-12.5,10)
                loopText(page,'05000',560,y,-12.5,10)
                loopText(page,date_sep,675,y,11.3,10)
                
                y-=16.4;
            }

            
            return page
        }
        $('a.pdf-sssr_file').on('click',async function(e){
            e.preventdefault;
            let information         = await getEmployeesData();
            let data                = information.employees;
            let employer            = information.employers;
            let data_length         = data.length;
            let pages_num           = 0;
            pages_num               = parseInt(data_length/15);
            if(data_length%15>0){
                pages_num+=1;
            }
            pages_num-=1;
            
            const url = $(this).data('file');
            const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())
            const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
            const srcDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
            const pages     = pdfDoc.getPages()
            const firstPage = pages[0]
            annotatePage(firstPage,[...data.slice(0,15)],employer)
            const { width, height } = firstPage.getSize()
            let data_index          = 15;
            for(let i=0;i<=pages_num;i++){
                if(i>0){
                    let [page1,page2] = await pdfDoc.copyPages(srcDoc,[0,1]);
                    pdfDoc.addPage(annotatePage(page1,[...data.slice(data_index,data_index+15)],employer));
                    pdfDoc.addPage(page2)
                    data_index+=15;
                    console.log('sss')
                }
            }
            // pdfDoc.addPage(page1)
            // pdfDoc.addPage(page2)
            // pdfDoc.addPage(page1)
            // pdfDoc.addPage(page2)
            // doc_pages=pdfDoc.getPages();
            // annotatePage(doc_pages[0])
            // annotatePage(doc_pages[2])
            // annotatePage(doc_pages[4])
            const pdfBytes = await pdfDoc.save()
            const pdfBlob = new Blob([pdfBytes], { type: 'application/pdf' });
            // Create a temporary URL and open the PDF in a new tab
            const url_data= URL.createObjectURL(pdfBlob);
            window.open(url_data, '_blank');
        })
        function annotatePhilHealth(page,data,employer){
            let employers_name      = employer['name'];
            let employers_address   = employer['address'];
            let zip_code            = employer['zip_code'];
            let employers_mobile    = employer['mobile_number'];
            let employers_tel_num   = employer['telephone'];
            let employers_email     = employer['email'];
            let employers_tin       = employer['tin'];
            let employer_id_num     = employer['sss_id'];
            let quater_end          = '112023';
            writeText(page,employer_id_num,655,510)
            writeText(page,employers_address,95,496,10)
            writeText(page,employers_email,525,496)
            let employees={sss_num:'3264123479',name:'Steph Curry Smith Jr',date_birth:'01211999',date_hire:'02-24-2022',date_sep:'10102023',monthly_com:'20000.00',position:'Web developer'}
            let text_y=435;
            for(let employee of data){
                let sss         = employee.col_empl_sssc?employee.col_empl_sssc.split('-').join(''):'';
                let fullname    = employee.fullname?employee.fullname:'';
                let position    = employee.position?employee.position:'';
                let birth_date  = employee.birth_date && employee.birth_date!='00000000'  ? employee.birth_date : '';
                let date_hire   = employee.hire_date && employee.hire_date!='00000000'  ? employee.hire_date : '';
                let date_sep    = employee.sep_date && employee.sep_date!='00000000'  ? employee.sep_date : '';
                let monthly_com = employee.salary_rate?employee.salary_rate+'':'';
                writeText(page,sss,45,text_y,10)
                writeText(page,fullname,165,text_y,10)
                writeText(page,position,315,text_y,10)
                writeText(page,monthly_com,435,text_y,10)
                writeText(page,date_hire,490,text_y,10)
                text_y-=20.08
            }
            writeText(page,data.length+'',200,85,16)
            return page;
        }
        
        $('a.pdf-phic').on('click',async function(e){
            e.preventdefault;
            let information         = await getEmployeesData();
            let data                = information.employees;
            let employer            = information.employers;
            let data_length         = data.length;
            let pages_num           = 0;
            pages_num               = parseInt(data_length/15);
            if(data_length%15>0){
                pages_num+=1;
            }
            pages_num-=1;
            const url = $(this).data('file');
            const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())
            const srcDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
            const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
            
            const pages             = pdfDoc.getPages()
            const firstPage         = pages[0]
            annotatePhilHealth(firstPage,[...data.slice(0,15)],employer)
            const { width, height } = firstPage.getSize()
            let data_index          = 15;
            for(let i=0;i<=pages_num;i++){
                if(i>0){
                    let [page1] = await pdfDoc.copyPages(srcDoc,[0]);
                    pdfDoc.addPage(annotatePhilHealth(page1,[...data.slice(data_index,data_index+15)],employer));
                    data_index+=15;
                    console.log('sss')
                }
            }
            // 
            const pdfBytes = await pdfDoc.save()
            // Convert PDF bytes to a Blob
            const pdfBlob = new Blob([pdfBytes], { type: 'application/pdf' });
    
            // Create a temporary URL and open the PDF in a new tab
            const url_data= URL.createObjectURL(pdfBlob);
            window.open(url_data, '_blank');
        })
        $('a.pdf-file').on('click',async function(e){
            e.preventdefault;
        const url = $(this).data('file');
        const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())
        const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes)
        const helveticaFont = await pdfDoc.embedFont(PDFLib.StandardFonts.Helvetica)
    
        const pages = pdfDoc.getPages()
        const firstPage = pages[0]
        const { width, height } = firstPage.getSize()
        // Today Date
        let today="<?=date('mY')?>";
        let text_x=49;
        loopText(firstPage,today,text_x,810,14.5)
        // number of sheets
        loopText(firstPage,'23',450,810,14.5)
        // writeText( firstPage,'2  3',450,345);
        // ATC
        loopText(firstPage,'2222',540,810,10)
        // writeText( firstPage,'2222',540,345);
        // Tin number
        let tin="000 123 456 89123"
        text_x=235.6
        loopText(firstPage,tin,text_x,780,14.3)
        loopText(firstPage,'403',552,780,14.8)
        //  Withholding Agent’s Name
        let fullname='Doe John Smith';
        let zip     = '4422';
       
        // Address
        let address         ='L.Pan St. Goa Camarines Sur';
        let contact_number  ='09123456789';
        let email           ='johndoe@gmail.com';
        let compensation    = 3000000.123456.toFixed(2).split('').reverse().join('');
        let sat_min_wage    = 2000000.123456.toFixed(2).split('').reverse().join('');
        
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
        
        let excess_pay              = 45328.345363.toFixed(2).split('').reverse().join('');
        let benefits_pay            = 628.345363.toFixed(2).split('').reverse().join('');
        let demin_benefits          = 422.345645.toFixed(2).split('').reverse().join('');
        let mando_contribution      = 5234.23.toFixed(2).split('').reverse().join('');
        let other_non_tax           = 400.2345.toFixed(2).split('').reverse().join('');
        let total_non_tax_com       = 470.34.toFixed(2).split('').reverse().join('');
        let total_tax_com           = 4320.34.toFixed(2).split('').reverse().join('');
        let less_tax_com_witholding = 350.33.toFixed(2).split('').reverse().join('');
        let net_tax_com             = 550.33.toFixed(2).split('').reverse().join('');
        let total_tax_witheld       = 650.33.toFixed(2).split('').reverse().join('');
        let tax_adj_widtheld        = 550.32.toFixed(2).split('').reverse().join('');
        let tax_widtheld_remittance = 2123.00.toFixed(2).split('').reverse().join('');
        let less_tax_remittance     = 3429.00.toFixed(2).split('').reverse().join('');
        let other_remittance        = 1429.00.toFixed(2).split('').reverse().join('');
        let total_tax_remittance    = 6429.00.toFixed(2).split('').reverse().join('');
        let tax_due                 = 8329.00.toFixed(2).split('').reverse().join('');
        let penalty_surcharge       = 1329.00.toFixed(2).split('').reverse().join('');
        let penalty_interest        = 2329.00.toFixed(2).split('').reverse().join('');
        let penalty_compromise      = 4329.00.toFixed(2).split('').reverse().join('');
        let total_penalties         = 8329.00.toFixed(2).split('').reverse().join('');
        let total_amount_due        = 8529.00.toFixed(2).split('').reverse().join('');
        
        
        let text_y=753.5;
        loopText(firstPage,fullname,20.3,text_y,14.4)
        loopText(firstPage,address,20,text_y-26,14.4)
        loopText(firstPage,zip,540,text_y-=40,14.4)
        loopText(firstPage,contact_number,108,text_y-=20,14.4)
        loopText(firstPage,email,108,text_y-=17,14.4)
        text_y=628;
        // part 2 
        let part3_data              = [ sat_min_wage,excess_pay,benefits_pay,demin_benefits,mando_contribution,
                                                other_non_tax,total_non_tax_com,total_tax_com,
                                                less_tax_com_witholding,net_tax_com,total_tax_witheld,
                                                tax_adj_widtheld,tax_widtheld_remittance,less_tax_remittance,
                                                other_remittance,total_tax_remittance,tax_due,penalty_surcharge,
                                                penalty_interest,penalty_compromise,total_penalties,total_amount_due
                                                ];
        loopText(firstPage,compensation,583.2,text_y,-14.4)                                        
        loopText(firstPage,sat_min_wage,583.2,text_y-=26,-14.4)
        for(let text of part3_data){
            loopText(firstPage,text,583.2,text_y,-14.4);
            text_y-=16;
        }
        //part 3
        /**
        debit_memo  - Cash/Bank Debit Memo
        check       - Check    
        */
        
        let debit_memo={agency:'PNBKB',number:'123456',date:'02022022',amount:'1234567'}
        let check={agency:'PNB',number:'234567',date:'02022022',amount:'1'}
        loopText(firstPage,debit_memo.agency,120,135,14.4)
        loopText(firstPage,debit_memo.number,194,135,14.4)
        loopText(firstPage,debit_memo.date,280,135,14.4)
        loopText(firstPage,debit_memo.amount,538,135,-14.4)
        const pdfBytes = await pdfDoc.save()
        // Convert PDF bytes to a Blob
        const pdfBlob = new Blob([pdfBytes], { type: 'application/pdf' });

        // Create a temporary URL and open the PDF in a new tab
        const url_data= URL.createObjectURL(pdfBlob);
        window.open(url_data, '_blank');
        })
        function jspdf_writeText(doc,text,x,y,size=12){
            doc.setFontSize(size);
            doc.text( x, y,text,{align:'left'});
        }
        
        function loop_jspdf_text(doc,text,x,y,steps,size=12){
            console.log('from spdf: '+y);
            for(char of text){
                jspdf_writeText(doc,char,x,y,size)
                x+=steps;
            }
        }
        $('a.pdf-file').on('click',function(){
            const imageURL = $(this).data('file');
            fetch(imageURL)
              .then(response => response.blob())
              .then(blob => {
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                var base64img_data = reader.result;
                 // Create a new jsPDF instance
                const doc = new jsPDF("p", "mm", "a4");
                // Load an image URL or base64 data
                
                var width = doc.internal.pageSize.width;
                var height = doc.internal.pageSize.height;
                // Add image to the PDF
                doc.addImage(base64img_data, 'JPEG', 0, 0, width, height);
                loop_jspdf_text(doc,'122023',16,40,5)
                loop_jspdf_text(doc,'23',155,40,5)
                jspdf_writeText(doc,'2322',184,40)
                // part 1
                let tin_num         = '234 547 584 75637';
                let rdo_num         = '234';
                let employee_name   = 'Doe John Smith Jr';
                let registered_add  = 'New Address St. Manila';
                let zip_code        = '1122';
                let contact_num     = '09123647584';
                let email_add       = 'test@email.com';
                loop_jspdf_text(doc,tin_num,81.5,49.5,4.9)
                loop_jspdf_text(doc,rdo_num,189.8,49.5,4.9)
                loop_jspdf_text(doc,employee_name,8,58,4.9)
                loop_jspdf_text(doc,registered_add.substr(0, 40),8,66.5,4.9)
                loop_jspdf_text(doc,registered_add.substr(41),8,71.5,4.9)
                loop_jspdf_text(doc,registered_add.substr(41),8,71.2,4.9)
                loop_jspdf_text(doc,zip_code,185,71.5,4.9)
                loop_jspdf_text(doc,contact_num,37,77.2,4.9)
                loop_jspdf_text(doc,email_add,37,82.3,4.9)
                // part 3
 
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
                let compensation    = 3000000.123456.toFixed(2).split('').reverse().join('');
                let sat_min_wage    = 2000000.123456.toFixed(2).split('').reverse().join('');
                let excess_pay              = 45328.345363.toFixed(2).split('').reverse().join('');
                let benefits_pay            = 628.345363.toFixed(2).split('').reverse().join('');
                let demin_benefits          = 422.345645.toFixed(2).split('').reverse().join('');
                let mando_contribution      = 5234.23.toFixed(2).split('').reverse().join('');
                let other_non_tax           = 400.2345.toFixed(2).split('').reverse().join('');
                let total_non_tax_com       = 470.34.toFixed(2).split('').reverse().join('');
                let total_tax_com           = 4320.34.toFixed(2).split('').reverse().join('');
                let less_tax_com_witholding = 350.33.toFixed(2).split('').reverse().join('');
                let net_tax_com             = 550.33.toFixed(2).split('').reverse().join('');
                let total_tax_witheld       = 650.33.toFixed(2).split('').reverse().join('');
                let tax_adj_widtheld        = 550.32.toFixed(2).split('').reverse().join('');
                let tax_widtheld_remittance = 2123.00.toFixed(2).split('').reverse().join('');
                let less_tax_remittance     = 3429.00.toFixed(2).split('').reverse().join('');
                let other_remittance        = 1429.00.toFixed(2).split('').reverse().join('');
                let total_tax_remittance    = 6429.00.toFixed(2).split('').reverse().join('');
                let tax_due                 = 8329.00.toFixed(2).split('').reverse().join('');
                let penalty_surcharge       = 1329.00.toFixed(2).split('').reverse().join('');
                let penalty_interest        = 2329.00.toFixed(2).split('').reverse().join('');
                let penalty_compromise      = 4329.00.toFixed(2).split('').reverse().join('');
                let total_penalties         = 8329.00.toFixed(2).split('').reverse().join('');
                let total_amount_due        = 8529.00.toFixed(2).split('').reverse().join('');
                let part2_data              = [ sat_min_wage,excess_pay,benefits_pay,demin_benefits,mando_contribution,
                                                other_non_tax,total_non_tax_com,total_tax_com,
                                                less_tax_com_witholding,net_tax_com,total_tax_witheld,
                                                tax_adj_widtheld,tax_widtheld_remittance,less_tax_remittance,
                                                other_remittance,total_tax_remittance,tax_due,penalty_surcharge,
                                                penalty_interest,penalty_compromise,total_penalties,total_amount_due
                                                ];
                let y_coor=106;
                loop_jspdf_text(doc,compensation,200,98,-4.9)
                for(let text of part2_data){
                    loop_jspdf_text(doc,text,200,y_coor,-4.9,11);
                    y_coor+=5.08;
                }
                // part 3
                loop_jspdf_text(doc,'00000',42,254.5,4.9)
                window.open(doc.output('bloburl'), '_blank');
                };
              })
              .catch(error => {
                console.error('Error fetching the image:', error);
              });
        })
        
    })
</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>