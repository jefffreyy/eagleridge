<html>
<?php $this->load->view('templates/css_link'); ?>
<?php $raw_input = basename("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
$raw_input_2 = str_replace("csv_import?", "", $raw_input);
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
list($table_name, $module_name, $page_name, $module_title, $page_title) = explode('-', $decryption);
// var_dump($decryption);
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
                    <li class="breadcrumb-item active" aria-current="page">CSV&nbsp;Import&nbsp;<?= $page_title ?>
                    </li>
                </ol>
            </nav>
            <div class="row d-flex justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <!-- Title Text -->
                                <div >
                                    <h1 class="page-title">CSV&nbsp;Upload</h1>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <!-- <div class="col-6">
                                    <h1 class="page-title mb-0 " style="font-size: 20px;">St</h1>
                                </div> -->
                                <div class="col-6">
                                    <!-- <i class="fas fa-question-circle text-primary float-right guide_icon" style="font-size: 20px; cursor:pointer;" data-toggle="modal" data-target="#modal_step1_guides" title="View Guides"></i> -->
                                </div>
                            </div>
                            <div class="container mt-3 mb-3">
                                <div class="coud_upload">
                                    <div class="donwloadFile">
                                        <p><strong>Step 1 : </strong>Download sample file format <i><a href="<?= base_url() ?>assets_system/csv_template/csv_import_name.csv" download>here.</a></i></p>
                                        <p><strong>Step 2 : </strong>Open the file using MS Excel or any Spreadsheet Software</p>
                                        <p><strong>Step 3 : </strong>Add new items on 2nd row onwards of the sheet</p>
                                        <p><strong>Step 4 : </strong>Save the file as CSV</p>
                                        <p><strong>Step 5 : </strong>Upload the CSV by clicking the Browse button below</p>
                                    </div>
                                </div>
                            </div>
                          
                            <div class="col-md-12 mt-4">
                                <form method='post' action='<?= base_url().'main_table_01/csv_import_file?table='.$table_name.'&module='.$module_name.'&page='.$page_name ?>' enctype="multipart/form-data">
                                    <div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input fileficker" id="file" name='file' onchange='myFunction()'>
                                                    <label class="custom-file-label" id="fileInput" for="file_step1">Choose csv file...</label>
                                                </div>
                                                <div class="input-group-append">    
                                                    <input class="btn btn-success mt-0 " type='submit' value='Upload'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function myFunction() {
            var x = document.getElementById("file").files[0].name;;
            document.getElementById("fileInput").innerHTML = x;
        }
    </script>
    <?php $this->load->view('templates/jquery_link'); ?>
    <?php
    if ($this->session->userdata('SESS_ERR_MSG_INSRT_CSV')) {
    ?>
    <script>
        Swal.fire(
        '<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_CSV'); ?>',
        '',
        'error'
        )
    </script>
    <?php
    $this->session->unset_userdata('SESS_ERR_MSG_INSRT_CSV');
    }
    ?>
    <?php
    if ($this->session->userdata('SESS_SUCC_MSG_INSRT_CSV')) {
    ?>
    <script>
        Swal.fire(
        '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_CSV'); ?>',
        '',
        'success'
        )
    </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_CSV');
    }
    ?>
    <script>
        $(document).ready(function() {
            <?php
            $js_array = json_encode($output_design);
            echo "var add_data = " . $js_array . ";";
            ?>
            $("#btn_add").on("click", function() {
                var col0 = [add_data.map(d => d[0]), add_data.map(d => d[4])];
                output = col0[0].map((_, colIndex) => col0.map(row => row[colIndex]));
                var element_Id = "";
                var count = 0;
                output.forEach(function(output_row) {
                    if (output_row[1] == 1) {
                        if (count >= 1) {
                            element_Id += '&' + output_row[0] + '=' + $("#input_" + output_row[0]).val();
                        } else {
                            element_Id += output_row[0] + '=' + $("#input_" + output_row[0]).val();
                        }
                        count++;
                    }
                });
                element_Id += '&table=' + '<?php echo ($table_name) ?>';
                document.location.href = "add_row?" + element_Id + "&module=" + '<?php echo ($module_name) ?>' + "&page=" + '<?php echo ($page_name) ?>';
            })
        })
    </script>
</body>
</html>