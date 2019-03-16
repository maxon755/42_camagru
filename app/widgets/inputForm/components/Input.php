<?php


namespace app\widgets\inputForm\components;


use app\base\Widget;

abstract class Input extends Widget
{
    protected $value;

    public function __construct(array $params = [], bool $async = false)
    {
        parent::__construct($params, $async);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }
}