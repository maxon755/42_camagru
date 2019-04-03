<?php

namespace app\controllers;

use app\base\Controller;
use app\components\Header;
use app\models\LoginForm;


class LoginController extends Controller
{
    /** @var LoginForm  */
    private $loginForm;

    /** @var string  */
    private const VIEW_NAME = 'login';

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
            self::$auth->login($this->loginForm->getValue('username'));
            Header::location('/');
        }
        else {
            $this->renderForm();
        }
    }

    public function actionLogout()
    {
        self::$auth->logout();
        Header::location('/login');
    }
}
