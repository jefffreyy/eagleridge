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

?>
<?php
$search_data = $this->input->get('all');

$search_data = str_replace("_", " ", $search_data ?? '');
$id_prefix = 'HDW';
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
          <h1 class="page-title d-flex align-items-center"><a onclick="afterRenderFunction()" href="<?= base_url('selfservices') ?>"> <img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />

            </a>&nbsp;My Holiday Work<h1>
        </div>

        <div class="col-md-6 button-title">
          <a onclick="afterRenderFunction()" href="<?= base_url('selfservices/request_holiday_work') ?>" class=" btn btn-primary shadow-none rounded d-flex align-items-center"><img src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
            </i>&nbsp;Add Request</a>
          <a id="btn_export" class=" btn btn-primary text-light shadow-none rounded d-flex align-items-center"><img src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>" alt="">
            </i>&nbsp;Export XLSX</a>


        </div>
      </div>
      <div class=" py-3 w-25">
        <p class="p-0 my-1 text-bold">Status</p>
        <select class="form-control leave_status">
          <option value="">All</option>
          <?php foreach ($STATUSES as $status) { ?>
            <option value="<?= $status ?>" <?= $status == $STATUS ? 'selected' : '' ?>><?= $status ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="card border-0 p-0 m-0">
        <div class="card border-0 pt-1 m-0">


          <div class="p-2 d-none d-lg-block">
            <div class="row align-items-center ">

              <div id="paginated" class="d-flex col-sm-9 col-md-10 col-lg-11 justify-content-end  my-lg-0 my-2">

                <div class=" d-flex align-items-center row  ">
                  <div class="d-inline col-12 col-lg-8">
                    <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                  </div>
                  <div class="d-lg-inline d-flex col-12 col-lg-4 justify-content-center">
                    <ul class=" pagination m-0 p-0 ">
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
                  </div>



                </div>
              </div>

              <div class=" col-sm-3 col-md-2 col-lg-1  d-flex align-items-center justify-content-center">
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
                <th style='width:10%;'>ID</th>
                <th style='width:15%;'>DATE</th>
                <th style='width:10%;'>TYPE</th>
                <th style='width:10%;'>HOURS</th>
                <th style=''>REASON</th>

                <!-- <th style='text-align: center;'>REMARKS</th> -->
                <th style='width:10%;text-align: center;'>STATUS</th>
                <th style="width:10%" class="text-center">ACTION</th>
              </thead>
              <tbody id="tbl_application_container">
                <?php if ($TABLE_DATA) {  ?>
                  <?php foreach ($TABLE_DATA as $row_data) {
                    $originalDate = $row_data->date;
                    $date = new DateTime($originalDate);
                    $formattedDate = $date->format($DATE_FORMAT ? $DATE_FORMAT: "d/m/Y");
                  ?>


                    <tr data-id="<?= $row_data->id ?>" data-toggle="modal" data-target="#modal_approval">

                      <td><?= $id_prefix . str_pad($row_data->id, 5, '0', STR_PAD_LEFT) ?></td>
                      <td>
                        <?= $formattedDate ?>
                      </td>
                      <td><?= $row_data->type ?></td>
                      <td><?= $row_data->hours ?></td>
                      <td><?= $row_data->reason ?></td>
                      <!-- <td class="text-center"><?= $row_data->comment ?></td> -->
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
          </div>
          <div class="p-2 d-lg-none d-block">
            <div class="row align-items-center ">

              <div id="paginated" class="d-flex col-sm-9 col-md-10 col-lg-11 justify-content-center  justify-content-lg-end  my-lg-0 my-2">

                <div class=" d-flex align-items-center row  ">
                  <div class="d-inline col-12 col-lg-8">
                    <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                  </div>
                  <div class="d-lg-inline d-flex col-12 col-lg-4 justify-content-center">
                    <ul class=" pagination m-0 p-0 ">
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
                  </div>



                </div>
              </div>

              <div class=" col-sm-3 col-md-2 col-lg-1  d-flex align-items-center justify-content-center">
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
    $(document).ready(function() {
      $('#modal_approval').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        var id = button.data('id');
        $.get("<?= base_url('selfservices/get_holiday_work_status') ?>" + '/' + id, function(res) {
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
        window.location.href = "<?= base_url('selfservices/my_holiday_work') ?>" + "?status=" + status + "&page=" + page + "&row=" + row;
      }
    })
  </script>
  <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> -->
  <script src="<?= base_url() ?>assets_system/js/xlsx.full.min.js"></script>
  <script>
    document.getElementById("btn_export").addEventListener('click', function() {
      var wb = XLSX.utils.table_to_book(document.getElementById("table_main"));
      XLSX.writeFile(wb, "my_holiday_works.xlsx");
    });
  </script>
</body>

</html>