<html>
    <style>
    .hover {
        cursor: pointer;
    }

    .img-circle {
        border-radius: 50%;
        width: 100px;
        height: 100px;
        object-fit: scale-down;
    }

    .swal2-validation-message {
        display: block;
        max-width: 100% !important;
        margin: auto !important;
    }

    .filter-container {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease-out;
    }

    .filter-container form {
        margin: 0;
    }

    .filter-container.visible {
        max-height: 1000px;
        transition: max-height 0.5s ease-in-out;
    }
    .button-title {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
    gap: 4px;
  }
    </style>
    <?php $this->load->view('templates/css_link'); ?>

    <?php

    $search_data = $this->input->get('all');
    $search_data = str_replace("_", " ", $search_data ?? '');
    if (isset($_GET['company'])) {
    $param_comp = $_GET['company'];
    } else {
    $param_comp = "";
    }
    if (isset($_GET['branch'])) {
    $param_branch = $_GET['branch'];
    } else {
    $param_branch = "";
    }
    if (isset($_GET['dept'])) {
    $param_dept = $_GET['dept'];
    } else {
    $param_dept = "";
    }
    if (isset($_GET['division'])) {
    $param_division = $_GET['division'];
    } else {
    $param_division = "";
    }
    if (isset($_GET['section'])) {
    $param_section = $_GET['section'];
    } else {
    $param_section = "";
    }
    if (isset($_GET['group'])) {
    $param_group = $_GET['group'];
    } else {
    $param_group = "";
    }
    if (isset($_GET['team'])) {
    $param_team = $_GET['team'];
    } else {
    $param_team = "";
    }
    if (isset($_GET['line'])) {
    $param_line = $_GET['line'];
    } else {
    $param_line = "";
    }
    if (isset($_GET['row'])) {
    $row = $_GET['row'];
    } else {
    $row = 25;
    }
    if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
    } else {
    $current_page = 1;
    }

    $prev_page = $current_page - 1;
    $next_page = $current_page + 1;
    $last_page_initial = ceil($C_DATA_COUNT / $row);
    $last_page = ($last_page_initial == 0 || $last_page_initial == 1) ? 1 : $last_page_initial;

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
    $filter = $this->input->get('filter');
    ?>
    <div class="content-wrapper">
    <div class="container-fluid p-4">
    <div class="row pt-1">
        <div class="col-md-6">
          <h1 class="page-title"><a onclick="afterRenderFunction()" href="<?= base_url('selfservices') ?>"> <img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />

            </a>&nbsp;My Shift Assignment<h1>
        </div>

        <div class="col-md-6 button-title">
          <!-- <a href="https://dev-env.eyebox.app/main_table_02/add_data?GnVsauFqMMl4sADKHhURs4nhFycg12iQnc&mbtvSype8qOqVzoJxLt4xrSqQHe0pTnsj5koCMN&WRpp+1u7ULutL&cctGpw+eJoEl0NMHQSy83Nd1FV7NMdiHWfkVCHes&GUvZnVqsN5UcqmooxFMbnvj6lO+4gyqfUGj6bgCQit0IRTKv0iukIBbsqTSfa6CXCtiVKCQSwQnzYyX5v26xaOwSm4&1wTdSQ4kBYVSJKyguU2PlzvfKMI6NEQAyUS6SvEmzx+jpGzxfnQeNf5CAmAz26lkaxpqH+S0PYF278&paCm75Q7efS3d+Atzcq4rSiRFS64q76vZjREh&aHFRxoJqgEtMJZLtBeOxL1fabrni&YkSA6ERdjzEImrXiehBpPUeJjRAWcAJwDKWAYE+bhoYSJVwqM91RuzVN47mrUX5mxRvlXJNWj2+IL2y+7JV0Ltg2DST3Nerdlx8ZoGRBW0B1wXQG6FIt5+RYZhgirwULGrMDKtl63whixWPf0P0U5g3G8vSvmj+1792RV1eWCgAOzKMo6mTQwo9ZZqBaT7WNC5s3+3S1ob&Kg348gGpgcV3T49a4+TXK4OOyJhyN6TGK6BbUBZJ6IQb9IbSgaVgXqfr5WqgBMGRW+esjQdqBOYjt6ehBhxYM7Vde4o9jA3bfquYzjVsUe4S1SDs+kibSMasrXhK+gXA02h5UPU2Crnl10ucHm&NBKb5ldgNgvWFYUmywiWNXgOkxgaTqQAYoE9Hbf6gLTp&b+QliJhKukVpeLYUpBIjJANVkhlcLBDBNvV+E40&bOIwEdF2CaXGaj9CtqPoTDjCiuVOz4vIhiTazxUtrgo37sqEqkBhhJjac6ofyq&5ze7Cixn3KYac7P2GPoAIIvw92+xEXV9v9VSI&UbAHFhMr08j1J4uwf0vM9i6G2hoFSpeqaph7jqscdaYl2AZAQp6VNBXDXwNvoh4zcpkLimHLHJOVzG6MeYkKmYfTef7mIvVuU2rdopDOS0Qsbb+Tqbbh0xyUPndvcEzIyLou91KDdrVG0&DkTmmXjOa&LyZCoTJos3oGHl9bacRidOJ+B3GWqv4QLaZKVFJ5CAL5ItVgqPpUkIQHybkblYatRAaodLdFjjDfifWGbh6LhabzUuNAqDlnnUceM7aQ370SBhr5Pb0z4Hj4QO3PpidPS0rIwtGJEEsP6ARqQCuk7TLlO168AM&WgkrH0NZHN+REvcdYfw49qwqCYI1sUqzBev9qWbq6VRfIKq&KAGMsE900dvgYFV4yzOlIMes0MkdkHbwixBKwTtCqXWx&om8XMfqhxE5ZYYrHen0vRt&QXjbEQ+i3yqeI3J7ylNp&W4OYlgQqKBJfNi8VYtKCMLkbDCSs&glqjzHR&LLN2RxcrvaQwuiKSLh0FlC+A+Wny6ErM3LPmyQjtaq3R867PZjAHacZ77+5Affqq8poFe9ZDJBWUmweP+paPZQEz586bU982gkJwa3Q+NDQSegxD8H7IRvyF&MTuOX7GzQe+RT&vLIz9yjM19nLjoqaQFWz0XZNogxzrUz4B+rr3gAP8uueySdK58fqhGv7o2zrBdn+cN5wC7mnwvOeniUXLsoExOxQOTBNLPBJzccZb9sg67wppI9rJECGK4ABOfDTHktghVySzbf5IlZljUIDM&eFgYQTPCHoPncG1hAT5FGuyMQHmfEsccfHCd32RsjUkRc+Oor57vzSNkqJSRXHPf73qmgE0YartR0haRB5mpYEvQ6uFC0fYyN0ru7StX39vDY8aszcDtp6jso9YZXSzGC1BQIoMbrweGrbf2KZt&cdMrRvq00Joyi5UVH4ZXxGNzroysP+e1Arf1tjEjsKGnnIpta7OQ8cLpX5mPrsejMS2FJ34mZitVjzl+dhY1FoX36rHhdOxEuv2q1WRvoWnwBM7yrpa4mkwsM6IFsveN8i18EmGDCTNNfpeRHQtZ3UMCeaD4BWjKhztOYpWN9M7ctCZqbVR00gQwsdr09tOaa5PqwS32f9wtOYCM88FaQ+ajhf669IO3JbbZzcD95OEtyR1XXbcYUFXJn4OCFevZkopBPjGyinAiswxI0vZYWVrpIe6AsmFd3pbtdTKKT9Tp82wkEXvyn&GBiBDJbjQ1XilbM8e1aiB+Gk0vpud1vmoiozbXx8FgK5aZU&rklW2JYuL2DzggB+AWJinU4TkHm&S5T46tkc+Wm8KicFCjtdbBJeGVWO451&d6d91Pj4HJJ4G4yJfy7mf56hJzO5ZKuXohejhQqQdRCVMWPNp79RC&EGsdpxY3c0N&XSpUl&u0ew6YRrkGatXY27P7rgMdPtauzWlsUPO2ZU1tZ+dmGHNuT1kwkFQ0kjXigdIYKhF63PAT&sHa9N2VM&HWgP6cJMolMoYyF+BCcUbOQptLQHfcdZnCgf9i8yZ1I5vCtXb9qkZ3SweAOSPGtaIgz49dUtZV2xQWAiVadUyvCtQ5XE+Iza5S1g7nL5kURRs1XWBHZq3kYkOnm4hdkhOHh&uUKYoZau32Z86shSxl3YkiJG3DrGU67Qo3ItWhFTVvRMRTrgZDVXoi6AsCDs5hpYYd91cOSZAfzVoe9khEVYtzEt05iHuyYsQrAhVdzCLWETUWBU3o14+TKTkQ3buDBADNBvPTWuHKAbJXAKIcDiUuSfqrrXFk9GqX5W&PJ682iw7eoh3oA05hkEvX4MM4s3Jz7CX9DyGfGqv3GpQ71xztQAtZmdeWKw2F9ssFZkQE9ZwOhsJ6Yg0Cuxv&LMbdqqHJxrcabCxrW8ckHwYaM266JZ9hDXVyrmvIjaZNcdd&a7&rQGdwxVxCUiOFtbCerxEUeS&LuIOak2sfuDzcOIFNPaNThBU8tahVKrAkkPdSlCPHPwLG1GD6T6C6op1yYNtYLzAio7MqjZrBeajbP4p1fwWOWh3rB8dsF894nfvmbhUVFIGMIC5eFxh6FyQ+OjGSWLFYq8IKunSd79GzHOfk9HsiDidx6bTAJHsRhuunkCQ5mxd0LUNsYbiFdGctQ10d1giy034tAu9fD62neFcEwFWpYIuVpIJ6Xd3zMXaqHhtHKS7jp1PoLSl2xYeyxDTMFYiAPLY+aEmANvPt2bkmHQzcz3WPps8oXWKEbXluxPfidrml3M8QFJOcbK++ral08dCP+N2iVc4YdM1DtQpUkkUuR99MGHFaV7pcwBwp4d2bWjZroyVDhvDY2pzWRTX&hmpgjb3SibZKfL3Suu5UpeYuJHlsuWCB7E+K7lB1Xqe6+F+WLnhpZ&pDhOKVX6oOeELZtMyf3weHH&CxY4qiseXBD5BNsqM0Y&YKvTDi5nnp&o1ju7MdjXrUSnr9JA8EahUlDp9X&nFJ&jMh+lD3qfIfFPqJHZwKmWSV7bDrwZ3JQ35f+hfey3cWRPZwoCQS&ssf2KAhkXwEqmBkuW&LR+VoOg1&Si4hSAIFijnhAGytZwuiDZ&8f2DXU3NLKgIMIHNlVqwfq88zFSQ2iy7cTh1BIxI1&w4k6IgkbfYf3SaH2FMlu1dWWmij6ZM8IBknB3ojw8zYwcqi71vnvlLcqbBJVPXMwgGBWZKGLHjmMI47DBg0Y4GC1xJZeXcoXgh&&SINasDqMjfmojEg6x5li1tJVeIoVK5Nv297S1fVmDj3gCK6dLeWbVBmmUEDRJ4nJRWv&xRpzH71G8AuAtNrIu7SUUq1MjjCefm9LBaJTAQqTLwnzsoMogi9FudM9COYj7H8TxvezaPeW&pNvibDQWYPcXHD+xDl5LFaFVc6qTwwQsbfTH&iNcjCOB9LuOM&bHbpKknsygu&I5eZozXWxCIXf10XWXycljCLnaN5KIfg6+VFImERVzOUJFm&8lIO5B4XOlsnzFa44dAs9YPSaODE1sE+j5E0VYQ&QBnjgipqLVIA7DdCdl3ePcPHsm6WWok41Mgtbr&Z2voVIxr2Q29sBojhlZ0CQCeRvu8DJ71WvyB0C7gWbmbgtdUe4BwL+VBtRAaNpkQgL8iSb9tfZa9TLhFREdp9mEst6PC&RJHbRBczJotu7p7kWrDrUTfTrlBQGyYSbxDR1kaR3p2iTZv+H7foclvkH6JkUyoCarZjimMALyIZSbTg8lhD6mW+&C5IBSvEGM3w1+46cRsLeUGwbWV6inRRe8U99CR5NbBst3Iu78QjW6SAswPSmnyedzKw6gGDX45ikK7uXXo+VyHNoEg&D5jhT3EHo&sL8wykAa+kIwTghGgbW218Mt9TMp+LhKLTHJy+0&sKRUUrMYd1zLUCLW+hGZ3ldZExuUs6BWRxsLKMFB7oyfGSu&wIPRc7Lyo2Smn2X2CemcfnxEx0dU7ih2n6LuYsxUyof4c3l9xChjt6f2z1eeMWBvEYY+EyLMdlJFmBfXF1sDsd8FJBdGLYZ+POvSEiadqw51VpRoQSxGJDAVT4wafb9QIcpKJSJsy+uIAMutQvtUmHUvH&8GlPQlXjfkNysuc4EdXyhSnhiectMxDk24gr7bY+6neBXt9vZNmgfyUjUJZz9WTeoac78RktX+YiIC6CF5lCTa&qqzebyUpqNovA9zs8FFI3aqk2r2hPcyNiwNJGWrjop7gvzcKLkXJCr7rh&3t6tK1mPJHle8oJcyyPWco&1CAnV4g2IgttmTUnde2dwFeS5T1hiTCAV9JuFJC&+yJjiHG3brhy5TN5XELn6hB2XSgQtmVMUdW71ADRo6ElOac0Pd&NVZP&1RkWP9dCxLilxr4DWq4gC23WgIfON0qCrQ4EF7pkqzgXUZwW2UbVAv3ua2yVBUhVbADAV3PUeVExtR6H0z01G8LtOlbEtYVVNVd8QpYtQzLCFJQnsJTFStbLuiOEWTO+n6KUcVbgdwmwI+s3p7DoXvFQ2BZ&jkKbMJylMDdgqeyHwRhpKxoQkL3SUFrUhkAUQM+jLd2YWA=" id="btn_application" class=" btn technos-button-green shadow-none rounded" ><i class="fas fa-plus"></i>&nbsp;Add Request</a> -->

          <!-- <a onclick="afterRenderFunction()" href="<?= base_url('teams/shift_assignment') ?>" class=" btn btn-primary shadow-none rounded d-flex align-items-center"><img src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
            &nbsp;Add Request</a> -->
         


        </div>
      </div>
        <hr class="title-line">



        <div class="filter-container  <?= $filter ? 'visible' : '' ?>">
        

        </div>


        <div class="card border-0 p-0 m-0">

        <div class="card border-0 p-0 m-0">
            <div class="p-2">
            <div>
                <div class='justify-content-between'>
            

                <div class='row mt-3 py-1 justify-content-between'>
                    <div class='col-12 col-lg-4 d-flex justify-content-lg-start justify-content-center'>
                    <!-- <button class="btn technos-button-green shadow-none rounded bulk-button" style="height: 36px; margin-right: 6px;" id="bulk_approved" data-toggle="modal" data-target="#modal_bulk_approved"><i class=""></i><img style="height: 1rem; width: 1rem; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-check-solid_mark.svg') ?>" alt="" />&nbsp;Bulk as Approve</button>
                    <button class="btn btn-danger shadow-none rounded bulk-button" style="height: 36px;" id="bulk_reject" data-toggle="modal" data-target="#modal_bulk_reject"><i class=""></i><img style="height: 1rem; width: 1rem; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-x-solid_mark.svg') ?>" alt="" />&nbsp;Bulk as Reject</button> -->
                    </div>

                    <div class="col-12 col-lg-7 d-lg-flex d-none justify-content-lg-end">
                    <div class=' ml-auto my-2 my-lg-0 row'>
                        <div class="d-inline d-flex col-12 col-lg-6 justify-content-lg-end justify-content-center align-items-center">
                        <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                        </div>
                        <div class="d-lg-inline col-12 col-lg-5 d-flex justify-content-lg-end justify-content-center align-items-center">
                        <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">
                            <li><a class="page_row" <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
                                < </a>
                            </li>
                            <li><a class="page_row" href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                            <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                            <li><a class="page_row" href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                            <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                            <li><a class="page_row" href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                            <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                            <li><a class="page_row" href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page) echo "hidden"; ?>><?= $last_page ?> </a></li>
                            <li><a class="page_row" style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
                        </ul>
                        </div>

                    </div>
                    </div>
                    <div class="col-sm-3 col-md-2 col-lg-1 d-flex align-items-center justify-content-center justify-content-lg-start mr-lg-0 mr-2">
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
            <div class="table-responsive">
            <table class="table table-bordered table-hover m-0" id="TableToExport" style="width:100%">
                <thead>
                <tr>
                    <!-- <th class="text-left"><input type="checkbox" name="check_all" id="check_all"></th> -->
                    <th class="text-left">SHIFT ID</th>
                    <th class="text-left" style='min-width:350px'>EMPLOYEE</th>
                    <th class="text-left">CUT-OFF PERIOD</th>
                    <th class="text-center">STATUS</th>
                    <!-- <th class="text-center">ACTION</th> -->
                </tr>
                </thead>
                <tbody id="tbl_application_container">
                <?php if ($DISP_SHIFT) {
                    foreach ($DISP_SHIFT as $DISP_SHIFT_ROW) { ?>
                    <!-- <tr data-leave_id="<?= $DISP_SHIFT_ROW->id ?>" data-toggle="modal" data-target="#modal_approval" class="hover"> -->
                    <tr >
                        <!-- <td class="text-center select-item-td" id="select_item">
                        <input type="checkbox" name="approval_name" class="check_single" approval_id="<?= convert_cmid($DISP_EMPLOYEES, $DISP_SHIFT_ROW->empl_id) ?>" employee_id="<?= $DISP_SHIFT_ROW->empl_id ?>" row_id="<?= $DISP_SHIFT_ROW->id ?>" value="<?= $DISP_SHIFT_ROW->empl_id ?>" checkbox_stat="">
                        </td> -->
                        <td class="text-left">SRA<?= str_pad($DISP_SHIFT_ROW->id, 5, '0', STR_PAD_LEFT) ?></td>
                        <td class="text-left hover td-directs text-primary" data-empl_id="<?= $DISP_SHIFT_ROW->empl_id ?>">

                        <?= convert_cmid($DISP_EMPLOYEES, $DISP_SHIFT_ROW->empl_id) ?> - <?= convert_data($DISP_EMPLOYEES, $DISP_SHIFT_ROW->empl_id) ?>
                        </td>
                        <!-- <td class="text-left"> <?= date("d/m/Y", strtotime($DISP_SHIFT_ROW->cutoff_period)) ?> </td> -->
                        <td class="text-left"> <?= $DISP_SHIFT_ROW->name ?> </td>
                        <td class="text-center">
                        <a class="btn btn-info" style="width:70px;  font-size: 13px;" href="<?= base_url() . 'selfservices/my_requested_shift/'.$DISP_SHIFT_ROW->empl_id.'/'.$DISP_SHIFT_ROW->cutoff_period ?>">
                         View
                        </a>
                        <!-- <span class="btn btn-warning disabled">
                            <?= $DISP_SHIFT_ROW->status ?>
                        </span> -->
                        <?php
                        $color="";

                        $color_2="";
                        
                        if($DISP_SHIFT_ROW->status == "Checked"){
                            $color_2 = 'background-color: #ff5c0a; color: #fff;';
                            
                        }
                            if($DISP_SHIFT_ROW->status == "Rejected"){
                                $color = "btn-danger";
                            }elseif($DISP_SHIFT_ROW->status == "Pending"){
                                $color = "btn-warning";
                            }elseif($DISP_SHIFT_ROW->status == "Withdrawed"){
                                $color = "btn-secondary";
                            }elseif($DISP_SHIFT_ROW->status == "Approved"){
                                $color = "btn-success";
                            }
                        ?>
                        <span class="btn <?= $color ?> disabled p-2 m-auto" style="width:70px;  font-size: 13px; <?=$color_2?>">
                        <?php
                                preg_match('/pending/i', $DISP_SHIFT_ROW->status, $matches);
                                if (!empty($matches)) {
                                echo 'Pending';
                                } else {
                                echo $DISP_SHIFT_ROW->status;
                                }
                        ?>
                        </span>

                        </td>
                        <!-- <td>
                        <a class="select_row p-1 request_id" data-leave_id="<?= $DISP_SHIFT_ROW->id ?>" data-toggle="modal" data-target="#modal_approval">
                             <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="">

                        </a>
                        </td> -->
<!-- 
                        <td class="text-center">
                        <button class="btn btn-secondary">Withdraw</button>
                        <button class="btn btn-success">Approve</button>
                        <button class="btn btn-danger">Reject</button>
                        </td> -->
                    </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr class="table-active">
                    <td colspan="12">
                        <center>No Records</center>
                    </td>
                    </tr>
                <?php  } ?>
                </tbody>
            </table>
            </div>
            <div class="col-12 col-lg-7 d-lg-none d-block justify-content-lg-end">
            <div class=' ml-auto my-2 my-lg-0 row'>
                <div class="d-inline d-flex col-12 col-lg-6 justify-content-lg-end justify-content-center align-items-center">
                <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                </div>
                <div class="d-lg-inline col-12 col-lg-5 d-flex justify-content-lg-end justify-content-center ">
                <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">
                    <li><a class="page_row" <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
                        < </a>
                    </li>
                    <li><a class="page_row" href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                    <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                    <li><a class="page_row" href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                    <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                    <li><a class="page_row" href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                    <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                    <li><a class="page_row" href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page) echo "hidden"; ?>><?= $last_page ?> </a></li>
                    <li><a class="page_row" style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
                </ul>
                </div>

            </div>

            <div class="col-sm-3 col-md-2 col-lg-2  d-flex align-items-center justify-content-center justify-content-lg-start mr-lg-0 mr-2">
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

    <div class="modal fade vertical-centered" id="modalDirects" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="d-flex justify-content-end">
            <button type="button" class="close pr-3 pt-2" data-dismiss="modal" aria-label="Close" style="font-size: 34px;">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div id="modalLoading" class="modal-body pt-0" style="position:absolute;height:100%;width:100%;background:white;z-index:1000;display:none;">
            <div class="d-flex w-100 h-100 align-items-center justify-content-center">
            <div class="d-flex align-items-center">
                <div class="spinner-border text-primary" role="status" style="width:20px;height:20px">
                <span class="sr-only">Loading...</span>
                </div>
                <span class="ml-1" style="font-weight: 600;font-size:18px">Fetching Data...</span>
            </div>
            </div>
        </div>
        <div class="modal-body pt-0">
            <div class="col card">
            <div id="modalContentEmployee" class="p-0">
                <div class="d-flex justify-content-between align-items-start">
                <div class="d-flex  align-items-center">
                    <div class="profile-pic m-0 p-0">
                    <img class="img-circle rounded-circle avatar m-3  elevation-2" onerror="setDefaultImage(this)" id="employee_img" style="cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Profile Image" src="<?= base_url() ?>/assets_system/images/default_user.jpg">
                    </div>
                    <div class="basic-profile p-2">
                    <div class="d-flex align-items-center">
                        <div class="stats" id="employeeNumber" style="line-height:1;">(No Employee Number)</div>
                    </div>
                    <div class="d-flex align-items-center">
                        <text style="font-size:15px;" class="emp-name text-bold m-0" id="employeeFullName">(No Full Name)</text>
                    </div>
                    <div class="emp-stat m-0 d-flex flex-column p-0">
                        <div>
                        <div class="stats" id="employeePosition">(Position)</div>
                        </div>
                        <div>
                        <div class="stats" id="employeeCompany">(No Company)</div>
                        </div>
                        <div>
                        <div class="stats" id="employeeBranchDepartment">(No Branch / No Department)</div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="p-3">
                <div>
                    <p class="mb-1" style="font-weight:500">Contact Information</p>
                    <div class="d-flex align-items-center mx-2">
                    <i class="fa fa-envelope" aria-hidden="true" style="font-size: 16px"></i>
                    <div class="mx-3">
                        <p class="p-0 m-0" style="line-height: 1;font-size: 13px;">Email:</p>
                        <a class="p-0 m-0" id="employeeEmail">(No Email)</a>
                    </div>

                    </div>
                </div>
                </div>
                <div class="px-3 py-1">
                <div>
                    <p class="mb-1" style="font-weight:500">Reporting To:</p>
                    <div id="reportingToContainer" class="d-flex align-items-center mx-2">
                    (No Reporting To)
                    </div>
                </div>
                </div>
                <div class="p-3">
                <div>
                    <p class="mb-1" style="font-weight:500">Directs:</p>
                    <div id="directsParent" class="mx-2">(No Directs)

                    </div>
                </div>

                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    <div class="modal fade class_modal_approval_list" id="modal_leave_request" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
            <h4 class="modal-title ml-1" id="exampleModalLabel">View Leave Request
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
            </button>
        </div>
        <form action="" id="form_updt_approvers" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
            <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                <ul id="approval_list_id" class="row" style="background: #e7f4e4;"></ul>
                </div>
                <div class="col-md-12">
                <div class="form-group">
                    <label class="required " for="empl_id">ID
                    </label>
                    <input type="text" class="form-control" name="empl_id" id="empl_id" readonly>
                </div>
                <div class="form-group">
                    <label class="required " for="request_by">Request By
                    </label>
                    <input type="text" class="form-control" name="request_by" id="request_by" readonly>
                </div>
                <div class="form-group">
                    <label class="required " for="leave_type">Leave Type
                    </label>
                    <input type="text" class="form-control" name="leave_type" id="leave_type" readonly>
                </div>
                <div class="form-group">
                    <label class="required " for="leave_date">Leave Date
                    </label>
                    <input type="text" class="form-control" name="leave_date" id="leave_date" readonly>
                </div>
                <div class="form-group">
                    <label class="required " for="leave_duration">Leave Duration
                    </label>
                    <input type="text" class="form-control" name="leave_duration" id="leave_duration" readonly>
                </div>
                <div class="form-group">
                    <label class="required " for="status">Status
                    </label>
                    <input type="text" class="form-control" name="status" id="status" readonly>
                </div>
                <div class="form-group">
                    <label class="required " for="remarks">Remarks
                    </label>
                    <input type="text" class="form-control" name="remarks" id="remarks" readonly>
                </div>
                <div class="form-group">
                    <label class="required " for="attachment">Attachment
                    </label>
                    <input type="text" class="form-control" name="attachment" id="attachment" readonly>
                    <a id="download-link" href="#">Download Attachment</a>
                </div>


                </div>
            </div>
            </div>
            <div class="modal-footer">
            <div class="spinner-border text-primary loading_indicator_appr2_appr3" style="display: none;"></div>
            </div>
        </form>
        </div>
    </div>
    </div>
    <div class="modal fade class_modal_approve" id="modal_bulk_approved" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
            <h4 class="modal-title ml-1" id="exampleModalLabel">Leave Bulk Approve
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
            </button>
        </div>
        <form action="<?php echo base_url(); ?>selfservices/leave_bulk_approve" id="form_bulk_approve" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
            <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                <ul id="approve_list_id" class="row" style="background: #e7f4e4;"></ul>
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <input type="hidden" name="EMPLOYEE_ID" id="EMPLOYEE_ID">
            <input type="hidden" name="APPROVE_ID" id="APPROVE_ID">
            <a type="submit" id="submit_bulk_approve" class='btn btn-primary text-light'>&nbsp; Save</a>
            <div class="spinner-border text-primary loading_indicator_appr2_appr3" style="display: none;"></div>
            </div>
        </form>
        </div>
    </div>
    </div>
    <div class="modal fade class_modal_reject" id="modal_bulk_reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
            <h4 class="modal-title ml-1" id="exampleModalLabel">Leave Bulk Reject
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
            </button>
        </div>
        <form action="<?php echo base_url(); ?>selfservices/leave_bulk_reject" id="form_bulk_reject" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
            <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                <ul id="reject_list_id" class="row" style="background: #e7f4e4;"></ul>
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <input type="hidden" name="REJECT_EMPLOYEE_ID" id="REJECT_EMPLOYEE_ID">
            <input type="hidden" name="REJECTED_ID" id="REJECTED_ID">
            <a type="submit" id="submit_bulk_reject" class='btn btn-primary text-light'>&nbsp; Save</a>
            <div class="spinner-border text-primary loading_indicator_appr2_appr3" style="display: none;"></div>
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
            <span aria-hidden="true" class="text-white">&times;
            </span>
            </button>
        </div>
        <div class="modal-body">
            <p>Hi are you sure you want to logout?
            </p>
        </div>
        <div class="modal-footer pb-1 pt-1">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
            </button>
            <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout
            </a>
        </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="modal_approval" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" id="approval_modal_content"></div>
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

    <?php
    function convert_data($array, $id)
    {
    $name = "";
    foreach ($array as $row) {
        if ($row->id == $id) {
        $lastnameSuffix = $row->col_last_name;
        if ($row->col_suffix) {
            $lastnameSuffix  = $lastnameSuffix . ' ' . $row->col_suffix;
        }
        $name = $lastnameSuffix . ', ' . $row->col_frst_name;
        if ($row->col_midl_name) {
            $name = $name . ' ' . $row->col_midl_name[0] . '.';
        }
        }
    }
    return $name;
    }
    function convert_img($array, $id)
    {
    $img = "";
    foreach ($array as $row) {
        if ($row->id == $id) {
        $img = $row->col_imag_path;
        }
    }
    return $img;
    }
    function convert_cmid($array, $id)
    {
    $cmid = "";
    foreach ($array as $row) {
        if ($row->id == $id) {
        $cmid = $row->col_empl_cmid;
        }
    }
    return $cmid;
    }
    function convert_type($array, $id)
    {
    $type = "";
    foreach ($array as $row) {
        if ($row->id == $id) {
        $type = $row->name;
        }
    }
    return $type;
    }
    function check_status($array, $status, $id, $empl_id)
    {
    $stat = 'disabled';
    if ($array == null) {
        return $stat = 'disabled';
    }
    foreach ($array as $row) {
        if ($row->empl_id == $id) {
        if ($status == "Pending 1") {
            if ($empl_id == $row->approver_1a || $empl_id == $row->approver_1b) {
            $stat = '';
            }
        }
        if ($status == "Pending 2") {
            if ($empl_id == $row->approver_2a || $empl_id == $row->approver_2b) {
            $stat = '';
            }
        }
        if ($status == "Pending 3") {
            if ($empl_id == $row->approver_3a || $empl_id == $row->approver_3b) {
            $stat = '';
            }
        }
        }
    }
    return $stat;
    }
    function checkbox_status($array, $status, $id, $empl_id)
    {
    $stat = '';
    foreach ($array as $row) {
        if ($row->empl_id == $id) {
        if ($status == "Pending 1") {
            if ($empl_id == $row->approver_1a || $empl_id == $row->approver_1b) {
            $stat = 'true';
            } else {
            $stat = 'false';
            }
        }
        if ($status == "Pending 2") {
            if ($empl_id == $row->approver_2a || $empl_id == $row->approver_2b) {
            $stat = 'true';
            } else {
            $stat = 'false';
            }
        }
        if ($status == "Pending 3") {
            if ($empl_id == $row->approver_3a || $empl_id == $row->approver_3b) {
            $stat = 'true';
            } else {
            $stat = 'false';
            }
        }
        }
    }
    return $stat;
    }
    ?>

    <script>
    // onerror="setDefaultImage(this)"
    function setDefaultImage(img) {
        img.src = "<?= base_url() ?>/assets_system/images/default_user.jpg";
        img.alt = 'Default Image';
    }
    </script>

    <script>
    var DISP_SHIFT = <?php echo json_encode($DISP_SHIFT); ?>;
    // console.log('DISP_SHIFT');
    $(document).ready(function() {

        $('#filter_by_company').select2();
        $('#filter_by_branch').select2();
        $('#filter_by_department').select2();
        $('#filter_by_division').select2();
        $('#filter_by_section').select2();
        $('#filter_by_group').select2();
        $('#filter_by_team').select2();
        $('#filter_by_line').select2();

        $('#modal_approval').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        var id = button.data('leave_id');
        $.get("<?= base_url('selfservices/get_leave_approval') ?>" + '/' + id, function(res) {
            // $('#approval_modal_content').html(res)
        })

        });

        $('#row_dropdown').on('change', function(e) {
        e.preventDefault()
        var row_val = $(this).val();
        let data = "?page=1&row=" + row_val;

        filter_data(data);
        });

        $("#filter_by_company").on("change", function() {
        filter_data();
        })
        $("#filter_by_branch").on("change", function() {
        filter_data();
        })
        $("#filter_by_department").on("change", function() {
        filter_data();
        })
        $("#filter_by_division").on("change", function() {
        filter_data();
        })
        $("#filter_by_section").on("change", function() {
        filter_data();
        })
        $('#filter_by_group').on("change", function() {
        filter_data();
        })
        $("#filter_by_team").on("change", function() {
        filter_data();
        })
        $("#filter_by_line").on("change", function() {
        filter_data();
        })

        function filter_data(page_row) {
        let base_url = '<?= base_url(); ?>';
        if (page_row == null || page_row == "") {
            page_row = '?page=' + "<?= $current_page ?>" + '&row=' + "<?= $row ?>"
        }
        let cut_off = $("#cutoff_period").find(":selected").val();
        let company = $("#filter_by_company").find(":selected").val();
        let branch = $("#filter_by_branch").find(":selected").val();
        let department = $("#filter_by_department").find(":selected").val();
        let division = $("#filter_by_division").find(":selected").val();
        let section = $("#filter_by_section").find(":selected").val();
        let group = $("#filter_by_group").find(":selected").val();
        let team = $("#filter_by_team").find(":selected").val();
        let line = $("#filter_by_line").find(":selected").val();

        // let status = $("#filter_by_status").find(":selected").val();
        let filterUrl = '&company=' + company + '&branch=' + branch + '&department=' + department + '&division=' + division + '&section=' + section + '&group=' + group + '&team=' + team + '&line=' + line;
        if (document.querySelector('.filter-container').classList.contains('visible')) {
            filterUrl = filterUrl + '&filter=1';
        }

        window.location = base_url + "selfservices/leave_approval" + page_row + filterUrl;
        }

        $('button.filter').on('click', function(e) {
        let select_employee = $('select.filter').val()
        window.location.href = '?employee=' + select_employee
        })
        $('#bulk_approved').click(function() {
        let selected_id = [];
        let selected_att_id = [];
        let selected_empl_id = [];
        let selected_row_id = [];
        $('#APPROVAL_ID').empty();
        $('#approve_list_id').empty();
        $('#select_item input[type=checkbox]:checked').each(function() {
            let selected_item = $(this).val();
            let att_approval_id = $(this).attr('approval_id');
            let att_empl_id = $(this).attr('employee_id');
            let att_row_id = $(this).attr('row_id');
            selected_id.push(selected_item);
            selected_att_id.push(att_approval_id);
            selected_empl_id.push(att_empl_id);
            selected_row_id.push(att_row_id);
        })
        if (selected_id.length > 0) {
            $('.class_modal_approve').prop('id', 'modal_bulk_approved');
            let approval_ids = selected_id.join(',');
            let empl_ids = selected_empl_id.join(',');
            let row_ids = selected_row_id.join(',');
            $('#APPROVE_ID').val(row_ids);
            $('#APPROVAL_ID').val(approval_ids);
            $('#EMPLOYEE_ID').val(empl_ids);
            selected_row_id.forEach(function(data) {
            $('#approve_list_id').append(`<li class="col-md-6">ID : <strong>LEA00${data}</strong></li>`);
            })
        } else {
            $('.class_modal_approve').prop('id', '');

            $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: 'Please Select Employee!',
            })
        }
        })
        $('#bulk_reject').click(function() {
        let selected_id = [];
        let selected_att_id = [];
        let selected_empl_id = [];
        let selected_row_id = [];
        $('#APPROVAL_ID').empty();
        $('#reject_list_id').empty();
        $('#select_item input[type=checkbox]:checked').each(function() {
            let selected_item = $(this).val();
            let att_approval_id = $(this).attr('approval_id');
            let att_empl_id = $(this).attr('employee_id');
            let att_row_id = $(this).attr('row_id');
            selected_id.push(selected_item);
            selected_att_id.push(att_approval_id);
            selected_empl_id.push(att_empl_id);
            selected_row_id.push(att_row_id);
        })
        if (selected_id.length > 0) {
            $('.class_modal_reject').prop('id', 'modal_bulk_reject');
            let approval_ids = selected_id.join(',');
            let empl_ids = selected_empl_id.join(',');
            let row_ids = selected_row_id.join(',');
            $('#REJECTED_ID').val(row_ids);
            $('#REJECT_EMPLOYEE_ID').val(empl_ids);
            selected_row_id.forEach(function(data) {
            $('#reject_list_id').append(`<li class="col-md-6">ID : <strong>LEA00${data}</strong></li>`);
            })
        } else {
            $('.class_modal_reject').prop('id', '');

            $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: 'Please Select Employee!',
            })
        }
        })
        $('td.select-item-td').on('click', function(event) {
        event.stopPropagation();
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
        $('#submit_bulk_approve').click(function() {
        $('#form_bulk_approve').submit();
        })
        $('#submit_bulk_reject').click(function() {
        $('#form_bulk_reject').submit();
        })
        $("#search_btn").on("click", function() {
        $('#search_data').val();
        var optionValue = $('#search_data').val();
        var url = window.location.href.split("?")[0];
        if (window.location.href.indexOf("?") > 0) {
            window.location = url + "?page=1&all=" + optionValue.replace(/\s/g, '_');
        } else {
            window.location = url + "?page=1&all=" + optionValue.replace(/\s/g, '_');
        }
        })
        $(document).on('click', '.reject_btn', function() {
        $('#modal_approval').modal('hide');
        var reject_key = $(this).attr('reject_key');
        Swal.fire({
            icon: 'warning',
            input: "textarea",
            inputLabel: "Add Reason",
            inputPlaceholder: "Type your message here...",
            inputAttributes: {
            "aria-label": "Type your message here"
            },
            showCancelButton: true,
            inputValidator: (value) => {
            if (!value) {
                return "You need to write something!";
            }
            },
            preConfirm: async (e) => {
            await $('input#remarks_reject').val(e);
            },
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Reject'
        }).then((result) => {
            if (result.isConfirmed) {

            $('#form_reject').submit();
            }
        })
        })
        $(document).on('click', '.approve_btn', function() {
        $('#modal_approval').modal('hide');
        var approved_id = $(this).attr('approved_id');
        Swal.fire({
            title: 'Confirmation',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Approve'
        }).then((result) => {
            if (result.isConfirmed) {
            $('#form_approved').submit();
            }
        })
        })
        $('.request_id').on('click', function() {
        let url = $(this).attr('href');
        fetch(url)
            .then((res) => res.json())
            .then((data) => {
            // console.log(data);

            $('#leave_type').val(data['type']);
            $('#empl_id').val('LEA00' + data[0]['id']);
            $('#request_by').val(data['name']);
            $('#leave_date').val(data['leave_date']);
            $('#leave_duration').val(data[0]['duration']);
            $('#status').val(data[0]['status']);
            $('#remarks').val(data[0]['remarks']);
            $('#attachment').val(data[0]['attachment']);
            })
        })


        var baseUrl = '<?= base_url() . 'assets_user/files/selfservices/' ?>';
        $('#download-link').click(function(e) {

        e.preventDefault();
        var fileName = $(this).siblings('input').val();

        var link = document.createElement('a');
        link.href = baseUrl + fileName;
        link.download = fileName;
        link.click();
        });

        var baseUrl = '<?= base_url() ?>';
        let companyHide = false;
        var companySettings = <?php echo json_encode($DISP_VIEW_COMPANY); ?>;
        var companySettingsNumber = parseInt(companySettings);
        if (!isNaN(companySettingsNumber) && companySettingsNumber < 1) companyHide = true;
        let branchHide = false;
        var branchSettings = <?php echo json_encode($DISP_VIEW_BRANCH); ?>;
        var branchSettingsNumber = parseInt(branchSettings);
        if (!isNaN(branchSettingsNumber) && branchSettingsNumber < 1) branchHide = true;
        let departmentHide = false;
        var departmentSettings = <?php echo json_encode($DISP_VIEW_DEPARTMENT); ?>;
        var departmentSettingsNumber = parseInt(departmentSettings);
        if (!isNaN(departmentSettingsNumber) && departmentSettingsNumber < 1) departmentHide = true;
        $('.td-directs').on('click', function(e) {
        e.stopPropagation();
        let employee_id = $(this).data('empl_id')
        directs(employee_id)
        })
        const directs = async (employeeId) => {
        document.getElementById("modalLoading").style.display = "block";
        $('#modalDirects').modal('show');
        const apiUrl = baseUrl + 'selfservices/get_reporting_to_directives';
        const data = {
            employeeId
        };
        // console.log('data', data);
        fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
            // console.log('result', result)
            document.getElementById("modalLoading").style.display = "none";
            let employeeImage = `${baseUrl}/assets_user/user_profile/${result.data.employeeInfo?.col_imag_path}`;
            if (!result.data.employeeInfo?.col_imag_path) employeeImage = `${baseUrl}/assets_system/images/default_user.jpg`;
            document.getElementById('employee_img').src = employeeImage;

            let employeeLastNameSuffix = result.data.employeeInfo?.col_last_name;
            if (result.data.employeeInfo?.col_suffix) employeeLastNameSuffix = `${result.data.employeeInfo?.col_last_name} ${result.data.employeeInfo?.col_suffix}`;
            let employeeFullName = employeeLastNameSuffix;
            if (result.data.employeeInfo?.col_frst_name) employeeFullName = `${employeeFullName}, ${result.data.employeeInfo?.col_frst_name}`;
            if (result.data.employeeInfo?.col_midl_name) employeeFullName = `${employeeFullName} ${result.data.employeeInfo?.col_midl_name.charAt(0)}.`;
            if (employeeFullName) {
                document.getElementById("employeeFullName").textContent = employeeFullName;
            } else {
                document.getElementById("employeeFullName").textContent = '(No Full Name)'
            }
            if (result.data.employeeInfo?.col_empl_cmid) {
                document.getElementById("employeeNumber").textContent = `${result.data.employeeInfo.col_empl_cmid}`;
            } else {
                document.getElementById("employeeNumber").textContent = '(No Employee Number)'
            }
            if (result.data.employeeInfo?.col_empl_posi) {
                document.getElementById("employeePosition").textContent = `${result.data.employeeInfo.col_empl_posi}`;
            } else {
                document.getElementById("employeePosition").textContent = '(No Position)'
            }
            if (result.data.employeeInfo?.col_empl_company) {
                document.getElementById("employeeCompany").textContent = `${result.data.employeeInfo.col_empl_company}`;
            } else {
                document.getElementById("employeeCompany").textContent = '(No Company)'
            }
            if (companyHide) document.getElementById("employeeCompany").style.display = 'none';
            branch = result.data.employeeInfo?.col_empl_branch;
            inBetween = ` \\ `;
            department = result.data.employeeInfo?.col_empl_dept;
            if (!branch || branchHide) branch = '';
            if (!department || departmentHide) department = '';
            if (branchHide || departmentHide || !branch || !department) inBetween = '';
            if (branch || department) {
                document.getElementById("employeeBranchDepartment").textContent = `${branch}${inBetween}${department}`;
            } else {
                if (branchHide && !departmentHide) {
                document.getElementById("employeeBranchDepartment").textContent = '(No Department)';
                } else if (departmentHide && !branchHide) {
                document.getElementById("employeeBranchDepartment").textContent = '(No Branch)';
                } else if (!branchHide && !departmentHide) {
                document.getElementById("employeeBranchDepartment").textContent = '(No Branch / No Department)';
                } else {
                document.getElementById("employeeBranchDepartment").textContent = ''
                }
            }
            if (result.data.employeeInfo?.col_comp_emai) {
                document.getElementById("employeeEmail").textContent = `${result.data.employeeInfo.col_comp_emai}`;
            } else {
                document.getElementById("employeeEmail").textContent = '(No Email)'
            }

            let reportingToLastNameSuffix = result.data.reportingTo?.col_last_name;
            // console.log('result.data.reportingTo',result.data.reportingTo)
            if (result.data.reportingTo?.col_suffix) reportingToLastNameSuffix = `${reportingToLastNameSuffix} ${result.data.reportingTo?.col_suffix}`;
            // console.log('reportingToLastNameSuffix',reportingToLastNameSuffix)
            let reportingToFullName = reportingToLastNameSuffix;
            if (result.data.reportingTo?.col_frst_name) reportingToFullName = `${reportingToFullName}, ${result.data.reportingTo?.col_frst_name}`;
            if (result.data.reportingTo?.col_midl_name) reportingToFullName = `${reportingToFullName} ${result.data.reportingTo?.col_midl_name?.charAt(0)}.`;
            let reportingToImage = "<?= base_url() ?>/assets_system/images/default_user.jpg";
            if (result.data.reportingTo?.col_imag_path)
                reportingToImage = `${baseUrl}/assets_user/user_profile/${result.data.reportingTo.col_imag_path}`;
            if (reportingToFullName) {
                document.getElementById("reportingToContainer").textContent = "";
                document.getElementById("reportingToContainer").innerHTML =
                `<img class="img-circle rounded-circle avatar elevation-2" onerror="setDefaultImage(this)"
                style="cursor: pointer;width:50px !important;height:50px !important" data-toggle="tooltip" 
                data-placement="right" title="Reporting To" 
                src="${reportingToImage}">
            <div class="mx-2">
                <p class="p-0 m-0" style="line-height: 1;font: size 13px;font-weight:500;">${reportingToFullName}</p>
            </div>`;
            } else {
                document.getElementById("reportingToContainer").innerHTML = '(No Redirect To)'
            }
            var directsParent = document.getElementById("directsParent");

            // console.log('directs condition', Array.isArray(result.data.directsTo) && result.data.directsTo.length > 0)
            if (Array.isArray(result.data.directsTo) && result.data.directsTo.length > 0) {
                directsParent.innerHTML = '';
                result.data.directsTo.forEach(function(user) {

                let directMiddleInitial = `${user.col_midl_name.charAt(0)}.`
                if (!directMiddleInitial) directMiddleInitial = null;
                directLastNameSuffix = user.col_last_name;
                if (user.col_suffix) directLastNameSuffix = `${directLastNameSuffix} ${user.col_suffix}`;
                let directFullName = directLastNameSuffix;
                if (user.col_frst_name) directFullName = `${directFullName}, ${user.col_frst_name}`;
                if (user.col_midl_name) directFullName = `${directFullName} ${user.col_midl_name.charAt(0)}.`;
                let directImage = `${baseUrl}/assets_system/images/default_user.jpg`;
                if (result.data.directsTo[0].col_imag_path) {
                    directImage = `${baseUrl}/assets_user/user_profile/${user.col_imag_path}`;
                }
                var div = document.createElement("div");
                div.className = "d-flex align-items-center";
                div.innerHTML = `
                <div  class="d-flex align-items-center mb-2">
                <img class="img-circle rounded-circle avatar elevation-2" onerror="setDefaultImage(this)"
                    id="directsToPhoto" style="cursor: pointer;width:50px !important;height:50px !important" 
                    data-toggle="tooltip" data-placement="right" title="Reporting To" 
                    src="${directImage}">
                <div class="mx-2">
                    <p id="direcstToName" class="p-0 m-0" style="line-height: 1;font: size 13px;">${directFullName}</p>
                </div>
                </div>
                `;
                directsParent.appendChild(div);
                });
            } else {
                directsParent.innerHTML = '(No Directs)';
            }
            if (result.errorMessage) {
                $(document).Toasts('create', {
                class: 'bg-warning toast_width',
                title: 'Warning!',
                subtitle: 'close',
                body: 'Unexpected Error Occured Fetching Data'
                })
            }
            })
            .catch(error => {
            document.getElementById("modalLoading").style.display = "none";
            $(document).Toasts('create', {
                class: 'bg-warning toast_width',
                title: 'Warning!',
                subtitle: 'close',
                body: 'Unexpected Error Occured Fetching Data..'
            })
            console.error('Data update error:', error);
            });

        }
    })
    </script>

    <!-- Advance filter -->
    <script>
    function toggleFilter() {
        document.querySelector('.filter-container').classList.toggle('visible');
    }
    </script>

    </body>

</html>