<?php

namespace app\widgets\ribbon;


use app\base\Widget;
use app\widgets\WidgetInterface;
use app\widgets\WidgetNameGetterTrait;

class Ribbon extends Widget implements WidgetInterface
{
    use WidgetNameGetterTrait;

    /**
     * @var string
     * url of resource witch provides items for infinite ribbon
     */
    private $dataSource;

    private $offset;

    private $limit;

    public function __construct(string $dataSource)
    {
        parent::__construct();

        $this->dataSource = $dataSource;
        $this->offset = 0;
        $this->limit = 5;
    }

    public function render(): void
    {
        echo 'ribbon item';
    }
}