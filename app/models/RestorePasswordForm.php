<?php

namespace app\models;

use app\widgets\inputForm\components\inputField\InputField;
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
                        'word'
                    ]
                ])],
            'description' => 'Specify your username. A new password will be sanded to related email.'
        ]);
    }
}
