<?php
include_once 'config/init.php';

$login = new Login();

$login->fetchUserActivity();