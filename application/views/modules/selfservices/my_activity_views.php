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

  .calendar-table {
    display: none !important;
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
$id_prefix = 'ADJ';
$TAB = 'active';
$STATUS = '';
$ACTIVES = 0;
$INACTIVES = 0;
$current_page = $PAGE;
$next_page = $PAGE + 1;
$prev_page = $PAGE - 1;
$last_page = $PAGES_COUNT;
$row = $ROW;
$CUTOFF_ID = 1;
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
          <h1 class="page-title d-flex align-items-center"><a onclick="afterRenderFunction()" href="<?= base_url('selfservices') ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />

            </a>&nbsp;My&nbsp;Activities<h1>
        </div>
      </div>

      <div class="card border-0 p-0 mt-5">
        <div class="card border-0 pt-1 m-0">
          <div class="p-2">

            <div class="row align-items-center py-1">
              <div class="d-none d-lg-flex col-sm-9 col-md-10 col-lg-11 justify-content-lg-end justify-content-center my-lg-0 my-2">
                <div class="d-flex align-items-center  row">
                  <div class="d-inline col-12 col-lg-6">

                    <p class="my-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                  </div>
                  <div class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-end">
                    <ul class="pagination  ml-0 ml-lg-4 m-0 p-0 ">
                      <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
                          < </a>
                      </li>
                      <li><a href="?cutoff=<?= $CUTOFF_ID ?>&page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                      <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                      <li><a href="?cutoff=<?= $CUTOFF_ID ?>&page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                      <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                      <li><a href="?cutoff=<?= $CUTOFF_ID ?>&page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                      <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                      <li><a href="?cutoff=<?= $CUTOFF_ID ?>&page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                      <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?cutoff=$CUTOFF_ID&page=$next_page&row=$row'"; ?>>> </a></li>
                    </ul>


                  </div>

                </div>


              </div>
              <div class=" col-sm-3 col-md-2 col-lg-1 d-none d-lg-flex align-items-center justify-content-center mr-lg-0 mr-2">
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

            <div class="table-responsive">
              <table class="table table-bordered m-0" id="table_main" style="width:100%">
                <thead>
                  <th>Title</th>
                  <th>Duration</th> 
                  <th>Location</th>
                  <th>Description</th>
                  <th>Status</th>
                  <th class="text-center">Action</th>
                </thead>
                <tbody id="tbl_application_container">
                  <?php if ($TABLE_DATA) {  ?>
                    <?php foreach ($TABLE_DATA as $row_data) : ?>
                      <tr>
                        <td><?= $row_data->title ?></td>
                        <td><?= $row_data->duration ?></td>
                        <td><?= $row_data->location ?></td>
                        <td><?= $row_data->description ?></td>
                        <td><?= $row_data->status ?></td>
                        <td class="text-center">
                          <a data-toggle="modal" data-target="#modal_act_info" data-description="<?= $row_data->description ?>" data-act_id="<?= $row_data->id ?>" data-title="<?= $row_data->title ?>" data-duration="<?= $row_data->duration ?>" data-location="<?= $row_data->location ?>" class="select_row p-2" style="color: gray; cursor: pointer; !important">
                             <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="">
                          </a>
                        </td>
                      </tr>
                    <?php endforeach ?>
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
            <div class="row align-items-center py-1">
              <div class="d-flex d-lg-none col-sm-9 col-md-10 col-lg-11 justify-content-lg-end justify-content-center my-lg-0 my-2">
                <div class="d-flex align-items-center  row">
                  <div class="d-inline col-12 col-lg-6">

                    <p class="my-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                  </div>
                  <div class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-end">
                    <ul class="pagination  ml-0 ml-lg-4 m-0 p-0 ">
                      <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
                          < </a>
                      </li>
                      <li><a href="?cutoff=<?= $CUTOFF_ID ?>&page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                      <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                      <li><a href="?cutoff=<?= $CUTOFF_ID ?>&page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                      <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                      <li><a href="?cutoff=<?= $CUTOFF_ID ?>&page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                      <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                      <li><a href="?cutoff=<?= $CUTOFF_ID ?>&page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                      <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?cutoff=$CUTOFF_ID&page=$next_page&row=$row'"; ?>>> </a></li>
                    </ul>

                  </div>

                </div>


              </div>
              <div class=" col-sm-3 col-md-2 col-lg-1 d-flex d-lg-none align-items-center justify-content-center mr-lg-0 mr-2">
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
      <div class="modal fade" id="modal_act_info" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Activity Information</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-6">
                  <div class="row">
                    <div class="col-6">
                      <span class="font-weight-bold">Title</span>
                    </div>
                    <div class="col-6">
                      <span id="act_title">Test 1</span>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="row d-flex align-items-center">
                    <div class="col">
                      <span class="font-weight-bold">Location</span>
                    </div>
                    <div class="col-8">
                      <span id="act_location"></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-3">
                  <span class="font-weight-bold">Duration</span>
                </div>
                <div class="col">
                  <span id="act_duration"></span>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-3">
                  <span class="font-weight-bold">Description</span>
                </div>
                <div class="col">
                  <span id="act_description"></span>
                </div>
              </div>
            </div>
            <div class="modal-footer" id="">
              <form action="" class="form-response">
                <input type="hidden" name="response" value="Accepted">
                <input type="hidden" name="id" class="act_id">
                <button type="button" class="btn btn-primary btn-response">Accept</button>
              </form>
              <form action="" class="form-response">
                <input type="hidden" name="response" value="Declined">
                <input type="hidden" name="id" class="act_id">
                <button type="button" class="btn btn-danger btn-response">Decline</button>
              </form>
              <form action="" class="form-response">
                <input type="hidden" name="response" value="Maybe">
                <input type="hidden" name="id" class="act_id">
                <button type="button" class="btn btn-info btn-response">Maybe</button>
              </form>
            </div>
          </div>
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
      <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
      <script>
        $(document).ready(function() {
          $('#cut_off_select,#row_dropdown').on('change', function() {
            reloadPage();
          })
          $('#modal_act_info').on('show.bs.modal', function(e) {
            var tr = $(e.relatedTarget);
            var title = tr.data('title');
            var location = tr.data('location');
            var duration = tr.data('duration');
            var description = tr.data('description');
            var act_id = tr.data('act_id');
            var modal = $(this)
            modal.find('.modal-body span#act_title').text(title);
            modal.find('.modal-body span#act_location').text(location);
            modal.find('.modal-body span#act_duration').text(duration);
            modal.find('.modal-body span#act_description').text(description);
            modal.find('.modal-footer form.form-response').attr('action', "<?= site_url("selfservices/response_activity") ?>");
            modal.find('.modal-footer form.form-response').attr('method', "POST");
            modal.find('.modal-footer button.btn-response').attr('type', "submit");
            modal.find('.modal-footer input.act_id').val(act_id);
          })
          $('#modal_act_info').on('hidden.bs.modal', function(e) {
            var tr = $(e.relatedTarget)
            var modal = $(this)
            modal.find('.modal-body span#act_title').text("");
            modal.find('.modal-body span#act_location').text("");
            modal.find('.modal-body span#act_duration').text("");
            modal.find('.modal-body span#act_description').text("");
            modal.find('.modal-footer form.form-response').attr('action', "");
            modal.find('.modal-footer form.form-response').attr('method', "POST");
            modal.find('.modal-footer button.btn-response').attr('type', "button");
            modal.find('.modal-footer input.act_id').val("");
          })
          $(document).on("click", ".nav-link-_activity_participants a", function(e) {
            e.preventDefault();
            var href = $(this).attr("href");
            if (!href) {
              return;
            }
            var link = "<?= site_url('hressentials/get_activity_participants') ?>" + '/' + $(this).attr("href");
            $.get(link, function(res) {
              $('#modal-dialog-activity').html(res);
            })
          })

          function reloadPage() {
            var cutoff = $('#cut_off_select').val();
            var row = $('#row_dropdown').val();
            var page = "<?= $PAGE ?>";
            window.location.href = "?cutoff=" + cutoff + "&page=" + page + "&row=" + row;
          }
          $("#btn_export").on('click', function() {
            var wb = XLSX.utils.table_to_book(document.getElementById('table_main'));
            XLSX.writeFile(wb, "my_time_adjustment.xlsx");
          });
        })
      </script>

</body>

</html>