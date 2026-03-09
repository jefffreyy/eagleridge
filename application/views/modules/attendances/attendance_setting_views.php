<?php $this->load->view('templates/css_link'); ?>
<style>
    body,html{
        height:100%;
    }
</style>
<div class="content-wrapper h-100 ">
    <div class="container-fluid h-100 p-4 ">
        <h1 class="page-title"><a href="<?= base_url().'employees';?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Attendance Settings </h1>
        <div class="card w-75 h-100 shadow-sm m-auto ">
            <div class="row">
                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                      <a class="nav-link active" id="v-pills-gen_settings-tab" data-toggle="pill" href="?tab=ge" role="tab" aria-controls="v-pills-gen_settings" aria-selected="true">General Settings</a>
                      <!--<a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>-->
                      <!--<a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</a>-->
                      <!--<a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>-->
                    </div>
                </div>
                <div class="col">
                    <div class="tab-content" id="v-pills-tabContent">
                      <div class="tab-pane fade show active" id="v-pills-gen_settings" role="tabpanel" aria-labelledby="v-pills-gen_settings-tab">
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
                      <!--<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">...</div>-->
                      <!--<div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>-->
                      <!--<div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>-->
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</div>