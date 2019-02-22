<?php

namespace app\widgets\inputForm;


use app\components\CaseTranslator;

class InputField
{
    /** @var string  */
    private $name;

    /** @var string  */
    private $contentType;

    /** @var bool  */
    private $required;

    /** @var string  */
    private $value;

    /** @var bool  */
    private $unique;

    /** @var null|string  */
    private $auxValue;

    /** @var string[]  */
    private $checks;

    /** @var bool  */
    private $validity;

    /** @var string */
    private $message;

    /** @var string  */
    private $placeholder;

    /**
     * InputField constructor.
     * @param string $name
     * @param string $contentType
     * @param bool $required
     * @param array $checks
     * @param bool $unique
     * @param string|null $value
     * @param string|null $auxValue
     */
    public function __construct(
        string  $name,
        string  $contentType,
        bool    $required,
        array   $checks=[],
        bool    $unique=false,
        string  $value=null,
        string  $auxValue=null)
    {
        $this->name = $name;
        $this->contentType = $contentType;
        $this->required = $required;
        $this->unique = $unique;
        $this->checks = $checks;
        $this->value = trim($value);
        $this->auxValue = $auxValue;
        $this->validity = true;
        $this->placeholder = ucfirst(CaseTranslator::toHuman($name));
        if ($this->required) {
            $this->placeholder .= ' *';
        }
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
     * @return null|string
     */
    public function getAuxValue(): ?string
    {
        return $this->auxValue;
    }

    /**
     * @param null|string $auxValue
     */
    public function setAuxValue(?string $auxValue): void
    {
        $this->auxValue = $auxValue;
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

    /**
     * @return bool
     */
    public function isUnique(): bool
    {
        return $this->unique;
    }
}
