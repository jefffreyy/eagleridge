<style>
    .card{
        padding: 20px;
    }
    li a{
        color: #0D74BC;
    }
    a:hover{
        text-decoration: none;
    }
    .activity td{
        padding: 6.8px 20px;
    }
    .page-item .active{
        background-color: #0D74BC !important;
    }
    label.required:after {
        content: " *";
    }

    label.required:after {
        content: " *";
        color: red;
    }
    li a{
        font-size: 14px;
    }
    .header-elements a{
        font-size: 14px;
    }
    .list-icons a{
        font-size: 11.2px;
        color: #197fc7;
    }
    .profile{
        padding: 20px 0px 0px;
    }
    .profile-img{
        display: inline-block;
        padding-right: 20px;
    }
    .profile-disc{
        margin-left: 100px;
    }
    .profile-name{
        font-weight: bold;
        font-size:16px;
        color: black;
    }
    .position{
        font-weight: bold;
        font-size: 15px;
        color: #B0B0B0;
    }
    .divider{
        margin-top: 50px;
    }
    .social-div a{
        padding: 10px 15px;
        color: #6a6a6a;
        font-size: 15px;
    }
    .label-note{
        background-color: #fde6d8;
        padding: 5px 10px;
        border-radius: 30px;
        color: #c46632;
        font-weight: bold;
        text-align: center;
        line-height: normal;
    }
    table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
   
    }
    th, td {
    text-align: left;
    padding: 8px;
    font-size: 14px;
    font-weight: normal;
    }
    
</style>

<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">

	<div class="content-wrapper">
		<div class="container-fluid p-4">
            <form action="<?php echo base_url('payroll/generator'); ?>" id="payslip_period" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="row">
                    <div class = "col-md-6">
                        <h1><b>Payroll</b><h1>
                    </div>
                    <div class = "col-md-6" style = "text-align: right;">
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="d-flex">
                            <div style="width: 150px;">
                                <p class="text-bold mb-2 pt-2">Cut-off Period:  </p>
                            </div>
                            <div class="flex-fill" style="width: auto;">
                                <!-- <p>June 1, 2021 - June 15, 2021</p> -->
                                <select name="date_period" class="form-control" id="date_period" required>
                                    <?php
                                        if($DISP_PAYROLL_SCHED){
                                            foreach($DISP_PAYROLL_SCHED as $DISP_PAYROLL_SCHED_ROW){
                                            ?>
                                                <option value="<?= $DISP_PAYROLL_SCHED_ROW->id ?>" <?php if($DISP_PAYROLL_SCHED_ROW->id == '9'){echo 'selected';} ?>><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                                            <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary float-right"><i class="fa fa-plus"></i>&nbsp;&nbsp; Enroll New</button>
                    </div>
                </div>
                <hr>
                <div class = "row">
                    <div class = "col-md-3">
                        <div class = "card" style = "background-color: #00897b; color: white;">
                            <div style = "padding: 10px 1px;">
                                <text style = "font-size: 20px; margin-bottom: -15px;">
                                    <?php 
                                        $employee = $this->p020_emplist_mod->MOD_DISP_ALL_EMPLOYEES();
                                        echo count($employee);
                                    ?>
                                 </text><br>
                                <text><b>Current Employees Count</b></text>
                            </div>
                        </div>
                    </div>
                    <div class = "col-md-3">
                        <div class = "card" style = "background-color: #5e35b1; color: white;">
                            <div style = "padding: 10px 1px;">
                                <text style = "font-size: 20px; margin-bottom: -15px;" id="generated_payslip_count">
                                <?php 
                                    echo count($DISP_PAYROLL_DATA);
                                ?>
                                </text><br>
                                <text><b>Generated Payslips</b></text>
                            </div>
                        </div>
                    </div>
                    <div class = "col-md-3">
                        <div class = "card" style = "background-color: #3382b1; color: white;">
                            <div style = "padding: 10px 1px;">
                                <text style = "font-size: 20px; margin-bottom: -15px;" id="employee_without_payslip">
                                
                                </text><br>
                                <text><b>Employees Without Payslips</b></text>
                            </div>
                        </div>
                    </div>
                    <div class = "col-md-3">
                        <div class = "card" style = "background-color: #635249; color: white;">
                            <div style = "padding: 10px 1px;">
                                <text style = "font-size: 20px; margin-bottom: -15px;" id="total_amount">
                                    <?php 
                                        $amount_arr = [];
                                        if($DISP_PAYROLL_DATA){
                                            foreach($DISP_PAYROLL_DATA as $DISP_PAYROLL_DATA_ROW){
                                                array_push($amount_arr, $DISP_PAYROLL_DATA_ROW->net_pay);
                                            }
                                        }
                                        echo array_sum($amount_arr);
                                    ?>
                                </text><br>
                                <text><b>Total Payroll Amount</b></text>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <ul class="nav nav-tabs border-0">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#employees_with_payslip">With Payslips</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#employees_without_payslip">Without Payslips</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class = "card border-0 mt-2 tab-pane active p-2" id="employees_with_payslip" style="margin-top: -1px !important; border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
                    <div style="overflow-x:auto;">
                        <table class = "table table-hover" id="tbl_payslip">
                            <thead>
                                <tr>
                                    <td style="border-top: none !important;">Employee Id</td>
                                    <td style="border-top: none !important;">Full Name</td>
                                    <td style="border-top: none !important;">Employment Type</td>
                                    <td style="border-top: none !important;">Position</td>
                                    <td style="border-top: none !important; display: none;">Cut-off Period</td>
                                    <td style="border-top: none !important;">Amount</td>
                                    <td style="border-top: none !important;" class="text-center">Action</td>
                                    <td style="border-top: none !important;" class="text-center">File</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if($DISP_PAYROLL_DATA){
                                        foreach($DISP_PAYROLL_DATA as $DISP_PAYROLL_DATA_ROW){
                                            $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_PAYROLL_DATA_ROW->empl_id);
                                            $payroll_period = $this->p175_payschedule_mod->MOD_GET_PAY_SCHED_DATA($DISP_PAYROLL_DATA_ROW->payroll_period);
                                        ?>
                                            <tr class="payslip_row">
                                                <td><?= $employee[0]->col_empl_cmid ?></td>
                                                <td><a href = "<?=base_url()?>employees/personal?id=<?= $DISP_PAYROLL_DATA_ROW->empl_id ?>">
                                                    <img class="rounded-circle avatar " width="35" height="35" src="<?php if($employee[0]->col_imag_path){echo base_url().'user_images/'.$employee[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $employee[0]->col_frst_name.' '.$employee[0]->col_last_name?></a>
                                                </td>
                                                
                                                <td><?= $employee[0]->col_empl_type ?></td>
                                                <td><?= $employee[0]->col_empl_posi ?></td>
                                                <td payroll_period="<?= $payroll_period[0]->name ?>" style="display: none;"></td>
                                                <td><?= $DISP_PAYROLL_DATA_ROW->net_pay ?></td>
                                                <td>
                                                    <center>
                                                        <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                                            <a href="<?= base_url() ?>payroll/employee_payroll_data?payroll_id=<?= $DISP_PAYROLL_DATA_ROW->id ?>" class="btn btn-primary text-white px-3" title="View Payslip Details">
                                                                <i class="fas fa-eye">
                                                                </i>&nbsp;&nbsp; View
                                                            </a>&nbsp;&nbsp;
                                                            <a href="<?= base_url() ?>payroll/employee_payroll_data?payroll_id=<?= $DISP_PAYROLL_DATA_ROW->id ?>" class="btn btn-primary text-white px-3" title="View Payslip Details">
                                                                <i class="fas fa-wrench">
                                                                </i>&nbsp;&nbsp; Adjust
                                                            </a>
                                                        </div>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <a href="#" payslip_id="<?= $DISP_PAYROLL_DATA_ROW->id ?>" class="download_pdf">
                                                            <img src="<?= base_url() ?>images/pdf_icon.png" alt="pdf icon" style="width: 30px;">&nbsp;&nbsp;<!-- <a href="<?= base_url() ?>reference_data/payroll.pdf" id="<?= $employee[0]->id.'pdf' ?>" download>sdf.pdf</a> -->
                                                        </a>
                                                    </center>
                                                </td>
                                        </tr>
                                        <?php
                                            }
                                        } else {
                                            ?>
                                                <td colspan=6>No Payslips Yet</td>
                                            <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class = "card border-0 mt-2 tab-pane p-2" id="employees_without_payslip" style="margin-top: -1px !important; border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
                    <div style="overflow-x:auto;">
                        <table class = "table table-hover" id="tbl_payslip">
                            <thead>
                                <tr>
                                    <td style="border-top: none !important;">Employee Id</td>
                                    <td style="border-top: none !important;">Full Name</td>
                                    <td style="border-top: none !important;">Employment Type</td>
                                    <td style="border-top: none !important;">Position</td>
                                    <td style="border-top: none !important; display: none">Cut-off Period</td>
                                    <td style="border-top: none !important;" class="text-center">Action</td>
                                </tr>
                            </thead>
                            <tbody id="empl_without_payslip_container">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
	</div>

	<aside class="control-sidebar control-sidebar-dark">
	</aside>
	<script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
	<!-- jQuery -->
	<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
        $.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- jQuery Knob Chart -->
	<script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js"></script>
	<!-- Summernote -->
	<script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js"></script>
	<!-- overlayScrollbars -->
	<script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>
	<!-- Full Calendar 2.2.5 -->
	<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js"></script>
	<!-- Sweet Alert -->
	<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
	<!-- Toastr -->
	<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
    <!-- JsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.debug.js"></script>

    <?php
    if ($this->session->userdata('SESS_SUCC_MSG_ADD_PAYROLL')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_MSG_ADD_PAYROLL'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_MSG_ADD_PAYROLL');
    }
    ?>

    <script>
        $(document).ready(function(){
            

            // for async data - fetch count of employees with no payslip
            var base_url = '<?= base_url() ?>';
            var url = '<?= base_url() ?>payroll/get_employee_no_payslip_count';
            var url2 = '<?= base_url() ?>payroll/get_payslip_count_based_on_period';
            var url3 = '<?= base_url() ?>payroll/getEmployeeData';
            var url4 = '<?= base_url() ?>payroll/get_payslip_data';
            var payroll_id = $('#date_period').val();
            var cut_off_period_text = $('#date_period option:selected').text()

            // =================================== LOAD INITIAL RECORDS =====================================
            // Diplay initial count based on current value of cutoff period
            get_employee_no_payslip_count(url, payroll_id).then(data => {
                $('#employee_without_payslip').html(data.employee_count);
            })

            // Diplay initial payslip count based on current value of cutoff period
            get_payslip_count_based_on_period(url2, payroll_id).then(data => {
                $('#generated_payslip_count').html(data);
            })

            // get the length of displayed tr
            var length = $('#tbl_payslip .payslip_row').filter(function() {
                            return $(this).css('display') !== 'none';
                        }).length;
            
            if(length == 0){
                $('#employee_without_payslip').html('0');
                $('#generated_payslip_count').html('0');
            }

            // get employees without payslip based on current vlaue of cutoff period
            get_employee_no_payslip_count(url, payroll_id).then(data => {
                console.log(data.employees_with_no_payslip);
                data.employees_with_no_payslip.forEach((id) => {
                    getEmployeeData(url3, id).then(data1 => {
                        data1.employee_data.forEach(function(x){
                            $('#empl_without_payslip_container').append(`
                                <tr class="payslip_row">
                                    <td>`+x.col_empl_cmid+`</td>
                                    <td><a href = "`+base_url+`employees/personal?id=`+x.id+`">
                                        <img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`/user_images/`+x.col_imag_path+`">&nbsp;&nbsp;`+x.col_frst_name+' '+x.col_last_name+`</a>
                                    </td>
                                    
                                    <td>`+x.col_empl_type+`</td>
                                    <td>`+x.col_empl_posi+`</td>
                                    <td style="display:none;">`+cut_off_period_text+`</td>
                                    <td>
                                        <center>
                                            <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                                <a href="`+base_url+`payroll/generator_empl?date_period=`+payroll_id+`&employee_id=`+x.id+`" class="btn btn-primary text-white px-3" title="Enroll New">
                                                    <i class="fas fa-eye">
                                                    </i>&nbsp;&nbsp; Enroll New
                                                </a>
                                            </div>
                                        </center>
                                    </td>
                                </tr>
                            `);
                        })
                    })
                })
            })

            // Generate current employees initially
            var date_period_value = $('#date_period option:selected').text();
            var amount_arr = [];
            var tr_cutoff = $('#tbl_payslip .payslip_row');
            if(date_period_value){
                Array.from(tr_cutoff).forEach(function(tr){
                    const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                    if(date_period_value == cut_off_period){
                        tr.style.display = "";
                        const cut_off_amount = $(tr.childNodes[11]).html();
                    } else {
                        tr.style.display = 'none';
                    }
                })
            }



            // Sort by cut-off period
            $('#date_period').change(function(e){
                // clear container before appending
                $('#empl_without_payslip_container').html('');

                var date_period_id_value = $(this).val();
                var date_period_value = $('#date_period option:selected').text();
                var amount_arr = [];
                var tr_cutoff = $('#tbl_payslip .payslip_row');
                
                if(date_period_value){
                    Array.from(tr_cutoff).forEach(function(tr){
                        const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                        if(date_period_value == cut_off_period){
                            tr.style.display = "";
                            const cut_off_amount = $(tr.childNodes[11]).html();
                            // display total amount
                            amount_arr.push(parseFloat(cut_off_amount));
                            // display employees with no payslip based on cutoff period
                            
                        } else {
                            tr.style.display = 'none';
                            amount_arr.push(parseFloat(0));
                        }
                    })

                    get_employee_no_payslip_count(url, date_period_id_value).then(data => {
                        $('#employee_without_payslip').html(data.employee_count);
                        console.log(data.employee_count);
                    })
                    // Diplay initial count based on current value of cutoff period
                    get_payslip_count_based_on_period(url2, date_period_id_value).then(data => {
                        $('#generated_payslip_count').html(data);
                    })

                    get_employee_no_payslip_count(url, date_period_id_value).then(data => {
                        console.log(data.employee_count);
                        data.employees_with_no_payslip.forEach((id) => {
                            getEmployeeData(url3, id).then(data1 => {
                                data1.employee_data.forEach(function(x){
                                    $('#empl_without_payslip_container').append(`
                                        <tr class="payslip_row">
                                            <td>`+x.col_empl_cmid+`</td>
                                            <td><a href = "`+base_url+`employees/personal?id=`+x.id+`">
                                                <img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`/user_images/`+x.col_imag_path+`">&nbsp;&nbsp;`+x.col_frst_name+' '+x.col_last_name+`</a>
                                            </td>
                                            
                                            <td>`+x.col_empl_type+`</td>
                                            <td>`+x.col_empl_posi+`</td>
                                            <td>`+date_period_value+`</td>
                                            <td>
                                                <center>
                                                    <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                                        <a href="`+base_url+`payroll/generator_empl?date_period=`+date_period_id_value+`&employee_id=`+x.id+`" class="btn btn-primary text-white px-3" title="Enroll New">
                                                            <i class="fas fa-eye">
                                                            </i>&nbsp;&nbsp; Enroll New
                                                        </a>
                                                    </div>
                                                </center>
                                            </td>
                                        </tr>
                                    `);
                                })
                            })
                        })
                    })
                } else {
                    Array.from(tr_category).forEach(function(tr){
                        tr.style.display = "";
                    })
                    $('#total_amount').html('0');
                } 
                // get the total sum of array values
                $('#total_amount').html((amount_arr.reduce((a, b) => a + b, 0)).toFixed(2));
                amount_arr = [0];
                
                // get the length of displayed tr
                var length = $('#tbl_payslip .payslip_row').filter(function() {
                                return $(this).css('display') !== 'none';
                            }).length;
                
                if(length == 0){
                    $('#employee_without_payslip').html('0');
                    $('#generated_payslip_count').html('0');
                }
            })
            

            $('.download_pdf').click(function(){
                var payslip_id = $(this).attr('payslip_id');
                var parent_tr = $(this).parent().parent().parent();

                var parent_element = Array.from(parent_tr)[0];
                var employment_type = $(parent_element.childNodes[5]).text();
                var position = $(parent_element.childNodes[7]).text();
                // var net_pay = $(parent_element.childNodes[11]).text();

                // console.log(employment_type);
                // console.log(position);
                // console.log(net_pay);
                // console.log(payslip_id);

                get_payslip_data(url4, payslip_id).then(function(payslip_data){
                    var employee_name = payslip_data[0].empl_name;
                    var net_pay = payslip_data[0].net_pay;

                    const doc = new jsPDF({
                        orientation: "landscape",
                        // unit: "in",
                        // format: [4, 2]
                    });

                    doc.text('Employee: '+employee_name, 20, 20);
                    doc.text('Employment Type: '+employment_type, 20, 30);
                    doc.text('Position: '+position, 20, 40);
                    doc.text('Net Pay: '+net_pay, 20, 50);

                    doc.save(employee_name + " - Payslip.pdf");
                })
            })
            
            async function get_payslip_data(url, payroll_id){
                var formData = new FormData();
                formData.append('payroll_id', payroll_id);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }


            
            
            async function get_payslip_count_based_on_period(url,payroll_id) {
                var formData = new FormData();
                formData.append('payroll_id', payroll_id);
                const response = await fetch(url, {
                method: 'POST',
                body: formData
                });
                return response.json();
            }

            async function get_employee_no_payslip_count(url,payroll_id) {
                var formData = new FormData();
                formData.append('payroll_id', payroll_id);
                const response = await fetch(url, {
                method: 'POST',
                body: formData
                });
                return response.json();
            }
            
            async function getEmployeeData(url,employee_id) {
                var formData = new FormData();
                formData.append('employee_id', employee_id);
                const response = await fetch(url, {
                method: 'POST',
                body: formData
                });
                return response.json();
            }
        })
    </script>
</body>
</html>
