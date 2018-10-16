<?php

namespace app\components;


class InputField
{
    private $name;
    private $value;
    private $checks;
    private $auxValue;

    /**
     * InputField constructor.
     * @param string $name
     * @param string $value
     * @param array $checks
     * @param string|Null $auxValue
     */
    public function __construct(
        string $name,
        string $value,
        array $checks,
        string $auxValue=Null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->checks = $checks;
        $this->auxValue = $auxValue;
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
    public function getAuxValue()
    {
        return $this->auxValue;
    }

}
