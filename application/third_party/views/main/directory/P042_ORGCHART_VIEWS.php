<style>
  .btn-group .btn {
    padding: 0px 12px;
  }

  .page-title {
    font-weight: 600;
    color: #424F5C;
    font-size: 33px;
  }

  th,
  td {
    font-size: 13px !important;
  }

  label.required::after {
    content: " *";
    color: red;
  }

  a:hover {
    text-decoration: none;
  }

  .active {
    font-weight: 500;
  }
</style>

<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>css/org_chart.css">

<div class="content-wrapper">

  <div class="p-3">

    <div class="flex-fill">

      <div class="row pr-3 mb-2">

        <div class="col">

          <h1 class="page-title">Organizational Chart</h1>

        </div>

      </div>

      <div class="row px-4 mt-4" style="margin-bottom: 75px;">

        <div class="btn-group float-left mr-4">

          <a class="btn btn-light active py-2 px-4" href="<?= base_url() ?>employees/org_chart">Employees</a>

          <a class="btn btn-light py-2 px-4" href="#">Departments</a>

        </div>

      </div>

      <div class="row">

        <div class="col-md-8 mx-auto">

          <!-- START OF ORGANIZATIONAL CHART -->
          <div class="tree" id="mydiv">

            <?php if ($DISP_ORGCHART_TOP_POSITION) : ?>
              <!-- Parent -->
              <ul style="width: 100%;">

                <?php foreach ($DISP_ORGCHART_TOP_POSITION as $DISP_ORGCHART_TOP_POSITION_ROW) : ?>

                  <li style="width: 100%;">

                    <a href="#">
                    
                      <img src="<?php if($DISP_ORGCHART_TOP_POSITION_ROW->col_imag_path){echo base_url().'user_images/'.$DISP_ORGCHART_TOP_POSITION_ROW->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>" class="profile_img">

                      <strong class="profile_name_org"><?php echo $DISP_ORGCHART_TOP_POSITION_ROW->col_frst_name . " " . $DISP_ORGCHART_TOP_POSITION_ROW->col_last_name ?></strong>

                      <small class="position"><?php echo $DISP_ORGCHART_TOP_POSITION_ROW->col_empl_posi ?></small>

                    </a>

                    <?php $DISP_ORGCHART_MID_POSITION = $this->p041_orgchart_mod->MOD_DISP_MID_POSITION($DISP_ORGCHART_TOP_POSITION_ROW->id); ?>

                    <?php if ($DISP_ORGCHART_MID_POSITION) : ?>
                      <!-- Generation 1 Child -->
                      <ul>

                        <?php foreach ($DISP_ORGCHART_MID_POSITION as $DISP_ORGCHART_MID_POSITION_ROW) : ?>

                          <?php if (($DISP_ORGCHART_MID_POSITION_ROW->col_empl_repo == $DISP_ORGCHART_TOP_POSITION_ROW->id) && ($DISP_ORGCHART_MID_POSITION_ROW->col_user_type != 'HR Head')) : ?>

                            <li>

                              <a href="#">
                              
                                <img src="<?php if($DISP_ORGCHART_MID_POSITION_ROW->col_imag_path){echo base_url().'user_images/'.$DISP_ORGCHART_MID_POSITION_ROW->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>" class="profile_img">

                                <strong class="profile_name_org"><?php echo $DISP_ORGCHART_MID_POSITION_ROW->col_frst_name . " " . $DISP_ORGCHART_MID_POSITION_ROW->col_last_name ?></strong>

                                <small class="position"><?php echo $DISP_ORGCHART_MID_POSITION_ROW->col_empl_posi ?></small>

                              </a>

                              <?php $DISP_ORGCHART_BOT_POSITION = $this->p041_orgchart_mod->MOD_DISP_BOT_POSITION($DISP_ORGCHART_MID_POSITION_ROW->id); ?>

                              <?php if ($DISP_ORGCHART_BOT_POSITION) : ?>
                                <!-- Generation 2 Child -->
                                <ul>

                                  <?php foreach ($DISP_ORGCHART_BOT_POSITION as $DISP_ORGCHART_BOT_POSITION_ROW) : ?>

                                    <?php if ($DISP_ORGCHART_BOT_POSITION_ROW->col_empl_repo == $DISP_ORGCHART_MID_POSITION_ROW->id) : ?>

                                      <li>

                                        <a href="#">
                                        
                                          <img src="<?php if($DISP_ORGCHART_BOT_POSITION_ROW->col_imag_path){echo base_url().'user_images/'.$DISP_ORGCHART_BOT_POSITION_ROW->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>" class="profile_img">

                                          <strong class="profile_name_org"><?php echo $DISP_ORGCHART_BOT_POSITION_ROW->col_frst_name . " " . $DISP_ORGCHART_BOT_POSITION_ROW->col_last_name ?></strong>

                                          <small class="position"><?php echo $DISP_ORGCHART_BOT_POSITION_ROW->col_empl_posi ?></small>

                                        </a>

                                        <!-- Next Generation Codes Here -->

                                      </li>

                                    <?php endif; ?>

                                  <?php endforeach; ?>

                                </ul>

                              <?php endif; ?>

                            </li>

                          <?php endif; ?>

                        <?php endforeach; ?>

                      </ul>

                    <?php endif; ?>

                  </li>

                <?php endforeach; ?>

              </ul>

            <?php endif; ?>

          </div>

        </div>

      </div>

      <!-- END OF ORGANIZATIONAL CHART -->

    </div> <!-- ./flex-fill -->

  </div> <!-- .p-3 -->

</div> <!-- ./content-wrapper -->

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
<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js">
</script>

<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js">
</script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js">
</script>

<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js">
</script>

<!-- Summernote -->
<script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js">
</script>

<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js">
</script>

<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/adminlte.js">
</script>

<!-- Full Calendar 2.2.5 -->
<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js">
</script>
<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js">
</script>

<!-- Sweet Alert -->
<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js">
</script>

<!-- Toastr -->
<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js">
</script>

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js">
</script>

<!-- Include Editor JS files. -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/js/froala_editor.pkgd.min.js"></script>

<script>
  //Make the DIV element draggagle:
  dragElement(document.getElementById("mydiv"));

  function dragElement(elmnt) {
    var pos1 = 0,
      pos2 = 0,
      pos3 = 0,
      pos4 = 0;
    if (document.getElementById(elmnt.id + "header")) {
      /* if present, the header is where you move the DIV from:*/
      document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
    } else {
      /* otherwise, move the DIV from anywhere inside the DIV:*/
      elmnt.onmousedown = dragMouseDown;
    }

    function dragMouseDown(e) {
      e = e || window.event;
      e.preventDefault();
      // get the mouse cursor position at startup:
      pos3 = e.clientX;
      pos4 = e.clientY;
      document.onmouseup = closeDragElement;
      // call a function whenever the cursor moves:
      document.onmousemove = elementDrag;
    }

    function elementDrag(e) {
      e = e || window.event;
      e.preventDefault();
      // calculate the new cursor position:
      pos1 = pos3 - e.clientX;
      pos2 = pos4 - e.clientY;
      pos3 = e.clientX;
      pos4 = e.clientY;
      // set the element's new position:
      elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
      elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    }

    function closeDragElement() {
      /* stop moving when mouse button is released:*/
      document.onmouseup = null;
      document.onmousemove = null;
    }
  }
</script>