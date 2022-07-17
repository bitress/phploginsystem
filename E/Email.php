<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email
{

    private PHPMailer $email;

    public function __construct(){
        $this->email = new PHPMailer();

    }

    /**
     * Initialise the mailer
     * @return PHPMailer
     * @throws Exception
     */
    private function initMailer(){

        $mail = $this->email;

        try {

            if (IS_SMTP){

                $mail->isSMTP();
//                $mail->SMTPDebug = 1;
                $mail->Host       = SMTP_HOST;
                $mail->SMTPAuth   = true;
                $mail->Username   = SMTP_USERNAME;
                $mail->Password   = SMTP_PASSWORD;
                $mail->SMTPSecure = "ssl";
                $mail->Port = SMTP_ENCRYPTION;

            }

            $mail->isHTML(true);

            $mail->From     = SMTP_USERNAME;
            $mail->FromName = APP_NAME;
            $mail->addReplyTo(SMTP_USERNAME);

            return $mail;

        } catch (Exception $e){
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }


    }

    /**
     * @throws Exception
     */
    public function sendEmailConfirmation($email, $confirmation_key): void
    {

        $mail = $this->initMailer();

        $mail->addAddress($email);

        $link = APP_URL . "/confirm.php?key=" . $confirmation_key;

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = APP_NAME . " - Email Confirmation";
        $mail->Body    = "<p>Thank you for registering on ". APP_NAME ." </p><p>Here is your confirmation key: <br /> ". $confirmation_key ."<br /></p><p>Please confirm your email by clicking on the link below:</p><a href='". $link. "'>Confirm Email</a> <br/><br/><p>If you can't click on that link, just copy and paste following key: </p><p>". $link ."</p>Thanks, <br/>". APP_NAME;

        if( ! $mail->send() ) {
            echo 'Message could not be sent. ';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            exit;
        }

    }

    /**
     * @return void
     * @throws Exception
     */
    public function sendResetPassword($email, $key)
    {

        $mail = $this->initMailer();

        $mail->addAddress($email);

        $link = APP_URL . "/reset-password.php?key=" . $key;

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = APP_NAME. " - Password Reset";
        $mail->Body    = "<p>It looks like you forgot your password on ". APP_NAME ." </p><p>Please reset your password by clicking on the link below:</p><a href='". $link. "'>Reset Password</a> <br/><br/><p>If you can't click on that link, just copy and paste following url: </p><p>". $link ."</p>Thanks, <br/>". APP_NAME;

        if( ! $mail->send() ) {
            echo 'Message could not be sent. ';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            exit;
        }



}

}