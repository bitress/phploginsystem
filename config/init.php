<?php

include_once 'Configuration.php';
include_once __DIR__ .'/../vendor/autoload.php';

//include_once __DIR__. '/../db/Database.php';
//include_once __DIR__. '/../E/Others.php';
//include_once __DIR__ . '/../E/Session.php';
//include_once __DIR__ . '/../E/Login.php';
//include_once __DIR__ . '/../E/Register.php';
//include_once __DIR__ . '/../E/User.php';
//include_once __DIR__ . '/../E/Email.php';

spl_autoload_register(function ($class) {

    $file = __DIR__. '/../E/'. $class .'.php';
    $db = __DIR__. '/../db/'. $class .'.php';

    if(file_exists($file)){
        include_once $file;

    } else {

        if (file_exists($db)){
            include_once $db;
        }

    }

});



Session::startSession(); // Start session

$db = Database::getInstance();

$login = new Login();