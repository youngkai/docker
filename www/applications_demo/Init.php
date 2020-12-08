<?php
/**
 * @name Init
 * @author carlziess
 * @desc 在开发阶段设置E_ALL，并且DEBUG为true
 */
error_reporting(E_ALL); 
//error_reporting(E_ALL^E_NOTICE); 
define('DEBUG', true);
//define('DEBUG', false);
define('MB_STRING',(int)function_exists('mb_get_info'));                             
define('HOST', 'dev.yaf.com');


$configApp = (new \Yaf\Config\Ini(
    APPLICATION_PATH . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'webapi.ini'
))->toArray();