<?php


namespace app\components;


class Escape
{
    public static function html(string $value): string
    {
        return htmlspecialchars($value);
    }
}