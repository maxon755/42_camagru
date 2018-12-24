<?php

namespace app\controllers;

use app\base\Controller;
use app\components\LogStateHandler;
use app\models\LoginForm;


class LoginController extends Controller
{
    private $loginForm;

    private const VIEW_NAME = 'login';

    use LogStateHandler;

    public function __construct()
    {
        $this->loginForm = new LoginForm();
    }

    public function actionIndex()
	{
        $this->renderForm();
	}

	private function renderForm()
    {
        $this->render(self::VIEW_NAME, true, ['loginForm' => $this->loginForm]);
    }

	public function actionConfirm()
    {
        $userInput = $_POST;

        if ($this->loginForm->isInputCorrect($userInput)) {
            $this->login($this->loginForm->getValue('username'));
            header('Location: /');
        }
        else {
            $this->renderForm();
        }
    }

    public function actionLogout()
    {
        $this->logout();
    }
}
