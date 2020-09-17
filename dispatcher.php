<?php

    class Dispatcher{

        private $request;

        public function dispatch(){

            new \Models\Session();
            $this->request = new Request();
            Router::parse($this->request);
        
            $controller = $this->loadController();

            call_user_func_array([$controller, $this->request->action], $this->request->params);
           
        }

        public function loadController(){

            $name = 'Controllers\\' . $this->request->controller . "Controller";
           
            if (class_exists($name)) {
                $controller = new $name();
            } else {
                \Models\Redirect::to("");
            }
            
            
            return $controller;
            
        }
    }



?>