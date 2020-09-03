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

        public function sendLineToDb(){

            if($_POST['action'] == "sendLineToDb"){

                $result = \Models\Messages::setLines($_SESSION['username'], $_POST['sendText']);
                
                echo $result;
            }
        }
        
        // public function getLinesFromDb(){

        //     $text = \Models\Messages::getLines($_POST['userId']);
        //     foreach($text as $col){

                
        //     $output = 
        //         "
        //             <span>{$col['publicUsername']}</span>
                

        //             <span>{$col['publicTimetext']}</span>
        //             <p>{$col['publicText']}</p>
                       
        //         ";
        //     }
        //     echo $output;
        // }
            
        public function getAllMessages(){

            $allMessages = \Models\Messages::usersMessages();
            $output = '<div >';

                foreach($allMessages as $row){

                
                $output .= '<p>'.$row['publicText'].' </p>';
                $output .= '<span>'.$row['publicTimetext'].'</span>';
                $output .= '<span> '.$row['publicUsername'].' </span>';
                
            }
            $output .= '</div>';
           echo $output;
        }
         
        public function logoutUser(){

            \Models\Session::userLogout();
        }
       

    }
?>