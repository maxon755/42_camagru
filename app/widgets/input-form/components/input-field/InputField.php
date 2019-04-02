<?php

namespace app\widgets\inputForm\components\inputField;


use app\components\CaseTranslator;
use app\widgets\inputForm\components\Input;
use app\widgets\WidgetFillPropertiesTrait;
use app\widgets\WidgetInterface;
use app\widgets\WidgetNameGetterTrait;

class InputField extends Input implements WidgetInterface
{
    use WidgetNameGetterTrait;
    use WidgetFillPropertiesTrait;


    /** @var string  */
    private $type;

    /** @var bool  */
    private $required;

    /** @var bool  */
    private $validity = true;

    /** @var string */
    private $message;

    /** @var string  */
    private $placeholder;

    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $params['value']        = trim($params['value'] ?? null);
        $params['placeholder']  = ucfirst(CaseTranslator::toHuman($params['name']));
        if ($this->required) {
            $params['placeholder'] .= ' *';
        }

        parent::__construct($params);
    }

    public function render(array $params = []): void
    {
        include(__DIR__ . DS . 'input-field.php');
    }



    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->validity;
    }

    /**
     * @param bool $validity
     */
    public function setValidity(bool $validity): void
    {
        $this->validity = $validity;
    }

    /**
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }
}
