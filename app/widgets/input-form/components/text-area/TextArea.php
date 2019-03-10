<?php

namespace app\widgets\inputForm\components\textArea;


use app\base\Widget;
use app\widgets\WidgetFillPropertiesTrait;
use app\widgets\WidgetInterface;
use app\widgets\WidgetNameGetterTrait;

class TextArea extends Widget implements WidgetInterface
{
    use WidgetNameGetterTrait;
    use WidgetFillPropertiesTrait;

    /** @var string  */
    private $name;

    /** @var bool  */
    private $required;

    /** @var string  */
    private $placeholder;

    /** @var int */
    private $rows;

    public function __construct(array $params)
    {
        parent::__construct($params);
    }

    public function render(array $params = []): void
    {
        include(__DIR__ . DS . 'text-area.php');
    }
}