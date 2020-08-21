<?php

    namespace Controllers;

    use Models\Messages;

class AuthenticationController extends Core\Controller{

        public $needlogin = false;

        public function login(){

            if(\Models\User::checkTheLogin()){

                \Models\Redirect::to("chat/index");
            }

            if ($errorMsg = \Models\Messages::getMessage()) {
               
                $data = [];
                $data['errorMsg'] = $errorMsg;
                $this->set($data);
            }
            $this->render("login");
            
        }

        public function login_check() {
            if(isset($_POST['userLoginBtn'])){
                
               
                $email = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
                $password = filter_var($_POST['userPass'], FILTER_SANITIZE_STRING);

                $user = \Models\User::loginUser($email, $password);
               
                if($user){
                    \Models\Redirect::to("chat/index");
                }
               
    
                \Models\Redirect::to("authentication/login");

            }
        }
        public function logout(){
         
            $session = new \Models\Session();
            $session::userLogout();

        }

        public function registerUser(){

           

            if(isset($_POST['registerBtn'])){

                $username = filter_var($_POST['userName'], FILTER_SANITIZE_STRING);
                $email = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
                $password = filter_var($_POST['userPass'], FILTER_SANITIZE_STRING);
                
                $newUser = new \Models\User();
                $login = $newUser->registerUser($username, $email, $password);
               
                
                if($login){
                    \Models\Redirect::to("chat/index");
                }                
                \Models\Redirect::to("authentication/register");
            }
          
        }
    }
?>