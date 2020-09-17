<?php

    namespace Controllers;

use PDO;

class ChatController extends Core\Controller{
      
        public $needlogin = true;
      

        public function index(){

            if(!\Models\User::checkTheLogin()){

                \Models\Redirect::to("authentication/login");
            }

            $this->set([
                'chatId' => 'global'
            ]);

            $this->layout = "chatroom";
            $this->render("index");
           
        }

        public function changeStatus(){
           
            $changeStatus =\Models\User::changeUserStatus($_POST['userStatus'], $_SESSION['id']);
            
            return $changeStatus;
            
        } 
        public function redirectToChat(){
       
            // $_SESSION['userChatId'] = $_POST['userChatId'];
            // var_dump($_SESSION['userChatId']);
            // exit();
            \Models\Redirect::to("room/roomIndex");
       }
      

        // public function room()
        // {
        //     if(!\Models\User::checkTheLogin()){

        //         \Models\Redirect::to("authentication/login");
        //     }

        //     $this->set([

        //         'chatId' => $_POST['userChatId'],
          
        //     ]);

        //     $this->layout = false;
        //     $this->render("room");

        // }

        public function onlineUsersStatus(){

            $onlineUsers = \Models\User::getOnlineUsers($_SESSION['id']);
            if(sizeof($onlineUsers) == 0){
                echo false;
                exit();
            }

            $this->set([
                'onlineUsers' => $onlineUsers
            ]);
            
            $this->layout = false;

            $this->render("getUsers");
        }

        public function sendLineToDb(){

            if($_POST['action'] == "sendLineToDb"){

                $result = \Models\Messages::setLines($_SESSION['username'], $_POST['sendText']);
                
                echo $result;
            }
        }

      
        public function checkNewMsg(){

            $lastMessageID = filter_var($_POST['lastMessageId'], FILTER_SANITIZE_NUMBER_INT);
            if (empty($lastMessageID)) $lastMessageID = 0;

            $lastMessage = \Models\Messages::getPublicLastMessage($lastMessageID);
         
                if (!$lastMessage) {
                    echo json_encode([
                        'status' => false
                    ]);
                    exit;
                }

                $this->set([
                    'lastMessage' => $lastMessage
                ]);
                
                $this->layout = false;
                
                ob_start();
                $this->render("newPbMessages");
                $msgs = ob_get_clean(); 
           
                echo json_encode([
                    'status' => true,
                    'msgs' => $msgs,
                    'lastId' => end($lastMessage)['publicId']
                ]);
        }

        // public function getAllRoomMessages(){
        //     $username = \Models\User::getUsername($_POST['chaUserId']);
        //     $usersAllMessages = \Models\Messages::roomMessages($_POST['chaUserId'], $_SESSION['id']);
        //     $this->set([
        //         'usersAllMessages' => $usersAllMessages,
        //         'username' => $username  
        //     ]);
        //     $this->layout = false;
        //     $this->render("roomMessages");
        // }
         
        // public function getPrivateMsgs(){

        //     $lastMsgRoomId = filter_var($_POST['lastMsgRoomId'], FILTER_SANITIZE_NUMBER_INT);
        //     if (empty($lastMsgRoomId)) $lastMsgRoomId = 0;

        //     $lastPrivateMessage = \Models\Messages::roomMessages($_POST['chatUserId'],$_SESSION['id'],$lastMsgRoomId);
         
        //         if (!$lastPrivateMessage) {
        //             echo json_encode([
        //                 'status' => false
        //             ]);
        //             exit;
        //         }

        //         $this->set([
        //             'lastPrivateMessage' => $lastPrivateMessage
        //         ]);
                
        //         $this->layout = false;
                
        //         ob_start();
        //         $this->render("roomMessages");
        //         $msgs = ob_get_clean(); 
           
        //         echo json_encode([
        //             'status' => true,
        //             'msgs' => $msgs,
        //             'lastId' => end($lastPrivateMessage)['privateId']
        //         ]);
        // }
    


     

        public function logoutUser(){

            \Models\Session::userLogout();
        }
    }
?>