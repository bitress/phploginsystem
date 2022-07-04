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
     * @return void TRUE if okay, FALSE otherwise
     **/
    public function userLogin(string $username, string $password)
    {

        $username = trim($username);
        $password = trim($password);
        try {

            $sql = "SELECT * FROM `users` WHERE `username` = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);

            if ($stmt->execute()){
                if($stmt->rowCount() > 0) {

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    /** @var string $hashed_password **/
                    $hashed_password = $row['password'];

                    if(password_verify($password, $hashed_password)){

                        /** Log in the user */
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

    }


    /**
     * Update user login activity
     * @param $id User's id
     * @return void
     */
    public function updateUserActivity($id){

        $date_time = date("Y-m-d h:i:s", (time() + 3));

        try {

            $sql = "UPDATE `user_activity` SET `last_activity` = :la WHERE `user_id` = :uid";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":uid", $id, PDO::PARAM_INT);
            $stmt->bindParam(":la", $date_time, PDO::PARAM_STR);
            if ($stmt->execute()){
                return true;
            }

        } catch (Exception $e) {
            echo "Error: ". $e;
        }

    }


    public function fetchUserActivity($id = 1){

        $sql = "SELECT * FROM `user_activity` WHERE`user_id` = :uid";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":uid", $id, PDO::PARAM_INT);
        if ($stmt->execute()){

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $time = strtotime(date("Y-m-d h:i:s"));
            $last_activity = strtotime($row['last_activity']);

            if($last_activity > $time){
                $res = array("status" => "1");
            } else {
                $res = array("status" => "0");
            }

            echo json_encode($res);


        }

    }

    public function changePassword($password, $confirm_password, $email){

        if (!$this->checkEmail($email)){
            echo "No user found with this email!";
        }


        $new_hashed_password = password_hash($confirm_password, PASSWORD_ARGON2ID);

        $sql = "UPDATE `users` SET `password` = :password WHERE `user_id` = :uid";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":password", $new_hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(":uid", $user, PDO::PARAM_INT);

        if ($stmt->execute()){
            return true;
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





}