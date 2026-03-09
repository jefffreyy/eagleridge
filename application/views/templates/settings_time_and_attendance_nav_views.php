<?php 
$currentUrl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$currentUrl .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$parsedUrl = parse_url($currentUrl);
$path = $parsedUrl['path'];
$lastParameter = basename($path);

?>
<a class="nav-link <?= ($lastParameter == 'setting_general')? 'active' : ''?>"      href="<?= base_url() . 'attendances/setting_general'; ?>">General</a>
<a class="nav-link <?= ($lastParameter == 'setting_holidays')? 'active' : ''?>"      href="<?= base_url() . 'attendances/setting_holidays'; ?>">Holidays</a>
<a class="nav-link <?= ($lastParameter == 'setting_years')? 'active' : ''?>"      href="<?= base_url() . 'attendances/setting_years'; ?>">Years</a>
<a class="nav-link <?= ($lastParameter == 'setting_biometrics')? 'active' : ''?>"      href="<?= base_url() . 'attendances/setting_biometrics'; ?>">Biometrics</a>
<a class="nav-link <?= ($lastParameter == 'setting_remote_in_out')? 'active' : ''?>"      href="<?= base_url() . 'attendances/setting_remote_in_out'; ?>">Remote In/Out</a>
<a class="nav-link <?= ($lastParameter == 'setting_geo_fences')? 'active' : ''?>"      href="<?= base_url() . 'attendances/setting_geo_fences'; ?>">Geo Fencing</a>
<a class="nav-link <?= ($lastParameter == 'setting_absent_lwop_awol')? 'active' : ''?>"      href="<?= base_url() . 'attendances/setting_absent_lwop_awol'; ?>">Absences</a>                         