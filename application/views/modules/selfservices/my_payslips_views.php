<html>
<?php $this->load->view('templates/css_link'); ?>

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

<div class="content-wrapper">
  <div class="container-fluid p-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= base_url() ?>selfservices">Self Services</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">My Payslips
        </li>
      </ol>
    </nav>
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title d-flex align-items-center"><a onclick="afterRenderFunction()" href="<?= base_url() . 'selfservices'; ?>">
            <img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />

          </a>&nbsp;My Payslips<h1>
      </div>
    </div>
    <hr>
    <div class="pb-1">
    </div>
    <div class="card border-0 p-0 m-0">
      <div class="card border-0 p-0 m-0">

        <div class="p-2 d-none d-lg-block">
          <div class='row align-items-center justify-content-center'>
            <div id="paginated" class="d-flex col-8 col-md-10 col-lg-11 justify-content-lg-end justify-content-center my-lg-0 my-2">

              <div class='d-flex align-items-center ml-auto row'>
                <div class="d-inline col-12 col-lg-6">
                  <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                </div>

                <div class="d-lg-inline d-flex col-12 col-lg-6  justify-content-center ">
                  <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">
                    <li><a class="page_row" <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
                        < </a>
                    </li>
                    <li><a class="page_row" href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                    <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                    <li><a class="page_row" href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                    <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                    <li><a class="page_row" href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                    <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                    <li><a class="page_row" href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page) echo "hidden"; ?>><?= $last_page ?> </a></li>
                    <li><a class="page_row" style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
                  </ul>
                </div>

              </div>
            </div>

            <div class="col-sm-3 col-md-2 col-lg-1  d-flex align-items-center justify-content-center mr-lg-0 mr-2">
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
          <table class="table table-bordered m-0" id="TableToExport" style="width:100%">
            <thead>

              <tr>
                <th>PAYSLIP&nbsp;ID</th>
                <th>PERIOD</th>
                <!-- <th class="text-center">EMPLOYEE&nbsp;ID</th>
                <th class="text-center">FULL&nbsp;NAME</th> -->
                <th>EMPLOYEE&nbsp;TYPE</th>
                <th>POSITION</th>
                <th class="text-center">ACTION</th>
              </tr>


            </thead>
            <tbody id="tbl_application_container">
              <?php if ($DISP_PAYSLIPS) {
                foreach ($DISP_PAYSLIPS as $DISP_PAYSLIP_ROW) { ?>
                  <tr>


                    <td> <?= 'PAY' . str_pad($DISP_PAYSLIP_ROW['id'], 5, '0', STR_PAD_LEFT); ?></td>
                    <td><?= $DISP_PAYSLIP_ROW['cutoff_period'] ?></td>
                    <!-- <td class="text-center"><?= $DISP_PAYSLIP_ROW['cmid'] ?> </td>
                    <td class="text-center"> <?= $DISP_PAYSLIP_ROW['fullname'] ?></td> -->
                    <td><?= $DISP_PAYSLIP_ROW['type'] ?> </td>
                    <td> <?= $DISP_PAYSLIP_ROW['position'] ?></td>
                    <td class="text-center">
                      <a payslip_id='<?= $DISP_PAYSLIP_ROW['id'] ?>' empl_id='<?= $DISP_PAYSLIP_ROW['empl_id'] ?>' class="btn-generate_payslip_pdf " style="background-color: transparent; border: none;color: gray; cursor: pointer; !important"> <img src="<?= base_url('assets_system/icons/download-duotone.svg') ?>" alt="">
                      </a>
                    </td>

                  </tr>
                <?php    }
              } else {
                ?>
                <tr class="table-active">
                  <td colspan="12">
                    <center>No Records</center>
                  </td>
                </tr>
              <?php  } ?>
            </tbody>
          </table>
        </div>

        <div class="p-2 d-block d-lg-none">
          <div class='row align-items-center justify-content-center'>
            <div id="paginated" class="d-flex col-8 col-md-10 col-lg-11 justify-content-lg-end justify-content-center my-lg-0 my-2">

              <div class='d-flex align-items-center ml-auto row'>
                <div class="d-inline col-12 col-lg-6">
                  <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                </div>

                <div class="d-lg-inline d-flex col-12 col-lg-6  justify-content-center ">
                  <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">
                    <li><a class="page_row" <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
                        < </a>
                    </li>
                    <li><a class="page_row" href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                    <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                    <li><a class="page_row" href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                    <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                    <li><a class="page_row" href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                    <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                    <li><a class="page_row" href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page) echo "hidden"; ?>><?= $last_page ?> </a></li>
                    <li><a class="page_row" style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
                  </ul>
                </div>

              </div>
            </div>
            <div class="col-sm-3 col-md-2 col-lg-1  d-flex align-items-center justify-content-center mr-lg-0 mr-2">
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




<div class="modal fade class_modal_approval_list" id="modal_leave_request" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">View Leave Request
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>

      <form action="" id="form_updt_approvers" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <ul id="approval_list_id" class="row" style="background: #e7f4e4;"></ul>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="empl_id">ID
                </label>
                <input type="text" class="form-control" name="empl_id" id="empl_id" readonly>
              </div>
              <div class="form-group">
                <label class="required " for="request_by">Request By
                </label>
                <input type="text" class="form-control" name="request_by" id="request_by" readonly>
              </div>
              <div class="form-group">
                <label class="required " for="leave_type">Leave Type
                </label>
                <input type="text" class="form-control" name="leave_type" id="leave_type" readonly>
              </div>
              <div class="form-group">
                <label class="required " for="leave_date">Leave Date
                </label>
                <input type="text" class="form-control" name="leave_date" id="leave_date" readonly>
              </div>
              <div class="form-group">
                <label class="required " for="leave_duration">Leave Duration
                </label>
                <input type="text" class="form-control" name="leave_duration" id="leave_duration" readonly>
              </div>
              <div class="form-group">
                <label class="required " for="status">Status
                </label>
                <input type="text" class="form-control" name="status" id="status" readonly>
              </div>
              <div class="form-group">
                <label class="required " for="remarks">Remarks
                </label>
                <input type="text" class="form-control" name="remarks" id="remarks" readonly>
              </div>
              <div class="form-group">
                <label class="required " for="attachment">Attachment
                </label>
                <input type="text" class="form-control" name="attachment" id="attachment" readonly>
                <a id="download-link" href="#">Download Attachment</a>
              </div>


            </div>
          </div>
        </div>

        <div class="modal-footer">
          <div class="spinner-border text-primary loading_indicator_appr2_appr3" style="display: none;"></div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade class_modal_approve" id="modal_bulk_approved" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Leave Bulk Approve
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>

      <form action="<?php echo base_url(); ?>selfservices/leave_bulk_approve" id="form_bulk_approve" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <ul id="approve_list_id" class="row" style="background: #e7f4e4;"></ul>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <input type="hidden" name="EMPLOYEE_ID" id="EMPLOYEE_ID">
          <input type="hidden" name="APPROVE_ID" id="APPROVE_ID">
          <a type="submit" id="submit_bulk_approve" class='btn btn-primary text-light'>&nbsp; Save</a>
          <div class="spinner-border text-primary loading_indicator_appr2_appr3" style="display: none;"></div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade class_modal_reject" id="modal_bulk_reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Leave Bulk Reject
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>

      <form action="<?php echo base_url(); ?>selfservices/leave_bulk_reject" id="form_bulk_reject" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <ul id="reject_list_id" class="row" style="background: #e7f4e4;"></ul>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <input type="hidden" name="REJECT_EMPLOYEE_ID" id="REJECT_EMPLOYEE_ID">
          <input type="hidden" name="REJECTED_ID" id="REJECTED_ID">
          <a type="submit" id="submit_bulk_reject" class='btn btn-primary text-light'>&nbsp; Save</a>
          <div class="spinner-border text-primary loading_indicator_appr2_appr3" style="display: none;"></div>
        </div>
      </form>
    </div>
  </div>
</div>



<?php $this->load->view('templates/jquery_link'); ?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script> -->
<script src="<?= base_url() ?>assets_system/js/jspdf.umd.min.js"></script>


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
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_APPROVER')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_APPROVER'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_APPROVER');
}
?>
<?php
if ($this->session->userdata('SESS_ERR_MSG_UPDT_APPROVER')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_ERR_MSG_UPDT_APPROVER'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_ERR_MSG_UPDT_APPROVER');
}
?>
<?php
if ($this->session->userdata('SESS_ERR_MSG_DLT_APPROVER')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_ERR_MSG_DLT_APPROVER'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_ERR_MSG_DLT_APPROVER');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_REJECT_LEAVE')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_REJECT_LEAVE'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_REJECT_LEAVE');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_APPROVE_LEAVE')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_APPROVE_LEAVE'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_APPROVE_LEAVE');
}
?>
<?php
if ($this->session->userdata('succ_approved')) {
?>
  <script>
    $(document).Toasts('create', {
      class: 'bg-success toast_width',
      title: 'Success',
      subtitle: 'close',
      body: '<?php echo $this->session->userdata('succ_approved'); ?>'
    })
  </script>
<?php
  $this->session->unset_userdata('succ_approved');
}
?>
<?php


function convert_cmid($array, $id)
{
  $cmid = "";
  foreach ($array as $row) {
    if ($row->id == $id) {
      $cmid = $row->col_empl_cmid;
    }
  }
  return $cmid;
}



?>
<script>
  $(document).ready(function() {
    window.jsPDF = window.jspdf.jsPDF;

    $('#row_dropdown').on('change', function(e) {
      e.preventDefault()
      var row_val = $(this).val();
      let data = "?page=1&row=" + row_val;
      filter_data(data);
    });

    $('.page_row').on('click', function(e) {
      e.preventDefault()
      let page_row = $(this).attr('href');
      filter_data(page_row);
    })

    function filter_data(page_row) {
      let base_url = '<?= base_url(); ?>';
      if (page_row == null || page_row == "") {
        page_row = '?page=' + "<?= $current_page ?>" + '&row=' + "<?= $row ?>"
      }

      window.location = base_url + "selfservices/my_payslips" + page_row;
    }

    $("#date_period").on("change", function() {
      var optionValue = $(this).val();
      var url = window.location.href.split("?")[0];
      if (window.location.href.indexOf("?") > 0) {
        window.location = url + "?date=" + optionValue;
      } else {
        window.location = url + "?date=" + optionValue;
      }
    })

    $("#btn_clear_filter").on("click", function() {
      var url = window.location.href.split("?")[0];
      window.location = url
    });


    async function getPayslipData(id, empl_id) {
      try {
        const data = await $.ajax({
          url: '<?= base_url() ?>selfservices/getPayslipData/' + id + '/' + empl_id,
          method: 'GET',
          dataType: 'json'
        });
        return data;
      } catch (error) {
        console.error(error);
      }
    }

    $('.btn-generate_payslip_pdf').on('click', function() {
      var payslip_id = $(this).attr('payslip_id');
      var empl_id = $(this).attr('empl_id');

      function formatDate(inputDate) {
        const months = [
          'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];

        const dateObject = new Date(inputDate);
        const month = months[dateObject.getMonth()];
        const day = dateObject.getDate();
        const year = dateObject.getFullYear();

        return `${month} ${day}, ${year}`;
      }


      var x_coor = 0;
      var y_coor = 0;
      var increment_by = 0;
      getPayslipData(payslip_id, empl_id)
        .then(res => {
          // console.log(res);
          let record = res.payslip[0];
          let password = res.password[0];
          let lastName = password.col_last_name;
          const dateObject = new Date(password.col_birt_date);
          const year = dateObject.getFullYear();
          let userPass = `${lastName}.${year}`;
          var pdfImage = "<?= base64_encode(file_get_contents(base_url('assets_system/forms/default_user_payslip_1.png'))) ?>";
          // let companyLogo = document.querySelector('.main-sidebar img').src;

          <?php
          if (!empty($DISP_NAV)) {
            $company_logo = base_url() . 'assets_system/images/' . $DISP_NAV;
          } else {
            $company_logo = false;
          }
          ?>
          let companyLogo = '<?= $company_logo ?>';

          var doc = new jsPDF({
            encryption: {
              userPassword: userPass,
              ownerPassword: '12345',
              userPermissions: ['print', 'modify', 'copy', 'annot-forms']
            },
            orientation: 'p',
            unit: 'mm',
            format: 'a5'
          });

          var width = doc.internal.pageSize.width;
          var height = doc.internal.pageSize.height;

          var dateData = "<?= date('M d Y') ?>"
          doc.addImage("data:image/png;base64," + pdfImage, 'PNG', 0, 0, width, height);
          // company logo start
          if (companyLogo) {
            let log0Xcoor = 6;
            let logoYcoor = 5.3;
            let logoWith = 20;
            let logoHeight = 6;
            doc.addImage(companyLogo, 'PNG', log0Xcoor, logoYcoor, logoWith, logoHeight);
          }
          // company logo end
          doc.setFontSize(4.8);


          xcoor = 54;
          ycoor = 4.2;
          increment_by = 2.5;
          // let name = record.col_last_name;
          // if (record.col_suffix) name = `${name} ${record.col_suffix}`;
          // if (record.col_frst_name) name = `${name}, ${record.col_frst_name}`;
          // if (record.col_midl_name) name = `${name} ${record.col_midl_name}`;

          doc.text(xcoor, ycoor += increment_by, (record.PAYSLIP_EMPLOYEE_CMID) ? record.PAYSLIP_EMPLOYEE_CMID : "");
          doc.text(xcoor, ycoor += increment_by, (record.PAYSLIP_EMPLOYEE_NAME) ? record.PAYSLIP_EMPLOYEE_NAME : "");
          doc.text(xcoor, ycoor += increment_by, (record.PAYSLIP_EMPLOYEE_DESIGNATION) ? record.PAYSLIP_EMPLOYEE_DESIGNATION : "");

          xcoor = 95;
          ycoor = 4;

          doc.text(xcoor, ycoor += increment_by, (record.PAYSLIP_PERIOD) ? record.PAYSLIP_PERIOD : "");
          doc.text(xcoor, ycoor += increment_by, (record.PAYSLIP_PAYOUT) ? formatDate(record.PAYSLIP_PAYOUT) : "");
          doc.text(xcoor, ycoor += increment_by, (record.BANK_ACCOUNT) ? record.BANK_ACCOUNT : "");

          xcoor = 128;
          ycoor = 4;
          doc.text(xcoor, ycoor += increment_by, (record.salary_type) ? record.salary_type : "");

          ycoor = 9;
          if (record.INITIAL_MONTHLY_RATE && record.INITIAL_MONTHLY_RATE != '0') {
            doc.text(xcoor, ycoor, parseFloat(record.INITIAL_MONTHLY_RATE).toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
          }

          ycoor = 11.5;
          if (record.INITIAL_DAILY_RATE && record.INITIAL_DAILY_RATE != '0') {
            doc.text(xcoor, ycoor, parseFloat(record.INITIAL_DAILY_RATE).toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
          }


          // xcoor = 135;
          // if(record.salary_type == "Daily"){
          //   doc.text(xcoor, ycoor, 'day');
          // }
          // else{
          //   doc.text(xcoor, ycoor, 'month');
          // }

          xcoor = 80;
          ycoor = 11.5;
          doc.text(xcoor, ycoor += increment_by, (record.ID_PAGIBIG) ? record.ID_PAGIBIG : "");
          doc.text(xcoor, ycoor += increment_by, (record.ID_PHILHEALTH) ? record.ID_PHILHEALTH : "");

          xcoor = 116;
          ycoor = 11.5;
          doc.text(xcoor, ycoor += increment_by, (record.ID_TIN) ? record.ID_TIN : "");
          doc.text(xcoor, ycoor += increment_by, (record.ID_SSS) ? record.ID_SSS : "");

          // YTD BALANCES =========================== START ===================================
          xcoor = 143;
          ycoor = 24.1
          if (record.YTD_GROSSTAX != '0.00' && record.YTD_GROSSTAX != '0' && record.YTD_GROSSTAX != null) {
            doc.text(xcoor, ycoor, parseFloat(record.YTD_GROSSTAX).toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }), {
              align: 'right'
            });
          }

          ycoor = 26.6
          if (record.YTD_EXCLUSION != '0.00' && record.YTD_EXCLUSION != '0' && record.YTD_EXCLUSION != null) {
            doc.text(xcoor, ycoor, parseFloat(record.YTD_EXCLUSION).toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }), {
              align: 'right'
            });
          }

          ycoor = 29.2
          if (record.YTD_WTAX != '0.00' && record.YTD_WTAX != '0' && record.YTD_WTAX != null) {
            doc.text(xcoor, ycoor, parseFloat(record.YTD_WTAX).toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }), {
              align: 'right'
            });
          }

          // YTD BALANCES =========================== END ===================================

          // LEAVE BALANCES =========================== START ===================================
          xcoor = 133;
          ycoor = 40;
          increment_by = 2.5;
          // Description
          if (record.VAC_USED && record.VAC_USED != '0') {
            doc.text(xcoor, ycoor += increment_by, parseFloat(record.VAC_USED).toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }), {
              align: 'right'
            });
          }

          if (record.SICK_USED && record.SICK_USED != '0') {
            doc.text(xcoor, ycoor += increment_by, parseFloat(record.SICK_USED).toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }), {
              align: 'right'
            });
          }


          xcoor = 143;
          ycoor = 40;
          increment_by = 2.5;
          if (record.VAC_BAL && record.VAC_BAL != '0') {
            doc.text(xcoor, ycoor += increment_by, parseFloat(record.VAC_BAL).toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }), {
              align: 'right'
            });
          }

          if (record.SICK_BAL && record.SICK_BAL != '0') {
            doc.text(xcoor, ycoor += increment_by, parseFloat(record.SICK_BAL).toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }), {
              align: 'right'
            });
          }

          // LEAVE BALANCES =========================== END ===================================


          // Gross Income Basic Pay   ================== Start =========================
          ycoor_1 = 22;
          xcoor_1_1 = 50;
          xcoor_1_2 = 22.5;
          xcoor_1_3 = 36.5;
          increment_by = 2.5;

          let description_1 = ['', ''];
          let count_1 = [record.COUNT_REG_HOURS, record.COUNT_PAID_LEAVE];
          let unit_1 = ['hr', 'hr'];
          let tot_1 = [record.TOT_REG_HOURS, record.TOT_PAID_LEAVE];
          size_length = description_1.length;

          for (let i = 0; i < size_length; i++) {
            if (tot_1[i] != '0.00' && tot_1[i] != '0') {
              // Description
              // doc.text(xcoor_1_1, ycoor_1, description_1[i], {
              //   align: 'left'
              // });

              if (count_1[i] != '0') {
                doc.text(xcoor_1_2, ycoor_1, parseFloat(count_1[i]).toFixed(2), {
                  align: 'right'
                });
                // doc.text(xcoor_1_2 + 1, ycoor_1, unit_1[i], {
                //   align: 'left'
                // });
              }

              doc.text(xcoor_1_3, ycoor_1, parseFloat(tot_1[i]).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              }), {
                align: 'right'
              });
              ycoor_1 += increment_by;

            } else {
              ycoor_1 += increment_by;
            }
          }
          // Gross Income Basic Pay   ================== End =========================

          // Gross Income Absences   ================== Start =========================
          ycoor_abs_1 = 32;
          xcoor_abs_1_1 = 50;
          xcoor_abs_1_2 = 22.5;
          xcoor_abs_1_3 = 36.5;
          increment_by = 2.6;

          let Description_absences = ["ABS", "TARD", "UT", "UBRK", "OBRK"];
          let count_absences = [record.COUNT_ABSENT, record.COUNT_TARDINESS, record.COUNT_UNDERTIME, record.COUNT_UNDERBREAK, record.COUNT_OVERBREAK];
          let unit__absences = ['hr', 'hr', 'hr', 'hr', 'hr'];
          let total_absences = [record.TOT_ABSENT, record.TOT_TARDINESS, record.TOT_UNDERTIME, record.TOT_UNDERBREAK, record.TOT_OVERBREAK];
          size_length = Description_absences.length;

          for (let i = 0; i < size_length; i++) {
            if (total_absences[i] && total_absences[i] != '0.00' && total_absences[i] != '0') {

              if (count_absences[i] && count_absences[i] != '0') {

                doc.text(xcoor_abs_1_2, ycoor_abs_1, count_absences[i], {
                  align: 'right'
                });
                // doc.text(xcoor_abs_1_2 + 1, ycoor_abs_1, unit__absences[i], {
                //   align: 'left'
                // });
              }

              doc.text(xcoor_abs_1_3, ycoor_abs_1, parseFloat(total_absences[i]).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              }), {
                align: 'right'
              });

              ycoor_abs_1 += increment_by;

            } else {
              ycoor_abs_1 += increment_by;
            }
          }
          // Gross Income Absences   ================== End =========================

          // Total Basic Pay  ======================Start ========================
          ycoor_total_basic = 50;
          xcoor_total_basic = 36.5;

          if (record.TOTAL_BASIC && record.TOTAL_BASIC != '0') {
            doc.text(xcoor_total_basic, ycoor_total_basic, parseFloat(record.TOTAL_BASIC).toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }), {
              align: 'right'
            });
          }

          // Total Basic Pay  ====================== End ========================

          // Gross Income OT Pay   ================== Start =========================
          ycoor_1 = 22;
          xcoor_1_1 = 38;
          xcoor_1_2 = 54;
          xcoor_1_3 = 69.6;
          increment_by = 2.6;


          let description_ot_pay = ['REST', 'LEGHOL', 'LEGREST', 'SPEHOL', 'SPEREST', 'REGOT', 'RESTOT', 'LEGOT', 'LEGRESTOT', 'SPEOT', 'SPERESTOT'];
          let count_ot_pay = [record.COUNT_REST_HOURS, record.COUNT_LEG_HOURS, record.COUNT_LEGREST_HOURS, record.COUNT_SPE_HOURS, record.COUNT_SPEREST_HOURS, record.COUNT_REG_OT, record.COUNT_REST_OT, record.COUNT_LEG_OT, record.COUNT_LEGREST_OT, record.COUNT_SPE_OT, record.COUNT_SPEREST_OT];
          let unit_ot_pay = ['hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr'];
          let tot_ot_pay = [record.TOT_REST_HOURS, record.TOT_LEG_HOURS, record.TOT_LEGREST_HOURS, record.TOT_SPE_HOURS, record.TOT_SPEREST_HOURS, record.TOT_REG_OT, record.TOT_REST_OT, record.TOT_LEG_OT, record.TOT_LEGREST_OT, record.TOT_SPE_OT, record.TOT_SPEREST_OT];
          size_length = description_ot_pay.length;

          for (let i = 0; i < size_length; i++) {
            if (tot_ot_pay[i] && tot_ot_pay[i] != '0.00' && tot_ot_pay[i] != '0') {
              // Description
              doc.text(xcoor_1_1, ycoor_1, description_ot_pay[i], {
                align: 'left'
              });

              if (count_ot_pay[i] != '0') {
                doc.text(xcoor_1_2, ycoor_1, count_ot_pay[i], {
                  align: 'right'
                });
                // doc.text(xcoor_1_2 + 1, ycoor_1, unit_ot_pay[i], {
                //   align: 'left'
                // });
              }
              doc.text(xcoor_1_3, ycoor_1, parseFloat(tot_ot_pay[i]).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              }), {
                align: 'right'
              });
              ycoor_1 += increment_by;
            }
          }

          // Gross Income OT Pay   ===================== End =========================


          // Gross Income NIGHT DIFF   ================== Start =========================
          ycoor_1 = 37;
          xcoor_1_1 = 38;
          xcoor_1_2 = 54;
          xcoor_1_3 = 69.5;
          increment_by = 2.6;

          let description_night_diff = ['REG ND', 'REG NDOT', 'REST ND', 'REST NDOT', 'LEG ND', 'LEG NDOT', 'LEGREST ND', 'LEGREST NDOT', 'SPE ND', 'SPE NDOT', 'SPEREST ND', 'SPEREST NDOT', ];
          let count_night_diff = [record.COUNT_REG_ND, record.COUNT_REG_NDOT, record.COUNT_REST_ND, record.COUNT_REST_NDOT, record.COUNT_LEG_ND, record.COUNT_LEG_NDOT, record.COUNT_LEGREST_ND, record.COUNT_LEGREST_NDOT, record.COUNT_SPE_ND, record.COUNT_SPE_NDOT, record.COUNT_SPEREST_ND, record.COUNT_SPEREST_NDOT, ];
          let unit_night_diff = ['hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr'];
          let tot_night_diff = [record.TOT_REG_ND, record.TOT_REG_NDOT, record.TOT_REST_ND, record.TOT_REST_NDOT, record.TOT_LEG_ND, record.TOT_LEG_NDOT, record.TOT_LEGREST_ND, record.TOT_LEGREST_NDOT, record.TOT_SPE_ND, record.TOT_SPE_NDOT, record.TOT_SPEREST_ND, record.TOT_SPEREST_NDOT, ];

          size_length = description_night_diff.length;

          for (let i = 0; i < size_length; i++) {
            if (tot_night_diff[i] && tot_night_diff[i] != '0.00' && tot_night_diff[i] != '0') {
              // Description
              doc.text(xcoor_1_1, ycoor_1, description_night_diff[i], {
                align: 'left'
              });

              if (count_night_diff[i] != '0') {
                doc.text(xcoor_1_2, ycoor_1, count_night_diff[i], {
                  align: 'right'
                });
                // doc.text(xcoor_1_2 + 1, ycoor_1, unit_night_diff[i], {
                //   align: 'left'
                // });
              }
              doc.text(xcoor_1_3, ycoor_1, parseFloat(tot_night_diff[i]).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              }), {
                align: 'right'
              });
              ycoor_1 += increment_by;
            }
          }

          // Gross Income NIGHT DIFF   ===================== End =========================


          // Total OT/ND PAY  ======================Start ========================
          ycoor_total_basic = 50;
          xcoor_total_basic = 69.5;

          if (record.TOTAL_OTND && record.TOTAL_OTND != '0') {
            doc.text(xcoor_total_basic, ycoor_total_basic, parseFloat(record.TOTAL_OTND).toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }), {
              align: 'right'
            });
          }

          // Total Basic Pay  ====================== End ========================

          // Other Taxable Income =============================== STart ===========================

          ycoor_2 = 57.5;
          xcoor_2_1 = 5.5;
          xcoor_2_2 = 21;
          xcoor_2_3 = 36.5;
          increment_by = 2.5;

          let description_tax = [];
          let amount_tax = [];
          let hr_tax = [];

          for (let i = 0; i < res.taxable.length; i++) {
            if (res.taxable[i].amount && res.taxable[i].amount != '0.00' && res.taxable[i].amount != '0') {
              // Description
              doc.text(xcoor_2_1, ycoor_2, res.taxable[i].description, {
                align: 'left'
              });
              // amount
              doc.text(xcoor_2_3, ycoor_2, parseFloat(res.taxable[i].amount).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              }), {
                align: 'right'
              });
              ycoor_2 += increment_by;
            }

          }
          // Other Taxable Income =============================== End ===========================


          // Other Non-Taxable Income =============================== STart ===========================

          ycoor_2 = 57.5;
          xcoor_2_1 = 38;
          xcoor_2_2 = 54;
          xcoor_2_3 = 69.6;
          increment_by = 2.5;

          let description_nontax = [];
          let amount_nontax = [];
          let hr_nontax = [];

          for (let i = 0; i < res.nontaxable.length; i++) {
            if (res.nontaxable[i].amount && res.nontaxable[i].amount != '0.00' && res.nontaxable[i].amount != '0') {
              // Description
              doc.text(xcoor_2_1, ycoor_2, res.nontaxable[i].description, {
                align: 'left'
              });
              // amount
              doc.text(xcoor_2_3, ycoor_2, parseFloat(res.nontaxable[i].amount).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              }), {
                align: 'right'
              });
              ycoor_2 += increment_by;
            }

          }
          // Other Non-Taxable Income =============================== End ===========================

          // Loans and Other Deductions   ======================== Start =======================
          ycoor_2 = 37;
          xcoor_2_1 = 70.5;
          xcoor_2_2 = 130;
          xcoor_2_3 = 107.5;
          xcoor_2_4 = 119.5;
          xcoor_2_5 = 80.5; // loan date
          xcoor_2_6 = 91; // loan amount
          increment_by = 2.5;

          let description_loan = [];
          let tot_loan = [];
          let loan_date = [];
          let loan_amount = [];

          let description_2 = [];
          let count_2 = [];
          let unit_2 = [];
          let tot_2 = [];
          let loan_id = [];

          // loan_list_raw = record.LOAN_LIST;
          // loan_list_replaced = loan_list_raw.replace(/@/g, "\"");
          // loan_list_decode = JSON.parse(loan_list_replaced);

          for (let i = 0; i < res.loans.length; i++) {

            let loanType = (res.loans[i].code != null) ? res.loans[i].code : "";
            let words = loanType.split(' ');
            let firstWord = words[0];
            let secondWord = words.length > 1 ? words[1].substring(0, 3) : '';
            let processedLoanType = secondWord ? `${firstWord} ${secondWord}` : firstWord;

            loan_id.push(res.loans[i].loan_id)
            description_2.push(processedLoanType.toUpperCase());
            loan_date.push(res.loans[i].loan_date);
            loan_amount.push(res.loans[i].payable);
            count_2.push(0);

            let contribValue = parseFloat(res.loans[i].deducted);
            tot_2.push(contribValue);

            let loanBalance = parseFloat(res.loans[i].balance);
            tot_loan.push(loanBalance);


          }

          // ca_list_raw = record.CA_LIST;
          // ca_list_replaced = ca_list_raw.replace(/@/g, "\"");
          // ca_list_decode = JSON.parse(ca_list_replaced);
          // for (let i = 0; i < ca_list_decode.length; i++) {
          //   description_2.push(ca_list_decode[i].loan_name);
          //   count_2.push(0);
          //   tot_2.push(ca_list_decode[i].contrib);
          // }
          // deduct_list_raw = record.DEDUCT_LIST;
          // deduct_list_replaced = deduct_list_raw.replace(/@/g, "\"");
          // deduct_list_decode = JSON.parse(deduct_list_replaced);
          // for (let i = 0; i < deduct_list_decode.length; i++) {
          //   description_2.push(deduct_list_decode[i].loan_name);
          //   count_2.push(0);
          //   tot_2.push(deduct_list_decode[i].contrib);
          // }

          size_length = description_2.length;
          for (let i = 0; i < size_length; i++) {

            if (tot_2[i] != '0.00' && tot_2[i] != '0') {

              doc.text(xcoor_2_1, ycoor_2, description_2[i], {
                align: 'left'
              });

              doc.text(xcoor_2_5, ycoor_2, loan_date[i], {
                align: 'left'
              });

              if (loan_amount[i] != '0' && loan_amount[i] != null) {
                doc.text(xcoor_2_6, ycoor_2, parseFloat(loan_amount[i]).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'left'
                });
              }


              // if (count_2[i] != '0') {
              //   doc.text(xcoor_2_2, ycoor_2, count_2[i], {
              //     align: 'right'
              //   });
              //   doc.text(xcoor_2_2 + 2, ycoor_2, unit_2[i], {
              //     align: 'left'
              //   });
              // }

              if (tot_2[i] && tot_2[i] != '0' && tot_2[i] != null) {
                doc.text(xcoor_2_3, ycoor_2, parseFloat(tot_2[i]).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'right'
                });
              }

              if (tot_loan[i] && tot_loan[i] != '0' && tot_loan[i] != null) {
                doc.text(xcoor_2_4, ycoor_2, parseFloat(tot_loan[i]).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'right'
                });
              }

              ycoor_2 += increment_by;
            }
          }

          // Loans and Other Deductions         ================ End ===============

          leave_list_raw = record.LEAVE_LIST;
          leave_list_replaced = leave_list_raw.replace(/@/g, "\"");
          leave_list_decode = JSON.parse(leave_list_replaced);


          // Government Contributions    ================ Start ===============
          ycoor_3 = 24.2;
          // xcoor_3_1 = 77; // Description
          xcoor_3_2 = 93; // Amount
          increment_by = 2.5;

          let description_3 = ['WTAX', 'SSS'];
          let tot_3 = [record.WTAX, record.SSS_EE_CURRENT];
          size_length = description_3.length;

          for (let i = 0; i < size_length; i++) {
            if (tot_3[i] != '0.00' && tot_3[i] != '0' && tot_3[i] != null) {

              // doc.text(xcoor_3_1, ycoor_3, description_3[i], {
              //   align: 'left'
              // });

              doc.text(xcoor_3_2, ycoor_3, parseFloat(tot_3[i]).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              }), {
                align: 'right'
              });
              ycoor_3 += increment_by;

            } else {
              doc.text(xcoor_3_2, ycoor_3, '');
              ycoor_3 += increment_by;
            }
          }


          ycoor_4 = 24.2;
          // xcoor_4_1 = 97; // Description
          xcoor_4_2 = 120; // Amount
          increment_by = 2.5;

          let description_4 = ['Philhealth', 'Pag-ibig'];
          let tot_4 = [record.PHILHEALTH_EE_CURRENT, record.PAGIBIG_EE_CURRENT];
          size_length = description_4.length;

          for (let i = 0; i < size_length; i++) {
            if (tot_4[i] != '0.00' && tot_4[i] != '0' && tot_4[i] != null) {

              doc.text(xcoor_4_2, ycoor_4, parseFloat(tot_4[i]).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              }), {
                align: 'right'
              });
              ycoor_4 += increment_by;
            } else {
              ycoor_4 += increment_by;
            }
          }
          // Government Contributions    ================ End ===============

          // // EARNINGS
          // y_coor = 65;
          // x_coor = 82;
          // doc.text(x_coor, y_coor, parseFloat(record.EARNINGS).toLocaleString('en-US', {
          //   minimumFractionDigits: 2,
          //   maximumFractionDigits: 2
          // }), {
          //   align: 'right'
          // });

          // OTHER TOTAL TAX
          y_coor = 65.5;
          x_coor = 36.5;
          if (record.OTHER_TOTAL_TAX && record.OTHER_TOTAL_TAX != '0') {
            doc.text(x_coor, y_coor, parseFloat(record.OTHER_TOTAL_TAX).toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }), {
              align: 'right'
            });
          }

          // GROSS INCOME
          y_coor = 68;
          x_coor = 36.5;
          if (record.GROSS_INCOME && record.GROSS_INCOME != '0') {
            doc.text(x_coor, y_coor, parseFloat(record.GROSS_INCOME).toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }), {
              align: 'right'
            });
          }

          // OTHER TOTAL NONTAX
          y_coor = 68;
          x_coor = 69.5;
          if (record.OTHER_TOTAL_NONTAX && record.OTHER_TOTAL_NONTAX != '0') {
            doc.text(x_coor, y_coor, parseFloat(record.OTHER_TOTAL_NONTAX).toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }), {
              align: 'right'
            });
          }

          // DEDUCTIONS 
          y_coor = 68;
          x_coor = 120;

          if (record.DEDUCTIONS && record.DEDUCTIONS != '0') {
            doc.text(x_coor, y_coor, parseFloat(record.DEDUCTIONS).toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }), {
              align: 'right'
            });
          }

          // NET INCOME 
          y_coor = 65;
          x_coor = 137;

          if (record.NET_INCOME && record.NET_INCOME != '0') {
            doc.text(x_coor, y_coor, parseFloat(record.NET_INCOME).toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }), {
              align: 'right'
            });
          }

          doc.save('my_payslip.pdf');
        })
    })


  })
</script>
</body>

</html>