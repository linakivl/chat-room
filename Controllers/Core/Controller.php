<?php

    namespace Controllers\Core;

    class Controller{

        public $vars = [];
        public $layout =  "default";

        function set($data){

            $this->vars = array_merge($this->vars, $data);

        }

        //import the data and load the layout in Views directory
        function render($filename){
            $classname = get_class($this);
            $classname = str_replace('Controllers\\', '', $classname);
            $classname = str_replace('Controller', '', $classname);
            extract($this->vars);

            ob_start();
            require(ROOT . "Views/" . ucfirst($classname) . '/' . $filename . '.php');
            $content_for_layout = ob_get_clean();

            if($this->layout == false){

                echo $content_for_layout;
                
            }else{
                require(ROOT . "Views/Layouts/" . $this->layout . '.php');
            }
        }
    }
?>