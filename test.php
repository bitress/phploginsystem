<?php

//header("Content-Type: application/json");
include_once 'config/init.php';



$login = new Message();

echo ($login->getUserAllMessages(1))  ;