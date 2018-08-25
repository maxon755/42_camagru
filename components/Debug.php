<?php

namespace app\components;

use app\base\Application;

class Debug extends Application
{

    private static function debugMode()
    {
        return self::$mode == 'debug';
    }

    static public function debugValue($value, $msg = "")
    {
        if (!self::debugMode())
            return ;
        echo '<code>';
        if ($msg)
            echo '<pre>' . $msg . ': ' . $value . '</pre>';
        else
            echo '<pre>' . $value . '</pre>';
        echo '</code><br>';
    }

    static public function debugArray($arr, $expl = "", $forceOutput)
    {
        if (!self::debugMode() && !$forceOutput)
            return ;
        echo '<code>';
        echo $expl . '<br>';
        echo '<pre>' . print_r($arr, true) . '</pre>';
        echo '</code><br>';
    }
}
