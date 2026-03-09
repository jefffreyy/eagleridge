<html>
<?php $this->load->view('templates/css_link'); ?>

<style>
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

    .image_profile::after {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        width: 1px;
        background-color: #000;
        border-left: 1px dashed #000;
    }
</style>
<?php
$this->load->library('session');

$url_count = $this->uri->total_segments();
$url_directory = $this->uri->segment($url_count);
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
<html>

<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">

            <div class="row pt-1">
                <div class="col-md-6">
                    <h1 class="page-title d-flex align-items-center"><a href="<?= base_url('teams') ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                        </a>&nbsp;My Team In/Out<h1>
                </div>



            </div>
            <hr>


            <div class="card border-0 p-0 m-0">
                <div class="card border-0 m-0">
                    <div class="p-2">


                    </div>

                    <div class="table-responsive">

                        <table class="table table-bordered m-0" id="table_main" style="width:100%">
                            <thead>

                                <th class="text-center" style="width:5%" hidden><input type="checkbox" name="check_all" id="check_all">
                                </th>
                                <th style='width:10%;text-align: left;'>EMPLOYEE</th>
                                <th style='width:10%;text-align: left;'>DATE</th>
                                <th style='width:10%;text-align: left;'>TIME IN</th>
                                <th style='width:10%;text-align: left;'>TIME OUT</th>
                                <th style="width:10%" class="text-center">ACTION</th>
                            </thead>
                            <tbody id="tbl_application_container">
                                <?php if ($members) { ?>
                                    <?php foreach ($members as $member) { ?>
                                        <tr data-leave_id="" data-toggle="modal" data-target="#modal_approval">
                                            <td class="text-center" id="select_item" hidden>
                                                <input type="checkbox" id="" name="brand" class="check_single" row_id="56">
                                            </td>
                                            <td class="text-left"><?= $member->name ?></td>
                                            <td class="text-left hover td-directs " data-empl_id="" style="width:10%">
                                                <?= date('d/m/Y', strtotime($member->date)) ?>

                                            </td>
                                            <td class="text-left "><?= $member->time_in ?></td>
                                            <td class="text-left"><?= $member->time_out ?></td>
                                            <td class="text-left"></td>
                                        </tr>
                                    <?php } ?>
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


    <?php $this->load->view('templates/jquery_link'); ?>
</body>


</html>