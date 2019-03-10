<?php

namespace app\widgets\inputForm;

use app\base\Widget;
use app\components\CaseTranslator;
use app\widgets\WidgetInterface;
use app\widgets\WidgetNameGetterTrait;
use app\widgets\inputForm\components\inputField\InputField;

class InputForm extends Widget implements WidgetInterface
{
    use WidgetNameGetterTrait;

    /** @var string  */
    private $name;

    /** @var string  */
    private $tittle;

    /** @var string  */
    private $action;

    /** @var string  */
    private $method;

    /** @var bool */
    private $header;

    /** @var InputField[] */
    protected $inputs;

    /** @var bool */
    private $validity;

    /** @var bool  */
    private $submitted = false;

    /**
     * @param array $params
     * @param array $inputFields
     * @throws \ReflectionException
     */
    public function __construct(array $params, array $inputFields) {
        parent::__construct();
        $className = CaseTranslator::toKebab($this->getShortClassName());

        $this->name     = $params['name']   ?? $className;
        $this->tittle   = $params['tittle'] ?? '';
        $this->action   = $params['action'] ?? '';
        $this->method   = $params['method'] ?? 'post';
        $this->header   = $params['header'] ?? true;
        $this->inputs   = $inputFields;
    }

    /**
     * @param Checker $inputChecker
     */
    public function validate(Checker $inputChecker): void
    {
        $this->validity = $inputChecker->check($this->inputs);
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
            foreach ($this->inputs as $field) {
                $field->setValidity(false);
            }
            $lastField = end($this->inputs);
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
        foreach ($this->inputs as $input)
        {
            if ($input->isUnique()){
                $uniqueFields[] = $input;
            }
        }
        return $uniqueFields;
    }

    public function render(array $params = []): void
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
            if (!isset($this->inputs[$name])) {
                continue ;
            }
            $this->inputs[$name]->setValue($value);
            if (($auxSource = $this->inputs[$name]->getAuxValue()) !== null)
            {
                $auxValue = $this->inputs[$auxSource]->getValue();
                $this->inputs[$name]->setAuxValue($auxValue);
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
    public function getInputs(): array
    {
        return $this->inputs;
    }

    public function getInputField(string $filedName): InputField
    {
        return $this->inputs[$filedName];
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
        foreach ($this->inputs as $inputField) {
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
            if (key_exists($name, $this->inputs)) {
                $values[$name] = $this->inputs[$name]->getValue();
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
