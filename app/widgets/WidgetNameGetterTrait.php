<?php

namespace app\widgets;

trait WidgetNameGetterTrait
{
    /**
     * @return string
     */
    public static function getWidgetName(): string
    {
        return self::class;
    }
}
