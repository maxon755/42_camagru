<?php

namespace app\widgets\inputForm;

use app\base\Widget;
use app\components\CaseTranslator;
use app\widgets\inputForm\components\Input;
use app\widgets\WidgetFillPropertiesTrait;
use app\widgets\WidgetInterface;
use app\widgets\WidgetNameGetterTrait;
use app\widgets\inputForm\components\inputField\InputField;

class InputForm extends Widget implements WidgetInterface
{
    use WidgetNameGetterTrait;
    use WidgetFillPropertiesTrait;

    /** @var string  */
    private $name;

    /** @var string  */
    private $tittle;

    /** @var string  */
    private $action;

    /** @var string  */
    private $method = 'post';

    /** @var bool */
    private $header = true;

    /** @var Input[] */
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
    public function __construct(array $params) {
        $className = CaseTranslator::toKebab($this->getShortClassName());
        $params['name'] =  $params['name'] ?? $className;
        parent::__construct($params);
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
            $name = CaseTranslator::toKebab($name);
            $field = $this->inputs[$name] ?? null;
            if (!isset($field) || !$field->shouldFeel()) {
                continue ;
            }

            $field->setValue($value);
            if (($auxSource = $field->getAuxValue()) !== null) {
                $auxValue = $this->inputs[$auxSource]->getValue();
                $field->setAuxValue($auxValue);
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
