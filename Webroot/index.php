
<?php

    define('WEBROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_NAME"]));
    define('ROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_FILENAME"]));

    include_once ROOT . "vendor/autoload.php";

    // require(ROOT . 'Config/core.php');

    require(ROOT . 'router.php');
    require(ROOT . 'request.php');
    require(ROOT . 'dispacher.php');

    $dispatch = new Dispatcher();
    $dispatch->dispatch();
    
    
?>