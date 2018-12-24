<?php

namespace app\controllers;

use app\base\Controller;
use app\components\Debug;
use app\components\inputForm\InputChecker;
use app\components\inputForm\InputField;
use app\components\inputForm\InputForm;
use app\models\LoginForm;
use app\models\Client;

class LoginController extends Controller
{
    private $loginForm;

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
            $_SESSION['username'] = $this->loginForm->getValue('username');
            header('Location: /');
        }
        else {
            $this->renderForm();
        }
    }
}
