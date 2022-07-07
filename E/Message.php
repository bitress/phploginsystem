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
                LEFT JOIN user_details ON user_details.user_id = messages.sender 
                LEFT JOIN users ON users.user_id = user_details.user_id
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
    public function getUserAllMessages($user) {


        $sql = "SELECT users.user_id, users.username, user_details.*, user_activity.* FROM `users` INNER JOIN `user_details` ON users.user_id = user_details.user_id INNER JOIN user_activity ON user_activity.user_id = users.user_id WHERE NOT users.user_id = :uid ORDER BY users.user_id DESC;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':uid', $user, PDO::PARAM_STR);
        if ($stmt->execute()) {
            // fetch all users data except current user
            if ($stmt->rowCount() > 0) {


                $output = "";

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {





                            $output .= '<a href="#" class="list-group-item list-group-item-action border-0">';
                            $output .= '<div class="badge bg-success float-right"></div>';
                            $output .= '<div class="d-flex align-items-start">';
                            $output .= '<img src="https://bootdey.com/img/Content/avatar/avatar5.png" class="rounded-circle mr-1" alt="" width="40" height="40">';
                            $output .= '<div class="flex-grow-1 ml-3">';
                            $output .= $row['first_name'] . " " . $row['last_name'];
                            if ($this->activity->fetchUserActivity($row['user_id']) === "0"){
                                $output .= '  <div class="small"><span class="fas fa-circle chat-offline"></span> Offline</div>';
                            } else {
                                $output .= '  <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>';
                            }


                            $output .= '   </div>';
                            $output .= '</div>';
                            $output .= '</a>';




                }  // end of while loop ($row)
                echo $output;
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




}