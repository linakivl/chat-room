<?php


    namespace Models;

    class User{

      
        private static $salt = "something";
        public static $active;
        public static $errors = ["The chars must have up 4 letters and have the following [a-z0-9]", 
        "Email is not Valid", "Username Exists"];

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
               
                $sql = "INSERT INTO users (userName, userEmail, userPassword) VALUES ('{$this->username}', '{$this->email}', '{$this->password}')";
              
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
           
            // if(!$email || !$pass){

              
            //     return false;
            // }
            $sql = "SELECT * FROM users WHERE userEmail = '{$email}' AND userPassword = '{$pass}'";
            $userExist = Db::getInstance()->getResults($sql);
           
            if(!$userExist){
                \Models\Messages::setMessage(self::$errors[0], "error", "log");
            
                return false;
            }
            if($userExist){

                foreach($userExist as $info){
                   
                    $_SESSION['id'] = $info['userId'];
                    $_SESSION['username'] = $info['userName'];
                    $_SESSION['key'] = md5(self::$salt . $info['userId']);
                
                }
                return $userExist;
            }
            
        }
         
            
        
        public static function checkTheLogin(){

        
            if(
                isset($_SESSION['id']) 
                && isset($_SESSION['key'])
                && $_SESSION['key'] === md5( self::$salt . $_SESSION['id'])
                ) {
                return true;

            }
            return false;
        }



        public function registerUser($username, $email, $pass){
            
            $username =  htmlspecialchars(self::checkUsername($username));
            $email = lcfirst(htmlspecialchars(self::validateEmail($email)));
            $pass = htmlspecialchars(self::passwordEncryption($pass));
        
            if(!$username){
                \Models\Messages::setMessage(self::$errors[0], "error", "reg");
                return false;
            }
            if(!$email){
                \Models\Messages::setMessage(self::$errors[1], "error", "reg");
                return false;
            }
            if(!$pass){
                  \Models\Messages::setMessage(self::$errors[0], "error", "reg");
                return false;
            }
             

            $sql = "SELECT userEmail FROM users WHERE userEmail = '{$email}'";
            $existUser = Db::getInstance()->getResults($sql);
         
            if($existUser){
                \Models\Messages::setMessage($this->error[0], "error","reg");
               return false;    
            }
            
            try{

                $this->username = $username;
               
                $this->email = $email;
                $this->setPass($pass);
                $id = $this->save();

            }catch(\Exception $e){

                var_dump($e->getMessage());

            }
            

            if($id){
   
                $_SESSION['username'] = $this->username;
                $_SESSION['id'] = $id;
                $_SESSION['key'] = md5( self::$salt . $id);
                
                return true;
            }
            return false;
        }
       
        public function setPass($pass){
        
            $this->password = $pass;

        }

        public static function checkChars($value){

            $value = trim($value);
            if(empty($value) || strlen($value) < 4 || !preg_match("/[a-z0-9]+/", $value)){
 
                return false;
            }
            return $value;
        }

        public static function checkUsername($username){

            if(!self::checkChars($username)){

            
                return false;

            }
            $sql = "SELECT userName FROM users WHERE userName= '{$username}'";
       
            $existUsername = Db::getInstance()->getResults($sql);

            if($existUsername){
               
                \Models\Messages::setMessage(self::$errors[2], "error");
                return false;
            }
            
            return $username;
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