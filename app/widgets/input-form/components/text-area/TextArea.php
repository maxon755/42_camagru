<?php

namespace app\widgets\inputForm\components\textArea;


use app\widgets\inputForm\components\Input;
use app\widgets\WidgetFillPropertiesTrait;
use app\widgets\WidgetInterface;
use app\widgets\WidgetNameGetterTrait;

class TextArea extends Input implements WidgetInterface
{
    use WidgetNameGetterTrait;
    use WidgetFillPropertiesTrait;

    /** @var bool  */
    private $required;

    /** @var string  */
    private $placeholder;

    /** @var int */
    private $rows;

    public function __construct(array $params)
    {
        parent::__construct($params);
        $this->placeholder = 'Write a comment...';
    }

    public function render(array $params = []): void
    {
        include(__DIR__ . DS . 'text-area.php');
    }
}