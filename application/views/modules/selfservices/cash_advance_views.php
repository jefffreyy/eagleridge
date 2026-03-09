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
    background-color: #000;
    border-left: 1px dashed #000;
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
$id_prefix = 'OVT';
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
      <div class="row pt-1">
        <div class="col-md-6">
          <h1 class="page-title d-flex align-items-center"><a href="<?= base_url('selfservices') ?>"> <img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />

            </a>&nbsp;Cash Advance<h1>
        </div>

        <div class="col-md-6 button-title">
          <a href="<?= base_url('selfservices/add_reimbursement') ?>" class=" btn btn-primary shadow-none rounded d-flex align-items-center"><img src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
            &nbsp;Add Request</a>
          <a id="btn_export" class=" btn btn-primary text-light shadow-none rounded d-flex align-items-center"><img src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>" alt="">
            &nbsp;Export XLSX</a>


        </div>
      </div>
      
      <div class=" py-3 w-25">
        <p class="p-0 my-1 text-bold">Status</p>
        <select class="form-control status_select">
          <option value="">All</option>
          <?php foreach ($STATUSES as $status) { ?>
            <option value="<?= $status ?>" <?= $status == $STATUS ? 'selected' : '' ?>><?= $status ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="card border-0 p-0 m-0">
        <div class="card border-0 pt-1 m-0">

          <div class="p-2">
            <div>
              <div class="">
                <div class="pb-2 row d-flex align-items-center justify-content-center">
                  <div class="d-flex col-8 col-md-10 col-lg-11">
                    <div class="d-flex align-items-center ml-auto">

                      <ul class="d-inline pagination m-0 p-0 ">
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
                        <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?status=$STATUS&page=$next_page&row=$row'"; ?>>> </a></li>
                      </ul>

                      <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>

                    </div>

                  </div>

                  <div class=" col-4 col-md-2 col-lg-1  d-flex align-items-center justify-content-end">
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

              <tr>
                <!-- <th class="text-center" style="min-width: 50px !important"><input type="checkbox" name="check_all" id="check_all"></th> -->
                <th class="text-left" style="min-width: 100px !important">ID</th>
                <th class="text-left" style="min-width: 300px !important">EMPLOYEE</th>
                <th class="text-left" style="min-width: 150px !important">TYPE</th>
                <th class="text-left" style="min-width: 100px !important">DESCRIPTION</th>
                <th class="text-left" style="min-width: 100px !important">AMOUNT</th>
                <th class="text-center" style="min-width: 100px !important">STATUS</th>
                <th class="text-center" style="min-width: 100px !important">ACTION</th>
              </tr>
              </thead>
              
              <tbody id="tbl_benefits_reimbursement">
                <?php if ($TABLE_DATA) {  ?>
                  <?php foreach ($TABLE_DATA as $tableDatarow) { ?>
                    <tr>
                      <td class="text-left"><?= 'LN' . str_pad($tableDatarow->id, 5, '0', STR_PAD_LEFT); ?></td>
                      <td class="text-left"><?= $tableDatarow->employee?></td>
                      <td class="text-left"><?= $tableDatarow->type ?></td>
                      <td class="text-left"><?= $tableDatarow->description ?></td>
                      <td class="text-left"><?= $tableDatarow->amount ?></td>
                      <td class="text-left">
                          <?php if ($tableDatarow->status == "Approved") { ?>
                              <span class='btn btn-sm btn-success disabled'><?= $tableDatarow->status ?></span>
                          <?php } elseif ($tableDatarow->status == "Rejected") { ?>
                              <span class='btn btn-sm btn-danger disabled'><?= $tableDatarow->status ?></span>
                          <?php } elseif ($tableDatarow->status == "Withdrawed") { ?>
                              <span class='btn btn-sm btn-secondary disabled'><?= $tableDatarow->status ?></span>
                          <?php } else { ?>
                              <span class='btn btn-sm btn-warning disabled'>Pending</span>
                          <?php } ?>
                      </td>
                      <td class="d-flex justify-content-center">
                          <a class="btn btn-sm btn_edit indigo lighten-2 ml-2" href="<?= base_url() . 'selfservices/approval_reimbursement/'.$tableDatarow->id ?>"  >
                              <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="" id="edit">
                          </a>
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
          </div>
        </div>
      </div>
    </div>
  </div>

  


  <div class="modal fade" id="modal_approval" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="approval_modal_content">
    </div>
  </div>

  <?php $this->load->view('templates/jquery_link'); ?>

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
      $('.status_select,#row_dropdown').on('change', function() {
        reloadPage();
      })

      function reloadPage() {
        var status = $('.status_select').val();
        var row = $('#row_dropdown').val();
        var page = "<?= $PAGE ?>";
        window.location.href = "<?= base_url('selfservices/my_reimbursement') ?>" + "?status=" + status + "&page=" + page + "&row=" + row;
      }
  </script>

  <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> -->
  <script src="<?=base_url() ?>assets_system/js/xlsx.full.min.js"></script>
  <script>
    document.getElementById("btn_export").addEventListener('click', function() {
      var wb = XLSX.utils.table_to_book(document.getElementById("table_main"));
      XLSX.writeFile(wb, "<?php echo 'my_reimbursement.xlsx' ?>");
    });
  </script>
</body>

</html>