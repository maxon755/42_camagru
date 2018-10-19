<?php

namespace app\components;


use app\base\Application;

class InputForm extends Application
{
    private $formName;
    private $action;
    private $inputFields;

    /**
     * InputForm constructor.
     * @param array $inputFields ['fieldName' => [validation conditions]]
     */
    public function __construct($formName, $action, array $inputFields)
    {
        $this->formName = $formName;
        $this->action = $action;
        $this->inputFields = $inputFields;
    }

    public function validate(Checker $inputChecker)
    {
        $inputChecker->check($this->inputFields);
    }

    public function render()
    {
        include(ROOT . '/template/input-form.php');
    }

    public function setValues(array $values)
    {
        foreach ($values as $name => $value)
        {
            if (isset($this->inputFields[$name]))
            {
                echo $name . '========= ' . $value;
                $this->inputFields[$name]->setValue($value);
            }
        }
    }
}
