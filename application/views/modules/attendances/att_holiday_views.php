<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title d-flex align-items-center"><a href="<?= base_url('attendances') ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                    </a>&nbsp;Holidays<h1>
            </div>
        </div>
        <hr>
        <div class="card border-0 p-0 m-0">
            <div class="card border-0 pt-1 m-0">
                <div class="card-header py-1">
                    <div class="row">
                        <!-- <div class="col-md-1">

                            <select name="filter_year" id="filter_year" class="form-control" onchange="filterYear()">
                                <?php
                                // var_dump($DISP_YEARS);
                                if ($years) {
                                    foreach ($years as $DISP_YEARS_ROW) {
                                ?>
                                        <option value="<?= $DISP_YEARS_ROW->name ?>">
                                            <?= $DISP_YEARS_ROW->name ?>
                                        </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div> -->

                        <div class="col-xl-8">
                            <ul class="nav nav-tabs">
                                <?php foreach ($TAB_YEARS as $year) {  ?>

                                    <li class="nav-item">
                                        <a class="nav-link head-tab <?= $TAB == $year['year'] ? 'active' : '' ?> " href="?tab=<?= $year['year'] ?>"><?= $year['year'] ?><span class="ml-2 badge badge-pill badge-secondary "><?= $year['count'] ?></span></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="table table-bordered m-0" id="table_main" style="width:100%">
                        <thead>
                            <th class="text-center" style="width:5%" hidden><input type="checkbox" name="check_all" id="check_all"></th>
                            <th style='width:20%;text-align: left;'>DATE</th>
                            <th style='width:15%;text-align: left;'>NAME</th>
                            <th style='width:15%;text-align: left;'>TYPE</th>
                            <th style="width:15%" class="text-center" hidden>ACTION</th>
                        </thead>

                        <tbody id="tbl_application_container">
                            <?php foreach ($HOLIDAYS as $holiday) : ?>
                                <tr>
                                    <!-- <td class="text-left" style="width:20%"><?= date_format(date_create($holiday->col_holi_date), $DATE_FORMAT) ?></td> -->
                                    <td><?= date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($holiday->col_holi_date)) ?></td>
                                    <td class="text-left" style="width:15%"><?= $holiday->name ?></td>
                                    <td class="text-left" style="width:15%"><?= $holiday->col_holi_type ?></td>
                                </tr>

                            <?php endforeach ?>
                            <?php if (!$HOLIDAYS) : ?>
                                <tr class="table-active">
                                    <td colspan="9">
                                        <center>No Records</center>
                                    </td> 
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // function filterYear() {
    //     var url = '<?= base_url() ?>';
    //     const year = document.getElementById('filter_year').value;

    //     fetch(url + 'attendances/holiday_select_api', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json'
    //             },
    //             body: JSON.stringify(approver_count)
    //         })
    //         .then(response => response.json())
    //         .then(result => {
    //             console.log(result);
    //             if (result.success_message) {
    //                 $(document).Toasts('create', {
    //                     class: 'bg-success toast_width',
    //                     title: 'Success!',
    //                     subtitle: 'close',
    //                     body: result.success_message
    //                 })
    //             }

    //             if (result.warning_message) {
    //                 $(document).Toasts('create', {
    //                     class: 'bg-warning toast_width',
    //                     title: 'Warning!',
    //                     subtitle: 'close',
    //                     body: result.warning_message
    //                 })
    //             }

    //         })
    //         .catch(error => {
    //             $(document).Toasts('create', {
    //                 class: 'bg-warning toast_width',
    //                 title: 'Warning!',
    //                 subtitle: 'close',
    //                 body: 'Please provide all required information.'
    //             })
    //             console.error('Data update error:', error);
    //         });
    // }
</script>