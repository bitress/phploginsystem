<?php

class User
{

    /**
     * @var Database
     */
    private Database $db;
    private mixed $user;
    private Login $login;


    public function __construct(){
        $this->db = Database::getInstance();
        $this->user = Session::getSession("uid");
        $this->login = new Login();
        
    }

    /**
     * Get logged in user data
     * @return mixed
     */
    public function getUserDetails(){

        $sql = "SELECT * FROM `users` INNER JOIN `user_details` ON user_details.user_id = users.user_id WHERE users.user_id = :uid";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam("uid", $this->user, PDO::PARAM_INT);
        $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    /***
     * Change profile function
     * @return boolean TRUE if profile edit is good, FALSE OTHERWISE
     */
    public function editProfile(string $first_name, string $last_name, string $birthdate): bool
    {

        if (!$this->login->isLoggedIn()){
            return false;
        }
        $first_name = trim($first_name);
        $last_name = trim($last_name);
        $birthdate = trim($birthdate);

        $sql = "UPDATE `user_details` SET `first_name` = :first_name, `last_name` = :last_name, `birthdate` = :birthdate WHERE user_id = :uid";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":first_name", $first_name, PDO::PARAM_STR);
        $stmt->bindParam(":last_name", $last_name, PDO::PARAM_STR);
        $stmt->bindParam(":birthdate", $birthdate, PDO::PARAM_STR);
        $stmt->bindParam(":uid", $this->user, PDO::PARAM_STR);

        if($stmt->execute()){
            return true;
        }
            return false;
    }

    /**
     * Make changes to user email
     * @param string $email User email
     * @return bool
     */
    public function changeEmail(string $email)
    {

            if (!$this->login->isLoggedIn()){
                return false;

            }

            $email = trim($email);

            $userDetails = $this->getUserDetails();

            if ($email == $userDetails['email']){
                echo "You can't use your current email";
                return false;
            }

            if($this->login->checkEmail($email)){
                echo "Email is already exists";
                return false;
            }

            $sql = "UPDATE `users` SET `email` = :email WHERE `user_id` = :uid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":uid", $this->user, PDO::PARAM_STR);
            if($stmt->execute()){

                return true;

            }

            return false;

        }



    /***
     * Change password function
     * @param $oldPassword string User's password
     * @param $newPassword string User's new password
     * @param $confirmPassword string User's confirmation new password
     * @return boolean TRUE if success, FALSE otherwise
     */
    public function changePassword(string $oldPassword, string $newPassword, string $confirmPassword){

        if (!$this->login->isLoggedIn()){
            return false;
        }

        try {


        $oldPassword = trim($oldPassword);
        $newPassword = trim($newPassword);
        $confirmPassword =  trim($confirmPassword);


        $u = $this->getUserDetails();
        $hashed_password = $u['password'];

        if(password_verify($oldPassword, $hashed_password)){

            $new_hashed_password = password_hash($confirmPassword, PASSWORD_ARGON2ID);

            $sql = "UPDATE `users` SET `password` = :password WHERE `user_id` = :uid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":password", $new_hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(":uid", $this->user, PDO::PARAM_INT);

            if ($stmt->execute()){
                return true;
            }

        } else {
            echo "Old password is incorrect";

        }


        } catch (Exception $e){
            echo "Error: Something happened to our end";
        }

    }

    public function resetPassword($key, $newpassword){


    }

}