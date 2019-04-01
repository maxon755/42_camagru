<?php


namespace app\widgets\inputForm\components\checkbox;


use app\widgets\inputForm\components\Input;
use app\widgets\WidgetFillPropertiesTrait;
use app\widgets\WidgetInterface;
use app\widgets\WidgetNameGetterTrait;

class Checkbox extends Input implements WidgetInterface
{
    use WidgetNameGetterTrait;
    use WidgetFillPropertiesTrait;

    /** @var string */
    private $label;

    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }

    public function render(array $params = []): void
    {
        include(__DIR__ . DS . 'checkbox-layout.php');
    }

    public function setValue($value): void
    {
        parent::setValue((bool)$value);
    }
}