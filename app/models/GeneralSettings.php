<?php

namespace app\models;

use app\widgets\inputForm\components\checkbox\Checkbox;
use app\widgets\inputForm\components\inputField\InputField;

class GeneralSettings extends Settings
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
                'like-notify' => new Checkbox([
                    'name'  => 'like-notify',
                    'label' => 'Like notification',
                ]),
                'comment-notify' => new Checkbox([
                    'name'  => 'comment-notify',
                    'label' => 'Comment notification',
                ]),
            ]
        ]);
    }

    protected function updateData($userInput): bool
    {
        return (new Client())->updateGeneralUserData($userInput);
    }
}
