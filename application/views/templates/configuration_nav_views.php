<?php 
$currentUrl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$currentUrl .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$parsedUrl = parse_url($currentUrl);
$path = $parsedUrl['path'];
$lastParameter = basename($path);

?>
<a class="nav-link <?= ($lastParameter == 'configurations')? 'active' : ''?>"      href="<?= base_url() . 'superadministrators/configurations'; ?>">Configurations</a>
<a class="nav-link <?= ($lastParameter == 'system_reset')? 'active' : ''?>"      href="<?= base_url() . 'superadministrators/system_reset'; ?>">System Reset</a>
<a class="nav-link <?= ($lastParameter == 'end_trial')? 'active' : ''?>"      href="<?= base_url() . 'superadministrators/end_trial'; ?>">End Trial</a>
<a class="nav-link <?= ($lastParameter == 'attendance_record_setting')? 'active' : ''?>"      href="<?= base_url() . 'superadministrators/attendance_record_setting'; ?>">Attendance Record</a>

                            