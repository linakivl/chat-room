<?php

    namespace Models;

    class Messages{



        public static function setLines($username, $text){

            $sql = "INSERT INTO public_chat (publicUsername,publicText) VALUES ('{$username}', '{$text}')";
            $result = \Models\Db::getInstance()->execute($sql);
            $result = \Models\Db::getInstance()->getLastInsert();
         
            return $result;
        }


        public static function getLines($lastInsertId){
            
            if(!$lastInsertId){
                
                return "No messages yet";
            }
            $sql = "SELECT publicUsername,publicText,publicTimetext FROM public_chat WHERE publicId = $lastInsertId ";
            
            $text = \Models\Db::getInstance()->getResults($sql);
           
            return $text;
        }



    }


?>