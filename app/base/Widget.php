<?php

namespace app\base;


class Widget extends Application
{
    /** @var View  */
    protected $view;

    public function __construct()
    {
        $this->view = View::getInstance();
    }
}