<?php

    namespace Controllers\Core;

    class Controller{

        public $arrayData = [];
        public $layout =  "default";
        public $needLogin = true;

        public function __construct() {
            if ($this->needLogin) {
                if (!\Models\User::checkTheLogin()) {

                }
            }
        }

        function set($data){

            $this->arrayData = array_merge($this->arrayData, $data);

        }

        //import the data and load the layout in Views directory
        function render($filename){

            $classname = get_class($this);                              //"Controllers\tasksController"
            $classname = str_replace('Controllers\\', '', $classname);  //"tasksController"
            $classname = str_replace('Controller', '', $classname);    //"tasks"
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