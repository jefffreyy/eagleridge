<?php 
$currentUrl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$currentUrl .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$parsedUrl = parse_url($currentUrl);
$path = $parsedUrl['path'];
$lastParameter = basename($path);

?>
<a class="nav-link <?= ($lastParameter == 'setting_constant')? 'active' : ''?>"      href="<?= base_url() . 'payrolls/setting_constant'; ?>">General</a>

                            