<?php

namespace app\models;

use app\widgets\inputForm\InputChecker;
use \app\widgets\inputForm\components\inputField\InputField;
use app\widgets\inputForm\InputForm;


class SignUpForm extends InputForm
{
    public function __construct()
    {
        parent::__construct([
            'tittle' => 'Sign Up',
            'action' => '/sign-up/confirm',
        ], [
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
        $clientModel = new Client();

        $this->setSubmitted(true);
        $this->setFieldsValues($userInput);
        $this->validate(new InputChecker());
        if ($this->isValid()) {
            $this->checkAvailability($clientModel);
        }
        if ($this->isValid()) {
            $userInput = $this->getValues();
            $clientModel->insertToDb($userInput);
        }

        return $this->isValid();
    }
}
