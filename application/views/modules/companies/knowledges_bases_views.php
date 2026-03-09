<?php $this->load->view('templates/css_link'); ?>

<style>
    @media (max-height: 1280px) {
        .col-2-xl {
            flex-basis: 16.66667%;
            max-width: 16.66667%;
        }
    }
</style>

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

<div class="content-wrapper">

    <div class="container-fluid p-4">

        <div class="row pt-1">

            <div class="col-md-6">

                <h1 class="page-title d-flex align-items-center"><a onclick="afterRenderFunction()" href="<?= base_url('companies') ?>"><img
                            style="width: 24px; height: 24px; margin-bottom: 3px;"
                            src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                    </a>&nbsp;Knowledge Base<h1>

            </div>



            <div class="col-md-6 button-title">

                <!-- <a href="https://dev-env.eyebox.app/main_table_02/add_data?GnVsauV9Dt5zrTDeAwUduYKsDzFiwmKOzsLtZsjEtpq7tfGTg61xIs06qnr&O+MyWzof6l4Edu3MW4k7nbjzc6sQzYk4Tp87H59jkyJEMF3Ypjce808XRaVvcRaAViHetf7Y7PvY5pIdUsqmpIJQIs33is1K+4g0oOEV+77kbQ2t0IJbOu5WokJlaMqTT&2vGgS1jDaFQSwWlSMhK4Pzjx6OwS+96k9nbSFcmRYVTpankZEuOjjuabN&ndwFEFEK7E&FjywJ+52n1ozIfLP4CAmGwijisPB+v0WXxec&me9u9cSm75Q9dZLwVrwa2oSduDnfd37p+9qsZjRCiLfTJUR4LrEE5poRfrRcOxLzc7P46zfd9SU6ERFq2VFTtX36gBpPV+p2V3CEBfgEKWAeGPPy1JyMMwyM91Jk2EAN9m+wVpmxQPxCN6C73oYD2y+9IUgYwxWHLT3YasAQytN7bAhTtB1kTXbPGJ9qjw4d4gqrwUTL7JHn&2S3yhiLGqSlbyE6g3G6sUu3oqQV12xVm4fR0VPXKMo6nztx9+YBuB6K7TEZrp2a3C1oafy1zPk4H&waV3T+&LstO2q9XOuJhyVyWXHMHbBlYJ6IR7Rdfl4CU2Hvfr5QoBVfbw27HsLQdqZLdygMYhUFzoM7U9OtsK7Y2dPprJyUI8gL8ltKC6unnaT7H8bDl9i4WGk1h5UJXiD6sxROqNv30YMKL945gtgvXlp9zxtrP&H3JxNAaXimHcgckzq76wLTofmuBHnG1+vkEfOLYUpHLCdTQkFnspqCH2R3UoU&0&bIKxQOYHifOGCj9C1hK5e0lC3KUez4uoJ3XtvpV77ko37qrV+3cQBM6aw6ofqu6o+p9C3VlXKYb8LO22WJCPA4wN2+wknU9fk0QPzDaQHFgsfg4U1Rvt1wk6MV07ygvcMD7Lqs8l&w2t9hWJMXUbhImrMCZyGekO2&xp+svh&JzjOXDv4vV&I4NAm1EezbG76IvV2dz6QYvDb20Qsbaez&fshswkEOndvaGCchXpO4sKLdrVe+6SpjgmCHOq&Lz5W9X+o02+WLl9bcdQ2OSIeEuGiqv4IHaZGUdZYwF7pItV4mP5YlQAmAeULlYa1cFLlsNYVSz3uwVzmLsbT0Kq&EqKdZGkmWKLur97k85AfQiOl0e1zob0FWez7ZmdTOwOYjpHIzY9XqcGOdHPorXM44xr9xSvm3gaHkQubd6WBWftcJ0J96tdSLMyptpydNr8rhG7yFNIsGveGQCLx+6l1sxwoTRJyjTSkQarx1nc4UfxjGd60GpFvuVwj7i9W7DahlA+chbqbOjFumxeEH&MhJ+jPht9QuN&P8fYyi9PZS9BL6Ldrlgc9eo+&KfxruVSg841KUjTQ4TrgnFy1stfAG4nOSLh0FlCiA+Wny6UrM3LPmyAjtaq3R5b7cdkdwetYKluBEffqq8poEe9ZDJBWUmweP+pmPZQEz5s6bU982g0Jwa3Q+NDQSegxL5W65P&CS7Nf+Tg3H2RfPPDP4PJ7tvUA09nLjouPPUiznKIZ49GnzBw5Iz6DviECl6&THXsLOhOLwPO7ayiKGIjLEEMFT&Rro6NfnzQm+qddgejdZAUtqb1dzccZb9s467wppIsnYAjH9lhNeDU3KhckzR1PEf+457JR0QZLcipV9cXW2BG0ej9HC8RjpZRK+JhD0bDxmZfSjfwiKtDYmIsPppstju1aHhrEoUXSoetzi7hpvIf7ZEyYbEC4+sp8yU9z2Hlepsaw9rqO8AUgoQc8JySMTwei71L8EdWC0WzNcUP18eKxvY+2Ghvss5fYd5APKhwErkX9HLm4JKGaVysspybnf&0qfxq+7lK3Q2iQf6&2eIcIftgR3LsxilMDUEYnr44i9IUH9&alD3VkauKmggaepFonzv0brrJXQtR8v2cZC5g0xsM6OG9&NS9DkxwLCTQmfavpfRHQtZ2AceJ&ytFLtagLrfckSdv5pLYeMvrhb1VlHhKZk29tHaa5P+k7uwqdzsec&NdBKNA+aiBmenNUD3oDScyRx5oPzkHYoJCmLJ3c9bSonUEOqBE5GXtKexEj23o5jewDKE3d706DoX7DQMzxt0p+eAGdHtLCo73K4imyzHiQndfnAog2oetxrzazloiNto8&Bg6Cz1NCUCgoV8dErAjmfnxbydtnPji+T01XZRc&wFbSGI3re9G581EtPDTQn14BR+88IL4yMXRGn40CE0thmNjhWN+sLh2Vzl&DOhac8nMJUJ6666uTwV9RoFAlLXvFRoYsXo1yffptYkZYu6wbOIi2fkax7KF6kSMwHTlD14q8cdMFQ&GnwsUPI0Ppvgsfc1nbPuT1klAsJyRmHzFUmPuwdzGDQPoJyL5MmCombeRLsYOJXzYgMzT6JftsNKXsSfkiCHpY&OFKH3eXNgY1rfs2v9tsZyClqCfKaDtPv1RNgGwgeYCU+EFjJKcVFyDMk0yIjKj&+ChZ9+Ow6GH5ChSPABsmEmYFK2UFvEQsRVEbIRLc4FNSq2MJ720j01CMnjOLxVJ&4q+wcjeQT2AyUrWRhVswfc1T+iqE&G00pluE&JYElbmUWPigwP4EACVJPwD88vgL&2Jth01scKl7CDHWYIk4S8wo9SNH8MlWhQFZhPA&cPjPGOHG8UR+bASCQ3XW059&iz5DjNbLvZNyo3U0zefoRpXk01wJ9C8VRzcvI18nAtGrHYTXrhEtIm2w6mBYmanEWGa8yZ512O&RZR+E5BAEc5Y55Us083P1FKe7BQx&cabblozpO8XJrL5T7+4AKtjLcgNf4anO3XoEF0PfqvnSS1xIAGlueZ6mRM+EpEqOObJhVTx34feSFaJEpYr7dOwtS8dLREvDu9QqJfRnhVKxUW0H0lCb7wNYpis4HOdH+48Kx4yo=" id="btn_application" class=" btn technos-button-green shadow-none rounded" ><i class="fas fa-plus"></i>&nbsp;</a> -->


                <a onclick="afterRenderFunction()" href="<?= base_url('companies/add_knowledge_base') ?>" class=" btn btn-primary shadow-none rounded "
                    style="padding-top: 8px"><img src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
                    &nbsp;Add knowledge bases</a>

                <a id="btn_export" class=" btn btn-primary text-light shadow-none rounded "><img
                        src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>" alt=""
                        style="margin-bottom: 4px;">
                    &nbsp;Export XLSX</a>





            </div>

        </div>

        <!-- <hr> -->

        <!-- <div class = "pb-1">     -->

        <!-- </div> -->

        <div class="card border-0 p-0 m-0">

            <div class="card border-0 pt-1 m-0">

                <div class="card-header p-0">

                    <div class="row">

                        <div class="col-xl-8">

                            <ul class="nav nav-tabs">

                                <li class="nav-item">

                                    <a class="nav-link head-tab  <?= $TAB == 'Active' ? 'active' : '' ?>"
                                        id="tab-Active" href="?page=1&row=<?= $row ?>&tab=Active">Active<span
                                            class="ml-2 badge badge-pill badge-secondary"><?= $ACTIVES ?></span></a>

                                </li>

                                <li class="nav-item">

                                    <a class="nav-link head-tab <?= $TAB == 'Inactive' ? 'active' : '' ?>"
                                        id="tab-Inactive" href="?page=1&row=<?= $row ?>&tab=Inactive">Inactive<span
                                            class="ml-2 badge badge-pill badge-secondary"><?= $INACTIVES ?></span></a>

                                </li>



                            </ul>

                        </div>

                        <div class="col-xl-4">

                            <div class="input-group pb-1 ">

                                <button id="search_btn"
                                    class="input-group-prepend btn btn-primary shadow-none d-flex align-items-center"><img
                                        src="<?= base_url('assets_system/icons/magnifying-glass-solid.svg') ?>" alt="">
                                    &nbsp;Search</button>



                                <input type="text" class="form-control" placeholder="Search" id="search_data" value=""
                                    aria-label="Username" aria-describedby="basic-addon1">

                            </div>

                        </div>

                    </div>

                </div>



                <div class="p-2 d-none d-lg-block">

                    <div class="row align-items-center py-1">

                        <div
                            class=" d-flex col-sm-9 col-md-10 col-xl-12 justify-content-lg-end justify-content-center my-lg-0 my-2">
                            <div class="d-flex align-items-center  row">

                                <div class="d-inline col-12 col-xl-6">
                                    <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing
                                        <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;
                                    </p>
                                </div>

                                <div
                                    class="d-lg-inline d-flex col-12 col-xl-6 justify-content-center justify-content-lg-end">
                                    <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">

                                        <li><a <?php if ($current_page > 1)
                                            echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>

                                                < </a>

                                        </li>

                                        <li><a href="?page=1&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page == 1)
                                                echo "hidden"; ?>>1 </a></li>

                                        <li><a <?php if ($current_page <= 2)
                                            echo "hidden"; ?>>... </a></li>

                                        <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page <= 2)
                                                    echo "hidden"; ?>><?= $prev_page ?></a>
                                        </li>

                                        <li><a style="color:white ; background-color:#007bff !important">
                                                <?= $current_page ?> </a></li>

                                        <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page >= $last_page - 1)
                                                    echo "hidden"; ?>><?= $next_page ?> </a></li>

                                        <li><a <?php if ($current_page >= $last_page - 1)
                                            echo "hidden"; ?>>... </a></li>

                                        <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page == $last_page || $last_page <= 0)
                                                  echo "hidden"; ?>><?= $last_page ?> </a></li>

                                        <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)
                                            echo "href='?page=$next_page&row=$row&tab=$TAB'"; ?>>> </a></li>

                                    </ul>
                                </div>
                            </div>

                            <div
                                class=" col-sm-3 col-md-2 col-xl-1 col-2-xl d-flex align-items-center justify-content-center mr-lg-0 mr-2">
                                <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>

                                <select id="row_dropdown" class="custom-select" style="width: auto;">

                                    <?php

                                    foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>

                                        <option value=<?= $C_ROW_DISPLAY_ROW ?>     <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>

                                        <?php

                                    } ?>

                                </select>

                            </div>
                        </div>



                    </div>

                </div>

                <div class="table-responsive">



                    <table class="table table-bordered m-0" id="table_main" style="width:100%">

                        <thead>



                            <th class="text-center" style="width:5%"><input type="checkbox" name="check_all"
                                    id="check_all"></th>

                            <th style='width:5%;text-align: left;'>ID</th>

                            <th style='width:20%;text-align: left;'>TITLE</th>

                            <th style='width:35%;text-align: left;'>DESCRIPTION</th>
                            <th style='width:15%;text-align: left;'>STATUS</th>
                            <th style="width:15%" class="text-center">ACTION</th>

                        </thead>

                        <tbody id="tbl_application_container">

                            <?php if ($KNOWLEDGE_BASES):
                                foreach ($KNOWLEDGE_BASES as $knowledge): ?>

                                    <tr>

                                        <td class="text-center" id="select_item">

                                            <input type="checkbox" name="brand" class="check_single"
                                                row_id="<?= $knowledge->id ?>">

                                        </td>



                                        <td class="text-left" style="width:5%">
                                            <?= 'KNB' . str_pad($knowledge->id, 5, '0', STR_PAD_LEFT) ?>
                                        </td>



                                        <td class="text-left" style="width:20%"><?= $knowledge->title ?></td>



                                        <td class="text-left" style="width:35%"><?= $knowledge->description ?></td>



                                        <td class="text-left" style="width:15%"><?= $knowledge->status ?></td>



                                        <td class="text-center">

                                            <div class="action_btn">

                                                <a onclick="afterRenderFunction()" href="<?= base_url('companies/knowledge_base/' . $knowledge->id) ?>"
                                                    class="select_edit_row m-1"
                                                    style="background-color: transparent; border: none;color: gray; cursor: pointer; !important"
                                                    row_id="9"> <img
                                                        src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>"
                                                        alt="" id="view">
                                                    </i></a>



                                                <a onclick="afterRenderFunction()" href="<?= base_url('companies/edit_knowledge_base/' . $knowledge->id) ?>"
                                                    type="submit" class="select_edit_row m-1"
                                                    style="background-color: transparent; border: none;color: gray; cursor: pointer; !important"
                                                    row_id="9"><img
                                                        src="<?= base_url('assets_system/icons/pen-to-square-solid.svg') ?>"
                                                        alt="" id="edit">
                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                <?php endforeach ?>
                            <?php else: ?>
                                <tr class="table-active">
                                    <td colspan=10 class="text-center">No Records</td>
                                </tr>
                            <?php endif ?>
                        </tbody>

                    </table>

                </div>

                <div class="p-2 d-block d-lg-none">

                    <div class="row align-items-center py-1">

                        <div
                            class=" d-flex col-sm-9 col-md-10 col-lg-11 justify-content-lg-end justify-content-center my-lg-0 my-2">
                            <div class="d-flex align-items-center  row">
                                <div class="d-inline col-12 col-lg-6">
                                    <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing
                                        <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;
                                    </p>
                                </div>
                                <div
                                    class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-end">
                                    <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">

                                        <li><a <?php if ($current_page > 1)
                                            echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>

                                                < </a>

                                        </li>

                                        <li><a href="?page=1&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page == 1)
                                                echo "hidden"; ?>>1 </a></li>

                                        <li><a <?php if ($current_page <= 2)
                                            echo "hidden"; ?>>... </a></li>

                                        <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page <= 2)
                                                    echo "hidden"; ?>><?= $prev_page ?></a>
                                        </li>

                                        <li><a style="color:white ; background-color:#007bff !important">
                                                <?= $current_page ?> </a></li>

                                        <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page >= $last_page - 1)
                                                    echo "hidden"; ?>><?= $next_page ?> </a></li>

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

                        <div
                            class=" col-sm-3 col-md-2 col-lg-1  d-flex align-items-center justify-content-center mr-lg-0 mr-2">
                            <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>

                            <select id="row_dropdown" class="custom-select" style="width: auto;">

                                <?php

                                foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>

                                    <option value=<?= $C_ROW_DISPLAY_ROW ?>     <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>

                                    <?php

                                } ?>

                            </select>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>









<!-- Set SSA -->

<div class="modal fade class_modal_set_ssa" id="modal_set_ssa" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-md" role="document">

        <div class="modal-content">

            <div class="modal-header" style="border-bottom: none;">

                <h4 class="modal-title ml-1" id="exampleModalLabel">Set Status</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <form id='form_activation' action="" method="post">

                <input type='hidden' name='table' value="tbl_hr_knowledgebases">

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

<?php $this->load->view('templates/jquery_link'); ?>

<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

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
    $(document).ready(function () {

        var model_name = "main_table_02_model";

        var module_name = "companies";

        var table_name = "tbl_hr_announcements";

        var page_name = "announcements";

        var url_get_all = "<?= base_url('companies/announcements') ?>";

        $('.bulk-button').click(function () {

            let action = $(this).data('action');

            if (action == 'activate') {

                $('#form_activation').attr('action', "<?= base_url('companies/activate') ?>")

            }

            if (action == 'deactivate') {

                $('#form_activation').attr('action', "<?= base_url('companies/deactivate') ?>")

            }

            let rows_id = [];

            var mymodal_data = $(this).data('id');

            console.log(mymodal_data);

            $('#modal_title').val(mymodal_data);

            var status = $(this).attr('status');

            $('#select_item input[type=checkbox]:checked').each(function () {

                var selected_item = $(this).attr('row_id');

                rows_id.push(selected_item);

            })



            $('#list_mark').empty();

            if (rows_id.length > 0) {

                $('.class_modal_set_ssa').prop('id', 'modal_set_ssa');

                var list_mark_ids = rows_id.join(" ");

                $('#list_mark_ids').val(list_mark_ids);

                rows_id.forEach(function (single_id) {

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



        $('#row_dropdown').on('change', function () {

            var row_val = $(this).val();

            var tab_val = "Active";

            window.location = "?page=1&row=" + row_val + "&tab=" + tab_val;

            return false;

        });

        $('#check_all').click(function () {

            if (this.checked == true) {

                Array.from($('.check_single')).forEach(function (element) {

                    $(element).prop('checked', true);

                    $('.check_single').parent().parent().css('background', '#e7f4e4');

                })

            } else {

                Array.from($('.check_single')).forEach(function (element) {

                    $(element).prop('checked', false);

                    $('.check_single').parent().parent().css('background', '');

                })

            }

        })

        $('.check_single').on('change', function () {

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



        $("#clear_search_btn").on("click", function () {

            var url = window.location.href.split("?")[0];

            window.location = url

        });



        $("#search_btn").on("click", function () {

            search();

        });



        $("#search_data").on("keypress", function (e) {

            if (e.which === 13) {

                search();

            }

        });



        function search() {

            var tab_val = "Active";

            var optionValue = $('#search_data').val();

            var url = window.location.href.split("?")[0];

            if (window.location.href.indexOf("?") > 0) {

                window.location = url + "?page=1&tab=" + tab_val + "&all=" + optionValue.replace(/\s/g, '_');

            } else {

                window.location = url + "?page=1&tab=" + tab_val + "&all=" + optionValue.replace(/\s/g, '_');

            }

        }





        $('.delete_data').click(function (e) {

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

                    window.location.href = "<?= base_url() ?>" + "main_table_02/delete_row?delete_id=" + user_deleteKey + "&table=" + table_name + "&module=" + module_name + "&page=" + page_name;

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

<!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> -->
<script src="<?= base_url() ?>assets_system/js/xlsx.full.min.js"></script>

<script>
    document.getElementById("btn_export").addEventListener('click', function () {

        /* Create worksheet from HTML DOM TABLE */

        var wb = XLSX.utils.table_to_book(document.getElementById("table_main"));

        /* Export to file (start a download) */

        XLSX.writeFile(wb, "announcements.xlsx");

    });
</script>