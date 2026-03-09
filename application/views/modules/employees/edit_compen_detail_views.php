<html>
<?php $this->load->view('templates/css_link'); ?>
<?php
$user_id = '';
if ($C_EMP_INFO) {
    foreach ($C_EMP_INFO as $C_EMP_INFO_ROW) {
        $user_id                = $C_EMP_INFO_ROW->id;
        $salary_rate            = $C_EMP_INFO_ROW->salary_rate;
        $salary_type            = $C_EMP_INFO_ROW->salary_type;
        $bank                   = $C_EMP_INFO_ROW->bank_name;
        $branch                 = $C_EMP_INFO_ROW->branch_name;
        $account_number         = $C_EMP_INFO_ROW->account_number;
        $account_type           = $C_EMP_INFO_ROW->account_type;
        $payment_type           = $C_EMP_INFO_ROW->payment_type;
    }
}
?>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>employees/directories">Employee List</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>employees/personal?id=<?= $user_id ?>">Personal Details</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Compensation Details
                </li>
            </ol>
        </nav>
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title"><a href="<?= base_url() ?>employees/personal?id=<?= $user_id ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="">
                    </a>&nbsp;Edit Compensation Details<h1>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <form action="<?php echo base_url('employees/update_comp_detail'); ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="user_id" value="<?= $user_id ?>">

                                    <div class="form-group">
                                        <label>Bank</label>
                                        <input class="form-control " type="text" name="UPDATE_BANK" value="<?= $bank ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label>Branch</label>
                                        <input class="form-control " type="text" name="UPDATE_BRANCH" value="<?= $branch ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label>Account Type</label>
                                        <input class="form-control " type="text" name="UPDATE_ACC_TYPE" value="<?= $account_type ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label>Payment Type</label>
                                        <input class="form-control " type="text" name="UPDATE_PAY_TYPE" value="<?= $payment_type ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label>Account Number</label>
                                        <input class="form-control " type="text" name="UPDATE_ACC_NUMBER" value="<?= $account_number ?>" />
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

<aside class="control-sidebar control-sidebar-dark">
</aside>
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
</body>

</html>