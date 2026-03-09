<?php $this->load->view('templates/css_link'); ?>
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

    .col-md-2 {
        width: 20% !important;
    }
</style>

<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="flex-fill">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>employees">Employees</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>employees/directories">Employee Directory</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">New Employee
                    </li>
                </ol>
            </nav>

            <div class="row pr-3 mb-2">
                <div class="col">
                    <h1 class="page-title">New Employee</h1>
                </div>
            </div>
            <hr>

            <h4 class="page-title mt-4" style="font-size:25px;">Personal</h4>
            <form action="<?php echo base_url('employees/add_new_employee'); ?>" id="FORM_ADD_EMP" method="POST" accept-charset="utf-8" autocomplete='off' enctype="multipart/form-data">
                <div class="card border-0">
                    <div class="row my-4">
                        <div class="col-md-3">
                            <div class="photo w-100 text-center">
                                <img class="rounded-circle avatar" id="profileImage" width="150" height="150" src="<?= base_url() ?>assets_system/images/default_user.jpg">
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
                                    <label>Mobile Number <span style="color:red;">*</span></label>
                                    <input type="number" class="form-control" name="mobile_num" id="mobile_num" placeholder="e.g 0907565325" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Email <span style="color:red;">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                                    <div>
                                        <div class="form-group">
                                            <label for="">Employee ID <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" id="empl_cmid" name="empl_cmid" placeholder="Employee ID" required>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 col-sm-4">
                                                <label for="">Last Name <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
                                            </div>

                                            <div class="col-md-4 col-sm-4">
                                                <label for="">First Name <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
                                            </div>

                                            <div class="col-md-4 col-sm-4">
                                                <label for="">Middle Name <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name" required>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label for="">Date of Birth <span style="color:red;">*</span></label>
                                                <input type="date" class="form-control" id="birthday" name="birthday" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="">Gender <span style="color:red;">*</span></label>
                                                <select class="custom-select mr-sm-2" id="gender" name="gender" required>
                                                    <option value="" selected>Choose...</option>
                                                    <?php foreach ($DISP_EMP_GENDER as $DISP_EMP_GENDER_ROW) { ?>
                                                        <option value="<?= $DISP_EMP_GENDER_ROW->id ?>"><?= $DISP_EMP_GENDER_ROW->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label for="">Home Address <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" id="home_address" name="home_address" placeholder="Home Address" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="">Current Address <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" id="current_address" name="current_address" placeholder="Current Address" required>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <label for="">Marital Status <span style="color:red;">*</span></label>
                                                <select class="custom-select mr-sm-2" id="marital_status" name="marital_status" required>
                                                    <option value="" selected>Choose...</option>
                                                    <?php foreach ($DISP_MRTL_STAT as $DISP_MRTL_STAT_ROW) { ?>
                                                        <option value="<?= $DISP_MRTL_STAT_ROW->id ?>"><?= $DISP_MRTL_STAT_ROW->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="">Nationality <span style="color:red;">*</span></label>
                                                <select class="custom-select mr-sm-2" id="nationality" name="nationality" required>
                                                    <option value="" selected>Choose...</option>
                                                    <?php foreach ($DISP_NATIONALITY as $DISP_NATIONALITY_ROW) { ?>
                                                        <option value="<?= $DISP_NATIONALITY_ROW->id ?>"><?= $DISP_NATIONALITY_ROW->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="">Shirt Size <span style="color:red;">*</span></label>
                                                <select class="custom-select mr-sm-2" id="shirt_size" name="shirt_size" required>
                                                    <option value="" selected>Choose...</option>
                                                    <?php foreach ($DISP_SHRT_SIZE as $DISP_SHRT_SIZE_ROW) { ?>
                                                        <option value="<?= $DISP_SHRT_SIZE_ROW->id ?>"><?= $DISP_SHRT_SIZE_ROW->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="page-title mt-4" style="font-size:25px;">Job</h4>
                <div class="card my-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hired_on">Hired On <span style="color:red;">*</span></label>
                                <input type="date" class="form-control" id="hired_on" name="hired_on" placeholder="" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Employment Type <span style="color:red;">*</span></label>
                                <select class="custom-select mr-sm-2" id="empl_type" name="empl_type" required>
                                    <option value="" selected>Choose...</option>
                                    <?php foreach ($DISP_EMP_EMPTYPES as $DISP_EMP_EMPTYPES_ROW) { ?>
                                        <option value="<?= $DISP_EMP_EMPTYPES_ROW->id ?>"><?= $DISP_EMP_EMPTYPES_ROW->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <br><br>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Position <span style="color:red;">*</span></label>
                                <select class="custom-select mr-sm-2" id="position" name="position" required>
                                    <option value="" selected>Choose...</option>
                                    <?php foreach ($DISP_EMP_POSITION as $DISP_EMP_POSITION_ROW) { ?>
                                        <option value="<?= $DISP_EMP_POSITION_ROW->id ?>"><?= $DISP_EMP_POSITION_ROW->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col" <?php echo ($DISP_VIEW_DEPARTMENT ? "" : "hidden") ?>>
                            <div class="form-group">
                                <label for="">Department <span style="color:red;">*</span></label>
                                <select class="custom-select mr-sm-2" id="department" name="department" <?php echo ($DISP_VIEW_DEPARTMENT ? "required" : "") ?>>
                                    <option value="" selected>Choose...</option>
                                    <?php foreach ($DISP_EMP_DEPARTMENT as $DISP_EMP_DEPARTMENT_ROW) { ?>
                                        <option value="<?= $DISP_EMP_DEPARTMENT_ROW->id ?>"><?= $DISP_EMP_DEPARTMENT_ROW->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col" <?php echo ($DISP_VIEW_SECTION ? "" : "hidden") ?>>
                            <div class="form-group">
                                <label for="">Section <span style="color:red;">*</span></label>
                                <select class="custom-select mr-sm-2" id="section" name="section" <?php echo ($DISP_VIEW_SECTION ? "required" : "") ?>>
                                    <option value="" selected>Choose...</option>
                                    <?php foreach ($DISP_SECTION as $DISP_SECTION_ROW) { ?>
                                        <option value="<?= $DISP_SECTION_ROW->id ?>"><?= $DISP_SECTION_ROW->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col" <?php echo ($DISP_VIEW_GROUP ? "" : "hidden") ?>>
                            <div class="form-group">
                                <label for="">Group <span style="color:red;">*</span></label>
                                <select class="custom-select mr-sm-2" id="group" name="group" <?php echo ($DISP_VIEW_GROUP ? "required" : "") ?>>
                                    <option value="" selected>Choose...</option>
                                    <?php foreach ($DISP_GROUP as $DISP_GROUP_ROW) { ?>
                                        <option value="<?= $DISP_GROUP_ROW->id ?>"><?= $DISP_GROUP_ROW->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col" <?php echo ($DISP_VIEW_LINE ? "" : "hidden") ?>>
                            <div class="form-group">
                                <label for="">Line <span style="color:red;">*</span></label>
                                <select class="custom-select mr-sm-2" id="line" name="line" <?php echo ($DISP_VIEW_LINE ? "required" : "") ?>>
                                    <option value="" selected>Choose...</option>
                                    <?php foreach ($DISP_LINE as $DISP_LINE_ROW) { ?>
                                        <option value="<?= $DISP_LINE_ROW->id ?>"><?= $DISP_LINE_ROW->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="page-title mt-4" style="font-size:25px;">Salary</h4>
                <div class="card">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Salary Rate <span style="color:red;">*</span></label>
                                <input type="number" class="form-control" name="salary_rate" id="salary_rate" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Salary Type <span style="color:red;">*</span></label>
                                <select class="custom-select mr-sm-2" id="salary_type" name="salary_type" required>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Daily">Daily</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" id="btn_empl_save" class="btn btn-primary text-white" name="BTN_EMPL_SAVE">Save</button>
                    <div class="spinner-border text-primary" id="loading_indicator" style="display: none;"></div>
                </div>
            </form>
        </div>
    </div>
</div>

<aside class="control-sidebar control-sidebar-dark"> </aside>

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>
<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js"></script>
<script src="<?php echo base_url(); ?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
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
        
        $('#BTN_EMPL_SAVE').click(function(e) {
            var mobile_num      = $('#mobile_num').val();
            var email           = $('#email').val();
            var empl_cmid       = $('#empl_cmid').val();
            var last_name       = $('#last_name').val();
            var middle_name     = $('#middle_name').val();
            var first_name      = $('#first_name').val();
            var birthday        = $('#birthday').val();
            var gender          = $('#gender').val();
            var home_address    = $('#home_address').val();
            var current_address = $('#current_address').val();
            var empl_type       = $('#empl_type').val();
            var position        = $('#position').val();
            var department      = $('#department').val();
            var section         = $('#section').val();
            var group           = $('#group').val();
            var line            = $('#line').val();
            var salary_rate     = $('#salary_rate').val();
            var salary_type     = $('#salary_type').val();
            if (mobile_num && email && empl_cmid && last_name && middle_name && first_name && birthday && gender && home_address && current_address && empl_type && position && department && section && group && line && salary_rate && salary_type) {
                $(this).hide();
                $('#loading_indicator').show();
            }
        })
    })
</script>
</body>

</html>