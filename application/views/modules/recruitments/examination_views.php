
<html>
<?php $this->load->view('templates/css_link'); ?>

<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<?php 

$title =  "Examination";
$header_button =  "Apply Examination";
$modal_title =  "Apply Examination";
$request_name =  "Apply Examination";

$id_code =  "EXL";

$col_name_1 =  "Examination". '&nbsp;' ."ID";
$col_name_2 =  "Application" . '&nbsp;' ."Date";
$col_name_3 =  "Employee";
$col_name_4 =  "Type";
$col_name_5 =  "Reason";
$col_name_6 =  "Status";
$col_name_7 =  "";
$col_name_8 =  "";
$col_name_9 =  "";
$col_name_10 =  "";

$mod_name_1 =  "Name";
$mod_name_2 =  "Position";
$mod_name_3 =  "Department";
$mod_name_4 =  "Application". '&nbsp;' ."Date";
$mod_name_5 =  "Leave". '&nbsp;' ."Date";
$mod_name_6 =  "Leave". '&nbsp;' ."Type";
$mod_name_7 =  "Reason";
$mod_name_8 =  "Duration";
$mod_name_9 =  "Status";
$mod_name_10 =  "";

?>





<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<body>
  <!-- Content Starts -->
  <div class="content-wrapper">
    <div class="container-fluid p-4">

    <nav aria-label="breadcrumb">

      <ol class="breadcrumb">

          <li class="breadcrumb-item">

            <a href="<?= base_url() ?>nav_recruitments">Recruitment</a>

          </li>

          <li class="breadcrumb-item active" aria-current="page">Examination
          </li>

      </ol>

    </nav>

      <div class="row">

        <!-- Title Text -->
        <div class="col-md-6">
          <h1 class="page-title"><?= $title ?></h1>
        </div>

        <!-- Title Button -->
        <div class="col-md-6 button-title">
          <a href="#" class="btn btn-primary shadow-none" id="btn_apply" employee_id="<?= $this->session->userdata('SESS_USER_ID') ?>"><i class="fas fa-plus mr-2"></i><?= $header_button ?></a>
        </div>

      </div>

      <!-- Title Header Line -->
      <hr>

      <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">
        <div class="row">
          <div class="col">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <!-- Table Headers -->
                  <?php if ($col_name_1) { ?><th><?= $col_name_1 ?></th><?php } ?>
                  <?php if ($col_name_2) { ?><th><?= $col_name_2 ?></th><?php } ?>
                  <?php if ($col_name_3) { ?><th><?= $col_name_3 ?></th><?php } ?>
                  <?php if ($col_name_4) { ?><th><?= $col_name_4 ?></th><?php } ?>
                  <?php if ($col_name_5) { ?><th><?= $col_name_5 ?></th><?php } ?>
                  <?php if ($col_name_6) { ?><th><?= $col_name_6 ?></th><?php } ?>
                  <?php if ($col_name_7) { ?><th><?= $col_name_7 ?></th><?php } ?>
                  <?php if ($col_name_8) { ?><th><?= $col_name_8 ?></th><?php } ?>
                  <?php if ($col_name_9) { ?><th><?= $col_name_9 ?></th><?php } ?>
                  <?php if ($col_name_10) { ?><th><?= $col_name_10 ?></th><?php } ?>
                </thead>

                <!-- Table Information -->
                <tbody id="tbl_application_container">

                  <?php
                  if ($DISP_TABLE) {
                    foreach ($DISP_TABLE as $DISP_TABLE_ROW) {
                      $application_id = $id_code . str_pad($DISP_TABLE_ROW->id, 5, '0', STR_PAD_LEFT);
                      $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_TABLE_ROW->empl_id);
                      // $db_date_from = $DISP_TABLE_ROW->from_date;
                      // $date_from = date('D, M j, Y', strtotime($db_date_from));

                      
                      $application_date = $DISP_TABLE_ROW->date_created;
                      $application_date = date('D, M j, Y', strtotime($application_date));

                     
                  ?>

                      <tr class="form_row" style="cursor: pointer;" data-toggle="modal" data-target="#modal_details" employee_id="<?= $DISP_TABLE_ROW->empl_id ?>" request_id="<?= $DISP_TABLE_ROW->id ?>">
                      <!-- <tr> -->
                        <td><?= $application_id ?></td>
                        <td><?= $application_date ?></td>
                        <td>
                          <a href="#">
                            <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($employee_id[0]->col_imag_path) {
                              echo base_url() . 'user_images/' . $employee_id[0]->col_imag_path;
                            } else {
                              echo base_url() . 'user_images/default_profile_img3.png';
                            } ?>">&nbsp;&nbsp;<?= $employee_id[0]->col_frst_name . ' ' . $employee_id[0]->col_last_name ?>
                          </a>
                        </td>
                        <td><?= $DISP_TABLE_ROW->col_type ?></td>
                        <td style="word-break: break-word;"><?= $DISP_TABLE_ROW->comments ?></td>
                        <td><?= $DISP_TABLE_ROW->status1 ?></td>

                     
                      </tr>
                    <?php
                    }
                  } else {
                    ?>

                    <!-- Message if no entries -->
                    <tr class="table-active">
                      <td colspan="9">
                        <center>You haven't submitted any <?= $request_name ?> yet</center>
                      </td>
                    </tr>

                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div> <!-- card border ends -->

      <!-- Pagination -->
      <right>
        <ul id="btn_pagination" class="pagination mr-auto ml-auto"> </ul>
      </right>

    </div>
  </div> <!-- Content ends -->

  <!------------------------------------------------------------- C. Data Pull  --------------------------------------------------------->
  <?php
  $url_count      = $this->uri->total_segments();
  $url_directory  = $this->uri->segment($url_count);
  $user           = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($this->session->userdata('SESS_USER_ID'));
  $user_cmid      = $user[0]->col_empl_cmid;
  $user_firstname = $user[0]->col_frst_name;
  $user_lastname  = $user[0]->col_last_name;


  ?>



  <?php
  $row_count = $DISP_ROW_COUNT[0]->ml_count;
  $page_count = ceil($DISP_ROW_COUNT[0]->ml_count / 10);
  ?>


  <input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT[0]->ml_count ?>">
  <input type="hidden" id="page_count" value="<?= $page_count ?>">
  <input type="hidden" id="id_code" value="<?= $id_code ?>">

  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->


  <!------------------------------------------------------------- Modals  --------------------------------------------------------->
  
  <!-- Apply -->
  <div class="modal fade" id="modal_apply" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">

        <!--Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title mt-0 ml-1"><?= $request_name ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
        </div>

        <!--Modal Body -->
        <div class="modal-body pb-5">
          
          <div class="row">
            <div class="col-12">
              <!-- Form starts -->
              <form action="<?php echo base_url('examinations/insert_data'); ?>" id="apply_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">

             
                <!-- Employee -->
                <div id="request_data">
                  <div class="form-group">
                    <label class="required" for="EMPLOYEE">Employee
                    </label>
                    <select class="form-control" name="EMPLOYEE" id="EMPLOYEE" disabled>
                      <option value=""><?= $user_cmid . ' - ' . $user_firstname . ' ' . $user_lastname ?></option>
                    </select>
                  </div>

                  <!-- Type -->
                  <div class="form-group">
                    <label class="required" for="INSRT_TYPE">Leave Type
                    </label>
                    <select class="form-control" name="INSRT_TYPE" id="INSRT_TYPE" required>
                      <option value="">Choose...</option>
                      <?php
                      foreach ($DISP_TYPES_INFO as $DISP_TYPES_INFO_ROW) {
                      ?>
                        <option value="<?= $DISP_TYPES_INFO_ROW->name ?>"><?= $DISP_TYPES_INFO_ROW->name ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>

                  <!--  Date -->
                  <div class="form-group">
                    <label class="required" for="INSRT_DATE">Date
                    </label>
                    <input class="form-control" type="date" name="INSRT_DATE" id="INSRT_DATE" required>
                  </div>

                  <!--  Duration -->
                  <div class="form-group">
                    <label class="required" for="INSRT_DURATION">Duration
                    </label>
                    <input type="number" name="INSRT_DURATION" id="INSRT_DURATION" class="form-control" step="0.25" placeholder="Enter Duration (Days)" required>
                    <!-- <select class="form-control" name="INSRT_DURATION" id="INSRT_DURATION">
                    <option value="">Choose...</option>
                    <option value="0.5">Half Day</option>
                    <option value="1">Full Day</option>
                  </select> -->
                  </div>

                </div><!-- Employee Single  ends-->

                                <!-- Insert Reason -->
                <div class="form-group">
                  <label for="INSRT_TO_DATE">Reason
                  </label>
                  <textarea class="form-control" name="INSRT_COMMENT" id="INSRT_COMMENT" cols="30" rows="5"></textarea>
                </div>

                <!-- Insert File (DISPLAY NONE)-->
                <div class="form-group" id="application_file">
                  <label for="INSRT_FILE">File Attachment &nbsp;&nbsp; <span class="text-muted"></span>
                  </label>
                  <div class="row">
                    <div class="col-6">
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input fileficker" id="INSRT_FILE" name="INSRT_FILE" multiple="" accept=".jpg, .jpeg, .png">
                          <label class="custom-file-label" for="INSRT_FILE">Choose file
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Imployee Id -->
                <div class="row">
                  <div class="col-12 w-100">
                    <input type="hidden" name="EMPL_ID" value="<?= $this->session->userdata('SESS_USER_ID') ?>">
                    <button class="btn btn-primary float-right" id="INSRT_BTN" type="submit">Apply</button>
                  </div>
                </div>

              </form> <!-- Form ends -->
            </div> <!-- col-12 ends  -->
          </div> <!-- row ends  -->
        </div> <!-- Modal ends -->
      </div> <!-- modal-content ends -->
    </div> <!-- modal-dialog ends -->
  </div> <!-- modal fade ends -->

  <!-- View Details -->
  <div class="modal fade" id="modal_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title mt-0 ml-1">Leave Request Details
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;
                    </span>
                </button>
            </div>
            <div class="modal-body pb-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="" for="employee_name"><?= $mod_name_1 ?>:
                            </label>
                            <input type="text" class="form-control" name="employee_name" id="employee_name" disabled>
                        </div>
                        <div class="form-group">
                            <label class="" for="employee_position"><?= $mod_name_2 ?>:
                            </label>
                            <input type="text" class="form-control" name="employee_position" id="employee_position" disabled>
                        </div>
                        <div class="form-group">
                            <label class="" for="employee_department"><?= $mod_name_3 ?>:
                            </label>
                            <input type="text" class="form-control" name="employee_department" id="employee_department" disabled>
                        </div>
                        <div class="form-group">
                            <label class="" for="date_requested"><?= $mod_name_4 ?>:
                            </label>
                            <input type="text" class="form-control" name="date_requested" id="date_requested" disabled>
                        </div>
                        <div class="form-group">
                            <label class="" for="on_date"><?= $mod_name_5 ?>:
                            </label>
                            <input type="text" class="form-control" name="on_date" id="on_date" disabled>
                        </div>
                        <div class="form-group">
                            <label class="" for="type"><?= $mod_name_6 ?>:
                            </label>
                            <input type="text" class="form-control" name="type" id="type" disabled>
                        </div>
                        <div class="form-group">
                            <label class="" for="reason"><?= $mod_name_7 ?>:
                            </label>
                            <input type="text" class="form-control" name="reason" id="reason" disabled>
                        </div>
                        <div class="form-group">
                            <label class="" for="duration"><?= $mod_name_8 ?>:
                            </label>
                            <input type="text" class="form-control" name="duration" id="duration" disabled>
                        </div>
                        <div class="form-group">
                            <label class="" for="status"><?= $mod_name_9 ?>:
                            </label>
                            <input type="text" class="form-control" name="status" id="status" disabled>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-md-6">
                            <p class="text-bold mb-1">Photo Attachments:</p>
                            <a id="attachment_link" target="_blank">
                              <img id="file_attachment" alt="" style="width: 100px;cursor:pointer" class="w3-hover-opacity">
                            </a>
                            <p style="display:none" class="text-muted" id="empty_attachment">No photo attached</p>
                          </div>
                          <div class="col-md-6" id="reason_rejection">
                            <p class="text-bold mb-1 text-danger">Reason for Rejection:</p>
                            <p id="rejection_comment"></p>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <!-- View Details Ends-->
  <!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->
  <?php $this->load->view('templates/jquery_link'); ?>



  <!-- SESSION MESSAGES -->

  <?php
  if ($this->session->userdata('SESS_SUCC_MSG_CANCEL')) {
  ?>
    <script>
      Swal.fire(
        '<?php echo $this->session->userdata('SESS_SUCC_MSG_CANCEL'); ?>',
        '',
        'success'
      )
    </script>
  <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_CANCEL');
  }
  ?>

  <?php
  if ($this->session->userdata('SESS_SUCC_MSG_INSRT_APPLY')) {
  ?>
    <script>
      Swal.fire(
        "<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_APPLY'); ?>",
        '',
        'success'
      )
    </script>
  <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_APPLY');
  }
  ?>
  <?php
  if ($this->session->userdata('SESS_SUCC_MSG_UPDT_APPLY')) {
  ?>
    <script>
      Swal.fire(
        '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_APPLY'); ?>',
        '',
        'success'
      )
    </script>
  <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_UPDT_APPLY');
  }
  ?>
  <?php
  if ($this->session->userdata('SESS_SUCC_MSG_DLT_APPLY')) {
  ?>
    <script>
      Swal.fire(
        '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_APPLY'); ?>',
        '',
        'success'
      )
    </script>
  <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_DLT_APPLY');
  }
  ?>
  <?php
  if ($this->session->userdata('SESS_ERR_MSG_INSRT_APPLY')) {
  ?>
    <script>
      Swal.fire(
        "<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_APPLY'); ?>",
        '',
        'warning'
      )
    </script>
  <?php
    $this->session->unset_userdata('SESS_ERR_MSG_INSRT_APPLY');
  }
  ?>

  <script>
    $(document).ready(function() {
      // controller urls
      var url_base = '<?= base_url() ?>';
      var url_get_specific_data = '<?= base_url() ?>examinations/get_specific_data';
      var url_get_table_list = '<?= base_url() ?>examinations/get_my_specific_data';
      var url_get_empl_data = '<?= base_url() ?>examinations/get_empl_data';

      $('#btn_apply').click(function(e) {
        e.preventDefault();

        var employee_id = $(this).attr('employee_id');
        get_empl_data(url_get_empl_data, employee_id).then(function(data) {
          Array.from(data).forEach(function(x) {
            if (x.isRegular >= 0) {  //originally  (x.isRegular > 0)
              $('#modal_apply').modal('toggle');
            } else {
              Swal.fire(
                'Application Restricted',
                'Only regular employees may apply for leave.',
                'warning'
              )
            }
          })
        })
      })


      // Get & Display Data to Edit Modal Using Async JS function

      const openModalButton = document.querySelectorAll('[data-target]');
      openModalButton.forEach(button => {
        button.addEventListener('click', () => {
          const modal = document.querySelector(button.dataset.target);
          get_specific_data(url_get_specific_data, button.getAttribute('request_id'), button.getAttribute('employee_id')).then(data => {
            
           
            data.specific_data.forEach((specificData) => {
             
              $('#date_requested').val(new Date(specificData.date_created).toLocaleDateString('en-us', {
                weekday: "long",
                year: "numeric",
                month: "short",
                day: "numeric"
              }));
             
              if (!specificData.col_leave_to) {
                $('#on_date').val(new Date(specificData.from_date).toLocaleDateString('en-us', {
                  weekday: "long",
                  year: "numeric",
                  month: "short",
                  day: "numeric"
                }));
              } else {
                var request_end = specificData.col_leave_to.split(' ');
                $('#on_date').val(specificData.from_date + ' to ' + request_end[0]);
              }

              $('#type').val(specificData.col_type);
              $('#reason').val(specificData.comments);
              $('#duration').val((parseFloat(specificData.duration)).toFixed(2) + " Day/s");
              $('#status').val(specificData.status1);
              if (specificData.col_image) {
                $('#empty_attachment').hide();
                $('#file_attachment').attr('src', url_base + 'assets/files/all_request/' + specificData.col_image);
              } else {
                $('#empty_attachment').show();
                $('#file_attachment').attr('src', '');
              }
              $('#attachment_link').attr('href', url_base + 'assets/files/all_request/' + specificData.col_image);

              if (specificData.col_reason_rejection) {
                $('#reason_rejection').show();
                $('#rejection_comment').text(specificData.col_reason_rejection);
              } else {
                $('#rejection_comment').text('');
                $('#reason_rejection').hide();
              }

            });
         
            data.employee_data.forEach((employeeData) => {
              
              $('#employee_name').val(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
              $('#employee_position').val(employeeData.col_empl_posi);
              $('#employee_department').val(employeeData.col_empl_dept);
              $('#modal_employee_img').attr('src', url_base + 'user_images/' + employeeData.col_imag_path);
              
            })
          });
        });
      });






      // ------------------------------ Pagination -------------------------------------
      // TECHNOS STANDARD: DO NOT CHANGE
      var row_count = $('#row_count').val();
      var page_count = $('#page_count').val();

      $('#btn_pagination').pagination();
      $('#btn_pagination').pagination({
        total: row_count, // the number of entries
        current: 1, // current page
        length: 10, // the number of entires per page
        size: 2, // pagination size
        prev: "&lt;", // Prev/Next text
        next: "&gt;",

        // fired on each click
        click: function(e) {
          $('#tbl_application_container').html('');

          var row_count = $('#row_count').val();
          var page_count = $('#page_count').val();
          var id_code = $('#id_code').val();
          var page_num = e.current;

          get_table_data(url_get_table_list, page_num).then(function(data) {
            Array.from(data).forEach(function(e) {

              var employee_id = e.empl_id;
              var date_from = e.from_date;
              var application_id = e.id;
              var application_date = e.date_created;
              var type = e.col_type;
              var comment = e.comments;
              var duration = e.duration;
              var status1 = e.status1;
              var status2 = e.status2;
              var status3 = e.status3;


              // Date Change Format
              var application_date = new Date(application_date).toLocaleDateString('en-us', {
                weekday: "short",
                year: "numeric",
                month: "short",
                day: "numeric"
              });
              var date_from = new Date(date_from).toLocaleDateString('en-us', {
                weekday: "short",
                year: "numeric",
                month: "short",
                day: "numeric"
              });

              // Status Condition
              if ((status1 == 'Rejected') || (status2 == 'Rejected') || (status3 == 'Rejected')) {
                var status = 'Rejected';
              } else if ((status1 == 'Approved') && (status2 == 'Approved') && (status3 == 'Approved')) {
                var status = 'Approved';
              } else {
                var status = 'Pending';
              }

              if ((status1 == 'Rejected') || (status2 == 'Rejected') || (status3 == 'Rejected')) {
                var Acknowledged = 'Acknowledged';
              } else if ((status1 == 'Approved') && (status2 == 'Approved') && (status3 == 'Approved')) {
                var Acknowledged = 'Acknowledged';
              } else {
                var Acknowledged = '';
              }

              $('#tbl_application_container').append(`
              <tr class="form_row" style="cursor: pointer;" data-toggle="modal" data-target="#modal_details" employee_id="` + employee_id + `" request_id="` + application_id + `">
              <td>`+id_code + application_id.padStart(5, '0') + `</td>
              <td>` + application_date + `</td>
              <td>` + date_from + `</td>
              <td>
              <a href = "#">
                <img class="rounded-circle avatar " width="35" height="35" 
                src="<?php if ($employee_id[0]->col_imag_path) {
                        echo base_url() . 'user_images/' . $employee_id[0]->col_imag_path;
                      } else {
                        echo base_url() . 'user_images/default_profile_img3.png';
                      } ?>">&nbsp;&nbsp;<?= $employee_id[0]->col_frst_name . ' ' . $employee_id[0]->col_last_name ?>
                </a>
              </td>
              <td>` + type + `</td>
              <td style="word-break: break-word;">` + comment + `</td>
              <td>` + Number(duration).toFixed(2) + `</td>
              <td>` + status + `</td>
              <td>` + Acknowledged + `</td>
              </tr>
          `)
            })
          })

        }
      });
      //-------------------------- ASYNC FUNCTIONS ------------------------------------------


      //Get My Specific List for the Table display       //<!--get_table_data CONTROLLER IS MISSING -->
      async function get_table_data(url, page_num) {
        var formData = new FormData();
        formData.append('page_num', page_num);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }

      //Get Specific Data for Modal Display
      async function get_specific_data(url, request_id, employee_id) {
        var formData = new FormData();
        formData.append('employee_id', employee_id);
        formData.append('request_id', request_id);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }

      //Get Employee Details to use for Modal Verification
      async function get_empl_data(url, empl_id) {
        var formData = new FormData();
        formData.append('empl_id', empl_id);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }
    })
  </script>
</body>

</html>