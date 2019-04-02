<?php


namespace app\components;


class Header
{
    /**
     * @param string $url
     */
    public static function location(string $url): void
    {
        header('Location: ' . $url);
    }
}