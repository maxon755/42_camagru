<?php

namespace app\base;


class Widget extends Application
{
    /** @var View  */
    protected $view;

    /** @var string */
    public $widgetName;

    public function __construct()
    {
        $this->view = View::getInstance();
        $this->widgetName = $this->getShortClassName(static::getWidgetName());
    }

    /**
     * @return string
     */
    public static function getWidgetName(): string
    {
        return self::class;
    }
}
