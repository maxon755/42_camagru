<?php

use app\base\Application;
use app\components\Router;

ini_set('display_errors', true);
error_reporting(E_ALL);


define('ROOT', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);

require_once(ROOT . '/config/AutoLoader.php');
require_once(ROOT . '/components/Router.php');


$config = require_once(ROOT . '/config/config.php');
Application::initApplication($config);

session_start();

$router = new Router();
$router->run();

?>
