<html>
<?php $this->load->view('templates/css_link'); ?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<style>
  .check_approved{
    color: #3ec769;
    font-size: 18px;
  }
</style>
<?php 

  if(isset($_GET['row'])){
    $row = $_GET['row'];
  }
  else{
    $row = 25;
  }

   if(isset($_GET['page']))
   {
    $current_page = $_GET['page'];
   }else{
    $current_page = 1;
   }

   $prev_page = $current_page - 1;
   $next_page = $current_page + 1;
  //  $last_page = intval($C_DATA_COUNT/$row) + 1;
  $last_page_initial = ceil($C_DATA_COUNT / $row);
  $last_page = ($last_page_initial == 0 || $last_page_initial == 1) ? 1 : $last_page_initial;
                            
  if($C_DATA_COUNT == 0){
      $low_limit = 0;
  }
  else{
      $low_limit = $row*($current_page - 1) + 1;
  }
  if($current_page*$row > $C_DATA_COUNT){
      $high_limit = $C_DATA_COUNT;
  }
  else{
      $high_limit = $row*($current_page);
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
          <li class="breadcrumb-item active" aria-current="page">Zkteco Attendance
          </li>
        </ol>
      </nav>
      <div class="row pt-1">
        <div class="col-md-6">
          <h1 class="page-title">Zkteco Attendance<h1>
        </div>
      </div>
      <hr>
      <div class="pb-1">

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
              <p class ="p-0 m-0 d-inline" style = "color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT?> entries&nbsp;</p>
                <ul class="d-inline pagination m-0 p-0 ">
                <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>> < </a></li>
                  <li><a href = "?page=1&row=<?=$row?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                  <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                  <li><a href = "?page=<?= $current_page - 1?>&row=<?=$row?>"   <?php if ($current_page <= 2) echo "hidden";?>><?= $prev_page?></a></li>
                  <li><a style = "color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                  <li><a href = "?page=<?= $current_page + 1?>&row=<?=$row?>"  <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>  ><?= $next_page?>  </a></li>
                  <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>...  </a></li>
                  <li><a href = "?page=<?= $last_page?>&row=<?=$row?>" <?php if ($current_page == $last_page) echo "hidden"; ?>><?= $last_page?> </a></li>
                  <li><a style="margin-right: 10px;"    <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>>    </a></li>
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
              <?php if($DISP_ATTENDANCE) {
                    foreach($DISP_ATTENDANCE as $DISP_ATTENDANCE_ROW ){  ?>
                    <tr>
                        <td><?=$DISP_ATTENDANCE_ROW['id']?></td>
                        <td><?=$DISP_ATTENDANCE_ROW['empl_id']?></td>
                        <td><?= (isset($DISP_ATTENDANCE_ROW['employee_name'])) ? $DISP_ATTENDANCE_ROW['employee_name'] : ""; ?></td>
                        <td><?=$DISP_ATTENDANCE_ROW['punch_time']?></td>
                        <td>
                          <?php
                          
                          if($DISP_ATTENDANCE_ROW['punch_state'] == 0) {
                            echo ('Time In');
                          }
                          elseif($DISP_ATTENDANCE_ROW['punch_state'] == 4) {
                            echo ('Break In');
                          }
                          elseif($DISP_ATTENDANCE_ROW['punch_state'] == 5) {
                            echo ('Break Out');
                          }     else{
                            echo ('Time Out');
                          }
                          
                          ?></td>
                        <td><?=$DISP_ATTENDANCE_ROW['terminal_sn']?></td>
                    </tr>
              <?php   } 
                  }else { ?>
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
    function convert_emp($array, $id){
        $result = "";
        foreach($array as $row){
            if($row->col_empl_cmid == $id ){
                $result = $row->col_last_name.', '.$row->col_frst_name.' '.$row->col_midl_name;
            }
        }
        return $result;
    }
?>

  <script>
    $(document).ready(function() {

    var base_url = '<?= base_url(); ?>';


    $('#row_dropdown').on('change', function () {
        var row_val = $(this).val(); 
        document.location.href = base_url + "attendances/zkteco_attendance?page=1&row=" + row_val ; 
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