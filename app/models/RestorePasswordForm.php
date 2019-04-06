<?php

namespace app\models;

use app\widgets\inputForm\components\inputField\InputField;
use app\widgets\inputForm\InputChecker;
use app\widgets\inputForm\InputForm;

class RestorePasswordForm extends InputForm
{
    public function __construct()
    {
        parent::__construct([
            'tittle' => 'Restore Password',
            'action' => '/restore-password/confirm',
            'inputs' => [
                'username'  => new InputField([
                    'name'      => 'username',
                    'type'      => 'text',
                    'required'  => true,
                    'checks'    => [
                        'emptiness',
                        'length',
                        'word',
                    ]
                ])],
            'description' => 'Specify your username. ' .
                'A new password will be sanded to the related email.',
        ]);
    }

    /**
     * @param array $userInput
     * @return bool
     */
    public function checkUsername(array $userInput): bool
    {
        $this->setSubmitted(true);
        $this->setFieldsValues($userInput);
        $this->validate(new InputChecker());

        if (!$this->isValid()) {
            return false;
        }

        if (!(new Client())->rowExists(['username' => $userInput['username']])) {
            $this->setResult('User with such name does not exist', 'danger');
            return false;
        }

        return true;
    }
}
