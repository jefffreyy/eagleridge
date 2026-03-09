<?php $this->load->view('templates/css_link'); ?>
<style>
    .switch {
        position: relative;
        display: block;
        width: 50px;
        height: 26px;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .switch input {
        display: none;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 21px;
        width: 21px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50px;
    }

    input:checked+.slider:before {
        background-color: limegreen;
    }

    input:checked+.slider:before {
        transform: translateX(23px);
    }
    input[type=number] {
  display: flex;
  justify-content: center;
  align-items: center;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
<div class="content-wrapper">

    <div class="container-fluid p-4">
        <div class="row mb-2">
            <!-- Title Text -->
            <div class="col d-flex align-items-center">
                    <a href="<?= base_url() . 'superadministrators'; ?>"><img style="width: 32px; height: 32px; margin: 0 7px 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>
                    <h1 class="page-title d-inline">Configuration</h1>
                </div>
            <div class="col-md-6" style="text-align: right;">
            </div>
        </div>
        <hr>
        <!-- Title Header Line -->
        <div class="row">
            <div class="card col-xl-3 col-lg-4 col-md-6 col-12 ml-2">
                <form action="<?php echo base_url() . 'superadministrators/update_maintenance'; ?>" method="post" accept-charset="utf-8" class="p-1">
                    <div class="card-header mt-0 p-0">
                        <strong> Maintenance </strong>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <div class="form-group">
                            <label class="switch p-0">
                                <input type="hidden" name="id" value="<?= $C_MAINTENANCE[40]->id ?>">
                                <input class="switch_on p-0" type="checkbox" <?= $C_MAINTENANCE[40]->value == '1' ? 'checked' : ''; ?> name="main_on" onchange="this.form.submit()">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </form>
                
                <!-- C_MAINTENANCE -->
            </div>
            <div class="card  col-xl-3 col-lg-4 col-md-6 col-12 ml-2">
                <form action="<?php echo base_url() . 'superadministrators/time_out'; ?>" method="post" accept-charset="utf-8" class="p-1">
                    <div class="card-header mt-0 p-0">
                        <strong> Time out </strong>
                    </div>
                    <div class="card-body ">
                       <div class="d-flex flex-column justify-content-center align-items-center">
                            <div class="form-group">
                                <label class="switch p-0">
                                    <input type="hidden" name="id" value="<?= $C_TIME_OUT->id ?>">
                                    <input class="switch_on p-0" type="checkbox" <?= $C_TIME_OUT->value != '0' ? 'checked' : ''; ?> name="main_on" onchange="this.form.submit()">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="form-group  d-flex flex-column justify-content-center align-items-center">
                                <label for="colFormLabelLg" class=" col-form-label col-form-label-lg">Minutes</label>
                                <div class="w-50 d-flex">
                                    <input type="number" name='minutes' value="<?=$C_TIME_OUT->value?>" class="form-control form-control-sm text-center" placeholder="">
                                    <?php if($C_TIME_OUT->value!='0'){ ?>
                                        <input type="submit" value="Update" class="btn btn-primary btn-sm ml-2">
                                    <?php } ?>
                                </div>
                            </div>
                       </div>
                    </div>
                </form>
            </div>

            <div class="card  col-xl-3 col-lg-4 col-md-6 col-12 ml-2">
            <!-- <form action="<?php echo base_url() . 'superadministrators/system_data_reset'; ?>" method="post" accept-charset="utf-8" class="p-1"> -->
                <div class="card-header mt-0 p-0">
                    <strong>System Data Reset</strong>
                </div>
                <div class="card-body ">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <div class="form-group">
                            <input class="btn btn-success" id="btn_reset" type="submit" value="Reset Data">
                        </div>
                    </div>
                </div>
            </div>
            <!-- </form> -->
        </div>

        <form action="<?php echo base_url('superadministrators/insrt_attachment'); ?>" id="ANNOUNCEMENTS_FORM_ADD" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
            <div class="modal-body">

                <div class="form-group">
                    <label for="INSRT_ATTACHMENT" class="form-label">Add attachments</label>
                    <input class="form-control add_attachments p-0 border-0" type="file" name="INSRT_ATTACHMENT" id="INSRT_ATTACHMENT" />
                </div>
            </div>
            <!-- <input type="hidden" name="USER_ID" value="<?= $this->session->userdata('SESS_USER_ID') ?>"> -->
            <div class="modal-footer">
                <button class='btn btn-primary text-light' id="ANNOUNCEMENTS_BTN_SAVE">&nbsp; Save
                </button>
            </div>
        </form>
    </div>
</div>


<?php $this->load->view('templates/jquery_link'); ?>

<script>

    $(document).ready(function() {
        let base_url='<?=base_url()?>'
        $('#btn_reset').on("click", function() {
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                fetch(base_url+"superadministrators/system_data_reset").then((result)=>{
                    console.log(result);
                    Swal.fire(
                    'Deleted!',
                    'Tables have been reset.',
                    'success'
                    )
                })
                
            }
            })

        })

    })

</script>
</body>

</html>