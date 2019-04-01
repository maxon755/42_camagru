<?php

namespace app\widgets\ribbon;


use app\base\Widget;
use app\widgets\WidgetFillPropertiesTrait;
use app\widgets\WidgetInterface;
use app\widgets\WidgetNameGetterTrait;

class Ribbon extends Widget implements WidgetInterface
{
    use WidgetNameGetterTrait;
    use WidgetFillPropertiesTrait;

    /**
     * @var string
     * url of resource witch provides items for infinite ribbon
     */
    private $url;

    private $offset = 0;

    private $limit = 5;

    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }

    public function render(array $params = []): void
    {
        include (__DIR__ . DS . 'ribbon-layout.php');
    }
}