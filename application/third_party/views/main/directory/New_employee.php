<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
    .card {
        padding: 20px;
    }

    li a {
        color: #0D74BC;
    }

    a:hover {
        text-decoration: none;
    }

    .activity td {
        padding: 6.8px 20px;
    }

    .page-item .active {
        background-color: #0D74BC !important;
    }

    label.required:after {
        content: " *";
    }

    label.required:after {
        content: " *";
        color: red;
    }

    label {
        font-weight: 500 !important;
    }

    li a {
        font-size: 14px;
    }

    .header-elements a {
        font-size: 14px;
    }

    .list-icons a {
        font-size: 11.2px;
        color: #197fc7;
    }

    td {
        width: 100%;
        padding-bottom: 0px !important;
    }

    .profile {
        padding: 20px 0px 0px;
    }

    .profile-img {
        display: inline-block;
        float: left;
        padding-right: 20px;
    }

    .profile-disc {
        margin-left: 100px;
    }

    .profile-name {
        font-weight: bold;
        font-size: 16px;
    }

    .position {
        font-weight: bold;
        font-size: 15px;
        color: #B0B0B0;
    }

    .divider {
        margin-top: 50px;
    }

    .social-div a {
        padding: 10px 15px;
        color: #6a6a6a;
        font-size: 15px;
    }

    .label-note {
        background-color: #fde6d8;
        padding: 5px 10px;
        border-radius: 30px;
        color: #c46632;
        font-weight: bold;
        text-align: center;
        line-height: normal;
    }

    .nav-tabs>li>a {
        background-color: none;
        color: black;
        border: 0px;
        font-size: 16px;
    }

    .nav-tabs>li>a:hover {
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

    .nav-tabs>li.active {
        border-color: #1279bf;
        border-bottom-style: solid;
    }

    .col-md-2{
        width: 20% !important;
    }
</style>



<div class="content-wrapper">

    <div class="container-fluid p-4">

        <div class="flex-fill">

            <div class="row pr-3 mb-2">

                <div class="col">

                    <h1 class="page-title">New Employee</h1>
                    <h4 class="text-bold mt-4">Personal</h4>

                </div>

                <div class="col ml-auto">

                    <a class="btn btn-primary float-right" title="Add" href="<?=base_url()?>csv">

                        <i class="fas fa-fw fa-upload">
                        </i> Import CSV

                    </a>

                </div>

            </div>

            <form action="<?php echo base_url('employees/add_new_employee'); ?>" id="FORM_ADD_EMP" method="POST" accept-charset="utf-8" autocomplete='off' enctype="multipart/form-data">
                <div class="card border-0">
                    <div class="row my-4">
                        <div class="col-md-3">
                            <div class="photo w-100 text-center">
                                <img class="rounded-circle avatar" id="profileImage" width="150" height="150" src="<?= base_url() ?>images/default_user.png">
                            </div>
                            <div class="form-group mt-3">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input fileficker" id="exampleInputFile" name="employee_image" multiple="" accept=".jpg, .jpeg, .png">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 30px;">
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input type="text" class="form-control" name="mobile_num" id="mobile_num" placeholder="e.g 0907565325" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
                                </div>
                                <!-- <div class="form-group">
                                    <label>Company Phone Number</label>
                                    <input type="text" name="INPF_EMPL_COMP_PNUMBER" id="INPF_EMPL_COMP_PNUMBER" class="form-control" placeholder="e.g. 834-4000" required>
                                </div> -->
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                                    <div>
                                        <div class="form-group">
                                            <label for="">Employee ID</label>
                                            <input type="text" class="form-control" id="empl_cmid" name="empl_cmid" placeholder="Employee ID" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4">
                                                <label for="">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <label for="">Middle Name</label>
                                                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name" required>
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <label for="">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <!-- <div class="col-sm-6">
                                                <label for="">Email</label>
                                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
                                            </div> -->
                                            <!-- <div class="col-sm-6">
                                                <label for="">Company Email</label>
                                                <input type="text" class="form-control" id="INPF_EMPL_COMP_EMAIL" name="INPF_EMPL_COMP_EMAIL" placeholder="Personal Email" required>
                                            </div> -->
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label for="">Date of Birth</label>
                                                <input type="date" class="form-control" id="birthday" name="birthday" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Gender</label>
                                                <select class="custom-select mr-sm-2" id="gender" name="gender" required>
                                                    <option value="" selected>Choose...</option>
                                                    <?php foreach ($DISP_EMP_GENDER as $DISP_EMP_GENDER_ROW) { ?>
                                                        <option value="<?= $DISP_EMP_GENDER_ROW->name ?>"><?= $DISP_EMP_GENDER_ROW->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label for="">Home Address</label>
                                                <input type="text" class="form-control" id="home_address" name="home_address" placeholder="Home Address" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Current Address</label>
                                                <input type="text" class="form-control" id="current_address" name="current_address" placeholder="Current Address" required>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <label for="">Marital Status</label>
                                                <select class="custom-select mr-sm-2" id="marital_status" name="marital_status">
                                                    <option value="" selected>Choose...</option>
                                                    <?php foreach ($DISP_MRTL_STAT as $DISP_MRTL_STAT_ROW) { ?>
                                                        <option value="<?= $DISP_MRTL_STAT_ROW->name ?>"><?= $DISP_MRTL_STAT_ROW->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Nationality</label>
                                                <select class="custom-select mr-sm-2" id="nationality" name="nationality">
                                                    <option value="" selected>Choose...</option>
                                                    <?php foreach ($DISP_NATIONALITY as $DISP_NATIONALITY_ROW) { ?>
                                                        <option value="<?= $DISP_NATIONALITY_ROW->name ?>"><?= $DISP_NATIONALITY_ROW->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Shirt Size</label>
                                                <select class="custom-select mr-sm-2" id="shirt_size" name="shirt_size">
                                                    <option value="" selected>Choose...</option>
                                                    <?php foreach ($DISP_SHRT_SIZE as $DISP_SHRT_SIZE_ROW) { ?>
                                                        <option value="<?= $DISP_SHRT_SIZE_ROW->name ?>"><?= $DISP_SHRT_SIZE_ROW->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- ./tab-content -->
                        </div><!-- ./col-md-6 -->
                    </div><!-- ./row -->
                </div> <!-- ./card -->
                <h4 class="text-bold mt-4">Job</h4>
                <div class="card my-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hired_on">Hired On</label>
                                <input type="date" class="form-control" id="hired_on" name="hired_on" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Employment Type</label>
                                <select class="custom-select mr-sm-2" id="empl_type" name="empl_type" required>
                                    <option value="" selected>Choose...</option>
                                    <?php foreach ($DISP_EMP_EMPTYPES as $DISP_EMP_EMPTYPES_ROW) { ?>
                                        <option value="<?= $DISP_EMP_EMPTYPES_ROW->name ?>"><?= $DISP_EMP_EMPTYPES_ROW->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Position</label>
                                <select class="custom-select mr-sm-2" id="position" name="position" required>
                                    <option value="" selected>Choose...</option>
                                    <?php foreach ($DISP_EMP_POSITION as $DISP_EMP_POSITION_ROW) { ?>
                                        <option value="<?= $DISP_EMP_POSITION_ROW->name ?>"><?= $DISP_EMP_POSITION_ROW->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Department</label>
                                <select class="custom-select mr-sm-2" id="department" name="department" required>
                                    <option value="" selected>Choose...</option>
                                    <?php foreach ($DISP_EMP_DEPARTMENT as $DISP_EMP_DEPARTMENT_ROW) { ?>
                                        <option value="<?= $DISP_EMP_DEPARTMENT_ROW->name ?>"><?= $DISP_EMP_DEPARTMENT_ROW->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Section</label>
                                <select class="custom-select mr-sm-2" id="section" name="section" required>
                                    <option value="" selected>Choose...</option>
                                    <?php foreach ($DISP_SECTION as $DISP_SECTION_ROW) { ?>
                                        <option value="<?= $DISP_SECTION_ROW->name ?>"><?= $DISP_SECTION_ROW->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Group</label>
                                <select class="custom-select mr-sm-2" id="group" name="group" required>
                                    <option value="" selected>Choose...</option>
                                    <?php foreach ($DISP_GROUP as $DISP_GROUP_ROW) { ?>
                                        <option value="<?= $DISP_GROUP_ROW->name ?>"><?= $DISP_GROUP_ROW->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Line</label>
                                <select class="custom-select mr-sm-2" id="line" name="line" required>
                                    <option value="" selected>Choose...</option>
                                    <?php foreach ($DISP_LINE as $DISP_LINE_ROW) { ?>
                                        <option value="<?= $DISP_LINE_ROW->name ?>"><?= $DISP_LINE_ROW->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="text-bold mt-4">Salary</h4>
                <div class="card">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Salary Rate</label>
                                <input type="number" class="form-control" name="salary_rate" id="salary_rate" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Salary Type</label>
                                <select class="custom-select mr-sm-2" id="salary_type" name="salary_type" required>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Daily">Daily</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>









                <!-- <h4 class="text-bold mt-4">Access</h4>
                <div class="card my-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="CHCK_ALLOW_SELF_SERVICE" name="CHCK_ALLOW_SELF_SERVICE">
                        <label class="form-check-label" for="CHCK_ALLOW_SELF_SERVICE">
                            Allow self service access to HrCare
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="CHCK_SEND_LETTER" name="CHCK_SEND_LETTER">
                        <label class="form-check-label" for="CHCK_SEND_LETTER">
                            Send welcome letter with login instructions
                        </label>
                    </div>
                </div> -->

                <div class="form-group mt-3">
                    <button type="submit" id="BTN_EMPL_SAVE" class="btn btn-primary text-white" name="BTN_EMPL_SAVE">Save</button>
                    <div class="spinner-border text-primary" id="loading_indicator" style="display: none;"></div>
                </div>
            </form>
        </div>
    </div>
</div>

<aside class="control-sidebar control-sidebar-dark">
</aside>
<script>
    $(function() {
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
<!-- Custom File Input -->
<script src="<?php echo base_url(); ?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- Sweet Alert -->
<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
<?php
if ($this->session->userdata('SESS_ERR_INCOMPLETE')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_ERR_INCOMPLETE'); ?>',
            '',
            'warning'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_ERR_INCOMPLETE');
}
?>
<script>
    $('#contact-tab').click(function() {
        $('.otherFields').css({
            'marginTop': '200px',
        })
    })

    $('#personal-tab').click(function() {
        $('.otherFields').css({
            'marginTop': '0px',
        })
    })

    $(document).ready(function() {
        $("#profileImage").click(function(e) {
            $("#exampleInputFile").click();
        });

        function fasterPreview(uploader) {
            if (uploader.files && uploader.files[0]) {
                $('#profileImage').attr('src',
                    window.URL.createObjectURL(uploader.files[0]));
                $('.custom-file-label').text(uploader.files[0].name);
            }
        }
        $("#exampleInputFile").change(function() {
            fasterPreview(this);
        });

        $('#BTN_EMPL_SAVE').click(function(e){
            var mobile_num = $('#mobile_num').val();
            var email = $('#email').val();
            var empl_cmid = $('#empl_cmid').val();
            var last_name = $('#last_name').val();
            var middle_name = $('#middle_name').val();
            var first_name = $('#first_name').val();
            var birthday = $('#birthday').val();
            var gender = $('#gender').val();
            var home_address = $('#home_address').val();
            var current_address = $('#current_address').val();
            var empl_type = $('#empl_type').val();
            var position = $('#position').val();
            var department = $('#department').val();
            var section = $('#section').val();
            var group = $('#group').val();
            var line = $('#line').val();
            var salary_rate = $('#salary_rate').val();
            var salary_type = $('#salary_type').val();

            if(mobile_num && email && empl_cmid && last_name && middle_name && first_name && birthday && gender && home_address && current_address && empl_type && position && department && section && group && line && salary_rate && salary_type){
                $(this).hide();
                $('#loading_indicator').show();
            }
        })
    })
</script>
</body>

</html>