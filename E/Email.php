<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email
{

    private PHPMailer $email;

    public function __construct()
    {
        $this->email = new PHPMailer(true);
    }

    /**
     * Initialise the mailer
     *
     * @return PHPMailer
     * @throws Exception
     */
    private function initMailer(): PHPMailer
    {
        $mail = $this->email;

        if (IS_SMTP) {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->SMTPSecure = "ssl";
            $mail->Port = SMTP_ENCRYPTION;
        }

        $mail->isHTML(true);

        $mail->setFrom(SMTP_USERNAME, APP_NAME);
        $mail->addReplyTo(SMTP_USERNAME, APP_NAME);

        return $mail;
    }

    /**
     * Sends email confirmation email
     *
     * @param string $email
     * @param string $confirmation_key
     * @throws Exception
     */
    public function sendEmailConfirmation(string $email, string $confirmation_key): void
    {
        $mail = $this->initMailer();
        $mail->addAddress($email);

        $link = APP_URL . "/confirm.php?key=" . $confirmation_key;

        //Content
        $mail->Subject = APP_NAME . " - Email Confirmation";
        $mail->Body = "<p>Thank you for registering on " . APP_NAME . "</p><p>Here is your confirmation key: <br /> " . $confirmation_key . "<br /></p><p>Please confirm your email by clicking on the link below:</p><a href='" . $link . "'>Confirm Email</a> <br/><br/><p>If you can't click on that link, just copy and paste following key: </p><p>" . $confirmation_key . "</p>Thanks, <br/>" . APP_NAME;

        try {
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    /**
     * Sends password reset email
     *
     * @param string $email
     * @param string $key
     * @throws Exception
     */
    public function sendResetPassword(string $email, string $key): void
    {
        $mail = $this->initMailer();
        $mail->addAddress($email);

        $link = APP_URL . "/reset-password.php?key=" . $key;

        //Content
        $mail->Subject = APP_NAME . " - Password Reset";
        $mail->Body = "<p>It looks like you forgot your password on " . APP_NAME . "</p><p>Please reset your password by clicking on the link below:</p><a href='" . $link . "'>Reset Password</a> <br/><br/><p>If you can't click on that link, just copy and paste following url: </p><p>" . $link . "</p>Thanks, <br/>" . APP_NAME;

        try {
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
