<?php


namespace app\models;


use app\widgets\inputForm\components\checkbox\Checkbox;
use app\widgets\inputForm\components\inputField\InputField;
use app\widgets\inputForm\InputChecker;
use app\widgets\inputForm\InputForm;

class Settings extends InputForm
{
    public function __construct(array $formConfig)
    {
        parent::__construct($formConfig);
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
