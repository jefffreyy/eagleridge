<html>
<script>
      function setDefaultImage(img) {
        img.src = "<?= base_url() ?>/assets_system/images/default_user.jpg";
        img.alt = 'Default Image';
      }
</script>
<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/myinfo_views_style'); ?>
<?php
$url_count = $this->uri->total_segments();
$url_directory = $this->uri->segment($url_count);
$user_info = $this->login_model->get_user_info($this->session->userdata('SESS_USER_ID'));
$user_id = '';
$user_image = '';
$employee_id = '';
$lastname = '';
$middlename = '';
$firstname = '';
$suffix  = '';
$full_name = '';
$marital_status = '';
$home_address = '';
$current_address = '';
$birthdate = '';
$nationality = '';
$email = '';
$gender = '';
$shirt_size = '';
$mobile_number = '';
$company_number = '';
$company_email = '';
$hired_on = '';
$end_on = '';
$regularization_date = '';
$employment_type = '';
$position = '';
$section = '';
$resignation_reason = '';
$termination_reason = '';
$resignation_date = '';
$termination_date = '';
$department = '';
$division = '';
$reporting_to = '';
$group = '';
$line = '';
$activation = '';
if ($C_EMP_INFO) {
    foreach ($C_EMP_INFO as $C_EMP_INFO_ROW) {
        $user_id                = $C_EMP_INFO_ROW->id;
        $user_image             = $C_EMP_INFO_ROW->col_imag_path;
        $employee_id            = $C_EMP_INFO_ROW->col_empl_cmid;
        $firstname              = $C_EMP_INFO_ROW->col_frst_name;
        $middlename             = $C_EMP_INFO_ROW->col_midl_name;
        $lastname               = $C_EMP_INFO_ROW->col_last_name;
        $suffix                 = $C_EMP_INFO_ROW->col_suffix;
        $marital_status         = $C_EMP_INFO_ROW->col_mart_stat;
        $birthdate              = $C_EMP_INFO_ROW->col_birt_date;
        $gender                 = $C_EMP_INFO_ROW->col_empl_gend;
        $nationality            = $C_EMP_INFO_ROW->col_empl_nati;
        $shirt_size             = $C_EMP_INFO_ROW->col_shir_size;
        $mobile_number          = $C_EMP_INFO_ROW->col_mobl_numb;
        $email                  = $C_EMP_INFO_ROW->col_empl_emai;
        $home_address           = $C_EMP_INFO_ROW->col_home_addr;
        $current_address        = $C_EMP_INFO_ROW->col_curr_addr;
        $province               = $C_EMP_INFO_ROW->col_province;
        $city                   = $C_EMP_INFO_ROW->col_city;
        $barangay               = $C_EMP_INFO_ROW->col_barangay;
        // if ($middlename) {
        //     $full_name = $lastname . ', ' . $firstname . ' ' . ucfirst($middlename[0]) . '.';
        // } else {
        //     $full_name = $lastname . ', ' . $firstname;
        // }
        $lastnameSufix = $lastname;
        if ($suffix) $lastnameSufix = $lastnameSufix . ' ' . $suffix;
        $full_name = $lastnameSufix . ', ' . $firstname;
        if ($middlename) $full_name = $lastnameSufix . ', ' . $firstname . ' ' . ucfirst($middlename[0]) . '.';
        $hired_on               = $C_EMP_INFO_ROW->col_hire_date;
        $regularization_date    = $C_EMP_INFO_ROW->date_regular;
        $resignation_date       = $C_EMP_INFO_ROW->resignation_date;
        $termination_date       = $C_EMP_INFO_ROW->termination_date;
        $end_on                 = $C_EMP_INFO_ROW->col_endd_date;
        $employment_type        = $C_EMP_INFO_ROW->col_empl_type;
        $position               = $C_EMP_INFO_ROW->col_empl_posi;
        $company_emp             = $C_EMP_INFO_ROW->col_empl_company;
        $branch_emp             = $C_EMP_INFO_ROW->col_empl_branch;
        $department             = $C_EMP_INFO_ROW->col_empl_dept;
        $division               = $C_EMP_INFO_ROW->col_empl_divi;
        $section                = $C_EMP_INFO_ROW->col_empl_sect;
        $resignation_reason     = $C_EMP_INFO_ROW->resignation_reason;
        $termination_reason       = $C_EMP_INFO_ROW->termination_reason;
        $groups                 = $C_EMP_INFO_ROW->col_empl_group;
        $line                   = $C_EMP_INFO_ROW->col_empl_line;
        $team                   = $C_EMP_INFO_ROW->col_empl_team;
        $company_number         = $C_EMP_INFO_ROW->col_comp_numb;
        $company_email          = $C_EMP_INFO_ROW->col_comp_emai;
        $hmo                    = $C_EMP_INFO_ROW->col_empl_hmoo;
        $hmo_number             = $C_EMP_INFO_ROW->col_empl_hmon;
        $reporting_to           = $C_EMP_INFO_ROW->col_empl_repo;
        $activation             = $C_EMP_INFO_ROW->disabled;
        $salary_rate            = $C_EMP_INFO_ROW->salary_rate;
        $salary_type            = $C_EMP_INFO_ROW->salary_type;
        $bank                   = $C_EMP_INFO_ROW->bank_name;
        $branch                 = $C_EMP_INFO_ROW->branch_name;
        $account_type           = $C_EMP_INFO_ROW->account_type;
        $payment_type           = $C_EMP_INFO_ROW->payment_type;
        $account_number         = $C_EMP_INFO_ROW->account_number;
        $sss                    = $C_EMP_INFO_ROW->col_empl_sssc;
        $hdmf                   = $C_EMP_INFO_ROW->col_empl_hdmf;
        $philhealth             = $C_EMP_INFO_ROW->col_empl_phil;
        $tin                    = $C_EMP_INFO_ROW->col_empl_btin;
        $drivers_license        = $C_EMP_INFO_ROW->col_empl_driv;
        $national_id            = $C_EMP_INFO_ROW->col_empl_naid;
        $passport               = $C_EMP_INFO_ROW->col_empl_pass;
        $activation             = $C_EMP_INFO_ROW->disabled;
    }
}
?>
<style>
    .header-title {
        color: #008037 !important;
    }

    .hide {
        display: none;
    }



    a.btnActivate:hover {
        opacity: 1;
    }

    .img-circle {
        border-radius: 50% !important;
        width: 100px !important;
        height: 100px !important;
        object-fit: scale-down;
    }
</style>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>-->
<div class="content-wrapper">

    <div class="container-fluid p-4">

        <div class='row'>
            <div class='col-md-8'>
                <h2><a onclick="afterRenderFunction()" href="<?= base_url() . 'selfservices'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a></h2>
            </div>
        </div>
        <div class="row  d-flex justify-content-center">
            <div class="col-sm-8 card">
                <div class="p-0">
                    <div class="row d-flex justify-content-between align-items-start">
                        <div class="col d-flex  align-items-center">
                            <div class="profile-pic m-0 p-0">
                            
                                <img class="img-circle rounded-circle avatar m-3 elevation-2" onerror="setDefaultImage(this)" id="employee_img" style="cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Profile Image" src="<?php if ($user_image) {
                                                                                                                                                                                                                        echo base_url() . 'assets_user/user_profile/' . $user_image;
                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                        echo base_url() . '/assets_system/images/default_user.jpg';
                                                                                                                                                                                                                    } ?>">
                            </div>
                            <div class="col basic-profile p-3">
                                <div class="d-flex align-items-center">
                                    <text class="emp-name text-bold m-0"><?= $full_name ?></text>
                                    <?php
                                    if ($C_EMP_INFO[0]->disabled > 0) {
                                    ?>
                                        <p class="text-danger text-bold">Inactive</p>
                                    <?php
                                    } else {
                                    ?>
                                        <p class="badge badge-success d-block ml-2 mt-3">Active</p>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="emp-stat m-0 d-flex flex-column p-0">
                                    <div>
                                        <div class="stats-icn mt-1"><img style="margin-top: 3px;" src="<?= base_url('assets_system/icons/briefcase-solid.svg') ?>" alt=""></div>
                                        <div class="stats "><?= convert_id2name($C_POSITIONS, $position) ?></div>
                                    </div>
                                    <div>
                                        <div class="stats-icn pt-1"><img style="" src="<?= base_url('assets_system/icons/building.svg') ?>" alt=""></div>
                                        <div class="stats mb-1">
                                            <?php if ($C_DIVISIONS && !empty(convert_id2name($C_DIVISIONS, $division))) { ?>
                                                <span> <?= convert_id2name($C_DIVISIONS, $division) ?>
                                                    <?= !empty(convert_id2name($C_DIVISIONS, $division)) &&  !empty(convert_id2name($C_DEPARTMENTS, $department))   ? '>' : '' ?>
                                                </span>
                                            <?php } ?>
                                            <?php if ($C_DEPARTMENTS && !empty(convert_id2name($C_DEPARTMENTS, $department))) { ?>
                                                <span> <?= convert_id2name($C_DEPARTMENTS, $department) ?>
                                                    <?= !empty(convert_id2name($C_DEPARTMENTS, $department)) &&  !empty(convert_id2name($C_TEAMS, $team))   ? '>' : '' ?>
                                                </span>
                                            <?php } ?>
                                            <?php if ($C_TEAMS && !empty(convert_id2name($C_TEAMS, $team))) { ?>
                                                <span> <?= convert_id2name($C_TEAMS, $team) ?> </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="<?= base_url() ?>selfservices/change_password" class="btn btn-sm btn-primary px-3 btnActivate d-flex align-items-center" id="change_password"> <img style="width: 17px; height: 17px;" src="<?= base_url('assets_system/icons/lock-rotation-open-svgrepo-com.svg') ?>" alt=""> &nbsp;Change password</a>
                    </div>
                </div>
            </div>

            <div class="col-md-8 card p-1" id="content_container">
                <br>
                <div class="card-title pl-4 pt-0 pb-0 text-bold header-title">
                    <img style="width: 18px; height: 15.4px; margin-right: 7px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/id-card-clip-solid.svg') ?>" alt="">Personal Details
                    <!-- <a href="<?php echo base_url('selfservices/edit_personal_detail/' . $user_id) ?>" type="submit" class="btn btn-success btn-sm px-4 float-right mr-5" name="p_details"><img class="mb-1"   src="<?= base_url('assets_system/icons/edit.svg') ?>" alt="" />&nbsp;Edit</a> -->
                </div>
                <hr>
                <div class="row pl-4 pt-0 pb-0">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <div class="col col-md-6 text-bold ">
                                Employee ID
                            </div>

                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $employee_id ?></span>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col col-md-6 text-bold">
                                First Name
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $firstname ?></span>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col col-md-6 text-bold">
                                Middle Name
                            </div>

                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $middlename ?></span>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col col-md-6 text-bold">
                                Last Name
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $lastname ?></span>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col col-md-6 text-bold">
                                Suffix
                                <!-- <span style="color:red;">*</span> -->
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $suffix ?></span>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col col-md-6 text-bold">
                                Marital Status
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_MARITAL, $marital_status) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-1">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Birthdate
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= ($birthdate && strtotime($birthdate) && $birthdate !== '0000-00-00') ? date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($birthdate)) : '' ?></span>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col col-md-6 text-bold">
                                Gender
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_GENDERS, $gender) ?></span>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col col-md-6 text-bold">
                                Nationality
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_NATIONALITY, $nationality) ?></span>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col col-md-6 text-bold">
                                Shirt size
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_SHIRT_SIZE, $shirt_size) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pl-4 pt-0 pb-0 mt-2">
                    <div class="col-md-6 ">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Mobile Number
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $mobile_number ?></span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Email
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $email ?></span>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col col-md-3 text-bold">
                                Home Address
                            </div>
                            <div class="col col-md-9">
                                <span style="font-weight:normal"><?= $home_address ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col col-md-3 text-bold">
                                Current Address
                            </div>
                            <div class="col col-md-9">
                                <span style="font-weight:normal"><?= $current_address ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col col-md-3 text-bold">
                                Province
                            </div>
                            <div class="col col-md-9">
                                <span style="font-weight:normal"><?= $province ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col col-md-3 text-bold">
                                City
                            </div>
                            <div class="col col-md-9">
                                <span style="font-weight:normal"><?= $city ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col col-md-3 text-bold">
                                Barangay
                            </div>
                            <div class="col col-md-9">
                                <span style="font-weight:normal"><?= $barangay ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <hr>
                <div class="card-title pl-4 pt-0 pb-0 text-bold header-title d-flex align-items-center">
                    <img style="width: 18px; height: 15.4px; margin-right: 7px;" src="<?= base_url('assets_system/icons/id-card-clip-solid.svg') ?>" alt="">Other Details
                </div>
                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <?php foreach ($C_OTHER_DETAILS as $other_detail) { ?>
                        <div class="col-sm-12 col-md-6">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col col-md-6 text-bold">
                                            <?= $other_detail->name ?>
                                        </div>
                                        <div class="col col-md-6">
                                            <span><?= $other_detail->value ?></span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <hr>
                <div class="card-title pl-4 pt-0 pb-0 text-bold header-title d-flex align-items-center">
                    <img style="width: 19px; height: 19px; margin-right: 7px;" src="<?= base_url('assets_system/icons/square-phone-flip-solid.svg') ?>" alt="">Employment Details
                </div>
                <hr>
                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Hired Date
                            </div>
                            <div class="col col-md-6">

                                <span style="font-weight:normal"><?= ($hired_on && strtotime($hired_on) && $hired_on !== '0000-00-00') ? date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($hired_on)) : '' ?></span>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Regularization
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= ($regularization_date && strtotime($regularization_date) && $regularization_date !== '0000-00-00') ? date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($regularization_date)) : '' ?></span>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Employment Type
                            </div>

                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_TYPE, $employment_type) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Position
                            </div>

                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_POSITIONS, $position) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Resignation Date:
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= ($resignation_date && strtotime($resignation_date) && $resignation_date !== '0000-00-00') ? date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($resignation_date)) : '' ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Last Day of Work:
                            </div>
                            <div class="col col-md-6">
                                <p class="mb-0"><?= ($end_on && strtotime($end_on) && $end_on !== '0000-00-00') ? date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($end_on)) : '' ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6 <?= true ? '' : 'hide'; ?> ">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Resignation Reason:
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_RESIGNATION_REASONS, $resignation_reason) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Termination Date:
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= ($termination_date && strtotime($termination_date) && $termination_date !== '0000-00-00') ? date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($termination_date)) : '' ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Termination Reason:
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_TERMINATION_REASONS, $termination_reason) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6 <?= ($DISP_VIEW_COMPANY) ? '' : 'hide'; ?>">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Company
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_COMPANIES, $company_emp) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 <?= ($C_COM_STRUCTURE[32]->value == '1') ? '' : 'hide'; ?>">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Branch
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_BRANCH, $branch_emp) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 <?= ($C_COM_STRUCTURE[33]->value == '1') ? '' : 'hide'; ?>">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Department
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_DEPARTMENTS, $department) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6 <?= ($C_COM_STRUCTURE[34]->value == '1') ? '' : 'hide'; ?>">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Division
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_DIVISIONS, $division) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 <?= ($C_COM_STRUCTURE[35]->value == '1') ? '' : 'hide'; ?>">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Sections
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_SECTIONS, $section) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6 <?= ($C_COM_STRUCTURE[36]->value == '1') ? '' : 'hide'; ?>">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Groups
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_GROUPS, $groups) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 <?= ($C_COM_STRUCTURE[38]->value == '1') ? '' : 'hide'; ?>">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Line
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_LINES, $line) ?></span>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6 <?= ($C_COM_STRUCTURE[37]->value == '1') ? '' : 'hide'; ?>">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Team
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_TEAMS, $team) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Company Number
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $company_number ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Company Email
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $company_email ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                HMO Provider
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= convert_id2name($C_HMO, $hmo) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                HMO Number
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $hmo_number ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <hr>
                <div class="card-title pl-4 pt-0 pb-0 text-bold header-title d-flex align-items-center">
                    <img style="width: 19px; height: 19px; margin-right: 7px;" src="<?= base_url('assets_system/icons/square-phone-flip-solid.svg') ?>" alt=""></i>ID Details
                </div>
                <hr>
                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                SSS
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $sss ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Pagibig
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $hdmf ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Philhealth
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $philhealth ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                TIN
                            </div>
                            <div class="col col-md-6">
                                <p class="mb-0"><?= $tin ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Driver's License
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $drivers_license ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                National ID
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $national_id ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Passport
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $passport ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <hr>
                <div class="card-title pl-4 pt-0 pb-0 text-bold header-title d-flex align-items-center">
                    <img style="width: 19px; height: 19px; margin-right: 7px;" src="<?= base_url('assets_system/icons/square-phone-flip-solid.svg') ?>" alt="">Compensation Details
                </div>
                <hr>

                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Bank
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $bank ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Branch
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $branch ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Account Type
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $account_type ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Payment Type
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $payment_type ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pl-4 pt-0 pb-0 mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col col-md-6 text-bold">
                                Account Number
                            </div>
                            <div class="col col-md-6">
                                <span style="font-weight:normal"><?= $account_number ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <hr>
                <div class="card-title pl-4 pt-0 pb-0 text-bold header-title d-flex align-items-center">
                    <img style="width: 21px; height: 21px; margin-right: 7px;" src="<?= base_url('assets_system/icons/graduation-cap-solid.svg') ?>" alt="">Education
                </div>
                <hr class="mb-0">
                <div class="row pl-1 pr-1">
                    <div class="table-responsive">
                        <table class="table table-xs table-hover table-nowrap mb-0" style="border:none;">
                            <tbody>
                                <thead>
                                    <th>LEVELS</th>
                                    <th>SCHOOL</th>
                                    <th>ADDRESS</th>
                                    <th>FROM</th>
                                    <th>TO</th>
                                    <th>STATUS</th>
                                </thead>
                                <?php
                                if ($C_EDUCATION) {
                                    foreach ($C_EDUCATION as $C_EDUCATION_ROW) {
                                ?>
                                        <tr>
                                            <td><?= $C_EDUCATION_ROW->col_educ_degree; ?></td>
                                            <td><?= $C_EDUCATION_ROW->col_educ_school; ?></td>
                                            <td><?= $C_EDUCATION_ROW->address; ?></td>
                                            <td><?= $C_EDUCATION_ROW->col_educ_from_yr ?></td>
                                            <td><?= $C_EDUCATION_ROW->col_educ_to_yr; ?></td>
                                            <td><?= $C_EDUCATION_ROW->completion ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr class="table-active">
                                        <td colspan="9">
                                            <center>No Records</center>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <hr>
                <div class="card-title pl-4 pt-0 pb-0 text-bold header-title d-flex align-items-center">
                    <img style="width: 21px; height: 21px; margin-right: 7px;" src="<?= base_url('assets_system/icons/book-open-solid.svg') ?>" alt="">Skills
                </div>
                <hr class="mb-0">
                <div class="row pl-1 pr-1">
                    <div class="table-responsive">
                        <table class="table table-xs table-hover table-nowrap mb-0" style="border:none;">
                            <tbody>
                                <thead>
                                    <th>TITLE</th>
                                    <th>LEVEL</th>
                                    <th>LAST UPDATE</th>
                                </thead>
                                <?php
                                if ($C_SKILLS_MATRIX) {
                                    foreach ($C_SKILLS_MATRIX as $C_SKILLS_MATRIX_ROW) {
                                ?>
                                        <tr>
                                            <td><?= convert_id2name($C_SKILLS_NAME, $C_SKILLS_MATRIX_ROW->name) ?></td>
                                            <td><?= convert_id2name($C_SKILLS_LEVEL, $C_SKILLS_MATRIX_ROW->value) ?></td>
                                            <td><?= date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($C_SKILLS_MATRIX_ROW->edit_date)); ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr class="table-active">
                                        <td colspan="9">
                                            <center>No Records</center>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <hr>
                <div class="card-title pl-4 pt-0 pb-0 text-bold header-title d-flex align-items-center">
                    <img style="width: 21px; height: 21px; margin-right: 7px;" src="<?= base_url('assets_system/icons/book-open-solid.svg') ?>" alt="">Documents
                </div>
                <hr class="mb-0">
                <div class="row pl-1 pr-1">
                    <div class="table-responsive">
                        <table class="table table-xs table-hover table-nowrap mb-0" style="border:none;">
                            <tbody>
                                <thead>
                                    <th>FILES</th>
                                    <th>ACTION</th>
                                </thead>
                                <?php
                                if ($C_DOCUMENTS) {
                                    foreach ($C_DOCUMENTS as $C_DOCUMENTS_ROW) {
                                ?>
                                        <tr>
                                            <td><?= $C_DOCUMENTS_ROW->col_doc_file; ?></td>
                                            <td><a href="<?= base_url() ?>assets_user/documents/<?= $C_DOCUMENTS_ROW->col_doc_file ?>" download>Download</a></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr class="table-active">
                                        <td colspan="9">
                                            <center>No Records</center>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <hr>
                <div class="card-title pl-4 pt-0 pb-0 text-bold header-title d-flex align-items-center">
                    <img style="width: 21px; height: 21px; margin-right: 7px;" src="<?= base_url('assets_system/icons/book-open-solid.svg') ?>" alt="">Dependents
                </div>
                <hr class="mb-0">
                <div class="row pl-1 pr-1">
                    <div class="table-responsive">
                        <table class="table table-xs table-hover table-nowrap mb-0" style="border:none;">
                            <tbody>
                                <thead>
                                    <th>NAME</th>
                                    <th>BIRTH DATE</th>
                                    <th>GENDER</th>
                                    <th>RELATIONSHIP</th>
                                </thead>
                                <?php
                                if ($C_DEPENDENTS) {
                                    foreach ($C_DEPENDENTS as $C_DEPENDENTS_ROW) {
                                ?>
                                        <tr>
                                            <td><?= $C_DEPENDENTS_ROW->col_depe_name; ?></td>
                                            <td><?= date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($C_DEPENDENTS_ROW->col_depe_bday)); ?></td>
                                            <td><?= $C_DEPENDENTS_ROW->col_depe_gndr; ?></td>
                                            <td><?= $C_DEPENDENTS_ROW->col_depe_rela ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr class="table-active">
                                        <td colspan="9">
                                            <center>No Records</center>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <hr>
                <div class="card-title pl-4 pt-0 pb-0 text-bold header-title d-flex align-items-center">
                    <img style="width: 21px; height: 21px; margin-right: 7px;" src="<?= base_url('assets_system/icons/book-open-solid.svg') ?>" alt="">Emergency Contacts
                </div>
                <hr class="mb-0">
                <div class="row pl-1 pr-1">
                    <div class="table-responsive">
                        <table class="table table-xs table-hover table-nowrap mb-0" style="border:none;">
                            <tbody>
                                <thead>
                                    <th>CONTACT NAME</th>
                                    <th>RELATIONSHIP</th>
                                    <th>MOBILE NUMBER</th>
                                    <th>WORK PHONE</th>
                                    <th>HOME PHONE</th>
                                    <th>CURRENT ADDRESS</th>
                                </thead>
                                <?php
                                if ($C_EMERGENCY) {
                                    foreach ($C_EMERGENCY as $C_EMERGENCY_ROW) {
                                ?>
                                        <tr>
                                            <td><?= $C_EMERGENCY_ROW->name ?></td>
                                            <td><?= $C_EMERGENCY_ROW->relationship ?></td>
                                            <td><?= $C_EMERGENCY_ROW->mobile_number ?></td>
                                            <td><?= $C_EMERGENCY_ROW->work_phone ?></td>
                                            <td><?= $C_EMERGENCY_ROW->home_phone ?></td>
                                            <td><?= $C_EMERGENCY_ROW->current_address ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr class="table-active">
                                        <td colspan="9">
                                            <center>No Records</center>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <hr>
                <div class="card-title pl-4 pt-0 pb-0 text-bold header-title d-flex align-items-center">
                    <img style="width: 21px; height: 21px; margin-right: 7px;" src="<?= base_url('assets_system/icons/book-open-solid.svg') ?>" alt="">Change Logs</span>
                </div>
                <hr class="mb-0">
                <div class="row pl-1 pr-1">
                    <div class="table-responsive">
                        <table class="table table table-hover table-nowrap mb-0" style="border:none;">
                            <tbody>
                                <thead>
                                    <th scope="col">DATE</th>
                                    <th scope="col">CATEGORY</th>
                                    <th scope="col">FROM</th>
                                    <th scope="col">TO</th>
                                </thead>
                                <?php
                                if ($C_LOGS) {
                                    foreach ($C_LOGS as $C_LOGS_ROW) {
                                ?>
                                        <tr>
                                            <td><?= $C_LOGS_ROW->log_date ? date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime(explode(" ", $C_LOGS_ROW->log_date)[0])) : '<a class="text-danger">No data</a>' ?></td>
                                            <td><?= $C_LOGS_ROW->category ? $C_LOGS_ROW->category : '<a class="text-danger">No data</a>' ?></td>
                                            <td><?= $C_LOGS_ROW->from_val ? $C_LOGS_ROW->from_val : '<a class="text-danger">No data</a>' ?></td>
                                            <td><?= $C_LOGS_ROW->to_val ? $C_LOGS_ROW->to_val : '<a class="text-danger">No data</a>' ?></td>

                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr class="table-active">
                                        <td colspan="9">
                                            <center>No Records</center>
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
        </div>
    </div>

    <?php
$school1_name = isset($school1_name) ? $school1_name : '';
$school1_deg = isset($school1_deg) ? $school1_deg : '';
$school1_gwa = isset($school1_gwa) ? $school1_gwa : '';
$school1_from = isset($school1_from) ? $school1_from : '';
$school1_to = isset($school1_to) ? $school1_to : '';
$DISP_GENDER_INFO = isset($DISP_GENDER_INFO) ? $DISP_GENDER_INFO : '';
$DISP_MRTL_STAT = isset($DISP_MRTL_STAT) ? $DISP_MRTL_STAT : '';
$DISP_SHRT_SIZE = isset($DISP_SHRT_SIZE) ? $DISP_SHRT_SIZE : '';
$DISP_NATIONALITY = isset($DISP_NATIONALITY) ? $DISP_NATIONALITY : '';
$DISP_SKILL_INFO = isset($DISP_SKILL_INFO) ? $DISP_SKILL_INFO : '';
$DISP_SKILL_LEVEL_INFO = isset($DISP_SKILL_LEVEL_INFO) ? $DISP_SKILL_LEVEL_INFO : '';

?>

    <div class="modal fade" id="modal_add_education" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Education</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="<?php echo base_url('employees/edit_employee_education'); ?>" id="ADD_EDUC_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-bold" style="font-size: 18px;">Primary</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label class="required" for="UPDT_ID_SSS">School</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter the name of school" name="school1_name" id="school1_name" value="<?= $school1_name ?>" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="UPDT_ID_SSS">Degree / Diploma</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter Degree/Diploma (if highschool graduate, enter 'High School Graduate')" name="school1_deg" id="school1_deg" value="<?= $school1_deg ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="UPDT_ID_SSS">Grade</label>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter grade" name="school1_gwa" id="school1_gwa" value="<?= $school1_gwa ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="UPDT_ID_SSS">From Year</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter start of school year" name="school1_from" id="school1_from" value="<?= $school1_from ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="UPDT_ID_SSS">To Year (or year expected)</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control form-control " type="text" placeholder="Enter end of school year" name="school1_to" id="school1_to" value="<?= $school1_to ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <input type="hidden" name="EMPL_ID" id="EDUC_EMPL_ID" value="<?= $user_id ?>">
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edit_employee_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Personal Info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('employees/edit_employee_info'); ?>" id="EDIT_EMPLOYEE_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Employee ID</label>
                                    <input class="form-control" autocomplete="off" type="text" value="<?= $employee_id ?>" name="UPDT_EMPL_ID" id="UPDT_EMPL_ID" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Last Name</label>
                                            <input class="form-control" autocomplete="off" type="text" value="<?= $lastname ?>" name="UPDT_EMPL_LNAME" id="UPDT_EMPL_LNAME" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Middle Name</label>
                                            <input class="form-control" autocomplete="off" type="text" value="<?= $middlename ?>" name="UPDT_EMPL_MNAME" id="UPDT_EMPL_MNAME" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">First Name</label>
                                            <input class="form-control" autocomplete="off" type="text" value="<?= $firstname ?>" name="UPDT_EMPL_FNAME" id="UPDT_EMPL_FNAME" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">Gender</label>
                                            <select name="UPDT_EMPL_GENDER" id="UPDT_EMPL_GENDER" class="form-control" required>
                                                <option value="<?= $gender ?>"><?= $gender ?></option>
                                                <?php
                                                if ($DISP_GENDER_INFO) {
                                                    foreach ($DISP_GENDER_INFO as $DISP_GENDER_INFO_ROW) { ?>
                                                        <option value="<?= $DISP_GENDER_INFO_ROW->name ?>"><?= $DISP_GENDER_INFO_ROW->name ?></option>
                                                <?php   }
                                                } ?>
                                                <select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">Marital Status</label>
                                            <select class="custom-select mr-sm-2" id="UPDT_EMPL_MRTL_STAT" name="UPDT_EMPL_MRTL_STAT" required>
                                                <option value="<?= $marital_status ?>" selected><?= $marital_status ?></option>
                                                <?php 
                                                 if ($DISP_MRTL_STAT) {
                                                foreach ($DISP_MRTL_STAT as $DISP_MRTL_STAT_ROW) { ?>
                                                    <option value="<?= $DISP_MRTL_STAT_ROW->name ?>"><?= $DISP_MRTL_STAT_ROW->name ?></option>
                                                <?php } 
                                            } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">Shirt Size</label>
                                            <select class="custom-select mr-sm-2" id="UPDT_EMPL_SHIRT_SIZE" name="UPDT_EMPL_SHIRT_SIZE">
                                                <option value="<?= $shirt_size ?>" selected><?= $shirt_size ?></option>
                                                <?php
                                                  if ($DISP_SHRT_SIZE) {
                                                 foreach ($DISP_SHRT_SIZE as $DISP_SHRT_SIZE_ROW) { ?>
                                                    <option value="<?= $DISP_SHRT_SIZE_ROW->name ?>"><?= $DISP_SHRT_SIZE_ROW->name ?></option>
                                                <?php } 
                                              } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">Nationality</label>
                                            <select class="custom-select mr-sm-2" id="UPDT_EMPL_NATIONALITY" name="UPDT_EMPL_NATIONALITY" required>
                                                <option value="<?= $nationality ?>" selected><?= $nationality ?></option>
                                                <?php 
                                                  if ($DISP_NATIONALITY) {
                                                    foreach ($DISP_NATIONALITY as $DISP_NATIONALITY_ROW) { ?>
                                                    <option value="<?= $DISP_NATIONALITY_ROW->name ?>"><?= $DISP_NATIONALITY_ROW->name ?></option>
                                                <?php } 
                                            } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="">Home Address</label>
                                            <input class="form-control" autocomplete="off" type="text" value="<?= $home_address ?>" name="UPDT_EMPL_HOME_ADDR" id="UPDT_EMPL_HOME_ADDR">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="">Current Address</label>
                                            <input class="form-control" autocomplete="off" type="text" value="<?= $current_address ?>" name="UPDT_EMPL_CURR_ADDR" id="UPDT_EMPL_CURR_ADDR">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="">Date of Birth</label>
                                            <input class="form-control" autocomplete="off" type="date" value="<?= date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($birthdate)) ?>" name="UPDT_EMPL_BIRTHDAY" id="UPDT_EMPL_BIRTHDAY">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="EDIT_EMPL_ID" id="EDIT_EMPL_ID" value="<?= $user_id ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="BTN_EMPL_UPDT">&nbsp; Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edit_employee_contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Contact</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('employees/edit_employee_contact'); ?>" id="EDIT_EMPLOYEE_CONTACT_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Mobile Number</label>
                                            <input class="form-control" autocomplete="off" type="text" value="<?= $mobile_number ?>" name="UPDT_EMPL_PERS_NUMBER" id="UPDT_EMPL_PERS_NUMBER" placeholder="e.g 09091234567">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Work Phone Number</label>
                                            <input class="form-control" autocomplete="off" type="text" value="<?= $company_number ?>" name="UPDT_EMPL_WORK_NUMBER" id="UPDT_EMPL_WORK_NUMBER" placeholder="e.g 834-4000">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="">Work Email</label>
                                    <input class="form-control" autocomplete="off" type="text" value="<?= $company_email ?>" name="UPDT_EMPL_WORK_EMAIL" id="UPDT_EMPL_WORK_EMAIL">
                                </div>
                                <div class="form-group">
                                    <label class="">Personal Email</label>
                                    <input class="form-control" autocomplete="off" type="text" value="<?= $email ?>" name="UPDT_EMPL_PERS_EMAIL" id="UPDT_EMPL_PERS_EMAIL">
                                    <small id="emailHelp" class="form-text text-muted">Personal email will be used to login.</small>
                                </div>
                            </div>
                            <input type="hidden" name="EDIT_EMPL_ID" value="<?= $user_id ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="BTN_EMPL_CONTACT_UPDT">&nbsp; Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edit_education" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Education</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('employees/edit_employee_education'); ?>" id="EDIT_EDUC_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">School</label>
                                    <input class="form-control form-control " type="text" name="UPDT_EDUC_SCHOOL" id="UPDT_EDUC_SCHOOL" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="UPDT_ID_SSS">Degree</label>
                                    <input class="form-control form-control " type="text" name="UPDT_EDUC_DEGREE" id="UPDT_EDUC_DEGREE" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="UPDT_ID_SSS">From Year</label>
                                            <input class="form-control form-control " type="text" name="UPDT_EDUC_FROM_YEAR" id="UPDT_EDUC_FROM_YEAR">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="UPDT_ID_SSS">To Year (or year expected)</label>
                                            <input class="form-control form-control " type="text" name="UPDT_EDUC_TO_YEAR" id="UPDT_EDUC_TO_YEAR">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="UPDT_ID_SSS">Grade</label>
                                    <input class="form-control form-control " type="text" name="UPDT_EDUC_GRADE" id="UPDT_EDUC_GRADE">
                                </div>
                            </div>
                            <input type="hidden" name="UPDT_EDUC_ID" id="UPDT_EDUC_ID">
                            <input type="hidden" name="UPDT_EDUC_EMPL_ID" id="UPDT_EDUC_EMPL_ID">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="EDUC_BTN_UPDT">&nbsp; Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edit_certificate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit License and Certifications</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('employees/edit_employee_certification'); ?>" id="EDIT_CERT_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_CERT_NAME">Name</label>
                                    <input class="form-control form-control " type="text" name="UPDT_CERT_NAME" id="UPDT_CERT_NAME" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="UPDT_CERT_ISSUER">Issuer</label>
                                    <input class="form-control form-control " type="text" name="UPDT_CERT_ISSUER" id="UPDT_CERT_ISSUER" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="UPDT_CERT_ISSUED_ON">Issued On</label>
                                    <input class="form-control form-control " type="date" name="UPDT_CERT_ISSUED_ON" id="UPDT_CERT_ISSUED_ON" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="icheck-primary pb-2" style="font-size: 14px; display: block;">
                                                <input type="checkbox" id="CHCK_CERT_EXPIRES_UPDT" name="CHCK_CERT_EXPIRES_UPDT">
                                                <label for="CHCK_CERT_EXPIRES_UPDT" style="font-weight: 500 !important; font-size: 14px !important;">
                                                    Expires
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 show_expire_updt" style="display:none;">
                                        <div class="form-group">
                                            <label for="UPDT_CERT_EXPIRE">Expires On</label>
                                            <input class="form-control form-control" type="date" name="UPDT_CERT_EXPIRE" id="UPDT_CERT_EXPIRE">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="UPDT_CERT_ID" id="UPDT_CERT_ID">
                            <input type="hidden" name="UPDT_CERT_EMPL_ID" id="UPDT_CERT_EMPL_ID">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="CERT_BTN_UPDT">&nbsp; Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edit_skills" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Skill</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('employees/edit_employee_skill'); ?>" id="EDIT_SKILL_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_SKILL_NAME">Skill</label>
                                    <select name="UPDT_SKILL_NAME" id="UPDT_SKILL_NAME" class="form-control">
                                        <option value="">Choose...</option>
                                        <?php
                                        if ($DISP_SKILL_INFO) {
                                            foreach ($DISP_SKILL_INFO as $DISP_SKILL_INFO_ROW) { ?>
                                                <option value="<?= $DISP_SKILL_INFO_ROW->col_skill_name ?>"><?= $DISP_SKILL_INFO_ROW->col_skill_name ?></option>
                                        <?php   }
                                        } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="required" for="UPDT_SKILL_LEVEL">Level</label>
                                    <select name="UPDT_SKILL_LEVEL" id="UPDT_SKILL_LEVEL" class="form-control">
                                        <option value="">Choose...</option>
                                        <?php
                                        if ($DISP_SKILL_LEVEL_INFO) {
                                            foreach ($DISP_SKILL_LEVEL_INFO as $DISP_SKILL_LEVEL_INFO_ROW) { ?>
                                                <option value="<?= $DISP_SKILL_LEVEL_INFO_ROW->col_level_name ?>"><?= $DISP_SKILL_LEVEL_INFO_ROW->col_level_name ?></option>
                                        <?php   }
                                        } ?>
                                        <select>
                                </div>
                                <div x-show="level == 'interested'">
                                    <p>You have a common knowledge level of understanding in this area and a basic understanding of the skills and techniques required to practically apply this skill.</p>
                                    <p>You have identified this as a key area of interest and are interested in developing it further.</p>
                                    <ul>
                                        <li>Basic knowledge</li>
                                        <li>Focus on learning</li>
                                    </ul>
                                </div>
                            </div>
                            <input type="hidden" name="UPDT_SKILL_ID" id="UPDT_SKILL_ID">
                            <input type="hidden" name="UPDT_SKILL_EMPL_ID" id="UPDT_SKILL_EMPL_ID">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="SKILL_BTN_UPDT">&nbsp; Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edit_image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Update Profile Photo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('selfservices/edit_image'); ?>" id="edit_image_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                    <div class="modal-body">
                        <hr>
                        <div class="edit_profile_pic w-100 text-center">
                            <img class="avatar" id="employee_img_modal" style="cursor: pointer;" width="300" height="300" src="<?php if ($user_image) {
                                                                                                                                    echo base_url() . '/assets_user/user_profile/' . $user_image;
                                                                                                                                } else {
                                                                                                                                    echo base_url() . '/assets_system/images/default_user.jpg';
                                                                                                                                } ?>">
                        </div>
                        <div class="form-group mt-3">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input fileficker" id="upload_image" name="employee_image" multiple="" accept="image/*" required>
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="INSRT_EMPL_ID" value="<?= $user_id ?>">
                        <?php
                        $url_count = $this->uri->total_segments();
                        $url_directory = $this->uri->segment($url_count);
                        ?>
                        <input type="hidden" name="URL_DIRECTORY" value="<?= $url_directory ?>">
                        <button class='btn btn-primary text-light px-3' type="submit" id="EDUC_BTN_INSRT">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<aside class="control-sidebar control-sidebar-dark">
</aside>



<?php $this->load->view('templates/jquery_link'); ?>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script>
</script>


<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->


<?php

if ($this->session->flashdata('SESS_SUCC_MSG_CHANGE_PASS')) {

?>

    <script>
        Swal.fire(

            '<?php echo $this->session->flashdata('SESS_SUCC_MSG_CHANGE_PASS'); ?>',

            '',

            'success'

        )
    </script>

<?php } ?>
<?php
if ($this->session->userdata('SESS_EMPLOYEE_TERMINATED')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_EMPLOYEE_TERMINATED'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_EMPLOYEE_TERMINATED');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_UPDT_IMG')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_UPDT_IMG'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_UPDT_IMG');
}
?>
<?php
if ($this->session->userdata('SESS_ERR_IMAGE')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_ERR_IMAGE'); ?>',
            '',
            'error'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_ERR_IMAGE');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_EDUCATION')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_EDUCATION'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_EDUCATION');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_CERTIFICATION')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_CERTIFICATION'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_CERTIFICATION');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_INSRT_SKILL')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_INSRT_SKILL'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_INSRT_SKILL');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_UPDT_EMPL_INFO')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_UPDT_EMPL_INFO'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_UPDT_EMPL_INFO');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_UPDT_EMPL_CONTACT')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_UPDT_EMPL_CONTACT'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_UPDT_EMPL_CONTACT');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_UPDT_EMPL_EDUC')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_UPDT_EMPL_EDUC'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_UPDT_EMPL_EDUC');
}
?>

<?php
if ($this->session->userdata('SESS_SUCC_MSG_DLT_EDUC')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_EDUC'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_DLT_EDUC');
}

?>

<?php
if ($this->session->flashdata('SESS_SUCC_MSG')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->flashdata('SESS_SUCC_MSG'); ?>',
            '',
            'success'
        )
    </script>
<?php
}

?>
<?php
if ($this->session->userdata('SESS_SUCC_UPDT_EMPL_CERT')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_UPDT_EMPL_CERT'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_UPDT_EMPL_CERT');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_UPDT_EMPL_CERT')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_CERT'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_DLT_CERT');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_UPDT_EMPL_SKILL')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_UPDT_EMPL_SKILL'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_UPDT_EMPL_SKILL');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_DLT_SKILL')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_SKILL'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_DLT_SKILL');
}
?>
<?php
function convert_id2name($array, $pos)
{
    $name = "";
    foreach ($array as $e) {
        if ($e->id == $pos) {
            $name = $e->name;
        }
    }

    return $name;
}

function check_value($data)
{
    $result = '';
    if ($data == "" || $data == "0000-00-00"  || $data == "0" || $data == "00:00") {
        $result = "-";
    }
    return $result;
}
?>
<script>
    $(document).ready(function() {


        $('#btn_activate').click(function() {
            $('#form_activate_empl').submit();
        })
        $("#employee_img_modal").click(function(e) {
            $("#upload_image").click();
        });

        function fasterPreview(uploader) {
            if (uploader.files && uploader.files[0]) {
                $('#employee_img_modal').attr('src',
                    window.URL.createObjectURL(uploader.files[0]));
                $('.custom-file-label').text(uploader.files[0].name);
            }
        }
        $("#upload_image").change(function() {
            fasterPreview(this);
        });
        $('#employee_img').click(function() {})
        $('#CHCK_CERT_EXPIRES').click(function() {
            $('.show_expire').toggle();
        });
        $('#CHCK_CERT_EXPIRES_UPDT').click(function() {
            $('.show_expire_updt').toggle();
        });
        var education_url = '<?php echo base_url(); ?>employees/getEducationData';
        const openModalButton_educ = document.querySelectorAll('[data-target]');
        openModalButton_educ.forEach(button => {
            button.addEventListener('click', () => {
                const modal = document.querySelector(button.dataset.target);
                getEducationData(education_url, button.getAttribute('education_id')).then(data => {
                    if (data.length > 0) {
                        data.forEach((x) => {
                            document.getElementById('UPDT_EDUC_ID').value = x.id;
                            document.getElementById('UPDT_EDUC_EMPL_ID').value = x.col_empl_id;
                            document.getElementById('UPDT_EDUC_SCHOOL').value = x.col_educ_school;
                            document.getElementById('UPDT_EDUC_DEGREE').value = x.col_educ_degree;
                            document.getElementById('UPDT_EDUC_FROM_YEAR').value = x.col_educ_from_yr;
                            document.getElementById('UPDT_EDUC_TO_YEAR').value = x.col_educ_to_yr;
                            document.getElementById('UPDT_EDUC_GRADE').value = x.col_educ_grade;
                        });
                    }
                });
            });
        });
        async function getEducationData(education_url, education_id) {
            var formData = new FormData();
            formData.append('education_id', education_id);
            const response = await fetch(education_url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }
        $('.EDUC_BTN_DLT').click(function(e) {
            e.preventDefault();
            var user_deleteKey = $(this).attr('delete_key');
            var employee_id = $(this).attr('employee_id');
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
                    window.location.href = "<?= base_url(); ?>employees/delete_employee_education?delete_id=" + user_deleteKey + "&employee_id=" + employee_id;
                }
            })
        })

        var certification_url = '<?php echo base_url(); ?>employees/getCertificationData';
        const openModalButton_cert = document.querySelectorAll('[data-target]');
        openModalButton_cert.forEach(button => {
            button.addEventListener('click', () => {
                const modal = document.querySelector(button.dataset.target);
                getCertificationData(certification_url, button.getAttribute('certification_id')).then(data => {
                    if (data.length > 0) {
                        data.forEach((x) => {
                            document.getElementById('UPDT_CERT_ID').value = x.id;
                            document.getElementById('UPDT_CERT_EMPL_ID').value = x.col_empl_id;
                            document.getElementById('UPDT_CERT_NAME').value = x.col_cert_name;
                            document.getElementById('UPDT_CERT_ISSUER').value = x.col_cert_issuer;
                            document.getElementById('UPDT_CERT_ISSUED_ON').value = x.col_cert_issued_on;
                            document.getElementById('UPDT_CERT_EXPIRE').value = x.col_cert_expires_on;
                            if (x.col_cert_expires_on != "0000-00-00") {
                                $('#CHCK_CERT_EXPIRES_UPDT').prop('checked', true);
                                $('.show_expire_updt').toggle();
                            }
                        });
                    }
                });
            });
        });
        async function getCertificationData(certification_url, certification_id) {
            var formData = new FormData();
            formData.append('certification_id', certification_id);
            const response = await fetch(certification_url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }
        $('.CERT_BTN_DLT').click(function(e) {
            e.preventDefault();
            var user_deleteKey = $(this).attr('delete_key');
            var employee_id = $(this).attr('employee_id');
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
                    window.location.href = "<?= base_url(); ?>employees/delete_employee_certification?delete_id=" + user_deleteKey + "&employee_id=" + employee_id;
                }
            })
        })
        var skills_url = '<?php echo base_url(); ?>employees/getSkillData';
        const openModalButton_skill = document.querySelectorAll('[data-target]');
        openModalButton_skill.forEach(button => {
            button.addEventListener('click', () => {
                const modal = document.querySelector(button.dataset.target);
                getSkillData(skills_url, button.getAttribute('skill_id')).then(data => {
                    if (data.length > 0) {
                        data.forEach((x) => {
                            document.getElementById('UPDT_SKILL_ID').value = x.id;
                            document.getElementById('UPDT_SKILL_EMPL_ID').value = x.col_empl_id;
                            document.getElementById('UPDT_SKILL_NAME').value = x.col_skill_name;
                            document.getElementById('UPDT_SKILL_LEVEL').value = x.col_skill_level;
                        });
                    }
                });
            });
        });
        async function getSkillData(skills_url, skill_id) {
            var formData = new FormData();
            formData.append('skill_id', skill_id);
            const response = await fetch(skills_url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        $('.SKILL_BTN_DLT').click(function(e) {
            e.preventDefault();
            var user_deleteKey = $(this).attr('delete_key');
            var employee_id = $(this).attr('employee_id');
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
                    window.location.href = "<?= base_url(); ?>employees/delete_employee_skill?delete_id=" + user_deleteKey + "&employee_id=" + employee_id;
                }
            })
        })
    })

</script>



</body>

</html>