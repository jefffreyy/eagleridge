
<html>
<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/home_style'); ?>
<?php
$fullname = '';
$User_access = '';
$Username = '';
$Group = '';
if ($DISP_USER_INFO) {
    foreach ($DISP_USER_INFO as $DISP_USER_INFO_ROW) {
        $fullname = $DISP_USER_INFO_ROW->col_frst_name . ' ' . $DISP_USER_INFO_ROW->col_last_name;
        $User_access = $DISP_USER_INFO_ROW->col_user_access;
        $Username = $DISP_USER_INFO_ROW->col_user_name;
        $Group = $DISP_USER_INFO_ROW->col_empl_group;
    }
}
?>
<?php
$user_id = '';
$user_image = '';
$employee_id = '';
$lastname = '';
$middlename = '';
$firstname = '';
$full_name = '';
$company_number = '';
$company_email = '';
$hired_on = '';
$employment_type = '';
$position = '';
$section = '';
$department = '';
$division = '';
$reporting_to = '';
if ($DISP_USER_INFO) {
    foreach ($DISP_USER_INFO as $DISP_USER_INFO_ROW) {
        $user_image = $DISP_USER_INFO_ROW->col_imag_path;
        $lastname = $DISP_USER_INFO_ROW->col_last_name;
        $middlename = $DISP_USER_INFO_ROW->col_midl_name;
        $firstname = $DISP_USER_INFO_ROW->col_frst_name;
        if ($middlename) {
            $full_name = $lastname . ', ' . $firstname . ' ' . $middlename;
        } else {
            $full_name = $lastname . ', ' . $firstname;
        }
        $position = $DISP_USER_INFO_ROW->col_empl_posi;
        
    }
}
?>
<style>
    li.approval-nav a.active{
        background-color:#7AC68B !important;
    }
    h6 {
        font-size: 14px !important;
    }
    .img-circle_sm{
        border-radius: 50% !important;
        width:30px !important;
        height:30px !important;
        object-fit: scale-down;
        background-color: #b0b0b0;
    }
    .img-circle {
        border-radius: 50% !important;
        height: 65px !important;
        object-fit: scale-down;
    }
    .img-circle-new-emp {
        border-radius: 50% !important;
        width:80px !important;
        height:80px !important;
        object-fit: scale-down;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
    <div class="nav navbar navbar-expand navbar-white navbar-light border-bottom p-0">
      <div class="nav-item dropdown">
        <a class="nav-link bg-danger dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Close</a>
        <div class="dropdown-menu mt-0">
          <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all">Close All</a>
          <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all-other">Close All Other</a>
        </div>
      </div>
      <a class="nav-link bg-light" href="#" data-widget="iframe-scrollleft"><i class="fas fa-angle-double-left"></i></a>
      <ul class="navbar-nav overflow-hidden" role="tablist">

      
      </ul>
      <a class="nav-link bg-light" href="#" data-widget="iframe-scrollright"><i class="fas fa-angle-double-right"></i></a>
      <a class="nav-link bg-light" href="#" data-widget="iframe-fullscreen"><i class="fas fa-expand"></i></a>
    </div>
    <div class="tab-content">
      <div class="tab-empty">
        <h2 class="display-4" style = "padding-top:300px">No tab selected!</h2>
      </div>
      <div class="tab-loading">
        <div>
          <h2 class="display-4" style = "padding-top:300px">Tab is loading <i class="fa fa-sync fa-spin"></i></h2>
        </div>
      </div>
    </div>
  </div>
<aside class="control-sidebar control-sidebar-dark">
</aside>
<!-- Request Time off -->
<div class="modal fade" id="modal_request_time_off" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pb-0" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Time Off Request</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url('contacts/update_contact'); ?>" id="update_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="required" for="leave_request_employee_leave_type_id">Leave Type</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div data-controller="none" data-none-cache-value="1622704009">
                                            <select class="form-control custom-select" required name="leave_request[employee_leave_type_id]" id="leave_request_employee_leave_type_id">
                                                <option value="">-- Select --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div data-controller="none" data-none-cache-value="1622704009">
                                            <input type="date" class="form-control" name="date" id="date" placeholder="DD.MM.YYYY - DD.MM.YYYY">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-bold mb-1 mt-2">Note</p>
                            <textarea class="form-control form-control" name="leave_request[description]" id="leave_request_description"></textarea>
                            <small class="form-text text-muted">
                                Here you can leave some extra information about your leave request such as reason.
                            </small>
                        </div>
                        <input type="hidden" name="contact_id" id="contact_number">
                    </div>
                </div>
                <div class="modal-footer">
                    <a class='btn btn-primary text-light' id="btn_updateContact">&nbsp; Save</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        Modal content
        <div class="modal-content hero-image" style="border-radius: 15px; border : none;">
            <div class="modal-body ">
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="width: fit-content; margin: 0 auto; background: transparent; border: none;">Remind me later</button>
</div> -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Welcome Title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Welcome Body Here...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- LOGOUT MODAL -->
<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Hi are you sure you want to logout?</p>
            </div>
            <div class="modal-footer pb-1 pt-1">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout</a>
            </div>
        </div>
    </div>
</div>
<!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->
<?php $this->load->view('templates/jquery_link'); ?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_LOGIN')) {
?>
    <script>
        $('#myModal').modal('show');
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_LOGIN');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_DLT_ANNOUNCEMENT')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_ANNOUNCEMENT'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_DLT_ANNOUNCEMENT');
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
        // $('#myModal').modal('show');
        $('a.btn').on('click',function(e){
            e.preventDefault();
            
            let url =$(this).attr('href');
            let action=$(this).text();
            Swal.fire({
              title: 'Confirmation',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: action==='Approve'? '#008037': '#3085d6' ,
              cancelButtonColor: '#d33',
              confirmButtonText: action==='Approve'? 'Approve': 'Reject'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        })
        var url_getChartData = '<?= base_url() ?>home/getChartData';
        setInterval(() => {
            var moment_current_date_time = moment.tz("Asia/Manila").format('llll');
            var split_moment_current_date_time = moment_current_date_time.split(' ');
            var date = split_moment_current_date_time[0] + ' ' + split_moment_current_date_time[1] + ' ' + split_moment_current_date_time[2] + ' ' + split_moment_current_date_time[3];
            var time = moment.tz("Asia/Manila").format('h:mm:ss');;
            var phase = split_moment_current_date_time[5];
            $('#current_date').text(date);
            $('#current_time').text(time);
            $('#current_phase').text(phase);
        }, 10);
        var celebration_tbl_length = $('#celebration_card tbody tr').length;
        var approved_tbl_length = $('#approved_tbl tbody tr').length;
        var rejected_tbl_length = $('#rejected_tbl tbody tr').length;
        if (celebration_tbl_length == 0) {
            $('#celebration_card tbody').append("<tr><td><div class='text-muted small mb-1'>No Incoming Celebrations</div></td></tr>");
        }
        if (approved_tbl_length == 0) {
            $('#approved_tbl tbody').append("<tr><td colspan='6' class='p-4'>No leave application approved under your supervision</td></tr>");
        }
        if (rejected_tbl_length == 0) {
            $('#rejected_tbl tbody').append("<tr><td colspan='6' class='p-4'>No leave application rejected under your supervision</td></tr>");
        }
    })
</script>
</body>
</html>