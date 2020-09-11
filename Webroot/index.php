
<?php
    define('WEBROOT', str_replace("Webroot/index.php", "", 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']));
    define('ROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_FILENAME"]));
    define('APPROOT', dirname(dirname(__FILE__))); 

    include_once ROOT . "vendor/autoload.php";

    require(ROOT . 'Config/config.php');

    require(ROOT . 'router.php');
    require(ROOT . 'request.php');
    require(ROOT . 'dispatcher.php');

    $dispatch = new Dispatcher();
    $dispatch->dispatch();
    
    
?>