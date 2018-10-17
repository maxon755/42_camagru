<?php

namespace app\components;


class InputChecker
{
    const MAX_LENGTH = 32;

    const EMPTY_FIELD =         "Empty field.";
    const LENGTH_ERROR =        "Maximum field length is " . self::MAX_LENGTH . " characters";
    const INCORRECT_WORD =      "This field should be an alphanumeric ASCII word. " .
                                "Optionally splitted with an underscore.";

    private $inputFields;

    /**
     * InputChecker constructor.
     * @param array $inputFields
     */
    public function __construct(array $inputFields)
    {
        $this->inputFields = $inputFields;
    }

    public function check():void
    {
        foreach ($this->inputFields as $inputField) {
            $this->performChecks($inputField);
        }
    }

    /**
     * @param InputField $inputField
     */
    private function performChecks(InputField $inputField): void
    {
        foreach ($inputField->getChecks() as $checkName)
        {
            $method = $this->getCheckMethod($checkName);
            call_user_func(array($this, $method), $inputField);
        }
    }

    /**
     * @param $checkName
     * @return string
     */
    private function getCheckMethod($checkName): string
    {
        return 'check' . ucfirst($checkName);
    }

    /**
     * @param InputField $inputField
     * @return bool
     */
    private function checkEmptiness(InputField $inputField): bool
    {
        if (empty($inputField->getValue()))
        {
            $inputField->setValidity(false);
            $inputField->setMessage(self::EMPTY_FIELD);
            return false;
        }
        return true;
    }

    /**
     * @param InputField $inputField
     * @return bool
     */
    private function checkLength(InputField $inputField): bool
    {
        if (strlen($inputField->getValue()) > self::MAX_LENGTH)
        {
            $inputField->setValidity(false);
            $inputField->setMessage(self::LENGTH_ERROR);
            return false;
        }
        return true;
    }

    /**
     * @param InputField $inputField
     * @return bool
     */
    private function checkWord(InputField $inputField): bool
    {
        $re = '/^\w+$/';

        if (!preg_match($re, $inputField->getValue()))
        {
            $inputField->setValidity(false);
            $inputField->setMessage(self::INCORRECT_WORD);
            return false;
        }
        return true;
    }
}
