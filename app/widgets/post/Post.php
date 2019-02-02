<?php

namespace app\widgets\post;

use app\base\Application;
use app\widgets\Widget;

class Post extends Application implements Widget
{
    private $postData;

    public function __construct(array $postData)
    {
        $this->postData = $postData;
    }

    public function render(): void
    {
        include(__DIR__ . DS . 'post-layout.php');
    }
}