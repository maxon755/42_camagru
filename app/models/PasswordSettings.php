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
                    'required'  => true,
                    'checks'    => [
                        'emptiness',
                        'password'
                    ]
                ]),
                'repeat-password' => new InputField([
                    'name'      => 'repeat-password',
                    'type'      => 'password',
                    'required'  => true,
                    'auxValue'  => 'password',
                    'save'      => false,
                    'checks'    => [
                        'emptiness',
                        'equality'
                    ]
                ]),
            ]
        ]);
    }

    /**
     * @param array $userInput
     * @return bool
     */
    protected function updateData(array $userInput): bool
    {
        return (new Client())->updateUserPassword($userInput['password']);
    }
}
