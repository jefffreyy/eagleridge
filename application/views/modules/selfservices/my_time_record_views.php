<html>
<style>
  /* Define a class for the scaling transformation */
  .scaled-content {
    transform: scale(0.7) !important;
    transform-origin: top left !important;
    /* Optional: set the scaling origin */
  }
</style>
<?php $this->load->view('templates/css_link'); ?>
<style>
  .check_approved {
    color: #3ec769;
    font-size: 18px;
  }

  tr.bg-light-regular {
    background-color: #FFFFFF;
  }

  tr.bg-light-rest {
    background-color: #FFF4F2;
  }

  tr.bg-light-legal {
    background-color: #DEF0FE;
  }

  tr.bg-light-special {
    background-color: #F5E9FF;
  }
</style>
<style>
  .hover {
    cursor: pointer;
  }
</style>

<style>
  @media print {

    #TableToExport {
      width: 100% !important;
      /* table-layout: fixed; */

    }

    @page {
      size: landscape;
      margin: 5mm;

    }

    body {
      margin: 0;
      transform: scale(0.5) !important;
    }
  }
</style>



<?php
if (isset($_GET['row'])) {
  $row = $_GET['row'];
} else {
  $row = 10;
}

if (isset($_GET['yearmonth_from'])) {
  $yearmonth_from = $_GET['yearmonth_from'];
} else {
  $yearmonth_from = date('Y-m-01');
}
if (isset($_GET['yearmonth_to'])) {
  $yearmonth_to = $_GET['yearmonth_to'];
} else {
  $yearmonth_to = date('Y-m-t');
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

      <div class="row pt-1">
        <div class="col-md-6">
          <h1 class="page-title d-flex align-items-center">
            <a onclick="afterRenderFunction()" href="<?= base_url() . 'selfservices'; ?>">
              <img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
            </a>
            &nbsp;My Time Record
            <h1>
        </div>

        <div class='col-md-6 button-title d-flex justify-content-end'>
          <a href="" class="btn btn-primary shadow-none d-flex align-items-center mr-1" id="btn_export"><img class="" src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>" alt="">
            &nbsp;Export XLSX</a>
          <button id="printButton" class="btn btn-primary shadow-none d-flex align-items-center"><img style="height: 18px: width: 17px;" src="<?= base_url('assets_system/icons/print-duotone_sm.svg') ?>" alt="">&nbsp;Print</button>
        </div>
      </div>
      <hr>
      <div class="pb-1">
      </div>

      <div class="card border-0 p-0 m-0">
        <div class="p-1">
          <div class="row">
            <div class="col-md-3">
              <div class='m-2'>
                <h6 class='p-0 mb-1'>Date From</h6>
                <input class="custom-select " type="date" id="year-month1" name="start" value="<?= $yearmonth_from ?>">
              </div>
            </div>

            <div class="col-md-3">
              <div class='m-2'>
                <h6 class='p-0 mb-1'>Date To</h6>
                <input class="custom-select " type="date" id="year-month2" name="end" value="<?= $yearmonth_to ?>">
              </div>
            </div>

            <!-- <div class="col-md-3">
              <div class='m-2'>
                <h6 class='p-0 mb-1'>Salary Type</h6>
                <input class="custom-select " type="text" value="<?= $C_SALARY_TYPE ?>" disabled>
              </div>
            </div> -->
          </div>
        </div>
      </div>

      <div class="card border-0 p-0 m-0">
        <div class="p-2" hidden>
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

        <?php
        $absence_val = 0;
        if (($AWOL == 0 && $LWOP == 1) || ($AWOL == 1 && $LWOP == 0)) {
          $absence_val = 1;
        } elseif ($AWOL == 1 && $LWOP == 1) {
          $absence_val = 2;
        } elseif ($AWOL == 0 && $LWOP == 0) {
          $absence_val = 0;
        }
        ?>
        <div class="table-responsive" id="tableDiv" style="min-height: 70vh !important">
          <table class="table table-bordered  m-0" id="TableToExport" style="width:100%">
            <thead>
              <tr style="line-height: 7px">
                <th rowspan="3" style="text-align: left">DATE</th>
                <th rowspan="3" style="text-align: left">DAY&nbsp;CODE</th>
                <th rowspan="3" style="text-align: left;line-height: 1">SHIFT CODE</th>
                <th colspan="6" style="text-align: center">SHIFT TIME</th>
                <th colspan="4" style="text-align: center">ACTUAL TIME</th>
                <th colspan="2" style="text-align: center">TOTAL ACTUAL TIME</th>
                <!-- <th rowspan="3" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">REG</th>
                <th rowspan="3" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">ND</th>
                <th rowspan="2" colspan="2" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">SHIFT</th>
                <th rowspan="2" colspan="4" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">APPROVED</th>
                <th rowspan="2" colspan="<?= $absence_val ?>" style="text-align: center;  background-color: #FFDADA" <?= ($absence_val == 0) ? "hidden" : '' ?>>Absences</th>
                <th rowspan="2" colspan="4" style="text-align: center;  background-color: #FFD779">Deductions</th> -->
                <!-- <th rowspan="3" style="text-align: center">TOTAL DAILY HOURS</th>
                <th rowspan="3" style="text-align: center">DAILY OVERTIME</th> -->
                <th rowspan="3" style="text-align: center">REMARKS</th>
              </tr>
              <tr style="line-height: 7px">
                <th colspan="2" style="text-align: center">REGULAR</th>
                <th colspan="2" style="text-align: center">BREAK</th>
                <th colspan="2" style="text-align: center">OVERTIME</th>
                <th colspan="2" style="text-align: center">REGULAR</th>
                <th colspan="2" style="text-align: center">BREAK</th>
                <th colspan="2" style="text-align: center">DAILY</th>
                <!-- <th colspan="2" style="text-align: center">BREAK</th> -->
              </tr>
              <tr style="line-height: 7px">
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">IN</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">OUT</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">IN</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">OUT</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">IN</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">OUT</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">IN</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">OUT</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">IN</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">OUT</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">HOURS</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">OVERTIME</th>
                <!-- <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">OT</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">NDOT</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">LEAV</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">HOLW</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">OT</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">NDOT</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #FFDADA" <?= ($LWOP != 0) ? "" : 'hidden' ?>>LWOP</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #FFDADA" <?= ($AWOL != 0) ? "" : 'hidden' ?>>AWOL</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #FFD779">TARD</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #FFD779">UT</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #FFD779">EARB</th>
                <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #FFD779">OVRB</th> -->
              </tr>
            </thead>
            <tbody id="tbl_application_container">
              <?php if ($ATTENDANCE_DATA) {
                foreach ($ATTENDANCE_DATA as $ATTENDANCE_DATA_ROW) {
                  if ($ATTENDANCE_DATA_ROW['day_code'] == 'REGULAR' && $ATTENDANCE_DATA_ROW['shift_code'] != "REST") {
                    $row_color = 'bg-light-regular';
                  } elseif ($ATTENDANCE_DATA_ROW['day_code'] == 'REGULAR' && $ATTENDANCE_DATA_ROW['shift_code'] == "REST") {
                    $row_color = 'bg-light-rest';
                  } elseif ($ATTENDANCE_DATA_ROW['day_code'] == 'LEGAL' && $ATTENDANCE_DATA_ROW['shift_code'] != "REST") {
                    $row_color = 'bg-light-legal';
                  } elseif ($ATTENDANCE_DATA_ROW['day_code'] == 'LEGAL' && $ATTENDANCE_DATA_ROW['shift_code'] == "REST") {
                    $row_color = 'bg-light-legal';
                  } elseif ($ATTENDANCE_DATA_ROW['day_code'] == 'SPECIAL' && $ATTENDANCE_DATA_ROW['shift_code'] != "REST") {
                    $row_color = 'bg-light-special';
                  } elseif ($ATTENDANCE_DATA_ROW['day_code'] == 'SPECIAL' && $ATTENDANCE_DATA_ROW['shift_code'] == "REST") {
                    $row_color = 'bg-light-special';
                  }
              ?>


                  <tr class='<?= $row_color ?> cutoff'>
                    <td class="text-left"><?= date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($ATTENDANCE_DATA_ROW['date'])) ?></td>
                    <td class="text-left"><?= $ATTENDANCE_DATA_ROW['day_code'] ?></td>
                    <td class="text-left"><?= $ATTENDANCE_DATA_ROW['shift_code'] ?></td>
                    <td><?= $ATTENDANCE_DATA_ROW['shift_time_in'] ?></td>
                    <td><?= $ATTENDANCE_DATA_ROW['shift_time_out'] ?></td>
                    <td><?= $ATTENDANCE_DATA_ROW['shift_break_start'] ?></td>
                    <td><?= $ATTENDANCE_DATA_ROW['shift_break_end'] ?></td>
                    <td><?= $ATTENDANCE_DATA_ROW['time_overtime_start'] ?></td>
                    <td><?= $ATTENDANCE_DATA_ROW['time_overtime_end'] ?></td>

                    <?php if (!empty($ATTENDANCE_DATA_ROW['snapshot_in']) || !empty($ATTENDANCE_DATA_ROW['time_in_address'])) { ?>
                      <td onclick="remoteInfo('<?php echo $ATTENDANCE_DATA_ROW['snapshot_in']; ?>','<?php echo $ATTENDANCE_DATA_ROW['time_in_address']; ?>')" style="font-weight: 450;color:blue" class="hover">
                        <?= $ATTENDANCE_DATA_ROW['time_in'] ?>
                        <img src="<?= base_url() ?>assets_system/icons/circle-info-solid_2xs.svg" alt="">
                      </td>
                    <?php } else { ?>
                      <td><?= $ATTENDANCE_DATA_ROW['time_in'] ?></td>
                    <?php } ?>

                    <?php if (!empty($ATTENDANCE_DATA_ROW['snapshot_out']) || !empty($ATTENDANCE_DATA_ROW['time_out_address'])) { ?>
                      <td onclick="remoteInfoOut('<?php echo $ATTENDANCE_DATA_ROW['snapshot_out']; ?>','<?php echo $ATTENDANCE_DATA_ROW['time_out_address']; ?>')" style="font-weight: 450;color:blue" class="hover">
                        <?= $ATTENDANCE_DATA_ROW['time_out'] ?>
                        <img src="<?= base_url() ?>assets_system/icons/circle-info-solid_2xs.svg" alt="">
                      </td>
                    <?php } else { ?>
                      <td><?= $ATTENDANCE_DATA_ROW['time_out'] == '00:00' ? '' : $ATTENDANCE_DATA_ROW['time_out'] ?></td>
                    <?php } ?>

                    <?php if (!empty($ATTENDANCE_DATA_ROW['break_in_snapshot']) || !empty($ATTENDANCE_DATA_ROW['break_in_address'])) { ?>
                      <td onclick="remoteBreakInfo('<?= $ATTENDANCE_DATA_ROW['break_in_snapshot'] ?>','<?= $ATTENDANCE_DATA_ROW['break_in_address'] ?>','Break In Address','Break In Snapshot')" style="font-weight: 450;color:blue" class="hover">
                        <?= $ATTENDANCE_DATA_ROW['break_in'] ?>
                        <img src="<?= base_url() ?>assets_system/icons/circle-info-solid_2xs.svg" alt="">
                      </td>
                    <?php } else { ?>
                      <td><?= $ATTENDANCE_DATA_ROW['break_in'] ?></td>
                    <?php } ?>

                    <?php if (!empty($ATTENDANCE_DATA_ROW['break_out_snapshot']) || !empty($ATTENDANCE_DATA_ROW['break_out_address'])) { ?>
                      <td onclick="remoteBreakInfo('<?= $ATTENDANCE_DATA_ROW['break_out_snapshot'] ?>','<?= $ATTENDANCE_DATA_ROW['break_out_address'] ?>','Break Out Address','Break Out Snapshot')" style="font-weight: 450;color:blue" class="hover">
                        <?= $ATTENDANCE_DATA_ROW['break_out'] ?>
                        <img src="<?= base_url() ?>assets_system/icons/circle-info-solid_2xs.svg" alt="">
                      </td>
                    <?php } else { ?>
                      <td><?= $ATTENDANCE_DATA_ROW['break_out'] ?></td>
                    <?php } ?>

                    <?php
                    if (!function_exists('calculateWorkedHours')) {
                      function calculateWorkedHours($data)
                      {
                        if (empty($data['time_in']) || empty($data['time_out'])) {
                          return null;
                        }

                        $shiftStart = !empty($data['shift_time_in']) ? strtotime($data['shift_time_in']) : null;
                        $shiftEnd = !empty($data['shift_time_out']) ? strtotime($data['shift_time_out']) : null;
                        $breakStart = !empty($data['shift_break_start']) ? strtotime($data['shift_break_start']) : null;
                        $breakEnd = !empty($data['shift_break_end']) ? strtotime($data['shift_break_end']) : null;
                        $overtimeStart = !empty($data['time_overtime_start']) ? strtotime($data['time_overtime_start']) : null;
                        $overtimeEnd = !empty($data['time_overtime_end']) ? strtotime($data['time_overtime_end']) : null;
                        $timeIn = strtotime($data['time_in']);
                        $timeOut = strtotime($data['time_out']);
                        $breakIn = !empty($data['break_in']) ? strtotime($data['break_in']) : null;
                        $breakOut = !empty($data['break_out']) ? strtotime($data['break_out']) : null;

                        // Calculate total break duration
                        $totalBreakSeconds = 0;
                        if ($breakStart && $breakEnd) {
                          $totalBreakSeconds += $breakEnd - $breakStart;
                        }
                        if ($breakIn && $breakOut) {
                          $totalBreakSeconds += $breakOut - $breakIn;
                        }

                        // Calculate total overtime duration
                        $totalOvertimeSeconds = 0;
                        if ($overtimeStart && $overtimeEnd) {
                          $totalOvertimeSeconds = $overtimeEnd - $overtimeStart;
                        }

                        // Calculate actual worked hours excluding breaks
                        $workedSeconds = ($timeOut - $timeIn) - $totalBreakSeconds + $totalOvertimeSeconds;

                        // Calculate shift duration in seconds
                        $shiftDurationSeconds = $shiftStart && $shiftEnd ? $shiftEnd - $shiftStart : 0;

                        // Subtract total break seconds from shift duration
                        $adjustedShiftDurationSeconds = $shiftDurationSeconds + $totalOvertimeSeconds - $totalBreakSeconds;

                        // If workedSeconds exceed the adjusted shift duration, cap it at adjusted shift duration
                        if ($adjustedShiftDurationSeconds > 0 && $workedSeconds > $adjustedShiftDurationSeconds) {
                          $workedSeconds = $adjustedShiftDurationSeconds;
                        }

                        // Convert seconds to hours and floor to the nearest whole number
                        $workedHours = floor($workedSeconds / 3600);

                        // If workedHours is negative, return null
                        if ($workedHours < 0) {
                          return null;
                        }

                        // Format workedHours to 2 decimal places with .00 ending
                        return number_format($workedHours, 2, '.', '');
                      }
                    }

                    $workedHours = calculateWorkedHours($ATTENDANCE_DATA_ROW);
                    ?>

                    <td><?= is_null($workedHours) ? '' : $workedHours ?></td>

                    <td><?= $ATTENDANCE_DATA_ROW['reg_ot'] ?></td>


                    <!-- <td></td>
                    <td></td> -->

                    <td><?php echo $ATTENDANCE_DATA_ROW['paid_leave'] ? 'Approved Leave' : ''  ?></td>

                    <!-- <td></td>
                    <td><?= $ATTENDANCE_DATA_ROW['reg_ot'] ?></td>
                    <td><?= $ATTENDANCE_DATA_ROW['nd_ot'] ?></td>
                    <td <?= ($LWOP != 0) ? "" : 'hidden' ?>> <?= $ATTENDANCE_DATA_ROW['lwop'] ?></td>
                    <td <?= ($AWOL != 0) ? "" : 'hidden' ?>> <?= $ATTENDANCE_DATA_ROW['awol'] ?></td>
                    <td><?= $ATTENDANCE_DATA_ROW['tardiness'] ?></td>
                    <td><?= $ATTENDANCE_DATA_ROW['undertime'] ?></td>
                    <td></td>
                    <td></td> -->
                  </tr>
                <?php   }
              } else { ?>
                <tr class="table-active">
                  <td colspan="12">
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

  <aside class="control-sidebar control-sidebar-dark">
  </aside>
  <!-- Remote Info Modal Starts-->
  <div class="modal fade vertical-centered" id="remoteInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="d-flex justify-content-end">
          <button type="button" class="close pr-3 pt-2" data-dismiss="modal" aria-label="Close" style="font-size: 34px;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="col card d-flex justify-content-center align-items-center">
            <div class="card" style="width: 18rem;" id="remoteSnapshot">

            </div>
          </div>
          <div class="col card d-flex justify-content-center align-items-center">
            <div class="card" style="width: 18rem;" id="remoteAddress">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Remote Info Modal Ends-->
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
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCy_b_G7emL5aBoKkflJShoo_QEwO6afb8&libraries=geometry&loading=async"></script>
  <script>
    function remoteInfo(snapshot_in, address_in) {
      const baseUrl = '<?php echo base_url() . 'assets_user/snapshots/'; ?>';
      if (snapshot_in) {
        document.getElementById("remoteSnapshot").innerHTML =
          `<img src="${baseUrl}${snapshot_in}" class="card-img-top" alt="snapshot in">
                <div class="card-body">
                  <h5 class="card-title text-center w-100">Time In Snapshot</h5>
                </div>`
      } else {
        document.getElementById("remoteSnapshot").innerHTML = '';
      }
      if (address_in) {
        let coordinates = address_in.split(',');
        let latlng = new google.maps.LatLng(coordinates[0], coordinates[1]);
        let geocoder = new google.maps.Geocoder();
        geocoder.geocode({
          'latLng': latlng
        }, (results, status) => {
          document.getElementById("remoteAddress").innerHTML =
            `<iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d18820.036574374346!2d${address_in.split(',')[1]}!3d${address_in.split(',')[0]}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTXCsDE4JzU2LjgiTiAxMjDCsDMyJzQ4LjkiRQ!5e1!3m2!1sen!2sph!4v1699500707383!5m2!1sen!2sph" width="300" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div class="card-body">
                  <h5 class="card-title text-center w-100">Time In Address</h5>
                  <h6>${results[0].formatted_address}</h6>
                </div>`
        });

      } else {
        document.getElementById("remoteAddress").innerHTML = ''
      }
      $('#remoteInfo').modal('show');
    }

    function remoteInfoOut(snapshot_out, address_out) {
      const baseUrl = '<?php echo base_url() . 'assets_user/snapshots/'; ?>';
      if (snapshot_out) {
        document.getElementById("remoteSnapshot").innerHTML =
          `<img src="${baseUrl}${snapshot_out}" class="card-img-top" alt="snapshot">
                <div class="card-body">
                  <h5 class="card-title text-center w-100">Time Out Snapshot</h5>
                </div>`
      } else {
        document.getElementById("remoteSnapshot").innerHTML = '';
      }
      if (address_out) {
        let coordinates = address_out.split(',');
        let latlng = new google.maps.LatLng(coordinates[0], coordinates[1]);
        let geocoder = new google.maps.Geocoder();
        geocoder.geocode({
          'latLng': latlng
        }, (results, status) => {
          document.getElementById("remoteAddress").innerHTML =
            `<iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d18820.036574374346!2d${address_out.split(',')[1]}!3d${address_out.split(',')[0]}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTXCsDE4JzU2LjgiTiAxMjDCsDMyJzQ4LjkiRQ!5e1!3m2!1sen!2sph!4v1699500707383!5m2!1sen!2sph" width="300" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div class="card-body">
                  <h5 class="card-title text-center w-100">Time Out Address</h5>
                  <h6>${results[0].formatted_address}</h6>
                </div>`
        });
        // document.getElementById("remoteAddress").innerHTML =
        //   `<iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d18820.036574374346!2d${address_out.split(',')[1]}!3d${address_out.split(',')[0]}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTXCsDE4JzU2LjgiTiAxMjDCsDMyJzQ4LjkiRQ!5e1!3m2!1sen!2sph!4v1699500707383!5m2!1sen!2sph" width="300" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        //         <div class="card-body">
        //           <h5 class="card-title text-center w-100">Time Out Address</h5>
        //         </div>`
      } else {
        document.getElementById("remoteAddress").innerHTML = ''
      }
      $('#remoteInfo').modal('show');
    }

    function remoteBreakInfo(snapshot_out, address_out, address_text = '', snapshot_text = '') {
      const baseUrl = '<?php echo base_url() . 'assets_user/snapshots/'; ?>';
      if (snapshot_out) {
        document.getElementById("remoteSnapshot").innerHTML =
          `<img src="${baseUrl}${snapshot_out}" class="card-img-top" alt="snapshot">
                <div class="card-body">
                  <h5 class="card-title text-center w-100">${snapshot_text}</h5>
                </div>`
      } else {
        document.getElementById("remoteSnapshot").innerHTML = '';
      }
      if (address_out) {
        let coordinates = address_out.split(',');
        let latlng = new google.maps.LatLng(coordinates[0], coordinates[1]);
        let geocoder = new google.maps.Geocoder();
        geocoder.geocode({
          'latLng': latlng
        }, (results, status) => {
          document.getElementById("remoteAddress").innerHTML =
            `<iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d18820.036574374346!2d${address_out.split(',')[1]}!3d${address_out.split(',')[0]}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTXCsDE4JzU2LjgiTiAxMjDCsDMyJzQ4LjkiRQ!5e1!3m2!1sen!2sph!4v1699500707383!5m2!1sen!2sph" width="300" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div class="card-body">
                  <h5 class="card-title text-center w-100">${address_text}</h5>
                  <h6>${results[0].formatted_address}</h6>
                </div>`
        });
        // document.getElementById("remoteAddress").innerHTML =
        //   `<iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d18820.036574374346!2d${address_out.split(',')[1]}!3d${address_out.split(',')[0]}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTXCsDE4JzU2LjgiTiAxMjDCsDMyJzQ4LjkiRQ!5e1!3m2!1sen!2sph!4v1699500707383!5m2!1sen!2sph" width="300" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        //         <div class="card-body">
        //           <h5 class="card-title text-center w-100">${address_text}</h5>
        //         </div>`
      } else {
        document.getElementById("remoteAddress").innerHTML = ''
      }
      $('#remoteInfo').modal('show');
    }
  </script>
  <script>
    $(document).ready(function() {
      var base_url = '<?= base_url(); ?>';

      function writeData(doc, xAxis, yAxis, className) {
        $(className).each(function() {
          doc.text(xAxis, yAxis, $(this).text());
          yAxis += 3.5
        });
      }
      async function getData() {
        try {
          const data = await $.ajax({
            url: '<?= base_url() ?>attendances/getEmployee/' + "<?= $this->session->userdata('SESS_USER_ID') ?>",
            method: 'GET',
            dataType: 'json'
          });
          return data;
        } catch (error) {
          console.error(error);
        }
      }
      $(".btn-export_pdf").on("click", function() {
        getData().then((res) => {
          console.log(res);
          var employeeInfo = res[0];
          var imgData = "<?= base64_encode(file_get_contents(base_url('assets_system/images/login_logo.png'))) ?>";
          var pdfImage = "<?= base64_encode(file_get_contents(base_url('assets_system/forms/user_attendance_records.jpg'))) ?>"
          var doc = new jsPDF("p", "mm", "a4");
          var width = doc.internal.pageSize.width;
          var height = doc.internal.pageSize.height;
          var dateData = new Date().toJSON().slice(0, 10);
          var xAjustment = 8;
          doc.setFontSize(40)
          doc.addImage("data:image/jpg;base64," + pdfImage, 'JPG', 0, 0, width, height)
          doc.addImage("data:image/png;base64," + imgData, 'PNG', 10, 10, 60, 0)
          doc.setFontSize(7)
          doc.text(50, 43, dateData);
          doc.text(50, 46, employeeInfo.lastname + ' ' + employeeInfo.firstname + ',' + employeeInfo.middlename);
          doc.text(50, 49.5, employeeInfo.position);
          doc.text(50, 53, employeeInfo.salary_type);
          doc.text(139, 43, $('#cutoff_period option:selected').text().trim());
          doc.text(139, 46, employeeInfo.department);
          doc.text(139, 49.5, employeeInfo.project_name);
          doc.text(139, 53, employeeInfo.empl_group);
          let yAxis = 66.2;
          Array.from($('.cutoff')).forEach(function(row) {

            doc.text(19, yAxis, $(row).children()[0].innerText)
            doc.text(48.5, yAxis, $(row).children()[1].innerText)
            doc.text(75.5, yAxis, $(row).children()[2].innerText)
            doc.text(100.5, yAxis, $(row).children()[3].innerText)
            doc.text(125.5, yAxis, $(row).children()[5].innerText)
            doc.text(150.5, yAxis, $(row).children()[7].innerText)
            doc.text(175.5, yAxis, $(row).children()[9].innerText)

            yAxis += 5.7
          })
          window.open(doc.output('bloburl'), '_blank');
        })
      });
      $('#cutoff_period').on('change', function() {
        var row_val = $('#row_dropdown').val();
        var cutoff = $(this).val();
        document.location.href = base_url + "selfservices/my_time_records?page=1&row=" + row_val + "&cutoff=" + cutoff;
      })

      $('#row_dropdown').on('change', function() {
        var row_val = $(this).val();
        var cutoff = $('#select_cutoff').val();
        document.location.href = base_url + "selfservices/my_time_records?page=1&row=" + row_val;
      });
      $("#year-month1").on("change", function() {
        filter_data();
      })
      $("#year-month2").on("change", function() {
        filter_data();
      })

      function filter_data(page_row) {
        if (page_row == null || page_row == "") {
          page_row = '?page=' + "<?= $current_page ?>" + '&row=' + "<?= $row ?>"
        }
        var yearmonth_from = $("#year-month1").val();
        var yearmonth_to = $("#year-month2").val();
        let row = $("#row_dropdown").val();
        window.location = base_url + "selfservices/my_time_records" + page_row + "&yearmonth_from=" + yearmonth_from + "&yearmonth_to=" + yearmonth_to;
      }
    });
  </script>
  <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> -->
  <script src="<?= base_url() ?>assets_system/js/xlsx.full.min.js"></script>
  <script>
    document.getElementById("btn_export").addEventListener('click', function() {
      var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
      XLSX.writeFile(wb, "My Time Record.xlsx");
    });
  </script>

  <script>
    $(document).ready(function() {
      $("#printButton").click(function() {
        printTable();
      });

      function printTable() {
        var printContents = $("#tableDiv").html();
        var originalContents = $("body").html();
        var scaledContents = '<div class="scaled-content-p7" style="margin: 15px 0; padding: 0;">' + printContents + '</div>';

        // Apply styles for printing
        var styleSheet = '<style type="text/css">';
        styleSheet += '@page { margin: 15px 0; size: }';
        styleSheet += '</style>';
        scaledContents = styleSheet + scaledContents;

        // styleSheet += '@page { margin: 15px 0; size: landscape;margin: 5mm;size: 13in 8.5in !important; }';

        $("body").html(scaledContents);
        window.print();

        $("body").html(originalContents);
      }
    });
  </script>




</body>

</html>