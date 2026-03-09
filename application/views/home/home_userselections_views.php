<?php $this->load->view('templates/css_link'); ?>
<html>

<body style="overflow: hidden; height: 100%; width: 100%;" ontouchmove="BlockMove(event);">

    <div style="width: 1920px; height: 1080px; position: relative">

        <a href="<?= base_url() ?>home/registration">
            <div style="width: 480px; height: 300px; left: 466px; top: 390px; position: absolute; background: linear-gradient(180deg, #FFC000 0%, #DCA600 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
            <div style="width: 480px; height: 62px; left: 466px; top: 509px; position: absolute; text-align: center; color: white; font-size: 48px; font-family: Lato; font-weight: 700; word-wrap: break-word">I’m New</div>
        </a>

        <a href="<?= base_url() ?>home/login">
            <div style="width: 480px; height: 300px; left: 974px; top: 390px; position: absolute; background: linear-gradient(180deg, #92D050 0%, #53A100 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
            <div style="width: 480px; height: 62px; left: 974px; top: 509px; position: absolute; text-align: center; color: white; font-size: 48px; font-family: Lato; font-weight: 700; word-wrap: break-word">I have an account</div>
        </a>

        <div style="width: 1000px; height: 91px; left: 460px; top: 35px; position: absolute; background: #E3E3E3; border-radius: 20px"></div>
        <div style="width: 480px; height: 62px; left: 720px; top: 46px; position: absolute; text-align: center; color: #070707; font-size: 48px; font-family: Lato; font-weight: 600; word-wrap: break-word">Account Selection</div>
        <div style="width: 1191px; height: 33px; left: 364px; top: 150px; position: absolute; text-align: center; color: #070707; font-size: 32px; font-family: Lato; font-weight: 400; word-wrap: break-word">Please select appropriate option</div>
    </div>

</body>
<script>
    function BlockMove(event) {
        event.preventDefault();
    }
</script>

</html>