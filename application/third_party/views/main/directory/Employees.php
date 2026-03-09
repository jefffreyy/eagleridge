<style>
    .card{
        padding: 10px !important;
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
    td{
        width: 100%;
        padding-bottom: 0px !important;
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
</style>

<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">

	<div class="content-wrapper">
		<div class="container-fluid p-4">
            <div class="row">
                <div class = "col-md-6">
                    <h1><b>Directory</b><h1>
                </div>
                <div class = "col-md-6" style = "text-align: right;">
                    <div class="btn-group mr-2" role="group" aria-label="First group">
                        <button type="button" class="btn btn-light"><i class="fas fa-th"></i></button>
                        <button type="button" class="btn btn-light"><i class="fas fa-bars"></i></button>
                        <button type="button" class="btn btn-light"><i class="fas fa-users"></i></button>
                        <button type="button" class="btn btn-light"><i class="fas fa-project-diagram"></i></button>
                    </div>
                    <div class = "btn-group mr-2">
                        <button type ="button" class = "btn btn-primary shadow-none"><i class="fas fa-plus"></i> Add Employee</button>
                    </div>
                    <div class = "btn-group">
                      <button type ="button" class = "btn btn-light"><i class="fas fa-ellipsis-v"></i></button>
                    </div>
                </div>
            </div>
            <div class = "row">
                <div class = "col-md-4">
                    <div class = "card" style = "background-color: #00897b; color: white;">
                        <div style = "padding: 10px 1px;">
                            <text style = "font-size: 20px; margin-bottom: -15px;">1</text><br>
                            <text><b>Onboarding</b></text>
                        </div>
                    </div>
                </div>
                <div class = "col-md-4">
                    <div class = "card" style = "background-color: #5e35b1; color: white;">
                        <div style = "padding: 10px 1px;">
                            <text style = "font-size: 20px; margin-bottom: -15px;">6</text><br>
                            <text><b>On Probation</b></text>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "row">
                <div class = "col-md-4">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1" style = "background-color: white;"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search by name, email or phone number" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class = "col-md-4">
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                        <div class="dropdown-menu" style = "width: 500px; padding: 10px 10px;">
                            <div class="form-group">
                                <input type="select-multiple" class="form-control" placeholder="Positions">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Departments">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Division">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Location">
                            </div>
                            <div class="form-group">
                                <select class="form-control">
                                <option selected>Active</option>
                                <option>All</option>
                                <option>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <a href = "#" style = "margin-left: 10px;">Advance</a>
                </div>
            </div>
            <div class = "row">
                <div class = "col">
                     Displaying 1 - 9 of 9 in total 
                </div>
            </div>
            <div class = "row mt-2">
                <div class = "col-md-4">
                    <div class = "card">
                        <div class = "profile">
                            <div class = "profile-img">
                                <img class="rounded-circle avatar " width="70" height="70" src="<?= base_url()?>user_images/hrcare_sample_img1.jpg">
                            </div>
                            <div class = "profile-disc">
                                <text class = "profile-name">Bernier Mallie</text><br>
                                <text class = "position">Accountant in Melbourne</text>
                            </div>
                            <hr class = "divider">
                            <div class = "social-div">
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="email@email.com"><i class="fas fa-envelope"></i></a>
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="1-223-334-345"><i class="fas fa-phone"></i></a>
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "col-md-4">
                    <div class = "card">
                        <div class = "profile">
                            <div class = "profile-img">
                                <img class="rounded-circle avatar " width="70" height="70" src="<?= base_url()?>user_images/hrcare_sample_img1.jpg">
                            </div>
                            <div class = "profile-disc">
                                <text class = "profile-name">Cruz Arnold</text><br>
                                <div class = "label-note">
                                    On Probition Till Dec 19, 2021
                                </div>
                                <text class = "position">HR Specialist in Remote Workers</text>
                            </div>
                            <hr class = "divider">
                            <div class = "social-div">
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="email@email.com"><i class="fas fa-envelope"></i></a>
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="1-223-334-345"><i class="fas fa-phone"></i></a>
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "col-md-4">
                    <div class = "card">
                        <div class = "profile">
                            <div class = "profile-img">
                                <img class="rounded-circle avatar " width="70" height="70" src="<?= base_url()?>user_images/hrcare_sample_img1.jpg">
                            </div>
                            <div class = "profile-disc">
                                <text class = "profile-name">Gleason Oralee</text><br>
                                <text class = "position">Accountant in London</text>
                            </div>
                            <hr class = "divider">
                            <div class = "social-div">
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="email@email.com"><i class="fas fa-envelope"></i></a>
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="1-223-334-345"><i class="fas fa-phone"></i></a>
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "col-md-4">
                    <div class = "card">
                        <div class = "profile">
                            <div class = "profile-img">
                                <img class="rounded-circle avatar " width="70" height="70" src="<?= base_url()?>user_images/hrcare_sample_img1.jpg">
                            </div>
                            <div class = "profile-disc">
                                <text class = "profile-name">Gleason Oralee</text><br>
                                <text class = "position">Accountant in London</text>
                            </div>
                            <hr class = "divider">
                            <div class = "social-div">
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="email@email.com"><i class="fas fa-envelope"></i></a>
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="1-223-334-345"><i class="fas fa-phone"></i></a>
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "col-md-4">
                    <div class = "card">
                        <div class = "profile">
                            <div class = "profile-img">
                                <img class="rounded-circle avatar " width="70" height="70" src="<?= base_url()?>user_images/hrcare_sample_img1.jpg">
                            </div>
                            <div class = "profile-disc">
                                <text class = "profile-name">Gleason Oralee</text><br>
                                <text class = "position">Accountant in London</text>
                            </div>
                            <hr class = "divider">
                            <div class = "social-div">
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="email@email.com"><i class="fas fa-envelope"></i></a>
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="1-223-334-345"><i class="fas fa-phone"></i></a>
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "col-md-4">
                    <div class = "card">
                        <div class = "profile">
                            <div class = "profile-img">
                                <img class="rounded-circle avatar " width="70" height="70" src="<?= base_url()?>user_images/hrcare_sample_img1.jpg">
                            </div>
                            <div class = "profile-disc">
                                <text class = "profile-name">Gleason Oralee</text><br>
                                <text class = "position">Accountant in London</text>
                            </div>
                            <hr class = "divider">
                            <div class = "social-div">
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="email@email.com"><i class="fas fa-envelope"></i></a>
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="1-223-334-345"><i class="fas fa-phone"></i></a>
                                <a href = "#" data-toggle="tooltip" data-placement="top" title="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
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
    
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

</body>
</html>
