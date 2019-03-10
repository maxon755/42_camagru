<?php

namespace app\widgets;

use app\components\CaseTranslator;

trait WidgetFillPropertiesTrait
{
    /**
     * @param array $params
     */
    public function fillProperties(array $params): void
    {
        $properties = array_keys(get_class_vars($this->widgetFullName));
        foreach ($properties as $property) {
            if (key_exists($property, $params)) {
                $this->{$property} = $params[$property];
                continue;
            }
            $keySnake = CaseTranslator::toSnake($property);
            if (key_exists($keySnake, $params)) {
                $this->{$property} = $params[$keySnake];
            }
        }
    }
}