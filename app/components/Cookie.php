<?php


namespace app\components;


class Cookie
{
    /**
     * @param string $name
     * @return string|null
     */
    public static function get(string $name): ?string
    {
        return ArrayHelper::get($_COOKIE, $name);
    }

    /**
     * @param string $name
     * @return string|null
     */
    public static function getFromHeader(string $name): ?string
    {
        foreach (headers_list() as $header) {
            if (preg_match("/Set-Cookie:\s${name}=(?<${name}>.+?);/", $header, $matches)) {
                return urldecode($matches[$name]);
            }
        }

        return null;
    }

    /**
     * @param string $name
     * @param string $value
     * @param int $days
     * @param string $path
     * @return bool
     */
    public static function set(string $name, string $value, int $days = 7, string $path = '/'): bool
    {
        return setcookie(
            $name,
            $value,
            time() + (3600 * 24 * $days),
            $path);
    }

    /**
     * @param string $name
     * @return bool
     */
    public static function unset(string $name): bool
    {
        return setcookie(
            $name,
            '',
            time() - 3600,
            '/');
    }
}
