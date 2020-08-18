<?php

    
    namespace Controllers;

    class tasksController extends Core\Controller {

        public $needLogin = false;

        // public function index(){

        //     //pass the results
        //     $data = [];

        //     $user = new \Models\User(1);

        //     $data['username'] = 'test';

        //     $this->set($data);

        //     $this->render("index");

        // }

        public function login(){

            $username = filter_var($_POST['userName'], FILTER_SANITIZE_EMAIL);
            $password = filter_var($_POST['userPass'], FILTER_SANITIZE_STRING);

            $user = \Models\User::loginUser($username, $password);

            if ($user) {

                header("Location: " . WEBROOT . "chat/global");

            } else {

                $this->render("login");
            }
        }
    }

?>