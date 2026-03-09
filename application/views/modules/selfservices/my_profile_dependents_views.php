<html>
<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/myinfo_views_style'); ?>
<?php
$user_id = '';
$id_code = "DEP";
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
                            <a href="<?= base_url() ?>selfservices/my_profile_allowance" class="mini-links">Allowance</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_documents" class="mini-links">Documents</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_emergency" class="mini-links">Emergency</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_dependents" class="mini-links active">Dependents</a>
                        </div>
                    </div>
                    <br>
                    <div class="card_container border-0">
                        <div class="mb-0">
                            <p style="font-size:20px">Dependents</p>
                            <div class="modal-btn">
                                <a href="#" style="display: none;" data-target="#modal_add_dependents" data-toggle="modal"><i class="fas fa-plus"></i></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table table-xs table-hover table-nowrap mb-0" style="border: none;">
                                        <thead>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Birth&nbsp;Date</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Relationship</th>
                                            <th style="display: none;"></th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($DISP_DEPE_INFO) {
                                                foreach ($DISP_DEPE_INFO as $ROW_DEPE_INFO) {
                                                    $dependent_id = $id_code . str_pad($ROW_DEPE_INFO->id, 5, '0', STR_PAD_LEFT);
                                                    $date_birth = date_create($ROW_DEPE_INFO->col_depe_bday);
                                                    $birthDate = date_format($date_birth, "m-d-Y");
                                                    $birthDate = explode("-", $birthDate);
                                                    $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                                                        ? ((date("Y") - $birthDate[2]) - 1)
                                                        : (date("Y") - $birthDate[2]));
                                            ?>
                                                    <tr>
                                                        <td><?= $dependent_id ?></td>
                                                        <td><?= $ROW_DEPE_INFO->col_depe_name ?></td>
                                                        <td><?php
                                                            $DATE = date_create($ROW_DEPE_INFO->col_depe_bday);
                                                            echo date_format($DATE, "m-d-Y");
                                                            ?>
                                                        </td>
                                                        <td><?= $age ?></td>
                                                        <td><?= $ROW_DEPE_INFO->col_depe_gndr ?></td>
                                                        <td><?= $ROW_DEPE_INFO->col_depe_rela ?></td>
                                                        <td>
                                                            <a style="display: none;" class="btn btn-sm indigo lighten-2 float-right text-danger DEPENDENTS_BTN_DLT" delete_key="<?= $ROW_DEPE_INFO->id ?>" employee_id="<?= $user_id ?>"><i class="fas fa-trash text-danger"></i></a>
                                                            <a style="display: none;" class="btn btn-sm indigo lighten-2 float-right ml-2" DATA_ID="<?= $ROW_DEPE_INFO->id ?>" title="Edit" data-toggle="modal" data-target="#modal_edit_dependents"><i class="fas fa-edit"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr class="table-active">
                                                    <td colspan="9">
                                                        <center>No Data Yet</center>
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
            </div>
        </div>
    </div>
    <aside class="control-sidebar control-sidebar-dark"></aside>
    <div class="modal fade" id="modal_add_dependents" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Dependents</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('profile/insert_dependents'); ?>" id="ADD_DEPE_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input class="form-control form-control " type="text" name="INSRT_DEPT_EMPID" id="INSRT_DEPT_EMPID" value="<?php echo $user_id; ?>" hidden>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Name</label>
                                    <input class="form-control form-control " type="text" name="INSRT_DEPT_NAME" id="INSRT_DEPT_NAME" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Birthday</label>
                                    <input class="form-control form-control " type="date" name="INSRT_DEPT_BDAY" id="INSRT_DEPT_BDAY" required>
                                </div>

                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Gender</label>
                                    <select name="INSRT_DEPT_GNDR" id="INSRT_DEPT_GNDR" class="form-control" required>
                                        <option value="">Choose...</option>
                                        <?php
                                        foreach ($DISP_EMP_GENDER as $DISP_EMP_GENDER_ROW) {
                                        ?>
                                            <option value="<?= $DISP_EMP_GENDER_ROW->name ?>"><?= $DISP_EMP_GENDER_ROW->name ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Relationship</label>
                                    <input class="form-control form-control " type="text" name="INSRT_DEPT_RELA" id="INSRT_DEPT_RELA" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="DEPE_BTN_INSRT">&nbsp; Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edit_dependents" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Dependents</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('profile/update_dependents'); ?>" id="EDIT_DEPE_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input class="form-control form-control " type="text" name="UPDT_DEPT_ID" id="UPDT_DEPT_ID" hidden>
                                <input class="form-control form-control " type="text" name="UPDT_DEPT_EMPID" id="UPDT_DEPT_EMPID" hidden>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Name</label>
                                    <input class="form-control form-control " type="text" name="UPDT_DEPT_NAME" id="UPDT_DEPT_NAME" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Birthday</label>
                                    <input class="form-control form-control " type="date" name="UPDT_DEPT_BDAY" id="UPDT_DEPT_BDAY" required>
                                </div>

                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Gender</label>
                                    <input class="form-control form-control " type="text" name="UPDT_DEPT_GNDR" id="UPDT_DEPT_GNDR" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Relationship</label>
                                    <input class="form-control form-control " type="text" name="UPDT_DEPT_RELA" id="UPDT_DEPT_RELA" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class='btn btn-primary text-light' type="submit" id="DEPENDENTS_BTN_UPDT">&nbsp; Update</a>
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
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <?php $this->load->view('templates/jquery_link'); ?>
    <?php
    if ($this->session->userdata('SESS_SUCC_MSG_INSRT_DEPENDENTS')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_DEPENDENTS'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_DEPENDENTS');
    }
    ?>

    <?php
    if ($this->session->userdata('SESS_SUCC_MSG_DLT_DEPENDENTS')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_DEPENDENTS'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_MSG_DLT_DEPENDENTS');
    }
    ?>
    <?php
    if ($this->session->userdata('SESS_SUCC_MSG_UPDT_DEPENDENTS')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_DEPENDENTS'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_MSG_UPDT_DEPENDENTS');
    }
    ?>
    <script>
        $(function() {
            $('div#froala-editor').froalaEditor({
                toolbarButtons: ['undo', 'redo', '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting', 'html'],
                toolbarButtonsXS: ['undo', 'redo', '-', 'bold', 'italic', 'html']
            })
            $('i.fa.fa-rotate-left').attr('class')
        });
    </script>
    <script>
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
            var url = '<?php echo base_url(); ?>employees/get_dependents_data';
            const openModalButton = document.querySelectorAll('[data-target]');
            openModalButton.forEach(button => {
                button.addEventListener('click', () => {
                    const modal = document.querySelector(button.dataset.target);
                    get_dependents_data(url, button.getAttribute('DATA_ID')).then(data => {
                        if (data.length > 0) {
                            data.forEach((x) => {
                                document.getElementById('UPDT_DEPT_ID').value = x.id;
                                document.getElementById('UPDT_DEPT_EMPID').value = x.col_depe_empid;
                                document.getElementById('UPDT_DEPT_NAME').value = x.col_depe_name;
                                document.getElementById('UPDT_DEPT_BDAY').value = x.col_depe_bday;
                                document.getElementById('UPDT_DEPT_GNDR').value = x.col_depe_gndr;
                                document.getElementById('UPDT_DEPT_RELA').value = x.col_depe_rela;
                            });
                        }
                    });
                });
            });

            async function get_dependents_data(url, DATA_ID) {
                var formData = new FormData();
                formData.append('DATA_ID', DATA_ID);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            $('#DEPENDENTS_BTN_UPDT').click(function(e) {
                var UPDT_DEPT_NAME = $('#UPDT_DEPT_NAME').val();
                var hasErr = 0;
                if (!UPDT_DEPT_NAME) {
                    hasErr++;
                }
                if (hasErr == 0) {
                    Swal.fire({
                        title: 'Do you want to save the following changes?',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#EDIT_DEPE_FORM').submit();
                        }
                    })
                } else {
                    $('#UPDT_DEPT_NAME').addClass('is-invalid');
                }
            })
            $('#UPDT_DEPT_NAME').keyup(function() {
                $('#UPDT_DEPT_NAME').removeClass('is-invalid');
            })
            $('.DEPENDENTS_BTN_DLT').click(function(e) {
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
                        window.location.href = "<?= base_url(); ?>profile/delete_dependents?delete_id=" + user_deleteKey + "&employee_id=" + employee_id;
                    }
                })
            })
        })
    </script>
</body>

</html>