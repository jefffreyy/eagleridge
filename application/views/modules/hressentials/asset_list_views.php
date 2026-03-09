<html>

<?php $this->load->view('templates/css_link'); ?>
<?php
$id_code = "AST";
?>
<?php

$search_data = $this->input->get('all');



$search_data    = str_replace("_", " ", $search_data ?? '');

$date_data      = $this->input->get('date');

$current_page = $PAGE;

$next_page = $PAGE + 1;

$prev_page = $PAGE - 1;

$last_page = $PAGES_COUNT;

$row = $ROW;

if ($C_DATA_COUNT == 0) {

    $low_limit = 0;
} else {

    $low_limit = $row * ($current_page - 1) + 1;
}

if ($current_page * $row > $C_DATA_COUNT) {

    $high_limit = $C_DATA_COUNT;
} else {

    $high_limit = $row * ($current_page);
}

?>

<body>

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
                <div class="col-md-6">
                    <h1 class="page-title d-flex align-items-center"><a href="<?= base_url('assets') ?>"> <img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                        </a>&nbsp;Assets List
                        <h1>
                </div>


                <div class="col-md-6 button-title">
                    <a class="btn btn-primary shadow-none" href="#" data-toggle="modal" data-target="#modal_add_asset">
                        <i class="fas fa-plus mr-1"></i> New Asset
                    </a>
                </div>
            </div>
            <hr>

            <div class="card border-0 p-0 m-0">

                <div class="card border-0 pt-1 m-0">

                    <div class="card-header p-0">

                        <div class="row">

                            <div class="col-xl-8">

                                <ul class="nav nav-tabs">

                                    <li class="nav-item">

                                        <a class="nav-link head-tab  <?= $TAB == 'Active' ? 'active' : '' ?>" id="tab-Active" href="?page=1&row=<?= $row ?>&tab=Active">Active<span class="ml-2 badge badge-pill badge-secondary"><?= $ACTIVES ?></span></a>

                                    </li>

                                    <li class="nav-item">

                                        <a class="nav-link head-tab <?= $TAB == 'Inactive' ? 'active' : '' ?>" id="tab-Inactive" href="?page=1&row=<?= $ROW ?>&tab=Inactive">Inactive<span class="ml-2 badge badge-pill badge-secondary"><?= $INACTIVES ?></span></a>

                                    </li>



                                </ul>

                            </div>

                            <div class="col-xl-4">

                                <div class="input-group pb-1 ">

                                    <button id="search_btn" class="input-group-prepend btn btn-primary shadow-none d-flex align-items-center"><img src="<?= base_url('assets_system/icons/magnifying-glass-solid.svg') ?>" alt="">
                                        &nbsp;Search</button>



                                    <input type="text" class="form-control" placeholder="Search" id="search_data" value="" aria-label="Username" aria-describedby="basic-addon1">

                                </div>

                            </div>

                        </div>

                    </div>



                    <div class="pt-2 px-2">

                        <div>

                            <button id=btn_mark_active class="btn  shadow-none rounded bulk-button technos-button-green rounded " data-toggle="modal" data-id=Active data-target="#modal_set_ssa" data-action='activate' status=Mark as Active><img style="height: 1rem; width: 1rem; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-check-solid_mark.svg') ?>" alt="">
                                &nbsp;Mark as Active</button>

                            <button id=btn_mark_inactive class="btn  shadow-none rounded bulk-button btn-danger  " style="padding: 5px 12px 5px 12px" data-toggle="modal" data-id=Inactive data-target="#modal_set_ssa" data-action='deactivate' status=Mark as Inactive><img style="height: 1rem; width: 1rem; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-x-solid_mark_as.svg') ?>" alt="">
                                &nbsp;Mark as Inactive</button>



                            <!-- <button id="btn_application"    class=" btn technos-button-gray shadow-none rounded" data-toggle="modal" data-target="#modal_insert"  ><i class="far fa-trash-alt"></i>&nbsp;Delete</button> -->

                            <div class="float-right ">

                                <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>

                                <ul class="d-inline pagination m-0 p-0 ">

                                    <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>

                                            < </a>

                                    </li>

                                    <li><a href="?page=1&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>

                                    <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>

                                    <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>

                                    <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>

                                    <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>

                                    <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>

                                    <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>

                                    <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row&tab=$TAB'"; ?>>> </a></li>

                                </ul>

                                <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>

                                <select id="row_dropdown" class="custom-select" style="width: auto;">

                                    <?php

                                    foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>

                                        <option value=<?= $C_ROW_DISPLAY_ROW ?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>

                                    <?php

                                    } ?>

                                </select>

                            </div>

                        </div>

                    </div>

                    <div class="table-responsive">



                        <table class="table table-bordered m-0" id="table_main" style="width:100%">

                            <thead>
                                <th>Asset ID</th>
                                <th>Name</th>
                                <th>Serial&nbsp;number</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Warranty&nbsp;Expires&nbsp;On</th>
                                <th>Assigned&nbsp;To</th>
                                <th>Action</th>
                            </thead>
                            <tbody id=" tbl_application_container">
                                <?php

                                if ($DISP_ASSETS_INFO) {

                                    foreach ($DISP_ASSETS_INFO as $DISP_ASSETS_INFO_ROW) {
                                        $application_id = $id_code . str_pad($DISP_ASSETS_INFO_ROW->id, 5, '0', STR_PAD_LEFT);
                                        // $asset_info = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_ASSETS_INFO_ROW->col_asset_assigned_to);

                                        // $fullname = '';

                                        // if ($asset_info) {

                                        //     if (!empty($asset_info[0]->col_midl_name)) {

                                        //         $midl_ini = $asset_info[0]->col_midl_name[0] . '.';
                                        //     } else {

                                        //         $midl_ini = '';
                                        //     }
                                        //     $fullname = $asset_info[0]->col_last_name . ', ' . $asset_info[0]->col_frst_name . ' ' . $midl_ini;
                                        // }
                                ?>
                                        <tr style="cursor: pointer;">

                                            <td>
                                                <?= $application_id ?>
                                            </td>
                                            <td onclick="window.location.href = '<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>'"><?= $DISP_ASSETS_INFO_ROW->col_asset_name ?></td>
                                            <td onclick="window.location.href = '<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>'"><?= $DISP_ASSETS_INFO_ROW->col_asset_serial ?></td>
                                            <td onclick="window.location.href = '<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>'"><?= $DISP_ASSETS_INFO_ROW->asset_category_name ?></td>
                                            <td onclick="window.location.href = '<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>'"><?= $DISP_ASSETS_INFO_ROW->location_name ?></td>
                                            <td onclick="window.location.href = '<?= base_url() ?>asset/asset_info?id=<?= $DISP_ASSETS_INFO_ROW->id ?>'"><?= $DISP_ASSETS_INFO_ROW->col_asset_warranty_exp ?></td>
                                            <td>

                                            </td>
                                            <td>
                                                <a href="#" class="text-black-50" data-toggle="dropdown" aria-expanded="false">
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
                                    <tr class="table-active">
                                        <td class="p-4" colspan="8">
                                            <center> No Assets Yet</center>
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

    <aside class=" control-sidebar control-sidebar-dark">
    </aside>

    <!-- Set SSA -->

    <div class="modal fade class_modal_set_ssa" id="modal_set_ssa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">

                <div class="modal-header" style="border-bottom: none;">

                    <h4 class="modal-title ml-1" id="exampleModalLabel">Set Status</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <form id='form_activation' action="" method="post">

                    <input type='hidden' name='table' value="tbl_hr_announcements">

                    <input type='hidden' name='sub_url' value="announcements">

                    <div class="modal-body px-5 pb-4">

                        <div class="row">

                            <div class="col-md-12">

                                <div class="row mb-1">

                                    <div class="col-md-12">

                                        <p class="">Set Status for the following orders:</p>

                                    </div>

                                    <div class="col-md-12">

                                        <ul id="list_mark" class="row"></ul>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <input type="hidden" id="modal_title" name="modal_title">

                        <input type="hidden" id="list_mark_ids" name="list_mark_ids">

                        <button type="submit" class="btn btn-info">Submit</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <div class="modal fade" id="modal_add_asset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Asset</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="<?php echo base_url('assets/add_asset'); ?>" id="update_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="col_asset_assigned_by" value="<?= $this->session->userdata('SESS_USER_ID')  ?>">
                                <div class="form-group">
                                    <label class="required" for="INSRT_ASSIGN_TO">Assign To:</label>
                                   <select name="col_asset_assigned_to" id="" class="form-control">
                                    <?php foreach($DISP_EMPLOYEES as $employees) { ?>
                                        <option value="<?= $employees->id ?>">
                                        <?= $employees->col_empl_cmid . ' - ' . $employees->col_frst_name . ' ' . $employees->col_last_name ?>
                                    </option>
                                        <?php } ?>
                                    
                                   </select>
                                </div>

                                <div class="form-group">
                                    <label class="required" for="INSRT_ASSET_NAME">Name</label>
                                    <input class="form-control form-control " type="text" name="col_asset_name" id="INSRT_ASSET_NAME" required>
                                </div>

                                <div class="form-group">
                                    <label class="required" for="INSRT_ASSET_SERIAL">Serial Number</label>
                                    <input class="form-control form-control " type="text" name="col_asset_serial" id="INSRT_ASSET_SERIAL" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="required" for="INSRT_ASSET_CATEGORY">Category</label>
                                    <select name="col_asset_category" id="INSRT_ASSET_CATEGORY" class="form-control" required>
                                        <option value="">-- Select -- </option>
                                        <?php
                                        foreach ($DISP_ASSET_CATEGORY as $DISP_ASSET_CATEGORY_ROW) {
                                        ?>
                                            <option value="<?= $DISP_ASSET_CATEGORY_ROW->id ?>"><?= $DISP_ASSET_CATEGORY_ROW->name ?></option>
                                        <?php

                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label class="required" for="INSRT_ASSET_LOCATION">Location</label>
                                    <select name="col_asset_location" id="INSRT_ASSET_LOCATION" class="form-control" required>
                                        <option value="">-- Select -- </option>
                                        <?php
                                        foreach ($DISP_LOCATION_INFO as $DISP_LOCATION_INFO_ROW) {
                                        ?>
                                            <option value="<?= $DISP_LOCATION_INFO_ROW->id ?>"><?= $DISP_LOCATION_INFO_ROW->name ?></option>
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
                                    <input class="form-control " type="text" name="col_asset_price" id="INSRT_ASSET_PRICE">
                                </div>

                                <div class="form-group">
                                    <label for="INSRT_ASSET_WARRANTY_EXP">Warranty Expires On</label>
                                    <input class="form-control" type="date" name="col_asset_warranty_exp" id="INSRT_ASSET_WARRANTY_EXP">
                                </div>

                                <div class="form-group">
                                    <label for="asset_code">Description</label>
                                    <textarea class="form-control" name="col_asset_description" id="INSRT_ASSET_DESCRIPTION" cols="30" rows="5"></textarea>
                                </div>
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

    <script>
        $(function() {
            var row_count = $('#row_count').val();
            var page_count = $('#page_count').val();

            $('#btn_pagination').pagination();
            $('#btn_pagination').pagination({

                total: row_count,
                current: 1,
                length: 10,
                size: 2,
                prev: "&lt;",
                next: "&gt;",
                click: function(e) {

                    $('#tbl_application_container').html('');
                    var row_count = $('#row_count').val();
                    var page_count = $('#page_count').val();
                    var page_num = e.current;
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