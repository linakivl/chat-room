<?php

    namespace Controllers;

    use PDO;
    class RoomController extends Core\Controller{

        public $needlogin = true;

        public function privateChat($chatId){

            $username = $this->getRecieverUsername($chatId);

            $this->set([
                'chatId' => $chatId,
                'username' => $username
            ]);

            $this->layout = "room";
            $this->render("roomIndex");

        }

        public function getRecieverUsername($chatId){

            $username = \Models\Messages::retrieveUsername($chatId);
           
            return $username;

        }

        public function savePrivateText(){

            $result = \Models\Messages::setNewPrivateMsg($_SESSION['id'], $_POST['chatRoomId'], $_POST['userText']);

            return $result;
        }

         public function getPrivateMsgs(){

            $lastMsgRoomId = filter_var($_POST['lastMsgRoomId'], FILTER_SANITIZE_NUMBER_INT);
            
            if (empty($lastMsgRoomId)) $lastMsgRoomId = 0;

            $lastPrivateMessage = \Models\Messages::getPrivateLastMessage($_POST['chatUserId'],$_SESSION['id'],$_POST['lastMsgRoomId']);
            
                if (!$lastPrivateMessage) {
                    echo json_encode([
                        'status' => false
                    ]);
                    exit;
                }
               
                $this->set([
                    'lastPrivateMessage' => $lastPrivateMessage
                ]);
              
                $this->layout = false;
                
                ob_start();
                $this->render("roomMessages");
                $messages = ob_get_clean(); 
                
                echo json_encode([
                    'status' => true,
                    'messages' => $messages,
                    'lastId' => end($lastPrivateMessage)['privateId']
                ]);
        }

        public function appendChatsController(){

            $appendChats = \Models\Messages::appendChats($_POST['lastIdMsg']);

        }
    }
?>