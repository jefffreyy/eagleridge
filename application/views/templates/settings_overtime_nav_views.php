<?php 
$currentUrl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$currentUrl .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$parsedUrl = parse_url($currentUrl);
$path = $parsedUrl['path'];
$lastParameter = basename($path);

?>
<a class="nav-link <?= ($lastParameter == 'setting_general')? 'active' : ''?>"      href="<?= base_url() . 'overtimes/setting_general'; ?>">General</a>
<a class="nav-link <?= ($lastParameter == 'overtime_step')? 'active' : ''?>"      href="<?= base_url() . 'overtimes/overtime_step'; ?>">Overtime Step Count</a>
<a class="nav-link <?= ($lastParameter == 'overtime_hours')? 'active' : ''?>"      href="<?= base_url() . 'overtimes/overtime_hours'; ?>">Overtime Hours</a>

                            