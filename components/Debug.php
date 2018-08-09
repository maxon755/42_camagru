<?php

namespace app\components;

use app\base\Application;

class Debug extends Application
{

    static public  function debugValue($value, $msg = "")
    {
        if (self::$mode != 'debug')
            return ;
        echo '<code>';
        echo '<pre>' . $msg . ': ' . $value . '</pre>';
        echo '</code><br>';
    }

    static public function debugArray(array $arr, $expl = "")
    {
        if (self::$mode != 'dev')
            return ;
        echo '<code>';
        echo $expl . '<br>';
        echo '<pre>' . print_r($arr, true) . '</pre>';
        echo '</code><br>';
    }
}
