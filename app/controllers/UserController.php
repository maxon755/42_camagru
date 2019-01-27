<?php

namespace app\controllers;

use app\base\Controller;


class UserController extends Controller
{
    private const VIEW_NAME = 'user';

    public function actionIndex($username) {
        $this->render($this::VIEW_NAME, true, ['username' => $username]);
    }
}
