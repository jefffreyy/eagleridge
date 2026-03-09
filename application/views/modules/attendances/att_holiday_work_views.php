<html>
<?php $this->load->view('templates/css_link'); ?>
<style>
    .action_btn {
        display: flex !important;
        flex-direction: row !important;
        justify-content: center !important;
        align-items: center !important;
        margin: 0 auto;
        width: 100%;
    }
    .button-title {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        gap: 4px;
    }
    .image_profile::after {
  content: "";
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  width: 1px; /* Width of the vertical line */
  background-color: #000; /* Line color */
  border-left: 1px dashed #000; /* Dashed line style */
}

</style>
<?php
$this->load->library('session');

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
<?php
$search_data = $this->input->get('search');

$search_data = str_replace("_", " ", $search_data ?? '');
$company_data   = $this->input->get('company');
$branch_data    = $this->input->get('branch');
$dept_data      = $this->input->get('dept');
$div_data       = $this->input->get('div');
$section_data   = $this->input->get('section');
$group_data     = $this->input->get('group');
$team_data      = $this->input->get('team');
$line_data      = $this->input->get('line');
$id_prefix='HDW';
// $PAGE=1;
// $C_DATA_COUNT =0;
// $PAGES_COUNT=0;
$TAB='active';
$ACTIVES=0;
$INACTIVES=0;
// $ROW=25;

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
<html>
<body>
    <div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title"><a href="<?=base_url('attendances')?>"><i
              class="fa-duotone fa-circle-left"></i></a>&nbsp;Holiday Work<h1>
      </div>

      <div class="col-md-6 button-title">
        <!-- <a href="https://dev-env.eyebox.app/main_table_02/add_data?GnVsauFqMMl4sADKHhURs4nhFycg12iQnc&mbtvSype8qOqVzoJxLt4xrSqQHe0pTnsj5koCMN&WRpp+1u7ULutL&cctGpw+eJoEl0NMHQSy83Nd1FV7NMdiHWfkVCHes&GUvZnVqsN5UcqmooxFMbnvj6lO+4gyqfUGj6bgCQit0IRTKv0iukIBbsqTSfa6CXCtiVKCQSwQnzYyX5v26xaOwSm4&1wTdSQ4kBYVSJKyguU2PlzvfKMI6NEQAyUS6SvEmzx+jpGzxfnQeNf5CAmAz26lkaxpqH+S0PYF278&paCm75Q7efS3d+Atzcq4rSiRFS64q76vZjREh&aHFRxoJqgEtMJZLtBeOxL1fabrni&YkSA6ERdjzEImrXiehBpPUeJjRAWcAJwDKWAYE+bhoYSJVwqM91RuzVN47mrUX5mxRvlXJNWj2+IL2y+7JV0Ltg2DST3Nerdlx8ZoGRBW0B1wXQG6FIt5+RYZhgirwULGrMDKtl63whixWPf0P0U5g3G8vSvmj+1792RV1eWCgAOzKMo6mTQwo9ZZqBaT7WNC5s3+3S1ob&Kg348gGpgcV3T49a4+TXK4OOyJhyN6TGK6BbUBZJ6IQb9IbSgaVgXqfr5WqgBMGRW+esjQdqBOYjt6ehBhxYM7Vde4o9jA3bfquYzjVsUe4S1SDs+kibSMasrXhK+gXA02h5UPU2Crnl10ucHm&NBKb5ldgNgvWFYUmywiWNXgOkxgaTqQAYoE9Hbf6gLTp&b+QliJhKukVpeLYUpBIjJANVkhlcLBDBNvV+E40&bOIwEdF2CaXGaj9CtqPoTDjCiuVOz4vIhiTazxUtrgo37sqEqkBhhJjac6ofyq&5ze7Cixn3KYac7P2GPoAIIvw92+xEXV9v9VSI&UbAHFhMr08j1J4uwf0vM9i6G2hoFSpeqaph7jqscdaYl2AZAQp6VNBXDXwNvoh4zcpkLimHLHJOVzG6MeYkKmYfTef7mIvVuU2rdopDOS0Qsbb+Tqbbh0xyUPndvcEzIyLou91KDdrVG0&DkTmmXjOa&LyZCoTJos3oGHl9bacRidOJ+B3GWqv4QLaZKVFJ5CAL5ItVgqPpUkIQHybkblYatRAaodLdFjjDfifWGbh6LhabzUuNAqDlnnUceM7aQ370SBhr5Pb0z4Hj4QO3PpidPS0rIwtGJEEsP6ARqQCuk7TLlO168AM&WgkrH0NZHN+REvcdYfw49qwqCYI1sUqzBev9qWbq6VRfIKq&KAGMsE900dvgYFV4yzOlIMes0MkdkHbwixBKwTtCqXWx&om8XMfqhxE5ZYYrHen0vRt&QXjbEQ+i3yqeI3J7ylNp&W4OYlgQqKBJfNi8VYtKCMLkbDCSs&glqjzHR&LLN2RxcrvaQwuiKSLh0FlC+A+Wny6ErM3LPmyQjtaq3R867PZjAHacZ77+5Affqq8poFe9ZDJBWUmweP+paPZQEz586bU982gkJwa3Q+NDQSegxD8H7IRvyF&MTuOX7GzQe+RT&vLIz9yjM19nLjoqaQFWz0XZNogxzrUz4B+rr3gAP8uueySdK58fqhGv7o2zrBdn+cN5wC7mnwvOeniUXLsoExOxQOTBNLPBJzccZb9sg67wppI9rJECGK4ABOfDTHktghVySzbf5IlZljUIDM&eFgYQTPCHoPncG1hAT5FGuyMQHmfEsccfHCd32RsjUkRc+Oor57vzSNkqJSRXHPf73qmgE0YartR0haRB5mpYEvQ6uFC0fYyN0ru7StX39vDY8aszcDtp6jso9YZXSzGC1BQIoMbrweGrbf2KZt&cdMrRvq00Joyi5UVH4ZXxGNzroysP+e1Arf1tjEjsKGnnIpta7OQ8cLpX5mPrsejMS2FJ34mZitVjzl+dhY1FoX36rHhdOxEuv2q1WRvoWnwBM7yrpa4mkwsM6IFsveN8i18EmGDCTNNfpeRHQtZ3UMCeaD4BWjKhztOYpWN9M7ctCZqbVR00gQwsdr09tOaa5PqwS32f9wtOYCM88FaQ+ajhf669IO3JbbZzcD95OEtyR1XXbcYUFXJn4OCFevZkopBPjGyinAiswxI0vZYWVrpIe6AsmFd3pbtdTKKT9Tp82wkEXvyn&GBiBDJbjQ1XilbM8e1aiB+Gk0vpud1vmoiozbXx8FgK5aZU&rklW2JYuL2DzggB+AWJinU4TkHm&S5T46tkc+Wm8KicFCjtdbBJeGVWO451&d6d91Pj4HJJ4G4yJfy7mf56hJzO5ZKuXohejhQqQdRCVMWPNp79RC&EGsdpxY3c0N&XSpUl&u0ew6YRrkGatXY27P7rgMdPtauzWlsUPO2ZU1tZ+dmGHNuT1kwkFQ0kjXigdIYKhF63PAT&sHa9N2VM&HWgP6cJMolMoYyF+BCcUbOQptLQHfcdZnCgf9i8yZ1I5vCtXb9qkZ3SweAOSPGtaIgz49dUtZV2xQWAiVadUyvCtQ5XE+Iza5S1g7nL5kURRs1XWBHZq3kYkOnm4hdkhOHh&uUKYoZau32Z86shSxl3YkiJG3DrGU67Qo3ItWhFTVvRMRTrgZDVXoi6AsCDs5hpYYd91cOSZAfzVoe9khEVYtzEt05iHuyYsQrAhVdzCLWETUWBU3o14+TKTkQ3buDBADNBvPTWuHKAbJXAKIcDiUuSfqrrXFk9GqX5W&PJ682iw7eoh3oA05hkEvX4MM4s3Jz7CX9DyGfGqv3GpQ71xztQAtZmdeWKw2F9ssFZkQE9ZwOhsJ6Yg0Cuxv&LMbdqqHJxrcabCxrW8ckHwYaM266JZ9hDXVyrmvIjaZNcdd&a7&rQGdwxVxCUiOFtbCerxEUeS&LuIOak2sfuDzcOIFNPaNThBU8tahVKrAkkPdSlCPHPwLG1GD6T6C6op1yYNtYLzAio7MqjZrBeajbP4p1fwWOWh3rB8dsF894nfvmbhUVFIGMIC5eFxh6FyQ+OjGSWLFYq8IKunSd79GzHOfk9HsiDidx6bTAJHsRhuunkCQ5mxd0LUNsYbiFdGctQ10d1giy034tAu9fD62neFcEwFWpYIuVpIJ6Xd3zMXaqHhtHKS7jp1PoLSl2xYeyxDTMFYiAPLY+aEmANvPt2bkmHQzcz3WPps8oXWKEbXluxPfidrml3M8QFJOcbK++ral08dCP+N2iVc4YdM1DtQpUkkUuR99MGHFaV7pcwBwp4d2bWjZroyVDhvDY2pzWRTX&hmpgjb3SibZKfL3Suu5UpeYuJHlsuWCB7E+K7lB1Xqe6+F+WLnhpZ&pDhOKVX6oOeELZtMyf3weHH&CxY4qiseXBD5BNsqM0Y&YKvTDi5nnp&o1ju7MdjXrUSnr9JA8EahUlDp9X&nFJ&jMh+lD3qfIfFPqJHZwKmWSV7bDrwZ3JQ35f+hfey3cWRPZwoCQS&ssf2KAhkXwEqmBkuW&LR+VoOg1&Si4hSAIFijnhAGytZwuiDZ&8f2DXU3NLKgIMIHNlVqwfq88zFSQ2iy7cTh1BIxI1&w4k6IgkbfYf3SaH2FMlu1dWWmij6ZM8IBknB3ojw8zYwcqi71vnvlLcqbBJVPXMwgGBWZKGLHjmMI47DBg0Y4GC1xJZeXcoXgh&&SINasDqMjfmojEg6x5li1tJVeIoVK5Nv297S1fVmDj3gCK6dLeWbVBmmUEDRJ4nJRWv&xRpzH71G8AuAtNrIu7SUUq1MjjCefm9LBaJTAQqTLwnzsoMogi9FudM9COYj7H8TxvezaPeW&pNvibDQWYPcXHD+xDl5LFaFVc6qTwwQsbfTH&iNcjCOB9LuOM&bHbpKknsygu&I5eZozXWxCIXf10XWXycljCLnaN5KIfg6+VFImERVzOUJFm&8lIO5B4XOlsnzFa44dAs9YPSaODE1sE+j5E0VYQ&QBnjgipqLVIA7DdCdl3ePcPHsm6WWok41Mgtbr&Z2voVIxr2Q29sBojhlZ0CQCeRvu8DJ71WvyB0C7gWbmbgtdUe4BwL+VBtRAaNpkQgL8iSb9tfZa9TLhFREdp9mEst6PC&RJHbRBczJotu7p7kWrDrUTfTrlBQGyYSbxDR1kaR3p2iTZv+H7foclvkH6JkUyoCarZjimMALyIZSbTg8lhD6mW+&C5IBSvEGM3w1+46cRsLeUGwbWV6inRRe8U99CR5NbBst3Iu78QjW6SAswPSmnyedzKw6gGDX45ikK7uXXo+VyHNoEg&D5jhT3EHo&sL8wykAa+kIwTghGgbW218Mt9TMp+LhKLTHJy+0&sKRUUrMYd1zLUCLW+hGZ3ldZExuUs6BWRxsLKMFB7oyfGSu&wIPRc7Lyo2Smn2X2CemcfnxEx0dU7ih2n6LuYsxUyof4c3l9xChjt6f2z1eeMWBvEYY+EyLMdlJFmBfXF1sDsd8FJBdGLYZ+POvSEiadqw51VpRoQSxGJDAVT4wafb9QIcpKJSJsy+uIAMutQvtUmHUvH&8GlPQlXjfkNysuc4EdXyhSnhiectMxDk24gr7bY+6neBXt9vZNmgfyUjUJZz9WTeoac78RktX+YiIC6CF5lCTa&qqzebyUpqNovA9zs8FFI3aqk2r2hPcyNiwNJGWrjop7gvzcKLkXJCr7rh&3t6tK1mPJHle8oJcyyPWco&1CAnV4g2IgttmTUnde2dwFeS5T1hiTCAV9JuFJC&+yJjiHG3brhy5TN5XELn6hB2XSgQtmVMUdW71ADRo6ElOac0Pd&NVZP&1RkWP9dCxLilxr4DWq4gC23WgIfON0qCrQ4EF7pkqzgXUZwW2UbVAv3ua2yVBUhVbADAV3PUeVExtR6H0z01G8LtOlbEtYVVNVd8QpYtQzLCFJQnsJTFStbLuiOEWTO+n6KUcVbgdwmwI+s3p7DoXvFQ2BZ&jkKbMJylMDdgqeyHwRhpKxoQkL3SUFrUhkAUQM+jLd2YWA=" id="btn_application" class=" btn technos-button-green shadow-none rounded" ><i class="fas fa-plus"></i>&nbsp;Add Request</a> -->

        <!--<form action="https://dev-env.eyebox.app/main_table_02/add_data" method="post" >-->
        <!--    <input type="text" name="add_encrypted_data" value="GnVsauFqMMl4sADKHhURs4nhFycg12iQnc&mbtvSype8qOqVzoJxLt4xrSqQHe0pTnsj5koCMN&WRpp+1u7ULutL&cctGpw+eJoEl0NMHQSy83Nd1FV7NMdiHWfkVCHes&GUvZnVqsN5UcqmooxFMbnvj6lO+4gyqfUGj6bgCQit0IRTKv0iukIBbsqTSfa6CXCtiVKCQSwQnzYyX5v26xaOwSm4&1wTdSQ4kBYVSJKyguU2PlzvfKMI6NEQAyUS6SvEmzx+jpGzxfnQeNf5CAmAz26lkaxpqH+S0PYF278&paCm75Q7efS3d+Atzcq4rSiRFS64q76vZjREh&aHFRxoJqgEtMJZLtBeOxL1fabrni&YkSA6ERdjzEImrXiehBpPUeJjRAWcAJwDKWAYE+bhoYSJVwqM91RuzVN47mrUX5mxRvlXJNWj2+IL2y+7JV0Ltg2DST3Nerdlx8ZoGRBW0B1wXQG6FIt5+RYZhgirwULGrMDKtl63whixWPf0P0U5g3G8vSvmj+1792RV1eWCgAOzKMo6mTQwo9ZZqBaT7WNC5s3+3S1ob&Kg348gGpgcV3T49a4+TXK4OOyJhyN6TGK6BbUBZJ6IQb9IbSgaVgXqfr5WqgBMGRW+esjQdqBOYjt6ehBhxYM7Vde4o9jA3bfquYzjVsUe4S1SDs+kibSMasrXhK+gXA02h5UPU2Crnl10ucHm&NBKb5ldgNgvWFYUmywiWNXgOkxgaTqQAYoE9Hbf6gLTp&b+QliJhKukVpeLYUpBIjJANVkhlcLBDBNvV+E40&bOIwEdF2CaXGaj9CtqPoTDjCiuVOz4vIhiTazxUtrgo37sqEqkBhhJjac6ofyq&5ze7Cixn3KYac7P2GPoAIIvw92+xEXV9v9VSI&UbAHFhMr08j1J4uwf0vM9i6G2hoFSpeqaph7jqscdaYl2AZAQp6VNBXDXwNvoh4zcpkLimHLHJOVzG6MeYkKmYfTef7mIvVuU2rdopDOS0Qsbb+Tqbbh0xyUPndvcEzIyLou91KDdrVG0&DkTmmXjOa&LyZCoTJos3oGHl9bacRidOJ+B3GWqv4QLaZKVFJ5CAL5ItVgqPpUkIQHybkblYatRAaodLdFjjDfifWGbh6LhabzUuNAqDlnnUceM7aQ370SBhr5Pb0z4Hj4QO3PpidPS0rIwtGJEEsP6ARqQCuk7TLlO168AM&WgkrH0NZHN+REvcdYfw49qwqCYI1sUqzBev9qWbq6VRfIKq&KAGMsE900dvgYFV4yzOlIMes0MkdkHbwixBKwTtCqXWx&om8XMfqhxE5ZYYrHen0vRt&QXjbEQ+i3yqeI3J7ylNp&W4OYlgQqKBJfNi8VYtKCMLkbDCSs&glqjzHR&LLN2RxcrvaQwuiKSLh0FlC+A+Wny6ErM3LPmyQjtaq3R867PZjAHacZ77+5Affqq8poFe9ZDJBWUmweP+paPZQEz586bU982gkJwa3Q+NDQSegxD8H7IRvyF&MTuOX7GzQe+RT&vLIz9yjM19nLjoqaQFWz0XZNogxzrUz4B+rr3gAP8uueySdK58fqhGv7o2zrBdn+cN5wC7mnwvOeniUXLsoExOxQOTBNLPBJzccZb9sg67wppI9rJECGK4ABOfDTHktghVySzbf5IlZljUIDM&eFgYQTPCHoPncG1hAT5FGuyMQHmfEsccfHCd32RsjUkRc+Oor57vzSNkqJSRXHPf73qmgE0YartR0haRB5mpYEvQ6uFC0fYyN0ru7StX39vDY8aszcDtp6jso9YZXSzGC1BQIoMbrweGrbf2KZt&cdMrRvq00Joyi5UVH4ZXxGNzroysP+e1Arf1tjEjsKGnnIpta7OQ8cLpX5mPrsejMS2FJ34mZitVjzl+dhY1FoX36rHhdOxEuv2q1WRvoWnwBM7yrpa4mkwsM6IFsveN8i18EmGDCTNNfpeRHQtZ3UMCeaD4BWjKhztOYpWN9M7ctCZqbVR00gQwsdr09tOaa5PqwS32f9wtOYCM88FaQ+ajhf669IO3JbbZzcD95OEtyR1XXbcYUFXJn4OCFevZkopBPjGyinAiswxI0vZYWVrpIe6AsmFd3pbtdTKKT9Tp82wkEXvyn&GBiBDJbjQ1XilbM8e1aiB+Gk0vpud1vmoiozbXx8FgK5aZU&rklW2JYuL2DzggB+AWJinU4TkHm&S5T46tkc+Wm8KicFCjtdbBJeGVWO451&d6d91Pj4HJJ4G4yJfy7mf56hJzO5ZKuXohejhQqQdRCVMWPNp79RC&EGsdpxY3c0N&XSpUl&u0ew6YRrkGatXY27P7rgMdPtauzWlsUPO2ZU1tZ+dmGHNuT1kwkFQ0kjXigdIYKhF63PAT&sHa9N2VM&HWgP6cJMolMoYyF+BCcUbOQptLQHfcdZnCgf9i8yZ1I5vCtXb9qkZ3SweAOSPGtaIgz49dUtZV2xQWAiVadUyvCtQ5XE+Iza5S1g7nL5kURRs1XWBHZq3kYkOnm4hdkhOHh&uUKYoZau32Z86shSxl3YkiJG3DrGU67Qo3ItWhFTVvRMRTrgZDVXoi6AsCDs5hpYYd91cOSZAfzVoe9khEVYtzEt05iHuyYsQrAhVdzCLWETUWBU3o14+TKTkQ3buDBADNBvPTWuHKAbJXAKIcDiUuSfqrrXFk9GqX5W&PJ682iw7eoh3oA05hkEvX4MM4s3Jz7CX9DyGfGqv3GpQ71xztQAtZmdeWKw2F9ssFZkQE9ZwOhsJ6Yg0Cuxv&LMbdqqHJxrcabCxrW8ckHwYaM266JZ9hDXVyrmvIjaZNcdd&a7&rQGdwxVxCUiOFtbCerxEUeS&LuIOak2sfuDzcOIFNPaNThBU8tahVKrAkkPdSlCPHPwLG1GD6T6C6op1yYNtYLzAio7MqjZrBeajbP4p1fwWOWh3rB8dsF894nfvmbhUVFIGMIC5eFxh6FyQ+OjGSWLFYq8IKunSd79GzHOfk9HsiDidx6bTAJHsRhuunkCQ5mxd0LUNsYbiFdGctQ10d1giy034tAu9fD62neFcEwFWpYIuVpIJ6Xd3zMXaqHhtHKS7jp1PoLSl2xYeyxDTMFYiAPLY+aEmANvPt2bkmHQzcz3WPps8oXWKEbXluxPfidrml3M8QFJOcbK++ral08dCP+N2iVc4YdM1DtQpUkkUuR99MGHFaV7pcwBwp4d2bWjZroyVDhvDY2pzWRTX&hmpgjb3SibZKfL3Suu5UpeYuJHlsuWCB7E+K7lB1Xqe6+F+WLnhpZ&pDhOKVX6oOeELZtMyf3weHH&CxY4qiseXBD5BNsqM0Y&YKvTDi5nnp&o1ju7MdjXrUSnr9JA8EahUlDp9X&nFJ&jMh+lD3qfIfFPqJHZwKmWSV7bDrwZ3JQ35f+hfey3cWRPZwoCQS&ssf2KAhkXwEqmBkuW&LR+VoOg1&Si4hSAIFijnhAGytZwuiDZ&8f2DXU3NLKgIMIHNlVqwfq88zFSQ2iy7cTh1BIxI1&w4k6IgkbfYf3SaH2FMlu1dWWmij6ZM8IBknB3ojw8zYwcqi71vnvlLcqbBJVPXMwgGBWZKGLHjmMI47DBg0Y4GC1xJZeXcoXgh&&SINasDqMjfmojEg6x5li1tJVeIoVK5Nv297S1fVmDj3gCK6dLeWbVBmmUEDRJ4nJRWv&xRpzH71G8AuAtNrIu7SUUq1MjjCefm9LBaJTAQqTLwnzsoMogi9FudM9COYj7H8TxvezaPeW&pNvibDQWYPcXHD+xDl5LFaFVc6qTwwQsbfTH&iNcjCOB9LuOM&bHbpKknsygu&I5eZozXWxCIXf10XWXycljCLnaN5KIfg6+VFImERVzOUJFm&8lIO5B4XOlsnzFa44dAs9YPSaODE1sE+j5E0VYQ&QBnjgipqLVIA7DdCdl3ePcPHsm6WWok41Mgtbr&Z2voVIxr2Q29sBojhlZ0CQCeRvu8DJ71WvyB0C7gWbmbgtdUe4BwL+VBtRAaNpkQgL8iSb9tfZa9TLhFREdp9mEst6PC&RJHbRBczJotu7p7kWrDrUTfTrlBQGyYSbxDR1kaR3p2iTZv+H7foclvkH6JkUyoCarZjimMALyIZSbTg8lhD6mW+&C5IBSvEGM3w1+46cRsLeUGwbWV6inRRe8U99CR5NbBst3Iu78QjW6SAswPSmnyedzKw6gGDX45ikK7uXXo+VyHNoEg&D5jhT3EHo&sL8wykAa+kIwTghGgbW218Mt9TMp+LhKLTHJy+0&sKRUUrMYd1zLUCLW+hGZ3ldZExuUs6BWRxsLKMFB7oyfGSu&wIPRc7Lyo2Smn2X2CemcfnxEx0dU7ih2n6LuYsxUyof4c3l9xChjt6f2z1eeMWBvEYY+EyLMdlJFmBfXF1sDsd8FJBdGLYZ+POvSEiadqw51VpRoQSxGJDAVT4wafb9QIcpKJSJsy+uIAMutQvtUmHUvH&8GlPQlXjfkNysuc4EdXyhSnhiectMxDk24gr7bY+6neBXt9vZNmgfyUjUJZz9WTeoac78RktX+YiIC6CF5lCTa&qqzebyUpqNovA9zs8FFI3aqk2r2hPcyNiwNJGWrjop7gvzcKLkXJCr7rh&3t6tK1mPJHle8oJcyyPWco&1CAnV4g2IgttmTUnde2dwFeS5T1hiTCAV9JuFJC&+yJjiHG3brhy5TN5XELn6hB2XSgQtmVMUdW71ADRo6ElOac0Pd&NVZP&1RkWP9dCxLilxr4DWq4gC23WgIfON0qCrQ4EF7pkqzgXUZwW2UbVAv3ua2yVBUhVbADAV3PUeVExtR6H0z01G8LtOlbEtYVVNVd8QpYtQzLCFJQnsJTFStbLuiOEWTO+n6KUcVbgdwmwI+s3p7DoXvFQ2BZ&jkKbMJylMDdgqeyHwRhpKxoQkL3SUFrUhkAUQM+jLd2YWA=" hidden>-->
        <!--    <button type="submit"  class=" btn technos-button-green shadow-none rounded"  ><i class="fas fa-plus"></i>&nbsp;Add Request</button>-->
        <!--</form>-->
        <a href="<?=base_url('attendances/request_holiday_work')?>"
          class=" btn technos-button-green shadow-none rounded"><i class="fas fa-plus"></i>&nbsp;Add Request</a>
        <a id="btn_export" class=" btn technos-button-gray shadow-none rounded"><i
            class="fas fa-file-export"></i>&nbsp;Export XLSX</a>


      </div>
    </div>
    <div class="row mb-4 mt-5">
        <div class="col-md-2">
            <p class="mb-1 text-secondary ">Company</p>
            <select name="dept" id="filter_by_company" class="filter_select form-control">
                <option value="">All Companies</option>
<?php foreach($COMPANIES as $row_data) : ?>
                <option value="<?=$row_data->id?>" <?=$company_data==$row_data->id ?'selected': '' ?> ><?=$row_data->name?></option>
<?php endforeach ?>
            </select>
        </div>
        <div class="col-md-2">
            <p class="mb-1 text-secondary ">Branch</p>
            <select name="dept" id="filter_by_branch" class="filter_select form-control">
                <option value="">All Branches</option>
<?php foreach($BRANCHES as $row_data) : ?>
                <option value="<?=$row_data->id?>" <?=$branch_data==$row_data->id ?'selected': '' ?>><?=$row_data->name?></option>
<?php endforeach ?>
            </select>
        </div>
        <div class="col-md-2">
            <p class="mb-1 text-secondary ">Department</p>
            <select name="dept" id="filter_by_department" class="filter_select form-control">
                <option value="">All Departments</option>
<?php foreach($DEPARTMENTS as $row_data) : ?>
                <option value="<?=$row_data->id?>" <?=$dept_data==$row_data->id ?'selected': '' ?>><?=$row_data->name?></option>
<?php endforeach ?>
            </select>
        </div>
        <div class="col-md-2">
            <p class="mb-1 text-secondary ">Division</p>
            <select name="dept" id="filter_by_division" class="filter_select form-control">
                <option value="">All Divisions</option>
<?php foreach($DIVISIONS as $row_data) : ?>
                <option value="<?=$row_data->id?>" <?=$div_data==$row_data->id ?'selected': '' ?>><?=$row_data->name?></option>
<?php endforeach ?>
            </select>
        </div>
        <div class="col-md-2">
            <p class="mb-1 text-secondary ">Section</p>
            <select name="section" id="filter_by_section" class="filter_select form-control">
                <option value="">All Sections</option>
<?php foreach($SECTIONS as $row_data) : ?>
                <option value="<?=$row_data->id?>" <?=$section_data==$row_data->id ?'selected': '' ?>><?=$row_data->name?></option>
<?php endforeach ?>
            </select>
        </div>
        <div class="col-md-2">
            <p class="mb-1 text-secondary ">Group</p>
            <select name="group" id="filter_by_group" class="filter_select form-control">
                <option value="">All Groups</option>
<?php foreach($GROUPS as $row_data) : ?>
                <option value="<?=$row_data->id?>" <?=$group_data==$row_data->id ?'selected': '' ?>><?=$row_data->name?></option>
<?php endforeach ?>
            </select>
        </div>
        <div class="col-md-2">
            <p class="mb-1 text-secondary ">Team</p>
            <select name="dept" id="filter_by_team" class="filter_select form-control">
                <option value="">All Teams</option>
<?php foreach($TEAMS as $row_data) : ?>
                <option value="<?=$row_data->id?>" <?=$team_data==$row_data->id ?'selected': '' ?>><?=$row_data->name?></option>
<?php endforeach ?>
            </select>
        </div>
        <div class="col-md-2">
            <p class="mb-1 text-secondary ">Line</p>
            <select name="line" id="filter_by_line" class="filter_select form-control">
                <option value="">All Lines</option>
<?php foreach($LINES as $row_data) : ?>
                <option value="<?=$row_data->id?>" <?=$line_data==$row_data->id ?'selected': '' ?>><?=$row_data->name?></option>
<?php endforeach ?>
            </select>
        </div>
        <div class="col-md-2">
            <p class="mb-1 text-secondary ">Action</p>
            <a href="<?=base_url('attendances/holiday_work')?>" id="btn_clear_filter"
                class="col btn btn-secondary mx-1">Clear Filter</a>
        </div>

    </div> <!-- filter divs ends -->
     <div class=" py-3 w-25">
        <p class="mb-1 text-secondary ">Status</p>
        <select class="form-control leave_status">
            <option value="">All</option>
<?php foreach($STATUSES as $status) { ?>
            <option value="<?=$status?>" <?= $status==$STATUS ? 'selected' : '' ?>><?=$status?></option>
<?php } ?>
        </select>
    </div>
    <div class="card border-0 p-0 m-0">
      <div class="card border-0 p-1 m-0">
        <div class="card-header p-0">
          <div class="row">
            <div class="col-xl-8">
              <!--<ul class="nav nav-tabs">-->
              <!--  <li class="nav-item">-->
              <!--    <a class="nav-link head-tab  active" id="tab-Pending 1"-->
              <!--      href="?page=1&row=25&tab=Pending 1&tab_filter=status">Pending 1<span-->
              <!--        class="ml-2 badge badge-pill badge-secondary">2</span></a>-->
              <!--  </li>-->
              <!--  <li class="nav-item">-->
              <!--    <a class="nav-link head-tab " id="tab-Pending 2"-->
              <!--      href="?page=1&row=25&tab=Pending 2&tab_filter=status">Pending 2<span-->
              <!--        class="ml-2 badge badge-pill badge-secondary">1</span></a>-->
              <!--  </li>-->
              <!--  <li class="nav-item">-->
              <!--    <a class="nav-link head-tab " id="tab-Pending 3"-->
              <!--      href="?page=1&row=25&tab=Pending 3&tab_filter=status">Pending 3<span-->
              <!--        class="ml-2 badge badge-pill badge-secondary">0</span></a>-->
              <!--  </li>-->
              <!--  <li class="nav-item">-->
              <!--    <a class="nav-link head-tab " id="tab-Approved"-->
              <!--      href="?page=1&row=25&tab=Approved&tab_filter=status">Approved<span-->
              <!--        class="ml-2 badge badge-pill badge-secondary">2</span></a>-->
              <!--  </li>-->
              <!--  <li class="nav-item">-->
              <!--    <a class="nav-link head-tab " id="tab-Rejected"-->
              <!--      href="?page=1&row=25&tab=Rejected&tab_filter=status">Rejected<span-->
              <!--        class="ml-2 badge badge-pill badge-secondary">0</span></a>-->
              <!--  </li>-->

              <!--</ul>-->
            </div>
            <div class="col-xl-4">
              <div class="input-group pb-1 ">
                <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i
                    class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>

                <input type="text" class="form-control" placeholder="Search" value="<?=$search_data?>" id="search_data"
                  aria-label="Username" aria-describedby="basic-addon1">
              </div>
            </div>
          </div>
        </div>

        <div class="p-2">
          <div>

            <!-- <button id="btn_application"    class=" btn technos-button-gray shadow-none rounded" data-toggle="modal" data-target="#modal_insert"  ><i class="far fa-trash-alt"></i>&nbsp;Delete</button> -->
            <div class="float-right ">
              <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
              <ul class="d-inline pagination m-0 p-0 ">
                <li ><a  <?php if ($current_page > 1) echo " class='paginate' href='?page=$prev_page&row=$row&search=$search_data'"; ?>>
                    < </a>
                </li>
                <li><a class="paginate" href="?status=<?=$STATUS?>&page=1&row=<?= $row ?>&search=<?=$search_data?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                <li><a class="paginate" href="?status=<?=$STATUS?>&page=<?= $current_page - 1 ?>&row=<?= $row ?>&search=<?=$search_data?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                <li><a class="paginate" href="?status=<?=$STATUS?>&page=<?= $current_page + 1 ?>&row=<?= $row ?>&search=<?=$search_data?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                <li><a class="paginate" href="?status=<?=$STATUS?>&page=<?= $last_page ?>&row=<?= $row ?>&search=<?=$search_data?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                <li><a  style="margin-right: 10px;" <?php if ($current_page < $last_page) echo "class='paginate'  href='?status=$STATUS&page=$next_page&row=$row&search=$search_data'"; ?>>> </a></li>
              </ul>
              <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
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

          <table class="table table-bordered m-0" id="table_main" style="width:100%">
            <thead>
              <th class="text-center" >ID</th>
              <th class="text-center" >Assigned By</th>
              <th class="text-center" >Employee</th>
              <th class="text-center">Type</th>
              <th class="text-center">Shift Date</th>
              <th class="text-center">Overtime Hours</th>
              <th class="text-center">Reason</th>
              <th class="text-center">Status</th>
              <th class="text-center">Remarks</th>
              <th class="text-center">Action</th>
            </thead>
            <tbody id="tbl_application_container">
<?php if($TABLE_DATA) {  ?>
    <?php foreach($TABLE_DATA as $row_data) { ?>
              <tr >
                <td><?= $id_prefix . str_pad($row_data->id, 5 , '0', STR_PAD_LEFT)?></td>
                <td class="text-center" ><?=$row_data->assigned_by?></td>
                <td class="text-center" ><?=$row_data->employee?></td>
                <td class="text-center" ><?=$row_data->type?></td>
                <td class="text-center" ><?=date_format(date_create($row_data->date),'d/m/Y')?></td>
                <td class="text-center" ><?=$row_data->hours?></td>
                <td class="text-center"><?=$row_data->reason?></td>
                <td class="text-center">
<?php
    if($row_data->status == "Approved") { ?>
                  <div class=' technos-button-green p-2 rounded disabled m-auto' style="width:100px"><?=$row_data->status?></div>
<?php }
    elseif($row_data->status == "Rejected") { ?>
                  <div class='bg-danger p-2 rounded disabled m-auto'  style="width:100px"><?=$row_data->status?></div>
<?php }
    elseif($row_data->status == "Withdrawed"){ ?>
                  <div class='bg-secondary p-2 rounded disabled m-auto' style="width:100px"><?=$row_data->status?></div>
<?php }
    else{ ?>
                  <div class='bg-warning  p-2 rounded disabled m-auto' style="width:100px">Pending</div>
<?php } ?>
                </td>
                <td class="text-center"><?= $row_data->comment ?></td>
                <td class="text-center">
                   <a class = "select_row p-2"  style ="color: gray; cursor: pointer; !important"  row_id="56" data-id="<?=$row_data->id?>"  data-toggle="modal" data-target="#modal_approval">
                        <i class="far fa-eye"></i></a>
<?php if($row_data->status=='Pending 1' || $row_data->status=='Pending 2' || $row_data->status=='Pending 3' ) : ?>
                   <a class = "select_edit_row p-2 edit_data_id"  href="<?=base_url('attendances/edit_holiday_work/'.$row_data->id)?>"  style ="color: gray; cursor: pointer; !important" row_id="56">
                        <i class="far fa-edit" id="edit"></i></a> 
<?php endif ?>
                </td>
              </tr>
    <?php } ?>
<?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>




<!-- Set SSA -->
<div class="modal fade" id="modal_approval" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" id="approval_modal_content">
  </div>
</div>
    <?php $this->load->view('templates/jquery_link'); ?>
    <?php
    if ($this->session->userdata('success')) {
    ?>
        <script>Swal.fire('<?php echo $this->session->userdata('success'); ?>','','success')</script>
    <?php $this->session->unset_userdata('success');
    }
    ?>
    <?php
    if ($this->session->flashdata('SUCC')) {
    ?>
        <script>Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>','','success')</script>
    <?php 
    }
    ?>
    <?php
    if ($this->session->flashdata('ERR')) {
    ?>
        <script>Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>',
                '',
                'error'
            )
        </script>
    <?php
    }
    ?>
    <script>
        $(document).ready(function() {
            
            $('#modal_approval').on('show.bs.modal', function (e) {
                var button      = $(e.relatedTarget); 
                var id    = button.data('id');
                $.get("<?=base_url('selfservices/get_holiday_work_status')?>"+'/'+id,function(res){
                 $('#approval_modal_content').html(res)
                })
                // fetch()
                // .then(res=>res)
                // .then(data=>{
                //     console.log(data)
                // })
            });
            $('#search_btn').on('click',function(){
                reloadPage();
            })
            $('a.paginate').on('click',function(){
                var status      = $('.leave_status').val();
                var row         = $('#row_dropdown').val();
                var page        = "<?=$PAGE?>";
                var search      = $('#search_data').val();
                var company     = $('#filter_by_company').val();
                var branch      = $('#filter_by_branch').val();
                var department  = $('#filter_by_department').val();
                var division    = $('#filter_by_division').val();
                var section     = $('#filter_by_section').val();
                var group       = $('#filter_by_group').val();
                var team        = $('#filter_by_team').val();
                var line        = $('#filter_by_line').val();
                var filter_url  = '&company='+company+'&branch='+branch+'&dept='+department+'&div='+division+'&section='+section+'&group='+group+'&team='+team+'&line='+line;
                window.location.href="<?=base_url('attendances/holiday_work')?>"+$(this).attr('href')+filter_url;
                return false;
            })
            
            $('.leave_status,#row_dropdown').on('change',function(){
                reloadPage();
            })
            $('.filter_select').on('change',function(){
                reloadPage()
            })
            function reloadPage(){
                var status      = $('.leave_status').val();
                var row         = $('#row_dropdown').val();
                var page        = "<?=$PAGE?>";
                var search      = $('#search_data').val();
                var company     = $('#filter_by_company').val();
                var branch      = $('#filter_by_branch').val();
                var department  = $('#filter_by_department').val();
                var division    = $('#filter_by_division').val();
                var section     = $('#filter_by_section').val();
                var group       = $('#filter_by_group').val();
                var team        = $('#filter_by_team').val();
                var line        = $('#filter_by_line').val();
                var filter_url  = '&company='+company+'&branch='+branch+'&dept='+department+'&div='+division+'&section='+section+'&group='+group+'&team='+team+'&line='+line;
                window.location.href="<?=base_url('attendances/holiday_work')?>"+"?status="+status+"&page="+page+"&row="+row+'&search='+search+filter_url;
            }
        })
    </script>
    <!-------------------- Export ----------------->
    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <script>
        document.getElementById("btn_export").addEventListener('click', function() {
            /* Create worksheet from HTML DOM TABLE */
            var wb = XLSX.utils.table_to_book(document.getElementById("table_main"));
            /* Export to file (start a download) */
            XLSX.writeFile(wb, "<?php echo 'holiday_work_list.xlsx'?>");
        });
    </script>
</body>
</html>