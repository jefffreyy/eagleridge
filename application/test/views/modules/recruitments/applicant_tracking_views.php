<html>
<?php $this->load->view('templates/css_link'); ?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<?php
$title =  " Applicant Tracking System ";
$header_button =  "Add Applicant";
$modal_title =  "Add Applicant";
$request_name =  "Add Applicant";
$id_code =  "APC";
$job_id_code = "JOB";
$col_name_1 =  "Applicant" . '&nbsp;' . "ID";
$col_name_2 =  "First name";
$col_name_3 =  "Last name";
$col_name_4 =  "Province";
$col_name_5 =  "City";
$col_name_6 =   "Baranggay";
$col_name_7 =  "Street";
$col_name_8 =  "Zip code";
$col_name_9 =  "Attachment";
$col_name_10 =  "Date created";
$col_name_11 =  "Applied for";
$mod_name_1 =  "Name:";
$mod_name_2 =  "Position";
$mod_name_3 =  "Department";
$mod_name_4 =  "Application" . '&nbsp;' . "Date";
$mod_name_5 =  "Leave" . '&nbsp;' . "Date";
$mod_name_6 =  "Leave" . '&nbsp;' . "Type";
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
      <div class="row">
        <!-- Title Text -->
        <div class="col-md-6">
          <h1 class="page-title"><?= $title ?></h1>
        </div>
        <!-- Title Button -->
        <div class="col-md-6 button-title">
          <a href="#" id="btn_export" class="btn btn-primary shadow-none disabled"><i class="fas fa-file-export"></i> Export as XLSX</a>
          <a href="#" class="btn btn-primary shadow-none disabled" id="btn_apply" employee_id="<?= $this->session->userdata('SESS_USER_ID') ?>"><i class="fas fa-plus mr-2"></i><?= $header_button ?></a>
        </div>
      </div>
      <!-- Title Header Line -->
      <hr>
      <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">
        <div class="row">
          <div class="col">
            <div class="table-responsive">
              <table class="table table-hover" id="TableToExport">
                <thead>
                  <!-- Table Headers -->
                  <?php if ($col_name_1) { ?><th><?= $col_name_1 ?></th><?php } ?>
                  <?php if ($col_name_11) { ?><th><?= $col_name_11 ?></th><?php } ?>
                  <?php if ($col_name_10) { ?><th><?= $col_name_10 ?></th><?php } ?>
                  <?php if ($col_name_2) { ?><th><?= $col_name_2 ?></th><?php } ?>
                  <?php if ($col_name_3) { ?><th><?= $col_name_3 ?></th><?php } ?>
                  <?php if ($col_name_4) { ?><th><?= $col_name_4 ?></th><?php } ?>
                  <?php if ($col_name_5) { ?><th><?= $col_name_5 ?></th><?php } ?>
                  <?php if ($col_name_6) { ?><th><?= $col_name_6 ?></th><?php } ?>
                  <?php if ($col_name_7) { ?><th><?= $col_name_7 ?></th><?php } ?>
                  <?php if ($col_name_8) { ?><th><?= $col_name_8 ?></th><?php } ?>
                  <?php if ($col_name_9) { ?><th><?= $col_name_9 ?></th><?php } ?>
                </thead>
                <!-- Table Information -->
                <tbody id="tbl_application_container">
                  <?php
                  if ($DISP_ALL_DATA) {
                    foreach ($DISP_ALL_DATA as $DISP_ALL_DATA_ROW) {
                      $application_id = $id_code . str_pad($DISP_ALL_DATA_ROW->id, 5, '0', STR_PAD_LEFT);
                      $job_id = $job_id_code . str_pad($DISP_ALL_DATA_ROW->job_id, 5, '0', STR_PAD_LEFT);

                    //   $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_ALL_DATA_ROW->employee_id);
                      // $date = date('D, M j, Y', strtotime($DISP_ALL_DATA_ROW->task_date_from));
                    //   $title = $DISP_ALL_DATA_ROW->title;
                      // $db_date_from = $DISP_ALL_DATA_ROW->from_date;
                      // $date_from = date('D, M j, Y', strtotime($db_date_from));
                      // $application_date = $DISP_ALL_DATA_ROW->date_created;
                      // $application_date = date('D, M j, Y', strtotime($application_date));
                  ?>
                      <tr class="form_row" style="" data-toggle="">
                        <!-- <tr> -->
                        <td><?= $application_id ?></td>
                        <td> <?= $job_id ?> </td>
                        <td> <?= $DISP_ALL_DATA_ROW->date_created  ?> </td>
                        <td><?= $DISP_ALL_DATA_ROW->first_name ?></td>
                        
                        <td><?= $DISP_ALL_DATA_ROW->last_name ?></td>
                        <td style="word-break: break-word;"><?= $DISP_ALL_DATA_ROW->province ?></td>
                        
                        <td><?= $DISP_ALL_DATA_ROW->city ?></td>
                        <td><?= $DISP_ALL_DATA_ROW->baranggay ?></td>
                        
                        <td> <?= $DISP_ALL_DATA_ROW->street  ?> </td>
                        <td> <?= $DISP_ALL_DATA_ROW->zip_code  ?> </td>
                        <td class="text-center" >
                          <a href="<?php echo base_url('applicant_trackings/download/'.$DISP_ALL_DATA_ROW->id); ?>" data-action="download" class="text-center">
                          <p class="btn btn-secondary mr-2 mb-0">
                                                                    <i class="fas fa-file-download"></i>
                                 </p>
                          </a>
                            
                        </td>

                      </tr>
                    <?php
                    }
                  } else {
                    ?>
                    <!-- Message if no entries -->
                    <tr class="table-active">
                      <td colspan="11">
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
  <!-- <?php
  $row_count = $DISP_ROW_COUNT[0]->count;
  $page_count = ceil($DISP_ROW_COUNT[0]->count / 10);
  ?> -->
  <!-- <input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT[0]->count ?>">
  <input type="hidden" id="page_count" value="<?= $page_count ?>">
  <input type="hidden" id="id_code" value="<?= $id_code ?>">
  <aside class="control-sidebar control-sidebar-dark"> -->
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
              <form action="<?php //echo base_url('complaints/insert_all_data'); ?>" id="apply_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                <!-- Employee -->
                <div id="request_data">
                  <div class="form-group">
                    <label class="required" for="STATUS">Status
                    </label>
                    <select class="form-control" name="STATUS" id="STATUS" disabled>
                      <option value="New">New</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="required" for="EMPLOYEE">Employee
                    </label>
                    <select class="form-control" name="EMPLOYEE" id="EMPLOYEE" disabled>
                      <option value=""><?= $user_cmid . ' - ' . $user_firstname . ' ' . $user_lastname ?></option>
                    </select>
                  </div>
                </div><!-- Employee Single  ends-->
                <div class="form-group">
                  <label class="required" for="INSRT_TITLE">Title
                  </label>
                  <input type="text" class="form-control" name="INSRT_TITLE" id="INSRT_TITLE" required>
                </div>
                <!-- Insert Description -->
                <div class="form-group">
                  <label class="required" for="INSRT_DESCRIPTION">Description
                  </label>
                  <textarea class="form-control" name="INSRT_DESCRIPTION" id="INSRT_DESCRIPTION" cols="30" rows="2"></textarea>
                </div>
                <!-- Insert Description -->
                <div class="form-group">
                  <label class="required" for="INSRT_FEEDBACK">Feedback
                  </label>
                  <textarea class="form-control" name="INSRT_FEEDBACK" id="INSRT_FEEDBACK" cols="30" rows="2"></textarea>
                </div>
                <!-- Insert File (DISPLAY NONE)-->
                <div class="form-group" id="application_file">
                  <label for="INSRT_FILE">Attachment &nbsp;&nbsp; <span class="text-muted"></span>
                  </label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input fileficker" id="INSRT_FILE" name="INSRT_FILE" multiple="" accept=".jpg, .jpeg, .png">
                      <label class="custom-file-label" for="INSRT_FILE">Choose file
                      </label>
                    </div>
                  </div>
                </div>
                <!-- Imployee Id -->
                <div class="row">
                  <div class="col-12 w-100">
                    <input type="hidden" name="EMPL_ID" value="<?= $this->session->userdata('SESS_USER_ID') ?>">
                    <button class="btn btn-primary float-right" id="INSRT_BTN" type="submit">Add</button>
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
        <!-- Modal Header -->
        <div class="modal-header" style="border-bottom: none;">
          <h4 class="modal-title mt-0 ml-1">Request Details
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
        </div>
        <!-- Modal Body -->
        <div class="modal-body pb-5">
          <div class="row">
            <div class="col-md-4 col-6">
              <p class="text-bold mb-1"><?= $mod_name_1 ?></p>
              <p class="mb-3" id="employee_name"></p>
              <p class="text-bold mb-1"><?= $mod_name_2 ?></p>
              <p class="mb-3" id="employee_position"></p>
              <p class="text-bold mb-1"><?= $mod_name_3 ?></p>
              <p class="mb-3" id="employee_department"></p>
              <p class="text-bold mb-1"><?= $mod_name_4 ?></p>
              <p class="mb-3" id="date_requested"></p>
              <p class="text-bold mb-1"><?= $mod_name_5 ?></p>
              <p class="mb-3" id="on_date"></p>
              <p class="text-bold mb-1"><?= $mod_name_6 ?></p>
              <p class="mb-3" id="type"></p>
              <p class="text-bold mb-1"><?= $mod_name_7 ?></p>
              <p class="mb-3" id="reason"></p>
              <p class="text-bold mb-1"><?= $mod_name_8 ?></p>
              <p class="mb-3" id="duration"></p>
              <p class="text-bold mb-1"><?= $mod_name_9 ?></p>
              <p class="mb-3" id="status"></p>
            </div>
          </div> <!-- row ends -->
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
          </div><!-- row ends -->
        </div> <!-- Modal Body ends -->
      </div> <!-- modal-content ends -->
    </div> <!-- modal-dialog ends -->
  </div> <!-- modal fade ends -->
  <!-- Edit Modal -->
  <div class="modal fade" id="modal_edit_complaint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header pb-0" style="border-bottom: none;">
          <h4 class="modal-title ml-1" id="exampleModalLabel">Edit My Complaint</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!--Modal Body -->
        <div class="modal-body pb-5">
          <div class="row">
            <div class="col-12">
              <form action="<?php //echo base_url('complaints/edit_data'); ?>" id="update_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                <!-- Employee -->
                <div class="form-group">
                  <label class="required" for="UPDATE_STATUS">status
                  </label>
                  <select class="form-control" name="UPDATE_STATUS" id="UPDATE_STATUS">
                    <option value="New">New</option>
                    <option value="Pending">Pending</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Finished">Finished</option>
                    <option value="Cancelled">Cancelled</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="required" for="EMPLOYEE">Employee
                  </label>
                  <select class="form-control" name="UPDATE_EMPLOYEE" id="UPDATE_EMPLOYEE" disabled>
                    <option value=""><?= $user_cmid . ' - ' . $user_firstname . ' ' . $user_lastname ?></option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="required" for="UPDATE_TITLE">Title
                  </label>
                  <input type="text" class="form-control" name="UPDATE_TITLE" id="UPDATE_TITLE">
                </div>
                <!-- Insert Description -->
                <div class="form-group">
                  <label class="required" for="UPDATE_DESCRIPTION">Description
                  </label>
                  <textarea class="form-control" name="UPDATE_DESCRIPTION" id="UPDATE_DESCRIPTION" cols="30" rows="2"></textarea>
                </div>
                <!-- Insert Description -->
                <div class="form-group">
                  <label class="required" for="UPDATE_FEEDBACK">Feedback
                  </label>
                  <textarea class="form-control" name="UPDATE_FEEDBACK" id="UPDATE_FEEDBACK" cols="30" rows="2"></textarea>
                </div>
                <!-- Insert File (DISPLAY NONE)-->
                <div class="form-group" id="application_file">
                  <label for="INSRT_FILE">Attachment &nbsp;&nbsp; <span class="text-muted"></span>
                  </label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input fileficker" id="UPDATE_FILE" name="UPDATE_FILE" multiple="" accept=".jpg, .jpeg, .png">
                      <label class="custom-file-label" for="UPDATE_FILE">Choose file
                      </label>
                    </div>
                  </div>
                </div>
                <!-- Imployee Id -->
                <div class="row">
                  <div class="col-12 w-100">
                    <input type="hidden" name="COMPLAINT_ID" id="COMPLAINT_ID">
                    <input type="hidden" name="EMPL_ID" value="<?= $this->session->userdata('SESS_USER_ID') ?>">
                    <button class="btn btn-primary float-right" id="BTN_UPDATE">Update</button>
                  </div>
                </div>
              </form> <!-- Form ends -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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
      var url_get_all_data = '<?= base_url()?>complaints/get_all_data';
      var url_base = '<?= base_url() ?>';
      var url_get_specific_data = '<?= base_url() ?>complaints/get_specific_data';
      var url_get_table_list = '<?= base_url() ?>complaints/get_my_specific_data';
      var url_get_empl_data = '<?= base_url() ?>complaints/get_empl_data';
      // var url = '<?php echo base_url(); ?>asset/getAssetData';
      $('#btn_apply').click(function(e) {
        e.preventDefault();
        var employee_id = $(this).attr('employee_id');
        get_empl_data(url_get_empl_data, employee_id).then(function(data) {
          Array.from(data).forEach(function(x) {
            if (x.isRegular >= 0) { //originally  (x.isRegular > 0)
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
      // get and Display data in modal
      const openModalButton = document.querySelectorAll('[data-target]');
      openModalButton.forEach(button => {
        button.addEventListener('click', () => {
          const modal = document.querySelector(button.dataset.target);
          get_specific_data(url_get_specific_data, button.getAttribute('request_id'), button.getAttribute('employee_id')).then(data => {
            if (data.specific_data.length > 0) {
              console.log('length' + data.specific_data.length);
              data.specific_data.forEach((x) => {
                // console.log(x.task_title);
                document.getElementById('UPDATE_STATUS').value = x.status;
                document.getElementById('UPDATE_TITLE').value = x.title;
                document.getElementById('UPDATE_DESCRIPTION').value = x.description;
                document.getElementById('UPDATE_FEEDBACK').value = x.feedback;
                document.getElementById('COMPLAINT_ID').value = x.id;
              });
            }
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
          get_all_data(url_get_all_data, page_num).then(function(data) {
            Array.from(data).forEach(function(e) {
              let id = e.id;
              let employee_id = e.employee_id;
              var status = e.status;
              var title = e.title;
              var description = e.description;
              // var date = e.task_date_from;
              // var date = new Date(e.task_date_from);
              var remarks = e.remarks;
              var application_id = id_code + (e.id).padStart(5, 0);
              $('#tbl_application_container').append(`
                <tr class="form_row" >
                  <td>` + application_id + `</td>
                  <td>` + title + `</td>
                  <td>` + description + `</td>
                  <td>` + status + `</td>
                  <td><a href="" class="btn btn-warning " employee_id="` + employee_id + `" request_id="` + id + `" data-toggle="modal" data-target="#modal_edit_complaint"><i class="fas fa-fw fa-edit"></i></a></td>
                  </tr>
              `)
              const openModalButton = document.querySelectorAll('[data-target]');
              openModalButton.forEach(button => {
                button.addEventListener('click', () => {
                  const modal = document.querySelector(button.dataset.target);
                  get_specific_data(url_get_specific_data, button.getAttribute('request_id'), button.getAttribute('employee_id')).then(data => {
                    if (data.specific_data.length > 0) {
                      console.log('length' + data.specific_data.length);
                      data.specific_data.forEach((x) => {
                        // console.log(x.task_title);
                        document.getElementById('UPDATE_STATUS').value = x.status;
                        document.getElementById('UPDATE_TITLE').value = x.title;
                        document.getElementById('UPDATE_DESCRIPTION').value = x.description;
                        document.getElementById('UPDATE_FEEDBACK').value = x.feedback;
                        document.getElementById('COMPLAINT_ID').value = x.id;
                      });
                    }
                  });
                });
              });
            })
          })
        }
      });
      //-------------------------- ASYNC FUNCTIONS ------------------------------------------
      async function get_all_data(url, page_num) {
        var formData = new FormData();
        formData.append('page_num', page_num);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }
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
<!-------------------- Export ----------------->
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script>
document.getElementById("btn_export").addEventListener('click', function() {
  /* Create worksheet from HTML DOM TABLE */
  var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
  /* Export to file (start a download) */
  XLSX.writeFile(wb, "complaint.xlsx");
});
</script>
</body>
</html>