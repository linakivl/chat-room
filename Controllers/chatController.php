<?php

    namespace Controllers;

    class ChatController extends Core\Controller{
      
        public $needlogin = true;

        public function index(){

            $this->render("index");
           
        }
       

    }
?>