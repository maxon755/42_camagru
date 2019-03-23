<?php


namespace app\components;


class ArrayHelper
{
    /**
     * @param array $arr
     * @param $field
     * @return mixed|null
     */
    public static function get(array $arr, $field)
    {
        if (array_key_exists($field, $arr)) {
            return $arr[$field];
        }

        return null;
    }
}