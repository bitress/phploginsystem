<?php

/***
 * @author Cyanne Justin Vega
 * This class is adapted from another system (FessItUp, removed class), still underconstruction
 *
 */


class Message {

    private Database $db;
    /**
     * @var mixed|null
     */
    private mixed $user;

    private Activity $activity;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->user = Session::getSession('uid');
        $this->activity = new Activity();
    }


    /**
     * Get all messages by sender and receiver id
     * @param int $receiver ID of the receiver (incoming)
     * @param int $sender ID of the sender or me (outgoing)
     * @return array messages
     */
    public function getMessage($receiver, $sender) {

        $sql = "SELECT * FROM messages 
                LEFT JOIN users_details ON users_details.users_id = messages.sender 
                LEFT JOIN users ON users.user_id = users_details.users_id
                    WHERE (sender = :s AND receiver = :r)
                     OR (receiver = :s AND sender = :r)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':s', $sender, PDO::PARAM_INT);
        $stmt->bindParam(':r', $receiver, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $row;
    }

    /**
     * Get all the messages of the user for side bar
     * @param int $user ID of the user (sender), current user
     * @return array all messages
     */
    public function getUserAllMessages($user, $dropdown = true) {


        $sql = "SELECT * FROM users INNER JOIN users_settings ON users.user_id = users_settings.user INNER JOIN users_details ON users_settings.user = users_details.users_id WHERE NOT user_id = :u ORDER BY user_id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':u', $user, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $user_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {

                foreach ($user_data as $row) {

                    $sql2 = "SELECT * FROM messages WHERE (receiver = :m
                     OR sender = :m) AND (sender = :u
                     OR receiver = :u) ORDER BY message_id DESC ";
                    $stmt2 = $this->db->prepare($sql2);
                    $stmt2->bindParam(':u', $user, PDO::PARAM_INT);
                    $stmt2->bindParam(':m', $row['user_id'], PDO::PARAM_INT);
                    $stmt2->execute();
                    $message = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($message as $res) {

                        $you = $user == $res['sender'] ? "You: " : "";

                        //Made this because my knowledge is low yet
                        $users = array('username' => $row['username'],
                            'name' => $row['first_name'] . $row['last_name'],
                            'user_id' => $row['user_id'],
                            'profile_image' => $row['profile_image']);

                        if (!empty($res)) {
                            $mes = array('message_id' => $res['message_id'],
                                'sender' => $res['sender'],
                                'receiver' => $res['receiver'],
                                'message' => $you . $res['message'],
                                'status' => $res['status'],
                                'date_created' => $res['date_created']
                            );
                        } else {
                            $mes = array();
                        }

                        //End of made this


                        if ($dropdown) {
                            return array_merge($users,
                                $mes );
                        } else {
                            return $user_data;
                        }



                    }

                }
            }

        }



    }

    /**
     * Send message and insert to database
     * @param int $receiver id of the receiver
     * @param string $message message to be sent
     * @return boolean TRUE if success, FALSE otherwise
     */
    public function sendMessage($receiver, $message) {

        try {
            //code...

            $encrypted_message = ($message);

            $sql = "INSERT INTO messages (sender, receiver, message) VALUES (:s, :r, :m)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':s', $this->userID, PDO::PARAM_INT);
            $stmt->bindParam(':r', $receiver, PDO::PARAM_INT);
            $stmt->bindParam(':m', $message, PDO::PARAM_STR);
            if ($stmt->execute()) {
                echo 'true';
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function fetchUser(){

        $sql = "SELECT * FROM `user_details` INNER JOIN user_activity ua on user_details.user_id = ua.user_id";
        $stmt = $this->db->query($sql);

            $output = "";

        while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== FALSE){

            $output .= '<tr>';
            $output .= '<th scope="row">'. $row['user_id'] .'</th>';
            $output .= '<td>'. $this->activity->fetchUserActivity($row['user_id'])  .'</td>'  ;
            $output .= '</tr>';
        }

        echo $output;

    }



}