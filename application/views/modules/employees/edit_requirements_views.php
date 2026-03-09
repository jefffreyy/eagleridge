<html>
<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title"><a href="<?= base_url() ?>employees/personal?id=<?= $C_USER_ID ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="">
                    </a>&nbsp;Edit Requirements<h1>
            </div>
        </div>

        <div class="row  d-flex justify-content-center">
            <div class="col-md-8 card p-1" id="content_container">
                <div class="card-title pl-4 pt-0 pb-0 text-bold header-title">
                </div>
                <hr class="mb-0">
                <div class="row pl-3 pr-3">
                    <form style="width:100%" action="<?php echo base_url('employees/save_document'); ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="table-responsive">
                            <table class="table table-xs table-hover table-nowrap mb-0" style="border:none;">
                                <tbody>
                                    <thead>
                                        <th>Name</th>
                                        <th>Attachment</th>
                                        <th>Status</th>
                                        <th>Upload</th>
                                    </thead>

                                    <?php
                                    if ($C_REQUIREMENTS) {
                                        foreach ($C_REQUIREMENTS as $C_DOCUMENTS_ROW) {
                                    ?>
                                            <tr>
                                                <td><?= $C_DOCUMENTS_ROW->name; ?></td>
                                                <td><?= $C_DOCUMENTS_ROW->attachment; ?></td>
                                                <td>
                                                    <select class="form-control" onchange="update_status('<?php echo $C_DOCUMENTS_ROW->tbl_employee_requirements_id; ?>',
                                        '<?php echo $C_DOCUMENTS_ROW->tbl_std_requirements_id; ?>', this.value)" name="require_id_status<?php echo $C_DOCUMENTS_ROW->tbl_employee_requirements_id; ?>" id="std_id_status<?php echo $C_DOCUMENTS_ROW->tbl_std_requirements_id; ?>">
                                                        <option value="" <?php if ($C_DOCUMENTS_ROW->status == 'Done') {
                                                                                echo "Selected";
                                                                            } ?>>-Select-</option>
                                                        <option value="Done" <?php if ($C_DOCUMENTS_ROW->status == 'Done') {
                                                                                    echo "Selected";
                                                                                } ?>>Done</option>
                                                        <option value="Not Done" <?php if ($C_DOCUMENTS_ROW->status == 'Not Done') {
                                                                                        echo "Selected";
                                                                                    } ?>>Not Done</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="container">
                                                        <form>
                                                            <label class="btn btn-primary" for="std_id_<?php echo $C_DOCUMENTS_ROW->tbl_std_requirements_id; ?>">Upload File</label>
                                                            <input type="file" class="d-none custom-file-input_ben" id="std_id_<?php echo $C_DOCUMENTS_ROW->tbl_std_requirements_id; ?>" name="require_id_<?php echo $C_DOCUMENTS_ROW->tbl_employee_requirements_id; ?>">
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr class="table-active">
                                            <td colspan="9">
                                                <center>No Data Yet</center>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
<?php
if ($this->session->flashdata('ERR')) {
?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('ERR'); ?>'
        })
    </script>
<?php
}
?>

<script>
    function update_status(requirement_id, std_id, status) {
        const data = {
            requirement_id,
            std_id,
            status,
            empl_id: <?php echo $C_USER_ID ?>,
        }
        const controllerUrl = '<?php echo base_url(); ?>employees/save_edit_requirement_status';
        fetch(controllerUrl, {
                method: 'POST',
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                console.log('data', data);
                if (data?.SUCC) {
                    location.reload();
                }
                if (data?.ERR) {
                    $(document).Toasts('create', {
                        class: 'bg-warning toast_width',
                        title: 'Warning!',
                        subtitle: 'close',
                        body: 'Failed' + data?.ERR
                    })
                }
            })
            .catch(error => {
                console.error('Error:', error);
                $(document).Toasts('create', {
                    class: 'bg-warning toast_width',
                    title: 'Warning!',
                    subtitle: 'close',
                    body: error
                })
            });
    }
</script>

<script>
    const fileInputs = document.querySelectorAll('.custom-file-input_ben');
    fileInputs.forEach(fileInput => {
        fileInput.addEventListener('change', function(event) {
            const std_id = event.target.id;
            const requirement_id = event.target.name;
            const selectedFile = event.target.files[0];
            const data = {
                std_id: event.target.id.replace("std_id_", ""),
                requirement_id: event.target.name.replace("require_id_", ""),
                empl_id: <?php echo $C_USER_ID ?>,
            }
            console.log('data', data);
            if (selectedFile && data.std_id) {
                const formData = new FormData();
                formData.append('std_id', data.std_id);
                formData.append('requirement_id', data.requirement_id);
                formData.append('empl_id', data.empl_id);
                formData.append('file', selectedFile);
                const controllerUrl = '<?php echo base_url(); ?>employees/save_edit_requirement';
                fetch(controllerUrl, {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('data', data);
                        if (data?.SUCC) {
                            location.reload();
                        }
                        if (data?.ERR) {
                            $(document).Toasts('create', {
                                class: 'bg-warning toast_width',
                                title: 'Warning!',
                                subtitle: 'close',
                                body: 'Failed' + data?.ERR
                            })
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        $(document).Toasts('create', {
                            class: 'bg-warning toast_width',
                            title: 'Warning!',
                            subtitle: 'close',
                            body: error
                        })
                    });
            }
        });
    });
</script>

</body>

</html>