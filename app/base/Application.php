<?php

namespace app\base;


class Application
{
    protected static $config;
    protected static $appName;
    protected static $mode;
    protected static $viewComponents;

    public static function initApplication(array $config)
    {
        self::$config           = $config;
        self::$appName          = $config['appName'];
        self::$mode             = $config['mode'];
        self::$viewComponents   = $config['viewComponents'];
    }

    protected function camelToSnake($camelString)
    {
        $re = '/(?<=[a-z])(?=[A-Z])/';
        $stringParts = preg_split($re, $camelString);
        $snakeString = implode('_', $stringParts);
        $snakeString = strtolower($snakeString);

        return $snakeString;
    }

    protected function arrayCamelToSnake($camelArray)
    {
        $snakeArray = [];

        foreach ($camelArray as $camelString) {
            $snakeArray[] = $this->camelToSnake($camelString);
        }

        return $snakeArray;
    }
}
