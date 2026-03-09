<html>
<?php $this->load->view('templates/css_link'); ?>
<?php

(isset($_GET['search'])) ? $search = $_GET['search'] : $search = "";
?>
<style>
  
  .check_approved {
    color: #3ec769;
    font-size: 18px;
  }

</style>
<?php

if (isset($_GET['row'])) {
  $row = $_GET['row'];
} else {
  $row = 25;
}

if (isset($_GET['page'])) {
  $current_page = $_GET['page'];
} else {
  $current_page = 1;
}

$prev_page = $current_page - 1;
$next_page = $current_page + 1;
$last_page_initial = ceil($C_DATA_COUNT / $row);
$last_page = ($last_page_initial == 0 || $last_page_initial == 1) ? 1 : $last_page_initial;

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

<body>

  <div class="content-wrapper">
    <div class="container-fluid p-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url() ?>attendances">Attendance</a>
          </li>

          <li class="breadcrumb-item active" aria-current="page">Biometric Records
          </li>
        </ol>
      </nav>

      <div class="row pt-1">
        <div class="col-md-6">
          <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'attendances'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
</a>&nbsp;Biometric Records<h1>
        </div>
      </div>
      <hr>

      <div class="pb-1"></div>

      <div class="card border-0 p-0 m-0">
        <div class="card border-0 p-0 m-0">
          <div class="p-2">
            <div class="col-md-2" <?php echo (true ? "" : "hidden") ?>>
              <p class="mb-1 text-secondary ">Search</p>
              <select name="dept" id="search_select" class="form-control">
                <?php
                if ($DISP_EMP_LIST) {
                ?>
                  <option value="all" <?php foreach ($DISP_EMP_LIST as $DISP_DISTINCT_DIVISION_ROW_1) {
                                        if ($DISP_DISTINCT_DIVISION_ROW_1['name'] == '') {
                                          echo 'selected';
                                        }
                                      } ?>>All </option>
                  <?php
                  foreach ($DISP_EMP_LIST as $DISP_DISTINCT_DIVISION_ROW) {
                    if ($DISP_DISTINCT_DIVISION_ROW['name'] != '') {
                  ?>
                      <option value="<?= $DISP_DISTINCT_DIVISION_ROW['zkteco_code'] ?>" <?php echo $search == $DISP_DISTINCT_DIVISION_ROW['zkteco_code'] ? 'selected' : '' ?>>
                        <?= $DISP_DISTINCT_DIVISION_ROW['name'] ?>
                      </option>
                <?php
                    }
                  }
                }
                ?>
              </select>
            </div>

            <div>
              <div class="float-right ">
                <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                <ul class="d-inline pagination m-0 p-0">
                  <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row" . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') . "'"; ?>>< </a></li>
                  <li><a href="?page=1&row=<?= $row . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1</a></li>
                  <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>...</a></li>
                  <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                  <li><a style="color:white; background-color:#007bff !important"><?= $current_page ?></a></li>
                  <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') ?>" <?php if ($current_page >= $last_page - 1) echo "hidden"; ?>><?= $next_page ?></a></li>
                  <li><a <?php if ($current_page >= $last_page - 1) echo "hidden"; ?>>...</a></li>
                  <li><a href="?page=<?= $last_page ?>&row=<?= $row . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') ?>" <?php if ($current_page == $last_page) echo "hidden"; ?>><?= $last_page ?></a></li>
                  <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page) echo "href='?page=$next_page&row=$row" . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') . "'"; ?>>> </a></li>
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
            <table class="table table-hover m-0" id="TableToExport" style="width:100%">
              <thead>
                <tr>
                  <th>Attendance&nbsp;ID</th>
                  <th>ZKTECO EMP&nbsp;ID</th>
                  <th>Employee&nbsp;Name</th>
                  <th>Punch&nbsp;Time</th>
                  <th>Punch&nbsp;State</th>
                  <th>Terminal&nbsp;SN</th>
                </tr>
              </thead>
              <tbody id="tbl_application_container">
                <?php if ($DISP_ATTENDANCE) {
                  foreach ($DISP_ATTENDANCE as $DISP_ATTENDANCE_ROW) {  ?>
                    <tr>
                      <td><?= $DISP_ATTENDANCE_ROW['id'] ?></td>
                      <td><?= $DISP_ATTENDANCE_ROW['empl_id'] ?></td>
                      <td><?= (isset($DISP_ATTENDANCE_ROW['employee_name'])) ? $DISP_ATTENDANCE_ROW['employee_name'] : ""; ?></td>
                      <td><?= $DISP_ATTENDANCE_ROW['punch_time'] ?></td>
                      <td>
                        <?php

                        if ($DISP_ATTENDANCE_ROW['punch_state'] == 0) {
                          echo ('Time In');
                        } elseif ($DISP_ATTENDANCE_ROW['punch_state'] == 4) {
                          echo ('Break In');
                        } elseif ($DISP_ATTENDANCE_ROW['punch_state'] == 5) {
                          echo ('Break Out');
                        } else {
                          echo ('Time Out');
                        }

                        ?></td>
                      <td><?= $DISP_ATTENDANCE_ROW['terminal_sn'] ?></td>
                    </tr>
                  <?php   }
                } else { ?>
                  <tr class="table-active">
                    <td colspan="12">
                      <center>No Records</center>
                    </td>
                  </tr>
                <?php }  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <aside class="control-sidebar control-sidebar-dark"></aside>
  <?php $this->load->view('templates/jquery_link'); ?>

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
  <?php
  if ($this->session->userdata('SESS_ERR_MSG_INSRT_APPROVER')) {
  ?>
    <script>
      Swal.fire(
        '<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_APPROVER'); ?>',
        '',
        'error'
      )
    </script>
  <?php
    $this->session->unset_userdata('SESS_ERR_MSG_INSRT_APPROVER');
  }
  ?>

  <?php
  function convert_emp($array, $id)
  {
    $result = "";
    foreach ($array as $row) {
      if ($row->col_empl_cmid == $id) {
        $result = $row->col_last_name . ', ' . $row->col_frst_name . ' ' . $row->col_midl_name;
      }
    }
    return $result;
  }
  ?>

  <script>
    $(document).ready(function() {
    
      $('#search_select').select2();
      var base_url = '<?= base_url(); ?>';
      $('#row_dropdown').on('change', function() {
        var optionValue = $('#search_data').val();
        var row_val = $(this).val();
        if (optionValue) {
          document.location.href = base_url + "attendances/zkteco_attendance?page=1&row=" + row_val + "&search=" + optionValue.replace(/\s/g, '_');
        } else {
          document.location.href = base_url + "attendances/zkteco_attendance?page=1&row=" + row_val;
        }
      });

      $("#clear_search_btn").on("click", function() {
        var url = window.location.href.split("?")[0];
        window.location = url
      });

      $("#search_select").on("change", function() {
        search();
      });

      function search() {
        let search_select = $("#search_select").find(":selected").val();
        console.log('search_select', search_select);
        if (!search_select) return;
        window.location.href = "?search=" + search_select.replace(/\s/g, '_');
      }

    });
  </script>

  <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> -->
  <!-- <script src="<?=base_url()?>assets_system/js/xlsx.full.min.js"></script>
  <script>
    document.getElementById("btn_export").addEventListener('click', function() {
      var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
      XLSX.writeFile(wb, "Route Leave.xlsx");
    });

  </script> -->
</body>

</html>