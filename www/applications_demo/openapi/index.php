<?php
if(!extension_loaded('yaf'))die('Not Install Yaf');  
define('APPLICATION_PATH', dirname(dirname(__FILE__)));
define('BOOTSTRAP_PATH', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'BootstrapOpenApi.php');
Yaf\Loader::import(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'Init.php');   
$application = new Yaf\Application(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'openapi.ini');
$application->getDispatcher()->catchException(true); 
$application->getDispatcher()->throwException(false); 
$application->getDispatcher()->setErrorHandler(['Errors','errorHandler']);  
$application->bootstrap()->run();

?>
