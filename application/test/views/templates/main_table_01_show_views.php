<html>
<?php $this->load->view('templates/css_link'); ?>
<?php $raw_input = basename("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); 
                            $raw_input_2 = str_replace("show_data?", "", $raw_input);
                            $raw_encrypted = str_replace("&", "/", $raw_input_2);
                            $ciphering = "AES-128-CTR";
                            $iv_length = openssl_cipher_iv_length($ciphering);
                            $options = 0;
                            $decryption_iv = '6234564891013126';
                            $decryption_key = "Technos";
                            $decryption=openssl_decrypt ($raw_encrypted, $ciphering, 
                                    $decryption_key, $options, $decryption_iv);

                            list($params,$data, $design) = explode('.', $decryption);
                            list($table_name, $id_prefix, $module_name,$page_name,$module_title,$page_title) = explode('-', $params);
                            parse_str($data, $output_data);
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
                                    foreach ($output_design as $output_design_row) { 
                                        if($output_design_row[9]==1){ 
                                            $row_size = 1;
                                            if($output_design_row[8]=="id")
                                            {
    
                                                $output = $id_prefix. str_pad($output_data[$output_design_row[0]], 5, '0', STR_PAD_LEFT);
                                            }
                                            else if($output_design_row[8]=="user"){
                                                foreach ($C_DATA_EMPL_NAME as $C_DATA_EMPL_NAME_ROW){
                                                    if($output_data[$output_design_row[0]] == $C_DATA_EMPL_NAME_ROW->id){
                                                        $output = $C_DATA_EMPL_NAME_ROW->col_frst_name . " " . $C_DATA_EMPL_NAME_ROW->col_last_name;
                                                    }
                                                }
                                            }
                                            else if($output_design_row[8]=="textarea"){
                                                $output = $output_data[$output_design_row[0]];
                                                $row_size = 4;
                                            }
                                            else{
                                                $output = $output_data[$output_design_row[0]];
                                            }
                                            

                                            if($output_design_row[8]=="textarea"){
                                            ?>
                                            <div class="form-group">
                                                <label class="" for="<?=$output_design_row[0]?>"><?= $output_design_row[7] ?></label>
                                                <textarea id="sample_id" name="sample_name" class="form-control" id="<?=$output_design_row[0]?>" rows="4" cols="50" disabled><?= $output ?></textarea>                                      
                                                </div>
                                            <?php }
                                            else{ ?>
                                                    <div class="form-group">
                                                        <label class="" for="<?=$output_design_row[0]?>"><?= $output_design_row[7] ?></label>
                                                        <input type="<?= $output_design_row[1] ?>" rows=<?=$row_size ?> class="form-control" name="<?=$output_design_row[0]?>" id="<?=$output_design_row[0]?>" value="<?= $output ?>" disabled>
                                                    </div>
                                            <?php
                                            } ?>

                                           
                                    
                                <?php
                                        }
                                    }
                                ?>
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