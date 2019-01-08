<?php

namespace app\base;

class View extends Application
{
    private static $viewInstance = null;

    private $template = ROOT . '/template/template.php';

    private function __construct()
    {
    }

    /**
     * @return View
     */
    public static function getInstance(): View
    {
        if (!self::$viewInstance) {
            self::$viewInstance = new self();
        }

        return self::$viewInstance;
    }

    /**
     * @param $renderUnit
     * @return array
     */
    private function getViewFiles($renderUnit): array
    {
        $pattern = "/views/{$renderUnit}/{$renderUnit}";
        return ["markUp"    => ROOT . DS . $pattern . ".php",
            "style"     => $pattern . ".css",
            "script"    => $pattern . ".js"];
    }

    /**
     * @param string $renderUnit
     * @param bool $useComponents
     * @param array $parameters
     */
    public function render(
        string $renderUnit,
        bool $useComponents,
        array $parameters = []
    ): void {
        $renderUnit = $this->getViewFiles($renderUnit);
        include($this->template);
    }
}
