<?php



class Register
{

    private Database $db;
    /**
     * @var mixed|null
     */

    private Login $login;

    private Email $mailer;


    public function __construct() {
        $this->db = Database::getInstance();
        $this->login = new Login();
        $this->mailer = new Email();
    }

    /**
     * Register user
     * @param string $username User's username
     * @param string $email Email of the user
     * @param string $password Password of the user
     * @param string $confirm_password Retyped password of the user
     * @param int $captcha User's answer to the captcha
     * @return bool|void
     * @throws \PHPMailer\PHPMailer\Exception
     */
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

         if ($password !== $confirm_password){
             echo "Password doesnt match";
             return;
         }

         if($captchaAnswer !== intval($captcha)){
             echo "Captcha is incorrect";
             return;
         }

         try {

             $hashed_password = password_hash($confirm_password, PASSWORD_DEFAULT);

             // generate confirmation code
             $confirmation_code = Miscellaneous::generateKey();

             $status = (EMAIL_CONFIRMATION)  ? '0' : '1';

             $sql = "INSERT INTO `users` (`username`, `email`, `password`, `status`, `confirmation_key`) VALUES (:username, :email, :password, :status, :confirmation_key)";
             $stmt = $this->db->prepare($sql);
             $stmt->bindParam(":username", $username, PDO::PARAM_STR);
             $stmt->bindParam(":email", $email, PDO::PARAM_STR);
             $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
             $stmt->bindParam(":confirmation_key", $confirmation_code, PDO::PARAM_STR);
             $stmt->bindParam(":status", $status, PDO::PARAM_STR);
             if($stmt->execute()){

                 $uid = $this->db->lastInsertId();

                 $sql = "INSERT INTO `user_details` (`user_id`) VALUES (:uid)";
                 $stmt = $this->db->prepare($sql);
                 $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
                 if($stmt->execute()){

                     if (EMAIL_CONFIRMATION){
                         $this->mailer->sendEmailConfirmation($email, $confirmation_code);
                     }

                     return true;
                 }
             }

         } catch(Exception $e){
             echo "Error: ". $e;
         }


    }


    public function confirmAccount(string $key){

        try {

            $sql = "SELECT * FROM `users` WHERE `confirmation_key` = :key";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':key', $key, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $sql = "UPDATE `users` SET `status` = '1' WHERE `confirmation_key` = :key";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':key', $key, PDO::PARAM_STR);
                if($stmt->execute()) {

                    return true;

                } else {
                    echo 'There must be an error confirming your account!';
                }
            } else {
                echo 'Oops! Sorry, the key with this user does not exist.';

            }

        } catch (Exception $e){
            echo "Error: " . $e;
        }



    }

    /**
     * Generate register captcha
     * @return void
     */
    public function generateCaptcha(){

        Session::setSession('first_number', rand(1, 10));
        Session::setSession("second_number", rand(1, 10));
    }

}