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
    public function __construct($formName, array $inputFields)
    {
        $this->formName = $formName;
        $this->inputFields = $inputFields;
    }

//    private function buildForm($formFrame)
//    {
//        $inputFields = [];
//        foreach ($formFrame as $filedName => $checks)
//        {
//            $inputFields[] = new InputField($filedName, null, $checks);
//        }
//        return $inputFields;
//    }

    public function render()
    {
        include(ROOT . '/template/input-form.php');
    }
}
