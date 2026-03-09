<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/payslip_views_style'); ?>
<?php
    $id_code = 'PAY';
?>
<style>
    @media (min-width: 1200px) {
        .remote_att {
            float: right;
            margin-top: 25px;
        }
    }
</style>
<body>
    <!-- Content Starts -->
    <div class="content-wrapper">
    <div class="container-fluid p-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url() ?>payrolls">Payroll</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Payslip Generator
        </li>
        </ol>
            <div class="row">
                <!-- Title Text -->
                <div class="col-md-6">
                    <h1 class="page-title">Payslip Generator<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <!-- Title Header Line -->
            <hr>
            <form action="<?php echo base_url('payrolls/generator'); ?>" id="payslip_period" method="post" accept-charset="utf-8" autocomplete='off'>
                <div class="row">
                    <div class="col-md-3">
                        <label for="">Payroll Period</label>
                        <!-- <p>June 1, 2021 - June 15, 2021</p> -->
                        <select name="date_period" class="form-control" id="date_period" required>
                            <?php
                            $date = ((isset($_GET['date'])) && ($_GET['date'] != '')) ? $_GET['date'] : '';
                            $db_cutoff_id = '';
                            if ($DISP_PAYROLL_SCHED) {
                                $isCutoff_today = false;
                                foreach ($DISP_PAYROLL_SCHED as $DISP_PAYROLL_SCHED_ROW) {
                                    $current_date = date('Y-m-d');

                                    
                                    $start_date = $DISP_PAYROLL_SCHED_ROW->date_from;
                                    $end_date = $DISP_PAYROLL_SCHED_ROW->date_to;

                                    $db_payout = $DISP_PAYROLL_SCHED_ROW->payout;
                                    $payout = date('F d Y', strtotime($db_payout));
                                    if ($DISP_PAYROLL_SCHED_ROW->id == $date) {
                                        $selected = "selected";
                                    } else {
                                        $selected = '';
                                    }
                                    if (($current_date >= $start_date) && ($current_date <= $end_date)) {
                                        $schedule_id = $DISP_PAYROLL_SCHED_ROW->id;
                                        $db_cutoff_id = $schedule_id;
                                        $isCutoff_today = true;
                            ?>
                                        <option <?php echo $selected; ?>  value="<?= $schedule_id ?>" db_date="<?= $DISP_PAYROLL_SCHED_ROW->db_name ?>" payout="<?= $payout ?>"><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                            <?php
                                    } else {
                            ?>
                                        <option <?php echo $selected; ?> value="<?= $DISP_PAYROLL_SCHED_ROW->id ?>" db_date="<?= $DISP_PAYROLL_SCHED_ROW->db_name ?>" payout="<?= $payout ?>"><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                            <?php
                                    }
                                }
                                if ($isCutoff_today) {
                                    $db_cutoff_id = $DISP_PAYROLL_SCHED[0]->id;
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-9 mt-4">
                         <!--<a id="btn_bir" class="btn text-light btn-primary float-right ml-2" id="download_csv"><i class="fas fa-pdf"></i>&nbsp;&nbsp;BIR2316 Form</a> -->
                        <button type="submit" class="btn btn-primary float-right ml-2 mb-2" <?php echo (count($PAY_SLIPS_READY)== 0)? 'disabled' : '' ?>><i class="fa fa-plus" id="generate_payslips" ></i>&nbsp;&nbsp;Generate Payslip</button>
                        <!-- <a href="#" cutoff_id="<?= $db_cutoff_id ?>" class="btn btn-primary float-right" id="download_csv"><i class="fas fa-download"></i>&nbsp;&nbsp;Export to CSV</a> -->
                        <!-- <a href="https://api.promotexter.com/sms/send?apiKey=RlMidXh8xm6ITdvn3u5L4Oh8EX2F8o&apiSecret=nB5yKhiJA-BlB-pixZK-Pi34esYVBN&from=EROVOUTIKA&to=+639158406388&text=aw" class="btn btn-primary float-right"><i class="fas fa-download"></i>&nbsp;&nbsp;Test</a> -->
                        <div class="spinner-border text-success float-right mt-1" style="width: 25px !important; height: 25px !important; display: none;" id="export_csv_loading_indicator"></div>
                    </div>
                    
                </div>
                <hr>
                <div class="row">
                    <!-- <div class="col-md-3">
                        <div class="small-box bg-light">
                            <div class="inner">
                                <h3 id="total_employees">
                                    <?php
                               
                                    echo $EMPLOYEE_COUNT;
                                    ?>
                                </h3>
                                <p>Total Employees</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-3">
                        <div class="card p-2 small-box">
                            <div class="inner">
                                <h3 id="label_not_ready_for_payslip"><?=count($PAY_SLIPS_NOT_READY)?></h3>
                                <p>Not Ready for Payslip</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-excel"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-2 small-box">
                            <div class="inner">
                                <h3 id="label_ready_for_payslip"><?=count($PAY_SLIPS_READY)?></h3>
                                <p>Ready for Payslip</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-medical"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card p-2 small-box">
                            <div class="inner">
                                <h3 id="generated_payslip_count"><?=count($PAYSLIPS)?></h3>
                                <p>Generated Payslips</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-powerpoint"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-2 small-box">
                            <div class="inner">
                                <h3 id="total_generated_salary">
                                    &#8369;
                                    <?=$TOTAL_GENERATED_SALARY?>
                                </h3>
                                <p>Total Generated Salary</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-coins"></i>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                        <div class="small-box bg-light">
                            <div class="inner">
                                <h3>XXX</h3>
                                <p>Overtime Costs</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-excel"></i>
                            </div>
                        </div>
                    </div> -->
                </div>
            </form>
             <div class="row">
                <div class="col-md-12">
                    <div class="remote_att">
                        <!--<button class="btn btn-info shadow-none mb-2" id="generate_all_pdf" disabled><i class="fas fa-file-alt"></i>&nbsp;&nbsp;Generate PDF By 3s</button>-->
                        <a href=<?= base_url().'payrolls/export_csv/'.$date ?> class="btn btn-primary shadow-none mb-2" id="btn_export" style="color:#fff;" hidden><i class="fas fa-file-export"></i>&nbsp;Export CSV</a>
                        <a class="btn btn-danger shadow-none mb-2" id="delete_all_payslips" style="color:#fff;" hidden><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Bulk Delete</a>
                    </div>
                </div>
            </div> 
            <ul class="nav nav-tabs border-0">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#employees_not_ready_for_payslip" onclick="changeTab(false)"><i class="fas fa-times-circle" id="not_ready_for_payslip"></i>&nbsp;&nbsp;Not Ready for Payslip</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#employees_ready_for_payslip" onclick="changeTab(false)"><i class="fas fa-check-circle" id="ready_for_payslip"></i>&nbsp;&nbsp;Ready for Payslip</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#employees_with_payslip" onclick="changeTab(true)"><i class="fas fa-file-pdf" id="with_payslips"></i>&nbsp;&nbsp;With Payslips</a>
                </li>
            
            </ul>
            <div class="tab-content">
                <div class="card border-0 mt-2 tab-pane p-0" id="employees_with_payslip" style="margin-top: -1px !important; border-top: none !important;">
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="tbl_payslip">
                                    <thead>
                                        <th  style='min-width:50px'><input type='checkbox' name='check_all' id='select_all' /></th>
                                        <th>Payslip ID</th>
                                        <!-- Table Headers -->
                                        <th>Employee&nbsp;Id</th>
                                        <th>Full&nbsp;Name</th>
                                        <th>Employment&nbsp;Type</th>
                                        <th>Position</th>
                                        <th style="display: none;">Cut&nbsp;-&nbsp;off&nbsp;Period</th>
                                        <th>Action</th>
                                        <!--<th class="text-center">Action</th>-->
                                    </thead>
                                    <tbody>
                                        <?php if (count($PAYSLIPS) > 0) { ?>
                                            <?php foreach($PAYSLIPS as $payslip_row){ ?>
                                                 <tr class="payslip_row">
                                                    <td><input type='checkbox' payslip_id='<?=$payslip_row['id']?>'  class='select_payslip'/></td>
                                                    <td>PAY0000<?=$payslip_row['id']?></td>
                                                    <td><?=$payslip_row['col_empl_cmid']?></td>
                                                    <td><?=$payslip_row['col_frst_name'].' '. $payslip_row['col_last_name'] ?> 
                                                    </td>
                                                    <td><?=$payslip_row['employee_type']?></td>
                                                    <td><?=$payslip_row['position']?></td>
                                                    <td>
                                                        <a payslip_id='<?=$payslip_row['id']?>' class="btn-generate_payslip_pdf text-light d-block m-auto btn btn-sm btn-info">Generate PDF</a>
                                                        <a payslip_id='<?=$payslip_row['id']?>'  class="btn-delete_payslip_pdf text-light d-block  btn btn-sm btn-danger mt-1">Delete</a>
                                                        <!-- <p><?=$payslip_row['id']?></p> -->
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <?php } else {
                                            ?>
                                            <!-- Message if no entries -->
                                            <tr class="table-active">
                                                <td colspan="12">
                                                    <center>No Payslips Yet</center>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- <ul id="btn_pagination" class="pagination"></ul> -->
                </div>
                <div class="card border-0 mt-2 tab-pane p-0" id="employees_ready_for_payslip" style="margin-top: -1px !important; border-top: none !important;">
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="tbl_employees_ready_for_payslip">
                                    <thead>
                                        <!-- Table Headers -->
                                        <!--<th>Payslip ID</th>-->
                                        <th>Employee&nbsp;Id</th>
                                        <th>Full&nbsp;Name</th>
                                        <th>Employment&nbsp;Type</th>
                                        <th>Position</th>
                                        <th style=" display: none">Cut&nbsp;-&nbsp;off&nbsp;Period</th>
                                         <!--<th class="text-center">Action</th> -->
                                    </thead>
                                    <!--container_employees_ready_for_payslip-->
                                    <tbody>
                            <?php if(count($PAY_SLIPS_READY)>0) { ?>
                                 <?php foreach($PAY_SLIPS_READY as $employee) { ?>
                                    <tr>
                                        <td><?=$employee['col_empl_cmid']?></td>
                                        <td><?=$employee['col_last_name'].' '.$employee['col_frst_name']?></td>
                                        <td><?=$employee['employee_type']?></td>
                                        <td><?=$employee['position']?></td>
                                    </tr>
                                
                            <?php } ?>
                            <?php } else { ?>
                                         <!--Message if no entries -->
                                    <tr class="table-active mb-0" id="ready_for_payslip_no_data">
                                        <td colspan="12">
                                            <p class="text-center mb-0">No Payslips Yet</p>
                                        </td>
                                    </tr>
                            <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- <ul id="btn_pagination" class="pagination"></ul> -->
                </div>
                <div class="card border-0 mt-2 tab-pane p-0  active" id="employees_not_ready_for_payslip" style="margin-top: -1px !important; border-top: none !important; ">
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="tbl_employees_not_ready_for_payslip">
                                    <thead>
                                        <!-- Table Headers -->
                                        
                                        <th>Employee&nbsp;Id</th>
                                        <th>Full&nbsp;Name</th>
                                        <th>Employment&nbsp;Type</th>
                                        <th>Position</th>
                                        <th style="border-top: none !important; display: none">Cut-off Period</th>
                                        <!-- <td style="border-top: none !important;" class="text-center">Action</td> -->
                                    </thead>
                                    <!--container_employees_not_ready_for_payslip-->
                                    <tbody>
                            <?php if(count($PAY_SLIPS_NOT_READY )>0) { ?>
                            <?php foreach($PAY_SLIPS_NOT_READY as $employee) { ?>
                                    <tr>
                                        <td><?=$employee['col_empl_cmid']?></td>
                                        <td><?=$employee['col_last_name'].' '.$employee['col_frst_name']?></td>
                                        <td><?=$employee['employee_type']?></td>
                                        <td><?=$employee['position']?></td>
                                    </tr>
                                
                            <?php } ?>
                            <?php } else { ?>
                                    <tr class="table-active" id="ready_for_payslip_no_data">
                                        <td colspan="12">
                                            <p class="text-center mb-0">No Payslips Yet</p>
                                        </td>
                                    </tr>
                            <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- <ul id="btn_pagination" class="pagination"></ul> -->
                </div>
            </div>
        </div>
    </div>
    <?php
    $page = ((isset($_GET['page'])) && ($_GET['page'] != '')) ? $_GET['page'] : 1;
    $date = ((isset($_GET['date'])) && ($_GET['date'] != '')) ? $_GET['date'] : '';
    $date = "?date=" . $date;
    // $filter = "current=stock&";
    // print_r ("Count of Rows: ".$status);//. $filter;
    // print_r ("<br>Count of Rows: ".$DISP_PRODUCT_INFO2_COUNT);//. $filter;
    $page_limit = 20;
    // $total_records = $DISP_PRODUCT_INFO2_COUNT;
    $row_count = $DISP_PAYROLL_DATA_COUNT;
    $ends_count = 1;
    $middle_count = 2;
    $total_pages = ceil($row_count / $page_limit);
    $dots = false;
    echo "<center><ul class='pagination mr-auto ml-auto'>";
    // if ($page > 1)
    $show = 0;
    if ($page > 1) {
        echo "<li><a id='pages' href='" . base_url() . "payroll" . $date . "&page=" . ($page - 1) . "' class='button'>&lt;</a></li>";
    }
    if ($total_pages >= 1 && $page == 1) {
    ?><li disabled><a id='pages' class='text-muted button'>&lt;</a></li><?php
                                                                    } elseif ($page == 3) {
                                                                        ?><li><a id="pages" href="<?php echo base_url(); ?>payroll<?php echo $date; ?>&page=<?php echo 1; ?>"><?php echo 1; ?></a></li><?php
                                                                                                                                                                                                    } elseif ($page == 4) {
                                                                                                                                                                                                        ?><li><a id='pages' href="<?php echo base_url(); ?>payroll<?php echo $date; ?>&page=<?php echo 1; ?>"><?php echo 1; ?></a></li><?php
                                                                                                                                                                                                                                                                                                                                        ?><li><a style="color: #23527c;">&hellip;</a></li><?php
                                                                                                                                                                                                                                                                                                                                                                                            ?><li><a id='pages' href="<?php echo base_url(); ?>payroll<?php echo $date; ?>&page=<?php echo 2; ?>"><?php echo 2; ?></a></li><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } elseif ($page >= 5) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ?><li><a id='pages' href="<?php echo base_url(); ?>payroll<?php echo $date; ?>&page=<?php echo 1; ?>"><?php echo 1; ?></a></li><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ?><li><a style="color: #23527c;">&hellip;</a></li><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ?><li><a id='pages' href="<?php echo base_url(); ?>payroll<?php echo $date; ?>&page=<?php echo 3; ?>"><?php echo 3; ?></a></li><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            for ($i = $page; $i <= $total_pages; $i++) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                if ($i == $page) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    if ($page != 1) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ?><li><a id='pages' href="<?php echo base_url(); ?>payroll<?php echo $date; ?>&page=<?php echo $i - 1; ?>"><?php echo $i - 1; ?></a></li><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ?><li class="active"><a><?php echo $i; ?></a></li><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ?><li class="active"><a href="#"><?php echo $i; ?></a></li><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $dots = true;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                if ($i <= $ends_count || ($page && $i >= $page - $middle_count && $i <= $page + $middle_count) || $i > $total_pages - $ends_count) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ?><li><a id='pages' href="<?php echo base_url(); ?>payroll<?php echo $date; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $dots = true;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } elseif ($dots) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ?><li><a style="color: #23527c;">&hellip;</a></li><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $dots = false;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            if ($total_pages == 1 || $page == $total_pages) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ?><li disabled><a id='pages' class='text-muted button'>&gt;</a></li><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        if ($total_pages > $page) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo "<li><a id='pages' href='" . base_url() . "payroll" . $date . "&page=" . ($page + 1) . "' class='button'>&gt;</a></li>";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo "</ul></center>";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ?>
 
    
   
    <form action='<?=base_url('payrolls/delete_payslip')?>' method='post' id='form_bulk_delete'>
        <input type='hidden' name='payslip_ids' id='payslip_ids'/>
    </form>
    <?php $this->load->view('templates/jquery_link'); ?>
    
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
    <?php
    if ($this->session->userdata('SESS_SUCC_MSG_DLT_PAYROLL')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_PAYROLL'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_MSG_DLT_PAYROLL');
    }
    ?>
    <script>
        function changeTab(e) {
            if (e) {
                $("#delete_all_payslips").removeAttr("hidden");
                $("#btn_export").removeAttr("hidden");
            } else {
                $("#delete_all_payslips").attr("hidden", true);
                $("#btn_export").attr("hidden", true);
            }
        }
        $(document).ready(function() {
            window.jsPDF = window.jspdf.jsPDF;
            // for async data - fetch count of employees with no payslip
            var base_url = '<?= base_url() ?>';
            var url_get_employee_not_ready_for_payslip = '<?= base_url() ?>payrolls/get_employee_not_ready_for_payslip';
            var url_generated_payslip_count = '<?= base_url() ?>payrolls/generated_payslip_count';
            var url3 = '<?= base_url() ?>payrolls/getEmployeeData';
            var url4 = '<?= base_url() ?>payrolls/get_payslip_data';
            var url5 = '<?= base_url() ?>payrolls/get_payment_info';
            var url_payroll_data_based_period = '<?= base_url() ?>payrolls/get_payslip_data_based_on_period';
            var url_get_employees_ready_for_payslip = '<?= base_url() ?>payrolls/get_employees_ready_for_payslip';
            var payroll_id = $('#date_period').val();
            var cut_off_period_text = $('#date_period option:selected').text();
            var cutoff_period_db_name = $('#date_period option:selected').attr('db_date');
            var url_get_employee_all_ampl_data = '<?= base_url() ?>attendances/get_employee_all_ampl_data';
            var url_get_all_payroll_data_by_3s = '<?= base_url() ?>payrolls/get_all_payroll_data_by_3s';
            var global_generate_all_pdf_object = [];
            // CHECK CUTOFF PERIOD
            var db_date_name = $('#date_period option:selected').attr('db_date');
            var split_db_date_name = db_date_name.split('/');
            var initial_cutoff_year = split_db_date_name[4];
            var SIL_year = parseInt(initial_cutoff_year);
            var SIL_label = 'SIL ' + (initial_cutoff_year - 1);

            // console.log(cut_off_period_text);
            $('#select_all').on('change',function(){
                let selected_payslip=$('.select_payslip');
                if($(this).is(':checked')){
                    // Checkbox is checked..
                     selected_payslip.each(function() {
                          this.checked = true;                        
                        });
                  } else{
                    // Checkbox is not checked..
                    selected_payslip.each(function() {
                          this.checked = false;                        
                        });
                  }
            })
            
            $('#SIL_csv_label').html(SIL_label);
            $('.btn-delete_payslip_pdf').on('click',function(e){
                $('input#payslip_ids').val($(this).attr('payslip_id'));
                e.preventDefault();
                
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) {
                    $('#form_bulk_delete').submit();
                  }
                })
            })
            $("#date_period").on("change", function() {
                var optionValue = $(this).val();
                // window.history.replaceState(null, null, '?date='+optionValue+'');
                // console.log('?date='+optionValue+'');
                var url = window.location.href.split("?")[0];
                if (window.location.href.indexOf("?") > 0) {
                    window.location = url + "?date=" + optionValue;
                } else {
                    window.location = url + "?date=" + optionValue;
                }
            })
            // =================================== LOAD INITIAL RECORDS =====================================
            // Diplay initial count based on current value of cutoff period
            // get_employees_ready_for_payslip(url_get_employees_ready_for_payslip, cut_off_period_text, payroll_id).then(data => {
            //     $('#label_ready_for_payslip').html(data.count);
                
            // })
            
            // get_employee_not_ready_for_payslip(url_get_employee_not_ready_for_payslip, cut_off_period_text, payroll_id).then(data => {
            //     $('#label_not_ready_for_payslip').html(data.count);
            // })
            // // Diplay initial payslip count based on current value of cutoff period
            // generated_payslip_count(url_generated_payslip_count, payroll_id).then(data => {
            //     $('#generated_payslip_count').html(data);
            // })
            // get the length of displayed tr
            // var length = $('#tbl_payslip .payslip_row').filter(function() {
            //     return $(this).css('display') !== 'none';
            // }).length;
            // if (length == 0) {
            //     $('#employee_without_payslip').html('0');
            //     $('#generated_payslip_count').html('0');
            // }
            // GET EMPLOYESS READY FOR PAYSLIP
            get_employees_ready_for_payslip(url_get_employees_ready_for_payslip, cut_off_period_text, payroll_id).then(data => {
                
                $('#container_employees_ready_for_payslip').html('');

                if (data.empl_ready_for_payslip.length) {
                    $("#generate_all_pdf").removeAttr("disabled");
                }
                data.empl_ready_for_payslip.forEach(function(id) {
                    getEmployeeData(url3, id.empl_id).then(data1 => {
                        data1.employee_data.forEach(function(x) {
                            // var empl_img = 'default_profile_img3.png';
                            // if (x.col_imag_path) {
                            //     empl_img = x.col_imag_path;
                            // }
                            $('#container_employees_ready_for_payslip').append(`
                                <tr class="payslip_row">
                                    <td>` + x.col_empl_cmid + `</td>
                                    <td><a>
                                        ` + x.col_frst_name + ' ' + x.col_last_name + `</a>
                                    </td>
                                    <td>` + x.col_empl_type + `</td>
                                    <td>` + x.col_empl_posi + `</td>
                                    <td style="display:none;">` + cut_off_period_text + `</td>
                                    </tr>
                            `); //<img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`/user_images/`+empl_img+`">&nbsp;&nbsp;
                        })
                    })
                })
            })
            function write_text(doc,x,y,text){
                if(!text){
                    text='-';
                }
              return doc.text(text,x,y,{ align: 'right' });
            }
            function write_description(doc,x,y,text){
      
              return doc.text(x,y,text);
            }
            async function getPayslipData(id) {
                  try {
                    const data = await $.ajax({
                      url: '<?=base_url()?>payrolls/getPayslipData/'+id,
                      method: 'GET',
                      dataType: 'json'
                    });
                    return data;
                  } catch (error) {
                    console.error(error);
              }
            }


            $('.btn-generate_payslip_pdf').on('click',function(){
               
                var x_coor=0;
                var y_coor=0;
                var increment_by=0;

                var payslip_id=$(this).attr('payslip_id');
                getPayslipData(payslip_id)
                .then(res=>{
                let record=res[0];
                console.log(record)
                var pdfImage    ="<?=base64_encode(file_get_contents(base_url('assets_system/forms/user_payslip.png')))?>"
                var doc         = new jsPDF('l', 'mm', 'a5');
                var width       = doc.internal.pageSize.width;
                var height      = doc.internal.pageSize.height;
                var dateData    = "<?=date('M d Y')?>"
            
                
                doc.addImage("data:image/png;base64,"+pdfImage,'PNG',0,0,width,height);
          
                doc.setFontSize(8);
                
                xcoor = 35;
                ycoor = 24.9;
                increment_by=4.5;

                doc.text(xcoor, ycoor+=increment_by,record.col_empl_cmid);
                doc.text(xcoor, ycoor+=increment_by,record.col_last_name+' '+record.col_frst_name+' '+record.col_midl_name);
                doc.text(xcoor, ycoor+=increment_by,record.position);
                doc.text(xcoor, ycoor+=increment_by,record.department);

                xcoor = 105.5;
                ycoor = 24.9;
                doc.text(xcoor, ycoor+=increment_by,record.PAYSLIP_PERIOD);
                doc.text(xcoor, ycoor+=increment_by,dateData);
                doc.text(xcoor, ycoor+=increment_by,record.salary_type);
                doc.text(xcoor, ycoor+=increment_by,record.TOT_PRESENT);
                
                xcoor = 135;
                doc.text(xcoor, ycoor,'month');

                xcoor = 169;
                ycoor = 24.9;
                doc.text(xcoor, ycoor+=increment_by,record.ID_TIN);
                doc.text(xcoor, ycoor+=increment_by,record.ID_SSS);
                doc.text(xcoor, ycoor+=increment_by,record.ID_PAGIBIG);
                doc.text(xcoor, ycoor+=increment_by,record.ID_PHILHEALTH);

         
                ycoor_1=54;
                xcoor_1_1=8;
                xcoor_1_2=46;
                xcoor_1_3=82;
                increment_by=3.7;
                let description_1=[  'Regular Pay','Paid Leave','Regular','Regular OT','Regular ND','Regular NDOT','Rest','Rest OT','Rest ND','Rest NDOT','Legal Holiday','Legal OT','Legal ND','Legal NDOT','Legal Rest Holiday','Legal Rest OT','Legal Rest ND','Legal Rest NDOT','Special Hours','Special OT','Special ND','Special NDOT','Special Rest Holiday','Special Rest OT','Special Rest ND','Special Rest NDOT',
                                 ];
                let count_1=[  0,record.COUNT_PAID_LEAVE,record.COUNT_REG_HOURS,record.COUNT_REG_OT,record.COUNT_REG_ND,record.COUNT_REG_NDOT,record.COUNT_REST_HOURS,record.COUNT_REST_OT,record.COUNT_REST_ND,record.COUNT_REST_NDOT,record.COUNT_LEG_HOURS,record.COUNT_LEG_OT,record.COUNT_LEG_ND,record.COUNT_LEG_NDOT,record.COUNT_LEGREST_HOURS,record.COUNT_LEGREST_OT,record.COUNT_LEGREST_ND,record.COUNT_LEGREST_NDOT,record.COUNT_SPE_HOURS,record.COUNT_SPE_OT,record.COUNT_SPE_ND,record.COUNT_SPE_NDOT,record.COUNT_SPEREST_HOURS,record.COUNT_SPEREST_OT,record.COUNT_SPEREST_ND,record.COUNT_SPEREST_NDOT,
];
                let unit_1=[  0,'hr','hr','hr','hr','hr','hr','hr','hr','hr','hr','hr','hr','hr','hr','hr','hr','hr','hr','hr','hr','hr','hr','hr','hr','hr'];
                let tot_1=[ record.TOT_PRESENT,record.TOT_PAID_LEAVE,record.TOT_REG_HOURS,record.TOT_REG_OT,record.TOT_REG_ND,record.TOT_REG_NDOT,record.TOT_REST_HOURS,record.TOT_REST_OT,record.TOT_REST_ND,record.TOT_REST_NDOT,record.TOT_LEG_HOURS,record.TOT_LEG_OT,record.TOT_LEG_ND,record.TOT_LEG_NDOT,record.TOT_LEGREST_HOURS,record.TOT_LEGREST_OT,record.TOT_LEGREST_ND,record.TOT_LEGREST_NDOT,record.TOT_SPE_HOURS,record.TOT_SPE_OT,record.TOT_SPE_ND,record.TOT_SPE_NDOT,record.TOT_SPEREST_HOURS,record.TOT_SPEREST_OT,record.TOT_SPEREST_ND,record.TOT_SPEREST_NDOT,
                ];

                size_length = description_1.length;
                for(let i=0;i<size_length;i++){
                    if(tot_1[i] != '0.00'){
                     doc.text(xcoor_1_1,ycoor_1,description_1[i], {align: 'left'});

                     if(count_1[i] != '0'){
                        doc.text(xcoor_1_2,ycoor_1,count_1[i], {align: 'right'});
                        doc.text(xcoor_1_2+2,ycoor_1,unit_1[i], {align: 'left'});
                     }
                     doc.text(xcoor_1_3,ycoor_1,tot_1[i], {align: 'right'});
                     ycoor_1+=increment_by;
                    }        
                }

                ycoor_2=54;
                xcoor_2_1=85;
                xcoor_2_2=129;
                xcoor_2_3=159;
                increment_by=3.7;
                let description_2=[ 'Absent','Tardiness','Undertime','Withholding Tax','SSS','Pag-ibig','Philhealth'];
                let count_2=[  record.COUNT_ABSENT,record.COUNT_TARDINESS,record.COUNT_UNDERTIME,0,0,0,0];
                let unit_2=[ 'hr','hr','hr',0,0,0,0];
                let tot_2=[  record.TOT_ABSENT,record.TOT_TARDINESS,record.TOT_UNDERTIME,record.WTAX,record.SSS_EE_CURRENT,record.PAGIBIG_EE_CURRENT,record.PHILHEALTH_EE_CURRENT];
                
                
                loan_list_raw = record.LOAN_LIST;
                loan_list_replaced = loan_list_raw.replace(/@/g,"\"");
                loan_list_decode = JSON.parse(loan_list_replaced);

                for(let i=0;i<loan_list_decode.length;i++){
                    description_2.push(loan_list_decode[i].loan_name);
                    count_2.push(0);
                    tot_2.push(loan_list_decode[i].contrib);
                }

                ca_list_raw = record.CA_LIST;
                ca_list_replaced = ca_list_raw.replace(/@/g,"\"");
                ca_list_decode = JSON.parse(ca_list_replaced);

                for(let i=0;i<ca_list_decode.length;i++){
                    description_2.push(ca_list_decode[i].loan_name);
                    count_2.push(0);
                    tot_2.push(ca_list_decode[i].contrib);
                }

                deduct_list_raw = record.DEDUCT_LIST;
                deduct_list_replaced = deduct_list_raw.replace(/@/g,"\"");
                deduct_list_decode = JSON.parse(deduct_list_replaced);

                for(let i=0;i<deduct_list_decode.length;i++){
                    description_2.push(deduct_list_decode[i].loan_name);
                    count_2.push(0);
                    tot_2.push(deduct_list_decode[i].contrib);
                }
           

                size_length = description_2.length;
                for(let i=0;i<size_length;i++){
                    if(tot_2[i] != '0.00'){
                     doc.text(xcoor_2_1,ycoor_2,description_2[i], {align: 'left'});

                     if(count_2[i] != '0'){
                        doc.text(xcoor_2_2,ycoor_2,count_2[i], {align: 'right'});
                        doc.text(xcoor_2_2+2,ycoor_2,unit_2[i], {align: 'left'});
                     }
                     doc.text(xcoor_2_3,ycoor_2,tot_2[i], {align: 'right'});
                     ycoor_2+=increment_by;
                    }        
                }

                ycoor_3=54;
                xcoor_3_1=162;
                xcoor_3_2=201;
                increment_by=3.7;
                let description_3=['SSS','Pag-ibig','Philhealth'];
                let tot_3=[ record.SSS_ER_CURRENT,record.PAGIBIG_ER_CURRENT,record.PHILHEALTH_ER_CURRENT];

                size_length = description_3.length;
                for(let i=0;i<size_length;i++){
                    if(tot_3[i] != '0.00'){
                     doc.text(xcoor_3_1,ycoor_3,description_3[i], {align: 'left'});
                     doc.text(xcoor_3_2,ycoor_3,tot_3[i], {align: 'right'});
                     ycoor_3+=increment_by;
                    }        
                }
                y_coor=132;
                x_coor=82;
                
                doc.text(x_coor,y_coor,record.EARNINGS, {align: 'right'});

                x_coor=159;
                doc.text(x_coor,y_coor,record.DEDUCTIONS, {align: 'right'});

                x_coor=201;
                doc.text(x_coor,y_coor,record.NET_INCOME, {align: 'right'});

                window.open(doc.output('bloburl'), '_blank');
                })

                
            })
            // GET EMPLOYEES NOT READY FOR PAYSLIP
            get_employee_not_ready_for_payslip(url_get_employee_not_ready_for_payslip, cut_off_period_text, payroll_id).then(data => {
                console.log(data);
                $('#container_employees_not_ready_for_payslip').html('');
                data.empl_not_ready_for_payslip.forEach(function(id) {
                    // console.log(id);
                    getEmployeeData(url3, id.id).then(data1 => {
                        data1.employee_data.forEach(function(x) {
                      
                            $('#container_employees_not_ready_for_payslip').append(`
                                <tr class="payslip_row">
                                    <td>` + x.col_empl_cmid + `</td>
                                    <td><a>&nbsp;&nbsp;` + x.col_frst_name + ' ' + x.col_last_name + `</a>
                                    </td>
                                    <td>` + x.col_empl_type + `</td>
                                    <td>` + x.col_empl_posi + `</td>zzz
                                    <td style="display:none;">` + cut_off_period_text + `</td>
                                </tr>
                            `); 
                        })
                    })
                })
            })
           
            $('#date_period').change(function(e) {
                var date_period_id_value = $(this).val();
                var date_db_name = $('#date_period option:selected').attr('db_date');
                var date_period_text = $('#date_period option:selected').text();
                $('#generate_all_pdf').prop('disabled', true);
                $('#download_csv').attr('cutoff_id', date_period_id_value);
                // clear container before appending
                $('#container_employees_ready_for_payslip').html('');
                $('#container_employees_not_ready_for_payslip').html('');
                $('#payroll_data_container').html('');
                // GET EMPLOYESS READY FOR PAYSLIP
                get_employees_ready_for_payslip(url_get_employees_ready_for_payslip, date_db_name, date_period_id_value).then(data => {
                    
                    $('#container_employees_ready_for_payslip').html('');
                    data.empl_ready_for_payslip.forEach(function(id) {
                        getEmployeeData(url3, id).then(data1 => {
                            data1.employee_data.forEach(function(x) {
                                var empl_img = 'default_profile_img3.png';
                                if (x.col_imag_path) {
                                    empl_img = x.col_imag_path;
                                }
                                $('#container_employees_ready_for_payslip').append(`
                                    <tr class="payslip_row">
                                        <td>` + x.col_empl_cmid + `</td>
                                        <td><a>
                                            ` + x.col_frst_name + ' ' + x.col_last_name + `</a>
                                        </td>
                                        <td>` + x.col_empl_type + `</td>
                                        <td>` + x.col_empl_posi + `</td>
                                        <td style="display:none;">` + cut_off_period_text + `</td>
                                    </tr>
                                `); //<img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`/user_images/`+empl_img+`">&nbsp;&nbsp;
                            })
                        })
                    })
                    $('#label_ready_for_payslip').html(data.count);
                })
                // GET EMPLOYEES NOT READY FOR PAYSLIP
                get_employee_not_ready_for_payslip(url_get_employee_not_ready_for_payslip, date_db_name, date_period_id_value).then(data => {
                    $('#container_employees_not_ready_for_payslip').html('');
                    data.empl_not_ready_for_payslip.forEach(function(id) {
                        getEmployeeData(url3, id).then(data1 => {
                            data1.employee_data.forEach(function(x) {
                                var empl_img = 'default_profile_img3.png';
                                if (x.col_imag_path) {
                                    empl_img = x.col_imag_path;
                                }
                                $('#container_employees_not_ready_for_payslip').append(`
                                    <tr class="payslip_row">
                                        <td>` + x.col_empl_cmid + `</td>
                                        <td><a>
                                            ` + x.col_frst_name + ' ' + x.col_last_name + `</a>
                                        </td>
                                        <td>` + x.col_empl_type + `</td>
                                        <td>` + x.col_empl_posi + `</td>
                                        <td style="display:none;">` + cut_off_period_text + `</td>
                                    </tr>
                                `); //<img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`/user_images/`+empl_img+`">&nbsp;&nbsp;
                            })
                        })
                    })
                    $('#label_not_ready_for_payslip').html(data.count);
                })
                  
           
            })
            $('#btn_export_payroll_data').click(function() {
                var table_id = 'tbl_payroll_data';
                var separator = ',';
                // Select rows from table_id
                var rows = document.querySelectorAll('table#' + table_id + ' tr');
                // Construct csv
                var csv = [];
                for (var i = 0; i < rows.length; i++) {
                    var row = [],
                        cols = rows[i].querySelectorAll('td, th');
                    for (var j = 0; j < cols.length; j++) {
                        // Clean innertext to remove multiple spaces and jumpline (break csv)
                        var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
                        // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
                        data = data.replace(/"/g, '""');
                        // Push escaped string
                        row.push('"' + data + '"');
                    }
                    csv.push(row.join(separator));
                }
                var csv_string = csv.join('\n');
                // Download it
                var filename = 'Export_Payroll_Data.csv';
                var link = document.createElement('a');
                link.style.display = 'none';
                link.setAttribute('target', '_blank');
                link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
                link.setAttribute('download', filename);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            })
            // DELETE PAYSLIP
            $('.btn_delete_payslip').click(function(e) {
                e.preventDefault();
                var payslip_id = $(this).attr('payslip_id');
                var empl_cmid = $(this).attr('empl_cmid');
                var date_period = $('#date_period option:selected').text();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?= base_url(); ?>payrolls/delete_payslip_data?payslip_id=" + payslip_id + "&date_period=" + date_period + "&empl_cmid=" + empl_cmid;
                    }
                })
            })
          
            $('#delete_all_payslips').click(function(e) {
                e.preventDefault();
                let selected_checkbox   =$('.select_payslip');
                let payslip_params      =[];
                let selection           =false;
                
                selected_checkbox.each(function(index) {
                    // Do something with each element here
                    if ($(selected_checkbox[index]).prop("checked")) {
                        // Checkbox is checked
                        console.log('sadas');
                        payslip_params.push($(selected_checkbox[index]).attr('payslip_id'));
                        selection=true;
                    } 
                });
                $('input#payslip_ids').val(payslip_params.join(','))
                if(selection==true){
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#form_bulk_delete').submit();
                            }
                        })
                }else{
                    Swal.fire(
                      'Warning',
                      'No payslip selected!',
                      'warning'
                    )
                }
 
               
            })
     
            
            // BUTTON TOGGLE GENERATE PDF MODAL
            $('#generate_all_pdf').click(function(e) {
                e.preventDefault();
                $('#modal_select_empl_pdf').modal('toggle');
            })
            async function get_all_payroll_data_by_3s(url, payroll_id1, payroll_id2, payroll_id3) {
                var formData = new FormData();
                formData.append('payroll_id1', payroll_id1);
                formData.append('payroll_id2', payroll_id2);
                formData.append('payroll_id3', payroll_id3);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_payslip_data_based_on_period(url, cutoff_id) {
                var formData = new FormData();
                formData.append('cutoff_id', cutoff_id);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_empl_leave_data(url, empl_id) {
                var formData = new FormData();
                formData.append('empl_id', empl_id);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_payslip_data(url, payroll_id) {
                var formData = new FormData();
                formData.append('payroll_id', payroll_id);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function generated_payslip_count(url, payroll_id) {
                var formData = new FormData();
                formData.append('payroll_id', payroll_id);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function getEmployeeData(url, employee_id) {
                var formData = new FormData();
                formData.append('employee_id', employee_id);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            // ============================ display empl with payslips, ready for payslip, not ready for payslip =============================
            async function get_employees_ready_for_payslip(url, payroll_date, payroll_id) {
                var formData = new FormData();
                formData.append('payroll_date', payroll_date);
                formData.append('payroll_id', payroll_id);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            
            async function get_employee_not_ready_for_payslip(url, payroll_date, payroll_id) {
                var formData = new FormData();
                formData.append('payroll_date', payroll_date);
                formData.append('payroll_id', payroll_id);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            
            async function get_employee_all_ampl_data(url, employee_id) {
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
    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <script>
    // document.getElementById("btn_export").addEventListener('click', function() {
    //   /* Create worksheet from HTML DOM TABLE */
    //   var wb = XLSX.utils.table_to_book(document.getElementById("tbl_payslip"));
    //   /* Export to file (start a download) */
    //   XLSX.writeFile(wb, "Payslip.xlsx");
    // });
  </script>
</body>
</html>