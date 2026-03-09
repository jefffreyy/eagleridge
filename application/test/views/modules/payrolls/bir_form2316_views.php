
<?php $this->load->view('templates/css_link'); ?>
<style>
    *{
        font-size:16px;
    }
</style>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">payrolls</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">BIR form 2316
                </li>
            </ol>
        </nav>
        <h1 class="py-3 page-title border-bottom">BIR form 2316<h1>
        <div class="row  d-flex justify-content-center">
        <div class="col-sm-8">
            <div class="card mt-3">
                <div class="modal-body pb-5">
                    <div class="row">
                        <div class="col-md-12">
                           <form method='POST'>
                               <div class="form-group ">
                                    <label class="required">Year</label>
                                    <select class="form-control" name="year" id="year" required>
                                        <option value="">Please Choose Year</option>
                                    <?php foreach($YEARS as$year){?>
                                        <option value='<?=$year?>'><?=$year?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label class="required">Employee</label>
                                    <select class="form-control" name="employee" id="insrt_name" required>
                                        <option value="">Please Choose Employee</option>
                                        <option value='1'>John Doe</option>
                                <?php foreach($EMPLOYEES as $employee) { ?>
                                        <option value='<?=$employee->id?>'><?=$employee->col_last_name.' '.$employee->col_frst_name?></option>
                                        
                                <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="employees_tin">TIN</label>
                                    <p class='m-0' style='font-size:12px'>Note: Tin number is 14 digit number</p>
                                    <input type="text" name='employees_tin'  class="form-control tinNum" id="employees_tin" placeholder="Employee's TIN" required>
                                     <div class='employees_tin_error error'></div>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="employees_zipcode">Zip code</label>
                                    <input type="text" name='employees_zipcode'  class="form-control" id="employees_zipcode" placeholder="Employee's Zip code" required>
                                    <div class='employees_zip_error error'></div>
                                </div>
                                <hr/>
                                    <p class='p-0 m-0 text-center'>Employer's Information</p>
                                <hr/>
                                <div class="form-group">
                                    <label class="required" for="employer">Employer</label>
                                    <input type="text" name='employers_name'  class="form-control" id="employer" placeholder="Employer's name" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="employers_tin">TIN</label>
                                    <p class='m-0' style='font-size:12px'>Note: Tin number is 14 digit number</p>
                                    <input type="text" name='employeers_tin'  class="form-control tinNum" id="employers_tin" placeholder="Employer's TIN" required>
                                    <div class='employers_tin_error error'></div>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="employers_address">Address</label>
                                    <input type="text" name='employers_address'  class="form-control" id="employers_address" placeholder="Employer's Address" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="employers_zipcode">Zip code</label>
                                    <input type="text" name='employers_zipcode'  class="form-control" id="employers_zipcode" placeholder="Zip code" required>
                                    <div class='employers_zip_error error'></div>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="employers_rep">Employer Representative</label>
                                    <input type="text" name='employers_rep'  class="form-control" id="employers_rep" placeholder="Employer Representative Name" required>
                                </div>
                                <button type='submit' class='btn technos-button-blue d-block ml-auto'>Generate</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<?php $this->load->view('templates/jquery_link'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"
integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
<script>
    $(document).ready(function(){

        
        $('#year').select2();
        $('#insrt_name').select2();

        $('form').on('submit',function(e){
            e.preventDefault();
            var formData= {};
            $(this).find('input, select').each(function() {
              formData[this.name] = $(this).val();
            });
            var isValid=validateData(formData);
            if(isValid){
                var employeeData={};
                getData(formData.employee)
                .then((res)=>{
                    employeeData=res[0];
                    generate(employeeData,formData)
                    
                })
            }
            
        });
    async function getData(empl_id) {
          try {
            const data = await $.ajax({
              url: "<?=base_url()?>payrolls/getSpecificEmployeeData/"+empl_id,
              method: 'GET',
              dataType: 'json'
            });
            return data;
          } catch (error) {
            console.error(error);
      }
    }
    function validateData(data){
        var employer_tin=parseInt(data.employeers_tin);
        var employee_tin=parseInt(data.employees_tin);
        var isValid=true;
        if(employer_tin.toString().length!=14){
            $('.employers_tin_error').html("<p class='text-danger'>Invalid tin number</p>");
            isValid=false;
                
        }
        if(employee_tin.toString().length!=14){
            $('.employees_tin_error').html("<p class='text-danger'>Invalid tin number</p>");
            isValid=false;
        }
        if(data.employers_zipcode.length!=4){
            $('.employers_zip_error').html("<p class='text-danger'>Invalid zip code</p>");
            isValid=false;
                
        }
        if(data.employees_zipcode.length!=4){
            $('.employees_zip_error').html("<p class='text-danger'>Invalid zip code</p>");
            isValid=false;
        }
        setTimeout(function(){
            $('.error').html('')
        },5000);
        return isValid;
    }
    function reformatDate(dateData){
        const date = new Date(Date.parse(dateData));
        const options = { month: '2-digit', day: '2-digit', year: 'numeric' };
        const formattedDate = date.toLocaleDateString('en-US', options);
        return formattedDate;
    }
    function generate(employeeData,formData){
        var employerTin=formData['employeers_tin'];
        var employeesTin=formData['employees_tin'];
        var doc = new jsPDF("p", "mm", [297, 420]);
        var width = doc.internal.pageSize.width;
        var height = doc.internal.pageSize.height;
        var image="<?=base64_encode(file_get_contents(base_url('assets_system/forms/form_bir2316.jpeg')))?>";
        doc.addImage("data:image/jpeg;base64,"+image, 'JPEG', 0,0, 297, 420);
        doc.setFont('helvetica');
    
        doc.setFontSize(12)
        doc.setFontStyle('bold');
        // year
        var year=formData.year;
       
        // doc.text(year, (95/2)/2+(95/2), 48,{align:'center'});
        doc.text(63, 48, year[0]);
        doc.text(72, 48, year[1]);
        doc.text(81, 48, year[2]);
        doc.text(90, 48, year[3]);

        // date period from month
        doc.text(190, 48, '');
        doc.text(200, 48, '');
        // date period from day
        doc.text(208, 48, '');
        doc.text(216, 48, '');
         // date period to month
         doc.text(252, 48, '');
        doc.text(260, 48, '');
        // date period to day
        doc.text(268, 48, '');
        doc.text(278, 48, '');
        // tin number
        let tinX1=44;
        let tinX2=50;
        let tinX3=56;
       
        doc.text(tinX1, 61, employeesTin[0]);
        doc.text(tinX2, 61, employeesTin[1]);
        doc.text(tinX3, 61, employeesTin[2]);
    
        doc.text(tinX1+=24, 61, employeesTin[3]);
        doc.text(tinX2+=24, 61, employeesTin[4]);
        doc.text(tinX3+=24, 61, employeesTin[5]);
    
        doc.text(tinX1+=24, 61, employeesTin[6]);
        doc.text(tinX2+=24, 61, employeesTin[7]);
        doc.text(tinX3+=24, 61, employeesTin[8]);
    
        doc.text(tinX1+=24, 61, employeesTin[9]);
        doc.text(tinX2+=25, 61, employeesTin[10]);
        doc.text(tinX3+=27, 61, employeesTin[11]);
        doc.text(tinX3+=7, 61, employeesTin[12]);
        doc.text(tinX3+=6, 61, employeesTin[13]);
        // Document of 210mm wide and 297mm high
        doc.text(23, 72.5,employeeData['col_last_name']+','+employeeData['col_frst_name']+' '+employeeData['col_midl_name']);
        // registered Add
        doc.text(23, 85, employeeData['col_curr_addr']);
        // rdo code
        doc.text(130, 72.5, '-');
        // doc.text(136, 72.5, '-');
        // doc.text(142, 72.5, 'O');

        // zip code
        // doc.text(formData['employees_zipcode'], (175/2)/2+(175/2), 84.5,{align:'center'});
        doc.text(128, 84.5, formData['employees_zipcode'][0]);
        doc.text(134, 84.5, formData['employees_zipcode'][1]);
        doc.text(140, 84.5, formData['employees_zipcode'][2]);
        doc.text(146, 84.5, formData['employees_zipcode'][3]);

        // Local home Address
        doc.text(23, 96, employeeData['col_home_addr']);

        // Local home zip code
        // doc.text(formData['employees_zipcode'], (175/2)/2+(175/2), 96,{align:'center'});
        doc.text(128, 96, formData['employees_zipcode'][0]);
        doc.text(134, 96, formData['employees_zipcode'][1]);
        doc.text(140, 96, formData['employees_zipcode'][2]);
        doc.text(146, 96, formData['employees_zipcode'][3]);
        
        // Foreign Address
        doc.text(26, 107.5, '-');
        // date birth
            // month
        var employeeBirthDate=reformatDate(employeeData['col_birt_date']).split('/');
        let bdate_month = employeeBirthDate[0].split('');
        let bdate_day = employeeBirthDate[1].split('');
        let bdate_year = employeeBirthDate[2].split('');
      
        // doc.text(employeeBirthDate[0],(35/2)/2+(35/2), 119.5, {align:'center'} );
        // day
        doc.text(25, 119.5, bdate_month[0]);
        doc.text(31, 119.5, bdate_month[1]);
        
        // doc.text(employeeBirthDate[1],(50/2)/2+(50/2), 119.5, {align:'center'} );
        // month
        doc.text(37, 119.5, bdate_day[0]);
        doc.text(43, 119.5, bdate_day[1]);

        // year
        // doc.text(employeeBirthDate[2],(72.5/2)/2+(72.5/2), 119.5, {align:'center'} );
        doc.text(49, 119.5, bdate_year[0]);
        doc.text(55, 119.5, bdate_year[1]);
        doc.text(61, 119.5, bdate_year[2]);
        doc.text(67, 119.5, bdate_year[3]);

        // contact number
        // let contacXpos=82.5
        let contacXpos=76.5
        let contactIncBy=6.3;
        // doc.text(contacXpos, 119.5, employeeData['col_mobl_numb']);
       
        doc.text(contacXpos+=contactIncBy, 119.5, (employeeData['col_mobl_numb'][0]) ? employeeData['col_mobl_numb'][0] : "");
        doc.text(contacXpos+=contactIncBy, 119.5, (employeeData['col_mobl_numb'][1]) ? employeeData['col_mobl_numb'][1] : "");
        doc.text(contacXpos+=contactIncBy, 119.5, (employeeData['col_mobl_numb'][2]) ? employeeData['col_mobl_numb'][2] : "");
        doc.text(contacXpos+=contactIncBy, 119.5, (employeeData['col_mobl_numb'][3]) ? employeeData['col_mobl_numb'][3] : "");
        doc.text(contacXpos+=contactIncBy, 119.5, (employeeData['col_mobl_numb'][4]) ? employeeData['col_mobl_numb'][4] : "");
        doc.text(contacXpos+=contactIncBy, 119.5, (employeeData['col_mobl_numb'][5]) ? employeeData['col_mobl_numb'][5] : "");
        doc.text(contacXpos+=contactIncBy, 119.5, (employeeData['col_mobl_numb'][6]) ? employeeData['col_mobl_numb'][6] : "");
        doc.text(contacXpos+=contactIncBy, 119.5, (employeeData['col_mobl_numb'][7]) ? employeeData['col_mobl_numb'][7] : "");
        doc.text(contacXpos+=contactIncBy, 119.5, (employeeData['col_mobl_numb'][8]) ? employeeData['col_mobl_numb'][8] : "");
        doc.text(contacXpos+=contactIncBy, 119.5, (employeeData['col_mobl_numb'][9]) ? employeeData['col_mobl_numb'][9] : "");
        doc.text(contacXpos+=contactIncBy, 119.5, (employeeData['col_mobl_numb'][10]) ? employeeData['col_mobl_numb'][10] : "");
        // doc.text(contacXpos+=contactIncBy, 119.5, '9');
        // doc.text(contacXpos+=contactIncBy, 119.5, '1');
        // doc.text(contacXpos+=contactIncBy, 119.5, '2');
        // doc.text(contacXpos+=contactIncBy, 119.5, '3');
        // doc.text(contacXpos+=contactIncBy, 119.5, '4');
        // doc.text(contacXpos+=contactIncBy, 119.5, '5');
        // doc.text(contacXpos+=contactIncBy, 119.5, '6');
        // doc.text(contacXpos+=contactIncBy, 119.5, '7');
        // doc.text(contacXpos+=contactIncBy, 119.5, '8');
        // doc.text(contacXpos+=contactIncBy, 119.5, '9');

        doc.text(103, 127.5, '-');
        doc.text(103, 135.5, '-');
        doc.text(25, 143.5, '-');
        // empoyer tin
        tinX1=44;
        tinX2=50;
        tinX3=56;
        tinY=155.5;
        doc.text(tinX1, tinY, employerTin[0]);
        doc.text(tinX2, tinY, employerTin[1]);
        doc.text(tinX3, tinY, employerTin[2]);
    
        doc.text(tinX1+=24, tinY, employerTin[3]);
        doc.text(tinX2+=24, tinY, employerTin[4]);
        doc.text(tinX3+=24, tinY, employerTin[5]);
    
        doc.text(tinX1+=24, tinY, employerTin[6]);
        doc.text(tinX2+=24, tinY, employerTin[7]);
        doc.text(tinX3+=24, tinY, employerTin[8]);
    
        doc.text(tinX1+=24, tinY, employerTin[9]);
        doc.text(tinX2+=25, tinY, employerTin[10]);
        doc.text(tinX3+=27, tinY, employerTin[11]);
        doc.text(tinX3+=7, tinY, employerTin[12]);
        doc.text(tinX3+=6, tinY, employerTin[13]);

        // employer name
        doc.text(23, 167, formData['employers_name']);
        doc.text(23, 179, formData['employers_address']);

        // zipp code
        let zipX=127;
        let zipY=179;
        // doc.text(formData['employers_zipcode'], (175/2)/2+(175/2), 179,{align:'center'});
        doc.text(zipX, zipY, formData['employers_zipcode'][0]);
        doc.text(zipX+=6, zipY, formData['employers_zipcode'][1]);
        doc.text(zipX+=6, zipY, formData['employers_zipcode'][2]);
        doc.text(zipX+=6, zipY, formData['employers_zipcode'][3]);

        // Type of employer
        doc.text(57.5, 187, '-');
        doc.text(98, 187, '-');
        // previous employeer
        // empoyer tin
        tinX1=43;
        tinX2=50;
        tinX3=56;
        tinY=199.5;
        doc.text(tinX1, tinY, '-');
        doc.text(tinX2, tinY, '-');
        doc.text(tinX3, tinY, '-');
    
        doc.text(tinX1+=24, tinY, '-');
        doc.text(tinX2+=24, tinY, '-');
        doc.text(tinX3+=24, tinY, '-');
    
        doc.text(tinX1+=24, tinY, '-');
        doc.text(tinX2+=24, tinY, '-');
        doc.text(tinX3+=24, tinY, '-');
    
        doc.text(tinX1+=24, tinY, '-');
        doc.text(tinX2+=24, tinY, '-');
        doc.text(tinX3+=24, tinY, '-');
        doc.text(tinX3+=8, tinY, '-');
        doc.text(tinX3+=6, tinY, '-');
         // employer name
        doc.text(23, 210, '');
        doc.text(23, 223, '');
        zipX=127;
        zipY=223;
        doc.text(zipX, zipY, '-');
        // doc.text(zipX+=6, zipY, 'I');
        // doc.text(zipX+=6, zipY, 'P');
        // doc.text(zipX+=6, zipY, 'P');
        // Gross compensation income present
        // Part IV
        let conX=103;
        let conY=235;
        let conIncBy=8.5;
        doc.text(conX, conY, '-');
        doc.text(conX, conY+=8.5, '-');
        doc.text(conX, conY+=8.5, '-');
        doc.text(conX, conY+=8.6, '-');
        doc.text(conX, conY+=8.7, '-');
        doc.text(conX, conY+=8.8, '-');
        doc.text(conX, conY+=8.9, '-');
        doc.text(conX, conY+=9, '-');
        doc.text(conX, conY+=9.1, '-');
        doc.text(conX, conY+=9.2, '-');
        doc.text(conX, conY+=9.3, '-');
        
        // Non taxable compensation income
        conX=236;
        conY=69;
        conIncBy=8.5;
        let conAdd=0.1;
        doc.text(conX, conY, '-');
        doc.text(conX, conY+=8.5, '-');
        doc.text(conX, conY+=8.7, '-');
        doc.text(conX, conY+=8.9, '-');
        doc.text(conX, conY+=9.0, '-');
        doc.text(conX, conY+=9.0, '-');
        doc.text(conX, conY+=8.6, '-');
        doc.text(conX, conY+=8.2, '-');
        doc.text(conX, conY+=8.5, '-');
        doc.text(conX, conY+=8.5, '-');
        // Taxable compensation
        conY=164
        doc.text(conX, conY, '-');
        doc.text(conX, conY+=9, '-');
        doc.text(conX, conY+=9, '-');
        doc.text(conX, conY+=9, '-');
        doc.text(conX, conY+=8, '-');
        // Others
        conX=167
        conY=211
        doc.text(conX, conY, '-');
        doc.text(conX, conY+=8, '-');
        conX=236;
        conY=211
        doc.text(conX, conY, '-');
        doc.text(conX, conY+=8, '-');
        // Supplementary
        conY=230.5;
        doc.text(conX, conY, '-');
        doc.text(conX, conY+=8.5, '-');
        doc.text(conX, conY+=8.6, '-');
        doc.text(conX, conY+=8.7, '-');
        doc.text(conX, conY+=8.8, '-');
        doc.text(conX, conY+=8.9, '-');
        conX=167
        conY=287.5
        doc.text(conX, conY, '-');
        doc.text(conX, conY+=8, '-');
        conX=236;
        conY=287.5
        doc.text(conX, conY, '-');
        doc.text(conX, conY+=8, '-');
        // Total taxable income
        doc.text(conX, conY+=8.5, '-');
        
        conX=23;
        conY=300;
        // 53 Present employer over signature
        doc.text(formData['employers_name'], (90/2)/2+(90/2), 345,{align:'center'});
        // Date Signed
        // Month
        doc.text('', 204, 344.5);
        doc.text('', 210, 344.5);
        // Day
        doc.text('', 216, 344.5);
        doc.text('', 222, 344.5);
        // Year
        doc.text('', 228.5, 344.5);
        doc.text('', 234.5, 344.5);
        doc.text('', 241.5, 344.5);
        doc.text('', 247.5, 344.5);
        // employee ID
        doc.text('', 48, 370);
        // Place of Issue
        doc.text('', 120, 370);
        // Employee Signature
        doc.text(employeeData['col_frst_name']+' '+employeeData['col_midl_name']+' '+employeeData['col_last_name'], (90/2)/2+(90/2), 358,{align:'center'});
        // Date Signed
        // Month
        doc.text('', 204, 358.5);
        doc.text('', 210, 358.5);
        // Day
        doc.text('', 216, 358.5);
        doc.text('', 222, 358.5);
        // Year
        doc.text('', 228.5, 358.5);
        doc.text('', 234.5, 358.5);
        doc.text('', 241.5, 358.5);
        doc.text('', 247.5, 358.5);
        // employee ID
        doc.text('', 48, 370);
        // Place of Issue
        doc.text('', 120, 370);
        // Date Signed
        // Month
        doc.text('', 204, 370);
        doc.text('', 210, 370);
        // Day
        doc.text('', 216, 370);
        doc.text('', 222, 370);
        // Year
        doc.text('', 228.5, 370);
        doc.text('', 234.5, 370);
        doc.text('', 241.5, 370);
        doc.text('', 247.5, 370);
        // Amount paid
        doc.text('', 263, 370);
        // substitute filing
        doc.text(formData['employers_rep'], (90/2)/2+(90/2), 395,{align:'center'});
        doc.text(employeeData['col_frst_name']+' '+employeeData['col_midl_name']+' '+employeeData['col_last_name'], (257/2)/2+(257/2), 402,{align:'center'});
        // doc.output('dataurlnewwindow');
        window.open(doc.output('bloburl'), '_blank');
  
    }
})
</script>