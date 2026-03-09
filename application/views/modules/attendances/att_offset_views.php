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
    width: 1px;
    /* Width of the vertical line */
    background-color: #000;
    /* Line color */
    border-left: 1px dashed #000;
    /* Dashed line style */
  }
</style>
<style>
  .hover {
    cursor: pointer;
  }

  .img-circle {
    border-radius: 50% !important;
    width: 100px !important;
    height: 100px !important;
    object-fit: scale-down;
  }
</style>
<?php
$this->load->library('session');

$url_count          = $this->uri->total_segments();
$url_directory      = $this->uri->segment($url_count);
function technos_encrypt($input)
{
  $ciphering = "AES-128-CTR";
  $iv_length = openssl_cipher_iv_length($ciphering);
  $options = 0;
  $encryption_iv = '6234564891013126';
  $encryption_key = "Technos";
  $result_raw = openssl_encrypt($input, $ciphering, $encryption_key, $options, $encryption_iv);
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
$clubhouse_data = $this->input->get('clubhouse');
$section_data   = $this->input->get('section');
$group_data     = $this->input->get('group');
$team_data      = $this->input->get('team');
$line_data      = $this->input->get('line');
$id_prefix = 'OFF';
// $PAGE=1;
// $C_DATA_COUNT =0;
// $PAGES_COUNT=0;
$TAB = 'active';
$ACTIVES = 0;
$INACTIVES = 0;
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
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url('attendances') ?>">Offsets</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Offset Requests </li>
        </ol>
      </nav>
      <div class="row pt-1">
        <div class="col-md-6">
          <h1 class="page-title d-flex align-items-center"><a href="<?= base_url('attendances') ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
              </i></a>&nbsp;Offset Requests<h1>
        </div>

        <div class="col-md-6 button-title">
          <!-- <a href="https://dev-env.eyebox.app/main_table_02/add_data?GnVsauFqMMl4sADKHhURs4nhFycg12iQnc&mbtvSype8qOqVzoJxLt4xrSqQHe0pTnsj5koCMN&WRpp+1u7ULutL&cctGpw+eJoEl0NMHQSy83Nd1FV7NMdiHWfkVCHes&GUvZnVqsN5UcqmooxFMbnvj6lO+4gyqfUGj6bgCQit0IRTKv0iukIBbsqTSfa6CXCtiVKCQSwQnzYyX5v26xaOwSm4&1wTdSQ4kBYVSJKyguU2PlzvfKMI6NEQAyUS6SvEmzx+jpGzxfnQeNf5CAmAz26lkaxpqH+S0PYF278&paCm75Q7efS3d+Atzcq4rSiRFS64q76vZjREh&aHFRxoJqgEtMJZLtBeOxL1fabrni&YkSA6ERdjzEImrXiehBpPUeJjRAWcAJwDKWAYE+bhoYSJVwqM91RuzVN47mrUX5mxRvlXJNWj2+IL2y+7JV0Ltg2DST3Nerdlx8ZoGRBW0B1wXQG6FIt5+RYZhgirwULGrMDKtl63whixWPf0P0U5g3G8vSvmj+1792RV1eWCgAOzKMo6mTQwo9ZZqBaT7WNC5s3+3S1ob&Kg348gGpgcV3T49a4+TXK4OOyJhyN6TGK6BbUBZJ6IQb9IbSgaVgXqfr5WqgBMGRW+esjQdqBOYjt6ehBhxYM7Vde4o9jA3bfquYzjVsUe4S1SDs+kibSMasrXhK+gXA02h5UPU2Crnl10ucHm&NBKb5ldgNgvWFYUmywiWNXgOkxgaTqQAYoE9Hbf6gLTp&b+QliJhKukVpeLYUpBIjJANVkhlcLBDBNvV+E40&bOIwEdF2CaXGaj9CtqPoTDjCiuVOz4vIhiTazxUtrgo37sqEqkBhhJjac6ofyq&5ze7Cixn3KYac7P2GPoAIIvw92+xEXV9v9VSI&UbAHFhMr08j1J4uwf0vM9i6G2hoFSpeqaph7jqscdaYl2AZAQp6VNBXDXwNvoh4zcpkLimHLHJOVzG6MeYkKmYfTef7mIvVuU2rdopDOS0Qsbb+Tqbbh0xyUPndvcEzIyLou91KDdrVG0&DkTmmXjOa&LyZCoTJos3oGHl9bacRidOJ+B3GWqv4QLaZKVFJ5CAL5ItVgqPpUkIQHybkblYatRAaodLdFjjDfifWGbh6LhabzUuNAqDlnnUceM7aQ370SBhr5Pb0z4Hj4QO3PpidPS0rIwtGJEEsP6ARqQCuk7TLlO168AM&WgkrH0NZHN+REvcdYfw49qwqCYI1sUqzBev9qWbq6VRfIKq&KAGMsE900dvgYFV4yzOlIMes0MkdkHbwixBKwTtCqXWx&om8XMfqhxE5ZYYrHen0vRt&QXjbEQ+i3yqeI3J7ylNp&W4OYlgQqKBJfNi8VYtKCMLkbDCSs&glqjzHR&LLN2RxcrvaQwuiKSLh0FlC+A+Wny6ErM3LPmyQjtaq3R867PZjAHacZ77+5Affqq8poFe9ZDJBWUmweP+paPZQEz586bU982gkJwa3Q+NDQSegxD8H7IRvyF&MTuOX7GzQe+RT&vLIz9yjM19nLjoqaQFWz0XZNogxzrUz4B+rr3gAP8uueySdK58fqhGv7o2zrBdn+cN5wC7mnwvOeniUXLsoExOxQOTBNLPBJzccZb9sg67wppI9rJECGK4ABOfDTHktghVySzbf5IlZljUIDM&eFgYQTPCHoPncG1hAT5FGuyMQHmfEsccfHCd32RsjUkRc+Oor57vzSNkqJSRXHPf73qmgE0YartR0haRB5mpYEvQ6uFC0fYyN0ru7StX39vDY8aszcDtp6jso9YZXSzGC1BQIoMbrweGrbf2KZt&cdMrRvq00Joyi5UVH4ZXxGNzroysP+e1Arf1tjEjsKGnnIpta7OQ8cLpX5mPrsejMS2FJ34mZitVjzl+dhY1FoX36rHhdOxEuv2q1WRvoWnwBM7yrpa4mkwsM6IFsveN8i18EmGDCTNNfpeRHQtZ3UMCeaD4BWjKhztOYpWN9M7ctCZqbVR00gQwsdr09tOaa5PqwS32f9wtOYCM88FaQ+ajhf669IO3JbbZzcD95OEtyR1XXbcYUFXJn4OCFevZkopBPjGyinAiswxI0vZYWVrpIe6AsmFd3pbtdTKKT9Tp82wkEXvyn&GBiBDJbjQ1XilbM8e1aiB+Gk0vpud1vmoiozbXx8FgK5aZU&rklW2JYuL2DzggB+AWJinU4TkHm&S5T46tkc+Wm8KicFCjtdbBJeGVWO451&d6d91Pj4HJJ4G4yJfy7mf56hJzO5ZKuXohejhQqQdRCVMWPNp79RC&EGsdpxY3c0N&XSpUl&u0ew6YRrkGatXY27P7rgMdPtauzWlsUPO2ZU1tZ+dmGHNuT1kwkFQ0kjXigdIYKhF63PAT&sHa9N2VM&HWgP6cJMolMoYyF+BCcUbOQptLQHfcdZnCgf9i8yZ1I5vCtXb9qkZ3SweAOSPGtaIgz49dUtZV2xQWAiVadUyvCtQ5XE+Iza5S1g7nL5kURRs1XWBHZq3kYkOnm4hdkhOHh&uUKYoZau32Z86shSxl3YkiJG3DrGU67Qo3ItWhFTVvRMRTrgZDVXoi6AsCDs5hpYYd91cOSZAfzVoe9khEVYtzEt05iHuyYsQrAhVdzCLWETUWBU3o14+TKTkQ3buDBADNBvPTWuHKAbJXAKIcDiUuSfqrrXFk9GqX5W&PJ682iw7eoh3oA05hkEvX4MM4s3Jz7CX9DyGfGqv3GpQ71xztQAtZmdeWKw2F9ssFZkQE9ZwOhsJ6Yg0Cuxv&LMbdqqHJxrcabCxrW8ckHwYaM266JZ9hDXVyrmvIjaZNcdd&a7&rQGdwxVxCUiOFtbCerxEUeS&LuIOak2sfuDzcOIFNPaNThBU8tahVKrAkkPdSlCPHPwLG1GD6T6C6op1yYNtYLzAio7MqjZrBeajbP4p1fwWOWh3rB8dsF894nfvmbhUVFIGMIC5eFxh6FyQ+OjGSWLFYq8IKunSd79GzHOfk9HsiDidx6bTAJHsRhuunkCQ5mxd0LUNsYbiFdGctQ10d1giy034tAu9fD62neFcEwFWpYIuVpIJ6Xd3zMXaqHhtHKS7jp1PoLSl2xYeyxDTMFYiAPLY+aEmANvPt2bkmHQzcz3WPps8oXWKEbXluxPfidrml3M8QFJOcbK++ral08dCP+N2iVc4YdM1DtQpUkkUuR99MGHFaV7pcwBwp4d2bWjZroyVDhvDY2pzWRTX&hmpgjb3SibZKfL3Suu5UpeYuJHlsuWCB7E+K7lB1Xqe6+F+WLnhpZ&pDhOKVX6oOeELZtMyf3weHH&CxY4qiseXBD5BNsqM0Y&YKvTDi5nnp&o1ju7MdjXrUSnr9JA8EahUlDp9X&nFJ&jMh+lD3qfIfFPqJHZwKmWSV7bDrwZ3JQ35f+hfey3cWRPZwoCQS&ssf2KAhkXwEqmBkuW&LR+VoOg1&Si4hSAIFijnhAGytZwuiDZ&8f2DXU3NLKgIMIHNlVqwfq88zFSQ2iy7cTh1BIxI1&w4k6IgkbfYf3SaH2FMlu1dWWmij6ZM8IBknB3ojw8zYwcqi71vnvlLcqbBJVPXMwgGBWZKGLHjmMI47DBg0Y4GC1xJZeXcoXgh&&SINasDqMjfmojEg6x5li1tJVeIoVK5Nv297S1fVmDj3gCK6dLeWbVBmmUEDRJ4nJRWv&xRpzH71G8AuAtNrIu7SUUq1MjjCefm9LBaJTAQqTLwnzsoMogi9FudM9COYj7H8TxvezaPeW&pNvibDQWYPcXHD+xDl5LFaFVc6qTwwQsbfTH&iNcjCOB9LuOM&bHbpKknsygu&I5eZozXWxCIXf10XWXycljCLnaN5KIfg6+VFImERVzOUJFm&8lIO5B4XOlsnzFa44dAs9YPSaODE1sE+j5E0VYQ&QBnjgipqLVIA7DdCdl3ePcPHsm6WWok41Mgtbr&Z2voVIxr2Q29sBojhlZ0CQCeRvu8DJ71WvyB0C7gWbmbgtdUe4BwL+VBtRAaNpkQgL8iSb9tfZa9TLhFREdp9mEst6PC&RJHbRBczJotu7p7kWrDrUTfTrlBQGyYSbxDR1kaR3p2iTZv+H7foclvkH6JkUyoCarZjimMALyIZSbTg8lhD6mW+&C5IBSvEGM3w1+46cRsLeUGwbWV6inRRe8U99CR5NbBst3Iu78QjW6SAswPSmnyedzKw6gGDX45ikK7uXXo+VyHNoEg&D5jhT3EHo&sL8wykAa+kIwTghGgbW218Mt9TMp+LhKLTHJy+0&sKRUUrMYd1zLUCLW+hGZ3ldZExuUs6BWRxsLKMFB7oyfGSu&wIPRc7Lyo2Smn2X2CemcfnxEx0dU7ih2n6LuYsxUyof4c3l9xChjt6f2z1eeMWBvEYY+EyLMdlJFmBfXF1sDsd8FJBdGLYZ+POvSEiadqw51VpRoQSxGJDAVT4wafb9QIcpKJSJsy+uIAMutQvtUmHUvH&8GlPQlXjfkNysuc4EdXyhSnhiectMxDk24gr7bY+6neBXt9vZNmgfyUjUJZz9WTeoac78RktX+YiIC6CF5lCTa&qqzebyUpqNovA9zs8FFI3aqk2r2hPcyNiwNJGWrjop7gvzcKLkXJCr7rh&3t6tK1mPJHle8oJcyyPWco&1CAnV4g2IgttmTUnde2dwFeS5T1hiTCAV9JuFJC&+yJjiHG3brhy5TN5XELn6hB2XSgQtmVMUdW71ADRo6ElOac0Pd&NVZP&1RkWP9dCxLilxr4DWq4gC23WgIfON0qCrQ4EF7pkqzgXUZwW2UbVAv3ua2yVBUhVbADAV3PUeVExtR6H0z01G8LtOlbEtYVVNVd8QpYtQzLCFJQnsJTFStbLuiOEWTO+n6KUcVbgdwmwI+s3p7DoXvFQ2BZ&jkKbMJylMDdgqeyHwRhpKxoQkL3SUFrUhkAUQM+jLd2YWA=" id="btn_application" class=" btn technos-button-green shadow-none rounded" ><i class="fas fa-plus"></i>&nbsp;Add Request</a> -->

          <!--<form action="https://dev-env.eyebox.app/main_table_02/add_data" method="post" >-->
          <!--    <input type="text" name="add_encrypted_data" value="GnVsauFqMMl4sADKHhURs4nhFycg12iQnc&mbtvSype8qOqVzoJxLt4xrSqQHe0pTnsj5koCMN&WRpp+1u7ULutL&cctGpw+eJoEl0NMHQSy83Nd1FV7NMdiHWfkVCHes&GUvZnVqsN5UcqmooxFMbnvj6lO+4gyqfUGj6bgCQit0IRTKv0iukIBbsqTSfa6CXCtiVKCQSwQnzYyX5v26xaOwSm4&1wTdSQ4kBYVSJKyguU2PlzvfKMI6NEQAyUS6SvEmzx+jpGzxfnQeNf5CAmAz26lkaxpqH+S0PYF278&paCm75Q7efS3d+Atzcq4rSiRFS64q76vZjREh&aHFRxoJqgEtMJZLtBeOxL1fabrni&YkSA6ERdjzEImrXiehBpPUeJjRAWcAJwDKWAYE+bhoYSJVwqM91RuzVN47mrUX5mxRvlXJNWj2+IL2y+7JV0Ltg2DST3Nerdlx8ZoGRBW0B1wXQG6FIt5+RYZhgirwULGrMDKtl63whixWPf0P0U5g3G8vSvmj+1792RV1eWCgAOzKMo6mTQwo9ZZqBaT7WNC5s3+3S1ob&Kg348gGpgcV3T49a4+TXK4OOyJhyN6TGK6BbUBZJ6IQb9IbSgaVgXqfr5WqgBMGRW+esjQdqBOYjt6ehBhxYM7Vde4o9jA3bfquYzjVsUe4S1SDs+kibSMasrXhK+gXA02h5UPU2Crnl10ucHm&NBKb5ldgNgvWFYUmywiWNXgOkxgaTqQAYoE9Hbf6gLTp&b+QliJhKukVpeLYUpBIjJANVkhlcLBDBNvV+E40&bOIwEdF2CaXGaj9CtqPoTDjCiuVOz4vIhiTazxUtrgo37sqEqkBhhJjac6ofyq&5ze7Cixn3KYac7P2GPoAIIvw92+xEXV9v9VSI&UbAHFhMr08j1J4uwf0vM9i6G2hoFSpeqaph7jqscdaYl2AZAQp6VNBXDXwNvoh4zcpkLimHLHJOVzG6MeYkKmYfTef7mIvVuU2rdopDOS0Qsbb+Tqbbh0xyUPndvcEzIyLou91KDdrVG0&DkTmmXjOa&LyZCoTJos3oGHl9bacRidOJ+B3GWqv4QLaZKVFJ5CAL5ItVgqPpUkIQHybkblYatRAaodLdFjjDfifWGbh6LhabzUuNAqDlnnUceM7aQ370SBhr5Pb0z4Hj4QO3PpidPS0rIwtGJEEsP6ARqQCuk7TLlO168AM&WgkrH0NZHN+REvcdYfw49qwqCYI1sUqzBev9qWbq6VRfIKq&KAGMsE900dvgYFV4yzOlIMes0MkdkHbwixBKwTtCqXWx&om8XMfqhxE5ZYYrHen0vRt&QXjbEQ+i3yqeI3J7ylNp&W4OYlgQqKBJfNi8VYtKCMLkbDCSs&glqjzHR&LLN2RxcrvaQwuiKSLh0FlC+A+Wny6ErM3LPmyQjtaq3R867PZjAHacZ77+5Affqq8poFe9ZDJBWUmweP+paPZQEz586bU982gkJwa3Q+NDQSegxD8H7IRvyF&MTuOX7GzQe+RT&vLIz9yjM19nLjoqaQFWz0XZNogxzrUz4B+rr3gAP8uueySdK58fqhGv7o2zrBdn+cN5wC7mnwvOeniUXLsoExOxQOTBNLPBJzccZb9sg67wppI9rJECGK4ABOfDTHktghVySzbf5IlZljUIDM&eFgYQTPCHoPncG1hAT5FGuyMQHmfEsccfHCd32RsjUkRc+Oor57vzSNkqJSRXHPf73qmgE0YartR0haRB5mpYEvQ6uFC0fYyN0ru7StX39vDY8aszcDtp6jso9YZXSzGC1BQIoMbrweGrbf2KZt&cdMrRvq00Joyi5UVH4ZXxGNzroysP+e1Arf1tjEjsKGnnIpta7OQ8cLpX5mPrsejMS2FJ34mZitVjzl+dhY1FoX36rHhdOxEuv2q1WRvoWnwBM7yrpa4mkwsM6IFsveN8i18EmGDCTNNfpeRHQtZ3UMCeaD4BWjKhztOYpWN9M7ctCZqbVR00gQwsdr09tOaa5PqwS32f9wtOYCM88FaQ+ajhf669IO3JbbZzcD95OEtyR1XXbcYUFXJn4OCFevZkopBPjGyinAiswxI0vZYWVrpIe6AsmFd3pbtdTKKT9Tp82wkEXvyn&GBiBDJbjQ1XilbM8e1aiB+Gk0vpud1vmoiozbXx8FgK5aZU&rklW2JYuL2DzggB+AWJinU4TkHm&S5T46tkc+Wm8KicFCjtdbBJeGVWO451&d6d91Pj4HJJ4G4yJfy7mf56hJzO5ZKuXohejhQqQdRCVMWPNp79RC&EGsdpxY3c0N&XSpUl&u0ew6YRrkGatXY27P7rgMdPtauzWlsUPO2ZU1tZ+dmGHNuT1kwkFQ0kjXigdIYKhF63PAT&sHa9N2VM&HWgP6cJMolMoYyF+BCcUbOQptLQHfcdZnCgf9i8yZ1I5vCtXb9qkZ3SweAOSPGtaIgz49dUtZV2xQWAiVadUyvCtQ5XE+Iza5S1g7nL5kURRs1XWBHZq3kYkOnm4hdkhOHh&uUKYoZau32Z86shSxl3YkiJG3DrGU67Qo3ItWhFTVvRMRTrgZDVXoi6AsCDs5hpYYd91cOSZAfzVoe9khEVYtzEt05iHuyYsQrAhVdzCLWETUWBU3o14+TKTkQ3buDBADNBvPTWuHKAbJXAKIcDiUuSfqrrXFk9GqX5W&PJ682iw7eoh3oA05hkEvX4MM4s3Jz7CX9DyGfGqv3GpQ71xztQAtZmdeWKw2F9ssFZkQE9ZwOhsJ6Yg0Cuxv&LMbdqqHJxrcabCxrW8ckHwYaM266JZ9hDXVyrmvIjaZNcdd&a7&rQGdwxVxCUiOFtbCerxEUeS&LuIOak2sfuDzcOIFNPaNThBU8tahVKrAkkPdSlCPHPwLG1GD6T6C6op1yYNtYLzAio7MqjZrBeajbP4p1fwWOWh3rB8dsF894nfvmbhUVFIGMIC5eFxh6FyQ+OjGSWLFYq8IKunSd79GzHOfk9HsiDidx6bTAJHsRhuunkCQ5mxd0LUNsYbiFdGctQ10d1giy034tAu9fD62neFcEwFWpYIuVpIJ6Xd3zMXaqHhtHKS7jp1PoLSl2xYeyxDTMFYiAPLY+aEmANvPt2bkmHQzcz3WPps8oXWKEbXluxPfidrml3M8QFJOcbK++ral08dCP+N2iVc4YdM1DtQpUkkUuR99MGHFaV7pcwBwp4d2bWjZroyVDhvDY2pzWRTX&hmpgjb3SibZKfL3Suu5UpeYuJHlsuWCB7E+K7lB1Xqe6+F+WLnhpZ&pDhOKVX6oOeELZtMyf3weHH&CxY4qiseXBD5BNsqM0Y&YKvTDi5nnp&o1ju7MdjXrUSnr9JA8EahUlDp9X&nFJ&jMh+lD3qfIfFPqJHZwKmWSV7bDrwZ3JQ35f+hfey3cWRPZwoCQS&ssf2KAhkXwEqmBkuW&LR+VoOg1&Si4hSAIFijnhAGytZwuiDZ&8f2DXU3NLKgIMIHNlVqwfq88zFSQ2iy7cTh1BIxI1&w4k6IgkbfYf3SaH2FMlu1dWWmij6ZM8IBknB3ojw8zYwcqi71vnvlLcqbBJVPXMwgGBWZKGLHjmMI47DBg0Y4GC1xJZeXcoXgh&&SINasDqMjfmojEg6x5li1tJVeIoVK5Nv297S1fVmDj3gCK6dLeWbVBmmUEDRJ4nJRWv&xRpzH71G8AuAtNrIu7SUUq1MjjCefm9LBaJTAQqTLwnzsoMogi9FudM9COYj7H8TxvezaPeW&pNvibDQWYPcXHD+xDl5LFaFVc6qTwwQsbfTH&iNcjCOB9LuOM&bHbpKknsygu&I5eZozXWxCIXf10XWXycljCLnaN5KIfg6+VFImERVzOUJFm&8lIO5B4XOlsnzFa44dAs9YPSaODE1sE+j5E0VYQ&QBnjgipqLVIA7DdCdl3ePcPHsm6WWok41Mgtbr&Z2voVIxr2Q29sBojhlZ0CQCeRvu8DJ71WvyB0C7gWbmbgtdUe4BwL+VBtRAaNpkQgL8iSb9tfZa9TLhFREdp9mEst6PC&RJHbRBczJotu7p7kWrDrUTfTrlBQGyYSbxDR1kaR3p2iTZv+H7foclvkH6JkUyoCarZjimMALyIZSbTg8lhD6mW+&C5IBSvEGM3w1+46cRsLeUGwbWV6inRRe8U99CR5NbBst3Iu78QjW6SAswPSmnyedzKw6gGDX45ikK7uXXo+VyHNoEg&D5jhT3EHo&sL8wykAa+kIwTghGgbW218Mt9TMp+LhKLTHJy+0&sKRUUrMYd1zLUCLW+hGZ3ldZExuUs6BWRxsLKMFB7oyfGSu&wIPRc7Lyo2Smn2X2CemcfnxEx0dU7ih2n6LuYsxUyof4c3l9xChjt6f2z1eeMWBvEYY+EyLMdlJFmBfXF1sDsd8FJBdGLYZ+POvSEiadqw51VpRoQSxGJDAVT4wafb9QIcpKJSJsy+uIAMutQvtUmHUvH&8GlPQlXjfkNysuc4EdXyhSnhiectMxDk24gr7bY+6neBXt9vZNmgfyUjUJZz9WTeoac78RktX+YiIC6CF5lCTa&qqzebyUpqNovA9zs8FFI3aqk2r2hPcyNiwNJGWrjop7gvzcKLkXJCr7rh&3t6tK1mPJHle8oJcyyPWco&1CAnV4g2IgttmTUnde2dwFeS5T1hiTCAV9JuFJC&+yJjiHG3brhy5TN5XELn6hB2XSgQtmVMUdW71ADRo6ElOac0Pd&NVZP&1RkWP9dCxLilxr4DWq4gC23WgIfON0qCrQ4EF7pkqzgXUZwW2UbVAv3ua2yVBUhVbADAV3PUeVExtR6H0z01G8LtOlbEtYVVNVd8QpYtQzLCFJQnsJTFStbLuiOEWTO+n6KUcVbgdwmwI+s3p7DoXvFQ2BZ&jkKbMJylMDdgqeyHwRhpKxoQkL3SUFrUhkAUQM+jLd2YWA=" hidden>-->
          <!--    <button type="submit"  class=" btn technos-button-green shadow-none rounded"  ><i class="fas fa-plus"></i>&nbsp;Add Request</button>-->
          <!--</form>-->
          <a href="<?= base_url('attendances/request_offset') ?>" class=" btn btn-primary shadow-none rounded"><img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
            &nbsp;Add Request</a>
          <a id="btn_export" class=" btn technos-button-green shadow-none rounded"><img class="mb-1" src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>" alt="">
            &nbsp;Export XLSX</a>


        </div>
      </div>
      <div class="row mb-4 mt-5">
        <div class="col-md-2 <?= $DISP_VIEW_COMPANY == '0' ? 'd-none' : '' ?>">
          <p class="mb-1 text-secondary ">Company</p>
          <select name="dept" id="filter_by_company" class="filter_select form-control">
            <option value="">All Companies </option>
            <?php foreach ($COMPANIES as $row_data) : ?>
              <option value="<?= $row_data->id ?>" <?= $company_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="col-md-2 <?= $DISP_VIEW_BRANCH == '0' ? 'd-none' : '' ?>">
          <p class="mb-1 text-secondary ">Branch</p>
          <select name="dept" id="filter_by_branch" class="filter_select form-control">
            <option value="">All Branches</option>
            <?php foreach ($BRANCHES as $row_data) : ?>
              <option value="<?= $row_data->id ?>" <?= $branch_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="col-md-2 <?= $DISP_VIEW_DEPARTMENT == '0' ? 'd-none' : '' ?>">
          <p class="mb-1 text-secondary ">Department</p>
          <select name="dept" id="filter_by_department" class="filter_select form-control">
            <option value="">All Departments</option>
            <?php foreach ($DEPARTMENTS as $row_data) : ?>
              <option value="<?= $row_data->id ?>" <?= $dept_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="col-md-2 <?= $DISP_VIEW_DIVISION == '0' ? 'd-none' : '' ?>">
          <p class="mb-1 text-secondary ">Division</p>
          <select name="dept" id="filter_by_division" class="filter_select form-control">
            <option value="">All Divisions</option>
            <?php foreach ($DIVISIONS as $row_data) : ?>
              <option value="<?= $row_data->id ?>" <?= $div_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="col-md-2 <?= $DISP_VIEW_CLUBHOUSE == '0' ? 'd-none' : '' ?>">
          <p class="mb-1 text-secondary ">Clubhouse</p>
          <select name="dept" id="filter_by_clubhouse" class="filter_select form-control">
            <option value="">All Clubhouse</option>
            <?php foreach ($CLUBHOUSE as $row_data) : ?>
              <option value="<?= $row_data->id ?>" <?= $div_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="col-md-2 <?= $DISP_VIEW_SECTION == '0' ? 'd-none' : '' ?>">
          <p class="mb-1 text-secondary ">Section</p>
          <select name="section" id="filter_by_section" class="filter_select form-control">
            <option value="">All Sections</option>
            <?php foreach ($SECTIONS as $row_data) : ?>
              <option value="<?= $row_data->id ?>" <?= $section_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="col-md-2 <?= $DISP_VIEW_GROUP == '0' ? 'd-none' : '' ?>">
          <p class="mb-1 text-secondary ">Group</p>
          <select name="group" id="filter_by_group" class="filter_select form-control">
            <option value="">All Groups</option>
            <?php foreach ($GROUPS as $row_data) : ?>
              <option value="<?= $row_data->id ?>" <?= $group_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="col-md-2 <?= $DISP_VIEW_TEAM == '0' ? 'd-none' : '' ?>">
          <p class="mb-1 text-secondary ">Team</p>
          <select name="dept" id="filter_by_team" class="filter_select form-control">
            <option value="">All Teams</option>
            <?php foreach ($TEAMS as $row_data) : ?>
              <option value="<?= $row_data->id ?>" <?= $team_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="col-md-2 <?= $DISP_VIEW_LINE == '0' ? 'd-none' : '' ?>">
          <p class="mb-1 text-secondary ">Line</p>
          <select name="line" id="filter_by_line" class="filter_select form-control">
            <option value="">All Lines</option>
            <?php foreach ($LINES as $row_data) : ?>
              <option value="<?= $row_data->id ?>" <?= $line_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="col-md-2">
          <p class="mb-1 text-secondary ">Action</p>
          <a href="<?= base_url('attendances/offset_lists') ?>" id="btn_clear_filter" class="col btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg')?>" alt=""/>Clear Filter</a>
        </div>

      </div> <!-- filter divs ends -->
      <div class="py-3 d-flex">
        <div class="mx-1">
          <p class="mb-1 text-secondary ">Status</p>
          <select class="form-control leave_status" style="min-width:200px;width:max-content">
            <option value="">All</option>
            <?php foreach ($STATUSES as $status) { ?>
              <option value="<?= $status ?>" <?= $status == $STATUS ? 'selected' : '' ?>><?= $status ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="mx-1">
          <p class="mb-1 text-secondary ">Employee</p>
          <select class="select-employee form-control" id="search_data" style="min-width:300px;width:max-content">
            <option value=''>All</option>
            <?php foreach ($EMPLOYEES as $employee) {
              $name = $employee->col_empl_cmid . '-' . $employee->col_last_name;
              if (!empty($employee->col_suffix)) $name = $name . ' ' . $employee->col_suffix;
              if (!empty($employee->col_frst_name)) $name = $name . ', ' . $employee->col_frst_name;
              if (!empty($employee->col_midl_name)) $name = $name . ' ' . $employee->col_midl_name[0] . '.';
            ?>
              <option value="<?= $employee->id ?>" <?= $search_data == $employee->id ? 'selected' : '' ?>><?= $name
                                                                                                          // $employee->col_empl_cmid."-".$this->system_functions->fomatName($employee->col_last_name,$employee->col_frst_name,$employee->col_midl_name)
                                                                                                          ?></option>
            <?php } ?>
          </select>
        </div>

      </div>


      <div class="card border-0 p-0 m-0">
        <div class="card border-0 p-1 m-0">
          <!-- <div class="card-header p-0">
            <div class="input-group m-2 ml-auto" style="width:max-content">
                <div class="input-group-prepend">
                   <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i

                    class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
                </div>
                <p class="mb-1 text-secondary ">Employee</p>
                <select class="select-employee d-block" id="search_data" style="min-width:300px;width:max-content">
                    <option value=''>All</option>
                  <?php foreach ($EMPLOYEES as $employee) { ?>
                      <option value="<?= $employee->id ?>" <?= $search_data == $employee->id ? 'selected' : '' ?>
                      ><?= $employee->col_empl_cmid . "-" . $this->system_functions->fomatName($employee->col_last_name, $employee->col_frst_name, $employee->col_midl_name) ?></option>
                  <?php } ?>
                </select>
 
            </div>

        </div> -->

          <div class="p-2">
            <div>

              <!-- <button id="btn_application"    class=" btn technos-button-gray shadow-none rounded" data-toggle="modal" data-target="#modal_insert"  ><i class="far fa-trash-alt"></i>&nbsp;Delete</button> -->
              <div class="float-right ">
                <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                <ul class="d-inline pagination m-0 p-0 ">
                  <li><a <?php if ($current_page > 1) echo " class='paginate' href='?page=$prev_page&row=$row&search=$search_data'"; ?>>
                      < </a>
                  </li>
                  <li><a class="paginate" href="?status=<?= $STATUS ?>&page=1&row=<?= $row ?>&search=<?= $search_data ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                  <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                  <li><a class="paginate" href="?status=<?= $STATUS ?>&page=<?= $current_page - 1 ?>&row=<?= $row ?>&search=<?= $search_data ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                  <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                  <li><a class="paginate" href="?status=<?= $STATUS ?>&page=<?= $current_page + 1 ?>&row=<?= $row ?>&search=<?= $search_data ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                  <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                  <li><a class="paginate" href="?status=<?= $STATUS ?>&page=<?= $last_page ?>&row=<?= $row ?>&search=<?= $search_data ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                  <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page) echo "class='paginate'  href='?status=$STATUS&page=$next_page&row=$row&search=$search_data'"; ?>>> </a></li>
                </ul>
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
          <div class="table-responsive">

            <table class="table table-bordered m-0" id="table_main" style="width:100%">
              <thead>

                <th class="text-center" style="width:5%" hidden><input type="checkbox" name="check_all" id="check_all">
                </th>
                <th style='width:5%;text-align: center;'>Offset ID</th>
                <th style='width:10%;text-align: center;'>Assigned by</th>
                <th style='width:10%;text-align: center;'>Employee</th>
                <!-- <th style='width:15%;text-align: center;'>Type</th> -->
                <th style='width:15%;text-align: center;'>Offset Date</th>
                <th style='width:15%;text-align: center;'>Time Range</th>
                <th style='width:10%;text-align: center;'>Offset Duration (Hours)</th>
                <th style='width:15%;text-align: center;'>Status</th>
                <th style='width:0%;text-align: center;'>Reason</th>

                <th style="width:15%" class="text-center">Action</th>
              </thead>
              <tbody id="tbl_application_container">
                <?php if ($OFFSETS) {  ?>
                  <?php foreach ($OFFSETS as $offset) { ?>
                    <tr data-leave_id="<?= $offset->id ?>" data-toggle="modal" data-target="#modal_approval">
                      <td class="text-center" id="select_item" hidden>
                        <input type="checkbox" name="brand" class="check_single" row_id="56">
                      </td>
                      <td class="text-center" style="width:5%"><?= $id_prefix . str_pad($offset->id, 5, '0', STR_PAD_LEFT) ?></td>
                      <td class="text-center hover td-directs text-primary " style="width:10%" data-empl_id="<?= $offset->assigned_table_id ?>">
                        <?= $offset->assigned_by ?>
                      </td>
                      <td class="text-center hover td-directs text-primary " data-empl_id="<?= $offset->employee_table_id ?>" style="width:10%">
                        <?= $offset->employee ?>
                      </td>
                      <td class="text-center" style="width:15%"><?= date(($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y", strtotime($offset->offset_date)) ?></td>
                      <td class="text-center" style="width:10%">
                        <?= isset($offset->time_range) && $offset->time_range ? $offset->time_range : '' ?>
                    </td>

                      <td class="text-center" style="width:10%"><?= $offset->duration ?></td>
                      <td class="text-center" style="width:15%">
                        <?php
                        if ($offset->status == "Approved") { ?>
                          <div class=' technos-button-green p-2 rounded disabled m-auto' style="width:100px"><?= $offset->status ?></div>
                        <?php } elseif ($offset->status == "Rejected") { ?>
                          <div class='bg-danger p-2 rounded disabled m-auto' style="width:100px"><?= $offset->status ?></div>
                        <?php } elseif ($offset->status == "Withdrawed") { ?>
                          <div class='bg-secondary p-2 rounded disabled m-auto' style="width:100px"><?= $offset->status ?></div>
                        <?php } else { ?>
                          <div class='bg-warning  p-2 rounded disabled m-auto' style="width:100px">Pending</div>
                        <?php } ?>

                      </td>
                      <td class="text-center" style="width:0%"><?= $offset->reason ?></td>

                      <td class="text-center">
                        <a class="select_row p-2" style="color: gray; cursor: pointer; !important" row_id="56" data-leave_id="<?= $offset->id ?>" data-toggle="modal" data-target="#modal_approval">
                           <img src="<?= base_url('assets_system/icons/eye-solid.svg') ?>" alt="">
                        </a>
                        <?php if ($offset->status == 'Pending 1') { ?>
                          <a class="select_edit_row p-2 edit_data_id" href="<?= base_url('attendances/edit_offset/' . $offset->id) ?>" style="color: gray; cursor: pointer; !important" row_id="56">
                            <img src="<?= base_url('assets_system/icons/pen-to-square-solid.svg') ?>" alt="" id="edit">
                          </a>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } else { ?>
                  <tr class="table-active">
                    <td colspan="12">
                      <center>No Records</center>
                    </td>
                  </tr>
                <?php } ?>
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

        <?php
            $tab = ''; 
            $table_name = ''; 
            $module_name = ''; 
            $page_name = ''; 
        ?>
        
        <form action="<?php echo base_url('main_table_02/edit_bulk_status?page=' . $current_page . '&row=' . $row . '&tab=' . $tab . '&table=' . $table_name . '&module=' . $module_name . '&page_name=' . $page_name); ?>" method="post">
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
            <input type="hidden" id="modal_title" name="modal_title">
            <input type="hidden" id="list_mark_ids" name="list_mark_ids">
            <button type="submit" class="btn btn-info">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_approval" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="approval_modal_content">
    </div>
  </div>

  <!-- modal employee info reporting to, directs -->
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
                  <img class="img-circle rounded-circle avatar m-3  elevation-2"  onerror="setDefaultImage(this)" id="employee_img" style="cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Profile Image" src="<?= base_url() ?>/assets_system/images/default_user.jpg">     
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
                    <!-- <div  class="d-flex align-items-center mx-2 mb-2">
                    <img class="img-circle rounded-circle avatar elevation-2" 
                    id="directsImage" style="cursor: pointer;width:50px !important;height:50px !important" data-toggle="tooltip" 
                    data-placement="right" title="Reporting To" 
                    src="<?= base_url() ?>/assets_system/images/default_user.jpg">
                    <div class="mx-2">
                      <p id="directsName" class="p-0 m-0" style="line-height: 1;font: size 13px;font-weight:500;">Name of Reporting To</p>
                    </div> -->
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

  <?php $this->load->view('templates/jquery_link'); ?>
  <?php
  if ($this->session->userdata('success')) {
  ?>
    <script>
      Swal.fire('<?php echo $this->session->userdata('success'); ?>', '', 'success')
    </script>
  <?php $this->session->unset_userdata('success');
  }
  ?>
  <?php
  if ($this->session->flashdata('SUCC')) {
  ?>
    <script>
      Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>', '', 'success')
    </script>
  <?php
  }
  ?>
  <?php
  if ($this->session->flashdata('ERR')) {
  ?>
    <script>
      Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>',
        '',
        'error'
      )
    </script>
  <?php
  }
  ?>
  <script>
    $(document).ready(function() {
      $('.select-employee').select2();
      $('#modal_approval').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        var leave_id = button.data('leave_id');
        $.get("<?= base_url('attendances/get_offset_status') ?>" + '/' + leave_id, function(res) {
          $('#approval_modal_content').html(res)
        })
        // fetch()
        // .then(res=>res)
        // .then(data=>{
        //     console.log(data)
        // })
      });
      // $('#search_btn').on('click',function(){
      //     reloadPage();
      // })
      $('.select-employee,#search_data').on('change', function() {
        reloadPage();
      })
      $('.leave_status,#row_dropdown').on('change', function() {
        reloadPage();
      })
      $('.filter_select').on('change', function() {
        reloadPage()
      })
      $('a.paginate').on('click', function() {
        var status = $('.leave_status').val();
        var row = $('#row_dropdown').val();
        var page = "<?= $PAGE ?>";
        var search = $('#search_data').val();
        var company = $('#filter_by_company').val();
        var branch = $('#filter_by_branch').val();
        var department = $('#filter_by_department').val();
        var division = $('#filter_by_division').val();
        var clubhouse = $('#filter_by_clubhouse').val();
        var section = $('#filter_by_section').val();
        var group = $('#filter_by_group').val();
        var team = $('#filter_by_team').val();
        var line = $('#filter_by_line').val();
        var filter_url = '&company=' + company + '&branch=' + branch + '&dept=' + department + '&div=' + division + '&section=' + section + '&group=' + group + '&team=' + team + '&line=' + line;
        window.location.href = "<?= base_url('attendances/offset_lists') ?>" + $(this).attr('href') + filter_url;
        return false;
      })

      function reloadPage() {
        var status = $('.leave_status').val();
        var row = $('#row_dropdown').val();
        var page = "<?= $PAGE ?>";
        var search = $('#search_data').val();
        var company = $('#filter_by_company').val();
        var branch = $('#filter_by_branch').val();
        var department = $('#filter_by_department').val();
        var division = $('#filter_by_division').val();
        var clubhouse = $('#filter_by_clubhouse').val();
        var section = $('#filter_by_section').val();
        var group = $('#filter_by_group').val();
        var team = $('#filter_by_team').val();
        var line = $('#filter_by_line').val();
        var filter_url = '&company=' + company + '&branch=' + branch + '&dept=' + department + '&div=' + division + '&clubhouse=' + clubhouse + '&section=' + section + '&group=' + group + '&team=' + team + '&line=' + line;
        window.location.href = "<?= base_url('attendances/offset_lists') ?>" + "?status=" + status + "&page=" + page + "&row=" + row + '&search=' + search + filter_url;
      }
      // -----------------------------------For employee modal information---------------------------------------------
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
        let empl_id = $(this).data('empl_id')
        directs(empl_id);
      })
      const directs = async (employeeId) => {
        if (employeeId) {
          document.getElementById("modalLoading").style.display = "block";
          $('#modalDirects').modal('show');
          const apiUrl = baseUrl + 'selfservices/get_reporting_to_directives';
          const data = {
            employeeId
          };
          console.log('data', data);
          fetch(apiUrl, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
              console.log('result', result)
              document.getElementById("modalLoading").style.display = "none";
              document.getElementById("employeeCompany").style.display = 'block';
              document.getElementById("employeeBranchDepartment").style.display = 'block';
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
              if (result.data.reportingTo?.col_suffix) reportingToLastNameSuffix = `${reportingToLastNameSuffix} ${result.data.reportingTo?.col_suffix}`;
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

              console.log('directs condition', Array.isArray(result.data.directsTo) && result.data.directsTo.length > 0)
              if (Array.isArray(result.data.directsTo) && result.data.directsTo.length > 0) {
                directsParent.innerHTML = '';
                result.data.directsTo.forEach(function(user) {

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
                <img class="img-circle rounded-circle avatar elevation-2" 
                  id="directsToPhoto" style="cursor: pointer;width:50px !important;height:50px !important" 
                  data-toggle="tooltip" data-placement="right" title="Reporting To" 
                  src="${directImage}" onerror="setDefaultImage(this)">
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

          // document.getElementById('employee_img').src = `${baseUrl}/assets_system/images/default_user.jpg`;
          // assets_user/user_profile/' . $user_image;
        } else {
          $('#modalDirects').modal('show');
          document.getElementById('employee_img').src = `${baseUrl}/assets_system/images/default_user.jpg`;
          document.getElementById("employeeFullName").textContent = '(No Full Name)';
          document.getElementById("employeeNumber").textContent = '(No Employee Number)';
          document.getElementById("employeePosition").textContent = '(No Position)';
          document.getElementById("employeeCompany").style.display = 'none';
          document.getElementById("employeeBranchDepartment").style.display = 'none';
          document.getElementById("employeeEmail").textContent = '(No Email)';
          document.getElementById("reportingToContainer").innerHTML = '(No Redirect To)';
          document.getElementById("directsParent").innerHTML = '(No Directs)';
        }
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
      XLSX.writeFile(wb, "<?php echo 'offset_list.xlsx' ?>");
    });
  </script>

  <script>

  </script>
  <script>
  // onerror="setDefaultImage(this)"
  function setDefaultImage(img) {
    img.src = "<?= base_url() ?>/assets_system/images/default_user.jpg";
    img.alt = 'Default Image';
  }
</script>
</body>

</html>