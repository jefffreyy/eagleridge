<?php $this->load->view('templates/css_link'); ?>

<head>
    <style>
        .calendar-table {
            display: none !important;
        }
    </style>
</head>

<div class="content-wrapper" style="min-height: 624px;">

    <div class="container-fluid px-4">

        <div class='row mt-3'>
            <div class='col-md-8'>
                <h2><a href="<?= base_url('overtimes/overtime_step') ?>"><img style="width: 32px; height: 32px; " class="mb-1" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?= site_url('overtimes/update_overtime_step') ?>" method="POST">
                                    <div class="form-group">
                                        <label class="required" for="step_count">Overtime Step Count</label>
                                        <select class="form-control" name="step_count" id="step_count" required>
                                            <option value="">-Select Step Count-</option>
                                            <option value="1" <?= ($step_count == 1) ? 'selected' : '' ?>>1</option>
                                            <option value="0.5" <?= ($step_count == 0.5) ? 'selected' : '' ?>>0.5</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                                </form>
                            </div>
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
                    title: 'Success',
                    subtitle: 'close',
                    body: '<?php echo $this->session->flashdata('SUCC'); ?>'
                })
            </script>
        <?php
              $this->session->unset_flashdata('SUCC');
          }
        ?>
    </div>
</div>
