<?php

namespace app\controllers;

use app\base\Controller;
use app\components\inputForm\InputChecker;
use app\components\inputForm\InputField;
use app\components\inputForm\InputForm;
use app\models\User;

class LoginController extends Controller
{
    private $loginForm;

    private const VIEW_NAME = 'login';

    public function __construct()
    {
        $this->loginForm = new InputForm('login', 'Log In', '/login/confirm', 'post', [
            'username'  => new InputField('username', 'text', true, [
                'emptiness',
            ], true),
            'password'  => new InputField('password', 'password', true, [
                'emptiness',
            ]),
        ]);
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

        $this->loginForm->setSubmitted(true);
        $this->loginForm->setFieldsValues($userInput);
        $this->loginForm->validate(new InputChecker());
        $userModel = new User();
        if ($this->loginForm->isValid() &&
            $this->loginForm->checkCredentials($userModel)) {
            $_SESSION['username'] = $this->loginForm->getInputField('username')->getValue();
            header('Location: http://camagru/');
        }
        else {
            $this->renderForm();
        }
    }
}
