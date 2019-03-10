<?php

namespace app\models;

use app\widgets\inputForm\InputChecker;
use app\widgets\inputForm\components\inputField\InputField;
use app\widgets\inputForm\InputForm;

class LoginForm extends InputForm
{
    public function __construct()
    {
        parent::__construct([
            'tittle'    => 'Log In',
            'action'    => '/login/confirm',
        ], [
            'username'  => new InputField('username', 'text', true, [
                'emptiness',
            ], true),
            'password'  => new InputField('password', 'password', true, [
                'emptiness',
            ]),
        ]);
    }

    /**
     * @param array $userInput
     * @return bool
     */
    public function isInputCorrect(array $userInput): bool
    {
        $failMessage = "Incorrect username/password or account wasn't activated";
        $this->setSubmitted(true);
        $this->setFieldsValues($userInput);
        $this->validate(new InputChecker());

        return $this->isValid()
            ? $this->checkCredentials(new Client(), $failMessage)
            : false;
    }
}
