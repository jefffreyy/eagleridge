<html>
<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/myinfo_views_style'); ?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<style>
    .text-muted{
        color:red;
    }
    </style>
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
$style = 'color:red';
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
<body>
    <!-- Content Starts -->
    <div class="content-wrapper">
        <!-- <div class = "nav-top">
            <a href = "#" class = "top-left"><i class="fas fa-angle-left"></i>  Previous</a>
            <div class = "top-right">
                <a href = "#">Next  <i class="fas fa-angle-right"></i></a>
                <a href = "#" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <h6 class="dropdown-header text-left">Self-Service...</h6>
                    <a class="dropdown-item ml-0" href="#">Reset Password</a>
                    <a class="dropdown-item ml-0" href="#">Send Welcome Letter</a>
                    <a class="dropdown-item ml-0" href="#">Login as User</a>
                    <a class="dropdown-item ml-0" href="#">Disable Self-Service Access</a>
                    <a class="dropdown-item ml-0" href="#">Leave Policy</a>
                    <a class="dropdown-item ml-0" href="#">Terminate Employee...</a>
                    <a class="dropdown-item ml-0 text-danger" href="#">Delete Employee</a>
                </div>
            </div>
        </div> -->
        <div class="container-fluid p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>selfservices">Self-Service
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">My Personal Profile
                </li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                <?php $this->load->view('templates/partials/profile_header',array(
                    'full_name'=>$full_name,
                    'user_image'=>$user_image,
                    'is_active'=>$DISP_USER_INFO[0]->disabled,
                    'employment_type'=>$employment_type,
                    'position'=>$position,
                    'department'=>$department
                )); ?>
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="card border-0">
                                <div class="card-title">Company Number</div>
                                <?= $company_number ?>
                                <div class="card-title mt-2">Company Email</div>
                                <?= $company_email ?>
                                <hr>
                                <div class="card-title mt-2">Hired On</div>
                                <?= $hired_on ?>
                                <div class="card-title mt-2">Employment Type</div>
                                <?= $employment_type ?>
                                <div class="card-title mt-2">Position</div>
                                <?= $position ?>
                                <div class="card-title mt-2">Section</div>
                                <?= $section ?>
                                <div class="card-title mt-2">Department</div>
                                <?= $department ?>
                                <div class="card-title mt-2">Division</div>
                                <?= $division ?>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class = "row">
                        <div class = "col-md-12">
                            <div class="card">
                                <h6 class="card-title">
                                <i class="fas fa-user-tie mr-2"></i> Reports To
                                </h6>
                                <div class="table-responsive mt-3">
                                    <table class="table table-xs" style="border: none !important;">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php
                                                        $reporting = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($reporting_to);
                                                        $manager_name = $reporting[0]->col_frst_name . ' ' . $reporting[0]->col_last_name;
                                                        $manager_position = $reporting[0]->col_empl_posi;
                                                        ?>
                                                        <div class="mr-3">
                                                            <a href="#">
                                                                <img class="rounded-circle avatar" src="<?= base_url() ?>user_images/<?= $reporting[0]->col_imag_path; ?>" style="width: 50px; height: 50px;">
                                                            </a>                      
                                                        </div>
                                                        <div>
                                                            <strong><a href="<?= base_url() ?>employees/personal?id=<?= $reporting[0]->id ?>"><?= $manager_name ?></a></strong>
                                                            <div class="small text-muted">
                                                                <?= $manager_position ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class="card">
                                <h6 class="card-title">
                                <i class="fas fa-sitemap mr-2"></i> Direct Reports
                                </h6>
                                <div class="table-responsive mt-3">
                                    <table class="table table-xs" style="border: none !important;">
                                        <tbody>
                                            <?php if ($DISP_EMP_DIRECT_REPORTS) {
                                                foreach ($DISP_EMP_DIRECT_REPORTS as $DISP_EMP_DIRECT_REPORTS_ROW) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="mr-3">
                                                            <a href="#">
                                                                <img class="rounded-circle avatar" src="<?= base_url() ?>user_images/<?= $DISP_EMP_DIRECT_REPORTS_ROW->col_imag_path; ?>" style="width: 50px; height: 50px;">
                                                            </a>                      
                                                        </div>
                                                        <div>
                                                            <strong><a href="<?= base_url() ?>employees/personal?id=<?= $DISP_EMP_DIRECT_REPORTS_ROW->id ?>"><?= $DISP_EMP_DIRECT_REPORTS_ROW->col_frst_name . ' ' . $DISP_EMP_DIRECT_REPORTS_ROW->col_last_name ?></a></strong>
                                                            <div class="small text-muted">
                                                                <?= $DISP_EMP_DIRECT_REPORTS_ROW->col_empl_posi ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php }
                                            } else { ?>
                                                <div class="text-center text-muted" >
                                                    Employee does not have any direct reports
                                                </div>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="card  col-md-12">
                    <div class="row">
                    <div class="mini-nav">
                            <a href="<?= base_url() ?>selfservices/my_profile_personal"      class="mini-links">Personal</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_ids"           class="mini-links active">ID's</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_job"           class="mini-links">Job</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_allowance"     class="mini-links">Allowance</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_documents"     class="mini-links">Documents</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_emergency"     class="mini-links">Emergency</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_dependents"    class="mini-links">Dependents</a>
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
                                                                        echo '<em class="text-danger">No Details</em>';
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
                                                                        echo '<em class="text-danger">No Details</em>';
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
                                                                        echo '<em class="text-danger">No Details</em>';
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
                                                                        echo '<em class="text-danger">No Details</em>';
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
                                                                        echo '<em class="text-danger">No Details</em>';
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
                                                                        echo '<em class="text-danger">No Details</em>';
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
                                                                        echo '<em class="text-danger">No Details</em>';
                                                                    }  ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                </div>
            </div>
            <!-- Edit position -->
            <div class="modal fade" id="modal_update_ids" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header pb-0" style="border-bottom: none;">
                            <h4 class="modal-title ml-1" id="exampleModalLabel">Add/Update IDs</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?php echo base_url('profile/update_employee_id'); ?>" id="UPDT_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="UPDT_ID_SSS">SSS</label>
                                            <input class="form-control form-control " type="text" name="UPDT_ID_SSS" value="<?php if ($sss) {
                                                                                                                                echo $sss;
                                                                                                                            } else {
                                                                                                                                echo '';
                                                                                                                            } ?>" id="UPDT_ID_SSS" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="UPDT_ID_SSS">HDMF</label>
                                            <input class="form-control form-control " type="text" name="UPDT_ID_HDMF" value="<?php if ($hdmf) {
                                                                                                                                    echo $hdmf;
                                                                                                                                } else {
                                                                                                                                    echo '';
                                                                                                                                } ?>" id="UPDT_ID_HDMF" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="UPDT_ID_PHIL">Philhealth</label>
                                            <input class="form-control form-control " type="text" name="UPDT_ID_PHIL" value="<?php if ($philhealth) {
                                                                                                                                    echo $philhealth;
                                                                                                                                } else {
                                                                                                                                    echo '';
                                                                                                                                } ?>" id="UPDT_ID_PHIL" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="UPDT_ID_TIN">TIN</label>
                                            <input class="form-control form-control " type="text" name="UPDT_ID_TIN" value="<?php if ($drivers_license) {
                                                                                                                                echo $drivers_license;
                                                                                                                            } else {
                                                                                                                                echo '';
                                                                                                                            } ?>" id="UPDT_ID_TIN" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="UPDT_ID_DRV">Driver's License</label>
                                            <input class="form-control form-control " type="text" name="UPDT_ID_DRV" value="<?php if ($national_id) {
                                                                                                                                echo $national_id;
                                                                                                                            } else {
                                                                                                                                echo '';
                                                                                                                            } ?>" id="UPDT_ID_DRV" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="UPDT_ID_NAT">National ID</label>
                                            <input class="form-control form-control " type="text" name="UPDT_ID_NAT" value="<?php if ($passport) {
                                                                                                                                echo $passport;
                                                                                                                            } else {
                                                                                                                                echo '';
                                                                                                                            } ?>" id="UPDT_ID_NAT" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="UPDT_ID_PSSP">Passport</label>
                                            <input class="form-control form-control " type="text" name="UPDT_ID_PSSP" value="<?php if ($sss) {
                                                                                                                                    echo $sss;
                                                                                                                                } else {
                                                                                                                                    echo '';
                                                                                                                                } ?>" id="UPDT_ID_PSSP" required>
                                        </div>
                                    </div>
                                    <input type="hidden" name="UPDT_EMP_ID" id="UPDT_EMP_ID" value="<?= $user_id ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a class='btn btn-primary text-light' id="BTN_UPDT">&nbsp; Update</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit Profile Image -->
            <div class="modal fade" id="modal_edit_image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header pb-0" style="border-bottom: none;">
                            <h4 class="modal-title ml-1" id="exampleModalLabel">Update Profile Photo</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?php echo base_url('profile/edit_image'); ?>" id="edit_image_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                            <div class="modal-body">
                                <hr>
                                <div class="edit_profile_pic w-100 text-center">
                                    <img class="avatar" id="employee_img_modal" style="cursor: pointer;" width="300" height="300" src="<?php if ($user_image) {
                                                                                                                                            echo base_url() . 'assets_user/user_profile/' . $user_image;
                                                                                                                                        } else {
                                                                                                                                            echo base_url() . 'assets_system/images/default_user.jpg';
                                                                                                                                        } ?>">
                                </div>
                                <div class="form-group mt-3">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input fileficker" id="upload_image" name="employee_image" multiple="" accept=".jpg, .png" required>
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
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->
    <?php $this->load->view('templates/jquery_link'); ?>
    <?php
    if ($this->session->userdata('SESS_SUCC_UPDT')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_UPDT'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_UPDT');
    }
    ?>
    <script>
        $('#BTN_UPDT').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Do you want to save changes?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#UPDT_FORM').submit();
                }
            })
        })
        $(document).ready(function() {
            // Update Image
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
            // Toggle modal by clicking the employee's profile photo
            $('#employee_img').click(function() {
                // $('#modal_edit_image').modal('toggle');
            })
        })
    </script>
</body>
</html>