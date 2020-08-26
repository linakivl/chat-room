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
                    echo "Email is not valid";
                    exit();
                }
               
                $user = \Models\User::loginUser($email, $password);
                
                if(is_string($user)){
                  
                    if(strcmp($user,"noexist") === 0){
                        echo "User Not Exist";
                    }
                    if(strcmp($user,"wrong") === 0){
                        echo "Wrong Email or Password";
                    }
                }
                if(is_array($user)){
                    
                    \Models\Redirect::to("chat/index");
                }
            }
        }
        public function logout(){
         
            $session = new \Models\Session();
            $session::userLogout();

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
                    echo "Email is not valid";
                    exit();
                }
              
               
                $newUser = new \Models\User();
                $login = $newUser->newUser($username, $email, $password);
               
                if(is_string($login)){
                  
                    if(strcmp($login,"username")  === 0 || strcmp($login,"pass") === 0){
                        echo "The username or password field must contain at least 4 characters";
                        
                    }
                    if(strcmp($login,"userexist")  === 0){
                        echo "You already have acount";
                      
                    }
                }
           
                if(is_bool($login)){
                  
                    \Models\Redirect::to("chat/index");

                }               
       
            }
          
        }

    }
?>