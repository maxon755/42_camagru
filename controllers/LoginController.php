<?php

namespace app\controllers;

use app\base\Controller;

class LoginController extends Controller
{
    public function actionIndex()
	{
		$this->render('login', false);
	}
}
