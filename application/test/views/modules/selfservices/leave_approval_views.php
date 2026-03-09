
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
  // $last_page = intval($C_DATA_COUNT / $row) + 1;
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
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<div class="content-wrapper">
  <div class="container-fluid p-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= base_url() ?>selfservices">Self Services</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Leave Approval
        </li>
      </ol>
    </nav>
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title">Leave Approval<h1>
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
            <div class='justify-content-between'>
                <div class='w-50 align-items-center mt-2'>
                    <div class='d-flex align-items-center'>
                        <select class='filter custom-select w-50 mt-1'>
                            <option value='all' <?= $FILTER=='all'? 'selected' : '' ?>>All</option>
                            <?php foreach($OPTIONS_EMPLOYEES as $employee) { ?>
                            <option value='<?=$employee->empl_id?>' <?= $FILTER==$employee->empl_id ? 'selected' : '' ?>>
                                <?=$employee->col_frst_name.' '.$employee->col_midl_name.' '.
                                    $employee->col_last_name
                                ?>
                                </option>
                            <?php } ?>
                          </select>
                        <button class='filter btn technos-button-blue mt-1 ml-2'>Filter</button>
                    </div>
                </div>
                <div class='row mt-3'>
                  <div class='col-md-6'>
                    <button class="btn technos-button-gray shadow-none rounded bulk-button" id="bulk_approved" data-toggle="modal" data-target="#modal_bulk_approved"><i class=""></i>&nbsp;Bulk as Approve</button>
                    <button class="btn technos-button-gray shadow-none rounded bulk-button" id="bulk_reject" data-toggle="modal" data-target="#modal_bulk_reject"><i class=""></i>&nbsp;Bulk as Reject</button>
                  </div>

                    <div class='col d-flex justify-content-end align-items-center'>
                      <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                      <ul class="d-inline pagination m-0 p-0 ">
                        <li><a class="page_row" <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>> < </a></li>
                        <li><a class="page_row" href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                        <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                        <li><a class="page_row" href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                        <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                        <li><a class="page_row" href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                        <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                        <li><a class="page_row" href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page) echo "hidden"; ?>><?= $last_page ?> </a></li>
                        <li><a class="page_row" style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
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
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover m-0" id="TableToExport" style="width:100%">
            <thead>
              <tr>
                <th class="text-center"><input type="checkbox" name="check_all" id="check_all"></th>
                <th class="text-center">Leave ID</th>
                <th class="text-center" style='min-width:350px'>Employee</th>
                <th class="text-center">Type</th>
                <th class="text-center">Leave&nbsp;Date</th>
                <th class="text-center">Leave&nbsp;Duration&nbsp;(Hours)</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody id="tbl_application_container">
              <?php if ($DISP_SHIFT) {
                foreach ($DISP_SHIFT as $DISP_SHIFT_ROW) { ?>
                  <tr>
                    <td class="text-center" id="select_item">
                      <input type="checkbox" name="approval_name" class="check_single" approval_id="<?= convert_cmid($DISP_EMPLOYEES, $DISP_SHIFT_ROW->empl_id) ?>" employee_id="<?= $DISP_SHIFT_ROW->empl_id ?>" row_id="<?= $DISP_SHIFT_ROW->id ?>" value="<?= $DISP_SHIFT_ROW->empl_id ?>" checkbox_stat="" >
                    </td>
                    <td class="text-center">LEA00<?= $DISP_SHIFT_ROW->id ?></td>
                    <td class="text-center"><?= convert_cmid($DISP_EMPLOYEES, $DISP_SHIFT_ROW->empl_id) ?> - <?= convert_data($DISP_EMPLOYEES, $DISP_SHIFT_ROW->empl_id) ?></td>
                    <td class="text-center"> <?= convert_type($DISP_TYPES, $DISP_SHIFT_ROW->type) ?></td>
                    <td class="text-center"> <?= $DISP_SHIFT_ROW->leave_date ?> </td>
                    <td class="text-center"> <?= $DISP_SHIFT_ROW->duration ?></td>
                    <td class="text-center"> <?= $DISP_SHIFT_ROW->status ?></td>
                    <td style="width:15%" class="text-center">
                      <a class="select_row p-1 request_id btn btn-warning" href="<?= base_url() ?>selfservices/get_specific_leave_request/<?= $DISP_SHIFT_ROW->id ?>" id="view_button" data-toggle="modal" data-target="#modal_leave_request" leave_id="<?= $DISP_SHIFT_ROW->id; ?>"><i class="far fa-eye"></i></a>
                      <button class="select_edit_row p-1 approved_data btn btn-success" href="" approved_id="<?= $DISP_SHIFT_ROW->id; ?>" row_id=""><i class="fas fa-check-circle" id="btn_approved"></i></button>
                      <button  class="select_edit_row p-1 reject_data btn btn-danger " href="" reject_key="<?= $DISP_SHIFT_ROW->id; ?>" row_id=""><i class="fas fa-times-circle" id="btn_rejected"></i></button>
                      <!-- <a class="delete_data p-2 " style="color: gray !important" delete_key=""><i class="far fa-trash-alt" hidden></i></a> -->
                    </td>
                  </tr>
                <?php
                }
              } else {
                ?>
                <tr class="table-active">
                  <td colspan="12">
                    <center>No Data</center>
                  </td>
                </tr>
              <?php  } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ================================================================ new design End here ======================================================= -->
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
<!-- LOGOUT MODAL -->
<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?
        </p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;
          </span>
        </button>
      </div>
      <div class="modal-body">
        <p>Hi are you sure you want to logout?
        </p>
      </div>
      <div class="modal-footer pb-1 pt-1">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
        </button>
        <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout
        </a>
      </div>
    </div>
  </div>
</div>
<!-- jQuery -->
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
function convert_data($array, $id)
{
  $name = "";
  foreach ($array as $row) {
    if ($row->id == $id) {
      $name = $row->col_last_name . ' ' . $row->col_frst_name . ' ' . $row->col_midl_name;
    }
  }
  return $name;
}
function convert_img($array, $id)
{
  $img = "";
  foreach ($array as $row) {
    if ($row->id == $id) {
      $img = $row->col_imag_path;
    }
  }
  return $img;
}
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
function convert_type($array, $id)
{
  $type = "";
  foreach ($array as $row) {
    if ($row->id == $id) {
      $type = $row->name;
    }
  }
  return $type;
}
function check_status($array, $status, $id, $empl_id)
{
  $stat = 'disabled';
  if ($array == null) {
    return $stat = 'disabled';
  }
  foreach ($array as $row) {
    if ($row->empl_id == $id) {
      if ($status == "Pending 1") {
        if ($empl_id == $row->approver_1a || $empl_id == $row->approver_1b) {
          $stat = '';
        }
      }
      if ($status == "Pending 2") {
        if ($empl_id == $row->approver_2a || $empl_id == $row->approver_2b) {
          $stat = '';
        }
      }
      if ($status == "Pending 3") {
        if ($empl_id == $row->approver_3a || $empl_id == $row->approver_3b) {
          $stat = '';
        }
      }
    }
  }
  return $stat;
}
function checkbox_status($array, $status, $id, $empl_id)
{
  $stat = '';
  foreach ($array as $row) {
    if ($row->empl_id == $id) {
      if ($status == "Pending 1") {
        if ($empl_id == $row->approver_1a || $empl_id == $row->approver_1b) {
          $stat = 'true';
        }else{
          $stat = 'false';
        }
      }
      if ($status == "Pending 2") {
        if ($empl_id == $row->approver_2a || $empl_id == $row->approver_2b) {
          $stat = 'true';
        }else{
          $stat = 'false';
        }
      }
      if ($status == "Pending 3") {
        if ($empl_id == $row->approver_3a || $empl_id == $row->approver_3b) {
          $stat = 'true';
        }else{
          $stat = 'false';
        } 
      }
    }
  }
  return $stat;
}
?>
<script>
  $(document).ready(function() {

    

    $('#row_dropdown').on('change', function (e) {
        e.preventDefault()
        var row_val = $(this).val(); 
        let data = "?page=1&row=" + row_val;
        filter_data(data);
        // document.location.href = base_url + "employees/taxable_allowance_assign?page=1&row=" + row_val ; 
    });

    $('.page_row').on('click',function(e){
        e.preventDefault()
        let page_row = $(this).attr('href');
        filter_data(page_row);
    })

    function filter_data(page_row) {
      let base_url = '<?= base_url(); ?>';
      if(page_row == null || page_row == ""){
        page_row ='?page='+"<?=$current_page?>"+'&row='+"<?=$row?>"
      }

      window.location = base_url + "selfservices/leave_approval"+page_row;
    }


    $('button.filter').on('click',function(e){
        let select_employee=$('select.filter').val()
      window.location.href = '?employee='+ select_employee
    })
    $('#bulk_approved').click(function() {
      let selected_id = [];
      let selected_att_id = [];
      let selected_empl_id = [];
      let selected_row_id = [];
      $('#APPROVAL_ID').empty();
      $('#approve_list_id').empty();
      $('#select_item input[type=checkbox]:checked').each(function() {
        let selected_item = $(this).val();
        let att_approval_id = $(this).attr('approval_id');
        let att_empl_id = $(this).attr('employee_id');
        let att_row_id = $(this).attr('row_id');
        selected_id.push(selected_item);
        selected_att_id.push(att_approval_id);
        selected_empl_id.push(att_empl_id);
        selected_row_id.push(att_row_id);
      })
      if (selected_id.length > 0) {
        $('.class_modal_approve').prop('id', 'modal_bulk_approved');
        let approval_ids = selected_id.join(',');
        let empl_ids = selected_empl_id.join(',');
        let row_ids = selected_row_id.join(',');
        $('#APPROVE_ID').val(row_ids);
        $('#APPROVAL_ID').val(approval_ids);
        $('#EMPLOYEE_ID').val(empl_ids);
        selected_row_id.forEach(function(data) {
          $('#approve_list_id').append(`<li class="col-md-6">ID : <strong>LEA00${data}</strong></li>`);
        })
      } else {
        $('.class_modal_approve').prop('id', '');
        Swal.fire(
          'Please Select Employee!',
          '',
          'warning'
        )
      }
    })
    $('#bulk_reject').click(function() {
      let selected_id = [];
      let selected_att_id = [];
      let selected_empl_id = [];
      let selected_row_id = [];
      $('#APPROVAL_ID').empty();
      $('#reject_list_id').empty();
      $('#select_item input[type=checkbox]:checked').each(function() {
        let selected_item = $(this).val();
        let att_approval_id = $(this).attr('approval_id');
        let att_empl_id = $(this).attr('employee_id');
        let att_row_id = $(this).attr('row_id');
        selected_id.push(selected_item);
        selected_att_id.push(att_approval_id);
        selected_empl_id.push(att_empl_id);
        selected_row_id.push(att_row_id);
      })
      if (selected_id.length > 0) {
        $('.class_modal_reject').prop('id', 'modal_bulk_reject');
        let approval_ids = selected_id.join(',');
        let empl_ids = selected_empl_id.join(',');
        let row_ids = selected_row_id.join(',');
        $('#REJECTED_ID').val(row_ids);
        $('#REJECT_EMPLOYEE_ID').val(empl_ids);
        selected_row_id.forEach(function(data) {
          $('#reject_list_id').append(`<li class="col-md-6">ID : <strong>LEA00${data}</strong></li>`);
        })
      } else {
        $('.class_modal_reject').prop('id', '');
        Swal.fire(
          'Please Select Employee!',
          '',
          'warning'
        )
      }
    })
    $('#check_all').click(function() {
        if (this.checked == true) {
          Array.from($('.check_single')).forEach(function(element) {
            $(element).prop('checked', true);
            $('.check_single').parent().parent().css('background', '#e7f4e4');
          })
        } else {
          Array.from($('.check_single')).forEach(function(element) {
            $(element).prop('checked', false);
            $('.check_single').parent().parent().css('background', '');
          })
        }
      })
    $('.check_single').on('change', function() {
      if (this.checked == true) {
        $(this).parent().parent().css('background', '#e7f4e4');
      } else {
        $(this).parent().parent().css('background', '');
      }
    })
    $('#submit_bulk_approve').click(function() {
      $('#form_bulk_approve').submit();
    })
    $('#submit_bulk_reject').click(function() {
      $('#form_bulk_reject').submit();
    })
    $("#search_btn").on("click", function() {
      $('#search_data').val();
      var optionValue = $('#search_data').val();
      var url = window.location.href.split("?")[0];
      if (window.location.href.indexOf("?") > 0) {
        window.location = url + "?page=1&all=" + optionValue.replace(/\s/g, '_');
      } else {
        window.location = url + "?page=1&all=" + optionValue.replace(/\s/g, '_');
      }
    })
    $('.reject_data').click(function(e) {
      e.preventDefault();
      var reject_key = $(this).attr('reject_key');
      Swal.fire({
        title: 'Confirmation',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Reject'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url(); ?>selfservices/reject_leave_assign?reject_id=" + reject_key;
        }
      })
    })
    $('.approved_data').click(function(e) {
      e.preventDefault();
      var approved_id = $(this).attr('approved_id');
      Swal.fire({
        title: 'Confirmation',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Approve'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url(); ?>selfservices/update_leave_assign?approved_id=" + approved_id;
        }
      })
    })
    $('.request_id').on('click', function() {
      let url = $(this).attr('href');
      fetch(url)
        .then((res) => res.json())
        .then((data) => {
          console.log(data);
          
          $('#leave_type').val(data['type']);
          $('#empl_id').val('LEA00' + data[0]['id']);
          $('#request_by').val(data['name']);
          $('#leave_date').val(data['leave_date']);
          $('#leave_duration').val(data[0]['duration']);
          $('#status').val(data[0]['status']);
          $('#remarks').val(data[0]['remarks']);
          $('#attachment').val(data[0]['attachment']);
        })
    })

    
    var baseUrl = '<?= base_url() . 'assets_user/files/selfservices/' ?>';
    $('#download-link').click(function(e) {

      e.preventDefault(); // Prevents the default click behavior
      var fileName = $(this).siblings('input').val();
 
      var link = document.createElement('a');
      link.href = baseUrl + fileName;
      link.download = fileName;
      link.click();
    });





  })
</script>
<!-------------------- Export ----------------->
</body>
</html>