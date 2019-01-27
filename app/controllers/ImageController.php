<?php

namespace app\controllers;

use app\base\Controller;


class ImageController extends Controller
{
    private const VIEW_NAME = 'image';

    public function actionIndex() {
        $this->render($this::VIEW_NAME, true);
    }

    public function actionSave() {
        $image = $_REQUEST['image'] ?? null;
        if (!$image) {
            return;
        }

        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
        echo $image;
    }
}