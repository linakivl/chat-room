<?php

    namespace Models;

    class Messages{



        public static function setLines($username, $text){

            $sql = "INSERT INTO public_chat (publicUsername,publicText) VALUES ('{$username}', '{$text}')";
            $result = \Models\Db::getInstance()->execute($sql);
            $result = \Models\Db::getInstance()->getLastInsert();
            $_SESSION['lastInsertId'] = $result;
            return $result;
        }


        public static function getLines($lastInsertId){

            if(!$lastInsertId){
                
                return "No messages yet";
            }
            // $sql = "SELECT publicUsername,publicText,publicTimetext FROM public_chat WHERE publictId = '{$lastInsertId} > ? 
            // and publicTimetext >= DATE_SUB(NOW(), INTERVAL 1 HOUR)";

            return $lastInsertId;
        }



    }


?>