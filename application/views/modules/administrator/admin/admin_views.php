<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/companycontribution_style'); ?>

<style>
    .disabled-link {
        pointer-events: none;
    }

    .vl {
        height: 50px;
        border-left: 6px solid lightskyblue;
        margin: 15px;
        left: 50%;
        position: relative;
    }

    .vb {
        height: 50px;
        margin: 15px;
        left: 50%;
        position: relative;
    }

    .checkbox-success input[type="checkbox"]:checked+label::before {
        background-color: #33ccca;
        border-color: #33ccca;
    }

    @supports (-webkit-appearance: none) or (-moz-appearance: none) {
        .checkbox-wrapper-13 input[type=checkbox] {
            --active: #22ddc4;
            --active-inner: #fff;
            --focus: 2px rgba(34, 221, 196, 1);
            --border: #33ccca;
            --border-hover: #33ccca;
            --background: #fff;
            --disabled: #F6F8FF;
            --disabled-inner: #22ddc4;
            -webkit-appearance: none;
            -moz-appearance: none;
            height: 21px;
            outline: none;
            display: inline-block;
            vertical-align: top;
            position: relative;
            margin: 0;
            cursor: pointer;
            border: 1px solid var(--bc, var(--border));
            background: var(--b, var(--background));
            transition: background 0.3s, border-color 0.3s, box-shadow 0.2s;
        }

        .checkbox-wrapper-13 input[type=checkbox]:after {
            content: "";
            display: block;
            left: 0;
            top: 0;
            position: absolute;
            transition: transform var(--d-t, 0.3s) var(--d-t-e, ease), opacity var(--d-o, 0.2s);
        }

        .checkbox-wrapper-13 input[type=checkbox]:checked {
            --b: var(--active);
            --bc: var(--active);
            --d-o: .3s;
            --d-t: .6s;
            --d-t-e: cubic-bezier(.2, .85, .32, 1.2);
        }

        .checkbox-wrapper-13 input[type=checkbox]:disabled {
            --b: var(--disabled);
            cursor: not-allowed;
            opacity: 0.9;
        }

        .checkbox-wrapper-13 input[type=checkbox]:disabled:checked {
            --b: var(--disabled-inner);
            --bc: var(--border);
        }

        .checkbox-wrapper-13 input[type=checkbox]:disabled+label {
            cursor: not-allowed;
        }

        .checkbox-wrapper-13 input[type=checkbox]:hover:not(:checked):not(:disabled) {
            --bc: var(--border-hover);
        }

        .checkbox-wrapper-13 input[type=checkbox]:focus {
            box-shadow: 0 0 0 var(--focus);
        }

        .checkbox-wrapper-13 input[type=checkbox]:not(.switch) {
            width: 21px;
        }

        .checkbox-wrapper-13 input[type=checkbox]:not(.switch):after {
            opacity: var(--o, 0);
        }

        .checkbox-wrapper-13 input[type=checkbox]:not(.switch):checked {
            --o: 1;
        }

        .checkbox-wrapper-13 input[type=checkbox]+label {
            display: inline-block;
            vertical-align: middle;
            cursor: pointer;
            margin-left: 4px;
        }

        .checkbox-wrapper-13 input[type=checkbox]:not(.switch) {
            border-radius: 7px;
        }

        .checkbox-wrapper-13 input[type=checkbox]:not(.switch):after {
            width: 5px;
            height: 9px;
            border: 2px solid var(--active-inner);
            border-top: 0;
            border-left: 0;
            left: 7px;
            top: 4px;
            transform: rotate(var(--r, 20deg));
        }

        .checkbox-wrapper-13 input[type=checkbox]:not(.switch):checked {
            --r: 43deg;
        }
    }

    .checkbox-wrapper-13 * {
        box-sizing: inherit;
    }

    .checkbox-wrapper-13 *:before,
    .checkbox-wrapper-13 *:after {
        box-sizing: inherit;
    }

</style>

<div class="content-wrapper">
    <div class="p-3">
        <div class="flex-fill">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>nav_corehr">HR Essentials</a>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Starter Guide
                    </li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-md-6">
                    <h1 class="page-title">Starter Guide<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>

            <hr>
            <center>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>employees/positions" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Positions</span>
                            </div>
                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 0) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 1) ? 0 : 1; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>employees/employment_types" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Employee Types</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 1) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 2) ? 1 : 2; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>employees/departments" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Departments</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 2) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 3) ? 2 : 3; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>employees/sections" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Sections</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 3) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 4) ? 3 : 4; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>employees/groups" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Groups</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 4) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 5) ? 4 : 5; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>employees/lines" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Lines</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 5) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 6) ? 5 : 6; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>employees/genders" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Genders</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 6) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 7) ? 6 : 7; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>employees/nationalities" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Nationality</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 7) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 8) ? 7 : 8; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>employees/marital_statuses" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Marital Status</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 8) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 9) ? 8 : 9; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>employees/shirt_sizes" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Shirt Sizes</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 9) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 10) ? 9 : 10; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>employees/hmos" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">HMO</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 10) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 11) ? 10 : 11; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>employees/skill_names" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Skill Name</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 11) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 12) ? 11 : 12; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>employees/skill_levels" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Skill Level</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 12) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 13) ? 12 : 13; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>attendances/holidays" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Holidays</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 13) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 14) ? 13 : 14; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>attendances/work_shifts" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Shifts</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 14) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 15) ? 14 : 15; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>attendances/shift_templates" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Shift Template</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 15) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 16) ? 15 : 16; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>payrolls/payroll_schedules" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Payroll Period</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 16) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 17) ? 16 : 17; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>payrolls/sss_rates" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">SSS Rate</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 17) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 18) ? 17 : 18; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>payrolls/philhealth_rates" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Philhealth Rate</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 18) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 19) ? 18 : 19; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>payrolls/hdmf_rates" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">HDMF Rate</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 19) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 20) ? 19 : 20; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>payrolls/tax_rates" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Withholding Tax Rate</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 20) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 21) ? 20 : 21; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>employees/allowances" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Allowances</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 21) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 22) ? 21 : 22; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="vl"></div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="<?= base_url() ?>employees/deductions" class="page_link" style="text-decoration: none;   color: black;">
                        <div class="info-box shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size:large !important">Deductions</span>
                            </div>

                            <div class="checkbox-wrapper-13 padding-top check" style="padding-top: 20px;">
                                <input type="checkbox" class="check" name="check_box" <?= ($check_value > 22) ? 'checked' : ''; ?> onclick='window.location.assign("/hressentials/starter_guide?guide=<?= ($check_value >= 23) ? 22 : 23; ?>" )'>
                            </div>
                        </div>
                    </a>
                </div>

            </center>
        </div>
    </div>
</div>

<aside class="control-sidebar control-sidebar-dark"></aside>

<?php $this->load->view('templates/jquery_link'); ?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_ADD_PAYROLL')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_ADD_PAYROLL'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_ADD_PAYROLL');
}
?>

<script>
    $(document).ready(function() {
      
        base_url = '<?= base_url() ?>';
        url = '<?= base_url() ?>payroll/get_employee_no_payslip_count';
        url2 = '<?= base_url() ?>payroll/get_payslip_count_based_on_period';
        url3 = '<?= base_url() ?>payroll/getEmployeeData';
        var payroll_id = $('#date_period').val();
        var cut_off_period_text = $('#date_period option:selected').text();
        var total_sss_arr = [];
        var total_pagibig_arr = [];
        var total_philhealth_arr = [];
        var sss_cutoff = $('#tbl_sss .payslip_row');
        var pagibig_cutoff = $('#tbl_pagibig .payslip_row');
        var philhealth_cutoff = $('#tbl_philhealth .payslip_row');
        if (cut_off_period_text) {
            Array.from(sss_cutoff).forEach(function(tr) {
                const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                if (cut_off_period_text == cut_off_period) {
                    tr.style.display = "";
                    var sss_total = $(tr.childNodes[17]).attr('sss_total');
                    total_sss_arr.push(parseFloat(sss_total));
                } else {
                    tr.style.display = 'none';
                    $('#total_sss').html(0);
                }
            });
            $('#total_sss').html((total_sss_arr.reduce((a, b) => a + b, 0)).toFixed(2));
            Array.from(pagibig_cutoff).forEach(function(tr) {
                const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                if (cut_off_period_text == cut_off_period) {
                    tr.style.display = "";
                    var pagibig_total = $(tr.childNodes[17]).attr('pagibig_total');
                    total_pagibig_arr.push(parseFloat(pagibig_total));
                } else {
                    tr.style.display = 'none';
                    $('#total_pagibig').html(0);
                }
            });
            $('#total_pagibig').html((total_pagibig_arr.reduce((a, b) => a + b, 0)).toFixed(2));
            Array.from(philhealth_cutoff).forEach(function(tr) {
                const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                if (cut_off_period_text == cut_off_period) {
                    tr.style.display = "";
                    var philhealth_total = $(tr.childNodes[17]).attr('philhealth_total');
                    total_philhealth_arr.push(parseFloat(philhealth_total));
                } else {
                    tr.style.display = 'none';
                    $('#total_philhealth').html(0);
                }
            });
            $('#total_philhealth').html((total_philhealth_arr.reduce((a, b) => a + b, 0)).toFixed(2));
        } else {
            Array.from(sss_cutoff).forEach(function(tr) {
                tr.style.display = "";
            })
            Array.from(pagibig_cutoff).forEach(function(tr) {
                tr.style.display = "";
            })
            Array.from(philhealth_cutoff).forEach(function(tr) {
                tr.style.display = "";
            })
        }
        $('#date_period').change(function(e) {
            var date_period_id_value = $(this).val();
            var date_period_value = $('#date_period option:selected').text();
            var total_sss_arr = [];
            var total_pagibig_arr = [];
            var total_philhealth_arr = [];
            var sss_cutoff = $('#tbl_sss .payslip_row');
            var pagibig_cutoff = $('#tbl_pagibig .payslip_row');
            var philhealth_cutoff = $('#tbl_philhealth .payslip_row');
            if (date_period_value) {
                Array.from(sss_cutoff).forEach(function(tr) {
                    const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                    if (date_period_value == cut_off_period) {
                        tr.style.display = "";
                        var sss_total = $(tr.childNodes[17]).attr('sss_total');
                        total_sss_arr.push(parseFloat(sss_total));
                    } else {
                        tr.style.display = 'none';
                        $('#total_sss').html(0);
                    }
                })
                $('#total_sss').html((total_sss_arr.reduce((a, b) => a + b, 0)).toFixed(2));
                Array.from(pagibig_cutoff).forEach(function(tr) {
                    const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                    if (date_period_value == cut_off_period) {
                        tr.style.display = "";
                        var pagibig_total = $(tr.childNodes[17]).attr('pagibig_total');
                        total_pagibig_arr.push(parseFloat(pagibig_total));
                    } else {
                        tr.style.display = 'none';
                        $('#total_pagibig').html(0);
                    }
                })
                $('#total_pagibig').html((total_pagibig_arr.reduce((a, b) => a + b, 0)).toFixed(2));
                Array.from(philhealth_cutoff).forEach(function(tr) {
                    const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                    if (date_period_value == cut_off_period) {
                        tr.style.display = "";
                        var philhealth_total = $(tr.childNodes[17]).attr('philhealth_total');
                        total_philhealth_arr.push(parseFloat(philhealth_total));
                    } else {
                        tr.style.display = 'none';
                        $('#total_philhealth').html(0);
                    }
                })
                $('#total_philhealth').html((total_philhealth_arr.reduce((a, b) => a + b, 0)).toFixed(2));
            } else {
                Array.from(sss_cutoff).forEach(function(tr) {
                    tr.style.display = "";
                })
                Array.from(pagibig_cutoff).forEach(function(tr) {
                    tr.style.display = "";
                })
                Array.from(philhealth_cutoff).forEach(function(tr) {
                    tr.style.display = "";
                })
            }
        })
        async function getPayrollData_period(url, payroll_date) {
            var formData = new FormData();
            formData.append('employee_id', employee_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }
    })
</script>

<script>
    $(document).ready(function() {
        $arr = new Array();

    });
</script>

</body>

</html>