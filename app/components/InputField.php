<?php

namespace app\components;


class InputField
{
    private $name;
    private $value;
    private $auxValue;
    private $checks;
    private $validity;
    private $message;

    /**
     * InputField constructor.
     * @param string $name
     * @param string $value
     * @param array $checks
     * @param string|Null $auxValue
     */
    public function __construct(
        string  $name,
        string  $value=null,
        array   $checks=[],
        string  $auxValue=null)
    {
        $this->name = $name;
        $this->value = trim($value);
        $this->checks = $checks;
        $this->auxValue = $auxValue;
        $this->validity = true;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function getChecks(): array
    {
        return $this->checks;
    }

    /**
     * @return string
     */
    public function getAuxValue(): string
    {
        return $this->auxValue;
    }

    /**
     * @return bool
     */
    public function getValidity(): bool
    {
        return $this->validity;
    }

    /**
     * @param bool $validity
     * @return InputField
     */
    public function setValidity(bool $validity): void
    {
        $this->validity = $validity;
    }

    /**
     * @return string
     */
    public function getMessage():string
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
}
