<html>
<?php $this->load->view('templates/css_link'); ?>
<?php $raw_input = basename("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
$raw_input_2 = str_replace("add_data?", "", $raw_input);
$raw_encrypted = str_replace("&", "/", $raw_input_2);
$ciphering = "AES-128-CTR";
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
$decryption_iv = '6234564891013126';
$decryption_key = "Technos";
$decryption = openssl_decrypt(
    $raw_encrypted,
    $ciphering,
    $decryption_key,
    $options,
    $decryption_iv
);
list($params, $design) = explode('.', $decryption);
list($table_name, $module_name, $page_name, $module_title, $page_title) = explode('-', $params);
parse_str($design, $output_design);


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

                                        if ($output_design_row[4] == true) {
                                            $row_size = 1;
                                            if ($output_design_row[8] == "textarea") {
                                                $row_size = 4;
                                            }
                                            if ($output_design_row[8] == "textarea") {
                                    ?>
                                                <div class="form-group">
                                                    <label class="" for="<?= $output_design_row[4] ?>"><?= $output_design_row[7] ?></label>
                                                    <textarea name="<?= $output_design_row[0] ?>" class="form-control" id="input_<?=$output_design_row[0] ?>" rows="4" cols="50" <?php echo ($output_design_row[4]) ? "enabled" : "disabled"; ?> required></textarea>
                                                </div>
                                            <?php } 
                                            else if($output_design_row[8] == "status"){ 
                                                $selection = explode(';', $output_design_row[10]);?>
                                                <label class="">Status</label>
                                                <div class="form-group">
                                                    <select class="form-control" name="input_<?=$output_design_row[0]?>" id="input_<?= $output_design_row[0]?>" <?php echo ($output_design_row[4]) ? "enabled" : "disabled"; ?> >
                                                        <?php foreach ($selection as $selection_row) { ?>
                                                            <option><?= $selection_row ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <?php
                                            }
                                            else if($output_design_row[8] == "dropdown"){ 
                                                $selection = explode(';', $output_design_row[10]);?>
                                                <label class="" for="<?= $output_design_row[0] ?>"><?= $output_design_row[7] ?></label>
                                                <div class="form-group">
                                                    <select class="form-control" name="input_<?=$output_design_row[0]?>" id="input_<?= $output_design_row[0]?>" <?php echo ($output_design_row[4]) ? "enabled" : "disabled"; ?>>
                                                        <?php foreach ($selection as $selection_row) { ?>
                                                            <option><?= $selection_row ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <?php
                                            }
                                            else { ?>
                                                <div class="form-group">
                                                    <label class="" for="<?= $output_design_row[4] ?>"><?= $output_design_row[7] ?></label>
                                                    <input type="<?= $output_design_row[1] ?>" rows=<?= $row_size ?> class="form-control" name="input_<?=$output_design_row[0]?>" id="input_<?= $output_design_row[0]?>" <?php echo ($output_design_row[4]) ? "enabled" : "disabled"; ?> required>
                                                </div>
                                            <?php
                                            } ?>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <div class="mr-2" style ="float: right !important">
                                        <a id="btn_add"  class="btn technos-button-blue shadow-none rounded ";> Submit</a>
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
        $(document).ready(function(){
            <?php
            $js_array = json_encode($output_design);
            echo "var add_data = ". $js_array. ";";
            ?>
            $("#btn_add").on("click", function() {

            var col0 = [add_data.map(d => d[0]), add_data.map(d => d[4])]; 
            output = col0[0].map((_, colIndex) => col0.map(row => row[colIndex]));
            var element_Id = "";
            var count = 0;
            output.forEach(function(output_row) {
                if(output_row[1] == 1){
                    if(count >= 1){
                        element_Id += '&' + output_row[0] + '=' + $("#input_"+output_row[0]).val();
                    }else{
                        element_Id += output_row[0] + '=' + $("#input_"+output_row[0]).val();
                    }count++;
                }
                
            });
          
            element_Id += '&table=' + '<?php echo($table_name) ?>';
            document.location.href = "add_row?"+ element_Id + "&module=" + '<?php echo($module_name) ?>'+ "&page=" + '<?php echo($page_name) ?>';
        })
        })
    </script>
</body>
</html>