<!------------------------------------------------------ A. PAGE INFORMATION  -----------------------------------------------------

TECHNOS SYSTEM ENGINEERING INC.

EyeBox HRMS

@author     Technos Developers

@datetime   16 November 2022

@purpose    Company Contributions

CONTROLLER FILES:

MODEL FILES:

----------------------------------------------------------- A. STYLESHEETS  ----------------------------------------------------->

<?php $this->load->view('templates/css_link'); ?>

<?php $this->load->view('templates/companycontribution_style'); ?>

<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->





<div class="content-wrapper">
    <div class="container-fluid p-4">

        <!--<nav aria-label="breadcrumb">-->

        <!--    <ol class="breadcrumb">-->

        <!--        <li class="breadcrumb-item">-->

        <!--            <a href="<?= base_url() ?>superadministrators">Super Administrator</a>-->

        <!--        </li>-->

        <!--        <li class="breadcrumb-item active" aria-current="page">System Variables-->

        <!--        </li>-->

        <!--    </ol>-->

        <!--</nav>-->



        <div class="row mb-2">

            <!-- Title Text -->

            <div class="col-md-6">

                <h1 class="page-title">System Variables <h1>

            </div>

        </div>



             <!-- Title Header Line -->

      <hr>
      
<?php echo form_open('superadministrators/update_system_varibles', 'class="email" id="myform"');?>
        <button type='submit' class='btn technos-button-blue d-block ml-auto'>Save Changes</button>
        <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">

            <div class="row">

                <div class="col">

                    <div class="table-responsive" style='max-height:75vh'>

                        <table class="table table-striped">

                            <thead style='position:sticky;top:-1px'>

                                <tr class='text-center'>

                                    <th scope="col">Setting</th>

                                    <th  scope="col">Values </th>

                                </tr>

                            </thead>
                            <tbody>
<?php foreach($SET_UP_VARIABLES as $variable) { ?>
                                    <tr >

                                        <td style="text-align: left;">
                                        <?=$variable->setting?>
                                        </td>
                                        <td style="text-align: left;">
                                            <input name="<?=$variable->setting?>[id]" type='hidden' value="<?=$variable->id?>">
                                            <input name="<?=$variable->setting?>[value]" class="d-block w-100"  type='text' value="<?=$variable->value?>"
                                            style='background-color:transparent;border:none;height:30px;'>
                                        </td>
                                    </tr>
<?php } ?>
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Modal -->

<?php $this->load->view('templates/jquery_link'); ?>

<?php if($this->session->flashdata('success')) { ?>
<script>
    Swal.fire(
      'Success!',
       "<?=$this->session->flashdata('success')?>",
      'success'
    )
</script>
<?php } ?>