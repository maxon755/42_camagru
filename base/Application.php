<?php
/**
 * Created by PhpStorm.
 * User: maks
 * Date: 09.08.18
 * Time: 15:05
 */

namespace app\base;


class Application
{
    static $config;
    static $mode;
    static $components;

    public static function initApplication(array $config)
    {
        self::$config = $config;
        self::$mode = $config['mode'];
        self::$components = $config['components'];
    }
}
