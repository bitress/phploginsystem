<?php

//header("Content-Type: application/json");
include_once 'config/init.php';



$login = new User();


echo $login->getUserDataByEmail('itscyanne@gmail.com')  ;