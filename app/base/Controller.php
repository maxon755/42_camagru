<?php

namespace app\base;

/**
 * Класс Controller
 *
 * Базовый класс для всех контроллеров в проекте
 */
class Controller extends Application
{
    private $template = ROOT . '/template/template.php';

    private function getViewFiles($renderUnit)
    {
        $pattern = "views/{$renderUnit}/{$renderUnit}";
        return ["markUp"    => ROOT . DS . $pattern . ".php",
                "style"     => APP . DS . $pattern . ".css",
                "script"    => APP . DS . $pattern . ".js"];
    }

    protected function render($renderUnit, $useComponents, array $parameters = [])
    {
        $renderUnit = $this->getViewFiles($renderUnit);
        include($this->template);
    }
}
