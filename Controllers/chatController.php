<?php

    namespace Controllers;

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

        public function room()
        {
            if(!\Models\User::checkTheLogin()){

                \Models\Redirect::to("authentication/login");
            }

            $this->set([
                'chatId' => $_POST['userId']
            ]);

            $this->layout = false;
            $this->render("room");
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

            if($_POST['action'] == "sendLineToDb"){

                $result = \Models\Messages::setLines($_SESSION['username'], $_POST['sendText']);
                
                echo $result;
            }
        }
        
        public function getAllPublicMessages(){

            $allMessages = \Models\Messages::usersMessages();
            $this->set([
                'allMessages' => $allMessages
            ]);
            
            $this->layout = false;

            $this->render("publicMessages");
            
        }     

      
        public function checkNewMsg(){

            $lastMessage = \Models\Messages::getPublicLastMessage($_POST['lastMessageId']); 
            $this->set([
                'lastMessage' => $lastMessage
            ]);
            
            $this->layout = false;

            $this->render("newPbMessages");
        }

        public function getAllRoomMessages(){

            $userAllMessages = \Models\Messages::roomMessages($_POST['chatid'], $_SESSION['id']);
            //merge two users 
        }
         
        public function logoutUser(){

            \Models\Session::userLogout();
        }
    }
?>