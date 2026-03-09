<html>

<?php $this->load->view('templates/css_link'); ?>

<style>
    @media (min-width: 1280px) {
        .col-2-xl {
            flex-basis: 16.66667%;
            max-width: 16.66667%;
        }

        #search_data {
            min-width: 200px;
        }
    }
</style>

<?php
$id_code = "AST";
?>
<?php

$search_data = $this->input->get('all');

$search_data = str_replace("_", " ", $search_data ?? '');

$date_data = $this->input->get('date');

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


                <div class="col-md-6 button-title d-flex justify-content-end">
                    <a class="btn btn-primary shadow-none" href="<?= base_url('assets/insert_asset') ?>">
                        <img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt=""> New Asset
                    </a>
                </div>
            </div>
            <hr>

            <div class="card border-0 p-0 m-0">

                <div class="card border-0 p-1 m-0">

                    <div class="card-header p-0 row">

                        <div class="col-12 col-lg-4">

                            <ul class="nav nav-tabs">

                                <li class="nav-item">

                                    <a class="nav-link head-tab  <?= $TAB == 'Active' ? 'active' : '' ?>" id="tab-Active" href="?page=1&row=<?= $row ?>&tab=Active">Active<span class="ml-2 badge badge-pill badge-secondary"><?= $ACTIVES ?></span></a>

                                </li>

                                <li class="nav-item">

                                    <a class="nav-link head-tab <?= $TAB == 'Inactive' ? 'active' : '' ?>" id="tab-Inactive" href="?page=1&row=<?= $ROW ?>&tab=Inactive">Inactive<span class="ml-2 badge badge-pill badge-secondary"><?= $INACTIVES ?></span></a>

                                </li>



                            </ul>

                        </div>

                        <div class="col-12 col-xl-4  ml-auto mt-2 mt-lg-0">

                            <div class="input-group ml-auto pb-1 ">

                                <div class="input-group pb-1 ">
                                    <button id="search_btn" class="input-group-prepend btn btn-primary shadow-none d-flex align-items-center"><img src="<?= base_url('assets_system/icons/magnifying-glass-solid.svg') ?>" alt="">
                                        &nbsp;Search
                                    </button>

                                    <input type="text" class="form-control" placeholder="Search" value="<?= ($search_data) ? $search_data : ""; ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
                                </div>

                            </div>

                        </div>

                    </div>



                    <div class="py-0 px-1">

                        <div>
                            <div class="row py-1">
                                <div class="col-12 col-xl-4 d-flex justify-content-lg-start justify-content-center align-items-center">
                                    <button id=btn_mark_active class="btn  shadow-none rounded bulk-button technos-button-green rounded  <?= $TAB == 'Active' ? 'd-none' : '' ?>" data-toggle="modal" data-id=Active data-target="#modal_set_ssa" data-action='activate' status=Mark as Active><img style="height: 1rem; width: 1rem; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-check-solid_mark.svg') ?>" alt="">
                                        &nbsp;Mark as Active</button>

                                    <button id=btn_mark_inactive class="btn  shadow-none rounded bulk-button btn-danger  <?= $TAB == 'Active' ? '' : 'd-none' ?>" style="padding: 5px 12px 5px 12px" data-toggle="modal" data-id=Inactive data-target="#modal_set_ssa" data-action='deactivate' status=Mark as Inactive><img style="height: 1rem; width: 1rem; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-x-solid_mark_as.svg') ?>" alt="">
                                        &nbsp;Mark as Inactive</button>
                                </div>

                                <div class="col-12 col-xl-8 d-lg-flex d-none justify-content-end">
                                    <div class="d-flex align-items-center  row">
                                        <div class="d-inline col-12 col-xl-6">
                                            <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing
                                                <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?>
                                                entries&nbsp;</p>
                                        </div>
                                        <div class="d-lg-inline d-flex col-12 col-xl-6 justify-content-center">
                                            <ul class="pagination ml-0 ml-lg-4 m-0 p-0">

                                                <li><a <?php if ($current_page > 1)
                                                            echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>

                                                        < </a>

                                                </li>

                                                <li><a href="?page=1&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page == 1)
                                                                                                            echo "hidden"; ?>>1 </a></li>

                                                <li><a <?php if ($current_page <= 2)
                                                            echo "hidden"; ?>>... </a></li>

                                                <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page <= 2)
                                                                                                                                    echo "hidden"; ?>><?= $prev_page ?></a></li>

                                                <li><a style="color:white ; background-color:#007bff !important">
                                                        <?= $current_page ?> </a></li>

                                                <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page >= $last_page - 1)
                                                                                                                                    echo "hidden"; ?>><?= $next_page ?> </a></li>

                                                <li><a <?php if ($current_page >= $last_page - 1)
                                                            echo "hidden"; ?>>...
                                                    </a></li>

                                                <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page == $last_page || $last_page <= 0)
                                                                                                                            echo "hidden"; ?>><?= $last_page ?> </a></li>

                                                <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)
                                                                                        echo "href='?page=$next_page&row=$row&tab=$TAB'"; ?>>> </a></li>

                                            </ul>
                                        </div>

                                    </div>

                                    <div class="col-sm-3 col-md-2 col-xl-1 col-2-xl d-none d-lg-flex align-items-center justify-content-center justify-content-lg-start mr-lg-0 mr-2">
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

                            <!-- <button id="btn_application"    class=" btn technos-button-gray shadow-none rounded" data-toggle="modal" data-target="#modal_insert"  ><i class="far fa-trash-alt"></i>&nbsp;Delete</button> -->

                        </div>

                    </div>

                    <div class="table-responsive">



                        <table class="table table-bordered m-0" id="table_main" style="width:100%">

                            <thead>
                                <th class="text-center" style="width:5%"><input type="checkbox" name="check_all" id="check_all"></th>
                                <th class="text-center">Asset ID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Serial&nbsp;number</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Location</th>
                                <th class="text-center">Warranty&nbsp;Expires&nbsp;On</th>
                                <th class="text-center">Assigned&nbsp;To</th>
                                <th class="text-center">Action</th>
                            </thead>
                            <tbody id=" tbl_application_container">
                                <?php

                                if ($DISP_ASSETS_INFO) {

                                    foreach ($DISP_ASSET_INFO as $DISP_ASSETS_INFO_ROW) {
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
                                            <td class="text-center" id="select_item">

                                                <input type="checkbox" name="brand" class="check_single" row_id="<?= $DISP_ASSETS_INFO_ROW->id ?>">

                                            </td>
                                            <td class="text-center">
                                                <?= $application_id ?>
                                            </td>
                                            <td class="text-center"><?= $DISP_ASSETS_INFO_ROW->col_asset_name ?></td>
                                            <td class="text-center"><?= $DISP_ASSETS_INFO_ROW->col_asset_serial ?></td>
                                            <td class="text-center"><?= $DISP_ASSETS_INFO_ROW->asset_category_name ?></td>
                                            <td class="text-center"><?= $DISP_ASSETS_INFO_ROW->location_name ?></td>
                                            <td class="text-center">
                                                <?= date(($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y", strtotime($DISP_ASSETS_INFO_ROW->col_asset_warranty_exp)) ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $DISP_ASSETS_INFO_ROW->col_empl_cmid . ' - ' . $DISP_ASSETS_INFO_ROW->col_frst_name . ' ' . $DISP_ASSETS_INFO_ROW->col_last_name ?>
                                            </td>
                                            <td class="text-center">

                                                <div class="btn-action">

                                                    <a href="<?= base_url('assets/edit_asset/' . $DISP_ASSETS_INFO_ROW->id) ?>" class="select_edit_row m-1" style="background-color: transparent; border: none;color: gray; cursor: pointer; !important" row_id="9"> <img src="<?= base_url('assets_system/icons/pen-to-square-solid.svg') ?>" alt="">
                                                    </a>

                                                    <a href="<?= base_url('assets/view_asset/' . $DISP_ASSETS_INFO_ROW->id) ?>" type="submit" class="select_edit_row m-1 " style="background-color: transparent; border: none;color: gray; cursor: pointer; !important" row_id="9"><img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="">
                                                    </a>

                                                </div>


                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr class="table-active">
                                        <td class="p-4" colspan="9">
                                            <center> No Assets Yet</center>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>

                        </table>

                    </div>

                    <div class="col-12 col-lg-6 d-lg-none d-flex justify-content-lg-end ">
                        <div class="col-12  col-lg-6 ml-auto my-2 my-lg-0 row d-flex justify-content-lg-end justify-content-center align-items-center">
                            <div class="d-flex col-12 col-lg-8 justify-content-lg-end justify-content-center align-items-center">
                                <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?>
                                    to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>

                            </div>
                            <div class="d-lg-inline d-flex col-12 col-lg-4 justify-content-center">
                                <ul class="pagination ml-0 ml-lg-4 m-0 p-0">

                                    <li><a <?php if ($current_page > 1)
                                                echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>

                                            < </a>

                                    </li>

                                    <li><a href="?page=1&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page == 1)
                                                                                                echo "hidden"; ?>>1 </a></li>

                                    <li><a <?php if ($current_page <= 2)
                                                echo "hidden"; ?>>... </a></li>

                                    <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page <= 2)
                                                                                                                        echo "hidden"; ?>><?= $prev_page ?></a></li>

                                    <li><a style="color:white ; background-color:#007bff !important">
                                            <?= $current_page ?> </a></li>

                                    <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page >= $last_page - 1)
                                                                                                                        echo "hidden"; ?>><?= $next_page ?> </a>
                                    </li>

                                    <li><a <?php if ($current_page >= $last_page - 1)
                                                echo "hidden"; ?>>... </a></li>

                                    <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page == $last_page || $last_page <= 0)
                                                                                                                echo "hidden"; ?>><?= $last_page ?> </a></li>

                                    <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)
                                                                            echo "href='?page=$next_page&row=$row&tab=$TAB'"; ?>>> </a></li>

                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-3 col-md-2 col-lg-1  d-flex d-lg-none align-items-center justify-content-center  mr-lg-0 m-2">
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

                    <input type='hidden' name='table' value="tbl_asset_assign">

                    <input type='hidden' name='sub_url' value="assetslists">

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



    <div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?
                    </p>
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

    <?php
    if ($this->session->flashdata('SUCC')) {
    ?>
        <script>
            $(document).Toasts('create', {
                class: 'bg-success toast_width',
                title: 'Success!',
                subtitle: 'close',
                body: '<?php echo $this->session->flashdata('SUCC'); ?>'
            })
        </script>
    <?php
    }
    ?>


    <?php
    if ($this->session->flashdata('ERR')) {
    ?>
        <script>
            $(document).Toasts('create', {
                class: 'bg-warning toast_width',
                title: 'Warning!',
                subtitle: 'close',
                body: '<?php echo $this->session->flashdata('ERR'); ?>'
            })
        </script>
    <?php
    }
    ?>



    <script>
        $(document).ready(function() {

            $('.bulk-button').click(function() {

                let action = $(this).data('action');

                if (action == 'activate') {

                    $('#form_activation').attr('action', "<?= base_url('assets/activate') ?>")

                }

                if (action == 'deactivate') {

                    $('#form_activation').attr('action', "<?= base_url('assets/deactivate') ?>")

                }

                let rows_id = [];

                var mymodal_data = $(this).data('id');

                console.log(mymodal_data);

                $('#modal_title').val(mymodal_data);

                var status = $(this).attr('status');

                $('#select_item input[type=checkbox]:checked').each(function() {

                    var selected_item = $(this).attr('row_id');

                    rows_id.push(selected_item);

                })



                $('#list_mark').empty();

                if (rows_id.length > 0) {

                    $('.class_modal_set_ssa').prop('id', 'modal_set_ssa');

                    var list_mark_ids = rows_id.join(" ");

                    $('#list_mark_ids').val(list_mark_ids);

                    rows_id.forEach(function(single_id) {

                        $('#list_mark').append(`<li class="col-md-6">` + String("00000000" + single_id).slice(-8) + `</li>`)

                    })

                } else {

                    $('.class_modal_set_ssa').prop('id', '');

                    // Swal.fire(

                    //     'Please Select Row!',

                    //     '',

                    //     'warning'

                    // )
                    $(document).Toasts('create', {
                        class: 'bg-warning toast_width',
                        title: 'Warning!',
                        subtitle: 'close',
                        body: 'Please Select Row!'
                    })

                }

            })

            $('#row_dropdown').on('change', function() {

                var row_val = $(this).val();

                var tab_val = "Active";

                window.location = "?page=1&row=" + row_val + "&tab=" + tab_val;

                return false;

            });




            $('#check_all').click(function() {

                if (this.checked == true) {

                    Array.from($('.check_single')).forEach(function(element) {

                        $(element).prop('checked', true);

                        $('.check_single').parent().parent().css('background', '#e7f4e4');

                    })

                } else {

                    Array.from($('.check_single')).forEach(function(element) {

                        $(element).prop('checked', false);

                        $('.check_single').parent().parent().css('background', '');

                    })

                }

            });

            $('.check_single').on('change', function() {

                if (this.checked == true) {

                    $(this).parent().parent().css('background', '#e7f4e4');

                } else {

                    $(this).parent().parent().css('background', '');

                }

            });



            $('.delete_data').click(function(e) {

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

                        window.location.href = "<?= base_url('') ?>" + "main_table_02/delete_row?delete_id=" + user_deleteKey + "&table=" + table_name + "&module=" + module_name + "&page=" + page_name;

                    }

                })

            })
        });
    </script>

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

    <script>
        $(document).ready(function() {

            $("#search_btn").on("click", function() {
                search();
            });

            $("#search_data").on("keypress", function(e) {
                if (e.which === 13) {
                    search();
                }
            });

            function search() {
                console.log("Search function called");
                var tab_val = "<?php echo $TAB ?>";
                var optionValue = $('#search_data').val();
                var url = window.location.href.split("?")[0];

                if (window.location.href.indexOf("?") > 0) {
                    window.location = url + "?page=1&tab=" + tab_val + "&all=" + encodeURIComponent(optionValue.replace(/\s/g, '_'));
                } else {
                    window.location = url + "?page=1&tab=" + tab_val + "&all=" + encodeURIComponent(optionValue.replace(/\s/g, '_'));
                }
            }
        });
    </script>




</body>

</html>