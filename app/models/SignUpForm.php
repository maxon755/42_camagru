<?php

namespace app\models;

use app\components\inputForm\InputChecker;
use app\components\inputForm\InputField;
use app\components\inputForm\InputForm;

class SignUpForm extends InputForm
{
    public function __construct()
    {
        parent::__construct('sign_up', 'Sign Up', '/sign-up/confirm', 'post', [
            'username'  => new InputField('username', 'text', true, [
                'emptiness',
                'length',
                'word'
            ], true),
            'first-name'=> new InputField('first-name', 'text', false, [
                'length'
            ]),
            'last-name' => new InputField('last-name', 'text', false, [
                'length'
            ]),
            'email'     => new InputField('email', 'email', true, [
                'emptiness',
                'length',
                'email'
            ], true),
            'password'  => new InputField('password', 'password', true, [
                'emptiness',
                'length',
                'password'
            ]),
            'repeat-password' => new InputField('repeat-password', 'password', true, [
                'emptiness',
                'length',
                'equality'
            ], false, null, $auxValue = 'password')
        ]);
    }

    /**
     * @param array $userInput
     * @return bool
     */
    public function confirm(array $userInput): bool
    {
        $this->setSubmitted(true);
        $this->setFieldsValues($userInput);
        $this->validate(new InputChecker());
        $userModel = new User();
        if ($this->isValid()) {
            $this->checkAvailability($userModel);
        }
        if ($this->isValid()) {
            $userInput = $this->getValues();
            $userModel->insertToDb($userInput);
        }
        return $this->isValid();
    }
}
