<?php

    namespace Controllers;

 

class AuthenticationController extends Core\Controller{

        public $needlogin = false;

        public function login(){
           
            if(\Models\User::checkTheLogin()){

                \Models\Redirect::to("chat/index");
            }
                  
            $this->render("login");
             
        }

        public function login_check() {
           
          
                $email = filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL);
                $password = filter_var($_POST['userPass'], FILTER_SANITIZE_STRING);
               

                if(!$email){
                    $error =  "Email is not valid";

                    echo json_encode($error, JSON_PRETTY_PRINT);
                    
                    exit();
                }
                if($email && $password){

                    $user = \Models\User::loginUser($email, $password);

                    if(is_string($user)){
                        
                        echo json_encode($user, JSON_PRETTY_PRINT);

                        exit();
                    }
                    else{    
                        echo true;
                    }
                } 
                
            
        }
      
        public function usernameCheck(){
            $userNameSet = $_POST['newUsername'];
            $userId = $_SESSION['id'];
         
            $userNameUpdate = new \Models\User($userId, $userNameSet);
            
            $set = $userNameUpdate->save();
       
            if($set === false){
                $errors = "Username already used";
                echo json_encode($errors, JSON_PRETTY_PRINT);
               
                exit();
            }
            echo json_encode([
                'status' => true
            ]);
                
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

                    exit();
                }
                if($email && $password && $username){

                    $newUser = new \Models\User();
                    $login = $newUser->newUser($username, $email, $password);
                    
                    if(is_string($login)){

                        echo json_encode($login, JSON_PRETTY_PRINT);
    
                        exit();
                    }
            
                    echo json_encode([
                        'status' => true
                    ]);
                    
                }                
       
            }
          
        }
        public function redirectToChat(){

            \Models\Redirect::to("chat/index");
       }


    }
?>