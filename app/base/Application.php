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

    public function getShortClassName(): string
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}
