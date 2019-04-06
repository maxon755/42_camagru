<?php

namespace app\base;


class Application
{
    /** @var array */
    protected static $config;

    /** @var string */
    protected static $appName;

    /** @var string */
    protected static $mode;

    /** @var array */
    protected static $viewComponents;

    /* @var \app\base\Auth $auth */
    protected static $auth;

    public static function initApplication(array $config)
    {
        self::$config           = $config;
        self::$appName          = $config['appName'];
        self::$mode             = $config['mode'];

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
