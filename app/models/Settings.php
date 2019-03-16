<?php


namespace app\models;


use app\widgets\inputForm\components\inputField\InputField;
use app\widgets\inputForm\InputForm;

class Settings extends InputForm
{
    public function __construct()
    {
        parent::__construct([
            'tittle' => 'User Settings',
            'action' => '/settings/save',
            'inputs' => [
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
            ]
        ]);
    }
}