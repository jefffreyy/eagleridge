<?php $this->load->view('templates/css_link'); ?>
<style>
    .content{
        margin: 0;
        padding: 0;
        box-sizing: border-box
    }

    .content_section{
        display: flex;
        justify-content: center;
        margin-top: 220px;
        
    } 

    .content_section .message{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        border: 1px solid gray;
        border-radius: 15px;
        padding: 25px;
    }

    .header_section .logo{
        margin: 12px;
    }

    .header_section .logo img{
        height: 70px;
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
            <div class="message">
                <h3>Site not yet activated</h3>
                <p>Contact Eyebox Representative for activation</p>
            </div>
        </div>
    </div>
    
</body>
