<html>
<?php $this->load->view('templates/css_link');
$user_id = $this->session->userdata('SESS_USER_ID');
?>
<div class="content-wrapper">
  <div class="container-fluid p-4">

    <h1 class="page-title mb-3 d-flex align-items-center"><a onclick="afterRenderFunction()" href="<?= base_url() . 'selfservices'; ?>"> <img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
      </a>&nbsp;Notifications</h1>
    <hr>
    <div class="d-flex justify-content-center justify-content-lg-start">
      <button class="btn btn-primary mark_as_read d-flex align-items-center mr-2"><img style="height: 1.4rem; width: 1.4rem; " src="<?= base_url('assets_system/icons/envelope-circle-check-solid.svg') ?>" alt="">&nbsp;Mark as Read</button>
      <a href="<?= site_url("selfservices/mark_all_as_read/" . $user_id) ?>" class="btn btn-warning"><img style="width: 18px; height: 18px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/envelope-open-solid_dark.svg') ?>" alt="" /> &nbsp;Mark as All Read</a>
    </div>

    <div class="card p-0 mt-3">
      <div class="table-responsive">
        <table class="m-0 table table-hover" id="positions_tbl">
          <thead>
            <tr>
              <th class="text-center">
                <input type="checkbox" class="check_all_notif" />
              </th>
              <th>DATE</th>
              <th>DESCRIPTION</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($C_NOTIFICATION as $NOTIFICATION_ROW) { ?>
              <tr class="<?= $NOTIFICATION_ROW['is_read'] == '0' ? 'text-bold' : '' ?> notif_row" style="cursor:pointer">
                <td class="text-center">
                  <input type="checkbox" class="check_notif_row" data-notif_id="<?= $NOTIFICATION_ROW['id'] ?>" />
                </td>
                <td class="text-left"><?= date(($DATE_FORMAT ? $DATE_FORMAT : "d/m/Y") . " h:i a", strtotime($NOTIFICATION_ROW["create_date"])) ?></td>
                <td><?= $NOTIFICATION_ROW['description'] ?></td>
                <td>
                  <button data-id="<?= $NOTIFICATION_ROW["content_id"] ?>" data-notif_type="<?= $NOTIFICATION_ROW["type"] ?>" class=" btn_view btn btn-sm btn-transparentp-0 m-0" data-toggle="modal" data-target="#modal_approval">
                    <img src="<?= base_url('assets_system/icons/eye-duotone.svg') ?>" alt="" />
                  </button>
                  <form class="read_notif" action="<?= base_url('selfservices/view_notification/' . $NOTIFICATION_ROW['id']) ?>" method='POST'>
                    <input type="hidden" name="location" value="<?= $NOTIFICATION_ROW['location'] ?>" />
                  </form>
                </td>
              </tr>
            <?php } ?>
            <?php if (!$C_NOTIFICATION) { ?>
              <tr class="table-active">
                <td colspan=10 class="text-center">No Records</td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

    </div>

  </div>
</div>
<div class="modal fade" id="modal_approval" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" id="approval_modal_content">
  </div>
</div>
<?php
function getID($listID, $userId)
{
  foreach ($listID as $ids) {
    if ($ids['id'] == $userId) {
      return $ids['col_empl_cmid'];
    }
  }
  return 'user not found';
}
?>
<?php $this->load->view('templates/jquery_link'); ?>

<?php
if ($this->session->flashdata('SUCC')) {
?>
  <script>
    $(document).Toasts('create', {
      class: 'bg-success toast_width',
      title: 'Success!',
      subtitle: 'close',
      body: '<?php echo $this->session->flashdata('SUCC'); ?>'
    })
  </script>
<?php
}
?>

<script>
  $(document).ready(function() {
    var url_approval = "";
    $('form.read_notif').on('submit', function(e) {
      console.log()

      $.post($(this).attr('action'), $(this).serialize(), function(res) {
        var notif_row = $(e.target).closest('tr.notif_row');
        notif_row.removeClass('text-bold')
      })
      return false;
    })
    $('#modal_approval').on('hidden.bs.modal', function(e) {
      $('#approval_modal_content').html('')
    })
    $('#modal_approval').on('show.bs.modal', function(e) {
      var button = $(e.relatedTarget);
      var form_elem = button.closest('.notif_row').find('form.read_notif');
      form_elem.submit();
    })
    $('#modal_approval').on('shown.bs.modal', function(e) {
      var button = $(e.relatedTarget);
      var id = button.data('id');
      var notif_type = button.data('notif_type');


      
      if(notif_type == 'exemptut'){
        $.get("<?= base_url('selfservices/get_exempt_undertime_approval') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }

      if(notif_type == 'undertime'){
        $.get("<?= base_url('selfservices/get_undertime_approval') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }

      if(notif_type == 'changeoff_approval'){
        $.get("<?= base_url('selfservices/get_changeoff_approval') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }

      if(notif_type == 'changeoff_approval_status'){
        $.get("<?= base_url('selfservices/get_changeoff_approval_status') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }
      
      if(notif_type == 'changeshift_approval'){
        $.get("<?= base_url('selfservices/get_changeshift_approval') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }

      if(notif_type == 'changeshift_approval_status'){
        $.get("<?= base_url('selfservices/get_changeshift_approval_status') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }

      if(notif_type == 'offset'){
        $.get("<?= base_url('selfservices/get_offset_approval') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }

      if (notif_type == 'time_adjustment_approval') {
        $.get("<?= base_url('selfservices/get_time_adjustment_approval') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }
      if (notif_type == 'time_adjustment') {
  
        $.get("<?= base_url('selfservices/get_time_adj_status') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }
      if (notif_type == 'time adjustment') {
   
        $.get("<?= base_url('selfservices/get_time_adj_status') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }
      if (notif_type == 'leave_approval') {
        $.get("<?= base_url('selfservices/get_leave_approval') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }
      if (notif_type == 'leave') {
        $.get("<?= base_url('selfservices/get_leave_approval_status') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }
      if (notif_type == 'overtime_approval') {
        $.get("<?= base_url('selfservices/get_overtime_approval') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }
      if (notif_type == 'overtime') {
        $.get("<?= base_url('selfservices/get_overtime_status') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }
      if (notif_type == 'holiday_work_approval') {
        $.get("<?= base_url('selfservices/get_holiday_work_approval') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }
      if (notif_type == 'holiday_work') {
        $.get("<?= base_url('selfservices/get_holiday_work_status') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }
      if (notif_type == 'shift_approval') {
        $.get("<?= base_url('selfservices/get_shift_approval') ?>" + '/' + id, function(res) {
          $('#approval_modal_content').html(res)
        })
      }
      // console.log('notif_type', notif_type);
    });

    $(document).on('click', '.approve_btn', function(e) {
      e.preventDefault();
      var approved_id = $(this).attr('approved_id');
      var adjustment_date = $(this).attr('adjustment_date');
      Swal.fire({
        title: 'Confirmation',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Approve'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#form_approved').submit();
        }
      })
    })
    
    $(document).on('click', '.reject_btn', function(e) {
      e.preventDefault();
      // $('#modal_approval').modal('hide');
      var reject_key = $(this).attr('reject_key');
      Swal.fire({
        // icon: 'warning',
        // input: "textarea",
        // inputLabel: "Add Reason",
        // inputPlaceholder: "Type your message here...",
        // inputAttributes: {
        //   "aria-label": "Type your message here"
        // },
        // showCancelButton: true,
        // inputValidator: (value) => {
        //   if (!value) {
        //     return "You need to write something!";
        //   }
        // },
        // preConfirm: async (e) => {
        //   await $('input#remarks_reject').val(e);
        // },
        title: 'Confirmation',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,

        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Reject'
      }).then((result) => {
        if (result.isConfirmed) {
          console.log('must reject');
          $('#form_reject').submit();
        }
      })
    })

    $('button.mark_as_read').on('click', async function() {
      let response = await $('input.check_notif_row:checked').each(function() {
        const formElement = $(this).closest('tr').find('form');
        const notif_id = $(this).data('notif_id');
        $.post("<?= site_url('selfservices/mark_as_read') ?>", {
          'id': notif_id
        }, function(res) {

        })
      });
      window.location = "<?= site_url('selfservices/notifications') ?>"

    })
    $('input.check_all_notif').on('change', function() {
      if ($(this).prop('checked')) {
        $('input.check_notif_row').prop('checked', true);
        return;
      }
      $('input.check_notif_row').prop('checked', false);
    })
    $('tr.notif_row').on('click', function(e) {
      if (!$(e.target).is('input.check_notif_row')) {
        const formElement = $(this).find('form');
        // console.log(formElement);
        // formElement.submit();
      }
    });

  })
</script>

</html>