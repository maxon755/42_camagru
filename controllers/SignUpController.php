<?php

namespace app\controllers;

use app\base\Controller;

class SignUpController extends Controller
{
    public function actionConfirm() {
        echo "method works!";
    }

    public function actionIndex()
    {
        $this->render('sign-up', false);
    }
}
