<?php

include_once '../config/init.php';

$username = trim($username);
$password = trim($password);
try {

    $sql = "SELECT * FROM `users` WHERE `username` = :username";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);

    if ($stmt->execute()){
        if($stmt->rowCount() > 0) {

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            /** @var string $hashed_password **/
            $hashed_password = $row['password'];

            if(password_verify($password, $hashed_password)){

                Session::setSession("uid", $row['user_id']);
                Session::setSession("isLoggedIn", true);

                echo "true";

            } else {
                echo "Password is incorrect";
            }

        } else {
            echo "No username found";
        }
    } else {
        echo "Error occurred while logging in.";
    }

} catch (Exception $e){
    echo "Error: " . $e;
}


