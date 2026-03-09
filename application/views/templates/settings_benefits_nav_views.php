<?php 
$currentUrl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$currentUrl .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$parsedUrl = parse_url($currentUrl);
$path = $parsedUrl['path'];
$lastParameter = basename($path);

?>
<a class="nav-link <?= ($lastParameter == 'setting_general')? 'active' : ''?>"      href="<?= base_url() . 'benefits/setting_general'; ?>">General</a>
<a class="nav-link <?= ($lastParameter == 'setting_loan_types')? 'active' : ''?>"      href="<?= base_url() . 'benefits/setting_loan_types'; ?>">Loan Types</a>
<a class="nav-link <?= ($lastParameter == 'setting_reimbursement_types')? 'active' : ''?>"      href="<?= base_url() . 'benefits/setting_reimbursement_types'; ?>">Reimbursement Types</a>
<a class="nav-link <?= ($lastParameter == 'setting_cashadvance_types')? 'active' : ''?>"      href="<?= base_url() . 'benefits/setting_cashadvance_types'; ?>">Cash Advance Types</a>
<a class="nav-link <?= ($lastParameter == 'setting_allowance')? 'active' : ''?>"      href="<?= base_url() . 'benefits/setting_allowance'; ?>">Extra Allowance</a>








                            