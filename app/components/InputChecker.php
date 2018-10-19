<?php

namespace app\components;


class InputChecker implements Checker
{
    const MAX_LENGTH = 32;

    const EMPTY_FIELD       =   "Empty field.";
    const LENGTH_ERROR      =   "Maximum field length is " . self::MAX_LENGTH . " characters";
    const INCORRECT_WORD    =   "This field should be an alphanumeric ASCII word. " .
                                "Optionally splitted with an underscore.";
    const INCORRECT_EMAIL   =   "Incorect email";

    const PW_MIN_LENGTH     =   8;
    const PW_LENGTH_ERROR   =   "Minimum length is " . self::PW_MIN_LENGTH . " symbols";
    const PW_CAPITAL_ERROR  =   "The password must contain at least one capital letter";
    const PW_DIGIT_ERROR    =   "The password must contain at least one digit";

    /**
     * @param array $inputFields
     */
    public function check(array $inputFields):void
    {
        foreach ($inputFields as $inputField) {
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
            if (!call_user_func(array($this, $method), $inputField))
            {
                break;
            }
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
        if (mb_strlen($inputField->getValue()) > self::MAX_LENGTH)
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

    /**
     * @param InputField $inputField
     * @return bool
     */
    private function checkEmail(InputField $inputField)
    {
        $re = '/^.+@[a-z]+\.[a-z]+/';

        if (!preg_match($re, $inputField->getValue()))
        {
            $inputField->setValidity(false);
            $inputField->setMessage(self::INCORRECT_EMAIL);
            return false;
        }
        return true;
    }

    /**
     * @param InputField $inputField
     * @return bool
     */
    private function checkPassword(InputField $inputField)
    {
        $password = $inputField->getValue();

        if (mb_strlen($password) < self::PW_MIN_LENGTH)
        {
            $inputField->setValidity(false);
            $inputField->setMessage(self::PW_LENGTH_ERROR);
            return false;
        }
        else if (!preg_match('/[А-ЯA-Z]/', $password))
        {
            $inputField->setValidity(false);
            $inputField->setMessage(self::PW_CAPITAL_ERROR);
            return false;
        }
        else if (!preg_match('/[0-9]/', $password))
        {
            $inputField->setValidity(false);
            $inputField->setMessage(self::PW_DIGIT_ERROR);
            return false;
        }
        return true;
    }
}
