<?php

// Key id

$user_id = '';



// Personal Info

$user_image = '';

$lastname = '';

$middlename = '';

$firstname = '';

$full_name = '';
$progress=0;


// Company Info

$company_number = '';

$company_email = '';

$hired_on = '';

$employment_type = '';

$position = '';

$section = '';

$department = '';

$division = '';

$reporting_to = '';



// ID Info

$sss = '';

$hdmf = '';

$philhealth = '';

$tin = '';

$drivers_license = '';

$national_id = '';

$passport = '';



if ($DISP_EMP_INFO) {

    foreach ($DISP_EMP_INFO as $DISP_EMP_INFO_ROW) {

        // Key id

        $user_id = $DISP_EMP_INFO_ROW->id;



        // Set personal Info

        $user_image = $DISP_EMP_INFO_ROW->col_imag_path;

        $lastname = $DISP_EMP_INFO_ROW->col_last_name;

        $middlename = $DISP_EMP_INFO_ROW->col_midl_name;

        $firstname = $DISP_EMP_INFO_ROW->col_frst_name;

        if ($middlename) {

            $full_name = $lastname . ', ' . $firstname . ' ' . ucfirst($middlename[0]) . '.';

        } else {

            $full_name = $lastname . ', ' . $firstname;

        }



        // Set company Info

        $company_number = $DISP_EMP_INFO_ROW->col_comp_numb;

        $company_email = $DISP_EMP_INFO_ROW->col_comp_emai;

        $hired_on = $DISP_EMP_INFO_ROW->col_hire_date;

        $employment_type = $DISP_EMP_INFO_ROW->col_empl_type;

        $position = $DISP_EMP_INFO_ROW->col_empl_posi;

        $section = $DISP_EMP_INFO_ROW->col_empl_sect;

        $department = $DISP_EMP_INFO_ROW->col_empl_dept;

        $division = $DISP_EMP_INFO_ROW->col_empl_divi;

        $reporting_to = $DISP_EMP_INFO_ROW->col_empl_repo;



        // ID Info

        $sss = $DISP_EMP_INFO_ROW->col_empl_sssc;
        $progress= ($sss !='')  ? ++$progress : $progress ; 

        $hdmf = $DISP_EMP_INFO_ROW->col_empl_hdmf;
        $progress= ($hdmf !='')  ? ++$progress : $progress ;

        $philhealth = $DISP_EMP_INFO_ROW->col_empl_phil;
        $progress= ($philhealth !='')  ? ++$progress : $progress ; 

        $tin = $DISP_EMP_INFO_ROW->col_empl_btin;
        $progress= ($tin !='')  ? ++$progress : $progress ;

        $drivers_license = $DISP_EMP_INFO_ROW->col_empl_driv;
        $progress= ($drivers_license !='')  ? ++$progress : $progress ; 

        $national_id = $DISP_EMP_INFO_ROW->col_empl_naid;
        $progress= ($national_id !='')  ? ++$progress : $progress ; 

        $passport = $DISP_EMP_INFO_ROW->col_empl_pass;
        $progress= ($passport !='')  ? ++$progress : $progress ; 
    }
}
$progress=round(($progress/7)*100);
?>

<div class="row">

    <div class="mini-nav">

        <a href="<?= base_url() ?>profile" class="mini-link">Personal</a>

        <a href="<?= base_url() ?>profile/ids" class="mini-links active">ID's</a>

        <a href="<?= base_url() ?>profile/job" class="mini-links">Job</a>

        <a href="<?= base_url() ?>profile/allowance" class="mini-links">Allowance</a>

        <!-- <a href = "<?= base_url() ?>profile/leave" class = "mini-links">Leave</a> -->

        <a href="<?= base_url() ?>profile/documents" class="mini-links">Documents</a>

        <!-- <a href = "<?= base_url() ?>profile/tasks" class = "mini-links">Tasks</a> -->

        <a href="<?= base_url() ?>profile/assets" class="mini-links">Assets</a>

        <a href="<?= base_url() ?>profile/emergency" class="mini-links">Emergency</a>

        <a href="<?= base_url() ?>profile/dependents" class="mini-links">Dependents</a>

        <a href="<?= base_url() ?>profile/notes" class="mini-links">Notes</a>

    </div>

</div>

<br>
<?php $this->load->view('templates/partials/progress',array('progress'=>$progress)); ?>
<div class="card_container">

    <div class="card-title">Government ID's

        <div class="modal-btn"><a data-toggle="modal" style="display: none;" href="#" data-target="#modal_update_ids"><i class="fas fa-pencil-alt"></i></a></div>

    </div>
    <br>
    <hr>
    <div class="row mt-4">
        <div class="col col-md-3 text-bold">

            SSS
        </div>

        <div class="col col-md-8">

            <span style="font-weight:normal"><?php if ($sss) {

                                                    echo $sss;

                                                } else {

                                                    echo '<em class="text-muted">Add an ID</em>';

                                                }  ?></span>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col col-md-3 text-bold">

            HDMF

        </div>

        <div class="col col-md-8">

            <span style="font-weight:normal"><?php if ($hdmf) {

                                                    echo $hdmf;

                                                } else {

                                                    echo '<em class="text-muted">Add an ID</em>';

                                                }  ?></span>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col col-md-3 text-bold">

            Philhealth

        </div>

        <div class="col col-md-8">

            <span style="font-weight:normal"><?php if ($philhealth) {

                                                    echo $philhealth;

                                                } else {

                                                    echo '<em class="text-muted">Add an ID</em>';

                                                }  ?></span>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col col-md-3 text-bold">

            TIN

        </div>

        <div class="col col-md-8">

            <span style="font-weight:normal"><?php if ($tin) {

                                                    echo $tin;

                                                } else {

                                                    echo '<em class="text-muted">Add an ID</em>';

                                                }  ?></span>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col col-md-3 text-bold">

            Driver's License

        </div>

        <div class="col col-md-8">

            <span style="font-weight:normal"><?php if ($drivers_license) {

                                                    echo $drivers_license;

                                                } else {

                                                    echo '<em class="text-muted">Add an ID</em>';

                                                }  ?></span>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col col-md-3 text-bold">

            National ID

        </div>

        <div class="col col-md-8">

            <span style="font-weight:normal"><?php if ($national_id) {

                                                    echo $national_id;

                                                } else {

                                                    echo '<em class="text-muted">Add an ID</em>';

                                                }  ?></span>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col col-md-3 text-bold">

            Passport

        </div>

        <div class="col col-md-8">

            <span style="font-weight:normal"><?php if ($passport) {

                                                    echo $passport;

                                                } else {

                                                    echo '<em class="text-muted">Add an ID</em>';

                                                }  ?></span>

        </div>

    </div>

</div>