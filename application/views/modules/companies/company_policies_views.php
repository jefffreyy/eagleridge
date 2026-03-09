<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title d-flex align-items-center"><a onclick="afterRenderFunction()" href="<?= base_url('companies') ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                    </a>&nbsp;Policies<h1>
            </div>
        </div>

        <div class="card border-0 p-0 mt-5">
            <div class="card border-0 m-0">
                <div class="table-responsive">
                    <table class="table table-bordered m-0" id="table_main" style="width:100%">
                        <thead>
                            <th style='width:20%;text-align: left;'>TITLE</th>
                            <th style='width:35%;text-align: left;'>DESCRIPTION</th>
                            <th style="width:15%" class="text-left">ATTACHMENT</th>
                        </thead>

                        <tbody id="tbl_application_container">
                            <?php if ($POLICIES) { ?>
                                <?php foreach ($POLICIES as $policy) : ?>
                                    <tr>
                                        <td class="text-left"><?= $policy->title ?></td>
                                        <td class="text-left"><?= $policy->description ?></td>
                                        <td class="text-left">
                                            <?php if (file_exists(FCPATH . 'assets_user/files/hressentials/' . $policy->attachment) && !empty($policy->attachment)) { ?>
                                                <?php if ($this->system_functions->getFileType($policy->attachment) == 'PDF') { ?>
                                                    <a target="_blank" class="h4" href="<?= base_url('assets_user/files/hressentials/' . $policy->attachment) ?>">
                                                        <i class="fa-duotone fa-file-pdf"></i>
                                                    </a>
                                                <?php } elseif ($this->system_functions->getFileType($policy->attachment) == 'Image') { ?>
                                                    <a target="_blank" class="h4" href="<?= base_url('assets_user/files/hressentials/' . $policy->attachment) ?>">
                                                        <i class="fa-duotone fa-file-image"></i>
                                                    </a>
                                                <?php } elseif ($this->system_functions->getFileType($policy->attachment) == 'Excel') { ?>
                                                    <a target="_blank" class="h4" href="<?= base_url('assets_user/files/hressentials/' . $policy->attachment) ?>">
                                                        <i class="fa-duotone fa-file-excel"></i>
                                                    </a>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php } else { ?>
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
</div>