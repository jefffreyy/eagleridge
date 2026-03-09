<style>
    .card {
        padding: 0px 14px 10px;
    }

    /* edited froala editor */
    .fr-toolbar {
        border-top: 1px solid #ccc !important;
        z-index: 0 !important;
        border-radius: 10px 10px 0px 0px !important;
    }

    .fr-wrapper {
        border-radius: 0px 0px 10px 10px !important;
        font-size: 14px !important;
        margin-bottom: 20px !important;
    }

    .fr-command {
        margin-top: 5px !important;
        margin-bottom: 5px !important;
    }

    .fr-counter {
        margin-right: 5px !important;
        border: none !important;
    }

    .fr-counter::before {
        content: 'Characters: ';
        font-family: inter, sans-serif;
    }

    #froala-editor {
        border-radius: 10px !important;
    }

    /* CSS for this page only */
    .active {
        font-weight: 600;
    }

    .page-title {
        font-weight: 600;
        color: #424F5C;
        font-size: 33px;
    }

    th,
    td {
        font-size: 13px !important;
    }

    label.required::after {
        content: " *";
        color: red;
    }
</style>

<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Pagination -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/bs-pagination.min.css">
<!-- Datatable -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<!-- Include Editor style. -->
<!-- <link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_style.min.css" rel="stylesheet" type="text/css" /> -->

<div class="content-wrapper">
    <div class="p-3">
        <div class="flex-fill">
            <div class="row pr-3">
                <div class="col">
                    <h1 class="page-title">Assets</h1>
                    <p class="plain-text mb-0">Manage company assets and assignments for your employees.</p>
                </div>
                <div class="ml-auto">
                    <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal_add_asset">
                        <i class="fas fa-plus mr-1"></i> New Asset
                    </a>
                </div>
            </div>
            <hr>
            <!-- <div class="row w-100 px-3 mb-2">
                    <div class="form-inline">
                        <div class="input-group mr-3">
                            <span class="input-group-prepend">
                                <div class="input-group-text bg-white border-right-0"><i class="fa fa-search text-muted"></i></div>
                            </span>
                            <input placeholder="Search..." class="form-control border-left-0" autofocus="autofocus" data-action="debounced:input->form#submit" type="search" name="criteria[query]" id="criteria_query">
                        </div>
                        <button class="btn btn-secondary dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-filter p-1"></i>&nbsp;&nbsp;Filter</button>
                        <div class="dropdown-menu js-dropdown-propagate-click" style="width: 400px;">
                            <div class="p-2">
                                <div class="mb-2">
                                    <input type="text" name="teams" id="teams" class="form-control w-100" placeholder="Category">
                                </div>
                                <div class="mb-2">
                                    <input type="text" name="department" id="department" class="form-control w-100" placeholder="Locations">
                                </div>
                                <div class="mb-2">
                                    <input type="text" name="divisions" id="divisions" class="form-control w-100" placeholder="Assigned To">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-hover"">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Serial number</th>
                                            <th>Category</th>
                                            <th>Location</th>
                                            <th>Warranty Expires On</th>
                                            <th>Assigned To</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody id=" tbl_application_container">
                                <?php
                                if ($DISP_ASSETS_INFO) {
                                    foreach ($DISP_ASSETS_INFO as $DISP_ASSETS_INFO_ROW) {
                                        $asset_info = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_ASSETS_INFO_ROW->col_asset_assigned_to);
                                        $fullname = '';
                                        if ($asset_info) {
                                            if (!empty($asset_info[0]->col_midl_name)) {
                                                $midl_ini = $asset_info[0]->col_midl_name[0] . '.';
                                            } else {
                                                $midl_ini = '';
                                            }
                                            $fullname = $asset_info[0]->col_last_name . ', ' . $asset_info[0]->col_frst_name . ' ' . $midl_ini;
                                        }
                                ?>
                                        <tr style="cursor: pointer;">
                                            <td onclick="window.location.href = '<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>'">
                                                <a href="<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>"><?= $DISP_ASSETS_INFO_ROW->col_asset_id ?></a>
                                            </td>
                                            <td onclick="window.location.href = '<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>'"><?= $DISP_ASSETS_INFO_ROW->col_asset_name ?></td>
                                            <td onclick="window.location.href = '<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>'"><?= $DISP_ASSETS_INFO_ROW->col_asset_serial ?></td>
                                            <td onclick="window.location.href = '<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>'"><?= $DISP_ASSETS_INFO_ROW->col_asset_category ?></td>
                                            <td onclick="window.location.href = '<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>'"><?= $DISP_ASSETS_INFO_ROW->col_asset_location ?></td>
                                            <td onclick="window.location.href = '<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>'"><?= $DISP_ASSETS_INFO_ROW->col_asset_warranty_exp ?></td>
                                            <td><a href="#"><?= $fullname ?></a></td>
                                            <td>
                                                <a href="#" class="text-black-50" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas  fa-ellipsis-v"></i>
                                                    <span class="d-xl-none ml-2">Settings</span>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" title="Edit" href="#" asset_id="<?= $DISP_ASSETS_INFO_ROW->id ?>" data-toggle="modal" data-target="#modal_edit_asset"><i class="fas fa-fw fa-edit"></i>Edit</a>
                                                    <a class="dropdown-item text-danger BTN_DLT_ASSET" title="Delete" href="#" rel="nofollow" delete_key="<?= $DISP_ASSETS_INFO_ROW->id ?>"><i class="fas fa-fw fa-trash"></i>Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php   }
                                } else { ?>
                                    <tr>
                                        <td class="p-4" colspan="8"> No Assets Yet</td>
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
        <!-- flex-fill -->
        <right>
                        <ul id="btn_pagination" class="pagination ml-auto mr-auto"></ul>
                    </right>
    </div>
    <!-- p-3 -->
</div>
<!-- content-wrapper -->

<?php
$page_count = $DISP_ROW_COUNT[0]->ast_count / 20;

if (($DISP_ROW_COUNT[0]->ast_count % 20) != 0) {
    $page_count = $page_count++;
}

$page_count = ceil($page_count);
?>

<input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT[0]->ast_count ?>">
<input type="hidden" id="page_count" value="<?= $page_count ?>">


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Add Asset -->
<div class="modal fade" id="modal_add_asset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pb-0" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Add Asset</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url('asset/add_asset'); ?>" id="update_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="required" for="INSRT_ASSET_ID">ID</label>
                                <input class="form-control form-control " type="text" name="INSRT_ASSET_ID" id="INSRT_ASSET_ID" required>
                            </div>
                            <div class="form-group">
                                <label class="required" for="INSRT_ASSET_NAME">Name</label>
                                <input class="form-control form-control " type="text" name="INSRT_ASSET_NAME" id="INSRT_ASSET_NAME" required>
                            </div>
                            <div class="form-group">
                                <label class="required" for="INSRT_ASSET_SERIAL">Serial Number</label>
                                <input class="form-control form-control " type="text" name="INSRT_ASSET_SERIAL" id="INSRT_ASSET_SERIAL" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="required" for="INSRT_ASSET_CATEGORY">Category</label>
                                <select name="INSRT_ASSET_CATEGORY" id="INSRT_ASSET_CATEGORY" class="form-control" required>
                                    <option value="7301">-- Select -- </option>
                                    <?php
                                    foreach ($DISP_ASSET_CATEGORY as $DISP_ASSET_CATEGORY_ROW) {
                                    ?>
                                        <option value="<?= $DISP_ASSET_CATEGORY_ROW->name ?>"><?= $DISP_ASSET_CATEGORY_ROW->name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="required" for="INSRT_ASSET_LOCATION">Location</label>
                                <select name="INSRT_ASSET_LOCATION" id="INSRT_ASSET_LOCATION" class="form-control" required>
                                    <option value="7301">-- Select -- </option>
                                    <?php
                                    foreach ($DISP_LOCATION_INFO as $DISP_LOCATION_INFO_ROW) {
                                    ?>
                                        <option value="<?= $DISP_LOCATION_INFO_ROW->name ?>"><?= $DISP_LOCATION_INFO_ROW->name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="INSRT_ASSET_PRICE">Price (&#8369;)</label>
                                <input class="form-control " type="text" name="INSRT_ASSET_PRICE" id="INSRT_ASSET_PRICE">
                            </div>
                            <div class="form-group">
                                <label for="INSRT_ASSET_WARRANTY_EXP">Warranty Expires On</label>
                                <input class="form-control" type="date" name="INSRT_ASSET_WARRANTY_EXP" id="INSRT_ASSET_WARRANTY_EXP">
                            </div>
                            <div class="form-group">
                                <label for="asset_code">Description</label>
                                <!-- <div id="froala-editor">
                                        <p></p>
                                    </div> -->
                                <textarea class="form-control" name="INSRT_ASSET_DESCRIPTION" id="INSRT_ASSET_DESCRIPTION" cols="30" rows="5"></textarea>
                            </div>
                            <!-- <input type="hidden" name="INSRT_ASSET_DESCRIPTION" id="INSRT_ASSET_DESCRIPTION"> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class='btn btn-primary text-light' id="BTN_ASSET_INSRT">&nbsp; Save</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Asset -->
<div class="modal fade" id="modal_edit_asset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pb-0" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Asset</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url('asset/edit_asset'); ?>" id="edit_asset_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="required" for="UPDT_ASSET_ID">ID</label>
                                <input class="form-control form-control " type="text" name="UPDT_ASSET_ID" id="UPDT_ASSET_ID" required>
                            </div>
                            <div class="form-group">
                                <label class="required" for="UPDT_ASSET_NAME">Name</label>
                                <input class="form-control form-control " type="text" name="UPDT_ASSET_NAME" id="UPDT_ASSET_NAME" required>
                            </div>
                            <div class="form-group">
                                <label class="required" for="UPDT_ASSET_SERIAL">Serial Number</label>
                                <input class="form-control form-control " type="text" name="UPDT_ASSET_SERIAL" id="UPDT_ASSET_SERIAL" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="required" for="UPDT_ASSET_CATEGORY">Category</label>
                                <select name="UPDT_ASSET_CATEGORY" id="UPDT_ASSET_CATEGORY" class="form-control" required>
                                    <option value="7301">-- Select -- </option>
                                    <?php
                                    foreach ($DISP_ASSET_CATEGORY as $DISP_ASSET_CATEGORY_ROW) {
                                    ?>
                                        <option value="<?= $DISP_ASSET_CATEGORY_ROW->name ?>"><?= $DISP_ASSET_CATEGORY_ROW->name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="required" for="UPDT_ASSET_LOCATION">Location</label>
                                <select name="UPDT_ASSET_LOCATION" id="UPDT_ASSET_LOCATION" class="form-control" required>
                                    <option value="7301">-- Select -- </option>
                                    <?php
                                    foreach ($DISP_LOCATION_INFO as $DISP_LOCATION_INFO_ROW) {
                                    ?>
                                        <option value="<?= $DISP_LOCATION_INFO_ROW->name ?>"><?= $DISP_LOCATION_INFO_ROW->name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="UPDT_ASSET_PRICE">Price (&#8369;)</label>
                                <input class="form-control " type="text" name="UPDT_ASSET_PRICE" id="UPDT_ASSET_PRICE">
                            </div>
                            <div class="form-group">
                                <label for="UPDT_ASSET_WARRANTY_EXP">Warranty Expires On</label>
                                <input class="form-control" type="date" name="UPDT_ASSET_WARRANTY_EXP" id="UPDT_ASSET_WARRANTY_EXP">
                            </div>
                            <div class="form-group">
                                <label for="asset_code">Description</label>
                                <textarea name="UPDT_ASSET_DESCRIPTION" id="UPDT_ASSET_DESCRIPTION" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="UPDT_ASSET_KEY" id="UPDT_ASSET_KEY">
                <div class="modal-footer">
                    <a class='btn btn-primary text-light' id="BTN_ASSET_UPDT">&nbsp; Save</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- LOGOUT MODAL -->
<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Hi are you sure you want to logout?</p>
            </div>
            <div class="modal-footer pb-1 pt-1">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout</a>
            </div>
        </div>
    </div>
</div>

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
<!-- Pagination -->
<script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>
<!-- Data table -->
<script src="<?= base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Include Editor JS files. -->
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/js/froala_editor.pkgd.min.js"></script> -->
<?php
if ($this->session->userdata('SESS_SUCC_INSRT_ASSET')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_INSRT_ASSET'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_INSRT_ASSET');
}
?>
<?php
if ($this->session->userdata('SESS_ERR_INSRT_ASSET')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_ERR_INSRT_ASSET'); ?>',
            'Please fill up all the fields',
            'error'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_ERR_INSRT_ASSET');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_UPDT_ASSET')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_UPDT_ASSET'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_UPDT_ASSET');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_DLT_ASSET')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_ASSET'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_DLT_ASSET');
}
?>
<!-- Initialize the editor. -->
<script>
    $(function() {
        /* $('div#froala-editor').froalaEditor({
            // Set custom buttons with separator between them.
            toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting','html'],
            toolbarButtonsXS: ['undo', 'redo' , '-', 'bold', 'italic','html']
        })

        $('i.fa.fa-rotate-left').attr('class');

        $('.fr-view').keyup(function(){
            var fr_text = $('.fr-view').html();
            $('#INSRT_ASSET_DESCRIPTION').val(fr_text);
        }) */






        $('#btn_pagination').pagination();

        var row_count = $('#row_count').val();
        var page_count = $('#page_count').val();

        console.log(row_count);
        console.log(page_count);

        $('#btn_pagination').pagination({

            // the number of entries
            total: row_count,

            // current page
            current: 1,

            // the number of entires per page
            length: 20,

            // pagination size
            size: 2,

            // Prev/Next text
            prev: "&lt;",
            next: "&gt;",

            // fired on each click
            click: function(e) {
                $('#tbl_application_container').html('');

                var row_count = $('#row_count').val();
                var page_count = $('#page_count').val();
                // console.log(e.current);
                var page_num = e.current;

                // console.log(page_num);

                get_assets(url_get_assets, page_num).then(function(data) {
                    console.log(data);
                    Array.from(data).forEach(function(e) {

                        var asset_info = e.id;
                        var asset_name = e.col_asset_name;
                        var asset_serial = e.col_asset_serial;
                        var asset_category = e.col_asset_category;
                        var asset_location = e.col_asset_location;
                        var asset_warranty = e.col_asset_warranty_exp;
                        var fullname = '';

                        $('#tbl_application_container').append(`
                               <tr>
                               <td>` + asset_info + `</td>
                                <td>` + asset_name + `</td>
                                <td>` + asset_serial + `</td>
                                <td>` + asset_category + `</td>
                                <td>` + asset_location + `</td>
                                <td>` + asset_warranty + `</td>
                                <td>` + fullname + `</td>
                                <td>
                                <a href="#" class="text-black-50" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas  fa-ellipsis-v"></i>
                                <span class="d-xl-none ml-2">Settings</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" title="Edit" href="#" asset_id="<?= $DISP_ASSETS_INFO_ROW->id ?>" data-toggle="modal" data-target="#modal_edit_asset"><i class="fas fa-fw fa-edit"></i>Edit</a>
                                <a class="dropdown-item text-danger BTN_DLT_ASSET" title="Delete" href="#" rel="nofollow" delete_key="<?= $DISP_ASSETS_INFO_ROW->id ?>"><i class="fas fa-fw fa-trash"></i>Delete</a>
                                </div>
                                </td>
                            </tr>
                        `)
                    })
                })
            }
        });






        // Get & Display Data to Edit Modal Using Async JS function
        var url_get_assets = '<?= base_url() ?>asset/get_assets';
        var url_get_ast_application_data = '<?= base_url() ?>asset/get_ast_application_data';
        var url = '<?php echo base_url(); ?>asset/getAssetData';
        const openModalButton = document.querySelectorAll('[data-target]');
        openModalButton.forEach(button => {
            button.addEventListener('click', () => {
                const modal = document.querySelector(button.dataset.target);
                getAssetData(url, button.getAttribute('asset_id')).then(data => {
                    if (data.length > 0) {
                        data.forEach((x) => {
                            document.getElementById('UPDT_ASSET_KEY').value = x.id;
                            document.getElementById('UPDT_ASSET_ID').value = x.col_asset_id;
                            document.getElementById('UPDT_ASSET_NAME').value = x.col_asset_name;
                            document.getElementById('UPDT_ASSET_SERIAL').value = x.col_asset_serial;
                            document.getElementById('UPDT_ASSET_CATEGORY').value = x.col_asset_category;
                            document.getElementById('UPDT_ASSET_LOCATION').value = x.col_asset_location;
                            document.getElementById('UPDT_ASSET_PRICE').value = x.col_asset_price;
                            document.getElementById('UPDT_ASSET_WARRANTY_EXP').value = x.col_asset_warranty_exp;

                            var html = x.col_asset_description.replace(/<style([\s\S]*?)<\/style>/gi, '');
                            html = html.replace(/<script([\s\S]*?)<\/script>/gi, '');
                            html = html.replace(/<\/div>/ig, '\n');
                            html = html.replace(/<\/li>/ig, '\n');
                            html = html.replace(/<li>/ig, '  *  ');
                            html = html.replace(/<\/ul>/ig, '\n');
                            html = html.replace(/<\/p>/ig, '\n');
                            html = html.replace(/<br\s*[\/]?>/gi, "\n");
                            html = html.replace(/<[^>]+>/ig, '');

                            document.getElementById('UPDT_ASSET_DESCRIPTION').value = html;
                        });
                    }
                });
            });
        });

        async function get_assets(url, page_num) {
            var formData = new FormData();
            formData.append('page_num', page_num);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_ast_application_data(url, page_num) {
            var formData = new FormData();
            formData.append('page_num', page_num);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }


        async function getAssetData(url, asset_id) {
            var formData = new FormData();
            formData.append('asset_id', asset_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        // Update Position
        $('#BTN_ASSET_UPDT').click(function() {
            var asset_id = $('#UPDT_ASSET_ID').val();
            var asset_name = $('#UPDT_ASSET_NAME').val();
            var asset_category = $('#UPDT_ASSET_CATEGORY').val();
            var asset_price = $('#UPDT_ASSET_PRICE').val();
            var hasErr = 0;
            if (!asset_id) {
                $('#UPDT_ASSET_ID').addClass('is-invalid');
                hasErr++;
            }
            if (!asset_name) {
                $('#UPDT_ASSET_NAME').addClass('is-invalid');
                hasErr++;
            }
            if (!asset_category) {
                $('#UPDT_ASSET_CATEGORY').addClass('is-invalid');
                hasErr++;
            }
            if (!asset_price) {
                $('#UPDT_ASSET_PRICE').addClass('is-invalid');
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
                        $('#edit_asset_form').submit();
                    }
                })
            }
        })

        $('#UPDT_ASSET_ID').keyup(function() {
            $('#UPDT_ASSET_ID').removeClass('is-invalid');
        })
        $('#UPDT_ASSET_NAME').keyup(function() {
            $('#UPDT_ASSET_NAME').removeClass('is-invalid');
        })
        $('#UPDT_ASSET_CATEGORY').keyup(function() {
            $('#UPDT_ASSET_CATEGORY').removeClass('is-invalid');
        })
        $('#UPDT_ASSET_PRICE').keyup(function() {
            $('#UPDT_ASSET_PRICE').removeClass('is-invalid');
        })

        // Delete Position
        $('.BTN_DLT_ASSET').click(function(e) {
            e.preventDefault();
            var user_deleteKey = $(this).attr('delete_key');
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
                    window.location.href = "<?= base_url(); ?>asset/dlt_asset?delete_id=" + user_deleteKey;
                }
            })
        })
    });
</script>


</body>

</html>