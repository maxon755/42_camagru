<?php

namespace app\base;

use app\components\Debug;

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
        $pattern = "/views/{$renderUnit}/{$renderUnit}";
        return ["markUp"    => ROOT . $pattern . ".php",
                "style"     => $pattern . "css",
                "script"    => $pattern . ".js"];
    }

    protected function render($renderUnit, $embedded, array $parameters = [])
    {
        $renderUnit = $this->getViewFiles($renderUnit);
        if (!$embedded)
            include($renderUnit['markUp']);
        else
            include($this->template);
    }
}
