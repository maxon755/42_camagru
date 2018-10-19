<?php

namespace app\components;


class InputField
{
    private $name;
    private $contentType;
    private $required;
    private $value;
    private $auxValue;
    private $checks;
    private $validity;
    private $message;

    /**
     * InputField constructor.
     * @param string $name
     * @param string $contentType
     * @param bool $required
     * @param array $checks
     * @param string|null $value
     * @param string|null $auxValue
     */
    public function __construct(
        string  $name,
        string  $contentType,
        bool    $required,
        array   $checks=[],
        string  $value=null,
        string  $auxValue=null)
    {
        $this->name = $name;
        $this->contentType = $contentType;
        $this->required = $required;
        $this->checks = $checks;
        $this->value = trim($value);
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
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
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
    public function isValid(): bool
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
