<?php

/**
 * Reset Password Class
 * @author ItsCyanne
 */
class PasswordReset {

    private Database $db;
    private User $user;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->user = new User();
    }

    /**
     * Request reset password code
     * @param $email string user's email
     * @return void
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function RequestResetPassword($email) {

        $user = $this->user->getUserDataByEmail($email);


        if ($user !== 0) {
            $email1 = new Email();

            /*** Create user token **/
            $token = Others::generateKey();
            $this->setToken($token, $email);

            if($email1->sendResetPassword($email, $token)){
                return true;
            }

        } else {
            echo "The email you've entered was not bind to any account";
            return;
        }
    }

    /**
     * Change user's password in the database
     * @param $password User's new password
     * @param $reset_key User's reset key
     * @return bool|void
     */

    public function resetPassword($password, $reset_key) {


        if (!empty($this->isTokenValid($reset_key))) {
            $reset = $this->isTokenValid($reset_key);
            $user = $reset['user_id'];
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE `users` SET `password` = :p WHERE `user_id` = :i LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":p", $password, PDO::PARAM_STR);
        $stmt->bindParam(":i", $user, PDO::PARAM_INT);
        if ($stmt->execute()) {

            /*** Make user's token expire and be invalid */
            $this->expireToken($reset_key);
            return true;
        }


    }

    /**
     * Set user's token into the databse
     * @param $token User's created token
     * @param $email User's email
     * @return bool|void
     */

    public function setToken($token, $email) {

        $user = $this->user->getUserDataByEmail($email);
        $expireAt = date("Y-m-d H:i:s", strtotime('+8 hours'));


        $sql = "INSERT INTO password_reset (user_id, token, expire_at) VALUES (:u, :t, :e)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":u", $user, PDO::PARAM_INT);
        $stmt->bindParam(":t", $token, PDO::PARAM_STR);
        $stmt->bindParam(":e", $expireAt, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        }

    }

    /**
     * Verify if token is still valid
     * @param $token user's token
     * @return mixed|void
     */
    public function isTokenValid($token) {

        $sql = "SELECT * FROM `password_reset` WHERE `token` = :t AND `is_valid` = '1' AND `expire_at` >= now()";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":t", $token, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return $stmt->fetch();
        }


    }


    /***
     * Make the token expire and be invalid
     * @param $token user's token
     * @return bool|void
     */
    private function expireToken($token){

        $sql = "UPDATE password_reset SET is_valid = '0' , expire_at = now() WHERE token = :t";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":t", $token, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return true;
        }
    }



}