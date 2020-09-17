<?php

    namespace Models;

    class Messages{



        public static function setLines($username, $text){

            $sql = "INSERT INTO public_chat (publicUsername,publicText) VALUES ('{$username}', '{$text}')";
            $result = \Models\Db::getInstance()->execute($sql);
            $result = \Models\Db::getInstance()->getLastInsert();
         
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

        public static function setNewPrivateMsg($userid, $chatUserId , $text){

            $sql = "INSERT INTO private_chat (toUserId,fromUserId,privateText) VALUES ($userid, $chatUserId, '{$text}')";
            $result = \Models\Db::getInstance()->execute($sql);
            $result = \Models\Db::getInstance()->getLastInsert();
            
            return $result;
        }

        public static function roomMessages($chatUserId, $userId, $lastInsertId){

           $sql = "SELECT * FROM private_chat WHERE publicId > $lastInsertId AND toUserId = $chatUserId AND
            fromUserId = $userId OR toUserId = $userId AND fromUserId = $chatUserId 
            ORDER BY privateTextTime DESC";
           $result = \Models\Db::getInstance()->getResults($sql);
           return $result;
        }
    }
?>