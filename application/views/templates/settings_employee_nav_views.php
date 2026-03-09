<?php 
$currentUrl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$currentUrl .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$parsedUrl = parse_url($currentUrl);
$path = $parsedUrl['path'];
$lastParameter = basename($path);

$com_company = $this->employees_model->GET_SYSTEM_SETTING("com_company");
$com_branch = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
$com_Department = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
$com_division = $this->employees_model->GET_SYSTEM_SETTING("com_division");
$com_clubhouse = $this->employees_model->GET_SYSTEM_SETTING("com_clubhouse");
$com_section = $this->employees_model->GET_SYSTEM_SETTING("com_section");
$com_group = $this->employees_model->GET_SYSTEM_SETTING("com_group");
$com_team = $this->employees_model->GET_SYSTEM_SETTING("com_team");
$com_line = $this->employees_model->GET_SYSTEM_SETTING("com_line");

?>
<a class="nav-link <?= ($lastParameter == 'setting_general')? 'active' : ''?>"      href="<?= base_url() . 'employees/setting_general'; ?>">General</a>
<a class="nav-link <?= ($lastParameter == 'auto_approve')? 'active' : ''?>"      href="<?= base_url() . 'employees/auto_approve'; ?>">Auto Approve</a>
<a class="nav-link <?= ($lastParameter == 'employee_offset_access')? 'active' : ''?>"      href="<?= base_url() . 'employees/employee_offset_access'; ?>">Offset Access</a>
<a class="nav-link <?= ($lastParameter == 'exempt_undertime_access')? 'active' : ''?>"      href="<?= base_url() . 'employees/exempt_undertime_access'; ?>">Exempt Undertime Access</a>
<a class="nav-link <?= ($lastParameter == 'employee_types')? 'active' : ''?>"      href="<?= base_url() . 'employees/employee_types'; ?>">Employee Types</a>
<a class="nav-link <?= ($lastParameter == 'requirements')? 'active' : ''?>"      href="<?= base_url() . 'employees/requirements'; ?>">Requirements</a>
<a class="nav-link <?= ($lastParameter == 'customize_informations')? 'active' : ''?>"      href="<?= base_url() . 'employees/customize_informations'; ?>">Customize Informations</a>
<a class="nav-link <?= ($lastParameter == 'positions')? 'active' : ''?>"      href="<?= base_url() . 'employees/positions'; ?>">Positions</a>
<?php if($com_company){ ?>                                                                  
<a class="nav-link <?= ($lastParameter == 'companies')? 'active' : ''?>"      href="<?= base_url() . 'employees/companies'; ?>">Companies</a> <?php } ?>
<?php if($com_branch){ ?>
<a class="nav-link <?= ($lastParameter == 'branches')? 'active' : ''?>"      href="<?= base_url() . 'employees/branches'; ?>">Branches</a> <?php } ?>
<?php if($com_Department){ ?>
<a class="nav-link <?= ($lastParameter == 'departments')? 'active' : ''?>"      href="<?= base_url() . 'employees/departments'; ?>">Departments</a> <?php } ?>
<?php if($com_division){ ?>
<a class="nav-link <?= ($lastParameter == 'divisions')? 'active' : ''?>"      href="<?= base_url() . 'employees/divisions'; ?>">Divisions</a> <?php } ?>
<?php if($com_clubhouse){ ?>
<a class="nav-link <?= ($lastParameter == 'clubhouse')? 'active' : ''?>"      href="<?= base_url() . 'employees/clubhouse'; ?>">Clubhouse</a> <?php } ?>
<?php if($com_section){ ?>
<a class="nav-link <?= ($lastParameter == 'sections')? 'active' : ''?>"      href="<?= base_url() . 'employees/sections'; ?>">Sections</a> <?php } ?>
<?php if($com_group){ ?>
<a class="nav-link <?= ($lastParameter == 'groups')? 'active' : ''?>"      href="<?= base_url() . 'employees/groups'; ?>">Groups</a> <?php } ?>
<?php if($com_team){ ?>
<a class="nav-link <?= ($lastParameter == 'teams')? 'active' : ''?>"      href="<?= base_url() . 'employees/teams'; ?>">Teams</a> <?php } ?>
<?php if($com_line){ ?>
<a class="nav-link <?= ($lastParameter == 'lines')? 'active' : ''?>"      href="<?= base_url() . 'employees/lines'; ?>">Lines</a> <?php } ?>
<a class="nav-link <?= ($lastParameter == 'marital_statuses')? 'active' : ''?>"      href="<?= base_url() . 'employees/marital_statuses'; ?>">Marital Statuses</a>
<a class="nav-link <?= ($lastParameter == 'genders')? 'active' : ''?>"      href="<?= base_url() . 'employees/genders'; ?>">Genders</a>
<a class="nav-link <?= ($lastParameter == 'nationalities')? 'active' : ''?>"      href="<?= base_url() . 'employees/nationalities'; ?>">Nationalities</a>
<a class="nav-link <?= ($lastParameter == 'religions')? 'active' : ''?>"      href="<?= base_url() . 'employees/religions'; ?>">Religions</a>
<a class="nav-link <?= ($lastParameter == 'blood_types')? 'active' : ''?>"      href="<?= base_url() . 'employees/blood_types'; ?>">Blood Types</a>
<a class="nav-link <?= ($lastParameter == 'hmos')? 'active' : ''?>"      href="<?= base_url() . 'employees/hmos'; ?>">HMOs</a>
<a class="nav-link <?= ($lastParameter == 'shirt_sizes')? 'active' : ''?>"      href="<?= base_url() . 'employees/shirt_sizes'; ?>">Shirt Sizes</a>
<a class="nav-link <?= ($lastParameter == 'banks')? 'active' : ''?>"      href="<?= base_url() . 'employees/banks'; ?>">Banks</a>
<a class="nav-link <?= ($lastParameter == 'settings_custom_groups')? 'active' : ''?>"      href="<?= base_url() . 'employees/settings_custom_groups'; ?>">Custom Groups</a>

                            