<?php

namespace app\base;

class Controller extends Application
{
    protected function render($renderUnit, $useComponents, array $parameters = [])
    {
        (View::getInstance())->render($renderUnit, $useComponents, $parameters);
    }
}
