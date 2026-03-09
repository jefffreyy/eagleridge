<html>
<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/myinfo_views_style'); ?>
<?php
$user_id = '';
$id_code = "EME";
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
$progress = 90;
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
                            <a href="<?= base_url() ?>selfservices/my_profile_emergency" class="mini-links active">Emergency</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_dependents" class="mini-links">Dependents</a>
                        </div>
                    </div>
                    <br>
                    <div class="card_container border-0">
                        <div>
                            <p style="font-size:20px">Emergency Contacts</p>
                            <div class="modal-btn"><a href="#" style="display: none;" data-target="#modal_add_emergency" data-toggle="modal"><i class="fas fa-plus"></i></i></a></div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table table-xs table-hover table-nowrap mb-0" style="border:none;">
                                        <tbody>
                                            <thead>
                                                <th>ID</th>
                                                <th>Relationship</th>
                                                <th>Mobile No.</th>
                                                <th>Home Phone</th>
                                                <th>Work Phone</th>
                                                <th>Current address</th>
                                            </thead>
                                            <?php
                                            if ($DISP_EMER_INFO) {
                                                foreach ($DISP_EMER_INFO as $ROW_EMER_INFO) {
                                                    $emergency_id = $id_code . str_pad($ROW_EMER_INFO->id, 5, '0', STR_PAD_LEFT);
                                            ?>
                                                    <tr>
                                                        <td>
                                                            <?= $emergency_id ?>
                                                        </td>
                                                        <td>
                                                            <?= $ROW_EMER_INFO->relationship ?>
                                                        </td>
                                                        <td>
                                                            <?= $ROW_EMER_INFO->mobile_number ?>
                                                        </td>
                                                        <td>
                                                            <?= $ROW_EMER_INFO->work_phone ?>
                                                        </td>
                                                        <td>
                                                            <?= $ROW_EMER_INFO->home_phone ?>
                                                        </td>
                                                        <td>
                                                            <?= $ROW_EMER_INFO->work_phone ?>
                                                        </td>
                                                        <td>
                                                            <?= $ROW_EMER_INFO->current_address ?>
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

    <div class="modal fade" id="modal_add_emergency" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Emergency Contacts</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('profile/insert_emergency'); ?>" id="ADD_EMER_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input class="form-control form-control " type="text" name="INSRT_EMER_EMPID" id="INSRT_EMER_EMPID" value="<?php echo $user_id; ?>" hidden>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Name</label>
                                    <input class="form-control form-control " type="text" name="INSRT_EMER_NAME" id="INSRT_EMER_NAME" required>
                                </div>

                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Relationship</label>
                                    <input class="form-control form-control " type="text" name="INSRT_EMER_RELA" id="INSRT_EMER_RELA" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Mobile Number</label>
                                    <input class="form-control form-control " type="text" name="INSRT_EMER_MNUM" id="INSRT_EMER_MNUM" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Work Phone</label>
                                    <input class="form-control form-control " type="text" name="INSRT_EMER_WPHN" id="INSRT_EMER_WPHN" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Home Phone</label>
                                    <input class="form-control form-control " type="text" name="INSRT_EMER_HPHN" id="INSRT_EMER_HPHN" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Current Address</label>
                                    <textarea class="form-control form-control" name="INSRT_EMER_ADDR" id="INSRT_EMER_ADDR" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' type="submit" id="EMER_BTN_INSRT">&nbsp; Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_edit_emergency" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Emergency Contacts</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('profile/update_emergency'); ?>" id="EDIT_EMER_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input class="form-control form-control " type="text" name="UPDT_EMER_ID" id="UPDT_EMER_ID" hidden>
                                <input class="form-control form-control " type="text" name="UPDT_EMER_EMPID" id="UPDT_EMER_EMPID" value="<?php echo $user_id; ?>" hidden>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Name</label>
                                    <input class="form-control form-control " type="text" name="UPDT_EMER_NAME" id="UPDT_EMER_NAME" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Relationship</label>
                                    <input class="form-control form-control " type="text" name="UPDT_EMER_RELA" id="UPDT_EMER_RELA" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Mobile Number</label>
                                    <input class="form-control form-control " type="text" name="UPDT_EMER_MNUM" id="UPDT_EMER_MNUM" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Work Phone</label>
                                    <input class="form-control form-control " type="text" name="UPDT_EMER_WPHN" id="UPDT_EMER_WPHN" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Home Phone</label>
                                    <input class="form-control form-control " type="text" name="UPDT_EMER_HPHN" id="UPDT_EMER_HPHN" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" class="required" for="UPDT_ID_SSS">Current Address</label>
                                    <textarea class="form-control form-control" name="UPDT_EMER_ADDR" id="UPDT_EMER_ADDR" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a class='btn btn-primary text-light' id="EMER_BTN_UPDT">&nbsp; Update</a>
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
    if ($this->session->userdata('SESS_SUCC_MSG_INSRT_EMERGENCY')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_EMERGENCY'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_EMERGENCY');
    }
    ?>

    <?php
    if ($this->session->userdata('SESS_SUCC_MSG_DLT_EMERGENCY')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_EMERGENCY'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_MSG_DLT_EMERGENCY');
    }
    ?>

    <?php
    if ($this->session->userdata('SESS_SUCC_MSG_UPDT_EMERGENCY')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_EMERGENCY'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_MSG_UPDT_EMERGENCY');
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
            var url = '<?php echo base_url(); ?>employees/get_emergency_data';
            const openModalButton = document.querySelectorAll('[data-target]');
            openModalButton.forEach(button => {
                button.addEventListener('click', () => {
                    const modal = document.querySelector(button.dataset.target);
                    get_dependents_data(url, button.getAttribute('DATA_ID')).then(data => {
                        if (data.length > 0) {
                            data.forEach((x) => {
                                document.getElementById('UPDT_EMER_ID').value = x.id;
                                document.getElementById('UPDT_EMER_EMPID').value = x.empid;
                                document.getElementById('UPDT_EMER_NAME').value = x.name;
                                document.getElementById('UPDT_EMER_RELA').value = x.relationship;
                                document.getElementById('UPDT_EMER_MNUM').value = x.mobile_number;
                                document.getElementById('UPDT_EMER_WPHN').value = x.work_phone;
                                document.getElementById('UPDT_EMER_HPHN').value = x.home_phone;
                                document.getElementById('UPDT_EMER_ADDR').value = x.current_address;
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

            $('#EMER_BTN_UPDT').click(function(e) {
                var UPDT_DEPT_NAME = $('#UPDT_EMER_NAME').val();
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
                            $('#EDIT_EMER_FORM').submit();
                        }
                    })
                } else {
                    $('#UPDT_EMER_NAME').addClass('is-invalid');
                }
            })
            $('#UPDT_EMER_NAME').keyup(function() {
                $('#UPDT_EMER_NAME').removeClass('is-invalid');
            })
            $('.EMERGENCY_BTN_DLT').click(function(e) {
                e.preventDefault();
                var user_deleteKey = $(this).attr('delete_key');
                var employee_key = $(this).attr('employee_id');
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
                        window.location.href = "<?= base_url(); ?>profile/delete_emergency?delete_id=" + user_deleteKey + "&employee_id=" + employee_key;
                    }
                })
            })
        })
    </script>
</body>

</html>