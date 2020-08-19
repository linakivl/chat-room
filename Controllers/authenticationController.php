<?php

    namespace Controllers;

    class AuthenticationController extends Core\Controller{

        public $needlogin = false;

        public function login(){
            $this->render("login");
        }

        public function login_check() {
            if(isset($_POST['userLoginBtn'])){
                
               
                $email = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
                $password = filter_var($_POST['userPass'], FILTER_SANITIZE_STRING);

                $user = \Models\User::loginUser($email, $password);


               
                if($user){
                    \Models\Redirect::to("Views/Chat/global");
                }

                \Models\Redirect::to("authentication/login");

            }
        }
        // public function logout(){
        //     echo "hello";
        //     $session = new \Models\Session();
        //     $session::userLogout();
        // }
          
    }
?>