<?php

namespace app\components;


use app\base\Application;

class InputForm extends Application
{
    private $formName;
    private $tittle;
    private $action;
    private $inputFields;

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
        $inputChecker->check($this->inputFields);
    }

    public function render(): void
    {
        include(ROOT . '/template/input-form.php');
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
}
