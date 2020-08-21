<?php

    namespace Models;

    class Messages{

        public static function setMessage($text, $type){

            if($type == 'success'){
                
                $_SESSION['successMsg'] = $text;
            }

            if($type == 'error'){
                
                $_SESSION['errorMsg'] = $text;
            }

        }

        public static function getMessage(){
            $msg = null;

            if(isset($_SESSION['successMsg'])){

                $msg = $_SESSION['successMsg'];
                unset($_SESSION['successMsg']);

            }
            if(isset($_SESSION['errorMsg'])){

                $msg = $_SESSION['errorMsg'];
                unset($_SESSION['errorMsg']);
            }

            return $msg;

        }



    }


?>