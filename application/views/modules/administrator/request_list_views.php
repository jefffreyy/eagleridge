<html>
<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'administrators'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Requests List </h1>
            </div>
            <!-- <div class="col-md-6" style="text-align: right;">
                <button type="button" id="btn_add" class="btn btn-primary" data-toggle="modal" data-target="#modal_form"><img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">&nbsp;Add Request</button>
            </div> -->
        </div>
        <!-- Title Header Line -->
        <hr>
        <div class="col-12">
            <div class="card p-0">
                <table class="m-0 table table-bordered table-hover" id="positions_tbl">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 100px">REQUEST ID</th>
                            <th class="text-left">REQUEST DETAILS</th>
                            <th style="width: 120px">STATUS</th>
                            <th style="width: 100px">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($dataTable)) {
                            foreach ($dataTable as $row) { ?>
                                <tr>
                                    <td>RQT<?= str_pad($row->id, 5, '0', STR_PAD_LEFT) ?></td>
                                    <td class="user_access"><?= $row->request_details ?></td>
                                    <td class="text-center">
                                        <?php if($row->status == "Finished"){?>
                                            <div class='class=" technos-button-green p-2 rounded disabled m-auto" style="width:100px"'><?=$row->status?></div>
                                        <?php } elseif($row->status == "For Request"){ ?>
                                            <div class='class=" bg-orange p-2 rounded disabled m-auto" style="width:100px"'><?=$row->status?></div>
                                        <?php } elseif($row->status == "Lined Up"){ ?>
                                            <div class='class=" bg-info p-2 rounded disabled m-auto" style="width:100px"'><?=$row->status?></div>
                                        <?php } elseif($row->status == "Withdrawed"){ ?>
                                            <div class='class=" bg-light p-2 rounded disabled m-auto" style="width:100px"'><?=$row->status?></div>
                                        <?php } elseif($row->status == "Ongoing"){ ?>
                                            <div class='class=" bg-warning p-2 rounded disabled m-auto" style="width:100px"'><?=$row->status?></div>
                                        <?php } ?>
                                    </td>          
                                    <td class="d-flex justify-content-center">
                                        <!-- <a class="btn btn-sm btn_edit indigo lighten-2 edit_position" data-id="<?= $row->id ?>" title="Edit" data-toggle="modal" data-target="#modal_form">
                                            <img src="<?= base_url('assets_system/icons/pen-to-square-solid.svg') ?>" alt="" id="edit">
                                        </a> -->
                                        <button type="button"  data-id="<?= $row->id ?>" class="btn_view" style="background-color: transparent; border: none;color: gray; cursor: pointer; !important" row_id="1">
                                            <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="" id="view">
                                        </button>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr class="table-active">
                                <td colspan="12">
                                    <center>No Records</center>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pb-0" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="ModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="request_details">Request Details (Max 250 characters)</label>
                        <textarea class="form-control" name="request_details" id="request_details" rows="3" maxlength="250"></textarea>
                        <small class="form-text text-muted">Remaining characters: <span id="charCount">250</span></small>
                    </div>
                    <div class="form-group" id="status-div">
                        <label for="request_details">Status</label>
                        <select class="form-control" name="status" id="status" disabled>
                            <option value="For Request">For Request</option>
                            <option value="Lined Up">Lined Up</option>
                            <option value="Withdrawed">Withdrawed</option>
                            <option value="Ongoing">Ongoing</option>
                            <option value="Finished">Finished</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
                    <button type="submit" class='btn btn-primary text-light btn-submit' id="edit_btn_save">&nbsp;Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('templates/jquery_link'); ?>

<?php if ($this->session->flashdata('SUCC')) { ?>
      <script>
          $(document).Toasts('create', {
              class: 'bg-success toast_width',
              title: 'Success!',
              subtitle: 'close',
              body: '<?php echo $this->session->flashdata('SUCC'); ?>'
          })
      </script>
    <?php } ?>

    <?php if ($this->session->flashdata('ERR')) { ?>
        <script>
          $(document).Toasts('create', {
              class: 'bg-warning toast_width',
              title: 'Warning!',
              subtitle: 'close',
              body: '<?php echo $this->session->flashdata('ERR'); ?>'
          })
        </script>
    <?php } ?>

<script>
    document.getElementById('request_details').addEventListener('input', function () {
        var maxLength = 250;
        var currentLength = this.value.length;
        var remainingCharacters = maxLength - currentLength;
        document.getElementById('charCount').innerText = remainingCharacters;
    });
</script>

<script>
    $(document).ready(function() {
        var url = '<?= base_url() ?>administrators';
        var url_add = '<?= base_url() ?>administrators/add_request_list';
        var url_update = '<?= base_url() ?>administrators/update_request_list';

        $("#btn_add").on("click", function() {
            $("#ModalLabel").text("Add Request");
            $("#request_details").val('');
            var statusSelect = document.getElementById("status");
            for (var i = 0; i < statusSelect.options.length; i++) {
                if (statusSelect.options[i].value === "For Request") {
                    statusSelect.options[i].selected = true;
                    break;
                }
            }
            $(".btn-submit").removeClass("d-none");
            $("#request_details").prop("disabled", false);
            $('form').attr("action", url_add);
        })
        $(".btn_view").on("click",function(){
            let id = $(this).attr("data-id");
            $("#modal_form").modal("show");
            $(".btn-submit").addClass("d-none");
            $("#request_details").prop("disabled", true);
            $("#ModalLabel").text(`View Request (RQT${ id.padStart(5, '0')})`);
            console.log('id', id);
            fetch(url + '/view_request_list/' + id).then(response => {
                return response.json();
            }).then(res => {
                console.log('res', res);
                var fetchedRequestDetails = res.dataTable[0]?.request_details;
                document.getElementById("request_details").value = fetchedRequestDetails;
                var remainingCharacters = 250 - fetchedRequestDetails.length;
                document.getElementById("charCount").textContent = remainingCharacters;

                var receivedStatus = res.dataTable[0]?.status;
                var statusSelect = document.getElementById("status");
                
                for (var i = 0; i < statusSelect.options.length; i++) {
                    if (statusSelect.options[i].value === receivedStatus) {
                        statusSelect.options[i].selected = true;
                        break;
                    }
                }
            }).catch(() => {
                console.log('error')
            })
        })
        // $(".btn_edit").on("click", function() {
        //     $("#ModalLabel").text("Edit Request");
        //     $('form').attr("action", url_update);
        //     let id = $(this).attr("data-id");
        //     $("#position_id").val(id);
        //     $("input[type='checkbox']").prop("checked", false);
        //     let user_access = $(this).parent().siblings("td.user_access").text();
        //     $("#position_name").val(user_access);

        //     fetch(url + '/get_user_access_by_id/' + id).then(response => {
        //         return response.json();
        //     }).then(res => {
        //         $('input.check_data').each(function() {

        //             if (res[0]["user_page"].search($(this).val()) >= 0 && $(this).val() != "") {
        //                 $(this).prop("checked", true);
        //             }
        //         })
        //     }).then(() => {
        //         $('.select_all').each(function() {
        //             let check_all = false;
        //             let check_box = $(this).parent().siblings("div.row").children('ul').children('li').children('div').children('input');
        //             check_box.each(function() {
        //                 if ($(this).is(':checked')) {
        //                     check_all = true;
        //                 }
        //             })
        //             $(this).prop("checked", check_all);
        //         })
        //     })
        // })
    })
</script>
</body>

</html>