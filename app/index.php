<?php

use app\base\Application;
use app\components\Router;

ini_set('display_errors', true);
error_reporting(E_ALL);


define('ROOT', dirname(__FILE__));
define('APP', "app");
define('DS', DIRECTORY_SEPARATOR);

require_once(ROOT . '/components/AutoLoader.php');
require_once(ROOT . '/components/Router.php');


$config = require_once(ROOT . '/config/config.php');
Application::initApplication($config);

//$db = new \app\base\DataBase("users");
//var_dump($db);
//
//$data = $db->selectAllWhere('username', 'Mega_Vasiliy');
//var_dump($data);


$router = new Router();
$router->run();

?>
