<html>
<?php $this->load->view('templates/css_link'); 
$this->load->library('session');
?>
<?php //$raw_input = basename("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
$raw_input = $encrypted_data;
$raw_input_2 = str_replace("add_data?", "", $raw_input);
$raw_encrypted = str_replace("&", "/", $raw_input_2);
$ciphering = "AES-128-CTR";
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
$decryption_iv = '6234564891013126';
$decryption_key = "Technos";

// $aw = $this->session->userdata('add_data');
// var_dump($aw);
$decryption = openssl_decrypt(
    $raw_encrypted,
    $ciphering,
    $decryption_key,
    $options,
    $decryption_iv
);


list($params, $design, $users, $array1, $array2, $array3, $array4, $array5) = explode('|', $decryption);
list($table_name, $module_name, $page_name, $module_title, $page_title) = explode('#', $params);
parse_str($design, $output_design);

$array1_str = [];
$array2_str = [];
$array3_str = [];
$array4_str = [];
$array5_str = [];

if ($array1 != "X") {
    parse_str($array1, $array1_str);
}
if ($array2 != "X") {
    parse_str($array2, $array2_str);
}
if ($array3 != "X") {
    parse_str($array3, $array3_str);
}
if ($array4 != "X") {
    parse_str($array4, $array4_str);
}
if ($array5 != "X") {
    parse_str($array5, $array5_str);
}

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
                        <a href="<?= base_url($module_name . '/' . $page_name) ?>"><?= $page_title ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add&nbsp;<?= $page_title ?>
                    </li>
                </ol>
            </nav>
            <div class="row d-flex justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    
                              
                                    <?php
                                 
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


                                        if ($add_display == 1) {
                                            
                                            if ($parameter == "text-area") {
                                                $row_size = 4;
                                            }
                                            else{
                                                $row_size = 1;
                                            }


                                            if ($parameter == "text-row") { ?>
                                                <div class="form-group">
                                                    <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                    <input type="text" class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" <?php echo ($add_enable) ? "enabled" : "disabled"; ?> value = "">
                                                </div>
                                            <?php 
                                            } else if ($parameter == "text-area") { ?>
                                                <div class="form-group">
                                                    <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                    <textarea name="<?= $column ?>" class="form-control" id="input_<?= $column ?>" rows="4" cols="50" <?php echo ($add_enable) ? "enabled" : "disabled"; ?>></textarea>
                                                </div>
                                            <?php 
                                            } else if ($parameter == "number") { ?>
                                                <div class="form-group">
                                                    <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                    <input type="number" class="form-control " min="0" name="input_<?= $column ?>" id="input_<?= $column ?>" <?php echo ($add_enable) ? "enabled" : "disabled"; ?> value = "">
                                                </div>
                                            <?php 
                                            } else if ($parameter == "attachment") { ?>
                                                <div class="form-group">
                                                    <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                    <input type="file" class="form-control file_upload" name="input_<?= $column ?>" id="input_<?= $column ?>" <?php echo ($add_enable) ? "enabled" : "disabled"; ?> value="" >
                                                </div>
                                            <?php 
                                            } else if ($parameter == "date") { ?>
                                                <div class="form-group">
                                                    <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                    <input type="date" class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" <?php echo ($add_enable) ? "enabled" : "disabled"; ?> value = "">
                                                </div>
                                            <?php
                                            } else if ($parameter == "time") { ?>
                                                <div class="form-group">
                                                    <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                    <input type="time" class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" <?php echo ($add_enable) ? "enabled" : "disabled"; ?> value = "">
                                                </div>
                                            <?php
                                            }else if ($parameter == "datetime") { ?>
                                                <div class="form-group">
                                                    <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                    <input type="datetime-local" class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" <?php echo ($add_enable) ? "enabled" : "disabled"; ?> value = "">
                                                </div>
                                            <?php
                                            }else if ($parameter == "user") { ?>
                                                <label class=""><?= $label ?></label>
                                                <?php
                                                $user = $this->session->userdata('SESS_USER_ID');

                                                if ($setting == "self"){?>
                                                    <select class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" <?php // echo ($editable) ? "enabled" : "disabled"; ?>>
                                                        <?php foreach ($users_str as $users_row) { 
                                                            if($users_row["id"] ==  $user){?>
                                                            <option value=<?= $users_row["id"] ?>><?= $users_row["col_empl_cmid"] . " - " . $users_row["col_frst_name"] . " " . $users_row["col_last_name"] ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    
                                                <?php }
                                                else{?>
                                                    <select class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" <?php // echo ($editable) ? "enabled" : "disabled"; ?>>
                                                        <?php foreach ($users_str as $users_row) {?>
                                                            <option value=<?= $users_row["id"] ?>><?= $users_row["col_empl_cmid"] . "- " . $users_row["col_frst_name"] . " " . $users_row["col_last_name"] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    
                                                <?php }?>
                                            <?php
                                            } else if ($parameter == "fixed-sel-direct") {
                                                $selection = explode(';', $setting); ?>
                                                <label class=""><?= $label ?></label>
                                                <div class="form-group">
                                                    <select class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" <?php echo ($add_enable) ? "enabled" : "disabled"; ?>>
                                                        <?php foreach ($selection as $selection_row) { ?>
                                                            <option><?= $selection_row ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php
                                            } else if ($parameter == "fixed-sel-second") {
                                                $selection = explode(';', $setting); ?>
                                                <label class=""><?= $label ?></label>
                                                <div class="form-group">
                                                    <select class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" <?php echo ($add_enable) ? "enabled" : "disabled"; ?>>
                                                        <?php foreach ($selection as $selection_row) { 
                                                            
                                                            $selection_options = explode(',', $selection_row); ?>
                                                            <option value = <?=$selection_options[1]?> ><?= $selection_options[0] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php 
                                            } else if ($parameter == "db-sel") {?>

                                                <label class=""><?= $label ?><?php if($add_required == 0){ echo(" (Optional)"); } ?></label>
                                                <div class="form-group">
                                                    <select class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" <?php echo ($add_enable) ? "enabled" : "disabled"; ?>>
                                                        <?php if($add_required == 0){ ?><option value=0 selected>No Option Selected</option><?php } ?>
                                                        <?php if($setting == "array1"){ foreach ($array1_str as $array1_row) { ?><option value=<?= $array1_row["id"] ?>><?= $array1_row["name"] ?></option><?php }} ?>
                                                        <?php if($setting == "array2"){ foreach ($array2_str as $array2_row) { ?><option value=<?= $array2_row["id"] ?>><?= $array2_row["name"] ?></option><?php }} ?>
                                                        <?php if($setting == "array3"){ foreach ($array3_str as $array3_row) { ?><option value=<?= $array3_row["id"] ?>><?= $array3_row["name"] ?></option><?php }} ?>
                                                        <?php if($setting == "array4"){ foreach ($array4_str as $array4_row) { ?><option value=<?= $array4_row["id"] ?>><?= $array4_row["name"] ?></option><?php }} ?>
                                                        <?php if($setting == "array5"){ foreach ($array5_str as $array5_row) { ?><option value=<?= $array5_row["id"] ?>><?= $array5_row["name"] ?></option><?php }} ?>
                                                    </select>
                                                </div>
                                            <?php
    
                                            } else { ?>
                                                <div class="form-group">
                                                    <label class="" for="input_<?= $column ?>"><?= $label ?></label>
                                                    <input type="<?= $output_design_row[1] ?>" rows=<?= $row_size ?> class="form-control" name="input_<?= $column ?>" id="input_<?= $column ?>" <?php echo ($add_enable) ? "enabled" : "disabled"; ?>>
                                                </div>
                                            <?php
                                            } ?>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <div class="mr-2" style="float: right !important">
                                        <a id="btn_add" class="btn technos-button-blue shadow-none rounded " ;> Submit</a>
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
    <script>
        $(document).ready(function() {
            <?php
            $js_array = json_encode($output_design);
            echo "var add_data = " . $js_array . ";";
            ?>
           
            $('#input_empl_id').select2();
            $('#input_assigned_by').select2();
            $('#input_employee_id').select2();

            $("#btn_add").on("click", function() {

                var col0 = [add_data.map(d => d[0]), add_data.map(d => d[6])];
                output = col0[0].map((_, colIndex) => col0.map(row => row[colIndex]));
                var element_Id = "";
                var count = 0;
                var isExit = 0;
                output.forEach(function(output_row) {
                    
                    if (output_row[1] == 1 && isExit == 0) {
                        if($("#input_" + output_row[0]).val() == ""){
                            alert("Please select a valid input");
                            isExit = 1;
                        }
                        if (count >= 1) {
                        element_Id += '&' + output_row[0] + '=' + $("#input_" + output_row[0]).val();
                        } else {
                            element_Id += output_row[0] + '=' + $("#input_" + output_row[0]).val();
                        }
                        count++;           
                    }

                }
                
                );

                if(isExit == 0){
                    element_Id += '&table=' + '<?php echo ($table_name) ?>';
                    // document.location.href = "add_row?"+ element_Id + "&module=" + '<?php echo($module_name) ?>'+ "&page=" + '<?php echo($page_name) ?>';

                
                    // Get the file object
                    var formData = new FormData();
                    if($('.file_upload').length != 0) {
                        var file = $('.file_upload')[0].files[0];
                        // Create a FormData object
                        
                        formData.append("file", file);
                    }
                    

                    // Send the AJAX request to the server URL
                    $.ajax({
                    url: "<?=base_url()?>main_table_02/add_row?"+ element_Id + "&module=" + '<?php echo($module_name) ?>' + "&page=" + '<?php echo ($page_name) ?>',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Add Successful',
                        willClose: () => {
                            document.location.href = '<?php echo (base_url() . $module_name . "/" . $page_name )?>';
                        }
                        });
                    },
                    error: function(error) {
                        console.log(error);
                        Swal.fire({
                        icon: 'warning',
                        title: 'Fail',
                        text: 'Add Failed',
                        willClose: () => {
                            document.location.href = '<?php echo (base_url() . $module_name . "/" . $page_name )?>';
                        }
                        });
                    }
                });
            }
            })
        })
    </script>
</body>

</html>