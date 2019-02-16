<?php

namespace app\widgets\inputForm;

use app\base\Widget;
use app\widgets\WidgetInterface;

class InputForm extends Widget implements WidgetInterface
{
    /** @var string  */
    private $formName;

    /** @var string  */
    private $tittle;

    /** @var string  */
    private $action;

    /** @var string  */
    private $method;

    /** @var InputField[] */
    protected $inputFields;

    /** @var bool */
    private $validity;

    /** @var bool  */
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
     * @param AvailabilityChecker $checker
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
     * @param CredentialsChecker $checker
     * @return bool
     */
    public function checkCredentials(CredentialsChecker $checker, string $failMessege): bool
    {

        $data = $this->getValues();
        if (!$checker->checkCredentials($data)) {
            $this->setValidity(false);
            foreach ($this->inputFields as $field) {
                $field->setValidity(false);
            }
            $lastField = end($this->inputFields);
            $lastField->setMessage($failMessege);
            return false;
        }
        return true;
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
     * @param string $fieldName
     * @return string
     */
    public function getValue(string $fieldName): string {
        return $this->getInputField($fieldName)->getValue();
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
