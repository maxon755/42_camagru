<?php

namespace app\base;


class Widget extends Application
{
    /** @var View  */
    protected $view;

    /** @var string */
    protected $widgetName;

    /** @var bool */
    protected $async;

    public function __construct(bool $async = false)
    {
        $this->view = View::getInstance();
        $this->widgetName = $this->getShortClassName(static::_getWidgetName());
        $this->async = $async;
    }

    /**
     * @return string
     */
    public function getWidgetName(): string
    {
        return $this->widgetName;
    }

    public function isAsync() {
        return $this->async;
    }
}
