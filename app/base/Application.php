<?php

namespace app\base;


class Application
{
    protected static $config;
    protected static $appName;
    protected static $mode;
    protected static $viewComponents;

    /* @var \app\base\Auth $auth */
    protected static $auth;

    public static function initApplication(array $config)
    {
        self::$config           = $config;
        self::$appName          = $config['appName'];
        self::$mode             = $config['mode'];
        self::$viewComponents   = $config['viewComponents'];

        self::$auth = new Auth();
    }

    /**
     * @param string|object $class
     * @return string
     * @throws \ReflectionException
     */
    public function getShortClassName($class = null): string
    {

        return (new \ReflectionClass($class ?? $this))->getShortName();
    }
}
