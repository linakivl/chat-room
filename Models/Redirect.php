<?php

    namespace Models;

    class Redirect{

        public static function to($path){
            header("Location: " . WEBROOT . $path );
            exit();
        }

    }


?>