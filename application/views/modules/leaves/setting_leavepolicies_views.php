<?php $this->load->view('templates/companycontribution_style'); ?>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->

<style>
    .image {
        display: flex;
        flex-direction: column;
    }

    .image p {
        margin-left: 8px;
        font-size: 12px;
    }
</style>
<style>
    .switch {
        position: relative;
        display: block;
        width: 50px;
        height: 26px;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .switch input {
        display: none;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 21px;
        width: 21px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50px;
    }

    input:checked+.slider:before {
        background-color: limegreen;
    }

    input:checked+.slider:before {
        transform: translateX(23px);
    }
</style>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="flex-fill">

            <div class="row p-0">
                <div class="col-md-6">
                    <h1 class="page-title"><a href="<?= base_url() . 'leaves'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;Leave Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>

            <div class="mx-auto card d-block d-lg-none col-12">
                <div class="form-group row d-flex justify-content-center">
                    <label for="" class="col-10">Navigate Settings</label>
                    <select name="" class="form-control col-10" id="settingsDropdown">
                        <option value="leave_policies" selected>
                            Leave Policies
                        </option>
                        <option value="leave_types">
                            Leave Types
                        </option>
                    </select>
                </div>
            </div>

            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
                <div class="card col-xl-8 col-lg-4 col-md-8 col-11" style="min-height:700px ">
                    <div class="row">
                        <div class="col-md-3 d-none d-lg-inline-block">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?php $this->load->view('templates/settings_leave_nav_views'); ?>
                            </div>
                        </div>
                        <div class="col-md-9">
                        <div class="row mx-2">
                            <div class="col-md-12 d-flex justify-content-between align-items-center">
                                <span style="font-weight: 500; font-size: 18px">Leave Policies</span>
                                <button type="submit" class="btn btn-primary mb-2 submit_form d-flex align-items-center" id="btn-update">
                                    <img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url() ?>assets_system/icons/circle-arrow-up-sharp-solid.svg" alt="">&nbsp;Update
                                </button>
                                 <!-- <button type="submit" class="btn btn-primary pt-1 pb-1 submit_form d-flex align-items-center" id="btn-update" style="font-size: 14px">
                                        <img class="" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>">&nbsp;Save Changes
                                    </button> -->

                            </div>
  

                                <div class="col-md-12">
                                    Manage leave settings and related features. These settings are applied company-wide.
                                </div>
                            </div>
                            <hr>
                            <?php echo form_open('leaves/update_setting'); ?>
                            <div class="row mx-2">

                                <div class="col-12 "><span style="font-weight: 500;">General</span></div>

                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center ">
                                        <p class="col-12 col-lg-3 mt-2 ml-auto ml-lg-3 text-nowrap">Auto-approve of leave applications</p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1 ">
                                                <label class="switch mx-auto">
                                                    <input type="hidden" name="policy_autoapprove" value="0">
                                                    <input class="switch_on" name="policy_autoapprove" value="1" type="checkbox" <?= $LEAVE_SETTINGS['policy_autoapprove'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center ">
                                        <p class="col-12 col-lg-3 mt-2 ml-auto ml-lg-3 text-nowrap">Nurse Approver</p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1 ">
                                                <label class="switch mx-auto">
                                                    <input type="hidden" name="nurse_approver" value="0">
                                                    <input class="switch_on" name="nurse_approver" value="1" type="checkbox" <?= $LEAVE_SETTINGS['nurse_approver'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center ">
                                        <p class="col-12 col-lg-3 mt-2 ml-auto ml-lg-3 text-nowrap">Receive on-app notifications</p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1 ">
                                                <label class="switch mx-auto">
                                                    <input type="hidden" name="policy_notif_onapp" value="0">
                                                    <input class="switch_on" name="policy_notif_onapp" value="1" type="checkbox" <?= $LEAVE_SETTINGS['policy_notif_onapp'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center ">
                                        <p class="col-12 col-lg-3 mt-2 ml-auto ml-lg-3  text-nowrap">Receive email notifications</p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1 ">
                                                <label class="switch mx-auto">
                                                    <input type="hidden" name="policy_notif_email" value="0">
                                                    <input class="switch_on" name="policy_notif_email" value="1" type="checkbox" <?= $LEAVE_SETTINGS['policy_notif_email'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center ">
                                        <p class="col-12 col-lg-3 mt-2 ml-auto ml-lg-3  text-nowrap">Receive SMS notifications</p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1 ">
                                                <label class="switch mx-auto">
                                                    <input type="hidden" name="policy_notif_sms" value="0">
                                                    <input class="switch_on" name="policy_notif_sms" value="1" type="checkbox" <?= $LEAVE_SETTINGS['policy_notif_sms'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                        <p class="col-12 col-lg-3 mt-2 ml-auto ml-lg-3  text-nowrap">Days or Hours</p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Days</p>
                                            <div class="col-4 col-lg-3 mt-1">
                                                <label class="switch mx-auto">
                                                    <input type="hidden" name="isLeaveHours" value="0">
                                                    <input class="switch_on" name="isLeaveHours" value="1" type="checkbox" <?= $isLeaveHours == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Hours</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="col-12 row m-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                        <p class="col-12 col-lg-3 mt-2 mr-auto p-0 text-nowrap"><span style="font-weight: 500;">Leave without Pay (LWOP)</span></p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center text-nowrap" style="margin-right: 1px;">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1">
                                                <label class="switch enable-switch mx-auto" data-section="lwop">
                                                    <input type="hidden" name="lwop_enable" value="0">
                                                    <input class="switch_on" name="lwop_enable" value="1" type="checkbox" <?= $LEAVE_SETTINGS['lwop_enable'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($LEAVE_SETTINGS['lwop_enable'] == 1) : ?>
                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3  text-nowrap">
                                                Reason
                                            </p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto lwop-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 lwop-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="lwop_reason" value="0">
                                                        <input class="switch_on" name="lwop_reason" value="1" type="checkbox" <?= $LEAVE_SETTINGS['lwop_reason'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto lwop-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap">Attachment</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto lwop-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 lwop-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="lwop_attachment" value="0">
                                                        <input class="switch_on" name="lwop_attachment" value="1" type="checkbox" <?= $LEAVE_SETTINGS['lwop_attachment'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto lwop-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>


                                <?php else : ?>


                                <?php endif; ?>
                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                        <p class="col-12 col-lg-3 mt-2 mr-auto p-0 text-nowrap"><span style="font-weight: 500;">Offset Leave</span></p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center text-nowrap" style="margin-right: 3px;">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1">
                                                <label class="switch enable-switch mx-auto" data-section="offset">
                                                    <input type="hidden" name="offset_enable" value="0">
                                                    <input class="switch_on" name="offset_enable" value="1" type="checkbox" <?= $LEAVE_SETTINGS['offset_enable'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>



                                <?php if ($LEAVE_SETTINGS['offset_enable'] == 1) : ?>
                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap">Reason</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto offset-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 offset-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="offset_reason" value="0">
                                                        <input class="switch_on" name="offset_reason" value="1" type="checkbox" <?= $LEAVE_SETTINGS['offset_reason'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto offset-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap offset-sections">Attachment</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto offset-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 offset-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="offset_attachment" value="0">
                                                        <input class="switch_on" name="offset_attachment" value="1" type="checkbox" <?= $LEAVE_SETTINGS['offset_attachment'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto offset-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                <?php else : ?>


                                <?php endif; ?>
                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                        <p class="col-12 col-lg-3 mt-2 mr-auto p-0 text-nowrap"><span style="font-weight: 500;">Service Incentive Leave (SIL)</span>

                                        <div class="col-12 col-lg-6 row d-flex justify-content-center text-nowrap" style="margin-right: 3px;">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1">
                                                <label class="switch enable-switch mx-auto" data-section="sil">
                                                    <input type="hidden" name="sil_enable" value="0">
                                                    <input class="switch_on" name="sil_enable" value="1" type="checkbox" <?= $LEAVE_SETTINGS['sil_enable'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>



                                <?php if ($LEAVE_SETTINGS['sil_enable'] == 1) : ?>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap sil-sections">Use of Leave credits</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto sil-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 sil-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="sil_credit" value="0">
                                                        <input class="switch_on" name="sil_credit" value="1" type="checkbox" <?= $LEAVE_SETTINGS['sil_credit'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto sil-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap sil-sections">Reason</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto sil-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 sil-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="sil_reason" value="0">
                                                        <input class="switch_on" name="sil_reason" value="1" type="checkbox" <?= $LEAVE_SETTINGS['sil_reason'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto sil-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap sil-sections">Attachment</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto sil-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 sil-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="sil_attachment" value="0">
                                                        <input class="switch_on" name="sil_attachment" value="1" type="checkbox" <?= $LEAVE_SETTINGS['sil_attachment'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto sil-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>


                                <?php else : ?>

                                <?php endif; ?>
                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                        <p class="col-12 col-lg-3 mt-2 mr-auto p-0 text-nowrap"><span style="font-weight: 500;">Vacation Leave</span></p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center text-nowrap" style="margin-right: 3px;">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1">
                                                <label class="switch enable-switch mx-auto" data-section="vacation">
                                                    <input type="hidden" name="vacation_enable" value="0">
                                                    <input class="switch_on" name="vacation_enable" value="1" type="checkbox" <?= $LEAVE_SETTINGS['vacation_enable'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($LEAVE_SETTINGS['vacation_enable']) : ?>
                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap vacation-sections">Use of Leave credits</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto vacation-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 vacation-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="vacation_credit" value="0">
                                                        <input class="switch_on" name="vacation_credit" value="1" type="checkbox" <?= $LEAVE_SETTINGS['vacation_credit'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto vacation-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap vacation-sections">Reason</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto vacation-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 vacation-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="vacation_reason" value="0">
                                                        <input class="switch_on mx-auto" name="vacation_reason" value="1" type="checkbox" <?= $LEAVE_SETTINGS['vacation_reason'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto vacation-sections">Required</p>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap vacation-sections">Attachment</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto vacation-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 vacation-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="vacation_attachment" value="0">
                                                        <input class="switch_on" name="vacation_attachment" value="1" type="checkbox" <?= $LEAVE_SETTINGS['vacation_attachment'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto vacation-sections">Required</p>
                                            </div>
                                        </div>

                                    </div>

                                <?php else : ?>
                                <?php endif; ?>
                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                        <p class="col-md-6 mt-2"><span style="font-weight: 500;">Sick Leave</span></p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center text-nowrap" style="margin-right: 3px;">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1">
                                                <label class="switch enable-switch mx-auto" data-section="sickleave">
                                                    <input type="hidden" name="sick_enable" value="0">
                                                    <input class="switch_on" name="sick_enable" value="1" type="checkbox" <?= $LEAVE_SETTINGS['sick_enable'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>


                                <?php if ($LEAVE_SETTINGS['sick_enable'] == 1) : ?>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap sick-sections">Use of Leave credits</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto sick-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 sick-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="sick_credit" value="0">
                                                        <input class="switch_on" name="sick_credit" value="1" type="checkbox" <?= $LEAVE_SETTINGS['sick_credit'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto sick-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap sick-sections">Reason</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto sick-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 sick-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="sick_reason" value="0">
                                                        <input class="switch_on" name="sick_reason" value="1" type="checkbox" <?= $LEAVE_SETTINGS['sick_reason'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto sick-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap sick-sections">Attachment</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto sick-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 sick-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="sick_attachment" value="0">
                                                        <input class="switch_on" name="sick_attachment" value="1" type="checkbox" <?= $LEAVE_SETTINGS['sick_attachment'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto sick-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                <?php else : ?>
                                <?php endif; ?>

                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                        <p class="col-md-6 mt-2"><span style="font-weight: 500;">Bereavement Leave</span></p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center text-nowrap" style="margin-right: 3px;">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1">
                                                <label class="switch enable-switch mx-auto" data-section="bereavement">
                                                    <input type="hidden" name="bereav_enable" value="0">
                                                    <input class="switch_on" name="bereav_enable" value="1" type="checkbox" <?= $LEAVE_SETTINGS['bereav_enable'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>


                                <?php if ($LEAVE_SETTINGS['bereav_enable'] == 1) : ?>
                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap bereav-sections">Use of Leave credits</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto bereav-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 bereav-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="bereav_credit" value="0">
                                                        <input class="switch_on" name="bereav_credit" value="1" type="checkbox" <?= $LEAVE_SETTINGS['bereav_credit'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto bereav-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap bereav-sections">Reason</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto bereav-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 bereav-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="bereav_reason" value="0">
                                                        <input class="switch_on" name="bereav_reason" value="1" type="checkbox" <?= $LEAVE_SETTINGS['bereav_reason'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto bereav-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap bereav-sections">Attachment</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto bereav-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 bereav-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="bereav_attachment" value="0">
                                                        <input class="switch_on" name="bereav_attachment" value="1" type="checkbox" <?= $LEAVE_SETTINGS['bereav_attachment'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto bereav-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                <?php else : ?>
                                <?php endif; ?>

                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                        <p class="col-md-6 mt-2"><span style="font-weight: 500;">Maternity Leave</span></p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center text-nowrap" style="margin-right: 3px;">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1">
                                                <label class="switch enable-switch mx-auto" data-section="maternity">
                                                    <input type="hidden" name="maternity_enable" value="0">
                                                    <input class="switch_on" name="maternity_enable" value="1" type="checkbox" <?= $LEAVE_SETTINGS['maternity_enable'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>


                                <?php if ($LEAVE_SETTINGS['maternity_enable'] == 1) : ?>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap maternity-sections">Use of Leave credits</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto maternity-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 maternity-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="maternitycredit" value="0">
                                                        <input class="switch_on" name="maternitycredit" value="1" type="checkbox" <?= $LEAVE_SETTINGS['maternitycredit'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto maternity-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap maternity-sections">Reason</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto maternity-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 maternity-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="maternityreason" value="0">
                                                        <input class="switch_on" name="maternityreason" value="1" type="checkbox" <?= $LEAVE_SETTINGS['maternityreason'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto maternity-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap maternity-sections">Attachment</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto maternity-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 maternity-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="maternityattachment" value="0">
                                                        <input class="switch_on" name="maternityattachment" value="1" type="checkbox" <?= $LEAVE_SETTINGS['maternityattachment'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto maternity-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                <?php else : ?>
                                <?php endif; ?>

                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                        <p class="col-md-6 mt-2"><span style="font-weight: 500;">Paternity Leave</span></p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center text-nowrap" style="margin-right: 3px;">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1">
                                                <label class="switch enable-switch mx-auto" data-section="paternity">
                                                    <input type="hidden" name="paternity_enable" value="0">
                                                    <input class="switch_on" name="paternity_enable" value="1" type="checkbox" <?= $LEAVE_SETTINGS['paternity_enable'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>


                                <?php if ($LEAVE_SETTINGS['paternity_enable'] == 1) : ?>
                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap paternity-sections">Use of Leave credits</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto paternity-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 paternity-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="paternity_credit" value="0">
                                                        <input class="switch_on" name="paternity_credit" value="1" type="checkbox" <?= $LEAVE_SETTINGS['paternity_credit'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto paternity-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap paternity-sections">Reason</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto paternity-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 paternity-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="paternity_reason" value="0">
                                                        <input class="switch_on" name="paternity_reason" value="1" type="checkbox" <?= $LEAVE_SETTINGS['paternity_reason'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto paternity-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap paternity-sections">Attachment</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto paternity-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 paternity-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="paternity_attachment" value="0">
                                                        <input class="switch_on" name="paternity_attachment" value="1" type="checkbox" <?= $LEAVE_SETTINGS['paternity_attachment'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto paternity-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                <?php else : ?>
                                <?php endif; ?>

                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                        <p class="col-md-6 mt-2"><span style="font-weight: 500;">Solo-Parent Leave</span></p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center text-nowrap" style="margin-right: 3px;">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1">
                                                <label class="switch enable-switch mx-auto" data-section="soloparent">
                                                    <input type="hidden" name="soloparent_enable" value="0">
                                                    <input class="switch_on" name="soloparent_enable" value="1" type="checkbox" <?= $LEAVE_SETTINGS['soloparent_enable'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($LEAVE_SETTINGS['soloparent_enable'] == 1) : ?>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap soloparent-sections">Use of Leave credits</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto soloparent-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 soloparent-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="soloparent_credit" value="0">
                                                        <input class="switch_on" name="soloparent_credit" value="1" type="checkbox" <?= $LEAVE_SETTINGS['soloparent_credit'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto soloparent-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap soloparent-sections">Reason</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto soloparent-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 soloparent-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="soloparent_reason" value="0">
                                                        <input class="switch_on" name="soloparent_reason" value="1" type="checkbox" <?= $LEAVE_SETTINGS['soloparent_reason'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto soloparent-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap soloparent-sections">Attachment</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto soloparent-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 soloparent-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="soloparent_attachment" value="0">
                                                        <input class="switch_on" name="soloparent_attachment" value="1" type="checkbox" <?= $LEAVE_SETTINGS['soloparent_attachment'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto soloparent-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>


                                <?php else : ?>
                                <?php endif; ?>


                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                        <p class="col-md-6 mt-2"><span style="font-weight: 500;">Marriage Leave</span></p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center text-nowrap" style="margin-right: 3px;">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1">
                                                <label class="switch enable-switch mx-auto" data-section="marriage">
                                                    <input type="hidden" name="marriage_enable" value="0">
                                                    <input class="switch_on" name="marriage_enable" value="1" type="checkbox" <?= $LEAVE_SETTINGS['marriage_enable'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>



                                <?php if ($LEAVE_SETTINGS['marriage_enable'] == 1) : ?>
                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap marriage-sections">Attachment</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto marriage-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 marriage-sections">
                                                    <label class="switch mx-auto ">
                                                        <input type="hidden" name="marriage_credit" value="0">
                                                        <input class="switch_on" name="marriage_credit" value="1" type="checkbox" <?= $LEAVE_SETTINGS['marriage_credit'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto marriage-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap marriage-sections">Reason</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto marriage-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 marriage-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="marriage_reason" value="0">
                                                        <input class="switch_on" name="marriage_reason" value="1" type="checkbox" <?= $LEAVE_SETTINGS['marriage_reason'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto marriage-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap marriage-sections">Attachment</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto marriage-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 marriage-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="marriage_attachment" value="0">
                                                        <input class="switch_on" name="marriage_attachment" value="1" type="checkbox" <?= $LEAVE_SETTINGS['marriage_attachment'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto marriage-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>


                                <?php else : ?>
                                <?php endif; ?>

                                <div class="col-md-12">
                                    <hr>
                                </div>


                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                        <p class="col-md-6 mt-2"><span style="font-weight: 500;">Emergency Leave</span></p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center text-nowrap" style="margin-right: 3px;">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1">
                                                <label class="switch enable-switch mx-auto" data-section="emergency">
                                                    <input type="hidden" name="emergency_enable" value="0">
                                                    <input class="switch_on" name="emergency_enable" value="1" type="checkbox" <?= $LEAVE_SETTINGS['emergency_enable'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>


                                <?php if ($LEAVE_SETTINGS['emergency_enable'] == 1) : ?>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap emergency-sections">Use of Leave Credits</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto emergency-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 emergency-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="emergency_credit" value="0">
                                                        <input class="switch_on" name="emergency_credit" value="1" type="checkbox" <?= $LEAVE_SETTINGS['emergency_credit'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto emergency-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap emergency-sections">Reason</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto emergency-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 emergency-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="emergency_reason" value="0">
                                                        <input class="switch_on" name="emergency_reason" value="1" type="checkbox" <?= $LEAVE_SETTINGS['emergency_reason'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto emergency-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap emergency-sections">Attachment</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto emergency-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 emergency-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="emergency_attachment" value="0">
                                                        <input class="switch_on" name="emergency_attachment" value="1" type="checkbox" <?= $LEAVE_SETTINGS['emergency_attachment'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto emergency-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                <?php else : ?>
                                <?php endif; ?>


                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="col-12 m-0 pr-0">
                                    <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                        <p class="col-md-6 mt-2"><span style="font-weight: 500;">Other Leave Types</span></p>
                                        <div class="col-12 col-lg-6 row d-flex justify-content-center text-nowrap" style="margin-right: 3px;">
                                            <p class="col-4 col-lg-3 mt-1 ml-auto" style="text-align: right;">Disable</p>
                                            <div class="col-4 col-lg-3 mt-1">
                                                <label class="switch enable-switch mx-auto" data-section="others">
                                                    <input type="hidden" name="other_enable" value="0">
                                                    <input class="switch_on" name="other_enable" value="1" type="checkbox" <?= $LEAVE_SETTINGS['other_enable'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                </label>
                                            </div>
                                            <p class="col-4 col-lg-3 mt-1 mr-auto">Enable</p>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($LEAVE_SETTINGS['other_enable'] == 1) : ?>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap other-sections">Use of Leave Credits</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto other-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 other-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="other_credit" value="0">
                                                        <input class="switch_on" name="other_credit" value="1" type="checkbox" <?= $LEAVE_SETTINGS['other_credit'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto other-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap other-sections">Reason</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto other-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 other-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="other_reason" value="0">
                                                        <input class="switch_on" name="other_reason" value="1" type="checkbox" <?= $LEAVE_SETTINGS['other_reason'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto other-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 pr-0">
                                        <div class="col-12 row d-flex justify-content-center justify-content-lg-between align-items-center">
                                            <p class="col-12 col-lg-3 mt-2 mr-auto ml-lg-3 text-nowrap other-sections">Attachment</p>
                                            <div class="col-12 col-lg-6 row d-flex justify-content-center mr-0 mr-lg-1 text-nowrap">
                                                <p class="col-4 col-lg-3 mt-1 ml-auto other-sections" style="text-align: right;">Not Required</p>
                                                <div class="col-4 col-lg-3 mt-1 other-sections">
                                                    <label class="switch mx-auto">
                                                        <input type="hidden" name="other_attachment" value="0">
                                                        <input class="switch_on" name="other_attachment" value="1" type="checkbox" <?= $LEAVE_SETTINGS['other_attachment'] == 1 ? 'checked' : '' ?>><span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <p class="col-4 col-lg-3 mt-1 mr-auto other-sections">Required</p>
                                            </div>
                                        </div>
                                    </div>

                                <?php else : ?>
                                <?php endif; ?>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                                <div class="col-12 mt-2 d-flex justify-content-end">
                                    <button type="button" class="btn btn-danger py-1 clear_changes mr-2 d-flex align-items-center" id="btn-update" style="font-size: 14px">
                                        <img class="" style="height: 1.1rem; width: 1.1rem; " src="<?= base_url('assets_system/icons/circle-x-solid_mark_as.svg') ?>">&nbsp;Clear Changes
                                    </button>

                                    <!-- <button type="submit" class="btn btn-primary pt-1 pb-1 submit_form d-flex align-items-center" id="btn-update" style="font-size: 14px">
                                        <img class="" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>">&nbsp;Save Changes
                                    </button> -->

                                </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    <?php $this->load->view('templates/jquery_link'); ?>
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
    <script>
        $(document).ready(function() {

            $('input[name$="_enable"]').change(function() {
                var sectionName = $(this).attr('name').replace('_enable', '');

                toggleSections(sectionName);
            });


            function toggleSections(sectionName) {
                var enableSwitch = $('input[name="' + sectionName + '_enable"]');
                var sections = $('.' + sectionName + '-sections');

                if (enableSwitch.is(':checked')) {
                    sections.show();
                } else {
                    sections.hide();
                }
            }

        });
    </script>

    <?php
    if ($this->session->userdata('SESS_UPDATE')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_UPDATE'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_UPDATE');
    }
    ?>

    <?php
    if ($this->session->userdata('SESS_SUCC_UPDATE')) {
    ?>
        <script>
            $(document).Toasts('create', {
                class: 'bg-success toast_width',
                title: 'Success',
                subtitle: 'close',
                body: '<?php echo $this->session->userdata('SESS_SUCC_UPDATE'); ?>'
            })
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_UPDATE');
    }
    ?>

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
        $(document).ready(function() {
            $(document).on('click', 'button.clear_changes', function() {
                window.location.reload();
            });

            $(document).on('click', 'button.submit_form', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Update leave settings",
                    text: "Confirm to save the settings",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Confirm"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('form').submit();
                    }
                });
            });


            $('.enable-switch input.switch_on').click(function(e) {
                localStorage.setItem('clickedScrollPosition', $(window).scrollTop());
            });


            $(document).ready(function() {

                var clickedScrollPosition = localStorage.getItem('clickedScrollPosition');
                if (clickedScrollPosition !== null) {



                    localStorage.removeItem('clickedScrollPosition');
                }
            });


            $('.enable-switch input.switch_on').change(function(e) {
                e.preventDefault();
                $('form').submit();
            });


        });
    </script>

    <!-- <script>
        var url = '<?= base_url() ?>';
        var parsedData = <?php echo $DATA_LIST; ?>;

        console.log('parsedData', parsedData)

        var tableName = 'tbl_std_leavetypes';
        var hot;
        let column_headers = "";
        let columns = "";

        // Custom renderer to prevent text wrapping
        const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.whiteSpace = 'nowrap';
            td.style.overflow = 'hidden';
        };

        column_headers = ['Id', 'Name', 'Status'];
        columns = [{
                data: 'id'
            }, {
                data: 'name'
            },
            {
                data: 'status',
                type: 'dropdown',
                source: ['Active', 'Inactive'],
            },
        ]

        const container = document.querySelector('#data_table');
        hot = new Handsontable(container, {
            data: parsedData,
            colHeaders: column_headers,
            rowHeaders: true,
            stretchH: 'all',
            height: 'auto',
            rowHeights: 40,
            outsideClickDeselects: false,
            selectionMode: 'multiple',
            licenseKey: 'non-commercial-and-evaluation',
            renderer: customStyleRenderer,
            hiddenColumns: {
                columns: [0],
                indicators: true,
                // exclude hidden columns from copying and pasting
                copyPasteEnabled: false,
            },
            columns: columns,
            minRows: 1,
        });


        function generateYearDropdownSource() {
            const currentYear = new Date().getFullYear();
            const years = [];
            // range of years
            for (let i = currentYear; i >= currentYear - 3; i--) {
                years.push(i.toString());
            }
            return years;
        }

        function setHeightTo500px() {
            const currentHeight = hot.rootElement.clientHeight;
            if (currentHeight >= 500) {
                hot.updateSettings({
                    height: 500
                });
            }
        }

        // add row ===========================================================================
        const addRowButton = document.getElementById('btn-add-row');
        addRowButton.addEventListener('click', function() {
            const selected = hot.getSelected() || [];

            if (selected.length === 0) {
                alert('Please select a row to add a new row below.');
                return;
            }
            // Get the index of the first selected row
            const selectedIndex = selected[0][0];

            hot.alter('insert_row_below', selectedIndex);
            setHeightTo500px();
        });

        // delete row ==========================================================================
        const deleteRowButton = document.getElementById('btn-delete-row');
        deleteRowButton.addEventListener('click', function() {
            const selectedRows = hot.getSelected() || [];


            if (selectedRows.length === 0) {
                alert('No rows selected. Please select rows to delete.');
                return;
            }

            if (selectedRows.length > 0) {
                const confirmed = confirm('Are you sure you want to delete the selected row?');
                if (confirmed) {

                    // Create an array to hold unique row indices
                    const rowsToDelete = new Set();

                    // Iterate through each selected range and add row indices to the set
                    selectedRows.forEach(range => {
                        const [row1, _column1, row2, _column2] = range;
                        for (let rowIndex = Math.min(row1, row2); rowIndex <= Math.max(row1, row2); rowIndex++) {
                            rowsToDelete.add(rowIndex);
                        }
                    });

                    // Convert the set to an array and sort it in descending order
                    const sortedRowsToDelete = Array.from(rowsToDelete).sort((a, b) => b - a);

                    // Delete rows in the sorted order
                    sortedRowsToDelete.forEach(rowIndex => {
                        hot.alter('remove_row', rowIndex);
                    });

                    hot.deselectCell();

                }
            }
            setHeightTo500px();
        });
        setHeightTo500px();
        // update data ================================================================================== 

        const col_status = [{
            name: 'Active'
        }, {
            name: 'Inactive'
        }, ];
        const col_type = [{
            name: 'Fixed'
        }, {
            name: 'Attendance'
        }, ];

        var update = document.getElementById('btn-update');
        update.addEventListener('click', function() {
            const confirmed = confirm('Are you sure you want to upload the data?');
            if (!confirmed) {
                return;
            }

            const updatedData = hot.getData();

            // check if rows is empty
            const hasEmptyRow = updatedData.some(row => row.slice(1).some(cell => (cell == '' || cell == null)));
            if (hasEmptyRow) {
                alert('Cannot upload empty rows.');
                return;
            }

            // validate type
            function validateType(row, rowIndex, tableColumn, title) {
                const validData = tableColumn.map(data => data.name);
                if (!validData.includes(row)) {
                    shouldProceed = false;
                    alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
                }
            }

            // validate data
            function validateData(row, rowIndex, tableColumn, title) {
                const validPositions = tableColumn.map(division => division.name);
                if (!validPositions.includes(row)) {
                    shouldProceed = false;
                    alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
                }
            }

            // validate year
            function validateYear(row, rowIndex, tableColumn, title) {
                const validPositions = tableColumn.map(date => date);
                if (!validPositions.includes(row)) {
                    shouldProceed = false;
                    alert(`${title} in row ${rowIndex + 1} is not valid. Please select a valid ${title.toLowerCase()}.`);
                }
            }


            let shouldProceed = true;
            updatedData.forEach((row, rowIndex) => {
                if (tableName == "tbl_std_allowances_tax" || tableName == "tbl_std_allowances_nontax" || tableName == "tbl_std_deductions_nontax" || tableName == "tbl_std_deductions_tax") {
                    validateType(row[3], rowIndex, col_type, 'Type');
                } else if (tableName == "tbl_biometrics") {
                    validateData(row[3], rowIndex, col_status, 'Status');
                } else if (tableName == "tbl_std_holidays") {
                    const date = new Date(row[1]);
                    const year = date.getFullYear();

                    validateYear(year.toString(), rowIndex, generateYearDropdownSource(), 'Date');
                    validateYear(row[4], rowIndex, generateYearDropdownSource(), 'Year');
                    validateData(row[5], rowIndex, col_status, 'Status');

                    if (row[4] != year.toString()) {
                        shouldProceed = false;
                        alert(`Please make sure the dates in row ${rowIndex + 1} are for the same year.`);
                    }
                } else {
                    validateData(row[2], rowIndex, col_status, 'Status');
                }

            });

            if (!shouldProceed) {
                return;
            }

            const requestData = {
                updatedData: updatedData,
                tableName: tableName
            };

            // insert data
            fetch(url + 'main_table_01/update_data', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(requestData)
                })
                .then(response => response.json())
                .then(result => {

                    if (result.success_message) {
                        $(document).Toasts('create', {
                            class: 'bg-success toast_width',
                            title: 'Success!',
                            subtitle: 'close',
                            body: result.success_message
                        })
                    }

                    if (result.warning_message) {
                        $(document).Toasts('create', {
                            class: 'bg-warning toast_width',
                            title: 'Warning!',
                            subtitle: 'close',
                            body: result.warning_message
                        })
                    }

                })
                .catch(error => {
                    $(document).Toasts('create', {
                        class: 'bg-warning toast_width',
                        title: 'Warning!',
                        subtitle: 'close',
                        body: 'Please provide all required information.'
                    })
                    console.error('Data update error:', error);
                });
        });
    </script> -->
    <script>
        $(document).ready(function() {

            $('#settingsDropdown').on('change', function() {
                var selectedValue = $(this).val();

                if (selectedValue === 'leave_policies') {
                    window.location.href = '<?= base_url('leaves/settings_leavepolicies') ?>';
                }
                if (selectedValue === 'leave_types') {
                    window.location.href = '<?= base_url('leaves/settings_leavetypes') ?>';
                }



            });
        });
    </script>