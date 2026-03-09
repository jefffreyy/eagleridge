<!------------------------------------------------------ A. PAGE INFORMATION  -----------------------------------------------------
TECHNOS SYSTEM ENGINEERING INC.
EyeBox HRMS
@author     Technos Developers
@datetime   15 November 2022
@purpose    My Leave
CONTROLLER FILES:
MODEL FILES:
----------------------------------------------------------- A. STYLESHEETS  ----------------------------------------------------->
<html>
<?php $this->load->view('templates/css_link'); ?>
<?php
$search_data = $this->input->get('all');
$search_data = str_replace("_", " ", $search_data);

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
<style>

  .switch {
        margin-top: 11px;
        margin-left: 7px;
        position: relative;
        display: block;
        width: 50px;
        height: 26px;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    .switch input {
        display: none;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 21px;
        width: 21px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50px;
    }
    input:checked+.slider:before {
        background-color: limegreen;
    }
    input:checked+.slider:before {
        transform: translateX(23px);
    }

    .ip_on{
      font-size: 15px;
      font-weight: bold;
      color: green;
      margin-top: 11px;
      margin-left: 5px;
      background-color: #a0f2c1;
      padding: 2px 10px;
      border-radius: 12px;
    }
    .ip_off{
      font-size: 15px;
      font-weight: bold;
      color: red;
      margin-top: 11px;
      margin-left: 5px;
      background-color: pink;
      padding: 2px 10px;
      border-radius: 12px;
    }
</style>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<div class="content-wrapper">
  <div class="container-fluid p-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= base_url() ?>administrators">Administrator</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">IP Address
        </li>
      </ol>
    </nav>
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title">IP Address<h1>
      </div>
      <div class="col-md-6 button-title">
        <a href="<?= base_url() . 'administrators/ip_address_form' ?>" class=" btn technos-button-green shadow-none rounded" id="ip_address"><i class="fas fa-plus-circle"></i> Add&nbsp;IP Address</a>
      </div>
    </div>
    <hr>
    <div class="pb-1">

    </div>
    <div class="card border-0 p-0 m-0">
      <div class="p-1">
        <!-- <div class="card-header p-0">
          <ul class="nav nav-tabs">

            <li class="nav-item">
              <a class="nav-link head-tab " id="" href="">Active<span class="ml-2 badge badge-pill badge-secondary">7</span></a>
            </li>

          </ul>
        </div> -->
        <div class="col-md-4 pl-0">
          <div class="input-group p-1 pt-2">
            <?php 
                if($search_data){ ?>
                <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fa-regular fa-broom-wide" style="margin-top: 4px"></i>&nbsp;Clear</button>
            <?php } else{?>
                <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
            <?php } ?>
            
            <input type="text" class="form-control" placeholder="Search" value="<?= ($search_data) ? $search_data : ""; ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
          </div>
        </div>
      </div>
      <div class="card border-0 p-0 m-0">
        <div class="p-2">
          <div class="row">
            <!-- <button id="" class="btn technos-button-gray shadow-none rounded bulk-button" data-toggle="modal" data-id="" data-target="#modal_set_ssa" status=""><i class="far fa-check-circle" id="btn_mrk_active"></i>&nbsp;Mark as Active</button> -->
            <!-- <a href="#" class=" btn technos-button-gray shadow-none rounded" id="APPROVAL_UPDT" approval_id="<?= $DISP_APPROVER[0]->id ?>" data-toggle="modal" data-target="#modal_assign_approver"><i class="far fa-check-circle"></i>&nbsp;Update Approvers</a> -->
            <!-- <a href="#" class=" btn technos-button-gray shadow-none rounded" id="approval"  data-toggle="modal" data-target="#modal_assign_approver"><i class="far fa-check-circle"></i>&nbsp;Mark as Active</a> -->
            
            <form action="<?php echo base_url().'administrators/update_ip_address';?>"  method="post" accept-charset="utf-8" class="p-0" >
              <label class="switch p-0">
                
                  <input class="switch_on p-0" type="checkbox" <?= $SYSTEM_IP_ADDRESS == '0' ? '' : 'checked';?> name="val_setting" onchange="this.form.submit()" >
                  <span class="slider round" id="branch"></span>
              </label>
            </form>
            <p class="ip_on" <?= $SYSTEM_IP_ADDRESS == '1' ? '' : 'hidden';?>>On</p>
            <p class="ip_off" <?= $SYSTEM_IP_ADDRESS == '0' ? '' : 'hidden';?>>Off</p>
            
            <div class='col d-flex justify-content-end align-items-center'>
              <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
              <ul class="d-inline pagination m-0 p-0 ">
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
                <!-- <th class="text-center"><input type="checkbox" name="check_all" id="check_all"></th> -->
                <th class="text-left">IP Address</th>
                <th class="text-center">Remarks</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody id="tbl_application_container">
              <?php if ($DISP_IP_ADDRESS) {
                foreach ($DISP_IP_ADDRESS as $DISP_IP_ADDRESS_ROW) {
              ?>
                  <tr>
                    <!-- <td class="text-center" id="select_item">
                      <input type="checkbox" name="approval_name" class="check_single" approval_id=""  row_id="" value="">
                    </td> -->
                    <td class="text-left"><?= $DISP_IP_ADDRESS_ROW->ip_address; ?></td>
                    <td class="text-center"><?= $DISP_IP_ADDRESS_ROW->remarks; ?></td>

                    <td style="width:15%" class="text-center">
                      <a class="select_row p-2" href="" style="color: gray; " row_id=""><i class="far fa-eye" hidden></i></a>
                      <a class="select_edit_row p-2" href="" style="color: gray; " row_id=""><i class="far fa-edit" hidden></i></a>
                      <a class="delete_data p-2 APPROVAL_DLT" href="" style="color: gray !important" delete_key="<?= $DISP_IP_ADDRESS_ROW->id ?>"><i class="far fa-trash-alt" id="trash"></i></a>
                    </td>
                  </tr>
                <?php }
              } else { ?>

                <tr class="table-active">
                  <td colspan="12">
                    <center>No Data</center>
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


<!-- ================================================================ new design End here ======================================================= -->

<aside class="control-sidebar control-sidebar-dark">
</aside>


<div class="modal fade  class_modal_approval_list" id="modal_assign_approver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Update Approvers
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('attendances/assign_approvers_ot_adj'); ?>" id="FORM_REJECT_LEAVE" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <ul id="approval_list_id" class="row" style="background: #e7f4e4;"></ul>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="UPDT_APPROVER1a">Approver 1-A
                </label>
                <select name="UPDT_APPROVER1a" id="UPDT_APPROVER1a" class="form-control" required>
                  <option value="">Choose Approver 1-A...</option>
                  <?php
                  if ($DISP_EMPLOYEES) {
                    foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) {
                  ?>
                      <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="UPDT_APPROVER1b">Approver 1-B
                </label>
                <select name="UPDT_APPROVER1b" id="UPDT_APPROVER1b" class="form-control" required>
                  <option value="">Choose Approver 1-B...</option>
                  <?php
                  if ($DISP_EMPLOYEES) {
                    foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) {
                  ?>
                      <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="UPDT_APPROVER2a">Approver 2-A
                </label>
                <select name="UPDT_APPROVER2a" id="UPDT_APPROVER2a" class="form-control" required>
                  <option value="">Choose Approver 2-A...</option>
                  <?php
                  if ($DISP_EMPLOYEES) {
                    foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) {
                  ?>
                      <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="UPDT_APPROVER2b">Approver 2-B
                </label>
                <select name="UPDT_APPROVER2b" id="UPDT_APPROVER2b" class="form-control" required>
                  <option value="">Choose Approver 2-B...</option>
                  <?php
                  if ($DISP_EMPLOYEES) {
                    foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) {
                  ?>
                      <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="UPDT_APPROVER3a">Approver 3-A
                </label>
                <select name="UPDT_APPROVER3a" id="UPDT_APPROVER3a" class="form-control" required>
                  <option value="">Choose Approver 3-A...</option>
                  <?php
                  if ($DISP_EMPLOYEES) {
                    foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) {
                  ?>
                      <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label class="required " for="UPDT_APPROVER3b">Approver 3-B
                </label>
                <select name="UPDT_APPROVER3b" id="UPDT_APPROVER3b" class="form-control" required>
                  <option value="">Choose Approver 3-B...</option>
                  <?php
                  if ($DISP_EMPLOYEES) {
                    foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) {
                  ?>
                      <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="APPROVAL_ID" id="APPROVAL_ID">
          <button type="submit" class='btn btn-primary text-light'>&nbsp; Save
          </button>
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

<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT')) {
?>
  <script>
    $(document).Toasts('create', {
      class: 'bg-success toast_width',
      title: 'Success',
      subtitle: 'close',
      body: '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT'); ?>'
    })
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_INSRT');
}
?>

<?php
if ($this->session->userdata('SESS_SUCC_MSG_DELETE')) {
?>
  <script>
    $(document).Toasts('create', {
      class: 'bg-success toast_width',
      title: 'Success',
      subtitle: 'close',
      body: '<?php echo $this->session->userdata('SESS_SUCC_MSG_DELETE'); ?>'
    })
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_DELETE');
}
?>




<script>
  $(document).ready(function() {

    $('#row_dropdown').on('change', function(e) {
      e.preventDefault()
      var row_val = $(this).val();
      let data = "?page=1&row=" + row_val;
      filter_data(data);
      // document.location.href = base_url + "employees/taxable_allowance_assign?page=1&row=" + row_val ; 
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

      window.location = base_url + "administrators/ip_address" + page_row;
    }

    $('#approval').click(function() {
      let selected_id = [];
      let selected_att_id = [];
      $('#APPROVAL_ID').empty();
      $('#approval_list_id').empty();
      $('#select_item input[type=checkbox]:checked').each(function() {
        let selected_item = $(this).val();
        let att_approval_id = $(this).attr('approval_id');
        selected_id.push(selected_item);
        selected_att_id.push(att_approval_id);
      })

      if (selected_id.length > 0) {
        $('.class_modal_approval_list').prop('id', 'modal_assign_approver');
        let approval_ids = selected_id.join(',');
        $('#APPROVAL_ID').val(approval_ids);
        selected_att_id.forEach(function(data) {
          $('#approval_list_id').append(`<li class="col-md-6">Employee ID: <strong>${data}</strong></li>`);
        })
      } else {
        $('.class_modal_approval_list').prop('id', '');
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


    $("#clear_search_btn").on("click", function() {
        var url = window.location.href.split("?")[0];
        window.location = url
    });

    $("#search_btn").on("click", function() {
        search();
    });

    $("#search_data").on("keypress", function(e) {
        if (e.which === 13) {
        search();
        }
    });

    function search() {
        var optionValue = $('#search_data').val();
        var url = window.location.href.split("?")[0];
        if (window.location.href.indexOf("?") > 0) {
        window.location = url + "?page=1&all=" + optionValue.replace(/\s/g, '_');
        } else {
        window.location = url + "?page=1&all=" + optionValue.replace(/\s/g, '_');
        }
    }



    setTimeout(() => {
      // ===================== ACTIVATE DATATABLE PLUGIN =======================
      var empl_tbl = $('#for_approval_tbl').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "autoWidth": false,
        "info": false,
        language: {
          'paginate': {
            'previous': '&lt;</span>',
            'next': '&gt;</span>'
          }
        }
      })
      $('#for_approval_tbl_filter').parent().parent().hide();
    }, 1500);
    // Get & Display Data to Edit Modal Using Async JS function
    var url = '<?php echo base_url(); ?>attendances/get_approval_route_ot_adj';
    $('#APPROVAL_UPDT').click(function() {
      get_approval_route_ot_adj(url, $(this).attr('approval_id')).then(data => {
        if (data.length > 0) {
          data.forEach((x) => {
            $('#UPDT_APPROVAL_ID').val(x.id);
            $('#UPDT_APPROVER1a').val(x.approver_1a);
            $('#UPDT_APPROVER1b').val(x.approver_1b);
            $('#UPDT_APPROVER2a').val(x.approver_2a);
            $('#UPDT_APPROVER2b').val(x.approver_2b);
            $('#UPDT_APPROVER3a').val(x.approver_3a);
            $('#UPDT_APPROVER3b').val(x.approver_3b);
          });
        }
      });
    })
    async function get_approval_route_ot_adj(url, approval_id) {
      var formData = new FormData();
      formData.append('approval_id', approval_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }
    // Delete Position
    $('.APPROVAL_DLT').click(function(e) {
      e.preventDefault();
      var user_deleteKey = $(this).attr('delete_key');
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url(); ?>administrators/delete_id_address/" + user_deleteKey;
        }
      })
    })
  })
</script>
<!-------------------- Export ----------------->
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>

</body>

</html>