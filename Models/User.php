<?php


    namespace Models;

    class User{

      
        private static $salt = "something";

        public $errors = [];
        private $id, $password;
        public $username, $email;
        public $userLoginId;

        public function __construct($id = false, $username = false){

          if($id){
          
            $sql = "SELECT userName FROM users WHERE userId != '{$id}'";
            $userEntity = \Models\Db::getInstance()->getResults($sql);
           
            foreach($userEntity as $user){
                foreach($user as $name){
                    $string = strcmp($username, $name);
                    if($string == 0){
                        
                        return "false";
                        exit();
                    }
                }
            }
           
            $this->id = $id;
           
            $this->username = $username;
          }
        }

        public function save(){
            
            if($this->id){
                
                //update user
                $sql = "UPDATE users SET userName = '{$this->username}'  WHERE userId = '{$this->id}'";
              
                try{
                    $set = \Models\Db::getInstance()->execute($sql);
                    if($set){
                        $_SESSION['username'] = $this->username;
                           
                        $userActivity = self::changeUserDetails($_SESSION['id']);
                        foreach($userActivity as $details){

                            $_SESSION['loginId'] = $details['loginId'];
                            $_SESSION['timelogin'] = $details['loginUserActivity'];
                        }      
                        $status = 1;
                        self::changeUserStatus($status, $_SESSION['id']);   
                        
                        return true;
                    }
                    
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
         $password =   self::passwordEncryption($pass);
         
            $sql = "SELECT userEmail FROM users WHERE userEmail = '{$email}'";
            $userExist = Db::getInstance()->getResults($sql);
            
           
            if(!$userExist){
               
                $errors = "The User Not Exist";
                return $errors; 
                exit();
               
            }
           
            if($userExist){
                
                $sqlUserValid = "SELECT * FROM users WHERE userEmail = '{$email}' AND  userPassword = '{$password}' LIMIT 1";

               
                $userValid = Db::getInstance()->getResults($sqlUserValid);
           
                if(!$userValid){

                    $errors = "Wrong Password or Email";
                    return $errors; 
                    exit();   

                }

                if($userValid){

                    foreach($userValid as $info){
                              
                        $_SESSION['id'] = $info['userId'];
                        $_SESSION['key'] = md5(self::$salt . $info['userId']);

                     
                    }
                   
                    
                    $errors = [];
                    return true;
                }
               
            }
        }
       
        public static function changeUserStatus($status, $userId){

            $sql= "UPDATE login_details SET  status = '{$status}' WHERE loginUserId ='{$userId}'";
            $userActiveStatus = Db::getInstance()->execute($sql); 
            if($userActiveStatus){
                return true;
            }
        }

        public static function checkTheLogin(){

        
            if(
                isset($_SESSION['id']) 
                && isset($_SESSION['key'])
                && $_SESSION['key'] == md5( self::$salt . $_SESSION['id'] ) && isset($_SESSION['username'])
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
                $errors = "The username field must contain at least 4 characters";
                return $errors; 
                exit();
              
            }
            if(!$pass){
                
                $errors = "The username or password field must contain at least 4 characters";
                return $errors; 
                exit();
            }
    

            $sql = "SELECT userEmail FROM users WHERE userEmail = '{$email}'";
            $existUser = Db::getInstance()->getResults($sql);
            
            if($existUser){

                $errors =  "You already have acount";
                return $errors; 
                exit();
               
            }
            if($username){

                $sql = "SELECT userName FROM users WHERE userName= '{$username}'";
       
                $existUsername = Db::getInstance()->getResults($sql);
    
                if($existUsername){
                   
                    $errors =  "Username already exist";
                    return $errors; 
                    exit();
                }
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
                $status = 1;
                self::changeUserStatus($status, $_SESSION['id']);
                return true;
            }
     
        }

        public static function getOnlineUsers($currentUser){
           
            $sql = "SELECT userId, userName FROM users INNER JOIN login_details on users.userId = login_details.loginUserId
            WHERE login_details.status = 1 AND login_details.loginUserId != '{$currentUser}'";
            $onlineUsers = \Models\Db::getInstance()->getResults($sql);
            
            return $onlineUsers;

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
            $pass = md5($pass);
            return $pass;
        }
    }
?>