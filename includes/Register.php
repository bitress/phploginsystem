<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Register
{

    private Database $db;
    /**
     * @var mixed|null
     */

    private Login $login;
    private PHPMailer $email;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->login = new Login();
        $this->email = new PHPMailer();
    }

    public function userRegister(string $username, string $email, string $password, string $confirm_password, int $captcha ){

        $username = trim($username);
        $email = trim($email);
        $password = trim($password);
        $confirm_password = trim($confirm_password);
        $captcha = trim($captcha);

        $captchaAnswer =  Session::getSession('first_number') + Session::getSession("second_number");
         
         if($this->login->checkUsername($username)){
             echo "Username is already exists";
             return;
         }

         if($this->login->checkEmail($email)){
             echo "Email is already exists";
             return;
         }

         if($captchaAnswer !== intval($captcha)){
             echo "Captcha is incorrect";
             return;
         }

         $hashed_password = password_hash($confirm_password, PASSWORD_DEFAULT);

         $sql = "INSERT INTO `users` (`username`, `email`, `password`) VALUES (:username, :email, :password)";
         $stmt = $this->db->prepare($sql);
         $stmt->bindParam(":username", $username, PDO::PARAM_STR);
         $stmt->bindParam(":email", $email, PDO::PARAM_STR);
         $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);

         if($stmt->execute()){

                $uid = $this->db->lastInsertId();

                $sql = "INSERT INTO `user_details` (`user_id`) VALUES (:uid)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
                if($stmt->execute()){
                    return true;

                    //TODO: add confirmation code sent via email

                }
         }

    }

    private function sendConfirmationCode($email){

    }

    /**
     * Generate register captcha
     */
    public function generateCaptcha(){

        Session::setSession('first_number', rand(1, 10));
        Session::setSession("second_number", rand(1, 10));
    }

}