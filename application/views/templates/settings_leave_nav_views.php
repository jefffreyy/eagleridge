<?php 
$currentUrl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$currentUrl .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$parsedUrl = parse_url($currentUrl);
$path = $parsedUrl['path'];
$lastParameter = basename($path);

?>
<a class="nav-link <?= ($lastParameter == 'settings_leavepolicies')? 'active' : ''?>"   href="<?= base_url() . 'leaves/settings_leavepolicies'; ?>" >Leave Policies</a>
<a class="nav-link <?= ($lastParameter == 'settings_leavetypes')? 'active' : ''?>"      href="<?= base_url() . 'leaves/settings_leavetypes'; ?>">Leave Types</a>

                            