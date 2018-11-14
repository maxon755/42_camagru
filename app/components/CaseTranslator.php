<?php

namespace app\components;


class CaseTranslator
{
    /**
     * @param string $case ('camel', 'cap', 'snake', 'kebab', 'human')
     * @param array $strings
     * @return array
     */
    static function arrayTo(string $case, array $strings): array
    {
        $method = 'to' . ucfirst($case);
        $res = [];
        foreach ($strings as $str)
        {
            $res[] = call_user_func([self::class, $method], $str);
        }
        return $res;
    }

    static function keysTo(string $case, array $strings): array
    {
        $method = 'to' . ucfirst($case);
        $res = [];
        foreach ($strings as $key => $str)
        {
            $translatedKey = call_user_func([self::class, $method], $key);
            $res[$translatedKey] = $strings[$key];
        }
        return $res;
    }

    /**
     * @param string $str
     * @return string
     */
    static function toCamel(string $str): string
    {
        return lcfirst(self::toCap($str));
    }

    /**
     * @param string $str
     * @return string
     */
    static function toCap(string $str): string
    {
        return str_replace(['_', '-', ' '], '', ucwords($str, '_- '));
    }

    /**
     * @param string $str
     * @return string
     */
    static function toSnake(string $str): string
    {
        return strtolower(preg_replace('/(?<=[a-z])(?=[A-Z])|_| |-/', '_', $str));
    }

    /**
     * @param string $str
     * @return string
     */
    static function  toKebab(string $str): string
    {
        return strtolower(preg_replace('/(?<=[a-z])(?=[A-Z])|_| |-/', '-', $str));
    }

    /**
     * @param string $str
     * @return string
     */
    static function  toHuman(string $str): string
    {
        return strtolower(preg_replace('/(?<=[a-z])(?=[A-Z])|_| |-/', ' ', $str));
    }

}
