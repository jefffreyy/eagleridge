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
    .body{
        width: 100%;
    }
    .header_section .logo{
        margin: 12px;
    }

    .header_section .logo img{
        height: 70px;
    }

    .input{
        display: flex;
        justify-content: center;
    }

    .form-content form .input p{
        padding: 7px;
        width: 240px;
    }

    .body .title{
        font-weight: 500;
        margin-bottom: 50px;
    }

    .btn{
        padding: 0;
        margin-top: 25px;
        float: right;
    }
    .btn input{
        padding: 5px 20px;
    }
    .header_line{
        border: 1px solid rgb(210, 210, 210);
        margin-top: 20px;
        width: 100%;
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
                        <a href="<?= base_url() ?>client_activation">Previews
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Organizational Company Setup (1/2)
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
                        <p>2. Organizational Company Setup (1/2)</p>
                    </div>
                    <div class="form-content">
                        <form action="<?=base_url().'client_activation/update_company_name'?>"  method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">

                            <div class="input">
                                <p>Company Name</p>
                                <input class="form-control" type="text" name="update_comp_name" id="update_comp_name" value="<?= $DISP_COMPANY_NAME['value'] ?>">
                            </div>
                            
                            <div class="input">
                                <p>Company Logo</p>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input fileficker" id="update_nav_logo" name="update_nav_logo" multiple="" accept=".jpg, .jpeg, .png">
                                        <label class="custom-file-label" id="preview_nav_logo" for="update_nav_logo">Choose file
                                        </label>
                                    </div>
                                    <div class="row mt-1 image">
                                        <img style="width:160px; object-fit:contain" src="<?= base_url() ?>assets_system/images/<?= $DISP_NAVBAR_LOGO['value']; ?>">
                                        <p>Will be used in side menu</p>
                                    </div>
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
