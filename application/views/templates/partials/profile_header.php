<div class="p-0">
    <div class="profile d-flex  align-items-center p-0">
        <div class="profile-pic m-0 p-0">
            <img class="rounded-circle avatar m-3 img-responsive" id="employee_img" style="cursor: pointer;" width="100" height="100" src="<?php if ($user_image) {
                                                                                                                            echo base_url() . 'assets_user/user_profile/' . $user_image;
                                                                                                                        } else {
                                                                                                                            echo base_url() . 'assets_system/images/default_user.jpg';
                                                                                                                        } ?>">
        </div>
        <div class="basic-profile">
            <div class="d-flex align-items-center">
                <p class="emp-name text-bold m-0 "><?= $full_name ?></p>
                <?php
                if ($is_active > 0) {
                ?>
                    <p class="badge badge-danger d-block ml-2 mt-3">Inactive</p>
                <?php
                } else {
                ?>
                    <p class="badge badge-success d-block ml-2 mt-3">Active</p>
                <?php
                }
                ?>
            </div>
            <div class="emp-stat m-0 d-flex flex-column p-0">
                <p class="stats m-0"><?= $position ?></p>
                <p class="stats m-0"><?= $department ?></p>
            </div>
        </div> 
    </div>
    
</div>