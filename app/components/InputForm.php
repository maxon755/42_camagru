<?php

namespace app\components;


use app\base\Application;

class InputForm extends Application
{
    private $formName;
    private $inputFields;

    /**
     * InputForm constructor.
     * @param array $inputFields ['fieldName' => [validation conditions]]
     */
    public function __construct($formName, array $formFrame)
    {
        $this->formName = $formName;
        $this->inputFields = $this->buildForm($formFrame);
    }

    private function buildForm($formFrame)
    {
        $inputFields = [];
        foreach ($formFrame as $filedName => $checks)
        {
            $inputFields[] = new InputField($filedName, null, $checks);
        }
        return $inputFields;
    }

    public function render()
    {
        include(ROOT . '/template/input-form.php');
    }
}
