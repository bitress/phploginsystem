<?php
include_once '../config/init.php';

if (isset($_POST['action'])){

    $action = $_POST['action'];

    switch($action){

        case 'userLogin':
            /** @var $login */
            $response = $login->userLogin($_POST['username'], $_POST['password']);
                if($response === true){
                    echo "true";
                }
            break;
        case 'userRegister':
           $register = new Register();
            $response = $register->userRegister($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm_password'], $_POST['captcha']);
            if($response === true){
                echo "true";
            }
            break;
        case 'editProfile':
            $user = new User();

            $response = $user->editProfile($_POST['first_name'], $_POST['last_name'], $_POST['birthdate']);
            if($response === true){
                echo "true";
            }
            break;
        case 'changeEmail':
            $user = new User();
                $response = $user->changeEmail($_POST['email']);
                if($response === true){
                    echo "true";
                }

            break;
        case 'changePassword':
            $user = new User();
            $response = $user->changePassword($_POST['oldPassword'], $_POST['newPassword'], $_POST['confirmPassword']);
                if($response === true){
                    echo "true";
                }
            break;

        case 'confirmAccount':

            $register = new Register();
            $response = $register->confirmAccount($_POST['key']);
            if ($response === true){
                echo "true";
            }
            break;
        case 'updateActivity';
                $login = new Login();
                $response = $login->updateUserActivity($_POST['id']);
                if ($response === true){
                    echo "true";
                }
          break;

        default:
            break;

    }
}
