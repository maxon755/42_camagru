<?php

namespace app\components\inputForm;


use app\base\Application;

class InputForm extends Application
{
    private $formName;
    private $tittle;
    private $action;
    private $method;
    private $inputFields;
    private $validity;
    private $submitted = false;

    /**
     * InputForm constructor.
     * @param string $formName
     * @param string $tittle
     * @param array $inputFields ['fieldName' => [validation conditions]]
     * @param array $inputFields
     */
    public function __construct(
        string $formName,
        string $tittle,
        string $action,
        string $method,
        array $inputFields)
    {
        $this->formName = $formName;
        $this->tittle = $tittle;
        $this->action = $action;
        $this->method = $method;
        $this->inputFields = $inputFields;
    }

    /**
     * @param Checker $inputChecker
     */
    public function validate(Checker $inputChecker): void
    {
        $this->validity = $inputChecker->check($this->inputFields);
    }

    /**
     * @param callable $checkFunction
     */
    public function checkAvailability(AvailabilityChecker $checker): void
    {
        $uniqueFields = $this->getUniqueFields();
        foreach ($uniqueFields as $field) {
            $name = $field->getName();
            $value = $field->getValue();
            if (!$checker->isInputAvailable([$name => $value])) {
                $field->setValidity(false);
                $field->setMessage("The ${name} is unavailable");
                $this->setValidity(false);
            }
        }
    }

    /**
     * @return array
     */
    private function getUniqueFields(): array
    {
        $uniqueFields = [];
        foreach ($this->inputFields as $field)
        {
            if ($field->isUnique()){
                $uniqueFields[] = $field;
            }
        }
        return $uniqueFields;
    }

    public function render(): void
    {
        include(__DIR__ . DS . 'input-form.php');
    }

    /**
     * @param array $values
     */
    public function setFieldsValues(array $values): void
    {
        foreach ($values as $name => $value)
        {
            if (!isset($this->inputFields[$name])) {
                continue ;
            }
            $this->inputFields[$name]->setValue($value);
            if (($auxSource = $this->inputFields[$name]->getAuxValue()) !== null)
            {
                $auxValue = $this->inputFields[$auxSource]->getValue();
                $this->inputFields[$name]->setAuxValue($auxValue);
            }
        }
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->validity;
    }

    /**
     * @param mixed $validity
     */
    public function setValidity($validity): void
    {
        $this->validity = $validity;
    }

    /**
     * @return array
     */
    public function getInputFields(): array
    {
        return $this->inputFields;
    }

    public function getInputField(string $filedName): InputField
    {
        return $this->inputFields[$filedName];
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->inputFields as $inputField) {
            $values[$inputField->getName()] = $inputField->getValue();
        }
        return $values;
    }

    /**
     * @param array $names
     * @return array
     */
    public function getValuesByName(array $names): array
    {
        $values = [];
        foreach ($names as $name) {
            if (key_exists($name, $this->inputFields)) {
                $values[$name] = $this->inputFields[$name]->getValue();
            }
        }
        return $values;
    }

    /**
     * @param bool $submitted
     */
    public function setSubmitted(bool $submitted): void
    {
        $this->submitted = $submitted;
    }
}
