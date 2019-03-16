<?php

namespace app\base;


use app\widgets\WidgetInterface;
use Exception;

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

    /**
     * @return bool
     */
    public function isAsync(): bool
    {
        return $this->async;
    }

    /**
     * @param WidgetInterface $widget
     * @return string
     */
    public static function getContent(WidgetInterface $widget): string
    {
        ob_start();
        $widget->render();

        return ob_get_clean();
    }

    /**
     * @param array[WidgetInterface] $widgets
     * @return string
     * @throws Exception
     */
    public static function getContentArray(array $widgets): string
    {
        ob_start();
        foreach ($widgets as $widget) {
            $widget->render();
        }

        return ob_get_clean();
    }
}
