<?php


    namespace Models;

    class User{

        private static $salt = "something";
        public static $active;

        private $id, $password;
        public $username, $email;

        public function __construct($id = false){

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
                
                $sql = "INSERT INTO (userName, userEmail, userPassword , userStatus) VALUES ('{$this->username}', '{$this->email}', '{$this->password}')";
                try{

                    Db::getInstance()->execute($sql);
                    return Db::getInstance()->getLastInsert();

                }catch(\Exception $e){
                    return false;
                }

            }

        }

        public static function loginUser($email, $pass){

            $email = htmlspecialchars(self::validateEmail($email));
            $pass = htmlspecialchars(self::passwordEncryption($pass));
           

            $sql = "SELECT * FROM users WHERE userEmail = '{$email}' AND userPassword = '{$pass}'";
            $userExist = Db::getInstance()->getResults($sql);
           
            if(!$userExist){
                
                return false;
            }
            if($userExist){

                foreach($userExist as $info){
                   
                    $session = new \Models\Session();
                    $_SESSION['id'] = $info['userId'];
                    $_SESSION['username'] = $info['userName'];
                    $_SESSION['key'] = md5(self::$salt . $info['userId']);
                
                }
                return $userExist;
            }
            
        }
         
            
        
        public static function checkTheLogin(){

            $session = new \Models\Session();
            if(
                isset($_SESSION['id']) 
                && isset($_SESSION['key'])
                && $_SESSION['key'] === md5( self::$salt . $_SESSION['id'])
                ) {

                return true;
            }
            return false;
        }



        public function registerUser(){
            

        }
       

        public static function checkChars($value){

            if(empty($value) || strlen($value) < 4 || !preg_match("/[a-z0-9]+/", $value)){
                return false;
            }
            return true;
        }

        public static function checkUsername($username){

            if(!self::checkChars($username)){
                return false;
            }
            return true;
        }

        public static function validateEmail($email){

            $valEmail = trim(strtolower($email));
            if(!filter_var($valEmail, FILTER_SANITIZE_EMAIL)){

                return false;
            }
            return $valEmail;
        }


        public static function passwordEncryption($pass){

            if(!self::checkChars($pass)){
                return false;
            }
            $pass = hash("sha512", $pass);
            return $pass;
        }
    }
?>