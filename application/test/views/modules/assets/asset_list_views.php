<!------------------------------------------------------ A. PAGE INFORMATION  -----------------------------------------------------

  

TECHNOS SYSTEM ENGINEERING INC.

EyeBox HRMS



@author     Technos Developers

@datetime   16 November 2022

@purpose    Assets



CONTROLLER FILES:





MODEL FILES:

  











----------------------------------------------------------- A. STYLESHEETS  ----------------------------------------------------->

<html>

<?php $this->load->view('templates/css_link'); ?>



<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<?php
    $id_code = "AST";
?>


<body>

    <!-- Content Starts -->

    <div class="content-wrapper">

        <div class="container-fluid p-4">

        <nav aria-label="breadcrumb">

            <ol class="breadcrumb">

            <li class="breadcrumb-item">

                <a href="<?= base_url() ?>nav_assets">Asset</a>

            </li>

            <li class="breadcrumb-item active" aria-current="page">Assets
            </li>

            </ol>

        </nav>

            <div class="row">



                <!-- Title Text -->

                <div class="col-md-6">

                    <h1 class="page-title">Assets</h1>

                    <p class="plain-text mb-2">Manage company assets and assignments for your employees.</p>

                </div>



                <!-- Title Button -->

                <div class="col-md-6 button-title">

                    <a class="btn btn-primary shadow-none" href="#" data-toggle="modal" data-target="#modal_add_asset">

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

                                            <!-- Table Headers -->

                                            <th>Asset ID</th>

                                            <th>Name</th>

                                            <th>Serial&nbsp;number</th>

                                            <th>Category</th>

                                            <th>Location</th>

                                            <th>Warranty&nbsp;Expires&nbsp;On</th>

                                            <th>Assigned&nbsp;To</th>

                                    </thead>



                                    <tbody id=" tbl_application_container">

                                <?php

                                if ($DISP_ASSETS_INFO) {

                                    foreach ($DISP_ASSETS_INFO as $DISP_ASSETS_INFO_ROW) {
                                        $application_id = $id_code . str_pad($DISP_ASSETS_INFO_ROW->id, 5, '0', STR_PAD_LEFT);
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

                                            <td>
                                                <?= $application_id ?>
                                            </td>

                                            <td onclick="window.location.href = '<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>'"><?= $DISP_ASSETS_INFO_ROW->col_asset_name ?></td>

                                            <td onclick="window.location.href = '<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>'"><?= $DISP_ASSETS_INFO_ROW->col_asset_serial ?></td>

                                            <td onclick="window.location.href = '<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>'"><?= $DISP_ASSETS_INFO_ROW->col_asset_category ?></td>

                                            <td onclick="window.location.href = '<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>'"><?= $DISP_ASSETS_INFO_ROW->col_asset_location ?></td>

                                            <td onclick="window.location.href = '<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>'"><?= $DISP_ASSETS_INFO_ROW->col_asset_warranty_exp ?></td>

                                    

                                            <td>

                                                <a href="#" class="text-black-50" data-toggle="dropdown" aria-expanded="false">

                                                    <!--<i class="fas  fa-ellipsis-v"></i>-->

                                                    <span class="ml-2">Settings</span>

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



        <right>

            <ul id="btn_pagination" class="pagination ml-auto mr-auto"></ul>

        </right>



    </div>

</div>

<!-- content-wrapper -->



<?php

$page_count = $DISP_ROW_COUNT[0]->ast_count / 10;



if (($DISP_ROW_COUNT[0]->ast_count % 10) != 0) {

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







  <!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->

  <?php $this->load->view('templates/jquery_link'); ?>









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









        // ------------------------------ Pagination -------------------------------------

        // TECHNOS STANDARD: DO NOT CHANGE

        var row_count = $('#row_count').val();

        var page_count = $('#page_count').val();



        $('#btn_pagination').pagination();

        $('#btn_pagination').pagination({

            total: row_count, // the number of entries

            current: 1, // current page

            length: 10, // the number of entires per page

            size: 2, // pagination size

            prev: "&lt;", // Prev/Next text

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