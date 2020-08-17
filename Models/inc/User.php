<?php


    namespace Models\inc;

    class User{


        private static $salt = "something";
        public static $signedIn = false;

        private $id, $password;
        public $username, $email, $active;

        public function __construct($id = false){
            
          /*search user in db
            if not throw an exception 
            if exist give the values above
            from query
          */ 
          if($id){

            $sql = "SELECT * FROM users WHERE id = {$id}";
            $userEntity = Db::getInstance()->getResults($sql);

            if(!$userEntity){

                throw new \Exception('Failed to find user');

            }
            $this->id = $id;
            $this->email = $userEntity[0]->email;
            $this->username = $userEntity[0]->username;
          }
        }

        public function save(){
           
            if($this->id){
                $sql = "UPDATE users SET userName = $this->username, userEmail = $this-email, userPassword = $this->password";
                try{
                    Db::getInstance()->execute($sql);
                }catch(\Exception $e){
                    return false;
                }
            }else{
                $sql = "INSERT INTO (userName, userEmail, userPassword) VALUES ('{$this->username}', '{$this->email}', '{$this->password}')";
                try{

                    Db::getInstance()->execute($sql);
                    return Db::getInstance()->getLastInsert();

                }catch(\Exception $e){
                    return false;
                }
            }

        }

        public function loginUser($){

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
        
        public function checkTheLogin($email){

            /*
                start new session and check if isset session key id salt 
                and if signedIn = true 
                return  signedIN 

             */


        }

        public function registerUser(){
            

        }
       

        protected function checkChars($value){

            if(strlen($value) < 4 && !preg_match("/[a-z0-9]+/", $value)){
                return false;
            }
            return true;
        }

        protected function checkUsername($username){

            if(!$this->checkChars($username)){
                return false;
            }
            return true;
        }

        protected function validateEmail($email){

            $valEmail = trim($email);
            
            if(!filter_var(strtolower($valEmail, FILTER_SANITIZE_EMAIL))){
                return false;
            }
            return $valEmail;
        }


        protected function passwordEncryption($pass){

            if(!$this->checkChars($pass)){
                return false;
            }
            $pass = hash("sha512", $pass);
            return $pass;
        }

    


    }



?>