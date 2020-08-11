<?php


    namespace Itrust;

    class User{


        private static $salt = "something";
        public static $signedIn = false;
        private $id, $password;
        public $username, $email, $active;

        public function __construct($id=false){
            
          /*search user in db
            if not throw an exception 
            if exist give the values above
            from query
            
          */ 
        

        }

        public function save(){
           
            /**
             update a user if a id exists
             else create one
             and try and catch within excute the sql and return the last insert 
             */

        }

        public function loginUser(){

            /*
                check and validate username and password ecnrypted
                check if the user exists
                if not exist send the user msg 
                if  exist create a session and a key with id and fname
                and the $salt 
                The end redirect to main page
                and change the active to 1 

            */

        }
        
        public function checkTheLogin(){

            /*
                start new session and check if isset session key id salt 
                and if signedIn = true 
                return  signedIN 

             */

        }

        public function registerUser(){
            

        }

        protected function validateEmail(){

            /**
             *validate email and turn the letters lower 
             */
        }

        protected function passwordEncryption(){

            /**
             password encription  
             
             */


        }


    }



?>