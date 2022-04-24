<?php

include_once 'Configuration.php';
include_once __DIR__. '/../db/Database.php';
include_once __DIR__. '/../includes/Session.php';
include_once __DIR__. '/../includes/Login.php';
include_once __DIR__. '/../includes/Register.php';
include_once __DIR__. '/../includes/User.php';


Session::startSession(); // Start session

$db = Database::getInstance();

$login = new Login();