<?php

namespace app\base;


use app\widgets\WidgetNameGetterTrait;

class Widget extends Application
{
    /** @var View  */
    protected $view;

    /** @var string */
    protected $widgetName;

    /** @var string */
    protected $widgetFullName;

    /** @var bool */
    protected $async;

    /** @var array */
    protected $properties;

    public function __construct(array $params = [], bool $async = false)
    {
        $this->view = View::getInstance();
        $this->widgetFullName = static::_getWidgetName();
        $this->widgetName = $this->getShortClassName($this->widgetFullName);

        $this->properties = get_class_vars($this->widgetFullName);
        $this->async = $async;
        if (!empty($params)) {
            static::fillProperties($params);
        }
    }

    /**
     * @return string
     */
    public function getWidgetName(): string
    {
        return $this->widgetName;
    }

    public function isAsync()
    {
        return $this->async;
    }


}
