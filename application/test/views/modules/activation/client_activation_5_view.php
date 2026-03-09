<?php $this->load->view('templates/css_link'); ?>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        /* outline: 1px solid blue; */
    }
    .content{
        
    }
    .content_section{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin-top: 15px;
        
    } 
    .content_section .form{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        border: 1px solid gray;
        border-radius: 15px;
        padding: 25px;
        width: 508px;
    }
    .header_section .logo{
        margin: 12px;
    }
    .body{
        width: 100%;
    }

    .header_section .logo img{
        height: 70px;
    }

    .header_line{
        border: 1px solid rgb(210, 210, 210);
        margin-top: 20px;
        width: 100%;
    }

    .body .title{
        font-weight: 500;
        margin-bottom: 20px;
    }

    .input{
        display: flex;
        justify-content: start;
        align-items: center;
    }

    .input .category{
        width: 140px;
    }

    .category_name {
        width: 50px;
    }

    .input .category_name{
        display: flex;
        justify-content: start;
        align-items: center;
        margin: 0 20px;
    }
    .category_name input{
        margin-bottom: 15px;
        margin-right: 5px;
    }
    .btn{
        padding: 0;
        margin-top: 25px;
        float: right;
    }
    .btn input{
        padding: 5px 20px;
    }
    

</style>
<body>
    <div class="content">
        <div class="header_section">
            <div class="logo">
                <img src="<?=base_url().'assets_system/images/activation_logo.png'; ?>" alt="">
            </div>
        </div>
        
        <div class="content_section">

            <nav aria-label="breadcrumb" style="width: 508px">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>client_activation/setup_4">Previews
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Other Settings
                    </li>
                </ol>
            </nav>


            <div class="form">
                <div class="header">
                    <h3>Getting Started</h3>
                </div>
                <p class="header_line"></p>
                <div class="body">
                    <div class="title">
                        <p>6. Other Settings</p>
                    </div>
                    <div class="form-content">
                        <form action="<?=base_url().'client_activation/site_restriction';?>" method="post" accept-charset="utf-8" class="p-0">
                            <div class="input">
                                <p class="category">Site Access</p>
                                <div class="category_name">
                                    <input type="radio" id="site_access" name="site_access" value="0" checked>
                                    <p>Public</p>
                                </div>
                                <div class="category_name">
                                    <input type="radio" id="site_access" name="site_access" value="1">
                                    <p>Private</p>
                                </div>
                            </div>

                            <div class="input">
                                <p  class="category">IP&nbsp;Address</p>
                                <input class="form-control" type="text" name="ip_address" id="ip_address" placeholder="Enter IP Address" disabled>
                            </div>

                            <div class="input">
                                <p class="category">Remote Attendance</p>
                                <div class="category_name">
                                    <input type="radio" id="remote" name="remote" value="1" checked>
                                    <p>Disabled</p>
                                </div>
                                <div class="category_name">
                                    <input type="radio" id="remote" name="remote" value="0">
                                    <p>Enable</p>
                                </div>
                            </div>

                            <div class="input">
                                <p class="category">Forgot Password</p>
                                <div class="category_name">
                                    <input type="radio" id="forgot_pass" name="forgot_pass" value="0" checked>
                                    <p>By&nbsp;Email</p>
                                </div>
                                <div class="category_name">
                                    <input type="radio" id="forgot_pass" name="forgot_pass" value="1">
                                    <p>By&nbsp;HR</p>
                                </div>
                                <div class="category_name">
                                    <input type="radio" id="forgot_pass" name="forgot_pass" value="2">
                                    <p>By&nbsp;Email&nbsp;or&nbsp;HR</p>
                                </div>
                            </div>
                            
                            <div class="btn">
                                <input class="btn btn-success"  type="submit" name="btn-submit" value="Next">
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('templates/jquery_link'); ?>
    <script>

    // Get the radio buttons
    var publicRadio = document.querySelector('input[name="site_access"][value="0"]');
    var privateRadio = document.querySelector('input[name="site_access"][value="1"]');
    var ip_address = document.getElementById("ip_address");

    // Add an event listener to the private radio button
    privateRadio.addEventListener('click', function() {
        // Select the private radio button and uncheck the public radio button
        privateRadio.checked = true;
        publicRadio.checked = false;
        ip_address.disabled = false;
    });

    publicRadio.addEventListener('click', function() {
        // Select the private radio button and uncheck the public radio button
        privateRadio.checked = false;
        publicRadio.checked = true;
        ip_address.disabled = true;
    });

  

        $(function() {
            function update_nav_logo(uploader) {
                if (uploader.files && uploader.files[0]) {
                    $('#preview_nav_logo').text(uploader.files[0].name);
                }
            }
            $("#update_nav_logo").change(function() {
                update_nav_logo(this);
            });
        });
    </script>

</body>
