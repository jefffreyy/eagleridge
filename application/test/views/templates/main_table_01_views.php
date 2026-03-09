<html>
<?php $this->load->view('templates/css_link'); ?>
<style>
    .list-group-item.active {
    z-index: 2;
    color: #545454;
    background-color:#e1ffde !important;
    border-color: #e1ffde !important;
}
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
  <style>
        .vertical-scrollable>.row {
            position: absolute;
            overflow-y: scroll;
        }
        .hide{
            display: none;
        }

        .side_module{
            overflow-y: auto;
            max-height: 100vh;
        }
        .side_module::-webkit-scrollbar {
            width: 7px;
        }
        .side_module::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius: 10px;
        }

        .side_module::-webkit-scrollbar-thumb {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius: 10px;
       
        }
        @media only screen and (min-width: 700px) {
          
            .sideBtn{
                display: none;
            }
        }

        @media only screen and (max-width: 500px) {
            
            .sideModule{
                z-index: 1000;
                left: -180px;
                transition: .4s;
            }
            .sideModule.active {
                left: 0;
            }
            .sideBtn{
                margin: 1px 0 1px 30px;
                padding: 0;
                font-size: 15px;
                color: gray;
                left: -22px;
                cursor: pointer;
                position: fixed;
            }
       
        }
    </style>
<html>
<body>
    <div class="content-wrapper ">
        <div class = "row ">
            
            <div class = "col-md-2 sideModule" id="sideModule_id">
                <div class="sideBtn" ><i class="fas fa-bars" id="side_btn_id"></i></div>
                <?php
                    $raw_input = basename("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                    $url_end = str_replace("administrators/", "", $raw_input);
                ?>
                <!--list-group list-group-light side_module position-fixed -->
                    <nav class="side_module position-fixed " id="side_nav">
                        <!-- <a href="adjustments" class="list-group-item list-group-item-action px-3 border-0 ripple <?php if ($this->uri->segment(2) == "adjustments")  echo "active"; ?>" >Adjustments</a> -->
                        <!-- <a href="allowances" class="list-group-item list-group-item-action px-3 border-0 ripple <?php if ($this->uri->segment(2) == "allowances")  echo "active"; ?>" >Allowances</a> -->
                        <a href="taxable_allowances" class="list-group-item list-group-item-action px-3 border-0 ripple <?php if ($this->uri->segment(2) == "taxable_allowances")  echo "active"; ?>" id="taxable_allowances">Taxable Allowances</a>
                        <a href="non_taxable_allowances" class="list-group-item list-group-item-action px-3 border-0 ripple " id="non_taxable_allowances">Non Taxable Allowances</a>
                        <!-- <a href="deductions" class="list-group-item list-group-item-action px-3 border-0 ripple <?php if ($this->uri->segment(2) == "deductions")  echo "active"; ?>">Deductions</a> -->
                        <a href="taxable_deductions" class="list-group-item list-group-item-action px-3 border-0 ripple " id="taxable_deductions">Taxable Deductions</a>
                        <a href="non_taxable_deductions" class="list-group-item list-group-item-action px-3 border-0 ripple " id="non_taxable_deductions">Non Taxable Deductions</a>
                        
                        <a href="positions" class="list-group-item list-group-item-action px-3 border-0 ripple " id="positions">Positions</a> 
                        <a href="branches" class="list-group-item list-group-item-action px-3 border-0 ripple <?=($C_COM_STRUCTURE[32]->value == '1') ? '' : 'hide';?>" id="branches">Branches</a>
                        <a href="departments" class="list-group-item list-group-item-action px-3 border-0 ripple <?=($C_COM_STRUCTURE[33]->value == '1') ? '' : 'hide';?>" id="departments">Departments</a>
                        <a href="sections" class="list-group-item list-group-item-action px-3 border-0 ripple " id="sections">Sections</a>
                        <a href="divisions" class="list-group-item list-group-item-action px-3 border-0 ripple <?=($C_COM_STRUCTURE[34]->value == '1') ? '' : 'hide';?>" id="divisions">Divisions</a>
                        <a href="groups" class="list-group-item list-group-item-action px-3 border-0 ripple  <?=($C_COM_STRUCTURE[36]->value == '1') ? '' : 'hide';?>" id="groups">Groups</a>
                        <a href="lines" class="list-group-item list-group-item-action px-3 border-0 ripple  <?=($C_COM_STRUCTURE[38]->value == '1') ? '' : 'hide';?>" id="lines">Lines</a>
                        <a href="teams" class="list-group-item list-group-item-action px-3 border-0 ripple  <?=($C_COM_STRUCTURE[37]->value == '1') ? '' : 'hide';?>" id="teams">Teams</a>
                        <a href="skill_names" class="list-group-item list-group-item-action px-3 border-0 ripple " id="skill_name">Skill Name</a>
                        <a href="skill_levels" class="list-group-item list-group-item-action px-3 border-0  ripple " id="skill_level">Skill Level</a>
                        <a href="marital_statuses" class="list-group-item list-group-item-action px-3 border-0 ripple " id="marital_status">Marital Status</a>
                        <a href="genders" class="list-group-item list-group-item-action px-3 border-0 ripple " id="gender">Gender</a>
                        <a href="nationalities" class="list-group-item list-group-item-action px-3 border-0 ripple " id="nationality">Nationality</a>
                        <a href="religions" class="list-group-item list-group-item-action px-3 border-0 ripple " id="religion">Religion</a>
                        <a href="blood_types" class="list-group-item list-group-item-action px-3 border-0 ripple " id="blood">Blood</a>
                        <a href="hmos" class="list-group-item list-group-item-action px-3 border-0 ripple " id="hmo">HMO</a>
                        <a href="shirt_sizes" class="list-group-item list-group-item-action px-3 border-0 ripple " id="shirt_size">Shirt Size</a>
                        <a href="banks" class="list-group-item list-group-item-action px-3 border-0 ripple " id="bank">Bank</a>
                        <a href="asset_categories" class="list-group-item list-group-item-action px-3 border-0 ripple " id="asset_categories">Asset Categories</a>
                        <a href="leave_types" class="list-group-item list-group-item-action px-3 border-0 ripple " id="leave_types">Leave Types</a>
                        <a href="company_locations" class="list-group-item list-group-item-action px-3 border-0 ripple " id="company_locations">Company Locations</a>
                        <a href="employee_types" class="list-group-item list-group-item-action px-3 border-0 ripple " id="employee_types">Employee Types</a>
                        <a href="holidays" class="list-group-item list-group-item-action px-3 border-0 ripple " id="holidays">Holidays</a>
                        <a href="knowledge_articles" class="list-group-item list-group-item-action px-3 border-0 ripple " id="knowledge_articles">Knowledge Articles</a>
                        <a href="knowledge_categories" class="list-group-item list-group-item-action px-3 border-0 ripple " id="knowledge_categories">Knowledge Categories</a>
                        <a href="pay_grade" class="list-group-item list-group-item-action px-3 border-0 ripple " id="pay_grade">Pay Grade</a>
                        <a href="stockrooms" class="list-group-item list-group-item-action px-3 border-0 ripple " id="stockrooms">Stockrooms</a>
                        <a href="termination_types" class="list-group-item list-group-item-action px-3 border-0 ripple " id="termination_types">Termination Types</a>
                        <a href="biometrics" class="list-group-item list-group-item-action px-3 border-0 ripple " id="biometrics">Biometrics</a>
                    </nav>
            </div>
            <div class = "col-md-10">
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
                        $url_add_combined  = $url_add_params .".". $url_add_design;
                        $url_add_encrypted = technos_encrypt($url_add_combined);
                        $url_csv_params    = $table_name."-".$module_name."-".$page_name."-".$module_title."-".$page_title;
                        $url_csv_encrypted = technos_encrypt($url_csv_params);
                        ?>
                        <div class="col-md-6 button-title">
                            <a href="<?php echo base_url('main_table_01/add_data?'.$url_add_encrypted);?>" id="btn_application"     class=" btn technos-button-green shadow-none rounded" <?php if (!$add_button[0])  echo "hidden"; ?>><i class="fas fa-plus"></i>&nbsp;<?= $add_button[1] ?></a>
                            <!-- <a href="<?php echo base_url('main_table_01/csv_import?'.$url_csv_encrypted);?>" id="bulk_import"     class=" btn technos-button-green shadow-none rounded" <?php if (!$add_button[0])  echo "hidden"; ?>><i class="fas fa-file-import"></i>&nbsp;Bulk Import</a> -->
                            <a href="<?php echo base_url('main_table_01/excel_import?'.$url_csv_encrypted);?>" id="bulk_import"     class=" btn technos-button-green shadow-none rounded" <?php if (!$add_button[0])  echo "hidden"; ?>><i class="fas fa-file-import"></i>&nbsp;Bulk Update</a>
                            <a id="btn_export"          class=" btn technos-button-gray shadow-none rounded" <?php if (!$excel_output[0])  echo "hidden"; ?>><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a>
                        </div>
                    </div>
                    <hr>
                    <div class = "pb-1">    
                        <?php
                            $search_data = $this->input->get('all');
                            $search_data = str_replace("_", " ", $search_data);

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
                            // $last_page = intval($C_DATA_COUNT/$row) + 1;
                            $last_page_initial = ceil($C_DATA_COUNT / $row);
                            $last_page = ($last_page_initial == 0 || $last_page_initial == 1) ? 1 : $last_page_initial;

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
                    <div class="card border-0 p-0 m-0">
                        <div class = "p-1">
                            <div class="card-header p-0">
                                <ul class="nav nav-tabs">
                                    <?php
                                    foreach ($C_DATA_TAB as $C_DATA_TAB_ROW) {?>
                                        <li class="nav-item">
                                            <a class="nav-link head-tab <?php echo($C_DATA_TAB_ROW[0] == $tab) ? ' active' : ''; ?>" id="tab-<?= $C_DATA_TAB_ROW[0]?>" href="?page=1&row=<?=$row?>&tab=<?= $C_DATA_TAB_ROW[0]?>" ><?= $C_DATA_TAB_ROW[0] ?><span class="ml-2 badge badge-pill badge-secondary"><?= $C_DATA_TAB_ROW[3] ?></span></a>
                                        </li>
                                    <?php
                                    } ?>                
                                </ul>
                            </div>
                        <div class="col-md-4 pl-0">
                            <div class ="input-group p-1 pt-2">
                                <?php 
                                    if($search_data){ ?>
                                    <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none"   <?php if (!$add_button[0])  echo "hidden"; ?>><i class="fa-regular fa-broom-wide" style="margin-top: 4px"></i>&nbsp;Clear</button>
                                <?php } else { ?>
                                    <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"   <?php if (!$add_button[0])  echo "hidden"; ?>><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
                                <?php }?>
                            
                                <input type="text" class="form-control" placeholder="Search" value="<?= ($search_data) ? $search_data : ""; ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
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
                                    <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$tab'"; ?>> < </a></li>
                                    <li><a href = "?page=1&row=<?=$row?>&tab=<?=$tab?>"  <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                                    <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                                    <li><a href = "?page=<?= $current_page - 1?>&row=<?=$row?>&tab=<?=$tab?>"   <?php if ($current_page <= 2)               echo "hidden";                  ?>><?= $prev_page?>         </a></li>
                                    <li><a style = "color:white ; background-color:#007bff !important"                                                               ><?= $current_page ?>     </a></li>
                                    <li><a href = "?page=<?= $current_page + 1?>&row=<?=$row?>&tab=<?=$tab?>"   <?php if ($current_page >= $last_page - 1)  echo "hidden";                  ?>><?= $next_page?>         </a></li>
                                    <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>...                      </a></li>
                                    <li><a href = "?page=<?= $last_page?>&row=<?=$row?>&tab=<?=$tab?>"          <?php if ($current_page == $last_page)      echo "hidden";                  ?>><?= $last_page?>         </a></li>
                                    <li><a                                      style="margin-right: 10px;"    <?php if ($current_page < $last_page)       echo "href='?page=$next_page&row=$row&tab=$tab'"; ?>>>                        </a></li>
                                </ul>
                                <p class ="p-0 mr-0 d-inline" style = "color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                                <select id="row_dropdown" class="custom-select" style="width: auto;">
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
                            <table class="table table-hover m-0" id="table_main" style="width:100%">
                                <thead>
                                    <th class="text-center" style="width:5%"><input type="checkbox" name="check_all" id="check_all"></th>
                                    <?php
                                    foreach ($C_DB_DESIGN as $C_DB_DESIGN_ROW) {
                                        if($C_DB_DESIGN_ROW[5] == true) {?>
                                        <th style='width:<?= $C_DB_DESIGN_ROW[6] ?>%;text-align: center;'><?= $C_DB_DESIGN_ROW[7]?></th>
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
                                                <td class="text-center" id="select_item">
                                                    <input type="checkbox" name="brand" class="check_single" row_id="<?= $id_raw ?>">
                                                </td>
                                            <?php
                                            foreach ($C_DB_DESIGN as $C_DB_DESIGN_ROW) {
                                                if($C_DB_DESIGN_ROW[5] == true) {
                                                    $column = $C_DB_DESIGN_ROW[0];
                                                    $process = $C_DB_DESIGN_ROW[8];
                                                    $width = $C_DB_DESIGN_ROW[6];
                                                    $column_data_raw = $C_DATA_TABLE_ROW->$column;
                                                    if($process == "id"){
                                                        $column_data = $id_prefix . str_pad($column_data_raw, 5, '0', STR_PAD_LEFT);
                                                    }
                                                    else if($process == "date"){
                                                        $column_data = date('j M Y', strtotime($column_data_raw));
                                                        $column_data = ($column_data == "30 Nov -0001") ? "0000-00-00" : $column_data;
                                                    }
                                                    else if($process == "status"){
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
                                                    else if ($process == "user"){
                                                        foreach ($C_DATA_EMPL_NAME as $C_DATA_EMPL_NAME_ROW){
                                                            if($column_data_raw == $C_DATA_EMPL_NAME_ROW->id){
                                                                $column_data = $C_DATA_EMPL_NAME_ROW->col_frst_name . " " . $C_DATA_EMPL_NAME_ROW->col_last_name;
                                                            }
                                                        }
                                                    }
                                                    else{
                                                        $column_data =  $column_data_raw;
                                                    }
                                                    if($process != "status"){?>
                                                        <td class="text-center" style="width:<?= $width?>%"><?= $column_data?></td>
                                                    <?php }
                                                    else{?>
                                                        <td style="width:<?= $width?>%;text-align: center;">
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
                                            $url_edit_data      = http_build_query($C_DATA_TABLE_ROW);
                                            $url_edit_design    = http_build_query($C_DB_DESIGN);
                                            $url_edit_combined  = $url_edit_params . "." .$url_edit_data .".". $url_edit_design;
                                            $url_edit_encrypted = technos_encrypt($url_edit_combined);
                                            ?>
                                                <td style="width:15%" class="text-center">
                                                    <a class = "select_row p-2"      href="<?php echo base_url('main_table_01/show_data?'.$url_edit_encrypted); ?>"  style ="color: gray; cursor: pointer; !important"  row_id="<?= $id_raw ?>"><i class="far fa-eye" id="view"></i></a>
                                                    <a class = "select_edit_row p-2" href="<?php echo base_url('main_table_01/edit_data?'.$url_edit_encrypted); ?>"  style ="color: gray; cursor: pointer; !important" row_id="<?= $id_raw ?>"><i class="far fa-edit" id="edit"></i></a>
                                                    <!-- <a class = "delete_data p-2 " style ="color: gray !important"  delete_key="<?=  $id_raw ?>"><i class="far fa-trash-alt" hidden></i></a> -->
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } 
                                    else {
                                        ?>
                                        <tr class="table-active">
                                            <td colspan="9">
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
            <form action="<?php echo base_url('main_table_01/edit_bulk_status?page='.$current_page.'&row='.$row.'&tab='.$tab.'&table='.$table_name.'&module='.$module_name.'&page_name='.$page_name); ?>" method="post">
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
                    <button type="submit" class="btn btn-info" id = "btn_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('templates/jquery_link'); ?>

<?php
if ($this->session->userdata('success')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('success'); ?>'
    })
</script>
<?php
$this->session->unset_userdata('success');
}
?>

<?php
if ($this->session->userdata('delete')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('delete'); ?>'
    })
</script>
<?php
$this->session->unset_userdata('delete');
}
?>


<?php
if ($this->session->userdata('error')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-danger toast_width',
        title: 'Error',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('error'); ?>'
    })
</script>
<?php
$this->session->unset_userdata('error');
}
?>


<?php
if ($this->session->userdata('info')) {
?>
    <script>Swal.fire('<?php echo $this->session->userdata('info'); ?>','','info')</script>
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
            //   $('#side_nav').animate({
            //     scrollTop: $("a.active").offset().top
            // }, 2000);
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
                var tab_val = "<?php echo $tab?>";
                var optionValue = $('#search_data').val();
                var url = window.location.href.split("?")[0];
                if (window.location.href.indexOf("?") > 0) {
                window.location = url + "?page=1&tab="+tab_val+"&all=" + optionValue.replace(/\s/g, '_');
                } else {
                window.location = url + "?page=1&tab="+tab_val+"&all=" + optionValue.replace(/\s/g, '_');
                }
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
                window.location.href = "<?= base_url(); ?>" + "main_table_01/delete_row?delete_id=" + user_deleteKey + "&table=" + table_name + "&module=" + module_name + "&page=" + page_name;
                }
            })
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

    // function show(){
       
    //     let collection =document.getElementsByClassName('sideModule')
    //     collection[0].classList.toggle('active');
       
    // }

    const sideBtn = document.getElementsByClassName('sideBtn')
    const sideModule = document.getElementsByClassName('sideModule')

    document.onclick = (e) => {
    if(e.target.id !== 'sideModule_id' && e.target.id !== 'side_btn_id'){
        sideModule[0].classList.remove('active')
        sideBtn[0].classList.remove('active')
    }
    }

    sideBtn[0].onclick = () => {
        console.log('clicked')
        sideBtn[0].classList.toggle('active')
        sideModule[0].classList.toggle('active')
    }
    
    // $(document).ready(function(){
    //     let collection = document.getElementsByClassName('sideModule')
    //     if(collection[0] == 'active'){
    //         $('body').click(function(){
    //             let collection =document.getElementsByClassName('sideModule')
    //             collection[0].classList.toggle('active');
    //         });
    //     }
        
    // })

    // Add an event listener to the parent element containing the navigation links
    document.getElementById('side_nav').addEventListener('click', function(event) {
        // Get the clicked link's ID
        const activeLinkId = event.target.id;

        // Store the active link's ID in localStorage
        localStorage.setItem('activeLinkId', activeLinkId);
    });

    // After the page loads, retrieve the active link ID from localStorage and apply the "active" class
    document.addEventListener('DOMContentLoaded', function() {

        const activeLinkId = localStorage.getItem('activeLinkId');

        if (activeLinkId) {
            // Remove the "active" class from all links
            const links = document.querySelectorAll('.list-group-item');
            links.forEach(link => link.classList.remove('active'));

            // Apply the "active" class to the active link
            const activeLink = document.getElementById(activeLinkId);
            activeLink.classList.add('active');

            // When the page refreshes, scroll to the active item.
            activeLink.scrollIntoView();
        }

    });

    </script>
</body>
</html>