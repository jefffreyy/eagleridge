<html>
<?php $this->load->view('templates/css_link'); ?>
<?php 
    $user_id = '';
    $company_number = '';
    $company_email = '';
    $hired_on = '';
    $end_on = '';
    $regularization_date = '';
    $employment_type = '';
    $position = '';
    $section = '';
    $department = '';
    $division = '';
    $reporting_to = '';
    $group = '';
    $line = '';
    $activation = '';
    $team = '';
    if($C_EMP_INFO){
        foreach($C_EMP_INFO as $C_EMP_INFO_ROW){
            $user_id                = $C_EMP_INFO_ROW->id;
            $hired_on               = $C_EMP_INFO_ROW->col_hire_date;
            $regularization_date    = $C_EMP_INFO_ROW->date_regular;
            $resignation_date       = $C_EMP_INFO_ROW->resignation_date;
            $end_on                 = $C_EMP_INFO_ROW->col_endd_date;
            $employment_type        = $C_EMP_INFO_ROW->col_empl_type;
            $position               = $C_EMP_INFO_ROW->col_empl_posi;
            $branch_emp             = $C_EMP_INFO_ROW->col_empl_branch;
            $department             = $C_EMP_INFO_ROW->col_empl_dept;
            $division               = $C_EMP_INFO_ROW->col_empl_divi;
            $section                = $C_EMP_INFO_ROW->col_empl_sect;
            $groups                 = $C_EMP_INFO_ROW->col_empl_group;
            $line                   = $C_EMP_INFO_ROW->col_empl_line;
            $team                   = $C_EMP_INFO_ROW->col_empl_team;
            $company_number         = $C_EMP_INFO_ROW->col_comp_numb;
            $company_email          = $C_EMP_INFO_ROW->col_comp_emai;
            // Jobs Info
            $hmo                    = $C_EMP_INFO_ROW->col_empl_hmoo;
            $hmo_number             = $C_EMP_INFO_ROW->col_empl_hmon;
            $reporting_to           = $C_EMP_INFO_ROW->col_empl_repo;
            $activation             = $C_EMP_INFO_ROW->disabled;
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
                    <a href="<?= base_url() ?>employees/personal?id=<?=$user_id?>" >Personal Details</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Employment Details
                </li>
            </ol>
        </nav>
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <!-- form start -->
                    <form action="<?php echo base_url('employees/update_employment_detail'); ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="user_id" value="<?=$user_id?>" >
                                    <div class="form-group">
                                        <label>Hired Date</label>
                                        <input class="form-control " type="date" name="UPDATE_HIRED_DATE" value="<?=$hired_on?>" />
                                    </div>
                                    <div class="form-group">
                                        <label>Regularization</label>
                                        <input class="form-control " type="date" name="UPDATE_REGULAR_DATE" value="<?=$regularization_date?>" />
                                    </div>
                                    <div class="form-group">
                                        <label>Resignation</label>
                                        <input class="form-control " type="date" name="UPDATE_RESIGN_DATE" value="<?=$resignation_date?>" />
                                    </div>
                                    <div class="form-group">
                                        <label>Last Day of Work</label>
                                        <input class="form-control " type="date" name="UPDATE_END" value="<?=$end_on?>" />
                                    </div>
                                    <div class="form-group">
                                        <label >Employment Type</label>
                                        <select class="form-control" name="UPDATE_EMP_TYPE" >
                                        <?php if($C_TYPE) {
                                        foreach($C_TYPE as $C_TYPE_ROW){  ?>  
                                            <option value="<?=$C_TYPE_ROW->id?>" <?php  if($employment_type == $C_TYPE_ROW->id){echo"Selected";} ?>> <?=$C_TYPE_ROW->name?></option>
                                        <?php }  }   ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Position</label>
                                        <select class="form-control" name="UPDATE_POSITION" >
<?php                               if($C_POSITIONS) {
                                        foreach($C_POSITIONS as $C_POSITIONS_ROW){  ?>  
                                            <option value="<?=$C_POSITIONS_ROW->id?>" <?php  if($position == $C_POSITIONS_ROW->id){echo"Selected";} ?>> <?=$C_POSITIONS_ROW->name?></option>
<?php                                   } 
                                    }   ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Branch</label>
                                        <select class="form-control" name="UPDATE_BRANCH" >
<?php                               if($C_BRANCH) {
                                        foreach($C_BRANCH as $C_BRANCH_ROW){  ?>  
                                            <option value="<?=$C_BRANCH_ROW->id?>" <?php  if($branch_emp == $C_BRANCH_ROW->id){echo"Selected";} ?>> <?=$C_BRANCH_ROW->name?></option>
<?php                                   } 
                                    }   ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Department</label>
                                        <select class="form-control" name="UPDATE_DEPARTMENT">
<?php                               if($C_DEPARTMENTS) {
                                        foreach($C_DEPARTMENTS as $C_DEPARTMENTS_ROW){  ?>  
                                            <option value="<?=$C_DEPARTMENTS_ROW->id?>" <?php  if($department == $C_DEPARTMENTS_ROW->id){echo"Selected";} ?>> <?=$C_DEPARTMENTS_ROW->name?></option>
<?php                                   } 
                                    }   ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Division</label>
                                        <select class="form-control" name="UPDATE_DIVISION" >
<?php                               if($C_DIVISIONS) {
                                        foreach($C_DIVISIONS as $C_DIVISIONS_ROW){  ?>  
                                            <option value="<?=$C_DIVISIONS_ROW->id?>" <?php  if($department == $C_DIVISIONS_ROW->id){echo"Selected";} ?>> <?=$C_DIVISIONS_ROW->name?></option>
<?php                                   } 
                                    }   ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Sections</label>
                                        <select class="form-control" name="UPDATE_SECTION" >
<?php                               if($C_SECTIONS) {
                                        foreach($C_SECTIONS as $C_SECTIONS_ROW){  ?>  
                                            <option value="<?=$C_SECTIONS_ROW->id?>" <?php  if($section == $C_SECTIONS_ROW->id){echo"Selected";} ?>> <?=$C_SECTIONS_ROW->name?></option>
<?php                                   } 
                                    }   ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Groups</label>
                                        <select class="form-control" name="UPDATE_GROUPS" >
<?php                               if($C_GROUPS) {
                                        foreach($C_GROUPS as $C_GROUPS_ROW){  ?>  
                                            <option value="<?=$C_GROUPS_ROW->id?>" <?php  if($groups == $C_GROUPS_ROW->id){echo"Selected";} ?>> <?=$C_GROUPS_ROW->name?></option>
<?php                                   } 
                                    }   ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Line</label>
                                        <select class="form-control" name="UPDATE_LINE" >
<?php                               if($C_LINES) {
                                        foreach($C_LINES as $C_LINES_ROW){  ?>  
                                            <option value="<?=$C_LINES_ROW->id?>" <?php  if($line == $C_LINES_ROW->id){echo"Selected";} ?>> <?=$C_LINES_ROW->name?></option>
<?php                                   } 
                                    }   ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Team</label>
                                        <select class="form-control" name="UPDATE_TEAM" >
<?php                               if($C_TEAMS) {
                                        foreach($C_TEAMS as $C_TEAMS_ROW){  ?>  
                                            <option value="<?=$C_TEAMS_ROW->id?>" <?php  if($team == $C_TEAMS_ROW->id){echo"Selected";} ?>> <?=$C_TEAMS_ROW->name?></option>
<?php                                   } 
                                    }   ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Company Number</label>
                                        <input class="form-control " type="text" name="UPDATE_COMP_NUM" value="<?=$company_number?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Company Email</label>
                                        <input class="form-control " type="text" name="UPDATE_COMP_EMAIL"  value="<?=$company_email?>">
                                    </div>
                                    <div class="form-group">
                                        <label>HMO Provider</label>
                                        <select class="form-control" name="UPDATE_HMO_PROV" >
<?php                               if($C_HMO) {
                                        foreach($C_HMO as $C_HMO_ROW){  ?>  
                                            <option value="<?=$C_HMO_ROW->id?>" <?php  if($hmo == $C_HMO_ROW->id){echo"Selected";} ?>> <?=$C_HMO_ROW->name?></option>
<?php                                   } 
                                    }   ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>HMO Number</label>
                                        <input class="form-control " type="text" name="UPDATE_HMO_NUM" value="<?=$hmo_number?>">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" href="#" class="btn btn-success px-5 float-right">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- form ends -->
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