<?php

use app\base\Application;
use app\components\Router;

ini_set('display_errors', true);
error_reporting(E_ALL);


define('ROOT', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);


require_once(ROOT . '/components/AutoLoader.php');
require_once(ROOT . '/components/Router.php');
require_once(ROOT . '/components/DataBase.php');


$config = require_once(ROOT . '/config/config.php');
Application::initApplication($config);

$router = new Router();
$router->run();

?>
