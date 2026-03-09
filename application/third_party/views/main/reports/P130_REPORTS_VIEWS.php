<style>
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
        float: left;
        padding-right: 20px;
    }
    .profile-disc{
        margin-left: 100px;
    }
    .profile-name{
        font-weight: bold;
        font-size:16px;
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
    .upload-div{
        position: absolute;
        width: 250px;
        background-color: ;
        height: 300px;
    }
    #formFile{
        padding: 10px 15px -20px 10px;
    }
    .photo{
        text-align: center;
        padding: 10px;
    }
    .firstFields{
        margin-left: 250px; 
        max-width: auto;
    }
    @media (max-width: 900px) {
        .upload-div{
            position: relative;
            width: 100%;
            background-color: ;
            height: 250px;
        }
        .firstFields{
            margin-left: 0px;

        }
        #myTab{
            margin-left: 0px;
        }
    }
    .nav-tabs > li > a{
    	background-color: none;
		color: black;
		border: 0px;
        font-size: 14px;
    }
    .nav-tabs > li > a:hover{
    	background-color: white;
		border: 0px;
    }
    .nav-tabs>li.active>a, 
	.nav-tabs>li.active>a:focus, 
	.nav-tabs>li.active>a:hover {
		border: 0;
    }
    .nav-tabs {
	  border-bottom: 0px solid transparent;
      padding-right: 15px;
	}
	.nav-tabs .nav-link {
	  border: 0px solid transparent;
	}
	.nav-tabs>li.active{
		border-color: #1279bf;
		border-bottom-style: solid;
	}
    .profile-pic{
        text-align: center;
        margin-bottom: 10px;
    }
    .emp-name{
        font-size: 20px;
    }
    .nav-top{
        width: 100%;
        overflow: hidden;
        background-color: white;
    }
    .nav-top a{
        padding: 13px 27px;
        display: block;
        float: left;
        margin-left: 20px;
        color: black;
    }
    .nav-top a:hover{
        
    }
    .nav-top .top-right{
        float: none;
        margin-right: 20px;
        display: block;
    }
    .time-off{
        background-color:;
        padding: 5px;
    }
    .time-off-text{
        background-color: #e1e1e1;
        padding: 3px 8px;
        border-radius: 15px;
    }
    .emp-stat{
        padding: 7px 10px;
        display: block;
    }
    .emp-stat{
        list-style-type: none;
        padding: 7px 0px;
        display: block;
        margin-bottom: -10px;
    }
    .emp-stat .stats{
       display: block;
       display: inline-block;
    }
    .scrollmenu{
        width: 800px;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
    }
    .modal-btn{
        display: flex;
        float: right;
        font-size: 22px;
    }
    .stats-icn{
        width: 20px;
        text-align: center;
        display: inline-block;
        margin-right: 5px;
        margin-bottom: 10px;
    }
    .stats{
        display: inline-block;
        word-break: break-all;
    }
    table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
    }
    th, td {
    text-align: left;
    padding: 8px;
    font-weight: normal;
    }

    tr:nth-child(even){background-color: #f2f2f2}
    .list-div{
        padding: 10px 10px;
        padding-left: 20px;
        display: block;
    }
    .list-div:hover{
        background-color: #f3f3f3;
    }
    .report-title{
        font-size: 17px;
        padding: 3px;
        color: #212F3D;
        font-weight: bold;
    }
    .report-disc{
        padding: 3px;
        color: #a1a1a1;
    }
</style>

<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<div class="content-wrapper">
        <div class="navbar navbar-expand-md py-0" style="margin-top: -5px; background-color: #fff;padding-left: 0px;">
        	<div class="container-fluid">
          		<div class="navbar-collapse ">
              		<ul class="nav navbar-nav list-group list-group-horizontal">
    					<li class="nav-item py-2 px-1 nav_item_active">
      						<a class="nav-link nav_pill active py-0"  href="#">Standard Reports</a>
						</li>
						<li class="nav-item py-2 px-1" style="margin-top: 0; border: none;">
							<a class="nav-link nav_pill py-0" href="#" style="color: #213148;">
							My Reports
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container-fluid p-4">
            <div class = "row">
                <div class = "col-md-6">
                    <h1><b>Reports</b>&nbsp;&nbsp;<span class="text-danger text-bold" style="font-size: 20px !important;">(Under Development)</span></h1>
                </div>
                <div class = "col-md-6" style = "text-align: right;">
                <button type ="button" class = "btn btn-primary shadow-none"><i class="fas fa-plus"></i> New</button>
                </div>
            </div>
            <div class = "card border-0" style = "padding: 0px;">
                <div style = "margin:10px 0px;">
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Security Audit</div>
                            <div class = "report-disc">Security audit of your employee and the platform.</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Tasks</div>
                            <div class = "report-disc">See the progress of task across your company.</div>
                        </div>
                    </a>
                    <a href = "<?=base_url()?>reports/report_age">
                        <div class = "list-div">
                            <div class = "report-title">Age Profile</div>
                            <div class = "report-disc">Report on the age profiles of your company.</div>
                        </div>
                    </a>
                    <a href = "<?=base_url()?>reports/report_gender">
                        <div class = "list-div">
                            <div class = "report-title">Gender Profile</div>
                            <div class = "report-disc">Report on the gender diverisification of your company.</div>
                        </div>
                    </a>
                    <a href = "<?=base_url()?>reports/report_head_count">
                        <div class = "list-div">
                            <div class = "report-title">Headcount</div>
                            <div class = "report-disc">Employee headcounts Over time.</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Termination Breakdown</div>
                            <div class = "report-disc">See the reasons why emplyees were terminated from your company.</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Years of Service </div>
                            <div class = "report-disc">What length of service bench strength does my workforce have and how does that look across organizational and demographic dimensions?</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Dependents</div>
                            <div class = "report-disc">Reports on the dependents of the employees within your company</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Custom Fields</div>
                            <div class = "report-disc">See all the custom page for each your employees</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Capacity</div>
                            <div class = "report-disc">Look at the upcoming capacity of your team members for project planning</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Employment Status History</div>
                            <div class = "report-disc">See the history of employment status changes that have occured for employees</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Job History</div>
                            <div class = "report-disc">See the history of job changes that have occured for employees</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Monthly Payroll</div>
                            <div class = "report-disc">Monthlt payroll report across employees of your company</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Salary History</div>
                            <div class = "report-disc">See the history of compensation changes that have occured for employees</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Working Hours</div>
                            <div class = "report-disc">See the actual working hours and leave taken for each employees</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Leave Used</div>
                            <div class = "report-disc">Used leaved of employees</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Leave Reports</div>
                            <div class = "report-disc">See the history of leave approved by employees</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Leave Balance</div>
                            <div class = "report-disc">See the current leave balance of employees</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Leave Policy</div>
                            <div class = "report-disc">See the leave policies used by employees</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Assets Register</div>
                            <div class = "report-disc">Report on the assests within your company and where they are assigned</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Mood</div>
                            <div class = "report-disc">Analyse how your employees are feeling overtime with their responses</div>
                        </div>
                    </a>
                    <a href = "#">
                        <div class = "list-div">
                            <div class = "report-title">Celebrations</div>
                            <div class = "report-disc">See list of employees birthdays and anniversaries</div>
                        </div>
                    </a>
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

</body>
</html>
