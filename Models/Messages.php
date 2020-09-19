<?php

    namespace Models;

    class Messages{


       
        public static function retrieveUsername($chatUserId){

            $sql = "SELECT userName FROM users WHERE userId = $chatUserId";
            $result = \Models\Db::getInstance()->getResults($sql);
          
            return $result;

        }


        public static function setLines($username, $text){

            $sql = "INSERT INTO public_chat (publicUsername,publicText) VALUES ('{$username}', '{$text}')";
            $result = \Models\Db::getInstance()->execute($sql);
         
            return $result;
        }


        public static function getPublicLastMessage($lastInsertId){
            
    
            $sql = "SELECT * FROM public_chat WHERE publicId > $lastInsertId AND date(publicTimetext) = curdate()";

            $text = \Models\Db::getInstance()->getResults($sql);
            $countMessages = count($text);
        
            if($countMessages >= 29){
              
                $deleteQuery = "DELETE FROM public_chat ORDER BY publicId ASC LIMIT 10";
                $deleteResult = \Models\Db::getInstance()->execute($deleteQuery);
                
            }
            return $text;
        }    

        public static function setNewPrivateMsg( $chatUserId, $userid, $text){

            $sql = "INSERT INTO private_chat (toUserId,fromUserId,privateText) VALUES ( $chatUserId, $userid, '{$text}')";
           
            $result = \Models\Db::getInstance()->execute($sql);
            $result = \Models\Db::getInstance()->getLastInsert();
            var_dump($result);
            exit();
            return $result;
        }

        public static function getPrivateLastMessage($chatUserId, $userId, $lastInsertId){

            if($lastInsertId > 0){

                $sql = "SELECT * FROM private_chat WHERE privateId > $lastInsertId";
                $result = \Models\Db::getInstance()->getResults($sql);

                return $result;
                exit();
            }  

            $sql = "SELECT * FROM private_chat WHERE  toUserId = $chatUserId AND
            fromUserId = $userId OR toUserId = $userId AND fromUserId = $chatUserId 
            ORDER BY privateTextTime ASC";
            

           $result = \Models\Db::getInstance()->getResults($sql);
          
           $countMessages = count($result);
        
            if($countMessages >= 100){
              
                $deleteQuery = "DELETE FROM private_chat ORDER BY privateId ASC LIMIT 10";
                $deleteResult = \Models\Db::getInstance()->execute($deleteQuery);
                
            }
           return $result;
        }

        public static function getUnreadMsgs($userId){

            $sql = "SELECT  private_chat.status, private_chat.fromUserId , users.userName 
            FROM private_chat INNER JOIN users ON private_chat.fromUserId = users.userId
            WHERE toUserId = $userId AND status = 1";
            $result = \Models\Db::getInstance()->getResults($sql);
            $ids = [];
            $userNames = [];
            
                foreach($result as $key => $val){

                    array_push($ids, $val['fromUserId']);
                    array_push($userNames, $val['userName']);
                    
                }
                $ids = array_unique($ids);
                $userNames = array_unique($userNames);
                $combine = array_combine($ids, $userNames);
 
                return $combine;
                
        }
        public static function changePrivateMsgStatus($currentUser,$chatId){

            $sql = "UPDATE private_chat SET status = 0  WHERE fromUserId = $chatId AND toUserId = $currentUser";
            $result = \Models\Db::getInstance()->execute($sql);
          
        }
    }
?>