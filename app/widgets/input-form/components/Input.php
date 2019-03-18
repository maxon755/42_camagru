<?php


namespace app\widgets\inputForm\components;


use app\base\Widget;

abstract class Input extends Widget
{
    protected $value;

    /** @var bool  */
    protected $unique;

    /** @var string */
    protected $id;

    public function __construct(array $params = [], bool $async = false)
    {
        parent::__construct($params, $async);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isUnique(): bool
    {
        return (bool)$this->unique;
    }
}
