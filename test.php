<?php
include_once 'config/init.php';

use PragmaRX\Google2FA\Google2FA;

$google2fa = new Google2FA();

echo $google2fa->generateSecretKey();