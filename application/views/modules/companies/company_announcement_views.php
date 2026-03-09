<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title d-flex align-items-center"><a onclick="afterRenderFunction()" href="<?= base_url('companies') ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
</a>&nbsp;Announcements<h1>
            </div>
        </div>
      
        <div class="row justify-content-center mt-4">
            <div class="col col-md-8">
                <div class="card">
                    <div>
                        <div id="tbl_announcement">
                            <?php foreach ($ANNOUNCEMENTS as $announcement) : 
                                $name = $announcement->col_last_name;
                                if(!empty($announcement->col_last_name))$name = $name.' '.$announcement->col_suffix;
                                if(!empty($announcement->col_frst_name))$name = $name.', '.$announcement->col_frst_name;
                                if(!empty($announcement->col_midl_name))$name = $name.' '.$announcement->col_midl_name[0].'.';
                                ?>
                                <div class="p-3">
                                    <div>
                                        <a class="announcement_title"><?= $announcement->title ?></a>
                                        <div class="author_name mb-2 mt-1"> <a>
                                                <img width="30px" height="30px" class="rounded-circle mr-1  elevation-2" loading="lazy" style="object-fit:scale-down" src="<?= $this->system_functions->profileImageCheck('assets_user/user_profile/',$announcement->col_imag_path)?>"> </a>
                                            <a class="author_name"><?= $name
                                            // $announcement->col_last_name . ',' . $announcement->col_frst_name . ' ' . $announcement->col_midl_name . '.' 
                                            ?></a>
                                            <span class="text-muted ml-1 author_date">
                                                <?= date_format(date_create($announcement->create_date), "$DATE_FORMAT") ?>
                                            </span>
                                        </div>

                                        <p class="my-2"><?= $announcement->description ?></p>
                                        <div class="plain_text text-justify" style="overflow: hidden;  text-overflow: ellipsis !important; ">
                                            <?php if (file_exists(FCPATH . 'assets_user/files/hressentials/' . $announcement->attachment) && !empty($announcement->attachment)) { ?>
                                                <img width='80%' class="d-block m-auto" src="<?= base_url('assets_user/files/hressentials/' . $announcement->attachment) ?>" />
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/jquery_link'); ?>
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<?php if ($this->session->flashdata('ERR')) { ?>
    <script>
        Swal.fire(
            '<?= $this->session->flashdata('ERR') ?>',
            '',
            'error'
        )
    </script>
<?php } ?>
<?php if ($this->session->flashdata('SUCC')) { ?>
    <script>
        Swal.fire(
            '<?= $this->session->flashdata('SUCC') ?>',
            '',
            'success'
        )
    </script>
<?php } ?>
<script>
    $(document).ready(function() {
        var model_name  = "main_table_02_model";
        var module_name = "companies";
        var table_name  = "tbl_hr_announcements";
        var page_name   = "announcements";
        var url_get_all = "<?= base_url('companies/announcements') ?>";
        $('.bulk-button').click(function() {
            let action = $(this).data('action');
            if (action == 'activate') {
                $('#form_activation').attr('action', "<?= base_url('companies/activate') ?>")
            }
            if (action == 'deactivate') {
                $('#form_activation').attr('action', "<?= base_url('companies/deactivate') ?>")
            }
            let rows_id = [];
            var mymodal_data = $(this).data('id');
            console.log(mymodal_data);
            $('#modal_title').val(mymodal_data);
            var status = $(this).attr('status');
            $('#select_item input[type=checkbox]:checked').each(function() {
                var selected_item = $(this).attr('row_id');
                rows_id.push(selected_item);
            })
            $('#list_mark').empty();
            if (rows_id.length > 0) {
                $('.class_modal_set_ssa').prop('id', 'modal_set_ssa');
                var list_mark_ids = rows_id.join(" ");
                $('#list_mark_ids').val(list_mark_ids);
                rows_id.forEach(function(single_id) {
                    $('#list_mark').append(`<li class="col-md-6">` + String("00000000" + single_id).slice(-8) + `</li>`)
                })
            } else {
                $('.class_modal_set_ssa').prop('id', '');
                Swal.fire(
                    'Please Select Row!',
                    '',
                    'warning'
                )
            }
        })
        $('#row_dropdown').on('change', function() {
            var row_val = $(this).val();
            var tab_val = "Active";
            window.location = "?page=1&row=" + row_val + "&tab=" + tab_val;
            return false;
        });
        $('#check_all').click(function() {
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
            var tab_val     = "Active";
            var optionValue = $('#search_data').val();
            var url         = window.location.href.split("?")[0];
            if (window.location.href.indexOf("?") > 0) {
                window.location = url + "?page=1&tab=" + tab_val + "&all=" + optionValue.replace(/\s/g, '_');
            } else {
                window.location = url + "?page=1&tab=" + tab_val + "&all=" + optionValue.replace(/\s/g, '_');
            }
        }
        $('.delete_data').click(function(e) {
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
                    window.location.href = "<?=base_url()?>" + "main_table_02/delete_row?delete_id=" + user_deleteKey + "&table=" + table_name + "&module=" + module_name + "&page=" + page_name;
                }
            })
        })
    })

</script>
