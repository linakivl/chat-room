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
            
    
            $sql = "SELECT publicUsername,publicText,publicTimetext FROM public_chat WHERE publicId = $lastInsertId ";
            
            $text = \Models\Db::getInstance()->getResults($sql);
           
            return $text;
        }    

        public static function usersMessages(){

            $sql = "SELECT publicUsername,publicText,publicTimetext FROM  public_chat WHERE date(publicTimetext) = curdate()";
            $messages = \Models\Db::getInstance()->getResults($sql);
            $countMessages = count($messages);
        
            if($countMessages >= 29){
              
                $deleteQuery = "DELETE FROM public_chat ORDER BY publicId ASC LIMIT 10";
                $deleteResult = \Models\Db::getInstance()->execute($deleteQuery);
                
            }

            return $messages;
        }

        public static function roomMessages($chatId){

            ////////////////////////////////////////////////////////////
        }
    }
?>