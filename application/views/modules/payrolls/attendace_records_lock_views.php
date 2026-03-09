<html>
<?php $this->load->view('templates/css_link'); ?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<style>
  .check_approved {
    color: #3ec769;
    font-size: 18px;
  }
</style>
<?php

if (isset($_GET['cutoff'])) {
  $cutoff = $_GET['cutoff'];
} else {
  $cutoff = $CUTOFF_INITIAL;
}


if (isset($_GET['row'])) {
  $row = $_GET['row'];
} else {
  $row = 10;
}

if (isset($_GET['page'])) {
  $current_page = $_GET['page'];
} else {
  $current_page = 1;
}

$prev_page = $current_page - 1;
$next_page = $current_page + 1;
$last_page = intval($C_DATA_COUNT / $row) + 1;

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
            <a href="<?= base_url() ?>payrolls">Payroll</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Attendance Records Lock
          </li>
        </ol>
      </nav>
      <div class="row pt-1">
        <div class="col d-flex align-items-center">
          <a href="<?= base_url() . 'superadministrators'; ?>"><i class="h3 mr-3 fa-duotone fa-circle-left"></i></a>
          <h1 class="page-title d-inline">Attendance Records Lock</h1>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-3">
          <div class="small-box bg-light">
            <div class="inner">
              <h3> <?= (!$C_TOTAL_RECORD_COUNT) ? 0 : $C_TOTAL_RECORD_COUNT; ?> </h3>
              <p>Total Records Lock</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-md-2">
          <p class="mb-1 text-secondary ">Cut-off</p>
          <select name="filter_cutoff" id="filter_cutoff" class="form-control">
            <?php

            if ($DISP_CUTOFF) {
              foreach ($DISP_CUTOFF as $DISP_CUTOFF_ROW) {
            ?>
                <option value="<?= $DISP_CUTOFF_ROW->id ?>" <?php echo ($cutoff == $DISP_CUTOFF_ROW->id ? 'selected' : '') ?>>
                  <?= $DISP_CUTOFF_ROW->name ?>
                </option>
            <?php
              }
            }
            ?>
          </select>
        </div>

        <div class="col-md-2">
          <p class="mb-1 text-secondary ">Action</p>
          <a href=<?= base_url() . "payrolls/attendance_records_lock" ?> id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
        </div>
      </div>

      <div class="card border-0 p-0 m-0">
        <!-- <div class="p-1">
          <div class="col-md-4 pl-0">
            <div class="input-group p-1 pt-2">
              <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
              <input type="text" class="form-control" placeholder="Search" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
            </div>
          </div>
        </div> -->
        <div class="card border-0 p-0 m-0">
          <div class="p-2">
            <div>
              <div class="float-right ">
                <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                <ul class="d-inline pagination m-0 p-0 ">
                  <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
                      < </a>
                  </li>
                  <li><a href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                  <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                  <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                  <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                  <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                  <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                  <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page) echo "hidden"; ?>><?= $last_page ?> </a></li>
                  <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
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
                  <th>Employee&nbsp;Id</th>
                  <th>Period</th>
                  <th>Present</th>
                  <th>absent</th>
                  <th>tardiness</th>
                  <th>undertime</th>
                  <th>Paid&nbsp;leave</th>
                  <th>reg&nbsp;hours</th>
                  <th>reg&nbsp;ot</th>
                  <th>reg&nbsp;nd</th>
                  <th>reg&nbsp;ndot</th>
                  <th>rest&nbsp;hours</th>
                  <th>rest&nbsp;ot</th>
                  <th>rest&nbsp;nd</th>
                  <th>rest&nbsp;ndot</th>
                  <th>leg&nbsp;hours</th>
                  <th>leg&nbsp;ot</th>
                  <th>leg&nbsp;nd</th>
                  <th>leg&nbsp;ndot</th>
                  <th>legrest&nbsp;hours</th>
                  <th>legrest&nbsp;ot</th>
                  <th>legrest&nbsp;nd</th>
                  <th>legrest&nbsp;ndot</th>
                  <th>spe&nbsp;hours</th>
                  <th>spe&nbsp;ot</th>
                  <th>spe&nbsp;nd</th>
                  <th>spe&nbsp;ndot</th>
                  <th>sperest&nbsp;hours</th>
                  <th>sperest&nbsp;ot</th>
                  <th>sperest&nbsp;nd</th>
                  <th>sperest&nbsp;ndot</th>
                  <th>status</th>
                </tr>
              </thead>
              <tbody id="tbl_application_container">
                <?php if ($DISP_ATTENDANCE_LOCK) {
                  foreach ($DISP_ATTENDANCE_LOCK as $DISP_ATTENDANCE_LOCK_ROW) {  ?>
                    <tr>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->empl_id ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->period ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->present ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->absent ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->tardiness ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->undertime ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->paid_leave ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->reg_hours ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->reg_ot ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->reg_nd ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->reg_ndot ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->rest_hours ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->rest_ot ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->rest_nd ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->rest_ndot ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->leg_hours ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->leg_ot ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->leg_nd ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->leg_ndot ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->legrest_hours ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->legrest_ot ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->legrest_nd ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->legrest_ndot ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->spe_hours ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->spe_ot ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->spe_nd ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->spe_ndot ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->sperest_hours ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->sperest_ot ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->sperest_nd ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->sperest_ndot ?></td>
                      <td><?= $DISP_ATTENDANCE_LOCK_ROW->status ?></td>
                    </tr>
                  <?php   }
                } else { ?>
                  <tr class="table-active">
                    <td colspan="100%">
                      <center>No Data</center>
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
  <!-- Content Ends -->

  <aside class="control-sidebar control-sidebar-dark">
  </aside>

  <?php $this->load->view('templates/jquery_link'); ?>


  <!-- SESSION MESSAGES -->
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

      var base_url = '<?= base_url(); ?>';


      $("#filter_cutoff").on("change", function() {
        filter_data();
      })

      function filter_data(page_row) {

        if (page_row == null || page_row == "") {
          page_row = '?page=' + "<?= $current_page ?>" + '&row=' + "<?= $row ?>"
        }

        let cutoff = $("#filter_cutoff").find(":selected").val();

        window.location = base_url + "payrolls/attendance_records_lock" + page_row + "&cutoff=" + cutoff;
      }

      $('#row_dropdown').on('change', function(e) {
        e.preventDefault()
        var row_val = $(this).val();
        let data = "?page=1&row=" + row_val;
        filter_data(data);
      });



    });
  </script>
  <!-------------------- Export ----------------->
  <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
  <script>
    document.getElementById("btn_export").addEventListener('click', function() {
      /* Create worksheet from HTML DOM TABLE */
      var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
      /* Export to file (start a download) */
      XLSX.writeFile(wb, "Route Leave.xlsx");
    });
  </script>
</body>

</html>