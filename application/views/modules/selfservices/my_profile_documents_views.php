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
$progress = 5;
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
                    <?php $this->load->view(
                        'templates/partials/profile_header',
                        array(
                            'full_name' => $full_name,
                            'user_image' => $user_image,
                            'is_active' => $DISP_USER_INFO[0]->disabled,
                            'employment_type' => $employment_type,
                            'position' => $position,
                            'department' => $department
                        )
                    ); ?>


                </div>
                <div class="card col-md-12">
                    <div class="row">
                        <div class="mini-nav">
                            <a href="<?= base_url() ?>selfservices/my_profile_personal" class="mini-links">Personal</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_ids" class="mini-links">ID's</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_job" class="mini-links">Job</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_allowance" class="mini-links">Allowance</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_documents" class="mini-links active">Documents</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_emergency" class="mini-links">Emergency</a>
                            <a href="<?= base_url() ?>selfservices/my_profile_dependents" class="mini-links">Dependents</a>
                        </div>
                    </div>
                    <br>
                    <div class="card_container border-0">
                        <div>
                            <p style="font-size:20px">Documents</p>
                            <div class="modal-btn">

                                <button type="button" class="btn btn-primary" style="display: none;" data-toggle="modal" data-target="#modal_add_document"><i class="fas fa-plus mr-2"></i>Add
                                    Document</button>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col col-md-12 ">
                                <div>
                                    <table class="table table-xs table-hover table-nowrap mb-0" style="border:none;">
                                        <thead>
                                            <th>ID</th>
                                            <th>Document name</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($DISP_EMPL_DOCS) {
                                                foreach ($DISP_EMPL_DOCS as $DISP_EMPL_DOCS_ROW) {
                                                    $application_id = $id_code . str_pad($DISP_EMPL_DOCS_ROW->id, 5, '0', STR_PAD_LEFT);
                                            ?>
                                                    <tr>
                                                        <td><?= $application_id ?></td>
                                                        <td>

                                                        <td>
                                                            <?= $DISP_EMP_ASSETS_ROW->col_asset_issued_on ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url() ?>employee_files/<?= $DISP_EMPL_DOCS_ROW->col_doc_file ?>" download>
                                                                <i class="fas fa-file-pdf mr-2"></i>
                                                            </a>
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
                <div>
                </div>
            </div>

            <div class="modal fade" id="modal_add_document" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header pb-0" style="border-bottom: none;">
                            <h4 class="modal-title ml-1" id="exampleModalLabel">Add Document</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="<?php echo base_url('employees/add_employee_document'); ?>" id="ADD_DOCUMENT_FORM" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mt-3">
                                            <label class="required" for="exampleInputFile">Attach File</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input fileficker" id="exampleInputFile" name="employee_file" multiple="" accept=".docx, .pdf, .xlsx, .pptx" required>
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="INSRT_DOC_EMPL_ID" id="INSRT_DOC_EMPL_ID" value="<?= $user_id ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class='btn btn-primary text-light' type="submit" id="DOC_BTN_INSRT">&nbsp;
                                    Add</button>
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
    if ($this->session->userdata('SESS_SUCC_ADD_EMPL_DOC')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_ADD_EMPL_DOC'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_ADD_EMPL_DOC');
    }
    ?>
    <?php
    if ($this->session->userdata('SESS_ERR_ADD_EMPL_DOC')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_ERR_ADD_EMPL_DOC'); ?>',
                '',
                'error'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_ERR_ADD_EMPL_DOC');
    }
    ?>
    <?php
    if ($this->session->userdata('SESS_SUCC_DLT_EMPL_DOC')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_DLT_EMPL_DOC'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_DLT_EMPL_DOC');
    }
    ?>
    <?php
    if ($this->session->userdata('SESS_ERR_DLT_EMPL_DOC')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_ERR_DLT_EMPL_DOC'); ?>',
                '',
                'error'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_ERR_DLT_EMPL_DOC');
    }
    ?>
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
            $('.BTN_DLT_DOC').click(function(e) {
                e.preventDefault();
                var user_deleteKey = $(this).attr('delete_key');
                var employee_id = $(this).attr('employee_id');
                var filename = $(this).attr('filename');
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
                        window.location.href = "<?= base_url(); ?>employees/delete_employee_document?id=" + user_deleteKey + "&file=" + filename + "&employee_id=" + employee_id;
                    }
                })
            })
        })
    </script>
</body>

</html>