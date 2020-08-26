<?php


    namespace Models;

    class User{

      
        private static $salt = "something";
        public static $active;

        private $id, $password;
        public $username, $email;
        public $userLoginId;

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
                //update user
                $sql = "UPDATE users SET userName = $this->username, userEmail = $this-email, userPassword = $this->password WHERE userId = $this->id";
                try{
                    Db::getInstance()->execute($sql);
                }catch(\Exception $e){
                    return false;
                }
                
            }else{
               //create user
                $sql = "INSERT INTO users (userName, userEmail, userPassword) VALUES ('{$this->username}', '{$this->email}', '{$this->password}')";
              
                try{

                    Db::getInstance()->execute($sql);

                    return Db::getInstance()->getLastInsert();
                    
                }catch(\Exception $e){
                    return false;
                }

            }

        }
        public static function changeUserDetails($userId){
          
            $loginDetailsSql = "SELECT * FROM login_details WHERE loginUserId = '{$userId}' ";
            
            $loginDetails = Db::getInstance()->getResults($loginDetailsSql);
          
            if(!$loginDetails){

                $sql = "INSERT INTO login_details (loginUserId) VALUES ('$userId')";
                $result = Db::getInstance()->execute($sql);
                $userLoginId = Db::getInstance()->getLastInsert();
              
                return $userLoginId;
              
            }else{
                //Update the same user login time 
                $sql = "UPDATE login_details SET  loginUserActivity = NOW() WHERE loginUserId = $userId";
                $result =  Db::getInstance()->execute($sql);
                  
                if($result){
                    
                    $updateDetails = Db::getInstance()->getResults($loginDetailsSql);
                    return $updateDetails;

                }
            }

        }


        public static function loginUser($email, $pass){
           
            
         $email = self::validateEmail($email);
         $password =  crypt('somethingforpassword', $pass);
    
            $sql = "SELECT userEmail FROM users WHERE userEmail = '{$email}'";
            $userExist = Db::getInstance()->getResults($sql);
            
           
            if(!$userExist){
               
                return "noexist"; 
               
            }
           
            if($userExist){
                
                $sqlUserValid = "SELECT * FROM users WHERE userEmail = '{$email}' AND  userPassword = '{$password}' ";
                $userValid = Db::getInstance()->getResults($sqlUserValid);
                
                if(!$userValid){
                   
                    return "wrong";   
                }

                if($userValid){

                 
                    foreach($userValid as $info){
                              
                        $_SESSION['id'] = $info['userId'];
                        $_SESSION['username'] = $info['userName'];
                        $_SESSION['key'] = md5(self::$salt . $info['userId']);
                        $userActivity = self::changeUserDetails($_SESSION['id']);
                        foreach($userActivity as $details){

                            $_SESSION['loginId'] = $details['loginId'];
                            $_SESSION['timelogin'] = $details['loginUserActivity'];

                        }
                                              
                    }
                   
                    return $userValid;

                }
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



        public function newUser($username, $email, $pass){
          
            $username =  htmlspecialchars(self::checkUsername($username));
            $email = lcfirst(htmlspecialchars(self::validateEmail($email)));
            $pass = self::passwordEncryption($pass);
          
            if(!$username){
                return  "username";
                exit();
              
            }
            if(!$pass){
                
                return "pass";
                exit();
            }
    

            $sql = "SELECT userEmail FROM users WHERE userEmail = '{$email}'";
            $existUser = Db::getInstance()->getResults($sql);
            
            if($existUser){

               return "userexist";  
               exit();
               
            }
            
            try{

                $this->username = $username;
                $this->email = $email;
                $this->setPass($pass);
                $id = $this->save();
                if($id){

                    $this->userLoginId = self::changeUserDetails($id);
                   
                }
                

            }catch(\Exception $e){

                var_dump($e->getMessage());

            }
            

            if($id){
                
                $_SESSION['username'] = $this->username;
                $_SESSION['id'] = $id;
                $_SESSION['key'] = md5( self::$salt . $id);
                $_SESSION['loginId'] = $this->userLoginId;
               
                return true;
            }
     
        }
       
        public function setPass($pass){
        
            $this->password = $pass;

        }

        public static function checkChars($value){
            
            $value = trim($value);
            if(strlen($value) < 4){
                
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
               
                return false;
            }
            
            return $username;
        }

        public static function validateEmail($email){

            $valEmail = trim(strtolower($email));
            if(filter_var($valEmail, FILTER_SANITIZE_EMAIL)){
                
            return $valEmail;

        }
    }


        public static function passwordEncryption($pass){
            
            if(!self::checkChars($pass)){
               
                return false;
            }
            $pass = crypt('somethingforpassword', $pass);
            return $pass;
        }
    }
?>