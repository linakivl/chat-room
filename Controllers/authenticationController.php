<?php

    namespace Controllers;

    use Models\Messages;

class AuthenticationController extends Core\Controller{

        public $needlogin = false;

        public function login(){
           
            if(\Models\User::checkTheLogin()){

                \Models\Redirect::to("chat/index");
            }
           
                  $this->render("login");
             
        }

        public function login_check() {
           
            if(isset($_POST['action']) == 'login-task'){
               
                
                $email = filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL);
                $password = filter_var($_POST['userPass'], FILTER_SANITIZE_STRING);
               
                if(!$email){
                    $error =  "Email is not valid";
                    echo json_encode($error, JSON_PRETTY_PRINT);
                    file_put_contents("../erros.json", $error);
                    
                    exit();
                }
                if($email && $password){

                    $user = \Models\User::loginUser($email, $password);
                    if(is_string($user)){

                        echo json_encode($user, JSON_PRETTY_PRINT);
                        file_put_contents("../erros.json", $user);
                        exit();
                    }
                    else{    
                        $emptyjson = [];
                        json_encode($emptyjson);
                        file_put_contents("../erros.json", $emptyjson);
                        echo true;
                    }
                } 
                
            }
        }

        public function chatIndex(){
             \Models\Redirect::to("chat/index");
        }
        public function logoutUser(){
        
            if(isset($_POST['userLogout'])){

                \Models\Session::userLogout();
            }

        }
        public function register(){
            if(\Models\User::checkTheLogin()){

                \Models\Redirect::to("chat/index");
            }


            $this->render("register");

        }
        
        public function registerUser(){
         
        
            if(isset($_POST['action']) == 'register-task'){
               

                $username = filter_var($_POST['userName'], FILTER_SANITIZE_STRING);
                $email = filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL);
                $password = filter_var($_POST['userPass'], FILTER_SANITIZE_STRING);

                if(!$email){
                    $error =  "Email is not valid";
                    echo json_encode($error, JSON_PRETTY_PRINT);
                    file_put_contents("erros.json", $error);
                    
                    exit();
                }
                if($email && $password && $username){

                    $newUser = new \Models\User();
                    $login = $newUser->newUser($username, $email, $password);

                    if(is_string($login)){

                        echo json_encode($login, JSON_PRETTY_PRINT);
                        file_put_contents("erros.json", $login);
                        exit();
                    }
                    else{  
                        $emptyjson = [];
                        json_encode($emptyjson);
                        file_put_contents("erros.json", $emptyjson);  
                        echo true;
                    }
                }                
       
            }
          
        }

    }
?>