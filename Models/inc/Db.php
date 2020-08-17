<?php

namespace Models\inc;

class Db {

        private $serverName = DB_HOST;
        private $root = DB_USER;
        private $pass = DB_PASS;
        private $databaseName =  DB_NAME;
        private $connection;

        private static $instance = null;

        public static function getInstance(){
            if(!self::$instance){

                self::$instance = new Db();
            }    
            return self::$instance;
        }
        
        public function __construct(){
          
            $this->connection = new \PDO("mysql:host=$this->serverName;dbname=$this->databaseName", $this->root, $this->pass);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        public function execute($sql){
            return $this->connection->exec($sql);
        }

        public function getResults($sql, $single = false){
            
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();            

            $stmt->setFetchMode(\PDO::FETCH_ASSOC);

            $results = $stmt->fetchAll();

            if(!$results){

                return [];
            }
            if($single){
                return $results[0];
            }

            return $results;
        }

        public function getLastInsert(){
            
            return $this->connection->lastInsertId();
            
        }
    }
?>