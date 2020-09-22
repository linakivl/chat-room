<?php

    namespace Models;

    class Session{


        public function __construct(){

            session_status() === PHP_SESSION_ACTIVE ?: session_start();
        }

        public static function userLogout(){

            session_unset();
            session_destroy();
            // \Models\Redirect::to("authentication/authentication");
           
        }
    }
?>