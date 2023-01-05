<?php

class Activity
{

    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
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


    public function fetchUserActivity($id){

        $sql = "SELECT * FROM `user_activity` WHERE`user_id` = :uid";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":uid", $id, PDO::PARAM_INT);
        if ($stmt->execute()){

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $time = strtotime(date("Y-m-d h:i:s"));
            $last_activity = strtotime($row['last_activity']);

            if($last_activity > $time){
                return "1";
            } else {
                return "0";
            }




        }

    }

}