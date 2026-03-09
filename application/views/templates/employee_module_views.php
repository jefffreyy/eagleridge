<html>
<?php $this->load->view('templates/css_link'); ?>
<style>
</style>
<?php
$url_count          = $this->uri->total_segments();
$url_directory      = $this->uri->segment($url_count);
function technos_encrypt($input){
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = '6234564891013126';
    $encryption_key = "Technos";
    $result_raw = openssl_encrypt($input, $ciphering,$encryption_key, $options, $encryption_iv);
    $result = str_replace("/", "&", $result_raw);
    return $result;
}
?>
<html>
<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= $module[0] ?>"><?= $module[1] ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $module[2] ?>
                    </li>
                </ol>
            </nav>
            <div class="row pt-1">
                <div class="col-md-6">
                    <h1 class="page-title"><?= $module[2] ?><h1>
                </div>
                <?php 

                $module_title      = $module[1];
                $page_title        = $module[2];
                $url_add_params    = $table_name."-".$module_name."-".$page_name."-".$module_title."-".$page_title;
                $url_add_design    = http_build_query($C_DB_DESIGN);
                $url_users     = http_build_query($C_DATA_EMPL_NAME);
                if(isset($C_ARRAY_1) ){$url_array1 = http_build_query($C_ARRAY_1);}else{$url_array1 = "X";}
                if(isset($C_ARRAY_2) ){$url_array2 = http_build_query($C_ARRAY_2);}else{$url_array2 = "X";}
                if(isset($C_ARRAY_3)){$url_array3 = http_build_query($C_ARRAY_3);}else{$url_array3 = "X";}
                if(isset($C_ARRAY_4)){$url_array4 = http_build_query($C_ARRAY_4);}else{$url_array4 = "X";}
                if(isset($C_ARRAY_5)){$url_array5 = http_build_query($C_ARRAY_5);}else{$url_array5 = "X";}
                
                $url_add_combined  = $url_add_params .".". $url_add_design.".". $url_users .".". $url_array1 .".". $url_array2.".". $url_array3.".". $url_array4.".". $url_array5;
                $url_add_encrypted = technos_encrypt($url_add_combined);

                $url_csv_params    = $table_name."-".$module_name."-".$page_name."-".$module_title."-".$page_title;
                $url_csv_encrypted = technos_encrypt($url_csv_params);
        
                ?>
                <div class="col-md-6 button-title">
                    <a href="<?php echo base_url('main_table_02/add_data?'.$url_add_encrypted);?>" id="btn_application"     class=" btn technos-button-green shadow-none rounded" <?php if (!$add_button[0])  echo "hidden"; ?>><i class="fas fa-plus"></i>&nbsp;<?= $add_button[1] ?></a>
                    <a href="<?php echo base_url('main_table_02/csv_import?'.$url_csv_encrypted);?>" id="bulk_import"     class=" btn technos-button-green shadow-none rounded" <?php if (!$excel_import[0])  echo "hidden"; ?>><i class="fas fa-file-import"></i>&nbsp;Bulk Import</a>
                    <a id="export_xlsx"          class=" btn technos-button-gray shadow-none rounded" <?php if (!$excel_output[0])  echo "hidden"; ?>><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a>
                </div>
            </div>
            <hr>
            <div class = "pb-1">    
                <?php
                    if(isset($_GET['row'])){
                        $row = $_GET['row'];
                    }
                    else{
                        $row = $default_row;
                    }
                    if(isset($_GET['tab'])){
                        $tab = $_GET['tab'];
                    }
                    else{
                        $tab = $C_TAB_SELECT;
                    }
                    if(isset($_GET['page'])){
                        $current_page = $_GET['page'];
                    }
                    else{$current_page = 1;  }
                    $prev_page = $current_page - 1;
                    $next_page = $current_page + 1;
                    $last_page = intval($C_DATA_COUNT/$row) + 1;
                    if($C_DATA_COUNT == 0){
                        $low_limit = 0;
                    }
                    else{
                        $low_limit = $row*($current_page - 1) + 1;
                    }
                    if($current_page*$row > $C_DATA_COUNT){
                        $high_limit = $C_DATA_COUNT;
                    }
                    else{
                        $high_limit = $row*($current_page);
                    }
                ?>
            </div>
            <?php 
                (isset($_GET['dept']) ? $dept = $_GET['dept'] : $dept = "");
                (isset($_GET['sec']) ? $sec = $_GET['sec'] : $sec = "");
                (isset($_GET['group']) ? $group = $_GET['group'] : $group = "");
                (isset($_GET['line']) ? $line = $_GET['line'] : $line = "");
                (isset($_GET['team']) ? $team = $_GET['team'] : $team = "");
                (isset($_GET['division']) ? $division = $_GET['division'] : $division = "");
                (isset($_GET['branch']) ? $branch = $_GET['branch'] : $branch = "");
                (isset($_GET['status']) ? $status = $_GET['status'] : $status = "");
                (isset($_GET['all']) ? $all = $_GET['all'] : $all = "");
            ?>

            <!-- filter -->
            <div class="row mb-4">
                <div class="col-md-2 "  <?php echo($DISP_VIEW_DEPARTMENT ? "" :"hidden") ?>>
                    <p class="mb-1 text-secondary ">Department</p>
                    <select id="filter_by_department" class="form-control">
                        <?php
                        if ($C_DEPARTMENTS) {
                        ?>
                            <option value="" <?php foreach ($C_DEPARTMENTS as $DISP_DISTINCT_DEPARTMENT_ROW_1) {
                                                    if ($DISP_DISTINCT_DEPARTMENT_ROW_1->name == '') {
                                                        echo 'selected';
                                                    }
                                                } ?>>All Departments</option>
                            <?php
                            foreach ($C_DEPARTMENTS as $DISP_DISTINCT_DEPARTMENT_ROW) {
                                if ($DISP_DISTINCT_DEPARTMENT_ROW->name != '') {
                            ?>
                                    <option value="<?= $DISP_DISTINCT_DEPARTMENT_ROW->id ?>"   <?= ($DISP_DISTINCT_DEPARTMENT_ROW->id == $dept) ?  "selected" : ''; ?>  ><?=  $DISP_DISTINCT_DEPARTMENT_ROW->name ?></option>
                        <?php
                                }
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-2 " <?php echo($DISP_VIEW_SECTION ? "" :"hidden") ?>>
                    <p class="mb-1 text-secondary ">Section</p>
                    <select id="filter_by_section" class="form-control">
                        <?php
                        if ($C_SECTIONS) {
                        ?>
                            <option value="" <?php foreach ($C_SECTIONS as $DISP_DISTINCT_SECTION_ROW_1) {
                                                    if ($DISP_DISTINCT_SECTION_ROW_1->name == '') {
                                                        echo 'selected';
                                                    }
                                                } ?>>All Sections</option>
                            <?php
                            foreach ($C_SECTIONS as $DISP_DISTINCT_SECTION_ROW) {
                                if ($DISP_DISTINCT_SECTION_ROW->name != '') {
                            ?>
                                    <option value="<?= $DISP_DISTINCT_SECTION_ROW->id ?>"  <?= ($DISP_DISTINCT_SECTION_ROW->id == $sec) ?  "selected" : ''; ?>  ><?= $DISP_DISTINCT_SECTION_ROW->name ?></option>
                        <?php
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2 "  <?php echo($DISP_VIEW_GROUP ? "" :"hidden") ?>>
                    <p class="mb-1 text-secondary ">Group</p>
                    <select id="filter_by_group" class="form-control">
                        <?php
                        if ($C_GROUPS) {
                        ?>
                            <option value="" <?php foreach ($C_GROUPS as $DISP_Group_ROW_1) {
                                                    if ($DISP_Group_ROW_1->name == '') {
                                                        echo 'selected';
                                                    }
                                                } ?>>All Groups</option>
                            <?php
                            foreach ($C_GROUPS as $DISP_Group_ROW) {
                                if ($DISP_Group_ROW->name != '') {
                            ?>
                                    <option value="<?= $DISP_Group_ROW->id ?>" <?= ($DISP_Group_ROW->id == $group) ? 'Selected' : "";?>  ><?= $DISP_Group_ROW->name ?></option>
                        <?php
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2 " <?php echo($DISP_VIEW_LINE ? "" :"hidden") ?>>
                    <p class="mb-1 text-secondary ">Line</p>
                    <select id="filter_by_line" class="form-control">
                        <?php
                        if ($C_LINES) {
                        ?>
                            <option value="" <?php foreach ($C_LINES as $DISP_Line_ROW_1) {
                                                    if ($DISP_Line_ROW_1->name == '') {
                                                        echo 'selected';
                                                    }
                                                } ?>>All Lines</option>
                            <?php
                            foreach ($C_LINES as $DISP_Line_ROW) {
                                if ($DISP_Line_ROW->name != '') {
                            ?>
                                    <option value="<?= $DISP_Line_ROW->id ?>" <?= ($DISP_Line_ROW->id == $line) ? 'Selected' : ''; ?>><?= $DISP_Line_ROW->name ?></option>
                        <?php
                                }
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-2 " <?php echo($DISP_VIEW_TEAM ? "" :"hidden") ?>>
                <p class="mb-1 text-secondary ">Team</p>
                    <select id="filter_by_team" class="form-control">
                        <?php
                        if ($C_TEAMS) {
                        ?>
                            <option value="" <?php foreach ($C_TEAMS as $C_TEAMS_ROW_1) {
                                                    if ($C_TEAMS_ROW_1->name == '') {
                                                        echo 'selected';
                                                    }
                                                } ?>>All Team</option>
                            <?php
                            foreach ($C_TEAMS as $C_TEAMS_ROW) {
                                if ($C_TEAMS_ROW->name != '') {
                            ?>
                                    <option value="<?= $C_TEAMS_ROW->id ?>" <?= ($C_TEAMS_ROW->id == $team) ? 'Selected' : ''; ?>><?= $C_TEAMS_ROW->name ?></option>
                        <?php
                                }
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-2 " <?php echo($DISP_VIEW_TEAM ? "" :"hidden") ?>>
                <p class="mb-1 text-secondary ">Division</p>
                    <select id="filter_by_division" class="form-control">
                        <?php
                        if ($C_DIVISIONS) {
                        ?>
                            <option value="" <?php foreach ($C_DIVISIONS as $C_DIVISIONS_ROW_1) {
                                                    if ($C_DIVISIONS_ROW_1->name == '') {
                                                        echo 'selected';
                                                    }
                                                } ?>>All Division</option>
                            <?php
                            foreach ($C_DIVISIONS as $C_DIVISIONS_ROW) {
                                if ($C_DIVISIONS_ROW->name != '') {
                            ?>
                                    <option value="<?= $C_DIVISIONS_ROW->id ?>" <?= ($C_DIVISIONS_ROW->id == $division) ? 'Selected' : ''; ?>><?= $C_DIVISIONS_ROW->name ?></option>
                        <?php
                                }
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-2 " <?php echo($DISP_VIEW_TEAM ? "" :"hidden") ?>>
                <p class="mb-1 text-secondary ">Branch</p>
                    <select id="filter_by_branch" class="form-control">
                        <?php
                        if ($C_BRANCH) {
                        ?>
                            <option value="" <?php foreach ($C_BRANCH as $C_BRANCH_ROW_1) {
                                                    if ($C_BRANCH_ROW_1->name == '') {
                                                        echo 'selected';
                                                    }
                                                } ?>>All Branch</option>
                            <?php
                            foreach ($C_BRANCH as $C_BRANCH_ROW) {
                                if ($C_BRANCH_ROW->name != '') {
                            ?>
                                    <option value="<?= $C_BRANCH_ROW->id ?>" <?= ($C_BRANCH_ROW->id == $branch) ? 'Selected' : ''; ?>><?= $C_BRANCH_ROW->name ?></option>
                        <?php
                                }
                            }
                        }
                        ?>
                    </select>
                </div>

                

                <div class="col-md-2">
                    <p class="mb-1 text-secondary ">Status</p>
                    <select id="filter_by_status" class="form-control">
                        <option value="">All Status</option>
                        <option value="0" <?= ($status == '0') ? 'Selected' : ''; ?> >Active</option>
                        <option value="1" <?= ($status == '1') ? 'Selected' : ''; ?> >Inactive</option>
                    </select>
                </div>
                <!-- <div class="col-md-2">
                    <br>
                    <a href="#" id="btn_clear_filter" class="btn btn-primary float-right">Clear Filter</a>
                </div> -->

                <div class="col-md-2">
                    <p class="mb-1 text-secondary ">Action</p>
                    <a href="#" id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
                </div>
            </div>

            <div class="card border-0 p-0 m-0">
                <div class = "p-1">
                    <div class="card-header p-0">
                        <ul class="nav nav-tabs">
                            <?php
                            foreach ($C_DATA_TAB as $C_DATA_TAB_ROW) {?>
                                <li class="nav-item">
                                    <a class="nav-link head-tab <?php echo($C_DATA_TAB_ROW[0] == $tab) ? ' active' : ''; ?>" id="tab-<?= $C_DATA_TAB_ROW[0]?>" href="?page=1&row=<?=$row?>&tab=<?= $C_DATA_TAB_ROW[0]?>&tab_filter=<?= $C_DATA_TAB_ROW[1]?>" ><?= $C_DATA_TAB_ROW[0] ?><span class="ml-2 badge badge-pill badge-secondary"><?= $C_DATA_TAB_ROW[3] ?></span></a>
                                </li>
                            <?php
                            } ?>                
                        </ul>
                    </div>
                <div class="col-md-4 pl-0">
                    <div class ="input-group p-1 pt-2">
                        <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"   <?php if (!$add_button[0])  echo "hidden"; ?>><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
                        <input type="text" class="form-control" placeholder="Search" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>
            <div class="card border-0 p-0 m-0">
                <div class = "p-2">
                  <div>
                    <?php
                    foreach ($C_BULK_BUTTON as $C_BULK_BUTTON_ROW) {?>
                        <button id=<?=$C_BULK_BUTTON_ROW[1]?> class="btn technos-button-gray shadow-none rounded bulk-button" data-toggle="modal"  data-id=<?= $C_BULK_BUTTON_ROW[5] ?> data-target="#modal_set_ssa" <?php if (!$C_BULK_BUTTON_ROW[0])  echo "hidden"; ?> status = <?= $C_BULK_BUTTON_ROW[3] ?>><i class="<?=$C_BULK_BUTTON_ROW[2]?>"></i>&nbsp;<?= $C_BULK_BUTTON_ROW[3] ?></button>
                    <?php
                    } ?>  
                    <!-- <button id="btn_application"    class=" btn technos-button-gray shadow-none rounded" data-toggle="modal" data-target="#modal_insert"  <?php if (!$add_button[0])  echo "hidden"; ?>><i class="far fa-trash-alt"></i>&nbsp;Delete</button> -->
                    <div class="float-right ">
                        <p class ="p-0 m-0 d-inline" style = "color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT?> entries&nbsp;</p>
                        <ul class="d-inline pagination m-0 p-0 ">
                            <li><a                                          <?php if ($current_page > 1)                echo "href='?page=$prev_page&row=$row&tab=$tab'"; ?>><                        </a></li>
                            <li><a href = "?page=1&row=<?=$row?>&tab=<?=$tab?>"                         <?php if ($current_page == 1)               echo "hidden";                  ?>>1                        </a></li>
                            <li><a                                          <?php if ($current_page <= 2)               echo "hidden";                  ?>>...                      </a></li>
                            <li><a href = "?page=<?= $current_page - 1?>&row=<?=$row?>&tab=<?=$tab?>"   <?php if ($current_page <= 2)               echo "hidden";                  ?>><?= $prev_page?>         </a></li>
                            <li><a style = "color:white ; background-color:#007bff !important"                                                               ><?= $current_page ?>     </a></li>
                            <li><a href = "?page=<?= $current_page + 1?>&row=<?=$row?>&tab=<?=$tab?>"   <?php if ($current_page >= $last_page - 1)  echo "hidden";                  ?>><?= $next_page?>         </a></li>
                            <li><a                                          <?php if ($current_page >= $last_page - 1)  echo "hidden";                  ?>>...                      </a></li>
                            <li><a href = "?page=<?= $last_page?>&row=<?=$row?>&tab=<?=$tab?>"          <?php if ($current_page == $last_page)      echo "hidden";                  ?>><?= $last_page?>         </a></li>
                            <li><a                style="margin-right: 10px;"                          <?php if ($current_page < $last_page)       echo "href='?page=$next_page&row=$row&tab=$tab'"; ?>>>                        </a></li>
                        </ul>
                        <p class ="p-0 m-0 d-inline" style = "color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                        <select id = "row_dropdown d-inline" class="custom-select" style="width: auto;">
                        <?php
                            foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) {?>
                                <option value=<?= $C_ROW_DISPLAY_ROW?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW?> </option>
                            <?php
                        } ?>
                        </select>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered m-0" id="table_main" style="width:100%">
                        <thead>
                            
                            <th class="text-center" style="width:5%" <?php if(empty($C_BULK_BUTTON)){ echo("hidden"); } ?>><input type="checkbox" name="check_all" id="check_all" ></th>
                            <?php
                            foreach ($C_DB_DESIGN as $C_DB_DESIGN_ROW) {
                                $label          = $C_DB_DESIGN_ROW[1];
                                $table_display  = $C_DB_DESIGN_ROW[4];
                                $table_width    = $C_DB_DESIGN_ROW[5];

                                if($table_display == 1) {?>
                                <th style='width:<?= $table_width ?>%;text-align: center;'><?= $label ?></th>
                            <?php
                            }
                            } ?>     
                            <th style="width:15%" class="text-center" >Action</th>
                        </thead>
                        <tbody id="tbl_application_container">
                            <?php
                            if ($C_DATA_TABLE) {
                                foreach ($C_DATA_TABLE as $C_DATA_TABLE_ROW) {
                                    $id_raw         = $C_DATA_TABLE_ROW->id;
                                    ?>
                                    <tr>
                                        <td class="text-center" id="select_item" <?php if(empty($C_BULK_BUTTON)){ echo("hidden"); } ?>>
                                            <input type="checkbox" name="brand" class="check_single" row_id="<?= $id_raw ?>" >
                                        </td>
                                    <?php
                                    foreach ($C_DB_DESIGN as $C_DB_DESIGN_ROW) {

                                        $column         = $C_DB_DESIGN_ROW[0];
                                        $label          = $C_DB_DESIGN_ROW[1];
                                        $parameter      = $C_DB_DESIGN_ROW[2];
                                        $setting        = $C_DB_DESIGN_ROW[3];
                                        $table_display  = $C_DB_DESIGN_ROW[4];
                                        $table_width    = $C_DB_DESIGN_ROW[5];
                                        $add_required   = $C_DB_DESIGN_ROW[6];
                                        $editable       = $C_DB_DESIGN_ROW[7];
                                        $show_views     = $C_DB_DESIGN_ROW[8];
                                 

                                        if($table_display == true) {
                                            $column_data_raw = $C_DATA_TABLE_ROW->$column;
                                            if($parameter == "id"){
                                                $column_data = $id_prefix . str_pad($column_data_raw ?? "", 5, '0', STR_PAD_LEFT);
                                            }
                                            else if($parameter == "date"){
                                                $column_data = date('j M Y', strtotime($column_data_raw));
                                            }
                                            else if($parameter == "fixed-sel-status"){
                                                if($column_data_raw == $status_text[0] ){
                                                    $status_badge = "badge-success";
                                                }else if($column_data_raw == $status_text[1] ){
                                                    $status_badge = "badge-warning";
                                                }else if($column_data_raw == $status_text[2] ){
                                                    $status_badge = "badge-danger";
                                                }else if($column_data_raw == $status_text[3] ){
                                                    $status_badge = "badge-secondary";
                                                }
                                                else{
                                                    $status_badge = "badge-light";
                                                }
                                                $column_data = $column_data_raw;
                                            }
                                            else if ($parameter == "user"){
                                                foreach ($C_DATA_EMPL_NAME as $C_DATA_EMPL_NAME_ROW){
                                                    if($column_data_raw == $C_DATA_EMPL_NAME_ROW->id){
                                                        $column_data = $C_DATA_EMPL_NAME_ROW->col_frst_name . " " . $C_DATA_EMPL_NAME_ROW->col_last_name;
                                                    }
                                                }
                                            }
                                        
                                            else if ($parameter == "db-sel"){


                                                if($setting == "array1"){ 
                                                    foreach ($C_ARRAY_1 as $C_ARRAY_ROW) {
                                                        if($column_data_raw == $C_ARRAY_ROW->id){
                                                            $column_data = $C_ARRAY_ROW->name;
                                                        }
                                                    }
                                                } 
                                                if($setting == "array2"){ 
                                                    foreach ($C_ARRAY_2 as $C_ARRAY_ROW) {
                                                        if($column_data_raw == $C_ARRAY_ROW->id){
                                                            $column_data = $C_ARRAY_ROW->name;
                                                        }
                                                    }
                                                } 
                                                if($setting == "array3"){ 
                                                    foreach ($C_ARRAY_3 as $C_ARRAY_ROW) {
                                                        if($column_data_raw == $C_ARRAY_ROW->id){
                                                            $column_data = $C_ARRAY_ROW->name;
                                                        }
                                                    }
                                                } 
                                                if($setting == "array4"){ 
                                                    foreach ($C_ARRAY_4 as $C_ARRAY_ROW) {
                                                        if($column_data_raw == $C_ARRAY_ROW->id){
                                                            $column_data = $C_ARRAY_ROW->name;
                                                        }
                                                    }
                                                } 
                                                if($setting == "array5"){ 
                                                    foreach ($C_ARRAY_5 as $C_ARRAY_ROW) {
                                                        if($column_data_raw == $C_ARRAY_ROW->id){
                                                            $column_data = $C_ARRAY_ROW->name;
                                                        }
                                                    }
                                                } 
                                               
                                            }
                                            else{
                                                $column_data =  $column_data_raw;
                                            }
                                            if($parameter != "status"){?>
                                                <td style="width:<?= $table_width?>%"><?= $column_data?></td>
                                            <?php }
                                            else{?>
                                                <td style="width:<?= $table_width?>%;text-align: center;">
                                                    <h5><span style = "width:100px;" class="badge <?= $status_badge ?>"><?= $column_data?></i></span></h5>
                                                </td>
                                            <?php
                                            }
                                            ?>
                                        <?php
                                        }
                                    }
                            ?>
                                    <?php 



                                    $url_edit_params    = $table_name."-".$id_prefix."-".$module_name."-".$page_name."-".$module_title."-".$page_title;
                                    $url_edit_data_raw      = http_build_query($C_DATA_TABLE_ROW);
                                    $url_edit_data      = str_replace(".", "*", $url_edit_data_raw);


                                    $url_edit_design    = http_build_query($C_DB_DESIGN);
                                    $url_edit_combined  = $url_edit_params . "." .$url_edit_data .".". $url_edit_design .".". $url_users .".". $url_array1 .".". $url_array2.".". $url_array3.".". $url_array4.".". $url_array5;
                                    $url_edit_encrypted = technos_encrypt($url_edit_combined);
                                    ?>
                                        <td style="width:15%" class="text-center">
                                            <a class = "select_row p-2"      href="<?php echo base_url('main_table_02/show_data?'.$url_edit_encrypted); ?>"  style ="color: gray; cursor: pointer; !important"  row_id="<?= $id_raw ?>"><i class="far fa-eye" id="view_button"></i></a>
                                            <a class = "select_edit_row p-2" href="<?php echo base_url('main_table_02/edit_data?'.$url_edit_encrypted); ?>"  style ="color: gray; cursor: pointer; !important" row_id="<?= $id_raw ?>"><i class="far fa-edit" id="edit_button"></i></a>
                                            <a class = "delete_data p-2 " style ="color: gray !important"  delete_key="<?=  $id_raw ?>"><i class="far fa-trash-alt" hidden></i></a>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } 
                            else {
                                ?>
                                <tr class="table-active">
                                    <td colspan="50">
                                        <center>No Data</center>
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
            <form action="<?php echo base_url('main_table_02/edit_bulk_status?page='.$current_page.'&row='.$row.'&tab='.$tab.'&table='.$table_name.'&module='.$module_name.'&page_name='.$page_name); ?>" method="post">
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
                    <input type="hidden" id="modal_title"  name="modal_title">
                    <input type="hidden" id="list_mark_ids" name="list_mark_ids">
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <?php $this->load->view('templates/jquery_link'); ?>
<?php
if ($this->session->userdata('delete')) {
?>
    <script>Swal.fire('<?php echo $this->session->userdata('delete'); ?>','','success')</script>
    <?php $this->session->unset_userdata('delete');
}
?>
<?php
if ($this->session->userdata('success')) {
?>
    <script>Swal.fire('<?php echo $this->session->userdata('success'); ?>','','success')</script>
<?php $this->session->unset_userdata('success');
}
?>
<?php
if ($this->session->userdata('error')) {
?>
    <script>Swal.fire('<?php echo $this->session->userdata('error'); ?>',
            '',
            'error'
        )
    </script>
<?php
    $this->session->unset_userdata('error');
}
?>
<?php
if ($this->session->userdata('info')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('info'); ?>',
            '',
            'info'
        )
    </script>
<?php
    $this->session->unset_userdata('info');
}
?>
    <script>
        $(document).ready(function() {
            var model_name      = "<?php echo $model_name?>";
            var module_name     = "<?php echo $module_name?>";
            var table_name      = "<?php echo $table_name?>";
            var page_name       = "<?php echo $page_name?>";
            var url_get_all     = '<?= base_url() . $module_name . '/' . $page_name ?>';
            $('.bulk-button').click(function() {
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
                    var list_mark_ids = rows_id.join(", ");
                    $('#list_mark_ids').val(list_mark_ids);
                    rows_id.forEach(function(single_id) {
                        $('#list_mark').append(`<li class="col-md-6">` + String("00000000" + single_id).slice(-8) + `</li>`)
                    })
                }
            })
            $('#row_dropdown').on('change', function () {
                var row_val = $(this).val(); 
                var tab_val = "<?php echo $tab?>";
                window.location = "?page=1&row=" + row_val +"&tab="+tab_val; 
                return false;
            });
            $('#check_all').click(function(){
                if (this.checked == true){
                    Array.from($('.check_single')).forEach(function(element){
                        $(element).prop('checked', true);
                        $('.check_single').parent().parent().css('background', '#e7f4e4');
                    })
                } else {
                    Array.from($('.check_single')).forEach(function(element){
                        $(element).prop('checked', false);
                        $('.check_single').parent().parent().css('background', '');
                    })
                }
            })
            $('.check_single').on('change',function(){
                if (this.checked == true){
                    $(this).parent().parent().css('background', '#e7f4e4');
                }else{
                    $(this).parent().parent().css('background', '');
                }
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
                window.location.href = "<?= base_url(); ?>" + "main_table_02/delete_row?delete_id=" + user_deleteKey + "&table=" + table_name + "&module=" + module_name + "&page=" + page_name;
                }
            })
            })

     
           
            $("#filter_by_department").change(function() {
                var filter_dept = document.getElementById("filter_by_department");
                document.location.href = page_name+"?dept=" + filter_dept.value ;
            })
            $("#filter_by_section").change(function() {
            var filter_sec = document.getElementById("filter_by_section");
            document.location.href = page_name+"?sec=" + filter_sec.value;
            })
            $("#filter_by_group").change(function() {
                var filter_group = document.getElementById("filter_by_group");
                document.location.href = page_name+"?group=" + filter_group.value;
            })
            $("#filter_by_line").change(function() {
                var filter_line = document.getElementById("filter_by_line");
                document.location.href = page_name+"?line=" + filter_line.value;
            })
            $("#filter_by_team").change(function() {
                var filter_team = document.getElementById("filter_by_team");
                document.location.href = page_name+"?team=" + filter_team.value;
            })
            
            $("#filter_by_branch").change(function() {
                var filter_branch = document.getElementById("filter_by_branch");
                document.location.href = page_name+"?branch=" + filter_branch.value;
            })
            
            $("#filter_by_division").change(function() {
                var filter_division = document.getElementById("filter_by_division");
                document.location.href = page_name+"?division=" + filter_division.value;
            })

            $("#filter_by_status").change(function() {
            var filter_status = document.getElementById("filter_by_status");
            document.location.href = page_name+"?status=" + filter_status.value;
        })


            $('#btn_clear_filter').click(function(){
                $("#filter_by_division").val("");
                $("#filter_by_branch").val("");
                $("#filter_by_team").val("");
                $("#filter_by_status").val("");
                $("#filter_by_line").val("");
                $("#filter_by_group").val("");
                $("#filter_by_section").val("");
                $("#filter_by_department").val("");
                document.location.href = page_name;
            })

        })
    </script>
    <!-------------------- Export ----------------->
    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <script>
        document.getElementById("btn_export").addEventListener('click', function() {
            /* Create worksheet from HTML DOM TABLE */
            var wb = XLSX.utils.table_to_book(document.getElementById("table_main"));
            /* Export to file (start a download) */
            XLSX.writeFile(wb, "<?php echo $excel_output[1]?>");
        });
    </script>
</body>
</html>