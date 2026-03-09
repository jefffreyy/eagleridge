<?php $this->load->view('templates/css_link'); ?>
<?php //$this->load->view('templates/payslip_views_style'); 
?>
<link rel="stylesheet" href="<?= base_url('assets_system/css') ?>/handsontable14.css" />
<style>
  .hover {
    cursor: pointer;
  }

  .img-circle {
    border-radius: 50% !important;
    width: 100px !important;
    height: 100px !important;
    object-fit: scale-down;
  }
</style>
<style>
  /* * {
    outline: 1px solid blue;
  } */
  th.std {
    min-width: 135px;
    font-size: 12px !important;
  }

  th.emp {
    min-width: 200px;
    font-size: 12px !important;
  }

  th.chk {
    min-width: 30px;
    font-size: 12px !important;
  }

  th.bg-light-green {
    background-color: #b8f9b8;
  }

  th.bg-light-orange {
    background-color: #ffd196;
  }

  th.bg-light-blue {
    background-color: #a0cfff;
  }

  td {
    padding: 10px !important;
    font-size: 13px !important;
  }

  th.bg-light-regular {
    background-color: #FEFFED;
  }

  th.bg-light-rest {
    background-color: #FFF4F2;
  }

  th.bg-light-legal {
    background-color: #DEF0FE;
  }

  th.bg-light-special {
    background-color: #F5E9FF;
  }

  .shift_data {
    font-size: 12px !important;
  }

  @media (max-width: 780px) {
    .shift {
      margin-top: 20px;
    }
  }
</style>
<?php
// if (isset($_GET['year'])) {
//   $year = $_GET['year'];
// } else {
//   $year = $YEAR_INITIAL;
// }
if (isset($_GET['branch'])) {
  $param_branch = $_GET['branch'];
} else {
  $param_branch = "";
}
if (isset($_GET['dept'])) {
  $param_dept = $_GET['dept'];
} else {
  $param_dept = "";
}
if (isset($_GET['division'])) {
  $param_division = $_GET['division'];
} else {
  $param_division = "";
}
if (isset($_GET['section'])) {
  $param_section = $_GET['section'];
} else {
  $param_section = "";
}
if (isset($_GET['group'])) {
  $param_group = $_GET['group'];
} else {
  $param_group = "";
}
if (isset($_GET['team'])) {
  $param_team = $_GET['team'];
} else {
  $param_team = "";
}
if (isset($_GET['line'])) {
  $param_line = $_GET['line'];
} else {
  $param_line = "";
}
?>

<style>
  .nav-link {
    color: #0F0F0F;
  }
</style>

<body>
  <!-- Content Starts -->
  <div class="content-wrapper">
    <div class="container-fluid p-4">
      <div class="row  pt-1">
        <!-- Title Text -->
        <div class="col-md-6">
          <h1 class="page-title"><a href="<?= base_url() . 'attendances/'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
            </a>&nbsp;Payroll Generation</h1>
        </div>
        <!-- Title Button -->
        <!-- <div class="col-md-6 button-title">
          <a href="<?= base_url() . 'leaves/leave_parameter'; ?>" id="" class="btn btn-primary shadow-none"><i class="fa-duotone fa-gears"></i>&nbsp;Settings</a>
        </div> -->
      </div>
      <hr>
      <div class="row mb-4">
        <div class=" col-md-2 ">
          <p class="p-0 my-1 text-bold">Cut-off&nbsp;Period</p>
          <select class="form-control cut_off_period" id="cut_off_period">
            <?php foreach ($CUTOFF_PERIODS as $cut_off) { ?>
              <option value="<?= $cut_off->id ?>" <?= $PERIOD == $cut_off->id ? 'selected' : '' ?>><?= $cut_off->name ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-md-7"></div>
        <div class="col-3 hover mt-0 p-0" id="view_details_total" hidden>
          <div class="card p-0 small-box">
            <div style="padding: 5px 20px; " class="text-left">
              <text style="font-size: 1rem; font-weight: 400;">Total net income :</text>
              <text style="padding: 5px; font-size: 1rem; font-weight: 600;">₱<?= number_format($DISP_GENERATED_SUM_NET_INCOME, 2) ?></text>
            </div>
          </div>
        </div>
        <div class="col-3 hover mt-0 p-0" id="published_view_details_total" hidden>
          <div class="card p-0 small-box">
            <div style="padding: 5px 20px; " class="text-left">
              <text style="font-size: 1rem; font-weight: 400;">Total net income :</text>
              <text style="padding: 5px; font-size: 1rem; font-weight: 600;">₱<?= number_format($DISP_PUBLISHED_SUM_NET_INCOME, 2) ?></text>
            </div>
          </div>
        </div>
      </div> <!-- filter divs ends -->

      <div class="form-group row d-block d-lg-none">
        <div class="col-12">
          <label for="col-11">
            Select Type
          </label>
          <select name="" class="form-control" id="payroll_nav">
            <option value="pending" selected>Pending</option>
            <option value="ready">Ready</option>
            <option value="generated">Generated</option>
            <option value="published">Published</option>
          </select>
        </div>
      </div>
      <?php
      //   $search_data = $this->input->get('all');
      //   $search_data = str_replace("_", " ", $search_data ?? '');
      //   if (isset($_GET['row'])) {
      //     $row = $_GET['row'];
      //   } else {
      //     $row = 25;
      //   }
      //   if (isset($_GET['page'])) {
      //     $current_page = $_GET['page'];
      //   } else {
      //     $current_page = 1;
      //   }
      //   $prev_page = $current_page - 1;
      //   $next_page = $current_page + 1;
      //   // $last_page = intval($C_DATA_COUNT / $row);
      //   $last_page_initial = ceil($C_DATA_COUNT / $row);
      //   $last_page = ($last_page_initial == 0 || $last_page_initial == 1) ? 1 : $last_page_initial;
      //   if ($C_DATA_COUNT == 0) {
      //     $low_limit = 0;
      //   } else {
      //     $low_limit = $row * ($current_page - 1) + 1;
      //   }
      //   if ($current_page * $row > $C_DATA_COUNT) {
      //     $high_limit = $C_DATA_COUNT;
      //   } else {
      //     $high_limit = $row * ($current_page);
      //   }
      ?>
      <div class="card border-0 p-0 m-0">
        <div class="p-1">
          <div class="col-md-4 pl-0">
          </div>
        </div>
        <div class="card border-0 p-0 m-0">
          <div class="p-2">

            <!-- <a style="width: 150px;" href="#" class=" btn technos-button-gray shadow-none rounded" id="update" data-toggle="modal" data-target="#modela_update"><img src="<?= base_url('assets_system/icons/circle-check-solid_mark.svg') ?>" alt="">&nbsp;Generate</a> -->
            <!--<a style="width: 150px;" href="#" class=" btn technos-button-gray shadow-none rounded" id="update2" data-toggle="modal" data-target="#modela_update2"><img src="<?= base_url('assets_system/icons/circle-check-solid_mark.svg') ?>" alt="">&nbsp;Delete</a> -->
            <ul class="nav nav-tabs border-0 d-none d-lg-flex">
              <li class="nav-item" style="background-color:#e8e8e8;">
                <a class="nav-link " href="<?= base_url() . 'attendances/pending?period=' . $PERIOD ?>"><img style="width: 15px; height: 15px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/hand-solid.svg') ?>" alt="" />&nbsp;&nbsp;Pending
                  <span class="ml-2 badge badge-pill badge-secondary"> <?= $DISP_PENDING_COUNT; ?> </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="<?= base_url() . 'attendances/ready?period=' . $PERIOD ?>"><img style="width: 15px; height: 15px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-x-solid.svg') ?>" alt="" />&nbsp;&nbsp;Ready
                  <span class="ml-2 badge badge-pill badge-secondary"> <?= $DISP_EMP_LIST_COUNT; ?> </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="<?= base_url() . 'attendances/generated?period=' . $PERIOD ?>"><img style="width: 15px; height: 15px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-check-solid_payslip.svg') ?>" alt="" />&nbsp;&nbsp;Generated
                  <span class="ml-2 badge badge-pill badge-secondary"> <?= $GENERATED_LIST_COUNT; ?> </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="<?= base_url() . 'attendances/published?period=' . $PERIOD ?>"><img style="width: 15px; height: 15px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/file-pdf-solid.svg') ?>" alt="" />&nbsp;&nbsp;Published
                  <span class="ml-2 badge badge-pill badge-secondary"> <?= $PUBLISHED_LIST_COUNT; ?> </span>
                </a>
              </li>
            </ul>
          </div>
          <div id="auto_table_data"></div>
          <!-- <div id="manual_table_data"></div> -->
          <div class="tab-content">
            <div class="card border-0 mt-2 p-0 " style="margin-top: -1px !important; margin-bottom: 0px !important; border-top: none !important; ">
              <div class="row">
                <div class="col">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0" id="tbl_employees_pending">
                      <thead>
                        <th>EMPLOYEE&nbsp;ID</th>
                        <th>FULL&nbsp;NAME</th>
                        <th>EMPLOYMENT&nbsp;TYPE</th>
                        <th>POSITION</th>
                        <th style="border-top: none !important; display: none">CUT-OFF PERIOD</th>
                      </thead>
                      <tbody>
                        <?php if ($DISP_PENDING) {
                          foreach ($DISP_PENDING as $EMP_LIST) { ?>
                            <tr>
                              <td> <?= $EMP_LIST->col_empl_cmid ?></td>
                              <td> <?= $EMP_LIST->col_last_name . ', ' . $EMP_LIST->col_frst_name; ?></td>
                              <td> <?= ($EMP_LIST->col_empl_type) ? $EMP_LIST->col_empl_type : ""; ?> </td>
                              <td> <?= ($EMP_LIST->col_empl_posi) ? $EMP_LIST->col_empl_posi : ""; ?></td>
                            </tr>
                          <?php }
                        } else { ?>
                          <tr class="table-active" id="ready_for_payslip_no_data">
                            <td colspan="12">
                              <p class="text-center mb-0">No Payslips Yet</p>
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

        </div>
      </div>
    </div><!--End fluid-->
  </div>
  <!-- /.control-sidebar -->
  <!-- LOGOUT MODAL -->
  <!-- Export Employee Modal -->

  <!-- =============== APPY TEMPLATE ================= -->
  <!-- Modal -->
  <div class="modal fade" id="assign_shift" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container" style="margin:100px">
            <div style="position: relative">
              <!-- Include input field with id so
                that we can use it in JavaScript
                to set attributes.-->
              <input class="form-control" type="text" id="datetime" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <!-- =============== APPY TEMPLATE ================= -->
  <div class="modal fade  class_modal_update_list" id="modela_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h4 class="modal-title ml-1" id="exampleModalLabel">Generate Payslip
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
        </div>
        <form action="<?= base_url() . ''; ?>" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <ul id="update_list_id" class="row" style="background: #e7f4e4;"></ul>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="UPDATE_ID" id="UPDATE_ID">
            <button type="submit" class='btn btn-primary text-light' id="save_button">&nbsp; Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade  class_modal_update_list1" id="modela_update1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h4 class="modal-title ml-1" id="exampleModalLabel">Publish Payslip
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
        </div>
        <form action="<?= base_url() . 'attendances/add_payslip_published'; ?>" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <ul id="update_publish_id" class="row" style="background: #e7f4e4;"></ul>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="UPDATE_PUBLISH_ID" id="UPDATE_PUBLISH_ID">
            <input type="hidden" name="UPDATE_EMPLOYEE_LOAN_LIST" id="UPDATE_EMPLOYEE_LOAN_LIST">
            <button type="submit" class='btn btn-primary text-light' id="save_button">&nbsp; Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- <div class="modal fade  class_modal_view_payslip" id="modal_view_payslip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h4 class="modal-title ml-1" id="exampleModalLabel">View Payslip
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
        </div>
        <form action="<?= base_url() . 'attendances/view_published_payslip'; ?>" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <ul id="view_published_payslip_id" class="row" style="background: #e7f4e4;"></ul>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="VIEW_PUBLISHED_PAYSLIP_ID" id="VIEW_PUBLISHED_PAYSLIP_ID">
            <button type="submit" class='btn btn-primary text-light' id="save_button">&nbsp;Proceed
            </button>
          </div>
        </form>
      </div>
    </div>
  </div> -->
  <div class="modal fade  class_modal_update_list2" id="modela_update2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h4 class="modal-title ml-1" id="exampleModalLabel">Delete
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
        </div>
        <form action="<?= base_url() . ''; ?>" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <ul id="update_delete_id" class="row" style="background: #e7f4e4;"></ul>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="UPDATE_DELETE_ID" id="UPDATE_DELETE_ID">
            <button type="submit" class='btn btn-primary text-light' id="save_button">&nbsp; Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- jQuery -->
  <?php $this->load->view('templates/jquery_link'); ?>
  <script type="text/javascript" src="<?= base_url('assets_system/js') ?>/handsontable14.js"></script>
  <script type="text/javascript" src="<?= base_url('assets_system/js') ?>/jspdf.umd.min.js"></script>
  <?php
  if ($this->session->userdata('SESS_SUCCESS')) {
  ?>
    <script>
      $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('SESS_SUCCESS'); ?>'
      })
    </script>
  <?php
    $this->session->unset_userdata('SESS_SUCCESS');
  }
  ?>
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
  if ($this->session->userdata('SESS_ERR_MSG_INSRT_CSV')) {
  ?>
    <script>
      Swal.fire(
        '<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_CSV'); ?>',
        '',
        'error'
      )
    </script>
  <?php
    $this->session->unset_userdata('SESS_ERR_MSG_INSRT_CSV');
  }
  ?>
  <?php
  if ($this->session->userdata('success_copy_shift')) {
  ?>
    <script>
      Swal.fire(
        '<?php echo $this->session->userdata('success_copy_shift'); ?>',
        '',
        'success'
      )
    </script>
  <?php
    $this->session->unset_userdata('success_copy_shift');
  }
  ?>
  <script>
    $(document).ready(function() {
      var base_url = '<?= base_url() ?>';
      var tab = '<?= $TAB; ?>'
      if (tab) {
        if (tab == "generated") {
          // $("#update1").removeAttr("hidden");
          $("#view_details").removeAttr("hidden");
          $("#view_details_total").removeAttr("hidden");
          $("#published_view_details").attr("hidden", true);
          $("#published_view_details_total").attr("hidden", true);
          $("#generate_payslip").attr("hidden", true);
        } else if (tab == "published") {
          $("#published_view_details").removeAttr("hidden");
          $("#published_view_details_total").removeAttr("hidden");
          $("#view_details").attr("hidden", true);
          $("#view_details_total").attr("hidden", true);
          $("#generate_payslip").attr("hidden", true);
        } else if (tab == "ready") {
          $("#generate_payslip").removeAttr("hidden");
          $("#published_view_details").attr("hidden", true);
          $("#published_view_details_total").attr("hidden", true);
          $("#view_details").attr("hidden", true);
          $("#view_details_total").attr("hidden", true);
        } else {
          // $("#update1").attr("hidden", true);
          $("#view_details").attr("hidden", true);
          $("#view_details_total").attr("hidden", true);
          $("#published_view_details").attr("hidden", true);
          $("#published_view_details_total").attr("hidden", true);
          $("#generate_payslip").attr("hidden", true);
        }
      }


      $('.btn_delete').click(function(e) {
        e.preventDefault();
        var user_deleteKey = $(this).attr('delete_key');
        var user_deleteId = $(this).attr('delete_id');
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
            // window.location = base_url + "attendances/delete_generated_payslip/"+user_deleteKey;
            $.ajax({
              type: 'POST',
              url: base_url + 'attendances/delete_generated_payslip',
              data: {
                ids: [user_deleteKey],
                userId: user_deleteId,
              },
              dataType: 'json',
              success: function(response) {
                if (response.success_message) {
                  $(document).Toasts('create', {
                    class: 'bg-success toast_width',
                    title: 'Success!',
                    subtitle: 'close',
                    body: response.success_message
                  })
                  setTimeout(function() {
                    location.reload();
                  }, 1500);
                } else {
                  $(document).Toasts('create', {
                    class: 'bg-warning toast_width',
                    title: 'Error!',
                    subtitle: 'close',
                    body: 'Failed to delete!'
                  })
                }
              },
              error: function(error) {
                console.error(error);
              }
            });
          }
        })
      })

      $('#update').click(function() {
        let selected_id = [];
        let att_empl_names = [];
        $('#UPDATE_ID').empty();
        $('#update_list_id').empty();
        $('#select_item input[type=checkbox]:checked').each(function() {
          let selected_item = $(this).val();
          let att_empl_name = $(this).attr('empl_name')
          selected_id.push(selected_item);
          att_empl_names.push(att_empl_name);
        })
        if (selected_id.length > 0) {
          $('.class_modal_update_list').prop('id', 'modela_update');
          $('#UPDATE_ID').val(selected_id);
          att_empl_names.forEach(function(data) {
            $('#update_list_id').append(`<li class="col-md-6"> <strong>${data}</strong></li>`);
          })
        } else {
          $('.class_modal_update_list').prop('id', '');
          Swal.fire(
            'Please Select Employee!',
            '',
            'warning'
          )
        }
      });
      $('#update1').click(function() {
        let selected_id = [];
        let att_empl_names = [];
        let att_loan_lists = [];
        $('#UPDATE_EMPLOYEE_LOAN_LIST').empty();
        $('#UPDATE_PUBLISH_ID').empty();
        $('#update_publish_id').empty();
        $('#select_item input[type=checkbox]:checked').each(function() {
          let selected_item = $(this).val();
          let att_empl_name = $(this).attr('empl_name')
          let att_loan_list = $(this).attr('loan_id_list')

          selected_id.push(selected_item);
          att_empl_names.push(att_empl_name);
          att_loan_lists.push(att_loan_list);
        })
        if (selected_id.length > 0) {
          $('.class_modal_update_list1').prop('id', 'modela_update1');
          $('#UPDATE_PUBLISH_ID').val(selected_id);
          $('#UPDATE_EMPLOYEE_LOAN_LIST').val(att_loan_lists);
          att_empl_names.forEach(function(data) {
            $('#update_publish_id').append(`<li class="col-md-6"> <strong>${data}</strong></li>`);
          })
        } else {
          $('.class_modal_update_list1').prop('id', '');
          Swal.fire(
            'Please Select Employee!',
            '',
            'warning'
          )
        }
      });

      $(document).on('click', '#check_all', function() {
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
      async function getPayslipData(id, empl_id) {
        try {
          const data = await $.ajax({
            url: '<?= base_url() ?>attendances/getPayslipData/' + id + '/' + empl_id,
            method: 'GET',
            dataType: 'json'
          });
          return data;
        } catch (error) {
          console.error(error);
        }
      }
      window.jsPDF = window.jspdf.jsPDF;
      $('#view_payslip').click(function() {
        let selected_id = [];
        let att_empl_names = [];
        let att_published_empl_ids = [];
        // $('#VIEW_PUBLISHED_PAYSLIP_ID').empty();
        // $('#view_published_payslip_id').empty();
        $('#published_select_item input[type=checkbox]:checked').each(function() {
          let selected_item = $(this).val();
          let att_published_empl_id = $(this).attr('published_empl_id')
          let att_empl_name = $(this).attr('empl_name')
          selected_id.push(selected_item);
          att_empl_names.push(att_empl_name);
          att_published_empl_ids.push(att_published_empl_id);
        })
        const mergedObject = {
          keys: att_published_empl_ids,
          values: selected_id
        };
        if (selected_id.length > 0) {
          let keys = mergedObject.keys;
          let values = mergedObject.values;
          // Create an array to store promises
          let promises = [];
          keys.forEach((key, index) => {
            const value = values[index];
            promises.push(getPayslipData(value, key));
          });
          var x_coor = 0;
          var y_coor = 0;
          var increment_by = 0;
          Promise.all(promises)
            .then((results) => {

              var doc = new jsPDF({
                orientation: 'p',
                unit: 'mm',
                format: 'a5'
              });
              results.forEach((res) => {
                let record = res.payslip[0];
                var pdfImage = "<?= base64_encode(file_get_contents(base_url('assets_system/forms/default_user_payslip.png'))) ?>";
                let companyLogo = document.querySelector('.main-sidebar img').src;


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

                var width = doc.internal.pageSize.width;
                var height = doc.internal.pageSize.height;

                var dateData = "<?= date('M d Y') ?>"
                doc.addImage("data:image/png;base64," + pdfImage, 'PNG', 0, 0, width, height);
                // company logo start
                let log0Xcoor = 6;
                let logoYcoor = 5.3;
                let logoWith = 20;
                let logoHeight = 6;
                doc.addImage(companyLogo, 'PNG', log0Xcoor, logoYcoor, logoWith, logoHeight);
                // company logo end
                doc.setFontSize(4.8);
                xcoor = 54;
                ycoor = 4.2;
                increment_by = 2.5;
                // let name = record.col_last_name;
                // if (record.col_suffix) name = `${name} ${record.col_suffix}`;
                // if (record.col_frst_name) name = `${name}, ${record.col_frst_name}`;
                // if (record.col_midl_name) name = `${name} ${record.col_midl_name}`;

                doc.text(xcoor, ycoor += increment_by, record.PAYSLIP_EMPLOYEE_CMID);
                doc.text(xcoor, ycoor += increment_by, record.PAYSLIP_EMPLOYEE_NAME);
                doc.text(xcoor, ycoor += increment_by, record.PAYSLIP_EMPLOYEE_DESIGNATION);


                xcoor = 95;
                ycoor = 4;

                doc.text(xcoor, ycoor += increment_by, record.PAYSLIP_PERIOD);
                doc.text(xcoor, ycoor += increment_by, formatDate(record.PAYSLIP_PAYOUT));

                xcoor = 128;
                ycoor = 4;
                doc.text(xcoor, ycoor += increment_by, record.salary_type);
                doc.text(xcoor, ycoor += increment_by, parseFloat(record.INITIAL_MONTHLY_RATE).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }));
                doc.text(xcoor, ycoor += increment_by, parseFloat(record.INITIAL_DAILY_RATE).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }));


                // xcoor = 135;
                // doc.text(xcoor, ycoor, 'month');

                xcoor = 80;
                ycoor = 11.5;
                doc.text(xcoor, ycoor += increment_by, record.ID_PAGIBIG);
                doc.text(xcoor, ycoor += increment_by, record.ID_PHILHEALTH);

                xcoor = 116;
                ycoor = 11.5;
                doc.text(xcoor, ycoor += increment_by, record.ID_TIN);
                doc.text(xcoor, ycoor += increment_by, record.ID_SSS);

                // YTD BALANCES =========================== START ===================================
                xcoor = 143;
                ycoor = 21.5;
                increment_by = 2.6;
                doc.text(xcoor, ycoor += increment_by, parseFloat(record.YTD_GROSSTAX).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'right'
                });
                doc.text(xcoor, ycoor += increment_by, parseFloat(record.YTD_EXCLUSION).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'right'
                });
                doc.text(xcoor, ycoor += increment_by, parseFloat(record.YTD_WTAX).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'right'
                });
                // YTD BALANCES =========================== END ===================================

                // LEAVE BALANCES =========================== START ===================================
                xcoor = 133;
                ycoor = 40;
                increment_by = 2.5;
                // Description
                doc.text(xcoor, ycoor += increment_by, parseFloat(record.VAC_USED).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'right'
                }); +
                doc.text(xcoor, ycoor += increment_by, parseFloat(record.SICK_USED).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'right'
                });

                xcoor = 143;
                ycoor = 40;
                increment_by = 2.5;
                doc.text(xcoor, ycoor += increment_by, parseFloat(record.VAC_BAL).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'right'
                });
                doc.text(xcoor, ycoor += increment_by, parseFloat(record.SICK_BAL).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'right'
                });
                // LEAVE BALANCES =========================== END ===================================




                // Gross Income Basic Pay   ================== Start =========================
                ycoor_1 = 22;
                xcoor_1_1 = 50;
                xcoor_1_2 = 22.5;
                xcoor_1_3 = 36.5;
                increment_by = 2.5;
                // let description_1 = ['Regular Pay', 'Paid Leave', 'Regular', 'Regular OT', 'Regular ND', 'Regular NDOT', 'Rest', 'Rest OT', 'Rest ND', 'Rest NDOT', 'Legal Holiday', 'Legal OT', 'Legal ND', 'Legal NDOT', 'Legal Rest Holiday', 'Legal Rest OT', 'Legal Rest ND', 'Legal Rest NDOT', 'Special Hours', 'Special OT', 'Special ND', 'Special NDOT', 'Special Rest Holiday', 'Special Rest OT', 'Special Rest ND', 'Special Rest NDOT', ];
                let description_1 = ['', ''];
                let count_1 = [record.COUNT_REG_HOURS, record.COUNT_PAID_LEAVE, record.COUNT_REST_HOURS, record.COUNT_LEG_HOURS, record.COUNT_LEGREST_HOURS, record.COUNT_SPE_HOURS, record.COUNT_SPEREST_HOURS, ];
                let unit_1 = ['hr', 'hr', 'hr', 'hr', 'hr', 'hr', 'hr'];
                let tot_1 = [record.TOT_REG_HOURS, record.TOT_PAID_LEAVE, record.TOT_REST_HOURS, record.TOT_LEG_HOURS, record.TOT_LEGREST_HOURS, record.TOT_SPE_HOURS, record.TOT_SPEREST_HOURS, ];
                size_length = description_1.length;

                for (let i = 0; i < size_length; i++) {
                  if (tot_1[i] != '0.00' && tot_1[i] != '0') {
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
                  if (total_absences[i] != '0.00' && total_absences[i] != '0') {

                    if (count_absences[i] != '0') {
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

                  }
                }
                // Gross Income Absences   ================== End =========================

                // Total Basic Pay  ======================Start ========================
                ycoor_total_basic = 50;
                xcoor_total_basic = 36.5;

                doc.text(xcoor_total_basic, ycoor_total_basic, parseFloat(record.TOTAL_BASIC).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'right'
                });
                // Total Basic Pay  ====================== End ========================

                // Gross Income OT Pay   ================== Start =========================
                ycoor_1 = 22;
                xcoor_1_1 = 38;
                xcoor_1_2 = 54;
                xcoor_1_3 = 69.6;
                increment_by = 2.6;

                let description_ot_pay = ['REGOT', 'RESTOT', 'LEGOT', 'LEGRESTOT', 'SPEOT', 'SPERESTOT'];
                let count_ot_pay = [record.COUNT_REG_OT, record.COUNT_REST_OT, record.COUNT_LEG_OT, record.COUNT_LEGREST_OT, record.COUNT_SPE_OT, record.COUNT_SPEREST_OT];
                let unit_ot_pay = ['hr', 'hr', 'hr', 'hr', 'hr', 'hr'];
                let tot_ot_pay = [record.TOT_REG_OT, record.TOT_REST_OT, record.TOT_LEG_OT, record.TOT_LEGREST_OT, record.TOT_SPE_OT, record.TOT_SPEREST_OT];
                size_length = description_ot_pay.length;

                for (let i = 0; i < size_length; i++) {
                  if (tot_ot_pay[i] != '0.00' && tot_ot_pay[i] != '0') {
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
                  if (tot_night_diff[i] != '0.00' && tot_night_diff[i] != '0') {
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

                doc.text(xcoor_total_basic, ycoor_total_basic, parseFloat(record.TOTAL_OTND).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'right'
                });
                // Total Basic Pay  ====================== End ========================

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

                // loan_list_raw = record.LOAN_LIST;
                // loan_list_replaced = loan_list_raw.replace(/@/g, "\"");
                // loan_list_decode = JSON.parse(loan_list_replaced);

                for (let i = 0; i < res.loans.length; i++) {

                  let loanType = res.loans[i].loan_type;
                  let words = loanType.split(' ');
                  let firstWord = words[0];
                  let secondWord = words.length > 1 ? words[1].substring(0, 3) : '';
                  let processedLoanType = secondWord ? `${firstWord} ${secondWord}` : firstWord;

                  description_2.push(processedLoanType.toUpperCase());
                  loan_date.push(res.loans[i].loan_date);
                  loan_amount.push(res.loans[i].loan_amount);
                  count_2.push(0);

                  let contribValue = parseFloat(res.loans[i].contrib);
                  tot_2.push(contribValue);

                  let loanBalance = parseFloat(res.loans[i].loan_balance);
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

                    doc.text(xcoor_2_6, ycoor_2, parseFloat(loan_amount[i]).toLocaleString('en-US', {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                    }), {
                      align: 'left'
                    });

                    if (count_2[i] != '0') {
                      doc.text(xcoor_2_2, ycoor_2, count_2[i], {
                        align: 'right'
                      });
                      doc.text(xcoor_2_2 + 2, ycoor_2, unit_2[i], {
                        align: 'left'
                      });
                    }

                    doc.text(xcoor_2_3, ycoor_2, parseFloat(tot_2[i]).toLocaleString('en-US', {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                    }), {
                      align: 'right'
                    });

                    doc.text(xcoor_2_4, ycoor_2, parseFloat(tot_loan[i]).toLocaleString('en-US', {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                    }), {
                      align: 'right'
                    });

                    ycoor_2 += increment_by;
                  }
                }

                // Loans and Other Deductions         ================ End ===============

                // Government Contributions    ================ Start ===============
                ycoor_3 = 24.2;
                // xcoor_3_1 = 77; // Description
                xcoor_3_2 = 93; // Amount
                increment_by = 2.5;

                let description_3 = ['WTAX', 'SSS'];
                let tot_3 = [record.WTAX, record.SSS_EE_CURRENT];
                size_length = description_3.length;

                for (let i = 0; i < size_length; i++) {
                  if (tot_3[i] != '0.00') {

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
                  if (tot_4[i] != '0.00') {

                    doc.text(xcoor_4_2, ycoor_4, parseFloat(tot_4[i]).toLocaleString('en-US', {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                    }), {
                      align: 'right'
                    });
                    ycoor_4 += increment_by;
                  }
                }
                // Government Contributions    ================ End ===============

                // x_coor = 120;
                // doc.text(x_coor, y_coor, parseFloat(record.EARNINGS).toLocaleString('en-US', {
                //   minimumFractionDigits: 2,
                //   maximumFractionDigits: 2
                // }), {
                //   align: 'right'
                // });

                // DEDUCTIONS 
                y_coor = 68;
                x_coor = 120;
                doc.text(x_coor, y_coor, parseFloat(record.DEDUCTIONS).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'right'
                });

                // NET INCOME 
                y_coor = 65;
                x_coor = 137;
                doc.text(x_coor, y_coor, parseFloat(record.NET_INCOME).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'right'
                });

                doc.addPage();
              });
              doc.deletePage(doc.getNumberOfPages());
              window.open(doc.output('bloburl'), '_blank');
            })
        } else {
          $('.class_modal_view_payslip').prop('id', '');
          Swal.fire(
            'Please Select Employee!',
            '',
            'warning'
          )
        }
      });
      $(document).on('click', '#published_check_all', function() {
        if (this.checked == true) {
          Array.from($('.published_check_single')).forEach(function(element) {
            $(element).prop('checked', true);
            $('.published_check_single').parent().parent().css('background', '#e7f4e4');
          })
        } else {
          Array.from($('.published_check_single')).forEach(function(element) {
            $(element).prop('checked', false);
            $('.published_check_single').parent().parent().css('background', '');
          })
        }
      })
      $('.published_check_single').on('change', function() {
        if (this.checked == true) {
          $(this).parent().parent().css('background', '#e7f4e4');
        } else {
          $(this).parent().parent().css('background', '');
        }
      })
      // $('#not_generated').click(function() {
      //   $not_generated = 'not_generated';
      //   filter_data($not_generated);
      // });
      // $('#all_generated').click(function() {
      //   $all_generated = 'all_generated';
      //   filter_data($all_generated);
      // });
      // $('#select_all').click(function() {
      //   $select_all = 'select_all';
      //   filter_data($select_all);
      // });
      // function filter_data(data = "") {
      //   window.location = base_url + "attendances/payroll_status" + "?status=" + data;
      // }


      $('.btn-generate_payslip_pdf').on('click', function() {
        var payslip_id = $(this).attr('payslip_id');
        var empl_id = $(this).attr('empl_id');
        var x_coor = 0;
        var y_coor = 0;
        var increment_by = 0;

        getPayslipData(payslip_id, empl_id)
          .then(res => {
            console.log('Result = ', res);
            // console.log(res.loans);
            let record = res.payslip[0];
            let password = res.password[0];
            let lastName = password.col_last_name;
            const dateObject = new Date(password.col_birt_date);
            const year = dateObject.getFullYear();
            let userPass = `${lastName}.${year}`;

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

            var pdfImage = "<?= base64_encode(file_get_contents(base_url('assets_system/forms/default_user_payslip.png'))) ?>";
            let companyLogo = document.querySelector('.main-sidebar img').src;
            var doc = new jsPDF({
              encryption: {
                userPassword: userPass,
                ownerPassword: '12345',
                userPermissions: ['print', 'modify', 'copy', 'annot-forms']
              },
              orientation: 'P',
              unit: 'mm',
              format: 'a5'
            });
            var width = doc.internal.pageSize.width;
            var height = doc.internal.pageSize.height;

            var dateData = "<?= date('M d Y') ?>"
            doc.addImage("data:image/png;base64," + pdfImage, 'PNG', 0, 0, width, height);
            // company logo start
            let log0Xcoor = 6;
            let logoYcoor = 5.3;
            let logoWith = 20;
            let logoHeight = 6;
            doc.addImage(companyLogo, 'PNG', log0Xcoor, logoYcoor, logoWith, logoHeight);
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

              let loanType = res.loans[i].code;
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

                doc.text(xcoor_2_6, ycoor_2, parseFloat(loan_amount[i]).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'left'
                });

                if (count_2[i] != '0') {
                  doc.text(xcoor_2_2, ycoor_2, count_2[i], {
                    align: 'right'
                  });
                  doc.text(xcoor_2_2 + 2, ycoor_2, unit_2[i], {
                    align: 'left'
                  });
                }

                doc.text(xcoor_2_3, ycoor_2, parseFloat(tot_2[i]).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'right'
                });

                doc.text(xcoor_2_4, ycoor_2, parseFloat(tot_loan[i]).toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }), {
                  align: 'right'
                });

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


            doc.save('payslip.pdf');
          })
      })

      $("#cut_off_period").on("change", function() {
        filter_data(tab);
      })
      // function changeTab(tabId) {
      //     // Your existing logic to handle tab change
      //     // Get the selected cut-off period
      //     // let cut_off = $("#cut_off_period").find(":selected").val();
      //     // Update the URL with the selected cut-off period and tabId
      //     // let newUrl = base_url + "attendances/payroll_status?period=" + cut_off + "&tab=" + tabId;
      //     // history.pushState(null, null, newUrl);
      //     // // Call the filter_data function if needed
      //     filter_data(tabId);
      // }
      // $('#payslip_not_yet_generated').on('click', function(){
      //   let tab_name = $(this).attr('ready_name');
      //   filter_data(tab_name);
      // })
      // $('#payslip_generated').on('click', function(){
      //   let tab_name = $(this).attr('gen_name');
      //   filter_data(tab_name);
      // })
      // $('#payslips_published').on('click', function(){
      //   let tab_name = $(this).attr('pub_name');
      //   filter_data(tab_name);
      // })
      // $('#payslip_pending').on('click', function(){
      //   let tab_name = $(this).attr('pending_name');
      //   filter_data(tab_name);
      // })
      function filter_data(tabId) {
        if (tabId == null || tabId == "") {
          tabId = 'pending';
        }
        let cut_off = $("#cut_off_period").find(":selected").val();
        window.location = base_url + "attendances/pending?period=" + cut_off;
      }

      // $('select.cut_off_period').on('change', function() {
      //   window.location.href = "<?= base_url('attendances/payrolls?period=') ?>" + $(this).val()
      // })
    })
  </script>
  <script src="<?= base_url('assets_system/js') ?>/xlsx.full.min.js"></script>

  <script>
    $(document).ready(function() {

      $('#payroll_nav').on('change', function() {
        var selectedValue = $(this).val();

        if (selectedValue === 'pending') {
          window.location.href = '<?= base_url() . 'attendances/pending?period=' . $PERIOD ?>';
        }
        if (selectedValue === 'ready') {
          window.location.href = '<?= base_url() . 'attendances/ready?period=' . $PERIOD ?>';
        }
        if (selectedValue === 'generated') {
          window.location.href = '<?= base_url() . 'attendances/generated?period=' . $PERIOD ?>';
        }
        if (selectedValue === 'published') {
          window.location.href = '<?= base_url() . 'attendances/published?period=' . $PERIOD ?>';
        }

      });
    });
  </script>
</body>

</html>
<!-- SELECT * FROM `tbl_empl_info` WHERE id='1000004' OR id='1000022' OR id='1134' OR id='1149' OR id='1150' OR id='1270' OR id='1429' -->