<?php


namespace app\models;

use app\widgets\inputForm\InputChecker;
use app\widgets\inputForm\InputForm;

abstract class Settings extends InputForm
{
    public function __construct(array $formConfig)
    {
        parent::__construct($formConfig);
    }

    /**
     * @param int $userId
     * @param array $userInput
     * @return bool
     */
    public function save(int $userId, array $userInput): bool
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
            $this->updateData($userId, $userInput);
        }

        return $this->isValid();
    }

    /**
     * @param int $userId
     * @param array $userInput
     * @return mixed
     */
    abstract protected function updateData(int $userId, array $userInput);
}
