<html>
<?php $this->load->view('templates/css_link'); ?>
<?php

$user_id             = '';
$company_number      = '';
$company_email       = '';
$hired_on            = '';
$end_on              = '';
$regularization_date = '';
$employment_type     = '';
$position            = '';
$section             = '';
$department          = '';
$division            = '';
$clubhouse           = '';
$reporting_to        = '';
$group               = '';
$line                = '';
$activation          = '';
$team                = '';
$resignation_reason  = '';
$termination_reason  = '';

if ($C_EMP_INFO) {
    foreach ($C_EMP_INFO as $C_EMP_INFO_ROW) {
        $user_id                = $C_EMP_INFO_ROW->id;
        $hired_on               = $C_EMP_INFO_ROW->col_hire_date;
        $regularization_date    = $C_EMP_INFO_ROW->date_regular;
        $resignation_date       = $C_EMP_INFO_ROW->resignation_date;
        $termination_date       = $C_EMP_INFO_ROW->termination_date;
        $end_on                 = $C_EMP_INFO_ROW->col_endd_date;
        $employment_type        = $C_EMP_INFO_ROW->col_empl_type;
        $position               = $C_EMP_INFO_ROW->col_empl_posi;
        $branch_emp             = $C_EMP_INFO_ROW->col_empl_branch;
        $department             = $C_EMP_INFO_ROW->col_empl_dept;
        $division               = $C_EMP_INFO_ROW->col_empl_divi;
        $clubhouse               = $C_EMP_INFO_ROW->col_empl_club;
        $section                = $C_EMP_INFO_ROW->col_empl_sect;
        $groups                 = $C_EMP_INFO_ROW->col_empl_group;
        $line                   = $C_EMP_INFO_ROW->col_empl_line;
        $team                   = $C_EMP_INFO_ROW->col_empl_team;
        $company_number         = $C_EMP_INFO_ROW->col_comp_numb;
        $company_email          = $C_EMP_INFO_ROW->col_comp_emai;
        $resignation_reason       = $C_EMP_INFO_ROW->resignation_reason;
        $termination_reason     = $C_EMP_INFO_ROW->termination_reason;
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
                    <a href="<?= base_url() ?>employees/personal?id=<?= $user_id ?>">Personal Details</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Employment Details
                </li>
            </ol>
        </nav>
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title"><a href="<?= base_url() ?>employees/personal?id=<?= $user_id ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="">
                    </a>&nbsp;Edit Employment Details<h1>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <form action="<?php echo base_url('employees/update_employment_detail'); ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                    <div class="form-group">
                                        <label>Hired Date</label>
                                        <input class="form-control " type="date" name="UPDATE_HIRED_DATE" value="<?= $hired_on ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label>Regularization</label>
                                        <input class="form-control " type="date" name="UPDATE_REGULAR_DATE" value="<?= $regularization_date ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label>Resignation</label>
                                        <input class="form-control " type="date" name="UPDATE_RESIGN_DATE" value="<?= $resignation_date ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label>Resignation Reason</label>
                                        <select class="form-control" name="RESIGNATION_REASON">
                                            <option value=''>-Select Reason-</option>
                                            <?php if ($C_RESIGNATION_REASONS) {
                                                foreach ($C_RESIGNATION_REASONS as $row) {  ?>
                                                    <option value="<?= $row->id ?>" <?php if ($resignation_reason == $row->id) {
                                                                                        echo "Selected";
                                                                                    } ?>> <?= $row->name ?></option>
                                            <?php                                   }
                                            }   ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Termination</label>
                                        <input class="form-control " type="date" name="TERMINATION_DATE" value="<?= $termination_date ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label>Termination Reason</label>
                                        <select class="form-control" name="TERMINATION_REASON">
                                            <option value=''>-Select Reason-</option>
                                            <?php if ($C_TERMINATION_REASONS) {
                                                foreach ($C_TERMINATION_REASONS as $row) {  ?>
                                                    <option value="<?= $row->id ?>" <?php if ($termination_reason == $row->id) {
                                                                                        echo "Selected";
                                                                                    } ?>> <?= $row->name ?></option>
                                            <?php                                   }
                                            }   ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Last Day of Work</label>
                                        <input class="form-control " type="date" name="UPDATE_END" value="<?= $end_on ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label>Employment Type</label>
                                        <select class="form-control" name="UPDATE_EMP_TYPE">
                                        <option value=''>-Select Employment Type-</option>
                                            <?php if ($C_TYPE) {
                                                foreach ($C_TYPE as $C_TYPE_ROW) {  ?>
                                                    <option value="<?= $C_TYPE_ROW->id ?>" <?php if ($employment_type == $C_TYPE_ROW->id) {
                                                                                                echo "Selected";
                                                                                            } ?>> <?= $C_TYPE_ROW->name ?></option>
                                            <?php }
                                            }   ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Position</label>
                                        <select class="form-control" name="UPDATE_POSITION">
                                        <option value=''>-Select Position-</option>
                                            <?php if ($C_POSITIONS) {
                                                foreach ($C_POSITIONS as $C_POSITIONS_ROW) {  ?>
                                                    <option value="<?= $C_POSITIONS_ROW->id ?>" <?php if ($position == $C_POSITIONS_ROW->id) {
                                                                                                    echo "Selected";
                                                                                                } ?>> <?= $C_POSITIONS_ROW->name ?></option>
                                            <?php                                   }
                                            }   ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Branch</label>
                                        <select class="form-control" name="UPDATE_BRANCH">
                                        <option value=''>-Select Branch-</option>
                                            <?php if ($C_BRANCH) {
                                                foreach ($C_BRANCH as $C_BRANCH_ROW) {  ?>
                                                    <option value="<?= $C_BRANCH_ROW->id ?>" <?php if ($branch_emp == $C_BRANCH_ROW->id) {
                                                                                                    echo "Selected";
                                                                                                } ?>> <?= $C_BRANCH_ROW->name ?></option>
                                            <?php                                   }
                                            }   ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Department</label>
                                        <select class="form-control" name="UPDATE_DEPARTMENT">
                                        <option value=''>-Select Department-</option>
                                            <?php if ($C_DEPARTMENTS) {
                                                foreach ($C_DEPARTMENTS as $C_DEPARTMENTS_ROW) {  ?>
                                                    <option value="<?= $C_DEPARTMENTS_ROW->id ?>" <?php if ($department == $C_DEPARTMENTS_ROW->id) {
                                                                                                        echo "Selected";
                                                                                                    } ?>> <?= $C_DEPARTMENTS_ROW->name ?></option>
                                            <?php                                   }
                                            }   ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Division</label>
                                        <select class="form-control" name="UPDATE_DIVISION">
                                        <option value=''>-Select Division-</option>
                                            <?php if ($C_DIVISIONS) {
                                                foreach ($C_DIVISIONS as $C_DIVISIONS_ROW) {  ?>
                                                    <option value="<?= $C_DIVISIONS_ROW->id ?>" <?php if ($department == $C_DIVISIONS_ROW->id) {
                                                                                                    echo "Selected";
                                                                                                } ?>> <?= $C_DIVISIONS_ROW->name ?></option>
                                            <?php                                   }
                                            }   ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Clubhouse</label>
                                        <select class="form-control" name="UPDATE_CLUBHOUSE">
                                        <option value=''>-Select Clubhouse-</option>
                                            <?php if ($C_CLUBHOUSE) {
                                                foreach ($C_CLUBHOUSE as $C_CLUBHOUSE_ROW) {  ?>
                                                    <option value="<?= $C_CLUBHOUSE_ROW->id ?>" <?php if ($department == $C_CLUBHOUSE_ROW->id) {
                                                                                                    echo "Selected";
                                                                                                } ?>> <?= $C_CLUBHOUSE_ROW->name ?></option>
                                            <?php                                   }
                                            }   ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Sections</label>
                                        <select class="form-control" name="UPDATE_SECTION">
                                        <option value=''>-Select Section-</option>
                                            <?php if ($C_SECTIONS) {
                                                foreach ($C_SECTIONS as $C_SECTIONS_ROW) {  ?>
                                                    <option value="<?= $C_SECTIONS_ROW->id ?>" <?php if ($section == $C_SECTIONS_ROW->id) {
                                                                                                    echo "Selected";
                                                                                                } ?>> <?= $C_SECTIONS_ROW->name ?></option>
                                            <?php                                   }
                                            }   ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Groups</label>
                                        <select class="form-control" name="UPDATE_GROUPS">
                                        <option value=''>-Select Group-</option>
                                            <?php if ($C_GROUPS) {
                                                foreach ($C_GROUPS as $C_GROUPS_ROW) {  ?>
                                                    <option value="<?= $C_GROUPS_ROW->id ?>" <?php if ($groups == $C_GROUPS_ROW->id) {
                                                                                                    echo "Selected";
                                                                                                } ?>> <?= $C_GROUPS_ROW->name ?></option>
                                            <?php                                   }
                                            }   ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Line</label>
                                        <select class="form-control" name="UPDATE_LINE">
                                        <option value=''>-Select Line-</option>
                                            <?php if ($C_LINES) {
                                                foreach ($C_LINES as $C_LINES_ROW) {  ?>
                                                    <option value="<?= $C_LINES_ROW->id ?>" <?php if ($line == $C_LINES_ROW->id) {
                                                                                                echo "Selected";
                                                                                            } ?>> <?= $C_LINES_ROW->name ?></option>
                                            <?php                                   }
                                            }   ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Team</label>
                                        <select class="form-control" name="UPDATE_TEAM">
                                        <option value=''>-Select Team-</option>
                                            <?php if ($C_TEAMS) {
                                                foreach ($C_TEAMS as $C_TEAMS_ROW) {  ?>
                                                    <option value="<?= $C_TEAMS_ROW->id ?>" <?php if ($team == $C_TEAMS_ROW->id) {
                                                                                                echo "Selected";
                                                                                            } ?>> <?= $C_TEAMS_ROW->name ?></option>
                                            <?php                                   }
                                            }   ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Company Number</label>
                                        <input class="form-control " type="text" name="UPDATE_COMP_NUM" value="<?= $company_number ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Company Email</label>
                                        <input class="form-control " type="text" name="UPDATE_COMP_EMAIL" value="<?= $company_email ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>HMO Provider</label>
                                        <select class="form-control" name="UPDATE_HMO_PROV">
                                        <option value=''>-Select Provider-</option>
                                            <?php if ($C_HMO) {
                                                foreach ($C_HMO as $C_HMO_ROW) {  ?>
                                                    <option value="<?= $C_HMO_ROW->id ?>" <?php if ($hmo == $C_HMO_ROW->id) {
                                                                                                echo "Selected";
                                                                                            } ?>> <?= $C_HMO_ROW->name ?></option>
                                            <?php                                   }
                                            }   ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>HMO Number</label>
                                        <input class="form-control " type="text" name="UPDATE_HMO_NUM" value="<?= $hmo_number ?>">
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