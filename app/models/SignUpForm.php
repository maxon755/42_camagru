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
            'username'  => new InputField([
                'name'      => 'username',
                'type'      => 'text',
                'required'  => true,
                'unique'    => true,
                'checks'    => [
                    'emptiness',
                    'length',
                    'word'
                ]
            ]),
            'first-name'=> new InputField([
                'name'      => 'first-name',
                'type'      => 'text',
                'checks'    => [
                    'length',
                ]
            ]),
            'last-name' => new InputField([
                'name'      => 'last-name',
                'type'      => 'text',
                'checks'    => [
                    'length',
                ]
            ]),
            'email'     => new InputField([
                'name'      => 'email',
                'type'      => 'email',
                'required'  => true,
                'unique'    => true,
                'checks'    => [
                    'emptiness',
                    'length',
                    'email'
                ]
            ]),
            'password'  => new InputField([
                'name'      => 'password',
                'type'      => 'password',
                'required'  => true,
                'unique'    => true,
                'checks'    => [
                    'emptiness',
                    'length',
                    'password'
                ]
            ]),
            'repeat-password' => new InputField([
                'name'      => 'repeat-password',
                'type'      => 'password',
                'required'  => true,
                'auxValue'  => 'password',
                'checks'    => [
                    'emptiness',
                    'length',
                    'equality'
                ]
            ]),
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
