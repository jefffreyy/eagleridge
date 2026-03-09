<html lang="en" style="height: auto">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Eyebox | Projects</title>

    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback"
    />

    <link
      rel="stylesheet"
      href="component/all.min.css"
    />

    <link
      rel="stylesheet"
      href="component/adminlte.min.css?v=3.2.0"
    />
<!-- Multiselect -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">


    <script
      defer=""
      referrerpolicy="origin"
      src="/cdn-cgi/zaraz/s.js?z=JTdCJTIyZXhlY3V0ZWQlMjIlM0ElNUIlNUQlMkMlMjJ0JTIyJTNBJTIyQWRtaW5MVEUlMjAzJTIwJTdDJTIwUHJvamVjdHMlMjIlMkMlMjJ4JTIyJTNBMC45ODU1NDA0MDY1NDkwNzEyJTJDJTIydyUyMiUzQTEyODAlMkMlMjJoJTIyJTNBNzIwJTJDJTIyaiUyMiUzQTc3MCUyQyUyMmUlMjIlM0ExNzA3JTJDJTIybCUyMiUzQSUyMmh0dHBzJTNBJTJGJTJGYWRtaW5sdGUuaW8lMkZ0aGVtZXMlMkZ2MyUyRnBhZ2VzJTJGZXhhbXBsZXMlMkZwcm9qZWN0cy5odG1sJTIyJTJDJTIyciUyMiUzQSUyMiUyMiUyQyUyMmslMjIlM0EyNCUyQyUyMm4lMjIlM0ElMjJVVEYtOCUyMiUyQyUyMm8lMjIlM0EtNDgwJTJDJTIycSUyMiUzQSU1QiU1RCU3RA==">
    </script>

    <script nonce="59625435-fe9d-4ec8-8333-d84171e77ba4">
      (function (w, d) {
        !(function (f, g, h, i) {
          f[h] = f[h] || {};
          f[h].executed = [];
          f.zaraz = { deferred: [], listeners: [] };
          f.zaraz.q = [];
          f.zaraz._f = function (j) {
            return function () {
              var k = Array.prototype.slice.call(arguments);
              f.zaraz.q.push({ m: j, a: k });
            };
          };
          for (const l of ["track", "set", "debug"]) f.zaraz[l] = f.zaraz._f(l);
          f.zaraz.init = () => {
            var m = g.getElementsByTagName(i)[0],
              n = g.createElement(i),
              o = g.getElementsByTagName("title")[0];
            o && (f[h].t = g.getElementsByTagName("title")[0].text);
            f[h].x = Math.random();
            f[h].w = f.screen.width;
            f[h].h = f.screen.height;
            f[h].j = f.innerHeight;
            f[h].e = f.innerWidth;
            f[h].l = f.location.href;
            f[h].r = g.referrer;
            f[h].k = f.screen.colorDepth;
            f[h].n = g.characterSet;
            f[h].o = new Date().getTimezoneOffset();
            if (f.dataLayer)
              for (const s of Object.entries(
                Object.entries(dataLayer).reduce((t, u) => ({
                  ...t[1],
                  ...u[1],
                }))
              ))
                zaraz.set(s[0], s[1], { scope: "page" });
            f[h].q = [];
            for (; f.zaraz.q.length; ) {
              const v = f.zaraz.q.shift();
              f[h].q.push(v);
            }
            n.defer = !0;
            for (const w of [localStorage, sessionStorage])
              Object.keys(w || {})
                .filter((y) => y.startsWith("_zaraz_"))
                .forEach((x) => {
                  try {
                    f[h]["z_" + x.slice(7)] = JSON.parse(w.getItem(x));
                  } catch {
                    f[h]["z_" + x.slice(7)] = w.getItem(x);
                  }
                });
            n.referrerPolicy = "origin";
            n.src =
              "/cdn-cgi/zaraz/s.js?z=" +
              btoa(encodeURIComponent(JSON.stringify(f[h])));
            m.parentNode.insertBefore(n, m);
          };
          ["complete", "interactive"].includes(g.readyState)
            ? zaraz.init()
            : f.addEventListener("DOMContentLoaded", zaraz.init);
        })(w, d, "zarazData", "script");
      })(window, document);
    </script>

  </head>
<?php 
  $title =  "Projects";
  $header_button =  "Add Project";
  $modal_title =  "Add Project";
  $request_name =  "Add Project";
  
  $col_name_1 = "ID";
  $col_name_2 = "Project Name";
  $col_name_3 = "Team Members";
  $col_name_4 = "Progress";
  $col_name_5 = "Status";
  $col_name_6 = "Action";


  $id_code =  "PRJ";
  
?>

  <body class="">
    <div class="">

      <div class="content-wrapper" >
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Projects</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Projects</li>
                </ol>
              </div>
            </div>
          </div>
        </section>

      <!-- Add Project -->
      <div class="col-md-12 button-title mb-2">
        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#modal_assign">
         <i class="fas fa-plus mr-2"></i>Assign members
        </button>
    
        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#modal_apply">
        <i class="fas fa-plus mr-2"></i>Add project
        </button>
      </div>

        <section class="content">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Projects</h3>
              <div class="card-tools">
                <button
                  type="button"
                  class="btn btn-tool"
                  data-card-widget="collapse"
                  title="Collapse"
                >
                  <i class="fas fa-minus"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-tool"
                  data-card-widget="remove"
                  title="Remove"
                >
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0" style="display: block">
              <table class="table table-striped projects">
                <thead>
             
                      <?php if ($col_name_1) {?> <th class="mx-3"><?= $col_name_1 ?></th> <?php } ?>
                      <?php if ($col_name_2) {?> <th><?= $col_name_2 ?></th> <?php } ?>
                      <?php if ($col_name_3) {?> <th><?= $col_name_3 ?></th> <?php } ?>
                      <?php if ($col_name_4) {?> <th><?= $col_name_4 ?></th> <?php } ?>
                      <?php if ($col_name_5) {?> <th><?= $col_name_5 ?></th> <?php } ?>
                      
           
                </thead>
                <tbody>
             
                    
                      <?php
                        if ($DISP_ALL_DATA) {
                          foreach ($DISP_ALL_DATA as $DISP_ALL_DATA_ROW) {
                            $application_id = $id_code . str_pad($DISP_ALL_DATA_ROW->id, 5, '0', STR_PAD_LEFT);
                            $title = $DISP_ALL_DATA_ROW->project_name;
                          
                          
                            
                         if ($DISP_ALL_DATA_ROW->status == 'Inactive') {
                              $status_badge = "badge-secondary";
                              $status_text = "Inactive";
                            } else if ($DISP_ALL_DATA_ROW->status == 'Pending') {
                                $status_badge = "badge-warning";
                                $status_text = "Pending";
                            } else {
                                $status_badge = "badge-success";
                                $status_text = "Success";
                            }

                            

                        ?>
                            <tr class="form_row" style="" data-toggle="" >
                              <!-- <tr> -->
                              <td><?= $application_id ?></td>
                              <td>
                                <?= $title ?><br>
                                <small>
                                  Created. <?= $DISP_ALL_DATA_ROW->date_created ?>
                                </small>
                              </td>
                                
                                      
                                  <td>
                                          <?php echo count(array_filter(explode(',', ($DISP_ALL_DATA_ROW->employee_id == null)? ''  :  $DISP_ALL_DATA_ROW->employee_id))); ?>
                                  </td>
                             
                                
                              <td class="project_progress">
                                <div class="progress progress-sm">
                                <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?= $DISP_ALL_DATA_ROW->project_progress ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $DISP_ALL_DATA_ROW->project_progress ?>%">
                                </div>
                                </div>
                                <small>
                                   <?= $DISP_ALL_DATA_ROW->project_progress ?>% Complete
                                </small>
                              </td>
                              <td class="project-state">
                                <span class="badge <?= $status_badge ?>">
                                    <?= $status_text ?>
                                </span>
                              </td>

                              <td class="project-actions text-center">
                                <a class="btn btn-primary btn-sm" href="#">
                                  <i class="fas fa-folder"> </i>
                                  View
                                </a>

                                <a class="btn btn-info btn-sm" href="#" data-toggle="modal" data-target="#modal_update">
                                  <i class="fas fa-pencil-alt"> </i>
                                  Edit
                                </a>
              
                                <a class="btn btn-danger btn-sm" href="#">
                                  <i class="fas fa-trash"> </i>
                                  Delete
                                </a>
                              </td>
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
        </section>
    </div>                    

<!-- Adding Project -->
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

          <form action="<?php echo base_url('projects/insert_all_data'); ?>" id="apply_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">

            <!-- Employee -->

            <div id="request_data">


                  <!-- Status -->
                <div class="form-group">
                      <label class="required" for="status">Status
                      </label>
                      <select class="form-control" name="status" id="status" required>
                        <option value="Success">Success</option>
                        <option value="Pending">Pending</option>
                        <option value="Inactive">Inactive</option>
                      </select>
                </div>

                <!-- Project name -->
                <div class="form-group">
                    <label class="required" for="project_name">Project name
                    </label>
                    <input type="text" class="form-control" name="project_name" id="project_name" required/>
                </div>
                <!-- Code -->
                <div class="form-group">
                    <label class="required" for="code">Code
                    </label>
                    <input type="text" class="form-control" name="code" id="code" required/>
                </div>
            
                <!-- Type -->
                <div class="form-group">
                    <label class="required" for="type">Type
                    </label>
                    <input type="text" class="form-control" name="type" id="type" required/>
                </div>
                
                <!-- Budget -->
                <div class="form-group">
                    <label class="required" for="budget">Budget
                    </label>
                    <input type="number" class="form-control" name="budget" id="budget" required/>
                </div>
                <!-- Description -->
                <div class="form-group">
                    <label class="required" for="description">Description
                    </label>
                    <textarea name="description" id="description" cols="10" rows="5" class="form-control" required></textarea>
                </div>
                <!-- Max members-->
                <div class="form-group">
                    <label class="required" for="max-member">Max members
                    </label><br>
                    <input type="number" class="form-control" name="max-member" id="max-member" required/>
                </div>
                 <!-- Join Date -->
                 <div class="form-group">
                      <label class="required" for="start_date">Start date
                      </label><br>
                      <input type="date" data-date-format="dd/mm/yyyy" id="datepicker" name="start_date" class="form-control" required>
                  </div>

                   <!-- End Date -->
                   <div class="form-group">
                      <label class="required" for="end_date">End date
                      </label><br>
                      <input type="date" data-date-format="dd/mm/yyyy" id="datepicker" name="end_date" class="form-control" required>
                  </div>

                    <!-- Progress -->
           <div class="form-group">
                  <label for="progress">Project progress
                    </label>
                    <input class="form-control" type="range" min="1" max="100" value="1" step="1" name="progress" oninput="showValue(this)" required>
                    <span id="range">1</span><span>%</span>
              </div>

            <!-- Imployee Id -->

            <div class="row">

              <div class="col-12 w-100">

                <input type="hidden" name="EMPL_ID" value="<?= $this->session->userdata('SESS_USER_ID') ?>">

                <button class="btn btn-primary float-right" id="INSRT_BTN" type="submit">Add</button>

              </div>

            </div>

          </form> <!-- Form ends -->

              </div><!-- Employee Single  ends-->

       

        </div> <!-- col-12 ends  -->

      </div> <!-- row ends  -->

    </div> <!-- Modal ends -->

  </div> <!-- modal-content ends -->

</div> <!-- modal-dialog ends -->

</div> <!-- modal fade ends -->



<!-- Add member modal -->
<div class="modal fade" id="modal_assign" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <!--Modal Header -->

      <div class="modal-header">

        <h4 class="modal-title mt-0 ml-1">Assign members</h4>

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

            <form action="<?php echo base_url('projects/add_members'); ?>" id="apply_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">


              <div id="request_data">
                <!-- Assign project -->
                <div class="form-group">
                      <label class="required" for="project">Select project
                      </label>
                        <select name="project" id="project" class="form-control" required>

                          <option value="">Select project</option>
                              <?php
                              foreach ($DISP_ALL_DATA as $DISP_ALL_DATA_ROW){ ?>

                                <option value="<?= $DISP_ALL_DATA_ROW->id ?>">
                                
                                  
                                <?= $DISP_ALL_DATA_ROW->project_name ?>
                            

                                    <?php } ?>

                                </option>
                        

                        </select>
                  </div>

              

                </div>
                
                <!-- Select member -->
                <div class="">
                      <label class="required " for="member">Select member
                      </label>
                      <select name="member[]" id="members" class="" multiple="multiple" required> 
                          <?php

                              if ($DISP_ALL_EMPLOYEES) {
                                foreach ($DISP_ALL_EMPLOYEES as $DISP_ALL_EMPLOYEES_ROW) {

                            ?>
                                <option value="<?php echo $DISP_ALL_EMPLOYEES_ROW->id;?>">
                                  <?= $DISP_ALL_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_ALL_EMPLOYEES_ROW->col_last_name ?>
                                </option>
                            <?php

                              }

                              }

                              ?>

                        </select>
                  </div>
                  <!-- Role -->
                  <div class="form-group">
                      <label class="required" for="role">Role
                      </label>
                      <input type="text" class="form-control" name="role" id="role" required/>
                  </div>
                  <!-- Join Date -->
                  <div class="form-group">
                      <label class="required" for="join_date">Joining date
                      </label><br>
                      <input type="date" data-date-format="dd/mm/yyyy" id="datepicker" name="join_date" class="form-control" required>
                  </div>
                  <!-- Start Date -->
                  <div class="form-group">
                      <label class="required" for="start_date">Starting date
                      </label><br>
                      <input type="date" data-date-format="dd/mm/yyyy" id="datepicker" name="member_start_date" class="form-control" required>
                  </div>
                  <!-- End Date -->
                  <div class="form-group">
                      <label class="required" for="end_date">End date
                      </label><br>
                      <input type="date" data-date-format="dd/mm/yyyy" id="datepicker" name="member_end_date" class="form-control" required>
                  </div>


              

                </div>

                
              </div>
              

              <!-- Add button -->
              <div class="row">

                  <div class="col-12 w-100">

                    <button class="btn btn-primary float-right mt-3 mr-2" id="INSRT_BTN" type="submit">Assign members</button>

                  </div>

              </div>
             

            </form> <!-- Form ends -->

          </div> <!-- col-12 ends  -->

        </div> <!-- row ends  -->

      </div> <!-- Modal ends -->

    </div> <!-- modal-content ends -->

  </div> <!-- modal-dialog ends -->

</div> <!-- modal fade ends -->



<!-- Update Project -->
<div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

<div class="modal-dialog modal-lg" role="document">

  <div class="modal-content">

    <!--Modal Header -->

    <div class="modal-header">

      <h4 class="modal-title mt-0 ml-1">Edit</h4>

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

          <form action="<?php echo base_url('projects/update_project'); ?>" id="apply_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">

            <!-- Employee -->

            <div id="request_data">


                  <!-- Status -->
                <div class="form-group">
                      <label class="required" for="status">Status
                      </label>
                      <select class="form-control" name="update_status" id="status" required>
                        <option value="Success">Success</option>
                        <option value="Pending">Pending</option>
                        <option value="Inactive">Inactive</option>
                      </select>
                </div>

            
                <!-- Type -->
                <div class="form-group">
                    <label class="required" for="type">Type
                    </label>
                    <input type="text" class="form-control" name="update_type" id="type" required/>
                </div>
                
                <!-- Budget -->
                <div class="form-group ">
                    <label class="required" for="budget">Budget
                    </label>
                    <input type="text" class="form-control" name="update_budget" id="budget" required/>
                </div>
                <!-- Select member -->
                <div class="form-group mb-3 pb-3">
                   <label class="required " for="member">Select member
                   </label>
                   <select name="update_member[]" id="members2" class="" multiple="multiple" required> 
                       <?php
   
                           if ($DISP_ALL_EMPLOYEES) {
                             foreach ($DISP_ALL_EMPLOYEES as $DISP_ALL_EMPLOYEES_ROW) {
   
                         ?>
                             <option value="<?php echo $DISP_ALL_EMPLOYEES_ROW->id;?>">
                               <?= $DISP_ALL_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_ALL_EMPLOYEES_ROW->col_last_name ?>
                             </option>
                         <?php
   
                           }
   
                           }
   
                           ?>
   
                     </select>
               </div>

                <!-- Description -->
                <div class="form-group pb-2">
                    <label class="required" for="update_description">Description
                    </label>
                    <textarea name="update_description" id="description" cols="10" rows="5" class="form-control"></textarea>
                </div>
                 

                    <!-- Progress -->
           <div class="form-group">
                  <label for="progress">Project progress
                    </label>
                    <input class="form-control" type="range" min="1" max="100" value="1" step="1" name="update_progress" oninput="showRange(this)" required>
                    <span id="update_range">1</span><span>%</span>
              </div>

              

                </div>

            <!-- Imployee Id -->

            <div class="row">

              <div class="col-12 w-100">

                <input type="hidden" name="id" value="<?= $DISP_ALL_DATA_ROW->id ?>">

                <button class="btn btn-primary float-right" id="INSRT_BTN" type="submit">Update</button>

              </div>

            </div>

          </form> <!-- Form ends -->

              </div><!-- Employee Single  ends-->

       

        </div> <!-- col-12 ends  -->

      </div> <!-- row ends  -->

    </div> <!-- Modal ends -->

  </div> <!-- modal-content ends -->

</div> <!-- modal-dialog ends -->

</div> <!-- modal fade ends -->
   
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



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>

<!-- Multiselect -->
<script>
    new MultiSelectTag('members')  // id
</script>
<script>
    new MultiSelectTag('members2')  // id
</script>
<script>
      // Show range value
      function showRange(rangeVal) {
        document.getElementById("update_range").innerHTML = rangeVal.value;
      };
</script>


<!-- Range -->

    <script>
      // Show range value
      function showValue(num) {
        document.getElementById("range").innerHTML = num.value;
      };

     



// update


    $(document).ready(function() {
      // controller urls
      var url_base = '<?= base_url() ?>';
      var url_get_specific_data = '<?= base_url() ?>recruitments/get_specific_data';
      var url_get_table_list = '<?= base_url() ?>recruitments/get_my_specific_data';
      var url_get_empl_data = '<?= base_url() ?>recruitments/get_empl_data';

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



    <script src="component/jquery.min.js.download"></script>

    <script src="https://adminlte.io/themes/v3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js?v=3.2.0"></script>

    <script src="component/demo.js.download"></script>

  </body>
</html>
