<?php

namespace app\widgets;

trait WidgetNameGetterTrait
{
    /**
     * @return string
     */
    public static function _getWidgetName(): string
    {
        return self::class;
    }
}
