<?php

namespace app\widgets\post;

use app\base\Widget;
use app\widgets\WidgetInterface;
use app\widgets\WidgetNameGetterTrait;

class Post extends Widget implements WidgetInterface
{
    use WidgetNameGetterTrait;

    /** @var array  */
    private $postData;

    /** @var string */
    private $brokenFilePath;

    public function __construct(array $postData, bool $async = false)
    {
        parent::__construct($async);
        $this->postData = $postData;
        $this->brokenFilePath = DS . 'widgets' . DS . 'post' . DS . 'broken-file.png';
    }

    public function render(array $params = []): void
    {
        include(__DIR__ . DS . 'post-layout.php');
    }
}
