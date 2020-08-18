<?php

    namespace Models;

    class Session{


        public function __construct(){

            if(session_start() == PHP_SESSION_NONE){

                session_start();
            }
        }

        public function logOut(){

            session_unset();
            session_destroy();

        }
    }
?>