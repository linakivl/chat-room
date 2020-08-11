/* Get the url requested by user */

<?php

    class Request{

        public $url;

        public function __construct(){

            $this->url = $_SERVER['REQUEST_URI'];
            var_dump($this->url);
            exit();

        }
      

    }

?>