<?php


namespace app\models;


use app\widgets\inputForm\components\checkbox\Checkbox;
use app\widgets\inputForm\components\inputField\InputField;
use app\widgets\inputForm\InputChecker;
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
                'like-notify' => new Checkbox([
                    'name'  => 'like-notify',
                    'label' => 'Like notification',
                ]),
            ]
        ]);
    }

    /**
     * @param array $userInput
     * @return bool
     */
    public function save(array $userInput): bool
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
            $clientModel->updateUserData($userInput);
        }

        return $this->isValid();
    }
}