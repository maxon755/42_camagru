<?php

namespace app\base;

use Exception;

class View extends Application
{
    private static $viewInstance = null;

    private $template = ROOT . '/template/template.php';

    private $viewName;

    private $jsFiles = [];

    private $cssFiles = [];

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
     * @return array
     */
    private function getViewFiles(): array
    {
        $pattern = $this->getViewPath() . $this->viewName;

        $style = $pattern . ".css";
        if (!file_exists(ROOT . DS . $style)) {
            $style = false;
        }
        $script = $pattern . ".js";
        if (!file_exists(ROOT . DS . $script)) {
            $script = false;
        }
        return ["markUp"    => ROOT . DS . $pattern . ".php",
            "style"     => $style,
            "script"    => $script];
    }

    /**
     * @return string
     */
    private function getViewPath(): string
    {
        return DS . "views" . DS . $this->viewName . DS ;
    }

    /**
     * @param string $viewName
     * @param bool $useComponents
     * @param array $parameters
     */
    public function render(
        string $viewName,
        bool $useComponents,
        array $parameters = []
    ): void {
        $this->viewName = $viewName;
        $renderUnit = $this->getViewFiles();
        include($this->template);
    }

    /**
     * @param string $fileName
     * @throws Exception
     */
    public function registerJsFile(string $fileName): void
    {
        $this->jsFiles[] = $this->resolveFilePath($fileName, 'js');
    }

    /**
     * @param string $fileName
     * @throws Exception
     */
    public function registerCssFile(string $fileName)
    {
        $this->cssFiles[] = $this->resolveFilePath($fileName, 'css');
    }

    /**
     * @param string $fileName
     * @param string $extension
     * @return string
     * @throws Exception
     */
    private function resolveFilePath(string $fileName, string $extension)
    {
        if (!preg_match('/.+\.\w+$/', $fileName)) {
            $fileName = $fileName . '.' . $extension;
        }
        $pathPatterns = [
            $this->getViewPath() . DS . $fileName,
            $this->getViewPath() . DS . $extension . DS . $fileName,
            $this->getViewPath() . 'assets' . DS . $extension . DS . $fileName,
            $this->getViewPath() . 'assets' . DS . $fileName,
        ];
        foreach ($pathPatterns as $pathPattern) {
            if (file_exists(ROOT . $pathPattern)) {
                return $pathPattern;
            }
        }
        throw new Exception("File ${fileName} does not exists");
    }
}
