<?php
include_once 'config/init.php';

Session::unsetSession("uid");
Session::unsetSession("isLoggedIn");

header("Location: index.php");