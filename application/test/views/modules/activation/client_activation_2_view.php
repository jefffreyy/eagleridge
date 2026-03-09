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

    .header_line{
        border: 1px solid rgb(210, 210, 210);
        margin-top: 20px;
        width: 100%;
    }

    .body .title{
        font-weight: 500;
        margin-bottom: 50px;
    }

    .input{
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .input .category{
        width: 200px;
    }

    .input .category_name{
        display: flex;
        justify-content: center;
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
                        <a href="<?= base_url() ?>client_activation/setup_1">Previews
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Organizational Company Setup (2/2)
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
                        <p>2. Organizational Company Setup (2/2)</p>
                    </div>
                    <div class="form-content">
                        <form action="<?=base_url().'client_activation/update_organization';?>" method="post" accept-charset="utf-8" class="p-0" >

                            <div class="input">
                                <p class="category">Branch</p>
                                <div class="category_name">
                                    <input type="radio" id="branch" name="branch" value="0">
                                    <p>Disabled</p>
                                </div>
                                <div class="category_name">
                                    <input type="radio" id="branch" name="branch" value="1">
                                    <p>Enable</p>
                                </div>
                            </div>

                            <div class="input">
                                <p class="category">Department</p>
                                <div class="category_name">
                                    <input type="radio" id="dept" name="dept" value="0">
                                    <p>Disabled</p>
                                </div>
                                <div class="category_name">
                                    <input type="radio" id="dept" name="dept" value="1">
                                    <p>Enable</p>
                                </div>
                            </div>

                            <div class="input">
                                <p class="category">Division</p>
                                <div class="category_name">
                                    <input type="radio" id="division" name="division" value="0">
                                    <p>Disabled</p>
                                </div>
                                <div class="category_name">
                                    <input type="radio" id="division" name="division" value="1">
                                    <p>Enable</p>
                                </div>
                            </div>

                            <div class="input">
                                <p class="category">Section</p>
                                <div class="category_name">
                                    <input type="radio" id="sect" name="sect" value="0">
                                    <p>Disabled</p>
                                </div>
                                <div class="category_name">
                                    <input type="radio" id="sect" name="sect" value="1">
                                    <p>Enable</p>
                                </div>
                            </div>

                            <div class="input">
                                <p class="category">Group</p>
                                <div class="category_name">
                                    <input type="radio" id="group" name="group" value="0">
                                    <p>Disabled</p>
                                </div>
                                <div class="category_name">
                                    <input type="radio" id="group" name="group" value="1">
                                    <p>Enable</p>
                                </div>
                            </div>

                            <div class="input">
                                <p class="category">Team</p>
                                <div class="category_name">
                                    <input type="radio" id="team" name="team" value="0">
                                    <p>Disabled</p>
                                </div>
                                <div class="category_name">
                                    <input type="radio" id="team" name="team" value="1">
                                    <p>Enable</p>
                                </div>
                            </div>

                            <div class="input">
                                <p class="category">Line</p>
                                <div class="category_name">
                                    <input type="radio" id="line" name="line" value="0">
                                    <p>Disabled</p>
                                </div>
                                <div class="category_name">
                                    <input type="radio" id="line" name="line" value="1">
                                    <p>Enable</p>
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
