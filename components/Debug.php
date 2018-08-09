<?php

namespace app\components;


class Debug
{
    static public function debugArray(array $arr, $expl = "")
    {
        echo '<code>';
        echo $expl . '<br>';
        echo '<pre>' . print_r($arr, true) . '</pre><br>';
        echo '</code>';
    }
}
