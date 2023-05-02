<?php

/**
 * Login Class
 * @author ItsCyanne
 */

class Login
{

    /**
     * @var Database
     */
    private Database $db;


    public function __construct(){
        $this->db = Database::getInstance();
    }

    /***
     * Check the user if logged in
     * @return bool
     */
    public function isLoggedIn(){

        if(Session::checkSession("uid")){
            return true;
        }
        if (Session::checkSession("isLoggedIn")){
            return true;
        }
        return false;
    }


    /**
    * User login function
    * @param string $username User's username
     * @param string $password User's password
     * @param string $token login token
     * @return void TRUE if okay, FALSE otherwise
     **/
    public function userLogin(string $username, string $password, string $token)
    {

        $username = trim($username);
        $password = trim($password);
        try {

            if (!CSRF::check($token, 'login_form')){
                echo "Unable to process your request.";
                return false;
            }

            $sql = "SELECT * FROM `users` WHERE `username` = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);

            if ($stmt->execute()){
                if($stmt->rowCount() > 0) {

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    /** @var string $hashed_password **/
                    $hashed_password = $row['password'];


                    if ($this->isBruteForce()){
                        echo "You have exceeded the maximum login attempts. Try again tomorrow.";
                        return false;
                    }

                    if ($row['status'] == '0'){
                        echo "Your account has not been activated yet. Please confirm your account.";
                        return false;
                    }

                    if(password_verify($password, $hashed_password)){

                        /** Log in the user */
                        Session::setSession("uid", $row['user_id']);
                        Session::setSession("isLoggedIn", true);

                       echo "true";

                    } else {
                        echo "Password is incorrect";
                        $this->increaseLoginAttempt();
                    }

                } else {
                    echo "No username found";
                }
            } else {
                echo "Error occurred while logging in.";
            }

        } catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }

    }


    /**
     * Check username if exists
     * @param $username string username of the user
     * @return boolean TRUE if it exists, FALSE otherwise
     */
    public function checkUsername($username){

        $sql = "SELECT user_id FROM users WHERE username = :u";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':u', $username, PDO::PARAM_STR);
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                return true;
            }
        }
    }

    /**
     * Check email if exists
     * @param $email string email of the user
     * @return boolean TRUE if it exists, FALSE otherwise
     */
    public function checkEmail(string $email){

        $sql = "SELECT `user_id` FROM `users` WHERE `email` = :e";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':e', $email, PDO::PARAM_STR);
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                return true;
            }
        }
    }


    /**
     * Increase log in attempt when password is incorrect
     * @return void
     */
    private function increaseLoginAttempt(){

        $date = date('Y-m-d');
        $user_ip = Others::getUserIpAddress();
        $login_attempts = $this->getLoginAttempts();
        
        // echo $login_attempts;

        if ($login_attempts > 0) {
            $stmt = $this->db->prepare('UPDATE `login_attempts` SET `attempt` = attempt + 1 WHERE `ip_address` = :ip AND `date` = :d');
            // $stmt->execute([$user_ip,$date]);
            $stmt->bindParam(':ip', $user_ip, PDO::PARAM_STR);
            $stmt->bindParam(':d', $date, PDO::PARAM_STR);
            $stmt->execute();
        } else {
            $stmt = $this->db->prepare("INSERT INTO `login_attempts` (`ip_address`, `date`) VALUES (:ip, :d)");
            $stmt->bindParam(':ip', $user_ip, PDO::PARAM_STR);
            $stmt->bindParam(':d', $date, PDO::PARAM_STR);
            $stmt->execute();
        }



    }

    /**
     * Get user log in attempt
     * @return int
     */
    private function getLoginAttempts() {

        $date = date('Y-m-d');
        $user_ip = Others::getUserIpAddress();

        $sql = "SELECT * FROM `login_attempts` WHERE `ip_address` = :ip AND `date` = :d";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':ip', $user_ip, PDO::PARAM_STR);
        $stmt->bindParam(':d', $date, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch();
        if ($stmt->rowCount() == 0) {
            return 0;
        } else {
            return intval($res['attempt']);
        }

    }


    /**
     * Check if exceeds the number of max attempts
     * @return bool
     */
    private function isBruteForce(){
        $login_attempts = $this->getLoginAttempts();

        if ($login_attempts > MAX_LOGIN_ATTEMPTS)  {
            return true;
        } else {
            return false;
        }

    }



}
