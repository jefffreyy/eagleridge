<html>
<?php $this->load->view('templates/css_link'); ?>

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
    $row = 10;
  }

  // if(isset($_GET['yearmonth'])){
  //   $yearmonth = $_GET['yearmonth'];
  // }
  // else{
  //   $yearmonth = date('Y-m');
  // }

  if(isset($_GET['yearmonth_from'])){
    $yearmonth_from = $_GET['yearmonth_from'];
  }
  else{
    $yearmonth_from = date('Y-m-01');
  }
  
  if(isset($_GET['yearmonth_to'])){
    $yearmonth_to = $_GET['yearmonth_to'];
  }
  else{
    $yearmonth_to = date('Y-m-t');
  }
  

   if(isset($_GET['page']))
   {
    $current_page = $_GET['page'];
   }else{
    $current_page = 1;
   }

   $prev_page = $current_page - 1;
   $next_page = $current_page + 1;
   $last_page = intval($C_DATA_COUNT/$row) + 1;
                            
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
            <a href="<?= base_url() ?>selfservices">Self-services</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">My Attendance Record
          </li>
        </ol>
      </nav>
      <div class="row pt-1">
        <div class="col-md-6">
          <h1 class="page-title">My Attendance Record<h1>
        </div>
        <div class='col-md-6 button-title'>
            <!-- <button class=' btn-export_pdf btn btn-primary d-block ml-auto'><i class="fas fa-file-export"></i> Export PDF</button> -->
            <a href="#" class="btn btn-primary shadow-none" id="btn_export"><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a>
        </div>
      </div>
      <hr>
      <div class="pb-1">

      </div>

      <div class="card border-0 p-0 m-0">
        <div class="p-1">
          <div class = "row">
            <div class = "col-md-3">
              <div class='m-2'>
                <h6 class='p-0 mb-1'>Period From</h6>
                <input class = "custom-select " type="date" id="year-month1" name="start" value="<?=$yearmonth_from?>">
              </div>
            </div>
            <div class = "col-md-3">
              <div class='m-2'>
                <h6 class='p-0 mb-1'>Period To</h6>
                <input class = "custom-select " type="date" id="year-month2" name="end" value="<?=$yearmonth_to?>">
              </div>
            </div>
            <div class = "col-md-3">
              <div class='m-2'>
                <h6 class='p-0 mb-1'>Type</h6>
                <input class = "custom-select " type="text" value="<?= $C_SALARY_TYPE ?>" disabled>
              </div>
            </div>
          </div>
        </div>
      </div>
        <div class="card border-0 p-0 m-0">
          <div class="p-2" hidden>
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
            
          <div class="table-responsive" style = "min-height: 70vh !important">
            <table class="table table-hover m-0" id="TableToExport" style="width:100%">
              <thead>
                <tr>
                    <th>Date</th>
                    <th>Shift&nbsp;Code</th>
                    <!-- <th>Shift&nbsp;Name</th> -->
                    <th>Time&nbsp;In&nbsp;1</th>
                    <!-- <th>In&nbsp;Address&nbsp;1</th> -->
                    <th>Time&nbsp;Out&nbsp;1</th>
                    <!-- <th>Out&nbsp;Address&nbsp;1</th> -->
                    <th <?= ($DISP_INOUT_TYPE <= '1')? 'hidden': '' ?>>Time&nbsp;In&nbsp;2</th>
                    <th <?= ($DISP_INOUT_TYPE <= '1')? 'hidden': '' ?>>In&nbsp;Address&nbsp;2</th>
                    <th <?= ($DISP_INOUT_TYPE <= '1')? 'hidden': '' ?>>Time&nbsp;Out&nbsp;2</th>
                    <th <?= ($DISP_INOUT_TYPE <= '1')? 'hidden': '' ?>>Out&nbsp;Address&nbsp;2</th>
                    <th <?= ($C_SALARY_TYPE == 'Monthly')? 'hidden': '' ?>style="min-width: 50px !important">Worked Hours</th>
                    <th style="min-width: 50px !important">Tardiness</th>
                    <th style="min-width: 50px !important">Undertime</th>
                    <th style="min-width: 50px !important">Absent</th>
                    <th style="min-width: 50px !important">Paid Leave</th>
                    <!-- <th style="min-width: 50px !important">OT</th>
                    <th style="min-width: 50px !important">ND</th>
                    <th style="min-width: 50px !important">ND_OT</th>
                    <th style="min-width: 100px !important">Remarks</th> -->
                </tr>
              </thead>
              <tbody id="tbl_application_container">
                
              <?php if($DISP_ATTENDANCE) {
                    foreach($DISP_ATTENDANCE as $DISP_ATTENDANCE_ROW ){  ?>
                    <tr class='cutoff'>
                        <td><?=$DISP_ATTENDANCE_ROW['date']?></td>
                        <td><?php if($DISP_ATTENDANCE_ROW['code']!=""){
                            echo $DISP_ATTENDANCE_ROW['code'];
                          }
                          else{
                            echo '<i class="fa-duotone fa-circle-exclamation fa-xl" style="--fa-primary-color: #ff0000; --fa-secondary-color: #ff0000;"></i>&nbsp;No assigned Shift';
                          
                          }
                          
                          
                          
                          ?></td>
                              
                        
                        <!-- <td><?=$DISP_ATTENDANCE_ROW['shift_name']?></td> -->
                        <td>
                        <?=$DISP_ATTENDANCE_ROW['time_in1']?>
                        <a href="<?=base_url()?>selfservices/current_location/In/<?=urlencode($DISP_ATTENDANCE_ROW['time_in1_address'])?>"><i <?= ($DISP_ATTENDANCE_ROW['time_in1_address'] == '')? 'hidden': '' ?> class="fa-duotone fa-map-location-dot fa-xl" style="--fa-primary-color: #ffbb00; --fa-secondary-color: #ffbb00;"></i></a>
                        </td>
                        <td>
                        <?=$DISP_ATTENDANCE_ROW['time_out1']?>
                        <a href="<?=base_url()?>selfservices/current_location/Out/<?=urlencode($DISP_ATTENDANCE_ROW['time_out1_address'])?>"><i <?= ($DISP_ATTENDANCE_ROW['time_out1_address'] == '')? 'hidden': '' ?> class="fa-duotone fa-map-location-dot fa-xl" style="--fa-primary-color: #ffbb00; --fa-secondary-color: #ffbb00;"></i></a>
                        </td>

                        <td <?= ($DISP_INOUT_TYPE <= '1')? 'hidden': '' ?>>
                        <?=$DISP_ATTENDANCE_ROW['time_in2']?>
                        <a href="<?=base_url()?>selfservices/current_location/In/<?=urlencode($DISP_ATTENDANCE_ROW['time_in2_address'])?>"><i <?= ($DISP_ATTENDANCE_ROW['time_in2_address'] == '')? 'hidden': '' ?> class="fa-duotone fa-map-location-dot fa-xl" style="--fa-primary-color: #ffbb00; --fa-secondary-color: #ffbb00;"></i></a>
                        </td>
                        <td <?= ($DISP_INOUT_TYPE <= '1')? 'hidden': '' ?>></td>
                        <td <?= ($DISP_INOUT_TYPE <= '1')? 'hidden': '' ?>>
                        <?=$DISP_ATTENDANCE_ROW['time_out2']?>
                        <a href="<?=base_url()?>selfservices/current_location/Out/<?=urlencode($DISP_ATTENDANCE_ROW['time_out2_address'])?>"><i <?= ($DISP_ATTENDANCE_ROW['time_out2_address'] == '')? 'hidden': '' ?> class="fa-duotone fa-map-location-dot fa-xl" style="--fa-primary-color: #ffbb00; --fa-secondary-color: #ffbb00;"></i></a>
                        </td>
                        <td <?= ($DISP_INOUT_TYPE <= '1')? 'hidden': '' ?>></td>
                        <td <?= ($C_SALARY_TYPE == 'Monthly')? 'hidden': '' ?>></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <!-- <td></td>
                        <td></td>
                        <td></td> -->
                        <!-- <td>Test Remarks</td> -->
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
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"
integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
  <script>
 
$(document).ready(function() {

  var base_url = '<?= base_url(); ?>';
  function writeData(doc,xAxis,yAxis,className){
         $(className).each(function() {
                     doc.text(xAxis,yAxis,$(this).text());
                     yAxis+=3.5
                    });
    }
   async function getData() {
          try {
            const data = await $.ajax({
              url: '<?=base_url()?>attendances/getEmployee/'+"<?=$this->session->userdata('SESS_USER_ID')?>",
              method: 'GET',
              dataType: 'json'
            });
            return data;
          } catch (error) {
            console.error(error);
      }
    }
  $(".btn-export_pdf").on("click",function(){
          
       getData().then((res)=>{
        console.log(res);
        var   employeeInfo=res[0];
        var imgData ="<?=base64_encode(file_get_contents(base_url('assets_system/images/login_logo.png')))?>";
        var pdfImage="<?=base64_encode(file_get_contents(base_url('assets_system/forms/user_attendance_records.jpg')))?>"
        var doc = new jsPDF("p", "mm", "a4");
        var width =  doc.internal.pageSize.width;
        var height = doc.internal.pageSize.height;
        var dateData= new Date().toJSON().slice(0, 10);
        
        
        var xAjustment=8;
              doc.setFontSize(40)
              doc.addImage("data:image/jpg;base64,"+pdfImage,'JPG',0,0,width,height)
              doc.addImage("data:image/png;base64,"+imgData,'PNG',10, 10, 60, 0)
             // HEADER LEFT
             // attendance table
              doc.setFontSize(7)
                    doc.text(50, 43,dateData);
                    doc.text(50, 46,employeeInfo.lastname+' '+employeeInfo.firstname+','+employeeInfo.middlename);
                    doc.text(50, 49.5,employeeInfo.position);
                    doc.text(50, 53,employeeInfo.salary_type);
                   // HEADER RIGHT
                    doc.text(139, 43, $('#cutoff_period option:selected').text().trim());
                    doc.text(139, 46,employeeInfo.department);
                    doc.text(139, 49.5,employeeInfo.project_name);
                    doc.text(139, 53,employeeInfo.empl_group);
                 let yAxis=66.2;
                  Array.from($('.cutoff')).forEach(function(row){
                        // doc.text(19, yAxis, $(row).children()[1].innerText)
                        // doc.text(39, yAxis, $(row).children()[2].innerText)
                        // doc.text(60, yAxis, $(row).children()[3].innerText)
                        // doc.text(81, yAxis, $(row).children()[4].innerText)
                        // doc.text(89, yAxis, $(row).children()[5].innerText)
                        // doc.text(97, yAxis, $(row).children()[6].innerText)
                        // doc.text(105, yAxis, $(row).children()[7].innerText)
                        // doc.text(113, yAxis, $(row).children()[8].innerText)
                        // doc.text(121, yAxis, $(row).children()[9].innerText)
                        // doc.text(128.5, yAxis, $(row).children()[10].innerText)
                        // doc.text(136.5, yAxis, $(row).children()[11].innerText)
                        // doc.text(144.5, yAxis, $(row).children()[12].innerText)
                        // doc.text(151.5, yAxis, $(row).children()[13].innerText)
                        // doc.text(159.5, yAxis, $(row).children()[14].innerText)
                        // doc.text(167.5, yAxis, $(row).children()[15].innerText)
                        // doc.text(175.5, yAxis, $(row).children()[16].innerText)
                        // yAxis+=5.41
                        doc.text(19, yAxis, $(row).children()[0].innerText)
                        doc.text(48.5, yAxis, $(row).children()[1].innerText)
                        doc.text(75.5, yAxis, $(row).children()[2].innerText)
                        doc.text(100.5, yAxis, $(row).children()[3].innerText)
                        doc.text(125.5, yAxis, $(row).children()[5].innerText)
                        doc.text(150.5, yAxis, $(row).children()[7].innerText)
                        doc.text(175.5, yAxis, $(row).children()[9].innerText)
                        // doc.text(102.5, yAxis, $(row).children()[8].innerText)
                        // doc.text(110.5, yAxis, $(row).children()[9].innerText)
                        // doc.text(118.5, yAxis, $(row).children()[10].innerText)
                        // doc.text(126.5, yAxis, $(row).children()[11].innerText)
                        // doc.text(134.5, yAxis, $(row).children()[12].innerText)
                        // doc.text(142.5, yAxis, $(row).children()[13].innerText)
                        // doc.text(150.5, yAxis, $(row).children()[14].innerText)
                        // doc.text(158.5, yAxis, $(row).children()[15].innerText)
                        // doc.text(166.5, yAxis, $(row).children()[16].innerText)
                        // doc.text(174.5, yAxis, $(row).children()[17].innerText)
                        yAxis+=5.7
                  })
              window.open(doc.output('bloburl'), '_blank');
       })
        

      });
  $('#cutoff_period').on('change',function(){
      var row_val =$('#row_dropdown').val();
      var cutoff  =$(this).val();
      document.location.href = base_url + "selfservices/my_time_records?page=1&row=" + row_val+"&cutoff="+ cutoff ; 
  })
  
  // $('#year-month').on('change',function(){
  //   var row_val =$('#row_dropdown').val();
  //     // var row_val =$('#year-month').val();
  //     // console.log(row_val);
  //     var yearmonth  =$(this).val();
  //     document.location.href = base_url + "selfservices/my_time_records?page=1&row=" + row_val+"&yearmonth="+ yearmonth ; 
  // })


  $('#row_dropdown').on('change', function () {
      var row_val = $(this).val(); 
      var cutoff  =$('#select_cutoff').val();
      document.location.href = base_url + "selfservices/my_time_records?page=1&row=" + row_val ; 
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
        var yearmonth_from  =$("#year-month1").val();
        var yearmonth_to  =$("#year-month2").val();
        let row = $("#row_dropdown").val();

        window.location = base_url + "selfservices/my_time_records" + page_row + "&yearmonth_from=" + yearmonth_from + "&yearmonth_to=" + yearmonth_to;
      }

});



  </script>
  <!-------------------- Export ----------------->
  <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
  <script>
    document.getElementById("btn_export").addEventListener('click', function() {
      /* Create worksheet from HTML DOM TABLE */
      var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
      /* Export to file (start a download) */
      XLSX.writeFile(wb, "My Time Record.xlsx");
    });
  </script>
</body>

</html>