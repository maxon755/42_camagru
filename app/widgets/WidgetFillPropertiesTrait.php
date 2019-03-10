<?php


namespace app\widgets;


trait WidgetFillPropertiesTrait
{
    /**
     * @param array $params
     */
    public function fillProperties(array $params): void
    {
        foreach (get_class_vars($this->widgetFullName) as $property => $value) {
            if (key_exists($property, $params)) {
                $this->{$property} = $params[$property];
            }
        }
    }
}