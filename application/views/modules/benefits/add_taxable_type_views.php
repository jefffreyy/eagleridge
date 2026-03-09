<?php $this->load->view('templates/css_link'); ?>

<style>
    .calendar-table {
        display: none !important;
    }

    table {
        border-collapse: collapse;
        /* width: 50%;
        margin: 20px; */
    }

    table,
    th,
    td {
        border: 1px solid #0000000f;
    }

    th,
    td {
        /* padding: 10px; */
        width: 30%;
    }

    .circle-button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #3498db;
        /* Change the background color as desired */
        color: #ffffff;
        /* Change the text color as desired */
        font-size: 24px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }
</style>

<div class="content-wrapper" style="min-height: 624px;">
    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="<?= base_url() . 'benefits/taxable_type'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
        </div>
    </div>
    <div class="container-fluid px-4">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <form  action="<?= base_url('benefits/insert_taxable_types')?>" method="post" id="" style="width:100%">
                                <div class="col-md-12">
                          
                                    <div class="form-group">
                                        <label class="">Name</label>
                                        <input type="text" class="form-control " name="name" id="name" required >
                                    </div>
                                    <div class="form-group">
                                        <label class="">Type</label>
                                        <select class="form-control" name="type" id="type" enabled="">
                                            <option value='One-Time' >One-Time</option>
                                            <option value='Attendance' >Attendance</option>
                                        </select>
                                    </div>
                                    <div class="mr-2" style="float: right !important">
                                        <input type='submit'  class="btn technos-button-blue shadow-none rounded "  value="Submit"> 
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
<?php $this->load->view('templates/jquery_link'); ?>

<?php

if ($this->session->flashdata('SUCC')) { ?>
    <!-- <script>
        Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>', '', 'success')
    </script> -->
    <script>
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('SUCC'); ?>'
        })
    </script>
<?php } ?>

<?php if ($this->session->flashdata('ERR')) { ?>
    <script>
        Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>', '', 'error')
    </script>
<?php } ?>

