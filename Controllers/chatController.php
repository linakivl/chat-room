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

             $result = \Models\Messages::setLines($_SESSION['username'], $_POST['sendText']);
                
             return $result;
            
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

        
        public function unOpenedChatsController(){

            $unopendedChats = \Models\Messages::getUnreadMsgs($_SESSION['id']);

            $this->set([
                'users' => $unopendedChats
            ]);
            $this->layout = false;

            ob_start();
                $this->render("appendChats");
                $chats = ob_get_clean(); 

            echo json_encode([
                'status' => true,
                'chats' => $chats
            ]);
        }

        public function logoutUser(){

            \Models\Session::userLogout();
        }
    }
?>