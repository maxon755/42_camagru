<?php

namespace app\components\inputForm;


use app\base\Application;
use app\components\Checker;

class InputForm extends Application
{
    private $formName;
    private $tittle;
    private $action;
    private $inputFields;
    private $validity;

    /**
     * InputForm constructor.
     * @param string $formName
     * @param string $tittle
     * @param array $inputFields ['fieldName' => [validation conditions]]
     * @param array $inputFields
     */
    public function __construct(string $formName, string $tittle, string $action, array $inputFields)
    {
        $this->formName = $formName;
        $this->tittle = $tittle;
        $this->action = $action;
        $this->inputFields = $inputFields;
    }

    /**
     * @param Checker $inputChecker
     */
    public function validate(Checker $inputChecker): void
    {
        $this->validity = $inputChecker->check($this->inputFields);
    }

    public function render(): void
    {
        include(__DIR__ . DS . 'input-form.php');
    }

    /**
     * @param array $values
     */
    public function setValues(array $values): void
    {
        foreach ($values as $name => $value)
        {
            if (isset($this->inputFields[$name]))
            {
                $this->inputFields[$name]->setValue($value);
                if (($auxSource = $this->inputFields[$name]->getAuxValue()) != null)
                {
                    $auxValue = $this->inputFields[$auxSource]->getValue();
                    $this->inputFields[$name]->setAuxValue($auxValue);
                }
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
}
