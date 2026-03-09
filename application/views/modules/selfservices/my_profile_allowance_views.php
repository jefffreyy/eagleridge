<html>
<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/myinfo_views_style'); ?>
<?php
$user_id = '';
$user_image = '';
$lastname = '';
$middlename = '';
$firstname = '';
$full_name = '';
$company_number = '';
$company_email = '';
$hired_on = '';
$employment_type = '';
$position = '';
$section = '';
$department = '';
$division = '';
$reporting_to = '';
$sss = '';
$hdmf = '';
$philhealth = '';
$tin = '';
$drivers_license = '';
$national_id = '';
$passport = '';
$progress = 45;
$daily_allowance = '';
$pioneer_allowance = '';
$load_allowance = '';
$skill_allowance = '';
$group_allowance = '';
$transportation_allowance = '';
if ($DISP_EMP_INFO) {
    foreach ($DISP_EMP_INFO as $DISP_EMP_INFO_ROW) {
        $user_id = $DISP_EMP_INFO_ROW->id;
        $user_image = $DISP_EMP_INFO_ROW->col_imag_path;
        $lastname = $DISP_EMP_INFO_ROW->col_last_name;
        $middlename = $DISP_EMP_INFO_ROW->col_midl_name;
        $firstname = $DISP_EMP_INFO_ROW->col_frst_name;
        if ($middlename) {
            $full_name = $lastname . ', ' . $firstname . ' ' . ucfirst($middlename[0]) . '.';
        } else {
            $full_name = $lastname . ', ' . $firstname;
        }
        $company_number = $DISP_EMP_INFO_ROW->col_comp_numb;
        $company_email = $DISP_EMP_INFO_ROW->col_comp_emai;
        $hired_on = $DISP_EMP_INFO_ROW->col_hire_date;
        $employment_type = $DISP_EMP_INFO_ROW->col_empl_type;
        $position = $DISP_EMP_INFO_ROW->col_empl_posi;
        $section = $DISP_EMP_INFO_ROW->col_empl_sect;
        $department = $DISP_EMP_INFO_ROW->col_empl_dept;
        $division = $DISP_EMP_INFO_ROW->col_empl_divi;
        $reporting_to = $DISP_EMP_INFO_ROW->col_empl_repo;
        $sss = $DISP_EMP_INFO_ROW->col_empl_sssc;
        $hdmf = $DISP_EMP_INFO_ROW->col_empl_hdmf;
        $philhealth = $DISP_EMP_INFO_ROW->col_empl_phil;
        $tin = $DISP_EMP_INFO_ROW->col_empl_btin;
        $drivers_license = $DISP_EMP_INFO_ROW->col_empl_driv;
        $national_id = $DISP_EMP_INFO_ROW->col_empl_naid;
        $passport = $DISP_EMP_INFO_ROW->col_empl_pass;
    }
}
?>

<body>
    <div class="content-wrapper">
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
                    <?php $this->load->view('templates/partials/profile_header', array(
                        'full_name' => $full_name,
                        'user_image' => $user_image,
                        'is_active' => $DISP_USER_INFO[0]->disabled,
                        'employment_type' => $employment_type,
                        'position' => $position,
                        'department' => $department
                    )); ?>

                </div>
                <div class="card col-md-12">
                    <div class="row">
                        <div class="mini-nav">
                            <a href="<?= base_url() ?>selfservices/my_profile_personal" class="mini-links">Personal</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_ids" class="mini-links">ID's</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_job" class="mini-links">Job</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_allowance" class="mini-links active">Allowance</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_documents" class="mini-links">Documents</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_emergency" class="mini-links">Emergency</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_dependents" class="mini-links">Dependents</a>
                        </div>
                    </div>
                    <br>
                    <div class="card_container d-block border-0">
                        <div class="card-title">Allowances
                            <div class="modal-btn"><a data-toggle="modal" style="display: none;" href="#" data-target="#modal_update_ids"><i class="fas fa-pencil-alt"></i></a></div>
                        </div>
                        <br>
                        <hr>
                        <div class="row mt-4">
                            <div class="col col-md-3 text-bold">
                                Daily Allowance
                            </div>
                            <div class="col col-md-8">
                                <span style="font-weight:normal"><?php if ($daily_allowance) {
                                                                        echo number_format($daily_allowance, 2, '.', "");
                                                                    } else {
                                                                        echo '0.00';
                                                                    }  ?></span>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col col-md-3 text-bold">
                                Pioneer Allowance
                            </div>
                            <div class="col col-md-8">
                                <span style="font-weight:normal"><?php if ($pioneer_allowance) {
                                                                        echo number_format($pioneer_allowance, 2, '.', "");
                                                                    } else {
                                                                        echo '0.00';
                                                                    }  ?></span>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col col-md-3 text-bold">
                                Load Allowance
                            </div>
                            <div class="col col-md-8">
                                <span style="font-weight:normal"><?php if ($load_allowance) {
                                                                        echo number_format($load_allowance, 2, '.', "");
                                                                    } else {
                                                                        echo '0.00';
                                                                    }  ?></span>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col col-md-3 text-bold">
                                Skill Allowance
                            </div>
                            <div class="col col-md-8">
                                <span style="font-weight:normal"><?php if ($skill_allowance) {
                                                                        echo number_format($skill_allowance, 2, '.', "");
                                                                    } else {
                                                                        echo '0.00';
                                                                    }  ?></span>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col col-md-3 text-bold">
                                Group Leader Allowance
                            </div>
                            <div class="col col-md-8">
                                <span style="font-weight:normal"><?php if ($group_allowance) {
                                                                        echo number_format($group_allowance, 2, '.', "");
                                                                    } else {
                                                                        echo '0.00';
                                                                    }  ?></span>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col col-md-3 text-bold">
                                Transportation Allowance
                            </div>
                            <div class="col col-md-8">
                                <span style="font-weight:normal"><?php if ($transportation_allowance) {
                                                                        echo number_format($transportation_allowance, 2, '.', "");
                                                                    } else {
                                                                        echo '0.00';
                                                                    }  ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
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
        })
    </script>
</body>

</html>