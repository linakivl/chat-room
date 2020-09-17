<?php

    namespace Controllers\Core;

    class Controller{

        public $arrayData = [];
        public $layout = "default";
        public $needlogin = true;

        public function __construct(){

            if($this->needlogin){

                if(!\Models\User::checkTheLogin()){
                    
                    \Models\Redirect::to("authentication/login");

                }

            }
        }

        public function set($data){

            $this->arrayData = array_merge($this->arrayData, $data);
          
        }

        public function render($filename){
     
            $className =  get_class($this); 
            $className = str_replace('Controllers\\' , '' , $className); 
            $className = str_replace('Controller', '', $className); 

            extract($this->arrayData);
            
            ob_start();
            require ROOT . "Views/" . ucfirst($className) . '/' . $filename . '.php';
            $content_for_layout = ob_get_clean();

            if($this->layout == false){

                echo $content_for_layout;

            }else{

                require ROOT . "Views/Layout/" . $this->layout . '.php';
            }       
        }
    }
?>