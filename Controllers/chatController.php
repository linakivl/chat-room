<?php

    namespace Controllers;

    class ChatController extends Core\Controller{
      
        public $needlogin = true;

        public function index(){

            if(!\Models\User::checkTheLogin()){

                \Models\Redirect::to("authentication/login");
            }

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
            $output = '<ul>';

                foreach($onlineUsers as $row){

                $output .= '
                    <li> '.$row['userName'].' </li>
                ';
            }
                $output .= '</ul>';
                echo $output;
            
        }

        public function logoutUser(){

            \Models\Session::userLogout();
        }
       

    }
?>