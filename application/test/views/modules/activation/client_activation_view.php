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
        margin-top: 15px;
        /* margin-top: 79px; */
        
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

    .header_section .logo img{
        height: 70px;
    }

    .input{
        display: flex;
        justify-content: center;
    }

    .form-content form .input p{
        padding: 7px;
        width: 250px;
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
            <div class="form">
                <div class="header">
                    <h3>Getting Started</h3>
                </div>
                <p class="header_line"></p>
                <div class="body">
                    <div class="title">
                        <p>1. Administrator Account Setup</p>
                    </div>
                    <div class="form-content">

                        <form action="<?=base_url().'client_activation/add_account';?>" method="POST" accept-charset="utf-8" autocomplete='off'>
                        
                            <div class="input">
                                <p>Employee Number</p>
                                <input class="form-control" type="text" name="empl_no" id="empl_no" placeholder="Enter Employee Number">
                            </div>

                            <div class="input">
                                <p>First Name</p>
                                <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Enter First Name">
                            </div>

                            <div class="input">
                                <p>Middle Name</p>
                                <input class="form-control" type="text" name="midlname" id="midlname" placeholder="Enter Middle Name">
                            </div>

                            <div class="input">
                                <p>Last Name</p>
                                <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Enter Last name">
                            </div>

                            <div class="input">
                                <p>Username</p>
                                <input class="form-control" type="text" name="username" id="username" placeholder="Enter Username">
                            </div>
                            
                            <div class="input">
                                <p>Password</p>
                                <input class="form-control" type="password" name="password" id="password" placeholder="Enter Password">
                            </div>
                            
                            <div class="input">
                                <p>Confirm Password</p>
                                <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="Enter Confirm Password">
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

    <?php
    if ($this->session->userdata('SESS_ERROR_MSG')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_ERROR_MSG'); ?>',
                '',
                'error'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_ERROR_MSG');
    }
    ?>
</body>
