<?php


namespace app\models;


use app\widgets\inputForm\components\inputField\InputField;

class PasswordSettings extends Settings
{
    public function __construct()
    {
        parent::__construct([
            'tittle' => 'Password Settings',
            'action' => '/settings/save',
            'inputs' => [
                'password'  => new InputField([
                    'name'      => 'password',
                    'type'      => 'password',
                    'fillValue' => false,
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
            ]
        ]);
    }
}
