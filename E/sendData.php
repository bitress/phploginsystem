<?php
include_once '../config/init.php';

if (isset($_POST['action'])){

    $action = $_POST['action'];

    switch($action){

        case 'userLogin':
            /** @var $login */
            $response = $login->userLogin($_POST['username'], $_POST['password'], $_POST['token']);
                if($response === true){
                    echo "true";
                }
            break;
        case 'userRegister':
           $register = new Register();
            try {
                $response = $register->userRegister($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm_password'], $_POST['captcha'], $_POST['token']);
            } catch (\PHPMailer\PHPMailer\Exception $e) {
                echo $e->getMessage();
            }
            if($response === true){
                echo "true";
            }
            break;
        case 'editProfile':
            $user = new User();

            $avatar = !empty($_FILES['avatar']) ? $_FILES['avatar'] : '';
            $response = $user->editProfile($avatar ,$_POST['first_name'], $_POST['last_name'], $_POST['birthdate']);
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

        case 'sendResetCode':

            $reset = new PasswordReset();
            $response = $reset->RequestResetPassword($_POST['email']);

            if ($response === true){
                echo 'true';
            }

            break;

        case 'resetPassword':

            $reset = new PasswordReset();
            $response = $reset->resetPassword($_POST['new_password'], $_POST['key']);
            if ($response === true){
                echo "true";
            }
            break;

        case 'updateActivity';
                $act = new Activity();
                $response = $act->updateUserActivity($_POST['id']);
                if ($response === true){
                    echo "true";
                }
          break;

        case 'getSidebarMessage':

            $message = new Message();
            $response = $message->getUserAllMessages($_POST['id']);

            break;
        case 'getAllMessages':

            $message = new Message();
            $response = $message->getMessage($_POST['receiver'], $_POST['sender']);

            break;
        case 'sendMessage':

            $message = new Message();
            $response = $message->sendMessage($_POST['receiver'], $_POST['message']);

            break;

        case 'getChatHeader':

            $message = new Message();
            $response = $message->getChatHeader($_POST['id']);

            break;

        default:
            break;

    }
}
