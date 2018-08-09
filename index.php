<?php


ini_set('display_errors', true);
error_reporting(E_ALL);


define('ROOT', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);


require_once(ROOT.'/components/AutoLoader.php');
require_once(ROOT.'/components/Router.php');
require_once(ROOT . '/components/DataBase.php');



$router = new app\components\Router();
$router->run();

?>
