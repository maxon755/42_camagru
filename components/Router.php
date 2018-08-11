<?php

namespace app\components;

/**
 * Класс Router
 *
 * Анализирует строку запроса.
 * Передает управление необходимому контроллеру
 */
class Router
{
    /**
     * Массив шаблонов путей приложения.
     *
     * Содержится в файле /config/routes.php
     *
     * @var mixed
     */
	private $routes;

    /**
     * Содержит целевое пространство имен для формирования
     * полного имени класса.
     *
     * @var string
     */
	private $targetNameSpace = '\app\controllers\\';

	public function __construct()
	{
		$routesPath = ROOT . '/config/routes.php';
		$this->routes = include($routesPath);
	}

    /**
     * Возвращет строку запроса
     *
     * @return string
     */
	private function getURI()
    {
        return trim($_SERVER['REQUEST_URI'], '/');
	}

    /**
     * @param $segments
     * @return string
     */
	private function getControllerName(&$segments)
    {
        $controllerName = array_shift($segments) . 'Controller';
//        $controllerName = ucfirst($controllerName);

        return $controllerName;
    }

    /**
     * @param $segments
     * @return string
     */
    public function getActionName(&$segments)
    {
        $actionName = array_shift($segments);
        $actionName = ucwords($actionName, "-");
        $actionName = str_replace("-", "", $actionName);
        $actionName = 'action' . $actionName;
        return  $actionName;
    }

    /**
     * Возвращет полное имя класса.
     *
     * Полное имя = name space + class name
     *
     * @return string
     */
    private function  getFullClassName($controllerName)
    {
        return sprintf( $this->targetNameSpace . '%s', $controllerName);
    }

    /**
     * Запускает приложение перенаправляя запрос к необходимому контроллеру.
     *
     * Сопоставляет строку запроса uri с элементами массива routes.
     * При нахождении совпадения формирует имя контроллера и название метода.
     *
     * Файл с контроллером подключается автоматически с помощью автозагрузчика.
     *
     * Создает экземпляр контроллера и передает ему управление.
     *
     * @return void
     */
	public function run()
	{
	    $pageFound = false;
		$uri = $this->getURI();

        Debug::debugValue($uri, "uri");

		if (is_null($uri))
            return ;

		foreach ($this->routes as $uriPattern => $path)
		{
			if (!preg_match("~$uriPattern~", $uri))
			    continue ;
            $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
            $segments = explode('/', $internalRoute);
            $controllerName = $this->getControllerName($segments);
            $actionName = $this->getActionName($segments);
            $controllerName = $this->getFullClassName($controllerName);
            $controllerObject = new $controllerName;

            if (!method_exists($controllerObject, $actionName))
                continue ;

            call_user_func_array(array($controllerObject, $actionName), $segments);
            $pageFound = true;
            break;
		}
		if (!$pageFound)
		    echo '404 page not found';
	}
}
