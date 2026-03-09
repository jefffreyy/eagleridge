<?php $this->load->view('templates/css_link'); ?>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .content {}

    .content_section {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin-top: 15px;

    }

    .content_section .form {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        border: 1px solid gray;
        border-radius: 15px;
        padding: 25px;
        width: 508px;
    }

    .header_section .logo {
        margin: 12px;
    }

    .header_section .logo img {
        height: 70px;
    }

    .input {
        display: flex;
        justify-content: center;
    }

    .body {
        width: 100%;
    }

    .form-content form .input p {
        padding: 7px;
        width: 250px;
    }

    .body .title {
        font-weight: 500;
        margin-bottom: 50px;
    }

    .btn {
        padding: 0;
        margin-top: 25px;
        float: right;
    }

    .btn input {
        padding: 5px 20px;
    }

    .header_line {
        border: 1px solid rgb(210, 210, 210);
        margin-top: 20px;
        width: 100%;
    }
</style>

<body>
    <div class="content">
        <div class="header_section">
            <div class="logo">
                <img src="<?= base_url() . 'assets_system/images/activation_logo.png'; ?>" alt="">
            </div>
        </div>

        <div class="content_section">

            <nav aria-label="breadcrumb" style="width: 508px">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>client_activation/setup_3">Previews
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Date Coverage
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
                        <p>4. Date Coverage</p>
                    </div>
                    <div class="form-content">
                        <form action="<?= base_url() . 'client_activation/date_coverage'; ?>" method="post" accept-charset="utf-8" class="p-0">

                            <div class="input">
                                <p>Month Label</p>
                                <input class="form-control" type="text" name="label" id="label" placeholder="Enter Label">
                            </div>

                            <div class="input">
                                <p>Date From</p>
                                <input class="form-control" type="date" name="date_from" id="date_from" placeholder="Date">
                            </div>

                            <div class="input">
                                <p>Date To</p>
                                <input class="form-control" type="date" name="date_to" id="date_to" placeholder="Date">
                            </div>

                            <div class="input">
                                <p>Pay Period</p>
                                <input class="form-control" type="date" name="pay_period" id="pay_period" placeholder="Date">
                            </div>

                            <div class="input">
                                <p>Year</p>
                                <input class="form-control" type="number" name="year" id="year" placeholder="Enter Year">
                            </div>

                            <div class="btn">
                                <input class="btn btn-success" type="submit" name="btn-submit" value="Next">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>