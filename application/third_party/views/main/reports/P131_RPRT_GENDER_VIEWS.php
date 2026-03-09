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
    #unbold{
        font-weight: normal;
    }
    .num{
        font-size: 22px;
        margin-bottom: 10px;
        font-weight: bold;
    }
    .t-num{
        font-size: 17px;
        font-weight: bold;
        color: #aeaeae;
    }
</style>

<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
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
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style = "background-color: transparent; padding: 0px;">
                    <li class="breadcrumb-item"><a href="#">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Gender Profile</li>
                </ol>
            </nav>
            <div class = "row">
                <div class = "col-md-6">
                    <h1><b>Gender Profile</b></h1>
                </div>
                <div class = "col-md-6" style = "text-align: right;">
                <button type ="button" class = "btn btn-primary shadow-none"><i class="fas fa-plus"></i> Export</button>
                </div>
            </div>
            <p>Report on the gender diverisifcation of your company</p>
            <div class = "card border-0">
                <div class = "row">
                    <div class = "col-md-4">
                        <div class="form-group">
                            <label id = "unbold">Positions</label>
                            <input type="text" class="form-control" id="" placeholder="Positions">
                        </div>
                    </div>
                    <div class = "col-md-4">
                        <div class="form-group">
                            <label id = "unbold">Departments</label>
                            <input type="text" class="form-control" id="" placeholder="Deparments">
                        </div>
                    </div>
                    <div class = "col-md-4">
                        <div class="form-group">
                            <label id = "unbold">Divisions</label>
                            <input type="text" class="form-control" id="" placeholder="Divisions">
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-md-6">
                        <div class="form-group">
                            <label id = "unbold">Locations</label>
                            <input type="text" class="form-control" id="" placeholder="Locations">
                        </div>
                    </div>
                    <div class = "col-md-6">
                        <div class="form-group">
                            <label id = "unbold">Employment Types</label>
                            <input type="text" class="form-control" id="" placeholder="Employment Types">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type = "button" class = "btn btn-primary">Filter</button>
                </div>
            </div>
            <div class = "row">
                <div class = "col">
                    <div class="card" style = "padding: 40px 30px;">
                        <div class="chart mt-2">
                        <canvas id="myChart1" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "row">
                <div class = "col">
                     Displaying 1 - 9 of 9 in total 
                </div>
            </div>
            <div class = "card border-0 mt-2" style = "padding: 0px; magin: 0px">
                <div style="overflow-x:auto;">
                    <table class = "table table-hover">
                        <tr>
                        <td>Full Name</td>
                        <td>Employment Type</td>
                        <td>Position</td>
                        <td>Department</td>
                        <td>Location</td>
                        <td>Reporting To</td>
                        </tr>
                        <tr>
                            <td><a href = "P020_EMPLIST_VIEWS/P021_EMPINFO_PERSONAL_VIEWS">
                            Bernier Mallie</a>
                            </td>
                            <td>Contractor</td>
                            <td>Accountant</td>
                            <td>Finance</td>
                            <td>Melbourne</td>
                            <td>Kuhic Hugh</td>
                        </tr>
                        <tr>
                            <td><a href = "P020_EMPLIST_VIEWS/P021_EMPINFO_PERSONAL_VIEWS">Cruz Arnold</a></td>
                            <td>Part-Time</td>
                            <td>HR Specialist</td>
                            <td>IT</td>
                            <td>Remote Workers</td>
                            <td>Dela Cruz Juan</td>
                        </tr>
                    </table>
                </div>
            </div>
            <nav aria-label="...">
                <ul class="pagination">
                    <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active">
                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
	</div>

	<aside class="control-sidebar control-sidebar-dark">
	</aside>
	<script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <script>
        Chart.defaults.global.defaultFontColor = 'black';
	
	let labels1 = ['Male', 'Female', 'Not Specified'];
	let data1 = ['3', '5', '1'];
	let colors1 = ['#434348','#7cb5ec','#90ed7d'];

	let myChart1 = document.getElementById("myChart1").getContext('2d');

	let chart1 = new Chart(myChart1, {
		type: 'pie',
		data: {
			labels: labels1,
			datasets: [ {
				data: data1,
				backgroundColor: colors1
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
            legend: {
			  display: false
			},
		}
	});
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
