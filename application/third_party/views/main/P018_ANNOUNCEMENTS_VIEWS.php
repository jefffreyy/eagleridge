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
</style>

<?php
$url_count = $this->uri->total_segments();
$url_directory = $this->uri->segment($url_count);
?>


<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">

<!-- Pagination -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/bs-pagination.min.css">
<!-- Datatable -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">

<!-- Include Editor style. -->
<!-- <link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_style.min.css" rel="stylesheet" type="text/css" /> -->
<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row">
      <div class="col-md-6">
        <h1 class="page-title">Announcements </h1>
      </div>
    </div>
    <hr>
    <div class="row mb-2">
      <div class="col">
        <form class="new_q" id="new_q" action="#" accept-charset="UTF-8" method="get">
          <div class="form-row align-items-center">
            <div class="col mb-1">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1" style="background-color: white;"><i class="fas fa-search"></i></span>
                </div>
                <input autofocus="autofocus" class="form-control" placeholder="Search Title..." type="search" name="work_pattern_search" id="work_pattern_search">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col ml-auto">
        <a class="btn btn-primary float-right" title="Add" href="#" data-toggle="modal" data-target="#modal_add_announcements">
          <i class="fas fa-fw fa-plus">
          </i> Add
        </a>
      </div>
    </div>
    <div class = "card border-0 mt-2" style = "padding: 0px; margin: 0px">
      <table class="table table-hover table-xs">
        <thead>
          <tr>
            <th>Title</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody id="tbl_application_container">
          <?php
          if ($DISP_ANNOUNCEMENTS_INFO) {
            foreach ($DISP_ANNOUNCEMENTS_INFO as $ROW_ANNOUNCEMENTS_INFO) {
          ?>
              <tr>
                <td><?= $ROW_ANNOUNCEMENTS_INFO->name ?></td>
                <td><?= $ROW_ANNOUNCEMENTS_INFO->description ?></td>
                <td class="">
                  <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                      <a class="btn btn-sm indigo lighten-2" announcements_id="<?= $ROW_ANNOUNCEMENTS_INFO->id ?>" title="Edit" data-toggle="modal" data-target="#modal_edit_announcements">
                        <i class="fas fa-edit">
                        </i>
                      </a>
                      <a class="btn btn-sm indigo lighten-2 text-danger ANNOUNCEMENTS_BTN_DLT" delete_key="<?= $ROW_ANNOUNCEMENTS_INFO->id ?>">
                        <i class="fas fa-trash">
                        </i>
                      </a>
                    </div>
                  </div>
                </td>
              </tr>
            <?php
            }
          } else { ?>
            <tr>
              <td colspan='3'>No Data Yet
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
      <ul id="btn_pagination" class="pagination mr-auto ml-auto"></ul>
    </div>
  </div>
  <!-- flex-fill -->
</div>

<?php
$page_count = $DISP_ROW_COUNT[0]->anc_count / 20;

if (($DISP_ROW_COUNT[0]->anc_count % 20) != 0) {
  $page_count = $page_count++;
}

$page_count = ceil($page_count);
?>

<input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT[0]->anc_count ?>">
<input type="hidden" id="page_count" value="<?= $page_count ?>">

<!-- content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<!-- Add position -->
<div class="modal fade" id="modal_add_announcements" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Add Announcements
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('announcements/insrt_announcements'); ?>" id="ANNOUNCEMENTS_FORM_ADD" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="ANNOUNCEMENTS_INPF_NAME">Title
                </label>
                <input class="form-control form-control " type="text" name="ANNOUNCEMENTS_INPF_NAME" id="ANNOUNCEMENTS_INPF_NAME">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="required " for="ANNOUNCEMENTS_INPF_NAME">Description</label>
            <textarea class="form-control" name="INSRT_TASK_DESC" id="INSRT_TASK_DESC" cols="30" rows="10"></textarea>
          </div>

        </div>

        <input type="hidden" name="SENT_BY_EMPL_ID" value="<?= $this->session->userdata('SESS_USER_ID') ?>">

        <div class="modal-footer">
          <button class='btn btn-primary text-light' id="ANNOUNCEMENTS_BTN_SAVE">&nbsp; Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit position -->
<div class="modal fade" id="modal_edit_announcements" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Announcements
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('announcements/updt_announcements'); ?>" id="ANNOUNCEMENTS_FORM_EDIT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="asset_code">Name
                </label>
                <input class="form-control form-control " type="text" name="UPDT_ANNOUNCEMENTS_INPF_NAME" id="UPDT_ANNOUNCEMENTS_INPF_NAME" required>
              </div>
            </div>
            <input type="hidden" name="UPDT_ANNOUNCEMENTS_INPF_ID" id="UPDT_ANNOUNCEMENTS_INPF_ID">
          </div>
        </div>
        <div class="modal-footer">
          <a class='btn btn-primary text-light' id="ANNOUNCEMENTS_BTN_UPDT">&nbsp; Update
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
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

<!-- Pagination -->
<script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>
<!-- Data table -->
<script src="<?= base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>


<!-- Include Editor JS files. -->
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/js/froala_editor.pkgd.min.js"> -->
</script>
<!-- Initialize the editor. -->
<script>
  $(function() {
    /* $('div#froala-editor').froalaEditor({
      // Set custom buttons with separator between them.
      toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting','html'],
      toolbarButtonsXS: ['undo', 'redo' , '-', 'bold', 'italic','html']
    }
                                       )
    $('i.fa.fa-rotate-left').attr('class') */
  });
</script>
<!-- SESSION MESSAGES -->
<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_ANNOUNCEMENTS')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_ANNOUNCEMENTS'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_ANNOUNCEMENTS');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_UPDT_ANNOUNCEMENTS')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_ANNOUNCEMENTS'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_UPDT_ANNOUNCEMENTS');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_DLT_ANNOUNCEMENTS')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_ANNOUNCEMENTS'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_DLT_ANNOUNCEMENTS');
}
?>
<script>
  $(document).ready(function() {
    // Get & Display Data to Edit Modal Using Async JS function
    var url_get_announcements = '<?= base_url() ?>announcements/get_announcements';
    var url_get_search_announcements = '<?= base_url() ?>announcements/get_search_announcements';
    var url_get_anc_application_data = '<?= base_url() ?>announcements/get_anc_application_data';
    var url = '<?php echo base_url(); ?>announcements/getAnnouncementsData';

    const openModalButton = document.querySelectorAll('[data-target]');
    openModalButton.forEach(button => {
      button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.target);
        getAnnouncementsData(url, button.getAttribute('announcements_id')).then(data => {
          var anc_id = 'ANC' + (e.id).padStart(5, 0);

          if (data.length > 0) {
            data.forEach((x) => {
              document.getElementById('UPDT_ANNOUNCEMENTS_INPF_ID').value = x.id;
              document.getElementById('UPDT_ANNOUNCEMENTS_INPF_NAME').value = x.name;
            });
          }
        });
      });
    });
    async function getAnnouncementsData(url, announcements_id) {
      var formData = new FormData();
      formData.append('ANNOUNCEMENTS_GET_ANNOUNCEMENTS_DATA', announcements_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }
    // Update Position
    $('#ANNOUNCEMENTS_BTN_UPDT').click(function() {
      var announcements_name = $('#UPDT_ANNOUNCEMENTS_INPF_NAME').val();
      var hasErr = 0;
      if (!announcements_name) {
        hasErr++;
      }
      if (hasErr == 0) {
        Swal.fire({
          title: 'Do you want to save the following changes?',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.isConfirmed) {
            $('#ANNOUNCEMENTS_FORM_EDIT').submit();
          }
        })
      } else {
        $('#UPDT_ANNOUNCEMENTS_INPF_NAME').addClass('is-invalid');
      }
    })
    $('#UPDT_ANNOUNCEMENTS_INPF_NAME').keyup(function() {
      $('#UPDT_ANNOUNCEMENTS_INPF_NAME').removeClass('is-invalid');
    })

    $(function() {
      /* $('div#froala-editor').froalaEditor({
        // Set custom buttons with separator between them.
        toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting','html'],
        toolbarButtonsXS: ['undo', 'redo' , '-', 'bold', 'italic','html']
        })

        $('i.fa.fa-rotate-left').attr('class')
        
        $('.fr-view').keyup(function(){
            var fr_text = $('.fr-view').text();
            $('#INSRT_TASK_DESC').val(fr_text);
      }) */
    });

    // Delete Position
    $('.ANNOUNCEMENTS_BTN_DLT').click(function(e) {
      e.preventDefault();
      var user_deleteKey = $(this).attr('delete_key');
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
          window.location.href = "<?= base_url(); ?>announcements/dlt_announcements?delete_id=" + user_deleteKey;
        }
      })
    })

    $('#work_pattern_search').keyup(function() {
      var search = $("#work_pattern_search").val();
      // console.log(search)
      get_search_announcements(url_get_search_announcements, search).then(function(data) {
        // console.log(data);
        if (search) {
          $('#tbl_application_container').html('');
          Array.from(data).forEach(function(e) {

            var anc_id = 'ANC' + (e.id).padStart(5, 0);

            var announcements_id = e.id;
            var name = e.name;
            var description = e.description;

            $('#tbl_application_container').append(`
                  <tr>
                      <td>` + name + `</td>
                      <td>` + description + `</td>
                      <td class="">
                        <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                          <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                            <a class="btn btn-sm indigo lighten-2" announcements_id="<?= $ROW_ANNOUNCEMENTS_INFO->id ?>" title="Edit" data-toggle="modal" data-target="#modal_edit_announcements" >
                              <i class="fas fa-edit">
                              </i>
                            </a>
                            <a class="btn btn-sm indigo lighten-2 text-danger ANNOUNCEMENTS_BTN_DLT" delete_key="<?= $ROW_ANNOUNCEMENTS_INFO->id ?>">
                              <i class="fas fa-trash">
                              </i>
                            </a>
                          </div>
                        </div>
                      </td>
                  </tr>
              `)
          })
        } else {
          location.reload();
        }
      })
    })

    $('#btn_pagination').pagination();

    var row_count = $('#row_count').val();
    var page_count = $('#page_count').val();

    // console.log(row_count);
    // console.log(page_count);

    $('#btn_pagination').pagination({

      // the number of entries
      total: row_count,

      // current page
      current: 1,

      // the number of entires per page
      length: 20,

      // pagination size
      size: 2,

      // Prev/Next text
      prev: "&lt;",
      next: "&gt;",

      // fired on each click
      click: function(e) {
        $('#tbl_application_container').html('');

        var row_count = $('#row_count').val();
        var page_count = $('#page_count').val();
        // console.log(e.current);
        var page_num = e.current;

        // console.log(page_num);

        get_announcements(url_get_announcements, page_num).then(function(data) {
          console.log(data);
          Array.from(data).forEach(function(e) {

            var anc_id = 'ANC' + (e.id).padStart(5, 0);

            var announcements_id = e.id;
            var name = e.name;
            var description = e.description;

            $('#tbl_application_container').append(`
                                <tr>
                                    <td>` + name + `</td>
                                    <td>` + description + `</td>
                                    <td class="">
                                      <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                          <a class="btn btn-sm indigo lighten-2" announcements_id="<?= $ROW_ANNOUNCEMENTS_INFO->id ?>" title="Edit" data-toggle="modal" data-target="#modal_edit_announcements" >
                                            <i class="fas fa-edit">
                                            </i>
                                          </a>
                                          <a class="btn btn-sm indigo lighten-2 text-danger ANNOUNCEMENTS_BTN_DLT" delete_key="<?= $ROW_ANNOUNCEMENTS_INFO->id ?>">
                                            <i class="fas fa-trash">
                                            </i>
                                          </a>
                                        </div>
                                      </div>
                                    </td>
                                </tr>
                            `)
          })
        })

      }
    });


    async function get_search_announcements(url, search) {
      var formData = new FormData();
      formData.append('work_pattern_search', search);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_announcements(url, page_num) {
      var formData = new FormData();
      formData.append('page_num', page_num);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_anc_application_data(url, page_num) {
      var formData = new FormData();
      formData.append('page_num', page_num);
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