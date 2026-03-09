<html>

<?php $this->load->view('templates/css_link'); ?>



<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<?php



$title =  "Task Management";

$header_button =  "Add Task";

$modal_title =  "Add Task";

$request_name =  "Add Tasks";



$id_code =  "TSK";



$col_name_1 =  "Task" . '&nbsp;' . "ID";

$col_name_2 =  "Date";

$col_name_3 =  "Title";

$col_name_4 =  "Description";

$col_name_5 =  "Status";

$col_name_6 =   "Action";

$col_name_7 =  "";

$col_name_8 =  "";

$col_name_9 =  "";

$col_name_10 =  "";



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

      <nav aria-label="breadcrumb">

        <ol class="breadcrumb">

          <li class="breadcrumb-item">

            <a href="<?= base_url() ?>nav_project_managements">Project Management</a>

          </li>

          <li class="breadcrumb-item active" aria-current="page">Task Management</li>

        </ol>

      </nav>

      <div class="row">



        <!-- Title Text -->

        <div class="col-md-6">
          <h1 class="page-title"><?= $title ?></h1>
        </div>



        <!-- Title Button -->

        <div class="col-md-6 button-title">
          <a href="<?php echo base_url('task/exportCSV'); ?>" cutoff_id="" class="btn btn-primary" id="download_csv"><i
              class="fas fa-download"></i>&nbsp;&nbsp;Export </a>
          <a href="#" class="btn btn-primary shadow-none" id="btn_apply"
            employee_id="<?= $this->session->userdata('SESS_USER_ID') ?>"><i class="fas fa-plus mr-2"></i><?= $header_button ?></a>

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

                      $employee_id = $this->project_management_model->MOD_DISP_EMPLOYEE($DISP_TABLE_ROW->employee_id);

                      $date = date('D, M j, Y', strtotime($DISP_TABLE_ROW->task_date_from));

                      $title = $DISP_TABLE_ROW->task_title;

                      // $db_date_from = $DISP_TABLE_ROW->from_date;

                      // $date_from = date('D, M j, Y', strtotime($db_date_from));

                      // $application_date = $DISP_TABLE_ROW->date_created;

                      // $application_date = date('D, M j, Y', strtotime($application_date));





                  ?>



                  <tr class="form_row" style="" data-toggle="" employee_id="<?= $DISP_TABLE_ROW->employee_id ?>"
                    request_id="<?= $DISP_TABLE_ROW->id ?>">

                    <!-- <tr> -->

                    <td><?= $application_id ?></td>

                    <td><?= $date ?></td>

                    <td><?= $title ?></td>





                    <!-- <td>

                          <a href="#">

                            <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($employee_id[0]->col_imag_path) {

                                                                                              echo base_url() . 'user_images/' . $employee_id[0]->col_imag_path;

                                                                                            } else {

                                                                                              echo base_url() . 'user_images/default_profile_img3.png';

                                                                                            } ?>">&nbsp;&nbsp;<?= $employee_id[0]->col_frst_name . ' ' . $employee_id[0]->col_last_name ?>

                          </a>

                        </td> -->





                    <td><?= $DISP_TABLE_ROW->task_description ?></td>

                    <td style="word-break: break-word;"><?= $DISP_TABLE_ROW->status ?></td>

                    <td><a href="" class="btn btn-warning" employee_id="<?= $DISP_TABLE_ROW->employee_id ?>"
                        request_id="<?= $DISP_TABLE_ROW->id ?>" data-toggle="modal" data-target="#modal_edit_task"><i
                          class="fas fa-fw fa-edit"></i></a></td>





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

  <div class="modal fade" id="modal_apply" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">

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

              <form action="<?php echo base_url('task_managements/insert_data'); ?>" id="apply_form" method="post"
                accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">





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

                    <select class="form-control" name="EMPLOYEE" id="EMPLOYEE">

                      <option value=""><?= $user_cmid . ' - ' . $user_firstname . ' ' . $user_lastname ?></option>

                    </select>

                  </div>



                  <!-- Type -->

                  <!-- <div class="form-group">

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

                  </div> -->



                  <!--  Date -->
                  <div class="form-check">
                    <input class="form-check-input all_day" type="checkbox" name="all_day" value="true"
                      style="width:15px;height:15px">
                    <span class="d-inline-block" style="margin-top:3px">All Day</span>
                  </div>
                  <div class="form-group  date_container  d-flex justify-content-between w-100">
                    <div class="w-25">
                      <label class="required" for="INSRT_DATE_FROM">Start Date</label>
                      <input type="date" class="form-control" name="INSRT_DATE_FROM" id="INSRT_DATE_FROM" required>
                    </div>
                    <div class="ml-3 time_container">
                      <label>Set Time</label>
                      <div class="d-flex border border-1 border-darken container_select">
                        <div class="">
                          <select class="form-control border-0 time" name="start_time" style="appearance:none">
                            <option value="00">--</option>
                            <?php for($i=1;$i<=12;$i++) {?>
                            <option value="<?=$i.':00'?>"><?= $i.':00'?></option>
                            <?php for($j=15;$j<=45;$j+=15) {?>
                            <option value="<?=$i.':'.$j?>"><?= $i.':'.$j?></option>
                            <?}?>
                            <?}?>
                          </select>
                        </div>
                        <div class="">
                          <select class="form-control border-0" name="start_Indicator" style="appearance:none">
                            <option>--</option>
                            <option value="am">AM</option>
                            <option value="pm">PM</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group date_container  d-flex justify-content-between w-100">
                    <div class="w-25">
                      <label class="required" for="INSRT_DATE_TO">Due Date</label>
                      <input type="date" class="form-control" name="INSRT_DATE_TO" id="INSRT_DATE_TO" required>
                    </div>
                    <div class="ml-3 ">
                      <label>Set Time</label>
                      <div class="d-flex border border-1 border-darken container_select">
                        <div class="">
                          <select class="form-control border-0 time" name="end_time" style="appearance:none">
                            <option value="00">--</option>
                            <?php for($i=1;$i<=12;$i++) {?>
                            <option value="<?=$i.':00'?>"><?= $i.':00'?></option>
                            <?php for($j=15;$j<=45;$j+=15) {?>
                            <option value="<?=$i.':'.$j?>"><?= $i.':'.$j?></option>
                            <?}?>
                            <?}?>
                          </select>
                        </div>
                        <div class="">
                          <select class="form-control border-0" name="end_Indicator" style="appearance:none">
                            <option>--</option>
                            <option value="am">AM</option>
                            <option value="pm">PM</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>



                  <!--  Duration -->

                  <!-- <div class="form-group">

                    <label class="required" for="INSRT_DURATION">Duration

                    </label>

                    <input type="number" name="INSRT_DURATION" id="INSRT_DURATION" class="form-control" step="0.25" placeholder="Enter Duration (Days)" required>

                     -->

                  <!-- <select class="form-control" name="INSRT_DURATION" id="INSRT_DURATION">

                    <option value="">Choose...</option>

                    <option value="0.5">Half Day</option>

                    <option value="1">Full Day</option>

                  </select> -->

                  <!-- </div> -->



                </div>
                <!-- Employee Single  ends-->



                <div class="form-group">

                  <label class="required" for="INSRT_TITLE">Title

                  </label>

                  <input type="text" class="form-control" name="INSRT_TITLE" id="INSRT_TITLE" required>

                </div>





                <!-- Insert Description -->

                <div class="form-group">

                  <label class="required" for="INSRT_DESCRIPTION">Description

                  </label>

                  <textarea class="form-control" name="INSRT_DESCRIPTION" id="INSRT_DESCRIPTION" cols="30"
                    rows="2"></textarea>

                </div>



                <!-- Insert File (DISPLAY NONE)-->

                <div class="form-group" id="application_file">

                  <label for="INSRT_FILE">Attachment &nbsp;&nbsp; <span class="text-muted"></span>

                  </label>

                  <div class="input-group">

                    <div class="custom-file">

                      <input type="file" class="custom-file-input fileficker" id="INSRT_FILE" name="INSRT_FILE"
                        multiple="" accept=".jpg, .jpeg, .png">

                      <label class="custom-file-label" for="INSRT_FILE">Choose file

                      </label>

                    </div>

                  </div>

                </div>



                <!-- Insert Description -->

                <div class="form-group">

                  <label for="INSRT_REMARKS">Remarks

                  </label>

                  <textarea class="form-control" name="INSRT_REMARKS" id="INSRT_REMARKS" cols="30" rows="2"></textarea>

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

  <div class="modal fade" id="modal_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">

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

  <div class="modal fade" id="modal_edit_task" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">

      <div class="modal-content">



        <div class="modal-header pb-0" style="border-bottom: none;">

          <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Tasks</h4>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

          </button>

        </div>



        <!--Modal Body -->

        <div class="modal-body pb-5">



          <div class="row">

            <div class="col-12">

              <form action="<?php echo base_url('task_managements/edit_data'); ?>" id="update_form" method="post"
                accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">

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

                  <select class="form-control" name="UPDATE_EMPLOYEE" id="UPDATE_EMPLOYEE">

                    <option value=""><?= $user_cmid . ' - ' . $user_firstname . ' ' . $user_lastname ?></option>

                  </select>

                </div>



                <!--  Date -->
                <div class="form-check">
                  <input class="form-check-input all_day" type="checkbox" name="all_day" value="true"
                    style="width:15px;height:15px">
                  <span class="d-inline-block" style="margin-top:3px">All Day</span>
                </div>
                <div class="form-group d-flex date_container justify-content-between w-100">
                  <div class="w-50">
                    <label class="required" for="UPDATE_DATE_FROM">Start Date</label>
                    <input type="date" class="form-control" name="UPDATE_DATE_FROM" id="UPDATE_DATE_FROM">
                  </div>

                  <div class="ml-3">
                    <label>Set Time</label>
                    <div class="d-flex border border-1 border-darken container_select">
                      <div class="container_select">
                        <select class="form-control border-0 time" name="start_time" id="UPDATE_START_TIME"
                          style="appearance:none">
                          <option value="00">--</option>
                          <?php for($i=1;$i<=12;$i++) {?>
                          <?php for($j=0;$j<=45;$j+=15) {?>
                          <option value="<?php echo $i<10 ? '0'.$i : $i; echo ':'; echo $j==0 ? '00' : $j ?>"><?php echo $i<10 ? '0'.$i : $i; echo ':'; echo $j==0 ? '00' : $j  ?></option>
                          <?}?>
                          <?}?>
                        </select>
                      </div>
                      <div class="container_select">
                        <select class="form-control border-0" name="start_Indicator" id="UPDATE_START_INDICATOR"
                          style="appearance:none">
                          <option value="00">--</option>
                          <option value="am">AM</option>
                          <option value="pm">PM</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group date_container  d-flex justify-content-between w-100">
                  <div class="w-50">
                    <label class="required" for="UPDATE_DATE_TO">Due Date</label>
                    <input type="date" class="form-control" name="UPDATE_DATE_TO" id="UPDATE_DATE_TO">
                  </div>
                  <div class="ml-3">
                    <label>Set Time</label>
                    <div class="d-flex border border-1 border-darken container_select">
                      <div class="">
                        <select class="form-control border-0 time" name="end_time" id="UPDATE_END_TIME"
                          style="appearance:none">
                          <option value="00">--</option>
                          <?php for($i=1;$i<=12;$i++) {?>
                          <?php for($j=0;$j<=45;$j+=15) {?>
                          <option value="<?php echo $i<10 ? '0'.$i : $i; echo ':'; echo $j==0 ? '00' : $j ?>"><?php echo $i<10 ? '0'.$i : $i; echo ':'; echo $j==0 ? '00' : $j  ?></option>
                          <?}?>
                          <?}?>
                        </select>
                      </div>
                      <div class="">
                        <select class="form-control border-0" name="end_Indicator" id="UPDATE_END_INDICATOR"
                          style="appearance:none">
                          <option>--</option>
                          <option value="am">AM</option>
                          <option value="pm">PM</option>
                        </select>
                      </div>
                    </div>
                  </div>
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

                  <textarea class="form-control" name="UPDATE_DESCRIPTION" id="UPDATE_DESCRIPTION" cols="30"
                    rows="2"></textarea>

                </div>



                <!-- Insert File (DISPLAY NONE)-->

                <div class="form-group" id="application_file">

                  <label for="INSRT_FILE">Attachment &nbsp;&nbsp; <span class="text-muted"></span>

                  </label>

                  <div class="input-group">

                    <div class="custom-file">

                      <input type="file" class="custom-file-input fileficker" id="UPDATE_FILE" name="UPDATE_FILE"
                        multiple="" accept=".jpg, .jpeg, .png">

                      <label class="custom-file-label" for="UPDATE_FILE">Choose file

                      </label>

                    </div>

                  </div>

                </div>



                <!-- Insert Description -->

                <div class="form-group">

                  <label for="UPDATE_REMARKS">Remarks

                  </label>

                  <textarea class="form-control" name="UPDATE_REMARKS" id="UPDATE_REMARKS" cols="30"
                    rows="2"></textarea>

                </div>



                <!-- Imployee Id -->

                <div class="row">

                  <div class="col-12 w-100">

                    <input type="hidden" name="TASK_ID" id="TASK_ID">

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

    $(document).ready(function () {

      // controller urls

      var url_base = '<?= base_url() ?>';

      var url_get_specific_data = '<?= base_url() ?>task/get_specific_data';

      var url_get_table_list = '<?= base_url() ?>task/get_my_specific_data';

      var url_get_empl_data = '<?= base_url() ?>task/get_empl_data';

      // var url = '<?php echo base_url(); ?>asset/getAssetData';



      $('#btn_apply').click(function (e) {

        e.preventDefault();



        var employee_id = $(this).attr('employee_id');

        get_empl_data(url_get_empl_data, employee_id).then(function (data) {

          Array.from(data).forEach(function (x) {

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
                console.log(x.start_time);

                document.getElementById('UPDATE_STATUS').value = x.status;

                document.getElementById('UPDATE_DATE_FROM').value = x.task_date_from;

                document.getElementById('UPDATE_START_TIME').value = x.start_time;

                document.getElementById('UPDATE_END_TIME').value = x.end_time;

                document.getElementById('UPDATE_START_INDICATOR').value = x.start_indicator.toLowerCase();

                document.getElementById('UPDATE_END_INDICATOR').value = x.end_indicator.toLowerCase()//x.end_indicator.toLowerCase();

                document.getElementById('UPDATE_DATE_TO').value = x.task_date_to;

                document.getElementById('UPDATE_TITLE').value = x.task_title;

                document.getElementById('UPDATE_DESCRIPTION').value = x.task_description;

                document.getElementById('UPDATE_REMARKS').value = x.remarks;

                document.getElementById('TASK_ID').value = x.id;



                // var html = x.col_asset_description.replace(/<style([\s\S]*?)<\/style>/gi, '');

                // html = html.replace(/<script([\s\S]*?)<\/script>/gi, '');

                // html = html.replace(/<\/div>/ig, '\n');

                // html = html.replace(/<\/li>/ig, '\n');

                // html = html.replace(/<li>/ig, '  *  ');

                // html = html.replace(/<\/ul>/ig, '\n');

                // html = html.replace(/<\/p>/ig, '\n');

                // html = html.replace(/<br\s*[\/]?>/gi, "\n");

                // html = html.replace(/<[^>]+>/ig, '');



                // document.getElementById('UPDT_ASSET_DESCRIPTION').value = html;

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

        click: function (e) {

          $('#tbl_application_container').html('');



          var row_count = $('#row_count').val();

          var page_count = $('#page_count').val();

          var id_code = $('#id_code').val();

          var page_num = e.current;



          get_table_data(url_get_table_list, page_num).then(function (data) {

            Array.from(data).forEach(function (e) {

              let id = e.id;

              let employee_id = e.employee_id;

              var status = e.status;

              var title = e.task_title;

              var description = e.task_description;

              // var date = e.task_date_from;

              var date = new Date(e.task_date_from);

              var remarks = e.remarks;

              var application_id = id_code + (e.id).padStart(5, 0);





              $('#tbl_application_container').append(`

                <tr class="form_row" >

                  <td>` + application_id + `</td>

                  <td>` + date.toDateString() + `</td>

                  <td>` + title + `</td>

                  <td>` + description + `</td>

                  <td>` + status + `</td>

                  <td><a href="" class="btn btn-warning btn_edit_task" employee_id="` + employee_id + `" request_id="` + id + `" data-toggle="modal" data-target="#modal_edit_task"><i class="fas fa-fw fa-edit"></i></a></td>

                

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

                        document.getElementById('UPDATE_STATUS').value = x.status;

                        document.getElementById('UPDATE_DATE_FROM').value = '2022/01/26';

                        document.getElementById('UPDATE_DATE_TO').value = x.task_date_to;

                        document.getElementById('UPDATE_TITLE').value = x.task_title;

                        document.getElementById('UPDATE_DESCRIPTION').value = x.task_description;

                        document.getElementById('UPDATE_REMARKS').value = x.remarks;

                        document.getElementById('TASK_ID').value = x.id;



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
      $('input.all_day').on("click", function () {
        if (this.checked) {
          console.log("hello");
          $(this).parent().siblings('.date_container').find("div").children().children().prop('disabled', 'disabled'); //children("div.date_container").children("div.time_container").css("border","2px solid red");
          return;
        }
        $(this).parent().siblings('.date_container').find("div").children().children().prop('disabled', false)
      })

    })

  </script>

</body>



</html>