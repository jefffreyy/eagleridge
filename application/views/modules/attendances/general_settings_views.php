<?php $this->load->view('templates/companycontribution_style'); ?>
<?php $this->load->view('templates/css_link'); ?>


<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="flex-fill">

            <div class="row p-0">
                <div class="col-md-6">
                    <h1 class="page-title"><a href="<?= base_url() . 'attendances'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;Attendance Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>

            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
                <div class="card col-xl-8 col-lg-4 col-md-8 col-8" style="min-height:700px ">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?php $this->load->view('templates/settings_time_and_attendance_nav_views'); ?>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12">
                                    <span style="font-weight: 500; font-size: 18px">General Settings</span>
                                </div>
                           
                                <div class="col-md-12">
                                    <!-- <i>Note: LWOP, Offset, Vacation, Sick Leaves are permanent leave types.</i> -->
                                </div>
                            </div>
                            <hr>
                            <div class="row justify-content-center">
                                <!-- <div class="col-md-12 mb-3">
                                    <button class="btn btn-success pt-1 pb-1" id="btn-add-row" style="font-size: 14px"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-plus-solid_xs.svg') ?>">&nbsp;Add Row</button>
                                    <button class="btn btn-danger pt-1 pb-1" id="btn-delete-row" style="font-size: 14px"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-minus-solid_xs.svg') ?>">&nbsp;Delete Row</button>
                                    <button class="btn btn-primary pt-1 pb-1" id="btn-update" style="font-size: 14px"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>">&nbsp;Save Record</button>
                                </div> -->

                                <div class="col-md-12">
                                    <form>
                                        <div class="row">
                                            <div class="col col-md-6 m-1">
                                                    <div class="form-group">
                                                        <label>Grace Period</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control " name="grace_period" />
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary" type="submit">Update</button>
                                                            </div>
                                                        </div>    
                                                    </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<aside class="control-sidebar control-sidebar-dark">
</aside>
<?php $this->load->view('templates/jquery_link'); ?>