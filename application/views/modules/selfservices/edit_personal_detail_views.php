<html>
<?php $this->load->view('templates/css_link'); ?>
<?php
$user_id         = '';
$employee_id     = '';
$lastname        = '';
$middlename      = '';
$firstname       = '';
$full_name       = '';
$marital_status  = '';
$home_address    = '';
$current_address = '';
$birthdate       = '';
$nationality     = '';
$email           = '';
$gender          = '';
$shirt_size      = '';
$mobile_number   = '';
if ($C_EMP_INFO) {
    foreach ($C_EMP_INFO as $C_EMP_INFO_ROW) {
        $user_id                = $C_EMP_INFO_ROW->id;
        $employee_id            = $C_EMP_INFO_ROW->col_empl_cmid;
        $firstname              = $C_EMP_INFO_ROW->col_frst_name;
        $middlename             = $C_EMP_INFO_ROW->col_midl_name;
        $lastname               = $C_EMP_INFO_ROW->col_last_name;
        $marital_status         = $C_EMP_INFO_ROW->col_mart_stat;
        $birthdate              = $C_EMP_INFO_ROW->col_birt_date;
        $gender                 = $C_EMP_INFO_ROW->col_empl_gend;
        $nationality            = $C_EMP_INFO_ROW->col_empl_nati;
        $shirt_size             = $C_EMP_INFO_ROW->col_shir_size;
        $mobile_number          = $C_EMP_INFO_ROW->col_mobl_numb;
        $email                  = $C_EMP_INFO_ROW->col_empl_emai;
        $home_address           = $C_EMP_INFO_ROW->col_home_addr;
        $current_address        = $C_EMP_INFO_ROW->col_curr_addr;
    }
}
?>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title"><a href="<?= base_url() ?>selfservices/my_profile_personal?id=<?= $user_id ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="">
                    </a>&nbsp;Edit Personal Details</h1>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <form action="<?php echo base_url('selfservices/update_personal_detail'); ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                    <div class="form-group">
                                        <label for="" >Employee ID</label>
                                        <input class="form-control " type="text" name="" id="" value="<?= $employee_id ?>" disabled />
                                    </div>

                                    <div class="form-group">
                                        <label for="UPDATE_FIRSTNAME" class="required">First Name</label>
                                        <input class="form-control " type="text" name="UPDATE_FIRSTNAME" id="" value="<?= $firstname ?>" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="UPDATE_MIDDLENAME" >Middle Name</label>
                                        <input class="form-control " type="text" name="UPDATE_MIDDLENAME" id="UPDATE_MIDDLENAME" value="<?= $middlename ?>"  />
                                    </div>

                                    <div class="form-group">
                                        <label for="UPDATE_LASTNAME" class="required">Last Name</label>
                                        <input class="form-control " type="text" name="UPDATE_LASTNAME" id="UPDATE_LASTNAME" value="<?= $lastname ?>" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="UPDATE_MART_STAT" >Marital Status</label>
                                        <select class="form-control" name="UPDATE_MART_STAT" id="UPDATE_MART_STAT">
                                            <?php if ($C_MARITAL) {
                                                foreach ($C_MARITAL as $C_MARITAL_ROW) {  ?>
                                                    <option value="<?= $C_MARITAL_ROW->id ?>" <?php if ($marital_status == $C_MARITAL_ROW->id) {
                                                                                                    echo "Selected";
                                                                                                } ?>> <?= $C_MARITAL_ROW->name ?></option>
                                            <?php                                   }
                                            }   ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="UPDATE_MOB_NUM" >Mobile Number</label>
                                        <input class="form-control" type="text" name="UPDATE_MOB_NUM" id="UPDATE_MOB_NUM" value="<?= $mobile_number ?>"  />
                                    </div>

                                    <div class="form-group">
                                        <label for="UPDATE_BIRTHDATE" class="required">Birthdate</label>
                                        <input class="form-control" type="date" name="UPDATE_BIRTHDATE" id="UPDATE_BIRTHDATE" value="<?= $birthdate ?>" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="UPDATE_GENDER" >Gender</label>
                                        <select class="form-control" name="UPDATE_GENDER" id="UPDATE_GENDER">
                                        <option value=''>-Select Gender-</option>
                                            <?php if ($C_GENDERS) {
                                                foreach ($C_GENDERS as $C_GENDERS_ROW) {  ?>
                                                    <option value="<?= $C_GENDERS_ROW->id ?>" <?php if ($gender == $C_GENDERS_ROW->id) {
                                                                                                    echo "Selected";
                                                                                                } ?>> <?= $C_GENDERS_ROW->name ?></option>
                                            <?php                                   }
                                            }   ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="UPDATE_NATIONALITY" >Nationality</label>
                                        <select class="form-control" name="UPDATE_NATIONALITY" id="UPDATE_NATIONALITY">
                                        <option value=''>-Select Nationality-</option>
                                            <?php if ($C_NATIONALITY) {
                                                foreach ($C_NATIONALITY as $C_NATIONALITY_ROW) {  ?>
                                                    <option value="<?= $C_NATIONALITY_ROW->id ?>" <?php if ($nationality == $C_NATIONALITY_ROW->id) {
                                                                                                        echo "Selected";
                                                                                                    } ?>> <?= $C_NATIONALITY_ROW->name ?></option>
                                            <?php                                   }
                                            }   ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="UPDATE_SHIRT_SIZE" >Shirt size</label>
                                        <select class="form-control" name="UPDATE_SHIRT_SIZE" id="UPDATE_SHIRT_SIZE">
                                        <option value=''>-Select Shirt Size-</option>
                                            <?php if ($C_SHIRT_SIZE) {
                                                foreach ($C_SHIRT_SIZE as $C_SHIRT_SIZE_ROW) {  ?>
                                                    <option value="<?= $C_SHIRT_SIZE_ROW->id ?>" <?php if ($shirt_size == $C_SHIRT_SIZE_ROW->id) {
                                                                                                        echo "Selected";
                                                                                                    }  ?>> <?= $C_SHIRT_SIZE_ROW->name ?></option>
                                            <?php                                   }
                                            }   ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="UPDATE_EMAIL" >Email</label>
                                        <input class="form-control" type="text" name="UPDATE_EMAIL" id="UPDATE_EMAIL" value="<?= $email ?>"  />
                                    </div>

                                    <div class="form-group">
                                        <label for="UPDATE_HOME_ADD" >Home Address</label>
                                        <input class="form-control" type="text" name="UPDATE_HOME_ADD" id="UPDATE_HOME_ADD" value="<?= $home_address ?>"  />
                                    </div>

                                    <div class="form-group">
                                        <label for="UPDATE_CURRENT_ADD" >Current Address</label>
                                        <input class="form-control" type="text" name="UPDATE_CURRENT_ADD" id="UPDATE_CURRENT_ADD" value="<?= $current_address ?>"  />
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" href="#" class="btn btn-success px-5 float-right">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
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
if ($this->session->userdata('SESS_SUCC_MSG')) {
?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success',
            subtitle: 'close',
            body: '<?php echo $this->session->userdata('SESS_SUCC_MSG'); ?>'
        })
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG');
}
?>

<?php function convert_id2name($array, $pos)
{
    $name = "";
    foreach ($array as $e) {
        if ($e->id == $pos) {
            $name = $e->name;
        }
    }
    if ($name == "") {
        $name = "error: can't be found";
    }
    return $name;
}
?>
</body>

</html>