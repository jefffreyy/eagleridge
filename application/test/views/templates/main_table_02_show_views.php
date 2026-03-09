<html>
<?php $this->load->view('templates/css_link'); ?>
<?php //$raw_input = basename("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

                            $raw_input = $encrypted_data;
                            $raw_input_2 = str_replace("show_data?", "", $raw_input);
                            $raw_encrypted = str_replace("&", "/", $raw_input_2);
                            $ciphering = "AES-128-CTR";
                            $iv_length = openssl_cipher_iv_length($ciphering);
                            $options = 0;
                            $decryption_iv = '6234564891013126';
                            $decryption_key = "Technos";
                            $decryption=openssl_decrypt ($raw_encrypted, $ciphering, 
                                    $decryption_key, $options, $decryption_iv);

                            list($params,$data_raw, $design, $users, $array1, $array2, $array3, $array4, $array5) = explode('|', $decryption);
                            list($table_name, $id_prefix, $module_name,$page_name,$module_title,$page_title) = explode('#', $params);
                            $data = str_replace("*", ".", $data_raw);    
                            parse_str($data, $output_data);
                            parse_str($design, $output_design);

                            $array1_str = [];
                            $array2_str = [];
                            $array3_str = [];
                            $array4_str = [];
                            $array5_str = [];

                            if($array1 != "X"){parse_str($array1, $array1_str);}
                            if($array2 != "X"){parse_str($array2, $array2_str);}
                            if($array3 != "X"){parse_str($array3, $array3_str);}
                            if($array4 != "X"){parse_str($array4, $array4_str);}
                            if($array5 != "X"){parse_str($array5, $array5_str);}
                            parse_str($users, $users_str);
                        ?>
<body>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url($module_name) ?>"><?= $module_title ?></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= base_url($module_name. '/' . $page_name) ?>"><?= $page_title ?></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">View&nbsp;<?= $page_title ?>
                </li>
            </ol>
        </nav>
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card" >
                    <div class="modal-body pb-5">
                        <div class="row">
                        
                            <div class="col-md-12">
                                <?php
                                // var_dump($output_data);
                                foreach ($output_design as $output_design_row) {
                                    $selection = [];
                                    
                                    $column         = $output_design_row[0];
                                    $label          = $output_design_row[1];
                                    $parameter      = $output_design_row[2];
                                    $setting        = $output_design_row[3];
                                    $table_display  = $output_design_row[4];
                                    $table_width    = $output_design_row[5];
                                    $add_display    = $output_design_row[6];
                                    $add_required   = $output_design_row[7];
                                    $add_enable     = $output_design_row[8];
                                    $edit_display   = $output_design_row[9];
                                    $edit_enable    = $output_design_row[10];
                                    $show_views     = $output_design_row[11];


                                    if ($show_views == 1) {
                                        if(isset($output_data[$column]) == false){
                                            $output = "";
                                        }
                                        else{
                                            $output = $output_data[$column];
                                        }
                                        if ($parameter == "text-area") {
                                            $row_size = 4;
                                        } else {
                                            $row_size = 1;
                                        }
                                        if ($parameter == "id") { 
                                            $output = $id_prefix . str_pad($output, 5, '0', STR_PAD_LEFT);?>
                                             <div class="form-group">
                                                <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                <input type="text" class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" disabled value= "<?= $output ?>">
                                            </div>
                                        <?php
                                        } else if ($parameter == "text-row") { ?>
                                            <div class="form-group">
                                                <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                <input type="text" class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" disabled value= "<?= $output ?>">
                                            </div>
                                        <?php
                                        } else if ($parameter == "text-area") { ?>
                                            <div class="form-group">
                                                <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                <textarea name="<?= $column ?>" class="form-control" id="input_<?= $column ?>" rows="4" cols="50" disabled><?= $output ?></textarea>
                                            </div>
                                        <?php
                                        } else if ($parameter == "number") { ?>
                                            <div class="form-group">
                                                <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                <input type="number" class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" disabled value= <?= $output ?>>
                                            </div>
                                        <?php
                                        } else if ($parameter == "attachment") { ?>
                                            <div class="form-group">
                                                <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                <!-- <input type="file" class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" disabled value= <?= $output ?>> -->
                                                <!-- <input type="file" class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>"  disabledstyle="display:none;"/> -->
                                                <br><a href="<?= base_url() . "assets_user/files/" . $module_name . "/" .$output ?>" download> <?= $output ?></a> 
                                                </div>
                                        <?php
                                        } else if ($parameter == "date") { ?>
                                            <div class="form-group">
                                                <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                <input type="date" class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" disabled value= <?= $output ?>>
                                            </div>
                                        <?php
                                        } else if ($parameter == "time") { ?>
                                            <div class="form-group">
                                                <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                <input type="time" class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" disabled value= <?= $output ?>>
                                            </div>
                                        <?php
                                        } else if ($parameter == "datetime") { ?>
                                            <div class="form-group">
                                                <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                <input type="datetime-local" class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" disabled value= <?= str_replace(" ","T",$output)?>>
                                            </div>
                                        <?php
                                           }else if ($parameter == "user") { ?>
                                            <label class=""><?= $label ?></label>
                                            <?php
                                            $user = $this->session->userdata('SESS_USER_ID');

                                            if ($setting == "self"){?>
                                                <select class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" disabled>
                                                    <?php foreach ($users_str as $users_row) { 
                                                        if($users_row["id"] ==  $user){?>
                                                        <option value=<?= $users_row["id"] ?>><?= $users_row["col_empl_cmid"] . " - " . $users_row["col_frst_name"] . " " . $users_row["col_last_name"] ?></option>
                                                    <?php }} ?>
                                                </select>
                                                
                                            <?php }
                                            else{?>
                                                <select class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" disabled>
                                                    <?php foreach ($users_str as $users_row) {
                                                        if($output){?>
                                                        <option value=<?= $users_row["id"] ?> <?= $output == $users_row["id"] ? 'selected' : '' ?>><?= $users_row["col_empl_cmid"] . "- " . $users_row["col_frst_name"] . " " . $users_row["col_last_name"] ?></option>
                                                    <?php } 
                                                        } ?>
                                                </select>
                                                
                                            <?php }?>
                                        <?php
                                        } else if ($parameter == "fixed-sel-direct") {
                                            $selection = explode(';', $setting); ?>
                                            <label class=""><?= $label ?></label>
                                            <div class="form-group">
                                                <select class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" disabled>
                                                    <?php foreach ($selection as $selection_row) { ?>
                                                        <option  <?php echo (($selection_row == $output)) ? "selected" : ""; ?>><?= $selection_row ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        <?php
                                        } else if ($parameter == "fixed-sel-second") {
                                            $selection = explode(';', $setting); ?>
                                            <label class=""><?= $label ?></label>
                                            <div class="form-group">
                                                <select class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" disabled>
                                                    <?php foreach ($selection as $selection_row) {

                                                        $selection_options = explode(',', $selection_row); ?>
                                                        <option value=<?= $selection_options[1] ?>><?= $selection_options[0] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        <?php
                                        } else if ($parameter == "db-sel") { ?>
                                            <label class=""><?= $label ?></label>
                                            <div class="form-group">
                                                <select class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" disabled>
                                                    <?php if($setting == "array1"){ foreach ($array1_str as $array1_row) { ?><option value=<?= $array1_row["id"] ?> <?php echo ($array1_row["id"] == $output) ? "enabled" : "disabled"; ?>><?= $array1_row["name"] ?></option><?php }} ?>
                                                    <?php if($setting == "array2"){ foreach ($array2_str as $array2_row) { ?><option value=<?= $array2_row["id"] ?> <?php echo ($array2_row["id"] == $output) ? "enabled" : "disabled"; ?>><?= $array2_row["name"] ?></option><?php }} ?>
                                                    <?php if($setting == "array3"){ foreach ($array3_str as $array3_row) { ?><option value=<?= $array3_row["id"] ?> <?php echo ($array3_row["id"] == $output) ? "enabled" : "disabled"; ?>><?= $array3_row["name"] ?></option><?php }} ?>
                                                    <?php if($setting == "array4"){ foreach ($array4_str as $array4_row) { ?><option value=<?= $array4_row["id"] ?> <?php echo ($array4_row["id"] == $output) ? "enabled" : "disabled"; ?>><?= $array4_row["name"] ?></option><?php }} ?>
                                                    <?php if($setting == "array5"){ foreach ($array5_str as $array5_row) { ?><option value=<?= $array5_row["id"] ?> <?php echo ($array5_row["id"] == $output) ? "enabled" : "disabled"; ?>><?= $array5_row["name"] ?></option><?php }} ?>
                                                </select>
                                            </div>
                                        <?php

                                        } else { ?>
                                            <div class="form-group">
                                                <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                <input type="<?= $output_design_row[1] ?>" rows=<?= $row_size ?> class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" <?php echo ($editable) ? "enabled" : "disabled"; ?>>
                                            </div>
                                        <?php
                                        } ?>
                                <?php
                                    }
                                }
                                ?>
                                <div class="mr-2" style="float: right !important">
                                    <!-- <a id="btn_edit" class="btn technos-button-blue shadow-none rounded " ;> Submit</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
  
  <?php $this->load->view('templates/jquery_link'); ?>

</body>
</html>