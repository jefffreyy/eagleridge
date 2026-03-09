<html>
<?php $this->load->view('templates/css_link'); ?>
<?php
    $search_data = $this->input->get('all');
    $search_data = str_replace("_", " ", $search_data);

    $current_page=$PAGE;
    $next_page=$PAGE+1;
    $prev_page=$PAGE-1;
    $last_page=$PAGES_COUNT;
    $row=$ROW;
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
<style>
    .active-page{
    background-color:#007bff !important;
    color:white !important;
    cursor:'default';
    }
    .img-circle_sm{
        border-radius: 50% !important;
        width:30px !important;
        height:30px !important;
        object-fit: scale-down;
        background-color: #fff;
    }
</style>
<body>
    <!-- Content Starts -->
    <div class="content-wrapper ">
        <div class="container-fluid p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url() ?>administrators">Administrator</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Access Management
            </li>
            </ol>
        </nav>
            <div class="row">
                <!-- Title Text -->
                <div class="col-md-6">
                    <h1 class="page-title">Access Management<h1>
                </div>
                <!-- Title Button -->
                <div class="col-md-6  button-title">
                    <!-- <a href = "<?= base_url() ?>employees/new_employee" type ="button" class = "btn btn-primary shadow-none"><i class="fas fa-plus"></i> Add Employee</a> -->
                    <a href="#" id="save_user_access"  class="btn btn-primary shadow-none">Save Changes</a>
                </div>
            </div>
            <!-- Title Header Line -->
            <hr>
            <div class="row mb-1">
                <!-- <div class="col-md-4">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1" style="background-color: white;"><i class="fas fa-search"></i></span>
                        </div>
                        
                        <input type="text" class="form-control" placeholder="Search by name, email or phone number" id="filter_employee" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div> -->
                
            </div>
            <div class="card border-0 mt-1" style="padding: 0px; margin: 0px">
                <div class="p-1">
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
            <div class="">

                <div class='row justify-content-between mb-1'>
                    <div class="col-md-4">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link head-tab <?= $TAB=='Active'?'active' :'' ?> " id="tab-Active" style='cursor:pointer'>Active<span class="ml-2 badge badge-pill badge-secondary"><?=$ACTIVES?></span></a>
                            </li>
                                                                <li class="nav-item">
                                <a class="nav-link head-tab <?= $TAB=='Inactive'?'active' :'' ?>"  id="tab-Inactive" style='cursor:pointer' >Inactive<span class="ml-2 badge badge-pill badge-secondary"><?=$INACTIVES?></span></a>
                            </li>               
                        </ul>
                    </div>
                    <div class='col'>
                        <div class='float-right pr-2'>
                            <ul class="d-inline pagination m-0 p-0 ">
                            <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB&all=$ALL'"; ?>>
                                                < </a>
                                        </li>
                                        <li><a href="?page=1&row=<?= $row ?>&tab=<?=$TAB?>&all=<?=$ALL?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                                        <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                                        <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&tab=<?=$TAB?>&all=<?=$ALL?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                                        <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                                        <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&tab=<?=$TAB?>&all=<?=$ALL?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                                        <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                                        <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&tab=<?=$TAB?>&all=<?=$ALL?>" <?php if ($current_page == $last_page||$last_page<=0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                                        <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row&tab=$TAB&all=$ALL'"; ?>>> </a></li>
                            </ul>
                            <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                            <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                            <select id="row_dropdown" class="custom-select m-0" style="width: auto;">
                                <option value="10" <?= $ROW==10? 'selected' :'' ?> > 10 </option>
                                <option value="25" <?= $ROW==25? 'selected' :'' ?> > 25 </option>
                                <option value="50" <?= $ROW==50? 'selected' :'' ?>> 50 </option>
                                <option value="100" <?= $ROW==100? 'selected' :'' ?>> 100 </option>
                            </select>
                        </div>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-hover" id="employee_tbl">
                                <thead>
                                    <!-- Table Headers -->
                                    <th >Employee&nbsp;Id</th>
                                    <th style='min-width:200px'>Full&nbsp;Name</th>
                                    <th>Position</th>
                                    <th>User&nbsp;Access</th>
                                    <th>Remote&nbsp;Attendance</th>
                                    <th>Status</th>
                                    <th>Accessibility Status </th>
                                    <th class="text-center">Action</th>
                                </thead>
                                <tbody id="table_container">
                                    <?php
                                    if ($C_USERS) {
                                        foreach ($C_USERS as $C_USERS_ROW) {
                                            if (!empty($C_USERS_ROW->col_midl_name)) {
                                                $midl_ini = $C_USERS_ROW->col_midl_name[0] . '.';
                                            } else {
                                                $midl_ini = '';
                                            } ?>
                                            <tr class="empl_row" empl_id="<?= $C_USERS_ROW->id ?>" reset_pass="<?= ucwords($C_USERS_ROW->col_last_name).'.'.date('Y', strtotime($C_USERS_ROW->col_birt_date)) ?>">
                                                <td><?= $C_USERS_ROW->col_empl_cmid ?></td>
                                                <td><a href="<?= base_url() ?>employees/personal?id=<?= $C_USERS_ROW->id ?>">
                                                        <img class="rounded-circle avatar img-circle_sm elevation-2"  src="<?php if ($C_USERS_ROW->col_imag_path) {
                                                                                                                            echo base_url() . 'assets_user/user_profile/' . $C_USERS_ROW->col_imag_path;
                                                                                                                        } else {
                                                                                                                            echo base_url() . 'assets_system/images/default_user.jpg';
                                                                                                                        } ?>">&nbsp;&nbsp;<?= $C_USERS_ROW->col_last_name . ', ' . $C_USERS_ROW->col_frst_name . ' ' . $midl_ini ?></a>
                                                </td>
                                                <td><?= convert_id2name($C_POSITIONS,$C_USERS_ROW->col_empl_posi) ?></td>
                                                <td>
                                                    <select name="user_access" id="user_access" class="form-control">
                                                    <?php foreach($C_USER_ACCESS as $C_USER_ACCESS_ROW) { ?>
                                                        <option value="<?=$C_USER_ACCESS_ROW->id?>" <?php echo $C_USERS_ROW->col_user_access==$C_USER_ACCESS_ROW->id?'selected':""?>>
                                                        <?=$C_USER_ACCESS_ROW->user_access?></option>
                                                    <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="remote_attendance" id="remote_attendance" class="form-control">
                                                        <option value="0" <?php if ($C_USERS_ROW->remote_att == 0) {
                                                                                echo 'selected';
                                                                            } ?>>Disabled</option>
                                                        <option value="1" <?php if ($C_USERS_ROW->remote_att == 1) {
                                                                                echo 'selected';
                                                                            } ?>>Enabled</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="user_status" id="user_status" class="form-control "> <!-- user_status -->
                                                            <option value="1" <?php if ($C_USERS_ROW->disabled == 1) {
                                                                                    echo 'selected';
                                                                                } ?>>Inactive</option>
                                                            <option value="0" <?php if ($C_USERS_ROW->disabled == 0) {
                                                                                    echo 'selected';
                                                                                } ?>>Active</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <?=$C_USERS_ROW->password_attempt>=10 ?"<p class='text-danger text-md'>Locked</p>": "<p class='text-success text-md'>Good</p>" ?>
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn-sm btn-primary  btn_reset_pass text-light" style='cursor:pointer' id="reset_password">Reset Password</a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else { ?>
                                        <!-- Message if no entries -->
                                        <tr class="table-active">
                                            <td colspan="9">
                                                <center>No Employee Yet</center>
                                            </td>
                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <aside class="control-sidebar control-sidebar-dark"></aside>
    <!-- Resign/Terminate Employee Modal -->
    <div class="modal fade" id="modal_show_termination_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Termination Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <p class="mb-0" id="termination_date"></p>
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <p class="mb-0" id="termination_type"></p>
                            </div>
                            <div class="form-group">
                                <label>Reason</label>
                                <p class="mb-0" id="termination_reason"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class='btn btn-primary text-light' data-dismiss="modal" aria-label="Close">&nbsp; Remove</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->
    <?php $this->load->view('templates/jquery_link'); ?>
    <?php
    if ($this->session->userdata('SESS_SUCC_INSRT')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_INSRT'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_INSRT');
    }
    ?>
    <?php
    if ($this->session->userdata('SESS_ERR_IMAGE')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_ERR_IMAGE'); ?>',
                '',
                'warning'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_ERR_IMAGE');
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
    if ($this->session->userdata('SESS_WARN_MSG_INSRT_CSV')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_WARN_MSG_INSRT_CSV'); ?>',
                '',
                'warning'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_WARN_MSG_INSRT_CSV');
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
    <?php function convert_id2name($array,$pos){
        $name = "";
        foreach($array as $e){
            if($e->id == $pos){
                $name = $e->name;
            }
        }
        if($name == ""){
            $name = "error: can't be found";
        }
        return $name;
        }
    ?>
    <script>
        $(document).ready(function() {
            $('a.page-link').on('click',function(){
                  paginate($(this).text());
              })
            $("#prev-page").on('click',function(){
              let activePage=$('a.active-page').text();
              if(parseInt(activePage)>1){
                  paginate(parseInt(activePage)-1);
              }
            })
            $("#next-page").on('click',function(){
              let maxPage=<?=$PAGES_COUNT-1?>;
              let activePage=$('a.active-page').text();
              if(parseInt(activePage)<parseInt(maxPage) && parseInt(maxPage)>1  ){
                let nextPage      =parseInt(activePage)+1;
                paginate(nextPage);
              }
            })
            $('#tab-Inactive').on('click',function(){
                 let row = $("#row_dropdown").val();
                window.location="<?=base_url()?>administrators/access?"+"page="+1+"&row="+row+'&tab=Inactive&all=<?=$ALL?>';
            })
            $('#tab-Active').on('click',function(){
                 let row = $("#row_dropdown").val();
                window.location="<?=base_url()?>administrators/access?"+"page="+1+"&row="+row+'&tab=Active&all=<?=$ALL?>';
            })
            $('#row_dropdown').on("change",function(){
                let row = $("#row_dropdown").val();
                window.location="<?=base_url()?>administrators/access?"+"page="+1+"&row="+row+'&tab=<?=$TAB?>&all=<?=$ALL?>';
              })
            function paginate(page="<?=$PAGE?>"){
                let row           = $("#row_dropdown").val();
                window.location="<?=base_url()?>administrators/access?"+"page="+page+"&row="+row;
            }
            var base_url = '<?= base_url() ?>';
            var department;
            var section;
            var group;
            var line;
            var status;
            var department_arr;
            var section_arr;
            var group_arr;
            var line_arr;
            var url_reset_empl_password = '<?= base_url() ?>administrators/reset_empl_password';
            var url_update_empl_user_access = '<?= base_url() ?>administrators/update_empl_user_access';
            var url_get_filter_data = '<?= base_url() ?>employees/get_filter_data';
            var url_get_filter_data_department = '<?= base_url() ?>employees/get_filter_data_department';
            var url_get_filter_data_section = '<?= base_url() ?>employees/get_filter_data_section';
            var url_get_filter_data_group = '<?= base_url() ?>employees/get_filter_data_group';
            var url_get_filter_data_line = '<?= base_url() ?>employees/get_filter_data_line';
            var url_get_all_filter_data = '<?= base_url() ?>employees/get_all_filter_data';
            var url_filter_by_department = '<?= base_url() ?>attendance/get_employee_data_filter_by_dept';
            var url_filter_section_by_department = '<?= base_url() ?>attendance/get_employee_section_data_filter_by_dept';
            var url_filter_by_section = '<?= base_url() ?>attendance/get_employee_data_filter_by_sect';
            var url_get_all_empl_data = '<?= base_url() ?>employees/get_all_employee_data';
            var url_filter_by_group = '<?= base_url() ?>attendance/get_employee_data_filter_by_group';
            var url_filter_by_line = '<?= base_url() ?>attendance/get_employee_data_filter_by_line';
            var url_filter_by_status = '<?= base_url() ?>attendance/get_employee_data_filter_by_status';
            $(".user_status").on("change",function(){
                let value=$(this).val();
                console.log(value);
                window.location = '<?=base_url()?>administrators/user_activation/'+value;
            })
            
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                "formatted-num-pre": function(a) {
                    a = (a === "-" || a === "") ? 0 : a.replace(/[^\d\-\.]/g, "");
                    return parseFloat(a);
                },
                "formatted-num-asc": function(a, b) {
                    return a - b;
                },
                "formatted-num-desc": function(a, b) {
                    return b - a;
                }
            });
            // var empl_tbl = $('#employee_tbl').DataTable({
            //     "paging": false,
            //     "searching": true,
            //     "ordering": true,
            //     "autoWidth": false,
            //     "info": true,
            //     columnDefs: [{
            //         type: 'formatted-num',
            //         targets: 0
            //     }]
            // })

            $('#employee_tbl_filter').parent().parent().hide();
            $('#employee_tbl_info').parent().parent().hide();

            $('#filter_employee').on('keyup', function() {
                empl_tbl.search(this.value).draw();
            });



            // $("#search_btn").on("click", function() {
            //    search_action();
            // })
            // $('#search_data').on("keydown", function(e) {
            //       const ENTER_KEY_CODE = 13;
            //       const ENTER_KEY = "Enter";
            //       var code = e.keyCode || e.which;
            //       var key = e.key;
            //       if (code == ENTER_KEY_CODE || key == ENTER_KEY) {
            //         search_action();
            //       }
            //     });
            // function search_action(){
            //     $('#search_data').val();
            //     var optionValue = $('#search_data').val();
            //     var url = window.location.href.split("?")[0];
            //     if (window.location.href.indexOf("?") > 0) {
            //         window.location = url + "?page=1&row=<?=$row?>&tab=<?=$TAB?>&all=" + optionValue.replace(/\s/g, '_');
            //     } else {
            //         window.location = url + "?page=1&row=<?=$row?>&tab=<?=$TAB?>&all=" + optionValue.replace(/\s/g, '_');
            //     }
            // }

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
                window.location = url + "?page=1&row=<?= $row ?>&tab=<?= $TAB ?>&all=" + optionValue.replace(/\s/g, '_');
                } else {
                window.location = url + "?page=1&row=<?= $row ?>&tab=<?= $TAB ?>&all=" + optionValue.replace(/\s/g, '_');
                }
            }


            function display_filtered_empl(department, section, line, group, status) {
                $('#loader_gif').show();
                // change employee dropdown
                $('#table_container').html('');
                get_filter_data(url_get_filter_data, department, line, group, section, status).then(function(data) {
                    if (data.length > 0) {
                        Array.from(data).forEach(function(x) {
                            var staffIsSelected = '';
                            var HRIsSelected = '';
                            var AccountingIsSelected = '';
                            var AdminIsSelected = '';
                            var IsRemote = '';
                            var user_image = '';
                            if (x.col_imag_path) {
                                user_image = base_url + 'user_images/' + x.col_imag_path;
                            } else {
                                user_image = base_url + 'user_images/default_profile_img3.png';
                            }
                            var fullname = '';
                            if ((x.col_frst_name) && (x.col_last_name)) {
                                if (x.col_midl_name) {
                                    var middlename = capitalizeFirstLetter(x.col_midl_name);
                                    fullname = x.col_last_name + ', ' + x.col_frst_name + ' ' + middlename + '.';
                                } else {
                                    fullname = x.col_last_name + ', ' + x.col_frst_name;
                                }
                            }
                            $('#loader_gif').hide();
                            if (x.col_user_access == 0) {
                                staffIsSelected = 'selected';
                            } else if (x.col_user_access == 2) {
                                HRIsSelected = 'selected';
                            } else if (x.col_user_access == 3) {
                                AccountingIsSelected = 'selected';
                            } else if (x.col_user_access == 4) {
                                AdminIsSelected = 'selected';
                            }
                            if (x.remote_att == 1) {
                                IsRemote = 'selected';
                            }
                            $('#table_container').append(`
                                <tr class="empl_row" empl_id="` + x.id + `">
                                    <td>` + x.col_empl_cmid + `</td>
                                    <td><a href = "<?= base_url() ?>employees/personal?id=` + x.id + `">
                                        <img class="rounded-circle avatar " width="35" height="35" src="` + user_image + `">&nbsp;&nbsp;` + fullname + `</a>
                                    </td>
                                    <td>` + x.col_empl_posi + `</td>
                                    <td>
                                        <select name="user_access" id="user_access" class="form-control">
                                            <option value="0" ` + staffIsSelected + `>STAFF</option>
                                            <option value="2" ` + HRIsSelected + `>HR</option>
                                            <option value="3" ` + AccountingIsSelected + `>ACCOUNTING</option>
                                            <option value="4" ` + AdminIsSelected + `>ADMIN</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="user_access" id="user_access" class="form-control">
                                            <option value="0">Disabled</option>
                                            <option value="1" ` + IsRemote + `>Enabled</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-primary btn_reset_pass">Reset Password</a>
                                    </td>
                                </tr>
                            `);
                        })
                    } else {
                        $('#loader_gif').hide();
                        $('#table_container').append(`
                                <td colspan="7">No Employees Detected</td>
                        `);
                    }
                })
            }
            // ======================= FILTER BY DEPARTMENT ================================
            $('#filter_by_department').change(function() {
                department = $(this).val();
                section = $('#filter_by_section').val();
                line = $('#filter_by_line').val();
                group = $('#filter_by_group').val();
                status = $('#filter_by_status').val();
                display_filtered_empl(department, section, line, group, 0);
                get_filter_data(url_get_filter_data_section, department, line, group, section, 0).then(function(data) {
                    if (!section) {
                        $('#filter_by_section').html('');
                        $('#filter_by_section').append(`<option value="">All Sections</option>`);
                    }
                    Array.from(data).forEach(function(x) {
                        if (x.col_empl_sect != '') {
                            $('#filter_by_section').append(`
                                <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_group, department, line, group, section, 0).then(function(data) {
                    if (!group) {
                        $('#filter_by_group').html('');
                        $('#filter_by_group').append(`<option value="">All Groups</option>`);
                    }
                    Array.from(data).forEach(function(x) {
                        if (x.col_empl_group != '') {
                            $('#filter_by_group').append(`
                                <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_line, department, line, group, section, 0).then(function(data) {
                    if (!line) {
                        $('#filter_by_line').html('');
                        $('#filter_by_line').append(`<option value="">All Lines</option>`);
                    }
                    Array.from(data).forEach(function(x) {
                        if (x.col_empl_line != '') {
                            $('#filter_by_line').append(`
                                <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                            `);
                        }
                    })
                })
            })
            // ======================= FILTER BY SECTION ================================
            $('#filter_by_section').change(function() {
                department = $('#filter_by_department').val();
                section = $(this).val();
                line = $('#filter_by_line').val();
                group = $('#filter_by_group').val();
                status = $('#filter_by_status').val();
                display_filtered_empl(department, section, line, group, 0);
                get_filter_data(url_get_filter_data_department, department, line, group, section, 0).then(function(data) {
                    if (!department) {
                        $('#filter_by_department').html('');
                        $('#filter_by_department').append(`<option value="">All Departments</option>`);
                    }
                    Array.from(data).forEach(function(x) {
                        if (x.col_empl_dept != '') {
                            $('#filter_by_department').append(`
                                <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_group, department, line, group, section, 0).then(function(data) {
                    if (!group) {
                        $('#filter_by_group').html('');
                        $('#filter_by_group').append(`<option value="">All Groups</option>`);
                    }
                    Array.from(data).forEach(function(x) {
                        if (x.col_empl_group != '') {
                            $('#filter_by_group').append(`
                                <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_line, department, line, group, section, 0).then(function(data) {
                    if (!line) {
                        $('#filter_by_line').html('');
                        $('#filter_by_line').append(`<option value="">All Lines</option>`);
                    }
                    Array.from(data).forEach(function(x) {
                        if (x.col_empl_line != '') {
                            $('#filter_by_line').append(`
                                <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                            `);
                        }
                    })
                })
            })
            // ======================= FILTER BY GROUP ================================
            $('#filter_by_group').change(function() {
                department = $('#filter_by_department').val();
                section = $('#filter_by_section').val();
                line = $('#filter_by_line').val();
                group = $(this).val();
                status = $('#filter_by_status').val();
                display_filtered_empl(department, section, line, group, 0);
                get_filter_data(url_get_filter_data_department, department, line, group, section, 0).then(function(data) {
                    if (!department) {
                        $('#filter_by_department').html('');
                        $('#filter_by_department').append(`<option value="">All Departments</option>`);
                    }
                    Array.from(data).forEach(function(x) {
                        if (x.col_empl_dept != '') {
                            $('#filter_by_department').append(`
                                <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_section, department, line, group, section, 0).then(function(data) {
                    if (!section) {
                        $('#filter_by_section').html('');
                        $('#filter_by_section').append(`<option value="">All Sections</option>`);
                    }
                    Array.from(data).forEach(function(x) {
                        if (x.col_empl_sect != '') {
                            $('#filter_by_section').append(`
                                <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_line, department, line, group, section, 0).then(function(data) {
                    if (!line) {
                        $('#filter_by_line').html('');
                        $('#filter_by_line').append(`<option value="">All Lines</option>`);
                    }
                    Array.from(data).forEach(function(x) {
                        if (x.col_empl_line != '') {
                            $('#filter_by_line').append(`
                                <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                            `);
                        }
                    })
                })
            })
            // ======================= FILTER BY LINE ================================
            $('#filter_by_line').change(function() {
                department = $('#filter_by_department').val();
                section = $('#filter_by_section').val();
                line = $(this).val();
                group = $('#filter_by_group').val();
                status = $('#filter_by_status').val();
                display_filtered_empl(department, section, line, group, 0);
                get_filter_data(url_get_filter_data_department, department, line, group, section, 0).then(function(data) {
                    if (!department) {
                        $('#filter_by_department').html('');
                        $('#filter_by_department').append(`<option value="">All Departments</option>`);
                    }
                    Array.from(data).forEach(function(x) {
                        if (x.col_empl_dept != '') {
                            $('#filter_by_department').append(`
                                <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_section, department, line, group, section, 0).then(function(data) {
                    if (!section) {
                        $('#filter_by_section').html('');
                        $('#filter_by_section').append(`<option value="">All Sections</option>`);
                    }
                    Array.from(data).forEach(function(x) {
                        if (x.col_empl_sect != '') {
                            $('#filter_by_section').append(`
                                <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_group, department, line, group, section, 0).then(function(data) {
                    if (!group) {
                        $('#filter_by_group').html('');
                        $('#filter_by_group').append(`<option value="">All Groups</option>`);
                    }
                    Array.from(data).forEach(function(x) {
                        if (x.col_empl_group != '') {
                            $('#filter_by_group').append(`
                                <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                            `);
                        }
                    })
                })
            })
            // ================================ CLEAR FILTER ==================================
            $('#btn_clear_filter').click(function() {
                $('#loader_gif').show();
                $('#filter_by_group').val('');
                $('#filter_by_section').val('');
                $('#filter_by_department').val('');
                $('#filter_by_line').val('');
                $('#table_container').html('');
                get_all_employee_data(url_get_all_empl_data).then(function(data) {
                    Array.from(data).forEach(function(x) {
                        var staffIsSelected = '';
                        var HRIsSelected = '';
                        var AccountingIsSelected = '';
                        var AdminIsSelected = '';
                        var IsRemote = '';
                        var user_image = '';
                        if (x.col_imag_path) {
                            user_image = base_url + 'user_images/' + x.col_imag_path;
                        } else {
                            user_image = base_url + 'user_images/default_profile_img3.png';
                        }
                        var fullname = '';
                        if ((x.col_frst_name) && (x.col_last_name)) {
                            if (x.col_midl_name) {
                                var middlename = capitalizeFirstLetter(x.col_midl_name);
                                fullname = x.col_last_name + ', ' + x.col_frst_name + ' ' + middlename + '.';
                            } else {
                                fullname = x.col_last_name + ', ' + x.col_frst_name;
                            }
                        }
                        $('#loader_gif').hide();
                        if (x.col_user_access == 0) {
                            staffIsSelected = 'selected';
                        } else if (x.col_user_access == 2) {
                            HRIsSelected = 'selected';
                        } else if (x.col_user_access == 3) {
                            AccountingIsSelected = 'selected';
                        } else if (x.col_user_access == 4) {
                            AdminIsSelected = 'selected';
                        }
                        if (x.remote_att == 1) {
                            IsRemote = 'selected';
                        }
                        $('#table_container').append(`
                            <tr class="empl_row" empl_id="` + x.id + `">
                                <td>` + x.col_empl_cmid + `</td>
                                <td><a href = "<?= base_url() ?>employees/personal?id=` + x.id + `">
                                    <img class="rounded-circle avatar " width="35" height="35" src="` + user_image + `">&nbsp;&nbsp;` + fullname + `</a>
                                </td>
                                <td>` + x.col_empl_posi + `</td>
                                <td>
                                    <select name="user_access" id="user_access" class="form-control">
                                        <option value="0" ` + staffIsSelected + `>STAFF</option>
                                        <option value="2" ` + HRIsSelected + `>HR</option>
                                        <option value="3" ` + AccountingIsSelected + `>ACCOUNTING</option>
                                        <option value="4" ` + AdminIsSelected + `>ADMIN</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="user_access" id="user_access" class="form-control">
                                        <option value="0">Disabled</option>
                                        <option value="1" ` + IsRemote + `>Enabled</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-primary btn_reset_pass">Reset Password</a>
                                </td>
                            </tr>
                        `);
                    })
                })
                get_all_filter_data(url_get_all_filter_data).then(function(data) {
                    $('#filter_by_group').html('');
                    $('#filter_by_section').html('');
                    $('#filter_by_department').html('');
                    $('#filter_by_line').html('');
                    $('#filter_by_group').append('<option value="">All Groups</option>');
                    $('#filter_by_section').append('<option value="">All Sections</option>');
                    $('#filter_by_department').append('<option value="">All Departments</option>');
                    $('#filter_by_line').append('<option value="">All Lines</option>');
                    Array.from(data.DISP_Group).forEach(function(x) {
                        if (x.col_empl_group != '') {
                            $('#filter_by_group').append(`
                                <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                            `)
                        }
                    })
                    Array.from(data.DISP_DISTINCT_SECTION).forEach(function(x) {
                        if (x.col_empl_sect != '') {
                            $('#filter_by_section').append(`
                                <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                            `)
                        }
                    })
                    Array.from(data.DISP_DISTINCT_DEPARTMENT).forEach(function(x) {
                        if (x.col_empl_dept != '') {
                            $('#filter_by_department').append(`
                                <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                            `)
                        }
                    })
                    Array.from(data.DISP_Line).forEach(function(x) {
                        if (x.col_empl_line != '') {
                            $('#filter_by_line').append(`
                                <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                            `)
                        }
                    })
                })
            })
            // =============================================================== UPDATE USER ACCESS =======================================================
            function save_user_access() {
                // var row_length = $('.empl_row').length;
                // var updted_rows = 0;
                
                Array.from($('.empl_row')).forEach(function(e) {
                    var td_user_access_parent       = e.childNodes[7];
                    var user_access_dropdown        = td_user_access_parent.childNodes[1];
                    var user_access_id              = $(user_access_dropdown).val();

                    var td_remote_attendance        = e.childNodes[9];
                    var remote_attendance_dropdown  = td_remote_attendance.childNodes[1];
                    var remote_attendance           = $(remote_attendance_dropdown).val();

                    var td_disable                  = e.childNodes[11];
                    var disable_dropdown            = td_disable.childNodes[1];
                    var disable                     = $(disable_dropdown).val();
                    
                    var empl_id                     = $(e).attr('empl_id');

                    update_empl_user_access(url_update_empl_user_access, empl_id, user_access_id, remote_attendance, disable).then(function(data) {
                        console.log(empl_id + ' - ' + data +' disable = '+ disable);
           
                       
                    })
                })
            }
            $('#save_user_access').click(function() {
                save_user_access();
                // Swal.fire(
                //     'Changes Saved',
                //     '',
                //     'success'
                // )

                $(document).Toasts('create', {
                    class: 'bg-success toast_width',
                    title: 'Success',
                    subtitle: 'close',
                    body: 'Access Management Updated Successfully'
                })
            })
            // ========================================================== RESET PASSWORD =================================================
            $('.btn_reset_pass').click(function() {
                var parent_tr = $(this).parent().parent();
                var empl_id = $(parent_tr).attr('empl_id');
                var reset_pass = $(parent_tr).attr('reset_pass');
                Swal.fire({
                    title: 'Reset Password for this Employee?',
                    text: ' New Password: '+reset_pass,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Reset'
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(empl_id+'\n'+reset_pass);
                        reset_empl_password(url_reset_empl_password, empl_id, reset_pass).then(function(data) {
                            console.log(data)
                            if(data===1){
                                $(document).Toasts('create', {
                                    class: 'bg-success toast_width',
                                    title: 'Success',
                                    subtitle: 'close',
                                    body: 'Password has been reset successfully!'
                                })
                            }
                            else{
                                $(document).Toasts('create', {
                                class: 'bg-danger toast_width',
                                title: 'Fail',
                                subtitle: 'close',
                                body: 'Unable to reset password! Please try again'
                        })
                            }
                        })
                        
                    }
                }).catch((err)=>{
                     $(document).Toasts('create', {
                                class: 'bg-danger toast_width',
                                title: 'Fail',
                                subtitle: 'close',
                                body: 'Unable to reset password! Please try again'
                        })
                })
            })
            async function update_status_remarks(url, date, empl_id, status, remarks) {
                var formData = new FormData();
                formData.append('date', date);
                formData.append('empl_id', empl_id);
                formData.append('status', status);
                formData.append('remarks', remarks);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_all_employee_data(url) {
                var formData = new FormData();
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            // ==================================================== FILTER ========================================================
            async function get_employee_section_data_filter_by_dept(url, department) {
                var formData = new FormData();
                formData.append('department', department);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_employee_data_filter_by_group(url, group) {
                var formData = new FormData();
                formData.append('group', group);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_employee_data_filter_by_line(url, line) {
                var formData = new FormData();
                formData.append('line', line);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_employee_data_filter_by_status(url, status) {
                var formData = new FormData();
                formData.append('status', status);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_employee_data_filter_by_sect(url, section) {
                var formData = new FormData();
                formData.append('section', section);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_employee_data_filter_by_dept(url, department) {
                var formData = new FormData();
                formData.append('department', department);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            // ================================ ASYNC FILTER ===================================
            async function get_filter_data(url, department, line, group, section, status) {
                var formData = new FormData();
                formData.append('department', department);
                formData.append('line', line);
                formData.append('group', group);
                formData.append('section', section);
                formData.append('status', status);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            async function get_all_filter_data(url) {
                var formData = new FormData();
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            // ================================ UPDATE USER ACCESS ===================================
            async function update_empl_user_access(url, empl_id, user_access, remote_attendance, disable) {
                var formData = new FormData();
                formData.append('empl_id', empl_id);
                formData.append('user_access', user_access);
                formData.append('remote_attendance', remote_attendance);
                formData.append('disable', disable);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            // ================================== RESET PASSWORD ======================================
            async function reset_empl_password(url, empl_id, reset_pass) {
                var formData = new FormData();
                formData.append('empl_id', empl_id);
                formData.append('reset_pass', reset_pass)
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