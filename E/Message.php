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
        $this->u = new User();
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
                    WHERE (sender = :s AND receiver = :r)
                     OR (receiver = :s AND sender = :r) ORDER BY messages.message_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':s', $sender, PDO::PARAM_INT);
        $stmt->bindParam(':r', $receiver, PDO::PARAM_INT);
        if ($stmt->execute()) {

            if($stmt->rowCount() > 0){
                $output = "";

               while($mess = $stmt->fetch(PDO::FETCH_ASSOC)) {


                    if($mess['sender'] == $this->user){

                        $output .= '<div class="chat-message-right pb-4">';
                        $output .= '<div>';
                        $output .= '<img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">';
                        $output .= '<div class="text-muted small text-nowrap mt-2">2:33 am</div>';
                        $output .= '</div>';
                        $output .= '<div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">';
                        $output .= '     <div class="font-weight-bold mb-1">You</div>';
                        $output .= htmlentities($mess['message']);
                        $output .= '     </div>';
                        $output .= '  </div>';

                    } else {

                        $output .= '     <div class="chat-message-left pb-4">';
                        $output .= '      <div>';
                        $output .= '          <img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">';
                        $output .= '          <div class="text-muted small text-nowrap mt-2">2:34 am</div>';
                        $output .= '     </div>';
                        $output .= '      <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">';
                        $output .= '          <div class="font-weight-bold mb-1">'.  $mess['first_name'] .'</div>';
                        $output .= htmlentities($mess['message']);
                        $output .= '</div>';
                        $output .= '</div>';

                    }



                } // end foreach

                echo ($output);
            } // end rowCount


        }


    }


    public function getChatHeader($id){

        $data = [];

  $row = $this->u->getUserData($id);

          if (empty($row['first_name'])){
              $name = $row['username'];
          } else {
              $name = $row['first_name'] . ' ' . $row['last_name'];

          }

            $data = [
                'user_id' => $row['user_id'],
                'name' => $name
            ];



        echo json_encode($data);

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


                $output = array();
                $output['messages'] = array();

              $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

              foreach ($row as $r) {





                    $sql = "SELECT * FROM `messages` WHERE (sender = :u OR receiver = :u) AND (receiver = :m OR sender = :m) ORDER BY message_id DESC LIMIT 1";
                    $stmt = $this->db->prepare($sql);
                    $stmt->bindParam(":u", $user, PDO::PARAM_INT);
                    $stmt->bindParam(":m", $r['user_id'], PDO::PARAM_INT);
                    $stmt->execute();
                        $res = $stmt->fetch(PDO::FETCH_ASSOC);

                          if (empty($r['first_name'])){
                              $name = $r['username'];
                          } else {
                              $name = $r['first_name'] . ' ' . $r['last_name'];

                          }

                            if($stmt->rowCount() > 0){



                                $data = [
                                    'user_id' => $r['user_id'],
                                    'sender' => $res['sender'],
                                    'receiver' => $res['receiver'],
                                    'message' => $res['message'],
                                    'name' => $name,
                                    'activity' => $this->activity->fetchUserActivity($r['user_id']),
                                    'hasConversation' => true
                                ];

                            } else {

                                $data = [
                                    'user_id' => $r['user_id'],
                                    'sender' => null,
                                    'receiver' => null,
                                    'message' => "You can message ". $r['first_name']. ' ' . $r['last_name'],
                                    'name' => $name,
                                    'activity' => $this->activity->fetchUserActivity($r['user_id']),
                                    'hasConversation' => false
                                ];

                            }



                            array_push($output['messages'], $data);


                }  // end of while loop ($row)

                echo json_encode($output);

            }

        }

//  /**
//     * Get all the messages of the user for side bar
//     * @param int $user ID of the user (sender), current user
//     * @return array all messages
//     */
//    public function getUserAllMessages($user) {
//
//
//        $sql = "SELECT users.user_id, users.username, user_details.*, user_activity.* FROM `users` INNER JOIN `user_details` ON users.user_id = user_details.user_id INNER JOIN user_activity ON user_activity.user_id = users.user_id WHERE NOT users.user_id = :uid ORDER BY users.user_id DESC;";
//        $stmt = $this->db->prepare($sql);
//        $stmt->bindParam(':uid', $user, PDO::PARAM_STR);
//        if ($stmt->execute()) {
//            // fetch all users data except current user
//            if ($stmt->rowCount() > 0) {
//
//
//                $output = "";
//
//                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//
//
//
//
//
//                            $output .= '<a href="#" class="list-group-item list-group-item-action border-0">';
//                            $output .= '<div class="badge bg-success float-right"></div>';
//                            $output .= '<div class="d-flex align-items-start">';
//                            $output .= '<img src="https://bootdey.com/img/Content/avatar/avatar5.png" class="rounded-circle mr-1" alt="" width="40" height="40">';
//                            $output .= '<div class="flex-grow-1 ml-3">';
//                            $output .= $row['first_name'] . " " . $row['last_name'];
//                            if ($this->activity->fetchUserActivity($row['user_id']) === "0"){
//                                $output .= '  <div class="small"><span class="fas fa-circle chat-offline"></span> Offline</div>';
//                            } else {
//                                $output .= '  <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>';
//                            }
//
//
//                            $output .= '   </div>';
//                            $output .= '</div>';
//                            $output .= '</a>';
//
//
//
//
//                }  // end of while loop ($row)
//                echo $output;
//            }
//        }


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
            $stmt->bindParam(':s', $this->user, PDO::PARAM_INT);
            $stmt->bindParam(':r', $receiver, PDO::PARAM_INT);
            $stmt->bindParam(':m', $message, PDO::PARAM_STR);
            if ($stmt->execute()) {

                $data = [
                    'message' => htmlentities($message)
                ];

echo  json_encode($data);

            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }




}