<?php

namespace app\components;

/**
 * Class CaseTranslator
 * @package app\components
 */
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

    /**
     * @param string $case
     * @param array $strings
     * @return array
     *
     * Converts keys of array to specified case and returns it.
     */
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
     *
     * lowerCamelCase
     */
    static function toCamel(string $str): string
    {
        return lcfirst(self::toCap($str));
    }

    /**
     * @param string $str
     * @return string
     *
     * CapWords
     */
    static function toCap(string $str): string
    {
        return str_replace(['_', '-', ' '], '', ucwords($str, '_- '));
    }

    /**
     * @param string $str
     * @return string
     *
     * snake_case
     */
    static function toSnake(string $str): string
    {
        return strtolower(preg_replace('/(?<=[a-z])(?=[A-Z])|_| |-/', '_', $str));
    }

    /**
     * @param string $str
     * @return string
     *
     * kebab-case
     */
    static function  toKebab(string $str): string
    {
        return strtolower(preg_replace('/(?<=[a-z])(?=[A-Z])|_| |-/', '-', $str));
    }

    /**
     * @param string $str
     * @return string
     *
     * human case
     */
    static function  toHuman(string $str): string
    {
        return strtolower(preg_replace('/(?<=[a-z])(?=[A-Z])|_| |-/', ' ', $str));
    }

}
