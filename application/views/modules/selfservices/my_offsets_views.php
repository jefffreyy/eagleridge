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

  .modal-title-header {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 100%;
  }

  .table-acquired-hours {
    table-layout: fixed;
    width: 100%;
  }

  .table-acquired-hours th,
  .table-acquired-hours td {
    width: 50%;
  }


  .image_profile::after {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    width: 1px;
    background-color: #000;
    border-left: 1px dashed #000;
  }

  @media (min-width: 576px) {
    #paginate {
      text-align: right;
      ;
    }
  }

  @media (min-width: 1280px) {
    .col-2-xl {
      flex-basis: 16.66667%;
      max-width: 16.66667%;
    }

    #search_data {
      min-width: 200px;
    }
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
$search_data = $this->input->get('all');

$search_data = str_replace("_", " ", $search_data ?? '');
$id_prefix = 'OFF';

$TAB = 'active';
$ACTIVES = 0;
$INACTIVES = 0;


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
          <h1 class="page-title"><a onclick="afterRenderFunction()" href="<?= base_url('selfservices') ?>"> <img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />

            </a>&nbsp;My Offsets<h1>
        </div>

        <div class="col-md-6 button-title">
          <!-- <a href="https://dev-env.eyebox.app/main_table_02/add_data?GnVsauFqMMl4sADKHhURs4nhFycg12iQnc&mbtvSype8qOqVzoJxLt4xrSqQHe0pTnsj5koCMN&WRpp+1u7ULutL&cctGpw+eJoEl0NMHQSy83Nd1FV7NMdiHWfkVCHes&GUvZnVqsN5UcqmooxFMbnvj6lO+4gyqfUGj6bgCQit0IRTKv0iukIBbsqTSfa6CXCtiVKCQSwQnzYyX5v26xaOwSm4&1wTdSQ4kBYVSJKyguU2PlzvfKMI6NEQAyUS6SvEmzx+jpGzxfnQeNf5CAmAz26lkaxpqH+S0PYF278&paCm75Q7efS3d+Atzcq4rSiRFS64q76vZjREh&aHFRxoJqgEtMJZLtBeOxL1fabrni&YkSA6ERdjzEImrXiehBpPUeJjRAWcAJwDKWAYE+bhoYSJVwqM91RuzVN47mrUX5mxRvlXJNWj2+IL2y+7JV0Ltg2DST3Nerdlx8ZoGRBW0B1wXQG6FIt5+RYZhgirwULGrMDKtl63whixWPf0P0U5g3G8vSvmj+1792RV1eWCgAOzKMo6mTQwo9ZZqBaT7WNC5s3+3S1ob&Kg348gGpgcV3T49a4+TXK4OOyJhyN6TGK6BbUBZJ6IQb9IbSgaVgXqfr5WqgBMGRW+esjQdqBOYjt6ehBhxYM7Vde4o9jA3bfquYzjVsUe4S1SDs+kibSMasrXhK+gXA02h5UPU2Crnl10ucHm&NBKb5ldgNgvWFYUmywiWNXgOkxgaTqQAYoE9Hbf6gLTp&b+QliJhKukVpeLYUpBIjJANVkhlcLBDBNvV+E40&bOIwEdF2CaXGaj9CtqPoTDjCiuVOz4vIhiTazxUtrgo37sqEqkBhhJjac6ofyq&5ze7Cixn3KYac7P2GPoAIIvw92+xEXV9v9VSI&UbAHFhMr08j1J4uwf0vM9i6G2hoFSpeqaph7jqscdaYl2AZAQp6VNBXDXwNvoh4zcpkLimHLHJOVzG6MeYkKmYfTef7mIvVuU2rdopDOS0Qsbb+Tqbbh0xyUPndvcEzIyLou91KDdrVG0&DkTmmXjOa&LyZCoTJos3oGHl9bacRidOJ+B3GWqv4QLaZKVFJ5CAL5ItVgqPpUkIQHybkblYatRAaodLdFjjDfifWGbh6LhabzUuNAqDlnnUceM7aQ370SBhr5Pb0z4Hj4QO3PpidPS0rIwtGJEEsP6ARqQCuk7TLlO168AM&WgkrH0NZHN+REvcdYfw49qwqCYI1sUqzBev9qWbq6VRfIKq&KAGMsE900dvgYFV4yzOlIMes0MkdkHbwixBKwTtCqXWx&om8XMfqhxE5ZYYrHen0vRt&QXjbEQ+i3yqeI3J7ylNp&W4OYlgQqKBJfNi8VYtKCMLkbDCSs&glqjzHR&LLN2RxcrvaQwuiKSLh0FlC+A+Wny6ErM3LPmyQjtaq3R867PZjAHacZ77+5Affqq8poFe9ZDJBWUmweP+paPZQEz586bU982gkJwa3Q+NDQSegxD8H7IRvyF&MTuOX7GzQe+RT&vLIz9yjM19nLjoqaQFWz0XZNogxzrUz4B+rr3gAP8uueySdK58fqhGv7o2zrBdn+cN5wC7mnwvOeniUXLsoExOxQOTBNLPBJzccZb9sg67wppI9rJECGK4ABOfDTHktghVySzbf5IlZljUIDM&eFgYQTPCHoPncG1hAT5FGuyMQHmfEsccfHCd32RsjUkRc+Oor57vzSNkqJSRXHPf73qmgE0YartR0haRB5mpYEvQ6uFC0fYyN0ru7StX39vDY8aszcDtp6jso9YZXSzGC1BQIoMbrweGrbf2KZt&cdMrRvq00Joyi5UVH4ZXxGNzroysP+e1Arf1tjEjsKGnnIpta7OQ8cLpX5mPrsejMS2FJ34mZitVjzl+dhY1FoX36rHhdOxEuv2q1WRvoWnwBM7yrpa4mkwsM6IFsveN8i18EmGDCTNNfpeRHQtZ3UMCeaD4BWjKhztOYpWN9M7ctCZqbVR00gQwsdr09tOaa5PqwS32f9wtOYCM88FaQ+ajhf669IO3JbbZzcD95OEtyR1XXbcYUFXJn4OCFevZkopBPjGyinAiswxI0vZYWVrpIe6AsmFd3pbtdTKKT9Tp82wkEXvyn&GBiBDJbjQ1XilbM8e1aiB+Gk0vpud1vmoiozbXx8FgK5aZU&rklW2JYuL2DzggB+AWJinU4TkHm&S5T46tkc+Wm8KicFCjtdbBJeGVWO451&d6d91Pj4HJJ4G4yJfy7mf56hJzO5ZKuXohejhQqQdRCVMWPNp79RC&EGsdpxY3c0N&XSpUl&u0ew6YRrkGatXY27P7rgMdPtauzWlsUPO2ZU1tZ+dmGHNuT1kwkFQ0kjXigdIYKhF63PAT&sHa9N2VM&HWgP6cJMolMoYyF+BCcUbOQptLQHfcdZnCgf9i8yZ1I5vCtXb9qkZ3SweAOSPGtaIgz49dUtZV2xQWAiVadUyvCtQ5XE+Iza5S1g7nL5kURRs1XWBHZq3kYkOnm4hdkhOHh&uUKYoZau32Z86shSxl3YkiJG3DrGU67Qo3ItWhFTVvRMRTrgZDVXoi6AsCDs5hpYYd91cOSZAfzVoe9khEVYtzEt05iHuyYsQrAhVdzCLWETUWBU3o14+TKTkQ3buDBADNBvPTWuHKAbJXAKIcDiUuSfqrrXFk9GqX5W&PJ682iw7eoh3oA05hkEvX4MM4s3Jz7CX9DyGfGqv3GpQ71xztQAtZmdeWKw2F9ssFZkQE9ZwOhsJ6Yg0Cuxv&LMbdqqHJxrcabCxrW8ckHwYaM266JZ9hDXVyrmvIjaZNcdd&a7&rQGdwxVxCUiOFtbCerxEUeS&LuIOak2sfuDzcOIFNPaNThBU8tahVKrAkkPdSlCPHPwLG1GD6T6C6op1yYNtYLzAio7MqjZrBeajbP4p1fwWOWh3rB8dsF894nfvmbhUVFIGMIC5eFxh6FyQ+OjGSWLFYq8IKunSd79GzHOfk9HsiDidx6bTAJHsRhuunkCQ5mxd0LUNsYbiFdGctQ10d1giy034tAu9fD62neFcEwFWpYIuVpIJ6Xd3zMXaqHhtHKS7jp1PoLSl2xYeyxDTMFYiAPLY+aEmANvPt2bkmHQzcz3WPps8oXWKEbXluxPfidrml3M8QFJOcbK++ral08dCP+N2iVc4YdM1DtQpUkkUuR99MGHFaV7pcwBwp4d2bWjZroyVDhvDY2pzWRTX&hmpgjb3SibZKfL3Suu5UpeYuJHlsuWCB7E+K7lB1Xqe6+F+WLnhpZ&pDhOKVX6oOeELZtMyf3weHH&CxY4qiseXBD5BNsqM0Y&YKvTDi5nnp&o1ju7MdjXrUSnr9JA8EahUlDp9X&nFJ&jMh+lD3qfIfFPqJHZwKmWSV7bDrwZ3JQ35f+hfey3cWRPZwoCQS&ssf2KAhkXwEqmBkuW&LR+VoOg1&Si4hSAIFijnhAGytZwuiDZ&8f2DXU3NLKgIMIHNlVqwfq88zFSQ2iy7cTh1BIxI1&w4k6IgkbfYf3SaH2FMlu1dWWmij6ZM8IBknB3ojw8zYwcqi71vnvlLcqbBJVPXMwgGBWZKGLHjmMI47DBg0Y4GC1xJZeXcoXgh&&SINasDqMjfmojEg6x5li1tJVeIoVK5Nv297S1fVmDj3gCK6dLeWbVBmmUEDRJ4nJRWv&xRpzH71G8AuAtNrIu7SUUq1MjjCefm9LBaJTAQqTLwnzsoMogi9FudM9COYj7H8TxvezaPeW&pNvibDQWYPcXHD+xDl5LFaFVc6qTwwQsbfTH&iNcjCOB9LuOM&bHbpKknsygu&I5eZozXWxCIXf10XWXycljCLnaN5KIfg6+VFImERVzOUJFm&8lIO5B4XOlsnzFa44dAs9YPSaODE1sE+j5E0VYQ&QBnjgipqLVIA7DdCdl3ePcPHsm6WWok41Mgtbr&Z2voVIxr2Q29sBojhlZ0CQCeRvu8DJ71WvyB0C7gWbmbgtdUe4BwL+VBtRAaNpkQgL8iSb9tfZa9TLhFREdp9mEst6PC&RJHbRBczJotu7p7kWrDrUTfTrlBQGyYSbxDR1kaR3p2iTZv+H7foclvkH6JkUyoCarZjimMALyIZSbTg8lhD6mW+&C5IBSvEGM3w1+46cRsLeUGwbWV6inRRe8U99CR5NbBst3Iu78QjW6SAswPSmnyedzKw6gGDX45ikK7uXXo+VyHNoEg&D5jhT3EHo&sL8wykAa+kIwTghGgbW218Mt9TMp+LhKLTHJy+0&sKRUUrMYd1zLUCLW+hGZ3ldZExuUs6BWRxsLKMFB7oyfGSu&wIPRc7Lyo2Smn2X2CemcfnxEx0dU7ih2n6LuYsxUyof4c3l9xChjt6f2z1eeMWBvEYY+EyLMdlJFmBfXF1sDsd8FJBdGLYZ+POvSEiadqw51VpRoQSxGJDAVT4wafb9QIcpKJSJsy+uIAMutQvtUmHUvH&8GlPQlXjfkNysuc4EdXyhSnhiectMxDk24gr7bY+6neBXt9vZNmgfyUjUJZz9WTeoac78RktX+YiIC6CF5lCTa&qqzebyUpqNovA9zs8FFI3aqk2r2hPcyNiwNJGWrjop7gvzcKLkXJCr7rh&3t6tK1mPJHle8oJcyyPWco&1CAnV4g2IgttmTUnde2dwFeS5T1hiTCAV9JuFJC&+yJjiHG3brhy5TN5XELn6hB2XSgQtmVMUdW71ADRo6ElOac0Pd&NVZP&1RkWP9dCxLilxr4DWq4gC23WgIfON0qCrQ4EF7pkqzgXUZwW2UbVAv3ua2yVBUhVbADAV3PUeVExtR6H0z01G8LtOlbEtYVVNVd8QpYtQzLCFJQnsJTFStbLuiOEWTO+n6KUcVbgdwmwI+s3p7DoXvFQ2BZ&jkKbMJylMDdgqeyHwRhpKxoQkL3SUFrUhkAUQM+jLd2YWA=" id="btn_application" class=" btn technos-button-green shadow-none rounded" ><i class="fas fa-plus"></i>&nbsp;Add Request</a> -->

          <a onclick="afterRenderFunction()" href="<?= base_url('selfservices/acquire_offset') ?>" class=" btn btn-primary shadow-none rounded d-flex align-items-center"><img src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
            &nbsp;Acquire </a>

          <a onclick="afterRenderFunction()" href="<?= base_url('selfservices/redeemed_offset') ?>" class=" btn btn-primary shadow-none rounded d-flex align-items-center"><img src="<?= base_url('assets_system/icons/minus-solid.svg') ?>" alt="">
            &nbsp;Redeemed</a>
          <!-- <a id="btn_export" class=" btn btn-primary text-light shadow-none rounded d-flex align-items-center"><img src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>" alt="">
            &nbsp;Export XLSX</a> -->


        </div>
      </div>

      <div class="py-3 col-6 col-lg-4 d-flex align-items-end">
        <div class="w-75 me-2">
          <p class="p-0 my-1 text-bold">Status</p>
          <select class="form-control leave_status">
            <option value="">All</option>
            <?php foreach ($STATUSES as $status) { ?>
              <option value="<?= $status ?>" <?= $status == $STATUS ? 'selected' : '' ?>><?= $status ?></option>
            <?php } ?>
          </select>
        </div>
      </div>


      <div class="card border-0 p-0 m-0">
        <div class="card border-0 pT-1 m-0">
          <div class="card-header p-0 border-0">

            <!-- <div class="row">
              <div class="col-xl-">


              </div>

            </div> -->
          </div>

          <div class="p-2 d-none d-lg-block">
            <div class="row align-items-center py-1">



              <!-- <button id="btn_application"    class=" btn technos-button-gray shadow-none rounded" data-toggle="modal" data-target="#modal_insert"  ><i class="far fa-trash-alt"></i>&nbsp;Delete</button> -->

              <div class="col-12 col-xl-12 d-flex justify-content-between">

                <div class="">
                  <button type="button" class="btn btn-primary w-100" id="summaryButton" data-bs-toggle="modal" data-bs-target="#summaryModal">
                    Summary
                  </button>
                </div>

                <div id="paginated" class=" d-flex col-sm-9 col-md-10 col-xl-10 justify-content-lg-end justify-content-center my-lg-0 my-2">
                  <div class=" d-flex align-items-center  row">
                    <div class="d-inline col-12 col-xl-6">
                      <p class="p-0 m-0 mx-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                    </div>
                    <div class="d-lg-inline d-flex col-12 col-xl-6 justify-content-center justify-content-lg-end">
                      <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">
                        <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
                            < </a>
                        </li>
                        <li><a href="?status=<?= $STATUS ?>&page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                        <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                        <li><a href="?status=<?= $STATUS ?>&page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                        <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                        <li><a href="?status=<?= $STATUS ?>&page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                        <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                        <li><a href="?status=<?= $STATUS ?>&page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                        <li><a <?php if ($current_page < $last_page)   echo "href='?status=$STATUS&page=$next_page&row=$row'"; ?>>> </a></li>
                      </ul>
                    </div>


                  </div>
                  <div class=" col-sm-3 col-md-2 col-xl-1 col-2-xl  d-flex align-items-center justify-content-end mr-lg-0 mr-2">
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

            <table class="table table-bordered m-0" id="table_main" style="width:100%">
              <thead>

                <th class="text-center" style="width:5%" hidden><input type="checkbox" name="check_all" id="check_all">
                </th>
                <th style='width:10%;'>ID</th>
                <th style='width:10%;'>DATE</th>
                <th style='width:10%;'>TYPE</th>
                <!-- <th style='width:10%;'>TIME RANGE</th> -->
                <th style='width:15%;'>
                  <span>HOURS</span>
                </th>

                <th>REASON</th>
                <!-- <th style='width:0%;text-align: center;'>REMARKS</th> -->
                <th style='width:10%;text-align: center;'>STATUS</th>
                <th style="width:10%" class="text-center">ACTION</th>
              </thead>
              <!-- <tbody id="tbl_application_container">
                <?php if ($TABLE_DATA) {  ?>
                  <?php foreach ($TABLE_DATA as $row_data) { ?>
                    <tr data-id="<?= $row_data->id ?>" data-toggle="modal" data-target="#modal_approval">
                      <td><?= $id_prefix . str_pad($row_data->id, 5, '0', STR_PAD_LEFT) ?></td>
                      <td><?= date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($row_data->offset_date)) ?></td>
                      <td><?= $row_data->time_range ?></td>
                      <td><?= $row_data->duration ?></td>
                      <td><?= $row_data->reason ?></td>
                      <td class="text-center">
                        <?php
                        if ($row_data->status == "Approved") { ?>
                          <div class=' technos-button-green p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?></div>
                        <?php } elseif ($row_data->status == "Rejected") { ?>
                          <div class='bg-danger p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?></div>
                        <?php } elseif ($row_data->status == "Withdrawed") { ?>
                          <div class='bg-secondary p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?></div>
                        <?php } else { ?>
                          <div class='bg-warning  p-2 rounded disabled m-auto' style="width:100px">Pending</div>
                        <?php } ?>
                      </td>

                      <td class="text-center">
                        <a class="select_row p-2" style="color: gray; cursor: pointer; !important" row_id="56" data-id="<?= $row_data->id ?>" data-toggle="modal" data-target="#modal_approval">
                           <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="">
                        </a>
                        <?php if ($row_data->status == 'Pending 1' || $row_data->status == 'Pending 2' || $row_data->status == 'Pending 3') : ?>
                        <?php endif ?>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } else { ?>
                  <tr class="table-active">
                    <td colspan="10">
                      <center>No Records</center>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div> -->

              <tbody id="tbl_application_container">
                <?php if ($TABLE_DATA) {
                  $currentDate = new DateTime();
                ?>
                  <?php foreach ($TABLE_DATA as $row_data) {
                    $dataDate = new DateTime($row_data->offset_date);
                    $interval = $currentDate->diff($dataDate);
                    // if (!(($row_data->status == "Pending 1" || $row_data->status == 'Pending 2' || $row_data->status == 'Pending 3') && ($interval->m + ($interval->y * 12) > 2))) {
                  ?>
                    <tr data-id="<?= $row_data->id ?>" data-toggle="modal" data-target="#modal_approval">
                      <td><?= $id_prefix . str_pad($row_data->id, 5, '0', STR_PAD_LEFT) ?></td>
                      <td><?= date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($row_data->offset_date)) ?></td>
                      <td><?= $row_data->offset_type ?></td>
                      <!-- <td><?= $row_data->time_range ?></td> -->
                      <td><?= $row_data->duration ?></td>
                      <td><?= $row_data->reason ?></td>
                      <td class="text-center">
                        <?php
                        if ($row_data->status == "Approved") { ?>
                          <div class='technos-button-green p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?></div>
                        <?php } elseif ($row_data->status == "Rejected") { ?>
                          <div class='bg-danger p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?></div>
                        <?php } elseif ($row_data->status == "Withdrawn") { ?>
                          <div class='bg-secondary p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?></div>
                        <?php } else { ?>
                          <div class='bg-warning p-2 rounded disabled m-auto' style="width:100px">Pending</div>
                        <?php } ?>
                      </td>
                      <td class="text-center">
                        <a class="select_row p-2" style="color: gray; cursor: pointer; !important" row_id="56" data-id="<?= $row_data->id ?>" data-toggle="modal" data-target="#modal_approval">
                          <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="">
                        </a>
                        <?php if ($row_data->status == 'Pending 1' || $row_data->status == 'Pending 2' || $row_data->status == 'Pending 3') : ?>
                        <?php endif ?>
                      </td>
                    </tr>
                  <?php
                  }
                  // } 
                  ?>
                <?php } else { ?>
                  <tr class="table-active">
                    <td colspan="10">
                      <center>No Records</center>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

          <div class="p-2 d-block d-lg-none">
            <div class="row align-items-center py-1">

              <!-- <button id="btn_application"    class=" btn technos-button-gray shadow-none rounded" data-toggle="modal" data-target="#modal_insert"  ><i class="far fa-trash-alt"></i>&nbsp;Delete</button> -->

              <div id="paginated" class=" d-flex col-sm-9 col-md-10 col-lg-11 justify-content-lg-end justify-content-center my-lg-0 my-2">
                <div class=" d-flex align-items-center  row">
                  <div class="d-inline col-12 col-lg-6">
                    <p class="p-0 m-0 mx-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                  </div>
                  <div class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-end">
                    <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">
                      <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
                          < </a>
                      </li>
                      <li><a href="?status=<?= $STATUS ?>&page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                      <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                      <li><a href="?status=<?= $STATUS ?>&page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                      <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                      <li><a href="?status=<?= $STATUS ?>&page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                      <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                      <li><a href="?status=<?= $STATUS ?>&page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                      <li><a <?php if ($current_page < $last_page)   echo "href='?status=$STATUS&page=$next_page&row=$row'"; ?>>> </a></li>
                    </ul>
                  </div>


                </div>

              </div>
              <div class=" col-sm-3 col-md-2 col-lg-1  d-flex align-items-center justify-content-center mr-lg-0 mr-2">
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
  </div>




  <div class="modal fade" id="modal_approval" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="approval_modal_content">
    </div>
  </div>

  <!-- Summary Modal -->
  <div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="summaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title-header"  id="summaryModalLabel">Acquired Hours Summary</h4>
        </div>
        <div class="modal-body">
          <h5>Total Acquired Hours: <span id="totalAcquiredHours">0</span></h5>
          <div class="table-responsive">
            <table class="table-acquired-hours table table-bordered mt-2">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Acquired Hours</th>
                </tr>
              </thead>
              <tbody id="acquiredHoursTable">
                <!-- Table Data -->
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <?php $this->load->view('templates/jquery_link'); ?>

  <script>
    $(document).ready(function() {
      function updateJustifyContentClass() {
        if ($(window).width() <= 576) {
          $('#paginate').removeClass('justify-content-end').addClass('justify-content-center');
        } else {
          $('#paginate').removeClass('justify-content-center').addClass('justify-content-end');
        }
      }

      // Update on page load and window resize
      $(window).on('resize', updateJustifyContentClass);
      updateJustifyContentClass();
    });
  </script>
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
  <script>
    $(document).ready(function() {

      $(document).on('click', 'button.btn_withdraw', function() {
        let id = $(this).data('id');
        $.post("<?= base_url('selfservices/withdraw_leave') ?>", {
          'rowId': id
        }, function(res) {
          window.location.reload();
        })
      })
      $('#modal_approval').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        var id = button.data('id');
        $.get("<?= base_url('selfservices/get_offset_status') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })

      });

      $('.leave_status,#row_dropdown').on('change', function() {
        reloadPage();
      })

      function reloadPage() {
        afterRenderFunction();
        var status = $('.leave_status').val();
        var row = $('#row_dropdown').val();
        var page = "<?= $PAGE ?>";
        window.location.href = "<?= base_url('selfservices/my_offsets') ?>" + "?status=" + status + "&page=" + page + "&row=" + row;
      }
    })
  </script>
  <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> -->
  <script src="<?= base_url() ?>assets_system/js/xlsx.full.min.js"></script>
  <script>
    document.getElementById("btn_export").addEventListener('click', function() {
      var wb = XLSX.utils.table_to_book(document.getElementById("table_main"));
      XLSX.writeFile(wb, "<?php echo 'my_offsets.xlsx' ?>");
    });
  </script>

  <script>
    $(document).on('click', '#summaryButton', function() {
      var empl_id = <?= json_encode($this->session->userdata('SESS_USER_ID')) ?>;
      $.ajax({
        url: '<?= base_url("selfservices/get_acquired_hours_summary"); ?>',
        type: 'POST',
        data: {
          empl_id: empl_id
        },
        dataType: 'json',
        success: function(response) {
          console.log(response);

          $('#totalAcquiredHours').text(response.total_acquired_offset || 0);

          const tableBody = $('#acquiredHoursTable');
          tableBody.empty();

          if (response.monthly_data.length > 0) {
            response.monthly_data.forEach((item) => {
              tableBody.append(`
      <tr>
        <td>${item.month_year}</td>
        <td>${item.total_hours}</td>
      </tr>
    `);
            });
          } else {
            tableBody.append(`
    <tr>
        <td colspan="2" class="text-center">No Records</td>
    </tr>
  `);
          }

          var myModal = new bootstrap.Modal(document.getElementById('summaryModal'));
          myModal.show();

          document.querySelector('[data-bs-dismiss="modal"]').addEventListener('click', function() {
            myModal.hide();
          });
        },
        error: function(error) {
          console.error('Error fetching data:', error);
        }
      });
    });
  </script>

</body>

</html>