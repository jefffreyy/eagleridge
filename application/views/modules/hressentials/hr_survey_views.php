<?php $this->load->view('templates/css_link'); ?>

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

<div class="content-wrapper">

    <div class="container-fluid p-4">

        <div class="row pt-1">

            <div class="col-md-6">

                <h1 class="page-title d-flex align-items-center"><a href="<?= base_url('hressentials') ?>">
                        <img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>
                    &nbsp;Survey</h1>

            </div>



            <div class="col-md-6 button-title d-flex justify-content-center justify-content-lg-end">
                <a href="<?= base_url('hressentials/add_survey') ?>" class="mr-1 btn btn-primary shadow-none rounded">
                    <img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
                    &nbsp;Add Survey</a>

                <a id="btn_export" class=" btn btn-primary text-light shadow-none rounded"><img class="mb-1" src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>" alt="">
                    &nbsp;Export XLSX</a>

            </div>

        </div>

        <hr>

        <!-- <div class = "pb-1">     -->

        <!-- </div> -->

        <div class="card border-0 p-0 m-0">

            <div class="card border-0 pt-1 m-0">

                <div class="card-header p-0 row ">

                    <div class="col-12 col-lg-8">
                        <ul class="nav nav-tabs">

                            <li class="nav-item">

                                <a class="nav-link head-tab  <?= $TAB == 'Active' ? 'active' : '' ?>" id="tab-Active" href="?page=1&row=<?= $row ?>&tab=Active">Active<span class="ml-2 badge badge-pill badge-secondary"><?= $ACTIVES ?></span></a>

                            </li>

                            <li class="nav-item">

                                <a class="nav-link head-tab <?= $TAB == 'Inactive' ? 'active' : '' ?>" id="tab-Inactive" href="?page=1&row=<?= $row ?>&tab=Inactive">Inactive<span class="ml-2 badge badge-pill badge-secondary"><?= $INACTIVES ?></span></a>

                            </li>
                        </ul>
                    </div>

                    <div class="col-12 col-lg-4 mt-1 mt-lg-0">
                        <div class="input-group mr-1  ml-auto" style="width:max-content">
                            <div class="input-group-prepend">
                                <button id="search_btn" class="input-group-prepend btn btn-primary shadow-none d-flex align-items-center"><img src="<?= base_url('assets_system/icons/magnifying-glass-solid.svg') ?>" alt="">
                                    &nbsp;Search</button>
                            </div>
                            <select class="select-employee d-block" id="search_data" style="min-width:300px;width:max-content">
                                <option value=''>All</option>
                                <?php foreach ($EMPLOYEE_LIST as $employee) {  ?>
                                    <option value="<?= $employee->id ?>" <?= $EMPLOYEE == $employee->id ? 'selected' : '' ?>><?= $employee->employee ?></option>
                                <?php } ?>
                            </select>

                        </div>
                    </div>
                </div>

                <div class="p-2">

                    <div class="row py-1 justify-content-between">

                        <div class="col-12 col-lg-3 d-flex justify-content-lg-start justify-content-center">
                            <button id=btn_mark_active class="mr-1      btn  shadow-none rounded bulk-button technos-button-green rounded " data-toggle="modal" data-id=Active data-target="#modal_set_ssa" data-action='activate' status=Mark as Active><img style="height: 1rem; width: 1rem; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-check-solid_mark.svg') ?>" alt="">
                                &nbsp;Mark as Active</button>

                            <button id=btn_mark_inactive class="btn  shadow-none rounded bulk-button btn-danger  " style="padding: 5px 12px 5px 12px" data-toggle="modal" data-id=Inactive data-target="#modal_set_ssa" data-action='deactivate' status=Mark as Inactive><img style="height: 1rem; width: 1rem; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-x-solid_mark_as.svg') ?>" alt="">
                                &nbsp;Mark as Inactive</button>
                        </div>

                        <div class="col-12 col-lg-7 d-lg-flex d-none justify-content-end">
                            <div class="col-12 col-lg-4 d-flex justify-content-center my-2 my-lg-0 ">
                                <div class="row d-flex align-items-center justify-content-end">
                                    <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>

                                    <div class="d-lg-inline d-flex col-12 col-lg-4 justify-content-center">
                                        <ul class="pagination ml-0 ml-lg-4 m-0 p-0">

                                            <li>
                                                <a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB&all=$EMPLOYEE'"; ?>>
                                                    < </a>
                                            </li>

                                            <li><a href="?page=1&row=<?= $row ?>&tab=<?= $TAB ?>&all=<?= $EMPLOYEE ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>

                                            <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>

                                            <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>&all=<?= $EMPLOYEE ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>

                                            <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>

                                            <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>&all=<?= $EMPLOYEE ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>

                                            <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>

                                            <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&tab=<?= $TAB ?>&all=<?= $EMPLOYEE ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>

                                            <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row&tab=$TAB&all=$EMPLOYEE'"; ?>>> </a></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3 col-md-2 col-lg-1 d-none d-lg-flex align-items-center justify-content-center justify-content-lg-start mr-lg-0 mr-2">
                            <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>

                            <select id="row_dropdown" class="custom-select" style="width: auto;">

                                <?php

                                foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>

                                    <option value=<?= $C_ROW_DISPLAY_ROW ?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>

                                <?php

                                } ?>

                            </select>
                        </div>






                        <!-- <button id="btn_application"    class=" btn technos-button-gray shadow-none rounded" data-toggle="modal" data-target="#modal_insert"  ><i class="far fa-trash-alt"></i>&nbsp;Delete</button> -->

                    </div>

                </div>

                <div class="table-responsive">



                    <table class="table table-bordered m-0" id="table_main" style="width:100%">

                        <thead>



                            <th class="text-center" style="width:5%"><input type="checkbox" name="check_all" id="check_all"></th>

                            <th style='width:5%;text-align: left;'>ID</th>
                            <th style='width:5%;text-align: left;'>EMPLOYEE</th>
                            <th style='width:20%;text-align: left;'>TITLE</th>

                            <th style='width:35%;text-align: left;'>DESCRIPTION</th>

                            <th style='width:15%;text-align: center;'>STATUS</th>



                            <th style="width:15%" class="text-center">ACTION</th>

                        </thead>

                        <tbody id="tbl_application_container">
                            <?php if ($TABLE_DATA) { ?>
                                <?php foreach ($TABLE_DATA as $row_data) : ?>

                                    <tr>

                                        <td class="text-center" id="select_item">

                                            <input type="checkbox" name="brand" class="check_single" row_id="<?= $row_data->id ?>">

                                        </td>



                                        <td class="text-left" style="width:5%"><?= 'SRV' . str_pad($row_data->id, 5, '0', STR_PAD_LEFT) ?></td>
                                        <td class="text-left" style="width:20%"><?= $row_data->employee ?></td>

                                        <td class="text-left" style="width:20%"><?= $row_data->title ?></td>



                                        <td class="text-left" style="width:35%"><?= $row_data->description ?></td>



                                        <td class="text-center" style="width:15%"><?= $row_data->status ?></td>



                                        <td class="text-center">
                                            <div class="action_btn">

                                                <a href="<?= base_url('hressentials/show_survey/' . $row_data->id) ?>" class="select_edit_row m-1" style="background-color: transparent; border: none;color: gray; cursor: pointer; !important" row_id="9">
                                                    <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="">
                                                </a>
                                                <a href="<?= base_url('hressentials/edit_survey/' . $row_data->id) ?>" type="submit" class="select_edit_row m-1" style="background-color: transparent; border: none;color: gray; cursor: pointer; !important" row_id="9">
                                                    <img src="<?= base_url('assets_system/icons/pen-to-square-solid.svg') ?>" alt="">
                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                <?php endforeach ?>
                            <?php } else { ?>
                                <tr class="table-active">
                                    <td colspan=10>
                                        <center>No Records</center>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>

                </div>

                <div class="col-12 col-lg-6 d-lg-none d-flex justify-content-lg-end">
                    <div class="col-12  col-lg-6 ml-auto my-2 my-lg-0 row d-flex justify-content-lg-end justify-content-center align-items-center">
                        <div class="d-flex col-12 col-lg-8 justify-content-lg-end justify-content-center align-items-center">
                            <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                        </div>

                        <div class="d-lg-inline d-flex col-12 col-lg-4 justify-content-center">
                            <ul class="pagination ml-0 ml-lg-4 m-0 p-0">

                                <li>
                                    <a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB&all=$EMPLOYEE'"; ?>>
                                        < </a>
                                </li>

                                <li><a href="?page=1&row=<?= $row ?>&tab=<?= $TAB ?>&all=<?= $EMPLOYEE ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>

                                <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>

                                <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>&all=<?= $EMPLOYEE ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>

                                <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>

                                <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>&all=<?= $EMPLOYEE ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>

                                <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>

                                <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&tab=<?= $TAB ?>&all=<?= $EMPLOYEE ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>

                                <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row&tab=$TAB&all=$EMPLOYEE'"; ?>>> </a></li>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 col-md-2 col-lg-2  d-flex d-lg-none align-items-center justify-content-center justify-content-lg-start mr-lg-0 m-2">
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

                <input type='hidden' name='table' value="tbl_hr_surveys">

                <input type='hidden' name='sub_url' value="surveys">

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

<?php $this->load->view('templates/jquery_link'); ?>

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
        $('.select-employee').select2();
        var model_name = "main_table_02_model";

        var module_name = "companies";

        var table_name = "tbl_hr_announcements";

        var page_name = "announcements";

        var url_get_all = "<?= base_url('companies/announcements') ?>";

        $('.bulk-button').click(function() {

            let action = $(this).data('action');

            if (action == 'activate') {

                $('#form_activation').attr('action', "<?= base_url('hressentials/activate') ?>")

            }

            if (action == 'deactivate') {

                $('#form_activation').attr('action', "<?= base_url('hressentials/deactivate') ?>")

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
            var optionValue = $('#search_data').val();
            window.location = "?page=1&row=" + row_val + "&tab=" + tab_val + '&all=' + optionValue;

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

        })

        $('.check_single').on('change', function() {

            if (this.checked == true) {

                $(this).parent().parent().css('background', '#e7f4e4');

            } else {

                $(this).parent().parent().css('background', '');

            }

        })



        // $("#search_btn").on("click", function() {

        //     $('#search_data').val();

        //     var optionValue = $('#search_data').val();

        //     var url = window.location.href.split("?")[0];

        //     if (window.location.href.indexOf("?") > 0) {

        //         window.location = url + "?page=1&all=" + optionValue.replace(/\s/g, '_');

        //     } else {

        //         window.location = url + "?page=1&all=" + optionValue.replace(/\s/g, '_');

        //     }

        // })



        $("#clear_search_btn").on("click", function() {

            var url = window.location.href.split("?")[0];

            window.location = url

        });



        $("#search_btn").on("click", function() {

            search();

        });



        $("#search_data").on("keypress", function(e) {

            if (e.which === 13) {

                search();

            }

        });



        function search() {

            var tab_val = "<?= $TAB ?>";

            var optionValue = $('#search_data').val();

            var url = window.location.href.split("?")[0];
            var row_val = $('#row_dropdown').val();
            window.location.href = "?page=1&row=" + row_val + "&tab=" + tab_val + "&all=" + optionValue;
            // if (window.location.href.indexOf("?") > 0) {

            //     window.location.href = "?page=1&tab=" + tab_val + "&all=" + optionValue.replace(/\s/g, '_');

            // } else {

            //     window.location =+ "?page=1&tab=" + tab_val + "&all=" + optionValue.replace(/\s/g, '_');

            // }

        }





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



        // $('.edit_data_id').click(function(e) {

        //     e.preventDefault(); // Prevent the default click behavior

        //     var id = $(this).attr('row_id');

        //     $('#edit_id_data').val(id);

        //     // Submit the form

        //     $('#edit_data_id').submit();



        // });

    })
</script>

<script src="<?= base_url('assets_system/js') ?>/xlsx.full.min.js"></script>

<script>
    document.getElementById("btn_export").addEventListener('click', function() {

        /* Create worksheet from HTML DOM TABLE */

        var wb = XLSX.utils.table_to_book(document.getElementById("table_main"));

        /* Export to file (start a download) */

        XLSX.writeFile(wb, "surveys.xlsx");

    });
</script>