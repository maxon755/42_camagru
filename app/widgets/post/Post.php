<?php

namespace app\widgets\post;

use app\base\Application;
use app\base\View;
use app\widgets\Widget;

class Post extends Application implements Widget
{
    /** @var array  */
    private $postData;

    /** @var View  */
    private $view;

    /** @var string */
    private $brokenFilePath;

    public function __construct(array $postData)
    {
        $this->postData = $postData;
        $this->view = View::getInstance();
        $this->brokenFilePath = DS . 'widgets' . DS . 'post' . DS . 'broken-file.png';
    }

    public function getShortClassName(): string
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    public function render(): void
    {
        include(__DIR__ . DS . 'post-layout.php');
    }
}
