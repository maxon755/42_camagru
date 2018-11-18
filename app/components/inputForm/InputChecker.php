<?php

namespace app\components\inputForm;


class InputChecker implements Checker
{
    const MAX_LENGTH = 32;

    const EMPTY_FIELD       =   "Empty field.";
    const LENGTH_ERROR      =   "Maximum field length is " . self::MAX_LENGTH . " characters";
    const INCORRECT_WORD    =   "This field should be an alphanumeric ASCII word. " .
                                "Optionally splitted with an underscore.";
    const INCORRECT_EMAIL   =   "Incorrect email";

    const PW_MIN_LENGTH     =   8;
    const PW_LENGTH_ERROR   =   "Minimum length is " . self::PW_MIN_LENGTH . " symbols";
    const PW_CAPITAL_ERROR  =   "The password must contain at least one capital letter";
    const PW_DIGIT_ERROR    =   "The password must contain at least one digit";

    const DISMATCH_ERROR    =   "The value doesn`t not match the previous one";

    /**
     * @param array $inputFields
     * @return bool
     */
    public function check(array $inputFields):bool
    {
        $validity = true;
        foreach ($inputFields as $inputField) {
            $validity *= $this->performChecks($inputField);
        }
        return $validity;
    }

    /**
     * @param InputField $inputField
     * @return bool
     */
    private function performChecks(InputField $inputField): bool
    {
        foreach ($inputField->getChecks() as $checkName) {
            $method = $this->getCheckMethod($checkName);
            if (!(call_user_func(array($this, $method), $inputField))) {
                return false;
            }
        }
        return true;
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
        if (empty($inputField->getValue())) {
            return $this->setData($inputField, self::EMPTY_FIELD);
        }
        return true;
    }

    /**
     * @param InputField $inputField
     * @return bool
     */
    private function checkLength(InputField $inputField): bool
    {
        if (mb_strlen($inputField->getValue()) > self::MAX_LENGTH) {
            return $this->setData($inputField, self::LENGTH_ERROR);
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

        if (!preg_match($re, $inputField->getValue())) {
            return $this->setData($inputField, self::INCORRECT_WORD);
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

        if (!preg_match($re, $inputField->getValue())) {
            return $this->setData($inputField, self::INCORRECT_EMAIL);
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

        if (mb_strlen($password) < self::PW_MIN_LENGTH) {
            return $this->setData($inputField, self::PW_LENGTH_ERROR);
        }
        else if (!preg_match('/[А-ЯA-Z]/', $password)) {
            return $this->setData($inputField, self::PW_CAPITAL_ERROR);
        }
        else if (!preg_match('/[0-9]/', $password)) {
            return $this->setData($inputField, self::PW_DIGIT_ERROR);
        }
        return true;
    }

    private function checkEquality(InputField $inputField)
    {
        if (strcmp($inputField->getValue(), $inputField->getAuxValue())) {
            return $this->setData($inputField, self::DISMATCH_ERROR);
        }
        return true;
    }

    private function  setData(InputField $inputField, string $message): bool
    {
        $inputField->setValidity(false);
        $inputField->setMessage($message);

        return false;
    }
}
