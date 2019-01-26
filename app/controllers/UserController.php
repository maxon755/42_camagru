<?php

namespace app\controllers;

use app\base\Controller;


class UserController extends Controller
{
    private const VIEW_NAME = 'user';

    public function actionIndex($username) {
        $this->render($this::VIEW_NAME, true, ['username' => $username]);
    }

    public function actionSaveImage() {
        $image = $_REQUEST['image'];
        if (!$image) {
            return;
        }

        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
        echo $image;
    }
}
