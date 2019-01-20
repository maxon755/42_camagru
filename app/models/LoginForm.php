<?php

namespace app\models;

use app\components\inputForm\InputChecker;
use app\components\inputForm\InputField;
use app\components\inputForm\InputForm;

class LoginForm extends InputForm
{
    public function __construct()
    {
        parent::__construct('login', 'Log In', '/login/confirm', 'post', [
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
        $this->setSubmitted(true);
        $this->setFieldsValues($userInput);
        $this->validate(new InputChecker());
        return $this->isValid() ? $this->checkCredentials(new Client()) : false;
    }
}
