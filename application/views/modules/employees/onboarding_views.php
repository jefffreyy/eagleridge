<html>
<?php $this->load->view('templates/css_link'); ?>
<style>

.filter-container {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease-out;
    }

    .filter-container form {
        margin: 0;
    }

    .filter-container.visible {
        max-height: 100px;
        transition: max-height 0.5s ease-in-out;
    }

    @media (max-width: 576px) {
        #search_select .employee_select {
            width: 100% !important;
        }
    }
  .action_btn {
    display: flex !important;
    flex-direction: row !important;
    justify-content: center !important;
    align-items: center !important;
    margin: 0 auto;
    width: 100%;
  }

  .button-title {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
    gap: 4px;
  }

  @media (min-width: 576px) {
    #paginate {
      text-align: right;
      ;
    }
  }
</style>
<?php
$this->load->library('session');

$url_count          = $this->uri->total_segments();
$url_directory      = $this->uri->segment($url_count);
function technos_encrypt($input)
{
  $ciphering = "AES-128-CTR";
  $iv_length = openssl_cipher_iv_length($ciphering);
  $options = 0;
  $encryption_iv = '6234564891013126';
  $encryption_key = "Technos";
  $result_raw = openssl_encrypt($input, $ciphering, $encryption_key, $options, $encryption_iv);
  $result = str_replace("/", "&", $result_raw);
  return $result;
}
?>

<?php
(isset($_GET['branch'])) ? $param_branch = $_GET['branch'] : $param_branch = "";
(isset($_GET['dept'])) ? $param_dept = $_GET['dept'] : $param_dept = "";
(isset($_GET['division'])) ? $param_division = $_GET['division'] : $param_division = "";
(isset($_GET['section'])) ? $param_section = $_GET['section'] : $param_section = "";
(isset($_GET['group'])) ? $param_group = $_GET['group'] : $param_group = "";
(isset($_GET['team'])) ? $param_team = $_GET['team'] : $param_team = "";
(isset($_GET['line'])) ? $param_line = $_GET['line'] : $param_line = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
} else {
    $search = "";
}

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

$id_prefix = 'OBD';
$prev_page         = $current_page - 1;
$next_page         = $current_page + 1;
$last_page_initial = ceil($C_DATA_COUNT / $row);
$last_page         = ($last_page_initial == 0 || $last_page_initial == 1) ? 1 : $last_page_initial;


$filter = $this->input->get('filter');
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
<html>

<body>
  <div class="content-wrapper">
    <div class="container-fluid p-4">
      <div class="row pt-1">
        <div class="col-md-6">
          <h1 class="page-title"><a href="<?= base_url() . 'employees'; ?>"> <img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />

            </a>&nbsp;Onboarding Checklist<h1>
        </div>

          <div class="col-md-6 button-title">
          <a href="<?= base_url('employees/add_onboarding_task') ?>" class=" btn btn-primary shadow-none rounded d-flex align-items-center"><img src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
            &nbsp;Add Onboarding Task</a>
        </div>
      </div>
      <hr>
      

          <div class=" py-3 w-25">
        <p class="p-0 my-1 text-bold">Status</p>
        <select class="form-control leave_status">
          <option value="">All</option>
          <?php foreach ($STATUSES as $status) { ?>
            <option value="<?= $status ?>" <?= $status == $STATUS ? 'selected' : '' ?>><?= $status ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="card border-0 p-0 m-0">
        <div class="card border-0 pT-1 m-0">
          <div class="card-header p-0 border-0">
            <div class="row">
              <div class="col-xl-8">


              </div>

            </div>
          </div>
          

    <div class="filter-container <?= $filter ? 'visible' : '' ?>">
          <div class=" mb-4 d-flex row ">
              <div class="col-md-2" <?php echo ($DISP_VIEW_BRANCH ? "" : "hidden") ?>>
                  <p class="mb-1 text-secondary ">Branch</p>
                  <select name="dept" id="filter_by_branch" class="form-control">
                      <?php
                      if ($DISP_DISTINCT_BRANCH) {
                      ?>
                          <option value="all">All Branches</option>
                          <?php
                          foreach ($DISP_DISTINCT_BRANCH as $DISP_DISTINCT_BRANCH_ROW) {
                              if ($DISP_DISTINCT_BRANCH_ROW->name != '') {
                          ?>
                                  <option value="<?= $DISP_DISTINCT_BRANCH_ROW->id ?>" <?php echo $param_branch == $DISP_DISTINCT_BRANCH_ROW->id ? 'selected' : '' ?>>
                                      <?= $DISP_DISTINCT_BRANCH_ROW->name ?>
                                  </option>
                      <?php
                              }
                          }
                      }
                      ?>
                  </select>
              </div>

          <div class="col-md-2 mx-2 my-2" <?php echo ($DISP_VIEW_DEPARTMENT ? "" : "hidden") ?>>
              <p class="mb-1 text-secondary ">Department</p>
              <select name="dept" id="filter_by_department" class="form-control">
                  <?php
                  if ($DISP_DISTINCT_DEPARTMENT) {
                  ?>
                      <option value="all" <?php foreach ($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW_1) {
                                              if ($DISP_DISTINCT_DEPARTMENT_ROW_1->name == '') {
                                                  echo 'selected';
                                              }
                                          } ?>>All Departments</option>
                      <?php
                      foreach ($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW) {
                          if ($DISP_DISTINCT_DEPARTMENT_ROW->name != '') {
                      ?>
                              <option value="<?= $DISP_DISTINCT_DEPARTMENT_ROW->id ?>" <?php echo $param_dept == $DISP_DISTINCT_DEPARTMENT_ROW->id ? 'selected' : '' ?>>
                                  <?= $DISP_DISTINCT_DEPARTMENT_ROW->name ?>
                              </option>
                  <?php
                          }
                      }
                  }
                  ?>
              </select>
          </div>

          <div class="col-md-2 mx-2 my-2" <?php echo ($DISP_VIEW_DIVISION ? "" : "hidden") ?>>
              <p class="mb-1 text-secondary ">Division</p>
              <select name="dept" id="filter_by_division" class="form-control">
                  <?php
                  if ($DISP_DISTINCT_DIVISION) {
                  ?>
                      <option value="all" <?php foreach ($DISP_DISTINCT_DIVISION as $DISP_DISTINCT_DIVISION_ROW_1) {
                                              if ($DISP_DISTINCT_DIVISION_ROW_1->name == '') {
                                                  echo 'selected';
                                              }
                                          } ?>>All Divisions</option>
                      <?php
                      foreach ($DISP_DISTINCT_DIVISION as $DISP_DISTINCT_DIVISION_ROW) {
                          if ($DISP_DISTINCT_DIVISION_ROW->name != '') {
                      ?>
                              <option value="<?= $DISP_DISTINCT_DIVISION_ROW->id ?>" <?php echo $param_division == $DISP_DISTINCT_DIVISION_ROW->id ? 'selected' : '' ?>>
                                  <?= $DISP_DISTINCT_DIVISION_ROW->name ?>
                              </option>
                  <?php
                          }
                      }
                  }
                  ?>
              </select>
          </div>

          <div class="col-md-2" <?php echo ($DISP_VIEW_SECTION ? "" : "hidden") ?>>
              <p class="mb-1 text-secondary ">Section</p>
              <select name="section" id="filter_by_section" class="form-control">
                  <?php
                  if ($DISP_DISTINCT_SECTION) {
                  ?>
                      <option value="all" <?php foreach ($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW_1) {
                                              if ($DISP_DISTINCT_SECTION_ROW_1->name == '') {
                                                  echo 'selected';
                                              }
                                          } ?>>All Sections</option>
                      <?php
                      foreach ($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW) {
                          if ($DISP_DISTINCT_SECTION_ROW->name != '') {
                      ?>
                              <option value="<?= $DISP_DISTINCT_SECTION_ROW->id ?>" <?php echo $param_section == $DISP_DISTINCT_SECTION_ROW->id ? 'selected' : "" ?>>
                                  <?= $DISP_DISTINCT_SECTION_ROW->name ?>
                              </option>
                  <?php
                          }
                      }
                  }
                  ?>
              </select>
          </div>

          <div class="col-md-2" <?php echo ($DISP_VIEW_GROUP ? "" : "hidden") ?>>
              <p class="mb-1 text-secondary ">Group</p>
              <select name="group" id="filter_by_group" class="form-control">
                  <?php
                  if ($DISP_DISTINCT_GROUP) {
                  ?>
                      <option value="all" <?php foreach ($DISP_DISTINCT_GROUP as $DISP_DISTINCT_GROUP_ROW_1) {
                                              if ($DISP_DISTINCT_GROUP_ROW_1->name == '') {
                                                  echo 'selected';
                                              }
                                          } ?>>All Groups</option>
                      <?php
                      foreach ($DISP_DISTINCT_GROUP as $DISP_DISTINCT_GROUP_ROW) {
                          if ($DISP_DISTINCT_GROUP_ROW->name != '') {
                      ?>
                              <option value="<?= $DISP_DISTINCT_GROUP_ROW->id ?>" <?php echo $param_group == $DISP_DISTINCT_GROUP_ROW->id ? 'selected' : "" ?>>
                                  <?= $DISP_DISTINCT_GROUP_ROW->name ?>
                              </option>
                  <?php
                          }
                      }
                  }
                  ?>
              </select>
          </div>

            <div class="col-md-2" <?php echo ($DISP_VIEW_TEAM ? "" : "hidden") ?>>
                <p class="mb-1 text-secondary ">Team</p>
                <select name="dept" id="filter_by_team" class="form-control">
                    <?php
                    if ($DISP_DISTINCT_TEAM) {
                    ?>
                        <option value="all" <?php foreach ($DISP_DISTINCT_TEAM as $DISP_DISTINCT_TEAM_ROW_1) {
                                                if ($DISP_DISTINCT_TEAM_ROW_1->name == '') {
                                                    echo 'selected';
                                                }
                                            } ?>>All Teams</option>
                        <?php
                        foreach ($DISP_DISTINCT_TEAM as $DISP_DISTINCT_TEAM_ROW) {
                            if ($DISP_DISTINCT_TEAM_ROW->name != '') {
                        ?>
                                <option value="<?= $DISP_DISTINCT_TEAM_ROW->id ?>" <?php echo $param_team == $DISP_DISTINCT_TEAM_ROW->id ? 'selected' : '' ?>>
                                    <?= $DISP_DISTINCT_TEAM_ROW->name ?>
                                </option>
                    <?php
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-2" <?php echo ($DISP_VIEW_LINE ? "" : "hidden") ?>>
                <p class="mb-1 text-secondary ">Line</p>
                <select name="line" id="filter_by_line" class="form-control">
                    <?php
                    if ($DISP_DISTINCT_LINE) {
                    ?>
                        <option value="all" <?php foreach ($DISP_DISTINCT_LINE as $DISP_DISTINCT_LINE_ROW_1) {
                                                if ($DISP_DISTINCT_LINE_ROW_1->name == '') {
                                                    echo 'selected';
                                                }
                                            } ?>>All Lines</option>
                        <?php
                        foreach ($DISP_DISTINCT_LINE as $DISP_DISTINCT_LINE_ROW) {
                            if ($DISP_DISTINCT_LINE_ROW->name != '') {
                        ?>
                                <option value="<?= $DISP_DISTINCT_LINE_ROW->id ?>" <?php echo $param_line == $DISP_DISTINCT_LINE_ROW->id ? 'selected' : '' ?>><?= $DISP_DISTINCT_LINE_ROW->name ?></option>
                    <?php
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>

<div class="card border-0 p-0 m-0">
  <div class="card border-0 p-0 m-0">
      <div class="p-2">
      <div class="">
          <div class="justify-content-between">
              <div class="row">
                  <div class="col-md-12 col-lg-12">
                      <div class="d-flex row justify-content-between align-items-center">
                          <div class=" row d-flex justify-content-center justify-content-lg-start col-12 col-lg-5 mx-1">

                              <p class="col-md-12 mb-1 text-secondary">Search Employee</p>

                              <select id="search_select" class="px-1 col-12 col-lg-6  employee_select form-control w-100 w-lg-50">
                                  <?php
                                  if ($DISP_EMP_LIST_SEARCH) {
                                  ?>
                                      <option value="all" <?php foreach ($DISP_EMP_LIST_SEARCH as $DISP_EMP_LIST_SEARCH_ROW_1) {
                                                              if ($DISP_EMP_LIST_SEARCH_ROW_1->name == '') {
                                                                  echo 'selected';
                                                              }
                                                          } ?>>All </option>
                                      <?php
                                      foreach ($DISP_EMP_LIST_SEARCH as $DISP_EMP_LIST_SEARCH_ROW) {
                                          if ($DISP_EMP_LIST_SEARCH_ROW->name != '') {
                                      ?>
                                              <option value="<?= $DISP_EMP_LIST_SEARCH_ROW->id ?>" <?php echo $search == $DISP_EMP_LIST_SEARCH_ROW->id ? 'selected' : '' ?>>
                                                  <?= $DISP_EMP_LIST_SEARCH_ROW->name ?>
                                              </option>
                                  <?php
                                          }
                                      }
                                  }
                                  ?>
                              </select>
                      <button id="btnFilter" class="btn btn-primary shadow-none rounded ml-1" onclick="toggleFilter()"><img src="<?= base_url('assets_system/icons/advance_filter.svg') ?>" style="margin-bottom: 2px" alt="">&nbsp;Advance Filter</button>
                      <a href="<?= base_url('employees/onboarding') ?>" id="btn_clear_filter" class="btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="">&nbsp;Clear</a>
                  </div>
              </div>
             
            
            <div class="row align-items-center py-2">
            <div class="d-none d-lg-flex col-sm-7 col-md-10 col-lg-10 justify-content-lg-end justify-content-center my-lg-0 my-2">
                <div class=" d-flex align-items-center  row">
                  <div class="d-inline col-12 col-lg-6">

                    <p class="p-0 m-0 mx-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                  </div>
                  <div class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-end">
                    <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">
                      <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
                          < </a>
                      </li>
                      <li><a href="?status=<?= $STATUS ?>&page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                      <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                      <li><a href="?status=<?= $STATUS ?>&page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                      <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                      <li><a href="?status=<?= $STATUS ?>&page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                      <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                      <li><a href="?status=<?= $STATUS ?>&page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                      <li><a <?php if ($current_page < $last_page)   echo "href='?status=$STATUS&page=$next_page&row=$row'"; ?>>> </a></li>
                    </ul>
                  </div>


                </div>

              </div>
              <div class="col-12 col-lg-2 d-none d-lg-flex  justify-content-center align-items-center">
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

            <table class="table table-bordered m-0" id="table_main" style="width:100%">
              <thead>

                <th class="text-center" style="width:5%" hidden><input type="checkbox" name="check_all" id="check_all">
                </th>
                <th style='width:10%;'>ID</th>
                <th style='width:10%;'>DATE</th>
                <th style='width:10%;text-align: center;'>EMPLOYEE</th>
                <th style='width:10%;text-align: center;'>TASK NAME</th>
                <th style='width:10%;text-align: center;'>PERSON IN CHARGE</th>
                <th style='width:10%;text-align: center;'>STATUS</th>
                <th style="width:10%" class="text-center">ACTION</th>
              </thead>
              <tbody id="tbl_application_container">
                <?php if ($TABLE_DATA) {  ?>
                  <?php foreach ($TABLE_DATA as $row_data) { ?>
                    <tr data-id="<?= $row_data->id ?>" data-toggle="modal" data-target="#modal_approval">
                      <td><?= $id_prefix . str_pad($row_data->id, 5, '0', STR_PAD_LEFT) ?></td>
                      <td><?= date_format(date_create($row_data->date), 'd/m/Y') ?></td>
                      <td class="text-left"><?= $row_data->employee ?></td>
                      <td><?= $row_data->task_name ?></td>
                      <td><?= $row_data->person_in_charge ?></td>
                      <!-- <td><?= $row_data->status ?></td> -->
                      <!-- <td><?= $row_data->action ?></td> -->
                      <td class="text-center">
                        <?php
                        if ($row_data->status == "Partial") { ?>
                          <div class=' bg-warning p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?></div>

                        <?php } elseif ($row_data->status == "Not Yet Started") { ?>
                          <div class='bg-secondary  p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?></div>

                        <?php } elseif ($row_data->status == "Completed") { ?>
                          <div class='bg-success p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?></div>

                        <?php } elseif ($row_data->status == "Cancelled") { ?>
                          <div class='bg-danger p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?></div>

                        <?php } else { ?>
                          <div class='bg-secondary p-2 rounded disabled m-auto' style="width:100px">Not Yet Started</div>
                        <?php } ?>
                      </td>

                      <td class="text-center">
                        <a href="<?= base_url() . 'employees/edit_onboarding_task/'.$row_data->id; ?>"> 
                           <img src="<?= base_url('assets_system/icons/pen-to-square-solid.svg') ?>" alt="">
                        </a>
                        <?php if ($row_data->status == 'Pending 1' || $row_data->status == 'Pending 2' || $row_data->status == 'Pending 3') : ?>
                        <?php endif ?>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } else { ?>
                  <tr class="table-active">
                    <td colspan="10">
                      <center>No Records Yet</center>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="p-2 d-block d-lg-none">
            <div class="row align-items-center py-1">

              <!-- <button id="btn_application"    class=" btn technos-button-gray shadow-none rounded" data-toggle="modal" data-target="#modal_insert"  ><i class="far fa-trash-alt"></i>&nbsp;Delete</button> -->


              <div id="paginated" class=" d-flex col-sm-9 col-md-10 col-lg-11 justify-content-lg-end justify-content-center my-lg-0 my-2">
                <div class=" d-flex align-items-center  row">
                  <div class="d-inline col-12 col-lg-6">
                    <p class="p-0 m-0 mx-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                  </div>
                  <div class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-end">
                    <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">
                      <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
                          < </a>
                      </li>
                      <li><a href="?status=<?= $STATUS ?>&page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                      <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                      <li><a href="?status=<?= $STATUS ?>&page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                      <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                      <li><a href="?status=<?= $STATUS ?>&page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                      <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                      <li><a href="?status=<?= $STATUS ?>&page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                      <li><a <?php if ($current_page < $last_page)   echo "href='?status=$STATUS&page=$next_page&row=$row'"; ?>>> </a></li>
                    </ul>
                  </div>


                </div>

              </div>
              <div class=" col-sm-3 col-md-2 col-lg-1  d-flex align-items-center  justify-content-center justify-content-lg-start mr-lg-0 mr-2">
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




  <?php $this->load->view('templates/jquery_link'); ?>

  <?php
    if ($this->session->userdata('SUCC')) {
?>
        <script>
            $(document).Toasts('create', {
                class: 'bg-success toast_width',
                title: 'Success',
                subtitle: 'close',
                body: '<?php echo $this->session->userdata('SUCC'); ?>'
            })
        </script>
<?php
        $this->session->unset_userdata('SUCC');
    }
?>

    <script>
        $(document).ready(function() {
            $('#search_select').select2();
            $("#search_select").on("change", function() {
                search();
            });
        });

        function search() {
            let search_select = $("#search_select").find(":selected").val();
            console.log('search_select', search_select);
            if (!search_select) return;
            if (search_select == 'all') {
                filter_clear();
            } else {
                if (document.querySelector('.filter-container').classList.contains('visible')) {
                    window.location.href = "?search=" + search_select.replace(/\s/g, '_') + '&filter=1';
                } else {
                    window.location.href = "?search=" + search_select.replace(/\s/g, '_');
                }

            }
        }

        function filter_clear() {
            document.location.href = "onboarding";
        }
    </script>

        
    <script>
        var url = '<?= base_url() ?>';
        var dispEmpList = <?php echo json_encode($DISP_EMP_LIST); ?>;
        let data = [];
        let dataCopy = [];
        if (dispEmpList && dispEmpList.length > 0) {
            data = dispEmpList;
            dataCopy = JSON.parse(JSON.stringify(dispEmpList));

        }
        </script>

    <script>
        var url = '<?= base_url() ?>';
        var dispEmpList = <?php echo json_encode($DISP_EMP_LIST); ?>;
        let data = [];
        let dataCopy = [];
        if (dispEmpList && dispEmpList.length > 0) {
            data = dispEmpList;
            dataCopy = JSON.parse(JSON.stringify(dispEmpList));

        }
        console.log('dispEmpList', dispEmpList);
        var colHeaders = ['Id', 'Employee', 'Assignment'];
        var numColumns = colHeaders.length;
        const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.whiteSpace = 'nowrap';
            td.style.overflow = 'hidden';
        };
      
    
            console.log('messageError', messageError);
            if (messageError) {
                $(document).Toasts('create', {
                    class: 'bg-warning toast_width',
                    title: 'Warning!',
                    subtitle: 'close',
                    body: messageError
                });
                return;
            }
            console.log('changes', changes);
            if (changes.length < 1) {
                $(document).Toasts('create', {
                    class: 'bg-warning toast_width',
                    title: 'Warning!',
                    subtitle: 'close',
                    body: 'No Changes'
                });
                return;
            }
            fetch(url + 'employees/update_onboarding_task', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    console.log(result);

                });

 
    </script>

    <script>
        $(document).ready(function() {

            $('#filter_by_branch').select2();
            $('#filter_by_department').select2();
            $('#filter_by_division').select2();
            $('#filter_by_section').select2();
            $('#filter_by_group').select2();
            $('#filter_by_team').select2();
            $('#filter_by_line').select2();

            var base_url = '<?= base_url(); ?>';

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

            $("#filter_by_branch").on("change", function() {
                filter_data();
            })
            $("#filter_by_department").on("change", function() {
                filter_data();
            })
            $("#filter_by_division").on("change", function() {
                filter_data();
            })
            $("#filter_by_section").on("change", function() {
                filter_data();
            })
            $('#filter_by_group').on("change", function() {
                filter_data();
            })
            $("#filter_by_team").on("change", function() {
                filter_data();
            })
            $("#filter_by_line").on("change", function() {
                filter_data();
            })

            $("#filter_by_status").on("change", function() {
                filter_data();
            })

            function filter_data(page_row) {
                
                if (page_row == null || page_row == "") {
                    page_row = '?page=' + "<?= $current_page ?>" + '&row=' + "<?= $row ?>"
                        }

            let branch = $("#filter_by_branch").find(":selected").val();
            let department = $("#filter_by_department").find(":selected").val();
            let division = $("#filter_by_division").find(":selected").val();
            let section = $("#filter_by_section").find(":selected").val();
            let group = $("#filter_by_group").find(":selected").val();
            let team = $("#filter_by_team").find(":selected").val();
            let line = $("#filter_by_line").find(":selected").val();

            filterUrl = page_row + "&branch=" + branch + "&dept=" + department + "&division=" + division + "&section=" + section + "&group=" + group + "&team=" + team + "&line=" + line;

            if (document.querySelector('.filter-container').classList.contains('visible')) {
                filterUrl = filterUrl + '&filter=1';
            }

            // Check if only one employee is selected
            let selectedEmployees = $('#search_select').val();
            if (selectedEmployees && selectedEmployees.length === 1) {
                // Show no data when only one employee is selected
                filterUrl = base_url + "employees/onboarding?search=" + selectedEmployees[0].replace(/\s/g, '_');
            }

            window.location = filterUrl;
        }

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

        })
    </script>

<script>
   $('.leave_status,#row_dropdown').on('change', function() {
        reloadPage();
      })

      function reloadPage() {
        var status = $('.leave_status').val();
        var row = $('#row_dropdown').val();
        var page = "<?= $PAGE ?>";
        window.location.href = "<?= base_url('employees/onboarding') ?>" + "?status=" + status + "&page=" + page + "&row=" + row;
      }
  </script>

    <script>
        function toggleFilter() {
            document.querySelector('.filter-container').classList.toggle('visible');
        }
    </script>

</body>

</html>