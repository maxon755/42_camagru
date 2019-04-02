<?php


namespace app\controllers;

use app\base\Controller;

class ErrorController extends Controller
{
    private const VIEW_NAME = 'error';

    public function action404()
    {
        $this->render($this::VIEW_NAME, true);
    }
}